<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sabidang-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
	'focus'=>'#golonganNama',
)); ?>
<div class="row">
	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
	<?php echo $form->errorSummary($model); ?>
	<div class="col-sm-6">		
		<div class="control-group">
			<!--<label class="control-label" for="golongan">Golongan</label>-->
			<?php  echo $form->dropDownListRow($model, 'golongan_id', CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'),array('empty'=>'-- Pilih --', 'onchange' => 'kodeBidang(this)')); ?>
			<div class="controls">
			<?php //echo $form->hiddenField($model,'golongan_id'); ?>
			<?php 

					/*$this->widget('MyJuiAutoComplete', array(

									'name'=>'golonganNama',
									'source'=>'js: function(request, response) {
												   $.ajax({
													   url: "'.Yii::app()->createUrl('ActionAutoComplete/getGolongan').'",
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
												$("#'.CHtml::activeId($model, 'golongan_id').'").val(ui.item.golongan_id);
												$("#golonganNama").val(ui.item.golongan_nama);
												return false;
											}',
									),
									'htmlOptions'=>array(
											'onkeypress'=>"return $(this).focusNextInputField(event)",                                                    
									),
									'tombolDialog'=>array('idDialog'=>'dialogGolongan'),
								)); */
				?>
			</div>
		</div>
		<?php //Echo CHtml::hiddenField('tempKode', $model->bidang_kode); ?>
		<?php echo $form->textFieldRow($model,'bidang_kode',array('readonly' => TRUE ,'class'=>'span1 angkadot-only', 'onkeyup'=>'setKode(this);','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>5,)); ?>
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'bidang_nama',array('onkeyup' => 'namaLain(this)','class'=>'span4 custom-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		<?php echo $form->textFieldRow($model,'bidang_namalainnya',array('class custom-only'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		<?php //echo $form->checkBoxRow($model,'bidang_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>		
	</div>	
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
		Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
		array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
		'',
		array('class' => 'btn btn-default',
		'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php //$this->widget('UserTips',array('type'=>'create'));?>
    <?php
        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Bidang', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
        $tips = array(
            '0' => 'simpan',
            '1' => 'ulang',
        );
        $content = $this->renderPartial($this->path_tips.'detailTips',array('tips'=>$tips),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
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
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogGolongan',
    'options'=>array(
        'title'=>'Sub Golongan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modgolongan= new SAGolonganM('search');
$modgolongan->unsetAttributes();
if(isset($_GET['SAGolonganM']))
    $modgolongan->attributes = $_GET['SAGolonganM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sainstalasi-m-grid',
	'dataProvider'=>$modgolongan->search(),
	'filter'=>$modgolongan,
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
                                    $(\"#'.CHtml::activeId($model, 'golongan_id').'\").val($data->golongan_id);
                                    $(\"#golonganNama\").val(\'$data->golongan_nama\');
                                    $(\'#dialogGolongan\').dialog(\'close\');return false;"))'
                ),
 array(
                      'header'=>'Golongan',
                     'filter'=>  CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'),
                      'type'=>'raw',                      
                      'value'=>'$data->golongan_nama',
               ),
                /*array(
                        'header'=>'Kelompok ',
                        'filter'=>  CHtml::listData($model->KelompokItems, 'kelompok_id', 'kelompok_nama'),
                        'value'=>'$data->kelompok->kelompok_nama',
                ),*/

		
                
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
<script>
    function namaLain(obj){
        $("#<?php echo Chtml::activeId($model, 'bidang_namalainnya') ?>").val($(obj).val());
    }
    
    function kodeBidang(obj){
        var golongan_id = $(obj).val();
        
        $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('KodeBidang'); ?>',
        data: {golongan_id:golongan_id},
        dataType: "json",
        success:function(data){           
            if (data.sukses == '0'){                
                myAlert(data.pesan);
                return false;
            }else if (data.sukses == 'kodebaru'){
                $("#<?php echo Chtml::activeId($model, 'bidang_kode'); ?>").val(data.kodebaru);                
                return false;
            }else if (data.sukses == 'kosong'){
                $("#<?php echo Chtml::activeId($model, 'bidang_kode'); ?>").val(data.kodebaru);
                return false;
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);
            
            }
        });
    }
</script>
