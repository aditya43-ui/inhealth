<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Riwayat Penyakit</div>
            </div>
            <div class="panel-body">
                <div class="col-xs-6">
                    <div class="control-group ">
                        
                        <div class="controls">
                         
                        <div class="control-group ">
                        <?php echo $form->labelEx($modPPBuatJanjiPoli,'rv_golongandarah', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPPBuatJanjiPoli,'rv_golongandarah', LookupM::getItems('golongandarah'),  
                                                        array('empty'=>'- Pilih -', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'form-control span1')); ?>   
                          
                            <?php echo $form->error($modPPBuatJanjiPoli, 'rv_golongandarah'); ?>
                         
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPPBuatJanjiPoli, 'rv_tekanandarah', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPPBuatJanjiPoli, 'rv_tekanandarah', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", "maxlength" => 100)); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPPBuatJanjiPoli, 'rv_statuskehamilan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modPPBuatJanjiPoli, 'rv_statuskehamilan', array('0' => 'Tidak', '1' => 'Ya'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'statusrokok', 'onclick' => 'setHamil(this);')); ?>            

                            <?php echo $form->textField($modPPBuatJanjiPoli, 'rv_usia_kehamilan', array('class' => 'span1 statushamil integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->labelEx($modPPBuatJanjiPoli, 'Bulan') ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPPBuatJanjiPoli, 'rv_riwayatpenyakitterdahulu', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textArea($modPPBuatJanjiPoli, 'rv_riwayatpenyakitterdahulu', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            <?php
                            echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-primary', 'onclick' => "$('#dialogAddRiwayatPenyakitTerdahulu').dialog('open');",
                                'id' => 'btnAddRiwayatPenyakitTerdahulu', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modPPBuatJanjiPoli->getAttributeLabel('riwayatpenyakitterdahulu')))
                            ?>
                            <?php echo $form->error($modPPBuatJanjiPoli, 'rv_riwayatpenyakitterdahulu'); ?>
                        </div>
                    </div>
                    <?php echo $form->textAreaRow($modPPBuatJanjiPoli, 'rv_riwayatalergiobat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textAreaRow($modPPBuatJanjiPoli, 'rv_riwayatmakanan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 1000)); ?>
                </div>


            </div>
        </div>
        <ul class="list-inline pull-left">
            <li><button type="button" class="btn btn-default prev-step">Kembali</button></li>

        </ul>
        <ul class="list-inline pull-right">

            <li><button type="button" class="btn btn-primary next-step" >Lanjut</button></li>      </ul>
    </div>
</div>
<?php
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAddRiwayatPenyakitTerdahulu',
    'options' => array(
        'title' => 'Pencarian Data Diagnosa Penyakit Terdahulu',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 440,
        'resizable' => false,
    ),
));

$modDataDiagnosa = new EKDiagnosaM('searchDiagnosaAnamnesa');
$modDataDiagnosa->unsetAttributes();
if (isset($_GET['EKDiagnosaM']))
    $modDataDiagnosa->attributes = $_GET['EKDiagnosaM'];
$modDataDiagnosa->diagnosa_nama = (isset($_GET['EKDiagnosaM']['diagnosa_nama']) ? $_GET['EKDiagnosaM']['diagnosa_nama'] : "");
$modDataDiagnosa->diagnosa_namalainnya = (isset($_GET['EKDiagnosaM']['diagnosa_namalainnya']) ? $_GET['EKDiagnosaM']['diagnosa_namalainnya'] : "");
$modDataDiagnosa->diagnosa_kode = (isset($_GET['EKDiagnosaM']['diagnosa_kode']) ? $_GET['EKDiagnosaM']['diagnosa_kode'] : "");
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
                                                var data = $(\"#' . CHtml::activeId($modPPBuatJanjiPoli, 'rv_riwayatpenyakitterdahulu') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($modPPBuatJanjiPoli, 'rv_riwayatpenyakitterdahulu') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($modPPBuatJanjiPoli, 'rv_riwayatpenyakitterdahulu') . '\").val(data+\", $data->diagnosa_nama\");                                                  
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