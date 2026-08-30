<?php

/**
 * digunakan untuk perbaikan panel pencarian
 * RSST-2894
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 */
?>
<?php $linkHalaman = CustomFunction::getUrlByMenuID(3030); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pengajuan Sterilisasi',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pengajuan Sterilisasi</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
$('#pengajuansterilisasis-info-search').submit(function(){
	$('#informasipengajuansterilisasi-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasipengajuansterilisasi-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
        ?>
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengajuan Sterilisasi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipengajuansterilisasi-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'No. Pengajuan',
                            'type' => 'raw',
                            'value' => '$data->pengajuansterlilisasi_no',
                        ),
                        array(
                            'header' => 'Tanggal Pengajuan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->pengajuansterlilisasi_tgl)',
                        ),
                        array(
                            'header' => 'Instalasi',
                            'type' => 'raw',
                            'value' => '$data->ruangan->instalasi->instalasi_nama',
                        ),
                        array(
                            'header' => 'Ruangan',
                            'type' => 'raw',
                            'value' => '$data->ruangan->ruangan_nama',
                        ),
                        array(
                            'header' => 'Keterangan',
                            'type' => 'raw',
                            'value' => '$data->pengajuansterlilisasi_ket',
                        ),
                        array(
                            'header' => 'Lihat Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/sterilisasi/informasiPengajuanSterilisasi/detail",array("id"=>$data->pengajuansterlilisasi_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Pengajuan Sterilisasi", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Terima Peralatan dan Linen',
                            'type' => 'raw',
                            'value' => 'isset($data->issudahditerima) ? "Sudah Diterima" : CHtml::link("<i class=\'icon-form-input\'></i> ",  Yii::app()->controller->createUrl("/sterilisasi/penerimaanPeralatanSterilT/index",array("pengajuansterlilisasi_id"=>$data->pengajuansterlilisasi_id)),array("rel"=>"tooltip","title"=>"Klik untuk Detail Pengajuan Sterilisasi"));', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pengajuan Sterilisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => true,
    ),
));
echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>