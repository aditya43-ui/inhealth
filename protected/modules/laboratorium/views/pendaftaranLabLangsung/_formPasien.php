<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/protected/extensions/jpegcam/assets/webcam.js'); ?>
<?php
$nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps" : "");
$alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps" : "");
?>

<div class="col-sm-6">
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
                    'class' => 'span3 numbers-only form-control delapan'
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
                    'class' => 'numbers-only f_rm', 'maxlength' => 6,
                ),
            ));
            ?>
            <?php echo $form->error($modPasien, 'no_rekam_medik'); ?>
            <?php echo $form->hiddenField($modPasien, 'pasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        </div>
    </div>

    <div class="control-group no_identitas">
        <?php echo $form->labelEx($modPasien, 'no_identitas_pasien', array('class' => 'control-label refreshable')) ?>
        <div class="controls">
            <?php echo $form->dropDownList(
                $modPasien,
                'jenisidentitas',
                LookupM::getItems('jenisidentitas'),
                array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1', 'style' => 'float:left; width:80px')
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
                'htmlOptions' => array('placeholder' => 'No. Identitas Pasien', 'rel' => 'tooltip', 'title' => 'No. Identitas untuk masukan data / mencari pasien', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span2'),
            ));
            ?>

            <?php echo $form->error($modPasien, 'jenisidentitas'); ?>
            <?php echo $form->error($modPasien, 'no_identitas_pasien'); ?>
        </div>
    </div>
    <div class="control-group form_m">
        <?php echo CHtml::label("Nama Pasien <span class='required'>*</span>", 'nama_pasien', array('class' => 'control-label')) ?>
        <?php //echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
        <div class="controls">
            <span class='namadepan'>
            <?php echo $form->dropDownList(
                $modPasien,
                'namadepan',
                LookupM::getItems('namadepan'),
                array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1', 'style' => 'float:left; width:80px')
            ); ?>
            </span>
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
                'htmlOptions' => array('placeholder' => 'Nama Lengkap Pasien', 'rel' => 'tooltip', 'title' => 'Ketik Nama untuk masukan data / mencari pasien', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span2 ' . $nama_kapital),
            ));
            ?>
            <?php echo $form->error($modPasien, 'namadepan'); ?>
            <?php echo $form->error($modPasien, 'nama_pasien'); ?>
        </div>
    </div>
    <div class="control-group form_bm">
        <?php echo CHtml::label("Nama Spesimen <span class='required'>*</span>", 'nama_pasien', array('class' => 'control-label')) ?>
        <?php //echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
        <div class="controls">
            <span class='namadepan'>
            <?php echo $form->dropDownList(
                $modPasien,
                'namadepan',
                LookupM::getItems('namadepan'),
                array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1', 'style' => 'float:left; width:80px')
            ); ?>
            </span>
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
                'htmlOptions' => array('placeholder' => 'Nama Spesimen', 'rel' => 'tooltip', 'title' => 'Ketik Nama untuk masukan data / mencari pasien', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span2 ' . $nama_kapital),
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
                    'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onblur' => 'setUmur(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
            <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
        </div>
    </div>

    <?php echo $form->textFieldRow($model, 'umur', array('placeholder' => '00 Thn 00 Bln 00 Hr', 'class' => 'span3 umur', 'onblur' => 'setTglLahir(this);', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>

    <div class="control-group jeniskelamin">
        <?php echo $form->label($modPasien, 'jeniskelamin', array('class' => 'control-label required')) ?>
        <div class="controls">
            <?php echo $form->radioButtonListInline($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setNamaDepan()", 'class' => 'required')); ?>
        </div>
    </div>
    <?php //echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setNamaDepan()", 'class' => '')); ?>
    
    <div class="control-group">
        <?php echo $form->labelEx($modPasien, 'golongandarah', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList(
                $modPasien,
                'golongandarah',
                LookupM::getItems('golongandarah'),
                array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1')
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
</div>
<div class="col-sm-6">
    <div class="control-group alamat">
        <?php echo CHtml::label('Alamat Pasien <span class="required">*</span>', '', array('class' => 'control-label required_m')) ?>
        <div class="controls">
            <?php echo $form->textArea($modPasien, 'alamat_pasien', array('placeholder' => 'Alamat Lengkap Pasien', 'rows' => 2, 'cols' => 50, 'class' => 'span3 required_m' . $alamat_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <?php //echo $form->textAreaRow($modPasien, 'alamat_pasien', array('placeholder' => 'Alamat Lengkap Pasien', 'rows' => 2, 'cols' => 50, 'class' => 'span3 ' . $alamat_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
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
        <?php echo $form->labelEx($modPasien, 'propinsi_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList(
                $modPasien,
                'propinsi_id',
                CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),
                array(
                    'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($modPasien))),
                        'update' => "#" . CHtml::activeId($modPasien, 'kabupaten_id'),
                    ),
                    'onchange' => "setClearDropdownKelurahan();setClearDropdownKecamatan();",
                )
            ); ?>
            <?php echo $form->error($modPasien, 'propinsi_id'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPasien, 'kabupaten_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList(
                $modPasien,
                'kabupaten_id',
                CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'),
                array(
                    'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($modPasien))),
                        'update' => "#" . CHtml::activeId($modPasien, 'kecamatan_id'),
                    ),
                    'onchange' => "setClearDropdownKelurahan();",
                )
            ); ?>
            <?php echo $form->error($modPasien, 'kabupaten_id'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPasien, 'kecamatan_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList(
                $modPasien,
                'kecamatan_id',
                CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'),
                array(
                    'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($modPasien))),
                        'update' => "#" . CHtml::activeId($modPasien, 'kelurahan_id'),
                    ),
                    'onchange' => "",
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

    <?php echo $form->textFieldRow($modPasien, 'no_mobile_pasien', array('placeholder' => 'No. Handphone', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
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
<div class="col-sm-6">
    <?php echo  $form->hiddenField($modPasien, 'is_ambilfoto', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
    <?php echo  $form->hiddenField($modPasien, 'photopasien', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
    <div style="text-align: center;">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Ambil Foto', array('{icon}' => '<i class="icon-camera icon-white"></i>')),
            array(
                'class' => 'btn btn-danger', 'onclick' => "$('#dialog-addphoto').dialog('open'); putarWebcam();",
                'id' => 'btn-addphoto', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'rel' => 'tooltip', 'title' => 'Klik untuk Ambil Foto'
            )
        ) ?>
        <br>
        <?php
        $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasien->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg");
        ?>
        <img id="photo-preview" src="<?php echo $url_photopasien ?>" style="width: 160px;">
    </div>
    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        'id' => 'form-detailpasien',
        'content' => array(
            'content-detailpasien' => array(
                'header' => '<b>Detail Pasien</b>',
                'isi' => $this->renderPartial($this->path_view . '_formDetailPasien', array(
                    'form' => $form,
                    'model' => $model,
                    'modPasien' => $modPasien,
                    'nama_kapital' => $nama_kapital,
                ), true),
                'active' => false,
            ),
        ),
    )); ?>

</div>


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
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ambil', array('{icon}' => '<i class="icon-camera icon-white"></i>')), array('id' => 'btn_ambil_gambar', 'class' => 'btn-danger', 'type' => 'button', 'onclick' => 'ambilGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="icon-download-alt icon-white"></i>')), array('id' => 'btn_simpan_gambar', 'disabled' => true, 'class' => 'btn-primary', 'type' => 'button', 'onclick' => 'simpanGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('id' => 'btn_ulang_gambar', 'class' => 'btn-default', 'type' => 'button', 'onclick' => 'ulangGambar();', 'style' => 'font-size:10px; width:76px; height:24px;')); ?>
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

<?php //================= end dialog webcam ===================== 
?>