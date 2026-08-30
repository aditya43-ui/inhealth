
<?php

class ObatAlkesPenjaminMController extends MyAuthController {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
	public $path_view = 'sistemAdministrator.views.obatAlkesPenjamin.';

	/**
	 * Menampilkan detail data.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$model = $this->loadModel($id);
		$this->render($this->path_view . 'view', array(
			'model' => $model,
		));
	}

	/**
	 * Membuat dan menyimpan data baru.
	 */
	public function actionIndex($id = null) {
		$model = new ObatalkespenjaminM();
		$modDetails = array();

		if (!empty($id)) {
			$model = $this->loadModel($id);
			$model->penjamin_nama = $model->penjamin->penjamin_nama;
			$model->carabayar_nama = $model->carabayar->carabayar_nama;
		}

		if (isset($_POST['ObatalkespenjaminM'])) {
			// if (!empty($_POST['ObatalkespenjaminM'])) {
			// 	$modDetails = $this->validasiTabular($_POST['ObatalkespenjaminM'],$model);
			// }
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$success = true;
				$modDetails = $this->validasiTabular($_POST['ObatalkespenjaminM'],$model);
//				foreach ($modDetails as $i => $data) {
					if ($modDetails->obatalkespenjamin_id > 0) {
						if ($modDetails->update()) {
							$success = true;
						} else {
							$success = false;
						}
					} else {
						if ($modDetails->save()) {
							$success = true;
						} else {
							$success = false;
						}
					}
//				}
				if ($success == true) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					$this->redirect(array('admin', 'id' => $model->obatalkespenjamin_id));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
				}
			} catch (Exception $ex) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
			}
		}

		$this->render($this->path_view . 'create', array(
			'model' => $model, 'modDetails' => $modDetails,
		));
	}

	protected function validasiTabular($data,$model) {
		if(!empty($model->obatalkespenjamin_id)){
			$modDetails = ObatalkespenjaminM::model()->findByPk($model->obatalkespenjamin_id);
		}else{
			$modDetails = new ObatalkespenjaminM();
		}

		$modDetails->attributes = $data;
		if (!empty($modDetails->obatalkespenjamin_id)) {
			$modDetails->update_time = date('Y-m-d H:i:s');
			$modDetails->update_loginpemakai_id = Yii::app()->user->id;
		} else {
			$modDetails->create_time = date('Y-m-d H:i:s');
			$modDetails->create_loginpemakai_id = Yii::app()->user->id;
			$modDetails->create_ruangan = Yii::app()->user->getState('ruangan_id');
		}
		$modDetails->validate();

		return $modDetails;
	}

	/**
	 * Memanggil dan Menghapus data.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Pengaturan data.
	 */
	public function actionAdmin() {
		$model = new ObatalkespenjaminM('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['ObatalkespenjaminM'])) {
			$model->attributes = $_GET['ObatalkespenjaminM'];
		}
		$this->render($this->path_view . 'admin', array(
			'model' => $model,
		));
	}

	/**
	 * Memanggil data dari model.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = ObatalkespenjaminM::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'sabank-rek-m-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Mencetak data
	 */
	public function actionPrint() {
		$model = new ObatalkespenjaminM;
		if (isset($_GET['ObatalkespenjaminM'])) {
			$model->attributes = $_GET['ObatalkespenjaminM'];
		}
		$judulLaporan = 'RINCIAN OBAT ALKES PENJAMIN';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			ob_end_clean();
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
			$mpdf->mirrorMargins = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}

	/**
	 * menampilkan rekening bank yg sudah pernah di inputkan
	 */
	public function actionGetDetail() {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$model = new ObatalkespenjaminM;
			$data['form'] = "";
			$penjamin_id = isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null;

			if (!empty($penjamin_id)) {
				$models = ObatalkespenjaminM::model()->findAllByAttributes(array('penjamin_id' => $penjamin_id));
				if (count($models) > 0) {
					foreach ($models AS $i => $model) {
						$data['form'] .= $this->renderPartial($this->path_view . '_rowRekening', array('model' => $model), true);
					}
				}
			}

			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

	/**
	 * Memanggil dan Menghapus data.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeleteDetail($id) {
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$data['sukses'] = 0;
			$data['pesan'] = "Data gagal dihapus!";
			$transaction = Yii::app()->db->beginTransaction();
			try {
				if ($this->loadModel($id)->delete()) {
					$data['sukses'] = 1;
					$data['pesan'] = "Data berhasil dihapus!";
					$transaction->commit();
				} else {
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = "Data gagal dihapus karna sudah digunakan di tabel lain!";
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = "Data gagal dihapus karna sudah digunakan di tabel lain!";
			}
			echo CJSON::encode($data);
			Yii::app()->end();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	public function actionAutocompletePenjamin() {
		if (Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$term = isset($_GET['term']) ? $_GET['term'] : null;
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(penjamin_nama)', strtolower($term), true);
			$criteria->limit = 5;

			$models = SAPenjaminPasienM::model()->findAll($criteria);
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->penjamin_nama;
				$returnVal[$i]['value'] = $model->penjamin_id;
				$returnVal[$i]['carabayar_nama'] = $model->carabayar->carabayar_nama;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

}
