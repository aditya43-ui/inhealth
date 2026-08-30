<style type="text/css">
    .integer-decimal{
        text-align: right;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php
$this->breadcrumbs=array(
	'Informasi Settlement Advance Payment',
);
Yii::app()->clientScript->registerScript('search', "
$('#advancepayment-t-search').submit(function(){
	$.fn.yiiGridView.update('advancepayment-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
$('#btn_reset').click(function(){
	setTimeout(function(){
		$.fn.yiiGridView.update('advancepayment-t-grid', {
			data: $('#advancepayment-t-search').serialize()
		});
	}, 1000);
});
");
?>

<?php
// $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
// 		'id'=>'advancepayment-t-form',
// 		'enableAjaxValidation'=>false,
// 		'type'=>'horizontal',
// 		'focus'=>'#',
// 		'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
// 						),
// 						// 'onsubmit'=>'return cekInputan();'
// 	));
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'advancepayment-t-search',
            'type'=>'horizontal',
        )
    );
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                    <div class="panel-title">Informasi <strong>Settlement Advance Payment</strong></div>
            </div>            
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel Settlement Advance Payment</div>
                    </div>
                    <div class="panel-body" style="overflow-x: auto;max-width: 100%">
					<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
					
						<?php 
								$this->renderPartial($this->path_view.'_tableInformasi',array(
                                   'model' => $model,
								//    'modTandaBuktiKeluar'=>$modTandaBuktiKeluar

                                ));
						?>

						<?php //echo $form->errorSummary(array($modelBayar,$modBuktiKeluar)); ?>
                    </div>
                </div>			
				
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="panel-title">Pencarian</div>
					</div>
					<div class="panel-body">
					<?php 
								$this->renderPartial('_searchInformasi',array(
                                   'form'=>$form,
								   'model'=>$model,
								//    'modTandaBuktiKeluar'=>$modTandaBuktiKeluar
                                ));
						?>	
					</div>
				</div>
			
				<div class="form-actions">
					<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
					<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
						$this->createUrl($this->id.'/informasi'), 
						array('class'=>'btn btn-danger',
							'onclick'=>'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
					<?php  
						// $content = $this->renderPartial('keuangan.views/tips/informasi',array(),true);
						// $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
					?>
				</div>
            </div>
        </div>
    </div>
</div>
</div>
	<?php $this->endWidget(); ?>
<script type="text/javascript">
 

</script>