<?php

$module = '/' . $this->module->id;
if($this->init == 'RJ') {
    $data = array(
        array('label' => 'Perkembangan Terintegrasi Pasien', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/PerkembanganTerintegrasiPasienT' . $this->init . '/index')),
    );
}else{
    $data = array(
        //        array('label'=>'Asesmen Awal Keperawatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenAwalKeperawatan'.$this->init.'/index')),
       // array('label' => 'Rencana Keperawatan Awal', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/asesmenRencanaAwalKeperawatan' . $this->init . '/index')),
        array('label' => 'Perkembangan Terintegrasi Pasien', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/PerkembanganTerintegrasiPasienT' . $this->init . '/index')),
        //array('label' => 'Revisi dan Review Rencana Keperawatan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/asesmenRevisiRencanaKeperawatan' . $this->init . '/index')),
    );
}

$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => $data,
));
?>