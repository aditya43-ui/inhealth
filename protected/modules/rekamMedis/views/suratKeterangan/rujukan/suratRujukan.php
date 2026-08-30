<?php 
$format = new MyFormatter();
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
if(!empty($_GET['pendaftaran_id'])){
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
}else{
    $model->tglsurat = date('Y-m-d');
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
    
    .add-on{
        border: #ddd 1px solid;
        padding: 6px;
        border-radius: 5px;
    }
</style>
<TABLE>
<div>
    <div>
        <TABLE ALIGN="CENTER" style="margin-left:100px; text-align: center;">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN RUJUKAN"; ?></U></span></B>
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
	<div>
    <p align="justify">
        Kepada		
    </p>
	<p align="justify">
        Yth. <?php echo CHtml::activeTextArea($model, 'rujukan_yth', array('class'=>'autogrow')) ?>
    </p>
	<br>
	<p align="justify">
        Bersama ini kami merujuk pasien :
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
                <td>Usia</td>
                <td>:</td>
                <td>
                    <?php 
                    $umur = explode(' ',$modPendaftaran->umur);
                    
                     
                            $jkPR = '';
                            $jkLK = '';
                            if (!empty($modPasien->jeniskelamin)){
                                if ($modPasien->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                                    $jkPR = 'line-words';
                                }else{
                                    $jkLK = 'line-words';
                                }
                            }
                       
                    echo CHtml::textField('nama_pasien',$umur[0].' Tahun,', array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>
                    <span class='<?php echo $jkLK ?>'><?php echo Params::JENIS_KELAMIN_LAKI_LAKI; ?></span>
                            /
                        <span class='<?php echo $jkPR ?>'><?php echo Params::JENIS_KELAMIN_PEREMPUAN; ?></span>
                    
            </tr>                  
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->alamat_pasien, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Diagnosa</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
			<tr>
                <td>Dokter yang merawat</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPendaftaran->pegawai->namaLengkap, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
			<tr>
				<td colspan="3">Anamnesis :</td>
			</tr>
			<tr>
				<td colspan="3"><?php echo CHtml::activeTextArea($model,'rujukan_anamnesis',array('class'=>'form-control autogrow')) ?></td>
			</tr>
			<tr>
				<td colspan="3">Pemeriksaan Fisik :</td>
			</tr>
			<tr>
				<td colspan="3"><?php echo CHtml::activeTextArea($model,'rujukan_fisik',array('class'=>'form-control autogrow')) ?></td>
			</tr>
			<tr>
				<td colspan="3">Terapi :</td>
			</tr>
			<tr>
				<td colspan="3"><?php echo CHtml::activeTextArea($model,'rujukan_terapi',array('class'=>'form-control autogrow')) ?></td>
			</tr>
			<tr>
				<td colspan="3">Pemeriksaan Penunjang :</td>
			</tr>
			<tr>
				<td colspan="3"><?php echo CHtml::activeTextArea($model,'rujukan_penunjang',array('class'=>'form-control autogrow')) ?></td>
			</tr>
			<tr>
				<td colspan="3">Observasi terakhir penderita :</td>
			</tr>
			<tr>
				<td colspan="3"><?php echo CHtml::activeTextArea($model,'rujukan_observasiakhir',array('class'=>'form-control autogrow')) ?></td>
			</tr>
        </table>       
        <p align="justify">
           Atas bantuan dan kerjasamanya kami ucapkan terimakasih
        </p>
</div><br><br><br><br><br>
<div class="row">
    <div class="col-sm-12">
        <label class="font-13px"  style="width:100%">
            <table class="tabel-surat">
                <tr style="text-align: center;">
                    <td width="80%">
                        
                    </td>
                    <td width="19%">                        
                                <?php $date = date('Y-m-d'); ?>
                                <?php echo strtoupper($data->kabupaten->kabupaten_nama) ;?>, <?php echo strtoupper($format->formatDateTimeForUser($date)); ?><br>
                                <?php //echo strtoupper($data->nama_rumahsakit);?>,
                                Dokter Pemeriksa
                                <br><br><br><br><br>
                       
                        <?php
                               echo CHtml::activeDropDownList($model,'mengetahui_surat', CHtml::listData(DokterV::model()->findAll(array(
        'condition'=>'pegawai_aktif = true AND kelompokpegawai_id = '.Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
        'order'=>'nama_pegawai'
    )), 'namaLengkap', 'namaLengkap'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)"));
                            ?>
                        
                    </td>
                </tr>
                <tr>
                    <td width="80%">
                        <b>*Coret Salah Satu</b>
                    </td>
                </tr>
            </table>
      </label>
    </div>
</div>
</TABLE>