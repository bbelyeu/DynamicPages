<?php
    $custom_views = array();
    $custom_views['options'] = array();
    // check if folder exists in Views
    $path = APP.'View'.DS.'DynamicPages';
    if (file_exists($path)) {
        $files = scandir($path);
        foreach ($files as $file) {
            if (substr($file, -4) === '.ctp') {
                $view = substr($file, 0, -4);
                $custom_views['options'][$view] = $view;
            }
        }
    }
    $custom_views['default'] = $this->data['Page']['custom_view'];
?>
<script type="text/javascript" src="/dynamic_pages/ckeditor/ckeditor.js"></script>
<div class="pages form">
<?php echo $this->Form->create('Page', array('type' => 'file'));?>
	<fieldset>
		<legend><?php echo __('Edit Page'); ?></legend>
	<?php
		echo $this->Form->input('id');
        if (!empty($this->data['Page']['image_id'])):
    ?>
        <div class="clearfix">
            <label>Current Photo</label>
		    <img src="/images/<?php echo h($this->data['Page']['image_id']); ?>" />
        </div>
    <?php else: ?>
        <div class="clearfix">
            <label>No Image Uploaded</label>
        </div>
    <?php
        endif;
        echo $this->Form->input('photo_upload', array(
            'type' => 'file',
            'label' => 'Upload new photo'
        ));
		echo $this->Form->input('title');
		echo $this->Form->input('url');
    ?>
        <div class="clearfix">
    <?php
        echo $this->Form->label('Page.custom_view', 'Select a custom view file');
		echo $this->Form->select('custom_view', $custom_views);
    ?>
        </div>
    <?php
		echo $this->Form->input('copy', array(
            'class' => 'ckeditor'
        ));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Page.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Page.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Pages'), array('action' => 'index'));?></li>
	</ul>
</div>
