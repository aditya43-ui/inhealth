<?php 
$module = '/'.$this->module->id;
$controller = '/'.$this->id;

$modul_login = Yii::app()->user->getState('modul_id');
$modul_pel = array(5, 6, 7);

$menu_list = array(
  array('label'=>'Dirawat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.$controller.'/opnameRI')),        

  // array('label'=>'Dirawat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'default-tab','onclick'=>'setTab(this);', 'tab'=>$module.$controller.'/opnameRI')),        
  array('label'=>'Lahir', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'default-tab','onclick'=>'setTab(this);', 'tab'=>$module.$controller.'/suratLahir')),        
  array('label'=>'Berbadan Sehat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.$controller.'/suratBadanSehat')),
  array('label'=>'Sakit', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.$controller.'/istirahatv2')),        
  array('label'=>'Rujukan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.$controller.'/suratRujukan')),        
  array('label'=>'Kesehatan Jiwa', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.$controller.'/suratKesehatanJiwa')),
  array('label'=>'Kelayakan Vaksinasi Covid-19', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.$controller.'/suratKelayakanCovid19')),
  array('label'=>'Surat Keterangan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.$controller.'/SuratKeteranganbebas')),
  !in_array($modul_login, $modul_pel) ? array('label'=>'Surat Kematian', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/suratKematian/index')) : "",
  array('label'=>'Surat Kematian Pasien', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'pemulasaranJenazah/suratKeterangan/suratKematian&pendaftaran_id' . $_GET['pendaftaran_id'])),
  // array('label'=>'PCR', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.$controller.'/pcr')),        
);

// if ($modPendaftaran->instalasi_id != Params::INSTALASI_ID_RJ) {
//   echo $modPendaftaran->instalasi_id;
//   $menu_list = array_merge($menu_list, array(
//     array('label'=>'Berbadan Sehat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.$controller.'/suratBadanSehat')),
//   ));
// }

// if ($modPendaftaran->instalasi_id != Params::INSTALASI_ID_RI) {
//   echo $modPendaftaran->instalasi_id;

//   $menu_list = array_merge($menu_list, array(
//   ));
// }
 

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'htmlOptions' => array('id'=>'menuBoot'),
    'items'=> $menu_list

));
?>

