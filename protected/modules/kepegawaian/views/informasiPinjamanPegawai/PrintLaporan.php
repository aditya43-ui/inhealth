<?php 
if($caraPrint == 'EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode, 'colspan'=>10));      
?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'kppenggajianpeg-t-grid',
    'dataProvider'=>$model->searchPrint(),
    'template'=>"{items}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array( 
        array(
            'header'=>'NIP',
            'name'=>'nomorindukpegawai',
            'value'=>'$data->nomorindukpegawai',
        ),
        array(
            'header'=>'Nama Pegawai',
            'name'=>'nama_pegawai',
            'value'=>'$data->gelardepan." ".$data->nama_pegawai',
        ),
        'nopinjam',
        array(
            'name'=>'tglpinjampeg',
            'value'=>'MyFormatter::formatDateTimeForUser($data->tglpinjampeg)',
        ),
        array(
            'name'=>'tgljatuhtempo',
            'value'=>'MyFormatter::formatDateTimeForUser($data->tglpinjampeg)',
        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>