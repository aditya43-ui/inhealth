<?php 
    $merge = array('instalasi_nama', 'ruangan_nama', 'dokter_nama');
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
       'mergeColumns' => $merge,
    'columns'=>array(
        array(
          'header'=>'No.',
          'value'=>'(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
          'type'=>'raw',
        ),
        array(
          'header'=>'Tanggal Pendaftaran/<br>No. Pendaftaran',
          'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br>".$data->no_pendaftaran',
          'type'=>'raw',
        ),
        array(
            'header' => 'Instalasi',
            'name' =>'instalasi_nama',
            'value'=> '$data->instalasi_nama'
        ),       
        array(
            'header' => 'Ruangan',
            'name' =>'ruangan_nama',
            'value'=> '$data->ruangan_nama'
        ),              
        array(
            'header' => 'Dokter',
            'value' => function ($data){
                $dokter = PegawaiM::model()->findByPk($data->dokter_id);
                
                echo $dokter->namaLengkap;                
            }
        ),
      //  'dokter_nama',
        
        array(
          'header'=>'No. Rekam Medik',
          'value'=>'$data->no_rekam_medik',
          'type'=>'raw',
        ),
        array(
          'header'=>'Nama Pasien',
          'value'=>'$data->namadepan." ".$data->nama_pasien',
          'type'=>'raw',
        ),        
        array(
          'header'=>'Jenis Kelamin'."/"."<br>".'Umur',
          'value'=>'$data->jeniskelamin."<br>".$data->umur',
          'type'=>'raw',
        ),
        array(
          'header'=>'Kelas Pelayanan'."/"."<br>".'Kelas penyakit',
          'value'=>'$data->kelaspelayanan_nama."<br>".$data->jeniskasuspenyakit_nama',
          'type'=>'raw',
        ),
        array(
          'header'=>'Alamat'."/"."<br>".'RT'." / ".'RW',
          'value'=>'$data->alamat_pasien."<br>".$data->rt." / ".$data->rw',
          'type'=>'raw',
        ),
        array(
          'header'=>'Jenis Penjamin'."/"."<br>".'Penjamin',
          'value'=>'$data->carabayar_nama."<br>".$data->penjamin_nama',
          'type'=>'raw',
        ),
        
    ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 
