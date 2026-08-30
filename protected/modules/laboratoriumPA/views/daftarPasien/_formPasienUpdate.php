<fieldset class="box" id='fieldsetPasien'>
    <legend class="rim">Ubah Data Pasien </legend>
    <table><tr>
            <td width="50%">
                <div class="control-group">
                    <?php // echo $form->labelEx($modPasien,'no_rekam_medik',array('class'=>'control-label')); ?>
                    <label class="control-label">No./Tgl. Rekam Medik</label>
                    <div class="controls">
                        <?php echo $form->textField($modPasien, 'no_rekam_medik', array('class' => 'span2', 'readonly' => true)); ?>
                        <?php echo $form->textField($modPasien, 'tgl_rekam_medik', array('class' => 'span2', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPasien, 'no_identitas_pasien', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($modPasien, 'jenisidentitas', LookupM::getItems('jenisidentitas'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 reqPasien'
                        ));
                        ?>   
                        <?php echo $form->textField($modPasien, 'no_identitas_pasien', array('placeholder' => 'No. Identitas', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>            
<?php echo $form->error($modPasien, 'jenisidentitas'); ?><?php echo $form->error($modPasien, 'no_identitas'); ?>
                    </div>
                </div>

                <?php //echo $form->dropDownListRow($modPasien,'jenisidentitas', LookupM::getItems('jenisidentitas'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php //echo $form->textFieldRow($modPasien,'no_identitas_pasien',array('onkeypress'=>"return $(this).focusNextInputField(event)"));  ?>
                <div class="control-group ">
<?php echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
                    <div class="controls inline">

                        <?php
                        echo $form->dropDownList($modPasien, 'namadepan', LookupM::getItems('namadepan'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 reqPasien', 'readOnly' => true,
                        ));
                        ?>   
                        <?php
                        echo $form->textField($modPasien, 'nama_pasien', array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'placeholder' => 'Nama Pasien',
                            'class' => 'span2 reqPasien',
                            'onkeyup' => 'convertToUpper(this)'
                                )
                        );
                        ?>

                        <?php echo $form->error($modPasien, 'namadepan'); ?><?php echo $form->error($modPasien, 'nama_pasien'); ?>
                    </div>
                </div>

                <?php //echo $form->dropDownListRow($modPasien,'namadepan', LookupM::getItems('namadepan'),array('empty'=>'-- Pilih --','class'=>'span1','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php //echo $form->textFieldRow($modPasien,'nama_pasien',array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($modPasien, 'nama_bin', array('onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Alias')); ?>
                <?php echo $form->textFieldRow($modPasien, 'tempat_lahir', array('onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Tempat Lahir')); ?>
                <?php //echo $form->textFieldRow($modPasien,'tanggal_lahir'); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPasien, 'tanggal_lahir', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPasien,
                            'attribute' => 'tanggal_lahir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                                'maxYear' => 'd',
                                //
                                'onkeypress' => "js:function(){getUmur(this);}",
                                'onSelect' => 'js:function(){getUmur(this);}',
                                'yearRange' => "-60:+0",
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 reqPasien', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
<?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                    </div>
                </div>

                    <?php //echo $form->textFieldRow($modPasien,'umur', array('onkeypress'=>"return $(this).focusNextInputField(event)",'onblur'=>'getTglLahir(this)'));  ?>
                <div class="control-group ">
                        <?php echo $form->labelEx($modPasien, 'umur', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('CMaskedTextField', array(
                            'model' => $modPasien,
                            'attribute' => 'umur',
                            'mask' => '99 Thn 99 Bln 99 Hr',
                            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'onblur' => 'getTglLahir(this)', 'placeholder' => 'Umur Pasien', 'onchange' => 'setNamaGelar()')
                        ));
                        ?>
<?php echo $form->error($modPasien, 'umur'); ?>
                    </div>
                </div>

                <?php //echo $form->dropDownListRow($modPasien,'kelompokumur', LookupM::getItems('kelompokumur'),array('empty'=>'-- Pilih --', 'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('class' => 'reqPasien', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaGelar()')); ?>
                <?php //echo $form->dropDownListRow($modPasien,'jeniskelamin', LookupM::getItems('jeniskelamin'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
<?php echo $form->dropDownListRow($modPasien, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaGelar()')); ?>

                <!--    <div class="control-group ">
                <?php // echo $form->labelEx($modPasien,'golongandarah', array('class'=>'control-label'))  ?>
                        <div class="controls">
                <?php
//                echo $form->dropDownList($modPasien,'golongandarah', LookupM::getItems('golongandarah'),  
//                    array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'));
                ?>   
                            <div class="radio inline">
                                <div class="form-inline">
<?php // echo $form->radioButtonList($modPasien,'rhesus',LookupM::getItems('rhesus'), array('onkeypress'=>"return $(this).focusNextInputField(event)"));  ?>            
                                </div>
                           </div>
                <?php // echo $form->error($modPasien, 'golongandarah'); ?>
<?php // echo $form->error($modPasien, 'rhesus');  ?>
                        </div>
                    </div>-->
                <?php //echo $form->dropDownListRow($modPasien,'golongandarah', LookupM::getItems('golongandarah'),array('empty'=>'-- Pilih --','class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)"));  ?>

                <?php //echo $form->dropDownListRow($modPasien,'rhesus', LookupM::getItems('rhesus'),array('empty'=>'-- Pilih --','class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)"));  ?>

                <?php
                echo $form->textAreaRow($modPasien, 'alamat_pasien', array(
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'placeholder' => 'Alamat Pasien',
                    'onkeyup' => 'convertToUpper(this)',
                    'class' => 'reqPasien',
                        )
                );
                ?>
                <?php //echo $form->textFieldRow($modPasien,'rt',array('class'=>'span1','maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPasien, 'rt', array('class' => 'control-label inline')) ?>

                    <div class="controls">
                        <?php echo $form->textField($modPasien, 'rt', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 numberOnly', 'maxlength' => 3, 'placeholder' => 'RT')); ?>   / 
                        <?php echo $form->textField($modPasien, 'rw', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 numberOnly', 'maxlength' => 3, 'placeholder' => 'RW')); ?>            
                        <?php echo $form->error($modPasien, 'rt'); ?>
                        <?php echo $form->error($modPasien, 'rw'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPasien, 'no_telepon_pasien', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modPasien, 'no_telepon_pasien', array('class' => 'numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Telepon yang dapat dihubungi')); ?>
                        <?php echo $form->error($modPasien, 'no_telepon_pasien'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPasien, 'no_mobile_pasien', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modPasien, 'no_mobile_pasien', array('class' => 'numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. HP yang dapat dihubungi')); ?>
                        <?php echo $form->error($modPasien, 'no_mobile_pasien'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modPasien, 'alamatemail', arraY('onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Alamat E-mail')); ?>

            </td>
            <td width="50%">
                <?php
                echo $form->textFieldRow($modPasien, 'nama_ibu', array(
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'placeholder' => 'Nama Ibu'
                        )
                );
                ?>
                <?php
                echo $form->textFieldRow($modPasien, 'nama_ayah', array(
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'placeholder' => 'Nama Ayah'
                        )
                );
                ?>
                <div class="control-group ">
                <?php echo $form->labelEx($modPasien, 'anakke', array('class' => 'control-label')) ?>
                    <div class="controls">
                    <?php echo $form->textField($modPasien, 'anakke', array('class' => 'span1', 'maxlength' => 2, 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Anak Ke')) . '<label> dari </label>'; ?> 
                        <?php echo $form->textField($modPasien, 'jumlah_bersaudara', array('class' => 'span1', 'maxlength' => 2, 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Dari')) . '<label> bersaudara</label>'; ?>
                        <?php //echo CHtml::button('', array('class'=>'buttonTambahIcon','onclick'=>"{addPropinsi(); $('#dialogAddPropinsi').dialog('open');}",'id'=>'btnAddPropinsi',)) ?>
                        <?php echo $form->error($modPasien, 'anakke'); ?><?php echo $form->error($modPasien, 'jumlah_bersaudara'); ?>
                    </div>
                        <?php //echo $form->textFieldRow($modPasien,'rw',array('class'=>'span1','maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <div class="control-group ">
                    <?php $modPasien->propinsi_id = (!empty($modPasien->propinsi_id)) ? $modPasien->propinsi_id : Yii::app()->user->getState('propinsi_id'); ?>
                        <?php echo $form->labelEx($modPasien, 'propinsi_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                        <?php
                        echo $form->dropDownList($modPasien, 'propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqPasien',
                            'ajax' => array('type' => 'POST',
                                'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'namaModel' => 'LBPasienM')),
                                'update' => '#LKPasienM_kabupaten_id',),
                            'onchange' => "clearKecamatan();clearKelurahan();",));
                        ?>
                            <?php
                            echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array('class' => 'btn btn-primary', 'onclick' => "{addPropinsi(); $('#dialogAddPropinsi').dialog('open');}",
                                'id' => 'btnAddPropinsi', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modPasien->getAttributeLabel('propinsi_id')))
                            ?>
                            <?php echo $form->error($modPasien, 'propinsi_id'); ?>
                        </div>
                    </div>

                    <div class="control-group ">
                        <?php $modPasien->kabupaten_id = (!empty($modPasien->kabupaten_id)) ? $modPasien->kabupaten_id : Yii::app()->user->getState('kabupaten_id'); ?>
                        <?php echo $form->labelEx($modPasien, 'kabupaten_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($modPasien, 'kabupaten_id', CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqPasien',
                                'ajax' => array('type' => 'POST',
                                    'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false, 'namaModel' => 'LBPasienM')),
                                    'update' => '#LKPasienM_kecamatan_id'),
                                'onchange' => "clearKelurahan();",));
                            ?>
                            <?php
                            echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array('class' => 'btn btn-primary', 'onclick' => "{addKabupaten(); $('#dialogAddKabupaten').dialog('open');}",
                                'id' => 'btnAddKabupaten', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modPasien->getAttributeLabel('kabupaten_id')))
                            ?>
<?php echo $form->error($modPasien, 'kabupaten_id'); ?>
                        </div>
                    </div>

                    <div class="control-group ">
                            <?php $modPasien->kecamatan_id = (!empty($modPasien->kecamatan_id)) ? $modPasien->kecamatan_id : Yii::app()->user->getState('kecamatan_id'); ?>
                            <?php echo $form->labelEx($modPasien, 'kecamatan_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($modPasien, 'kecamatan_id', CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqPasien',
                                'ajax' => array('type' => 'POST',
                                    'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false, 'namaModel' => 'LBPasienM')),
                                    'update' => '#LKPasienM_kelurahan_id')));
                            ?>
                            <?php
                            echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array('class' => 'btn btn-primary', 'onclick' => "{addKecamatan(); $('#dialogAddKecamatan').dialog('open');}",
                                'id' => 'btnAddKecamatan', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modPasien->getAttributeLabel('kecamatan_id')))
                            ?>
                        <?php echo $form->error($modPasien, 'kecamatan_id'); ?>
                        </div>
                    </div>

                    <div class="control-group ">
                            <?php $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id)) ? $modPasien->kelurahan_id : Yii::app()->user->getState('kelurahan_id'); ?>
                            <?php echo $form->labelEx($modPasien, 'kelurahan_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPasien, 'kelurahan_id', CHtml::listData($modPasien->getKelurahanItems($modPasien->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",));
                            ?>
                            <?php
                            echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array('class' => 'btn btn-primary', 'onclick' => "{addKelurahan(); $('#dialogAddKelurahan').dialog('open');}",
                                'id' => 'btnAddKelurahan', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modPasien->getAttributeLabel('kelurahan_id')))
                            ?>
                    <?php echo $form->error($modPasien, 'kelurahan_id'); ?>
                        </div>
                    </div>

                    <?php //echo $form->textFieldRow($modPasien,'tgl_rekam_medik'); ?>
                    <?php //echo $form->textFieldRow($modPasien,'statusrekammedis'); ?>
                    <?php $modPasien->agama = (!empty($modPasien->agama)) ? $modPasien->agama : Params::DEFAULT_AGAMA; ?>
                    <?php echo $form->dropDownListRow($modPasien, 'agama', LookupM::getItems('agama'), array('class' => 'reqPasien', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->dropDownListRow($modPasien, 'pendidikan_id', CHtml::listData($modPasien->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->dropDownListRow($modPasien, 'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'cekStatusPekerjaan(this)')); ?>
                    <?php $modPasien->warga_negara = (!empty($modPasien->warga_negara)) ? $modPasien->warga_negara : Params::DEFAULT_WARGANEGARA; ?>
                    <?php echo $form->dropDownListRow($modPasien, 'warga_negara', LookupM::getItems('warganegara'), array('class' => 'reqPasien', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->dropDownListRow($modPasien, 'suku_id', CHtml::listData($modPasien->getSukuItems(), 'suku_id', 'suku_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <!--    <div class="control-group ">
                    <?php // echo $form->labelEx($modPasien,'no_telepon_pasien', array('class'=>'control-label')) ?>
                            <div class="controls">
                    <?php // echo $form->textField($modPasien,'no_telepon_pasien', array('onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Tlp','class'=>'span2'));  ?>
                    <?php // echo $form->textField($modPasien,'no_mobile_pasien', array('onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Mobile','class'=>'span2')); ?>
<?php // echo $form->error($modPasien, 'rt');  ?>
<?php // echo $form->error($modPasien, 'rw');  ?>
                            </div>
                        </div>-->
<?php //echo $form->textFieldRow($modPasien,'tgl_meninggal');  ?>


                    <!--<fieldset id="fieldsetDetailPasien" class="span6">
                        <legend class="accord1"><?php // echo CHtml::checkBox('cex_detaildatapasien', '', array('onkeypress'=>"return $(this).focusNextInputField(event)"))  ?>
                            Detail Data Pasien 
                        </legend>
                        <div id='detail_data_pasien' class="control-group toggle">
                    <?php //echo $form->textFieldRow($modPasien,'anakke',array('class'=>'span1','maxlength'=>2, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                            <div class="control-group ">
                    <?php // echo $form->labelEx($modPasien,'anakke', array('class'=>'control-label')) ?>
                            <div class="controls">
                                
                    <?php // echo $form->textField($modPasien,'anakke', array('class'=>'span1','maxlength'=>2,'onkeypress'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Anak Ke')).' dari ';  ?> 
                    <?php // echo $form->textField($modPasien,'jumlah_bersaudara', array('class'=>'span1','maxlength'=>2,'onkeypress'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Dari' )).' bersaudara'; ?>
                    <?php //echo CHtml::button('', array('class'=>'buttonTambahIcon','onclick'=>"{addPropinsi(); $('#dialogAddPropinsi').dialog('open');}",'id'=>'btnAddPropinsi',))  ?>
                    <?php // echo $form->error($modPasien, 'anakke'); ?><?php // echo $form->error($modPasien, 'jumlah_bersaudara'); ?>
                            </div>
                        </div>
                    <?php //echo $form->textFieldRow($modPasien,'jumlah_bersaudara',array('class'=>'span1','maxlength'=>2, 'onkeypress'=>"return $(this).focusNextInputField(event)"));  ?>
                        
                    <?php // echo $form->textFieldRow($modPasien,'no_telepon_pasien',array('onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Telephone Yang Dapat Dihubungi')); ?>
<?php // echo $form->textFieldRow($modPasien,'no_mobile_pasien', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'No. Hp Yang Dapat Dihubungi','class'=>'numbersOnly'));  ?>
<?php // echo $form->dropDownListRow($modPasien,'suku_id', CHtml::listData($modPasien->getSukuItems(), 'suku_id', 'suku_nama'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)"));  ?>
                        <img id="imgFotoPasien" src="" alt="photo pasien">
                        <?php //echo $form->fileFieldRow($modPasien,'photopasien', array('onchange'=>'previewFoto(this)','onkeypress'=>"return $(this).focusNextInputField(event)"));  ?>
                        <?php // echo $form->textFieldRow($modPasien,'alamatemail', arraY('onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Alamat E-mail')); ?>
                        </div>
                    </fieldset>-->

                    <div class="control-group">
<?php echo $form->labelEx($modPasien, 'caraAmbilPhoto', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                        <div class="controls">  
<?php echo CHtml::radioButton('caraAmbilPhoto', false, array('value' => 'webCam', 'onclick' => 'caraAmbilPhotoJS(this)', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> Web Cam
                    <?php echo CHtml::radioButton('caraAmbilPhoto', true, array('value' => 'file', 'onclick' => 'caraAmbilPhotoJS(this)', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> File                               
                        </div>
                    </div>

                </div>
                <div id="divCaraAmbilPhotoWebCam"  style="display: none">
                    <?php
                    $random = rand(0000000000000000, 9999999999999999);
                    $pathPhotoPegawaiTumbs = Params::pathPasienDirectory();
                    $pathPhotoPegawai = Params::pathPasienTumbsDirectory();
                    ?>
                    <?php
                    $onBeforeSnap = "document.getElementById('upload_results').innerHTML = '<h1>Proses Penyimpanan...</h1>';";
                    $completionHandler = <<<BLOCK
                          if (msg == 'OK') 
                           {
                                document.getElementById('upload_results').innerHTML = '<h1>OK! ...Photo Sedang Disimpan</h1>';
                                // reset camera for another shot
                                webcam.reset();
                                setTimeout(function(){
                                document.getElementById('upload_results').innerHTML = '<h1>Photo Berhasil Disimpan</h1>';
                                },3000);
                            }
                         else
                            {
                                myAlert("PHP Error: " + msg);
                            }
BLOCK;

                    $this->widget('application.extensions.jpegcam.EJpegcam', array(
                        'apiUrl' => 'index.php?r=photoWebCam/jpegcam.saveJpg&random=' . $random . '&pathTumbs=' . $pathPhotoPegawaiTumbs . '&path=' . $pathPhotoPegawai . '',
                        'shutterSound' => false,
                        'stealth' => true,
                        'buttons' => array(
                            'configure' => 'Konfigurasi',
//                'takesnapshot' => 'Ambil Photo2',
                            'freeze' => 'Ambil Photo',
                            'reset' => 'Ulang',
                        ),
                        'onBeforeSnap' => $onBeforeSnap,
                        'completionHandler' => $completionHandler
                    ));
                    ?>     

                    <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
                </div>
                <div id="divCaraAmbilPhotoFile" style="display: block">
                    <div class="control-group">
<?php echo $form->hiddenField($modPasien, 'tempPhoto', array('readonly' => TRUE, 'value' => $random . '.jpg')); ?>
                <?php echo $form->labelEx($modPasien, 'photopasien', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                        <div class="controls">  
<?php echo Chtml::activeFileField($modPasien, 'photopasien', array('maxlength' => 254, 'Hint' => 'Isi Jika Akan Menambahkan Logo', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                </div>
<?php //echo $form->textFieldRow($modPasien,'no_rekam_medik');  ?>
            </td>
        </tr>
    </table>
</fieldset>

<?php
$urlGetTglLahir = $this->createUrl('GetTglLahir');
$urlGetUmur = $this->createUrl('GetUmur');
$urlGetDaerah = Yii::app()->createUrl('ActionAjax/getListDaerahPasien');
$idTagUmur = CHtml::activeId($modPasien, 'umur');
$js = <<< JS
setTimeout(function(){loadUmur($('#LKPasienM_tanggal_lahir').val());},1000);
        
function previewFoto(obj)
{
    var pathFile = $(obj).val();
    $('#imgFotoPasien').attr('src','file://'+pathFile);
    $('#imgFotoPasien').load();
}

function enableInputPasien(obj)
{
    if(!obj.checked) {
        $('#fieldsetPasien input').removeAttr('disabled');
        $('#fieldsetPasien input').removeAttr('checked');
        $('#fieldsetPasien #isUpdatePasien').hide();
        $('#fieldsetPasien select').removeAttr('disabled');
        $('#fieldsetPasien textarea').removeAttr('disabled');
        $('#fieldsetPasien button').removeAttr('disabled');
//        $('#fieldsetDetailPasien input').removeAttr('disabled');
//        $('#fieldsetDetailPasien select').removeAttr('disabled');
        $('#controlNoRekamMedik button').attr('disabled','true');
        $('#noRekamMedik').attr('readonly','true');
        //$('#detail_data_pasien').slideUp(500);
        //$('#cex_detaildatapasien').removeAttr('checked','checked');

        $('#noRekamMedik').val('');
        $('#fieldsetPasien input').not(':radio').val('');
        $('#fieldsetPasien select').val('');
        $('#fieldsetPasien textarea').val('');
        $('#fieldsetPasien button').val('');
//        $('#fieldsetDetailPasien input').val('');
//        $('#fieldsetDetailPasien select').val('');
        $('#tombolPasienDialog').addClass('hide');
        
    }
    else {
        $('#fieldsetPasien input').attr('disabled','true');
        $('#fieldsetPasien #isUpdatePasien').show();
        $('#fieldsetPasien #isUpdatePasien').removeAttr('disabled');
        $('#fieldsetPasien select').attr('disabled','true');
        $('#fieldsetPasien textarea').attr('disabled','true');
        $('#fieldsetPasien button').attr('disabled','true');
//        $('#fieldsetDetailPasien input').attr('disabled','true');
//        $('#fieldsetDetailPasien select').attr('disabled','true');
        $('#controlNoRekamMedik button').removeAttr('disabled');
        $('#noRekamMedik').removeAttr('readonly');
        $('#detail_data_pasien').slideDown(500);
        $('#cex_detaildatapasien').attr('checked','checked');
        $('#tombolPasienDialog').removeClass('hide');
        
    }
}

function updateInputPasien(obj)
{
    if(!obj.checked) {
        $('#fieldsetPasien input').attr('disabled','true');
        $('#fieldsetPasien #isUpdatePasien').removeAttr('disabled');
        $('#fieldsetPasien select').attr('disabled','true');
        $('#fieldsetPasien textarea').attr('disabled','true');
        $('#fieldsetPasien button').attr('disabled','true');
//        $('#fieldsetDetailPasien input').attr('disabled','true');
//        $('#fieldsetDetailPasien select').attr('disabled','true');
        $('#controlNoRekamMedik button').removeAttr('disabled');
        $('#noRekamMedik').removeAttr('readonly');
        //$('#detail_data_pasien').slideDown(500);
        //$('#cex_detaildatapasien').attr('checked','checked');
        
    }
    else {
        $('#fieldsetPasien input').removeAttr('disabled');
        $('#fieldsetPasien select').removeAttr('disabled');
        $('#fieldsetPasien textarea').removeAttr('disabled');
        $('#fieldsetPasien button').removeAttr('disabled');
//        $('#fieldsetDetailPasien input').removeAttr('disabled');
//        $('#fieldsetDetailPasien select').removeAttr('disabled');
        $('#controlNoRekamMedik button').attr('disabled','true');
        $('#noRekamMedik').attr('readonly','true');
        //$('#detail_data_pasien').slideUp(500);
        //$('#cex_detaildatapasien').removeAttr('checked','checked');
        
    }
}

function getTglLahir(obj)
{
    var str = obj.value;
    obj.value = str.replace(/_/gi, "0");
    $.post("${urlGetTglLahir}",{umur: obj.value},
        function(data){
           $('#LKPasienM_tanggal_lahir').val(data.tglLahir); 
    },"json");
}

function getUmur(obj)
{
    //myAlert(obj.value);
    if(obj.value == '')
        obj.value = 0;
    $.post("${urlGetUmur}",{tglLahir: obj.value},
        function(data){

           $('#PPPendaftaranRj_umur').val(data.umur); 
           $('#PPPendaftaranMp_umur').val(data.umur); 
           $('#PPPendaftaranRd_umur').val(data.umur); 

           $("#${idTagUmur}").val(data.umur);
    },"json");
}

function loadUmur(tglLahir)
{
    $.post("${urlGetUmur}",{tglLahir: tglLahir},
        function(data){
           $("#${idTagUmur}").val(data.umur);
    },"json");
}

function setJenisKelaminPasien(jenisKelamin)
{
    $('input[name="LBPasienM[jeniskelamin]"]').each(function(){
            if(this.value == jenisKelamin)
                $(this).attr('checked',true);
        }
    );
}

function setRhesusPasien(rhesus)
{
    $('input[name="LBPasienM[rhesus]"]').each(function(){
            if(this.value == rhesus)
                $(this).attr('checked',true);
        }
    );
}

function loadDaerahPasien(idProp,idKab,idKec,idKel)
{
    $.post("${urlGetDaerah}", { idProp: idProp, idKab: idKab, idKec: idKec, idKel: idKel },
        function(data){
            $('#LKPasienM_propinsi_id').html(data.listPropinsi);
            $('#LKPasienM_kabupaten_id').html(data.listKabupaten);
            $('#LKPasienM_kecamatan_id').html(data.listKecamatan);
            $('#LKPasienM_kelurahan_id').html(data.listKelurahan);
    }, "json");
}

function clearKecamatan()
{
    $('#LKPasienM_kecamatan_id').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}

function clearKelurahan()
{
    $('#LKPasienM_kelurahan_id').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
JS;
Yii::app()->clientScript->registerScript('formPasien', $js, CClientScript::POS_HEAD);
?>

<?php
// Dialog buat nambah data propinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddPropinsi',
    'options' => array(
        'title' => 'Menambah data Propinsi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 350,
        'resizable' => false,
    ),
));

echo '<div class="divForForm"></div>';


$this->endWidget();
//========= end propinsi dialog =============================
// Dialog buat nambah data kabupaten =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddKabupaten',
    'options' => array(
        'title' => 'Menambah data Kabupaten',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 440,
        'resizable' => false,
    ),
));

echo '<div class="divForFormKabupaten"></div>';


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
        'height' => 440,
        'resizable' => false,
    ),
));

echo '<div class="divForFormKecamatan"></div>';


$this->endWidget();
//========= end kecamatan dialog =============================
// Dialog buat nambah data kelurahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddKelurahan',
    'options' => array(
        'title' => 'Menambah data Kelurahan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 440,
        'resizable' => false,
    ),
));

echo '<div class="divForFormKelurahan"></div>';


$this->endWidget();
//========= end kelurahan dialog =============================
?>

<script type="text/javascript">
// here is the magic
    function addPropinsi()
    {
<?php
echo CHtml::ajax(array(
    'url' => Yii::app()->createUrl('ActionAjax/addPropinsi'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogAddPropinsi div.divForForm').html(data.div);
                    $('#dialogAddPropinsi div.divForForm form').submit(addPropinsi);
                }
                else
                {
                    $('#dialogAddPropinsi div.divForForm').html(data.div);
                    $('#LKPasienM_propinsi_id').html(data.propinsi);
                    setTimeout(\"$('#dialogAddPropinsi').dialog('close') \",1000);
                }
 
            } ",
))
?>;
        return false;
    }

    function addKabupaten()
    {
<?php
echo CHtml::ajax(array(
    'url' => $this->createUrl('addKabupaten'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogAddKabupaten div.divForFormKabupaten').html(data.div);
                    $('#dialogAddKabupaten div.divForFormKabupaten form').submit(addKabupaten);
                }
                else
                {
                    $('#dialogAddKabupaten div.divForFormKabupaten').html(data.div);
                    $('#LKPasienM_kabupaten_id').html(data.kabupaten);
                    setTimeout(\"$('#dialogAddKabupaten').dialog('close') \",1000);
                }
 
            } ",
))
?>;
        return false;
    }

    function addKecamatan()
    {
<?php
echo CHtml::ajax(array(
    'url' => $this->createUrl('addKecamatan'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogAddKecamatan div.divForFormKecamatan').html(data.div);
                    $('#dialogAddKecamatan div.divForFormKecamatan form').submit(addKecamatan);
                }
                else
                {
                    $('#dialogAddKecamatan div.divForFormKecamatan').html(data.div);
                    $('#LKPasienM_kecamatan_id').html(data.kecamatan);
                    setTimeout(\"$('#dialogAddKecamatan').dialog('close') \",1000);
                }
 
            } ",
))
?>;
        return false;
    }

    function addKelurahan()
    {
<?php
echo CHtml::ajax(array(
    'url' => $this->createUrl('addKelurahan'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogAddKelurahan div.divForFormKelurahan').html(data.div);
                    $('#dialogAddKelurahan div.divForFormKelurahan form').submit(addKelurahan);
                }
                else
                {
                    $('#dialogAddKelurahan div.divForFormKelurahan').html(data.div);
                    $('#LKPasienM_kelurahan_id').html(data.kelurahan);
                    setTimeout(\"$('#dialogAddKelurahan').dialog('close') \",1000);
                }
 
            } ",
))
?>;
        return false;
    }
</script>

<?php
Yii::app()->clientScript->registerScript('detail_data_pasien', "
    $('#detail_data_pasien').hide();
    $('#cex_detaildatapasien').change(function(){
        if ($(this).is(':checked')){
//                $('#fieldsetDetailPasien input').not('input[type=checkbox]').removeAttr('disabled');
//                $('#fieldsetDetailPasien select').removeAttr('disabled');
        }else{
//                $('#fieldsetDetailPasien input').not('input[type=checkbox]').attr('disabled','true');
//                $('#fieldsetDetailPasien select').attr('disabled','true');
//                $('#fieldsetDetailPasien input').attr('value','');
//                $('#fieldsetDetailPasien select').attr('value','');
        }
        $('#detail_data_pasien').slideToggle(500);
    });
");


$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
?>

<script type="text/javascript">

    function convertToUpper(obj)
    {
        var string = obj.value;
        $(obj).val(string.toUpperCase());
    }

    function setNamaGelar()
    {
        var statusperkawinan = $('#<?php echo CHtml::activeId($modPasien, 'statusperkawinan'); ?>');
        var namadepan = $('#<?php echo CHtml::activeId($modPasien, 'namadepan'); ?>');
        var umur = $("#<?php echo CHtml::activeId($modPasien, 'umur'); ?>").val().substr(0, 2);
        umur = parseInt(umur);
        if (umur <= 5) {
            namadepan.val('BY. Ny.');
            if (statusperkawinan.val().length > 0) {
                statusperkawinan.val('');
                myAlert('Maaf status perkawinan belum cukup usia');
            }
        } else if (umur <= 15) {
            namadepan.val('An.');
            if (statusperkawinan.val().length > 0) {
                statusperkawinan.val('');
                myAlert('Maaf status perkawinan belum cukup usia');
            }
        } else {
            if ($('#LKPasienM_jeniskelamin_0').is(':checked')) {
                if (statusperkawinan.val() !== 'JANDA') {
                    namadepan.val('Tn.');
                } else {
                    myAlert('Pilih status pernikahan yang sesuai');
                    statusperkawinan.val('KAWIN');
                    namadepan.val('Tn.');
                }
            }

            if ($('#LKPasienM_jeniskelamin_1').is(':checked')) {
                if (statusperkawinan.val() !== 'DUDA') {
                    if (statusperkawinan.val() === 'KAWIN' || statusperkawinan.val() == 'JANDA' || statusperkawinan.val() == 'NIKAH SIRIH' || statusperkawinan.val() == 'POLIGAMI') {
                        namadepan.val('Ny.');
                    } else {
                        namadepan.val('Nn');
                    }
                } else {
                    myAlert('Pilih status pernikahan yang sesuai');
                    statusperkawinan.val('KAWIN');
                    namadepan.val('Ny.');
                }
            }

        }
    }

    function cekStatusPekerjaan(obj)
    {
        var statusperkawinan = $('#<?php echo CHtml::activeId($modPasien, 'statusperkawinan'); ?>');
        var namaDepan = $('#<?php echo CHtml::activeId($modPasien, 'namadepan'); ?>');
        var umur = $("#<?php echo CHtml::activeId($modPasien, 'umur'); ?>").val().substr(0, 2);
        var namaPekerjaan = obj.value;
        umur = parseInt(umur);

        if (namaDepan.val().length > 0)
        {
            if (umur < 15) {
                if (namaPekerjaan !== '12') {
                    if (namaPekerjaan !== '') {
                        myAlert('Pasien masih di bawah umur, coba cek ulang');
                    }
                    $(obj).val('');
                } else {
                    $(obj).val(namaPekerjaan);
                }
            } else {
                if (namaPekerjaan === '12') {
                    if (namaDepan.val() === 'Ny.') {
                        $(obj).val('9');
                    } else if (namaDepan.val() === 'Nn' && namaPekerjaan === '9') {
                        myAlert('Pasien belum menikah, coba cek ulang');
                        $(obj).val('');
                    } else {
                        $(obj).val('');
                    }
                    myAlert('Pilih pekerjaan yang tepat');
                } else {
                    if (namaPekerjaan === '9') {
                        if (namaDepan.val() !== 'Ny.') {
                            myAlert('Pasien seorang laki - laki, coba cek ulang');
                            $(obj).val('');
                        }
                    }
                }
            }
        } else {
            $(obj).val('');
            myAlert('Pilih gelar kehormatan terlebih dahulu');
        }

    }
    $('#LKPasienM_namadepan').click(function () {
//    myAlert('Klik');
        document.getElementById('LKPasienM_nama_pasien').focus();
    });

</script>