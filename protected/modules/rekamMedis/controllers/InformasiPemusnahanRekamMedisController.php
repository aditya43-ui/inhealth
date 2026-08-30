<?php
/**
* - digunakan sebagai Informasi Pemusnahan Rekam Medis
* @author  Elham Budianto <elhambudianto1@gmail.com>
* @website	   <.com>
**/
?>

<?php
class InformasiPemusnahanRekamMedisController extends MyAuthController
{
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'rekamMedis.views.informasiPemusnahanRekamMedis.';
    
    public function actionIndex(){
		
        $model = new InformasipemusnahanrekammedisV('search');
        
        $model->tgl_awal= date("Y-m-d");
        $model->tgl_akhir= date("Y-m-d");        
        if (isset($_GET['InformasipemusnahanrekammedisV'])){
            $model->attributes = $_GET['InformasipemusnahanrekammedisV'];    
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['InformasipemusnahanrekammedisV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['InformasipemusnahanrekammedisV']['tgl_akhir']);
        }
        
        $this->render($this->path_view.'index',array('model'=>$model));
    }
	
    
  
}