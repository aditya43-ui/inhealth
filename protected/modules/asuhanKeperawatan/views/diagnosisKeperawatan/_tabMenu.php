<?php

if (!empty($modAwalMedis)) {
    $pilihan1 = array('label' => 'Asesmen Awal Medis', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/InformasiPengkajianAskep/Asesmenawalmedis&id=' . $modPengkajian->pengkajianaskep_id));
} else {
    $pilihan1 = array('label' => 'Asesmen Awal Medis', 'visible' => false, 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/InformasiPengkajianAskep/Asesmenawalmedis&id=' . $modPengkajian->pengkajianaskep_id));
}
if (!empty($modAwalKeperawatan)) {
    $pilihan2 = array('label' => 'Asesmen Awal Keperawatan', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/InformasiPengkajianAskep/Asesmenawalkeperawatan&id=' . $modPengkajian->pengkajianaskep_id));
} else {
    $pilihan2 = array('label' => 'Asesmen Awal Keperawatan', 'visible' => false, 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/InformasiPengkajianAskep/Asesmenawalkeperawatan&id=' . $modPengkajian->pengkajianaskep_id));
}
if (!empty($modAwalKritis)) {
    $pilihan3 = array('label' => 'Asesmen Awal Kritis', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/InformasiPengkajianAskep/Asesmenawalkritis&id=' . $modPengkajian->pengkajianaskep_id));
} else {
    $pilihan3 = array('label' => 'Asesmen Awal Kritis', 'visible' => false, 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/InformasiPengkajianAskep/Asesmenawalkritis&id=' . $modPengkajian->pengkajianaskep_id));
}
if (!empty($modAwalKebidanan)) {
    $pilihan4 = array('label' => 'Asesmen Awal Kebidanan', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/InformasiPengkajianAskep/Asesmenawalkebidanan&id=' . $modPengkajian->pengkajianaskep_id));
    //$pilihan4 = array('label'=>'Asesmen Awal Kebidanan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'persalinan/AsesmenAwalKebidanan/index&pendaftaran_id='.$modPengkajian->pengkajianaskep_id));
} else {
    $pilihan4 = array('label' => 'Asesmen Awal Kebidanan', 'visible' => false, 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => 'asuhanKeperawatan/InformasiPengkajianAskep/Asesmenawalkebidanan&id=' . $modPengkajian->pengkajianaskep_id));
}
?>
<?php

$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        $pilihan1,
        $pilihan2,
        $pilihan3,
        $pilihan4,
    ),
));
?>