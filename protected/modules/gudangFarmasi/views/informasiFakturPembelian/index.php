<?php
$this->breadcrumbs = array(
    'Informasi Faktur Pembelian',
);
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
	$.fn.yiiGridView.update('rencana-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Faktur Pembelian</b>
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
                <?php echo $this->renderPartial('search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Faktur Pembelian</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'rencana-m-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        array(
                            'name' => 'tglfaktur',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglfaktur)',
                        ),
                        'nofaktur',
                        array(
                            'name' => 'tgljatuhtempo',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)',
                        ),
                        array(
                            'name' => 'tglsuratjalan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglsuratjalan)',
                        ),
                        'nosuratjalan',
                        array(
                            'name' => 'supplier_nama',
                            'type' => 'raw',
                            'value' => '$data->supplier_nama',
                        ),
                        array(
                            'name' => 'statuspenerimaan',
                            'type' => 'raw',
                            'value' => '$data->statuspenerimaan',
                        ),
                        array(
                            'name' => 'ruangan_nama',
                            'type' => 'raw',
                            'value' => '$data->ruangan_nama',
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("FakturPembelian/print",array("fakturpembelian_id"=>$data->fakturpembelian_id,"frame"=>true)),
                                     array("class"=>"", 
                                           "target"=>"rencana",
                                           "onclick"=>"$(\"#dialogPenerimaan\").dialog(\"open\");",
                                           "rel"=>"tooltip",
                                           "title"=>"Klik untuk melihat detail Penerimaan Barang",
                                     ))',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog Detail=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPenerimaan',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Penerimaan',
        'autoOpen' => false,
        'minWidth' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="rencana" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Detail================================
?>