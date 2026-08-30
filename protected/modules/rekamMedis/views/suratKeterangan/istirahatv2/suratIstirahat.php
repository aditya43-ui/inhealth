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
        $model->mengetahui_surat = (isset($modAdmisi->pegawai->nama_pegawai) ? $modAdmisi->pegawai->nama_pegawai : "");
    }
}
$model->tglistirahat = date('Y-m-d');

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
        <TABLE ALIGN="CENTER" style="margin-left:200px;">
        <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4><?php echo CHtml::activeTextField($model,'nomorsurat', array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></span></B>
                    
                    <?php
                        echo CHtml::activeHiddenField($model,'suratketerangan_id',array()); 
                    ?>
                </td>
            </tr>
             <tr>
             <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span SIZE=4><?php echo "SURAT KETERANGAN SAKIT"."<br><span style='font-style: italic;'>CERTIFICATE OF ILLNES<span>" ?></span></B>
                </td>
            </tr>
             
        </TABLE>
    </div>
    </br><br>
    <p align="justify">
        Yang bertanda tangan dibawah ini menerangkan bahwa :<br><span style="font-style: italic;">I hereby state that:<span>
    </p>
    <p align="justify">
        <table width="100%" style="margin-left:80px;width:500px;">
            <tr>
                <td>Nama<br><span style="font-style: italic;">Name<span></td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->nama_pasien, array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Usia<br><span style="font-style: italic;">Age<span></td>
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
                       
                    echo CHtml::textField('nama_pasien',$umur[0].' Tahun,', array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>
                    <?php /*
                    <span class='<?php echo $jkLK ?>'><?php echo Params::JENIS_KELAMIN_LAKI_LAKI; ?></span>
                            /
                        <span class='<?php echo $jkPR ?>'><?php echo Params::JENIS_KELAMIN_PEREMPUAN; ?></span>
                     * 
                     */ ?>
                    
            </tr>
            <tr>
                <td>Pekerjaan<br><span style="font-style: italic;">Occupation<span></td>
                <td>:</td>
                <td><?php echo CHtml::textField('pekerjaan',!empty($modPasien->pekerjaan_id)?$modPasien->pekerjaan->pekerjaan_nama:'-', array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>            
            <tr>
                <td>Alamat<br><span style="font-style: italic;">Address<span></td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->alamat_pasien, array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>No. RM<br><span style="font-style: italic;">No. RM<span></td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->no_rekam_medik, array('readonly'=>True,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
        </table><br>
        <p align="justify">
        Memerlukan cuti/istirahat selama<?php echo CHtml::activeTextField($model,'lamaistirahat', array('readonly'=>false,
                            'class'=>'span1','onkeypress'=>"return $(this).focusNextInputField(event)")); ?> <span id='hariterbilang'></span>harikarena<br><span style="font-style: italic;">
                            Needs to have <?php echo $model->lamaistirahat; ?> day(s) sick leave/rest due to
                            <span>
                            </p>
                            <table width="100%" style="margin-left:80px;width:500px;">
                                <tr>
                                    <td><?php echo CHtml::activeRadioButton($model,'jenisizin',array('value' => 'Sakit', 'uncheckValue'=>null))."Sakit"; ?></td>
                                    <td></td>
                                    <td><?php echo CHtml::activeRadioButton($model,'jenisizin',array('value' => 'Melahirkan/Periksa Hamil', 'uncheckValue'=>null))."Melahirkan/Periksa Hamil"; ?></td>
                                </tr>
                            </table>
                            <p align="justify">
                            Mulai tanggal
                                <?php 
                                    $model->tglsurat = $format->formatDateTimeForUser($model->tglistirahat);
                                    $model->tglistirahat = $format->formatDateTimeForUser($model->tglistirahat);
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tglistirahat',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            //'maxDate' => 'd',
                                            'line' => true
                                        ),
                                        'htmlOptions' => array('readonly' => true,'class'=>'span2',
                                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                                    ));
                                ?> sampai 
                                 <?php 
                                   // $model->tglsurat = $format->formatDateTimeForUser($model->tglistirahat);
                                    $model->istirahat_tgl_sd = $format->formatDateTimeForUser($model->istirahat_tgl_sd);
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'istirahat_tgl_sd',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            //'maxDate' => 'd',
                                            'line' => true
                                        ),
                                        'htmlOptions' => array('readonly' => true,'class'=>'span2',
                                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                                    ));
                                ?>
                                <br><span style='font-style: italic;'>
            Starting from <?php echo $format->formatDateTimeForUser($model->tglsurat); ?> to <?php echo $format->formatDateTimeForUser($model->istirahat_tgl_sd); ?> 
            <span> 
                          
            <br>
        </p>
        <p align="justify">
            Surat Keterangan ini dikeluarkan untuk dipergunakan sebagaimana mestinya.<br><span style='font-style: italic;'>
            This letter is for the use of specified person only
            <span>
        </p>
        
</div><br><br><br><br><br>
</TABLE>
<div class="row">
    <div class="col-sm-6">
    
    
    </div>
    <div class="col-sm-6">
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
                <tr hidden>
                    <td width="80%">
                        <b>*Coret Salah Satu</b>
                    </td>
                </tr>
            </table>
      </label>
    </div>
</div>