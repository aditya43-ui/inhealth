<?php

class BatalBayarSupplierController extends MyAuthController
{
  protected $successSave = true;
  public $path_view = 'billingKasir.views.batalBayarSupplier.';

  public function actionIndex($id = null)
  {
    if (!empty($_GET['frame'])) {
      $this->layout = 'iframe';
    }
    $modBuktiKeluar = new KUTandabuktikeluarT;
    $modBayarSupplier = new KUBayarkesupplierT;
    $modBatalBayar = new KUBatalBayarSupplierT;

    if (!empty($id)) {
      $modBatalBayar = KUBatalBayarSupplierT::model()->findByPk($id);
      $modBuktiKeluar = KUTandabuktikeluarT::model()->findByPk($modBatalBayar->tandabuktikeluar_id);
      $modBayarSupplier = KUBayarkesupplierT::model()->findByPk($modBatalBayar->bayarkesupplier_id);
    }

    if (isset($_POST['KUBatalBayarSupplierT'])) {
      // var_dump($_POST); die;
      $modBuktiKeluar->attributes = $_POST['KUTandabuktikeluarT'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modBatalBayar = $this->saveBatalBayarSupplier($_POST['KUBatalBayarSupplierT']);
        if ($this->successSave) {
          $transaction->commit();
          $this->redirect(array('index', 'id' => $modBatalBayar->batalbayarsupplier_id));
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'modBuktiKeluar' => $modBuktiKeluar,
      'modBayarSupplier' => $modBayarSupplier,
      'modBatalBayar' => $modBatalBayar
    ));
  }

  protected function saveBatalBayarSupplier($postBatalBayar)
  {
    $modBatalBayar = new KUBatalBayarSupplierT;
    $modBatalBayar->attributes = $postBatalBayar;
    $modBatalBayar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if ($modBatalBayar->validate()) {
      $this->successSave = $this->successSave && $modBatalBayar->save();
      BayarkesupplierT::model()->updateByPk($modBatalBayar->bayarkesupplier_id, array(
        'batalbayarsupplier_id' => $modBatalBayar->batalbayarsupplier_id,
      ));
    } else {
      $this->successSave = false;
    }

    return $modBatalBayar;
  }

  public function actionCekLogin($task = 'Retur')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $idRuangan = Yii::app()->user->getState('ruangan_id');

      $user = LoginpemakaiK::model()->findByAttributes(array(
        'nama_pemakai' => $username,
        'loginpemakai_aktif' => TRUE
      ));
      if ($user === null) {
        $data['error'] = "Login Pemakai salah!";
        $data['cssError'] = 'username';
        $data['status'] = 'Gagal Login';
      } else {
        // cek password
        if ($user->katakunci_pemakai !== $user->encrypt($password)) {
          $data['error'] = 'password salah!';
          $data['cssError'] = 'password';
          $data['status'] = 'Gagal Login';
        } else {
          // cek ruangan
          $ruangan_user = RuanganpemakaiK::model()->findByAttributes(array(
            'loginpemakai_id' => $user->loginpemakai_id,
            'ruangan_id' => $idRuangan
          ));
          if ($ruangan_user === null) {
            $data['error'] = 'ruangan salah!';
            $data['status'] = 'Gagal Login';
          } else {
            $data['error'] = '';
            $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id)); //dari MyAuthController
            if ($cek) {
              $data['status'] = 'success';
              $data['userid'] = $user->loginpemakai_id;
              $data['username'] = $user->nama_pemakai;
            } else {
              $data['status'] = 'Anda tidak memiliki hak melakukan proses ini!';
            }
          }
        }
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionInfoBayarSupplier()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(t.nokaskeluar)', strtolower($_GET['term']), true);
      $criteria->addCondition('t.bayarkesupplier_id IS NOT NULL');
      $criteria->join = "LEFT JOIN bayarkesupplier_t ON bayarkesupplier_t.bayarkesupplier_id = t.bayarkesupplier_id";
      $models = KUTandabuktikeluarT::model()->findAll($criteria);
      if (count((array)$models) > 0) {
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->nokaskeluar . ' - ' . $model->namapenerima;
          $returnVal[$i]['value'] = $model->nokaskeluar;
          $returnVal[$i]['tglbayarkesupplier'] = $model->bayarkesupplier->tglbayarkesupplier;
          $returnVal[$i]['totaltagihan'] = $model->bayarkesupplier->totaltagihan;
          $returnVal[$i]['jmldibayarkan'] = $model->bayarkesupplier->jmldibayarkan;
        }
      } else {
        $returnVal = null;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  // Uncomment the following methods and override them if needed
  /*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
