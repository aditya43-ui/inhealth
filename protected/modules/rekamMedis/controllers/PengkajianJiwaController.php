<?php

/**
 * Description of PengkaijanJiwaController
 *
 * @author inova
 */
class PengkajianJiwaController extends MyAuthController {

    public $path_view = "rekamMedis.views.pengkajianJiwa.";

    public function actionIndex($pendaftaran_id, $id = null) {

        $this->layout = "//layouts/iframe";

        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $pasien = PasienM::model()->findByPk($pendaftaran->pasien_id);

        if (!empty($id)) {
            $model = AskepkesehatanjiwaT::model()->findByPk($id);
            if (empty($model)) {
                $model = new AskepkesehatanjiwaT;
                $model->pendaftaran_id = $pendaftaran->pendaftaran_id;
                $model->tgl_pengkajian = date('Y-m-d');
                $model->jam_pengkajian = date('H:i:s');
            } else {
                $model->caraberpakaian = empty($model->caraberpakaian) ? null : CJSON::decode($model->caraberpakaian);
                $model->jenisaktivitas = empty($model->jenisaktivitas) ? null : CJSON::decode($model->jenisaktivitas);
                $model->interaksiselama_wawancara = empty($model->interaksiselama_wawancara) ? null : CJSON::decode($model->interaksiselama_wawancara);
                $model->alamperasaan = empty($model->alamperasaan) ? null : CJSON::decode($model->alamperasaan);
                $model->afek = empty($model->afek) ? null : CJSON::decode($model->afek);
                $model->halusinasi = empty($model->halusinasi) ? null : CJSON::decode($model->halusinasi);
                $model->bentukpikir = empty($model->bentukpikir) ? null : CJSON::decode($model->bentukpikir);
                $model->aruspikir = empty($model->aruspikir) ? null : CJSON::decode($model->aruspikir);
                $model->isipikir = empty($model->isipikir) ? null : CJSON::decode($model->isipikir);
                $model->waham = empty($model->waham) ? null : CJSON::decode($model->waham);
                $model->tingkatkesaradaran = empty($model->tingkatkesaradaran) ? null : CJSON::decode($model->tingkatkesaradaran);
                $model->dayaingat = empty($model->dayaingat) ? null : CJSON::decode($model->dayaingat);
                $model->konsentasidanhitung = empty($model->konsentasidanhitung) ? null : CJSON::decode($model->konsentasidanhitung);
                $model->insight = empty($model->insight) ? null : CJSON::decode($model->insight);
                $model->koping_adatif = empty($model->koping_adatif) ? null : CJSON::decode($model->koping_adatif);
                $model->koping_maladatif = empty($model->koping_maladatif) ? null : CJSON::decode($model->koping_maladatif);
                $model->kurangnyapendidikan = empty($model->kurangnyapendidikan) ? null : CJSON::decode($model->kurangnyapendidikan);
                
                $model->informan_kecamatan_id = empty($model->informan_kelurahan_id) ? null : $model->informan_kelurahan->kecamatan_id;
                $model->informan_kabupaten_id = empty($model->informan_kelurahan_id) ? null : $model->informan_kelurahan->kecamatan->kabupaten_id;
                $model->informan_propinsi_id = empty($model->informan_kelurahan_id) ? null : $model->informan_kelurahan->kecamatan->kabupaten->propinsi_id;
                
                $model->suhutubuh = empty($model->suhutubuh) ? null : number_format($model->suhutubuh, 2, ",", "");
                
                $model->informan_istinggalserumah = $model->informan_istinggalserumah ? "Ya" : "Tidak";
                
            }
        } else {
            $model = new AskepkesehatanjiwaT;
            $model->pendaftaran_id = $pendaftaran->pendaftaran_id;
            $model->tgl_pengkajian = date('Y-m-d');
            $model->jam_pengkajian = date('H:i:s');
        }
        

        $model->tgl_pengkajian = MyFormatter::formatDateTimeForUser($model->tgl_pengkajian);


        if (isset($_POST['AskepkesehatanjiwaT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            
            if (isset($_POST['AskepkesehatanjiwaT']['askepkesehatanjiwa_id']) && !empty($_POST['AskepkesehatanjiwaT']['askepkesehatanjiwa_id'])) {
                $model = AskepkesehatanjiwaT::model()->findByPk($_POST['AskepkesehatanjiwaT']['askepkesehatanjiwa_id']);
            } else {
                $model = new AskepkesehatanjiwaT;
            }

            try {
                
                $ok = $ok && $this->submitData($model, $_POST);

                // var_dump($ok, $model->attributes, $_POST); die;
                // die;
                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil </strong> Data berhasil disimpan');
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal </strong> Data gagal disimpan');
                }
            } catch (Exception $ex) {
                $trans->rollback();
                //echo $ex->getMessage();
                Yii::app()->user->setFlash('error', '<strong>Gagal </strong> Data gagal disimpan ' . $ex->getMessage);
            }
        }


        $this->render($this->path_view . "indexPengkajian", array(
            'pendaftaran' => $pendaftaran,
            'pasien' => $pasien,
            'model' => $model,
        ));
    }
    
    
    public function actionAjaxSubmitPengkajianJiwa() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $ajax_ok = 1;
        $msg = "Data berhasil disimpan";
        $id = null;
        
        if (isset($_POST['AskepkesehatanjiwaT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;

            if (isset($_POST['AskepkesehatanjiwaT']['askepkesehatanjiwa_id']) && !empty($_POST['AskepkesehatanjiwaT']['askepkesehatanjiwa_id'])) {
                $model = AskepkesehatanjiwaT::model()->findByPk($_POST['AskepkesehatanjiwaT']['askepkesehatanjiwa_id']);
            } else {
                $model = new AskepkesehatanjiwaT;
            }
            
            try {
                
                $ok = $ok && $this->submitData($model, $_POST);
                $id = $model->askepkesehatanjiwa_id;
                

                // var_dump($ok, $model->attributes, $_POST); die;
                // die;
                if ($ok) {
                    $trans->commit();
                } else {
                    $trans->rollback();
                    $ajax_ok = 0;
                    $msg = "Data gagal disimpan";
                }
            } catch (Exception $ex) {
                $trans->rollback();
                //echo $ex->getMessage();
                $ajax_ok = 0;
                $msg = "Data gagal disimpan. ".$ex->getMessage();
            }
        }
        
        echo CJSON::encode(array(
            'ok'=>$ajax_ok,
            'msg'=>$msg,
            'id'=>$id,
        ));
        
    }

    public function submitData(&$model, $post) {
        
        $ok = true;
        
        $model->attributes = $post['AskepkesehatanjiwaT'];

        $model->tgl_pengkajian = MyFormatter::formatDateTimeForDB($model->tgl_pengkajian);

        $model->caraberpakaian = empty($model->caraberpakaian) ? null : CJSON::encode($model->caraberpakaian);
        $model->jenisaktivitas = empty($model->jenisaktivitas) ? null : CJSON::encode($model->jenisaktivitas);
        $model->interaksiselama_wawancara = empty($model->interaksiselama_wawancara) ? null : CJSON::encode($model->interaksiselama_wawancara);
        $model->alamperasaan = empty($model->alamperasaan) ? null : CJSON::encode($model->alamperasaan);
        $model->afek = empty($model->afek) ? null : CJSON::encode($model->afek);
        $model->halusinasi = empty($model->halusinasi) ? null : CJSON::encode($model->halusinasi);
        $model->bentukpikir = empty($model->bentukpikir) ? null : CJSON::encode($model->bentukpikir);
        $model->aruspikir = empty($model->aruspikir) ? null : CJSON::encode($model->aruspikir);
        $model->isipikir = empty($model->isipikir) ? null : CJSON::encode($model->isipikir);
        $model->waham = empty($model->waham) ? null : CJSON::encode($model->waham);
        $model->tingkatkesaradaran = empty($model->tingkatkesaradaran) ? null : CJSON::encode($model->tingkatkesaradaran);
        $model->dayaingat = empty($model->dayaingat) ? null : CJSON::encode($model->dayaingat);
        $model->konsentasidanhitung = empty($model->konsentasidanhitung) ? null : CJSON::encode($model->konsentasidanhitung);
        $model->insight = empty($model->insight) ? null : CJSON::encode($model->insight);
        $model->koping_adatif = empty($model->koping_adatif) ? null : CJSON::encode($model->koping_adatif);
        $model->koping_maladatif = empty($model->koping_maladatif) ? null : CJSON::encode($model->koping_maladatif);
        $model->kurangnyapendidikan = empty($model->kurangnyapendidikan) ? null : CJSON::encode($model->kurangnyapendidikan);
        $model->informan_istinggalserumah = $model->informan_istinggalserumah == "Ya";

        $model->suhutubuh = str_replace(",", ".", $model->suhutubuh);

        if ($model->isNewRecord) {
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai = Yii::app()->user->id;
            $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai = Yii::app()->user->id;

        if ($model->validate()) {
            $ok = $ok && $model->save();
        } else {
            $ok = false;
        }
        
//        var_dump($ok, $model->errors);

        RiwayataniayaT::model()->deleteAllByAttributes(array(
            'askepkesehatanjiwa_id'=>$model->askepkesehatanjiwa_id,
        ));
        if (isset($post['RiwayataniayaT']) && is_array($post['RiwayataniayaT'])) {
            foreach ($post['RiwayataniayaT'] as $jenis => $item) {
                foreach ($item as $item_det) {
                    $det = new RiwayataniayaT();
                    $det->jenisaniaaya = $jenis;
                    $det->attributes = $model->attributes;
                    $det->attributes = $item_det;
                    $det->askepkesehatanjiwa_id = $model->askepkesehatanjiwa_id;
                    $det->create_loginpemakai_id = $model->create_loginpemakai;
                    $det->update_loginpemakai_id = $model->update_loginpemakai;

                    $ok = $ok && $det->save();

                    // var_dump($det->errors, $det->attributes);
                }
            }
        }
        
//        var_dump($ok);

        DaftarkeluargaGangguangjiwaT::model()->deleteAllByAttributes(array(
            'askepkesehatanjiwa_id'=>$model->askepkesehatanjiwa_id,
        ));
        if (isset($post['DaftarkeluargaGangguangjiwaT']) && is_array($post['DaftarkeluargaGangguangjiwaT'])) {
            foreach ($post['DaftarkeluargaGangguangjiwaT'] as $item) {
                if (!is_array($item)) {
                    continue;
                }

                $det = new DaftarkeluargaGangguangjiwaT();
                $det->attributes = $model->attributes;
                $det->attributes = $item;
                $det->create_loginpemakai_id = $model->create_loginpemakai;
                $det->update_loginpemakai_id = $model->update_loginpemakai;

                $ok = $ok && $det->save();

//                        var_dump($det->errors, $det->attributes);
            }
        }

//        var_dump($ok);
        
        DiagnosajiwapasienT::model()->deleteAllByAttributes(array(
            'askepkesehatanjiwa_id'=>$model->askepkesehatanjiwa_id,
        ));
        if (isset($post['DiagnosajiwapasienT']['diagnosakesehatanjiwa_id']) && is_array($post['DiagnosajiwapasienT']['diagnosakesehatanjiwa_id'])) {
            foreach ($post['DiagnosajiwapasienT']['diagnosakesehatanjiwa_id'] as $jenis => $item) {
                foreach ($item as $kelompok => $item_det) {
                    foreach ($item_det as $item_dat) {
                        
                        
                        $det = new DiagnosajiwapasienT;
                        $det->attributes = $model->attributes;
                        $det->create_loginpemakai_id = $model->create_loginpemakai;
                        $det->update_loginpemakai_id = $model->update_loginpemakai;
                        $det->diagnosakesehatanjiwa_id = $item_dat;

                        $ok = $ok && $det->save();


                        // var_dump($det->errors, $det->attributes);
                    }
                }
            }
        }
        
//        var_dump($ok);
//        die;
        
        return $ok;
    }

    public function actionAutocompletePerawatPengkaji($term = null) {

        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $model = new RKPegawaiM();
        $model->unsetAttributes();
        $model->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
        $model->nama_pegawai = $term;

        $prov = $model->searchDialog2();
        $prov->pagination = false;

        $res = array();

        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['nama_pegawai'] = $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->pegawai_id;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    public function actionGetRuanganPasien() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
            $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
            $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);

            if (isset($_POST['jeniskasuspenyakit_id'])) {
                $jeniskasuspenyakit_id = (isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null);
                $jenisKasusPenyakit = '';
                $criteria = new CDbCriteria;
                $criteria->select = 't.ruangan_id, t.jeniskasuspenyakit_id, ruangan_m.ruangan_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_nama,
									jeniskasuspenyakit_aktif';
                if (!empty($ruangan_id)) {
                    $criteria->addCondition("t.ruangan_id = " . $ruangan_id);
                }
                if (!empty($jeniskasuspenyakit_id)) {
                    $criteria->addCondition('t.jeniskasuspenyakit_id = ' . $jeniskasuspenyakit_id);
                }
                $criteria->addCondition('jeniskasuspenyakit_m.jeniskasuspenyakit_aktif is true');
                $criteria->join = 'LEFT JOIN ruangan_m on t.ruangan_id = ruangan_m.ruangan_id
								   LEFT JOIN jeniskasuspenyakit_m on t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
									';
                $dataJenisPenyakit = KasuspenyakitruanganM::model()->findAll($criteria);
//                $dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.' AND jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');

                foreach ($dataJenisPenyakit AS $jenisPenyakit) {
                    if ($jenisPenyakit['jeniskasuspenyakit_id'] == $jeniskasuspenyakit_id) {
                        $jenisKasusPenyakit .= '<option value="' . $jenisPenyakit['jeniskasuspenyakit_id'] . '" selected="selected">' . $jenisPenyakit['jeniskasuspenyakit_nama'] . '</option>';
                    } else {
                        $jenisKasusPenyakit .= '<option value="' . $jenisPenyakit['jeniskasuspenyakit_id'] . '">' . $jenisPenyakit['jeniskasuspenyakit_nama'] . '</option>';
                    }
                }
                $data['jenisKasusPenyakit'] = $jenisKasusPenyakit;
            }


            if (isset($_POST['pegawai_id'])) {
                $pegawai_id = $_POST['pegawai_id'];
                $ruangan_id = $_POST['ruangan_id'];
                $criteria = new CDbCriteria;
                $criteria->select = 't.ruangan_id, t.pegawai_id, t.nama_pegawai';
                if (!empty($ruangan_id)) {
                    $criteria->addCondition("t.ruangan_id = " . $ruangan_id);
                }
                if (!empty($pegawai_id)) {
                    $criteria->addCondition('t.pegawai_id = ' . $pegawai_id);
                }
                $dataDokter = DokterV::model()->findAll($criteria);
//                $dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.' AND jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');
                $dokter = '';
                foreach ($dataDokter AS $dokters) {
                    if ($dokters['pegawai_id'] == $pegawai_id) {
                        $dokter .= '<option value="' . $dokters['pegawai_id'] . '" selected="selected">' . $dokters['nama_pegawai'] . '</option>';
                    } else {
                        $dokter .= '<option value="' . $dokters['pegawai_id'] . '">' . $dokters['nama_pegawai'] . '</option>';
                    }
                }
                $data['dokter'] = $dokter;
            }

            $dropDown = '';
            $dataRuangan = RuanganM::model()->findAll('instalasi_id=' . $instalasi_id . ' AND ruangan_aktif=TRUE ORDER BY ruangan_nama');
            foreach ($dataRuangan AS $tampilRuangan) {
                if ($tampilRuangan['ruangan_id'] == $ruangan_id) {
                    $dropDown .= '<option value="' . $tampilRuangan['ruangan_id'] . '" selected="selected" onchange="getKasusPenyakit(' . $ruangan_id . ')">' . $tampilRuangan['ruangan_nama'] . '</option>';
                } else {
                    $dropDown .= '<option value="' . $tampilRuangan['ruangan_id'] . '" onchange="return getKasusPenyakit(' . $ruangan_id . ')">' . $tampilRuangan['ruangan_nama'] . '</option>';
                }
            }
            $data['dropDown'] = $dropDown;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Mengatur dropdown kabupaten
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $modPasien = new AskepkesehatanjiwaT;
            if ($model_nama !== '' && $attr == '') {
                $propinsi_id = $_POST["$model_nama"]['informan_propinsi_id'];
            } elseif ($model_nama == '' && $attr !== '') {
                $propinsi_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $propinsi_id = $_POST["$model_nama"]["$attr"];
            }
            $kabupaten = null;
            if ($propinsi_id) {
                $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
                $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
            }
            if ($encode) {
                echo CJSON::encode($kabupaten);
            } else {
                if (empty($kabupaten)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($kabupaten as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * Mengatur dropdown kecamatan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $modPasien = new AskepkesehatanjiwaT;
            if ($model_nama !== '' && $attr == '') {
                $kabupaten_id = $_POST["$model_nama"]['informan_kabupaten_id'];
            } elseif ($model_nama == '' && $attr !== '') {
                $kabupaten_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $kabupaten_id = $_POST["$model_nama"]["$attr"];
            }
            $kecamatan = null;
            if ($kabupaten_id) {
                $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
                $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');
            }

            if ($encode) {
                echo CJSON::encode($kecamatan);
            } else {
                if (empty($kecamatan)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($kecamatan as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * Mengatur dropdown kelurahan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $modPasien = new AskepkesehatanjiwaT;
            if ($model_nama !== '' && $attr == '') {
                $kecamatan_id = $_POST["$model_nama"]['informan_kecamatan_id'];
            } elseif ($model_nama == '' && $attr !== '') {
                $kecamatan_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $kecamatan_id = $_POST["$model_nama"]["$attr"];
            }
            $kelurahan = null;
            if ($kecamatan_id) {
                $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
//                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
                $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');
            }

            if ($encode) {
                echo CJSON::encode($kelurahan);
            } else {
                if (empty($kelurahan)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($kelurahan as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    public function actionSimpanTambahDiagnosa() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        if (isset($_POST['DiagnosakesehatanjiwaM'])) {

            $ok = 1;
            $msg = "Diagnosa kesehatang jiwa berhasil ditambah.";
            $html = "";


            $trans = Yii::app()->db->beginTransaction();

            try {
                $mod = new DiagnosakesehatanjiwaM;
                $mod->attributes = $_POST['DiagnosakesehatanjiwaM'];

                $mod->create_time = $mod->update_time = date('Y-m-d H:i:s');
                $mod->create_loginpemakai = $mod->update_loginpemakai = Yii::app()->user->id;
                $mod->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                $mod->urutan = 1;

                $mod->save();

                // var_dump($mod->errors, $mod->attributes); die;

                $trans->commit();

                $html = CHtml::activeCheckBoxList(DiagnosajiwapasienT::model(), 'diagnosakesehatanjiwa_id[' . $mod->jenisdiagnosa . '][' . $mod->kelompokdiagnosa . ']', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                'isaktif' => true, 'jenisdiagnosa' => $mod->jenisdiagnosa, 'kelompokdiagnosa' => $mod->kelompokdiagnosa,
                                ), array('order' => 'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue' => null));
            } catch (Exception $ex) {
                $trans->rollback();
                $ok = 0;
                $msg = "Diagnosa kesehatang jiwa gagal ditambah. " . $ex->getMessage();
            }


            echo CJSON::encode(array(
                'ok' => $ok,
                'msg' => $msg,
                'html' => $html,
            ));
//            
//            
//            
//            
//            
//            
//            
//            var_dump($mod->attributes);
//            die;
        }
    }

    public function actionTambahKeluargaJiwa() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $hubungan = $_POST['hubungan'];
        $gejala = $_POST['gejala'];
        $riwayatpengobatan = $_POST['riwayatpengobatan'];
        $idx = $_POST['idx'];

        $mod = new DaftarkeluargaGangguangjiwaT;
        $mod->hubungankeluarga = $hubungan;
        $mod->gejala = $gejala;
        $mod->riwayatpengobatan = $riwayatpengobatan;

        $ok = 1;
        $html = $this->renderPartial($this->path_view . "form.predisposisi.biologik._rowKeluargaJiwa", array(
            'mod' => $mod, 'i' => $idx, 'no' => '',
            ), true);

        echo CJSON::encode(array(
            'ok' => $ok,
            'html' => $html,
        ));
    }

    public function actionTambahDataRiwayatAniaya() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $jenisaniaya = $_POST['jenisaniaya'];
        $idx = $_POST['idx'];

        $model = new RiwayataniayaT();
        $ok = 1;
        $html = $this->renderPartial($this->path_view . "form.predisposisi.psikososial._rowAniaya", array(
            'mod' => $model, 'i' => $idx, 'jenisaniaya' => $jenisaniaya
            ), true);

        echo CJSON::encode(array(
            'ok' => $ok,
            'html' => $html,
        ));
    }
    
    public function actionHapusRiwayat() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data berhasil dihapus";
        
        $id = $_POST['id'];
        
        try {
            
            RiwayataniayaT::model()->deleteAllByAttributes(array(
                'askepkesehatanjiwa_id'=>$id,
            ));
            DaftarkeluargaGangguangjiwaT::model()->deleteAllByAttributes(array(
                'askepkesehatanjiwa_id'=>$id,
            ));
            DiagnosajiwapasienT::model()->deleteAllByAttributes(array(
                'askepkesehatanjiwa_id'=>$id,
            ));
            AskepkesehatanjiwaT::model()->deleteByPk($id);
            
            $trans->commit();
            
        } catch (Exception $ex) {
            $trans->rollback();
            $ok = 0;
            $msg = "Data gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'sukses'=>$ok,
            'msg'=>$msg,
        ));
        
    }
    
    
    public function actionDetail($pendaftaran_id, $id) {
        
        $this->layout = "//layouts/iframe";
        
        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $model = AskepkesehatanjiwaT::model()->findByPk($id);
        $diagnosa = CHtml::listData(DiagnosajiwapasienT::model()->findAllByAttributes(array(
            'askepkesehatanjiwa_id'=>$id,
        )), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_id');
        
        if (empty($pendaftaran) || empty($model)) {
            echo "Data tidak ditemukan";
        }
        
        $this->render($this->path_view.'detail', array(
            'pendaftaran'=>$pendaftaran, 'model'=>$model, 'diagnosa'=>$diagnosa,
        ));
        
    }
    
    public function actionPrint($id) {
        
        $this->layout = "//layouts/printWindows";
        
        $model = AskepkesehatanjiwaT::model()->findByPk($id);
        $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $diagnosa = CHtml::listData(DiagnosajiwapasienT::model()->findAllByAttributes(array(
            'askepkesehatanjiwa_id'=>$id,
        )), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_id');
        
        if (empty($pendaftaran) || empty($model)) {
            echo "Data tidak ditemukan";
        }
        
        $this->render($this->path_view.'print', array(
            'pendaftaran'=>$pendaftaran, 'model'=>$model, 'diagnosa'=>$diagnosa,
        ));
        
    }

}
