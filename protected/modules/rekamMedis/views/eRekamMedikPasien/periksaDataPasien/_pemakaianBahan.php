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
    'id'=>'rjobatalkes-pasien-t-grid', 
    'dataProvider'=>$modPemakaianBahan->searchDetailPemakaianBahan($modPendaftaran->pendaftaran_id), 
    //'filter'=>$model, 
        'template'=>"{summary}\n{items}\n{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array( 
        array(
            'header'=>'Ruangan',
            'value'=>'$data->ruangan->ruangan_nama',
        ),
        array(
            'header'=>'Tgl. Pemakaian',
            'value'=>'$data->tglpelayanan',
        ),
        array(
          'header'=>'Jenis Obat Alkes',
          'value'=>' isset($data->obatalkes->jenisobatalkes_id) ? $data->obatalkes->jenisobatalkes->jenisobatalkes_nama : ""',
        ),
        array(
          'header'=>'Nama Obat Alkes',
          'value'=>'$data->obatalkes->obatalkes_nama',
        ),
        array(
          'header'=>'Jumlah',
          'value'=>'$data->qty_oa',
        ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 

