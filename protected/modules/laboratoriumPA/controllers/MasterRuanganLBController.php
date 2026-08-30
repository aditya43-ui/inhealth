<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterRuanganController');
class MasterRuanganLBController extends MasterRuanganController
{		
	public $defaultAction = 'index';	
        public $init = '';
	
	public function actionIndex()
	{
		$this->render($this->path_view.'index');
	}
	        
	public function getUrlPegawaiRuangan(){
		return $this->module->id.'/RuanganpegawaiMLB/Admin';
	}
        
        public function getUrlKelasRuangan(){
		return $this->module->id.'/KelasRuanganMLB/Admin';
	}
        
        public function getUrlKasusPenyakitRuangan(){
		return $this->module->id.'/KasuspenyakitruanganMLB/Admin';
	}
        
    	public function getUrlKasusPenyakitDiagnosa(){
		return $this->module->id.'/KasusPenyakitDiagnosaLB/Admin';
	}
        
        public function getUrlTindakanRuangan(){
		return $this->module->id.'/TindakanRuanganLB/Admin';
	}                        
}
