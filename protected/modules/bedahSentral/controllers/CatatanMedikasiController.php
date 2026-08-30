<?php

/**
 * Description of CatatanMedikasiController
 *
 * @author inova
 */
class CatatanMedikasiController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $ok = true;

  public function actionIndex($pasienmasukpenunjang_id)
  {
    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $admisi = PasienadmisiT::model()->findByPk($penunjang->pasienadmisi_id);


    $ruangpulih = PasienruangpulihT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    if (empty($ruangpulih)) {
      echo "Harus dilakukan transaksi Masuk Ruang Pulih sebelum mengakses form ini";
      Yii::app()->end();
    }

    if (isset($_POST['ObatalkespasienT']['detail'])) {
      $trans = Yii::app()->db->beginTransaction();
      $this->ok = true;
      $stokValidasiKet = "";

      try {
        foreach ($_POST['ObatalkespasienT']['detail'] as $item) {
          $oa = ObatalkesM::model()->findByPk($item['obatalkes_id']);

          $det = new ObatalkespasienT;
          $det->attributes = $oa->attributes;
          $det->attributes = $penunjang->attributes;
          $det->attributes = $ruangpulih->attributes;
          $det->attributes = $item;
          $det->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
          $det->qty_oa = 1;
          $det->harganetto_oa = $oa->harganetto;
          $det->harganetto_oa = $oa->harganetto;
          $det->hargasatuan_oa = $oa->hjanonresep;
          $det->hargajual_oa = $det->qty_oa * $det->hargasatuan_oa;

         
          if ($det->isNewRecord) {
            $det->create_time = date('Y-m-d H:i:s');
            $det->create_loginpemakai_id = Yii::app()->user->id;
            $det->create_ruangan = Yii::app()->user->getState('ruangan_id');
          }
          $det->update_time = date('Y-m-d H:i:s');
          $det->update_loginpemakai_id = Yii::app()->user->id;

          if ($det->validate()) {
            

            if($det->save()){
              
              $stok_ada = StokobatalkesT::getJumlahStok($det->obatalkes_id, Yii::app()->user->getState("ruangan_id"));
              
              if ($stok_ada <= 0) {
            //     echo '== '.$stok_ada;
            // exit();
                $this->ok = false;
                  $stokValidasiKet = "Stok tidak mencukupi";
              }else{
                $this->ok = true;
                $stok = $this->simpanStokObatAlkesOut($det);
                if (empty($stok)) {
                  $this->ok = false;
                }
              }
            }else{
              $this->ok = false;
            }
          } else {
            $this->ok = false;
          }

        }
       
        if ($this->ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('index', 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        } else {
          $trans->rollback();
          if(!empty($stokValidasiKet)){
            Yii::app()->user->setFlash('error', $stokValidasiKet);
          }else{
            Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
          }
          
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<strong>Data gagal disimpan.' . MyExceptionMessage::getMessage($ex, true) . '</strong>');
      }
    }


    $this->render('index', array(
      'ruangpulih' => $ruangpulih,
      'admisi' => $admisi,
      'penunjang' => $penunjang,
    ));
  }

  public function actionAutocompleteObatAlkes($term = null)
  {

    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $model = new BSObatalkesM();
    $model->unsetAttributes();
    $model->obatalkes_nama = $term;
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    $prop = $model->searchObatPasienRuangan();
    $prop->pagination = false;

    $res = array();
    foreach ($prop->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->obatalkes_nama;
      $sub['value'] = $item->obatalkes_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  protected function simpanStokObatAlkesOut($modObatAlkesPasien)
  {
    $format = new MyFormatter;
    // $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $oa = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $oa->attributes;
    $modStokOaNew->attributes = $modObatAlkesPasien->attributes; //duplicate
    $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
    $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
    // $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

    $modStokOaNew->tglterima = $modStokOaNew->create_time;

    // var_dump($modStokOaNew->attributes); 
    // var_dump($modStokOaNew->validate());
    // var_dump($modStokOaNew->errors);
    // die;

    if ($modStokOaNew->validate()) {
      $modStokOaNew->save();
      // $modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      return null;
    }


    if (empty($modStokOaNew->stokobatalkes_id)) {
      return null;
    }

    return $modStokOaNew;
  }


  public function actionDelete()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['id'];
    $trans = Yii::app()->db->beginTransaction();
    $ok = 1;
    $msg = "";

    try {
      StokobatalkesT::model()->deleteAllByAttributes(array(
        'obatalkespasien_id' => $id,
      ));
      ObatalkespasienT::model()->deleteByPk($id);
      $trans->commit();
    } catch (Exception $ex) {
      $trans->rollback();
      $ok = 0;
      $msg = "Data gagal dihapus dikarenakan sudah dilakukan transaksi pembayaran sebelumnya.";
    }


    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }
}
