<?php $linkHalaman = CustomFunction::getUrlByMenuID(3187); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pengaduan Pelayanan',
);
Yii::app()->clientScript->registerScript('search', "
    $('#informasipengaduan-search').submit(function(){
        $.fn.yiiGridView.update('informasipengaduan-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash("success", "Data berhasil disimpan!");
    $this->widget('bootstrap.widgets.BootAlert');
}
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pengaduan Pelayanan</b>
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
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengaduan Pelayanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div style="float:right;margin-bottom:10px">
                </div>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipengaduan-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Pengaduan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pengaduan)'
                        ),
                        array(
                            'header' => 'Kategori',
                            'type' => 'raw',
                            'value' => '$data->namakategori',
                            'value' => function($data) {
                                    echo $data->namakategori;
                                    
                                    // menampung nilai bulan untuk perubahan warna 
                                    echo CHtml::hiddenField('warna', $data->warnakategoripengaduan, array('class' => 'ubah'));
                                }
                        ),
                        array(
                            'header' => 'Instalasi/Ruangan terkait pengaduan',
                            'type' => 'raw',
                            'value' => '$data->kp_namaunit'
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik'
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => '$data->nama_pasien'
                        ),
                        array(
                            'header' => 'Nama Pelapor',
                            'type' => 'raw',
                            'value' => '$data->nama'
                        ),
                        array(
                            'header' => 'Alamat',
                            'type' => 'raw',
                            'value' => '$data->alamat'
                        ),
                        array(
                            'header' => 'Keluhan',
                            'type' => 'raw',
                            'value' => '$data->uraian_keluhan'
                        ),
                        array(
                            'header' => 'Jenis Pelayanan',
                            'name' => 'jenis_pelayanan',
                        ),
                        array(
                            'header' => 'Kepuasan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $hasil = '';
                                if ($data->kp_sangatpuas == 1) {
                                    $hasil = "<img src='data/images/informasi/sangatpuas.png' width='20' height='20'> Sangat Puas";
                                } else if ($data->kp_puas == 1) {
                                    $hasil = "<img src='data/images/informasi/puas.png' width='20' height='20'> Puas";
                                } else if ($data->kp_tidakpuas == 1) {
                                    $hasil = "<img src='data/images/informasi/tidakpuas.png' width='20' height='20'> Tidak Puas";
                                }
                                return $hasil;
                            }
                        ),
                        array(
                            'header' => 'Detail',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link("<i class='icon-form-lihat'></i>", Yii::app()->createUrl('informasi/InformasiPengaduan/detail&id=' . $data->kepuasanpasien_id), array(
                                    "rel" => "tooltip",
                                    //'onclick'=>'Menyetujui('.$data->ppdslisensi_id.');',
                                    "target" => "iframeDetail",
                                    "onclick" => "$('#dialogDetail').dialog('open');",
                                    "title" => "Klik untuk Melihat Detail"
                                ));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Aksi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link(
                                    "<span style='font-size:15px'><i class='icon-form-ubah'></i></span>",
                                    Yii::app()->createUrl('informasi/TransaksiPengaduan/Index&kepuasanpasien_id=' . $data->kepuasanpasien_id),
                                    array("rel" => "tooltip", "title" => "Klik untuk Mengubah Data")
                                ) .
                                    CHtml::Link(
                                        "<i class='icon-form-sampah'></i>",
                                        "javascript:void(0)",
                                        array("onclick" => "hapus($data->kepuasanpasien_id)")
                                    );
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
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
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
?>
<?php
// ===========================Dialog Details Evaluasi=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Edukasi',
        'autoOpen' => false,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="iframeDetail" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Evaluasi================================
?>
<script>
    function hapus(id) {
        myConfirm("Anda yakin akan membatalkan data ini?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('batal'); ?>', {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'berhasil') {
                            $.fn.yiiGridView.update('informasipengaduan-grid', {
                                data: $(this).serialize()
                            });
                            myAlert('Data berhasil dibatalkan');
                            return false;
                        } else {
                            myAlert('Data gagal disimpan')
                        }
                    }, 'json');
            }
        });
    }
</script>
<script type="text/javascript">
    function ubahWarna() {
        $('#informasipengaduan-grid > table > tbody > tr').each(function () {
            var warna = $(this).find('.ubah').val();

            $(this).find('td').attr('style', 'background: '+warna+'  !important');
        });
    }

    $(document).ready(function () {
        ubahWarna();
    });
</script>