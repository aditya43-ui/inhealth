<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahDebitKreditPenerimaan-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
?>
<p class="help-block">
    <?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model, 'jenispenerimaan_id',array('readonly'=>true)); ?>
<?php echo $form->hiddenField($model, 'rekeningdebit_id',array('readonly'=>true)); ?>
<?php echo $form->hiddenField($model, 'rekeningkredit_id',array('readonly'=>true)); ?>
<?php echo $form->textFieldRow($model, 'jenispenerimaan_nama',array('readonly'=>true)); ?>
<?php echo $form->textFieldRow($model, 'jenispenerimaan_namalain',array('readonly'=>true)); ?>

<div class='control-group'>
                                  <?php echo $form->labelEx($model,'rekeningdebit_id', array('class'=>'control-label')) ?>
                             <div class="controls">
                                 <?php //echo $form->hiddenField($model,'rekeningdebit_id',array('class'=>'span3','maxlength'=>50)); ?>
                                    <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                            'model' => $model,
                                            'value'=>$model->rekeningdebit->nmrekening5,
                                            'attribute' => 'rekDebit',
                                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 2,
                                                'focus' => 'js:function( event, ui ) {
                                                        $(this).val(ui.item.nmstruktur);
                                                        return false;
                                                    }',
                                                'select' => 'js:function( event, ui ) {
                                                                $(this).val(ui.item.nmstruktur);
                                                                $("#' . CHtml::activeId($model, 'rekeningdebit_id') . '").val(ui.item.rincianobyek_id);
                                                                    return false;
                                                              }'
                                            ),
                                            'htmlOptions' => array(
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class'=>'span2',
                                                'style'=>'width:150px;',
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogRekDebit',),
                                        ));
                                    ?>
                             </div>
                   </div>
                    
                   <div class='control-group'>
                                  <?php echo $form->labelEx($model,'rekeningkredit_id', array('class'=>'control-label')) ?>
                             <div class="controls">
                                  <?php //echo $form->hiddenField($model,'rekeningkredit_id',array('class'=>'span3','maxlength'=>50)); ?>
                                    <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                            'model' => $model,
                                            'value'=>$model->rekeningkredit->nmrekening5,
                                            'attribute' => 'rekKredit',
                                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 2,
                                                'focus' => 'js:function( event, ui ) {
                                                        $(this).val(ui.item.nmstruktur);
                                                        return false;
                                                    }',
                                                'select' => 'js:function( event, ui ) {
                                                                $(this).val(ui.item.nmstruktur);
                                                                $("#' . CHtml::activeId($model, 'rekeningkredit_id') . '").val(ui.item.rincianobyek_id);
                                                                    return false;
                                                              }'
                                            ),
                                            'htmlOptions' => array(
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class'=>'span2',
                                                'style'=>'width:150px;',
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogRekKredit',),
                                        ));
                                    ?>
                             </div>
                   </div>
<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function loadDataJenisPenerima()
    {
        var penerimaan = $('#temp_idPenerimaan').val();
        $.post("<?php echo Yii::app()->createUrl('ActionAjax/cariJenisPenerimaan')?>", { penerimaan: penerimaan },
            function(data){
                $('#JenispenerimaanM_jenispenerimaan_id').val(data.jenispenerimaan_id);
                $('#JenispenerimaanM_rekeningdebit_id').val(data.rekeningdebit_id);
                $('#JenispenerimaanM_rekeningkredit_id').val(data.rekeningkredit_id);
                $('#JenispenerimaanM_jenispenerimaan_nama').val(data.jenispenerimaan_nama);
                $('#JenispenerimaanM_jenispenerimaan_namalain').val(data.jenispenerimaan_namalain);
        }, "json");
    }
    loadDataJenisPenerima();
</script>


<?php 
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekDebit',
    'options'=>array(
        'title'=>'Daftar Rekening Debit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>700,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modRekDebit = new RekeningakuntansiV('search');
$modRekDebit->unsetAttributes();
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'rekdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekDebit->search(),
	'filter'=>$modRekDebit,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Kode Rekening</center>',
                'start'=>1, //indeks kolom 3
                'end'=>5, //indeks kolom 4
            ),
            array(
                'name'=>'<center>Saldo Normal</center>',
                'start'=>8, //indeks kolom 3
                'end'=>9, //indeks kolom 4
            ),
        ),
	'columns'=>array(
                array(
                    'header'=>'No Urut',
                    'value'=>'$data->nourutrek',
                ),
                array(
                    'header'=>'Rek. 1',
                    'value'=>'$data->kdstruktur',
                ),
                array(
                    'header'=>'Rek. 2',
                    'value'=>'$data->kdkelompok',
                ),
                array(
                    'header'=>'Rek. 3',
                    'value'=>'$data->kdjenis',
                ),
                array(
                    'header'=>'Rek. 4',
                    'value'=>'$data->kdobyek',
                ),
                array(
                    'header'=>'Rek. 5',
                    'value'=>'$data->kdrincianobyek',
                ),
                array(
                    'header'=>'Nama Rekening',
                    'value'=>'$data->nmrincianobyek',
                ),
                array(
                    'header'=>'Nama Lain',
                    'value'=>'$data->nmrincianobyeklain',
                ),
                array(
                    'header'=>'Saldo Normal',
                    'value'=>'$data->rincianobyek_nb',
                ),
            
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                                $(\"#JenispenerimaanM_rekeningdebit_id\").val(\"$data->rincianobyek_id\");
                                                $(\"#JenispenerimaanM_rekDebit\").val(\"$data->nmrincianobyek\");                                                
                                                $(\"#dialogRekDebit\").dialog(\"close\");    
                                                return false;
                            "))',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>
        
<?php 
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekKredit',
    'options'=>array(
        'title'=>'Daftar Rekening Kredit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modRekKredit = new RekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'rekdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekKredit->search(),
	'filter'=>$modRekKredit,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Kode Rekening</center>',
                'start'=>1, //indeks kolom 3
                'end'=>5, //indeks kolom 4
            ),
        ),
	'columns'=>array(
                array(
                    'header'=>'No Urut',
                    'value'=>'$data->nourutrek',
                ),
                array(
                    'header'=>'Rek. 1',
                    'value'=>'$data->kdstruktur',
                ),
                array(
                    'header'=>'Rek. 2',
                    'value'=>'$data->kdkelompok',
                ),
                array(
                    'header'=>'Rek. 3',
                    'value'=>'$data->kdjenis',
                ),
                array(
                    'header'=>'Rek. 4',
                    'value'=>'$data->kdobyek',
                ),
                array(
                    'header'=>'Rek. 5',
                    'value'=>'$data->kdrincianobyek',
                ),
                array(
                    'header'=>'Nama Rekening',
                    'value'=>'$data->nmrincianobyek',
                ),
                array(
                    'header'=>'Nama Lain',
                    'value'=>'$data->nmrincianobyeklain',
                ),
                array(
                    'header'=>'Saldo Normal',
                    'value'=>'$data->rincianobyek_nb',
                ),
            
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                                $(\"#JenispenerimaanM_rekeningkredit_id\").val(\"$data->rincianobyek_id\");
                                                $(\"#JenispenerimaanM_rekKredit\").val(\"$data->nmrincianobyek\");
                                                $(\"#dialogRekKredit\").dialog(\"close\");    
                                                return false;
                            "))',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>