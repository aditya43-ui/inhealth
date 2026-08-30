<?php

/**
 * Digunakan untuk mengakses transaksi masuk coolbox
 * @author Andyka Putra <andykaputra@.com>
 * @packag application.modules.bankDarah
 * @subpackage controllers
 * @category controller
 */
class MasukCoolboxController extends MyAuthController {

    public $defaultAction = 'index';
    public $path_view = 'bankDarah.views.masukCoolbox.';
    public $init = '';
    public $penggunaancoolboxsimpan = false;
    
    /**
     * Digunakan untuk mengakses halaman transaksi masuk coolbox
     */
    public function actionIndex() {
        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'barang-m-grid') {
                $this->renderPartial($this->path_view . '/_dialogKantongDarah');
                Yii::app()->end();
            }
        }
        $model = new PenggunaanCoolboxT;
        $modDet = new PenggunaanCoolboxdetT;
        $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
        $modDet->tanggal_masukcoolbox = MyFormatter::formatDateTimeForUser(date('d M Y H:i:s'));
        $modDet->petugas_id = $modLogin->pegawai_id;
        $modDet->petugas_nama = $modLogin->pegawai->nama_pegawai;
        
        // Uncomment the following line if AJAX validation is needed
        if (isset($_POST['BDPenggunaanCoolboxdetT'])) {
            // echo '<pre>';var_dump($_POST);die;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $this->simpanPenggunaanCoolboxDet($_POST['BDPenggunaanCoolboxdetT'],$_POST['PenggunaanCoolboxdetT']['tanggal_masukcoolbox'],$_POST['PenggunaanCoolboxdetT']['petugas_id']);
                
                if ($this->penggunaancoolboxsimpan = true) {
                    $transaction->commit();
                    Yii::app()->user->setFlash("success", "Data berhasil Disimpan");
                    $this->redirect(array('index'));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash("error", "Data Gagal Disimpan");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modDet' => $modDet
        ));
    }
    
    /**
     * Fungsi untuk mendapatkan data penggunaan coolbox
     */
    public function actionGetPenggunaanCoolbox() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $id = !empty($_POST['id']) ? $_POST['id'] : null;
            
            $model = PenggunaanCoolboxT::model()->findByPk($id);

            if (!empty($model)) {
                $data['no_penggunaan_coolbox'] = $model->no_penggunaan_coolbox;
                $data['tgl_penggunaan_coolbox'] = $model->tgl_penggunaan_coolbox;
                $data['jumlah_icepack'] = $model->jumlah_icepack;
                $data['jenis_kantong'] = !empty($model->coolboxdarah->jenis_kantong) ? $model->coolboxdarah->jenis_kantong : '';
                $data['standar_suhu'] = !empty($model->coolboxdarah->standart_suhu) ? $model->coolboxdarah->standart_suhu : '';
            } else {
                $data['no_penggunaan_coolbox'] = "";
                $data['tgl_penggunaan_coolbox'] = "";
                $data['jumlah_icepack'] = "";
                $data['jenis_kantong'] = "";
                $data['standar_suhu'] = "";
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Fungsi untuk mendapatkan data kantong  
     */
    public function actionGetDataKantong()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            
            $no_kantongdarah = $_POST['nomor'];
            $criteria=new CDbCriteria;
            //$criteria->addCondition('pendonor_id IS NULL');
            //$criteria->addCondition('daftarpendonor_id IS NULL');
            //$criteria->addCondition('penerimaandarahpmidet_id IS NULL');
            $criteria->compare('LOWER(no_kantongdarah)', strtolower($no_kantongdarah), true);
            $model = KantongdarahT::model()->find($criteria);
            if(!empty($model)){
                $data['no_kantongdarah'] = $model->no_kantongdarah;
                $data['kantongdarah_id'] = $model->kantongdarah_id;
                $data['jeniskantong'] = !empty($model->jeniskantongdarah_id) ? $model->jeniskantongdarah->nama_jenis : '';
            }else{
                $data['no_kantongdarah'] = '';
                $data['kantongdarah_id'] = '';
                $data['jeniskantong'] = '';
            }
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Digunakan untuk load data kantong yang sudah di inputkan
     */
    public function actionGetMultipleKantong() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post
            
            $penggunaan_coolbox_id = $_POST['penggunaan_coolbox_id'];
            $nomorbarcode_utama = $_POST['nomorbarcode_utama'];
            $daftardonasi_id = $_POST['daftardonasi_id'];
            $jeniskantong = $_POST['jeniskantong'];
            $volume = $_POST['volume'];
            $kantongdarah = $_POST['kantongdarah'];
            $sampelkonfirmasi = $_POST['sampelkonfirmasi'];
            $sampleitd = $_POST['sampleitd'];
            $rhesus = $_POST['rhesus'];
            $gol_darah = $_POST['gol_darah'];
            $no_kantongpabrik = $_POST['no_kantongpabrik'];

            //set new model
            $modDet = new BDPenggunaanCoolboxdetT();
            
            $modDet->volume_kantong = $volume;
            $modDet->nomorbarcode_utama = $nomorbarcode_utama;
            $modDet->nomorbarcod_sample = $nomorbarcode_utama;
            $modDet->ada_samplekonfirmasi = $sampelkonfirmasi;
            $modDet->ada_sampleitd = $sampleitd;
            $modDet->ada_kantongdarah = $kantongdarah;
            $modDet->jeniskantong = $jeniskantong;
            $modDet->penggunaan_coolbox_id = $penggunaan_coolbox_id;
            $modDet->gol_darah = $gol_darah;
            $modDet->rhesus = $rhesus;
            $modDet->no_kantongpabrik = $no_kantongpabrik;
            $modDet->daftardonasi_id = $daftardonasi_id;

            $return = $this->renderPartial($this->path_view . "/_rowTambahKantong", array('model' => $modDet, 'i' => 1), true);

            $data['return'] = $return;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Fungsi untuk menyimpan penggunaan coolbox det
     * @param type $post
     * @param type $tanggal_masukcoolbox
     * @param type $petugas_id
     */
    public function simpanPenggunaanCoolboxDet($post,$tanggal_masukcoolbox,$petugas_id) {
        // echo '<pre>';var_dump($post);die;
        foreach ($post as $p) {
            $cekKantong = KantongdarahT::model()->findAllByAttributes(array('nomorbarcode_utama'=>$p['nomorbarcode_utama']));
            // echo '<pre>';var_dump($cekKantong);die;
            if(!empty($cekKantong)){
                foreach ($cekKantong as $val){
                    $cekDet = PenggunaanCoolboxdetT::model()->findByAttributes(array('nomorbarcode_utama'=>$p['nomorbarcode_utama'], 'penggunaan_coolbox_id'=>null));
                    if(!empty($cekDet)){
                        $cekDet->daftardonasi_id = $val->daftarpendonor_id;
                        $cekDet->penggunaan_coolbox_id = $p['penggunaan_coolbox_id'];
                        $cekDet->volume_kantong = $p['volume_kantong'];
                        $cekDet->ada_samplekonfirmasi = $p['ada_samplekonfirmasi'];
                        $cekDet->ada_sampleitd = $p['ada_sampleitd'];
                        $cekDet->ada_kantongdarah = $p['ada_kantongdarah'];
                        $cekDet->no_kantongpabrik = $p['no_kantongpabrik'];
                        $cekDet->tanggal_masukcoolbox = MyFormatter::formatDateTimeForDb($tanggal_masukcoolbox);
                        $cekDet->petugas_id = $petugas_id;
                        if($cekDet->save()){
                            $this->penggunaancoolboxsimpan = true;
                        }else{
                            $this->penggunaancoolboxsimpan = false;
                        }
                    }else{
                        $model = new PenggunaanCoolboxdetT;
                        $model->daftardonasi_id = $val->daftarpendonor_id;
                        $model->kantongdarah_id = $val->kantongdarah_id;
                        $model->penggunaan_coolbox_id = $p['penggunaan_coolbox_id'];
                        $model->nomorbarcod_sample = $p['nomorbarcod_sample'];
                        $model->nomorbarcode_utama = $p['nomorbarcode_utama'];
                        $model->kirimkantongdet_id = null;
                        $model->volume_kantong = $p['volume_kantong'];
                        $model->ada_samplekonfirmasi = $p['ada_samplekonfirmasi'];
                        $model->ada_sampleitd = $p['ada_sampleitd'];
                        $model->ada_kantongdarah = $p['ada_kantongdarah'];
                        $model->no_kantongpabrik = $p['no_kantongpabrik'];
                        $model->tanggal_masukcoolbox = MyFormatter::formatDateTimeForDb($tanggal_masukcoolbox);
                        $model->petugas_id = $petugas_id;
                        if($model->save()){
                            $this->penggunaancoolboxsimpan = true;
                        }else{
                            $this->penggunaancoolboxsimpan = false;
                        }
                    }
                    
                    $up = KantongdarahT::model()->findByPk($val->kantongdarah_id);
                    $up->gol_darah = $p['gol_darah'];
                    $up->rhesus = $p['rhesus'];
                    $up->update_time = date('Y-m-d H:i:s');
                    $up->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $this->penggunaancoolboxsimpan = $this->penggunaancoolboxsimpan && $up->save();                    
                }                                
            }
        }
    }
    
    /**
     * Autocomplete Kantong
     */
    public function actionAutoCompleteGetKantong() {
        if (Yii::app()->request->isAjaxRequest) {
            
            $cekDet = PenggunaanCoolboxdetT::model()->findAll('nomorbarcode_utama IS NOT NULL AND penggunaan_coolbox_id IS NOT NULL');
            $barcode_utama = array();

            foreach ($cekDet as $val):
                $barcode_utama[] = $val->nomorbarcode_utama;
            endforeach;

            $cri = new CDbCriteria;
            $cri->select = " t.*, jeniskantongdarah_m.nama_jenis, donor.gol_darah, donor.rhesus";
            $cri->join = ' LEFT JOIN jeniskantongdarah_m ON jeniskantongdarah_m.jeniskantongdarah_id = t.jeniskantongdarah_id '
                        . ' LEFT JOIN pendonor_m donor ON donor.pendonor_id = t.pendonor_id';
            $cri->addNotInCondition('t.nomorbarcode_utama',$barcode_utama);
            if (isset($_GET['term'])){
                $cri->compare("LOWER(t.nomorbarcode_utama)", strtolower($_GET['term']),true);
            }if (isset($_POST['term'])){
                $cri->compare("LOWER(t.nomorbarcode_utama)", strtolower($_POST['term']),true);                
            }
            $cri->limit = 10;

            $kantong = KantongdarahT::model()->findAll($cri);

            $res = array();

            $awal = '';
            
            foreach ($kantong as $det) {
                $res[$det->nomorbarcode_utama]['nomorbarcode_utama'] = $det->nomorbarcode_utama;
                $res[$det->nomorbarcode_utama]['nama_jenis'] = $det->nama_jenis;
                $res[$det->nomorbarcode_utama]['gol_darah'] = $det->gol_darah;
                
                $res[$det->nomorbarcode_utama]['rhesus_positif'] = false;
                $res[$det->nomorbarcode_utama]['rhesus_negatif'] = false;
                if (strtolower($det->rhesus) == 'positif'){
                    $res[$det->nomorbarcode_utama]['rhesus_positif'] = true;
                }elseif (strtolower($det->rhesus) == 'negatif'){
                    $res[$det->nomorbarcode_utama]['rhesus_negatif'] = true;
                }
                $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['nomorbarcode_utama'] = $det->nomorbarcode_utama;
                $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['nomorbarcode_sample'] = $det->nomorbarcode_sample;
                $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['jeniskantongdarah_id'] = $det->jeniskantongdarah_id;
                $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['det'][$det->kantongdarah_id]['komponendarah_id'] = $det->komponendarah_id;
                $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['det'][$det->kantongdarah_id]['no_kantongdarah'] = $det->no_kantongdarah;
                $res[$det->nomorbarcode_utama]['sampel'][$det->nomorbarcode_utama]['det'][$det->kantongdarah_id]['no_kantongdarah'] = $det->no_kantongdarah;
            }

            $returnVal = array();
            $i = 0;
            
            foreach ($res as $d){
                $returnVal[$i]['nomorbarcode_utama'] = $d['nomorbarcode_utama'];
                $returnVal[$i]['nama_jenis'] = $d['nama_jenis'];
                $returnVal[$i]['gol_darah'] = $d['gol_darah'];                
                $returnVal[$i]['rhesus_positif'] = $d['rhesus_positif'];
                $returnVal[$i]['rhesus_negatif'] = $d['rhesus_negatif'];
                $returnVal[$i]['label'] = $d['nomorbarcode_utama'];                
                $returnVal[$i]['value'] = $d['nomorbarcode_utama'];  
                
                $i++;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}
