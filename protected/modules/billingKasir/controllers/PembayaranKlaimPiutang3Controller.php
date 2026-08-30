
<?php

class PembayaranKlaimPiutang3Controller extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'billingKasir.views.pembayaranKlaimPiutang.';

  public function actionIndex()
  {
    $modPembayaranKlaim = new BKPembayaranklaimT;
    $modPembayaranKlaimDetail = new BKPembayarklaimdetailT;
    $modTandabukti = new TandabuktibayarT;
    $modPendaftaran = new BKPendaftaranT;
    $modPasien = new BKPasienM;
    $format = new MyFormatter();

    $modPendaftaran->tgl_awal = date('Y-m-d 00:00:00');
    $modPendaftaran->tgl_akhir = date('Y-m-d 23:59:59');

    $modPembayaranKlaim->tglpembayaranklaim = date('Y-m-d H:i:s');
    $modPembayaranKlaim->nopembayaranklaim = MyGenerator::noPembayaranKlaim();
    $modPembayaranKlaim->carabayar_id = 1;
    $modPembayaranKlaim->penjamin_id = 117;


    $modPembayaranPelayanan = new PembayaranpelayananT;
    $modPembayaranPelayanan->pembayaranpelayanan_id = 0;
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $modPembayaranKlaim = BKPembayaranklaimT::model()->find('pembayarklaim_id =' . $id . '');
      if (!empty($modPembayaranKlaim)) {
        $modPembayaranKLaimDetail->pembayarklaim_id = $modPembayaranKlaim->pembayarklaim_id;
        $modPembayaranKLaimDetail = BKPembayarklaimdetailT::model()->findAll('pembayarklaim_id = ' . $modPembayaranKlaim->pembayarklaim_id . ' and pembayaranpelayanan_id is not null');
        $modPembayaranPelayanan->pembayaranpelayanan_id = CHtml::listData($modDetailFormulir, 'pembayaranpelayanan_id', 'pembayaranpelayanan_id');
      }
    }

    if (isset($_POST['BKPembayaranklaimT'])) {
      $modPembayaranKlaim->attributes = $_POST['BKPembayaranklaimT'];
      if (count((array)$_POST['PembayaranpelayananT']) > 0) {
        $modPembayaranPelayanan->pembayaranpelayanan_id = $this->sortPilih($_POST['PembayaranpelayananT']);
        $modDetails = $this->validasiTabular($_POST['PembayaranpelayananT']);
      }
      if ($modPembayaranKlaim->validate()) {
        $modPembayaranKlaim->tglpembayaranklaim = trim($_POST['$modPembayaranKlaim']['tglpembayaranklaim']);
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $hasil = 0;
          if ($modPembayaranKlaim->save()) {
            if (count((array)$modDetails) > 0) {
              $jumlah = count((array)$modDetails);
              foreach ($modDetails as $i => $v) {
                $v->pembayarklaim_id = $modPembayaranKlaim->pembayarklaim_id;
                if ($v->save()) {
                  if (!empty($v->pembayaranpelayanan_id)) {
                    PembayaranpelayananT::model()->updateByPk($v->pembayaranpelayanan_id, array('pembklaimdetal_id' => $v->pembklaimdetal_id));
                  }
                  $hasil++;
                }
              }
            }
          }

          if (($hasil > 0) && ($hasil == $jumlah)) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
            $this->redirect($this->createUrl('Index', array('sukses' => 1)));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data Gagal Disimpan ");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', ' Data gagal disimpan.' . MyExceptionMessage::getMessage($ex, true));
        }
      }
    }

    if (isset($_GET['PembayaranpelayananT'])) {
      $modPembayaranpelayanan->unsetAttributes();
      $modPembayaranpelayanan->attributes = $_GET['PembayaranpelayananT'];
    }

    if ((isset($_GET['tgl_awal'])) && (isset($_GET['tgl_akhir'])) || (isset($_GET['carabayar_id'])) || (isset($_GET['penjamin_id'])) || (isset($_GET['pendaftaran_id']))) {
      if (Yii::app()->request->isAjaxRequest) {
        $tgl_awal  = $format->formatDateTimeForDb($_GET['tgl_awal']);
        $tgl_akhir = $format->formatDateTimeForDb($_GET['tgl_akhir']);
        $tr = $this->createList($tgl_awal, $tgl_akhir, true);
        echo $tr;
        Yii::app()->end();
      }
    }

    $this->render($this->path_view . 'index', array(
      'modPembayaranKlaim' => $modPembayaranKlaim,
      'modPembayaranKlaimDetail' => $modPembayaranKlaimDetail,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPembayaranPelayanan' => $modPembayaranPelayanan
    ));
  }

  protected function sortPilih($data)
  {
    $result = array();
    foreach ($data as $i => $row) {
      if ($row['cekList'] == 1) {
        $result[] = $row['pembayaranpelayanan_id'];
      }
    }

    return $result;
  }

  protected function validasiTabular($data)
  {
    foreach ($data as $i => $row) {
      $pembayaranpelayanan = PembayaranpelayananT::model()->findByPk($row['pembayaranpelayanan_id']);
      $modDetails[$i] = new BKPembayarklaimdetailT();
      $modDetails[$i]->attributes = $row;
      $modDetails[$i]->pendaftaran_id = $pembayaranpelayanan->pendaftaran_id;
      $modDetails[$i]->pasien_id = $pembayaranpelayanan->pasien_id;
      $modDetails[$i]->pembayarklaim_id = $_POST['BKPembayaranklaimT']['pembayaranklaim_id'];
      $modDetails[$i]->pembayaranpelayanan_id = $pembayaranpelayanan->pembayaranpelayanan_id;
      $modDetails[$i]->tandabuktibayar_id = $pembayaranpelayanan->tandabuktibayar_id;
      $modDetails[$i]->jmlpiutang = $modDetails[$i]->jmlpiutang;
      $modDetails[$i]->jumlahbayar = $modDetails[$i]->jmlbayar;
      $modDetails[$i]->jmltelahbayar = $modDetails[$i]->jmltelahbayar;
      $modDetails[$i]->jmlsisapiutang = $modDetails[$i]->jmlsisapiutang;
      $modDetails[$i]->validate();
    }
    return $modDetails;
  }

  protected function createList($tgl_awal, $tgl_akhir, $status = null)
  {
    $criteria = new CDbCriteria();
    $criteria->addBetweenCondition('tglpembayaran', $tgl_awal, $tgl_akhir);
    if ($status == true) {
      $criteria->addCondition('pembklaimdetal_id is null');
    }
    $pengeluaran = PembayaranpelayananT::model()->findAll($criteria);
    $tr = $this->rowPengeluaran($pengeluaran, $data['biayapelayanan'], $data['tr']);

    return $tr;
  }

  protected function rowPengeluaran($pengeluaran, $biayapelayanan, $tr, $text = null)
  {
    if (count((array)$pengeluaran) > 0) {
      foreach ($pengeluaran as $i => $row) {
        $i++;
        $totaltransaksi = count((array)$pengeluaran);
        $biayapelayanan += $row->totalbiayapelayanan;
        $tr .= '<tr >';
        $tr .= '<td>' . $i . '</td>';
        $tr .= '<td>' . $row->pasien->no_rekam_medik . "<br/>" . $row->pendaftaran->no_pendaftaran . '</td>';
        $tr .= '<td>' . $row->pasien->nama_pasien . '</td>';
        $tr .= '<td>' . $row->pasien->alamat_pasien . '</td>';
        $tr .= '<td>' . $row->pendaftaran->penanggungJawab->nama_pj . "-" . $row->pendaftaran->penanggungJawab->pengantar . '</td>';
        $tr .= '<td>' . $row->nopembayaran . '</td>';
        if ($text == true) {
          $tr .= '<td>' . number_format($row->totalbiayapelayanan) . '</td>';
          $tr .= '<td>' . number_format($row->totalsisatagihan) . '</td>';
          $tr .= '<td>' . number_format($row->uangditerima) . '</td>';
          $tr .= '<td>' . number_format($row->totalbayartindakan) . '</td>';
          $tr .= '<td>' . number_format($row->totalsisatagihan) . '</td>';
        } else {
          $tr .= '<td>' . CHtml::textField('jmltagihan', number_format($row->totalbiayapelayanan), array('style' => 'width:70px;', 'class' => 'inputFormTabel currency lebar3 jmltagihan', 'readonly' => true, 'onkeyup' => 'setAll()')) . '</td>';
          $tr .= '<td>' . CHtml::textField('jmlpiutang', number_format($row->totalbiayapelayanan), array('style' => 'width:70px;', 'class' => 'inputFormTabel currency lebar3 jmlpiutang', 'onkeyup' => 'setAll();')) . '</td>';
          $tr .= '<td>' . CHtml::textField('jmltelahbayar', '', array('style' => 'width:70px;', 'class' => 'inputFormTabel currency lebar3 jmltelahbayar', 'onkeyup' => 'setAll();')) . '</td>';
          $tr .= '<td>' . CHtml::textField('jmlbayar', '', array('style' => 'width:70px;', 'class' => 'inputFormTabel currency lebar3 jmlbayar', 'onkeyup' => 'hitungTotalBayar();')) . '</td>';
          $tr .= '<td>' . CHtml::textField('jmlsisatagihan', '', array('style' => 'width:70px;', 'class' => 'inputFormTabel currency lebar3 jmlsisatagihan', 'onkeyup' => 'setAll();')) . '</td>';

          $tr .= '<td>' . CHtml::checkBox('cekList[Terima][' . $row->pembayaranpelayanan_id . ']', false, array('value' => $row - pembayaranpelayanan_id, 'class' => 'cek', 'onClick' => 'setAll();')) .
            CHtml::hiddenField('pendaftaran_id', $row->pendaftaran_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  lebar3 ',)) .
            CHtml::hiddenField('pembayaranpelayanan_id', $row->pembayaranpelayanan_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  lebar3 ',)) . '</td>';
        }
        $tr .= '</tr>';
      }
    }
    return $tr;
  }

  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gfstokopname-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
}
