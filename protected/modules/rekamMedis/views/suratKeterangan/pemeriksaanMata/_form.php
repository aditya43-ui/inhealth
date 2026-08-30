<?php 
$format = new MyFormatter();
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());



$this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p{
        text-indent: 50px;
        text-align: justify;
    }
</style>
<TABLE ALIGN="CENTER" style="margin-left:100px; text-align: center;">
     <tr>
        <td ALIGN=CENTER VALIGN=MIDDLE>
            <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN PEMERIKSAAN MATA"; ?></U></span></B>
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
    
<p align="justify">
    Saya yang bertanda tangan dibawah ini, menerangkan bahwa:
</p>

<table width="100%" style="width:500px;margin-left:80px;">
    <tr>
        <td width="150px">Nama</td>
        <td>:</td>
        <td><?php echo CHtml::textField('nama_pasien',$modPasien->nama_pasien, array('readonly'=>true,
                    'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
    </tr>
    <tr>
        <td>No CM</td>
        <td>:</td>
        <td><?php echo CHtml::activeTextField($model, 'keterangan',array(
                    'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td>
        <td><?php echo CHtml::textField('nama_pasien',$modPendaftaran->umur, array('readonly'=>true,
                    'class'=>'',
                    'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
           </td>
    </tr>
    <tr>
        <td>Pekerjaan</td>
        <td>:</td>
        <td><?php echo CHtml::textField('pekerjaan',($modPasien->pekerjaan)?$modPasien->pekerjaan->pekerjaan_nama:'', array('readonly'=>true,
                    'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?php echo CHtml::textField('nama_pasien',$modPasien->alamat_pasien, array('readonly'=>true,
                    'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
    </tr>
</table>

<p align="justify">
    Telah dilakukan pemeriksaan pada matanya dengan hasil sebagai berikut :
    <br>    
</p>

<table width="100%" style="width:500px;margin-left:80px;">
    <tr>
        <td width="150px">1. Tajam penglihatan</td>
        <td></td>
        <td>
        </td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mata kanan</td>
        <td>:</td>
        <td> <?= CHtml::activeTextField($modFisik, 'mata_kanan',['readonly'=>true]) ?>
        </td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mata kiri</td>
        <td></td>
        <td> <?= CHtml::activeTextField($modFisik, 'mata_kiri',['readonly'=>true]) ?>
        </td>
    </tr>
    <tr>
        <td>2. Segmen Anterior</td>
        <td>:</td>
        <td><?= CHtml::activeTextField($modFisik, 'segmen_anterior',['readonly'=>true]) ?>
        </td>
    </tr>
    <tr>
        <td>3. Segmen Posterior</td>
        <td>:</td>
        <td><?= CHtml::activeTextField($modFisik, 'segmen_posterior',['readonly'=>true]) ?>
        </td>
    </tr>
    <tr>
        <td>4. Penglihatan</td>
        <td></td>
        <td>
        </td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mata/Ishihara Test</td>
        <td></td>
        <td> <?= CHtml::activeTextField($modFisik, 'warna',['readonly'=>true]) ?>
        </td>
    </tr>
    <tr>
        <td>5. Resume</td>
        <td>:</td>
        <td><?= CHtml::activeTextField($modFisik, 'resume',['readonly'=>true]) ?>
        </td>
    </tr>
</table>
        

<TABLE width="100%" style="width:750px;margin-left:80px;">
    <tr>
        <td width="50%">&nbsp;</td>
        <td style="text-align:center;">
            
            <?php $date = date('Y-m-d'); ?>
            <?php echo $data->kecamatan->kecamatan_nama ;?>, <?php echo $format->formatDateTimeForUser($date); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align:center;">
            <?php
                echo CHtml::activeDropDownList($model,'mengetahui_surat', CHtml::listData(DokterV::model()->findAll(array(
                    'condition'=>'pegawai_aktif = true AND kelompokpegawai_id = '.Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                    'order'=>'nama_pegawai'
                )), 'namaLengkap', 'namaLengkap'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)"));
            ?>
        </td>
    </tr>
</TABLE>