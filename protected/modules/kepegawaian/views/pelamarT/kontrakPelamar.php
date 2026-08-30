<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Kontrak Pegawai
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/fileupload/fileupload.js'); ?>
        <?php
        $this->breadcrumbs = array(
            'Informasi Pelamar' => array('admin'),
            'Create',
        );
        $this->widget('bootstrap.widgets.BootAlert');
        /*
     * start tidak tahu untuk apa
     */
        $random = rand(000000, 999999);
        $format = new MyFormatter;
        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pegawai-m-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#',
        ));
        ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php
        if (isset($_GET['pegawai_id'])) {
            Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
        }
        ?>

        <fieldset id="fieldsetPasien">

            <?php echo $form->errorSummary(array($modKontrak, $modPegawai)); ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-user"></i> Data Pribadi
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai, 'profilperusahaan_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList(
                                        $modPegawai,
                                        'profilrs_id',
                                        CHtml::listData($modPegawai->getRumahSakitItems(), 'profilrs_id', 'nama_rumahsakit'),
                                        array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')
                                    ); ?>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($modPegawai, 'nomorindukpegawai', array('class' => 'numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nomor Induk Pegawai', 'maxlength' => 18)); ?>

                            <div class="control-group">
                                <?php echo CHtml::label('No. Identitas', 'jenisidentitas', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modPegawai, 'jenisidentitas', LookupM::getItems('jenisidentitas'), array('empty' => '-- Pilih --', 'id' => 'jenisidentitas', 'style' => 'width:70px;', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                    <?php echo $form->textField($modPegawai, 'noidentitas', array('class' => 'numbers-only', 'empty' => '-- Pilih --', 'id' => 'noidentitas', 'style' => 'width:135px;', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Identitas Pegawai', 'maxlength' => 18)); ?>
                                </div>
                            </div>
                            <!--RND-4482 : Memisahkan Gelardepan,Gelar Belakang dengan Nama Pegawai-->
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai, 'gelardepan', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList(
                                        $modPegawai,
                                        'gelardepan',
                                        CHtml::listData($modPegawai->getGelarDepanItems(), 'lookup_id', 'lookup_name'),
                                        array(
                                            'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'style' => 'width:70px;'
                                        )
                                    ); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai, 'nama_pegawai', array('class' => 'control-label required')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPegawai, 'nama_pegawai', array('onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'class' => 'hurufs-only inputRequire all-caps', 'style' => 'width:208px;', 'placeholder' => 'Nama Lengkap Pegawai')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai, 'gelarbelakang_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList(
                                        $modPegawai,
                                        'gelarbelakang_id',
                                        CHtml::listData($modPegawai->getGelarBelakangItems(), 'gelarbelakang_id', 'gelarbelakang_nama'),
                                        array(
                                            'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'style' => 'width:70px;'
                                        )
                                    ); ?>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($modPegawai, 'nama_keluarga', array('class' => 'hurufs-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nama Keluarga Pegawai')); ?>

                            <?php echo $form->textFieldRow($modPegawai, 'tempatlahir_pegawai', array('class' => 'hurufs-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'placeholder' => 'Kota/Kabupaten Kelahiran')); ?>

                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai, 'tgl_lahirpegawai', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    //                    $modPegawai->tgl_lahirpegawai = (!empty($modPegawai->tgl_lahirpegawai) ? date("d/m/Y",strtotime($modPegawai->tgl_lahirpegawai)) : null);
                                    //                    $this->widget('MyDateTimePicker',array(
                                    //                                            'model'=>$modPegawai,
                                    //                                            'attribute'=>'tgl_lahirpegawai',
                                    //                                            'mode'=>'date',
                                    //                                            'options'=> array(
                                    //                                                    'dateFormat'=>Params::DATE_FORMAT,
                                    //                                                'showOn' => false,
                                    //                                                'maxDate' => 'd',
                                    //                                                'yearRange'=> "-150:+0",
                                    //                                            ),
                                    //                                            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                    //                                            ),
                                    //                    ));
                                    $modPegawai->tgl_lahirpegawai = $format->formatDateTimeForUser($modPegawai->tgl_lahirpegawai);
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modPegawai,
                                        'attribute' => 'tgl_lahirpegawai',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2', 'onclick' => "return $(this).focusNextInputField(event)"),
                                    ));
                                    $modPegawai->tgl_lahirpegawai = $format->formatDateTimeForDb($modPegawai->tgl_lahirpegawai);
                                    ?>
                                    <?php echo $form->error($modPegawai, 'tgl_lahirpegawai'); ?>
                                </div>
                            </div>

                            <?php
                            if (empty($modPegawai->jeniskelamin)) :
                                $modPegawai->jeniskelamin = 'LAKI-LAKI';
                            endif;

                            echo $form->radioButtonListInlineRow($modPegawai, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'inputRequire')); ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai, 'golongandarah', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList(
                                        $modPegawai,
                                        'golongandarah',
                                        LookupM::getItems('golongandarah'),
                                        array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span2')
                                    ); ?>
                                    <div class="radio inline">
                                        <div class="form-inline">
                                            <?php echo $form->radioButtonList($modPegawai, 'rhesus', LookupM::getItems('rhesus'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                        </div>
                                    </div>
                                    <?php echo $form->error($modPegawai, 'golongandarah'); ?>
                                    <?php echo $form->error($modPegawai, 'rhesus'); ?>
                                </div>
                            </div>
                            <?php echo $form->dropDownListRow(
                                $modPegawai,
                                'agama',
                                LookupM::getItems('agama'),
                                array(
                                    'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'class' => 'inputRequire'
                                )
                            ); ?>
                            <?php echo $form->dropDownListRow(
                                $modPegawai,
                                'suku_id',
                                CHtml::listData($modPegawai->getSukuItems(), 'suku_id', 'suku_nama'),
                                array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")
                            ); ?>
                            <?php echo $form->dropDownListRow($modPegawai, 'warganegara_pegawai', LookupM::getItems('warganegara'), array('onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 25, 'empty' => '-- Pilih --')); ?>
                            <?php echo $form->dropDownListRow(
                                $modPegawai,
                                'statusperkawinan',
                                LookupM::getItems('statusperkawinan'),
                                array(
                                    'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'class' => 'inputRequire'
                                )
                            ); ?>
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-file"></i> Alamat / Kontak
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php echo $form->textAreaRow($modPegawai, 'alamat_pegawai', array('rows' => 6, 'cols' => 50,  'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Alamat Lengkap Pegawai')); ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai, 'propinsi_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList(
                                        $modPegawai,
                                        'propinsi_id',
                                        CHtml::listData($modPegawai->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),
                                        array(
                                            'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'ajax' => array(
                                                'type' => 'POST',
                                                'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($modPegawai), '')),
                                                'update' => "#" . CHtml::activeId($modPegawai, 'kabupaten_id'),
                                            ),
                                            'onchange' => "",
                                        )
                                    ); ?>
                                    <?php echo $form->error($modPegawai, 'propinsi_id'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai, 'kabupaten_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList(
                                        $modPegawai,
                                        'kabupaten_id',
                                        CHtml::listData($modPegawai->getKabupatenItems($modPegawai->propinsi_id), 'kabupaten_id', 'kabupaten_nama'),
                                        array(
                                            'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'ajax' => array(
                                                'type' => 'POST',
                                                'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($modPegawai), '')),
                                                'update' => "#" . CHtml::activeId($modPegawai, 'kecamatan_id'),
                                            ),
                                            'onchange' => "",
                                        )
                                    ); ?>
                                    <?php echo $form->error($modPegawai, 'kabupaten_id'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai, 'kecamatan_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList(
                                        $modPegawai,
                                        'kecamatan_id',
                                        CHtml::listData($modPegawai->getKecamatanItems($modPegawai->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'),
                                        array(
                                            'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'ajax' => array(
                                                'type' => 'POST',
                                                'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($modPegawai))),
                                                'update' => "#" . CHtml::activeId($modPegawai, 'kelurahan_id'),
                                            ),
                                            'onchange' => "",
                                        )
                                    ); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('kelurahan', '', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php //echo $form->dropDownList($modPegawai,'kelurahan_id',CHtml::listData($modPegawai->getKelurahanItems($modPegawai->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
                                    //array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); 
                                    ?>
                                    <?php echo $form->dropDownList(
                                        $modPegawai,
                                        'kelurahan_id',
                                        CHtml::listData($modPegawai->getKelurahanItems($modPegawai->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
                                        array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")
                                    ); ?>
                                    <?php //echo $form->error($modPegawai, 'kelurahan_id'); 
                                    ?>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($modPegawai, 'garis_latitude', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            <?php echo $form->textFieldRow($modPegawai, 'garis_longitude', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            <div class="control-group">
                                <?php echo CHtml::label('No. Telp / Hp', 'nomorcontact', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPegawai, 'notelp_pegawai', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 15, 'style' => 'width:97px;text-align:right;', 'id' => 'nomorcontact', 'placeholder' => 'No. Telepon Pegawai')); ?>
                                    <?php echo ' / '; ?>
                                    <?php echo $form->textField($modPegawai, 'nomobile_pegawai', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 15, 'style' => 'width:97px;text-align:right;', 'id' => 'nomorcontact', 'placeholder' => 'No. Handphone Pegawai')); ?>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($modPegawai, 'alamatemail', array('onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'contoh: info@piinformasi.com')); ?>
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-file"></i> Data Lain-Lain
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php echo $form->dropDownListRow($modPegawai, 'statuskepemilikanrumah_id', CHtml::listData($modPegawai->getStatuskepemilikanrumahItems(), 'statuskepemilikanrumah_id', 'statuskepemilikanrumah_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            <?php echo $form->dropDownListRow($modPegawai, 'kemampuanbahasa', LookupM::getItems('kemampuanbahasa'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            <?php echo $form->dropDownListRow($modPegawai, 'warnakulit', LookupM::getItems('warnakulit'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'contoh : Sawo Matang')); ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai, 'tinggibadan', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPegawai, 'tinggibadan', array('onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100, 'class' => 'numbers-only span1', 'style' => 'text-align: right')); ?>
                                    <?php echo CHtml::label('cm', 'cm'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai, 'beratbadan', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPegawai, 'beratbadan', array('onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100, 'class' => 'numbers-only span1', 'style' => 'text-align: right')); ?>
                                    <?php echo CHtml::label('kg', 'kg'); ?>
                                </div>
                            </div>
                            <?php echo $form->textAreaRow($modPegawai, 'keterampilan', array('rows' => 3, 'cols' => 50,  'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keterampilan pegawai')); ?>
                            <?php echo $form->textAreaRow($modPegawai, 'keahlian', array('rows' => 3, 'cols' => 50,  'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keahlian pegawai')); ?>
                            <?php echo $form->textAreaRow($modPegawai, 'minat', array('rows' => 3, 'cols' => 50,  'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Minat pegawai')); ?>
                            <?php echo $form->textAreaRow($modPegawai, 'bakat', array('rows' => 3, 'cols' => 50,  'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Bakat pegawai')); ?>
                        </div>
                    </div>

                    <?php echo $this->renderPartial('_formKontrak', array('modPegawai' => $modPegawai, 'modKontrak' => $modKontrak, 'form' => $form)); ?>
                </div>

                <div class="col-sm-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-file"></i> Data Kepegawaian
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php echo $form->dropDownListRow(
                                $modPegawai,
                                'golonganpegawai_id',
                                CHtml::listData($modPegawai->getGolonganPegawaiItems(), 'golonganpegawai_id', 'golonganpegawai_nama'),
                                array(
                                    'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                )
                            ); ?>

                            <?php echo $form->dropDownListRow(
                                $modPegawai,
                                'pangkat_id',
                                CHtml::listData($modPegawai->getPangkatItems(), 'pangkat_id', 'pangkat_nama'),
                                array(
                                    'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                )
                            ); ?>

                            <?php echo $form->dropDownListRow(
                                $modPegawai,
                                'jabatan_id',
                                CHtml::listData($modPegawai->getJabatanItems(), 'jabatan_id', 'jabatan_nama'),
                                array(
                                    'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                )
                            ); ?>

                            <?php echo $form->dropDownListRow(
                                $modPegawai,
                                'kelompokpegawai_id',
                                CHtml::listData($modPegawai->getKelompokPegawaiItems(), 'kelompokpegawai_id', 'kelompokpegawai_nama'),
                                array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")
                            ); ?>

                            <?php echo $form->dropDownListRow(
                                $modPegawai,
                                'jenistenagamedis_id',
                                CHtml::listData($modPegawai->getJenisTenagaMedisItems(), 'jenistenagamedis_id', 'tenagamedis_nama'),
                                array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")
                            ); ?>

                            <?php echo $form->dropDownListRow(
                                $modPegawai,
                                'kategoripegawai',
                                LookupM::getItems('kategoripegawai'),
                                array('onchange' => "cekValidasiNIP(); return false;", 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")
                            ); ?>

                            <div class="control-group">
                                <?php echo CHtml::label('Kat. Pegawai Asal &nbsp; <span class="required">*</span>', '', array('class' => 'control-label required')); ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList(
                                        $modPegawai,
                                        'kategoripegawaiasal',
                                        LookupM::getItems('kategoriasalpegawai'),
                                        array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'required' => 'required')
                                    ); ?>
                                </div>
                            </div>
                            <?php echo $form->dropDownListRow(
                                $modPegawai,
                                'kelompokjabatan',
                                LookupM::getItems('kelompokjabatan'),
                                array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")
                            ); ?>

                            <?php echo $form->dropDownListRow(
                                $modPegawai,
                                'jeniswaktukerja',
                                LookupM::getItems('jeniswaktukerja'),
                                array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")
                            ); ?>

                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai, 'pendidikan_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList(
                                        $modPegawai,
                                        'pendidikan_id',
                                        CHtml::listData($modPegawai->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'),
                                        array(
                                            'onchange' => "setClearDropdownKelompokPegawai();", 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'ajax' => array(
                                                'type' => 'POST',
                                                'url' => $this->createUrl('/ActionDynamic/GetPendKualifikasi', array('encode' => false, 'model_nama' => get_class($modPegawai))),
                                                'update' => "#" . CHtml::activeId($modPegawai, 'pendkualifikasi_id'),
                                            )
                                        )
                                    ); ?>
                                    <?php echo $form->error($modPegawai, 'pendidikan_id'); ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai, 'pendkualifikasi_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList(
                                        $modPegawai,
                                        'pendkualifikasi_id',
                                        CHtml::listData($modPegawai->getPendKualifikasiItems($modPegawai->pendidikan_id), 'pendkualifikasi_id', 'pendkualifikasi_nama'),
                                        array(
                                            'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'ajax' => array(
                                                'type' => 'POST',
                                                'url' => $this->createUrl('/ActionDynamic/GetKelompokPegawai', array('encode' => false, 'model_nama' => get_class($modPegawai))),
                                                'update' => "#" . CHtml::activeId($modPegawai, 'kelompokpegawai_id'),
                                            )
                                        )
                                    ); ?>
                                    <?php echo $form->error($modPegawai, 'pendkualifikasi_id'); ?>
                                </div>
                            </div>

                            <div class='control-group'>
                                <?php echo CHtml::label('Tgl. Diterima &nbsp; <span class="required">*</span>', '', array('class' => 'control-label required')); ?>
                                <?php //echo $form->labelEx($modPegawai,'tglditerima', array('class'=>'required control-label')) 
                                ?>
                                <div class="controls">
                                    <?php
                                    //                    $modPegawai->tgl_lahirpegawai = (!empty($modPegawai->tgl_lahirpegawai) ? date("d/m/Y",strtotime($modPegawai->tglditerima)) : null);
                                    //                    $this->widget('MyDateTimePicker',array(
                                    //                                            'model'=>$modPegawai,
                                    //                                            'attribute'=>'tglditerima',
                                    //                                            'mode'=>'date',
                                    //                                            'options'=> array(
                                    //        //                                            'dateFormat'=>Params::DATE_FORMAT,
                                    //                                                'showOn' => false,
                                    //                                                'maxDate' => 'd',
                                    //                                                'yearRange'=> "-150:+0",
                                    //                                            ),
                                    //                                            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                                    //                                            ),
                                    //                    ));
                                    $modPegawai->tglditerima = $format->formatDateTimeForUser($modPegawai->tglditerima);
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modPegawai,
                                        'attribute' => 'tglditerima',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2 required', 'onclick' => "return $(this).focusNextInputField(event)", 'onchange' => 'getChangeTglTerima()'),
                                    ));
                                    $modPegawai->tglditerima = $format->formatDateTimeForDb($modPegawai->tglditerima);
                                    ?>
                                    <?php echo $form->error($modPegawai, 'tglditerima'); ?>
                                </div>
                            </div>
                            <div <?php echo $form->textFieldRow($modPegawai, 'surattandaregistrasi', array('placeholder' => 'Surat Tanda Registrasi', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?> <?php echo $form->textFieldRow($modPegawai, 'suratizinpraktek', array('placeholder' => 'Surat Izin Praktik', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?> <?php echo $form->textFieldRow($modPegawai, 'npwp', array('placeholder' => 'NPWP', 'class' => 'numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?> <?php echo $form->textFieldRow($modPegawai, 'no_rekening', array('placeholder' => 'No. Rekening', 'class' => 'numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?> <?php echo $form->textFieldRow($modPegawai, 'bank_no_rekening', array('placeholder' => 'Bank', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?> <?php echo $form->textFieldRow($modPegawai, 'gajipokok', array('placeholder' => '0', 'class' => 'integer2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100, 'style' => 'text-align:right;')); ?> <?php echo $form->dropDownListRow(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $modPegawai,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                'shift_id',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                CHtml::listData(ShiftM::model()->findAll("shift_aktif = true ORDER BY shift_nama ASC"), 'shift_id', 'shift_nama'),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ); ?> <div class="control-group">
                                <?php echo $form->labelEx($modPegawai, 'caraAmbilPhoto', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::radioButton('caraAmbilPhoto', false, array('value' => 'webCam', 'onclick' => 'caraAmbilPhotoJS(this)', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?><span style='font-size:11px' ;>Web Cam</span>
                                    <?php echo CHtml::radioButton('caraAmbilPhoto', true, array('value' => 'file', 'onclick' => 'caraAmbilPhotoJS(this)', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?><span style='font-size:11px' ;>File</span>
                                </div>
                            </div>
                            <div id="divCaraAmbilPhotoWebCam" style="display:none;">
                                <div class="controls">
                                    <div class="buttonWebcam2">
                                        <?php
                                        $random = rand(0000000000000000, 9999999999999999);
                                        $pathPhotoPegawaiTumbs = Params::pathPegawaiTumbsDirectory();
                                        $pathPhotoPegawai = Params::pathPegawaiDirectory();
                                        $urlAjaxSessionPhoto = '';
                                        ?>
                                        <?php echo $form->hiddenField($modPegawai, 'tempPhoto', array('readonly' => TRUE, 'value' => $random . '.jpg')); ?>
                                        <?php $onBeforeSnap = "document.getElementById('upload_results').innerHTML = '<h1>Proses Penyimpanan...</h1>';";
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
                                                //                'takesnapshot' => 'Ambil Foto',
                                                'freeze' => 'Ambil Foto',
                                                'reset' => 'Ulang',
                                                'takesnapshot' => 'Simpan',
                                            ),
                                            'onBeforeSnap' => $onBeforeSnap,
                                            'completionHandler' => $completionHandler
                                        ));
                                        ?>
                                        <!--<img src="<?php //echo Params::urlPegawaiDirectory()
                                                        ?>9680901rizky.jpg " id="gambar">-->

                                        <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="divCaraAmbilPhotoFile" style="display: block;">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="control-group">
                                        <?php echo $form->labelEx($modPegawai, 'photopegawai', array('class' => 'control-label', 'onkeyup' => "return $(this).focusNextInputField(event);")) ?>
                                        <div class="controls">
                                            <?php echo Chtml::activeFileField($modPegawai, 'photopegawai', array('maxlength' => 254, 'Hint' => 'Isi Jika Akan Menambahkan Logo', 'class' => 'fileupload-new')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width:90%;line-height:20px;margin-left:34.3%"><img src="<?php echo Params::urlPhotoPasienDirectory() . 'no_photo.jpeg'; ?>" /></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br><br>
                            <p class="help-block">Dibawah ini hanya diisi untuk dokter tamu atau jenis waktu kerja freelance</p>
                            <div class='control-group'>
                                <?php echo $form->labelEx($modPegawai, 'tglmasaaktifpeg', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $modPegawai->tglmasaaktifpeg = (!empty($modPegawai->tglmasaaktifpeg) ? MyFormatter::formatDateTimeForUser($modPegawai->tglmasaaktifpeg) : null);
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modPegawai,
                                        'attribute' => 'tglmasaaktifpeg',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            // 'showOn' => false,
                                            // 'yearRange'=> "-150:+0",
                                        ),
                                        'htmlOptions' => array(
                                            'placeholder' => '', 'class' => 'dtPicker2 span2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                        ),
                                    )); ?>
                                    <?php echo $form->error($modPegawai, 'tglmasaaktifpeg'); ?>
                                </div>
                            </div>
                            <div class='control-group'>
                                <?php echo $form->labelEx($modPegawai, 'tglmasaaktifpeg_sd', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $modPegawai->tglmasaaktifpeg_sd = (!empty($modPegawai->tglmasaaktifpeg_sd) ? MyFormatter::formatDateTimeForUser($modPegawai->tglmasaaktifpeg_sd) : null);
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modPegawai,
                                        'attribute' => 'tglmasaaktifpeg_sd',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            // 'showOn' => false,
                                            // 'yearRange'=> "-150:+0",
                                        ),
                                        'htmlOptions' => array(
                                            'placeholder' => '', 'class' => 'dtPicker2 span2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                        ),
                                    )); ?>
                                    <?php echo $form->error($modPegawai, 'tglmasaaktifpeg_sd'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <?php
                $disableSave = isset($_GET['idKaryawan']) ? true : false;
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('class' => 'btn btn-danger', 'id' => 'btn_submit', 'type' => 'button', 'onclick' => 'cekValiditas()', 'onKeypress' => 'return cekValiditas()', 'disabled' => $disableSave)
                ); ?>

                <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/kontrakPelamar'),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                ); ?>
            </div>
            <div class="row">
        </fieldset>
        <?php $this->endWidget(); ?>
    </div>
</div>

<?php
if (!empty($_GET['idPelamar'])) {
?><script type="text/javascript">
        setTimeout('usia()', 1000);
    </script><?php
            }
            $urlLamaKontrak = $this->createUrl('GetLamaKontrak');
            $idTagUmur = CHtml::activeId($modPegawai, 'umur');
            $js = <<< JS
function lamaKontrak()
{
    var tgl_awal = $('#KPKontrakKaryawanR_tglmulaikontrak').val();
    var tgl_akhir = $('#KPKontrakKaryawanR_tglakhirkontrak').val();
    if(tgl_awal != '' && tgl_akhir != ''){
        $.post("${urlLamaKontrak}",{tgl_awal:tgl_awal, tgl_akhir:tgl_akhir},
            function(data){
               $('#KPKontrakKaryawanR_lamakontrak').val(data.kontrak);
        },"json");
    }
}
function clearKabupaten()
{
    $('#KPPegawaiM_kabupaten_id').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}

JS;
            Yii::app()->clientScript->registerScript('form', $js, CClientScript::POS_HEAD);
                ?>
<?php echo $this->renderPartial('_jsFunctions', array('modPegawai' => $modPegawai)); ?>