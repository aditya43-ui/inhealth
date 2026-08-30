<?php
$this->breadcrumbs = array(
    'Pembayaran Tagihan Non Tunai' => array('/billingKasir/informasiPembayaranTagihanNonTunai/index'),
    'index',
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Piutang Penjamin</b>
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
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Piutang Penjamin</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'pencarianpasien-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'mergeHeaders' => array(
                        array(
                            'name' => '<p style="margin: 0; text-align: center;">Piutang yang sudah dibayarkan</p>',
                            'start' => 9, //indeks kolom 3
                            'end' => 10, //indeks kolom 4
                        ),
                    ),
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Bukti Bayar/<br>No. Bukti Bayar',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglbuktibayar)."/<br>".$data->nobuktibayar',
                        ),
                        array(
                            'header' => 'Instalasi/<br>Ruangan',
                            'type' => 'raw',
                            'value' => '$data->instalasi_nama."/<br>".$data->ruangan_nama',
                        ),
                        array(
                            'header' => 'No. Pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->no_pendaftaran',
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => '$data->nama_pasien',
                        ),
                        array(
                            'header' => 'Nama Penjamin',
                            'type' => 'raw',
                            'value' => '$data->penjamin_nama',
                        ),
                        array(
                            'header' => 'Total Tagihan <br>(Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->totalbiayapelayanan,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Piutang <br>(Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->totalpiutang,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Umur Piutang',
                            'type' => 'raw',
                            'value' => '$data->getUmurHutang($data->tgljatuhtempo, $data->tglpengajuanklaimanklaim)',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Tunai <br>(Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->totalbayar_tunai,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Non Tunai <br>(Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->totalbayar_nontunai,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Sisa Piutang <br>(Rp)',
                            'type' => 'raw',
                            'value' => 'number_format(($data->totalpiutang - $data->totalbayar_tunai - $data->totalbayar_nontunai),0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Rincian Piutang',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",Yii::app()->controller->createUrl("rincianDetail",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id)) ,array("title"=>"Klik untuk Melihat Rincian","target"=>"iframeRincianTagihan", "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");", "rel"=>"tooltip"))',
                            'footerHtmlOptions' => array('style' => 'text-align:left;color:white;'),
                        ),
                        array(
                            'header' => 'Status Klaim',
                            'type' => 'raw',
                            'value' => '(!empty($data->pengajuanklaimpiutang_id)?"PENGAJUAN ".MyFormatter::formatDateTimeForUser($data->tglpengajuanklaimanklaim) : "BELUM PENGAJUAN")',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianTagihan',
    'options' => array(
        'title' => 'Rincian Pembayaran Piutang Penjamin',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1024,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>