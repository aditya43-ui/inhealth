<?php

$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$modul_id = Yii::app()->user->getState('modul_id');
$readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
$hide = $readonly ? " hide" : "";
$hidden = $readonly ? " hidden" : "";
$display = "display:" . ($readonly ? " none;" : "block;");
$visibility = "visibility:" . ($readonly ? " visible; " : "hidden; ");

?>

<?php 
/**
* - versi 2 surat keterangan lahir
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/datetime.js');

$format = new MyFormatter();
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$dropKab = array();
$dropKec = array();
$propinsi_id = NULL;
$kabupaten_id = NULL;
$kecamatan_id = NULL;

if(!empty($_GET['pendaftaran_id'])){
    $pendaftaran_id = $_GET["pendaftaran_id"];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    
    $model->mengetahui_surat = $modPendaftaran->pegawai->nama_pegawai;
	// $modPasien->tanggal_lahir = $format->formatDateTimeForUser($modPasien->tanggal_lahir);
    $kabupaten_id = $modPasien->kabupaten_id;
    $kecamatan_id = $modPasien->kecamatan_id;

    
}else{
    $model->tglsurat = date('Y-m-d');
}

// $model->lahir_tgllahir = (!empty($model->lahir_tgllahir) ? $format->formatDateTimeForUser($model->lahir_tgllahir) : $format->formatDateTimeForUser(date('Y-m-d H:i:s')));

if(!empty($model->suratketerangan_id)){
    
    if (!empty($model->lahir_propinsi)){
    $prop = PropinsiM::model()->findByAttributes(array('propinsi_nama'=>$model->lahir_propinsi));
    if (!empty($prop)) {
        $model->lahir_propinsi = $prop->propinsi_nama;
    }
    $dropKab = CHtml::listData(KabupatenM::model()->findAll("kabupaten_aktif = TRUE AND propinsi_id = '".$prop->propinsi_id."' ORDER BY kabupaten_nama ASC"), 'kabupaten_nama', 'kabupaten_nama');
}

if (!empty($model->lahir_kabupaten)){
    $kab = KabupatenM::model()->findByAttributes(array('kabupaten_nama'=>$model->lahir_kabupaten));
    if (!empty($kab)) {
        $model->lahir_kabupaten = $kab->kabupaten_nama;
    }
    $dropKec = CHtml::listData(KecamatanM::model()->findAll("kecamatan_aktif = TRUE AND kabupaten_id = '".$kab->kabupaten_id."' ORDER BY kecamatan_nama ASC"), 'kecamatan_nama', 'kecamatan_nama');
}

if (!empty($model->lahir_kecamatan)){
    $kec = KecamatanM::model()->findByAttributes(array('kecamatan_nama'=>$model->lahir_kecamatan));
    if (!empty($kec)) {
        $model->lahir_kecamatan = $kec->kecamatan_nama;
    }

}
    
    
} else {

    if (!empty($model->lahir_propinsi)){
        $prop = PropinsiM::model()->findByPk($model->lahir_propinsi);//findByAttributes(array('propinsi_nama'=>$model->lahir_propinsi));
        // var_dump($prop);die;
        // var_dump($model->lahir_propinsi);die;
        // var_dump($modPasien->attributes);die;
        // var_dump($propinsi_id);die;
        if (!empty($prop)) {
            $model->lahir_propinsi = $prop->propinsi_nama;
            $dropKab = CHtml::listData(KabupatenM::model()->findAll("kabupaten_aktif = TRUE AND propinsi_id = '".$prop->propinsi_id."' ORDER BY kabupaten_nama ASC"), 'kabupaten_nama', 'kabupaten_nama');
        }
        
    }
    
    if (!empty($model->lahir_kabupaten)){
        $kab = KabupatenM::model()->findByPk($model->lahir_kabupaten);//findByAttributes(array('kabupaten_nama'=>$model->lahir_kabupaten));
        if (!empty($kab)) {
            $model->lahir_kabupaten = $kab->kabupaten_nama;
            $dropKec = CHtml::listData(KecamatanM::model()->findAll("kecamatan_aktif = TRUE AND kabupaten_id = '".$kab->kabupaten_id."' ORDER BY kecamatan_nama ASC"), 'kecamatan_nama', 'kecamatan_nama');

        }
    }
    
    if (!empty($model->lahir_kecamatan)){
        $kec = KecamatanM::model()->findByPk($model->lahir_kecamatan);//findByAttributes(array('kecamatan_nama'=>$model->lahir_kecamatan));
        if (!empty($kec)) {
            $model->lahir_kecamatan = $kec->kecamatan_nama;
        }
        
    }
    
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
.add-on{
    border: #ddd 1px solid;
    padding: 6px;
    border-radius: 5px;
}
</style>
<div class="row">
    <div class="col-md-12" style="text-align:center;">
        <?php
            echo CHtml::activeHiddenField($model,'suratketerangan_id',array()); 
        ?>
        <h2><b><u>SURAT KETERANGAN LAHIR</u></b></h2>
        <label class="font-15px">
            No. <?php echo CHtml::activeTextField($model,'nomorsurat', array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
      </label>
    </div>
</div>
<p>&nbsp;</p>
<div class="row">
    <div class="col-sm-12">       
        <p>
            <label class="font-13px">
                Yang Bertanda Tangan dibawah ini menerangkan bahwa
          </label>
        </p>
        <p>
            <label class="font-13px">
                Pada hari ini <?php echo CHtml::textField("hari", MyFormatter::getDayName($model->lahir_tgllahir['date']),array('readonly'=>true,'class'=>'span2')) ?> 
                tanggal <?php   
                
                $model2 = clone $model;
                
                //$tgl = MyFormatter::formatDateTimeForUser($model2->lahir_tgllahir['date']);
                // var_dump($model2->lahir_tgllahir['date']);die;
                $model2->lahir_tgllahir = array(
                    'date'=>MyFormatter::formatDateTimeForUser($model2->lahir_tgllahir['date']),
                    'time'=>$model2->lahir_tgllahir['time'],
                );
                
                
                $this->widget('MyDateTimePicker', array(
                                'model'=>$model2,
                                'attribute'=>'lahir_tgllahir[date]',
                                'name'=>'lahir_tgllahir[date]',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                    'line' => true
                                ),
                                'htmlOptions' => array('readonly' => true,
                                    'class'=>'span2',
                                    'onchange' => 'getTanggal(this);',
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                    )); ?> 
                    pukul 
                    <?php 
                $this->widget('MyDateTimePicker', array(
                            'model'=>$model,
                            'attribute'=>'lahir_tgllahir[time]',
                            'name'=>'lahir_tgllahir[time]',
                            'mode' => 'time',
                            'options' => array(
                                'line' => true
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'class'=>'span2',
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                    )); 
                ?> 
                    WIB, telah lahir bayi :  
          </label>
        </p>        
    </div>
</div>
<div class="row">   
    <div class="col-md-12" style="padding-left: 50px;">
        <label   class="font-13px">
            <table class="tabel-surat">
                <tr>
                    <td>Jenis kelamin</td>
                    <td> : </td>
                    <td> 
                        <?php
                            $jkPR = '';
                            $jkLK = '';
                            if (!empty($modKelahiran->jeniskelamin)){
                                if ($modKelahiran->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                                    $jkPR = 'line-words';
                                }else{
                                    $jkLK = 'line-words';
                                }
                            }
                        ?>
                        <span class='<?php echo $jkLK ?>'><?php echo Params::JENIS_KELAMIN_LAKI_LAKI; ?></span>
                            /
                        <span class='<?php echo $jkPR ?>'><?php echo Params::JENIS_KELAMIN_PEREMPUAN; ?></span>*
                    </td>
                </tr>
                <tr>
                    <td>Jenis kelahiran</td>
                    <td> : </td>
                    <td> 
                        <?php echo CHtml::link("Tunggal",'javascript:;',array('val' => Params::JENIS_KELAHIRAN_TUNGGAL,'id' => 'jnsLahir'.Params::JENIS_KELAHIRAN_TUNGGAL, 'onclick' => 'pilihJnsKelahiran(this)')) ?>/
                        <?php echo CHtml::link("Kembar 2",'javascript:;',array('val' => Params::JENIS_KELAHIRAN_KEMBAR2,'id' => 'jnsLahir'.Params::JENIS_KELAHIRAN_KEMBAR2, 'onclick' => 'pilihJnsKelahiran(this)')) ?>/
                        <?php echo CHtml::link("Kembar 3",'javascript:;',array('val' => Params::JENIS_KELAHIRAN_KEMBAR3,'id' => 'jnsLahir'.Params::JENIS_KELAHIRAN_KEMBAR3, 'onclick' => 'pilihJnsKelahiran(this)')) ?>/
                        <?php echo CHtml::link("Lainnya",'javascript:;',array('val' => Params::JENIS_KELAHIRAN_LAINNYA,'id' => 'jnsLahir'.Params::JENIS_KELAHIRAN_LAINNYA, 'onclick' => 'pilihJnsKelahiran(this)')) ?>*
                        <!--<span id='jnsLahir1'>Tunggal</span> / 
                        <span id='jnsLahir2'>Kembar 2</span> / 
                        <span id='jnsLahir3'>Kembar 3</span> / 
                        <span id='jnsLahir4'>Lainnya</span>*-->
                        <?php echo CHtml::activeHiddenField($model,'lahir_jeniskelahiran',array('readonly'=>true)) ?>
                    </td>
                </tr>                
                <tr>
                    <td>Persalinan ke</td>
                    <td> : </td>
                    <td> <?php echo CHtml::activeTextField($model, 'lahir_persalinan_ke', array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 numbers-only','placeholder'=>'', 'maxlength'=>4, 'style'=>'text-align: right;')); ?> </td>
                </tr>
                <tr>
                    <td>Berat lahir</td>
                    <td> : </td>
                    <td> <?php echo CHtml::activeTextField($model, 'lahir_beratbadan_gram', array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 numbers-only','placeholder'=>'Gr', 'maxlength'=>4, 'style'=>'text-align: right;')); ?> Gram</td>
                </tr>
                <tr>
                    <td>Panjang badan</td>
                    <td> : </td>
                    <td> <?php echo CHtml::activeTextField($model, 'lahir_panjangbadan_cm', array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 numbers-only','placeholder'=>'Cm', 'maxlength'=>2, 'style'=>'text-align: right;')); ?> Cm </td>
                </tr>
                <tr>
                    <td>Tempat lahir</td>
                    <td> : </td>
                    <td> 
                        <?php echo $data->nama_rumahsakit; ?><br> 
                        <?php echo $data->alamatlokasi_rumahsakit.' '.(!empty($data->kabupaten_id)?$data->kabupaten->kabupaten_nama:''); ?>
                        <?php $model->lahir_alamat_bayi = $data->nama_rumahsakit.'<br>'.$data->alamatlokasi_rumahsakit.' '.(!empty($data->kabupaten_id)?$data->kabupaten->kabupaten_nama:'');?>
                        <?php echo CHtml::activeHiddenField($model, 'lahir_alamat_bayi', array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Alamat Orangtua',)); ?>
                    </td>
                </tr>
                <tr>
                    <td>Nama Bayi</td>
                    <td> : </td>
                    <td> <?php echo CHtml::textField('nama_pasien',$modKelahiran->namabayi, array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?> </td>
                </tr>
                <tr>
                    <td>Dari Orang Tua</td>                    
                </tr>
                <tr>
                    <td>Nama Ibu</td>
                    <td> : </td>
                    <td> <?php echo CHtml::activeTextField($model, 'lahir_namaibu', array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Nama Ibu')); ?>
                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                        Usia Ibu<?php echo CHtml::activeTextField($model, 'lahir_ibu_umur', array('class'=>'numbers-only','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Usia Ibu')); ?>
                    </td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td> : </td>
                    <td> <?php echo CHtml::activeTextField($model, 'lahir_pekerjaan_ibu', array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Pekerjaan Ibu')); ?> </td>
                </tr>
                <tr>
                    <td>No. Identitas</td>
                    <td> : </td>
                    <td> <?php echo CHtml::activeTextField($model, 'lahir_ktp_ibu', array('class'=>'numbers-only','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. KTP Ibu')); ?> </td>
                </tr>
                <tr>
                    <td>Nama ayah</td>
                    <td> : </td>
                    <td> 
                        <?php echo CHtml::activeTextField($model, 'lahir_namaayah', array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Nama Ayah')); ?> 
                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                        Usia Ayah<?php echo CHtml::activeTextField($model, 'lahir_ayah_umur', array('class'=>'numbers-only','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Usia Ayah')); ?>
                    </td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td> : </td>
                    <td> <?php echo CHtml::activeTextField($model, 'lahir_pekerjaan_ayah', array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Pekerjaan Ayah')); ?> </td>
                </tr>
                <tr>
                    <td>No Identitas</td>
                    <td> : </td>
                    <td> <?php echo CHtml::activeTextField($model, 'no_ktp_ayah', array('class'=>'numbers-only','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','placeholder'=>'No. KTP Ayah')); ?> </td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td> : </td>
                    <td> <?php echo CHtml::activeTextArea($model, 'lahir_alamat', array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Alamat Orangtua',)); ?> </td>
                </tr>
                <tr>
                    <td>Propinsi</td>
                    <td> : </td>
                    <td> <?php echo CHtml::activeDropDownList($model, 'lahir_propinsi', CHtml::listData(PropinsiM::model()->findAll(" propinsi_aktif = TRUE ORDER BY propinsi_nama ASC "), 'propinsi_nama', 'propinsi_nama'),array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Provinsi','empty'=>'-- Pilih --',
                        'ajax'=>array(
                            'type'=>'POST',
                            'url'=>Yii::app()->createUrl('ActionDynamic/GetKabupatenNama',array('encode'=>false,'model_nama'=>get_class($model),'attr'=>'lahir_propinsi')),
                            'update'=> '#'.CHtml::activeId($model, 'lahir_kabupaten'),))); ?> </td>
                </tr>
                <tr>
                    <td>Kab/Kota</td>
                    <td> : </td>
                    <td> <?php echo CHtml::activeDropDownList($model, 'lahir_kabupaten', $dropKab,array('empty'=>'-- Pilih --','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Kabupaten',
                        'ajax'=>array(
					'type'=>'POST',
					'url'=>Yii::app()->createUrl('ActionDynamic/GetKecamatanNama',array('encode'=>false,'model_nama'=>get_class($model),'attr'=>'lahir_kabupaten')),
					'update'=>'#'.CHtml::activeId($model, 'lahir_kecamatan'),))); ?> </td>
                </tr>
                <tr>
                    <td>Kecamatan</td>
                    <td> : </td>
                    <td> <?php echo CHtml::activeDropDownList($model, 'lahir_kecamatan', $dropKec,array('empty'=>'-- Pilih --','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Kecamatan',)); ?> </td>
                </tr>
                
            </table>
      </label>
    </div>
</div>
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
                                Penolong Persalinan
                                <br><br><br><br><br>
                       
                        <?php
                                $penolong = new CDbCriteria();
                                $penolong->addCondition("pegawai_aktif = TRUE");
                                $penolong->addInCondition('ruangan_id',array(Params::RUANGAN_ID_KEBIDANAN_BPJS, Params::RUANGAN_ID_KEBIDANAN, Params::RUANGAN_ID_VK));
                                $penolong->addInCondition('kelompokpegawai_id',array(Params::KELOMPOKPEGAWAI_ID_BIDAN, Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK));
                                $penolong->order="nama_pegawai ASC";
                                    echo CHtml::activeDropDownList($model,'dokter_persalinan_id', CHtml::listData(PegawairuanganV::model()->findAll($penolong), 'pegawai_id', 'namaLengkap'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)", 'disabled' => $readonly));
                            ?>
                        
                    </td>
                </tr>
                <tr>
                    <td width="80%">
                        *Coret Salah Satu
                    </td>
                </tr>
            </table>
      </label>
    </div>
</div>
<script>
    function getTanggal(obj){
        var tgl = $(obj).val();
        var pisah = tgl.split(" ");
        
        $("#hari").val(getNamaHari(pisah[0],pisah[1],pisah[2]));
        
        $("#pukul").val(pisah[3]);
        
    }
    
    function pilihJnsKelahiran(obj){
        var val = $(obj).attr('val');
        
        $("[id^=jnsLahir]").each(function(){
           if ($(this).attr('val') != val){
               $(this).addClass('line-words');
           }else{
               $(this).removeClass('line-words');
               $("#<?php echo CHtml::activeId($model, 'lahir_jeniskelahiran') ?>").val(val);
           }
        });
    }
    
    $(document).ready(function(){
        var val = $("#<?php echo CHtml::activeId($model, 'lahir_jeniskelahiran') ?>").val();
    
        $("[id^=jnsLahir]").each(function(){            
            if (val != ''){
                if ($(this).attr('val') != val){                               
                     $(this).addClass('line-words');                
                }else{               
                     $(this).removeClass('line-words');                                  
                }
            }
        });
        <?php if($readonly):?>
                $('input,select,textarea').attr('disabled', true);
                $('.multiselect-selected-text').attr('disabled', true);
           <?php endif;?>
    });
</script>