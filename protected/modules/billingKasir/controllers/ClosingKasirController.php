<?php

/**
 * Form Closing Kasir
 * 
 * @author     Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package    application.modules.billingKasir
 * @subpackage controllers
 * @category   controller
 */
class ClosingKasirController extends MyAuthController
{

  public $url_setor_bank = "setoranBendaharaKeBankBK/index";
  public $path_view = 'billingKasir.views.closingKasir.';

  /**
   * Form Closing Kasir
   * 
   * @param integer $id ID Closing Kasir setelah submit.
   */
  public function actionIndex($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Closing Kasir";
    $format = new MyFormatter();
    $informasi = array();

    $model = new BKClosingkasirT();
    $model->tglclosingkasir = date('Y-m-d H:i:s');

    $mSetorBank = new BKSetorbankT();
    $mBuktBayar = new BKTandabuktibayarT();
    $mBuktiKeluar = new BKTandabuktikeluarT();
    //$mBuktBayar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $mBuktBayar->tgl_awal = date('d M Y 00:00:00');
    $mBuktBayar->tgl_akhir = date('d M Y 23:59:59');


    $mBuktBayar->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
    $mBuktBayar->shift_id = Yii::app()->user->getState('shift_id');
    //$mBuktBayar->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');

    // if (!empty($mBuktBayar->shift_id)) {
    //   $sft = $this->hitungShift($mBuktBayar->shift_id);
    //   $mBuktBayar->tgl_awal = $sft['awal'];
    //   $mBuktBayar->tgl_akhir = $sft['akhir'];
    // }



    if (isset($_POST['BKTandabuktibayarT'])) {
      $mBuktBayar->attributes = $_POST['BKTandabuktibayarT'];
      $mBuktBayar->tgl_awal = $mBuktiKeluar->tgl_awal = $format->formatDateTimeForDb($_POST['BKTandabuktibayarT']['tgl_awal']);
      $mBuktBayar->tgl_akhir = $mBuktiKeluar->tgl_akhir = $format->formatDateTimeForDb($_POST['BKTandabuktibayarT']['tgl_akhir']);
      $mBuktBayar->loket_id = (!empty($_POST['BKTandabuktibayarT']['loket_id'])?$_POST['BKTandabuktibayarT']['loket_id']:null);
      $mBuktBayar->jnspembayar_id = (!empty($_POST['BKTandabuktibayarT']['jnspembayar_id'])?$_POST['BKTandabuktibayarT']['jnspembayar_id']:null);
      $mBuktBayar->shift_id = $mBuktiKeluar->shift_id = (!empty($_POST['BKTandabuktibayarT']['shift_id'])?$_POST['BKTandabuktibayarT']['shift_id']:null);

      $mBuktiKeluar->create_loginpemakai_id = $_POST['BKTandabuktibayarT']['create_loginpemakai_id'];

      $model->closingdari = $mBuktBayar->tgl_awal;
      $model->sampaidengan = $mBuktBayar->tgl_akhir;

      $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
      // $model->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      //            $model->shift_id = $mBuktBayar->shift_id;

      $mSetorBank->ygmenyetor_id = $mBuktBayar->create_loginpemakai_id;
      $mSetorBank->create_loginpemakai_id = Yii::app()->user->id;
    }

    $model->closingsaldoawal = 0;
    $cr = new CDbCriteria();
    // $cr->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
    $cr->compare('pegawai_id', Yii::app()->user->getState('pegawai_id'));
    $cr->addCondition('closingkasir_id is null');
    $cr->order='pengisiansaldoawal_id desc';
    
    // if(!empty($mBuktBayar->shift_id)){
		// 	if (is_array($mBuktBayar->shift_id)){
		// 		$cr->addInCondition("shift_id",$mBuktBayar->shift_id);			
		// 	}else{
		// 		$cr->addCondition("shift_id = ".$mBuktBayar->shift_id);			
		// 	}
		// }

    if (!empty($mBuktBayar->ruangan_id)) {
			$cr->addCondition("t.ruangan_id = " . $mBuktBayar->ruangan_id);
		}

    if(!empty($mBuktBayar->tgl_awal) && !empty($mBuktBayar->tgl_akhir)){
      $cr->addBetweenCondition('tglpengisiansaldo',MyFormatter::formatDateTimeForDb($mBuktBayar->tgl_awal), MyFormatter::formatDateTimeForDb($mBuktBayar->tgl_akhir));
    }
    
    
    $saldo = PengisiansaldoawalT::model()->find($cr);
    if (!empty($mBuktBayar->shift_id)&&(!empty($saldo->nilaisaldoawal))) {
      $model->closingsaldoawal = $saldo->nilaisaldoawal;
    }
    $model->closingkasir_no = '-- Otomatis --'; //MyGenerator::noClosingKasir();

    $criteria = new CDbCriteria;
    $criteria->join .= "left join loginpemakai_k m on m.loginpemakai_id = t.create_loginpemakai_id";
    if (!empty($mBuktBayar->ruangan_id)) {
      $criteria->addCondition("t.ruangan_id = " . $mBuktBayar->ruangan_id);
    }
    if (!empty($mBuktBayar->create_loginpemakai_id)) {
      $criteria->addCondition("m.loginpemakai_id = " . $mBuktBayar->create_loginpemakai_id);
    }
    $criteria->addCondition('t.closingkasir_id IS NULL');
    if(!empty($mBuktBayar->tgl_awal) && !empty($mBuktBayar->tgl_akhir)){
      $criteria->addBetweenCondition('DATE(t.tglpenerimaan)',MyFormatter::formatDateTimeForDb($mBuktBayar->tgl_awal), MyFormatter::formatDateTimeForDb($mBuktBayar->tgl_akhir));
    }
   
    $rPenerimaanUmum = array(); //PenerimaanumumT::model()->findAll($criteria);
    $total_penerimaan_umum = 0;
    foreach ($rPenerimaanUmum as $val) {
      $total_penerimaan_umum += $val['totalharga'];
    }
    $informasi['total_penerimaan_umum'] = $total_penerimaan_umum;
    // MyFormatter::formatNumberForUser($total_penerimaan_umum);
    $criteria_dua = new CDbCriteria;
    $criteria_dua->join .= "left join loginpemakai_k m on m.loginpemakai_id = t.create_loginpemakai_id";
    if (!empty($mBuktBayar->ruangan_id)) {
      $criteria->addCondition("t.create_ruangan = " . $mBuktBayar->ruangan_id);
    }
    if (!empty($mBuktBayar->create_loginpemakai_id)) {
      $criteria->addCondition("m.loginpemakai_id = " . $mBuktBayar->create_loginpemakai_id);
    }
    $criteria_dua->addCondition('t.closingkasir_id IS NULL');
    $criteria_dua->addCondition('t.batalkeluarumum_id IS NULL');
    if(!empty($mBuktBayar->tgl_awal) && !empty($mBuktBayar->tgl_akhir)){
      $criteria_dua->addBetweenCondition('DATE(t.tglpengeluaran)',MyFormatter::formatDateTimeForDb($mBuktBayar->tgl_awal), MyFormatter::formatDateTimeForDb($mBuktBayar->tgl_akhir));
    }
    $rPengeluaranUmum = array(); //PengeluaranumumT::model()->findAll($criteria_dua);
    $total_pengeluaran_umum = 0;

    foreach ($rPengeluaranUmum as $val) {
      $total_pengeluaran_umum += $val['totalharga'];
    }
    $informasi['total_pengeluaran_umum'] = $total_pengeluaran_umum;
    //MyFormatter::formatNumberForUser($total_pengeluaran_umum);
    $attributes = array('lookup_type' => 'nilaiuang', 'lookup_aktif' => true);
    $rPecahanUang = LookupM::model()->findAllByAttributes($attributes, array('order' => 'lookup_urutan'));


    if (isset($_POST['BKClosingkasirT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $model->attributes = $_POST['BKClosingkasirT'];
      $model->jumlahnontunai = $_POST['BKClosingkasirT']['jumlahnontunai'];
      $model->jumlahreturoa = $_POST['BKClosingkasirT']['jumlahreturoa'];
      $model->closingdari = empty($model->closingdari) ? NULL : $format->formatDateTimeForDb($model->closingdari);
      $model->sampaidengan = empty($model->sampaidengan) ? NULL : $format->formatDateTimeForDb($model->sampaidengan);
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_time = date('Y-m-d H:i:s');
      $model->update_time = date('Y-m-d H:i:s');
      $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
      $model->shift_id = (!empty($_POST['BKClosingkasirT']['shift_id'])?$_POST['BKClosingkasirT']['shift_id']:Yii::app()->user->getState('shift_id'));
      $model->jmluanglogam = 0;
      $model->jmluangkertas = 0;
      $model->closingkasir_no = MyGenerator::noClosingKasir();
      // var_dump($model->attributes); die;
      try {
        if ($model->validate()) {
          if ($model->save()) {

            if(!empty($model->closingkasir_id) && $saldo != null){
              $saldo->closingkasir_id = $model->closingkasir_id;
              $saldo->save();
            }

            $x = 0;
            foreach ($_POST['jum_recehan'] as $key => $val) {
              $rincianCloding = new RincianclosingT;
              $rincianCloding->closingkasir_id = $model->closingkasir_id;
              $rincianCloding->nourutrincian = $x + 1;
              $rincianCloding->nilaiuang = $key;
              $rincianCloding->banyakuang = (int) $val;
              $rincianCloding->jumlahuang = $key * $val;
              $rincianCloding->save();
              $x++;
            }

            $penerimaan = true;
            if (isset($_POST['isPenerimaanUmum'])) {
              $penerimaan = $this->savePenerimaan($model, $rPenerimaanUmum);
            }

            $pengeluaran = true;
            if (isset($_POST['isPengeluaranUmum'])) {
              $pengeluaran = $this->savePengeluaran($model, $rPengeluaranUmum);
            }
            /*
                          if(isset($_POST['setorBank']))
                          {
                          $mSetorBank->attributes = $_POST['BKSetorbankT'];
                          $mSetorBank->create_time = date('Y-m-d h:m:s');
                          $mSetorBank->tgldisetor = $format->formatDateTimeForDb($_POST['BKSetorbankT']['tgldisetor']);
                          if($mSetorBank->validate())
                          {
                          if($mSetorBank->save())
                          {
                          $buktiBayar =  $this->saveTandaBuktiBayar($model, $_POST['BKClosingkasirT']['nobuktibayar']);

                          if($penerimaan && $pengeluaran && $buktiBayar)
                          {
                          $transaction->commit();
                          Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                          }else{
                          Yii::app()->user->setFlash('error',"Data gagal disimpan");
                          }
                          }else{
                          Yii::app()->user->setFlash('error',"Data gagal setor bank disimpan");
                          }
                          }
                          }else{
                         * 
                         */

            $pilih = isset($_POST['pilih']) ? $_POST['pilih'] : array();
            $pilih_keluar = isset($_POST['pilih_keluar']) ? $_POST['pilih_keluar'] : array();

            // var_dump($pilih, $pilih_keluar);
            // die;

            $buktiBayar = $this->saveTandaBuktiBayar($model, $pilih);
            $buktiKeluar = $this->saveTandaBuktiKeluar($model, $pilih_keluar);

            // die;

            $this->notifClosingKasir($model);

            if ($penerimaan && $pengeluaran && $buktiBayar) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', "Data nomor Closing Kasir " . $model->closingkasir_no . " berhasil disimpan");
              $this->redirect(array('index', 'id' => $model->closingkasir_id));
            } else {
              Yii::app()->user->setFlash('error', "Data tutup kasir gagal disimpan");
            }
            // }
          }
        } else {

          Yii::app()->user->setFlash('error', "Data tutup kasir gagal disimpan");
          $transaction->rollback();
        }
      } catch (Exception $exc) { var_dump($exc->getMessage()); die;
        Yii::app()->user->setFlash('error', "Data tutup kasir gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }
    //Mengembalikan format tanggal
    $mBuktBayar->tgl_awal = MyFormatter::formatDateTimeForUser($mBuktBayar->tgl_awal);
    $mBuktBayar->tgl_akhir = MyFormatter::formatDateTimeForUser($mBuktBayar->tgl_akhir);

    $this->render(
      'index',
      array(
        'model' => $model,
        'mBuktBayar' => $mBuktBayar,
        'mBuktiKeluar' => $mBuktiKeluar,
        'rPenerimaanUmum' => $rPenerimaanUmum,
        'rPengeluaranUmum' => $rPengeluaranUmum,
        'rPecahanUang' => $rPecahanUang,
        'informasi' => $informasi,
        'mSetorBank' => $mSetorBank,
        'format' => $format,
        'id' => $id,
      )
    );
  }


  protected function notifClosingKasir($model)
  {

    // $shift = ShiftM::model()->findByPk($model->shift_id);
    // $pegawai = PegawaiM::model()->findByPk($model->pegawai_id);

    // $judul = "Closing Kasir - ".$model->closingkasir_no;
    // //$jenis = JenispenerimaanM::model()->findByPk($model->jenispenerimaan_id);

    // $isi = "Tgl. Closing : ".MyFormatter::formatDateTimeForUser($model->tglclosingkasir)."<br/>";
    // $isi .= "Shift : ".$shift->shift_nama."<br/>";
    // $isi .= "Petugas Kasir : ".(empty($pegawai) ? "-" : $pegawai->namaLengkap)."<br/>";

    // $ruanganKeuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    // $ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);

    // $ok = CustomFunction::broadcastNotif($judul, $isi, array(
    //     array('instalasi_id'=>$ruanganKeuangan->instalasi_id, 'ruangan_id'=>$ruanganKeuangan->ruangan_id, 'modul_id'=>$ruanganKeuangan->modul_id),
    //     //array('instalasi_id'=>$ruanganAkuntansi->instalasi_id, 'ruangan_id'=>$ruanganAkuntansi->ruangan_id, 'modul_id'=>$ruanganAkuntansi->modul_id),
    // ));

    $judul = "Closing Kasir - " . $model->closingkasir_no;
    $shift = ShiftM::model()->findByPk($model->shift_id);
    $pegawai = PegawaiM::model()->findByPk($model->pegawai_id);

    $isi = "Tgl. Closing : " . MyFormatter::formatDateTimeForUser($model->tglclosingkasir) . "<br/>";
    $isi .= "Shift : " . $shift->shift_nama . "<br/>";
    $isi .= "Petugas Kasir : " . (empty($pegawai) ? "-" : $pegawai->namaLengkap) . "<br/>";

    $ruanganKeuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    $ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);
    $kasir = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

    $cur = array(
      array('instalasi_id' => $ruanganKeuangan->instalasi_id, 'ruangan_id' => $ruanganKeuangan->ruangan_id, 'modul_id' => $ruanganKeuangan->modul_id),
      array('instalasi_id' => $ruanganAkuntansi->instalasi_id, 'ruangan_id' => $ruanganAkuntansi->ruangan_id, 'modul_id' => $ruanganAkuntansi->modul_id),
      array('instalasi_id' => $kasir->instalasi_id, 'ruangan_id' => $kasir->ruangan_id, 'modul_id' => $kasir->modul_id)
    );
    CustomFunction::broadcastNotif($judul, $isi, $cur);
  }


  /**
   * Update data penerimaan umum
   * 
   * @param  mixed $params
   * @param  PenerimaanumumT $penerimaan
   * @return mixed
   */
  protected function savePenerimaan($params, $penerimaan)
  {
    $record = false;
    foreach ($penerimaan as $val) {
      $record = PenerimaanumumT::model()->updateByPk($val['penerimaanumum_id'], array('closingkasir_id' => $params['closingkasir_id']));
      TandabuktibayarT::model()->updateByPk($val['tandabuktibayar_id'], array('closingkasir_id' => $params['closingkasir_id']));
    }
    return $record;
  }

  /**
   * Update data pengeluaran  
   * @param mixed $params
   * @param PengeluaranumumT $pengeluaran
   * @return mixed
   */
  protected function savePengeluaran($params, $pengeluaran)
  {
    $record = false;
    foreach ($pengeluaran as $val) {
      $record = PengeluaranumumT::model()->updateByPk($val['pengeluaranumum_id'], array('closingkasir_id' => $params['closingkasir_id']));
      TandabuktibayarT::model()->updateByPk($val['tandabuktibayar_id'], array('closingkasir_id' => $params['closingkasir_id']));
    }
    return $record;
  }

  /**
   * Update tanda bukti bayar + insert jurnal closing.
   * 
   * @param mixed $params
   * @param mixed $tanda
   * @return mixed
   */
  protected function saveTandaBuktiBayar($params, $tanda)
  {
    $record = true;

    foreach ($tanda as $val => $v) {
      $attributes = array(
        'tandabuktibayar_id' => trim($val)
      );

      $result = TandabuktibayarT::model()->findByAttributes($attributes);

      $result->closingkasir_id = $params->closingkasir_id;
      $record = $record && $result->save();


      TandabuktibayarT::model()->updateByPk($result->tandabuktibayar_id, array('closingkasir_id' => $params->closingkasir_id));
      if (Yii::app()->user->getState('ispostingotomatis')) {
        Yii::app()->db
          ->createCommand("select ins_jurnalpostingotomatisbilling_fix_bkm(" . $result['tandabuktibayar_id'] . ")")
          ->query();
      }
    }
    return $record;
  }

  /**
   * Update tanda bukti keluar
   * 
   * @param mixed $params
   * @param mixed $tanda
   * @return mixed
   */
  protected function saveTandaBuktiKeluar($params, $tanda)
  {
    $record = true;

    foreach ($tanda as $val => $v) {
      $attributes = array(
        'tandabuktikeluar_id' => trim($val)
      );

      $result = TandabuktikeluarT::model()->findByAttributes($attributes);

      $result->closingkasir_id = $params->closingkasir_id;
      $record = $record && $result->save(false);


      TandabuktikeluarT::model()->updateByPk($result->tandabuktikeluar_id, array('closingkasir_id' => $params->closingkasir_id));
      
      // var_dump($result->attributes);
      /*
      if (Yii::app()->user->getState('ispostingotomatis')) {
        Yii::app()->db
          ->createCommand("select ins_jurnalpostingotomatisbilling_fix_bkm(" . $result['tandabuktibayar_id'] . ")")
          ->query();
      }
      */
    }
    return $record;
  }

  /**
   * Menampilkan informasi closing kasir
   */
  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Closing Kasir";
    $model = new BKInformasiclosingkasirV('searchInformasi');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date("d M Y");
    $model->tgl_akhir = date("d M Y");
    if (isset($_GET['BKInformasiclosingkasirV'])) {
      $model->attributes = $_GET['BKInformasiclosingkasirV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasiclosingkasirV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasiclosingkasirV']['tgl_akhir']);
      $model->status_setor = $_GET['BKInformasiclosingkasirV']['status_setor'];
    }

    $this->render($this->path_view . 'informasi', array('model' => $model));
  }

  /**
   * Menampilkan rincian setoran berdasarkan data closing yang dipilih.
   * 
   * @param integer $idSetor
   */
  public function actionRincianSetoran($idSetor)
  {
    $this->layout = '//layouts/iframe';
    $modSetor = BKSetorbankT::model()->findByPk($idSetor);
    if (!$modSetor) {
      Yii::app()->user->setFlash('warning', 'Tidak ada transaksi setor ke Bank !');
      $modSetor = new BKSetorbankT;
    }
    $this->render($this->path_view . 'rincianSetoran', array(
      'modSetor' => $modSetor,
    ));
  }

  /**
   * Menampilkan rincian closing berdasarkan data closing yang dipilih.
   * 
   * @param integer $idClosing
   */
  public function actionRincian($idClosing)
  {
    $this->layout = '//layouts/iframe';

    $closing = ClosingkasirT::model()->findByPk($idClosing);
    $bkm = TandabuktibayarT::model()->findAllByAttributes(array('closingkasir_id' => $idClosing), array('order' => 'tglbuktibayar asc'));
    $bkk = TandabuktikeluarT::model()->findAllByAttributes(array('closingkasir_id' => $idClosing), array('order' => 'tglkaskeluar asc'));
    $rincian = RincianclosingT::model()->findAllByAttributes(array('closingkasir_id' => $idClosing), array('order' => 'nourutrincian'));
    $rekap = CetakclosingkasirV::model()->findAllByAttributes(['closingkasir_id'=>$idClosing]);
    $rekapTunai = CetakclosingkasirV::model()->findAllByAttributes(['closingkasir_id'=>$idClosing, 'jenis_rekap'=>'PEMBAYARAN '], ['order'=>'jenis_rekap']);
    $rekapDP = CetakclosingkasirV::model()->findAllByAttributes(['closingkasir_id'=>$idClosing, 'jenis_rekap'=>'DP '], ['order'=>'jenis_rekap']);
    $rekapjaminan = CetakclosingkasirV::model()->findAllByAttributes(['closingkasir_id'=>$idClosing, 'jenis_rekap'=>'JAMINAN '], ['order'=>'jenis_rekap']);
    $rekapRetur = CetakclosingkasirV::model()->findAllByAttributes(['closingkasir_id'=>$idClosing, 'jenis_rekap'=>'RETUR '], ['order'=>'jenis_rekap']);
    $nontunai = InformasipembayarantagihannontunaiV::model()->findAllByAttributes(['closingkasir_id' => $idClosing]);
    // echo '<pre>';
    // var_dump($rekapRetur);die;
    $this->render($this->path_view . 'rincian', array(
      'closing' => $closing,
      'bkm' => $bkm,
      'rincian' => $rincian,
      'rekap' => $rekap,
      'rekapTunai' => $rekapTunai,
      'rekapjaminan' =>$rekapjaminan,
      'rekapDP' => $rekapDP,
      'nontunai' => $nontunai,
      'bkk' => $bkk,
      'rekapRetur' => $rekapRetur,
    ));
  }

  /**
   * Membatalkan closing kasir.
   * 
   * @param integer $idClosing
   */
  public function actionBatalclosing($idClosing)
  {
    $this->layout = '//layouts/iframe';
    $model = BKClosingkasirT::model()->findByPk($idClosing);
    $modRincian = BKRincianclosingT::model()->findAllByAttributes(array('closingkasir_id' => $model->closingkasir_id));
    $modSaldo = BKPengisiansaldoawalT::model()->findAllByAttributes(['closingkasir_id'=>$model->closingkasir_id]);
    // var_dump($modSaldo);die;
    $status;
    $transaction = Yii::app()->db->beginTransaction();
    try {
      if (empty($model->setorkebank_id)) {
        $modTandabukti = BKTandabuktibayarT::model()->findAllByAttributes(array('closingkasir_id' => $idClosing));
        if (count((array)$modTandabukti) > 0) {
          foreach ($modTandabukti as $buktibayar) {
            $buktibayar->closingkasir_id = "";
            $buktibayar->save();
          }
        }
        $modKeluar = BKTandabuktikeluarT::model()->findAllByAttributes(array('closingkasir_id' => $idClosing));
        if (count((array)$modKeluar) > 0) {
          foreach ($modKeluar as $buktibayar) {
            $buktibayar->closingkasir_id = "";
            $buktibayar->save();
          }
        }
        foreach ($modRincian as $rincian) {
          $rincian->delete();
        }
        foreach ($modSaldo as $mod){
          $mod->closingkasir_id = null;
          $mod->save();
        }
        $model->delete();
        $transaction->commit();
        Yii::app()->user->setFlash('success', 'Closing Kasir berhasil dibatalkan !');
        $status = 1;
      } else {
        Yii::app()->user->setFlash('error', 'Closing Kasir gagal dibatalkan karena sudah melakukan setoran ke bank !');
        $status = 0;
        $this->redirect(array('RincianSetoran', 'idSetor' => $model->setorbank_id));
      }
    } catch (Exception $exc) {
      Yii::app()->user->setFlash('error', "Closing Kasir gagal dibatalkan " . MyExceptionMessage::getMessage($exc, true));
      $transaction->rollback();
    }
    $this->render('batalclosing', array(
      'model' => $model,
      'modRincian' => $modRincian,
      'status' => $status,
    ));
  }

  public function actionKirimClosingKeKeuangan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    if (isset($_POST['form_kirim'])) {
      $ok = true;
      $msg = "Data Closing berhasil dikirim.";
      $trans = Yii::app()->db->beginTransaction();
      try {

        ClosingkasirT::model()->updateByPk($_POST['form_kirim'], array(
          'is_kirim' => true,
          'kirim_tgl' => date('Y-m-d H:i:s'),
          'kirim_pegawai_id' => Yii::app()->user->getState('pegawai_id'),
          'kirim_keterangan' => $_POST['form_kirim']['keterangan'],
        ));

        // insert jurnal

        $closing = ClosingkasirT::model()->findByPk($_POST['form_kirim']);

        if (isset($closing)) {
          if (isset($closing->jumlahtunai) && $closing->jumlahtunai > 0) {
            $ok = $ok && $this->insertJurnalKirim($_POST['form_kirim']);
          }
        }

        $this->notifClosingKasir($closing);

        if ($ok) {
          $trans->commit();
        } else {
          $trans->rollback();
          $msg = "Data Closing gagal dikirim.";
        }
      } catch (Exception $e) {
        $trans->rollback();
        $ok = false;
        $msg = "Data Closing gagal dikirim. " . $e->getMessage();
      }

      echo CJSON::encode(array(
        'ok' => $ok ? 1 : 0,
        'msg' => $msg,
      ));
    }
  }

  public function insertJurnalKirim($id)
  {
    $ok = true;
    $closing = ClosingkasirT::model()->findByPk($id);
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $jenis = JenisjurnalM::model()->findByPk(Params::JENISJURNAL_ID_PENERIMAAN_KAS);

    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = MyFormatter::formatDateTimeForDb($closing->kirim_tgl);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($closing->kirim_tgl, $jenis->jeniskode);
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $closing->closingkasir_no;
    $modJurnalRekening->tglreferensi = $modJurnalRekening->tglbuktijurnal;
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = "Closing Kasir - " . $closing->closingkasir_no;
    $modJurnalRekening->jenisjurnal_id = $jenis->jenisjurnal_id;
    $modJurnalRekening->rekperiod_id = $period;
    $modJurnalRekening->create_time = $modJurnalRekening->tglbuktijurnal;
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->closingkasir_id = $closing->closingkasir_id;

    if ($modJurnalRekening->validate()) {
      $ok = $ok && $modJurnalRekening->save();
    } else {
      $ok = false;
    }

    // insert jurnal detail
    $rek = RekeningcolumnM::model()->findAllByAttributes(array(
      'table_name' => 'closingkasir_t',
      'column_name' => 'nilaiclosingtrans'
    ), array(
      'order' => 'debitkredit',
    ));

    $cnt = 1;
    foreach ($rek as $item) {


      $det = new JurnaldetailT();
      $det->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      $det->rekening5_id = $item->rekening5_id;
      $det->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $det->nourut = $cnt++;
      $det->uraiantransaksi = $modJurnalRekening->urianjurnal;
      $det->saldodebit = 0;
      $det->saldokredit = 0;
      if ($item->debitkredit == 'D') {
        $det->saldodebit = $closing->jumlahtunai;
      } else {
        $det->saldokredit = $closing->jumlahtunai;
      }
      $det->catatan = '';

      if ($det->validate()) {
        $ok = $ok && $det->save();
      } else {
        $ok = false;
      }
    }

    return $ok;
  }

  /**
   * Menampilkan informasi closing kasir
   */
  public function actionInformasiKirim()
  {

    $model = new BKInformasiclosingkasirV('searchInformasiKirim');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date("d M Y");
    $model->tgl_akhir = date("d M Y");
    if (isset($_GET['BKInformasiclosingkasirV'])) {
      $model->attributes = $_GET['BKInformasiclosingkasirV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasiclosingkasirV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasiclosingkasirV']['tgl_akhir']);
      $model->status_setor = $_GET['BKInformasiclosingkasirV']['status_setor'];
    }

    $this->render($this->path_view . 'informasiKirim', array('model' => $model));
  }

  /**
   * Ajax untuk Mengambil waktu shift berdasarkan ID Shift-nya.
   */
  function actionSetTglShift()
  {
    $res = array(
      'awal' => '',
      'akhir' => '',
    );
    $shift_id = $_POST['id'];

    $jamawal = array();
        $jamakhir = array();

    if(!empty($shift_id)){
      $criteria = new CDbCriteria();

      if(is_array($shift_id)){
        $criteria->addInCondition('shift_id', $shift_id);
      }else{
        $criteria->addCondition('shift_id ='.$shift_id);
      }
      $model = ShiftM::model()->findAll($criteria);

      if(!empty($model)){
        $shiftAwal = array();
        $shiftAkhi = array();

        foreach($model as $dataShift){
          $shiftAwal[] = date('Y-m-d')." ".$dataShift->shift_jamawal;

          if($dataShift->shift_bedatanggal){
            $datenext = date('Y-m-d H:i:s', strtotime('+1 day', strtotime(date('Y-m-d')." ".$dataShift->shift_jamakhir)));
            $shiftAkhi[] = $datenext;
          }else{
            $shiftAkhi[] = date('Y-m-d')." ".$dataShift->shift_jamakhir;
          }
          
        }
        asort($shiftAwal);
        arsort($shiftAkhi);
        
        foreach($shiftAwal as $data){
          $jamawal[] = $data;
        }

        foreach($shiftAkhi as $data){
          $jamakhir[] = $data;
        }

       

      }

    }

    if(empty($jamawal)){
      $jamawal[0] = date('Y-m-d H:i:s');
    }

    if(empty($jamakhir)){
      $jamakhir[0] = date('Y-m-d H:i:s');
    }
    $res['awal'] = MyFormatter::formatDateTimeForUser($jamawal[0]);
    $res['akhir'] = MyFormatter::formatDateTimeForUser($jamakhir[0]);

    echo CJSON::encode($res);
    Yii::app()->end();
  }

  function getLoadShiftJam($jam){

  }

  /**
   * Mengambil waktu shift berdasarkan ID Shift-nya.
   * 
   * @param type $id
   * @return type
   */
  function hitungShift($id)
  {
    $shift = ShiftM::model()->findByPk($id);

    $base = strtotime("00:00:00");
    $awal = strtotime($shift->shift_jamawal);
    $akhir = strtotime($shift->shift_jamakhir);

    $now2 = time();
    $now1 = time();

    if ($awal > $akhir) {
      if ($now1 >= $base && $now1 <= $akhir) {
        $now2 -= (24 * 3600);
      } else {
        $now1 += (24 * 3600);
      }
    }
    $res['awal'] = MyFormatter::formatDateTimeForUser(date('Y-m-d ' . $shift->shift_jamawal), $now2);
    $res['akhir'] = MyFormatter::formatDateTimeForUser(date('Y-m-d ' . $shift->shift_jamakhir, $now1));

    return $res;
  }
}
