<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Jenis Obat', 'url'=>$this->createUrl('/gudangFarmasi/jenisObatAlkesM/admin'),),
        array('label'=>'Generik', 'url'=>$this->createUrl('/gudangFarmasi/generikM/admin'), ),
        array('label'=>'Asal Barang', 'url'=>$this->createUrl('/gudangFarmasi/sumberDanaM/admin'), ),
        array('label'=>'Terapi Obat', 'url'=>$this->createUrl('/gudangFarmasi/therapiObatM/admin'),),
        array('label'=>'Satuan Kecil', 'url'=>$this->createUrl('/gudangFarmasi/satuanKecilM/admin'), ),
        array('label'=>'Satuan Besar', 'url'=>$this->createUrl('/gudangFarmasi/satuanBesarM/admin'),),
        array('label'=>'Lokasi Gudang', 'url'=>$this->createUrl('/gudangFarmasi/lokasiGudangM/admin'), ),
        array('label'=>'Kadar Obat', 'url'=>$this->createUrl('/gudangFarmasi/kadarObatM/admin'),),
        array('label'=>'Kategori Obat', 'url'=>$this->createUrl('/gudangFarmasi/kategoriObatM/admin'), 'active'=>true),
    ),
)); 
?>