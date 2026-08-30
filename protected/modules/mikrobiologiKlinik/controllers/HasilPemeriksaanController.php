<?php
/**
 * digunakan untuk mengelola transaksi informasi rujukan penunjang
 * RSST-5081
 * @package application.modules.mikrobiologiKlinik
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class HasilPemeriksaanController extends MyAuthController
{

    public $instalasi_ruangan, $nama_pasien_panggilan, $cara_bayar_penjamin, $kasus_pelayanan;

    public $path_view_daftar = 'mikrobiologiKlinik.views.daftarPasien.';
    
    /**
     * Default menu
     */
    public function actionIndex()
    {
        $format = new MyFormatter;
        $model = new HasilpemeriksaanmikrobiologiV();
        $model->tgl_awal = date('Y-m-d');//, strtotime('-5 days')
        $model->tgl_akhir = date('Y-m-d');
        
        if(isset($_GET['HasilpemeriksaanmikrobiologiV'])){
           
            $model->attributes = $_GET['HasilpemeriksaanmikrobiologiV'];  
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HasilpemeriksaanmikrobiologiV']['tgl_awal']);  
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HasilpemeriksaanmikrobiologiV']['tgl_akhir']);  
           
            if(Yii::app()->request->isAjaxRequest) {
                if(isset($_GET['ajax']) && $_GET['ajax'] == 'pasienpenunjangrujukan-m-grid') {
                    $this->renderPartial('_table', ['model' => $model]);
                    Yii::app()->end();
                }
            }			
        }
        $this->render('index',array('model'=>$model,'format'=>$format));
        
    }

        /**
     * Halaman mengisi Hasil Analis
     */
    public function actionHasilExpertise($kelompokpemeriksaanmikro_id, $id, $pasienmasukpenunjang_id, $pemeriksaan) {

        $kultur = new PemeriksaankulturT;
        $pewarnaan = new PemeriksaanpewarnaanT;
        $pcr = new PemeriksaanpcrT;

        $modKunjungan = MKPasienmasukpenunjangV::model()->findByAttributes(array("pasienmasukpenunjang_id" => $pasienmasukpenunjang_id));

        $kelompok = KelompokpemeriksaanmikroT::model()->findByPk($kelompokpemeriksaanmikro_id);
        
        $this->render('hasilExpertise', array('modKunjungan' => $modKunjungan, 'kelompok' => $kelompok));
    }

     /**
     * Halaman mengisi Hasil Analis
     */
    public function actionKultur($kelompokpemeriksaanmikro_id, $pasienmasukpenunjang_id, $pemeriksaankultur_id) {

        $modKunjungan = MKPasienmasukpenunjangV::model()->findByAttributes(array("pasienmasukpenunjang_id" => $pasienmasukpenunjang_id));

        $kelompok = KelompokpemeriksaanmikroT::model()->findByPk($kelompokpemeriksaanmikro_id);
        $kultur = PemeriksaankulturT::model()->findByPk($pemeriksaankultur_id);
        $modPengambilanSample = PengambilansampleT::model()->findByAttributes(['pasienmasukpenunjang_id' => $pasienmasukpenunjang_id]);
        if (isset($_POST['PemeriksaankulturT'])) {
          $ok = true;
          $trans = Yii::app()->db->beginTransaction();
          try {
              
            $kultur->attributes = $_POST['PemeriksaankulturT'];
            $kultur->tgl_pemeriksaan = MyFormatter::formatDateTimeForDb($_POST['PemeriksaankulturT']['tgl_pemeriksaan']);
            $kultur->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;

            if(!empty($modPengambilanSample)) {
              $kultur->no_lab = $modPengambilanSample->no_pengambilansample;
            }

            $kultur->update_time = date('Y-m-d H:i:s');
            $kultur->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

            $ok = $ok && $kultur->save();

            $kelompok->tgl_pemeriksaan = $kultur->tgl_pemeriksaan;
            $kelompok->pegawai_id = $kultur->pegawai_id;
            $kelompok->dpjp_id = $kultur->dpjp_id;
            $kelompok->perawat_id = $kultur->perawat_id;

            $ok = $ok && $kelompok->save();

            if ($ok) {
                $trans->commit();
                Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                $this->redirect(array('kultur', 'kelompokpemeriksaanmikro_id' => $kelompokpemeriksaanmikro_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pemeriksaankultur_id' => $kultur->pemeriksaankultur_id,  'sukses' => 1));
            } else {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($kultur));
            }
          } catch (Exception $exc) {
            echo '<pre>'; var_dump($exc); die;
              $trans->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
          }
      }
        
      $this->render('hasilExpertise', array('modKunjungan' => $modKunjungan, 'kelompok' => $kelompok, 'kultur' => $kultur));
    }

         /**
     * Halaman mengisi Hasil Analis
     */
    public function actionPewarnaan($kelompokpemeriksaanmikro_id, $pasienmasukpenunjang_id, $pemeriksaanpewarnaan_id) {

        $modKunjungan = MKPasienmasukpenunjangV::model()->findByAttributes(array("pasienmasukpenunjang_id" => $pasienmasukpenunjang_id));

        $kelompok = KelompokpemeriksaanmikroT::model()->findByPk($kelompokpemeriksaanmikro_id);
        $pewarnaan = PemeriksaanpewarnaanT::model()->findByPk($pemeriksaanpewarnaan_id);
        $modPengambilanSample = PengambilansampleT::model()->findByAttributes(['pasienmasukpenunjang_id' => $pasienmasukpenunjang_id]);
        if (isset($_POST['PemeriksaanpewarnaanT'])) {
          $ok = true;
          $trans = Yii::app()->db->beginTransaction();
          try {
              
            $pewarnaan->attributes = $_POST['PemeriksaanpewarnaanT'];
            $pewarnaan->tgl_pemeriksaan = MyFormatter::formatDateTimeForDb($_POST['PemeriksaanpewarnaanT']['tgl_pemeriksaan']);
            $pewarnaan->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
            if(!empty($modPengambilanSample)) {
              $pewarnaan->no_lab = $modPengambilanSample->no_pengambilansample;
            }
            $pewarnaan->update_time = date('Y-m-d H:i:s');
            $pewarnaan->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

            $ok = $ok && $pewarnaan->save();

            $kelompok->tgl_pemeriksaan = $pewarnaan->tgl_pemeriksaan;
            $kelompok->pegawai_id = $pewarnaan->pegawai_id;
            $kelompok->dpjp_id = $pewarnaan->dpjp_id;
            $kelompok->perawat_id = $pewarnaan->perawat_id;

            $ok = $ok && $kelompok->save();

            if ($ok) {
                $trans->commit();
                Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                $this->redirect(array('pewarnaan', 'kelompokpemeriksaanmikro_id' => $kelompokpemeriksaanmikro_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pemeriksaanpewarnaan_id' => $pewarnaan->pemeriksaanpewarnaan_id,  'sukses' => 1));
            } else {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($pewarnaan));
            }
          } catch (Exception $exc) {
            echo '<pre>'; var_dump($exc); die;
              $trans->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
          }
      }
        
      $this->render('hasilExpertise', array('modKunjungan' => $modKunjungan, 'kelompok' => $kelompok, 'pewarnaan' => $pewarnaan));
    }

    function actionCCI($kelompokpemeriksaanmikro_id, $pasienmasukpenunjang_id, $jenispemeriksaanlab_id, $pemeriksaancci_id) {
      $modKunjungan = MKPasienmasukpenunjangV::model()->findByAttributes(array("pasienmasukpenunjang_id" => $pasienmasukpenunjang_id));
      $kelompok = KelompokpemeriksaanmikroT::model()->findByPk($kelompokpemeriksaanmikro_id);
      $cci = PemeriksaancciT::model()->findByPk($pemeriksaancci_id);
      $jns_pemeriksaan = JenispemeriksaanlabM::model()->findByPk($jenispemeriksaanlab_id)->jenispemeriksaanlab_nama ?? '';

      $cci->jenis_pemeriksaan = $jns_pemeriksaan;
      if (isset($_POST['PemeriksaancciT'])) {
          $ok = true;
          $trans = Yii::app()->db->beginTransaction();
          try {

              $cci->attributes = $_POST['PemeriksaancciT'];
              // if(empty($_POST['PemeriksaancciT']['pemeriksaancci_id'])) {
              //   $cci->pemeriksaancci_id = null;
              // }
              $cci->tgl_pemeriksaan = MyFormatter::formatDateTimeForDb($_POST['PemeriksaancciT']['tgl_pemeriksaan']);
              $cci->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
              
              $cci->pendaftaran_id = $modKunjungan->pendaftaran_id;
              $cci->pasien_id = $modKunjungan->pasien_id;
              $cci->pasienadmisi_id = $modKunjungan->pasienadmisi_id;

              $cci->no_lab = $kelompok->tindakanpelayanan->no_lab;

              if(!empty($tindakan)) {
                $cci->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
                $cci->daftartindakan_id = $tindakan->daftartindakan_id;
              }

              if(empty($pemeriksaancci_id)) {
                $cci->create_time = date('Y-m-d H:i:s');
                $cci->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                $cci->create_ruangan = Yii::app()->user->getState('ruangan_id');
              } else {
                $cci->update_time = date('Y-m-d H:i:s');
                $cci->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
              } 

              $ok = $ok && $cci->save();

              if($ok && !isset($pemeriksaancci_id)) {
                $kelompok->pemeriksaancci_id = $cci->pemeriksaancci_id;
                $kelompok->is_pemeriksaancci = true;

                $kelompok->pendaftaran_id = $modKunjungan->pendaftaran_id;
                $kelompok->pasien_id = $modKunjungan->pasien_id;
                $kelompok->pasienadmisi_id = $modKunjungan->pasienadmisi_id;
                $kelompok->pasienmasukpenunjang_id = $modKunjungan->pasienmasukpenunjang_id;
                $kelompok->tgl_pemeriksaan = $cci->tgl_pemeriksaan;
                $kelompok->no_lab = $cci->no_lab;
                $kelompok->pegawai_id = $cci->pegawai_id;
                $kelompok->dpjp_id = $cci->dpjp_id;
                $kelompok->perawat_id = $cci->perawat_id;
                $kelompok->tindakanpelayanan_id = $cci->tindakanpelayanan_id;

                $kelompok->create_time = date('Y-m-d H:i:s');
                $kelompok->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');

                $ok = $ok && $kelompok->save();
                
              }

              // var_dump($ok); die;

              if ($ok) {
                  $trans->commit();
                  Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                  $this->redirect(array('CCI', 'penilaian_kelayakan_spesimen_id' => '', 'kelompokpemeriksaanmikro_id' => $kelompokpemeriksaanmikro_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pemeriksaan' => 'cci', 'pemeriksaancci_id' => $cci->pemeriksaancci_id, 'jenispemeriksaanlab_id' => $jenispemeriksaanlab_id, 'sukses' => 1));
              } else {
                  $trans->rollback();
                  Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($cci));
              }
          } catch (Exception $exc) {
              echo '<pre>'; var_dump($exc); die;
              $trans->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
          }
      }

      $this->render('hasilExpertise', array('modKunjungan' => $modKunjungan, 'kelompok' => $kelompok, 'cci' => $cci));
    }

    public function actionPrintCci($pemeriksaancci_id)
    {
      $this->layout = '//layouts/printWindows';

      $cci = PemeriksaancciT::model()->findByPk($pemeriksaancci_id);
      $modKelompokcci = KelompokpemeriksaanmikroT::model()->findByAttributes(['pemeriksaancci_id' => $pemeriksaancci_id]);

      $modPendaftaran = PendaftaranT::model()->findByPk($cci->pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($cci->pasien_id);

      $this->render($this->path_view_daftar . '_hasilAnalis/_printCci', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'cci' => $cci, 'modKelompokcci' => $modKelompokcci));

    }
    
    public function actionValidasi() {
        if (!Yii::app()->request->isAjaxRequest) {
          Yii::app()->end();
        }
  
        $id = $_POST['id'];
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        
        try {
  
          $kel = KelompokpemeriksaanmikroT::model()->findByPk($id);
          
          if($kel->is_validasi != true) {
              $kel->is_validasi = true;
          } else {
              $kel->is_validasi = false;
          }

          $kel->update_time = date('Y-m-d H:i:s');
          $kel->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

          $ok = $ok && $kel->save();
  
          $trans->commit();
          echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>'Validasi hasil pemeriksaan berhasil diubah',
          ));
  
          // var_dump($_POST); die;
  
        } catch (Exception $e) {
          $trans->rollback();
          echo CJSON::encode(array(
            'ok'=>0,
            'msg'=>$e->getMessage()
          ));
        }
  
      }

    
    public function actionKirimHasil() {
        if (!Yii::app()->request->isAjaxRequest) {
          Yii::app()->end();
        }
  
        $id = $_POST['id'];
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        
        try {
  
          $kel = KelompokpemeriksaanmikroT::model()->findByPk($id);
          
          if($kel->is_kirimhasil != true) {
              $kel->is_kirimhasil = true;
              $this->notifKirimHasil($kel, $kel->pendaftaran, 'kirim');
          } else {
            $this->notifKirimHasil($kel, $kel->pendaftaran, 'batal');
              $kel->is_kirimhasil = false;
          }

          $kel->update_time = date('Y-m-d H:i:s');
          $kel->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

          $ok = ($ok && $kel->save()) ? 1 : 0;
  
          $trans->commit();
          echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>'Validasi hasil pemeriksaan berhasil diubah',
          ));
  
          // var_dump($_POST); die;
  
        } catch (Exception $e) {
          $trans->rollback();
          echo CJSON::encode(array(
            'ok'=>0,
            'msg'=>$e->getMessage()
          ));
        }
  
      }

      public function notifKirimHasil($kel, $pendaftaran, $kirim)
      {

        var_dump('kirim hasil', $pendaftaran->ruangan->ruangan_nama, $kel->pendaftaran_id);

          $pengiriman = $kirim == 'kirim' ? 'Kirim Hasil Laboratorium' : 'Batal Kirim Hasil Laboratorium';
          $judul = "$pengiriman";
  
          $asal = RuanganM::model()->findByPk($pendaftaran->ruangan_id);

          $isi = "No. Pendaftaran : " . $pendaftaran->no_pendaftaran . "<br/>";
          $isi .= "Pasien : " . $kel->pasien->no_rekam_medik . " - " . $kel->pasien->nama_pasien;
          $isi .= '<hr>';
  
          $link = $this->createUrl('/rawatJalan/pemeriksaanPasien/index', array(
              'pendaftaran_id' => $kel->pendaftaran_id
          ));
  
          $ok = CustomFunction::broadcastNotif($judul, $isi, array(
          array('instalasi_id' => $pendaftaran->instalasi_id, 'ruangan_id' => $pendaftaran->ruangan_id, 'modul_id' => $asal->modul_id, 'link_proses' => $link),
          ));
      }



    
}