<?php

$drop_look = LookupM::getItems('statusperiksa');
unset($drop_look[Params::STATUSPERIKSA_BATAL_PERIKSA]);

//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
	'id' => 'dialogPasien',
	'options' => array(
		'title' => 'Pencarian Data Kunjungan Pasien',
		'autoOpen' => false,
		'modal' => true,
		'width' => 980,
		'height' => 480,
		'resizable' => false,
	),
));
$modDialogPasien = new FAPasienM('searchPasienRumahsakitV');
$modDialogPasien->unsetAttributes();
// $modDialogPasien->idInstalasi = Params::INSTALASI_ID_RJ;
if (isset($_GET['FAPasienM'])) {
	$modDialogPasien->attributes = $_GET['FAPasienM'];
	$modDialogPasien->idInstalasi = (isset($_GET['FAPasienM']['idInstalasi']) ? $_GET['FAPasienM']['idInstalasi'] : null);
	$modDialogPasien->no_pendaftaran = (isset($_GET['FAPasienM']['no_pendaftaran']) ? $_GET['FAPasienM']['no_pendaftaran'] : "");
	$modDialogPasien->tgl_pendaftaran_cari = (isset($_GET['FAPasienM']['tgl_pendaftaran_cari']) ? $_GET['FAPasienM']['tgl_pendaftaran_cari'] : "");
	$modDialogPasien->instalasi_nama = (isset($_GET['FAPasienM']['instalasi_nama']) ? $_GET['FAPasienM']['instalasi_nama'] : "");
	$modDialogPasien->carabayar_nama = (isset($_GET['FAPasienM']['carabayar_nama']) ? $_GET['FAPasienM']['carabayar_nama'] : "");
	$modDialogPasien->ruangan_nama = (isset($_GET['FAPasienM']['ruangan_nama']) ? $_GET['FAPasienM']['ruangan_nama'] : "");
	$modDialogPasien->statusperiksa = (isset($_GET['FAPasienM']['statusperiksa']) ? $_GET['FAPasienM']['statusperiksa'] : "");
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'datakunjungan-grid',
	'dataProvider' => $modDialogPasien->searchPasienRumahsakitV(),
	'filter' => $modDialogPasien,
	//'template'=>"{items}\n{pager}",
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            setInfoPasien($data->pendaftaran_id, \"\", \"\", \"\");
                                            $(\"#dialogPasien\").dialog(\"close\");
                                        "))',
		),
		'no_pendaftaran',
		array(
			'name' => 'tgl_pendaftaran',
			'type' => 'raw',
			'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
			'filter' => false,
		),
		array(
			'name' => 'no_rekam_medik',
			'type' => 'raw',
			'value' => '$data->no_rekam_medik',
		),
		'nama_pasien',
		//                    'jeniskelamin',
		array(
			'name' => 'jeniskelamin',
			'type' => 'raw',
			'filter' => CHtml::dropDownList('FAPasienM[jeniskelamin]', $modDialogPasien->jeniskelamin, LookupM::model()->getItems('jeniskelamin'), array('empty' => '--Pilih--')),
		),
		array(
			'name' => 'instalasi_id',
			'value' => '$data->instalasi_nama',
			'type' => 'raw',
			//                        'filter'=>CHtml::listData(BKPendaftaranT::model()->getInstalasis(),'instalasi_id','instalasi_nama'), //dipilih dari instalasi form kunjungan
			'filter' => CHtml::activeHiddenField($modDialogPasien, 'idInstalasi'),
		),
		array(
			'name' => 'ruangan_nama',
			'type' => 'raw',
		),
		array(
			'name' => 'carabayar_nama',
			'type' => 'raw',
			'value' => '$data->carabayar_nama',
		),
		array(
			'header' => 'Status Periksa',
			'type' => 'raw',
			'filter' =>  CHtml::activeDropDownList($modDialogPasien, 'statusperiksa', $drop_look, array('empty' => '-- Pilih --')),
			'value' => function ($data) {
				return Params::getWrStatusPeriksa($data->statusperiksa);
			}
		),

	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>