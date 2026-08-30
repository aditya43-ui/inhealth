<div class="white-container">
    <legend class="rim2">Ubah <b>PTKP</b></legend>
    <?php
    $this->breadcrumbs=array(
            'PTKP Ms'=>array('index'),
            $model->ptkp_id=>array('view','id'=>$model->ptkp_id),
            'Update',
    );

    $arrMenu = array();
    //array_push($arrMenu,array('label'=>Yii::t('mds','Update').' PTKP ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' PTKP ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); 
    //$this->renderPartial('_tabMenu',array());?>

    <?php echo $this->renderPartial($this->path_view. '_formUpdate',array('model'=>$model)); ?>
</div>