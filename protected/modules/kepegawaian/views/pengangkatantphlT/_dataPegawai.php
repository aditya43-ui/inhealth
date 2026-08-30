<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('class' => 'required numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nomor Induk Pegawai')); ?>
        <div class="control-group">
            <?php echo CHtml::label('No. Identitas', 'noidentitas', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenisidentitas', LookupM::getItems('jenisidentitas'), array('empty' => '-- Pilih --', 'id' => 'jenisidentitas', 'style' => 'width:70px;', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textField($model, 'noidentitas', array('class'=>'numbers-only','empty' => '-- Pilih --', 'id' => 'jenisidentitas', 'style' => 'width:135px;', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Identitas Pegawai')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php //echo $form->labelEx($model,'nama_pegawai',array('class'=>'control-label required')); ?>
            <label class="control-label" for="KPPegawaiM_nama_pegawai">
                Nama Pegawai
                <!--<span class="required">*</span>-->
          </label>
            <div class="controls inline">
                <?php
                echo $form->dropDownList($model, 'gelardepan', CHtml::listData($model->getGelarDepanItems(), 'lookup_id', 'lookup_name'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'style' => 'width:60px;'));
                ?>
                <?php echo $form->textField($model, 'nama_pegawai', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'class' => 'required hurufs-only', 'style' => 'width:127px;', 'placeholder' => 'Nama Lengkap Pegawai')); ?>
                <?php
                echo $form->dropDownList($model, 'gelarbelakang_id', CHtml::listData($model->getGelarBelakangItems(), 'gelarbelakang_id', 'gelarbelakang_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'style' => 'width:60px;'));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nama_keluarga', array('class'=>'hurufs-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nama Keluarga Pegawai')); ?>
        <?php
            echo $form->dropDownListRow($model, 'jabatan_id', CHtml::listData($model->getJabatanItems(), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
            ));
        ?>
        <?php
            echo $form->dropDownListRow($model, 'pangkat_id', CHtml::listData($model->getPangkatItems(), 'pangkat_id', 'pangkat_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
            ));
        ?>
        <?php echo $form->textFieldRow($model, 'tempatlahir_pegawai', array('class'=>'hurufs-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'placeholder' => 'Kota/Kabupaten Kelahiran')); ?>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'tgl_lahirpegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tgl_lahirpegawai = (!empty($model->tgl_lahirpegawai) ? date("d/m/Y", strtotime($model->tgl_lahirpegawai)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_lahirpegawai',
                    'mode' => 'date',
                    'options' => array(
                        //                                            'dateFormat'=>Params::DATE_FORMAT,
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array('placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'tgl_lahirpegawai'); ?>
            </div>
        </div>
        <?php echo $form->radioButtonListInlineRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'inputRequire span3')); ?>
        <div class="control-group">
            <?php echo CHtml::label('Tinggi / Berat Badan', 'tinggiberatbadan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'tinggibadan', array('class' => 'span1 integer', 'style' => 'width:65px;', 'id' => 'tinggiberatbadan', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Tinggi Badan')) ?>
                <?php echo ' / '; ?>
                <?php echo $form->textField($model, 'beratbadan', array('class' => 'span1 integer', 'style' => 'width:60px;', 'id' => 'tinggiberatbadan', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Berat Badan')) ?>
            </div>
        </div>
        <?php
            echo $form->dropDownListRow($model, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
            'class' => 'inputRequire span3'));
        ?>
        <?php
            echo $form->dropDownListRow($model, 'agama', LookupM::getItems('agama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
            'class' => 'inputRequire span3'));
        ?>  
        <div class="control-group">
            <?php echo $form->labelEx($model,'golongandarah', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'golongandarah', LookupM::getItems('golongandarah'),  
                    array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>   
                <div class="radio inline">
                    <div class="form-inline">
                        <?php echo $form->radioButtonList($model,'rhesus',LookupM::getItems('rhesus'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
                    </div>
                </div>
                <?php echo $form->error($model, 'golongandarah'); ?>
                <?php echo $form->error($model, 'rhesus'); ?>
            </div>
        </div>    
        <?php echo $form->dropDownListRow($model, 'warganegara_pegawai', LookupM::getItems('warganegara'), array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 25)); ?>
        <?php echo $form->dropDownListRow($model, 'suku_id', CHtml::listData($model->getSukuItems(), 'suku_id', 'suku_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->dropDownListRow($model, 'pendidikan_id', CHtml::listData($model->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->dropDownListRow($model, 'pendkualifikasi_id', CHtml::listData($model->getPendidikanKualifikasiItems(), 'pendkualifikasi_id', 'pendkualifikasi_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)"));?>
        <div class="control-group">
            <?php echo CHtml::label('No. Telp / Hp', 'nomorcontact', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'notelp_pegawai', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 15, 'style' => 'width:97px;', 'id' => 'nomorcontact', 'placeholder' => 'No. Telepon Pegawai')); ?>
                <?php echo ' / '; ?>
                <?php echo $form->textField($model, 'nomobile_pegawai', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 15, 'style' => 'width:97px;', 'id' => 'nomorcontact', 'placeholder' => 'No. Handphone Pegawai')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'alamatemail', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'contoh: info@piinformasi.com')); ?>
        <?php echo $form->dropDownListRow($model, 'kategoripegawaiasal', LookupM::getItems('kategoriasalpegawai'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)"));?>
        <?php echo $form->dropDownListRow($model, 'kategoripegawai', LookupM::getItems('kategoripegawai'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)"));?>
        <?php echo $form->dropDownListRow($model, 'kelompokpegawai_id', CHtml::listData($model->getKelompokPegawaiItems(), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)"));?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'kelompokjabatan', LookupM::getItems('kelompokjabatan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)"));?>
        <?php echo $form->dropDownListRow($model, 'jeniswaktukerja', LookupM::getItems('jeniswaktukerja'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)"));?>  
        <?php echo $form->dropDownListRow($model, 'statuskepemilikanrumah_id', CHtml::listData($model->getStatuskepemilikanrumahItems(), 'statuskepemilikanrumah_id', 'statuskepemilikanrumah_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>    
        <?php echo $form->dropDownListRow($model, 'kemampuanbahasa', LookupM::getItems('kemampuanbahasa'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->dropDownListRow($model, 'warnakulit', LookupM::getItems('warnakulit'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>           
        <?php echo $form->textAreaRow($model, 'alamat_pegawai', array('rows' => 6, 'cols' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Alamat Lengkap Pegawai')); ?>
        <?php
            echo $form->dropDownListRow($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('empty' => '-- Pilih --',
            'ajax' => array('type' => 'POST',
                'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'model_nama' => 'KPPegawaiM')),
                'update' => '#'.CHtml::activeId($model, 'kabupaten_id').''),
            'onkeypress' => "return $(this).focusNextInputField(event)"
            ));
        ?>
        <?php
            echo $form->dropDownListRow($model, 'kabupaten_id', array(), array('empty' => '-- Pilih --',
            'ajax' => array('type' => 'POST',
                'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false,  'model_nama' => 'KPPegawaiM')),
                'update' => '#'.CHtml::activeId($model, 'kecamatan_id').''),
            'onkeypress' => "return $(this).focusNextInputField(event)"
            ));
        ?>
        <?php
            echo $form->dropDownListRow($model, 'kecamatan_id', array(), array('empty' => '-- Pilih --',
            'ajax' => array('type' => 'POST',
                'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false,  'model_nama' => 'KPPegawaiM')),
                'update' => '#'.CHtml::activeId($model, 'kelurahan_id').''),
            'onkeypress' => "return $(this).focusNextInputField(event)"
            ));
        ?>
        <?php echo $form->dropDownListRow($model, 'kelurahan_id', array(), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'tglditerima', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                    $model->tgl_lahirpegawai = (!empty($model->tgl_lahirpegawai) ? date("d/m/Y", strtotime($model->tglditerima)) : null);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglditerima',
                        'mode' => 'date',
                        'options' => array(
                            //                                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                            'yearRange' => "-150:+0",
                        ),
                        'htmlOptions' => array('placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                ?>
                <?php echo $form->error($model, 'tglditerima'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'caraAmbilPhoto', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php echo CHtml::radioButton('caraAmbilPhoto', false, array('value' => 'webCam', 'onclick' => 'caraAmbilPhotoJS(this)', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?><span style='font-size:11px';>Web Cam</span>
                <?php echo CHtml::radioButton('caraAmbilPhoto', true, array('value' => 'file', 'onclick' => 'caraAmbilPhotoJS(this)', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?><span style='font-size:11px';>File</span>                               
            </div>
        </div>
        <div id="divCaraAmbilPhotoWebCam"  style="display:none;">
            <div class="controls">
                <div class="buttonWebcam2">
                    <?php
                    $random = rand(0000000000000000, 9999999999999999);
                    $pathPhotoPegawaiTumbs = Params::pathPegawaiTumbsDirectory();
                    $pathPhotoPegawai = Params::pathPegawaiDirectory();
                    $urlAjaxSessionPhoto = '';
                    ?>
                    <?php echo $form->hiddenField($model, 'tempPhoto', array('readonly' => TRUE, 'value' => $random . '.jpg')); ?>
                    <?php
                    $onBeforeSnap = "document.getElementById('upload_results').innerHTML = '<h1>Proses Penyimpanan...</h1>';";
                    $completionHandler = <<<BLOCK
                        if (msg == 'OK') 
                           {
                                document.getElementById('upload_results').innerHTML = '<h1>OK! ...Photo Sedang Disimpan</h1>';

                                // reset camera for another shot
                                // webcam.reset();
                                setTimeout(function(){
                                document.getElementById('upload_results').innerHTML = '<h1>Photo Berhasil Disimpan</h1>';
                                },3000);
//                              $('#sapegawai-m-form').submit();           
                                $.post("${urlAjaxSessionPhoto}",{},
                                    function(data){
                                    $('#gambar').attr('src',data.photo);

                                },"json");
                            }else{
                                myAlert("PHP Error: " + msg);
                            }
BLOCK;

                    $this->widget('application.extensions.jpegcam.EJpegcam', array(
                        'apiUrl' => 'index.php?r=photoWebCam/jpegcam.saveJpg&random=' . $random . '&pathTumbs=' . $pathPhotoPegawaiTumbs . '&path=' . $pathPhotoPegawai . '',
                        'shutterSound' => false,
                        'stealth' => true,
                        'buttons' => array(
                            'configure' => 'Konfigurasi',
//                          'takesnapshot' => 'Ambil Foto',
                            'freeze' => 'Ambil Foto',
                            'reset' => 'Ulang',
                            'takesnapshot' => 'Simpan',
                        ),
                        'onBeforeSnap' => $onBeforeSnap,
                        'completionHandler' => $completionHandler
                    ));
                    ?>
<!--<img src="<?php //echo Params::urlPegawaiDirectory()?>9680901rizky.jpg " id="gambar">-->

                    <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
                </div>
            </div>
        </div>
        <div id="divCaraAmbilPhotoFile" style="display: block;">
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'photopegawai', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                    <div class="controls">  
                        <?php
                            $url_photopegawai = (!empty($model->photopegawai) ? Params::urlPegawaiTumbsDirectory() . "kecil_" . $model->photopegawai : Params::urlPegawaiDirectory() . "no_photo.jpeg");
                        ?>
                        <?php echo Chtml::activeFileField($model, 'photopegawai', array('maxlength' => 254, 'Hint' => 'Isi Jika Akan Menambahkan Logo', 'class' => 'fileupload-new')); ?>
                    </div>
                </div>
                <div class="control-group" style="padding-left:29.8%">
                    <div class="controls">
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; line-height: 20px;"><img src="<?php echo $url_photopegawai; ?>" /></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>