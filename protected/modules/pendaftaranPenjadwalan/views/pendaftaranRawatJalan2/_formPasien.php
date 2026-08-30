<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jpegcam/assets/webcam.js'); ?>
<?php
$nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps" : "");
$alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps" : "");
?>
<style>
    .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
    }
</style>
<?php
if (!isset($_GET['sukses'])) {
    if (Yii::app()->user->getState('is_finger_pasien')) {
?>
        <div class="col-sm-12">
            <div class="control-group">
                <div class="controls">
                    <label>
                        <div id="loading"></div>
                        <?php if (Yii::app()->user->getState('modul_id') != Params::MODUL_ID_HEMO) echo CHtml::button("Pendaftaran Sidik Jari", array('id' => 'pendaftaranFP', 'onclick' => 'setPendaftaranFP();', 'class' => 'btn btn-primary', 'style' => 'background:#ff0909;border:1px solid #ff0909;')); ?>
                        <?php echo CHtml::button("Verifikasi Sidik Jari", array('id' => 'verifikasiFP', 'onclick' => 'setVerifikasiFP();', 'class' => 'btn btn-primary', 'style' => 'background:#142ffb;border:1px solid #142ffb;')); ?>
                        <div id="pesanVerifikasi"></div>
                  </label>
                </div>
            </div>
        </div>
<?php
    }
}

$konSys = KonfigsystemK::model()->find();
if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_MCU) {
    $dialogPasienPeg = 'dialog_pasien_pegawai';
    $urlPegawai = '';
    $gelar = 'ada';
    $onblur = 'valNIK(this);';
} else {
    $dialogPasienPeg = 'dialogPasienBadak';
    $urlPegawai = $this->createUrl('AutocompletePasienLama');
    $gelar = 'tidak';
    $onblur = '';
}
?>
<div class="col-sm-6">

    <div class="control-group" <?php echo (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_HEMO) ? "hidden" : ""; ?>>
        <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::radioButton('rb_rm', false, array(
                'value' => 1,
                'name' => 'otomatis',
                'uncheckValue' => null,
                'onchange' => 'switchOtomatis(this)',
                'class' => 'rb_rm rmbaru',
            )) . "<label>Pasien Baru</label> ";
            echo CHtml::radioButton('rb_rm', false, array(
                'value' => 0,
                'name' => 'otomatis',
                'uncheckValue' => null,
                'onchange' => 'switchOtomatis(this)',
                'class' => 'rb_rm rmlama',
            )) . "<label>Pasien Lama</label> ";
            ?>
        </div>
    </div>



    <?php if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_HEMO) { ?>
        <div class="control-group">
            <?php echo CHtml::label("Cari NIP", 'nomorindukpegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'cari_nomorindukpegawai',
                    'value' => $modPegawai->nomorindukpegawai,
                    'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompletePasienLama') . '",
                                                   dataType: "json",
                                                   data: {
                                                       nomorindukpegawai: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                        'select' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            setPasienLama(ui.item.pasien_id,ui.item.no_rekam_medik);
                                            return false;
                                        }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPasienPegawai'),
                    'htmlOptions' => array(
                        'placeholder' => 'NIP', 'rel' => 'tooltip', 'title' => 'Ketik NIP untuk mencari pasien',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        //                                    'onblur'=>"if($(this).val()=='') setPasienBaru(); else setPasienLama('',this.value)",
                        'class' => 'numbers-only'
                    ),
                ));
                ?>
                <?php // echo $form->error($modPasien,'no_rekam_medik'); 
                ?>
                <?php // echo $form->hiddenField($modPasien,'pasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); 
                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label($modPasien->getAttributeLabel('no_rekam_medik') . " <span class=\"required\">*</span>", 'no_rekam_medik', array('class' => 'control-label required')) ?>
            <?php // echo CHtml::label("Cari ".$modPasien->getAttributeLabel('no_rekam_medik'), 'no_rekam_medik', array('class'=>'control-label'))
            ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modPasien,
                    'attribute' => 'no_rekam_medik',
                    'value' => $modPasien->no_rekam_medik,
                    'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompletePasienLama') . '",
                                                   dataType: "json",
                                                   data: {
                                                       no_rekam_medik: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                    'options' => array(
                        'minLength' => 4,
                        'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                        'select' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            setPasienLama(ui.item.pasien_id,ui.item.no_rekam_medik);
                                            return false;
                                        }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPasien'),
                    'htmlOptions' => array(
                        'placeholder' => 'No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'No. RM untuk mencari pasien',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        //                                    'onblur'=>"if($(this).val()=='') setPasienBaru(); else setPasienLama('',this.value)",
                        'class' => 'numbers-only span2'
                    ),
                ));
                ?>
                <?php // echo $form->error($modPasien,'no_rekam_medik'); 
                ?>
                <?php // echo $form->hiddenField($modPasien,'pasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); 
                ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="control-group rm_baru rm_state" hidden>
            <?php echo CHtml::label("Cari NIP", 'nomorindukpegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'cari_nomorindukpegawai',
                    'value' => $modPegawai->nomorindukpegawai,
                    'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompletePasienLama') . '",
                                                   dataType: "json",
                                                   data: {
                                                       nomorindukpegawai: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                        'select' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            setPasienLama(ui.item.pasien_id);
                                            return false;
                                        }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPasienBadak'),
                    'htmlOptions' => array(
                        'placeholder' => 'NIP', 'rel' => 'tooltip', 'title' => 'Ketik NIP untuk mencari pasien',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        //                                    'onblur'=>"if($(this).val()=='') setPasienBaru(); else setPasienLama('',this.value)",
                        'class' => 'numbers-only form-control delapan'
                    ),
                ));
                ?>
                <?php // echo $form->error($modPasien,'no_rekam_medik'); 
                ?>
                <?php // echo $form->hiddenField($modPasien,'pasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); 
                ?>
            </div>
        </div>

        <div class="control-group rm_nip_baru">
            <?php echo CHtml::label("NIP", 'nomorindukpegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modPasien,
                    'attribute' => 'nomorindukpegawai',
                    'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('autocompletePegawaiUntukPasienBaru') . '",
                                       dataType: "json",
                                       data: {
                                           nip: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                 return false;
                             }',
                        'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.nip);
                                setPegawai(ui.item.pegawai_id, ui.item.nip);
                                return false;
                            }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'NIP', 'rel' => 'tooltip', 'title' => 'Ketik NIP untuk mencari Pegawai',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        // 'onblur'=>"setPegawai(null, this.value); return false;",
                        'class' => 'numbers-only form-control span3'
                    ),
                ));
                ?>
                <?php echo $form->hiddenField($modPasien, 'pegawai_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
            </div>
        </div>

        <div class="control-group rm_baru" id="no_rm_lama" hidden>

            <?php echo CHtml::label($modPasien->getAttributeLabel('no_rekam_medik') . " <span class=\"required\">*</span>", 'no_rekam_medik', array("id" => "lb_rm_lama", 'class' => 'control-label required')) ?>
            <div class="controls">

                <?php $this->widget('MyJuiAutoComplete', array(
                    'model' => $modPasien,
                    'attribute' => 'no_rekam_medik',
                    'value' => $modPasien->no_rekam_medik,
                    'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompletePasienLama') . '",
                                                   dataType: "json",
                                                   data: {
                                                       no_rekam_medik: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                    'options' => array(
                        'minLength' => 4,
                        'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                        'select' => 'js:function( event, ui ) {
                                            console.log("A1");
                                            $(this).val( ui.item.value);
                                            setPasienLama(ui.item.pasien_id);
                                            return false;
                                        }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPasien'),
                    'htmlOptions' => array(
                        'placeholder' => 'No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'No. RM untuk mencari pasien',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => "cekNoRM();if($(this).val()==''){setPasienBaru();}else{setPasienLama('',this.value, true)}",
                        'class' => 'numbers-only f_rm form-control delapan', 'maxlength' => 6, 'id' => 'no_rekam_medik_baru'
                    ),
                )); ?>
                <?php  /*echo $form->textField($modPasien, 'no_rekam_medik', array(
                'id'=>'no_rekam_medik_baru', 
                'class'=>'numbers-only span3',
                'rel'=>'tooltip',
                'title'=>'No. RM pasien yang ada sebelumnya',
                'maxlength'=>6,
            )); */ ?>
                <?php
                //                    echo '<pre>';
                //                    print_r($modPasien->no_rekam_medik);
                //                    exit();
                //                    
                ?>
            </div>
        </div>
    <?php } ?>
    <div class="control-group rm_lama rm_state" hidden>
        <?php echo CHtml::label("Cari " . $modPasien->getAttributeLabel('no_rekam_medik'), 'no_rekam_medik', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'cari_no_rekam_medik',
                'value' => $modPasien->no_rekam_medik,
                'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompletePasienLama') . '",
                                                   dataType: "json",
                                                   data: {
                                                       no_rekam_medik: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                'options' => array(
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                    'select' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            setPasienLama(ui.item.pasien_id);
                                            return false;
                                        }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogPasien'),
                'htmlOptions' => array(
                    'placeholder' => 'No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'No. RM untuk mencari pasien',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onblur' => "if($(this).val()=='') setPasienBaru(); else setPasienLama('',this.value)",
                    'class' => 'numbers-only f_rm', 'maxlength' => 6,
                ),
            ));
            ?>
            <?php echo $form->error($modPasien, 'no_rekam_medik'); ?>
            <?php echo $form->hiddenField($modPasien, 'pasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        </div>
    </div>
    <?php /*
    <div class="control-group">
        <?php echo $form->labelEx($modPasien,'no_jamkespa', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modPasien, 'no_jamkespa', array('class'=>'span3 numbers-only')); ?>
            <?php echo $form->error($modPasien,'no_jamkespa'); ?>
        </div>
    </div>
	 * 
	 */ ?>
    <?php /*
    <div class="control-group normpilihan hide ">        
        <label class="control-label"></label>
        <div class="controls"  data-toggle="tooltip" data-original-title="Ceklis, jika Anda ingin generate nomor RM, sesuai range yang sudah ditentukan, jika pada range tersebut sudah terisi semua, maka otomatis akan digenerate diluar dari range tersebut" data-html="true">           
            <?php echo CHtml::checkBox("generateNoRM",false,array('value' => $konSys->normlama_maks)); ?> <label>&nbsp; No RM sesuai range <?php echo $konSys->normlama_min; ?> s/d <?php echo $konSys->normlama_maks; ?></label>            
        </div>
    </div>
     * 
     */ ?>
    <div class="control-group">
        <?php echo CHtml::label("No Identitas <span class=\"required\">*</span>", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien, 'jenisidentitas', LookupM::getItemsUrutan('jenisidentitas'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 jenisidentitas required', 'style' => 'float:left; width:80px', 'onchange' => 'cekLength(this);' . $onblur . ';'));
            ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modPasien,
                'attribute' => 'no_identitas_pasien',
                'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompletePasienLama') . '",
                                                   dataType: "json",
                                                   data: {
                                                       no_identitas_pasien: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                        }',
                    'select' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.no_identitas_pasien);
                                            setPasienLama(ui.item.pasien_id);
                                            return false;
                                        }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'No. Identitas Pasien',
                    'rel' => 'tooltip',
                    'title' => 'No. Identitas untuk masukan data / mencari pasien',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    // 'onblur'=>'setPasienLamaNomor()',
                    'onblur' => $onblur,
                    'class' => 'span3 numbers-only nik required',
                ),
            ));
            ?>

            <?php echo $form->error($modPasien, 'jenisidentitas'); ?>
            <?php echo $form->error($modPasien, 'no_identitas_pasien'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Pasien<span class='required'>*</span>", 'nama_pasien', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($modPasien, 'namadepan', LookupM::getItems('namadepan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'span1 form-control required', 'style' => 'width:80px'));
            ?>
            <br>
            <?php
            if ($gelar == 'ada') {
                echo $form->textField($modPasien, 'gelardepan', array('placeholder' => 'gelar depan', 'class' => 'form-control span2 ', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'border:#EBEBEB 1px solid !important;'));
            } ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modPasien,
                'attribute' => 'nama_pasien',
                'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . $this->createUrl('AutocompletePasienLama') . '",
                                               dataType: "json",
                                               data: {
                                                   nama_pasien: request.term,
                                                   tanggal_lahir: $("#' . CHtml::activeId($modPasien, 'tanggal_lahir') . '").val(),
                                               },
                                               success: function (data) {
                                                       response(data);
                                               }
                                           })
                                        }',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                         $(this).val( "");
                                         return false;
                                     }',
                    'select' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.nama_pasien);
                                        setPasienLama(ui.item.pasien_id);
                                        return false;
                                    }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Nama Lengkap Pasien',
                    'rel' => 'tooltip',
                    'title' => 'Ketik Nama untuk masukan data / mencari pasien',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'class' => 'required nama_pasien form-control hurufs-only span3 ' . $nama_kapital,
                    'onblur' => 'cekJamkespa(); $("#pemilikasuransisesuai").change();',
                ),
            ));
            ?>
            <?php
            if ($gelar == 'ada') {
                echo $form->textField($modPasien, 'gelarbelakang', array('placeholder' => 'gelar belakang', 'class' => 'form-control span2 ', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'border:#EBEBEB 1px solid !important;'));
            }
            ?>
        </div>

    </div>

    <div class="control-group " style="text-align:right">
        <p style="color:red;font-size:11px;">Keterangan : Sesuai Identitas Diri (tanpa tanda baca dan gelar)</p>
    </div>

    <?php echo $form->textFieldRow($modPasien, 'nama_bin', array('placeholder' => 'Alias / Nama Panggilan Pasien', 'class' => 'form-control hurufs-only span3 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <?php // echo $form->textFieldRow($modPasien,'tempat_lahir',array('placeholder'=>'Kota/Kabupaten Kelahiran','class'=>'form-control span3 all-caps hurufs-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25)); 
    ?>
    <div class="control-group" style="margin-bottom: 0;">
        <?php echo $form->labelEx($modPasien, 'tempat_lahir', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modPasien,
                'attribute' => 'tempat_lahir',
                'source' => 'js: function(request, response) {
                           $.ajax({
                               url: "' . $this->createUrl('/ActionAutoComplete/getTempatLahir') . '",
                               dataType: "json",
                               data: {
                                   tempat_lahir: request.term,
                               },
                               success: function (data) {
                                       response(data);
                               }
                           })
                        }',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                         $(this).val(ui.item.value);
                         $(this).val().toUpperCase();
                         return false;
                     }',
                    'select' => 'js:function( event, ui ) {
                        $(this).val(ui.item.value);
                        $(this).val().toUpperCase();
                        return false;
                    }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Kota/Kabupaten Kelahiran',
                    'rel' => 'tooltip',
                    'title' => 'Ketik tempat lahir pasien',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'class' => 'form-control span3 all-caps hurufs-only',
                    'onblur' => '',
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPasien, 'tanggal_lahir', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $modPasien->tanggal_lahir = (!empty($modPasien->tanggal_lahir) ? date("d/m/Y", strtotime($modPasien->tanggal_lahir)) : null);
            $this->widget('MyDateTimePicker', array(
                'model' => $modPasien,
                'attribute' => 'tanggal_lahir',
                'mode' => 'date',
                'options' => array(
                    'showOn' => false,
                    'maxDate' => 'd',
                    'onkeyup' => "js:function(){setUmur(this.value);" . (!empty($modPasien->cekinap) ? 'setRawatGabung();' : '') . "}",
                    'onSelect' => 'js:function(){setUmur(this.value);' . (!empty($modPasien->cekinap) ? 'setRawatGabung();' : '') . '}',
                    'yearRange' => "-150:+0",
                ),
                'htmlOptions' => array(
                    'autocomplete' => 'off', /* 'style' => 'width:120px;', */ 'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask required', 'onblur' => 'setUmur(this.value);' . (!empty($modPasien->cekinap) ? 'setRawatGabung();' : ''), 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
            <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
        </div>
    </div>

    <?php echo $form->textFieldRow($model, 'umur', array('placeholder' => '00 Thn 00 Bln 00 Hr', 'class' => 'span3 umur required', 'onblur' => 'setTglLahir(this);', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>

    <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setNamaDepan();cekRuanganIGD();", 'class' => 'form-control required')); ?>

    <div class="control-group">
        <?php echo $form->labelEx($modPasien, 'golongandarah', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien, 'golongandarah', LookupM::getItems('golongandarah'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'form-control span1'));
            ?>
            <div class="radio inline">
                <div class="form-inline">
                    <?php echo $form->radioButtonList($modPasien, 'rhesus', LookupM::getItems('rhesus'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'rhesus')); ?>
                </div>
            </div>
            <?php echo $form->error($modPasien, 'golongandarah'); ?>
            <?php echo $form->error($modPasien, 'rhesus'); ?>
        </div>
    </div>

    <?php echo $form->dropDownListRow($modPasien, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaDepan()', 'class' => 'form-control span1')); ?>


    <?php echo $form->textFieldRow($modPasien, 'nama_ayah', array('placeholder' => 'Nama Ayah Kandung Pasien', 'class' => 'form-control hurufs-only span3 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    <div class="control-group">
        <?php echo CHtml::label("Nama Ibu", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->textField($modPasien, 'nama_ibu', array(
                'placeholder' => 'Nama Ibu Kandung Pasien',
                'class' => 'nama_ibu form-control hurufs-only span3 ' . $nama_kapital,
                'onkeyup' => "return $(this).focusNextInputField(event);",
                'maxlength' => 50,
            ));
            ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($modPasien, 'anakke', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modPasien, 'anakke', array('class' => 'form-control span1 integer', 'maxlength' => 2, 'onkeypress' => "return $(this).focusNextInputField(event)",)) . ' dari '; ?>
            <?php echo $form->textField($modPasien, 'jumlah_bersaudara', array('class' => 'form-control span1 integer', 'maxlength' => 2, 'onkeypress' => "return $(this).focusNextInputField(event)",)) . ' bersaudara'; ?>
        </div>
    </div>


    <?php
    $model->is_adapjpasien = isset($modPasienAdmisi) ? 1 : 0;
    echo $form->hiddenField($model, 'is_adapjpasien', array('readonly' => true, 'class' => 'span3 is_adapjpasien', 'onkeyup' => "return $(this).focusNextInputField(event)"));
    ?>
    <?php
    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        'id' => 'form-pjpasien',
        'content' => array(
            'content-pjpasien' => array(
                'header' => '<b>Penanggung Jawab Pasien</b>',
                'isi' => $this->renderPartial($this->path_view . '_formPenanggungJawabPasien', array(
                    'form' => $form,
                    'modPenanggungJawab' => $modPenanggungJawab,
                ), true),
                'active' => isset($modPasienAdmisi) ? true : false,
            ),
        ),
    ));
    ?>

</div>
<div class="col-sm-6">

    <div style="text-align: center;">
        <?php echo $form->hiddenField($modPasien, 'photopasien', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
        <?php echo  $form->hiddenField($modPasien, 'is_ambilfoto', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Ambil Foto', array('{icon}' => '<i class="entypo-camera"></i>')), array(
            'class' => 'btn btn-primary', 'onclick' => "$('#dialog-addphoto').dialog('open'); putarWebcam();",
            'id' => 'btn-addphoto', 'onkeyup' => "return $(this).focusNextInputField(event)",
            'rel' => 'tooltip', 'title' => 'Klik untuk Ambil Foto'
        ))
        ?>
        <br>
        <?php
        $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasien->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg");
        ?>
        <img id="photo-preview" src="<?php echo $url_photopasien ?>" width="84px" />
    </div>


    <?php echo $form->textAreaRow($modPasien, 'alamat_pasien', array('placeholder' => 'Alamat Lengkap Pasien', 'rows' => 2, 'cols' => 60, 'class' => 'autogrow span3 ' . $alamat_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPasien, 'rt', array('class' => 'control-label inline')) ?>
        <div class="controls">
            <?php echo $form->textField($modPasien, 'rt', array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'form-control span1 numbers-only', 'maxlength' => 3, 'placeholder' => 'RT')); ?> /
            <?php echo $form->textField($modPasien, 'rw', array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'form-control span1 numbers-only', 'maxlength' => 3, 'placeholder' => 'RW')); ?>
            <?php echo $form->error($modPasien, 'rt'); ?>
            <?php echo $form->error($modPasien, 'rw'); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($modPasien, 'propinsi_id', array('class' => 'control-label refreshableLocation')) ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($modPasien, 'propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($modPasien))),
                    'update' => "#" . CHtml::activeId($modPasien, 'kabupaten_id'),
                ),
                'onchange' => "setClearDropdownKelurahan();setClearDropdownKecamatan();",
                'style' => 'width:170px;'
            ));
            ?>
            <?php echo $form->error($modPasien, 'propinsi_id'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPasien, 'kabupaten_id', array('class' => 'control-label refreshableLocation')) ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($modPasien, 'kabupaten_id', empty($modPasien->propinsi_id) ? array() : CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array(
                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($modPasien))),
                    'update' => "#" . CHtml::activeId($modPasien, 'kecamatan_id'),
                ),
                'onchange' => "setClearDropdownKelurahan();",
                'style' => 'width:170px;'
            ));
            ?>
            <?php echo $form->error($modPasien, 'kabupaten_id'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPasien, 'kecamatan_id', array('class' => 'control-label refreshableLocation')) ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($modPasien, 'kecamatan_id', empty($modPasien->kabupaten_id) ? array() : CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), array(
                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($modPasien))),
                    'update' => "#" . CHtml::activeId($modPasien, 'kelurahan_id'),
                ),
                'onchange' => "",
                'style' => 'width:170px;'
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPasien, 'kelurahan_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id)) ? $modPasien->kelurahan_id : Yii::app()->user->getState('kelurahan_id'); ?>
            <?php
            echo $form->dropDownList($modPasien, 'kelurahan_id', empty($modPasien->kecamatan_id) ? array() : CHtml::listData($modPasien->getKelurahanItems($modPasien->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'), array(
                'empty' => '-- Pilih --', 'class' => 'form-control span3', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'style' => 'width:170px;'
            ));
            ?>
            <?php echo $form->error($modPasien, 'kelurahan_id'); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPasien, 'alamatemail', array('placeholder' => 'contoh: info@.com', 'class' => 'span3 form-control', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

    <div class="control-group">
        <?php echo CHtml::label("No. Telepon Pasien", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modPasien, 'no_telepon_pasien', array('placeholder' => 'No. Telepon', 'class' => 'form-control span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            <?php echo $form->error($modPasien, 'no_telepon_pasien'); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo CHtml::label("No. Handphone Pasien <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modPasien, 'no_mobile_pasien', array('placeholder' => 'No. Handphone', 'class' => 'form-control span3 numbers-only required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 14)); ?>
            <?php echo $form->error($modPasien, 'no_mobile_pasien'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Chtml::label('Pekerjaan <span class="required">*</span>', 'pekerjaan_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien, 'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'), array('style' => 'width:170px;', 'empty' => '-- Pilih --', 'class' => 'form-control span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "cekStatusPekerjaan(this)")); ?>
        </div>
    </div>
    <?php echo $form->dropDownListRow($modPasien, 'warga_negara', LookupM::getItems('warganegara'), array('style' => 'width:170px;', 'class' => 'span3 required', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPasien, 'agama', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien, 'agama', LookupM::getItems('agama'), array('style' => 'width:170px;', 'class' => 'span3 required', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPasien, 'pendidikan_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien, 'pendidikan_id', CHtml::listData($modPasien->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'), array('style' => 'width:170px;', 'empty' => '-- Pilih --', 'class' => 'form-control span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>



    <?php if (isset($modPasienAdmisi)) { ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Lain - Lain
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label("Alergi", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPasienAdmisi, 'alergiterhadap', array('placeholder' => 'Alergi Terhadap', 'class' => 'form-control span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <?php echo $form->radioButtonListInlineRow($modPasienAdmisi, 'isprivasi', array('1' => "Ya", '0' => "Tidak"), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'form-control')); ?>
                <?php echo $form->radioButtonListInlineRow($modPasienAdmisi, 'ispenerjamah', array('1' => "Ya", '0' => "Tidak"), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'form-control', 'onchange' => 'cekBahasa(this)')); ?>
                <div class="control-group bahasa" style="display: none;">
                    <?php echo CHtml::label("Bahasa", '', array('class' => 'control-label', 'style' => 'color:white')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modPasienAdmisi, 'penerjemah_bahasa', LookupM::getItemsUrutan('kemampuanbahasa'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 form-control bahasa')); ?>
                    </div>
                </div>
                <?php echo $form->radioButtonListInlineRow($modPasienAdmisi, 'ispenyimpananbrg', array('1' => "Ya", '0' => "Tidak"), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'form-control')); ?>
                <?php echo $form->radioButtonListInlineRow($modPasienAdmisi, 'ispenerimaankuasa', array('1' => "Menyetujui", '0' => "Menolak"), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'form-control')); ?>
                <?php echo $form->radioButtonListInlineRow($modPasienAdmisi, 'isterimabrosur', array('1' => "Ya", '0' => "Tidak"), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'form-control')); ?>
                <?php echo $form->radioButtonListInlineRow($modPasienAdmisi, 'ismemberikaninform', array('1' => "Ya", '0' => "Tidak"), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'form-control')); ?>
                <?php echo $form->radioButtonListInlineRow($modPasienAdmisi, 'isberikanobatluarbpjs', array('1' => "Ya", '0' => "Tidak"), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'form-control')); ?>
            </div>
        </div>

    <?php } ?>

</div>
<br>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 500,
        'resizable' => false,
    ),
));
$kec_id = null;
$modDataPasien = new PPPasienM('searchDialog');
$modDataPasien->unsetAttributes();
$format = new MyFormatter();
$modDataPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
$modDataPasien->ispasienluar = FALSE;
if (isset($_GET['PPPasienM'])) {
    $modDataPasien->attributes = $_GET['PPPasienM'];
    $modDataPasien->cari_kelurahan_nama = $_GET['PPPasienM']['cari_kelurahan_nama'];
    $modDataPasien->cari_kecamatan_nama = $_GET['PPPasienM']['cari_kecamatan_nama'];
    if (isset($_GET['PPPasienM']['nomorindukpegawai'])) {
        $modDataPasien->nomorindukpegawai = $_GET['PPPasienM']['nomorindukpegawai'];
    }

    $kec = KecamatanM::model()->findByAttributes(array(
        'kecamatan_nama' => $modDataPasien->cari_kecamatan_nama,
        'kecamatan_aktif' => true,
    ));

    if (empty($kec))
        $kec_id = null;
    else
        $kec_id = $kec->kecamatan_id;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    'dataProvider' => $modDataPasien->searchDialog(),
    'filter' => $modDataPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "
                                            setPasienLama(\"$data->pasien_id\");
                                            $(\"#dialogPasien\").dialog(\"close\");
                                        "))',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'nama_bin',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => Chtml::dropDownList('PPPasienM[jeniskelamin]', $modDataPasien->jeniskelamin, LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
            'value' => '$data->jeniskelamin'
        ),
        array(
            'name' => 'tanggal_lahir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $modDataPasien,
                    'attribute' => 'tanggal_lahir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'tanggal_lahir', 'placeholder' => '23 Jan 1993'),
                ),
                true
            ),
            'htmlOptions' => array('width' => '80', 'style' => 'text-align:center'),
        ),
        'alamat_pasien',
        array(
            'header' => 'Nama Kecamatan',
            'name' => 'cari_kecamatan_nama',
            'type' => 'raw',
            'value' => '$data->kecamatan->kecamatan_nama',
            'filter' => CHtml::activeDropDownList($modDataPasien, 'cari_kecamatan_nama', CHtml::listData(KecamatanM::model()->findAll(array(
                'condition' => 'kecamatan_aktif = true',
                'order' => 'kecamatan_nama asc',
            )), 'kecamatan_nama', 'kecamatan_nama'), array(
                'empty' => '-- Pilih --',
            )),
        ),
        array(
            'header' => 'Nama Kelurahan',
            'name' => 'cari_kelurahan_nama',
            'type' => 'raw',
            'value' => 'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""',
            'filter' => CHtml::activeDropDownList($modDataPasien, 'cari_kelurahan_nama', CHtml::listData(KelurahanM::model()->findAllByAttributes(array(
                'kecamatan_id' => $kec_id,
            ), array(
                'condition' => 'kelurahan_aktif = true',
                'order' => 'kelurahan_nama asc',
            )), 'kelurahan_nama', 'kelurahan_nama'), array(
                'empty' => '-- Pilih --',
            )),
        ),
        'norm_lama',
        array(
            'name' => 'statusrekammedis',
            'type' => 'raw',
            'filter' => LookupM::getItems('statusrekammedis'),
            'value' => '$data->statusrekammedis',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});
                
            
            }',
));
$this->endWidget();
?>

<?php
$kec_id = null;
$modDataPasien2 = new PPPasienM('searchDialog');
$modDataPasien2->unsetAttributes();
$format = new MyFormatter();
$modDataPasien2->ispasienluar = FALSE;
if (isset($_GET['PPPasienM'])) {
    $modDataPasien2->attributes = $_GET['PPPasienM'];
    $modDataPasien2->cari_kelurahan_nama = $_GET['PPPasienM']['cari_kelurahan_nama'];
    $modDataPasien2->cari_kecamatan_nama = $_GET['PPPasienM']['cari_kecamatan_nama'];
    if (isset($_GET['PPPasienM']['nomorindukpegawai'])) {
        $modDataPasien2->nomorindukpegawai = $_GET['PPPasienM']['nomorindukpegawai'];
    }

    $kec = KecamatanM::model()->findByAttributes(array(
        'kecamatan_nama' => $modDataPasien2->cari_kecamatan_nama
    ));

    if (empty($kec))
        $kec_id = null;
    else
        $kec_id = $kec->kecamatan_id;
}

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasienBadak',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 500,
        'resizable' => false,
    ),
));

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasienbadak-m-grid',
    'dataProvider' => $modDataPasien2->searchDialogBadak(),
    'filter' => $modDataPasien2,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "
                                            setPasienLama(\"$data->pasien_id\");
                                            $(\"#dialogPasienBadak\").dialog(\"close\");
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'type' => 'raw',
            'value' => '$data->pegawai->nomorindukpegawai',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'nama_bin',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => Chtml::dropDownList('PPPasienM[jeniskelamin]', $modDataPasien->jeniskelamin, LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
            'value' => '$data->jeniskelamin'
        ),
        array(
            'name' => 'tanggal_lahir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $modDataPasien2,
                    'attribute' => 'tanggal_lahir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'tanggal_lahir', 'placeholder' => '23 Jan 1993'),
                ),
                true
            ),
            'htmlOptions' => array('width' => '80', 'style' => 'text-align:center'),
        ),
        'alamat_pasien',
        array(
            'header' => 'Nama Kecamatan',
            'name' => 'cari_kecamatan_nama',
            'type' => 'raw',
            'value' => '$data->kecamatan->kecamatan_nama',
            'filter' => CHtml::activeDropDownList($modDataPasien2, 'cari_kecamatan_nama', CHtml::listData(KecamatanM::model()->findAll(array(
                'condition' => 'kecamatan_aktif = true',
                'order' => 'kecamatan_nama asc',
            )), 'kecamatan_nama', 'kecamatan_nama'), array(
                'empty' => '-- Pilih --',
            )),
        ),
        array(
            'header' => 'Nama Kelurahan',
            'name' => 'cari_kelurahan_nama',
            'type' => 'raw',
            'value' => 'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""',
            'filter' => CHtml::activeDropDownList($modDataPasien2, 'cari_kelurahan_nama', CHtml::listData(KelurahanM::model()->findAllByAttributes(array(
                'kecamatan_id' => $kec_id,
            ), array(
                'condition' => 'kelurahan_aktif = true',
                'order' => 'kelurahan_nama asc',
            )), 'kelurahan_nama', 'kelurahan_nama'), array(
                'empty' => '-- Pilih --',
            )),
        ),
        'norm_lama',
        array(
            'name' => 'statusrekammedis',
            'type' => 'raw',
            'filter' => Chtml::dropDownList('PPPasienM[statusrekammedis]', $modDataPasien->statusrekammedis, LookupM::model()->getItems('statusrekammedis'), array('empty' => '-- Pilih --')),
            'value' => '$data->statusrekammedis',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});
                
            
            }',
));
$this->endWidget();
?>

<?php
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-addpropinsi',
    'options' => array(
        'title' => 'Menambah data Provinsi',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 450,
        'height' => 300,
        'resizable' => false,
    ),
));

echo '<div class="dialog-content"></div>';

$this->endWidget();
//========= end propinsi dialog =============================
// Dialog buat nambah data kabupaten =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-addkabupaten',
    'options' => array(
        'title' => 'Menambah data Kabupaten',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 300,
        'resizable' => false,
    ),
));

echo '<div class="dialog-content"></div>';

$this->endWidget();
//========= end kabupaten dialog =============================
// Dialog buat nambah data kecamatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddKecamatan',
    'options' => array(
        'title' => 'Menambah data Kecamatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 300,
        'resizable' => false,
    ),
));

echo '<div class="dialog-content"></div>';

$this->endWidget();
//========= end kecamatan dialog =============================
// Dialog buat nambah data kelurahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-addkelurahan',
    'options' => array(
        'title' => 'Menambah data Kelurahan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 300,
        'resizable' => false,
    ),
));

echo '<div class="dialog-content"></div>';

$this->endWidget();
//========= end kelurahan dialog =============================
?>
<?php
//================= dialog webcam =====================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-addphoto',
    'options' => array(
        'title' => 'Ambil Foto',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 360,
        'minHeight' => 250,
        'resizable' => false,
    ),
));
?>

<div id="dialog-content" style="text-align: center;">
    <div id="container_webcam" style="overflow: hidden; width: 320px; display: inline-block; margin-top: 10px;">
        <video id="cam-preview" style="margin-left: -160px;"></video>
    </div>
    <br>
    <?php // echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-cog icon-white"></i>')),array('rel'=>'tooltip','title'=>'Konfigurasi Kamera','class'=>'btn-primary', 'type'=>'button', 'onclick'=>'webcam.configure();','style'=>'font-size:10px; width:32px; height:24px;')); 
    ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ambil', array('{icon}' => '<i class="entypo-camera"></i>')), array('id' => 'btn_ambil_gambar', 'class' => 'btn-danger', 'type' => 'button', 'onclick' => 'ambilGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="icon-download-alt icon-white"></i>')), array('id' => 'btn_simpan_gambar', 'disabled' => true, 'class' => 'btn-primary', 'type' => 'button', 'onclick' => 'simpanGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('id' => 'btn_ulang_gambar', 'class' => 'btn-default', 'type' => 'button', 'onclick' => 'ulangGambar();', 'style' => 'font-size:10px; width:76px; height:24px;')); ?>
    <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
</div>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog_pasien_pegawai',
    'options' => array(
        'title' => 'Pencarian Data Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 530,
        'resizable' => false,
    ),
));

$modPeg = new PPPegawaiV;

if (isset($_GET['PPPegawaiV'])) {
    $modPeg->attributes = $_GET['PPPegawaiV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasienpegawai-m-grid',
    'dataProvider' => $modPeg->searchPegawaiPasienDialog(),
    'filter' => $modPeg,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => '',
            'value' => function ($data) {
                $peg = $data->attributes;
                $peg['pasien_id'] = !empty($data->pasien_id) ? $data->pasien_id : "";
                $peg['tgl_lahirpegawai'] = date("d/m/Y", strtotime($data->tgl_lahirpegawai));
                $peg['umur'] = CustomFunction::getUmur($data->tgl_lahirpegawai);
                $peg['gelarbelakang_nama'] = $data->belakang;
                $peg['golongandarah'] = $data->golongandarah;


                $res = CJSON::encode($peg);

                return CHtml::Link("<i class='icon-form-check'></i>", "javascript:void(0);", array(
                    "class" => "btn-small",
                    "id" => "selectPasien",
                    "onClick" => "                                     
                                //setPasienLama(" . $data->pasien_id . ");
                                generatePegawai(" . $res . ");
                                $('#dialog_pasien_pegawai').dialog('close');
                            "
                ));
            },
        ),
        'nomorindukpegawai',
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->belakang'
        ),
        array(
            'name' => 'jeniskelamin',
            'filter' => CHtml::activeDropDownList($modPeg, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Tempat Lahir',
            'name' => 'tempatlahir_pegawai',
            'value' => '$data->tempatlahir_pegawai'
        ),
        array(
            'header' => 'Tanggal Lahir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
            'filter' => false
        ),
        'alamat_pegawai',
        array(
            'name' => 'statusperkawinan',
            'filter' => CHtml::activeDropDownList($modPeg, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --'))
        ),
        array(
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPeg, 'jabatan_id', CHtml::listData(JabatanM::model()->findALl(" jabatan_aktif = true ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                return $data->jabatan_nama;
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});
                
            
            }',
));

$this->endWidget();
?>


<script type="text/javascript">
    <?php
    $random = rand(0000000000000000, 9999999999999999);
    ?>


    var video_pasien = null;
    var video_canvas = null;
    var temp_img = null;


    function putarWebcam() {
        ulangGambar();
    }

    /**
     * ambil gambar pada webcam
     * @returns {Boolean}
     */
    function ambilGambar() {
        video_pasien.pause();

        var img = document.createElement('img_webcam');
        var context;
        var width = container_webcam.offsetWidth;
        var height = container_webcam.offsetHeight;

        video_canvas = document.createElement("canvas");
        video_canvas.width = width;
        video_canvas.height = height;

        context = video_canvas.getContext('2d');
        context.drawImage(video_pasien, -157, 0);

        temp_img = video_canvas.toDataURL('image/png');

        $("#btn_ambil_gambar").prop("disabled", true);
        $("#btn_simpan_gambar").prop("disabled", false);
        $("#btn_ulang_gambar").prop("disabled", false);
    }
    /**
     * menyimpan / meng-upload gambar
     * @returns {undefined}
     */
    function simpanGambar() {
        $("#btn_simpan_gambar").attr("disabled", true);
        $("#PPPasienM_photopasien").val(temp_img);
        $("#PPPasienM_is_ambilfoto").val(1);
        $("#photo-preview").prop("src", temp_img);

        temp_img = null;
        $("#dialog-addphoto").dialog("close");


    }
    /**
     * mengulang pengambilan gambar
     * @returns {undefined}
     */
    function ulangGambar() {
        temp_img = null;
        video_pasien.play();
        $("#btn_ambil_gambar").prop("disabled", false);
        $("#btn_simpan_gambar").prop("disabled", true);
        $("#btn_ulang_gambar").prop("disabled", true);

    }

    function handleVideo(stream) {
        video_pasien.srcObject = stream;
    }

    function videoError(e) {
        // alert("Fungsi Foto pasien di-nonaktifkan.");
    }

    $(document).ready(function() {
        /**
         * set webcam
         * @returns {Boolean}
         */
        <?php if (!isset($_GET['sukses'])) { ?>

            video_pasien = document.querySelector("#cam-preview");
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

            if (navigator.getUserMedia) {
                // jalankan fungsi handleVideo, dan videoError jika izin ditolak
                navigator.getUserMedia({
                    video: true
                }, handleVideo, videoError);
            }
        <?php } ?>
    });
</script>
<script>
    function showDateTime() {
        $("#PPPasienM_tanggal_lahir").datepicker();
    }

    function cekBahasa(obj) {
        var ispenerjamah = $("#PPPasienAdmisiT_ispenerjamah_0").is(":checked");
        if (ispenerjamah) {
            $('.bahasa').show();
        } else {
            $('.bahasa').hide();
        }
    }

    function cekNoRM() {
        var norm = $("#<?php echo CHtml::activeId($modPasien, 'no_rekam_medik') ?>").val();

        if (norm != '') {
            if (norm.trim().length != 8) {
                myAlert("No. Rekam Medik harus berisi 8 digit angka");
                $("#<?php echo CHtml::activeId($modPasien, 'no_rekam_medik') ?>").val('');
                setPasienBaru();
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionAjax/cekNoRM/'); ?>',
                    data: {
                        no_rekam_medik: norm
                    },
                    dataType: "json",
                    success: function(data) {
                        if (norm > data.no_rekam_medik) {
                            myAlert("<p style=\"margin: 0; text-align: center;\">Maaf No. Rekam Medik <b>Invalid</b>, \n\
                                No. Rekam Medik Terakhir [<b>" + data.no_rekam_medik + "</b>]</p>");
                            $("#<?php echo CHtml::activeId($modPasien, 'no_rekam_medik') ?>").val("");
                            setPasienBaru();
                            return false;
                        } else {
                            setPasienLama(data.pasien_id, norm, true);
                        }
                    },
                });
            }
        }
    }

    function cekNoRmLama(obj) {
        var norm = $(obj).val();
        var pasien_id = $("#<?php echo CHtml::activeId($modPasien, 'pasien_id') ?>").val();
        var norm_lama_temp = $("#<?php echo CHtml::activeId($modPasien, 'norm_lama_temp') ?>").val();

        if (norm != '') {
            if (norm.trim().length != 8) {
                myAlert("No. Rekam Medik Lama harus berisi 8 digit angka");
                if (pasien_id !== "") {
                    $(obj).val(norm_lama_temp);
                } else {
                    $(obj).val("");
                }
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionAjax/cekNoRMLama/'); ?>',
                    data: {
                        norm_lama: norm,
                        pasien_id: pasien_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.pasien_id !== 0) {
                            myAlert("No.RM Lama yang dimasukan sudah ada pada Database");
                            if (pasien_id !== "") {
                                $(obj).val(norm_lama_temp);
                            } else {
                                $(obj).val("");
                            }
                        }
                    },
                });
            }
        }
    }

    function resetElementLocation() {
        $("label.refreshableLocation").each(function() {
            $(this).attr('title', 'Klik untuk refresh ini');
            $(this).attr('rel', 'tooltip');
            $(this).append('<i class="entypo-arrows-ccw"></i> ');
            $(this).tooltip();
        });
        $("label.refreshableLocation").click(function() {
            var control = $(this).parent();
            var propinsi_id = $("#<?php echo CHtml::activeId($modPasien, "propinsi_id"); ?>");
            var kabupaten_id = $("#<?php echo CHtml::activeId($modPasien, "kabupaten_id"); ?>");
            var kecamatan_id = $("#<?php echo CHtml::activeId($modPasien, "kecamatan_id"); ?>");
            control.addClass('animation-loading-1');
            var element_id = $(this).parent().find('input,textarea,select').attr('id');
            $.ajax({
                type: 'GET',
                url: window.location.href,
                data: {
                    propinsi_id: propinsi_id.val(),
                    kabupaten_id: kabupaten_id.val(),
                    kecamatan_id: kecamatan_id.val()
                },
                success: function(jqXHR, textStatus, errorThrown) {
                    control.removeClass('animation-loading-1');
                    var elemenbaru = $(jqXHR).find("#" + element_id).html();
                    $("#" + element_id).html(elemenbaru);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    control.removeClass('animation-loading-1');
                }
            });
        });
    }

    $(document).ready(function() {
        <?php
        if (isset($modPasienAdmisi)) {
            if ($modPasienAdmisi->ispenerjamah == 1) {
        ?>
                $('.bahasa').show();
            <?php
            } else {
            ?>
                $('.bahasa').hide();
        <?php
            }
        }
        ?>
        resetElementLocation();
    });
</script>

<?php //================= end dialog webcam ===================== 
?>

<?php
if (Yii::app()->user->getState('is_finger_pasien')) {
    echo $this->renderPartial('pendaftaranPenjadwalan.views.daftarSidikJariPasien._jsFunctionsFinger', array('modPasien' => $modPasien, 'modul_akses' => 'pendaftaran'));
}
?>