<div class="span11">
<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'kupembgajipeg-t-grid',
	'dataProvider'=>$modDetail->searchDetail($id),
        'template'=>"{items}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'name'=>'nopenggajian',
                    'value'=>'$data->nopenggajian',
                ),
                array(
                    'name'=>'periodegaji',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->periodegaji)',
                ),
		array(
                    'name'=>'pegawai_nip',
                    'value'=>'$data->pegawai_nip',
                ),
		array(
                    'name'=>'pegawai_nama',
                    'value'=>'$data->pegawai_nama',
                ),
		array(
                    'name'=>'totalterima',
                    'value'=>'number_format($data->totalterima)',
                ),
		array(
                    'name'=>'totalpotongan',
                    'value'=>'number_format($data->totalpotongan)',
                ),
		array(
                    'name'=>'penerimaanbersih',
                    'value'=>'number_format($data->penerimaanbersih)',
                ),
		
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
</div>