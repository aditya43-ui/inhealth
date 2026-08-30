<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/protected/extensions/jpegcam/assets/webcam.js'); ?>
<?php
$nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps" : "");
$alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps" : "");

$konSys = KonfigsystemK::model()->find();
?>

<div class="col-sm-12">
    <div id="loading"></div>
    </div>

<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-user"></i> Data <b>Pribadi</b>
                <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
            </div>
        </div>
        <div class="panel-body">
            <!-- <div class="control-group">
                <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    // echo CHtml::radioButton('rb_rm', false, array(
                    //     'value' => 1,
                    //     'name' => 'otomatis',
                    //     'uncheckValue' => null,
                    //     'onchange' => 'switchOtomatis(this)',
                    //     'class' => 'rb_rm rmbaru',
                    //     'id' => 'pasienbaru',
                    // )) . "<label for='pasienbaru'>Pasien Baru</label> ";
                    // echo CHtml::radioButton('rb_rm', false, array(
                    //     'value' => 0,
                    //     'name' => 'otomatis',
                    //     'uncheckValue' => null,
                    //     'onchange' => 'switchOtomatis(this)',
                    //     'class' => 'rb_rm rmlama',
                    //     'id' => 'pasienlama',
                    // )) . "<label for='pasienlama'>Pasien Lama</label> ";
                    ?>
                </div>
            </div> -->
            <!--</div>-->
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
                            'class' => 'span3 numbers-only-control delapan'
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
                            'class' => 'span3 numbers-only form-control span3'
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
                            'class' => 'numbers-only f_rm form-control delapan span3', 'maxlength' => $konSys->jmldigitrm, 'id' => 'no_rekam_medik_baru'
                        ),
                    )); ?>
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
                            'class' => 'numbers-only f_rm', 'maxlength' => 8,
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPasien, 'no_rekam_medik'); ?>
                    <?php echo $form->hiddenField($modPasien, 'pasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label('No Identitas <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $modPasien,
                        'jenisidentitas',
                        LookupM::getItems('jenisidentitas'),
                        array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'style' => 'float:left; width:80px')
                    ); ?>
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
                        'htmlOptions' => array('placeholder' => 'No. Identitas Pasien', 'rel' => 'tooltip', 'title' => 'No. Identitas untuk masukan data / mencari pasien', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 angkahuruf-only all-caps', 'onblur'=>'setInputBerdasarkanNoKTP();'),
                    ));
                    ?>

                    <?php echo $form->error($modPasien, 'jenisidentitas'); ?>
                    <?php echo $form->error($modPasien, 'no_identitas_pasien'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $modPasien,
                        'namadepan',
                        LookupM::getItems('namadepan'),
                        array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'style' => 'float:left; width:80px')
                    ); ?>
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
                        'htmlOptions' => array('placeholder' => 'Nama Lengkap Pasien', 'rel' => 'tooltip', 'title' => 'Ketik Nama untuk masukan data / mencari pasien', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 ' . $nama_kapital),
                    ));
                    ?>
                    <?php echo $form->error($modPasien, 'namadepan'); ?>
                    <?php echo $form->error($modPasien, 'nama_pasien'); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($modPasien, 'nama_bin', array('placeholder' => 'Alias / Nama Panggilan Pasien', 'class' => 'span3 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($modPasien, 'tempat_lahir', array('placeholder' => 'Kota/Kabupaten Kelahiran', 'class' => 'span3 all-caps', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 25)); ?>
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
                            //                                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                            'onkeyup' => "js:function(){setUmur(this.value);}",
                            'onSelect' => 'js:function(){setUmur(this.value);}',
                            'yearRange' => "-150:+0",
                        ),
                        'htmlOptions' => array(
                            'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask span3', 'onblur' => 'setUmur(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)"
                        ),
                    )); ?>
                    <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                </div>
            </div>

            <?php echo $form->textFieldRow($model, 'umur', array('placeholder' => '00 Thn 00 Bln 00 Hr', 'class' => 'span3 umur', 'onblur' => 'setTglLahir(this);', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>

            <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setNamaDepan()", 'class' => '')); ?>
            <?php if(Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_LAB) : ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'golongandarah', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $modPasien,
                        'golongandarah',
                        LookupM::getItems('golongandarah'),
                        array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')
                    ); ?>
                    <div class="radio inline">
                        <div class="form-inline">
                            <?php echo $form->radioButtonList($modPasien, 'rhesus', LookupM::getItems('rhesus'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'rhesus')); ?>
                        </div>
                    </div>
                    <?php echo $form->error($modPasien, 'golongandarah'); ?>
                    <?php echo $form->error($modPasien, 'rhesus'); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($modPasien, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaDepan()', 'class' => 'span3')); ?>
            <?php echo $form->textFieldRow($modPasien, 'nama_ibu', array('placeholder' => 'Nama Ibu Kandung Pasien', 'class' => 'span3 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-map-marker"></i> Alamat dan Kontak
            </div>
        </div>
        <div class="panel-body">
            <?php echo $form->textAreaRow($modPasien, 'alamat_pasien', array('placeholder' => 'Alamat Lengkap Pasien', 'rows' => 2, 'cols' => 50, 'class' => 'span3 ' . $alamat_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'rt', array('class' => 'control-label inline')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPasien, 'rt', array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 numbers-only', 'maxlength' => 3, 'placeholder' => 'RT')); ?> /
                    <?php echo $form->textField($modPasien, 'rw', array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 numbers-only', 'maxlength' => 3, 'placeholder' => 'RW')); ?>
                    <?php echo $form->error($modPasien, 'rt'); ?>
                    <?php echo $form->error($modPasien, 'rw'); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'propinsi_id', array('class' => 'control-label refreshableLocation')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $modPasien,
                        'propinsi_id',
                        CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),
                        array(
                            'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            //'ajax' => array(
                            //    'type' => 'POST',
                            //    'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($modPasien))),
                            //    'update' => "#" . CHtml::activeId($modPasien, 'kabupaten_id'),
                            //),
                            //'onchange' => "setClearDropdownKelurahan();setClearDropdownKecamatan();",
                        )
                    ); ?>
                    <?php echo $form->error($modPasien, 'propinsi_id'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'kabupaten_id', array('class' => 'control-label refreshableLocation')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $modPasien,
                        'kabupaten_id',
                        CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'),
                        array(
                            'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            //'ajax' => array(
                            //    'type' => 'POST',
                            //    'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($modPasien))),
                            //    'update' => "#" . CHtml::activeId($modPasien, 'kecamatan_id'),
                            //),
                            //'onchange' => "setClearDropdownKelurahan();",
                        )
                    ); ?>
                    <?php echo $form->error($modPasien, 'kabupaten_id'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'kecamatan_id', array('class' => 'control-label refreshableLocation')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $modPasien,
                        'kecamatan_id',
                        CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'),
                        array(
                            'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            //'ajax' => array(
                            //    'type' => 'POST',
                            //    'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($modPasien))),
                            //    'update' => "#" . CHtml::activeId($modPasien, 'kelurahan_id'),
                            //),
                            //'onchange' => "",
                        )
                    ); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'kelurahan_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php // $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id))?$modPasien->kelurahan_id:Yii::app()->user->getState('kelurahan_id');
                    ?>
                    <?php echo $form->dropDownList(
                        $modPasien,
                        'kelurahan_id',
                        CHtml::listData($modPasien->getKelurahanItems($modPasien->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
                        array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")
                    ); ?>
                    <?php echo $form->error($modPasien, 'kelurahan_id'); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("No. Handphone", '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPasien, 'no_mobile_pasien', array('placeholder' => 'No. Handphone', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 15)); ?>
                    <?php //echo CHtml::checkBox('is_whatsapp', true, array('rel'=>'tooltip', 'title'=>'Klik untuk mengirim pesan Whatsapp')); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($modPasien, 'no_telepon_pasien', array('placeholder' => 'No. Telepon', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 15)); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'pekerjaan_id', array('class' => 'control-label refreshable')); ?>
                <div class='controls'>
                    <?php echo $form->dropDownList($modPasien, 'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($modPasien, 'warga_negara', LookupM::getItems('warganegara'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'agama', array('class' => 'control-label refreshable')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'agama', LookupM::getItems('agama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasienBadak',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 480,
        'resizable' => false,
    ),
));

$modDataPasien = new PPPasienM('searchDialog');
$modDataPasien->unsetAttributes();
$format = new MyFormatter();
$modDataPasien->ispasienluar = FALSE;
if (isset($_GET['PPPasienM'])) {
    $modDataPasien->attributes = $_GET['PPPasienM'];
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

$prov = $modDataPasien->searchDialogBadak();

if (!empty($modDataPasien->tanggal_lahir)) {
    $modDataPasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($modDataPasien->tanggal_lahir);
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasienbadak-m-grid',
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
                                            $(\"#dialogPasienBadak\").dialog(\"close\");
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'type' => 'raw',
            'value' => '$data->pegawai?->nomorindukpegawai',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'nama_bin',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => LookupM::model()->getItems('jeniskelamin'),
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
            'htmlOptions' => array('width' => '180', 'style' => 'text-align:center'),
        ),
        'alamat_pasien',
        'rw',
        'rt',
        array(
            'header' => 'Nama Kelurahan',
            'name' => 'cari_kelurahan_nama',
            'type' => 'raw',
            'value' => 'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""'
        ),
        array(
            'header' => 'Nama Kecamatan',
            'name' => 'cari_kecamatan_nama',
            'type' => 'raw',
            'value' => '$data->kecamatan->kecamatan_nama'
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
            'htmlOptions' => array('width' => '180', 'style' => 'text-align:center'),
        ),
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
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien Laboratorium',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDataPasien = new PPPasienM('search');
$modDataPasien->unsetAttributes();
if (isset($_GET['PPPasienM'])) {
    $modDataPasien->attributes = $_GET['PPPasienM'];
    $modDataPasien->cari_kelurahan_nama = $_GET['PPPasienM']['cari_kelurahan_nama'];
    $modDataPasien->cari_kecamatan_nama = $_GET['PPPasienM']['cari_kecamatan_nama'];
}
$modDataPasien->ispasienluar = false;

$prov = $modDataPasien->searchDialog();

if (!empty($modDataPasien->tanggal_lahir)) {
    $modDataPasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($modDataPasien->tanggal_lahir);
}

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
            'filter' => LookupM::model()->getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin'
        ),
        'alamat_pasien',
        'rw',
        'rt',
        array(
            'header' => 'Nama Kelurahan',
            'name' => 'cari_kelurahan_nama',
            'type' => 'raw',
            'value' => 'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""'
        ),
        array(
            'header' => 'Nama Kecamatan',
            'name' => 'cari_kecamatan_nama',
            'type' => 'raw',
            'value' => '$data->kecamatan->kecamatan_nama'
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
            'htmlOptions' => array('width' => '180', 'style' => 'text-align:center'),
        ),
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

<!-- Pemeriksaan lab seperti di rujukan -->



<?php

    /** =============== TIM MEDIS ===================== * */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogLab',
    'options' => array(
        'title' => 'Daftar Pemeriksaan Laboratorium',
        'autoOpen' => false,
        'width' => 800,
        'height' => 600,
        'resizable' => true,
    ),
        )
);

$format = new MyFormatter();
$modTarif = new LBTariftindakanM('search');
$modTarif->unsetAttributes();
$modTarif->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;
if (isset($_GET['LBTariftindakanM'])) {
    $modTarif->attributes = $_GET['LBTariftindakanM'];
    $modTarif->kategoritindakan_nama = $_GET['LBTariftindakanM']['kategoritindakan_nama'] ?? "";
    $modTarif->daftartindakan_kode = $_GET['LBTariftindakanM']['daftartindakan_kode'] ?? "";
    $modTarif->daftartindakan_nama = $_GET['LBTariftindakanM']['daftartindakan_nama'] ?? "";
    $modTarif->pemeriksaanlab_nama = $_GET['LBTariftindakanM']['pemeriksaanlab_nama'] ?? "";
    $modTarif->paket = $_GET['LBTariftindakanM']['paket'] ?? "";
}

if ($modTarif->paket == "paket") {

    $modTarif->unsetAttributes();
    if (isset($_GET['LBTariftindakanM'])) {
        $modTarif->attributes = $_GET['LBTariftindakanM'];
        $modTarif->tipepaket_nama = $_GET['LBTariftindakanM']['tipepaket_nama'] ?? "";
        $modTarif->paket = $_GET['LBTariftindakanM']['paket'];
    }


    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'dialog-tariftindakan-m-grid',
        'dataProvider' => $modTarif->searchPaket(),
        'filter' => $modTarif,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'filter' => CHtml::dropDownList('LBTariftindakanM[paket]', $modTarif->paket, ['paket' => 'Paket', 'nonpaket' => 'Non Paket'], array('empty' => '-- Pilih --')),
                'value' => function($data) {
                    return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                                "onclick" => "pilihPemeriksaanIniDialogPaket(".$data->tipepaket_id."); $('#dialogLab').dialog('close'); return false;"));
                },
            ),
            array(
                'header' => 'Nama Paket',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'tipepaket_nama', array('class' => 'span3')),
                'value' => '$data->tipepaket_nama',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    

} else {

    $modTarif->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'dialog-tariftindakan-m-grid',
        'dataProvider' => $modTarif->search2(),
        'filter' => $modTarif,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                // 'filter' => CHtml::dropDownList('LBTariftindakanM[paket]', $modTarif->paket, ['paket' => 'Paket', 'nonpaket' => 'Non Paket'], array('empty' => '-- Pilih --')),
                'value' => function($data) {
                    
                    echo CHtml::hiddenField('daftartindakan_kode', $data->daftartindakan->daftartindakan_kode, array('class' => 'span3 daftartindakan_kode'));
                    echo CHtml::hiddenField('pemeriksaanlab_id', $data->pemeriksaanlab_id, array('class' => 'span3 pemeriksaanlab_id_dialog'));
                    echo CHtml::hiddenField('pemeriksaanlab_nama', $data->pemeriksaanlab_nama, array('class' => 'span3 pemeriksaanlab_nama'));
                    echo CHtml::hiddenField('jenispemeriksaanlab_nama', $data->jenispemeriksaanlab_nama, array('class' => 'span3 jenispemeriksaanlab_nama'));
                    echo CHtml::hiddenField('daftartindakan_id', $data->daftartindakan_id, array('class' => 'span3 daftartindakan_id'));
                    echo CHtml::hiddenField('jenistarif_id', $data->jenistarif_id, array('class' => 'span3 jenistarif_id'));
                    echo CHtml::hiddenField('harga_tariftindakan', $data->harga_tariftindakan, array('class' => 'span3 harga_tariftindakan'));
                    echo CHtml::hiddenField('kelaspelayanan_id', $data->kelaspelayanan_id, array('class' => 'span3 kelaspelayanan_id_dialog'));
                    return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                                "onclick" => "pilihPemeriksaanIniNew(this); $('#dialogLab').dialog('close'); return false;"));
                },
            ),
            array(
                'header' => 'Kategori Tindakan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'kategoritindakan_nama', array('class' => 'span3')),
                'value' => '$data->daftartindakan->kategoritindakan->kategoritindakan_nama',
            ),
            array(
                'header' => 'Kode Tindakan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'daftartindakan_kode', array('class' => 'span3')),
                'value' => '$data->daftartindakan->daftartindakan_kode',
            ),
            array(
                'header' => 'Nama Pemeriksaan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'pemeriksaanlab_nama', array('class' => 'span3')),
                'value' => '$data->pemeriksaanlab_nama',
            ),
            array(
                'header' => 'Uraian Tindakan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'daftartindakan_nama', array('class' => 'span3')),
                'value' => '$data->daftartindakan->daftartindakan_nama',
            ),
            array(
                'header' => 'Kelas Pelayanan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::dropDownList('LBTariftindakanM[kelaspelayanan_id]', $modTarif->kelaspelayanan_id, CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif IS TRUE"), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --')),
                'value' => '$data->kelaspelayanan->kelaspelayanan_nama',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

}


$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END TIM MEDIS =======================================

?>
<!-- End -->


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
        $("#LBPasienM_photopasien").val(temp_img);
        $("#LBPasienM_is_ambilfoto").val(1);
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
            "yearRange": "-80y:+20y"
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
    });

    function showDateTime() {
        $("#PPPasienM_tanggal_lahir").datepicker();
    }
</script>

<?php //================= end dialog webcam ===================== 
?>

<?php

$listJenis = CHtml::listData(JenisvaksinM::model()->findAll('jenisvaksin_aktif = true order by jenisvaksin_nama asc'), 'jenisvaksin_id', 'jenisvaksin_nama');

$str_list_jenis = '<option value="">-- Pilih --</option>';
foreach ($listJenis as $val => $item) {
    $str_list_jenis.= '<option value="'.$val.'">'.$item.'</option>';;
}

?>

<script>
    
    var row_idx = 0;
    var item_jenis_vaksinasi = '<?php echo $str_list_jenis; ?>';
    var row_vaksinasi = <?php echo CJSON::encode(array(
        'html'=>$this->renderPartial("pendaftaranPenjadwalan.views.pendaftaranRawatJalan.vaksinasi._rowVaksinasi", array(), true),
    )); ?>;
        
        
    function getDataRiwayatVaksinasi(pasien_id) {
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/loadRiwayatVaksinasi') ?>', {pasien_id: pasien_id}, function(data) {
            if (data.ok == 1) {
                
                var idx = 0;
                
                $("#tab_riwayat_vaksinasi").html(data.html);
                
                renameInputRiwayatVaksinasi();
                
                $("#tab_riwayat_vaksinasi tr").each(function() {
                    
                    var date_input = $(this).find(".vaksinasi_tanggal").attr("id", "vaksinasi_tanggal_" + row_idx);
                    
                    $(date_input).datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                        jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                             'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                    $(date_input).parents(".input-append").find(".add-on").on('click', function() { $(date_input).datepicker('show'); }); 
                    
                    //$(this).find(".jenisvaksin_id").html(item_jenis_vaksinasi);
                    $(this).find(".vaksinasi_ke").maskMoney({
                        "symbol": "",
                        "defaultZero": true,
                        "allowZero": true,
                        "decimal": ",",
                        "thousands": "",
                        "precision": 0
                    });

                    row_idx++;
                    
                });
                
                if ($("#tab_riwayat_vaksinasi tr").length > 0) {
                    tampilFormRiwayatVaksinasi();
                }
            } else {
                myAlert(data.msg);
            }
        }, 'json');
    }    
        
    function hapusRowRiwayatVaksinasi(obj) {
        $(obj).parents("tr").remove();
    }    
        
        
        
    function tambahRowRiwayat() {
        $("#tab_riwayat_vaksinasi").append(row_vaksinasi.html);
        renameInputRiwayatVaksinasi();
        
        var last = $("#tab_riwayat_vaksinasi tr:last-child");
        
        var date_input = $(last).find(".vaksinasi_tanggal").attr("id", "vaksinasi_tanggal_" + row_idx);
        
        
        $(date_input).datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
        $(date_input).parents(".input-append").find(".add-on").on('click', function() { $(date_input).datepicker('show'); });             
        
        $(last).find(".jenisvaksin_id").html(item_jenis_vaksinasi);
        $(last).find(".vaksinasi_ke").maskMoney({
            "symbol": "",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": "",
            "precision": 0
        });
        
        row_idx++;
        
    }
    
    function renameInputRiwayatVaksinasi() {
        
        var name_val = "RiwayatvaksinasipasienT[detail]";
        var id_val = "RiwayatvaksinasipasienT_detail_";
        var idx = 0;
        
        $("#tab_riwayat_vaksinasi tr").each(function() {
            
            var name_res = name_val + '[' + idx + ']';
            // var id_res = id_val + idx + '_';
            
            $(this).find(".riwayatvaksinasipasien_id").attr("name", name_res + "[riwayatvaksinasipasien_id]");
            $(this).find(".vaksinasi_tanggal").attr("name", name_res + "[vaksinasi_tanggal]");
            $(this).find(".vaksinasi_ke").attr("name", name_res + "[vaksinasi_ke]");
            $(this).find(".jenisvaksin_id").attr("name", name_res + "[jenisvaksin_id]");
            $(this).find(".vaksin_id").attr("name", name_res + "[vaksin_id]");
            $(this).find(".daftarvaksin_id").attr("name", name_res + "[daftarvaksin_id]");
            $(this).find(".no_batch").attr("name", name_res + "[no_batch]");
            $(this).find(".vaksinasi_lokasimenerima").attr("name", name_res + "[vaksinasi_lokasimenerima]");
            
            idx++;
        });
    } 
    
    
    function setItemVaksin(obj) {
        var jenisvaksin_id = $(obj).val();
        var input_vaksin = $(obj).parents("tr").find(".vaksin_id");
        
        $(obj).parents("tr").find(".daftarvaksin_id").val("");
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListVaksin'); ?>', {jenisvaksin_id: jenisvaksin_id}, function(data) {
            $(input_vaksin).html(data.html);
        }, 'json');
    }
    
    function setItemDaftarVaksin(obj) {
        var vaksin_id = $(obj).val();
        var input_daftar_vaksin = $(obj).parents("tr").find(".daftarvaksin_id");
        
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListDaftarVaksin'); ?>', {vaksin_id: vaksin_id}, function(data) {
            $(input_daftar_vaksin).html(data.html);
        }, 'json');
    }
    
    function setLoadJenisVaksinasi() {
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListJenisVaksin'); ?>', {}, function(data) {
            
            $(".list_jenisvaksin").each(function() {
                var data_lama = $(this).val();
                $(this).html(data.html);
                $(this).val(data_lama);
            });
            
            item_jenis_vaksinasi = data.html;
        }, 'json');
    }
    
    function setLoadProgramVaksinasi(jenisvaksin_id) {
        $("#tab_riwayat_vaksinasi tr").each(function() {
            
            var input_vaksin = $(this).find(".vaksin_id");
            
            if ($(this).find(".jenisvaksin_id").val() == jenisvaksin_id) {
                $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListVaksin'); ?>', {jenisvaksin_id, jenisvaksin_id}, function(data) {
                    var nilai_lama = $(input_vaksin).val();
                    $(input_vaksin).html(data.html).val(nilai_lama);
                }, 'json');
            }
        });
    }
    function setLoadDaftarVaksinasi(vaksin_id) {
        console.log("VAKSIN", vaksin_id);
        $("#tab_riwayat_vaksinasi tr").each(function() {
            
            var input_vaksin = $(this).find(".daftarvaksin_id");
            
            if ($(this).find(".vaksin_id").val() == vaksin_id) {
                $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListDaftarVaksin'); ?>', {vaksin_id, vaksin_id}, function(data) {
                    var nilai_lama = $(input_vaksin).val();
                    $(input_vaksin).html(data.html).val(nilai_lama);
                }, 'json');
            }
        });
    }
    
    /** control accordion penanggung jawab pasien */
    $('#form-vaksinasi > div > .accordion-heading').click(function(){
    //    console.log("Detail PJ Pasien Di Klik!");
        var is_vaksinasi = $("#<?php echo CHtml::activeId($model, "is_vaksinasi"); ?>");
        if(is_vaksinasi.val() > 0){ //hide
            is_vaksinasi.val(0);
        }else{//show
            is_vaksinasi.val(1);
        }
    });
    
    function tampilFormRiwayatVaksinasi(){
        $('#form-vaksinasi > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-vaksinasi > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-vaksinasi').removeClass().addClass("accordion-body in collapse");
        $("#<?php echo CHtml::activeId($model, "is_vaksinasi"); ?>").val(1);
    }
    
    
    function cekValidasiRiwayatVaksinasi() {
        var is_kosong = 0;
        var is_vaksinasi = $("#<?php echo CHtml::activeId($model, "is_vaksinasi"); ?>").val();
        
        $("#tab_riwayat_vaksinasi .input_req").each(function() {
            $(this).removeClass("error");
            if ($(this).val() == "" || $(this).val() == null) {
                is_kosong = 1;
                $(this).addClass("error");
            }
        });
        
        if (is_kosong != 0 && is_vaksinasi == 1) {
            myAlert("Input pada Kolom * pada Tabel Riwayat Vaksinasi harus diisi");
            return false;
        }
        
        return true;
        
    }
</script>