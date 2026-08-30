<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'anamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
        ));
?>
<?php
$this->breadcrumbs = array(
    'Anamnesa',
);

$this->widget('bootstrap.widgets.BootAlert');
$this->renderPartial('_ringkasDataPasien', array());

$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Anamnesa', 'url' => $this->createUrl('/sistemAdministrator/AnamnesaRD'), 'linkOptions' => array('onclick' => 'return palidasiForm(this);'),'active'=>true),
        array('label' => 'Periksa Fisik', 'url' => $this->createUrl('/sistemAdministrator/PemeriksaanFisikRD'), 'linkOptions' => array('onclick' => 'return palidasiForm(this);')),
        array('label' => 'Laboratorium', 'url' => $this->createUrl('/sistemAdministrator/laboratoriumRD')),
        array('label' => 'Radiologi', 'url' => $this->createUrl('/sistemAdministrator/radiologiRD')),
        array('label' => 'Rehab Medis', 'url' => $this->createUrl('/sistemAdministrator/rehabMedisRD')),
        array('label' => 'Konsultasi Gizi', 'url' => $this->createUrl('/sistemAdministrator/konsulGiziRD')),
        array('label' => 'Konsul Poliklinik', 'url' => $this->createUrl('/sistemAdministrator/konsulPoliRD')),
        array('label' => 'Tindakan', 'url' => $this->createUrl('/sistemAdministrator/tindakanRD'), 'linkOptions' => array('onclick' => 'return palidasiForm(this);')),
        array('label' => 'Diagnosis', 'url' => $this->createUrl('/sistemAdministrator/diagnosaRD')),
        array('label' => 'Bedah Sentral', 'url' => $this->createUrl('/sistemAdministrator/bedahSentralRD')),
        array('label' => 'Rujukan Ke Luar', 'url' => $this->createUrl('/sistemAdministrator/rujukanKeluarRD')),
        array('label' => 'Reseptur', 'url' => $this->createUrl('/sistemAdministrator/resepturRD')),
        array('label' => 'Pemakaian Bahan', 'url' => $this->createUrl('/sistemAdministrator/pemakaianBahanRD')),
    ),
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($modAnamnesa); ?>
<table class="">
    <tr>
        <td>
            <?php //echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
            <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
            <?php echo $form->dropDownListRow($modAnamnesa, 'pegawai_id', CHtml::listData($modAnamnesa->DokterItems, 'pegawai_id', 'nama_pegawai'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
            <?php echo $form->dropDownListRow($modAnamnesa, 'paramedis_nama', CHtml::listData(ParamedisV::model()->findAll(), 'nama_pegawai', 'nama_pegawai'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>                        
            
            <div class="control-group">
                <?php echo $form->labelEx($modAnamnesa, 'keluhanutama', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                            'model'=>$modAnamnesa,
                            'attribute'=>'keluhanutama',
                            'data'=> explode(',', $modAnamnesa->keluhanutama),   
                            'debugMode'=>true,
                            'options'=>array(
                                //'bricket'=>false,
                                'json_url'=>$this->createUrl('//actionAjax/MasterKeluhan'),
                                'addontab'=> true, 
                                'maxitems'=> 10,
                                'input_min_size'=> 0,
                                'cache'=> true,
                                'newel'=> true,
                                'addoncomma'=>true,
                                'select_all_text'=> "", 
                            ),
                        ));
                    ?>
                    <?php echo $form->error($modAnamnesa, 'keluhanutama'); ?>
                </div>
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($modAnamnesa, 'riwayatpenyakitterdahulu', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($modAnamnesa, 'riwayatpenyakitterdahulu', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array('class' => 'btn btn-danger', 'onclick' => "$('#dialogAddRiwayatPenyakitTerdahulu').dialog('open');",
                        'id' => 'btnAddRiwayatPenyakitTerdahulu', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('riwayatpenyakitterdahulu')))
                    ?>
                    <?php echo $form->error($modAnamnesa, 'riwayatpenyakitterdahulu'); ?>
                </div>
            </div>
           
            <?php echo $form->textFieldRow($modAnamnesa, 'lamasakit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            <?php echo $form->textAreaRow($modAnamnesa, 'riwayatalergiobat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textAreaRow($modAnamnesa, 'riwayatkelahiran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textAreaRow($modAnamnesa, 'keterangananamesa', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </td>
        <td>
            <?php echo $form->labelEx($modAnamnesa, 'tglanamnesis', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modAnamnesa,
                    'attribute' => 'tglanamnesis',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT_MEDIUM,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div> 
            <div class="control-group">
                <?php echo $form->labelEx($modAnamnesa, 'keluhantambahan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                            'model'=>$modAnamnesa,
                            'attribute'=>'keluhantambahan',
                            'data'=> explode(',', $modAnamnesa->keluhantambahan),   
                            'debugMode'=>true,
                            'options'=>array(
                                'json_url'=>$this->createUrl('//actionAjax/MasterKeluhan'),
                                'addontab'=> true, 
                                'maxitems'=> 10,
                                'input_min_size'=> 0,
                                'cache'=> true,
                                'newel'=> true,
                                'addoncomma'=>true,
                                'select_all_text'=> "", 
                            ),
                        ));
                    ?>
                    <?php echo $form->error($modAnamnesa, 'keluhantambahan'); ?>
                </div>
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array('class' => 'btn btn-danger', 'onclick' => "$('#dialogAddRiwayatPenyakitKeluarga').dialog('open');",
                        'id' => 'btnAddRiwayatPenyakitKeluarga', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('riwayatpenyakitkeluarga')))
                    ?>
                    <?php echo $form->error($modAnamnesa, 'riwayatpenyakitkeluarga'); ?>
                </div>
            </div>
            <?php echo $form->textAreaRow($modAnamnesa, 'pengobatanygsudahdilakukan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textAreaRow($modAnamnesa, 'riwayatmakanan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modAnamnesa, 'riwayatimunisasi', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($modAnamnesa, 'riwayatimunisasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array('class' => 'btn btn-danger', 'onclick' => "$('#dialogAddRiwayatImunisasi').dialog('open');",
                        'id' => 'btnAddRiwayatImunisasi', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('riwayatimunisasi')))
                    ?>
                    <?php echo $form->error($modAnamnesa, 'riwayatimunisasi'); ?>
                </div>
            </div>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($modAnamnesa->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
    ?>
</div>

<?php $this->endWidget(); ?>

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
           if(confirm('Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?'))
               {
                    $('#url').val(obj);
                    $('#btn_simpan').click();
          
               }

        }      
   }
JS;
Yii::app()->clientScript->registerScript('validasi', $js, CClientScript::POS_HEAD);
?>   

<?php
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAddRiwayatPenyakitTerdahulu',
    'options' => array(
        'title' => 'Pencarian Data Diagnosa Penyakit Terdahulu',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-grid',
    'dataProvider' => $modDataDiagnosa->searchKeluhanPenyakit(),
    'filter' => $modDataDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
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
        'diagnosa_katakunci',
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
//========= Dialog buat Pencarian Diagnosa Penyakit Keluarga =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
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

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'penyakitkeluarga-m-grid',
    'dataProvider' => $modDataDiagnosa->searchKeluhanPenyakit(),
    'filter' => $modDataDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
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
        'diagnosa_katakunci',
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pencarian Diagnosa Penyakit Keluarga dialog =============================
?>

<?php
//========= Dialog buat Pencarian Riwayat Imunisasi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
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
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
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