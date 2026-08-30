<?php
class RingkasanMasukKeluarController extends MyAuthController
{
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'rawatInap.views.ringkasanMasukKeluar.';
    public $tersimpan = false;

    public function actionIndex($pendaftaran_id)
    {
        if (!empty($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }

        $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir);
        $ruangan_id = Yii::app()->user->getState("ruangan_id");

        $model = RingkasanmasukdankeluarT::model()->findByAttributes(array(
            'pendaftaran_id' => $pendaftaran_id,
        ));
        $modRi = RingkasanmasukdankeluarT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $pendaftaran_id
        ));
        if (empty($model)) {
            $model = new RingkasanmasukdankeluarT();
            $model->tanggal_penginputan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
            $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

            $model->pekerjaan_nama = (isset($model->pekerjaan) ? $model->pekerjaan->pekerjaan_nama : "");
            $model->pendidikan_nama = (isset($model->pendidikan) ? $model->pendidikan->pendidikan_nama : "");
            $model->nama_pj = (isset($model->penanggungjawab) ? $model->penanggungjawab->nama_pj : "");
            $model->alamat_pj = (isset($model->penanggungjawab) ? $model->penanggungjawab->alamat_pj : "");
            $model->hubungankeluarga = (isset($model->penanggungjawab) ? $model->penanggungjawab->hubungankeluarga : "");

            // $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            // if (!empty($peg)) {
            //     $model->dokter_yangmerawat_id = $peg->pegawai_id;
            //     $model->dokter_yangmerawat_nama = $peg->namaLengkap;
            // }

            //icd10
            $icd10 = PasienmorbiditasT::model()->findAll(" pendaftaran_id = " . $modPendaftaran->pendaftaran_id . " AND diagnosaicdix_id IS NULL ");
            if (!empty($icd10)) {
                $model->icd10 = '';
                foreach ($icd10 as $key => $val) {
                    $model->icd10 .= ($key + 1) . '. ' . $val->diagnosa->diagnosa_nama . (!empty($val->ket_diagnosa) ? '(' . strip_tags($val->ket_diagnosa) . ')' : '') . '<br/>';
                }
            }

            //icd9
            $icd9 = PasienmorbiditasT::model()->findAll(" pendaftaran_id = " . $modPendaftaran->pendaftaran_id . " AND diagnosaicdix_id IS NOT NULL ");
            if (!empty($icd9)) {
                $model->icd9 = '';
                foreach ($icd9 as $key => $val) {
                    $model->icd9 .= ($key + 1) . '. ' . $val->diagnosatindakan->diagnosaicdix_nama . '<br/>';
                }
            }

            //terapi pengobatan
            $cri = new CDbCriteria;
            $cri->join = " JOIN reseptur_t r ON r.reseptur_id = t.reseptur_id ";
            $cri->addCondition(" r.pendaftaran_id = " . $modPendaftaran->pendaftaran_id . " AND (r.isterapipulang = false OR r.isterapipulang is null ) ");
            $terapipengobatan = ResepturdetailT::model()->findAll($cri);
            if (!empty($terapipengobatan)) {
                $model->terapiselamadirs = '';
                foreach ($terapipengobatan as $key => $val) {
                    $model->terapiselamadirs .= ($key + 1) . '. ' . $val->obatalkes->obatalkes_nama . '<br/>';
                }
            }


            //terapi pulang
            $cri = new CDbCriteria;
            $cri->join = " JOIN reseptur_t r ON r.reseptur_id = t.reseptur_id ";
            $cri->addCondition(" r.pendaftaran_id = " . $modPendaftaran->pendaftaran_id . " AND r.isterapipulang = true ");
            $terapipulang = ResepturdetailT::model()->findAll($cri);
            if (!empty($terapipulang)) {
                $model->terapipulang = '';
                foreach ($terapipulang as $key => $val) {
                    $model->terapipulang .= ($key + 1) . '. ' . $val->obatalkes->obatalkes_nama . '<br/>';
                }
            }
        } else {
            $model->imunisasididapat = CJSON::decode($model->imunisasididapat);
            //            $model->tindakanyangdipilih = CJSON::decode($model->tindakanyangdipilih);            
            $model->tanggal_penginputan = MyFormatter::formatDateTimeForUser($model->tanggal_penginputan);
        }


        $modPendaftaran->carabayar_nama = $modPendaftaran->carabayar->carabayar_nama;
        $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        $modPendaftaran->kelaspelayanan_nama = $modPendaftaran->kelaspelayanan->kelaspelayanan_nama;
        $pasienpulang_id = $modPendaftaran->pasienpulang_id;
        if (isset($modPasienAdmisi)) {
            $modPendaftaran->carabayar_nama = $modPasienAdmisi->carabayar->carabayar_nama;
            $modPendaftaran->ruangan_nama = $modPasienAdmisi->ruangan->ruangan_nama;
            $modPendaftaran->kelaspelayanan_nama = $modPasienAdmisi->kelaspelayanan->kelaspelayanan_nama;
            $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPasienAdmisi->tgladmisi);
            $pasienpulang_id = $modPasienAdmisi->pasienpulang_id;
        }
        $modPasienPulang = PasienpulangT::model()->findByPk($pasienpulang_id);
        if (isset($modPasienPulang)) {
            $modPasienPulang->tglpasienpulang = MyFormatter::formatDateTimeForUser($modPasienPulang->tglpasienpulang);
        } else {
            $modPasienPulang = new PasienpulangT();
        }
        $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);

        $daftar = date('Y-m-d', strtotime($modPendaftaran->tgl_pendaftaran));
        $pulang = empty($modPasienPulang->tglpasienpulang) ? date('Y-m-d') : $modPasienPulang->tglpasienpulang;

        $vpulang = date('Y-m-d', strtotime($pulang));

        $tgl_daftar = MyFormatter::formatDateTimeForUser($daftar);
        $tgl_pulang = MyFormatter::formatDateTimeForUser($vpulang);

        $val_daftar = strtotime($daftar);
        $val_pulang = strtotime($vpulang);

        $lamatrawat = (($val_pulang - $val_daftar) / (3600 * 24)) + 1;
        $model->lamarawat = $lamatrawat;

        $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruangan_id));
        $diagnosaUtama = "";
        $diagnosaTambahan = "";
        $diagnosa_id = null;

        if (count((array) $pasienMorbid) > 0) {
            $indexKel2 = 0;
            $indexKel3 = 0;

            foreach ($pasienMorbid as $datamorbid) {
                $diagnosa_id = $datamorbid->diagnosa_id;
                if ($datamorbid->kelompokdiagnosa_id == 2) {
                    if ($indexKel2 > 0) {
                        $diagnosaUtama .= ", ";
                    }
                    $diagnosaUtama .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel2++;
                }

                if ($datamorbid->kelompokdiagnosa_id == 3) {
                    if ($indexKel3 > 0) {
                        $diagnosaTambahan .= ", ";
                    }
                    $diagnosaTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel3++;
                }
            }
        }
        $model->diagnosa_masuk = "Diagnosa Utama: " . $diagnosaUtama . " \n\n Diagnosa Tambahan: " . $diagnosaTambahan;

        $modRencanaOperasi = RencanaoperasiT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'pasienadmisi_id' => $modPendaftaran->pasienadmisi_id));
        $modTindakanPelayanan = TindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'pasienadmisi_id' => $modPendaftaran->pasienadmisi_id));



        if (isset($_POST['RingkasanmasukdankeluarT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                // echo "<pre>";
                // var_dump($_POST);die;
                $model->attributes = $_POST['RingkasanmasukdankeluarT'];
                $model->tanggal_penginputan = (!empty($_POST['RingkasanmasukdankeluarT']['tanggal_penginputan']) ? MyFormatter::formatDateTimeForDb($_POST['RingkasanmasukdankeluarT']['tanggal_penginputan']) : null);
                $model->tglkontrol = !empty($model->tglkontrol) ? MyFormatter::formatDateTimeForDb($model->tglkontrol) : null;

                if (!empty($model->ringkasanmasukdankeluar_id)) {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                } else {
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }
                $model->create_ruangan = Yii::app()->user->getState("ruangan_id");
                $model->ruangan_id = Yii::app()->user->getState("ruangan_id");
                $model->tglkontrol = !empty($model->tglkontrol) ? MyFormatter::formatDateTimeForDb($model->tglkontrol) : null;
                $model->tglkeluar = !empty($model->tglkeluar) ? MyFormatter::formatDateTimeForDb($model->tglkeluar) : null;

                $model->imunisasididapat = CJSON::encode($model->imunisasididapat);

                if ($model->save()) {
                    $this->tersimpan = true;
                } else {
                    $this->tersimpan = false;
                }
                // echo "<pre>";
                // var_dump($model->getErrors());die;

                if ($this->tersimpan == true) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
                    // $this->redirect(array('index','pendaftaran_id'=>$model->pendaftaran_id,'ringkasanmasukdankeluar_id'=>$model->ringkasanmasukdankeluar_id,'sukses'=>1, 'type'=> $_GET['type'], 'frame'=> $_GET['frame']));
                    $this->redirect(array('index', 'pendaftaran_id' => $model->pendaftaran_id, 'ringkasanmasukdankeluar_id' => $model->ringkasanmasukdankeluar_id, 'sukses' => 1));
                } else {
                    Yii::app()->user->setFlash('error', "Data gagal disimpan!");
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . 'indexNew', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'modPasienAdmisi' => $modPasienAdmisi,
            'modPasienPulang' => $modPasienPulang,
            'pasienMorbid' => $pasienMorbid,
            'modRencanaOperasi' => $modRencanaOperasi,
            'modTindakanPelayanan' => $modTindakanPelayanan,
            'modRi' => $modRi
        ));
    }

    public function actionPrint($id)
    {
        $model = RingkasanmasukdankeluarT::model()->findByPk($id);
        $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($model->pendaftaran_id);
        $modPasienAdmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
        $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $ruangan_id = $model->ruangan_id;

        $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir);
        $model->pekerjaan_nama = (isset($model->pekerjaan) ? $model->pekerjaan->pekerjaan_nama : "");
        $model->pendidikan_nama = (isset($model->pendidikan) ? $model->pendidikan->pendidikan_nama : "");
        $model->nama_pj = (isset($model->penanggungjawab) ? $model->penanggungjawab->nama_pj : "");
        $model->alamat_pj = (isset($model->penanggungjawab) ? $model->penanggungjawab->alamat_pj : "");
        $model->hubungankeluarga = (isset($model->penanggungjawab) ? $model->penanggungjawab->hubungankeluarga : "");
        $model->imunisasididapat = CJSON::decode($model->imunisasididapat);
        // $model->tindakanyangdipilih = CJSON::decode($model->tindakanyangdipilih);

        $model->dokter_yangmerawat_nama = !empty($model->dokteryangmerawat) ? $model->dokteryangmerawat->namaLengkap : '';


        $modPendaftaran->carabayar_nama = $modPendaftaran->carabayar->carabayar_nama;
        $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        $modPendaftaran->kelaspelayanan_nama = $modPendaftaran->kelaspelayanan->kelaspelayanan_nama;
        $pasienpulang_id = $modPendaftaran->pasienpulang_id;
        if (isset($modPasienAdmisi)) {
            $modPendaftaran->carabayar_nama = $modPasienAdmisi->carabayar->carabayar_nama;
            $modPendaftaran->ruangan_nama = $modPasienAdmisi->ruangan->ruangan_nama;
            $modPendaftaran->kelaspelayanan_nama = $modPasienAdmisi->kelaspelayanan->kelaspelayanan_nama;
            $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPasienAdmisi->tgladmisi);
            $pasienpulang_id = $modPasienAdmisi->pasienpulang_id;
        }
        $modPasienPulang = PasienpulangT::model()->findByPk($pasienpulang_id);
        if (isset($modPasienPulang)) {
            $modPasienPulang->tglpasienpulang = MyFormatter::formatDateTimeForUser($modPasienPulang->tglpasienpulang);
        } else {
            $modPasienPulang = new PasienpulangT();
        }
        $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);

        $daftar = date('Y-m-d', strtotime($modPendaftaran->tgl_pendaftaran));
        $pulang = empty($modPasienPulang->tglpasienpulang) ? date('Y-m-d') : $modPasienPulang->tglpasienpulang;

        $vpulang = date('Y-m-d', strtotime($pulang));

        $tgl_daftar = MyFormatter::formatDateTimeForUser($daftar);
        $tgl_pulang = MyFormatter::formatDateTimeForUser($vpulang);

        $val_daftar = strtotime($daftar);
        $val_pulang = strtotime($vpulang);

        $lamatrawat = (($val_pulang - $val_daftar) / (3600 * 24)) + 1;
        $model->lamarawat = $lamatrawat;

        $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruangan_id));
        $diagnosaUtama = "";
        $diagnosaTambahan = "";
        $diagnosa_id = null;

        if (count((array) $pasienMorbid) > 0) {
            $indexKel2 = 0;
            $indexKel3 = 0;

            foreach ($pasienMorbid as $datamorbid) {
                $diagnosa_id = $datamorbid->diagnosa_id;
                if ($datamorbid->kelompokdiagnosa_id == 2) {
                    if ($indexKel2 > 0) {
                        $diagnosaUtama .= ", ";
                    }
                    $diagnosaUtama .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel2++;
                }

                if ($datamorbid->kelompokdiagnosa_id == 3) {
                    if ($indexKel3 > 0) {
                        $diagnosaTambahan .= ", ";
                    }
                    $diagnosaTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel3++;
                }
            }
        }
        $model->diagnosa_masuk = "Diagnosa Utama: " . $diagnosaUtama . " \n\n Diagnosa Tambahan: " . $diagnosaTambahan;

        $modRencanaOperasi = RencanaoperasiT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'pasienadmisi_id' => $modPendaftaran->pasienadmisi_id));
        $modTindakanPelayanan = TindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'pasienadmisi_id' => $modPendaftaran->pasienadmisi_id));

        $this->layout = '//layouts/printWindows';
        $this->render($this->path_view . 'prinout/index', array(
            'model' => $model,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modPasienPulang' => $modPasienPulang,
            'pasienMorbid' => $pasienMorbid,
            'modRencanaOperasi' => $modRencanaOperasi,
            'modTindakanPelayanan' => $modTindakanPelayanan
        ));
    }

    /**
     * untuk menampilkan data dokter dari autocomplete
     * - nama_pegawai
     */
    public function actionAutocompleteDokterRawat()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $nama_pegawai = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
            $criteria->order = 'nama_pegawai';
            $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
            $criteria->limit = 5;

            $models = RIDokterV::model()->findAll($criteria); //default
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->NamaLengkap;
                $returnVal[$i]['value'] = $model->NamaLengkap;
                $returnVal[$i]['pegawai_id'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionlihatRiwayatPasienPulang($id)
    {
        $model = RingkasanmasukdankeluarT::model()->findByPk($id);
        $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($model->pendaftaran_id);
        $modPasienAdmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
        $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $ruangan_id = $model->ruangan_id;

        $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir);
        $model->pekerjaan_nama = (isset($model->pekerjaan) ? $model->pekerjaan->pekerjaan_nama : "");
        $model->pendidikan_nama = (isset($model->pendidikan) ? $model->pendidikan->pendidikan_nama : "");
        $model->nama_pj = (isset($model->penanggungjawab) ? $model->penanggungjawab->nama_pj : "");
        $model->alamat_pj = (isset($model->penanggungjawab) ? $model->penanggungjawab->alamat_pj : "");
        $model->hubungankeluarga = (isset($model->penanggungjawab) ? $model->penanggungjawab->hubungankeluarga : "");
        $model->imunisasididapat = CJSON::decode($model->imunisasididapat);
        // $model->tindakanyangdipilih = CJSON::decode($model->tindakanyangdipilih);

        $model->dokter_yangmerawat_nama = !empty($model->dokteryangmerawat) ? $model->dokteryangmerawat->namaLengkap : '';


        $modPendaftaran->carabayar_nama = $modPendaftaran->carabayar->carabayar_nama;
        $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        $modPendaftaran->kelaspelayanan_nama = $modPendaftaran->kelaspelayanan->kelaspelayanan_nama;
        $pasienpulang_id = $modPendaftaran->pasienpulang_id;
        if (isset($modPasienAdmisi)) {
            $modPendaftaran->carabayar_nama = $modPasienAdmisi->carabayar->carabayar_nama;
            $modPendaftaran->ruangan_nama = $modPasienAdmisi->ruangan->ruangan_nama;
            $modPendaftaran->kelaspelayanan_nama = $modPasienAdmisi->kelaspelayanan->kelaspelayanan_nama;
            $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPasienAdmisi->tgladmisi);
            $pasienpulang_id = $modPasienAdmisi->pasienpulang_id;
        }
        $modPasienPulang = PasienpulangT::model()->findByPk($pasienpulang_id);
        if (isset($modPasienPulang)) {
            $modPasienPulang->tglpasienpulang = MyFormatter::formatDateTimeForUser($modPasienPulang->tglpasienpulang);
        } else {
            $modPasienPulang = new PasienpulangT();
        }
        $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);

        $daftar = date('Y-m-d', strtotime($modPendaftaran->tgl_pendaftaran));
        $pulang = empty($modPasienPulang->tglpasienpulang) ? date('Y-m-d') : $modPasienPulang->tglpasienpulang;

        $vpulang = date('Y-m-d', strtotime($pulang));

        $val_daftar = strtotime($daftar);
        $val_pulang = strtotime($vpulang);

        $lamatrawat = (($val_pulang - $val_daftar) / (3600 * 24)) + 1;
        $model->lamarawat = $lamatrawat;

        $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruangan_id));
        $diagnosaUtama = "";
        $diagnosaTambahan = "";
        $diagnosa_id = null;

        if (count((array) $pasienMorbid) > 0) {
            $indexKel2 = 0;
            $indexKel3 = 0;

            foreach ($pasienMorbid as $datamorbid) {
                $diagnosa_id = $datamorbid->diagnosa_id;
                if ($datamorbid->kelompokdiagnosa_id == 2) {
                    if ($indexKel2 > 0) {
                        $diagnosaUtama .= ", ";
                    }
                    $diagnosaUtama .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel2++;
                }

                if ($datamorbid->kelompokdiagnosa_id == 3) {
                    if ($indexKel3 > 0) {
                        $diagnosaTambahan .= ", ";
                    }
                    $diagnosaTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel3++;
                }
            }
        }
        $model->diagnosa_masuk = "Diagnosa Utama: " . $diagnosaUtama . " \n\n Diagnosa Tambahan: " . $diagnosaTambahan;

        $this->render($this->path_view . 'view', array(
            'model' => $model,
            'modDaftar' => $modPendaftaran,
            'modPas' => $modPasien,
            'modAdmisi' => $modPasienAdmisi,
            'modPulang' => $modPasienPulang,
        ));
    }
    public function loadModel($id)
    {
        $model = RingkasanmasukdankeluarT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    public function actionDelete($id, $pendaftaran_id=null)
    {
        $this->loadModel($id)->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(Yii::app()->controller->createUrl('/rawatInap/ringkasanMasukKeluar/index',array('pendaftaran_id'=> $pendaftaran_id, 'frame'=>1)));
            //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index', array('pendaftaran_id'=> $pendaftaran_id, 'frame'=>1)));
    }

    public function actionAutocompleteNamaDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
    //   var_dump($_GET);die;
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->order = 'nama_pegawai';
    //   $criteria->addCondition('instalasi_id ='.Params::INSTALASI_ID_RI);
      $criteria->addCondition('jabatan_id is not null');  
      $criteria->limit = 5;

      $models = PegawaiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->namaLengkap;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
