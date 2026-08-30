
<?php

class RinciantagihanpasienVController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';

	public function actionIndex()
	{
//                
		$model=new LBRinciantagihanpasienpenunjangV('search');
                $model->tgl_awal = date('Y-m-d H:i:s');
                $model->tgl_akhir = date('Y-m-d H:i:s');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LBRinciantagihanpasienpenunjangV']))
			$model->attributes=$_GET['LBRinciantagihanpasienpenunjangV'];

		$this->render('laboratorium.views.rinciantagihanpasienV.index',array(
			'model'=>$model,
		));
	}
        
        public function actionRincian($id){
            $this->layout = '//layouts/iframe';
            $data['judulLaporan'] = 'Rincian Tagihan Pasien';
            $modPendaftaran = LBPendaftaranT::model()->findByPk($id);
            $modRincian = LBRinciantagihanpasienpenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $id,'ruanganpendaftaran_id'=>18,'ruangan_id'=>18), array('order'=>'ruangan_id'));
            $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
//            $modRincian->pendaftaran_id = $id;
            $this->render('laboratorium.views.rinciantagihanpasienV.rincianNew', array('modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data));
        }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=LBRinciantagihanpasienpenunjangV::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='rjrinciantagihanpasien-v-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /**
         *Mengubah status aktif
         * @param type $id 
         */
        public function actionRemoveTemporary($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
                //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionPrint()
        {
            $id = $_REQUEST['id'];
            $modPendaftaran = LBPendaftaranT::model()->findByPk($id);
            $modRincian = LBRinciantagihanpasienpenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $id,'ruanganpendaftaran_id'=>18,'ruangan_id'=>18), array('order'=>'ruangan_id'));
            $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
            $data['judulLaporan']='Data Rincian Tagihan Pasien';
            $caraPrint=$_REQUEST['caraPrint'];
            
            $uangmuka = BayaruangmukaT::model()->findAllByAttributes(
                array('pendaftaran_id'=>$id)
            );
            $uang_cicilan = 0;
            foreach($uangmuka as $val)
            {
                $uang_cicilan += $val->jumlahuangmuka;
            }
            $data['uang_cicilan'] = $uang_cicilan;
            
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render('laboratoriumPA.views.rinciantagihanpasienV.rincianNew', array('modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data, 'caraPrint'=>$caraPrint));
                //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render('laboratoriumPA.views.rinciantagihanpasienV.rincianNew',array('modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data, 'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $style = '<style>.control-label{float:left; text-align: right; width:140px;font-size:12px; color:black;padding-right:10px;  }</style>';
                $mpdf->WriteHTML($style, 1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('laboratoriumPA.views.rinciantagihanpasienV.rincianNew',array('modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data, 'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }
}
