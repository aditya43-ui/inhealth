<?php
    $this->widget('bootstrap.widgets.BootMenu',array(
        'type'=>'tabs',
        'stacked'=>false,
        'htmlOptions'=>array('id'=>'tabmenu'),
        'items'=>array(
            array('label'=>'Rekap Jasa Dokter','url'=>'javascript:void(0);','itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'bedahSentral/Laporan/LaporanRekapJD')),
            array('label'=>'Detail Rekap Jasa Dokter','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'bedahSentral/Laporan/LaporanDetailRekapJD')),
            array('label'=>'Rekap Pajak Dokter','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'penggajian/Laporan/LaporanRekapPajakDokter')),
        ),
    ))
?>
