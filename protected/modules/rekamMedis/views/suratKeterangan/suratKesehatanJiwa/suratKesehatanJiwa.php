<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);


$format = new MyFormatter();
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
if (!empty($_GET['pendaftaran_id'])) {
    $pendaftaran_id = $_GET["pendaftaran_id"];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $periksaFisik = PemeriksaanfisikT::model()->findByAttributes(array(
        'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
    ), array(
        'order' => 'tglperiksafisik desc',
    )) ?? new PemeriksaanfisikT;

    // $model->mengetahui_surat = $modPendaftaran->pegawai->nama_pegawai;
    if (!empty($modPendaftaran->pasienadmisi_id)) {
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        // $model->mengetahui_surat = (isset($modAdmisi->pasienadmisi_id) ? $modAdmisi->pegawai->nama_pegawai : "");
    } else {
        $modAdmisi = new PasienadmisiT;
        $modAdmisi->tgladmisi = date('Y-m-d') . " 00:00:00";
        $modAdmisi->tglpulang = date('Y-m-d') . " 00:00:00";
    }
} else {
    $model->tglsurat = date('Y-m-d');
    $periksaFisik = new PemeriksaanfisikT;
}
if (!empty($_GET['suratketerangan_id'])) {
    $model = SuratketeranganR::model()->findByPk($_GET['suratketerangan_id']);
    // $model->hasilperiksajiwa = CJSON::decode($model->hasilperiksajiwa) ?? array();
}

// if ($model->isNewRecord) {
//     $model->tekanandarah_sistolik = $periksaFisik->td_systolic;
//     $model->tekanandarah_diastolik = $periksaFisik->td_diastolic;
//     // $model->nadi = $periksaFisik->detaknadi;
//     // $model->pernafasan = $periksaFisik->pernapasan;
//     // $model->suhu_badan = $periksaFisik->suhutubuh;
//     // $model->beratbadan = $periksaFisik->beratbadan_kg;
//     // $model->tinggibadan = $periksaFisik->tinggibadan_cm;
// }

// $model->suhu_badan = empty($model->suhu_badan) ? "" : number_format($model->suhu_badan, 2, ",", "");
// $model->beratbadan = empty($model->beratbadan) ? "" : number_format($model->beratbadan, 2, ",", "");
// $model->tinggibadan = empty($model->tinggibadan) ? "" : number_format($model->tinggibadan, 2, ",", "");



?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p {
        text-indent: 50px;
        text-align: justify;
    }

    .add-on {
        border: #ddd 1px solid;
        padding: 6px;
        border-radius: 5px;
    }

    .table-checklist {
        border: #000 1px solid;
        padding: 6px;
    }

    .table-checklist tr>td {
        padding: 6px;
    }

    .table-checklist .btm {
        padding: 6px;
        border-bottom: #000 1px solid;
    }

    .table-checklist .bord {
        border-left: #000 1px solid;
        border-right: #000 1px solid;
        text-align: center;
        padding: 6px;
    }

    #txt_tanggal .input-append {
        display: inline-block;
    }
</style>
<div>
    <div>
        <TABLE ALIGN="CENTER" style="margin-left:100px; text-align: center;">
            <tr>
                <td ALIGN="CENTER" VALIGN="MIDDLE">
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo $model->judulsurat; ?></U></span></B>
                </td>
            </tr>
            <tr>
                <td ALIGN="CENTER" VALIGN="MIDDLE">
                    <B><span FACE="Liberation Serif" SIZE=4>No.<?php echo CHtml::activeTextField($model, 'nomorsurat', array(
                                                                    'readonly' => true,
                                                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                                                )); ?></span></B>

                    <?php
                    // echo CHtml::activeTextField($model, 'suratketerangan_id', array());
                    ?>
                </td>
            </tr>
        </TABLE>
    </div>
    <br><br><br><br>
    <p align="justify">
        Yang bertanda tangan dibawah ini menerangkan bahwa :
    </p>
    <table width="100%" style="width:500px;margin-left:80px;">
        <tr>
            <td width="150">Nama</td>
            <td width="10">:</td>
            <!-- <td><?php //echo CHtml::activeTextField($model, 'kepadayth', array('readonly'=>false,
                        //'onkeypress'=>"return $(this).focusNextInputField(event)")); 
                        ?></td> -->
            <td><?php echo CHtml::textField('nama_pegawai', "", array(
                    'readonly' => true,
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                )); ?>
            </td>
        </tr>
        <tr>
            <td width="150">SIP</td>
            <td width="10">:</td>
            <td><?php echo CHtml::textField('sip', "", array(
                    'readonly' => true,
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                )); ?>
            </td>
        </tr>
        <tr>
            <td width="150">Jabatan</td>
            <td width="10">:</td>
            <td><?php echo CHtml::textField('jabatan', "", array(
                    'readonly' => true,
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                )); ?>
            </td>
        </tr>
        <tr>
            <td width="150">Instansi</td>
            <td width="10">:</td>
            <td><?php echo CHtml::textField('instansi', "", array(
                    'readonly' => true,
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                )); ?>
            </td>
        </tr>
    </table>
    <table width="100%" style="width:500px;margin-left:50px;">
        <tr>
            <td width="180">Atas permintaan dari</td>
            <td width="10">:</td>
            <td>
                <div class="controls">
                    <?php
                    echo CHtml::dropDownList('permintaandari', 'Permintaandari', array('Diri Sendiri' => 'Diri Sendiri', 'Instansi' => 'Instansi'), array(
                        'class' => 'span3', 'onchange' => 'setInstansiDiri()'
                    ));
                    ?>
                </div>
            </td>
        </tr>
    </table>
    <div class="control-group" id="instansidiri" style="display:none;">
        <div class="controls">
            <table width="100%" style="width:500px;margin-left:80px;">
                <tr>
                    <td width="150">Nama</td>
                    <td width="10">:</td>
                    <!-- <td><?php //echo CHtml::activeTextField($model, 'kepadayth', array('readonly'=>false,
                                //'onkeypress'=>"return $(this).focusNextInputField(event)")); 
                                ?></td> -->
                    <td><?php echo CHtml::textField('nama_pegawai_instansi', $model->nama_pegawai_instansi, array(
                            'readonly' => false,
                            'onkeypress' => "return $(this).focusNextInputField(event)"
                        )); ?>
                    </td>
                </tr>
                <tr>
                    <td width="150">Jabatan</td>
                    <td width="10">:</td>
                    <td><?php echo CHtml::textField('jabatan_instansi', $model->jabatan_instansi, array(
                            'readonly' => false,
                            'onkeypress' => "return $(this).focusNextInputField(event)"
                        )); ?>
                    </td>
                </tr>
                <tr>
                    <td width="150">Instansi</td>
                    <td width="10">:</td>
                    <td><?php echo CHtml::textField('instansi_instansi', $model->instansi_instansi, array(
                            'readonly' => false,
                            'onkeypress' => "return $(this).focusNextInputField(event)"
                        )); ?>
                    </td>
                </tr>
                <tr>
                    <td width="150">Perihal</td>
                    <td width="10">:</td>
                    <td><?php echo CHtml::textField('perihal_instansi', $model->perihal_instansi, array(
                            'readonly' => false,
                            'onkeypress' => "return $(this).focusNextInputField(event)"
                        )); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br />
    <div style="text-align: justify; margin-left: 50px;" id="txt_tanggal">
        Telah melakukan pemeriksaan psikiatrik pada tanggal
        <?php
        $model->tgl_periksa = $format->formatDateTimeForUser($model->tgl_periksa ?? date('Y-m-d'));
        $this->widget('MyDateTimePicker', array(
            'model' => $model,
            'attribute' => 'tgl_periksa',
            'mode' => 'date',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                //                                            'maxDate' => 'd',
            ),
            'htmlOptions' => array(
                'readonly' => true, 'class' => 'span2',
                'onkeypress' => "return $(this).focusNextInputField(event)"
            ),
        ));
        ?>
        terhadap :
    </div></br>
    <table width="100%" style="width:500px;margin-left:80px;">
        <tr>
            <td width="150">Nama</td>
            <td width="10">:</td>
            <td><?php echo CHtml::textField('nama_pasien', $modPasien->nama_pasien, array(
                    'readonly' => true,
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                )); ?></td>
        </tr>
        <tr>
            <td width="150">NIK</td>
            <td width="10">:</td>
            <td><?php echo CHtml::textField('jeniskelamin', $modPasien->no_identitas_pasien, array(
                    'readonly' => true,
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                )); ?></td>
        </tr>
        <tr>
            <td>Tempat/ Tanggal Lahir</td>
            <td>:</td>
            <td><?php echo CHtml::textField('tanggal_lahir', ($modPasien->tempat_lahir . ", " . MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir)), array(
                    'readonly' => true,
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                )); ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo CHtml::textField('nama_pasien', $modPasien->alamat_pasien, array(
                    'readonly' => true,
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                )); ?></td>
        </tr>
    </table>
    <div style="text-align: justify; margin-left: 50px;" id="txt_tanggal">
        Dengan Hasil Pemeriksaan Kesehatan Jiwa pada saat ini :
    </div></br>
    <table width="100%" style="width:500px;margin-left:80px;">
        <tr>
            <td colspan="3">1. Psikopatologi :</td>
        </tr>
        <tr>
            <td colspan="3"><?php echo CHtml::activeTextArea($model, 'psikopatologi', array('class' => 'form-control autogrow')) ?></td>
        </tr>
        <tr>
            <td colspan="3">2. Kepribadian :</td>
        </tr>
        <tr>
            <td colspan="3"><?php echo CHtml::activeTextArea($model, 'kepribadian', array('class' => 'form-control autogrow')) ?></td>
        </tr>
    </table>
    <br />
    <div style="text-align: justify; margin: 0px 50px;" id="txt_tanggal">
        <!-- <p align="justify"> -->
        <?php echo CHtml::link(Params::SURAT_KETERANGAN_KESEHATAN_JIWA_MEMENUHI, 'javascript:;', array('val' => Params::SURAT_KETERANGAN_KESEHATAN_JIWA_MEMENUHI, 'id' => 'fisik' . Params::SURAT_KETERANGAN_KESEHATAN_JIWA_MEMENUHI, 'onclick' => 'pilihFisik(this)')) ?>/
        <?php echo CHtml::link(Params::SURAT_KETERANGAN_KESEHATAN_JIWA_TIDAK, 'javascript:;', array('val' => Params::SURAT_KETERANGAN_KESEHATAN_JIWA_TIDAK, 'id' => 'fisik' . Params::SURAT_KETERANGAN_KESEHATAN_JIWA_TIDAK, 'onclick' => 'pilihFisik(this)')) ?> *
        <?php echo CHtml::activeHiddenField($model, 'kelayakan_jiwa', array('readonly' => true)) ?>
        Sehat Rohani / Jiwa, sesuai UU Kesehatan Jiwa No.18, 2014 (individu menyadari kemampuan sendiri, dapat mengatasi tekanan, dan dapat bekerja secara produktif dan mampu memberikan kontribusi untuk komunitasnya)
        <br />
        Demikian surat keterangan pemeriksaan kesehatan jiwa dapat dibuat dengan sebenarnya untuk keperluan
        <!-- </p> -->
        <!-- <p align="justify"> -->
        Demikian surat keterangan ini dibuat untuk digunakan dengan semestinya.
        <!-- </p> -->
    </div>
</div><br><br><br><br><br>
<div class="">
    <div class="">
        <label class="font-13px" style="width:100%">
            <table class="tabel-surat">
                <tr style="text-align: center;">
                    <td width="30%">
                    <?php
                    $this->widget('ext.qrcode.QRCodeGenerator', array(
                        'data' => $model->qrcode,
                        'subfolderVar' => false,
                        'matrixPointSize' => 5,
                        'displayImage' => true, // default to true, if set to false display a URL path
                        'errorCorrectionLevel' => 'L', // available parameter is L,M,Q,H
                        'matrixPointSize' => 3, // 1 to 10 only
                    ));
                    // echo $model->qrcode;
                    ?>
                    </td>
                    <td width="50%">
                    </td>
                    <td width="19%">
                        <?php $date = date('Y-m-d'); ?>
                        <?php echo strtoupper($data->kabupaten->kabupaten_nama); ?>, <?php //echo strtoupper($format->formatDateTimeForUser($date)); 
                                                                                        ?><br>
                        <!-- <?php //echo strtoupper($data->nama_rumahsakit);
                                ?>, -->
                        <!-- Dokter Pemeriksa -->
                        <br><br><br><br><br>

                        <?php

                        $pegawaiList = DokterV::model()->findAll(array(
                            'condition' => 'pegawai_aktif = true AND kelompokpegawai_id = ' . Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                            'order' => 'nama_pegawai'
                        ));

                        $pegawaiOpt = array();
                        foreach ($pegawaiList as $item) {
                            $pegawaiOpt[$item->namaLengkap] = array(
                                'data-nama' => $item->namaLengkap,
                                'data-sip' => $item->suratizinpraktek ?? "-",
                                'data-jabatan' => $item->jabatan->jabatan_nama ?? "-",
                                'data-instansi' => 'RSUD Ketet Provinsi Jawa Tengah',
                            );
                        }

                        echo CHtml::activeDropDownList($model, 'mengetahui_surat', CHtml::listData($pegawaiList, 'namaLengkap', 'namaLengkap'), array(
                            'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'setPenandaTangan();',
                            'options' => $pegawaiOpt,
                        ));
                        ?>

                    </td>
                </tr>
                <tr>
                    <td width="80%" colspan="2">
                        <b>*Coret Salah Satu</b>
                    </td>
                </tr>
            </table>
        </label>
    </div>
</div>
</TABLE>

<script>
    function pilihFisik(obj) {
        var val = $(obj).attr('val');

        $("[id^=fisik]").each(function() {
            if ($(this).attr('val') != val) {
                $(this).addClass('line-words');
            } else {
                $(this).removeClass('line-words');
                $("#<?php echo CHtml::activeId($model, 'kelayakan_jiwa') ?>").val(val);
            }
        });
    }

    function setPenandaTangan() {
        var opt = $("#RKSuratketeranganR_mengetahui_surat :selected");

        $("#nama_pegawai").val($(opt).data('nama'));
        $("#sip").val($(opt).data('sip'));
        $("#jabatan").val($(opt).data('jabatan'));
        $("#instansi").val($(opt).data('instansi'));
    }

    function setInstansiDiri() {
        var nilai = $('#permintaandari').val();

        if (nilai == 'Instansi') {
            $('#instansidiri').show();
        } else {
            $('#instansidiri').hide();
        }
    }
</script>