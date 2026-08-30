<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jpegcam/assets/webcam.js'); ?>
<?php
$nama_kapital = "all-caps"; //((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps" : "");
$alamat_kapital = "all-caps"; //((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps" : "");

$konSys = KonfigsystemK::model()->find();

$drop_lookjeniskelamin = LookupM::getItems('jeniskelamin');
//if ($this->id == "pendaftaranPersalinan") {
//    unset($drop_lookjeniskelamin[Params::JENIS_KELAMIN_LAKI_LAKI]);
//}
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



<div class="col-sm-8">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-user"></i> Data <b>Pribadi</b>
                <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
            </div>
            <div class="pull-right" style="padding-right: 5px; padding-top: 5px;">
                <!--<i class="glyphicon glyphicon-camera"></i> Foto Pasien<span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>-->
                <a class="btn btn-default" onclick="$('#dialog-addphoto').dialog('open'); putarWebcam();" id="btn-addphoto" onkeyup="return $(this).focusNextInputField(event)">
                    <i class="glyphicon glyphicon-camera"></i> Ambil Foto
                </a>
            </div>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <div class="col-sm-8">
                    <div class="input_lama" style="display: none">
                        <div class="control-group">
                            <?php echo $form->label($modPasien, 'no_rekam_medik', array(
                                'class'=>'control-label'
                            )); ?>
                            <div class="controls">
                                <?php echo $form->textField($modPasien, 'no_rekam_medik', array(
                                    'class'=>'span3 input_no_rekam_medik',
                                    'readonly'=>true,
                                )); ?>
                            </div>
                        </div>
                        <?php echo $form->hiddenField($modPasien, 'pasien_id', array(
                            'class'=>'input_pasien_id',
                        )); ?>
                    </div>
                    <div class="control-group">
                        <?php //echo $form->labelEx($modPasien,'no_identitas_pasien', array('class'=>'control-label refreshable'))
                        ?>
                        <?php echo CHtml::label('No Identitas <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPasien, 'jenisidentitas', LookupM::getItemsUrutan('jenisidentitas'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 form-control jenisidentitas', 'style' => 'float:left; width:150px', 'onchange' => 'cekLength(this);'));
                            ?>
                            <br>
                            <?php echo $form->textField($modPasien, 'no_identitas_pasien', array(
                                'placeholder' => 'No. Identitas Pasien',
                                'rel' => 'tooltip',
                                'title' => 'No. Identitas untuk masukan data / mencari pasien',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur'=>'setInputBerdasarkanNoKTP()',
                                'class' => 'form-control span3 angkahuruf-only all-caps nik',
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
                        <?php echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
                        <div class="controls">
        
                            <?php
                            echo $form->textField($modPasien, 'nama_pasien', array(
                                'placeholder' => 'Nama Lengkap Pasien',
                                'rel' => 'tooltip',
                                'title' => 'Ketik Nama untuk masukan data / mencari pasien',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'class' => 'nama_pasien form-control hurufkomatitik-only span3 ' . $nama_kapital,
                            ));
                            ?>
                            <?php //echo $form->error($modPasien,'namadepan');
                            ?>
                            <?php //echo $form->error($modPasien,'nama_pasien');
                            ?>
                            <p style="color:red;font-size:11px;">Keterangan : Sesuai Identitas Diri (tanpa tanda baca dan gelar)</p>
                        </div>
                    </div>
        
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
                                    'autocomplete' => 'off', 'style' => '', 'placeholder' => '00/00/0000', 'class' => 'form-control dtPicker2 datemask span3', 'onblur' => 'setUmur(this.value);' . (!empty($modPasien->cekinap) ? 'setRawatGabung();' : ''), 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                        </div>
                    </div>
        
                    <?php echo $form->textFieldRow($model, 'umur', array('placeholder' => '00 Thn 00 Bln 00 Hr', 'class' => 'form-control span3 umur', 'onblur' => 'setTglLahir(this);', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true)); ?>
        
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
                    <?php echo $form->dropDownListRow($modPasien, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaDepan()', 'class' => 'form-control', 'style' => 'width:170px')); ?>
                    <?php echo $form->textFieldRow($modPasien, 'nama_ayah', array('placeholder' => 'Nama Ayah Kandung Pasien', 'class' => 'form-control hurufs-only span3 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <div class="control-group">
                        <?php echo CHtml::label("Nama Ibu <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPasien, 'nama_ibu', array(
                                'placeholder' => 'Nama Ibu Kandung Pasien',
                                'class' => 'nama_ibu required form-control hurufs-only span3 ' . $nama_kapital,
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
                            <?php echo $form->textField($modPasien, 'anakke', array('class' => 'form-control span1 integer', 'placeholder' => '00', 'maxlength' => 2, 'onkeypress' => "return $(this).focusNextInputField(event)",)) . ' dari '; ?>
                            <?php echo $form->textField($modPasien, 'jumlah_bersaudara', array('class' => 'form-control span1 integer', 'placeholder' => '00', 'maxlength' => 2, 'onkeypress' => "return $(this).focusNextInputField(event)",)) . ' bersaudara'; ?>
                        </div>
                    </div>

                </div>
                <div class="col-sm-4">
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
        </div>
    </div>
</div>

<div class="col-sm-4">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-map-marker"></i> Alamat dan Kontak
                <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
            </div>
        </div>
        <div class="panel-body">
            <?php echo $form->textAreaRow($modPasien, 'alamat_pasien', array('placeholder' => 'Alamat Lengkap Pasien', 'rows' => 2, 'cols' => 60, 'class' => 'form-control autogrow span3 all-caps', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style'=>'height: 100px;')); ?>
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
                <?php echo $form->labelEx($modPasien, 'kabupaten_id', array('class' => 'control-label refreshableLocation')) ?>
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
                <?php echo $form->labelEx($modPasien, 'kecamatan_id', array('class' => 'control-label refreshableLocation')) ?>
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
                <?php echo CHtml::label("No. Handphone Pasien <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPasien, 'no_mobile_pasien', array('placeholder' => 'No. Handphone', 'class' => 'form-control span3 numbers-only required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 15)); ?>
                    <?php //echo CHtml::checkBox('is_whatsapp', true, array('rel'=>'tooltip', 'title'=>'Klik untuk mengirim pesan Whatsapp')); ?>
                    <?php echo $form->error($modPasien, 'no_mobile_pasien'); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'pekerjaan_id', array('class' => 'control-label refreshable')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'), array('style' => 'width:170px;', 'empty' => '-- Pilih --', 'class' => 'form-control span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "cekStatusPekerjaan(this)")); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($modPasien, 'warga_negara', LookupM::getItems('warganegara'), array('style' => 'width:170px;', 'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'agama', array('class' => 'control-label refreshable')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'agama', LookupM::getItems('agama'), array('style' => 'width:170px;', 'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'pendidikan_id', array('class' => 'control-label refreshable')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'pendidikan_id', CHtml::listData($modPasien->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'), array('style' => 'width:170px;', 'empty' => '-- Pilih --', 'class' => 'form-control span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>

<!--<br>-->

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

                    setUmur($("#PPPasienM_tanggal_lahir").val());
                }
            } else {
                myAlert("Data pegawai Tidak ditemukan");
                $("#cari_nomor_pasien").addClass("animation-loading").val("");
            }
            $("#cari_nomor_pasien").removeClass("animation-loading");
        }, 'json');
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

        setPlaceHolderNomor();
    });
</script>
<script>
    function showDateTime() {
        $("#PPPasienM_tanggal_lahir").datepicker();
    }
    
    $(document).ready(function() {
        <?php if ($this->id == "pendaftaranPersalinan") { ?>
        $("#PPPasienM_jeniskelamin_0").parents(".radio").remove();
        <?php } ?>
    });
    
    /**
     *
     * @param {type} obj
     * @returns {change attribute maxlength}
     */
    function cekLength(obj){
        var cek = $(obj).val();
    
        if (cek == '<?php echo Params::JENIS_IDENTITAS_KTP ?>'){
            $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").attr('maxlength',16);
        }else{
            $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").attr('maxlength',30);
        }
    }

    function setInputBerdasarkanNoKTP() {
        return false;

            /*
        var jenis = $('#<?php echo CHtml::activeId($modPasien,'jenisidentitas'); ?>').val();
        var no_ktp = $('#<?php echo CHtml::activeId($modPasien,'no_identitas_pasien'); ?>').val();
        
        return false;
        if (otoval != 1 || jenis != 'KTP') {
            return false;
        }
        
        //$('#<?php echo CHtml::activeId($modPasien,'no_identitas_pasien'); ?>').addClass("animation-loading");
        
        $.post('<?php echo $this->createUrl('inputDariNoKTP'); ?>', {
            no_ktp: no_ktp
        }, function(data) {
            $('#<?php echo CHtml::activeId($modPasien,'tanggal_lahir'); ?>').val(data.tanggal_lahir_format);
            setJenisKelaminPasien(data.jeniskelamin);
            setDaerahPasien(data.propinsi_id, data.kabupaten_id, data.kecamatan_id, null);
            setUmur(data.tanggal_lahir);
            //$('#<?php echo CHtml::activeId($modPasien,'no_identitas_pasien'); ?>').removeClass("animation-loading");
        }, 'json');
        */
        
    }

    /**
     * set input radio button jenis kelamin
     * @param {type} jk
     * @returns {undefined}
     */
    function setJenisKelaminPasien(jk){
        $('input[name$="[jeniskelamin]"][type="radio"]').each(function(){
            if($(this).val() == $.trim(jk)){
                $(this).attr('checked',true);
            }
        });
    }

    /**
     * set propinsi, kabupaten, kecamatan, dan kelurahan
     * @param {type} propinsi_id
     * @param {type} kabupaten_id
     * @param {type} kecamatan_id
     * @param {type} kalurahan_id
     * @returns {undefined}
     */
    function setDaerahPasien(propinsi_id,kabupaten_id,kecamatan_id,kelurahan_id){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetDropdownDaerahPasien'); ?>',
            data: { propinsi_id: propinsi_id, kabupaten_id: kabupaten_id, kecamatan_id: kecamatan_id, kelurahan_id: kelurahan_id },
            dataType: "json",
            success:function(data){
                $("#<?php echo CHtml::activeId($modPasien,"propinsi_id");?>").html(data.listPropinsi);
                $("#<?php echo CHtml::activeId($modPasien,"kabupaten_id");?>").html(data.listKabupaten);
                $("#<?php echo CHtml::activeId($modPasien,"kecamatan_id");?>").html(data.listKecamatan);
                $("#<?php echo CHtml::activeId($modPasien,"kelurahan_id");?>").html(data.listKelurahan);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }

    /**
     * set nilai umur dari tanggal_lahir
     * @param {type} tanggal_lahir
     * @returns {undefined} */
    function setUmur(tanggal_lahir)
    {
        $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetUmur'); ?>',
        data: {tanggal_lahir : tanggal_lahir},//
        dataType: "json",
        success:function(data){
            $("#<?php echo CHtml::activeId($model,"umur");?>").val(data.umur);
            setNamaDepan();
        },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }


    /**
     * set nama depan berdasarkan umur, jenis kelamin dan status perkawinan
     *
     * @returns {undefined} */
    function setNamaDepan(){

        var statusperkawinan = $('#PPPasienM_statusperkawinan').val();
        var namadepan = $('#PPPasienM_namadepan');
        var umur = $("#<?php echo CHtml::activeId($model,'umur');?>").val().substr(0,2);

        if(isNaN(umur)){
            umur = 0;
        }
        umur = parseInt(umur);



        if(umur <= 5){
            var namadepan = $('#PPPasienM_namadepan').val('By. ');
            if(statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR"){
                $('#PPPasienM_statusperkawinan').val('');
                alert('Maaf status perkawinan belum cukup usia');
            }
        }else if(umur <= 14){ //
            var namadepan = $('#PPPasienM_namadepan').val('An. ');
            if(statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR"){
                $('#PPPasienM_statusperkawinan').val('');
                alert('Maaf status perkawinan belum cukup usia');
            }
        }else{;
            if($('#PPPasienM_jeniskelamin_0').is(':checked')){
                if(statusperkawinan !== 'JANDA'){
                    var namadepan = $('#PPPasienM_namadepan').val('Tn. ');
                }else{
                    alert('Silakan pilih status pernikahan yang sesuai!');
                    $('#PPPasienM_statusperkawinan').val('KAWIN');
                    var namadepan = $('#PPPasienM_namadepan').val('Tn. ')
                }

            }

            if($('#PPPasienM_jeniskelamin_1').is(':checked')) {
                $('#PPPasienM_namadepan').val('Nn. ');
                if(statusperkawinan !== 'DUDA') {
                    var namadepan = $('#PPPasienM_namadepan').val('Nn. ');
                    if(statusperkawinan === 'KAWIN' || statusperkawinan == 'JANDA' || statusperkawinan == 'NIKAH SIRIH' || statusperkawinan == 'POLIGAMI'){
                        var namadepan = $('#PPPasienM_namadepan').val('Ny. ');
                    } else {
                        var namadepan = $('#PPPasienM_namadepan').val('Nn. ');
                    }
                } else {
                    alert('Silakan pilih status pernikahan yang sesuai!');
                    $('#PPPasienM_statusperkawinan').val('KAWIN');
                    var namadepan = $('#PPPasienM_namadepan').val('Ny. ');
                }
            }

            if (statusperkawinan == "DIBAWAH UMUR"){
                alert('Silakan pilih status pernikahan yang sesuai!');
                $('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
            }
        }
    }

    function cekStatusPekerjaan(obj)
    {
        var namaDepan = $('#PPPasienM_namadepan').val();
        var namaPekerjaan = obj.value;
        var umur = $("#<?php echo CHtml::activeId($model,'umur');?>").val().substr(0,2);
        umur = parseInt(umur);

        if(namaDepan.length > 0)
        {
            if(umur < 15){
                if(namaPekerjaan !== '13' && namaPekerjaan != '10'){
                    if(namaPekerjaan !== ''){
                        alert('Pasien masih di bawah umur, silakan cek kembali!');
                    }
                    $(obj).val('');
                }else{
                    $(obj).val(namaPekerjaan);
                }
            }else{
                if(namaPekerjaan === '12'){
                    if(namaDepan === 'Ny. '){
                        $(obj).val('9');
                    }else if(namaDepan === 'Nn. ' && namaPekerjaan === '9'){
                        alert('Pasien belum menikah, silakan cek kembali!');
                        $(obj).val('');
                    }else{
                        $(obj).val('');
                    }
                    alert('Silakan pilih pekerjaan yang tepat!');
                }else{
                    if(namaPekerjaan === '9'){
                        if(namaDepan !== 'Ny. '){
                        if ($("#PPPasienM_jeniskelamin_0").is(":checked")) alert ("Silakan Cek Kembali Jenis Kelamin Yang Dipilih!");
                        else alert('Silakan Cek Kembali Status Perkawinan Anda!');
                        $(obj).val('');
                        }
                    }
                }
            }
        }else{
            $(obj).val('');
            alert('Silakan pilih gelar kehormatan terlebih dahulu!');
        }

    }


    /** bersihkan dropdown kecamatan */
    function setClearDropdownKecamatan()
    {
        $("#<?php echo CHtml::activeId($modPasien,"kecamatan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }
    /** bersihkan dropdown kelurahan */
    function setClearDropdownKelurahan()
    {
        $("#<?php echo CHtml::activeId($modPasien,"kelurahan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }

    /**
     * set input radio button jenis kelamin
     * @param {type} jk
     * @returns {undefined}
     */
    function setJenisKelaminPasien(jk){
        $('input[name$="[jeniskelamin]"][type="radio"]').each(function(){
            if($(this).val() == $.trim(jk)){
                $(this).attr('checked',true);
            }
        });
    }
    /**
     * set input radio button rhesus
     * @param {type} rh
     * @returns {undefined}
     */
    function setRhesusPasien(rh){
        $('input[name*="[rhesus]"]').each(function(){
            if(this.value == $.trim(rh))
                $(this).attr('checked',true);
        });
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