<?php
// $this->widget('bootstrap.widgets.BootMenu', array(
//     'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
//     'stacked'=>false, // whether this is a stacked menu
//     'items'=>array(
//         array('label'=>'Transportasi', 'url'=>$this->createUrl('/rawatDarurat/TransportasiM')),
//         array('label'=>'Keadaan Masuk', 'url'=>$this->createUrl('/rawatDarurat/KeadaanMasukM')),
//         array('label'=>'Kondisi Pulang', 'url'=>'', 'active'=>true),
//         array('label'=>'Rujukan Keluar', 'url'=>$this->createUrl('/rawatDarurat/rujukanKeluarM')),
//         array('label'=>'Asal Rujukan', 'url'=>$this->createUrl('/rawatDarurat/asalRujukanM')),
//         array('label'=>'Triase', 'url'=>$this->createUrl('/rawatDarurat/triaseM')),
//         array('label'=>'Cara Keluar', 'url'=>$this->createUrl('/rawatDarurat/CaraKeluarM')),
//     ),
// )); 
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Kondisi Pulang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Rdkondisi Pulang Ms' => array('index'),
            $model->lookup_id => array('view', 'id' => $model->lookup_id),
            'Update',
        );

        $arrMenu = array();
        //                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kondisi Pulang', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kondisi Pulang', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model)); ?>
    </div>
</div>