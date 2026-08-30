<div class="row-fluid">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label("NPWP <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($modSupplier, 'supplier_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modSupplier,
                            'attribute' => 'supplier_npwp',
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                        url: "' . Yii::app()->createUrl('ActionAutoComplete/supplier') . '",
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
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.label);
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    setDataSupplier(ui.item);
                                    return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => $disableSupplier, 'class' => 'span4 required', 'placeholder' => 'Ketikkan NPWP Supplier'),
                        ));
                    ?>
                </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Supplier Nama <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSupplier, 'supplier_nama', array('readonly' => $disableSupplier, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Supplier <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
            <div class="controls">
                <?php echo $form->dropDownList($modSupplier,'supplier_jenis', LookupM::getItems('jenissupplier'),
                        array('disabled' => $disableSupplier,  'class' => 'span4 required', 'onclick' => 'cekPBF(this);', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            </div>
        </div>
        <div class="pbf">
            <div class="control-group">
                <?php echo $form->labelEx($modSupplier, 'pbf_id', array('class'=>'control-label', 
                    'label'=>'Perusahaan Besar Farmasi')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modSupplier,'pbf_id',
                        CHtml::listData(PbfM::model()->findAll("pbf_aktif = TRUE ORDER BY pbf_nama ASC"), 'pbf_id', 'pbf_nama'),
                        array('disabled' => $disableSupplier, 'style' => 'width: 240px', 'class'=>'span4 pbf_nama', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'empty'=>'-- Pilih --',)); ?>
                </div>
            </div>   
        </div>  
        <div class="control-group">
            <?php echo CHtml::label("Alamat Supplier <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($modSupplier, 'supplier_alamat', array('readonly' => $disableSupplier, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($modSupplier,'supplier_propinsi', CHtml::listData($modSupplier->PropinsiItems, 'propinsi_nama', 'propinsi_nama'),array('disabled' => $disableSupplier, 'empty'=>'-- Pilih --','class' => 'span4' ,'onkeypress'=>"return $(this).focusNextInputField(event)",'ajax'=>array('type'=>'POST','url'=>$this->createUrl('GetKabupatendrNamaPropinsi',array('encode'=>false,'namaModel'=>'SupplierM','attr'=>'supplier_propinsi')),'update'=>'#SupplierM_supplier_kabupaten'))); ?>
        <?php echo $form->dropDownListRow($modSupplier,'supplier_kabupaten',CHtml::listData($modSupplier->KabupatenItems, 'kabupaten_nama', 'kabupaten_nama'),array('disabled' => $disableSupplier, 'class'=>'inputRequire', 'class' => 'span4' ,'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>  

    </div>
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label("Nama Direktur <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSupplier, 'direktursupplier', array('readonly' => $disableSupplier, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label("Nomor Telepon <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSupplier, 'supplier_telp', array('readonly' => $disableSupplier, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label("Email <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSupplier, 'supplier_email', array('readonly' => $disableSupplier, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label("Nama Contact Person", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSupplier, 'supplier_cp', array('readonly' => $disableSupplier, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label("Jabatan Contact Person", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSupplier, 'supplier_cp_jabatan', array('readonly' => $disableSupplier, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label("Nomor Ponsel Contact Person", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSupplier, 'supplier_cp_hp', array('readonly' => $disableSupplier, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div> 
    
    </div>
</div>

<?php
//========= Dialog buat cari data Program Studi  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPenyedia',
    'options' => array(
        'title' => 'Pencarian Supplier',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modSupplier = new SupplierM('search');
$modSupplier->unsetAttributes();
if (isset($_GET['SupplierM'])) {
    $modSupplier->attributes = $_GET['SupplierM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'prodi-m-grid',
    'dataProvider' => $modSupplier->searchSupplierDialog(),
    'filter' => $modSupplier,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $attributes = $data->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal["$attribute"] = $data->$attribute;
                }
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array(
                    "class" => "btn-small",
                    "id" => "spk",
                    "onClick" => "setDataSupplier(" . CJSON::encode($returnVal) . "); $('#dialogPenyedia').dialog('close');return false;"
                ));
            }
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        array(
            'header' => 'Kode Supplier',
            'name' => 'supplier_kode',
            'value' => '$data->supplier_kode',
        ),
        array(
            'header' => 'Nama Supplier',
            'name' => 'supplier_nama',
            'value' => '$data->supplier_nama',
        ),
        array(
            'header' => 'NPWP Supplier',
            'name' => 'supplier_npwp',
            'value' => '$data->supplier_npwp',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Program Studi =============================
?>