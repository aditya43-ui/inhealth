<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jpegcam/assets/webcam.js'); ?>
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
<?php
//if (!isset($_GET['sukses'])){ //RSPMC-1273
if (Yii::app()->user->getState('is_finger_pasien')) {
?>
    <div class="col-sm-12">
        <div id="loading"></div>
        <?php
        echo CHtml::tag('button', array(
            'id' => 'pendaftaranFP', 'onclick' => 'setPendaftaranFP();', 'class' => 'btn btn-danger'
        ), '<i class="entypo-check"></i> Pendaftaran Sidik Jari');
        echo CHtml::tag('button', array(
            'id' => 'verifikasiFP', 'onclick' => 'setVerifikasiFP();', 'class' => 'btn btn-primary'
        ), '<i class="entypo-check"></i> Verifikasi Sidik Jari');
        ?>
        <?php //echo CHtml::button("Batal",array('id'=>'batalVerifFP','onclick' => 'batalVerifikasiFP();', 'class'=>'btn btn-primary'));  
        ?>
        <div id="pesanVerifikasi">&nbsp;</div>
    </div>
<?php
}
//}
?>
<div class="col-sm-12" style="margin-bottom: 17px;">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-user"></i> Ibu Bayi
            </div>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">

                <div class="control-group">
                    <?php echo CHtml::label($modPasien->getAttributeLabel('no_rekam_medik') . " Ibu <span class=\"required\">*</span>", 'no_rekam_medik', array("id" => "lb_rm_lama", 'class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPasien,
                            'attribute' => 'no_rekam_medik',
                            'value' => $modPasien->no_rekam_medik,
                            'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompletePasienIbu') . '",
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
                                            setPasienBayi(ui.item.pasien_id, ui.item.pendaftaran_id, ui.item.kelahiranbayi_id);
                                            return false;
                                        }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPasien'),
                            'htmlOptions' => array(
                                'placeholder' => 'No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'No. RM untuk mencari pasien',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => "cekNoRM();",
                                'class' => 'numbers-only f_rm form-control delapan span3', 'maxlength' => $konSys->jmldigitrm, 'id' => 'no_rekam_medik_bayi'
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($modPasien,'nama_ibu',array('placeholder'=>'Nama Ibu Kandung Pasien','class'=>'required form-control hurufs-only span3 '.$nama_kapital, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50));  
                ?>

            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Nama Ibu", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPasien, 'nama_ibu', array(
                            'class' => 'nama_ibu required form-control hurufs-only span3 ' . $nama_kapital,
                            'onkeyup' => "return $(this).focusNextInputField(event);",
                            'readonly' => true,
                            'maxlength' => 50,
                        ));
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-user"></i> Data <b>Bayi</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php //echo $form->labelEx($modPasien,'no_identitas_pasien', array('class'=>'control-label refreshable')) 
                ?>
                <?php echo CHtml::label("No Identitas", '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'jenisidentitas', LookupM::getItemsUrutan('jenisidentitas'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 form-control jenisidentitas', 'onchange' => 'cekLength(this);'));
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
                            'minLength' => 4,
                            'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                        }',
                            'select' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.no_identitas_pasien);
                                            setPasienBayi(ui.item.pasien_id, ui.item.pendaftaran_id, ui.item.kelahiranbayi_id);
                                            return false;
                                        }',
                        ),
                        'htmlOptions' => array(
                            'placeholder' => 'No. Identitas Pasien',
                            'rel' => 'tooltip',
                            'title' => 'No. Identitas untuk masukan data / mencari pasien',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            // 'onblur'=>'setPasienLamaNomor()',
                            'class' => 'form-control span3 numbers-only nik',
                        ),
                    ));
                    ?>

                    <?php echo $form->error($modPasien, 'jenisidentitas'); ?>
                    <?php echo $form->error($modPasien, 'no_identitas_pasien'); ?>
                </div>
            </div>
            <div class="control-group" style="margin-bottom: 0;display: none;">
                <?php
                echo $form->dropDownList($modPasien, 'namadepan', LookupM::getItems('namadepan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'span1 form-control', 'style' => 'float:left; width:80px'));
                ?>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPasien, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span3')); ?>
                </div>
            </div>

            <?php echo $form->textFieldRow($modPasien, 'nama_bin', array('placeholder' => 'Alias / Nama Panggilan Pasien', 'class' => 'form-control hurufs-only span3 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($modPasien, 'tempat_lahir', array('placeholder' => 'Kota/Kabupaten Kelahiran', 'class' => 'form-control span3 all-caps hurufs-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 25)); ?>
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
                            'onkeyup' => "js:function(){setUmur(this.value);" . (!empty($modPasien->cekinap) ? 'setRawatGabung();' : '') . "}",
                            'onSelect' => 'js:function(){setUmur(this.value);' . (!empty($modPasien->cekinap) ? 'setRawatGabung();' : '') . '}',
                            'yearRange' => "-150:+0",
                        ),
                        'htmlOptions' => array(
                            'autocomplete' => 'off', 'style' => 'width:120px;', 'placeholder' => '00/00/0000', 'class' => 'form-control dtPicker2 datemask', 'onblur' => 'setUmur(this.value);' . (!empty($modPasien->cekinap) ? 'setRawatGabung();' : ''), 'onkeyup' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                </div>
            </div>

            <?php echo $form->textFieldRow($model, 'umur', array('placeholder' => '00 Thn 00 Bln 00 Hr', 'class' => 'form-control span3 umur', 'onblur' => 'setTglLahir(this);', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true)); ?>

            <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setNamaDepan()", 'class' => 'form-control required')); ?>
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
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'nama_ayah', array('class' => 'control-label')) ?>
                <div class="controls">
                <?php echo $form->textField($modPasien, 'nama_ayah', array('placeholder' => 'Nama Ayah Kandung Pasien', 'class' => 'form-control hurufs-only span3  ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                </div>
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'anakke', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPasien, 'anakke', array('placeholder' => '00', 'class' => 'form-control span1 integer', 'maxlength' => 2, 'onkeypress' => "return $(this).focusNextInputField(event)",)) . ' dari '; ?>
                    <?php echo $form->textField($modPasien, 'jumlah_bersaudara', array('placeholder' => '00', 'class' => 'form-control span1 integer', 'maxlength' => 2, 'onkeypress' => "return $(this).focusNextInputField(event)",)) . ' bersaudara'; ?>
                </div>
            </div>
            <?php // echo $form->dropDownListRow($modPasien,'statusperkawinan', LookupM::getItems('statusperkawinan'),array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'setNamaDepan()','class'=>'form-control span3'));  
            ?>
            <?php echo $form->hiddenField($modPasien, 'kelahiranbayi_id', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <!--<i class="glyphicon glyphicon-camera"></i> Foto Pasien
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>-->
                <a class="btn btn-default" onclick="$('#dialog-addphoto').dialog('open'); putarWebcam();" id="btn-addphoto" onkeyup="return $(this).focusNextInputField(event)">
                    <i class="glyphicon glyphicon-camera"></i> Ambil Foto
                </a>
            </div>
        </div>
        <div class="panel-body">
            <?php echo $form->hiddenField($modPasien, 'photopasien', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            <?php echo $form->hiddenField($modPasien, 'is_ambilfoto', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            <div style="text-align: center;">
                <?php
                $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasien->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg");
                ?>
                <img id="photo-preview" src="<?php echo $url_photopasien ?>" style="width: 160px;">
            </div>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-map-marker"></i> Alamat dan Kontak
            </div>
        </div>
        <div class="panel-body">
            <?php echo $form->textAreaRow($modPasien, 'alamat_pasien', array('placeholder' => 'Alamat Lengkap Pasien', 'rows' => 2, 'cols' => 60, 'class' => 'form-control autogrow span3 ' . $alamat_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
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
                <?php echo $form->labelEx($modPasien, 'propinsi_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($modPasien, 'propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                        'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
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
                <?php echo $form->labelEx($modPasien, 'kabupaten_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($modPasien, 'kabupaten_id', empty($modPasien->propinsi_id) ? array() : CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array(
                        'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
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
                <?php echo $form->labelEx($modPasien, 'kecamatan_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($modPasien, 'kecamatan_id', empty($modPasien->kabupaten_id) ? array() : CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), array(
                        'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
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
                        'empty' => '-- Pilih --', 'class' => 'form-control span3', 'onkeyup' => "return $(this).focusNextInputField(event)",
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
                    <?php echo $form->textField($modPasien, 'no_mobile_pasien', array('placeholder' => 'No. Handphone', 'class' => 'form-control span3 numbers-only required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 15)); ?>
                    <?php echo $form->error($modPasien, 'no_mobile_pasien'); ?>
                </div>
            </div>

            <?php //echo $form->textFieldRow($modPasien,'no_telepon_pasien',array('placeholder'=>'No. Telepon','class'=>'form-control span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>15)); 
            ?>
            <?php /*
              <div class="control-group">
              <?php echo $form->labelEx($modPasien,'pekerjaan_id', array('class'=>'control-label refreshable')) ?>
              <div class="controls">
              <?php echo $form->dropDownList($modPasien,'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'),array('style' => 'width:170px;','empty'=>'-- Pilih --', 'class'=>'form-control span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", "onchange"=>"cekStatusPekerjaan(this)")); ?>
              </div>
              </div>
             * 
             */ ?>
            <?php echo $form->dropDownListRow($modPasien, 'warga_negara', LookupM::getItems('warganegara'), array('style' => 'width:170px;', 'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'agama', array('class' => 'control-label refreshable')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'agama', LookupM::getItems('agama'), array('style' => 'width:170px;', 'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien Ibu',
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
//$modDataPasien->ispasienluar = FALSE;
if (isset($_GET['PPPasienM'])) {
    $modDataPasien->attributes = $_GET['PPPasienM'];
    //        $modDataPasien->tanggal_lahir =  isset($_GET['PPPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['PPPasienM']['tanggal_lahir']) : null;
    $modDataPasien->cari_kelurahan_nama = $_GET['PPPasienM']['cari_kelurahan_nama'];
    $modDataPasien->cari_kecamatan_nama = $_GET['PPPasienM']['cari_kecamatan_nama'];
    $modDataPasien->carabayar_id = $_GET['PPPasienM']['carabayar_id'];
    $modDataPasien->no_pendaftaran = $_GET['PPPasienM']['no_pendaftaran'];
    if (isset($_GET['PPPasienM']['nomorindukpegawai'])) {
        $modDataPasien->nomorindukpegawai = $_GET['PPPasienM']['nomorindukpegawai'];
        $modDataPasien->namabayi = $_GET['PPPasienM']['namabayi'];
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
    'dataProvider' => $modDataPasien->searchDialogIbu(),
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
                                            setPasienBayi(\"$data->pasien_id\", \"$data->pendaftaran_id\", \"$data->kelahiranbayi_id\");
                                            $(\"#dialogPasien\").dialog(\"close\");
                                        "))',
        ),
        array(
            'header' => 'Tgl. Bayi Lahir',
            'type' => 'raw',
            'value' => function ($data) {
                return MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
            }
        ),
        array(
            'header' => 'No. Pendaftaran',
            'name' => 'no_pendaftaran',
        ),
        'no_rekam_medik',
        array(
            'header' => 'Nama Bayi',
            'name' => 'namabayi',
        ),
        array(
            'header' => 'Nama Ibu',
            'name' => 'nama_pasien',
        ),
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modDataPasien, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
            'value' => '$data->jeniskelamin'
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
        // 'norm_lama',
        array(
            'name' => 'statusrekammedis',
            'type' => 'raw',
            'filter' => LookupM::getItems('statusrekammedis'),
            'value' => '$data->statusrekammedis',
        ),
        array(
            'header' => 'Jenis Penjamin',
            'name' => 'carabayar_id',
            'type' => 'raw',
            'value' => '$data->carabayar_nama',
            'filter' => CHtml::activeDropDownList($modDataPasien, 'carabayar_id', CHtml::listData(
                CarabayarM::model()->findAll('carabayar_aktif = true order by carabayar_id'),
                'carabayar_id',
                'carabayar_nama'
            ), array('empty' => '-- Pilih --'))
        )
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
    //        $modDataPasien->tanggal_lahir =  isset($_GET['PPPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['PPPasienM']['tanggal_lahir']) : null;
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

<script>
      function printLabelGelang()
    {
        var gelang = $('#gelangPasien').val();
        if(gelang == '1'){
            window.open('<?php echo $this->createUrl('printLabelGelang', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=793,height=1122');
        }
        else{
            window.open('<?php echo $this->createUrl('printLabelGelang', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=793,height=1122');
        }
        
    }
    </script>