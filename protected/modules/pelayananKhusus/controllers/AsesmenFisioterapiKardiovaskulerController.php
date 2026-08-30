<?php
/**
 *
 * controller transaksi asesmen fisioterapi kardiovaskuler
 *
 * @package      application.modules.rehabMedis
 * @subpackage   controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 */
class AsesmenFisioterapiKardiovaskulerController extends MyAuthController
{
    public $defaultAction = 'index';
    public $path_view = 'rehabMedis.views.asesmenFisioterapiKardiovaskuler.';
    public $init = '';
    public $layout = '//layouts/iframe';
    public $tersimpan = false;

    /**
     * action ini digunakan sebagai halaman utama transaksi keseimbangan cairan
     * parameter yang digunakan dan wajib ada yaitu pendaftaran_id, untuk parameter pasienadmisi_id bersifat optional
     * @param type $publikasi_id
     */
    public function actionIndex($pendaftaran_id,$pasienadmisi_id=null,$pasienmasukpenunjang_id)
    {
      $modPendaftaran= RMPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = RMPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $ruanganid = Yii::app()->user->getState("ruangan_id");

      $periksaTesSpesifik = PemeriksaantesspesifikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id,'create_ruangan'=>$ruanganid),array('order'=>'create_time DESC'));
      $testPesifik = "";

      if(isset($periksaTesSpesifik) && !empty($periksaTesSpesifik)){
        $periksaTesSpesifikDet = PemeriksaantesspesifikdetT::model()->findAllByAttributes(array('pemeriksaantesspesifik_id'=>$periksaTesSpesifik->pemeriksaantesspesifik_id));

        if(count($periksaTesSpesifikDet) > 0){
          foreach($periksaTesSpesifikDet as $i=> $detailTestSpesifik){
            if($i > 0){
              $testPesifik .= ", ";
            }
            $testPesifik .= $detailTestSpesifik->nama;
          }
        }
      }

      $cekAnamnesa = AnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      $cekPemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

      $model = AsesmenFisioterapiKardiovaskulerT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

      if(!isset($model) || empty($model->asesmen_fisioterapi_kardiovaskuler_id)){
        $model = new AsesmenFisioterapiKardiovaskulerT();
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
        $model->tanggal_catat = date('d M Y');
        $model->test_khusus = $testPesifik;

        if (!empty($cekAnamnesa)) {
            // var_dump($model->attributes, $cekAnamnesa->attributes); die;
            $model->keluhanutama = $cekAnamnesa->keluhanutama;
            // $model->keluhantambahan = $cekAnamnesa->keluhantambahan;
            $model->riwayatpenyakit = $cekAnamnesa->riwayatpenyakitterdahulu;
            // $model->riwayat_keluarga = $cekAnamnesa->riwayatpenyakitkeluarga;
        }
        if (!empty($cekPemeriksaanFisik)) {
            $model->td_systolic = $cekPemeriksaanFisik->td_systolic;
            $model->td_dyastolic = $cekPemeriksaanFisik->td_diastolic;
            $model->nadi = $cekPemeriksaanFisik->detaknadi;
            $model->pernapasan = $cekPemeriksaanFisik->pernapasan;
            $model->suhutubuh = str_replace(",", ".", $cekPemeriksaanFisik->suhutubuh);
            // $model->skala_wongbaker_nrs = $cekPemeriksaanFisik->skala_wongbaker_nrs;
        }

      }

      $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'ruangan_id'=>$ruanganid));
      $diagnosaUtama = "";
      $diagnosaTambahan = "";
      $diagnosa_id = null;

      if(count($pasienMorbid) >0){
          $indexKel2=0;
          $indexKel3=0;

          foreach ($pasienMorbid as $datamorbid){
            $diagnosa_id = $datamorbid->diagnosa_id;
              if($datamorbid->kelompokdiagnosa_id == 2){
                  if($indexKel2 > 0){
                      $diagnosaUtama .= ", ";
                  }
                  $diagnosaUtama .= $datamorbid->diagnosa->diagnosa_nama;
                  $indexKel2++;
              }

              if($datamorbid->kelompokdiagnosa_id == 3){
                  if($indexKel3 > 0){
                      $diagnosaTambahan .= ", ";
                  }
                  $diagnosaTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                  $indexKel3++;
              }
          }
      }
      $model->diagnosa_id = $diagnosa_id;
      $model->diagnosa_nama = "Diagnosa Utama: ".$diagnosaUtama." \n\n Diagnosa Tambahan: ".$diagnosaTambahan;

      $pemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'create_ruangan'=>$ruanganid));

      if(isset($pemeriksaanFisik) && empty($model->asesmen_fisioterapi_kardiovaskuler_id)){
        $model->td_dyastolic = $pemeriksaanFisik->td_diastolic;
        $model->td_systolic = $pemeriksaanFisik->td_systolic;
      }

      if(isset($_POST['AsesmenFisioterapiKardiovaskulerT'])) {
          $transaction = Yii::app()->db->beginTransaction();

          try {
              $model->attributes = $_POST['AsesmenFisioterapiKardiovaskulerT'];
              $model->tanggal_catat = MyFormatter::formatDateTimeForDb($_POST['AsesmenFisioterapiKardiovaskulerT']['tanggal_catat']);
              $model->jam_pengisian = (!empty($_POST['AsesmenFisioterapiKardiovaskulerT']['jam_pengisian'])? $_POST['AsesmenFisioterapiKardiovaskulerT']['jam_pengisian'] : null);

              if(!empty($model->asesmen_fisioterapi_kardiovaskuler_id)){
                  $model->update_time = date('Y-m-d H:i:s');
                  $model->update_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
              }else{
                $model->pencatat_id = Yii::app()->user->getState('pegawai_id');
                  $model->create_time = date('Y-m-d H:i:s');
                  $model->create_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
              }
              $model->create_ruangan = Yii::app()->user->getState("ruangan_id");

              $tersimpanMMT = true;
              $tersimpanExtra = true;
              $tersimpanSinistra = true;

              if(isset($_POST['PalpasiOtot']) && count($_POST['PalpasiOtot']) > 0){
                $arrSpasme = array();
                foreach($_POST['PalpasiOtot'] as $spasme){
                  if(isset($spasme['ischeckotot']) && $spasme['ischeckotot'] == 1){
                    $arrSpasme[] = $spasme['nama'];
                  }
                }

                if(count($arrSpasme) > 0){
                  $model->palpasi_spasme_otot = json_encode($arrSpasme);
                }
              }

              if(isset($_POST['AsesmenFisioterapiKardiovaskulerT']['inspeksi_statik_bentukdada']) && count($_POST['AsesmenFisioterapiKardiovaskulerT']['inspeksi_statik_bentukdada']) > 0){


                $statik_data = array();
                foreach($_POST['AsesmenFisioterapiKardiovaskulerT']['inspeksi_statik_bentukdada'] as $statik){

                    $statik_data[] = $statik;
                }

                if(count($statik_data) > 0){
                    $model->inspeksi_statik_bentukdada = json_encode($statik_data);
                }
            }


            if(isset($_POST['AsesmenFisioterapiKardiovaskulerT']['palpasi_ekspansi_thorax']) && count($_POST['AsesmenFisioterapiKardiovaskulerT']['palpasi_ekspansi_thorax']) > 0){

                $palpasi_data = array();
                foreach($_POST['AsesmenFisioterapiKardiovaskulerT']['palpasi_ekspansi_thorax'] as $palpasi){
                    $palpasi_data[] = $palpasi;
                }

                if(count($palpasi_data) > 0){
                    $model->palpasi_ekspansi_thorax = json_encode($palpasi_data);
                }
            }


              if($model->save()){
                  $this->tersimpan = true;
              }else{
                 $this->tersimpan = false;
              }

              if($this->tersimpan == true){
                  $transaction->commit();
                  Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                  $this->redirect(array('index','pendaftaran_id'=>$model->pendaftaran_id,'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,'sukses'=>1));
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
      ));
    }

    public function actionPrint($pendaftaran_id, $pasienmasukpenunjang_id) {
      $modPendaftaran= RMPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = RMPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $ruanganid = Yii::app()->user->getState("ruangan_id");

      $model = AsesmenFisioterapiKardiovaskulerT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modPendaftaran->pasienadmisi_id,'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

      if(!isset($model) || empty($model->asesmen_fisioterapi_kardiovaskuler_id)){
        $model = new AsesmenFisioterapiKardiovaskulerT();
      }

      $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'ruangan_id'=>$ruanganid));
      $diagnosaUtama = "";
      $diagnosaTambahan = "";
      $diagnosa_id = null;

      if(count($pasienMorbid) >0){
          $indexKel2=0;
          $indexKel3=0;

          foreach ($pasienMorbid as $datamorbid){
            $diagnosa_id = $datamorbid->diagnosa_id;
              if($datamorbid->kelompokdiagnosa_id == 2){
                  if($indexKel2 > 0){
                      $diagnosaUtama .= ", ";
                  }
                  $diagnosaUtama .= $datamorbid->diagnosa->diagnosa_nama;
                  $indexKel2++;
              }

              if($datamorbid->kelompokdiagnosa_id == 3){
                  if($indexKel3 > 0){
                      $diagnosaTambahan .= ", ";
                  }
                  $diagnosaTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                  $indexKel3++;
              }
          }
      }
      $model->diagnosa_nama = "Diagnosa Utama: ".$diagnosaUtama;
      $model->diagnosatambahan = "Diagnosa Tambahan: ".$diagnosaTambahan;

        $this->layout = '//layouts/printWindows';
        $this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran));
    }
}
