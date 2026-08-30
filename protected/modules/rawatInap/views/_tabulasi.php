<?php 
$module = '/'.$this->module->id.'/';
$controlModule = $module.$this->id.'/';
$urlRoute = Yii::app()->createUrl($this->route,array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id));
$urlAnamnesa = $this->createUrl($module.'anamnesaTRI/index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id));
$urlFisik = $this->createUrl($module.'PemeriksaanFisikTRI/index',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id));
$urlLab =$this->createUrl($module.'laboratoriumTRI/index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id));
$urlRad = $this->createUrl($module.'radiologiTRI/index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id));
$urlRehab =  $this->createUrl($module.'rehabMedisTRI/index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id));
$urlGizi = $this->createUrl($module.'konsulGiziTRI/index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id));
$urlPoli = $this->createUrl($module.'konsulPoliTRI/index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id));
$urlTindakan = $this->createUrl($module.'tindakanTRI/index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id));
$urlDiagnosa =$this->createUrl($module.'diagnosaTRI/index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id));
$urlBedah = $this->createUrl($module.'bedahSentralTRI/index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id));
$urlRujukan =  $this->createUrl($module.'rujukanKeluarTRI/index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id));
//Reseptur Di Hide Sementara karena tidak dibutuhkan
$urlResep = $this->createUrl($module.'resepturTRI/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id));
$urlBahan = $this->createUrl($module.'pemakaianBahanTRI/index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id));
//$urlUnitDosis = $this->createUrl($module.'unitDosisTRI/index', array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id));

//ADA DI FORM MASING-MASING
//if(strtolower($urlRoute) == strtolower($urlAnamnesa)){
//    echo '<legend class="rim">ANAMNESIS</legend><hr>';
//}else if(strtolower($urlRoute) == strtolower($urlFisik)){
//    echo '<legend class="rim">PERIKSA FISIK</legend><hr>';
//}else if(strtolower($urlRoute) == strtolower($urlLab)){
//    echo '<legend class="rim">LABORATORIUM</legend><hr>';
//}else if(strtolower($urlRoute) == strtolower($urlRad)){
//    echo '<legend class="rim">RADIOLOGI</legend><hr>';
//}else if(strtolower($urlRoute) == strtolower($urlGizi)){
//    echo '<legend class="rim">KONSULTASI GIZI</legend><hr>';
//}else if(strtolower($urlRoute) == strtolower($urlPoli)){
//    echo '<legend class="rim">KONSUL POLIKLINIK</legend><hr>';
//}else if(strtolower($urlRoute) == strtolower($urlTindakan)){
//    echo '<legend class="rim">TINDAKAN</legend><hr>';
//}else if(strtolower($urlRoute) == strtolower($urlDiagnosa)){
//    echo '<legend class="rim">DIAGNOSIS</legend><hr>';
//}else if(strtolower($urlRoute) == strtolower($urlBedah)){
//    echo '<legend class="rim">BEDAH SENTRAL</legend><hr>';
//}else if(strtolower($urlRoute) == strtolower($urlRujukan)){
//    echo '<legend class="rim">RUJUKAN KE LUAR</legend><hr>';
//}else if(strtolower($urlRoute) == strtolower($urlBahan)){
//    echo '<legend class="rim">PEMAKAIAN BAHAN</legend><hr>';
//}

$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Anamnesis', 'url' =>$urlAnamnesa, 'active' =>((strtolower($urlRoute) == strtolower($urlAnamnesa)) ? true : false),'linkOptions'=>array('onclick'=>'return palidasiForm(this);')),
        array('label' => 'Periksa Fisik', 'url' =>$urlFisik, 'linkOptions' => array('onclick' => 'return palidasiForm(this);'), 'active' =>((strtolower($urlRoute) == strtolower($urlFisik)) ? true : false)),
        array('label' => 'Laboratorium', 'url' => $urlLab, 'active' => (strtolower($urlRoute) == strtolower($urlLab)) ? true : false),
        array('label' => 'Radiologi', 'url' => $urlRad, 'active' => (strtolower($urlRoute) == strtolower($urlRad)) ? true : false),
        array('label' => 'Rehab Medis', 'url' =>$urlRehab, 'active' => (strtolower($urlRoute) == strtolower($urlRehab)) ? true : false),
        array('label' => 'Konsultasi Gizi', 'url' => $urlGizi, 'active' => (strtolower($urlRoute) == strtolower($urlGizi)) ? true : false),
        array('label' => 'Konsul Poliklinik', 'url' => $urlPoli, 'active' => (strtolower($urlRoute) == strtolower($urlPoli)) ? true : false),
        array('label' => 'Tindakan', 'url' => $urlTindakan, 'linkOptions' => array('onclick' => 'return palidasiForm(this);'), 'active' => (strtolower($urlRoute) == strtolower($urlTindakan)) ? true : false,'linkOptions'=>array('onclick'=>'return palidasiForm(this);')),
        array('label' => 'Diagnosis', 'url' => $urlDiagnosa, 'active' => (strtolower($urlRoute) == strtolower($urlDiagnosa)) ? true : false),
        array('label' => 'Bedah Sentral', 'url' =>$urlBedah, 'active' => (strtolower($urlRoute) == strtolower($urlBedah)) ? true : false),
        array('label' => 'Rujukan Ke Luar', 'url' =>$urlRujukan, 'active' => (strtolower($urlRoute) == strtolower($urlRujukan)) ? true : false),
//        Reseptur Di Hide Sementara karena tidak dibutuhkan
        array('label' => 'Reseptur', 'url' => $urlResep, 'active' => (strtolower($urlRoute) == strtolower($urlResep)) ? true : false),
        array('label' => 'Pemakaian Bahan', 'url' => $urlBahan, 'active' => (strtolower($urlRoute) == strtolower($urlBahan)) ? true : false),
//        array('label' => 'Unit Dosis', 'url' => $urlUnitDosis, 'active' => (strtolower($urlRoute) == strtolower($urlUnitDosis)) ? true : false),
    ),
));