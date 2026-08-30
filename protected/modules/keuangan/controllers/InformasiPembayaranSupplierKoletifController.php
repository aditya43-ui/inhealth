<?php
class InformasiPembayaranSupplierKoletifController extends MyAuthController
{
  protected $successSave = true;
  protected $pesan = "succes";
  protected $path_view = "keuangan.views.informasiPembayaranSupplierKolektif.";

  public function actionIndex()
  {
    $model = new KUInformasipembayaransupplierkolektifV();
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->tglnyetor_awal = date('Y-m-d');
    $model->tglnyetor_akhir = date('Y-m-d');
    $model->ceklis = false;

    if (isset($_GET['KUInformasipembayaransupplierkolektifV'])) {
      $model->attributes = $_GET['KUInformasipembayaransupplierkolektifV'];
      $model->ceklis = $_GET['KUInformasipembayaransupplierkolektifV']['ceklis'];
      $model->status_penyetoran = $_GET['KUInformasipembayaransupplierkolektifV']['status_penyetoran'];
      $model->status_pembatalan = $_GET['KUInformasipembayaransupplierkolektifV']['status_pembatalan'];
      $model->tgl_awal = $format->formatDateTimeForDB($_GET['KUInformasipembayaransupplierkolektifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDB($_GET['KUInformasipembayaransupplierkolektifV']['tgl_akhir']);
      $model->tglnyetor_awal = $format->formatDateTimeForDB($_GET['KUInformasipembayaransupplierkolektifV']['tglnyetor_awal']);
      $model->tglnyetor_akhir = $format->formatDateTimeForDB($_GET['KUInformasipembayaransupplierkolektifV']['tglnyetor_akhir']);
    }

    $this->render($this->path_view . 'index', array('model' => $model));
  }

  public function actionRincian($tandabuktikeluar_id)
  {
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    if (isset($_GET['caraPrint']) && ($_GET['caraPrint'] == "PRINT")) {
      $this->layout = '//layouts/printWindows';
    } else {
      $this->layout = '//layouts/iframe';
    }

    $totaltagihan = 0;
    $totalsisahutang = 0;
    $jmlpembayaran = 0;
    $detailPembayaran = array();
    $supplier = "";
    $jenisupplier = "";

    $modBuktiKeluar = TandabuktikeluarT::model()->findByPk($tandabuktikeluar_id);
    $modDetail = BayarkesupplierT::model()->findAllByAttributes(array('tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id));
    // $model = SetoranpajakT::model()->findAllByAttributes(array('tandabuktikeluar_id'=>$modBuktiKeluar->tandabuktikeluar_id));
    //
    if (count((array)$modDetail) > 0) {
      foreach ($modDetail as $dataSetor) {

        $criteria = new CDbCriteria();
        if (!empty($dataSetor->terimapersediaan_id)) {
          $criteria->addCondition('faktur_id = ' . $dataSetor->terimapersediaan_id);
          $criteria->addCondition("typefaktur = 'barang'");
        }

        if (!empty($dataSetor->fakturpembelian_id)) {
          $criteria->addCondition('faktur_id = ' . $dataSetor->fakturpembelian_id);
          $criteria->addCondition("typefaktur = 'obatalkes'");
        }

        if (!empty($dataSetor->terimabahanmakan_id)) {
          $criteria->addCondition('faktur_id = ' . $dataSetor->terimabahanmakan_id);
          $criteria->addCondition("typefaktur = 'gizi'");
        }
        $criteria->limit = 1;
        $modFakur = FakturpembeliantopembayaranV::model()->find($criteria);
        $pemby = array();
        $pemby['nofaktur'] = "-";
        $pemby['tglfaktur'] = "-";
        $pemby['tgljatuhtempo'] = "-";
        $pemby['instalasi'] = "-";
        $pemby['ruangan'] = "-";
        if (isset($modFakur)) {
          $pemby['nofaktur'] = $modFakur->nofaktur;
          $pemby['tglfaktur'] = MyFormatter::formatDateTimeForUser($modFakur->tglfaktur);
          $pemby['tgljatuhtempo'] = (!empty($modFakur->tgljatuhtempo) ? MyFormatter::formatDateTimeForUser($modFakur->tgljatuhtempo) : "-");
          $pemby['instalasi'] = $modFakur->instalasi_nama;
          $pemby['ruangan'] = $modFakur->ruangan_nama;
          $supplierMod = SupplierM::model()->findByPk($modFakur->supplier_id);

          if (isset($supplierMod)) {
            $supplier = $supplierMod->supplier_nama;
            $jenisupplier = $supplierMod->supplier_jenis;
          }
        }
        $pemby['totaltagihan'] = $dataSetor->totaltagihan;
        $pemby['totalsisatagihan'] = $dataSetor->totalsisatagihan;
        $pemby['jmldibayarkan'] = $dataSetor->jmldibayarkan;
        $pemby['keterangan'] = $dataSetor->keterangan;
        $totaltagihan += $dataSetor->totaltagihan;
        $totalsisahutang += $dataSetor->totalsisatagihan;
        $jmlpembayaran += $dataSetor->jmldibayarkan;
        $tglsetoran = MyFormatter::formatDateTimeForUser($dataSetor->tglbayarkesupplier);
        $detailPembayaran[] = $pemby;
      }
    }


    $this->render($this->path_view . '_rincian', array(
      'caraPrint' => $caraPrint,
      'modBuktiKeluar' => $modBuktiKeluar,
      'totaltagihan' => $totaltagihan,
      'totalsisahutang' => $totalsisahutang,
      'jmlpembayaran' => $jmlpembayaran,
      'detailPembayaran' => $detailPembayaran,
      'tglsetoran' => $tglsetoran,
      'supplier' => $supplier,
      'jenisupplier' => $jenisupplier

    ));
  }

  public function actionAutocompleteMasterSupplier($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $criteria = new CDbCriteria;
    $criteria->compare('lower(supplier_nama)', strtolower($term), true);
    $criteria->addCondition('supplier_aktif = true');
    $criteria->order = 'supplier_nama';
    $criteria->limit = 10;

    $model = SupplierM::model()->findAll($criteria);
    $res = array();

    foreach ($model as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->supplier_nama;
      $sub['value'] = $item->supplier_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }
}
