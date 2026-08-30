<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'tabelverifikasi-search',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'method' => 'GET',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
Yii::app()->clientScript->registerScript('tabelVerifikasi', "
$('#tabelverifikasi-search').submit(function(){
	$.fn.yiiGridView.update('pencarianverifikasi-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$format = new MyFormatter();
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/alertjs/jQuery.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/alertjs/jQuery.alert.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Batal Tindakan</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
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
                <?php $this->renderPartial('_search', [
                    'modInfoOrderBatal' => $modInfoOrderBatal,
                    'form' => $form
                ]) ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Batal Tindakan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php 
                    $this->renderPartial('_table', [
                        'modInfoOrderBatal' => $modInfoOrderBatal,
                        'format' => $format
                    ]);
                ?>
            </div>
        </div>
    </div>
</div>

<?php 
    //semua dialog dikumpulkan di file _dialog
    $this->renderPartial('_dialog', [
    
    ]);
    $this->renderPartial('_jsFunctions', [
    
    ]);

    $this->endWidget();
?>