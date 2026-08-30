<?php

/**
 * digunakan sebagai Laporan Produksi Komponen Darah
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * */
class LaporanProduksiKomponenDarahController extends MyAuthController {

    /**
     * Menampilkan laporan produksi komponen darah
     */
    public function actionIndex() {
        $model = new LapproduksikomponenV('search');
        $format = new MyFormatter();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        $this->render('admin', array(
            'model' => $model
        ));
    }

    /**
     * Fungsi ajax untuk mendapatkan laporan
     */
    public function actionGetLaporan() {
        if (Yii::app()->request->isAjaxRequest) {
            //mendapatkan tanggal awal dan tanggal akhir dari form search
            $tgl_awal = $_POST['tgl_awal'];
            $tgl_akhir = $_POST['tgl_akhir'];
            $data = $this->getData($tgl_awal, $tgl_akhir);
            //$data = null;
            $tr = $this->renderPartial('_detailLaporan', array('data' => $data), true);
            echo json_encode($tr);
            Yii::app()->end();
        }
    }

    /**
     * Fungsi untuk mencari data laporan
     * @param type $tgl_awal
     * @param type $tgl_akhir
     */
    public function getData($tgl_awal, $tgl_akhir) {

        $tanggal_awal = date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($tgl_awal)));
        $tanggal_akhir = date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($tgl_akhir)));

        //Cari jumlah ruangan sesuai dengan range data tanggal yang diinputkan
        $criteriaRuang = new CDbCriteria();
        $criteriaRuang->select = 'ruangan_rekruitmen_id, DATE(waktu_pendaftaran) as waktu_pendaftaran';
        $criteriaRuang->addBetweenCondition('DATE(waktu_pendaftaran)', $tanggal_awal, $tanggal_akhir);
        $criteriaRuang->group = 'ruangan_rekruitmen_id, DATE(waktu_pendaftaran)';
        $criteriaRuang->order = 'DATE(waktu_pendaftaran), ruangan_rekruitmen_id';
        $modelRuang = LapproduksikomponenV::model()->findAll($criteriaRuang);

        $ruang = array();
        foreach ($modelRuang as $val) {
            $ruang[] = $val->ruangan_rekruitmen_id;
        }

        $tanggal = array();
        foreach ($modelRuang as $val) {
            $tanggal[] = $val->waktu_pendaftaran;
        }

        $jumlahruang = !empty($modelRuang) ? count($modelRuang) : 0;

        //mencari data sesuai dengan data list bulan 
        if (!empty($modelRuang)) {
            $i = 0;
            $j = 0;
            $k = 0;
            $data = null;
            $dataPendonor = array();
            foreach ($modelRuang as $result) {
                $dataPendonor[$ruang[$i]]['dataPendonor'][] = $result->daftardonasi_id;
                $dataPendonor['tanggalnya'][] = date("Y-m-d", strtotime($result->waktu_pendaftaran));
                $dataPendonor['ruanganRekruitmen'][] = $result->ruangan_rekruitmen_id;
            }

            $tanggalnya = null;
            //merapikan indeks didalam array tanggal
            foreach ($dataPendonor['tanggalnya'] as $e) {
                $tanggalnya [$j] = $e;
                $j++;
            }

            $ruang_rekruitmen = null;
            //merapikan indeks didalam array tanggal
            foreach ($dataPendonor['ruanganRekruitmen'] as $g) {
                $ruang_rekruitmen [$k] = $g;
                $k++;
            }

            $i = 0;
            $kantong_sg = 0;
            $kantong_db = 0;
            $kantong_tr = 0;
            $kantong_qd = 0;
            $jumlah_wb = 0;
            $jumlah_prc = 0;
            $jumlah_ffp = 0;
            $jumlah_tc = 0;
            $jumlah_pcr = 0;
            $jumlah_ahf = 0;

            foreach ($modelRuang as $i => $result) {
                $data[$i]['gabung'] = !empty($tanggalnya[$i]) ? $tanggalnya[$i] : 0;
                $data[$i]['jumlahnya'] = count($ruang_rekruitmen);
                $data[$i]['tanggal'] = $tanggalnya[$i];
                $data[$i]['filter'] = $ruang_rekruitmen[$i];
                $data[$i]['jumlah_donor'] = $this->getJumlahDonor($tanggalnya[$i], $ruang_rekruitmen[$i]);
                $data[$i]['gagal_sadap'] = $this->viewGagalSadap($tanggalnya[$i], $ruang_rekruitmen[$i], 'yes');
                $data[$i]['skrining'] = $this->viewSkrining('yes', $tanggalnya[$i], $ruang_rekruitmen[$i]);
                $data[$i]['kantong_sg'] = $kantong_sg + $this->viewKantong('Single', $tanggalnya[$i], $ruang_rekruitmen[$i]);
                $data[$i]['kantong_db'] = $kantong_db + $this->viewKantong('Double', $tanggalnya[$i], $ruang_rekruitmen[$i]);
                $data[$i]['kantong_tr'] = $kantong_tr + $this->viewKantong('Triple', $tanggalnya[$i], $ruang_rekruitmen[$i]);
                $data[$i]['kantong_qd'] = $kantong_qd + $this->viewKantong('Quadruple', $tanggalnya[$i], $ruang_rekruitmen[$i]);
                $data[$i]['komponen_wb'] = $jumlah_wb + $this->viewKomponen($tanggalnya[$i], $ruang_rekruitmen[$i], 'Whole Blood');
                $data[$i]['komponen_prc'] = $jumlah_prc + $this->viewKomponen($tanggalnya[$i], $ruang_rekruitmen[$i], 'Packed Red Cell');
                $data[$i]['komponen_ffp'] = $jumlah_ffp + $this->viewKomponen($tanggalnya[$i], $ruang_rekruitmen[$i], 'Thrombocyte Concentrate');
                $data[$i]['komponen_tc'] = $jumlah_tc + $this->viewKomponen($tanggalnya[$i], $ruang_rekruitmen[$i], 'Fresh Frozen Plasma');
                $data[$i]['komponen_pcr'] = $jumlah_pcr + $this->viewKomponen($tanggalnya[$i], $ruang_rekruitmen[$i], 'PCR');
                $data[$i]['komponen_ahf'] = $jumlah_ahf + $this->viewKomponen($tanggalnya[$i], $ruang_rekruitmen[$i], 'Cryoprecipitate');
                $data[$i]['gagal_produksi'] = $this->viewGagalProduksi($tanggalnya[$i], $ruang_rekruitmen[$i]);
                $data[$i]['keterangan'] = $this->viewKeterangan($tanggalnya[$i], $ruang_rekruitmen[$i]);
                
                $data[$i]['asal'] = $ruang_rekruitmen[$i];
            }
        } else {
            //jika tidak ada record sesuai dengan tgl yg di search maaka akan direturn null
            $data = null;
        }
        return $data;
    }

    /**
     * Fungsi untuk mendapatkan jumlah pendonor
     * @param type $tanggal
     * @return type
     */
    protected function getJumlahDonor($tanggal, $ruangan) {
        $jam_awal = $tanggal . ' 00:00:00';
        $jam_akhir = $tanggal . ' 23:59:59';

        $criteria = new CDbCriteria();
        $criteria->select = 't.waktu_pendaftaran, t.is_batalpenyadapan, t.hasil_skrining, t.nama_jenis, t.namakomponendrh,'
                . 't.komponen_wb, t.komponen_prc, t.komponen_tc, t.komponen_ffp, t.komponen_pcr, t.komponen_cry, t.gol_darah, t.ruangan_rekruitmen_id';
        $criteria->addBetweenCondition('DATE(waktu_pendaftaran)', $jam_awal, $jam_akhir);
        $criteria->addCondition('t.ruangan_rekruitmen_id = ' . $ruangan);
        
        $donor = LapproduksikomponenV::model()->findAll($criteria);
        $jumlah = count($donor);
        return $jumlah;
    }

    /**
     * Fungsi untuk mendapatkan jumlah gagal sadap
     * @param type $is_gagalpenyadapan
     * @param type $tanggal
     * @return type
     */
    protected function viewGagalSadap($tanggal, $ruangan, $is_gagalpenyadapan = null) {
        $jam_awal = $tanggal . ' 00:00:00';
        $jam_akhir = $tanggal . ' 23:59:59';
        $criteria = new CDbCriteria();
        $criteria->select = 't.waktu_pendaftaran, t.is_batalpenyadapan, t.hasil_skrining, t.nama_jenis, t.namakomponendrh,'
                . 't.komponen_wb, t.komponen_prc, t.komponen_tc, t.komponen_ffp, t.komponen_pcr, t.komponen_cry, t.gol_darah, t.ruangan_rekruitmen_id';
        if (!empty($is_gagalpenyadapan)) {
            $criteria->addCondition("is_batalpenyadapan = true");
        }
        $criteria->addBetweenCondition('DATE(waktu_pendaftaran)', $jam_awal, $jam_akhir);
        $criteria->addCondition('t.ruangan_rekruitmen_id = ' . $ruangan);
        
        $model = LapproduksikomponenV::model()->findAll($criteria);
        $count = count($model);
        return $count;
    }

    /**
     * Fungsi untuk mendapatkan jumlah skrining yang reaktif
     * @param type $skrining
     * @param type $tanggal
     * @return type
     */
    protected function viewSkrining($skrining = null, $tanggal, $ruangan) {
        $jam_awal = $tanggal . ' 00:00:00';
        $jam_akhir = $tanggal . ' 23:59:59';
        $criteria = new CDbCriteria();
        $criteria->select = 't.waktu_pendaftaran, t.nomorbarcode_sample, t.is_batalpenyadapan, t.hasil_skrining, t.nama_jenis, t.namakomponendrh,'
                . 't.komponen_wb, t.komponen_prc, t.komponen_tc, t.komponen_ffp, t.komponen_pcr, t.komponen_cry, t.gol_darah, t.ruangan_rekruitmen_id';
        if (!empty($skrining)) {
            $criteria->addCondition("hasil_skrining = 'REAKTIF'");
        }
        $criteria->addBetweenCondition('DATE(waktu_pendaftaran)', $jam_awal, $jam_akhir);
        $criteria->addCondition('t.ruangan_rekruitmen_id = ' . $ruangan);
        
        $model = LapproduksikomponenV::model()->findAll($criteria);
        $count = count($model);
        return $count;
    }

    /**
     * Fungsi untuk mendapatkan informasi kantong darah
     * @param type $nama_jenis
     * @param type $tanggal
     * @return type
     */
    protected function viewKantong($nama_jenis = null, $tanggal, $ruangan) {
        $jam_awal = $tanggal . ' 00:00:00';
        $jam_akhir = $tanggal . ' 23:59:59';
        $criteria = new CDbCriteria();
        $criteria->select = 't.waktu_pendaftaran, t.nomorbarcode_sample, t.nama_jenis,'
                          . 't.gol_darah, t.ruangan_rekruitmen_id';
        if (!empty($nama_jenis)) {
            $criteria->addCondition("nama_jenis = '" . $nama_jenis . "'");
        }
        $criteria->addBetweenCondition('DATE(waktu_pendaftaran)', $jam_awal, $jam_akhir);
        $criteria->addCondition('t.ruangan_rekruitmen_id = ' . $ruangan);

        $model = LapproduksikomponenV::model()->findAll($criteria);
        $count = count($model);
        return $count;
    }

    /**
     * Fungsi untuk mendapatkan informasi komponen darah
     * @param type $tanggal
     * @param type $namakomponendrh
     * @return type
     */
    protected function viewKomponen($tanggal, $ruangan, $namakomponendrh = null) {
        $jam_awal = $tanggal . ' 00:00:00';
        $jam_akhir = $tanggal . ' 23:59:59';
        $criteria = new CDbCriteria();
        $criteria->select = 't.waktu_pendaftaran, t.nomorbarcode_sample, t.namakomponendrh,'
                . 't.komponen_wb, t.komponen_prc, t.komponen_tc, t.komponen_ffp, t.komponen_pcr, t.komponen_cry, t.gol_darah, t.ruangan_rekruitmen_id';
        if (!empty($namakomponendrh)) {
            $criteria->addCondition("namakomponendrh = '" . $namakomponendrh . "'");
        }
        $criteria->addCondition("komponen_wb = 'BERHASIL' OR "
                . "komponen_prc = 'BERHASIL' OR "
                . "komponen_tc = 'BERHASIL' OR "
                . "komponen_ffp = 'BERHASIL' OR "
                . "komponen_pcr = 'BERHASIL' OR "
                . "komponen_cry = 'BERHASIL'");
        $criteria->addBetweenCondition('DATE(waktu_pendaftaran)', $jam_awal, $jam_akhir);
        $criteria->addCondition('t.ruangan_rekruitmen_id = ' . $ruangan);
        
        $model = LapproduksikomponenV::model()->findAll($criteria);
        $count = count($model);
        return $count;
    }

    /**
     * Fungsi untuk mendapatkan jumlah gagal produksi 
     * @param type $tanggal
     * @return string
     */
    protected function viewGagalProduksi($tanggal, $ruangan) {
        $jam_awal = $tanggal . ' 00:00:00';
        $jam_akhir = $tanggal . ' 23:59:59';
        $criteria = new CDbCriteria();
        $criteria->select = 't.waktu_pendaftaran, t.nomorbarcode_sample, t.is_batalpenyadapan, t.hasil_skrining, t.nama_jenis, t.namakomponendrh,'
                . 't.komponen_wb, t.komponen_prc, t.komponen_tc, t.komponen_ffp, t.komponen_pcr, t.komponen_cry, t.gol_darah, t.ruangan_rekruitmen_id';
        $criteria->addCondition("komponen_wb = 'GAGAL PRODUKSI' OR "
                . "komponen_prc = 'GAGAL PRODUKSI' OR "
                . "komponen_tc = 'GAGAL PRODUKSI' OR "
                . "komponen_ffp = 'GAGAL PRODUKSI' OR "
                . "komponen_pcr = 'GAGAL PRODUKSI' OR "
                . "komponen_cry = 'GAGAL PRODUKSI'");

        $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)', $jam_awal, $jam_akhir);
        $criteria->addCondition('t.ruangan_rekruitmen_id = ' . $ruangan);
        
        $model = LapproduksikomponenV::model()->findAll($criteria);
        $count = count($model);
        if ($count > 1) {
            $data = array();
            $countWB = 0;
            $countPRC = 0;
            $countFFP = 0;
            $countTC = 0;
            $countPCR = 0;
            $countCRY = 0;
            foreach ($model as $m) {
                if ($m->komponen_wb == 'GAGAL PRODUKSI') {
                    $countWB = $countWB + 1;
                } else if ($m->komponen_prc == 'GAGAL PRODUKSI') {
                    $countPRC = $countPRC + 1;
                } else if ($m->komponen_ffp == 'GAGAL PRODUKSI') {
                    $countFFP = $countFFP + 1;
                } else if ($m->komponen_tc == 'GAGAL PRODUKSI') {
                    $countTC = $countTC + 1;
                } else if ($m->komponen_pcr == 'GAGAL PRODUKSI') {
                    $countPCR = $countPCR + 1;
                } else if ($m->komponen_cry == 'GAGAL PRODUKSI') {
                    $countCRY = $countCRY + 1;
                }
            }
            $data['wb'] = $countWB;
            $data['prc'] = $countPRC;
            $data['ffp'] = $countFFP;
            $data['tc'] = $countTC;
            $data['pcr'] = $countPCR;
            $data['cry'] = $countCRY;
        } else {
            $data = '';
        }
        return $data;
    }

    /**
     * Fungsi untuk mendapatkan jumlah gagal produksi 
     * @param type $daftardonasi_id
     * @param type $tanggal
     */
    protected function viewKeterangan($tanggal, $ruangan) {
        $jam_awal = $tanggal . ' 00:00:00';
        $jam_akhir = $tanggal . ' 23:59:59';
        $criteria = new CDbCriteria();
        $criteria->select = 't.waktu_pendaftaran, t.nomorbarcode_sample, t.is_batalpenyadapan, t.hasil_skrining, t.nama_jenis, t.namakomponendrh,'
                . 't.komponen_wb, t.komponen_prc, t.komponen_tc, t.komponen_ffp, t.komponen_pcr, t.komponen_cry, t.gol_darah, t.ruangan_rekruitmen_id';
        $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)', $jam_awal, $jam_akhir);
        $criteria->addCondition('t.ruangan_rekruitmen_id = ' . $ruangan);
        
        $model = LapproduksikomponenV::model()->findAll($criteria);
        $count = count($model);
        if ($count > 1) {
            $data = array();
            $countA_WB = 0;
            $countB_WB = 0;
            $countO_WB = 0;
            $countAB_WB = 0;
            $countA_PRC = 0;
            $countB_PRC = 0;
            $countO_PRC = 0;
            $countAB_PRC = 0;
            $countA_FFP = 0;
            $countB_FFP = 0;
            $countO_FFP = 0;
            $countAB_FFP = 0;
            $countA_TC = 0;
            $countB_TC = 0;
            $countO_TC = 0;
            $countAB_TC = 0;
            $countA_PCR = 0;
            $countB_PCR = 0;
            $countO_PCR = 0;
            $countAB_PCR = 0;
            $countA_AHF = 0;
            $countB_AHF = 0;
            $countO_AHF = 0;
            $countAB_AHF = 0;
            foreach ($model as $m) {
                if ($m->namakomponendrh == 'Whole Blood') { // komponen WB
                    if ($m->gol_darah == 'O') {
                        $countO_WB = $countO_WB + 1;
                    }
                    if ($m->gol_darah == 'A') {
                        $countA_WB = $countA_WB + 1;
                    }
                    if ($m->gol_darah == 'B') {
                        $countB_WB = $countB_WB + 1;
                    }
                    if ($m->gol_darah == 'AB') {
                        $countAB_WB = $countAB_WB + 1;
                    }
                } else if ($m->namakomponendrh == 'Packed Red Cell') { // komponen PRC
                    if ($m->gol_darah == 'O') {
                        $countO_PRC = $countO_PRC + 1;
                    }
                    if ($m->gol_darah == 'A') {
                        $countA_PRC = $countA_PRC + 1;
                    }
                    if ($m->gol_darah == 'B') {
                        $countB_PRC = $countB_PRC + 1;
                    }
                    if ($m->gol_darah == 'AB') {
                        $countAB_PRC = $countAB_PRC + 1;
                    }
                } else if ($m->namakomponendrh == 'Fresh Frozen Plasma') { // komponen FFP
                    if ($m->gol_darah == 'O') {
                        $countO_FFP = $countO_FFP + 1;
                    }
                    if ($m->gol_darah == 'A') {
                        $countA_FFP = $countA_FFP + 1;
                    }
                    if ($m->gol_darah == 'B') {
                        $countB_FFP = $countB_FFP + 1;
                    }
                    if ($m->gol_darah == 'AB') {
                        $countAB_FFP = $countAB_FFP + 1;
                    }
                } else if (($m->namakomponendrh == 'Thrombocyte Concentrate')) { // komponen TC
                    if ($m->gol_darah == 'O') {
                        $countO_TC = $countO_TC + 1;
                    }
                    if ($m->gol_darah == 'A') {
                        $countA_TC = $countA_TC + 1;
                    }
                    if ($m->gol_darah == 'B') {
                        $countB_TC = $countB_TC + 1;
                    }
                    if ($m->gol_darah == 'AB') {
                        $countAB_TC = $countAB_TC + 1;
                    }
                } else if (($m->namakomponendrh == 'PCR')) { // komponen PCR
                    if ($m->gol_darah == 'O') {
                        $countO_PCR = $countO_PCR + 1;
                    }
                    if ($m->gol_darah == 'A') {
                        $countA_PCR = $countA_PCR + 1;
                    }
                    if ($m->gol_darah == 'B') {
                        $countB_PCR = $countB_PCR + 1;
                    }
                    if ($m->gol_darah == 'AB') {
                        $countAB_PCR = $countAB_PCR + 1;
                    }
                } else if (($m->namakomponendrh == 'Cryoprecipitate')) { // komponen AHF
                    if ($m->gol_darah == 'O') {
                        $countO_AHF = $countO_AHF + 1;
                    }
                    if ($m->gol_darah == 'A') {
                        $countA_AHF = $countA_AHF + 1;
                    }
                    if ($m->gol_darah == 'B') {
                        $countB_AHF = $countB_AHF + 1;
                    }
                    if ($m->gol_darah == 'AB') {
                        $countAB_AHF = $countAB_AHF + 1;
                    }
                }
            }
            $data['wb']['a'] = $countA_WB;
            $data['wb']['b'] = $countB_WB;
            $data['wb']['o'] = $countO_WB;
            $data['wb']['ab'] = $countAB_WB;
            $data['prc']['a'] = $countA_PRC;
            $data['prc']['b'] = $countB_PRC;
            $data['prc']['o'] = $countO_PRC;
            $data['prc']['ab'] = $countAB_PRC;
            $data['ffp']['a'] = $countA_FFP;
            $data['ffp']['b'] = $countB_FFP;
            $data['ffp']['o'] = $countO_FFP;
            $data['ffp']['ab'] = $countAB_FFP;
            $data['tc']['a'] = $countA_TC;
            $data['tc']['b'] = $countB_TC;
            $data['tc']['o'] = $countO_TC;
            $data['tc']['ab'] = $countAB_TC;
            $data['pcr']['a'] = $countA_PCR;
            $data['pcr']['b'] = $countB_PCR;
            $data['pcr']['o'] = $countO_PCR;
            $data['pcr']['ab'] = $countAB_PCR;
            $data['cry']['a'] = $countA_AHF;
            $data['cry']['b'] = $countB_AHF;
            $data['cry']['o'] = $countO_AHF;
            $data['cry']['ab'] = $countAB_AHF;
            $data['wb']['total'] = $countA_WB + $countB_WB + $countO_WB + $countAB_WB;
            $data['prc']['total'] = $countA_PRC + $countB_PRC + $countO_PRC + $countAB_PRC;
            $data['ffp']['total'] = $countA_FFP + $countB_FFP + $countO_FFP + $countAB_FFP;
            $data['tc']['total'] = $countA_TC + $countB_TC + $countO_TC + $countAB_TC;
            $data['pcr']['total'] = $countA_PCR + $countB_PCR + $countO_PCR + $countAB_PCR;
            $data['cry']['total'] = $countA_AHF + $countB_AHF + $countO_AHF + $countAB_AHF;
        } else {
            $data = '';
        }
        return $data;
    }

    /**
     * Fungsi untuk mendapatkan ruangan
     * @param type $tanggal
     * @return string
     */
    protected function viewRuangan($tanggal, $ruangan) {
        $jam_awal = $tanggal . ' 00:00:00';
        $jam_akhir = $tanggal . ' 23:59:59';
        $criteria = new CDbCriteria();
        $criteria->select = 't.waktu_pendaftaran, t.nomorbarcode_sample, t.is_batalpenyadapan, t.hasil_skrining, t.nama_jenis, t.namakomponendrh,'
                . 't.komponen_wb, t.komponen_prc, t.komponen_tc, t.komponen_ffp, t.komponen_pcr, t.komponen_cry, t.gol_darah, t.ruangan_rekruitmen_id';
        $criteria->addBetweenCondition('DATE(t.waktu_pendaftaran)', $jam_awal, $jam_akhir);
        $criteria->addCondition('t.ruangan_rekruitmen_id = ' . $ruangan);
        
        $model = LapproduksikomponenV::model()->findAll($criteria);
        $count = count($model);
        if ($count > 1) {
            $data = array();
            $ruangan = 0;
            $ruangan_id = 0;
            $modRuangan = RuanganM::model()->findAll();
            foreach ($model as $m) {
                foreach ($modRuangan as $val) {
                    if ($m->ruangan_rekruitmen_id == $val->ruangan_id) {
                        $ruangan_id = $m->ruangan_rekruitmen_id;
                        $ruangan = $ruangan + 1;
                    }
                }
            }
            $data['asalnya']['ruangan_id'] = $ruangan_id;
            $data['asalnya']['ruangan'] = $ruangan;
        } else {
            $data = '';
        }
        return $data;
    }

    //fungsi untuk mendapatkan list tanggal dari tgl_awal sampai tgl_akhir
    protected function getDatesFromRange($start, $end, $format = 'Y-m-d') {
        $array = array();
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        foreach ($period as $date) {
            $array[] = $date->format($format);
        }

        return $array;
    }

    /**
     * Fungsi untuk mencetak laporan
     * @param type $caraPrint
     */
    public function actionPrint($caraPrint) {
        $format = new MyFormatter();
        $judulLaporan = 'LAPORAN PRODUKSI KOMPONEN DARAH';
        $tgl_awal = $_GET['LapproduksikomponenV']['tgl_awal'];
        $tgl_akhir = $_GET['LapproduksikomponenV']['tgl_akhir'];
        $model = $this->getData($tgl_awal, $tgl_akhir);
        $model2 = new LapproduksikomponenV('searchGrafik');
        //Data Grafik
        $data['title'] = 'GRAFIK LAPORAN PRODUKSI KOMPONEN DARAH';
        $type = substr($_GET['r'], 50);

        //$data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
        $data['type'] = $type;
        if (isset($_GET['LapproduksikomponenV'])) {
            $model2->attributes = $_GET['LapproduksikomponenV'];
            $model2->tgl_awal = $format->formatDateTimeForDb($_GET['LapproduksikomponenV']['tgl_awal']);
            $model2->tgl_akhir = $format->formatDateTimeForDb($_GET['LapproduksikomponenV']['tgl_akhir']);
            $model2->is_jenis = $_GET['LapproduksikomponenV']['is_jenis'];
        }
        //$data['type'] = $type;
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render('_print', array('judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'model' => $model, 'model2' => $model2, 'data' => $data));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('_print', array('judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'model' => $model, 'model2' => $model2, 'data' => $data));
        } else if ($caraPrint == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('_print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    /**
     * Menampilkan grafik produksi komponen
     */
    public function actionFrameGrafikProduksiKomponen() {
        $this->layout = '//layouts/iframe';

        $model2 = new LapproduksikomponenV('searchGrafik');
        $format = new MyFormatter();
        $model2->tgl_awal = date('Y-m-d');
        $model2->tgl_akhir = date('Y-m-d');
        //Data Grafik
        $data['title'] = 'Grafik Laporan Produksi Komponen Darah';
        //$data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
        $data['type'] = substr($_GET['id'], 6);
        if (isset($_GET['LapproduksikomponenV'])) {
            $model2->attributes = $_GET['LapproduksikomponenV'];
            $model2->tgl_awal = $format->formatDateTimeForDb($_GET['LapproduksikomponenV']['tgl_awal']);
            $model2->tgl_akhir = $format->formatDateTimeForDb($_GET['LapproduksikomponenV']['tgl_akhir']);
            $model2->is_jenis = $_GET['LapproduksikomponenV']['is_jenis'];
        }

        $this->render('_grafik', array(
            'model2' => $model2,
            'data' => $data,
        ));
    }

}
