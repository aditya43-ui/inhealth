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
$format = new MyFormatter();
$cekSurat = RKSuratketeranganR::model()->findByAttributes(array('jenissurat_id'=>$_POST["jenissurat_id"], 'pendaftaran_id'=>$_POST["id"], 'ruangan_id'=>Yii::app()->user->getState('ruangan_id')));
if(!empty($cekSurat)){
    $tinggibadan = $cekSurat->tinggibadan;
    $beratbadan = $cekSurat->beratbadan;
    $tekanandarah_sistolik = $cekSurat->tekanandarah_sistolik;
    $tekanandarah_diastolik = $cekSurat->tekanandarah_diastolik;
    $diagnosis = $cekSurat->keterangan; 
    $model->nomorsurat = $cekSurat->nomorsurat;
    
    $cekPendaftaran = PendaftaranT::model()->findByPk($cekSurat->pendaftaran_id);    
    $cekPasien = PasienM::model()->findByAttributes(array('pasien_id'=>$cekPendaftaran->pasien_id));
    
    $modPasien->nama_pasien = $cekPasien->nama_pasien;
    $modPasien->jeniskelamin = $cekPasien->jeniskelamin;
    $modPasien->alamat_pasien = strtoupper($cekPasien->alamat_pasien.', '.$cekPasien->kecamatan->kecamatan_nama.', '.$cekPasien->kabupaten->kabupaten_nama);
    $model->suratketerangan_id = $cekSurat->suratketerangan_id;
    
}else{
    
    $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    if(!empty($_POST["id"])){
        $pendaftaran_id = $_POST["id"];
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

    if(!empty($modFisik)){
        $tinggibadan = $modFisik->tinggibadan;
        $beratbadan = $modFisik->beratbadan;
        $tekanandarah_sistolik = $modFisik->tekanandarah_sistolik;
        $tekanandarah_diastolik = $modFisik->tekanandarah_diastolik;
        $diagnosis = $modFisik->diagnosis;
    }
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
    
    .transform{
        text-transform: uppercase;
    }
</style>
    <TABLE ALIGN="CENTER" style="margin-left:100px; text-align: center;">
         <tr>
            <td ALIGN=CENTER VALIGN=MIDDLE>
                <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN SEHAT"; ?></U></span></B>
            </td>
        </tr>
         <tr>
            <td ALIGN=CENTER VALIGN=MIDDLE>
                <B>
                    <span FACE="Liberation Serif" SIZE=4> NO : 
                    <?php
                    
                    if(!empty($cekSurat)){
                        echo CHtml::activeTextField($model,'nomorsurat', array('onkeypress'=>"return $(this).focusNextInputField(event)")); 
                    }else{
                        $model->nomorsurat = '--- Otomatis ---';
                        echo CHtml::activeTextField($model,'nomorsurat', array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)")); 
                    }
                    ?>
                    </span>
                </B>
            </td>
        </tr>
    </TABLE>
    
    </br><br>
    <p align="justify">
        Yang bertanda tangan dibawah ini menerangkan bahwa :
    </p>
    <p align="justify">
        <table width="100%" style="width:500px;margin-left:50px;">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->nama_pasien, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
             <tr>
                <td>Umur</td>
                <td>:</td>
                <td>
                    <?php 
                    if(!empty($cekSurat)){
                        $umur = explode(' ',$cekPendaftaran->umur);
                    }else{
                        $umur = explode(' ',$modPendaftaran->umur);
                    }
                    echo CHtml::textField('nama_pasien',$umur[0].' TAHUN', array('readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?php echo CHtml::textField('jeniskelamin',$modPasien->jeniskelamin, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>            
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->alamat_pasien, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
        </table>
        <br>
        <p align="justify">Setelah dilakukan pemeriksaan secara seksama pada saat ini dinyatakan :</p>
        <TABLE width="100%" style="width:500px;">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <?php echo CHtml::dropDownList('RKSuratketeranganR[status_fisik]',$model->status_fisik,LookupM::model()->getItems('status_surat_sehat'),array('empty'=>'-- Pilih --')) ?>
                </td>
            </tr>
        </TABLE>
            
        </p>
        <p align="justify">
        Demikian surat keterangan ini kami berikan untuk melengkapi persyaratan :
        </p>
        <TABLE width="100%" style="width:500px;">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <?php
                    if(!empty($modFisik)){
                        echo CHtml::activeTextField($model,'keterangan',array('onkeyup' => 'upper(this);','class'=>'span5 transform','onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Surat untuk', 'value'=>$diagnosis));
                    } else{
                        echo CHtml::activeTextField($model,'keterangan',array('onkeyup' => 'upper(this);','class'=>'span5','onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Surat untuk'));
                    }
                    ?>
                    
                </td>
            </tr>
        </TABLE>
        <br>
            <table width="100%" style="width:500px;margin-left:50px;">
                <tr>
                    <td>Tinggi Badan</td>
                    <td>:</td>
                    <td><?php 
                        if(!empty($modFisik)){
                            echo CHtml::activeTextField($model,'tinggibadan',array('class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Tinggi Badan', 'value'=>$tinggibadan));
                        } else{
                            echo CHtml::activeTextField($model,'tinggibadan',array('class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Tinggi Badan'));;
                        }
                        ?> cm
                    </td>
                </tr>
                 <tr>
                    <td>Berat Badan</td>
                    <td>:</td>
                    <td><?php 
                        if(!empty($modFisik)){
                            echo CHtml::activeTextField($model,'beratbadan',array('class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Berat Badan', 'value'=>$beratbadan));
                        } else{
                            echo CHtml::activeTextField($model,'beratbadan',array('class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Berat Badan'));
                        }
                        ?> kg
                    </td>
                </tr>
                <tr>
                    <td>Tensi</td>
                    <td>:</td>
                    <td><?php 
                        if(!empty($modFisik)){
                            echo CHtml::activeTextField($model,'tekanandarah_sistolik',array('class'=>'span1 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Tekanan Darah', 'value'=>$tekanandarah_sistolik)); ?> / 
                            <?php echo CHtml::activeTextField($model,'tekanandarah_diastolik',array('class'=>'span1 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Tekanan Darah', 'value'=>$tekanandarah_diastolik));
                        
                        } else{
                            echo CHtml::activeTextField($model,'tekanandarah_sistolik',array('class'=>'span1 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Tekanan Darah')); ?> / 
                            <?php echo CHtml::activeTextField($model,'tekanandarah_diastolik',array('class'=>'span1 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Tekanan Darah'));
                        }
                        ?> mmhg
                    </td>
                </tr>            
            </table>
        </p>        
<br><br><br>
<div class="">
    <div class="">
        <label class="font-13px"  style="width:100%">
            <table class="tabel-surat">
                <tr>
                    <td width="80%" style="text-align: left;">
                        <?php if(!empty($cekSurat)){ 
                            $cekLampiran = RKLampiransuratsehatR::model()->findAllByAttributes(array('suratketerangan_id'=>$model->suratketerangan_id)); 
                        ?>
                        Lampiran/catatan<br> 
                        <?php } ?>
                        <table id="tbl-Lampiran" border="0px" width="20% !important">
                            <tbody>
                                <?php
                                    if (!empty($cekLampiran)){
                                        foreach($cekLampiran as $i => $det){
                                            echo $this->renderPartial($this->path_view.'keteranganSehat._rowTabel',array('modLampiran'=>$det, 'i'=>$i)); 
                                        }
                                    }else{                        
                                        echo $this->renderPartial($this->path_view.'keteranganSehat._rowTabel',array('modLampiran'=>$modLampiran, 'i'=>0)); 
                                    }
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <span style="color:red; font-size: 10px">
                            *) Jika tidak ada yang ingin di lampirkan, <br>&nbsp;&nbsp;&nbsp; hapus field lampiran menggunakan tombol <?php echo CHtml::link('<i class="icon-minus icon-white"></i>', '#', array('disabled'=>true, 'class'=>'btn btn-xs btn-primary', 'onclick'=>'#', )); ?>
                        </span>
                    </td>
                    <td width="19%" style="text-align: center;">                        
                        <?php echo Yii::app()->user->getState('kabupaten_nama') ?>,
                            <?php   
                                $this->widget('MyDateTimePicker', array(
                                    'model'=>$model,
                                    'attribute'=>'tglsurat',
                                    'name'=>'tglsurat',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'line' => true
                                    ),
                                    'htmlOptions' => array(
                                        'class'=>'span2 tglpemeriksaan',
//                                        'onchange' => 'getTanggal(this);',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                        )); ?><br>
                        Pemeriksa
                        <br><br><br><br><br>
                        <?php 
                            if(!empty($modPendaftaran->pegawai_id)){
                                $model->mengetahuipeg_id = $modPendaftaran->pegawai_id;
                                echo CHtml::activeDropDownList($model,'mengetahuipeg_id', CHtml::listData($model->getDokterItems(Yii::app()->user->getState('ruangan_id')), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)"));
                            }else{
                                echo CHtml::activeDropDownList($model,'mengetahuipeg_id', CHtml::listData($model->getDokterItems(Yii::app()->user->getState('ruangan_id')), 'pegawai_id', 'namaLengkap'), array('onkeypress'=>"return $(this).focusNextInputField(event)"));
                            } 
                            echo CHtml::activeHiddenField($model,'suratketerangan_id', array('onkeypress'=>"return $(this).focusNextInputField(event)")); 
                            
                            // echo CHtml::activeTextField($model,'no_sk',array('class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Nomor. SIP')) ; 
                        ?>
                    </td>
                    </td>
                </tr>
            </table>
      </label>
    </div>
</div>
</TABLE>

<div class="form-actions" <?=$hidden?>>
<?php
    if(!empty($model->suratketerangan_id)){
        echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
        array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 
                'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>false)); 

        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
    }else{
        echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
        array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 
                'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>true,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
    }
?>
<?php if (!empty($model->suratketerangan_id)){
    $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/PrintSuratKeteranganSehat&suratketerangan_id='.$model->suratketerangan_id);
}else{
    $urlPrint='';
}
$sip = " ";
?>
</div>
<script type="text/javascript">
    function setSIP(){
        var peg = $("#RKSuratketeranganR_mengetahuipeg_id").val();
        
        if (peg != ''){
            $.ajax({
                type:'POST',
                data: {peg : peg},
                url:'<?php echo $this->createUrl('generateSIP'); ?>',
                dataType: "json",
                success:function(data) {
                    if (data.ok != 1) {
                        toastr.warning(data.msg);
                        $("#RKSuratketeranganR_no_sk").val("");
                        return false;
                    }
                setVal(data.data);
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else{
            myAlert('Tidak ada data STR');
            $("#RKSuratketeranganR_no_sk").val("");
            return false;
        }
    }
    
    function setVal(data){
         $("#RKSuratketeranganR_no_sk").val(data.no_sk);
    }
    
    function print(caraPrint)
    {
        window.open("<?php echo $urlPrint ?>&caraPrint="+caraPrint,"",'location=_new, width=980px');
    }

    function upper(obj)
    {
        var upper = $(obj).val().toUpperCase();

        $(obj).val(upper);
    }
    
    function removeRow(obj) {
        myConfirm("Anda yakin untuk menghapus baris ini?", "Peringatan", function(r) {
            if (r) {
                $(obj).parent().parent('tr').detach();
            }
        });
    }
    
    function addRow(obj){
        var tr = $('#tbl-Lampiran tbody tr:first').html();

        $('#tbl-Lampiran tr:last').after('<tr>'+tr+'</tr>');
        $('#tbl-Lampiran tr:last td:last');

        renameInput($('#tbl-Lampiran'));
        $('#tbl-Lampiran tr:last').find('input').val('');
    }

    function renameInput(obj_table){
        var row = 0;
        $(obj_table).find("tbody > tr").each(function(){

            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
            });

            row++;
        });
    }
    
    //Fungsi untuk mencoret data ketika data tersebut tidak dipilih
    function pilihFisik(obj){
        var val = $(obj).attr('val');
        
        $("[id^=fisik]").each(function(){
           if ($(this).attr('val') != val){
               $(this).removeClass('line-words');
           }else{
               $(this).addClass('line-words');
               $("#<?php echo CHtml::activeId($model, 'status_fisik') ?>").val(val);
           }
        });
    }
    
    $(document).ready(function(){
        // setSIP();
        var val = $("#<?php echo CHtml::activeId($model, 'status_fisik') ?>").val();
        $("[id^=fisik]").each(function(){            
            if (val != ''){
                if ($(this).attr('val') != val){                               
                     $(this).removeClass('line-words');                
                }else{               
                     $(this).addClass('line-words');                                  
                }
            }
        });
    });
</script>
