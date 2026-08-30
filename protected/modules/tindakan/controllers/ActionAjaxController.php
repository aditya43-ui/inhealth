<?php

/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAjaxController extends MyAuthController
{
  public function actionLoadTindakanKomponenPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];

      $tindakans = TindakanpelayananT::model()->with('daftartindakan')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id,));
      foreach ($tindakans as $i => $tindakan) {
        $returnVal[$tindakan->tindakanpelayanan_id]['daftartindakan_id'] = $tindakan->daftartindakan_id;
        $returnVal[$tindakan->tindakanpelayanan_id]['daftartindakan_nama'] = $tindakan->daftartindakan->daftartindakan_nama;
        $komponens = TindakankomponenT::model()->findAllByAttributes(array('tindakanpelayanan_id' => $tindakan->tindakanpelayanan_id));

        foreach ($komponens as $j => $komponen) {
          $tindKomponenId = $komponen->tindakankomponen_id;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['tindakankomponen_id'] = $tindKomponenId;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['komponentarif_id'] = $komponen->komponentarif_id;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['komponentarif_nama'] = $komponen->komponentarif->komponentarif_nama;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['tarif_kompsatuan'] = $komponen->tarif_kompsatuan;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['tarif_tindakankomp'] = $komponen->tarif_tindakankomp;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['tarifcyto_tindakankomp'] = $komponen->tarifcyto_tindakankomp;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['subsidiasuransikomp'] = $komponen->subsidiasuransikomp;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['subsidipemerintahkomp'] = $komponen->subsidipemerintahkomp;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['subsidirumahsakitkomp'] = $komponen->subsidirumahsakitkomp;
          $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['iurbiayakomp'] = $komponen->iurbiayakomp;
        }
      }

      $form = $this->renderPartial('_formPembebasanTarif', array('data' => $returnVal), true);
      $returnVal['tabelPembebasanTarif'] = $form;

      echo CJSON::encode($returnVal);
    }
  }

  public function actionCekHakAkses()
  {
    if (!Yii::app()->user->checkAccess('Administrator')) {
      //throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
      $data['cekAkses'] = false;
    } else {
      $pendaftaran = PendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
      $data['pendaftaran'] = $pendaftaran->attributes;
      //echo 'punya hak akses';
      $pasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id));
      $ruangan_m = RuanganM::model()->findByPk($pasienAdmisi->ruangan_id);
      $data['ruanganPasien'] =  $ruangan_m->ruangan_nama;
      $data['cekAkses'] = true;
      $data['userid'] = Yii::app()->user->id;
      $data['username'] = Yii::app()->user->name;
    }

    echo CJSON::encode($data);
    Yii::app()->end();
  }

  public function actiondataPasien()
  {
    $pasien_id = $_POST['pasien_id'];
    $pendaftaran_id = $_POST['pendaftaran_id'];
    $modPasien = RIPasienM::model()->findByPk($pasien_id);
    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $form = $this->renderPartial('/_ringkasDataPasien', array(
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
    ), true);

    $data['form'] = $form;
    echo CJSON::encode($data);
  }
}
