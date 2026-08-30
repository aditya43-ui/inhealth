<?php

class PeriksaRujukanController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'index';

    public function actionIndex($pendaftaran_id, $pasienkirimkeunitlain_id, $pasienmasukpenunjang_id = null) {
   
        $modPendaftaran = HDPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = HDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modPasienrujukan = PasienrujukanhdV::model()->findByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);
        $modKirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);        
        
        if(!empty($pasienmasukpenunjang_id)) {
            $model = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
            $model->nama_pegawai = (!empty($model->pegawai_id)) ? PegawaiM::model()->findByPk($model->pegawai_id)->namaLengkap : "";
        }

        if(empty($model)) {
            $model = new PasienmasukpenunjangT();
            $model->pegawai_id = $modKirim->pegawai_id;
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->tglmasukpenunjang = date('Y-m-d H:i:s');
            $model->nama_pegawai = (!empty($model->pegawai_id)) ? PegawaiM::model()->findByPk($model->pegawai_id)->namaLengkap : "";
        }
        
        if (empty($model->shift_id)){
            $cekShiftHd = ShiftHdM::model()->find(" shift_hd_aktif = TRUE AND ( '".date('H:i:s')."' >= shift_hd_jamawal AND '".date('H:i:s')."' <= shift_hd_jamakhir) ");
            if (!empty($cekShiftHd)){
                $model->shift_id = $cekShiftHd->shift_hd_id;
            }
        }
        
        $modJadwalhemodialisa = new JadwalhemodialisaT();
        if (!empty($pasienmasukpenunjang_id)) {
            $modJadwalhemodialisa = JadwalhemodialisaT::model()->findByAttributes(['pasienmasukpenunjang_id' => $pasienmasukpenunjang_id]);
            if (!empty($modJadwalhemodialisa)) {
                $modJadwalhemodialisa->jadwalhemodialisa_tgl_ke = date('d M Y H:i:s', strtotime($modJadwalhemodialisa->jadwalhemodialisa_tgl_ke));
                $modJadwalhemodialisa->shift_id = $modJadwalhemodialisa->shift_id;
            } else {
                $modJadwalhemodialisa = new JadwalhemodialisaT();
            }
        }

        if (isset($_POST['JadwalhemodialisaT'])) {
            $ok = true;
            // echo '<pre>';var_dump($_POST);die;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $save = false;

                $modPenunjang = new PasienmasukpenunjangT();
                $modPenunjang->attributes = $modPendaftaran->attributes;
                $modPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modPenunjang->shift_id = $_POST['PasienmasukpenunjangT']['shift_id'];
                $modPenunjang->kamarruangan_id = $_POST['PasienmasukpenunjangT']['kamarruangan_id'];
                $modPenunjang->keterangan_hd = $_POST['PasienmasukpenunjangT']['keterangan_hd'];
                $modPenunjang->pegawai_id = $_POST['PasienmasukpenunjangT']['pegawai_id'];
                $modPenunjang->is_verifikasi_hd = true;
                $modPenunjang->pasienkirimkeunitlain_id = $modKirim->pasienkirimkeunitlain_id;
                $modPenunjang->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                $modPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang2('HD');
                $modPenunjang->tglmasukpenunjang = date('Y-m-d H:i:s');
                $modPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
                $modPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modPenunjang->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $modPenunjang->create_time = date('Y-m-d H:i:s');
                $modPenunjang->create_time = date('Y-m-d H:i:s');
                $modPenunjang->ruangan_id = $_POST['PasienmasukpenunjangT']['ruangan_id'];
                $modPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPenunjang->ruangan_id);
                if (!empty($modKirim)) {
                  $modPenunjang->ruanganasal_id = $modKirim->create_ruangan;
                }

                if($modPenunjang->validate()) {
                    if($modPenunjang->save()) {
                        $save = true;
                    } else {
                        $save = false;
                    }
                } else {
                    $save = false;
                }

                if(isset($_POST['JadwalhemodialisaT']) && $save){
                    if (!empty($_POST['JadwalhemodialisaT']['jadwalhemodialisa_tgl_ke']) && !empty($_POST['JadwalhemodialisaT']['shift_id']) ){
                        $modJadwalhemodialisa = new JadwalhemodialisaT();
                        $modJadwalhemodialisa->attributes = $_POST['JadwalhemodialisaT'];
                        $modJadwalhemodialisa->pasienmasukpenunjang_id = $modPenunjang->pasienmasukpenunjang_id;
                        $modJadwalhemodialisa->shift_id = $_POST['JadwalhemodialisaT']['shift_id'];
                        $modJadwalhemodialisa->pasien_id = $modPendaftaran->pasien_id;
                        $modJadwalhemodialisa->pendaftaran_id = $pendaftaran_id;
                        $modJadwalhemodialisa->kamarruangan_id = $_POST['PasienmasukpenunjangT']['kamarruangan_id'];

                        $modJadwalhemodialisa->jadwalhemodialisa_tgl_ke = MyFormatter::formatDateTimeForDb($modJadwalhemodialisa->jadwalhemodialisa_tgl_ke);
                        $modJadwalhemodialisa->ruangan_id = $model->ruangan_id;

                        $cri = new CDbCriteria();
                        $cri->select = "max(jadwalhemodialisa_ke) as jadwalke";
                        $cri->addCondition('pasien_id = ' . $modPendaftaran->pasien_id);
                        $incremen = JadwalhemodialisaT::model()->find($cri);
                        $modKonsPoli = KonsulpoliT::model()->findByPk($pendaftaran_id);

                        if(empty($incremen->jadwalke)) {

                            $jadwalke = 1;
                        } else {
                            $jadwalke = $incremen->jadwalke + 1;
                        }

                        $modJadwalhemodialisa->jadwalhemodialisa_ke = $jadwalke;
                        $modJadwalhemodialisa->jadwalhemodialisa_status = 0;
                        $modJadwalhemodialisa->pegawai_id = Yii::app()->user->getState('pegawai_id');
                        $modJadwalhemodialisa->membuat_id = Yii::app()->user->getState('pegawai_id');
                        $modJadwalhemodialisa->mengetahui_id = Yii::app()->user->getState('pegawai_id');
                        $modJadwalhemodialisa->jh_create_time = date('Y-m-d');
                        $modJadwalhemodialisa->jh_update_time = date('Y-m-d');
                        $modJadwalhemodialisa->jh_create_loginid = Yii::app()->user->getState('pegawai_id');
                        $modJadwalhemodialisa->jh_create_ruanganid = Yii::app()->user->getState('ruangan_id');
                        $modJadwalhemodialisa->jh_create_ruanganiphost = '127.0.1.1';                            
                        
                        $hari = $modJadwalhemodialisa->jadwalhemodialisa_hari;
                        $harijad = 'jadwalhari_hari_'.strtolower($hari);

                        $jadwalhari = JadwalhariM::model()->findByAttributes([
                            $harijad => true
                        ]);
                        $modJadwalhemodialisa->jadwalhari_id = !empty($jadwalhari->jadwalhari_id)?$jadwalhari->jadwalhari_id:1;
                        // echo '<pre>';
                        // var_dump($modJadwalhemodialisa);die;
                        if ($modJadwalhemodialisa->save()) {
                            $save = true;
                        }else {
                            $save = false;
                        }
                    }else{                            
                        $save = true;
                    }
                } else {                        
                   $save = false;
                }
               
                if($save) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienkirimkeunitlain_id' => $modKirim->pasienkirimkeunitlain_id, 'pasienmasukpenunjang_id' => $modPenunjang->pasienmasukpenunjang_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . CHtml::errorSummary($modJadwalhemodialisa));
                }
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', "Data gagal disimpan! " . MyExceptionMessage::getMessage($ex, true));
                echo '<pre>';var_dump($ex);die;
            }
        }

        $this->render('index', [
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modPasienrujukan' => $modPasienrujukan,
            'model' => $model,
            'modJadwalhemodialisa' => $modJadwalhemodialisa
        ]);
    }

    public function actionSetDropdownDokter() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new HDPendaftaranT;
            $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            $option1 = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            if (!empty($_POST['ruangan_id'])) {
                $data = $model->getDokterItems($_POST['ruangan_id']);
                $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');
                foreach ($data as $value => $name) {
                    if ($value == Params::PEGAWAI_DPJP_ID_STRIP) {
                        $select = true;
                    } else {
                        $select = false;
                    }
                    $option .= CHtml::tag('option', array('value' => $value, 'selected' => $select), CHtml::encode($name), true);
                }
                $data = $model->getPPJPItems($_POST['ruangan_id']);
                $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');
                foreach ($data as $value => $name) {
                    $option1 .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }

            $modRuangan = RuanganM::model()->findByPk($_POST['ruangan_id']);

            $dataList['listDokter'] = $option;
            $dataList['listPPJP'] = $option1;
            $dataList['kode_bpjs'] = $modRuangan->kode_bpjs;

            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    public function actionSetDropdownJeniskasuspenyakit() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new HDPendaftaranT;
            $option = '';
            if (!empty($_POST['ruangan_id'])) {
                $data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
                $data = CHtml::listData($data, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
                $jml = count($data);
                $count = 0;
                foreach ($data as $value => $name) {
                    if ($count == 0 && $jml > 1) {
                        $option .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    }
                    $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    $count++;
                }
            }
            $dataList['listKasuspenyakit'] = $option;
            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    public function actionSetDropdownKelasPelayananRI() {
        if (Yii::app()->request->isAjaxRequest) {
            $ruangan_id = $_POST['ruangan_id'];
            $kelasPelayanan = null;
            $option = null;
            if ($ruangan_id) {
                $kelasPelayanan = KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id=' . $ruangan_id . ' and kelaspelayanan_aktif = true');
                $kelasPelayanan = CHtml::listData($kelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama');
            }
            if (empty($kelasPelayanan)) {
                $option .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            } else {
                foreach ($kelasPelayanan as $value => $name) {
                    $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }
            $dataList['listKelas'] = $option;
            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    public function actionGetKamarKosongByKelasLantai($encode = false) {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['kelaspelayanan_id'])) {
                $ruangan_id = $_POST['ruangan_id'];
                $kelaspelayanan_id = ($_POST['kelaspelayanan_id'] == '' ? 0 : $_POST['kelaspelayanan_id']);
                $lantai_hd = ($_POST['lantai_hd'] == '' ? 0 : $_POST['lantai_hd']);

                $kamarKosong = array();
                if (!empty($ruangan_id)) {
                    $kamarKosong = KamarruanganM::model()->findAllByAttributes(
                            array(
                                'ruangan_id' => $ruangan_id,
                                'kelaspelayanan_id' => $kelaspelayanan_id,
                                'kamarruangan_status' => (isset($_POST['is_status']) ? $_POST['is_status'] : true),
                                'kamarruangan_nokamar' => $lantai_hd
                            )
                    );
                    $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'TempatTidur');
                }
            } else {
                $ruangan_id = $_POST['ruangan_id'];
                $kamarKosong = array();
                if (!empty($ruangan_id)) {
                    $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_status' => true));
                    $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'TempatTidur');
                }
            }

            if ($encode) {
                echo CJSON::encode($kamarKosong);
            } else {
                if (empty($kamarKosong)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
                } else {
                    if (count($kamarKosong) > 1) {
//						echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
                    }
                    foreach ($kamarKosong as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    public function actionGetHari() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $format = new MyFormatter();
            $tanggal = $_POST['tanggal'];
            $tanggalDB = $format->formatDateTimeForDb($tanggal); //Mengubah Tanggal inputan ke tanggal database
            $hari = date('l', strtotime($tanggalDB)); //Mendapatkan nilai hari dari tanggal yang dipilih

            if (strtolower($hari) == 'sunday') {
                $hari = 'Minggu';
            } else if (strtolower($hari) == 'monday') {
                $hari = 'Senin';
            } else if (strtolower($hari) == 'tuesday') {
                $hari = 'Selasa';
            } else if (strtolower($hari) == 'wednesday') {
                $hari = 'Rabu';
            } else if (strtolower($hari) == 'thursday') {
                $hari = 'Kamis';
            } else if (strtolower($hari) == 'friday') {
                $hari = 'Jumat';
            } else if (strtolower($hari) == 'saturday') {
                $hari = 'Sabtu';
            }
//                echo $hari;die;
            $data['hari'] = $hari;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionPrint() {
        $this->layout = '//layouts/printWindows';
        $id = $_GET['id'];
        $format = new MyFormatter;
        $model = KonsulpoliT::model()->findByPk($id);
        $modJadwalhemodialisa = JadwalhemodialisaT::model()->find('konsulpoli_id = ' . $id);
        $modPendaftaran = HDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($model->pendaftaran_id);
        $modPasien = HDPasienM::model()->findByPk($modPendaftaran->pasien_id);


        $judul_print = 'Pendaftaran Hemodialisa';
        $this->render('print', array('format' => $format,
            'judul_print' => $judul_print,
            'model' => $model,
            'modJadwalhemodialisa' => $modJadwalhemodialisa,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien
        ));
    }

    public function actionAutocompleteDokter() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
            $criteria->addCondition('kelompokpegawai_id = ' . Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP);
            $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
            $criteria->order = 'nama_pegawai';

//perhatikan ini
            $criteria->group = 'pegawai_id, nama_pegawai';
            $criteria->select = $criteria->group;

            $criteria->limit = 5;
            $models = PegawairuanganV::model()->findAll($criteria);
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
