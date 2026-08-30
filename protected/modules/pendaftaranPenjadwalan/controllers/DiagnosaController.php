<?php
class DiagnosaController extends MyAuthController{
	
	public $path_view = 'pendaftaranPenjadwalan.views.diagnosa.';
	
	public function actionIndex(){
		
		$this->render($this->path_view.'index',array(
			
		));
	}
	
	/**
	* set bpjs Interface
	*/
	public function actionBpjsInterface()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			if(empty( $_GET['param'] ) OR $_GET['param'] === ''){
				die('param can\'not empty value');
			}else{
				$param = $_GET['param'];
			}

 //                if(empty( $_GET['server'] ) OR $_GET['server'] === ''){
 //                    
 //                }else{
 //                    $server = 'http://'.$_GET['server'];
 //                }

			$bpjs = new BpjsVklaim();

			switch ($param) {
				case '1':
					$query = $_GET['query'];
					$query = explode(" ",$query);
					$query = $query[0];
					$start = 1;
					$limit = 10;
					print_r( $bpjs->search_diagnosa($query,$start, $limit) );
					break;
				default:
					die('error number, please check your parameter option');
					break;
			}
			Yii::app()->end();
		}
	}
	
	/**
	* @param type $faskes - katakunci
	*/
	public function actionPrintData($diagnosa = null)
	{
		$this->layout='//layouts/printWindows';
		$format = new MyFormatter;
		$data = '';
		if(!empty($diagnosa)){
			$data = 'DIAGNOSA (ICD-10)';
		}
		$judul_print = 'DATA '.$data.'';
		$this->render($this->path_view.'print', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
		));
	} 
	
    public function actionSetFormDiagnosa()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $diagnosaList = $_POST['diagnosaList'];
			$form = '';
			$pesan = '';
            if(count((array)$diagnosaList) > 0){
                foreach($diagnosaList AS $i => $diagnosa){
					$kode = $diagnosa['kode'];
					$nama = $diagnosa['nama'];
                    $form .= $this->renderPartial($this->path_view.'_rowDetail', array(
						'kode'=>$kode,
						'nama'=>$nama,
					), true);
                }
            }else{
                $pesan = "Data tidak ada!";
            }
            
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
    }
}