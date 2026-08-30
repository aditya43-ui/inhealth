<?php

/**
 * view utama untuk masuk ke transaksi pencatatan pegawai
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0 
 * @link    <http://piindonesia.co.id>
 */
?>
<style>
    .yellow td {
        background: yellow !important;
        color: #333;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/fileupload/fileupload.js'); ?>
<?php 
$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
    'bootstrap-multiselect.js' => false,
);

/*
 * start tidak tahu untuk apa 
 */
$random = rand(000000, 999999);
/*
 * end tidak tahu untuk apa 
 */

$arrMenu = array();
//array_push($arrMenu,array('label'=>Yii::t('mds','Ubah').' Data Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;

$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapegawai-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this); cekSubmit();'
    ),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>
                            
<div class="row-fluid">

</div>
                            

<div class="row-fluid">
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pribadi</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->hiddenField($model, 'unit_perusahaan', array('class' => 'required numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nomor Induk Pegawai', 'maxlength' => 20, 'readonly', true, 'value' => LookupM::getNama('unit_perusahaan'))); ?>
                <?php // echo $form->textFieldRow($model,'nomorindukpegawai',array('onblur'=>'cekLengthNIP();','class'=>'required','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Nomor Induk Pegawai', 'maxlength' => 18, 'class'=>'numbers-only')); 
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('NIP <span style = "color:red;">*</span>', 'nomorindukpegawai', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php // echo $form->textField($model,'nomorindukpegawai',array('onblur'=>'cekLengthNIP();','class'=>'required numbers-only','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Nomor Induk Pegawai','maxlength'=>18)); 
                        ?>
                        <?php echo $form->textField($model, 'nomorindukpegawai', array('class' => 'required numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nomor Induk Pegawai', 'maxlength' => 18)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('No. Identitas', 'jenisidentitas', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'jenisidentitas', LookupM::getItems('jenisidentitas'), array('empty' => '-- Pilih --', 'id' => 'jenisidentitas', 'style' => 'width:70px;', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php echo $form->textField($model, 'noidentitas', array('empty' => '-- Pilih --', 'id' => 'noidentitas', 'style' => 'width:135px;', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Identitas Pegawai')); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label('Nama Pegawai <span style = "color:red;">*</span>', 'namapegawai', array('class' => 'control-label')); ////$form->labelEx($model,'nama_pegawai',array('class'=>'control-label required')); 
                    ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'gelardepan',
                            CHtml::listData($model->getGelarDepanItems(), 'lookup_name', 'lookup_name'),
                            array(
                                'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'style' => 'width:50px;'
                            )
                        ); ?>
                        <?php echo $form->textField($model, 'nama_pegawai', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'class' => 'inputRequire required', 'style' => 'width:135px;', 'placeholder' => 'Nama Lengkap Pegawai')); ?>
                        <?php echo $form->dropDownList(
                            $model,
                            'gelarbelakang_id',
                            CHtml::listData($model->getGelarBelakangItems(), 'gelarbelakang_id', 'gelarbelakang_nama'),
                            array(
                                'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'style' => 'width:70px;'
                            )
                        ); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'inisial', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'inisial', array('onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 12, 'class' => '', 'style' => 'width:208px;', 'placeholder' => 'Inisial')); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'nama_keluarga', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nama Keluarga Pegawai')); ?>

                <?php echo $form->textFieldRow($model, 'tempatlahir_pegawai', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'placeholder' => 'Kota/Kabupaten Kelahiran')); ?>

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
                            'htmlOptions' => array(
                                'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                        <?php echo $form->error($model, 'tgl_lahirpegawai'); ?>
                    </div>
                </div>

                <?php echo $form->radioButtonListInlineRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'inputRequire')); ?>

                <!--<div class="control-group">-->
                <?php // echo CHtml::label('Tinggi / Berat Badan','tinggiberatbadan',array('class'=>'control-label')); 
                ?>
                <!--<div class="controls">-->
                <?php // echo $form->textField($model,'tinggibadan',array('class'=>'span1 integer','style'=>'width:65px;','id'=>'tinggiberatbadan','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Tinggi Badan')) 
                ?>
                <?php // echo ' / '; 
                ?>
                <?php // echo $form->textField($model,'beratbadan',array('class'=>'span1 integer','style'=>'width:60px;','id'=>'tinggiberatbadan','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Berat Badan')) 
                ?>
                <!--</div>-->
                <!--</div>-->
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'golongandarah', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'golongandarah',
                            LookupM::getItems('golongandarah'),
                            array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span2')
                        ); ?>
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($model, 'rhesus', LookupM::getItems('rhesus'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($model, 'golongandarah'); ?>
                        <?php echo $form->error($model, 'rhesus'); ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow(
                    $model,
                    'agama',
                    LookupM::getItems('agama'),
                    array(
                        'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'class' => 'inputRequire'
                    )
                ); ?>

                <?php echo $form->dropDownListRow(
                    $model,
                    'suku_id',
                    CHtml::listData($model->getSukuItems(), 'suku_id', 'suku_nama'),
                    array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")
                ); ?>

                <div class="control-group">
                    <?php echo CHtml::label('Warga Negara <span style = "color:red;">*</span>', 'warganegara_pegawai', array('class' => 'control-label required')); ?>
                    <div class="controls">
                        <?php
                        if ($model->isNewRecord) {
                            $model->warganegara_pegawai = 'WNI';
                        }
                        // $model->warganegara_pegawai = 'INDONESIA';
                        echo $form->dropDownList($model, 'warganegara_pegawai', LookupM::getItems('warganegara'), array('onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 25, 'empty' => '-- Pilih --', 'onchange' => 'changeWargaNegara();')); ?>
                    </div>
                </div>

                <?php echo $form->dropDownListRow(
                    $model,
                    'statusperkawinan',
                    LookupM::getItems('statusperkawinan'),
                    array(
                        'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'class' => 'inputRequire'
                    )
                ); ?>


                <div class="control-group">
                    <?php echo CHtml::label('Kode PTKP', 'ptkp_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'ptkp_id', CHtml::listData($model->getPtkpItems(), 'ptkp_id', 'statusKawinTanggungan'), array('onchange' => 'namaPtkp(this.value);', 'empty' => '-- Pilih --', 'style' => 'width:135px;', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php echo $form->textField($model, 'ptkp_nama', array('style' => 'width:70px;', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>

                <?php echo $form->dropDownListRow($model, 'kode_objekpajak', LookupM::getItems('kodeobjekpajak'), array('class' => 'span2', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($model, 'kode_negara', array('class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php // echo $form->checkBoxRow($model,'pegawai_aktif', array('value'=>1, 'uncheckedValue'=>0)); 
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Alamat / Kontak
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->textAreaRow($model, 'alamat_pegawai', array('rows' => 6, 'cols' => 50,  'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Alamat Lengkap Pegawai')); ?>
                <?php echo $form->textAreaRow($model, 'alamat_pegawai_ktp', array('rows' => 6, 'cols' => 50,  'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Alamat Lengkap Pegawai')); ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'propinsi_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'propinsi_id',
                            CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),
                            array(
                                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($model))),
                                    'update' => "#" . CHtml::activeId($model, 'kabupaten_id'),
                                ),
                                'onchange' => "setClearDropdownKelurahan();setClearDropdownKecamatan();",
                            )
                        ); ?>
                        <?php echo $form->error($model, 'propinsi_id'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'kabupaten_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'kabupaten_id',
                            empty($model->kabupaten_id) ? array() : CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'),
                            array(
                                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($model))),
                                    'update' => "#" . CHtml::activeId($model, 'kecamatan_id'),
                                ),
                                'onchange' => "setClearDropdownKelurahan();",
                            )
                        ); ?>
                        <?php echo $form->error($model, 'kabupaten_id'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'kecamatan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'kecamatan_id',
                            empty($model->kabupaten_id) ? array() : CHtml::listData($model->getKecamatanItems($model->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'),
                            array(
                                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($model))),
                                    'update' => "#" . CHtml::activeId($model, 'kelurahan_id'),
                                ),
                                'onchange' => "",
                            )
                        ); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'kelurahan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'kelurahan_id',
                            empty($model->kelurahan_id) ? array() : CHtml::listData($model->getKelurahanItems($model->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
                            array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")
                        ); ?>
                        <?php echo $form->error($model, 'kelurahan_id'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'garis_latitude', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'garis_latitude', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php echo CHtml::htmlButton(
                            '<i class="entypo-search"></i>',
                            array(
                                'class' => 'btn btn-primary btn-location',
                                'rel' => 'tooltip',
                                'id' => 'yw2',
                                'title' => 'Klik untuk mencari Longitude & Latitude',
                            )
                        ); ?>
                    </div>
                </div>

                <?php echo $form->textFieldRow($model, 'garis_longitude', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

                <!--Extension location-picker latitude & longitude-->
                <?php
                $modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getstate('propinsi_id'));
                $latitude  = $modPropinsi->latitude;
                $longitude = $modPropinsi->longitude;

                $this->widget('ext.LocationPicker2.CoordinatePicker', array(
                    'model' => $model,
                    'latitudeAttribute' => 'garis_latitude',
                    'longitudeAttribute' => 'garis_longitude',
                    //optional settings
                    'editZoom' => 12,
                    'pickZoom' => 7,
                    'defaultLatitude' => $latitude,
                    'defaultLongitude' => $longitude,
                ));
                ?>


                <div class="control-group">
                    <?php echo CHtml::label('No. Telp / Hp', 'nomorcontact', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'notelp_pegawai', array('class' => 'span2 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 15, 'style' => 'width:97px;text-align:right;', 'id' => 'nomorcontact', 'placeholder' => 'No. Telepon Pegawai')); ?>
                        <?php echo ' / '; ?>
                        <?php echo $form->textField($model, 'nomobile_pegawai', array('class' => 'span2 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 15, 'style' => 'width:97px;;text-align:right;', 'id' => 'nomorcontact', 'placeholder' => 'No. Handphone Pegawai')); ?>
                    </div>
                </div>

                <?php echo $form->textFieldRow($model, 'alamatemail', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'contoh: info@piiinformasi.com')); ?>

            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data Lain - Lain
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->dropDownListRow($model, 'statuskepemilikanrumah_id', CHtml::listData($model->getStatuskepemilikanrumahItems(), 'statuskepemilikanrumah_id', 'statuskepemilikanrumah_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($model, 'kemampuanbahasa', LookupM::getItems('kemampuanbahasa'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($model, 'warnakulit', LookupM::getItems('warnakulit'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'contoh : Sawo Matang')); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tinggibadan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'tinggibadan', array('onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100, 'class' => 'numbers-only span1', 'style' => 'text-align: right')); ?>
                        <?php echo CHtml::label('cm', 'cm'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'beratbadan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'beratbadan', array('onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100, 'class' => 'numbers-only span1', 'style' => 'text-align: right')); ?>
                        <?php echo CHtml::label('kg', 'kg'); ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($model, 'keterampilan', array('rows' => 3, 'cols' => 50,  'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keterampilan pegawai')); ?>
                <?php echo $form->textAreaRow($model, 'keahlian', array('rows' => 3, 'cols' => 50,  'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keahlian pegawai')); ?>
                <?php echo $form->textAreaRow($model, 'minat', array('rows' => 3, 'cols' => 50,  'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Minat pegawai')); ?>
                <?php echo $form->textAreaRow($model, 'bakat', array('rows' => 3, 'cols' => 50,  'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Bakat pegawai')); ?>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Data <b>Kepegawaian</b>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'pendidikan_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $model,
                                'pendidikan_id',
                                CHtml::listData($model->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'),
                                array(
                                    'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('SetDropdownPendKualifikasi', array('encode' => false, 'model_nama' => get_class($model))),
                                        'update' => "#" . CHtml::activeId($model, 'pendkualifikasi_id'),
                                    ),
                                    'onchange' => "setClearDropdownKelompokPegawai();",
                                )
                            ); ?>
                            <?php echo $form->error($model, 'pendidikan_id'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'pendkualifikasi_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $model,
                                'pendkualifikasi_id',
                                CHtml::listData($model->getPendKualifikasiItems($model->pendidikan_id), 'pendkualifikasi_id', 'pendkualifikasi_nama'),
                                array(
                                    'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('SetDropdownKelompokPegawai', array('encode' => false, 'model_nama' => get_class($model))),
                                        'update' => "#" . CHtml::activeId($model, 'kelompokpegawai_id'),
                                    )
                                )
                            ); ?>
                            <?php echo $form->error($model, 'pendkualifikasi_id'); ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow(
                        $model,
                        'jabatan_id',
                        CHtml::listData($model->getJabatanItems(), 'jabatan_id', 'jabatan_nama'),
                        array(
                            'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        )
                    ); ?>
                    <?php echo $form->textFieldRow($model, 'levelakses', array('onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'placeholder' => 'Level Akses')); ?>
                    <?php echo $form->dropDownListRow(
                        $model,
                        'unitkerja_id',
                        CHtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'unitkerja_id', 'namaunitkerja'),
                        array(
                            'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        )
                    ); ?>
                    <?php echo $form->dropDownListRow($model,'kelompokpegawai_id',  CHtml::listData($model->getKelompokPegawaiItems(), 'kelompokpegawai_id', 'kelompokpegawai_nama'), 
                        array('onchange' => 'cekKalompokPegawai();', 'empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        
                    <?php echo $form->dropDownListRow($model,'jenistenagamedis_id',  CHtml::listData($model->getJenisTenagaMedisItems(), 'jenistenagamedis_id', 'tenagamedis_nama'), 
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    
                    <?php echo $form->dropDownListRow($model,'spesialissubspesialis_id',  CHtml::listData(SpesialissubspesialisM::model()->findAll('spesialissubspesialis_aktif = true order by spesialissubspesialis_nama'), 'spesialissubspesialis_id', 'spesialissubspesialis_nama'), 
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'spesialissubspesialis_id')); ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Kategori Pegawai <span style = "color:red;">*</span>', 'kategoripegawai', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $model,
                                'kategoripegawai',
                                LookupM::getItems('kategoripegawai'),
                                array('class' => 'required', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'cekValidasiNIP();cekKatKontrak(this); return false;')
                            ); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kategori Pegawai Asal<span style = "color:red;">*</span>', 'kategoripegawaiasal', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $model,
                                'kategoripegawaiasal',
                                LookupM::getItems('kategoriasalpegawai'),
                                array(
                                    'class' => 'required',    'empty' => '-- Pilih --',
                                    'onkeyup' => "return $(this).focusNextInputField(event)"
                                )
                            ); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Pegawai <span style = "color:red;">*</span>', 'jenispegawai', array('class' => 'control-label required')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $model,
                                'jenispegawai',
                                LookupM::getItems('jenispegawai'),
                                array('class' => 'required', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'changeJenisPegawai();')
                            ); ?>
                        </div>
                    </div>




                    
                    <?php echo $form->textFieldRow($model, 'kodegroup_komponen', array('onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 15, 'placeholder' => 'Kode Group Komponen')); ?>
                    <?php echo $form->dropDownListRow(
                        $model,
                        'kelompokjabatan',
                        LookupM::getItems('kelompokjabatan'),
                        array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")
                    ); ?>

                    <?php echo $form->dropDownListRow(
                        $model,
                        'jeniswaktukerja',
                        LookupM::getItems('jeniswaktukerja'),
                        array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")
                    ); ?>




                    <?php echo $form->textFieldRow($model, 'cabang_pegawai', array('onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'placeholder' => 'Cabang Pegawai')); ?>
                    <?php echo $form->textFieldRow($model, 'golongan', array('onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'placeholder' => 'Golongan Pegawai')); ?>
                    <?php echo $form->textFieldRow($model, 'grade', array('onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'placeholder' => 'Grade')); ?>
                    <div class='control-group'>
                        <?php echo CHtml::label('Tgl. Diterima <span style= "color:red;">*</span>', 'tglditerima', array('class' => 'required control-label')) ?>
                        <div class="controls">
                            <?php
                            $model->tglditerima = MyFormatter::formatDateTimeForUser($model->tglditerima);
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglditerima',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onclick' => "return $(this).focusNextInputField(event)", 'onchange' => 'getChangeTglTerima()'),
                            ));
                            $model->tglditerima = MyFormatter::formatDateTimeForDb($model->tglditerima);
                            ?>
                            <?php echo $form->error($model, 'tglditerima'); ?>
                        </div>
                    </div>
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'masa_str', array('class' => ' control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'masa_str',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    //'maxDate' => 'd',
                                ),
                                'clearable' => true,
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onclick' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model, 'surattandaregistrasi', array('onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?>
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'masa_sip', array('class' => ' control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'masa_sip',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    //'maxDate' => 'd',
                                ),
                                'clearable' => true,
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onclick' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model, 'suratizinpraktek', array('onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'nominal_sip', array('class' => 'integer2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100, 'style' => 'text-align: right;')); ?>
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'masa_tenagasehat', array('class' => ' control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'masa_tenagasehat',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    //'maxDate' => 'd',
                                ),
                                'clearable' => true,
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onclick' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div>
                    </div>

                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'masa_medis', array('class' => ' control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'masa_medis',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    //'maxDate' => 'd',
                                ),
                                'clearable' => true,
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onclick' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('NPWP <span style="color:red">*</span>', 'npwp', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'npwp', array('class' => 'required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tgl. Terdaftar NPWP <span style="color:red">*</span>', 'tglterdaftarnpwp', array('class' => 'control-label required')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglterdaftarnpwp',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    //'maxDate' => 'd',
                                ),
                                'clearable' => true,
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onclick' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Alamat NPWP <span style="color:red">*</span>', 'alamatnpwp', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textArea($model, 'alamatnpwp', array('rows' => 6, 'cols' => 50,  'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Alamat NPWP')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('No. BPJS Kesehatan', 'no_bpjs_kesehatan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'no_bpjs_kesehatan', array('class' => 'numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('No. BPJS Ketenagakerjaan', 'no_bpjs_ketenagakerjaan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'no_bpjs_ketenagakerjaan', array('class' => 'numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'tglmasuk_bpjs_ketenagakerjaan', array('class' => ' control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglmasuk_bpjs_ketenagakerjaan',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'clearable' => true,
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onclick' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'tglkeluar_bpjs_ketenagakerjaan', array('class' => ' control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglkeluar_bpjs_ketenagakerjaan',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    //'maxDate' => 'd',
                                ),
                                'clearable' => true,
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onclick' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model, 'no_rekening', array('class' => 'numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'atasnama', array('class' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                    <?php echo $form->dropDownListRow($model, 'bank_no_rekening', CHtml::listData(BankM::model()->findAll("bank_aktif = TRUE ORDER BY namabank ASC"), 'namabank', 'namabank'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'cabang_bank', array('class' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'nopeserta_asuransi', array('class' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 30)); ?>
                    <?php echo $form->textFieldRow($model, 'gajipokok', array('class' => 'integer2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 100, 'style' => 'text-align:right;')); ?>
                    
                    <div class="control-group">
                        <?php echo CHtml::label('Metode PPh 21 <span class="required">*</span>', 'metode_pph_21', array('class' => 'control-label inline required')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'metode_pph_21', LookupM::getItemsUrutan('metode_pph_21'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => false)); ?>
                        </div>
                    </div>
                    <div class="control-group" hidden>
                        <?php echo $form->labelEx($model, 'caraAmbilPhoto', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php //echo CHtml::radioButton('caraAmbilPhoto', false, array('value' => 'webCam', 'onclick' => 'caraAmbilPhotoJS(this)', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?><span style='font-size:11px' ;>Web Cam</span>
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

    //                                $this->widget('application.extensions.jpegcam.EJpegcam', array(
    //                                    'apiUrl' => 'index.php?r=photoWebCam/jpegcam.saveJpg&random=' . $random . '&pathTumbs=' . $pathPhotoPegawaiTumbs . '&path=' . $pathPhotoPegawai . '',
    //                                    'shutterSound' => false,
    //                                    'stealth' => true,
    //                                    'buttons' => array(
    //                                        'configure' => 'Konfigurasi',
    //                                        //                'takesnapshot' => 'Ambil Foto',
    //                                        'freeze' => 'Ambil Foto',
    //                                        'reset' => 'Ulang',
    //                                        'takesnapshot' => 'Simpan',
    //                                    ),
    //                                    'onBeforeSnap' => $onBeforeSnap,
    //                                    'completionHandler' => $completionHandler
    //                                ));
                                    ?>

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
                                    <?php echo $form->hiddenField($model, 'tempPhoto', array('readonly' => TRUE, 'value' => $random . '.jpg')); ?>
                                    <?php echo Chtml::activeFileField($model, 'photopegawai', array('maxlength' => 254, 'Hint' => 'Isi Jika Akan Menambahkan Logo', 'class' => 'fileupload-new', 'value' => $model->photopegawai)); ?>
                                </div>
                            </div>
                            <div class="control-group" style="padding-left:29.5%;">
                                <div class="controls">
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; line-height: 20px;"><img src="<?php echo $url_photopegawai; ?>" /></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'kodedokter_bpjs', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'kodedokter_bpjs', array('class'=>'span2 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                            <?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
                                array('onclick'=>'$("#dialogDokterBpjs").dialog("open");',
                                  'class'=>'btn btn-primary btn-location',
                                  'rel'=>"tooltip",
                                  'title'=>"Klik untuk menampilkan dokter bpjs")); ?>
                        </div>
                    </div>


                    
                    <br/><br/>
                    <p class="help-block">Dibawah ini hanya diisi untuk dokter tamu atau jenis waktu kerja freelance atau kategori pegawai kontrak</p>
                    <?php echo $form->textFieldRow($model, 'nokontrak', array('class' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'tglmasaaktifpeg', array('class' => 'control-label tglmasaaktif_label')) ?>
                        <div class="controls">
                            <?php
                            $model->tglmasaaktifpeg = (!empty($model->tglmasaaktifpeg) ? MyFormatter::formatDateTimeForUser($model->tglmasaaktifpeg) : null);
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglmasaaktifpeg',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'showOn' => false,
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '', 'class' => 'dtPicker2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            )); ?>
                            <?php echo $form->error($model, 'tglmasaaktifpeg'); ?>
                        </div>
                    </div>
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'tglmasaaktifpeg_sd', array('class' => 'control-label tglmasaaktifsd_label')) ?>
                        <div class="controls">
                            <?php
                            $model->tglmasaaktifpeg_sd = (!empty($model->tglmasaaktifpeg_sd) ? MyFormatter::formatDateTimeForUser($model->tglmasaaktifpeg_sd) : null);
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglmasaaktifpeg_sd',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'showOn' => false,
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '', 'class' => 'dtPicker2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            )); ?>
                            <?php echo $form->error($model, 'tglmasaaktifpeg_sd'); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label("File Kontrak", 'file_kontrak', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->fileField($model, 'file_kontrak', array('maxlength' => 150, 'Hint' => 'Isi Jika Akan Menambahkan File Kontrak')); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label('Keterangan Kontrak', 'keterangankontrak', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textArea($model, 'keterangankontrak', array('rows' => 6, 'cols' => 50,  'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keterangan Kontrak')); ?>
                        </div>
                    </div>
                </div>

            </div>
    </div>
</div>

    <div class="col-sm-12" style="margin-top: 17px;">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Ruangan
                </div>
            </div>
            <div class="panel-body">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="width:127px;text-align:right;">
                            <div class="control-group">
                                <?php echo CHtml::label('Ruangan / Unit kerja', 'ruangan', array('class' => 'control-label')); ?>
                            </div>
                        </td>
                        <td>
                            <?php
                            $arrRuanganPegawai = array();
                            foreach ($modRuanganPegawai as $tampilRuanganPegawai) {
                                $arrRuanganPegawai[] = isset($tampilRuanganPegawai->ruangan_id) ? $tampilRuanganPegawai->ruangan_id : null;
                            }
                            $this->widget(
                                'application.extensions.emultiselect.EMultiSelect',
                                array('sortable' => true, 'searchable' => true)
                            );
                            echo CHtml::dropDownList(
                                'ruangan_id[]',
                                $arrRuanganPegawai,
                                CHtml::listData(KPRuanganM::model()->findAll(array('order' => 'ruangan_nama', 'condition' => 'ruangan_aktif = true')), 'ruangan_id', 'ruangan_nama'),
                                array('multiple' => 'multiple', 'key' => 'ruangan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                            );
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-sm-12" style="margin-top: 17px;">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Shift Pegawai
                </div>
            </div>
            <div class="panel-body">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="width:127px;text-align:right;">
                            <div class="control-group">
                                <?php echo CHtml::label('Shift', 'shift', array('class' => 'control-label')); ?>
                            </div>
                        </td>
                        <td>
                            <?php
                            $arrShiftPegawai = array();
                            foreach ($modShiftPegawai as $tampilShiftPegawai) {
                                $arrShiftPegawai[] = isset($tampilShiftPegawai['shift_id']) ? $tampilShiftPegawai['shift_id'] : null;
                            }
                            $this->widget(
                                'application.extensions.emultiselect.EMultiSelect',
                                array('sortable' => true, 'searchable' => true)
                            );
                            echo CHtml::dropDownList(
                                'shift_id[]',
                                $arrShiftPegawai,
                                CHtml::listData(KPShiftM::model()->findAll(array('order' => 'shift_nama', 'condition' => 'shift_aktif = true')), 'shift_id', 'shiftJam'),
                                array('multiple' => 'multiple', 'key' => 'shift_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                            );
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-sm-12" style="display:none;">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Detail <b>Komponen Gaji</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table id="table-komgajipeg" class="table table-bordered dataTable">
                    <thead>
                        <th style="text-align:center;width:50px;">No</th>
                        <th style="text-align:center;">Komponen Gaji <span class="required">*</span></th>
                        <th style="text-align:center;">Tipe Komponen </th>
                        <th style="text-align:center;">Jenis</th>
                        <th style="text-align:center;width:15%;">Nilai <span class="required">*</span></th>
                        <th style="text-align:center;color:#FFF;"><?php echo CHtml::link('<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>', 'javascript:;', array('class' => 'btn btn-primary white', 'onclick' => 'tambahKomGajiPeg();', "data-toggle" => "tooltip", "data-placement" => "bottom", "title" => "", "data-original-title" => "Klik Icon ini, untuk menambahkan data <b>komponen gaji untuk pegawai</b>", "data-html" => true)); ?></th>
                    </thead>
                    <tbody>
                        <?php
                        /*
									$cek = KPKomponengajipegawaiM::model()->findByAttributes(array('pegawai_id' => $model->pegawai_id));
									
									if (!empty($cek)){										
										foreach ($modKomGajiDet as $det){
											$det->tipekomponen = $det->komponengaji->tipekomponengaji;
											$det->jeniskomponen = ($det->komponengaji->ispotongan == true)?"Potongan":"Gaji";
											$det->nilaigaji = number_format($det->nilaigaji,0,"",".");
											echo $this->renderPartial($this->path_view."_rowKomGaji",array('model'=>$det, 'i'=>0));
										}
									}
                                                                   * 
                                                                   */
                        ?>
                    </tbody>
                </table>

                <table id="table-delkomgajipeg" class="table table-bordered dataTable" hidden>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <div class="col-sm-12" style="margin-top: 17px;">
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onkeypress' => 'formSubmit(this,event);'));
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                '',
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('kepegawaian.views.tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $urlPrintKartuPegawai = Yii::app()->createUrl('print/kartuPegawai', array('idPegawai' => ''));
            ?>
        </div>
    </div>


<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokterBpjs',
    'options' => array(
        'title' => 'Pencarian Dokter BPJS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view.'_dialogDokterBpjs',array('model'=>$model));
$this->endWidget();
?>

<?php
$modKomGajiDet = new KPKomponengajipegawaiM;

$js = <<< JS

function caraAmbilPhotoJS(obj)
{
    caraAmbilPhoto=obj.value;
    
    if(caraAmbilPhoto=='webCam')
        {
          $('#divCaraAmbilPhotoWebCam').slideToggle(500);
          $('#divCaraAmbilPhotoFile').slideToggle(500);
            
        }
    else
        {
         $('#divCaraAmbilPhotoWebCam').slideToggle(500);
          $('#divCaraAmbilPhotoFile').slideToggle(500);
        }
} 

function simpanDataPegawai()
{
    var caraAmbilPhoto = $('#caraAmbilPhoto');
     if(caraAmbilPhoto=='webCam')
        {
          $('#upload').click();  
          do_upload();
          $('#sapegawai-m-form').submit();           
        }
     else
        {
          $('#sapegawai-m-form').submit();           
        }
}    

JS;
Yii::app()->clientScript->registerScript('caraAmbilPhoto212', $js, CClientScript::POS_BEGIN);
?>
<?php //$this->widget('UserTips',array('type'=>'create'));
?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>
<script>
    function changeWargaNegara() {
        var value = $('#<?php echo CHtml::activeId($model, 'warganegara_pegawai'); ?>').val();

        if (value == 'WNI') {
            $('#<?php echo CHtml::activeId($model, 'kode_negara'); ?>').prop('disabled', true);
            $('.kode_negara_label').removeClass('required');
            $('.kode_negara_label').html('Kode Negara');

        } else {
            $('#<?php echo CHtml::activeId($model, 'kode_negara'); ?>').prop('disabled', false);
            $('.kode_negara_label').addClass('required');
            $('.kode_negara_label').html('Kode Negara <span style = "color:red;">*</span>');
        }

    }

    function changeJenisPegawai() {
        var value = $('#<?php echo CHtml::activeId($model, 'jenispegawai'); ?>').val();
        $('.tglmasaaktif_label').addClass('required');
        $('.tglmasaaktif_label').html('Masa Aktif');

        $('.tglmasaaktifsd_label').addClass('required');
        $('.tglmasaaktifsd_label').html('Sampai Dengan');

        if (value == 'Tetap') {
            $('#<?php echo CHtml::activeId($model, 'tglmasaaktifpeg'); ?>').prop('disabled', true);
            $('#<?php echo CHtml::activeId($model, 'tglmasaaktifpeg'); ?>_date').hide();

            $('#<?php echo CHtml::activeId($model, 'tglmasaaktifpeg_sd'); ?>').prop('disabled', true);
            $('#<?php echo CHtml::activeId($model, 'tglmasaaktifpeg_sd'); ?>_date').hide();
        } else {
            $('#<?php echo CHtml::activeId($model, 'tglmasaaktifpeg'); ?>').prop('disabled', false);
            $('#<?php echo CHtml::activeId($model, 'tglmasaaktifpeg'); ?>_date').show();

            $('#<?php echo CHtml::activeId($model, 'tglmasaaktifpeg_sd'); ?>').prop('disabled', false);
            $('#<?php echo CHtml::activeId($model, 'tglmasaaktifpeg_sd'); ?>_date').show();

            if (value == 'Tidak Tetap') {
                $('.tglmasaaktif_label').addClass('required');
                $('.tglmasaaktif_label').html('Masa Aktif <span style = "color:red;">*</span>');

                $('.tglmasaaktifsd_label').addClass('required');
                $('.tglmasaaktifsd_label').html('Sampai Dengan <span style = "color:red;">*</span>');
            }
        }

    }

    function cekValidasiNIP() {
        if ($("#KPPegawaiM_kategoripegawai").val().trim().toLowerCase() == "pns") {
            //NIP
            $("#KPPegawaiM_nomorindukpegawai").addClass("required");
            $("label[for=KPPegawaiM_nomorindukpegawai]").append("<span class=required> *</span>");
            $("#KPPegawaiM_nomorindukpegawai").removeClass('error').addClass('inputnotrequired');

            //golongan
            $("#KPPegawaiM_golonganpegawai_id").addClass("required");
            $("label[for=KPPegawaiM_golonganpegawai_id]").append("<span class=required> *</span>");
            $("#KPPegawaiM_golonganpegawai_id").removeClass('error').addClass('inputnotrequired');

            //jabatan
            $("#KPPegawaiM_jabatan_id").addClass("required");
            $("label[for=KPPegawaiM_jabatan_id]").append("<span class=required> *</span>");
            $("#KPPegawaiM_jabatan_id").removeClass('error').addClass('inputnotrequired');

            //pangkat
            $("#KPPegawaiM_pangkat_id").addClass("required");
            $("label[for=KPPegawaiM_pangkat_id]").append("<span class=required> *</span>");
            $("#KPPegawaiM_pangkat_id").removeClass('error').addClass('inputnotrequired');

            //kelompok  jabatan
            $("#KPPegawaiM_kelompokjabatan").addClass("required");
            $("label[for=KPPegawaiM_kelompokjabatan]").append("<span class=required> *</span>");
            $("#KPPegawaiM_kelompokjabatan").removeClass('error').addClass('inputnotrequired');

        } else {
            $(".control-group").removeClass('error').addClass('notrequired');

            //nip
            $("#KPPegawaiM_nomorindukpegawai").removeClass("required");
            $("#KPPegawaiM_nomorindukpegawai").removeClass('error').addClass('inputnotrequired');
            $("label[for=KPPegawaiM_nomorindukpegawai]").find($("span[class=required]")).remove();
            $("label[for=KPPegawaiM_nomorindukpegawai]").removeClass('error required').addClass('notrequired');

            //golongan
            $("#KPPegawaiM_golonganpegawai_id").removeClass("required");
            $("#KPPegawaiM_golonganpegawai_id").removeClass('error').addClass('inputnotrequired');
            $("label[for=KPPegawaiM_golonganpegawai_id]").find($("span[class=required]")).remove();
            $("label[for=KPPegawaiM_golonganpegawai_id]").removeClass('error required').addClass('notrequired');

            //jabatan
            $("#KPPegawaiM_jabatan_id").removeClass("required");
            $("#KPPegawaiM_jabatan_id").removeClass('error').addClass('inputnotrequired');
            $("label[for=KPPegawaiM_jabatan_id]").find($("span[class=required]")).remove();
            $("label[for=KPPegawaiM_jabatan_id]").removeClass('error required').addClass('notrequired');

            //pangkat
            $("#KPPegawaiM_pangkat_id").removeClass("required");
            $("#KPPegawaiM_pangkat_id").removeClass('error').addClass('inputnotrequired');
            $("label[for=KPPegawaiM_pangkat_id]").find($("span[class=required]")).remove();
            $("label[for=KPPegawaiM_pangkat_id]").removeClass('error required').addClass('notrequired');

            //kelompok jabatan
            $("#KPPegawaiM_kelompokjabatan").removeClass("required");
            $("#KPPegawaiM_kelompokjabatan").removeClass('error').addClass('inputnotrequired');
            $("label[for=KPPegawaiM_kelompokjabatan]").find($("span[class=required]")).remove();
            $("label[for=KPPegawaiM_kelompokjabatan]").removeClass('error required').addClass('notrequired');
        }
    }

    function cekKalompokPegawai() {
        //var kelDokTetap = <?php echo Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP; ?>;
        //var kelDokGigi = <?php echo Params::KELOMPOKPEGAWAI_ID_DOKTER_GIGI; ?>;
        //var kelDokUmum = <?php echo Params::KELOMPOKPEGAWAI_ID_DOKTER_UMUM; ?>;
        //var kelDokSpe = <?php echo Params::KELOMPOKPEGAWAI_ID_DOKTER_SPESIALIS; ?>;
        var kelMedis = <?php echo Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK; ?>;
        var kelompok = $("#KPPegawaiM_kelompokpegawai_id").val();

        $(".spesialissubspesialis_id").attr("disabled", true);

        if (
            (kelompok == kelMedis)
        ) {
            $("#KPPegawaiM_suratizinpraktek").addClass("required");
            $("label[for=KPPegawaiM_suratizinpraktek]").append("<span class=required> *</span>");
            $("#KPPegawaiM_suratizinpraktek").removeClass('error').addClass('inputnotrequired');

            $("#KPPegawaiM_surattandaregistrasi").addClass("required");
            $("label[for=KPPegawaiM_surattandaregistrasi]").append("<span class=required> *</span>");
            $("#KPPegawaiM_surattandaregistrasi").removeClass('error').addClass('inputnotrequired');

            $(".spesialissubspesialis_id").attr("disabled", false);

            //masa berlaku surat izin registrasi
            // $("#<?php echo CHtml::activeId($model, 'masa_str') ?>").addClass("required");
            // $("label[for=<?php echo CHtml::activeId($model, 'masa_str') ?>]").append("<span class=required> *</span>");
            // $("#<?php echo CHtml::activeId($model, 'masa_str') ?>").removeClass('error').addClass('inputnotrequired');   

            //masa berlaku surat izin praktek
            //  $("#<?php echo CHtml::activeId($model, 'masa_sip') ?>").addClass("required");
            //  $("label[for=<?php echo CHtml::activeId($model, 'masa_sip') ?>]").append("<span class=required> *</span>");
            //  $("#<?php echo CHtml::activeId($model, 'masa_sip') ?>").removeClass('error').addClass('inputnotrequired');   

            //masa berlaku tenaga kesehatan
            //  $("#<?php echo CHtml::activeId($model, 'masa_tenagasehat') ?>").addClass("required");
            //  $("label[for=<?php echo CHtml::activeId($model, 'masa_tenagasehat') ?>]").append("<span class=required> *</span>");
            //  $("#<?php echo CHtml::activeId($model, 'masa_tenagasehat') ?>").removeClass('error').addClass('inputnotrequired');   

            //masa berlaku medis
            //  $("#<?php echo CHtml::activeId($model, 'masa_medis') ?>").addClass("required");
            //  $("label[for=<?php echo CHtml::activeId($model, 'masa_medis') ?>]").append("<span class=required> *</span>");
            //  $("#<?php echo CHtml::activeId($model, 'masa_medis') ?>").removeClass('error').addClass('inputnotrequired');   
        } else {
            $(".control-group").removeClass('error').addClass('notrequired');

            $("#KPPegawaiM_suratizinpraktek").removeClass("required");
            $("#KPPegawaiM_suratizinpraktek").removeClass('error').addClass('inputnotrequired');
            $("label[for=KPPegawaiM_suratizinpraktek]").find($("span[class=required]")).remove();
            $("label[for=KPPegawaiM_suratizinpraktek]").removeClass('error required').addClass('notrequired');

            $("#KPPegawaiM_surattandaregistrasi").removeClass("required");
            $("#KPPegawaiM_surattandaregistrasi").removeClass('error').addClass('inputnotrequired');
            $("label[for=KPPegawaiM_surattandaregistrasi]").find($("span[class=required]")).remove();
            $("label[for=KPPegawaiM_surattandaregistrasi]").removeClass('error required').addClass('notrequired');

            //masa berlaku surat izin registrasi        
            // $("#<?php echo CHtml::activeId($model, 'masa_str') ?>").removeClass("required");
            // $("#<?php echo CHtml::activeId($model, 'masa_str') ?>").removeClass('error').addClass('inputnotrequired');
            // $("label[for=<?php echo CHtml::activeId($model, 'masa_str') ?>]").find($("span[class=required]")).remove();         
            // $("label[for=<?php echo CHtml::activeId($model, 'masa_str') ?>]").removeClass('error required').addClass('notrequired');

            //masa berlaku surat izin praktek
            // $("#<?php echo CHtml::activeId($model, 'masa_sip') ?>").removeClass("required");
            // $("#<?php echo CHtml::activeId($model, 'masa_str') ?>").removeClass('error').addClass('inputnotrequired');
            // $("label[for=<?php echo CHtml::activeId($model, 'masa_sip') ?>]").find($("span[class=required]")).remove();         
            // $("label[for=<?php echo CHtml::activeId($model, 'masa_sip') ?>]").removeClass('error required').addClass('notrequired');

            //masa berlaku tenaga kesehatan
            // $("#<?php echo CHtml::activeId($model, 'masa_tenagasehat') ?>").removeClass("required");
            // $("#<?php echo CHtml::activeId($model, 'masa_tenagasehat') ?>").removeClass('error').addClass('inputnotrequired');
            // $("label[for=<?php echo CHtml::activeId($model, 'masa_tenagasehat') ?>]").find($("span[class=required]")).remove();         
            // $("label[for=<?php echo CHtml::activeId($model, 'masa_tenagasehat') ?>]").removeClass('error required').addClass('notrequired');

            //masa berlaku medis
            // $("#<?php echo CHtml::activeId($model, 'masa_medis') ?>").removeClass("required");
            // $("#<?php echo CHtml::activeId($model, 'masa_medis') ?>").removeClass('error').addClass('inputnotrequired');
            // $("label[for=<?php echo CHtml::activeId($model, 'masa_medis') ?>]").find($("span[class=required]")).remove();         
            // $("label[for=<?php echo CHtml::activeId($model, 'masa_medis') ?>]").removeClass('error required').addClass('notrequired');
        }
    }

    /** bersihkan dropdown kecamatan */
    function setClearDropdownKecamatan() {
        $("#<?php echo CHtml::activeId($model, "kecamatan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }
    /** bersihkan dropdown kelurahan */
    function setClearDropdownKelurahan() {
        $("#<?php echo CHtml::activeId($model, "kelurahan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }

    function setClearDropdownKelompokPegawai() {
        $("#<?php echo CHtml::activeId($model, "kelompokpegawai_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }

    function cekLengthNIP() {
        nip = $("#<?php echo CHtml::activeId($model, "nomorindukpegawai"); ?>").val();

        if (nip != '') {
            if (nip.length < 18) {
                myAlert("Maaf jumlah <b>NIP</b> tidak boleh kurang dari <b>18 digit</b>", 'Perhatian');
                return false;
            }
        }
    }

    function cekSubmit() {
        nip = $("#<?php echo CHtml::activeId($model, "nomorindukpegawai"); ?>").val();

        if (nip != '') {
            //        if (nip.length < 18){
            //            myAlert("Maaf jumlah <b>NIP</b> tidak boleh kurang dari <b>18 digit</b>",'Perhatian');
            //            return false;
            //        }else{
            return requiredCheck($("#sapegawai-m-form"));
            //        }
        } else {
            return requiredCheck($("#sapegawai-m-form"));
        }
    }

    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find(".no-urut").val(row + 1);
            $(this).find('span').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;

            jQuery('[data-toggle="tooltip"]').each(function(i, el) {
                var $this = jQuery(el),
                    placement = attrDefault($this, 'placement', 'top'),
                    trigger = attrDefault($this, 'trigger', 'hover'),
                    popover_class = $this.hasClass('tooltip-secondary') ? 'tooltip-secondary' : ($this.hasClass('tooltip-primary') ? 'tooltip-primary' : ($this.hasClass('tooltip-default') ? 'tooltip-default' : ''));

                $this.tooltip({
                    placement: placement,
                    trigger: trigger
                });

                $this.on('shown.bs.tooltip', function(ev) {
                    var $tooltip = $this.next();

                    $tooltip.addClass(popover_class);
                });
            });


        });
    }

    function hapusLookup(obj) {
        myConfirm(" Apakah Anda yakin menghapus komponen " + $(obj).text() + " ini ? ", "Perhatian !", function(r) {
            var id = $(obj).parents("tr").find(".komponenid").val();


            $(obj).parents('tr').detach();
            renameInputRow($("#table-komgajipeg"));

            $("#table-delkomgajipeg > tbody ").append("<tr><td><input type='text' name='deletekomponen[]' value='" + id + "'></td></tr>");
        });

    }


    function tambahKomGajiPeg() {
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowKomGaji', array('model' => $modKomGajiDet, 'i' => 0), true)); ?>'
        $('#table-komgajipeg').append(row);
        renameInputRow($("#table-komgajipeg"));
        $("#table-komgajipeg tr:last .integer2").maskMoney({
            "symbol": "",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": ".",
            "precision": 0
        });
    }

    function cekKomponen(obj) {
        var cekData = true;
        var nourut = $(obj).parents("tr").find(".no-urut").val();

        $('#table-komgajipeg > tbody > tr').each(function() {
            $(this).removeClass("yellow");

            var id = $(this).find(".komponengaji").val();
            var urut = $(this).find(".no-urut").val();

            if (id != '' && nourut != urut) {
                if (id == $(obj).val()) {
                    $(this).addClass("yellow");
                    cekData = false;
                }
            }
        });

        if (cekData == false) {
            myAlert(" Maaf komponen gaji ini sudah dipilih ");
            $(obj).parents("tr").removeClass("yellow");
            $(obj).val('');
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('getKomponenGaji') ?>',
                dataType: "json",
                data: {
                    id: $(obj).val()
                },
                success: function(data) {
                    if (data.sukses == 1) {
                        $(obj).parents("tr").find(".tipekomponen").val(data.tipekomponen);
                        $(obj).parents("tr").find(".jeniskomponen").val(data.jeniskomponen);
                    } else {
                        myAlert(data.pesan);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function cekKatKontrak(obj) {
        var kategoripegawai = $(obj).val();
        var lower = kategoripegawai.toLowerCase();

        if (lower == '<?php echo strtolower(Params::KATEGORI_PEGAWAI_KONTRAK) ?>') {
            //tanggal masa aktif
            $("#KPPegawaiM_tglmasaaktifpeg").addClass('required');
            $("label[for=KPPegawaiM_tglmasaaktifpeg]").append("<span class=required> *</span>");

            $("#KPPegawaiM_tglmasaaktifpeg_sd").addClass('required');
            $("label[for=KPPegawaiM_tglmasaaktifpeg_sd]").append("<span class=required> *</span>");



        } else {
            $("#KPPegawaiM_tglmasaaktifpeg").removeClass("required");
            $("label[for=KPPegawaiM_tglmasaaktifpeg]").find($("span[class=required]")).remove();
            $("#KPPegawaiM_tglmasaaktifpeg").removeClass("error");

            $("#KPPegawaiM_tglmasaaktifpeg_sd").removeClass("required");
            $("label[for=KPPegawaiM_tglmasaaktifpeg_sd]").find($("span[class=required]")).remove();
            $("#KPPegawaiM_tglmasaaktifpeg_sd").removeClass("error");
        }
    }

    function namaPtkp(obj) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getNamaPtkp') ?>',
            dataType: "json",
            data: {
                ptkp_id: obj
            },
            success: function(data) {
                if (data.sukses == 1) {
                    $('#KPPegawaiM_ptkp_nama').val(data.ptkpnama);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function getChangeTglTerima() {
        var tglterima = $('#<?php echo CHtml::activeId($model, 'tglditerima') ?>').val();
        $('#<?php echo CHtml::activeId($model, 'tglmasaaktifpeg') ?>').val(tglterima);
    }
    /**
     * javascript yang di running setelah halaman ready / load sempurna
     * posisi script ini harus tetap dibawah
     */
    $(document).ready(function() {
        //setClearDropdownKelurahan();
        //setClearDropdownKecamatan();
        //cekValidasiNIP();
        cekKalompokPegawai();
        renameInputRow($("#table-komgajipeg"));
    });
</script>