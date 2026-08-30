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
	$data = $modPemesanan->searchPrint();
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL")
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
} else{
	$data = $modPemesanan->searchPrint();
	 $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table,array(
'id'=>'sajenis-kelas-m-grid',
'enableSorting'=>$sort,
'dataProvider'=>$data,
'template'=>$template,
'itemsCssClass'=>'table table-striped table-bordered table-condensed',
'columns'=>array(
        array(
              'header' => 'Tanggal Pemesanan',
              'name' => 'tglpemesananambulans',
              'value' => 'MyFormatter::formatDateTimeForUser($data->tglpemesananambulans)'
          ),
          'pesanambulans_no',
          'norekammedis',
          array(
              'header' => 'Nama Pasien',
              'name' => 'nama_pasien',
              'value' => '(isset($data->pasien)? $data->pasien->namadepan ." ".$data->pasien->nama_pasien:"")'
          ),                
          'tempattujuan',
          'alamattujuan',
          array(
              'header' => 'Tanggal Pemakaian',
              'name' => 'tglpemakaianambulans',
              'value' => '

              !empty($data->tglpemakaianambulans) ? MyFormatter::formatDateTimeForUser($data->tglpemakaianambulans):"-"'
          ),                
          'untukkeperluan',
          'ruanganpemesan.ruangan_nama',
          array(
              'header' => 'Nama Pemakai',
              'name' => 'create_login_pemakai',
              'value' => '!empty($data->userpemesan->nama_pemakai)?$data->userpemesan->nama_pemakai:"-"'
          ),  

      ),
));

?>
