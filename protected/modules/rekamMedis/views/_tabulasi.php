<?php 
$module = '/'.$this->module->id.'/';
$controlModule = $module.$this->id.'/';
$urlRoute = Yii::app()->createUrl($this->route,array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));

$urlAnamnesa = $this->createUrl($module.'pemeriksaanFisikAnamnesaRK/indexAnamnesa',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
$urlFisik = $this->createUrl($module.'pemeriksaanFisikAnamnesaRK/indexPemeriksaanFisik',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));

//if(strtolower($urlRoute) == strtolower($urlAnamnesa)){
//    echo '<legend class="rim">ANAMNESIS</legend><hr>';
//}else if(strtolower($urlRoute) == strtolower($urlFisik)){
//    echo '<legend class="rim">PERIKSA FISIK</legend><hr>';
//}
$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Anamnesis', 'url' =>$urlAnamnesa, 'active' =>((strtolower($urlRoute) == strtolower($urlAnamnesa)) ? true : false)),
        array('label' => 'Periksa Fisik', 'url' =>$urlFisik, 'linkOptions' => array('onclick' => 'return palidasiForm(this);'), 'active' =>((strtolower($urlRoute) == strtolower($urlFisik)) ? true : false)),
    ),
));