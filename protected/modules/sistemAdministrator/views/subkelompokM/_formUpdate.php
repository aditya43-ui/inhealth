<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sasubkelompok-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>
<div class="row">
	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
	<?php echo $form->errorSummary($model); ?>
	<div class="col-sm-6">
		
			<div class="control-group">
				<label class="control-label" for="bidang">Kelompok <span style="color:red">*</span></label>
				<div class="controls">
					<?php echo $form->hiddenField($model, 'temp_kel_id') ?>
					<?php echo $form->hiddenField($model,'kelompok_id'); ?>
					<?php 
						$this->widget('MyJuiAutoComplete', array(                                            
							'name'=>'kelompokNama',
							'value'=>$model->kelompok->kelompok_nama,
							'source'=>'js: function(request, response) {
								$.ajax({
									url: "'.Yii::app()->createUrl('ActionAutoComplete/getKelompok').'",
									dataType: "json",
									data: {
										term: request.term,
									},
									success: function (data) {
										response(data);
									}
								})
							}',
							 'options'=>array(
								'showAnim'=>'fold',
								'minLength' => 2,
								'focus'=> 'js:function( event, ui ) {
									$(this).val( ui.item.label);
									return false;
								 }',
								'select'=>'js:function( event, ui ) { 
									$("#'.CHtml::activeId($model, 'kelompok_id').'").val(ui.item.kelompok_id);
									$("#kelompokNama").val(ui.item.kelompok_nama);
									kodeSubKelompok(ui.item.kelompok_id);
									return false;
								}',
							),
							'htmlOptions'=>array(
								'onkeypress'=>"return $(this).focusNextInputField(event)",
								'class' => 'required custom-only', 
							),
							'tombolDialog'=>array('idDialog'=>'dialogKelompok', 'idTombol'=>'tombolIdKelompok'),
						)); 
					?>
				</div>
			</div>

		<?php //Echo CHtml::hiddenField('tempKode', $model->subkelompok_kode); ?>
		<?php echo $form->hiddenField($model, 'temp_kode_subkel') ?>
		<?php echo $form->textFieldRow($model,'subkelompok_kode',array('readonly' => TRUE,'class'=>'span2 numbers-only', 'onkeyup'=>'setKode(this);','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>11,)); ?>
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'subkelompok_nama',array('onkeyup'=>'namaLain(this)','class'=>'span3 custom-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		<?php echo $form->textFieldRow($model,'subkelompok_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		<?php echo $form->checkBoxRow($model,'subkelompok_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>		
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
		Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
		array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
		'',
		array('class' => 'btn btn-default',
		'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php //$this->widget('UserTips',array('type'=>'create'));?>
    <?php
        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Sub Kelompok', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
        $tips = array(
            '0' => 'simpan',
            '1' => 'ulang',
            '2' => 'autocomplete-search',
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips' => $tips),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>
<?php $this->endWidget(); ?>
<?php //JS;
//Yii::app()->clientScript->registerScript('jsBarang',$jscript, CClientScript::POS_BEGIN);
//
//$js = <<< JS
//$('.numbersOnly').keyup(function() {
//var d = $(this).attr('numeric');
//var value = $(this).val();
//var orignalValue = value;
//value = value.replace(/[0-9]*/g, "");
//var msg = "Only Integer Values allowed.";
//
//if (d == 'decimal') {
//value = value.replace(/\./, "");
//msg = "Only Numeric Values allowed.";
//}
//
//if (value != '') {
//orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
//$(this).val(orignalValue);
//}
//});
//JS;
//Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);?>
<?php 
//Yii::app()->clientScript->registerScript('head','
//    function setKode(obj){
//        var value = $("#tempKode").val();
//        var objValue = $(obj).val();
//        if (objValue < value){
//           $(obj).val(value);
//        }
//    }
//',  CClientScript::POS_HEAD); ?>
<?php 
$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);?>
<?php
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogKelompok',
    'options'=>array(
        'title'=>'Kelompok',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
        'close'=>'js:function(){ backSize(); }',
    ),
));

$modKelompok= new SAKelompokM('search');
$modKelompok->unsetAttributes();
if(isset($_GET['SAKelompokM']))
    $modKelompok->attributes = $_GET['SAKelompokM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sainstalasi-m-grid',
	'dataProvider'=>$modKelompok->search(),
	'filter'=>$modKelompok,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
             array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectKelompok",
                                    "onClick" => "
                                    $(\"#'.CHtml::activeId($model, 'kelompok_id').'\").val(\'$data->kelompok_id\');
                                    $(\"#kelompokNama\").val(\'$data->kelompok_nama\');
                                    kodeSubKelompok($data->kelompok_id);
                                    backSize();
                                    $(\'#dialogKelompok\').dialog(\'close\');return false;"))'
                ),                 
                array(
                        'header'=>'Bidang',
                        'name' => 'bidang_id',
                        'filter'=> CHtml::dropDownList('SAKelompokM[bidang_id]',$modKelompok->bidang_id,CHtml::listData($model->BidangItems, 'bidang_id', 'bidang_nama'),array('empty'=>'-- Pilih --')),
                        //'value'=>'$this->grid->getOwner()->renderPartial(\'sistemAdministrator.views.subkelompokM.listGolongan\', array(\'idKelompok\'=>$data->kelompok_id))',
                        'value'=>'$data->bidang->bidang_nama',
                ),
                array(
                        'header'=>'Kelompok ',
                        'name' => 'kelompok_nama',
                      //  'filter'=>  CHtml::listData($model->KelompokItems, 'kelompok_id', 'kelompok_nama'),
                        'value'=>'$data->kelompok_nama',
                ),

		
                
               
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
<script>
    function namaLain(obj){
        $("#<?php echo Chtml::activeId($model, 'subkelompok_namalainnya') ?>").val($(obj).val());
    }
    
    function kodeSubKelompok(id){
        var kelompok_id = id;
        var temp_kel_id = $("#<?php echo Chtml::activeId($model, 'temp_kel_id') ?>").val();
        var temp_kode_subkel = $("#<?php echo Chtml::activeId($model, 'temp_kode_subkel') ?>").val();
        
        $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('KodeSubKelompok'); ?>',
        data: {kelompok_id:kelompok_id},
        dataType: "json",
        success:function(data){           
            if (data.sukses == '0'){                
                myAlert(data.pesan);
                return false;
            }else if (data.sukses == 'kodebaru'){         
                if (kelompok_id == temp_kel_id){
                    $("#<?php echo Chtml::activeId($model, 'subkelompok_kode'); ?>").val(temp_kode_subkel); 
                }else{
                    $("#<?php echo Chtml::activeId($model, 'subkelompok_kode'); ?>").val(data.kodebaru);                
                    return false;
                }
            }else if (data.sukses == 'kosong'){
                if (kelompok_id == temp_kel_id){
                    $("#<?php echo Chtml::activeId($model, 'subkelompok_kode'); ?>").val(temp_kode_subkel); 
                }else{
                    $("#<?php echo Chtml::activeId($model, 'subkelompok_kode'); ?>").val(data.kodebaru);
                    return false;
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);
            
            }
        });
    }
    
    function changeSize()
    {            
        window.parent.document.getElementById('frame').style= 'overflow-y:scroll;height:600px;';            
    }
    
    function backSize()
    {
        window.parent.document.getElementById('frame').style= 'overflow-y:scroll;height:350px;';  
    }
    
    $("#tombolIdKelompok").click(function(){
        changeSize();
    });
</script>