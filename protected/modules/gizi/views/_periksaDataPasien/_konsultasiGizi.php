<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
            header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>
<div>
	<br>
</div>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array( 
    'id'=>'rjtindakan-pelayanan-t-grid', 
    'dataProvider'=>$modTindakanSearch->searchDetailKonsul($modPendaftaran->pendaftaran_id), 
	'template'=>"{summary}\n{items}\n{pager}", 
	'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array( 
        array(
            'header'=>'Ruangan Asal',
            'value'=>'$data->pendaftaran->ruangan->ruangan_nama',
        ),
        array(
            'header'=>'Tanggal Konsultasi',
            'value'=>'$data->tgl_tindakan',
        ),
        array(
            'header'=>'Kategori Konsultasi',
            'value'=>'(isset($data->daftartindakan->kategoritindakan->) ? $data->daftartindakan->kategoritindakan->kategoritindakan_nama : "")',
        ),
        array(
            'header'=>'Konsultasi Gizi',
            'value'=>'$data->daftartindakan->daftartindakan_nama',
        ),
        array(
            'header'=>'Jumlah',
            'value'=>'$data->qty_tindakan',
        ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 