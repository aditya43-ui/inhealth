<?php 
$format = new MyFormatter();
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
if(!empty($_GET["pendaftaran_id"])){
    $pendaftaran_id = $_GET["pendaftaran_id"];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $model->mengetahui_surat = empty($modPendaftaran->pegawai) ? "" : $modPendaftaran->pegawai->nama_pegawai;
    if(!empty($modPendaftaran->pasienadmisi_id)){
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pegawai_id);
        $model->mengetahui_surat = (!empty($modAdmisi->pegawai) ? $modAdmisi->pegawai->nama_pegawai : "");
    }
}
$model->tglistirahat = date('Y-m-d');
$model->istirahat_tgl_sd = date('Y-m-d');

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
    
    .add-on{
        border: #ddd 1px solid;
        padding: 6px;
        border-radius: 5px;
    }
</style>

<TABLE>
<div>
    <div>
        <TABLE ALIGN="CENTER" style="margin-left:200px;">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN DOKTER"; ?></U></span></B>
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
       Yang bertanda tangan dibawah ini menerangkan bahwa :
    </p>
    <p align="justify">
        <table width="100%" style="margin-left:80px;width:500px;">
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
                    <?php /*
                    <span class='<?php echo $jkLK ?>'><?php echo Params::JENIS_KELAMIN_LAKI_LAKI; ?></span>
                            /
                        <span class='<?php echo $jkPR ?>'><?php echo Params::JENIS_KELAMIN_PEREMPUAN; ?></span>
                     * 
                     */ ?>
                    
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td><?php echo CHtml::textField('pekerjaan',!empty($modPasien->pekerjaan_id)?$modPasien->pekerjaan->pekerjaan_nama:'-', array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>            
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->alamat_pasien, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>No. RM</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->no_rekam_medik, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
        </table><br>
        <p align="justify">
            Berdasarkan pemeriksaan kami, memerlukan istirahat selama <?php echo CHtml::activeTextField($model,'lamaistirahat', array('readonly'=>false,
                            'class'=>'span1','onkeypress'=>"return $(this).focusNextInputField(event)")); ?> <span id='hariterbilang'></span>hari
                            </p>
                            <p align="justify">
                            terhitung mulai tanggal
                          
                                <?php 
                                    $model->tglsurat = $format->formatDateTimeForUser($model->tglistirahat);
                                    $model->tglistirahat = $format->formatDateTimeForUser($model->tglistirahat);
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tglistirahat',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate' => 'd',
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
                          
            <br>
        </p>
        <p align="justify">
            Demikian surat keterangan dibuat dengan sebenarnya, untuk dipergunakan sebagaimana mestinya.
        </p>
        
</div><br><br><br><br><br>
</TABLE>
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
                <tr hidden>
                    <td width="80%">
                        <b>*Coret Salah Satu</b>
                    </td>
                </tr>
            </table>
      </label>
    </div>
</div>