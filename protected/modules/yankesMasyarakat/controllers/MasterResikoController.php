<?php
/**
 * controller utama untuk mengakses master menu resiko
 * 
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @author Elham Budianto <elhambudianto1@gmail.com> 
 * @author Andyka Putra <andykaputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class MasterResikoController extends MyAuthController
{	
    public $defaultAction = 'index';
    public $path_view = 'yankesMasyarakat.views.masterResiko.';
    
    /**
     * Lists all models.
     */
    public function actionIndex()
    {
            $this->render($this->path_view.'index');
    }

    /**
     * url untuk tab menu tipe resiko
     * @return type
     */
    public function getUrlTipeResiko(){
            return $this->module->id.'/TiperesikoM/admin';
    }
    
    /**
     * url untuk tab menu sub tipe resiko
     * @return type
     */
    public function getUrlSubTipeResiko(){
            return $this->module->id.'/SubtiperesikoM/admin';
    }
    
    /**
     * url untuk tab menu detectability
     * @return type
     */
    public function getUrlDetectability(){
            return $this->module->id.'/DetectabilityM/admin';
    }
    
    /**
     * url untuk tab menu komponen responden
     * @return type
     */
    public function getUrlKonsekuensi(){
            return $this->module->id.'/KonsekuensiM/admin';
    }
    
    /**
     * url untuk tab menu pertanyaan
     * @return type
     */
    public function getUrlPeluang(){
            return $this->module->id.'/PeluangM/admin';
    }
    
    /**
     * url untuk tab menu tingkat risiko
     * @return type
     */
    public function getUrlTingkatresiko(){
            return $this->module->id.'/TingkatrisikoRiskregisterM/admin';
    }
    
    /**
     * url untuk tab menu grading risiko
     * @return type
     */
    public function getUrlGradingresiko(){
            return $this->module->id.'/GradingrisikoRiskregisterM/admin';
    }
    
}
