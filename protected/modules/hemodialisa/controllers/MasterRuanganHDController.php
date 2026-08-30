<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterRuanganController');
class MasterRuanganHDController extends MasterRuanganController
{		
	public $defaultAction = 'index';	
        public $init = '';
	
	public function actionIndex()
	{
		$this->render($this->path_view.'index');
	}
	        
	public function getUrlPegawaiRuangan(){
		return $this->module->id.'/RuanganpegawaiMHD/Admin';
	}
        
        public function getUrlKelasRuangan(){
		return $this->module->id.'/KelasRuanganMHD/Admin';
	}
        
        public function getUrlKasusPenyakitRuangan(){
		return $this->module->id.'/KasuspenyakitruanganMHD/Admin';
	}
        
    	public function getUrlKasusPenyakitDiagnosa(){
		return $this->module->id.'/KasusPenyakitDiagnosaHD/Admin';
	}
        
        public function getUrlTindakanRuangan(){
		return $this->module->id.'/TindakanRuanganHD/Admin';
	}                        
}
