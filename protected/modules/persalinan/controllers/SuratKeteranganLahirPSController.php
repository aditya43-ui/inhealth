<?php

Yii::import('rekamMedis.controllers.SuratKeteranganController');
Yii::import('rekamMedis.models.*');

/**
 * digunakan sebagai url utama untuk surat keterangan lahir di module persalinank
 * @author rusdiyanto <rusdiyanto@.com>
 * @package application.modules.persalinan
 * @subpackage controllers
 */
class SuratKeteranganLahirPSController extends SuratKeteranganController
{
  public $path_view = 'rekamMedis.views.suratKeterangan.';
  public $is_persalinan = true;

  /**
   * untuk surat kelahiran
   * @param integer $pendaftaran_id
   * @param integer $kelahiranbayi_id
   */
  public function actionSuratLahir($pendaftaran_id = null, $kelahiranbayi_id = null)
  {
    SuratKeteranganController::actionSuratLahir($pendaftaran_id, $kelahiranbayi_id);
  }

  /**
   * untuk surat kelahiran
   * @param integer $kelahiranbayi_id
   */
  public function actionCetakSuratKelarihan($kelahiranbayi_id)
  {
    $this->layout = '//layouts/iframe';

    $cekSurat = SuratketeranganR::model()->findByAttributes(array('kelahiranbayi_id' => $kelahiranbayi_id));
    if (isset($cekSurat)) {
      $modKelahiran = KelahiranbayiT::model()->findByPk($kelahiranbayi_id);
      $modPersalinan = PersalinanT::model()->findByPk($modKelahiran->persalinan_id);
      $model = SuratketeranganR::model()->findByPk($cekSurat->suratketerangan_id);
      $format = new MyFormatter();

      $model->lahir_tgllahir = array(
        'date' => date('Y-m-d', strtotime($model->lahir_tgllahir)),
        'time' => date('H:i:s', strtotime($model->lahir_tgllahir)),
      );
    } else {
      $format = new MyFormatter();
      $model = new SuratketeranganR;
      $modPekerjaan = '';
      $modPropinsi = '';
      $modKelurahan = '';
      $modKecamatan = '';
      $modKelahiran = '';
      $modPendaftaranData = '';
      $modPasienData = '';
      $modKabupaten = '';
      $modKelahiran = KelahiranbayiT::model()->findByPk($kelahiranbayi_id);
      $modPersalinan = PersalinanT::model()->findByPk($modKelahiran->persalinan_id);
      if (isset($modPersalinan)) {
        $modPendaftaranData = PendaftaranT::model()->findByPk($modPersalinan->pendaftaran_id);
        $modPasienData = PasienM::model()->findByPk($modPendaftaranData->pasien_id);
        if (isset($modPasienData)) {
          $modPekerjaan = PekerjaanM::model()->findByPk($modPasienData->pekerjaan_id);
          $modKelurahan = KelurahanM::model()->findByPk($modPasienData->kelurahan_id);
          $modPropinsi = PropinsiM::model()->findByPk($modPasienData->propinsi_id);
          $modKecamatan = KecamatanM::model()->findByPk($modPasienData->kecamatan_id);
          $modKabupaten = KabupatenM::model()->findByPk($modPasienData->kabupaten_id);
        }
        if (isset($modKelahiran)) {
          $model->lahir_beratbadan_gram = $modKelahiran->bb_gram;
          $model->lahir_panjangbadan_cm = $modKelahiran->tb_cm;
          $model->lahir_namaibu = $modPasienData->nama_pasien;
          $model->lahir_tgllahir = array(
            'date' => date('Y-m-d', strtotime($modKelahiran->tgllahirbayi)),
            'time' => date('H:i:s', strtotime($modKelahiran->tgllahirbayi)),
          );
          $model->lahir_ibu_umur = $modPendaftaranData->umur;
          $model->lahir_pekerjaan_ibu = isset($modPekerjaan) ? $modPekerjaan->pekerjaan_nama : '';
          $model->lahir_ktp_ibu = $modPasienData->no_identitas_pasien;
          $model->lahir_alamat = $modPasienData->alamat_pasien;
          $model->lahir_propinsi = $modPropinsi->propinsi_id;
          $model->lahir_kabupaten = $modKabupaten->kabupaten_id;
          $model->lahir_kecamatan = $modKecamatan->kecamatan_id;
          $model->lahir_jeniskelahiran = ""; //$modPersalinan->jnskelahiranhidup;
          // var_dump( $model->lahir_tgllahir);die;
        }
      }
      $modPasien = new PasienM;
      $modPendaftaran = new PendaftaranT;
      $model->nomorsurat = MyGenerator::noSurat(18, "SKL");
    }
    $modPendaftaran = PendaftaranT::model()->findByPk($modPersalinan->pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    if (isset($_POST['SuratketeranganR'])) {
      // var_dump($_POST['SuratketeranganR']);die;


      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['SuratketeranganR'];
        $model->tglsurat = date('Y-m-d');
        $model->jenissurat_id = 18; //surat keterangan lahir
        $model->nourutsurat = 1;
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasien_id = $modPasien->pasien_id;
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jmlprint_surat = 1;
        $model->mengetahui_surat = isset($_POST['SuratketeranganR']['mengetahui_surat']) ? $_POST['SuratketeranganR']['mengetahui_surat'] : null;
        $model->profilrs_id = 1;
        $model->judulsurat = "SURAT KETERANGAN LAHIR";
        $model->lahir_panjangbadan_cm = $_POST['SuratketeranganR']['lahir_panjangbadan_cm'];
        $model->lahir_beratbadan_gram = $_POST['SuratketeranganR']['lahir_beratbadan_gram'];
        $model->lahir_namaibu = $_POST['SuratketeranganR']['lahir_namaibu'];
        $model->lahir_namaayah = $_POST['SuratketeranganR']['lahir_namaayah'];
        $model->lahir_pekerjaan_ayah = $_POST['SuratketeranganR']['lahir_pekerjaan_ayah'];
        $model->no_pekerja_badge = isset($_POST['SuratketeranganR']['no_pekerja_badge']) ? $_POST['SuratketeranganR']['no_pekerja_badge'] : null;
        $model->no_ktp_ayah = $_POST['SuratketeranganR']['no_ktp_ayah'];
        $model->lahir_alamat = $_POST['SuratketeranganR']['lahir_alamat'];
        $model->dokter_persalinan_id = $_POST['SuratketeranganR']['dokter_persalinan_id'];
        //$model->lahir_tgllahir = $format->formatDateTimeForDb($_POST['lahir_tgllahir']);
        $model->lahir_kabupaten = $model->lahir_kabupaten;
        $model->lahir_kecamatan = $model->lahir_kecamatan;
        // var_dump($model->lahir_propinsi);die;
        $model->lahir_propinsi = $model->lahir_propinsi;
        
        $model->kelahiranbayi_id = $kelahiranbayi_id;
        $model->create_time = date('Y-m-d');
        $model->update_time = date('Y-m-d');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->update_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        $model->lahir_tgllahir = $format->formatDateTimeForDb($_POST['lahir_tgllahir']['date'] . " " . $_POST['lahir_tgllahir']['time']);
        // var_dump($format->formatDateTimeForDb($_POST['lahir_tgllahir']['date'] . "-- " . $_POST['lahir_tgllahir']['time']));die;

        if ($model->validate()) {
          if ($model->save()) {
            $transaction->commit();
            $model->isNewRecord = FALSE;
            if (!empty($_GET['pendaftaran_id'])) {
              // $model->suratketerangan_id = $model->suratketerangan_id;
            }
            Yii::app()->user->setFlash('success', "Surat Keterangan Lahir berhasil disimpan");
          $this->redirect(array(
            'CetakSuratKelarihan', 'kelahiranbayi_id' => $kelahiranbayi_id,
            'suratketerangan_id' => $model->suratketerangan_id
          ));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Surat Keterangan Lahir gagal disimpan ");
          }

          
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Surat Keterangan Lahir gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    
    if (!empty($model->lahir_tgllahir)&& !is_array($model->lahir_tgllahir) ){
      // var_dump($model->lahir_tgllahir);die;
      $model->lahir_tgllahir = array(
        'date' => date('Y-m-d', strtotime($model->lahir_tgllahir)),
        'time' => date('H:i:s', strtotime($model->lahir_tgllahir)),
      );
    }
    // var_dump($model->lahir_tgllahir['date']);die;
    $this->render(
      $this->path_view . 'lahir/index',
      array(
        'model' => $model,
        'modPasien' => $modPasien,
        'modPendaftaran' => $modPendaftaran,
        'modKelahiran' => $modKelahiran,
        'modPersalinan' => $modPersalinan
      )
    );
  }

  /**
   * untuk cetak surat kelahiran
   * @param integer $kelahiranbayi_id
   * @param integer $pendaftaran_id
   * @param integer $suratketerangan_id
   * @param integer $lama_hari
   */
  public function actionPrintSuratLahirNew($kelahiranbayi_id, $pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null)
  {
    $this->layout = '//layouts/iframe';
    $modKelahiran = KelahiranbayiT::model()->findByPk($kelahiranbayi_id);
    $modPersalinan = PersalinanT::model()->findByPk($modKelahiran->persalinan_id);
    $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    //        $modDokter = PegawaiM::model()->findByPk($modAdmisi->pegawai_id);
    $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);

    //        $mengetahui = $modDokter->gelardepan." ".$modDokter->nama_pegawai." .".$modDokter->gelarbelakang->gelarbelakang_nama;
    $judulLaporan = '';

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows3';
    }
    $this->render($this->path_view . 'lahir/printSuratLahirV2', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modAdmisi' => $modAdmisi,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'caraPrint' => $caraPrint,
      'modKelahiran' => $modKelahiran,
      'modPersalinan' => $modPersalinan
    ));
  }


  public function actionPrintSuratLahir($pendaftaran_id = null, $suratketerangan_id = null, $lama_hari = null)
  {
    $this->layout = '//layouts/iframe';

    $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    //        $modDokter = PegawaiM::model()->findByPk($modAdmisi->pegawai_id);
    $model = RKSuratketeranganR::model()->findByPk($suratketerangan_id);
    $modKelahiran = KelahiranbayiT::model()->findByPk($model->kelahiranbayi_id);

    if (empty($modKelahiran)) {
      $modKelahiran = new KelahiranbayiT;
    }

    //        $mengetahui = $modDokter->gelardepan." ".$modDokter->nama_pegawai." .".$modDokter->gelarbelakang->gelarbelakang_nama;
    $judulLaporan = '';

    $caraPrint = $_REQUEST['caraPrint'];
    /*
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'lahir/printSuratLahirV2',array(
                'modPendaftaran'=>$modPendaftaran, 
                'modPasien'=>$modPasien,
                'modAdmisi'=>$modAdmisi,
                'model'=>$model, 
                'judulLaporan'=>$judulLaporan,
                'modKelahiran'=>$modKelahiran,
                'caraPrint'=>$caraPrint));
         * 
         */


    $ukuranKertasPDF = 'A5';                  //Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
    $mpdf = new MyPDF60('', $ukuranKertasPDF);
    $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A5.css');
    $mpdf->WriteHTML($formatkonten, 1);
    // $mpdf->SetHTMLFooter($this->renderPartial($this->path_view."footerSurat", array(), true));
    ////$mpdf->useOddEven = 1;
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
    $mpdf->WriteHTML($stylesheet, 1);

    // $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> $periode, 'colspan'=>10),true));
    $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 15, 10, 10);
    $mpdf->WriteHTML($this->renderPartial($this->path_view . 'lahir/printSuratLahirV2', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modAdmisi' => $modAdmisi,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'modKelahiran' => $modKelahiran,
      'caraPrint' => $caraPrint
    ), true));
    $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
  }
}
