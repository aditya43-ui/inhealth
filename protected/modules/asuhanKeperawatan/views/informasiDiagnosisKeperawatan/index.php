<?php $linkHalaman = CustomFunction::getUrlByMenuID(3567); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#pengkajiankeperawatan-info-search').submit(function(){
    $('#informasiasuhankeperawatan-grid').addClass('animation-loading');
    $.fn.yiiGridView.update('informasiasuhankeperawatan-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<?php
$this->breadcrumbs = array(
    'Informasi Diagnosis Keperawatan',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Diagnosis Keperawatan</b>
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
                <?php
                $this->renderPartial($this->path_view . '_search', array(
                    'model' => $model, 'format' => $format
                ));
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Diagnosa Keperawatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasiasuhankeperawatan-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No. Diagnosis',
                            'type' => 'raw',
                            'value' => '$data->no_diagnosisaskep',
                        ),
                        array(
                            'header' => 'Tanggal Diagnosis',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->diagnosisaskep_tgl)',
                        ),
                        array(
                            'header' => 'No. Pendaftaran',
                            'name' => 'no_pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->no_pendaftaran',
                        ),
                        array(
                            'header' => 'Ruangan',
                            'name' => 'ruangan_nama',
                            'type' => 'raw',
                            'value' => '$data->ruangan_nama',
                        ),
                        array(
                            'header' => 'Kelas Pelayanan',
                            'name' => 'umur',
                            'type' => 'raw',
                            'value' => '$data->kelaspelayanan_nama',
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => '$data->nama_pasien',
                        ),
                        array(
                            'header' => 'Jenis Kelamin',
                            'type' => 'raw',
                            'value' => '$data->jeniskelamin',
                        ),
                        array(
                            'header' => 'Nama Perawat',
                            'type' => 'raw',
                            'value' => '$data->nama_pegawai',
                        ),
                        array(
                            'header' => 'Lihat Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/asuhanKeperawatan/InformasiDiagnosisKeperawatan/Detail",array("diagnosisaskep_id"=>$data->diagnosisaskep_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Diagnosa Keperawatan", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Buat Rencana',
                            'type' => 'raw',
                            'value' => function ($data) use (&$dekdata) {
                                $dekdata = ASRencanaaskepT::model()->findByAttributes(array('diagnosisaskep_id' => $data->diagnosisaskep_id));
                                if (empty($dekdata)) {
                                    echo CHtml::link("<i class='icon-form-kunjungan'></i> ",  Yii::app()->controller->createUrl("/asuhanKeperawatan/rencanaKeperawatan/Index", array("diagnosisaskep_id" => $data->diagnosisaskep_id)), array("rel" => "tooltip", "title" => "Klik untuk Melanjutkan ke transaksi Rencana Asuhan Keperawatan", "data-placement" => "left"));
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        [
                            'header' => 'Batal',
                            'type' => 'raw',
                            'htmlOptions' => [
                                'style' => 'text-align:center;'
                            ],
                            'value' => function ($data) use (&$dekdata) {
                                $click = "hapus_data(this)";
                                if (!empty($dekdata)) {
                                    $click = "toastr.info('Data Tidak Bisa Dihapus karena sudah Ada Transaksi Rencana Keperawatan','Perhatian!')";
                                }
                                return CHtml::link("<i class='icon-form-sampah'></i> ",  'javascript:void(0)', array('data-id' => $data->diagnosisaskep_id, "rel" => "tooltip", "title" => "Klik untuk menghapus Diagnosa Keperawatan", "onclick" => $click));
                            }
                        ]
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?=
$this->renderPartial($this->path_view . '_jsFunctions', [], true)
?>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Diagnosa Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>