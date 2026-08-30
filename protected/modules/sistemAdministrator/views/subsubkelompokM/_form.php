<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sasubsubkelompok-m-form',
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
			<label class="control-label" for="bidang">Sub Kelompok <span style="color:red">*</span></label>
			<div class="controls">
				<?php echo $form->hiddenField($model,'subkelompok_id'); ?>
				<?php 
					$this->widget('MyJuiAutoComplete', array(                                            
						'name'=>'subkelompokNama',
						'source'=>'js: function(request, response) {
							$.ajax({
								url: "'.Yii::app()->createUrl('ActionAutoComplete/getSubKelompok').'",
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
								$("#'.CHtml::activeId($model, 'subkelompok_id').'").val(ui.item.subkelompok_id);
								$("#subkelompokNama").val(ui.item.subkelompok_nama);
								kodeSubSubKelompok(ui.item.subkelompok_id);
								return false;
							 }',
						),
						'htmlOptions'=>array(
							'onkeypress'=>"return $(this).focusNextInputField(event)",
							'class' => 'required custom-only', 
						),
						'tombolDialog'=>array('idDialog'=>'dialogSubKelompok', 'idTombol'=>'tombolIdSubKelompok'),
					)); 
				?>
			</div>
		</div>

		<?php //Echo CHtml::hiddenField('tempKode', $model->subkelompok_kode); ?>

		<?php echo $form->textFieldRow($model,'subsubkelompok_kode',array('readonly' => TRUE,'class'=>'span2 angkadot-only','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>14,)); ?>
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'subsubkelompok_nama',array('onkeyup'=>'namaLain(this)','class'=>'span2 custom-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		<?php echo $form->textFieldRow($model,'subsubkelompok_namalainnya',array('class'=>'span2 custom-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		<?php //echo $form->checkBoxRow($model,'subkelompok_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>		
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
		Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
		array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
		'',
		array('class' => 'btn btn-default',
		'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php //$this->widget('UserTips',array('type'=>'create'));?>
    <?php
        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Sub Sub Kelompok', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
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
    'id'=>'dialogSubKelompok',
    'options'=>array(
        'title'=>'Sub Kelompok',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
        'close'=>'js:function(){ backSize(); }',
    ),
));

$modKelompok= new SASubkelompokM('search');
$modKelompok->unsetAttributes();
if(isset($_GET['SASubkelompokM']))
    $modKelompok->attributes = $_GET['SASubkelompokM'];

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
                                    $(\"#'.CHtml::activeId($model, 'subkelompok_id').'\").val(\'$data->subkelompok_id\');
                                    $(\"#subkelompokNama\").val(\'$data->subkelompok_nama\');
                                    kodeSubSubKelompok($data->subkelompok_id);
                                    backSize();
                                    $(\'#dialogSubKelompok\').dialog(\'close\');return false;"))'
                ),
                array(
                        'header'=>'Kelompok',
                        'name' => 'kelompok_id',
                        'filter'=> CHtml::dropDownList('SASubkelompokM[kelompok_id]',$modKelompok->kelompok_id,CHtml::listData($model->KelompokItems, 'kelompok_id', 'kelompok_nama'),array('empty'=>'-- Pilih --')),                       
                        //'value'=>'$this->grid->getOwner()->renderPartial(\'sistemAdministrator.views.subkelompokM.listGolongan\', array(\'idKelompok\'=>$data->kelompok_id))',
                        'value'=>'$data->kelompok->kelompok_nama',
                ),
                array(
                        'header'=>'Sub Kelompok',
                        'name' => 'subkelompok_nama',
                        //'filter'=>  CHtml::listData($model->SubKelompokItems, 'subkelompok_id', 'subkelompok_nama'),                       
                        //'value'=>'$this->grid->getOwner()->renderPartial(\'sistemAdministrator.views.subkelompokM.listGolongan\', array(\'idKelompok\'=>$data->kelompok_id))',
                        'value'=>'$data->subkelompok_nama',
                ),
               /* array(
                        'header'=>'Bidang',
                        'filter'=>  CHtml::listData($model->BidangItems, 'bidang_id', 'bidang_nama'),
                        //'value'=>'$this->grid->getOwner()->renderPartial(\'sistemAdministrator.views.subkelompokM.listGolongan\', array(\'idKelompok\'=>$data->kelompok_id))',
                        'value'=>'$data->bidang_nama',
                ),
                array(
                        'header'=>'Kelompok ',
                        'filter'=>  CHtml::listData($model->KelompokItems, 'kelompok_id', 'kelompok_nama'),
                        'value'=>'$data->kelompok_nama',
                ),*/
//                array(
//                        'header'=>'Sub Kelompok',
////                        'filter'=>  CHtml::listData($model->SubKelompokItems, 'subkelompok_id', 'subkelompok_nama'),
//                        'type'=>'raw',
//                        
//                        'value'=>'$this->grid->getOwner()->renderPartial(\'listSubKelompok\', array(\'idKelompok\'=>$data->kelompok_id))',
//                ),
//                array(
//                        'header'=>'bidang_id',
//                        'filter'=>  CHtml::listData($model->BidangItems, 'bidang_id', 'bidang_nama'),
//                        'type'=>'raw',
//                        'value'=>'$this->grid->getOwner->renderPartial(\'listBidang\',array(\'idKelompok\'=>\'$data->kelompok_id\'))',
//                ),
		
                
               
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>

<script>
    function namaLain(obj){
        $("#<?php echo Chtml::activeId($model, 'subsubkelompok_namalainnya') ?>").val($(obj).val());
    }
    
    function kodeSubSubKelompok(id){
        var subkelompok_id = id;
        var temp_subkel_id = $("#<?php echo Chtml::activeId($model, 'temp_subkel_id') ?>").val();
        var temp_kode_subsubkel = $("#<?php echo Chtml::activeId($model, 'temp_kode_subsubkel') ?>").val();
        
        $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('KodeSubSubKelompok'); ?>',
        data: {subkelompok_id:subkelompok_id},
        dataType: "json",
        success:function(data){           
            if (data.sukses == '0'){                
                myAlert(data.pesan);
                return false;
            }else if (data.sukses == 'kodebaru'){                         
                $("#<?php echo Chtml::activeId($model, 'subsubkelompok_kode'); ?>").val(data.kodebaru);                
                return false;                
            }else if (data.sukses == 'kosong'){                
                $("#<?php echo Chtml::activeId($model, 'subsubkelompok_kode'); ?>").val(data.kodebaru);
                return false;                
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
        window.parent.document.getElementById('frame').style= 'overflow-y:scroll;height:400px;';  
    }
    
    $("#tombolIdSubKelompok").click(function(){
        changeSize();
    });
</script>

