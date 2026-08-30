<?php 
$module = '/'.$this->module->id;
$pendaftaran_id = isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null;
$tabArray = array();
if($pendaftaran_id != ''){
$criteria = new CDbCriteria();
$criteria->select = 'pendaftaran_id';
$criteria->group = $criteria->select;
$criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
$model = RJPhotopemeriksaanT::model()->findAll($criteria);
if(count((array)$model) > 0){
  foreach($model as $i=>$photo){
      $tabArray = array('label'=>$photo->pendaftaran->no_pendaftaran, 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pengambilanGambarPasien/group&pendaftaran_id='.$photo->pendaftaran_id));
  }
}else{
    $tabArray = '';
}
}
if($tabArray != '' && isset($_GET['pendaftaran_id'])){
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Tampilkan Semua', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pengambilanGambarPasien/tampilkanSemua')),
        $tabArray),
));
}else{
  $this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Tampilkan Semua', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pengambilanGambarPasien/tampilkanSemua'))
        ),
));  
}
