<?php

Yii::import('farmasiApotek.controllers.InformasiPenjualanResepController');
Yii::import('farmasiApotek.views.informasiPenjualanResep.*');

class InformasiPenjualanDokterController extends InformasiPenjualanResepController
{
  public function actionIndex()
  {
    $format = new MyFormatter();
    $modInfoPenjualan = new FAInformasipenjualanresepV('searchInfoJualDokter');
    $modInfoPenjualan->unsetAttributes();
    $modInfoPenjualan->tgl_awal = date('d M Y');
    $modInfoPenjualan->tgl_akhir = date('d M Y');
    if (isset($_GET['FAInformasipenjualanresepV'])) {
      $modInfoPenjualan->attributes = $_GET['FAInformasipenjualanresepV'];
      $modInfoPenjualan->tgl_awal = $format->formatDateTimeForDb($_GET['FAInformasipenjualanresepV']['tgl_awal']);
      $modInfoPenjualan->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInformasipenjualanresepV']['tgl_akhir']);
    }

    $this->render('index', array('modInfoPenjualan' => $modInfoPenjualan, 'format' => $format));
  }

  public function actionDetailPenjualan($id, $pasien_id)
  {
    $this->layout = '//layouts/iframe';

    $modDetailPenjualan = FAInformasipenjualanresepV::model()->findAll('penjualanresep_id=' . $id . ' and pasien_id=' . $pasien_id . '');
    $modReseptur = FAPenjualanResepT::model()->findByPk($id);


    $detailreseptur = FAObatalkesPasienT::model()->findAll('penjualanresep_id = ' . $id . ' ');
    $modPasien = FAPasienM::model()->findByPk($pasien_id);

    $this->render('DetailPenjualan', array(
      'modDetailPenjualan' => $modDetailPenjualan,
      'modReseptur' => $modReseptur, 'detailreseptur' => $detailreseptur
    ));
  }
  public function actionPrintStruk($id, $pasien_id)
  {
    $this->layout = '//layouts/iframe';

    $modDetailPenjualan = FAInformasipenjualanresepV::model()->findAll('penjualanresep_id=' . $id . ' and pasien_id=' . $pasien_id . '');
    $reseptur = FAPenjualanResepT::model()->find('penjualanresep_id = ' . $id . '');

    $criteria = new CDbCriteria();
    $criteria->select = 't.penjualanresep_id,
                                sum(t.qty_oa) As qty_oa,
                                sum(penjualanresep_t.biayaadministrasi) As biayaadministrasi,
                                sum(penjualanresep_t.biayakonseling) As biayakonseling,
                                sum(penjualanresep_t.totaltarifservice) As biayaservice,
                                sum(penjualanresep_t.jasadokterresep) As jasadokterresep,
                                sum(t.hargasatuan_oa) As hargasatuan_oa,
                                sum((t.qty_oa*t.hargasatuan_oa)*(t.discount/100)) As diskon,
                                sum((t.qty_oa * t.hargasatuan_oa)) As subtotal';
    $criteria->group = 't.penjualanresep_id';
    $criteria->join = 'RIGHT JOIN penjualanresep_t ON penjualanresep_t.penjualanresep_id = t.penjualanresep_id RIGHT JOIN obatalkes_m ON obatalkes_m.obatalkes_id = t.obatalkes_id';
    //           $criteria->with = array('penjualanresep,obatalkes');
    if (!empty($id)) {
      $criteria->addCondition("t.penjualanresep_id = " . $id);
    }
    $detailreseptur = FAObatalkesPasienT::model()->findAll($criteria);
    $daftar = FAPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $reseptur->pendaftaran_id));
    $pasien = FAPasienM::model()->findByAttributes(array('pasien_id' => $reseptur->pasien_id));

    $this->render('PrintStrukPenjualan', array(
      'reseptur' => $reseptur,
      'detailreseptur' => $detailreseptur, 'daftar' => $daftar, 'pasien' => $pasien, 'modDetailPenjualan' => $modDetailPenjualan
    ));
  }
  public function actionStrukPrint($id, $pasien_id)
  {
    $this->layout = '//layouts/iframe';

    $modDetailPenjualan = FAInformasipenjualanresepV::model()->findAll('penjualanresep_id=' . $id . ' and pasien_id=' . $pasien_id . '');
    $reseptur = FAPenjualanResepT::model()->find('penjualanresep_id = ' . $id . '');

    $criteria = new CDbCriteria();
    $criteria->select = 't.penjualanresep_id,
                                sum(t.qty_oa) As qty_oa,
                                sum(penjualanresep_t.biayaadministrasi) As biayaadministrasi,
                                sum(penjualanresep_t.biayakonseling) As biayakonseling,
                                sum(penjualanresep_t.totaltarifservice) As biayaservice,
                                sum(penjualanresep_t.jasadokterresep) As jasadokterresep,
                                sum(t.hargasatuan_oa) As hargasatuan_oa,
                                sum((t.qty_oa*t.hargasatuan_oa)*(t.discount/100)) As diskon,
                                sum((t.qty_oa * t.hargasatuan_oa)) As subtotal';
    $criteria->group = 't.penjualanresep_id';
    $criteria->join = 'RIGHT JOIN penjualanresep_t ON penjualanresep_t.penjualanresep_id = t.penjualanresep_id RIGHT JOIN obatalkes_m ON obatalkes_m.obatalkes_id = t.obatalkes_id';
    //           $criteria->with = array('penjualanresep,obatalkes');
    if (!empty($id)) {
      $criteria->addCondition("t.penjualanresep_id = " . $id);
    }
    $detailreseptur = FAObatalkesPasienT::model()->findAll($criteria);
    $daftar = FAPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $reseptur->pendaftaran_id));
    $pasien = FAPasienM::model()->findByAttributes(array('pasien_id' => $reseptur->pasien_id));
    $judulLaporan = 'Struk Penjualan';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('farmasiApotek.views.informasiPenjualanResep.PrintStrukPenjualan', array(
        'reseptur' => $reseptur,
        'detailreseptur' => $detailreseptur, 'daftar' => $daftar,
        'pasien' => $pasien, 'modDetailPenjualan' => $modDetailPenjualan,
        'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('farmasiApotek.views.informasiPenjualanResep.PrintStrukPenjualan', array(
        'reseptur' => $reseptur,
        'detailreseptur' => $detailreseptur, 'daftar' => $daftar,
        'pasien' => $pasien, 'modDetailPenjualan' => $modDetailPenjualan,
        'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('farmasiApotek.views.informasiPenjualanResep.PrintStrukPenjualan', array(
        'reseptur' => $reseptur,
        'detailreseptur' => $detailreseptur, 'daftar' => $daftar,
        'pasien' => $pasien, 'modDetailPenjualan' => $modDetailPenjualan,
        'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ), true));
      $mpdf->Output();
    }
  }

  public function actionPrintDetailPenjualan()
  {
    $id = $_POST['id'];
    $modDetailPenjualan = FAInformasipenjualanresepV::model()->findAll('penjualanresep_id=:penjualanresep', array(':penjualanresep' => $id));
    $modReseptur = FAPenjualanResepT::model()->findByPk($id);

    $detailreseptur = FAObatalkesPasienT::model()->findAll('penjualanresep_id = ' . $id . ' ');
    $modPasien = FAPasienM::model()->findByPk($pasien_id);

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('DetailPenjualan', array(
        'modDetailPenjualan' => $modDetailPenjualan,
        'modReseptur' => $modReseptur, 'detailreseptur' => $detailreseptur
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('DetailPenjualan', array(
        'modDetailPenjualan' => $modDetailPenjualan,
        'modReseptur' => $modReseptur, 'detailreseptur' => $detailreseptur
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('DetailPenjualan', array(
        'modDetailPenjualan' => $modDetailPenjualan,
        'modReseptur' => $modReseptur, 'detailreseptur' => $detailreseptur
      ), true));
      $mpdf->Output();
    }
    $this->render('DetailPenjualan', array(
      'modDetailPenjualan' => $modDetailPenjualan,
      'modReseptur' => $modReseptur, 'detailreseptur' => $detailreseptur
    ));
  }

  public function actionCopyResep($idPenjualanResep, $pasien_id, $id = null)
  {
    $this->layout = '//layouts/iframe';
    if (!empty($id)) {
      $model = FACopyResepR::model()->findAllByAttributes(array('penjualanresep_id' => $idPenjualanResep));
    } else {
      $model = new FACopyResepR;
    }
    $tersimpan = 'Tidak';

    $modelPenjualanResep = FAPenjualanResepT::model()->findByPk($idPenjualanResep);
    $modDetailPenjualan = FAInformasipenjualanresepV::model()->findAll('penjualanresep_id=' . $idPenjualanResep . ' and pasien_id=' . $pasien_id . '');
    $modPasien = FAPasienM::model()->findByPk($pasien_id);
    $modCopy = CopyresepR::model()->findAll('penjualanresep_id=' . $idPenjualanResep);
    foreach ($modCopy as $i => $data) {
      $copy = $data->jmlcopy;
    }
    $copy = $copy + 1;
    //             echo $copy;
    //             exit;
    if (isset($_POST['FACopyResepR'])) {
      $jmlCopy = $copy;
      $model->attributes = $_POST['FACopyResepR'];
      $model->tglcopy = date('Y-m-d');
      $model->penjualanresep_id = $_POST['FAPenjualanResepT']['penjualanresep_id'];
      $model->keterangancopy = $_POST['FACopyResepR']['keterangancopy'];
      $model->jmlcopy = $jmlCopy;
      $model->create_time = date('Y-m-d');
      $model->update_time = date('Y-m-d');
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->update_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      //                    
      //                    echo print_r($model->getAttributes());
      //                    exit;
      if ($model->validate()) {
        if ($modCopy > 0) {
          $update = CopyresepR::model()->UpdateAll(array(
            'jmlcopy' => $jmlCopy,
            'tglcopy' => date('Y-m-d'),
            'keterangancopy' => $_POST['FACopyResepR']['keterangancopy'],
            'create_time' => date('Y-m-d'),
            'update_time' => date('Y-m-d'),
            'create_loginpemakai_id' => Yii::app()->user->id,
            'update_loginpemakai_id' => Yii::app()->user->id,
            'create_ruangan' => Yii::app()->user->getState('ruangan_id')
          ), 'penjualanresep_id=:penjualanresep_id', array(':penjualanresep_id' => $_POST['FAPenjualanResepT']['penjualanresep_id']));

          if ($update) {
            Yii::app()->user->setFlash('success', "Data berhasil disimpan");
            $tersimpan = 'Ya';
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
          }
        } else {
          if ($model->save()) {
            Yii::app()->user->setFlash('success', "Data berhasil disimpan");
            $tersimpan = 'Ya';
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
          }
        }
      }
    }

    $model->tglcopy = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($model->tglcopy, 'yyyy-MM-dd')
    );

    $this->render('formCopyResep', array(
      'modelPenjualanResep' => $modelPenjualanResep,
      'modPasien' => $modPasien,
      'model' => $model,
      'modCopy' => $modCopy,
      'modDetailPenjualan' => $modDetailPenjualan,
      'tersimpan' => $tersimpan,
    ));
  }

  public function actionPrintCopyResep($idPenjualanResep)
  {
    $this->layout = '//layouts/printWindows';

    $modelPenjualanResep = FAPenjualanResepT::model()->findByPk($idPenjualanResep);
    $modReseptur = ResepturT::model()->findAll('penjualanresep_id = ' . $idPenjualanResep);
    $modCopy = CopyresepR::model()->findAll('penjualanresep_id = ' . $idPenjualanResep);
    $modDetailPenjualan = FAInformasipenjualanresepV::model()->findAll('penjualanresep_id=' . $idPenjualanResep . ' and pasien_id=' . $modelPenjualanResep->pasien_id . '');
    $modPasien = FAPasienM::model()->findByPk($modelPenjualanResep->pasien_id);

    $this->render('PrintCopyResep', array(
      'modelPenjualanResep' => $modelPenjualanResep,
      'modPasien' => $modPasien,
      'modDetailPenjualan' => $modDetailPenjualan,
      'modReseptur' => $modReseptur,
      'modCopy' => $modCopy,
    ));
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

  /**
   * untuk print data penjualan resep
   */
  public function actionPrint($penjualanresep_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
    $modPenjualanDetail = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id));

    $judul_print = 'Penjualan Pegawai / Dokter';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPenjualan' => $modPenjualan,
      'modPenjualanDetail' => $modPenjualanDetail,
      'caraPrint' => $caraPrint
    ));
  }

  public function actionUbahStatusObat()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $penjualanresep_id = isset($_POST['penjualanresep_id']) ? $_POST['penjualanresep_id'] : null;
      $pesan = 'gagal';
      $tanggal = date('Y-m-d H:i:s');
      if ($status == 'BELUM') {
        $statusNew = 'SEDANG';
        $update = PenjualanresepT::model()->updateByPk($penjualanresep_id, array('statusobat' => $statusNew, 'tglsedangdisiapkan' => $tanggal));
      } else {
        $statusNew = 'SUDAH';
        $update = PenjualanresepT::model()->updateByPk($penjualanresep_id, array('statusobat' => $statusNew, 'tglselesaidisiapkan' => $tanggal));
      }

      if ($update) {
        $pesan = 'ok';
      } else {
        $pesan = 'gagal';
      }
      $data['pesan'] = $pesan;

      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
