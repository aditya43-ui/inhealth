<?php
/*$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Jurnal Rekening Penerimaan', 'url'=>$this->createUrl('/akuntansi/JurnalRekPenerimaan/Admin', array('tab'=>'frame','modul_id'=>Yii::app()->session['modul_id'])),'active'=>true),
        array('label'=>'Jurnal Rekening Pengeluaran', 'url'=>$this->createUrl('/akuntansi/JurnalRekPengeluaran/Admin'), ),
        array('label'=>'Jurnal Rekening Penjamin', 'url'=>$this->createUrl('/akuntansi/JurnalRekPenjamin/Admin'), ),
        array('label'=>'Jurnal Rekening Supplier', 'url'=>$this->createUrl('/akuntansi/SupplierRek/Admin'), ),
        array('label'=>'Jurnal Rekening Cara Pembayaran', 'url'=>$this->createUrl('/akuntansi/CarapembayarRek/Admin'), ),
        array('label'=>'Jurnal Rekening Sumber Dana', 'url'=>$this->createUrl('/akuntansi/SumberdanaRek/Admin'), ),
            ),
)); */
?>

<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Jurnal Rekening Penerimaan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);',  'tab'=>'/akuntansi/JurnalRekPenerimaan/Admin&tab=frame&modul_id='.Yii::app()->session['modul_id']),'active'=>true),
        array('label'=>'Jurnal Rekening Pengeluaran', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/akuntansi/JurnalRekPengeluaran/Admin&tab=frame&modul_id='.Yii::app()->session['modul_id'])),        
    	array('label'=>'Jurnal Rekening Penjamin', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/akuntansi/JurnalRekPenjamin/Admin&tab=frame&modul_id='.Yii::app()->session['modul_id'])),        
        array('label'=>'Jurnal Rekening Supplier', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/akuntansi/SupplierRek/Admin&tab=frame&modul_id='.Yii::app()->session['modul_id'])),        
        array('label'=>'Jurnal Rekening Cara Pembayaran', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/akuntansi/CarapembayarRek/Admin&tab=frame&modul_id='.Yii::app()->session['modul_id'])),        
        array('label'=>'Jurnal Rekening Sumber Dana', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/akuntansi/SumberdanaRek/Admin&tab=frame&modul_id='.Yii::app()->session['modul_id'])),        
    ),
));
?>
