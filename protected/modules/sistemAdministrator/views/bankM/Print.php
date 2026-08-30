
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
$rows = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
if (isset($caraPrint)){
	$rows = '$row+1';
    $template = "{items}";
}
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');   
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));      

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header' => 'No.',
			'value'=>$rows,
		),
		array(
			'header'=>'Nama Bank',
			'name'=>'namabank',
			'value'=>'isset($data->namabank) ? $data->namabank : "-"',
		),
		array(
			'header'=>'No. Rekening',
			'name'=>'norekening',
			'value'=>'isset($data->norekening) ? $data->norekening : "-"',
		),
                array(
                    'header'=>'Atas Nama',
                    'name'=>'bank_atasnama',
                    'value'=>'$data->bank_atasnama',
                ),
		array(
			'header'=>'Mata Uang',
			'name'=>'matauang_id',
			'value'=>'isset($data->matauang_id) ? $data->matauang->matauang : "-"',
		),
		array(
			'header'=>'Provinsi',
			'name'=>'propinsi_id',
			'value'=>'isset($data->propinsi_id) ? $data->propinsi->propinsi_nama : "-"',
		),
		array(
			'header'=>'Kabupaten',
			'name'=>'kabupaten_id',
			'value'=>'isset($data->kabupaten_id) ? $data->kabupaten->kabupaten_nama : "-"',
		),
		array(
			'header'=>'Alamat Bank',
			'name'=>'alamatbank',
			'value'=>'isset($data->alamatbank) ? $data->alamatbank : "-"',
		),
		array(
			'header'=>'Telp Bank 1 / 2',
			'name'=>'telpbank1',
			'value'=>'isset($data->telpbank1) ? $data->telpbank1 : "-"." / ". isset($data->telpbank2) ? $data->telpbank2 : "-"',
		),
		array(
			'header'=>'Fax Bank/<br>Kode Pos',
			'name'=>'faxbank',
			'value'=>'isset($data->faxbank) ? $data->faxbank : "-" ." / ". isset($data->kodepos) ? $data->kodepos : "-"',
		),
		array(
			'header'=>'Email/<br>Website',
			'name'=>'emailbank',
			'value'=>'isset($data->emailbank) ? $data->emailbank : "-" ." / ". isset($data->website) ? $data->website : "-"',
		),
		array(
			'header'=>'Cabang dari/<br>Negara',
			'name'=>'cabangdari',
				'value'=>'isset($data->cabangdari) ? $data->cabangdari : "-" ." / ".isset($data->negara) ? $data->negara : "-"',
		),
		array(
			'header'=>'Rekening Debit',
			'type'=>'raw',
			'value'=>'$this->grid->owner->renderPartial("sistemAdministrator.views.bankM/_rekBankD",array("saldonormal"=>"D","bank_id"=>$data->bank_id),true)',
		),
		array(
			'header'=>'Rekening Kredit',
			'type'=>'raw',
			'value'=>'$this->grid->owner->renderPartial("sistemAdministrator.views.bankM/_rekBankK",array("saldonormal"=>"K","bank_id"=>$data->bank_id),true)',
		),
		array(
			'header'=>'Aktif',
			'value'=>'($data->bank_aktif == 1) ? "Aktif" : "Tidak Aktif" ',
		),
	),
    )); 
?>