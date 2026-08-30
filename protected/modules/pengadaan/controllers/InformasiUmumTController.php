<?php
/**
 * Controller untuk tab Informasi Umum pada Surat Perjanjian Kerja
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 */
class InformasiUmumTController extends MyAuthController{
    
    /**
     * Load halaman index
     */
    public function actionIndex(){
        $this->layout = '//layouts/iframe';
        $modSupplier = new SupplierM;
        $cekInformasi = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $_GET['id'], 'isbatal' => false, 'isaddendum' => true));
        $modInformasi = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $_GET['id']));
        $cekPenawaran = PenawaranpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $_GET['id'], 'isbatal' => false, 'isaddendum' => true));
        $disable = false;
        $disableSupplier = false;
        $disablePejabat = false;
        if (!empty($cekInformasi)) {
            $model = $cekInformasi;
            $model->temp_file = $model->dokumen_pendukung;
            if (!empty($model->pegpengadaan_id)) {
                $model->pegpengadaan_nama = $model->pegpengadaan->namaLengkap;
                $model->tgl_sk = MyFormatter::formatDateTimeForUser($model->tgl_sk);
                $disablePejabat = true;
            }
            if (!empty($model->supplier_id)) {
                $modSupplier = SupplierM::model()->findByPk($model->supplier_id);
                $disableSupplier = true;
            } else {
                $modSupplier = new SupplierM();
                $disableSupplier = false;
            }
                
            if (!empty($cekPenawaran)) {
                $modPenawaran = $cekPenawaran;
                $modPenawaran->temp_file = $modPenawaran->penawaranpenyedia_file; 
                $modPenawaran->penawaranpenyedia_tanggal = MyFormatter::formatDateTimeForUser($modPenawaran->penawaranpenyedia_tanggal);
                $modPenawaran->penawaranpenyedia_harga = MyFormatter::formatNumberForPrint($modPenawaran->penawaranpenyedia_harga, 2);
            } else {
                $modPenawaran = new PenawaranpenyediaT;
                $disable = false;
                $model->keterangan = "Belum ada data penawaran";
                $modPenawaran->penawaranpenyedia_nomor  = '-- Otomatis -- ';
                $modPenawaran->penawaranpenyedia_tanggal = date('d M Y');
            }
        } else {
            $model = new InfoumumpengadaanT();
            $model->tgl_sk = date('d M Y');
            if (!empty($cekPenawaran)) {
                $modPenawaran = $cekPenawaran;
                $modPenawaran->penawaranpenyedia_tanggal = MyFormatter::formatDateTimeForUser($modPenawaran->penawaranpenyedia_tanggal);
                $modPenawaran->penawaranpenyedia_harga = MyFormatter::formatNumberForPrint($modPenawaran->penawaranpenyedia_harga, 2);
            } else {
                $modPenawaran = new PenawaranpenyediaT;
                $disable = false;
                $model->keterangan = "Belum ada data penawaran";
                $modPenawaran->penawaranpenyedia_nomor  = '-- Otomatis -- ';
                $modPenawaran->penawaranpenyedia_tanggal = date('d M Y');
            }
        }
        $modPegawaiPa = PegawaiM::model()->findByPk($modInformasi->pegawaipa_id);
        $modPegawaiKpa = PegawaiM::model()->findByPk($modInformasi->pegawaikpa_id);
        $modPegawaiPpk = PegawaiM::model()->findByPk($modInformasi->pegawaippk_id);
        $model->persiapanpengadaan_id = $_GET['id'];
        $model->pegpa_id = $modInformasi->pegawaipa_id;
        $model->pegpa_nama = $modPegawaiPa->namaLengkap;
        $model->pegkpa_nama = $modPegawaiKpa->namaLengkap;
        $model->pegkpa_id = $modInformasi->pegawaikpa_id;
        $model->pegppk_id = $modInformasi->pegawaippk_id;
        $model->pegppk_nama = $modPegawaiPpk->namaLengkap;
        if (isset($_POST['InfoumumpengadaanT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            
            $nama_modul = Yii::app()->controller->module->id;
            $nama_controller = Yii::app()->controller->id;
            $nama_action = Yii::app()->controller->action->id;
            $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
            $criteria = new CDbCriteria;
            $criteria->compare('modul_id', $modul_id);
            $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
            $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
            $criteria->addCondition(" statussms = true AND tujuansms = 'supplier' ");

            $modSmsgateway = SmsgatewayM::model()->find($criteria);

            if (!empty($modSmsgateway)) {
                $template = $modSmsgateway->templatesms;
            } else {
                $template = "Penyedia {{supplier_nama}} terpilih sebagai pemenang untuk pekerjaan {{kode_sub_kegiatan}} - {{nama_pekerjaan}}. Mohon untuk segera memasukkan data perusahaan dan data penawaran dengan login ke http://172.9.1.15/simpp/ (Akses harus di RSUD dr. Soetomo).";
            }
            try{
                if (isset($_POST['SupplierM'])) {
                    
                    // kondisi 1 jika ada supplier_id dan data belum pernah di-update sebelumnya akan mengirim SMS ke supplier
                    if (!empty($_POST['SupplierM']['supplier_id']) && empty($model->update_time)) {
                        $modSupplier = SupplierM::model()->findByPk($_POST['SupplierM']['supplier_id']);
                        $modSupplier->attributes = $_POST['SupplierM'];      
                        $modSupplier->attributes = $modSupplier; 
                        /**
                         * Disable notifikasi SMS di RSST-9901
                        if (!empty($modSupplier->supplier_telp)){
                            $isiPesan = $template;
                            $attributes = $model->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                $isiPesan = str_replace("{{kode_sub_kegiatan}}", $modInformasi->subkegiatanprogram_kode, $isiPesan);
                                $isiPesan = str_replace("{{supplier_nama}}", $modSupplier->supplier_nama, $isiPesan);
                                $isiPesan = str_replace("{{nama_pekerjaan}}", $modInformasi->nama_pekerjaan, $isiPesan);
                            }                                                                                                          
                            $api = new MyAPI();                
                            $api->smsBlastSend(array($modSupplier->supplier_telp),'RSDrSoetomo', $isiPesan);
                        }
                         * 
                         */
                    } 
                    
                    // kondisi 2 jika tidak ada supplier
                    if(empty($_POST['SupplierM']['supplier_id'])){
                        $modSupplier = new SupplierM;
                        $modSupplier->attributes = $_POST['SupplierM'];
                        $modSupplier->supplier_kode = MyGenerator::kodeSupplier();
                        $modSupplier->create_loginpemakai_id = Yii::app()->user->id;
                        $modSupplier->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $modSupplier->create_time = date ('Y-m-d H:i:s');
                        //START NOTIFIKASI
                        $judul = 'Pembuatan Data Supplier Baru';
                        $isi = $modSupplier->supplier_kode . " - " . $modSupplier->supplier_nama;

                        CustomFunction::broadcastNotif(
                            $judul, $isi, array(
                            array('instalasi_id' => Params::INSTALASI_ID_SISADMIN,
                                'ruangan_id' => Params::RUANGAN_ID_SIMRS,
                                'modul_id' => Params::MODUL_ID_SISADMIN),
                            )
                        );
                        
                        //END NOTIFIKASI
                        /** Disable notifikasi SMS di RSST-9901
                        $template2 = "Penyedia {{supplier_nama}} terpilih sebagai pemenang untuk pekerjaan {{kode_sub_kegiatan}} - {{nama_pekerjaan}}. Mohon untuk segera memasukkan data perusahaan dan data penawaran dengan login ke http://172.9.1.15/simpp/ (Akses harus di RSUD dr. Soetomo). Catatan: Informasi login akan dikirimkan.";
                        if (!empty($modSupplier->supplier_telp)){
                            $isiPesan2 = $template2;
                            $attributes = $model->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan2 = str_replace("{{" . $attributes . "}}", $value, $isiPesan2);
                                $isiPesan2 = str_replace("{{kode_sub_kegiatan}}", $modInformasi->subkegiatanprogram_kode, $isiPesan2);
                                $isiPesan2 = str_replace("{{supplier_nama}}", $_POST['SupplierM']['supplier_nama'], $isiPesan2);
                                $isiPesan2 = str_replace("{{nama_pekerjaan}}", $modInformasi->nama_pekerjaan, $isiPesan2);
                            }                                                                                                          
                            $api = new MyAPI();                
                            $api->smsBlastSend(array($modSupplier->supplier_telp),'RSDrSoetomo', $isiPesan2);
                        } */
                    } 
                    $ok = $ok && $modSupplier->save();
                }
                
                if (isset($_POST['PenawaranpenyediaT'])) {
                    if (!empty($_POST['PenawaranpenyediaT']['penawaranpenyedia_id'])) {
                        $files = $_FILES['PenawaranpenyediaT'];
                        $modPenawaran = PenawaranpenyediaT::model()->findByPk($_POST['PenawaranpenyediaT']['penawaranpenyedia_id']);
                        $modPenawaran->attributes = $_POST['PenawaranpenyediaT'];
                        if (!empty($modPenawaran->penyedia_id)) {
                            $modPenawaran->penyedia_id = $modPenawaran->penyedia_id;
                        }
                        $modPenawaran->penawaranpenyedia_nomor = $modPenawaran->penawaranpenyedia_nomor;
                        $modPenawaran->penawaranpenyedia_tanggal = MyFormatter::formatDateTimeForDb($modPenawaran->penawaranpenyedia_tanggal);
                        $modPenawaran->penawaranpenyedia_harga = MyFormatter::formatNumberForDb($modPenawaran->penawaranpenyedia_harga);
                        $sk_path_temp = !empty($_POST['PenawaranpenyediaT']['temp_file']) ? $_POST['PenawaranpenyediaT']['temp_file'] : null;

                        $name = $modPenawaran->penawaranpenyedia_nomor.".pdf";

                        if (is_uploaded_file($files["tmp_name"]['penawaranpenyedia_file'])) {
                            $modPenawaran->penawaranpenyedia_file = $name;
                        }
                        if(!empty($modPenawaran->penawaranpenyedia_id) && empty($modPenawaran->penawaranpenyedia_file)){
                            $modPenawaran->penawaranpenyedia_file = $sk_path_temp;
                        }
                    } else {
                        $files = $_FILES['PenawaranpenyediaT'];
                        $modPenawaran = new PenawaranpenyediaT();
                        $modPenawaran->attributes = $_POST['PenawaranpenyediaT']; 
                        if (!empty($modPenawaran->penyedia_id)) {
                            $modPenawaran->penyedia_id = $modPenawaran->penyedia_id;
                        }
                        $modPenawaran->supplier_id = $modSupplier->supplier_id; 
                        $modPenawaran->persiapanpengadaan_id = $model->persiapanpengadaan_id; 
                        $modPenawaran->penawaranpenyedia_status = "Diajukan";
                        $modPenawaran->ispemenang = true;
                        $modPenawaran->penawaranpenyedia_nomor = MyGenerator::noPenawaranPenyedia();
                        $modPenawaran->penawaranpenyedia_tanggal = !empty($modPenawaran->penawaranpenyedia_tanggal) ? MyFormatter::formatDateTimeForDb($modPenawaran->penawaranpenyedia_tanggal) : "";
                        $modPenawaran->penawaranpenyedia_harga = !empty($modPenawaran->penawaranpenyedia_harga) ? MyFormatter::formatNumberForDb($modPenawaran->penawaranpenyedia_harga) : 0; 

                        $name = $modPenawaran->penawaranpenyedia_nomor.".pdf";

                        if (is_uploaded_file($files["tmp_name"]['penawaranpenyedia_file'])) {
                            $modPenawaran->penawaranpenyedia_file = $name;
                        }

                    }
                }
                
                $model->attributes = $_POST['InfoumumpengadaanT'];
                $model->persiapanpengadaan_id = $_GET['id']; 
                $model->pegpa_id = $modInformasi->pegawaipa_id;
                $model->pegpa_nama = $modInformasi->peg_pa;
                $model->pegkpa_nama = $modInformasi->peg_kpa;
                $model->pegkpa_id = $modInformasi->pegawaikpa_id;
                $model->pegppk_id = $modInformasi->pegawaippk_id;
                $model->pegppk_nama = $modInformasi->peg_ppk;
                $model->supplier_id = $modSupplier->supplier_id;
                $model->tgl_sk = !empty($model->tgl_sk) ? MyFormatter::formatDateTimeForDb($model->tgl_sk) : null;  
                $files2 = $_FILES['InfoumumpengadaanT'];
                $modPersiapan = PersiapanpengadaanT::model()->findByPk($model->persiapanpengadaan_id); 
                if (empty($cekInformasi)) {
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date ('Y-m-d H:i:s');
                    $name_2 = "REFERENSI_".$modPersiapan->persiapanpengadaan_nomor.".pdf";

                    if (is_uploaded_file($files2["tmp_name"]['dokumen_pendukung'])) {
                        $model->dokumen_pendukung = $name_2;
                    }
                } else {
                    $model->update_time = date ('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $sk_path_temp_2 = $model->temp_file;
                    $name_2 = "REFERENSI_".$modPersiapan->persiapanpengadaan_nomor.".pdf";

                    if (is_uploaded_file($files2["tmp_name"]['dokumen_pendukung'])) {
                        $model->dokumen_pendukung = $name_2;
                    }
                    if(!empty($model->infoumumpengadaan_id) && empty($model->dokumen_pendukung)){
                        $model->dokumen_pendukung = $sk_path_temp_2;
                    }
                }
                
                if (!empty($_POST['PenawaranpenyediaT']['penawaranpenyedia_id'])) {
                    $ok = $ok && $model->save() && $modPenawaran->save(); 

                    if(!empty($files["tmp_name"]['penawaranpenyedia_file'])){
                        
                        if (!file_exists(Params::pathPenawaranPenyediaFileDirectory())){
                            mkdir(Params::pathPenawaranPenyediaFileDirectory(), 0775, true);
                        }
                        
                        if (!empty($sk_path_temp) && file_exists(Params::pathPenawaranPenyediaFileDirectory().$sk_path_temp)) {
                            unlink(Params::pathPenawaranPenyediaFileDirectory().$sk_path_temp);
                        }
                        move_uploaded_file(
                            $files["tmp_name"]['penawaranpenyedia_file'], 
                                Params::pathPenawaranPenyediaFileDirectory().$name
                            );
                    }
                    
                    if(!empty($files2["tmp_name"]['dokumen_pendukung'])){
                        
                        if (!file_exists(Params::pathPenawaranPenyediaFileDirectory())){
                            mkdir(Params::pathPenawaranPenyediaFileDirectory(), 0775, true);
                        }
                        
                        if (!empty($sk_path_temp) && file_exists(Params::pathPenawaranPenyediaFileDirectory().$sk_path_temp)) {
                            unlink(Params::pathPenawaranPenyediaFileDirectory().$sk_path_temp_2);
                        }
                        move_uploaded_file(
                            $files2["tmp_name"]['dokumen_pendukung'], 
                                Params::pathPenawaranPenyediaFileDirectory().$name_2
                            );
                    }
                } else {
                    $ok = $ok && $model->save() && $modPenawaran->save(); 
                    if(!empty($files["tmp_name"]['penawaranpenyedia_file'])){
                        
                        if (!file_exists(Params::pathPenawaranPenyediaFileDirectory())){
                            mkdir(Params::pathPenawaranPenyediaFileDirectory(), 0775, true);
                        }
                        
                        move_uploaded_file(
                            $files["tmp_name"]['penawaranpenyedia_file'], 
                                Params::pathPenawaranPenyediaFileDirectory().$name
                            );
                    }
                    
                    if(!empty($files2["tmp_name"]['dokumen_pendukung'])){
                        
                        if (!file_exists(Params::pathPenawaranPenyediaFileDirectory())){
                            mkdir(Params::pathPenawaranPenyediaFileDirectory(), 0775, true);
                        }
                        
                        move_uploaded_file(
                            $files2["tmp_name"]['dokumen_pendukung'], 
                                Params::pathPenawaranPenyediaFileDirectory().$name_2
                            );
                    }
                    
                }
                
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'id' => $_GET['id'], 'sukses' => 1));
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
                'modSupplier' => $modSupplier, 
                'disable' => $disable, 
                'disablePejabat' => $disablePejabat,
                'disableSupplier' => $disableSupplier,
                'model' => $model, 
                'modInformasi'=>$modInformasi,
                'modPenawaran' => $modPenawaran));
    }
    
    /**
     * Unduh file penawaran penyedia
     * @param type $penawaranpenyedia_id
     */
    public function actionUnduh($penawaranpenyedia_id) {
        $filename = PenawaranpenyediaT::model()->findByPk($penawaranpenyedia_id);
        $path = Params::pathPenawaranPenyediaFileDirectory().$filename->penawaranpenyedia_file;
        if (!empty($filename->penawaranpenyedia_file)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->penawaranpenyedia_file, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));   
        }
    }
    
    /**
     * Unduh file penawaran penyedia
     * @param type $penawaranpenyedia_id
     */
    public function actionUnduhDokumen($infoumumpengadaan_id) {
        $filename = InfoumumpengadaanT::model()->findByPk($infoumumpengadaan_id);
        $path = Params::pathPenawaranPenyediaFileDirectory()."/".$filename->dokumen_pendukung;
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
    
    /**
     * Autocomplete pegawai berdasarkan pejabat pengadaan = "Pejabat Pengadan"
     */
    public function actionGetPegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            $returnVal = array();
            if (isset($_GET['pegawai_id'])) {
                if (!empty($_GET['pegawai_id'])) {
                    $criteria->addCondition("pegawai_id = " . $_GET['pegawai_id']);
                }
            }
            $criteria->join = "LEFT JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id";
            $criteria->addCondition("jabatan_pengadaan ilike '%Pejabat Pengadaan%'");
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition(" pegawai_aktif = TRUE ");
            $criteria->order = 'nama_pegawai ASC';
            $criteria->select = "t.*, pegawai_m.*";
            $criteria->limit = 10;
            $models = PejabatpengadaanM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $modPegawai = PegawaiV::model()->findByAttributes(array('pegawai_id' => $model->pegawai_id));
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->nama_pegawai;
                $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                $returnVal[$i]['jabatan_pengadaan'] = $model->jabatan_pengadaan;
                $returnVal[$i]['tgl_sk'] = MyFormatter::formatDateTimeForUser($model->tgl_sk);
                $returnVal[$i]['no_sk'] = $model->no_sk;
                $returnVal[$i]['value'] = $model->pegawai_id;
                if (!empty($model->jabatan_id)) {
                    $returnVal[$i]['jabatan_nama'] = JabatanM::model()->findByPk($model->jabatan_id)->jabatan_nama;
                } else {
                    $returnVal[$i]['jabatan_nama'] = '';
                }
                $returnVal[$i]['nosk'] = $modPegawai->getNoKeputusan();
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * generate kabupaten dari nama propinsi
     * @param type $encode
     * @param type $namaModel
     * @param type $attr
     */
    public function actionGetKabupatendrNamaPropinsi($encode = false, $namaModel = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            if ($namaModel == '' && $attr !== '') {
                $propinsi_nama = $_POST["$attr"];
            } elseif ($namaModel !== '' && $attr !== '') {
                $propinsi_nama = $_POST["$namaModel"]["$attr"];
            }
           
            $propinsi = PropinsiM::model()->findByAttributes(array('propinsi_nama' => $propinsi_nama));
            
            $propinsi_id = $propinsi->propinsi_id;
             
            if (!empty($propinsi) ) {
                $propinsi_id = $propinsi_id;
            }
            $kabupaten = KabupatenM::model()->findAll("propinsi_id='$propinsi_id' ORDER BY kabupaten_nama asc");
            $kabupaten = CHtml::listData($kabupaten, 'kabupaten_nama', 'kabupaten_nama');
            
            if ($encode) {
                echo CJSON::encode($kabupaten);
            } else {
                if (empty($kabupaten)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($kabupaten as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
}