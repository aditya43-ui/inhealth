<?php
class SebabPenularanController extends MyAuthController{
	
    public $path_view = 'rsOnlineCovid19.views.sebabPenularan.';

    public function actionIndex(){

            $this->render($this->path_view.'index',array(

            ));
    }
	
    public function actionGetDataSebabPenularan()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $bpjs = new BridgingKemenkes();
            $start = 1;
            $limit = 10;
            $dataBridging = $bpjs->sebab_penularan("",$start, $limit);
            
            $status = "";
            $pesan = "";
            $form = "";
            $decodeJson  = json_decode($dataBridging);
            
            if(count($decodeJson->sebab_penularan) > 0){
                $no = 1;
                foreach ($decodeJson->sebab_penularan as $data){
                    $status = isset($data->status)?$data->status:"";
                    $pesan = isset($data->message)?$data->message:"";
                   $form .= $this->renderPartial($this->path_view.'_rowDetail', array(
						'model'=>$data,
						'index'=>$no,
					), true);
                   $no++;
                }
            }
            
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan,'status'=>$status));
            Yii::app()->end(); 
        }
    }
        
    /**
    * @param type $faskes - katakunci
    */
    public function actionPrintData($faskes = null)
    {
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;

            $judul_print = 'DATA SEBAB PENULARAN';
            $this->render($this->path_view.'print', array(
                    'format'=>$format,
                    'judul_print'=>$judul_print,
            ));
    } 
}