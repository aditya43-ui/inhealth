<?php
class RencanaKebutuhanController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.rencanaKebutuhan.';
  public $rencanakebutuhanobattersimpan = true;

  public function actionIndex($rencanakebfarmasi_id = null)
  {
    $format = new MyFormatter();
    $modRencanaKebFarmasi = new GFRencanaKebFarmasiT;
    $modRencanaKebFarmasi->tglperencanaan = date('Y-m-d H:i:s');
    $modDetails = array();
    if (!empty($rencanakebfarmasi_id)) {
      $modRencanaKebFarmasi = GFRencanaKebFarmasiT::model()->findByPk($rencanakebfarmasi_id);
      $modRencanaKebFarmasi->pegawaimengetahui_nama = !empty($modRencanaKebFarmasi->pegawaimengetahui->NamaLengkap) ? $modRencanaKebFarmasi->pegawaimengetahui->NamaLengkap : "";
      $modRencanaKebFarmasi->pegawaimenyetujui_nama = !empty($modRencanaKebFarmasi->pegawaimenyetujui->NamaLengkap) ? $modRencanaKebFarmasi->pegawaimenyetujui->NamaLengkap : "";

      $modDetails = GFRencDetailkebT::model()->findAllByAttributes(array('rencanakebfarmasi_id' => $modRencanaKebFarmasi->rencanakebfarmasi_id));
    }

    if (isset($_POST['GFRencanaKebFarmasiT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modRencanaKebFarmasi->attributes = $_POST['GFRencanaKebFarmasiT'];
        if (isset($_GET['ubah'])) {
          $modRencanaKebFarmasi->update_time = date('Y-m-d H:i:s');
          $modRencanaKebFarmasi->update_loginpemakai_id = Yii::app()->user->id;
        } else {
          $modRencanaKebFarmasi->noperencnaan = MyGenerator::noPerencanaan();
          $modRencanaKebFarmasi->ruangan_id = Yii::app()->user->getState('ruangan_id');
          $modRencanaKebFarmasi->pegawai_id = Yii::app()->user->getState('pegawai_id');
          $modRencanaKebFarmasi->tglperencanaan = $format->formatDateTimeForDb($_POST['GFRencanaKebFarmasiT']['tglperencanaan']);
          $modRencanaKebFarmasi->create_time = date('Y-m-d H:i:s');
          $modRencanaKebFarmasi->create_loginpemakai_id = Yii::app()->user->id;
          $modRencanaKebFarmasi->create_ruangan = Yii::app()->user->ruangan_id;
        }
        $modRencanaKebFarmasi->statusrencana = "BELUM DISETUJUI"; // sesuaikan dengan lookup_m where lookup_type = 'statusrencana'
        if ($modRencanaKebFarmasi->save()) {
          if (isset($_GET['ubah'])) {
            $modRencanaDetailKeb = GFRencDetailkebT::model()->deleteAllByAttributes(array('rencanakebfarmasi_id' => $modRencanaKebFarmasi->rencanakebfarmasi_id));
          }
          if (count((array)$_POST['GFRencDetailkebT']) > 0) {
            foreach ($_POST['GFRencDetailkebT'] as $i => $postOa) {
              $modDetails[$i] = $this->simpanRencanaKebutuhan($modRencanaKebFarmasi, $postOa);
            }
          }
        }
        if ($this->rencanakebutuhanobattersimpan) {
          $transaction->commit();
          $modRencanaKebFarmasi->isNewRecord = FALSE;
          $this->redirect(array('index', 'rencanakebfarmasi_id' => $modRencanaKebFarmasi->rencanakebfarmasi_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Rencana Kebutuhan gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Rencana Kebutuhan gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render('index', array(
      'format' => $format,
      'modRencanaKebFarmasi' => $modRencanaKebFarmasi,
      'modDetails' => $modDetails,
    ));
  }

  /**
   * simpan GFRencDetailkebT
   * @param type $modRencanaKebFarmasi
   * @param type $post
   * @return \GFRencDetailkebT
   */
  public function simpanRencanaKebutuhan($modRencanaKebFarmasi, $post)
  {
    $format = new MyFormatter();
    $modRencanaDetailKeb = new GFRencDetailkebT;
    $modRencanaDetailKeb->attributes = $post;
    $modRencanaDetailKeb->rencanakebfarmasi_id = $modRencanaKebFarmasi->rencanakebfarmasi_id; //fake id
    $modRencanaDetailKeb->tglkadaluarsa = $format->formatDateTimeForDb($modRencanaDetailKeb->tglkadaluarsa);
    $modRencanaDetailKeb->persenppn = 0;
    $modRencanaDetailKeb->persenpph = 0;
    $modRencanaDetailKeb->satuankecil_id = $post['satuankecil_id'];

    if ($post['satuanobat'] == PARAMS::SATUAN_KECIL) {
      $modRencanaDetailKeb->satuanbesar_id = NULL;
    } else {
      $modRencanaDetailKeb->satuankecil_id = NULL;
    }

    $modRencanaDetailKeb->hargatotalrenc = $modRencanaDetailKeb->jmlpermintaan * $modRencanaDetailKeb->harganettorenc;

    if ($modRencanaDetailKeb->validate()) {
      $modRencanaDetailKeb->save();
    } else {
      $this->rencanakebutuhanobattersimpan &= false;
    }
    return $modRencanaDetailKeb;
  }

  /**
   * menampilkan obat
   * @return row table 
   */
  public function actionLoadFormRencanaKebutuhan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = $_POST['obatalkes_id'];
      $jumlah = $_POST['jumlah'];

      $format = new MyFormatter();
      $modRencanaKebFarmasi = new GFRencanaKebFarmasiT();
      $modRencanaDetailKeb = new GFRencDetailkebT;
      $modObatAlkes = GFObatalkesM::model()->findByPk($obatalkes_id);

      $jmlKemasan = ($modObatAlkes->kemasanbesar > 0) ? $modObatAlkes->kemasanbesar : 1;
      $modRencanaDetailKeb->jmlpermintaan = $jumlah;
      $modRencanaDetailKeb->harganettorenc = $modObatAlkes->harganetto;
      $modRencanaDetailKeb->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
      $modRencanaDetailKeb->maksimalstok = 0;
      $modRencanaDetailKeb->sumberdana_id = isset($modObatAlkes->sumberdana_id) ? $modObatAlkes->sumberdana_id : null;
      $modRencanaDetailKeb->obatalkes_nama = isset($modObatAlkes->obatalkes_id) ? $modObatAlkes->obatalkes_nama : null;
      $modRencanaDetailKeb->obatalkes_id = $modObatAlkes->obatalkes_id;
      $modRencanaDetailKeb->persenpph = 0;
      $modRencanaDetailKeb->persenppn = 0;
      $modRencanaDetailKeb->tglkadaluarsa = NULL;
      $modRencanaDetailKeb->kemasanbesar = $modObatAlkes->kemasanbesar;
      $modRencanaDetailKeb->satuankecil_id = $modObatAlkes->satuankecil_id;
      $modRencanaDetailKeb->satuanbesar_id = $modObatAlkes->satuanbesar_id;

      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'form' => $this->renderPartial(
            '_rowObatRencanaKebutuhan',
            array(
              'modRencanaKebFarmasi' => $modRencanaKebFarmasi,
              'modRencanaDetailKeb' => $modRencanaDetailKeb,
            ),
            true
          )
        )
      );
      exit;
    }
  }

  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = GFPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompletePegawaiMenyetujui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = GFPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompleteObatAlkes()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'obatalkes_nama';
      $criteria->limit = 5;
      $models = GFObatAlkesM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->obatalkes_nama . " (Stok=" . $model->StokObatRuangan . ")";
        $returnVal[$i]['value'] = $model->obatalkes_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionSetHitungRO()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $konfig = GFKonfigfarmasiK::model()->find('konfigfarmasi_aktif is true');
      $form = '';
      $pesan = '';
      $t = isset($_POST['waktu_pemakaian']) ? $_POST['waktu_pemakaian'] : null;

      $criteria_obat = new CDbCriteria();
      $criteria_obat->select = 'lokasigudang_m.lokasigudang_nama, 
									t.obatalkes_id,
									t.obatalkes_kategori,
									t.obatalkes_nama,
									t.sumberdana_id,
									t.tglkadaluarsa,
									satuankecil_m.satuankecil_nama,
									satuanbesar_m.satuanbesar_nama,
									t.harganetto,   
									t.maksimalstok, 
									t.minimalstok, 
									t.ven, 
									t.urutan_ven,
									SUM(obatalkespasien_t.hargasatuan_oa) AS hargasatuan_oa, 
									SUM(obatalkespasien_t.qty_oa) AS qty_oa,
									SUM(obatalkespasien_t.qty_oa) * obatalkespasien_t.hargasatuan_oa AS nilai,
									row_number() OVER (ORDER BY (sum(obatalkespasien_t.qty_oa) * obatalkespasien_t.hargasatuan_oa) DESC) AS rownum';
      $criteria_obat->addCondition("DATE_PART('month',tglpelayanan) BETWEEN (DATE_PART('month',now())-6) AND (DATE_PART('month',now())-1)");
      $criteria_obat->join = 'JOIN obatalkespasien_t ON obatalkespasien_t.obatalkes_id = t.obatalkes_id'
        . ' JOIN lokasigudang_m ON lokasigudang_m.lokasigudang_id = t.lokasigudang_id'
        . ' JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id'
        . ' JOIN satuanbesar_m ON satuanbesar_m.satuanbesar_id = t.satuanbesar_id';
      $criteria_obat->group = 'lokasigudang_m.lokasigudang_nama, 
									t.obatalkes_id,
									t.obatalkes_kategori,
									t.obatalkes_nama,
									t.sumberdana_id,
									t.tglkadaluarsa,
									satuankecil_m.satuankecil_nama,
									satuanbesar_m.satuanbesar_nama,
									t.harganetto,   
									t.maksimalstok, 
									t.minimalstok, 
									t.ven,
									t.urutan_ven,
									obatalkespasien_t.hargasatuan_oa';
      $criteria_obat->order = 't.urutan_ven ASC, nilai DESC';
      //			$criteria_obat->order = 'nilai DESC';

      $modObatAlkes = GFObatalkesM::model()->findAll($criteria_obat);
      $modRencanaKebFarmasi = new GFRencanaKebFarmasiT();
      $modRencanaDetailKeb = new GFRencDetailkebT;

      $nilai_a_persen = $konfig->nilai_a_persen;
      $nilai_b_persen = $konfig->nilai_b_persen;
      $nilai_c_persen = $konfig->nilai_c_persen;

      $jumlah_a_persen = ceil(($nilai_a_persen / 100) * (count((array)$modObatAlkes)));
      $jumlah_b_persen = ceil(($nilai_b_persen / 100) * (count((array)$modObatAlkes)));
      $jumlah_c_persen = ceil(($nilai_c_persen / 100) * (count((array)$modObatAlkes)));
      $jumlah_90 = ceil((90 / 100) * (count((array)$modObatAlkes)));

      $jumlah_a = 0;
      $jumlah_b = 0;
      $jumlah_c = 0;

      $kategori_obat = '';
      $nilai_persen = '';
      $dataObat = array();
      $lt = 0;
      if (count((array)$modObatAlkes) > 0) {
        foreach ($modObatAlkes as $i => $obat) {
          $modLookup = GFLookupM::model()->findByAttributes(array('lookup_type' => 'ven', 'lookup_value' => $obat->ven));
          $ven = $obat->ven;
          if ($obat->rownum <= $jumlah_a_persen) {
            $kategori_obat = 'A';
            $nilai_persen = $nilai_a_persen;
          } else if ($obat->rownum > $jumlah_a_persen && $obat->rownum <= $jumlah_90) {
            $kategori_obat = 'B';
            $nilai_persen = $nilai_b_persen;
          } else {
            $kategori_obat = 'C';
            $nilai_persen = $nilai_c_persen;
          }

          // untuk mengambil data lt
          $criteria_penerimaan = new CDbCriteria();
          $criteria_penerimaan->select = 't.permintaanpembelian_id, t.tglterima, permintaanpembelian_t.tglpermintaanpembelian,penerimaandetail_t.obatalkes_id';
          $criteria_penerimaan->join = 'JOIN permintaanpembelian_t ON permintaanpembelian_t.permintaanpembelian_id = t.permintaanpembelian_id
							JOIN permintaandetail_t ON permintaandetail_t.permintaanpembelian_id = permintaanpembelian_t.permintaanpembelian_id
							JOIN penerimaandetail_t ON penerimaandetail_t.penerimaanbarang_id = t.penerimaanbarang_id';
          $criteria_penerimaan->addCondition("DATE_PART('month',t.tglterima) BETWEEN (DATE_PART('month',now()) - $t) AND (DATE_PART('month',now())-1) OR"
            . " DATE_PART('month',permintaanpembelian_t.tglpermintaanpembelian) BETWEEN (DATE_PART('month',now()) - $t) AND (DATE_PART('month',now())-1)");
          $criteria_penerimaan->addCondition('t.permintaanpembelian_id is NOT NULL');
          $criteria_penerimaan->addCondition('penerimaandetail_t.obatalkes_id = ' . $obat->obatalkes_id);

          $mod_penerimaan = GFPenerimaanBarangT::model()->findAll($criteria_penerimaan);

          if (count((array)$mod_penerimaan) > 0) {
            foreach ($mod_penerimaan as $d => $terima) {
              $tglterima = $terima->tglterima;
              $tglpermintaan = $terima->tglpermintaanpembelian;

              $tgl = abs(strtotime($tglpermintaan) + strtotime($tglterima));

              $years = floor($tgl / (365 * 60 * 60 * 24));
              $months = floor(($tgl - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
              $days = floor(($tgl - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

              if (empty($months) || $months <= 0) {
                $lt += 0;
              }
            }
          }

          // untuk mengambil data O
          $sql_o = 'SELECT SUM(jmlpermintaan - jmlterima) AS onorder FROM penerimaandetail_t';
          $mod_o = Yii::app()->db->createCommand($sql_o)->queryRow();

          // untuk mengambil data X
          $sql_x = "SELECT AVG(qtystok_out) AS qtystok,obatalkes_id FROM stokobatalkes_t WHERE obatalkes_id = $obat->obatalkes_id AND DATE_PART('month',tglstok_out) BETWEEN DATE_PART('month',now()) - 6 AND DATE_PART('month',now())-1 GROUP BY obatalkes_id";
          $mod_x = Yii::app()->db->createCommand($sql_x)->queryRow();

          // untuk mengambil data SD
          $sql_sd = "SELECT STDDEV(qtystok_in - qtystok_out) AS qtystok,obatalkes_id FROM stokobatalkes_t WHERE obatalkes_id = $obat->obatalkes_id GROUP BY obatalkes_id";
          $mod_sd = Yii::app()->db->createCommand($sql_sd)->queryRow();

          // untuk mengambil data SOH
          $sql_soh = "SELECT SUM(qtystok_in - qtystok_out) AS qtystok,obatalkes_id FROM stokobatalkes_t WHERE obatalkes_id = $obat->obatalkes_id GROUP BY obatalkes_id";
          $mod_soh = Yii::app()->db->createCommand($sql_soh)->queryRow();

          // untuk mengambil nilai K
          $k = 0;
          if ($ven == 'v') {
            $k = $konfig->nilai_vital;
          } else if ($ven == 'e') {
            $k = $konfig->nilai_esensial;
          } else if ($ven == 'n') {
            $k = $konfig->nilai_nonesensial;
          }

          // untk mengambil nilai qtystok
          $sql_qtystok = 'SELECT SUM(qtystok_in - qtystok_out) AS qtystok,obatalkes_id FROM stokobatalkes_t WHERE obatalkes_id = ' . $obat->obatalkes_id . ' GROUP BY obatalkes_id';
          $mod_qtystok = Yii::app()->db->createCommand($sql_qtystok)->queryRow();

          $o = isset($mod_o['onorder']) ? round($mod_o['onorder']) : 0;
          $x = isset($mod_x['qtystok']) ? round($mod_x['qtystok']) : 0;
          $sd = isset($mod_sd['qtystok']) ? round($mod_sd['qtystok']) : 0;
          $soh = isset($mod_soh['qtystok']) ? round($mod_soh['qtystok']) : 0;
          $qtystok = isset($mod_qtystok['qtystok']) ? round($mod_qtystok['qtystok']) : 0;

          // untuk perhitungan RO
          $ro = round($x * ($t + $lt)) + ($sd * $k) - ($soh + $o);

          // untuk penghitungan buffer stok
          $buffer_stok = round($sd * $k);

          // untuk penghitungan stok akhir
          $stokakhir = round($ro + $qtystok);

          // untuk menampilkan detail obat 
          $modRencanaDetailKeb->obatalkes_id = isset($obat->obatalkes_id) ? $obat->obatalkes_id : null;
          $modRencanaDetailKeb->jmlpermintaan = $ro;
          $modRencanaDetailKeb->buffer_stok = $buffer_stok;
          $modRencanaDetailKeb->on_order = $o;
          $modRencanaDetailKeb->x_ratapemakaian = $x;
          $modRencanaDetailKeb->stokonhand = $soh;
          $modRencanaDetailKeb->harganettorenc = $obat->harganetto;
          //					$modRencanaDetailKeb->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
          $modRencanaDetailKeb->stokakhir = $stokakhir;
          $modRencanaDetailKeb->maksimalstok = $obat->maksimalstok;
          //					$modRencanaDetailKeb->maksimalstok = 0;
          $modRencanaDetailKeb->sumberdana_id = isset($obat->sumberdana_id) ? $obat->sumberdana_id : null;
          $modRencanaDetailKeb->obatalkes_nama = isset($obat->obatalkes_id) ? $obat->obatalkes_nama : null;
          $modRencanaDetailKeb->persenpph = 0;
          $modRencanaDetailKeb->persenppn = 0;
          $modRencanaDetailKeb->tglkadaluarsa = isset($obat->tglkadaluarsa) ? $obat->tglkadaluarsa : null;
          $modRencanaDetailKeb->kemasanbesar = $obat->kemasanbesar;
          $modRencanaDetailKeb->satuankecil_id = $obat->satuankecil_id;
          $modRencanaDetailKeb->satuanbesar_id = $obat->satuanbesar_id;
          $modRencanaDetailKeb->kategori_abc = $kategori_obat;
          $modRencanaDetailKeb->persen_abc = $nilai_persen;
          $modRencanaDetailKeb->ven = $obat->ven;
          $modRencanaDetailKeb->jenis_material = isset($modLookup) ? $modLookup->lookup_name : "-";
          $dataObat[$ven][$kategori_obat][$i] = $modRencanaDetailKeb->attributes;
        }

        // untuk menampilkan data Vital - A
        if (isset($dataObat['v']['A'])) {
          if (count((array)$dataObat['v']['A']) > 0) {
            foreach ($dataObat['v']['A'] as $ii => $data) {
              $modObat = GFObatalkesM::model()->findByPk($data['obatalkes_id']);
              $modLookup = GFLookupM::model()->findByAttributes(array('lookup_type' => 'ven', 'lookup_value' => $modObat->ven));

              $modRencanaDetailKeb->obatalkes_id = isset($modObat->obatalkes_id) ? $modObat->obatalkes_id : null;
              $modRencanaDetailKeb->jmlpermintaan = $data['jmlpermintaan'];
              $modRencanaDetailKeb->buffer_stok = $data['buffer_stok'];
              $modRencanaDetailKeb->on_order = $data['on_order'];
              $modRencanaDetailKeb->x_ratapemakaian = $data['x_ratapemakaian'];
              $modRencanaDetailKeb->stokonhand = $data['stokonhand'];
              $modRencanaDetailKeb->harganettorenc = $modObat->harganetto;
              //					$modRencanaDetailKeb->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
              $modRencanaDetailKeb->stokakhir = $data['stokakhir'];
              $modRencanaDetailKeb->maksimalstok = $modObat->maksimalstok;
              //					$modRencanaDetailKeb->maksimalstok = 0;
              $modRencanaDetailKeb->sumberdana_id = isset($modObat->sumberdana_id) ? $modObat->sumberdana_id : null;
              $modRencanaDetailKeb->obatalkes_nama = isset($modObat->obatalkes_id) ? $modObat->obatalkes_nama : null;
              $modRencanaDetailKeb->persenpph = 0;
              $modRencanaDetailKeb->persenppn = 0;
              $modRencanaDetailKeb->tglkadaluarsa = isset($modObat->tglkadaluarsa) ? $modObat->tglkadaluarsa : null;
              $modRencanaDetailKeb->kemasanbesar = $modObat->kemasanbesar;
              $modRencanaDetailKeb->satuankecil_id = $modObat->satuankecil_id;
              $modRencanaDetailKeb->satuanbesar_id = $modObat->satuanbesar_id;
              $modRencanaDetailKeb->kategori_abc = $data['kategori_abc'];
              $modRencanaDetailKeb->persen_abc = $data['persen_abc'];
              $modRencanaDetailKeb->ven = $modObat->ven;
              $modRencanaDetailKeb->jenis_material = isset($modLookup) ? $modLookup->lookup_name : "-";

              if ($modRencanaDetailKeb->stokakhir <= $modRencanaDetailKeb->maksimalstok || $modRencanaDetailKeb->jmlpermintaan >= 0) {
                $form .= $this->renderPartial('_rowObatRencanaKebutuhan', array('modRencanaKebFarmasi' => $modRencanaKebFarmasi, 'modRencanaDetailKeb' => $modRencanaDetailKeb), true);
              }
            }
          }
        }

        // untuk menampilkan data Vital - B
        if (isset($dataObat['v']['B'])) {
          if (count((array)$dataObat['v']['B']) > 0) {
            foreach ($dataObat['v']['B'] as $ii => $data) {
              $modObat = GFObatalkesM::model()->findByPk($data['obatalkes_id']);
              $modLookup = GFLookupM::model()->findByAttributes(array('lookup_type' => 'ven', 'lookup_value' => $modObat->ven));

              $modRencanaDetailKeb->obatalkes_id = isset($modObat->obatalkes_id) ? $modObat->obatalkes_id : null;
              $modRencanaDetailKeb->jmlpermintaan = $data['jmlpermintaan'];
              $modRencanaDetailKeb->buffer_stok = $data['buffer_stok'];
              $modRencanaDetailKeb->on_order = $data['on_order'];
              $modRencanaDetailKeb->x_ratapemakaian = $data['x_ratapemakaian'];
              $modRencanaDetailKeb->stokonhand = $data['stokonhand'];
              $modRencanaDetailKeb->harganettorenc = $modObat->harganetto;
              //					$modRencanaDetailKeb->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
              $modRencanaDetailKeb->stokakhir = $data['stokakhir'];
              $modRencanaDetailKeb->maksimalstok = $modObat->maksimalstok;
              //					$modRencanaDetailKeb->maksimalstok = 0;
              $modRencanaDetailKeb->sumberdana_id = isset($modObat->sumberdana_id) ? $modObat->sumberdana_id : null;
              $modRencanaDetailKeb->obatalkes_nama = isset($modObat->obatalkes_id) ? $modObat->obatalkes_nama : null;
              $modRencanaDetailKeb->persenpph = 0;
              $modRencanaDetailKeb->persenppn = 0;
              $modRencanaDetailKeb->tglkadaluarsa = isset($modObat->tglkadaluarsa) ? $modObat->tglkadaluarsa : null;
              $modRencanaDetailKeb->kemasanbesar = $modObat->kemasanbesar;
              $modRencanaDetailKeb->satuankecil_id = $modObat->satuankecil_id;
              $modRencanaDetailKeb->satuanbesar_id = $modObat->satuanbesar_id;
              $modRencanaDetailKeb->kategori_abc = $data['kategori_abc'];
              $modRencanaDetailKeb->persen_abc = $data['persen_abc'];
              $modRencanaDetailKeb->ven = $modObat->ven;
              $modRencanaDetailKeb->jenis_material = isset($modLookup) ? $modLookup->lookup_name : "-";

              if ($modRencanaDetailKeb->stokakhir <= $modRencanaDetailKeb->maksimalstok || $modRencanaDetailKeb->jmlpermintaan >= 0) {
                $form .= $this->renderPartial('_rowObatRencanaKebutuhan', array('modRencanaKebFarmasi' => $modRencanaKebFarmasi, 'modRencanaDetailKeb' => $modRencanaDetailKeb), true);
              }
            }
          }
        }

        // untuk menampilkan data Vital - C
        if (isset($dataObat['v']['C'])) {
          if (count((array)$dataObat['v']['C']) > 0) {
            foreach ($dataObat['v']['C'] as $ii => $data) {
              $modObat = GFObatalkesM::model()->findByPk($data['obatalkes_id']);
              $modLookup = GFLookupM::model()->findByAttributes(array('lookup_type' => 'ven', 'lookup_value' => $modObat->ven));

              $modRencanaDetailKeb->obatalkes_id = isset($modObat->obatalkes_id) ? $modObat->obatalkes_id : null;
              $modRencanaDetailKeb->jmlpermintaan = $data['jmlpermintaan'];
              $modRencanaDetailKeb->buffer_stok = $data['buffer_stok'];
              $modRencanaDetailKeb->on_order = $data['on_order'];
              $modRencanaDetailKeb->x_ratapemakaian = $data['x_ratapemakaian'];
              $modRencanaDetailKeb->stokonhand = $data['stokonhand'];
              $modRencanaDetailKeb->harganettorenc = $modObat->harganetto;
              //					$modRencanaDetailKeb->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
              $modRencanaDetailKeb->stokakhir = $data['stokakhir'];
              $modRencanaDetailKeb->maksimalstok = $modObat->maksimalstok;
              //					$modRencanaDetailKeb->maksimalstok = 0;
              $modRencanaDetailKeb->sumberdana_id = isset($modObat->sumberdana_id) ? $modObat->sumberdana_id : null;
              $modRencanaDetailKeb->obatalkes_nama = isset($modObat->obatalkes_id) ? $modObat->obatalkes_nama : null;
              $modRencanaDetailKeb->persenpph = 0;
              $modRencanaDetailKeb->persenppn = 0;
              $modRencanaDetailKeb->tglkadaluarsa = isset($modObat->tglkadaluarsa) ? $modObat->tglkadaluarsa : null;
              $modRencanaDetailKeb->kemasanbesar = $modObat->kemasanbesar;
              $modRencanaDetailKeb->satuankecil_id = $modObat->satuankecil_id;
              $modRencanaDetailKeb->satuanbesar_id = $modObat->satuanbesar_id;
              $modRencanaDetailKeb->kategori_abc = $data['kategori_abc'];
              $modRencanaDetailKeb->persen_abc = $data['persen_abc'];
              $modRencanaDetailKeb->ven = $modObat->ven;
              $modRencanaDetailKeb->jenis_material = isset($modLookup) ? $modLookup->lookup_name : "-";

              if ($modRencanaDetailKeb->stokakhir <= $modRencanaDetailKeb->maksimalstok || $modRencanaDetailKeb->jmlpermintaan >= 0) {
                $form .= $this->renderPartial('_rowObatRencanaKebutuhan', array('modRencanaKebFarmasi' => $modRencanaKebFarmasi, 'modRencanaDetailKeb' => $modRencanaDetailKeb), true);
              }
            }
          }
        }

        // untuk menampilkan data Essensial -A
        if (isset($dataObat['e']['A'])) {
          if (count((array)$dataObat['e']['A']) > 0) {
            foreach ($dataObat['e']['A'] as $ii => $data) {
              $modObat = GFObatalkesM::model()->findByPk($data['obatalkes_id']);
              $modLookup = GFLookupM::model()->findByAttributes(array('lookup_type' => 'ven', 'lookup_value' => $modObat->ven));

              $modRencanaDetailKeb->obatalkes_id = isset($modObat->obatalkes_id) ? $modObat->obatalkes_id : null;
              $modRencanaDetailKeb->jmlpermintaan = $data['jmlpermintaan'];
              $modRencanaDetailKeb->buffer_stok = $data['buffer_stok'];
              $modRencanaDetailKeb->on_order = $data['on_order'];
              $modRencanaDetailKeb->x_ratapemakaian = $data['x_ratapemakaian'];
              $modRencanaDetailKeb->stokonhand = $data['stokonhand'];
              $modRencanaDetailKeb->harganettorenc = $modObat->harganetto;
              //					$modRencanaDetailKeb->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
              $modRencanaDetailKeb->stokakhir = $data['stokakhir'];
              $modRencanaDetailKeb->maksimalstok = $modObat->maksimalstok;
              //					$modRencanaDetailKeb->maksimalstok = 0;
              $modRencanaDetailKeb->sumberdana_id = isset($modObat->sumberdana_id) ? $modObat->sumberdana_id : null;
              $modRencanaDetailKeb->obatalkes_nama = isset($modObat->obatalkes_id) ? $modObat->obatalkes_nama : null;
              $modRencanaDetailKeb->persenpph = 0;
              $modRencanaDetailKeb->persenppn = 0;
              $modRencanaDetailKeb->tglkadaluarsa = isset($modObat->tglkadaluarsa) ? $modObat->tglkadaluarsa : null;
              $modRencanaDetailKeb->kemasanbesar = $modObat->kemasanbesar;
              $modRencanaDetailKeb->satuankecil_id = $modObat->satuankecil_id;
              $modRencanaDetailKeb->satuanbesar_id = $modObat->satuanbesar_id;
              $modRencanaDetailKeb->kategori_abc = $data['kategori_abc'];
              $modRencanaDetailKeb->persen_abc = $data['persen_abc'];
              $modRencanaDetailKeb->ven = $modObat->ven;
              $modRencanaDetailKeb->jenis_material = isset($modLookup) ? $modLookup->lookup_name : "-";

              if ($modRencanaDetailKeb->stokakhir <= $modRencanaDetailKeb->maksimalstok || $modRencanaDetailKeb->jmlpermintaan >= 0) {
                $form .= $this->renderPartial('_rowObatRencanaKebutuhan', array('modRencanaKebFarmasi' => $modRencanaKebFarmasi, 'modRencanaDetailKeb' => $modRencanaDetailKeb), true);
              }
            }
          }
        }

        // untuk menampilkan data Non-Essensial -A
        if (isset($dataObat['n']['A'])) {
          if (count((array)$dataObat['n']['A']) > 0) {
            foreach ($dataObat['n']['A'] as $ii => $data) {
              $modObat = GFObatalkesM::model()->findByPk($data['obatalkes_id']);
              $modLookup = GFLookupM::model()->findByAttributes(array('lookup_type' => 'ven', 'lookup_value' => $modObat->ven));

              $modRencanaDetailKeb->obatalkes_id = isset($modObat->obatalkes_id) ? $modObat->obatalkes_id : null;
              $modRencanaDetailKeb->jmlpermintaan = $data['jmlpermintaan'];
              $modRencanaDetailKeb->buffer_stok = $data['buffer_stok'];
              $modRencanaDetailKeb->on_order = $data['on_order'];
              $modRencanaDetailKeb->x_ratapemakaian = $data['x_ratapemakaian'];
              $modRencanaDetailKeb->stokonhand = $data['stokonhand'];
              $modRencanaDetailKeb->harganettorenc = $modObat->harganetto;
              //					$modRencanaDetailKeb->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
              $modRencanaDetailKeb->stokakhir = $data['stokakhir'];
              $modRencanaDetailKeb->maksimalstok = $modObat->maksimalstok;
              //					$modRencanaDetailKeb->maksimalstok = 0;
              $modRencanaDetailKeb->sumberdana_id = isset($modObat->sumberdana_id) ? $modObat->sumberdana_id : null;
              $modRencanaDetailKeb->obatalkes_nama = isset($modObat->obatalkes_id) ? $modObat->obatalkes_nama : null;
              $modRencanaDetailKeb->persenpph = 0;
              $modRencanaDetailKeb->persenppn = 0;
              $modRencanaDetailKeb->tglkadaluarsa = isset($modObat->tglkadaluarsa) ? $modObat->tglkadaluarsa : null;
              $modRencanaDetailKeb->kemasanbesar = $modObat->kemasanbesar;
              $modRencanaDetailKeb->satuankecil_id = $modObat->satuankecil_id;
              $modRencanaDetailKeb->satuanbesar_id = $modObat->satuanbesar_id;
              $modRencanaDetailKeb->kategori_abc = $data['kategori_abc'];
              $modRencanaDetailKeb->persen_abc = $data['persen_abc'];
              $modRencanaDetailKeb->ven = $modObat->ven;
              $modRencanaDetailKeb->jenis_material = isset($modLookup) ? $modLookup->lookup_name : "-";

              if ($modRencanaDetailKeb->stokakhir <= $modRencanaDetailKeb->maksimalstok || $modRencanaDetailKeb->jmlpermintaan >= 0) {
                $form .= $this->renderPartial('_rowObatRencanaKebutuhan', array('modRencanaKebFarmasi' => $modRencanaKebFarmasi, 'modRencanaDetailKeb' => $modRencanaDetailKeb), true);
              }
            }
          }
        }

        // untuk menampilkan data Essensial -B
        if (isset($dataObat['e']['B'])) {
          if (count((array)$dataObat['e']['B']) > 0) {
            foreach ($dataObat['e']['B'] as $ii => $data) {
              $modObat = GFObatalkesM::model()->findByPk($data['obatalkes_id']);
              $modLookup = GFLookupM::model()->findByAttributes(array('lookup_type' => 'ven', 'lookup_value' => $modObat->ven));

              $modRencanaDetailKeb->obatalkes_id = isset($modObat->obatalkes_id) ? $modObat->obatalkes_id : null;
              $modRencanaDetailKeb->jmlpermintaan = $data['jmlpermintaan'];
              $modRencanaDetailKeb->buffer_stok = $data['buffer_stok'];
              $modRencanaDetailKeb->on_order = $data['on_order'];
              $modRencanaDetailKeb->x_ratapemakaian = $data['x_ratapemakaian'];
              $modRencanaDetailKeb->stokonhand = $data['stokonhand'];
              $modRencanaDetailKeb->harganettorenc = $modObat->harganetto;
              //					$modRencanaDetailKeb->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
              $modRencanaDetailKeb->stokakhir = $data['stokakhir'];
              $modRencanaDetailKeb->maksimalstok = $modObat->maksimalstok;
              //					$modRencanaDetailKeb->maksimalstok = 0;
              $modRencanaDetailKeb->sumberdana_id = isset($modObat->sumberdana_id) ? $modObat->sumberdana_id : null;
              $modRencanaDetailKeb->obatalkes_nama = isset($modObat->obatalkes_id) ? $modObat->obatalkes_nama : null;
              $modRencanaDetailKeb->persenpph = 0;
              $modRencanaDetailKeb->persenppn = 0;
              $modRencanaDetailKeb->tglkadaluarsa = isset($modObat->tglkadaluarsa) ? $modObat->tglkadaluarsa : null;
              $modRencanaDetailKeb->kemasanbesar = $modObat->kemasanbesar;
              $modRencanaDetailKeb->satuankecil_id = $modObat->satuankecil_id;
              $modRencanaDetailKeb->satuanbesar_id = $modObat->satuanbesar_id;
              $modRencanaDetailKeb->kategori_abc = $data['kategori_abc'];
              $modRencanaDetailKeb->persen_abc = $data['persen_abc'];
              $modRencanaDetailKeb->ven = $modObat->ven;
              $modRencanaDetailKeb->jenis_material = isset($modLookup) ? $modLookup->lookup_name : "-";

              if ($modRencanaDetailKeb->stokakhir <= $modRencanaDetailKeb->maksimalstok || $modRencanaDetailKeb->jmlpermintaan >= 0) {
                $form .= $this->renderPartial('_rowObatRencanaKebutuhan', array('modRencanaKebFarmasi' => $modRencanaKebFarmasi, 'modRencanaDetailKeb' => $modRencanaDetailKeb), true);
              }
            }
          }
        }

        // untuk menampilkan data Non-Essensial -B
        if (isset($dataObat['n']['B'])) {
          if (count((array)$dataObat['n']['B']) > 0) {
            foreach ($dataObat['n']['B'] as $ii => $data) {
              $modObat = GFObatalkesM::model()->findByPk($data['obatalkes_id']);
              $modLookup = GFLookupM::model()->findByAttributes(array('lookup_type' => 'ven', 'lookup_value' => $modObat->ven));

              $modRencanaDetailKeb->obatalkes_id = isset($modObat->obatalkes_id) ? $modObat->obatalkes_id : null;
              $modRencanaDetailKeb->jmlpermintaan = $data['jmlpermintaan'];
              $modRencanaDetailKeb->buffer_stok = $data['buffer_stok'];
              $modRencanaDetailKeb->on_order = $data['on_order'];
              $modRencanaDetailKeb->x_ratapemakaian = $data['x_ratapemakaian'];
              $modRencanaDetailKeb->stokonhand = $data['stokonhand'];
              $modRencanaDetailKeb->harganettorenc = $modObat->harganetto;
              //					$modRencanaDetailKeb->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
              $modRencanaDetailKeb->stokakhir = $data['stokakhir'];
              $modRencanaDetailKeb->maksimalstok = $modObat->maksimalstok;
              //					$modRencanaDetailKeb->maksimalstok = 0;
              $modRencanaDetailKeb->sumberdana_id = isset($modObat->sumberdana_id) ? $modObat->sumberdana_id : null;
              $modRencanaDetailKeb->obatalkes_nama = isset($modObat->obatalkes_id) ? $modObat->obatalkes_nama : null;
              $modRencanaDetailKeb->persenpph = 0;
              $modRencanaDetailKeb->persenppn = 0;
              $modRencanaDetailKeb->tglkadaluarsa = isset($modObat->tglkadaluarsa) ? $modObat->tglkadaluarsa : null;
              $modRencanaDetailKeb->kemasanbesar = $modObat->kemasanbesar;
              $modRencanaDetailKeb->satuankecil_id = $modObat->satuankecil_id;
              $modRencanaDetailKeb->satuanbesar_id = $modObat->satuanbesar_id;
              $modRencanaDetailKeb->kategori_abc = $data['kategori_abc'];
              $modRencanaDetailKeb->persen_abc = $data['persen_abc'];
              $modRencanaDetailKeb->ven = $modObat->ven;
              $modRencanaDetailKeb->jenis_material = isset($modLookup) ? $modLookup->lookup_name : "-";

              if ($modRencanaDetailKeb->stokakhir <= $modRencanaDetailKeb->maksimalstok || $modRencanaDetailKeb->jmlpermintaan >= 0) {
                $form .= $this->renderPartial('_rowObatRencanaKebutuhan', array('modRencanaKebFarmasi' => $modRencanaKebFarmasi, 'modRencanaDetailKeb' => $modRencanaDetailKeb), true);
              }
            }
          }
        }

        // untuk menampilkan data Essensial -C
        if (isset($dataObat['e']['C'])) {
          if (count((array)$dataObat['e']['C']) > 0) {
            foreach ($dataObat['e']['C'] as $ii => $data) {
              $modObat = GFObatalkesM::model()->findByPk($data['obatalkes_id']);
              $modLookup = GFLookupM::model()->findByAttributes(array('lookup_type' => 'ven', 'lookup_value' => $modObat->ven));

              $modRencanaDetailKeb->obatalkes_id = isset($modObat->obatalkes_id) ? $modObat->obatalkes_id : null;
              $modRencanaDetailKeb->jmlpermintaan = $data['jmlpermintaan'];
              $modRencanaDetailKeb->buffer_stok = $data['buffer_stok'];
              $modRencanaDetailKeb->on_order = $data['on_order'];
              $modRencanaDetailKeb->x_ratapemakaian = $data['x_ratapemakaian'];
              $modRencanaDetailKeb->stokonhand = $data['stokonhand'];
              $modRencanaDetailKeb->harganettorenc = $modObat->harganetto;
              //					$modRencanaDetailKeb->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
              $modRencanaDetailKeb->stokakhir = $data['stokakhir'];
              $modRencanaDetailKeb->maksimalstok = $modObat->maksimalstok;
              //					$modRencanaDetailKeb->maksimalstok = 0;
              $modRencanaDetailKeb->sumberdana_id = isset($modObat->sumberdana_id) ? $modObat->sumberdana_id : null;
              $modRencanaDetailKeb->obatalkes_nama = isset($modObat->obatalkes_id) ? $modObat->obatalkes_nama : null;
              $modRencanaDetailKeb->persenpph = 0;
              $modRencanaDetailKeb->persenppn = 0;
              $modRencanaDetailKeb->tglkadaluarsa = isset($modObat->tglkadaluarsa) ? $modObat->tglkadaluarsa : null;
              $modRencanaDetailKeb->kemasanbesar = $modObat->kemasanbesar;
              $modRencanaDetailKeb->satuankecil_id = $modObat->satuankecil_id;
              $modRencanaDetailKeb->satuanbesar_id = $modObat->satuanbesar_id;
              $modRencanaDetailKeb->kategori_abc = $data['kategori_abc'];
              $modRencanaDetailKeb->persen_abc = $data['persen_abc'];
              $modRencanaDetailKeb->ven = $modObat->ven;
              $modRencanaDetailKeb->jenis_material = isset($modLookup) ? $modLookup->lookup_name : "-";

              if ($modRencanaDetailKeb->stokakhir <= $modRencanaDetailKeb->maksimalstok || $modRencanaDetailKeb->jmlpermintaan >= 0) {
                $form .= $this->renderPartial('_rowObatRencanaKebutuhan', array('modRencanaKebFarmasi' => $modRencanaKebFarmasi, 'modRencanaDetailKeb' => $modRencanaDetailKeb), true);
              }
            }
          }
        }

        // untuk menampilkan data Non-Essensial -C
        if (isset($dataObat['n']['C'])) {
          if (count((array)$dataObat['n']['C']) > 0) {
            foreach ($dataObat['n']['C'] as $ii => $data) {
              $modObat = GFObatalkesM::model()->findByPk($data['obatalkes_id']);
              $modLookup = GFLookupM::model()->findByAttributes(array('lookup_type' => 'ven', 'lookup_value' => $modObat->ven));

              $modRencanaDetailKeb->obatalkes_id = isset($modObat->obatalkes_id) ? $modObat->obatalkes_id : null;
              $modRencanaDetailKeb->jmlpermintaan = $data['jmlpermintaan'];
              $modRencanaDetailKeb->buffer_stok = $data['buffer_stok'];
              $modRencanaDetailKeb->on_order = $data['on_order'];
              $modRencanaDetailKeb->x_ratapemakaian = $data['x_ratapemakaian'];
              $modRencanaDetailKeb->stokonhand = $data['stokonhand'];
              $modRencanaDetailKeb->harganettorenc = $modObat->harganetto;
              //					$modRencanaDetailKeb->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
              $modRencanaDetailKeb->stokakhir = $data['stokakhir'];
              $modRencanaDetailKeb->maksimalstok = $modObat->maksimalstok;
              //					$modRencanaDetailKeb->maksimalstok = 0;
              $modRencanaDetailKeb->sumberdana_id = isset($modObat->sumberdana_id) ? $modObat->sumberdana_id : null;
              $modRencanaDetailKeb->obatalkes_nama = isset($modObat->obatalkes_id) ? $modObat->obatalkes_nama : null;
              $modRencanaDetailKeb->persenpph = 0;
              $modRencanaDetailKeb->persenppn = 0;
              $modRencanaDetailKeb->tglkadaluarsa = isset($modObat->tglkadaluarsa) ? $modObat->tglkadaluarsa : null;
              $modRencanaDetailKeb->kemasanbesar = $modObat->kemasanbesar;
              $modRencanaDetailKeb->satuankecil_id = $modObat->satuankecil_id;
              $modRencanaDetailKeb->satuanbesar_id = $modObat->satuanbesar_id;
              $modRencanaDetailKeb->kategori_abc = $data['kategori_abc'];
              $modRencanaDetailKeb->persen_abc = $data['persen_abc'];
              $modRencanaDetailKeb->ven = $modObat->ven;
              $modRencanaDetailKeb->jenis_material = isset($modLookup) ? $modLookup->lookup_name : "-";

              if ($modRencanaDetailKeb->stokakhir <= $modRencanaDetailKeb->maksimalstok || $modRencanaDetailKeb->jmlpermintaan >= 0) {
                $form .= $this->renderPartial('_rowObatRencanaKebutuhan', array('modRencanaKebFarmasi' => $modRencanaKebFarmasi, 'modRencanaDetailKeb' => $modRencanaDetailKeb), true);
              }
            }
          }
        }
      } else {
        $pesan = "Daftar Obat Alkes selama 6 bulan terakhir tidak ditemukan!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan, 'lead_time' => $lt));
    }
    Yii::app()->end();
  }

  /**
   * untuk print data rencana kebutuhan farmasi
   */
  public function actionPrint($rencanakebfarmasi_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modRencanaKebFarmasi = GFRencanaKebFarmasiT::model()->findByPk($rencanakebfarmasi_id);
    $modRencanaDetailKeb = GFRencDetailkebT::model()->findAllByAttributes(array('rencanakebfarmasi_id' => $rencanakebfarmasi_id));

    $judul_print = 'RENCANA KEBUTUHAN';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modRencanaKebFarmasi' => $modRencanaKebFarmasi,
      'modRencanaDetailKeb' => $modRencanaDetailKeb,
      'caraPrint' => $caraPrint
    ));
  }
}
