<?php
    $custom_views = array();
    // check if folder exists in Views
    $path = APP.'View'.DS.'DynamicPages';
    if (file_exists($path)) {
        $files = scandir($path);
        foreach ($files as $file) {
            if (substr($file, -4) === '.ctp') {
                $view = substr($file, 0, -4);
                $custom_views[$view] = $view;
            }
        }
    }
?>
<script type="text/javascript" src="/dynamic_pages/ckeditor/ckeditor.js"></script>
<div class="pages form">
<?php echo $this->Form->create('Page');?>
	<fieldset>
		<legend><?php echo __('Add Page'); ?></legend>
	<?php
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
		<li><?php echo $this->Html->link(__('List Pages'), array('action' => 'index'));?></li>
	</ul>
</div>
