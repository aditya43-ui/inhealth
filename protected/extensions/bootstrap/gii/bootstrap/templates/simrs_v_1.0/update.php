
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
	'Update',
);\n";
?>

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' <?php echo $this->modelClass; ?> #'.$model-><?php echo $this->tableSchema->primaryKey; ?>, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' <?php echo $this->modelClass; ?>', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' <?php echo $this->modelClass; ?>', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' <?php echo $this->modelClass; ?>', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' <?php echo $this->modelClass; ?>', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo "<?php echo \$this->renderPartial('_formUpdate',array('model'=>\$model)); ?>"; ?>

<?php echo "<?php \$this->widget('UserTips',array('type'=>'update'));?>" ?>
