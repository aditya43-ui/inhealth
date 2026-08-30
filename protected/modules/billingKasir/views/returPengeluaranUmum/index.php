<?php
    $this->breadcrumbs=array(
        'Retur Pengeluaran Umum',
    );
?>
<?php

$this->widget('application.extensions.moneymask.MMask',
    array(
        'element'=>'.currency',
        'currency'=>'PHP',
        'config'=>array(
            'symbol'=>'Rp ',
            'defaultZero'=>true,
            'allowZero'=>true,
            'decimal'=>',',
            'thousands'=>'.',
            'precision'=>0,
        )
    )
);

?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
    array(
	'id'=>'returpenerimaanumum-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
        'htmlOptions'=>array(
            'onKeyPress'=>'return disableKeyPress(event)',
            'onsubmit'=>'return cekOtorisasi();'
        ),
    )
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
    $this->renderPartial('__formInfoPembayaran',
        array(
            'modBuktiBayar'=>$modBuktiBayar,
            'form'=>$form
        )
    );
?>
<?php $this->endWidget();?>