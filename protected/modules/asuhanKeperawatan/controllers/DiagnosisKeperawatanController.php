<?php

/**
 * Transaksi Diagnosa Askep
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage controllers
 */
class DiagnosisKeperawatanController extends MyAuthController {

    protected $successSave = true;
    public $path_view = "asuhanKeperawatan.views.diagnosisKeperawatan.";

    /**
     * Load halaman transaksi diagnosis keperawatan
     */
    public function actionIndex() {
        if (isset($_GET['frame'])) {
            $this->layout = "//layouts/iframe";
        }
        $model = new ASDiagnosisaskepT;
        $modDetail = new ASDiagnosisaskepdetT;
        $modPilih = new ASPilihdiagnosisaskepT;
        $modPengkajian = new ASPengkajianaskepT;
        $modPasien = new ASInfopengkajianaskepV;
        $model->no_diagnosisaskep = "- Otomatis -";
        $model->diagnosisaskep_tgl = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $cekPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->pegawai_id = !empty($cekPegawai->pegawai_id) ? $cekPegawai->pegawai_id : '';
        $model->nama_pegawai = !empty($cekPegawai->nama_pegawai) ? $cekPegawai->nama_pegawai : '';

        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;

        $url_batal = Yii::app()->createAbsoluteUrl(
                Yii::app()->controller->module->id . '/' . Yii::app()->controller->id
        );
        $successSave = false;

        if (isset($_GET['diagnosisaskep_id'])) {
            $model = ASDiagnosisaskepT::model()->findByPk($_GET['diagnosisaskep_id']);

            $modPengkajian = ASPengkajianaskepT::model()->findBySql('SELECT pengkajianaskep_t.*,pegawai.nama_pegawai 
			FROM pengkajianaskep_t
			JOIN pegawai_m AS pegawai ON pegawai.pegawai_id = pengkajianaskep_t.pegawai_id
			WHERE pengkajianaskep_id =' . $model->pengkajianaskep_id);
            if ($modPengkajian->iskeperawatan == 1) {
                $modPasien = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
            }
            if ($modPengkajian->iskeperawatan == 0) {
                $modPasien = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
            }
        }

        if (isset($_POST['ASDiagnosisaskepT']) && !empty($_POST['ASPengkajianaskepT']['pengkajianaskep_id'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model = $this->saveRencana($_POST['ASDiagnosisaskepT'], $_POST['ASPengkajianaskepT']);
                if (isset($_POST['ASDiagnosisaskepdetT'])) {
                    $modRencanaDetail = $this->saveRencanaDetail($_POST['ASDiagnosisaskepdetT'], $model);
                }

                $successSave = $this->successSave;

                if ($successSave) {
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $transaction->commit();
                    $this->redirect(array('index', 'status' => 1, 'diagnosisaskep_id' => $model->diagnosisaskep_id, 'iskeperawatan' => $modPengkajian->iskeperawatan));
                } else {
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                    $transaction->rollback();
                }
            } catch (Exception $exc) {
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                $transaction->rollback();
            }
        }

        $this->render('index', array(
            'model' => $model,
            'modDetail' => $modDetail,
            'modPilih' => $modPilih,
            'modPengkajian' => $modPengkajian,
            'modPasien' => $modPasien,
            'successSave' => $successSave,
            'url_batal' => $url_batal
                )
        );
    }

    /**
     * Digunakan untuk mengecek pengkajian
     * @param type $pengkajianaskep_id
     */
    public function actionCekPengkajianId($pengkajianaskep_id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data = '';
            if (isset($pengkajianaskep_id)) {
                $data = ASDiagnosisaskepT::model()->findByAttributes(array('pengkajianaskep_id' => $pengkajianaskep_id));
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    /**
     * Digunakan untuk load data pasien
     * @param type $pengkajianaskep_id
     * @param type $iskeperawatan
     */
    public function actionLoadPasien($pengkajianaskep_id, $iskeperawatan) {
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            if (isset($pengkajianaskep_id)) {
                if ($iskeperawatan == 0) {
                    $data['iskeperawatan'] = 1;
                    $modaskep = new CDbCriteria();
                    $modaskep->select = "d.diagnosa_nama as diagnosa,*";
                    $modaskep->join = " LEFT JOIN diagnosa_m d ON d.diagnosa_id = t.diagnosa_id ";
                    $modaskep->addCondition('pengkajianaskep_id=' . $pengkajianaskep_id);
                    $modaskepkajian = ASInfopengkajianaskepV::model()->find($modaskep);

                    $data['data'] = $modaskepkajian;
                    $data['diagnosa'] = isset($modaskepkajian->diagnosa) ? $modaskepkajian->diagnosa : "";
                }
                if ($iskeperawatan == 1) {
                    $data['iskeperawatan'] = 0;
                    $data['data'] = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $pengkajianaskep_id));
                }
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    /**
     * Digunakan untuk menyimpan data diagnosis keperawatan
     * @param type $post
     * @param type $pengkajianaskep
     * @return \ASDiagnosisaskepT
     */
    protected function saveRencana($post, $pengkajianaskep) {

        $modRencana = new ASDiagnosisaskepT;
        $modRencana->attributes = $post;
        $modRencana->no_diagnosisaskep = MyGenerator::noDiagnosisKeperawatan();
        $modRencana->diagnosisaskep_tgl = MyFormatter::FormatDateTimeForDb($post['diagnosisaskep_tgl']);
        $modRencana->pengkajianaskep_id = $pengkajianaskep['pengkajianaskep_id'];
        $modRencana->create_ruangan_id = Yii::app()->user->ruangan_id;
        $modRencana->create_time = date('Y-m-d');
        $modRencana->create_loginpemakai_id = Yii::app()->user->id;
        $modRencana->ruangan_id = Yii::app()->user->ruangan_id;
        $modRencana->pegawai_id = $post['pegawai_id'];
        if ($modRencana->validate()) {
            $modRencana->save();
            $this->successSave = $this->successSave && true;
        } else {
            $this->successSave = false;
        }

        return $modRencana;
    }

    /**
     * Digunakan untuk menyimpan data detail diagnosis keperawatan
     * @param type $post
     * @param type $diagnosisaskep
     * @return \ASPilihdiagnosisaskepT
     */
    public function saveRencanaDetail($post, $diagnosisaskep) {
        foreach ($post as $s => $row) {
            $modRencanaDetail = new ASDiagnosisaskepdetT;
            $modRencanaDetail->attributes = $row;
            $modRencanaDetail->diagnosisaskep_id = $diagnosisaskep->diagnosisaskep_id;
            $modRencanaDetail->hasildiagnosa_id = $row['diagnosisaskep_id'];
            $modRencanaDetail->iskolaborasi = true;
            if ($modRencanaDetail->validate()) {
                $modRencanaDetail->save();

                if (isset($_POST['ASPilihdiagnosisaskepT'])) {
                    foreach ($_POST['ASPilihdiagnosisaskepT'] as $i => $row2) {
                        if ($s == $i) {
                            $diagnosa = $modRencanaDetail->diagnosisaskepdet_id;
                            if (!empty($row2['kelompoktandagejaladaftar_id'])) {
                                foreach ($row2['kelompoktandagejaladaftar_id'] as $ii => $val) {
                                    if ($val != 0) {
                                        $cekTandagejala = TandagejalaM::model()->findByAttributes(array('kelompoktandagejaladaftar_id' => $val, 'diagnosakep_id' => $row['diagnosisaskep_id']));
                                        if(!empty($cekTandagejala)){
                                            $modRencanaDetail = new ASPilihdiagnosisaskepT;
                                            $modRencanaDetail->diagnosisaskepdet_id = $diagnosa;
                                            $modRencanaDetail->tandagejala_id = $cekTandagejala->tandagejala_id;
                                            if ($modRencanaDetail->validate()) {
                                                $modRencanaDetail->save();
                                                $this->successSave = $this->successSave && true;
                                            } else {
                                                $this->successSave = false;
                                            }
                                        }
                                    }
                                }
                            }
                            if (!empty($row2['kelompokfaktorrisikodaftar_id'])) {
                                foreach ($row2['kelompokfaktorrisikodaftar_id'] as $iii => $val2) {
                                    if ($val2 != 0) {
                                        $cekFaktorRisiko = FaktorrisikoM::model()->findByAttributes(array('kelompokfaktorrisikodaftar_id' => $val2, 'diagnosakep_id' => $row['diagnosisaskep_id']));
                                        if(!empty($cekFaktorRisiko)){
                                            $modRencanaDetail = new ASPilihdiagnosisaskepT;
                                            $modRencanaDetail->diagnosisaskepdet_id = $diagnosa;
                                            $modRencanaDetail->faktorrisiko_id = $cekFaktorRisiko->faktorrisiko_id;
                                            if ($modRencanaDetail->validate()) {
                                                $modRencanaDetail->save();
                                                $this->successSave = $this->successSave && true;
                                            } else {
                                                $this->successSave = false;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $this->successSave = $this->successSave && true;
            } else {
                $this->successSave = false;
            }
        }
        return $modRencanaDetail;
    }

    /**
     * Digunakan untuk mencetak data
     */
    public function actionPrint() {
        $model = ASDiagnosisaskepT::model()->findByPk($_REQUEST['diagnosisaskep_id']);
        $model->attributes = $model;
        $modPengkajian = ASPengkajianaskepT::model()->findByPk($model->pengkajianaskep_id);

        if ($modPengkajian->iskeperawatan == 1) {
            $modPasien = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
        }
        if ($modPengkajian->iskeperawatan == 0) {
            $modPasien = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
        }

        $modDetail = new ASDiagnosisaskepdetT;
        $judulLaporan = 'Rencana Keperawatan';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    /**
     * Digunakan untuk mendapatkan data penunjang
     * @param type $pengkajianaskep_id
     */
    public function actionGetPenunjang($pengkajianaskep_id) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $penunjang = ASDatapenunjangT::model()->findAllByAttributes(array('pengkajianaskep_id' => $pengkajianaskep_id));
            $data['form'] = "";

            if (count($penunjang) > 0) {
                foreach ($penunjang AS $i => $modPenunjang) {
                    $data['form'] .= $this->renderPartial($this->path_view . '_rowPenunjang', array('modPenunjang' => $modPenunjang), true);
                }
            } else {
                $data['form'] .= $this->renderPartial($this->path_view . '_rowPenunjang', array('modPenunjang' => $modPenunjang), true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * action ajax select tindakan ke form
     */
    public function actionGetDiagnosa() {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            $returnVal = array();

            $criteria = new CDbCriteria();
            if (isset($_GET['diagnosakep_id'])) {
                if (!empty($_GET['diagnosakep_id'])) {
                    $criteria->addCondition("diagnosakep_id = " . $_GET['diagnosakep_id']);
                }
            }
            $criteria->order = 'diagnosakep_nama';
            $models = ASDiagnosakepM::model()->findAll($criteria);
            if (isset($models)) {

                foreach ($models as $i => $model) {
                    $attributes = $model->attributeNames();

                    foreach ($attributes as $j => $attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }

                    $returnVal[$i]['label'] = $model->diagnosakep_nama;
                    $returnVal[$i]['value'] = $model->diagnosakep_id;
                }
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Digunakan untuk mendapatkan data diagnosa
     * @param type $diagnosakep_id
     */
    public function actionGetDiagnosaRow($diagnosakep_id = null) {
        if (Yii::app()->request->isAjaxRequest) {
            $modRencanaDet = new ASDiagnosisaskepdetT;
            $data['form'] = "";
            $diagnosa = ASDiagnosakepM::model()->findByPk($diagnosakep_id);
            $data['form'] .= "<div class='diagdetail'>";
            $data['form'] .= "<br>";
            $data['form'] .= '<strong>Penyebab</strong>';
            $data['form'] .= "<br>";
            $bk_head = BataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id));
            if (count($bk_head)) {
                foreach ($bk_head as $i => $bk) {
                    $data['form'] .= "<ul class='spasi1'>";
                    $data['form'] .= '<li ><b>' . $bk->bataskarakteristik_nama . '</b></li>';
                    $data['form'] .= "<ul class='spasi2'>";
                    $bk_tail = BataskarakteristikdetM::model()->findAllByAttributes(array('bataskarakteristikdet_aktif' => true, 'bataskarakteristik_id' => $bk->bataskarakteristik_id));
                    if (count($bk_tail)) {
                        foreach ($bk_tail as $i => $bkd) {
                            $data['form'] .= '<li >' . $bkd->bataskarakteristikdet_indikator . '</li>';
                        }
                    } else {
                        $data['form'] .= "<ul class='spasi1'>";
                        $data['form'] .= '<li> Data tidak ditemukan. </li>';
                        $data['form'] .= "</ul>";
                    }
                    $data['form'] .= "</ul>";
                    $data['form'] .= "</ul>";
                }
            } else {
                $data['form'] .= "<ul class='spasi1'>";
                $data['form'] .= '<li> Data tidak ditemukan. </li>';
                $data['form'] .= "</ul>";
            }

            $data['form'] .= "<br>";

            $data['form'] .= '<strong>Kondisi Klinis Terkait</strong>';
            $data['form'] .= "<br>";
            $bk_head = FaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id));
            if (count($bk_head)) {
                foreach ($bk_head as $i => $bk) {
                    $data['form'] .= "<ul class='spasi1'>";
                    $data['form'] .= '<li ><b>' . $bk->faktorhub_nama . '</b></li>';
                    $data['form'] .= "<ul class='spasi2'>";
                    $bk_tail = FaktorhubdetM::model()->findAllByAttributes(array('faktorhubdet_aktif' => true, 'faktorhub_id' => $bk->faktorhub_id));
                    if (count($bk_tail)) {
                        foreach ($bk_tail as $i => $bkd) {
                            $data['form'] .= '<li >' . $bkd->faktorhubdet_indikator . '</li>';
                        }
                    } else {
                        $data['form'] .= "<ul class='spasi1'>";
                        $data['form'] .= '<li> Data tidak ditemukan. </li>';
                        $data['form'] .= "</ul>";
                    }
                    $data['form'] .= "</ul>";
                    $data['form'] .= "</ul>";
                }
            } else {
                $data['form'] .= "<ul class='spasi1'>";
                $data['form'] .= '<li> Data tidak ditemukan. </li>';
                $data['form'] .= "</ul>";
            }
            $data['form'] .= "</div>";
        }
        echo CJSON::encode($data);
        Yii::app()->end();
    }

    /**
     * Digunakan untuk menampilkan data detail pengkajian
     * @param type $pengkajianaskep_id
     */
    public function actionDetailPengkajian($pengkajianaskep_id = null) {
        $this->layout = "//layouts/iframe";

        $modPengkajian = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $pengkajianaskep_id));

        $modAwalKritis = null;
        $modAwalKeperawatan = null;
        $modAwalKebidanan = null;
        $modAwalMedis = null;
        if (!empty($modPengkajian->asesmen_awal_medis_id)) {
            $modAwalMedis = AsesmenAwalMedisT::model()->findByPk($modPengkajian->asesmen_awal_medis_id);
        }
        if ($modPengkajian->instalasi_id == Params::INSTALASI_ID_ICU) {
            if (!empty($modPengkajian->asesmenawalkritis_id)) {
                $modAwalKritis = AsesmenawalkritisT::model()->findByPk($modPengkajian->asesmenawalkritis_id);
            }
        } else if ($modPengkajian->ruangan_id == Params::RUANGAN_ID_VK) {
            if (!empty($modPengkajian->asesmenawalkebidanan_bidan_id)) {
                $modAwalKebidanan = AsesmenawalkebidananBidanT::model()->findByPk($modPengkajian->asesmenawalkebidanan_bidan_id);
            }
        } else {
            if (!empty($modPengkajian->asesmen_awal_keperawatan_id)) {
                $modAwalKeperawatan = AsesmenAwalKeperawatanT::model()->findByPk($modPengkajian->asesmen_awal_keperawatan_id);
            }
        }
        $penunjang = new ASDatapenunjangT;
        $criteria = new CDbCriteria();
        $criteria->addCondition('pengkajianaskep_id =' . $modPengkajian->pengkajianaskep_id);
        $modPenunjang = new CActiveDataProvider($penunjang, array(
            'criteria' => $criteria,
        ));

        if ((!empty($modPemeriksaanFisik->gcs_eye)) && (!empty($modPemeriksaanFisik->gcs_verbal)) && (!empty($modPemeriksaanFisik->gcs_motorik))) {
            $modPemeriksaanFisik->namaGCS = $modPemeriksaanFisik->gcs_eye + $modPemeriksaanFisik->gcs_verbal + $modPemeriksaanFisik->gcs_motorik;
        }

        $this->render($this->path_view . '_detail', array(
            'modPengkajian' => $modPengkajian,
            'modAwalMedis' => $modAwalMedis,
            'modAwalKeperawatan' => $modAwalKeperawatan,
            'modAwalKritis' => $modAwalKritis,
            'modAwalKebidanan' => $modAwalKebidanan,
            'modPenunjang' => $modPenunjang
        ));
    }

    /**
     * Digunakan untuk menampilkan data detail pengkajian kebidanan
     */
    public function actionDetailPengkajianKeb() {
        $this->layout = "//layouts/iframe";
        $modPengkajian = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $_GET['pengkajianaskep_id']));
        $modPengkajian->attributes = $modPengkajian;

        $anamnesa = new ASAnamnesaT;
        $criteria = new CDbCriteria();
        $criteria->addCondition('anamesa_id =' . $modPengkajian->anamesa_id);
        $modAnamnesa = ASAnamnesaT::model()->find($criteria);

        $periksafisik = new ASPemeriksaanfisikT;
        $criteria = new CDbCriteria();
        $criteria->addCondition('pemeriksaanfisik_id =' . $modPengkajian->pemeriksaanfisik_id);
        $modPemeriksaanFisik = ASPemeriksaanfisikT::model()->find($criteria);
        $modPemeriksaanGambar = ASPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $modPemeriksaanFisik->pendaftaran_id));
        $modGambarTubuh = new ASGambartubuhM();
        $modBagianTubuh = new ASBagiantubuhM();

        if ((!empty($modPemeriksaanFisik->gcs_eye)) && (!empty($modPemeriksaanFisik->gcs_verbal)) && (!empty($modPemeriksaanFisik->gcs_motorik))) {
            $modPemeriksaanFisik->namaGCS = $modPemeriksaanFisik->gcs_eye + $modPemeriksaanFisik->gcs_verbal + $modPemeriksaanFisik->gcs_motorik;
        }

        $penunjang = new ASDatapenunjangT;
        $criteria = new CDbCriteria();
        $criteria->addCondition('pengkajianaskep_id =' . $modPengkajian->pengkajianaskep_id);
        $modPenunjang = new CActiveDataProvider($penunjang, array(
            'criteria' => $criteria,
        ));

        $perkawinan = new ASRiwayatperkawinanR;
        $persalinan = new ASRiwayatpersalinanR;
        $criteria = new CDbCriteria();
        $criteria->addCondition('anamesa_id =' . $modPengkajian->anamesa_id);

        $modPerkawinan = new CActiveDataProvider($perkawinan, array(
            'criteria' => $criteria,
        ));
        $modPersalinan = new CActiveDataProvider($persalinan, array(
            'criteria' => $criteria,
        ));


        $this->render($this->path_view . '_detailPengkajianKeb', array(
            'modPengkajian' => $modPengkajian,
            'modAnamnesa' => $modAnamnesa,
            'modPemeriksaanFisik' => $modPemeriksaanFisik,
            'modPemeriksaanGambar' => $modPemeriksaanGambar,
            'modGambarTubuh' => $modGambarTubuh,
            'modBagianTubuh' => $modBagianTubuh,
            'modPenunjang' => $modPenunjang,
            'modPerkawinan' => $modPerkawinan,
            'modPersalinan' => $modPersalinan,
        ));
    }

    /**
     * Autocomplete pengkajian keperawatan
     */
    public function actionAutocompletepengkajiankep() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_pengkajian)', strtolower($_GET['term']), true);
            $criteria->limit = 5;
            $models = ASInfopengkajianaskepV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pengkajian . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
                $returnVal[$i]['value'] = $model->no_pengkajian;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete pengkajian kebidanan
     */
    public function actionAutocompletepengkajiankeb() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_pengkajian)', strtolower($_GET['term']), true);
            $criteria->limit = 5;
            $models = ASInfopengkajiankebidananV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pengkajian . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
                $returnVal[$i]['value'] = $model->no_pengkajian;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete Pegawai Riwayat
     */
    public function actionPegawairiwayat() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->limit = 5;
            $models = PegawaiM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai . ' - ' . $model->jeniskelamin;
                $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
                $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete Diagnosa
     */
    public function actionAutocompleteDiagnosa() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $term = strtolower(trim($_GET['term']));
            $condition = "LOWER(diagnosakep_kode) LIKE '%" . $term . "%' OR LOWER(diagnosakep_nama) LIKE '%" . $term . "%' ";
            $criteria->addCondition($condition);
            $criteria->limit = 5;
            $models = ASDiagnosakepM::model()->findAll($criteria);
            $returnVal = array();

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->diagnosakep_kode . ' - ' . $model->diagnosakep_nama;
                $returnVal[$i]['value'] = $model->diagnosakep_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Autocomplete Tanda Gejala Mayor Objektif
     */
    public function actionAutocompleteMayorObjektif() {
        if (Yii::app()->request->isAjaxRequest) {
            $term = strtolower(trim($_GET['term']));
            
            $criteria = new CDbCriteria;
            $criteria->select = 't.tandagejala_daftar_nama, det.kelompoktandagejaladaftar_id';
            $criteria->join = 'JOIN kelompoktandagejaladaftar_m det ON det.tandagejala_daftar_id = t.tandagejala_daftar_id '
                            . 'JOIN jenistandagejala_m jenistandagejala ON jenistandagejala.jenistandagejala_id = det.jenistandagejala_id';
            $criteria->compare('LOWER(t.tandagejala_daftar_nama)', strtolower($term), true);
            $criteria->addCondition('t.tandagejala_daftar_aktif is true');
            $criteria->addCondition("jenistandagejala.subjenistandagejala_nama = 'Objektif' ");
            $criteria->addCondition("jenistandagejala.jenistandagejala_nama = 'Mayor' ");
            $criteria->order = 't.tandagejala_daftar_nama';
            $criteria->limit = 5;
            $models = ASTandagejalaDaftarM::model()->findAll($criteria);
            $returnVal = array();

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->tandagejala_daftar_nama;
                $returnVal[$i]['value'] = $model->kelompoktandagejaladaftar_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete Tanda Gejala Mayor Subjektif
     */
    public function actionAutocompleteMayorSubjektif() {
        if (Yii::app()->request->isAjaxRequest) {
            $term = strtolower(trim($_GET['term']));
            
            $criteria = new CDbCriteria;
            $criteria->select = 't.tandagejala_daftar_nama, det.kelompoktandagejaladaftar_id';
            $criteria->join = 'JOIN kelompoktandagejaladaftar_m det ON det.tandagejala_daftar_id = t.tandagejala_daftar_id '
                            . 'JOIN jenistandagejala_m jenistandagejala ON jenistandagejala.jenistandagejala_id = det.jenistandagejala_id';
            $criteria->compare('LOWER(t.tandagejala_daftar_nama)', strtolower($term), true);
            $criteria->addCondition('t.tandagejala_daftar_aktif is true');
            $criteria->addCondition("jenistandagejala.subjenistandagejala_nama = 'Subjektif' ");
            $criteria->addCondition("jenistandagejala.jenistandagejala_nama = 'Mayor' ");
            $criteria->order = 't.tandagejala_daftar_nama';
            $criteria->limit = 5;
            $models = ASTandagejalaDaftarM::model()->findAll($criteria);
            $returnVal = array();

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->tandagejala_daftar_nama;
                $returnVal[$i]['value'] = $model->kelompoktandagejaladaftar_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete Tanda Gejala Minor Objektif
     */
    public function actionAutocompleteMinorObjektif() {
        if (Yii::app()->request->isAjaxRequest) {
            $term = strtolower(trim($_GET['term']));
            
            $criteria = new CDbCriteria;
            $criteria->select = 't.tandagejala_daftar_nama, det.kelompoktandagejaladaftar_id';
            $criteria->join = 'JOIN kelompoktandagejaladaftar_m det ON det.tandagejala_daftar_id = t.tandagejala_daftar_id '
                            . 'JOIN jenistandagejala_m jenistandagejala ON jenistandagejala.jenistandagejala_id = det.jenistandagejala_id';
            $criteria->compare('LOWER(t.tandagejala_daftar_nama)', strtolower($term), true);
            $criteria->addCondition('t.tandagejala_daftar_aktif is true');
            $criteria->addCondition("jenistandagejala.subjenistandagejala_nama = 'Objektif' ");
            $criteria->addCondition("jenistandagejala.jenistandagejala_nama = 'Minor' ");
            $criteria->order = 't.tandagejala_daftar_nama';
            $criteria->limit = 5;
            $models = ASTandagejalaDaftarM::model()->findAll($criteria);
            $returnVal = array();

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->tandagejala_daftar_nama;
                $returnVal[$i]['value'] = $model->kelompoktandagejaladaftar_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete Tanda Gejala Minor Subjektif
     */
    public function actionAutocompleteMinorSubjektif() {
        if (Yii::app()->request->isAjaxRequest) {
            $term = strtolower(trim($_GET['term']));
            
            $criteria = new CDbCriteria;
            $criteria->select = 't.tandagejala_daftar_nama, det.kelompoktandagejaladaftar_id';
            $criteria->join = 'JOIN kelompoktandagejaladaftar_m det ON det.tandagejala_daftar_id = t.tandagejala_daftar_id '
                            . 'JOIN jenistandagejala_m jenistandagejala ON jenistandagejala.jenistandagejala_id = det.jenistandagejala_id';
            $criteria->compare('LOWER(t.tandagejala_daftar_nama)', strtolower($term), true);
            $criteria->addCondition('t.tandagejala_daftar_aktif is true');
            $criteria->addCondition("jenistandagejala.subjenistandagejala_nama = 'Subjektif' ");
            $criteria->addCondition("jenistandagejala.jenistandagejala_nama = 'Minor' ");
            $criteria->order = 't.tandagejala_daftar_nama';
            $criteria->limit = 5;
            $models = ASTandagejalaDaftarM::model()->findAll($criteria);
            $returnVal = array();

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->tandagejala_daftar_nama;
                $returnVal[$i]['value'] = $model->kelompoktandagejaladaftar_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete Faktor Risiko
     */
    public function actionAutocompleteFaktorRisiko() {
        if (Yii::app()->request->isAjaxRequest) {
            $term = strtolower(trim($_GET['term']));
            
            $criteria = new CDbCriteria;
            $criteria->select = 'jenisfaktorrisiko.jenisfaktorrisiko_nama, t.faktorrisiko_daftar_nama, det.kelompokfaktorrisikodaftar_id';
            $criteria->join = 'JOIN kelompokfaktorrisikodaftar_m det ON det.faktorrisiko_daftar_id = t.faktorrisiko_daftar_id '
                            . 'JOIN jenisfaktorrisiko_m jenisfaktorrisiko ON jenisfaktorrisiko.jenisfaktorrisiko_id = det.jenisfaktorrisiko_id';
            $criteria->compare('LOWER(t.faktorrisiko_daftar_nama)', strtolower($term), true);
            $criteria->addCondition('t.faktorrisiko_daftar_aktif is true');
            $criteria->order = 'jenisfaktorrisiko.jenisfaktorrisiko_urutan';
            $criteria->limit = 5;
            $models = ASFaktorrisikoDaftarM::model()->findAll($criteria);
            $returnVal = array();

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->jenisfaktorrisiko_nama . ' - ' . $model->faktorrisiko_daftar_nama;
                $returnVal[$i]['value'] = $model->kelompokfaktorrisikodaftar_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Digunakan untuk load diagnosa medis
     * @param type $pasien_id
     * @param type $pendaftaran_id
     */
    public function actionLoadDiagnosaMedis($pasien_id, $pendaftaran_id) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['diagnosa_id'] = "";
            $data['diagnosa_nama'] = "";

            $modPasienMorb = ASPasienmorbiditasT::model()->findAllByAttributes(array('pasien_id' => $pasien_id, 'pendaftaran_id' => $pendaftaran_id, 'kelompokdiagnosa_id' => 2));

            foreach ($modPasienMorb as $i => $detail) {

                $modDiagnosa = ASDiagnosaM::model()->findByAttributes(array('diagnosa_id' => $detail->diagnosa_id));

                if ($i == 0) {
                    $data['diagnosa_id'] = $modDiagnosa->diagnosa_id;
                    $data['diagnosa_nama'] = $modDiagnosa->diagnosa_nama;
                } else {
                    $data['diagnosa_id'] .= ',' . $modDiagnosa->diagnosa_id;
                    $data['diagnosa_nama'] .= ',' . $modDiagnosa->diagnosa_nama;
                }
            }

            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Generate baris tanda gejala mayor objektif
     */
    public function actionGetTandaGejalaMayorObjektif() {
        if (Yii::app()->request->isAjaxRequest) {
            $kelompoktandagejaladaftar_id = isset($_POST['kelompoktandagejaladaftar_id']) ? $_POST['kelompoktandagejaladaftar_id'] : null;

            $cri = new CDbCriteria();
            $cri->select = 't.*, tandagejala_daftar_m.tandagejala_daftar_nama, jenistandagejala_m.jenistandagejala_nama, jenistandagejala_m.subjenistandagejala_nama';
            $cri->join = 'JOIN jenistandagejala_m ON jenistandagejala_m.jenistandagejala_id = t.jenistandagejala_id '
                       . 'JOIN tandagejala_daftar_m ON tandagejala_daftar_m.tandagejala_daftar_id = t.tandagejala_daftar_id';
            if (is_array($kelompoktandagejaladaftar_id)) {
                $cri->addInCondition("t.kelompoktandagejaladaftar_id", $kelompoktandagejaladaftar_id);
            } else {
                $cri->addCondition("t.kelompoktandagejaladaftar_id = '" . $kelompoktandagejaladaftar_id . "' ");
            }
            $modTandaGejala = KelompoktandagejaladaftarM::model()->findAll($cri);

            $kanUtam = array();

            foreach ($modTandaGejala as $d) {
                $kanUtam[$d->kelompoktandagejaladaftar_id]['kelompoktandagejaladaftar_id'] = $d->kelompoktandagejaladaftar_id;
                $kanUtam[$d->kelompoktandagejaladaftar_id]['tandagejala_daftar_nama'] = $d->tandagejala_daftar_nama;
                $kanUtam[$d->kelompoktandagejaladaftar_id]['jenistandagejala_nama'] = $d->jenistandagejala_nama;
                $kanUtam[$d->kelompoktandagejaladaftar_id]['subjenistandagejala_nama'] = $d->subjenistandagejala_nama;
            }

            $data['tabel'] = "";
            $data['diagnosa_nama'] = "";
            $data['diagnosa_id'] = "";

            $data['tabel'] = '';

            $no = 0;
            $no1 = 0;
            $kelompoktandagejaladaftar = array();
            foreach ($kanUtam as $det) {
                $modDetail = new ASPilihdiagnosisaskepT();
                $modDetail->kelompoktandagejaladaftar_id = $det['kelompoktandagejaladaftar_id'];
                if ($det['jenistandagejala_nama'] == 'Mayor') {
                    if ($det['subjenistandagejala_nama'] == 'Objektif') {
                        $kelompoktandagejaladaftar[] = $det['kelompoktandagejaladaftar_id'];
                        $data['tabel'] .= $this->renderPartial($this->path_view . '_detailTandagejala', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modDetail), true);
                        $no1++;
                    }
                }
                $no++;
            }
            if ($no1 == 0) {
                $data['tabel'] .= '';
            }
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Generate baris tanda gejala mayor subjektif
     */
    public function actionGetTandaGejalaMayorSubjektif() {
        if (Yii::app()->request->isAjaxRequest) {
            $kelompoktandagejaladaftar_id = isset($_POST['kelompoktandagejaladaftar_id']) ? $_POST['kelompoktandagejaladaftar_id'] : null;

            $cri = new CDbCriteria();
            $cri->select = 't.*, tandagejala_daftar_m.tandagejala_daftar_nama, jenistandagejala_m.jenistandagejala_nama, jenistandagejala_m.subjenistandagejala_nama';
            $cri->join = 'JOIN jenistandagejala_m ON jenistandagejala_m.jenistandagejala_id = t.jenistandagejala_id '
                       . 'JOIN tandagejala_daftar_m ON tandagejala_daftar_m.tandagejala_daftar_id = t.tandagejala_daftar_id';
            if (is_array($kelompoktandagejaladaftar_id)) {
                $cri->addInCondition("t.kelompoktandagejaladaftar_id", $kelompoktandagejaladaftar_id);
            } else {
                $cri->addCondition("t.kelompoktandagejaladaftar_id = '" . $kelompoktandagejaladaftar_id . "' ");
            }
            $modTandaGejala = KelompoktandagejaladaftarM::model()->findAll($cri);

            $kanUtam = array();

            foreach ($modTandaGejala as $d) {
                $kanUtam[$d->kelompoktandagejaladaftar_id]['kelompoktandagejaladaftar_id'] = $d->kelompoktandagejaladaftar_id;
                $kanUtam[$d->kelompoktandagejaladaftar_id]['tandagejala_daftar_nama'] = $d->tandagejala_daftar_nama;
                $kanUtam[$d->kelompoktandagejaladaftar_id]['jenistandagejala_nama'] = $d->jenistandagejala_nama;
                $kanUtam[$d->kelompoktandagejaladaftar_id]['subjenistandagejala_nama'] = $d->subjenistandagejala_nama;
            }

            $data['tabel'] = "";
            $data['diagnosa_nama'] = "";
            $data['diagnosa_id'] = "";

            $data['tabel'] = '';

            $no = 0;
            $no2 = 0;
            $kelompoktandagejaladaftar = array();
            foreach ($kanUtam as $det) {
                $modDetail = new ASPilihdiagnosisaskepT();
                $modDetail->kelompoktandagejaladaftar_id = $det['kelompoktandagejaladaftar_id'];
                if ($det['jenistandagejala_nama'] == 'Mayor') {
                    if ($det['subjenistandagejala_nama'] == 'Subjektif') {
                        $kelompoktandagejaladaftar[] = $det['kelompoktandagejaladaftar_id'];
                        $data['tabel'] .= $this->renderPartial($this->path_view . '_detailTandagejala', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modDetail), true);
                        $no2++;
                    }
                }
                $no++;
            }
            if ($no2 == 0) {
                $data['tabel'] .= '';
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Generate baris tanda gejala minor objektif
     */
    public function actionGetTandaGejalaMinorObjektif() {
        if (Yii::app()->request->isAjaxRequest) {
            $kelompoktandagejaladaftar_id = isset($_POST['kelompoktandagejaladaftar_id']) ? $_POST['kelompoktandagejaladaftar_id'] : null;

            $cri = new CDbCriteria();
            $cri->select = 't.*, tandagejala_daftar_m.tandagejala_daftar_nama, jenistandagejala_m.jenistandagejala_nama, jenistandagejala_m.subjenistandagejala_nama';
            $cri->join = 'JOIN jenistandagejala_m ON jenistandagejala_m.jenistandagejala_id = t.jenistandagejala_id '
                       . 'JOIN tandagejala_daftar_m ON tandagejala_daftar_m.tandagejala_daftar_id = t.tandagejala_daftar_id';
            if (is_array($kelompoktandagejaladaftar_id)) {
                $cri->addInCondition("t.kelompoktandagejaladaftar_id", $kelompoktandagejaladaftar_id);
            } else {
                $cri->addCondition("t.kelompoktandagejaladaftar_id = '" . $kelompoktandagejaladaftar_id . "' ");
            }
            $modTandaGejala = KelompoktandagejaladaftarM::model()->findAll($cri);

            $kanUtam = array();

            foreach ($modTandaGejala as $d) {
                $kanUtam[$d->kelompoktandagejaladaftar_id]['kelompoktandagejaladaftar_id'] = $d->kelompoktandagejaladaftar_id;
                $kanUtam[$d->kelompoktandagejaladaftar_id]['tandagejala_daftar_nama'] = $d->tandagejala_daftar_nama;
                $kanUtam[$d->kelompoktandagejaladaftar_id]['jenistandagejala_nama'] = $d->jenistandagejala_nama;
                $kanUtam[$d->kelompoktandagejaladaftar_id]['subjenistandagejala_nama'] = $d->subjenistandagejala_nama;
            }

            $data['tabel'] = "";
            $data['diagnosa_nama'] = "";
            $data['diagnosa_id'] = "";

            $data['tabel'] = '';

            $no = 0;
            $no3 = 0;
            $kelompoktandagejaladaftar = array();
            foreach ($kanUtam as $det) {
                $modDetail = new ASPilihdiagnosisaskepT();
                $modDetail->kelompoktandagejaladaftar_id = $det['kelompoktandagejaladaftar_id'];
                if ($det['jenistandagejala_nama'] == 'Minor') {
                    if ($det['subjenistandagejala_nama'] == 'Objektif') {
                        $kelompoktandagejaladaftar[] = $det['kelompoktandagejaladaftar_id'];
                        $data['tabel'] .= $this->renderPartial($this->path_view . '_detailTandagejala', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modDetail), true);
                        $no3++;
                    }
                }
                $no++;
            }
            if ($no3 == 0) {
                $data['tabel'] .= '';
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Generate baris tanda gejala minor subjektif
     */
    public function actionGetTandaGejalaMinorSubjektif() {
        if (Yii::app()->request->isAjaxRequest) {
            $kelompoktandagejaladaftar_id = isset($_POST['kelompoktandagejaladaftar_id']) ? $_POST['kelompoktandagejaladaftar_id'] : null;

            $cri = new CDbCriteria();
            $cri->select = 't.*, tandagejala_daftar_m.tandagejala_daftar_nama, jenistandagejala_m.jenistandagejala_nama, jenistandagejala_m.subjenistandagejala_nama';
            $cri->join = 'JOIN jenistandagejala_m ON jenistandagejala_m.jenistandagejala_id = t.jenistandagejala_id '
                       . 'JOIN tandagejala_daftar_m ON tandagejala_daftar_m.tandagejala_daftar_id = t.tandagejala_daftar_id';
            if (is_array($kelompoktandagejaladaftar_id)) {
                $cri->addInCondition("t.kelompoktandagejaladaftar_id", $kelompoktandagejaladaftar_id);
            } else {
                $cri->addCondition("t.kelompoktandagejaladaftar_id = '" . $kelompoktandagejaladaftar_id . "' ");
            }
            $modTandaGejala = KelompoktandagejaladaftarM::model()->findAll($cri);

            $kanUtam = array();

            foreach ($modTandaGejala as $d) {
                $kanUtam[$d->kelompoktandagejaladaftar_id]['kelompoktandagejaladaftar_id'] = $d->kelompoktandagejaladaftar_id;
                $kanUtam[$d->kelompoktandagejaladaftar_id]['tandagejala_daftar_nama'] = $d->tandagejala_daftar_nama;
                $kanUtam[$d->kelompoktandagejaladaftar_id]['jenistandagejala_nama'] = $d->jenistandagejala_nama;
                $kanUtam[$d->kelompoktandagejaladaftar_id]['subjenistandagejala_nama'] = $d->subjenistandagejala_nama;
            }

            $data['tabel'] = "";
            $data['diagnosa_nama'] = "";
            $data['diagnosa_id'] = "";

            $data['tabel'] = '';

            $no = 0;
            $no4 = 0;
            $kelompoktandagejaladaftar = array();
            foreach ($kanUtam as $det) {
                $modDetail = new ASPilihdiagnosisaskepT();
                $modDetail->kelompoktandagejaladaftar_id = $det['kelompoktandagejaladaftar_id'];
                if ($det['jenistandagejala_nama'] == 'Minor') {
                    if ($det['subjenistandagejala_nama'] == 'Subjektif') {
                        $kelompoktandagejaladaftar[] = $det['kelompoktandagejaladaftar_id'];
                        $data['tabel'] .= $this->renderPartial($this->path_view . '_detailTandagejala', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modDetail), true);
                        $no4++;
                    }
                }
                $no++;
            }
            if ($no4 == 0) {
                $data['tabel'] .= '';
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Generate baris faktor risiko
     */
    public function actionGetFaktorRisikonya() {
        if (Yii::app()->request->isAjaxRequest) {
            $kelompokfaktorrisikodaftar_id = isset($_POST['kelompokfaktorrisikodaftar_id']) ? $_POST['kelompokfaktorrisikodaftar_id'] : null;

            $cri = new CDbCriteria();
            $cri->select = 'faktorrisiko_daftar_m.faktorrisiko_daftar_nama, jenisfaktorrisiko_m.jenisfaktorrisiko_nama, jenisfaktorrisiko_m.jenisfaktorrisiko_id, t.*,'
                    . 'row_number() OVER (PARTITION BY jenisfaktorrisiko_m.jenisfaktorrisiko_urutan ORDER BY jenisfaktorrisiko_m.jenisfaktorrisiko_urutan) AS no';
            $cri->join = 'JOIN jenisfaktorrisiko_m ON jenisfaktorrisiko_m.jenisfaktorrisiko_id = t.jenisfaktorrisiko_id '
                       . 'JOIN faktorrisiko_daftar_m ON faktorrisiko_daftar_m.faktorrisiko_daftar_id = t.faktorrisiko_daftar_id';
            if (is_array($kelompokfaktorrisikodaftar_id)) {
                $cri->addInCondition("t.kelompokfaktorrisikodaftar_id", $kelompokfaktorrisikodaftar_id);
            } else {
                $cri->addCondition("t.kelompokfaktorrisikodaftar_id = '" . $kelompokfaktorrisikodaftar_id . "' ");
            }
            $cri->order = 'jenisfaktorrisiko_m.jenisfaktorrisiko_urutan';
            $modFaktorRisiko = KelompokfaktorrisikodaftarM::model()->findAll($cri);

            $jenisResiko = JenisfaktorrisikoM::model()->findAllByAttributes(array('jenisfaktorrisiko_aktif' => true), array('order' => 'jenisfaktorrisiko_urutan ASC'));

            $kanUtam = array();
            foreach ($modFaktorRisiko as $d) {
                $kanUtam[$d->kelompokfaktorrisikodaftar_id]['kelompokfaktorrisikodaftar_id'] = $d->kelompokfaktorrisikodaftar_id;
                $kanUtam[$d->kelompokfaktorrisikodaftar_id]['faktorrisiko_daftar_nama'] = $d->faktorrisiko_daftar_nama;
                $kanUtam[$d->kelompokfaktorrisikodaftar_id]['jenisfaktorrisiko_nama'] = $d->jenisfaktorrisiko_nama;
                $kanUtam[$d->kelompokfaktorrisikodaftar_id]['jenisfaktorrisiko_id'] = $d->jenisfaktorrisiko_id;
                $kanUtam[$d->kelompokfaktorrisikodaftar_id]['no'] = $d->no;
            }

            $data['tabel'] = "";
            $data['diagnosa_nama'] = "";
            $data['diagnosa_id'] = "";
            $no = 0;
            $kelompokfaktorrisikodaftar = array();

            foreach ($kanUtam as $det) {
                foreach ($jenisResiko as $key => $value) {
                    if (!empty($det['jenisfaktorrisiko_id'])) {
                        if ($value->jenisfaktorrisiko_id == $det['jenisfaktorrisiko_id']) {
                            $no = !empty($det['no']) ? $det['no'] : 0;
                            if($det['no'] == 1){
                                $data['tabel'] .= ' <tr> 
                                                        <td colspan="2" style="background-color:#f8f8f8; border: 1px solid #f8f8f8 !important;"><b>' . $det['jenisfaktorrisiko_nama'] . '</b></td>
                                                    </tr>';
                            }
                            $modDetail = new ASPilihdiagnosisaskepT();
                            $modDetail->kelompokfaktorrisikodaftar_id = $det['kelompokfaktorrisikodaftar_id'];
                            $kelompokfaktorrisikodaftar[] = $det['kelompokfaktorrisikodaftar_id'];
                            $data['tabel'] .= $this->renderPartial($this->path_view . '_detailFaktorRisiko', array('no' => $no + 1, 'modFaktorRisiko' => $det, 'modDetail' => $modDetail), true);

                            $no++;
                        }
                    }
                }
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk mendapatkan data diagnosa
     * @param type $kelompoktandagejaladaftar_id
     * @param type $kelompokfaktorrisikodaftar_id
     */
    public function actionGetDiagnosaKeperawatan() {
        if (Yii::app()->request->isAjaxRequest) {
            $kelompoktandagejaladaftar_id = isset($_GET['kelompoktandagejaladaftar_id']) ? $_GET['kelompoktandagejaladaftar_id'] : null;
            $kelompokfaktorrisikodaftar_id = isset($_GET['kelompokfaktorrisikodaftar_id']) ? $_GET['kelompokfaktorrisikodaftar_id'] : null;
                        
            $criteria = new CDbCriteria();
            if (!empty($kelompoktandagejaladaftar_id)) {
                if ($kelompoktandagejaladaftar_id != 'undefined') {
                    $criteria->select = 't.diagnosakep_id, t.diagnosakep_kode, t.diagnosakep_nama, t.diagnosakep_deskripsi, t.diagnosakep_aktif,
                                 det.kelompoktandagejaladaftar_id, jenis.jenistandagejala_nama,jenis.subjenistandagejala_nama, tandagejala_daftar_m.tandagejala_daftar_nama';
                    $criteria->join = 'JOIN tandagejala_m tandagejala ON tandagejala.diagnosakep_id = t.diagnosakep_id
                                       JOIN kelompoktandagejaladaftar_m det ON det.kelompoktandagejaladaftar_id = tandagejala.kelompoktandagejaladaftar_id 
                                       JOIN jenistandagejala_m jenis ON det.jenistandagejala_id = jenis.jenistandagejala_id
                                       JOIN tandagejala_daftar_m ON tandagejala_daftar_m.tandagejala_daftar_id = det.tandagejala_daftar_id ';
                    $criteria->addInCondition('det.kelompoktandagejaladaftar_id ', $kelompoktandagejaladaftar_id);
                    $jml = count($kelompoktandagejaladaftar_id);
                }
            } else if (!empty($kelompokfaktorrisikodaftar_id)) {
                if ($kelompokfaktorrisikodaftar_id != 'undefined') {
                    $criteria->select = 't.diagnosakep_id, t.diagnosakep_kode, t.diagnosakep_nama, t.diagnosakep_deskripsi, t.diagnosakep_aktif,
                                 dets.kelompokfaktorrisikodaftar_id, jenis.jenisfaktorrisiko_nama, faktorrisiko_daftar_m.faktorrisiko_daftar_nama';
                    $criteria->join = 'JOIN faktorrisiko_m faktorrisiko ON faktorrisiko.diagnosakep_id = t.diagnosakep_id
                                       JOIN kelompokfaktorrisikodaftar_m dets ON dets.kelompokfaktorrisikodaftar_id = faktorrisiko.kelompokfaktorrisikodaftar_id 
                                       JOIN jenisfaktorrisiko_m jenis ON dets.jenisfaktorrisiko_id = jenis.jenisfaktorrisiko_id
                                       JOIN faktorrisiko_daftar_m ON faktorrisiko_daftar_m.faktorrisiko_daftar_id = dets.faktorrisiko_daftar_id ';
                    $criteria->addInCondition('dets.kelompokfaktorrisikodaftar_id ', $kelompokfaktorrisikodaftar_id);
                    $jml = count($kelompokfaktorrisikodaftar_id);
                }
            }
            $criteria->group = $criteria->select;
            $cekData = ASDiagnosakepM::model()->findAll($criteria);
            
            $data['form'] = "";
            $data['jml_data'] = !empty($cekData) ? count($cekData) : 0;
            $data['jml_kelompoktandagejaladaftar_id'] = !empty($kelompoktandagejaladaftar_id) ? count($kelompoktandagejaladaftar_id) : 0;
            $data['jml_kelompokfaktorrisikodaftar_id'] = !empty($kelompokfaktorrisikodaftar_id) ? count($kelompokfaktorrisikodaftar_id) : 0;
            $data['kelompoktandagejaladaftar_id'] = '';
            $data['kelompokfaktorrisikodaftar_id'] = '';
            $data['diagnosa_id'] = '';
            $data['jmlnya'] = '';
            
            
            if (!empty($cekData)) {
                /*
                $modDiagnosa = ASDiagnosakepM::model()->find($criteria);
                $diagnosakep_id = $modDiagnosa->diagnosakep_id;
                
                $diagnosa = ASDiagnosakepM::model()->findByPk($diagnosakep_id);
                $data['diagnosakep_id'] = $diagnosa->diagnosakep_id;
                $data['diagnosakep_nama'] = $diagnosa->diagnosakep_nama;
                $data['form'] .= "<div class='diagdetail'>";
                $data['form'] .= "<br>";
                $data['form'] .= '<strong>Penyebab</strong>';
                $data['form'] .= "<br>";
                $bk_head = BataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id));
                if (count($bk_head)) {
                    foreach ($bk_head as $i => $bk) {
                        $data['form'] .= "<ul class='spasi1'>";
                        $data['form'] .= '<li >' . $bk->bataskarakteristik_nama . '</li>';
                        $bk_tail = BataskarakteristikdetM::model()->findAllByAttributes(array('bataskarakteristikdet_aktif' => true, 'bataskarakteristik_id' => $bk->bataskarakteristik_id));
                        if (count($bk_tail)) {
                            foreach ($bk_tail as $i => $bkd) {
                                $data['form'] .= '<li >' . $bkd->bataskarakteristikdet_indikator . '</li>';
                            }
                        } else {
                            $data['form'] .= "<ul class='spasi1'>";
                            $data['form'] .= '<li> Data tidak ditemukan. </li>';
                            $data['form'] .= "</ul>";
                        }
                        $data['form'] .= "</ul>";
                    }
                } else {
                    $data['form'] .= "<ul class='spasi1'>";
                    $data['form'] .= '<li> Data tidak ditemukan. </li>';
                    $data['form'] .= "</ul>";
                }

                $data['form'] .= "<br>";

                $data['form'] .= '<strong>Kondisi Klinis Terkait</strong>';
                $data['form'] .= "<br>";
                $bk_head = FaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id));
                if (count($bk_head)) {
                    foreach ($bk_head as $i => $bk) {
                        $data['form'] .= "<ul class='spasi1'>";
                        $data['form'] .= '<li >' . $bk->faktorhub_nama . '</li>';
                        $bk_tail = FaktorhubdetM::model()->findAllByAttributes(array('faktorhubdet_aktif' => true, 'faktorhub_id' => $bk->faktorhub_id));
                        if (count($bk_tail)) {
                            foreach ($bk_tail as $i => $bkd) {
                                $data['form'] .= '<li >' . $bkd->faktorhubdet_indikator . '</li>';
                            }
                        } else {
                            $data['form'] .= "<ul class='spasi1'>";
                            $data['form'] .= '<li> Data tidak ditemukan. </li>';
                            $data['form'] .= "</ul>";
                        }
                        $data['form'] .= "</ul>";
                    }
                } else {
                    $data['form'] .= "<ul class='spasi1'>";
                    $data['form'] .= '<li> Data tidak ditemukan. </li>';
                    $data['form'] .= "</ul>";
                }
                $data['form'] .= "</div>";
            }else{
                */
                foreach ($cekData as $value){
                   if (!empty($kelompoktandagejaladaftar_id)) {
                       $crit = new CDbCriteria();
                       $crit->addCondition('diagnosakep_id = '.$value->diagnosakep_id);
                       if ($kelompoktandagejaladaftar_id != 'undefined') {
                        $crit->addInCondition('kelompoktandagejaladaftar_id',$kelompoktandagejaladaftar_id);
                       }
                       $cektandagejala = TandagejalaM::model()->findAll($crit);
                       
                       $data['diagnosa_id'] .= $value->diagnosakep_id.',';
                       $data['kelompoktandagejaladaftar_id'] .= $value->kelompoktandagejaladaftar_id.',';
                       $data['jmlnya'] .= count($cektandagejala).',';
                       if(count($cektandagejala) == $jml){
                           $diagnosakep_id = $value->diagnosakep_id;
                
                            $diagnosa = ASDiagnosakepM::model()->findByPk($diagnosakep_id);
                            $data['diagnosakep_id'] = $diagnosa->diagnosakep_id;
                            $data['diagnosakep_nama'] = $diagnosa->diagnosakep_nama;
                            $data['form'] .= "<div class='diagdetail'>";
                            $data['form'] .= "<br>";
                            $data['form'] .= '<strong>Penyebab</strong>';
                            $data['form'] .= "<br>";
                            $bk_head = BataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id));
                            if (count($bk_head)) {
                                foreach ($bk_head as $i => $bk) {
                                    $data['form'] .= "<ul class='spasi1'>";
                                    $data['form'] .= '<li >' . $bk->bataskarakteristik_nama . '</li>';
                                    $bk_tail = BataskarakteristikdetM::model()->findAllByAttributes(array('bataskarakteristikdet_aktif' => true, 'bataskarakteristik_id' => $bk->bataskarakteristik_id));
                                    if (count($bk_tail)) {
                                        foreach ($bk_tail as $i => $bkd) {
                                            $data['form'] .= '<li >' . $bkd->bataskarakteristikdet_indikator . '</li>';
                                        }
                                    } else {
                                        $data['form'] .= "<ul class='spasi1'>";
                                        $data['form'] .= '<li> Data tidak ditemukan. </li>';
                                        $data['form'] .= "</ul>";
                                    }
                                    $data['form'] .= "</ul>";
                                }
                            } else {
                                $data['form'] .= "<ul class='spasi1'>";
                                $data['form'] .= '<li> Data tidak ditemukan. </li>';
                                $data['form'] .= "</ul>";
                            }

                            $data['form'] .= "<br>";

                            $data['form'] .= '<strong>Kondisi Klinis Terkait</strong>';
                            $data['form'] .= "<br>";
                            $bk_head = FaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id));
                            if (count($bk_head)) {
                                foreach ($bk_head as $i => $bk) {
                                    $data['form'] .= "<ul class='spasi1'>";
                                    $data['form'] .= '<li >' . $bk->faktorhub_nama . '</li>';
                                    $bk_tail = FaktorhubdetM::model()->findAllByAttributes(array('faktorhubdet_aktif' => true, 'faktorhub_id' => $bk->faktorhub_id));
                                    if (count($bk_tail)) {
                                        foreach ($bk_tail as $i => $bkd) {
                                            $data['form'] .= '<li >' . $bkd->faktorhubdet_indikator . '</li>';
                                        }
                                    } else {
                                        $data['form'] .= "<ul class='spasi1'>";
                                        $data['form'] .= '<li> Data tidak ditemukan. </li>';
                                        $data['form'] .= "</ul>";
                                    }
                                    $data['form'] .= "</ul>";
                                }
                            } else {
                                $data['form'] .= "<ul class='spasi1'>";
                                $data['form'] .= '<li> Data tidak ditemukan. </li>';
                                $data['form'] .= "</ul>";
                            }
                            $data['form'] .= "</div>";
                       }
                   } else if (!empty($kelompokfaktorrisikodaftar_id)) {
                       $crit = new CDbCriteria();
                       $crit->addCondition('diagnosakep_id = '.$value->diagnosakep_id);
                       if ($kelompokfaktorrisikodaftar_id != 'undefined') {
                        $crit->addInCondition('kelompokfaktorrisikodaftar_id',$kelompokfaktorrisikodaftar_id);
                       }
                       $cekfaktorrisiko = FaktorrisikoM::model()->findAll($crit);
                       
                       $data['diagnosa_id'] .= $value->diagnosakep_id.',';
                       $data['kelompokfaktorrisikodaftar_id'] .= $value->kelompokfaktorrisikodaftar_id.',';
                       $data['jmlnya'] .= count($cekfaktorrisiko).',';
                       if(count($cekfaktorrisiko) == $jml){
                           $diagnosakep_id = $value->diagnosakep_id;
                
                            $diagnosa = ASDiagnosakepM::model()->findByPk($diagnosakep_id);
                            $data['diagnosakep_id'] = $diagnosa->diagnosakep_id;
                            $data['diagnosakep_nama'] = $diagnosa->diagnosakep_nama;
                            $data['form'] .= "<div class='diagdetail'>";
                            $data['form'] .= "<br>";
                            $data['form'] .= '<strong>Penyebab</strong>';
                            $data['form'] .= "<br>";
                            $bk_head = BataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id));
                            if (count($bk_head)) {
                                foreach ($bk_head as $i => $bk) {
                                    $data['form'] .= "<ul class='spasi1'>";
                                    $data['form'] .= '<li >' . $bk->bataskarakteristik_nama . '</li>';
                                    $bk_tail = BataskarakteristikdetM::model()->findAllByAttributes(array('bataskarakteristikdet_aktif' => true, 'bataskarakteristik_id' => $bk->bataskarakteristik_id));
                                    if (count($bk_tail)) {
                                        foreach ($bk_tail as $i => $bkd) {
                                            $data['form'] .= '<li >' . $bkd->bataskarakteristikdet_indikator . '</li>';
                                        }
                                    } else {
                                        $data['form'] .= "<ul class='spasi1'>";
                                        $data['form'] .= '<li> Data tidak ditemukan. </li>';
                                        $data['form'] .= "</ul>";
                                    }
                                    $data['form'] .= "</ul>";
                                }
                            } else {
                                $data['form'] .= "<ul class='spasi1'>";
                                $data['form'] .= '<li> Data tidak ditemukan. </li>';
                                $data['form'] .= "</ul>";
                            }

                            $data['form'] .= "<br>";

                            $data['form'] .= '<strong>Kondisi Klinis Terkait</strong>';
                            $data['form'] .= "<br>";
                            $bk_head = FaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id));
                            if (count($bk_head)) {
                                foreach ($bk_head as $i => $bk) {
                                    $data['form'] .= "<ul class='spasi1'>";
                                    $data['form'] .= '<li >' . $bk->faktorhub_nama . '</li>';
                                    $bk_tail = FaktorhubdetM::model()->findAllByAttributes(array('faktorhubdet_aktif' => true, 'faktorhub_id' => $bk->faktorhub_id));
                                    if (count($bk_tail)) {
                                        foreach ($bk_tail as $i => $bkd) {
                                            $data['form'] .= '<li >' . $bkd->faktorhubdet_indikator . '</li>';
                                        }
                                    } else {
                                        $data['form'] .= "<ul class='spasi1'>";
                                        $data['form'] .= '<li> Data tidak ditemukan. </li>';
                                        $data['form'] .= "</ul>";
                                    }
                                    $data['form'] .= "</ul>";
                                }
                            } else {
                                $data['form'] .= "<ul class='spasi1'>";
                                $data['form'] .= '<li> Data tidak ditemukan. </li>';
                                $data['form'] .= "</ul>";
                            }
                            $data['form'] .= "</div>";
                       }
                   }
                   
                }
            }
        }
        echo CJSON::encode($data);
        Yii::app()->end();
    }

}
