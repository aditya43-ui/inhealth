<?php

/**
 * controller utama untuk mengelola daftar pasien radiologi
 *
 * @package application.modules.radiologi
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
class DaftarPasienController extends MyAuthController
{
  public $successPengambilanSample = false;
  public $successKirimSample = false;
  public $path_view = 'laboratorium.views.daftarPasien.';
  public $path_view_rad = 'radiologi.views.daftarPasien.';

  /**
   * action ini digunakan untuk mengakses ke menu informasi daftar pasien radiologi
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Daftar Pasien";
    $modPasienMasukPenunjang = new ROPasienMasukPenunjangV;
    $format = new MyFormatter();
    //                $modPasienMasukPenunjang->tgl3507091801010004_awal = date('d M Y').' 00:00:00';
    //$modPasienMasukPenunjang->tgl_awal = date('d M Y', strtotime('-5 days')).' 00:00:00';
    $modPasienMasukPenunjang->tgl_awal = date('d M Y');
    $modPasienMasukPenunjang->tgl_akhir = date('d M Y');
    $modPasienMasukPenunjang->tgl_awall = date('Y-m-d');
    $modPasienMasukPenunjang->tgl_akhirl = date('Y-m-d');
    $modPasienMasukPenunjang->tgl_awall2 = date('d M Y');
    $modPasienMasukPenunjang->tgl_akhirl2 = date('d M Y');
    $modPasienMasukPenunjang->ceklis = false;
    // var_dump(Yii::app()->user->getState('pegawai_id'));die;
    // if(Yii::app()->user->getState('pegawai_id') == 1158){
      
    // }else if (Yii::app()->user->getState('unitkerja_id') == Params::UNITKERJA_ID_DOKTER) {
    //   // $modPasienMasukPenunjang->pegawai_id = Yii::app()->user->getState('pegawai_id');
    // }

    if (isset($_GET['ROPasienMasukPenunjangV'])) {
      $modPasienMasukPenunjang->attributes = $_GET['ROPasienMasukPenunjangV'];
      $modPasienMasukPenunjang->jenis_pasien = $_REQUEST['ROPasienMasukPenunjangV']['jenis_pasien'];
      $modPasienMasukPenunjang->ceklis = $_REQUEST['ROPasienMasukPenunjangV']['ceklis'];
      $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($_GET['ROPasienMasukPenunjangV']['tgl_awal']);
      $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($_GET['ROPasienMasukPenunjangV']['tgl_akhir']);
      $modPasienMasukPenunjang->tgl_awall = $format->formatDateTimeForDb($_REQUEST['ROPasienMasukPenunjangV']['tgl_awall']);
      $modPasienMasukPenunjang->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['ROPasienMasukPenunjangV']['tgl_akhirl']);
      if(isset($_REQUEST['ROPasienMasukPenunjangV']['tgl_awall2'])) {
        $modPasienMasukPenunjang->tgl_awall2 = $format->formatDateTimeForDb($_REQUEST['ROPasienMasukPenunjangV']['tgl_awall2']);
      }
      if(isset($_REQUEST['ROPasienMasukPenunjangV']['tgl_akhirl2'])) {
        $modPasienMasukPenunjang->tgl_akhirl2 = $format->formatDateTimeForDb($_REQUEST['ROPasienMasukPenunjangV']['tgl_akhirl2']);
      }
     
      if(Yii::app()->request->isAjaxRequest) {
        if(isset($_GET['ajax']) && $_GET['ajax'] == 'daftarpasien-v-grid') {
          $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
          $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
          $this->renderPartial('_table', ['modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'module' => $module, 'controller' => $controller]);
          Yii::app()->end();
        }
      }
    }
    $this->render('index', array('modPasienMasukPenunjang' => $modPasienMasukPenunjang));
  }

  public function actionUbahPemeriksa($pendaftaran_id, $pasienmasukpenunjang_id)
    {

        $this->layout = '//layouts/iframe';

        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPendaftaran->nama_pasien = $modPendaftaran->pasien->nama_pasien;

        $modPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
        $modPenunjang->pegawai_nama = $modPenunjang->pegawai->namaLengkap;
       
        if (isset($_POST['PasienmasukpenunjangT'])) {

            $transaction = Yii::app()->db->beginTransaction();
                try {
        
                  $save = PasienmasukpenunjangT::model()->updateByPk($pasienmasukpenunjang_id, ['pegawai_id' => $_POST['PasienmasukpenunjangT']['pegawaibaru_id'],
                   'update_time' => date('Y-m-d H:i:s'), 'update_loginpemakai_id' => Yii::app()->user->getState('loginpemakai_id')]);

                    if($save) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', 'Data Berhasil Disimpan!');
                        $this->redirect(array('UbahPemeriksa', 'pendaftaran_id'=>$pendaftaran_id, 'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id, 'sukses' => 1));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', 'Data gagal disimpan!');
                    }
                } catch (Exception $exc) {
                    echo '<pre>';var_dump($exc);die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', 'Data gagal disimpan!');

                }
        }

   
        $this->render($this->path_view_rad . '_formEditPemeriksa', array(
            'modPendaftaran' => $modPendaftaran, 
            'modPenunjang' => $modPenunjang, 
        ));
        
    }

  /**
   * mengenerate hasil pemeriksaan radiologi
   * @param type $pendaftaran_id
   * @param type $pasien_id
   * @param type $pasienmasukpenunjang_id
   */
  // public function actionHasilPemeriksaan($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id)
  // {
  //   $modPasienMasukPenunjang = ROPasienMasukPenunjangV::model()->findByAttributes(
  //     array(
  //       'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
  //     )
  //   );
  //   $modPendaftaran = ROPendaftaranMp::model()->findByPk($pendaftaran_id);
  //   $modRujukan = RORujukanT::model()->findByPk($modPendaftaran->rujukan_id);
  //   $modRujukan2 = RujukandariM::model()->findByPk($modPendaftaran->rujukan_id);
  //   $modPasienMorbiditas = new ROPasienmorbiditasT();
  //   $modAnamnesa = array();
  //   $modPemeriksaan = array();
  //   if (!empty($pendaftaran_id)) {
  //     $pendaftaran_id = $pendaftaran_id;
  //     $anamnesa = ROAnamnesaT::model()->find('pendaftaran_id = ' . $pendaftaran_id);
  //     if (!empty($anamnesa)) {
  //       $modAnamnesa = $anamnesa;
  //     } else {
  //       $modAnamnesa = new ROAnamnesaT();
  //       $modAnamnesa->pendaftaran_id = $pendaftaran_id;
  //     }
  //     $modAnamnesa->pendaftaran_id = $modAnamnesa->pendaftaran_id;

  //     $periksafisik = ROPemeriksaanfisikT::model()->find('pendaftaran_id = ' . $pendaftaran_id);
  //     if (!empty($periksafisik)) {
  //       $modPemeriksaan = $periksafisik;
  //     } else {
  //       $modPemeriksaan = new ROPemeriksaanfisikT;
  //       $modPemeriksaan->pendaftaran_id = $pendaftaran_id;
  //     }
  //   }
  //   if (isset($_POST['RORujukanT'])) { // Update Dokter Perujuk pada RujukanT
  //     $modRujukan->rujukandari_id = $_POST['RORujukanT']['rujukandari_id'];
  //     $modRujukanDari = RujukandariM::model()->findByPk($modRujukan->rujukandari_id);
  //     $modRujukan->nama_perujuk = $modRujukanDari->namaperujuk;
  //     $modRujukan->update();
  //   }

  //   if (isset($_POST['ROHasilpemeriksaanradT'])) {
  //     $transaction = Yii::app()->db->beginTransaction();
  //     try {
  //       /*
  //                   $hasilLama = HasilpemeriksaanradT::model()->findByAttributes(array(
  //                       'pasienmasukpenunjang_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id,
  //                       'statusperiksahasil'=>'SUDAH',
  //                   ));
  //                    *
  //                    */

  //       $this->saveHasilPemeriksaan($_POST['ROHasilpemeriksaanradT'], $pasienmasukpenunjang_id);

  //       //Update dokter pemeriksa (pegawai_id) pada pasien masuk penunjang
  //       ROPasienmasukpenunjangT::model()->updateByPk(
  //         $pasienmasukpenunjang_id,
  //         array(
  //           'pegawai_id' => $modPasienMasukPenunjang->pegawai_id,
  //           'statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA
  //         )
  //       );

  //       if ($modPasienMasukPenunjang->ruanganasal_id == $modPasienMasukPenunjang->ruangan_id) {

  //         $judul = 'Pasien sudah periksa Radiologi';
  //         $isi = $modPasienMasukPenunjang->no_pendaftaran . " - " . $modPasienMasukPenunjang->no_rekam_medik . ' ' . $modPasienMasukPenunjang->nama_pasien;

  //         $arr = array(
  //           'pendaftaran_id' => $modPasienMasukPenunjang->pendaftaran_id,
  //           'instalasi_id' => Yii::app()->user->getState('instalasi_id'),
  //         );

  //         $isi .= CHtml::link('<br/><u>Klik ini untuk melakukan pembayaran.</u>', Yii::app()->createUrl('/billingKasir/PembayaranTagihanPasienPenunjang/index', $arr));

  //         $ok = CustomFunction::broadcastNotif($judul, $isi, array(
  //           array('instalasi_id' => Params::INSTALASI_ID_KEUANGAN, 'ruangan_id' => Params::RUANGAN_ID_KASIR, 'modul_id' => Params::MODUL_ID_BILLINGKASIR),
  //         ));


  //         PendaftaranT::model()->updateByPk($modPasienMasukPenunjang->pendaftaran_id, array(
  //           'statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA
  //         ));
  //       } else {
  //         // if (empty($hasilLama)) {

  //         $hasilBaru = HasilpemeriksaanradT::model()->findByAttributes(array(
  //           'pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id,
  //           'statusperiksahasil' => 'SUDAH',
  //         ));

  //         //$pasien = PasienmasukpenunjangV::model()->find(" pasienmasukpenunjang_id = '".$pasienmasukpenunjang_id."' ");
  //         //$up = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
  //         $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
  //         $modul = RuanganM::model()->findByPk($modPasienMasukPenunjang->ruanganasal_id);

  //         $judul = 'Hasil Pemeriksaan Radiologi';
  //         $isi =  $peg->namaLengkap . ' sudah mencatatkan / mengubah data hasil pemeriksaan untuk pasien ' . $modPasienMasukPenunjang->nama_pasien . ' (No RM' . $modPasienMasukPenunjang->no_rekam_medik . ' - ' . $modPasienMasukPenunjang->no_pendaftaran . ') pada tanggal ' . MyFormatter::formatDateTimeForUser($hasilBaru->tglpegambilanhasilrad);


  //         $this->broadcastNotifHasilPemeriksaan($judul, $isi, $modPasienMasukPenunjang, $modul);
  //         /*
  //                           $ok = CustomFunction::broadcastNotif($judul, $isi, array(
  //                                  array('instalasi_id'=>$modPasienMasukPenunjang->instalasiasal_id, 'ruangan_id'=> $modPasienMasukPenunjang->ruanganasal_id, 'modul_id'=>$modul->modul_id ),
  //                           ));
  //                            *
  //                            */

  //         // }
  //       }
  //       //                    die;
  //       $transaction->commit();
  //       Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
  //       //$this->redirect(array('index'));
  //       $this->redirect(array('hasilPemeriksaan', 'pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $pasien_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
  //       //                    $this->redirect($this->createUrl("/radiologi/lihatHasil/HasilPeriksa", array('pendaftaran_id'=>$pendaftaran_id,'pasien_id'=>$pasien_id,'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,'caraPrint'=>'PRINT')));
  //     } catch (Exception $exc) {
  //       $transaction->rollback();
  //       Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
  //     }
  //   }

  //   $modHasilpemeriksaanRad = ROHasilpemeriksaanradT::model()->with('pemeriksaanrad')->findAllByAttributes(
  //     array(
  //       'pendaftaran_id' => $pendaftaran_id,
  //       'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
  //       'pasien_id' => $pasien_id,
  //     )
  //   );


  //   if (empty($modHasilpemeriksaanRad)) {
  //     $this->redirect(
  //       $this->createUrl(
  //         '/radiologi/pemeriksaanPasienRadiologi/index',
  //         array(
  //           'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
  //         )
  //       )
  //     );
  //   }
  //   $this->render(
  //     'hasilPemeriksaan',
  //     array(
  //       'modHasilpemeriksaanRad' => $modHasilpemeriksaanRad,
  //       'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
  //       'modPendaftaran' => $modPendaftaran,
  //       'modRujukan' => $modRujukan,
  //       'modRujukan2' => $modRujukan2,
  //     //   'modRujukanDari'=>$modRujukanDari,
  //       'modAnamnesa' => $modAnamnesa,
  //       'modPemeriksaan' => $modPemeriksaan,
  //       'modPasienMorbiditas' => $modPasienMorbiditas
  //     )
  //   );
  // }



  public function actionHasilPemeriksaan($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id) {
    $modPasienMasukPenunjang = ROPasienMasukPenunjangV::model()->findByAttributes(
            array(
                'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
            )
    );
    $modPendaftaran = ROPendaftaranMp::model()->findByPk($pendaftaran_id);
    $modRujukan = RORujukanT::model()->findByPk($modPendaftaran->rujukan_id);
    $modPasienMorbiditas = new ROPasienmorbiditasT();
    $modAnamnesa = array();
    $modPemeriksaan = array();
    if (!empty($pendaftaran_id)) {
        $pendaftaran_id = $pendaftaran_id;
        $anamnesa = ROAnamnesaT::model()->find('pendaftaran_id = ' . $pendaftaran_id);
        if (!empty($anamnesa)) {
            $modAnamnesa = $anamnesa;
        } else {
            $modAnamnesa = new ROAnamnesaT();
            $modAnamnesa->pendaftaran_id = $pendaftaran_id;
        }
        $modAnamnesa->pendaftaran_id = $modAnamnesa->pendaftaran_id;

        $periksafisik = ROPemeriksaanfisikT::model()->find('pendaftaran_id = ' . $pendaftaran_id);
        if (!empty($periksafisik)) {
            $modPemeriksaan = $periksafisik;
        } else {
            $modPemeriksaan = new ROPemeriksaanfisikT;
            $modPemeriksaan->pendaftaran_id = $pendaftaran_id;
        }
    }
    $modPasienPenunjang = ROPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
    if (isset($_POST['ROPasienmasukpenunjangT'])) { // Update Dokter Perujuk pada RujukanT
        $modPasienPenunjang->ppds_id = $_POST['ROPasienmasukpenunjangT']['ppds_id'];
        $modPasienPenunjang->update();
    }
    if (isset($_POST['RORujukanT'])) { // Update Dokter Perujuk pada RujukanT
        $modRujukan->rujukandari_id = $_POST['RORujukanT']['rujukandari_id'];
        $modRujukanDari = RujukandariM::model()->findByPk($modRujukan->rujukandari_id);
        $modRujukan->nama_perujuk = $modRujukanDari->namaperujuk;
        $modRujukan->update();
    }

    if (isset($_POST['ROHasilpemeriksaanradT'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {

            if (!empty($_GET['baru'])) {
                $this->saveHasilPemeriksaan($_POST['ROHasilpemeriksaanradT']);
            } else {
                $this->saveHasilPemeriksaan($_POST['ROHasilpemeriksaanradT']);
            }

            //Update dokter pemeriksa (pegawai_id) pada pasien masuk penunjang
            if (isset($_POST['ROPasienmasukpenunjangT']['ppds_id'])) {
                ROPasienmasukpenunjangT::model()->updateByPk(
                    $pasienmasukpenunjang_id, array(
                        'ppds_id' => $_POST['ROPasienmasukpenunjangT']['ppds_id'],
                    )
                );
            }

            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
            //$this->redirect(array('index'));
            $this->redirect(array('hasilPemeriksaan', 'pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $pasien_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
            //                    $this->redirect($this->createUrl("/radiologi/lihatHasil/HasilPeriksa", array('pendaftaran_id'=>$pendaftaran_id,'pasien_id'=>$pasien_id,'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,'caraPrint'=>'PRINT')));
        } catch (Exception $exc) {
            $transaction->rollback(); var_dump($exc->getMessage()); die;
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        }
    }

    $modHasilpemeriksaanRad = ROHasilpemeriksaanradT::model()->with('pemeriksaanrad')->findAllByAttributes(
            array(
                'pendaftaran_id' => $pendaftaran_id,
                'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
                'pasien_id' => $pasien_id,
            )
    );

    if (empty($modHasilpemeriksaanRad)) {
        $this->redirect(
                $this->createUrl(
                        '/radiologi/pemeriksaanPasienRadiologi/index', array(
                    'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
                        )
                )
        );
    }
    $this->render(
        'hasilPemeriksaan', array(
            'modHasilpemeriksaanRad' => $modHasilpemeriksaanRad,
            'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
            'modPasienPenunjang' => $modPasienPenunjang,
            'modPendaftaran' => $modPendaftaran,
            'modRujukan' => $modRujukan,
            'modAnamnesa' => $modAnamnesa,
            'modPemeriksaan' => $modPemeriksaan,
            'modPasienMorbiditas' => $modPasienMorbiditas
        )
    );
}


  protected function broadcastNotifHasilPemeriksaan($judul, $isi, $pasien, $modul)
  {

    $link = null;


    // var_dump($pasien->instalasiasal_id); die;

    // rawat jalan
    if ($pasien->instalasiasal_id == Params::INSTALASI_ID_RJ) {
      $link = Yii::app()->createUrl('/rawatJalan/daftarPasien/index', array(
        'RJInfokunjunganrjV[tgl_awal]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'RJInfokunjunganrjV[tgl_akhir]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'RJInfokunjunganrjV[no_pendaftaran]' => substr($pasien->no_pendaftaran, 2),
        //'RJInfokunjunganrjV[nama_pasien]'=>$model->pasien->nama_pasien,
        //'RJInfokunjunganrjV[no_rekam_medik]'=>$model->pasien->no_rekam_medik,
        'RJInfokunjunganrjV[ceklis]' => false,
        'RJInfokunjunganrjV[tgl_awall]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'RJInfokunjunganrjV[tgl_akhirl]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran))
      ));
    }

    if ($pasien->instalasiasal_id == Params::INSTALASI_ID_RD) {
      $link = Yii::app()->createUrl('/rawatDarurat/DaftarPasien/Index', array(
        'RDInfoKunjunganRDV[tgl_awal]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'RDInfoKunjunganRDV[tgl_awall]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'RDInfoKunjunganRDV[tgl_akhir]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'RDInfoKunjunganRDV[tgl_akhirl]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'RDInfoKunjunganRDV[no_pendaftaran]' => substr($pasien->no_pendaftaran, 2),
        //'RDInfoKunjunganRDV[nama_pasien]'=>$pasien->pasien->nama_pasien,
        //'RDInfoKunjunganRDV[no_rekam_medik]'=>$pasien->pasien->no_rekam_medik,
        'RDInfoKunjunganRDV[ceklis]' => 0
      ));
    }

    if ($pasien->ruanganasal_id == Params::RUANGAN_ID_VK) {
      $link = Yii::app()->createUrl('/persalinan/DaftarPasien/Index', array(
        'PSInfokunjunganpersalinanV[tgl_awal]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'PSInfokunjunganpersalinanV[tgl_awall]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'PSInfokunjunganpersalinanV[tgl_akhir]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'PSInfokunjunganpersalinanV[tgl_akhirl]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'PSInfokunjunganpersalinanV[no_pendaftaran]' => substr($pasien->no_pendaftaran, 2),
        //'PSInfokunjunganpersalinanV[nama_pasien]'=>$pasien->pasien->nama_pasien,
        //'PSInfokunjunganpersalinanV[no_rekam_medik]'=>$pasien->pasien->no_rekam_medik,
        'PSInfokunjunganpersalinanV[ceklis]' => 0
      ));
    }


    if ($pasien->instalasiasal_id == Params::INSTALASI_ID_HD) {
      $link = Yii::app()->createUrl('/hemodialisa/DaftarPasien/index', array(
        'HDInfoKunjunganRDV[tgl_awal]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'HDInfoKunjunganRDV[tgl_akhir]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'HDInfoKunjunganRDV[tgl_awall]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'HDInfoKunjunganRDV[tgl_akhirl]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'HDInfoKunjunganRDV[ceklis]' => 0,
        //'HDInfoKunjunganRDV[no_rekam_medik]'=>$model->pasien->no_rekam_medik,
        'HDInfoKunjunganRDV[no_pendaftaran]' => substr($pasien->no_pendaftaran, 2),
        //'HDInfoKunjunganRDV[nama_pasien]'=>$model->pasien->nama_pasien,
      ));
    }
    //        echo $link; die;

    if ($pasien->instalasiasal_id == Params::INSTALASI_ID_RI) {
      $link = Yii::app()->createUrl('/rawatInap/PasienRawatInap/Index', array(
        'RIInfopasienmasukkamarV[tgl_awal]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'RIInfopasienmasukkamarV[tgl_awall]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'RIInfopasienmasukkamarV[tgl_akhir]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'RIInfopasienmasukkamarV[tgl_akhirl]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'RIInfopasienmasukkamarV[no_pendaftaran]' => substr($pasien->no_pendaftaran, 2),
        //'RIInfopasienmasukkamarV[nama_pasien]' => $model->pasien->nama_pasien,
        //'RIInfopasienmasukkamarV[no_rekam_medik]' => $pasien->pasien->no_rekam_medik,
        'RIInfopasienmasukkamarV[prefix_pendaftaran]' => substr($pasien->no_pendaftaran, 0, 2),
        'RIInfopasienmasukkamarV[ruangan_id]' => $pasien->ruangan_id,
        'RIInfopasienmasukkamarV[ceklis]' => '',
        'RIInfopasienmasukkamarV[ceklisAdmisi]' => '',
        'RIInfopasienmasukkamarV[is_nursestation]' => '',
      ));
    }

    if ($pasien->instalasiasal_id == Params::INSTALASI_ID_ICU) {
      $link = Yii::app()->createUrl('/perawatanIntensif/PasienRawatIntensif/Index', array(
        'PIInfopasienmasukkamarV[tgl_awal]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'PIInfopasienmasukkamarV[tgl_awall]' => date('Y-m-01', strtotime($pasien->tgl_pendaftaran)),
        'PIInfopasienmasukkamarV[tgl_akhir]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'PIInfopasienmasukkamarV[tgl_akhirl]' => date('Y-m-t', strtotime($pasien->tgl_pendaftaran)),
        'PIInfopasienmasukkamarV[no_pendaftaran]' => substr($pasien->no_pendaftaran, 2),
        //'PIInfopasienmasukkamarV[nama_pasien]' => $model->pasien->nama_pasien,
        //'PIInfopasienmasukkamarV[no_rekam_medik]' => $model->pasien->no_rekam_medik,
        'PIInfopasienmasukkamarV[prefix_pendaftaran]' => substr($pasien->no_pendaftaran, 0, 2),
        'PIInfopasienmasukkamarV[ruangan_id]' => $pasien->ruangan_id,
        'PIInfopasienmasukkamarV[ceklis]' => '',
        'PIInfopasienmasukkamarV[ceklisAdmisi]' => '',
        'PIInfopasienmasukkamarV[is_nursestation]' => '',
      ));
    }

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $pasien->instalasiasal_id, 'ruangan_id' => $pasien->ruanganasal_id, 'modul_id' => $modul->modul_id, 'link_proses' => $link),
    ));


    //            echo $link; die;

  }

  /**
   * mengenerate hasil referensi hasil radiologi
   */
  public function actionGetReferensiHasilRad()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = array();
      $idPemeriksaanRad = $_POST['idPemeriksaanRad'];
      $banyak = $_POST['banyak'];
      $jeniskelamin = isset($_POST['jeniskelamin']) ? $_POST['jeniskelamin'] : null;

      if ($banyak == 'false') {
        $modReferensi = ReferensihasilradM::model()->findByPk($idPemeriksaanRad);
        if ($modReferensi) {
          $attributeRef = $modReferensi->attributeNames();
          foreach ($attributeRef as $attribute) {
            $data[$attribute] = $modReferensi->$attribute;
          }
        }
      } else {
        $refHasilRad = ROReferensiHasilRadM::model()->findByAttributes(array('pemeriksaanrad_id' => $idPemeriksaanRad, 'refhasilrad_banyak' => true));
        $refHasilDet = null;
        if (!empty($refHasilRad)) {

          $criDet = new CDbCriteria();
          $criDet->select = " t.*, hp.hasilpemeriksaanrad_id, pr.hasperiksaraddet_id, pr.hasperiksaraddet_expertise ";
          $criDet->join = " LEFT JOIN hasilperiksaraddet_t pr ON pr.refhasildet_id = t.refhasildet_id "
            .  " LEFT JOIN hasilpemeriksaanrad_t hp ON  hp.hasilpemeriksaanrad_id = pr.hasilpemeriksaanrad_id "
            .   "  ";
          $criDet->addCondition(" refhasilrad_id = " . $refHasilRad->refhasilrad_id . " AND  refhasildet_aktif = TRUE ");
          $criDet->addCondition(" t.refhasildet_jk = '" . $jeniskelamin . "' OR  t.refhasildet_jk = '' ");
          $criDet->order = " refhasildet_urut ASC ";
          $refHasilDet = ROReferensihasildetM::model()->findAll($criDet);

          foreach ($refHasilDet as $key => $val) {
            $data[$key] = $val;
          }
        }
      }

      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }

  /**
   * fungsi simpan hasil pemeriksaan
   * @param type $arrHasil
   */



  protected function saveHasilPemeriksaan($arrHasil) {
    $format = new MyFormatter();
    $tglpegambilanhasilrad = $format->formatDateTimeForDb($arrHasil[0]['tglpegambilanhasilrad']);
    $ok = true;
    if (trim($tglpegambilanhasilrad) == '') {
        $tglpegambilanhasilrad = null;
    }

    
    foreach ($arrHasil as $i => $hasil) {
        $get = '';                 
        if (!isset($hasil['kesan_hasilrad'])){
            $hasil['kesan_hasilrad'] = '';
        }
                    
        if (isset($hasil["det"])) {
            if (is_array($hasil["det"])) {
                foreach ($hasil['det'] as $val) {
                    $get .= $val['hasilexpertise'] . ' {{pisah}}';
                }
            }
                 
            if (empty($get)){
                $get = isset($hasil['hasilexpertise'])?$hasil['hasilexpertise']:null;
            }
            
            if (empty($_GET['baru'])) {
                $upHasila = ROHasilpemeriksaanradT::model()->findByPk(
                        $hasil['hasilpemeriksaanrad_id']
                );
                //$cekdata = HasilpemeriksaanradR::model()->findAll();
                $cek = HasilpemeriksaanradR::model()->findByAttributes(array('pendaftaran_id' => $upHasila->pendaftaran_id, 'pasien_id' => $upHasila->pasien_id, 'pasienmasukpenunjang_id' => $upHasila->pasienmasukpenunjang_id, 'pemeriksaanrad_id' => $upHasila->pemeriksaanrad_id));
                $cekAll = HasilpemeriksaanradR::model()->findAllByAttributes(array('pendaftaran_id' => $upHasila->pendaftaran_id, 'pasien_id' => $upHasila->pasien_id, 'pasienmasukpenunjang_id' => $upHasila->pasienmasukpenunjang_id));

                if (count($cekAll) == 2) {                        
                    $upHasils = new HasilpemeriksaanradR;
                    $cekSecond = HasilpemeriksaanradR::model()->findByAttributes(array('pendaftaran_id' => $upHasila->pendaftaran_id, 'pasien_id' => $upHasila->pasien_id, 'pasienmasukpenunjang_id' => $upHasila->pasienmasukpenunjang_id, 'is_secondopinion' => true, 'pemeriksaanrad_id' => $upHasila->pemeriksaanrad_id));
                    if (!empty($cekSecond)){
                        $upHasils = $cekSecond;
                        $upHasils->statusperiksahasil = Params::STATUSPERIKSAHASIL_SUDAH;
                        $upHasils->statuskirim_hasilrad = Params::STATUSKIRIM_HASILRAD_SIAP_KIRIM;                            
                    }else{
                        //$upHasils->riwayathasilpemeriksaanrad_id = count($cekdata) + 1;
                        $upHasils->pasienmasukpenunjang_id = $upHasila->pasienmasukpenunjang_id;
                        $upHasils->pendaftaran_id = $upHasila->pendaftaran_id;
                        $upHasils->pasien_id = $upHasila->pasien_id;
                        $upHasils->pasienadmisi_id = $upHasila->pasienadmisi_id;                                                        
                        $upHasils->tindakanpelayanan_id = $upHasila->tindakanpelayanan_id;
                        $upHasils->pemeriksaanrad_id = $upHasila->pemeriksaanrad_id;
                        $upHasils->tglpemeriksaanrad = $upHasila->tglpemeriksaanrad;
                        $upHasils->create_time = date("Y-m-d H:i:s");
                        $upHasils->create_loginpemakai_id = Yii::app()->user->id;
                        $upHasils->create_ruangan = $upHasila->create_ruangan;
                        $upHasils->is_secondopinion = true;
                    }
                    $upHasils->hasilexpertise = $get;
                    $upHasils->kesan_hasilrad = $hasil['kesan_hasilrad'];
                    $upHasils->kesimpulan_hasilrad = $hasil['kesimpulan_hasilrad'];
                    $upHasils->tglpengambilanhasilrad = $tglpegambilanhasilrad;
                    
                    $upHasils->save();
                } else {
                    if (empty($cek)) {
                        $upHasils = new HasilpemeriksaanradR;
                        //$upHasils->riwayathasilpemeriksaanrad_id = count($cekdata) + 1;
                        $upHasils->pasienmasukpenunjang_id = $upHasila->pasienmasukpenunjang_id;
                        $upHasils->pendaftaran_id = $upHasila->pendaftaran_id;
                        $upHasils->pasien_id = $upHasila->pasien_id;
                        $upHasils->pasienadmisi_id = $upHasila->pasienadmisi_id;
                        $upHasils->hasilexpertise = $get;
                        $upHasils->kesan_hasilrad = $hasil['kesan_hasilrad'];
                        $upHasils->kesimpulan_hasilrad = $hasil['kesimpulan_hasilrad'];
                        $upHasils->tglpengambilanhasilrad = $tglpegambilanhasilrad;
                        $upHasils->tindakanpelayanan_id = $upHasila->tindakanpelayanan_id;
                        $upHasils->pemeriksaanrad_id = $upHasila->pemeriksaanrad_id;
                        $upHasils->tglpemeriksaanrad = $upHasila->tglpemeriksaanrad;
                        $upHasils->create_time = date("Y-m-d H:i:s");
                        $upHasils->create_loginpemakai_id = Yii::app()->user->id;
                        $upHasils->create_ruangan = $upHasila->create_ruangan;

                        $upHasils->save();
                    } else {
                        $upHasils = HasilpemeriksaanradR::model()->findByAttributes(array('pendaftaran_id' => $upHasila->pendaftaran_id, 'pasien_id' => $upHasila->pasien_id, 'pasienmasukpenunjang_id' => $upHasila->pasienmasukpenunjang_id, 'pemeriksaanrad_id' => $upHasila->pemeriksaanrad_id));                            
                        $upHasils->hasilexpertise = $get;
                        $upHasils->kesan_hasilrad = $hasil['kesan_hasilrad'];
                        $upHasils->kesimpulan_hasilrad = $hasil['kesimpulan_hasilrad'];
                        $upHasils->tglpengambilanhasilrad = $tglpegambilanhasilrad;
                        $upHasils->statusperiksahasil = Params::STATUSPERIKSAHASIL_SUDAH;
                        $upHasils->statuskirim_hasilrad = Params::STATUSKIRIM_HASILRAD_SIAP_KIRIM;
                        $upHasils->update();
                    }

                    $upHasil = ROHasilpemeriksaanradT::model()->updateByPk(
                            $hasil['hasilpemeriksaanrad_id'], array(
                        'kesan_hasilrad' => isset($hasil['kesan_hasilrad']) ? $hasil['kesan_hasilrad'] : null,
                        'kesimpulan_hasilrad' => $hasil['kesimpulan_hasilrad'],
                        'tglpegambilanhasilrad' => $tglpegambilanhasilrad,
                        'statusperiksahasil' => Params::STATUSPERIKSAHASIL_SUDAH,
                        'statuskirim_hasilrad' => Params::STATUSKIRIM_HASILRAD_SIAP_KIRIM,
                            )
                    );
                }
            } else {
                $upHasila = ROHasilpemeriksaanradT::model()->findByPk(
                        $hasil['hasilpemeriksaanrad_id']
                );
                //$cekdata = HasilpemeriksaanradR::model()->findAll();

                $upHasils = new HasilpemeriksaanradR;
                //$upHasils->riwayathasilpemeriksaanrad_id = count($cekdata) + 1;
                $upHasils->pasienmasukpenunjang_id = $upHasila->pasienmasukpenunjang_id;
                $upHasils->pendaftaran_id = $upHasila->pendaftaran_id;
                $upHasils->pasien_id = $upHasila->pasien_id;
                $upHasils->pasienadmisi_id = $upHasila->pasienadmisi_id;
                $upHasils->hasilexpertise = $get;
                $upHasils->kesan_hasilrad = $hasil['kesan_hasilrad'];
                $upHasils->kesimpulan_hasilrad = $hasil['kesimpulan_hasilrad'];
                $upHasils->tglpengambilanhasilrad = $tglpegambilanhasilrad;
                $upHasils->tindakanpelayanan_id = $upHasila->tindakanpelayanan_id;
                $upHasils->pemeriksaanrad_id = $upHasila->pemeriksaanrad_id;
                $upHasils->tglpemeriksaanrad = $upHasila->tglpemeriksaanrad;
                $upHasils->create_time = date("Y-m-d H:i:s");
                $upHasils->create_loginpemakai_id = Yii::app()->user->id;
                $upHasils->create_ruangan = $upHasila->create_ruangan;
                $upHasils->is_secondopinion = true;
                $upHasils->save();


                $upHasil = ROHasilpemeriksaanradT::model()->updateByPk(
                        $hasil['hasilpemeriksaanrad_id'], array(
                    'kesan_hasilrad' => isset($hasil['kesan_hasilrad']) ? $hasil['kesan_hasilrad'] : null,
                    'kesimpulan_hasilrad' => $hasil['kesimpulan_hasilrad'],
                    'tglpegambilanhasilrad' => $tglpegambilanhasilrad,
                    'statusperiksahasil' => Params::STATUSPERIKSAHASIL_SUDAH,
                    'statuskirim_hasilrad' => Params::STATUSKIRIM_HASILRAD_SIAP_KIRIM,
                    'pegawai_verifikasi_id' => null,
                    'tglverifikasi_dpjp' => null
                        )
                );
            }

            $upHasil = ROHasilpemeriksaanradT::model()->updateByPk(
                    $hasil['hasilpemeriksaanrad_id'], array('hasilexpertise' => isset($hasil["hasilexpertise"]) ? $hasil["hasilexpertise"] : null,
                'kesan_hasilrad' => isset($hasil['kesan_hasilrad']) ? $hasil['kesan_hasilrad'] : null,
                'kesimpulan_hasilrad' => $hasil['kesimpulan_hasilrad'],
                'tglpegambilanhasilrad' => $tglpegambilanhasilrad,
                'statusperiksahasil' => Params::STATUSPERIKSAHASIL_SUDAH,
                'statuskirim_hasilrad' => Params::STATUSKIRIM_HASILRAD_SIAP_KIRIM,
                    )
            );
        } else {

            if (empty($_GET['baru'])) {
                $upHasila = ROHasilpemeriksaanradT::model()->findByPk(
                        $hasil['hasilpemeriksaanrad_id']
                );
                //$cekdata = HasilpemeriksaanradR::model()->findAll();
                $cek = HasilpemeriksaanradR::model()->findByAttributes(array('pendaftaran_id' => $upHasila->pendaftaran_id, 'pasien_id' => $upHasila->pasien_id, 'pasienmasukpenunjang_id' => $upHasila->pasienmasukpenunjang_id, 'pemeriksaanrad_id' => $upHasila->pemeriksaanrad_id));
                $cekAll = HasilpemeriksaanradR::model()->findAllByAttributes(array('pendaftaran_id' => $upHasila->pendaftaran_id, 'pasien_id' => $upHasila->pasien_id, 'pasienmasukpenunjang_id' => $upHasila->pasienmasukpenunjang_id));

                if (count($cekAll) == 2) {
                    $upHasils = HasilpemeriksaanradR::model()->findByAttributes(array('pendaftaran_id' => $upHasila->pendaftaran_id, 'pasien_id' => $upHasila->pasien_id, 'pasienmasukpenunjang_id' => $upHasila->pasienmasukpenunjang_id, 'is_secondopinion' => true, 'pemeriksaanrad_id' => $upHasila->pemeriksaanrad_id));
                    
                    if(empty($upHasils)) {
                      $upHasils = new HasilpemeriksaanradR;
                      $upHasils->pendaftaran_id = $upHasila->pendaftaran_id;
                      $upHasils->pasien_id = $upHasila->pasien_id;
                      $upHasils->pasienmasukpenunjang_id = $upHasila->pasienmasukpenunjang_id;
                      $upHasils->pemeriksaanrad_id = $upHasila->pemeriksaanrad_id;
                      $upHasils->is_secondopinion = true;
                    }

                    $upHasils->hasilexpertise = $hasil['hasilexpertise'];
                    $upHasils->kesan_hasilrad = $hasil['kesan_hasilrad'];
                    $upHasils->kesimpulan_hasilrad = $hasil['kesimpulan_hasilrad'];
                    $upHasils->tglpengambilanhasilrad = $tglpegambilanhasilrad;
                    $upHasils->statusperiksahasil = Params::STATUSPERIKSAHASIL_SUDAH;
                    $upHasils->statuskirim_hasilrad = Params::STATUSKIRIM_HASILRAD_SIAP_KIRIM;
                    $upHasils->save();
                } else {
                    if (empty($cek)) {
                        $upHasils = new HasilpemeriksaanradR;
                        //$upHasils->riwayathasilpemeriksaanrad_id = count($cekdata) + 1;
                        $upHasils->pasienmasukpenunjang_id = $upHasila->pasienmasukpenunjang_id;
                        $upHasils->pendaftaran_id = $upHasila->pendaftaran_id;
                        $upHasils->pasien_id = $upHasila->pasien_id;
                        $upHasils->pasienadmisi_id = $upHasila->pasienadmisi_id;
                        $upHasils->hasilexpertise = $hasil['hasilexpertise'];
                        $upHasils->kesan_hasilrad = $hasil['kesan_hasilrad'];
                        $upHasils->kesimpulan_hasilrad = $hasil['kesimpulan_hasilrad'];
                        $upHasils->tglpengambilanhasilrad = $tglpegambilanhasilrad;
                        $upHasils->tindakanpelayanan_id = $upHasila->tindakanpelayanan_id;
                        $upHasils->pemeriksaanrad_id = $upHasila->pemeriksaanrad_id;
                        $upHasils->tglpemeriksaanrad = $upHasila->tglpemeriksaanrad;
                        $upHasils->create_time = date("Y-m-d H:i:s");
                        $upHasils->create_loginpemakai_id = Yii::app()->user->id;
                        $upHasils->create_ruangan = $upHasila->create_ruangan;

                        $upHasils->save();
                    } else {
                        $upHasils = HasilpemeriksaanradR::model()->findByAttributes(array('pendaftaran_id' => $upHasila->pendaftaran_id, 'pasien_id' => $upHasila->pasien_id, 'pasienmasukpenunjang_id' => $upHasila->pasienmasukpenunjang_id, 'pemeriksaanrad_id' => $upHasila->pemeriksaanrad_id));
                        $upHasils->hasilexpertise = $hasil['hasilexpertise'];
                        $upHasils->kesan_hasilrad = $hasil['kesan_hasilrad'];
                        $upHasils->kesimpulan_hasilrad = $hasil['kesimpulan_hasilrad'];
                        $upHasils->tglpengambilanhasilrad = $tglpegambilanhasilrad;
                        $upHasils->statusperiksahasil = Params::STATUSPERIKSAHASIL_SUDAH;
                        $upHasils->statuskirim_hasilrad = Params::STATUSKIRIM_HASILRAD_SIAP_KIRIM;
                        $upHasils->update();
                    }

                    $upHasil = ROHasilpemeriksaanradT::model()->updateByPk(
                        $hasil['hasilpemeriksaanrad_id'], array(
                        'kesan_hasilrad' => isset($hasil['kesan_hasilrad']) ? $hasil['kesan_hasilrad'] : null,
                        'kesimpulan_hasilrad' => $hasil['kesimpulan_hasilrad'],
                        'hasilexpertise' => $hasil['hasilexpertise'],
                        'tglpegambilanhasilrad' => $tglpegambilanhasilrad,
                        'statusperiksahasil' => Params::STATUSPERIKSAHASIL_SUDAH,
                        'statuskirim_hasilrad' => Params::STATUSKIRIM_HASILRAD_SIAP_KIRIM,
                            )
                    );
                }
            } else {
                $upHasila = ROHasilpemeriksaanradT::model()->findByPk(
                        $hasil['hasilpemeriksaanrad_id']
                );
                //$cekdata = HasilpemeriksaanradR::model()->findAll();

                $upHasils = new HasilpemeriksaanradR;
                //$upHasils->riwayathasilpemeriksaanrad_id = count($cekdata) + 1;
                $upHasils->pasienmasukpenunjang_id = $upHasila->pasienmasukpenunjang_id;
                $upHasils->pendaftaran_id = $upHasila->pendaftaran_id;
                $upHasils->pasien_id = $upHasila->pasien_id;
                $upHasils->pasienadmisi_id = $upHasila->pasienadmisi_id;
                $upHasils->hasilexpertise = $hasil['hasilexpertise'];
                $upHasils->kesan_hasilrad = $hasil['kesan_hasilrad'];
                $upHasils->kesimpulan_hasilrad = $hasil['kesimpulan_hasilrad'];
                $upHasils->tglpengambilanhasilrad = $tglpegambilanhasilrad;
                $upHasils->tindakanpelayanan_id = $upHasila->tindakanpelayanan_id;
                $upHasils->pemeriksaanrad_id = $upHasila->pemeriksaanrad_id;
                $upHasils->tglpemeriksaanrad = $upHasila->tglpemeriksaanrad;
                $upHasils->create_time = date("Y-m-d H:i:s");
                $upHasils->create_loginpemakai_id = Yii::app()->user->id;
                $upHasils->create_ruangan = $upHasila->create_ruangan;
                $upHasils->is_secondopinion = true;
                $upHasils->save();
                

                $upHasil = ROHasilpemeriksaanradT::model()->updateByPk(
                        $hasil['hasilpemeriksaanrad_id'], array(
                    'kesan_hasilrad' => isset($hasil['kesan_hasilrad']) ? $hasil['kesan_hasilrad'] : null,
                    'kesimpulan_hasilrad' => $hasil['kesimpulan_hasilrad'],
                    'tglpegambilanhasilrad' => $tglpegambilanhasilrad,
                    'statusperiksahasil' => Params::STATUSPERIKSAHASIL_SUDAH,
                    'statuskirim_hasilrad' => Params::STATUSKIRIM_HASILRAD_SIAP_KIRIM,
                    'pegawai_verifikasi_id' => null,
                    'tglverifikasi_dpjp' => null
                        )
                );
            }
        }

        $upHasil = ROHasilpemeriksaanradT::model()->findByPk($hasil['hasilpemeriksaanrad_id']);
        if (isset($hasil["det"])) {
            foreach ($hasil["det"] as $det) {
                $hasilDet = ROHasilperiksaraddetT::model()->findByPk($det['hasperiksaraddet_id']);

                if (!empty($hasilDet)) {
                    $hasilDet->hasperiksaraddet_tgl = $upHasil->tglpegambilanhasilrad;
                    $hasilDet->hasperiksaraddet_expertise = $det['hasilexpertise'];
                    $hasilDet->update_time = date('Y-m-d H:i:s');
                    $hasilDet->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

                    $ok = $ok && $hasilDet->save();
                } else {
                    $hasilDet = new ROHasilperiksaraddetT;
                    //$hasilDet->hasilpemeriksaanrad_id = $upHasil->hasilpemeriksaanrad_id;
                    $hasilDet->refhasildet_id = $det['refhasildet_id'];
                    $hasilDet->hasperiksaraddet_tgl = $upHasil->tglpegambilanhasilrad;
                    $hasilDet->hasperiksaraddet_expertise = $det['hasilexpertise'];
                    $hasilDet->create_time = date('Y-m-d H:i:s');
                    $hasilDet->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $hasilDet->create_ruangan = Yii::app()->user->getState('ruangan_id');

                    $ok = $ok && $hasilDet->save();
                }
            }
        }
    }
}

public function actionVerifikasiAntrian()
{
  if (Yii::app()->request->isAjaxRequest) {
    $format = new MyFormatter();
    $data = array();
    $data['pesan']="";
    $pasienmasukpenunjang_id = ($_POST['pasienmasukpenunjang_id']);
    $pasienmasukpenunjang =  PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

    if($pasienmasukpenunjang->panggilantrian == true) {
        $pasienmasukpenunjang->tgl_pasiendatang = date('Y-m-d H:i:s');
        $pasienmasukpenunjang->is_verifikasi = true;
        
        if($pasienmasukpenunjang->update()){     
          // $this->redirect(
          //   '/radiologi/daftarPasien/index'
          //   );
            $data['pesan']="Verifikasi Berhasil Dilakukan";
          
        }else{
          // $this->redirect(
          //   '/radiologi/daftarPasien/index'
          //   );
            $data['pesan']="Verifikasi gagal dilakukan";
           
        }

    } else {
        $data['pesan']="Panggil Pasien Dahulu";
    }
    
 
      echo CJSON::encode($data);
      Yii::app()->end();
  } else {
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}
  // protected function saveHasilPemeriksaan($arrHasil, $pasienmasukpenunjang_id)
  // {
  //   $format = new MyFormatter();
  //   $modPasienPenunjang = ROPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
  //   $tglmasukpenunjang = $format->formatDateTimeForDb($modPasienPenunjang->tglmasukpenunjang);
  //   $tglpegambilanhasilrad = $format->formatDateTimeForDb($arrHasil[0]['tglpegambilanhasilrad']);
  //   $akhir  = strtotime($tglpegambilanhasilrad);
  //   $awal = strtotime($tglmasukpenunjang);
  //   $diff  = $akhir - $awal;
  //   $jam   = floor($diff / (60 * 60));
  //   $menit = $diff - ($jam * (60 * 60));
  //   $respondtime =  $jam .  ' jam ' . floor($menit / 60) . ' mnt';

  //   // $tglpegambilanhasilrad = $format->formatDateTimeForDb($arrHasil[0]['tglpegambilanhasilrad']);
  //   $ok = true;
  //   if (trim($tglpegambilanhasilrad) == '') $tglpegambilanhasilrad = null;

  //   //echo "<pre>";
  //   //var_dump($arrHasil); //die;
  //   //echo "</pre>";die;
  //   foreach ($arrHasil as $i => $hasil) {
  //     if (is_array($hasil)) {
  //     $get = '';

  //       if (isset($hasil["hasilexpertise"])) {
  //         if (is_array($hasil["hasilexpertise"])) {
  //           foreach ($hasil['hasilexpertise'] as $val) {
  //             $get .= $val . ' {{pisah}}';
  //           }
  //         }

        
  //         $upHasil = ROHasilpemeriksaanradT::model()->updateByPk(
  //           $hasil['hasilpemeriksaanrad_id'],
  //           array(
  //             'hasilexpertise' => isset($hasil["hasilexpertise"]) ? $hasil["hasilexpertise"] : null,
  //             'kesan_hasilrad' => isset($hasil['kesan_hasilrad']) ? $hasil['kesan_hasilrad'] : null,
  //             'kesimpulan_hasilrad' => $hasil['kesimpulan_hasilrad'],
  //             'tglpegambilanhasilrad' => $tglpegambilanhasilrad,
  //             'statusperiksahasil' =>  Params::STATUSPERIKSAHASIL_SUDAH,
  //             'respondtime' => $respondtime
  //           )
  //         );
  //       } else {
  //         $upHasil = ROHasilpemeriksaanradT::model()->updateByPk(
  //           $hasil['hasilpemeriksaanrad_id'],
  //           array(
  //             'kesan_hasilrad' => isset($hasil['kesan_hasilrad']) ? $hasil['kesan_hasilrad'] : null,
  //             'kesimpulan_hasilrad' => $hasil['kesimpulan_hasilrad'],
  //             'tglpegambilanhasilrad' => $tglpegambilanhasilrad,
  //             'statusperiksahasil' =>  Params::STATUSPERIKSAHASIL_SUDAH,
  //             'respondtime' => $respondtime
  //           )
  //         );
  //       }

  //     //   die;




  //       $upHasil = ROHasilpemeriksaanradT::model()->findByPk($hasil['hasilpemeriksaanrad_id']);
  //       if (isset($hasil["det"])) {
  //         foreach ($hasil["det"] as $det) {
  //           $hasilDet = ROHasilperiksaraddetT::model()->findByPk($det['hasperiksaraddet_id']);

  //           if (!empty($hasilDet)) {
  //             $hasilDet->hasperiksaraddet_tgl = $upHasil->tglpegambilanhasilrad;
  //             $hasilDet->hasperiksaraddet_expertise = $det['hasilexpertise'];
  //             $hasilDet->update_time = date('Y-m-d H:i:s');
  //             $hasilDet->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

  //             $ok = $ok && $hasilDet->save();
  //           } else {
  //             $hasilDet = new ROHasilperiksaraddetT;
  //             $hasilDet->hasilpemeriksaanrad_id = $upHasil->hasilpemeriksaanrad_id;
  //             $hasilDet->refhasildet_id = $det['refhasildet_id'];
  //             $hasilDet->hasperiksaraddet_tgl = $upHasil->tglpegambilanhasilrad;
  //             $hasilDet->hasperiksaraddet_expertise = $det['hasilexpertise'];
  //             $hasilDet->create_time = date('Y-m-d H:i:s');
  //             $hasilDet->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
  //             $hasilDet->create_ruangan = Yii::app()->user->getState('ruangan_id');

  //             $ok = $ok && $hasilDet->save();
  //           }
  //         }
  //       }
  //       //var_dump($ok);
  //     }
  //   }     //      die;
  // }

  /**
   * fungsi untuk mengubah data pasien, sesuai attributes yang sudah ditentukan
   * @param type $id
   */
  public function actionUbahPasien($id)
  {
    Yii::import('application.modules.laboratorium.models.ROPasienM');
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = ROPasienM::model()->findByPk($id);
    $format = new MyFormatter();
    $temLogo = $model->photopasien;
    $model->update_time = date('Y-m-d');
    $model->update_loginpemakai_id = Yii::app()->user->id;
    $model->tgl_rekam_medik = $format->formatDateTimeForUser($model->tgl_rekam_medik);
    if (isset($_POST['ROPasienM'])) {
      $random = rand(0000000, 9999999);
      $model->attributes = $_POST['ROPasienM'];
      $model->tanggal_lahir = $format->formatDateTimeForDb($model->tanggal_lahir);
      $model->kelompokumur_id = CustomFunction::getKelompokUmur($model->tanggal_lahir);
      $model->photopasien = CUploadedFile::getInstance($model, 'photopasien');
      $gambar = $model->photopasien;
      $model->tgl_rekam_medik  = $format->formatDateTimeForDb($model->tgl_rekam_medik);

      if (!empty($model->photopasien)) { //if user input the photo of patient
        $model->photopasien = $random . $model->photopasien;

        Yii::import("ext.EPhpThumb.EPhpThumb");

        $thumb = new EPhpThumb();
        $thumb->init(); //this is needed

        $fullImgName = $model->photopasien;
        $fullImgSource = Params::pathPasienDirectory() . $fullImgName;
        $fullThumbSource = Params::pathPasienTumbsDirectory() . 'kecil_' . $fullImgName;

        if ($model->save()) {
          if (!empty($temLogo)) {
            if (file_exists(Params::pathPasienDirectory() . $temLogo))
              unlink(Params::pathPasienDirectory() . $temLogo);
            if (file_exists(Params::pathPasienTumbsDirectory() . 'kecil_' . $temLogo))
              unlink(Params::pathPasienTumbsDirectory() . 'kecil_' . $temLogo);
          }
          $gambar->saveAs($fullImgSource);
          $thumb->create($fullImgSource)
            ->resize(200, 200)
            ->save($fullThumbSource);

          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        } else {
          Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
        }
      } else { //if user not input the photo
        $model->photopasien = $temLogo;
        if ($model->save()) {
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        }
      }
    }
    $this->render($this->path_view . 'ubahPasien', array('model' => $model));
  }

  /**
   * fungsi batal pemeriksaan
   */
  public function actionBatalPemeriksaan()
  {
    $idKirimUnit = null;
    $keterangan = "";
    $nama_pasien = "";

    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pesan = 'success';
      $status = 'ok';
      $ok = true;
      try {
        $id = $_POST['pendaftaran_id'];
        $idPenunjang = $_POST['idPenunjang'];
        $keterangan_batal = $_POST['keterangan_batal'];

        $pendaftaran = PendaftaranT::model()->findByPk($id);
        $penunjang = PasienmasukpenunjangT::model()->findByPk($idPenunjang);
        $nama_pasien = $pendaftaran->pasien->nama_pasien;

        // periksa tindakan
        $criteria = new CDbCriteria();
        $criteria->select = "count(tindakanpelayanan_id) as tindakanpelayanan_id";
        $criteria->addCondition("pasienmasukpenunjang_id = " . $idPenunjang . " and tindakansudahbayar_id is not null");
        $tindakan = TindakanpelayananT::model()->find($criteria);

        if ($tindakan->tindakanpelayanan_id > 0) {
          $pesan = 'exist';
          $keterangan = "<div class='flash-success'>Pasien <b> " . $pendaftaran->pasien->nama_pasien . "
                                </b> sudah melakukan pembayaran pemeriksaan </div>";
          $ok = false;
        } else {
          TindakanpelayananT::model()->updateAll(array(
            'detailhasilpemeriksaanlab_id' => null,
            'hasilpemeriksaanrm_id' => null,
            'hasilpemeriksaanrad_id' => null,
            'hasilpemeriksaanpa_id' => null,
          ), 'pasienmasukpenunjang_id = ' . $idPenunjang);
          TindakanpelayananT::model()->deleteAllByAttributes(array(
            'pasienmasukpenunjang_id' => $idPenunjang,
          ));
          // $ok = $ok && PasienmasukpenunjangT::model()->deleteByPk();
        }

        //var_dump($ok);

        // simpan batal periksa penunjang
        $model = new PasienbatalperiksaR();
        $model->pendaftaran_id = $id;
        $model->pasien_id = $pendaftaran->pasien_id;
        $model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
        $model->pasienkirimkeunitlain_id = $penunjang->pasienkirimkeunitlain_id;
        $model->tglbatal = date('Y-m-d H:i:s');
        $model->keterangan_batal = $keterangan_batal;
        $model->create_time = date('Y-m-d H:i:s');
        $model->update_time = null;
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($model->validate()) {
          $ok = $ok && $model->save();
        } else $ok = false;

        // var_dump($model->attributes); die;

        //var_dump($ok);
        $hl7_komentar = "Pasien Daftar Langsung Radiologi";
        if (empty($penunjang->pasienkirimkeunitlain_id) && $penunjang->ruangan_id == $pendaftaran->ruangan_id) {
          $attributes = array(
            'statusperiksa' => 'BATAL PERIKSA',
            'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
            'update_time' => date('Y-m-d H:i:s'),
            'update_loginpemakai_id' => Yii::app()->user->id
          );
          $ok = $ok && PendaftaranT::model()->updateByPk($id, $attributes);
          $hl7_komentar = "Pasien Daftar Langsung Radiologi";
        } else {
          $attributes = array(
            'statusperiksa' => 'BATAL PERIKSA',
            'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
            'update_time' => date('Y-m-d H:i:s'),
            'update_loginpemakai_id' => Yii::app()->user->id
          );
          $this->notifPasienBatalPemeriksaan($penunjang);
          $ok = $ok && PasienmasukpenunjangT::model()->updateByPk($idPenunjang, $attributes);
          $hl7_komentar = "Pasien Rujuk Internal";
        }

        $oa = ObatalkespasienT::model()->findAllByAttributes(array(
          'pasienmasukpenunjang_id' => $idPenunjang,
        ));
        foreach ($oa as $item) {
          StokobatalkesT::model()->deleteAllByAttributes(array(
            'obatalkespasien_id' => $item->obatalkespasien_id,
          ));
          ObatalkespasienT::model()->deleteByPk($item->obatalkespasien_id);
        }

        if (!empty($penunjang)) {
          $hl7 = new HL7;
          // $ok = $ok && 
          $hl7->hapusPasien($penunjang->pasienmasukpenunjang_id, $hl7_komentar);
        }

        // var_dump($ok); die;

        if ($ok) {
          $transaction->commit();
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        print_r($ex);
        $status = 'not';
        $transaction->rollback();
      }

      $data['pesan'] = $pesan;
      $data['status'] = $status;
      $data['keterangan'] = $keterangan;
      //$data['smspasien'] = $smspasien;
      $data['nama_pasien'] = $nama_pasien;

      echo json_encode($data);

      Yii::app()->end();
    }
  }

  /**
   * mengirimkan notifikasi pembatalan pemeriksaan radiologi
   * @param type $pasienMasukPenunjang
   */
  public function notifPasienBatalPemeriksaan($pasienMasukPenunjang)
  {
    // var_dump($pasienMasukPenunjang->attributes); die;

    if (!empty($pasienMasukPenunjang->pasienkirimkeunitlain_id)) {
      $ki = PasienkirimkeunitlainT::model()->findByPk($pasienMasukPenunjang->pasienkirimkeunitlain_id);
      $modRuangan = RuanganM::model()->findByPk($ki->create_ruangan);
    } else {
      $modRuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_LOKET);
    }

    // var_dump($modRuangan->attributes); die;

    //$modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain->create_ruangan);
    $pasien_id = $pasienMasukPenunjang->pasien_id;
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $judul = 'Pasien Batal Pemeriksaan Radiologi';

    $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;

    //var_dump($judul." , ".$isi);

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $modRuangan->instalasi_id, 'ruangan_id' => $modRuangan->ruangan_id, 'modul_id' => $modRuangan->modul_id),
    ));
  }

  /**
   * menghapus tindakan dan penggunaan obat
   * @param type $pasienMasukPenunjang
   * @param type $status
   * @param type $pesan
   */
  protected function hapusTindakanDanOa($pasienMasukPenunjang, &$status, &$pesan)
  {
    $ok = true;
    $isbayar = false;
    $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
    ));
    $hasilpemeriksaan = HasilpemeriksaanradT::model()->findAllByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
    ));

    $oa = ObatalkespasienT::model()->findAllByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
    ));


    foreach ($tindakan as $item) {
      if (!empty($item->tindakansudahbayar_id)) {
        $isbayar = true;
        break;
      }
    }

    if (!$isbayar) {
      foreach ($tindakan as $item) {
        $ok = $ok && TindakanpelayananT::model()->updateByPk($item->tindakanpelayanan_id, array(
          'hasilpemeriksaanrad_id' => null,
        ));
      }

      foreach ($hasilpemeriksaan as $item) {
        $ok = $ok && HasilpemeriksaanradT::model()->deleteByPk($item->hasilpemeriksaanrad_id);
      }

      foreach ($tindakan as $item) {
        $ok = $ok && TindakankomponenT::model()->deleteAllByAttributes(array(
          'tindakanpelayanan_id' => $item->tindakanpelayanan_id,
        ));
        $ok = $ok && TindakanpelayananT::model()->deleteByPk($item->tindakanpelayanan_id);
      }

      // farmasi
      foreach ($oa as $item) {
        $ok = $ok && StokobatalkesT::model()->deleteAllByAttributes(array(
          'obatalkespasien_id' => $item->obatalkespasien_id
        ));
        $ok = $ok && ObatalkespasienT::model()->deleteByPk($item->obatalkespasien_id);
      }

      if ($ok) {
        $status = "ok";
      } else {
        $pesan = "exist";
      }
    } else {
      $ok = false;
      $status = "exist";
      $pesan = "exist";
    }
  }


  /**
   * action ketika tombol panggil di klik
   */
  public function actionPanggil()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $pasienmasukpenunjang_id = ($_POST['pasienmasukpenunjang_id']);
      $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
      $pasienMasukPenunjang =  PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

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
      $data['smspasien'] = 1;
      $data['nama_pasien'] = '';

      if (isset($pasienMasukPenunjang)) {

        $ruangan = RuanganM::model()->findByPk($pasienMasukPenunjang->ruangan_id);
        $data['ruangan_singkatan'] = $ruangan->ruangan_singkatan;

        if ($pasienMasukPenunjang->panggilantrian == true) {
          if ($keterangan == "batal") {
            $pasienMasukPenunjang->panggilantrian = false;
            if ($pasienMasukPenunjang->update()) {
              // SMS GATEWAY
              $modPasien = $pasienMasukPenunjang->pasien;
              $sms = new Sms();
              $smspasien = 1;
              foreach ($modSmsgateway as $i => $smsgateway) {
                $isiPesan = $smsgateway->templatesms;

                $attributes = $modPasien->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $pasienMasukPenunjang->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }

                if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                  if (!empty($modPasien->no_mobile_pasien)) {
                    $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                  } else {
                    $smspasien = 0;
                  }
                }
              }
              // END SMS GATEWAY
              $data['smspasien'] = $smspasien;
              $data['nama_pasien'] = $modPasien->nama_pasien;
              $data['pesan'] = "Pemanggilan no. antrian " . $pasienMasukPenunjang->no_urutperiksa . " dibatalkan !";
            }
          } else {
            $data['pesan'] = "No. antrian " . $pasienMasukPenunjang->no_urutperiksa . " dipanggil !";
          }
        } else {
          $pasienMasukPenunjang->panggilantrian = true;
          if ($pasienMasukPenunjang->update()) {
            $data['pesan'] = "No. antrian " . $pasienMasukPenunjang->no_urutperiksa . " dipanggil !";
            // $data_telnet = $pasienMasukPenunjang->ruangan->ruangan_nama.", ".$pasienMasukPenunjang->ruangan->ruangan_singkatan."-".$pasienMasukPenunjang->no_urutperiksa;
            //              AKAN DIGANTI MENGGUNAKAN NODE JS
            // self::postTelnet($data_telnet);
          }
        }
      }

      $attributes = $pasienMasukPenunjang->attributeNames();
      foreach ($attributes as $i => $attribute) {
        $data["$attribute"] = $pasienMasukPenunjang->$attribute;
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * memanggil antrian terakhir (sesuai dengan urutan nomor selanjutnya dari nomor terakhir yang dipanggil)
   * @throws CHttpException
   */
  public function actionGetAntrianTerakhir()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $data['pesan'] = "";
      $criteria = new CDbCriteria;
      $criteria->addCondition('panggilantrian != TRUE');
      $criteria->addCondition('date(tglmasukpenunjang) BETWEEN \'' . date('d M Y') . '\' AND \'' . date('d M Y') . '\'');
      $criteria->order = 'no_urutperiksa ASC';

      $model = ROPasienMasukPenunjangV::model()->find($criteria);
      if (!empty($model)) {
        $data['pasienmasukpenunjang_id'] = $model->pasienmasukpenunjang_id;
        $data['ruangan_singkatan'] = $model->ruangan_singkatan;
        $data['no_urutperiksa'] = $model->no_urutperiksa;
        $data['ruangan_id'] = $model->ruangan_id;
      } else {
        $data['pesan'] = "Tidak ada antrian!";
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * digunakan untuk memanggil prinout data
   * @param type $hasilpemeriksaan_id
   */
  public function actionPrintPemeriksaanRad($pasienmasukpenunjang_id, $nofoto)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter();
    $masukpenunjang = null; //PasienmasukpenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
    // $model = ROHasilpemeriksaanradT::model()->findByPk($hasilpemeriksaan_id);
    // var_dump( $model);die;
    $judulLaporan = '';

    // if (!empty($model)) {
      /*
      $cri = new CDbCriteria();
      $cri->select = "t.*, rhd.refhasildet_nama";
      $cri->join =  " JOIN referensihasildet_m rhd ON rhd.refhasildet_id = t.refhasildet_id  "
        .  " JOIN referensihasilrad_m rhr ON rhd.refhasilrad_id = rhr.refhasilrad_id ";
      $cri->addCondition(" rhr.refhasilrad_banyak = TRUE ");
      $cri->addCondition(" t.hasilpemeriksaanrad_id = " . $hasilpemeriksaan_id . " ");
      $cri->order = " rhd.refhasildet_urut ";
      $hasDet = ROHasilperiksaraddetT::model()->findAll($cri);
      */
      //if (count((array)$hasDet) > 0) {
      //  $this->render($this->path_view_rad . 'printTemplate.printHasilDet', array('hasDet' => $hasDet, 'model' => $model, 'judulLaporan' => $judulLaporan));
      //} else {
      //  if ($model->pemeriksaanrad_id == Params::PEMERIKSAAN_RAD_THORAX_PA) {
      //    $this->render($this->path_view_rad . 'printTemplate.printThoraxPa', array('model' => $model, 'judulLaporan' => $judulLaporan));
      //  } elseif ($model->pemeriksaanrad_id == Params::PEMERIKSAAN_RAD_UPPER_LOWER_ABDOMEN || $model->pemeriksaanrad_id == Params::PEMERIKSAAN_RAD_UPPER_LOWER) {
      //    $this->render($this->path_view_rad . 'printTemplate.printUpperLowerAbd', array('model' => $model, 'judulLaporan' => $judulLaporan));
      //  } elseif ($model->pemeriksaanrad_id == Params::PEMERIKSAAN_RAD_UROLOGI) {
      //    $this->render($this->path_view_rad . 'printTemplate.printUrologi', array('model' => $model, 'judulLaporan' => $judulLaporan));
      //  } else {
          $this->render($this->path_view_rad . 'printTemplate.print', array('masukpenunjang' => $masukpenunjang, 'nofoto'=>$nofoto, 'judulLaporan' => $judulLaporan));
      //  }
      //}
    // }
  }


    public function actionPrintPemeriksaanRadiologi($riwayathasilpemeriksaan_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter();
    $model = HasilpemeriksaanradR::model()->findByPk($riwayathasilpemeriksaan_id);
    $judulLaporan = 'HASIL PEMERIKSAAN RADIOLOGI';
        
          $this->render($this->path_view_rad . 'printTemplate.printRiwayat', array('model' => $model, 'judulLaporan' => $judulLaporan));
        }
      
  
  public function actionAmbilHasil($pendaftaran_id, $pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPasienMasukPenunjang = ROPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPasien = ROPasienM::model()->findByPk($modPasienMasukPenunjang->pasien_id);
    $modHasilRad = HasilpemeriksaanradT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modHasilRad->namaygmenyerahkan = Yii::app()->user->getState('nama_pegawai');
    if (isset($_POST['HasilpemeriksaanradT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        //var_dump($_POST['HasilpemeriksaanradT']);die;


        $modHasilRad->attributes = $_POST['HasilpemeriksaanradT'];
        $modHasilRad->tglpengambilanhasil = $format->formatDateTimeForDb($_POST['HasilpemeriksaanradT']['tglpengambilanhasil']);
        $attributes = array(
          'tglpengambilanhasil' => $modHasilRad->tglpengambilanhasil,
          'namapenerimahasil' => $modHasilRad->namapenerimahasil,
          'notelppenerimahasil' => $modHasilRad->notelppenerimahasil,
          'namaygmenyerahkan' => $modHasilRad->namaygmenyerahkan,
          'ketpenyerahan' => $modHasilRad->ketpenyerahan,
          'jenisidentitas' => $modHasilRad->jenisidentitas,
          'no_identitas' => $modHasilRad->no_identitas,
          'alamat' => $modHasilRad->alamat
        );
        $update = HasilpemeriksaanradT::model()->updateAll($attributes, " pasienmasukpenunjang_id = " . $pasienmasukpenunjang_id);
        if ($update) {
          //                        $modHasilRad->save();
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
          $this->redirect(array('ambilHasil', 'pendaftaran_id' => $pendaftaran_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'frame' => 1, 'popup' => 'true', 'sukses' => 1));
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
      'modHasilRad' => $modHasilRad,
      'format' => $format,
    ));
  }

  public function actionPrintLabel($id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;


    $data = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $id,
    ));
    $hasil = HasilpemeriksaanradT::model()->findAllByAttributes(array(
      'pasienmasukpenunjang_id' => $id,
    ));
    $pemeriksaanRad = array();

    foreach ($hasil as $key => $value) {
      $pemeriksaanRad[$key]['hasilpemeriksaanrad_id'] = $value->hasilpemeriksaanrad_id;
      $pemeriksaanRad[$key]['pasienmasukpenunjang_id'] = $value->pasienmasukpenunjang_id;
      $pemeriksaanRad[$key]['pasien_nama'] = $value->pasien->nama_pasien;
      $pemeriksaanRad[$key]['no_rekam_medik'] = $value->pasien->no_rekam_medik;
      $pemeriksaanRad[$key]['tanggal_lahir'] = $value->pasien->tanggal_lahir;
      $pemeriksaanRad[$key]['umur'] = $value->pasien->umur;
      $pemeriksaanRad[$key]['dokterpengirim'] = !empty($value->pasienmasukpenunjang->pegawai->nama_pegawai) ? $value->pasienmasukpenunjang->pegawai->nama_pegawai : "-";
      $pemeriksaanRad[$key]['gelardepan'] = !empty($value->pasienmasukpenunjang->pegawai->gelardepan) ? $value->pasienmasukpenunjang->pegawai->gelardepan : "-";
      $pemeriksaanRad[$key]['tglmasukpenunjang'] = $value->pasienmasukpenunjang->tglmasukpenunjang;
      $pemeriksaanRad[$key]['pemeriksaanrad_nama'] = $value->pemeriksaanrad->pemeriksaanrad_nama;
      // $pemeriksaanRad[$key] ['pemeriksaanrad_id']= $value->pemeriksaanrad_id;
    }


    // $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait

    $mpdf = new MyPDF60('', array(80, 50));
    // ob_clean();
    $mpdf->mirrorMargins = 0;
    //        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    //        $mpdf->WriteHTML($stylesheet,1);
    $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/LABEL.css');
    $mpdf->WriteHTML($formatkonten, 1);
    $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
    // $mpdf->SetHtmlFooter($this->renderPartial("application.views.footer._footerLabel", array(), true), 'O');
    $mpdf->SetHtmlFooter('<span></span>');
    $mpdf->WriteHTML(
      $this->renderPartial('printLabel', array(
        'format' => $format,
        'data' => $data,
        'hasil' => $hasil,
        'pemeriksaanRad' => $pemeriksaanRad,
      ), true)
    );
    $mpdf->SetJS('this.print();');
    $mpdf->Output();
  }

  public function actionGetDataPendaftaranRD()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id_pendaftaran = $_POST['pendaftaran_id'];
      $model = ROPasienMasukPenunjangV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
        $returnVal["gelarbelakang_nama"] = isset($model->gelarbelakang_nama) ? $model->gelarbelakang_nama : "";
        $returnVal["gelardepan"] = isset($model->gelardepan) ? $model->gelardepan : "";
      }
      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }

  public function actionUbahDokterPeriksa()
  {
    $model = new ROPendaftaranT();
    $modUbahDokter = new UbahdokterR;
    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    if (isset($_POST['ROPendaftaranT'])) {
      if ($_POST['ROPendaftaranT']['pegawai_id'] != "") {
        $modUbahDokter->attributes = $_POST['UbahdokterR'];
        $modUbahDokter->pendaftaran_id = $_POST['ROPendaftaranT']['pendaftaran_id'];
        $modUbahDokter->dokterbaru_id = $_POST['ROPendaftaranT']['pegawai_id'];
        $modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
        $modUbahDokter->create_time = date('Y-m-d H:i:s');
        $modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
        $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $attributes = array('pegawai_id' => $_POST['ROPendaftaranT']['pegawai_id']);

          $save = PendaftaranT::model()->updateByPk($_POST['ROPendaftaranT']['pendaftaran_id'], $attributes);

          if ($save) {
            $modUbahDokter->save();
            $transaction->commit();
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
            ));
          } else {
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
            ));
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
          )
        );
        exit;
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formUbahDokterPeriksa', array('model' => $model, 'modUbahDokter' => $modUbahDokter, 'menu' => $menu), true)
      ));
      exit;
    }
  }

  /**
   * @author Rusdiyanto<rusdiyanto@.com>
   * penambahan fungsi untuk ubah Radiografer
   * @param type $pasienmasukpenunjang_id
   */
  public function actionUbahRadiografer($pasienmasukpenunjang_id) {
    $this->layout = '//layouts/iframe';
    $modPegawai = new PegawaiM();
    $modPelaksana = new PelaksanaradiologiT();
    $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
    if (isset($modPasienMasukPenunjang)) {
      $modTindakanPelayanan = TindakanpelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id));
      $modPelaksana = PelaksanaradiologiT::model()->findAllByAttributes(array('tindakanpelayanan_id' => $modTindakanPelayanan->tindakanpelayanan_id, 'pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id));
      if (isset($modTindakanPelayanan->perawat_id)) {
        $modPegawai = PegawaiM::model()->findByPk($modTindakanPelayanan->perawat_id);
      }
    }
    if (isset($_POST['TindakanpelayananT'])) {
      $ok = true;
      $modSimpanPegawaiPelaksana = false;
      $trans = Yii::app()->db->beginTransaction();
      try {
        $update_Tindakan = TindakanpelayananT::model()->updateAll(array('perawat_id' => $_POST['TindakanpelayananT']['perawat_id']), 'pasienmasukpenunjang_id=' . $modPasienMasukPenunjang->pasienmasukpenunjang_id);
        if (isset($_POST['ROPelaksanaradiologiT'])) {
          if (count($_POST['ROPelaksanaradiologiT']) > 0) {
            foreach ($_POST['ROPelaksanaradiologiT'] as $data) {
              if (empty($data['pelaksanaradiologi_id'])) {
                $modSimpan = new PelaksanaradiologiT();
                $modSimpan->attributes = $data;
                $modSimpan->tindakanpelayanan_id = $modTindakanPelayanan->tindakanpelayanan_id;
                $modSimpan->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
                $modPegawaiPelaksana = PegawaiM::model()->findByPk($data['pegawai_id']);
                $modSimpan->kruradiologi = $modPegawaiPelaksana->nama_pegawai;
                $modSimpan->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $modSimpan->create_time = date('Y-m-d H:i:s');
                $modSimpan->create_ruangan = Yii::app()->user->getState('ruangan_id');
              } else if ($data['pelaksanaradiologi_id'] != null) {
                $modSimpan = PelaksanaradiologiT::model()->findByPk($data['pelaksanaradiologi_id']);
                $modPegawaiPelaksana = PegawaiM::model()->findByPk($data['pegawai_id']);
                $modSimpan->pegawai_id = $data['pegawai_id'];
                $modSimpan->kruradiologi = $modPegawaiPelaksana->nama_pegawai;
                $modSimpan->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $modSimpan->update_time = date('Y-m-d H:i:s');
              }
              if ($modSimpan->save()) {
                $modSimpanPegawaiPelaksana = true;
              }
            }
          }
        }
        if ($update_Tindakan || $modSimpanPegawaiPelaksana == true) {
          $trans->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
          $this->redirect(array('UbahRadiografer', 'pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id, 'sukses' => 1));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($modPasienMasukPenunjang));
        }
      } catch (Exception $exc) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    $this->render('_formUbahRadiografer', array(
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modTindakanPelayanan' => $modTindakanPelayanan,
      'modPegawai' => $modPegawai,
      'modPelaksana' => $modPelaksana
    ));

  }
  
  /**
   * Untuk verifikasi hasil pemeriksaan
   */
  public function actionCekVerifikasi() {
    if (Yii::app()->request->isAjaxRequest) {
      $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;

      $modHasilPemeriksaan = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
      $modHasilPemeriksaan2 = HasilpemeriksaanradR::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

      $create_time = '';
      $id = '';


      if (count($modHasilPemeriksaan) > 0) {
        
        // mengitung selisih dua tanggal
        foreach ($modHasilPemeriksaan as $isi) {
          $create_time = strtotime($isi->create_time);
          $id = $isi->hasilpemeriksaanrad_id;
          $data_now = date('Y-m-d H:i:s');
          $selisih_tgl = strtotime($data_now) - $create_time;
          $menit = floor($selisih_tgl / 60);
          $data['status'] = true;
          //                                        $data['pesan'] = $menit;
          HasilpemeriksaanradT::model()->updateAll(
            array(
              'tglverifikasi_dpjp' => $data_now,
              'tat_pelayanan_pasien' => $menit,
              'pegawai_verifikasi_id' => Yii::app()->user->id,
            ), 'hasilpemeriksaanrad_id=' . $id
          );

          $up = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

          if (!empty($up)) {
            $up->statusperiksa = Params::STATUSPERIKSA_SUDAH_DIPERIKSA;
            $up->update_time = date("Y-m-d H:i:s");
            $up->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $up->save();
          }
        }
      } else {
        $data['status'] = false;
        $data['pesan'] = ' Pemeriksaan Radiologi Tidak Ada!';
      }

      if (count($modHasilPemeriksaan2) > 0) {
        // mengitung selisih dua tanggal
        foreach ($modHasilPemeriksaan2 as $isi) {
          $create_time = strtotime($isi->create_time);
          $id = $isi->riwayathasilpemeriksaanrad_id;
          $data_now = date('Y-m-d H:i:s');
          $selisih_tgl = strtotime($data_now) - $create_time;
          $menit = floor($selisih_tgl / 60);
          $data['status'] = true;
          //                                        $data['pesan'] = $menit;
          HasilpemeriksaanradR::model()->updateAll(
          array(
            'tglverifikasi_dpjp' => $data_now,
            'tat_pelayanan_pasien' => $menit,
            'pegawai_verifikasi_id' => Yii::app()->user->id,
          ), 'riwayathasilpemeriksaanrad_id=' . $id
          );
        }
      } else {
        $data['status'] = false;
        $data['pesan'] = ' Pemeriksaan Radiologi Tidak Ada!';
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * Fungsi Mengubah status Siap kirim menjadi
   */
  public function actionSiapKirimRad() {
      if (Yii::app()->request->isAjaxRequest) {
          $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;

          $modHasilPemeriksaan = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

          $create_time = '';
          $id = '';

          if (count($modHasilPemeriksaan) > 0) {
              // mengitung selisih dua tanggal
              foreach ($modHasilPemeriksaan as $isi) {
                  $create_time = strtotime($isi->create_time);
                  $id = $isi->hasilpemeriksaanrad_id;
                  $data_now = date('Y-m-d H:i:s');
                  $data['status'] = true;
                  //                                        $data['pesan'] = $menit;
                  HasilpemeriksaanradT::model()->updateAll(
                          array(
                      'statuskirim_hasilrad' => Params::STATUSKIRIM_HASILRAD_SEDANG_KIRIM,
                          ), 'hasilpemeriksaanrad_id=' . $id
                  );
              }
          } else {
              $data['status'] = false;
              $data['pesan'] = ' Pemeriksaan Rad Tidak Ada!';
          }

          echo json_encode($data);
          Yii::app()->end();
      }
  }

  /**
   * Fungsi Terima Hasil Rad
   */
  public function actionTerimaHasilRad() {
      if (Yii::app()->request->isAjaxRequest) {
          $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;

          $modHasilPemeriksaan = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

          $create_time = '';
          $id = '';

          if (count($modHasilPemeriksaan) > 0) {
              // mengitung selisih dua tanggal
              foreach ($modHasilPemeriksaan as $isi) {
                  $create_time = strtotime($isi->create_time);
                  $id = $isi->hasilpemeriksaanrad_id;
                  $data_now = date('Y-m-d H:i:s');
                  $data['status'] = true;
                  //                                        $data['pesan'] = $menit;
                  HasilpemeriksaanradT::model()->updateAll(
                          array(
                      'tgl_sdhterima' => $data_now,
                      'statuskirim_hasilrad' => Params::STATUSKIRIM_HASILRAD_SUDAH_DITERIMA,
                          ), 'hasilpemeriksaanrad_id=' . $id
                  );
              }
          } else {
              $data['status'] = false;
              $data['pesan'] = ' Pemeriksaan Rad Tidak Ada!';
          }

          echo json_encode($data);
          Yii::app()->end();
      }
  }

  /**
   * Fungsi ambil hasil rad
   */
  public function actionAmbilHasilRad() {
      if (Yii::app()->request->isAjaxRequest) {
          $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;

          $modHasilPemeriksaan = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

          $create_time = '';
          $id = '';

          $tindakan = TindakanpelayananT::model()->findByAttributes(array(
              'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
                  ), array(
              'condition' => 'tindakansudahbayar_id is null',
          ));

          if (!empty($tindakan)) {
              $data['status'] = false;
              $data['pesan'] = ' Pemeriksaan Rad belum dibayar!';

              echo json_encode($data);
              Yii::app()->end();
          }

          if (count($modHasilPemeriksaan) > 0) {
              // mengitung selisih dua tanggal
              foreach ($modHasilPemeriksaan as $isi) {
                  $create_time = strtotime($isi->create_time);
                  $id = $isi->hasilpemeriksaanrad_id;
                  $data_now = date('Y-m-d H:i:s');
                  $data['status'] = true;
                  //                                        $data['pesan'] = $menit;
                  HasilpemeriksaanradT::model()->updateAll(
                          array(
                      'tgl_sdhambil' => $data_now,
                      'statuskirim_hasilrad' => Params::STATUSKIRIM_HASILRAD_SUDAH_DIAMBIL,
                          ), 'hasilpemeriksaanrad_id=' . $id
                  );
              }
          } else {
              $data['status'] = false;
              $data['pesan'] = ' Pemeriksaan Rad Tidak Ada!';
          }

          echo json_encode($data);
          Yii::app()->end();
      }
  }

      /**
     * mengenerate hasil pemeriksaan radiologi
     * @param type $pendaftaran_id
     * @param type $pasien_id
     * @param type $pasienmasukpenunjang_id
     */
    public function actionVerifikasiDokter($pasienmasukpenunjang_id) {
        
      $this->layout = '//layouts/iframe';
      $modPasienMasukPenunjang = ROPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

      if (isset($_POST['ROPasienmasukpenunjangT'])) {
          $transaction = Yii::app()->db->beginTransaction();
          try {

              $ok = true;

              $isverif = $_POST['ROPasienmasukpenunjangT']['is_verifikasi'] != "false";

              $modPasienMasukPenunjang->is_verifikasi = $isverif;
              $modPasienMasukPenunjang->catatan_verifikasi = $_POST['ROPasienmasukpenunjangT']['catatan_verifikasi'];
              $ok &= $modPasienMasukPenunjang->update();

              // var_dump($ok, $modPasienMasukPenunjang->attributes); die;

              // ROPasienmasukpenunjangT::model()->updateByPk($pasienmasukpenunjang_id, array('is_verifikasi' => $isverif, 'catatan_verifikasi' => $_POST['ROPasienmasukpenunjangT']['catatan_verifikasi']));

              $transaction->commit();
              Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
              $this->redirect(array('verifikasiDokter', 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'is_sukses' => 1));
              // $this->redirect($this->createUrl("/radiologi/lihatHasil/HasilPeriksa", array('pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $pasien_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'caraPrint' => 'PRINT')));
          } catch (Exception $exc) {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
          }
      }
    
      $this->render('verifikasi/_verifikasiDokter',array('modPasienMasukPenunjang' => $modPasienMasukPenunjang));
  }


    /**
	 * Pemeriksaan selesai 
     * @param type $id
	 */
	public function actionPemeriksaanSelesai($id)
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses'] = 0;
			$model = ROPasienmasukpenunjangT::model()->findByPk($id);
 
			 $model->is_selesai = true;
			 if($model->save()){
				$data['sukses'] = 1;
			 }
			echo CJSON::encode($data); 
		}
	}

  public function actionLoadKonfigurasiLabel(){
    if (Yii::app()->request->isAjaxRequest){

        $id = (isset($_GET['id']) ? $_GET['id'] : null);       
        $html = $this->renderPartial('label/form/_pilihPosisi', array('id' => $id), true);
        
        echo json_encode(['html'=>$html]);
    }
    Yii::app()->end();
}



  public function actionViewFoto($no_register, $nofoto) {
      // $periksa = HasilpemeriksaanradT::model()->findByPk($hasilpemeriksaan_id);
      $url = ListAllOrder::generateURLHasil($no_register, $nofoto);

      $this->redirect($url);
  }
}