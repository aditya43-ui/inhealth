<?php

$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Diagnosa Keperawatan', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/diagnosakepMAS/Admin')),
        array('label' => 'Daftar Faktor Penyebab', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/faktorpenyebabDaftarM/Admin')),
        array('label' => 'Faktor Penyebab', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/batasKarakteristikAS/Admin')),
        array('label' => 'Daftar Faktor Risiko', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/faktorrisikoDaftarM/Admin')),
        array('label' => 'Kelompok Faktor Risiko', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/kelompokFaktorResiko/Admin')),
        array('label' => 'Faktor Risiko', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/faktorRisikoAS/Admin')),
        array('label' => 'Daftar Kondisi Klinis Terkait', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/faktorHubDaftar/Admin')),
        array('label' => 'Kondisi Klinis Terkait', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/faktorHubAS/Admin')),
//        array('label' => 'Kriteria dan Hasil', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'sistemAdministrator/kriteriaHasil/Admin')),
        array('label' => 'Daftar Tanda dan Gejala', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/daftarTandaGejala/admin')),
        array('label' => 'Kelompok Tanda dan Gejala', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/kelompoktandagejaladaftarM/Index')),
        array('label' => 'Tanda Gejala', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/tandaGejalaAS/Admin')),
//        array('label' => 'Intervensi', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'sistemAdministrator/intervensi/Admin')),
//        array('label' => 'Implementasi Keperawatan', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'sistemAdministrator/implementasikepM/Admin')),
//        array('label' => 'Alternatif Diagnosa', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'sistemAdministrator/alternatifDx/Admin')),
    //array('label'=>'Diagnosa Keperawatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'rawatJalan/diagnosakeperawatanM/Admin')),
    //array('label'=>'Rencana Keperawatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/rencanaKeperawatanM/Admin')),
    //array('label'=>'Implementasi Keperawatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/implementasikeperawatanM/Admin')),
    ),
));
?>