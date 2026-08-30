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
    'id'=>'rjkonsulpoli-t-grid', 
    'dataProvider'=>$modRiwayatKonsulSearch->searchDetail($modPendaftaran->pendaftaran_id), 
//	'dataProvider'=>$modTindakanSearch->searchDetailTindakan($modPendaftaran->pendaftaran_id),
        'template'=>"{summary}\n{items}\n{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array( 
        array(
            'header'=>'Ruangan/Poliklinik',
            'value'=>'$data->tglkonsulpoli',
        ),
        array(
            'header'=>'Poliklinik Asal',
            'value'=>'$data->poliasal->ruangan_nama',
        ),
        array(
            'header'=>'Poliklinik Tujuan',
            'value'=>'$data->politujuan->ruangan_nama',
        ),
        array(
            'header'=>'Catatan Dokter',
            'value'=>'$data->catatan_dokter_konsul',
        ),
        
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 