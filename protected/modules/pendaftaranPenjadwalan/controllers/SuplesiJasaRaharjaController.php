<?php
class SuplesiJasaRaharjaController extends MyAuthController{
	
	public $path_view = 'asuransi.views.suplesiJasaRaharja.';
	
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
					$query1 = $_GET['katakunci1'];
					$query2 = MyFormatter::formatDateTimeForDb($_GET['katakunci2']);
					$query = $query1 . "/tglPelayanan/". $query2;
					$start = 1;
					$limit = 10;
					print_r( $bpjs->search_suplesi($query,$start, $limit) );
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
	public function actionPrintData($dokter = null)
	{
		$this->layout='//layouts/printWindows';
		$format = new MyFormatter;
		$data = '';
                
                $kartu_peserta = $_GET['kartu_peserta'];
                $tgl_pelayanan = $_GET['tgl_pelayanan'];
                
		if(!empty($kartu_peserta)){
			$data = 'POTENSI SUPLESI JASA RAHARJA';
		}
		$judul_print = 'DATA '.$data.'';
		$this->render($this->path_view.'print', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
                        'kartu_peserta'=>$kartu_peserta,
                        'tgl_pelayanan'=>$tgl_pelayanan,
		));
	} 
	
    public function actionSetFormSuplesi()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $suplesiList = $_POST['suplesiList'];
			$form = '';
			$pesan = '';
            if(count((array)$suplesiList) > 0){
                foreach($suplesiList AS $i => $suplesi){
                        $no_register = $suplesi['noRegister'];
                        $noSep = $suplesi['noSep'];
                        $noSepAwal = $suplesi['noSepAwal'];
                        $noSuratJaminan = $suplesi['noSuratJaminan'];
                        $tglKejadian = $suplesi['tglKejadian'];
                        $tglSep = $suplesi['tglSep'];
                    $form .= $this->renderPartial($this->path_view.'_rowDetail', array(
						'noRegister'=>$no_register,
						'noSep'=>$noSep,
						'noSepAwal'=>$noSepAwal,
						'noSuratJaminan'=>$noSuratJaminan,
						'tglKejadian'=>$tglKejadian,
						'tglSep'=>$tglSep,
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