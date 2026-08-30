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
<?php 

$prov = $modTindakanSearch->searchDetailTindakan($modPendaftaran->pendaftaran_id);
$prov->pagination = false;
$prov->criteria->order = 'tgl_tindakan desc';

$this->widget('ext.bootstrap.widgets.BootGridView',array( 
    'id'=>'rjtindakan-pelayanan-t-grid', 
    'dataProvider'=>$prov, 
    //'pagination'=>false,
    'template'=>"{summary}\n{items}\n{pager}", 
    'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array( 
        array(
            'header'=>'Ruangan/Poliklinik',
            'value'=>'$data->ruangan->ruangan_nama',
        ),
        'tgl_tindakan',
        'daftartindakan.kategoritindakan.kategoritindakan_nama',
        'daftartindakan.daftartindakan_kode',
        'daftartindakan.daftartindakan_nama',
		array(
			'name'=>'qty_tindakan',
			'htmlOptions'=>array(
				'style'=>'text-align: right;',
			),
		),
		array(
			'name'=>'tarif_tindakan',
			'value'=>'MyFormatter::formatNumberForPrint($data->tarif_tindakan)',
			'htmlOptions'=>array(
				'style'=>'text-align: right;',
			),
		),
        array(
            'header'=>'Keterangan',
            'value'=>'$data->keterangantindakan',
        ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 