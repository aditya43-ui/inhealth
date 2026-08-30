<?php

/**
 * Transaksi Berita Acara - Hasil Pemeriksaan
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class BAHasilPemeriksaanController extends MyAuthController {

    /**
     * Default menu transaksi Berita Acara - Hasil Pemeriksaan
     * @param integer $suratperjanjiankerja_id
     * @param integer $bahasilpemeriksaanpekerjaan_id
     */
    public function actionIndex($suratperjanjiankerja_id, $bahasilpemeriksaanpekerjaan_id = null) {
        $this->layout = '//layouts/iframe';
        $model = new ADBahasilpemeriksaanpekerjaanT;
        $modelDetail = array();
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        $modPeriksaKerja = new ADBapemeriksaanpekerjaanT(); 
        $model->bahasilpemeriksaanpekerjaan_nomor = "-- Otomatis --";
//        $model->nomor_beritaacara = "-- Otomatis --";  // Generator nomor BA di-nonaktifkan di RSST-10126
        $model->bahasilpemeriksaanpekerjaan_tanggal = date('d M Y H:i:s');
        $this->setPihakKessatu($model, $modSPK->pejabatpembuatkomitmen_id);
        $model->jabatan_pihakkesatu = "Pejabat Penandatangan Kontrak RSUD Dr. Soetomo";
        $model->supplier_id = $modSPK->supplier_id;

        if (isset($_POST['ADBahasilpemeriksaanpekerjaanT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $model->attributes = $_POST['ADBahasilpemeriksaanpekerjaanT'];
                $model->bahasilpemeriksaanpekerjaan_nomor = MyGenerator::noBAHasilPemeriksaanPekerjaan();
                $model->suratperjanjiankerja_id = $suratperjanjiankerja_id;
                $model->bahasilpemeriksaanpekerjaan_tanggal = MyFormatter::formatDateTimeForDb($model->bahasilpemeriksaanpekerjaan_tanggal);
                $model->total_dibulatkan = $modSPK->total_pembulatan;
                $model->jumlah_harga = $modSPK->jumlah_harga;
                $model->jumlah_pajak = $modSPK->jumlah_pajak;
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->create_time = date('Y-m-d H:i:s');
                
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
                
                $tanggal = MyFormatter::formatDateTimeForDb(date("d m Y"));
                $tanggalbeli = MyFormatter::formatDateTimeForDb(date("d m Y", strtotime($model->bahasilpemeriksaanpekerjaan_tanggal)));
                if ($tanggalbeli < $tanggal) {
                    $model->isantidatir = true;
                }
                 // Generator nomor BA di-nonaktifkan di RSST-10126
//                $nomorsurat = MyGenerator::nomorBAPemeriksaanPekerjaan($model->bahasilpemeriksaanpekerjaan_tanggal, $modKPA->kode_dokumen, $modPPK->kode_dokumen); 
//                $model->nomor_beritaacara = $nomorsurat['nosurat'];
//                $model->nomor_urut = $nomorsurat['nourut']; 
                $model->nomor_urut = '000';                        
                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');
                
                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if (!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->bahasilpemeriksaanpekerjaan_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathberitaAcaraDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathberitaAcaraDirectory())){
                        mkdir(Params::pathberitaAcaraDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = ADBahasilpemeriksaanpekerjaanT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }
                
                $ok = $ok && $model->save();

                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'bahasilpemeriksaanpekerjaan_id' => $model->bahasilpemeriksaanpekerjaan_id, 'sukses' => 1));
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
            'modSPK' => $modSPK,
            'modPeriksaKerja' => $modPeriksaKerja,
            'modelDetail' => $modelDetail,
        ));
    }

    /**
     * Ubah hasil pemeriksaan
     * @param type $suratperjanjiankerja_id
     * @param type $bahasilpemeriksaanpekerjaan_id
     */
    public function actionUbah($suratperjanjiankerja_id, $bahasilpemeriksaanpekerjaan_id) {
        $this->layout = '//layouts/iframe';
        $model = BahasilpemeriksaanpekerjaanT::model()->findByPk($bahasilpemeriksaanpekerjaan_id);
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        $modPeriksaKerja = ADBapemeriksaanpekerjaanT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id), array('order' => 'bapemeriksaanpekerjaan_id DESC'));
        $modTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
        $mTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'], 'terminke' => $model->terminke));
        $hitungTermin = count($modTermin);
        $model->termin_terminjumlah = $mTermin->urutan;
        $model->termin_termintotal = $hitungTermin;
        $model->supplier_id = $modSPK->supplier_id;
        $this->setPihakKessatu($model, $model->pegpihakkesatu_id);
        $model->nomor_beritaacara_pemeriksaanpekerjaan = $model->bapemeriksaanpekerjaan->bapemeriksaanpekerjaan_nomor;
        $modelDetail = ADBapemeriksaanpekerjaandetT::model()->findAllByAttributes(array('bapemeriksaanpekerjaan_id' => $modPeriksaKerja->bapemeriksaanpekerjaan_id));
        if (isset($_POST['BahasilpemeriksaanpekerjaanT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                $model = BahasilpemeriksaanpekerjaanT::model()->findByPk($bahasilpemeriksaanpekerjaan_id);
                $model->attributes = $_POST['BahasilpemeriksaanpekerjaanT'];
                $model->bahasilpemeriksaanpekerjaan_tanggal = MyFormatter::formatDateTimeForDb($model->bahasilpemeriksaanpekerjaan_tanggal);
                $model->suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->update_time = date('Y-m-d H:i:s');
                
                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');
                
                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if (!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->bahasilpemeriksaanpekerjaan_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathberitaAcaraDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathberitaAcaraDirectory())){
                        mkdir(Params::pathberitaAcaraDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = ADBahasilpemeriksaanpekerjaanT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }
                
                $ok = $ok && $model->save();
                
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'], 'sukses' => 1));
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
            'modSPK' => $modSPK,
            'modPeriksaKerja' => $modPeriksaKerja,
            'modelDetail' => $modelDetail,
        ));
    }
    
    /**
     * Load dokumen BA 
     */
    public function actionGetDokumen(){
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            $id = $_POST['id'];
            $tr = "";
            $model = BapemeriksaanpekerjaanT::model()->findByPk($id);
            $jumlahtermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
            $modTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'terminke' => $model->terminke)); 
            $modSPK = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
            $data = $model->attributes; 
            $data['jumlah_harga'] = $model->jumlah_harga;
            $data['total_pembayaran'] = $model->total_pembayaran;
            $data['total_dibulatkan'] = $model->total_dibulatkan;
            $data['jumlah_pajak'] = $model->jumlah_pajak;
//            $data['termin_persen'] = $modTermin->jumlah_persen;
            if($model->terminke == 'I'){
                $data['termin'] = 1;  
            }else if($model->terminke == 'II'){
                $data['termin'] = 2;  
            }else if($model->terminke == 'III'){
                $data['termin'] = 3;  
            }
            $data['supplier_nama'] = $model->supplier->supplier_nama;
            $data['supplier_id'] = $model->supplier->supplier_id;
            $data['direktur'] = !empty($model->supplier->direktursupplier) ? $model->supplier->direktursupplier : "-";
            $data['alamat'] = !empty($model->supplier->supplier_alamat) ? $model->supplier->supplier_alamat : "-";
            $data['jumlahtermin'] = count($jumlahtermin);
            if ($modSPK->istermin == true) {
                $tr .= "<tr class='termin'>
                        <td colspan='7' style='text-align: right; font-weight: bold; color: #a6a7aa'>" . "Termin ".$model->terminke." (". $modTermin->jumlah_persen ." %) ". "</td>
                        <td style='text-align:right;font-weight: bold; color: #a6a7aa'> Rp. " . number_format((float)$modTermin->jumlah_harga,2,",",".") . "</td>
                        <td style='text-align:right;font-weight: bold; color: #a6a7aa'> </td>
                        </tr>
                        ";
            }
            $data['tr'] = $tr;
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Set pegawai pihak kesatu
     * @param array $model
     * @param integer $pegawai_id
     * @return \ADBahasilpemeriksaanpekerjaanT
     */
    public function setPihakKessatu($model, $pegawai_id) {
        $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
        $model->pegpihakkesatu_id = $modPegawai->pegawai_id;
        $model->pegpihakkesatu_nama = $modPegawai->nama_pegawai;
        $model->pegpihakkesatu_nip = $modPegawai->nomorindukpegawai;
        $model->pegpihakkesatu_alamat = $modPegawai->alamat_pegawai;

        return $model;
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
     * Autocomplete Pemeriksaan Pekerjaan
     */
    public function actionGetPemeriksaanPekerjaan() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }

            $criteria->compare('LOWER(bapemeriksaanpekerjaan_nomor)', strtolower($_GET['term']), true);
            if (isset($_GET['suratperjanjiankerja_id']) && !empty($_GET['suratperjanjiankerja_id'])) {
                $criteria->addCondition('suratperjanjiankerja_id = ' . $_GET['suratperjanjiankerja_id']);
            }
            $criteria->order = 'bapemeriksaanpekerjaan_tanggal ASC';
            $criteria->limit = 10;
            $models = ADBapemeriksaanpekerjaanT::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->bapemeriksaanpekerjaan_nomor . " - " . $model->nomor_beritaacara;
                $returnVal[$i]['value'] = $model->bapemeriksaanpekerjaan_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Get lampiran
     */
    public function actionGetLampiran() {
        if (Yii::app()->request->isAjaxRequest) {
            $bapemeriksaanpekerjaan_id = $_POST['bapemeriksaanpekerjaan_id'];
            $modelDetail = ADBapemeriksaanpekerjaandetT::model()->findAllByAttributes(array('bapemeriksaanpekerjaan_id' => $bapemeriksaanpekerjaan_id));
            $tr = "";
            if (count($modelDetail)) {

                foreach ($modelDetail as $key => $value) {
                    $hasilPemeriksaan = ($value->hasil_pemeriksaan) ? "<i class=\"fa fa-check-square-o\"></i>" : "<i class=\"fa fa-square-o\"></i>";
                    $tr .= "
                        <tr>
                            <td>" . ($key + 1) . "</td>
                            <td>" . $value->nama_barang . "</td>
                            <td>" . $value->jumlah_barang . " " . $value->satuan_barang . "</td>
                            <td style='text-align: center; font-size: 15px'>" . $hasilPemeriksaan . "</td>
                            <td>".$value->satuan_barang."</td>
                            <td>".$value->jumlah_barang."</td>
                            <td style='text-align:right;'> Rp. ".number_format((float)$value->harga_satuan,2,",",".")."</td>
                            <td style='text-align:right;'> Rp. ".number_format((float)$value->jumlah_harga,2,",",".")."</td>
                            <td>" . $value->keterangan_pemeriksaan . "</td>
                        </tr>
                        ";
                }
            }
            $data['tr'] = $tr;

            echo json_encode($data);
        }
        Yii::app()->end();
    }

    
    /**
     * Detail 
     * @param type $id
     */
    public function actionDetail($id){
        $this->layout = '//layouts/iframe';
        $model = BahasilpemeriksaanpekerjaanT::model()->findByPk($id);
        $modPeriksaKerja = BapemeriksaanpekerjaanT::model()->findByPk($model->bapemeriksaanpekerjaan_id);
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
        $this->setPihakKessatu($model, $modSPK->pejabatpembuatkomitmen_id);
        $modTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id));
        $mTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id, 'terminke' => $model->terminke));
        $hitungTermin = count($modTermin);
        $model->termin_terminjumlah = $mTermin->urutan;
        $model->termin_termintotal = $hitungTermin;
        if ($modSPK->istermin == true) {
            $modPeriksaKerja->bapemeriksaanpekerjaan_nomor = $modPeriksaKerja->bapemeriksaanpekerjaan_nomor." - Termin ".$model->termin_terminjumlah." ( ".$mTermin->jumlah_persen." %)";
        } else {
            $modPeriksaKerja->bapemeriksaanpekerjaan_nomor = $modPeriksaKerja->bapemeriksaanpekerjaan_nomor." - Non Termin";
        }
        
        $modelDetail = ADBapemeriksaanpekerjaandetT::model()->findAllByAttributes(array('bapemeriksaanpekerjaan_id' => $modPeriksaKerja->bapemeriksaanpekerjaan_id));

        $this->render('detail', array('model' => $model, 'modSPK' => $modSPK, 'modPeriksaKerja' => $modPeriksaKerja, 'modelDetail' => $modelDetail));
    }
    
    /**
     * Cetak transaksi hasil pemeriksaan
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $model = BahasilpemeriksaanpekerjaanT::model()->findByPk($id);
        if (!empty($model->bahasilpemeriksaanpekerjaan_id)) {
            $isiPesan = "-";
            $criteria = new CDbCriteria;
            $criteria->addCondition("konfigtemplatesurat_aktif=true");
            if ($model->termin_persen == 100) {
                $criteria->addCondition("konfigtemplatesurat_nama = 'BA Hasil Pemeriksaan'");
            } else {
                $criteria->addCondition("konfigtemplatesurat_nama = 'BA Hasil Pemeriksaan - Termin'");
            }
            $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

            foreach ($modTemplate as $i => $templateTugas) {
                $isiPesan = $templateTugas->konfigtemplatesurat_isi;
                $isiPesan = "${isiPesan}";
                $attributes = $model->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{ba_hari}}", MyFormatter::getDayName($model->bahasilpemeriksaanpekerjaan_tanggal), $isiPesan);
                    $isiPesan = str_replace("{{ba_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->bahasilpemeriksaanpekerjaan_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_bulan_terbilang}}", ucwords(MyFormatter::getMonthId(date('n', strtotime($model->bahasilpemeriksaanpekerjaan_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->bahasilpemeriksaanpekerjaan_tanggal)))), $isiPesan);
                }

                $modPemeriksaan = BapemeriksaanpekerjaanT::model()->findByPk($model->bapemeriksaanpekerjaan_id);
                $attributes = $modPemeriksaan->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{bapemeriksaanpekerjaan_tanggal}}", MyFormatter::formatDateTimeForUser(date('d M Y', strtotime($modPemeriksaan->bapemeriksaanpekerjaan_tanggal))), $isiPesan);
                    $isiPesan = str_replace("{{nomor_pemeriksaan}}", $modPemeriksaan->nomor_beritaacara, $isiPesan);
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
                    $isiPesan = str_replace("{{tglsuratperjanjian}}", MyFormatter::formatDateTimeForUser(date('d M Y', strtotime($modSurat->tglsuratperjanjian))), $isiPesan);
                }
            }
            $model->dasar = $isiPesan;
        }
        $this->render('print', array('model' => $model, 'modSurat' => $modSurat));
    }
    
    /**
     * Menampilkan tabel riwayat Hasil Pemeriksaan Pekerjaan
     */
    public function actionGetRiwayat() {
        if (Yii::app()->request->isAjaxRequest) {
            $suratperjanjiankerja_id = $_POST['suratperjanjiankerja_id'];
            $modRiwayat = BahasilpemeriksaanpekerjaanT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id), array('order' => 'bapemeriksaanpekerjaan_id'));
            $i = 1;
            $tr = '';
            foreach ($modRiwayat as $row) {
                $modSurat = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
                if($modSurat->istermin == true){
                    $termin = "Termin ". $row->terminke . ' (' . $row->termin_persen . '%)';
                }else{
                    $termin = 'Non Termin';
                }
                $urlDetail = $this->createUrl('detail', array('id' => $row->bahasilpemeriksaanpekerjaan_id));
                $urlEdit = $this->createUrl('Ubah', array('suratperjanjiankerja_id' => $suratperjanjiankerja_id,'bahasilpemeriksaanpekerjaan_id' => $row->bahasilpemeriksaanpekerjaan_id));
                $urlPrint = $this->createUrl('Print', array('id' => $row->bahasilpemeriksaanpekerjaan_id));
                $tr .= '<tr>';
                    $tr .= '<td>' . $i . ' </td>';
                    $tr .= '<td>' . CHtml::link($row->bahasilpemeriksaanpekerjaan_nomor, $urlDetail, array('title' => 'Detail', 'rel' => 'tooltip',"target"=>"frame1", "onclick"=>"$('#dialog1').dialog('open');")).'</td>';
                    $tr .= '<td>' . $row->nomor_beritaacara . '</td>';
                    $tr .= '<td>' . MyFormatter::formatDateTimeForUser($row->create_time). '</td>';
                    $tr .= '<td>' . $termin .'</td>';
                    $tr .= '<td>' . $row->pegpihakkesatu->namaLengkap . '</td>';
                    $tr .= '<td>' . $row->supplier->supplier_nama . '</td>';
                    $tr .= '<td>' . CHtml::link('<i class="entypo-pencil"></i>', $urlEdit, array('title' => 'Ubah Data', 'rel' => 'tooltip')) . '</td>';
                    $tr .= '<td>' . CHtml::link('<i class="entypo-print"></i>', $urlPrint, array('title' => 'Cetak Data', 'rel' => 'tooltip', "target"=>"frame2", "onclick"=>"$('#dialog2').dialog('open');")) . '</td>';
                    
                $tr .= '</tr>';
                $i++;
            }

            $data['tr'] = $tr;

            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Fungsi unduh dokumen pendukung
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = BahasilpemeriksaanpekerjaanT::model()->findByPk($id);
        $path = Params::pathberitaAcaraDirectory()."/".$filename->dokumen_pendukung;
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