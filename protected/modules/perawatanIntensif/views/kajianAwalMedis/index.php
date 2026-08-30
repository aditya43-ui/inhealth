<?php
//komen buat ngepull
$this->breadcrumbs = array(
    'Anamnesa',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data anamnesa berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
//$this->renderPartial('/_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAdmisi'=>$modAdmisi));
//echo '<legend class="rim">ANAMNESIS</legend><hr>';
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RIAnamnesaT_keluhanutama_annoninput .maininput',
));
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class='fas fa-laptop-medical'></i> Asessmen <b>Awal</b>
        </div>
    </div>
    <div class="panel-body">
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'tabel-riwayatanamnesa',
            'content' => array(
                'content-detailanamnesa' => array(
                    'header' => '<b>Tabel Riwayat Assesmen</b>',
                    'isi' => $this->renderPartial('_tabelRiwayatAnamnesa', array(
                        'tabelAnamnesa' => $tabelAnamnesa,
                        'format' => $format,
                    ), true),
                    'active' => true,
                ),
            ),
        )); ?>

        <div class="row">
            <div class="col-sm-6 col-sm-12">
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'tglanamnesis', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modAnamnesa,
                            'attribute' => 'tglanamnesis',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span3',
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                <?php echo $form->dropDownListRow($modAnamnesa, 'pegawai_id', CHtml::listData($modAnamnesa->getDokterItems($modAdmisi->ruangan_id), 'pegawai_id', 'NamaLengkap'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
                <?php
            echo $form->dropDownListRow(
                    $modAnamnesa, 'ppds_id', CHtml::listData($modAnamnesa->getPPDS(), 'ppds_id', 'ppds_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")
            );
            ?>
             <?php //echo $form->dropDownListRow($modAnamnesa, 'paramedis_nama', CHtml::listData(ParamedisV::model()->findAll("ruangan_id = ".Yii::app()->user->getState('ruangan_id')), 'nama_pegawai', 'NamaLengkap'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                ?>
                <?php //echo $form->dropDownListRow($modAnamnesa,'paramedis_nama', CHtml::listData($modAnamnesa->ParamedisItems, 'pegawai.NamaLengkap', 'pegawai.nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                ?>
                <?php echo $form->dropDownListRow($modAnamnesa, 'paramedis_nama', CHtml::listData($modAnamnesa->getParamedisItems(), 'pegawai.NamaLengkap', 'pegawai.NamaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php //echo $form->textAreaRow($modAnamnesa, 'keluhanutama', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                ?>

                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'keluhanutama', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modAnamnesa, 'attribute' => 'keluhanutama', 'toolbar' => 'mini', 'height' => '200px')) ?>
                        <?php
                        // $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                        //     'model' => $modAnamnesa,
                        //     'attribute' => 'keluhanutama',
                        //     'data' => explode(',', $modAnamnesa->keluhanutama),
                        //     'debugMode' => true,
                        //     'options' => array(
                        //         //'bricket'=>false,
                        //         //                                'json_url'=>$this->createUrl('//actionAjax/MasterKeluhan'),
                        //         'addontab' => true,
                        //         'maxitems' => 10,
                        //         'input_min_size' => 0,
                        //         'cache' => true,
                        //         'newel' => true,
                        //         'addoncomma' => true,
                        //         'select_all_text' => "",
                        //     ),
                        // ));
                        ?>
                        <?php echo $form->error($modAnamnesa, 'keluhanutama'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'keluhantambahan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($modAnamnesa, 'keluhantambahan', array('placeholder' => 'Keluhan Tambahan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php
                        // $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                        //     'model' => $modAnamnesa,
                        //     'attribute' => 'keluhantambahan',
                        //     'data' => explode(',', $modAnamnesa->keluhantambahan),
                        //     'debugMode' => true,
                        //     'options' => array(
                        //         //'bricket'=>false,
                        //         //                                'json_url'=>$this->createUrl('//actionAjax/MasterKeluhan'),
                        //         'addontab' => true,
                        //         'maxitems' => 10,
                        //         'input_min_size' => 0,
                        //         'cache' => true,
                        //         'newel' => true,
                        //         'addoncomma' => true,
                        //         'select_all_text' => "",
                        //     ),
                        // ));
                        ?>
                        <?php echo $form->error($modAnamnesa, 'keluhantambahan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="RJAnamnesaT_riwayatperjalananpasien">Riwayat Perjalanan Penyakit Pasien</label>
                    <div class="controls">
                        <?php echo $form->textArea($modAnamnesa, 'riwayatperjalananpasien', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                        <?php echo $form->error($modAnamnesa, 'riwayatperjalananpasien'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'lamasakit', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modAnamnesa, 'lamasakit', array('placeholder' => '00', 'class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", "maxlength" => 2)); ?>
                        <?php echo $form->dropDownList($modAnamnesa, 'satuanWaktu', array('Hari' => 'Hari', 'Minggu' => 'Minggu', 'Bulan' => 'Bulan', 'Tahun' => 'Tahun'), array('class' => 'span2', 'empty' => '-- Pilih --')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'riwayatpenyakitterdahulu', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($modAnamnesa, 'riwayatpenyakitterdahulu', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array(
                            'class' => 'btn btn-danger', 'onclick' => "$('#dialogAddRiwayatPenyakitTerdahulu').dialog('open');",
                            'id' => 'btnAddRiwayatPenyakitTerdahulu', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('riwayatpenyakitterdahulu')
                        ))
                        ?>
                        <?php echo $form->error($modAnamnesa, 'riwayatpenyakitterdahulu'); ?>
                    </div>
                </div>
                <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatpenyakitterdahulu', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));  
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array(
                            'class' => 'btn btn-danger', 'onclick' => "$('#dialogAddRiwayatPenyakitKeluarga').dialog('open');",
                            'id' => 'btnAddRiwayatPenyakitKeluarga', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('riwayatpenyakitkeluarga')
                        ))
                        ?>
                        <?php echo $form->error($modAnamnesa, 'riwayatpenyakitkeluarga'); ?>
                    </div>
                </div>

                <?php echo $form->textAreaRow($modAnamnesa, 'riwayatalergiobat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
            <div class="col-sm-6 col-sm-12 ">

                <?php //echo $form->textAreaRow($modAnamnesa, 'keluhantambahan', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                ?>

                <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                ?>
                <div hidden>
                    <?php echo $form->textAreaRow($modAnamnesa, 'pengobatanygsudahdilakukan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textAreaRow($modAnamnesa, 'riwayatmakanan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
                <?php echo $form->textAreaRow($modAnamnesa, 'riwayatkelahiran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php if ($modPasien->jeniskelamin == 'PEREMPUAN' && in_array($modPasien->kelompokumur_id, Params::getKelompokUmurHamil())) { ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modAnamnesa, 'ispasienwanitahamil', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAnamnesa, 'ispasienwanitahamil', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                'template' => '<div class="radio-inline">{input}{label} </div>',
                                'uncheckValue' => null,
                                'class' => 'ispasienwanitahamil'
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modAnamnesa, 'ispasienwanitamenyusui', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAnamnesa, 'ispasienwanitamenyusui', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                'template' => '<div class="radio-inline">{input}{label} </div>',
                                'uncheckValue' => null,
                                'class' => 'ispasienwanitamenyusui'
                            )); ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($modPasien->jeniskelamin == 'PEREMPUAN' && in_array($modPasien->kelompokumur_id, Params::getKelompokUmurCongenital())) { ?>
                    <div class="panel_radio_group">
                        <div class="control-group">
                            <?php echo $form->labelEx($modAnamnesa, 'isbayianak_kelainanconginetal', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->radioButtonList($modAnamnesa, 'isbayianak_kelainanconginetal', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                    'template' => '<div class="radio-inline">{input}{label} </div>',
                                    'uncheckValue' => null,
                                    'class' => 'isbayianak_kelainanconginetal panel_radio_ceklis'
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modAnamnesa, 'kelainanconginetal_jenis', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modAnamnesa, 'kelainanconginetal_jenis', array(
                                    'class' => 'span3 isbayianak_kelainanconginetal panel_radio_text',
                                    'data-ceklis' => 'Ya'
                                )); ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'riwayatimunisasi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($modAnamnesa, 'riwayatimunisasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array(
                            'class' => 'btn btn-danger', 'onclick' => "$('#dialogAddRiwayatImunisasi').dialog('open');",
                            'id' => 'btnAddRiwayatImunisasi', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('riwayatimunisasi')
                        ))
                        ?>
                        <?php echo $form->error($modAnamnesa, 'riwayatimunisasi'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'riwayat_operasi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($modAnamnesa, 'riwayat_operasi', array(
                            'class' => 'span3 riwayat_operasi',
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'statusmerokok', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->radioButtonList($modAnamnesa, 'statusmerokok', array('0' => 'Tidak', '1' => 'Ya'), array(
                            'template' => '<div class="radio-inline">{input}{label} </div>',
                            'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'statusrokok', 'onclick' => 'setJumlahRokok(this);'
                        )); ?>

                        <?php echo $form->error($modAnamnesa, 'statusmerokok'); ?>
                    </div>
                </div>
                <div class="control-group" hidden>
                    <?php echo $form->labelEx($modAnamnesa, 'jmlrokok_btg_hr', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modAnamnesa, 'jmlrokok_btg_hr', array('class' => 'span1 jmlbtg', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->labelEx($modAnamnesa, 'hari') ?>
                    </div>
                </div>

                <div class="panel_radio_group">
                    <div class="control-group">
                        <?php echo $form->labelEx($modAnamnesa, 'keb_konsumsialkohol', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAnamnesa, 'keb_konsumsialkohol', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                'template' => '<div class="radio-inline">{input}{label} </div>',
                                'uncheckValue' => null,
                                'class' => 'keb_konsumsialkohol panel_radio_ceklis'
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group" hidden>
                        <?php echo $form->labelEx($modAnamnesa, 'jmlalkohol_rutinminum', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modAnamnesa, 'jmlalkohol_rutinminum', array(
                                'class' => 'span3 jmlalkohol_rutinminum panel_radio_text',
                                'data-ceklis' => 'Ya'
                            )); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Kembiasaan Minum Teh/Kopi//Soda", "", array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'keb_minumkopi') . $form->label($modAnamnesa, 'keb_minumkopi'); ?>
                        </div>
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'keb_minumteh') . $form->label($modAnamnesa, 'keb_minumteh'); ?>
                        </div>
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'keb_minumsoda') . $form->label($modAnamnesa, 'keb_minumsoda'); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'keb_olahraga', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->radioButtonList($modAnamnesa, 'keb_olahraga', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                            'template' => '<div class="radio-inline">{input}{label} </div>',
                            'uncheckValue' => null,
                            'class' => 'keb_olahraga'
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Gangguan Komunikasi", "", array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'gangguankomunikasi_bahasaindonesia') . $form->label($modAnamnesa, 'gangguankomunikasi_bahasaindonesia'); ?>
                        </div>
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'gangguankomunikasi_gangguanpendengaran') . $form->label($modAnamnesa, 'gangguankomunikasi_gangguanpendengaran'); ?>
                        </div>
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'gangguankomunikasi_gangguanbicara') . $form->label($modAnamnesa, 'gangguankomunikasi_gangguanbicara'); ?>
                        </div>
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'gangguankomunikasi_tidakada') . $form->label($modAnamnesa, 'gangguankomunikasi_tidakada'); ?>
                        </div>
                    </div>
                </div>
                <div class="panel_radio_group">
                    <div class="control-group">
                        <?php echo $form->labelEx($modAnamnesa, 'riwayatperiksa_diagnosahiv', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAnamnesa, 'riwayatperiksa_diagnosahiv', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                'template' => '<div class="radio-inline">{input}{label} </div>',
                                'uncheckValue' => null,
                                'class' => 'riwayatperiksa_diagnosahiv panel_radio_ceklis'
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group" hidden>
                        <?php echo $form->labelEx($modAnamnesa, 'riwayatperiksa_diagnosahivhasil', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textArea($modAnamnesa, 'riwayatperiksa_diagnosahivhasil', array(
                                'class' => 'span3 riwayatperiksa_diagnosahivhasil panel_radio_text',
                                'data-ceklis' => 'Ya'
                            )); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Apakah Pasien memakai Gigi Palsu & Alat Bantu Dengar", "", array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'ismemakaigigipalsu') . $form->label($modAnamnesa, 'ismemakaigigipalsu'); ?>
                        </div>
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'ismemakaialatbantudengar') . $form->label($modAnamnesa, 'ismemakaialatbantudengar'); ?>
                        </div>
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'istidakmemakai_gigipalsualatbantudengar') . $form->label($modAnamnesa, 'istidakmemakai_gigipalsualatbantudengar'); ?>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'keterangananamesa', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modAnamnesa, 'attribute' => 'keterangananamesa', 'toolbar' => 'mini', 'height' => '200px')) ?>
                    </div>
                </div>
                <?php //echo $form->textAreaRow($modAnamnesa, 'keterangananamesa', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                ?>

                <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatalergiobat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                ?>

                <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatimunisasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                ?>
            </div>
        </div>

        <?php echo $this->renderPartial("_skriningGiziDewasa", array(
            'modAnamnesa' => $modAnamnesa,
            'form' => $form
        ), true); ?>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton($modAnamnesa->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            );


            $anamnesaB = null;
            if (isset($_GET['id'])) {
                $anamnesaB = RIAnamnesaT::model()->findByPk($_GET['id']);
            }

            if (empty($anamnesaB)) {
                $anamnesaB = new RIAnamnesaT();
            }

            if ($anamnesaB->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Anamnesa', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Anamnesa', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printAnamnesa();return false", 'disabled' => FALSE));
            }

            $content = $this->renderPartial('../tips/tips', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));

            ?>

        </div>
    </div>
</div>

<?php //$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
//         'id' => 'form-pemeriksaanfisik',
//         'content' => array(
//             'content-pemeriksaanfisik' => array(
//                 'header' => '<b>Pemeriksaan Fisik</b>',
//                 'isi' => '<iframe src="" id="pemeriksaanFisik" style="width:100%; height: 400px;"></iframe>',
//                 'active' => false,
//             ),
//         ),
// )); ?>

<?php //$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
//         'id' => 'form-laboratorium',
//         'content' => array(
//             'content-laboratorium' => array(
//                 'header' => '<b>Laboratorium</b>',
//                 'isi' => '<iframe src="" id="laboratorium" style="width:100%; height: 100%;"></iframe>',
//                 'active' => true,
//             ),
//         ),
// )); ?>


<?php //$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
//         'id' => 'form-laboratoriumPA',
//         'content' => array(
//             'content-laboratoriumPA' => array(
//                 'header' => '<b>Laboratorium Patologi Anatomi</b>',
//                 'isi' => '<iframe src="" id="laboratoriumPA" style="width:100%; height: 100%;"></iframe>',
//                 'active' => true,
//             ),
//         ),
// )); ?>

<?php //$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
//         'id' => 'form-radiologi',
//         'content' => array(
//             'content-radiologi' => array(
//                 'header' => '<b>Radiologi</b>',
//                 'isi' => '<iframe src="" id="radiologi" style="width:100%; height: 100%;"></iframe>',
//                 'active' => false,
//             ),
//         ),
// )); ?>

<?php //$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
//         'id' => 'form-diagnosis',
//         'content' => array(
//             'content-diagnosis' => array(
//                 'header' => '<b>Diagnosis</b>',
//                 'isi' => '<iframe src="" id="diagnosis" style="width:100%; height: 100%;"></iframe>',
//                 'active' => false,
//             ),
//         ),
// )); ?>



<?php $this->endWidget();

echo $this->renderPartial("_jsFunction", array('modPendaftaran' => $modPendaftaran), true);

?>

<?php
$js = <<< JS

//===============Awal untu Mengecek Form Sudah DiUbah Atw Belum====================    
    $(":input").keyup(function(event){
            $('#berubah').val('Ya');
         });
    $(":input").change(function(event){
            $('#berubah').val('Ya');
         });  
    $(":input").click(function(event){
            $('#berubah').val('Ya');
         });  
//================Akhir untuk Mengecek  Form Sudah DiUbah Atw Belum===================         
JS;
Yii::app()->clientScript->registerScript('asuransi', $js, CClientScript::POS_READY);
?>

<?php
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 34 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"

function palidasiForm(obj)
   {
        var berubah = $('#berubah').val();
        if(berubah=='Ya') 
        {
            myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
                if(r)
                {
                         $('#url').val(obj);
                         $('#btn_simpan').click();

                }
            });

        }      
   }
JS;
Yii::app()->clientScript->registerScript('validasi', $js, CClientScript::POS_HEAD);
?>

<?php
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAddRiwayatPenyakitTerdahulu',
    'options' => array(
        'title' => 'Pencarian Data Diagnosa Penyakit Terdahulu',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modDataDiagnosaPenyakitTerdahulu = new RIDiagnosaM('searchDiagnosaAnamnesa');
$modDataDiagnosaPenyakitTerdahulu->unsetAttributes();
if (isset($_GET['RIDiagnosaM'])) {
    $modDataDiagnosaPenyakitTerdahulu->attributes = $_GET['RIDiagnosaM'];
    $modDataDiagnosaPenyakitTerdahulu->diagnosa_nama = (isset($_GET['RIDiagnosaM']['diagnosa_nama']) ? $_GET['RIDiagnosaM']['diagnosa_nama'] : "");
    $modDataDiagnosaPenyakitTerdahulu->diagnosa_namalainnya = (isset($_GET['RIDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RIDiagnosaM']['diagnosa_namalainnya'] : "");
    $modDataDiagnosaPenyakitTerdahulu->diagnosa_kode = (isset($_GET['RIDiagnosaM']['diagnosa_kode']) ? $_GET['RIDiagnosaM']['diagnosa_kode'] : "");
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-grid',
    'dataProvider' => $modDataDiagnosaPenyakitTerdahulu->searchDiagnosaAnamnesa(),
    'filter' => $modDataDiagnosaPenyakitTerdahulu,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
                                                var data = $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitterdahulu') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitterdahulu') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitterdahulu') . '\").val(data+\", $data->diagnosa_nama\");                                                  
                                                }
                                                  $(\"#dialogAddRiwayatPenyakitTerdahulu\").dialog(\"close\");    
                                        "))',
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',
        // 'diagnosa_katakunci',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
//========= Dialog buat Pencarian Diagnosa Penyakit Keluarga =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAddRiwayatPenyakitKeluarga',
    'options' => array(
        'title' => 'Pencarian Data Pencarian Diagnosa Penyakit Keluarga',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modDataDiagnosaKeluarga = new RIDiagnosaM('searchDiagnosaAnamnesa');
$modDataDiagnosaKeluarga->unsetAttributes();
if (isset($_GET['RIDiagnosaM'])) {
    $modDataDiagnosaKeluarga->attributes = $_GET['RIDiagnosaM'];
    $modDataDiagnosaKeluarga->diagnosa_nama = (isset($_GET['RIDiagnosaM']['diagnosa_nama']) ? $_GET['RIDiagnosaM']['diagnosa_nama'] : "");
    $modDataDiagnosaKeluarga->diagnosa_namalainnya = (isset($_GET['RIDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RIDiagnosaM']['diagnosa_namalainnya'] : "");
    $modDataDiagnosaKeluarga->diagnosa_kode = (isset($_GET['RIDiagnosaM']['diagnosa_kode']) ? $_GET['RIDiagnosaM']['diagnosa_kode'] : "");
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'penyakitkeluarga-m-grid',
    'dataProvider' => $modDataDiagnosaKeluarga->searchDiagnosaAnamnesa(),
    'filter' => $modDataDiagnosaKeluarga,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectDiagnosaPenyakit",
                                    "onClick" => "
                                                var data = $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitkeluarga') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitkeluarga') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitkeluarga') . '\").val(data+\", $data->diagnosa_nama\");
                                                }
                                                $(\"#dialogAddRiwayatPenyakitKeluarga\").dialog(\"close\");    
                                        "))',
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pencarian Diagnosa Penyakit Keluarga dialog =============================
?>


<?php
//========= Dialog buat Pencarian Riwayat Imunisasi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAddRiwayatImunisasi',
    'options' => array(
        'title' => 'Pencarian Data Riwayat Imunisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'imunisasi-m-grid',
    'dataProvider' => $modDataDiagnosa->searchImunisasi(),
    'filter' => $modDataDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectDiagnosaImunisasi",
                                    "onClick" => "
                                                var data = $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatimunisasi') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatimunisasi') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatimunisasi') . '\").val(data+\", $data->diagnosa_nama\");
                                                }
                                                $(\"#dialogAddRiwayatImunisasi\").dialog(\"close\");    
                                        "))',
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',
        'diagnosa_katakunci',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pencarian Riwayat Imunisasi dialog =============================
?>


<script type="text/javascript">
    /**
     * print status
     */
    function printAnamnesa() {
        <?php $anamnesiadi = (!empty($anamnesaB->anamesa_id) ? $anamnesaB->anamesa_id : null); ?>
        window.open('<?php echo $this->createUrl('printAnamnesa', array('pendaftaran_id' => $modAnamnesa->pendaftaran_id, 'anamnesa_id' => $anamnesiadi)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }

    function defaultparamedis() {
        var paramedis = '<?php
                            $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                            if (!empty($pegawai)) echo $pegawai->nama_pegawai;
                            ?>';
        $("#<?php echo CHtml::activeId($modAnamnesa, 'paramedis_nama') ?>").val(paramedis);
    }

    function setJumlahRokok(obj) {
        var status = $(obj).val();
        if (status == 0) {
            $('.jmlbtg').attr('readonly', true);
        } else {
            $('.jmlbtg').removeAttr('readonly', true);
        }
    }

    $(document).ready(function() {
        $('input[name$="[statusmerokok]"][type="radio"]').each(function() {
            if ($(this).is(':checked')) {
                var status = $(this).val();
                if (status == 0) {
                    $('.jmlbtg').attr('readonly', true);
                } else {
                    $('.jmlbtg').removeAttr('readonly', true);
                }
            }
        });
        defaultparamedis();
    });


    $(document).ready(function() {
           var pegawai = jQuery('#<?php echo CHtml::activeId($modAnamnesa, 'pegawai_id') ?>');	
           jQuery(pegawai).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
       });


    function searchPegawai() {
            $('#rjanamnesa-t-form input[name*="pegawai_id"]').each(function() {
            });
    }



    $(document).ready(function() {
           var ppds = jQuery('#<?php echo CHtml::activeId($modAnamnesa, 'ppds_id') ?>');	
           jQuery(ppds).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
       });

       $(document).ready(function() {
           
           setTimeout(() => {

               $('#content-laboratorium').removeClass('in');     
               $('#content-laboratoriumPA').removeClass('in');     
           }, 3000);
       });


    $(document).ready(function() {
           var paramedis = jQuery('#<?php echo CHtml::activeId($modAnamnesa, 'paramedis_nama') ?>');	
           jQuery(paramedis).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();

        if (typeof parent.cekPeriksaPasien != "undefined") {
            parent.cekPeriksaPasien();
        }
       });


    function searchPegawai() {
            $('#rjanamnesa-t-form input[name*="ppds_id"]').each(function() {
            });
    }
    
</script>