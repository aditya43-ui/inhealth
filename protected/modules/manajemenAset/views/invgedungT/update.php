<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="far fa-edit"></i> Ubah Inventarisasi <b>Gedung dan Bangunan</b></div>
    </div>
    <div class="panel-body">

    <?php
    $this->breadcrumbs=array(
            'Inventarisasi Gedung'=>array('index'),
            $model->invgedung_id=>array('view','id'=>$model->invgedung_id),
            'Ubah',
    );
    $this->widget('bootstrap.widgets.BootAlert');
    //$this->renderPartial('/_dataBarang', array('modBarang' => $modBarang ,));

        $arrMenu = array();
        //                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Inventarisasi Gedung dan Bangunan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvgedungT', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' MAInvgedungT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' MAInvgedungT', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->invgedung_id))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Gedung dan Bangunan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_formUpdate', array('model' => $model, 'data' => $data, 'dataAsalAset' => $dataAsalAset, 'dataLokasi' => $dataLokasi, 'modBarang' => $modBarang)); ?>
        <?php $this->renderPartial('manajemenAset.views._jsFunction', array()); ?>
    </div>
</div>