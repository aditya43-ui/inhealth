<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/protected/extensions/jpegcam/assets/webcam.js'); ?>
<?php
$nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps" : "");
$alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps" : "");

$konSys = KonfigsystemK::model()->find();
?>
<style>
    .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
    }
</style>
<div class="col-sm-6">
    <?php /*
      <div class="control-group">
      <?php echo CHtml::label("Dari Instalasi", 'instalasi_id', array('class'=>'control-label')); ?>
      <div class="controls">
      <?php echo CHtml::dropDownList('instalasi_id',Params::INSTALASI_ID_RJ,CHtml::listData(PPPasienAdmisiT::model()->getInstalasis(),'instalasi_id','instalasi_nama'),array('onchange'=>'setJudulDialogPasien(this.value);setPasienRJRDReset();refreshDialogKunjungan(); $(".f_rm").focus();','class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
      </div>
      </div>
     * 
     */ ?>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-user"></i> Data <b>Pribadi</b>
                <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group hide">
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
                            'class' => 'numbers-only span4'
                        ),
                    ));
                    ?>
                    <?php // echo $form->error($modPasien,'no_rekam_medik'); 
                    ?>
                    <?php // echo $form->hiddenField($modPasien,'pasien_id',array('readonly'=>true,'class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); 
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Cari No. Pendaftaran <span class='required'>*</span>", 'no_pendaftaran', array('class' => 'control-label required')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'cari_no_pendaftaran',
                        'value' => $model->no_pendaftaran,
                        'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompletePasienRJRD') . '",
                                                   dataType: "json",
                                                   data: {
                                                        instalasi_id: $("#instalasi_id").val(),
                                                        no_pendaftaran: request.term,
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
                                            //setPasienRJRD(ui.item.pendaftaran_id);
                                            return false;
                                        }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogKunjungan'),
                        'htmlOptions' => array(
                            'placeholder' => 'No. Pendaftaran', 'rel' => 'tooltip', 'title' => 'No. pendaftaran untuk mencari pasien',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'class' => 'span4',
                            'onblur' => "if($(this).val()=='') setPasienRJRDReset(); else setPasienRJRD('',this.value,'','')",
                        ),
                    ));
                    ?>
                    <?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Cari " . $modPasien->getAttributeLabel('no_rekam_medik') . " <span class='required'>*</span>", 'no_rekam_medik', array('class' => 'control-label required')) ?>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($modPasien, 'no_rekam_medik', ['id' => 'no_rekam_medik_hidden']);

                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'cari_no_rekam_medik',
                        'value' => $modPasien->no_rekam_medik,
                        'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompletePasienRJRD') . '",
                                                   dataType: "json",
                                                   data: {
                                                       instalasi_id: $("#instalasi_id").val(),
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
                                            $(this).val( ui.item.no_rekam_medik);
                                            $("#no_rekam_medik_hidden").val(ui.item.no_rekam_medik);
                                            //setPasienRJRD(ui.item.pendaftaran_id);
                                            return false;
                                        }',
                        ),
                        'htmlOptions' => array(
                            'placeholder' => 'No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'No. RM untuk mencari pasien',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => "if($(this).val()=='') setPasienRJRDReset(); else setPasienRJRD('','','',this.value)",
                            'class' => 'span4 numbers-only f_rm', 'maxlength' => $konSys->jmldigitrm,
                        ),
                    ));
                    ?>
                    <?php echo $form->hiddenField($modPasien, 'pasien_id', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                </div>
            </div>
            <?php /*
              <div class="control-group">
              <?php echo $form->labelEx($modPasien,'no_jamkespa', array('class'=>'control-label')) ?>
              <div class="controls">
              <?php echo $form->textField($modPasien, 'no_jamkespa', array('class'=>'span4 numbers-only')); ?>
              <?php echo $form->error($modPasien,'no_jamkespa'); ?>
              </div>
              </div>
             */ ?>
            <div class="control-group">
                <?php echo CHtml::label($modPasien->getAttributeLabel('no_identitas_pasien') . " <span class='required'>*</span>", 'no_identitas_pasien', array('class' => 'control-label required')) ?>

                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'jenisidentitas', LookupM::getItemsUrutan('jenisidentitas'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4 jenisidentitas', 'style' => 'float:left; width:80px', 'onchange' => 'cekLength(this);'));
                    ?>
                    <br><br>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $modPasien,
                        'attribute' => 'no_identitas_pasien',
                        'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompletePasienRJRD') . '",
                                                   dataType: "json",
                                                   data: {
                                                       instalasi_id: $("#instalasi_id").val(),
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
                                            setPasienRJRD(ui.item.pendaftaran_id);
                                            return false;
                                        }',
                        ),
                        'htmlOptions' => array('placeholder' => 'No. Identitas Pasien', 'rel' => 'tooltip', 'title' => 'No. Identitas untuk masukan data / mencari pasien', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4 angkahuruf-only all-caps nik'),
                    ));
                    ?>

                    <?php echo $form->error($modPasien, 'jenisidentitas'); ?>
                    <?php echo $form->error($modPasien, 'no_identitas_pasien'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    // echo $form->dropDownList($modPasien,'namadepan', LookupM::getItems('namadepan'),  
                    //      array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span4','style'=>'float:left; width:80px')); 
                    ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $modPasien,
                        'attribute' => 'nama_pasien',
                        'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompletePasienRJRD') . '",
                                                   dataType: "json",
                                                   data: {
                                                       instalasi_id: $("#instalasi_id").val(),
                                                       nama_pasien: request.term,
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
                                            setPasienRJRD(ui.item.pendaftaran_id);
                                            return false;
                                        }',
                        ),
                        'htmlOptions' => array('placeholder' => 'Nama Lengkap Pasien', 'rel' => 'tooltip', 'title' => 'Ketik Nama untuk masukan data / mencari pasien', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'hurufs-only span4 ' . $nama_kapital),
                    ));
                    ?>
                    <?php echo $form->error($modPasien, 'namadepan'); ?>
                    <?php echo $form->error($modPasien, 'nama_pasien'); ?>
                    <p style="color:red;font-size:11px;">Keterangan : Sesuai Identitas Diri (tanpa tanda baca dan gelar)</p>
                </div>
            </div>

            <?php echo $form->textFieldRow($modPasien, 'nama_bin', array('placeholder' => 'Alias / Nama Panggilan Pasien', 'class' => 'hurufs-only span4 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($modPasien, 'tempat_lahir', array('placeholder' => 'Kota/Kabupaten Kelahiran', 'class' => 'hurufs-only span4 all-caps', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 25)); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'tanggal_lahir', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
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
                            'placeholder' => '00/00/0000', 'class' => 'span4 dtPicker2 datemask', 'onblur' => 'setUmur(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                </div>
            </div>

            <?php echo $form->textFieldRow($model, 'umur', array('readonly' => true, 'placeholder' => '00 Thn 00 Bln 00 Hr', 'class' => 'span4 umur', 'onblur' => 'setTglLahir(this);', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>

            <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setNamaDepan()", 'class' => '')); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'golongandarah', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'golongandarah', LookupM::getItems('golongandarah'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span2'));
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
            <?php echo $form->dropDownListRow($modPasien, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaDepan()', 'class' => 'span4')); ?>
            <?php echo $form->textFieldRow($modPasien, 'nama_ayah', array('placeholder' => 'Nama Ayah Kandung Pasien', 'class' => 'hurufs-only span4 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <div class="control-group">
                <?php echo CHtml::label("Nama Ibu <span class='required'>*</span>", 'no_rekam_medik', array('class' => 'control-label required')) ?>
                <div class="controls">
                <?php echo $form->textField($modPasien, 'nama_ibu', array('placeholder' => 'Nama Ibu Kandung Pasien', 'class' => 'required nama_ibu hurufs-only span4 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>

                </div>
            </div>    
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'anakke', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPasien, 'anakke', array(
                        'class' => 'span1 integer',
                        'maxlength' => 2,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => '00',
                    )) . ' dari '; ?>
                    <?php echo $form->textField($modPasien, 'jumlah_bersaudara', array(
                        'class' => 'span1 integer',
                        'maxlength' => 2,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => '00',
                    )) . ' bersaudara'; ?>
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
                    <i class="glyphicon glyphicon-camera"></i> Ambil Foto
                </a>
            </div>
        </div>
        <div class="panel-body">
            <?php echo $form->hiddenField($modPasien, 'is_ambilfoto', array('readonly' => true, 'class' => 'span4 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            <?php echo $form->hiddenField($modPasien, 'photopasien', array('readonly' => true, 'class' => 'span4 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            <div style="text-align: center;">
                <?php
                $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasien->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg");
                ?>
                <img id="photo-preview" src="<?php echo $url_photopasien ?>" style="width: 160px;">
            </div>
            <?php /* $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
              'id'=>'form-detailpasien',
              'content'=>array(
              'content-detailpasien'=>array(
              'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan detail pasien')).'<b>Detail Pasien</b>',
              'isi'=>$this->renderPartial($this->path_view_rj.'_formDetailPasien',array(
              'form'=>$form,
              'model'=>$model,
              'modPasien' => $modPasien,
              'nama_kapital' => $nama_kapital,
              ),true),
              'active'=>false,
              ),
              ),
              ));
             * ?>
             */ ?>

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
            <?php echo $form->textAreaRow($modPasien, 'alamat_pasien', array('placeholder' => 'Alamat Lengkap Pasien', 'rows' => 2, 'cols' => 50, 'class' => 'span4 ' . $alamat_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
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
                    <?php
                    echo $form->dropDownList($modPasien, 'propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                        'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($modPasien))),
                            'update' => "#" . CHtml::activeId($modPasien, 'kabupaten_id'),
                        ),
                        'onchange' => "setClearDropdownKelurahan();setClearDropdownKecamatan();",
                    ));
                    ?>
                    <?php echo $form->error($modPasien, 'propinsi_id'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'kabupaten_id', array('class' => 'control-label refreshableLocation')) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($modPasien, 'kabupaten_id', CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array(
                        'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($modPasien))),
                            'update' => "#" . CHtml::activeId($modPasien, 'kecamatan_id'),
                        ),
                        'onchange' => "setClearDropdownKelurahan();",
                    ));
                    ?>
                    <?php echo $form->error($modPasien, 'kabupaten_id'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'kecamatan_id', array('class' => 'control-label refreshableLocation')) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($modPasien, 'kecamatan_id', array(), array(
                        'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($modPasien))),
                            'update' => "#" . CHtml::activeId($modPasien, 'kelurahan_id'),
                        ),
                        'onchange' => "",
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'kelurahan_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php // $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id))?$modPasien->kelurahan_id:Yii::app()->user->getState('kelurahan_id');
                    ?>
                    <?php echo $form->dropDownList($modPasien, 'kelurahan_id', array(), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                    ?>
                    <?php echo $form->error($modPasien, 'kelurahan_id'); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($modPasien, 'alamatemail', array('placeholder' => 'contoh: info@.com', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php //echo $form->textFieldRow($modPasien,'no_telepon_pasien',array('placeholder'=>'No. Telepon','class'=>'span4 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>15));   
            ?>
            <div class="control-group">
                <?php echo CHtml::label("No. Telepon", '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPasien, 'no_telepon_pasien', array('placeholder' => 'No. Telepon', 'class' => 'form-control span4 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                    <?php echo $form->error($modPasien, 'no_telepon_pasien'); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("No. Handphone <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPasien, 'no_mobile_pasien', array('placeholder' => 'No. Handphone', 'class' => 'span3 numbers-only required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 15)); ?>
                    <?php //echo CHtml::checkBox('is_whatsapp', false, array('rel'=>'tooltip', 'title'=>'Klik untuk mengirim pesan Whatsapp')); 
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'pekerjaan_id', array('class' => 'control-label refreshable')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'cekStatusPekerjaan(this)')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'warga_negara', array('class' => 'control-label refreshable')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'warga_negara', LookupM::getItems('warganegara'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'agama', array('class' => 'control-label refreshable')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'agama', LookupM::getItems('agama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
            <?php /*
              <div class="control-group">
              <?php echo $form->labelEx($modPasien,'suku_id', array('class'=>'control-label refreshable')) ?>
              <div class="controls">
              <?php echo $form->dropDownList($modPasien,'suku_id', CHtml::listData($modPasien->getSukuItems(), 'suku_id', 'suku_nama'),array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
              </div>
              </div>
             * 
             */ ?>
            <div class="control-group">
                <?php echo CHtml::label("Pendidikan <span class='required'>*</span>", '', array('class' => 'control-label refreshable')) ?>
                <?php //echo $form->labelEx($modPasien, 'pendidikan_id', array('class' => 'control-label refreshable')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'pendidikan_id', CHtml::listData($modPasien->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKunjungan',
    'options' => array(
        'title' => 'Pencarian No. Pendaftaran Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1100,
        'height' => 500,
        'resizable' => false,
    ),
));
$kec_id = null;
$modDialogKunjungan = new PPPasientindaklanjutkeriV('searchDialogUntukPendaftaranRI');
$modDialogKunjungan->unsetAttributes();
$modDialogKunjungan->statusperiksa = Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO;
$format = new MyFormatter();
// $modDialogKunjungan->instalasi_id = Params::INSTALASI_ID_RJ;
if (isset($_GET['PPPasientindaklanjutkeriV'])) {
    $modDialogKunjungan->attributes = $_GET['PPPasientindaklanjutkeriV'];
    //$modDialogKunjungan->tanggal_lahir =  isset($_GET['PPPasientindaklanjutkeriV']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['PPPasientindaklanjutkeriV']['tanggal_lahir']) : null;
    $modDialogKunjungan->instalasi_id = $_GET['PPPasientindaklanjutkeriV']['instalasi_id'];

    if (isset($_GET['PPPasientindaklanjutkeriV']['kecamatan_id']))
        $modDialogKunjungan->kecamatan_id = $_GET['PPPasientindaklanjutkeriV']['kecamatan_id'];
    if (isset($_GET['PPPasientindaklanjutkeriV']['kelurahan_id']))
        $modDialogKunjungan->kelurahan_id = $_GET['PPPasientindaklanjutkeriV']['kelurahan_id'];

    /*
      $kec = KecamatanM::model()->findByAttributes(array(
      'kecamatan_id' => $modDialogKunjungan->kecamatan_id
      ));

      if (empty($kec)) $kec_id = null;
      else $kec_id = $kec->kecamatan_id;
     * 
     */
}

$cr = new CDbCriteria();
if (!empty($modDialogKunjungan->instalasi_id))
    $cr->compare('instalasi_id', $modDialogKunjungan->instalasi_id);
else
    $cr->compare('instalasi_id', array(2, 3));
$cr->addCondition('ruangan_aktif = true');
$cr->order = 'ruangan_nama';
$arr = Params::statusPeriksa();
unset($arr['SUDAH PULANG']);

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $modDialogKunjungan->searchDialogUntukPendaftaranRI(),
    'filter' => $modDialogKunjungan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            setPasienRJRD($data->pendaftaran_id, \"\", \"\", \"\", $data->instalasi_id);
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "))',
        ),
        'no_pendaftaran',
        array(
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
            'filter' => false,
        ),
        array(
            'name' => 'no_rekam_medik',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik',
        ),
        array(
            'name' => 'nama_pasien',
            'value' => '$data->namadepan.$data->nama_pasien',
        ),
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => CHtml::dropDownList('PPPasientindaklanjutkeriV[jeniskelamin]', $modDialogKunjungan->jeniskelamin, LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
        ), /*
          array(
          'name'=>'tanggal_lahir',
          'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
          'filter'=>$this->widget('MyDateTimePicker',array(
          'model'=>$modDialogKunjungan,
          'attribute'=>'tanggal_lahir',
          'mode'=>'date',
          'options'=> array(
          'dateFormat'=>Params::DATE_FORMAT,
          ),
          'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','id'=>'tanggal_lahir','placeholder'=>'23 Jan 1993'),
          ),true
          ),
          'htmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
          ), */
        array(
            'name' => 'instalasi_id',
            'value' => '$data->instalasi_nama',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'instalasi_id', array(2 => 'Rawat Jalan', 3 => 'Rawat Darurat'), array('empty' => '-- Pilih --')), //dipilih dari instalasi form pasien
            //'filter'=>CHtml::activeHiddenField($modDialogKunjungan,'instalasi_id'),
        ),
        array(
            'name' => 'ruangan_id',
            'header' => 'Ruangan',
            'type' => 'raw',
            'value' => '$data->ruangan_nama',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll($cr), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')),
        ),
        //                    'kabupaten_nama',
        /*
          array(
          'header'=>'Nama Kecamatan',
          'name'=>'kecamatan_id',
          'type'=>'raw',
          'value'=>'$data->kecamatan_nama',
          'filter'=>CHtml::activeDropDownList($modDialogKunjungan, 'kecamatan_id',
          CHtml::listData(KecamatanM::model()->findAll(array(
          'condition'=>'kecamatan_aktif = true',
          'order'=>'kecamatan_nama asc',
          )), 'kecamatan_id', 'kecamatan_nama'), array(
          'empty'=>'-- Pilih --',
          )),
          ),
          array(
          'header'=>'Nama Kelurahan',
          'name'=>'kelurahan_id',
          'type'=>'raw',
          'value'=>'$data->kelurahan_nama',
          'filter'=>CHtml::activeDropDownList($modDialogKunjungan, 'kelurahan_id',
          CHtml::listData(KelurahanM::model()->findAllByAttributes(array(
          'kecamatan_id'=>empty($modDialogKunjungan->kecamatan_id)?null:$modDialogKunjungan->kecamatan_id,
          ), array(
          'condition'=>'kelurahan_aktif = true',
          'order'=>'kelurahan_nama asc',
          )), 'kelurahan_id', 'kelurahan_nama'), array(
          'empty'=>'-- Pilih --',
          )),
          ),
         * 
         */
        array(
            'header' => 'Jenis Penjamin',
            'name' => 'carabayar_id',
            'type' => 'raw',
            'value' => '$data->carabayar_nama',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll(array(
                'condition' => 'carabayar_aktif = true',
                'order' => 'carabayar_nama asc',
            )), 'carabayar_id', 'carabayar_nama'), array(
                'empty' => '-- Pilih --',
            )),
        ),
        array(
            'header' => 'Penjamin',
            'name' => 'penjamin_id',
            'type' => 'raw',
            'value' => '$data->penjamin_nama',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'penjamin_id', CHtml::listData(PenjaminpasienM::model()->findAllByAttributes(array(
                'carabayar_id' => empty($modDialogKunjungan->carabayar_id) ? null : $modDialogKunjungan->carabayar_id,
            ), array(
                'condition' => 'penjamin_aktif = true',
                'order' => 'penjamin_nama asc',
            )), 'penjamin_id', 'penjamin_nama'), array(
                'empty' => '-- Pilih --',
            )),
        ),
        //'carabayar_nama',
        //'penjamin_nama',
        /*
      array(
      'name'=>'statusperiksa',
      'filter'=>  CHtml::activeDropDownList($modDialogKunjungan, 'statusperiksa', $arr, array('empty'=>'-- Pilih --')),
      )
     * 
     */
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
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
////======= end pendaftaran dialog =============
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasienBadak',
    'options' => array(
        'title' => 'Pencarian NIP Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDataPasien = new PPPasienM('searchDialog');
$modDataPasien->unsetAttributes();
$format = new MyFormatter();
$modDataPasien->ispasienluar = FALSE;
if (isset($_GET['PPPasienM'])) {
    $modDataPasien->attributes = $_GET['PPPasienM'];
    //        $modDataPasien->tanggal_lahir =  isset($_GET['PPPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['PPPasienM']['tanggal_lahir']) : null;
    $modDataPasien->cari_kelurahan_nama = $_GET['PPPasienM']['cari_kelurahan_nama'];
    $modDataPasien->cari_kecamatan_nama = $_GET['PPPasienM']['cari_kecamatan_nama'];
    $modDataPasien->nomorindukpegawai = $_GET['PPPasienM']['nomorindukpegawai'];
    $modDataPasien->nama_bin = $_GET['PPPasienM']['nama_bin'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasienbadak-m-grid',
    'dataProvider' => $modDataPasien->searchDialogBadak(),
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
            'value' => '$data->pegawai->nomorindukpegawai',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'nama_bin',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => CHtml::dropDownList('PPPasienM[jeniskelamin]', $modDataPasien->jeniskelamin, LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
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
            'htmlOptions' => array('width' => '80', 'style' => 'text-align:center'),
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
        'norm_lama',
        array(
            'name' => 'statusrekammedis',
            'type' => 'raw',
            'filter' => CHtml::dropDownList('PPPasienM[statusrekammedis]', $modDataPasien->statusrekammedis, LookupM::getItems('statusrekammedis'), array('empty' => '-- Pilih --')),
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

<?php //================= end dialog webcam ===================== 
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