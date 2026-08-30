<?php
Yii::import("rawatInap.models.*");
class AsuhanKeperawatanController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $successPlanning = true;
  public $successImplementasi = true;
  public $successIntervensi = true;
  public $successPengkajian = true;
  public $path_view = 'perawatanIntensif.views.asuhankeperawatan.';
  public $path_view_pengkajian = "asuhanKeperawatan.views.pengkajianAskep.";


  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new PIAsuhankeperawatanT;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PIAsuhankeperawatanT'])) {

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->asuhankeperawatan_id));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PIAsuhankeperawatanT'])) {
      $model->attributes = $_POST['PIAsuhankeperawatanT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->asuhankeperawatan_id));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Asuhan Keperawatan";
    $model = new PIAsuhankeperawatanT;
    $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
    $model->paramedis_nama = $model->pegawai->namaLengkap;
    $modPasien = new PIInfokunjunganriV();
    $modAnamnesa = new PIAnamnesaT();
    $modPeriksaFisik = new PIPemeriksaanFisikT();
    $modPasienPIV = new PIPasienRawatInapV();
    $model->tglaskep = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    $modPasienPIV->unsetAttributes();

		$modPengkajian = new PengkajianaskepT;
		$modPenunjang = new DatapenunjangT;
		
		$modPengkajian->pengkajianaskep_tgl = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
		$modPengkajian->no_pengkajian = "- Otomatis -";

    if (isset($_GET['PIPasienrawatinapV'])) {
      $modPasienPIV->attributes = $_GET['PIPasienrawatinapV'];
    }

    // Uncomment the following line if AJAX validation is needed

    // echo '<pre>'; var_dump($_POST); die;

    if (isset($_POST['PIAsuhankeperawatanT'])) {

    $post = $_POST['PengkajianaskepT'];
      //simpan pengkajian askep
    $modPengkajian = new PengkajianaskepT;
		$modPengkajian->attributes = $post;
		$modPengkajian->no_pengkajian = MyGenerator::noPengkajianAskep();
		$modPengkajian->anamesa_id = $post['anamesa_id'];
		$modPengkajian->pemeriksaanfisik_id = $post['pemeriksaanfisik_id'];
		$modPengkajian->pengkajianaskep_tgl = MyFormatter::formatDateTimeForDb($post['pengkajianaskep_tgl']);
		$modPengkajian->pendaftaran_id =  $_POST['PIAsuhankeperawatanT']['pendaftaran_id'];
		$modPengkajian->create_ruangan = Yii::app()->user->ruangan_id;
		$modPengkajian->create_time = date('Y-m-d');
		$modPengkajian->create_loginpemakai_id = Yii::app()->user->id;
		$modPengkajian->ruangan_id = Yii::app()->user->ruangan_id;
		$modPengkajian->iskeperawatan = 1;
		if ($modPengkajian->validate()) {
			$modPengkajian->save();
			$this->successPengkajian = $this->successPengkajian && true;
		} else {
                    
			$this->successPengkajian = false;
		}   

    // echo '<pre>'; var_dump($modPengkajian->attributes); die;

    

      $model->attributes = $_POST['PIAsuhankeperawatanT'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->shift_id = Yii::app()->user->getState('shift_id');
      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = $successIntervensi = $successPlanning = $successImplementasi = true;
        $jumlahAskep = $jumlahIntervensi = $jumlahPlanning = $jumlahImplementasi = 0;
        $jumlah = count((array)$_POST['AsuhankeperawatanT']['diagnosakeperawatan_id']);
        $data = AsuhankeperawatanT::model()->findAllByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        /**
         * Date     : 4 Agustus 2014
         * Issue    : RND-1187
         * Descript : dicomment karena transaksi bisa lebih dari satu.
                 
                if (count((array)$data) > 0){
                    foreach($data as $data){
                        PIIntervensiaskepT::model()->deleteAllByAttributes(array('asuhankeperawatan_id'=>$data->asuhankeperawatan_id));
                        PIImplementasiaskepT::model()->deleteAllByAttributes(array('asuhankeperawatan_id'=>$data->asuhankeperawatan_id));
                        PIPlaningaskepT::model()->deleteAllByAttributes(array('asuhankeperawatan_id'=>$data->asuhankeperawatan_id));
                        PIAsuhankeperawatanT::model()->deleteByPk($data->asuhankeperawatan_id);
                    }
                }
         * 
         */

        for ($i = 0; $jumlah > $i; $i++) {
          $modAsuhanKeperawatan[$i] = new PIAsuhankeperawatanT();
          $modAsuhanKeperawatan[$i]->attributes = $model->attributes;
          $modAsuhanKeperawatan[$i]->diagnosakeperawatan_id = $_POST['AsuhankeperawatanT']['diagnosakeperawatan_id'][$i];
          $modAsuhanKeperawatan[$i]->diagnosa_id = $_POST['AsuhankeperawatanT']['diagnosa_id'][$i];
          $modAsuhanKeperawatan[$i]->tglassesment = $model->tglaskep;
          $modAsuhanKeperawatan[$i]->evaluasi_objektif = $_POST['AsuhankeperawatanT']['evaluasi_objektif'][$i];
          $modAsuhanKeperawatan[$i]->evaluasi_subjektif = $_POST['AsuhankeperawatanT']['evaluasi_subjektif'][$i];
          $modAsuhanKeperawatan[$i]->evaluasi_assesment = $_POST['AsuhankeperawatanT']['evaluasi_assesment'][$i];
          $modAsuhanKeperawatan[$i]->askep_tujuan = $_POST['AsuhankeperawatanT']['askep_tujuan'][$i];
          $modAsuhanKeperawatan[$i]->askep_kriteriahasil = $_POST['AsuhankeperawatanT']['askep_kriteriahasil'][$i];
          $modAsuhanKeperawatan[$i]->update_time = date("Y-m-d H:i:s");
          $modAsuhanKeperawatan[$i]->update_loginpemakai_id = Yii::app()->user->id;
          //                    echo "<pre>";
          //                    echo print_r($modAsuhanKeperawatan[$i]->getAttributes());
          if ($modAsuhanKeperawatan[$i]->validate()) {
            if ($modAsuhanKeperawatan[$i]->save()) {
              $success = true;
              $jumlahAskep++;
              if (isset($_POST['rencana_intervensi'])) {
                $jumlahDipilihRencanaIntervensi = count((array)$_POST['rencana_intervensi'][$i]);
                for ($b = 0; $jumlahDipilihRencanaIntervensi > $b; $b++) {
                  $modRencana = PIRencanakeperawatanM::model()->findByPk($_POST['rencana_intervensi'][$i][$b]);
                  $modIntervensiAskep[$i][$b] = new PIIntervensiaskepT;
                  $modIntervensiAskep[$i][$b]->rencanakeperawatan_id = $_POST['rencana_intervensi'][$i][$b];
                  $modIntervensiAskep[$i][$b]->asuhankeperawatan_id = $modAsuhanKeperawatan[$i]->asuhankeperawatan_id;
                  $modIntervensiAskep[$i][$b]->tglmulaiintervensi = $modAsuhanKeperawatan[$i]->tglaskep;
                  $modIntervensiAskep[$i][$b]->intervensi_kode = $modRencana->rencana_kode;
                  $modIntervensiAskep[$i][$b]->intervensi_nama = $modRencana->rencana_intervensi;
                  $modIntervensiAskep[$i][$b]->intervensi_rasionalisasi = $modRencana->rencana_rasionalisasi;
                  $modIntervensiAskep[$i][$b]->iskolaborasi = $modRencana->iskolaborasiintervensi;
                  $modIntervensiAskep[$i][$b]->lama_waktu_jam = 0;
                  if ($modIntervensiAskep[$i][$b]->validate()) {
                    if ($modIntervensiAskep[$i][$b]->save()) {
                      $successIntervensi = true;
                      $jumlahIntervensi++;
                    }
                  }
                }
              }

              if (isset($_POST['ambil_intervensi'])) {
                $jumlahDipilihAmbilIntervensi = count((array)$_POST['ambil_intervensi'][$i]);
                for ($b = 0; $jumlahDipilihAmbilIntervensi > $b; $b++) {
                  $modRencana = PIRencanakeperawatanM::model()->findByPk($_POST['ambil_intervensi'][$i][$b]);
                  $modPlanning[$i][$b] = new PIPlaningaskepT();
                  $modPlanning[$i][$b]->asuhankeperawatan_id = $modAsuhanKeperawatan[$i]->asuhankeperawatan_id;
                  if ($modRencana->iskolaborasiintervensi == true) {
                    $modPlanning[$i][$b]->kolaborasilanjutan = $modRencana->rencana_intervensi;
                  } else {
                    $modPlanning[$i][$b]->intervensilanjutan = $modRencana->rencana_intervensi;
                  }

                  if ($modPlanning[$i][$b]->validate()) {
                    if ($modPlanning[$i][$b]->save()) {
                      $successPlanning = true;
                      $jumlahPlanning++;
                    }
                  }
                }
              }
              if (isset($_POST['rencana_implementasi'])) {
                $jumlahDipilihImplementasi = count((array)$_POST['rencana_implementasi'][$i]);
                for ($b = 0; $jumlahDipilihImplementasi > $b; $b++) {
                  $modelImplementasi = ImplementasikeperawatanM::model()->findByPk($_POST['rencana_implementasi'][$i][$b]);
                  $modImplementasi[$i][$b] = new PIImplementasiaskepT();
                  $modImplementasi[$i][$b]->asuhankeperawatan_id = $modAsuhanKeperawatan[$i]->asuhankeperawatan_id;
                  $modImplementasi[$i][$b]->implementasikeperawatan_id = $_POST['rencana_implementasi'][$i][$b];
                  $modImplementasi[$i][$b]->tglmulaiimplementasi = $modAsuhanKeperawatan[$i]->tglaskep;
                  $modImplementasi[$i][$b]->implementasi_nama = $modelImplementasi->implementasi_nama;
                  $modImplementasi[$i][$b]->iskolaborasi = $modelImplementasi->iskolaborasiimplementasi;
                  if ($modImplementasi[$i][$b]->validate()) {
                    if ($modImplementasi[$i][$b]->save()) {
                      $successImplementasi = true;
                      $jumlahImplementasi++;
                    }
                  }
                }
              }
            }
          }
        }
        $jumlahDipilihImplementasi = 0;
        $jumlahDipilihAmbilIntervensi = 0;
        $jumlahDipilihRencanaIntervensi = 0;
        if ($jumlahImplementasi > 0 && $jumlahDipilihImplementasi > 0 && $jumlahImplementasi != $jumlahDipilihImplementasi)
          $successImplementasi = false;
        if ($jumlahPlanning > 0 && $jumlahDipilihAmbilIntervensi > 0 && $jumlahPlanning != $jumlahDipilihAmbilIntervensi)
          $successPlanning = false;
        if ($jumlahIntervensi > 0 && $jumlahDipilihRencanaIntervensi > 0 && $jumlahIntervensi != $jumlahDipilihRencanaIntervensi)
          $successIntervensi = false;
        if ($jumlahDipilihImplementasi == 0)
          $successImplementasi = true;
        if ($jumlahDipilihAmbilIntervensi == 0)
          $successPlanning = true;
        if ($jumlahDipilihRencanaIntervensi == 0)
          $successIntervensi = true;

        if ($success && $successPlanning && $successImplementasi && $successIntervensi && $successPengkajian) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Asuhan Keperawatan berhasil disimpan");
          $this->redirect(array('index', array('sukses' => 1)));
          //                    $this->refresh();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $exc) {

        echo '<pre>'; var_dump($exc); die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'modPasien' => $modPasien, 'modPasienPIV' => $modPasienPIV,
      'modAnamnesa' => $modAnamnesa,
      'modPeriksaFisik' => $modPeriksaFisik,
      'modPengkajian' => $modPengkajian,
      'model' => $model,
    ));
  }

  public function actionRiwayatAsuhan()
  {
    $this->layout = '//layouts/iframe';
    $this->render(
      $this->path_view . '_riwayatAsuhanKeperawatan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modDiagnosaKeperawatanSearch' => $modDiagnosaKeperawatanSearch,
      )
    );
  }


  	
	public function actionLoadRiwayatAnemnesa() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$rows = "";
			$loadRiwayat = ASAnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']), array('order' => 'tglanamnesis DESC'));

			if (count($loadRiwayat) > 0) {
				foreach ($loadRiwayat AS $i => $modRiwayatAnemnesa) {
					$rows .= $this->renderPartial($this->path_view . "_rowRiwayatAnemnesa", array('modRiwayatAnemnesa' => $modRiwayatAnemnesa), true);
				}
			}
			echo CJSON::encode(array(
				'rows' => $rows));
		}
		Yii::app()->end();
	}

	public function actionLoadRiwayatPeriksaFisik() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$rows = "";
			$loadRiwayat = ASPemeriksaanfisikT::model()->findAllByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']), array('order' => 'tglperiksafisik DESC'));
			if (count($loadRiwayat) > 0) {
				foreach ($loadRiwayat AS $i => $modRiwayatPeriksaFisik) {
					$rows .= $this->renderPartial($this->path_view . "_rowRiwayatPemeriksaanFisik", array('modRiwayatPeriksaFisik' => $modRiwayatPeriksaFisik), true);
				}
			}
			echo CJSON::encode(array(
				'rows' => $rows));
		}
		Yii::app()->end();
	}

  public function actionDetailDiagnosaKeperawatan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PIPendaftaranT::model()->findByPk($id);
    $modDiagnosaKeperawatanSearch = new PIAsuhankeperawatanT('search');
    $this->render(
      $this->path_view . '_diagnosa',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modDiagnosaKeperawatanSearch' => $modDiagnosaKeperawatanSearch,
      )
    );
  }

  public function actionDetailRencanaKeperawatan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PIPendaftaranT::model()->findByPk($id);
    //$modDiagnosaKeperawatanSearch = PIAsuhankeperawatanT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
    $modDiagnosaKeperawatanSearch = new PIAsuhankeperawatanT('search');
    $this->render(
      $this->path_view . '_rencana',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modDiagnosaKeperawatanSearch' => $modDiagnosaKeperawatanSearch,
      )
    );
  }

  public function actionDetailEvaluasiKeperawatan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PIPendaftaranT::model()->findByPk($id);
    //$modDiagnosaKeperawatanSearch = PIAsuhankeperawatanT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
    $modDiagnosaKeperawatanSearch = new PIAsuhankeperawatanT('search');
    $this->render(
      $this->path_view . '_evaluasi',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modDiagnosaKeperawatanSearch' => $modDiagnosaKeperawatanSearch,
      )
    );
  }

  public function actionDetailPlanningKeperawatan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PIPendaftaranT::model()->findByPk($id);
    //$modDiagnosaKeperawatanSearch = PIAsuhankeperawatanT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
    $modDiagnosaKeperawatanSearch = new PIAsuhankeperawatanT('search');
    $this->render(
      $this->path_view . '_planning',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modDiagnosaKeperawatanSearch' => $modDiagnosaKeperawatanSearch,
      )
    );
  }

  public function actionGetRiwayatPasien($id)
  {
    $this->layout = '//layouts/iframe';
    $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : $id;
    $modPendaftaran = PIPendaftaranT::model()->findByPk($pendaftaran_id);
    $noRekamMedik = PIPasienM::model()->findByPk($modPendaftaran->pasien_id)->no_rekam_medik;

    $criteria = new CDbCriteria(array(
      'condition' => "no_rekam_medik ='" . $noRekamMedik . "' and ruangan_id =" . Yii::app()->user->getState('ruangan_id'),
      'order' => 'tgl_pendaftaran DESC',
    ));

    $pages = new CPagination(InfokunjunganrjV::model()->count($criteria));
    $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
    $pages->applyLimit($criteria);
    $modKunjungan = InfokunjunganriV::model()->findAll($criteria);
    $tr = '';

    foreach ($modKunjungan as $row) {
      $modPendaftaran = PendaftaranT::model()->findByPk($row->pendaftaran_id);
      $modAnamnesa = AnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'pasien_id' => $modPendaftaran->pasien_id));
      $diagnosa = PasienmorbiditasT::model()->with('diagnosa')->findByAttributes(array('pasien_id' => $row->pasien_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA));
      $asuhan = AsuhankeperawatanT::model()->findByAttributes(array('pasien_id' => $row->pasien_id, 'pendaftaran_id' => $row->pendaftaran_id, 'ruangan_id' =>  Yii::app()->user->getState('ruangan_id')), array('order' => 'tglaskep DESC'));
      $tr .= "<tr>
                            <td>" . $row->tgl_pendaftaran . '<br/>' . $row->no_pendaftaran . "</td>
                            <td>" . (isset($modAnamnesa->keluhanutama) ? $modAnamnesa->keluhanutama : "") . "</td>
                            <td>" . (isset($modAnamnesa->riwayatpenyakitterdahulu) ? $modAnamnesa->riwayatpenyakitterdahulu : "") . "</td>
                            <td>" . (isset($modPendaftaran->pemeriksaanfisikTs->tekanandarah) ? $modPendaftaran->pemeriksaanfisikTs->tekanandarah : "") . "</td>
                            <td>" . (isset($modPendaftaran->pemeriksaanfisikTs->detaknadi) ? $modPendaftaran->pemeriksaanfisikTs->detaknadi : "") . "</td>
                            <td>" . (isset($modPendaftaran->pemeriksaanfisikTs->suhutubuh) ? $modPendaftaran->pemeriksaanfisikTs->suhutubuh : "") . "</td>
                            <td>" . (isset($modPendaftaran->pemeriksaanfisikTs->tinggibadan_cm) ? $modPendaftaran->pemeriksaanfisikTs->tinggibadan_cm : "") . "<br/>" . (isset($modPendaftaran->pemeriksaanfisikTs->beratbadan_kg) ? $modPendaftaran->pemeriksaanfisikTs->beratbadan_kg : "") . "</td>
                            <td>" . (isset($diagnosa->diagnosa->diagnosa_nama) ? $diagnosa->diagnosa->diagnosa_nama : "") . "</td>
                            <td>" . (isset($asuhan->tglaskep) ? $asuhan->tglaskep : "") . "</td>
                            <td>" . CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl(
        "AsuhanKeperawatan/detailDiagnosaKeperawatan",
        array("id" => $row->pendaftaran_id)
      ), array("id" => "$row->no_pendaftaran", "target" => "detailData2", "rel" => "tooltip", "title" => "Klik untuk Detail Diagnosa Keperawatan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData2').text(text);window.parent.$('#dialogDetailData2').dialog('open');", "dialog-text" => "Detail Diagnosa Keperawatan")) . "</td>
                            <td>" . CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl(
        "AsuhanKeperawatan/detailRencanaKeperawatan",
        array("id" => $row->pendaftaran_id)
      ), array("id" => "$row->no_pendaftaran", "target" => "detailData2", "rel" => "tooltip", "title" => "Klik untuk Detail Rencana Keperawatan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData2').text(text);window.parent.$('#dialogDetailData2').dialog('open');", "dialog-text" => "Detail Rencana Keperawatan")) . "</td>
                            <td>" . CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl(
        "AsuhanKeperawatan/detailEvaluasiKeperawatan",
        array("id" => $row->pendaftaran_id)
      ), array("id" => "$row->no_pendaftaran", "target" => "detailData2", "rel" => "tooltip", "title" => "Klik untuk Detail Evaluasi Keperawatan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData2').text(text);window.parent.$('#dialogDetailData2').dialog('open');", "dialog-text" => "Detail Evaluasi Keperawatan")) . "</td>
                            <td>" . CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl(
        "AsuhanKeperawatan/detailPlanningKeperawatan",
        array("id" => $row->pendaftaran_id)
      ), array("id" => "$row->no_pendaftaran", "target" => "detailData2", "rel" => "tooltip", "title" => "Klik untuk Detail Planning Keperawatan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData2').text(text);window.parent.$('#dialogDetailData2').dialog('open');", "dialog-text" => "Detail Planning Keperawatan")) . "</td>                                    
                         </tr>";
    }

    //             if (Yii::app()->request->isAjaxRequest)
    //            {
    //                echo CJSON::encode(array(
    //                    'status'=>'create_form', 
    //                    'div'=>$this->renderPartial('_riwayatAsuhanKeperawatan', array('tr'=>$tr, 'pages'=>$pages), true)));
    //                exit;              
    //            }

    $this->render(
      $this->path_view . '_riwayatAsuhanKeperawatan',
      array(
        'tr' => $tr,
        'pages' => $pages
      )
    );
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new PIAsuhankeperawatanT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['PIAsuhankeperawatanT']))
      $model->attributes = $_GET['PIAsuhankeperawatanT'];

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = PIAsuhankeperawatanT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'rjasuhankeperawatan-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $model = new PIAsuhankeperawatanT;
    $model->attributes = $_REQUEST['PIAsuhankeperawatanT'];
    $judulLaporan = 'Data PIAsuhankeperawatanT';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PPINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->session['ukuran_kertas'];                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->session['posisi_kertas'];                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionGetDiagnosaKeperawatan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $diagnosakeperawatan_id = (isset($_POST['idDiagnosaKeperawatan']) ? $_POST['idDiagnosaKeperawatan'] : null);
      $modDiagnosaKeperawatan = DiagnosakepM::model()->findByPk($diagnosakeperawatan_id);
      $diagnosakep_id = $diagnosakeperawatan_id;
      // $modRencana = RencanakeperawatanM::model()->findAllByAttributes(array('diagnosakeperawatan_id' => $modDiagnosaKeperawatan->diagnosakeperawatan_id));
      // $modImplementasi = ImplementasikeperawatanM::model()->findAllByAttributes(array('diagnosakeperawatan_id' => $modDiagnosaKeperawatan->diagnosakeperawatan_id));
      $data1 = '';
      $data2 = '';
      $tr = $tr2 = $tr3 = '';
      // if (count((array)$modRencana) > 0) {
      //   $data1 .= '<ul id="intervensi">';
      //   foreach ($modRencana as $row) {
      //     if (empty($row->iskolaborasiintervensi)) {
      //       $row->iskolaborasiintervensi = 0;
      //     }
      //     $data1 .= '<li>' . CHtml::checkBox('rencana_intervensi[][]', false, array('value' => $row->rencanakeperawatan_id, 'onclick' => 'submitIntervensi(this);', 'class' => 'intervensi_check', 'textData' => $row->rencana_intervensi, 'valuedata' => $row->rencanakeperawatan_id, 'kolaborasi' => $row->iskolaborasiintervensi, 'value' => $row->rencanakeperawatan_id)) . '<span>' . $row->rencana_intervensi . '</span></li>';
      //   }
      //   $data1 .= '</ul>';
      // }
      // if (count((array)$modImplementasi) > 0) {
      //   $data2 .= '<ul id="implementasi">';
      //   foreach ($modImplementasi as $row) {
      //     $data2 .= '<li>' . CHtml::checkBox('rencana_implementasi[][]', false, array('onclick' => 'warnai(this)', 'class' => 'implementasi_check', 'textData' => $row->implementasi_nama, 'valueData' => $row->implementasikeperawatan_id, 'value' => $row->implementasikeperawatan_id)) . '<span>' . $row->implementasi_nama . '</span></li>';
      //   }
      //   $data2 .= '</ul>';
      // }

      $modDet = new RencanaaskepdetT;
      $cekIntervensiUtama = IntervensiM::model()->findByAttributes(array('diagnosakep_id'=>$diagnosakep_id, 'intervensi_nama' => 'Intervensi Utama'));
      $countUtama = 0;

      $intv = '';
      
      if(!empty($cekIntervensiUtama)){
          $intv .=  '<b>Intervensi Utama</b><br>';
          $intUtama = IntervensidetM::model()->findAllByAttributes(
              array('intervensidet_aktif' => true, 'intervensi_id' => $cekIntervensiUtama->intervensi_id));
          $intv .=  CHtml::activeHiddenField($modDet, '[0]intervensi_id', array('value' => $cekIntervensiUtama->intervensi_id));
          $intv .=  CHtml::activeCheckBoxList($modDet, '[0]intervensidet_id', CHtml::listData($intUtama, 'intervensidet_id', 'intervensidet_indikator'), (array('style' => 'float: left', 'onkeyup' => "return $(this).focusNextInputField(event);", 'class'=>'intervensinya', 'onclick'=>'setTindakan(this)')));
          $countUtama = count($intUtama);
      }
      $cekIntervensiPendukung = IntervensiM::model()->findByAttributes(array('diagnosakep_id'=>$diagnosakep_id, 'intervensi_nama' => 'Intervensi Pendukung'));
      if (!empty($cekIntervensiPendukung)) {
          $intv .=  '<br><b>Intervensi&nbsp;Pendukung</b><br>';
          $intDet = IntervensidetM::model()->findAllByAttributes(array('intervensidet_aktif' => true, 'intervensi_id' => $cekIntervensiPendukung->intervensi_id));
          $ii = $countUtama;
          foreach($intDet as $det){
              $intv .=  CHtml::activeCheckBox($modDet, '[0]intervensidet_id['.$ii.']', array('value'=>$det->intervensidet_id,'style' => 'float: left', 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'intervensinya', 'onclick' => 'setTindakan(this)')).'<label>'.$det->intervensidet_indikator.'</label><br>';
              $ii++;
          }
      }

      if (!empty($modDiagnosaKeperawatan)) {
        $model = new AsuhankeperawatanT;
        $tr .= "<tr class='tindakan_" . $diagnosakeperawatan_id . "'>
                                <td><div class='input-append'>
                                    " . CHtml::textField('nama_diagnosa', $modDiagnosaKeperawatan->diagnosakep_nama, array('class' => 'span2 diagnosakep_tr1', 'readOnly' => true)) . "
                                <span class='add-on'><i class='icon-list-alt'></i></span></div>
                                    " . CHtml::activeHiddenField($model, 'diagnosakeperawatan_id[]', array('value' => $diagnosakeperawatan_id, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "
                                    " . CHtml::hiddenField('urutan[]', '', array('class' => 'span2 urutan', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "
                                </td>
                                <td class='intervensi'>" . $data1 . $intv . "</td>
                                <td class='tindakannya'>" . $data2 . "<div id='table-tindakannya'></div>" . "</td>                            
                            </tr>
                            ";
        //<td>".CHtml::activeDropDownList($model, 'evaluasi_assesment[]', CHtml::listData($models, $valueField, $textField), $htmlOptions)($model, 'evaluasi_obbjektif', array('cols'=>3, 'rows=>2', 'class'=>'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
        $tr2 .= "<tr>
                                <td width='160px'><div class='input-append'>
                                    " . CHtml::textField('nama_diagnosa', $modDiagnosaKeperawatan->diagnosakep_nama, array('class' => 'span2', 'readOnly' => true)) . "
                                <span class='add-on'><i class='icon-list-alt'></i></span></div>
                                    " . CHtml::activeHiddenField($model, 'diagnosa_id[]', array('value' => $modDiagnosaKeperawatan->diagnosakep_id, 'class' => 'span2 urutan', 'onkeypress' => "return $(this).focusNextInputField(event)")) .
          CHtml::hiddenField('urutan[]', '', array('class' => 'span2 urutan', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>" . CHtml::activeTextArea($model, 'evaluasi_subjektif[]', array('cols' => 3, 'rows=>2', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>" . CHtml::activeTextArea($model, 'evaluasi_objektif[]', array('cols' => 3, 'rows=>2', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>" . CHtml::activeDropDownList($model, 'evaluasi_assesment[]', LookupM::getItems('evaluasi_assesment'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>" . CHtml::activeTextArea($model, 'askep_tujuan[]', array('cols' => 3, 'rows=>2', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>                               
                                <td>" . CHtml::activeTextArea($model, 'askep_kriteriahasil[]', array('cols' => 3, 'rows=>2', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            </tr>";
        $tr3 .= "<tr class='tindakantr3_" . $diagnosakeperawatan_id . "'>

                                <td width='160px'><div class='input-append'>
                                    " . CHtml::textField('nama_diagnosa', $modDiagnosaKeperawatan->diagnosakep_nama, array('class' => 'span2 diagnosa-tr3', 'readOnly' => true)) . "
                                <span class='add-on'><i class='icon-list-alt'></i></span></div>
                                                  " . CHtml::hiddenField('urutan[]', '', array('class' => 'span2 urutan', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                                <td>
                                <table class='block'>
                                    <tr>
                                      <td>
                                        <div class='intv-checked-tr3'></div>
                                      </td>    
                                    </tr>
                              </table>
                              </td>
                            </tr>
                                ";
      }
      $data['tr'] = $tr;
      $data['tr2'] = $tr2;
      $data['tr3'] = $tr3;
      //           $data['jam']=$jam;
      $data['id'] = $diagnosakeperawatan_id;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetDataAnamnesaFisik()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $dataPasienArray = array();

      $modPendaftatan = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($modPendaftatan->pasien_id);
      $diagnosa = PasienmorbiditasT::model()->with('diagnosa')->findByAttributes(array('ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'pasien_id' => $modPasien->pasien_id));
      $anamnesa = AnamnesaT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id), array('order' => 'tglanamnesis DESC', 'limit' => 1));
      $keluhanutama = null;
      $keluhantambahan = null;
      $riwayatpenyakitterdahulu = null;
      $riwayatpenyakitkeluarga = null;
      if (count((array)$anamnesa) > 0) {
        foreach ($anamnesa as $anamnesa) {
          $keluhanutama = $anamnesa->keluhanutama;
          $keluhantambahan = $anamnesa->keluhantambahan;
          $riwayatpenyakitterdahulu = $anamnesa->riwayatpenyakitterdahulu;
          $riwayatpenyakitkeluarga = $anamnesa->riwayatpenyakitkeluarga;
        }
      }
      $periksaFisik = PemeriksaanfisikT::model()->with('pegawai')->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id), array('order' => 'tglperiksafisik DESC', 'limit' => 1));
      if (count((array)$periksaFisik) > 0) {
        foreach ($periksaFisik as $periksaFisik) {
          $tekanandarah = $periksaFisik->tekanandarah;
          $detaknadi = $periksaFisik->detaknadi;
          $suhutubuh = $periksaFisik->suhutubuh;
          $beratbadan = $periksaFisik->beratbadan_kg;
          $tinggibadan = $periksaFisik->tinggibadan_cm;
          $pernapasan = $periksaFisik->pernapasan;
          $pegawai = $periksaFisik->pegawai->nama_pegawai;
          $kelainanpadabagtubuh = $periksaFisik->kelainanpadabagtubuh;
          $meanarteripressure = $periksaFisik->meanarteripressure;
          $gcs_eye = $periksaFisik->gcs_eye;
          $gcs_motorik = $periksaFisik->gcs_motorik;
          $gcs_verbal = $periksaFisik->gcs_verbal;
        }
      }


      $dataPasienArray["diagnosa"] = ((isset($diagnosa->diagnosa)) ? $diagnosa->diagnosa->diagnosa_nama : null);
      $dataPasienArray["diagnosa_id"] = ((isset($diagnosa->diagnosa_id)) ? $diagnosa->diagnosa_id : null);
      $dataPasienArray["keluhanutama"] = $keluhanutama;
      $dataPasienArray["keluhantambahan"] = $keluhantambahan;
      $dataPasienArray["riwayatpenyakitterdahulu"] = $riwayatpenyakitterdahulu;
      $dataPasienArray["riwayatpenyakitkeluarga"] = $riwayatpenyakitkeluarga;
      $dataPasienArray["tekanandarah"] = $tekanandarah;
      $dataPasienArray["pegawai"] = $pegawai;
      $dataPasienArray["detaknadi"] = $detaknadi;
      $dataPasienArray["suhutubuh"] = $suhutubuh;
      $dataPasienArray["tinggibadan"] = $tinggibadan;
      $dataPasienArray["beratbadan"] = $beratbadan;
      $dataPasienArray["pernapasan"] = $pernapasan;
      $dataPasienArray["kelainanpadabagtubuh"] = $kelainanpadabagtubuh;
      $dataPasienArray["meanarteripressure"] = $meanarteripressure;
      $dataPasienArray["gcs"] = $gcs_eye + $gcs_motorik + $gcs_verbal;
      $dataPasienArray["usia"] = substr($modPendaftatan->umur, 0, 2);

      echo json_encode($dataPasienArray);
      Yii::app()->end();
    }
  }
}