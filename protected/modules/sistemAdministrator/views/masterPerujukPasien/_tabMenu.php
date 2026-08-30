<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Asal Rujukan', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => $this->getUrlAsalRujukan())),
        array('label' => 'Perujuk', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $this->getUrlRujukanDari())),
        array('label' => 'Rujukan Ke Luar', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $this->getUrlRujukanKeluar())),
    ),
));
