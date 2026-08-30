<?php

/**
 * - digunakan sebagai Informasi Kalibrasi
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>
<?php
Yii::app()->clientScript->registerScript('search', "
    $('#kalibrasi-r-search').submit(function(){
        $.fn.yiiGridView.update('kalibrasi-r-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Kalibrasi</b>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Kalibrasi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'kalibrasi-r-grid',
                    'dataProvider' => $model->search(),
                    'replaceUrl' => true,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'Tanggal Kalibrasi',
                            'value' => function ($data) {
                                echo MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglkalibrasi)));
                            },
                        ),
                        array(
                            'header' => 'Berlaku Sampai',
                            'value' => function ($data) {
                                echo MyFormatter::formatDateTimeForUser($data->berlaku_sdtgl);
                            },
                        ),
                        array(
                            'header' => 'No & Nama Barang',
                            'value' => function ($data) {
                                //$barang = InvperalatanT::model()->findByPk($data->invperalatan_id);
                                //echo $barang->invperalatan_kode.'-'.$barang->invperalatan_namabrg;
                                echo $data->invperalatan_kode . '-' . $data->invperalatan_namabrg;
                            },
                        ),
                        array(
                            'header' => 'Unit Kerja Ruangan',
                            'value' => function ($data) {
                                if ($data->ruangan_id != NULL) {
                                    $ruangan = RuanganM::model()->findByPk($data->ruangan_id);
                                    $unitkerjaruangan = UnitkerjaruanganM::model()->findByAttributes(array('ruangan_id' => $data->ruangan_id));
                                    //$instalasi = InstalasiM::model()->findByPk($ruangan->instalasi_id);
                                    $unitkerja = UnitkerjaM::model()->findByPk($unitkerjaruangan->unitkerja_id);
                                    //echo 'Instalasi '.$instalasi->instalasi_nama.'-Ruang '.$ruangan->ruangan_nama;
                                    echo $unitkerja->namaunitkerja . ' - ' . $data->ruangan_nama;
                                } else {
                                    echo '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Vendor',
                            /*'value'=>function($data){
                                        $vendor = SupplierM::model()->findByPk($data->teknisikalibrasi_id);
                                        echo $vendor->supplier_nama;
                                    },*/
                            'value' => function ($data) {
                                if ($data->supplier_nama != NULL) {
                                    echo $data->supplier_nama;
                                } else {
                                    echo '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Pelaksana',
                            /*'value'=>function($data){
                                        $pelaksana = PegawaiM::model()->findByPk($data->pegpelaksana_id);
                                        echo $pelaksana->namaLengkap;
                                    },*/
                            'value' => '$data->nama_pegawai',
                        ),
                        array(
                            'header' => 'Detil',
                            'value' => 'CHtml::link("<i class=\'entypo-list\'></i>",Yii::app()->createUrl(\'manajemenAset/InformasiKalibrasi/Detail&id=\'.$data->invkalibrasi_id),array("rel"=>"tooltip","title"=>"Klik untuk Detail Kalibrasi" ))',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        /*array(
                                        'header'=>'Batal',
                                        'class'=>'bootstrap.widgets.BootButtonColumn',
                                        'template'=>'{delete}',
                                        'buttons'=>array(
                                            'delete'=> array(
                                                   'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus Kalibrasi' ),
                                           ),
                                        )
                                ),*/
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'entypo-cancel\'></i> ", "javascript:deleteRecord($data->invkalibrasi_id)",array("id"=>"$data->invkalibrasi_id","rel"=>"tooltip","title"=>"Klik untuk Membatalkan Kalibrasi"))',
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
// ===========================Dialog Details Perizinan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailsPerizinan',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Rincian Perizinan Sponsorship',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'scroll' => false
    ),
));
?>
<iframe src="" name="iframe" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Perizinan================================
?>
<?php
// ===========================Dialog Details Perizinan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogVerifikasiKabag',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Verifikasi Ka.Bid / Ka.Bag',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('kalibrasi-r-grid', {
            data: $('#kalibrasi-r-search').serialize()
    }); }",
    ),
));
?>
<iframe src="" name="iframe1" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Perizinan================================
?>
<?php
// ===========================Dialog Details Perizinan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogVerifikasiPeg',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Verifikasi Kepegawaian',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('kalibrasi-r-grid', {
            data: $('#kalibrasi-r-search').serialize()
    }); }",
    ),
));
?>
<iframe src="" name="iframe2" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Perizinan================================
?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
?>
<script type="text/javascript">
    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('kalibrasi-r-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
</script>