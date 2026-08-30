<?php

class InformasiTestimonialController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'sistemAdministrator.views.informasiTestimonial.';

   
    public function actionIndex() {
        $model = new TestimonialT("search");
        $format = new MyFormatter();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        
        if (isset($_GET['TestimonialT'])){
            $model->attributes = $_GET['TestimonialT'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['TestimonialT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['TestimonialT']['tgl_akhir']);
        }
        $this->render($this->path_view.'index', array(
            'model' => $model,
            'format'=>$format
        ));
    }
    
    
    public function actionPublish() {
       if (Yii::app()->request->isAjaxRequest){
                 $id = $_POST['id'];
                $modTesti = TestimonialT::model()->findByPk($id);

                $modTesti->is_publish = true;
                $modTesti->tglverifikasi = date('Y-m-d h:i:s');
                
                $modTesti->save();

                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-success'>Data berhasil dipublish.</div>",
                            ));
                        Yii::app()->end();              
        }
                                    
                    
    }

    public function actionUnpublish() {
       
        if (Yii::app()->request->isAjaxRequest)
            {
                 $id = $_POST['id'];
                $modTesti = TestimonialT::model()->findByPk($id);

                $modTesti->is_publish = false;
                $modTesti->tglverifikasi = date('Y-m-d h:i:s');
                
                $modTesti->save();

                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-success'>Data berhasil diunpublish.</div>",
                            ));
                       Yii::app()->end();              
                    }
                                    
                    
    }
}