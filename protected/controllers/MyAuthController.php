<?php
class MyAuthController extends Controller
{
	protected function beforeAction($action)
    {
		if(!isset(Yii::app()->user->id)){
			if(Yii::app()->request->isAjaxRequest){
				die('403, Anda tidak diperkenankan mengakses halaman ini, silakan hubungi administrator!');
			}else{
				$this->redirect(array('/site/login'));
			}
		}
        
        return true;
		
		if($this->checkAccess()){
			return true;
		}else{
            throw new CHttpException(403, 'Anda tidak diperkenankan mengakses halaman ini, silakan hubungi administrator!');
			return false;
		}
	}
	/**
	 * untuk mengecek hak akses
	 * @param type array(action, controller, module)
	 * @return boolean
	 * @throws CHttpException
	 */
	public function checkAccess($params = array()){
		$loginpemakai_id = Yii::app()->user->id;
		$username = Yii::app()->user->id;
		$action = $this->action->id;
		$controller = $this->id;
		$module = $this->module->id;
		$module_id = Yii::app()->user->getState('modul_id');
		
		// var_dump(Yii::app()->user->getState('peranpengguna_id')); die;
		if (Yii::app()->request->isAjaxRequest){
            return true;
        }
		
		if ($loginpemakai_id == 1 
				|| strpos($username, 'admin') !== false
				|| strpos($username, 'sysadmin') !== false
				|| strpos($username, 'sysadmin_clone') !== false
				|| Yii::app()->user->getState('peranpengguna_id') == Params::PERANPENGGUNA_ID_ADMIN) return true;
		
		
        return $this->cekAksesControllerAksi($module, $controller, $action, $loginpemakai_id);
	}
    
    
    public function cekAksesControllerAksi($module, $controller, $action, $loginpemakai_id) {
        $cr = new CDbCriteria();
		$cr->join = 'join peranpengguna_k p on p.peranpengguna_id = t.peranpengguna_id '
			. 'join tugaspengguna_k tu on tu.peranpengguna_id = p.peranpengguna_id and tu.tugas_nama = t.tugas_nama '
			. 'join modul_k m on m.modul_id = tu.modul_id';
		$cr->addCondition(" LOWER(m.url_modul) = '".strtolower($module)."'");
		$cr->addCondition(" LOWER(tu.controller_nama) = '".strtolower($controller)."'");
		$cr->addCondition(" LOWER(tu.action_nama) = '".strtolower($action)."'");
		$cr->addCondition("t.loginpemakai_id = '".$loginpemakai_id."'");
        
        // var_dump($cr); die;
		// var_dump($cr);
		//var_dump($loginpemakai_id);
		$dat = AksespenggunaK::model()->find($cr);
		
		//var_dump($dat->attributes); die;
		
		//var_dump(count((array)$dat));die;
		if (empty($dat->attributes)) return false;
        return true;
    }
    
    public function cekAksesMenu($url) {
        $loginpemakai_id = Yii::app()->user->id;
        $splitter = explode("/", $url);
        
        $module = $splitter[0];
        $controller = $splitter[1];
        
        if (!empty($splitter[2])) {
            $action = $splitter[2];
        } else {
            return false;
        }
        
        return $this->cekAksesControllerAksi($module, $controller, $action, $loginpemakai_id);
    }
	
	/**
	 * untuk mengecek hak akses	 
	 * @return boolean
	 * @throws CHttpException
	 */
	public function cekMenuModul(){
		$action = $this->action->id;
		$controller = $this->id;
		$module = $this->module->id;
		$module_id = Yii::app()->user->getState('modul_id');
		
		//if ($loginpemakai_id == 1 
		//		|| strpos($username, 'admin') !== false
		//		|| Yii::app()->user->getState('peranpengguna_id') == Params::PERANPENGGUNA_ID_ADMIN) return true;
	}
}

