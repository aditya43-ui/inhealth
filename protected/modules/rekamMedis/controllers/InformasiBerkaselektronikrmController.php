<?php
/**
* - digunakan sebagai Informasi Pemusnahan Rekam Medis
* @author  Elham Budianto <elhambudianto1@gmail.com>
* @website	   <.com>
**/
?>

<?php
class InformasiBerkaselektronikrmController extends MyAuthController
{
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'rekamMedis.views.informasiBerkaselektronikrm.';
    
    public function actionIndex(){
		
        $model = new RKBerkaselektronikrmV('searchInformasi');
        
        $model->tgl_awal= date("Y-m-d");
        $model->tgl_akhir= date("Y-m-d");        
        if (isset($_GET['RKBerkaselektronikrmV'])){
            $model->attributes = $_GET['RKBerkaselektronikrmV'];    
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['RKBerkaselektronikrmV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['RKBerkaselektronikrmV']['tgl_akhir']);
        }
        
        $this->render($this->path_view.'index',array('model'=>$model));
    }

    public function actionDetail($pasien_id){

        $dokFiles = DokfilermR::model()->findAllByAttributes(array('pasien_id'=>$pasien_id));
        $modPasien = PasienM::model()->findByPk($pasien_id);
        $this->render($this->path_view.'detail',array('dokFiles'=>$dokFiles,'modPasien' => $modPasien));
    }
	
    
  
}