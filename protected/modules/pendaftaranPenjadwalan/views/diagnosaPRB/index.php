<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><b>Diagnosa PRB</b></div>
    </div>
    <div class="panel-body">
<?php

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $prov,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Kode',
            'name'=>'kode',
        ),
        array(
            'header'=>'Nama',
            'name'=>'nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
				jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
	}',
));

?>
        
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => false, 'onclick' => 'printData(\'PRINT\')')); ?>
        </div>

    </div>
</div>

<script>
    function printData(caraPrint) {
        window.open('<?php echo $this->createUrl('PrintData'); ?>&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=1000,height=640');
    }
</script>
