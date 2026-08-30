<?php
/**
 * Controller untuk Addendum SPK
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class AddendumSPKController extends MyAuthController {

    public $path_view = 'pengadaan.views.suratPerjanjianKerja.';

    /**
     * Halaman index 
     * @param type $suratperjanjiankerja_id
     * @param type $transaksi
     */
    public function actionIndex($suratperjanjiankerja_id, $transaksi = null, $spk = null) {
        $model = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        $modTermin = new SuratperjanjiankerjaterminT();
        $modTermin2 = new ADSuratperjanjiankerjaterminT();
        
        if (!empty($model->penawaranpenyedia_id)) {
            $model->cekpenawaran = true;
        } else {
            $model->cekpenawaran = false;
        }
        $model->suratundanganpl_tanggal = MyFormatter::formatDateTimeForUser($model->suratundanganpl_tanggal);
        $model->bahasilpl_tanggal = MyFormatter::formatDateTimeForUser($model->bahasilpl_tanggal);
        $model->tgl_dpa = MyFormatter::formatDateTimeForUser($model->tgl_dpa);
        $modPengadaan = PersiapanpengadaanT::model()->findByPk($model->persiapanpengadaan_id);
        $modPengadaan->namaunitkerja = $modPengadaan->unitkerja->namaunitkerja;
        if (!empty($transaksi)) {
            $model->nosuratperjanjiankerja = "-- Otomatis --";
            $model->nomor_dokumen = "";
            $model->tglsuratperjanjian = "";
            $model->istermin = false;
            $model->jenis_termin = "";
            $modPengadaan->pelaksanaankontrak_tglawal = MyFormatter::formatDateTimeForUser($modPengadaan->pelaksanaankontrak_tglawal);
            $modPengadaan->pelaksanaankontrak_tglakhir = MyFormatter::formatDateTimeForUser($modPengadaan->pelaksanaankontrak_tglakhir);
        } else {
            $modNomor = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id), array('order' => 'nomor_urut desc'));
            $model->suratperjanjiankerjaasal_id = $modNomor->suratperjanjiankerja_id; // SPK asal dari 1 SPK yang sebelumnya 
            $model->nomor_urut = $modNomor->nomor_urut + 1;
            $modCariTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerjaasal_id));
            $modTermin2->jumlah_termin = count($modCariTermin);
            $modPengadaan->pelaksanaankontrak_tglawal = MyFormatter::formatDateTimeForUser($model->tglawal_pekerjaan);
            $modPengadaan->pelaksanaankontrak_tglakhir = MyFormatter::formatDateTimeForUser($model->tglakhir_pekerjaan);
        }
        
        if (!empty($modPengadaan->subkegiatanprogram_id)) {
            $cekSubKegiatan = SubkegiatanprogramM::model()->findByPk($modPengadaan->subkegiatanprogram_id);
            $subkegiatanprogram_id = $cekSubKegiatan->subkegiatanprogram_id;
            $subkegiatanprogram_nama = $cekSubKegiatan->subkegiatanprogram_kode . " - " . $cekSubKegiatan->subkegiatanprogram_nama;
            if (!empty($cekSubKegiatan->kegiatanprogram_id)) {
                $cekKegiatanprogram = KegiatanprogramM::model()->findByPk($cekSubKegiatan->kegiatanprogram_id);
                if (!empty($cekKegiatanprogram)) {
                    $kegiatanprogram_nama = $cekKegiatanprogram->kegiatanprogram_kode . " - " . $cekKegiatanprogram->kegiatanprogram_nama;
                    $kegiatanprogram_id = $cekKegiatanprogram->kegiatanprogram_id;
                    //$koderek = $kegiatanprogram_nama;
                    $cekSubprogramkerja = SubprogramkerjaM::model()->findByPk($cekKegiatanprogram->subprogramkerja_id);
                    if (!empty($cekSubprogramkerja)) {
                        $subprogramkerja_nama = $cekSubprogramkerja->subprogramkerja_nama;
                        $cekProgramkerja = ProgramkerjaM::model()->findByPk($cekSubprogramkerja->programkerja_id);
                        if (!empty($cekProgramkerja)) {
                            $programkerja_nama = $cekProgramkerja->programkerja_kode . " - " . $cekProgramkerja->programkerja_nama;
                            $programkerja_id = $cekProgramkerja->programkerja_id;
                        }
                    }
                }
            }
        } else {
            $subkegiatanprogram_nama = '-';
            $programkerja_nama = '-';
            $subprogramkerja_nama = '-';
            $programkerja_id = '-';
            $subprogramkerja_id = '-';
        }

        if (!empty($modPengadaan->rencanaumumpengadaan_id)) {
            $cekMapping = PengadaansumberdanaT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $modPengadaan->rencanaumumpengadaan_id));
            $koderek = $cekMapping->mappingrekeninganggaran->kodeanggaran . ' - ' . $cekMapping->mappingrekeninganggaran->nama_rekeninganggaran5;
            $mappingrekeninganggaran_id = $cekMapping->mappingrekeninganggaran_id;
        } else {
            $koderek = '-';
            $mappingrekeninganggaran_id = '';
        }
        $cekPersiapandet = PersiapanpengadaandetT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
        if (!empty($cekPersiapandet)) {
            $cekdokumendet = DokumenpelaksanaananggarandetT::model()->findByAttributes(array('dokumenpelaksanaananggarandet_id' => $cekPersiapandet->dokumenpelaksanaananggarandet_id));
            if (!empty($cekdokumendet)) {
                $cekNoDpa = DokumenpelaksanaananggaranT::model()->findByPk($cekdokumendet->dokumenpelaksanaananggaran_id);
                if (!empty($cekNoDpa)) {
                    $model->no_dpa = $cekNoDpa->no_dpa;
                } else {
                    $model->no_dpa = '';
                }
            } else {
                $model->no_dpa = '';
            }
        } else {
            $model->no_dpa = '';
        }
        $model->programkerja_nama = $programkerja_nama;
        $model->kegiatanprogram_nama = $kegiatanprogram_nama;
        $model->subprogramkerja_nama = $subkegiatanprogram_nama;

        $model->kegiatanprogram_id = $kegiatanprogram_id;
        $model->subkegiatanprogram_id = $subkegiatanprogram_id;
        $model->nmrekening5 = $koderek;
        $model->rekening5_id = null;
        $model->mappingrekeninganggaran_id = $mappingrekeninganggaran_id;
        $model->nilaikontrak = MyFormatter::formatNumberForPrint($model->nilaikontrak, 2);

        $model->supplier_nama = $model->supplier->supplier_nama;
        $model->nama_supplier = $model->supplier->direktursupplier;
        $model->alamat_supplier = $model->supplier->supplier_alamat;
        $model->nomor_rekening = $model->supplier->supplier_norekening;

        $modDet = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));

        if (isset($_POST['SuratperjanjiankerjaT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $modSPK = new SuratperjanjiankerjaT();
                $modSPK->attributes = $model->attributes;
                $modSPK->attributes = $_POST['SuratperjanjiankerjaT'];
                $modSPK->nosuratperjanjiankerja = MyGenerator::NoSuratPerjanjianKerja();
                $modSPK->tglputusanpenggunaanggaran = MyFormatter::formatDateTimeForDB($modSPK->tglputusanpenggunaanggaran);
                $modSPK->tgl_dpa = MyFormatter::formatDateTimeForDB($modSPK->tgl_dpa);
                $modSPK->tglpenawaran = MyFormatter::formatDateTimeForDB($modSPK->tglpenawaran);
                $modSPK->tglsuratperjanjian = MyFormatter::formatDateTimeForDB($modSPK->tglsuratperjanjian);
                $modSPK->tglawal_pekerjaan = MyFormatter::formatDateTimeForDB($_POST['PersiapanpengadaanT']['pelaksanaankontrak_tglawal']);
                $modSPK->tglakhir_pekerjaan = MyFormatter::formatDateTimeForDB($_POST['PersiapanpengadaanT']['pelaksanaankontrak_tglakhir']);
                $modSPK->suratundanganpl_tanggal = MyFormatter::formatDateTimeForDB($_POST['SuratperjanjiankerjaT']['suratundanganpl_tanggal']);
                $modSPK->bahasilpl_tanggal = MyFormatter::formatDateTimeForDB($_POST['SuratperjanjiankerjaT']['bahasilpl_tanggal']);
                $modSPK->suratperjanjiankerja_status = 'SPK Diterbitkan';
                $modSPK->create_time = date('Y-m-d H:i:s');
                $modSPK->create_loginpemakai_id = Yii::app()->user->id;
                $modSPK->create_ruangan = Yii::app()->user->getState('ruangan_id');

                $modNomor = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id), array('order' => 'nomor_urut desc'));
                $modSPK->suratperjanjiankerjaasal_id = $modNomor->suratperjanjiankerja_id; // SPK asal dari 1 SPK yang sebelumnya 
                $modSPK->nomor_urut = $modNomor->nomor_urut + 1;
                
                // Update isaddendum SPK sebelumnya menjadi false 
                $modCari = SuratperjanjiankerjaT::model()->findAllByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
                if (!empty($modCari)) {
                    foreach($modCari as $det){
                        $det->isaddendum = false;
                        $ok = $ok && $det->update();
                    }
                }
                
                $modSPK->isaddendum = true;
                                
                $ok = $ok && $modSPK->save();
                if (isset($_POST['SuratperjanjiankerjarincianT'])) {
                    foreach ($_POST['SuratperjanjiankerjarincianT']['detail'] as $key => $value) {
                        $modDet = new SuratperjanjiankerjarincianT;
                        $modDet->attributes = $value;
                        $modDet->suratperjanjiankerja_id = $modSPK->suratperjanjiankerja_id;
                        $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($modDet->dokumenpelaksanaananggarandet_id);
                        $modDPA->sisapagu_pengadaan = $value['sisa_pagu'] - $modDet->barang_total;
                        $modDPA->sisavolume_pengadaan = $value['sisa_volume'] - $modDet->barang_jumlah;
                        $ok = $ok && $modDet->save() && $modDPA->update();
                    }
                }

                if ($_POST['SuratperjanjiankerjaT']['istermin'] == 1) {
                    foreach ($_POST['SuratperjanjiankerjaterminT'] as $i => $mod) {
                        $modTermin = new SuratperjanjiankerjaterminT();
                        $modTermin->attributes = $mod;
                        $modTermin->suratperjanjiankerja_id = $modSPK->suratperjanjiankerja_id;
                        if ($mod['termintanggal_awal'] == "") {
                            $modTermin->termintanggal_awal = null;
                        } else {
                            $modTermin->termintanggal_awal = MyFormatter::formatDateTimeForDB($mod['termintanggal_awal']);
                        }
                        if ($mod['termintanggal_akhir'] == "") {
                            $modTermin->termintanggal_akhir = null;
                        } else {
                            $modTermin->termintanggal_akhir = MyFormatter::formatDateTimeForDB($mod['termintanggal_akhir']);
                        }
                        $ok = $ok && $modTermin->save();
                    }
                } else {
                    $modTermin = new SuratperjanjiankerjaterminT();
                    $modTermin->suratperjanjiankerja_id = $modSPK->suratperjanjiankerja_id;
                    $modTermin->terminke = 'I';
                    $modTermin->jumlah_persen = '100';
                    $modTermin->jumlah_harga = $model->total_pembulatan;
                    $modTermin->urutan = '1';
                    $modTermin->termintanggal_awal = MyFormatter::formatDateTimeForDB($_POST['PersiapanpengadaanT']['pelaksanaankontrak_tglawal']);
                    $modTermin->termintanggal_akhir = MyFormatter::formatDateTimeForDB($_POST['PersiapanpengadaanT']['pelaksanaankontrak_tglakhir']);
                    $ok = $ok && $modTermin->save();
                }
                
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id, 'sukses' => 1));
                } else {

                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render('index', array('model' => $model, 'modPengadaan' => $modPengadaan, 'modDet' => $modDet, 'modTermin' => $modTermin, 'modTermin2' => $modTermin2));
    }
    
    /**
     * Autocomplete untuk mengambil data pegawai untuk field Kuasa Pengguna Anggaran.
     * 
     * @param string $term nama kuasa yang dicari.
     */
    public function actionAutocompleteKuasaPengguna($term = "") {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $modKuasa = new PejabatpengadaanM('searchDialogKPA');
        $modKuasa->unsetAttributes();
        $modKuasa->nama_pegawai = $term;

        $prov = $modKuasa->searchDialogKPA();
        $prov->sort->defaultOrder = 'nama_pegawai';
        $prov->criteria->limit = 15;

        $res = array();

        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->pegawai->namaLengkap;
            $sub['value'] = $item->pegawai_id;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }
    
    /**
     * Autocomplete untuk mengambil data pegawai untuk field PPK
     * 
     * @param string $term nama PPK yang dicari.
     */
    public function actionAutocompletePegawaiPPK($term = "") {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $modKuasa = new PejabatpengadaanM('searchDialogPPK');
        $modKuasa->unsetAttributes();
        $modKuasa->nama_pegawai = $term;

        $prov = $modKuasa->searchDialogPPK();
        $prov->sort->defaultOrder = 'nama_pegawai';
        $prov->criteria->limit = 15;

        $res = array();

        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->pegawai->namaLengkap;
            $sub['value'] = $item->pegawai_id;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }
    
    /**
     * digunakan untuk men set dokumenpelaksaananggarandet_id yang dipilih
     */
    public function actionSetDokumenDet() {
        if (Yii::app()->request->isAjaxRequest) {
            $dokumenpelaksanaananggarandet_id = isset($_POST['dokumenpelaksanaananggarandet_id']) ? $_POST['dokumenpelaksanaananggarandet_id'] : null;
            $jenis = isset($_POST['jenis_trans']) ? $_POST['jenis_trans'] : null;
            $html = '';
            if (!empty($dokumenpelaksanaananggarandet_id)) {
                $cri = new CDbCriteria();
                $cri->addInCondition("dokumenpelaksanaananggarandet_id", $dokumenpelaksanaananggarandet_id);
                $cri->addCondition('pengadaan_status IS FALSE');
                $modDokumen = DokumenpelaksanaananggarandetT::model()->findAll($cri);

                foreach ($modDokumen as $dok) {
                    $modDetail = new SuratperjanjiankerjarincianT();
                    $modDetail->attributes = $dok; 
                    $modDetail->jenis_barang = $dok->jenis_barang;
                    $modDetail->nama_dpa = $dok->uraian;
                    $modDetail->barang_id = $dok->barang_id;
                    $modDetail->dokumenpelaksanaananggarandet_id = $dok->dokumenpelaksanaananggarandet_id;
                    $modDetail->barang_nama = ($modDetail->jenis_barang == 'Farmasi') ? "" : $modDetail->nama_dpa;
                    $modDetail->barang_satuan = $dok->satuan;
                    $modDetail->barang_harga = $dok->jumlah;
                    $modDetail->barang_jumlah = $dok->volume;
                    $modDetail->barang_total = $dok->harga_satuan;
                    $modDetail->sisa_pagu = $dok->sisapagu_pengadaan;
                    $modDetail->sisa_volume = $dok->sisavolume_pengadaan;
                    $html .= $this->renderPartial('_rowHPSBaru', array('model' => $modDetail, 'i' => 1), true);
                }
            }
            $data['sukses'] = 1;
            $data['html'] = $html;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    public function actionDelete($suratperjanjiankerjarincian_id, $dokumenpelaksanaananggarandet_id){
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $ok = true;
                $modRincian = SuratperjanjiankerjarincianT::model()->findByPk($suratperjanjiankerjarincian_id);
                $modSisaPagu = SisapagukontrakV::model()->findByAttributes(array('suratperjanjiankerja_id' => $modRincian->suratperjanjiankerja_id, 'dokumenpelaksanaananggarandet_id' => $dokumenpelaksanaananggarandet_id));
                $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($dokumenpelaksanaananggarandet_id);
                $modDPA->sisapagu_pengadaan = $modSisaPagu->sisapagu_kontrak;
                $modDPA->sisavolume_pengadaan = $modRincian->barang_jumlah;
                if ($modDPA->sisapagu_pengadaan > 0) {
                    $modDPA->pengadaan_status = false;
                }
                $ok = $ok && $modDPA->update();
                
                if ($ok) {
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                } else {
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data tidak dapat dihapus";
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data tidak dapat dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
}