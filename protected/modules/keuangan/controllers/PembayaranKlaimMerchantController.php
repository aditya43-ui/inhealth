<?php
class PembayaranKlaimMerchantController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'Index';
  public $path_view = 'keuangan.views.pembayaranKlaimMerchant.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . ' - Transaksi Pembayaran Klaim Merchant';

    $modPembayaranKlaim = new KUPembayaranklaimT;
    $modPembayaranKlaimDetail = new KUPembayarklaimdetailT;
    $modTandabukti = new KUTandabuktibayarT;
    $modPembayaranPelayanan = new PembayaranpelayananT;
    $modPendaftaran = new KUPendaftaranT;
    $modPasien = new KUPasienM;
    $format = new MyFormatter();
    $modRekenings = array();

    $modTandabukti->tgl_awal = date('Y-m-d');
    $modTandabukti->tgl_akhir = date('Y-m-d');

    $modPembayaranKlaim->tglpembayaranklaim = date('Y-m-d H:i:s');
    $modPembayaranKlaim->nopembayaranklaim = "Otomatis";
    $modDetails = array();
    if (isset($_POST['KUPembayaranklaimT'])) {
      $modPembayaranKlaim->attributes = $_POST['KUPembayaranklaimT'];
      $modPembayaranKlaim->nopembayaranklaim = MyGenerator::noPembayaranKlaim();
      $modPembayaranKlaim->carabayar_id = 1;
      $modPembayaranKlaim->penjamin_id = 117;
      if (count((array)$_POST['KUPembayarklaimdetailT']) > 0) {
        $pembayaranpelayanan_id = $this->sortPilih($_POST['KUPembayarklaimdetailT']);
        $modDetails = $this->validasiTabular($modPembayaranKlaim, $_POST['KUPembayarklaimdetailT']);
      }
      if ($modPembayaranKlaim->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $success = true;
          if ($modPembayaranKlaim->save()) {
            $modDetails = $this->validasiTabular($modPembayaranKlaim, $_POST['KUPembayarklaimdetailT']);
            //                                $nourut =1;
            //                                foreach($_POST['RekeningpembayarankasirV'] AS $i => $post){
            $postRekenings = $_POST['KUPembayarklaimdetailT'];
            if (isset($postRekenings)) {
              $modJurnalRekening = $this->saveJurnalRekening();
              $saveDetailJurnal = $this->saveJurnalDetail($modJurnalRekening, $postRekenings, null, false);
              $nourut++;
            }
            //                                }

            foreach ($modDetails as $i => $data) {
              if ($data->tandabuktibayar_id > 0) {
                if ($data->save()) {
                  //                                                 PembayaranpelayananT::model()->updateByPk($data->pembayaranpelayanan_id, array('pembklaimdetal_id'=>$data->pembklaimdetal_id));
                  KUTandabuktibayarT::model()->updateByPk($data->tandabuktibayar_id, array('pembklaimdetail_id' => $data->pembklaimdetal_id));
                } else {
                  $success = false;
                }
                echo '<pre>';
                echo print_r($data->getErrors());
                echo '</pre>';
              }
            }
          }
          if ($success == true) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            $this->redirect(array('index', 'id' => $modPembayaranKlaim->pembayarklaim_id));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . $ex->getMessage());
        }
      } else {
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
      }
    }
    $tr = '';
    if ((isset($_GET['tgl_awal'])) && (isset($_GET['tgl_akhir']))) {
      if (Yii::app()->request->isAjaxRequest) {
        $tgl_awal  = $format->formatDateTimeForDB($_GET['tgl_awal']);
        $tgl_akhir = $format->formatDateTimeForDB($_GET['tgl_akhir']);
        //                $pembklaimdetal_id = $_GET['pembklaimdetal_id'];
        $bankkartu = $_GET['bankkartu'];
        $carabayar_id = isset($_GET['carabayar_id']) ? $_GET['carabayar_id'] : null;
        $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;

        $tr = $this->createList($tgl_awal, $tgl_akhir, $bankkartu, $carabayar_id, $penjamin_id, true);
        echo $tr;
        Yii::app()->end();
      }
    }

    $this->render($this->path_view . 'index', array(
      'modPembayaranKlaim' => $modPembayaranKlaim,
      'modPembayaranKlaimDetail' => $modPembayaranKlaimDetail,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPembayaranPelayanan' => $modPembayaranPelayanan,
      'tr' => $tr,
      'modDetails' => $modDetails,
      'modRekenings' => $modRekenings,
      'modTandabukti' => $modTandabukti,
      //                    'pembayaran'=>$pembayaran,
    ));
  }

  protected function rowPengeluaran($pengeluaran, $totaltransaksi, $tr, $text = null)
  {
    if (count((array)$pengeluaran) > 0) {
      foreach ($pengeluaran as $i => $row) {
        $i++;
        $totaltransaksi = count((array)$pengeluaran);
        $jumlahPiutang = 0;
        $biayapelayanan = 0;
        if (isset($row->pembayaranpelayanan_id)) {
          $biayapelayanan += $row->pembayaranpelayanan->totalbiayapelayanan;
          if (isset($row->pembayaranpelayanan->pendaftaran_id)) {
            if (isset($row->pembayaranpelayanan->pendaftaran->carabayar_id)) {
              if ($row->pembayaranpelayanan->pendaftaran->carabayar->issubsidiasuransi == true || $row->pembayaranpelayanan->pendaftaran->carabayar->issubsidipemerintah == true || $row->pembayaranpelayanan->pendaftaran->carabayar->issubsidirs == true) {
                $jumlahPiutang += $row->pembayaranpelayanan->totalsubsidiasuransi + $row->pembayaranpelayanan->totalsubsidipemerintah + $row->pembayaranpelayanan->totalsubsidirs;
              } else if ($row->pembayaranpelayanan->pendaftaran->carabayar->issubsidiasuransi == true) {
                $jumlahPiutang += $row->pembayaranpelayanan->totalsubsidiasuransi;
              } else if ($row->pembayaranpelayanan->pendaftaran->carabayar->issubsidipemerintah == true) {
                $jumlahPiutang += $row->pembayaranpelayanan->totalsubsidipemerintah;
              } else if ($row->pembayaranpelayanan->pendaftaran->carabayar->issubsidirs == true) {
                $jumlahPiutang += $row->pembayaranpelayanan->totalsubsidirs;
              }
            } else {
              $jumlahPiutang += 0;
            }
          } else {
            $jumlahPiutang += 0;
          }
        } else {
          $biayapelayanan += 0;
          $jumlahPiutang += 0;
        }
        $tr .= '<tr >';
        $tr .= '<td>' . $i . '</td>';
        if (isset($row->pembayaranpelayanan_id)) {
          if (isset($row->pembayaranpelayanan->pasien_id)) {
            if (isset($row->pembayaranpelayanan->pendaftaran_id)) {
              $tr .= '<td>' . $row->pembayaranpelayanan->pasien->no_rekam_medik . "<br/>" . $row->pembayaranpelayanan->pendaftaran->no_pendaftaran . '</td>';
              $tr .= '<td>' . $row->pembayaranpelayanan->pasien->nama_pasien .
                CHtml::hiddenField('KUPembayarklaimdetailT[' . $i . '][pasien_id]', $row->pembayaranpelayanan->pasien_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3')) .
                '</td>';
              $tr .= '<td>' . $row->pembayaranpelayanan->pasien->alamat_pasien . '</td>';
              if (isset($row->pembayaranpelayanan->pendaftaran->penanggungjawab_id)) {
                $tr .= '<td>' . $row->pembayaranpelayanan->pendaftaran->penanggungJawab->nama_pj . "-" . $row->pembayaranpelayanan->pendaftaran->penanggungJawab->pengantar . '</td>';
              } else {
                $tr .= '<td> - </td>';
              }
              $tr .= '<td>' . $row->pembayaranpelayanan->nopembayaran . '</td>';
            } else {
              $tr .= '<td>' . $row->pembayaranpelayanan->pasien->no_rekam_medik . "<br/>" . ' - </td>';
              $tr .= '<td>' . $row->pembayaranpelayanan->pasien->nama_pasien .
                CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][pasien_id]', $row->pembayaranpelayanan->pasien_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3')) .
                '</td>';
              $tr .= '<td>' . $row->pembayaranpelayanan->pasien->alamat_pasien . '</td>';
              $tr .= '<td> - </td>';
              $tr .= '<td>' . $row->pembayaranpelayanan->nopembayaran . '</td>';
            }
          } else {
            $tr .= '<td> - ' . "<br/>" . ' - </td>';
            $tr .= '<td> - </td>';
            $tr .= '<td> - </td>';
            $tr .= '<td> - </td>';
            $tr .= '<td> - </td>';
          }
        } else {
          $tr .= '<td> - ' . "<br/>" . ' - </td>';
          $tr .= '<td> - </td>';
          $tr .= '<td> - </td>';
          $tr .= '<td> - </td>';
          $tr .= '<td> - </td>';
        }

        if ($text == true) {
          $tr .= (isset($row->pembayaranpelayanan_id) ? '<td>' . MyFormatter::formatNumberForPrint($row->pembayaranpelayanan->totalbiayapelayanan) . '</td>' : '<td> 0 </td>');
          $tr .= (isset($row->pembayaranpelayanan_id) ? '<td>' . MyFormatter::formatNumberForPrint($row->pembayaranpelayanan->totalsisatagihan) . '</td>' : '<td> 0 </td>');
          $tr .= '<td>' . MyFormatter::formatNumberForPrint($row->uangditerima) . '</td>';
          $tr .= (isset($row->pembayaranpelayanan_id) ? '<td>' . MyFormatter::formatNumberForPrint($row->pembayaranpelayanan->totalbayartindakan) . '</td>' : '<td> 0 </td>');
          $tr .= (isset($row->pembayaranpelayanan_id) ? '<td>' . MyFormatter::formatNumberForPrint($row->pembayaranpelayanan->totalsisatagihan) . '</td>' : '<td> 0 </td>');
        } else {
          $tr .= (isset($row->pembayaranpelayanan_id) ? '<td>' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmltagihan]', MyFormatter::formatNumberForPrint($row->pembayaranpelayanan->totalbiayapelayanan), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmltagihan integer2', 'readonly' => false, 'onkeyup' => 'hitungSemuaTransaksi()')) . '</td>' : '<td> ' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmltagihan]', 0, array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmltagihan integer2', 'readonly' => true)) . ' </td>');
          if (isset($row->pembayaranpelayanan_id)) {
            if (isset($row->pembayaranpelayanan->pembklaimdetal_id)) {
              $tr .= '<td>' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmlpiutang]', (empty($row->pembayaranpelayanan->pembklaimdetal_id) ? MyFormatter::formatNumberForPrint($jumlahPiutang) : MyFormatter::formatNumberForPrint($row->pembayaranpelayanan->detailklaim->jmlpiutang)), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlpiutang integer2 ', 'onkeyup' => 'hitungJumlahPiutang(this);')) .
                CHtml::hiddenField('KUPembayarklaimdetailT[' . $i . '][jmlpiutang2]', (empty($row->pembayaranpelayanan->pembklaimdetal_id) ? MyFormatter::formatNumberForPrint($row->pembayaranpelayanan->totalsisatagihan) : MyFormatter::formatNumberForPrint($row->pembayaranpelayanan->detailklaim->jmlpiutang)), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlpiutang2 integer2')) .
                '</td>';
              if (isset($row->pembayaranpelayanan->tandabuktibayar_id)) {
                if (isset($row->pembayaranpelayanan->pembklaimdetal_id)) {
                  $tr .= '<td>' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmltelahbayar]', (empty($row->pembayaranpelayanan->pembklaimdetal_id) ? (empty($row->pembayaranpelayanan->detailklaim->telahbayar) ? "0" : MyFormatter::formatNumberForPrint($row->pembayaranpelayanan->tandabukti->jmlpembayaran)) : MyFormatter::formatNumberForPrint($row->pembayaranpelayanan->detailklaim->jmltelahbayar)), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmltelahbayar integer2 ', 'onkeyup' => 'hitungJumlahTelahBayar();')) . '</td>';
                  $tr .= '<td>' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmlbayar]', (empty($row->pembayaranpelayanan->pembklaimdetal_id) ? MyFormatter::formatNumberForPrint($row->pembayaranpelayanan->tandabukti->jmlpembayaran) : MyFormatter::formatNumberForPrint($row->pembayaranpelayanan->detailklaim->jmlpiutang - $row->pembayaranpelayanan->detailklaim->jmltelahbayar)), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlbayar integer2 ', 'onkeyup' => 'hitungSisaTagihan();')) . '</td>';
                  $tr .= '<td>' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmlsisatagihan]', (empty($row->pembayaranpelayanan->pembklaimdetal_id) ? (empty($row->pembayaranpelayanan->detailklaim->jmlsisapiutang) ? "0" : MyFormatter::formatNumberForPrint($row->pembayaranpelayanan->totalbiayapelayanan - $row->pembayaranpelayanan->tandabukti->jmlpembayaran)) : MyFormatter::formatNumberForPrint($row->pembayaranpelayanan->detailklaim->jmlpiutang - ($row->pembayaranpelayanan->detailklaim->jmltelahbayar + ($row->pembayaranpelayanan->detailklaim->jmlpiutang - $row->pembayaranpelayanan->detailklaim->jmltelahbayar)))), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlsisatagihan integer2 ', 'onkeyup' => 'hitungSemuaTransaksi();')) . '</td>';
                } else {
                  $tr .= '<td> ' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmltelahbayar]', 0, array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmltelahbayar integer2', 'readonly' => true)) . ' </td>';
                  $tr .= '<td> ' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmlbayar]', 0, array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlbayar integer2', 'readonly' => true)) . ' </td>';
                  $tr .= '<td> ' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmlsisatagihan]', 0, array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlsisatagihan integer2', 'readonly' => true)) . ' </td>';
                }
              } else {
                $tr .= '<td> ' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmltelahbayar]', 0, array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmltelahbayar integer2', 'readonly' => true)) . ' </td>';
                $tr .= '<td> ' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmlbayar]', 0, array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlbayar integer2', 'readonly' => true)) . ' </td>';
                $tr .= '<td> ' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmlsisatagihan]', 0, array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlsisatagihan integer2', 'readonly' => true)) . ' </td>';
              }
            } else {
              $tr .= '<td> ' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmlpiutang]', 0, array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlpiutang integer2', 'readonly' => true)) . ' </td>';
              $tr .= '<td> ' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmltelahbayar]', 0, array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmltelahbayar integer2', 'readonly' => true)) . ' </td>';
              $tr .= '<td> ' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmlbayar]', 0, array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlbayar integer2', 'readonly' => true)) . ' </td>';
              $tr .= '<td> ' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmlsisatagihan]', 0, array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlsisatagihan integer2', 'readonly' => true)) . ' </td>';
            }
          } else {
            $tr .= '<td> ' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmlpiutang]', 0, array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlpiutang integer2', 'readonly' => true)) . ' </td>';
            $tr .= '<td> ' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmltelahbayar]', 0, array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmltelahbayar integer2', 'readonly' => true)) . ' </td>';
            $tr .= '<td> ' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmlbayar]', 0, array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlbayar integer2', 'readonly' => true)) . ' </td>';
            $tr .= '<td> ' . CHtml::textField('KUPembayarklaimdetailT[' . $i . '][jmlsisatagihan]', 0, array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlsisatagihan integer2', 'readonly' => true)) . ' </td>';
          }
          if (isset($row->pembayaranpelayanan_id)) {
            $tr .= '<td>' . CHtml::checkBox('KUPembayarklaimdetailT[' . $i . '][cekList]', true, array('value' => $row->pembayaranpelayanan_id, 'class' => 'cek', 'onClick' => 'setAll();')) .
              CHtml::hiddenField('KUPembayarklaimdetailT[' . $i . '][pendaftaran_id]', $row->pembayaranpelayanan->pendaftaran_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel currency span3 jmlsisatagihan',)) .
              CHtml::hiddenField('KUPembayarklaimdetailT[' . $i . '][pasien_id]', $row->pembayaranpelayanan->pasien_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel currency span3 jmlsisatagihan',)) .
              CHtml::hiddenField('KUPembayarklaimdetailT[' . $i . '][pembayaranpelayanan_id]', $row->pembayaranpelayanan_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3 ')) .
              CHtml::hiddenField('KUPembayarklaimdetailT[' . $i . '][tandabuktibayar_id]', $row->pembayaranpelayanan->tandabuktibayar_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3')) .
              CHtml::hiddenField('KUPembayarklaimdetailT[' . $i . '][carabayar_id]', $row->pembayaranpelayanan->carabayar_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3')) .
              CHtml::hiddenField('KUPembayarklaimdetailT[' . $i . '][penjamin_id]', $row->pembayaranpelayanan->penjamin_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3')) .
              '</td>';
          }
        }
        $tr .= '</tr>';
      }
    }
    return $tr;
  }

  protected function createList($tglAwal, $tglAkhir, $bankkartu, $carabayar, $penjamin, $status = null)
  {
    $criteria = new CDbCriteria();
    $criteria->join = 'JOIN pembayaranpelayanan_t ON pembayaranpelayanan_t.pembayaranpelayanan_id = t.pembayaranpelayanan_id
        JOIN carabayar_m ON carabayar_m.carabayar_id = pembayaranpelayanan_t.carabayar_id
        ';

    if (!empty($this->pembayaranpelayanan_id)) {
      $criteria->addCondition('t.pembayaranpelayanan_id = ' . $this->pembayaranpelayanan_id);
    }
    if (!empty($carabayar)) {
      $criteria->addCondition('pembayaranpelayanan_t.carabayar_id = ' . $carabayar);
    }
    $criteria->addBetweenCondition('t.tglbuktibayar::date', MyFormatter::formatDateTimeForDb($tglAwal), MyFormatter::formatDateTimeForDb($tglAkhir));
    $criteria->compare('LOWER(t.bankkartu)', strtolower($bankkartu));


    //var_dump($criteria);

    $pengeluaran = KUTandabuktibayarT::model()->findAll($criteria);

    //var_dump(count((array)$pengeluaran)); die;

    $tr = $this->rowPengeluaran($pengeluaran, isset($data['totaltransaksi']) ? $data['totaltransaksi'] : null, isset($data['tr']) ? $data['tr'] : null);

    return $tr;
  }

  protected function sortPilih($data)
  {
    $result = array();
    foreach ($data as $i => $row) {
      if (isset($row['cekList']) == 1) {
        $result[] = $row['tandabuktibayar_id'];
      }
    }

    return $result;
  }


  protected function validasiTabular($modPembayaranKlaim, $data)
  {
    foreach ($data as $i => $row) {
      if (isset($row['cekList']) == 1) {

        $modDetails[$i] = new KUPembayarklaimdetailT();
        $modDetails[$i]->attributes = $row;
        $modDetails[$i]->pendaftaran_id = $row['pendaftaran_id'];
        $modDetails[$i]->pasien_id = $row['pasien_id'];
        $modDetails[$i]->pembayarklaim_id = $modPembayaranKlaim->pembayarklaim_id;
        $modDetails[$i]->pembayaranpelayanan_id = $row['pembayaranpelayanan_id'];
        $modDetails[$i]->tandabuktibayar_id = $row['tandabuktibayar_id'];
        //                $modDetails[$i]->jmlpiutang = $row['jmlpiutang']-$row['jmlbayar'];
        //                $modDetails[$i]->jumlahbayar = $row['jmlbayar'];
        //                $modDetails[$i]->jmltelahbayar = $row['jmlbayar'];
        $modDetails[$i]->jmlsisapiutang = $row['jmlsisatagihan'];
        $modDetails[$i]->validate();
      }
    }

    return $modDetails;
  }

  /**
   * simpan jurnaldetail_t dan jurnalposting_t digunakan di:
   * - akuntansi/pembayaranKlaimMerchant
   */
  public function saveJurnalDetail($modJurnalRekening, $postRekenings, $noUrut = 0, $isPosting = false)
  {
    //        $modJurnalPosting = null;
    //        if($isPosting == true){
    //            $modJurnalPosting = new JurnalpostingT;
    //            $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
    //            $modJurnalPosting->keterangan = "Posting automatis";
    //            $modJurnalPosting->create_time = date('Y-m-d H:i:s');
    //            $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
    //            $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //            if($modJurnalPosting->validate()){
    //                $modJurnalPosting->save();
    //            }
    //        }

    foreach ($postRekenings as $i => $post) {
      $modJurnalDetail[$i] = new JurnaldetailT();
      //            $modJurnalDetail[$i]->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
      $modJurnalDetail[$i]->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $modJurnalDetail[$i]->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      $modJurnalDetail[$i]->uraiantransaksi = isset($post['nama_rekening']) ? $post['nama_rekening'] : null;
      $modJurnalDetail[$i]->saldodebit = isset($post['saldodebit']) ? $post['saldodebit'] : null;
      $modJurnalDetail[$i]->saldokredit = isset($post['saldokredit']) ? $post['saldokredit'] : null;
      $modJurnalDetail[$i]->nourut = $i + 1;
      // $modJurnalDetail[$i]->rekening1_id = isset($post['struktur_id']) ? $post['struktur_id'] : null;
      // $modJurnalDetail[$i]->rekening2_id = isset($post['kelompok_id']) ? $post['kelompok_id'] : null;
      // $modJurnalDetail[$i]->rekening3_id = isset($post['jenis_id']) ? $post['jenis_id'] : null;
      // $modJurnalDetail[$i]->rekening4_id = isset($post['obyek_id']) ? $post['obyek_id'] : null;
      $modJurnalDetail[$i]->rekening5_id = isset($post['rincianobyek_id']) ? $post['rincianobyek_id'] : null;
      $modJurnalDetail[$i]->catatan = "";

      // Sedang dikerjakan di LNG-1176 (menunggu konfirmasi)
      echo "<pre>";
      echo ".:: Sedang dikerjakan di LNG-1176 (menunggu konfirmasi) ::. <br><br>";
      print_r($post);
      $modJurnalDetail[$i]->validate();
      echo CHtml::errorSummary($modJurnalDetail[$i]);
      print_r($modJurnalDetail[$i]->attributes);
      print_r($modJurnalDetail[$i]->validate());
      exit;

      if ($modJurnalDetail[$i]->validate()) {
        $modJurnalDetail[$i]->save();
      }
    }
    return $modJurnalDetail;
  }

  /**
   * simpan jurnalrekening_t
   * @return \JurnalrekeningT
   */
  public function saveJurnalRekening()
  {
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = date('Y-m-d H:i:s');
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = 0;
    $modJurnalRekening->tglreferensi = date('Y-m-d H:i:s');
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = "";
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
    $modJurnalRekening->rekperiod_id = RekperiodM::model()->findByAttributes(array('isclosing' => false))->rekperiod_id;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
    } else {
      $modJurnalRekening['errorMsg'] = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function actionGetPenjaminPasien($encode = false, $namaModel = '')
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
