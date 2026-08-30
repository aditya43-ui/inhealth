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
    $cekPegawai = PegawaiM::model()->findByPk($model->mengetahuipeg_id);
    $model->dokter = $cekPegawai->namaLengkap;
    $model->jabatan= (isset($cekPegawai->jabatan_id) ? $cekPegawai->jabatan->jabatan_nama : "");
    
    if(!empty($modPendaftaran->pegawai_id)){
        $cekPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
        $model->dokter = $cekPegawai->namaLengkap;
        $model->jabatan= (isset($cekPegawai->jabatan_id) ? $cekPegawai->jabatan->jabatan_nama : "");
        /*
        $cekSIP = StrT::model()->findByAttributes(array('pegawai_id'=>$modPendaftaran->pegawai_id, 'jenis_str'=>'SIP'));
        if(!empty($cekSIP)){
            $model->sip = !empty($cekSIP->no_sk) ? $cekSIP->no_sk : '-';
        }else{
            $model->sip = '-';
        }
         * 
         */
    }

    $modPasien->nama_pasien = $cekPasien->nama_pasien;
    $modPasien->jeniskelamin = $cekPasien->jeniskelamin;
    $modPasien->alamat_pasien = strtoupper($cekPasien->alamat_pasien.', '.$cekPasien->kecamatan->kecamatan_nama.', '.$cekPasien->kabupaten->kabupaten_nama);
    $model->pekerjaan = $cekPasien->pekerjaan_id;
    $model->suratketerangan_id = $cekSurat->suratketerangan_id;
    
}else{
    $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    if(!empty($_POST["id"])){
        $pendaftaran_id = $_POST["id"];
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model->mengetahui_surat = $modPendaftaran->pegawai->nama_pegawai;
        
        if(!empty($modPendaftaran->pegawai_id)){
            $cekPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
            $model->dokter = $cekPegawai->namaLengkap;
            $model->jabatan= (isset($cekPegawai->jabatan_id) ? $cekPegawai->jabatan->jabatan_nama : "");
            /*
            $cekSIP = StrT::model()->findByAttributes(array('pegawai_id'=>$modPendaftaran->pegawai_id, 'jenis_str'=>'SIP'));
            if(!empty($cekSIP)){
                $model->sip = !empty($cekSIP->no_sk) ? $cekSIP->no_sk : '-';
            }else{
                $model->sip = '-';
            }
             * 
             */
        }
        
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
    

    if(!empty($modFisik)){
        $tinggibadan = $modFisik->tinggibadan;
        $beratbadan = $modFisik->beratbadan;
        $tekanandarah_sistolik = $modFisik->tekanandarah_sistolik;
        $tekanandarah_diastolik = $modFisik->tekanandarah_diastolik;
        $diagnosis = $modFisik->diagnosis;
    }
}

echo CHtml::activehiddenField($model,'tinggibadan', array('onkeypress'=>"return $(this).focusNextInputField(event)")); 
echo CHtml::activehiddenField($model,'beratbadan', array('onkeypress'=>"return $(this).focusNextInputField(event)")); 
echo CHtml::activehiddenField($model,'tekanandarah_sistolik', array('onkeypress'=>"return $(this).focusNextInputField(event)")); 
echo CHtml::activehiddenField($model,'tekanandarah_diastolik', array('onkeypress'=>"return $(this).focusNextInputField(event)")); 

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
                    <span FACE="Liberation Serif" SIZE=4>NO : 
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

                <?php
                    echo CHtml::activeHiddenField($model,'suratketerangan_id',array()); 
                ?>
            </td>
        </tr>
    </TABLE>
    
    </br><br>
    <p align="justify">
        Yang bertanda tangan dibawah ini :
    </p>
    <p align="justify">
        <table width="100%" style="width:500px;margin-left:50px;">
            <tr>
                <td style="width:20%">Dokter</td>
                <td>:</td>
                <td><?php echo CHtml::textField('dokter',$model->dokter, array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <?php /*
             <tr>
                <td style="width:20%">SIP</td>
                <td>:</td>
                <td><?php echo CHtml::textField('sip',$model->sip, array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
             * 
             */ ?>
            <tr>
                <td style="width:20%">Jabatan</td>
                <td>:</td>
                <td><?php echo CHtml::textField('jabatan',$model->jabatan, array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
        </table>
        <br>
        <p align="justify">Menerangkan Bahwa :</p>
        <br>
        <table width="100%" style="width:500px;margin-left:50px;">
            <tr>
                <td style="width:20%">Nama</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->nama_pasien, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
             <tr>
                <td style="width:20%">Umur</td>
                <td>:</td>
                <td>
                    <?php 
                    $umur = explode(' ',$modPendaftaran->umur);
                    echo CHtml::textField('nama_pasien',$umur[0].' TAHUN', array('readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            </tr>
            <tr>
                <td style="width:20%">Jenis Kelamin</td>
                <td>:</td>
                <td><?php echo CHtml::textField('jeniskelamin',$modPasien->jeniskelamin, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>            
            <tr>
                <td style="width:20%">Alamat</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->alamat_pasien, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td style="width:20%">Pekerjaan</td>
                <td>:</td>
                <td><?php echo CHtml::activeDropDownList($model,'pekerjaan', CHtml::listData(PekerjaanM::model()->findAll(), 'pekerjaan_id', 'pekerjaan_nama'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
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
                                        'onchange' => 'getTanggal(this);',
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
                            ?>
                    </td>
                    </td>
                </tr>
            </table>
      </label>
    </div>
</div>
</TABLE>

<div class="form-actions">
    <?php
        if(!empty($cekSurat)){
            echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
            array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 
                    'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); 
           echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
        }else{
            echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
            array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 
                    'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>true,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
        }
    ?>
    </div>
    <?php if (!empty($model->suratketerangan_id)){
        $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/PrintSuratKeteranganSehatDokter&suratketerangan_id='.$model->suratketerangan_id);
    }else{
        $urlPrint='';
    }
    ?>
</div>
<script type="text/javascript">
    
    
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
               $(this).addClass('line-words');
           }else{
               $(this).removeClass('line-words');
               $("#<?php echo CHtml::activeId($model, 'status_fisik') ?>").val(val);
           }
        });
    }
    
    $(document).ready(function(){
        var val = $("#<?php echo CHtml::activeId($model, 'status_fisik') ?>").val();
        $("[id^=fisik]").each(function(){            
            if (val != ''){
                if ($(this).attr('val') != val){                               
                     $(this).addClass('line-words');                
                }else{               
                     $(this).removeClass('line-words');                                  
                }
            }
        });
    });
</script>
