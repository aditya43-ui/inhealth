<?php

$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Luaran Keperawatan', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/luarankeperawatanM/Admin')),
        array('label' => 'Tautan SDKI-SLKI', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/tautansdkiSlkiM/Admin')),
        array('label' => 'Ekspektasi', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/tujuanAS/Admin')),
        array('label' => 'Daftar Kriteria Hasil', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/daftarKriteriaHasil/Admin')),
        array('label' => 'SLKI', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/kriteriaHasilAS/Admin')),
    ),
));
?>