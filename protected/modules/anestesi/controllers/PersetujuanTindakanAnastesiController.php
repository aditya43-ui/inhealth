<?php

/**
 * Transaksi Persetujuan Tindakan Anastesi
 * @author Tantowi J <tantowijaya@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.anestesi
 * @subpackage controllers
 */
class PersetujuanTindakanAnastesiController extends MyAuthController {

    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'anestesi.views.persetujuanTindakanAnastesi.';

    /**
     * Halaman Transaksi Persetujuan Tindakan
     * @param type $pendaftaran_id
     * @param type $pasienanastesi_id
     */
    public function actionIndex($pendaftaran_id, $pasienanastesi_id = null) {
        $format = new MyFormatter();
        $cekPersetujuan = ATPersetujuananestesiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        if (!empty($cekPersetujuan)) {
            $model = ATPersetujuananestesiT::model()->findByPk($cekPersetujuan->persetujuananestesi_id);
            $model->nama_pembuatpernyataan = $model->namapenanggungjawab;
            $model->identitas_pembuatpernyataan = $model->noidentitas_penanggungjawab;
            $diagnosa = !empty($model->diagnosa_id) ? $model->diagnosa->diagnosa_nama : '';
            $model->dokteranestesi_nama = !empty($model->dokteranestesi_id) ? $model->dokteranestesi->nama_pegawai : '';
            $model->dokteranestesi_nama2 = !empty($model->dokteranestesi_id) ? $model->dokteranestesi->nama_pegawai : '';
            $model->saksipihakrs_nama = !empty($model->saksipihakrs_id) ? $model->saksipihakrs->nama_pegawai : '';

            if ($model->jnsanestesi_regional_sedasi == true || $model->jnsanestesi_regional_tnpsedasi == true || $model->jnsanestesi_regional_sab == true || $model->jnsanestesi_regional_epidural == true || $model->jnsanestesi_regional_blokperifer == true || $model->jnsanestesi_regional_kombinasi == true) {
                $model->jnsanestesi_regional = true;
            }
        } else {
            $model = new ATPersetujuananestesiT;
        }
        $modPasienAnestesi = ATPasienanastesiT::model()->findByPk($pasienanastesi_id);
        if (!empty($modPasienAnestesi)) {
            $modRencanaOperasi = RencanaoperasiT::model()->findByPk($modPasienAnestesi->rencanaoperasi_id);
            if (empty($modRencanaOperasi)) {
                if (!empty($_GET['pasienkirimkeunitlain_id'])) {
                    $kirim = PasienkirimkeunitlainT::model()->findByPk($_GET['pasienkirimkeunitlain_id']);
                    $bedah = PasienmasukpenunjangT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $kirim->pasienkirimkeunitlainparent_id));
                    if (!empty($bedah)) {
                        $modRencanaOperasi = RencanaoperasiT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $bedah->pasienmasukpenunjang_id));
                    }
                }
            }
            $modPendaftaran = ATPendaftaranT::model()->findByPk($modPasienAnestesi->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPasienAnestesi->pasien_id);
            $diagnosa = !empty($model->diagnosa_id) ? $model->diagnosa->diagnosa_nama : '';
            /* Ambil diagnosa 
            $morbiditas = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA), array('order' => 'pasienmorbiditas_id DESC'));
            $diagnosa = !empty($morbiditas->diagnosa_id) ? $morbiditas->diagnosa->diagnosa_nama : "";
            $model->diagnosa_nama = $diagnosa;
            $model->diagnosa_id = !empty($morbiditas->diagnosa_id) ? $morbiditas->diagnosa_id : "";
             */
        }

        if (isset($_POST['ATPersetujuananestesiT'])) {

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['ATPersetujuananestesiT'];
                $model->tindakan = $_POST['ATPersetujuananestesiT']['tindakan'];
                $model->diagnosa_id = $_POST['ATPersetujuananestesiT']['diagnosa_id'];
                $model->jnsanestesi_regional_sedasi = !empty($_POST['jnsanestesi_regional_sedasi']) ? true : false;
                $model->jnsanestesi_regional_tnpsedasi = !empty($_POST['jnsanestesi_regional_tnpsedasi']) ? true : false;
                $model->jnsanestesi_regional_sab = !empty($_POST['jnsanestesi_regional_sab']) ? true : false;
                $model->jnsanestesi_regional_epidural = !empty($_POST['jnsanestesi_regional_epidural']) ? true : false;
                $model->jnsanestesi_regional_blokperifer = !empty($_POST['jnsanestesi_regional_blokperifer']) ? true : false;
                $model->jnsanestesi_regional_kombinasi = !empty($_POST['jnsanestesi_regional_kombinasi']) ? true : false;
                if (!empty($_POST['ATPersetujuananestesiT']['jnsanestesi_umum'])) {
                    if ($_POST['ATPersetujuananestesiT']['jnsanestesi_umum'] == true) {
                        $model->jnsanestesi_umum = true;
                        $model->jnsanestesi_sedasiberatsedang = false;
                        $model->jnsanestesi_kombinasi = false;
                    } else {
                        $model->jnsanestesi_umum = false;
                    }
                } else if (!empty($_POST['ATPersetujuananestesiT']['jnsanestesi_sedasiberatsedang'])) {
                    if ($_POST['ATPersetujuananestesiT']['jnsanestesi_sedasiberatsedang'] == true) {
                        $model->jnsanestesi_umum = false;
                        $model->jnsanestesi_sedasiberatsedang = true;
                        $model->jnsanestesi_sedasiberatsedang = false;
                    } else {
                        $model->jnsanestesi_umum = false;
                    }
                } else if (!empty($_POST['ATPersetujuananestesiT']['jnsanestesi_kombinasi'])) {
                    if ($_POST['ATPersetujuananestesiT']['jnsanestesi_kombinasi'] == true) {
                        $model->jnsanestesi_umum = false;
                        $model->jnsanestesi_sedasiberatsedang = false;
                        $model->jnsanestesi_kombinasi = true;
                    } else {
                        $model->jnsanestesi_kombinasi = false;
                    }
                } else if (!empty($_POST['jnsanestesi_regional'])) {
                    $model->jnsanestesi_umum = false;
                    $model->jnsanestesi_sedasiberatsedang = false;
                    $model->jnsanestesi_kombinasi = false;
                }
                $model->pasienmasukpenunjang_id = !empty($modPasienAnestesi->pasienmasukpenunjang_id) ? $modPasienAnestesi->pasienmasukpenunjang_id : $bedah->pasienmasukpenunjang_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $model->create_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->save();
                
                if ($model->validate()) {
                    if ($model->save()) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Surat Persetujuan Tindakan Anastesi berhasil disimpan");
                        $this->redirect(array('Index', 'pendaftaran_id' => $modPasienAnestesi->pendaftaran_id, 'pasienkirimkeunitlain_id' => $kirim->pasienkirimkeunitlainparent_id, 'pasienanastesi_id' => $pasienanastesi_id, 'persetujuananestesi_id' => $model->persetujuananestesi_id, 'sukses' => 1));
                    }
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Surat Surat Persetujuan Tindakan Anastesi gagal disimpan ");
                }
            } catch (Exception $ex) {
                var_dump($ex->getMessage());die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Transaksi gagal disimpan");
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modPasienAnestesi' => $modPasienAnestesi,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'diagnosa' => $diagnosa,
            'modRencanaOperasi' => $modRencanaOperasi,
            'format' => $format
        ));
    }

    /**
     * Digunakan untuk print data Persetujuan Tindakan Anastesi
     * @param type $pasienanastesi_id
     * @param type $persetujuananestesi_id
     * @param type $caraprint
     */
    public function actionPrint($pasienanastesi_id, $persetujuananestesi_id, $caraprint = null) {
        $this->layout = '//layouts/printWindows';

        $format = new MyFormatter;
        $model = ATPersetujuananestesiT::model()->findByPk($persetujuananestesi_id);

        $modPasienAnestesi = ATPasienanastesiT::model()->findByPk($pasienanastesi_id);
        $modRencanaOperasi = RencanaoperasiT::model()->findByPk($modPasienAnestesi->rencanaoperasi_id);
        if (empty($modRencanaOperasi)) {
            if (!empty($_GET['pasienkirimkeunitlain_id'])) {
                $kirim = PasienkirimkeunitlainT::model()->findByPk($_GET['pasienkirimkeunitlain_id']);
                $bedah = PasienmasukpenunjangT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $kirim->pasienkirimkeunitlainparent_id));
                if (!empty($bedah)) {
                    $modRencanaOperasi = RencanaoperasiT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $bedah->pasienmasukpenunjang_id));
                }
            }
        }

        if ($caraprint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array(
                'format' => $format,
                'model' => $model,
                'caraprint' => $caraprint,
                'modRencanaOperasi' => $modRencanaOperasi,
            ));
        } else if ($caraprint == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->render($this->path_view . 'Print', array(
                        'format' => $format,
                        'model' => $model,
                        'caraprint' => $caraprint,
                        'modRencanaOperasi' => $modRencanaOperasi,
                            ), true));
            $mpdf->Output();
        }
    }

    /**
     * Autocomplete Diagnosa
     */
    public function actionAutocompleteDiagnosa() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(diagnosa_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition("diagnosa_aktif IS TRUE");
            $criteria->order = 'diagnosa_nama ASC';
            $criteria->limit = 10;
            $models = DiagnosaM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->diagnosa_nama;
                $returnVal[$i]['value'] = $model->diagnosa_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete Dokter
     */
    public function actionAutocompleteDokter() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria;
            $criteria->join = 'left join pegawai_m as p ON t.pegawai_id = p.pegawai_id
                              ';
            $criteria->group = 'p.unitkerja_id,t.jabatan_id,t.nomorindukpegawai,t.nama_pegawai,t.gelardepan,t.gelarbelakang_nama,t.alamat_pegawai,t.pegawai_id';
            $criteria->select = $criteria->group;
            $criteria->addCondition('t.ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
            $criteria->addCondition('t.kelompokpegawai_id = ' . Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP);
            $criteria->compare('LOWER(t.nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 't.nama_pegawai';
            $criteria->limit = 10;

            $models = PegawairuanganV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nama_pegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete Saksi
     */
    public function actionAutocompleteSaksi() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria;
            $criteria->select = " t.nama_pegawai, t.pegawai_id,t.gelarbelakang_nama,t.gelardepan,j.jabatan_nama, j.jabatan_id, t.nomorindukpegawai, u.namaunitkerja,t.kelompokpegawai_id, t.nomobile_pegawai";
            $criteria->join = " LEFT JOIN jabatan_m j ON j.jabatan_id = t.jabatan_id "
                    . " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id "
                    . " LEFT JOIN unitkerja_m u ON u.unitkerja_id = p.unitkerja_id ";
            $criteria->addCondition(" ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
            $criteria->compare("LOWER(t.nama_pegawai)", strtolower($_GET['term']), true);
            $criteria->order = " t.nama_pegawai ASC ";
            $criteria->limit = 10;
            $models = PegawairuanganV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nama_pegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}
