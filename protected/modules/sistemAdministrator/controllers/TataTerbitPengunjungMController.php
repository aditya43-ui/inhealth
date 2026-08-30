
<?php

class TataTerbitPengunjungMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'sistemAdministrator.views.tataTertibPengunjung.';


	public function actionIndex()
	{
		$model = TatatertibpengunjungM::model()->find();

		if(!isset($model) || empty($model)){
			$model = new TatatertibpengunjungM();
		}

		if(isset($_POST['TatatertibpengunjungM'])){
			$transaction = Yii::app()->db->beginTransaction();

			try {
				$model->attributes = $_POST['TatatertibpengunjungM'];

				if(!empty($model->tatatertibpengunjung_id)){
						$model->update_time = date('Y-m-d H:i:s');
						$model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
				}else{
					 $model->create_time = date('Y-m-d H:i:s');
						$model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
				}
				$model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");

				if($model->save()){
					$transaction->commit();
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					$this->redirect(array('index'));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan!");
				}
			} catch (Exception $ex) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
			}
		}

		$this->render($this->path_view.'index',array(
				'model'=>$model,
		));
	}

}
