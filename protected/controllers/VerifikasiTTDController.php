<?php

class VerifikasiTTDController extends Controller {

    public $layout = '//layouts/iframe';

    public function actionVerifikasi($id) {

        $model = TandatangandigitalT::model()->findByPk($id);
        if (empty($model)) {
            echo "Data tidak ditemukan";
            Yii::app()->end();
        }

        $details = TandatangandigitaldetT::model()->findAllByAttributes(array(
            'tandatangandigital_id'=>$model->tandatangandigital_id
        ));

        $this->render('verifikasi', array(
            'model'=>$model,
            'details'=>$details,
        ));

    }


    public function actionVerifikasiDetail($id) {

        $detail = TandatangandigitaldetT::model()->findByPk($id);
        if (empty($detail)) {
            echo "Data tidak ditemukan";
            Yii::app()->end();
        }

        $model = TandatangandigitalT::model()->findByPk($detail->tandatangandigital_id);
        

        

        $this->render('verifikasiDetail', array(
            'model'=>$model,
            'detail'=>$detail,
        ));

    }

    public function actionUnduh($id) {

        $model = TandatangandigitalT::model()->findByPk($id);
        if (empty($model)) {
            echo "Data tidak ditemukan";
            Yii::app()->end();
        }
        // var_dump($model->attributes); die;
        $paths = $model->path_file;
            
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($model->nama_file).'"');
        header("Content-Transfer-Encoding: binary"); 
        header('Connection: Keep-Alive');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($paths));
        
        ob_clean();
        flush();
        readfile($paths);
        Yii::app()->end();
        

    }

}

?>