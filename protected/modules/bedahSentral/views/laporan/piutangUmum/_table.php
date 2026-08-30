<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>
<?php 
    $this->widget($table,array(
        'id'=>'tableLaporan',
        'dataProvider'=>$data,
        'enableSorting'=>$sort,
        'template'=>$template,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                array(
                        'header' => 'No.',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),  
                array(
                    'header'=>'Initial',
                    'type'=>'raw',
                    'value'=>'$data->tglpembayaran',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'header'=>'Tgl. Billing',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'type'=>'raw',
                    'value'=>'$data->nama_pasien',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'header'=>'No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->nama_pasien',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'header'=>'Total Tagihan',
                    'type'=>'raw',
                    'value'=>'"-"',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'header'=>'Tanggungan <br> P3',
                    'type'=>'raw',
                    'value'=>'"-"',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),

                ),
                array(
                    'header'=>'Tanggungan <br> Pasien',
                    'type'=>'raw',
                    'value'=>'"-"',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
               array(
                   'header'=>'Nama Pasien',
                   'type'=>'raw',
                   'value'=>'nama_pasien',
               ),
               array(
                   'header'=>'Unit Pelayanan',
                   'type'=>'raw',
                   'value'=>'ruangan_nama',
               ),
               array(
                   'header'=>'Tgl. Masuk',
                   'type'=>'raw',
                   'value'=>'ruangan_nama',
               ),
               array(
                   'header'=>'Tgl. Keluar',
                   'type'=>'raw',
                   'value'=>'ruangan_nama',
               ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
?>