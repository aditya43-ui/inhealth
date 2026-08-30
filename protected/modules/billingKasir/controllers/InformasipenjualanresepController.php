<?php

class InformasipenjualanresepController extends MyAuthController
{
  protected $pathViewPrint = 'farmasiApotek.views.penjualanResep.PrintBebasLuar';

  public function actionInformasijualresep()
  {
    $this->pageTitle = Yii::app()->name . " - Penjualan Obat Alkes";
    // $this->layout = '//layouts/column1';
    $model = new BKPenjualanresepT();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->ceklis = false;
    $model->tgl_awall = date('Y-m-d');
    $model->tgl_akhirl = date('Y-m-d');

    if (isset($_GET['BKPenjualanresepT'])) {
      $format = new MyFormatter();
      $model->attributes = $_GET['BKPenjualanresepT'];
      $model->no_identitas_pasien = $_GET['BKPenjualanresepT']['no_identitas_pasien'];
      $model->nama_pasien = $_GET['BKPenjualanresepT']['nama_pasien'];
      $model->tgl_awal = isset($_REQUEST['BKPenjualanresepT']['tgl_awal']) ? $format->formatDateTimeForDb($_REQUEST['BKPenjualanresepT']['tgl_awal']) : '';
      $model->tgl_akhir = isset($_REQUEST['BKPenjualanresepT']['tgl_akhir']) ? $format->formatDateTimeForDb($_REQUEST['BKPenjualanresepT']['tgl_akhir']) : '';
      $model->tgl_awall  =isset($_REQUEST['BKPenjualanresepT']['tgl_awall'])? $format->formatDateTimeForDb($_REQUEST['BKPenjualanresepT']['tgl_awall']) : '';
      $model->tgl_akhirl = isset($_REQUEST['BKPenjualanresepT']['tgl_akhirl'])? $format->formatDateTimeForDb($_REQUEST['BKPenjualanresepT']['tgl_akhirl']) : '';
      $model->ceklis = $_GET['BKPenjualanresepT']['ceklis'];
    }

    $this->render('informasijualresep', array('model' => $model));
  }

  public function actionDetailResep($id)
  {
    $this->layout = '//layouts/iframe';
    $modPenjualan = BKPenjualanresepT::model()->find('penjualanresep_id = ' . $id . '');
    $obatAlkes = BKObatalkesPasienT::model()->findAll('penjualanresep_id = ' . $modPenjualan->penjualanresep_id . ' ');
    $daftar = BKPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $obatAlkes[0]->pendaftaran_id));
    $pasien = BKPasienM::model()->findByAttributes(array('pasien_id' => $obatAlkes[0]->pasien_id));

    $judulLaporan = 'Laporan Penerimaan Kas';
    $this->render('PrintBebasLuar', array('modPenjualan' => $modPenjualan, 'daftar' => $daftar, 'pasien' => $pasien, 'obatAlkes' => $obatAlkes, 'judulLaporan' => $judulLaporan));
  }
  /**
   * actionFakturPembayaranApotek digunakan untuk print faktur kasir apotek bebas / resep luar / pegawai / dokter / unit
   * @param type $penjualanresep_id
   * @param type $tandabuktibayar_id
   */
  public function actionFakturPembayaranApotek($penjualanresep_id, $tandabuktibayar_id = null, $caraPrint=null){
    $this->layout = '//layouts/iframe';
    $modPenjualan = PenjualanresepT::model()->findByPk($penjualanresep_id);
    $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$modPenjualan->pendaftaran_id));
    $obatAlkes = ObatalkespasienT::model()->findAllByAttributes(array('penjualanresep_id'=>$penjualanresep_id));
    $pasien = PasienM::model()->findByPk($modPenjualan->pasien_id);
    $modPegawaiDokter = new PegawaikaryawanV();
    $modInstalasi = new InstalasiM();
    $modPenanggungjawab = array();
    // var_dump($obatAlkes);die;
    if(!empty($modPendaftaran->pembayaranpelayanan_id)){
      $modPembayaran = PembayaranpelayananT::model()->findByPk($modPendaftaran->pembayaranpelayanan_id);
      if (count((array)$modPembayaran)>0){
        foreach ($modPembayaran as $mod => $items){
            // $nopembayaran = $items->nopembayaran;
        }
    }
    }else{
      $modPembayaran = new PembayaranpelayananT();
    }
    
        // var_dump($modRincians);die;
        
      // var_dump($obatAlkes);die;
    $penjamin = array();
    if (!empty($modPendaftaran->penanggungjawab_id)){
      $modPenanggungjawab=PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    }
    
    if(!empty($modPenjualan->pasienpegawai_id))
        $modPegawaiDokter = PegawaikaryawanV::model()->findByAttributes(array('pegawai_id'=>$modPenjualan->pasienpegawai_id));
    if(!empty($modPenjualan->pasieninstalasiunit_id))
        $modInstalasi = InstalasiM::model()->findByAttributes(array('instalasi_id'=>$modPenjualan->pasieninstalasiunit_id));
    $criteria = new CDbCriteria;
    if(!empty($tandabuktibayar_id)){
            $criteria->addCondition("t.tandabuktibayar_id = ".$tandabuktibayar_id);					
            $tandabukti = TandabuktibayarT::model()->with('pembayaranpelayanan')->find($criteria);
    }
    else {
        $tandabukti = new TandabuktibayarT;
        $tandabukti->pembayaranpelayanan = new PembayaranpelayananT;
    }
    // if(!empty($pasien->penjamin_id)){
    //   $penjamin = PenjaminpasienM::model()->findByPk($pasien->penjamin_id);
    //   $penjamin = $penjamin->penjamin_nama;
    // }
    // else{
    //   $penjamin = '-';
    // }
    if(!empty($modPenjualan->pasien_id)){
      $asuransi = AsuransipasienM::model()->findByPk($modPenjualan->pasien_id);
    }
    if(!empty($modPendaftaran->penjamin_id)){
      $penjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
    }
    
    
//            var_dump($tandabukti->attributes); die;
    $judulLaporan='Sale Invoice';
    if(isset($modPendaftaran->asuransipasien_id)){
      $modAsuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
    }else{
      $modAsuransi = new AsuransipasienM();
    }
    
    $petugas = InformasipasiensudahbayarV::model()->findByAttributes(array('pendaftaran_id' =>$modPenjualan->pendaftaran_id));
//        $caraPrint=$_REQUEST['caraPrint'];
    if($caraPrint=='PRINT') {
         $this->layout='//layouts/printWindows';
    }
    // var_dump($daftar);die;
    $this->render('fakturPembayaranApotekV2', array('petugas' =>$petugas,'modAsuransi' =>$modAsuransi,'modPembayaran'=>$modPembayaran,'penjamin'=>$penjamin,'modPenanggungjawab'=>$modPenanggungjawab,'modPenjualan'=>$modPenjualan, 'modPendaftaran'=>$modPendaftaran,'pasien'=>$pasien,'modPegawaiDokter'=>$modPegawaiDokter,'modInstalasi'=>$modInstalasi,'obatAlkes'=>$obatAlkes, 'tandabukti'=>$tandabukti,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
 }
  /**
   * actionBuktiKasMasukFarmasi cetak BKM (Bukti Kas Masuk) Farmasi
   * @param type $penjualanresep_id
   * @param type $tandabuktibayar_id
   */
  public function actionBuktiKasMasukFarmasi($penjualanresep_id,$tandabuktibayar_id, $caraPrint = null) {
    if (!empty($tandabuktibayar_id) && !empty($penjualanresep_id)) {
        $this->layout='//layouts/iframe';
        $format = new MyFormatter();
        if($caraPrint == "PRINT"){
            $this->layout='//layouts/printWindows';
        }
        $criteria = new CDbCriteria;
        if(!empty($tandabuktibayar_id)){
          $criteria->addCondition("t.tandabuktibayar_id = ".$tandabuktibayar_id);					
        }
        $modPenjualan = PenjualanresepT::model()->findByPk($penjualanresep_id);
        $model = TandabuktibayarT::model()->with('pembayaranpelayanan')->find($criteria);
        $modObatalkes = ObatalkespasienT::model()->findAllByAttributes(array('penjualanresep_id'=>$penjualanresep_id));
        $rincianTagihan = BKInformasipenjualanaresepV::model()->findAllByAttributes
                (array('pasien_id'=>$model->pembayaranpelayanan->pasien_id,
                'penjualanresep_id'=>$penjualanresep_id));
        $modPegawai = PegawaikaryawanV::model()->findByAttributes(array('pegawai_id'=>$modPenjualan->pasienpegawai_id));
        $modInstalasi = InstalasiM::model()->findByAttributes(array('instalasi_id'=>$modPenjualan->pasieninstalasiunit_id));
        $judulLaporan = 'Tanda Bukti Pembayaran Apotek';
        $this->render('buktiKasMasukFarmasi', array(
            'model' => $model,
            'judulLaporan'=> $judulLaporan,
            'rincianTagihan'=>$rincianTagihan,
            'modObatalkes'=>$modObatalkes,
            'modPenjualan'=>$modPenjualan,
            'modPegawai'=>$modPegawai,
            'modInstalasi'=>$modInstalasi,
            'format'=>$format,
        ));
    }
}
}
