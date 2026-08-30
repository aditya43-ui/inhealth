<?php
//komen buat ngepull
$this->breadcrumbs = array(
    'Anamnesis',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Anamnesis berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RJAnamnesaT_keluhanutama_annoninput .maininput',
));
?>
<div class="white-container">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($modAnamnesa); ?>
    <div class="row">
        <div class="span8">
            <fieldset class="box">
                <legend class="rim">Data Pemeriksaan</legend>
                <table width='100%'>
                    <tr>
                        <td width='50%'>
                            <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                            <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                            <?php echo $form->dropDownListRow($modAnamnesa, 'pegawai_id', CHtml::listData($modAnamnesa->getDokterItems($modPendaftaran->ruangan_id), 'pegawai_id', 'NamaLengkap'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
                            <?php echo $form->dropDownListRow($modAnamnesa, 'paramedis_nama', CHtml::listData($modAnamnesa->ParamedisItems, 'pegawai.nama_pegawai', 'pegawai.NamaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($modAnamnesa, 'Tanggal Pemeriksaan', array('class' => 'control-label')) ?>
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
                                            'readonly' => true, 'class' => 'span2',
                                            'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modAnamnesa, 'keluhanutama', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                                        'model' => $modAnamnesa,
                                        'attribute' => 'keluhanutama',
                                        'data' => explode(',', $modAnamnesa->keluhanutama),
                                        'debugMode' => true,
                                        'options' => array(
                                            //'bricket'=>false,
                                            'json_url' => $this->createUrl('MasterKeluhan'),
                                            'addontab' => true,
                                            'maxitems' => 10,
                                            'input_min_size' => 0,
                                            'cache' => true,
                                            'newel' => true,
                                            'addoncomma' => true,
                                            'select_all_text' => "",
                                            'autoFocus' => true,
                                        ),
                                    ));
                                    ?>
                                    <?php echo $form->error($modAnamnesa, 'keluhanutama'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modAnamnesa, 'keluhantambahan', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                                        'model' => $modAnamnesa,
                                        'attribute' => 'keluhantambahan',
                                        'data' => explode(',', $modAnamnesa->keluhantambahan),
                                        'debugMode' => true,
                                        'options' => array(
                                            //'bricket'=>false,
                                            'json_url' => $this->createUrl('MasterKeluhan'),
                                            'addontab' => true,
                                            'maxitems' => 10,
                                            'input_min_size' => 0,
                                            'cache' => true,
                                            'newel' => true,
                                            'addoncomma' => true,
                                            'select_all_text' => "",
                                        ),
                                    ));
                                    ?>
                                    <?php echo $form->error($modAnamnesa, 'keluhantambahan'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modAnamnesa, 'Riwayat Penyakit Saat Ini', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textArea($modAnamnesa, 'riwayatpenyakitterdahulu', array('class' => 'span2', 'style' => 'width:150px', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                    <?php
                                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array(
                                        'class' => 'btn btn-danger', 'onclick' => "$('#dialogAddRiwayatPenyakitTerdahulu').dialog('open');",
                                        'id' => 'btnAddRiwayatPenyakitTerdahulu', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('riwayatpenyakitterdahulu')
                                    ))
                                    ?>
                                    <?php echo $form->error($modAnamnesa, 'riwayatpenyakitterdahulu'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modAnamnesa, 'Riwayat Obat-obatan yang sering digunakan', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textArea($modAnamnesa, 'riwayatobatygsering', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                </div>
                            </div>
                        </td>
                        <td width='50%'>
                            <?php echo $form->textAreaRow($modAnamnesa, 'riwayatalergiobat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            <?php echo $form->textAreaRow($modAnamnesa, 'riwayatmakanan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($modAnamnesa, 'riwayatimunisasi', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textArea($modAnamnesa, 'riwayatimunisasi', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'yang sudah dilakukan')); ?>
                                    <?php
                                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array(
                                        'class' => 'btn btn-danger', 'onclick' => "$('#dialogAddRiwayatImunisasi').dialog('open');",
                                        'id' => 'btnAddRiwayatImunisasi', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('riwayatimunisasi')
                                    ))
                                    ?>
                                    <?php echo $form->error($modAnamnesa, 'riwayatimunisasi'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modAnamnesa, 'riwayatimunisasi', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textArea($modAnamnesa, 'riwayatimunisasiblm', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'yang belum dilakukan')); ?>
                                    <?php
                                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array(
                                        'class' => 'btn btn-danger', 'onclick' => "$('#dialogAddRiwayatImunisasisudah').dialog('open');",
                                        'id' => 'btnAddRiwayatImunisasi', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('riwayatimunisasiblm')
                                    ))
                                    ?>
                                    <?php echo $form->error($modAnamnesa, 'riwayatimunisasiblm'); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <div class="col-sm-4">
            <fieldset class="box">
                <legend class="rim">Kebiasaan</legend>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'Olah Raga', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modAnamnesa, 'keb_olahraga', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'setOlahRaga(this);')); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modAnamnesa, 'keb_olahraga'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'Jenis Olah Raga', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modAnamnesa, 'keb_jnsolahraga', array('class' => 'span3 olahraga', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'Frekuensi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modAnamnesa, 'keb_frekuensi_kaliminggu', array('class' => 'span1 integer olahraga', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <?php echo $form->labelEx($modAnamnesa, 'kali / minggu') ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'statusmerokok', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modAnamnesa, 'statusmerokok', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'statusrokok', 'onclick' => 'setJumlahRokok(this);')); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modAnamnesa, 'statusmerokok'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'Jumlah Rokok', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modAnamnesa, 'jmlrokok_btg_hr', array('class' => 'span1 integer jmlbtg', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->labelEx($modAnamnesa, 'batang / hari') ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'Konsumsi Alkohol', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modAnamnesa, 'keb_konsumsialkohol', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modAnamnesa, 'keb_konsumsialkohol'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'Minum Kopi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modAnamnesa, 'keb_minumkopi', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modAnamnesa, 'keb_minumkopi'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'keb_konsumsidrug', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modAnamnesa, 'keb_konsumsidrug', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modAnamnesa, 'keb_konsumsidrug'); ?>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <fieldset class="box">
                <legend class="rim">Data Kesehatan Individu</legend>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Pengobatan TBC', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'pengobatan_tbc', array('1' => 'Pernah', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'pengobatan_tbc'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Pengobatan Hepatitis', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'pengobatan_hepatitis', array('1' => 'Pernah', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'pengobatan_hepatitis'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Asma', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'asma', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'asma'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Radang Sendi / Remantik', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'radang_sendi', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'radang_sendi'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Serangan Jantung', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'serangan_jantung', array('1' => 'Pernah', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'serangan_jantung'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Patah Tulang / Pasang Pen', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'patah_tulang', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'patah_tulang'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Hemoroid', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'hemoroid', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'hemoroid'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Hipertensi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'hipertensi', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'hipertensi'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Diabetes Melitus', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'diabetes_melitus', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'diabetes_melitus'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Tyroid', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'tyroid', array('1' => 'Pernah', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'tyroid'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Penyakit Ginjal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'penyakit_ginjal', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'penyakit_ginjal'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Saluran Kemih Lainnya', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'saluran_kemih', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'saluran_kemih'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Penyakit Stroke', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'penyakit_stroke', array('1' => 'Pernah', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'penyakit_stroke'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Epilepsi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'epilepsi', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'epilepsi'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Thypus', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'thypus', array('1' => 'Pernah', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'thypus'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Transfusi Darah', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'tranfusi_darah', array('1' => 'Pernah', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'tranfusi_darah'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'HIV', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'hiv', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'hiv'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Kanker', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'kanker', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatIndividu, 'kanker'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">
                        <?php echo $form->textField($modRiwayatIndividu, 'lainnya_label', array('class' => 'span1', 'style' => 'width:110px', 'rel' => 'tooltip', 'title' => 'Riwayat Kesehata Individu Lainnya',)); ?>
                  </label>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatIndividu, 'lainnya', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <legend>
                    <h4>Riwayat Kecelakaan Kerja</h4>
                </legend>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Waktu dan Jenis Kecelakaan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->textArea($modRiwayatIndividu, 'riwayat_kecelakankerja', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <legend>
                    <h4>Riwayat Jenis Operasi</h4>
                </legend>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatIndividu, 'Waktu dan Jenis Operasi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->textArea($modRiwayatIndividu, 'riwayat_jenisoperasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </fieldset>
        </div>
        <div class="col-sm-4">
            <fieldset class="box">
                <legend class="rim">Riwayat Kesehatan Keluarga</legend>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatKeluarga, 'Darah Tinggi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatKeluarga, 'darah_tinggi', array('1' => 'Ada', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatKeluarga, 'darah_tinggi'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatKeluarga, 'Kanker', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatKeluarga, 'kanker', array('1' => 'Ada', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatKeluarga, 'kanker'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatKeluarga, 'Asma', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatKeluarga, 'asma', array('1' => 'Ada', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatKeluarga, 'asma'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatKeluarga, 'Ambeien', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatKeluarga, 'ambeien', array('1' => 'Ada', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatKeluarga, 'ambeien'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatKeluarga, 'Jantung', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatKeluarga, 'jantung', array('1' => 'Ada', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatKeluarga, 'jantung'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatKeluarga, 'TBC', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatKeluarga, 'tbc', array('1' => 'Ada', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatKeluarga, 'tbc'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatKeluarga, 'Stroke', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatKeluarga, 'stroke', array('1' => 'Ada', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatKeluarga, 'stroke'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatKeluarga, 'Diabetes Melitus', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatKeluarga, 'diabetes_melitus', array('1' => 'Ada', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatKeluarga, 'diabetes_melitus'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatKeluarga, 'Gangguan Jiwa', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatKeluarga, 'gangguan_jiwa', array('1' => 'Ada', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatKeluarga, 'gangguan_jiwa'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatKeluarga, 'Penyakit Kuning (hati)', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatKeluarga, 'penyakit_kuning', array('1' => 'Ada', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatKeluarga, 'penyakit_kuning'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatKeluarga, 'Kelainan Darah (thalasemia)', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatKeluarga, 'kelainan_darah', array('1' => 'Ada', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatKeluarga, 'kelainan_darah'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">
                        <?php echo $form->textField($modRiwayatKeluarga, 'lainnya_label', array('class' => 'span1', 'style' => 'width:110px', 'rel' => 'tooltip', 'title' => 'Riwayat Kesehata keluarga Lainnya',)); ?>
                  </label>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatKeluarga, 'lainnya', array('1' => 'Ada', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-sm-4">
            <fieldset class="box">
                <legend class="rim">Faktor Risiko di Tempat Kerja</legend>
                <legend class="rim3">Faktor Fisika</legend>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Kebisingan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'kebisingan', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'kebisingan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'suhu_panas', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'suhu_panas', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'suhu_panas'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Kelembaban', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'kelembaban', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'kelembaban'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Pencahayaan Kurang', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'pencahayaan_kurang', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'pencahayaan_kurang'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Kesilauan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'kesilauan', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'kesilauan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Getaran Pada Tangan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'getaran_padatangan', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'getaran_padatangan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Getaran Seluruh Badan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'getaran_seluruhbadan', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'getaran_seluruhbadan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Ventilasi Kurang Memadai', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'ventilasi_kurang', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'ventilasi_kurang'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Radiasi Pengion', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'radiasi_pengion', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'radiasi_pengion'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Radiasi Bukan Pengion', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'radiasi_bukanpengion', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'radiasi_bukanpengion'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Ketinggian', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'ketinggian', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'ketinggian'); ?>
                    </div>
                </div>
                <br>
                <legend class="rim3">Faktor Biologi</legend>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Bakteri / Virus / Jamur / Parasit', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'bakteri', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'bakteri'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Darah / Cairan Tubuh Lainnya', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'darah_cairan', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'darah_cairan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Nyamuk / Serangga Lainnya', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'nyamuk', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'nyamuk'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Limbah (Kotoran manusia / hewan)', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'limbah', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'limbah'); ?>
                    </div>
                </div>
                <br>
                <legend class="rim3">Faktor Kimia</legend>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Asam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'asam', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'asam'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Basa', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'basa', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'basa'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Pelarut Organik', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'pelarut_organik', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'pelarut_organik'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Uap Logam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'uap_logam', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'uap_logam'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Gas', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'gas', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'gas'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Pestisida / Insektisida', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'pestisida', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'pestisida'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Debu', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'debu', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'debu'); ?>
                    </div>
                </div>
                <br>
                <legend class="rim3">Faktor Ergonomi</legend>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Posisi Kerja Tidak Ergonomis', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'posisi_kerja', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'posisi_kerja'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Gerakan Repetitif', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'gerakan_repetitif', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'gerakan_repetitif'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Berdiri Lama', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'berdiri_lama', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'berdiri_lama'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Duduk Lama', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'duduk_lama', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'duduk_lama'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Angkat / Angkut Barang', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'angkat_angkut', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'angkat_angkut'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Bekerja Dengan Motor (>= 4Jam/hari)', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'bekerja_denganmotor', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'bekerja_denganmotor'); ?>
                    </div>
                </div>
                <br>
                <legend class="rim3">Faktor Psikisosial</legend>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Stress Kerja', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'stress_kerja', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'stress_kerja'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Kekerasan di Tempat Kerja', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'kekerasan', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'kekerasan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Pelecehan di Tempat Kerja', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'pelecehan', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'pelecehan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Ketidakjelasan Tugas', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'ketidakjelasan_tugas', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'ketidakjelasan_tugas'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRiwayatResikoKerja, 'Konflik Dengan Teman Kerja', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="radio inline">
                            <div class="form-inline">
                                <?php echo $form->radioButtonList($modRiwayatResikoKerja, 'konflik', array('1' => 'Ya', '0' => 'Tidak'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->error($modRiwayatResikoKerja, 'konflik'); ?>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

    <div class="form-actions">
        <?php

        if (isset($_GET['sukses'])) {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "return false", 'enabled' => true, 'disabled' => true)
            );
            echo CHtml::link(Yii::t('mds', '{icon} Print Anamnesis', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'klik untuk print', 'class' => 'btn btn-info', 'onclick' => "printAnamnesa(); return false", 'disabled' => 'true', 'disabled' => false));
        } else {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => false)
            );
            echo CHtml::link(Yii::t('mds', '{icon} Print Anamnesis', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'enabled' => 'true', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
        }
        ?>
        <?php
        $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
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
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

$modDataDiagnosa = new RJDiagnosaM('searchDiagnosaAnamnesa');
$modDataDiagnosa->unsetAttributes();
if (isset($_GET['RJDiagnosaM']))
    $modDataDiagnosa->attributes = $_GET['RJDiagnosaM'];
$modDataDiagnosa->diagnosa_nama = (isset($_GET['RJDiagnosaM']['diagnosa_nama']) ? $_GET['RJDiagnosaM']['diagnosa_nama'] : "");
$modDataDiagnosa->diagnosa_namalainnya = (isset($_GET['RJDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RJDiagnosaM']['diagnosa_namalainnya'] : "");
$modDataDiagnosa->diagnosa_kode = (isset($_GET['RJDiagnosaM']['diagnosa_kode']) ? $_GET['RJDiagnosaM']['diagnosa_kode'] : "");
//echo $modDataDiagnosa->diagnosa_nama;exit;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-grid',
    'dataProvider' => $modDataDiagnosa->searchDiagnosaAnamnesa(),
    'filter' => $modDataDiagnosa,
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
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));
$modDataDiagnosaKeluarga = new RJDiagnosaM('searchDiagnosaAnamnesa');
$modDataDiagnosaKeluarga->unsetAttributes();
if (isset($_GET['RJDiagnosaM']))
    $modDataDiagnosaKeluarga->attributes = $_GET['RJDiagnosaM'];
$modDataDiagnosaKeluarga->diagnosa_nama = (isset($_GET['RJDiagnosaM']['diagnosa_nama']) ? $_GET['RJDiagnosaM']['diagnosa_nama'] : "");
$modDataDiagnosaKeluarga->diagnosa_namalainnya = (isset($_GET['RJDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RJDiagnosaM']['diagnosa_namalainnya'] : "");
$modDataDiagnosaKeluarga->diagnosa_kode = (isset($_GET['RJDiagnosaM']['diagnosa_kode']) ? $_GET['RJDiagnosaM']['diagnosa_kode'] : "");

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
        'title' => 'Pencarian Data Riwayat Imunisasi (Belum dilakukan)',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

$modDataDiagnosaImunisasi = new RJDiagnosaM('searchImunisasi');
$modDataDiagnosaImunisasi->unsetAttributes();
if (isset($_GET['RJDiagnosaM']))
    $modDataDiagnosaImunisasi->attributes = $_GET['RJDiagnosaM'];
$modDataDiagnosaImunisasi->diagnosa_nama = (isset($_GET['RJDiagnosaM']['diagnosa_nama']) ? $_GET['RJDiagnosaM']['diagnosa_nama'] : "");
$modDataDiagnosaImunisasi->diagnosa_namalainnya = (isset($_GET['RJDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RJDiagnosaM']['diagnosa_namalainnya'] : "");
$modDataDiagnosaImunisasi->diagnosa_kode = (isset($_GET['RJDiagnosaM']['diagnosa_kode']) ? $_GET['RJDiagnosaM']['diagnosa_kode'] : "");

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'imunisasi-m-grid',
    'dataProvider' => $modDataDiagnosaImunisasi->searchImunisasi(),
    'filter' => $modDataDiagnosaImunisasi,
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

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pencarian Riwayat Imunisasi dialog =============================
?>

<?php
//========= Dialog buat Pencarian Riwayat Imunisasi yang sudah dilakukan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAddRiwayatImunisasisudah',
    'options' => array(
        'title' => 'Pencarian Data Riwayat Imunisasi (Sudah dilakukan)',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

$modDataDiagnosaImunisasi = new RJDiagnosaM('searchImunisasi');
$modDataDiagnosaImunisasi->unsetAttributes();
if (isset($_GET['RJDiagnosaM']))
    $modDataDiagnosaImunisasi->attributes = $_GET['RJDiagnosaM'];
$modDataDiagnosaImunisasi->diagnosa_nama = (isset($_GET['RJDiagnosaM']['diagnosa_nama']) ? $_GET['RJDiagnosaM']['diagnosa_nama'] : "");
$modDataDiagnosaImunisasi->diagnosa_namalainnya = (isset($_GET['RJDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RJDiagnosaM']['diagnosa_namalainnya'] : "");
$modDataDiagnosaImunisasi->diagnosa_kode = (isset($_GET['RJDiagnosaM']['diagnosa_kode']) ? $_GET['RJDiagnosaM']['diagnosa_kode'] : "");

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'imunisasi-m-grid',
    'dataProvider' => $modDataDiagnosaImunisasi->searchImunisasi(),
    'filter' => $modDataDiagnosaImunisasi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectDiagnosaImunisasi",
                                    "onClick" => "
                                                var data = $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatimunisasiblm') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatimunisasiblm') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatimunisasiblm') . '\").val(data+\", $data->diagnosa_nama\");
                                                }
                                                $(\"#dialogAddRiwayatImunisasisudah\").dialog(\"close\");    
                                        "))',
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pencarian Riwayat Imunisasi dialog yang sudah dilakukan =============================
?>

<?php
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPengobatanYgSudahDilakukan',
    'options' => array(
        'title' => 'Pencarian Data Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

$modObatAlkes = new RJObatAlkesM('searchObatAlkes');
$modObatAlkes->unsetAttributes();
if (isset($_GET['RJObatAlkesM']))
    $modObatAlkes->attributes = $_GET['RJObatAlkesM'];
$modObatAlkes->obatalkes_kode = (isset($_GET['RJObatAlkesM']['obatalkes_kode']) ? $_GET['RJObatAlkesM']['obatalkes_kode'] : "");
$modObatAlkes->obatalkes_nama = (isset($_GET['RJObatAlkesM']['obatalkes_nama']) ? $_GET['RJObatAlkesM']['obatalkes_nama'] : "");

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modObatAlkes->searchObatAlkes(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObatAlkes",
                                    "onClick" => "
                                                var data = $(\"#' . CHtml::activeId($modAnamnesa, 'pengobatanygsudahdilakukan') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'pengobatanygsudahdilakukan') . '\").val(\"$data->obatalkes_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'pengobatanygsudahdilakukan') . '\").val(data+\", $data->obatalkes_nama\");                                                  
                                                }
                                                  $(\"#dialogPengobatanYgSudahDilakukan\").dialog(\"close\");    
                                        "))',
        ),
        'obatalkes_kode',
        'obatalkes_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<script type="text/javascript">
    /**
     * print status
     */
    function printAnamnesa() {
        window.open('<?php echo $this->createUrl('printAnamnesa', array('pendaftaran_id' => $modAnamnesa->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=793,height=1122');
    }

    function defaultparamedis() {
        var paramedis = '<?php echo PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'))->nama_pegawai; ?>';
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

    function setOlahRaga(obj) {
        var status = $(obj).val();
        if (status == 0) {
            $('.olahraga').attr('readonly', true);
        } else {
            $('.olahraga').removeAttr('readonly', true);
        }
    }

    $(document).ready(function() {
        $('input[name$="[keb_olahraga]"][type="radio"]').each(function() {
            if ($(this).is(':checked')) {
                var status = $(this).val();
                if (status == 0) {
                    $('.olahraga').attr('readonly', true);
                } else {
                    $('.olahraga').removeAttr('readonly', true);
                }
            }
        });
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
</script>