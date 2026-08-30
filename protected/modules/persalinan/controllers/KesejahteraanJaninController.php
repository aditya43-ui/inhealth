<?php


class KesejahteraanJaninController extends MyAuthController {
    
    public $path_view = "persalinan.views.kesejahteraanJanin.";
    public $layout = "//layouts/iframe";
    
    public function actionIndex($pendaftaran_id, $denyutjantungjanin_id = null, $ketubandanpenyusupan_id = null) {
        
        
        $partograf = PartografpasienT::model()->findByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
        ));
        
        if (empty($partograf)) {
            echo "Lakukan input Data Awal sebelum melakukan input di form ini.";
            Yii::app()->end();
        }
        $jantung = null;
        if (!empty($denyutjantungjanin_id)) {
            $jantung = DenyutjantungjaninT::model()->findByPk($denyutjantungjanin_id);
        }
        if (empty($jantung)) {
            $jantung = new DenyutjantungjaninT();
            $jantung->partografpasien_id = $partograf->partografpasien_id;
            $jantung->tgl_pemeriksaan = date('Y-m-d');
            $jantung->jam_pemeriksaan = date('H:i:s');
            $jantung->pemeriksaanke = $jantung->getNoPemeriksaan();
        }

        
        $ketuban = null;
        if (!empty($ketubandanpenyusupan_id)) {
            $ketuban = KetubandanpenyusupanT::model()->findByPk($ketubandanpenyusupan_id);
        }
        if (empty($ketuban)) {
            $ketuban = new KetubandanpenyusupanT();
            $ketuban->partografpasien_id = $partograf->partografpasien_id;
            $ketuban->tgl_pemeriksaan = date('Y-m-d');
            $ketuban->jam_pemeriksaan = date('H:i:s');
            $ketuban->pemeriksaanke = $ketuban->getNoPemeriksaan();
        }
        
        
        $jantung->tgl_pemeriksaan = MyFormatter::formatDateTimeForUser($jantung->tgl_pemeriksaan);
        $ketuban->tgl_pemeriksaan = MyFormatter::formatDateTimeForUser($ketuban->tgl_pemeriksaan);
        
        
        if (isset($_POST['DenyutjantungjaninT']) || isset($_POST['KetubandanpenyusupanT'])) {
            $trans = Yii::app()->db->beginTransaction();
            
            $ok = true;
            
            try {
                if (isset($_POST['DenyutjantungjaninT'])) {
                    $jantung->attributes = $_POST['DenyutjantungjaninT'];
                    $jantung->tgl_pemeriksaan = MyFormatter::formatDateTimeForDB($jantung->tgl_pemeriksaan);

                    if ($jantung->isNewRecord) {
                        $jantung->create_time = date('Y-m-d H:i:s');
                        $jantung->create_loginpemakai_id = Yii::app()->user->id;
                    }

                    $jantung->update_time = date('Y-m-d H:i:s');
                    $jantung->update_loginpemakai_id = Yii::app()->user->id;

                    if ($jantung->validate()) {
                        $ok = $ok && $jantung->save();
                    } else {
                        $ok = false;
                    }

//                    var_dump($jantung->attributes);
                }

                if (isset($_POST['KetubandanpenyusupanT'])) {
                    $ketuban->attributes = $_POST['KetubandanpenyusupanT'];
                    $ketuban->tgl_pemeriksaan = MyFormatter::formatDateTimeForDB($ketuban->tgl_pemeriksaan);

                    if ($ketuban->isNewRecord) {
                        $ketuban->create_time = date('Y-m-d H:i:s');
                        $ketuban->create_loginpemakai_id = Yii::app()->user->id;
                    }

                    $ketuban->update_time = date('Y-m-d H:i:s');
                    $ketuban->update_loginpemakai_id = Yii::app()->user->id;

                    if ($ketuban->validate()) {
                        $ok = $ok && $ketuban->save();
                    } else {
                        $ok = false;
                    }

//                    var_dump($ketuban->attributes);
                }
                
//                var_dump($ok);
//                die;

                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('index', 'pendaftaran_id'=>$pendaftaran_id));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
                }
                
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
            }
            
            
        }
        
        
        
        $this->render($this->path_view."index", array(
            'partograf'=>$partograf,
            'jantung'=>$jantung,
            'ketuban'=>$ketuban,
        ));
    }
    
    public function actionAutocompletePegawaiPemeriksa($term) {
        
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $petugas = new PegawairuanganV('search');
        $petugas->unsetAttributes();
        $petugas->nama_pegawai = $term;
        $petugas->ruangan_id = Yii::app()->user->getState('ruangan_id');
        
        
        $prov = $petugas->searchPegawaiRuangan();
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
    
    public function actionDeleteDenyut() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        
        $ok = 1;
        $id = $_POST['id'];
        $msg = "Data berhasil dihapus";
        $trans = Yii::app()->db->beginTransaction();
        
        try {
            $data = DenyutjantungjaninT::model()->findByPk($id);
            DenyutjantungjaninT::model()->deleteByPk($id);
            DenyutjantungjaninT::resetUrutanPeriksa($data->partografpasien_id);
            
            $trans->commit();
        } catch (Exception $ex) {
            $trans->rollback();
            $ok = 0;
            $msg = "Data gagal dihapus. ".$ex->getMessage();

        }
        
        echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
        
    }
    
    public function actionDeleteKetuban() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        
        $ok = 1;
        $id = $_POST['id'];
        $msg = "Data berhasil dihapus";
        $trans = Yii::app()->db->beginTransaction();
        
        try {
            $data = KetubandanpenyusupanT::model()->findByPk($id);
            KetubandanpenyusupanT::model()->deleteByPk($id);
            KetubandanpenyusupanT::resetUrutanPeriksa($data->partografpasien_id);
            
            $trans->commit();
        } catch (Exception $ex) {
            $trans->rollback();
            $ok = 0;
            $msg = "Data gagal dihapus. ".$ex->getMessage();

        }
        
        echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
        
    }
    
    public function actionDetail($id) {
        $partograf = PartografpasienT::model()->findByPk($id);
        
        if (empty($partograf)) {
            echo "Lakukan input Data Awal sebelum melihat detail ini.";
            Yii::app()->end();
        }
        
        $jantung = new DenyutjantungjaninT;
        $jantung->unsetAttributes();
        $jantung->partografpasien_id = $jantung->partografpasien_id;
        
        
        $ketuban = new KetubandanpenyusupanT();
        $ketuban->unsetAttributes();
        $ketuban->partografpasien_id = $partograf->partografpasien_id;
        
        $this->render($this->path_view.'detail', array(
            'partograf'=>$partograf,
            'jantung'=>$jantung,
            'ketubah'=>$ketuban,
        ));
    }
    
}
