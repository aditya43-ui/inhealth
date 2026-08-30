<?php
    $this->widget('bootstrap.widgets.BootMenu',array(
        'type'=>'tabs',
        'stacked'=>false,
        'htmlOptions'=>array('id'=>'tabmenu'),
        'items'=>array(
                 array('label'=>'Rujukan dari Luar','url'=>'javascript:void(0);','itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'laboratorium/Laporan/LaporanPemeriksaanRujukanLuar')),
                 array('label'=>'Rujukan dari RS','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'laboratorium/Laporan/LaporanPemeriksaanRujukanRS')),
        ),
    ))
?>
