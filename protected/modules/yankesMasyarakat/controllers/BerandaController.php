<?php

/**
 * contoller utama untuk menampilkan data dahboard
 * 
 * @package     application.modules.yankesMasyarakat
 * @subpackage  controllers 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @version     2.0.0
 * @link        http://172.9.1.15/simpp/docs/
 * @link        http://piindonesia.co.id 
 */
class BerandaController extends MyAuthController {

    public $defaultAction = 'default';
    public $path_view = 'yankesMasyarakat.views.beranda.';
    public $init = '';
        
    public function actionDefault(){
        
        
        $model = new YMCustomModel();
        
                       
        $data = $model->generateBerandaDefault();
                
        $this->render($this->path_view.'default/index',array('model'=>$model,'load' => $data));
    }
        
}
