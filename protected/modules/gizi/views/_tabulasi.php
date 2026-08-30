<?php 
$module = '/'.$this->module->id.'/';
$controlModule = $module.$this->id.'/';
$urlRoute = Yii::app()->createUrl($this->route,array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
//$urlIni = Yii::app()->createUrl($controlModule.$this->action->id);
//if (strtolower($urlRoute) == strtolower($urlIni)){
//    echo 'GGGGG';
//}
$urlAnamnesisDiet = $this->createUrl($module.'anamnesisDiet/index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
$urlPemeriksaanFisik = $this->createUrl($module.'PemeriksaanFisik/index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
$urlJenisDiet =$this->createUrl($module.'jenisDiet/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlKonsultasiGizi = $this->createUrl($module.'konsultasiGizi/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));

$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Anamnesis Diet', 'url' =>$urlAnamnesisDiet, 'active' =>((strtolower($urlRoute) == strtolower($urlAnamnesisDiet)) ? true : false)),
        array('label' => 'Periksa Fisik', 'url' =>$urlPemeriksaanFisik, 'linkOptions' => array(), 'active' =>((strtolower($urlRoute) == strtolower($urlPemeriksaanFisik)) ? true : false)),
        array('label' => 'Jenis Diet', 'url' => $urlJenisDiet,'linkOptions' => array(), 'active' => (strtolower($urlRoute) == strtolower($urlJenisDiet)) ? true : false),
        array('label' => 'Konsultasi Gizi', 'url' => $urlKonsultasiGizi,'linkOptions' => array(), 'active' => (strtolower($urlRoute) == strtolower($urlKonsultasiGizi)) ? true : false),
    ),
));