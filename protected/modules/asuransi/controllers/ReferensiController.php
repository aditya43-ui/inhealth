<?php

class ReferensiController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    
    public function actionObatPrb(){        
        $format = new MyFormatter;
        $model = new ARCustomModel;        
        
        if (isset($_GET['ARCustomModel'])){
            $model->attributes = $_GET['ARCustomModel'];            
            $model->obatprb = isset($_GET['ARCustomModel']['obatprb'])?$_GET['ARCustomModel']['obatprb']:null;                        
        }                
        
        if (isset($_GET['ajax'])){
            $ajax = $_GET['ajax'];
            
            if ($ajax == 'obat-prb-grid')
                $path = 'obat-prb/_table';
            
            $this->renderPartial($path,['model'=>$model]);
            exit;
        }else{        
            $this->render('obat-prb/index', array(
                'model' => $model,
            ));
        }
    }
    
    /**
     * 
     */
    public function actionPrintObatPrb(){       
        $this->layout='//layouts/printWindows';
        $format = new MyFormatter;
        $model = new ARCustomModel;        
        
        if (isset($_GET['ARCustomModel'])){
            $model->attributes = $_GET['ARCustomModel'];            
            $model->obatprb = isset($_GET['ARCustomModel']['obatprb'])?$_GET['ARCustomModel']['obatprb']:null;                        
        }    
        
        $judul_print = 'Obat Generik Program PRB';
                 
        $this->render('obat-prb/print', array(
            'model' => $model,
            'judul_print'=>$judul_print,
        )); 
               
    }
        
}
