<?php

/**
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author rusdiyanto <rusdiyanto@.com>
 * @author Tantowy <tantowijaya@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id> 
 */
class SeleksiDonorDarahTController extends MyAuthController {

    /**
     * action ini digunakan untuk masuk ke transaksi seleksi donor darah
     * @param integer $pendonor_id
     * @param integer $daftardonasi_id
     */
    public function actionIndex($pendonor_id = null, $daftardonasi_id = null) {
        $model = new BDSeleksipendonorT;
        $modKuesioner = new BDSeleksikuesionerT;
        $modPendonor = new PendonorM;
        $modDaftarDonasi = new DaftardonasiT;
        $modObservasi = new ObservasipendonorT;
        $model->ruangan_id = 545; //Ruang Tranfusi Darah
        $model->tglseleksidonor = date('d M Y');

        if (isset($_GET['seleksidonor_id'])) {
            $model = BDSeleksipendonorT::model()->findByPk($_GET['seleksidonor_id']);
            $model->ruangan_id = 545; //Ruang Tranfusi Darah
        }

        if (!empty($pendonor_id)) {
            $modPendonor = PendonorM::model()->findByPk($pendonor_id);
            $modPendonor->tgllahir = MyFormatter::formatDateTimeForUser($modPendonor->tgllahir);
        }

        if (!empty($daftardonasi_id)) {
            $modDaftarDonasi = DaftardonasiT::model()->findByPk($daftardonasi_id);
        }

        /**
         * Pencarian tanggal riwayat terakhir
         */
        $modObs = ObservasipendonorT::model()->findByAttributes(array('daftardonasi_id' => $daftardonasi_id));
            if (!empty($modObs)) {
                $sql = 
                    "select * FROM (
                        select 
                        ROW_NUMBER() OVER (ORDER BY observasipendonor_id) AS nomor_urut, 
                        daftardonasi_id,
                        pendonor_id,
                        date(waktu_observasi) as waktu_observasi,
                        observasipendonor_id
                        from observasipendonor_t where pendonor_id = '".$modPendonor->pendonor_id."'
                        order by observasipendonor_id ASC
                    ) AS sub
                    GROUP BY nomor_urut,  daftardonasi_id, pendonor_id, waktu_observasi, observasipendonor_id
                    HAVING max(observasipendonor_id) <= '".$modObs->observasipendonor_id."'
                    order by observasipendonor_id ASC";
                $modObservasi = Yii::app()->db->createCommand($sql)->queryAll();
            
                if ($modObservasi > 1) {
                    foreach($modObservasi as $mod){
                        $hasil = $mod['nomor_urut']-1;   
                    }
                    $sql = 
                            "select * FROM (
                                select 
                                    ROW_NUMBER() OVER (ORDER BY observasipendonor_id) AS nomor_urut, 
                                    daftardonasi_id,
                                    pendonor_id,
                                    date(waktu_observasi) as waktu_observasi,
                                    observasipendonor_id
                                from observasipendonor_t where pendonor_id = '".$modPendonor->pendonor_id."'
                                order by observasipendonor_id ASC
                            ) AS sub
                            group by nomor_urut,  daftardonasi_id, pendonor_id, waktu_observasi, observasipendonor_id
                            having max(nomor_urut) = '".$hasil."'
                            order by observasipendonor_id ASC";
                    $result = Yii::app()->db->createCommand($sql)->queryAll();
                    foreach ($result as $item){
                        $modPendonor->waktu_observasi = date('d M Y', strtotime($item['waktu_observasi']));
                    }
                } else {
                    $modPendonor->waktu_observasi = '-';
                }
            } else {
                $modPendonor->waktu_observasi = '-';
            }  
            
        $this->render('index', array(
            'model' => $model,
            'modKuesioner' => $modKuesioner,
            'modPendonor' => $modPendonor,
            'modDaftarDonasi' => $modDaftarDonasi,
            'modObservasi' => $modObservasi
        ));
    }

    /**
     * action ini digunakan untuk masuk ke transaksi seleksi donor darah
     * @param integer $pendonor_id
     * @param integer $daftardonasi_id
     */
    public function actionSeleksiIndex($pendonor_id = null, $daftardonasi_id = null) {
        $this->layout = '//layouts/iframe';
        $model = new BDSeleksipendonorT;
        $modKuesioner = new BDSeleksikuesionerT;
        $modPendonor = new PendonorM;
        $modDaftarDonasi = new DaftardonasiT;

        $model->ruangan_id = 545; //Ruang Tranfusi Darah
        $model->tglseleksidonor = date('d M Y');
        $model->tglseleksikuesioner = date('d M Y H:i:s');
        if (isset($_GET['seleksidonor_id'])) {
            $model = BDSeleksipendonorT::model()->findByPk($_GET['seleksidonor_id']);
            $model->ruangan_id = 545; //Ruang Tranfusi Darah
        }

        if (!empty($pendonor_id)) {
            $modPendonor = PendonorM::model()->findByPk($pendonor_id);
            $modPendonor->tgllahir = MyFormatter::formatDateTimeForUser($modPendonor->tgllahir);
        }

        if (!empty($daftardonasi_id)) {
            $modDaftarDonasi = DaftardonasiT::model()->findByPk($daftardonasi_id);
            $cekPegawai = PegawaiM::model()->findByPk(!empty($modDaftarDonasi->dpjp_id) ? $modDaftarDonasi->dpjp_id : null);
            if(!empty($cekPegawai)){
                $model->dpjpkuesioner_nama = $cekPegawai->nama_pegawai;
                $model->dpjpkuesioner_id = $cekPegawai->pegawai_id;
            }
        }

        $cekSeleksi = BDSeleksipendonorT::model()->findByAttributes(array('daftardonasi_id' => $daftardonasi_id, 'pendonor_id' => $pendonor_id));
        $getSioner = array();
        if (!empty($cekSeleksi)) {
            $model = $cekSeleksi;
            $model->tglseleksikuesioner = MyFormatter::formatDateTimeForUser($model->tglseleksikuesioner);
            $model->petugaskoreksi_nama = !empty($model->petugaskoreksi_id) ? $model->petugaskoreksi->namaLengkap : '';
            $cekKuesioner = BDSeleksikuesionerT::model()->findAllByAttributes(array('daftardonasi_id' => $daftardonasi_id));
            if (!empty($cekKuesioner)) {
                foreach ($cekKuesioner as $cek) {
                    $getSioner[$cek->kuesionerdonor_id] = ($cek->ceklist) ? '1' : '0';
                }
            }
            if (!empty($model->petugaskoreksi_id)) {
                $petugasKoreksi = PegawaiM::model()->findByPk($model->petugaskoreksi_id);
                if (!empty($petugasKoreksi)) {
                    $model->petugaskoreksi_nama = $petugasKoreksi->namaLengkap;
                } else {
                    $model->petugaskoreksi_nama = '-';
                }
            } else if (!empty($model->ppds_id)) {
                $ppds = PpdsM::model()->findByPk($model->ppds_id);
                if (!empty($ppds)) {
                    $model->ppds_nama = $ppds->ppds_nama;
                } else {
                    $model->ppds_nama = '-';
                }
            }
            
            if (!empty($model->dpjpkuesioner_id)) {
                $DPJP = PegawaiM::model()->findByPk($model->dpjpkuesioner_id);
                if (!empty($DPJP)) {
                    $model->dpjpkuesioner_nama = $DPJP->namaLengkap;
                } else {
                    $model->dpjpkuesioner_nama = '-';
                }
            }
        }

        if (isset($_POST['BDSeleksipendonorT'])) {

            $transaction = Yii::app()->db->beginTransaction();
            try {

                $model->attributes = $_POST['PendonorM'];
                $model->attributes = $_POST['DaftardonasiT'];
                $model->attributes = $_POST['BDSeleksipendonorT'];

                //if (empty($cekSeleksi)) {
                    $model->tglseleksikuesioner = MyFormatter::formatDateTimeForDb($_POST['BDSeleksipendonorT']['tglseleksikuesioner']);
                    $model->tglseleksidonor = MyFormatter::formatDateTimeForDb($model->tglseleksidonor);
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->jenisdonor = "Sukarela";
                    $model->status_pendonor = ($_POST['BDSeleksipendonorT']['is_gagalseleksiawal'] == "gagal") ? "DITOLAK" : "DITERIMA";
                    $model->tekanandarah = isset($model->td_systolic) ? $model->td_systolic . " / " . $model->td_diastoliic : '';
                    $model->td_systolic = isset($model->td_systolic) ? $model->td_systolic : '';
                    $model->td_diastoliic = isset($model->td_diastoliic) ? $model->td_diastoliic : '';
                    $model->kadar_hb = isset($model->kadar_hb) ? $model->kadar_hb : '';
                    
                    $model->hb_rendah = 0;
                    $model->bb_rendah = 0;
                    $model->medis_hb_17 = 0;
                    $model->medis_td_rendah = 0;
                    $model->medis_tk_tinggi = 0;
                    $model->medis_bb_lebih = 0;
                    $model->medis_vaksin = 0;
                    $model->perilakuberesiko = 0;
                    $model->riwberpergian = 0;
                    $model->lain_lain = 0;
                    $model->dpjpkuesioner_id = $_POST['BDSeleksipendonorT']['dpjpkuesioner_id'];
                    if ($_POST['BDSeleksipendonorT']['gagal_seleksi_wanita'] == 'gagal_seleksi') {
                        //$model->lain_lain = true;
                        $model->is_gagalseleksi = true;
                        $model->lain_lain = true;
                        $model->status_pendonor = 'DITOLAK';
                    }else{
                        $model->is_gagalseleksi = 0;
                        $model->lain_lain = false;
                        $model->status_pendonor = 'DITERIMA';
                    }
                //}

                if ($model->save()) {                    
                    foreach ($_POST['Kuesioner'] as $key => $value) {

                        $cekModKuesioner = BDSeleksikuesionerT::model()->findByAttributes(array('kuesionerdonor_id' => $key, 'daftardonasi_id' => $model->daftardonasi_id, 'seleksidonor_id' => $model->seleksidonor_id));

                        if (empty($cekModKuesioner)) {
                            $modKuesioner = new BDSeleksikuesionerT;
                            $modKuesioner->daftardonasi_id = $model->daftardonasi_id;
                            $modKuesioner->kuesionerdonor_id = $key;
                            $modKuesioner->seleksidonor_id = $model->seleksidonor_id;
                            $modKuesioner->ceklist = $value;
                            $modKuesioner->save();
                        } else {
                            $value = ($value == '1') ? 'true' : 'false';
                            Yii::app()->db->createCommand(" update seleksikuesioner_t SET ceklist = " . $value . " WHERE kuesionerdonor_id = " . $key . " AND daftardonasi_id = " . $model->daftardonasi_id . " AND seleksidonor_id = " . $model->seleksidonor_id . " ")->execute();
                        }
                    }

                    if (empty($cekSeleksi)) {
                        $up = DaftardonasiT::model()->findByPk($model->daftardonasi_id);
                        $up->status = 'SELEKSI';
                        $up->save();
                    }

                    $transaction->commit();
                    $this->redirect(array('SeleksiIndex', 'pendonor_id' => $model->pendonor_id, 'daftardonasi_id' => $model->daftardonasi_id, 'seleksidonor_id' => $model->seleksidonor_id, 'sukses' => 1));
                } else {                    
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan !");
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan !" . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render('formSeleksiIndex', array(
            'model' => $model,
            'modKuesioner' => $modKuesioner,
            'modPendonor' => $modPendonor,
            'modDaftarDonasi' => $modDaftarDonasi,
            'getSioner' => $getSioner,
            'cekSeleksi' => $cekSeleksi,
            
        ));
    }

    /**
     * action ini digunakan untuk masuk ke transaksi tab seleksi tanda vital
     * @param integer $pendonor_id
     * @param integer $daftardonasi_id
     */
    public function actionSeleksiTandaVitalIndex($pendonor_id = null, $daftardonasi_id = null) {

        $this->layout = '//layouts/iframe';
        if (isset($daftardonasi_id)) {
            $modSeleksi = SeleksipendonorT::model()->findByAttributes(array('daftardonasi_id' => $daftardonasi_id));
            $model = BDSeleksipendonorT::model()->findByPk($modSeleksi->seleksidonor_id);
            $modDokter = PegawaiM::model()->findByPk($model->dokter_id);
            $model->dokter_nama = isset($modDokter->nama_pegawai) ? $modDokter->nama_pegawai : '';
        } else {
            $model = new BDSeleksipendonorT;
        }
        $modKuesioner = new BDSeleksikuesionerT;
        $modPendonor = new PendonorM;
        $modDaftarDonasi = new DaftardonasiT;
        $model->tglseleksidonor = MyFormatter::formatDateTimeForUser(date("Y-m-d H:i:s"));

        if (isset($_GET['seleksidonor_id'])) {
            $model = BDSeleksipendonorT::model()->findByPk($_GET['seleksidonor_id']);
            $model->ruangan_id = Params::RUANGAN_TRANSFUSI_DARAH; //Ruang Tranfusi Darah
        }

        if (!empty($pendonor_id)) {
            $modPendonor = PendonorM::model()->findByPk($pendonor_id);
            $modPendonor->tgllahir = MyFormatter::formatDateTimeForUser($modPendonor->tgllahir);
            $model->rhesus = $modPendonor->rhesus;
            $model->gol_darah = $modPendonor->gol_darah;

            if (isset($_POST['BDSeleksipendonorT'])) {
                $modPendonor->rhesus = $_POST['BDSeleksipendonorT']['rhesus'];
                $modPendonor->tgllahir = !empty($modPendonor->tgllahir) ? MyFormatter::formatDateTimeForDb($modPendonor->tgllahir) : null;
                $modPendonor->gol_darah = !empty($modPendonor->gol_darah) ? $_POST['BDSeleksipendonorT']['gol_darah'] : null;
                $modPendonor->update();
            }
        }

        if (!empty($daftardonasi_id)) {
            $modDaftarDonasi = DaftardonasiT::model()->findByPk($daftardonasi_id);
        }

        if (isset($_POST['BDSeleksipendonorT'])) {

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['PendonorM'];
                $model->attributes = $_POST['DaftardonasiT'];
                $model->attributes = $_POST['BDSeleksipendonorT'];
                $model->tglseleksidonor = MyFormatter::formatDateTimeForDb($model->tglseleksidonor);
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->create_time = date('Y-m-d H:i:s');
                if ($_POST['BDSeleksipendonorT']['is_gagalseleksiawal'] == "gagal") {
                    $model->status_pendonor = "DITOLAK";                    
                    $model->is_gagalseleksi = true;
                } else {
                    $model->status_pendonor = "DITERIMA";
                }
                $model->tekanandarah = isset($model->td_systolic) ? $model->td_systolic . " / " . $model->td_diastoliic : 0;
                $model->td_systolic = isset($model->td_systolic) ? $model->td_systolic : 0;
                $model->td_diastoliic = isset($model->td_diastoliic) ? $model->td_diastoliic : 0;
                $model->kadar_hb = isset($model->kadar_hb) ? $model->kadar_hb : 0;
                $model->minum_obat = $_POST['BDSeleksipendonorT']['minum_obat'];
                if ($model->validate()) {
                    $model->save();
                    SeleksikuesionerT::model()->updateAll(array('seleksidonor_id' => $model->seleksidonor_id), 'daftardonasi_id=' . $model->daftardonasi_id);

                    $pendonor = PendonorM::model()->findByPk($model->pendonor_id);
                    $pendonor->gol_darah = $_POST['BDSeleksipendonorT']['gol_darah'];
                    $pendonor->rhesus = $_POST['BDSeleksipendonorT']['rhesus'];
                    $pendonor->save();

                    $transaction->commit();
                    $this->redirect(array('SeleksiTandaVitalIndex', 'pendonor_id' => $model->pendonor_id, 'daftardonasi_id' => $model->daftardonasi_id, 'seleksidonor_id' => $model->seleksidonor_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan !");
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan !" . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render('formSeleksiTandaVitalIndex', array(
            'model' => $model,
            'modKuesioner' => $modKuesioner,
            'modPendonor' => $modPendonor,
            'modDaftarDonasi' => $modDaftarDonasi,
        ));
    }

    /**
     * Digunakan untuk menampilkan detail seleksi
     * @author  Andyka <andykaputra@.com>
     * @param integer $pendonor_id
     * @param integer $daftardonasi_id
     */
    public function actionDetailSeleksi($pendonor_id, $daftardonasi_id) {
        $this->layout = '//layouts/iframe';
        $model = BDSeleksipendonorT::model()->findByAttributes(array('pendonor_id' => $pendonor_id, 'daftardonasi_id' => $daftardonasi_id));
        $modKuesioner = BDSeleksikuesionerT::model()->findAllByAttributes(array('seleksidonor_id' => $model->seleksidonor_id, 'daftardonasi_id' => $daftardonasi_id));
        $modPendonor = PendonorM::model()->findByPk($pendonor_id);
        $modDaftarDonasi = DaftardonasiT::model()->findByPk($daftardonasi_id);

        $model->ruangan_id = 545; //Ruang Tranfusi Darah
        $model->tglseleksidonor = date('d M Y');

        if (isset($_GET['seleksidonor_id'])) {
            $model = BDSeleksipendonorT::model()->findByPk($_GET['seleksidonor_id']);
            $model->ruangan_id = 545; //Ruang Tranfusi Darah
        }

        if (!empty($pendonor_id)) {
            $modPendonor = PendonorM::model()->findByPk($pendonor_id);
            $modPendonor->tgllahir = MyFormatter::formatDateTimeForUser($modPendonor->tgllahir);
        }

        if (!empty($daftardonasi_id)) {
            $modDaftarDonasi = DaftardonasiT::model()->findByPk($daftardonasi_id);
        }

        $this->render('detailseleksi', array(
            'model' => $model,
            'modKuesioner' => $modKuesioner,
            'modPendonor' => $modPendonor,
            'modDaftarDonasi' => $modDaftarDonasi,
        ));
    }

    /**
     * digunakan untuk autocomplete pegawai
     */
    public function actionAutocompletePetugas() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $nama = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama), true);
            ;
            $criteria->addCondition('ruangan_id = 545');
            $criteria->limit = 5;
            $models = PegawairuanganV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->nama_pegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * digunakan untuk mengecek data  seleksi donor darah
     */
    public function actionGetData() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = isset($_POST['id']) ? $_POST['id'] : ' ';
            $value = isset($_POST['value']) ? $_POST['value'] : ' ';
            if (isset($id) && isset($value)) {
                $modSeleksikusioner = SeleksikuesionerT::model()->findByAttributes(array('daftardonasi_id' => $id));
                $modSeleksipendonor = SeleksipendonorT::model()->findByAttributes(array('daftardonasi_id' => $id));
                if (isset($modSeleksikusioner) && isset($modSeleksipendonor) && $modSeleksipendonor->is_gagalseleksi == false && $value != 'cekkantong') {
                    $data['sukses'] = 1;
                    $data['pesan'] = 'data ada';
                } else if (isset($modSeleksikusioner) && isset($modSeleksipendonor) && $modSeleksipendonor->dokter_id == null && $modSeleksipendonor->is_gagalseleksi == true && $value != 'cekkantong') {
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Anda tidak lolos seleksi kuesioner';
                } else if (isset($modSeleksikusioner) && isset($modSeleksipendonor) && $modSeleksipendonor->dokter_id == null && $modSeleksipendonor->is_gagalseleksi != true && $modSeleksikusioner->seleksidonor_id == null && $value == 'cekkantong') {
                    $data['sukses'] = 0;
                    $data['pesan'] = 'seleksi tanda vital belum dilakukan';
                } else if (empty($modSeleksikusioner) && empty($modSeleksipendonor) && $value != 'cekkantong') {
                    $data['sukses'] = 0;
                    $data['pesan'] = 'seleksi kuesioner belum dilakukan';
                } else if (isset($modSeleksikusioner) && isset($modSeleksipendonor) && $modSeleksipendonor->is_gagalseleksi == false && $value == 'cekkantong') {
                    $data['sukses'] = 1;
                    $data['pesan'] = 'data ada';
                } else if (empty($modSeleksikusioner) && empty($modSeleksipendonor) && $value == 'cekkantong') {
                    $data['sukses'] = 0;
                    $data['pesan'] = 'seleksi kuesioner belum dilakukan';
                } else if (isset($modSeleksikusioner) && isset($modSeleksipendonor) && $modSeleksipendonor->dokter_id == null && $modSeleksipendonor->is_gagalseleksi == true && $value == 'cekkantong') {
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Anda tidak lolos seleksi kuesioner';
                } else if (isset($modSeleksikusioner) && isset($modSeleksipendonor) && $modSeleksipendonor->dokter_id != null && $modSeleksipendonor->status_pendonor == "DITOLAK" && $value == 'cekkantong') {
                    $data['sukses'] = 1;
                    $data['pesan'] = 'data ada';
                } else if (isset($modSeleksikusioner) && isset($modSeleksipendonor) && $modSeleksipendonor->dokter_id != null && $modSeleksipendonor->status_pendonor == "DITOLAK" && $value == 'cektandavital') {
                    $data['sukses'] = 1;
                    $data['pesan'] = 'data ada';   
                }
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Fungsi untuk Menampilkan Dialog PPDS
     */
    public function actionAutocompletePpds() {
        if (Yii::app()->request->isAjaxRequest) {

            $returnVal = array();
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }

            $criteria->compare('LOWER(ppds_nama)', strtolower($_GET['term']), true);
            //$criteria->addCondition('ppds_aktif IS true');
            $criteria->order = 'ppds_nama ASC';
            $criteria->limit = 10;
            $models = PpdsM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->ppds_nama;
                $returnVal[$i]['ppds_nama'] = $model->ppds_nama;
                $returnVal[$i]['value'] = $model->ppds_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Fungsi untuk Menampilkan Dialog DPJP
     * @author  Andyka <andykaputra@.com>
     */
    public function actionAutocompleteDpjp() {
        if (Yii::app()->request->isAjaxRequest) {

            $returnVal = array();
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            if (!isset($_GET['ruangan_id'])) {
                $_GET['ruangan_id'] = null;
            }

            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition('kelompokpegawai_id = 1');
            $criteria->addCondition('ruangan_id =' . $_GET['ruangan_id']);
            $criteria->order = 'nama_pegawai ASC';
            $criteria->limit = 10;
            $models = PegawairuanganV::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nama_pegawai;
                $returnVal[$i]['pegawai_id'] = $model->pegawai_id;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}
