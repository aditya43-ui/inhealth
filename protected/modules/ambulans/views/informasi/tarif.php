<?php
$this->breadcrumbs = array(
    'Informasi Tarif Ambulans',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Informasi <b>Tarif Ambulans</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
		$('.search-form form').submit(function(){
			$.fn.yiiGridView.update('tableTarif', {
				data: $(this).serialize()
			});
			return false;
		});
		");
        ?>
        <?php $this->renderPartial('_searchTarif', array('modTarif' => $modTarif)) ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Tarif Ambulans</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'tableTarif',
                    'dataProvider' => $modTarif->search(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'mergeHeaders' => array(
                        array(
                            'name' => 'Tujuan',
                            'start' => 1, //indeks kolom 3
                            'end' => 5, //indeks kolom 4
                        ),
                    ),
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'name' => 'tarifambulans_kode',
                        ),
                        array(
                            'name' => 'daftartindakan.daftartindakan_nama',
                        ),
                        array(
                            'name' => 'kepropinsi_nama',
                        ),
                        array(
                            'name' => 'kekabupaten_nama',
                        ),
                        array(
                            'name' => 'kekecamatan_nama',
                        ),
                        array(
                            'name' => 'kekelurahan_nama',
                        ),
                        array(
                            'name' => 'jmlkilometer',
                            'value' => 'number_format($data->jmlkilometer,0,",",".")',
                        ),
                        array(
                            'name' => 'tarifperkm',
                            'header' => 'Tarif per KM<br>(Rp)',
                            'value' => 'number_format($data->tarifperkm,0,",",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'name' => 'tarifambulans',
                            'header' => 'Tarif Ambulans<br>(Rp)',
                            'value' => 'number_format($data->tarifambulans,0,",",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>