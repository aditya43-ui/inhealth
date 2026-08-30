<?php 

$arr = array(
	array('label'=>'Jenis Kelompok', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->getUrlJenisKelompok())),
    array('label'=>'Jenis Obat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->getUrlJenisObat())),
);

if (Yii::app()->controller->module->id != 'sistemAdministrator') {
    $arr = array_merge($arr, array(
    	array('label'=>'Kategori', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlKategori())),
        array('label'=>'Golongan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlGolongan())),
    ));
}

$arr = array_merge($arr, array(
    array('label'=>'Generik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlGenerik())),
    array('label'=>'Terapi Obat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlTherapiObat())),
    array('label'=>'Kadar Obat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlKadarObat())),
    array('label'=>'Asal Barang', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlAsalBarang())),
    array('label'=>'Lokasi Gudang', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlLokasiGudang())),
    array('label'=>'Satuan Besar', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlSatuanBesar())),
    array('label'=>'Satuan Kecil', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlSatuanKecil())),	
));

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$arr,
));
?>