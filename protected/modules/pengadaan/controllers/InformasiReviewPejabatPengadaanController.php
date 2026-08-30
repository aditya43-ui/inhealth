<?php

/**
 * Controller untuk Informasi Review Pejabat Pengadaan
 * @author Aida Rahmawati <aidarahmawati@.com>
 * 
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class InformasiReviewPejabatPengadaanController extends MyAuthController {

    public $path_view_detail = 'pengadaan.views.informasiReviewPejabatPengadaan.detail.';

    /**
     * Halaman Index
     */
    public function actionIndex() {
        $model = new ADInformasireviewpejabatpengadaanV();
        $model->tgl_awal = date("d M Y");
        $model->tgl_akhir = date("d M Y");
        $format = new MyFormatter();
        if (isset($_GET['ADInformasireviewpejabatpengadaanV'])) {
            $model->attributes = $_GET['ADInformasireviewpejabatpengadaanV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['ADInformasireviewpejabatpengadaanV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ADInformasireviewpejabatpengadaanV']['tgl_akhir']);
            $model->pegawaipengadaan_nama = isset($_GET['ADInformasireviewpejabatpengadaanV']['pegawaipengadaan_nama']) ? $_GET['ADInformasireviewpejabatpengadaanV']['pegawaipengadaan_nama'] : null;
            $model->pegppk_nama = isset($_GET['ADInformasireviewpejabatpengadaanV']['pegppk_nama']) ? $_GET['ADInformasireviewpejabatpengadaanV']['pegppk_nama'] : null;
        }
        $this->render('index', array('model' => $model));
    }

    /**
     * Detail Review Pejabat Pengadaan 
     * @param type $id
     * @return type
     */
    public function actionDetail($id) {
        $model = ADInformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
        $modPersiapan = PersiapanpengadaanT::model()->findByPk($model->persiapanpengadaan_id);
        $modRencana = RencanaumumpengadaanT::model()->findByPk($model->rencanaumumpengadaan_id);
        $model->persiapanpengadaan_tanggal = MyFormatter::formatDateTimeForUser($model->persiapanpengadaan_tanggal);
        if (!empty($modPersiapan->pegawaipembuat_id)) {
            $pegawaiPembuat = PegawaiM::model()->findByPk($modPersiapan->pegawaipembuat_id);
            if (!empty($pegawaiPembuat)) {
                $model->pegawaipembuat_nama = $pegawaiPembuat->namaLengkap;
            } else {
                $model->pegawaipembuat_nama = '-';
            }
        } else {
            $model->pegawaipembuat_nama = '-';
        }
        if (!empty($modPersiapan->unitkerja_id)) {
            $unitkerja = UnitkerjaM::model()->findByPk($modPersiapan->unitkerja_id);
            if (!empty($unitkerja)) {
                $model->namaunitkerja = $unitkerja->namaunitkerja;
            } else {
                $model->namaunitkerja = '-';
            }
        } else {
            $model->namaunitkerja = '-';
        }
        if (!empty($model->instalasi_id)) {
            $instalasi = InstalasiM::model()->findByPk($model->instalasi_id);
            if (!empty($instalasi)) {
                $model->instalasi_nama = $instalasi->instalasi_nama;
            } else {
                $model->instalasi_nama = '-';
            }
        } else {
            $model->instalasi_nama = '-';
        }
        if (!empty($modPersiapan->subprogram_id)) {
            $subprogramkerja = SubprogramkerjaM::model()->findByPk($modPersiapan->subprogram_id);
            $programkerja = ProgramkerjaM::model()->findByPk($subprogramkerja->programkerja_id);
            if (!empty($subprogramkerja)) {
                $model->subprogramkerja_nama = $subprogramkerja->subprogramkerja_kode . " - " . $subprogramkerja->subprogramkerja_nama;
            } else {
                $model->subprogramkerja_nama = '-';
            }
            if (!empty($programkerja)) {
                $model->programkerja_nama = $programkerja->programkerja_kode . " - " . $programkerja->programkerja_nama;
            } else {
                $model->programkerja_nama = '-';
            }
        } else {
            $model->subprogramkerja_nama = '-';
            $model->programkerja_nama = '-';
        }
        if (!empty($modPersiapan->metodepengadaan_id)) {
            $metode = MetodepengadaanM::model()->findByPk($modPersiapan->metodepengadaan_id);
            if (!empty($metode)) {
                $model->metodepengadaan_nama = $metode->metodepengadaan_nama;
            } else {
                $model->metodepengadaan_nama = '-';
            }
        } else {
            $model->metodepengadaan_nama = '-';
        }

        if (!empty($model->subkegiatanprogram_id)) {
            $model->subkegiatanprogram_nama = $model->subkegiatanprogram_kode . " - " . $model->subkegiatanprogram_nama;
        } else {
            $model->metodepengadaan_nama = '-';
        }

        if (!empty($modPersiapan->dpa_pagu)) {
            $modPersiapan->dpa_pagu = "Rp " . number_format($modPersiapan->dpa_pagu, 2, ',', '.');
        }
        $model->pemanfaatanbarang_tglawal = (!empty($model->pemanfaatanbarang_tglawal)) ? MyFormatter::formatDateTimeForUser($model->pemanfaatanbarang_tglawal) : null;
        $model->pemanfaatanbarang_tglakhir = (!empty($model->pemanfaatanbarang_tglakhir)) ? MyFormatter::formatDateTimeForUser($model->pemanfaatanbarang_tglakhir) : null;
        $model->pemilihanpenyedia_tglawal = (!empty($model->pemilihanpenyedia_tglawal)) ? MyFormatter::formatDateTimeForUser($model->pemilihanpenyedia_tglawal) : null;
        $model->pemilihanpenyedia_tglakhir = (!empty($model->pemilihanpenyedia_tglakhir)) ? MyFormatter::formatDateTimeForUser($model->pemilihanpenyedia_tglakhir) : null;
        $model->pelaksanaankontrak_tglawal = (!empty($model->pelaksanaankontrak_tglawal)) ? MyFormatter::formatDateTimeForUser($model->pelaksanaankontrak_tglawal) : null;
        $model->pelaksanaankontrak_tglakhir = (!empty($model->pelaksanaankontrak_tglakhir)) ? MyFormatter::formatDateTimeForUser($model->pelaksanaankontrak_tglakhir) : null;

        $model->nama_pekerjaan = !empty($modPersiapan->rencanaumumpengadaan_id) ? $modPersiapan->rencanaumumpengadaan->nama_pekerjaan : '';

        $modDetail = ADPersiapanpengadaandetT::model()->findAll(" persiapanpengadaan_id = '" . $id . "' ");
        $loadDokSiap = ADPengadaandokumenpendukungT::model()->findAll(" persiapanpengadaan_id = '" . $id . "' ORDER BY dokumenpengadaan_id ASC, dokumenpendukungpengadaan_id ASC ");
        $modDokumen = array();
        foreach ($loadDokSiap as $det) {
            $modDokumen[$det->dokumenpengadaan_id]['nama'] = $det->dokumenpendukungpengadaan_nama;
            $modDokumen[$det->dokumenpengadaan_id]['det'][$det->dokumenpendukungpengadaan_id]['file'] = $det->dokumenpendukungpengadaan_file;
            $modDokumen[$det->dokumenpengadaan_id]['det'][$det->dokumenpendukungpengadaan_id]['id'] = $det->dokumenpendukungpengadaan_id;
        }
        $modDokRUP = ADPengadaandokumenpendukungT::model()->findAll(" rencanaumumpengadaan_id ='" . $modPersiapan->rencanaumumpengadaan_id . "'");
        $modRiwayat = ADRiwayatpengadaanR::model()->findAllByAttributes(array('persiapanpengadaan_id' => $id));
        $modRiwayatPengadaan = new RiwayatpengadaanR();

        $modRiwayatPengadaan->riwayatpengadaan_catatan = "Melakukan Review Persiapan Pengadaan";
        $temp = '';
        return $this->render('detail', array(
                    'model' => $model,
                    'modRencana' => $modRencana,
                    'modDetail' => $modDetail,
                    'modDokumen' => $modDokumen,
                    'modRiwayat' => $modRiwayat,
                    'modPersiapan' => $modPersiapan,
                    'modRiwayatPengadaan' => $modRiwayatPengadaan,
                    'modDokRUP' => $modDokRUP
        ));
    }

    /**
     * Review Pejabat Pengadaan
     * Ada 3 status : Dilanjutkan, Revisi Dokumen, Revisi Rincian 
     * @param type $id
     * @return type
     */
    public function actionReview($id) {
        $model = ADInformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
        $modPersiapan = PersiapanpengadaanT::model()->findByPk($model->persiapanpengadaan_id);
        $modRencana = RencanaumumpengadaanT::model()->findByPk($model->rencanaumumpengadaan_id);
        $model->persiapanpengadaan_tanggal = MyFormatter::formatDateTimeForUser($model->persiapanpengadaan_tanggal);
        if (!empty($modPersiapan->pegawaipembuat_id)) {
            $pegawaiPembuat = PegawaiM::model()->findByPk($modPersiapan->pegawaipembuat_id);
            if (!empty($pegawaiPembuat)) {
                $model->pegawaipembuat_nama = $pegawaiPembuat->namaLengkap;
            } else {
                $model->pegawaipembuat_nama = '-';
            }
        } else {
            $model->pegawaipembuat_nama = '-';
        }
        if (!empty($modPersiapan->unitkerja_id)) {
            $unitkerja = UnitkerjaM::model()->findByPk($modPersiapan->unitkerja_id);
            if (!empty($unitkerja)) {
                $model->namaunitkerja = $unitkerja->namaunitkerja;
            } else {
                $model->namaunitkerja = '-';
            }
        } else {
            $model->namaunitkerja = '-';
        }
        if (!empty($model->instalasi_id)) {
            $instalasi = InstalasiM::model()->findByPk($model->instalasi_id);
            if (!empty($instalasi)) {
                $model->instalasi_nama = $instalasi->instalasi_nama;
            } else {
                $model->instalasi_nama = '-';
            }
        } else {
            $model->instalasi_nama = '-';
        }
        if (!empty($modPersiapan->subprogram_id)) {
            $subprogramkerja = SubprogramkerjaM::model()->findByPk($modPersiapan->subprogram_id);
            $programkerja = ProgramkerjaM::model()->findByPk($subprogramkerja->programkerja_id);
            if (!empty($subprogramkerja)) {
                $model->subprogramkerja_nama = $subprogramkerja->subprogramkerja_kode . " - " . $subprogramkerja->subprogramkerja_nama;
            } else {
                $model->subprogramkerja_nama = '-';
            }
            if (!empty($programkerja)) {
                $model->programkerja_nama = $programkerja->programkerja_kode . " - " . $programkerja->programkerja_nama;
            } else {
                $model->programkerja_nama = '-';
            }
        } else {
            $model->subprogramkerja_nama = '-';
            $model->programkerja_nama = '-';
        }
        if (!empty($modPersiapan->metodepengadaan_id)) {
            $metode = MetodepengadaanM::model()->findByPk($modPersiapan->metodepengadaan_id);
            if (!empty($metode)) {
                $model->metodepengadaan_nama = $metode->metodepengadaan_nama;
            } else {
                $model->metodepengadaan_nama = '-';
            }
        } else {
            $model->metodepengadaan_nama = '-';
        }

        if (!empty($model->subkegiatanprogram_id)) {
            $model->subkegiatanprogram_nama = $model->subkegiatanprogram_kode . " - " . $model->subkegiatanprogram_nama;
        } else {
            $model->metodepengadaan_nama = '-';
        }

        if (!empty($modPersiapan->dpa_pagu)) {
            $modPersiapan->dpa_pagu = "Rp " . number_format($modPersiapan->dpa_pagu, 2, ',', '.');
        }
        $model->pemanfaatanbarang_tglawal = (!empty($model->pemanfaatanbarang_tglawal)) ? MyFormatter::formatDateTimeForUser($model->pemanfaatanbarang_tglawal) : null;
        $model->pemanfaatanbarang_tglakhir = (!empty($model->pemanfaatanbarang_tglakhir)) ? MyFormatter::formatDateTimeForUser($model->pemanfaatanbarang_tglakhir) : null;
        $model->pemilihanpenyedia_tglawal = (!empty($model->pemilihanpenyedia_tglawal)) ? MyFormatter::formatDateTimeForUser($model->pemilihanpenyedia_tglawal) : null;
        $model->pemilihanpenyedia_tglakhir = (!empty($model->pemilihanpenyedia_tglakhir)) ? MyFormatter::formatDateTimeForUser($model->pemilihanpenyedia_tglakhir) : null;
        $model->pelaksanaankontrak_tglawal = (!empty($model->pelaksanaankontrak_tglawal)) ? MyFormatter::formatDateTimeForUser($model->pelaksanaankontrak_tglawal) : null;
        $model->pelaksanaankontrak_tglakhir = (!empty($model->pelaksanaankontrak_tglakhir)) ? MyFormatter::formatDateTimeForUser($model->pelaksanaankontrak_tglakhir) : null;

        $model->nama_pekerjaan = !empty($modPersiapan->rencanaumumpengadaan_id) ? $modPersiapan->rencanaumumpengadaan->nama_pekerjaan : '';

        $modDetail = ADPersiapanpengadaandetT::model()->findAll(" persiapanpengadaan_id = '" . $id . "' ");
        $loadDokSiap = ADPengadaandokumenpendukungT::model()->findAll(" persiapanpengadaan_id = '" . $id . "' ORDER BY dokumenpengadaan_id ASC, dokumenpendukungpengadaan_id ASC ");
        $modDokumen = array();
        foreach ($loadDokSiap as $det) {
            $modDokumen[$det->dokumenpengadaan_id]['nama'] = $det->dokumenpendukungpengadaan_nama;
            $modDokumen[$det->dokumenpengadaan_id]['det'][$det->dokumenpendukungpengadaan_id]['file'] = $det->dokumenpendukungpengadaan_file;
            $modDokumen[$det->dokumenpengadaan_id]['det'][$det->dokumenpendukungpengadaan_id]['id'] = $det->dokumenpendukungpengadaan_id;
        }
        $modDokRUP = ADPengadaandokumenpendukungT::model()->findAll(" rencanaumumpengadaan_id ='" . $modPersiapan->rencanaumumpengadaan_id . "'");
        $modRiwayat = ADRiwayatpengadaanR::model()->findAllByAttributes(array('persiapanpengadaan_id' => $id));
        $modRiwayatPengadaan = new RiwayatpengadaanR();

        $modRiwayatPengadaan->riwayatpengadaan_catatan = "Melakukan review Pejabat Pengadaan";
        $temp = '';
        if (isset($_POST['RiwayatpengadaanR'])) {
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modRiwayatPengadaan->persiapanpengadaan_id = $id;
                $modInformasiUmum = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
                $modInformasiUmum->infoumumpengadaan_status = $_POST['InformasireviewpejabatpengadaanV']['infoumumpengadaan_status'];
                $modRiwayatPengadaan->status_berkas = $modInformasiUmum->infoumumpengadaan_status;
                $pegawai = ADPegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                $modRiwayatPengadaan->pegawai_id = $pegawai->pegawai_id;
                $cekjab = PejabatpengadaanM::model()->findAllByAttributes(array('pegawai_id' => $modRiwayatPengadaan->pegawai_id));
                if (count($cekjab) == 1) {
                    $jab = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $modRiwayatPengadaan->pegawai_id));
                } else if (count($cekjab) > 1) {
                    $jab = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $modRiwayatPengadaan->pegawai_id, 'jabatan_pengadaan' => 'PPK'));
                }
                $modRiwayatPengadaan->nama_pegawai = !empty($pegawai) ? $pegawai->namaLengkap : '';
                $modRiwayatPengadaan->jabatan_pengadaan = !empty($jab) ? $jab->jabatan_pengadaan : '';
                $modRiwayatPengadaan->create_time = date('Y-m-d H:i:s');
                $modRiwayatPengadaan->tanggal_update = date('Y-m-d H:i:s');
                $modRiwayatPengadaan->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $modRiwayatPengadaan->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modRiwayatPengadaan->riwayatpengadaan_catatan = !empty($_POST['RiwayatpengadaanR']['riwayatpengadaan_catatan']) ? $_POST['RiwayatpengadaanR']['riwayatpengadaan_catatan'] : "Melakukan Review Persiapan Pengadaan";
                $modRiwayatPengadaan->riwayatpengadaan_lampiran = CUploadedFile::getInstance($modRiwayatPengadaan, 'riwayatpengadaan_lampiran');
                if (!empty($modRiwayatPengadaan->riwayatpengadaan_lampiran)) {
                    $dokumen_pendukung = $modRiwayatPengadaan->riwayatpengadaan_lampiran;
                    $fullImgName = str_replace(' ', '_', strtolower(date('dmY H:i:s') . $dokumen_pendukung));
                    $fullImgSource = Params::pathDokPersiapanPengadaanDirectory() . $fullImgName;

                    $modRiwayatPengadaan->riwayatpengadaan_lampiran = $fullImgName;

                    if (!empty($dokumen_pendukung)) {
                        if ($modRiwayatPengadaan->riwayatpengadaan_lampiran != $temp) {
                            if (!empty($temp)) {
                                if (file_exists(Params::pathDokPersiapanPengadaanDirectory() . $temp)) {
                                    unlink(Params::pathDokPersiapanPengadaanDirectory() . $temp);
                                }
                            }
                        }
                        
                        if (!file_exists(Params::pathDokPersiapanPengadaanDirectory())){
                            mkdir(Params::pathDokPersiapanPengadaanDirectory(), 0775, true);
                        }
                        
                        $dokumen_pendukung->saveAs($fullImgSource);
                    }
                }

                $ok = $modInformasiUmum->save() && $modRiwayatPengadaan->save();
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('review', 'id' => $id, 'sukses' => 'sukses'));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>a!</strong> Data gagal disimpan!');
                }
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', "Gagal! Data Gagal Disimpan." . MyExceptionMessage::getMessage($ex, true));
                $transaction->rollback();
            }
        }

        return $this->render('review', array(
                    'model' => $model,
                    'modRencana' => $modRencana,
                    'modDetail' => $modDetail,
                    'modDokumen' => $modDokumen,
                    'modRiwayat' => $modRiwayat,
                    'modPersiapan' => $modPersiapan,
                    'modRiwayatPengadaan' => $modRiwayatPengadaan,
                    'modDokRUP' => $modDokRUP
        ));
    }

    /**
     * Update Dokumen
     * @param type $id
     * @return type
     */
    public function actionUpdateDokumen($id) {
        $model = ADInformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
        $modPersiapan = PersiapanpengadaanT::model()->findByPk($model->persiapanpengadaan_id);
        $modRencana = RencanaumumpengadaanT::model()->findByPk($model->rencanaumumpengadaan_id);
        $modInfo = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
        
        if (isset($_POST['PengadaandokumenpendukungT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $modInfo->infoumumpengadaan_status = Params::STATUS_INFORMASI_UMUM_DIAJUKAN;
                if ($modInfo->update()) {
                    $ok &= true;
                }
                foreach ($_POST['PengadaandokumenpendukungT'] as $i => $load) {
                    if (!empty($load['det'])) {
                        foreach ($load['det'] as $a => $det) {
                            $dokumen_pendukung = null;
                            $modDok = new PengadaandokumenpendukungT();
                            $modDok->attributes = $model->attributes;
                            $modDok->attributes = $load;
                            $modDok->create_time = date('Y-m-d H:i:s');
                            $modDok->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                            $modDok->create_ruangan = Yii::app()->user->getState('ruangan_id');

                            $modDok->dokumenpendukungpengadaan_file = CUploadedFile::getInstance($modDok, '[' . $i . '][det][' . $a . ']dokumenpendukungpengadaan_file');
                            if (!empty($modDok->dokumenpendukungpengadaan_file)) {

                                $dokumen_pendukung = $modDok->dokumenpendukungpengadaan_file;
                                $fullImgName = $modDok->dokumenpendukungpengadaan_nama . "_" . $model->rencanaumumpengadaan_nomor . '.' . $dokumen_pendukung->getExtensionName();
                                if (!empty($modDok->persiapanpengadaan_id)) {
                                    $fullImgSource = Params::pathDokPersiapanPengadaanDirectory() . $fullImgName;
                                    
                                    if (!file_exists(Params::pathDokPersiapanPengadaanDirectory())){
                                        mkdir(Params::pathDokPersiapanPengadaanDirectory(), 0775, true);
                                    }
                                    
                                } else {
                                    $fullImgSource = Params::pathDokRencanaUmumPengadaanDirectory() . $fullImgName;
                                    
                                    if (!file_exists(Params::pathDokRencanaUmumPengadaanDirectory())){
                                        mkdir(Params::pathDokRencanaUmumPengadaanDirectory(), 0775, true);
                                    }
                                }

                                $modDok->dokumenpendukungpengadaan_file = $fullImgName;

                                $ok = $ok && $modDok->save();
                                
                                if (!empty($dokumen_pendukung)){		//                                                    
                                    $dokumen_pendukung->saveAs($fullImgSource);
                                }
                            }
                        }
                    } 
                }
                
                if (isset($_POST['ADPengadaandokumenpendukungT'])) {
                    foreach($_POST['ADPengadaandokumenpendukungT'] as $j => $load){
                        foreach($load['det'] as $k => $det){
                            $dokumen_pendukung = null;
                            $modDok = new ADPengadaandokumenpendukungT();
                            $modDok->attributes = $model->attributes;
                            $modDok->attributes = $load;
                            $modDok->attributes = $det;
                            $modDok->create_time = date('Y-m-d H:i:s');
                            $modDok->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                            $modDok->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            $modDok->dokumenpendukungpengadaan_file = CUploadedFile::getInstance($modDok, '[' . $j . '][det][' . $k . ']dokumenpendukungpengadaan_file');
                            if (!empty($modDok->dokumenpendukungpengadaan_file)) {
                                $dokumen_pendukung = $modDok->dokumenpendukungpengadaan_file;
                                $fullImgName = $modDok->dokumenpendukungpengadaan_nama . "_" . $model->rencanaumumpengadaan_nomor . '.' . $dokumen_pendukung->getExtensionName();
                                if (!empty($modDok->persiapanpengadaan_id)) {
                                    $fullImgSource = Params::pathDokPersiapanPengadaanDirectory() . $fullImgName;
                                    
                                    if (!file_exists(Params::pathDokPersiapanPengadaanDirectory())){
                                        mkdir(Params::pathDokPersiapanPengadaanDirectory(), 0775, true);
                                    }
                                } else {
                                    $fullImgSource = Params::pathDokRencanaUmumPengadaanDirectory() . $fullImgName;
                                    
                                    if (!file_exists(Params::pathDokRencanaUmumPengadaanDirectory())){
                                        mkdir(Params::pathDokRencanaUmumPengadaanDirectory(), 0775, true);
                                    }
                                }

                                $modDok->dokumenpendukungpengadaan_file = $fullImgName;

                                $ok = $ok && $modDok->save();
                                
                                if (!empty($dokumen_pendukung)){		//                                                    
                                    $dokumen_pendukung->saveAs($fullImgSource);
                                }
                            }
                        }
                    }
                }
                                
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('updateDokumen', 'id' => $id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        return $this->render('_formDokumen', array(
                    'model' => $model,
                    'modRencana' => $modRencana,
                    'modPersiapan' => $modPersiapan,
                    'modInfo' => $modInfo,
        ));
    }

    /**
     * Load row dokumen
     */
    public function actionLoadDokumen() {
        if (Yii::app()->request->isAjaxRequest) {
            $tipe = isset($_POST['tipe']) ? $_POST['tipe'] : null;
            $rencanaumumpengadaan_id = isset($_POST['rencanaumumpengadaan_id']) ? $_POST['rencanaumumpengadaan_id'] : null;
            $jenispengadaan_id = isset($_POST['jenispengadaan_id']) ? $_POST['jenispengadaan_id'] : null;

            $cri2 = new CDbCriteria();
            $cri2->join = " JOIN dokumenpengadaan_m dp ON dp.dokumenpengadaan_id = t.dokumenpengadaan_id ";
            if ($tipe == 'load') {
                $cri2->addCondition(" t.rencanaumumpengadaan_id = " . $rencanaumumpengadaan_id . " ");
            } else {
                $cri2->addCondition(" t.rencanaumumpengadaan_id = " . $rencanaumumpengadaan_id . " AND dp.jenispengadaan_id = " . $jenispengadaan_id . " ");
            }

            $jenis = PengadaandokumenpendukungT::model()->findAll($cri2);
            $jnspengadaan = PengadaanjenisT::model()->findAll(" t.rencanaumumpengadaan_id = " . $rencanaumumpengadaan_id . " ");
            $modRencana = RencanaumumpengadaanT::model()->findByPk($rencanaumumpengadaan_id);

            $jenis_id = array();
            $loadData = array();

            if (!empty($jenis)) {
                foreach ($jenis as $j) {
                    $loadData[$j->dokumenpengadaan_id]['dok_id'] = $j->dokumenpengadaan_id;
                    $loadData[$j->dokumenpengadaan_id]['nama'] = $j->dokumenpendukungpengadaan_nama;
                    $loadData[$j->dokumenpengadaan_id]['det'][$j->dokumenpendukungpengadaan_id]['file'] = $j->dokumenpendukungpengadaan_file;
                    $loadData[$j->dokumenpengadaan_id]['det'][$j->dokumenpendukungpengadaan_id]['id'] = $j->dokumenpendukungpengadaan_id;
                }
            }

            if (!empty($jnspengadaan)) {
                if ($tipe == 'load') {
                    foreach ($jnspengadaan as $p) {
                        $jenis_id[] = $p->jenispengadaan_id;
                    }
                } else {
                    $jenis_id[] = $jenispengadaan_id;
                }
            }

            $kategori = $modRencana->rencanaumumpengadaan_kategori;

            $trDok = '';

            $cri = new CDbCriteria();

            if (strtolower($kategori) == strtolower(Params::KATEGORI_PENGADAAN_PENYEDIA)) {
                if (!empty($jenis_id)) {
                    $cri->addInCondition(" jenispengadaan_id ", $jenis_id);
                } else {
                    $cri->addCondition(" dokumenpengadaan_id is null ");
                }
            } elseif (strtolower($kategori) == strtolower(Params::KATEGORI_PENGADAAN_SWAKELOLA)) {
                $cri->addCondition(" jenispengadaan_id IS NULL ");
            } else {
                $cri->addCondition(" dokumenpengadaan_id is null ");
            }
            $cri->addCondition(" metodepengadaan_id = " . $modRencana->metodepengadaan_id);
            $cri->addCondition(" dokumenpengadaan_aktif = TRUE AND dokumenpengadaan_jenistransaksi ilike '" . Params::DOKUMEN_PENGADAAN_RENCANA_UMUM_PENGADAAN . "' ");
            $cri->order = " dokumenpengadaan_urutan ASC ";
            $dok = ADDokumenpengadaanM::model()->findAll($cri);

            if (!empty($dok)) {
                foreach ($dok as $i => $d) {
                    $class = '';
                    $jenis = array();
                    $tipe = array();
                    $dok_det = array();

                    if ($d->file_zip) {
                        $tipe[] = '.zip';
                        $jenis[] = 'zip';
                    }

                    if ($d->file_rar) {
                        $tipe[] = '.rar';
                        $jenis[] = 'rar';
                    }

                    if ($d->file_word) {
                        $tipe[] = '.doc';
                        $tipe[] = '.docx';
                        $jenis[] = 'word';
                    }

                    if ($d->file_pdf) {
                        $tipe[] = '.pdf';
                        $jenis[] = 'pdf';
                    }

                    if ($d->file_excel) {
                        $tipe[] = '.xls';
                        $tipe[] = '.xlsx';
                        $jenis[] = 'excel';
                    }

                    if ($d->file_image) {
                        $tipe[] = 'image/*';
                        $jenis[] = 'image';
                    }

                    if ($d->dokumenpengadaan_wajib) {
                        $class = ' required ';
                    }

                    $modDok = new PengadaandokumenpendukungT();
                    $modDok->dokumenpengadaan_id = $d->dokumenpengadaan_id;
                    $modDok->dokumenpendukungpengadaan_nama = $d->dokumenpengadaan_nama;
                    $modDok->jenispengadaan_id = $d->jenispengadaan_id;
                    $modDok->rencanaumumpengadaan_id = $rencanaumumpengadaan_id;

                    if (isset($loadData[$d->dokumenpengadaan_id]['det'])) {
                        if (!empty($loadData[$d->dokumenpengadaan_id]['det'])) {
                            $dok_det = $loadData[$d->dokumenpengadaan_id]['det'];
                        }
                    } else {
                        $dok_det[0]['id'] = null;
                        $dok_det[0]['file'] = null;
                    }

                    $trDok .= $this->renderPartial($this->path_view_detail . '_rowDokDukung', array('jenis' => $jenis, 'tipe' => $tipe, 'required' => $class, 'modDok' => $modDok, 'i' => $i, 'det' => $dok_det), true);
                }
            }

            $data['dokDukung'] = $trDok;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Load row dokumen
     */
    public function actionLoadDokumenPersiapanPengadaan() {
        if (Yii::app()->request->isAjaxRequest) {
            $tipe = isset($_POST['tipe']) ? $_POST['tipe'] : null;
            $persiapanpengadaan_id = isset($_POST['persiapanpengadaan_id']) ? $_POST['persiapanpengadaan_id'] : null;

            $modPersiapan = PersiapanpengadaanT::model()->findByPk($persiapanpengadaan_id);
            $modRencana = RencanaumumpengadaanT::model()->findByPk($modPersiapan->rencanaumumpengadaan_id);
            $rencanaumumpengadaan_id = $modRencana->rencanaumumpengadaan_id;
            $kategori = $modRencana->rencanaumumpengadaan_kategori;
            $jenispengadaan_id = array();
            $jenis = PengadaanjenisT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $rencanaumumpengadaan_id));

            if (!empty($jenis)) {
                foreach ($jenis as $j) {
                    $jenispengadaan_id[] = $j->jenispengadaan_id;
                }
            }

            $trDok = '';
            $cri = new CDbCriteria();
            if (strtolower($kategori) == strtolower(Params::KATEGORI_PENGADAAN_PENYEDIA)) {
                if (!empty($jenispengadaan_id)) {
                    $cri->addInCondition(" jenispengadaan_id ", $jenispengadaan_id);
                } else {
                    $cri->addCondition(" dokumenpengadaan_id is null ");
                }
            } elseif (strtolower($kategori) == strtolower(Params::KATEGORI_PENGADAAN_SWAKELOLA)) {
                $cri->addCondition(" jenispengadaan_id IS NULL ");
            } else {
                $cri->addCondition(" dokumenpengadaan_id is null ");
            }
            $cond = '';
            if (!empty($modPersiapan)) {
                $cond = "AND metodepengadaan_id = '" . $modPersiapan->metodepengadaan_id . "' ";
            } elseif (!empty($modRencana)) {
                $cond = "AND metodepengadaan_id = '" . $modPersiapan->metodepengadaan_id . "' ";
            } else {
                $cond = "AND metodepengadaan_id is NULL ";
            }
            $cri->addCondition(" dokumenpengadaan_aktif = TRUE AND dokumenpengadaan_jenistransaksi = '" . Params::DOKUMEN_PENGADAAN_PERSIAPAN_PENGADAAN . "'  " . $cond);
            $cri->order = " dokumenpengadaan_urutan ASC ";
            $dok = ADDokumenpengadaanM::model()->findAll($cri);

            $cekDok = array();
            
            if (!empty($persiapanpengadaan_id)) {
                $loadDok = ADPengadaandokumenpendukungT::model()->findAllByAttributes(array('persiapanpengadaan_id' => $persiapanpengadaan_id));
                if (!empty($loadDok)) {
                    foreach ($loadDok as $file) {
                        $cekDok[$file->persiapanpengadaan_id][$rencanaumumpengadaan_id][$file->dokumenpengadaan_id]['det'][$file->dokumenpendukungpengadaan_id]['file'] = $file->dokumenpendukungpengadaan_file;
                        $cekDok[$file->persiapanpengadaan_id][$rencanaumumpengadaan_id][$file->dokumenpengadaan_id]['det'][$file->dokumenpendukungpengadaan_id]['id'] = $file->dokumenpendukungpengadaan_id;
                    }
                }
            }

            if (!empty($dok)) {
                foreach ($dok as $i => $d) {
                    $class = '';
                    $jenis = array();
                    $tipe = array();
                    $dok_det = array();

                    if ($d->file_zip) {
                        $tipe[] = '.zip';
                        $jenis[] = 'zip';
                    }

                    if ($d->file_rar) {
                        $tipe[] = '.rar';
                        $jenis[] = 'rar';
                    }

                    if ($d->file_word) {
                        $tipe[] = '.doc';
                        $tipe[] = '.docx';
                        $jenis[] = 'word';
                    }

                    if ($d->file_pdf) {
                        $tipe[] = '.pdf';
                        $jenis[] = 'pdf';
                    }

                    if ($d->file_excel) {
                        $tipe[] = '.xls';
                        $tipe[] = '.xlsx';
                        $jenis[] = 'excel';
                    }

                    if ($d->file_image) {
                        $tipe[] = 'image/*';
                        $jenis[] = 'image';
                    }

                    if ($d->dokumenpengadaan_wajib) {
                        $class = ' required ';
                    }

                    $modDok = new ADPengadaandokumenpendukungT();
                    $modDok->dokumenpengadaan_id = $d->dokumenpengadaan_id;
                    $modDok->dokumenpendukungpengadaan_nama = $d->dokumenpengadaan_nama;
                    $modDok->jenispengadaan_id = $d->jenispengadaan_id;
                    $modDok->persiapanpengadaan_id = $persiapanpengadaan_id;

                    if (isset($loadData[$d->dokumenpengadaan_id]['det'])) {
                        if (!empty($loadData[$d->dokumenpengadaan_id]['det'])) {
                            $dok_det = $loadData[$d->dokumenpengadaan_id]['det'];
                        }
                    } else {
                        $dok_det[0]['id'] = null;
                        $dok_det[0]['file'] = null;
                    }

                    $trDok .= $this->renderPartial($this->path_view_detail . '_rowDokDukung', array('jenis' => $jenis, 'tipe' => $tipe, 'required' => $class, 'modDok' => $modDok, 'i' => $i, 'det' => $dok_det), true);
                }
            }

            $data['dokDukung'] = $trDok;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Fungsi Cetak Review 
     */
    public function actionPrint() {
        $model = new ADInformasireviewpejabatpengadaanV();
        $model->tgl_awal = date("d M Y");
        $model->tgl_akhir = date("d M Y");
        $format = new MyFormatter();
        if (isset($_REQUEST['ADInformasireviewpejabatpengadaanV'])) {
            $model->attributes = $_REQUEST['ADInformasireviewpejabatpengadaanV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['ADInformasireviewpejabatpengadaanV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ADInformasireviewpejabatpengadaanV']['tgl_akhir']);
            $model->pegawaipengadaan_nama = isset($_GET['ADInformasireviewpejabatpengadaanV']['pegawaipengadaan_nama']) ? $_GET['ADInformasireviewpejabatpengadaanV']['pegawaipengadaan_nama'] : null;
            $model->pegppk_nama = isset($_GET['ADInformasireviewpejabatpengadaanV']['pegppk_nama']) ? $_GET['ADInformasireviewpejabatpengadaanV']['pegppk_nama'] : null;
        }
        $judulLaporan = 'Data Review Pejabat Pengadaan';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');      //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');         //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
        }
    }

}
