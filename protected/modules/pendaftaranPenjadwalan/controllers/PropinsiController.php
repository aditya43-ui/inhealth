<?php
class PropinsiController extends MyAuthController{
	
	public $path_view = 'asuransi.views.propinsi.';
	
	public function actionIndex(){
            $this->render($this->path_view.'index',array());
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
                                $start = 1;
                                $limit = 10;
                                print_r( $bpjs->search_propinsi("",$start, $limit) );
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
	public function actionPrintData($faskes = null)
	{
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;

            $judul_print = 'DATA PROPINSI';
            $this->render($this->path_view.'print', array(
                    'format'=>$format,
                    'judul_print'=>$judul_print,
            ));
	} 
	
    public function actionSetFormPropinsi()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $propinsiList = $_POST['propinsiList'];
            $form = '';
            $pesan = '';
            
            if(count((array)$propinsiList) > 0){
                foreach($propinsiList AS $i => $propinsi){
                    $kode = $propinsi['kode'];
                    $nama = $propinsi['nama'];
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