<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Jenis Kantong Darah', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'bankDarah/jeniskantongdarahM/Admin')),
        array('label' => 'Komponen Darah', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'bankDarah/KomponendarahM/Admin')),
    ),
));
