<table>
    <tr>
        <td width="50%">
            <div class="control-group">
                <?php echo $form->labelEx($modUnitDosis, 'alergiobat', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($modUnitDosis, 'alergiobat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array('class' => 'btn btn-danger', 'onclick' => "$('#dialogAddAlergi').dialog('open');",
                        'id' => 'btnAddAlergi', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modUnitDosis->getAttributeLabel('alergiobat')))
                    ?>
                    <?php echo $form->error($modUnitDosis, 'alergiobat'); ?>
                </div>
            </div> 
        </td>
        
        <td>
            <div class="control-group">
                <?php echo $form->labelEx($modUnitDosis,'beratbadan_kg', array('class'=>'control-label inline')) ?>

                <div class="controls">
                    <?php echo $form->textField($modUnitDosis,'tinggibadan_cm', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbersOnly','maxlength'=>3,'placeholder'=>'')); ?> cm 
                    <?php echo $form->textField($modUnitDosis,'beratbadan_kg', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbersOnly','maxlength'=>3,'placeholder'=>'')); ?> kg           
                    <?php echo $form->error($modUnitDosis, 'tinggibadan_cm'); ?>
                    <?php echo $form->error($modUnitDosis, 'beratbadan_kg'); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($modUnitDosis,'diagnosa_id',CHtml::listData($diagnosa, 'diagnosa_id', 'diagnosa_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --'));?>
            <?php echo $form->dropDownListRow($modUnitDosis,'jenisdiet_id',CHtml::listData($jenisdiet, 'jenisdiet_id', 'jenisdiet_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --'));?>
        </td>
    </tr>
</table>
<?php
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAddAlergi',
    'options' => array(
        'title' => 'Pencarian Data Alergi Terdahulu',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modAlergi = new RIAnamnesaT('searchAleregi');
$pendaftaran_id = $_GET['pendaftaran_id'];
$modAlergi->unsetAttributes();
if (isset($_GET['RIAnamnesaT'])) {
    $modAlergi->attributes = $_GET['RIAnamnesaT'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-grid',
    'dataProvider' => $modAlergi->searchAlergi($pendaftaran_id),
    'filter' => $modAlergi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
                                                var data = $(\"#' . CHtml::activeId($modUnitDosis, 'alergiobat') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($modUnitDosis, 'alergiobat') . '\").val(\"$data->riwayatalergiobat\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($modUnitDosis, 'alergiobat') . '\").val(data+\", $data->riwayatalergiobat\");                                                  
                                                }
                                                  $(\"#dialogAddAlergi\").dialog(\"close\");    
                                        "))',
        ),
        array(
          'header'=>'Riwayat Alergi Obat',
          'type'=>'raw',
          'value'=>'$data->riwayatalergiobat',
        ),
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>