<?php 
$module = '/'.$this->module->id.'/';
$controlModule = $module.$this->id.'/';
$urlRoute = Yii::app()->createUrl($this->route,array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
$urlAnamnesa = $this->createUrl($module.'anamnesaTRD/index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
$urlFisik = $this->createUrl($module.'PemeriksaanFisikTRD/index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
$urlLab =$this->createUrl($module.'laboratoriumTRD/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlRad = $this->createUrl($module.'radiologiTRD/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlRehab =  $this->createUrl($module.'rehabMedisTRD/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlGizi = $this->createUrl($module.'konsulGiziTRD/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlPoli = $this->createUrl($module.'konsulPoliTRD/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlTindakan = $this->createUrl($module.'tindakanTRD/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlDiagnosa =$this->createUrl($module.'diagnosaTRD/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlBedah = $this->createUrl($module.'bedahSentralTRD/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlRujukan =  $this->createUrl($module.'rujukanKeluarTRD/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlResep = $this->createUrl($module.'resepturTRD/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
$urlBahan = $this->createUrl($module.'pemakaianBahanTRD/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));

if(strtolower($urlRoute) == strtolower($urlAnamnesa)){
    echo '<legend class="rim">ANAMNESIS</legend><hr>';
}else if(strtolower($urlRoute) == strtolower($urlFisik)){
    echo '<legend class="rim">PERIKSA FISIK</legend><hr>';
}else if(strtolower($urlRoute) == strtolower($urlLab)){
    echo '<legend class="rim">LABORATORIUM</legend><hr>';
}else if(strtolower($urlRoute) == strtolower($urlRad)){
    echo '<legend class="rim">RADIOLOGI</legend><hr>';
}else if(strtolower($urlRoute) == strtolower($urlGizi)){
    echo '<legend class="rim">KONSULTASI GIZI</legend><hr>';
}else if(strtolower($urlRoute) == strtolower($urlPoli)){
    echo '<legend class="rim">KONSUL POLIKLINIK</legend><hr>';
}else if(strtolower($urlRoute) == strtolower($urlTindakan)){
    echo '<legend class="rim">TINDAKAN</legend><hr>';
}else if(strtolower($urlRoute) == strtolower($urlDiagnosa)){
    echo '<legend class="rim">DIAGNOSIS</legend><hr>';
}else if(strtolower($urlRoute) == strtolower($urlBedah)){
    echo '<legend class="rim">BEDAH SENTRAL</legend><hr>';
}else if(strtolower($urlRoute) == strtolower($urlRujukan)){
    echo '<legend class="rim">RUJUKAN KE LUAR</legend><hr>';
}else if(strtolower($urlRoute) == strtolower($urlBahan)){
    echo '<legend class="rim">PEMAKAIAN BAHAN</legend><hr>';
}

$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Anamnesis', 'url' =>$urlAnamnesa, 'active' =>((strtolower($urlRoute) == strtolower($urlAnamnesa)) ? true : false)),
        array('label' => 'Periksa Fisik', 'url' =>$urlFisik, 'linkOptions' => array('onclick' => 'return palidasiForm(this);'), 'active' =>((strtolower($urlRoute) == strtolower($urlFisik)) ? true : false)),
        array('label' => 'Laboratorium', 'url' => $urlLab,'linkOptions' => array('onclick' => 'return palidasiForm(this);'), 'active' => (strtolower($urlRoute) == strtolower($urlLab)) ? true : false),
        array('label' => 'Radiologi', 'url' => $urlRad,'linkOptions' => array('onclick' => 'return palidasiForm(this);'), 'active' => (strtolower($urlRoute) == strtolower($urlRad)) ? true : false),
       array('label' => 'Rehab Medis', 'url' =>$urlRehab, 'linkOptions' => array('onclick' => 'return palidasiForm(this);'),'active' => (strtolower($urlRoute) == strtolower($urlRehab)) ? true : false),
        array('label' => 'Konsultasi Gizi', 'url' => $urlGizi, 'linkOptions' => array('onclick' => 'return palidasiForm(this);'),'active' => (strtolower($urlRoute) == strtolower($urlGizi)) ? true : false),
        array('label' => 'Konsul Poliklinik', 'url' => $urlPoli, 'linkOptions' => array('onclick' => 'return palidasiForm(this);'),'active' => (strtolower($urlRoute) == strtolower($urlPoli)) ? true : false),
        array('label' => 'Tindakan', 'url' => $urlTindakan, 'linkOptions' => array('onclick' => 'return palidasiForm(this);'), 'active' => (strtolower($urlRoute) == strtolower($urlTindakan)) ? true : false),
        array('label' => 'Diagnosis', 'url' => $urlDiagnosa,'linkOptions' => array('onclick' => 'return palidasiForm(this);'), 'active' => (strtolower($urlRoute) == strtolower($urlDiagnosa)) ? true : false),
        array('label' => 'Bedah Sentral', 'url' =>$urlBedah, 'linkOptions' => array('onclick' => 'return palidasiForm(this);'),'active' => (strtolower($urlRoute) == strtolower($urlBedah)) ? true : false),
        array('label' => 'Rujukan Ke Luar', 'url' =>$urlRujukan, 'linkOptions' => array('onclick' => 'return palidasiForm(this);'),'active' => (strtolower($urlRoute) == strtolower($urlRujukan)) ? true : false),
//        Reseptur Di Hide Sementara karena tidak dibutuhkan
       array('label' => 'Reseptur', 'url' => $urlResep,'linkOptions' => array('onclick' => 'return palidasiForm(this);'), 'active' => (strtolower($urlRoute) == strtolower($urlResep)) ? true : false),
        array('label' => 'Pemakaian Bahan', 'url' => $urlBahan, 'linkOptions' => array('onclick' => 'return palidasiForm(this);'),'active' => (strtolower($urlRoute) == strtolower($urlBahan)) ? true : false),
    ),
));