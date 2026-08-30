<style type="text/css">
    .integer-decimal {
        text-align: right;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Advance Payment Dan Request Of Payment',
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
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'advancepayment-t-search',
        'type' => 'horizontal',
    )
);
?>
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <strong><span id="jenis_transaksi">Advance Payment</span></strong>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->renderPartial('_searchInformasi', array(
                    'form' => $form,
                    'model' => $model,
                    //    'modTandaBuktiKeluar'=>$modTandaBuktiKeluar
                ));
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Advance Payment</b>
                </div>
            </div>
            <div class="panel-body" style="overflow-x: auto;max-width: 100%">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $this->renderPartial($this->path_view . '_tableInformasi', array(
                    'model' => $model,
                    //    'modTandaBuktiKeluar'=>$modTandaBuktiKeluar
                ));
                ?>
                <?php //echo $form->errorSummary(array($modelBayar,$modBuktiKeluar)); 
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>