
<?php

class RekonsiliasiObatController extends MyAuthController
{
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'rawatJalan.views.rekonsiliasiObat.';
    public $tersimpan = false;

    public function actionIndex($pendaftaran_id, $rekonsiliasiobat_id = null)
    {
        $format = new MyFormatter();
        $modPendaftaran= RJPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = new RJRekonsiliasiobatT();
        $modDetail = new RJRekonsiliasiobatdetT();
        $model->tgl_pengisiandokter = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasien_id = $modPasien->pasien_id;

        if(isset($_POST['RJRekonsiliasiobatT'])) {
            $transaction = Yii::app()->db->beginTransaction();

            try {
                $model->attributes = $_POST['RJRekonsiliasiobatT'];
                $model->tgl_pengisiandokter = (!empty($_POST['RJRekonsiliasiobatT']['tgl_pengisiandokter'])?MyFormatter::formatDateTimeForDb($_POST['RJRekonsiliasiobatT']['tgl_pengisiandokter']):null);
                $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->obatdiapakai = (($_POST['RJRekonsiliasiobatT']['obatdiapakai']==1)? 1 : 0);


                if(!empty($model->rekonsiliasiobat_id)){
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }else{
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }
                $model->create_ruangan = Yii::app()->user->getState("ruangan_id");

                $tersimpandetail = true;

                if($model->save()){
                    $this->tersimpan = true;

                    if(isset($_POST['RekonsiliasiobatdetT']) && count($_POST['RekonsiliasiobatdetT']) >0){
                        RJRekonsiliasiobatdetT::model()->deleteAllByAttributes(array('rekonsiliasiobat_id'=>$model->rekonsiliasiobat_id));

                        foreach ($_POST['RekonsiliasiobatdetT'] as $dataDet){
                            $modDetail = new RJRekonsiliasiobatdetT();
                            $modDetail->attributes = $dataDet;
                            $modDetail->rekonsiliasiobat_id = $model->rekonsiliasiobat_id;
                            $modDetail->islanjutadmisi = (isset($dataDet['islanjutadmisi'])?$dataDet['islanjutadmisi']:false);

                            if(!empty($modDetail->rekonsiliasiobatdet_id)){
                                    $modDetail->update_time = date('Y-m-d H:i:s');
                                    $modDetail->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                                }else{
                                    $modDetail->create_time = date('Y-m-d H:i:s');
                                    $modDetail->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                                }
                                 $modDetail->create_ruangan = Yii::app()->user->getState("pegawai_id");

                             if(!$modDetail->save()){
                                $tersimpandetail = false;
                            }
                        }
                    }
                }else{
                   $this->tersimpan = false;
                }

                if($this->tersimpan == true && $tersimpandetail == true){
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('index','pendaftaran_id'=>$model->pendaftaran_id));
                }else{
                    Yii::app()->user->setFlash('error',"Data gagal disimpan!");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        }

        $this->render($this->path_view.'index',
                array('modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'model'=>$model,
                    'modDetail'=>$modDetail

        ));
    }


    public function actionIndexTabulasi($pendaftaran_id=null)
    {
        $format = new MyFormatter();
        $modPendaftaran = new RJPendaftaranT();
        $modPasien = new RJPasienM();

        if(!empty($pendaftaran_id)){
          $modPendaftaran= RJPendaftaranT::model()->findByPk($pendaftaran_id);
          $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
        }

        $this->render($this->path_view.'indexTabulasi',
                array('modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,

        ));
    }


    public function getUrlRekonsiliasiObatAlergi() {
        return $this->module->id . '/RekonsiliasiObatAlergi/index';
    }


    public function getUrlRekonsiliasiObatAdmisi() {
        return $this->module->id . '/RekonsiliasiObatAdmisi/index';
    }

    public function getUrlRekonsiliasiObatTransfer() {
        return $this->module->id . '/RekonsiliasiObatTransfer/index';
    }

    public function getUrlRekonsiliasiObatDischarge() {
        return $this->module->id . '/RekonsiliasiObatDischarge/index';
    }

    public function actionPrint($pendaftaran_id) {
      $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
      // if(empty($ruangan_id)){
      //     $ruangan_id = Yii::app()->user->getState("ruangan_id");
      // }
      // $modRuangan = RuanganM::model()->findByPk($ruangan_id);

      // if($modRuangan->instalasi_id != Params::INSTALASI_ID_RI){
      //   $modPendaftaran->pasienadmisi_id = null;
      // }

      $modRekonAlergi = RekonobatalergiT::model()->findAllByAttributes(array('pendaftaran_id'=> $modPendaftaran->pendaftaran_id),array('order'=>'create_time DESC'));

      $crtRekonAdmisi = new CDbCriteria();
      $crtRekonAdmisi->select = "t.tanggal_pengisian, t.petugas_id, t.rujukansebelumnya, t.rujukanke, det.nama_obat, det.dosis, det.frekuensi, det.cara_pemberian, det.waktu_pemberian, det.jumlah_obat, det.tindaklanjut, det.keterangan, det.create_time";
  		$crtRekonAdmisi->group = $crtRekonAdmisi->select;
  		$crtRekonAdmisi->join = "JOIN rekonobatadmisidet_t det on det.rekonobatadmisi_id = t.rekonobatadmisi_id";
      $crtRekonAdmisi->addCondition('t.pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
      $crtRekonAdmisi->order = "det.create_time DESC";
      $modRekonAdmisi = RekonobatadmisiT::model()->findAll($crtRekonAdmisi);

      $crtRekonTransfer = new CDbCriteria();
      $crtRekonTransfer->select = "t.tanggal_pengisian, t.petugas_id, t.rujukansebelumnya, t.rujukanke, det.nama_obat, det.dosis, det.frekuensi, det.cara_pemberian, det.waktu_pemberian, det.jumlah_obat, det.tindaklanjut, det.keterangan, det.create_time";
  		$crtRekonTransfer->group = $crtRekonTransfer->select;
  		$crtRekonTransfer->join = "JOIN rekonobattransferdet_t det on det.rekonobattransfer_id = t.rekonobattransfer_id";
      $crtRekonTransfer->addCondition('t.pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
      $crtRekonTransfer->order = "det.create_time DESC";
      $modRekonTransfer = RekonobattransferT::model()->findAll($crtRekonTransfer);

      $crtRekonDischarge = new CDbCriteria();
      $crtRekonDischarge->select = "t.tanggal_pengisian, t.petugas_id, t.rujukansebelumnya, t.rujukanke, det.nama_obat, det.dosis, det.frekuensi, det.cara_pemberian, det.waktu_pemberian, det.jumlah_obat, det.tindaklanjut, det.keterangan, det.create_time";
  		$crtRekonDischarge->group = $crtRekonDischarge->select;
  		$crtRekonDischarge->join = "JOIN rekonobatdischargedet_t det on det.rekonobatdischarge_id = t.rekonobatdischarge_id";
      $crtRekonDischarge->addCondition('t.pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
      $crtRekonDischarge->order = "det.create_time DESC";
      $modRekonDischarge = RekonobatdischargeT::model()->findAll($crtRekonDischarge);

      $caraPrint = $_REQUEST['caraPrint'];
      $params = array(
        'modPasien' => $modPasien,
        'modPendaftaran' => $modPendaftaran,
        'modRekonAlergi'=>$modRekonAlergi,
        'modRekonAdmisi'=>$modRekonAdmisi,
        'modRekonTransfer'=>$modRekonTransfer,
        'modRekonDischarge'=>$modRekonDischarge,
        'caraPrint' => $caraPrint
      );

      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render($this->path_view . 'Print', $params);
      } else if ($caraPrint == 'EXCEL') {
          $this->layout = '//layouts/printExcel';
          $this->render($this->path_view . 'Print', $params);
      } else if ($_REQUEST['caraPrint'] == 'PDF') {
          $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
          $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
          $mpdf = new MyPDF('', $ukuranKertasPDF);
          $mpdf->useOddEven = 2;
          $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
          $mpdf->WriteHTML($stylesheet, 1);
          $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
          $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', $params, true));
          $mpdf->Output();
      }
    }

    public function actionAutocompleteInfoPasien() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $nama_pasien = isset($_POST['nama_pasien']) ? $_POST['nama_pasien'] : null;

            $returnVal = array();
            $criteria = new CDbCriteria();
           	 $criteria->compare('lower(nama_pasien)',strtolower($nama_pasien),false);
            $models = RJPasienrekonsiliasiobatV::model()->findAll($criteria);
            $returnVal = array();

            if(count($models) > 0){
              foreach($models as $i=>$model)
              {

              $attributes = $model->attributeNames();
              foreach ($attributes as $j => $attribute) {
                  $returnVal["$attribute"] = $model->$attribute;
              }
              $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
              $namaDokter = "";
              if(!empty($pendaftaran->pasienadmisi_id)){
                $namaDokter = (isset($pendaftaran->pasienadmisi)? (isset($pendaftaran->pasienadmisi->dokpenerima)? $pendaftaran->pasienadmisi->dokpenerima->namaLengkap: ""):"");
              }else{
                $namaDokter = (isset($pendaftaran->dokter)? $pendaftaran->dokter->namaLengkap:"");
              }
              $returnVal["dokterdpjp"] = $namaDokter;
              $returnVal["nama_pasien"] = $model->namadepan . $model->nama_pasien;
              $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
              $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            }
          }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}
