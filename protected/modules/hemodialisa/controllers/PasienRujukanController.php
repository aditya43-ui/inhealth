<?php

class PasienRujukanController extends MyAuthController {

    public function actionIndex() {
        $model = new PasienrujukanhdV();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        if(isset($_REQUEST['PasienrujukanhdV'])){
            $model->attributes = $_REQUEST['PasienrujukanhdV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_REQUEST['PasienrujukanhdV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_REQUEST['PasienrujukanhdV']['tgl_akhir']);
        }

        $dataProvider = $model->searchPasienRujukan();

        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'pasienrujukan-m-grid') {
                $this->renderPartial('_table', ['dataProvider' => $dataProvider]);
                Yii::app()->end();
            }
        }
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider
        ));
    }

    public function actionGetRuanganAsalDariInstalasiAsal($encode = false, $namaModel = '', $attr = 'instalasi_nama') {
        if (Yii::app()->request->isAjaxRequest) {
            $instalasi = $_POST["$namaModel"][$attr];
            $str = [];
            foreach ($instalasi as $key => $value) {
                $modInstalasi = InstalasiM::model()->find("instalasi_nama = '" . $value . "'");

                $str[] = $modInstalasi->instalasi_id;
            };
//            $modInstalasi = InstalasiM::model()->find("instalasi_nama = '".$instalasi."'");
            if (!empty($str)) {
//                $ruangan = RuanganM::model()->findAll('instalasi_id='.$modInstalasi->instalasi_id.' and ruangan_aktif = true');
                $cri = new CDbCriteria();
                $cri->compare("instalasi_id", $str);
                $cri->addCondition("ruangan_aktif = true");
                $ruangan = RuanganM::model()->findAll($cri);

                $ruangan = CHtml::listData($ruangan, 'ruangan_nama', 'ruangan_nama');
//                $modRuangan = new RuanganM();
//                $modRuangan->instalasi_id = $str;
            } else {
                $ruangan = array();
            }

            if (empty($ruangan)) {
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            } else {
                if (count($ruangan) > 1) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } elseif (count($ruangan) == 0) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                }
                foreach ($ruangan as $value => $name) {
                    echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }
        }
        Yii::app()->end();
    }

    public function actionGetDokterPengirimDariRuanganAsal($encode = false, $namaModel = '', $attr = 'ruangan_nama') {
        if (Yii::app()->request->isAjaxRequest) {
            $ruangan = $_POST["$namaModel"][$attr];
            $str = [];
            foreach ($ruangan as $key => $value) {
                $modRuangan = RuanganM::model()->find("ruangan_nama = '" . $value . "'");

                $str[] = $modRuangan->instalasi_id;
            };
//            $modRuangan = RuanganM::model()->find("ruangan_nama = '" . $ruangan . "'");
            if (!empty($str)) {
//                $pegawai = PegawairuanganV::model()->findAll('ruangan_id=' . $modRuangan->ruangan_id . ' and pegawai_aktif = true');
                $cri = new CDbCriteria();
                $cri->compare("ruangan_id", $str);
                $cri->addCondition("pegawai_aktif = true");
                $pegawai = PegawairuanganV::model()->findAll($cri);

                $pegawai = CHtml::listData($pegawai, 'nama_pegawai', 'nama_pegawai');
            } else {
                $pegawai = array();
            }

            if (empty($pegawai)) {
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            } else {
                if (count($pegawai) > 1) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } elseif (count($pegawai) == 0) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                }
                foreach ($pegawai as $value => $name) {
                    echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }
        }
        Yii::app()->end();
    }

    public function actionBatalRujuk() {
        if (Yii::app()->request->isAjaxRequest) {
            $pasienkirimkeunitlain_id = $_GET['pasienkirimkeunitlain_id'];
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $modPasienmasukpenunjang = PasienmasukpenunjangT::model()->findByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);
                if(!empty($modPasienmasukpenunjang)){
                    $ok = $ok && $modPasienmasukpenunjang->delete();
                }
                $ok = $ok && PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
                if ($ok) {
                    $data['sukses'] = 1;
                    $data['status'] = 'ok';
                    $data['pesan'] = 'Data Berhasil dihapus!';
                    $trans->commit();
                } else {
                    $data['sukses'] = 0;
                    $data['status'] = 'not';
                    $data['pesan'] = 'Data Gagal dihapus!';
                    $trans->rollback();
                }
            } catch (Exception $ex) {
                $data['sukses'] = 0;
                $data['status'] = 'not';
                $data['pesan'] = 'Data Gagal dihapus! Exception';
                $trans->rollback();
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionGetRuanganNamaByMultiSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $dataRuangan = array();
            $instalasi_nama = !empty($_POST['instalasi_nama']) ? $_POST['instalasi_nama'] : null;
            $str = [];
            if(!empty($instalasi_nama)){
                foreach($instalasi_nama as $key=>$value){
                    $instalasi = InstalasiM::model()->find("instalasi_nama = '".$value."'");
                    $str[] = $instalasi->instalasi_id;
                }
            }
//            var_dump($str);die;
            $cri = new CDbCriteria();
            $cri->addCondition("ruangan_aktif = TRUE");
            if (!empty($instalasi_nama)) {
                $cri->addInCondition("instalasi_id",$str);
            }
            $cri->order = "ruangan_nama ASC";


            $ruangan = RuanganM::model()->findAll($cri);
            $val = array();
            $val['ruangan'] = '';


            if (!empty($instalasi_nama)) {
                $data = CHtml::listData($ruangan, 'ruangan_nama', 'ruangan_nama');
            } else {
                $data = null;
            }

            if (!empty($data) && count($data) > 0) {
                $val['sukses'] = 1;
                foreach ($data as $value => $name) {
                    $val['ruangan'] .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            } else {
                $val['sukses'] = 1;
            }

            echo CJSON::encode($val);
        }
        Yii::app()->end();
    }
    
    public function actionGetDokterPengirimNamaByMultiSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $dataRuangan = array();
            $ruangan_nama = !empty($_POST['ruangan_nama']) ? $_POST['ruangan_nama'] : null;
            $str = [];
            if(!empty($ruangan_nama)){
                foreach($ruangan_nama as $key=>$value){
                    $ruangan = RuanganM::model()->find("ruangan_nama = '".$value."'");
                    $str[] = $ruangan->ruangan_id;
                }
            }
//            var_dump($str);die;
            $cri = new CDbCriteria();
            $cri->addCondition("pegawai_aktif = TRUE");
            if (!empty($ruangan_nama)) {
                $cri->addInCondition("ruangan_id",$str);
            }
            $cri->order = "nama_pegawai ASC";


            $pegawai = PegawairuanganV::model()->findAll($cri);
            $val = array();
            $val['ruangan'] = '';


            if (!empty($pegawai)) {
                $data = CHtml::listData($pegawai, 'nama_pegawai', 'nama_pegawai');
            } else {
                $data = null;
            }

            if (!empty($data) && count($data) > 0) {
                $val['sukses'] = 1;
                foreach ($data as $value => $name) {
                    $val['ruangan'] .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            } else {
                $val['sukses'] = 1;
            }

            echo CJSON::encode($val);
        }
        Yii::app()->end();
    }
    
      public function actionAutocompleteDokter() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition('kelompokpegawai_id = '.Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = RIPegawaiM::model()->findAll($criteria);
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

    public function actionPilihTglPeriksa($pasienkirimkeunitlain_id, $pasien_id) {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $modKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
        $modKirimKeUnitLain->tglrencanapemeriksaan = !empty($modKirimKeUnitLain->tglrencanapemeriksaan) ? MyFormatter::formatDateTimeForUser($modKirimKeUnitLain->tglrencanapemeriksaan) : '';
        $modKirimKeUnitLain->tgl_kirimpasien = !empty($modKirimKeUnitLain->tgl_kirimpasien) ? MyFormatter::formatDateTimeForUser($modKirimKeUnitLain->tgl_kirimpasien) : '';
    
        $modPermintaan = PermintaankepenunjangT::model()->findAll("pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id");
        if(count($modPermintaan) > 0) {
          foreach ($modPermintaan as $i => $value) {
            $value->jenispemeriksaanrad_nama = $value->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama ?? '';
            $value->pemeriksaanrad_nama = $value->pemeriksaanrad->pemeriksaanrad_nama ?? '';
            $value->pemeriksaanrad_kode = $value->pemeriksaanrad->pemeriksaanrad_kode ?? '';
            if (!empty($value->tgl_rencanapemeriksaan)) {
              $value->tgl_rencanapemeriksaan = MyFormatter::formatDateTimeForDB($value->tgl_rencanapemeriksaan);
              $value->tgl_rencanapemeriksaan = date('Y-m-d', strtotime($value->tgl_rencanapemeriksaan));
              $value->tgl_rencanapemeriksaan = MyFormatter::formatDateTimeForUser($value->tgl_rencanapemeriksaan);
            }
          }
        }
        
        if (isset($_POST['PasienkirimkeunitlainT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
    
                $arr_permintaan = array();
                
                if (isset($_POST['PermintaankepenunjangT'])) {
                  foreach ($_POST['PermintaankepenunjangT'] as $permintaankepenunjang_id => $item) {
    
                    $tanggal = MyFormatter::formatDateTimeForDB($item['tgl_rencanapemeriksaan']);
    
                    if (empty($arr_permintaan[$tanggal])) {
                      $arr_permintaan[$tanggal] = array();
                    }
                    $arr_permintaan[$tanggal]['dataPermintaan'][] = $permintaankepenunjang_id;
                    $arr_permintaan[$tanggal]['is_cito'] = $item['is_cito'] == '1' ? true : false;
                  }
                  
                  // echo '<pre>';var_dump($arr_permintaan);die;
                  $cnt = 0;
                  foreach ($arr_permintaan as $tgl_rencanapemeriksaan => $item) {
                    if ($cnt == 0) {
                      $modKirim = $modKirimKeUnitLain;
                    } else {
                      $modKirim = clone $modKirimKeUnitLain;
                      $modKirim->isNewRecord = true;
                      $modKirim->pasienkirimkeunitlain_id = null;
                    }
    
                    $modKirim->attributes = $_POST['PasienkirimkeunitlainT'];
                    $modKirim->is_elektif = isset($_POST['PasienkirimkeunitlainT']['is_elektif']) ? $_POST['PasienkirimkeunitlainT']['is_elektif'] : null;
                    $modKirim->tglrencanapemeriksaan = $tgl_rencanapemeriksaan;
                    $modKirim->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($_POST['PasienkirimkeunitlainT']['tgl_kirimpasien']);
                    $modKirim->is_cito = $item['is_cito'];
    
                    $modKirim->update_time = date('Y-m-d H:i:s');
                    $modKirim->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
    
                    if ($modKirim->isNewRecord) {
                      $modKirim->create_time = $modKirim->update_time;
                      $modKirim->create_loginpemakai_id = $modKirim->update_loginpemakai_id;
                    }
    
                    if ($modKirim->validate()) {
                      $ok = $ok && $modKirim->save();
                    } else {
                      $ok = false;
                    }
    
    
                    foreach ($item['dataPermintaan'] as $permintaankepenunjang_id) {
                      $permintaan = PermintaankepenunjangT::model()->findByPk($permintaankepenunjang_id);
                      $permintaan->pasienkirimkeunitlain_id = $modKirim->pasienkirimkeunitlain_id;
                      $permintaan->tgl_rencanapemeriksaan = $modKirim->tglrencanapemeriksaan;
                      $ok = $ok && $permintaan->save(false, array('pasienkirimkeunitlain_id', 'tgl_rencanapemeriksaan'));
                      // var_dump($permintaan->attributes);
                    }
    
                    // var_dump($modKirim->attributes);
                    
    
                    $cnt++;
                  }
    
    
                }
    
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
                    $this->redirect(array('pilihTglPeriksa', 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'pasien_id' => $pasien_id, 'frame' => 1, 'popup' => 'true', 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan!");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
    
        $this->render('_pilihTglPeriksa', array(
            'modKirimKeUnitLain' => $modKirimKeUnitLain,
            'modPermintaan' => $modPermintaan,
            'format' => $format,
        ));
    }

}
