<?php
/**
 * controller ini digunakan untuk mengakses menu lokasi karcis antrian
 * 
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class LokasiKarcisAntrianController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
	public $path_view = 'sistemAdministrator.views.lokasiKarcisAntrian.';
        public $path_tips = 'sistemAdministrator.views.tips.';

	/**
	 * Menampilkan detail data.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->render($this->path_view.'view',array(
				'model'=>$model,
		));
	}

	/**
	 * Membuat dan menyimpan data baru.
	 */
	public function actionCreate()
	{
            $model = new SALokasiKarcisantrianM;            
        
            if(isset($_POST['SALokasiKarcisantrianM']))
            {
                $ok = true;
                $trans = Yii::app()->db->beginTransaction();
                try{
                    $model->attributes = $_POST['SALokasiKarcisantrianM'];
                    $ok = $ok && $model->save();
                    if($ok){
                        $trans->commit();
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        $this->redirect(array('admin'));
                    }else {
                        $trans->rollback();
                        Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                    }
                } catch (Exception $exc) {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                }                                       
            }

            $this->render($this->path_view.'create',array(
                    'model'=>$model,
            ));
	}

	/**
	 * Memanggil dan Mengubah sebagian data.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
            $model = $this->loadModel($id);


            if(isset($_POST['SALokasiKarcisantrianM']))
            {
                $ok = true;
                $trans = Yii::app()->db->beginTransaction();
                try{
                    $model->attributes = $_POST['SALokasiKarcisantrianM'];
                    $ok = $ok && $model->save();
                    
                    if($ok){
                        $trans->commit();
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        $this->redirect(array('admin'));
                    }else {
                        $trans->rollback();
                        Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                    }
                } catch (Exception $exc) {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                }                                       
            }

		$this->render($this->path_view.'update',array(
				'model'=>$model,
		));
	}

	/**
	 * Memanggil dan Menghapus data.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	/**
	 * Memanggil dan menonaktifkan status 
	 */
	public function actionNonActive($id)
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses'] = 0;
			$model = $this->loadModel($id);
			// set non-active this
			// example: 
			 $model->lokasi_karcisantrian_aktif = false;
			 if($model->save()){
				$data['sukses'] = 1;
			 }
			echo CJSON::encode($data); 
		}
	}
	

	/**
	 * Pengaturan data.
	 */
	public function actionAdmin()
	{
		$model = new SALokasiKarcisantrianM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SALokasiKarcisantrianM'])){
                    $model->attributes = $_GET['SALokasiKarcisantrianM'];
                    $model->lokasi_karcisantrian_judul = isset($_GET['SALokasiKarcisantrianM']['lokasi_karcisantrian_judul'])?$_GET['SALokasiKarcisantrianM']['lokasi_karcisantrian_judul']:null;    
		}
		$this->render($this->path_view.'admin',array(
				'model'=>$model,
		));
	}
		
	/**
	 * Memanggil data dari model.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = SALokasiKarcisantrianM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='saloket-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * Mencetak data
	 */
	public function actionPrint()
	{
		$model = new SALokasiKarcisantrianM;
		$model->attributes = $_REQUEST['SALokasiKarcisantrianM'];
		$judulLaporan='Data Lokasi Karcis Antrian';
		$caraPrint = $_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			// $mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
		}
	}
}
