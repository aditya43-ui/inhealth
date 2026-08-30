<?php
class KecamatanController extends MyAuthController{
	
	public $path_view = 'asuransi.views.kecamatan.';
	
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
                                print_r( $bpjs->search_kecamatan($query,$start, $limit) );
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
	public function actionPrintData($kecamatan = null)
	{
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;
            $data = '';
            if(!empty($kecamatan)){
                    $data = 'KECAMATAN';
            }
            $judul_print = 'DATA '.$data.' KODE KABUPATEN '.$kecamatan;
            $this->render($this->path_view.'print', array(
                    'format'=>$format,
                    'judul_print'=>$judul_print,
            ));
	} 
	
    public function actionSetFormKecamatan()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $kecamatanList = $_POST['kecamatanList'];
                    $form = '';
                    $pesan = '';
            if(count((array)$kecamatanList) > 0){
                foreach($kecamatanList AS $i => $kecamatan){
                    $kode = $kecamatan['kode'];
                    $nama = $kecamatan['nama'];
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