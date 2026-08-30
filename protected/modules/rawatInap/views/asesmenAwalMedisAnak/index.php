<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php
$this->breadcrumbs = array(
    'Asesmen Awal Medis',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'asesmen-awal-medis-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this)'),
        ));
?>
<style>
    .groupUkurans{
        display:inline;
    }
    .numbers-only{
        text-align: right;


    }

</style>
<?php
$dokter = "";
$dpjp = "";
$diagnosa = "";
$ppds = "";
if (!empty($modAsesmenAwalMedis->dokterpemeriksa_id)) {
    $load_dokter = DokterV::model()->findByAttributes(array('pegawai_id' => $modAsesmenAwalMedis->dokterpemeriksa_id));
    
    $dokter  = !empty($load_dokter)?$load_dokter->namaLengkap:null;
}
if (!empty($modAsesmenAwalMedis->dokterdpjp_id)) {
    $load = DokterV::model()->findByAttributes(array('pegawai_id' => $modAsesmenAwalMedis->dokterdpjp_id));
    $dpjp = !empty($load)?$load->namaLengkap:null;
}
if (!empty($modAsesmenAwalMedis->ppds_id)) {
    $load = DokterV::model()->findByAttributes(array('pegawai_id' => $modAsesmenAwalMedis->dokterdpjp_id));
    $ppds = !empty($load)?$load->namaLengkap:null;
}

$cekkelompokpegawai = PegawaiM::model()->findByAttributes(array('pegawai_id' => Yii::app()->user->getState('pegawai_id'), 'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP));
$cekppds = PpdsM::model()->findByPk(Yii::app()->user->getState('ppds_id'));

if (!empty($cekkelompokpegawai)) {
    //Jika yang login adalah kelompok pegawai 1, 
    //dokterpemeriksa disimpan di dokterpemeriksa_id
    //cek ada atau tidak di asesmen medis pada kolom dokterpemeriksa_id, 
    //jika di kolom tsb tidak ada load dari pasienadmisi.
    if (!empty($modAsesmenAwalMedis->asesmen_awal_medis_id)) {
        if (!empty($modAsesmenAwalMedis->dokterpemeriksa_id)) {
            $cekdokter = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modAsesmenAwalMedis->dokterpemeriksa_id));
            $pemeriksa = !empty($cekdokter->namaLengkap) ? $cekdokter->namaLengkap : '';
            $pemeriksa_id = !empty($cekdokter->pegawai_id) ? $cekdokter->pegawai_id : null;
        }
    } else {
        $cekPendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
        $cekPasienAdmisi = PasienadmisiT::model()->findByPk($cekPendaftaran->pasienadmisi_id);
        $pemeriksa = !empty($cekPasienAdmisi->pegawai->namaLengkap) ? $cekPasienAdmisi->pegawai->namaLengkap : '';
        $pemeriksa_id = !empty($cekPasienAdmisi->pegawai_id) ? $cekPasienAdmisi->pegawai_id : null;
    }
} else if (!empty($cekppds)) {
    //Jika yang login adalah ppds, 
    //dokterpemeriksa disimpan di ppds_id
    //cek ada atau tidak di asesmen medis pada kolom ppds_id, 
    //jika di kolom tsb tidak ada maka load dari userlogin.
    if (!empty($modAsesmenAwalMedis->ppds_id)) {
        $cekppds = PpdsM::model()->findByAttributes(array('ppds_id' => $modAsesmenAwalMedis->ppds_id));
        $pemeriksa = !empty($cekppds->ppds_nama) ? $cekppds->ppds_nama : '';
        $pemeriksa_id = !empty($cekppds->ppds_id) ? $cekppds->ppds_id : null;
    } else {
        $cekppds = PpdsM::model()->findByPk(Yii::app()->user->getState('ppds_id'));
        $pemeriksa = !empty($cekppds->ppds_nama) ? $cekppds->ppds_nama : '';
        $pemeriksa_id = !empty($cekppds->ppds_id) ? $cekppds->ppds_id : null;
    }
} else if (empty($cekkelompokpegawai) && empty($cekppds)) {
    echo '<span class="required">* Pengisian Asesmen awal medis Hanya bisa dilakukan oleh Dokter</span>';
}

//DPJP
if (!empty($modAsesmenAwalMedis->dokterdpjp_id)) {
    $cekdpjp = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modAsesmenAwalMedis->dokterdpjp_id));
    $dpjp = !empty($cekdpjp->namaLengkap) ? $cekdpjp->namaLengkap : '';
    $dpjp_id = !empty($cekdpjp->pegawai_id) ? $cekdpjp->pegawai_id : '';
} else {
    if ($this->init == 'RD' || $this->init == 'RJ') {
        $cekDPJP = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
        $dpjp = !empty($cekDPJP->pegawai->namaLengkap) ? $cekDPJP->pegawai->namaLengkap : '';
        $dpjp_id = !empty($cekDPJP->pegawai_id) ? $cekDPJP->pegawai_id : '';
    } else {
        $cekPendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
        $cekDPJP = PasienadmisiT::model()->findByPk($cekPendaftaran->pasienadmisi_id);
        $dpjp = !empty($cekDPJP->pegawai->namaLengkap) ? $cekDPJP->pegawai->namaLengkap : '';
        $dpjp_id = !empty($cekDPJP->pegawai_id) ? $cekDPJP->pegawai_id : '';
    }
}

$pendaftaran_id = (isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null);
$modRiwayatAwalMedis = RIAsesmenAwalMedisT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
if (empty($_GET['from'])) {
    if (Yii::app()->controller->id == 'asesmenAwalMedisDewasaHD') {
    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        'id' => 'asesmenawalmedis',
        'content' => array(
            'content-asesmenawalmedis' => array(
                'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk menampilkan riwayat asesmen awal dialisis')) . '<b> Riwayat Asesmen Awal Dialisis</b>',
                'isi' => $this->renderPartial($this->path_view . '_rowRiwayatAsesmenAwalDialisis', array(
                    'form' => $form,
                    'modRiwayatAwalMedis' => $modRiwayatAwalMedis,
                    'modPendaftaran' => $modPendaftaran,
                    'st' => 'asuhan'
                        ), true),
                'active' => false,
            ),
        ),
    ));
} else if (Yii::app()->controller->id == 'asesmenAwalMedisAnakHD') {
     $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'asesmenawalmedis',
            'content' => array(
                'content-asesmenawalmedis' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk menampilkan riwayat asesmen awal dialisis anak')) . '<b> Riwayat Asesmen Awal Dialisis Anak</b>',
                    'isi' => $this->renderPartial($this->path_view . '_rowRiwayatAsesmenAwalDialisis', array(
                        'form' => $form,
                        'modAsesmenAwalMedis' => $modAsesmenAwalMedis,
                        'modRiwayatAwalMedis' => $modRiwayatAwalMedis,
                        'modPendaftaran'=>$modPendaftaran,
                        'st' => 'asuhan'
                            ), true),
                    'active' => true,
                ),
            ),
        ));
} else {
    if (!empty($modRiwayatAwalMedis)) {
     $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'asesmenawalmedis',
            'content' => array(
                'content-asesmenawalmedis' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk menampilkan riwayat asesmen awal medis')) . '<b> Riwayat Asesmen Awal Medis </b>',
                    'isi' => $this->renderPartial($this->path_view . '_rowRiwayatAsesmenAwalMedis', array(
                        'form' => $form,
                        'modAsesmenAwalMedis' => $modAsesmenAwalMedis,
                        'modRiwayatAwalMedis' => $modRiwayatAwalMedis,
                        'modPendaftaran'=>$modPendaftaran,
                        'st' => 'asuhan'
                            ), true),
                    'active' => true,
                ),
            ),
        ));
    }
}
}

?>
<br>
<?php
if ($this->module->id == 'hemodialisa') :
    $this->renderPartial($this->path_view . '_formAsesmenAwalMedis', array('modAsesmenAwalMedis' => $modAsesmenAwalMedis));
    ?>

<?php else : ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Asesmen Awal Medis Anak</div>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <div class="col-sm-12">
                    <?php if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RJ) { ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Waktu Pemeriksaan', 'tanggalruangan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modAsesmenAwalMedis,
                                    'attribute' => 'tgl_pemeriksaan',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('readonly' => true,
                                        'class' => 'span4',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                                ));
                                ?>   
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Tanggal dan Jam Masuk Ruangan', 'tanggalruangan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modAsesmenAwalMedis,
                                    'attribute' => 'tglmasuk_rs',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('readonly' => true,
                                        'class' => 'span4',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                                ));
                                ?>   
                            </div>
                        </div> 
                        <div class="control-group">
                            <?php echo CHtml::label('Waktu Pemeriksaan', 'tanggalruangan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modAsesmenAwalMedis,
                                    'attribute' => 'tgl_pemeriksaan',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('readonly' => true,
                                        'class' => 'span4',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                                ));
                                ?>   
                            </div>
                        </div> 

                        <div class="control-group">
                            <?php echo CHtml::label('Cara Masuk <span class="required">*</span>', 'tanggalruangan', array('class' => 'control-label')); ?>
                            <div class='controls' id="cek-caramasuk">
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'pasiendari_irj', array('class' => 'cek', 'onclick' => '$("#RIAsesmenAwalMedisT_riwayat_penyakit_sekarang").blur();')); ?> <label>IRJ</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'pasiendari_igd', array('class' => 'cek', 'onclick' => '$("#RIAsesmenAwalMedisT_riwayat_penyakit_sekarang").blur();')); ?> <label>IGD</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'pasiendari_rujukan', array('checked' => false, 'class' => 'cek', 'onclick' => '$("#RIAsesmenAwalMedisT_riwayat_penyakit_sekarang").blur();')); ?> <label>Rujukan</label>
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'pasiendari_lainnya', array('class' => 'cek lainlain', 'onclick' => '$("#RIAsesmenAwalMedisT_riwayat_penyakit_sekarang").blur();')); ?> <label>Lain-lain</label>
                                <?php echo $form->textField($modAsesmenAwalMedis, 'pasiendari_lainnya_keterangan', array('placeholder' => 'Keterangan Lainnya', 'class' => 'span4', 'readonly' => true)) ?>
                            </div>
                        </div>
                    <?php if ($this->init != 'HD'){ ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Diagnosa Masuk RS <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->hiddenField($modAsesmenAwalMedis, 'diagnosa_id', array('readonly' => true));
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $modAsesmenAwalMedis,
                                    'attribute' => 'diagnosa_nama',
                                    'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('daftarKeperawatan') . '",
                                            dataType: "json",
                                                data: {
                                                    term: request.term,
                                                    tipe: 1,
                                            },
                                                success: function (data) {
                                                response(data);
                                        }
                                         })
                                        }',
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui ) {
                                                    $(this).val(ui.item.value);
                                                    return false;
                                        }',
                                        'select' => 'js:function( event, ui ) {
//                                          $("#InfokunjunganriV_no_pendaftaran").val(ui.item.no_pendaftaran);
                                            return false;
                                        }',
                                    ),
                                    'htmlOptions' => array('placeholder' => 'Nama Diagnosa', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 required'),
                                    'tombolDialog' => array('idDialog' => 'diagnosa-dialog'),
                                ));
                                ?>
                            </div>
                        </div>  
                    <?php } ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Alasan dirawat', 'tanggalruangan', array('class' => 'control-label')); ?>
                            <div class='controls'>
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'alasandirawat_observasi', array()); ?> <label>Observasi</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'alasandirawat_prosesdiagnostik', array()); ?> <label>Proses Diagnostik</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'alasandirawat_terapi', array()); ?> <label>Terapi</label>
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'alasandirawat_rehabilitasi', array()); ?> <label>Rehabilitasi</label> 
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Pasien</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-12">
                <div class="form-cek-lis">
                    <?= $this->renderPartial($this->path_view.'form/_form_keluhan_utama',['model'=>$modAsesmenAwalMedis, 'form'=>$form], true) ?> 
                </div>
                <div class="riwayat-penyakit-sekarang form-cek-lis">
                <div class="control-group ">
                    <?php echo CHtml::label('Riwayat Penyakit Sekarang', 'keluhanutama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <div class='controls kelompok'>
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_sakit_skr_diabetes', array('class'=>'multiple')); ?> <label>Diabetes</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_sakit_skr_hipertensi', array('class'=>'multiple')); ?> <label>Hipertensi</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_sakit_skr_jantung', array('class'=>'multiple')); ?> <label>Jantung</label>
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_sakit_skr_tidakada', array('class' => 'tidak-ada multiple')); ?> <label>Tidak Ada</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_sakit_skr_lainnya', array('class' => 'lainlain open-ket-dis multiple')); ?> <label>Lainnya</label> 
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_sakit_skr_lainnya_ket', array('placeholder' => 'Keterangan Lainnya', 'class' => 'span4 ket-dis')) ?>
                        </div>
                    </div>
                </div> 
                </div>
                <div class="riwayat-penyakit-dahulu">
                    <div class="control-group">
                        <?php echo CHtml::label('Riwayat Penyakit Dahulu', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_sakit_dulu_diabetes', array()); ?> <label>Diabetes</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_sakit_dulu_hipertensi', array()); ?> <label>Hipertensi</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_sakit_dulu_jantung', array()); ?> <label>Jantung</label>
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_sakit_dulu_tidakada', array('class' => 'tidak-ada')); ?> <label>Tidak Ada</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_sakit_dulu_lainnya', array('class' => 'lainlain')); ?> <label>Lainnya</label> 
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_sakit_dulu_lainnya_ket', array('placeholder' => 'Keterangan Lainnya', 'class' => 'span4', 'readonly' => true)) ?>
                        </div>
                    </div>  
                </div>
                <div class="riwayat-penyakit-keluarga">    
                    <div class="control-group">
                        <?php echo CHtml::label('Riwayat Penyakit Keluarga', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_sakit_keluarga_diabetes', array()); ?> <label>Diabetes</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_sakit_keluarga_hipertensi', array()); ?> <label>Hipertensi</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_sakit_keluarga_jantung', array()); ?> <label>Jantung</label>
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_sakit_keluarga_tidakada', array('class' => 'tidak-ada-keluarga')); ?> <label>Tidak Ada</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_sakit_keluarga_lainnya', array('class' => 'lainlain')); ?> <label>Lainnya</label> 
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_sakit_keluarga_lainnya_ket', array('placeholder' => 'Keterangan Lainnya', 'class' => 'span4', 'readonly' => true)) ?>
                        </div>
                    </div>  
                </div>
<!--<<<<<<< HEAD
                <div id="riwayatimunasi">
                    <div class="control-group">
                <?php //echo CHtml::label('Riwayat Imunasi', 'riwayat_imunisasi_bcg', array('class' => 'control-label'));  ?>
                        <div class="controls">
                <?php //echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_imunisasi_bcg', array());  ?> <label>BCG</label>
                        </div>
                    </div>
=======-->
                <?php if (Yii::app()->controller->id == 'asesmenAwalMedisDewasaHD') : ?>

                    <div class="kebiasaan">
                        <div class="control-group">
                            <label class="control-label">Kebiasaan</label>
                            <div class="controls">
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'kebiasaan_merokok', array()); ?> <label>Merokok</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'kebiasaan_alkohol', array()); ?> <label>Alkohol</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'kebiasaan_obat', array('onclick' => 'kebiasaanObat()')); ?> <label>Obat-obatan</label> 
                                <?php echo $form->textField($modAsesmenAwalMedis, 'kebiasaan_obat_keterangan', array('class' => 'span3', 'readonly' => true)) ?>
                            </div>
                        </div>
                    </div>           

                    <div class="perilaku">
                        <div class="control-group">
                            <label class="control-label">Perilaku</label>
                            <div class="controls">
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'perilaku_agresif', array()); ?> <label>Agresif</label> &nbsp;&nbsp;
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'perilaku_tidakkooperatif', array()); ?> <label>Tidak Kooperatif</label> 
                            </div>
                        </div>
                    </div>           

                    <div class="masalah-perkawinan">
                        <div class="control-group">
                            <label class="control-label">Masalah Perkawinan</label>
                            <div class="controls">
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'masalah_perkawinan_tidak_ada', array()); ?> <label>Tidak Ada</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'masalah_perkawinan_ada', array('onclick' => 'masalahkawinAda()')); ?> <label>Ada</label> 
                                <?= $form->dropDownList($modAsesmenAwalMedis, 'masalah_perkawinan_keterangan', CHtml::listData(LookupM::model()->findAll("lookup_type = 'masalah_keperawatan_hd'"), 'lookup_name', 'lookup_name'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'cekPerkawinan(this)', 'readonly' => true)); ?>
                                <?php echo $form->textField($modAsesmenAwalMedis, 'masalah_perkawinan_keterangan_1', array('class' => 'span3', 'readonly' => true)) ?>
                            </div>
                        </div>
                    </div>           

                    <div class="mengalami-kekerasan-fisik">
                        <div class="control-group">
                            <label class="control-label">Mengalami Kekerasan Fisik</label>
                            <div class="controls">
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'kekerasan_fisik_tidak_ada', array()); ?> <label>Tidak Ada</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'kekerasan_fisik_ada', array()); ?> <label>Ada</label> 
                                &nbsp;<label>Mencederai diri/orang lain</label>

                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'mencederai_orang_pernah', array()); ?> <label>Pernah</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'mencederai_orang_tidak_pernah', array()); ?> <label>Tidak Pernah</label> 
                            </div>
                        </div>
                    </div>

                    <div class="trauma-dalam-kehidupan">
                        <div class="control-group">
                            <label class="control-label">Trauma Dalam Kehidupan</label>
                            <div class="controls">
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'trauma_kehidupan_tidak_ada', array()); ?> <label>Tidak Ada</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'trauma_kehidupan_ada', array('onclick' => 'traumahidupAda()')); ?> <label>Ada</label> 
                                <?php echo $form->textField($modAsesmenAwalMedis, 'trauma_kehidupan_ada_keterangan', array('class' => 'span3', 'readonly' => true)) ?>
                            </div>
                        </div>
                    </div>   

                    <div class="gangguan-tidur">
                        <div class="control-group">
                            <label class="control-label">Gangguan Tidur</label>
                            <div class="controls">
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'gangguan_tidur_tidak_ada', array()); ?> <label>Tidak Ada</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'gangguan_tidur_ada', array()); ?> <label>Ada</label> 
                            </div>
                        </div>
                    </div>   

                    <div class="konsultasi-dengan-psikiater">
                        <div class="control-group">
                            <label class="control-label">Konsultasi dengan Psikiater</label>
                            <div class="controls">
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'konsultasi_psikiater_tidak_ada', array()); ?> <label>Tidak Ada</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'konsultasi_psikiater_ada', array()); ?> <label>Ada</label> 
                            </div>
                        </div>
                    </div>   

                    <div class="tempat-tinggal">
                        <div class="control-group">
                            <label class="control-label">Tempat Tinggal</label>
                            <div class="controls">
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'tempattinggal_rumahpribadi', array()); ?> <label>Rumah Pribadi</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'tempattinggal_rumahkeluarga', array()); ?> <label>Rumah Keluarga</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'tempattinggal_kontrak', array()); ?> <label>Kontrak</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'tempattinggal_panti', array()); ?> <label>Panti</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'tempattinggal_lainnya', array('onclick' => 'tempattinggalLain()')); ?> <label>Lainnya</label> 
                                <?php echo $form->textField($modAsesmenAwalMedis, 'tempattinggal_lainnya_keterangan', array('class' => 'span3', 'readonly' => true)) ?>
                            </div>
                        </div>
                    </div>   

                    <div class="tinggal-bersama">
                        <div class="control-group">
                            <label class="control-label">Tinggal Bersama</label>
                            <div class="controls">
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'tinggalbersama_suamiistri', array()); ?> <label>Suami/Istri</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'tinggalbersama_anak', array()); ?> <label>Anak</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'tinggalbersama_orangtua', array()); ?> <label>Orang Tua</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'tinggalbersama_sendiri', array()); ?> <label>Sendiri</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'tinggalbersama_lainnya', array('onclick' => 'tinggalbersamaLain()')); ?> <label>Lainnya</label> 
                                <?php echo $form->textField($modAsesmenAwalMedis, 'tinggalbersama_lainnya_keterangan', array('class' => 'span3', 'readonly' => true)) ?>
                            </div>
                        </div>
                    </div>   

                    <div class="status-fungsional">
                        <div class="control-group">
                            <label class="control-label">Status Fungsional</label>
                            <div class="controls">
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'statusfungsional_mandiri', array()); ?> <label>Mandiri</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'statusfungsional_ketergantungan', array()); ?> <label>Ketergantungan</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'statusfungsional_tirahbaringparsial', array()); ?> <label>Tirah Baring Parsial</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'statusfungsional_tirahbaringtotal', array()); ?> <label>Tirah Baring Total</label> 
                            </div>
                        </div>
                    </div>  

                    <div>
                        <div class="control-group">
                            <label class="control-label">Penanggung Jawab Perawatan di Rumah (care giving)</label>
                            <div class="controls">
                                <?php echo $form->textField($modAsesmenAwalMedis, 'penanggungjawab_perawatanrumah', array('class' => 'span4')) ?>
                            </div>
                        </div>
                    </div>

                <?php else : ?>

                    <div class="control-group">
                        <?php echo CHtml::label('Riwayat Imunasi', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class="controls" id="cek-imunasi">
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_imunisasi_bcg', array()); ?> <label>BCG</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_imunisasi_polio', array('class' => 'polio')); ?> <label>Polio</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_imunisasi_polio_ket', array('placeholder' => 'Berapa Kali', 'class' => 'span1 numbers-only', 'readonly' => true)) ?>
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_imunisasi_hepatitisb', array('class' => 'hepatitisb')); ?> <label>Hepatitis B</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_imunisasi_hepatitisb_ket', array('placeholder' => 'Berapa Kali', 'class' => 'span1 numbers-only', 'readonly' => true)) ?>
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_imunisasi_dpt', array('class' => 'dpt')); ?> <label>DPT</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_imunisasi_dpt_ket', array('placeholder' => 'Berapa Kali', 'class' => 'span1 numbers-only', 'readonly' => true)) ?>
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_imunisasi_campak', array('class' => 'campak')); ?> <label>Campak</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_imunisasi_campak_ket', array('placeholder' => 'Berapa Kali', 'class' => 'span1 numbers-only', 'readonly' => true)) ?>
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_imunisasi_lainnya', array('class' => 'lainlain')); ?> <label>Lainnya</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_imunisasi_lainnya_ket', array('placeholder' => 'Keterangan Lainnya', 'class' => 'span3', 'readonly' => true)) ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label('', 'riwayat_imunisasi_polio', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_imunisasi_polio', array('onclick' => 'cekRiwayatImunisasi();')); ?> <label>Polio</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_imunisasi_polio_ket', array('class' => 'span1 numbers-only Keterangan Lainnya', 'placeholder' => 'Berapa Kali')) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('', 'riwayat_imunisasi_hepatitisb', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_imunisasi_hepatitisb', array('onclick' => 'cekRiwayatImunisasi();')); ?> <label>Hepatitis B</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_imunisasi_hepatitisb_ket', array('class' => 'span1 numbers-only autogrow', 'placeholder' => 'Berapa Kali')) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('', 'riwayat_imunisasi_dpt', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_imunisasi_dpt', array('onclick' => 'cekRiwayatImunisasi();')); ?> <label>DPT</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_imunisasi_dpt_ket', array('class' => 'span1 numbers-only autogrow', 'placeholder' => 'Berapa Kali')) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('', 'riwayat_imunisasi_campak', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_imunisasi_campak', array('onclick' => 'cekRiwayatImunisasi();')); ?> <label>Campak</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_imunisasi_campak_ket', array('class' => 'span1 numbers-only autogrow', 'placeholder' => 'Berapa Kali')) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('', 'riwayat_imunisasi_lainnya', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_imunisasi_lainnya', array('onclick' => 'cekRiwayatImunisasi();')); ?> <label>Lainnya</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_imunisasi_lainnya_ket', array('class' => 'span1 numbers-only autogrow', 'placeholder' => 'Keterangan Lainnya')) ?>
                        </div>
                    </div>
                <!--</div>-->
                <div class="control-group">
                    <?php echo CHtml::label('Riwayat Persalinan', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                    <div class='controls'>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_persalinan_normal', array()); ?> <label>Normal</label> 
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_persalinan_vacum', array()); ?> <label>Vacum</label> 
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_persalinan_forceps', array()); ?> <label>Forceps</label>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_persalinan_sc', array()); ?> <label>SC</label><br>
                        <div class="riwayat-persalinan">
                            <label>Ditolong Oleh</label>&nbsp;<?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_persalinan_olehdokter', array()); ?> <label>Dokter</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_persalinan_olehbidan', array('class' => 'bidan')); ?> <label>Bidan</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_persalinan_olehlainnya', array('class' => 'lainlain')); ?> <label>Lainnya</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_persalinan_olehlainnya_ket', array('placeholder' => 'Keterangan Lainnya', 'class' => 'span3', 'readonly' => true)) ?><br>
                        </div>
                        <label>Berat Badan</label>&nbsp;<?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_persalinan_beratbadan', array('placeholder' => 'Berat Badan', 'class' => 'span2 numbers-only')) ?><label>gram</label><br>
                        <label>Tinggi Badan</label>&nbsp;<?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_persalinan_tinggibadan', array('placeholder' => 'Tinggi Badan', 'class' => 'span2 numbers-only')) ?><label>cm</label><br>
                        <label>Lingkar Kepala</label>&nbsp;<?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_persalinan_lingkarkepala', array('placeholder' => 'Lingkar Kepala', 'class' => 'span2 numbers-only')) ?><label>cm</label><br>
                        <label>Keadaan saat lahir</label>&nbsp;<?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_persalinan_segeramenangis', array()); ?> <label>Segera Menangis</label> 
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_persalinan_tidaksegeramenangis', array()); ?> <label>Tidak Segera Menangis</label>
                    </div>
                </div>
                <div class="riwayat-nutrisi">
                    <div class="control-group">
                        <?php echo CHtml::label('Riwayat Nutrisi', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                            <label>ASI : </label>&nbsp;<label>Ekslusif</label>&nbsp;<?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_nutrisi_asi_eksklusif', array('placeholder' => 'Berapa Bulan pemberian', 'class' => 'span2 numbers-only')) ?><label>Bulan,</label>
                            <label>Durasi</label>&nbsp;<?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_nutrisi_asi_durasi', array('placeholder' => 'Durasi', 'class' => 'span2 numbers-only')) ?><label>Bulan,</label>
                            <label>Frekuensi</label>&nbsp;<?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_nutrisi_asi_frekuensi', array('placeholder' => 'Durasi', 'class' => 'span2 numbers-only')) ?><label>Kali/Hari</label><br>
                            <label>Susu Formula : </label> &nbsp;<label>Sejak Usia</label>&nbsp;<?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_nutrisi_susuformula_usia', array('placeholder' => 'Berapa Bulan pemberian', 'class' => 'span2 numbers-only')) ?><label>Bulan,</label>
                            <label>Frekuensi</label>&nbsp;<?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_nutrisi_susuformula_frekuensi', array('placeholder' => 'Frekuensi', 'class' => 'span2 numbers-only')) ?><label>Kali/Hari</label><br>
                            <label>Bubur Susu : </label>&nbsp;<label>Sejak Usia</label>&nbsp;<?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_nutrisi_bubutsusu_usia', array('placeholder' => 'Berapa Bulan pemberian', 'class' => 'span2 numbers-only')) ?><label>Bulan,</label>
                            <label>Frekuensi</label>&nbsp;<?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_nutrisi_bubursusu_frekuensi', array('placeholder' => 'Frekuensi', 'class' => 'span2 numbers-only')) ?><label>Kali/Hari</label><br>
                            <label>Nasi Tim : </label>&nbsp;<label>Sejak Usia</label>&nbsp;<?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_nutrisi_nasitim_usia', array('placeholder' => 'Berapa Bulan pemberian', 'class' => 'span2 numbers-only')) ?><label>Bulan,</label>
                            <label>Frekuensi</label>&nbsp;<?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_nutrisi_nasitim_frekuensi', array('placeholder' => 'Frekuensi', 'class' => 'span2 numbers-only')) ?><label>Kali/Hari</label><br>
                            <label>Makanan Dewasa : </label>&nbsp;<label>Sejak Usia</label>&nbsp;<?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_nutrisi_makanandewasa_usia', array('placeholder' => 'Berapa Bulan pemberian', 'class' => 'span2 numbers-only')) ?><label>Bulan,</label>
                            <label>Frekuensi</label>&nbsp;<?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_nutrisi_makanandewasa_frekuensi', array('placeholder' => 'Frekuensi', 'class' => 'span2 numbers-only')) ?><label>Kali/Hari</label><br>
                        </div>
                    </div>
                </div>
                <div id="riwayattumbuh">
                    <div class="control-group">
                        <?php echo CHtml::label('Riwayat Tumbuh Kembang', 'riwayat_tumbuhkembang_menegakkankepala', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_menegakkankepala', array('onclick' => 'cekRiwayatTumbuh();')); ?> <label>Menegakkan Kepala</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_menegakkankepala_ket', array('class' => 'span1 numbers-only Keterangan Lainnya', 'placeholder' => 'Usia')) ?><label>Bulan</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('', 'riwayat_tumbuhkembang_membalikbadan', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_membalikbadan', array('onclick' => 'cekRiwayatTumbuh();')); ?> <label>Membalikan Badan</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_membalikbadan_ket', array('class' => 'span1 numbers-only Keterangan Lainnya', 'placeholder' => 'Usia')) ?><label>Bulan</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('', 'riwayat_tumbuhkembang_duduk', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_duduk', array('onclick' => 'cekRiwayatTumbuh();')); ?> <label>Duduk</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_duduk_ket', array('class' => 'span1 numbers-only autogrow', 'placeholder' => 'Usia')) ?><label>Bulan</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('', 'riwayat_imunisasi_dpt', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_merangkak', array('onclick' => 'cekRiwayatTumbuh();')); ?> <label>Merangkak</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_merangkak_ket', array('class' => 'span1 numbers-only autogrow', 'placeholder' => 'Usia')) ?><label>Bulan</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('', 'riwayat_tumbuhkembang_berdiri', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_berdiri', array('onclick' => 'cekRiwayatTumbuh();')); ?> <label>Berdiri</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_berdiri_ket', array('class' => 'span1 numbers-only autogrow', 'placeholder' => 'Usia')) ?><label>Bulan</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('', 'riwayat_tumbuhkembang_berjalan', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_berjalan', array('onclick' => 'cekRiwayatTumbuh();')); ?> <label>Berjalan</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_berjalan', array('class' => 'span1 numbers-only autogrow', 'placeholder' => 'Usia')) ?><label>Bulan</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('', 'riwayat_tumbuhkembang_bicara', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_bicara', array('onclick' => 'cekRiwayatTumbuh();')); ?> <label>Bicara</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'riwayat_tumbuhkembang_bicara', array('class' => 'span1 numbers-only autogrow', 'placeholder' => 'Usia')) ?><label>Bulan</label>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div id="riwayatalergi">
                <div class="control-group ">
                    <?php echo CHtml::label('Riwayat Alergi', 'riwayatalergi_obat', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayatalergi_obat', array('onclick' => 'cekRiwayatAlergi();')); ?> <label>Alergi Obat</label>                     
                    </div>
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="controls">
                        <?php echo $form->textField($modAsesmenAwalMedis, 'riwayatalergi_obatket', array('class' => 'Keterangan Lainnya', 'placeholder' => 'catatan riwayat alergi obat')) ?>
                    </div>
                </div>      

                <div class="control-group ">
                    <?php echo CHtml::label('', 'riwayatalergi_makanan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'riwayatalergi_makanan', array('onclick' => 'cekRiwayatAlergi();')); ?> <label>Alergi Makanan</label>                     
                    </div>
                    <div class="controls">
                        <?php echo $form->textField($modAsesmenAwalMedis, 'riwayatalergi_makananket', array('class' => 'autogrow', 'placeholder' => 'catatan riwayat alergi makanan')) ?>
                    </div>
                </div>   
            </div>    
        </div>
    </div>
</div>
</div>

<?php
if ($this->module->id == 'hemodialisa') {
    
    echo $this->renderPartial($this->path_view . '_formRiwayatObatHemodialisa', array(
        'modRiwayatObatSblm' => $modRiwayatObatSblm,
        'modAsesmenAwalMedis' => $modAsesmenAwalMedis,
        'form' => $form
            ), true);
} else {
    ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Riwayat Pengobatan Sebelumnya</div>
        </div>
        <div class="panel-body">
            <div class="row-fluid"> 
    <?php
//            if($this->module->id == 'hemodialisa'){
//                echo $this->renderPartial($this->path_view . '_formRiwayatObatHemodialisa', array(
//                    'modRiwayatObatSblm' => $modRiwayatObatSblm,
//                    'form' => $form
//                        ), true);
//                
//            }else{
    echo $this->renderPartial($this->path_view . '_formRiwayatObat', array(
        'modRiwayatObatSblm' => $modRiwayatObatSblm,
        'form' => $form
            ), true);

//            }
    ?>
            </div>
        </div>
    </div>
<?php } ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Pemeriksaan Umum</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid"> 
            <div class="col-sm-12">
                <div class="control-group">
<?php echo CHtml::label('Kesadaran Kualitatif', 'tanggalruangan', array('class' => 'control-label')); ?>
                    <div class='controls'>
                    <?php echo $form->checkBox($modAsesmenAwalMedis, 'kesadarankualitatif_composmentis', array()); ?> <label>Compos Mentis</label> 
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'kesadarankualitatif_apatis', array()); ?> <label>Apatis</label> 
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'kesadarankualitatif_delirum', array()); ?> <label>Delirum</label>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'kesadarankualitatif_koma', array()); ?> <label>Koma</label> 
                    </div>
                </div>                                        

                <div class="control-group">
<?php echo CHtml::label('GCS', 'sesak_nafas', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <label>E</label>
                    </div>
                    <div class="controls">
<?php
$crit = new CDbCriteria();
$crit->compare('LOWER(metodegcs_singkatan)', "e");
$crit->addCondition('metodegcs_nilai is not null');
$crit->order = 'metodegcs_nilai ASC';
echo $form->dropDownList($modAsesmenAwalMedis, 'kesadarankuantitatif_gcs_eye', CHtml::listData(RIMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'hitungCGS()'));
?>

                    </div>

                    <div class="controls">
                        <label>V</label>
                    </div>
                    <div class="controls">
<?php
$crit3 = new CDbCriteria();
$crit3->compare('LOWER(metodegcs_singkatan)', "v");
$crit3->addCondition('metodegcs_nilai is not null');
$crit3->order = 'metodegcs_nilai ASC';
echo $form->dropDownList($modAsesmenAwalMedis, 'kesadarankuantitatif_gcs_verbal', CHtml::listData(RIMetodeGCSM::model()->findAll($crit3), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'hitungCGS()'));
?>
                    </div>

                    <div class="controls">
                        <label>M</label>
                    </div>
                    <div class="controls">
<?php
$crit2 = new CDbCriteria();
$crit2->compare('LOWER(metodegcs_singkatan)', "m");
$crit2->addCondition('metodegcs_nilai is not null');
$crit2->order = 'metodegcs_nilai ASC';
echo $form->dropDownList($modAsesmenAwalMedis, 'kesadarankuantitatif_gcs_motorik', CHtml::listData(RIMetodeGCSM::model()->findAll($crit2), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'hitungCGS()'));
?>
                    </div>
                </div>

                <div class="control-group">
<?php echo CHtml::label('Berat Badan', 'berat_badan', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo $form->textField($modAsesmenAwalMedis, 'beratbadan', array('placeholder' => 'Berat Badan', 'class' => 'span4 float2', 'onkeyup' => 'jumlah(),cekBeratTinggi()')) ?> <label>Kg</label>
                    </div>
                </div>
                <div class="control-group">
<?php echo CHtml::label('Tinggi Badan', 'tinggi_badan', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo $form->textField($modAsesmenAwalMedis, 'tinggibadan', array('placeholder' => 'Tinggi Badan', 'class' => 'span4 numbers-only', 'onkeyup' => 'jumlah(),cekBeratTinggi()')) ?> <label>Cm</label>
                    </div>
                </div>
                <div class="control-group">
<?php echo CHtml::label('Luas Badan', 'luas_badan', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo $form->textField($modAsesmenAwalMedis, 'luasbadan', array('placeholder' => 'Luas Badan', 'class' => 'span4 float2')) ?> <label>Kg/m<sup>2</sup></label>
                    </div>
                </div>
                <div class="control-group">
<?php echo CHtml::label('BMI', 'luas_badan', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo $form->textField($modAsesmenAwalMedis, 'nilai_bmi', array('readonly' => true, 'placeholder' => 'Skor BMI', 'class' => 'span4', 'style' => 'text-align:right;')) ?> 
                        <?php echo $form->hiddenField($modAsesmenAwalMedis, 'bodymassindex_id', array('placeholder' => 'Skor BMI', 'class' => 'span4 numbers-only')) ?> 
                        <?php echo $form->textField($modAsesmenAwalMedis, 'bodymassindex_nama', array('readonly' => true, 'placeholder' => 'Kategori BMI', 'class' => 'span4')) ?> 
                    </div>
                </div>
                <div class="control-group">
<?php echo CHtml::label('Kondisi Khusus', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                    <div class='controls' id="cek-kondisikhusus">
                    <?php echo $form->checkBox($modAsesmenAwalMedis, 'kondisikhusus_normal', array()); ?> <label>Normal</label> 
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'kondisikhusus_anemis', array()); ?> <label>Anemis</label> 
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'kondisikhusus_icterus', array()); ?> <label>Icterus</label>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'kondisikhusus_sianosis', array()); ?> <label>Sianosis</label> 
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'kondisikhusus_lainnya', array('class' => 'lainlain')); ?> <label>Lainnya</label> 
                        <?php echo $form->textField($modAsesmenAwalMedis, 'kondisikhusus_lainnya_ket', array('placeholder' => 'Keterangan Lainnya', 'class' => 'span4', 'readonly' => true)) ?>
                    </div>
                </div>
                <div class="control-group">
<?php echo CHtml::label('Tekanan Darah', 'berat_badan', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo $form->textField($modAsesmenAwalMedis, 'tekanandarah_sistolok', array('placeholder' => 'Tekanan Darah', 'class' => 'span4 numbers-only')) ?> <label> / </label>
                        <?php echo $form->textField($modAsesmenAwalMedis, 'tekanandarah_diastolik', array('placeholder' => 'Tekanan Darah', 'class' => 'span4 numbers-only')) ?> <label>mmHg</label>
                    </div>
                </div>
                <div class="control-group">
<?php echo CHtml::label('Nadi', 'tinggi_badan', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo $form->textField($modAsesmenAwalMedis, 'nadi', array('placeholder' => 'Nadi', 'class' => 'span4 numbers-only')) ?> <label>x/mnt</label>
                    </div>
                </div>
                <div class="control-group">
<?php echo CHtml::label('Pernafasan', 'pernafasan', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo $form->textField($modAsesmenAwalMedis, 'pernafasan', array('placeholder' => 'Pernafasan', 'class' => 'span4 numbers-only')) ?> <label>x/mnt</label>
                    </div>
                </div>
                <div class="control-group">
<?php echo CHtml::label('Suhu', 'suhu', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo $form->textField($modAsesmenAwalMedis, 'suhu', array('placeholder' => 'Suhu', 'class' => 'span4 numbers-only')) ?> <label><sup>o</sup>C (Aksiler/Rectal)</label>
                    </div>
                </div>
                <div class="cekbox-nyeri">
                    <div class="control-group">
<?php echo CHtml::label('Nyeri', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'nyeri_ada', array()); ?> <label>Ya</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'nyeri_tidakada', array()); ?> <label>Tidak</label> 
                        </div>
                    </div> 
                </div>

                <div class="control-group">
                    <label class="control-label">Pilih Semua</label>
                    <div class="controls">
<?php echo CHtml::checkBox("pilihSemuaPeriksaUmum", false, array('onclick' => 'pilihNormal(this);')); ?>
                    </div>
                </div>
                <div class="pemeriksaanumum-normal">                                                
                    <div class="control-group">
<?php echo CHtml::label('Kepala', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'kepala_normal', array('class' => 'pilih-normal', '')); ?> <label>Normal</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'kepala_tidaknormal', array('class' => 'lainlain')); ?> <label>Tidak Normal</label>                        
                            <?php echo $form->textField($modAsesmenAwalMedis, 'kepala_tidaknormal_ket', array('placeholder' => 'Keterangan Tidak Normal', 'class' => 'span4 laintext', 'readonly' => true)) ?>
                        </div>
                    </div> 


                    <div class="control-group">
<?php echo CHtml::label('Mata', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'mata_normal', array('class' => 'pilih-normal')); ?> <label>Normal</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'mata_tidaknormal', array('class' => 'lainlain')); ?> <label>Tidak Normal</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'mata_tidaknormal_ket', array('placeholder' => 'Keterangan Tidak Normal', 'class' => 'span4 laintext', 'readonly' => true)) ?>
                        </div>
                    </div>


                    <div class="control-group">
<?php echo CHtml::label('THT', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'tht_normal', array('class' => 'pilih-normal')); ?> <label>Normal</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'tht_tidaknormal', array('class' => 'lainlain')); ?> <label>Tidak Normal</label>                         
                            <?php echo $form->textField($modAsesmenAwalMedis, 'tht_tidaknormal_ket', array('placeholder' => 'Keterangan THT Tidak Normal', 'class' => 'span4 laintext', 'readonly' => true)) ?>
                        </div>
                    </div>

                    <div class="control-group">
<?php echo CHtml::label('Leher', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'leher_normal', array('class' => 'pilih-normal')); ?> <label>Normal</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'leher_tidaknormal', array('class' => 'lainlain')); ?> <label>Tidak Normal</label>                         
                            <?php echo $form->textField($modAsesmenAwalMedis, 'leher_tidaknormal_ket', array('placeholder' => 'Keterangan Leher Tidak Normal', 'class' => 'span4 laintext', 'readonly' => true)) ?>
                        </div>
                    </div>

                    <div class="control-group">
<?php echo CHtml::label('Mulut', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'mulut_normal', array('class' => 'pilih-normal')); ?> <label>Normal</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'mulut_tidaknormal', array('class' => 'lainlain')); ?> <label>Tidak Normal</label>                         
                            <?php echo $form->textField($modAsesmenAwalMedis, 'mulut_tidaknormal_ket', array('placeholder' => 'Keterangan Mulut Tidak Normal', 'class' => 'span4 laintext', 'readonly' => true)) ?>
                        </div>
                    </div>

                    <div class="control-group">
<?php echo CHtml::label('Jantung & Pembuluh Darah', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'jantung_pb_normal', array('class' => 'pilih-normal')); ?> <label>Normal</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'jantung_pb_tidaknormal', array('class' => 'lainlain')); ?> <label>Tidak Normal</label>                         
                            <?php echo $form->textField($modAsesmenAwalMedis, 'jantung_pb_tidaknormal_ket', array('class' => 'span4 laintext', 'placeholder' => 'Keterangan Jantuk Tidak Normal', 'readonly' => true)) ?>
                        </div>
                    </div>

                    <div class="control-group">
<?php echo CHtml::label('Thorax,Paru2,Payudara', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'thorax_paru_payudara_normal', array('class' => 'pilih-normal')); ?> <label>Normal</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'thorax_paru_payudara_tidaknormal', array('class' => 'lainlain')); ?> <label>Tidak Normal</label>                         
                            <?php echo $form->textField($modAsesmenAwalMedis, 'thorax_paru_payudara_tidaknormal_ket', array('placeholder' => 'Keterangan Tidak Normal', 'class' => 'span4 laintext', 'readonly' => true)) ?>
                        </div>
                    </div>

                    <div class="control-group">
<?php echo CHtml::label('Abdomen', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'abdomen_normal', array('class' => 'pilih-normal')); ?> <label>Normal</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'abdomen_tidaknormal', array('class' => 'lainlain')); ?> <label>Tidak Normal</label>                         
                            <?php echo $form->textField($modAsesmenAwalMedis, 'abdomen_tidaknormal_ket', array('placeholder' => 'Keterangan Abdomen Tidak Normal', 'class' => 'span4 laintext', 'readonly' => true)) ?>
                        </div>
                    </div>

                    <div class="control-group">
<?php echo CHtml::label('Kulit & Sistem Limfatik', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'kulit_normal', array('class' => 'pilih-normal')); ?> <label>Normal</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'kulit_tidaknormal', array('class' => 'lainlain')); ?> <label>Tidak Normal</label>                         
                            <?php echo $form->textField($modAsesmenAwalMedis, 'kulit_tidaknormal_ket', array('placeholder' => 'Keterangan Kulit Tidak Normal', 'class' => 'span4 laintext', 'readonly' => true)) ?>
                        </div>
                    </div>

                    <div class="control-group">
<?php echo CHtml::label('Tulang Belakang dan Anggota Tubuh', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'tulang_anggotatubuh_normal', array('class' => 'pilih-normal')); ?> <label>Normal</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'tulang_anggotatubuh_tidaknormal', array('class' => 'lainlain')); ?> <label>Tidak Normal</label>                         
                            <?php echo $form->textField($modAsesmenAwalMedis, 'tulang_anggotatubuh_tidaknormal_ket', array('placeholder' => 'Keterangan Tulang Tidak Normal', 'class' => 'span4 laintext', 'readonly' => true)) ?>
                        </div>
                    </div>

                    <div class="control-group">
<?php echo CHtml::label('Sistem Saraf', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'sistemsaraf_normal', array('class' => 'pilih-normal')); ?> <label>Normal</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'sistemsaraf_tidaknormal', array('class' => 'lainlain')); ?> <label>Tidak Normal</label>                         
                            <?php echo $form->textField($modAsesmenAwalMedis, 'sistemsaraf_tidaknormal_ket', array('placeholder' => 'Keterangan Sistem Tidak Normal', 'class' => 'span4 laintext', 'readonly' => true)) ?>
                        </div>
                    </div>

                    <div class="control-group">
<?php echo CHtml::label('Genitalia,Anus dan rektum', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'genitalia_normal', array('class' => 'pilih-normal')); ?> <label>Normal</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'genitalia_tidaknormal', array('class' => 'lainlain')); ?> <label>Tidak Normal</label>                         
                            <?php echo $form->textField($modAsesmenAwalMedis, 'genitalia_tidaknormal_ket', array('placeholder' => 'Ginitalia Tidak Normal', 'class' => 'span4 laintext', 'readonly' => true)) ?>
                        </div>
                    </div>
                    <div class="form-cek-lis has-delete">
                    <?= $this->renderPartial($this->path_view.'form/_form_akses_vaskuler',['modVas'=>$modVas,'model'=>$modAsesmenAwalMedis]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (Yii::app()->controller->id == 'asesmenAwalMedisDewasaHD') : ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Status Gizi / Nutrisi</div>
        </div>
        <div class="panel-body">
            <div class="row-fluid"> 
                <div class="col-sm-12">
                    <table class="table table-striped">
                        <tr>
                            <th>Status Gizi/Nutrisi</th>
                            <th>Penilaian</th>
                        </tr>
                        <tr>
                            <td>1. Pasien kehilangan berat badan 5% dalam waktu 3 bulan terakhir ?</td>
                            <td>
                                <?php echo CHtml::radioButton('statusgizi_kehilanganberatbadan', '', array('value' => 1, 'unCheckValue' => null, 'onclick' => 'cekStatusGizi()')); ?> <label>Ya</label> 
                                <?php echo CHtml::radioButton('statusgizi_kehilanganberatbadan', '', array('value' => 0, 'unCheckValue' => null, 'onclick' => 'cekStatusGizi()', 'checked' => 'checked')); ?> <label>Tidak</label>
                            </td>
                        </tr>
                        <tr>
                            <td>2. Asupan makan pasien kurang dalam 1 minggu terakhir ?</td>
                            <td>
                                <?php echo CHtml::radioButton('statusgizi_asupanmakankurang', '', array('value' => 1, 'unCheckValue' => null, 'onclick' => 'cekStatusGizi()')); ?> <label>Ya</label> 
                                <?php echo CHtml::radioButton('statusgizi_asupanmakankurang', '', array('value' => 0, 'unCheckValue' => null, 'onclick' => 'cekStatusGizi()', 'checked' => true)); ?> <label>Tidak</label>
                            </td>
                        </tr>
                        <tr>
                            <td>3. Pasien menderita penyakit yang berat ?</td>
                            <td>
                                <?php echo CHtml::radioButton('statusgizi_menderitapenyakitberat', '', array('value' => 1, 'unCheckValue' => null, 'onclick' => 'cekStatusGizi()')); ?> <label>Ya</label> 
                                <?php echo CHtml::radioButton('statusgizi_menderitapenyakitberat', '', array('value' => 0, 'unCheckValue' => null, 'onclick' => 'cekStatusGizi()', 'checked' => true)); ?> <label>Tidak</label>
                            </td>
                        </tr>
                    </table><br>
                    <label id="statusPasien" style="font-weight: bold; color: red; font-size: 20px;"><i>Pasien harus konsultasi gizi</i></label>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Status Lokalis</div>
    </div>
    <div class="panel-body">
<?php
echo $this->renderPartial($this->path_view . '_formStatusLokalis', array(
    'form' => $form,
//                                                'model'=>$model,  
    'modGambarTubuh' => $modGambarTubuh,
    'modPemeriksaanGambar' => $modPemeriksaanGambar
        ), true);
?> 
    </div>
</div>
<?php if (Yii::app()->controller->id != 'asesmenAwalMedisDewasaHD') : ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Status Neurologis</div>
        </div>
        <div class="panel-body">
            <div class="row-fluid"> 
                <div class="col-sm-12">
                    <div class="cekbox-reflekfisiologis">
                        <div class="control-group">
    <?php echo CHtml::label('Reflek Fisiologi', 'fisiologi', array('class' => 'control-label')); ?>
                            <div class='controls'>
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'statusneurologis_reflekfisiologis_babinsky', array()); ?> <label>Bobinsky</label> 
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'statusneurologis_reflekfisiologis_moro', array()); ?> <label>Moro</label> 
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
    <?php echo CHtml::label('Reflek Pathologis', 'pathologis', array('class' => 'control-label')); ?>
                        <div class='controls' id='cek-reflekpathologis'>
                        <?php echo $form->checkBox($modAsesmenAwalMedis, 'statusneurologis_reflekpathologis_babinsky', array()); ?> <label>Bobinsky</label> 
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'statusneurologis_reflekpathologis_clonus', array()); ?> <label>Clonus</label>
                            <?php echo $form->checkBox($modAsesmenAwalMedis, 'statusneurologis_reflekpathologis_lainlain', array('class' => 'lainlainreflekpathologis')); ?> <label>Lainnya</label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'statusneurologis_reflekpathologis_lainlainket', array('placeholder' => 'Keterangan Lainnya', 'class' => 'span4', 'readonly' => true)) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Arthopometri</div>
        </div>
        <div class="panel-body">
            <div class="row-fluid"> 
                <div class="col-sm-12">
                    <div class="control-group">
    <?php echo CHtml::label('Berat Badan/Usia', 'atropometri_beratbadan', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textField($modAsesmenAwalMedis, 'atropometri_beratbadan', array('placeholder' => 'Berat Badan', 'class' => 'span3 numbers-only', 'onkeyup' => "beratBadan(this)")) ?> <label> Kg </label> <label> / </label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'atropometri_usia', array('placeholder' => 'Usia', 'onkeypress' => "return $(this).focusNextInputField(event);", 'class' => 'span3 numbers-only'));
                            ?> <label> Tahun </label>
                        </div>
                    </div>
                    <div class="control-group">
    <?php echo CHtml::label('Tinggi Badan/Usia', 'atropometri_tinggibadan', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textField($modAsesmenAwalMedis, 'atropometri_tinggibadan', array('placeholder' => 'Tinggi Badan', 'class' => 'span3 numbers-only', 'onkeyup' => "tinggiBadan(this)")) ?> <label> Cm </label> <label> / </label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'atropometri_usia', array('placeholder' => 'Usia', 'onkeypress' => "return $(this).focusNextInputField(event);", 'class' => 'span3 numbers-only'));
                            ?> <label> Tahun </label>
                        </div>
                    </div>
                    <div class="control-group">
    <?php echo CHtml::label('Berat Badan/Tinggi Badan', 'berat_badan', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textField($modAsesmenAwalMedis, 'atropometri_beratbadan2', array('placeholder' => 'Berat Badan', 'class' => 'span3 numbers-only')) ?> <label> Kg </label> <label> / </label>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'atropometri_tinggibadan2', array('placeholder' => 'Tinggi Badan', 'class' => 'span3 numbers-only')) ?> <label> Cm </label>
                        </div>
                    </div>
                    <div class="control-group">
    <?php echo CHtml::label('Berat Badan Ideal', 'berat_badan', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textField($modAsesmenAwalMedis, 'atropometri_beratbadanideal', array('placeholder' => 'Berat Badan Ideal', 'class' => 'span3 numbers-only')) ?> <label>gram</label>
                        </div>
                    </div>
                    <div class="control-group">
    <?php echo CHtml::label('Status Nutrisi', 'atropometri_statusnutris', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textField($modAsesmenAwalMedis, 'atropometri_statusnutris', array('placeholder' => 'Status Nutrisi', 'class' => 'span3 numbers-only')) ?> <label>%</label>
                        </div>
                    </div>
                    <div class="control-group">
    <?php echo CHtml::label('Lingkar Kepala', 'atropometri_lingkarkepala', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textField($modAsesmenAwalMedis, 'atropometri_lingkarkepala', array('placeholder' => 'Lingkar Kepala', 'class' => 'span3 numbers-only')) ?>
                        </div>
                    </div>
                    <div class="control-group">
    <?php echo CHtml::label('Lingka Dada', 'atropometri_lingkardada', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textField($modAsesmenAwalMedis, 'atropometri_lingkardada', array('placeholder' => 'Lingkar Dada', 'class' => 'span3 numbers-only')) ?>
                        </div>
                    </div>
                    <div class="control-group">
    <?php echo CHtml::label('Lingkar Lengan Atas', 'atropometri_lingkarlenganatas', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textField($modAsesmenAwalMedis, 'atropometri_lingkarlenganatas', array('placeholder' => 'Lingkar Lengan Atas', 'class' => 'span3 numbers-only')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="panel panel-success">
    <div class="panel-heading">
<?php if (Yii::app()->controller->id == 'asesmenAwalMedisDewasaHD') : ?>
            <div class="panel-title">Pemeriksaan Tambahan</div>
        <?php else : ?>
            <div class="panel-title">Pemeriksaan Penunjang</div>
        <?php endif; ?>
    </div>
    <div class="panel-body">
<?php if ($this->module->id == 'hemodialisa') : ?>
            <?= $this->renderPartial($this->path_view . '_formPemeriksaanPenunjang', array('modAsesmenAwalMedis' => $modAsesmenAwalMedis, 'loadHasilPemeriksaanRad' => $loadHasilPemeriksaanRad, 'loadHasilPemeriksaanLab' => $loadHasilPemeriksaanLab,'modLabEks'=>$modLabEks)) ?>
        <?php else : ?>
            <div class="row-fluid"> 
                <div class="col-sm-12">
    <?php if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RJ) { ?>
                        <div class="control-group">
                        <?php echo CHtml::label('Pemeriksaan Penunjang', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                            <div class='controls'>
                            <?php echo $form->textArea($modAsesmenAwalMedis, 'pemeriksaanpenunjang_ket', array('placeholder' => 'Pemeriksaan Penunjang', 'class' => 'span4 laintext', 'readonly' => false)) ?>
                            </div>
                        </div>
    <?php } else { ?>
                        <div class="lab">
                            <div class="control-group">
        <?php echo CHtml::label('Laboratorium', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                                <div class='controls'>
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'laboratorium_normal', array()); ?> <label>Normal</label> 
                                    <?php echo $form->checkBox($modAsesmenAwalMedis, 'laboratorium_tidaknormal', array('class' => 'tidak-normal-lab')); ?> <label>Tidak Normal</label>                         
                                    <?php echo $form->textField($modAsesmenAwalMedis, 'laboratorium_tidaknormal_ket', array('placeholder' => 'Keterangan Tidak Normal', 'class' => 'span4', 'readonly' => true)) ?>
                                </div>
                            </div>
                        </div>
                        <div class="rad">
                            <div class="control-group">
        <?php echo CHtml::label('Radiologi', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                                <div class='controls'>

                                </div>
                            </div>
                        </div>
                        <div class="thorax">    
                            <div class="control-group">
        <?php echo CHtml::label('1. Thorax Foto', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                                <div class='controls'>
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'radiologi_thorax_normal', array()); ?> <label>Normal</label> 
                                    <?php echo $form->checkBox($modAsesmenAwalMedis, 'radiologi_thorax_tidaknormal', array('class' => 'tidak-normal-thorax')); ?> <label>Tidak Normal</label>                         
                                    <?php echo $form->textField($modAsesmenAwalMedis, 'radiologi_thorax_tidaknormal_ket', array('placeholder' => 'Keterangan Tidak Normal', 'class' => 'span4', 'readonly' => true)) ?>
                                </div>
                            </div>
                        </div>
                        <div class="ctscan">
                            <div class="control-group">
        <?php echo CHtml::label('2. CT Scan', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                                <div class='controls'>
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'radiologi_ctscan_normal', array()); ?> <label>Normal</label> 
                                    <?php echo $form->checkBox($modAsesmenAwalMedis, 'radiologi_ctscan_tidaknormal', array('class' => 'tidak-normal-ctscan')); ?> <label>Tidak Normal</label>                         
                                    <?php echo $form->textField($modAsesmenAwalMedis, 'radiologi_ctscan_tidaknormal_ket', array('placeholder' => 'Keterangan Tidak Normal', 'class' => 'span4', 'readonly' => true)) ?>
                                </div>
                            </div>
                        </div>
                        <div class="mri">
                            <div class="control-group">
        <?php echo CHtml::label('3. MRI', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                                <div class='controls'>
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'radiologi_mri_normal', array()); ?> <label>Normal</label> 
                                    <?php echo $form->checkBox($modAsesmenAwalMedis, 'radiologi_mri_tidaknormal', array('class' => 'tidak-normal-mri')); ?> <label>Tidak Normal</label>                         
                                    <?php echo $form->textField($modAsesmenAwalMedis, 'radiologi_mri_tidaknormal_ket', array('placeholder' => 'Keterangan Tidak Normal', 'class' => 'span4', 'readonly' => true)) ?>
                                </div>
                            </div>
                        </div>
                        <div class="usg">
                            <div class="control-group">
        <?php echo CHtml::label('4. USG', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                                <div class='controls'>
                                <?php echo $form->checkBox($modAsesmenAwalMedis, 'radiologi_usg_normal', array()); ?> <label>Normal</label> 
                                    <?php echo $form->checkBox($modAsesmenAwalMedis, 'radiologi_usg_tidaknormal', array('class' => 'tidak-normal-usg')); ?> <label>Tidak Normal</label>                         
                                    <?php echo $form->textField($modAsesmenAwalMedis, 'radiologi_usg_tidaknormal_ket', array('placeholder' => 'Keterangan Tidak Normal', 'class' => 'span4', 'readonly' => true)) ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
        <?php echo CHtml::label('5. Lain-lain', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                            <div class='controls'>
                            <?php echo $form->textField($modAsesmenAwalMedis, 'radiologi', array('placeholder' => 'Lain-Lain', 'class' => 'span6')) ?>
                            </div>
                        </div>
    <?php } ?>
                    <div class="control-group">
                    <?php echo $form->labelEx($modAsesmenAwalMedis, 'diagnosisawal', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modAsesmenAwalMedis,
                            'attribute' => 'diagnosisawal',
                            'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('daftarKeperawatan') . '",
                                            dataType: "json",
                                                data: {
                                                    term: request.term,
                                                    tipe: 1,
                                            },
                                                success: function (data) {
                                                response(data);
                                        }
                                         })
                                        }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                                    $(this).val(ui.item.value);
                                                    return false;
                                        }',
                                'select' => 'js:function( event, ui ) {
//                                          $("#InfokunjunganriV_no_pendaftaran").val(ui.item.no_pendaftaran);
                                            return false;
                                        }',
                            ),
                            'htmlOptions' => array('placeholder' => 'Diagnosa', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 required'),
                            'tombolDialog' => array('idDialog' => 'daftardiagnosa-dialog'),
                        ));
                        ?>
                        </div>
                    </div> 
                    <div class="control-group">
    <?php echo CHtml::label('Diagnosa Banding', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->textArea($modAsesmenAwalMedis, 'diagnosisbanding', array('placeholder' => 'Diagnosa Banding', 'class' => 'span4')) ?>
                        </div>
                    </div>
                </div>
            </div>
<?php endif; ?>
    </div>
</div>
        <?php if ($this->module->id == 'hemodialisa') : ?>
    <?php $this->renderPartial($this->path_view . '_formDiagnosis', array('modPasienMorbiditas' => $modPasienMorbiditas, 'form' => $form)); ?>
<?php endif; ?>
<div class="panel panel-success">
    <div class="panel-body">
        <div class="row-fluid"> 
            <div class="col-sm-6">
                <div class="control-group">
<?php echo CHtml::label('PPDS', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php
                    echo $form->hiddenField($modAsesmenAwalMedis, 'ppds_id', array());
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'ppds_nama',
                        'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('/ActionAutoComplete/PPDSPelayanan') . '",
                                            dataType: "json",
                                                data: {
                                                    term: request.term,
                                            },
                                                success: function (data) {
                                                response(data);
                                        }
                                         })
                                        }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.ppds_nama);
                                            $("#RIAsesmenAwalMedisT_ppds_id").val(ui.item.ppds_id);
                                            return false;
                                        }',
                        ),
                        'htmlOptions' => array('placeholder' => 'Ketik Nama PPDS', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 '),
                        'tombolDialog' => array('idDialog' => 'dokterpemeriksa-dialog'),
                    ));
                    ?>
                    </div>
                </div>  

            </div>
            <div class='col-sm-6'>
                <div class="control-group">
<?php echo $form->labelEx($modAsesmenAwalMedis, 'dokterdpjp_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php
                    echo $form->hiddenField($modAsesmenAwalMedis, 'dokterdpjp_id', array('readonly' => true));
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'dokterdpjp_nama',
                        'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('daftarDokter') . '",
                                            dataType: "json",
                                                data: {
                                                    term: request.term,
                                                    tipe: 1,
                                            },
                                                success: function (data) {
                                                response(data);
                                        }
                                         })
                                        }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                                    $(this).val(ui.item.value);
                                                    return false;
                                        }',
                            'select' => 'js:function( event, ui ) {
//                                          $("#InfokunjunganriV_no_pendaftaran").val(ui.item.no_pendaftaran);
                                            
                                            return false;
                                        }',
                        ),
                        'htmlOptions' => array('placeholder' => 'Ketik Nama DPJP', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 required'),
                        'tombolDialog' => array('idDialog' => 'dokterdpjp-dialog'),
                    ));
                    ?>
                    </div>
                </div>  

            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
<?php
if ($modAsesmenAwalMedis->isNewRecord) {
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => false));
    echo "&nbsp;";
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false;", 'disabled' => 'true', 'style' => 'cursor:not-allowed;'));
} else {
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => false));
    echo "&nbsp;";
    if (!isset($_GET['id'])) {
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false;", 'disabled' => 'true', 'style' => 'cursor:not-allowed;'));
    } else {
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print($modAsesmenAwalMedis->asesmen_awal_medis_id);return false", 'enabled' => 'true'));
    }
}
?>
                <?php
                $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
                $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                ?>
            </div>
        </div>
    </div>
</div>
                <?php $this->endWidget(); ?>
<script>
//    function print() {
//        window.open('<?php //echo $this->createUrl('printAnak', array('id' => $modAsesmenAwalMedis->asesmen_awal_medis_id));  ?>', 'printwin', 'left=100,top=100,width=640,height=480');
//    }

    function print(id) {
        window.open('<?php echo $this->createUrl('print'); ?>&id=' + id, 'printwin', 'left=100,top=100,width=640,height=480');

    }

</script>

<?php
//========= Dialog buat Diagnosa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'diagnosa-dialog',
    'options' => array(
        'title' => 'Pencarian Data Diagnosa Penyakit Terdahulu',
        'autoOpen' => false,
        'position' => ['top', 10],
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modDataDiagnosaPenyakitTerdahulu = new RIDiagnosaM('searchDiagnosis');
$modDataDiagnosaPenyakitTerdahulu->unsetAttributes();
if (isset($_GET['RIDiagnosaM'])) {
    $modDataDiagnosaPenyakitTerdahulu->attributes = $_GET['RIDiagnosaM'];
    $modDataDiagnosaPenyakitTerdahulu->diagnosa_nama = (isset($_GET['RIDiagnosaM']['diagnosa_nama']) ? $_GET['RIDiagnosaM']['diagnosa_nama'] : "");
    $modDataDiagnosaPenyakitTerdahulu->diagnosa_namalainnya = (isset($_GET['RIDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RIDiagnosaM']['diagnosa_namalainnya'] : "");
    $modDataDiagnosaPenyakitTerdahulu->diagnosa_kode = (isset($_GET['RIDiagnosaM']['diagnosa_kode']) ? $_GET['RIDiagnosaM']['diagnosa_kode'] : "");
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-grid',
    'dataProvider' => $modDataDiagnosaPenyakitTerdahulu->searchDiagnosis(),
    'filter' => $modDataDiagnosaPenyakitTerdahulu,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
                                                  $(\"#diagnosa-dialog\").dialog(\"close\");    
                                                  $(\"#RIAsesmenAwalMedisT_diagnosa_nama\").val(\"$data->diagnosa_nama\");  
                                                  $(\"#RIAsesmenAwalMedisT_diagnosa_id\").val(\"$data->diagnosa_id\");
                                                  $(\"#RIAsesmenAwalMedisT_riwayat_penyakit_sekarang\").blur();
                                        "))',
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',
    // 'diagnosa_katakunci',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<!--//dialog dokter pemeriksa-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dokterpemeriksa-dialog',
    'options' => array(
        'title' => 'Daftar Dokter Pemeriksa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modDokter = new PpdsM('search');
$modDokter->unsetAttributes();
if (isset($_GET['PpdsM'])) {
    $modDokter->attributes = $_GET['PpdsM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengajukandokter-m-grid',
    'dataProvider' => $modDokter->searchDialogPPDS(),
    'filter' => $modDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"
                            $(\"#ppds_nama\").val(\"$data->ppds_nama\");
                            $(\"#RIAsesmenAwalMedisT_ppds_id\").val(\"$data->ppds_id\");
                            $(\"#dokterpemeriksa-dialog\").dialog(\"close\");
                            $(\"#RIAsesmenAwalMedisT_riwayat_penyakit_sekarang\").blur();
                            return false;"
                ))'
        ),
        array(
            'header' => 'Nama PPDS',
            'name' => 'ppds_nama',
            'value' => '$data->ppds_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>


<!--//dialog dokter DPJP-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dokterdpjp-dialog',
    'options' => array(
        'title' => 'Daftar Dokter DPJP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'position' => ['top', 2600],
        'resizable' => false,
    ),
));

$modDokter = new PegawairuanganV();
$modDokter->unsetAttributes();
$modDokter->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP;
if (isset($_GET['PegawairuanganV'])) {
    $modDokter->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengajukan-m-grid',
    'dataProvider' => $modDokter->searchDialogPegRuangan(),
    'filter' => $modDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"
                            $(\"#dokterdpjp_nama\").val(\"$data->nama_pegawai\");
                            $(\"#RIAsesmenAwalMedisT_dokterdpjp_id\").val(\"$data->pegawai_id\");
                            $(\"#dokterdpjp-dialog\").dialog(\"close\");
                            $(\"#RIAsesmenAwalMedisT_riwayat_penyakit_sekarang\").blur();
                            return false;"
                ))'
        ),
        array(
            'name' => 'nomorindukpegawai',
            'header' => 'NIP',
        ),
        array(
            'header' => 'Nama Dokter',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'name' => 'jabatan_id',
            'header' => 'Jabatan',
            'value' => function($data) {
                $modul = JabatanM::model()->findByPk($data->jabatan_id);
                if (!empty($modul)) {
                    return $modul->jabatan_nama;
                }
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll(), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'daftardiagnosa-dialog',
    'options' => array(
        'title' => 'Daftar Diagnosa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'position' => ['top', 2600],
        'resizable' => false,
    ),
));

$modDiagnosa = new DiagnosaM('search');
$modDiagnosa->unsetAttributes();
if (isset($_GET['DiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['DiagnosaM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftardiagnosa-m-grid',
    'dataProvider' => $modDiagnosa->search(),
    'filter' => $modDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectDaftarDiagnosa",
                "onClick"=>"
                            $(\"#RIAsesmenAwalMedisT_diagnosisawal\").val(\"$data->diagnosa_nama\");
                            $(\"#daftardiagnosa-dialog\").dialog(\"close\");
                            return false;"
                ))'
        ),
        array(
            'name' => 'diagnosa_kode',
            'header' => 'Kode Diagnosa',
        ),
        array(
            'header' => 'Diagnosa',
            'name' => 'diagnosa_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'KonsultanNefrologidialog',
    'options' => array(
        'title' => 'Daftar Konsultan Nefrologi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'position' => ['top', 2600],
        'resizable' => false,
    ),
));

$modPegawai = new PegawaiM('searchPegawai');
$modPegawai->unsetAttributes();
if (isset($_GET['PegawaiM'])) {
    $modPegawai->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'konsultannefroogi-m-grid',
    'dataProvider' => $modPegawai->searchPegawai(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectKonsultanNefrologi",
                "onClick"=>"
                            $(\"#RIAsesmenAwalMedisT_konsultan_nefrologi_id\").val(\"$data->pegawai_id\");
                            $(\"#RIAsesmenAwalMedisT_konsultan_nefrologi_nama\").val(\"$data->nama_pegawai\");
                            $(\"#KonsultanNefrologidialog\").dialog(\"close\");
                            return false;"
                ))'
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
        ),
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama Pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'Diagnosadialog',
    'options' => array(
        'title' => 'Daftar Diagnosis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'position' => ['top', 2600],
        'resizable' => false,
    ),
));

$modDokter = new DiagnosaM();
$modDokter->unsetAttributes();
if (isset($_GET['DiagnosaM'])) {
    $modDokter->attributes = $_GET['DiagnosaM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-m-grid',
    'dataProvider' => $modDokter->searchDialog(),
    'filter' => $modDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"
                            set_diagnosis();
                            $(\"#PasienmorbiditasT_diagnosa_kode\").val(\"$data->diagnosa_kode\");
                            $(\"#PasienmorbiditasT_diagnosa_nama1\").val(\"$data->diagnosa_nama\");
                            $(\"#PasienmorbiditasT_diagnosa_nama\").val(\"$data->diagnosa_nama\");
                            $(\"#PasienmorbiditasT_diagnosa_id\").val(\"$data->diagnosa_id\");
                            $(\"#Diagnosadialog\").dialog(\"close\");
                            return false;"
                ))'
        ),
        array(
            'name' => 'diagnosa_kode',
            'header' => 'Kode Diagnosis',
        ),
        array(
            'header' => 'Nama Diagnosis',
            'name' => 'diagnosa_nama',
            'value' => '$data->diagnosa_nama',
        ),
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php $this->renderPartial($this->path_view . '_jsFunctions', array(
    'modLabEks'=>$modLabEks,
    'modPasienMorbiditas'=>$modPasienMorbiditas,
    'modBagianTubuh' => $modBagianTubuh, 'modAsesmenAwalMedis' => $modAsesmenAwalMedis, 'modRiwayatObatSblm' => $modRiwayatObatSblm, 'modPemeriksaanGambar' => $modPemeriksaanGambar, 'modPendaftaran' => $modPendaftaran, 'modPasienAdmisi' => $modPasienAdmisi, 'instalasi_asal' => $instalasi_asal, 'dokter' => $dokter, 'dpjp' => $dpjp, 'ppds' => $ppds)); ?>