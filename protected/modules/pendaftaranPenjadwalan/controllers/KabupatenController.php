<?php
class KabupatenController extends MyAuthController{
	
	public $path_view = 'asuransi.views.kabupaten.';
	
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
                                $query = $_GET['query'];
                                $query = explode(" ",$query);
                                $query = $query[0];
                                $start = 1;
                                $limit = 10;
                                print_r( $bpjs->search_kabupaten($query,$start, $limit) );
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
	public function actionPrintData($kabupaten = null)
	{
		$this->layout='//layouts/printWindows';
		$format = new MyFormatter;
		$data = '';
		if(!empty($kabupaten)){
			$data = 'KABUPATEN';
		}
		$judul_print = 'DATA '.$data.' KODE PROPINSI '.$kabupaten;
		$this->render($this->path_view.'print', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
		));
	} 
	
    public function actionSetFormKabupaten()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $KabupatenList = $_POST['kabupatenList'];
            $form = '';
            $pesan = '';
            if(count((array)$KabupatenList) > 0){
                foreach($KabupatenList AS $i => $Kabupaten){
                    $kode = $Kabupaten['kode'];
                    $nama = $Kabupaten['nama'];
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