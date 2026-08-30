<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterRuanganController');
class MasterRuanganRMController extends MasterRuanganController
{		
	public $defaultAction = 'index';	
        public $init = '';
	
	public function actionIndex()
	{
		$this->render($this->path_view.'index');
	}
	        
	public function getUrlPegawaiRuangan(){
		return $this->module->id.'/RuanganpegawaiMRM/Admin';
	}
        
        public function getUrlKelasRuangan(){
		return $this->module->id.'/KelasRuanganMRM/Admin';
	}
        
        public function getUrlKasusPenyakitRuangan(){
		return $this->module->id.'/KasuspenyakitruanganMRM/Admin';
	}
        
    	public function getUrlKasusPenyakitDiagnosa(){
		return $this->module->id.'/KasusPenyakitDiagnosaRM/Admin';
	}
        
        public function getUrlTindakanRuangan(){
		return $this->module->id.'/TindakanRuanganRM/Admin';
	}                        
}
