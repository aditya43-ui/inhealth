<?php

/**
 * Transaksi berita acara pemeriksaan pekerjaan
 * 
 * @author  Tantowi J <tantowijaya@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @author  Andyka Putra <andykaputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class BAPemeriksaanPekerjaanController extends MyAuthController {
    
    /**
     * Default menu transaksi Pemeriksaan Pekerjaan - Berita Acara
     * @param integer $suratperjanjiankerja_id
     * @param integer $bapemeriksaanpekerjaan_id
     */
    public function actionIndex($suratperjanjiankerja_id, $bapemeriksaanpekerjaan_id = null){
        $this->layout = '//layouts/iframe';
        $model = new ADBapemeriksaanpekerjaanT;
        $modelDetail = new ADBapemeriksaanpekerjaandetT;
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        $modTeknisi = new PegtimteknisT;
        $modSPKRincian = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
        if($modSPK->istermin == true){
            $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id));
            $cekpemeriksaanpekerjaan = ADBapemeriksaanpekerjaanT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id));
            $jumlahpemeriksaan = count($cekpemeriksaanpekerjaan)+1;
        }
            
        if (empty($bapemeriksaanpekerjaan_id)) {
            $model = new ADBapemeriksaanpekerjaanT;
            $model->bapemeriksaanpekerjaan_nomor = "-Otomatis-";
            $model->nomor_beritaacara = "-Otomatis-";
            $model->bapemeriksaanpekerjaan_tanggal = date('d M Y H:i:s');
            
            //Cek Kode Dokumen
            $unitkerjaSPK = !empty($modSPK->unitkerja_id) ? $modSPK->unitkerja->namaunitkerja : '';
            if($unitkerjaSPK !== ''){
                $criteria = new CDbCriteria();
                $criteria->addCondition(" lookup_type = 'kodepemeriksaanpekerjaan' ");
                $criteria->addCondition(" lookup_aktif IS TRUE ");
                $criteria->compare('LOWER(lookup_value)', strtolower($unitkerjaSPK), true);
                $cekLookup = LookupM::model()->find($criteria);
                $model->kode_dokumen = !empty($cekLookup->lookup_name) ? $cekLookup->lookup_name : '';
            }
            
            //Cek Termin
            if($modSPK->istermin == true){
                $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
                $model->termin_ke = !empty($cekpemeriksaanpekerjaan) ? count($cekpemeriksaanpekerjaan)+1 : 1;            
                $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id, 'urutan'=>$jumlahpemeriksaan));
                if(!empty($cekTermin)){
                    $model->terminke = $cekTermin->terminke;
                    $model->termin_persen = $cekTermin->jumlah_persen;
                }
            }else{
                $model->total_termin = 1;
                $model->termin_ke = 1;
                $model->terminke = 'I';
                $model->termin_persen = 100;
            }
        } else {
            $model = ADBapemeriksaanpekerjaanT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanpekerjaan_id'=>$bapemeriksaanpekerjaan_id));
            $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
            $model->terminke = $model->terminke;
            if($modSPK->istermin == true){
                if($model->terminke == 'I'){
                    $model->termin_ke = 1;  
                }else if($model->terminke == 'II'){
                    $model->termin_ke = 2;  
                }else if($model->terminke == 'III'){
                    $model->termin_ke = 3;  
                }
            }else{
                $model->total_termin = 1;
                $model->termin_ke = 1;
            }
            $modSPKRincian = ADBapemeriksaanpekerjaandetT::model()->findAllByAttributes(array('bapemeriksaanpekerjaan_id' => $model->bapemeriksaanpekerjaan_id));
        }

        if(isset($_POST['ADBapemeriksaanpekerjaanT'])){
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                
                $model->attributes = $_POST['ADBapemeriksaanpekerjaanT'];
                $model->suratperjanjiankerja_id = $suratperjanjiankerja_id;
                $model->supplier_id = $modSPK->supplier_id;
                $model->bapemeriksaanpekerjaan_tanggal = MyFormatter::formatDateTimeForDb($model->bapemeriksaanpekerjaan_tanggal);
                $model->pa_tanggalsk = MyFormatter::formatDateTimeForDb($model->pa_tanggalsk);
                $model->kode_dokumen = $_POST['ADBapemeriksaanpekerjaanT']['kode_dokumen'];
                $model->jumlah_harga = $_POST['ADBapemeriksaanpekerjaanT']['jumlah_harga'];
                $model->jumlah_pajak = $_POST['ADBapemeriksaanpekerjaanT']['jumlah_pajak'];
                $model->total_harga = $_POST['ADBapemeriksaanpekerjaanT']['total_harga'];
                $model->total_dibulatkan = $_POST['ADBapemeriksaanpekerjaanT']['total_dibulatkan'];
                $model->total_pembayaran = $_POST['ADBapemeriksaanpekerjaanT']['total_pembayaran'];
                if($modSPK->istermin == true){
                    $model->terminke = $_POST['ADBapemeriksaanpekerjaanT']['terminke'];
                    $model->termin_persen = $_POST['ADBapemeriksaanpekerjaanT']['termin_persen'];
                }else{
                    $model->terminke = 'I';
                    $model->termin_persen = 100;
                }
                
                if(empty($model->bapemeriksaanpekerjaan_id)){
                    $model->nomor_beritaacara = MyGenerator::noBeritaAcaraPemeriksaanPekerjaan($_POST['ADBapemeriksaanpekerjaanT']['kode_dokumen'], date('Y', strtotime($_POST['ADBapemeriksaanpekerjaanT']['bapemeriksaanpekerjaan_tanggal'])));
                    $model->bapemeriksaanpekerjaan_nomor = MyGenerator::noBAPemeriksaanPekerjaan();
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                }else{
                    $cekmodel = ADBapemeriksaanpekerjaanT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanpekerjaan_id'=>$bapemeriksaanpekerjaan_id));
                    if ($_POST['ADBapemeriksaanpekerjaanT']['kode_dokumen'] !== $cekmodel->kode_dokumen) {
                        $model->nomor_beritaacara = str_replace($cekmodel->kode_dokumen, $_POST['ADBapemeriksaanpekerjaanT']['kode_dokumen'], $cekmodel->nomor_beritaacara);
                    }
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                }
                
                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');
                
                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if (!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->bapemeriksaanpekerjaan_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathberitaAcaraDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathberitaAcaraDirectory())){
                        mkdir(Params::pathberitaAcaraDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = ADBapemeriksaanpekerjaanT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }
                
                $ok = $ok && $model->save();
                if (isset($_POST['PegtimteknisT'])) {
                    foreach ($_POST['PegtimteknisT'] as $i => $postDetail) {
                        if (!empty($postDetail['pegtimteknis_id'])) {
                            //untuk cek data sudah tersedia 
                            $jumlah = PegtimteknisT::model()->countByAttributes(array(
                                'pegtimteknis_id' => $postDetail['pegtimteknis_id']
                            ));

                            if ($jumlah != 0) {

                                if (!empty($model->bapemeriksaanpekerjaan_id) && ($_GET['status'] = 'update')) {
                                    $modPegawai = PegtimteknisT::model()->findByPk($postDetail['pegtimteknis_id']);
                                }
                                
                                if ($postDetail['status'] == 1) {//untuk hapus data yang sudah ada
                                    $modPegawai->delete();
                                } else { //untuk edit data baru
                                    $modPegawai->pegawai_id = $postDetail['pegawai_id'];
                                    $modPegawai->jabatan_timteknis = $postDetail['jabatan_timteknis'];
                                    $modPegawai->suratperjanjiankerja_id = $suratperjanjiankerja_id;
                                    $modPegawai->bapemeriksaanpekerjaan_id = $model->bapemeriksaanpekerjaan_id;
                                    $ok = $ok && $modPegawai->save() && true;
                                }
                            }
                        } else {
                            $modPegawai = new PegtimteknisT;
                            $modPegawai->pegawai_id = $postDetail['pegawai_id'];
                            $modPegawai->jabatan_timteknis = $postDetail['jabatan_timteknis'];

                            $modPegawai->suratperjanjiankerja_id = $suratperjanjiankerja_id;
                            $modPegawai->bapemeriksaanpekerjaan_id = $model->bapemeriksaanpekerjaan_id;
                            $ok = $ok && $modPegawai->save();
                        }
                    }
                }
                
                if($ok){
                    ADBapemeriksaanpekerjaandetT::model()->deleteAllByAttributes(array('bapemeriksaanpekerjaan_id' => $model->bapemeriksaanpekerjaan_id));
                }
                
                if(isset($_POST['ADBapemeriksaanpekerjaandetT']) && $ok){
                    foreach ($_POST['ADBapemeriksaanpekerjaandetT'] as $key => $value) {
                        $modelDetail = new ADBapemeriksaanpekerjaandetT;
                        $modelDetail->attributes = $value;
                        $modelDetail->bapemeriksaanpekerjaan_id = $model->bapemeriksaanpekerjaan_id;
                        $modelDetail->harga_satuan = $value['harga_satuan'];
                        $modelDetail->jumlah_harga = $value['jumlah_harga'];
                        $modelDetail->jumlah_pajak = $value['jumlah_pajak'];
                        $modelDetail->pajak_persen = null;
                        $ok = $ok && $modelDetail->save();
                    }
                }
                
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'bapemeriksaanpekerjaan_id' => $model->bapemeriksaanpekerjaan_id ,'sukses' => 1));
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
            'modTeknisi' => $modTeknisi,
            'modSPKRincian' => $modSPKRincian,
        ));
    }
    
    /**
     * Cetak transaksi pemeriksaan pekerjaan
     * @param type $id
     */
    public function actionPrint($id){
        $this->layout = '//layouts/printWindows';
        $model = BapemeriksaanpekerjaanT::model()->findByPk($id);
        $modsurat= SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
        $modeldet = BapemeriksaanpekerjaandetT::model()->findAllByAttributes(array('bapemeriksaanpekerjaan_id'=>$id));
        $modTeknisi = PegtimteknisT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'bapemeriksaanpekerjaan_id'=>$model->bapemeriksaanpekerjaan_id));
        if(!empty($model->bapemeriksaanpekerjaan_id)){
            $isiPesan = "-";
            $criteria = new CDbCriteria;
            $criteria->addCondition("konfigtemplatesurat_aktif=true");
            $criteria->addCondition("konfigtemplatesurat_nama = 'BA Pemeriksaan Pekerjaan'");
            $modTemplate1 = KonfigtemplatesuratK::model()->findAll($criteria);
            

            foreach ($modTemplate1 as $i => $templateTugas) {
                $isiPesan = $templateTugas->konfigtemplatesurat_isi;
                $isiPesan = "${isiPesan}";
                $attributes = $model->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  
                    $isiPesan = str_replace("{{ba_hari}}", MyFormatter::getDayName($model->bapemeriksaanpekerjaan_tanggal), $isiPesan);
                    $isiPesan = str_replace("{{ba_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->bapemeriksaanpekerjaan_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_bulan_terbilang}}", ucwords(MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanpekerjaan_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->bapemeriksaanpekerjaan_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_tgl_bulan_tahun}}", date('d-', strtotime($model->bapemeriksaanpekerjaan_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanpekerjaan_tanggal))) . date('-Y', strtotime($model->bapemeriksaanpekerjaan_tanggal)), $isiPesan);
                    $isiPesan = str_replace("{{namapekerjaan}}",$modsurat->namapekerjaan , $isiPesan);
                    $isiPesan = str_replace("{{tglsuratperjanjian}}",date('d ', strtotime($modsurat->tglsuratperjanjian)) . MyFormatter::getMonthId(date('m', strtotime($modsurat->tglsuratperjanjian))) . date(' Y', strtotime($modsurat->tglsuratperjanjian)), $isiPesan);                     
                    $isiPesan = str_replace("{{nomorsuratperjanjian}}",$modsurat->nosuratperjanjiankerja , $isiPesan);
                    $isiPesan = str_replace("{{nama_direktur}}",$model->supplier->direktursupplier , $isiPesan);
                    $isiPesan = str_replace("{{supplier_alamat}}",$model->supplier->supplier_alamat , $isiPesan);
                    $isiPesan = str_replace("{{supplier_nama}}",$model->supplier->supplier_nama , $isiPesan);
                    $isiPesan = str_replace("{{nomor_dokumen_spk}}",$modsurat->nomor_dokumen , $isiPesan);
                    $isiPesan = str_replace("{{tanda_centang}}","<i class='fa fa-check'></i>", $isiPesan);
                    $isiPesan = str_replace("{{tanda_silang}}","<i class='fa fa-times'></i>", $isiPesan);
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{pa_tanggalsk}}", date('d ', strtotime($model->pa_tanggalsk)) . MyFormatter::getMonthId(date('m', strtotime($model->pa_tanggalsk))) . date(' Y', strtotime($model->pa_tanggalsk)), $isiPesan);                    
                    $isiPesan = str_replace("{{bapemeriksaanpekerjaan_tanggal}}", date('d ', strtotime($model->bapemeriksaanpekerjaan_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanpekerjaan_tanggal))) . date(' Y', strtotime($model->bapemeriksaanpekerjaan_tanggal)), $isiPesan);                    

                }
                
            
            $a = '<table border="0" width="width:100%">';
            $no = 1;
            foreach ($modTeknisi as $panitia) {
                $cekPegawai = PegawaiM::model()->findByPk($panitia->pegawai_id);
                $a .= '<tr>
                            <td width="5%">' . $no++ . '. </td>
                            <td width="5%">Nama </td>
                            <td width="45%"> : ' . $cekPegawai->namaLengkap . '</td>
                            <td  width="10%">Jabatan</td>
                            <td width="40%"> : ' . $panitia->jabatan_timteknis . '</td>
                        </tr>';
            }
            $a .= '</table>';
            $isiPesan = str_replace("{{tim_pegawai}}", $a, $isiPesan);
                           
            }
            $model->dasar=$isiPesan;
            
        }
        $this->render('print', array('model' => $model,'modsurat' => $modsurat));
    }
    
    /**
     * Cetak transaksi pemeriksaan pekerjaan - Termin
     * @param type $id
     */
    public function actionPrintTermin($id) {
        $this->layout = '//layouts/printWindows';
        $model = BapemeriksaanpekerjaanT::model()->findByPk($id);
        $modsurat= SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
        $modeldet = BapemeriksaanpekerjaandetT::model()->findAllByAttributes(array('bapemeriksaanpekerjaan_id'=>$id));
        $modTeknisi = PegtimteknisT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'bapemeriksaanpekerjaan_id'=>$model->bapemeriksaanpekerjaan_id));
        if(!empty($model->bapemeriksaanpekerjaan_id)){
            $isiPesan = "-";
            $criteria = new CDbCriteria;
            $criteria->addCondition("konfigtemplatesurat_aktif=true");
            $criteria->addCondition("konfigtemplatesurat_nama = 'BA Pemeriksaan Pekerjaan - Termin'");
            $modTemplate1 = KonfigtemplatesuratK::model()->findAll($criteria);
            

            foreach ($modTemplate1 as $i => $templateTugas) {
                $isiPesan = $templateTugas->konfigtemplatesurat_isi;
                $isiPesan = "${isiPesan}";
                $attributes = $model->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  
                    $isiPesan = str_replace("{{ba_hari}}", MyFormatter::getDayName($model->bapemeriksaanpekerjaan_tanggal), $isiPesan);
                    $isiPesan = str_replace("{{ba_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->bapemeriksaanpekerjaan_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_bulan_terbilang}}", ucwords(MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanpekerjaan_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->bapemeriksaanpekerjaan_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_tgl_bulan_tahun}}", date('d-', strtotime($model->bapemeriksaanpekerjaan_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanpekerjaan_tanggal))) . date('-Y', strtotime($model->bapemeriksaanpekerjaan_tanggal)), $isiPesan);
                    $isiPesan = str_replace("{{namapekerjaan}}",$modsurat->namapekerjaan , $isiPesan);
                    $isiPesan = str_replace("{{tglsuratperjanjian}}",date('d ', strtotime($modsurat->tglsuratperjanjian)) . MyFormatter::getMonthId(date('m', strtotime($modsurat->tglsuratperjanjian))) . date(' Y', strtotime($modsurat->tglsuratperjanjian)), $isiPesan);                     
                    $isiPesan = str_replace("{{nomorsuratperjanjian}}",$modsurat->nosuratperjanjiankerja , $isiPesan);
                    $isiPesan = str_replace("{{nama_direktur}}",$model->supplier->direktursupplier , $isiPesan);
                    $isiPesan = str_replace("{{supplier_alamat}}",$model->supplier->supplier_alamat , $isiPesan);
                    $isiPesan = str_replace("{{supplier_nama}}",$model->supplier->supplier_nama , $isiPesan);
                    $isiPesan = str_replace("{{nomor_dokumen_spk}}",$modsurat->nomor_dokumen , $isiPesan);
                    $isiPesan = str_replace("{{tanda_centang}}","<i class='fa fa-check'></i>", $isiPesan);
                    $isiPesan = str_replace("{{tanda_silang}}","<i class='fa fa-times'></i>", $isiPesan);
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{pa_tanggalsk}}", date('d ', strtotime($model->pa_tanggalsk)) . MyFormatter::getMonthId(date('m', strtotime($model->pa_tanggalsk))) . date(' Y', strtotime($model->pa_tanggalsk)), $isiPesan);                    
                    $isiPesan = str_replace("{{bapemeriksaanpekerjaan_tanggal}}", date('d ', strtotime($model->bapemeriksaanpekerjaan_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanpekerjaan_tanggal))) . date(' Y', strtotime($model->bapemeriksaanpekerjaan_tanggal)), $isiPesan);                    
                    $isiPesan = str_replace("{{terminke}}", $model->terminke, $isiPesan);
                }
                
            
            $a = '<table border="0" width="width:100%">';
            $no = 1;
            foreach ($modTeknisi as $panitia) {
                $cekPegawai = PegawaiM::model()->findByPk($panitia->pegawai_id);
                $a .= '<tr>
                            <td width="5%">' . $no++ . '. </td>
                            <td width="5%">Nama </td>
                            <td width="45%"> : ' . $cekPegawai->namaLengkap . '</td>
                            <td  width="10%">Jabatan</td>
                            <td width="40%"> : ' . $panitia->jabatan_timteknis . '</td>
                        </tr>';
            }
            $a .= '</table>';
            $isiPesan = str_replace("{{tim_pegawai}}", $a, $isiPesan);
                           
            }
            $model->dasar=$isiPesan;
            
        }
        $this->render('print', array('model' => $model,'modsurat' => $modsurat));
    }
    
    /**
     * Menampilkan tabel riwayat Pemeriksaan Pekerjaan
     */
    public function actionGetRiwayat() {
        if (Yii::app()->request->isAjaxRequest) {
            $suratperjanjiankerja_id = $_POST['suratperjanjiankerja_id'];
            $modRiwayat = ADBapemeriksaanpekerjaanT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id), array('order' => 'bapemeriksaanpekerjaan_id'));
            $i = 1;
            $tr = '';
            foreach ($modRiwayat as $row) {
                $tim = '';
                $cekTimteknis = PegtimteknisT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanpekerjaan_id' => $row->bapemeriksaanpekerjaan_id));
                if (count($cekTimteknis)>0){
                    $tim .= '<ul>';
                    foreach($cekTimteknis as $val){
                        if (!empty($val->pegtimteknis_id)){
                            $tim .= '<li>'.$val->pegawai->namaLengkap.'</li>';
                        }
                    }
                    $tim .= '</ul>';
                }else{
                    $tim .= "-";
                }
                $modSurat = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
                if($modSurat->istermin == true){
                    $termin = $row->terminke . ' (' . $row->termin_persen . '%)';
                    $cetak = CHtml::link('<i class="entypo-print"></i>', '#', array('title' => 'Cetak Dokumen', 'rel' => 'tooltip', 'onclick' => "window.open('" . $this->createUrl('printTermin', array('id' => $row->bapemeriksaanpekerjaan_id)) . "', 'printwin', 'left=100,top=100,width=790,height=1120')"));
                }else{
                    $termin = 'Non Termin';
                    $cetak = CHtml::link('<i class="entypo-print"></i>', '#', array('title' => 'Cetak Dokumen', 'rel' => 'tooltip', 'onclick' => "window.open('" . $this->createUrl('print', array('id' => $row->bapemeriksaanpekerjaan_id)) . "', 'printwin', 'left=100,top=100,width=790,height=1120')"));
                }
                
                $urlDetail = $this->createUrl('Detail', array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanpekerjaan_id' => $row->bapemeriksaanpekerjaan_id));
                $urlEdit = $this->createUrl('Index', array('suratperjanjiankerja_id' => $suratperjanjiankerja_id,'bapemeriksaanpekerjaan_id' => $row->bapemeriksaanpekerjaan_id));
                $tr .= '<tr>';
                    $tr .= '<td>' . $i . ' </td>';
                    $tr .= '<td>' . Chtml::link($row->bapemeriksaanpekerjaan_nomor, $urlDetail, array('title' => 'Detail', 'rel' => 'tooltip',"target"=>"iframe1", "onclick"=>"$('#dialogRiwayat').dialog('open');")).'</td>';
                    $tr .= '<td>' . $row->nomor_beritaacara . '</td>';
                    $tr .= '<td>' . date("d M Y H:i:s", strtotime($row->bapemeriksaanpekerjaan_tanggal)) . '</td>';
                    $tr .= '<td>' . $row->lokasi_pemeriksaan . '</td>';
                    $tr .= '<td>' . $termin .'</td>';
                    $tr .= '<td>' . $tim . '</td>';
                    $tr .= '<td>' . $row->bapemeriksaanpekerjaan_hasil . '</td>';
                    $tr .= '<td>' . CHtml::link('<i class="entypo-pencil"></i>', $urlEdit, array('title' => 'Ubah Data', 'rel' => 'tooltip', 'onclick' => 'setUbahForm(' . $row->bapemeriksaanpekerjaan_id, $row->suratperjanjiankerja_id . '); return false')) . '</td>';
                    $tr .= '<td>' . $cetak . '</td>';
                    
                $tr .= '</tr>';
                $i++;
            }

            $data['tr'] = $tr;

            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Load pegawai tim teknis
     */
    public function actionGetPegawai(){
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {  
            $model = new PegtimteknisT();
            $data['form'] = "";
            if(!empty($_POST['pemeriksaanpekerjaan_id'])){
                $models = $this->loadPegawai($_POST['id'],$_POST['pemeriksaanpekerjaan_id']);
            }else{
                $models = $this->loadPegawai($_POST['id']);
            }
            
            if(count($models) > 0){
                foreach ($models AS $i=>$model){
                    if(!empty($_POST['pemeriksaanpekerjaan_id'])){
                        $model->pegtimteknis_id = $model->pegtimteknis_id;
                    }else{
                        $model->pegtimteknis_id = null;
                    }
                    $model->nama_pegawai = $model->pegawai->nama_pegawai;
                    $model->nomorindukpegawai = $model->pegawai->nomorindukpegawai;
                    $data['form'] .= $this->renderPartial('_rowTimTeknis',array('modPegawai'=>$model, 'i'=>1),true);
                }
            } else {
                $data['form'] .= $this->renderPartial('_rowTimTeknis',array('modPegawai'=>$model, 'i'=>1),true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    
    
    /**
     * Load pegawai tim teknis detail
     */
    public function actionGetPegawaidet(){
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {  
            $model = new PegtimteknisT();
            $data['form'] = "";
            if(!empty($_POST['pemeriksaanpekerjaan_id'])){
                $models = $this->loadPegawai($_POST['id'],$_POST['pemeriksaanpekerjaan_id']);
            }else{
                $models = $this->loadPegawai($_POST['id']);
            }
            
            if(count($models) > 0){
                foreach ($models AS $i=>$model){
                    if(!empty($_POST['pemeriksaanpekerjaan_id'])){
                        $model->pegtimteknis_id = $model->pegtimteknis_id;
                    }else{
                        $model->pegtimteknis_id = null;
                    }
                    $model->nama_pegawai = $model->pegawai->nama_pegawai;
                    $model->nomorindukpegawai = $model->pegawai->nomorindukpegawai;
                    $data['form'] .= $this->renderPartial('_rowTimTeknisdet',array('modPegawai'=>$model, 'i'=>1),true);
                }
            } else {
                $data['form'] .= $this->renderPartial('_rowTimTeknisdet',array('modPegawai'=>$model, 'i'=>1),true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Load data pegawai
     * @param type $id
     * @param type $bapemeriksaanpekerjaan_id
     * @return type
     * @throws CHttpException
     */
    private function loadPegawai($id, $bapemeriksaanpekerjaan_id = null){
        if(!empty($bapemeriksaanpekerjaan_id)){
            $model = PegtimteknisT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $id,'bapemeriksaanpekerjaan_id'=>$bapemeriksaanpekerjaan_id), array('order' => 'pegtimteknis_id ASC'));
        }else{
            $model = PegtimteknisT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $id,'bapemeriksaanpekerjaan_id'=>null), array('order' => 'pegtimteknis_id ASC'));
        }
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    
    /**
     * Autocomplete Tim Teknis
     */
    public function actionAutocompletePegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }

            if (isset($_GET['pegawai_id'])) {
                if (!empty($_GET['pegawai_id'])) {
                    $criteria->addCondition("t.pegawai_id = " . $_GET['pegawai_id']);
                }
            }
            $criteria->select = "t.*, pegawai_m.*";
            $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id "
                            . "JOIN jabatan_m ON pegawai_m.jabatan_id = jabatan_m.jabatan_id "
                            . "JOIN unitkerja_m ON pegawai_m.unitkerja_id = unitkerja_m.unitkerja_id ";
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition("jabatan_pengadaan = 'Tim Teknis'");
            $criteria->addCondition('pejabatpengadaan_aktif IS TRUE');
            
            $criteria->order = 'pegawai_m.nama_pegawai ASC';
            $criteria->limit = 10;
            $models = PejabatpengadaanM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->nama_pegawai;
                $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
                $returnVal[$i]['nomorindukpegawai'] = $model->nomorindukpegawai;
                $returnVal[$i]['no_sk'] = $model->no_sk;
                $returnVal[$i]['tgl_sk'] = date('d ', strtotime($model->tgl_sk)) . MyFormatter::getMonthId(date('m', strtotime($model->tgl_sk))) . date(' Y', strtotime($model->tgl_sk));
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
 
    /**
     * Halaman Detail Berita Acara Pemeriksaan Pekerjaan
     * 
     * @param integer $suratperjanjiankerja_id
     * @param integer $bapemeriksaanpekerjaan_id
     */
    public function actionDetail($suratperjanjiankerja_id, $bapemeriksaanpekerjaan_id = null) {
        $this->layout = '//layouts/iframe';
        $model = new ADBapemeriksaanpekerjaanT;
        $modelDetail = new ADBapemeriksaanpekerjaandetT;
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        $modTeknisi = new PegtimteknisT;
        $modSPKRincian = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
        if($modSPK->istermin == true){
            $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id));
            $cekpemeriksaanpekerjaan = ADBapemeriksaanpekerjaanT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id));
            $jumlahpemeriksaan = count($cekpemeriksaanpekerjaan)+1;
        }
        
        if (empty($bapemeriksaanpekerjaan_id)) {
            $model = new ADBapemeriksaanpekerjaanT;
            $model->bapemeriksaanpekerjaan_nomor = "-Otomatis-";
            $model->bapemeriksaanpekerjaan_tanggal = date('d M Y H:i:s');
            $model->pa_tanggalsk = date('d M Y');
            if($modSPK->istermin == true){
                $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
                $model->termin_ke = !empty($cekpemeriksaanpekerjaan) ? count($cekpemeriksaanpekerjaan)+1 : 1;            
                $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id, 'urutan'=>$jumlahpemeriksaan));
                if(!empty($cekTermin)){
                    $model->terminke = $cekTermin->terminke;
                }
            }else{
                $model->total_termin = 1;
                $model->termin_ke = 1;
                $model->terminke = 'I';
                $model->termin_persen = 100;
            }
        } else {
            $model = ADBapemeriksaanpekerjaanT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanpekerjaan_id'=>$bapemeriksaanpekerjaan_id));
            $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
            $model->terminke = $model->terminke;
            if($modSPK->istermin == true){
                if($model->terminke == 'I'){
                    $model->termin_ke = 1;  
                }else if($model->terminke == 'II'){
                    $model->termin_ke = 2;  
                }else if($model->terminke == 'III'){
                    $model->termin_ke = 3;  
                }
            }else{
                $model->total_termin = 1;
                $model->termin_ke = 1;
            }
            $modSPKRincian = ADBapemeriksaanpekerjaandetT::model()->findAllByAttributes(array('bapemeriksaanpekerjaan_id' => $model->bapemeriksaanpekerjaan_id));
        }
        
        $this->render('detail', array(
            'model' => $model,
            'modelDetail' => $modelDetail,
            'modSPK' => $modSPK,
            'modTeknisi' => $modTeknisi,
            'modSPKRincian' => $modSPKRincian,
        ));
    }
    
    /**
     * Fungsi unduh dokumen pendukung
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = BapemeriksaanpekerjaanT::model()->findByPk($id);
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

