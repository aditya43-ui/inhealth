<div class="white-container">
    <legend class="rim2">Tambah <b>Golongan Gaji</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Golongan Gaji Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Golongan Gaji ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //(Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Golongan Gaji', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>