<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrintLaporan();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        $itemsCssClass='tableRincian';
    } else{
        $data = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
         $itemsCssClass='table table-striped table-bordered table-condensed';
    }
    
      $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array( 
    'id'=>'laporan-grid',
    'dataProvider'=>$data, 
    'template'=>$template,
    'enableSorting'=>$sort,
   // 'mergeColumns'=>array('nama_pegawai'),
//    'extraRowColumns'=> array('nama_pegawai'),
    'columns'=>array( 
        array(
            'header'=>'No.',
            'value' => $row,
        ),
        array(
            'header'=>'Tanggal Pendaftaran',
            'name'=>'tgl_pendaftaran',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:left;'),
            'value'=>'date("d/m/Y H:i:s",strtotime($data->tgl_pendaftaran))',
            'footerHtmlOptions'=>array('colspan'=>9,'style'=>'text-align:right;font-weight:bold;'),
            'footer'=>'Jumlah Total',
        ),
        array(
            'header'=>'No. Registrasi',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:left;'),
            'value'=>'$data->no_pendaftaran',
        ),
        array(
            'header'=>'Unit Pelayanan',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:left;'),
            'value'=>'$data->instalasiasal_nama." ". $data->ruanganasal_nama',
        ),
        array(
            'header'=>'No. RM',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:left;'),
            'value'=>'$data->no_rekam_medik',
        ),
        array(
            'header'=>'Nama Pasien',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:left;'),
            'value'=>'$data->nama_pasien',
        ),
        array(
            'header'=>'Obat',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:right;'),
            'headerHtmlOptions'=>array('style'=>'text-align:right;'),
         'value'=>'number_format($data->getSumJenisObat(array("jml"),"Obat"))',
        ),
        array(
            'header'=>'Alkes',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:right;'),
            'headerHtmlOptions'=>array('style'=>'text-align:right;'),
            'value'=>'number_format($data->getSumJenisObat(array("jml"),"Alkes"))',
         
        ),
        array(
            'header'=>'Gas',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:right;'),
            'headerHtmlOptions'=>array('style'=>'text-align:right;'),
            'value'=>'number_format($data->getSumJenisObat(array("jml"),"Gas"))',
        ),
        array(
            'header'=>'Bruto',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:right;'),
            'headerHtmlOptions'=>array('style'=>'text-align:right;'),
           // 'value'=>'$data->jmlbayar_oa',
            'value'=>'number_format($data->getSumJenisObat(array("jml"),"Bruto"))',
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;'),
            'footer'=>number_format($model->getSumJenisObat(array("jml"),"Bruto")),
        ),
        array(
            'header'=>'KSO',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:right;'),
            'headerHtmlOptions'=>array('style'=>'text-align:right;'),
        //'value'=>'3.5',
          'value'=>'$data->kso',
            // 'value'=>'number_format($data->getSumJenisObat(array("jml"),"kso"))',
             'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;'),
        // 'footer'=>number_format($model->getSumJenisObat(array("jml"),"kso")),
            'footer'=>(number_format($model->getSumJenisObat(array("jml"),"Bruto")))*(3.5),
            
        ),
        array(
            'header'=>'Netto',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:right;'),
            'headerHtmlOptions'=>array('style'=>'text-align:right;'),
        'value'=>'number_format($data->getSumJenisObat(array("jml"),"Netto"))',
           // 'value'=>'number_format($data->netto)',
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;'),
            'footer'=>'sum(netto)',
        'footer'=>number_format($model->getSumJenisObat(array("jml"),"Netto")),
            
        ),
//   
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 