<?php 
$format = new MyFormatter();
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
if(!empty($_GET["pendaftaran_id"])){
    $pendaftaran_id = $_GET["pendaftaran_id"];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $model->mengetahui_surat = $modPendaftaran->pegawai->nama_pegawai;
    if(!empty($modPendaftaran->pasienadmisi_id)){
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        $model->mengetahui_surat = (isset($modAdmisi->pasienadmisi_id) ? $modAdmisi->pegawai->nama_pegawai : "");
    }else{
        $modAdmisi = new PasienadmisiT;
        $modAdmisi->tgladmisi = date('Y-m-d')." 00:00:00";
        $modAdmisi->tglpulang = date('Y-m-d')." 00:00:00";
    }
    
    $modPasienmorbiditas = PasienmorbiditasT::model()->find('pendaftaran_id = '.$pendaftaran_id.' AND kelompokdiagnosa_id = '.PARAMS::KELOMPOKDIAGNOSA_UTAMA.'');
    if(empty($modPasienmorbiditas)){
        $modPasienmorbiditas = PasienmorbiditasT::model()->find('pendaftaran_id = '.$pendaftaran_id.' AND kelompokdiagnosa_id = '.PARAMS::KELOMPOKDIAGNOSA_MASUK.' OR kelompokdiagnosa_id = '.PARAMS::KELOMPOKDIAGNOSA_TAMBAH.'');
    }
    if(!empty($modPasienmorbiditas)){
        $diagnosa = $modPasienmorbiditas->diagnosa->diagnosa_nama;
    }else{
        $diagnosa = " ";
    }
    
    $modPemeriksaan = PemeriksaanfisikT::model()->find('pendaftaran_id = '.$pendaftaran_id.'');
    $modAnamnesa = AnamnesaT::model()->find('pendaftaran_id = '.$pendaftaran_id.'');
    
    if(!empty($modAnamnesa)){
        $keluhan_utama = $modAnamnesa->keluhanutama;
    }else{
        $keluhan_utama = '';
    }
    
    if(!empty($modPemeriksaan)){
        $tekanan_darah = $modPemeriksaan->tekanandarah;
        $tempratur = $modPemeriksaan->suhutubuh;
        $pols = $modPemeriksaan->detaknadi;
        $rr = $modPemeriksaan->pernapasan;
        $tinggi_badan = $modPemeriksaan->tinggibadan_cm;
        $berat_badan = $modPemeriksaan->beratbadan_kg;
        $pemeriksaan_lain = $modPemeriksaan->kelainanpadabagtubuh;
    }else{
        $tekanan_darah = '';
        $tempratur = '';
        $pols = '';
        $rr = '';
        $tinggi_badan = '';
        $berat_badan = '';
        $pemeriksaan_lain = '';
    }
}
$model->tglistirahat = date('Y-m-d');

if(!empty($_GET['lama_hari'])){
    $model->lama_istirahat = $_GET['lama_hari'];
}
if(!empty($_GET['suratketerangan_id'])){
    $model = RKSuratketeranganR::model()->findByPk($_GET['suratketerangan_id']);
    $model->tglistirahat = $model->tglistirahat;
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p{
        text-indent: 50px;
        text-align: justify;
    }
</style>
<TABLE>
<div>
    <div>
        <TABLE ALIGN="CENTER" style="margin-left:100px; text-align: center;">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN PENYAKIT GAWAT DARURAT"; ?></U></span></B>
                </td>
            </tr>
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4>NO : <?php echo CHtml::activeTextField($model,'nomorsurat', array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></span></B>
                    
                    <?php
                        echo CHtml::activeHiddenField($model,'suratketerangan_id',array()); 
                    ?>
                </td>
            </tr>
        </TABLE>
    </div>
    </br><br><br><br>
    <p align="justify">
        Saya yang bertanda tangan dibawah ini, Dokter <?php echo $data->nama_rumahsakit;?>, dengan ini menerangkan bahwa:
    </p>
    <p align="justify">
        <table width="100%" style="width:500px;margin-left:80px;">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->nama_pasien, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Umur/Tgl. lahir</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPendaftaran->umur, array('readonly'=>false,
                            'class'=>'span2',
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo CHtml::textField('nama_pasien',MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir), array('readonly'=>false,
                            'class'=>'span2',
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->jeniskelamin, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>No. RK</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->no_rekam_medik, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->alamat_pasien, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
        </table><br>
        <p align="justify">
            Adalah benar sedang dirawat inap/ opname di RS <?php echo $data->nama_rumahsakit;?> mulai tanggal
                            <div style="margin-top:-30px;margin-left:608px;"> 
                                <?php 
                                $modAdmisi->tgladmisi = (!empty($modAdmisi->tgladmisi) ? $format->formatDateTimeForUser($modAdmisi->tgladmisi) : '');
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modAdmisi,
                                        'attribute' => 'tgladmisi',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
//                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array('readonly' => true,'class'=>'span2',
                                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                                    ));
                                ?>
                            </div>
            Berdasarkan hasil pemeriksaan dokter dapat diinformasikan sebagai berikut :
            <br>
            <table width="100%" style="width:750px;margin-left:80px;">
                <tr>
                    <td>Keluhan Utama</td>
                    <td>:</td>
                    <td><?php echo CHtml::textField('keluhan_utama',(!empty($_GET['pendaftaran_id']) ? $keluhan_utama : ''), array('readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php 
                                echo "<span class='help-inline error'>".(!empty($keluhan_utama) || empty($_GET['pendaftaran_id']) ? "" : 'Keluhan Utama harus diinputkan di Pemeriksaan Pasien')."</span>";                         
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Tekanan Darah</td>
                    <td>:</td>
                    <td><?php echo CHtml::textField('tekanan_darah',(!empty($_GET['pendaftaran_id']) ? $tekanan_darah : ''), array('readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php 
                                echo "<span class='help-inline error'>".(!empty($tekanan_darah) || empty($_GET['pendaftaran_id']) ? "" : 'Tekanan Darah harus diinputkan di Pemeriksaan Pasien')."</span>";                         
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Tempratur</td>
                    <td>:</td>
                    <td><?php echo CHtml::textField('tempratur',(!empty($_GET['pendaftaran_id']) ? $tempratur : ''), array('readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php 
                                echo "<span class='help-inline error'>".(!empty($tempratur) || empty($_GET['pendaftaran_id']) ? "" : 'Tempratur harus diinputkan di Pemeriksaan Pasien')."</span>";                         
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Pols</td>
                    <td>:</td>
                    <td><?php echo CHtml::textField('pols',(!empty($_GET['pendaftaran_id']) ? $pols : ''), array('readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php 
                                echo "<span class='help-inline error'>".(!empty($pols) || empty($_GET['pendaftaran_id']) ? "" : 'Pols harus diinputkan di Pemeriksaan Pasien')."</span>";                         
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>RR</td>
                    <td>:</td>
                    <td><?php echo CHtml::textField('rr',(!empty($_GET['pendaftaran_id']) ? $rr : ''), array('readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php 
                                echo "<span class='help-inline error'>".(!empty($rr) || empty($_GET['pendaftaran_id']) ? "" : 'RR harus diinputkan di Pemeriksaan Pasien')."</span>";                         
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Lab/Rad</td>
                    <td>:</td>
                    <td><?php echo CHtml::activeTextField($model,'lab_rad', array('readonly'=>false,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    </td>
                </tr>
                <tr>
                    <td>Diagnosa</td>
                    <td>:</td>
                    <td><?php echo CHtml::textArea('diagnosa',(!empty($_GET['pendaftaran_id']) ? $diagnosa : ''), array('readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php 
                                echo "<span class='help-inline error'>".(!empty($diagnosa) || empty($_GET['pendaftaran_id']) ? "" : 'Diagnosa harus diinputkan di Pemeriksaan Pasien')."</span>";                         
                        ?>
                    </td>
                </tr>
            </table><br>
            <p align="justify">
                Sehubungan dengan diagnosa tersebut diatas, pasien dikategorikan menderita penyakit yang harus ditindak dengan cepat (Gawat Darurat).
            </p>            
            <br>
            <p align="justify">
                Demikianlah Surat Keterangan Penyakit Gawat Darurat ini diperbuat untuk dapat dipergunakan seperlunya, atas kerjasamanya diucapkan Terima Kasih.
            </p> 
        </p>
</div><br><br><br><br><br>
<div style="margin-left: 50px">
    <?php $date = date('Y-m-d'); ?>
    <?php echo $data->kecamatan->kecamatan_nama ;?>, <?php echo $format->formatDateTimeForUser($date); ?>
<br><br><br><br><br>
<!--(_________________)-->
<?php
    echo CHtml::activeDropDownList($model,'mengetahui_surat', CHtml::listData(DokterV::model()->findAll(array(
        'condition'=>'pegawai_aktif = true AND kelompokpegawai_id = '.Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
        'order'=>'nama_pegawai'
    )), 'namaLengkap', 'namaLengkap'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)"));
?>
</div>
</TABLE>