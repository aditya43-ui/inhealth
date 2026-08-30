<?php
$this->breadcrumbs = array(
    'Pesangon Pegawai',
);
$arrMenu = array();
//                    array_push($arrMenu,array('label'=>' Penggajian Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPenggajianpegT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' KPPenggajianpegT', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;
?>
<?php $this->menu = $arrMenu; ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pesangon Pegawai</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'modPegawai' => $modPegawai, 'komponen' => $komponen)); ?>
    </div>
</div>