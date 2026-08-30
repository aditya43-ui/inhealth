<?php

/**
 * Form Surat Perjanjian Kerja
 * 
 * @author     Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author     Andyka Putra <andykaputra@.com>
 * @author     Aida Rahmawati <aidarahmawati@.com>
 * @package    application.modules.pengadaan
 * @subpackage controllers
 * @category   controller
 */
class SuratPerjanjianKerjaController extends MyAuthController {

    public $path_view = "application.modules.pengadaan.views.suratPerjanjianKerja.";

    /**
     * Autocomplete kegiatan program untuk field Program
     * 
     * @param string  $term       Nama Program yang dicari     
     * @param integer $program_id ID Program kerja.
     */
    public function actionAutocompleteKegiatan($term = "", $program_id = null) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $modKegiatan = new SubkegiatanprogramM('search');
        $modKegiatan->unsetAttributes();
        $modKegiatan->subkegiatanprogram_aktif = true;
        $modKegiatan->subkegiatanprogram_nama = $term;
        $modKegiatan->kegiatanprogram_id = $program_id;

        $prov = $modKegiatan->search();
        $prov->sort->defaultOrder = 'subkegiatanprogram_nourut';

        $res = array();

        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->subkegiatanprogram_kode . " - " . $item->subkegiatanprogram_nama;
            $sub['value'] = $item->subkegiatanprogram_id;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    /**
     * Autocomplete untuk mengambil data pegawai untuk field Kuasa Pengguna.
     * 
     * @param string $term nama kuasa yang dicari.
     */
    public function actionAutocompleteKuasaPengguna($term = "") {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $modKuasa = new PegawaiV('search');
        $modKuasa->unsetAttributes();
        $modKuasa->pegawai_aktif = true;
        $modKuasa->nama_pegawai = $term;

        $prov = $modKuasa->search();
        $prov->sort->defaultOrder = 'nama_pegawai';
        $prov->criteria->limit = 15;

        $res = array();

        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->pegawai_id;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    /**
     * Autocomplete untuk mengambil data pegawai untuk field Pejabat Pengguna.
     * 
     * @param string $term nama pejabat yang dicari.
     */
    public function actionAutocompletePejabatPengguna($term = "") {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $modPejabat = new PegawaiV('search');
        $modPejabat->unsetAttributes();
        $modPejabat->pegawai_aktif = true;
        $modPejabat->nama_pegawai = $term;

        $prov = $modPejabat->search();
        $prov->sort->defaultOrder = 'nama_pegawai';
        $prov->criteria->limit = 15;

        $res = array();

        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->pegawai_id;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    /**
     * Autocomplete untuk mengambil data supplier untuk field Penyesia barang jas
     * 
     * @param string $term nama supplier yang dicari
     */
    public function actionAutocompletePenyediaBarangJasa($term = "") {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $modSupplier = new ADSupplierM('search');
        $modSupplier->unsetAttributes();
        $modSupplier->supplier_nama = $term;

        $prov = $modSupplier->searchDialogPenyedia();
        $prov->sort->defaultOrder = 'supplier_nama';

        $res = array();

        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->supplier_nama;
            $sub['value'] = $item->supplier_id;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    /**
     * Autocomplete untuk mengambil data program kerja untuk field Pengguna.
     * 
     * @param string $term nama program kerja yang dicari.
     */
    public function actionAutocompleteProgram($term = "") {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $modProgram = new KegiatanprogramM('search');
        $modProgram->unsetAttributes();
        $modProgram->kegiatanprogram_nama = $term;
        $modProgram->kegiatanprogram_aktif = true;

        $prov = $modProgram->search();
        $prov->sort->defaultOrder = 'kegiatanprogram_nourut';
        $prov->criteria->limit = 10;

        $res = array();

        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->kegiatanprogram_kode . " - " . $item->kegiatanprogram_nama;
            $sub['value'] = $item->kegiatanprogram_id;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    /**
     * Autocomplete untuk mengambil data rekening akuntansi untuk field Rekening
     * 
     * @param string $term nama rekening5 yang dicari.
     */
    public function actionAutocompleteRekening($term = "") {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $modRekDebit = new RekeningakuntansiV('search');
        $modRekDebit->unsetAttributes();
        // $modRekDebit->rekening5_nb = "D";
        $modRekDebit->rekening5_aktif = true;
        $modRekDebit->nmrekening5 = $term;

        $prov = $modRekDebit->searchAccounts();
        $prov->criteria->limit = 10;
        $prov->sort->defaultOrder = 'kdrekening5';

        $res = array();

        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->kdrekening5 . " - " . $item->nmrekening5;
            $sub['value'] = $item->rekening5_id;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    /**
     * Form Surat Perjanjian Kerja
     * 
     * @param type $id ID Surat Perjanjian yang di-load setelah submit.
     */
    public function actionIndexold($id = null) {
        $model = new SuratperjanjiankerjaT;
        $model->setDefaultData();


        if (!empty($id)) {
            $model = SuratperjanjiankerjaT::model()->findByPk($id);
            $sup = SupplierM::model()->findByPk($model->supplier_id);
            $model->nama_supplier = $sup->supplier_cp;
            $model->jabatan_supplier = $sup->supplier_cp_jabatan;
            $model->alamat_supplier = $sup->supplier_alamat;


            $model->tglputusanpenggunaanggaran = MyFormatter::formatDateTimeForUser($model->tglputusanpenggunaanggaran);
            $model->tgl_dpa = MyFormatter::formatDateTimeForUser($model->tgl_dpa);
            $model->tglpenawaran = MyFormatter::formatDateTimeForUser($model->tglpenawaran);
            $model->tglsuratperjanjian = MyFormatter::formatDateTimeForUser($model->tglsuratperjanjian);
            $model->tglawal_pekerjaan = MyFormatter::formatDateTimeForUser($model->tglawal_pekerjaan);
            $model->tglakhir_pekerjaan = MyFormatter::formatDateTimeForUser($model->tglakhir_pekerjaan);

            $model->nilaikontrak = MyFormatter::formatNumberForPrint($model->nilaikontrak);
        }

        if (isset($_POST['SuratperjanjiankerjaT'])) {
            $trans = Yii::app()->db->beginTransaction();

            try {
                if ($model->saveSuratPerjanjian($_POST)) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'id' => $model->suratperjanjiankerja_id));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
                }
            } catch (CException $e) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data Gagal Disimpan " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
        ));
    }

    /**
     * Form Surat Perjanjian Kerja
     * 
     * @author  Andyka Putra <andykaputra@.com>
     * @package application.models
     * @param type $id ID Persiapan pengadaan yang dipilih.
     */
    public function actionIndex($id = null) {
        $this->layout = '//layouts/iframe';
        $model = new SuratperjanjiankerjaT;
        $model->setDefaultData();
        $model->nosuratperjanjiankerja = '--Otomatis--';
        $model->tglsuratperjanjian = $model->tgl_dpa = $model->bahasilpl_tanggal = $model->suratundanganpl_tanggal = MyFormatter::formatDateTimeForUser(date('d M Y H:i:s'));
        $modPengadaan = new PersiapanpengadaanT;
        $modTermin = new SuratperjanjiankerjaterminT();
        $modTermin2 = new ADSuratperjanjiankerjaterminT();
        if (!empty($id)) {
            $modPengadaan = PersiapanpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
            $cekPerjanjiankerja = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id,'isbatal' => false, 'isaddendum' => true));
            if (!empty($cekPerjanjiankerja)) {
                $model = SuratperjanjiankerjaT::model()->findByPk($cekPerjanjiankerja->suratperjanjiankerja_id);
                $sup = SupplierM::model()->findByPk($model->supplier_id);
                $model->nama_supplier = $sup->supplier_cp;
                $model->jabatan_supplier = $sup->supplier_cp_jabatan;
                $model->alamat_supplier = $sup->supplier_alamat;

                $model->tglputusanpenggunaanggaran = MyFormatter::formatDateTimeForUser($model->tglputusanpenggunaanggaran);
                $model->tgl_dpa = MyFormatter::formatDateTimeForUser($model->tgl_dpa);
                $model->tglsuratperjanjian = MyFormatter::formatDateTimeForUser($model->tglsuratperjanjian);
                $modPengadaan->pelaksanaankontrak_tglawal = date('d M Y', strtotime($model->tglawal_pekerjaan));
                $modPengadaan->pelaksanaankontrak_tglakhir = date('d M Y', strtotime($model->tglakhir_pekerjaan));
                
                $model->suratundanganpl_tanggal = MyFormatter::formatDateTimeForUser($model->suratundanganpl_tanggal);
                $model->bahasilpl_tanggal = MyFormatter::formatDateTimeForUser($model->bahasilpl_tanggal);
                
                $cekUnitkerja = UnitkerjaM::model()->findByPk($modPengadaan->unitkerja_id);
                if(!empty($cekUnitkerja)){
                    $modPengadaan->namaunitkerja = $cekUnitkerja->namaunitkerja;
                }else{
                    $modPengadaan->namaunitkerja = "-";
                }
                
                $cekDet = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$cekPerjanjiankerja->suratperjanjiankerja_id));
                if(!empty($cekDet)){
                    $modTermin2->jumlah_termin = count($cekDet);
                }else{
                    $modTermin2->jumlah_termin = 1;
                }
                $model->nilaikontrak = MyFormatter::formatNumberForPrint($model->nilaikontrak, 2);
                $model->jumlah_pajak = MyFormatter::formatNumberForPrint($model->jumlah_pajak, 2);
                $model->jumlah_harga = MyFormatter::formatNumberForPrint($model->jumlah_harga, 2);
                $model->total_hargaseluruhnya = $model->nilaikontrak;
                $model->total_pembulatan = !empty($model->total_pembulatan) ? MyFormatter::formatNumberForPrint($model->total_pembulatan, 2) : null;
                $model->cekpenawaran = true;
                $modDet = SuratperjanjiankerjarincianT::model()->findAll(" suratperjanjiankerja_id = " . $cekPerjanjiankerja->suratperjanjiankerja_id . " ");
            } else {
                $cekNegosiasi = BanegosiasiT::model()->findByAttributes(array('persiapanpengadaan_id'=>$id, 'isbatal' => false, 'isaddendum' => true));
                if(!empty($cekNegosiasi)){
                    $modPenyedia =  PenawaranpenyediaT::model()->findByAttributes(array('penawaranpenyedia_id'=>$cekNegosiasi->penawaranpenyedia_id, 'isbatal' => false, 'isaddendum' => true));
                    if(!empty($modPenyedia)){
                        $modDet = PenawaranpenyediadetT::model()->findAll(" penawaranpenyedia_id = '" . $modPenyedia->penawaranpenyedia_id . "' AND banegosiasi_id = ".$cekNegosiasi->banegosiasi_id);
                        $model->jumlah_harga = !empty($cekNegosiasi->jumlah_negosiasi) ? MyFormatter::formatNumberForPrint($cekNegosiasi->jumlah_negosiasi, 2) : null;
                        $model->jumlah_pajak = !empty($cekNegosiasi->pajak_negosiasi) ? MyFormatter::formatNumberForPrint($cekNegosiasi->pajak_negosiasi, 2) : null;
                        $model->total_hargaseluruhnya = !empty($cekNegosiasi->total_negosiasi) ? MyFormatter::formatNumberForPrint($cekNegosiasi->total_negosiasi, 2) : null;
                        $model->total_pembulatan = !empty($cekNegosiasi->pembulatan_negosiasi) ? MyFormatter::formatNumberForPrint($cekNegosiasi->pembulatan_negosiasi, 2) : null;
                        $model->statusnya = 'banegosiasi';
                        $model->nilaikontrak = !empty($cekNegosiasi->pembulatan_negosiasi) ? MyFormatter::formatNumberForPrint($cekNegosiasi->pembulatan_negosiasi, 2) : null;
                    }else{
                        $modDet = ADPersiapanpengadaandetT::model()->findAll(" persiapanpengadaan_id = '" . $id . "' ");
                        $cekPengadaan = PersiapanpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
                        $model->statusnya = 'persiapanpengadaan';
                        $model->jumlah_harga = !empty($cekPengadaan->total_harga) ? MyFormatter::formatNumberForPrint($cekPengadaan->total_harga, 2) : null;
                        $model->jumlah_pajak = !empty($cekPengadaan->total_pajak) ? MyFormatter::formatNumberForPrint($cekPengadaan->total_pajak, 2) : null;
                        $model->total_hargaseluruhnya = !empty($cekPengadaan->total_hargaseluruhnya) ? MyFormatter::formatNumberForPrint($cekPengadaan->total_hargaseluruhnya, 2) : null;
                        $model->nilaikontrak = !empty($cekPengadaan->total_hargaseluruhnya) ? MyFormatter::formatNumberForPrint($cekPengadaan->total_hargaseluruhnya, 2) : null;
                    }
                }else{
                    $modDet = ADPersiapanpengadaandetT::model()->findAll(" persiapanpengadaan_id = '" . $id . "' ");
                    $cekPengadaan = PersiapanpengadaanT::model()->findByPk($id);
                    $model->statusnya = 'persiapanpengadaan';
                    $model->jumlah_harga = MyFormatter::formatNumberForPrint($cekPengadaan->total_harga, 2);
                    $model->jumlah_pajak = MyFormatter::formatNumberForPrint($cekPengadaan->total_pajak, 2);
                    $model->total_hargaseluruhnya = MyFormatter::formatNumberForPrint($cekPengadaan->total_hargaseluruhnya, 2);
                    $model->nilaikontrak = MyFormatter::formatNumberForPrint($cekPengadaan->total_hargaseluruhnya, 2);
                }
                
                $modPengadaan = PersiapanpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
                $modPengadaan->pelaksanaankontrak_tglawal = date('d M Y', strtotime($modPengadaan->pelaksanaankontrak_tglawal));
                $modPengadaan->pelaksanaankontrak_tglakhir = date('d M Y', strtotime($modPengadaan->pelaksanaankontrak_tglakhir));
                
                //$model->no_putusanpenggunaanggaran = !empty($modPejabat) ? $modPejabat->no_sk : "-";
                //$model->tglputusanpenggunaanggaran = !empty($modPejabat) ? MyFormatter::formatDateTimeForUser($modPejabat->tgl_sk) : "-";
                
                $cekUnitkerja = UnitkerjaM::model()->findByPk($modPengadaan->unitkerja_id);
                if(!empty($cekUnitkerja)){
                    $modPengadaan->namaunitkerja = $cekUnitkerja->namaunitkerja;
                }else{
                    $modPengadaan->namaunitkerja = "-";
                }
                $modTermin2->jumlah_termin = 1;
                
                $model->no_dpa = !empty($modPengadaan) ? $modPengadaan->periodeanggaran->nodpa_anggaran : "";
                $model->tgl_dpa = !empty($modPengadaan) ? MyFormatter::formatDateTimeForUser($modPengadaan->periodeanggaran->tgl_pengesahandpa) : "";   
            }

            $cekInstalasi = InstalasiM::model()->findByPk($modPengadaan->instalasi_id);
            if (!empty($cekInstalasi)) {
                $modPengadaan->instalasi_nama = $cekInstalasi->instalasi_nama;
                $modPengadaan->instalasi_id = $cekInstalasi->instalasi_id;
            } else {
                $modPengadaan->instalasi_nama = '-';
                $modPengadaan->instalasi_id = null;
            }

            $cekMetode = MetodepengadaanM::model()->findByPk($modPengadaan->metodepengadaan_id);
            if (!empty($cekMetode)) {
                $modPengadaan->metodepengadaan_nama = $cekMetode->metodepengadaan_nama;
            } else {
                $modPengadaan->metodepengadaan_nama = '-';
            }

            $model->namapekerjaan = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->nama_pekerjaan : '';
            $model->pejabatpenggunaanggaran_id = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaipa_id : '';
            $model->kuasapenggunaanggaran_id = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaikpa_id : '';
            $model->pejabatpembuatkomitmen_id = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk_id : '';
            $model->namapembuatkomitmen = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk->namaLengkap : '';
            $modPejabat = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $modPengadaan->rencanaumumpengadaan->pegawaippk_id, 'jabatan_pengadaan'=> Params::JABATAN_PENGADAAN_PPK));
            
            $model->no_putusanpenggunaanggaran = !empty($modPejabat) ? $modPejabat->no_sk : "";
            $model->tglputusanpenggunaanggaran = !empty($modPejabat) ? MyFormatter::formatDateTimeForUser($modPejabat->tgl_sk) : "";
            $model->noindukpegawai = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk->nomorindukpegawai : '';
            $model->jabatan = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk->jabatan->jabatan_nama : '';
            $model->alamat = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk->alamat_pegawai : '';

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
            
            if(!empty($modPengadaan->rencanaumumpengadaan_id)){
                $cekMapping = PengadaansumberdanaT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $modPengadaan->rencanaumumpengadaan_id));
                $koderek = $cekMapping->mappingrekeninganggaran->kodeanggaran.' - '.$cekMapping->mappingrekeninganggaran->nama_rekeninganggaran5;
                $mappingrekeninganggaran_id = $cekMapping->mappingrekeninganggaran_id;
            }else{
                $koderek = '-';    
                $mappingrekeninganggaran_id = '';
            }
            $cekPersiapandet = PersiapanpengadaandetT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
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

            $cekPeriodeAnggaran = PeriodeanggaranK::model()->findByPk($modPengadaan->periodeanggaran_id);
            $model->tahunanggaran = !empty($cekPeriodeAnggaran) ? $cekPeriodeAnggaran->tahunanggaran : '';
            $model->periodeanggaran_id = !empty($cekPeriodeAnggaran) ? $cekPeriodeAnggaran->periodeanggaran_id : '';

//            $cekNilaikontrak = PenetapanpemenangT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
//            $model->nilaikontrak = !empty($cekNilaikontrak) ? MyFormatter::formatNumberForPrint($cekNilaikontrak->harga_negosiasi, 2) : null;

            $awal = date_create($modPengadaan->pelaksanaankontrak_tglawal);
            $akhir = date_create($modPengadaan->pelaksanaankontrak_tglakhir); // waktu sekarang
            $diff = date_diff($awal, $akhir);
            $model->jangka_waktu = $diff->d;

            $cekPenawaran = PenawaranpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
            if (!empty($cekPenawaran)) {
                $model->cekpenawaran = true;
                $model->supplier_id = $cekPenawaran->supplier->supplier_id;
                $model->supplier_nama = $cekPenawaran->supplier->supplier_nama;
                $model->tglpenawaran = MyFormatter::formatDateTimeForUser($cekPenawaran->penawaranpenyedia_tanggal);
                $model->penawaranpenyedia_id = $cekPenawaran->penawaranpenyedia_id;
                $model->nomor_rekening = $cekPenawaran->supplier->supplier_norekening;
                $model->nama_supplier = $cekPenawaran->supplier->direktursupplier;
                $model->alamat_supplier = $cekPenawaran->supplier->supplier_alamat;
                $model->nopenawaran = $cekPenawaran->penawaranpenyedia_nomor;
            } else {
                $model->cekpenawaran = false;
                $cekSupplier = SupplierM::model()->findByPk($model->supplier_id);
                if(!empty($cekSupplier)){
                    $model->nomor_rekening = $cekSupplier->supplier_norekening;
                    $model->nama_supplier = $cekSupplier->direktursupplier;
                    $model->alamat_supplier = $cekSupplier->supplier_alamat;
                }
            }
        }

        if (isset($_POST['SuratperjanjiankerjaT'])) {
            $trans = Yii::app()->db->beginTransaction();
            try {
                if ($model->saveSuratPerjanjian($_POST)) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'id' => $model->persiapanpengadaan_id));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
                }
            } catch (CException $e) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data Gagal Disimpan " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modPengadaan' => $modPengadaan,
            'modDet' => $modDet,
            'modTermin' => $modTermin,
            'modTermin2' => $modTermin2,
        ));
    }

    /**
     * Cetak Surat Perjanjian Kerja
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $model = SuratperjanjiankerjaT::model()->findByPk($id);
        $modPengadaan = PersiapanpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
        $sup = SupplierM::model()->findByPk($model->supplier_id);
        
        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        $criteria->addCondition("konfigtemplatesurat_id=" . $model->konfigtemplatesurat_id);
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{tglsuratperjanjian}}", date('d ', strtotime($model->tglsuratperjanjian)) . MyFormatter::getMonthId(date('m', strtotime($model->tglsuratperjanjian))) . date(' Y', strtotime($model->tglsuratperjanjian)), $isiPesan);
                $isiPesan = str_replace("{{tglawal_pekerjaan}}", date('d ', strtotime($model->tglawal_pekerjaan)) . MyFormatter::getMonthId(date('m', strtotime($model->tglawal_pekerjaan))) . date(' Y', strtotime($model->tglawal_pekerjaan)), $isiPesan);
                $isiPesan = str_replace("{{tglakhir_pekerjaan}}", date('d ', strtotime($model->tglakhir_pekerjaan)) . MyFormatter::getMonthId(date('m', strtotime($model->tglakhir_pekerjaan))) . date(' Y', strtotime($model->tglakhir_pekerjaan)), $isiPesan);
                $isiPesan = str_replace("{{hari_terbilang}}", "(" . ucwords(MyFormatter::kataTerbilang($model->jangka_waktu)) . " Hari )", $isiPesan);
                $isiPesan = str_replace("{{namapekerjaan}}", strtoupper($model->namapekerjaan), $isiPesan);
                $isiPesan = str_replace("{{bahasilpl_nomor}}", $model->bahasilpl_nomor, $isiPesan);
                $isiPesan = str_replace("{{suratundanganpl_nomor}}", $model->suratundanganpl_nomor, $isiPesan);
                $isiPesan = str_replace("{{suratundanganpl_tanggal}}", date('d ', strtotime($model->suratundanganpl_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->suratundanganpl_tanggal))) . date(' Y', strtotime($model->suratundanganpl_tanggal)), $isiPesan);
                $isiPesan = str_replace("{{bahasilpl_tanggal}}", date('d ', strtotime($model->bahasilpl_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bahasilpl_tanggal))) . date(' Y', strtotime($model->bahasilpl_tanggal)), $isiPesan);
            }
            $modSupplier = SupplierM::model()->findByPk($model->supplier_id);
            $attributes = $modSupplier->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $cekKegiatanprogram = KegiatanprogramM::model()->findByPk($model->kegiatanprogram_id);
            $attributes = $cekKegiatanprogram->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $cekKodeRekening = MappingrekeninganggaranM::model()->findByPk($model->mappingrekeninganggaran_id);
            $attributes = $cekKodeRekening->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{kodeanggaran}}", $cekKodeRekening->kodeanggaran, $isiPesan);
                $isiPesan = str_replace("{{nama_rekeninganggaran5}}", $cekKodeRekening->nama_rekeninganggaran5, $isiPesan);
            }
            $cekSubprogramkerja = SubprogramkerjaM::model()->findByPk($cekKegiatanprogram->subprogramkerja_id);
            $cekProgramkerja = ProgramkerjaM::model()->findByPk($cekSubprogramkerja->programkerja_id);
            $attributes = $cekProgramkerja->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            
            $cekUnitkerja = UnitkerjaM::model()->findByPk($modPengadaan->unitkerja_id);
            if(!empty($cekUnitkerja)){
                $unitkerja = $cekUnitkerja->namaunitkerja;
            }else{
                $unitkerja = '';
            }
            
            $attributes = $modPengadaan->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{unitkerja_nama}}", $unitkerja, $isiPesan);
            }
            
            $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id'=>$id));
            $attributes = $cekTermin->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{termintanggal_awal}}", date('d ', strtotime($cekTermin->termintanggal_awal)) . MyFormatter::getMonthId(date('m', strtotime($cekTermin->termintanggal_awal))) . date(' Y', strtotime($cekTermin->termintanggal_awal)), $isiPesan);
                $isiPesan = str_replace("{{termintanggal_akhir}}",date('d ', strtotime($cekTermin->termintanggal_akhir)) . MyFormatter::getMonthId(date('m', strtotime($cekTermin->termintanggal_akhir))) . date(' Y', strtotime($cekTermin->termintanggal_akhir)), $isiPesan);
            }
        }
        $model->isi_surat = $isiPesan;
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($id);
        $modRincianSPK = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id)); 
        
        $this->render('print', array('model' => $model,'modPengadaan'=>$modPengadaan,'sup'=>$sup, 'modSPK' => $modSPK,'modRincianSPK'=>$modRincianSPK));
    }

    
    /**
     * menghitung jangka waktu kontrak berdasarkan 2 tanggal
     */
    public function actionGetJangkaWaktu()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['selisih'] = null;
            if(isset($_POST['date1']) && !empty($_POST['date2'])){
                $format = new MyFormatter;
                $tanggalpertama = $format->formatDateTimeForDb($_POST['date1']);
                $tanggalkedua = $format->formatDateTimeForDb($_POST['date2']);
                $data['selisih'] = CustomFunction::hitungHari($tanggalpertama, $tanggalkedua) + 1;
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Mendapatkan daftar semester
     */
    public function actionGetTermin() {
        if (Yii::app()->request->isAjaxRequest) {
            $jumlah_termin = $_POST['jumlah_termin'];
            $tahun = date('Y');
            $format_awal = MyFormatter::formatDateTimeForDb($_POST['pelaksanaankontrak_tglawal']);
            $format_akhir = MyFormatter::formatDateTimeForDb($_POST['pelaksanaankontrak_tglakhir']);
            $tanggal_awal = date('d M Y', strtotime($format_awal));
            $tanggal_akhir =  date('d M Y', strtotime($format_akhir));
            $awal = date('d M Y', strtotime($_POST['pelaksanaankontrak_tglawal']));
            $akhir =  date('d M Y', strtotime($_POST['pelaksanaankontrak_tglakhir']));
            
            $selisih = CustomFunction::hitungHari($tanggal_awal, $tanggal_akhir) + 1;
            
            if($jumlah_termin <= $selisih){
                $model = new SuratperjanjiankerjaterminT;
            
                $return = $this->renderPartial($this->path_view.'form/_rowTerminPeriodikal', array('model' => $model,
                    'tanggal_awal' => $tanggal_awal,
                    'tanggal_akhir' => $tanggal_akhir,
                    'jumlah_termin' => $jumlah_termin,
                    'tahun' => $tahun,
                    'selisih'=>$selisih
                        ), true);
            }else{
                $return = 'gagal';
            }
            
            $data['return'] = $return;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
     /**
     * fungsi ini untuk mencari data obat alkes
     */
    public function actionAutocompleteObat() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $obatalkes_nama = isset($_GET['term']) ? $_GET['term'] : null;
            $generik_id = isset($_GET['generik_id'])?$_GET['generik_id']:null;                        
            $wajib = isset($_GET['wajib'])?$_GET['wajib']:null;
            $criteria = new CDbCriteria();
                        
            
            if (isset($_GET['obatalkes_id'])) {
                $criteria->addCondition('obatalkes_id = '.$_GET['obatalkes_id']);
            }
            if (!empty($generik_id)){                
                $criteria->addCondition('generik_id = '.$generik_id);                
            }
            
            if (!empty($wajib)){
                foreach($wajib as $det){
                    if (empty($$det)){
                        $criteria->addCondition("obatalkes_id is null");
                    }
                }
            }
            
            $criteria->compare('LOWER(obatalkes_nama)', strtolower($obatalkes_nama), true);
            $criteria->limit = 5;
            $models = ObatalkesM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->obatalkes_kode . " - " . $model->obatalkes_nama;
                $returnVal[$i]['value'] = $model->obatalkes_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Fungsi untuk cek file yang di import
     */
    function actionCekFileImport(){
        if (Yii::app()->request->isAjaxRequest){
            $file = $_FILES['file'];              
            
            $path = Yii::getPathOfAlias('webroot').'/protected/modules/pengadaan/views/suratPerjanjianKerja/file/template_import_spk.xls';                
            $objectTemp = Yii::app()->yexcel->readActiveSheet($path);
                                    
            $object = Yii::app()->yexcel->readActiveSheet($file['tmp_name']);
                                                
            $ok = true; 
            
            if (
                    strtolower(trim($objectTemp[1]['A'])) ==  strtolower(trim($object[1]['A'])) &&
                    strtolower(trim($objectTemp[1]['B'])) ==  strtolower(trim($object[1]['B'])) &&
                    strtolower(trim($objectTemp[1]['C'])) ==  strtolower(trim($object[1]['C'])) &&
                    strtolower(trim($objectTemp[1]['D'])) ==  strtolower(trim($object[1]['D']))
            ){
                $pesan = array();
                $golPrev = array();
                $golBerbeda = array();
                $golMaster = array();
                $metodeMaster = array();
                $jnsMaster = array();
                $masterBarang = array();
                $masterObat = array();
                $masterGolBahan = array();
                $num = true;
                $i = 0;
                unset($object[1]);

                $load_obat = ObatalkesM::model()->findAll(" obatalkes_aktif = TRUE ORDER BY obatalkes_nama ASC ");
                $obat = array();   
                $obatalkes_id = array();
                $obatalkes_nama = array();         
                foreach($load_obat as $key => $val){
                    $val['obatalkes_nama'] = trim($val['obatalkes_nama']);
                    $val['obatalkes_id'] = trim($val['obatalkes_id']);
                    $obat[str_replace(' ','_',strtolower($val['obatalkes_nama']))] = $val->obatalkes_id;
                }    
                
                $pesanTemp = '';
                $j = 0;
                foreach($object as $key => $det){
                    $cek = true;

                    if (strtolower(trim($det['D'])) == 'farmasi'){                    
                        if (!isset($obat[str_replace(' ', '_', strtolower(trim($det['C'])))])){
                            $pesan[$key]['list_obat'] = '- Pada baris '.$key.', uraian <b>'.trim($det['C']).'</b> ini tidak sesuai dengan yang ada pada, list master obat</b><br/>';
                            $cek &= false;
                            $i++;
                            $obatalkes_id[$j] = "";

                            if ($i <= 3){                                        
                                $pesanTemp .= '- Pada baris '.$key.', uraian <b>'.trim($det['C']).'</b> ini tidak sesuai dengan yang ada pada, list master obat</b><br/>';
                            }
                        }else{
                            $obatalkes_id[$j] = $obat[str_replace(' ', '_', strtolower(trim($det['C'])))];
                        }
                    }else{
                        $obatalkes_id[$j] = "";
                    }
                    $obatalkes_nama[] = trim($det['C']);

                    if ($num == false){
                        $pesan[$key]['numeric'] = '- Ada Kesalahan pada baris <b>'.$key.'</b> untuk nominal tidak boleh menggunakan format currency<br/>';
                        $i++;

                        if ($i <= 3){                                        
                            $pesanTemp .= '- Ada Kesalahan pada baris <b>'.$key.'</b> untuk nominal tidak boleh menggunakan format currency<br/>';
                        }
                    }       

                    $ok &= $cek;
                    $j++;
                }

                
                if ($i > 3){
                    $pesanTemp .= " <div id='footer-error' class='tile-footer'> 
                                        <button type='button' class='btn btn-danger btn-block' onclick='downloadTemplate(\"list_kesalahan_format\")'>Selengkapnya</button> 
                                    </div> ";
                }

                Yii::app()->user->setState('list_kesalahan_format',$pesan);

                $pesan = $pesanTemp;
                
                if ($ok){
                    $data['id'] = $obatalkes_id;
                    $data['spk'] = $obatalkes_nama;
                    $data['jumlah'] = count($object);
                    $data['pesan'] = 'Data yang diimport sesuai';
                    $data['sukses'] = 1;
                }else{
                    $data['id'] = "";
                    $data['spk'] = "";
                    $data['jumlah'] = count($object);
                    $data['pesan'] = 'Mohon cek kembali file yang di-import, kemungkinan ada data yang formatnya tidak sesuai. <br/>'.$pesan;
                    $data['sukses'] = 0;                
                }   
            }else{
                $data['id'] = "";
                $data['spk'] = "";
                $data['jumlah'] = count($object);
                $data['pesan'] = 'Format tidak sesuai mohon cek urutan antar kolomnya';
                $data['sukses'] = 0;                
            }
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    /**
     * Digunakan untuk load form unggah dokumen
     * @param type $id
     */
    public function actionLoadformImport($id) {
        $this->layout = '//layouts/iframe';
        $model = new SuratperjanjiankerjaT;
        $model->setDefaultData();
        $model->nosuratperjanjiankerja = '--Otomatis--';
        $model->tglsuratperjanjian = $model->tgl_dpa = $model->bahasilpl_tanggal = $model->suratundanganpl_tanggal = MyFormatter::formatDateTimeForUser(date('d M Y H:i:s'));
        $modPengadaan = new PersiapanpengadaanT;
        $modTermin = new SuratperjanjiankerjaterminT();
        $modTermin2 = new ADSuratperjanjiankerjaterminT();
        if (!empty($id)) {
            $modPengadaan = PersiapanpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
            $cekPerjanjiankerja = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id,'isbatal' => false, 'isaddendum' => true));
            if (!empty($cekPerjanjiankerja)) {
                $model = SuratperjanjiankerjaT::model()->findByPk($cekPerjanjiankerja->suratperjanjiankerja_id);
                $sup = SupplierM::model()->findByPk($model->supplier_id);
                $model->nama_supplier = $sup->supplier_cp;
                $model->jabatan_supplier = $sup->supplier_cp_jabatan;
                $model->alamat_supplier = $sup->supplier_alamat;

                $model->tglputusanpenggunaanggaran = MyFormatter::formatDateTimeForUser($model->tglputusanpenggunaanggaran);
                $model->tgl_dpa = MyFormatter::formatDateTimeForUser($model->tgl_dpa);
                $model->tglsuratperjanjian = MyFormatter::formatDateTimeForUser($model->tglsuratperjanjian);
                $modPengadaan->pelaksanaankontrak_tglawal = date('d M Y', strtotime($model->tglawal_pekerjaan));
                $modPengadaan->pelaksanaankontrak_tglakhir = date('d M Y', strtotime($model->tglakhir_pekerjaan));
                
                $model->suratundanganpl_tanggal = MyFormatter::formatDateTimeForUser($model->suratundanganpl_tanggal);
                $model->bahasilpl_tanggal = MyFormatter::formatDateTimeForUser($model->bahasilpl_tanggal);
                
                $cekUnitkerja = UnitkerjaM::model()->findByPk($modPengadaan->unitkerja_id);
                if(!empty($cekUnitkerja)){
                    $modPengadaan->namaunitkerja = $cekUnitkerja->namaunitkerja;
                }else{
                    $modPengadaan->namaunitkerja = "-";
                }
                
                $cekDet = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$cekPerjanjiankerja->suratperjanjiankerja_id));
                if(!empty($cekDet)){
                    $modTermin2->jumlah_termin = count($cekDet);
                }else{
                    $modTermin2->jumlah_termin = 1;
                }
                $model->nilaikontrak = MyFormatter::formatNumberForPrint($model->nilaikontrak);
                $model->total_pembulatan = !empty($model->total_pembulatan) ? MyFormatter::formatNumberForPrint($model->total_pembulatan, 2) : null;
                $model->cekpenawaran = true;
                $modDet = SuratperjanjiankerjarincianT::model()->findAll(" suratperjanjiankerja_id = " . $cekPerjanjiankerja->suratperjanjiankerja_id . " ");
            } else {
                $cekNegosiasi = BanegosiasiT::model()->findByAttributes(array('persiapanpengadaan_id'=>$id, 'isbatal' => false, 'isaddendum' => true));
                if(!empty($cekNegosiasi)){
                    $modPenyedia =  PenawaranpenyediaT::model()->findByAttributes(array('penawaranpenyedia_id'=>$cekNegosiasi->penawaranpenyedia_id, 'isbatal' => false, 'isaddendum' => true));
                    if(!empty($modPenyedia)){
                        $modDet = PenawaranpenyediadetT::model()->findAll(" penawaranpenyedia_id = '" . $modPenyedia->penawaranpenyedia_id . "' AND banegosiasi_id = ".$cekNegosiasi->banegosiasi_id);
                        $model->total_pembulatan = !empty($cekNegosiasi->pembulatan_negosiasi) ? MyFormatter::formatNumberForPrint($cekNegosiasi->pembulatan_negosiasi, 2) : null;
                    }else{
                        $modDet = ADPersiapanpengadaandetT::model()->findAll(" persiapanpengadaan_id = '" . $id . "' ");
                    }
                }else{
                    $modDet = ADPersiapanpengadaandetT::model()->findAll(" persiapanpengadaan_id = '" . $id . "' ");
                }
                $modPengadaan = PersiapanpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
                $modPengadaan->pelaksanaankontrak_tglawal = date('d M Y', strtotime($modPengadaan->pelaksanaankontrak_tglawal));
                $modPengadaan->pelaksanaankontrak_tglakhir = date('d M Y', strtotime($modPengadaan->pelaksanaankontrak_tglakhir));
                
                //$model->no_putusanpenggunaanggaran = !empty($modPejabat) ? $modPejabat->no_sk : "-";
                //$model->tglputusanpenggunaanggaran = !empty($modPejabat) ? MyFormatter::formatDateTimeForUser($modPejabat->tgl_sk) : "-";
                
                $cekUnitkerja = UnitkerjaM::model()->findByPk($modPengadaan->unitkerja_id);
                if(!empty($cekUnitkerja)){
                    $modPengadaan->namaunitkerja = $cekUnitkerja->namaunitkerja;
                }else{
                    $modPengadaan->namaunitkerja = "-";
                }
                $modTermin2->jumlah_termin = 1;
                
                $model->no_dpa = !empty($modPengadaan) ? $modPengadaan->periodeanggaran->nodpa_anggaran : "";
                $model->tgl_dpa = !empty($modPengadaan) ? MyFormatter::formatDateTimeForUser($modPengadaan->periodeanggaran->tgl_pengesahandpa) : "";   
            }

            $cekInstalasi = InstalasiM::model()->findByPk($modPengadaan->instalasi_id);
            if (!empty($cekInstalasi)) {
                $modPengadaan->instalasi_nama = $cekInstalasi->instalasi_nama;
                $modPengadaan->instalasi_id = $cekInstalasi->instalasi_id;
            } else {
                $modPengadaan->instalasi_nama = '-';
                $modPengadaan->instalasi_id = null;
            }

            $cekMetode = MetodepengadaanM::model()->findByPk($modPengadaan->metodepengadaan_id);
            if (!empty($cekMetode)) {
                $modPengadaan->metodepengadaan_nama = $cekMetode->metodepengadaan_nama;
            } else {
                $modPengadaan->metodepengadaan_nama = '-';
            }

            $model->namapekerjaan = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->nama_pekerjaan : '';
            $model->pejabatpenggunaanggaran_id = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaipa_id : '';
            $model->kuasapenggunaanggaran_id = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaikpa_id : '';
            $model->pejabatpembuatkomitmen_id = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk_id : '';
            $model->namapembuatkomitmen = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk->namaLengkap : '';
            $modPejabat = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $modPengadaan->rencanaumumpengadaan->pegawaippk_id, 'jabatan_pengadaan'=> Params::JABATAN_PENGADAAN_PPK));
            
            $model->no_putusanpenggunaanggaran = !empty($modPejabat) ? $modPejabat->no_sk : "";
            $model->tglputusanpenggunaanggaran = !empty($modPejabat) ? MyFormatter::formatDateTimeForUser($modPejabat->tgl_sk) : "";
            $model->noindukpegawai = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk->nomorindukpegawai : '';
            $model->jabatan = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk->jabatan->jabatan_nama : '';
            $model->alamat = !empty($modPengadaan->rencanaumumpengadaan_id) ? $modPengadaan->rencanaumumpengadaan->pegawaippk->alamat_pegawai : '';

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
            
            if(!empty($modPengadaan->rencanaumumpengadaan_id)){
                $cekMapping = PengadaansumberdanaT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $modPengadaan->rencanaumumpengadaan_id));
                $koderek = $cekMapping->mappingrekeninganggaran->kodeanggaran.' - '.$cekMapping->mappingrekeninganggaran->nama_rekeninganggaran5;
                $mappingrekeninganggaran_id = $cekMapping->mappingrekeninganggaran_id;
            }else{
                $koderek = '-';    
                $mappingrekeninganggaran_id = '';
            }
            $cekPersiapandet = PersiapanpengadaandetT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
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

            $cekPeriodeAnggaran = PeriodeanggaranK::model()->findByPk($modPengadaan->periodeanggaran_id);
            $model->tahunanggaran = !empty($cekPeriodeAnggaran) ? $cekPeriodeAnggaran->tahunanggaran : '';
            $model->periodeanggaran_id = !empty($cekPeriodeAnggaran) ? $cekPeriodeAnggaran->periodeanggaran_id : '';

            $cekNilaikontrak = PenetapanpemenangT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
            $model->nilaikontrak = !empty($cekNilaikontrak) ? MyFormatter::formatNumberForPrint($cekNilaikontrak->harga_negosiasi, 2) : null;

            $awal = date_create($modPengadaan->pelaksanaankontrak_tglawal);
            $akhir = date_create($modPengadaan->pelaksanaankontrak_tglakhir); // waktu sekarang
            $diff = date_diff($awal, $akhir);
            $model->jangka_waktu = $diff->d;

            $cekPenawaran = PenawaranpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
            if (!empty($cekPenawaran)) {
                $model->cekpenawaran = true;
                $model->supplier_id = $cekPenawaran->supplier->supplier_id;
                $model->supplier_nama = $cekPenawaran->supplier->supplier_nama;
                $model->tglpenawaran = MyFormatter::formatDateTimeForUser($cekPenawaran->penawaranpenyedia_tanggal);
                $model->penawaranpenyedia_id = $cekPenawaran->penawaranpenyedia_id;
                $model->nomor_rekening = $cekPenawaran->supplier->supplier_norekening;
                $model->nama_supplier = $cekPenawaran->supplier->direktursupplier;
                $model->alamat_supplier = $cekPenawaran->supplier->supplier_alamat;
                $model->nopenawaran = $cekPenawaran->penawaranpenyedia_nomor;
            } else {
                $model->cekpenawaran = false;
                $cekSupplier = SupplierM::model()->findByPk($model->supplier_id);
                if(!empty($cekSupplier)){
                    $model->nomor_rekening = $cekSupplier->supplier_norekening;
                    $model->nama_supplier = $cekSupplier->direktursupplier;
                    $model->alamat_supplier = $cekSupplier->supplier_alamat;
                }
            }
        }
        
        $this->render($this->path_view . '_formUnggahDokumen', array(
            'model' => $model,
            'modPengadaan' => $modPengadaan,
            'modDet' => $modDet,
            'modTermin' => $modTermin,
            'modTermin2' => $modTermin2
                ));
    }
    
    /**
     * fungsi export excel
     * @param type $id
     * @param type $file
     * @param type $caraPrint
     */
    public function exportExcel($id, $file=null, $caraPrint=null){
        
        $cekPerjanjiankerja = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id,'isbatal' => false, 'isaddendum' => true));
        if (!empty($cekPerjanjiankerja)) {
            $modDet = SuratperjanjiankerjarincianT::model()->findAll(" suratperjanjiankerja_id = " . $cekPerjanjiankerja->suratperjanjiankerja_id . " ");
        } else {
            $cekNegosiasi = BanegosiasiT::model()->findByAttributes(array('persiapanpengadaan_id'=>$id, 'isbatal' => false, 'isaddendum' => true));
            if(!empty($cekNegosiasi)){
                $modPenyedia =  PenawaranpenyediaT::model()->findByAttributes(array('penawaranpenyedia_id'=>$cekNegosiasi->penawaranpenyedia_id, 'isbatal' => false, 'isaddendum' => true));
                if(!empty($modPenyedia)){
                    $modDet = PenawaranpenyediadetT::model()->findAll(" penawaranpenyedia_id = '" . $modPenyedia->penawaranpenyedia_id . "' AND banegosiasi_id = ".$cekNegosiasi->banegosiasi_id);
                }else{
                    $modDet = ADPersiapanpengadaandetT::model()->findAll(" persiapanpengadaan_id = '" . $id . "' ");
                }
            }else{
                $modDet = ADPersiapanpengadaandetT::model()->findAll(" persiapanpengadaan_id = '" . $id . "' ");
            }
        }

        $objPHPExcel = new MyExcel();                

        $i = 1;
        if (file_exists($file)){                     
            $objPHPExcel = PHPExcel_IOFactory::load($file);
            $objPHPExcel->setActiveSheetIndex(0);
            $i = $objPHPExcel->getActiveSheet(0)->getHighestRow() + 1;
        }else{                                        
            $objWorkSheet = $objPHPExcel->createSheet();
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, 'NO');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, 'NAMA USULAN');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, 'NAMA SPK');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, 'JENIS BARANG');                             

            $i = 2;
        }
        
        $no = 1;
        foreach($modDet as $val){
            if(!empty($val->penawaranpenyediadet_id)){
                $nama_usulan = !empty($val->nama_barang) ? $val->nama_barang : '';
                $jenis_barang = !empty($val->jenis_barang) ? $val->jenis_barang : '';
            }else if(!empty($val->persiapanpengadaandet_id)){
                $nama_usulan = !empty($val->persiapanpengadaandet_nama) ? $val->persiapanpengadaandet_nama : '';
                $jenis_barang = !empty($val->jenis_barang) ? $val->jenis_barang : '';
            }else if(!empty($val->suratperjanjiankerjarincian_id)){
                $nama_usulan = !empty($val->barang_nama) ? $val->barang_nama : '';
                $jenis_barang = !empty($val->jenis_barang) ? $val->jenis_barang : '';
            }else{
                $nama_usulan = '';
                $jenis_barang = '';
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $nama_usulan, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, "", PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $jenis_barang, PHPExcel_Cell_DataType::TYPE_STRING);
            $i++;
            $no++;
        }


        $objPHPExcel->setActiveSheetIndex(0);

        if (!file_exists($file)){
            $i =1;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, 'NO');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, 'NAMA USULAN');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, 'NAMA SPK');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, 'JENIS BARANG');
            $i =2;
        }else{
            $i = $objPHPExcel->getActiveSheet(1)->getHighestRow() + 1;
            unlink($file);
        }
        
        $sheetIndex = $objPHPExcel->getIndex(
            $objPHPExcel->getSheetByName('Worksheet 1')
        );
        $objPHPExcel->removeSheetByIndex($sheetIndex);

        $nomor = 1;
        foreach($modDet as $det){     
            if(!empty($det->penawaranpenyediadet_id)){
                $nama_usulan = !empty($det->nama_barang) ? $det->nama_barang : '';
                $jenis_barang = !empty($det->jenis_barang) ? $det->jenis_barang : '';
            }else if(!empty($det->persiapanpengadaandet_id)){
                $nama_usulan = !empty($det->persiapanpengadaandet_nama) ? $det->persiapanpengadaandet_nama : '';
                $jenis_barang = !empty($det->jenis_barang) ? $det->jenis_barang : '';
            }else if(!empty($det->suratperjanjiankerjarincian_id)){
                $nama_usulan = !empty($det->barang_nama) ? $det->barang_nama : '';
                $jenis_barang = !empty($det->jenis_barang) ? $det->jenis_barang : '';
            }else{
                $nama_usulan = '';
                $jenis_barang = '';
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $nomor, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $nama_usulan, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, "", PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $jenis_barang, PHPExcel_Cell_DataType::TYPE_STRING);
            $i++;
            $nomor++;
        }
                              
        $pisah = explode(".",$file);
        if (end($pisah) == 'xls'){
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);                                 
        }elseif (end($pisah) == 'xlsx'){
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);                                 
        }
        if (empty($caraPrint)){            
            $objWriter->save($file);
            unset($objPHPExcel);
        }else{
            if ($caraPrint == 'EXCEL'){    
                ob_end_clean();
                header( "Content-type: application/vnd.ms-excel" );                
                header('Content-Disposition: attachment; filename="'.$file.'"');                
                header("Pragma: no-cache");
                header("Expires: 0");
                $objWriter->save("php://output");                                                
            }
        }
    }
    
    /**
     * Digunakan untuk download data rincian pekerjaan menjadi excel
     * @param type $id
     */
    public function actionUnduhExcel($id){
        
        $file = 'data_rincian_pekerjaan.xls';  
        
        $this->exportExcel($id,$file,'EXCEL');
    }
    
    /**
     * Unduh file template dan list kesalahan import
     */
    public function actionUnduhFile(){       
        $this->layout = '//layouts/printWindows';
        
        $jenis = $_GET['jenis'];
        $file = $jenis.'.xls';
        
        if ($jenis == 'data_usulan'){            
            $path = Yii::getPathOfAlias('webroot').'/protected/modules/pengadaan/views/suratPerjanjianKerja/file/template_import_spk.xls';                
            Yii::app()->getRequest()->sendFile('template_import_spk.xls', file_get_contents($path));                
        }elseif($jenis == 'list_kesalahan_format'){
            $model = Yii::app()->user->getState('list_kesalahan_format');            
            $this->renderPartial($this->path_view.'file/_printListKesalahan',array('model'=>$model,'jenis'=>$file));
        }
                
    }
    
    /**
     * Fungsi unduh template
     */
    public function actionUnduhTemplate(){
        if (Yii::app()->request->isAjaxRequest){
            
            $jenis = isset($_POST['jenis'])?$_POST['jenis']:null;                        
            $url = $this->createUrl('unduhFile', array('jenis'=>$jenis));
            
            $data['sukses'] = 1;
            $data['url_download'] = $url;
            
            echo json_encode($data);
            Yii::app()->end();
        }
    } 
    
    /**
     * Form Surat Perjanjian Kerja
     * 
     * @author  M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * @package application.models
     * @param type $suratperjanjiankerja_id ID surat perjanjian kerja yang dipilih.
     */
    public function actionUbah($suratperjanjiankerja_id = null) {        
        
        $model = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);                
        $modPengadaan = PersiapanpengadaanT::model()->findByPk($model->persiapanpengadaan_id);
        $modTermin = new SuratperjanjiankerjaterminT();
        $modTermin2 = new ADSuratperjanjiankerjaterminT();
                
        if ($model->isbatal === false && $model->isaddendum === true) {                
            $sup = SupplierM::model()->findByPk($model->supplier_id);
            $model->nama_supplier = $sup->supplier_cp;
            $model->jabatan_supplier = $sup->supplier_cp_jabatan;
            $model->alamat_supplier = $sup->supplier_alamat;

            $model->tglputusanpenggunaanggaran = MyFormatter::formatDateTimeForUser($model->tglputusanpenggunaanggaran);
            $model->tgl_dpa = MyFormatter::formatDateTimeForUser($model->tgl_dpa);
            $model->tglsuratperjanjian = MyFormatter::formatDateTimeForUser($model->tglsuratperjanjian);
            $modPengadaan->pelaksanaankontrak_tglawal = date('d M Y', strtotime($model->tglawal_pekerjaan));
            $modPengadaan->pelaksanaankontrak_tglakhir = date('d M Y', strtotime($model->tglakhir_pekerjaan));

            $model->suratundanganpl_tanggal = MyFormatter::formatDateTimeForUser($model->suratundanganpl_tanggal);
            $model->bahasilpl_tanggal = MyFormatter::formatDateTimeForUser($model->bahasilpl_tanggal);

            $cekUnitkerja = UnitkerjaM::model()->findByPk($modPengadaan->unitkerja_id);
            if(!empty($cekUnitkerja)){
                $modPengadaan->namaunitkerja = $cekUnitkerja->namaunitkerja;
            }else{
                $modPengadaan->namaunitkerja = "-";
            }

            $cekDet = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$model->suratperjanjiankerja_id));
            if(!empty($cekDet)){
                $modTermin2->jumlah_termin = count($cekDet);
            }else{
                $modTermin2->jumlah_termin = 1;
            }
            
            $total_seluruh =  $model->jumlah_pajak + $model->jumlah_harga;
            
            $model->nilaikontrak = MyFormatter::formatNumberForPrint($model->nilaikontrak, 2);
            $model->jumlah_pajak = MyFormatter::formatNumberForPrint($model->jumlah_pajak, 2);
            $model->jumlah_harga = MyFormatter::formatNumberForPrint($model->jumlah_harga, 2);
            
            $model->total_hargaseluruhnya = MyFormatter::formatNumberForPrint($total_seluruh, 2);
            $model->total_pembulatan = !empty($model->total_pembulatan) ? MyFormatter::formatNumberForPrint($model->total_pembulatan, 2) : null;
            $modDet = SuratperjanjiankerjarincianT::model()->findAll(" suratperjanjiankerja_id = " . $model->suratperjanjiankerja_id . " ");
        } else {
            $cekNegosiasi = BanegosiasiT::model()->findByAttributes(array('persiapanpengadaan_id'=>$model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
            if(!empty($cekNegosiasi)){
                $modPenyedia =  PenawaranpenyediaT::model()->findByAttributes(array('penawaranpenyedia_id'=>$cekNegosiasi->penawaranpenyedia_id, 'isbatal' => false, 'isaddendum' => true));
                if(!empty($modPenyedia)){
                    $modDet = PenawaranpenyediadetT::model()->findAll(" penawaranpenyedia_id = '" . $modPenyedia->penawaranpenyedia_id . "' AND banegosiasi_id = ".$cekNegosiasi->banegosiasi_id);
                    $model->jumlah_harga = !empty($cekNegosiasi->jumlah_negosiasi) ? MyFormatter::formatNumberForPrint($cekNegosiasi->jumlah_negosiasi, 2) : null;
                    $model->jumlah_pajak = !empty($cekNegosiasi->pajak_negosiasi) ? MyFormatter::formatNumberForPrint($cekNegosiasi->pajak_negosiasi, 2) : null;
                    $model->total_hargaseluruhnya = !empty($cekNegosiasi->total_negosiasi) ? MyFormatter::formatNumberForPrint($cekNegosiasi->total_negosiasi, 2) : null;
                    $model->total_pembulatan = !empty($cekNegosiasi->pembulatan_negosiasi) ? MyFormatter::formatNumberForPrint($cekNegosiasi->pembulatan_negosiasi, 2) : null;
                    $model->statusnya = 'banegosiasi';
                    $model->nilaikontrak = !empty($cekNegosiasi->pembulatan_negosiasi) ? MyFormatter::formatNumberForPrint($cekNegosiasi->pembulatan_negosiasi, 2) : null;
                }else{
                    $modDet = ADPersiapanpengadaandetT::model()->findAll(" persiapanpengadaan_id = '" . $id . "' ");
                    $cekPengadaan = PersiapanpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
                    $model->statusnya = 'persiapanpengadaan';
                    $model->jumlah_harga = !empty($cekPengadaan->total_harga) ? MyFormatter::formatNumberForPrint($cekPengadaan->total_harga, 2) : null;
                    $model->jumlah_pajak = !empty($cekPengadaan->total_pajak) ? MyFormatter::formatNumberForPrint($cekPengadaan->total_pajak, 2) : null;
                    $model->total_hargaseluruhnya = !empty($cekPengadaan->total_hargaseluruhnya) ? MyFormatter::formatNumberForPrint($cekPengadaan->total_hargaseluruhnya, 2) : null;
                    $model->nilaikontrak = !empty($cekPengadaan->total_hargaseluruhnya) ? MyFormatter::formatNumberForPrint($cekPengadaan->total_hargaseluruhnya, 2) : null;
                }
            }else{
                $modDet = ADPersiapanpengadaandetT::model()->findAll(" persiapanpengadaan_id = '" . $id . "' ");
                $cekPengadaan = PersiapanpengadaanT::model()->findByPk($id);
                $model->statusnya = 'persiapanpengadaan';
                $model->jumlah_harga = MyFormatter::formatNumberForPrint($cekPengadaan->total_harga, 2);
                $model->jumlah_pajak = MyFormatter::formatNumberForPrint($cekPengadaan->total_pajak, 2);
                $model->total_hargaseluruhnya = MyFormatter::formatNumberForPrint($cekPengadaan->total_hargaseluruhnya, 2);
                $model->nilaikontrak = MyFormatter::formatNumberForPrint($cekPengadaan->total_hargaseluruhnya, 2);
            }

            $modPengadaan = PersiapanpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
            $modPengadaan->pelaksanaankontrak_tglawal = date('d M Y', strtotime($modPengadaan->pelaksanaankontrak_tglawal));
            $modPengadaan->pelaksanaankontrak_tglakhir = date('d M Y', strtotime($modPengadaan->pelaksanaankontrak_tglakhir));

            //$model->no_putusanpenggunaanggaran = !empty($modPejabat) ? $modPejabat->no_sk : "-";
            //$model->tglputusanpenggunaanggaran = !empty($modPejabat) ? MyFormatter::formatDateTimeForUser($modPejabat->tgl_sk) : "-";

            $cekUnitkerja = UnitkerjaM::model()->findByPk($modPengadaan->unitkerja_id);
            if(!empty($cekUnitkerja)){
                $modPengadaan->namaunitkerja = $cekUnitkerja->namaunitkerja;
            }else{
                $modPengadaan->namaunitkerja = "-";
            }
            $modTermin2->jumlah_termin = 1;
            
            $model->tgl_dpa = !empty($model->tgl_dpa) ? MyFormatter::formatDateTimeForUser($model->tgl_dpa) : null;   
        }

        $cekInstalasi = InstalasiM::model()->findByPk($modPengadaan->instalasi_id);
        if (!empty($cekInstalasi)) {
            $modPengadaan->instalasi_nama = $cekInstalasi->instalasi_nama;
            $modPengadaan->instalasi_id = $cekInstalasi->instalasi_id;
        } else {
            $modPengadaan->instalasi_nama = '-';
            $modPengadaan->instalasi_id = null;
        }

        $cekMetode = MetodepengadaanM::model()->findByPk($modPengadaan->metodepengadaan_id);
        if (!empty($cekMetode)) {
            $modPengadaan->metodepengadaan_nama = $cekMetode->metodepengadaan_nama;
        } else {
            $modPengadaan->metodepengadaan_nama = '-';
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

        if(!empty($modPengadaan->rencanaumumpengadaan_id)){
            $cekMapping = PengadaansumberdanaT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $modPengadaan->rencanaumumpengadaan_id));
            $koderek = $cekMapping->mappingrekeninganggaran->kodeanggaran.' - '.$cekMapping->mappingrekeninganggaran->nama_rekeninganggaran5;
            $mappingrekeninganggaran_id = $cekMapping->mappingrekeninganggaran_id;
        }else{
            $koderek = '-';    
            $mappingrekeninganggaran_id = '';
        }
        
        
        $model->programkerja_nama = $programkerja_nama;
        $model->kegiatanprogram_nama = $kegiatanprogram_nama;
        $model->subprogramkerja_nama = $subkegiatanprogram_nama;               
       
        $cekPenawaran = PenawaranpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
        if (!empty($cekPenawaran)) {            
            $model->supplier_nama = $cekPenawaran->supplier->supplier_nama;
            $model->tglpenawaran = !empty($model->tglpenawaran)?MyFormatter::formatDateTimeForUser($model->tglpenawaran ):null;            
            $model->nomor_rekening = $cekPenawaran->supplier->supplier_norekening;
            $model->nama_supplier = $cekPenawaran->supplier->direktursupplier;
            $model->alamat_supplier = $cekPenawaran->supplier->supplier_alamat;
        } else {            
            $cekSupplier = SupplierM::model()->findByPk($model->supplier_id);
            if(!empty($cekSupplier)){
                $model->nomor_rekening = $cekSupplier->supplier_norekening;
                $model->nama_supplier = $cekSupplier->direktursupplier;
                $model->alamat_supplier = $cekSupplier->supplier_alamat;
            }
        }        

        $model->tanggal_perubahan = date('d M Y H:i:s');
        
        if (isset($_POST['SuratperjanjiankerjaT'])) {
            $trans = Yii::app()->db->beginTransaction();
            try {
                if ($model->saveSuratPerjanjian($_POST)) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('ubah', 'ubah'=>true,'suratperjanjiankerja_id' => $suratperjanjiankerja_id));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
                }
            } catch (CException $e) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data Gagal Disimpan " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modPengadaan' => $modPengadaan,
            'modDet' => $modDet,
            'modTermin' => $modTermin,
            'modTermin2' => $modTermin2,
        ));
    }
    
}
