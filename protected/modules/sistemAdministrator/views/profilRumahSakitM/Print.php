
<?php 
if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

  $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            'nama_rumahsakit',
                'alamatlokasi_rumahsakit',
                'website',
		'email',
		'no_telp_profilrs',
            /*
		'tahunprofilrs',
		'kodejenisrs_profilrs',
		'jenisrs_profilrs',
		'statusrsswasta',
		'namakepemilikanrs',
		
		'kodestatuskepemilikanrs',
		'statuskepemilikanrs',
		'pentahapanakreditasrs',
		'statusakreditasrs',
		'nokode_rumahsakit',
		'nama_rumahsakit',
		'kelas_rumahsakit',
		'namadirektur_rumahsakit',
		'alamatlokasi_rumahsakit',
		'nomor_suratizin',
		'tgl_suratizin',
		'oleh_suratizin',
		'sifat_suratizin',
		'masaberlakutahun_suratizin',
		'motto',
		'visi',
		'no_faksimili',
		'logo_rumahsakit',
		'path_logorumahsakit',
		'npwp',
		'tahun_diresmikan',
		'nama_kepemilikanrs',
		'status_kepemilikanrs',
		'khususuntukswasta',
		'website',
		'email',
		'no_telp_profilrs',
		*/
             ), 
              
	
    )); ?>
