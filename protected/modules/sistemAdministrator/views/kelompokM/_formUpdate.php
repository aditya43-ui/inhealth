<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakelompok-m-form',
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
			<label class="control-label" for="bidang">Bidang <span style="color:red">*</span></label>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'temp_bid_id') ?>
				<?php echo $form->hiddenField($model,'bidang_id'); ?>
				<?php 
					$this->widget('MyJuiAutoComplete', array(                                            
						'name'=>'bidangNama',
						'value' => $model->bidang_nama,
						'source'=>'js: function(request, response) {
							$.ajax({
								url: "'.Yii::app()->createUrl('ActionAutoComplete/getBidang').'",
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
								$("#'.CHtml::activeId($model, 'bidang_id').'").val(ui.item.bidang_id);
								$("#bidangNama").val(ui.item.bidang_nama);
								kodeKelompok(ui.item.bidang_id);
								return false;
							}',
						),
						'htmlOptions'=>array(
							'onkeypress'=>"return $(this).focusNextInputField(event)",
							'class' => 'required custom-only',  
						),
						'tombolDialog'=>array('idDialog'=>'dialogBidang', 'idTombol'=>'tombolIdBidang'),
					)); 
				?>
			</div>
		</div>            
		<?php echo $form->hiddenField($model, 'temp_kode_kel') ?>
		<?php echo $form->textFieldRow($model,'kelompok_kode',array('readonly' => TRUE,'class'=>'span2 numbers-only', 'onkeyup'=>'setKode(this);','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>8,)); ?>
		<?php echo $form->textFieldRow($model,'kelompok_nama',array('onkeyup'=>'namaLain(this)','class'=>'span3 custom-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'kelompok_namalainnya',array('class'=>'span3 custom-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		<div>
			<?php echo $form->checkBoxRow($model,'kelompok_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		</div>		
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
		Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
		array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
		'',
		array('class' => 'btn btn-default',
		'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>           
    <?php
		echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
		$content = $this->renderPartial($this->path_tips.'tipsaddedit3a',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogBidang',
    'options'=>array(
        'title'=>'Bidang',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
        'close'=>'js:function(){ backSize(); }',
    ),
));

$modBidang = new SABidangM('search');//SAKelompokM
$modBidang->unsetAttributes();
if(isset($_GET['SABidangM']))
    $modBidang->attributes = $_GET['SABidangM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sainstalasi-m-grid',
	'dataProvider'=>$modBidang->search(),
	'filter'=>$modBidang,
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
                                    "id" => "selectBidang",
                                    "onClick" => "
                                    $(\"#'.CHtml::activeId($model, 'bidang_id').'\").val($data->bidang_id);
                                    $(\"#bidangNama\").val(\'$data->bidang_nama\');
                                    kodeKelompok($data->bidang_id);
                                    backSize();
                                    $(\'#dialogBidang\').dialog(\'close\');return false;"))'
                ),
                array(
                        'header'=>'Golongan',
                        'name' => 'golongan_id',
                        'filter'=> CHtml::dropDownList('SABidangM[golongan_id]',$modBidang->golongan_id,CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'),array('empty'=>'-- Pilih --')),
                        'value'=>'$data->golongan->golongan_nama',
                ),
                array(
                        'header'=>'Bidang',
                        'name' => 'bidang_nama',
                        //'filter'=>  CHtml::dropDownList('SABidangM[golongan_id]',$modBidang->bidang_id,CHtml::listData($model->BidangItems, 'bidang_id', 'bidang_nama'),array('empty'=>'-- Pilih --')),
                        'value'=>'$data->bidang_nama',
                ),
               /* array(
                        'header'=>'Kelompok',
                        'filter'=>  CHtml::listData($model->KelompokItems, 'kelompok_id', 'kelompok_nama'),
                        'value'=>'$data->kelompok_nama',
                ),
                array(
                        'header'=>'Sub Kelompok',
//                        'filter'=>  CHtml::listData($model->SubKelompokItems, 'subkelompok_id', 'subkelompok_nama'),
                        'type'=>'raw',
                        
                        'value'=>'$this->grid->getOwner()->renderPartial(\'sistemAdministrator.views.kelompokM.listSubKelompok\', array(\'idKelompok\'=>$data->kelompok_id))',
                ),*/
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
<script>
    function namaLain(obj){
        $("#<?php echo Chtml::activeId($model, 'kelompok_namalainnya') ?>").val($(obj).val());
    }
    
    function kodeKelompok(id){
        var bidang_id = id;
        var temp_bid_id = $("#<?php echo Chtml::activeId($model, 'temp_bid_id') ?>").val();
        var temp_kode_kel = $("#<?php echo Chtml::activeId($model, 'temp_kode_kel') ?>").val();
        
        $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('KodeKelompok'); ?>',
        data: {bidang_id:bidang_id},
        dataType: "json",
        success:function(data){           
            if (data.sukses == '0'){                
                myAlert(data.pesan);
                return false;
            }else if (data.sukses == 'kodebaru'){         
                if (bidang_id == temp_bid_id){
                    $("#<?php echo Chtml::activeId($model, 'kelompok_kode'); ?>").val(temp_kode_kel); 
                }else{
                    $("#<?php echo Chtml::activeId($model, 'kelompok_kode'); ?>").val(data.kodebaru);                
                    return false;
                }
            }else if (data.sukses == 'kosong'){
                if (bidang_id == temp_bid_id){
                    $("#<?php echo Chtml::activeId($model, 'kelompok_kode'); ?>").val(temp_kode_kel); 
                }else{
                    $("#<?php echo Chtml::activeId($model, 'kelompok_kode'); ?>").val(data.kodebaru);
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
    
    $("#tombolIdBidang").click(function(){
        changeSize();
    });
</script>

