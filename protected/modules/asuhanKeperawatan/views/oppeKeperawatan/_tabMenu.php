<?php
$module = '/' . $this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'PRESENTASE PERILAKU', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => $module . '/oppeperilakuT/Index')),
        array('label' => 'PELATIHAN DAN WORKSHOP', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => $module . '/oppepelatihanT/Index')),
        array('label' => 'KEHADIRAN', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => $module . '/oppekehadiranT/Index')),
        array('label' => 'CARING', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => $module . '/oppecaringT/Index')),
//        array('label' => 'INDIKATOR MUTU', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => $module . '/oppeindikatormutuT/Index')),
        array('label' => 'KEPATUHAN ASESMEN', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => $module . '/oppeasesmenT/Index')),
        array('label' => 'BIMBINGAN', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => $module . '/oppebimbinganT/Index')),
        array('label' => 'CLINICAL CARE', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => $module . '/oppeclinicalcareT/Index')),
        
    ),
));
?>