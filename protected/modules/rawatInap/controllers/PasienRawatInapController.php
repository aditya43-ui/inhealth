<?php

/**
 * digunakan untuk menyimpan fung - fungsi javascript unyuk tabulasi menu asesmen awal kebidanan
 * 
 * @package application.modules.rawatInap
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
class PasienRawatInapController extends MyAuthController
{
  /**
   * @return array action filters
   */
  public $path_view = 'rawatInap.views.pasienRawatInap.';


  public $ppdsTersimpan = true;

  public $successSave;
  public $successUpdateMasukKamar = false;
  public $successPasienPulang = false;
  public $successUpdatePendaftaran = false;
  public $successUpdatePasienAdmisi = false;
  public $successRujukanKeluar = true;
  public $successPaseinM = true;
  public $successSaveTindakanKomponen = true;
  public $successSaveTindakan;
  public $simpan_rencanakontrol;

  /**
   * action yang digunakan untuk mengakses menu informasi daftar pasien
   */
  public function actionIndex()
  {

    $this->pageTitle = Yii::app()->name . " - Pasien Rawat Inap";
    $format = new MyFormatter();
    $model = new RIInfopasienmasukkamarV;
    $model->tgl_awal  = date('Y-m-d', time() - (3600 * 24 * 30));
    //$model->tgl_awal  = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->tgl_awall = date('Y-m-d');
    $model->tgl_akhirl = date('Y-m-d');
    $model->ceklis = false;
    $model->is_nursestation = true;
    $model->is_global = false;

    if (Yii::app()->user->getState('unitkerja_id') == Params::UNITKERJA_ID_DOKTER) {
      //$model->pegawai_id = Yii::app()->user->getState('pegawai_id');
      // var_dump($model->dokterpenerima_id);die;
    }

    if (isset($_REQUEST['RIInfopasienmasukkamarV'])) {
      $model->attributes = $_REQUEST['RIInfopasienmasukkamarV'];
      $model->ceklis = $_REQUEST['RIInfopasienmasukkamarV']['ceklis'];
      $model->tgl_awal = isset($_REQUEST['RIInfopasienmasukkamarV']['tgl_awal']) ? $format->formatDateTimeForDb($_REQUEST['RIInfopasienmasukkamarV']['tgl_awal']) : '';
      $model->tgl_akhir = isset($_REQUEST['RIInfopasienmasukkamarV']['tgl_akhir']) ? $format->formatDateTimeForDb($_REQUEST['RIInfopasienmasukkamarV']['tgl_akhir']) : '';
      $model->tgl_awall  = $format->formatDateTimeForDb($_REQUEST['RIInfopasienmasukkamarV']['tgl_awall']);
      $model->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['RIInfopasienmasukkamarV']['tgl_akhirl']);
      $model->prefix_pendaftaran = isset($_REQUEST['RIInfopasienmasukkamarV']['prefix_pendaftaran']) ? $_REQUEST['RIInfopasienmasukkamarV']['prefix_pendaftaran'] : '';
      //$model->ceklis = $_REQUEST['RIInfopasienmasukkamarV']['ceklis'];
      $model->is_nursestation = isset($_REQUEST['RIInfopasienmasukkamarV']['is_nursestation']) ? $_REQUEST['RIInfopasienmasukkamarV']['is_nursestation'] : null;
      $model->is_global = isset($_REQUEST['RIInfopasienmasukkamarV']['is_global']) ? $_REQUEST['RIInfopasienmasukkamarV']['is_global'] : null;
      $model->statusperiksa = isset($_REQUEST['RIInfopasienmasukkamarV']['statusperiksa']) ? $_REQUEST['RIInfopasienmasukkamarV']['statusperiksa'] : null;

    }
    // untuk proses pencarian agar lebih memangkas waktu karena hanya merender tabel nya saja
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_GET['ajax']) && $_GET['ajax'] == 'daftarPasien-grid') {
        $this->renderPartial('_tablePasien', ['model' => $model]);
        Yii::app()->end();
      }
    }

    $this->render('index', array('model' => $model, 'format' => $format));
  }

  /**
   * fungsi terima dokumen
   */
  public function actionTerimaDokumen()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran = $_POST['pendaftaran_id'];
      $pengirimanrm_id = $_POST['pengirimanrm_id'];

      $model = PendaftaranT::model()->findByPk($pendaftaran);
      if (!empty($pengirimanrm_id)) {
        $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
        $modPenerimaanRm->tglterimadokrm = date('Y-m-d H:i:s');
        $modPenerimaanRm->petugaspenerima_id = Yii::app()->user->id;
        $modPenerimaanRm->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');

        if ($modPenerimaanRm->save()) {
          $model->statusdokrm = 'SUDAH DITERIMA';
          $model->save();

          $judul = 'Penerimaan Berkas Rekam Medis';

          $isi = $modPenerimaanRm->pasien->no_rekam_medik . ' - ' . $modPenerimaanRm->pasien->nama_pasien;


          CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $modPenerimaanRm->ruanganpengirim->instalasi->instalasi_id, 'ruangan_id' => $modPenerimaanRm->ruanganpengirim->ruangan_id, 'modul_id' => !empty($modPenerimaanRm->ruanganpengirim->modul_id) ? $modPenerimaanRm->ruanganpengirim->modul_id : null),
          ));

          $update = true;
        } else {
          $update = false;
        }
      }

      if ($update == true) {
        $status = 'proses_form';
        $div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil diterima </div>";
      } else {
        $status = 'proses_form';
        $div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal diterima </div>";
      }

      echo CJSON::encode(array(
        'status' => $status,
        'div' => $div,
      ));
      exit;
    }
  }




  public function actionCekRencanaPulang()
  {

    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $model = new RIInfopasienmasukkamarV;
    $model->unsetAttributes();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if (isset($_POST['RIInfopasienmasukkamarV'])) {
      $model->attributes = $_POST['RIInfopasienmasukkamarV'];
      $model->ceklis = $_POST['RIInfopasienmasukkamarV']['ceklis'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_POST['RIInfopasienmasukkamarV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_POST['RIInfopasienmasukkamarV']['tgl_akhir']);
      $model->tgl_awall = MyFormatter::formatDateTimeForDb($_POST['RIInfopasienmasukkamarV']['tgl_awall']);
      $model->tgl_akhirl = MyFormatter::formatDateTimeForDb($_POST['RIInfopasienmasukkamarV']['tgl_akhirl']);
      //  $model->rencanapulang = MyFormatter::formatDateTimeForDb($_POST['RIInfopasienmasukkamarV']['rencanapulang']);

      //   $model->prefix_pendaftaran = isset($_POST['RIInfopasienmasukkamarV']['prefix_pendaftaran']) ? $_POST['RIInfopasienmasukkamarV']['prefix_pendaftaran'] : null;
    }

    $prov = $model->searchRIInfo();
    $prov->pagination = false;


    $belum_ada = array();
    foreach ($prov->data as $item) {
      $respon = RIPasienAdmisiT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $item->pendaftaran_id,
        'pasienadmisi_id' => $item->pasienadmisi_id,
        'rencanapulang' => MyFormatter::formatDateTimeForDb($item->rencanapulang),
        'tglpulang' =>  MyFormatter::formatDateTimeForDb($item->tglpulang),

      ));
      if (empty($respon)) {
        $belum_ada[] = [
          'nama_pasien' => $item->namadepan . $item->nama_pasien,
          'no_rekam_medik' => $item->no_rekam_medik,
          'no_pendaftaran' => $item->no_pendaftaran,
          'tglpulang' =>  MyFormatter::formatDateTimeForDb($item->tglpulang),
          'rencanapulang' =>  MyFormatter::formatDateTimeForDb($item->rencanapulang),



        ];
        // $belum_ada[]['no_rekam_medik'] =$item->no_rekam_medik;
        // $belum_ada[]['no_pendaftaran'] =$item->no_pendaftaran;
      }
    }
    // var_dump($belum_ada);die;

    $total = count($belum_ada);
    $msg = "";
    if ($total > 0) {
      $msg = "<center><h1>INFORMASI PASIEN RENCANA PULANG</h1></center><br>";
      $msg .= "<center><h2>Segera selesaikan transaksi pada pasien rencana pulang rawat inap berikut :</h2></center>";

      $msg .= '<table border="1" width="100%" height="40%">';
      $msg .= '<thead>
                  <tr>
                      <th><center> No </center> </th>
                      <th><center> Nama Pasien </center> </th>
                      <th><center> No RM </center> </th>
                      <th><center> No Pendaftaran </center></th>
                      <th><center> Tgl Pulang </center></th>
                      <th><center> Rencana Pulang </center></th>
                      
                      
              </thead>
              <tbody>';
      foreach ($belum_ada as $idx => $item) {
        // var_dump($item);die;
        //   $msg .= "<table><thead><th>".($idx+1)."</th>.".$item."</table>\n";
        $msg .= '<tr>';
        $msg .= '<td><center>' . ((int)$idx + 1) . '</center></td>';
        $msg .= '<td><center>' . $item['nama_pasien'] . '</center></td>';
        $msg .= '<td><center>' . $item['no_rekam_medik'] . '</center></td>';
        $msg .= '<td><center>' . $item['no_pendaftaran'] . '</center></td>';
        $msg .= '<td><center>' . $item['tglpulang'] . '</center></td>';
        $msg .= '<td><center>' . $item['rencanapulang'] . '</center></td>';

        $msg .= '</tr>';
      }
      $msg .= '</tbody>';
      $msg .= '</table>';
    }




    //  $isi = $this->render('dialogInfo', array(
    //    'total' => $total,
    //    'respon' => $respon,
    //    'model' => $model,
    //    'msg' => $msg
    //  ));

    echo CJSON::encode(array(
      'total' => $total,
      'msg' => $msg,

    ));
  }


  public function actionSetKarcis()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $konfig = KonfigsystemK::model()->find();

      $format = new MyFormatter();
      $modTindakan = new PPTindakanPelayananT;
      $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
      $ruangan_id = $_POST['ruangan_id'];
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : "";
      $penjamin_id = $_POST['penjamin_id'];
      $form = '';

      $is_pasienbaru = 'true';
      if (!empty($ruangan_id)) {
        if (!empty($pasien_id)) {
          $modP = PendaftaranT::model()->findByAttributes(array(
            'pasien_id' => $pasien_id,
          ), array(
            'condition' => 'pasienbatalperiksa_id is null',
          ));
          $modPasien = PasienM::model()->findByPk($pasien_id);
          if (isset($modPasien)) {
            $is_pasienbaru = ($modPasien->statusrekammedis == Params::STATUSREKAMMEDIS_AKTIF && !empty($modP)) ? 'false' : 'true';
          }
        } else if (trim($no_rekam_medik) != "") {
          $is_pasienbaru = 'false';
        }

        $criteria = new CdbCriteria();
        $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        $criteria->addCondition("ruangan_id = " . $ruangan_id);
        $criteria->addCondition("penjamin_id = " . $penjamin_id);
        if (!empty($pasien_id)) {
          $is_pasien = 'false';
        } else if (empty($pasien_id)) {
          $is_pasien = 'true';
        }

        //if (Yii::app()->user->getState('karcisbarulama')) { //RND-7737
        $criteria->addCondition("pasienbaru_karcis = $is_pasien");
        //}
        $modKarcisAll = KarcisV::model()->findAll($criteria);


        $modKarcisV = KarcisV::model()->findAll($criteria);
        // echo "<pre>"; print_r($modKarcisV);die;
        // susun karcis global
        $modKarcisFinal = array();
        $modKarcisAda = array();
        foreach ($modKarcisAll as $item) {
          if (empty($modKarcisAda[$item->daftartindakan_id])) {
            $modKarcisAda[$item->daftartindakan_id] = 1;
            $modKarcisFinal[] = $item;
          }
        }


        // echo "<pre>";
        // print_r(count((array)$modKarcisFinal));
        // exit;
        $form = $this->renderPartial($this->path_view . '_formKarcis', array('modKarcisAll' => $modKarcisFinal, 'modKarcisV' => $modKarcisV, 'modTindakan' => $modTindakan, 'format' => $format, 'is_pasien' => $is_pasien), true);
        $data['listKarcis'] = $form;
        echo json_encode($data);
        Yii::app()->end();
      }
      $data['listKarcis'] = $form;
      echo json_encode($data);
      Yii::app()->end();
    }
  }


  public function actionKirimDokumen($pengirimanrm_id, $pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $status = false;
    if (!empty($pengirimanrm_id)) {
      $modPengirimanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
    } else {
      $modPengirimanRm = new PengirimanrmT();
    }

    $modUbahStatus = new PengirimanrmT;
    $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');

    if (isset($_POST['PengirimanrmT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modUbahStatus->attributes = $_POST['PengirimanrmT'];
        $modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
        $modUbahStatus->dokrekammedis_id = isset($modPengirimanRm) ? $modPengirimanRm->dokrekammedis_id : null;
        $modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
        $modUbahStatus->tglpengirimanrm = $format->formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
        $modUbahStatus->kelengkapandokumen = TRUE;
        $modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];
        $modUbahStatus->create_time = date('Y-m-d H:i:s');
        $modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
        $modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');

        if ($modUbahStatus->save()) {
          $modPendaftaran->statusdokrm = 'SUDAH DIKIRIM';
          $modPendaftaran->save();

          $transaction->commit();
          $status = true;
          Yii::app()->user->setFlash('success', "Data pengiriman dokumen pasien berhasil disimpan !");
        } else {
          $status = false;
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data pengiriman dokumen pasien gagal disimpan');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $status = false;
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
      }
    }

    $this->render('_formStatusDokumen', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPengirimanRm' => $modPengirimanRm,
      'modUbahStatus' => $modUbahStatus,
      'status' => $status
    ));
  }

  public function actionPrint($id = null)
  {
    //$this->layout='//layouts/iframe';

    //  $modPendaftaran = RJPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modRincian = RIRinciantagihanpasienriV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id'));


    $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    //            $modPendaftaran->tgl_admisi = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPendaftaran->tgl_admisi, 'yyyy-MM-dd hh:mm:ss'));
    //  $modRincian = RIRinciantagihanpasienriV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;

    $judulLaporan = 'Data Rincian';
    $caraPrint = $_REQUEST['caraPrint'];

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('rawatInap.views.pasienRawatInap/detailRincian', array(
        'modPendaftaran' => $modPendaftaran,
        'modRincian' => $modRincian,

        // 'modPasien'=>$modPasien, 
        'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('rawatInap.views.pasienRawatInap/detailRincian', array(
        'modPendaftaran' => $modPendaftaran,
        'modRincian' => $modRincian,
        //  'modPasien'=>$modPasien,
        'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('rawatInap.views.daftarPasien/detailRincian');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('pasienRawatInap/detailRincian', array(
        'modPendaftaran' => $modPendaftaran,  'modRincian' => $modRincian,

        // 'modPasien'=>$modPasien,
        'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ), true));
      $mpdf->Output();
    }
  }

  public function actionRincian($id)
  {
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Tagihan Pasien';
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    //            $modPendaftaran->tgl_admisi = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPendaftaran->tgl_admisi, 'yyyy-MM-dd hh:mm:ss'));
    $modRincian = RIRinciantagihanpasienriV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id'));
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    //            $modRincian->pendaftaran_id = $id;
    $this->render('rincian', array('modPendaftaran' => $modPendaftaran, 'modAdmisi' => $modAdmisi, 'modRincian' => $modRincian, 'data' => $data));
  }

  //        public function actionRincian($id){
  //            $this->layout = '//layouts/iframe';
  //            $data['judulLaporan'] = 'Rincian Tagihan Pasien';
  //            $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
  //            $modRincian = RJRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));
  //            $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
  ////            $modRincian->pendaftaran_id = $id;
  //            $this->render('/rinciantagihanpasienV.rincian', array('modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data));
  //        }

  public function actionTindakLanjutDariPasienRI($pendaftaran_id, $melarikandiri = 0, $meninggal = 0, $pasienadmisi_id = null)
  {
    $this->layout = '//layouts/iframe';
    $modKematian = new RISuratKeteranganR();
    $modelPulang = new RIPasienPulangT;
    $modRujukanKeluar = new RIPasienDirujukKeluarT;
    $modPendaftaran = RIPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modPasienRIV = RIInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    $modTariftindakan = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id' => $modPasienRIV->kelaspelayanan_id));
    $modMasukKamar = RIMasukKamarT::model()->findByPk($modPasienRIV->masukkamar_id);
    $modMasukKamarPertama = MasukkamarT::model()->findByAttributes(array(
      'pasienadmisi_id' => $admisi->pasienadmisi_id,
      // 'pindahkamar_id'=>null
    ), array(
      'order' => 'create_time asc',
    ));
    $modPasienKirimUnit = PasienkirimkeunitlainT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienmasukpenunjang_id' => null));
    $modelPulang->pendaftaran_id = $modPasienRIV->pendaftaran_id;
    $modelPulang->pasien_id = $modPasienRIV->pasien_id;
    $modelPulang->pasienadmisi_id = $modPasienRIV->pasienadmisi_id;
    $modelPulang->tglpasienpulang = empty($admisi->rencanapulang) ? date('Y-m-d H:i:s') : $admisi->rencanapulang;
    $modMasukKamar->tglkeluarkamar = date('Y-m-d', strtotime($modelPulang->tglpasienpulang));
    $modMasukKamar->jamkeluarkamar = date('H:i:s', strtotime($modelPulang->tglpasienpulang));
    $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
    $modRujukanKeluar->tgldirujuk = date('Y-m-d H:i:s');
    $tersimpan = 'Tidak';
    $modelPulang->keterangankeluar = null;

    if ($melarikandiri == 1) {
      $modelPulang->carakeluar_id = Params::CARAKELUAR_ID_MELARIKANDIRI;
    }

    if ($meninggal == 1) {
      $modelPulang->carakeluar_id = Params::CARAKELUAR_ID_MENINGGAL;
    }

    if(!empty($modPasienRIV->rencanacarakeluar_id)) {
        $modAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
        $modelPulang->carakeluar_nama = $modAdmisi->carakeluar->carakeluar_nama;
        $modelPulang->kondisikeluar_nama = $modAdmisi->kondisikeluar->kondisikeluar_nama;
        
        $modelPulang->carakeluar_id = $modPasienRIV->rencanacarakeluar_id;
        $modelPulang->kondisikeluar_id = $modPasienRIV->rencanakondisikeluar_id;
    }

    $cekPembayaran = (PasienpulangT::model()->cekSisaPembayaran($pendaftaran_id) == false) ? 'ada' : 'tidak';


    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
    $smspasien = 1;

    $format = new MyFormatter();
    //Hitung lama rawat                
    $modMasukKamar->tglmasukkamar = $format->formatDateTimeForDb($modMasukKamar->tglmasukkamar);

    $admisi->tgladmisi = $format->formatDateTimeForDb($admisi->tgladmisi);

    // $selisihHari = CustomFunction::hitungHari(date('Y-m-d', strtotime($modMasukKamarPertama->tglmasukkamar)), $modelPulang->tglpasienpulang);
    $selisihHari = CustomFunction::hitungHari(date('Y-m-d', strtotime($admisi->tgladmisi)), $modelPulang->tglpasienpulang);

    //Hitung hari rawat
    // $selisihHariRawat = CustomFunction::hitungHariRawat(date('Y-m-d', strtotime($modMasukKamarPertama->tglmasukkamar)), $modelPulang->tglpasienpulang);
    $selisihHariRawat = CustomFunction::hitungHariRawat(date('Y-m-d', strtotime($admisi->tgladmisi)), $modelPulang->tglpasienpulang);

    $modMasukKamar->lamadirawat_kamar = $selisihHari;
    $modelPulang->hariperawatan = $selisihHariRawat;

    $pen = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modUbahStatus = new PengirimanrmT;
    $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');
    $modUbahStatus->petugaspengirim = Yii::app()->user->name;
    $modUbahStatus->petugaspengirim_id = Yii::app()->user->getState('pegawai_id');
    $modUbahStatus->ruangan_id = Params::RUANGAN_ID_REKAM_MEDIS;
    $modUbahStatus->instalasi_id = Params::INSTALASI_ID_RM;
    //if ($_POST["RDPasienPulangT"]['carakeluar_id'] != Params::CARAKELUAR_ID_RAWATINAP){
    if (!empty($pen->pengirimanrm_id)) {
      if (Yii::app()->user->getState('ruangan_id') == $pen->pengirimanrm->ruanganpenerima_id) {
        if (empty($pen->pengirimanrm->tglterimadokrm)) {
          $modUbahStatus->statusdokrm = 'belum-diterima';
        } else {
          $modUbahStatus->statusdokrm = 'belum-dikembalikan';
        }
      }
    }

    if(!empty($pen)) {
      // untuk form surat kematian pasien
      $modKematian = new RISuratKeteranganR();
      $modKematian->pendaftaran_id = $pendaftaran_id;
      $modKematian->pasien_id = $pen->pasien_id;
      $modKematian->nourutsurat = $modKematian->getNoUrut();
      $modKematian->nomorsurat = $modKematian->getNoSuratKematian(Yii::app()->user->getState('ruangan_id'));
      $modKematian->tglsurat = date('d M Y H:i:s');
      $modKematian->judulsurat = 'SURAT KETERANGAN KEMATIAN';
      $modKematian->jmlprint_surat = 1;
      $modKematian->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modKematian->profilrs_id = Params::getDefaultProfilRS();
      $modKematian->jenissurat_id = Params::SURAT_KETERANGAN_KEMATIAN;
    }
    //}else{
    //	$modUbahStatus->statusdokrm = '';
    //}		 


    //                if(empty($modPasienRIV->kamarruangan_nokamar)){ 
    ////                    echo "kamarruangan tidak  ada";
    ////                              myAlert('Silakan Isi No. Kamar Terlebih Dahulu');
    //                    echo "<script>
    //                                window.top.location.href='".Yii::app()->createUrl('rawatInap/PasienRawatInap/index')."';
    //                            </script>";
    //                }else{
    ////                    echo "kamarruangan ada";
    //                }
    $modRenKontrol = new RIRencanakontrolR;
    $modRenKontrol->rencanapulang_tgl = $admisi->rencanapulang;
    $modRenKontrol->rencanakontrol_tgl = date('Y-m-d H:i:s', strtotime($modPendaftaran->tglrenkontrol));
    $modRenKontrol->polikontrol_id = $modPendaftaran->ruangankontrol_id;


    if (isset($_POST['RIPasienPulangT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modMasukKamar = RIMasukKamarT::model()->findByPk($_POST['RIMasukKamarT']['masukkamar_id']);
        $this->updateMasukKamar($modMasukKamar, $_POST['RIMasukKamarT']);
        if (!isset($modTariftindakan->harga_tariftindakan)) {
          throw new CException("Maaf, Harga Tarif Kamar Rawat Inap Belum Ada. Silakan Hubungi Bagian Administrasi");
        } else {
          $modelPulang = $this->savePasienPulang($modMasukKamar, $modelPulang, $_POST['RIPasienPulangT'], $_POST['RIPasienPulangT']['pasienadmisi_id']);
        }


        $modPendaftaran = RIPendaftaranT::model()->findByPk($modelPulang->pendaftaran_id);
        $this->updatePendaftaran($modPendaftaran, $modelPulang);

        $modPasienAdmisi = RIPasienAdmisiT::model()->findByPk($modelPulang->pasienadmisi_id);
        $this->updatePasienAdmisi($modPasienAdmisi, $modelPulang);


        // if ($this->checkBayarLunasRI($modPendaftaran) && );

        if (isset($_POST['pakeRujukan']) && $_POST['pakeRujukan'] == '1') //Jika Pake Rujukan
        {
          //var_dump($_POST['pakeRujukan']);die;
          $this->successRujukanKeluar = false;
          $modelPulang->pakeRujukan = true;
          $modRujukanKeluar = $this->saveRujukanKeluar($modRujukanKeluar, $modelPulang, $_POST['RIPasienDirujukKeluarT']);
        }


        //var_dump($modRujukanKeluar->getErrors());die;
        if ((isset($_POST['isDead']) && $_POST['isDead'] == '1') || $modelPulang->carakeluar_id == Params::CARAKELUAR_ID_MENINGGAL) //Jika Pasien Meninggal
        {
          $modelPulang->isDead;
          $this->successPaseinM = false;
          $modPasien = RIPasienM::model()->findByPk($modelPulang->pasien_id);
          $modPasien->tgl_meninggal = $format->formatDateTimeForDb($_POST['RIPasienPulangT']['tgl_meninggal']);

          if ($modPasien->update()) {
            $this->successPaseinM = true;
          } else {
            $this->successPaseinM = false;
          }
          // echo '<pre>';var_dump($this->successPaseinM, $modPasien->getErrors());die;
        }

        $this->updateSEPPulang($modPendaftaran, $modelPulang);
        // fungsi simpan rencana kontrol start
        if (isset($_POST['RIRencanakontrolR'])) {
          $this->saveRencanaKontrol($modRenKontrol, $modelPulang, $_POST['RIRencanakontrolR']);
        }
        // end
        // echo '<pre>';var_dump($this->successUpdateMasukKamar ,$this->successPasienPulang
        // ,$this->successUpdatePendaftaran ,$this->successUpdatePasienAdmisi
        // ,$this->successRujukanKeluar ,$this->successPaseinM);die;
        if (
          $this->successUpdateMasukKamar && $this->successPasienPulang
          && $this->successUpdatePendaftaran && $this->successUpdatePasienAdmisi
          && $this->successRujukanKeluar && $this->successPaseinM
        ) {
          // SMS GATEWAY
          $modPasien = $modPendaftaran->pasien;
          $modCaraKeluar = $modelPulang->carakeluar;
          $modKondisiKeluar = $modelPulang->kondisikeluar;

          if(isset($_POST['Diagnosa'])) {

              foreach ($_POST['Diagnosa'] as $ii => $data) {
                  $insert = new MortalitasR();
                  $insert->tanggal = date('Y-m-d H:i:s');
                  $insert->diagnosa_id = $data['diagnosa_id'];
                  $insert->diagnosa_nama = $data['diagnosa_nama'];
                  $insert->jumlah = 1;
                  $insert->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                  $insert->created_by = Yii::app()->user->getState('loginpemakai_id');
                  $insert->created_time = date('Y-m-d H:i:s');
                  $insert->ruangan_id = Yii::app()->user->getState('ruangan_id');
                  $insert->pegawai_id = Yii::app()->user->getState('pegawai_id');
                  if ($insert->save()) {
                      $modelPulang->isDead = true;
                  }
              }
              // echo '<pre>';var_dump($insert->save(), $insert->getErrors());
          }

          if(isset($_POST['RISuratKeteranganR'])) {
            //save surat kematian
            if(isset($_POST['RISuratKeteranganR'])) {
              $modKematian->attributes = $_POST['RISuratKeteranganR'];
              $modKematian->penyebabkematian = $_POST['RISuratKeteranganR']['penyebabkematian'];
              $modKematian->jenissurat_id = Params::SURAT_KETERANGAN_KEMATIAN;
              if ($modKematian->validate()) {
                  $modKematian->save();
              }
            }
          }

          /*
					$sms = new Sms();
					foreach ($modSmsgateway as $i => $smsgateway) {
						$isiPesan = $smsgateway->templatesms;

						$attributes = $modPasien->getAttributes();
						foreach($attributes as $attributes => $value){
							$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
						}
						$attributes = $modCaraKeluar->getAttributes();
						foreach($attributes as $attributes => $value){
							$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
						}
						$attributes = $modKondisiKeluar->getAttributes();
						foreach($attributes as $attributes => $value){
							$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
						}
						$attributes = $modelPulang->getAttributes();
						foreach($attributes as $attributes => $value){
							$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
						}
						$isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modelPulang->tglpasienpulang),$isiPesan);

						if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
							if(!empty($modPasien->no_mobile_pasien)){
								$sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
							}else{
								$smspasien = 0;
							}
						}
					}
					 * 
					 */
          // END SMS GATEWAY
          // die;
          /** AWAL - Notifikasi Pasien Pulang */

          $rgizi = RuanganM::model()->findAll(" ruangan_aktif = TRUE AND instalasi_id = " . Params::INSTALASI_ID_GIZI);
          $arrgizi = [];
          if (!empty($rgizi)) {
            foreach ($rgizi as $key => $val) {
              $arrgizi[] = [
                'instalasi_id' => $val->instalasi_id,
                'ruangan_id' => $val->ruangan_id,
                'modul_id' => $val->modul_id
              ];
            }
          }
          if (!empty($_POST['RIPendaftaranT']['ruangankontrol_id'])) {
            $r = RuanganM::model()->findByPk($_POST['RIPendaftaranT']['ruangankontrol_id']);

            $judul = 'Pasien Rencana Kontrol';
            //$isi =  'Pasien '.$modPasien->nama_pasien. ' dengan nomor rekam medik '.$modPasien->no_rekam_medik.'<br/> telah membuat rencana kontrol untuk tanggal '.MyFormatter::formatDateTimeForUser($_POST['RIPendaftaranT']['tglrenkontrol']).
            //      ' ke ruangan '.$r->ruangan_nama;
            $isi = $modPasien->no_rekam_medik . ' ' . $modPasien->namadepan . ' ' . $modPasien->nama_pasien . ' '
              .  MyFormatter::formatDateTimeForUser($_POST['RIPendaftaranT']['tglrenkontrol']) . ' ' . $r->ruangan_nama . ' ';

            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
              array('instalasi_id' => Params::INSTALASI_ID_RJ, 'ruangan_id' => $_POST['RIPendaftaranT']['ruangankontrol_id'], 'modul_id' => Params::MODUL_ID_RJ),
              array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
            ));
            // var_dump(5, $ok);
          }

          if ($modelPulang->carakeluar_id == Params::CARAKELUAR_ID_MENINGGAL) {
            $this->notifPasienMeninggal($modPasien, $modelPulang, $arrgizi);
          }

          if ($modelPulang->carakeluar_id != Params::CARAKELUAR_ID_DIRUJUK) {
            if ($modelPulang->carakeluar_id == Params::CARAKELUAR_ID_DIPULANGKAN) {
              $judul = 'Pasien Pulang';
            } else {
              $judul = 'Pasien ' . $modCaraKeluar->carakeluar_nama;
            }
            $isi = $modPasien->no_rekam_medik . ' ' . $modPasien->namadepan . ' ' . $modPasien->nama_pasien . ' '
              .  'Pasien ' . strtoupper($modCaraKeluar->carakeluar_nama) . ' dengan kondisi ' . $modKondisiKeluar->kondisikeluar_nama . ' '
              . MyFormatter::formatDateTimeForUser($modelPulang->tglpasienpulang) . ' ' . $modMasukKamar->kamarruangan->kamarruangan_nokamar . ' ' . $modMasukKamar->kamarruangan->kamarruangan_nobed;
            $ok = true;
            if ($modelPulang->carakeluar_id == Params::CARAKELUAR_ID_DIPULANGKAN) {
              $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK),
              ));
            }
            // var_dump(2, $ok);

            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
              //array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),							
              array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
              array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'modul_id' => Yii::app()->session['modul_id']),
            ));

            if (!empty($arrgizi)) {
              $ok = CustomFunction::broadcastNotif($judul, $isi, $arrgizi);
            }
          } else {
            $judul = 'Pasien Dirujuk';
            //var_dump($modRujukanKeluar->attributes);die;
            $isi = $modPasien->no_rekam_medik . ' ' . $modPasien->namadepan . ' ' . $modPasien->nama_pasien . ' '
              .  'Pasien ' . strtoupper($modCaraKeluar->carakeluar_nama) . ' dengan kondisi ' . $modKondisiKeluar->kondisikeluar_nama //.' ke '.$modRujukanKeluar->rujukankeluar->rumahsakitrujukan.' '
              . MyFormatter::formatDateTimeForUser($modelPulang->tglpasienpulang) . ' ' . $modMasukKamar->kamarruangan->kamarruangan_nokamar . ' ' . $modMasukKamar->kamarruangan->kamarruangan_nobed;
            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
              //array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),							
              array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
              array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'modul_id' => Yii::app()->session['modul_id']),
            ));
            // var_dump(2, $ok);
          }

          if (isset($_POST['PengirimanrmT']) && $melarikandiri != 1 && $meninggal != 1) {
            $ok = $ok && $this->simpanPengirimanDokRM($modPendaftaran, $_POST['PengirimanrmT'], $modPasien->dokrekammedis_id);
          }

          /** AKHIR - Notifikasi Pasien Pulang */

          // var_dump(3, $ok); die;

          if (isset($_POST['is_whatsapp']) && $_POST['is_whatsapp'] = "Ya") {
            $this->kirimWhatsapp($modelPulang);
            //                        echo "Kick";
          }
          //            die;

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $tersimpan = 'Ya';
        } else {
          if ($this->successUpdateMasukKamar == false) {
            Yii::app()->user->setFlash('error', "Data Masuk Kamar gagal disimpan");
          } else if ($this->successPasienPulang == false) {
            Yii::app()->user->setFlash('error', "Data Pasien Pulang gagal disimpan");
          } else if ($this->successUpdatePendaftaran == false) {
            Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan");
          } else if ($this->successUpdatePasienAdmisi == false) {
            Yii::app()->user->setFlash('error', "Data Pasien Admisi gagal disimpan");
          } else if ($this->successRujukanKeluar == false) {
            Yii::app()->user->setFlash('error', "Data Rujukan Keluar gagal disimpan");
          } else if ($this->successPaseinM == false) {
            Yii::app()->user->setFlash('error', "Data Pasien disimpan");
          }
        }
      } catch (CException $cexc) {
        $transaction->rollback();
        if (YII_DEBUG == true)
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($cexc, true, true));
        else
          Yii::app()->user->setFlash('error', "Data gagal disimpan. " . $cexc->getMessage());
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modMasukKamar->tglmasukkamar = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modMasukKamar->tglmasukkamar, 'yyyy-MM-dd hh:mm:ss')
    );
    $modMasukKamar->tglkeluarkamar = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modMasukKamar->tglkeluarkamar, 'yyyy-MM-dd'),
      'medium',
      false
    );
    $modelPulang->tglpasienpulang = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modelPulang->tglpasienpulang, 'yyyy-MM-dd hh:mm:ss')
    );
    $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss')
    );
    if (!empty($modPendaftaran->pegawai_id)) {
      $modRujukanKeluar->pegawai_id = $modPendaftaran->pegawai_id;
      $modRujukanKeluar->ruanganasal_id = $modMasukKamar->ruangan_id;
    }

    $this->render('formTindakLanjutDariPasienRI', array(
      'modelPulang' => $modelPulang,
      'modRujukanKeluar' => $modRujukanKeluar,
      'modPasienRIV' => $modPasienRIV,
      'modMasukKamar' => $modMasukKamar,
      'modTariftindakan' => $modTariftindakan,
      'tersimpan' => $tersimpan,
      'smspasien' => $smspasien,
      'modPendaftaran' => $modPendaftaran,
      'modUbahStatus' => $modUbahStatus,
      'cekPembayaran' => $cekPembayaran,
      'modRenKontrol' => $modRenKontrol,
      'admisi' => $admisi,
      'modKematian' => $modKematian
    ));
  }

  function actionAddRowDiagnosa() {
      $jumlahtr = $_POST['jumlahtr'];
      $diagnosa_id = $_POST['diagnosa_id'];
      $diagnosa_kode = $_POST['diagnosa_kode'];
      $diagnosa_nama = $_POST['diagnosa_nama'];
      $diagnosa_namalainnya = $_POST['diagnosa_namalainnya'];

      $data['html'] = $this->renderPartial($this->path_view . 'diagnosaMeninggal/_rowDiagnosa', [
          'jumlahtr' => $jumlahtr,
          'diagnosa_id' => $diagnosa_id,
          'diagnosa_nama' => $diagnosa_nama,
          'diagnosa_kode' => $diagnosa_kode,
          'diagnosa_namalainnya' => $diagnosa_namalainnya
      ], true);

      echo json_encode($data);

  }

  function kirimWhatsapp($modelPulang)
  {

    $profil = ProfilrumahsakitM::model()->find();

    $admisi = PasienadmisiT::model()->findByPk($modelPulang->pasienadmisi_id);
    $kamar = $admisi->kamarruangan;
    $pasien = $admisi->pasien;

    $str = "((Nama Pasien)) dengan no RM ((RM Pasien)) Kamar ((Kamar dan bed)) pada hari ini anda dijadwalkan untuk pulang, pastikan tidak ada barang yang tertinggal. 
        Anda akan mendapatkan Surat Keterangan Pulang sebagai bukti bahwa Anda telah menyelesaikan masa perawatan di ((nama_rs_short)).
        \n
        Terimakasih - Salam Sehat dan Tetap jaga 3M\n((nama_rs))";



    $str = str_replace("((Nama Pasien))", $pasien->namadepan . $pasien->nama_pasien, $str);
    $str = str_replace("((RM Pasien))", $pasien->no_rekam_medik, $str);
    $str = str_replace("((Kamar dan bed))", empty($kamar) ? "-" : ($kamar->kamarruangan_nokamar . " - " . $kamar->kamarruangan_nobed), $str);
    $str = str_replace("((nama_rs))", ucwords(strtolower((Yii::app()->user->getState('nama_rumahsakit')))) . " - " . Yii::app()->user->getState('kabupaten_nama'), $str);
    $str = str_replace("((nama_rs_short))", ucwords(strtolower((Yii::app()->user->getState('nama_rumahsakit')))), $str);

    // var_dump($str);die;
    // echo "<pre>";
    // print_r($str);die;
    //        var_dump($pasien->no_mobile_pasien, $str); die;

    $wa = new WhatsApp();
    $wa->kirimIndividu($pasien->no_mobile_pasien, $str);
    //        var_dump($wa->kirimIndividu("085606615990", $str));
    //        die;
  }

  public function notifPasienMeninggal($modPasien, $modelPulang, $arrgizi = [])
  {

    $modCaraKeluar = CarakeluarM::model()->findByPk($modelPulang->carakeluar_id);
    $modKondisiKeluar = KondisiKeluarM::model()->findByPk($modelPulang->kondisikeluar_id);

    $judul = "Pasien Meninggal";

    $isi = $modPasien->no_rekam_medik . ' ' . $modPasien->namadepan . $modPasien->nama_pasien . ' '
      .  'Pasien ' . strtoupper($modCaraKeluar->carakeluar_nama) . ' dengan kondisi ' . $modKondisiKeluar->kondisikeluar_nama . ' pada tanggal '
      . MyFormatter::formatDateTimeForUser($modPasien->tgl_meninggal);

    if (!empty($arrgizi)) {
      $ok = CustomFunction::broadcastNotif($judul, $isi, $arrgizi);
    }

    return CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => Params::INSTALASI_ID_JZ, 'ruangan_id' => Params::RUANGAN_ID_FORENSIC, 'modul_id' => Params::MODUL_ID_JENAZAH),
    ));
  }

  public function checkBayarLunasRI($modPendaftaran)
  {
    $tindakan = TindakanpelayananT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
    ), array(
      'condition' => 'tindakansudahbayar_id is null'
    ));
    $oa = ObatalkespasienT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
    ), array(
      'condition' => 'oasudahbayar_id is null'
    ));

    return (!empty($tindakan) || !empty($oa));
  }

  public function updateSEPPulang($modPendaftaran, $modelPulang)
  {
    $bpjs = new Bpjs;
    $sep = SepT::model()->findByPk($modPendaftaran->sep_id);

    if (empty($sep)) return false;

    $noSep = $sep->nosep;
    $ppk = substr($noSep, 0, 8);
    $tglPulang = $modelPulang->tglpasienpulang;

    // var_dump(json_decode($bpjs->update_tanggal_pulang_sep($noSep, $tglPulang, $ppk)));

    // var_dump($noSep, $ppk, $tglPulang, $modelPulang->attributes);
    // var_dump($modPendaftaran->attributes);
  }

  public function actionTindakLanjutDrTransaksi($id = null)
  {
    $modelPulang = new RIPasienPulangT;
    $modRujukanKeluar = new RIPasienDirujukKeluarT;
    // $modPasienRIV = new RIPasienRawatInapV;
    //$modInfoPasien = new RIInfopasienmasukkamarV;
    $modPasienRIV = new RIInfopasienmasukkamarV;
    $modMasukKamar = new RIMasukKamarT;
    $modelPulang->keterangankeluar = null;
    $modMasukKamar->tglkeluarkamar = date('Y-m-d');
    $modMasukKamar->jamkeluarkamar = date('H:i:s');
    $modelPulang->tglpasienpulang = date('Y-m-d H:i:s');
    $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
    $tersimpan = 'Tidak';
    $modPendaftaran = new RIPendaftaranT;

    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);


    $modUbahStatus = new PengirimanrmT;
    $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');
    $modUbahStatus->petugaspengirim = Yii::app()->user->name;
    $modUbahStatus->petugaspengirim_id = Yii::app()->user->getState('pegawai_id');
    $modUbahStatus->ruangan_id = Params::RUANGAN_ID_REKAM_MEDIS;
    $modUbahStatus->instalasi_id = Params::INSTALASI_ID_RM;

    $modRenKontrol = new RIRencanakontrolR;

    $modPasienRIV->unsetAttributes();
    if (isset($_GET['RIInfopasienmasukkamarV'])) {
      $modPasienRIV->attributes = $_GET['RIInfopasienmasukkamarV'];
    }

    if (!empty($id)) {
      $modelPulang = RIPasienPulangT::model()->findByPk($id);
      $modMasukKamar = RIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id' => $modelPulang->pasienadmisi_id));
    }



    if (isset($_POST['RIPasienPulangT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modMasukKamar = RIMasukKamarT::model()->findByPk($_POST['RIMasukKamarT']['masukkamar_id']);
        $this->updateMasukKamar($modMasukKamar, $_POST['RIMasukKamarT']);

        $modelPulang = $this->savePasienPulang(
          $modMasukKamar,
          $modelPulang,
          $_POST['RIPasienPulangT'],
          $_POST['RIPasienPulangT']['pasienadmisi_id']
        );

        $modPendaftaran = RIPendaftaranT::model()->findByPk($modelPulang->pendaftaran_id);
        $this->updatePendaftaran($modPendaftaran, $modelPulang);

        $modPasienAdmisi = RIPasienAdmisiT::model()->findByPk($modelPulang->pasienadmisi_id);
        $this->updatePasienAdmisi($modPasienAdmisi, $modelPulang);


        if (isset($_POST['pakeRujukan']) && $_POST['pakeRujukan'] == '1') //Jika Pake Rujukan
        {
          $this->successRujukanKeluar = false;
          $modelPulang->pakeRujukan = true;
          $modRujukanKeluar = $this->saveRujukanKeluar($modRujukanKeluar, $modelPulang, $_POST['RIPasienDirujukKeluarT']);
        }

        if (isset($_POST['isDead']) && $_POST['isDead'] == '1') //Jika Pasien Meninggal
        {
          $modelPulang->isDead;
          $this->successPaseinM = false;
          $modPasien = RIPasienM::model()->findByPk($modelPulang->pasien_id);
          $modPasien->tgl_meninggal = $modelPulang->tgl_meninggal;
          if ($modPasien->save()) {
            $this->successPaseinM = true;
          } else {
            $this->successPaseinM = false;
          }
        }
        $this->updateSEPPulang($modPendaftaran, $modelPulang);


        if ($modelPulang->carakeluar_id == Params::CARAKELUAR_ID_MENINGGAL) {
          $this->notifPasienMeninggal($modPasien, $modelPulang);
        }

        if (
          $this->successUpdateMasukKamar && $this->successPasienPulang
          && $this->successUpdatePendaftaran && $this->successUpdatePasienAdmisi
          && $this->successRujukanKeluar
        ) {

          // SMS GATEWAY
          $modPasien = $modPendaftaran->pasien;
          $modCaraKeluar = $modelPulang->carakeluar;
          $modKondisiKeluar = $modelPulang->kondisikeluar;
          $sms = new Sms();
          $smspasien = 1;
          /*
          foreach ($modSmsgateway as $i => $smsgateway) {
              $isiPesan = $smsgateway->templatesms;

              $attributes = $modPasien->getAttributes();
              foreach($attributes as $attributes => $value){
                  $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
              }
              $attributes = $modCaraKeluar->getAttributes();
              foreach($attributes as $attributes => $value){
                  $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
              }
              $attributes = $modKondisiKeluar->getAttributes();
              foreach($attributes as $attributes => $value){
                  $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
              }
              $attributes = $modelPulang->getAttributes();
              foreach($attributes as $attributes => $value){
                  $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
              }
              $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modelPulang->tglpasienpulang),$isiPesan);
              
              if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                  if(!empty($modPasien->no_mobile_pasien)){
                      $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                  }else{
                      $smspasien = 0;
                  }
              }
          }
           * 
           */
          // END SMS GATEWAY

          $transaction->commit();
          $tersimpan = 'Ya';
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('TindakLanjutDrTransaksi', 'id' => $modelPulang->pasienpulang_id, 'sukses' => $tersimpan, 'smspasien' => $smspasien));
        } else {
          if ($this->successUpdateMasukKamar == false) {
            Yii::app()->user->setFlash('error', "Data Masuk Kamar gagal disimpan");
          } else if ($this->successPasienPulang == false) {
            Yii::app()->user->setFlash('error', "Data Pasien Pulang gagal disimpan");
          } else if ($this->successUpdatePendaftaran == false) {
            Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan");
          } else if ($this->successUpdatePasienAdmisi == false) {
            Yii::app()->user->setFlash('error', "Data Pasien Admisi gagal disimpan");
          } else if ($this->successRujukanKeluar == false) {
            Yii::app()->user->setFlash('error', "Data Rujukan Keluar gagal disimpan");
          } else if ($this->successPaseinM == false) {
            Yii::app()->user->setFlash('error', "Data Pasien disimpan");
          }
        }
      } catch (CException $cexc) {
        $transaction->rollback();
        if (YII_DEBUG == true)
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($cexc, true));
        else
          Yii::app()->user->setFlash('error', "Data gagal disimpan. " . $cexc->getMessage());
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }


    $modMasukKamar->tglmasukkamar = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modMasukKamar->tglmasukkamar, 'yyyy-MM-dd hh:mm:ss')
    );
    $modMasukKamar->tglkeluarkamar = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modMasukKamar->tglkeluarkamar, 'yyyy-MM-dd'),
      'medium',
      false
    );
    $modelPulang->tglpasienpulang = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modelPulang->tglpasienpulang, 'yyyy-MM-dd hh:mm:ss')
    );
    $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss')
    );
    $this->render('formTindakLanjutDariPasienRI', array(
      'modelPulang' => $modelPulang,
      'modRujukanKeluar' => $modRujukanKeluar,
      'modPasienRIV' => $modPasienRIV,
      'modMasukKamar' => $modMasukKamar,
      'tersimpan' => $tersimpan,
      'modUbahStatus' => $modUbahStatus,
      'modRenKontrol' => $modRenKontrol,
      'modPendaftaran' => $modPendaftaran
    ));
  }

  protected function saveRujukanKeluar($modRujukanKeluar, $modelPulang, $attrRujukanKeluar)
  {
    $format = new MyFormatter();
    $modRujukanKeluarNew = new RIPasienDirujukKeluarT;
    $modRujukanKeluarNew->attributes = $attrRujukanKeluar;
    $modRujukanKeluarNew->tgldirujuk = $format->formatDateTimeForDb(trim($attrRujukanKeluar['tgldirujuk']));
    $modRujukanKeluarNew->pendaftaran_id = $modelPulang->pendaftaran_id;
    $modRujukanKeluarNew->pasien_id = $modelPulang->pasien_id;
    $modRujukanKeluarNew->create_time = date('Y-m-d H:i:s');
    $modRujukanKeluarNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modRujukanKeluarNew->create_loginpemakai_id = Yii::app()->user->id;
    $modRujukanKeluarNew->tglberlakusurat = $modRujukanKeluarNew->tgldirujuk;
    $modRujukanKeluarNew->sampaidengan = $modRujukanKeluarNew->tgldirujuk;
    if ($modRujukanKeluarNew->save()) {
      $this->successRujukanKeluar = true;
    } else {
      $this->successRujukanKeluar = false;
    }
    return $modRujukanKeluarNew;
  }

  protected function updateMasukKamar($modMasukKamar, $attrMasukKamar)
  {
    $format = new MyFormatter();
    $modMasukKamar->attributes = $attrMasukKamar;
    $modMasukKamar->tglmasukkamar = $format->formatDateTimeForDb(trim($attrMasukKamar['tglmasukkamar']));
    $modMasukKamar->tglkeluarkamar  = $format->formatDateTimeForDb(trim($attrMasukKamar['tglkeluarkamar']) . ' ' . $attrMasukKamar['jamkeluarkamar']);
    if ($modMasukKamar->save()) {
      $this->successUpdateMasukKamar = true;
    } else {
      $this->successUpdateMasukKamar = false;
    }
  }

  protected function updatePendaftaran($modPendaftaran, $modelPulang)
  {
    if (isset($_POST['RIPendaftaranT']['tglrenkontrol']) && $_POST['RIPendaftaranT']['tglrenkontrol'] != null) {
      $format = new MyFormatter();
      $tglrenkontrol = $format->formatDateTimeForDb($_POST['RIPendaftaranT']['tglrenkontrol']);
      $kontrolruangan = $_POST['RIPendaftaranT']['ruangankontrol_id'];
    } else {
      $tglrenkontrol = null;
      $kontrolruangan = null;
    }

    $daftar = PendaftaranT::model()->updateByPk(
      $modelPulang->pendaftaran_id,
      array(
        'tglselesaiperiksa' => date('Y-m-d H:i:s'),
        'pasienpulang_id' => $modelPulang->pasienpulang_id,
        //'tglrenkontrol'=>$tglrenkontrol,
        'statusperiksa' => Params::STATUSPERIKSA_SUDAH_PULANG,
        // 'ruangankontrol_id'=>$kontrolruangan,
      )
    );

    if (!empty($kontrolruangan)) {
      $this->simpanSKKontrol($modPendaftaran, $kontrolruangan);
    }

    //            $modPendaftaran->tglselesaiperiksa = date( 'Y-m-d H:i:s');
    //            $modPendaftaran->pasienpulang_id = $modelPulang->pasienpulang_id;
    if ($daftar) {
      $this->successUpdatePendaftaran = true;
      return $modPendaftaran;
    } else {
      $this->successUpdatePendaftaran = false;
    }
  }

  protected function updatePasienAdmisi($modPasienAdmisi, $modelPulang)
  {
    $modPasienAdmisi->pasienpulang_id = $modelPulang->pasienpulang_id;
    $modPasienAdmisi->tglpulang = $modelPulang->tglpasienpulang;
    $admisi = PasienadmisiT::model()->updateByPk($modPasienAdmisi->pasienadmisi_id, array("tglpulang" => $modPasienAdmisi->tglpulang, "pasienpulang_id" => $modPasienAdmisi->pasienpulang_id));
    if ($admisi) {
      $this->successUpdatePasienAdmisi = true;
    } else {
      $this->successUpdatePasienAdmisi = false;
    }

    return $modPasienAdmisi;
  }

  protected function simpanSKKontrol($modPendaftaran, $kontrolruangan)
  {
    $admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

    $sk = new SuratketeranganR();
    $sk->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $sk->jenissurat_id = Params::SURAT_KETERANGAN_KONTROL;
    $sk->pasien_id = $modPendaftaran->pasien_id;
    $sk->ruangan_id = $kontrolruangan;
    $sk->profilrs_id = Yii::app()->user->getState('profilrs_id');
    $sk->tglsurat = date('Y-m-d');
    $sk->judulsurat = "SURAT RENCANA KONTROL PASIEN";
    $sk->nourutsurat = 1;
    $sk->nomorsurat = MyGenerator::noSurat(Params::SURAT_KETERANGAN_KONTROL);
    $sk->mengetahui_surat = $admisi->pegawai->namaLengkap;

    $sk->save();
  }


  public function actionRiwayatPelayanan($pendaftaran_id)
  {

    $this->layout = '//layouts/iframe';
    $sukses = 'tidak';
    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPengirim = PengirimanrmT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    $modFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));

    //var_dump($modFisik); die;

    $this->render('_riwayatPelayanan', array('modPengirim' => $modPengirim, 'modFisik' => $modFisik, 'modPendaftaran' => $modPendaftaran));
  }


  protected function savePasienPulang($modMasukKamar, $modPasienPulang, $attrPasienPulang, $pasienadmisi_id = '')
  {
    $format = new MyFormatter();
    $modelPulangNew = new RIPasienPulangT;
    $modelPulangNew->attributes = $attrPasienPulang;
    $modelPulangNew->carakeluar_id = $attrPasienPulang['carakeluar_id'];
    $modelPulangNew->kondisikeluar_id = $attrPasienPulang['kondisikeluar_id'];
    $modelPulangNew->tglpasienpulang = $format->formatDateTimeForDb(trim($attrPasienPulang['tglpasienpulang']));
    $modelPulangNew->tgl_meninggal = (isset($attrPasienPulang['tgl_meninggal']) ? $format->formatDateTimeForDb(trim($attrPasienPulang['tgl_meninggal'])) : null);
    $modelPulangNew->lamarawat = $modMasukKamar->lamadirawat_kamar;
    $modelPulangNew->satuanlamarawat = Params::SATUAN_LAMARAWAT_RI;
    $modelPulangNew->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
    $modelPulangNew->create_time = date('Y-m-d H:i:s');
    $modelPulangNew->update_time = date('Y-m-d H:i:s');
    $modelPulangNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modelPulangNew->create_loginpemakai_id = Yii::app()->user->id;
    $modelPulangNew->update_loginpemakai_id = Yii::app()->user->id;
    $modelPulangNew->pasienadmisi_id = $pasienadmisi_id;

    if (isset($attrPasienPulang['tgl_meninggal'])) {
      $modelPulangNew->ismeninggal = true;
    } else {
      $modelPulangNew->ismeninggal = false;
    }

    $masukKamar = MasukkamarT::model()->findByAttributes(
      array(
        'pasienadmisi_id' => $pasienadmisi_id,
        'pindahkamar_id' => null
      )
    );

    if (!$modelPulangNew->cekSisaPembayaranUntukPulang()) {
      throw new CException("Sisa tagihan pasien yang akan dipulangkan belum dibayarkan.");
    }

    // die;
    if ($modelPulangNew->validate()) {
      if ($modelPulangNew->save()) {
        //                   ini digunakan untuk mengupdate masukkamar ruangan_id=>menjadi null dan kamarruangan_m  status menjadi true
        $kamarruangan_status = true;
        $keterangan_kamar = Params::KETERANGANKAMAR_TERSEDIA; //'OPEN'
        $modBookingkamar = BookingkamarT::model()->findByAttributes(array('kamarruangan_id' => $masukKamar->kamarruangan_id, 'statuskonfirmasi' => 'SUDAH KONFIRMASI', 'pasienadmisi_id' => null));
        if (!empty($modBookingkamar)) {
          $kamarruangan_status = false;
          $keterangan_kamar = Params::KETERANGANKAMAR_DIPESAN; //'BOOKING'
        }
        $ukamarruangan = true;

        // var_dump($kamarruangan_status, $keterangan_kamar); die;

        if (!empty($masukKamar->kamarruangan_id)) {
          $ukamarruangan = KamarruanganM::model()->updateByPk(
            $masukKamar->kamarruangan_id,
            array(
              'kamarruangan_status' => $kamarruangan_status,
              'keterangan_kamar' => $keterangan_kamar
            )
          );
        }
        // $umasukkamar = MasukkamarT::model()->updateByPk($masukKamar->masukkamar_id, array('kamarruangan_id'=>null));
        if ($ukamarruangan || $umasukkamar) {
          $this->successPasienPulang = true;
        }
      } else {
        $this->successPasienPulang = false;
      }
    }

    return $modelPulangNew;
  }

  public function actionPindahKamarDariTransaksi()
  {
    $this->pageTitle = Yii::app()->name . " - Pindah Kamar";
    $format = new MyFormatter;
    $modPindahKamar = new RIPindahkamarT;
    $modPasienRIV = new RIPasienRawatInapV;
    $modMasukKamar = new RIMasukKamarT;

    $modPindahKamar->tglpindahkamar = date('d M Y');
    $modPindahKamar->jampindahkamar = date('H:i:s');
    $tersimpan = 'Tidak';

    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
    $smspasien = 1;

    $modPasienRIV->unsetAttributes();
    if (isset($_GET['RIPasienRawatInapV'])) {
      $modPasienRIV->attributes = $_GET['RIPasienRawatInapV'];
    }

    if (isset($_POST['RIPindahkamarT'])) {
      if ($_POST['RIPindahkamarT']['pendaftaran_id'] == '') {
        Yii::app()->user->setFlash('error', "Pendaftaran masih kosong coba cek lagi");
        $this->refresh();
      } else {
        $modPindahKamar->attributes = $_POST['RIPindahkamarT'];
        $modPindahKamar->tglpindahkamar = $format->formatDateTimeForDb($_POST['RIPindahkamarT']['tglpindahkamar']) . " " . $modPindahKamar->jampindahkamar;
        $pendaftaran_id = ((isset($_POST['RIPindahkamarT']['pendaftaran_id'])) ? $_POST['RIPindahkamarT']['pendaftaran_id'] : null);
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $modPasienRIV = RIPasienRawatInapV::model()->findByAttributes(
          array(
            'pasienadmisi_id' => $modPendaftaran->pasienadmisi_id
          )
        );

        /* PASIEN MASUK KAMAR LAMA*/
        $modMasukKamar = RIMasukKamarT::model()->findByPk(
          $modPindahKamar->masukkamar_id
        );

        /* PASIEN ADMISI*/
        $modPasienAdmisi = RIPasienAdmisiT::model()->findByPK(
          $modPindahKamar->pasienadmisi_id
        );

        /* END PASIEN ADMISI*/

        $modPindahKamar->pasien_id = $modPasienRIV->pasien_id;
        $modPindahKamar->pendaftaran_id = $modPasienRIV->pendaftaran_id;
        $modPindahKamar->pasienadmisi_id = $modPasienRIV->pasienadmisi_id;
        $modPindahKamar->masukkamar_id = null;
        $modPindahKamar->shift_id = Yii::app()->user->getState('shift_id');
        $modPindahKamar->nopindahkamar = MyGenerator::noMasukKamar($modPindahKamar->ruangan_id);
        $modPindahKamar->carabayar_id = $modPasienAdmisi->carabayar_id;
        $modPindahKamar->penjamin_id = $modPasienAdmisi->penjamin_id;
        $modPindahKamar->pegawai_id = $modPasienAdmisi->pegawai_id;


        /* PROSES SIMPAN DAN UPDATE */
        $transaction = Yii::app()->db->beginTransaction();
        $is_simpan = false;
        $errors = array();
        $pesan = array(
          'status' => 'success',
          'text' => 'Data Berhasil Disimpan'
        );
        try {
          /* simpan_pindah_kamar */

          $isSimpanPindahKamar = false;
          if ($modPindahKamar->save()) {
            $isSimpanPindahKamar = true;
          };
          if (!empty($modPasienAdmisi->kamarruangan_id)) {
            KamarruanganM::model()->updateByPk(
              $modPasienAdmisi->kamarruangan_id,
              array('kamarruangan_status' => true, 'keterangan_kamar' => Params::KETERANGANKAMAR_TERSEDIA) //'OPEN'
            );
          }

          /* update_masuk_kamar lama*/
          $modMasukKamar->pindahkamar_id = $modPindahKamar->pindahkamar_id;
          $modMasukKamar->tglkeluarkamar = $modPindahKamar->tglpindahkamar;
          $modMasukKamar->jamkeluarkamar = $modPindahKamar->jampindahkamar;

          $selisihHari = CustomFunction::hitungHari($modMasukKamar->tglmasukkamar, $modMasukKamar->tglkeluarkamar);

          $modMasukKamar->lamadirawat_kamar = $selisihHari;

          if ($modMasukKamar->save()) {
            /* update_pasien_admisi */
            $is_simpan = true;
            $modPasienAdmisi->ruangan_id = $modPindahKamar->ruangan_id;
            $modPasienAdmisi->kelaspelayanan_id = $modPindahKamar->kelaspelayanan_id;
            $modPasienAdmisi->kamarruangan_id = !empty($modPindahKamar->kamarruangan_id) ? $modPindahKamar->kamarruangan_id : null;
            if ($modPasienAdmisi->save()) {
              /* simpan_masuk_kamar_new */
              $is_simpan = true;
              $mod_masuk_kamar = new RIMasukKamarT();
              $mod_masuk_kamar->attributes = $modPindahKamar->attributes; //mengambil nilai ruangan_id, 
              $mod_masuk_kamar->pindahkamar_id = null; //karena record baru asumsi belum pernah pindah
              $mod_masuk_kamar->masukkamar_id = null; //record baru
              $mod_masuk_kamar->nomasukkamar = MyGenerator::noMasukKamar(Yii::app()->user->getState('ruangan_id'));
              $mod_masuk_kamar->tglmasukkamar = $modPindahKamar->tglpindahkamar;
              $mod_masuk_kamar->jammasukkamar = $modPindahKamar->jampindahkamar;
              $mod_masuk_kamar->kelaspelayanan_id = empty($modPindahKamar->kelaspelayanan_id) ?  $modMasukKamar->kelaspelayanan_id : $modPindahKamar->kelaspelayanan_id;
              $mod_masuk_kamar->create_time = date('Y-m-d H:i:s');
              $mod_masuk_kamar->create_loginpemakai_id = Yii::app()->user->id;
              $mod_masuk_kamar->create_ruangan = Yii::app()->user->getState('ruangan_id');
              $mod_masuk_kamar->kamarruangan_id = !empty($modPindahKamar->kamarruangan_id) ? $modPindahKamar->kamarruangan_id : null;
              if ($mod_masuk_kamar->save()) {
                $is_simpan = true;

                /* update_kamar_ruangan */
                //update masukkamar_id (baru) pada pindahkamar_t
                $modPindahKamar->updateByPk($modPindahKamar->pindahkamar_id, array('masukkamar_id' => $mod_masuk_kamar->masukkamar_id));
                if (!empty($modPindahKamar->kamarruangan_id)) {
                  KamarruanganM::model()->updateByPk(
                    $modPindahKamar->kamarruangan_id,
                    array('kamarruangan_status' => false, 'keterangan_kamar' => Params::KETERANGANKAMAR_DIGUNAKAN) //'IN USE'
                  );
                }
              } else {
                $is_simpan = false;
                $pesan = array(
                  'status' => 'error',
                  'text' => 'Data Masuk Kamar Gagal Disimpan'
                );
                $errors[] = $pesan;
              }
            } else {
              $is_simpan = false;
              $pesan = array(
                'status' => 'error',
                'text' => 'Data Admisi Gagal Disimpan'
              );
              $errors[] = $pesan;
            }
          } else {
            $is_simpan = false;
            $pesan = array(
              'status' => 'error',
              'text' => 'Data Masuk Kamar Gagal Disimpan'
            );
            $errors[] = $pesan;
          }

          if ($is_simpan && $isSimpanPindahKamar) {

            // SMS GATEWAY
            $modPasien = $modPasienAdmisi->pasien;
            $modRuangan = $modPasienAdmisi->ruangan;
            $modKamarRuangan = $modPasienAdmisi->kamarruangan;
            $modKelaspelayanan = $modPasienAdmisi->kelaspelayanan;
            $sms = new Sms();
            foreach ($modSmsgateway as $i => $smsgateway) {
              $isiPesan = $smsgateway->templatesms;

              $attributes = $modPasien->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modRuangan->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modKelaspelayanan->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modKamarRuangan->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modPindahKamar->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPindahKamar->tglpindahkamar), $isiPesan);


              if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                if (!empty($modPasien->no_mobile_pasien)) {
                  $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                } else {
                  $smspasien = 0;
                }
              }
            }
            // END SMS GATEWAY

            $tersimpan = 'Ya';
            $transaction->commit();
            Yii::app()->user->setFlash($pesan['status'], $pesan['text']);
          } else {
            foreach ($errors as $val) {
              Yii::app()->user->setFlash($val['status'], $val['text']);
            }
            $transaction->rollback();
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan" . MyExceptionMessage::getMessage($exc, true));
        }
      }
    }

    $this->render(
      'formPindahKamar',
      array(
        'modPindahKamar' => $modPindahKamar,
        'modPasienRIV' => $modPasienRIV,
        'tersimpan' => $tersimpan,
        'modMasukKamar' => $modMasukKamar,
        'smspasien' => $smspasien,
        'jenis' => 'transaksi'
      )
    );
  }

  public function actionPindahKamarPasienRI($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPindahKamar = new RIPindahkamarT;
    $modPasienAdmisi = new RIPasienAdmisiT;
    $modPasienPulang = new RIPasienPulangT;
    $modMasukKamar = new RIMasukKamarT;
    $modTindakan = null;

    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
    $smspasien = 1;

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasienRIV = RIPasienRawatInapV::model()->findByAttributes(
      array('pasienadmisi_id' => $modPendaftaran->pasienadmisi_id)
    );
    $modMasukKamar = RIMasukKamarT::model()->findByPk(
      $modPasienRIV->masukkamar_id
    );

    $modPindahKamar->pasien_id = $modPasienRIV->pasien_id;
    $modPindahKamar->pendaftaran_id = $modPasienRIV->pendaftaran_id;
    $modPindahKamar->pasienadmisi_id = $modPasienRIV->pasienadmisi_id;
    $modPindahKamar->masukkamar_id = $modPasienRIV->masukkamar_id;
    $modPindahKamar->kamarruangan_id = !empty($modPasienRIV->kamarruangan_id) ? $modPasienRIV->kamarruangan_id : null;
    $modPindahKamar->pegawai_id = $modPendaftaran->pegawai_id;
    $modPindahKamar->carabayar_id = $modPendaftaran->carabayar_id;
    // $modPindahKamar->ruangan_id = $modPendaftaran->ruangan_id;
    $modPindahKamar->penjamin_id = $modPendaftaran->penjamin_id;
    // $modPindahKamar->kelaspelayanan_id = $modPasienRIV->kelaspelayanan_id;
    $modPindahKamar->jampindahkamar = date('H:i:s');
    $modPindahKamar->shift_id = Yii::app()->user->getState('shift_id');
    $modPindahKamar->nopindahkamar = MyGenerator::noMasukKamar($modPindahKamar->ruangan_id);
    $modPindahKamar->tglpindahkamar = date('d M Y');

    if (!empty($modPindahKamar->ruangan_id)) {
      $modRuang = RuanganM::model()->findByPk($modPindahKamar->ruangan_id);
      $modPindahKamar->instalasi_id = $modRuang->instalasi_id;
    }

    $tersimpan = 'Tidak';
    if (isset($_POST['RIPindahkamarT'])) {
      if ($_POST['RIPindahkamarT']['pendaftaran_id'] == '') {
        Yii::app()->user->setFlash('error', "Pendaftaran masih kosong coba cek lagi");
        $this->refresh();
      } else {
        $modPindahKamar->attributes = $_POST['RIPindahkamarT'];
        $modPindahKamar->tglpindahkamar = $format->formatDateTimeForDb($_POST['RIPindahkamarT']['tglpindahkamar']) . " " . $modPindahKamar->jampindahkamar;
        $pendaftaran_id = ((isset($_POST['RIPindahkamarT']['pendaftaran_id'])) ? $_POST['RIPindahkamarT']['pendaftaran_id'] : null);
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $modPasienRIV = RIPasienRawatInapV::model()->findByAttributes(
          array(
            'pasienadmisi_id' => $modPendaftaran->pasienadmisi_id
          )
        );

        /* PASIEN MASUK KAMAR LAMA*/
        $modMasukKamar = RIMasukKamarT::model()->findByPk(
          $modPindahKamar->masukkamar_id
        );

        $kamar_asal = (!empty($modMasukKamar)) ? $modMasukKamar->kamarruangan->kamarruangan_nokamar . ' ' . $modMasukKamar->kamarruangan->kamarruangan_nobed : '-';

        /* PASIEN ADMISI*/
        $modPasienAdmisi = RIPasienAdmisiT::model()->findByPK(
          $modPindahKamar->pasienadmisi_id
        );

        /* END PASIEN ADMISI*/

        $modPindahKamar->pasien_id = $modPasienRIV->pasien_id;
        $modPindahKamar->pendaftaran_id = $modPasienRIV->pendaftaran_id;
        $modPindahKamar->pasienadmisi_id = $modPasienRIV->pasienadmisi_id;
        $modPindahKamar->shift_id = Yii::app()->user->getState('shift_id');
        $modPindahKamar->nopindahkamar = MyGenerator::noPindahKamar($modPindahKamar->ruangan_id);
        $modPindahKamar->carabayar_id = $modPasienAdmisi->carabayar_id;
        $modPindahKamar->penjamin_id = $modPasienAdmisi->penjamin_id;
        $modPindahKamar->pegawai_id = $modPasienAdmisi->pegawai_id;

        // die;

        /* PROSES SIMPAN DAN UPDATE */
        $transaction = Yii::app()->db->beginTransaction();
        $is_simpan = false;
        $errors = array();
        $pesan = array(
          'status' => 'success',
          'text' => 'Data Berhasil Disimpan'
        );


        /* PROSES PINDAH DOKUMEN RM */
        /*
					$dokrm = PengirimanrmT::model()->findByAttributes(array(
						'pendaftaran_id'=>$modPasienRIV->pendaftaran_id,
						'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
					), array(
						'order'=>'pengirimanrm_id desc',
					));
					if (!empty($dokrm)) {
						$doknew = new PengirimanrmT();
						//$doknew->attributes = $dokrm->attributes;
						$doknew->pengirimanrm_id = null;
						$doknew->pasien_id = $dokrm->pasien_id;
						$doknew->pendaftaran_id = $dokrm->pendaftaran_id;
						$doknew->ruanganpengirim_id = $dokrm->ruangan_id;
						$doknew->dokrekammedis_id = $dokrm->dokrekammedis_id;
						$doknew->ruangan_id = $modPindahKamar->ruangan_id;
						$doknew->nourut_keluar = MyGenerator::noUrutKeluarRM();
						$doknew->tglpengirimanrm = $modPindahKamar->tglpindahkamar;
						$doknew->kelengkapandokumen = true;

						$lp = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
						if (!empty($lp->pegawai_id)) {
							$pegawai = PegawaiM::model()->findByPk($lp->pegawai_id);
							$doknew->petugaspengirim = $pegawai->nama_pegawai;
						}


						$doknew->validate();
					}
                     * 
                     */

        try {
          /* simpan_pindah_kamar */
          // var_dump($modPindahKamar->attributes);
          $mk =  MasukkamarT::model()->findByPk($modPindahKamar->masukkamar_id);
          $modPindahKamar->masukkamar_id = null; //ini di isi masukkamar baru nanti
          if ($modPindahKamar->save()) {
            $modMasukKamar->pindahkamar_id = $modPindahKamar->pindahkamar_id;
            $modMasukKamar->tglkeluarkamar = $modPindahKamar->tglpindahkamar;
            $modMasukKamar->jamkeluarkamar = $modPindahKamar->jampindahkamar;

            $selisihHari = CustomFunction::hitungHari($modMasukKamar->tglmasukkamar, $modMasukKamar->tglkeluarkamar);

            $modMasukKamar->lamadirawat_kamar = $selisihHari;
          } else {
            $modMasukKamar->pindahkamar_id = null;
          }

          // var_dump($mk->kamarruangan_id);

          if (!empty($modPasienAdmisi->kamarruangan_id)) {
            //echo "Kick1"; die;
            KamarruanganM::model()->updateByPk(
              $modPasienAdmisi->kamarruangan_id,
              array('kamarruangan_status' => true, 'keterangan_kamar' => Params::KETERANGANKAMAR_TERSEDIA) //'OPEN'
            );
          } else if (!empty($mk) && !empty($mk->kamarruangan_id)) {
            //echo "Kick2"; die;
            KamarruanganM::model()->updateByPk(
              $mk->kamarruangan_id,
              array('kamarruangan_status' => true, 'keterangan_kamar' => Params::KETERANGANKAMAR_TERSEDIA) //'OPEN'
            );
          }
          // die;

          /* update_masuk_kamar lama*/
          if ($modMasukKamar->save()) {
            /* update_pasien_admisi */
            $is_simpan = true;

            if ($modPasienAdmisi->ruangan_id != $modPindahKamar->ruangan_id) {
              $is_simpan = $is_simpan && $this->simpanKirimRMPindahKamar($modPasienAdmisi, $modPindahKamar);
            }

            // var_dump($is_simpan); die;

            $modPasienAdmisi->ruangan_id = $modPindahKamar->ruangan_id;
            $modPasienAdmisi->kelaspelayanan_id = $modPindahKamar->kelaspelayanan_id;
            $modPasienAdmisi->kamarruangan_id = !empty($modPindahKamar->kamarruangan_id) ? $modPindahKamar->kamarruangan_id : null;
            if ($modPasienAdmisi->save()) {
              /* simpan_masuk_kamar_new */
              $is_simpan = true;
              $mod_masuk_kamar = new RIMasukKamarT();
              $mod_masuk_kamar->attributes = $modPindahKamar->attributes; //mengambil nilai ruangan_id, 
              $mod_masuk_kamar->pindahkamar_id = null; //karena record baru asumsi belum pernah pindah
              $mod_masuk_kamar->masukkamar_id = null; //record baru
              $mod_masuk_kamar->nomasukkamar = MyGenerator::noMasukKamar(Yii::app()->user->getState('ruangan_id'));
              $mod_masuk_kamar->tglmasukkamar = $modPindahKamar->tglpindahkamar;
              $mod_masuk_kamar->jammasukkamar = $modPindahKamar->jampindahkamar;
              $mod_masuk_kamar->kelaspelayanan_id = empty($modPindahKamar->kelaspelayanan_id) ?  $modMasukKamar->kelaspelayanan_id : $modPindahKamar->kelaspelayanan_id;
              $mod_masuk_kamar->create_time = date('Y-m-d H:i:s');
              $mod_masuk_kamar->create_loginpemakai_id = Yii::app()->user->id;
              $mod_masuk_kamar->create_ruangan = Yii::app()->user->getState('ruangan_id');
              $mod_masuk_kamar->kamarruangan_id = !empty($modPindahKamar->kamarruangan_id) ? $modPindahKamar->kamarruangan_id : null;

              if ($mod_masuk_kamar->save()) {
                $is_simpan = true;
                //if (!empty($dokrm)) {
                //	$doknew->save();
                //}
                //var_dump($doknew->save()); die;
                //update masukkamar_id (baru) pada pindahkamar_t
                $modPindahKamar->updateByPk($modPindahKamar->pindahkamar_id, array('masukkamar_id' => $mod_masuk_kamar->masukkamar_id));
                if (!empty($modPindahKamar->kamarruangan_id)) {
                  /* update_kamar_ruangan */
                  KamarruanganM::model()->updateByPk(
                    $modPindahKamar->kamarruangan_id,
                    array('kamarruangan_status' => false, 'keterangan_kamar' => Params::KETERANGANKAMAR_DIGUNAKAN) //'IN USE'
                  );
                }
              } else {
                $is_simpan = false;
                $pesan = array(
                  'status' => 'error',
                  'text' => 'Data Masuk Kamar Gagal Disimpan'
                );
                $errors[] = $pesan;
              }
            } else {
              $is_simpan = false;
              $pesan = array(
                'status' => 'error',
                'text' => 'Data Admisi Gagal Disimpan'
              );
              $errors[] = $pesan;
            }
          } else {
            $is_simpan = false;
            $pesan = array(
              'status' => 'error',
              'text' => 'Data Masuk Kamar Gagal Disimpan'
            );
            $errors[] = $pesan;
          }

          if(Yii::app()->user->getState('akomodasiotomatis') == true) {
            self::saveAkomodasi($modPendaftaran, $modPasienAdmisi);
          }

          if ($is_simpan) {

            // vaR_dump("OK"); die;

            $tersimpan = 'Ya';

            //notifikasi pindah kamar ke ruangan tujuan
            $nama_pemakai = LoginpemakaiK::model()->findByPk($mod_masuk_kamar->create_loginpemakai_id);
            $tujuan = RuanganM::model()->findByPk($modPindahKamar->ruangan_id);
            $modul = ModulK::model()->findByPk($tujuan->modul_id);

            if ($modPindahKamar->ruangan_id != Yii::app()->user->getState('ruangan_id')) {
              $judul = 'PASIEN PINDAH KAMAR';
              $isi = $modPasienRIV->no_rekam_medik . ' ' . $modPasienRIV->namadepan . ' ' . $modPasienRIV->nama_pasien . ', ' . strtoupper($kamar_asal . ' - ' . $modPindahKamar->kamarruangan->kamarruangan_nokamar . ' ' . $modPindahKamar->kamarruangan->kamarruangan_nobed) . '<br/>'
                . MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($mod_masuk_kamar->create_time))) . ', ' . $nama_pemakai->nama_pemakai;

              if (!empty($tujuan->modul_id)) {
                $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                  array(
                    'instalasi_id' => $tujuan->instalasi_id,
                    'ruangan_id' => $tujuan->ruangan_id,
                    'modul_id' => $modul->modul_id
                  ),
                ));
              }

              $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'modul_id' => Yii::app()->session['modul_id']),
                //array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),
                array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
                array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id' => Params::MODUL_ID_REKAMMEDIS),
                array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK),
              ));
            } else {
              $judul = 'PASIEN PINDAH KAMAR';
              $isi = $modPasienRIV->no_rekam_medik . ' ' . $modPasienRIV->namadepan . ' ' . $modPasienRIV->nama_pasien . ', ' . strtoupper($kamar_asal . ' - ' . $modPindahKamar->kamarruangan->kamarruangan_nokamar . ' ' . $modPindahKamar->kamarruangan->kamarruangan_nobed) . '<br/>'
                . MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($mod_masuk_kamar->create_time))) . ', ' . $nama_pemakai->nama_pemakai;
              $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'modul_id' => Yii::app()->session['modul_id']),
                //array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),
                array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
                array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id' => Params::MODUL_ID_REKAMMEDIS),
                array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK),
              ));
            }

            $transaction->commit();
            Yii::app()->user->setFlash($pesan['status'], $pesan['text']);
          } else {
            foreach ($errors as $val) {
              Yii::app()->user->setFlash($val['status'], $val['text']);
            }
            $transaction->rollback();
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan. " . $exc->getMessage());
        }
      }
    }
    $this->render(
      'formPindahKamar',
      array(
        'modPindahKamar' => $modPindahKamar,
        'modPasienRIV' => $modPasienRIV,
        'modMasukKamar' => $modMasukKamar,
        'modTindakan' => $modTindakan,
        'tersimpan' => $tersimpan,
        'is_grid' => true,
        'smspasien' => $smspasien
      )
    );
  }

  /**
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   * 
   * Menyimpan data pengiriman RM dari ruangan lama ke ruangan baru ketika 
   * pindah kamar dilakukan dengan ruangan yang berbeda.
   * Setelah pengiriman RM disimpan, maka data pendaftaran_t akan diupdate status
   * dan set id pengiriman dengan data pengiriman yang disimpan tadi.
   * 
   * @param PasienadmisiT $modPasienAdmisi
   * @param PindahkamarT $modPindahKamar
   * @return boolean Dokumen Rekam medis berhasil disimpan dan data Pendaftaran
   * sudah diupdate.
   */



  function simpanKirimRMPindahKamar($modPasienAdmisi, $modPindahKamar)
  {

    $ok = true;
    $pendaftaran = PendaftaranT::model()->findByPk($modPasienAdmisi->pendaftaran_id);
    $kirim_lama = PengirimanrmT::model()->findByPk($pendaftaran->pengirimanrm_id);
    $ruangan = RuanganM::model()->findByPk($modPindahKamar->ruangan_id);

    if (!empty($kirim_lama)) {
      $kirim = new PengirimanrmT;
      $kirim->pasien_id = $modPasienAdmisi->pasien_id;
      $kirim->pendaftaran_id = $modPasienAdmisi->pendaftaran_id;
      $kirim->dokrekammedis_id = $kirim_lama->dokrekammedis_id;
      $kirim->tglpengirimanrm = date('Y-m-d H:i:s');
      $kirim->petugaspengirim = Yii::app()->user->name;
      $kirim->petugaspengirim_id = Yii::app()->user->getState('pegawai_id');
      $kirim->ruangan_id = $modPindahKamar->ruangan_id;
      $kirim->instalasi_id = $ruangan->instalasi_id;
      $kirim->nourut_keluar = MyGenerator::noUrutKeluarRM();
      $kirim->kelengkapandokumen = TRUE;
      $kirim->create_time = date('Y-m-d H:i:s');
      $kirim->create_loginpemakai_id = Yii::app()->user->id;
      $kirim->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $kirim->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
      $kirim->ruanganpenerima_id = $modPindahKamar->ruangan_id;

      if ($kirim->validate()) {
        $ok = $ok && $kirim->save();

        $pendaftaran->pengirimanrm_id = $kirim->pengirimanrm_id;
        $pendaftaran->statusdokrm = 'SUDAH DIKIRIM';

        $ok = $ok && $pendaftaran->save();
      } else $ok = false;
    }

    return $ok;

    //var_dump($pendaftaran->attributes, $kirim_lama->attributes, $ok, $kirim->attributes, $modPasienAdmisi->attributes, $modPindahKamar->attributes); die;


  }

  public static function cekAkomodasiHariIni($modPendaftaran, $modPasienAdmisi, $modMasukKamar)
  {
    $akomodasi = PasienRawatInapController::tindakanAkomodasi($modMasukKamar->kelaspelayanan_id, $modMasukKamar->penjamin_id, $modPasienAdmisi->ruangan_id);
    if (count((array)$akomodasi) > 0) {
      $tipePaket = PasienRawatInapController::tipePaketAkomodasi($modPendaftaran, $modPasienAdmisi, $akomodasi[0]->daftartindakan_id);
      $criteria = new CdbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $modPasienAdmisi->pendaftaran_id);
      $criteria->addCondition('pasienadmisi_id = ' . $modPasienAdmisi->pasienadmisi_id);
      $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
      $criteria->addCondition('kelaspelayanan_id = ' . $modMasukKamar->kelaspelayanan_id);
      $criteria->addCondition('tipepaket_id = ' . $tipePaket);
      $criteria->addBetweenCondition('tgl_tindakan', date('Y-m-d') . " 00:00:00", date('Y-m-d') . " 23:59:59");
      $modAkomodasi = TindakanpelayananT::model()->findAll($criteria);
      if (count((array)$modAkomodasi) == 0) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public static function saveAkomodasi($modPendaftaran, $modPasienAdmisi)
  {
    $ok = true;
    $masuk = MasukkamarT::model()->findAllByAttributes(array(
      'pasienadmisi_id' => $modPasienAdmisi->pasienadmisi_id,
    ), array(
      'order' => 'masukkamar_id asc',
    ));

    $konfig = KonfigsystemK::model()->find();

    $limit_alert = $konfig->waktutampilalert_akomodasisdhterhitung;
    $limit_alert_time = (empty($limit_alert) ? 2 : $limit_alert) * 3600;

    $downer = 0;
    $base_masuk = array();


    foreach ($masuk as $idx => $item) {

      $is_belum_keluar = false;

      $tgl_awal = $item->tglmasukkamar;
      $tgl_akhir = $item->tglkeluarkamar;

      $list_masuk = array();

      if (empty($tgl_akhir)) {
        $is_belum_keluar = true;
        $tgl_akhir = date('Y-m-d H:i:s');
      }

      $tgl_awal = new DateTime($tgl_awal);
      $tgl_akhir = new DateTime($tgl_akhir);


      // set tindakan 1-1

      $sub_masuk = array(
        'tgl_tindakan_awal' => $tgl_awal->format('Y-m-d H:i:s'), 
        'tgl_tindakan_akhir' => null,
        'qty' => 0,
        'masukkamar_id' => $item->masukkamar_id,
      );

      if ($tgl_awal->format('Y-m-d') == $tgl_akhir->format('Y-m-d')) {

        $sub_masuk['tgl_tindakan_akhir'] = $tgl_akhir->format('Y-m-d H:i:s');
        if (!empty($masuk[$idx + 1])) {
          $sub_masuk['qty'] += 0.5;
        } else {
          $sub_masuk['qty'] += 1;
        }

      } else {
        $period = new DatePeriod(
          new DateTime($tgl_awal->format('Y-m-d')),
          new DateInterval('P1D'),
          new DateTime($tgl_akhir->format('Y-m-d 23:59:59'))
        );
        foreach ($period as $date) {

          if ($tgl_awal->format('Y-m-d') == $date->format('Y-m-d')) {

            if ($idx == 0) {
              $setengah = false;
            } else {
              $setengah = true;
            }

            $sub_masuk['tgl_tindakan_akhir'] = $date->format('Y-m-d 23:59:59');
            $sub_masuk['qty'] += $setengah ? 0.5 : 1;

            /*
            $list_masuk[] = array(
              'tgl_tindakan_awal' => $tgl_awal->format('Y-m-d H:i:s'), 
              'tgl_tindakan_akhir' => $date->format('Y-m-d 23:59:59'),
              'is_setengah' => $setengah,
              'masukkamar_id' => $item->masukkamar_id,
              'qty' => $setengah ? 0.5 : 1,
            );
            */
          } else if ($tgl_akhir->format('Y-m-d') == $date->format('Y-m-d')) {


            if (empty($item->tglkeluarkamar)) {
              $setengah = false;
            } else {
              $setengah = true;
            }

            $sub_masuk['tgl_tindakan_akhir'] = $tgl_akhir->format('Y-m-d H:i:s');
            $sub_masuk['qty'] += $setengah ? 0.5 : 1;

            /*
            $list_masuk[] = array(
              'tgl_tindakan_awal' => $date->format('Y-m-d 00:00:00'), 
              'tgl_tindakan_akhir' => $tgl_akhir->format('Y-m-d H:i:s'),
              'is_setengah' => $setengah,
              'masukkamar_id' => $item->masukkamar_id,
              'qty' => 1,
            );
            */
          } else {

            $sub_masuk['tgl_tindakan_akhir'] = $date->format('Y-m-d 23:59:59');
            $sub_masuk['qty'] += 1;

            /*
            $list_masuk[] = array(
              'tgl_tindakan_awal' => $date->format('Y-m-d 00:00:00'), 
              'tgl_tindakan_akhir' => $date->format('Y-m-d 23:59:59'),
              'is_setengah' => false,
              'masukkamar_id' => $item->masukkamar_id,
              'qty' => 1,
            );
            */
          }
        }
      }

    
      $item_masuk = $sub_masuk;
      
      // foreach ($list_masuk_res as $item_masuk) {
        // echo "Tgl tarif : ".$item_masuk['tgl_tindakan_awal']." x ".$item_masuk['tgl_tindakan_akhir']." - qty : ".$item_masuk['qty']." - masukkamar_id : ".$item_masuk['masukkamar_id']."\n";
      
        $tindakan = TindakanpelayananT::model()->findByAttributes(array(
          'masukkamar_id'=>$item_masuk['masukkamar_id'],
          // 'tgl_tindakan'=>$item_masuk['tgl_tindakan_awal']
        ), array(
          'condition'=>'verifbataltindakan_id is null',
        ));

        if (!empty($tindakan)) {
          // echo "TINDAKAN ADA\n";

          $tindakanAko = self::tindakanAkomodasi($tindakan->kelaspelayanan_id, $tindakan->penjamin_id, $tindakan->ruangan_id, $tindakan->daftartindakan_id);
          // var_dump(count($tindakanAko));

          if (!empty($tindakanAko[0])) {
            $tindakan->tarif_satuan = $tindakanAko[0]->harga_tariftindakan;
          }

          $tindakan->qty_tindakan = $item_masuk['qty'];
          $tindakan->tarif_tindakan = $tindakan->tarif_satuan * $tindakan->qty_tindakan;
          $tindakan->save(false, array('tarif_tindakan', 'tarif_satuan', 'qty_tindakan'));

        } else {
          // echo "TINDAKAN TIDAK ADA\n";
          $item->tglmasukkamar = $item_masuk['tgl_tindakan_awal'];
          $ok = self::simpanTindakanAkomodasi($modPasienAdmisi, $item, $item_masuk['qty']);
        }
      // }
      
    } 

    return $ok;
  }

  public static function simpanAkomodasiInap($modPasienAdmisi, $masukkamar, $selisih)
  {
    // periksa tindakan pelayanan

    $ok = true;
    /*
            if (!empty($next)) {
                $selisih = CustomFunction::hitungHari($masukkamar->tglmasukkamar, $next->tglmasukkamar) - 1;
            } else {
                $selisih = CustomFunction::hitungHari($masukkamar->tglmasukkamar, null);
            }
             * 
             */

    $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
      'masukkamar_id' => $masukkamar->masukkamar_id,
    ));
    if (count((array)$tindakan) == 0) {
      $ok = $ok && self::simpanTindakanAkomodasi($modPasienAdmisi, $masukkamar, $selisih);
    } else {
      $qty = 0;
      foreach ($tindakan as $item) {
        $qty += $item->qty_tindakan;
      }

      $selisih -= $qty;
      if ($selisih > 0) {
        $ok = $ok && self::simpanTindakanAkomodasi($modPasienAdmisi, $masukkamar, $selisih);
      }
    }

    return $ok;
  }

  public static function simpanTindakanAkomodasi($modPasienAdmisi, $masukkamar, $selisih, $is_setengah = false)
  {
    $akomodasi_list = PasienRawatInapController::tindakanAkomodasi($masukkamar->kelaspelayanan_id, $masukkamar->penjamin_id, $masukkamar->ruangan_id);

    if (count((array)$akomodasi_list) == 0) {
      return true;
    }

    $tindakanMasuk = TindakanpelayananT::model()->find("pendaftaran_id = ".$modPasienAdmisi->pendaftaran_id." AND masukkamar_id is not null and nopelayanan IS NOT NULL order by cast((case when nopelayanan = '' or nopelayanan is null then '0' else nopelayanan end) as integer) DESC");

    $no_awal_hasil = null;

    if (!empty($tindakanMasuk)) {
      $no_awal_hasil = $tindakanMasuk->nopelayanan;
    }

    /*
    if (!empty($tindakanMasuk)) {
      $no_awal_hasil = $tindakanMasuk->nopelayanan;
    } else {
      $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPasienAdmisi->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan::numeric DESC");
  
      if(!empty($md_noawal)) {
        $noawal = intval($md_noawal->nopelayanan);
      } else {
        $noawal = 1;
      }
      $no_awal_hasil = str_pad($noawal+1,3,"0",STR_PAD_LEFT);
    }
    */


    // var_dump(count($akomodasi_list));

    foreach ($akomodasi_list as $akomodasi) {

      

      // var_dump($noawal);


      $tindakan = new TindakanpelayananT;

      $tindakan->penjamin_id = $masukkamar->penjamin_id;
      $tindakan->pasien_id = $modPasienAdmisi->pasien_id;
      $tindakan->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
      $tindakan->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
      $tindakan->instalasi_id = $masukkamar->ruangan->instalasi_id;
      $tindakan->pendaftaran_id = $modPasienAdmisi->pendaftaran_id;
      $tindakan->shift_id = 1; //Yii::app()->user->getState('shift_id');
      $tindakan->daftartindakan_id = (isset($akomodasi->daftartindakan_id) ? $akomodasi->daftartindakan_id : "");
      $tindakan->carabayar_id = $modPasienAdmisi->carabayar_id;
      $tindakan->jeniskasuspenyakit_id = $modPasienAdmisi->pendaftaran->jeniskasuspenyakit_id;

      $tindakan->tarif_satuan = (isset($akomodasi->harga_tariftindakan) ? $akomodasi->harga_tariftindakan : "");

      /*
      if ($is_setengah) {
        $tindakan->tarif_satuan = $tindakan->tarif_satuan * 0.5;
      }
      */

      $tindakan->qty_tindakan = $selisih;
      $tindakan->tarif_tindakan = $tindakan->tarif_satuan * $tindakan->qty_tindakan;
      $tindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
      $tindakan->cyto_tindakan = 0;
      $tindakan->tarifcyto_tindakan = 0;
      $tindakan->dokterpemeriksa1_id = NULL;
      $tindakan->discount_tindakan = 0;
      $tindakan->subsidiasuransi_tindakan = 0;
      $tindakan->subsidipemerintah_tindakan = 0;
      $tindakan->subsisidirumahsakit_tindakan = 0;
      $tindakan->iurbiaya_tindakan = 0;
      $tindakan->pembebasan_tindakan = 0;
      $tindakan->ruangan_id = $masukkamar->ruangan_id;
      $tindakan->tipepaket_id = PasienRawatInapController::tipePaketAkomodasi($modPasienAdmisi->pendaftaran, $modPasienAdmisi, $tindakan->daftartindakan_id);
      $tindakan->create_time = date('Y-m-d H:i:s');
      $tindakan->create_loginpemakai_id = 1;
      $tindakan->create_ruangan = $masukkamar->ruangan_id;
      $tindakan->tarif_rsakomodasi = 0;
      $tindakan->tarif_medis = 0;
      $tindakan->tarif_paramedis = 0;
      $tindakan->tarif_bhp = 0;
      $tindakan->tgl_tindakan = date('Y-m-d H:i:s', strtotime($masukkamar->tglmasukkamar));
      $tindakan->masukkamar_id = $masukkamar->masukkamar_id;
      $tindakan->nopelayanan = $tindakan->nopelayanan ?? ""; //$no_awal_hasil;

      $ok = true;

      if ($tindakan->validate()) {
        $ok = $ok && $tindakan->save();
        $tindakan->saveTindakanKomponen();


        // var_dump($tindakan->attributes);

        //$komponen = TindakankomponenT::model()->findAllByAttributes(array(
        //    'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id,
        //));
        //var_dump(count((array)$komponen));
      } else {
        $ok = false;
      }
    }

    // var_dump($tindakan->attributes);
    return $ok;
  }

  public static function hapusTindakanAkomodasiTanpaMasukKamar($modPasienAdmisi)
  {
    $dt = DaftartindakanM::model()->findAllByAttributes(array(
      'kelompoktindakan_id' => Params::KELOMPOKTINDAKAN_ID_PELAYANANRAWATINAP,
      'daftartindakan_akomodasi' => true,
      'daftartindakan_aktif' => true,
    ), array(
      'select' => 'daftartindakan_id',
    ));

    $ok = true;
    foreach ($dt as $item) {
      $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $modPasienAdmisi->pendaftaran_id,
        'daftartindakan_id' => $item->daftartindakan_id,
      ), array(
        'select' => 'tindakanpelayanan_id',
        'condition' => 'tindakansudahbayar_id is null',
      ));

      foreach ($tindakan as $dat) {
        $komponen = TindakankomponenT::model()->findAllByAttributes(array(
          'tindakanpelayanan_id' => $dat->tindakanpelayanan_id,
        ));
        if (count((array)$komponen) != 0) {
          $ok = $ok && TindakankomponenT::model()->deleteAllByAttributes(array(
            'tindakanpelayanan_id' => $dat->tindakanpelayanan_id,
          ));
        }
        $ok = $ok && TindakanpelayananT::model()->deleteByPk($dat->tindakanpelayanan_id);
      }
    }
    return $ok;
  }

  public static function tindakanAkomodasi($kelaspelayanan_id, $penjamin_id, $ruangan_id = null, $daftartindakan_id = null)
  {
    $criteria = new CDbCriteria;
    if (!empty($ruangan_id)) {
      $criteria->addCondition('ruangan_id=' . $ruangan_id);
    } else {
      $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
    }
    $criteria->addCondition('penjamin_id = ' . $penjamin_id);
    $criteria->addCondition('daftartindakan_akomodasi is true');
    if (!empty($kelaspelayanan_id)) {
      $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
    }
    $criteria->compare('daftartindakan_id', $daftartindakan_id);
    $criteria->limit = 1;
    // var_dump($criteria);
    $daftarTindakan = TariftindakanperdaruanganV::model()->findAll($criteria);

    return $daftarTindakan;
  }

  public static function tipePaketAkomodasi($modPendaftaran, $modPasienAdmisi, $idTindakan)
  {
    $criteria = new CDbCriteria;
    $criteria->with = array('tipepaket');
    if (!empty($idTindakan)) {
      $criteria->addCondition("daftartindakan_id = " . $idTindakan);
    }
    if (!empty($modPasienAdmisi->carabayar_id)) {
      $criteria->addCondition("tipepaket.carabayar_id = " . $modPasienAdmisi->carabayar_id);
    }
    if (!empty($modPasienAdmisi->penjamin_id)) {
      $criteria->addCondition("tipepaket.penjamin_id = " . $modPasienAdmisi->penjamin_id);
    }
    if (!empty($modPasienAdmisi->kelaspelayanan_id)) {
      $criteria->addCondition("tipepaket.kelaspelayanan_id = " . $modPasienAdmisi->kelaspelayanan_id);
    }
    $modPaket = PaketpelayananM::model()->find($criteria);
    $paket = Params::TIPEPAKET_ID_NONPAKET;
    if (isset($modPaket->paket_id)) {
      $paket = $modPaket->tipepaket_id;
    }

    return $paket;
  }
  /**
   * digunakan untuk membatalkan pasien rawat inap
   * tabel yang digunakan 
   * pendaftaran_t; pasien_m; pasienadmisi_t; jeniskasuspenyakit_m, pasienbatalrawat_r
   * @param type $pendaftaran_id type = integer  
   */
  public function actionBatalRawatInap($pendaftaran_id, $pasienadmisi_id)
  {
    $this->layout = '//layouts/iframe';

    $modPasienBatalRawat = new PasienbatalrawatR;

    $modPendaftaran    = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien         = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi         = PasienadmisiT::model()->findByPk($pasienadmisi_id);
    $jenisPenyakit     = JeniskasuspenyakitM::model()->findByPk($modPendaftaran->jeniskasuspenyakit_id);
    //             digunakan untuk merefresh jika data berhasil di simpan
    $tersimpan = 'Tidak';

    $modPendaftaran->jeniskasuspenyakit_nama   = $jenisPenyakit->jeniskasuspenyakit_nama;
    $modPasienBatalRawat->pasienadmisi_id      = $modAdmisi->pasienadmisi_id;
    $modPasienBatalRawat->create_time          = date('Y-m-d H:i:s');
    $modPasienBatalRawat->update_time          = date('Y-m-d H:i:s');
    $modPasienBatalRawat->create_ruangan       = Yii::app()->user->getState('ruangan_id');
    $modPasienBatalRawat->create_loginpemakai_id   = Yii::app()->user->id;
    $modPasienBatalRawat->update_loginpemakai_id   = Yii::app()->user->id;

    if (!empty($_REQUEST['PasienbatalrawatR'])) {

      $format = new MyFormatter();
      $modPasienBatalRawat->attributes = $_REQUEST['PasienbatalrawatR'];
      $modPasienBatalRawat->tglbatalrawat = $format->formatDateTimeForDb($modPasienBatalRawat->tglbatalrawat);
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $cek = PasienbatalrawatR::model()->findByAttributes(array('pasienadmisi_id' => $modPasienBatalRawat->pasienadmisi_id));
      $kamarRuangan = PasienadmisiT::model()->findByPk($modPasienBatalRawat->pasienadmisi_id);

      if (!empty($cek->update_time) || !empty($cek->update_loginpemakaian_id)) {
        $modPasienBatalRawat->update_time              = date('Y-m-d H:i:s');
        $modPasienBatalRawat->update_loginpemakai_id   = Yii::app()->user->getState('loginpemakai_id');
      }

      if ($modPasienBatalRawat->validate()) {
        $admisi_id = $pasienadmisi_id;;
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if ($modPasienBatalRawat->save()) {
            //                          update null terlebih dahulu kamarruangan_id di pasienadmisi                

            $modA = PasienadmisiT::model()->updateByPk($pasienadmisi_id, array('bookingkamar_id' => null, 'kamarruangan_id' => null, 'pendaftaran_id' => null));

            // TindakanpelayananT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));

            $bookingKamar = BookingkamarT::model()->findByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));

            $keterangan_kamar = Params::KETERANGANKAMAR_TERSEDIA; //'OPEN'
            $kamarruangan_status = true;
            if ($bookingKamar) {
              BookingkamarT::model()->updateByPk($bookingKamar->bookingkamar_id, array('pasienadmisi_id' => null));
              $keterangan_kamar = Params::KETERANGANKAMAR_DIPESAN; //'BOOKING'
              $kamarruangan_status = false;
            }

            $ok = $this->hapusTindakanDanUpdate($modAdmisi);

            //$masukKamar = MasukkamarT::model()->findByAttributes(array('pasienadmisi_id'=>$admisi_id));
            //if($masukKamar){
            //   MasukkamarT::model()->deleteByPk($masukKamar->masukkamar_id);
            //}
            if (!empty($kamarRuangan->kamarruangan_id)) {
              KamarruanganM::model()->updateByPk($kamarRuangan->kamarruangan_id, array('kamarruangan_status' => $kamarruangan_status, 'keterangan_kamar' => $keterangan_kamar));
            }

            $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, array(
              'pasienadmisi_id' => null, 'alihstatus' => false,
              'statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA, 'update_time' => date('Y-m-d H:i:s')
            ));
            // $deleteAdmisi = PasienadmisiT::model()->deleteByPk($admisi_id); //RND-1592

            // hapus tindakan

            if ($pendaftaran && $ok) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', "Data berhasil disimpan");
              $tersimpan = 'Ya';
            } else {
              $transaction->rollback();
              if (!$ok) {
                Yii::app()->user->setFlash('error', "Rawat Inap tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!");
              } else {
                Yii::app()->user->setFlash('error', "Data gagal disimpan");
              }
            }
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan", MyExceptionMessage::getMessage($exc, false));
        }
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $this->render('formBatalRawatInap', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modPasienBatalRawat' => $modPasienBatalRawat, 'tersimpan' => $tersimpan));
  }





  public function simpanPPDS($pendaftaran_id, $urutan_ppds, $ppds_id, $pasienadmisi_id, $post)
  {
    foreach ($post as $i => $ppds) {
      if (empty($ppds['pasien_ppds_id'])) {
        $model = new PasienPpdsT();
        $model->attributes = $ppds;
        $model->pendaftaran_id = $pendaftaran_id;
        $model->urutan_ppds = $urutan_ppds;
        $model->ppds_id = $urutan_ppds;
        $model->pasienadmisi_id = $pasienadmisi_id;

        if (!$model->save()) {
          $this->ppdsTersimpan &= false;
        }
      }
    }
  }


  public function actionCreate($pendaftaran_id = null, $pasienadmisi_id = null, $ppds_id = null, $urutan_ppds = null)
  {

    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
    $model2 = new PpdsM();
    $modPpds = new PpdsM();
    $modDetail = new PasienPpdsT;
    $model = new PasienPpdsT;

    if (isset($_POST['PasienPpdsT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $ok = true;
      $pesan = '';
      $i = 1;
      try {
        //  $modPds = PpdsM::model()->findByPk($_POST['PasienPpdsT']['ppds_id']);
        foreach ($_POST['PasienPpdsT'] as $idx => $item) {

          // $_POST['PasienPpdsT'][$item]['ppds_id'] = $modPds->ppds_id;
          // $_POST['PasienPpdsT'][$item]['urutan_ppds'] = $i;
          // $_POST['PasienPpdsT'][$item]['pendaftaran_id'] = $pendaftaran_id;
          // $_POST['PasienPpdsT'][$item]['pasienadmisi_id'] = $pasienadmisi_id;


          $modDetail = new PasienPpdsT;
          $modDetail->ppds_id = $item['ppds_id'];
          $modDetail->urutan_ppds = [$i];
          $modDetail->pendaftaran_id = [$pendaftaran_id];
          $modDetail->pasienadmisi_id = [$pasienadmisi_id];

          $ok = $ok && $modDetail->save();
          $i++;
        }

        if ($ok && !empty(Yii::app()->user->getState('pegawai_id'))) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Sukses!</strong> Data berhasil disimpan!');
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Perhatian!</strong> Nama PPDS Tidak Sesuai login Anda!');
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', $e);
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'model2' => $model2,
      'modPpds' => $modPpds,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRuangan' => $modRuangan,
      'modDetail' => $modDetail
    ));
  }

  public function actionAutoPPDS()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(ppds_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'ppds_nama';
      $criteria->limit = 10;
      $models = PpdsM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->ppds_nama;
        $returnVal[$i]['value'] = $model->ppds_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPPDSRJ($pendaftaran_id = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    //$pendaftaran_id = $_GET['pendaftaran_id'];

    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
    $model2 = new PpdsM();
    $modPpds = new PpdsM();
    $modDetail = new PasienPpdsT;

    $model2->ppds_nama;

    $this->render('_formPPDSRI', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRuangan' => $modRuangan,
      'model2' => $model2,
      'modPpds' => $modPpds,
      'modDetail' => $modDetail
      //   'datatable' => $datatable
    ));
  }




  public function hapusTindakanDanUpdate($admisi)
  {
    $cr = new CDbCriteria();
    $cr->select = "count(*) as tindakanpelayanan_id";
    $cr->addCondition("tindakansudahbayar_id is not null and pasienadmisi_id = " . $admisi->pasienadmisi_id);
    $dat = TindakanpelayananT::model()->find($cr);
    $ok = true;
    // if ($dat->tindakanpelayanan_id > 0) {
    if ($dat->tindakanpelayanan_id == 0) {
      //echo "MK"; die;
      // return false;
      return true;
    } else {
      $ok = $ok && TindakanpelayananT::model()->deleteAllByAttributes(array(
        'pasienadmisi_id' => $admisi->pasienadmisi_id
      ));
      //var_dump($ok);
      if ($admisi->pendaftaran->instalasi_id == Params::INSTALASI_ID_RI) {
        $ok = $ok && PendaftaranT::model()->updateByPk($admisi->pendaftaran_id, array(
          //'statusperiksa'=> Params::STATUSPERIKSA_SUDAH_PULANG,
          'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA,
          'pasienadmisi_id' => null,
        ));
      } else {
        $ok = $ok && PendaftaranT::model()->updateByPk($admisi->pendaftaran_id, array(
          //'statusperiksa'=> Params::STATUSPERIKSA_SUDAH_PULANG,
          'statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA,
          'pasienadmisi_id' => null,
        ));
      }
      //var_dump($ok); 

      $pk = PindahkamarT::model()->findAllByAttributes(array(
        'pasienadmisi_id' => $admisi->pasienadmisi_id,
      ));

      if (count((array)$pk) > 0) {
        $ok = $ok && PindahkamarT::model()->updateAll(array(
          'masukkamar_id' => null,
        ), array(
          'condition' => 'pasienadmisi_id = ' . $admisi->pasienadmisi_id,
        ));
      }
      //var_dump($ok);

      $ok = $ok && MasukkamarT::model()->deleteAllByAttributes(array(
        'pasienadmisi_id' => $admisi->pasienadmisi_id,
      ));
      if (count((array)$pk) > 0) {
        $ok = $ok && PindahkamarT::model()->deleteAllByAttributes(array(
          'pasienadmisi_id' => $admisi->pasienadmisi_id,
        ));
      }
      //var_dump($ok);
      //$ok = $ok && PasienadmisiT::model()->deleteByPk($admisi->pasienadmisi_id);

      //var_dump($ok); die;
      return $ok;
    }
    // echo 'Kick';
    // die;
  }

  public function actionRencanaPulangPasienRI($idPasienadmisi)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $model = new RIPasienAdmisiT;
    $model->rencanapulang = date('Y-m-d H:i:s');
    $tersimpan = 'Tidak';

    $modelAdmisi = RIPasienAdmisiT::model()->findByPk($idPasienadmisi);
    $modPasien = RIPasienM::model()->findByPk($modelAdmisi->pasien_id);
    $modPendaftaran = RIPendaftaranT::model()->findByPk($modelAdmisi->pendaftaran_id);
    $modSuratKeterangan = new SuratketeranganR();
    $carabayar = "";
    $digitAwal = "40";
    $jenissurat_id = 2;
    $ruanganlainnya = true;

    if ($modelAdmisi->carabayar_id == 1) {
      $carabayar = "UMUM";
    } else if (($modelAdmisi->carabayar_id == 2 || $modelAdmisi->carabayar_id == 20)) {
      $carabayar = "BPJS";
    } else if ($modelAdmisi->carabayar_id == 3) {
      $carabayar = "ASURANSI";
    } else {
      $carabayar = "";
    }


    if ($modelAdmisi->carabayar_id == 1 && Yii::app()->user->getState('ruangan_id') == 361) {
      $jenissurat_id = 21;
      $digitAwal = "40";
      $ruanganlainnya = true;
    } else if (($modelAdmisi->carabayar_id == 2 || $modelAdmisi->carabayar_id == 20) && Yii::app()->user->getState('ruangan_id') == 361) {
      $jenissurat_id = 22;
      $digitAwal = "40";
      $ruanganlainnya = true;
    } else if ($modelAdmisi->carabayar_id == 3 && Yii::app()->user->getState('ruangan_id') == 361) {
      $jenissurat_id = 23;
      $digitAwal = "40";
      $ruanganlainnya = true;
    } else if ($modelAdmisi->carabayar_id == 1 && Yii::app()->user->getState('ruangan_id') != 361) {
      $jenissurat_id = 21;
      $digitAwal = "20";
      $ruanganlainnya = false;
    } else if (($modelAdmisi->carabayar_id == 2 || $modelAdmisi->carabayar_id == 20) && Yii::app()->user->getState('ruangan_id') != 361) {
      $jenissurat_id = 22;
      $digitAwal = "20";
      $ruanganlainnya = false;
    } else if ($modelAdmisi->carabayar_id == 3 && Yii::app()->user->getState('ruangan_id') != 361) {
      $jenissurat_id = 23;
      $digitAwal = "20";
      $ruanganlainnya = false;
    }


    $modSuratKeterangan->nomorsurat = MyGenerator::noSuratKeteranganRencPulang($digitAwal, $jenissurat_id, Yii::app()->user->getState('ruangan_id'), $carabayar, $ruanganlainnya);

    $tindakanPelayanan = TindakanpelayananT::model()->findAllByAttributes(array('pasienadmisi_id' => $modelAdmisi->pasienadmisi_id));
    $textTindakan = "";

    if (count($tindakanPelayanan) > 0) {
      foreach ($tindakanPelayanan as $i => $dataTindakan) {
        if ($i > 0) {
          $textTindakan .= "\n";
        }
        $textTindakan .= " - " . (isset($dataTindakan->daftartindakan) ? $dataTindakan->daftartindakan->daftartindakan_nama : "");
      }
    }
    $modSuratKeterangan->kontrolri_tindakan = $textTindakan;

    $criretia = new CDbCriteria();
    $criretia->addCondition('pasienadmisi_id = ' . $modelAdmisi->pasienadmisi_id);
    $criretia->order = 'reseptur_id DESC';
    $criretia->limit = 1;
    $reseptur = ResepturT::model()->find($criretia);
    $textReseptur = "";

    if (isset($reseptur)) {
      $resepturdet = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $reseptur->reseptur_id));

      if (count($resepturdet) > 0) {
        foreach ($resepturdet as $i => $dataResepturDet) {
          if ($i > 0) {
            $textReseptur .= "\n";
          }
          $textReseptur .= " - " . $dataResepturDet->obatalkes->obatalkes_nama . ' ' . $dataResepturDet->qty_reseptur . ' ' . (isset($dataResepturDet->satuankecil) ? $dataResepturDet->satuankecil->satuankecil_nama : "") . ' ' . $dataResepturDet->signa_reseptur;
        }
      }
    }

    $modSuratKeterangan->kontrolri_terapipulang = $textReseptur;

    if (isset($_POST['RIPasienAdmisiT'])) {
      $rencanapulang = $format->formatDateTimeForDb($_POST['RIPasienAdmisiT']['rencanapulang']);
      $pasien_id = $_POST['RIPasienAdmisiT']['pasienadmisi_id'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $update = RIPasienAdmisiT::model()->updateByPk($pasien_id, array('rencanapulang' => $rencanapulang));



        if ($update) {
          $kamarUpdate = true;
          if (!empty($modelAdmisi->kamarruangan_id)) {
            $kamarUpdate = KamarruanganM::model()->updateByPk($modelAdmisi->kamarruangan_id, array('keterangan_kamar' => Params::KETERANGANKAMAR_RENCANA_PULANG)); //'RENCANA PULANG'
          }

          $ok = $this->notifRencanaPulangpasien($modelAdmisi, $modPendaftaran, $modPasien);

          // var_dump($ok);

          if (!empty($_POST['RIPendaftaranT']['ruangankontrol_id'])) {

            if (isset($_POST['RIPendaftaranT']['ruangankontrol_id']) && isset($_POST['RIPendaftaranT']['tglrenkontrol'])) {
              $modPendaftaran->tglrenkontrol = MyFormatter::formatDateTimeForDb($_POST['RIPendaftaranT']['tglrenkontrol']);
              $modPendaftaran->ruangankontrol_id = $_POST['RIPendaftaranT']['ruangankontrol_id'];
              $modPendaftaran->doktertujuankontrol_id = isset($_POST['RIPendaftaranT']['doktertujuankontrol_id']) ? $_POST['RIPendaftaranT']['doktertujuankontrol_id'] : null;
              $kamarUpdate = $kamarUpdate && $modPendaftaran->save();

              if (!empty($modPendaftaran->ruangankontrol_id)) {
                if (isset($_POST['SuratketeranganR'])) {
                  $suratKeterangan = new SuratketeranganR();
                  $suratKeterangan->attributes = $_POST['SuratketeranganR'];
                  $suratKeterangan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                  $suratKeterangan->jenissurat_id = $jenissurat_id;
                  $suratKeterangan->tglsurat = date('Y-m-d');
                  $suratKeterangan->pasien_id = $modelAdmisi->pasien_id;
                  $suratKeterangan->profilrs_id = Yii::app()->user->getState('profilrs_id');
                  $suratKeterangan->ruangan_id = Yii::app()->user->getState('ruangan_id');
                  $suratKeterangan->judulsurat = "Surat Kontrol";
                  $suratKeterangan->nomorsurat = MyGenerator::noSuratKeteranganRencPulang($digitAwal, $jenissurat_id, Yii::app()->user->getState('ruangan_id'), $carabayar, $ruanganlainnya);
                  $suratKeterangan->nourutsurat = 1;
                  $suratKeterangan->create_loginpemakai_id = Yii::app()->user->id;
                  $suratKeterangan->create_ruangan = Yii::app()->user->getState('ruangan_id');
                  $suratKeterangan->mengetahui_surat = $modelAdmisi->pegawai->namaLengkap;
                  $suratKeterangan->jenissurat_id = Params::SURAT_KETERANGAN_KONTROL;

                  if ($modelAdmisi->carabayar_id == Params::CARABAYAR_ID_BPJS && Yii::app()->user->getState('isbridging') == true) {
                    // var_dump($_POST);
                    $suratKeterangan->jenissurat_id = 2;
                    $kode_dokter = "";
                    if (isset($_POST['RIPendaftaranT']['doktertujuankontrol_id'])) {
                      $dok = PegawaiM::model()->findByPk($_POST['RIPendaftaranT']['doktertujuankontrol_id']);
                      if (!empty($dok)) {
                        $kode_dokter = $dok->kodedokter_bpjs;
                      }
                    }
                    $poli = RuanganM::model()->findByPk($modPendaftaran->ruangankontrol_id);
                    $kontrol_poli = $poli->kode_bpjs;
                    $kontrol_tgl_rencana = date('Y-m-d', strtotime($modPendaftaran->tglrenkontrol));
                    $user = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                    $kontrol_user_res = empty($user) ? "" : trim($user->namaLengkap);
                    $kontrol_no_sep = isset($_POST['SepT']['nosep']) ? $_POST['SepT']['nosep'] : null;

                    $bpjs = new Bpjs_Vklaim;


                    // var_dump($modSurat->attributes); die;

                    if (!empty($suratKeterangan->nomorsurat_bpjs)) {
                      $res_kontrol = $bpjs->update_rencana_kontrol($suratKeterangan->nomorsurat_bpjs, $kontrol_no_sep, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res);
                    } else {
                      $res_kontrol = $bpjs->create_rencana_kontrol($kontrol_no_sep, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res);
                    }

                    $suratKeterangan->nosep = $kontrol_no_sep;
                    $suratKeterangan->polikontrol = $kontrol_poli;
                    $suratKeterangan->ruanganpolitujuan_id = $poli->ruangan_id;


                    if (!$res_kontrol) {
                      $vclaim_msg = "Note : Ada kesalahan ketika membuat rencana kontrol";
                    }
                    $res_json = CJSON::decode($res_kontrol);

                    if ($res_json['metaData']['code'] != 200) {
                      $vclaim_msg = "Note : " . $res_json['metaData']['message'];
                      $suratKeterangan->respon_bpjs = CJSON::encode($res_json);
                      if (!empty($suratKeterangan->nomorsurat_bpjs)) {
                        $this->logBpjs($modelAdmisi, $res_json, $bpjs->server_new['update_rencana_kontrol']);
                      } else {
                        $this->logBpjs($modelAdmisi, $res_json, $bpjs->server_new['create_rencana_kontrol']);
                      }
                    } else {
                      if (!empty($suratKeterangan->nomorsurat_bpjs)) {
                        $this->logBpjs($modelAdmisi, $res_json, $bpjs->server_new['update_rencana_kontrol']);
                      } else {
                        $this->logBpjs($modelAdmisi, $res_json, $bpjs->server_new['create_rencana_kontrol']);
                      }
                      $suratKeterangan->nomorsurat_bpjs = $res_json['response']['noSuratKontrol'];
                      if (empty($suratKeterangan->respon_bpjs)) {
                        $suratKeterangan->respon_bpjs = CJSON::encode($res_json['response']);
                      }
                    }

                    //var_dump($res_json);


                    // var_dump($kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res, $kontrol_no_sep);

                  }
                  // var_dump($suratKeterangan->attributes); die;

                  
                  $suratKeterangan->save();
                  
                }
                //									$this->simpanSKKontrol($modPendaftaran, $modPendaftaran->ruangankontrol_id);
              }
            }


            $r = RuanganM::model()->findByPk($_POST['RIPendaftaranT']['ruangankontrol_id']);

            $judul = 'Rencana Kontrol Pasien';
            //$isi =  'Pasien '.$modPasien->nama_pasien. ' dengan nomor rekam medik '.$modPasien->no_rekam_medik.'<br/> telah membuat rencana kontrol untuk tanggal '.MyFormatter::formatDateTimeForUser($_POST['RIPendaftaranT']['tglrenkontrol']).
            //      ' ke ruangan '.$r->ruangan_nama;
            $isi = $modPasien->no_rekam_medik . ' ' . $modPasien->nama_pasien . ' '
              .  MyFormatter::formatDateTimeForUser($_POST['RIPendaftaranT']['tglrenkontrol']) . ' ' . $r->ruangan_nama . ' ';

            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
              array('instalasi_id' => Params::INSTALASI_ID_RI, 'ruangan_id' => $_POST['RIPendaftaranT']['ruangankontrol_id'], 'modul_id' => Params::MODUL_ID_RJ),
              array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
            ));
            //var_dump($ok);die;
          }
          //						exit();
          // die;
          if ($kamarUpdate) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil disimpan ");
            $tersimpan = 'Ya';
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . $vclaim_msg);
            $tersimpan = 'Tidak';
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan", MyExceptionMessage::getMessage($exc, false));
      }
    }

    $model->rencanapulang = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($model->rencanapulang, 'yyyy-MM-dd hh:mm:ss')
    );

    $this->render('formRencanaPulang', array(
      'modelAdmisi' => $modelAdmisi,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
      'model' => $model,
      'tersimpan' => $tersimpan,
      'modSuratKeterangan' => $modSuratKeterangan
    ));
  }

  public function actionBatalRencanaPulangPasienRI()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;

      $modelAdmisi = RIPasienAdmisiT::model()->findByPk($pasienadmisi_id);
      $modPasien = RIPasienM::model()->findByPk($modelAdmisi->pasien_id);
      $modPendaftaran = RIPendaftaranT::model()->findByPk($modelAdmisi->pendaftaran_id);
      $transaction = Yii::app()->db->beginTransaction();

      try {
        $update = RIPasienAdmisiT::model()->updateByPk($pasienadmisi_id, array('rencanapulang' => null));
        //var_dump($update);
        if ($update) {
          $kamarUpdate = true;
          if (!empty($modelAdmisi->kamarruangan_id)) {
            $kamarUpdate = KamarruanganM::model()->updateByPk($modelAdmisi->kamarruangan_id, array('keterangan_kamar' => Params::KETERANGANKAMAR_DIGUNAKAN)); //'RENCANA PULANG'
          }
          $ok = $this->notifBatalRencanaPulangpasien($modelAdmisi, $modPendaftaran, $modPasien);

          if ($kamarUpdate) {
            $data['sukses'] = 1;
            $data['pesan'] = ' Rencana pulang pasien berhasil dibatalkan ';
            $transaction->commit();
          } else {
            $data['sukses'] = 0;
            $data['pesan'] = ' Rencana 3 pulang pasien gagal dibatalkan ';
            $transaction->rollback();
          }
        } else {
          $data['sukses'] = 0;
          $data['pesan'] = ' Rencana 2 pulang pasien gagal dibatalkan ';
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        //print_r($exc);
        $data['sukses'] = 0;
        $data['pesan'] = ' Rencana 1 pulang pasien gagal dibatalkan ';
        $transaction->rollback();
      }

      echo json_encode($data);
    }
    Yii::app()->end();
  }


  public function notifRencanaPulangpasien($modelAdmisi, $modPendaftaran, $modPasien)
  {

    $ruangan = RuanganM::model()->findByPk($modelAdmisi->ruangan_id);
    $kamar = KamarruanganM::model()->findByPk($modelAdmisi->kamarruangan_id);

    $judul = 'Rencana Pulang Pasien Rawat Inap';


    $ruangan_nama = empty($ruangan) ? "-" : $ruangan->ruangan_nama;
    $no_bed = empty($kamar) ? "-" : $kamar->kamarruangan_nobed;

    $isi = $modPasien->no_rekam_medik . ' ' . $modPasien->nama_pasien . '<br/>'
      .  'Ruangan ' . $ruangan_nama . ' Bed ' . $no_bed . '<br/>' .
      "Rencana Pulang " . MyFormatter::formatDateTimeForUser($modelAdmisi->rencanapulang);

    $isi_plus = $isi;
    $arr = array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'pasienadmisi_id' => $modelAdmisi->pasienadmisi_id,
      'instalasi_id' => Params::INSTALASI_ID_RI,
    );
    $isi_plus .= CHtml::link('<br/><u>Klik ini untuk melakukan pembayaran.</u>', Yii::app()->createUrl('/billingKasir/PembayaranTagihanPasien/index', $arr));

    // var_dump($judul, $isi, $modelAdmisi->attributes); die;

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK),
    ));
    $ok = $ok && CustomFunction::broadcastNotif($judul, $isi_plus, array(
      array('instalasi_id' => Params::INSTALASI_ID_KEUANGAN, 'ruangan_id' => Params::RUANGAN_ID_KASIR, 'modul_id' => Params::MODUL_ID_BILLINGKASIR),
    ));

    return $ok;
  }

  public function notifBatalRencanaPulangpasien($modelAdmisi, $modPendaftaran, $modPasien)
  {

    $ruangan = RuanganM::model()->findByPk($modelAdmisi->ruangan_id);
    $kamar = KamarruanganM::model()->findByPk($modelAdmisi->kamarruangan_id);

    $judul = 'Batal Rencana Pulang Pasien Rawat Inap';

    $ruangan_nama = empty($ruangan) ? "-" : $ruangan->ruangan_nama;
    $no_bed = empty($kamar) ? "-" : $kamar->kamarruangan_nobed;

    $isi = $modPasien->no_rekam_medik . ' ' . $modPasien->nama_pasien . '<br/>'
      .  'Ruangan ' . $ruangan_nama . ' Bed ' . $no_bed . '<br/>' .
      "Batal Rencana Pulang " . MyFormatter::formatDateTimeForUser(date('Y-m-d'));

    return CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK),
      array('instalasi_id' => Params::INSTALASI_ID_KEUANGAN, 'ruangan_id' => Params::RUANGAN_ID_KASIR, 'modul_id' => Params::MODUL_ID_BILLINGKASIR),
    ));
  }


  /**
   * untuk load form masuk kamar pasien
   * Issue  : RND-2717
   * Date   : 24 September 2014
   */
  public function actionAddMasukKamarRI()
  {
    $pendaftaran_id = (isset(Yii::app()->session['pendaftaran_id']) ? Yii::app()->session['pendaftaran_id'] : null);
    $kamarruangan_id = (isset($_POST['kamarruangan_id']) ? $_POST['kamarruangan_id'] : null);
    $masukkamar_id = (isset(Yii::app()->session['masukkamar_id']) ? Yii::app()->session['masukkamar_id'] : null);
    $kelaspelayanan_id = (isset(Yii::app()->session['kelaspelayanan_id']) ? Yii::app()->session['kelaspelayanan_id'] : null);
    $ruangan_id = Yii::app()->user->getState('ruangan_id');

    //var_dump($kamarruangan_id);        
    $cekMasukKamar = null;
    if (isset($masukkamar_id)) {
      $modMasukKamar = MasukkamarT::model()->findByPk($masukkamar_id);
      $cekMasukKamar = MasukkamarT::model()->findByPk($masukkamar_id);
    } else {
      $modMasukKamar = new MasukkamarT();
    }
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

    $modMasukKamar->ruangan_id = (!empty($modMasukKamar->ruangan_id) ? $modMasukKamar->ruangan_id : $ruangan_id); //$kamarruangan_id

    $modMasukKamar->tglmasukkamar = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
    $modMasukKamar->jammasukkamar = date('H:i:s');

    $modDataPasien = PasienrawatinapV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    if (isset($_POST['MasukkamarT'])) {
      // $trans = Yii::app()->db->beginTransaction();
      // var_dump($_POST);
      $modMasukKamar->attributes =  $_POST['MasukkamarT'];
      $modMasukKamar->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
      $modMasukKamar->carabayar_id = $modPasienAdmisi->carabayar_id;
      $modMasukKamar->penjamin_id = $modPasienAdmisi->penjamin_id;
      $modMasukKamar->pegawai_id = $modPasienAdmisi->pegawai_id;
      $modMasukKamar->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
      $modMasukKamar->nomasukkamar = MyGenerator::noMasukKamar($modMasukKamar->ruangan_id);
      $modMasukKamar->shift_id = Yii::app()->user->getState('shift_id');
      if (!empty($cekMasukKamar)) {
        $modMasukKamar->update_time = date('Y-m-d H:i:s');
        $modMasukKamar->update_loginpemakai_id = Yii::app()->user->id;
      } else {
        $modMasukKamar->create_time = date('Y-m-d H:i:s');
        $modMasukKamar->create_loginpemakai_id = Yii::app()->user->id;
        $modMasukKamar->create_ruangan = Yii::app()->user->getState('ruangan_id');
      }
      // $cekMasukKamar->kamarruangan_id = null;

      $modMasukKamar->tglmasukkamar = MyFormatter::formatDateTimeForDB($modMasukKamar->tglmasukkamar) . " " . $modMasukKamar->jammasukkamar;

      if (!empty($cekMasukKamar->kamarruangan_id)) {
        $modMasukKamar->tglmasukkamar = $cekMasukKamar->tglmasukkamar;
        $modMasukKamar->jammasukkamar = $cekMasukKamar->jammasukkamar;
      }

      // var_dump($modMasukKamar->tglmasukkamar, $modMasukKamar->jammasukkamar, $_POST); die;

      $kamarruanganidupdate = isset($_POST['MasukkamarT']['kamarruangan_id']) ? $_POST['MasukkamarT']['kamarruangan_id'] : null;
      //            $cekidkamar = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
      $cekidkamar = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));



      //if(empty($kamarruanganidupdate)){ 
      PasienadmisiT::model()->updateByPk($cekidkamar->pasienadmisi_id, array('kamarruangan_id' => $kamarruanganidupdate));
      // var_dump($modDataPasien->kamarruangan_id); die;
      if (!empty($modDataPasien->kamarruangan_id)) {
        KamarruanganM::model()->updateByPk($modDataPasien->kamarruangan_id, array('kamarruangan_status' => true, 'keterangan_kamar' => Params::KETERANGANKAMAR_TERSEDIA)); //'OPEN'
      }
      //}
      if ($modMasukKamar->save()) {
        if (!empty($kamarruanganidupdate)) {
          KamarruanganM::model()->updateByPk($kamarruanganidupdate, array('kamarruangan_status' => false, 'keterangan_kamar' => Params::KETERANGANKAMAR_DIGUNAKAN)); //'IN USE'
        }

        $str_akomodasi = "";
        if (Yii::app()->user->getState('akomodasiotomatis')) {
          self::saveAkomodasi($modPendaftaran, $modPasienAdmisi);
          $str_akomodasi = "<div class='flash-success'>Akomodasi Rawat Inap berhasil ditambahkan ! </div>";
        }


        // die;
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data Pasien berhasil disimpan </div>",
            'notif_akomodasi' => $str_akomodasi,
          ));
          exit;
        }
      } else {

        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
          ));
          exit;
        }
      }
    }
    if (Yii::app()->request->isAjaxRequest) {

      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formMasukKamar', array('modMasukKamar' => $modMasukKamar, 'modDataPasien' => $modDataPasien), true)
      ));
      exit;
    }
  }

  /**
   * untuk load session masuk kamar
   */
  public function actionBuatSessionMasukKamar()
  {

    $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
    $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
    if (!empty($_POST['masukkamar_id'])) {
      $masukkamar_id = (isset($_POST['masukkamar_id']) ? $_POST['masukkamar_id'] : null);
      Yii::app()->session['masukkamar_id'] = $masukkamar_id;
    }
    Yii::app()->session['kelaspelayanan_id'] =  $kelaspelayanan_id;
    Yii::app()->session['pendaftaran_id'] =  $pendaftaran_id;
    Yii::app()->session['masukkamar_id'] = $masukkamar_id;

    echo CJSON::encode(array(
      'kelaspelayanan_id' => Yii::app()->session['kelaspelayanan_id'],
      'pendaftaran_id' => Yii::app()->session['pendaftaran_id'],
      'masukkamar_id' => Yii::app()->session['masukkamar_id']
    ));
  }

  /**
   * Mengatur dropdown kabupaten
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropDownKondisiKeluar($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $model = new RIPasienPulangT;
      if ($model_nama !== '' && $attr == '') {
        $carakeluar_id = $_POST["$model_nama"]['carakeluar_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $carakeluar_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $carakeluar_id = $_POST["$model_nama"]["$attr"];
      }
      $kondisikeluar = null;
      if ($carakeluar_id) {
        $kondisikeluar = $model->getKondisikeluarItems($carakeluar_id);
        $kondisikeluar = CHtml::listData($kondisikeluar, 'kondisikeluar_id', 'kondisikeluar_nama');
      }
      if ($encode) {
        echo CJSON::encode($kondisikeluar);
      } else {
        if (empty($kondisikeluar)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kondisikeluar as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionGetKelasPelayanan($encode = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $kelaspelayanan = array();
      if (!empty($ruangan_id)) {
        $kelasRuangan = KelasruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id));

        foreach ($kelasRuangan as $key => $value) {
          $kelaspelayanan[$key] = KelaspelayananM::model()->findByPk($value->kelaspelayanan_id);
        }
        $kelaspelayanan = CHtml::listData($kelaspelayanan, 'kelaspelayanan_id', 'kelaspelayanan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kelaspelayanan);
      } else {
        if (empty($kelaspelayanan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
          foreach ($kelaspelayanan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Mengatur dropdown kasus penyakit
   */
  public function actionSetDropdownKasusPenyakit()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;

      $jeniskasuspenyakit = JeniskasuspenyakitM::model()->findAll('jeniskasuspenyakit_aktif = TRUE ORDER BY jeniskasuspenyakit_nama');
      $jeniskasuspenyakit = CHtml::listData($jeniskasuspenyakit, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');

      $jeniskasuspenyakitOptions = CHtml::dropDownList('jeniskasuspenyakit_id', '', $jeniskasuspenyakit, array("onchange" => "saveKasusPenyakit(this,$pendaftaran_id,$pasienadmisi_id)", "style" => "width:140px;", "options" => array($jeniskasuspenyakit_id => array("selected" => true))));

      $dataList['kasusPenyakit'] = $jeniskasuspenyakitOptions;

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }
  /**
   * Mengatur dropdown kasus penyakit
   */
  public function actionSaveKasusPenyakit()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;
      $pesan = 'gagal';

      $update = RIPendaftaranT::model()->updateByPk($pendaftaran_id, array('jeniskasuspenyakit_id' => $jeniskasuspenyakit_id));
      $updateadmisi = PasienadmisiT::model()->updateByPk($pasienadmisi_id, array('spesialis_id' => $jeniskasuspenyakit_id));
      if ($update) {
        $pesan = 'berhasil';
      } else {
        $pesan = 'gagal';
      }
      $data['pesan'] = $pesan;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  function actionApproveAlihDPJP()
  {
    $ubahdokter_id = $_POST['ubahdokter_id'];
    $data['sukses'] = 0;

    $modUbahDokter = UbahdokterR::model()->findByPk($_POST['ubahdokter_id']);

    $dokterLama = PegawaiM::model()->findByPk($modUbahDokter->dokterlama_id);
    $dokterBaru = PegawaiM::model()->findByPk($modUbahDokter->dokterbaru_id);
    $modPendaftaran = PendaftaranT::model()->findByPk($modUbahDokter->pendaftaran_id);
    $modPemindahan = PemindahanpasienT::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
    $update = UbahdokterR::model()->updateByPk($ubahdokter_id, [
      'is_approve' => true
    ]);
    if ($update) {
      $updateAdmisi = PasienadmisiT::model()->updateByPk($modPendaftaran->pasienadmisi_id, [
        'pegawai_id' => $modUbahDokter->dokterbaru_id
      ]);

      if ($updateAdmisi) {
        $judul = 'Persetujuan Pengalihan DPJP';
        $isi = 'Pengalihan DPJP Disetujui Dari ' . $dokterLama->namaLengkap . ' Ke ' . $dokterBaru->namaLengkap;

        if (!empty($modPemindahan)) {
          CustomFunction::broadcastNotif($judul, $isi, array(
            array(
              'instalasi_id' => Yii::app()->user->getState('instalasi_id'),
              'ruangan_id' => $modPemindahan->ruangantujuan_id,
              'modul_id' => 7,
              // 'link_proses' => $link_rj
            ),
            array(
              'instalasi_id' => Yii::app()->user->getState('instalasi_id'),
              'ruangan_id' => $modPemindahan->ruanganasal_id,
              'modul_id' => 7,
              // 'link_proses' => $link_rj
            )
          ));
        } else {
          CustomFunction::broadcastNotif($judul, $isi, array(
            array(
              'instalasi_id' => Yii::app()->user->getState('instalasi_id'),
              'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
              'modul_id' => 7,
              // 'link_proses' => $link_rj
            )
          ));
        }
        $data['sukses'] = 1;
        $data['msg'] = 'Berhasil Disetujui';
      }
    } else {
      $data['msg'] = 'Gagal Disetujui';
    }

    echo json_encode($data);
  }

  function actionRejectedAlihDPJP($ubahdokter_id)
  {
    $this->layout = '//layouts/iframe';
    $modUbahDokter = UbahdokterR::model()->findByPk($ubahdokter_id);
    $dokterLama = PegawaiM::model()->findByPk($modUbahDokter->dokterlama_id);
    $dokterBaru = PegawaiM::model()->findByPk($modUbahDokter->dokterbaru_id);

    if (isset($_POST['UbahdokterR'])) {
      $modUbahDokter->keterangan = $_POST['UbahdokterR']['keterangan'];
      $modUbahDokter->is_approve = false;
      $modUbahDokter->update_time = $_POST['UbahdokterR']['tglubahdokter'];


      if ($modUbahDokter->save()) {
        $judul = 'Persetujuan Pengalihan DPJP';
        $isi = 'Pengalihan DPJP Ditolak Dari '
          . $dokterLama->namaLengkap . ' Ke ' . $dokterBaru->namaLengkap
          . '<br> <b>Dengan Alasan </b> :' . $modUbahDokter->keterangan;
        CustomFunction::broadcastNotif($judul, $isi, array(
          array(
            'instalasi_id' => Yii::app()->user->getState('instalasi_id'),
            'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
            'modul_id' => 7,
            // 'link_proses' => $link_rj
          )
        ));
        Yii::app()->user->setFlash('success', "Data berhasil update");
        $this->redirect(array('RejectedAlihDPJP', 'ubahdokter_id' => $modUbahDokter->ubahdokter_id, 'sukses' => 1));
      }
    }

    $modUbahDokter->keterangan = '';
    $this->render('_formPenolakanDisposAlihLeader', [
      'modUbahDokter' => $modUbahDokter
    ]);
  }

  public function actionAlihDPJP($pendaftaran_id = null)
  {

    $this->layout = '//layouts/iframe';

    $modUbahDokter = new UbahdokterR;
    $modAlihLeader = new UbahdokterR();

    // var_dump($pendaftaran_id);die;
    $modRiwayatUbahDokter = UbahdokterR::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id], ['order' => 'create_time desc']);

    // var_dump($pendaftaran_id);die;
    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

    if (!empty($modAdmisi)) {
      $modUbahDokter->dokterlama_id = $modAdmisi->pegawai_id;
      $modUbahDokter->dokterlama_nama = $modAdmisi->pegawai->namaLengkap;
      $modPendaftaran->nama_pasien = $modPendaftaran->pasien->nama_pasien;
      $modPendaftaran->alamat_pasien = $modPendaftaran->pasien->alamat_pasien;
      $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
      $modPendaftaran->no_rekam_medik = $modPendaftaran->pasien->no_rekam_medik;


      // tab alih leader
      $modAlihLeader->dokterlama_nama = $modAdmisi->pegawai->namaLengkap;
      $modAlihLeader->dokterlama_id = $modAdmisi->pegawai_id;

      // echo '<pre>';
      // var_dump($modPendaftaran->pegawai->spesialissubspesialis);die;
      if (!empty($modPendaftaran->pegawai->spesialissubspesialis_id)) {
        $modSpesialissub = SpesialissubspesialisM::model()->findByPk($modPendaftaran->pegawai->spesialissubspesialis_id);
        if (!empty($modSpesialissub)) {
          $modAlihLeader->spesialissubspesialis_nama = $modSpesialissub->spesialissubspesialis_nama ?? '';
        }
      }
    }

    if (empty($modPendaftaran)) {
      $modPendaftaran = new RIPendaftaranT();
    }

    if (isset($_POST['RIPendaftaranT'])) {
      // echo '<pre>';var_dump($_POST);die;
      $transaction = Yii::app()->db->beginTransaction();

      if (isset($_POST['formalihleader'])) {
        if ($_POST['UbahdokterR']['dokterbaru_id'] != "") {
          $modUbahDokter->attributes = $_POST['UbahdokterR'];
          $modUbahDokter->pendaftaran_id = $_POST['RIPendaftaranT']['pendaftaran_id'];
          $modUbahDokter->tglubahdokter = MyFormatter::formatDateTimeForDb($_POST['tglubahdokter']);
          $modUbahDokter->create_time = date('Y-m-d H:i:s');
          $modUbahDokter->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $modUbahDokter->alasanperubahandokter = 'ALIH LEADER';
          $modUbahDokter->keterangan = 'ALIH LEADER';
          try {

            if ($modUbahDokter->save()) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', 'Data Berhasil Disimpan !');
              $this->redirect(array('alihDPJP', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan !');
            }
          } catch (Exception $exc) {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan {3}!');
          }
        }
      }
    }


    $this->render($this->path_view . '_formAlihDPJP', array(
      'modPendaftaran' => $modPendaftaran,
      'modUbahDokter' => $modUbahDokter,
      'modDokter' => $modUbahDokter,
      'modRiwayatUbahDokter' => $modRiwayatUbahDokter,
      'modAlihLeader' => $modAlihLeader,
    ));
  }

  /**
   * untuk Ubah Dokter
   */
  public function actionUbahDokterPeriksa($pendaftaran_id, $pasienadmisi_id)
  {
    $this->layout = '//layouts/iframe';
    $model = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($model->pasien_id);
    $modAdmisi = RIPasienAdmisiT::model()->findByPk($pasienadmisi_id);
    $modUbahDokter = RIUbahdokterR::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id], ['order' => 'tglubahdokter desc']);


    if (empty($modAdmisi)) {
      $modAdmisi = new RIPasienAdmisiT();
    }
    if (empty($modUbahDokter)) {
      $modUbahDokter = new RIUbahdokterR();
      $modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
    }

    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    if (isset($_POST['RIPendaftaranT'])) {
      // echo '<pre>';var_dump($_POST);die;
      if ($_POST['RIPendaftaranT']['pegawai_id'] != "") {

        $admisi = RIPasienAdmisiT::model()->findByPk($_POST['RIPendaftaranT']['pasienadmisi_id']);

        $model->attributes = $_POST['RIPendaftaranT'];
        $modUbahDokter->attributes = $_POST['RIUbahdokterR'];
        $modUbahDokter->pendaftaran_id = $_POST['RIPendaftaranT']['pendaftaran_id'];
        // $modUbahDokter->dokterbaru_id = $_POST['RIPendaftaranT']['pegawai_id'];
        $modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
        $modUbahDokter->create_time = date('Y-m-d H:i:s');
        $modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
        $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modUbahDokter->pasienadmisi_id = $admisi->pasienadmisi_id;

        // print_r($modUbahDokter->attributes); 
        // print_r($_POST['RIPendaftaranT']['pegawai_id']);

        $pegawais = $_POST['RIPendaftaranT']['pegawai_id'];

        $transaction = Yii::app()->db->beginTransaction();
        try {

          $ok = true;

          foreach ($pegawais as $param => $item) {
            if (!empty($item)) {
              $ok = $ok && $this->simpanUbahDokters($modUbahDokter, $admisi, $param, $item);
            }
          }


          if ($ok) {
            $modUbahDokter->save();
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil update");
            $this->redirect(array('ubahDokterPeriksa', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'sukses' => 1));
          } else {
            Yii::app()->user->setFlash('error', "Data gagal update");
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
        }
      }
    }

    $this->render('_formUbahDokterPeriksa', array('model' => $model, 'modAdmisi' => $modAdmisi, 'modUbahDokter' => $modUbahDokter, 'menu' => $menu, 'modPasien' => $modPasien));
  }

  public function simpanUbahDokters($modUbahDokter, $admisi, $param, $item)
  {
    $ok = true;
    $dpjp = array(
      'pegawai_id' => 1,
      'dpjp2_id' => 2,
      'dpjp3_id' => 3,
      'dpjp4_id' => 4,
      'dpjp5_id' => 5,

    );

    $model = new RIUbahdokterR;
    $model->attributes = $modUbahDokter->attributes;
    $model->dokterlama_id = $admisi[$param];
    $model->dokterbaru_id = $item;
    $model->dpjp = $dpjp[$param];

    if ($model->dokterlama_id == $model->dokterbaru_id) return true;

    if ($model->validate()) {
      $ok = $ok && $model->save();
    } else $ok = false;


    if ($param == 'pegawai_id') {
      $masukkamar = RIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id' => $admisi->pasienadmisi_id));
      if (!empty($masukkamar)) {
        RIMasukKamarT::model()->updateByPk($masukkamar->masukkamar_id, array('pegawai_id' => $item));
      }
    }

    PasienadmisiT::model()->updateByPk($admisi->pasienadmisi_id, array($param => $item));

    // print_r($model->attributes);

    return true;
  }

  public function actionGetDataPendaftaranRI()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id_pendaftaran = $_POST['pendaftaran_id'];
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $model = InfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran, 'pasienadmisi_id' => $pasienadmisi_id));
      $modPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
        $returnVal["gelarbelakang_nama"] = isset($model->gelarbelakang_nama) ? $model->gelarbelakang_nama : "";
        $returnVal["gelardepan"] = isset($model->gelardepan) ? $model->gelardepan : "";
        $returnVal["pegawai_id"] = isset($modPasienAdmisi->pegawai_id) ? $modPasienAdmisi->pegawai_id : null;

        if (!empty($model->dpjp1_id)) {
          $peg = PegawaiM::model()->findByPk($model->dpjp1_id);
          $returnVal['dpjp1'] = $peg->namaLengkap;
        }
        if (!empty($model->dpjp2_id)) {
          $peg = PegawaiM::model()->findByPk($model->dpjp2_id);
          $returnVal['dpjp2'] = $peg->namaLengkap;
        }
        if (!empty($model->dpjp3_id)) {
          $peg = PegawaiM::model()->findByPk($model->dpjp3_id);
          $returnVal['dpjp3'] = $peg->namaLengkap;
        }
        if (!empty($model->dpjp4_id)) {
          $peg = PegawaiM::model()->findByPk($model->dpjp4_id);
          $returnVal['dpjp4'] = $peg->namaLengkap;
        }
        if (!empty($model->dpjp5_id)) {
          $peg = PegawaiM::model()->findByPk($model->dpjp5_id);
          $returnVal['dpjp5'] = $peg->namaLengkap;
        }
      }
      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }

  public function actionListDokterRuangan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (!empty($_POST['idRuangan'])) {
        $idRuangan = $_POST['idRuangan'];
        $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array('order' => 'nama_pegawai'));
        $data = CHtml::listData($data, 'pegawai_id', 'nama_pegawai');

        if (empty($data)) {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
            $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        $dataList['listDokter'] = $option;
      } else {
        $dataList['listDokter'] = $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      }

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * untuk print data penjualan dokter
   */
  public function actionPrintPasienPulang($pasienpulang_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPulang = RIPasienPulangT::model()->findByPk($pasienpulang_id);
    $modMasukKamar = RIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id' => $modPulang->pasienadmisi_id));
    $modPasien = RIPendaftaranT::model()->findByAttributes(array('pasienadmisi_id' => $modPulang->pasienadmisi_id));

    $judul_print = 'Pasien Pulang';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    if ($modPulang->carakeluar_id == Params::CARAKELUAR_ID_MENINGGAL) {
      $view = "printMeninggal";

      $judul_print = "Pasien Meninggal";
    } else {
      $view = "Print";
    }

    $this->render($this->path_view . $view, array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPulang' => $modPulang,
      'modMasukKamar' => $modMasukKamar,
      'modPasien' => $modPasien
    ));
  }

  public function actionPrintPasienKontrol($pasienpulang_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPulang = RIPasienPulangT::model()->findByPk($pasienpulang_id);
    $modMasukKamar = RIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id' => $modPulang->pasienadmisi_id));
    $modPendaftaran = RIPendaftaranT::model()->findByAttributes(array('pasienadmisi_id' => $modPulang->pasienadmisi_id));
    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = RIPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    $sk = SuratketeranganR::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'jenissurat_id' => Params::SURAT_KETERANGAN_KONTROL,
    ));

    $judul_print = 'Pasien Kontrol';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render('printKontrol', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPulang' => $modPulang,
      'modMasukKamar' => $modMasukKamar,
      'modPasien' => $modPasien,
      'modAdmisi' => $modAdmisi,
      'modPendaftaran' => $modPendaftaran,
      'sk' => $sk,
    ));
  }

  /**
   * - digunakan untuk mencetak prinout pasien rencana kontrol di form rencana pulang
   * @param type $pasienpulang_id
   * @param type $caraPrint
   */
  public function actionPrintPasienKontrolRencana($pasienadmisi_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modMasukKamar = RIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));
    $modPendaftaran = RIPendaftaranT::model()->findByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));
    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = RIPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    $sk = SuratketeranganR::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'jenissurat_id' => Params::SURAT_KETERANGAN_KONTROL,
    ));

    $judul_print = 'Pasien Kontrol';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render('printKontrol', array(
      'format' => $format,
      'judul_print' => $judul_print,
      //'modPulang'=>$modPulang,
      'modMasukKamar' => $modMasukKamar,
      'modPasien' => $modPasien,
      'modAdmisi' => $modAdmisi,
      'modPendaftaran' => $modPendaftaran,
      'sk' => $sk,
    ));
  }

  /**
   * Tampil dialog label gelang pasien
   */
  public function actionLabelGelang()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $datatable = '';
    $pendaftaran_id = $_GET['pendaftaran_id'];
    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $this->render('_labelGelang', array(
      'modPendaftaran' => $modPendaftaran,
    ));
  }

  /*public function actionPrintLabelGelang($pendaftaran_id) 
        {
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;
            $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);

            $judul_print = 'Label Gelang';
            $this->render('printLabelGelang', array(
                                'modPendaftaran'=>$modPendaftaran
            ));
        }*/

  /**
   * generate print label gelang
   * @param type $pendaftaran_id
   */
  public function actionPrintLabelGelang($pendaftaran_id)
  {

    $format = new MyFormatter();
    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);

    $judul_print = '';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      //            $this->layout='//layouts/printWindows';
    }
    $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
    $posisi = 'P'; //Posisi L->Landscape,P->Portait
    if ($modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_DEWASA) {
      // panjang : 20 -> 2cm , lebar: 118 ->11,8 cm
      $mpdf = new MyPDF60('', array(25, 105));
    } else if ($modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_ANAK) {
      // panjang : 20 -> 2cm , lebar: 40->4 cm
      $mpdf = new MyPDF60('', array(25, 40));
    } else if ($modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_BAYI || $modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_BARU_LAHIR) {
      // panjang : 20 -> 2cm , lebar: 40->4 cm
      $mpdf = new MyPDF60('', array(25, 40));
    }
    // ob_clean();
    // $mpdf->mirrorMargins = 0;
    $mpdf = new MyPDF60('', array(25, 105));
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
    $mpdf->SetHTMLFooter('<span></span>');
    $mpdf->WriteHTML(
      $this->renderPartial('printLabelGelangV2', array(
        'format' => $format,
        'modPendaftaran' => $modPendaftaran,
      ), true)
    );
    $mpdf->SetJS('this.print();');
    $mpdf->Output();
  }



  public function actionGetKamarKosong($encode = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_POST['kelaspelayanan_id'])) {
        $ruangan_id = $_POST['ruangan_id'];
        $kelaspelayanan_id = ($_POST['kelaspelayanan_id'] == '' ? 0 : $_POST['kelaspelayanan_id']);

        $kamarKosong = array();
        if (!empty($ruangan_id)) {

          if (isset($_POST['all_kamar'])) {
            $kamarKosong = KamarruanganM::model()->findAllByAttributes(
              array(
                'ruangan_id' => $ruangan_id,
                'kelaspelayanan_id' => $kelaspelayanan_id,
                'kamarruangan_aktif' => true,
              )
            );
          } else {
            $kamarKosong = KamarruanganM::model()->findAllByAttributes(
              array(
                'ruangan_id' => $ruangan_id,
                'kelaspelayanan_id' => $kelaspelayanan_id,
                'kamarruangan_status' => (isset($_POST['is_status']) ? $_POST['is_status'] : true),
                'kamarruangan_aktif' => true,
              )
            );
          }


          $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidurInUseV2');
        }
      } else {
        $ruangan_id = $_POST['ruangan_id'];
        $kamarKosong = array();
        if (!empty($ruangan_id)) {
          $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_status' => true));
          $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidur');
        }
      }

      if ($encode) {
        echo CJSON::encode($kamarKosong);
      } else {
        if (empty($kamarKosong)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
        } else {
          if (count((array)$kamarKosong) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
          }
          foreach ($kamarKosong as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionVerifikasiRencanaPulang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $data['pesan'] = '';
      $data['verifikasinull'] = '';
      $data['isalert'] = 0;
      $data['isnotif'] = 0;
      $modRencanaTindakan = RencanatindakanT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'rencanatindakan_id DESC'));
      if (!empty($modRencanaTindakan)) {
        $data['status'] = true;
        $data['pesan'] = "";
        if (empty($modRencanaTindakan->verifrenctindakan_id)) {
          $data['verifikasinull'] = 'ya';
          $data['pesan'] = "Tindakan Pasien Belum Di-Verifikasi";
        }
      } else {
        if (empty($status)) {

          $data = $this->verifikasiTindakanRawatInap($pendaftaran_id, $data);
        } else {
          $data['status'] = true;
          $data['pesan'] = '';
        }
      }

      if($status == 'pulang') {
        // cek resume medis
        $criteria = new CDbCriteria();
        $criteria->join = 'JOIN ruangan_m r on r.ruangan_id = t.create_ruangan';
        $criteria->addCondition('t.pendaftaran_id=' . $pendaftaran_id);
        $criteria->addCondition('t.pasienadmisi_id is not null');
        $criteria->addInCondition('r.instalasi_id', Params::INSTALASI_ID_RI_ARR);
        $modResume = ResumemedisR::model()->findAll($criteria);
        if(empty($modResume)) {
          $data['status'] = true;
          $data['verifikasinull'] = 'ya';
          $data['pesan'] = 'Resume medis belum diterbitkan oleh dokter';
        }
      }
     
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  function actionVerifikasiMeninggal() {
    // cek resume medis
    $pendaftaran_id = $_POST['pendaftaran_id'];
    $pasienadmisi_id = $_POST['pasienadmisi_id'];

    $criteria = new CDbCriteria();
    $criteria->join = 'JOIN ruangan_m r on r.ruangan_id = t.create_ruangan';
    $criteria->addCondition('t.pendaftaran_id=' . $pendaftaran_id);
    if(!empty($pasienadmisi_id)) {
      $criteria->addCondition('t.pasienadmisi_id=' . $pasienadmisi_id);
    }
    $criteria->addInCondition('r.instalasi_id', Params::INSTALASI_ID_RI_ARR);
    $modResume = ResumemedisR::model()->findAll($criteria);
    if(empty($modResume)) {
      $data['status'] = true;
      $data['verifikasinull'] = 'ya';
      $data['pesan'] = 'Resume medis belum diterbitkan oleh dokter';
    } else {
      $data['status'] = false;
      // $data['pesan'] = 'Resume medis belum diterbitkan oleh dokter';
    }

    echo json_encode($data);
  }

  protected function verifikasiTindakanRawatInap($id, $data)
  {


    $reseptur_full = ResepturT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ));

    $reseptur = ResepturT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'condition' => 'penjualanresep_id is null',
    ));

    $model = InformasikasirinappulangV::model()->findByAttributes(array(
      'pendaftaran_id' => $id,
    ));
    $admisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);

    $nama = $model->namadepan . $model->nama_pasien;
    $modRuangan = RuanganM::model()->findByPk($admisi->ruangan_id);
    $ruangan = $modRuangan->ruangan_nama;


    $no_rm = $model->no_rekam_medik;
    $nama = $model->namadepan . $model->nama_pasien;
    $status = $model->statusperiksa;
    $ruangan = $model->ruangan_nama;

    // ============= Pemeriksaan belum diapprove di lab/rad ===========
    $kirim = PasienkirimkeunitlainT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
      'instalasi_id' => array(Params::INSTALASI_ID_LAB, Params::INSTALASI_ID_RAD, Params::INSTALASI_ID_IBS, Params::INSTALASI_ID_REHAB),
      ), array(
      'condition' => 'tglrencanapemeriksaan is null',
    ));

    // var_dump(count($kirim), count($reseptur)); die;

    if (count($kirim) > 0 || count($reseptur) > 0) {
      $ok = 0;
      $is_notif = 1;

  
      $grup_kirim = array(
        Params::INSTALASI_ID_LAB => array(
          'nama'=>'Pemeriksaan Laboratorium',
          'detail'=>array(),
        ),
        Params::INSTALASI_ID_RAD => array(
          'nama'=>'Pemeriksaan Radiologi',
          'detail'=>array(),
        ),
        Params::INSTALASI_ID_IBS => array(
          'nama'=>'Tindakan Bedah',
          'detail'=>array(),
        ),
        Params::INSTALASI_ID_REHAB => array(
          'nama'=>'Tindakan Fisioterapi',
          'detail'=>array(),
        ),
      );
  
      foreach ($kirim as $item) {
          $grup_kirim[$item->instalasi_id]['detail'][] = $item;
      }
  
      $msg = $this->renderPartial("_notifPenunjang", array(
          'grup_kirim'=>$grup_kirim, 'reseptur'=>$reseptur,
      ), true);
  
      $data['isnotif'] = 1;
      $data['pesan'] = $msg;
      $data['status'] = false;
      
      return $data;

    }


    /*
    $kirimLab = PasienkirimkeunitlainT::model()->countByAttributes(array(
      'pendaftaran_id' => $id,
      'instalasi_id' => Params::INSTALASI_ID_LAB,
    ), array(
      'condition' => 'pasienmasukpenunjang_id is null',
    ));
    $kirimRad = PasienkirimkeunitlainT::model()->countByAttributes(array(
      'pendaftaran_id' => $id,
      'instalasi_id' => Params::INSTALASI_ID_RAD,
    ), array(
      'condition' => 'pasienmasukpenunjang_id is null',
    ));

    $kirimBedah = PasienkirimkeunitlainT::model()->countByAttributes(array(
      'pendaftaran_id' => $id,
      'instalasi_id' => Params::INSTALASI_ID_IBS,
    ), array(
      'condition' => 'pasienmasukpenunjang_id is null',
    ));

    $kirimBedah2 = RencanaoperasiT::model()->countByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'condition' => 'tindakanpelayanan_id is null',
    ));
    */


    // ambulans
    // $ambulans = PesanambulansT::model()->find("pendaftaran_id = " . $id . " and pemakaianambulans_id is null");


    // if (count((array)$reseptur_full) == 0) {
    //   $data['status'] = false;
    //   $data['pesan'] = "Pasien ${nama} belum dilakukan Transaksi Reseptur.";
    //   $data['isalert'] = 1;
    //   //$this->breadcastNotifResepturPasien($model, $reseptur);
    // } else
    //  if (count((array)$reseptur) > 0) {
    //   $data['status'] = false;
    //   $data['pesan'] = "Resep untuk Pasien ${nama} belum dilakukan verifikasi oleh Farmasi.";
    //   $data['isalert'] = 1;

    //   $this->breadcastNotifResepturPasien($model, $reseptur);
    // } else if (!empty($ambulans)) {
    //   $data['status'] = false;
    //   $data['pesan'] = "Pasien ${nama} belum dilakukan Pemakaian Ambulans";
    //   $data['isalert'] = 1;
    // } else if ($kirimLab > 0) {
    //   $data['status'] = false;
    //   $data['pesan'] = "Pasien ${nama} belum menyelesaikan Pemeriksaan Laboratorium";
    //   $data['isalert'] = 1;
    // } else if ($kirimRad > 0) {
    //   $data['status'] = false;
    //   $data['pesan'] = "Pasien ${nama} belum menyelesaikan Pemeriksaan Radiologi";
    //   $data['isalert'] = 1;
    // } else if (($kirimBedah + $kirimBedah2) > 0) {
    //   $data['status'] = false;
    //   $data['pesan'] = "Pasien ${nama} belum menyelesaikan Tindakan Bedah";
    //   $data['isalert'] = 1;
    // } else {
    $data['status'] = false;
    $data['pesan'] = "Anda tidak akan dapat melakukan transaksi setelah membuat Rencana Pulang untuk Pasien. <br>Apakah Anda akan melanjutkan membuat Rencana Pulang ?";
    //var_dump($pendaftaran_id);die;
    $data['statusbayar'] = (PasienpulangT::model()->cekSisaPembayaran($id) == false) ? 'ada' : 'tidak';
    // }

    return $data;
  }

  /**
   * 
   * @param mixed $model Data yang berhubungan dengan Pasien dan Pendaftaran.
   * @param ResepturT $reseptur Data ResepturT
   * @return boolean Status keberhasilan Broadcast reseptur ke farmasi
   */
  protected function breadcastNotifResepturPasien($model, $reseptur)
  {
    $judul = "Verifikasi Reseptur Rawat Inap";
    $msg = "Harap Reseptur dibawah ini di diselesaikan :<br/>";
    $noresep = array();
    foreach ($reseptur as $item) {
      $msg .= "- " . $item->noresep . '<br/>';
      $noresep[] = $item->noresep;
    }

    $link = $this->createUrl('/farmasiApotek/InformasiPasienResep/Index', array(
      'FAInformasiresepturV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
      'FAInformasiresepturV[tgl_akhir]' => date('Y-m-d'),
      'FAInformasiresepturV[no_pendaftaran]' => $model->no_pendaftaran,
      'FAInformasiresepturV[statusJual]' => 2,
    ));

    $cur = array(
      array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK, 'link_proses' => $link),
    );

    // var_dump($modKunjungan->attributes); die;
    // var_dump($judul, $isi, $cur, $modKunjungan->attributes); die;

    return CustomFunction::broadcastNotif($judul, $msg, $cur);
  }

  public function actionStatusDokumenKirim($pengirimanrm_id, $pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $status = false;
    if (!empty($pengirimanrm_id)) {
      $modPengirimanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
    } else {
      $modPengirimanRm = new PengirimanrmT();
    }

    $pegawai_id = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id;
    $modUbahStatus = new PengirimanrmT;
    $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');
    $modUbahStatus->petugaspengirim = Yii::app()->user->name;
    $modUbahStatus->petugaspengirim_id = $pegawai_id;

    if (isset($_POST['PengirimanrmT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modUbahStatus->attributes = $_POST['PengirimanrmT'];
        //var_dump($_POST);die;
        $modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
        $modUbahStatus->dokrekammedis_id = isset($modPengirimanRm) ? $modPengirimanRm->dokrekammedis_id : null;
        $modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
        $modUbahStatus->tglpengirimanrm = $format->formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
        $modUbahStatus->kelengkapandokumen = TRUE;
        $modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];
        $modUbahStatus->create_time = date('Y-m-d H:i:s');
        $modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
        $modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
        $modUbahStatus->ruanganpenerima_id = $_POST['PengirimanrmT']['ruangan_id'];

        if ($modUbahStatus->save()) {
          $modPendaftaran->statusdokrm = 'SUDAH DIKIRIM';
          $modPendaftaran->pengirimanrm_id = $modUbahStatus->pengirimanrm_id;
          $modPendaftaran->save();

          $judul = 'Pengiriman Berkas Rekam Medis';

          $isi = $modUbahStatus->pendaftaran->no_pendaftaran . ' - ' . $modUbahStatus->pasien->no_rekam_medik . ' - ' . $modUbahStatus->pasien->nama_pasien;

          CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $modUbahStatus->ruangantujuan->instalasi->instalasi_id, 'ruangan_id' => $modUbahStatus->ruangantujuan->ruangan_id, 'modul_id' => !empty($modUbahStatus->ruangantujuan->modul_id) ? $modUbahStatus->ruangantujuan->modul_id : null),
          ));


          $transaction->commit();
          $status = true;
          Yii::app()->user->setFlash('success', "Data pengiriman dokumen pasien berhasil disimpan !");
        } else {
          $status = false;
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data pengiriman dokumen pasien gagal disimpan');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $status = false;
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
      }
    }

    $this->render('_formStatusDokumen', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPengirimanRm' => $modPengirimanRm,
      'modUbahStatus' => $modUbahStatus,
      'status' => $status
    ));
  }

  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if (isset($_POST[$model_nama]['pasienadmisi_id'])) {
        $admisi = PasienadmisiT::model()->findByPk($_POST[$model_nama]['pasienadmisi_id']);


        $res_model = array();
        foreach ($models as $id => $nama) {
          if (!empty($admisi) && $id != $admisi->ruangan_id) {
            $res_model[$id] = $nama;
          }
        }

        $models = $res_model;
      }

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        if (count((array)$models) > 0) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } elseif (count((array)$models) == 0) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }

        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionCekJadwalPoli()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
      $waktu = isset($_POST['waktu']) ?  MyFormatter::formatDateTimeForDb($_POST['waktu']) : null;
      $rencanapulang = isset($_POST['rencanapulang']) ?  MyFormatter::formatDateTimeForDb($_POST['rencanapulang']) : null;
      $hari = MyFormatter::getDayUser(date('w', strtotime($waktu)));





      $jam = date('H:i:s', strtotime($waktu));

      $cri = new CDbCriteria();
      $cri->addCondition(" ruangan_id = '" . $ruangan_id . "' ");
      $cri->addCondition(" hari ilike '" . $hari . "' ");
      $cekJadwal = JadwalbukapoliM::model()->find($cri);

      $r = RuanganM::model()->findByPk($ruangan_id);

      if (!empty($cekJadwal)) {
        if (($jam >= $cekJadwal->jammulai) && ($jam <= $cekJadwal->jamtutup)) {
          $data['sukses'] = 1;
        } else {
          $data['sukses'] = 0;
          $data['pesan'] = 'Maaf, ' . $r->ruangan_nama . ' hanya buka pada jam ' . $cekJadwal->jmabuka;
        }
      } else {
        $data['sukses'] = 0;
        $data['pesan'] = 'Maaf, Tidak Ada Jadwal ' . $r->ruangan_nama . ' pada tanggal ' . date('d F Y', strtotime($waktu));
      }

      if ($waktu != null) {
        if (strtotime($waktu) > strtotime($rencanapulang)) {
          $data['validateTgl'] = 1;
        } else {
          $data['validateTgl'] = 0;
          $data['pesan'] = "Maaf, tanggal rencana kontrol pasien tidak boleh kurang dari tanggal rencana pulang ";
        }
      } else {
        $data['validateTgl'] = 1;
      }

      echo json_encode($data);
    }
    Yii::app()->end();
  }

  /**
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   * 
   * Ambil data dokter Umum dari autocomplete.
   * 
   * @param type $term data dari Text Input
   */
  public function actionGetDokterDPJP($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $prov = PegawaiV::model()->searchDokterDPJP();
    $prov->criteria->compare('lower(nama_pegawai)', strtolower($term), true);
    $prov->sort->defaultOrder = 'nama_pegawai';
    $prov->pagination = false;

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->namaLengkap;
      $sub['value'] = $item->pegawai_id;
      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  public function simpanPengirimanDokRM($modPendaftaran, $post, $dokrekammedis_id)
  {
    $modUbahStatus = new PengirimanrmT;
    $modUbahStatus->attributes = $post;
    $modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
    $modUbahStatus->dokrekammedis_id = $dokrekammedis_id;
    $modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
    $modUbahStatus->tglpengirimanrm = MyFormatter::formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
    $modUbahStatus->kelengkapandokumen = TRUE;
    $modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];
    $modUbahStatus->create_time = date('Y-m-d H:i:s');
    $modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
    $modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
    $modUbahStatus->ruanganpenerima_id = $_POST['PengirimanrmT']['ruangan_id'];

    // var_dump($modUbahStatus->attributes, $modUbahStatus->validate(), $modUbahStatus->errors);

    if ($modUbahStatus->save()) {


      PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('statusdokrm' => 'SUDAH DIKIRIM', 'pengirimanrm_id' => $modUbahStatus->pengirimanrm_id));

      $judul = 'Pengiriman Berkas Rekam Medis';

      $isi = $modUbahStatus->pendaftaran->no_pendaftaran . ' - ' . $modUbahStatus->pasien->no_rekam_medik . ' - ' . $modUbahStatus->pasien->nama_pasien;

      CustomFunction::broadcastNotif($judul, $isi, array(
        array('instalasi_id' => $modUbahStatus->ruangantujuan->instalasi->instalasi_id, 'ruangan_id' => $modUbahStatus->ruangantujuan->ruangan_id, 'modul_id' => !empty($modUbahStatus->ruangantujuan->modul_id) ? $modUbahStatus->ruangantujuan->modul_id : null),
      ));

      return true;
    } else {
      return false;
    }
  }

  protected function saveRencanaKontrol($model, $modPulang, $post)
  {
    $model = new RIRencanakontrolR;
    $model->attributes = $post;
    $model->pasienpulang_id = $modPulang->pasienpulang_id;
    $model->pendaftaran_id = $modPulang->pendaftaran_id;
    $model->pasien_id = $modPulang->pasien_id;
    $model->instalasi_id = $modPulang->pendaftaran->instalasi_id;
    $model->ruangan_id = $modPulang->pendaftaran->ruangan_id;
    $model->rencanapulang_tgl = !empty($model->rencanapulang_tgl) ? MyFormatter::formatDateTimeForDb($model->rencanapulang_tgl) : null;
    $model->rencanakontrol_tgl = !empty($model->rencanakontrol_tgl) ? MyFormatter::formatDateTimeForDb($model->rencanakontrol_tgl) : null;
    $model->create_time = date('Y-m-d H:i:s');
    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

    $this->simpan_rencanakontrol = $this->simpan_rencanakontrol && $model->save();
  }

  public function actionRiwayatDokfilerm($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $crit = new CDbCriteria();
    $crit->addCondition('pasien_id =' . $modPasien->pasien_id);
    $modDokfilerm = DokfilermR::model()->findAll($crit);
    $modDokfilerms = [];
    foreach ($modDokfilerm as $dok) {

      $arr = explode(",", $dok->instalasi_ids);
      if ($dok->instalasi_ids == 'null' || empty($arr) || !is_array($arr) || in_array(Yii::app()->user->getState('instalasi_id'), $arr)) {
        $modDokfilerms[] = $dok;
      }
    }
    $this->render('_listDokfilerm', array('modDokfilerm' => $modDokfilerms, 'modPasien' => $modPasien));
  }
  public function actionDetailScanRM($dokfilerm_id)
  {
    $this->layout = '//layouts/iframe';

    $file = DokfilermR::model()->findByPk($dokfilerm_id);

    $this->render("detail", array(
      'file' => $file,
    ));
  }

  public function actionSetHitungLamaRawat()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $tglpasienpulang = isset($_POST['tglpasienpulang']) ?  MyFormatter::formatDateTimeForDb($_POST['tglpasienpulang']) : null;

      $modAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);

      $data['sukses'] = 0;

      if (!empty($modAdmisi) && !empty($tglpasienpulang)) {

        $modAdmisi->tgladmisi = MyFormatter::formatDateTimeForDb($modAdmisi->tgladmisi);
        $lamadirawat_kamar = CustomFunction::hitungHari(date('Y-m-d', strtotime($modAdmisi->tgladmisi)), $tglpasienpulang);

        //Hitung hari rawat
        $hariperawatan = CustomFunction::hitungHariRawat(date('Y-m-d', strtotime($modAdmisi->tgladmisi)), $tglpasienpulang);

        $data['lamadirawat_kamar'] = $lamadirawat_kamar;
        $data['hariperawatan'] = $hariperawatan;
        $data['sukses'] = 1;
      }

      echo json_encode($data);
    }
    Yii::app()->end();
  }

  public function actionVclaimCekRuangan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $sep_id = $_POST['sep_id'];
    $ruangan_id = $_POST['ruangan_id'];
    $tanggal = MyFormatter::formatDateTimeForDB($_POST['tgl']);
    $modPendaftaran = PendaftaranT::model()->findByAttributes(array('sep_id' => $sep_id));
    if (!empty($modPendaftaran->pasienadmisi_id)) {
      $sep = SepT::model()->findByPk($modPendaftaran->pasienadmisi->sep_id);
    } else {
      $sep = SepT::model()->findByPk($sep_id);
    }

    $ruangan = RuanganM::model()->findByPk($ruangan_id);

    $tanggal2 = date('Y-m-d', strtotime($tanggal));



    $no_kartu = empty($sep) ? "0000000000000000000" : $sep->nosep;
    $ruangan = $ruangan->kode_bpjs;

    if (empty($no_kartu) || empty($ruangan)) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => 'No. SEP atau Ruangan tidak ditemukan',
      ));
      Yii::app()->end();
    }

    $bpjs = new Bpjs_Vklaim;
    $res = $bpjs->search_spesialtik_kontrol(2, $no_kartu, $tanggal2);

    if (!$res) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => 'Terjadi kesalahan dalam pengecekan Ruangan VClaim',
      ));
      Yii::app()->end();
    }



    $res_json = CJSON::decode($res);
    if ($res_json['metaData']['code'] != 200) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => $res_json['metaData']['message'],
      ));
      Yii::app()->end();
    }

    $is_ada = false;
    foreach ($res_json['response']['list'] as $item) {
      if ($ruangan == $item['kodePoli']) {
        $is_ada = true;

        if ($item['jmlRencanaKontroldanRujukan'] == $item['kapasitas']) {
          echo CJSON::encode(array(
            'ok' => 0,
            'msg' => "Kapasitas Jumlah Pasien Rencana Kontrol Poliklinik  Pasien BPJS sudah penuh, silahkan pilih tanggal lain",
          ));
          Yii::app()->end();
        }

        break;
      }
    }

    // var_dump($ruangan, $res_json); die;

    if (!$is_ada) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => "Ruangan kontrol tidak ditemukan.",
      ));
      Yii::app()->end();
    }
  }


  public function actionVclaimCekPraktekDokter()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $ruangan_id = $_POST['ruangan_id'];
    $tanggal = MyFormatter::formatDateTimeForDB($_POST['tgl']);

    $ruangan = RuanganM::model()->findByPk($ruangan_id);
    $tanggal2 = date('Y-m-d', strtotime($tanggal));

    $ruangan = $ruangan->kode_bpjs;

    if (empty($ruangan)) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => 'Ruangan tidak ditemukan',
      ));
      Yii::app()->end();
    }

    $bpjs = new Bpjs_Vklaim;
    $res = $bpjs->search_jadwal_dokter_kontrol(2, $ruangan, $tanggal2);

    if (!$res) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => 'Terjadi kesalahan dalam pengecekan Jadwal Dokter VClaim',
      ));
      Yii::app()->end();
    }



    $res_json = CJSON::decode($res);
    if ($res_json['metaData']['code'] != 200) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => $res_json['metaData']['message'],
      ));
      Yii::app()->end();
    }

    $is_ada = false;
    $html = '<option value="">-- Pilih --</option>';

    $peg_list = array();

    foreach ($res_json['response']['list'] as $item) {

      $peg = PegawaiM::model()->findByAttributes(array(
        'kodedokter_bpjs' => $item['kodeDokter'],
      ));

      if (empty($peg)) {
        continue;
      }

      if (in_array($peg->pegawai_id, $peg_list)) {
        continue;
      }

      $peg_list[] = $peg->pegawai_id;

      $html .= '<option value="' . $peg->pegawai_id . '">' . $peg->namaLengkap . '</option>';

      //var_dump($item);
    }

    echo CJSON::encode(array(
      'ok' => 1,
      'html' => $html,
    ));

    //die;

    // var_dump($ruangan, $res_json); die;

  }

  public function actionAmbilHasil($pendaftaran_id, $pasienmasukpenunjang_id, $hasilpemeriksaanlab_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPasienMasukPenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPasien = LBPasienM::model()->findByPk($modPasienMasukPenunjang->pasien_id);
    $modHasilLab = LBHasilPemeriksaanLabT::model()->findByPk($hasilpemeriksaanlab_id);
    $modHasilLab->namaygmenyerahkan = Yii::app()->user->getState('nama_pegawai');
    if (isset($_POST['LBHasilPemeriksaanLabT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        //var_dump($_POST['LBHasilPemeriksaanLabT']);die;


        $modHasilLab->attributes = $_POST['LBHasilPemeriksaanLabT'];
        $modHasilLab->tglpengambilanhasil = $format->formatDateTimeForDb($_POST['LBHasilPemeriksaanLabT']['tglpengambilanhasil']);


        if ($modHasilLab->validate()) {
          $modHasilLab->save();
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
          $this->redirect(array('ambilHasil', 'pendaftaran_id' => $pendaftaran_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'hasilpemeriksaanlab_id' => $hasilpemeriksaanlab_id, 'frame' => 1, 'popup' => 'true', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('ambilHasil', array(
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modPasien' => $modPasien,
      'modHasilLab' => $modHasilLab,
      'format' => $format,
    ));
  }

  /**
   * actionPrintRincianBelumBayar 
   * @params $instalasi_id = RJ / RD / RI
   * @params $pendaftaran_id
   * @params $pasienadmisi_id (RI saja)
   */
  //fungsi ini diambil dari bilingkasir/controller/PembayaranTagihanPasienController
  //RSPMC-1171
  public function actionPrintRincianBelumBayar($instalasi_id, $pendaftaran_id, $pasienadmisi_id = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';

    $modRincians = RinciantagihanpasienV::model()->findAll($criteria);
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    /*
        if($instalasi_id == Params::INSTALASI_ID_RJ){
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
        $criteria->order = 'unitlayanan_nama, tgl_tindakan';
        $modRincians = BKRincianbelumbayarrjV::model()->findAll($criteria);
        $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RD){
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
        $criteria->order = 'ruangantindakan_id';
        $modRincians = BKRincianbelumbayarrdV::model()->findAll($criteria);
        $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RI || $instalasi_id == Params::INSTALASI_ID_ICU){
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
        $criteria->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
        $criteria->order = 'ruangantindakan_id';
        $criteria->order = 'tgl_tindakan';
        $modRincians = BKRincianbelumbayarrawatinapV::model()->findAll($criteria);
        $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }
       * 
       */

    $modInstalasi = InstalasiM::model()->findByPk($instalasi_id);
    $this->render('billingKasir.views.pembayaranTagihanPasien.printRincianBelumBayar', array('modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modInstalasi' => $modInstalasi));
  }

  /**
   * Jawab konsul poli pasien
   * @param integer $konsulpoli_id
   */
  public function actionKonsultasiInternal($konsulpoli_id)
  {
    Yii::import("rawatJalan.models.*");

    $this->layout = '//layouts/iframe';
    $model = RJKonsulPoliT::model()->findByPk($konsulpoli_id);
    $model->uraian_konsul = strip_tags($model->uraian_konsul);

    if (empty($model)) {
      echo "Pasien belum melakukan konsultasi poliklinik";
      Yii::app()->end();
    }

    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit', 'kelaspelayanan')->findByPk($model->pendaftaran_id);
    $modPasien = $modPendaftaran->pasien;
    $pasienMorbiditas = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    $modUraian = new RJPasienMorbiditasT();
    $modMorbiditas = RJPasienMorbiditasT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ));

    $model->tgljawabpoli = !empty($model->tgljawabpoli) ? $model->tgljawabpoli : date('d M Y H:i:s');
    if (!empty($model->pegawaikonsul_id)) {
      $model->nama_pegawai = PegawaiM::model()->findByPk($model->pegawaikonsul_id)->nama_pegawai;
    }

    if (isset($_POST['RJKonsulPoliT'])) {
      $sukses = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['RJKonsulPoliT'];
        $model->uraian_konsul = isset($_POST['RJKonsulPoliT']['uraian_konsul']) ? $_POST['RJKonsulPoliT']['uraian_konsul'] : $model->uraian_konsul;
        $model->uraian_konsuljawaban = isset($_POST['RJKonsulPoliT']['uraian_konsuljawaban']) ? $_POST['RJKonsulPoliT']['uraian_konsuljawaban'] : $model->uraian_konsuljawaban;

        if ($model->save()) {

          if (isset($_POST['RJPasienMorbiditasT'])) {
            foreach ($_POST['RJPasienMorbiditasT'] as $key => $val) {
              if ($val['pasienmorbiditas_id'] == null || $val['pasienmorbiditas_id'] == "") {
                $insert = new RJPasienMorbiditasT();
                $insert->attributes = $val;
                $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
                $insert->kelompokumur_id = $modPasien->kelompokumur_id;
                $insert->golonganumur_id = $modPendaftaran->golonganumur_id;
                $insert->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                $insert->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $insert->kasusdiagnosa = $val['kasusdiagnosa'];
                $insert->pasien_id = $modPendaftaran->pasien_id;
                $insert->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $insert->pegawai_id = $val['pegawai_id'];
                $insert->$golUmur = 1;
                if ($insert->save()) {
                  $sukses &= true;
                } else {
                  $sukses &= false;
                }
              }
            }
          }
        } else {
          $sukses &= false;
        }

        // var_dump($sukses); die;

        if ($sukses) {




          $transaction->commit();

          $ruangan_id = "";
          $daftar = PendaftaranT::model()->findByPk($model->pendaftaran_id);

          if (!empty($daftar->pasienadmisi_id)) {
            $admisiMod = PasienadmisiT::model()->findBypk($daftar->pasienadmisi_id);
            $ruangan_id = (isset($admisiMod) ? $admisiMod->ruangan_id : "");
          } else {
            $ruangan_id = (isset($daftar) ? $daftar->ruangan_id : "");
          }

          if (!empty($ruangan_id)) {
            $ruanganMod = RuanganM::model()->findByPk($ruangan_id);
            $ruangKonsul = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

            if (isset($ruanganMod)) {
              $judul = 'Pasien Konsultasi Internal';
              $isi = 'Pasien ' . $modPasien->nama_pasien . ' dengan nomor rekam medik ' . $modPasien->no_rekam_medik . ' Telah melakukan konsultasi Internal di ' . $ruangKonsul->ruangan_nama . ' pada ' . $model->tgljawabpoli;
              $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => $ruanganMod->instalasi_id, 'ruangan_id' => $ruanganMod->ruangan_id, 'modul_id' => $ruanganMod->modul_id),
              ));
            }
          }

          Yii::app()->user->setFlash('success', "Data berhasil update");
          $this->redirect(array('KonsultasiInternal', 'konsulpoli_id' => $konsulpoli_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('danger', "Data tidak berhasil update");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        var_dump($ex->getMessage());
        die;
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('konsultasiInternal/index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'model' => $model,
      'pasienMorbiditas' => $pasienMorbiditas,
      'modUraian' => $modUraian,
      'modMorbiditas' => $modMorbiditas,
    ));
  }

  /**
   * Untuk cek golongan umur
   * @param type $idGolonganUmur
   */
  private function cekGolonganUmur($idGolonganUmur)
  {
    switch ($idGolonganUmur) {
      case 1:
        return 'umur_5_14thn';
      case 2:
        return 'umur_15_24thn';
      case 3:
        return 'umur_25_44thn';
      case 4:
        return 'umur_45_64thn';
      case 5:
        return 'umur_65';
      case 9:
        return 'umur_65';
      case 10:
        return 'umur_65';
      case 6:
        return 'umur_0_28hr';
      case 7:
        return 'umur_28hr_1thn';
      case 8:
        return 'umur_1_4thn';
      default:
        break;
    }
  }

  //save log bpjs
  function logBpjs($model, $reqSep, $api = null)
  {
    $log = new BpjslogR;
    $log->tgl_log = date('Y-m-d H:i:s');
    $log->code = $reqSep['metaData']['code'];
    $log->loginpemakai_id = Yii::app()->user->id;
    if (isset($reqSep['metaData']['message'])) {
      $log->pesan = $reqSep['metaData']['message'];
    }
    if (!empty($reqSep['request_vars'])) {
      $log->json_request_respose = $reqSep['request_vars'];
    }
    $log->pendaftaran_id = $model->pendaftaran_id;
    $request = Yii::app()->request;
    $ipAddress = $request->getUserHostAddress();
    $log->ip_address = $ipAddress;
    $log->api = $api;
    $log->save();
  }

  function actionPilihResep($pendaftaran_id) {
    $this->layout = '//layouts/iframe';
    $modReseptur = ResepturT::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id, 'penjualanresep_id' => null], ['condition' => 'pasienadmisi_id is not null', 'order' => 'tglreseptur desc']);

    $this->render('pilihResep', [
      'modReseptur' => $modReseptur
    ]);
  }

  public function actionVerifikasiPJA() {
    if (!Yii::app()->request->isAjaxRequest) {
        Yii::app()->end();
    }

    
    $pendaftaran_id = $_POST['verifikasi']['pendaftaran_id'];
    $tgl = MyFormatter::formatDateTimeForDB($_POST['verifikasi']['tanggal_approvaltindaklanjut'] ?? date('Y-m-d H:i:s'));
    $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);

    $tindakanCondition = "isapprovaltindaklanjut = false";
    $oaCondition = "isapprovaltindaklanjut = false";

    $trans = Yii::app()->db->beginTransaction();
    $ok = true;

    try {


      $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
        'pendaftaran_id'=>$pendaftaran_id,
      ), array(
        'condition'=>'isapprovaltindaklanjut = false or isapprovaltindaklanjut is null'
      ));
      $oa = ObatalkespasienT::model()->findAllByAttributes(array(
        'pendaftaran_id'=>$pendaftaran_id,
      ), array(
        'condition'=>'isapprovaltindaklanjut = false or isapprovaltindaklanjut is null'
      ));

      // var_dump(count($tindakan), count($oa)); die;

      foreach ($tindakan as $item) {
        $item->userapprovaltindaklanjut_id = $_POST['verifikasi']['userapprovaltindaklanjut_id'];
        $item->tanggal_approvaltindaklanjut = $tgl;
        $item->isapprovaltindaklanjut = true;
        $item->ruangan_id_approvaltindaklanjut = Yii::app()->user->getState('ruangan_id');


        // $item->userpembatalanapprovaltl_id = null;
        // $item->tanggalbatal_approvaltl = null;
        $item->ispembatalanapprovaltl = false;
        
        $ok = $ok && $item->save(false, array(
          'userapprovaltindaklanjut_id', 'tanggal_approvaltindaklanjut', 'isapprovaltindaklanjut',
          // 'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl',
          'ispembatalanapprovaltl', 'ruangan_id_approvaltindaklanjut'
        ));

        // var_dump($ok, $item->attributes); die;
      }

      foreach ($oa as $item) {
        $item->userapprovaltindaklanjut_id = $_POST['verifikasi']['userapprovaltindaklanjut_id'];
        $item->tanggal_approvaltindaklanjut = $tgl;
        $item->isapprovaltindaklanjut = true;
        $item->ruangan_id_approvaltindaklanjut = Yii::app()->user->getState('ruangan_id');
        
        // $item->userpembatalanapprovaltl_id = null;
        // $item->tanggalbatal_approvaltl = null;
        $item->ispembatalanapprovaltl = false;
        
        $ok = $ok && $item->save(false, array(
          'userapprovaltindaklanjut_id', 'tanggal_approvaltindaklanjut', 'isapprovaltindaklanjut',
          // 'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl',
          'ispembatalanapprovaltl', 'ruangan_id_approvaltindaklanjut'
        ));

        // var_dump($item->attributes);
      }

      $ok = $ok && $this->kirimNotifPJA($pendaftaran, $tgl, $_POST['verifikasi']['userapprovaltindaklanjut_id']);

      if ($ok) {
        $trans->commit();
        echo CJSON::encode(array(
          'ok'=>1,
          'msg'=>'Validasi PJA berhasil disimpan.',
        ));
        Yii::app()->end();
      } else {
        $trans->rollback();
        echo CJSON::encode(array(
          'ok'=>0,
          'msg'=>'Validasi PJA gagal disimpan.',
        ));
        Yii::app()->end();
      }
        
        // var_dump($_POST); die;


    } catch (CException $e) {
      $trans->rollback();
      echo CJSON::encode(array(
        'ok'=>0,
        'msg'=>'ERROR - '.$e->getMessage(),
      ));
      Yii::app()->end();
    }

    
  }

  public function actionBatalPJA() {
    if (!Yii::app()->request->isAjaxRequest) {
        Yii::app()->end();
    }

    $pendaftaran_id = $_POST['pendaftaran_id'];
    $tgl = date('Y-m-d H:i:s');
    $peg_id = Yii::app()->user->getState('pegawai_id');
    $trans = Yii::app()->db->beginTransaction();
    $ok = true;

    $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);

    //$tindakanCondition = "tgl_tindakan > '".$admisi->tgladmisi."'";
    //$oaCondition = "tglpelayanan > '".$admisi->tgladmisi."'";

    try {

      $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
        'pendaftaran_id'=>$pendaftaran_id,
        'ruangan_id_approvaltindaklanjut'=>Yii::app()->user->getState('ruangan_id'),
      ),array(
      //   'condition'=>$tindakanCondition
      ));
      $oa = ObatalkespasienT::model()->findAllByAttributes(array(
        'pendaftaran_id'=>$pendaftaran_id,
        'ruangan_id_approvaltindaklanjut'=>Yii::app()->user->getState('ruangan_id'),
      ),array(
      //   'condition'=>$oaCondition
      ));

      foreach ($tindakan as $item) {
        // $item->userapprovaltindaklanjut_id = null;
        // $item->tanggal_approvaltindaklanjut = null;
        $item->isapprovaltindaklanjut = false;

        $item->userpembatalanapprovaltl_id = $peg_id;
        $item->tanggalbatal_approvaltl = $tgl;
        $item->ispembatalanapprovaltl = true;
        $item->ruangan_id_approvaltindaklanjut = null;

        
        $ok = $ok && $item->save(true, array(
            'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl', 'ispembatalanapprovaltl',
            'isapprovaltindaklanjut', 'ruangan_id_approvaltindaklanjut'
        ));

        // var_dump($ok, $item->isapprovaltindaklanjut);
      }

      foreach ($oa as $item) {
        // $item->userapprovaltindaklanjut_id = null;
        // $item->tanggal_approvaltindaklanjut = null;
        $item->isapprovaltindaklanjut = false;


        $item->userpembatalanapprovaltl_id = $peg_id;
        $item->tanggalbatal_approvaltl = $tgl;
        $item->ispembatalanapprovaltl = true;
        $item->ruangan_id_approvaltindaklanjut = null;
        
        

        $ok = $ok && $item->save(false, array(
            'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl', 'ispembatalanapprovaltl',
            'isapprovaltindaklanjut', 'ruangan_id_approvaltindaklanjut'
        ));

        // var_dump($item->attributes);
      }

      // var_dump($ok); die;

      if ($ok) {
        $trans->commit();
        echo CJSON::encode(array(
            'ok'=>1,
            'msg'=>'Validasi PJA berhasil dibatalkan.',
        ));
        Yii::app()->end();
      } else {
        $trans->rollback();
        echo CJSON::encode(array(
            'ok'=>0,
            'msg'=>'Validasi PJA gagal dibatalkan.',
        ));
        Yii::app()->end();
      }

    } catch (CException $e) {
      $trans->rollback();
      echo CJSON::encode(array(
        'ok'=>0,
        'msg'=>'ERROR - '.$e->getMessage(),
      ));
      Yii::app()->end();
    }

  }

  function kirimNotifPJA($pendaftaran, $tgl, $approval_id) {
    $msg = "Telah divalidasi PJA atas nama {{nama_pasien}} dengan {{no_rekam_medik}} pada {{tanggal_validasi}}";

    $msg = str_replace("{{nama_pasien}}", $pendaftaran->pasien->nama_pasien, $msg);
    $msg = str_replace("{{no_rekam_medik}}", $pendaftaran->pasien->no_rekam_medik, $msg);
    $msg = str_replace("{{tanggal_validasi}}", MyFormatter::formatDateTimeForUser($tgl), $msg);

    $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_KEUANGAN);

    // var_dump($ruangan_keuangan->attributes); die;

    return CustomFunction::broadcastNotif("Validasi PJA", $msg, array(
      array('instalasi_id' => $ruangan_keuangan->instalasi_id, 'ruangan_id' => $ruangan_keuangan->ruangan_id, 'modul_id' =>$ruangan_keuangan->modul_id),
    ));

    // var_dump($msg); die;
  }

  public function actionUbahDPJP($pendaftaran_id = null, $pasienadmisi_id = null)
  {
      Yii::import('rawatJalan.models.*');
      $this->layout = '//layouts/iframe';

      $modUbahDokter = new RJUbahdokterR;
      
      $modRiwayatUbahDokter = UbahdokterR::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id], ['order' => 'create_time desc']);

      $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
      $modAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);

      if(!empty($modAdmisi) && !empty($modPendaftaran)) {
          $modUbahDokter->dokterlama_id = $modAdmisi->pegawai_id;
          $modUbahDokter->dokterlama_nama = $modAdmisi->pegawai->nama_pegawai;
          $modPendaftaran->nama_pasien = $modPendaftaran->pasien->nama_pasien;
          $modPendaftaran->alamat_pasien = $modPendaftaran->pasien->alamat_pasien;
          $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
          $modPendaftaran->ruangan_id = $modAdmisi->ruangan_id;
          $modPendaftaran->no_rekam_medik = $modPendaftaran->pasien->no_rekam_medik;
          
      }
      
      if(empty($modPendaftaran)) {
          $modPendaftaran = new RJPendaftaranT();
      }

      if (isset($_POST['RJPendaftaranT']) && !empty($pasienadmisi_id)) {

          $transaction = Yii::app()->db->beginTransaction();

          if ($_POST['RJUbahdokterR']['dokterbaru_id'] != "") {
              $modUbahDokter->attributes = $_POST['RJUbahdokterR'];
              $modUbahDokter->pendaftaran_id = $_POST['RJPendaftaranT']['pendaftaran_id'];
              $modUbahDokter->pasienadmisi_id = $pasienadmisi_id;
              $modUbahDokter->tglubahdokter = MyFormatter::formatDateTimeForDb($_POST['tglubahdokter']);
              $modUbahDokter->create_time = date('Y-m-d H:i:s');
              $modUbahDokter->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
              $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
              // echo '<pre>';var_dump($modUbahDokter);die;
              try {

                  $attributes = array('pegawai_id' => $_POST['RJUbahdokterR']['dokterbaru_id']);
      
                  $save = PasienadmisiT::model()->updateByPk($pasienadmisi_id, $attributes);
                  // echo '<pre>';var_dump($save, $modUbahDokter->validate());die;
                  if ($save) {
                      if($modUbahDokter->save()) {
                          $transaction->commit();
                          Yii::app()->user->setFlash('success', 'Data Berhasil Disimpan !');
                          $this->redirect(array('UbahDPJP', 'pendaftaran_id'=>$pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'sukses' => 1));

                      } else {
                          $transaction->rollback();
                          Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan !');

                      }
                  } else {
                      $transaction->rollback();
                      Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan {2}!');


                  }
                  
              } catch (Exception $exc) {
                  echo '<pre>';var_dump($exc);die;
                  $transaction->rollback();
                  Yii::app()->user->setFlash('error', 'Gagal Berhasil Disimpan {3}!');

              }
          }
          
      }

 
      $this->render($this->path_view . 'dpjp/_formUbahDPJP', array(
          'modPendaftaran' => $modPendaftaran, 
          'modUbahDokter' => $modUbahDokter, 
          'modDokter' => $modUbahDokter, 
          'modRiwayatUbahDokter' => $modRiwayatUbahDokter,
      ));
      
  }

  function actionUbahdoktertujuankonsul() {
    $pegawai_id = $_POST['pegawai_id'];
    $konsulpoli_id = $_POST['konsulpoli_id'];
    $update = KonsulpoliT::model()->updateByPk($konsulpoli_id, ['pegawai_id' => $pegawai_id]);

    if($update) {
      $data['sukses'] = 1;
    } else {
      $data['sukses'] = 0;
    }

    echo json_encode($data);
  }
}
