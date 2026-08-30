<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
<i class="far fa-edit"></i>
            Ubah <b>Kelurahan</b> </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sakelurahan Ms' => array('index'),
            $model->kelurahan_id => array('view', 'id' => $model->kelurahan_id),
            'Update',
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kelurahan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelurahan', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelurahan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kelurahan', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->kelurahan_id))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Kelurahan', 'icon' => 'folder-open', 'url' => array('admin'))) : '';

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model)); ?>
        <?php //$this->widget('UserTips',array('type'=>'update')); 
        ?>
    </div>
</div>