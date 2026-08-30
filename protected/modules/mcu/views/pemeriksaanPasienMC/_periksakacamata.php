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
    'id'=>'treadmill-t-grid', 
    'dataProvider'=>$modPeriksakacamataSearch->searchDetailPeriksakacamata($modPendaftaran->pendaftaran_id), 
	'template'=>"{summary}\n{items}\n{pager}", 
	'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array( 
        array(
            'header'=>'Tanggal Periksa Kacamata',
            'value'=>'MyFormatter::formatDateTimeForUser($data->tglperiksakacamata)',
        ),
        array(
            'header'=>'Jatuh Tempo Kacamata',
            'value'=>'MyFormatter::formatDateTimeForUser($data->jatuhtempo_kacamata)',
        ),
		'pro_kacamata',
		'permintaanke_kacamata',
		'hasil_penglihatan'
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 