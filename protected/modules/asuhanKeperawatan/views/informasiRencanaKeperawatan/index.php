<?php $linkHalaman = CustomFunction::getUrlByMenuID(3568); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Rencana Keperawatan',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Rencana Keperawatan</b>
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
            $('#rencanakeperawatan-info-search').submit(function(){
                $('#informasirecanakeperawatan-grid').addClass('animation-loading');
                $.fn.yiiGridView.update('informasirecanakeperawatan-grid', {
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
                    <i class="entypo-credit-card"></i> Tabel <b>Rencana Keperawatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasirecanakeperawatan-grid',
                    'dataProvider' => $model->search(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No. Rencana',
                            'type' => 'raw',
                            'value' => '$data->no_rencana',
                        ),
                        array(
                            'header' => 'Tanggal Rencana',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->rencanaaskep_tgl)',
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
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/asuhanKeperawatan/rencanaKeperawatan/detail",array("rencanaaskep_id"=>$data->rencanaaskep_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Rencana Keperawatan", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Riwayat<br>Implementasi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link("<i class='icon-form-detail'></i>",  "javascript:;", [
                                    "target" => "frameDetail",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk melihat riwayat implementasi",
                                    'style' => 'text-align: center; width:40px',
                                    "onclick" => 'cetakRiwayat(' . $data->rencanaaskep_id . ')'
                                ]);
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Implementasi Keperawatan',
                            'type' => 'raw',
                            'value' => function ($data) use (&$load) {
                                $cri = new CDbCriteria();
                                $cri->join = " JOIN evaluasiaskep_t eval ON eval.implementasiaskep_id = t.implementasiaskep_id ";
                                $cri->addCondition(" rencanaaskep_id = " . $data->rencanaaskep_id . " ");
                                $load = ASImplementasiaskepT::model()->find($cri);
                                if (empty($load)) {
                                    return CHtml::Link("<i class='icon-imkeperawatan'></i>", Yii::app()->controller->createUrl("/asuhanKeperawatan/implementasiAskep/Index", array("rencanaaskep_id" => $data->rencanaaskep_id)), array("class" => "", "rel" => "tooltip", "title" => "Klik Melakukan Ke Implementasi Keperawatan"));
                                } else {
                                    return "Rencana sudah dievaluasi";
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
                            'value' => function ($data) use (&$load) {
                                $click = "hapus_data(this)";
                                if (!empty($load)) {
                                    $click = "toastr.info('<b>Data Tidak Bisa Dihapus</b> karena sudah Ada Transaksi Implementasi Keperawatan','Perhatian!')";
                                }
                                return CHtml::link("<i class='icon-form-sampah'></i> ",  'javascript:void(0)', array('data-id' => $data->rencanaaskep_id, "rel" => "tooltip", "title" => "Klik untuk menghapus Rencana Keperawatan", "onclick" => $click));
                            }
                        ]
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<script>
    const cetakRiwayat = (rencanaaskep_id) => {
        window.open("<?php echo $this->createUrl("/asuhanKeperawatan/implementasiAskep/cetakRiwayat"); ?>/&rencanaaskep_id=" + rencanaaskep_id + "&caraPrint=PRINT", "", 'location=_new, width=900px, scrollbars=1');
    }
</script>
<?=
$this->renderPartial($this->path_view . '_jsFunctions', [], true)
?>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Rencana Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>