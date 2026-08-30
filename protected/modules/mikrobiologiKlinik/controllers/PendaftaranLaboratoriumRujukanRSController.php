<?php

/**
 * Proses pendaftaran / verifikasi penilaian kelayakan spesimen
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @author Tantowi J <tantowijaya@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage controllers
 * @category controller
 */
class PendaftaranLaboratoriumRujukanRSController extends MyAuthController {
    
    public $path_view_spesimen = "mikrobiologiKlinik.views.penilaianKelayakanSpesimen.";
    
    public $tindakanpelayanantersimpan = true; //dilooping / boleh tanpa ini
    public $komponentindakantersimpan = true; //di looping
    public $pengambilansampletersimpan = true; //dilooping / boleh tanpa ini
    public $pasienpenunjangtersimpan = true; //dilooping
    public $hasilpemeriksaantersimpan = true; //dilooping
    public $updatespesimen = true; //dilooping
        
    /**
     * Default transaksi
     * @param integer $pasienkirimkeunitlain_id
     * @param integer $pasienmasukpenunjang_id
     */
    public function actionIndex($pasienkirimkeunitlain_id, $pasienmasukpenunjang_id = null){
        $format = new MyFormatter();
        $modTindakan = new MKTindakanPelayananT;
        $modPasienMasukPenunjang = new MKPasienmasukpenunjangT;
        $modPemeriksaanLab = new MKTarifpemeriksaanlabruanganV;
        $modSpesimen = new MKSpesimenT;
        $modKunjungan = new MKPasienKirimKeUnitLainV;
        /// $modPpdsAlamat = new PpdsalamatM;
        $modPpds= new PpdsM;
        $modSpesimen2 = new SpesimenT;
        $dataSpesimen = new MKSpesimenT;
        $dataKirimSpesimen = new KirimspesimenlabT;
        
        // $modPpdsAlamat->no_mobile = null;
                
        if (!empty($pasienkirimkeunitlain_id)) {
            $modePasienKirimUnitlain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
            if(!empty($pasienmasukpenunjang_id)){
                $modKunjungan = MKPasienmasukpenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
                $modKunjungan->catatandokterpengirim = $modePasienKirimUnitlain->catatandokterpengirim;
            }else{
                $modKunjungan = MKPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
            }
            
           if(!empty($modePasienKirimUnitlain->ppds_id)){
                $modPpds = PpdsM::model()->findByPk($modePasienKirimUnitlain->ppds_id);
                /* $modPpdsAlamat = PpdsalamatM::model()->findByAttributes(array('ppds_id' => $modPpds->ppds_id));
                if(empty($modPpdsAlamat->ppds_id)){
                    $modPpdsAlamat = new PpdsalamatM;
                    $modPpdsAlamat->no_mobile = null;
                }
                */
            }
            $modPermintaanKePenunjang = PermintaankepenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
            
            $modPenilaian = MKPenialianKelayakanSpesimenT::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$pasienkirimkeunitlain_id));
            if(!empty($modPenilaian->penilaian_kelayakan_spesimen_id)){
                $modPenilaian->manajerpelayanan_nama = !empty($modPenilaian->manajerpelayanan_id)? PegawaiM::model()->findByPk($modPenilaian->manajerpelayanan_id)->namaLengkap : "";
                $modPenilaian->dpjtm_nama = !empty($modPenilaian->dpjtm_id)? PegawaiM::model()->findByPk($modPenilaian->dpjtm_id)->namaLengkap : "";
                $modPenilaian->ppds_nama = !empty($modPenilaian->ppds_id)? PpdsM::model()->findByPk($modPenilaian->ppds_id)->ppds_nama : "";
                $dataSpesimen = MKSpesimenT::model()->findAllByAttributes(array('penilaian_kelayakan_spesimen_id'=>$modPenilaian->penilaian_kelayakan_spesimen_id));
                
                $modSpesimen2 = SpesimenT::model()->findByAttributes(array('penilaian_kelayakan_spesimen_id'=>$modPenilaian->penilaian_kelayakan_spesimen_id));
            }else{
                $modPenilaian = new MKPenialianKelayakanSpesimenT;
            }
            
            $dataKirimSpesimen = KirimspesimenlabT::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$pasienkirimkeunitlain_id));            
            if (empty($dataKirimSpesimen)) {
                $dataKirimSpesimen = new KirimspesimenlabT;
            }
            $modPendaftaran = PendaftaranT::model()->findByPk($modePasienKirimUnitlain->pendaftaran_id);
        }
        
        $modPasienMasukPenunjang->ruangan_id = Yii::app()->user->getState("ruangan_id");
//        $modPasienMasukPenunjang->jeniskasuspenyakit_id = $modKunjungan->jeniskasuspenyakit_id;
        $modPasienMasukPenunjang->ppds_id = $modPenilaian->ppds_id;
        $modPasienMasukPenunjang->pegawai_id = $modPenilaian->dpjtm_id;
        
        if(isset($_POST['MKPenialianKelayakanSpesimenT'])){
            $sukses = true;
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $pasienkirimkeunitlain_id);
                $updateKirimSpesimen = KirimspesimenlabT::model()->updateAll(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id), 'pasienkirimkeunitlain_id = '.$modPasienMasukPenunjang->pasienkirimkeunitlain_id);
                $pasienkirimterupdate = PasienkirimkeunitlainT::model()->updateByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id, array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id));
                $modPenilaian->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
                $modPenilaian->update();
                $modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPendaftaran->pasien, $modPasienMasukPenunjang);
                if (isset($_POST['MKTindakanPelayananT'])) {
                    if (count($_POST['MKTindakanPelayananT']) > 0) {
                        foreach ($_POST['MKTindakanPelayananT'] AS $ii => $tindakan) {
                            $dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $tindakan);
                            $modSpesimen = SpesimenT::model()->findByPk($tindakan['spesimen_id']);
                            $modSpesimen->tindakanpelayanan_id = $dataTindakans[$ii]->tindakanpelayanan_id;
                            $this->updatespesimen = $this->updatespesimen && $modSpesimen->update();
                            if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
                                if (empty($tindakan['tindakanpelayanan_id'])) { //jika tindakan baru
                                    $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$ii], $tindakan);
                                }
                            }

//                            untuk ditampilkan di form
                            $dataTindakans[$ii]->pemeriksaanlab_id = $tindakan['pemeriksaanlab_id'];
                            $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
                            $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
                        }
                    }
                }
                
                
                if ($this->updatespesimen && $this->pasienpenunjangtersimpan && $this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->hasilpemeriksaantersimpan && $pasienkirimterupdate) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data pemeriksaan laboratorium berhasil disimpan !");
                    $this->redirect(array('index', 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data pemeriksaan laboratorium gagal disimpan !");
                }
                
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data pemeriksaan laboratorium gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        
        $this->render('index', array(
            'modKunjungan' => $modKunjungan,
            'modPemeriksaanLab' => $modPemeriksaanLab,
            'modTindakan' => $modTindakan,
            'modPpds' => $modPpds,
            // 'modPpdsAlamat' => $modPpdsAlamat,
            'modPenilaian' => $modPenilaian,
            'modSpesimen' => $modSpesimen,
            'modPermintaanKePenunjang' => $modPermintaanKePenunjang,
            'dataKirimSpesimen' => $dataKirimSpesimen,
            'dataSpesimen' => $dataSpesimen,
            'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
            'modSpesimen2' => $modSpesimen2
        ));
    }
    
    /**
     * set PermintaanKePenunjangT yang sudah ada di database
     */
    public function actionSetPermintaanKePenunjang() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $penjamin_id = $_POST['penjamin_id'];
            $modPermintaans = PermintaankepenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id' => $_POST['pasienkirimkeunitlain_id']));

            if (count($modPermintaans) > 0) {
                foreach ($modPermintaans AS $i => $modPermintaan) {
                    $modPemeriksaan = PemeriksaanlabM::model()->findByAttributes(array('pemeriksaanlab_id' => $modPermintaan->pemeriksaanlab_id));
                    if (isset($modPemeriksaan->daftartindakan_id)) {
                        $modPermintaan->daftartindakan_id = $modPemeriksaan->daftartindakan_id;
                        $rows .= $this->renderPartial("_rowPermintaanKePenunjang", array('i' => 0, 'modPermintaan' => $modPermintaan, 'penjamin_id' => $penjamin_id), true);
                    }
                }
            }
            echo CJSON::encode(array(
                'rows' => $rows));
        }
        Yii::app()->end();
    }

    /**
     * Fungsi untuk menyimpan data ke model PasienmasukpenunjangT
     * @param array $modPasienMasukPenunjang
     * @param array $modPendaftaran
     * @param integer $pasienkirimkeunitlain_id
     * @return \modPasienMasukPenunjang
     */
    public function simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $pasienkirimkeunitlain_id) {
        $modPasienMasukPenunjang = new $modPasienMasukPenunjang;
        $format = new MyFormatter();
        $modPasienMasukPenunjang->attributes = $modPendaftaran->attributes;
        $modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modPasienMasukPenunjang->pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id;
//        $instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
//        $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
        $modPasienMasukPenunjang->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPasienMasukPenunjang->tglmasukpenunjang = date("Y-m-d H:i:s");
        $modPenilaian = PenialianKelayakanSpesimenT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $modPasienMasukPenunjang->pasienkirimkeunitlain_id));
        $modPasienMasukPenunjang->pegawai_id = $modPenilaian->dpjtm_id; 
        $modPasienMasukPenunjang->manajer_laboratorium_id  = $modPenilaian->manajerpelayanan_id; 
        $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($modPasienMasukPenunjang->ruangan_id, $modPasienMasukPenunjang->tglmasukpenunjang);
        $modPasienMasukPenunjang->no_urutperiksa = MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
        $modPasienMasukPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
        $modPasienMasukPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modPasienMasukPenunjang->create_loginpemakai_id = Yii::app()->user->id;
        $modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');

        if ($modPasienMasukPenunjang->validate()) {
            $modPasienMasukPenunjang->save();
            $this->pasienpenunjangtersimpan &= true;
        } else {
            $this->pasienpenunjangtersimpan &= false;
        }
        
        return $modPasienMasukPenunjang;
    }
    
    /**
     * simpan MKHasilpemeriksaanlabT
     * @param array $modPasien
     * @param array $modPasienMasukPenunjang
     * @return \MKHasilPemeriksaanLabT
     */
    public function simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjang) {
        $modHasilPemeriksaan = new MKHasilpemeriksaanlabT;
        $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
        $modHasilPemeriksaan->nohasilperiksalab = MyGenerator::noHasilPemeriksaanLK();
        $modHasilPemeriksaan->tglhasilpemeriksaanlab = $modPasienMasukPenunjang->tglmasukpenunjang;
        $modHasilPemeriksaan->hasil_kelompokumur = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
        $modHasilPemeriksaan->hasil_jeniskelamin = $modPasien->jeniskelamin;
        $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_BELUM;
        $modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
        if ($modHasilPemeriksaan->validate()) {
            $modHasilPemeriksaan->save();
        } else {
            $this->hasilpemeriksaantersimpan &= false;
        }
        return $modHasilPemeriksaan;
    }
    
    /**
     * simpan MKDetailhasilpemeriksaanlabT
     * @param array $modHasilPemeriksaan
     * @param array $modTindakan
     * @param array $post
     * @return \MKDetailHasilPemeriksaanLabT
     */
    public function simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $modTindakan, $post) {
        $modDetailHasilPemeriksaans = array();
        $date1 = new DateTime($modTindakan->pendaftaran->tgl_pendaftaran);
        $date2 = new DateTime($modTindakan->pasien->tanggal_lahir);
        $umurhari = $date2->diff($date1)->format("%a");
        $criteria = new CDbCriteria();
        $criteria->addCondition('pemeriksaanlab_id = ' . $post['pemeriksaanlab_id']);
        $criteria->addCondition("'" . $umurhari . "' BETWEEN hariminlab AND harimakslab");
        $criteria->compare('LOWER(nilairujukan_jeniskelamin)', strtolower($modHasilPemeriksaan->pasien->jeniskelamin), true);
        $criteria->order = 'pemeriksaanlabdet_nourut ASC';
        $modPemeriksaanLadDet = PemeriksaanlabdetV::model()->findAll($criteria);

        if (count($modPemeriksaanLadDet) > 0) {
            foreach ($modPemeriksaanLadDet AS $i => $pemeriksaanDet) {
                $modDetailHasilPemeriksaans[$i] = new MKDetailhasilpemeriksaanlabT;
                $modDetailHasilPemeriksaans[$i]->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
                $modDetailHasilPemeriksaans[$i]->pemeriksaanlabdet_id = $pemeriksaanDet->pemeriksaanlabdet_id;
                $modDetailHasilPemeriksaans[$i]->pemeriksaanlab_id = $pemeriksaanDet->pemeriksaanlab_id;
                $modDetailHasilPemeriksaans[$i]->hasilpemeriksaanlab_id = $modHasilPemeriksaan->hasilpemeriksaanlab_id;
                $modDetailHasilPemeriksaans[$i]->nilairujukan = $pemeriksaanDet->nilairujukan_nama;
                $modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_satuan = $pemeriksaanDet->nilairujukan_satuan;
                $modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_metode = $pemeriksaanDet->nilairujukan_metode;
                $modDetailHasilPemeriksaans[$i]->create_time = date("Y-m-d H:i:s");
                $modDetailHasilPemeriksaans[$i]->create_loginpemakai_id = Yii::app()->user->id;
                $modDetailHasilPemeriksaans[$i]->create_ruangan = $modHasilPemeriksaan->create_ruangan;
                if ($modDetailHasilPemeriksaans[$i]->validate()) {
                    $modDetailHasilPemeriksaans[$i]->save();
                } else {
                    $this->hasilpemeriksaantersimpan &= false;
                }
            }
        }
        return $modDetailHasilPemeriksaans;
    }
    
    /**
     * proses simpan MKTindakanPelayananT
     * @param array $modPendaftaran
     * @param array $modPasienMasukPenunjang
     * @param array $post
     * @return \MKTindakanPelayananT
     */
    public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post) {
        $modTindakan = new MKTindakanPelayananT;
        
        if (!empty($post['tindakanpelayanan_id'])){
            $modTindakan = MKTindakanPelayananT::model()->findByPk($post['tindakanpelayanan_id']);
        }

        if (empty($modTindakan->tindakansudahbayar_id)){
            $modTindakan->attributes = $modPendaftaran->attributes;
            $modTindakan->attributes = $modPasienMasukPenunjang->attributes;
            $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modTindakan->attributes = $post;
            $modTindakan->pasienadmisi_id = $modPendaftaran->pasienadmisi_id ?? null;
            $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    //        $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
            $modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
            if (!empty($modTindakan->karcis_id)) {
                $this->karcistersimpan = true;
                if (isset($post['harga_tariftindakan'])) { //jika dari form karcis
                    if (!empty($post['harga_tariftindakan'])) {
                        $modTindakan->tarif_satuan = $post['harga_tariftindakan'];
                    }
                }
                $modTindakan->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
            }

            if (empty($modTindakan->tindakanpelayanan_id)){
                $modTindakan->create_time = date("Y-m-d H:i:s");
                $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
                $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
            }        
            $modTindakan->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
            $modTindakan->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
            $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
            $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
            $modTindakan->cyto_tindakan = 0;
            $modTindakan->tarifcyto_tindakan = 0;
            $modTindakan->discount_tindakan = 0;
            $modTindakan->subsidiasuransi_tindakan = 0;
            $modTindakan->subsidipemerintah_tindakan = 0;
            $modTindakan->subsisidirumahsakit_tindakan = 0;
            $modTindakan->iurbiaya_tindakan = 0;
            $modTindakan->tarif_rsakomodasi = 0;
            $modTindakan->tarif_medis = 0;
            $modTindakan->tarif_paramedis = 0;
            $modTindakan->tarif_bhp = 0;

            if ($modTindakan->validate()) {
                if ($modTindakan->save()) {
                    $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
                }
            } else {
                $this->tindakanpelayanantersimpan &= false;
            }
        }else{
            $this->tindakanpelayanantersimpan &= true;
        }

        return $modTindakan;
    }
    
    /**
     * menentukan tipepaket_id
     * @param array $modPendaftaran
     * @param integer $karcis_id
     * @param integer $idTindakan
     * @return type
     */
    public function tipePaketKarcis($modPendaftaran, $karcis_id, $tindakan_id) {
        $criteria = new CDbCriteria;
        $criteria->with = array('tipepaket');
        if (!empty($tindakan_id)) {
            $criteria->addCondition('daftartindakan_id = ' . $tindakan_id);
        }
        if (!empty($modPendaftaran->carabayar_id)) {
            $criteria->addCondition('tipepaket.carabayar_id = ' . $modPendaftaran->carabayar_id);
        }
        if (!empty($modPendaftaran->penjamin_id)) {
            $criteria->addCondition('tipepaket.penjamin_id = ' . $modPendaftaran->penjamin_id);
        }
        if (!empty($modPendaftaran->kelaspelayanan_id)) {
            $criteria->addCondition('tipepaket.kelaspelayanan_id = ' . $modPendaftaran->kelaspelayanan_id);
        }
        $paket = PaketpelayananM::model()->find($criteria);
        $result = Params::TIPEPAKET_ID_NONPAKET;
        if (isset($paket))
            $result = $paket->tipepaket_id;

        return $result;
    }
    
    /**
     * digunakan untuk cetak joblist
     * @param integer $pasienkirimkeunitlain_id 
     * @param integer $pasienmasukpenunjang_id
     */
    public function actionPrintAntrianFoto($pasienkirimkeunitlain_id,$pasienmasukpenunjang_id=null) {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modKunjungan = MKPasienmasukpenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        $modPenilaian = MKPenialianKelayakanSpesimenT::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$pasienkirimkeunitlain_id));
        $modSpesimen = MKSpesimenT::model()->findAllByAttributes(array('penilaian_kelayakan_spesimen_id'=>$modPenilaian->penilaian_kelayakan_spesimen_id));
        
        $judul_print = 'Pendaftaran Labolatorium Rujukan Rumah Sakit';
        $this->render('printAntrianFoto', array(
            'modKunjungan' => $modKunjungan,
            'modSpesimen'=>$modSpesimen,
            'judul_print'=>$judul_print,
            'format'=>$format,
        ));
    }

}