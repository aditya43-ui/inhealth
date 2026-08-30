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
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array( 
    'id'=>'rjtindakan-pelayanan-t-grid', 
    'dataProvider'=>$modTindakanSearch->searchDetailTindakan($modPendaftaran->pendaftaran_id), 
    //'filter'=>$modTindakan, 
        'template'=>"{summary}\n{items}\n{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array( 
        array(
            'header'=>'Ruangan/Poliklinik',
            'value'=>'$data->pendaftaran->ruangan->ruangan_nama',
        ),
        'tgl_tindakan',
        'daftartindakan.kategoritindakan.kategoritindakan_nama',
        'daftartindakan.daftartindakan_nama',
        'qty_tindakan',
        'tarif_tindakan',
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 