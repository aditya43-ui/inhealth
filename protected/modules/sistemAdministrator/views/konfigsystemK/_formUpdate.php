<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/ckeditor/ckeditor.js', CClientScript::POS_END); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakonfigsystem-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
    'focus' => '#' . CHtml::activeId($model, 'mr_lab'),
));

$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
    'bootstrap-multiselect.js' => false,
);
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>
<div class="row" id="backtop">
    <div class="col-sm-12" style="margin-bottom: 17px;">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title" id='konfig_rekam'>
                    <i class="fas fa-link"></i> Link Navigasi
                </div>
            </div>
            <div class="panel-body">
                <?php echo CHtml::link("<i class='entypo-link'></i > No Rekam Medis", '#konfig_rekam', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > No. Pendaftaran", '#konfig_pendaftaran', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > BPJS", '#konfig_bpjs', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Mandiri Inhealth", '#konfig_inhealth', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > KEMENKES", '#konfig_kemenkes', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > MIPS Scanner", '#konfig_mips', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Node JS", '#konfig_nodejs', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php // echo CHtml::link("<i class='entypo-link'></i > Telnet",'#konfig_telnet', array('class' => '','style'=>'margin:10px;')) 
                ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > HL-7 Broker", '#konfig_hl7', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Weasis Viewer", '#konfig_weasis', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Oviyam Viewer", '#konfig_oviyam', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Refresh", '#konfig_refresh', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Booking", '#konfig_booking', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Antrian", '#konfig_antrian', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Presentasi Rujukan", '#konfig_rujukan', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Keuangan dan Akuntansi", '#konfig_keu_akun', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php //echo CHtml::link("<i class='entypo-link'></i > Pelamar", '#konfig_pelamar', array('class' => '', 'style' => 'margin:10px;')) 
                ?>
                <?php //echo CHtml::link("<i class='entypo-link'></i > Email",'#konfig_email', array('class' => '','style'=>'margin:10px;')) 
                ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Sidik Jari Pasien", '#konfig_fingerpasien', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > WhatsApp", '#konfig_whatsapp', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Kepegawaian dan Penggajian", '#konfig_penggajian', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Komponen Jasa Dokter dan Perawat Bedah", '#konfig_komponenjasadokterbedah', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Akomodasi Rawat Inap", '#akomodasi_rawat_inap', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Metode Triage", '#metode_triage', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Lain - Lain", '#konfig_lain', array('class' => '', 'style' => 'margin:10px;')) ?>

                <?php echo CHtml::link("<i class='entypo-link'></i > Klinik Gigi", '#konfig_gigi', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Pengadaan (Gudang Umum, Gudang Farmasi, Gizi)", '#konfig_pengadaan', array('class' => '', 'style' => 'margin:10px;')) ?>

                <?php echo CHtml::link("<i class='entypo-link'></i > Validasi Regulasi BPJS", '#konfig_validasi_bpjs', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Pembuatan Nomor Kepegawaian", '#konfig_generatenomor_kepegawaian', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Pelabelan Nomor Kepegawaian", '#konfig_labelnomor_kepegawaian', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Pelabelan Kepegawaian", '#konfig_label_kepegawaian', array('class' => '', 'style' => 'margin:10px;')) ?>
                <?php echo CHtml::link("<i class='entypo-link'></i > Default Jenis Rujukan", '#jenisrujukan', array('class' => '', 'style' => 'margin:10px;')) ?>


            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="panel panel-success" id='konfig_rekam'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> No. Rekam Medis
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->textFieldRow($model, 'jmldigitrm', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 2, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_jenazah'))); ?>
                <?php echo $form->textFieldRow($model, 'normlama_min', array('class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('normlama_min'), 'placeholder' => '000000')); ?>
                <?php echo $form->textFieldRow($model, 'normlama_maks', array('class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('normlama_maks'), 'placeholder' => '000000')); ?>
                <?php echo $form->textFieldRow($model, 'mr_lab', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('mr_lab'))); ?>
                <?php echo $form->textFieldRow($model, 'mr_rad', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('mr_rad'))); ?>
                <?php echo $form->textFieldRow($model, 'mr_ibs', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('mr_ibs'))); ?>
                <?php echo $form->textFieldRow($model, 'mr_rehabmedis', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('mr_rehabmedis'))); ?>
                <?php echo $form->textFieldRow($model, 'mr_apotik', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('mr_apotik'))); ?>
                <?php echo $form->textFieldRow($model, 'mr_jenazah', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('mr_jenazah'))); ?>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>
        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-success" id='konfig_antrian'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Antrian
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'isantrian', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'isantrian', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isantrian'),)); ?>
                        </div>
                    </div>
                </div>
                <?php echo $form->checkBoxRow($model, 'isantrian', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isantrian'),)); ?>
                <?php echo $form->dropDownListRow($model, 'jenissuaraantrian', array('LAKI-LAKI' => 'LAKI-LAKI', 'PEREMPUAN' => 'PEREMPUAN'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('jenissuaraantrian'))); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'delaytombolantrian', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'delaytombolantrian', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('delaytombolantrian'))); ?> Detik
                    </div>
                </div>
                <?php echo $form->textAreaRow($model, 'running_text_display', array('rows' => 6, 'cols' => 50, 'class' => 'span3 autogrow', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('running_text_display'))); ?>
                <?php echo $form->textAreaRow($model, 'running_text_kiosk', array('rows' => 6, 'cols' => 50, 'class' => 'span3 autogrow', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('running_text_kiosk'))); ?>
                <?php echo $form->textAreaRow($model, 'running_text_kamar', array('rows' => 6, 'cols' => 50, 'class' => 'span3 autogrow', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('running_text_kamar'))); ?>

            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-success" id='konfig_rujukan'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Persentasi Rujukan
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->textFieldRow($model, 'persentasirujin', array('style' => 'text-align:right;', 'class' => 'span3 float2', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('persentasirujin'))); ?>
                <?php echo $form->textFieldRow($model, 'persentasirujout', array('style' => 'text-align:right;', 'class' => 'span3 float2', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('persentasirujout'))); ?>
                <?php echo $form->textFieldRow($model, 'pembulatanhargakasir', array('style' => 'text-align:right;', 'class' => 'span3 float2', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('pembulatanhargakasir'))); ?>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>
        <?php /*
        <div class="panel panel-success"  id='konfig_refresh'>
				<div class="panel-heading">
					<div class="panel-title">Refresh</div>
				</div>
				<div class="panel-body">
					<?php echo $form->textFieldRow($model, 'monitoringrefresh', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('monitoringrefresh'))); ?>
					<?php echo $form->textFieldRow($model,'refreshnotifikasi', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('refreshnotifikasi'))); ?>
				</div>
				<div class="panel-footer" style="text-align: right;">
					<?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas",'#backtop') ?>
				</div>
        </div>
         *
         */ ?>

        <div class="panel panel-success" id='konfig_booking'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Booking
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->textFieldRow($model, 'lamakonfbooking', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('lamakonfbooking'))); ?>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
            <?php //	echo $form->textFieldRow($model,'refreshnotifikasi',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200));  
            ?>
        </div>

        <div class="panel panel-success" id='konfig_gigi'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-tooth"></i> Klinik Gigi
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelex($model, 'klinikgigi_id', array('class' => 'control-label', 'label' => '')) ?>
                    <div class="controls">
                        <?php

                        $arrRuangan = array();
                        if (!empty($model->klinikgigi_id)) {
                            foreach ($model->klinikgigi_id as $ruanganPemakai) {
                                $arrRuangan[] = $ruanganPemakai;
                            }
                        }

                        $this->widget(
                            'application.extensions.emultiselect.EMultiSelect',
                            array('sortable' => true, 'searchable' => true)
                        );
                        echo CHtml::dropDownList(
                            'ruangan_id[]',
                            $arrRuangan,
                            CHtml::listData(RuanganM::model()->findAll(array('condition' => 'instalasi_id = ' . Params::INSTALASI_ID_RJ . ' and ruangan_aktif = TRUE', 'order' => 'ruangan_nama')), 'ruangan_id', 'ruangan_nama'),
                            array('multiple' => 'multiple', 'key' => 'ruangan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                        );
                        ?>
                        <?php echo $form->error($model, 'ruangan') ?>
                    </div>
                </div>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-success" id='konfig_pengadaan'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-cogs"></i> Pengadaan (Gudang Umum, Gudang Farmasi, Gizi)
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tampilhargagu', array('class' => 'control-label', 'style' => 'width: 200px')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'tampilhargagu', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('tampilhargagu'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tampilhargagf', array('class' => 'control-label', 'style' => 'width: 200px')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'tampilhargagf', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('tampilhargagf'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tampilhargagz', array('class' => 'control-label', 'style' => 'width: 200px')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'tampilhargagz', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('tampilhargagf'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'krngistokumum', array('class' => 'control-label', 'style' => 'width: 200px')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'krngistokumum', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('krngistokumum'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'krngistokgizi', array('class' => 'control-label', 'style' => 'width: 200px')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'krngistokgizi', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('krngistokgizi'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'isstokumumminus', array('class' => 'control-label', 'style' => 'width: 200px')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'isstokumumminus', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isstokumumminus'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'isstokgiziminus', array('class' => 'control-label', 'style' => 'width: 200px')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'isstokgiziminus', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isstokgiziminus'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'ispenerimaanlangsung', array('class' => 'control-label', 'style' => 'width: 200px')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'ispenerimaanlangsung', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('ispenerimaanlangsung'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'isfakturdigudang', array('class' => 'control-label', 'style' => 'width: 200px')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'isfakturdigudang', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isfakturdigudang'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tampilstokpenjualan', array('class' => 'control-label', 'style' => 'width: 200px')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'tampilstokpenjualan', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('tampilstokpenjualan'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'pesanmenudietotomatis', array('class' => 'control-label', 'style' => 'width: 200px')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'pesanmenudietotomatis', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('pesanmenudietotomatis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'is_notiftglkadaluarsa', array('class' => 'control-label', 'style' => 'width: 200px')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'is_notiftglkadaluarsa', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('is_notiftglkadaluarsa'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-success" id='konfig_lain'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Lain - Lain
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'iskarcis', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'iskarcis', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('iskarcis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'iskarcis', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('iskarcis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'karcisbarulama', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'karcisbarulama', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('karcisbarulama'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'karcisbarulama', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('karcisbarulama'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'printkartulsng', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'printkartulsng', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('printkartulsng'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'printkartulsng', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('printkartulsng'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'printkunjunganlsng', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'printkunjunganlsng', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('printkunjunganlsng'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'printkunjunganlsng', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('printkunjunganlsng'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'nama_huruf_capital', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'nama_huruf_capital', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nama_huruf_capital'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'nama_huruf_capital', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nama_huruf_capital'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'alamat_huruf_capital', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'alamat_huruf_capital', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('alamat_huruf_capital'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'alamat_huruf_capital', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('alamat_huruf_capital'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'dokterruangan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'dokterruangan', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('dokterruangan'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'dokterruangan', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('dokterruangan'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tindakanruangan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'tindakanruangan', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('tindakanruangan'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'tindakanruangan', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('tindakanruangan'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tindakankelas', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'tindakankelas', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('tindakankelas'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'tindakankelas', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('tindakankelas'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tgltransaksimundur', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'tgltransaksimundur', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('tgltransaksimundur'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'tgltransaksimundur', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('tgltransaksimundur'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>


                <?php //echo $form->checkBoxRow($model, 'krngistokgizi', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('krngistokgizi'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>


                <?php //echo $form->checkBoxRow($model, 'krngistokumum', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('krngistokumum'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>
                <?php //	  echo $form->checkBoxRow($model,'monitoringpresensi', array('onkeyup'=>"return $(this).focusNextInputField(event);")); 
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'akomodasiotomatis', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'akomodasiotomatis', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('akomodasiotomatis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'isonestopbilling', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'isonestopbilling', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isonestopbilling'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'isstatuspulang_otomatis', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'isstatuspulang_otomatis', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isstatuspulang_otomatis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'akomodasiotomatis', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('akomodasiotomatis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'iskartudgntemplate', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'iskartudgntemplate', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('iskartudgntemplate'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'iskartudgntemplate', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('iskartudgntemplate'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'is_api_gmap', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'is_api_gmap', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('is_api_gmap'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'mapdashboard', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'mapdashboard', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('mapdashboard'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'mapdashboard', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('mapdashboard'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'isbayarkekasirpenunjang', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo  $form->checkBox($model, 'isbayarkekasirpenunjang', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isbayarkekasirpenunjang'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'isbayarkekasirpenunjang', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isbayarkekasirpenunjang'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>


                <?php //echo $form->checkBoxRow($model, 'ispostingotomatis', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('ispostingotomatis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'issmsgateway', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'issmsgateway', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('ispostingotomatis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'ishelpusaktif', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'ishelpusaktif', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('ispostingotomatis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>





                <div class="control-group">
                    <?php echo $form->labelEx($model, 'suaranotifikasi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'suaranotifikasi', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('suaranotifikasi'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'is_ktpreader', array('class' => 'control-label', 'label' => 'KTP Reader')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'is_ktpreader', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('suaranotifikasi'), 'onkeyup' => "return $(this).focusNextInputField(event);"));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'isbydokter', array('class' => 'control-label', 'label' => 'By Dokter')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'isbydokter', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isbydokter'),)); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'isppds', array('class' => 'control-label', 'label' => 'PPDS')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'isppds', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isppds'),)); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'kelasrujukanpenunjang_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'kelasrujukanpenunjang_id', CHtml::listData(KelaspelayananM::model()->findAll('kelaspelayanan_aktif = true'), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'prefix_kode_surat', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'prefix_kode_surat') ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'alamatheadersurat', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'alamatheadersurat', array('rows' => 4, 'id' => 'alamatheadersurat')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'kopsurat_gizi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'kopsurat_gizi', array('rows' => 4, 'id' => 'kopsurat_gizi')) ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'footer_antrian', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'footer_antrian', 'toolbar' => 'mini', 'height' => '200px')) ?>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'issmsgateway', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('ispostingotomatis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-success" id='konfig_validasi_bpjs'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Validasi Regulasi BPJS
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'regulasibpjs_rd', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'regulasibpjs_rd', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('regulasibpjs_rd'))); ?>
                        <label style="width: 40px;">Hari</label>
                        <label style="width: 25px; text-align: right;">RD</label>
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'regulasibpjs_rd_isrd', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                        <label style="width: 25px; text-align: right;">RJ</label>
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'regulasibpjs_rd_isrj', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'regulasibpjs_rj', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'regulasibpjs_rj', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('regulasibpjs_rj'))); ?>
                        <label style="width: 40px;">Hari</label>
                        <label style="width: 25px; text-align: right;">RD</label>
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'regulasibpjs_rj_isrd', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                        <label style="width: 25px; text-align: right;">RJ</label>
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'regulasibpjs_rj_isrj', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="panel panel-success" id='konfig_generatenomor_kepegawaian'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pembuatan Nomor Kepegawaian
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label('Metode', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->radioButtonList($model, 'metode_nokepegawaian', array(
                            'Penginputan Manual' => 'Penginputan Manual',
                            'Otomatis Sistem' => 'Otomatis Sistem'
                        ), array('uncheckValue' => null, 'onchange' => 'setChangeMetodeGenNomorPeg()', 'class' => 'metode_nokepegawaian')); ?>
                    </div>
                </div>
                <div class="control-group manualpeggen">
                    <?php echo CHtml::label('Label Depan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'labeldepan_nokepegawaian', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'rel' => 'tooltip', 'title' => 'Label Depan')); ?>
                    </div>
                </div>
                <div class="control-group manualpeggen">
                    <?php echo CHtml::label('Jumlah Digit', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'jumlahdigit_nokepegawaian', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => 'Jumlah Digit')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success" id='konfig_labelnomor_kepegawaian'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pelabelan Nomor Kepegawaian
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label('Label', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'labelnomorpegawai',
                            'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('AutocompletePelabelanNomorKepegawaian') . '",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
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
                                        return false;
                                    }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Label', 'rel' => 'tooltip', 'title' => 'Label untuk mencari data pelabelan nomor kepegawaian',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3',
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success" id='konfig_label_kepegawaian'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pelabelan Kepegawaian
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label('Label', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'labelpegawai',
                            'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('AutocompletePelabelanKepegawaian') . '",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
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
                                        return false;
                                    }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Label', 'rel' => 'tooltip', 'title' => 'Label untuk mencari data pelabelan kepegawaian',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3',
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="panel panel-success" id='metode_triage'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Metode Triage Rawat Darurat
                </div>
            </div>
            <div class="panel-body">
                <div class="span4 controls">
                    <?php echo $form->radioButtonList($model, 'metode_triage', array(
                        'start' => 'Simple Triage And Rapid Treatment',
                        'ats' => 'Australian Triage Scale',
                        'esi' => 'Emergency Severity Index',
                        'wpsss' => 'Worthing Physiology Score System',

                    ), array('uncheckValue' => null, 'onchange' => 'setChangeMetodeTriage()', 'class' => 'metode_triage')); ?>
                </div>
            </div>
        </div>

        <div class="panel panel-success" id='metode_triage'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Bridging Farmasi
                </div>
            </div>
            <div class="panel-body">
                <div class="controls-group">
                    <label class="control-label">Bridging Host</label>
                    <div class="controls">
                        <?php echo $form->textField($model, 'bridging_host', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="col-sm-6">
        <div class="panel panel-success" id='konfig_pendaftaran'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Prefix No. Pendaftaran
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'no pendaftaran_rj', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nopendaftaran_rj', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_rj'))); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'no pendaftaran_ri', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nopendaftaran_ri', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_ri'))); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'no pendaftaran_gd', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nopendaftaran_gd', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('pendaftaran_gd'))); ?>
                    </div>
                </div>

                <?php /*
					<div class="control-group">
						<?php echo $form->labelEx($model, 'no pendaftaran_lab', array('class' => 'control-label')) ?>
						<div class="controls">
							<?php echo $form->textField($model, 'nopendaftaran_lab', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_lab'))); ?>
						</div>
					</div>
					<div class="control-group">
						<?php echo $form->labelEx($model, 'no pendaftaran_rad', array('class' => 'control-label')) ?>
						<div class="controls">
							<?php echo $form->textField($model, 'nopendaftaran_rad', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_rad'))); ?>
						</div>
					</div>
					<div class="control-group">
						<?php echo $form->labelEx($model, 'no pendaftaran_ibs', array('class' => 'control-label')) ?>
						<div class="controls">
							<?php echo $form->textField($model, 'nopendaftaran_ibs', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_ibs'))); ?>
						</div>
					</div>
					<div class="control-group">
						<?php echo $form->labelEx($model, 'no pendaftaran_rehabmedis', array('class' => 'control-label')) ?>
						<div class="controls">
							<?php echo $form->textField($model, 'nopendaftaran_rehabmedis', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_rehabmedis'))); ?>
						</div>
					</div>
					<div class="control-group">
						<?php echo $form->labelEx($model, 'no pendaftaran_jenazah', array('class' => 'control-label')) ?>
						<div class="controls">
							<?php echo $form->textField($model, 'nopendaftaran_jenazah', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_jenazah'))); ?>
						</div>
					</div>
                     *
                     */ ?>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <!-- BPJS -->
        <div class="panel panel-success" id='konfig_bpjs'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> BPJS
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'isbridging', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'isbridging', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isbridging'),)); ?>
                        </div>
                    </div>
                </div>

                <?php echo $form->radioButtonListRow($model, 'jenisrujukan', array(
                    '1' => 'PCare',
                    '2' => 'Rumah Sakit',
                ), array('uncheckValue' => null, 'onchange' => 'setChangeRujukan()', 'id' => 'jenisrujukan', 'class' => 'jenisrujukan')); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'bpjs_v2', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'bpjs_v2', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isbridging'),)); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'antreanonlinewsbpjs', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'antreanonlinewsbpjs', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isbridging'),)); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'bpjs_terenkripsi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'bpjs_terenkripsi', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isbridging'),)); ?>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Vklaim
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $form->textFieldRow($model, 'bpjs_uid', array('class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => 'Consumer ID yang diberikan BPJS untuk rumah sakit')); ?>
                        <?php echo $form->textFieldRow($model, 'bpjs_secret', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => 'Consumer Secret yang diberikan BPJS untuk rumah sakit')); ?>
                        <?php echo $form->textFieldRow($model, 'bpjs_userkey', array('onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('bpjs_userkey'))); ?>
                        <?php echo $form->textFieldRow($model, 'bpjs_host', array('placeholder' => 'http://192.168.1.1', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => 'Host/ alamat server bridging BPJS')); ?>
                        <?php echo $form->textFieldRow($model, 'bpjs_port', array('placeholder' => '3000', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => 'Port server bridging BPJS')); ?>
                        <?php echo $form->textFieldRow($model, 'servicename_bpjs', array('class' => 'span3', 'rel' => 'tooltip', 'title' => 'Service Name Vklaim BPJS')); ?>
                    </div>
                </div>

                <!-- Antrian -->
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Antrean Online
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $form->textFieldRow($model, 'antreanonline_uid', array('class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => 'Consumer ID Antrean yang diberikan BPJS untuk rumah sakit')); ?>
                        <?php echo $form->textFieldRow($model, 'antreanonline_secret', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => 'Consumer Secret Antrean yang diberikan BPJS untuk rumah sakit')); ?>
                        <?php echo $form->textFieldRow($model, 'antreanonline_userkey', array('onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('antreanonline_userkey'))); ?>
                        <?php echo $form->textFieldRow($model, 'antreanonline_host', array('placeholder' => 'http://192.168.1.1', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => 'Host/ alamat server Antrean Online')); ?>
                        <?php echo $form->textFieldRow($model, 'antreanonline_port', array('placeholder' => '3000', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => 'Port server Antrean Online')); ?>
                        <?php echo $form->textFieldRow($model, 'antreanonline_service', array('class' => 'span3', 'rel' => 'tooltip', 'title' => 'Service Name Antrean Online')); ?>
                        <?php echo $form->textFieldRow($model, 'antreanonline_kodefaskes', array('class' => 'span3', 'rel' => 'tooltip', 'title' => 'Kode Faskes Antrian Online')); ?>
                        <?php echo $form->textFieldRow($model, 'antreanonline_url', array('class' => 'span3', 'rel' => 'tooltip', 'title' => 'Url Antrean Online')); ?>
                    </div>
                </div>

                <?php echo $form->textFieldRow($model, 'bpjs_inacbg_path', array('class' => 'span3', 'rel' => 'tooltip', 'title' => 'Host INA-CBG untuk Bridging BPJS')); ?>
                <?php echo $form->textFieldRow($model, 'bpjs_inacbg_key', array('class' => 'span3', 'rel' => 'tooltip', 'title' => 'Key-INACBG untuk Bridging BPJS')); ?>
                <?php echo $form->textFieldRow($model, 'bpjs_aplicare_host', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => 'Host / Alamat Server Aplicare untuk Bridging BPJS')); ?>

                <?php //echo $form->checkBoxRow($model, 'isbridging', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isbridging'),)); 
                ?>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>
        <!-- AKHIR BPJS -->

        <div class="panel panel-primary panel-success" id='konfig_inhealth'>
            <div class="panel-heading">
                <div class="panel-title">Mandiri Inhealth</div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'bridging_inhealth', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'bridging_inhealth', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('bridging_inhealth'),)); ?>
                        </div>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'api_inhealth', array('placeholder' => 'http://development.inhealth.co.id/pelkesws2/', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('api_inhealth'))); ?>
                <?php echo $form->textFieldRow($model, 'token_inhealth', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('token_inhealth'))); ?>
                <?php echo $form->textFieldRow($model, 'provider_inhealth', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('provider_inhealth'))); ?>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-success" id='konfig_kemenkes'>
            <div class="panel-heading">
                <div class="panel-title">
                    Kemenkes
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'is_kemenkes', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'is_kemenkes', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('is_kemenkes'),)); ?>
                        </div>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'kemenkes_idrs', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('kemenkes_idrs'))); ?>
                <?php echo $form->textFieldRow($model, 'kemenkes_password', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('kemenkes_password'))); ?>
                <?php echo $form->textFieldRow($model, 'kemenkes_host', array('placeholder' => 'http://192.168.1.1', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('kemenkes_host'))); ?>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-success" id='konfig_mips'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> MIPS Scanner
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'is_mips', array('class' => 'control-label', 'label' => 'MIPS Aktif')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'is_mips', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('is_kemenkes'),)); ?>
                        </div>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'mips_host', array('placeholder' => 'http://192.168.1.1:80', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('kemenkes_host'))); ?>
                <?php echo $form->textFieldRow($model, 'mips_password', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('kemenkes_password'))); ?>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-success" id='konfig_nodejs'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Node Js
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'is_nodejsaktif', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'is_nodejsaktif', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('is_nodejsaktif'),)); ?>
                        </div>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'nodejs_host', array('placeholder' => 'http://192.168.1.1', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nodejs_host'))); ?>
                <?php echo $form->textFieldRow($model, 'nodejs_port', array('placeholder' => '3000', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nodejs_port'))); ?>

                <?php //echo $form->checkBoxRow($model, 'is_nodejsaktif', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('is_nodejsaktif'),)); 
                ?>
                <!-- <div class="control-group">
                    <?php //echo $form->labelEx($model, 'chat', array('class' => 'control-label')) 
                    ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php //echo $form->checkBox($model, 'chat', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('chat'),)); 
                            ?>
                        </div>
                    </div>
                </div> -->
                <?php //echo $form->checkBoxRow($model, 'chat', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('chat'),)); 
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'notifikasi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'notifikasi', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('notifikasi'),)); ?>
                            <?php //echo $form->checkBoxRow($model, 'notifikasi', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('notifikasi'),)); 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>
        <?php /*
		<div class="panel panel-success" id='konfig_telnet'>
			<div class="panel-heading">
				<div class="panel-title">Telnet</div>
			</div>
			<div class="panel-body">
				<div class="control-group">
					<?php echo $form->labelEx($model,'is_telnetaktif', array('class' => 'control-label')) ?>
					<div class="controls">
						<div class="make-switch">
							<?php  echo $form->checkBox($model, 'is_telnetaktif', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('is_telnetaktif'),)); ?>
							<?php //echo $form->checkBoxRow($model, 'is_telnetaktif', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('is_telnetaktif'),)); ?>
						</div>
					</div>
				</div>
				<?php echo $form->textFieldRow($model, 'telnet_host', array('placeholder' => '192.168.1.1', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('telnet_host'))); ?>
				<?php echo $form->textFieldRow($model, 'telnet_port', array('placeholder' => '6000', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('telnet_port'))); ?>
			</div>
			<div class="panel-footer" style="text-align: right;">
					<?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas",'#backtop') ?>
				</div>
		</div>
        */ ?>

        <div class="panel panel-success" id='konfig_hl7'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> HL-7 broker
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'hl7broker_aktif', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'hl7broker_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('hl7broker_aktif'),)); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'hl7broker_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('hl7broker_aktif'),)); 
                ?>
                <?php echo $form->textFieldRow($model, 'hl7broker_host', array('placeholder' => '192.168.1.1', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('hl7broker_host'))); ?>
                <?php echo $form->textFieldRow($model, 'hl7broker_port', array('placeholder' => '25750', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('hl7broker_port'))); ?>
                <?php echo $form->textFieldRow($model, 'hl7broker_api_url', array('placeholder' => 'localhost/api-hl7/backend/web/index.php?r=', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('hl7broker_port'))); ?>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-success" id='konfig_weasis'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Weasis Viewer
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'weasis_aktif', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'weasis_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('weasis_aktif'),)); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'hl7broker_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('hl7broker_aktif'),)); 
                ?>
                <?php echo $form->textFieldRow($model, 'weasis_host', array('placeholder' => 'http://192.168.1.1', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('weasis_host'))); ?>
                <?php echo $form->textFieldRow($model, 'weasis_port', array('placeholder' => '8080', 'class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('weasis_port'))); ?>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>
        <div class="panel panel-primary panel-success" id='konfig_oviyam'>
            <div class="panel-heading">
                <div class="panel-title">Oviyam Viewer</div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'oviyam_aktif', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'oviyam_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('oviyam_aktif'),));  ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->checkBoxRow($model, 'hl7broker_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('hl7broker_aktif'),)); 
                ?>
                <?php echo $form->textFieldRow($model, 'oviyam_host', array('placeholder' => 'http://192.168.1.1', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('oviyam_host'))); ?>
                <?php echo $form->textFieldRow($model, 'oviyam_port', array('placeholder' => '8080', 'class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('oviyam_port'))); ?>
                <?php echo $form->textFieldRow($model, 'oviyam_server', array('placeholder' => 'PACSServer', 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('oviyam_server'))); ?>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-success" id='konfig_keu_akun'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Keuangan dan Akuntansi
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'isjurnalotomatis', array('class' => 'control-label', 'label' => 'Penjurnalan Otomatis')) ?>
                            <div class="controls">
                                <div class="make-switch">
                                    <?php echo $form->checkBox($model, 'isjurnalotomatis', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isjurnalotomatis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'ispostingotomatis', array('class' => 'control-label', 'label' => 'Posting Otomatis')) ?>
                            <div class="controls">
                                <div class="make-switch">
                                    <?php echo $form->checkBox($model, 'ispostingotomatis', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('ispostingotomatis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Maksimum Level Rekening', 'levelrekeninglast', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'levelrekeninglast', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => 'Maksimum Level Rekening')); ?>
                            </div>
                        </div>
                        <!-- <div class="control-group">
                            <?php //echo $form->labelEx($model, 'jatuhtempoklaim', array('class' => 'control-label')) 
                            ?>
                            <div class="controls">
                                <?php //echo $form->textField($model, 'jatuhtempoklaim', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('jatuhtempoklaim'))); 
                                ?> Hari
                            </div>
                        </div>
                        <div class="control-group">
                            <?php //echo $form->labelEx($model, 'jatuhtempotagihan', array('class' => 'control-label')) 
                            ?>
                            <div class="controls">
                                <?php //echo $form->textField($model, 'jatuhtempotagihan', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('jatuhtempotagihan'))); 
                                ?> Hari
                            </div>
                        </div> -->
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('ID Tindakan Luar RS', 'tindakanluarrs', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'tindakanluarrs', array('class' => 'span1', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => 'Id Tindakan Luar RS')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-success" id='konfig_penggajian'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-users"></i> Kepegawaian dan Penggajian
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'cutoff_penggajian', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'cutoff_penggajian', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('cutoff_penggajian'))); ?> Hari
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'lama_cuti', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'lama_cuti', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('lama_cuti'))); ?> Hari
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'masaberlaku_pelamar_hr', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'masaberlaku_pelamar_hr', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('masaberlaku_pelamar_hr'))); ?> Hari
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'ispajakgajipegawai', array('class' => 'control-label', 'label' => 'Hitung Otomatis Pajak Pegawai')) ?>
                            <div class="controls">
                                <div class="make-switch">
                                    <?php echo $form->checkBox($model, 'ispajakgajipegawai', array('rel' => 'tooltip', 'title' => 'Hitung Otomatis Pajak Pegawai', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'ispajakdokter', array('class' => 'control-label', 'label' => 'Hitung Otomatis Pajak Dokter')) ?>
                            <div class="controls">
                                <div class="make-switch">
                                    <?php echo $form->checkBox($model, 'ispajakdokter', array('rel' => 'tooltip', 'title' => 'Hitung Otomatis Pajak Dokter', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-primary panel-success" id='konfig_komponenjasadokterbedah'>
            <div class="panel-heading">
                <div class="panel-title">Konfigurasi Komponen Jasa Dokter dan Perawat Bedah</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'jasaoperator_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'jasaoperator_id', CHtml::listData(KomponentarifM::model()->findAll('komponentarif_aktif = true order by komponentarif_nama asc'), 'komponentarif_id', 'komponentarif_nama'), array('class' => 'span2', 'empty' => 'Pilih')) ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'jasaasoperator_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'jasaasoperator_id', CHtml::listData(KomponentarifM::model()->findAll('komponentarif_aktif = true order by komponentarif_nama asc'), 'komponentarif_id', 'komponentarif_nama'), array('class' => 'span2', 'empty' => 'Pilih')) ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'jasaanestesi_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'jasaanestesi_id', CHtml::listData(KomponentarifM::model()->findAll('komponentarif_aktif = true order by komponentarif_nama asc'), 'komponentarif_id', 'komponentarif_nama'), array('class' => 'span2', 'empty' => 'Pilih')) ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'jasaperanestesi_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'jasaperanestesi_id', CHtml::listData(KomponentarifM::model()->findAll('komponentarif_aktif = true order by komponentarif_nama asc'), 'komponentarif_id', 'komponentarif_nama'), array('class' => 'span2', 'empty' => 'Pilih')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'jasaperruangpulih_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'jasaperruangpulih_id', CHtml::listData(KomponentarifM::model()->findAll('komponentarif_aktif = true order by komponentarif_nama asc'), 'komponentarif_id', 'komponentarif_nama'), array('class' => 'span2', 'empty' => 'Pilih')) ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'jasaperinstrument_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'jasaperinstrument_id', CHtml::listData(KomponentarifM::model()->findAll('komponentarif_aktif = true order by komponentarif_nama asc'), 'komponentarif_id', 'komponentarif_nama'), array('class' => 'span2', 'empty' => 'Pilih')) ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'jasapersirkuler_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'jasapersirkuler_id', CHtml::listData(KomponentarifM::model()->findAll('komponentarif_aktif = true order by komponentarif_nama asc'), 'komponentarif_id', 'komponentarif_nama'), array('class' => 'span2', 'empty' => 'Pilih')) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-success" id='konfig_fingerpasien'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Sidik Jari Pasien
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'finger_pasien_hostserver', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'finger_pasien_hostserver', array('class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('finger_pasien_hostserver'))); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'finger_pasien_portserver', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'finger_pasien_portserver', array('class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('finger_pasien_portserver'))); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("", "", array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->checkBox($model, 'is_finger_pasien', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isbridging'),)); ?> <label>Aktif</label>
                    </div>
                </div>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-success" id='konfig_antrian'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-image"></i> Logo Layar Antrian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->labelEx($model, 'logolayarantrian', array('class' => 'control-label', 'onkeypress' => "return nextFocus(this,event,'','')")) ?>
                <?php if (!empty($model->logolayarantrian)) { ?>
                    <img src="<?php echo Params::urlProfilRSDirectory() . $model->logolayarantrian ?> " style="width: 20%;padding:10px;display: block; background-color: #eee;">
                <?php
                } else {
                    echo "<span style='padding:10px 25px;'> Logo Antrian belum di-set</span>";
                }
                ?>
                <div class="controls">
                    <?php echo Chtml::activeFileField($model, 'logolayarantrian', array('maxlength' => 500, 'hint' => 'Isi Jika Akan Menambahkan Gambar')); ?>
                </div>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-primary panel-success" id='konfig_whatsapp'>
            <div class="panel-heading">
                <div class="panel-title">Kirim Pesan via WhatsApp</div>
            </div>
            <div class="panel-body">
                <?php echo $form->textFieldRow($model, 'whatsapp_host_single', array('class' => 'span5', 'onkeyup' => "return $(this).focusNextInputField(event);",  'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('whatsapp_host_single'))); ?>
                <?php echo $form->textFieldRow($model, 'whatsapp_host_file', array('class' => 'span5', 'onkeyup' => "return $(this).focusNextInputField(event);",  'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('whatsapp_host_file'))); ?>
                <?php echo $form->textFieldRow($model, 'whatsapp_host', array('class' => 'span5', 'onkeyup' => "return $(this).focusNextInputField(event);",  'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('whatsapp_host'))); ?>
                <?php echo $form->textAreaRow($model, 'whatsapp_renkontrol', array('rows' => 10, 'cols' => 100, 'class' => 'span5', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('whatsapp_renkontrol'))); ?>
                <?php echo $form->textAreaRow($model, 'whatsapp_h1renkontrol', array('rows' => 10, 'cols' => 100, 'class' => 'span5', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('whatsapp_h1renkontrol'))); ?>
                <?php echo $form->textAreaRow($model, 'whatsapp_hadirrenkontrol', array('rows' => 10, 'cols' => 100, 'class' => 'span5', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('whatsapp_hadirrenkontrol'))); ?>
                <?php echo $form->textAreaRow($model, 'whatsapp_tdkhadirrenkontrol', array('rows' => 10, 'cols' => 100, 'class' => 'span5', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('whatsapp_tdkhadirrenkontrol'))); ?>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-success" id='konfig_email' hidden>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-envelope"></i> Email
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group" rel='tooltip' title="<?php echo $model->getAttributeTooltip('email_aktif') ?> ">
                    <?php echo $form->labelEx($model, 'email_aktif', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'email_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('is_nodejsaktif'),)); ?>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'linkemail_aktifexp', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'linkemail_aktifexp', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('linkemail_aktifexp'))); ?> Jam
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'linkemail_resetexp', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'linkemail_resetexp', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('linkemail_resetexp'))); ?> Jam
                    </div>
                </div>
            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>

        <div class="panel panel-primary panel-success" id='akomodasi_rawat_inap'>
            <div class="panel-heading">
                <div class="panel-title">Akomodasi Perawatan Rawat Inap</div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'akomodasiotomatis', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="make-switch">
                            <?php echo $form->checkBox($model, 'akomodasiotomatis', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('akomodasiotomatis'), 'onkeyup' => "return $(this).focusNextInputField(event);"));  ?>
                        </div>
                    </div>
                </div>
                <?php echo $form->radioButtonListRow($model, 'jenispenambahan_akomodasiranap', array(
                    'is_otomatiscronjob' => 'Setiap Pukul 00:00:01 Secara Otomatis dengan Cron Job',
                    'is_setelah24jam' => '24 Jam dari Jam Masuk Kamar',
                    'is_waktupenambahan' => 'waktu Penambahan'
                ), array('uncheckValue' => null, 'onchange' => 'changeAkomodasiranap()', 'class' => 'jenispenambahan_akomodasiranap')); ?>
                <div class="control-group">
                    <?php echo CHtml::label("Jam Penambahan", '', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'jam_jobakomodasiranap',
                            'mode' => 'time',
                            'options' => array(),
                            'htmlOptions' => array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:70px;'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'waktutampilalert_akomodasisdhterhitung', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'waktutampilalert_akomodasisdhterhitung', array('class' => 'span1 numbers-only', 'rel' => 'tooltip', 'onkeyup' => "return $(this).focusNextInputField(event);"));  ?>
                        <label> Jam</label>
                    </div>
                </div>

            </div>
            <div class="panel-footer" style="text-align: right;">
                <?php echo CHtml::link("<i class='entypo-up-bold'></i>  Kembali ke Atas", '#backtop') ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    );
    ?>
    <?php
    //        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
    //                            $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])),
    //                            array('class' => 'btn btn-default',
    //                            'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('title' => 'Ulang', 'id' => 'btn_reset', 'class' => 'btn btn-default', 'type' => 'reset')
    );
    ?>
    <?php
    //            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Konfigurasi Sistem', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerScript('angka', "
$(document).ready(function () {
        $('.numbersOnly').keypress(function(event) {
                var charCode = (event.which) ? event.which : event.keyCode
                if ((charCode >= 48 && charCode <= 57)
                        || charCode == 46
                        || charCode == 44)
                        return true;
                return false;
        });
});
", CClientScript::POS_HEAD); ?>

<script>
    function changeAkomodasiranap() {
        var index = 0;
        var indexLainnya = 0;
        $('.jenispenambahan_akomodasiranap').each(function() {
            if ($(this).val() == 'is_waktupenambahan' && $(this).prop('checked') == true) {
                $('#<?php echo CHtml::activeId($model, 'jam_jobakomodasiranap'); ?>').attr('disabled', false);
                $('#<?php echo CHtml::activeId($model, 'jam_jobakomodasiranap'); ?>_date').show();
                indexLainnya = 1;
            } else {
                index++;
            }
        });
        if (index <= 3 && indexLainnya == 0) {
            $('#<?php echo CHtml::activeId($model, 'jam_jobakomodasiranap'); ?>').attr('disabled', true);
            $('#<?php echo CHtml::activeId($model, 'jam_jobakomodasiranap'); ?>_date').hide();
            $('#<?php echo CHtml::activeId($model, 'jam_jobakomodasiranap'); ?>').val('');
        }
    }

    function setChangeMetodeGenNomorPeg() {
        var index = 0;
        var indexLainnya = 0;
        $('.metode_nokepegawaian').each(function() {
            if ($(this).val() == 'Otomatis Sistem' && $(this).prop('checked') == true) {
                $('.manualpeggen').show();
                $('.manualpeggen').find('input').attr('disabled', false);
                indexLainnya = 1;
            } else {
                index++;
            }
        });

        if (index <= 2 && indexLainnya == 0) {
            $('.manualpeggen').hide();
            $('.manualpeggen').find('input').attr('disabled', true);
        }
    }


    function setChangeRujukan() {
        var index = 0;
        var indexLainnya = 0;
        $('.jenisrujukan').each(function() {
            if ($(this).val() == '1' && $(this).prop('checked') == true) {
                // $('.manualpeggen').show();
                // $('.manualpeggen').find('input').attr('disabled',false);
                indexLainnya = 1;
            } else {
                index++;
            }
        });

        if (index <= 2 && indexLainnya == 0) {
            // $('.manualpeggen').hide();
            // $('.manualpeggen').find('input').attr('disabled',true);
        }
    }

    $(document).ready(function() {
        changeAkomodasiranap();
        setChangeMetodeGenNomorPeg();
        CKEDITOR.replace('alamatheadersurat', {
            extraPlugins: 'colorbutton,colordialog',
            toolbarGroups: [{
                    "name": "basicstyles",
                    "groups": ["basicstyles", "align", "spacings", "colors"]
                },
                {
                    "name": "paragraph",
                    "groups": ["list", "blocks"]
                },
                {
                    "name": "styles",
                    "groups": ["styles"]
                }
            ]
        });
        CKEDITOR.replace('kopsurat_gizi', {
            extraPlugins: 'colorbutton,colordialog',
            toolbarGroups: [{
                    "name": "basicstyles",
                    "groups": ["basicstyles", "align", "spacings", "colors"]
                },
                {
                    "name": "paragraph",
                    "groups": ["list", "blocks"]
                },
                {
                    "name": "styles",
                    "groups": ["styles"]
                }
            ]
        });
    });
</script>