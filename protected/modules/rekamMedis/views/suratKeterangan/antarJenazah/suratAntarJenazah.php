<?php 
$format = new MyFormatter();
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
if(!empty($_GET["pendaftaran_id"])){
    $pendaftaran_id = $_GET["pendaftaran_id"];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $model->mengetahui_surat = $modPendaftaran->pegawai->nama_pegawai;
    if(!empty($modPendaftaran->pasienadmisi_id)){
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pegawai_id);
        $model->mengetahui_surat = (isset($modAdmisi->pasienadmisi_id) ? $modAdmisi->pegawai->nama_pegawai:"");
    }
}
$model->tglistirahat = date('Y-m-d')." 00:00:00";

if(!empty($_GET['lama_hari'])){
    $model->lama_istirahat = $_GET['lama_hari'];
}

if(!empty($_GET['suratketerangan_id'])){
    $model = SuratketeranganR::model()->findByPk($_GET['suratketerangan_id']);
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
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT JALAN AMBULANCE ANTAR JENAZAH"; ?></U></span></B>
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
        Saya yang bertanda tangan dibawah ini, Direktur <?php echo $data->nama_rumahsakit;?>, dengan ini menerangkan bahwa:
    </p>
    <p align="justify">
        <table width="100%" style="width:500px;margin-left:80px;">
            <tr>
                <td>Nama Supir</td>
                <td>:</td>
                <td><div class="control-group">
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($model,'supirambulans_id',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::textField('supir_nama','',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php
                            echo CHtml::htmlButton('<i class="entypo-search"></i>', array('class' => 'btn btn-danger', 'onclick' => "$('#dialogSupir').dialog('open');",
                                'id' => 'btnAddSupir', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'rel' => 'tooltip', 'title' => 'Klik untuk mencari Supir'))
                        ?>
                    </div>
                </div></td>
            </tr>
            <tr>
                <td>No. SIM</td>
                <td>:</td>
                <td><?php echo CHtml::activeTextField($model,'keterangan', array('readonly'=>false,'class'=>'span3',
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Nomor Plat Polisi</td>
                <td>:</td>
                <td><div class="control-group">
                            <div class="controls">
                                <?php echo CHtml::activeHiddenField($model,'mobilambulans_id',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php echo CHtml::textField('mobilambulans_nama','',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php
                                    echo CHtml::htmlButton('<i class="entypo-search"></i>', array('class' => 'btn btn-danger', 'onclick' => "$('#dialogKendaraan').dialog('open');",
                                        'id' => 'btnAddParamedis2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'rel' => 'tooltip', 'title' => 'Klik untuk mencari Mobil Ambulans'))
                                ?>
                            </div>
                        </div></td>
            </tr>
        </table>
        <p align="justify">
            untuk mengantar jenazah dengan data sebagai berikut :
            <br>
            <table width="100%" style="width:500px;margin-left:80px;">
                <tr>
                    <td>Nama Pasien</td>
                    <td>:</td>
                    <td><?php echo CHtml::textField('nama_pasien',$modPasien->nama_pasien, array('readonly'=>false,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td>:</td>
                    <td><?php echo CHtml::textField('nama_pasien',$modPendaftaran->umur, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>
                    <?php echo CHtml::textField('nama_pasien',  MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir), array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?></td>
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
                <tr>
                    <td>Tempat Tujuan</td>
                    <td>:</td>
                    <td><?php echo CHtml::textField('nama_pasien',$modPasien->alamat_pasien, array('readonly'=>false,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
                </tr>
            </table><br>
            <p align="justify">
                Demikian surat jalan ini diperbuat, untuk dapat dipergunakan seperlunya.
            </p>
        </p>
</div><br><br><br><br><br>
<div style="margin-left: 50px">
    <?php $date = date('Y-m-d'); ?>
    <?php echo $data->kecamatan->kecamatan_nama ;?>, <?php echo $format->formatDateTimeForUser($date); ?>
<br>
Direktur RS,<br><br><br><br><br>
<!--(_________________)-->
        <?php
		echo CHtml::activeDropDownList($model,'mengetahui_surat', CHtml::listData(DokterV::model()->findAll(array(
                    'condition'=>'pegawai_aktif = true AND kelompokpegawai_id = '.Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                    'order'=>'nama_pegawai',
                )), 'namaLengkap', 'namaLengkap'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)"));
	?>
</div>
</TABLE>
<?php 
//========= Dialog buat daftar supir  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogSupir',
    'options'=>array(
        'title'=>'Daftar Supir',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>500,
        'resizable'=>false,
    ),
));
    $this->renderPartial($this->path_view.'_daftarSupir');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar supir =============================
//========= Dialog buat daftar ambulans  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogKendaraan',
    'options'=>array(
        'title'=>'Daftar Kendaraan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>500,
        'resizable'=>false,
    ),
));
    $this->renderPartial($this->path_view.'_daftarKendaraan');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar ambulans =============================
?> 