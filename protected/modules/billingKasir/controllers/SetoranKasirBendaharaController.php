<?php

class SetoranKasirBendaharaController extends MyAuthController
{
  public $path_view = "billingKasir.views.setoranKasirBendahara.";

  public function actionDetail()
  {
    $this->render($this->path_view . 'detail');
  }

  public function actionIndex($id = null)
  {
    $closing = new BKClosingkasirT;
    $setoran = new BKSetorankasirT;
    $setorandet = array();
    $tot = $this->new_setoran();

    $p = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
    if (!empty($p)) {
      $setoran->pegawai_id = $p->pegawai_id;
      $setoran->pegawai_nama = $p->namaLengkap;
    }
    $setoran->nosetorankasir = MyGenerator::noSetoranKasir();

    if (!empty($id)) {
      $setoran = BKSetorankasirT::model()->findByPk($id);
      $closing = BKClosingkasirT::model()->findByPk($setoran->closingkasir_id);
      $p = PegawaiM::model()->findByPk($closing->pegawai_id);
      $closing->pegawai_id = $p->namaLengkap;
      $p = PegawaiM::model()->findByPk($setoran->pegawai_id);
      $setoran->pegawai_nama = $p->namaLengkap;


      $set = BKRinciansetorankasirT::model()->findAllByAttributes(array(
        'setorankasir_id' => $id
      ));

      foreach ($set as $item) {
        $sub = $this->new_setoran();
        $sub['ruangan_nama'] = $item->ruangan->ruangan_nama;
        $sub['jml_pasien'][Params::STATUSPASIEN_LAMA] = $item->jml_pasien_l;
        $tot['jml_pasien'][Params::STATUSPASIEN_LAMA] += $item->jml_pasien_l;
        $sub['jml_pasien'][Params::STATUSPASIEN_BARU] = $item->jml_pasien_p;
        $tot['jml_pasien'][Params::STATUSPASIEN_BARU] += $item->jml_pasien_p;

        $sub['retribusi'][Params::STATUSPASIEN_LAMA] = $item->jml_retirbusi_pl;
        $tot['retribusi'][Params::STATUSPASIEN_LAMA] += $item->jml_retirbusi_pl;
        $sub['retribusi'][Params::STATUSPASIEN_BARU] = $item->jml_retirbusi_pb;
        $tot['retribusi'][Params::STATUSPASIEN_BARU] += $item->jml_retirbusi_pb;

        $sub['jasa_medis'][Params::STATUSPASIEN_LAMA] = $item->jml_jasamedis_pl;
        $tot['jasa_medis'][Params::STATUSPASIEN_LAMA] += $item->jml_jasamedis_pl;
        $sub['jasa_medis'][Params::STATUSPASIEN_BARU] = $item->jml_jasamedis_pl;
        $tot['jasa_medis'][Params::STATUSPASIEN_BARU] += $item->jml_jasamedis_pb;

        $sub['jasa_paramedis'][Params::STATUSPASIEN_LAMA] = $item->jml_paramedis_pl;
        $tot['jasa_paramedis'][Params::STATUSPASIEN_LAMA] += $item->jml_paramedis_pl;
        $sub['jasa_paramedis'][Params::STATUSPASIEN_BARU] = $item->jml_paramedis_pb;
        $tot['jasa_paramedis'][Params::STATUSPASIEN_BARU] += $item->jml_paramedis_pb;

        $sub['administrasi'][Params::STATUSPASIEN_LAMA] = $item->jml_administrasi_pl;
        $tot['administrasi'][Params::STATUSPASIEN_LAMA] += $item->jml_administrasi_pl;
        $sub['administrasi'][Params::STATUSPASIEN_BARU] = $item->jml_administrasi_pb;
        $tot['administrasi'][Params::STATUSPASIEN_BARU] += $item->jml_administrasi_pb;

        $sub['jumlah'][Params::STATUSPASIEN_LAMA] = $item->jml_setoran_pl;
        $tot['jumlah'][Params::STATUSPASIEN_LAMA] += $item->jml_setoran_pl;
        $sub['jumlah'][Params::STATUSPASIEN_BARU] = $item->jml_setoran_pb;
        $tot['jumlah'][Params::STATUSPASIEN_BARU] += $item->jml_setoran_pb;

        $sub['total'] = $item->totsetkasirruangan;
        $tot['total'] += $item->totsetkasirruangan;

        $setorandet[$item->ruangan_id] = $sub;
      }
    }


    if (isset($_POST['BKSetorankasirT'])) {
      // var_dump($_POST);
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      $setoran->attributes = $_POST['BKSetorankasirT'];
      $setoran->profilrs_id = Yii::app()->user->getState('profilrs_id');
      $setoran->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $setoran->tglsetorankasir = MyFormatter::formatDateTimeForDb($setoran->tglsetorankasir);
      $setoran->jmluangsetorankasir = $_POST['totalsetoran'];
      $setoran->closingkasir_id = $_POST['BKClosingkasirT']['closingkasir_id'];
      $setoran->setorankasirdari = MyFormatter::formatDateTimeForDb($_POST['BKClosingkasirT']['closingdari']);
      $setoran->sampaidengan = MyFormatter::formatDateTimeForDb($_POST['BKClosingkasirT']['sampaidengan']);
      // var_dump($setoran->validate(), $setoran->errors, $setoran->attributes);

      if ($setoran->validate()) {
        $ok = $ok && $setoran->save();
        if (isset($_POST['detail'])) {
          foreach ($_POST['detail'] as $ruangan_id => $item) {
            $setorandet = new BKRinciansetorankasirT;
            $setorandet->attributes = $item;
            $setorandet->ruangan_id = $ruangan_id;
            $setorandet->setorankasir_id = $setoran->setorankasir_id;
            $setorandet->jml_pasien_lp = $setorandet->jml_pasien_l + $setorandet->jml_pasien_p;
            // $setorandet->jml_retribusi_pl = $item['jml_retribusi_pl'];
            if ($setorandet->validate()) {
              $ok = $ok && $setorandet->save();
            } else $ok = false;
          }
        }
      } else $ok = false;
      // var_dump($ok); die;
      if ($ok) {
        $trans->commit();
        Yii::app()->user->setFlash("success", "Berhasil! Data Berhasil Disimpan.");
        $this->redirect(array('index', 'id' => $setoran->setorankasir_id));
      }
    }

    $this->render($this->path_view . 'index', array(
      'closing' => $closing,
      'setoran' => $setoran,
      'setorandet' => $setorandet,
      'tot' => $tot,
    ));
  }

  public function actionInformasi()
  {
    $model = new BKInformasisetorankasirV();
    $model->unsetAttributes();

    $model->tgl_awal = date('Y-m-d', time() - (24 * 360 * 7));
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['BKInformasisetorankasirV'])) {
      $model->attributes = $_GET['BKInformasisetorankasirV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BKInformasisetorankasirV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BKInformasisetorankasirV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'informasi', array(
      'model' => $model,
    ));
  }

  public function actionTerima($id)
  {
    $this->layout = '//layouts/iframe';

    $setoran = BKSetorankasirT::model()->findByPk($id);
    $closing = BKClosingkasirT::model()->findByPk($setoran->closingkasir_id);
    $p = PegawaiM::model()->findByPk($closing->pegawai_id);
    $closing->pegawai_id = $p->namaLengkap;
    $p = PegawaiM::model()->findByPk($setoran->pegawai_id);
    $setoran->pegawai_nama = $p->namaLengkap;

    $tot = $this->new_setoran();

    $set = BKRinciansetorankasirT::model()->findAllByAttributes(array(
      'setorankasir_id' => $id
    ));

    if (isset($_POST['BKSetorankasirT'])) {
      $setoran->bendaharapenerima_id = $_POST['BKSetorankasirT']['bendaharapenerima_id'];
      $setoran->tglditerimabendahara = date('Y-m-d');

      if ($setoran->update()) {
        Yii::app()->user->setFlash("success", "Data Berhasil Disimpan.");
      }
    }

    foreach ($set as $item) {
      $sub = $this->new_setoran();
      $sub['ruangan_nama'] = $item->ruangan->ruangan_nama;
      $sub['jml_pasien'][Params::STATUSPASIEN_LAMA] = $item->jml_pasien_l;
      $tot['jml_pasien'][Params::STATUSPASIEN_LAMA] += $item->jml_pasien_l;
      $sub['jml_pasien'][Params::STATUSPASIEN_BARU] = $item->jml_pasien_p;
      $tot['jml_pasien'][Params::STATUSPASIEN_BARU] += $item->jml_pasien_p;

      $sub['retribusi'][Params::STATUSPASIEN_LAMA] = $item->jml_retirbusi_pl;
      $tot['retribusi'][Params::STATUSPASIEN_LAMA] += $item->jml_retirbusi_pl;
      $sub['retribusi'][Params::STATUSPASIEN_BARU] = $item->jml_retirbusi_pb;
      $tot['retribusi'][Params::STATUSPASIEN_BARU] += $item->jml_retirbusi_pb;

      $sub['jasa_medis'][Params::STATUSPASIEN_LAMA] = $item->jml_jasamedis_pl;
      $tot['jasa_medis'][Params::STATUSPASIEN_LAMA] += $item->jml_jasamedis_pl;
      $sub['jasa_medis'][Params::STATUSPASIEN_BARU] = $item->jml_jasamedis_pl;
      $tot['jasa_medis'][Params::STATUSPASIEN_BARU] += $item->jml_jasamedis_pb;

      $sub['jasa_paramedis'][Params::STATUSPASIEN_LAMA] = $item->jml_paramedis_pl;
      $tot['jasa_paramedis'][Params::STATUSPASIEN_LAMA] += $item->jml_paramedis_pl;
      $sub['jasa_paramedis'][Params::STATUSPASIEN_BARU] = $item->jml_paramedis_pb;
      $tot['jasa_paramedis'][Params::STATUSPASIEN_BARU] += $item->jml_paramedis_pb;

      $sub['administrasi'][Params::STATUSPASIEN_LAMA] = $item->jml_administrasi_pl;
      $tot['administrasi'][Params::STATUSPASIEN_LAMA] += $item->jml_administrasi_pl;
      $sub['administrasi'][Params::STATUSPASIEN_BARU] = $item->jml_administrasi_pb;
      $tot['administrasi'][Params::STATUSPASIEN_BARU] += $item->jml_administrasi_pb;

      $sub['jumlah'][Params::STATUSPASIEN_LAMA] = $item->jml_setoran_pl;
      $tot['jumlah'][Params::STATUSPASIEN_LAMA] += $item->jml_setoran_pl;
      $sub['jumlah'][Params::STATUSPASIEN_BARU] = $item->jml_setoran_pb;
      $tot['jumlah'][Params::STATUSPASIEN_BARU] += $item->jml_setoran_pb;

      $sub['total'] = $item->totsetkasirruangan;
      $tot['total'] += $item->totsetkasirruangan;

      $setorandet[$item->ruangan_id] = $sub;
    }

    $this->render($this->path_view . 'terima', array(
      'closing' => $closing,
      'setoran' => $setoran,
      'setorandet' => $setorandet,
      'tot' => $tot,
    ));
  }

  public function actionPrint($id, $frame = null)
  {
    $this->layout = '//layouts/printWindows';
    if (!empty($frame)) {
      $this->layout = '//layouts/iframe';
    }

    $setoran = BKSetorankasirT::model()->findByPk($id);
    $closing = BKClosingkasirT::model()->findByPk($setoran->closingkasir_id);
    $p = PegawaiM::model()->findByPk($closing->pegawai_id);
    $closing->pegawai_id = $p->namaLengkap;
    $p = PegawaiM::model()->findByPk($setoran->pegawai_id);
    $setoran->pegawai_nama = $p->namaLengkap;

    $tot = $this->new_setoran();

    $set = BKRinciansetorankasirT::model()->findAllByAttributes(array(
      'setorankasir_id' => $id
    ));

    foreach ($set as $item) {
      $sub = $this->new_setoran();
      $sub['ruangan_nama'] = $item->ruangan->ruangan_nama;
      $sub['jml_pasien'][Params::STATUSPASIEN_LAMA] = $item->jml_pasien_l;
      $tot['jml_pasien'][Params::STATUSPASIEN_LAMA] += $item->jml_pasien_l;
      $sub['jml_pasien'][Params::STATUSPASIEN_BARU] = $item->jml_pasien_p;
      $tot['jml_pasien'][Params::STATUSPASIEN_BARU] += $item->jml_pasien_p;

      $sub['retribusi'][Params::STATUSPASIEN_LAMA] = $item->jml_retirbusi_pl;
      $tot['retribusi'][Params::STATUSPASIEN_LAMA] += $item->jml_retirbusi_pl;
      $sub['retribusi'][Params::STATUSPASIEN_BARU] = $item->jml_retirbusi_pb;
      $tot['retribusi'][Params::STATUSPASIEN_BARU] += $item->jml_retirbusi_pb;

      $sub['jasa_medis'][Params::STATUSPASIEN_LAMA] = $item->jml_jasamedis_pl;
      $tot['jasa_medis'][Params::STATUSPASIEN_LAMA] += $item->jml_jasamedis_pl;
      $sub['jasa_medis'][Params::STATUSPASIEN_BARU] = $item->jml_jasamedis_pl;
      $tot['jasa_medis'][Params::STATUSPASIEN_BARU] += $item->jml_jasamedis_pb;

      $sub['jasa_paramedis'][Params::STATUSPASIEN_LAMA] = $item->jml_paramedis_pl;
      $tot['jasa_paramedis'][Params::STATUSPASIEN_LAMA] += $item->jml_paramedis_pl;
      $sub['jasa_paramedis'][Params::STATUSPASIEN_BARU] = $item->jml_paramedis_pb;
      $tot['jasa_paramedis'][Params::STATUSPASIEN_BARU] += $item->jml_paramedis_pb;

      $sub['administrasi'][Params::STATUSPASIEN_LAMA] = $item->jml_administrasi_pl;
      $tot['administrasi'][Params::STATUSPASIEN_LAMA] += $item->jml_administrasi_pl;
      $sub['administrasi'][Params::STATUSPASIEN_BARU] = $item->jml_administrasi_pb;
      $tot['administrasi'][Params::STATUSPASIEN_BARU] += $item->jml_administrasi_pb;

      $sub['jumlah'][Params::STATUSPASIEN_LAMA] = $item->jml_setoran_pl;
      $tot['jumlah'][Params::STATUSPASIEN_LAMA] += $item->jml_setoran_pl;
      $sub['jumlah'][Params::STATUSPASIEN_BARU] = $item->jml_setoran_pb;
      $tot['jumlah'][Params::STATUSPASIEN_BARU] += $item->jml_setoran_pb;

      $sub['total'] = $item->totsetkasirruangan;
      $tot['total'] += $item->totsetkasirruangan;

      $setorandet[$item->ruangan_id] = $sub;
    }

    $this->render($this->path_view . 'print', array(
      'closing' => $closing,
      'setoran' => $setoran,
      'setorandet' => $setorandet,
      'tot' => $tot,
    ));
  }

  public function actionLoadDataClosing()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $res = array();
      $cl = BKClosingkasirT::model()->findByPk($_POST['id']);

      if (!empty($cl)) {
        $p = PegawaiM::model()->findByPk($cl->pegawai_id);
        $res = $cl->attributes;
        $res['closingdari'] = MyFormatter::formatDateTimeForUser($res['closingdari']);
        $res['sampaidengan'] = MyFormatter::formatDateTimeForUser($res['sampaidengan']);
        $res['nama_pegawai'] = $p->namaLengkap;
      }

      echo CJSON::encode($res);
    }
    Yii::app()->end();
  }

  public function actionLoadDataSetoran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $c1 = new CDbCriteria();
      $c1->compare('closingkasir_id', $_POST['id']);
      $c1->compare('penjamin_id', Params::PENJAMIN_ID_UMUM);

      $s = SetoranclosingjasaruanganV::model()->findAll($c1);
      $komponen = array(
        1 => 'jasa_medis',
        2 => 'jasa_paramedis',
        3 => 'administrasi',
        4 => 'retribusi',
      );

      $res = array();
      $total = $this->new_setoran();
      $pasien_dat = $this->hitungPasienRuangan($s);

      foreach ($pasien_dat as $ruangan_id => $item) {
        if (empty($res[$ruangan_id])) $res[$ruangan_id] = $this->new_setoran();

        $res[$ruangan_id]['ruangan_nama'] = $item['ruangan_nama'];
        $res[$ruangan_id]['jml_pasien'][Params::STATUSPASIEN_BARU] = count((array)$item[Params::STATUSPASIEN_BARU]);
        $res[$ruangan_id]['jml_pasien'][Params::STATUSPASIEN_LAMA] = count((array)$item[Params::STATUSPASIEN_LAMA]);

        $total['jml_pasien'][Params::STATUSPASIEN_BARU] += count((array)$item[Params::STATUSPASIEN_BARU]);
        $total['jml_pasien'][Params::STATUSPASIEN_LAMA] += count((array)$item[Params::STATUSPASIEN_LAMA]);
      }

      foreach ($s as $item) {
        $ruangan_id = $item->ruangan_id;
        $ruangan_nama = $item->ruangan_tindakan;
        if ($ruangan_id == Params::RUANGAN_ID_LOKET) {
          $ruangan_id = $item->ruangandaftar_id;
          $ruangan_nama = $item->ruangan_daftar;
        }

        if (empty($res[$ruangan_id])) $res[$ruangan_id] = $this->new_setoran();
        $res[$ruangan_id]['ruangan_nama'] = $ruangan_nama;

        //if (isset($item->kelompokkomponentarif_id)){
        $res[$ruangan_id][$komponen[$item->kelompokkomponentarif_id]][$item->statuspasien] += $item->tarif_tindakankomp;
        $total[$komponen[$item->kelompokkomponentarif_id]][$item->statuspasien] += $item->tarif_tindakankomp;

        $res[$ruangan_id]['jumlah'][$item->statuspasien] += $item->tarif_tindakankomp;
        $total['jumlah'][$item->statuspasien] += $item->tarif_tindakankomp;

        $res[$ruangan_id]['total'] += $item->tarif_tindakankomp;
        $total['total'] += $item->tarif_tindakankomp;
        //}
      }


      $str = "";

      foreach ($res as $idx => $item) {
        $str .= $this->renderPartial($this->path_view . 'sub/_rowdetail', array('item' => $item, 'idx' => $idx), true);
      }
      $foot = $this->renderPartial($this->path_view . 'sub/_rowtotal', array('item' => $total), true);

      echo CJSON::encode(array("row" => $str, "foot" => $foot));
    }
    Yii::app()->end();
  }

  public function actionAutoCompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $term = $_GET['term'];
      $criteria = new CDbCriteria();
      $criteria->compare('lower(nama_pegawai)', strtolower($term), true);
      $criteria->order = 'nama_pegawai';

      $p = PegawaiM::model()->findAll($criteria);

      $res = array();
      foreach ($p as $idx => $item) {
        $res[$idx] = $item->attributes;
        $res[$idx]['label'] = $item->namaLengkap;
      }

      echo CJSON::encode($res);
    }

    Yii::app()->end();
  }

  public function actionAutoCompletePegawaiSetoran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $term = $_GET['term'];
      $criteria = new CDbCriteria();
      $criteria->join = "join ruanganpegawai_m r on r.pegawai_id = t.pegawai_id";
      $criteria->compare('lower(t.nama_pegawai)', strtolower($term), true);
      $criteria->compare('r.ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->order = 't.nama_pegawai';

      $p = PegawaiM::model()->findAll($criteria);

      $res = array();
      foreach ($p as $idx => $item) {
        $res[$idx] = $item->attributes;
        $res[$idx]['nama'] = $item->namaLengkap;
      }

      echo CJSON::encode($res);
    }

    Yii::app()->end();
  }

  protected function new_setoran()
  {
    $arr = array(
      'ruangan_nama' => '',
      'jml_pasien' => array(
        Params::STATUSPASIEN_BARU => 0,
        Params::STATUSPASIEN_LAMA => 0
      ),
      'retribusi' => array(
        Params::STATUSPASIEN_BARU => 0,
        Params::STATUSPASIEN_LAMA => 0
      ),
      'jasa_medis' => array(
        Params::STATUSPASIEN_BARU => 0,
        Params::STATUSPASIEN_LAMA => 0
      ),
      'jasa_paramedis' => array(
        Params::STATUSPASIEN_BARU => 0,
        Params::STATUSPASIEN_LAMA => 0
      ),
      'administrasi' => array(
        Params::STATUSPASIEN_BARU => 0,
        Params::STATUSPASIEN_LAMA => 0
      ),
      'jumlah' => array(
        Params::STATUSPASIEN_BARU => 0,
        Params::STATUSPASIEN_LAMA => 0
      ),
      'total' => 0,
    );

    return $arr;
  }

  protected function hitungPasienRuangan($data)
  {
    $res = array();
    foreach ($data as $item) {
      $pasien = $item->pasien_id;
      if (empty($res[$item->ruangandaftar_id]))
        $res[$item->ruangandaftar_id] = array(
          'ruangan_nama' => $item->ruangan_daftar,
          Params::STATUSPASIEN_BARU => array(),
          Params::STATUSPASIEN_LAMA => array()
        );

      if (!in_array($pasien, $res[$item->ruangandaftar_id][$item->statuspasien])) {
        array_push($res[$item->ruangandaftar_id][$item->statuspasien], $pasien);
      }
    }

    return $res;
  }


  // Uncomment the following methods and override them if needed
  /*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
