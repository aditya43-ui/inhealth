<?php

/**
 * - digunakan sebagai Informasi
 * @author  Elham Budianto <elhambudianto1@gmail.com>
 * @website	   <.com>
 **/
?>
<?php $linkHalaman = CustomFunction::getUrlByMenuID(3584); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pemusnahan Rekam Medis' => array('index'),
    'Informasi',
);
$arrMenu = array();
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'List') . ' Data Pelamar ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PelamarT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PelamarT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
$this->menu = $arrMenu;
Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
$('#pemusnahanrekammedis-search').submit(function(){
        $.fn.yiiGridView.update('pemusnahanrekammedis-grid', {
                data: $(this).serialize()
        });
        return false;
});
");
$this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pemusnahan Rekam Medis</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', array('model' => $model,)); ?>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Dokumen Rekam Medis</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pemusnahanrekammedis-grid',
                    'replaceUrl' => true,
                    'dataProvider' => $model->search(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Pemusnahan Rekam Medis',
                            'value' => function ($data) {
                                echo MyFormatter::formatDateTimeForUser($data->tglpemusnahanrekammedis);
                            },
                        ),
                        array(
                            'header' => 'No. Pemusnahan',
                            'value' => function ($data) {
                                echo $data->nopemusnahanrekammedis;
                            },
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'value' => function ($data) {
                                echo $data->no_rekam_medik;
                            },
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'value' => function ($data) {
                                echo $data->nama_pasien;
                            },
                        ),
                        array(
                            'header' => 'Jenis Kelamin',
                            'value' => function ($data) {
                                echo $data->jeniskelamin;
                            },
                        ),
                        array(
                            'header' => 'Alamat',
                            'value' => function ($data) {
                                echo $data->alamat_pasien;
                            },
                        ),
                        array(
                            'header' => 'Kunjungan Terakhir',
                            'value' => function ($data) {
                                echo MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglkunjunganterakhir)));
                            },
                        ),
                        array(
                            'header' => 'Masa Fungsi',
                            'value' => function ($data) {
                                echo $data->masafungsirm;
                            },
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>