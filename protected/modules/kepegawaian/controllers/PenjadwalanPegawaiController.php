<?php
class PenjadwalanPegawaiController extends MyAuthController
{
  protected  $path_view = 'kepegawaian.views.penjadwalanPegawai.';
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $penjadwalantersimpan = false;
  public $penjadwalandetailtersimpan = false;

  public function actionIndex($id = null)
  {
  
    $this->pageTitle = Yii::app()->name . " - Penjadwalan Pegawai";
    $model = new KPPenjadwalanT;
    $modPenjadwalanDetail = new KPPenjadwalandetailT;
    $instalasiAsal = CHtml::listData(KPInstalasiM::getInstalasiItems(), 'instalasi_id', 'instalasi_nama');
    $ruanganAsal = CHtml::listData(KPRuanganM::getRuanganItems(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama');
    $model->no_pembuatanjadwal = '-- Otomatis --';
    $model->periodebuatjadwal = date('Y-m-d');
    $model->sampaidengan = date('Y-m-d');
    $model->tglbuatjadwal = date('Y-m-d');
    $modDetails = array();

    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    $dis = false;
    if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_KEPEGAWAIAN) {
      $dis = true;
    }
    if (!empty($id)) {
      $model = KPPenjadwalanT::model()->findByPk($id);
    }

    if (isset($_POST['KPPenjadwalanT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        //echo 'asd';
        //var_dump($_POST['KPPenjadwalandetailT']);die;
        $model = $this->simpanPenjadwalan($model, $_POST['KPPenjadwalanT']);

        $total = array();

        if ($this->penjadwalantersimpan) {
          if (count((array)$_POST['KPPenjadwalandetailT']) > 0) {
            foreach ($_POST['KPPenjadwalandetailT'] as $i => $details) {
              //echo "<pre>";
              //print_r($details);
              //echo "</pre>";
              if (isset($details['checklist'])) {
                if ($details['checklist'] == 1) {
                  foreach ($details['shift'] as $j => $shift) {
                    if (!empty($shift['shift_id'])) {
                      $modDetails[$j] = $this->simpanPenjadwalanDetail($_POST['KPPenjadwalandetailT'], $details, $shift, $model);
                      $total[$details['pegawai_id']] = true;
                    }
                  }
                }
              }
            }
          }
        }

        // notif
        $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
        $instalasi = InstalasiM::model()->findByPk($ruangan->instalasi_id);
        $judul = "Penjadwalan Pegawai - " . $model->no_pembuatanjadwal;

        $isi = "Tgl. Penjadwalan : " . MyFormatter::formatDateTimeForUser($model->tglbuatjadwal) . "<br/>";
        $isi .= "No. Penjadwalan : " . $model->no_pembuatanjadwal . "<br/>";
        $isi .= "Periode Penjadwalan : " . MyFormatter::formatDateTimeForUser($model->tglbuatjadwal) . " - " . MyFormatter::formatDateTimeForUser($model->sampaidengan) . "<br/>";
        $isi .= "Instalasi : " . $instalasi->instalasi_nama . "<br/>";
        $isi .= "Ruangan : " . $ruangan->ruangan_nama . "<br/>";
        $isi .= "Jumlah Pegawai : " . count((array)$total);


        // var_dump($judul, $isi, $model->attributes);


        $tujuan = array((array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id)));


        if ($ruangan->ruangan_id != Params::RUANGAN_ID_KEPEGAWAIAN) {
          $peg = RuanganM::model()->findByPk(Params::RUANGAN_ID_KEPEGAWAIAN);

          $tujuan[] = (array('instalasi_id' => $peg->instalasi_id, 'ruangan_id' => $peg->ruangan_id, 'modul_id' => $peg->modul_id));
        }

        $ok = CustomFunction::broadcastNotif($judul, $isi, $tujuan);

        if ($this->penjadwalantersimpan && $this->penjadwalandetailtersimpan) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Penjadwalan Pegawai " . $model->no_pembuatanjadwal . " berhasil disimpan !");
          $this->redirect(array('index', 'id' => $model->penjadwalan_id, 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', "Data Penjadwalan Pegawai gagal disimpan !");
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
        $transaction->rollback();
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modPenjadwalanDetail' => $modPenjadwalanDetail,
      'instalasiAsal' => $instalasiAsal,
      'ruanganAsal' => $ruanganAsal,
      'dis' => $dis
    ));
  }

  /**
   * proses simpan data penjadwalan pegawai
   * @param type $model
   * @param type $post
   * @return type
   */
  public function simpanPenjadwalan($model, $post)
  {
    $format = new MyFormatter();
    $model = new KPPenjadwalanT;
    $model->attributes = $_POST['KPPenjadwalanT'];
    $model->no_pembuatanjadwal = MyGenerator::noPenjadwalanPegawai();
    $model->periodebuatjadwal = $format->formatDateTimeForDb($post['periodebuatjadwal']);
    $model->sampaidengan = $format->formatDateTimeForDb($post['sampaidengan']);
    $model->tglbuatjadwal = $format->formatDateTimeForDb($post['tglbuatjadwal']);
    $model->tglmengetahui = !empty($model->mengetahui_id) ? date('Y-m-d') : "";
    $model->tglmenyetujui = !empty($model->menyetujiu_id) ? date('Y-m-d') : "";
    $model->create_time = date('Y-m-d H:i:s');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($model->validate()) {
      $this->penjadwalantersimpan = true && $model->save();
    } else {
      $this->penjadwalantersimpan = $this->penjadwalantersimpan && false;
    }

    return $model;
  }

  /**
   * simpan PenjadwalandetailT
   * @param type $model
   * @param type $postPenjadwalan
   * @return \PenjadwalandetailT
   */
  protected function simpanPenjadwalanDetail($postPenjadwalanDetail, $details, $shift, $postPenjadwalan)
  {
    $format = new MyFormatter;
    $modPenjadwalanDetail = new KPPenjadwalandetailT;
    $modPenjadwalanDetail->attributes = $details;
    $modPenjadwalanDetail->penjadwalan_id = $postPenjadwalan->penjadwalan_id;
    $modPenjadwalanDetail->tgljadwalpegawai = MyFormatter::formatDateTimeForDb($shift['tgljadwalpegawai']);
    $pecah = explode('-', $shift['shift_id']);
    //var_dump($pecah);die;
    $modPenjadwalanDetail->shift_id = $pecah[0];
    $modPenjadwalanDetail->jamkerjamasuk = $pecah[1];
    $modPenjadwalanDetail->jamkerjapulang = $pecah[2];
    $modPenjadwalanDetail->ruangan_id = $details['ruangan_id'];


    if ($modPenjadwalanDetail->validate()) {
      $this->penjadwalandetailtersimpan = true && $modPenjadwalanDetail->save();
    } else {
      $this->penjadwalandetailtersimpan = $this->penjadwalandetailtersimpan && false;
    }

    //var_dump($modPenjadwalanDetail->getErrors());

    return $modPenjadwalanDetail;
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(KPRuanganM::getRuanganItems($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = isset($_GET['pegawai_id']) ? $_GET['pegawai_id'] : null;
      $nama_pegawai = isset($_GET['term']) ? $_GET['term'] : null;

      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 10;
      $models = KPPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['nama_pegawai'] = $model->NamaLengkap;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * menampilkan ruangan dan pola shift
   */
  public function actionGetRuanganForCheckBox()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new KPPenjadwalanT;
      $modPenjadwalanDetail = new KPShiftM;
      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
      //PROSES PENCARIAN RUANGAN
      $criteria = new CDbCriteria();
      if (!empty($instalasi_id)) {
        $criteria->addCondition('instalasi_id = ' . $instalasi_id);
      } else {
        $criteria->addCondition('instalasi_id = null');
      }
      $modRuangan = KPRuanganM::model()->findAll($criteria);
      //			$modShift	= KPShiftM::getData();
      //END PENCARIAN
      $form = "";
      if (count((array)$modRuangan) > 0) {
        foreach ($modRuangan as $i => $ruangan) {
          $criteria = new CDbCriteria();
          $criteria->select = 't.*,shift_m.*,ruangan_m.*';
          if (!empty($ruangan->ruangan_id)) {
            $criteria->addCondition('t.ruangan_id = ' . $ruangan->ruangan_id);
          }
          $criteria->addCondition('shift_m.shift_aktif = TRUE');
          $criteria->order = 'shift_m.shift_urutan ASC';
          $criteria->join = 'JOIN shift_m ON shift_m.shift_id = t.shift_id'
            . ' JOIN ruangan_m ON ruangan_m.ruangan_id = t.ruangan_id';
          $modShift = KPFormasishiftM::model()->findAll($criteria);
          $modRuangan = KPRuanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan->ruangan_id));
          $modPenjadwalanDetail->ruangan_id = $ruangan->ruangan_id;
          $modPenjadwalanDetail->ruangan_nama = $ruangan->ruangan_nama;
          $form .= $this->renderPartial('_dataRuangan', array(
            'model' => $model,
            'modPenjadwalanDetail' => $modPenjadwalanDetail,
            'modRuangan' => $modRuangan,
            'modShift' => $modShift,
            'ruangan' => $ruangan
          ), true);
        }
      } else {
        $form = '<label>Data Tidak Ditemukan</label>';
      }
      $data['form'] = $form;
      echo json_encode($data);
    }
    Yii::app()->end();
  }

  /**
   * menampilkan ruangan dan pola shift
   */
  public function actionGetPenjadwalan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $format = new MyFormatter();
      $model = new KPPenjadwalanT;
      $modShift = new KPShiftM;
      $modPenjadwalanDetail = new KPPenjadwalandetailT;


      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
      $pola_shift = isset($_POST['pola_shift']) ? $_POST['pola_shift'] : "";
      $kelompokpegawai_id = isset($_POST['kelompokpegawai_id']) ? $_POST['kelompokpegawai_id'] : "";
      $periodepenjadwalan = isset($_POST['periodepenjadwalan']) ? $_POST['periodepenjadwalan'] : "";
      $sampaidengan = isset($_POST['sampaidengan']) ? $_POST['sampaidengan'] : "";

      $tgl_awal = $format->formatDateTimeForDb($periodepenjadwalan);
      $tgl_akhir = $format->formatDateTimeForDb($sampaidengan);

      $jumlah_hari = ((abs(strtotime($tgl_akhir) - strtotime($tgl_awal))) / (60 * 60 * 24));

      $form = '';

      /*if(!empty($ruangan_id)){
				$criteria = new CDbCriteria();
				$criteria->with = array('pegawai');
				$criteria->addCondition("t.ruangan_id = ".$ruangan_id);
				if(!empty($kelompokpegawai_id)){
					$criteria->addCondition("pegawai.kelompokpegawai_id = ".$kelompokpegawai_id);
				}
				$modPegawaiRuangan = KPRuanganpegawaiM::model()->findAll($criteria);
			}*/

      $criteria = new CDbCriteria();
      $criteria->select = " t.ruangan_id,t.pegawai_id, kp.kelompokpegawai_id, kp.kelompokpegawai_nama, CONCAT(t.gelardepan,' ',t.nama_pegawai,', ',t.gelarbelakang_nama) as nama_lengkap ";
      $criteria->join = " LEFT JOIN kelompokpegawai_m kp ON kp.kelompokpegawai_id = t.kelompokpegawai_id "
        . "	";
      if (!empty($kelompokpegawai_id)) {
        $criteria->addCondition(" t.kelompokpegawai_id = '" . $kelompokpegawai_id . "' ");
      }
      if (!empty($ruangan_id)) {
        $criteria->addCondition(" t.ruangan_id = '" . $ruangan_id . "' ");
      }
      if (!empty($instalasi_id)) {
        $criteria->addCondition(" t.instalasi_id = '" . $instalasi_id . "' ");
      }
      $criteria->addCondition(" pegawai_aktif = TRUE ");
      $criteria->order = " nama_pegawai ASC ";

      //$modPegawaiRuangan = KPPegawaiM::model()->findAll($criteria);
      $modPegawaiRuangan = KPPegawairuanganV::model()->findAll($criteria);

      $criShift = new CDbCriteria;
      $criShift->select = " t.pegawai_id, t.shift_id, CONCAT(s.shift_nama,'  (',s.shift_jamawal,' - ',s.shift_jamakhir,')') as jamshift, CONCAT(s.shift_jamawal,'-',s.shift_jamakhir,')') as namashift ";
      $criShift->join = " JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id "
        . "	JOIN shift_m s ON s.shift_id = t.shift_id ";
      if (!empty($kelompokpegawai_id)) {
        $criteria->addCondition(" peg.kelompokpegawai_id = '" . $kelompokpegawai_id . "' ");
      }
      $criShift->order = " s.shift_nama ASC ";
      $shiftPegawai = KPShiftpegawaiM::model()->findAll($criShift);

      $modDropDownShift = array();
      foreach ($shiftPegawai as $s) {
        $nms = $s->shift_id . '-' . $s->namashift;
        $modDropDownShift[$s->pegawai_id]["$nms"] = $s->jamshift;
      }


      $criHariLibur = new CDbCriteria();
      $criHariLibur->select = " tglharilibur, namaharilibur ";
      $criHariLibur->addBetweenCondition("DATE(tglharilibur)", $tgl_awal, $tgl_akhir);
      $criHariLibur->addCondition(" harilibur_aktif = TRUE ");
      $criHariLibur->order = " tglharilibur ASC  ";
      $hariLibur = KPHariliburM::model()->findAll($criHariLibur);

      $modHariLibur = array();
      foreach ($hariLibur as $hr) {
        $modHariLibur[$hr->tglharilibur] = $hr->namaharilibur;
      }


      for ($p = 0; $p <= $jumlah_hari; $p++) {
        $hariawal = date("Y-m-d", strtotime($tgl_awal . ' +' . $p . ' days'));

        if (!isset($modHariLibur[$hariawal])) {
          if (strtolower(MyFormatter::getDayUser(date('w', strtotime($hariawal)))) == strtolower(Params::HARI_MINGGU)) {
            $modHariLibur[$hariawal] = 'hari minggu';
          }
        }
      }

      //echo "<pre>";
      //print_r($modhariLibur);
      //echo "</pre>";						
      //die;

      /*
//			$modShift	= KPShiftM::getData();
			$criteria = new CDbCriteria();
			$criteria->select = 't.*,shift_m.*,ruangan_m.*';
			if(!empty($ruangan_id)){
				$criteria->addCondition('t.ruangan_id = '.$ruangan_id);
			}
			$criteria->addCondition('shift_m.shift_aktif = TRUE');
			$criteria->order ='shift_m.shift_urutan ASC';
			$criteria->join = 'JOIN shift_m ON t.shift_id = shift_m.shift_id'
					. ' JOIN ruangan_m ON t.ruangan_id = ruangan_m.ruangan_id';
			$modFormasiShift = KPFormasishiftM::model()->findAll($criteria);
			
			//==== POLA SHIFT
			$pola = $pola_shift;
			$jmlpola = strlen($pola);
			$shift = array();
			for($i=0;$i<$jmlpola;$i++){
				$shift[$i] = substr($pola,($i),1);
			}
			//===
			$jmlpegawai = array();
			if(count((array)$modFormasiShift) > 0){
				foreach ($modFormasiShift AS $i => $cekshift){
					if (strpos(strtoupper($pola),strtoupper($cekshift->shift_kode)) !== false) { //hanya masukan yg ada di pola saja
						$jmlpegawai[$cekshift->shift_kode] = $_POST['jmlpegawais'][$i];
					}
				}
			}
			$form= "";
			 * 
			 */
      //if(!empty($pegawai_id)){ //Load dari Autocomplete
      /*$modRuangan = KPRuanganM::model()->findByPk($ruangan_id);
				$modPegawai = KPPegawaiM::model()->findByPk($pegawai_id);
				$modPenjadwalanDetail->instalasi_nama = isset($modRuangan->instalasi->instalasi_nama) ? $modRuangan->instalasi->instalasi_nama : "";
				$modPenjadwalanDetail->ruangan_nama = $modRuangan->ruangan_nama;
				$modPenjadwalanDetail->ruangan_id = $modRuangan->ruangan_id;
				$modPenjadwalanDetail->pegawai_id = $modPegawai->pegawai_id;
				$modPenjadwalanDetail->nama_pegawai = $modPegawai->NamaLengkap;
				$modPenjadwalanDetail->checklist = 1;
				$form = $this->renderPartial('_rowPenjadwalan', array(
					'model'=>$model,
					'modPenjadwalanDetail'=>$modPenjadwalanDetail,
					'modShift'=>$modShift,
					'modFormasiShift'=>$modFormasiShift,
					'jml_hari'=>$jumlah_hari,
					'tgl_awal'=>$tgl_awal,
					'tgl_akhir'=>$tgl_akhir,
					'shift'=>$shift,
				), true);*/
      //}else{
      if (count((array)$modPegawaiRuangan) > 0) {
        //$polaawal = $shift;
        $selectedoptions = true;
        foreach ($modPegawaiRuangan as $i => $ruangan) {
          //$modPenjadwalanDetail->instalasi_nama = isset($ruangan->ruangan->instalasi->instalasi_nama) ? $ruangan->ruangan->instalasi->instalasi_nama : "";
          //$modPenjadwalanDetail->ruangan_nama = isset($ruangan->ruangan->ruangan_nama) ? $ruangan->ruangan->ruangan_nama : "";
          $modPenjadwalanDetail->nama_pegawai = $ruangan->nama_lengkap;
          $modPenjadwalanDetail->ruangan_id = $ruangan->ruangan_id;
          $modPenjadwalanDetail->pegawai_id = $ruangan->pegawai_id;
          $modPenjadwalanDetail->kelompokpegawai_id = $ruangan->kelompokpegawai_id;
          $modPenjadwalanDetail->kelompokpegawai_nama = $ruangan->kelompokpegawai_nama;
          $modPenjadwalanDetail->checklist = 1;
          /*if($jmlpegawai[$shift[0]] == 0){ 
							while(1){ //ubah pola ke jmlpegawai yg tersedia
								$tempshift = $shift[0];
								unset($shift[0]);
								$shift = array_values($shift);
								$shift[count((array)$shift)] = $tempshift;
								if($jmlpegawai[$shift[0]] > 0) break;
								if($polaawal == $shift){ // jika pola kembali ke awal
									$selectedoptions = false;
									break;
								}
							}
							
						}*/
          $form .= $this->renderPartial('_rowPenjadwalanBaru', array(
            'model' => $model,
            'modPenjadwalanDetail' => $modPenjadwalanDetail,
            'modShift' => $modShift,
            //'modFormasiShift'=>$modFormasiShift,
            'jml_hari' => $jumlah_hari,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
            'modDropDownShift' => $modDropDownShift,
            'modHariLibur' => $modHariLibur
            //'shift'=>$shift,
            //'jmlpegawai'=>$jmlpegawai,
            //'selectedoptions'=>$selectedoptions,
          ), true);
          //if($jmlpegawai[$shift[0]] > 0){
          //$jmlpegawai[$shift[0]] --;
          //}
        }
      } else {
        $form = '';
      }

      //}

      $data['form'] = $form;
      $data['jumlah_hari'] = $jumlah_hari;

      $data['kolom_tanggal'] =  $this->renderPartial(
        '_rowTanggal',
        array(
          'jumlah_hari' => $jumlah_hari,
          'tgl_awal' => $tgl_awal,
          'tgl_akhir' => $tgl_akhir,
          'modHariLibur' => $modHariLibur
        ),
        true
      );
      echo json_encode($data);
    }
    Yii::app()->end();
  }
}
