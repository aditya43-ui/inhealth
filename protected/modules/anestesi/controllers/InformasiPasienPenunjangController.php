<?php

class InformasiPasienPenunjangController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view='anestesi.views.informasiPasienPenunjang.';
	public $path_tips='anestesi.views.tips.';


	public function actionIndex()
	{
		$model = new ATPasienmasukpenunjangV('searchInformasiPasien');
		$model->unsetAttributes();
		$model->tgl_awal = date('d M Y H:i:s');
		$model->tgl_akhir = date('d M Y H:i:s');
		
		if(isset($_GET['ATPasienmasukpenunjangV'])){
			$model->attributes = $_GET['ATPasienmasukpenunjangV'];
			$format = new MyFormatter();
			$model->tgl_awal  = $format->formatDateTimeForDb($_GET['ATPasienmasukpenunjangV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['ATPasienmasukpenunjangV']['tgl_akhir']);
		}

		if (Yii::app()->request->isAjaxRequest) {
			echo $this->renderPartial('_tablePasien', array('model'=>$model));
		}else{
			$this->render('index',array('model'=>$model));
		}
	}
	
	public function actionAnestesi($pasienmasukpenunjang_id = null, $pendaftaran_id = null){
		$this->layout = '//layouts/iframe';
		$format = new MyFormatter();
		$modPasienPenunjang = ATPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
		$status = false;
		
		$modPasienAnestesi = new ATPasienanastesiT();
		$modPasienAnestesi->noanestesi = '-Otomatis-';
		$modPasienAnestesi->tglanastesi = date('d/m/Y H:i:s');

		if (isset($_POST['ATPasienanastesiT'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$modPasienAnestesi->attributes = $_POST['ATPasienanastesiT'];
				$modPasienAnestesi->pasien_id = $modPasienPenunjang->pasien_id;
				$modPasienAnestesi->pasienmasukpenunjang_id = $modPasienPenunjang->pasienmasukpenunjang_id;
				$modPasienAnestesi->pendaftaran_id = $modPasienPenunjang->pendaftaran_id;
                                $modPasienAnestesi->dokteranastesi_id = $modPasienPenunjang->pegawai_id;
				$modPasienAnestesi->tglanastesi = !empty($_POST['ATPasienanastesiT']['tglanastesi']) ? $format->formatDateTimeForDb($_POST['ATPasienanastesiT']['tglanastesi']) : date('Y-m-d H:i:s');
				$modPasienAnestesi->noanestesi = MyGenerator::noAnestesi();
                                $modPasienAnestesi->jenisanastesi_id = 1;
				$modPasienAnestesi->create_time = date('Y-m-d H:i:s');
				$modPasienAnestesi->create_loginpemakai_id = Yii::app()->user->id;
				$modPasienAnestesi->create_ruangan = Yii::app()->user->getState('ruangan_id');                               
                                
				if ($modPasienAnestesi->save()) {
					$transaction->commit();
					$status = true;
					Yii::app()->user->setFlash('success', "Data anestesi pasien berhasil disimpan !");
				} else {
					$status = false;
					Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data anestesi pasien gagal disimpan');
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				$status = false;
				Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
			}
		}

		$this->render($this->path_view . '_formAnestesi', array(
			'modPasienPenunjang' => $modPasienPenunjang,
			'modPasienAnestesi' => $modPasienAnestesi,
			'status' => $status
		));
	}
	
}
