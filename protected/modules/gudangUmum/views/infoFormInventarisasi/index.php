<?php $linkHalaman = CustomFunction::getUrlByMenuID(1321); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Formulir Inventarisasi Barang',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('infoformulirinvbarang-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Formulir Inventarisasi Barang</b>
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
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Formulir Inventarisasi Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'infoformulirinvbarang-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                    : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'name' => 'forminvbarang_tgl',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->forminvbarang_tgl)',
                        ),
                        array(
                            'name' => 'forminvbarang_no',
                        ),
                        array(
                            'header' => 'Total Volume',
                            'value' => 'number_format($data->forminvbarang_totalvolume,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Total Harga (Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->forminvbarang_totalharga,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-formulir\"></i>","' . $this->getUrlPrint() . '&formulirinvbarang_id=$data->formulirinvbarang_id&frame=true",
                                array("class"=>"", 
                                    "target"=>"formulir",
                                    "onclick"=>"$(\"#dialogFormulir\").dialog(\"open\");",
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk melihat detail formulir",
                                ))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Inventarisasi',
                            'type' => 'raw',
                            'value' => '(!$data->beluminv ? "SUDAH<br>INVENTARISASI" : CHtml::link("<icon class=\"icon-invenmesin\">", "' . $this->getUrlInventarisasi() . '&formulirinvbarang_id=$data->formulirinvbarang_id", 
                                array("rel"=>"tooltip",
                                "title"=>"Klik untuk melakukan inventarisasi barang ".(!empty($data->invbarang_id) ? "lagi" : ""),)))',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogFormulir',
    'options' => array(
        'title' => 'Detail Formulir Inventarisasi Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<iframe src="" name="formulir" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>