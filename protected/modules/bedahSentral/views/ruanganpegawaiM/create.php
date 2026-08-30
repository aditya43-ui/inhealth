
<?php
$this->breadcrumbs=array(
	'RJRuanganpegawai M'=>array('index'),
	'Create',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Ruangan Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                //array_push($arrMenu,array('label'=>Yii::t('mds','List').' SANapzaM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Ruangan Pegawai ', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model, 'modDetails'=>$modDetails)); ?>
<?php //$this->widget('UserTips',array('type'=>'create'));?>