<?php

/**
 * Digunakan untuk mengakses transaksi Penggunaan Coolbox
 * @author     Andyka Putra <andykaputra@.com>
 * @package    application.modules.bankDarah
 * @subpackage controllers
 * @category   controller
 */
class PenggunaanCoolboxController extends MyAuthController {

    public $defaultAction = 'index';
    public $path_view = 'bankDarah.views.penggunaanCoolbox.';
    public $init = '';

    /**
     * Menampilkan form input transaksi penggunaan coolbox
     */
    public function actionIndex($id = null) {
        $format = new MyFormatter();
        $model = new PenggunaanCoolboxT;
        $model->no_penggunaan_coolbox = '- Otomatis -';
        $model->tgl_penggunaan_coolbox = date('Y-m-d');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        
        if (!empty($id)) {
            $model = PenggunaanCoolboxT::model()->findByPk($id);
            
            if(!empty($model->jam_kosongtanpalistrik)){
                $model->jam_monitoring = $model->jam_kosongtanpalistrik;
            }else if(!empty($model->jam_kosongdenganlistrik)){
                $model->jam_monitoring = $model->jam_kosongdenganlistrik;
            }else if(!empty($model->jam_listrikdanicepack)){
                $model->jam_monitoring = $model->jam_listrikdanicepack;
            }
        }
        if (isset($_POST['PenggunaanCoolboxT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $model->attributes = $_POST['PenggunaanCoolboxT'];
            $model->no_penggunaan_coolbox = MyGenerator::noPenggunaanCoolbox();
            $model->tgl_penggunaan_coolbox = $format->formatDateTimeForDb($_POST['PenggunaanCoolboxT']['tgl_penggunaan_coolbox']);
            $model->coolboxdarah_id = $_POST['PenggunaanCoolboxT']['coolboxdarah_id'];
            $model->ruangan_id = $_POST['PenggunaanCoolboxT']['ruangan_id'];
            $model->jumlah_icepack = $_POST['PenggunaanCoolboxT']['jumlah_icepack'];
            if (!empty($_POST['PenggunaanCoolboxT']['suhu_kosongtanpalistrik'])) {
                $model->jam_kosongtanpalistrik = $_POST['PenggunaanCoolboxT']['jam_monitoring'];
                $model->suhu_kosongtanpalistrik = $_POST['PenggunaanCoolboxT']['suhu_kosongtanpalistrik'];
            }
            if (!empty($_POST['PenggunaanCoolboxT']['suhu_kosongdenganlistrik'])) {
                $model->jam_kosongdenganlistrik = $_POST['PenggunaanCoolboxT']['jam_monitoring'];
                $model->suhu_kosongdenganlistrik = $_POST['PenggunaanCoolboxT']['suhu_kosongdenganlistrik'];
            }
            if (!empty($_POST['PenggunaanCoolboxT']['suhu_listrikdanicepack'])) {
                $model->jam_listrikdanicepack = $_POST['PenggunaanCoolboxT']['jam_monitoring'];
                $model->suhu_listrikdanicepack = $_POST['PenggunaanCoolboxT']['suhu_listrikdanicepack'];
            }
            $model->keterangan = $_POST['PenggunaanCoolboxT']['keterangan'];
            $model->pegawai_id = $_POST['PenggunaanCoolboxT']['pegawai_id'];
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = Yii::app()->user->id;
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $model->save();
            if ($model->save()) {
                $modMonitoring = new MonitoringkantongT;
                $modMonitoring->penggunaan_coolbox_id = $model->penggunaan_coolbox_id;
                $modMonitoring->coolboxdarah_id = $model->coolboxdarah_id;
                $modMonitoring->tglmonitoring = $model->tgl_penggunaan_coolbox;
                $modMonitoring->jammonitoring = date('H:i:s');
                $modMonitoring->monitoring_ke = 1;
                $modMonitoring->suhu_monitoring = 0;
                if (!empty($model->suhu_kosongtanpalistrik)) {
                    $modMonitoring->kosongtanpalistrik = $model->jam_kosongtanpalistrik;
                    $modMonitoring->kosongtanpalistrik_suhu = $model->suhu_kosongtanpalistrik;
                }
                if (!empty($model->suhu_kosongdenganlistrik)) {
                    $modMonitoring->kosongdenganlistrik = $model->jam_kosongdenganlistrik;
                    $modMonitoring->kosongdenganlistrik_suhu = $model->suhu_kosongdenganlistrik;
                } 
                if (!empty($model->suhu_listrikdanicepack)) {
                    $modMonitoring->listrikdanicepack = $model->jam_listrikdanicepack;
                    $modMonitoring->listrikdanicepack_suhu = $model->suhu_listrikdanicepack;
                }
                $modMonitoring->create_time = date('Y-m-d H:i:s');
                $modMonitoring->create_loginpemakai_id = Yii::app()->user->id;
                $modMonitoring->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modMonitoring->petugasmonitoring_id = Yii::app()->user->getState('pegawai_id');
                $modMonitoring->save();

                $transaction->commit();
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('index', 'id' => $model->penggunaan_coolbox_id, 'sukses' => '1'));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                $this->redirect(array('index'));
            }
        }
        $this->render($this->path_view . 'index', array(
            'model' => $model,
        ));
    }

    /**
     * Digunakan untuk mengecek dan mendapatkan data dari coolboxdarah_m
     */
    public function actionCekData() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            $model = CoolboxdarahM::model()->findByPk($_POST['coolboxdarah_id']);
            if (!empty($model)) {
                $returnVal['coolbox_ukuran'] = $model->coolbox_ukuran;
                $returnVal['jenis_kantong'] = $model->jenis_kantong;
                $returnVal['standart_suhu'] = $model->standart_suhu;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Digunakan untuk mengecek apakah di hari yang dipilih tersebut memiliki coolboxdarah_id yang sama
     */
    public function actionCekForm() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            $model = PenggunaanCoolboxT::model()->findByAttributes(array('coolboxdarah_id' => $_POST['coolboxdarah_id'], 'tgl_penggunaan_coolbox' => $_POST['tgl_penggunaan_coolbox']));
            if (!empty($model)) {
                $returnVal['status'] = true;
            } else {
                $returnVal['status'] = false;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}
