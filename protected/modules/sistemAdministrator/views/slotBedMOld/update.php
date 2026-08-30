<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">
            <i class="far fa-edit"></i> Ubah <?= ($this->module->id == 'hemodialisa')?'Tempat Tidur (Bed)':'Slot Bed' ?></div>
	</div>
	<div class="panel-body">
<?php
$this->breadcrumbs=array(
	'Slot Bed'=>array('update','id'=>$model->slotbed_id),	
	'Ubah'
);

        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'Update') . ' Slot Bed ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Slot Bed', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Slot Bed', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Slot Bed', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->slotbed_id))) ;
        // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Slot Bed', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_formUpdateV2',array('loadSlot'=>$loadSlot,'model'=>$model)); ?>
<?php //$this->widget('UserTips',array('type'=>'update'));?>
	</div>
</div>