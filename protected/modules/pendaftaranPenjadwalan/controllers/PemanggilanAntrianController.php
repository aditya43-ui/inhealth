<?php

class PemanggilanAntrianController extends MyAuthController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                if ($ajax == 'daftar-antrian-grid')
                    $path = 'grid/_listAntrian';
                $this->renderPartial($path,[]);
                exit;
            }
        }
        
        $model = new AntrianT;
        
        $this->pageTitle = Yii::app()->name . " - Pemanggilan Antrian";
        
        $this->render('index', array(
           'model' => $model
        ));
    }
    
    public function actionLoadLoketByModelAntrian(){
        if (Yii::app()->request->isAjaxRequest){
            
            $id = isset($_GET['id'])?$_GET['id']:null;
                        
            echo CHtml::tag('option', array('value'=>''),CHtml::encode('-Pilih-'),true);
            if (!empty($id)){
                $loket = LoketM::model()->findAll("modelantrian_id = ".$id." AND loket_aktif = TRUE ORDER BY loket_nourut ASC ");                
                if (!empty($loket)){                   
                    foreach($loket as $key => $value)
                    {
                        echo CHtml::tag('option', array('value'=>$value->loket_id),CHtml::encode($value->loket_nama),true);
                    }                    
                }
            }
            Yii::app()->end();
        }
    }
    
    public function actionPanggilNoAntrian(){
        if (Yii::app()->request->isAjaxRequest){
            
            $jenisAntrian = isset($_POST['jenisAntrian'])?$_POST['jenisAntrian']:null;
            $loketId = isset($_POST['loket'])?$_POST['loket']:null;
            $jumlahPanggil = isset($_POST['jumlahPanggil'])?$_POST['jumlahPanggil']:null;
            $antrianId = isset($_POST['antrianId'])?$_POST['antrianId']:null;
            $statuspanggil = isset($_POST['statuspanggil'])?$_POST['statuspanggil']:null;
            
            
            if (empty($antrianId)){
                if($jumlahPanggil < 5) {
                    $cri = new CDbCriteria;
                    $cri->join = " JOIN loket_m l ON l.loket_id = t.loket_id ";
                    $cri->select = " t.*, l.loket_nama, l.loket_singkatan ";
                    $cri->addCondition(" t.modelantrian_id = ".$jenisAntrian." AND t.loket_id = ".$loketId);
                    $cri->addCondition(" t.jam_panggil IS NULL AND DATE(tglantrian) = '".date('Y-m-d')."' AND t.jenis_kunjungan = 'Fast Track'");      
                    $cri->limit = $jumlahPanggil;
                    $cri->order = " t.noantrian::integer ASC ";
                    $listantrian = AntrianT::model()->findAll($cri);
                    
                    if(empty($listantrian)) { 
                        $cri = new CDbCriteria;
                        $cri->join = " JOIN loket_m l ON l.loket_id = t.loket_id ";
                        $cri->select = " t.*, l.loket_nama, l.loket_singkatan ";
                        $cri->addCondition(" t.modelantrian_id = ".$jenisAntrian." AND t.loket_id = ".$loketId);
                        $cri->addCondition(" t.jam_panggil IS NULL AND DATE(tglantrian) = '".date('Y-m-d')."' ");
                        $cri->limit = $jumlahPanggil;
                        $cri->order = " t.noantrian::integer ASC ";
                        $listantrian = AntrianT::model()->findAll($cri);   
                    }
                } else {
                    $cri = new CDbCriteria;
                    $cri->join = " JOIN loket_m l ON l.loket_id = t.loket_id ";
                    $cri->select = " t.*, l.loket_nama, l.loket_singkatan ";
                    $cri->addCondition(" t.modelantrian_id = ".$jenisAntrian." AND t.loket_id = ".$loketId);
                    $cri->addCondition(" t.jam_panggil IS NULL AND DATE(tglantrian) = '".date('Y-m-d')."' AND t.jenis_kunjungan = 'Fast Track'");      
                    // $cri->limit = $jumlahPanggil;
                    $cri->order = " t.noantrian::integer ASC ";
                    $listantrian = AntrianT::model()->findAll($cri);
                    if(count($listantrian) >= 5) {
                        $jumlahDikurangi = count($listantrian) - 5;
                        $jumlah = 5 + $jumlahDikurangi;
                        for($i=5;$i<$jumlah;$i++) {
                            unset($listantrian[$i]);
                        }

                    }
                    // var_dump($listantrian);die;
                    if(!empty($listantrian)) {
                        $limit = $jumlahPanggil - count($listantrian);

                        if($limit > 0) {
                            $cri = new CDbCriteria;
                            $cri->join = " JOIN loket_m l ON l.loket_id = t.loket_id ";
                            $cri->select = " t.*, l.loket_nama, l.loket_singkatan ";
                            $cri->addCondition(" t.modelantrian_id = ".$jenisAntrian." AND t.loket_id = ".$loketId);
                            $cri->addCondition(" t.jam_panggil IS NULL AND DATE(tglantrian) = '".date('Y-m-d')."' ");
                            $cri->limit = $limit;
                            $cri->order = " t.noantrian::integer ASC ";
                            $listantrian2 = AntrianT::model()->findAll($cri); 
                            // echo '<pre>';
                            // var_dump($listantrian2);die;

                            $listantrian =array_merge($listantrian , $listantrian2);
                            // echo '<pre>';
                            // var_dump($listantrian);die;
                        }
                    }
                    if(empty($listantrian)) { 
                        $cri = new CDbCriteria;
                        $cri->join = " JOIN loket_m l ON l.loket_id = t.loket_id ";
                        $cri->select = " t.*, l.loket_nama, l.loket_singkatan ";
                        $cri->addCondition(" t.modelantrian_id = ".$jenisAntrian." AND t.loket_id = ".$loketId);
                        $cri->addCondition(" t.jam_panggil IS NULL AND DATE(tglantrian) = '".date('Y-m-d')."' ");
                        $cri->limit = $jumlahPanggil;
                        $cri->order = " t.noantrian::integer ASC ";
                        $listantrian = AntrianT::model()->findAll($cri);   
                    }
                }
                
            }else{
                $cri = new CDbCriteria;
                $cri->join = " JOIN loket_m l ON l.loket_id = t.loket_id ";
                $cri->select = " t.*, l.loket_nama, l.loket_singkatan ";
                $cri->addCondition(" antrian_id = ".$antrianId);
                $cri->limit = $jumlahPanggil;
                $cri->order = " t.noantrian::integer ASC ";
                $listantrian = AntrianT::model()->findAll($cri);
            }
            
            // var_dump($listantrian);die;
                        
            $html = '<span class="required"><b>No Antrian tidak ditemukan</b></span>';
            
            $ok = true;
            $noantrian = [];
            $trans = Yii::app()->db->beginTransaction();
            try{                                
                if (!empty($listantrian)){
                    $html = '';
                    foreach($listantrian as $key => $val){     
                        if (empty($statuspanggil)){
                            if (empty($antrianId)){
                                $val->jam_panggil = date('Y-m-d H:i:s', strtotime("+".$key.' seconds'));
    //                            $val->panggil_flaq = true;
                                $val->tglpanggil = date('Y-m-d H:i:s', strtotime("+".$key.' seconds'));
                                $val->status_panggil = ParamsConst::STATUSPANGGIL_ANTRIAN_CALLOUTSIDE;
                                $val->status_barcode = ParamsConst::STATUSBARCODE_ANTRIAN_BELUMBARCODE;
                                $ok &= $val->update(['jam_panggil','panggil_flaq','tglpanggil','status_barcode','status_panggil']);                                       
                            }else{
                                $val->status_panggil = ParamsConst::STATUSPANGGIL_ANTRIAN_TUNGGU;
                                $val->status_barcode = ParamsConst::STATUSBARCODE_ANTRIAN_BELUMBARCODE;
                                $ok &= $val->update(['status_barcode','status_panggil']);                                       
                            }
                        }

                        $noantrian[$key] = $val->antrian_id;
                    }
                    
                    $cri = new CDbCriteria;
                    $cri->addInCondition("antrian_id",$noantrian);
                    $viewPanggil = Pemanggilanantrianlantai2V::model()->findAll($cri);
                    $html .= '<div style="width:100%"><b>No. Antrian sedang dipanggil</b>';
                    foreach($listantrian as $key => $val){    
                        $html .= $this->renderPartial('form/baris/_1_barisNoAntrian',['model'=>$val], true);
                    }
                    $html .= '</div>';
                }
                // echo '<pre>';
                // var_dump($html);die;
                if ($ok){
                    $trans->commit();
                }else{
                    $trans->rollback();
                }
            }catch(Exception $e){
                $trans->rollback();
            }            
            
            echo json_encode([
                'html' => $html,
                'noantrian' => $noantrian
            ]);
            Yii::app()->end();
        }
    }
    
    public function actionStatusBarcodeAntrian()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $antrianId = isset($_POST['antrianId']) ? $_POST['antrianId'] : null;
        $no = isset($_POST['no']) ? $_POST['no'] : null;
       
        $trans = Yii::app()->db->beginTransaction();
        $ok = true;
        try {
            $model = AntrianT::model()->findByPk($antrianId);

            if ($no == 1) { // mengubah pending menjadi proses
                $model->status_barcode = ParamsConst::STATUSBARCODE_ANTRIAN_PROSES;
                $model->status_panggil = ParamsConst::STATUSPANGGIL_ANTRIAN_TUNGGU;
            }

            $ok &= $model->update(['status_barcode','status_panggil']);

            if ($ok) {
                $trans->commit();
            } else {
                $trans->rollback();
            }
        } catch (Exception $e) {
            $trans->rollback();
        }

        echo json_encode([
            'sukses' => $ok
        ]);
    }
    
     public function actionFormUbahPoliklinik(){
        if (!Yii::app()->request->isAjaxRequest){
            Yii::app()->end();
        }                                
                
        if (!empty($_GET['id'])){
            $model = PPAntrianT::model()->findByPk($_GET['id']);
            $data = $this->renderPartial('form/_ubahPolik',['model'=>$model] , true);
        }else if (!empty($_POST['id'])){            
            $data = [];
            // var_dump($_POST);die;
            parse_str($_POST['formdata'], $arr);
            $ok = true;
            $pesan = '';
            $trans = Yii::app()->db->beginTransaction();
            try{
                $model = PPAntrianT::model()->findByPk($_POST['id']);
                
                $temp = $model;
                
                // $model->attributes = $arr['PPAntrianT'];
                if($model->ruangan_id != $arr['PPAntrianT']['ruangan_id']) {
                    $model->ubah_ruangan_id = $arr['PPAntrianT']['ruangan_id'];
                }
                if($model->modelantrian_id == $arr['PPAntrianT']['modelantrian_id'] ) {
                    $model->modelantrian_id = $arr['PPAntrianT']['modelantrian_id'];
                } else {
                    $model->ubah_modelantrian_id = $arr['PPAntrianT']['modelantrian_id'];
                }
                $model->noantrian = $arr['PPAntrianT']['noantrian'];
                
                $cri = new CDbCriteria;
                $cri->join = " JOIN loket_m l ON l.loket_id = t.loket_id ";
                $cri->addCondition("t.ruangan_id=" . $arr['PPAntrianT']['ruangan_id'] . " AND l.modelantrian_id =  " .  $arr['PPAntrianT']['modelantrian_id']);
                $loket = LoketpendaftaranpoliM::model()->find($cri);

                // echo '<pre>'; var_dump($arr, $loket->attributes, $cri); die;

                if (!empty($loket)) {
                    $model->loket_id = $loket->loket_id;
                    $model->modelantrian_id = $arr['PPAntrianT']['modelantrian_id'];
                }                               
                
                if ($temp->loket_id != $model->loket_id){
                    //$model->noantrian = MyGenerator::noAntrianModelAntrianInteger($model->modelantrian_id, $model->loket_id, $model->tglantrian);
                    
                    $tahun = date('y', strtotime($model->tglantrian));
                    $bulan = date('m', strtotime($model->tglantrian));
                    $tanggal = date('d', strtotime($model->tglantrian));
                    $nobarcode = $tahun . $bulan . $tanggal . $model->loket->loket_singkatan . $model->noantrian;
                    $model->barcode = $nobarcode;
                }                                                                
                
                $ok &= $model->save();
                
                if ($ok){
                    $data['pesan'] = "Berhasil Disimpan!";
                    $trans->commit();
                }else{
                    $trans->rollback();
                    $data['pesan'] = "Data gagal disimpan! 2";
                }
            }catch(Exception $e){

                echo '<pre>'; var_dump($e); die;
                $trans->rollback();
                $data['pesan'] = "Data gagal disimpan! 3";
                $ok &= false;
            }
            
            $data['sukses'] = $ok;
        }
        echo json_encode($data);
    }
    
    public function actionSetDropdownRuanganByJenisAntrian(){
        if (!Yii::app()->request->isAjaxRequest){
            Yii::app()->end();                        
        }
                
        $modelantrian_id = $_GET["modelantrian_id"];        
        
        $ruangan = null;
        if ($modelantrian_id) {
            $crJadwalPoli = new CDbCriteria();
            $crJadwalPoli->group = $crJadwalPoli->select = "t.ruangan_id, r.ruangan_nama";        
            $crJadwalPoli->compare('t.hari ', strtoupper($this->hari()));
            $crJadwalPoli->addCondition('t.jammulai <=' . "'" . date('H:i:s') . "'");
            $crJadwalPoli->addCondition('t.jamtutup >=' . "'" . date('H:i:s') . "'");
            $crJadwalPoli->join = ' join ruangan_m r on r.ruangan_id = t.ruangan_id 
            JOIN loketpendaftaranpoli_m loketpoli ON loketpoli.ruangan_id = t.ruangan_id 
            JOIN loket_m l ON l.loket_id = loketpoli.loket_id AND l.modelantrian_id =  ' . $modelantrian_id . '';
            $crJadwalPoli->addCondition('r.ruangan_aktif = true');
            $crJadwalPoli->order = "r.ruangan_nama ASC";
            $ruangan = JadwalbukapoliM::model()->findAll($crJadwalPoli);
            
            $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
        }
        
        
        if (empty($ruangan)) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
            echo  CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            foreach ($ruangan as $value => $name) {
                echo  CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        }
        
        
    }
    
    protected function hari() {
        $hari = date('l');
        /* $new = date('l, F d, Y', strtotime($Today)); */
        if ($hari == "Sunday") {
            return "MINGGU";
        } elseif ($hari == "Monday") {
            return "SENIN";
        } elseif ($hari == "Tuesday") {
            return "SELASA";
        } elseif ($hari == "Wednesday") {
            return "RABU";
        } elseif ($hari == "Thursday") {
            return "KAMIS";
        } elseif ($hari == "Friday") {
            return "JUMAT";
        } elseif ($hari == "Saturday") {
            return "SABTU";
        }
    }

}
