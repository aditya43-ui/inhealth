<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'searchLaporan',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<style>
    table {
        margin-bottom: 0;
    }

    .form-actions {
        padding: 4px;
        margin-top: 10px 125px;
    }

    .nav-tabs>li>a {
        display: block;
        cursor: pointer;
    }

    .nav-tabs>.active a:hover {
        cursor: pointer;
    }
</style>

<div class="row">
    <div class="col-sm-6">

        <div class="control-group ">
			<?php 
            
            $model2 = clone $model;
            $model2->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal); ?>
			<?php echo $form->labelEx($model,'tanggal', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php
					$this->widget('MyDateTimePicker',
						array(
								'model'=>$model2,
								'attribute'=>'tgl_awal',
								'mode'=>'datetime',
								'options'=>array(
									'dateFormat'=>Params::DATE_FORMAT,
									// 'maxDate' => 'd',
								),
								'htmlOptions'=>array(
									'class'=>'dtPicker2-5',
									'onkeypress'=>"return $(this).focusNextInputField(event)",
									'onchange' => '$(this).removeClass("realtime")'
								),
						)
					);
				?>

			</div>
		</div>
        <div class="control-group ">
			<?php $model2->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir); ?>
			<?php echo $form->labelEx($model,'sampai_dengan', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php
					$this->widget('MyDateTimePicker',
						array(
								'model'=>$model2,
								'attribute'=>'tgl_akhir',
								'mode'=>'datetime',
								'options'=>array(
									'dateFormat'=>Params::DATE_FORMAT,
									// 'maxDate' => 'd',
								),
								'htmlOptions'=>array(
									'class'=>'dtPicker2-5',
									'onkeypress'=>"return $(this).focusNextInputField(event)",
									'onchange' => '$(this).removeClass("realtime")'
								),
						)
					);
				?>

			</div>
		</div>


        <?php echo CHtml::hiddenField('type', ''); ?>
		<div class="control-group">
            <?php echo CHtml::label("Billing ".(!$this->is_umum ? '<span class="required">*</span>' : ''), 'billing', array('class' => 'control-label')) ?>
            <div class="controls">
				<?php echo $form->radioButtonList($model, 'billing', array('rj' => 'RAWAT JALAN', 'rd'=>'RAWAT DARURAT', 'ri' => 'RAWAT INAP'), array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputRequire billing')); ?>
            </div>
        </div>
    </div>
	<?php if (strtolower($this->id) == "laporantransaksipetugaspembayaranpenjaminan"): ?>
    <div class="col-sm-6">
		<div class="control-group">
            <?php echo CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true order by carabayar_id'), 'carabayar_id', 'carabayar_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $model,
                    'penjamin_id',
                    array(),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ); ?>
            </div>
        </div>
    </div>
	<?php endif; ?>
</div>

<div class="form-actions">
<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Preview', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'style' => 'background-color: #528AAE; border-color: #528AAE;', 'type' => 'submit')); ?>
<?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
?>
</div>


<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print');
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporan');

$validasiRequredBilling = "";
if (!$this->is_umum) {
	$validasiRequredBilling = "if ($('.billing:checked').length == 0) {
		myAlert('Pencarian billing harus di isi.');
		return false;
	}";
}

?>


<?php
$jsx = <<< JSCRIPT
function print(caraPrint)
{
	${validasiRequredBilling}
    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
?>

<?php if (strtolower($this->id) == "laporantransaksipetugaspembayaranpenjaminan"): ?>
<script>
	$(document).ready(function() {

	var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');		
	var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');		

	jQuery(cara).multiselect({
		includeSelectAllOption: true,
		buttonClass: "form-control",
		maxHeight: 300,
		buttonWidth: '182px',
		enableCaseInsensitiveFiltering: true,
		onChange: function(element, checked) {				
				var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
				var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
				var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
			
				var brands = cara_all;
				var selected = [];
				
			
				$(brands).each(function(index, brand){
					selected.push($(this).val());
				});

				penj.addClass('animation-loading');
				//alert(selected);

				jQuery.ajax({
					type:'POST',
					url: '<?php echo $this->createUrl('/ActionDynamic/GetPenjaminByMultiSelect') ?>',					
					dataType: "json",
					data: {carabayar_id:selected},
					success: function(data){	
						
						if (data.sukses != '1'){
							
							//toastr.error(data.pesan);
							penj.addClass('animation-loading');
						}else{							
							//alert(data.ruangan);
							penj.html(data.penjamin);								
							penj.multiselect('rebuild');																
							penj.removeClass('animation-loading');
						}
					},
					error: function (jqXHR, textStatus, errorThrown) { 					
						console.log(errorThrown);
						
					}
				});

		},
		onSelectAll: function() {
				var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
				var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
				var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
				
				var brands = ins_all;
				var selected = [];
			
				$(brands).each(function(index, brand){
					selected.push($(this).val());
				});

				penj.addClass('animation-loading');

				jQuery.ajax({
					type:'POST',
					url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
					dataType: "json",
					data: {carabayar_id:selected},
					success: function(data){	
						
						if (data.sukses != '1'){
							
							//toastr.error(data.pesan);
							penj.addClass('animation-loading');
						}else{							
							//alert(data.ruangan);
							penj.html(data.penjaminan);								
							penj.multiselect('rebuild');																
							penj.removeClass('animation-loading');
						}
					},
					error: function (jqXHR, textStatus, errorThrown) { 					
						console.log(errorThrown);
						
					}
				});
				
		},
		onDeselectAll: function() {		
			var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
			var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
			var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
				
			var brands = ins_all;
			var selected = '';

			

			penj.addClass('animation-loading');

			jQuery.ajax({
				type:'POST',
				url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
				dataType: "json",
				data: {carabayar_id:selected},
				success: function(data){	

					if (data.sukses != '1'){

						//toastr.error(data.pesan);
						penj.addClass('animation-loading');
					}else{							
						//alert(data.ruangan);
						penj.html(data.penjamin);								
						penj.multiselect('rebuild');															
						penj.removeClass('animation-loading');
					}
				},
				error: function (jqXHR, textStatus, errorThrown) { 					
					console.log(errorThrown);

				}
			});

		}
	}).hide();

	jQuery(penj).multiselect({
		includeSelectAllOption: true,
		buttonClass: "form-control",
		maxHeight: 300,
		buttonWidth: '182px',
		enableCaseInsensitiveFiltering: true
	}).hide();
	});
</script>
<?php endif; ?>