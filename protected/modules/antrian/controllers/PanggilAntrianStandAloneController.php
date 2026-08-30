<?php

/**
 * Class untuk pemanggilan antrian Stand Alone, tidak berhubungan dengan transaksi lainnya.
 * Untuk proses panggil saja proses sama seperti pendaftaran namun tidak update pendaftaran_id.
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.antrian
 * @subpackage controllers
 * @category controller
 */
class PanggilAntrianStandAloneController extends Controller {
    
    public $layout='//layouts/antrianHasilPenunjang';
    
    /**
     * Panggil antrian hasil penunjang GDC
     */
    public function actionAntrianHasilPenunjangGDC(){
        $format = new MyFormatter();
        $modAntrian = new ANAntrianT;
        $modAntrian->lokasi_karcisantrian = 14; //default lokasi antrian pengambilan hasil penunjang
        
        $this->render('hasilPenunjang/index',array(
            'format'=>$format,
            'modAntrian'=>$modAntrian,
        ));
    }
    
    /**
     * Panggil antrian hasil penunjang GDC
     */
    public function actionCustom(){
        $format = new MyFormatter();
        $modAntrian = new ANAntrianT;  
        $modAntrian->lokasi_karcisantrian = 14;
        $konfig = KonfigsystemK::model()->find();
        
        $this->render('custom/index',array(
            'format'=>$format,
            'modAntrian'=>$modAntrian,
            'konfig'=>$konfig
        ));
    }
    
    /**
     * Set model antrian berdasarkan model antrian
     */
    public function actionSetModelAntrian() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $lokasi = $_POST['lokasi'];

            $dataList = array();

            $modelantrian_id = array();
            $modelAntrian = ModelantrianM::model()->findAll('lokasi_karcisantrian_id = ' . $lokasi . ' AND modelantrian_aktif = TRUE ORDER BY modelantrian_nama ASC');
            $modelAntrian = CHtml::listData($modelAntrian, 'modelantrian_id', 'modelantrian_nama');
            $dropdown = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
            foreach ($modelAntrian as $value => $name) {
                $dropdown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                $modelantrian_id[] = $value;
            }

            $dataList['listModelAntrian'] = $dropdown;

            $criteria=new CDbCriteria;
            $criteria->addInCondition('modelantrian_id', $modelantrian_id);
            $criteria->addCondition('loket_aktif IS TRUE');
            $criteria->order = "loket_nama ASC";
            $modelLoket = LoketM::model()->findAll($criteria);
            $modelLoket = CHtml::listData($modelLoket, 'loket_id', 'loket_nama');
            $dropdown1 = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
            foreach ($modelLoket as $value => $name) {
                $dropdown1 .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }

            $dataList['listLoketAntrian'] = $dropdown1;

            echo json_encode($dataList);
            Yii::app()->end();
        }
    }
    
    /**
     * menampilkan form antrian dari request ajax
     * @throws CHttpException
     */
    public function actionSetFormAntrian() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $data = array();
            $data['pesan'] = "";
            $record = (isset($_POST['record']) ? $_POST['record'] : "");
            $noantrian = (isset($_POST['noantrian']) ? $_POST['noantrian'] : "");
            $loket_id = (isset($_POST['loket_id']) ? $_POST['loket_id'] : null);
            $modelantrian_id = (isset($_POST['modelantrian_id']) ? $_POST['modelantrian_id'] : null);

            if (!empty($modelantrian_id)) {
                $criteria1 = new CDbCriteria();
                $criteria1->compare('DATE(tglantrian)', date("Y-m-d"));
                $criteria1->addCondition("pendaftaran_id IS NULL");
                $criteria1->addCondition("modelantrian_id = " . $modelantrian_id);
                $criteria1->addCondition('update_loginpemakai_id IS NULL');
                $criteria1->addCondition('jml_panggil IS NULL');
                $criteria1->addCondition("isdatang IS NULL OR isdatang IS TRUE");
                $antrianModel = AntrianT::model()->findAll($criteria1);
            }
            if (!empty($modelantrian_id)) {
                $criteria1 = new CDbCriteria();
                $criteria1->compare('DATE(tglantrian)', date("Y-m-d"));
                $criteria1->addCondition("pendaftaran_id IS NULL");
                $criteria1->addCondition("modelantrian_id = " . $modelantrian_id);
                $jumlahAntrian = AntrianT::model()->findAll($criteria1);
            }
            if (!empty($modelantrian_id)) {
                $criteria1 = new CDbCriteria();
                $criteria1->compare('DATE(tglantrian)', date("Y-m-d"));
                $criteria1->addCondition("pendaftaran_id IS NULL");
                $criteria1->addCondition("isdatang IS FALSE");
                $criteria1->addCondition("modelantrian_id = " . $modelantrian_id);
                $jumlahTidakDatang = AntrianT::model()->findAll($criteria1);
            }

            if ($record == 'ulangi') { //ketika ubah lokasi antrian maka lakukan reset semua
                $modAntrian = new ANAntrianT;
            } else {

                if (empty($noantrian)) { //antrian baru
                    $criteria = new CDbCriteria();
                    $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
                    $criteria->addCondition("pendaftaran_id IS NULL");

                    if (!empty($modelantrian_id)) {
                        $criteria->addCondition("modelantrian_id = " . $modelantrian_id);
                    }
                    $criteria->addCondition('loket_id IS NULL OR loket_id = ' . $loket_id);
//                    $criteria->addCondition('update_loginpemakai_id IS NULL OR update_loginpemakai_id = ' . Yii::app()->user->id);
                    $criteria->addCondition('update_loginpemakai_id IS NULL');
                    $criteria->addCondition("isdatang IS NULL OR isdatang IS TRUE");
                    
                    $criteria->order = "antrian_id ASC";
                    if ($record == 'reset' && isset($antrianModel) && count($antrianModel) <= 0) {
                        $criteria->order = "antrian_id DESC";
                    } else if ($record == 'reset' && isset($antrianModel) && count($antrianModel) > 0) {
                        $criteria->addCondition('jml_panggil IS NULL');
                    } else if ($record == 'reset' && isset($antrianModel)) {
                        $criteria->addCondition('jml_panggil < 3 OR jml_panggil IS NULL');
                    } else {
                        $criteria->order = "antrian_id ASC";
                    }
                    $criteria->limit = 1;
                    $modAntrian = ANAntrianT::model()->find($criteria);
                    if (!empty($cari)) {

                        if ($record == 'next') {
                            $cari->loket_id = $loket_id;
                            $modAntrian = $cari->AntrianBerikut;
                            if($cari->panggil_flaq == false){
                                $data['pesan'] = "No Antrian <b>".$cari->noantrian."</b> belum dipanggil";
                            }else if($cari->panggil_flaq == null){
                                $data['pesan'] = "No Antrian <b>".$cari->noantrian."</b> belum dipanggil";
                            }
                        } else if ($record == 'prev') {
                            $cari->loket_id = $loket_id;
                            $modAntrian = $cari->AntrianSebelum;
                        } else {
                            $modAntrian = $cari;
                        }
                    }
                } else {
                    $criteria = new CDbCriteria();
                    $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
                    $criteria->compare("noantrian", trim($noantrian));
                    if ($record != 'next') {
                        $criteria->addCondition('(jml_panggil < 3 OR jml_panggil IS NULL)');
                    }
                    if ($record == 'reset') {
                        $criteria->addCondition('(jml_panggil IS NULL)');
                    }
                    if (!empty($modelantrian_id)) {
                        $criteria->addCondition("modelantrian_id = " . $modelantrian_id);
                    }
                    $criteria->addCondition('(loket_id IS NULL OR loket_id = ' . $loket_id . ')');
//                    $criteria->addCondition('(update_loginpemakai_id IS NULL OR update_loginpemakai_id = ' . Yii::app()->user->id . ')');
                    $criteria->addCondition('update_loginpemakai_id IS NULL');
                    $criteria->addCondition("isdatang IS NULL OR isdatang IS TRUE");
                    $criteria->limit = 1;
                    $criteria->order = "antrian_id ASC";
                    $cari = ANAntrianT::model()->find($criteria);
                    if (!empty($cari)) {

                        if ($record == 'next') {
                            $cari->loket_id = $loket_id;
                            $modAntrian = $cari->AntrianBerikut;
                            if($cari->panggil_flaq == false){
                                $data['pesan'] = "No Antrian <b>".$cari->noantrian."</b> belum dipanggil";
                            }else if($cari->panggil_flaq == null){
                                $data['pesan'] = "No Antrian <b>".$cari->noantrian."</b> belum dipanggil";
                            }
                        } else if ($record == 'prev') {
                            $cari->loket_id = $loket_id;
                            $modAntrian = $cari->AntrianSebelum;
                        } else {
                            $modAntrian = $cari;
                        }
                    }
                }
            }

            if (!isset($modAntrian)) {
                $modAntrian = new ANAntrianT;
                $data['pesan'] = "Antrian Habis !";
            }

            $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
            $data['noantrian'] = (isset($modAntrian->noantrian) && !empty($modAntrian->noantrian)) ? $modAntrian->noantrian : 'XX';
            $data['modelantrian_singkatan'] = (isset($modAntrian->noantrian) && !empty($modAntrian->noantrian)) ? (empty($modAntrian->modelantrian_id) ? "XX" : $modAntrian->modelAntrian->modelantrian_singkatan) : 'XX';
            $data['jml_panggil'] = (isset($modAntrian->jml_panggil) && !empty($modAntrian->jml_panggil)) ? $modAntrian->jml_panggil : null;
            $data['sisaAntrian'] = isset($antrianModel) ? count($antrianModel) : 0;
            $data['jumlah_antrian'] = isset($jumlahAntrian) ? count($jumlahAntrian) : 0;
            $data['jumlah_antrian_tidak_datang'] = isset($jumlahTidakDatang) ? count($jumlahTidakDatang) : 0;
            $data['antrian_id'] = (isset($modAntrian->antrian_id) && !empty($modAntrian->antrian_id)) ? $modAntrian->antrian_id : null;
            $data['update_loginpemakai_id'] = (isset($modAntrian->update_loginpemakai_id) && !empty($modAntrian->update_loginpemakai_id)) ? $modAntrian->update_loginpemakai_id : null;

            echo CJSON::encode($data);
            Yii::app()->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    
    /**
     * action ketika tombol panggil di klik
     * @throws CHttpException
     */
    public function actionPanggil() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $data = array();
            $data['pesan'] = "";
            
            $antrian_id = $_POST['antrian_id'];
            $ket = $_POST['ket'];
            $loket_id = $_POST['loket_id'];
            $lokasi_karcisantrian = isset($_POST['lokasi_karcisantrian'])?$_POST['lokasi_karcisantrian']:null;
            
            $modAntrian = AntrianT::model()->findByPk($antrian_id);
            $lokasi = LokasiKarcisantrianM::model()->findByPk($lokasi_karcisantrian);

            if (isset($modAntrian)) {
                if ($modAntrian->panggil_flaq == true) {
                    if ($ket == "batal") {
                        $modAntrian->panggil_flaq = false;
                        if ($modAntrian->update()) {
                            
                        }
                    }

                    /* Start-RSST-960 */
                    if (!empty($loket_id)) {
                        $modAntrian->loket_id = $loket_id;
                    }
                    $modAntrian->jampanggil = date('Y-m-d H:i:s');
                    $tglantrians = $modAntrian->tglantrian;
                    $now = date('Y-m-d H:i:s');
                    $to_time = strtotime($now);
                    $from_time = strtotime($tglantrians);
                    $difHour = round(abs($to_time - $from_time) / 60); //ambil konversi ke menit
                    $modAntrian->lamamenunggu_mnt = $difHour;
                    $jmlpanggil = $modAntrian->jml_panggil;
                    $modAntrian->jml_panggil = $jmlpanggil + 1;
//                    $modAntrian->update_loginpemakai_id = Yii::app()->user->id;
                    /* END */
                    $modAntrian->update();
                } else {

                    /* Start-RSST-960 */
                    if (!empty($loket_id)) {
                        $modAntrian->loket_id = $loket_id;
                    }
                    $modAntrian->jampanggil = date('Y-m-d H:i:s');
                    $tglantrians = $modAntrian->tglantrian;
                    $now = date('Y-m-d H:i:s');
                    $to_time = strtotime($now);
                    $from_time = strtotime($tglantrians);
                    $difHour = round(abs($to_time - $from_time) / 60); //ambil konversi ke menit
                    $modAntrian->lamamenunggu_mnt = $difHour;
                    $modAntrian->jml_panggil = 1;
//                    $modAntrian->update_loginpemakai_id = Yii::app()->user->id;
                    /* END */

                    $modAntrian->panggil_flaq = true;
                    if ($modAntrian->update()) {
                        
                    }
                }
            }

            if (!empty($modAntrian->modelantrian_id)) {
                $criteria1 = new CDbCriteria();
                $criteria1->compare('DATE(tglantrian)', date("Y-m-d"));
                $criteria1->addCondition("pendaftaran_id IS NULL");
                $criteria1->addCondition("modelantrian_id = " . $modAntrian->modelantrian_id);
                $criteria1->addCondition('update_loginpemakai_id IS NULL');
                $criteria1->addCondition('jml_panggil IS NULL');
                $antrianModel = AntrianT::model()->findAll($criteria1);
            }
            if (!empty($modAntrian->modelantrian_id)) {
                $criteria1 = new CDbCriteria();
                $criteria1->compare('DATE(tglantrian)', date("Y-m-d"));
                $criteria1->addCondition("pendaftaran_id IS NULL");
                $criteria1->addCondition("modelantrian_id = " . $modAntrian->modelantrian_id);
                $jumlahAntrian = AntrianT::model()->findAll($criteria1);
            }
            if (!empty($modAntrian->modelantrian_id)) {
                $criteria1 = new CDbCriteria();
                $criteria1->compare('DATE(tglantrian)', date("Y-m-d"));
                $criteria1->addCondition("pendaftaran_id IS NULL");
                $criteria1->addCondition("isdatang IS FALSE");
                $criteria1->addCondition("modelantrian_id = " . $modAntrian->modelantrian_id);
                $jumlahTidakDatang = AntrianT::model()->findAll($criteria1);
            }
            
            $data['noantrian'] = (isset($modAntrian->noantrian) && !empty($modAntrian->noantrian)) ? $modAntrian->noantrian : 'XX';
            $data['modelantrian_singkatan'] = (isset($modAntrian->noantrian) && !empty($modAntrian->noantrian)) ? (empty($modAntrian->modelantrian_id) ? "XX" : $modAntrian->modelAntrian->modelantrian_singkatan) : 'XX';
            $data['jml_panggil'] = (isset($modAntrian->jml_panggil) && !empty($modAntrian->jml_panggil)) ? $modAntrian->jml_panggil : null;
            $data['sisaAntrian'] = isset($antrianModel) ? count($antrianModel) : 0;
            $data['jumlah_antrian'] = isset($jumlahAntrian) ? count($jumlahAntrian) : 0;
            $data['jumlah_antrian_tidak_datang'] = isset($jumlahTidakDatang) ? count($jumlahTidakDatang) : 0;
            $data['antrian_id'] = (isset($modAntrian->antrian_id) && !empty($modAntrian->antrian_id)) ? $modAntrian->antrian_id : null;
            $data['update_loginpemakai_id'] = (isset($modAntrian->update_loginpemakai_id) && !empty($modAntrian->update_loginpemakai_id)) ? $modAntrian->update_loginpemakai_id : null;
            $data['loket_id'] = (isset($modAntrian->loket_id) && !empty($modAntrian->loket_id)) ? $modAntrian->loket_id : null;
            $data['set_antrian'] = !empty($lokasi->set_antrian)?$lokasi->set_antrian:'antrian';

            echo CJSON::encode($data);
            Yii::app()->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    
    /**
     * digunakan jika pasien tidak datang pada saat antrian
     * POST['antrian_id']
     */
    public function actionBatalPanggil() {
        if (Yii::app()->request->isAjaxRequest) {
            $antrian_id = isset($_POST['antrian_id']) ? $_POST['antrian_id'] : null;

            $modAntrian = AntrianT::model()->findByPk($antrian_id);
            if (!empty($modAntrian)) {

                $modAntrian->isdatang = false;
                $modAntrian->update();
                if ($modAntrian) {
                    $data['status'] = true;
                    $data['pesan'] = 'Antrian Pasien Berhasil di Ubah';
                }
            } else {
                $data['status'] = false;
                $data['pesan'] = 'Gagal!';
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Set lokasi antrian berdasarkan model antrian
     */
    public function actionSetLoketAntrian() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $modelantrian_id = $_POST['modelantrian_id'];

            $dataList = array();

            $criteria = new CDbCriteria();
            $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
            $criteria->addCondition("pendaftaran_id IS NULL");
            $criteria->addCondition("modelantrian_id = " . $modelantrian_id);
            $criteria->addCondition('update_loginpemakai_id IS NULL');
            $criteria->addCondition('jml_panggil IS NULL');
            $modAntrian = AntrianT::model()->findAll($criteria);

            $modelLoket = LoketM::model()->findAll('modelantrian_id = ' . $modelantrian_id . ' AND loket_aktif = TRUE ORDER BY loket_nama ASC');
            $modelLoket = CHtml::listData($modelLoket, 'loket_id', 'loket_nama');
            $dropdown = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
            foreach ($modelLoket as $value => $name) {
                $dropdown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }

            $dataList['listLoketAntrian'] = $dropdown;
            $dataList['sisaAntrian'] = count($modAntrian);

            echo json_encode($dataList);
            Yii::app()->end();
        }
    }
    
    /**
     * menghitung ulang Jumlah Antrian Belum di Panggil, Jumlah Antrian Tidak Datang dan Jumlah Antrian
     * @throws CHttpException
     */
    public function actionSetHitunganNomorAntrian() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $data = array();
            $data['pesan'] = "";
            $modelantrian_id = (isset($_POST['modelantrian_id']) ? $_POST['modelantrian_id'] : null);

            if (!empty($modelantrian_id)) {
                $criteria1 = new CDbCriteria();
                $criteria1->compare('DATE(tglantrian)', date("Y-m-d"));
                $criteria1->addCondition("pendaftaran_id IS NULL");
                $criteria1->addCondition("modelantrian_id = " . $modelantrian_id);
                $criteria1->addCondition('update_loginpemakai_id IS NULL');
                $criteria1->addCondition('jml_panggil IS NULL');
                $criteria1->addCondition("isdatang IS NULL OR isdatang IS TRUE");
                $antrianModel = AntrianT::model()->findAll($criteria1);
            }
            if (!empty($modelantrian_id)) {
                $criteria1 = new CDbCriteria();
                $criteria1->compare('DATE(tglantrian)', date("Y-m-d"));
                $criteria1->addCondition("pendaftaran_id IS NULL");
                $criteria1->addCondition("modelantrian_id = " . $modelantrian_id);
                $jumlahAntrian = AntrianT::model()->findAll($criteria1);
            }
            if (!empty($modelantrian_id)) {
                $criteria1 = new CDbCriteria();
                $criteria1->compare('DATE(tglantrian)', date("Y-m-d"));
                $criteria1->addCondition("pendaftaran_id IS NULL");
                $criteria1->addCondition("isdatang IS FALSE");
                $criteria1->addCondition("modelantrian_id = " . $modelantrian_id);
                $jumlahTidakDatang = AntrianT::model()->findAll($criteria1);
            }

            $data['sisaAntrian'] = isset($antrianModel) ? count($antrianModel) : 0;
            $data['jumlah_antrian'] = isset($jumlahAntrian) ? count($jumlahAntrian) : 0;
            $data['jumlah_antrian_tidak_datang'] = isset($jumlahTidakDatang) ? count($jumlahTidakDatang) : 0;
            
            echo CJSON::encode($data);
            Yii::app()->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    
}