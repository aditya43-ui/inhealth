<?php 
$module = '/'.$this->module->id.'/';
$controlModule = $module.$this->id.'/';
$urlRoute = Yii::app()->createUrl($this->route,array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'frame'=>true));

$urlAnamnesa = $this->createUrl($module.'pemeriksaanFisikAnamnesa/indexAnamnesa',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'frame'=>true));
$urlFisik = $this->createUrl($module.'pemeriksaanFisikAnamnesa/indexPemeriksaanFisik',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'frame'=>true));

//if(strtolower($urlRoute) == strtolower($urlAnamnesa)){
//    echo '<legend class="rim">ANAMNESIS</legend>';
//}else if(strtolower($urlRoute) == strtolower($urlFisik)){
//    echo '<legend class="rim">PERIKSA FISIK</legend>';
//}
$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Anamnesis', 'url' =>$urlAnamnesa, 'active' =>((strtolower($urlRoute) == strtolower($urlAnamnesa)) ? true : false)),
        array('label' => 'Periksa Fisik', 'url' =>$urlFisik, 'linkOptions' => array('onclick' => 'return palidasiForm(this);'), 'active' =>((strtolower($urlRoute) == strtolower($urlFisik)) ? true : false)),
    ),
));