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
    
    if(!empty($modPendaftaran->pegawai_id)){
        $cekPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
        $model->dokter = $cekPegawai->namaLengkap;
        $model->jabatan= (isset($cekPegawai->jabatan_id) ? $cekPegawai->jabatan->jabatan_nama : "");
        if(empty($model->no_sk)){
            /*
            $cekSIP = StrT::model()->findByAttributes(array('pegawai_id'=>$modPendaftaran->pegawai_id, 'jenis_str'=>'SIP'));
            if(!empty($cekSIP)){
                $model->no_sk = !empty($cekSIP->no_sk) ? $cekSIP->no_sk : '-';
            }else{
                $model->no_sk = '-';
            }
             * 
             */
        }else{
            $model->no_sk = $model->no_sk;
        }
    }
    
    $cekPendaftaran = PendaftaranT::model()->findByPk($cekSurat->pendaftaran_id);    
    $cekPasien = PasienM::model()->findByAttributes(array('pasien_id'=>$cekPendaftaran->pasien_id));
    $cekPegawai = PegawaiM::model()->findByPk($model->mengetahuipeg_id);
    $model->dokter = $cekPegawai->namaLengkap;
    $model->jabatan= (isset($cekPegawai->jabatan_id) ? $cekPegawai->jabatan->jabatan_nama : "");
    
    $modPasien->nama_pasien = $cekPasien->nama_pasien;
    $modPasien->jeniskelamin = $cekPasien->jeniskelamin;
    $modPasien->alamat_pasien = strtoupper($cekPasien->alamat_pasien.', '.$cekPasien->kecamatan->kecamatan_nama.', '.$cekPasien->kabupaten->kabupaten_nama);
    $model->suratketerangan_id = $cekSurat->suratketerangan_id;
    if(!empty($cekSurat)){ 
        $cekLampiran = RKLampiransuratsehatR::model()->findAllByAttributes(array('suratketerangan_id'=>$model->suratketerangan_id)); 
    }
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
    <table ALIGN="CENTER" style="margin-left:100px; text-align: center;">
         <tr>
            <td ALIGN=CENTER VALIGN=MIDDLE>
                <b>
                    <span SIZE=4> 
                    SURAT KETERANGAN SEHAT FISIK DAN MENTAL <br> 
                    UNTUK DAPAT MELAKSANAKAN PRAKTIK KEDOKTERAN
                    </span>
                </b>
            </td>
        </tr>
    </table>
    
    </br><br>
    <p align="justify">
        Yang bertanda tangan dibawah ini :
    </p>
    <p align="justify">
        <table width="100%" style="margin-left:50px;">
            <tr>
                <td style="width:15%">Dokter</td>
                <td><?php echo CHtml::textField('dokter',$model->dokter, array('class'=>'span7','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
             <tr>
                <td style="width:15%">NPA IDI</td>
                <td><?php echo CHtml::activetextField($model,'npaidi_dokter', array('class'=>'span7','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td style="width:15%">S.I.P</td>
                <td><?php echo CHtml::activetextField($model,'no_sk', array('class'=>'span7','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>            
            <tr>
                <td style="width:15%">Jabatan</td>
                <td><span>Dokter Pemeriksa Kesehatan di IDI Cabang</span> <?php echo CHtml::activetextField($model,'idi_cabang', array('style'=>'width:280px','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td style="width:15%"></td>
                <td><span>Surat Keputusan</span> 
                    <?php echo CHtml::activetextField($model,'suratkeputusan', array('style'=>'width:203px','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <span> No. </span>
                    <?php echo CHtml::activetextField($model,'suratkeputusan_no', array('style'=>'width:200px','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </td>
            </tr>
        </table>
        <br>
        <p align="justify">Menerangkan Bahwa :</p>
        <table width="100%" style="margin-left:50px;">
            <tr>
                <td style="width:15%">Nama</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->nama_pasien, array('class'=>'span7','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
             <tr>
                <td style="width:15%">Umur</td>
                <td>
                    <?php 
                    $umur = explode(' ',$modPendaftaran->umur);
                    echo CHtml::textField('nama_pasien',$umur[0].' TAHUN', array('class'=>'span7','readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            </tr>          
            <tr>
                <td style="width:15%">Alamat</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->alamat_pasien, array('class'=>'span7','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td style="width:15%">Spesialis</td>
                <td><?php echo CHtml::activetextField($model,'spesialis', array('class'=>'span7','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td style="width:15%; vertical-align: top; padding-top: 7px">Hasil Pemeriksaan</td>
                <td>
                    <table id="tbl-Lampiran" border="0px" width="15% !important">
                        <tbody>
                            <?php
                                if (!empty($cekLampiran)){
                                    foreach($cekLampiran as $i => $det){
                                        echo $this->renderPartial($this->path_view.'keteranganSehat._rowTabel2',array('modLampiran'=>$det, 'i'=>$i)); 
                                    }
                                }else{                        
                                    echo $this->renderPartial($this->path_view.'keteranganSehat._rowTabel2',array('modLampiran'=>$modLampiran, 'i'=>0)); 
                                }
                            ?>
                        </tbody>
                    </table>  
                </td>
            </tr>
            <tr>
                <td style="width:15%">Tempat</td>
                <td><?php $model->tempat = Yii::app()->user->getState('kabupaten_nama'); echo CHtml::textField('tempat',$model->tempat, array('class'=>'span7','readonly'=>true)); ?></td>
            </tr>
            <tr>
                <td style="width:15%">Tanggal</td>
                <td>
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
                                'class'=>'span7 tglpemeriksaan',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        )); ?>
                </td>
            </tr>
        </table>
<br><br><br>
<div class="">
    <div class="">
        <label class="font-13px"  style="width:100%">
            <table class="tabel-surat">
                <tr>
                    <td width="80%" style="text-align: left;">
                    </td>
                    <td width="19%" style="text-align: center;">
                        Dokter Pemeriksa
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
    $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/PrintSuratKeteranganSehatFisikdanMental&suratketerangan_id='.$model->suratketerangan_id);
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
               $(this).removeClass('line-words');
           }else{
               $(this).addClass('line-words');
               $("#<?php echo CHtml::activeId($model, 'status_fisik') ?>").val(val);
           }
        });
    }
    
    $(document).ready(function(){
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
