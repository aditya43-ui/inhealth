<?php

class PengeluaranUmumController extends MyAuthController
{
  protected $succesSave = true;

  public function actionIndex()
  {
    $modPengUmum = new BKPengeluaranumumT;
    $modPengUmum->tglpengeluaran = date('Y-m-d H:i:s');
    $modPengUmum->volume = 1;
    $modPengUmum->hargasatuan = 0;
    $modPengUmum->totalharga = 0;
    $modPengUmum->nopengeluaran = MyGenerator::noPengeluaranUmum();
    $modUraian[0] = new BKUraiankeluarumumT;
    $modUraian[0]->volume = 1;
    $modUraian[0]->hargasatuan = 0;
    $modUraian[0]->totalharga = 0;
    $modBuktiKeluar = new BKTandabuktikeluarT;
    $modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
    $modBuktiKeluar->biayaadministrasi = 0;
    $modBuktiKeluar->jmlkaskeluar = 0;

    if (isset($_POST['BKPengeluaranumumT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modBuktiKeluar = $this->saveTandaBuktiKeluar($_POST['BKTandabuktikeluarT']);
        $modPengUmum = $this->savePengeluaranUmum($_POST['BKPengeluaranumumT'], $modBuktiKeluar);
        $this->updateTandaBuktiKeluar($modBuktiKeluar, $modPengUmum);

        if ($modPengUmum->isurainkeluarumum && isset($_POST['BKUraiankeluarumumT'])) {
          $modUraian = $this->saveUraian($_POST['BKUraiankeluarumumT'], $modPengUmum);
        }

        if ($this->succesSave) {
          $transaction->commit();
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

    $this->render('index', array(
      'modPengUmum' => $modPengUmum,
      'modUraian' => $modUraian,
      'modBuktiKeluar' => $modBuktiKeluar
    ));
  }

  protected function savePengeluaranUmum($postPengeluaran, $modBuktiKeluar)
  {

    $modPengUmum = new BKPengeluaranumumT;
    $modPengUmum->attributes = $postPengeluaran;

    $format = new MyFormatter;
    $modPengUmum->tglpengeluaran = $format->formatDateTimeForDb($postPengeluaran['tglpengeluaran']);
    $modPengUmum->biayaadministrasi = $modBuktiKeluar->biayaadministrasi;
    $modPengUmum->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
    if ($modPengUmum->validate()) {
      $modPengUmum->save();
      $this->succesSave = $this->succesSave && true;
    } else {
      $this->succesSave = false;
    }

    return $modPengUmum;
  }

  protected function saveTandaBuktiKeluar($postBuktiKeluar)
  {
    $modBuktiKeluar = new BKTandabuktikeluarT;
    $modBuktiKeluar->attributes = $postBuktiKeluar;
    //$format = new customFormat;
    //$modBuktiKeluar->tglkaskeluar = $format->formatDateTimeForDb($postBuktiKeluar['tglkaskeluar']);
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
    $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->tahun = date('Y');


    if ($modBuktiKeluar->validate()) {
      $modBuktiKeluar->save();
      $this->succesSave = $this->succesSave && true;
    } else {
      $this->succesSave = false;
    }

    return $modBuktiKeluar;
  }

  protected function saveUraian($arrPostUraian, $modPengUmum)
  {
    //echo "<pre>".print_r($arrPostUraian,1)."</pre>";
    $valid = true;
    for ($i = 0; $i < count((array)$arrPostUraian); $i++) {
      $modUraian[$i] = new BKUraiankeluarumumT;
      $modUraian[$i]->attributes = $arrPostUraian[$i];
      $modUraian[$i]->pengeluaranumum_id = $modPengUmum->pengeluaranumum_id;
      $valid = $valid && $modUraian[$i]->validate();
      $modUraian[$i]->validate();
    }
    if ($valid) {
      for ($j = 0; $j < count((array)$arrPostUraian); $j++) {
        $modUraian[$j]->save();
      }
    }

    $this->succesSave = $this->succesSave && $valid;

    return $modUraian;
  }

  protected function updateTandaBuktiKeluar($modBuktiKeluar, $modPengUmum)
  {
    BKTandabuktikeluarT::model()->updateByPk($modBuktiKeluar->tandabuktikeluar_id, array('pengeluaranumum_id' => $modPengUmum->pengeluaranumum_id));
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
