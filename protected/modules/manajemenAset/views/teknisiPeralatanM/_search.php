<?php
/**
* - digunakan untuk Admin Teknisi Peralatan
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sagolongan-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'namateknisi',array('class'=>'span3','placeholder'=>'Ketik Nama Teknisi')); ?>
		<?php echo $form->hiddenField($model,'kabupaten_id',array('class'=>'span3','placeholder'=>'Ketik Nama Teknisi')); ?>
        <div class="control-group">
            <?php echo CHtml::label("Domisili",'',array('class' => 'control-label')); ?>
            <div class="controls">
               <?php $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$model,
                                        'attribute' => 'kabupaten_nama',
                                        'source' => 'js: function(request, response) {
                                                $.ajax({
                                                        url: "' . $this->createUrl('AutoCompleteKabupaten') . '",
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
                                                        $(this).val( ui.item.label);
                                                        refreshDialogOA();
                                                        return false;
                                                }',
                                                'select' => 'js:function( event, ui ) {
                                                        $("#'.Chtml::activeId($model, 'kabupaten_id') . '").val(ui.item.kabupaten_id); 
                                                        $("#'.Chtml::activeId($model, 'kabupaten_nama') . '").val(ui.item.kabupaten_nama); 
                                                        return false;
                                                }',
                                        ),
                                        'htmlOptions' => array(
                                                'placeholder'=>'Ketik Nama Domisili',
                                                'class'=>'span3',
                                                'onkeyup'=>"return $(this).focusNextInputField(event)",
                                        ),
                                        ))?>
            </div>
        </div>
	</div>
	<div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->hiddenField($model,'kabupaten_id',array('class'=>'span3')); ?>
            <?php echo CHtml::label("Supplier",'',array('class' => 'control-label')); ?>
            <div class="controls">
               <?php $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$model,
                                        'attribute' => 'supplier_nama',
                                        'source' => 'js: function(request, response) {
                                                $.ajax({
                                                        url: "' . $this->createUrl('AutoCompleteSupplier') . '",
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
                                                        $(this).val( ui.item.label);
                                                        refreshDialogOA();
                                                        return false;
                                                }',
                                                'select' => 'js:function( event, ui ) {
                                                        $("#'.Chtml::activeId($model, 'supplier_id') . '").val(ui.item.supplier_id); 
                                                        $("#'.Chtml::activeId($model, 'supplier_nama') . '").val(ui.item.supplier_nama); 
                                                        return false;
                                                }',
                                        ),
                                        'htmlOptions' => array(
                                                'placeholder'=>'Ketik Nama Supplier',
                                                'class'=>'span3',
                                                'onkeyup'=>"return $(this).focusNextInputField(event)",
                                        ),
                                        ))?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Kelamin",'',array('class' => 'control-label')); ?>
            <div class="controls">
               <?php echo Chtml::activeDropDownList($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --')) ?>
            </div>
        </div>
		
    </div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>
<?php $this->endWidget(); ?>
