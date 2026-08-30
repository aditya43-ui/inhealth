<div class="white-container">
    <legend class="rim2">Tambah <b>Profile Rumah Sakit</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Saprofil Rumah Sakit Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Profile Rumah Sakit ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Profile RS', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Profile Rumah Sakit ', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model,'modMisiRS'=>$modMisiRS, 'modProfilPict'=>$modProfilPict)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</div>