<?php
/**
*   - Detail Daftar Peralatan
*   @author	Andyka <andykaputra@.com>
*/

class DaftarperalatanController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $defaultAction = 'index';
	public $path_view = 'manajemenAset.views.daftarperalatan.';
        public $init = '';        

	public function actionIndex()
	{
            $model  = new MAInvperalatanT();
            if (Yii::app()->user->getState('ruangan_id')){
            }
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            
            if (isset($_GET['MAInvperalatanT'])){
                $model->attributes = $_GET['MAInvperalatanT'];
                                
                $model->invperalatan_kode = isset($_GET['MAInvperalatanT']['invperalatan_kode'])?$_GET['MAInvperalatanT']['invperalatan_kode']:null;
                $model->invperalatan_namabrg = isset($_GET['MAInvperalatanT']['invperalatan_namabrg'])?$_GET['MAInvperalatanT']['invperalatan_namabrg']:null;
                $model->create_ruangan = isset($_GET['MAInvperalatanT']['create_ruangan'])?$_GET['MAInvperalatanT']['create_ruangan']:null;
            }

            $this->render('index',array('model' => $model));
        }
        
        public function actionDetailaset($id) {
            
            $model = MAInvperalatanT::model()->findByPk($id);
            if (empty($model)){
                $model = new MAInvperalatanT;
            }
            
            $this->render('detailaset', array(
                'model'=>$model,
                'id'=>$id
            ));
        }
        
        /**
         * fungsi untuk print qrcode
         * @author rusdiyanto <rusdiyanto@.com>
         * @param type $kode
         */
        public function actionPrintQrCode($kode) {
         $this->layout='//layouts/printWindows';
         $pecah = explode(',', $kode);
         
         unset($pecah[count($pecah)-1]);         
         $cri = new CDbCriteria();
         $cri->addInCondition("invperalatan_id", $pecah);
         $load = InvperalatanT::model()->findAll($cri);
         
         
        $mpdf = new MyPDF('', array(80, 28));
        $posisi = 'P';
        $mpdf->mirrorMargins = 2;                
        $mpdf->AddPage($posisi, '', '', '', '', 3, 3, 3, 3, 3, 3);
        foreach($load as $inv){          
            $load = '
                ID                                : '.$inv->invperalatan_id.'
                Nama                         : '.$inv->invperalatan_namabrg.'
                Kode                          : '.$inv->invperalatan_kode.'
                Sumber Dana           : '.$inv->sumberdana.'
                Tanggal Perolehan : '.(!empty($inv->tanggal_perolehan)?MyFormatter::formatDateTimeForUser($inv->tanggal_perolehan, 'long'):'').'
                Lokasi Aset              : '.(!empty($inv->lokasi->lokasiaset_namalokasi)?$inv->lokasi->lokasiaset_namalokasi:'').'
                Ruangan Aset          : '.(!empty($inv->ruangan->ruangan_nama)?$inv->ruangan->ruangan_nama:'').'
            '; 
            
            $mpdf->WriteHTML((
                            $this->renderPartial('_printQrCode', array(
                                'kode'=>$inv->invperalatan_kode,
                                'load'=>$load,
                                'inv'=>$inv
            ), true)));
        }
        
        $mpdf->Output("Barcode.pdf", 'I');      
    }
}
