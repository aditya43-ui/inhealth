<?php
/**
* - digunakan untuk menampilkan tab menu
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$action = Yii::app()->controller->action->id;
$this->widget('bootstrap.widgets.BootMenu', array(
	'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
	'stacked'=>false, // whether this is a stacked menu
	'items'=>array(
		array('label'=>'Pasien DBD', 'url'=>$this->createAbsoluteUrl($controller.'/LaporanPasienDBD'),'active'=>(strtolower($action) == strtolower('LaporanPasienDBD'))?true:false),
		array('label'=>'Pasien Diare', 'url'=>$this->createAbsoluteUrl($controller.'/laporanPasienDiare'),'active'=>(strtolower($action) == strtolower('laporanPasienDiare'))?true:false),		
		array('label'=>'ISPA', 'url'=>$this->createAbsoluteUrl($controller.'/laporanIspa'),'active'=>(strtolower($action) == strtolower('laporanIspa'))?true:false),		
		array('label'=>'Kunjungan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKunjungan'),'active'=>(strtolower($action) == strtolower('laporanKunjungan'))?true:false),		
		array('label'=>'Angka Kematian', 'url'=>$this->createAbsoluteUrl($controller.'/LaporanAngkaKematian'),'active'=>(strtolower($action) == strtolower('LaporanAngkaKematian'))?true:false),		
		array('label'=>'Kinerja', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKinerja'),'active'=>(strtolower($action) == strtolower('laporanKinerja'))?true:false),		

			),
)); 
?>