<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Penerimaan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'akuntansi/jurnalRekPenerimaan')),
    	array('label'=>'Pengeluaran', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'akuntansi/jurnalRekPengeluaran')),
    	array('label'=>'Penjamin', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'akuntansi/jurnalRekPenjamin')),
   	    // array('label'=>'Supplier', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'akuntansi/supplierRek')), RSPMC-2088
    	// array('label'=>'Sumber Dana', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'akuntansi/sumberdanaRek')),
        array('label'=>'Cara Pembayaran', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'akuntansi/carapembayarRek')),
    	array('label'=>'Cara Pembayaran Keluar', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'akuntansi/caraBayarKeluarRekMAK')),
        array('label'=>'Jenis Pembayaran', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'akuntansi/jenisPembayar/admin')),
        // array('label'=>'Bank', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'akuntansi/masterBankAK/index')),
        array('label'=>'Jenis Barang', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'akuntansi/jenisbarangrekM')),
    	array('label'=>'Jenis Obat Alkes', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'akuntansi/rekeningJenisAlkes/admin')),
        array('label'=>'Kelompok Bahan Makanan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'akuntansi/kelompokbahanmakananrekM')),
        array('label'=>'Pajak', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'akuntansi/pajakM/admin')),
        array('label'=>'Rekening Kolom', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'akuntansi/RekeningColumnAK/admin')),
    ),
));
?>