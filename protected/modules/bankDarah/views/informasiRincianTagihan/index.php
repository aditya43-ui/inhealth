<?php

/**
 * digunakan sebagai Informasi Rincian Tagihan
 * @author Elham Budianto  <elhambudianto1@gmail.com>
 **/
?>
<?php
$this->breadcrumbs = array(
    'Informasi Rincian Tagihan Pasien',
);

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
Yii::app()->clientScript->registerScript('search', "
    $('#kantongdarah-r-search').submit(function(){
        $.fn.yiiGridView.update('kantongdarah-r-grid', {
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
            <i class="entypo-info-circled"></i> Informasi <b>Rincian Tagihan Pasien</b>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Rincian Tagihan Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'kantongdarah-r-grid',
                    'dataProvider' => $model->search(),
                    //'replaceUrl'=>true,
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
                            'header' => 'Tanggal Pendaftaran / No. Pendaftaran',
                            'value' => function ($data) {
                                return MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tgl_pendaftaran))) . '/' . $data->no_pendaftaran;
                            },
                        ),
                        array(
                            'header' => 'Tanggal Formulir Permintaan / No Formulir Permintaan',
                            'value' => function ($data) {
                                $tanggal = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglpermintaan)));
                                return $tanggal . '/' . $data->no_permintaandarah;
                            },
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'value' => function ($data) {
                                return $data->no_rekam_medik;
                            },
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'value' => function ($data) {
                                return $data->nama_pasien;
                            },
                        ),
                        array(
                            'header' => 'Dokter Pelaksana',
                            'value' => function ($data) {

                                $permintaan = PermintaandarahT::model()->findByPk($data->permintaandarah_id);

                                if(!empty($permintaan->dpjp_id)) {
                                    $pegawai = PegawaiM::model()->findByPk($permintaan->dpjp_id);
                                    return $pegawai->namaLengkap;

                                } else {
                                    return '-';
                                }

                            },
                        ),
                        array(
                            'header' => 'Jenis Penjamin',
                            'value' => function ($data) {

                                if(!empty($data->permintaandarah_id)) {
                                    $detail = PermintaandarahdetT::model()->findByAttributes(array('permintaandarah_id' => $data->permintaandarah_id));

                                    if(isset($data->tindakanpelayanan_id)) {
                                        $tindakan = TindakanpelayananT::model()->findByAttributes(array('tindakanpelayanan_id' => $detail->tindakanpelayanan_id));
                                    if (!empty($tindakan)) {
                                        $carabayar = CarabayarM::model()->findByAttributes(array('carabayar_id' => $tindakan->carabayar_id));
                                        return $carabayar->carabayar_nama;
                                    } else {
                                        return '-';
                                    }
                                    }

                                } else {
                                    return '-';
                                }
                                
                            },
                        ),
                        array(
                            'header' => 'Status Bayar',
                            'value' => function ($data) {
                                if ($data->total_tarif == $data->total_bayar && $data->total_tarif > 0 && $data->total_bayar > 0) {
                                    return PARAMS::STATUSBAYAR_LUNAS;
                                } else {
                                    return PARAMS::STATUSBAYAR_BELUM_LUNAS;
                                }
                            },
                        ),
                        array(
                            'header' => 'Total Tagihan (Rp)',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'value' => function ($data) {
                                //return 'Rp '.$data->total_tarif;
                                $grand_total = 0;
                                $total = 0;

                                if(!empty($data->permintaandarah_id)) {

                                $modelDetail = PermintaandarahdetT::model()->findAllByAttributes(array('permintaandarah_id' => $data->permintaandarah_id));
                                foreach ($modelDetail as $details) {
                                    $total = $details['jml_kantong'] * $details['tarif_satuan'];
                                    $grand_total = $grand_total + $total;
                                }
                                return number_format($grand_total, 2, ',', '.');

                            } else {
                                return '-';
                            }
                            },
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                echo CHtml::link("<i class='icon-form-lihat'></i>", Yii::app()->createUrl('bankDarah/InformasiRincianTagihan/detail&id=' . $data->permintaandarah_id), array("rel" => "tooltip", "title" => "Klik untuk Detail Rincian Tagihan Pasien", "target" => "frameDetail", "onclick" => "window.parent.$(\"#dialogRincian\").dialog(\"open\");"));
                            },
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
// ===========================Dialog =========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincian',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Rincian Tagihan Pasien',
        'autoOpen' => false,
        'width' => 1200,
        'height' => 500,
        'resizable' => false,
        'scroll' => false
    ),
));
?>
<iframe src="" name="frameDetail" style="width: 100%; height: 98%; border: none;"></iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint1 =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/Informasiprint', array('permohonankantongdarahluar_id' => ''));
$urlPrint2 =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/Informasiprintluar', array('permohonankantongdarahluar_id' => ''));
// $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Printinformasi');

?>
<script>
    function print1(permohonankantongdarahluar_id) {
        window.open('<?php echo $urlPrint1 ?>' + permohonankantongdarahluar_id, 'printwin', 'left=400,top=400,width=800,height=600');
    }

    function print2(permohonankantongdarahluar_id) {
        window.open('<?php echo $urlPrint2 ?>' + permohonankantongdarahluar_id, 'printwin', 'left=400,top=400,width=800,height=600');
    }

    function batalIzin(id) {
        myConfirm('Anda yakin untuk membatalkan perizinan ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('BatalIzin'); ?>', {
                    id: id
                }, function(data) {
                    if (data.sukses == 1) {
                        myAlert(data.pesan);
                        $.fn.yiiGridView.update('kantongdarah-r-grid');
                    } else {
                        myAlert(data.pesan);
                    }
                }, 'json');
            }
        });
    }
</script>