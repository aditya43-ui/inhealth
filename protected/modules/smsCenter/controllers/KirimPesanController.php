<?php

/**
 * Class untuk proses kirim pesan sms gateway dan sms blash
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.modules.smsCenter
 * @subpackage controller
 */
class KirimPesanController extends MyAuthController
{
  public $defaultAction = 'index';
  public $is_blast = false;
  public $path_view = 'smsCenter.views.kirimPesan.';

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $this->render($this->path_view . 'index');
  }

  /**
   * Proses kirim Sms Blast
   * @param string $no_tujuan
   * @param string $text
   * @param string $redirect_route
   * @param integer $id_department
   */
  public function kirimBlast($no_tujuan, $text, $redirect_route, $id_department = 1)
  {
    $api = new MyAPI();

    $response = $api->smsBlastSend($no_tujuan, 'RSDrSoetomo', $text, $id_department);

    $count = count($response);
    $error_count = 0;
    $no = array();

    foreach ($response as $item) {
      $sentItems = new Sentitems();
      $sentItems->UpdatedInDB = $sentItems->InsertIntoDB = date('Y-m-d H:i:s');
      $sentItems->SendingDateTime = date('Y-m-d H:i:s');
      $sentItems->DestinationNumber = $item['no'];
      $sentItems->Coding = "Default_No_Compression";
      $sentItems->SMSCNumber = "SMS Blast";
      $sentItems->Class = '-1';
      $sentItems->TextDecoded = $text;
      $sentItems->SequencePosition = 1;
      $sentItems->StatusError = -1;
      $sentItems->TPMR = 0;
      $sentItems->RelativeValidity = 255;
      $sentItems->CreatorID = 'RSDrSoetomo';
      $sentItems->SenderID = 'RSDrSoetomo';
      $sentItems->Text = "0";
      $sentItems->UDH = "0";

      if ($item['code'] != 1) {
        array_push($no, $item['no']);
        $sentItems->Status = "SendingError";
        $error_count++;
      } else {
        $sentItems->Status = "SendingOKNoReport";
        $sentItems->blast_id = $item['msgid'];
      }

      $sentItems->save();
    }

    if ($error_count > 0) {
      Yii::app()->user->setFlash('error', $error_count . " dari " . $count . " pesan, gagal dikirim.");
      $this->redirect($redirect_route);
    } else {
      Yii::app()->user->setFlash('success', "Semua pesan berhasil dikirim.");
      $this->redirect($redirect_route);
    }
  }

  /**
   * Default menu sms gateway pasien, serta proses simpan transaksinya
   */
  public function actionPasien()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien";
    $model = new Outbox;
    $modelPbk = new Pbk;
    $modPasien = new PasiensmscenterV;
    $model->CreatorID = $this->is_blast ? 'RSDrSoetomo' : Yii::app()->user->name;

    $modPasien = new PasiensmscenterV;
    $modPasien->tgl_rekam_medik = date('m/d/Y') . ' - ' . date('m/d/Y');
    $modPasien->tanggal_lahir = date('Y-m-d');
    if (isset($_GET['PasiensmscenterV'])) {
      $modPasien->unsetAttributes();
      $modPasien->attributes = $_GET['PasiensmscenterV'];
      $modPasien->pasien_ulang_tahun = $_GET['PasiensmscenterV']['pasien_ulang_tahun'];
      $modPasien->is_tgllahir = $_GET['PasiensmscenterV']['is_tgllahir'];
      $modPasien->nomor_valid = $_GET['PasiensmscenterV']['nomor_valid'];
    }

    if (isset($_POST['Outbox'])) {
      $noHpPasien = array();
      $noRmPasien = array();
      foreach ($_POST['Nomor'] as $i => $value) {
        $pasien = PasienM::model()->findByAttributes(array('no_rekam_medik' => $value));
        if (!empty($pasien->no_mobile_pasien) && $pasien->no_mobile_pasien != "" && $pasien->no_mobile_pasien != "-") {
          $noHpPasien[] = $pasien->no_mobile_pasien;
          $noRmPasien[$pasien->no_mobile_pasien] = $pasien->no_rekam_medik;
        }
      }

      $no_tujuan = $noHpPasien;

      if ($this->is_blast) {
        $this->kirimBlast($no_tujuan, $_POST['Outbox']['TextDecoded'], array('pasien'));
      }

      $id = null;
      $udh = '';
      $hex_number = '';
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (!empty($no_tujuan)) {
          foreach ($no_tujuan as $i => $nomor) {

            $pesan = $_POST['Outbox']['TextDecoded'];
            $pasien = PasienM::model()->findByAttributes(array('no_rekam_medik' => $noRmPasien[$nomor]));
            $attributes = $pasien->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $pesan = str_replace("{{" . $attributes . "}}", $value, $pesan);
            }
            $pesanArray = str_split(isset($pesan) ? $pesan : '', 153);
            $jumlah_part = count($pesanArray);

            $hex_number = $this->getRandomHex();
            foreach ($pesanArray as $j => $psn) {
              $udh = $hex_number . str_pad($jumlah_part, 2, "0", STR_PAD_LEFT) . str_pad($j + 1, 2, "0", STR_PAD_LEFT);
              if ($j == 0) {
                if (count($pesanArray) <= 1) {
                  $udh = '';
                }
                $model = new Outbox;
                $model->attributes = $_POST['Outbox'];
                $model->DestinationNumber = $nomor;
                $model->UDH = $udh;
                $model->TextDecoded = $psn;
                $model->MultiPart = ($jumlah_part > 1) ? 'true' : 'false';

                if ($model->save()) {
                  $id = $model->ID;
                }
              } else {
                $modMultiPart = new OutboxMultipart;
                $modMultiPart->UDH = $udh;
                $modMultiPart->TextDecoded = $psn;
                $modMultiPart->ID = $id;
                $modMultiPart->SequencePosition = $j + 1;
                $modMultiPart->save();
              }
            }

            $cekPbk = Pbk::model()->findByAttributes(array('Number' => $nomor));
            if (!isset($cekPbk->Number) && empty($cekPbk->Number)) {
              $modelPbk = new Pbk;
              $modelPbk->GroupID = Params::GROUP_PASIEN;
              $modelPbk->Name = $pasien->nama_pasien;
              $modelPbk->Number = $nomor;
              $modelPbk->save();
            }
          }
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Pesan berhasil dikirim.');
          $transaction->commit();
        } else {
          Yii::app()->user->setFlash('success', 'Pesan tidak dikirim karena nomor tidak sesuai.');
          $transaction->rollback();
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Pesan gagal dikirim. " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'kirimpasien', array(
      'model' => $model,
      'modPasien' => $modPasien
    ));
  }

  /**
   * Default menu sms gateway pegawai, serta proses simpan transaksinya
   */
  public function actionPegawai()
  {
    $this->pageTitle = Yii::app()->name . " - Pegawai";
    $model = new Outbox;
    $model->CreatorID = $this->is_blast ? 'RSDrSoetomo' : Yii::app()->user->name;

    $modPegawai = new PegawaismscenterV;
    if (isset($_GET['PegawaismscenterV'])) {
      $modPegawai->unsetAttributes();
      $modPegawai->attributes = $_GET['PegawaismscenterV'];
      $modPegawai->nomor_valid = $_GET['PegawaismscenterV']['nomor_valid'];
    }

    if (isset($_POST['Outbox'])) {
      $noHpPegawai = array();
      $noIdPegawai = array();
      foreach ($_POST['Nomor'] as $i => $value) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('pegawai_id=' . $value);
        $criteria->addCondition("length(nomobile_pegawai) >= 9 OR LEFT(nomobile_pegawai, 2) = '08' OR LEFT(nomobile_pegawai, 4) = '+628'");
        $pegawai = PegawaiM::model()->find($criteria);
        if (!empty($pegawai->nomobile_pegawai) && $pegawai->nomobile_pegawai != "" && $pegawai->nomobile_pegawai != "-" && $pegawai->nomobile_pegawai != "0" && $pegawai->nomobile_pegawai != "NULL") {
          $noHpPegawai[] = $pegawai->nomobile_pegawai;
          $noIdPegawai[$pegawai->nomobile_pegawai] = $pegawai->pegawai_id;
        }
      }

      $no_tujuan = $noHpPegawai;


      if ($this->is_blast) {
        $this->kirimBlast($no_tujuan, $_POST['Outbox']['TextDecoded'], array('pegawai'));
      }

      $id = null;
      $udh = '';
      $hex_number = '';
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (!empty($no_tujuan)) {
          foreach ($no_tujuan as $i => $nomor) {

            $pesan = $_POST['Outbox']['TextDecoded'];
            $pegawai = PegawaiM::model()->findByPk($noIdPegawai[$nomor]);
            $attributes = $pegawai->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $pesan = str_replace("{{" . $attributes . "}}", $value, $pesan);
            }
            $pesanArray = str_split(isset($pesan) ? $pesan : '', 153);
            $jumlah_part = count($pesanArray);

            $hex_number = $this->getRandomHex();
            foreach ($pesanArray as $j => $psn) {
              $udh = $hex_number . str_pad($jumlah_part, 2, "0", STR_PAD_LEFT) . str_pad($j + 1, 2, "0", STR_PAD_LEFT);
              if ($j == 0) {
                if (count($pesanArray) <= 1) {
                  $udh = '';
                }
                $model = new Outbox;
                $model->attributes = $_POST['Outbox'];
                $model->DestinationNumber = $nomor;
                $model->UDH = $udh;
                $model->TextDecoded = $psn;
                $model->MultiPart = ($jumlah_part > 1) ? 'true' : 'false';

                if ($model->save()) {
                  $id = $model->ID;
                }
              } else {
                $modMultiPart = new OutboxMultipart;
                $modMultiPart->UDH = $udh;
                $modMultiPart->TextDecoded = $psn;
                $modMultiPart->ID = $id;
                $modMultiPart->SequencePosition = $j + 1;
                $modMultiPart->save();
              }
            }

            $cekPbk = Pbk::model()->findByAttributes(array('Number' => $nomor));
            if (!isset($cekPbk->Number) && empty($cekPbk->Number)) {
              $modelPbk = new Pbk;
              $modelPbk->GroupID = Params::GROUP_PEGAWAI;
              $modelPbk->Name = $pegawai->nama_pegawai;
              $modelPbk->Number = $nomor;
              $modelPbk->save();
            }
          }
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Pesan berhasil dikirim.');
          $transaction->commit();
        } else {
          Yii::app()->user->setFlash('success', 'Pesan tidak dikirim karena nomor tidak sesuai.');
          $transaction->rollback();
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Pesan gagal dikirim. " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'kirimpegawai', array(
      'model' => $model,
      'modPegawai' => $modPegawai
    ));
  }

  /**
   * Load/colect data pegawai
   * @param array $param
   */
  protected function kumpulDataPegawai($param)
  {
    $ser = $param['serial'];
    $pegawai = new PegawaiM;

    $pegawai->ruangan_id = $ser[1]['value'];
    $pegawai->nomorindukpegawai = $ser[2]['value'];
    $pegawai->nama_pegawai = $ser[3]['value'];
    $pegawai->nomobile_pegawai = $ser[4]['value'];

    $provider = $pegawai->searchNoMobile();
    $provider->pagination = false;

    $res = array();

    foreach ($provider->data as $item) {
      array_push($res, array(
        'mobile' => (string) $item->nomobile_pegawai,
        'nama' => $item->nama_pegawai,
      ));
    }

    echo CJSON::encode($res);
  }

  /**
   * Default menu sms gateway untuk proses umum, serta proses simpan transaksinya
   */
  public function actionUmum()
  {
    $this->pageTitle = Yii::app()->name . " - Umum";
    $model = new Outbox;
    $modMultiPart = new OutboxMultipart;
    $model->CreatorID = $this->is_blast ? 'RSDrSoetomo' : Yii::app()->user->name;

    $modPasien = new PasienM;
    if (isset($_GET['PasienM'])) {
      $modPasien->unsetAttributes();
      $modPasien->attributes = $_GET['PasienM'];
      $modPegawai->nomor_valid = $_GET['PegawaismscenterV']['nomor_valid'];
    }

    if (isset($_POST['Outbox'])) {
      $no_tujuan = isset($_POST['Outbox']['DestinationNumber']) ? $_POST['Outbox']['DestinationNumber'] : '';

      $pre_no_tujuan = explode(" ", $no_tujuan);

      foreach ($pre_no_tujuan as $idx => $val) {
        if (trim($val) == "") {
          unset($pre_no_tujuan[$idx]);
        }
      }

      $no_tujuan = array();
      foreach ($pre_no_tujuan as $idx => $val) {
        array_push($no_tujuan, $val);
      }


      if ($this->is_blast) {
        $this->kirimBlast($no_tujuan, $_POST['Outbox']['TextDecoded'], array('umum'));
      }

      $pesan = str_split(isset($_POST['Outbox']['TextDecoded']) ? $_POST['Outbox']['TextDecoded'] : '', 153);
      $jumlah_part = count($pesan);
      $id = null;
      $udh = '';
      $hex_number = '';
      $transaction = Yii::app()->db->beginTransaction();
      try {
        foreach ($no_tujuan as $i => $nomor) {
          $hex_number = $this->getRandomHex();
          foreach ($pesan as $j => $psn) {
            $udh = $hex_number . str_pad($jumlah_part, 2, "0", STR_PAD_LEFT) . str_pad($j + 1, 2, "0", STR_PAD_LEFT);
            if (count($pesan) <= 1) {
              $udh = '';
            }
            if ($j == 0) {
              $model = new Outbox;
              $model->attributes = $_POST['Outbox'];
              $model->DestinationNumber = $nomor;
              $model->UDH = $udh;
              $model->TextDecoded = $psn;
              $model->MultiPart = ($jumlah_part > 1) ? 'true' : 'false';

              if ($model->save()) {
                $id = $model->ID;
              }
            } else {

              $modMultiPart = new OutboxMultipart;
              $modMultiPart->UDH = $udh;
              $modMultiPart->TextDecoded = $psn;
              $modMultiPart->ID = $id;
              $modMultiPart->SequencePosition = $j + 1;
              $modMultiPart->save();
            }
          }
        }
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Pesan berhasil dikirim.');
        $transaction->commit();
        $this->refresh();
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Pesan gagal dikirim. " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'kirimumum', array('model' => $model));
  }

  /**
   * Default menu sms gateway kunjungan pasien, serta proses simpan transaksinya
   */
  public function actionKunjunganPasien()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Kunjungan";
    $model = new Outbox;
    $modelPbk = new Pbk;
    $modPasien = new PasienberkunjungsmscenterV;
    $model->CreatorID = $this->is_blast ? 'RSDrSoetomo' : Yii::app()->user->name;

    $modPasien->tgl_pendaftaran = date('m/d/Y') . ' - ' . date('m/d/Y');
    $modPasien->tglrenkontrol = date('m/d/Y') . ' - ' . date('m/d/Y');
    if (isset($_GET['PasienberkunjungsmscenterV'])) {
      $modPasien->unsetAttributes();
      $modPasien->attributes = $_GET['PasienberkunjungsmscenterV'];
      $modPasien->is_tglKontrol = $_GET['PasienberkunjungsmscenterV']['is_tglKontrol'];
      $modPasien->nomor_valid = $_GET['PasienberkunjungsmscenterV']['nomor_valid'];
    }

    if (isset($_POST['Outbox'])) {
      $noHpPasien = array();
      $noRmPasien = array();

      $RM = array_unique($_POST['Nomor']);

      foreach ($RM as $i => $value) {
        $pasien = PasienM::model()->findByAttributes(array('no_rekam_medik' => $value));
        if (!empty($pasien->no_mobile_pasien) && $pasien->no_mobile_pasien != "" && $pasien->no_mobile_pasien != "-") {
          $noHpPasien[] = $pasien->no_mobile_pasien;
          $noRmPasien[$pasien->no_mobile_pasien] = $pasien->no_rekam_medik;
        }
      }

      $no_tujuan = $noHpPasien;

      if ($this->is_blast) {
        $this->kirimBlast($no_tujuan, $_POST['Outbox']['TextDecoded'], array('kunjunganPasien'));
      }

      $id = null;
      $udh = '';
      $hex_number = '';
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if ($no_tujuan) {
          foreach ($no_tujuan as $i => $nomor) {

            $pesan = $_POST['Outbox']['TextDecoded'];
            $pasien = PasienM::model()->findByAttributes(array('no_rekam_medik' => $noRmPasien[$nomor]));
            $attributes = $pasien->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $pesan = str_replace("{{" . $attributes . "}}", $value, $pesan);
            }
            $pesanArray = str_split(isset($pesan) ? $pesan : '', 153);
            $jumlah_part = count($pesanArray);

            $hex_number = $this->getRandomHex();
            foreach ($pesanArray as $j => $psn) {
              $udh = $hex_number . str_pad($jumlah_part, 2, "0", STR_PAD_LEFT) . str_pad($j + 1, 2, "0", STR_PAD_LEFT);
              if ($j == 0) {
                if (count($pesanArray) <= 1) {
                  $udh = '';
                }
                $model = new Outbox;
                $model->attributes = $_POST['Outbox'];
                $model->DestinationNumber = $nomor;
                $model->UDH = $udh;
                $model->TextDecoded = $psn;
                $model->MultiPart = ($jumlah_part > 1) ? 'true' : 'false';

                if ($model->save()) {
                  $id = $model->ID;
                }
              } else {
                $modMultiPart = new OutboxMultipart;
                $modMultiPart->UDH = $udh;
                $modMultiPart->TextDecoded = $psn;
                $modMultiPart->ID = $id;
                $modMultiPart->SequencePosition = $j + 1;
                $modMultiPart->save();
              }
            }

            $cekPbk = Pbk::model()->findByAttributes(array('Number' => $nomor));
            if (!isset($cekPbk->Number) && empty($cekPbk->Number)) {
              $modelPbk = new Pbk;
              $modelPbk->GroupID = Params::GROUP_PASIEN;
              $modelPbk->Name = $pasien->nama_pasien;
              $modelPbk->Number = $nomor;
              $modelPbk->save();
            }
          }
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Pesan berhasil dikirim.');
          $transaction->commit();
        } else {
          Yii::app()->user->setFlash('success', 'Pesan tidak dikirim karena nomor tidak sesuai.');
          $transaction->rollback();
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Pesan gagal dikirim. " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'kirimpasienberkunjung', array(
      'model' => $model,
      'modPasien' => $modPasien
    ));
  }

  /**
   * Default menu sms gateway kunjungan RI, serta proses simpan transaksinya
   */
  public function actionKunjunganPasienRi()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Kunjungan Rawat Inap";
    $model = new Outbox;
    $modelPbk = new Pbk;
    $modPasien = new PasienrawatinapsmscenterV;
    $model->CreatorID = $this->is_blast ? 'RSDrSoetomo' : Yii::app()->user->name;

    $modPasien->tgladmisi = date('m/d/Y') . ' - ' . date('m/d/Y');
    $modPasien->tglpasienpulang = date('m/d/Y') . ' - ' . date('m/d/Y');
    if (isset($_GET['PasienrawatinapsmscenterV'])) {
      $modPasien->unsetAttributes();
      $modPasien->attributes = $_GET['PasienrawatinapsmscenterV'];
      $modPasien->is_tglPulang = $_GET['PasienrawatinapsmscenterV']['is_tglPulang'];
      $modPasien->nomor_valid = $_GET['PasienrawatinapsmscenterV']['nomor_valid'];
    }

    if (isset($_POST['Outbox'])) {
      $noHpPasien = array();
      $noRmPasien = array();

      $RM = array_unique($_POST['Nomor']);
      foreach ($RM as $i => $value) {
        $pasien = PasienM::model()->findByAttributes(array('no_rekam_medik' => $value));
        if (!empty($pasien->no_mobile_pasien) && $pasien->no_mobile_pasien != "" && $pasien->no_mobile_pasien != "-") {
          $noHpPasien[] = $pasien->no_mobile_pasien;
          $noRmPasien[$pasien->no_mobile_pasien] = $pasien->no_rekam_medik;
        }
      }

      $no_tujuan = $noHpPasien;

      if ($this->is_blast) {
        $this->kirimBlast($no_tujuan, $_POST['Outbox']['TextDecoded'], array('kunjunganPasienRI'));
      }

      $id = null;
      $udh = '';
      $hex_number = '';
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (!empty($no_tujuan)) {
          foreach ($no_tujuan as $i => $nomor) {

            $pesan = $_POST['Outbox']['TextDecoded'];
            $pasien = PasienM::model()->findByAttributes(array('no_rekam_medik' => $noRmPasien[$nomor]));
            $attributes = $pasien->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $pesan = str_replace("{{" . $attributes . "}}", $value, $pesan);
            }
            $pesanArray = str_split(isset($pesan) ? $pesan : '', 153);
            $jumlah_part = count($pesanArray);

            $hex_number = $this->getRandomHex();
            foreach ($pesanArray as $j => $psn) {
              $udh = $hex_number . str_pad($jumlah_part, 2, "0", STR_PAD_LEFT) . str_pad($j + 1, 2, "0", STR_PAD_LEFT);
              if ($j == 0) {
                if (count($pesanArray) <= 1) {
                  $udh = '';
                }
                $model = new Outbox;
                $model->attributes = $_POST['Outbox'];
                $model->DestinationNumber = $nomor;
                $model->UDH = $udh;
                $model->TextDecoded = $psn;
                $model->MultiPart = ($jumlah_part > 1) ? 'true' : 'false';

                if ($model->save()) {
                  $id = $model->ID;
                }
              } else {
                $modMultiPart = new OutboxMultipart;
                $modMultiPart->UDH = $udh;
                $modMultiPart->TextDecoded = $psn;
                $modMultiPart->ID = $id;
                $modMultiPart->SequencePosition = $j + 1;
                $modMultiPart->save();
              }
            }

            $cekPbk = Pbk::model()->findByAttributes(array('Number' => $nomor));
            if (!isset($cekPbk->Number) && empty($cekPbk->Number)) {
              $modelPbk = new Pbk;
              $modelPbk->GroupID = Params::GROUP_PASIEN;
              $modelPbk->Name = $pasien->nama_pasien;
              $modelPbk->Number = $nomor;
              $modelPbk->save();
            }
          }
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Pesan berhasil dikirim.');
          $transaction->commit();
        } else {
          Yii::app()->user->setFlash('success', 'Pesan tidak dikirim karena nomor tidak sesuai.');
          $transaction->rollback();
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Pesan gagal dikirim. " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'kirimpasienberkunjungRi', array(
      'model' => $model,
      'modPasien' => $modPasien
    ));
  }

  /**
   * Default menu sms gateway asuransi penjamin, serta proses simpan transaksinya
   */
  public function actionProviderAsuransi()
  {
    $this->pageTitle = Yii::app()->name . " - Asuransi";
    $model = new Outbox;
    $modelPbk = new Pbk;
    $modAsuransi = new PenjaminpasienM;
    $model->CreatorID = $this->is_blast ? 'RSDrSoetomo' : Yii::app()->user->name;

    if (isset($_GET['PenjaminpasienM'])) {
      $modAsuransi->unsetAttributes();
      $modAsuransi->attributes = $_GET['PenjaminpasienM'];
      $modAsuransi->nomor_valid = $_GET['PenjaminpasienM']['nomor_valid'];
    }

    if (isset($_POST['Outbox'])) {
      $noHpPenjamin = array();
      $idPenjamin = array();

      foreach ($_POST['Nomor'] as $i => $value) {
        $penjamin = PenjaminpasienM::model()->findByPk($value);
        if (!empty($penjamin->penjamin_nomobile) && $penjamin->penjamin_nomobile != "" && $penjamin->penjamin_nomobile != "-") {
          $noHpPenjamin[] = $penjamin->penjamin_nomobile;
          $idPenjamin[$penjamin->penjamin_nomobile] = $penjamin->penjamin_id;
        }
      }

      $no_tujuan = $noHpPenjamin;

      if ($this->is_blast) {
        $this->kirimBlast($no_tujuan, $_POST['Outbox']['TextDecoded'], array('providerAsuransi'));
      }

      $id = null;
      $udh = '';
      $hex_number = '';
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (!empty($no_tujuan)) {
          foreach ($no_tujuan as $i => $nomor) {

            $pesan = $_POST['Outbox']['TextDecoded'];
            $penjamin = PenjaminpasienM::model()->findByPk($idPenjamin[$nomor]);
            $attributes = $penjamin->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $pesan = str_replace("{{" . $attributes . "}}", $value, $pesan);
            }
            $pesanArray = str_split(isset($pesan) ? $pesan : '', 153);
            $jumlah_part = count($pesanArray);

            $hex_number = $this->getRandomHex();
            foreach ($pesanArray as $j => $psn) {
              $udh = $hex_number . str_pad($jumlah_part, 2, "0", STR_PAD_LEFT) . str_pad($j + 1, 2, "0", STR_PAD_LEFT);
              if ($j == 0) {
                if (count($pesanArray) <= 1) {
                  $udh = '';
                }
                $model = new Outbox;
                $model->attributes = $_POST['Outbox'];
                $model->DestinationNumber = $nomor;
                $model->UDH = $udh;
                $model->TextDecoded = $psn;
                $model->MultiPart = ($jumlah_part > 1) ? 'true' : 'false';

                if ($model->save()) {
                  $id = $model->ID;
                }
              } else {
                $modMultiPart = new OutboxMultipart;
                $modMultiPart->UDH = $udh;
                $modMultiPart->TextDecoded = $psn;
                $modMultiPart->ID = $id;
                $modMultiPart->SequencePosition = $j + 1;
                $modMultiPart->save();
              }
            }

            $cekPbk = Pbk::model()->findByAttributes(array('Number' => $nomor));
            if (!isset($cekPbk->Number) && empty($cekPbk->Number)) {
              $modelPbk = new Pbk;
              $modelPbk->GroupID = Params::GROUP_ASURANSI;
              $modelPbk->Name = $penjamin->penjamin_nama;
              $modelPbk->Number = $nomor;
              $modelPbk->save();
            }
          }

          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Pesan berhasil dikirim.');
          $transaction->commit();
        } else {
          Yii::app()->user->setFlash('success', 'Pesan tidak dikirim karena nomor tidak sesuai.');
          $transaction->rollback();
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Pesan gagal dikirim. " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'kirimproviderasuransi', array(
      'model' => $model,
      'modAsuransi' => $modAsuransi
    ));
  }

  /**
   * Default menu sms gateway supplier, serta proses simpan transaksinya
   */
  public function actionSupplier()
  {
    $this->pageTitle = Yii::app()->name . " - Supplier";
    $model = new Outbox;
    $modelPbk = new Pbk;
    $modSupplier = new SupplierM;
    $model->CreatorID = $this->is_blast ? 'RSDrSoetomo' : Yii::app()->user->name;

    if (isset($_GET['SupplierM'])) {
      $modSupplier->unsetAttributes();
      $modSupplier->attributes = $_GET['SupplierM'];
      $modSupplier->nomor_valid = $_GET['SupplierM']['nomor_valid'];
      $modSupplier->supplier_cp_hp = $_GET['SupplierM']['supplier_cp_hp'];
    }

    if (isset($_POST['Outbox'])) {
      $noHpSupplier = array();
      $idSupplier = array();

      foreach ($_POST['Nomor'] as $i => $value) {
        $supplier = SupplierM::model()->findByPk($value);

        if (!empty($supplier->supplier_cp_hp) && $supplier->supplier_cp_hp != "" && $supplier->supplier_cp_hp != "-") {
          $noHpSupplier[] = $supplier->supplier_cp_hp;
          $idSupplier[$supplier->supplier_cp_hp] = $supplier->supplier_id;
        }
      }

      $no_tujuan = $noHpSupplier;

      if ($this->is_blast) {
        $this->kirimBlast($no_tujuan, $_POST['Outbox']['TextDecoded'], array('supplier'));
      }

      $id = null;
      $udh = '';
      $hex_number = '';
      $transaction = Yii::app()->db->beginTransaction();

      try {

        if (!empty($no_tujuan)) {
          foreach ($no_tujuan as $i => $nomor) {

            $pesan = $_POST['Outbox']['TextDecoded'];
            $supplier = SupplierM::model()->findByPk($idSupplier[$nomor]);
            $attributes = $supplier->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $pesan = str_replace("{{" . $attributes . "}}", $value, $pesan);
            }
            $pesanArray = str_split(isset($pesan) ? $pesan : '', 153);
            $jumlah_part = count($pesanArray);

            $hex_number = $this->getRandomHex();
            foreach ($pesanArray as $j => $psn) {
              $udh = $hex_number . str_pad($jumlah_part, 2, "0", STR_PAD_LEFT) . str_pad($j + 1, 2, "0", STR_PAD_LEFT);
              if ($j == 0) {
                if (count($pesanArray) <= 1) {
                  $udh = '';
                }
                $model = new Outbox;
                $model->attributes = $_POST['Outbox'];
                $model->DestinationNumber = $nomor;
                $model->UDH = $udh;
                $model->TextDecoded = $psn;
                $model->MultiPart = ($jumlah_part > 1) ? 'true' : 'false';

                if ($model->save()) {
                  $id = $model->ID;
                }
              } else {
                $modMultiPart = new OutboxMultipart;
                $modMultiPart->UDH = $udh;
                $modMultiPart->TextDecoded = $psn;
                $modMultiPart->ID = $id;
                $modMultiPart->SequencePosition = $j + 1;
                $modMultiPart->save();
              }
            }

            $cekPbk = Pbk::model()->findByAttributes(array('Number' => $nomor));
            if (!isset($cekPbk->Number) && empty($cekPbk->Number)) {
              $modelPbk = new Pbk;
              $modelPbk->GroupID = Params::GROUP_SUPPLIER;
              $modelPbk->Name = $supplier->supplier_nama;
              $modelPbk->Number = $nomor;
              $modelPbk->save();
            }
          }

          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Pesan berhasil dikirim.');
          $transaction->commit();
        } else {
          Yii::app()->user->setFlash('success', 'Pesan tidak dikirim karena nomor tidak sesuai.');
          $transaction->rollback();
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Pesan gagal dikirim. " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'kirimsupplier', array(
      'model' => $model,
      'modSupplier' => $modSupplier
    ));
  }

  /**
   * Default menu sms gateway pelamar serta proses simpan transaksinya
   */
  public function actionPelamar()
  {
    $this->pageTitle = Yii::app()->name . " - Pelamar";
    $model = new Outbox;
    $modelPbk = new Pbk;
    $modPelamar = new PelamarT;
    $modPelamar->unsetAttributes();
    $model->CreatorID = $this->is_blast ? 'RSDrSoetomo' : Yii::app()->user->name;

    $modPelamar->tglmelamar = date('m/d/Y') . ' - ' . date('m/d/Y');
    if (isset($_GET['PelamarT'])) {
      $modPelamar->attributes = $_GET['PelamarT'];
      $modPelamar->nomor_valid = $_GET['PelamarT']['nomor_valid'];
      // var_dump($modPelamar->attributes, $_GET); die;
    }

    if (isset($_POST['Outbox'])) {
      $noHpPelamar = array();
      $idPelamar = array();

      foreach ($_POST['Pelamar'] as $i => $value) {
        $pelamar = PelamarT::model()->findByPk($i);
        if (!empty($pelamar->nomobile_pelamar) && $pelamar->nomobile_pelamar != "" && $pelamar->nomobile_pelamar != "-") {
          $noHpPelamar[] = $pelamar->nomobile_pelamar;
          $idPelamar[$pelamar->nomobile_pelamar] = $pelamar->pelamar_id;
        }
      }

      $no_tujuan = $noHpPelamar;

      if ($this->is_blast) {
        $this->kirimBlast($no_tujuan, $_POST['Outbox']['TextDecoded'], array('pelamar'));
      }

      $id = null;
      $udh = '';
      $hex_number = '';
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (!empty($no_tujuan)) {
          foreach ($no_tujuan as $i => $nomor) {

            $pesan = $_POST['Outbox']['TextDecoded'];
            $pelamar = PelamarT::model()->findByPk($idPelamar[$nomor]);
            $attributes = $pelamar->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $pesan = str_replace("{{" . $attributes . "}}", $value, $pesan);
            }
            $pesanArray = str_split(isset($pesan) ? $pesan : '', 153);
            $jumlah_part = count($pesanArray);

            $hex_number = $this->getRandomHex();
            foreach ($pesanArray as $j => $psn) {
              $udh = $hex_number . str_pad($jumlah_part, 2, "0", STR_PAD_LEFT) . str_pad($j + 1, 2, "0", STR_PAD_LEFT);
              if ($j == 0) {
                if (count($pesanArray) <= 1) {
                  $udh = '';
                }
                $model = new Outbox;
                $model->attributes = $_POST['Outbox'];
                $model->DestinationNumber = $nomor;
                $model->UDH = $udh;
                $model->TextDecoded = $psn;
                $model->MultiPart = ($jumlah_part > 1) ? 'true' : 'false';

                if ($model->save()) {
                  $id = $model->ID;
                }
              } else {
                $modMultiPart = new OutboxMultipart;
                $modMultiPart->UDH = $udh;
                $modMultiPart->TextDecoded = $psn;
                $modMultiPart->ID = $id;
                $modMultiPart->SequencePosition = $j + 1;
                $modMultiPart->save();
              }
            }

            $cekPbk = Pbk::model()->findByAttributes(array('Number' => $nomor));
            if (!isset($cekPbk->Number) && empty($cekPbk->Number)) {
              $modelPbk = new Pbk;
              $modelPbk->GroupID = Params::GROUP_PELAMAR;
              $modelPbk->Name = $pelamar->nama_pelamar;
              $modelPbk->Number = $nomor;
              $modelPbk->save();
            }
          }

          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Pesan berhasil dikirim.');
          $transaction->commit();
        } else {
          Yii::app()->user->setFlash('success', 'Pesan tidak dikirim karena nomor tidak sesuai.');
          $transaction->rollback();
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Pesan gagal dikirim. " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'kirimpelamar', array(
      'model' => $model,
      'modPelamar' => $modPelamar
    ));
  }

  /**
   * Proses pembuatan nomor Hex untuk gammu sms gateway
   * @return string $udh
   */
  public function getRandomHex()
  {
    /* $possibilities = array(1, 2, 3, 4, 5, 6, 7, 8, 9, "A", "B", "C", "D", "E", "F" );
          shuffle($possibilities);
          $hex = "";
          for($i=1;$i<=8;$i++){
          $hex .= $possibilities[rand(0,14)];
          }
          return $hex; */

    // Length of User Data Header, in this case 05
    $octet1 = '05';
    // Information Element Identifier, equal to 00 (Concatenated short messages, 8-bit reference number)
    $octet2 = '00';
    // Length of the header, excluding the first two fields; equal to 03
    $octet3 = '03';
    // CSMS reference number, must be same for all the SMS parts in the CSMS
    $octet4 = str_pad(dechex(rand(1, 9) . rand(1, 9)), 2, '0', STR_PAD_LEFT);

    $udhArray = array(
      $octet1, $octet2, $octet3, $octet4
    );
    $udh = implode('', $udhArray);
    return strtoupper($udh);
  }

  /**
   * Ubah nomor pasien
   * @param string $no_rekam_medik
   */
  public function actionUbahNomorPasien($no_rekam_medik)
  {
    $this->layout = '//layouts/iframe';
    $model = PasienM::model()->findByAttributes(array('no_rekam_medik' => $no_rekam_medik));
    if (isset($_POST['PasienM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $model->no_mobile_pasien = $_POST['PasienM']['no_mobile_pasien'];

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $transaction->commit();
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }
    $this->render($this->path_view . '_formUbahNoHpPeserta', array('model' => $model));
  }

  /**
   * Ubah nomor penjamin asuransi
   * @param integer $penjamin_id
   */
  public function actionUbahNomorAsuransi($penjamin_id)
  {
    $this->layout = '//layouts/iframe';
    $model = PenjaminpasienM::model()->findByPk($penjamin_id);
    if (isset($_POST['PenjaminpasienM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $model->penjamin_cp = $_POST['PenjaminpasienM']['penjamin_cp'];
      $model->penjamin_nomobile = $_POST['PenjaminpasienM']['penjamin_nomobile'];

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $transaction->commit();
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }
    $this->render($this->path_view . '_formUbahNoHpPenjamin', array('model' => $model));
  }

  /**
   * Ubah nomor supplier
   * @param integer $supplier_id
   */
  public function actionUbahNomorSupplier($supplier_id)
  {
    $this->layout = '//layouts/iframe';
    $model = SupplierM::model()->findByPk($supplier_id);
    if (isset($_POST['SupplierM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $model->supplier_cp = $_POST['SupplierM']['supplier_cp'];
      $model->supplier_cp_hp = $_POST['SupplierM']['supplier_cp_hp'];

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $transaction->commit();
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }
    $this->render($this->path_view . '_formUbahNoHpSupplier', array('model' => $model));
  }

  /**
   * Ubah nomor pegawai
   * @param integer $pegawai_id
   */
  public function actionUbahNomorPegawai($pegawai_id)
  {
    $this->layout = '//layouts/iframe';
    $model = PegawaiM::model()->findByPk($pegawai_id);
    if (isset($_POST['PegawaiM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $model->nomobile_pegawai = $_POST['PegawaiM']['nomobile_pegawai'];

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $transaction->commit();
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }
    $this->render($this->path_view . '_formUbahNoHpPegawai', array('model' => $model));
  }

  /**
   * Ubah nomor pelamar
   * @param integer $pelamar_id
   */
  public function actionUbahNomorPelamar($pelamar_id)
  {
    $this->layout = '//layouts/iframe';
    $model = PelamarT::model()->findByPk($pelamar_id);
    if (isset($_POST['PelamarT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $model->nomobile_pelamar = $_POST['PelamarT']['nomobile_pelamar'];

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $transaction->commit();
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }
    $this->render($this->path_view . '_formUbahNoHpPelamar', array('model' => $model));
  }

  /**
   * Proses select semua data pegawai dari grid
   */
  public function actionSelectAllPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $nomorindukpegawai = $_POST['nomorindukpegawai'];
      $nama_pegawai = $_POST['nama_pegawai'];
      $nomobile_pegawai = $_POST['nomobile_pegawai'];
      $jeniskelamin = $_POST['jeniskelamin'];
      $jabatan_id = $_POST['jabatan_id'];
      $kategoripegawai = $_POST['kategoripegawai'];
      $kelompokpegawai_id = $_POST['kelompokpegawai_id'];
      $nomor_valid = $_POST['nomor_valid'];
      $form = "";

      $criteria = new CDbCriteria;
      $criteria->select = "pegawai_id";
      $criteria->compare('LOWER(nomorindukpegawai)', strtolower($nomorindukpegawai), true);
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->compare('LOWER(nomobile_pegawai)', strtolower($nomobile_pegawai), true);
      $criteria->compare('LOWER(jeniskelamin)', strtolower($jeniskelamin), true);
      $criteria->compare('LOWER(kategoripegawai)', strtolower($kategoripegawai), true);
      if (!empty($jabatan_id)) {
        $criteria->addCondition('jabatan_id = ' . $jabatan_id);
      }
      if (!empty($kelompokpegawai_id)) {
        $criteria->addCondition('kelompokpegawai_id = ' . $kelompokpegawai_id);
      }
      if ($nomor_valid == 1) {
        $criteria->addCondition("length(nomobile_pegawai) >= 9 OR LEFT(nomobile_pegawai, 2) = '08' OR LEFT(nomobile_pegawai, 4) = '+628'");
      }

      $model = PegawaismscenterV::model()->findAll($criteria);

      foreach ($model as $value) {
        $form .= "<input id='Nomor_" . $value->pegawai_id . "' class='span1 Nomor' type='hidden' name='Nomor[]' value='" . $value->pegawai_id . "' readonly='readonly'>";
      }

      echo CJSON::encode($form);
    }
    Yii::app()->end();
  }

  /**
   * Proses select semua data pasien dari grid
   */
  public function actionSelectAllPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $no_rekam_medik = $_POST['no_rekam_medik'];
      $tgl_rekam_medik = $_POST['tgl_rekam_medik'];
      $nama_pasien = $_POST['nama_pasien'];
      $tanggal_lahir = $_POST['tanggal_lahir'];
      $alamat_pasien = $_POST['alamat_pasien'];
      $no_mobile_pasien = $_POST['no_mobile_pasien'];
      $jeniskelamin = $_POST['jeniskelamin'];
      $agama = $_POST['agama'];
      $kelompokumur_id = $_POST['kelompokumur_id'];
      $is_tgllahir = $_POST['is_tgllahir'];
      $pasien_ulang_tahun = $_POST['pasien_ulang_tahun'];
      $nomor_valid = $_POST['nomor_valid'];
      $form = "";

      $Tgl = (explode(" - ", $tgl_rekam_medik));

      //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
      $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
      $Tgl[0] = $Tgl[0]->format('Y-m-d');
      $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
      $Tgl[1] = $Tgl[1]->format('Y-m-d');

      $criteria = new CDbCriteria;
      $criteria->select = "no_rekam_medik";
      $criteria->addBetweenCondition('DATE(tgl_rekam_medik)', $Tgl[0], $Tgl[1]);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      if (!empty($alamat_pasien)) {
        $criteria->addCondition("alamat_pasien ILIKE '%" . $alamat_pasien . "%' OR propinsi_nama ILIKE '%" . $alamat_pasien . "%' OR kabupaten_nama ILIKE '%" . $alamat_pasien . "%' OR kecamatan_nama ILIKE '%" . $alamat_pasien . "%' OR kelurahan_nama ILIKE '%" . $alamat_pasien . "%'");
      }
      if ($is_tgllahir == 1) {
        $criteria->addBetweenCondition('DATE(tanggal_lahir)', $tanggal_lahir, $tanggal_lahir);
      }
      $criteria->compare('LOWER(no_mobile_pasien)', strtolower($no_mobile_pasien), true);
      $criteria->compare('LOWER(agama)', strtolower($agama), true);
      $criteria->compare('LOWER(jeniskelamin)', strtolower($jeniskelamin), true);

      if (!empty($kelompokumur_id)) {
        $criteria->addCondition('kelompokumur_id = ' . $kelompokumur_id);
      }
      if ($pasien_ulang_tahun == 1) {
        $criteria->addCondition("DATE_PART('DAY', tanggal_lahir) = DATE_PART('DAY', CURRENT_DATE) AND DATE_PART('MONTH', tanggal_lahir) = DATE_PART('MONTH', CURRENT_DATE)");
      }
      if ($nomor_valid == 1) {
        $criteria->addCondition("length(no_mobile_pasien) >= 9 OR LEFT(no_mobile_pasien, 2) = '08' OR LEFT(no_mobile_pasien, 4) = '+628'");
      }

      $model = PasiensmscenterV::model()->findAll($criteria);

      foreach ($model as $value) {
        $form .= "<input id='Nomor_" . $value->no_rekam_medik . "' class='span1 Nomor' type='hidden' name='Nomor[]' value='" . $value->no_rekam_medik . "' readonly='readonly'>";
      }

      echo CJSON::encode($form);
    }
    Yii::app()->end();
  }

  /**
   * Proses select semua data kunjungan pasien dari grid
   */
  public function actionSelectAllKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $no_rekam_medik = $_POST['no_rekam_medik'];
      $nama_pasien = $_POST['nama_pasien'];
      $no_pendaftaran = $_POST['no_pendaftaran'];
      $tgl_pendaftaran = $_POST['tgl_pendaftaran'];
      $alamat_pasien = $_POST['alamat_pasien'];
      $penjamin_nama = $_POST['penjamin_nama'];
      $ruangan_nama = $_POST['ruangan_nama'];
      $tglrenkontrol = $_POST['tglrenkontrol'];
      $no_mobile_pasien = $_POST['no_mobile_pasien'];
      $jeniskelamin = $_POST['jeniskelamin'];
      $kelompokumur_id = $_POST['kelompokumur_id'];
      $is_tglKontrol = $_POST['is_tglKontrol'];
      $nomor_valid = $_POST['nomor_valid'];
      $form = "";

      $tgl_kunjungan = $tgl_pendaftaran;
      $Tgl1 = (explode(" - ", $tgl_kunjungan));
      $tgl_kontrol = $tglrenkontrol;
      $Tgl2 = (explode(" - ", $tgl_kontrol));

      //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
      $Tgl1[0] = DateTime::createFromFormat('m/d/Y', $Tgl1[0]);
      $Tgl1[0] = $Tgl1[0]->format('Y-m-d');
      $Tgl1[1] = DateTime::createFromFormat('m/d/Y', $Tgl1[1]);
      $Tgl1[1] = $Tgl1[1]->format('Y-m-d');
      $Tgl2[0] = DateTime::createFromFormat('m/d/Y', $Tgl2[0]);
      $Tgl2[0] = $Tgl2[0]->format('Y-m-d');
      $Tgl2[1] = DateTime::createFromFormat('m/d/Y', $Tgl2[1]);
      $Tgl2[1] = $Tgl2[1]->format('Y-m-d');

      $criteria = new CDbCriteria;
      if ($is_tglKontrol == 0) {
        $criteria->addCondition("DATE(tgl_pendaftaran) BETWEEN '" . $Tgl1[0] . "' AND '" . $Tgl1[1] . "'");
      } else {
        $criteria->addCondition("DATE(tglrenkontrol) BETWEEN '" . $Tgl2[0] . "' AND '" . $Tgl2[1] . "'");
      }
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_mobile_pasien)', strtolower($no_mobile_pasien), true);
      $criteria->compare('LOWER(jeniskelamin)', strtolower($jeniskelamin), true);
      $criteria->addCondition('instalasi_id <> ' . Params::INSTALASI_ID_FARMASI);
      $criteria->addCondition('instalasi_id <> 1');
      if (!empty($alamat_pasien)) {
        $criteria->addCondition("alamat_pasien ILIKE '%" . $alamat_pasien . "%' OR propinsi_nama ILIKE '%" . $alamat_pasien . "%' OR kabupaten_nama ILIKE '%" . $alamat_pasien . "%' OR kecamatan_nama ILIKE '%" . $alamat_pasien . "%' OR kelurahan_nama ILIKE '%" . $alamat_pasien . "%'");
      }
      if (!empty($penjamin_nama)) {
        $criteria->addCondition("penjamin_nama ILIKE '%" . $penjamin_nama . "%' OR carabayar_nama ILIKE '%" . $penjamin_nama . "%'");
      }
      if (!empty($ruangan_nama)) {
        $criteria->addCondition("ruangan_nama ILIKE '%" . $ruangan_nama . "%' OR instalasi_nama ILIKE '%" . $ruangan_nama . "%'");
      }
      if (!empty($kelompokumur_id)) {
        $criteria->addCondition('kelompokumur_id = ' . $kelompokumur_id);
      }
      if ($nomor_valid == 1) {
        $criteria->addCondition("length(no_mobile_pasien) >= 9 OR LEFT(no_mobile_pasien, 2) = '08' OR LEFT(no_mobile_pasien, 4) = '+628'");
      }

      $model = PasienberkunjungsmscenterV::model()->findAll($criteria);

      foreach ($model as $value) {
        $form .= "<input id='Nomor_" . $value->no_rekam_medik . "' class='span1 Nomor' type='hidden' name='Nomor[]' value='" . $value->no_rekam_medik . "' readonly='readonly'>";
      }

      echo CJSON::encode($form);
    }
    Yii::app()->end();
  }

  /**
   * Proses select semua data kunjungan RI dari grid
   */
  public function actionSelectAllKunjunganRI()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $no_rekam_medik = $_POST['no_rekam_medik'];
      $nama_pasien = $_POST['nama_pasien'];
      $no_pendaftaran = $_POST['no_pendaftaran'];
      $tgladmisi = $_POST['tgladmisi'];
      $alamat_pasien = $_POST['alamat_pasien'];
      $penjamin_nama = $_POST['penjamin_nama'];
      $ruangan_nama = $_POST['ruangan_nama'];
      $tglpasienpulang = $_POST['tglpasienpulang'];
      $no_mobile_pasien = $_POST['no_mobile_pasien'];
      $jeniskelamin = $_POST['jeniskelamin'];
      $kelompokumur_id = $_POST['kelompokumur_id'];
      $is_tglPulang = $_POST['is_tglPulang'];
      $nomor_valid = $_POST['nomor_valid'];
      $form = "";

      $tgl_admisi = $tgladmisi;
      $Tgl1 = (explode(" - ", $tgl_admisi));
      $tgl_pulang = $tglpasienpulang;
      $Tgl2 = (explode(" - ", $tgl_pulang));

      //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
      $Tgl1[0] = DateTime::createFromFormat('m/d/Y', $Tgl1[0]);
      $Tgl1[0] = $Tgl1[0]->format('Y-m-d');
      $Tgl1[1] = DateTime::createFromFormat('m/d/Y', $Tgl1[1]);
      $Tgl1[1] = $Tgl1[1]->format('Y-m-d');
      $Tgl2[0] = DateTime::createFromFormat('m/d/Y', $Tgl2[0]);
      $Tgl2[0] = $Tgl2[0]->format('Y-m-d');
      $Tgl2[1] = DateTime::createFromFormat('m/d/Y', $Tgl2[1]);
      $Tgl2[1] = $Tgl2[1]->format('Y-m-d');

      $criteria = new CDbCriteria;
      if ($is_tglPulang == 0) {
        $criteria->addCondition("DATE(tgladmisi) BETWEEN '" . $Tgl1[0] . "' AND '" . $Tgl1[1] . "'");
      } else {
        $criteria->addCondition("DATE(tglpasienpulang) BETWEEN '" . $Tgl2[0] . "' AND '" . $Tgl2[1] . "'");
      }
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_mobile_pasien)', strtolower($no_mobile_pasien), true);
      $criteria->compare('LOWER(jeniskelamin)', strtolower($jeniskelamin), true);
      $criteria->addCondition('instalasi_id <> ' . Params::INSTALASI_ID_FARMASI);
      $criteria->addCondition('instalasi_id <> 1');
      if (!empty($alamat_pasien)) {
        $criteria->addCondition("alamat_pasien ILIKE '%" . $alamat_pasien . "%' OR propinsi_nama ILIKE '%" . $alamat_pasien . "%' OR kabupaten_nama ILIKE '%" . $alamat_pasien . "%' OR kecamatan_nama ILIKE '%" . $alamat_pasien . "%' OR kelurahan_nama ILIKE '%" . $alamat_pasien . "%'");
      }
      if (!empty($penjamin_nama)) {
        $criteria->addCondition("penjamin_nama ILIKE '%" . $penjamin_nama . "%' OR carabayar_nama ILIKE '%" . $penjamin_nama . "%'");
      }
      if (!empty($ruangan_nama)) {
        $criteria->addCondition("ruangan_nama ILIKE '%" . $ruangan_nama . "%' OR instalasi_nama ILIKE '%" . $ruangan_nama . "%'");
      }
      if (!empty($kelompokumur_id)) {
        $criteria->addCondition('kelompokumur_id = ' . $kelompokumur_id);
      }
      if ($nomor_valid == 1) {
        $criteria->addCondition("length(no_mobile_pasien) >= 9 OR LEFT(no_mobile_pasien, 2) = '08' OR LEFT(no_mobile_pasien, 4) = '+628'");
      }

      $model = PasienrawatinapsmscenterV::model()->findAll($criteria);

      foreach ($model as $value) {
        $form .= "<input id='Nomor_" . $value->no_rekam_medik . "' class='span1 Nomor' type='hidden' name='Nomor[]' value='" . $value->no_rekam_medik . "' readonly='readonly'>";
      }

      echo CJSON::encode($form);
    }
    Yii::app()->end();
  }

  /**
   * Proses select semua data penjamin dari grid
   */
  public function actionSelectAllPenjamin()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $penjamin_nama = $_POST['penjamin_nama'];
      $penjamin_cp = $_POST['penjamin_cp'];
      $penjamin_nomobile = $_POST['penjamin_nomobile'];
      $carabayar_id = $_POST['carabayar_id'];
      $nomor_valid = $_POST['nomor_valid'];

      $form = "";

      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(penjamin_nama)', strtolower($penjamin_nama), true);
      $criteria->compare('LOWER(penjamin_cp)', strtolower($penjamin_cp), true);
      $criteria->compare('LOWER(penjamin_nomobile)', strtolower($penjamin_nomobile), true);
      $criteria->compare('t.carabayar_id', $carabayar_id);
      $criteria->addCondition("penjamin_aktif IS TRUE");

      if ($nomor_valid == 1) {
        $criteria->addCondition("length(penjamin_nomobile) >= 9 OR LEFT(penjamin_nomobile, 2) = '08' OR LEFT(penjamin_nomobile, 4) = '+628'");
      }

      $model = PenjaminpasienM::model()->findAll($criteria);

      foreach ($model as $value) {
        $form .= "<input id='Nomor_" . $value->penjamin_id . "' class='span1 Nomor' type='hidden' name='Nomor[]' value='" . $value->penjamin_id . "' readonly='readonly'>";
      }

      echo CJSON::encode($form);
    }
    Yii::app()->end();
  }

  /**
   * Proses select semua data supplier dari grid
   */
  public function actionSelectAllSupplier()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $supplier_kode = $_POST['supplier_kode'];
      $supplier_nama = $_POST['supplier_nama'];
      $supplier_alamat = $_POST['supplier_alamat'];
      $supplier_propinsi = $_POST['supplier_propinsi'];
      $supplier_kabupaten = $_POST['supplier_kabupaten'];
      $supplier_cp = $_POST['supplier_cp'];
      $supplier_cp_hp = $_POST['supplier_cp_hp'];
      $nomor_valid = $_POST['nomor_valid'];

      $form = "";

      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(supplier_kode)', strtolower($supplier_kode), true);
      $criteria->compare('LOWER(supplier_nama)', strtolower($supplier_nama), true);
      $criteria->compare('LOWER(supplier_alamat)', strtolower($supplier_alamat), true);
      $criteria->compare('LOWER(supplier_propinsi)', strtolower($supplier_propinsi), true);
      $criteria->compare('LOWER(supplier_kabupaten)', strtolower($supplier_kabupaten), true);
      $criteria->compare('LOWER(supplier_cp)', strtolower($supplier_cp), true);
      $criteria->compare('LOWER(supplier_cp_hp)', strtolower($supplier_cp_hp), true);
      $criteria->addCondition('supplier_aktif IS TRUE');

      if ($nomor_valid == 1) {
        $criteria->addCondition("length(supplier_cp_hp) >= 9 OR LEFT(supplier_cp_hp, 2) = '08' OR LEFT(supplier_cp_hp, 4) = '+628'");
      }

      $model = SupplierM::model()->findAll($criteria);

      foreach ($model as $value) {
        $form .= "<input id='Nomor_" . $value->supplier_id . "' class='span1 Nomor' type='hidden' name='Nomor[]' value='" . $value->supplier_id . "' readonly='readonly'>";
      }

      echo CJSON::encode($form);
    }
    Yii::app()->end();
  }

  /**
   * Proses select semua data pelamar dari grid
   */
  public function actionSelectAllPelamar()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $tgllowongan = $_POST['tgllowongan'];
      $nama_pelamar = $_POST['nama_pelamar'];
      $tempatlahir_pelamar = $_POST['tempatlahir_pelamar'];
      $alamat_pelamar = $_POST['alamat_pelamar'];
      $nomobile_pelamar = $_POST['nomobile_pelamar'];
      $jeniskelamin = $_POST['jeniskelamin'];
      $statusperkawinan = $_POST['statusperkawinan'];
      $agama = $_POST['agama'];
      $nomor_valid = $_POST['nomor_valid'];

      $form = "";

      $criteria = new CDbCriteria;

      $tgl_lowongan = $tgllowongan;
      $Tgl = (explode(" - ", $tgl_lowongan));

      //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
      $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
      $Tgl[0] = $Tgl[0]->format('Y-m-d');
      $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
      $Tgl[1] = $Tgl[1]->format('Y-m-d');

      $criteria->addBetweenCondition('DATE(tgllowongan)', $Tgl[0], $Tgl[1]);
      $criteria->compare('LOWER(nama_pelamar)', strtolower($nama_pelamar), true);
      $criteria->compare('LOWER(tempatlahir_pelamar)', strtolower($tempatlahir_pelamar), true);
      $criteria->compare('LOWER(alamat_pelamar)', strtolower($alamat_pelamar), true);
      $criteria->compare('LOWER(nomobile_pelamar)', strtolower($nomobile_pelamar), true);
      $criteria->compare('LOWER(jeniskelamin)', strtolower($jeniskelamin), true);
      $criteria->compare('LOWER(agama)', strtolower($agama), true);

      if (!empty($statusperkawinan)) {
        $criteria->addCondition("statusperkawinan = '" . $statusperkawinan . "'");
      }
      if ($nomor_valid == 1) {
        $criteria->addCondition("length(nomobile_pelamar) >= 9 OR LEFT(nomobile_pelamar, 2) = '08' OR LEFT(nomobile_pelamar, 4) = '+628'");
      }

      $model = SupplierM::model()->findAll($criteria);

      foreach ($model as $value) {
        $form .= "<input id='Nomor_" . $value->supplier_id . "' class='span1 Nomor' type='hidden' name='Nomor[]' value='" . $value->supplier_id . "' readonly='readonly'>";
      }

      echo CJSON::encode($form);
    }
    Yii::app()->end();
  }
}
