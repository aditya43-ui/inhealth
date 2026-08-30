<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jpegcam/assets/webcam.js'); ?>
<?php
$nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps" : "");
$alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps" : "");

$konSys = KonfigsystemK::model()->find();

$drop_lookjeniskelamin = LookupM::getItems('jeniskelamin');
//if ($this->id == "pendaftaranPersalinan") {
//    unset($drop_lookjeniskelamin[Params::JENIS_KELAMIN_LAKI_LAKI]);
//}
if (!empty($model->buatjanjipoli_id)) {
    // echo Yii::app()->user->getState('propinsi_id');
    // echo 'wwwwwwwwwwwwwwwwwwwwwwwwwwwwww';
    // echo $model->buatjanjipoli_id;
    // echo $modPasien->nama_pasien;
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
}
?>
<style>
    .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
    }

    table .input-append {
        width: 140px;
    }

    table .input-append input {
        float: left;
        margin: 0 !important;
    }

    table .input-append .add-on {
        float: left;
        margin: 0 !important;
    }
</style>
<?php
//if (!isset($_GET['sukses'])){  //RSPMC-1273
if (Yii::app()->user->getState('is_finger_pasien')) {
?>

    <div class="col-sm-12">
        <div id="loading"></div>
        <?php
        echo CHtml::tag('button', array(
            'id' => 'pendaftaranFP',
            'onclick' => 'setPendaftaranFP();',
            'class' => 'btn btn-danger',
            'title' => 'Klik di sini untuk mendaftarkan sidik jari',
        ), '<i class="entypo-check"></i> Pendaftaran Sidik Jari');
        echo CHtml::tag('button', array(
            'id' => 'verifikasiFP',
            'onclick' => 'setVerifikasiFP();',
            'class' => 'btn btn-primary',
            'title' => 'Klik di sini untuk verifikasi sidik jari',
        ), '<i class="entypo-check"></i> Verifikasi Sidik Jari');
        ?>
        <?php
        if (Yii::app()->user->getState('is_ktpreader') == true) {
            echo CHtml::htmlButton("<i class='entypo-credit-card'></i> Load eKTP", array('id' => 'btnLoadKTP', 'onclick' => 'loadKTP();', 'class' => 'btn btn-warning', 'style' => 'color: black;'));
        }

        ?>
        <?php //echo CHtml::button( 'Pendaftaran Sidik Jari', array('id' => 'pendaftaranFP', 'onclick' => 'setPendaftaranFP();', 'class' => 'btn btn-success', 'style' => ''));
        ?>
        <?php //echo CHtml::button(" Verifikasi Sidik Jari", array('id' => 'verifikasiFP', 'onclick' => 'setVerifikasiFP();', 'class' => 'btn btn-info', 'style' => ''));
        ?>
        <?php //echo CHtml::button("Batal",array('id'=>'batalVerifFP','onclick' => 'batalVerifikasiFP();', 'class'=>'btn btn-primary'));
        ?>
        <div id="pesanVerifikasi">&nbsp;</div>
    </div>

<?php
}
//}
?>

<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-user"></i> Data <b>Pribadi</b>
                <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
            </div>
        </div>
        <div class="panel-body">
            <!-- <?php if (strtolower($this->id) != "pendaftaranrawatjalan") { ?>
                <div class="control-group">
                    <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        // echo CHtml::radioButton('rb_rm', false, array(
                        //     'value' => 1,
                        //     'name' => 'otomatis',
                        //     'uncheckValue' => null,
                        //     'onchange' => 'switchOtomatis(this)',
                        //     'class' => 'rb_rm rmbaru',
                        // )) . "<label>Pasien Baru</label> ";
                        // echo CHtml::radioButton('rb_rm', false, array(
                        //     'value' => 0,
                        //     'name' => 'otomatis',
                        //     'uncheckValue' => null,
                        //     'onchange' => 'switchOtomatis(this)',
                        //     'class' => 'rb_rm rmlama',
                        // )) . "<label>Pasien Lama</label> ";
                        ?>
                    </div>
                </div>
            <?php } ?> -->
            <div class="control-group">
                <label class="control-label" style="padding-top: 0px;">
                    <?php echo CHtml::dropDownList('cari_pasien', null, array(
                        'nomor_peserta' => 'No. Peserta',
                        'no_rujukan' => 'No. Rujukan',
                        'nik' => 'NIK Pasien',
                        //'no_kk'=>'No.KK Pasien',
                        'nip' => 'NIP Pasien',
                    ), array(
                        'class' => 'span2', 'onchange' => 'setPlaceHolderNomor();', 'id' => 'tipe_nomor_pasien',
                    )); ?>
                </label>
                <div class="controls">
                    <?php echo CHtml::textField('nomor_cari', '', array(
                        // 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => "cariNomorPasien();console.log('blur cari nomor');",
                        'id' => 'cari_nomor_pasien',
                        'class' => 'span3',
                    )); ?>
                </div>

            </div>
            <div class="control-group rm_baru rm_state" hidden>
                <div class="controls">
                    <?php /*
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
                            'class' => 'span3 numbers-only form-control delapan'
                        ),
                    )); */
                    ?>
                    <?php // echo $form->error($modPasien,'no_rekam_medik');
                    ?>
                    <?php // echo $form->hiddenField($modPasien,'pasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10));
                    ?>
                </div>
            </div>
            <div class="control-group rm_nip_baru">
                <?php echo $form->hiddenField($modPasien, 'pegawai_id', array('readonly' => true, 'class' => 'span3 pasien_pegawai_id', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
            </div>
            <div class="control-group rm_baru" id="no_rm_lama" hidden>
                <?php echo CHtml::label($modPasien->getAttributeLabel('no_rekam_medik') . " <span class=\"required\">*</span>", 'no_rekam_medik', array("id" => "lb_rm_lama", 'class' => 'control-label required')) ?>
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
                                                   console.log(data);
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
                            'class' => 'span3 numbers-only f_rm form-control delapan', 'maxlength' => $konSys->jmldigitrm, 'id' => 'no_rekam_medik_baru'
                        ),
                    ));
                    ?>
                    <?php /* echo $form->textField($modPasien, 'no_rekam_medik', array(
                      'id'=>'no_rekam_medik_baru',
                      'class'=>'numbers-only span3',
                      'rel'=>'tooltip',
                      'title'=>'No. RM pasien yang ada sebelumnya',
                      'maxlength'=>6,
                      )); */ ?>
                </div>
            </div>
            <div class="control-group rm_lama rm_state" hidden>
                <?php echo CHtml::label("Cari " . $modPasien->getAttributeLabel('no_rekam_medik'), 'no_rekam_medik', array('class' => 'control-label required')) ?>
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
                            'class' => 'span3 numbers-only f_rm', 'maxlength' => $konSys->jmldigitrm,
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
                <?php //echo $form->labelEx($modPasien,'no_identitas_pasien', array('class'=>'control-label refreshable'))
                ?>
                <?php echo CHtml::label('No Identitas <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'jenisidentitas', LookupM::getItemsUrutan('jenisidentitas'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 form-control jenisidentitas required', 'style' => 'float:left; width:150px', 'onchange' => 'cekLength(this);'));
                    ?>
                    <br>
                    <br>
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
                            'minLength' => 4,
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
                            'onblur' => 'setInputBerdasarkanNoKTP()',
                            'class' => 'form-control span3 angkahuruf-only all-caps nik',
                        ),
                    ));
                    ?>

                    <?php echo $form->error($modPasien, 'jenisidentitas'); ?>
                    <?php echo $form->error($modPasien, 'no_identitas_pasien'); ?>
                </div>
            </div>
            <div class="control-group" style="margin-bottom: 0;display: none;">
                <?php
                echo $form->dropDownList($modPasien, 'namadepan', LookupM::getItems('namadepan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'span3 form-control', 'style' => 'float:left; width:80px'));
                ?>
            </div>
            <div class="control-group" style="margin-bottom: 0;">
                <?php echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label required')) ?>
                <div class="controls">

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
                            'minLength' => 2,
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
                            'class' => 'nama_pasien form-control hurufkomatitik-only span3 ' . $nama_kapital,
                            'onblur' => 'cekJamkespa(); $("#pemilikasuransisesuai").change();',
                        ),
                    ));
                    ?>
                    <?php //echo $form->error($modPasien,'namadepan');
                    ?>
                    <?php //echo $form->error($modPasien,'nama_pasien');
                    ?>
                    <p style="color:red;font-size:11px;">Keterangan : Sesuai Identitas Diri (tanpa tanda baca dan gelar)</p>
                </div>
            </div>

            <?php echo $form->textFieldRow($modPasien, 'nama_bin', array('placeholder' => 'Alias / Nama Panggilan Pasien', 'class' => 'form-control hurufs-only span3 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($modPasien, 'tempat_lahir', array('placeholder' => 'Kota/Kabupaten Kelahiran', 'class' => 'form-control span3 all-caps hurufs-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 25)); ?>
            <?php echo $form->textFieldRow($modPasien, 'tanggal_lahir', array('autocomplete' => 'off', 'style' => '', 'placeholder' => '00/00/0000', 'class' => 'form-control dtPicker2 datemask span3 required', 'onblur' => 'setUmur(this.value);' . (!empty($modPasien->cekinap) ? 'setRawatGabung();' : ''), 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            <!-- <div class="control-group">
                <?php //echo $form->labelEx($modPasien, 'tanggal_lahir', array('class' => 'control-label')) 
                ?>
                <div class="controls">
                    <?php
                    /* $modPasien->tanggal_lahir = (!empty($modPasien->tanggal_lahir) ? date("d/m/Y", strtotime($modPasien->tanggal_lahir)) : null);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modPasien,
                        'attribute' => 'tanggal_lahir',
                        'mode' => 'date',
                        'options' => array(
                            //                                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                            'minDate' => '1000y',
                            'onkeyup' => "js:function(){setUmur(this.value);" . (!empty($modPasien->cekinap) ? 'setRawatGabung();' : '') . "}",
                            'onSelect' => 'js:function(){setUmur(this.value);' . (!empty($modPasien->cekinap) ? 'setRawatGabung();' : '') . '}',
                            'yearRange' => "",
                        ),
                        'htmlOptions' => array(
                            'autocomplete' => 'off', 'style' => '', 'placeholder' => '00/00/0000', 'class' => 'form-control dtPicker2 datemask span3', 'onblur' => 'setUmur(this.value);' . (!empty($modPasien->cekinap) ? 'setRawatGabung();' : ''), 'onkeyup' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    */ ?>
                    <?php //echo $form->error($modPasien, 'tanggal_lahir'); 
                    ?>
                </div>
            </div> -->

            <?php echo $form->textFieldRow($model, 'umur', array('placeholder' => '00 Thn 00 Bln 00 Hr', 'class' => 'form-control span3 umur required', 'onblur' => 'setTglLahir(this);', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true)); ?>

            <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', $drop_lookjeniskelamin, array('onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setNamaDepan()", 'class' => 'form-control required')); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'golongandarah', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'golongandarah', LookupM::getItems('golongandarah'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'form-control span3', 'style' => 'width:170px'));
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
            <?php echo $form->dropDownListRow($modPasien, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaDepan()', 'class' => 'form-control required', 'style' => 'width:170px')); ?>
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
            <?php //echo $form->textFieldRow($modPasien,'nama_ibu',array('placeholder'=>'Nama Ibu Kandung Pasien','class'=>'required form-control hurufs-only span3 '.$nama_kapital, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50));
            ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'anakke', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPasien, 'anakke', array('class' => 'form-control anakke span1 numbers-only', 'maxlength' => 2, 'onkeypress' => "return $(this).focusNextInputField(event)", 'onblur' => 'cekJumlahSaudara(this);')) . ' <label>dari</label> '; ?>
                    <?php echo $form->textField($modPasien, 'jumlah_bersaudara', array('class' => 'form-control jumlah_bersaudara span1 numbers-only', 'maxlength' => 2, 'onkeypress' => "return $(this).focusNextInputField(event)", 'onblur' => 'cekJumlahSaudara(this);')) . ' <label>bersaudara</label> '; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <!--<i class="glyphicon glyphicon-camera"></i> Foto Pasien<span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>-->
                <a class="btn btn-default" onclick="$('#dialog-addphoto').dialog('open'); putarWebcam();" id="btn-addphoto" onkeyup="return $(this).focusNextInputField(event)">
                    <i class="glyphicon glyphicon-camera"></i> Ambil-Foto
                </a>
            </div>
        </div>
        <div class="panel-body">
            <?php echo $form->hiddenField($modPasien, 'photopasien', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            <?php echo $form->hiddenField($modPasien, 'is_ambilfoto', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>

            <?php if (Yii::app()->user->getState('is_mips')) : ?>
                <?php
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Kenali Wajah Pasien', array('{icon}' => '<i class="entypo-camera"></i>')), array(
                    'class' => 'btn btn-primary', 'onclick' => "ambilFoto();",
                    'id' => 'btn-addphoto', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'rel' => 'tooltip', 'title' => 'Klik untuk mengenali wajah pasien dari alat'
                ))
                ?>
                <?php
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-remove"></i>')), array(
                    'class' => 'btn btn-danger', 'onclick' => "hapusFoto();",
                    'id' => 'btn-hapusphoto', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'rel' => 'tooltip', 'title' => 'Klik untuk Mengenali Ulang Wajah Pasien'
                ))
                ?>
                <br>
                <div id="con_foto_scan">
                    <?php
                    if (!empty($model->pendaftaran_id)) {
                        $scan = ScanpasiendarialatT::model()->findByAttributes(array(
                            'pendaftaran_id' => $model->pendaftaran_id,
                        ));

                        if (!empty($scan)) {
                            $res = array(
                                'tempratrue' => $scan->suhu_tubuh,
                                'currentTime' => $scan->waktuscan,
                                'mask' => $scan->pake_masker ? 1 : 0,
                            );

                            $res_img = array(
                                'data' => $scan->data_gambar,
                            );

                            echo $this->renderPartial($this->path_view . "_fotoScan", array(
                                'res' => $res,
                                'res_img' => $res_img
                            ), true);
                        }
                    }
                    ?>
                </div>
                <br>
            <?php else : ?>
                <div style="text-align: center;" id="main_foto_preview">
                    <?php $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasien->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg"); ?>
                    <img id="photo-preview" src="<?php echo $url_photopasien ?>" style="width: 160px;"><br>
                    <?php
                    // echo CHtml::htmlButton(Yii::t('mds', '{icon} Ambil Foto', array('{icon}' => '<i class="entypo-camera"></i>')), array(
                    //     'class' => 'btn btn-dark', 'onclick' => "$('#dialog-addphoto').dialog('open'); putarWebcam();",
                    //     'id' => 'btn-addphoto', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    //     'rel' => 'tooltip', 'title' => 'Klik untuk Ambil Foto'
                    // ))
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-map-marker"></i> Alamat dan Kontak
                <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
            </div>
        </div>
        <div class="panel-body">
            <?php echo $form->textAreaRow($modPasien, 'alamat_pasien', array('placeholder' => 'Alamat Lengkap Pasien', 'rows' => 2, 'cols' => 60, 'class' => 'form-control autogrow span3 required' . $alamat_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($modPasien, 'alamat_domisili_pasien', array('placeholder' => 'Alamat Domisili Lengkap Pasien', 'rows' => 2, 'cols' => 60, 'class' => 'form-control autogrow span3 required' . $alamat_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

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
                        'class' => 'form-control span3 required', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($modPasien))),
                            'update' => "#" . CHtml::activeId($modPasien, 'kabupaten_id'),
                        ),
                        'onchange' => "setClearDropdownKelurahan();setClearDropdownKecamatan();",
                        'style' => 'width:170px;'
                    ));
                    ?>
                    <?php /*  >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>',
                      array('class'=>'btn btn-primary','onclick'=>"{addPropinsi(); $('#dialog-addpropinsi').dialog('open');}",
                      'id'=>'btn-addpropinsi','onkeyup'=>"return $(this).focusNextInputField(event)",
                      'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modPasien->getAttributeLabel('propinsi_id'))) */ ?>
                    <?php echo $form->error($modPasien, 'propinsi_id'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'kabupaten_id', array('class' => 'control-label refreshableLocation')) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($modPasien, 'kabupaten_id', empty($modPasien->propinsi_id) ? array() : CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array(
                        'class' => 'form-control span3 required', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($modPasien))),
                            'update' => "#" . CHtml::activeId($modPasien, 'kecamatan_id'),
                        ),
                        'onchange' => "setClearDropdownKelurahan();",
                        'style' => 'width:170px;'
                    ));
                    ?>
                    <?php /*    >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>',
                      array('class'=>'btn btn-primary','onclick'=>"{addKabupaten(); $('#dialog-addkabupaten').dialog('open');}",
                      'id'=>'btn-addkabupaten','onkeyup'=>"return $(this).focusNextInputField(event)",
                      'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modPasien->getAttributeLabel('kabupaten_id'))) */ ?>
                    <?php echo $form->error($modPasien, 'kabupaten_id'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'kecamatan_id', array('class' => 'control-label refreshableLocation')) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($modPasien, 'kecamatan_id', empty($modPasien->kabupaten_id) ? array() : CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), array(
                        'class' => 'form-control span3 required', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($modPasien))),
                            'update' => "#" . CHtml::activeId($modPasien, 'kelurahan_id'),
                        ),
                        'onchange' => "",
                        'style' => 'width:170px;'
                    ));
                    ?>
                    <?php /*    >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>',
                      array('class'=>'btn btn-primary','onclick'=>"{addKecamatan(); $('#dialogAddKecamatan').dialog('open');}",
                      'id'=>'btn-addkecamatan','onkeyup'=>"return $(this).focusNextInputField(event)",
                      'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modPasien->getAttributeLabel('kecamatan_id'))) */ ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'kelurahan_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php // $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id))?$modPasien->kelurahan_id:Yii::app()->user->getState('kelurahan_id');
                    ?>
                    <?php
                    echo $form->dropDownList($modPasien, 'kelurahan_id', empty($modPasien->kecamatan_id) ? array() : CHtml::listData($modPasien->getKelurahanItems($modPasien->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'), array(
                        'empty' => '-- Pilih --', 'class' => 'form-control span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'style' => 'width:170px;'
                    ));
                    ?>
                    <?php /* >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>',
                      array('class'=>'btn btn-primary','onclick'=>"{addKelurahan(); $('#dialog-addkelurahan').dialog('open');}",
                      'id'=>'btn-addkelurahan','onkeyup'=>"return $(this).focusNextInputField(event)",
                      'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modPasien->getAttributeLabel('kelurahan_id'))) */ ?>
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
                    <?php echo $form->textField($modPasien, 'no_mobile_pasien', array('placeholder' => 'No. Handphone', 'id' => 'no_mobile_pasien', 'class' => 'form-control span3 numbers-only required', 'onblur' => 'cekNoPonsel();', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 14)); ?>
                    <?php //echo CHtml::checkBox('is_whatsapp', false, array('rel'=>'tooltip', 'title'=>'Klik untuk mengirim pesan Whatsapp')); 
                    ?>
                    <?php echo $form->error($modPasien, 'no_mobile_pasien'); ?>


                </div>
            </div>

            <?php //echo $form->textFieldRow($modPasien,'no_telepon_pasien',array('placeholder'=>'No. Telepon','class'=>'form-control span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>15));
            ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'pekerjaan_id', array('class' => 'control-label refreshable')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'), array('style' => 'width:170px;', 'empty' => '-- Pilih --', 'class' => 'form-control span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "cekStatusPekerjaan(this)")); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($modPasien, 'warga_negara', LookupM::getItems('warganegara'), array('style' => 'width:170px;', 'class' => 'form-control span3 required', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'agama', array('class' => 'control-label refreshable')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'agama', LookupM::getItems('agama'), array('style' => 'width:170px;', 'class' => 'form-control span3 required', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("Suku <span class='required'>*</span>", '', array('class' => 'control-label refreshable')) ?>
                <?php //echo $form->labelEx($modPasien, 'suku_id', array('class' => 'control-label refreshable')) 
                ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'suku_id', CHtml::listData($modPasien->getSukuItems(), 'suku_id', 'suku_nama'), array('style' => 'width:170px;', 'class' => 'form-control span3 required', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>


            <div class="control-group">
                <?php echo CHtml::label("Pendidikan <span class='required'>*</span>", '', array('class' => 'control-label refreshable')) ?>
                <?php //echo $form->labelEx($modPasien, 'pendidikan_id', array('class' => 'control-label refreshable')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'pendidikan_id', CHtml::listData($modPasien->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'), array('style' => 'width:170px;', 'empty' => '-- Pilih --', 'class' => 'form-control span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
            <?php echo $form->textAreaRow($model, 'kepercayaan', array('placeholder' => '', 'rows' => 2, 'cols' => 60, 'class' => 'form-control autogrow span3 required' . $alamat_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

        </div>
    </div>
</div>
<!--<br>-->

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
if ($this->id == "pendaftaranPersalinan") {
    $modDataPasien->jeniskelamin = Params::JENIS_KELAMIN_PEREMPUAN;
}

if (isset($_GET['PPPasienM'])) {
    $modDataPasien->attributes = $_GET['PPPasienM'];
    $modDataPasien->nama_bin = $_GET['PPPasienM']['nama_bin'];

    $modDataPasien->tanggal_lahir =  isset($_GET['PPPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['PPPasienM']['tanggal_lahir']) : null;
    $modDataPasien->cari_kelurahan_nama = $_GET['PPPasienM']['cari_kelurahan_nama'];
    $modDataPasien->cari_kecamatan_nama = $_GET['PPPasienM']['cari_kecamatan_nama'];
    if (isset($_GET['PPPasienM']['nomorindukpegawai'])) {
        $modDataPasien->nomorindukpegawai = $_GET['PPPasienM']['nomorindukpegawai'];
    }
    if (isset($_GET['PPPasienM']['tanggal_lahir'])) {
        $modDataPasien->tanggal_lahir = MyFormatter::formatDateTimeForDB($_GET['PPPasienM']['tanggal_lahir']);
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

$prov = $modDataPasien->searchDialog();

if (!empty($modDataPasien->tanggal_lahir)) {
    $modDataPasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($modDataPasien->tanggal_lahir);
}

?>

<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    'dataProvider' => $prov,
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
            'filter' => (($this->id == "pendaftaranPersalinan") ? false : $drop_lookjeniskelamin),
            'value' => '$data->jeniskelamin'
        ),
        //                    array(
        //                        'name'=>'tanggal_lahir',
        //                        'type'=>'raw',
        //                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
        //                    ),
        array(
            'name' => 'tanggal_lahir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
            // 'filter' => $this->widget(
            //     'MyDateTimePicker',
            //     array(
            //         'model' => $modDataPasien,
            //         'attribute' => 'tanggal_lahir',
            //         'mode' => 'date',
            //         'options' => array(
            //             'dateFormat' => Params::DATE_FORMAT,
            //         ),
            //         'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'tanggal_lahir', 'placeholder' => '23 Jan 1993'),
            //     ),
            //     true
            // ),
            'filter' => $form->textField($modPasien, 'tanggal_lahir', array('autocomplete' => 'on', 'style' => '', 'placeholder' => '00/00/0000', 'class' => 'form-control dtPicker2 datemask span3', 'onkeyup' => "return $(this).focusNextInputField(event)")),
            'htmlOptions' => array('width' => '140', 'style' => 'text-align:center'),
        ),
        'alamat_pasien',
        //'rw',
        //'rt',
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
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'\'}));
                // jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});


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
if ($this->id == "pendaftaranPersalinan") {
    $modDataPasien2->jeniskelamin = Params::JENIS_KELAMIN_PEREMPUAN;
}
if (isset($_GET['PPPasienM'])) {
    $modDataPasien2->attributes = $_GET['PPPasienM'];
    //        $modDataPasien->tanggal_lahir =  isset($_GET['PPPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['PPPasienM']['tanggal_lahir']) : null;
    $modDataPasien2->cari_kelurahan_nama = $_GET['PPPasienM']['cari_kelurahan_nama'];
    $modDataPasien2->cari_kecamatan_nama = $_GET['PPPasienM']['cari_kecamatan_nama'];
    if (isset($_GET['PPPasienM']['nomorindukpegawai'])) {
        $modDataPasien2->nomorindukpegawai = $_GET['PPPasienM']['nomorindukpegawai'];
    }
    if (isset($_GET['PPPasienM']['tanggal_lahir'])) {
        $modDataPasien2->tanggal_lahir = MyFormatter::formatDateTimeForDB($_GET['PPPasienM']['tanggal_lahir']);
    }

    $kec = KecamatanM::model()->findByAttributes(array(
        'kecamatan_nama' => $modDataPasien2->cari_kecamatan_nama
    ));

    if (empty($kec))
        $kec_id = null;
    else
        $kec_id = $kec->kecamatan_id;
}

$prov2 = $modDataPasien2->searchDialogBadak();

if (!empty($modDataPasien2->tanggal_lahir)) {
    $modDataPasien2->tanggal_lahir = MyFormatter::formatDateTimeForUser($modDataPasien->tanggal_lahir);
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
    'dataProvider' => $prov2,
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
            'filter' => (($this->id == "pendaftaranPersalinan") ? false : $drop_lookjeniskelamin),
            'value' => '$data->jeniskelamin'
        ),
        //                    array(
        //                        'name'=>'tanggal_lahir',
        //                        'type'=>'raw',
        //                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
        //                    ),
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
        //'rw',
        //'rt',
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
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'\'}));
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
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ambil', array('{icon}' => '<i class="entypo-camera"></i>')), array('id' => 'btn_ambil_gambar', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'ambilGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="icon-download-alt icon-white"></i>')), array('id' => 'btn_simpan_gambar', 'disabled' => true, 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'simpanGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('id' => 'btn_ulang_gambar', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'ulangGambar();', 'style' => 'font-size:10px; width:76px; height:24px;')); ?>
    <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
</div>
<?php $this->endWidget(); ?>
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


    function ambilFoto() {
        $("#con_foto_scan").empty();
        $("#btn-addphoto").addClass("animation-loading");
        $.post('<?php echo $this->createUrl('ajaxLoadPhotoScan'); ?>', {}, function(data) {
            if (data.ok == 1) {
                $("#con_foto_scan").html(data.html);
                $("#btn-hapusphoto").show();

                if (data.pasien_id != "") {
                    $(".rmlama").click();
                    setPasienLama(data.pasien_id, data.no_rm, false);
                }

            } else {
                myAlert(data.msg);
            }
            $("#btn-addphoto").removeClass("animation-loading");
        }, 'json');
    }

    function hapusFoto() {
        $("#con_foto_scan").empty();
    }

    var data_ktp = null;

    function setDataKtpPasien() {
        if (data_ktp != null) {
            $("#<?php echo CHtml::activeId($modPasien, 'jenisidentitas'); ?>").val("KTP");
            $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien'); ?>").val(data_ktp.nik);
            $("#<?php echo CHtml::activeId($modPasien, 'nama_pasien'); ?>").val(data_ktp.nama);
            $("#<?php echo CHtml::activeId($modPasien, 'tempat_lahir'); ?>").val(data_ktp.tempat_lahir);
            $("#<?php echo CHtml::activeId($modPasien, 'tanggal_lahir'); ?>").val(data_ktp.tanggal_lahir).blur();
            $("#<?php echo CHtml::activeId($modPasien, 'golongandarah'); ?>").val(data_ktp.golongandarah);
            $("#<?php echo CHtml::activeId($modPasien, 'alamat_pasien'); ?>").val(data_ktp.alamat);
            $("#<?php echo CHtml::activeId($modPasien, 'rt'); ?>").val(data_ktp.rt);
            $("#<?php echo CHtml::activeId($modPasien, 'rw'); ?>").val(data_ktp.rw);
            $("#<?php echo CHtml::activeId($modPasien, 'agama'); ?>").val(data_ktp.agama);
            $("#<?php echo CHtml::activeId($modPasien, 'warga_negara'); ?>").val(data_ktp.kewarganegaraan);
            $("#<?php echo CHtml::activeId($modPasien, 'statusperkawinan'); ?>").val(data_ktp.statusnikah);
            $("#<?php echo CHtml::activeId($modPasien, 'pekerjaan_id'); ?>").val(data_ktp.pekerjaan_id);
            $("#<?php echo CHtml::activeId($modPasien, 'propinsi_id'); ?>").val(data_ktp.propinsi_id);
            $("#<?php echo CHtml::activeId($modPasien, 'kabupaten_id'); ?>").html(data_ktp.kabupaten_list).val(data_ktp.kabupaten_id);
            $("#<?php echo CHtml::activeId($modPasien, 'kecamatan_id'); ?>").html(data_ktp.kecamatan_list).val(data_ktp.kecamatan_id);
            $("#<?php echo CHtml::activeId($modPasien, 'kelurahan_id'); ?>").html(data_ktp.kelurahan_list).val(data_ktp.kelurahan_id);

            $("#main_foto_preview").html(data_ktp.foto);
            $("#con_foto_scan").html(data_ktp.foto);
            $("#PPPasienM_is_ambilfoto").val(1);
            $("#PPPasienM_photopasien").val(data_ktp.foto_bin);

            setJenisKelaminPasien(data_ktp.jeniskelamin);
            // data_ktp = null;
        }
    }

    function loadKTP() {
        $.post('<?php echo $this->createUrl('loadKTP'); ?>', {}, function(data) {
            if (data.ok == 1) {
                console.log(data.ktp);
                data_ktp = data.ktp;

                if (data_ktp.pasien_baru == 1) {
                    $("#rb_rm").click();

                    setDataKtpPasien();

                    // setDaerahPasien(data_ktp.propinsi_id, data_ktp.kabupaten_id, data_ktp.kecamatan_id, data_ktp.kelurahan_id);

                } else {
                    setPasienLama(data.ktp.pasien_id, "", "");
                }

            } else {}
        }, 'json');
    }

    <?php if (Yii::app()->user->getState('is_ktpreader') == true && !empty(Yii::app()->user->getState('ktpreader_load_interval'))) : ?>

        setInterval(function() {
            loadKTP();
        }, <?php echo Yii::app()->user->getState('ktpreader_load_interval'); ?>);

    <?php endif; ?>

    function setPlaceHolderNomor() {
        var jenis = $("#tipe_nomor_pasien").val();

        if (jenis == "nomor_peserta") {
            $("#cari_nomor_pasien").attr("placeholder", "Cari berdasarkan No.Peserta BPJS Pasien");
        } else if (jenis == "no_rujukan") {
            $("#cari_nomor_pasien").attr("placeholder", "Cari berdasarkan No.Rujukan BPJS Pasien");
        } else if (jenis == "nik") {
            $("#cari_nomor_pasien").attr("placeholder", "Cari berdasarkan NIK Pasien");
        } else if (jenis == "no_kk") {
            $("#cari_nomor_pasien").attr("placeholder", "Cari berdasarkan No.KK Pasien");
        } else if (jenis == "nip") {
            $("#cari_nomor_pasien").attr("placeholder", "Cari berdasarkan NIP Pasien");
        }
    }

    function cariNomorPasien() {
        var jenis = $("#tipe_nomor_pasien").val();
        var nomor = $("#cari_nomor_pasien").val();

        if (nomor.trim() == "") {
            return false;
        }

        $("#cari_nomor_pasien").addClass("animation-loading");

        if (jenis == "nomor_peserta") {
            loadNoPesertaBPJS(nomor);
        } else if (jenis == "nik") {
            loadNIKBPJS(nomor);
        } else if (jenis == "no_rujukan") {
            loadNoRujukanBPJS(nomor);
        } else if (jenis == "nip") {
            loadPasienDariNIPKK(jenis, nomor);
        } else if (jenis == "no_kk") {
            loadPasienDariNIPKK(jenis, nomor);
        }
    }

    function loadPasienDariNIPKK(jenis, nomor) {
        $.post('<?php echo $this->createUrl('cekPasienDariJenisNomor'); ?>', {
            jenis: jenis,
            nomor: nomor
        }, function(data) {
            if (data.ok == 1) {

                $(".pasien_pegawai_id").val(data.pegawai_id);

                if (data.ok_pasien == 1) {
                    setPasienLama(data.pasien_id, data.no_rekam_medik);
                } else {
                    $(".rb_rm.rmbaru").click();

                    var pegawai = data.pegawai_data;

                    // tanggal_lahir            
                    var d_lahir = new Date(pegawai.tgl_lahirpegawai);

                    $("#PPPasienM_jenisidentitas").val(pegawai.jenisidentitas);
                    $("#PPPasienM_no_identitas_pasien").val(pegawai.noidentitas);
                    $("#PPPasienM_nama_pasien").val(pegawai.nama_pegawai);
                    $("#PPPasienM_tempat_lahir").val(pegawai.tempatlahir_pegawai);
                    $("#PPPasienM_golongandarah").val(pegawai.golongandarah);
                    $("#PPPasienM_statusperkawinan").val(pegawai.statusperkawinan);
                    $("#PPPasienM_alamat_pasien").val(pegawai.alamat_pegawai);
                    $("#PPPasienM_agama").val(pegawai.agama);
                    $("#PPPasienM_alamatemail").val(pegawai.alamatemail);
                    $("#PPPasienM_no_telepon_pasien").val(pegawai.notelp_pegawai);
                    $("#PPPasienM_no_mobile_pasien").val(pegawai.nomobile_pegawai);
                    $("#PPPasienM_warga_negara").val(pegawai.warganegara_pegawai);
                    $("#PPPasienM_tanggal_lahir").val(d_lahir.getDate().toString().padStart(2, "0") + "/" + d_lahir.getMonth().toString().padStart(2, "0") + "/" + d_lahir.getFullYear().toString().padStart(4, "0"));

                    setDaerahPasien(pegawai.propinsi_id, pegawai.kabupaten_id, pegawai.kecamatan_id, pegawai.kelurahan_id);

                    if (pegawai.jeniskelamin.trim() == "Laki-Laki") {
                        $("#PPPasienM_jeniskelamin_0").click();
                    } else {
                        $("#PPPasienM_jeniskelamin_1").click();
                    }
                    tanggal_lahir
                    setUmur($("#PPPasienM_tanggal_lahir").val());
                }
            } else {
                myAlert("Data pegawai Tidak ditemukan");
                $("#cari_nomor_pasien").addClass("animation-loading").val("");
            }
            $("#cari_nomor_pasien").removeClass("animation-loading");
        }, 'json');
    }

    function loadNoPesertaBPJS(nomor) {
        $.ajax({
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=1&query=' + nomor,
            success: function(data) {
                var obj = JSON.parse(data);
                console.log('data', obj)
                if (obj.response != null) {
                    console.log(obj);

                    var peserta = obj.response.peserta;

                    $.post('<?php echo $this->createUrl('cekPasienBerdasarkanNoAsuransi'); ?>', {
                        nomor: peserta.noKartu
                    }, function(data) {
                        if (data.ok == 1) {
                            setPasienLama(data.pasien_id, data.no_rekam_medik);
                        } else {
                            $(".rb_rm.rmbaru").click();

                            var d_lahir = new Date(peserta.tglLahir);
                            var bulan = d_lahir.getMonth() + 1;

                            $("#PPPasienM_jenisidentitas").val("KTP");
                            $("#PPPasienM_no_identitas_pasien").val(peserta.nik);
                            $("#PPPasienM_nama_pasien").val(peserta.nama);
                            $("#PPPasienM_tanggal_lahir").val(d_lahir.getDate().toString().padStart(2, "0") + "/" + bulan.toString().padStart(2, "0") + "/" + d_lahir.getFullYear().toString().padStart(4, "0"));

                            if (peserta.sex == "L") {
                                $("#PPPasienM_jeniskelamin_0").click();
                            } else {
                                $("#PPPasienM_jeniskelamin_1").click();
                            }

                            setUmur($("#PPPasienM_tanggal_lahir").val());

                        }
                        $("#cari_nomor_pasien").removeClass("animation-loading");
                    }, 'json');

                    $("#PPPendaftaranT_carabayar_id").val(2).change();
                    $("#PPSepT_jenisfaskes_0").click();
                    <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") : ?>

                        getAsuransiNoKartuIGD(peserta.noKartu);

                        $("#PPAsuransipasienM_nopeserta").val(peserta.noKartu);
                        $("#PPSepT_nopeserta").val(peserta.noKartu);
                        $("#PPAsuransipasienM_nokartuasuransi").val(peserta.noKartu);
                        $("#PPAsuransipasienM_namapemilikasuransi").val(peserta.nama);
                    <?php else : ?>
                        getAsuransiNoKartu(peserta.noKartu);
                    <?php endif; ?>


                } else {
                    myAlert(obj.metaData.message);
                    $("#cari_nomor_pasien").removeClass("animation-loading").val("");
                }
            },
            error: function(data) {
                $("#cari_nomor_pasien").removeClass("animation-loading");
            }
        });
    }

    function loadNIKBPJS(nomor) {
        $.ajax({
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=2&query=' + nomor,
            success: function(data) {
                var obj = JSON.parse(data);
                if (obj.response != null) {

                    var peserta = obj.response.peserta;

                    $.post('<?php echo $this->createUrl('cekPasienBerdasarkanNoAsuransi'); ?>', {
                        nomor: peserta.noKartu
                    }, function(data) {

                        if (data.ok == 1) {
                            setPasienLama(data.pasien_id, data.no_rekam_medik);
                        } else {
                            $(".rb_rm.rmbaru").click();

                            var d_lahir = new Date(peserta.tglLahir);

                            var date = peserta.tglLahir;
                            var [year, month, day] = date.split('-');
                            var result = [day, month, year].join('/');

                            $("#PPPasienM_jenisidentitas").val("KTP");
                            $("#PPPasienM_no_identitas_pasien").val(peserta.nik);
                            $("#PPPasienM_nama_pasien").val(peserta.nama);
                            // $("#PPPasienM_tanggal_lahir").val(d_lahir.getDate().toString().padStart(2, "0") + "/" + d_lahir.getMonth().toString().padStart(2, "0") + "/" + d_lahir.getFullYear().toString().padStart(4, "0"));
                            $("#PPPasienM_tanggal_lahir").val(result);
                            if (peserta.sex == "L") {
                                $("#PPPasienM_jeniskelamin_0").click();
                            } else {
                                $("#PPPasienM_jeniskelamin_1").click();
                            }

                            setUmur($("#PPPasienM_tanggal_lahir").val());

                        }
                        $("#cari_nomor_pasien").removeClass("animation-loading");
                    }, 'json');

                    $("#PPPendaftaranT_carabayar_id").val(2).change();
                    $("#PPSepT_jenisfaskes_0").click();

                    <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") : ?>
                        $("#PPAsuransipasienM_nopeserta").val(peserta.noKartu);
                        $("#PPAsuransipasienM_nokartuasuransi").val(peserta.noKartu);
                        $("#PPAsuransipasienM_namapemilikasuransi").val(peserta.nama);
                    <?php else : ?>
                        getAsuransiNoPeserta(peserta.noKartu);
                    <?php endif; ?>


                } else {
                    myAlert(obj.metaData.message);
                    $("#cari_nomor_pasien").removeClass("animation-loading").val("");;
                }
            },
            error: function(data) {
                $("#cari_nomor_pasien").removeClass("animation-loading");
            }
        });
    }

    function loadNoRujukanBPJS(nomor) {
        $.ajax({
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=3&query=' + nomor,
            success: function(data) {
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    console.log(obj);

                    var rujukan = obj.response.rujukan;
                    var peserta = obj.response.rujukan.peserta;

                    $.post('<?php echo $this->createUrl('cekPasienBerdasarkanNoAsuransi'); ?>', {
                        nomor: peserta.noKartu
                    }, function(data) {
                        if (data.ok == 1) {
                            setPasienLama(data.pasien_id, data.no_rekam_medik);
                        } else {
                            $(".rb_rm.rmbaru").click();

                            var d_lahir = new Date(peserta.tglLahir);

                            $("#PPPasienM_jenisidentitas").val("KTP");
                            $("#PPPasienM_no_identitas_pasien").val(peserta.nik);
                            $("#PPPasienM_nama_pasien").val(peserta.nama);
                            $("#PPPasienM_tanggal_lahir").val(d_lahir.getDate().toString().padStart(2, "0") + "/" + d_lahir.getMonth().toString().padStart(2, "0") + "/" + d_lahir.getFullYear().toString().padStart(4, "0"));

                            if (peserta.sex == "L") {
                                $("#PPPasienM_jeniskelamin_0").click();
                            } else {
                                $("#PPPasienM_jeniskelamin_1").click();
                            }

                            setUmur($("#PPPasienM_tanggal_lahir").val());

                        }
                        $("#cari_nomor_pasien").removeClass("animation-loading");
                    }, 'json');

                    $.post('<?php echo $this->createUrl('cekRuanganBerdasarkanPoliBPJS') ?>', {
                        kode_ruangan: rujukan.poliRujukan.kode  
                    }, function(data) {
                        if (data.ok == 1) {
                            $("#PPPendaftaranT_ruangan_id").val(data.ruangan_id).change();
                        }
                    }, 'json');

                    $("#PPPendaftaranT_carabayar_id").val(2).change();
                    $("#PPSepT_jenisfaskes_0").click();
                    <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") : ?>
                        $("#PPAsuransipasienM_nopeserta").val(peserta.noKartu);
                        $("#PPAsuransipasienM_nokartuasuransi").val(peserta.noKartu);
                        $("#PPAsuransipasienM_namapemilikasuransi").val(peserta.nama);
                    <?php else : ?>
                        getRujukanNoRujukan(rujukan.noKunjungan);
                    <?php endif; ?>



                } else {
                    myAlert(obj.metaData.message);
                    $("#cari_nomor_pasien").removeClass("animation-loading").val("");;
                }
            },
            error: function(data) {
                $("#cari_nomor_pasien").removeClass("animation-loading");
            }
        });
    }

    $('#cari_nomor_pasien').keypress(function(e) {

        var key = e.which;
        if (key == 13) // the enter key code
        {
            $(this).trigger("blur");
        }
    });


    $(document).ready(function() {
        jQuery("input#tanggal_lahir").datepicker(jQuery.extend({
            showMonthAfterYear: false
        }, jQuery.datepicker.regional["id"], {
            "dateFormat": "dd M yy",
            "maxDate": "d",
            "timeText": "Waktu",
            "hourText": "Jam",
            "minuteText": "Menit",
            "secondText": "Detik",
            "showSecond": true,
            "timeOnlyTitle": "Pilih Waktu",
            "timeFormat": "hh:mm:ss",
            "changeYear": true,
            "changeMonth": true,
            "showAnim": "fold",
            "yearRange": ""
        }));
        //        jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '_date").on("click", function(){jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").datepicker("show");});
        jQuery("input#tanggal_lahir").datepicker({
            "maxDate": "' . date('m/d/Y') . '",
            "showDropdowns": true,
        });

        $("#btn-hapusphoto").hide();
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

        setPlaceHolderNomor();
    });

    function showDateTime() {
        $("#PPPasienM_tanggal_lahir").datepicker();
    }

    $(document).ready(function() {
        <?php if ($this->id == "pendaftaranPersalinan") { ?>
            $("#PPPasienM_jeniskelamin_0").parents(".radio").remove();
        <?php } ?>
        var lk = $("label[for='PPPasienM_jeniskelamin_0']").html();
        if (lk !== undefined) {
            $("label[for='PPPasienM_jeniskelamin_0']").html(lk.toUpperCase());
        }

    });
</script>

<?php
//================= end dialog webcam =====================

if (Yii::app()->user->getState('is_finger_pasien')) {
    echo $this->renderPartial('pendaftaranPenjadwalan.views.daftarSidikJariPasien._jsFunctionsFinger', array('modPasien' => $modPasien, 'modul_akses' => 'pendaftaran'));
}
?>

<?php
// Dialog cetak label gelang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogLabelGelang',
    'options' => array(
        'title' => 'Label Gelang Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 640,
        'height' => 280,
        'resizable' => true,
    ),
));
?>
<iframe name='frameLabelGelang' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>