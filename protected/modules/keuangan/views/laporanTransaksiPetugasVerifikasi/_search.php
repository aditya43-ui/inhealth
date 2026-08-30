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
        <?php echo CHtml::hiddenField('type', ''); ?>
        <div class="control-group">
            <?php echo CHtml::label("Tanggal", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->radioButtonListInlineRow($model, 'billing', array('rj' => 'RAWAT JALAN', 'ri' => 'RAWAT INAP'), array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputRequire')); ?>
    </div>
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
?>


<?php
$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
?>

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