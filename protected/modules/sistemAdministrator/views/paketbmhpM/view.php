<?php
$this->breadcrumbs = array(
    'Paket BMHP' => array('admin'),
    'Lihat'
)
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Paket BMHP</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Paket BMHP' => Yii::app()->request->getUrlReferrer(),
            $model->paketbmhp_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Paket BMHP #'.$model->paketbmhp_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAPaketbmhpM', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAPaketbmhpM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SAPaketbmhpM', 'icon'=>'pencil','url'=>array('update','id'=>$model->paketbmhp_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SAPaketbmhpM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->paketbmhp_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Paket BMHP', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'tipepaket.tipepaket_nama',
                'kelompokumur.kelompokumur_nama',
                'daftartindakan.daftartindakan_nama',
                'obatalkes.obatalkes_kode',
                'obatalkes.obatalkes_nama',
                'satuankecil.satuankecil_nama',
                array(
                    'name' => 'qtypemakaian',
                    'value' => MyFormatter::formatNumberForPrint($model->qtypemakaian),
                ),
                array(
                    'name' => 'hargapemakaian',
                    'value' => 'Rp ' . MyFormatter::formatNumberForPrint($model->hargapemakaian),
                ),
            ),
        )); ?>

        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Paket BMHP', array('{icon}' => '<i class="icon-file icon-white"></i>')),
            $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        );
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>