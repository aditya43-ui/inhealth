<?php


class KemajuanPersalinanController extends MyAuthController {
    
    public $layout='//layouts/iframe';
    public $path_view = "persalinan.views.kemajuanPersalinan.";
    
    public function actionIndex($pendaftaran_id, $serviks_id = null, $kontraksi_id = null) {
        
        $partograf = PartografpasienT::model()->findByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
        ));
        
        if (empty($partograf)) {
            echo "Lakukan input Data Awal sebelum melakukan input di form ini.";
            Yii::app()->end();
        }
        
        $jalanlahir = null;
        $kontraksi = null;
        if (!empty($serviks_id)) {
            $jalanlahir = MonitoringjalanlahirT::model()->findByPk($serviks_id);
        }
        if (!empty($kontraksi_id)) {
            $kontraksi = MonitoringkontraksiT::model()->findByPk($kontraksi_id);
        }
        
        if (empty($jalanlahir)) {
            $jalanlahir = new MonitoringjalanlahirT();
            $jalanlahir->partografpasien_id = $partograf->partografpasien_id;
            $jalanlahir->pemeriksaanke = MonitoringjalanlahirT::generatePemeriksaanKe($partograf->partografpasien_id);
            $jalanlahir->tgl_pemeriksaan = date('Y-m-d');
            $jalanlahir->jam_pemeriksaan = date('H:i:s');
        }
        $jalanlahir->tgl_pemeriksaan = MyFormatter::formatDateTimeForUser($jalanlahir->tgl_pemeriksaan);
        
        if (empty($kontraksi)) {
            $kontraksi = new MonitoringkontraksiT();
            $kontraksi->partografpasien_id = $partograf->partografpasien_id;
            $kontraksi->pemeriksaanke = MonitoringkontraksiT::generatePemeriksaanKe($partograf->partografpasien_id);
            $kontraksi->tgl_pemeriksaan = date('Y-m-d');
            $kontraksi->jam_pemeriksaan = date('H:i:s');
        }
        $kontraksi->tgl_pemeriksaan = MyFormatter::formatDateTimeForUser($kontraksi->tgl_pemeriksaan);
        
        
        
        if (isset($_POST['MonitoringjalanlahirT']) || isset($_POST['MonitoringkontraksiT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            
            try {
                if (isset($_POST['MonitoringjalanlahirT'])) {
                    $jalanlahir->attributes = $_POST['MonitoringjalanlahirT'];
                    $jalanlahir->tgl_pemeriksaan = MyFormatter::formatDateTimeForDB($jalanlahir->tgl_pemeriksaan);

                    if ($jalanlahir->isNewRecord) {
                        $jalanlahir->create_time = date('Y-m-d H:i:s');
                        $jalanlahir->create_loginpemakai_id = Yii::app()->user->id;
                    }

                    $jalanlahir->update_time = date('Y-m-d H:i:s');
                    $jalanlahir->update_loginpemakai_id = Yii::app()->user->id;

                    if ($jalanlahir->validate()) {
                        $ok = $ok && $jalanlahir->save();
                    } else {
                        $ok = false;
                    }

                }
                
                if (isset($_POST['MonitoringkontraksiT'])) {
                    $kontraksi->attributes = $_POST['MonitoringkontraksiT'];
                    $kontraksi->tgl_pemeriksaan = MyFormatter::formatDateTimeForDB($kontraksi->tgl_pemeriksaan);

                    if ($kontraksi->isNewRecord) {
                        $kontraksi->create_time = date('Y-m-d H:i:s');
                        $kontraksi->create_loginpemakai_id = Yii::app()->user->id;
                    }

                    $kontraksi->update_time = date('Y-m-d H:i:s');
                    $kontraksi->update_loginpemakai_id = Yii::app()->user->id;

                    if ($kontraksi->validate()) {
                        $ok = $ok && $kontraksi->save();
                    } else {
                        $ok = false;
                    }

                }
                
                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('index', 'pendaftaran_id'=>$pendaftaran_id));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
                }
                
            } catch(Exception $exc){
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }  
        }
        
        
        $this->render($this->path_view.'index', array(
            'partograf'=>$partograf,
            'jalanlahir'=>$jalanlahir,
            'kontraksi'=>$kontraksi,
        ));
        
    }
    
    public static function generatePemeriksaanKe($partografpasien_id) {
        $model = self::model()->findByAttributes(array(
            'partografpasien_id'=>$partografpasien_id,
        ), array(
            'order'=>'pemeriksaanke desc',
        ));
        
        return empty($model) ? 1 : ($model->pemeriksaanke + 1);
    }
    
    public function actionDeleteServiks() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        
        $ok = 1;
        $id = $_POST['id'];
        $msg = "Data berhasil dihapus";
        $trans = Yii::app()->db->beginTransaction();
        
        try {
            $data = MonitoringjalanlahirT::model()->findByPk($id);
            MonitoringjalanlahirT::model()->deleteByPk($id);
            MonitoringjalanlahirT::resetUrutanPeriksa($data->partografpasien_id);
            
            $trans->commit();
        } catch (Exception $ex) {
            $trans->rollback();
            $ok = 0;
            $msg = "Data gagal dihapus. ".$ex->getMessage();

        }
        
        echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
        
    }
    
    public function actionDeleteKontraksi() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        
        $ok = 1;
        $id = $_POST['id'];
        $msg = "Data berhasil dihapus";
        $trans = Yii::app()->db->beginTransaction();
        
        try {
            $data = MonitoringkontraksiT::model()->findByPk($id);
            MonitoringkontraksiT::model()->deleteByPk($id);
            MonitoringkontraksiT::resetUrutanPeriksa($data->partografpasien_id);
            
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
        
        $jalanlahir = new MonitoringjalanlahirT;
        $jalanlahir->unsetAttributes();
        $jalanlahir->partografpasien_id = $partograf->partografpasien_id;
        
        
        $kontraksi = new MonitoringkontraksiT;
        $kontraksi->unsetAttributes();
        $kontraksi->partografpasien_id = $partograf->partografpasien_id;
        
        $this->render($this->path_view.'detail', array(
            'partograf'=>$partograf,
            'jalanlahir'=>$jalanlahir,
            'kontraksi'=>$kontraksi,
        ));
    }
    
}
