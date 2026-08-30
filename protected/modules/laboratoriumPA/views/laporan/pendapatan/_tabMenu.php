<?php
    $this->widget('bootstrap.widgets.BootMenu',array(
        'type'=>'tabs',
        'stacked'=>false,
        'htmlOptions'=>array('id'=>'tabmenu'),
        'items'=>array(
                 array('label'=>'Pendapatan dari RS','url'=>'javascript:void(0);','itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'laboratorium/Laporan/LaporanPendapatanRS')),
                 array('label'=>'Pendapatan dari Luar RS','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'laboratorium/Laporan/LaporanPendapatanRSLuar')),
        ),
    ))
?>
