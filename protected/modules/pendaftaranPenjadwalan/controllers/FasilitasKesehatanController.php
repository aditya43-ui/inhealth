<?php
class FasilitasKesehatanController extends MyAuthController{
	
	public $path_view = 'asuransi.views.fasilitasKesehatan.';
	
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

                $bpjs = new BpjsVklaim();

                switch ($param) {
                        case '1':
                                $query = $_GET['query1'];
                                $query = explode(" ",$query);
                                $query = $query[0];
                                $query1 = $_GET['query2'];
                                $query1 = explode(" ",$query1);
                                $query1 = $query1[0];
                                $start = 1;
                                $limit = 10;
                                if($query!='' && $query1==''){
                                    $query = $query;
                                }else if($query!='' && $query1!=''){
                                    $query = $query.'/'.$query1;
                                }else if($query=='' && $query1!=''){
                                    $query = $query.'/'.$query1;
                                }
                                print_r( $bpjs->fasilitas_kesehatan($query,$start, $limit) );
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
	public function actionPrintData($faskes = null, $faskes1=null)
	{
		$this->layout='//layouts/printWindows';
		$format = new MyFormatter;
		$data = '';
		if(!empty($faskes) || !empty($faskes1)){
			$data = 'FASILITAS KESEHATAN';
		}
		$judul_print = 'DATA '.$data.'';
		$this->render($this->path_view.'print', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
		));
	} 
	
    public function actionSetFormFaskes()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $faskesList = $_POST['faskesList'];
            $form = '';
            $pesan = '';
            if(count((array)$faskesList) > 0){
                foreach($faskesList AS $i => $faskes){
                    $kdCabang = $faskes['kode'];
                    $nmCabang = $faskes['nama'];
                    $form .= $this->renderPartial($this->path_view.'_rowDetail', array(
						'kdCabang'=>$kdCabang,
						'nmCabang'=>$nmCabang,
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