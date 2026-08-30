<?php
/**
 * Controller untuk halaman Serah Terima pada Berita Acara
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class BASerahTerimaController extends MyAuthController{
    
    /**
     * Halaman index untuk transaksi berita acara serah terima
     * @param type $suratperjanjiankerja_id
     * @param type $baserahterima_id
     */
    public function actionIndex($suratperjanjiankerja_id, $baserahterima_id = null){
        $this->layout = '//layouts/iframe';
        $modSurat = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        $modDetail = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $modSurat->suratperjanjiankerja_id));
        $modBADetail = new BaserahterimadetT();
        $model = new BaserahterimaT;
        
        if($modSurat->istermin == true){
            $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $cekpemeriksaanpekerjaan = BaserahterimaT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $jumlahpemeriksaan = count($cekpemeriksaanpekerjaan) + 1;
        }
        
        if (empty($baserahterima_id)) {
            $model = new BaserahterimaT;
            $model->pegpihakkesatu_id = $modSurat->pejabatpembuatkomitmen_id;
            $model->pegpihakkesatu_nama = $modSurat->pejabatpembuatkomitmen->namaLengkap;
            $model->pegpihakkesatu_nip = $modSurat->pejabatpembuatkomitmen->nomorindukpegawai;
            $model->pegpihakkesatu_alamat = $modSurat->pejabatpembuatkomitmen->alamat_pegawai;
            $model->jabatan_pihakkesatu = "Pejabat Pembuat Komitmen RSUD Dr. Soetomo";
            $model->baserahterima_tanggal = date('d M Y H:i:s');
            $model->baserahterima_nomor = '-- Otomatis --';
//            $model->nomor_beritaacara = '-- Otomatis --';  // Generator nomor BA di-nonaktifkan di RSST-10126
            
            if($modSurat->istermin == true){
                $model->termin_termintotal = !empty($cekTermin) ? count($cekTermin) : 0;
                $model->termin_terminjumlah = !empty($cekpemeriksaanpekerjaan) ? count($cekpemeriksaanpekerjaan) + 1 : 1;
                $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'urutan' => $jumlahpemeriksaan));
                if (!empty($cekTermin)) {
                    $model->terminke = $cekTermin->terminke;
                    $model->termin_persen = $cekTermin->jumlah_persen;
                }
            }else{
                $model->termin_termintotal = 1;
                $model->termin_terminjumlah = 1;
                $model->terminke = 'I';
                $model->termin_persen = 100;
            }
        } else {
            $model = BaserahterimaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'baserahterima_id' => $baserahterima_id));
            $model->pegpihakkesatu_id = $modSurat->pejabatpembuatkomitmen_id;
            $model->pegpihakkesatu_nama = $modSurat->pejabatpembuatkomitmen->namaLengkap;
            $model->pegpihakkesatu_nip = $modSurat->pejabatpembuatkomitmen->nomorindukpegawai;
            $model->pegpihakkesatu_alamat = $modSurat->pejabatpembuatkomitmen->alamat_pegawai;
            $model->baserahterima_tanggal = !empty($model->baserahterima_tanggal) ? date('d M Y H:i:s', strtotime($model->baserahterima_tanggal)) : '';
            
            $model->termin_termintotal = !empty($cekTermin) ? count($cekTermin) : 0;
            if($modSurat->istermin == true){
                if ($model->terminke == 'I') {
                    $model->termin_terminjumlah = 1;
                } else if ($model->terminke == 'II') {
                    $model->termin_terminjumlah = 2;
                } else if ($model->terminke == 'III') {
                    $model->termin_terminjumlah = 3;
                }
            }else{
                $model->termin_termintotal = 1;
                $model->termin_terminjumlah = 1;
            }
        }
                
        $model->supplier_id = $modSurat->supplier_id;
        $model->supplier_nama = $modSurat->supplier->supplier_nama;
        $model->direktur = $modSurat->supplier->direktursupplier;
        $model->alamat_penyedia = $modSurat->supplier->supplier_alamat;
        if (isset($_POST['BaserahterimaT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                    $model = new BaserahterimaT();
                    $model->attributes = $_POST['BaserahterimaT'];
                    $model->baserahterima_nomor = MyGenerator::noBASerahTerima();
                    $model->baserahterima_tanggal = MyFormatter::formatDateTimeForDb($model->baserahterima_tanggal);
                    $model->suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
                    $modTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'], 'terminke' => $model->terminke));
                    $model->termin_persen = $modTermin->jumlah_persen; 
                    $model->total_dibulatkan = $modSurat->total_pembulatan; 
                    $model->total_pembayaran = $modTermin->jumlah_harga;
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date ('Y-m-d H:i:s');
                    $modKPA = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $modSurat->kuasapenggunaanggaran_id, 'pejabatpengadaan_aktif' => true, 'jabatan_pengadaan' => 'KPA'));
                    $modPPK = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $modSurat->pejabatpembuatkomitmen_id, 'pejabatpengadaan_aktif' => true, 'jabatan_pengadaan' => 'PPK'));
                    if (!empty($modPPK)) {
                        $modPPK->kode_dokumen = !empty($modPPK->kode_dokumen) ? $modPPK->kode_dokumen : null;
                    } else {
                        $modPPK->kode_dokumen = null;
                    }

                    if (!empty($modKPA)) {
                        $modKPA->kode_dokumen = !empty($modKPA->kode_dokumen) ? $modKPA->kode_dokumen : null;
                    } else {
                        $modKPA->kode_dokumen = null;
                    } 
                     // Generator nomor BA di-nonaktifkan di RSST-10126
//                    $nomorsurat = MyGenerator::nomorBASerahTerima($model->baserahterima_tanggal, $modKPA->kode_dokumen, $modPPK->kode_dokumen); 
//                    $model->nomor_beritaacara = $nomorsurat['nosurat'];
//                    $model->nomor_urut = $nomorsurat['nourut']; 
                    
                    $model->nomor_urut = '000';
                    $tanggal = MyFormatter::formatDateTimeForDb(date("d m Y"));
                    $tanggalbeli = MyFormatter::formatDateTimeForDb(date("d m Y", strtotime($model->baserahterima_tanggal)));
                    if ($tanggalbeli < $tanggal) {
                        $model->isantidatir = true;
                    }
                    $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');
                    if (!empty($model->dokumen_pendukung)) {
                        $file = $model->dokumen_pendukung;
                        if (!empty($model->dokumen_pendukung)) {
                            $fullDocName = $model->baserahterima_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                            $fullDocSource = Params::pathberitaAcaraDirectory() . $fullDocName;
                            $model->dokumen_pendukung = $fullDocName;
                        }
                        
                        if (!file_exists(Params::pathberitaAcaraDirectory())){
                            mkdir(Params::pathberitaAcaraDirectory(), 0775, true);
                        }
                        
                        $file->saveAs($fullDocSource);
                    }else{
                        $cekmodel = BaserahterimaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'baserahterima_id' => $baserahterima_id));
                        $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                    }
                    $ok = $ok && $model->save();
                    $this->saveSerahTerimaDet($model->baserahterima_id, $_POST['BaserahterimadetT']);
                    if ($ok) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                        $this->redirect(array('index', 'suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'baserahterima_id' => $model->baserahterima_id, 'sukses' => 1));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                    }
                } catch (Exception $ex) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
                }
        }
        $this->render('index', array(
            'model' => $model, 
            'modBADetail' => $modBADetail,
            'modDetail' => $modDetail, 
            'modSurat' => $modSurat));
    }
    
    /**
     * Save baserahterima_det
     * @param type $baserahterima_id
     * @param type $post
     */
    public function saveSerahTerimaDet($baserahterima_id, $post){
        $ok = true;
        foreach ($post as $i => $mod) {
            $modDetail = new BaserahterimadetT;
            $modDetail->attributes = $mod;
            $modDetail->baserahterima_id = $baserahterima_id; 
            $ok = $ok && $modDetail->save();
        }
    }
    
    /**
     * Ubah BA Serah Terima 
     * @param type $suratperjanjiankerja_id
     * @param type $baserahterima_id
     */
    public function actionUbah($suratperjanjiankerja_id, $baserahterima_id) {
        $this->layout = '//layouts/iframe';
        $model = BaserahterimaT::model()->findByPk($baserahterima_id);
        $model->baserahterima_tanggal = MyFormatter::formatDateTimeForUser($model->baserahterima_tanggal);
        $modSurat = SuratperjanjiankerjaT::model()->findByPk($_GET['suratperjanjiankerja_id']);
        $modDetail = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $modSurat->suratperjanjiankerja_id));
        $modBADetail = new BaserahterimadetT(); 
        $model->pegpihakkesatu_id = $modSurat->pejabatpembuatkomitmen_id;
        $model->pegpihakkesatu_nama = $modSurat->pejabatpembuatkomitmen->namaLengkap;
        $model->pegpihakkesatu_nip = $modSurat->pejabatpembuatkomitmen->nomorindukpegawai;
        $model->pegpihakkesatu_alamat = $modSurat->pejabatpembuatkomitmen->alamat_pegawai;
        $model->supplier_id = $modSurat->supplier_id;
        $model->supplier_nama = $modSurat->supplier->supplier_nama;
        $model->direktur = $modSurat->supplier->direktursupplier;
        $model->alamat_penyedia = $modSurat->supplier->supplier_alamat;
        
        $modTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
        $hitungTermin = count($modTermin);
        $mTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'], 'terminke' => $model->terminke));
        $model->termin_terminjumlah = $mTermin->urutan;
        $model->termin_termintotal = $hitungTermin;
        $model->termin_persen = $mTermin->jumlah_persen;
        
        if (isset($_POST['BaserahterimaT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                $model = BaserahterimaT::model()->findByPk($_GET['baserahterima_id']);
                $model->attributes = $_POST['BaserahterimaT'];
                $model->baserahterima_tanggal = MyFormatter::formatDateTimeForDb($model->baserahterima_tanggal);
                $model->suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
                $modTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'], 'terminke' => $model->terminke));
                $model->termin_persen = $modTermin->jumlah_persen; 
                $model->total_dibulatkan = $modSurat->total_pembulatan; 
                $model->total_pembayaran = $modTermin->jumlah_harga;
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->update_time = date('Y-m-d H:i:s');
                    
                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');

                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if (!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->baserahterima_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathberitaAcaraDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathberitaAcaraDirectory())){
                        mkdir(Params::pathberitaAcaraDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                        $cekmodel = BaserahterimaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'baserahterima_id' => $baserahterima_id));
                        $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                    }
                $ok = $ok && $model->save();
                
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'baserahterima_id' => $model->baserahterima_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        
        $this->render('update', array(
            'model' => $model, 
            'modBADetail' => $modBADetail,
            'modDetail' => $modDetail, 
            'modSurat' => $modSurat));
    }


    /**
     * Cetak transaksi serah terima
     * @param type $id
     */
    public function actionPrint($id){
        $this->layout = '//layouts/printWindows';
        $model = BaserahterimaT::model()->findByPk($id);
        if(!empty($model->baserahterima_id)){
            $isiPesan = "-";
            $criteria = new CDbCriteria;
            $criteria->addCondition("konfigtemplatesurat_aktif=true");
            $criteria->addCondition("konfigtemplatesurat_nama LIKE 'BA Serah Terima Hasil Pekerjaan'");
            $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

            foreach ($modTemplate as $i => $templateTugas) {
                $isiPesan = $templateTugas->konfigtemplatesurat_isi;
                $isiPesan = "${isiPesan}";
                $attributes = $model->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{ba_hari}}", MyFormatter::getDayName($model->baserahterima_tanggal), $isiPesan);
                    $isiPesan = str_replace("{{ba_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->baserahterima_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_bulan_terbilang}}", ucwords(MyFormatter::getMonthId(date('m', strtotime($model->baserahterima_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->baserahterima_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_tanggal}}", date('d ', strtotime($model->baserahterima_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->baserahterima_tanggal))) . date(' Y', strtotime($model->baserahterima_tanggal)), $isiPesan);
                }
                $modPegawai = PegawaiM::model()->findByPk($model->pegpihakkesatu_id);
                $attributes = $modPegawai->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{nama_pegawai}}", $modPegawai->namaLengkap, $isiPesan);
                } 
                
                $modSupplier = SupplierM::model()->findByPk($model->supplier_id);
                $attributes = $modSupplier->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                
                $modSurat = SuratperjanjiankerjaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                $attributes = $modSurat->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{nomor_dokumen_spk}}", $modSurat->nomor_dokumen, $isiPesan);
                    
                    $isiPesan = str_replace("{{tglsuratperjanjian}}", date('d ', strtotime($modSurat->tglsuratperjanjian)) . MyFormatter::getMonthId(date('m', strtotime($modSurat->tglsuratperjanjian))) . date(' Y', strtotime($modSurat->tglsuratperjanjian)), $isiPesan);
                } 
            }
            $model->dasar=$isiPesan;
        }
        $this->render('print', array('model' => $model, 'modSurat' => $modSurat));
    }
    
    /**
     * Cetak serah terima termin
     * @param type $id
     */
    public function actionPrintTermin($id){
        $this->layout = '//layouts/printWindows';
        
        $model = BaserahterimaT::model()->findByPk($id);
        $modTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' =>$model->suratperjanjiankerja_id));
       
        if(!empty($model->baserahterima_id)){
            $isiPesan = "-";
            $criteria = new CDbCriteria;
            $criteria->addCondition("konfigtemplatesurat_aktif=true");
            $criteria->addCondition("konfigtemplatesurat_id= 38");
            $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);
            
            foreach ($modTemplate as $i => $templateTugas) {
                $isiPesan = $templateTugas->konfigtemplatesurat_isi;
                $isiPesan = "${isiPesan}";
                $attributes = $model->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{ba_hari}}", MyFormatter::getDayName($model->baserahterima_tanggal), $isiPesan);
                    $isiPesan = str_replace("{{ba_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->baserahterima_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_bulan_terbilang}}", ucwords(MyFormatter::getMonthId(date('m', strtotime($model->baserahterima_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->baserahterima_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_tanggal}}", date('d ', strtotime($model->baserahterima_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->baserahterima_tanggal))) . date(' Y', strtotime($model->baserahterima_tanggal)), $isiPesan);
                   
                    
                }
                $modPegawai = PegawaiM::model()->findByPk($model->pegpihakkesatu_id);
                $attributes = $modPegawai->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{nama_pegawai}}", $modPegawai->namaLengkap, $isiPesan);
                } 
                
                $modSupplier = SupplierM::model()->findByPk($model->supplier_id);
                $attributes = $modSupplier->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                
                $modSurat = SuratperjanjiankerjaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                $attributes = $modSurat->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{nomor_dokumen_spk}}", $modSurat->nomor_dokumen, $isiPesan);
                    $isiPesan = str_replace("{{tglsuratperjanjian}}", date('d ', strtotime($modSurat->tglsuratperjanjian)) . MyFormatter::getMonthId(date('m', strtotime($modSurat->tglsuratperjanjian))) . date(' Y', strtotime($modSurat->tglsuratperjanjian)), $isiPesan);
                    
                } 
            }
            $model->dasar=$isiPesan;
        }
        $this->render('print_termin', array('model' => $model, 'modSurat' => $modSurat));
    }
    
    
    
    /**
     * Menampilkan detail dari serah terima
     * @param integer type $suratperjanjiankerja_id  
     * @param integer type $baserahterima_id
     */
    public function actionDetail($suratperjanjiankerja_id, $baserahterima_id){
       
        $this->layout = '//layouts/iframe';
        $model = BaserahterimaT::model()->findByPk($baserahterima_id);
        $model->baserahterima_tanggal = MyFormatter::formatDateTimeForUser($model->baserahterima_tanggal);
        $modSurat = SuratperjanjiankerjaT::model()->findByPk($_GET['suratperjanjiankerja_id']);
        $modDetail = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $modSurat->suratperjanjiankerja_id));
        $modBADetail = new BaserahterimadetT(); 
        $model->pegpihakkesatu_id = $modSurat->pejabatpembuatkomitmen_id;
        $model->pegpihakkesatu_nama = $modSurat->pejabatpembuatkomitmen->namaLengkap;
        $model->pegpihakkesatu_nip = $modSurat->pejabatpembuatkomitmen->nomorindukpegawai;
        $model->pegpihakkesatu_alamat = $modSurat->pejabatpembuatkomitmen->alamat_pegawai;
        $model->supplier_id = $modSurat->supplier_id;
        $model->supplier_nama = $modSurat->supplier->supplier_nama;
        $model->direktur = $modSurat->supplier->direktursupplier;
        $model->alamat_penyedia = $modSurat->supplier->supplier_alamat;
        
        $modTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'terminke' => $model->terminke));
        $mTerminTot = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
        $mTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'terminke' => $model->terminke));
        $hitungTermin = count($mTerminTot);
        $model->termin_terminjumlah = !empty($mTermin->urutan)?$mTermin->urutan:0;
        $model->termin_termintotal = $hitungTermin;
        $model->termin_persen = !empty($mTermin->jumlah_persen)?$mTermin->jumlah_persen:0;
        
         $this->render('detail/detail_form', array(
            'model' => $model, 
            'modBADetail' => $modBADetail,
            'modDetail' => $modDetail, 
            'modSurat' => $modSurat));
    }
    
    /**
     * Fungsi unduh dokumen pendukung
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = BaserahterimaT::model()->findByPk($id);
        $path = Params::pathberitaAcaraDirectory().$filename->dokumen_pendukung;
        if (!empty($filename->dokumen_pendukung)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->dokumen_pendukung, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));   
        }
    }
    
}