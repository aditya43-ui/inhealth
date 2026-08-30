<?php $linkHalaman = CustomFunction::getUrlByMenuID(3570); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Evaluasi Keperawatan',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Evaluasi Keperawatan</b>
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
            $('#asuhankeperawatan-info-search').submit(function(){
                $('#informasiasuhankeperawatan-grid').addClass('animation-loading');
                $.fn.yiiGridView.update('informasiasuhankeperawatan-grid', {
                        data: $(this).serialize()
                });
                return false;
            });
        ");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array(
                    'model' => $model, 'format' => $format
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Evaluasi Keperawatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasiasuhankeperawatan-grid',
                    'dataProvider' => $model->search(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No. Evaluasi',
                            'type' => 'raw',
                            'value' => '$data->no_evaluasi',
                        ),
                        array(
                            'header' => 'Tanggal Evaluasi',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->evaluasiaskep_tgl)',
                        ),
                        array(
                            'header' => 'No. Pendaftaran',
                            'name' => 'no_pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->no_pendaftaran',
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
                            'header' => 'Lihat Detail',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/asuhanKeperawatan/InformasiEvaluasiAskep/Detail",array("evaluasiaskep_id"=>$data->evaluasiaskep_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Evaluasi Keperawatan", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Verifikasi Keperawatan',
                            'type' => 'raw',
                            'value' => 'isset($data->verifikasiaskep_id)?"Sudah Diverifikasi":CHtml::Link("<i class=\'icon-verifikasiklaim\'></i>",Yii::app()->controller->createUrl("/asuhanKeperawatan/VerifikasiAskep/Index",array("evaluasiaskep_id"=>$data->evaluasiaskep_id)),array("class"=>"", "rel"=>"tooltip","title"=>"Klik Melakukan Ke Verifikasi Keperawatan"))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        [
                            'header' => 'Batal',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                $click = "hapus_data(this)";
                                if (!empty($data->verifikasiaskep_id)) {
                                    $click = "toastr.info('<b>Data Tidak Bisa Dihapus</b> karena sudah dilakukan Verifikasi','Perhatian!')";
                                }
                                return CHtml::link("<i class='icon-form-silang'></i> ",  'javascript:void(0)', array('data-id' => $data->evaluasiaskep_id, "rel" => "tooltip", "title" => "Klik untuk menghapus Pengkajian Keperawatan", "onclick" => $click));
                            }
                        ]
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
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
        'title' => 'Detail Evaluasi Keperawatan',
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