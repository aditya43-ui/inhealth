<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
		array('label'=>'Jurnal Rekening Penerimaan', 'url'=>$this->createUrl('/akuntansi/JurnalRekPenerimaan/Admin')),
		array('label'=>'Jurnal Rekening Pengeluaran', 'url'=>$this->createUrl('/akuntansi/JurnalRekPengeluaran/Admin') ),
                array('label'=>'Jurnal Rekening Penjamin', 'url'=>$this->createUrl('/akuntansi/JurnalRekPenjamin/Admin'), ),
                array('label'=>'Jurnal Rekening Supplier', 'url'=>$this->createUrl('/akuntansi/SupplierRek/Admin'), ),
                array('label'=>'Jurnal Rekening Cara Pembayaran', 'url'=>$this->createUrl('/akuntansi/CarapembayarRek/Admin'), 'active'=>true),
                array('label'=>'Jurnal Rekening Sumber Dana', 'url'=>$this->createUrl('/akuntansi/SumberdanaRek/Admin'),),
            ),
)); 
?>
