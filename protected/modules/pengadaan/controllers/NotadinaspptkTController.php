<?php

/**
 * Transaksi Nota Dinas PPTK
 * Terdapat 2 jenis yaitu : Dengan PPH22 dan Tanpa PPH22. 
 * Per 20 Februari sudah diganti dengan Penyedia dan Swakelola
 * Masing-masing memiliki input form yang bebeda
 * 
 * @author Andyka Putra <andykaputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class NotadinaspptkTController extends MyAuthController {

    /**
     * Menu Transaksi Nota Dinas PPTK 
     * @param type $notadinaspptk_id
     * @param type $persiapanpengadaan_id
     * @param type $ubah
     */
    public function actionIndex($notadinaspptk_id = null, $ubah = null) {
        $model = new NotadinaspptkT;
        $modDetail = new NotadinaspptkdetT;
        $format = new MyFormatter();
        $model->notadinaspptk_nomor = '--Otomatis--';
        $model->notadinaspptk_tanggal = date('d M Y H:i:s');
        $model->kategori_pengadaan = 1;
        $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->pegpptk_id = $modPegawai->pegawai_id;
        $model->pegpptk_nama = $modPegawai->namaLengkap;
        if (!empty($notadinaspptk_id)) {
            $model = NotadinaspptkT::model()->findByPk($notadinaspptk_id);
            $modDetail = NotadinaspptkdetT::model()->findAllByAttributes(array('notadinaspptk_id' => $notadinaspptk_id));
            $model->ispph22 = $model->ispph22;
            $model->pegpptk_nama = $model->pegpptk->namaLengkap;
            $model->pegppk_nama = $model->pegppk->namaLengkap;
            $model->pegpjk_nama = $model->pegpjk->namaLengkap;
            $model->pegpjk_unitkerja = $model->pegpjk->unitkerja->namaunitkerja;
            $model->kontrak_tanggal = MyFormatter::formatDateTimeforUser($model->kontrak_tanggal);
            if (!empty($model->suratperjanjiankerja_id)) {
                $modInfo = DaftarnomorNotadinaspptkV::model()->findByAttributes(array('nomor_id' => $model->suratperjanjiankerja_id, 'kategori_pengadaan' => 'Penyedia'));
                $modSPK = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
                $modRencana = RencanaumumpengadaanT::model()->findByPk($modSPK->persiapanpengadaan->rencanaumumpengadaan_id);
                $model->suratperjanjiankerja_id = $modInfo->nomor_id;
            } else {
                $modInfo = DaftarnomorNotadinaspptkV::model()->findByAttributes(array('nomor_id' => $model->rencanaumumpengadaan_id, 'kategori_pengadaan' => 'Swakelola'));
                $modRencana = RencanaumumpengadaanT::model()->findByPk($model->rencanaumumpengadaan_id);
                $model->rencanaumumpengadaan_id = $modInfo->nomor_id;
            }
            
            //Kode Rekening
            $model->koderekening = '';
            $cekRekening = MappingrekeninganggaranM::model()->findByPk($model->mappingrekeninganggaran_id);
            $model->koderekening .= !empty($cekRekening) ? $cekRekening->kodeanggaran . " - " . $cekRekening->nama_rekeninganggaran5 : ' ';
            
            $model->persiapanpengadaan_nomor = $modInfo->nomor_dokumen;
            $model->programkerja_nama = $modInfo->programkerja_kode . ' - ' . $modInfo->programkerja_nama;
            $model->kegiatanprogram_nama = $modInfo->subprogramkerja_kode . ' - ' . $modInfo->subprogramkerja_nama;
            $model->subkegiatanprogram_nama = $modInfo->subkegiatanprogram_kode . ' - ' . $modInfo->subkegiatanprogram_nama;
            $model->paket_pekerjaan = $modInfo->paket_pekerjaan;
            $model->tahunanggaran = $modInfo->tahun;
            $model->notadinaspptk_tanggal = date('d M Y H:i:s', strtotime($model->notadinaspptk_tanggal));
            $model->tanggal_pembayaran = !empty($model->tanggal_pembayaran) ? date('d M Y', strtotime($model->tanggal_pembayaran)) : date('d M Y');
            $model->telahditerima_dari = !empty($model->telahditerima_dari) ? $model->telahditerima_dari : 'Direktur Utama RSUD Dr. Soetomo Surabaya';
        
            $model->jumlah_harga = number_format($model->jumlah_harga, 2, ',', '.');
            $model->jumlah_pajak = number_format($model->jumlah_pajak, 2, ',', '.');
            $model->jumlah_diterima = number_format($model->jumlah_diterima, 2, ',', '.');
            $model->sisa_pagu = number_format($model->sisa_pagu, 2, ',', '.');
        }

        if (isset($_POST['NotadinaspptkT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                if (!empty($notadinaspptk_id)) {
                    $model = NotadinaspptkT::model()->findByPk($notadinaspptk_id);
                    $model->attributes = $_POST['NotadinaspptkT'];
                    $model->notadinaspptk_tanggal = MyFormatter::formatDateTimeForDb($_POST['NotadinaspptkT']['notadinaspptk_tanggal']);
                    $model->kategori_pengadaan = !empty($model->suratperjanjiankerja_id) ? "Penyedia" : "Swakelola";
                    $model->kontrak_tanggal = !empty($model->suratperjanjiankerja_id) ? MyFormatter::formatDateTimeForDb($model->kontrak_tanggal) : null; 
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $model->update_time = date('Y-m-d H:i:s');

                    $ok = $ok && $model->save();                   
                    
                    if (isset($_POST['NotadinaspptkdetT']) && $ok) {
                        NotadinaspptkdetT::model()->deleteAllByAttributes(array('notadinaspptk_id' => $notadinaspptk_id));
                        foreach ($_POST['NotadinaspptkdetT'] as $key => $value) {
                            $modelDetail = new NotadinaspptkdetT();
                            $modelDetail->attributes = $value;
                            $modelDetail->notadinaspptk_id = $model->notadinaspptk_id;
                            $modelDetail->notadinaspptkdet_tanggal = !empty($value['notadinaspptkdet_tanggal']) ? MyFormatter::formatDateTimeForDb($value['notadinaspptkdet_tanggal']) : null;
                            $ok = $ok && $modelDetail->save();
//                            if ($ok) {
//                                $modDok = DokumenpelaksanaananggarandetT::model()->findByPk($value['dokumenpelaksanaananggarandet_id']);
//                                $modDok->sisapagu_pengadaan = $value['sisapagu_pengadaan_baru'];
//                                $modDok->sisavolume_pengadaan = $value['volume_baru'];
//                                if ($modDok->sisapagu_pengadaan <= 0) {
//                                    $modDok->pengadaan_status = true;
//                                }
//                                $ok &= $modDok->save();
//                            }
                        }
                    }
                } else {
                    $model->attributes = $_POST['NotadinaspptkT'];
                    $model->notadinaspptk_nomor = MyGenerator::noNotaDinaspptk();
                    $model->notadinaspptk_tanggal = MyFormatter::formatDateTimeForDb($_POST['NotadinaspptkT']['notadinaspptk_tanggal']);
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->kategori_pengadaan = !empty($model->suratperjanjiankerja_id) ? "Penyedia" : "Swakelola";
                    $ok = $ok && $model->save();

                    if (isset($_POST['NotadinaspptkdetT']) && $ok) {
                        foreach ($_POST['NotadinaspptkdetT'] as $key => $value) {
                            $modelDetail = new NotadinaspptkdetT;
                            $modelDetail->attributes = $value;
                            $modelDetail->notadinaspptk_id = $model->notadinaspptk_id;
                            $modelDetail->notadinaspptkdet_tanggal = !empty($value['notadinaspptkdet_tanggal']) ? MyFormatter::formatDateTimeForDb($value['notadinaspptkdet_tanggal']) : null;
                            $ok = $ok && $modelDetail->save();
//                            if ($ok) {
//                                $modDok = DokumenpelaksanaananggarandetT::model()->findByPk($value['dokumenpelaksanaananggarandet_id']);
//                                $modDok->sisapagu_pengadaan = $value['sisapagu_pengadaan_baru'];
//                                $modDok->sisavolume_pengadaan = $value['volume_baru'];
//                                if ($modDok->sisapagu_pengadaan <= 0) {
//                                    $modDok->pengadaan_status = true;
//                                }
//                                $ok &= $modDok->save();
//                            }
                            
                        }
                    }
                }
                
                if ($ok) {
                    $transaction->commit();
                    if (!empty($ubah)) {
                        $this->redirect(array('index', 'notadinaspptk_id' => $model->notadinaspptk_id, 'persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'ubah' => 1, 'sukses' => 1));
                    } else {
                        $this->redirect(array('index', 'sukses' => 1));
                    }
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        // Membedakan render untuk dialog dan render pertama. Supaya load dialog cepat 
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('index', array(
                'model' => $model,
                'modDetail' => $modDetail,
                'format' => $format
            ));
        } else {
            $this->render('index', array(
                'model' => $model,
                'modDetail' => $modDetail,
                'format' => $format
            ));
        }
    }

    /**
     * Digunakan untuk mengenerate tabel Rincian
     */
    public function actionGenerateTableRincian() {
        if (Yii::app()->request->isAjaxRequest) {
            $suratperjanjiankerja_id = isset($_POST['suratperjanjiankerja_id']) ? $_POST['suratperjanjiankerja_id'] : null;
            $rencanaumumpengadaan_id = isset($_POST['rencanaumumpengadaan_id']) ? $_POST['rencanaumumpengadaan_id'] : null;
            $perintahpengiriman_id = null;
            $notadinaspptk_id = isset($_POST['notadinaspptk_id']) ? $_POST['notadinaspptk_id'] : null;
            $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : null;
            if (strtoupper($jenis) == Params::KATEGORI_PENGADAAN_PENYEDIA) {
                $modPerintah = PerintahpengirimanT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
                if (!empty($modPerintah)) {
                    $perintahpengiriman_id = $modPerintah->perintahpengiriman_id;
                }
            }
            $value = "";
            $valueTotal = "";
            $i = 1;
            $total_sebelumpajak = $total_pajak = $total_diterima = $sisa_pagu = 0;
            $criteria = new CDbCriteria();
            $cekRincian = NotadinaspptkdetT::model()->findByAttributes(array('notadinaspptk_id' => $notadinaspptk_id));
            if (!empty($cekRincian)) {
                $model = NotadinaspptkT::model()->findByPk($notadinaspptk_id);
                $modDet = NotadinaspptkdetT::model()->findAllByAttributes(array('notadinaspptk_id' => $notadinaspptk_id));
                foreach ($modDet as $mod) {
                    $value = $this->renderPartial('_rowdetail', array('modDetail' => $modDet, 'model' => $model), true);
                }
            } else if (!empty($perintahpengiriman_id) && strtoupper($jenis) == Params::KATEGORI_PENGADAAN_PENYEDIA) {
                $modPerintah = PerintahpengirimanT::model()->findByPk($perintahpengiriman_id);
                $total_sebelumpajak = $modPerintah->jumlah_harga;
                $total_pajak = $modPerintah->jumlah_pajak;
                $total_diterima = $modPerintah->total_harga;
                $modRincian = PerintahpengirimandetT::model()->findAllByAttributes(array('perintahpengiriman_id' => $modPerintah->perintahpengiriman_id));
                foreach($modRincian as $mod){
                    $modDet = new NotadinaspptkdetT;
                    $model = new NotadinaspptkT;
                    $modDet->barang_id = $mod->barang_id;
                    $modDet->notadinaspptkdet_jenisbarang = $mod->jenis_barang;
                    $modDet->pajak_persen = number_format($mod->pajak_persen, 2, ',', '.');
                    $modDet->barang_satuan = $mod->barang_satuan;
                    $modDet->notadinaspptkdet_uraian = $mod->barang_nama;
                    $modDet->jumlah_harga = number_format($mod->harga_satuan * $mod->barang_jumlah, 2, ',', '.');
                    $modDet->barang_volume = number_format($mod->barang_jumlah, 2, ',','.');
                    $modDet->jumlah_diterima = number_format($mod->jumlah_harga, 2, ',', '.');
                    $modDet->harga_satuan = number_format($mod->harga_satuan, 2, ',', '.');
                    $modDet->dokumenpelaksanaananggarandet_id = $mod->suratperjanjiankerjarincian->dokumenpelaksanaananggarandet_id;
                    $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($modDet->dokumenpelaksanaananggarandet_id);
                    $sql = "SELECT 
                            sum(jumlah_diterima) as rincian_serapan
                            FROM notadinaspptkdet_t
                            WHERE dokumenpelaksanaananggarandet_id = " . $modDet->dokumenpelaksanaananggarandet_id;
                    $result = Yii::app()->db->createCommand($sql)->queryRow();
                    if (!empty($result['rincian_serapan'])) {
                        $modDet->serapan = $result['rincian_serapan'];
                    } else {
                        $modDet->serapan = 0;
                    }
                    $modDet->pagu = $modDPA->jumlah;
                    $sisa = $modDet->pagu - $modDet->serapan;
                    $modDet->selisih = number_format($mod->jumlah_harga - $modDPA->sisapagu_pengadaan, 2, ',', '.'); 
                    $modDet->sisa = number_format($sisa, 2, ',', '.');
                    $modDet->serapan = number_format($modDet->serapan, 2, ',', '.');
                    $modDet->pagu = number_format($modDet->pagu, 2, ',', '.');
                    $modDet->jumlah_awal = $modDet->jumlah_diterima;
                    $modDet->volume_awal = $modDet->barang_volume;
                    $modDet->sisapagu_pengadaan = number_format($modDPA->sisapagu_pengadaan, 2, ',', '.');
                    $modDet->sisavolume_pengadaan = number_format($modDPA->sisavolume_pengadaan, 2, ',', '.');
                    $value .= $this->renderPartial('_rowRincian', array('modDetail' => $modDet, 'i' => $i), true);
                    $i++;
                }
            } else if (!empty($suratperjanjiankerja_id) && strtoupper($jenis) == Params::KATEGORI_PENGADAAN_PENYEDIA) {
                $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
                $total_sebelumpajak = $modSPK->jumlah_harga;
                $total_pajak = $modSPK->jumlah_pajak;
                $total_diterima = $modSPK->total_pembulatan;
                $criteria->addCondition('suratperjanjiankerja_id = ' . $suratperjanjiankerja_id);
                $modRincian = SuratperjanjiankerjarincianT::model()->findAll($criteria);
                foreach ($modRincian as $mod) {
                    $modDet = new NotadinaspptkdetT;
                    $model = new NotadinaspptkT;
                    $modDet->barang_id = $mod->barang_id;
                    $modDet->notadinaspptkdet_jenisbarang = $mod->jenis_barang;
                    $modDet->pajak_persen = number_format($mod->pajak_persen, 2, ',', '.');
                    $modDet->barang_satuan = $mod->barang_satuan;
                    $modDet->notadinaspptkdet_uraian = $mod->barang_nama;
                    $modDet->jumlah_harga = number_format($mod->barang_harga * $mod->barang_jumlah, 2, ',', '.');
                    $modDet->barang_volume = number_format($mod->barang_jumlah, 2, ',','.');
                    $modDet->jumlah_diterima = number_format($mod->barang_total, 2, ',', '.');
                    $modDet->harga_satuan = number_format($mod->barang_harga, 2, ',', '.');
                    $modDet->dokumenpelaksanaananggarandet_id = $mod->dokumenpelaksanaananggarandet_id;
                    $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($modDet->dokumenpelaksanaananggarandet_id);
                    $sql = "SELECT 
                            sum(jumlah_diterima) as rincian_serapan
                            FROM notadinaspptkdet_t
                            WHERE dokumenpelaksanaananggarandet_id = " . $modDet->dokumenpelaksanaananggarandet_id;
                    $result = Yii::app()->db->createCommand($sql)->queryRow();
                    if (!empty($result['rincian_serapan'])) {
                        $modDet->serapan = $result['rincian_serapan'];
                    } else {
                        $modDet->serapan = 0;
                    }
                    $modDet->pagu = $modDPA->jumlah;
                    $sisa = $modDet->pagu - $modDet->serapan;
                    $modDet->selisih = number_format($mod->barang_total - $modDPA->sisapagu_pengadaan, 2, ',', '.'); 
                    $modDet->sisa = number_format($sisa, 2, ',', '.');
                    $modDet->serapan = number_format($modDet->serapan, 2, ',', '.');
                    $modDet->pagu = number_format($modDet->pagu, 2, ',', '.');
                    $modDet->jumlah_awal = $modDet->jumlah_diterima;
                    $modDet->volume_awal = $modDet->barang_volume;
                    $modDet->sisapagu_pengadaan = number_format($modDPA->sisapagu_pengadaan, 2, ',', '.');
                    $modDet->sisavolume_pengadaan = number_format($modDPA->sisavolume_pengadaan, 2, ',', '.');
                    $value .= $this->renderPartial('_rowRincian', array('modDetail' => $modDet, 'i' => $i), true);
                    $i++;
                }
            } else {
                $modRUP = RencanaumumpengadaanT::model()->findByPk($rencanaumumpengadaan_id);
                $total_sebelumpajak = $modRUP->total_harga;
                $total_pajak = $modRUP->total_pajak;
                $total_diterima = $modRUP->total_pagu;
                
                $criteria->addCondition('rencanaumumpengadaan_id = ' . $rencanaumumpengadaan_id);
                $modRincian = RencanaumumpengadaandetT::model()->findAll($criteria);
                $modDet = new NotadinaspptkdetT;
                $model = new NotadinaspptkT;
                foreach ($modRincian as $mod) {
                    $modDet->barang_id = $mod->barang_id;
                    $modDet->notadinaspptkdet_jenisbarang = $mod->jenis_barang;
                    $modDet->pajak_persen = number_format($mod->rencanaumumpengadaandet_pajak, 2, ',', '.');
                    $modDet->barang_satuan = $mod->rencanaumumpengadaandet_satuan;
                    $modDet->notadinaspptkdet_uraian = $mod->rencanaumumpengadaandet_nama;
                    $modDet->barang_volume = number_format($mod->rencanaumumpengadaandet_volume, 2, ',', '.');
                    $modDet->volume_awal = $modDet->barang_volume;
                    $modDet->jumlah_diterima = number_format($mod->rencanaumumpengadaandet_jumlah, 2, ',', '.');
                    $modDet->harga_satuan = number_format($mod->rencanaumumpengadaandet_harga, 2, ',', '.');
                    $modDet->jumlah_harga = number_format($mod->rencanaumumpengadaandet_harga * $mod->rencanaumumpengadaandet_volume, 2, ',', '.');
                    $modDet->dokumenpelaksanaananggarandet_id = $mod->dokumenpelaksanaananggarandet_id;
                    $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($modDet->dokumenpelaksanaananggarandet_id);
                    $sql = "SELECT 
                            sum(jumlah_diterima) as rincian_serapan
                            FROM notadinaspptkdet_t
                            WHERE dokumenpelaksanaananggarandet_id = " . $modDet->dokumenpelaksanaananggarandet_id;
                    $result = Yii::app()->db->createCommand($sql)->queryRow();
                    if (!empty($result['rincian_serapan'])) {
                        $modDet->serapan = $result['rincian_serapan'];
                    } else {
                        $modDet->serapan = 0;
                    }
                    $modDet->pagu = $modDPA->jumlah;
                    $sisa = $modDet->pagu - $modDet->serapan;
                    $modDet->selisih = number_format($mod->rencanaumumpengadaandet_jumlah - $modDPA->sisapagu_pengadaan, 2, ',', '.');
                    $modDet->sisa = number_format($sisa, 2, ',', '.');
                    $modDet->serapan = number_format($modDet->serapan, 2, ',', '.');
                    $modDet->pagu = number_format($modDet->pagu, 2, ',', '.');
                    $modDet->jumlah_awal = $modDet->jumlah_diterima;
                    $modDet->sisapagu_pengadaan = number_format($modDPA->sisapagu_pengadaan, 2, ',', '.');
                    $modDet->sisavolume_pengadaan = number_format($modDPA->sisavolume_pengadaan, 2, ',', '.');
                    $value .= $this->renderPartial('_rowRincian', array('modDetail' => $modDet, 'i' => $i), true);
                    $i++;
                }
            }

            $data['sukses'] = 1;
            $data['html'] = $value;
            $data['total_sebelumpajak'] = number_format($total_sebelumpajak, 2, ',', '.');
            $data['total_pajak'] = number_format($total_pajak, 2, ',', '.');
            $data['total_diterima'] = number_format($total_diterima, 2, ',', '.');
            
            echo json_encode($data);

            Yii::app()->end();
        }
    }

    /**
     * Generate rincian rba  
     */
    public function actionGetRincianDokumen() {
        if (Yii::app()->request->isAjaxRequest) {
            $dokumen = isset($_POST['dokumendet_id']) ? $_POST['dokumendet_id'] : null;
            $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : null;
            $suratperjanjiankerja_id = isset($_POST['spk_id']) ? $_POST['spk_id'] : null;
            $rencanaumumpengadaan_id = isset($_POST['rup_id']) ? $_POST['rup_id'] : null;
            $tr = "";
            $no = 0;
            if ($jenis == "Penyedia") {
                $cri = new CDbCriteria();
                if (is_array($dokumen)) {
                    $cri->addInCondition("t.dokumenpelaksanaananggarandet_id", $dokumen);
                } else {
                    $cri->addCondition("t.dokumenpelaksanaananggarandet_id = '" . $dokumen . "' ");
                }
                $cri->addCondition('t.suratperjanjiankerja_id = ' . $suratperjanjiankerja_id);
                $cri->order = "t.suratperjanjiankerjarincian_id asc";
                $modDokumen = SuratperjanjiankerjarincianT::model()->findAll($cri);
                $modDet = new NotadinaspptkdetT();
                $i = '';
                if (!empty($modDokumen)) {
                    foreach ($modDokumen as $mod) {
                        $modDet->barang_id = $mod->barang_id;
                        $modDet->notadinaspptkdet_jenisbarang = $mod->jenis_barang;
                        $modDet->pajak_persen = number_format($mod->pajak_persen, 2, ',', '.');
                        $modDet->barang_satuan = $mod->barang_satuan;
                        $modDet->notadinaspptkdet_uraian = $mod->barang_nama;
                        $modDet->jumlah_harga = number_format($mod->barang_harga * $mod->barang_jumlah, 2, ',', '.');
                        $modDet->barang_volume = number_format($mod->barang_jumlah, 2, ',', '.');
                        $modDet->volume_awal =  $modDet->barang_volume; 
                        $modDet->jumlah_diterima = number_format($mod->barang_total, 2, ',', '.');
                        $modDet->harga_satuan = number_format($mod->barang_harga, 2, ',', '.');
                        $modDet->dokumenpelaksanaananggarandet_id = $mod->dokumenpelaksanaananggarandet_id;
                        $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($modDet->dokumenpelaksanaananggarandet_id);
                        $sql = "SELECT 
                                sum(jumlah_diterima) as rincian_serapan
                                FROM notadinaspptkdet_t
                                WHERE dokumenpelaksanaananggarandet_id = " . $modDet->dokumenpelaksanaananggarandet_id;
                        $result = Yii::app()->db->createCommand($sql)->queryRow();
                        if (!empty($result['rincian_serapan'])) {
                            $modDet->serapan = $result['rincian_serapan'];
                        } else {
                            $modDet->serapan = 0;
                        }
                        $modDet->pagu = $modDPA->jumlah;
                        $sisa = $modDet->pagu - $modDet->serapan;
                        $modDet->selisih = number_format($mod->barang_total - $modDPA->sisapagu_pengadaan, 2, ',', '.');
                        $modDet->sisa = number_format($sisa, 2, ',', '.');
                        $modDet->serapan = number_format($modDet->serapan, 2, ',', '.');
                        $modDet->pagu = number_format($modDet->pagu, 2, ',', '.');
                        $modDet->jumlah_awal = $modDet->jumlah_diterima;
                        $modDet->sisapagu_pengadaan = number_format($modDPA->sisapagu_pengadaan, 2, ',', '.');
                        $modDet->sisavolume_pengadaan = number_format($modDPA->sisavolume_pengadaan, 2, ',', '.');
                        $i++;
                        $tr .= $this->renderPartial('_rowRincian', array('modDetail' => $modDet, 'i' => $i), true);
                    }
                }
            } else {
                $cri = new CDbCriteria();
                if (is_array($dokumen)) {
                    $cri->addInCondition("t.dokumenpelaksanaananggarandet_id", $dokumen);
                } else {
                    $cri->addCondition("t.dokumenpelaksanaananggarandet_id = '" . $dokumen . "' ");
                }
                $cri->addCondition('rencanaumumpengadaan_id = ' . $rencanaumumpengadaan_id);
                $cri->order = "t.rencanaumumpengadaandet_id asc";
                $modDokumen = RencanaumumpengadaandetT::model()->findAll($cri);
                $modDet = new NotadinaspptkdetT();
                $i = 1;
                foreach ($modDokumen as $mod) {
                    $modDet->barang_id = $mod->barang_id;
                    $modDet->notadinaspptkdet_jenisbarang = $mod->jenis_barang;
                    $modDet->pajak_persen = number_format($mod->rencanaumumpengadaandet_pajak, 2, ',', '.');
                    $modDet->barang_satuan = $mod->rencanaumumpengadaandet_satuan;
                    $modDet->notadinaspptkdet_uraian = $mod->rencanaumumpengadaandet_nama;
                    $modDet->barang_volume = number_format($mod->rencanaumumpengadaandet_volume, 2, ',', '.');
                    $modDet->volume_awal = $modDet->barang_volume; 
                    $modDet->jumlah_diterima = number_format($mod->rencanaumumpengadaandet_jumlah, 2, ',', '.');
                    $modDet->harga_satuan = number_format($mod->rencanaumumpengadaandet_harga, 2, ',', '.');
                    $modDet->jumlah_harga = number_format($mod->rencanaumumpengadaandet_harga * $mod->rencanaumumpengadaandet_volume, 2, ',', '.');
                    $modDet->dokumenpelaksanaananggarandet_id = $mod->dokumenpelaksanaananggarandet_id;
                    $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($modDet->dokumenpelaksanaananggarandet_id);
                    $sql = "SELECT 
                                sum(jumlah_diterima) as rincian_serapan
                                FROM notadinaspptkdet_t
                                WHERE dokumenpelaksanaananggarandet_id = " . $modDet->dokumenpelaksanaananggarandet_id;
                        $result = Yii::app()->db->createCommand($sql)->queryRow();
                        if (!empty($result['rincian_serapan'])) {
                            $modDet->serapan = $result['rincian_serapan'];
                        } else {
                            $modDet->serapan = 0;
                        }
                    $modDet->pagu = $modDPA->jumlah;
                    $sisa = $modDet->pagu - $modDet->serapan;
                    $modDet->selisih = number_format($mod->rencanaumumpengadaandet_jumlah - $modDPA->sisapagu_pengadaan, 2, ',', '.');
                    $modDet->sisa = number_format($sisa, 2, ',', '.');
                    $modDet->serapan = number_format($modDet->serapan, 2, ',', '.');
                    $modDet->pagu = number_format($modDet->pagu, 2, ',', '.');
                    $modDet->jumlah_awal = $modDet->jumlah_diterima;
                    $modDet->sisapagu_pengadaan = number_format($modDPA->sisapagu_pengadaan, 2, ',', '.');
                    $modDet->sisavolume_pengadaan = number_format($modDPA->sisavolume_pengadaan, 2, ',', '.');
                    $tr .= $this->renderPartial('_rowRincian', array('modDetail' => $modDet, 'i' => $i), true);
                    $i++;
                }
            }
            
            echo json_encode($tr);
            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk men-generate Tabel Rincian
     */
    public function actionGenerateTableRinciantanpapph22() {
        if (Yii::app()->request->isAjaxRequest) {
            $persiapanpengadaan_id = isset($_POST['persiapanpengadaan_id']) ? $_POST['persiapanpengadaan_id'] : null;
            $notadinaspptk_id = isset($_POST['notadinaspptk_id']) ? $_POST['notadinaspptk_id'] : null;
            $value = "";
            $valueTotal = "";

            $criteria = new CDbCriteria();
            if (!empty($_POST['persiapanpengadaan_id'])) {
                $criteria->addCondition(" t.persiapanpengadaan_id = " . $persiapanpengadaan_id . " ");
            }
            $criteria->limit = 5;
            $modPersiapanPengadaan = PersiapanpengadaandetT::model()->findAll($criteria);

            $cekRincian = NotadinaspptkdetT::model()->findByAttributes(array('notadinaspptk_id' => $notadinaspptk_id));
            if (!empty($cekRincian)) {

                if ($cekRincian->notadinaspptkdet_tanggal == null) {
                    $modDet = NotadinaspptkdetT::model()->findAllByAttributes(array('notadinaspptk_id' => $notadinaspptk_id));
                    $model = NotadinaspptkT::model()->findByPk($notadinaspptk_id);
                    $value = $this->renderPartial('_rowdetail2', array('modPersiapanPengadaan' => $modPersiapanPengadaan, 'modDetail' => $modDet, 'model' => $model), true);
                } else {
                    $modDet = new NotadinaspptkdetT;
                    $model = new NotadinaspptkT;
                    $value = $this->renderPartial('_rowTabel2', array('modPersiapanPengadaan' => $modPersiapanPengadaan, 'modDet' => $modDet, 'model' => $model), true);
                }
            } else {
                $modDet = new NotadinaspptkdetT;
                $model = new NotadinaspptkT;

                $value = $this->renderPartial('_rowTabel2', array('modPersiapanPengadaan' => $modPersiapanPengadaan, 'modDet' => $modDet, 'model' => $model), true);
            }

            $data['sukses'] = 1;
            $data['html'] = $value;

            echo json_encode($data);

            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk Set Format Tanggal Persiapan Pengadaan
     */
    public function actionSetTanggal() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['persiapanpengadaan_tanggal'] = MyFormatter::formatDateTimeForUser($_POST['tgl']);

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Autocomplete Persiapan Pengadaan
     */
    public function actionAutocompletePersiapanPengadaan() {
        if (Yii::app()->request->isAjaxRequest) {

            $returnVal = array();
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }

            $criteria->join = 'JOIN rencanaumumpengadaan_t ON rencanaumumpengadaan_t.rencanaumumpengadaan_id = t.rencanaumumpengadaan_id';
            $criteria->select = 't.*, rencanaumumpengadaan_t.rencanaumumpengadaan_kategori';
            $criteria->compare('LOWER(persiapanpengadaan_nomor)', strtolower($_GET['term']), true);
            $criteria->addCondition(" t.persiapanpengadaan_status = '" . Params::VERIFIKASI_DISETUJUI . "'");
//            $criteria->addCondition(" t.rencanaumumpengadaan_kategori = 'Swakelola'");
            $criteria->order = 'persiapanpengadaan_nomor ASC';
            $criteria->limit = 10;
            $models = InformasipersiapanpengadaanV::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->persiapanpengadaan_nomor . " - " . $model->nama_pekerjaan;
                $cekpengadaansumberdana = PengadaansumberdanaT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $model->rencanaumumpengadaan_id));
                if (!empty($cekpengadaansumberdana)) {

                    //Sumber dana
                    $returnVal[$i]['sumberdana'] = '';
                    $cekSumberAnggaran = SumberanggaranM::model()->findByPk($cekpengadaansumberdana->sumberanggaran_id);
                    $returnVal[$i]['sumberdana'] .= !empty($cekSumberAnggaran) ? $cekSumberAnggaran->sumberanggarannama . ", " : ' ';

                    //Kode Rekening
                    $returnVal[$i]['koderekening'] = '';
                    $returnVal[$i]['mappingrekeninganggaran_id'] = !empty($cekpengadaansumberdana->mappingrekeninganggaran_id) ? $cekpengadaansumberdana->mappingrekeninganggaran_id : null;
                    $returnVal[$i]['kegiatanprogram_nama'] .= !empty($model) ? $model->subprogramkerja_kode . " - " . $model->subprogramkerja_nama : ' ';
                    $mapping = MappingrekeninganggaranM::model()->findByPk($cekpengadaansumberdana->mappingrekeninganggaran_id);
                    $returnVal[$i]['koderekening'] .= !empty($mapping) ? $mapping->kodeanggaran . " - " . $mapping->nama_rekeninganggaran5 : '';
                }

                $cekPegawaiPPK = RencanaumumpengadaanT::model()->findByPk($model->rencanaumumpengadaan_id);
                $cekNamaPegawaiPPK = PegawaiM::model()->findByPk($cekPegawaiPPK->pegawaippk_id);
                $returnVal[$i]['pegawaippk_id'] = !empty($cekPegawaiPPK) ? $cekPegawaiPPK->pegawaippk_id : ' ';
                $returnVal[$i]['pegawaippk_nama'] = !empty($cekNamaPegawaiPPK) ? $cekNamaPegawaiPPK->namaLengkap : ' ';

                $cekPersiapan = PersiapanpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
                $returnVal[$i]['nilai_hps'] = !empty($cekPersiapan) ? number_format($cekPersiapan->total_hargaseluruhnya, 2, ",", ".") : '';
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Cetak Nota Dinas
     * @param type $id
     */
    public function actionPrintNotadinas($id) {
        $this->layout = '//layouts/printWindows';
        $model = NotadinaspptkT::model()->findByPk($id);
        $modelDetail = NotadinaspptkdetT::model()->findAllByAttributes(array('notadinaspptk_id' => $id));

        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        $criteria->addCondition("konfigtemplatesurat_id=32");
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{notadinaspptk_tanggal}}", date('d ', strtotime($model->notadinaspptk_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->notadinaspptk_tanggal))) . date(' Y', strtotime($model->notadinaspptk_tanggal)), $isiPesan);
            }

            $modInfo = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
            $attributes = $modInfo->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
        }
        $model->isi_surat = $isiPesan;

        $this->render('printNotadinas', array('model' => $model, 'modelDetail' => $modelDetail));
    }

    /**
     * Cetak Uraian
     * @param type $id
     */
    public function actionPrintUraian($id) {
        $this->layout = '//layouts/printWindows';
        $model = NotadinaspptkT::model()->findByPk($id);
        $modelDetail = NotadinaspptkdetT::model()->findAllByAttributes(array('notadinaspptk_id' => $id));

        $this->render('printUraian', array('model' => $model, 'modelDetail' => $modelDetail));
    }

    /**
     * Autocomplete pptk
     */
    public function actionAutocompletePptk() {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->join = 'JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id';
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition("jabatan_pengadaan = 'Pejabat Pelaksana Teknis Kegiatan'");
            $criteria->addCondition('pejabatpengadaan_aktif IS TRUE');
            $criteria->order = 'pegawai_m.nama_pegawai ASC';
            $criteria->limit = 10;
            $models = PejabatpengadaanM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->pegawai->namaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete pjk
     */
    public function actionAutocompletePjk() {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->join = 'JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id';
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition("jabatan_pengadaan = 'Penanggung Jawab Kegiatan'");
            $criteria->addCondition('pejabatpengadaan_aktif IS TRUE');
            $criteria->order = 'pegawai_m.nama_pegawai ASC';
            $criteria->limit = 10;
            $models = PejabatpengadaanM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->pegawai->namaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;

                $j = PegawaiM::model()->findByPk($model->pegawai_id);
                if (!empty($j)) {
                    $nama_pegawai = $j->nama_pegawai;
                    $jabatan = $j->jabatan->jabatan_nama;
                    $unitkerja = $j->unitkerja->namaunitkerja;
                } else {
                    $nama_pegawai = '-';
                    $jabatan = '-';
                    $unitkerja = '-';
                }
                $returnVal[$i]['pegpjk_jabatan'] = $jabatan;
                $returnVal[$i]['pegpjk_unitkerja'] = $unitkerja;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * load total dpa dari pagu berdasarkan tabel dokumenpelaksanaananggarandet_t
     */
    public function actionPagudariDPA() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = isset($_POST['dokumenpelaksanaananggarandet_id']) ? $_POST['dokumenpelaksanaananggarandet_id'] : null;

            if (!empty($id)) {
                $total = 0;
                $serapan = 0;
                $sisa = 0;
                $cri = new CDbCriteria();
                $cri->select = "t.dokumenpelaksanaananggarandet_id,
                            t.jumlah,
                            (SELECT 
                                sum(jumlah_diterima) as rincian_serapan
                                FROM notadinaspptkdet_t nota
                                where nota.dokumenpelaksanaananggarandet_id = t.dokumenpelaksanaananggarandet_id
                                group by nota.dokumenpelaksanaananggarandet_id),
                                (SELECT 
                                t.jumlah - sum(jumlah_diterima) as sisa_pagu
                                FROM notadinaspptkdet_t nota
                                where nota.dokumenpelaksanaananggarandet_id = t.dokumenpelaksanaananggarandet_id
                                group by nota.dokumenpelaksanaananggarandet_id)";
                $cri->addInCondition("t.dokumenpelaksanaananggarandet_id", $id);
                $modDetail = DokumenpelaksanaananggarandetT::model()->findAll($cri);

                foreach ($modDetail as $det) {
                    $sisa = $det['jumlah'] - $det['rincian_serapan']; 
                    $total += $sisa;
                }
            }

            $data['sukses'] = 1;
            $data['total'] = !empty($total) ? number_format($total, 2, ",", ".") : number_format(0, 2, ",", ".");

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Load dropdown termin 
     * @param type $suratperjanjiankerja_id
     */
    public function actionSetDropdownTermin($suratperjanjiankerja_id = '') {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            if (!empty($suratperjanjiankerja_id)) {

                $data = SuratperjanjiankerjaterminT::model()->findAll('suratperjanjiankerja_id = ' . $suratperjanjiankerja_id);
                $data = CHtml::listData($data, 'terminke', 'terminke');
                foreach ($data as $value => $name) {
                    $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }
            $dataList['list_termin'] = $option;
            echo json_encode($dataList);
            Yii::app()->end();
        }
    }
    
    /**
     * Load dropdown termin 
     * @param type $suratperjanjiankerja_id
     */
    public function actionSetDropdownPerintahPengiriman($suratperjanjiankerja_id = '') {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            if (!empty($suratperjanjiankerja_id)) {
                $criteria = new CDbCriteria();
                $criteria->join = "left join notadinaspptk_t on t.perintahpengiriman_id = notadinaspptk_t.perintahpengiriman_id";
                $criteria->addCondition('t.suratperjanjiankerja_id = '.$suratperjanjiankerja_id."and notadinaspptk_t.notadinaspptk_id is null");
                $criteria->select = " t.perintahpengiriman_id, concat('Termin ', terminke, ' (', termin_persen,'%)', ' - ', perintahpengiriman_nomor) as perintahpengiriman_nomor  ";
                $criteria->order = "perintahpengiriman_id asc";
                $data = PerintahpengirimanT::model()->findAll($criteria);
                $data = CHtml::listData($data, 'perintahpengiriman_id', 'perintahpengiriman_nomor');
                foreach ($data as $value => $name) {
                    $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }
            $dataList['list_perintah_pengiriman'] = $option;
            echo json_encode($dataList);
            Yii::app()->end();
        }
    }
    
    /**
     * Autocomplete daftar nomor dari RUP dan SPK
     */
    public function actionAutocompleteDaftarNomor() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            if (!isset($_GET['kategori_pengadaan'])) {
                $_GET['kategori_pengadaan'] = null;
            }
            $model = new DaftarnomorNotadinaspptkV();
            $prov = $model->searchDialog();
            $prov->criteria->addCondition("kategori_pengadaan = :kategori_pengadaan");
                $prov->criteria->params[':kategori_pengadaan'] = $_GET['kategori_pengadaan'];
            $prov->criteria->compare('LOWER(t.nomor_dokumen)', strtolower($_GET['term']), true);
            $prov->criteria->order = 'nomor_dokumen ASC';
            $prov->criteria->limit = 5;
                        
            foreach ($prov->data as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomor_dokumen;
                $returnVal[$i]['value'] = $model->nomor_id;
                $returnVal[$i]['perintah_pengiriman'] = 0;
                $returnVal[$i]['kegiatanprogram_nama'] = !empty($model->subprogramkerja_kode) ? $model->subprogramkerja_kode . " - " . $model->subprogramkerja_nama : '';

                if ($_GET['kategori_pengadaan'] == 'Penyedia') {
                    $returnVal[$i]['suratperjanjiankerja_id'] = $model->nomor_id;
                    $returnVal[$i]['rencanaumumpengadaan_id'] = '';
                    $modPerintahPengiriman = PerintahpengirimanT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $returnVal[$i]['suratperjanjiankerja_id']));
                    if (!empty($modPerintahPengiriman)) {
                        $returnVal[$i]['perintah_pengiriman'] = count($modPerintahPengiriman);
                    }
                } else {
                    $returnVal[$i]['rencanaumumpengadaan_id'] = $model->nomor_id;
                    $returnVal[$i]['suratperjanjiankerja_id'] = '';
                }
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
     /**
     * Cek nomor dokumen
     * jika ada nomor dokumen yang sama maka muncul warning 
     */
    function actionCekNomorDokumen(){
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $nomor_notadinas = $_POST['nomor_notadinas'];
            $notadinaspptk_id = "";
            if ($_POST['notadinaspptk_id'] == 0) {
                $notadinaspptk_id = null;
            } else {
                $notadinaspptk_id = $_POST['notadinaspptk_id'];
            }
            
            $data['ok'] = 1;
            $data['pesan'] = '';
            $cri = new CDbCriteria(); 
            $cri->addCondition("lower(nomor_notadinas) = '".strtolower($nomor_notadinas)."'"); 
            $modNota = NotadinaspptkT::model()->find($cri);
            if (!empty($notadinaspptk_id)) {
                if (!empty($modNota) && ($modNota->notadinaspptk_id == $notadinaspptk_id)) {
                    $data['ok'] = 1;
                    $data['pesan'] = "ok";
                } else if (!empty($modNota) && ($modNota->notadinaspptk_id !== $notadinaspptk_id)) {
                    $data['ok'] = 0;
                    $data['pesan'] = "Nomor dokumen <b> ".$nomor_notadinas."</b> sudah dimasukkan pada <b> ".$modNota->notadinaspptk_nomor."</b>";
                } else {
                    $data['ok'] = 1;
                    $data['pesan'] = "ok";
                }
            } else {
                if (!empty($modNota)) {
                    $data['ok'] = 0;
                    $data['pesan'] = "Nomor dokumen <b> ".$nomor_notadinas."</b> sudah dimasukkan pada <b> ".$modNota->notadinaspptk_nomor."</b>";
                } else {
                    $data['ok'] = 1;
                    $data['pesan'] = "ok";
                }
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }
}
