<?php 
$format = new MyFormatter();
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
if(!empty($_GET['pendaftaran_id'])){
    $pendaftaran_id = $_GET["pendaftaran_id"];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    // var_dump($modPemeriksaanFisik);die;
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
                    <B><span FACE="Liberation Serif" SIZE=4><?php echo CHtml::activeTextField($model,'nomorsurat', array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></span></B>
                    
                    <?php
                        echo CHtml::activeHiddenField($model,'suratketerangan_id',array()); 
                    ?>
                </td>
            </tr>
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN SEHAT"; ?></U></span></B>
                </td>
            </tr>
             
        </TABLE>
    </div>
    </br><br><br><br>
    <p align="justify">
        <u>Yang bertanda tangan dibawah ini menerangkan bahwa :</u>
    </p>
    <p align="justify">
        <i>i herebly state that:</i>
    </p>
    <p align="justify">
        <table width="100%" style="margin-left:80px;">
            <tr>
                <td width="30%">Nama &nbsp; <i>(Name)</i></td>
                <td></td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->nama_pasien, array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin &nbsp; <i>(Gender)</i></td>
                <td></td>
                <td>
                    <?php
                        $jkPR = '';
                        $jkLK = '';
                        if (!empty($modPasien->jeniskelamin)){
                            if ($modPasien->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                                $jkPR = 'line-words';
                            }else{
                                $jkLK = 'line-words';
                            }
                        }
                    ?>
                    <span class='<?php echo $jkLK ?>'><?php echo Params::JENIS_KELAMIN_LAKI_LAKI; ?></span>
                            /
                    <span class='<?php echo $jkPR ?>'><?php echo Params::JENIS_KELAMIN_PEREMPUAN; ?></span> *
                </td>
            </tr>
             <tr>
                <td>Usia &nbsp; <i>(Ages)</i></td>
                <td></td>
                <td>
                    <?php 
                    $umur = explode(' ',$modPendaftaran->umur);
                    
                     
                            
                       
                    echo CHtml::textField('nama_pasien',$umur[0].' Tahun,', array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>
                   
                    
            </tr>
            <tr>
                <td>Pekerjaan &nbsp; <i>(Occupation)</i></td>
                <td></td>
                <td><?php echo CHtml::textField('pekerjaan',!empty($modPasien->pekerjaan_id)?$modPasien->pekerjaan->pekerjaan_nama:'-', array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>            
            <tr>
                <td>Alamat &nbsp; <i>(Address)</i></td>
                <td></td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->alamat_pasien, array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <!-- <tr>
                <td>No. RM &nbsp; <i>(No. RM)</i></td>
                <td></td>
                <td><?php //echo CHtml::textField('nama_pasien',$modPasien->no_rekam_medik, array('readonly'=>true,
                            //'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr> -->
        </table>
        <table width="100%" style="margin-left:80px;">
            <tr>
                <td width="30%"><u>Telah diperiksa dengan teliti dan dinyatakan:</u><br> <i>It  Has Been examined carefully and expressed:</i></td>
                <td><?php echo CHtml::activeTextField($model,'hasil_periksa', array('readonly'=>false,
                            'class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); ?> </td>
            </tr>
            <tr>
                <td><u>Surat Keterangan ini dipergunakan untuk:</u><br> <i>Health Certificate is used for:</i></td>
                <td><?php echo CHtml::activeTextField($model,'pergunaan_surat', array('readonly'=>false,
                            'class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); ?> </td>
            </tr>
        </table>
        <table width="100%" style="margin-left:80px;">
            <tr>
                <td><u>Hasil Pemeriksaan</u><br><i>Test Result</i></td>
            </tr>
            <tr>
                <td>Tekanan Darah &nbsp;<i>(Blood Pressure)</i></td>
                <td><?php echo CHtml::textField('nama_pasien',!empty($modPemeriksaanFisik)?$modPemeriksaanFisik->tekanandarah."Hg":'-', array('readonly'=>true,'class'=>'span4',
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
                <td>Denyut Nadi &nbsp;<i>(Pulse)</i></td>
                <td><?php echo CHtml::textField('nama_pasien',!empty($modPemeriksaanFisik)?$modPemeriksaanFisik->detaknadi."/Menit":'-', array('readonly'=>true,'class'=>'span4',
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td></td>
            </tr>
            <tr>
                <td>Suhu &nbsp;<i>(Temperature)</i></td>
                <td><?php echo CHtml::textField('nama_pasien',!empty($modPemeriksaanFisik)?$modPemeriksaanFisik->suhutubuh."°Celcius":'-', array('readonly'=>true,'class'=>'span4',
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td></td>
                <td>RR &nbsp;<i>(Respiration Rate)</i></td>
                <td><?php echo CHtml::textField('nama_pasien',!empty($modPemeriksaanFisik)?$modPemeriksaanFisik->pernapasan."/Menit":'-', array('readonly'=>true,'class'=>'span4',
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td></td>
            </tr>
            <tr>
                <td>Tinggi Badan &nbsp;<i>(Height)</i></td>
                <td><?php echo CHtml::textField('nama_pasien',!empty($modPemeriksaanFisik)?$modPemeriksaanFisik->tinggibadan_cm."Cm":'-', array('readonly'=>true,'class'=>'span4',
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td></td>
                <td>Berat Badan &nbsp;<i>(Weight)</i></td>
                <td><?php echo CHtml::textField('nama_pasien',!empty($modPemeriksaanFisik)?$modPemeriksaanFisik->beratbadan_kg."Kg":'-', array('readonly'=>true,'class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)"))."Kg"; ?></td></td>
            </tr>
            <tr>
                <td>Golongan Darah &nbsp;<i>(Blood type)</i></td>
                <td><?php echo CHtml::textField('nama_pasien',!empty($modPemeriksaanFisik)?$modPemeriksaanFisik->tekanandarah_text:'-', array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td></td>
                <td>Buta Warna &nbsp;<i>(Color Blindness)</i></td>
                <td><?php echo CHtml::activeTextField($model,'butawarna', array('readonly'=>false,
                            'class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
        </table>
        <table width="100%" style="margin-left:80px;">
            <tr>
                <td width="30%"><u>Swab PCR RT Covid-19</u></td>
                <td><?php echo CHtml::activeTextField($model,'hasil_swab', array('readonly'=>false,
                            'class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td><u>Catatan Dokter <i>(Note)</i></u></td>
                <td><?php echo CHtml::activeTextField($model,'catatan_dokter', array('readonly'=>false,
                            'class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td><u>Kesimpulan <i>(Summary)</i></u></td>
                <td><?php echo CHtml::activeTextField($model,'kesimpulan', array('readonly'=>false,
                            'class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
        </table>
        <p align="justify">
            <u>Surat Keterangan ini dikeluarkan untuk dipergunakan sebagaimana mestinya</u>
        </p>
        <p align="justify">
            <i>This letter is for the use of specified person only</i>
        </p>
</div><br><br><br><br><br>
<div class="">
    <div class="">
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
                <!-- <tr>
                    <td width="80%" colspan="2">
                        <b>*Coret Salah Satu</b>
                    </td>
                </tr> -->
            </table>
      </label>
    </div>
</div>
</TABLE>

<script>
    function pilihFisik(obj){
        var val = $(obj).attr('val');
        
        $("[id^=fisik]").each(function(){
           if ($(this).attr('val') != val){
               $(this).addClass('line-words');
           }else{
               $(this).removeClass('line-words');
               $("#<?php echo CHtml::activeId($model, 'status_fisik') ?>").val(val);
           }
        });
    }
    
    function pilihLayak(obj){
        var val = $(obj).attr('val');
        
        $("[id^=kelayakan]").each(function(){
           if ($(this).attr('val') != val){
               $(this).addClass('line-words');
           }else{
               $(this).removeClass('line-words');
               $("#<?php echo CHtml::activeId($model, 'kelayakan_pekerjaan') ?>").val(val);
           }
        });
    }
    
    $(document).ready(function(){
        var val = $("#<?php echo CHtml::activeId($model, 'status_fisik') ?>").val();
		var layak = $("#<?php echo CHtml::activeId($model, 'kelayakan_pekerjaan') ?>").val();
    
        $("[id^=fisik]").each(function(){            
            if (val != ''){
                if ($(this).attr('val') != val){                               
                     $(this).addClass('line-words');                
                }else{               
                     $(this).removeClass('line-words');                                  
                }
            }
        });
        
        $("[id^=kelayakan]").each(function(){            
            if (layak != ''){
                if ($(this).attr('val') != layak){                               
                     $(this).addClass('line-words');                
                }else{               
                     $(this).removeClass('line-words');                                  
                }
            }
        });
    });
</script>