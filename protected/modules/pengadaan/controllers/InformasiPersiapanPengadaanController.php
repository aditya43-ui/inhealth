<?php

/**
 * digunakan sebagai informasi persiapan pengadaan
 * @author Elham Budianto <elhambudianto@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * */
class InformasiPersiapanPengadaanController extends MyAuthController {

    public $path_view = 'pengadaan.views.informasiPersiapanPengadaan.';
    public $path_view_detail = 'pengadaan.views.informasiPersiapanPengadaan.detail.';
    public $simpan = false;

    /**
     * Digunakan untuk menampilkan data persiapan pengadaan
     */
    public function actionIndex() {
        $model = new ADInformasipersiapanpengadaanV('searchInformasi');
        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");
        if (isset($_GET['ADInformasipersiapanpengadaanV'])) {
            $model->attributes = $_GET['ADInformasipersiapanpengadaanV'];
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['instalasi_nama'])) {
                $model->instalasi_nama = $_GET['ADInformasipersiapanpengadaanV']['instalasi_nama'];
            }
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['nama_pekerjaan'])) {
                $model->nama_pekerjaan = $_GET['ADInformasipersiapanpengadaanV']['nama_pekerjaan'];
            }
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['rencanaumumpengadaan_kategori'])) {
                $model->rencanaumumpengadaan_kategori = $_GET['ADInformasipersiapanpengadaanV']['rencanaumumpengadaan_kategori'];
            }
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['daftarjenispengadaan'])) {
                $model->daftarjenispengadaan = $_GET['ADInformasipersiapanpengadaanV']['daftarjenispengadaan'];
            }
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['metodepengadaan_nama'])) {
                $model->metodepengadaan_nama = $_GET['ADInformasipersiapanpengadaanV']['metodepengadaan_nama'];
            }
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['persiapanpengadaan_status'])) {
                $model->persiapanpengadaan_status = $_GET['ADInformasipersiapanpengadaanV']['persiapanpengadaan_status'];
            }
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['rencanaumumpengadaan_nomor'])) {
                $model->rencanaumumpengadaan_nomor = $_GET['ADInformasipersiapanpengadaanV']['rencanaumumpengadaan_nomor'];
            }
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['kode_rup'])) {
                $model->kode_rup = $_GET['ADInformasipersiapanpengadaanV']['kode_rup'];
            }
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['ADInformasipersiapanpengadaanV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['ADInformasipersiapanpengadaanV']['tgl_akhir']);
        }
        $this->render($this->path_view . 'index', array(
            'model' => $model,
                )
        );
    }

    /**
     * Digunakan untuk mencetak dokumen
     */
    public function actionPrint() {
        $model = new ADInformasipersiapanpengadaanV();
        if (isset($_GET['ADInformasipersiapanpengadaanV'])) {
            $model->attributes = $_GET['ADInformasipersiapanpengadaanV'];
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['instalasi_nama'])) {
                $model->instalasi_nama = $_GET['ADInformasipersiapanpengadaanV']['instalasi_nama'];
            }
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['nama_pekerjaan'])) {
                $model->nama_pekerjaan = $_GET['ADInformasipersiapanpengadaanV']['nama_pekerjaan'];
            }
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['rencanaumumpengadaan_kategori'])) {
                $model->rencanaumumpengadaan_kategori = $_GET['ADInformasipersiapanpengadaanV']['rencanaumumpengadaan_kategori'];
            }
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['daftarjenispengadaan'])) {
                $model->daftarjenispengadaan = $_GET['ADInformasipersiapanpengadaanV']['daftarjenispengadaan'];
            }
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['metodepengadaan_nama'])) {
                $model->metodepengadaan_nama = $_GET['ADInformasipersiapanpengadaanV']['metodepengadaan_nama'];
            }
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['persiapanpengadaan_status'])) {
                $model->persiapanpengadaan_status = $_GET['ADInformasipersiapanpengadaanV']['persiapanpengadaan_status'];
            }
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['rencanaumumpengadaan_nomor'])) {
                $model->rencanaumumpengadaan_nomor = $_GET['ADInformasipersiapanpengadaanV']['rencanaumumpengadaan_nomor'];
            }
            if (!empty($_GET['ADInformasipersiapanpengadaanV']['kode_rup'])) {
                $model->kode_rup = $_GET['ADInformasipersiapanpengadaanV']['kode_rup'];
            }
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['ADInformasipersiapanpengadaanV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['ADInformasipersiapanpengadaanV']['tgl_akhir']);
        }
        $judulLaporan = 'Data Persiapan Pengadaan';
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
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
        }
    }

    /**
     * Menampilkan detail dari persiapan pengadaan
     * @param type $id
     */
    public function actionDetail($id) {
        //$model = PersiapanpengadaanT::model()->findByPk($id);
        $model = ADInformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
        $modPersiapan = PersiapanpengadaanT::model()->findByPk($model->persiapanpengadaan_id);
        $modRencana = RencanaumumpengadaanT::model()->findByPk($model->rencanaumumpengadaan_id);
        $modDokRUP = ADPengadaandokumenpendukungT::model()->findAll(" rencanaumumpengadaan_id ='" . $modPersiapan->rencanaumumpengadaan_id . "'");
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
            $sub = SubkegiatanprogramM::model()->findByPk($model->subkegiatanprogram_id);
            $model->subkegiatanprogram_nama = $sub->subkegiatanprogram_kode . " - " . $sub->subkegiatanprogram_nama;
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
        foreach($loadDokSiap as $det){
            $modDokumen[$det->dokumenpengadaan_id]['nama'] = $det->dokumenpendukungpengadaan_nama;
            $modDokumen[$det->dokumenpengadaan_id]['det'][$det->dokumenpendukungpengadaan_id]['file'] = $det->dokumenpendukungpengadaan_file;
            $modDokumen[$det->dokumenpengadaan_id]['det'][$det->dokumenpendukungpengadaan_id]['id'] = $det->dokumenpendukungpengadaan_id;
        }        
        
        $modRiwayat = ADRiwayatpengadaanR::model()->findAllByAttributes(array('persiapanpengadaan_id' => $id));
        return $this->render($this->path_view_detail . 'index', array(
                    'model' => $model,
                    'modRencana' => $modRencana,
                    'modDetail' => $modDetail,
                    'modDokumen' => $modDokumen,
                    'modRiwayat' => $modRiwayat,
                    'modPersiapan' => $modPersiapan,
                    'modDokRUP' => $modDokRUP,
        ));
    }

    /**
     * Fungsi unduh file
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = ADPengadaandokumenpendukungT::model()->findByPk($id);
        $path = Params::pathDokPersiapanPengadaanDirectory() . $filename->dokumenpendukungpengadaan_file;
        if (!empty($filename->dokumenpendukungpengadaan_file)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->dokumenpendukungpengadaan_file, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));
        }
    }
    
    /**
     * Proses unduh dokumen pendukung
     * @param integer $dokumenpendukungpengadaan_id
     */
    public function actionUnduhDok($dokumenpendukungpengadaan_id) {

        $filename = ADPengadaandokumenpendukungT::model()->findByPk($dokumenpendukungpengadaan_id);

        $path = Params::pathDokPersiapanPengadaanDirectory() . $filename->dokumenpendukungpengadaan_file;

        if (!empty($filename->dokumenpendukungpengadaan_file)) {
            if (file_exists($path)) {

                Yii::app()->getRequest()->sendFile($filename->dokumenpendukungpengadaan_file, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));
        }
    }
    
    /**
     * Proses unduh dokumen pendukung RUP
     * @param integer $dokumenpendukungpengadaan_id
     */
    public function actionUnduhDokRUP($dokumenpendukungpengadaan_id) {

        $filename = ADPengadaandokumenpendukungT::model()->findByPk($dokumenpendukungpengadaan_id);

        $path = Params::pathDokRencanaUmumPengadaanDirectory() . $filename->dokumenpendukungpengadaan_file;

        if (!empty($filename->dokumenpendukungpengadaan_file)) {
            if (file_exists($path)) {

                Yii::app()->getRequest()->sendFile($filename->dokumenpendukungpengadaan_file, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'. 'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'. 'file_tidak_ditemukan.txt'));
        }
    }

    /**
     * Fungsi unduh file
     * @param type $id
     */
    public function actionUnduhRiwayat($id) {
        $filename = ADRiwayatpengadaanR::model()->findByPk($id);
        $path = Params::pathDokPersiapanPengadaanDirectory() . $filename->riwayatpengadaan_lampiran;
        if (!empty($filename->riwayatpengadaan_lampiran)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->riwayatpengadaan_lampiran, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'. 'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'. 'file_tidak_ditemukan.txt'));
        }
    }
    
    /**
     * Fungsi unduh file
     * @param type $id
     */
    public function actionUnduhDokumenRiwayat($id) {
        $filename = ADRiwayatpengadaanR::model()->findByPk($id);
        $path = Params::pathLampiranRiwayatPengadaanDirectory(). $filename->riwayatpengadaan_lampiran;
        
        if (!empty($filename->riwayatpengadaan_lampiran)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->riwayatpengadaan_lampiran, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'. 'file_tidak_ditemukan.txt'));
        }
    }

    /**
     * Menampilkan detail dari persiapan pengadaan
     * @param type $id
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
        foreach($loadDokSiap as $det){
            $modDokumen[$det->dokumenpengadaan_id]['nama'] = $det->dokumenpendukungpengadaan_nama;
            $modDokumen[$det->dokumenpengadaan_id]['det'][$det->dokumenpendukungpengadaan_id]['file'] = $det->dokumenpendukungpengadaan_file;
            $modDokumen[$det->dokumenpengadaan_id]['det'][$det->dokumenpendukungpengadaan_id]['id'] = $det->dokumenpendukungpengadaan_id;
        }
        $modDokRUP = ADPengadaandokumenpendukungT::model()->findAll(" rencanaumumpengadaan_id ='" . $modPersiapan->rencanaumumpengadaan_id . "'");
        $modRiwayat = ADRiwayatpengadaanR::model()->findAllByAttributes(array('persiapanpengadaan_id' => $id));
        $modRiwayatPengadaan = new RiwayatpengadaanR();

        $modRiwayatPengadaan->riwayatpengadaan_catatan = "Melakukan Review Persiapan Pengadaan";
        $temp = '';
        if (isset($_POST['RiwayatpengadaanR'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modRiwayatPengadaan->persiapanpengadaan_id = $id;
                $this->simpan = $this->simpanRiwayat($_POST['RiwayatpengadaanR'], $id);
                if ($this->simpan) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    if ($_POST['RiwayatpengadaanR']['statusnya'] == 'DISETUJUI') {
                        $this->redirect(array('/'.$this->module->id.'/informasiPersiapanPengadaan/index','ADInformasipersiapanpengadaanV[rencanaumumpengadaan_nomor]'=>$model->rencanaumumpengadaan_nomor, 'ADInformasipersiapanpengadaanV[tgl_awal]' => $model->persiapanpengadaan_tanggal, 'ADInformasipersiapanpengadaanV[tgl_akhir]' => $model->persiapanpengadaan_tanggal));
                    } else {
                        $this->redirect(array('review', 'id' => $id, 'sukses' => 'sukses'));
                    }

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
     * Simpan riwayat sesuai dengan data status yang di-input pada halaman review
     * Ada 2 status: Disetujui dan Revisi
     * @param type $post
     * @param type $id
     * @return boolean
     */
    public function simpanRiwayat($post, $id) {
        $riwayat = new RiwayatpengadaanR;
        $riwayat->persiapanpengadaan_id = $id;
        $pegawai = ADPegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $riwayat->pegawai_id = $pegawai->pegawai_id;
        $riwayat->nama_pegawai = !empty($pegawai) ? $pegawai->namaLengkap : '';
        $riwayat->jabatan_pengadaan = Params::JABATAN_PENGADAAN_KA_UPPTSA;
        if ($post['statusnya'] == Params::STATUS_PENGAJUAN_DISETUJUI) {
            $cekmodel = PersiapanpengadaanT::model()->findByPk($id);
            if($cekmodel->persiapanpengadaan_status == 'Diajukan'){
                $riwayat->status_berkas = 'Disetujui';
            }
        } else {
            $riwayat->status_berkas = Params::STATUS_PERSIAPAN_REVISI;
        }
        
        $riwayat->riwayatpengadaan_lampiran = CUploadedFile::getInstance($riwayat, 'riwayatpengadaan_lampiran');                                

        if (!empty($riwayat->riwayatpengadaan_lampiran)){
            $dokumenpendukung = $riwayat->riwayatpengadaan_lampiran;

            $fullImgName = str_replace(' ','_',strtolower(date('dmY_s').$dokumenpendukung));
            $fullImgSource = Params::pathLampiranRiwayatPengadaanDirectory() . $fullImgName;

            $riwayat->riwayatpengadaan_lampiran = $fullImgName;
        }
        $riwayat->riwayatpengadaan_catatan = $post['riwayatpengadaan_catatan'];
        $riwayat->create_time = date('Y-m-d H:i:s');
        $riwayat->tanggal_update = date('Y-m-d H:i:s');
        $riwayat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $riwayat->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $riwayat->save();
        $update = PersiapanpengadaanT::model()->updateByPk($id, array('persiapanpengadaan_status' => $riwayat->status_berkas));
        if (!empty($dokumenpendukung)){  
            
            if (!file_exists(Params::pathLampiranRiwayatPengadaanDirectory())){
                mkdir(Params::pathLampiranRiwayatPengadaanDirectory(), 0775, true);
            }
            
            $dokumenpendukung->saveAs($fullImgSource);
        }
        
        if (!$riwayat->save() && $update) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Cetak Uraian
     * @param type $id
     */
    public function actionPrintHps($id) {
        $this->layout = '//layouts/printWindows';
        $model = ADPersiapanpengadaanT::model()->findByPk($id);
        $modDetail = ADPersiapanpengadaandetT::model()->findAllByAttributes(array("persiapanpengadaan_id" => $id));

        $this->render('printHPS', array('model' => $model, 'modelDetail' => $modDetail));
    }

    /**
     * Load dokumen pendukung
     */
    public function actionLoadDokpendukung() {
        if (Yii::app()->request->isAjaxRequest) {

            $kategori = isset($_POST['kategori']) ? $_POST['kategori'] : null;
            $persiapanpengadaan_id = isset($_POST['persiapanpengadaan_id']) ? $_POST['persiapanpengadaan_id'] : null;
            $cekmodel = PersiapanpengadaanT::model()->findByPk($persiapanpengadaan_id);
            $rencanaumumpengadaan_id = isset($cekmodel->rencanaumumpengadaan_id) ? $cekmodel->rencanaumumpengadaan_id : null;

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
            $cri->addCondition(" dokumenpengadaan_aktif = TRUE AND dokumenpengadaan_jenistransaksi = '" . Params::DOKUMEN_PENGADAAN_PERSIAPAN_PENGADAAN . "' ");
            $cri->order = " dokumenpengadaan_urutan ASC ";
            $dok = ADDokumenpengadaanM::model()->findAll($cri);

            $cekDok = array();

            if (!empty($persiapanpengadaan_id)) {
                $loadDok = ADPengadaandokumenpendukungT::model()->findAllByAttributes(array('persiapanpengadaan_id' => $persiapanpengadaan_id));

                if (!empty($loadDok)) {
                    foreach ($loadDok as $file) {
                        $cekDok[$file->persiapanpengadaan_id][$rencanaumumpengadaan_id][$file->dokumenpengadaan_id]['file'] = $file->dokumenpendukungpengadaan_file;
                        $cekDok[$file->persiapanpengadaan_id][$rencanaumumpengadaan_id][$file->dokumenpengadaan_id]['id'] = $file->dokumenpendukungpengadaan_id;
                    }
                }
            }

            if (!empty($dok)) {
                foreach ($dok as $i => $d) {
                    $class = '';
                    $jenis = array();
                    $tipe = array();

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
                    if (isset($cekDok[$persiapanpengadaan_id][$rencanaumumpengadaan_id][$d->dokumenpengadaan_id]['id'])) {
                        $modDok->dokumenpendukungpengadaan_file = $cekDok[$persiapanpengadaan_id][$rencanaumumpengadaan_id][$d->dokumenpengadaan_id]['file'];
                        $modDok->dokumenpendukungpengadaan_id = $cekDok[$persiapanpengadaan_id][$rencanaumumpengadaan_id][$d->dokumenpengadaan_id]['id'];
                    }
                    $modDok->dokumenpendukungpengadaan_nama = $d->dokumenpengadaan_nama;
                    $modDok->dokumenpengadaan_id = $d->dokumenpengadaan_id;
                    $modDok->temp_file = $modDok->dokumenpendukungpengadaan_file;

                    $trDok .= $this->renderPartial('_rowDokDukung', array('jenis' => $jenis, 'tipe' => $tipe, 'required' => $class, 'modDok' => $modDok, 'i' => $i), true);
                }
            }
            $data['sukses'] = 1;
            $data['dokDukung'] = $trDok;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Halaman Pejabat Pengadaan
     * @param type $persiapanpengadaan_id
     */
    public function actionPejabatPengadaan($persiapanpengadaan_id){
        $this->layout = '//layouts/iframe';
        $model = ADPersiapanpengadaanT::model()->findByPk($persiapanpengadaan_id);
        $modPersiapan = ADInformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
        $modPersiapan->pemilihanpenyedia_tglawal = MyFormatter::formatDateTimeForUser($modPersiapan->pemilihanpenyedia_tglawal) . " - " . MyFormatter::formatDateTimeForUser($modPersiapan->pemilihanpenyedia_tglakhir);
        $modPersiapan->total_hargaseluruhnya = number_format($modPersiapan->total_hargaseluruhnya, 2, ',', '.');
        
        $modInfo = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $persiapanpengadaan_id));
        if (!empty($modInfo)) {
            $modInfo->pegpengadaan_nama = $modInfo->pegpengadaan->namaLengkap; 
            $modInfo->tgl_sk = MyFormatter::formatDateTimeForUser($modInfo->tgl_sk);
        } else {
            $modInfo = new InfoumumpengadaanT();
        }
        
        if (isset($_POST['InfoumumpengadaanT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                $modInfo->attributes = $_POST['InfoumumpengadaanT'];
                $modInfo->persiapanpengadaan_id = $persiapanpengadaan_id; 
                $modInfo->pegpa_id = $modPersiapan->pegawaipa_id; 
                $modInfo->pegkpa_id = $modPersiapan->pegawaikpa_id;
                $modInfo->pegppk_id = $modPersiapan->pegawaippk_id;
                $modInfo->tgl_sk = MyFormatter::formatDateTimeForDb($modInfo->tgl_sk);
                
                if (empty($modInfo->infoumumpengadaan_id)) {
                    $modInfo->infoumumpengadaan_status = 'Diajukan'; 
                    $modInfo->create_loginpemakai_id = Yii::app()->user->id;
                    $modInfo->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modInfo->create_time = date ('Y-m-d H:i:s');
                } 
                
                $ok = $ok && $modInfo->save(); 

                // Kirim SMS Dari KUPBJ Ke Pejabat Pengadaan
                $nama_modul = Yii::app()->controller->module->id;
                $nama_controller = Yii::app()->controller->id;
                $nama_action = Yii::app()->controller->action->id;
                $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
                //LoadSMS
                $criteria = new CDbCriteria;
                $criteria->compare('modul_id', $modul_id);
                $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
                $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
                $criteria->addCondition(" statussms = true AND tujuansms = 'pegawai' ");
                $modSmsgateway = SmsgatewayM::model()->find($criteria);

                if (!empty($modSmsgateway)) {
                    $template = $modSmsgateway->templatesms;
                } else {
                    $template = "To Pejabat Pengadaan: Persiapan Pengadaan nomor {{nomor_pp}} tanggal {{tanggal_pp}} dengan metode {{metode_pengadaan}} nama unit kerja {{nama_unitkerja}} pekerjaan {{nama_pekerjaan}}. Mohon untuk segera mengisi Kelengkapan Dokumen Pengadaan.";
                }

                $modPejabatPengadaan     = PegawaiM::model()->findByPk($modInfo->pegpengadaan_id);

                if (!empty($modPejabatPengadaan)) {
                    $isiPesan = $template;
                    $attributes = $model->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        $isiPesan = str_replace("{{nomor_pp}}", $model->persiapanpengadaan_nomor, $isiPesan);
                        $isiPesan = str_replace("{{tanggal_pp}}", $model->persiapanpengadaan_tanggal, $isiPesan);
                        $isiPesan = str_replace("{{metode_pengadaan}}", $model->metodepengadaan_nama, $isiPesan);

                        $isiPesan = str_replace("{{nama_unitkerja}}", $model->unitkerja->namaunitkerja, $isiPesan);
                        $isiPesan = str_replace("{{nama_pekerjaan}}", $model->rencanaumumpengadaan->nama_pekerjaan, $isiPesan);
                    }
                    $api = new MyAPI();
                    if (!empty($modPejabatPengadaan->nomobile_pegawai)) {
                        $res = $api->smsBlastSend(array($modPejabatPengadaan->nomobile_pegawai), 'RSDrSoetomo', $isiPesan);
                        CustomFunction::addSentItem($res, 'RSDrSoetomo', $isiPesan);
                    }//END OF if (!empty($modPejabatPengadaan->nomobile_pegawai))
                }//END of if (!empty($modPejabatPengadaan))
                //END OF Kirim SMS Dari KUPBJ Ke Pejabat Pengadaan


                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");   
                    $this->redirect(array('pejabatPengadaan', 'persiapanpengadaan_id' => $persiapanpengadaan_id, 'sukses' => 'sukses'));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($modInfo));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render($this->path_view.'/pejabatPengadaan/index', 
            array(
                'model' => $model, 
                'modPersiapan' => $modPersiapan,
                'modInfo' => $modInfo));
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

}
