<?php
App::uses('DynamicPagesAppController', 'DynamicPages.Controller');
/**
 * Pages Controller
 *
 * @property Page $Page
 */
class PagesController extends DynamicPagesAppController
{
    /**
     * Before filter event
     *
     * @link http://book.cakephp.org/2.0/en/controllers.html#Controller::beforeFilter
     * @return null
     */
    public function beforeFilter()
    {
        $this->Auth->allow('view');
        parent::beforeFilter();
    }

    /**
     * View dynamically generated page content
     *
     * @param string $id
     * @return void
     */
    public function view($url)
    {   
        $data = $this->Page->findByUrl($url);
        if (empty($data)) {
            throw new NotFoundException(__('Invalid page'));
        }   

        $this->data = $data;
        $this->set('title_for_layout', $data['Page']['title']);

        if (!empty($data['Page']['custom_view'])) {
            $view = APP.'View'.DS.'DynamicPages'.DS.$data['Page']['custom_view'].'.ctp';
            if (file_exists($view)) {
                $this->render(DS.'DynamicPages'.DS.$data['Page']['custom_view']);
            }
        }
    }

    /**
     * admin_index method
     *
     * @return void
     */
	public function admin_index() 
    {
        $this->paginate = array(
            'order' => array('title' => 'asc'),
        );
		$this->Page->recursive = 0;
		$this->set('pages', $this->paginate());
	}

    /**
     * admin_view method
     *
     * @param string $id
     * @return void
     */
	public function admin_view($id = null) 
    {
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException(__('Invalid page'));
		}
		$this->set('page', $this->Page->read(null, $id));
	}

    /**
     * admin_add method
     *
     * @return void
     */
	public function admin_add() 
    {
		if ($this->request->is('post')) {
            if (App::import('Model', 'MysqlImageStorage.Image')) {
                $this->ImageComponent = $this->Components->load('MysqlImageStorage.Image');
                $this->request->data['Page']['image_id'] = $this->ImageComponent->process($this->request->data['Page']);
            }

			$this->Page->create();
			if ($this->Page->save($this->request->data)) {
				$this->Session->setFlash(__('The page has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The page could not be saved. Please, try again.'));
			}
		}
	}

    /**
     * admin_edit method
     *
     * @param string $id
     * @return void
     */
	public function admin_edit($id = null) 
    {
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException(__('Invalid page'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
            if (!empty($this->request->data['Page']['photo_upload'])) {
                if (App::import('Model', 'MysqlImageStorage.Image')) {
                    $this->ImageComponent = $this->Components->load('MysqlImageStorage.Image');
                    $this->request->data['Page']['image_id'] = $this->ImageComponent->process($this->request->data['Page']);
                }
            }

			if ($this->Page->save($this->request->data)) {
				$this->Session->setFlash(__('The page has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The page could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Page->read(null, $id);
		}
	}

    /**
     * admin_delete method
     *
     * @param string $id
     * @return void
     */
	public function admin_delete($id = null) 
    {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException(__('Invalid page'));
		}
		if ($this->Page->delete()) {
			$this->Session->setFlash(__('Page deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Page was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

}
