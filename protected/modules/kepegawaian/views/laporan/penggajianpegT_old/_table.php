<?php 
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'laporan-grid',
	'dataProvider'=>$model->searchLaporan(),
//	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                     array(
                        'header' => 'No.',
                        'type'=>'raw',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                    ),
                    array(
                        'name'=>'tglpenggajian',
                        'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpenggajian))'
                    ),
                    'pegawai.nomorindukpegawai',
                    'pegawai.nama_pegawai',
                    'pegawai.jabatan.jabatan_nama',
                    'pegawai.no_rekening',
                    array(
                        'header'=>'Total gaji',
                        'type'=>'raw',
                        'value'=>'number_format($data->totalterima,0,"",".")',
                    ),
                    array(
                        'header'=>'Total Potongan',
                        'type'=>'raw',
                        'value'=>'number_format($data->totalpotongan,0,"",".")',
                    ),
                    array(
                        'header'=>'Total Bersih',
                        'type'=>'raw',
                        'value'=>'number_format($data->penerimaanbersih,0,"",".")',
                    )
                ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?>