<?php

/**
 * Class untuk proses transaksi monitoring suhu kantong darah, transaksi dari informasi penerimaan kantong darah
 * menambahkan kantong detail kantong darah
 * @author Tantowy <tantowijaya@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class MonitoringSuhuKantongDarahController extends MyAuthController {

    /**
     * @author Tantowy <tantowijaya@.com>
     * Fungsi default index transaksi
     * @param integer $kirimkantongdarah_id
     */
    public function actionIndex($kirimkantongdarah_id = null) {

        $format = new MyFormatter;
        $model = new BDMonitoringkantongT;
        $modelDetail = new MonitoringkantongT;
        $model->tglmonitoring = date('d-m-Y');
        if (!empty($kirimkantongdarah_id)) {
            $modKirimKantongDarah = BDInfokirimkantongdarahV::model()->findByAttributes(array('kirimkantongdarah_id' => $kirimkantongdarah_id), array('order' => 'monitoring_ke DESC'));
            $model->kirimkantongdarah_id = $modKirimKantongDarah->kirimkantongdarah_id;
            $model->coolboxdarah_id = $modKirimKantongDarah->coolboxdarah_id;
        } else {
            $modKirimKantongDarah = new BDInfokirimkantongdarahV;
        }

        $model->ruangan_id = Params::RUANGAN_TRANSFUSI_DARAH; //Ruang Tranfusi Darah

        if (isset($_POST['BDMonitoringkantongT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $sukses = 0;
                $model->attributes = $_POST['BDMonitoringkantongT'];
                $model->tglmonitoring = $format->formatDateTimeForDb($model->tglmonitoring);
                $monitoring_ke = empty($modKirimKantongDarah->monitoring_ke) ? 1 : ($modKirimKantongDarah->monitoring_ke + 1); //ambil dari view jika sudah ada maka tambah satu jika belum set 1
                foreach ($_POST['MonitoringkantongT'] as $key => $value) {
                    $modelDetail = new MonitoringkantongT;
                    $modelDetail->tglmonitoring = $model->tglmonitoring;
                    $modelDetail->coolboxdarah_id = $model->coolboxdarah_id;
                    $modelDetail->kirimkantongdarah_id = $model->kirimkantongdarah_id;
                    $modelDetail->jammonitoring = date('H:i:s');
                    $modelDetail->monitoring_ke = $monitoring_ke;
                    $modelDetail->attributes = $value;
                    $monitoring_ke++;
                    if ($modelDetail->save()) {
                        $sukses++;
                    }
                }

                if ($sukses > 0) {
                    $transaction->commit();
                    $this->redirect(array('index', 'kirimkantongdarah_id' => $kirimkantongdarah_id, 'sukses' => 1)); //jika sukses kirim get sukses dan PK
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan !" . MyExceptionMessage::getMessage($ex, true)); //alert handle error
            }
        }

        $this->render('index', array(
            'model' => $model,
            'modelDetail' => $modelDetail,
            'modKirimKantongDarah' => $modKirimKantongDarah,
        ));
    }

    /**
     * Fungsi untuk menampilkan Informasi Monitoring Suhu Coolbox
     * @author Andyka <andykaputra@.com>
     */
    public function actionInformasi() {

        $model = new BDPenggunaanCoolboxT();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        if (isset($_GET['BDPenggunaanCoolboxT'])) {
            $model->attributes = $_GET['BDPenggunaanCoolboxT'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDPenggunaanCoolboxT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDPenggunaanCoolboxT']['tgl_akhir']);
            $model->coolboxdarah_id = $_GET['BDPenggunaanCoolboxT']['coolboxdarah_id'];
            $model->no_penggunaan_coolbox = $_GET['BDPenggunaanCoolboxT']['no_penggunaan_coolbox'];
        }

        $this->render('informasi', array('model' => $model));
    }

    /**
     * Fungsi untuk menampilkan detail Informasi Monitoring Suhu Coolbox
     * @author Andyka <andykaputra@.com>
     * @param integer $id
     * @param string $tgl_penggunaan_coolbox
     */
    public function actionDetailmonitoring($id, $tgl_penggunaan_coolbox) {

        $format = new MyFormatter;
        $model = BDPenggunaanCoolboxT::model()->findByPk($id);
        $model->coolboxdarah_nama = $model->coolboxdarah->coolboxdarah_nama;
        $model->ruangan_nama = $model->ruangan->ruangan_nama;
        $model->tgl_penggunaan_coolbox = date('d M Y', strtotime($model->tgl_penggunaan_coolbox));
        $cekCoolbox = CoolboxdarahM::model()->findByPk($model->coolboxdarah_id);
        $model->ukuran_coolbox = $cekCoolbox->coolbox_ukuran;
        $model->jenis_kantong = $cekCoolbox->jenis_kantong;
        $model->standar_suhu = $cekCoolbox->standart_suhu;
        
        $sql = "SELECT CAST(MAX(monitoring_ke) AS integer)+1 nourut
                FROM monitoringkantong_t
                WHERE penggunaan_coolbox_id = ".$id."";
        $mod = Yii::app()->db->createCommand($sql)->queryRow();
        
        $modKantong = new MonitoringkantongT;        
        $modKantong->monitoring_ke = empty($mod) ? 1 : $mod['nourut'];         
        $modShow = BDMonitoringkantongT::model()->findAllByAttributes(array('penggunaan_coolbox_id' => $id), array('order' => 'jammonitoring ASC'));
        
        $model->ruangan_id = Params::RUANGAN_TRANSFUSI_DARAH; //Ruang Tranfusi Darah

        if (isset($_POST['MonitoringkantongT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $sukses = 0;
                $model->attributes = $_POST['BDMonitoringkantongT'];
                $model->tglmonitoring = $format->formatDateTimeForDb($model->tglmonitoring);
                foreach ($_POST['BDMonitoringkantongT'] as $key => $value) {
                    $modelDetail = new BDMonitoringkantongT;
                    $modelDetail->penggunaan_coolbox_id = $_POST['BDPenggunaanCoolboxT']['penggunaan_coolbox_id'];
                    $modelDetail->tglmonitoring = date('Y-m-d H:i:s');
                    $modelDetail->coolboxdarah_id = $_POST['BDPenggunaanCoolboxT']['coolboxdarah_id'];
                    $modelDetail->attributes = $value;
                    $modelDetail->create_time = date('Y-m-d H:i:s');
                    $modelDetail->create_loginpemakai_id = Yii::app()->user->id;
                    $modelDetail->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    if ($modelDetail->save()) {
                        $sukses++;
                    }
                }

                if ($sukses > 0) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('detailmonitoring', 'id' => $id, 'tgl_penggunaan_coolbox' => $tgl_penggunaan_coolbox)); //jika sukses kirim get sukses dan PK
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan !" . MyExceptionMessage::getMessage($ex, true)); //alert handle error
            }
        }

        $this->render('detailmonitoring', array(
            'model' => $model,
            'modShow' => $modShow,
            'modKantong' => $modKantong
        ));
    }

    /**
     * @author Tantowy <tantowijaya@.com>
     * 
     * fungsi untuk get / set suhu ke detail
     */
    public function actionSetSuhuMonitor() {
        if (Yii::app()->request->isAjaxRequest) {

            $model = new MonitoringkantongT;
            $model->attributes = $_POST['BDMonitoringkantongT'];

            $form = $this->renderPartial('_rowTabel', array('model' => $model), true);
            $returnVal['form'] = $form;
            $returnVal['model'] = $_POST['BDMonitoringkantongT'];

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * fungsi untuk get / set suhu ke detail pada halaman detail
     * @author Andyka Putra <andykaputra@.com>
     */
    public function actionSetSuhuMonitor2() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new MonitoringkantongT;
            $model->attributes = $_POST['MonitoringkantongT'];
            $model->jam_monitoring = $_POST['MonitoringkantongT']['jam_monitoring'];
            $model->jammonitoring = $_POST['MonitoringkantongT']['jam_monitoring'];
            $model->monitoring_ke = $_POST['MonitoringkantongT']['monitoring_ke'];
            if($_POST['MonitoringkantongT']['kosongtanpalistrik'] != 0){
                $model->kosongtanpalistrik = $_POST['MonitoringkantongT']['jam_monitoring'];
                $model->kosongtanpalistrik_suhu = $_POST['MonitoringkantongT']['kosongtanpalistrik'];
            }
            if($_POST['MonitoringkantongT']['kosongdenganlistrik'] != 0){
                $model->kosongdenganlistrik = $_POST['MonitoringkantongT']['jam_monitoring'];
                $model->kosongdenganlistrik_suhu = $_POST['MonitoringkantongT']['kosongdenganlistrik'];
            }
            if($_POST['MonitoringkantongT']['listrikdanicepack'] != 0){
                $model->listrikdanicepack = $_POST['MonitoringkantongT']['jam_monitoring'];
                $model->listrikdanicepack_suhu = $_POST['MonitoringkantongT']['listrikdanicepack'];
            }
            if($_POST['MonitoringkantongT']['mulaiisikantong'] != 0){
                $model->mulaiisikantong = $_POST['MonitoringkantongT']['jam_monitoring'];
                $model->mulaiisikantong_suhu = $_POST['MonitoringkantongT']['mulaiisikantong'];
            }
            if($_POST['MonitoringkantongT']['setelahdiisikantong'] != 0){
                $model->setelahdiisikantong = $_POST['MonitoringkantongT']['jam_monitoring'];
                $model->setelahdiisikantong_suhu = $_POST['MonitoringkantongT']['setelahdiisikantong'];
            }
            if($_POST['MonitoringkantongT']['lepaslistrik'] != 0){
                $model->lepaslistrik = $_POST['MonitoringkantongT']['jam_monitoring'];
                $model->lepaslistrik_suhu = $_POST['MonitoringkantongT']['lepaslistrik'];
            }    
            
            $form = $this->renderPartial('_rowTabel2', array('model' => $model), true);
            $returnVal['form'] = $form;
            $returnVal['model'] = $_POST['MonitoringkantongT'];

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    /**
     * fungsi untuk delete
     */
    public function actionBatalMonitoring() {
        if (Yii::app()->request->isAjaxRequest) {
            $monitoringkantong_id = isset($_POST['id']) ? $_POST['id'] : 0;
            $cariData = MonitoringkantongT::model()->findByPk($monitoringkantong_id);
            if (isset($cariData)) {
                if ($cariData->delete()) {
                    $data['status'] = 'berhasil';
                } else {
                    $data['status'] = 'gagal';
                    $data['pesan'] = 'Data Gagal di hapus !!';
                }
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
     /**
     * Menampilkan detail  kantong darah.
     * 
     * @param integer $penggunaan_coolbox_id
     */
    public function actionLihatDetail($penggunaan_coolbox_id="") {
        $this->layout = "//layouts/iframe";
        $modcoolbox="";
        $modruangan="";
        $format = new MyFormatter();
        $modmonitoring= BDMonitoringkantongT::model()->findByAttributes(array('penggunaan_coolbox_id'=>$penggunaan_coolbox_id));

  
        $modmonitoring->tglmonitoring= MyFormatter::formatDateTimeForUser($modmonitoring->tglmonitoring);
        if (!empty($penggunaan_coolbox_id)) {
            $model= BDPenggunaanCoolboxT::model()->findByPk($penggunaan_coolbox_id);
            if(!empty($model->coolboxdarah_id)){
                $modcoolbox= CoolboxdarahM::model()->findByPk($model->coolboxdarah_id);
            }
            if(!empty($model->ruangan_id)){
                $modruangan= RuanganM::model()->findByPk($model->ruangan_id);
            }
            
            $criteria = new CDbCriteria();
            $criteria->select="pdet.penggunaan_coolbox_id,k.nomorbarcode_utama,k.nomorbarcode_sample,k.gol_darah,k.rhesus,p.no_pendonor,p.no_identitas";
           
            $criteria->join =" join penggunaan_coolboxdet_t pdet on pdet.penggunaan_coolbox_id=t.penggunaan_coolbox_id  "
                            . " left join kantongdarah_t k on k.kantongdarah_id=pdet.kantongdarah_id "
                        . " left join  pendonor_m p on p.pendonor_id=k.pendonor_id ";
            $criteria->group=$criteria->select;
            $criteria->addCondition("t.penggunaan_coolbox_id=".$penggunaan_coolbox_id);
            $moddetail= BDPenggunaanCoolboxT::model()->findAll($criteria);
           
        }
        
        $this->render('detail', array('modruangan'=>$modruangan,'modmonitoring'=>$modmonitoring,'model' => $model, 'modcoolbox' => $modcoolbox, 'moddetail' => $moddetail));
    }
     /**
     * fungsi untuk delete detail coolbox
     */
    public function actionBatalCoolbox() {
        if (Yii::app()->request->isAjaxRequest) {
            $nomorbarcode_sample = isset($_POST['id']) ? $_POST['id'] : 0;
            $arrUp = array(
                    'penggunaan_coolbox_id' => null
            );
            $deleteData = PenggunaanCoolboxdetT::model()->updateAll($arrUp," nomorbarcod_sample = '".$nomorbarcode_sample."' ");
            
            if ($deleteData) {
                    $data['status'] = 'berhasil';
            }else {
                    $data['status'] = 'gagal';
                    $data['pesan'] = 'Data Gagal di hapus !!';
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

}
