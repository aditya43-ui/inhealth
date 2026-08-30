<?php

/**
 * Transaksi berita acara pembelian langsung
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class BAPembelianLangsungController extends MyAuthController {
    
    /**
     * Default transaksi pembelian langsung
     * @param integer $suratperjanjiankerja_id
     * @param integer $bapembelianlangsung_id
     */
    public function  actionIndex($suratperjanjiankerja_id, $bapembelianlangsung_id = null){
        $this->layout = '//layouts/iframe';
        $model = new ADBapembelianlangsungT;
        $modelDetail = new ADBapembelianlangsungdetT;
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        $modSPKRincian = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
        
        if(!empty($modSPK->pejabatpembuatkomitmen_id)){
            $modPegawai = PegawaiM::model()->findByPk($modSPK->pejabatpembuatkomitmen_id);
            $model = ADBapembelianlangsungT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            if(empty($model->bapembelianlangsung_id)){
                $model = new ADBapembelianlangsungT;
                $model->bapembelianlangsung_nomor = "-- Otomatis --";
                $modPersiapan = PersiapanpengadaanT::model()->findByPk($modSPK->persiapanpengadaan_id);
                $modRencana = RencanaumumpengadaanT::model()->findByPk($modPersiapan->rencanaumumpengadaan_id);                    
                $modInfopengadaan = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id'=>$modPersiapan->persiapanpengadaan_id)); 
                $model->bapembelianlangsung_tanggal = date('d M Y H:i:s');
                $model->pihakkesatu_jabatan = "Pejabat Pembuat Komitmen RSUD Dr. Soetomo";
//                $model->nomor_beritaacara = '-- Otomatis --'; // Generator nomor BA di-nonaktifkan di RSST-10126
                $model->pihakkedua_jabatan = "Pejabat Pengadaan RSUD Dr. Soetomo";
                $model->pegpihakkesatu_id = $modPegawai->pegawai_id;
                $model->pegpihakkesatu_nama = $modPegawai->nama_pegawai;
                $model->pegpihakkesatu_nip = $modPegawai->nomorindukpegawai;
                $model->pegpihakkesatu_alamat = $modPegawai->alamat_pegawai;
                $modPegawai2 = PegawaiM::model()->findByPk($modInfopengadaan->pegpengadaan_id);
                $model->pegpihakkedua_id = $modPegawai2->pegawai_id;
                $model->pegpihakkedua_nama = $modPegawai2->nama_pegawai;
                $model->pegpihakkedua_nip = $modPegawai2->nomorindukpegawai;
                $model->pegpihakkedua_alamat = $modPegawai2->alamat_pegawai;
            }else{
                $modPersiapan = PersiapanpengadaanT::model()->findByPk($modSPK->persiapanpengadaan_id);
                $modRencana = RencanaumumpengadaanT::model()->findByPk($modPersiapan->rencanaumumpengadaan_id);
                $modInfopengadaan = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id'=>$modPersiapan->persiapanpengadaan_id)); 
                $modPegawai1 = PegawaiM::model()->findByPk($model->pegpihakkesatu_id);
                $modPegawai2 = PegawaiM::model()->findByPk($modInfopengadaan->pegpengadaan_id);
                $model->bapembelianlangsung_tanggal = MyFormatter::formatDateTimeForUser($model->bapembelianlangsung_tanggal); 
                $model->pegpihakkesatu_id = $modPegawai1->pegawai_id;
                $model->pegpihakkesatu_nama = $modPegawai1->nama_pegawai;
                $model->pegpihakkesatu_nip = $modPegawai1->nomorindukpegawai;
                $model->pegpihakkesatu_alamat = $modPegawai1->alamat_pegawai;
                $model->pegpihakkedua_id = $modPegawai2->pegawai_id;
                $model->pegpihakkedua_nama = $modPegawai2->nama_pegawai;
                $model->pegpihakkedua_nip = $modPegawai2->nomorindukpegawai;
                $model->pegpihakkedua_alamat = $modPegawai2->alamat_pegawai;
                $model->pihakkesatu_jabatan = "Pejabat Pembuat Komitmen RSUD Dr. Soetomo";
                $model->pihakkedua_jabatan = "Pejabat Pengadaan RSUD Dr. Soetomo";
            }
        }
        
        if(!empty($bapembelianlangsung_id)){
            $model = ADBapembelianlangsungT::model()->findByPk($bapembelianlangsung_id);
            $model->bapembelianlangsung_tanggal = MyFormatter::formatDateTimeForUser($model->bapembelianlangsung_tanggal);
            $model->pegpihakkesatu_nama = $model->pegpihakkesatu->nama_pegawai;
            $model->pegpihakkesatu_nip = $model->pegpihakkesatu->nomorindukpegawai;
            $model->pegpihakkesatu_alamat = $model->pegpihakkesatu->alamat_pegawai;
            $model->pegpihakkedua_nama = $model->pegpihakkedua->nama_pegawai;
            $model->pegpihakkedua_nip = $model->pegpihakkedua->nomorindukpegawai;
            $model->pegpihakkedua_alamat = $model->pegpihakkedua->alamat_pegawai;
        }
        
        if(isset($_POST['ADBapembelianlangsungT'])){
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                $modKPA = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $modSPK->kuasapenggunaanggaran_id, 'pejabatpengadaan_aktif' => true, 'jabatan_pengadaan' => 'KPA'));
                $modPPK = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $modSPK->pejabatpembuatkomitmen_id, 'pejabatpengadaan_aktif' => true, 'jabatan_pengadaan' => 'PPK'));
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
                
                $model->attributes = $_POST['ADBapembelianlangsungT'];
                $model->suratperjanjiankerja_id = $suratperjanjiankerja_id;
                $model->bapembelianlangsung_tanggal = MyFormatter::formatDateTimeForDb($model->bapembelianlangsung_tanggal);
                $tanggal = MyFormatter::formatDateTimeForDb(date("d m Y"));
                $tanggalbeli = MyFormatter::formatDateTimeForDb(date("d m Y", strtotime($model->bapembelianlangsung_tanggal)));
                if ($tanggalbeli < $tanggal) {
                    $model->isantidatir = true;
                }
                if(empty($model->bapembelianlangsung_id)){
                    $model->bapembelianlangsung_nomor = MyGenerator::noBAPembelianLangsung();
                    // Generator nomor BA di-nonaktifkan di RSST-10126
//                    $nomorsurat = MyGenerator::nomorBAPembelianLangsung($model->bapembelianlangsung_tanggal, $modKPA->kode_dokumen, $modPPK->kode_dokumen); 
//                    $model->nomor_beritaacara = $nomorsurat['nosurat'];
//                    $model->nomor_urut = $nomorsurat['nourut'];
                    $model->nomor_urut = '000';
                    $model->jumlah_pajak = $_POST['SuratperjanjiankerjaT']['jumlah_pajak'];
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date ('Y-m-d H:i:s');
                }else{
                    $model->update_time = date ('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                }
                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');
                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if (!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->bapembelianlangsung_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathberitaAcaraDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathberitaAcaraDirectory())){
                        mkdir(Params::pathberitaAcaraDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = ADBapembelianlangsungT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }
                $ok = $ok && $model->save();
                if($ok){
                    ADBapembelianlangsungdetT::model()->deleteAllByAttributes(array('bapembelianlangsung_id' => $model->bapembelianlangsung_id));
                }
                
                if(isset($_POST['ADBapembelianlangsungdetT']) && $ok){
                    foreach ($_POST['ADBapembelianlangsungdetT'] as $key => $value) {
                        $modelDetail = new ADBapembelianlangsungdetT;
                        $modelDetail->attributes = $value;
                        $modelDetail->bapembelianlangsung_id = $model->bapembelianlangsung_id;
                        $ok = $ok && $modelDetail->save();
                    }
                }
                
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'bapembelianlangsung_id' => $model->bapembelianlangsung_id ,'sukses' => 1));
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
            'modelDetail' => $modelDetail,
            'modSPK' => $modSPK,
            'modSPKRincian' => $modSPKRincian,
        ));
    }
    
    /**
     * Autocomplete pegawai
     */
    public function actionGetPegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }

            if (isset($_GET['pegawai_id'])) {
                if (!empty($_GET['pegawai_id'])) {
                    $criteria->addCondition("pegawai_id = " . $_GET['pegawai_id']);
                }
            }

            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition(" pegawai_aktif = TRUE ");
            $criteria->order = 'nama_pegawai ASC';
            $criteria->limit = 10;
            $models = PegawaiV::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->nama_pegawai;
                $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
                if (!empty($model->jabatan_id)) {
                    $returnVal[$i]['jabatan_nama'] = JabatanM::model()->findByPk($model->jabatan_id)->jabatan_nama;
                } else {
                    $returnVal[$i]['jabatan_nama'] = '';
                }
                $returnVal[$i]['nosk'] = $model->getNoKeputusan();
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Cetak transaksi pembelian langsung
     * @param type $id
     */
    public function actionPrint($id){
        $this->layout = '//layouts/printWindows';
        $model = BapembelianlangsungT::model()->findByPk($id);
        if(!empty($model->bapembelianlangsung_id)){
            $isiPesan = "-";
            $criteria = new CDbCriteria;
            $criteria->addCondition("konfigtemplatesurat_aktif=true");
            $criteria->addCondition("konfigtemplatesurat_nama LIKE 'BA Pembelian Langsung'");
            $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

            foreach ($modTemplate as $i => $templateTugas) {
                $isiPesan = $templateTugas->konfigtemplatesurat_isi;
                $isiPesan = "${isiPesan}";
                $attributes = $model->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{ba_hari}}", MyFormatter::getDayName($model->bapembelianlangsung_tanggal), $isiPesan);
                    $isiPesan = str_replace("{{ba_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->bapembelianlangsung_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_bulan_terbilang}}", ucwords(MyFormatter::getMonthId(date('n', strtotime($model->bapembelianlangsung_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->bapembelianlangsung_tanggal)))), $isiPesan);
                }
                $modPegawai = PegawaiM::model()->findByPk($model->pegpihakkesatu_id);
                $attributes = $modPegawai->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{pegpihakkesatu_nama}}", $modPegawai->namaLengkap, $isiPesan);
                    $isiPesan = str_replace("{{pegpihakkesatu_nip}}", $modPegawai->nomorindukpegawai, $isiPesan);
                    $isiPesan = str_replace("{{pegpihakkesatu_alamat}}", $modPegawai->alamat_pegawai, $isiPesan);
                } 
                $modPegawai2 = PegawaiM::model()->findByPk($model->pegpihakkedua_id);
                $attributes = $modPegawai2->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{pegpihakkedua_nama}}", $modPegawai2->namaLengkap, $isiPesan);
                    $isiPesan = str_replace("{{pegpihakkedua_nip}}", $modPegawai2->nomorindukpegawai, $isiPesan);
                    $isiPesan = str_replace("{{pegpihakkedua_alamat}}", $modPegawai2->alamat_pegawai, $isiPesan);
                } 
                                
                $modSurat = SuratperjanjiankerjaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                $attributes = $modSurat->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{nomor_dokumen_spk}}", $modSurat->nomor_dokumen, $isiPesan);
                    $isiPesan = str_replace("{{tglsuratperjanjian}}", MyFormatter::formatDateTimeForUser(date('d M Y', strtotime($modSurat->tglsuratperjanjian))), $isiPesan);
                } 
            }
            $model->dasar=$isiPesan;
        }
        $this->render('print', array('model' => $model, 'modSurat' => $modSurat));
    }
    
    /**
     * Fungsi unduh dokumen pendukung
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = BapembelianlangsungT::model()->findByPk($id);
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