<?php
//komen buat ngepull
$this->breadcrumbs = array(
    'Anamnesa',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Anamnesa berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RKAnamnesaT_keluhanutama_annoninput .maininput',
));
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
<i class="fa fa-user-md"></i> Pemeriksaan <b>Anamnesa</b></div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                                ?></p>-->
                    <?php echo $form->errorSummary($modAnamnesa); ?>
                    <div class="col-sm-6">
                        <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                        <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                        <?php echo $form->dropDownListRow($modAnamnesa, 'pegawai_id', CHtml::listData($modAnamnesa->getDokterItems($modPendaftaran->ruangan_id), 'pegawai_id', 'NamaLengkap'), array('onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
                        <?php // echo $form->dropDownListRow($modAnamnesa, 'paramedis_nama', CHtml::listData(ParamedisV::model()->findAll("ruangan_id = ".Yii::app()->user->getState('ruangan_id')), 'nama_pegawai', 'NamaLengkap'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                        ?>
                        <div class="control-group">
                            <?php
                            echo $form->label($modAnamnesa, 'perawat', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modAnamnesa, 'paramedis_nama', CHtml::listData($modAnamnesa->getParamedisItems($modPendaftaran->ruangan_id), 'pegawai.nama_pegawai', 'pegawai.NamaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                        </div>
                        <?php //echo $form->textAreaRow($modAnamnesa, 'keluhanutama', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                        ?>

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
                            <label class="control-label" for="RKAnamnesaT_riwayatperjalananpasien">Riwayat Perjalanan Penyakit Pasien</label>
                            <div class="controls">
                                <?php echo $form->textArea($modAnamnesa, 'riwayatperjalananpasien', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

                                <?php echo $form->error($modAnamnesa, 'riwayatperjalananpasien'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modAnamnesa, 'lamasakit', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modAnamnesa, 'lamasakit', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", "maxlength" => 2)); ?>
                                <?php echo $form->dropDownList($modAnamnesa, 'satuanWaktu', array('Hari' => 'Hari', 'Minggu' => 'Minggu', 'Bulan' => 'Bulan', 'Tahun' => 'Tahun'), array('class' => 'span2', 'empty' => '-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modAnamnesa, 'riwayatpenyakitterdahulu', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textArea($modAnamnesa, 'riwayatpenyakitterdahulu', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
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
                            <?php echo $form->labelEx($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textArea($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                <?php
                                echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array(
                                    'class' => 'btn btn-danger', 'onclick' => "$('#dialogAddRiwayatPenyakitKeluarga').dialog('open');",
                                    'id' => 'btnAddRiwayatPenyakitKeluarga', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('riwayatpenyakitkeluarga')
                                ))
                                ?>
                                <?php echo $form->error($modAnamnesa, 'riwayatpenyakitkeluarga'); ?>
                            </div>
                        </div>
                        <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatpenyakitterdahulu', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));  
                        ?>
                        <?php echo $form->textAreaRow($modAnamnesa, 'riwayatalergiobat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <?php if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KEBIDANAN) : ?>
                            <div class="control-group">
                                <?php
                                if (!empty($modAnamnesa->hpht)) $modAnamnesa->hpht = MyFormatter::formatDateTimeForUser($modAnamnesa->hpht);
                                echo $form->labelEx($modAnamnesa, 'hpht', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modAnamnesa,
                                        'attribute' => 'hpht',
                                        'value' => null,
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true,
                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'class' => 'span3 htpd',
                                        ),
                                    ));
                                    ?>
                                    <?php
                                    echo CHtml::htmlButton('Kosongkan', array(
                                        'class' => 'btn btn-danger', 'onclick' => "$('.htpd').val('');",
                                        'id' => 'btnKosongAPHT', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    ))
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php
                                if (!empty($modAnamnesa->tgl_persalinan)) $modAnamnesa->tgl_persalinan = MyFormatter::formatDateTimeForUser($modAnamnesa->tgl_persalinan);
                                echo $form->labelEx($modAnamnesa, 'tgl_persalinan', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modAnamnesa,
                                        'attribute' => 'tgl_persalinan',
                                        'value' => null,
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            //'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true,
                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'class' => 'span3 tgl_persalinan',
                                        ),
                                    ));
                                    ?>
                                    <?php
                                    echo CHtml::htmlButton('Kosongkan', array(
                                        'class' => 'btn btn-danger', 'onclick' => "$('.tgl_persalinan').val('');",
                                        'id' => 'btnKosongTglPersalinan', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    ))
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                    <div class="col-sm-6">
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
                                        'readonly' => true, 'class' => 'span3 realtime',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php //echo $form->textAreaRow($modAnamnesa, 'keluhantambahan', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                        ?>

                        <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                        ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modAnamnesa, 'pengobatanygsudahdilakukan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textArea($modAnamnesa, 'pengobatanygsudahdilakukan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 1000)); ?>
                                <?php
                                echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array(
                                    'class' => 'btn btn-danger', 'onclick' => "$('#dialogPengobatanYgSudahDilakukan').dialog('open');",
                                    'id' => 'btnAddPengobatanYgSudahDilakukan', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('pengobatanygsudahdilakukan')
                                ))
                                ?>
                                <?php echo $form->error($modAnamnesa, 'pengobatanygsudahdilakukan'); ?>
                            </div>
                        </div>
                        <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatalergiobat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                        ?>
                        <?php echo $form->textAreaRow($modAnamnesa, 'riwayatmakanan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatkelahiran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                        ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modAnamnesa, 'riwayatkelahiran', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                                    'model' => $modAnamnesa,
                                    'attribute' => 'riwayatkelahiran',
                                    'data' => explode(',', $modAnamnesa->riwayatkelahiran),
                                    'debugMode' => true,
                                    'options' => array(
                                        //'bricket'=>false,
                                        'htmlOptions' => array('style' => 'width:100%;'),
                                        'json_url' => $this->createUrl('/ActionAutoComplete/MasterRiwayatKelahiran'),
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
                            <?php echo $form->labelEx($modAnamnesa, 'riwayatimunisasi', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textArea($modAnamnesa, 'riwayatimunisasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
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
                            <?php echo $form->labelEx($modAnamnesa, 'statusmerokok', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="radio inline">
                                    <div class="form-inline">
                                        <?php echo $form->radioButtonList($modAnamnesa, 'statusmerokok', array('0' => 'Tidak', '1' => 'Ya'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'statusrokok', 'onclick' => 'setJumlahRokok(this);')); ?>
                                    </div>
                                </div>
                                <?php echo $form->error($modAnamnesa, 'statusmerokok'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modAnamnesa, 'jmlrokok_btg_hr', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modAnamnesa, 'jmlrokok_btg_hr', array('class' => 'span1 jmlbtg', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->labelEx($modAnamnesa, 'Per Hari') ?>
                            </div>
                        </div>
                        <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatimunisasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                        ?>

                        <?php echo $form->textAreaRow($modAnamnesa, 'keterangananamesa', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                    <?php
                    if (Yii::app()->user->getState('instalasi_id') == PARAMS::INSTALASI_ID_RD) {
                        $this->renderPartial($this->path_view . '_formInputTriase', array('modAnamnesa' => $modAnamnesa, 'form' => $form));
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php

            if ($modAnamnesa->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'enabled' => true)
                );
                echo CHtml::link(Yii::t('mds', '{icon} Print Anamnesa', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => 'true', 'style' => 'cursor:not-allowed;'));
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => false)
                ); //RND-8620
                echo CHtml::link(Yii::t('mds', '{icon} Print Anamnesa', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printAnamnesa();return false", 'enabled' => 'true'));
            }
            ?>
            <?php
            $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
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

$modDataDiagnosa = new RKDiagnosaM('searchDiagnosaAnamnesa');
$modDataDiagnosa->unsetAttributes();
if (isset($_GET['RKDiagnosaM']))
    $modDataDiagnosa->attributes = $_GET['RKDiagnosaM'];
$modDataDiagnosa->diagnosa_nama = (isset($_GET['RKDiagnosaM']['diagnosa_nama']) ? $_GET['RKDiagnosaM']['diagnosa_nama'] : "");
$modDataDiagnosa->diagnosa_namalainnya = (isset($_GET['RKDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RKDiagnosaM']['diagnosa_namalainnya'] : "");
$modDataDiagnosa->diagnosa_kode = (isset($_GET['RKDiagnosaM']['diagnosa_kode']) ? $_GET['RKDiagnosaM']['diagnosa_kode'] : "");
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
$modDataDiagnosaKeluarga = new RKDiagnosaM('searchDiagnosaAnamnesa');
$modDataDiagnosaKeluarga->unsetAttributes();
if (isset($_GET['RKDiagnosaM']))
    $modDataDiagnosaKeluarga->attributes = $_GET['RKDiagnosaM'];
$modDataDiagnosaKeluarga->diagnosa_nama = (isset($_GET['RKDiagnosaM']['diagnosa_nama']) ? $_GET['RKDiagnosaM']['diagnosa_nama'] : "");
$modDataDiagnosaKeluarga->diagnosa_namalainnya = (isset($_GET['RKDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RKDiagnosaM']['diagnosa_namalainnya'] : "");
$modDataDiagnosaKeluarga->diagnosa_kode = (isset($_GET['RKDiagnosaM']['diagnosa_kode']) ? $_GET['RKDiagnosaM']['diagnosa_kode'] : "");

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
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

$modDataDiagnosaImunisasi = new RKDiagnosaM('searchImunisasi');
$modDataDiagnosaImunisasi->unsetAttributes();
if (isset($_GET['RKDiagnosaM']))
    $modDataDiagnosaImunisasi->attributes = $_GET['RKDiagnosaM'];
$modDataDiagnosaImunisasi->diagnosa_nama = (isset($_GET['RKDiagnosaM']['diagnosa_nama']) ? $_GET['RKDiagnosaM']['diagnosa_nama'] : "");
$modDataDiagnosaImunisasi->diagnosa_namalainnya = (isset($_GET['RKDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RKDiagnosaM']['diagnosa_namalainnya'] : "");
$modDataDiagnosaImunisasi->diagnosa_kode = (isset($_GET['RKDiagnosaM']['diagnosa_kode']) ? $_GET['RKDiagnosaM']['diagnosa_kode'] : "");

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

$modObatAlkes = new RKObatAlkesM('searchObatAlkes');
$modObatAlkes->unsetAttributes();
if (isset($_GET['RKObatAlkesM']))
    $modObatAlkes->attributes = $_GET['RKObatAlkesM'];
$modObatAlkes->obatalkes_kode = (isset($_GET['RKObatAlkesM']['obatalkes_kode']) ? $_GET['RKObatAlkesM']['obatalkes_kode'] : "");
$modObatAlkes->obatalkes_nama = (isset($_GET['RKObatAlkesM']['obatalkes_nama']) ? $_GET['RKObatAlkesM']['obatalkes_nama'] : "");

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
        window.open('<?php echo $this->createUrl('printAnamnesa', array('pendaftaran_id' => $modAnamnesa->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=793,height=1122,scrollbars=yes');
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

        // defaultparamedis();     
    });
</script>