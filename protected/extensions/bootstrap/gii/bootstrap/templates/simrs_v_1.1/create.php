<?php
echo "<?php\n";
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	'Create',
);\n";
?>
?>
<legend class="rim2">Tambah <?php echo $this->modelClass; ?></legend>
<?php echo "<?php \$this->widget('bootstrap.widgets.BootAlert'); ?>\n"; ?>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>

