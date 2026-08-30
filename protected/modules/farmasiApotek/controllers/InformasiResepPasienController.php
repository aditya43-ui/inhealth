<?php

Yii::import('farmasiApotek.controllers.InformasiPenjualanResepController');
Yii::import('farmasiApotek.views.informasiPenjualanResep.*');

class InformasiResepPasienController extends InformasiPenjualanResepController
{
  public function actionIndex()
  {
    $modInfoPenjualan = new FAInformasipenjualanresepV('searchInfoResepPasien');
    $format = new MyFormatter();
    $modInfoPenjualan->unsetAttributes();
    $modInfoPenjualan->tgl_awal = date('Y-m-d');
    $modInfoPenjualan->tgl_akhir = date('Y-m-d');
    $modInfoPenjualan->is_tgl = 1;
    if (isset($_GET['FAInformasipenjualanresepV'])) {
      $modInfoPenjualan->attributes = $_GET['FAInformasipenjualanresepV'];
      $modInfoPenjualan->pegawai_id = $_GET['FAInformasipenjualanresepV']['pegawai_id'];
      $modInfoPenjualan->carabayar_id = $_GET['FAInformasipenjualanresepV']['carabayar_id'];
      $modInfoPenjualan->statusperiksa = $_GET['FAInformasipenjualanresepV']['statusperiksa'];
      $modInfoPenjualan->ruanganpendaftaran_id = isset($_GET['FAInformasipenjualanresepV']['ruanganpendaftaran_id']) ? $_GET['FAInformasipenjualanresepV']['ruanganpendaftaran_id'] : null;
      $modInfoPenjualan->instalasipendaftaran_id = isset($_GET['FAInformasipenjualanresepV']['instalasipendaftaran_id']) ? $_GET['FAInformasipenjualanresepV']['instalasipendaftaran_id'] : null;
      $modInfoPenjualan->tgl_awal = $format->formatDateTimeForDb($_GET['FAInformasipenjualanresepV']['tgl_awal']);
      $modInfoPenjualan->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInformasipenjualanresepV']['tgl_akhir']);
      $modInfoPenjualan->is_tgl = $_GET['FAInformasipenjualanresepV']['is_tgl'];
    }

    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'informasipenjualanresep-grid'){
        $this->renderPartial('_table', ['modInfoPenjualan' => $modInfoPenjualan]);
        Yii::app()->end();
      }
    }

    $this->render('index', array('format' => $format, 'modInfoPenjualan' => $modInfoPenjualan));
  }

  public function action
  
  ()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $penjualanresep_id = isset($_POST['penjualanresep_id']) ? $_POST['penjualanresep_id'] : null;
      $pesan = 'gagal';
      $tanggal = date('Y-m-d H:i:s');
      $pegawaibelum = Yii::app()->user->getState('pegawai_id');
      $pegawaisedang = Yii::app()->user->getState('pegawai_id');
      
      
      if ($status == 'BELUM') {
        $statusNew = 'SEDANG';
        $update = PenjualanresepT::model()->updateByPk($penjualanresep_id, array('statusobat' => $statusNew, 'tglsedangdisiapkan' => $tanggal, 'pegawaibelum_id'=>$pegawaibelum));
      } else {
        $statusNew = 'SUDAH';
        $update = PenjualanresepT::model()->updateByPk($penjualanresep_id, array('statusobat' => $statusNew, 'tglselesaidisiapkan' => $tanggal, 'pegawaisedang_id'=>$pegawaisedang));
      }

      if ($update) {
        $pesan = 'ok';
      } else {
        $pesan = 'gagal';
      }
      $data['pesan'] = $pesan;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionAmbilObat($penjualanresep_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
    $modPasien = PasienM::model()->findByPk($modPenjualan->pasien_id);
    $modPendaftaran = PendaftaranT::model()->findByPk($modPenjualan->pendaftaran_id);
    $modReseptur = ResepturdetailT::model()->findByAttributes(array('reseptur_id'=>$modPenjualan->reseptur_id));
    if(!empty($modPenjualan->reseptur_id)){

      $criteriakl = new CDbCriteria;
      $criteriakl->addCondition("reseptur_id = " . $modPenjualan->reseptur_id);
      $criteriakl->select = 'racikan_id, rke, iter, reseptur_id, jmlkemasan_reseptur';
      $criteriakl->group = 'racikan_id, rke, iter, reseptur_id, jmlkemasan_reseptur';
      if (isset($_GET['racikan_id'])) {
        $criteriakl->compare('racikan_id', $_GET['racikan_id']);
      }
      $kerangkaLooping = ResepturdetailT::model()->findAll($criteriakl);
    }else{
      $kerangkaLooping = ResepturdetailT::model()->findByAttributes(array('reseptur_id'=>$modPenjualan->reseptur_id));
    }

    if (!empty($modPenjualan->pegpenyerahan_id)){
        $modPenjualan->isdiserahkan_ke_petugas_ruangan = true;
    }
    if (!empty($modPenjualan)) {
      if(!empty($modPenjualan->pegawai_id)){
        $modPenjualan->harga_id = $modPenjualan->pegawai_id;
      }else{
        $modPenjualan->harga_id = Yii::app()->user->getState('pegawai_id');
      }
      $modPenjualan->namaygmenyerahkan = Yii::app()->user->getState('nama_pegawai');
      $modPenjualan->kiepenyerahan = CJSON::decode($modPenjualan->kiepenyerahan);
      $modPenjualan->penelaahanobat = CJSON::decode($modPenjualan->penelaahanobat);
      $modPenjualan->teknik_id = $modPenjualan->pegawaibelum_id;
      $modPenjualan->kemas_id = $modPenjualan->pegawaisedang_id;
      $modPenjualan->penyerahan_id = Yii::app()->user->getState('pegawai_id');
    }else {
      $modPenjualan = new FAPenjualanResepT();
    }

    if (isset($_POST['FAPenjualanResepT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modPenjualan->attributes = $_POST['FAPenjualanResepT'];
        $modPenjualan->tglpenyerahan = $format->formatDateTimeForDb($_POST['FAPenjualanResepT']['tglpenyerahan']);
        $modPenjualan->namapenerimaobat = $_POST['FAPenjualanResepT']['namapenerimaobat'];
        $modPenjualan->notelppenerimaobat = $_POST['FAPenjualanResepT']['notelppenerimaobat'];
        $modPenjualan->namaygmenyerahkan = $_POST['FAPenjualanResepT']['namaygmenyerahkan'];
        $modPenjualan->ketpenyerahan = $_POST['FAPenjualanResepT']['ketpenyerahan'];
        $modPenjualan->menerimaobatinformasi = $_POST['FAPenjualanResepT']['menerimaobatinformasi'];
        $modPenjualan->petugasfarmasi = $_POST['FAPenjualanResepT']['petugasfarmasi'];
        $modPenjualan->disetuju = $_POST['FAPenjualanResepT']['disetuju'];
        $modPenjualan->harga_id = $_POST['FAPenjualanResepT']['harga_id'];
        $modPenjualan->teknik_id = $_POST['FAPenjualanResepT']['teknik_id'];
        $modPenjualan->kemas_id = $_POST['FAPenjualanResepT']['kemas_id'];
        $modPenjualan->penyerahan_id = $_POST['FAPenjualanResepT']['penyerahan_id'];
        $modPenjualan->kiepenyerahan = CJSON::encode($_POST['FAPenjualanResepT']['kiepenyerahan']);
        $modPenjualan->penelaahanobat = CJSON::encode($_POST['FAPenjualanResepT']['penelaahanobat']);
        $modPenjualan->fotopenyerahanobat = $_POST['FAPenjualanResepT']['fotopenyerahanobat'];
        $modPenjualan->ttdpenyerahan = $_POST['FAPenjualanResepT']['ttdpenyerahan'];
        $modPenjualan->pegpenyerahan_id = $_POST['FAPenjualanResepT']['pegpenyerahan_id'];

        // echo '<pre>'; var_dump($_POST['FAPenjualanResepT'], $modPenjualan->attributes);die;

        $attributes = array(
          'tglpenyerahan' => $modPenjualan->tglpenyerahan,
          'namapenerimaobat' => $modPenjualan->namapenerimaobat,
          'notelppenerimaobat' => $modPenjualan->notelppenerimaobat,
          'namaygmenyerahkan' => $modPenjualan->namaygmenyerahkan,
          'ketpenyerahan' => $modPenjualan->ketpenyerahan,
          'menerimaobatinformasi' => $modPenjualan->menerimaobatinformasi,
          'petugasfarmasi' => $modPenjualan->petugasfarmasi,
          'disetuju' => $modPenjualan->disetuju,
          'harga_id' => $modPenjualan->harga_id,
          'teknik_id' => $modPenjualan->teknik_id,
          'kemas_id' => $modPenjualan->kemas_id,
          'penyerahan_id' => $modPenjualan->penyerahan_id,
          'kiepenyerahan' => $modPenjualan->kiepenyerahan,
          'penelaahanobat' => $modPenjualan->penelaahanobat,
          'ttdpenyerahan' => $modPenjualan->ttdpenyerahan,
          'fotopenyerahanobat' => $modPenjualan->fotopenyerahanobat,
          'pegpenyerahan_id' => $modPenjualan->pegpenyerahan_id,
        );
        // var_dump($attributes);die;

        $update = FAPenjualanResepT::model()->updateAll($attributes, " penjualanresep_id = " . $penjualanresep_id);
        
        if ($update) {
          if(!empty($modPendaftaran) && $modPendaftaran->instalasi_id == Params::INSTALASI_ID_RJ && (empty($modPendaftaran->pasienadmisi_id))){
            $kodebooking = $modPendaftaran->no_pendaftaran;
        
              if(!empty($modPendaftaran->buatjanjipoli_id)){
                $buatjanjipoli = BuatjanjipoliT::model()->findByPk($modPendaftaran->buatjanjipoli_id);
  
                if(!empty($buatjanjipoli)){
                  $kodebooking = $buatjanjipoli->no_buatjanji;
                }
              }
            $waktutunggupelayanan = new WaktutunggupelayananT();
            $waktutunggupelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $waktutunggupelayanan->pasien_id = $modPendaftaran->pasien_id;
            $waktutunggupelayanan->task_id = 7;
            $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type'=>'taskid','lookup_value'=>$waktutunggupelayanan->task_id));
            $waktutunggupelayanan->task_name = (!empty($lookup_waktutunggu)?$lookup_waktutunggu->lookup_name:null);
            $dateNow = date('c', strtotime(date('Y-m-d H:i:s')));
            $waktutunggupelayanan->waktutunggu_rs = date('Y-m-d H:i:s', strtotime($dateNow));

            $waktutunggupelayanan->tanggal = $waktutunggupelayanan->waktutunggu_rs;
            $waktutunggupelayanan->kode_booking = $modPendaftaran->no_pendaftaran;
            $waktutunggupelayanan->statuskirim = 0;
            $waktutunggupelayanan->create_time = $waktutunggupelayanan->waktutunggu_rs;
            $waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
            $waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
            $waktutunggupelayanan->waktutunggu_mil = (strtotime($dateNow) * 1000);

            if($waktutunggupelayanan->save()){
              if(Yii::app()->user->getState('antreanonlinewsbpjs')){
                $body_waktutgp = array("kodebooking"=>$waktutunggupelayanan->kode_booking, "taskid"=>$waktutunggupelayanan->task_id, "waktu"=>$waktutunggupelayanan->waktutunggu_mil);
                $antrianonlinebpjs = new AntrianOnlineBpjs();
                $response_antrianol = CJSON::decode($antrianonlinebpjs->update_waktu($body_waktutgp));
                $dateNowUpdt = date('c', strtotime(date('Y-m-d H:i:s')));

                if(!empty($response_antrianol['metaData']['code']) && $response_antrianol['metaData']['code'] == '200'){
                  WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('statuskirim'=>true,'update_loginpemakai_id'=>Yii::app()->user->id,'update_time'=>date('Y-m-d H:i:s', strtotime($dateNowUpdt))));
                }else{
                    if(!empty($response_antrianol['metaData']['code'])){
                      WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('response_list'=>$response_antrianol['metaData']['message']));
                    }
                }
              }
            }
          }	
          
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
          $this->redirect(array('ambilObat', 'penjualanresep_id' => $penjualanresep_id, 'frame' => 1, 'popup' => 'true', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('ambilObat', array(
      'modPenjualan' => $modPenjualan,
      'modPasien' => $modPasien,
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modReseptur' => $modReseptur,
      'kerangkaLooping' =>$kerangkaLooping
    ));
  }

   /**
   * untuk print data penjualan dokter
   */
  public function actionPrint2($penjualanresep_id, $caraPrint = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
    $modPenjualanDetail = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id));

    $judul_print = 'Penjualan Bebas';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render('Print2', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPenjualan' => $modPenjualan,
      'modPenjualanDetail' => $modPenjualanDetail,
      'caraPrint' => $caraPrint
    ));
  }

  function actionRiwayatObat($id) {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);

    $penjualan = PenjualanresepT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array('order' => 'tglpenjualan DESC'));

    $prereseptur = ResepturT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array('order' => 'tglreseptur DESC'));

    $reseptur = array();

    foreach ($prereseptur as $item) {
      $item->tglreseptur = MyFormatter::formatDateTimeForDb($item->tglreseptur);
      foreach ($penjualan as $item2) {
        if ($item->reseptur_id == $item2->reseptur_id || $item->penjualanresep_id == $item2->penjualanresep_id) {
          continue;
        }
      }
      array_push($reseptur, $item);
    }



    $checkers = array();

    foreach ($reseptur as $item) {
      $checkers[$item->tglreseptur] = array(
        'tipe' => 1,
        'noresep' => $item->noresep,
        'id' => $item->reseptur_id,
        'keterangan' => '',
        'user_apoteker' => "-",
      );
    }



    foreach ($penjualan as $item) {

      $login = LoginpemakaiK::model()->findByPk($item->create_loginpemakai_id);

      $checkers[$item->tglresep] = array(
        'tipe' => 2,
        'noresep' => $item->noresep,
        'id' => $item->penjualanresep_id,
        'keterangan' => $item->keterangan,
        'user_apoteker' => (empty($login->pegawai) ? $login->nama_pemakai : $login->pegawai->nama_pegawai),
      );
    }

    //echo "<pre>";
    //var_dump($checkers);
    //echo "</pre>";
    //die;

    //ksort($checkers);

    //var_dump(count((array)$checkers));die;

    $this->render(
      '_riwayatObat',
      array(
        'modPendaftaran' => $modPendaftaran,
        'checkers' => $checkers
      )
    );
  }
  public function actionPrintResep($penjualan_id = null) {
		
		$modPenjualan = PenjualanresepT::model()->findByPk($penjualan_id);
	
		
		$pendaftaran_id = $modPenjualan->pendaftaran_id;
		$modDetailResep = ObatalkespasienT::model()->findAllByAttributes(array('penjualanresep_id'=>$penjualan_id));
		$modPendaftaran = FAPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);

		$judulLaporan='';

		$criteriakl=new CDbCriteria;
		$criteriakl->addCondition("penjualanresep_id = ". $penjualan_id);
		$criteriakl->select = 'racikan_id, rke, penjualanresep_id';
		$criteriakl->group = 'racikan_id, rke, penjualanresep_id';
		$criteriakl->order = 'rke';
		$kerangkaLooping = ObatalkespasienT::model()->findAll($criteriakl);

		$caraPrint=$_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
				$this->layout='//layouts/printWindows';
				$this->render('printResep',array(
													'modPendaftaran'=>$modPendaftaran,
													'judulLaporan'=>$judulLaporan,
													'caraPrint'=>$caraPrint,
													"modDetailResep"=>$modDetailResep,
													'modPenjualan'=>$modPenjualan,
													'kerangkaLooping'=>$kerangkaLooping,
														));
		}
  }

  public function actionSetPetugasPenyerahan(){
    if (Yii::app()->request->isAjaxRequest){
        
        $id = isset($_POST['id'])?$_POST['id']:null;
        
        $peg = PegawaiM::model()->findByPk($id);
        
        $data['namaLengkap'] = !empty($peg)?$peg->namaLengkap:null;
        $data['pegawai_id'] = !empty($peg)?$peg->pegawai_id:null;
        $data['nomobile_pegawai'] = !empty($peg)?$peg->nomobile_pegawai:null;
        
        echo json_encode($data);
        Yii::app()->end();
    }
}
}
