<?php
$this->breadcrumbs = array(
    'Informasi Umur Utang',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Umur Utang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
$('#rekonsiliasibank-info-search').submit(function(){
	$('#informasirekonsiliasibank-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasirekonsiliasibank-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
        $format = new MyFormatter();
        //$data = SupplierM::model()->findByPk();
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array(
                    'model' => $model, 'format' => $format
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Umur Utang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                    'id' => 'informasirekonsiliasibank-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'value' => '$row+1',
                            'footer' => ' '
                        ),
                        array(
                            'header' => 'Tanggal Faktur',
                            'name' => 'tglfaktur',
                            'value' => 'MyFormatter::formatDateTImeForUser($data->tglfaktur)',
                            'footer' => ' '
                        ),
                        array(
                            'header' => 'No. Faktur',
                            'name' => 'nofaktur',
                            'value' => '$data->nofaktur',
                            'footer' => ' '
                        ),
                        array(
                            'header' => 'Nama Supplier',
                            'value' => '$data->supplier_nama',
                            'footer' => 'Total'
                        ),
                        array(
                            'header' => 'No. NPWP',
                            'name' => 'supplier_id',
                            'value' => function ($data) {
                                $modsup = SupplierM::model()->findByPk($data->supplier_id);
                                return $modsup->supplier_npwp;
                            },
                            'footer' => ' '
                        ),
                        array(
                            'header' => 'Total Utang (Rp)',
                            'name' => 'totalhargabruto',
                            'value' => 'number_format($data->totalhargabruto,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'footer' => 'sum(totalhargabruto)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Sisa Utang (Rp)',
                            'name' => 'sisa',
                            'value' => 'number_format($data->sisa,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'footer' => 'sum(sisa)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Umur Utang',
                            'name' => 'umur_hutang',
                            'value' => function ($data) {
                                return number_format($data->umur_hutang, 0, '', '.') . " Hari";
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'footer' => ' '
                        ),
                        array(
                            'header' => '0-30 Hari (Rp)',
                            'name' => 'sd_0_30',
                            'value' => function ($data) {
                                if ($data->sd_0_30 == 0) {
                                    return '-';
                                } else {
                                    return number_format($data->sd_0_30, 0, "", ".");
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'footer' => 'sum(sd_0_30)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => '31-60 Hari (Rp)',
                            'name' => 'sd_31_60',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'value' => function ($data) {
                                if ($data->sd_31_60 == 0) {
                                    return '-';
                                } else {
                                    return number_format($data->sd_31_60, 0, "", ".");
                                }
                            },
                            'footer' => 'sum(sd_31_60)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => '61-90 Hari (Rp)',
                            'name' => 'sd_61_90',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'value' => function ($data) {
                                if ($data->sd_61_90 == 0) {
                                    return '-';
                                } else {
                                    return number_format($data->sd_61_90, 0, "", ".");
                                }
                            },
                            'footer' => 'sum(sd_61_90)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => '> 90 Hari (Rp)',
                            'name' => 'sd_91',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'value' => function ($data) {
                                if ($data->sd_91 == 0) {
                                    return '-';
                                } else {
                                    return number_format($data->sd_91, 0, "", ".");
                                }
                            },
                            'footer' => 'sum(sd_91)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>