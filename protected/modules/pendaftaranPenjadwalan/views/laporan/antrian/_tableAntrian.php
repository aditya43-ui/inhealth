<?php 
    // $merge = array('instalasi_nama', 'ruangan_nama', 'dokter_nama');
    $itemCssClass='table table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        if ($caraPrint == "PDF"){
            $merge = array();
        }
       
        $itemCssClass='table border';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
//    'filter'=>$model,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
      //  'mergeColumns' => $merge,
    'columns'=>array(
        array(
          'header'=>'No.',
          'value'=>'(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
          'type'=>'raw',
        ),
        array(
          'header'=>'Tanggal Antrian',
          'value'=>'MyFormatter::formatDateTimeForUser($data->tglantrian)',
          'type'=>'raw',
        ),
        array(
            'header' => 'Nomor Antrian',
            'name' =>'noantrian',
            'value'=> '$data->noantrian'
        ),       
        array(
            'header' => 'Ruangan',
            'name' =>'ruangan_nama',
            'value'=> '$data->ruangan_nama'
        ), 
        array(
          'header' => 'Barcode',
          'name' =>'barcode',
          'value'=> '$data->barcode'
      ),              
        array(
            'header' => 'Poliklinik',
            'name' =>'ruangan_nama',
            'value'=> '$data->ruangan_nama'
        ),
      //  'dokter_nama',
        
        array(
          'header'=>'No. Rekam Medik',
          'value'=>'!empty($data->no_rekam_medik) ? $data->no_rekam_medik : "-"',
          'type'=>'raw',
        ),
        array(
          'header'=>'Nama Pasien',
          'value'=>'!empty($data->nama_pasien) ? $data->nama_pasien : "-"',
          'type'=>'raw',
        ),  
        array(
          'header'=>'No. Pendaftaran',
          'value'=>'!empty($data->no_pendaftaran) ? $data->no_pendaftaran : "-"',
          'type'=>'raw',
        ),  
        array(
          'header'=>'Kunjungan',
          'value'=>'!empty($data->jenis_kunjungan) ? $data->jenis_kunjungan : "-"',
          'type'=>'raw',
        ),  
        array(
          'header'=>'Pembayaran',
          'value'=>'!empty($data->carabayar_nama) ? $data->carabayar_nama : "-"',
          'type'=>'raw',
        ),        
        
    ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 
