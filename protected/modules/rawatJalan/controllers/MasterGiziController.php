<?php
class MasterGiziController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'rawatJalan.views.masterGizi.';

	
	public function actionIndex()
	{
		$this->render($this->path_view.'index');
	}
	/**
	 * url untuk tab menu
	 * @return string
	 */
	public function getUrlDomain(){
		return $this->module->id."/DomainM/Admin";

    }

    public function getUrlKelas(){
		return $this->module->id."/KelasM/Admin";
    }
    
    public function getUrlSubKelas(){
		return $this->module->id."/SubkelasM/Admin";
    }
    
    public function getUrlKlasifikasiSubkelas(){
		return $this->module->id."/KlasifikasiSubkelasM/Admin";
    }
     public function getUrlKlasifikasiSubsubkelas(){
		return $this->module->id."/KlasifikasiSubsubkelasM/Admin";
    }
    public function getUrlIdnt(){
		return $this->module->id."/IdntM/Admin";
	}
}
