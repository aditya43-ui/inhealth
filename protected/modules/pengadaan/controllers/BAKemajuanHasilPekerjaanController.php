<?php

/**
 * Transaksi Berita Acara Kemajuan Hasil Pekerjaan
 * 
 * @author Andyka Putra <andykaputra@.com>
 * @author  Aida Rahmawati <aidarahmawati@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class BAKemajuanHasilPekerjaanController extends MyAuthController {

    /**
     * Default Transaksi Kemajuan Hasil Pekerjaan
     * 
     * @param type $suratperjanjiankerja_id
     * @param type $bakemajuanhasilpekerjaan_id
     */
    public function actionIndex($suratperjanjiankerja_id, $bakemajuanhasilpekerjaan_id = null) {
        $this->layout = '//layouts/iframe';
        $model = new BakemajuanhasilpekerjaanT;
        $modelDetail = new BakemajuanhasilpekerjaandetT;
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        $modSPKRincian = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
        $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
        
        
        if (!empty($modSPK->pejabatpembuatkomitmen_id)) {
            $modPegawai = PegawaiM::model()->findByPk($modSPK->pejabatpembuatkomitmen_id);
            $models = BakemajuanhasilpekerjaanT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));

            $model = new BakemajuanhasilpekerjaanT;
            $model->bakemajuanhasilpekerjaan_nomor = "-- Otomatis --";
//            $modKPA = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $modSPK->kuasapenggunaanggaran_id, 'pejabatpengadaan_aktif' => true, 'jabatan_pengadaan' => 'KPA'));
//                $modPPK = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $modSPK->pejabatpembuatkomitmen_id, 'pejabatpengadaan_aktif' => true, 'jabatan_pengadaan' => 'PPK'));
//                if (!empty($modPPK)) {
//                    $modPPK->kode_dokumen = !empty($modPPK->kode_dokumen) ? $modPPK->kode_dokumen : null;
//                } else {
//                    $modPPK->kode_dokumen = null;
//                }
//                
//                if (!empty($modKPA)) {
//                    $modKPA->kode_dokumen = !empty($modKPA->kode_dokumen) ? $modKPA->kode_dokumen : null;
//                } else {
//                    $modKPA->kode_dokumen = null;
//                }
//                
//                $nomorsurat = MyGenerator::nomorBAKemajuanHasilPekerjaan($model->bakemajuanhasilpekerjaan_tanggal, $modKPA->kode_dokumen, $modPPK->kode_dokumen); 
//                $model->nomor_beritaacara = $nomorsurat['nosurat'];
//                $model->nomor_urut = $nomorsurat['nourut'];
//            $model->nomor_beritaacara = '-- Otomatis --'; // Generator nomor BA di-nonaktifkan di RSST-10126
            $model->tahap_pekerjaan = count($models) + 1;
            $model->bakemajuanhasilpekerjaan_tanggal = date('d M Y H:i:s');
            $model->pihakkesatu_jabatan = "Pejabat Pembuat Komitmen RSUD Dr. Soetomo";
            $model->pegpihakkesatu_id = $modPegawai->pegawai_id;
            $model->pegpihakkesatu_nama = $modPegawai->nama_pegawai;
            $model->pegpihakkesatu_nip = $modPegawai->nomorindukpegawai;
            $model->pegpihakkesatu_alamat = $modPegawai->alamat_pegawai;
            
            $model->termin_terminke = (!empty($cekTermin)) ? count($models) + 1 : 1;
            $model->termin_jumlah = count($cekTermin);
            $model->terminke = CustomFunction::Romawi($model->termin_terminke);
        }

        if (!empty($modSPK->supplier_id)) {
            $modSupplier = SupplierM::model()->findByPk($modSPK->supplier_id);
            $model->supplier_id = $modSupplier->supplier_id;
            $model->supplier_nama = $modSupplier->supplier_nama;
            $model->direktur = $modSupplier->direktursupplier;
            $model->alamat_penyedia = $modSupplier->supplier_alamat;
        }
        
        if (!empty($bakemajuanhasilpekerjaan_id)) {
            $model = BakemajuanhasilpekerjaanT::model()->findByPk($bakemajuanhasilpekerjaan_id);
            $model->pegpihakkesatu_nama = $model->pegpihakkesatu->nama_pegawai;
            $model->pegpihakkesatu_nip = $model->pegpihakkesatu->nomorindukpegawai;
            $model->pegpihakkesatu_alamat = $model->pegpihakkesatu->alamat_pegawai;
            
            $modSupplier = SupplierM::model()->findByPk($model->supplier_id);
            $model->supplier_id = $modSupplier->supplier_id;
            $model->supplier_nama = $modSupplier->supplier_nama;
            $model->direktur = $modSupplier->direktursupplier;
            $model->alamat_penyedia = $modSupplier->supplier_alamat;
        }

        if (isset($_POST['BakemajuanhasilpekerjaanT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $model->attributes = $_POST['BakemajuanhasilpekerjaanT'];
                $model->suratperjanjiankerja_id = $suratperjanjiankerja_id;
                $modTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'terminke' => $model->terminke)); 
                $model->termin_persen = $modTermin->jumlah_persen; 
                $model->bakemajuanhasilpekerjaan_tanggal = MyFormatter::formatDateTimeForDb($model->bakemajuanhasilpekerjaan_tanggal);
                $model->bakemajuanhasilpekerjaan_nomor = MyGenerator::noBAKemajuanHasilPekerjaan();
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
                // Generator nomor BA di-nonaktifkan di RSST-10126
//                $nomorsurat = MyGenerator::nomorBAKemajuanHasilPekerjaan($model->bakemajuanhasilpekerjaan_tanggal, $modKPA->kode_dokumen, $modPPK->kode_dokumen); 
//                $model->nomor_beritaacara = $nomorsurat['nosurat'];
//                $model->nomor_urut = $nomorsurat['nourut'];
                $model->nomor_urut = '000';
                $tanggal = MyFormatter::formatDateTimeForDb(date("d m Y"));
                $tanggalbeli = MyFormatter::formatDateTimeForDb(date("d m Y", strtotime($model->bakemajuanhasilpekerjaan_tanggal)));
                if ($tanggalbeli < $tanggal) {
                    $model->isantidatir = true;
                }
                
                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');
                
                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if (!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->bakemajuanhasilpekerjaan_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathberitaAcaraDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathberitaAcaraDirectory())){
                        mkdir(Params::pathberitaAcaraDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = BakemajuanhasilpekerjaanT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }
                $ok = $ok && $model->save();
                if (isset($_POST['BakemajuanhasilpekerjaandetT']) && $ok) {
                    foreach ($_POST['BakemajuanhasilpekerjaandetT'] as $key => $value) {
                        $modelDetail = new BakemajuanhasilpekerjaandetT;
                        $modelDetail->attributes = $value;
                        $modelDetail->bakemajuanhasilpekerjaan_id = $model->bakemajuanhasilpekerjaan_id;
                        $ok = $ok && $modelDetail->save();
                    }
                }
                
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'bakemajuanhasilpekerjaan_id' => $model->bakemajuanhasilpekerjaan_id, 'sukses' => 1));
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
     * Digunakan untuk edit data Transaksi Kemajuan Hasil Pekerjaan
     * @param type $id
     * @param type $suratperjanjiankerja_id
     */
    public function actionUbah($id, $suratperjanjiankerja_id) {
        $this->layout = '//layouts/iframe';

        $model = BakemajuanhasilpekerjaanT::model()->findByPk($id);
        $modelDetail = BakemajuanhasilpekerjaandetT::model()->findAllByAttributes(array('bakemajuanhasilpekerjaan_id' => $id));
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        $modSPKRincian = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));

        $model->pegpihakkesatu_nama = $model->pegpihakkesatu->nama_pegawai;
        $model->pegpihakkesatu_nip = $model->pegpihakkesatu->nomorindukpegawai;
        $model->pegpihakkesatu_alamat = $model->pegpihakkesatu->alamat_pegawai;
        $model->bakemajuanhasilpekerjaan_tanggal = date("d M Y H:i:s", strtotime($model->bakemajuanhasilpekerjaan_tanggal));
        $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));

        $modSupplier = SupplierM::model()->findByPk($model->supplier_id);
        $model->supplier_id = $modSupplier->supplier_id;
        $model->supplier_nama = $modSupplier->supplier_nama;
        $model->direktur = $modSupplier->direktursupplier;
        $model->alamat_penyedia = $modSupplier->supplier_alamat;
        if($model->terminke == 'I'){
            $model->termin_terminke = 1;  
        }else if($model->terminke == 'II'){
            $model->termin_terminke = 2;  
        }else if($model->terminke == 'III'){
            $model->termin_terminke = 3;  
        } 
        $model->termin_jumlah = count($cekTermin);
        if (isset($_POST['BakemajuanhasilpekerjaanT'])) {

            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {

                $model->attributes = $_POST['BakemajuanhasilpekerjaanT'];
                $model->suratperjanjiankerja_id = $suratperjanjiankerja_id;
                $model->bakemajuanhasilpekerjaan_tanggal = MyFormatter::formatDateTimeForDb($model->bakemajuanhasilpekerjaan_tanggal);
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->update_time = date('Y-m-d H:i:s');

                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');
                
                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if (!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->bakemajuanhasilpekerjaan_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathberitaAcaraDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathberitaAcaraDirectory())){
                        mkdir(Params::pathberitaAcaraDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = BakemajuanhasilpekerjaanT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }
                
                $ok = $ok && $model->save();

                if (isset($_POST['BakemajuanhasilpekerjaandetT']) && $ok) {
                    foreach ($_POST['BakemajuanhasilpekerjaandetT'] as $key => $value) {
                        $modelDetail = BakemajuanhasilpekerjaandetT::model()->findByAttributes(array('bakemajuanhasilpekerjaandet_id'=>$value['bakemajuanhasilpekerjaandet_id']));
                        $modelDetail->attributes = $value;
                        $modelDetail->bakemajuanhasilpekerjaan_id = $model->bakemajuanhasilpekerjaan_id;
                        $ok = $ok && $modelDetail->update();
                    }
                }
                
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'bakemajuanhasilpekerjaan_id' => $model->bakemajuanhasilpekerjaan_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render('_ubah', array(
            'model' => $model,
            'modelDetail' => $modelDetail,
            'modSPK' => $modSPK,
            'modSPKRincian' => $modSPKRincian));
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
     * Menampilkan tabel riwayat Kemajuan Hasil Pekerjaan
     */
    public function actionGetKHP() {
        if (Yii::app()->request->isAjaxRequest) {
            $suratperjanjiankerja_id = $_POST['suratperjanjiankerja_id'];
            $modKHP = BakemajuanhasilpekerjaanT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id), array('order' => 'bakemajuanhasilpekerjaan_id'));
            $i = 1;
            $tr = '';
            foreach ($modKHP as $row) {
                $termin = "";
                $modPegawai = PegawaiM::model()->findByPk($row->pegpihakkesatu_id);
                $modSupplier = SupplierM::model()->findByPk($row->supplier_id);
                $modSurat = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
                if($modSurat->istermin == true){
                    $termin = $row->terminke . ' (' . $row->termin_persen . '%)';
                }else{
                    $termin = 'Non Termin';
                }
                $urlDetail = $this->createUrl('Detail', array('id' => $row->bakemajuanhasilpekerjaan_id, 'suratperjanjiankerja_id' => $suratperjanjiankerja_id, ));
                $urlEdit = $this->createUrl('Ubah', array('id' => $row->bakemajuanhasilpekerjaan_id, 'suratperjanjiankerja_id' => $suratperjanjiankerja_id));
                $tr .= '<tr>';
                    $tr .= '<td>' . $i . ' </td>';
                    $tr .= '<td>' . CHtml::link($row->bakemajuanhasilpekerjaan_nomor, $urlDetail, array('title' => 'Detail', 'rel' => 'tooltip',"target"=>"iframe1", "onclick"=>"$('#dialogRiwayat').dialog('open');")).'</td>';
                    $tr .= '<td>' . $row->nomor_beritaacara . '</td>';
                    $tr .= '<td>' . date("d M Y H:i:s", strtotime($row->bakemajuanhasilpekerjaan_tanggal)).' </td>';
                    $tr .= '<td>' . $termin . '</td>';
                    $tr .= '<td>' . $row->tahap_pekerjaan . '</td>';
                    $tr .= '<td>' . $modPegawai->nama_pegawai . '</td>';
                    $tr .= '<td>' . $row->pihakkesatu_jabatan . '</td>';
                    $tr .= '<td>' . $modSupplier->direktursupplier . '</td>';
                    $tr .= '<td>Direktur</td>';
                    $tr .= '<td>' . CHtml::link('<i class="entypo-pencil"></i>', $urlEdit, array('title' => 'Ubah Data', 'rel' => 'tooltip', 'onclick' => 'setUbahForm(' . $row->bakemajuanhasilpekerjaan_id, $row->suratperjanjiankerja_id . '); return false')) . '</td>';
                    $tr .= '<td>' . CHtml::link('<i class="entypo-print"></i>', '#', array('title' => 'Cetak Dokumen', 'rel' => 'tooltip','onclick'=>"window.open('" . $this->createUrl('print', array('id' => $row->bakemajuanhasilpekerjaan_id)) ."', 'printwin', 'left=100,top=100,width=790,height=1120')")) . '</td>';
                    
                $tr .= '</tr>';
                $i++;
            }

            $data['tr'] = $tr;

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Detail Kemajuan Hasil Pekerjaan
     * @param type $id
     * @param type $suratperjanjiankerja_id
     */
    public function actionDetail($id, $suratperjanjiankerja_id){
        $this->layout = '//layouts/iframe';
        $model = BakemajuanhasilpekerjaanT::model()->findByPk($id);
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id); 
        $modelDetail = BakemajuanhasilpekerjaandetT::model()->findAllByAttributes(array('bakemajuanhasilpekerjaan_id' => $id));
        $modSPKRincian = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
        $model->pegpihakkesatu_nama = $model->pegpihakkesatu->nama_pegawai;
        $model->pegpihakkesatu_nip = $model->pegpihakkesatu->nomorindukpegawai;
        $model->pegpihakkesatu_alamat = $model->pegpihakkesatu->alamat_pegawai;
        $model->bakemajuanhasilpekerjaan_tanggal = date("d M Y H:i:s", strtotime($model->bakemajuanhasilpekerjaan_tanggal));
        $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));

        $modSupplier = SupplierM::model()->findByPk($model->supplier_id);
        $model->supplier_id = $modSupplier->supplier_id;
        $model->supplier_nama = $modSupplier->supplier_nama;
        $model->direktur = $modSupplier->direktursupplier;
        $model->alamat_penyedia = $modSupplier->supplier_alamat;
        if($model->terminke == 'I'){
            $model->termin_terminke = 1;  
        }else if($model->terminke == 'II'){
            $model->termin_terminke = 2;  
        }else if($model->terminke == 'III'){
            $model->termin_terminke = 3;  
        }
        $model->termin_jumlah = count($cekTermin);
        $this->render('_detail', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'modSPKRincian' => $modSPKRincian)); 
    }

    /**
     * Cetak Berita Acara Kemajuan Hasil Pekerjaan
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $model = BakemajuanhasilpekerjaanT::model()->findByPk($id);
        $modelDetail = BakemajuanhasilpekerjaandetT::model()->findAllByAttributes(array('bakemajuanhasilpekerjaan_id' => $id));
        $sup = SupplierM::model()->findByPk($model->supplier_id);
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        if ($modSPK->istermin == true) {
            $criteria->addCondition("konfigtemplatesurat_nama = 'BA Kemajuan Hasil Pekerjaan - Termin'");
        } else {
            $criteria->addCondition("konfigtemplatesurat_nama = 'BA Kemajuan Hasil Pekerjaan'");
        }        
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);
        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{ba_hari}}", ucwords(MyFormatter::getDayName(date('D', strtotime($model->bakemajuanhasilpekerjaan_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->bakemajuanhasilpekerjaan_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_bulan_terbilang}}", MyFormatter::getMonthId(date('m', strtotime($model->bakemajuanhasilpekerjaan_tanggal))), $isiPesan);
                $isiPesan = str_replace("{{ba_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->bakemajuanhasilpekerjaan_tanggal)))), $isiPesan);
            }
            
            $modSupplier = SupplierM::model()->findByPk($model->supplier_id);
            $attributes = $modSupplier->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            
            $cekPegawai = PegawaiM::model()->findByPk($model->pegpihakkesatu_id);
            $attributes = $cekPegawai->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            
            $cekSuratPerjanjian = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
            $attributes = $cekSuratPerjanjian->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{tglsuratperjanjian}}", date('d ', strtotime($cekSuratPerjanjian['tglsuratperjanjian'])) . MyFormatter::getMonthId(date('m', strtotime($cekSuratPerjanjian['tglsuratperjanjian']))) . date(' Y', strtotime($cekSuratPerjanjian['tglsuratperjanjian'])), $isiPesan);
            }
        }
        $model->isi_surat = $isiPesan;

        $this->render('print', array('model' => $model,'sup'=>$sup, 'modelDetail'=>$modelDetail,'cekSuratPerjanjian'=>$cekSuratPerjanjian));
    }
    
    /**
     * Fungsi unduh dokumen pendukung
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = BakemajuanhasilpekerjaanT::model()->findByPk($id);
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
