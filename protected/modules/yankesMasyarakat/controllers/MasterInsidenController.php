<?php
/**
 * controller utama untuk mengakses master menu resiko
 * 
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 */
class MasterInsidenController extends MyAuthController
{	
    public $defaultAction = 'index';
    public $path_view = 'yankesMasyarakat.views.masterInsiden.';
    
    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->render($this->path_view.'index');
    }

    /**
     * url untuk tab menu tipe insiden
     * @return type
     */
    public function getUrlTipeinsiden(){
        return $this->module->id.'/TipeinsidenM/admin';
    }
    
    /**
     * url untuk tab menu kelompok subtipe insiden
     * @return type
     */
    public function getUrlKelompoksubtipeinsiden(){
        return $this->module->id.'/KelompoksubtipeinsidenM/admin';
    }
    
    /**
     * url untuk tab menu subtipe insiden
     * @return type
     */
    public function getUrlSubtipeinsiden(){
        return $this->module->id.'/SubtipeinsidenM/admin';
    }
    
    /**
     * url untuk tab menu tingkat risiko
     * @return type
     */
    public function getUrlTingkatresiko(){
            return $this->module->id.'/TingkatrisikoM/admin';
    }
    
    /**
     * url untuk tab menu grading risiko
     * @return type
     */
    public function getUrlGradingresiko(){
        return $this->module->id.'/GradingrisikoM/admin';
    }
    
}
