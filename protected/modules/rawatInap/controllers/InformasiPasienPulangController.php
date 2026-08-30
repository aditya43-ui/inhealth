<?php

class InformasiPasienPulangController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Pulang";
    $format = new MyFormatter();
    $modPasienYangPulang = new RIPasienygPulangriV;
    $modPasienYangPulang->tgl_awal = date('Y-m-d');
    $modPasienYangPulang->tgl_akhir = date('Y-m-d');
    if (isset($_GET['RIPasienygPulangriV'])) {
      $modPasienYangPulang->attributes = $_GET['RIPasienygPulangriV'];
      $modPasienYangPulang->tgl_awal = $format->formatDateTimeForDb($_GET['RIPasienygPulangriV']['tgl_awal']);
      $modPasienYangPulang->tgl_akhir = $format->formatDateTimeForDb($_GET['RIPasienygPulangriV']['tgl_akhir']);
      $modPasienYangPulang->ceklis = $_GET['RIPasienygPulangriV']['ceklis'];
      $modPasienYangPulang->tgl_awal = $modPasienYangPulang->tgl_awal . " 00:00:00";
      $modPasienYangPulang->tgl_akhir = $modPasienYangPulang->tgl_akhir . " 23:59:59";
      $modPasienYangPulang->prefix_pendaftaran = $_GET['RIPasienygPulangriV']['prefix_pendaftaran'];
      $modPasienYangPulang->pegawai_id = $_GET['RIPasienygPulangriV']['pegawai_id'];
      $modPasienYangPulang->carakeluar_id = $_GET['RIPasienygPulangriV']['carakeluar_id'];
      $modPasienYangPulang->kondisikeluar_id = $_GET['RIPasienygPulangriV']['kondisikeluar_id'];
    }
    $this->render('index', array('format' => $format, 'modPasienYangPulang' => $modPasienYangPulang));
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

  //        public function actionBatalPulang()
  //        {
  //            if(Yii::app()->request->isAjaxRequest){
  //            $idOtoritas = $_POST['idOtoritas'];
  //            $namaOtoritas = $_POST['namaOtoritas'];
  //            $idPasienPulang=$_POST['idPasienPulang'];
  //            $pasienadmisi_id=$_POST['pasienadmisi_id'];
  //            $alasanPembatalan=$_POST['Alasan'];
  //            
  //            
  //            $modPasienBatalPulang = new RIPasienBatalPulangT;    
  //            $modPasienBatalPulang->namauser_otorisasi=$namaOtoritas;
  //            $modPasienBatalPulang->iduser_otorisasi=$idOtoritas;
  //            $modPasienBatalPulang->pasienpulang_id=$idPasienPulang;
  //            $modPasienBatalPulang->tglpembatalan=date('Y-m-d H:i:s');
  //             $modPasienBatalPulang->alasanpembatalan=$alasanPembatalan;
  //             $transaction = Yii::app()->db->beginTransaction();
  //             try{
  //                if($modPasienBatalPulang->save()){
  //                    $pulang = RIPasienPulangT::model()->updateByPk($idPasienPulang,array('pasienbatalpulang_id'=>$modPasienBatalPulang->pasienbatalpulang_id));
  //                    $admisi = RIPasienAdmisiT::model()->updateByPk($pasienadmisi_id, array('pasienpulang_id'=>null));  
  //                    if ($pulang && $admisi){
  //                        $data['status'] = 'success';
  //                        $transaction->commit();
  //                    }
  //                    else{
  //                        throw new Exception("Update Data Gagal");
  //                    }
  //                }
  //                else{
  //                    Throw new Exception("Pasien Batal Pulang Gagal Disimpan");
  //                }
  //             }catch(Exception $ex){
  //                 $transaction->rollback();
  //                 $data['status'] = $ex;
  //             }
  //
  //            echo json_encode($data);
  //            Yii::app()->end();
  //            }
  //        }
  public function actionBatalPulang($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';

    $modPendaftaran    = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien         = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'tgladmisi DESC', 'limit' => 1));

    $modPasienPulang   = PasienpulangT::model()->findByAttributes(array('pasienadmisi_id' => $modPasienAdmisi->pasienadmisi_id));

    $modPasienBatalPulang  = new PasienbatalpulangT;
    $modPasienBatalPulang->create_time             = date('Y-m-d H:i:s');
    $modPasienBatalPulang->update_time             = date('Y-m-d H:i:s');
    $modPasienBatalPulang->namauser_otorisasi      = Yii::app()->user->name;;
    $modPasienBatalPulang->iduser_otorisasi        = Yii::app()->user->id;
    $modPasienBatalPulang->create_loginpemakai_id  = Yii::app()->user->id;
    $modPasienBatalPulang->update_loginpemakai_id  = Yii::app()->user->id;
    $modPasienBatalPulang->create_ruangan          = Yii::app()->user->getState('ruangan_id');
    $modPasienBatalPulang->pasienpulang_id         = $modPasienPulang->pasienpulang_id;

    $jenisPenyakit         = JeniskasuspenyakitM::model()->findByPk($modPendaftaran->jeniskasuspenyakit_id);
    $modPendaftaran->jeniskasuspenyakit_nama   = $jenisPenyakit->jeniskasuspenyakit_nama;
    //             digunakan untuk merefresh jika data berhasil di simpan
    $tersimpan = 'Tidak';

    if (!empty($_POST['PasienbatalpulangT'])) {
      $format = new MyFormatter();
      $modPasienBatalPulang->attributes = $_POST['PasienbatalpulangT'];
      $modPasienBatalPulang->tglpembatalan = $format->formatDateTimeForDb($modPasienBatalPulang->tglpembatalan);

      if ($modPasienBatalPulang->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if ($modPasienBatalPulang->save()) {
            $pasienpulang_id = $modPasienBatalPulang->pasienpulang_id;
            $pasienadmisi_id = $_POST['pasienadmisi_id'];
            $pasienPulang = RIPasienPulangT::model()->updateByPk($pasienpulang_id, array('pasienbatalpulang_id' => $modPasienBatalPulang->pasienbatalpulang_id));
            $pasienAdmisi = RIPasienAdmisiT::model()->updateByPk($pasienadmisi_id, array('pasienpulang_id' => null));
            if ($pasienAdmisi && $pasienPulang) {
              $transaction->commit();
              RIPendaftaranT::model()->updateByPk(
                $pendaftaran_id,
                array(
                  'statusperiksa' => Params::STATUSPERIKSA_SEDANG_DIRAWATINAP,
                  'pasienpulang_id' => null
                )
              );
              Yii::app()->user->setFlash('success', "Data berhasil disimpan");
              $tersimpan = 'Ya';
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan");
            }
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan", MyExceptionMessage::getMessage($exc, true));
        }
      }
    }

    $this->render('_formBatalPulang', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPasienBatalPulang' => $modPasienBatalPulang,
      'modPasienAdmisi' => $modPasienAdmisi,
      'tersimpan' => $tersimpan
    ));
  }

  /**
   * set dropdown penjamin pasien dari carabayar_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
}
