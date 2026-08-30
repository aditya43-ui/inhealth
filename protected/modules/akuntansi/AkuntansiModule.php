<?php

class AkuntansiModule extends CWebModule
{
        public $defaultController = 'ModuleDashboardAK';
        public $kelompokMenu = array();
        public $menu = array();

        public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'akuntansi.models.*',
                        'akuntansi.controllers.*',
                        'akuntansi.view.*',
			'akuntansi.components.*',
		));
                if(!empty($_REQUEST['modul_id']))
                    Yii::app()->session['modul_id'] = $_REQUEST['modul_id']; 
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			if ($controller->layout != '//layouts/iframe'){
								$controller->layout = '//layouts/mainNeonSidebar';
							}
                        $this->kelompokMenu = KelompokmenuK::model()->findAllAktif();
                        $this->menu = MenumodulK::model()->findAllAktif(array('modulk.modul_id'=>Yii::app()->session['modul_id']));
                        $this->cekSessionPeriode();
						$periodeID = Yii::app()->user->getState('periode_ids');
                        if(!isset($periodeID)){
                            echo '<script>alert("Periode belum diset, silakan set kembali!");</script>';
                        } else if(empty($periodeID)){
                            echo '<script>alert("Periode masih belum benar/terlalu banyak data yang aktif/belum closing. Silakan cek kembali!");</script>';
                        }
                        return true;
		}
		else
			return false;
	}
	
	private function cekSessionPeriode()
	{
		$next_year = date('Y-m-d',mktime(0, 0, 0, date("m"),   date("d"),   date("Y")));
		
		$criteria = new CDbCriteria();
		$criteria->addCondition('isclosing is false');
		$criteria->addCondition('DATE(perideawal) <=\''.$next_year.'\'');
		$criteria->addCondition('DATE(sampaidgn) >= \''.$next_year.'\'');
		$attributes = array('isclosing'=>false);
		
		$modPeriode = RekperiodM::model()->find($criteria);
		$periode = array();
		if(isset($modPeriode) && !empty($modPeriode)){
			$periode = $modPeriode->rekperiod_id;
		}
		
		Yii::app()->user->setState('periode_ids',$periode); 
	}
}
