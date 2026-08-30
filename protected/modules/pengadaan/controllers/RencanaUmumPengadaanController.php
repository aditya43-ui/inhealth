<?php

/**
 * Transaksi Rencana Umum Pengadaan (RUP) Pengadaan
 * Terdapat 2 jenis yaitu : Penyedia dan Swakelola. Masing-masing memiliki input form dan jenis pengadaan yang bebeda
 * penghapusan limit 5 pada RAB
 * @author Tantowi J <tantowijaya@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.pengadaan
 * @subpackage controller
 */
class RencanaUmumPengadaanController extends MyAuthController {

    /**
     * Menu transaksi RUP Penyedia dan Swakelola
     * @param integer $rencanaumumpengadaan_id
     */
    public function actionIndex($rencanaumumpengadaan_id = null) {
        $model = new ADRencanaumumpengadaanT;
        $modLokasi = new PengadaanlokasiT;
        $modSumberDana = new PengadaansumberdanaT;
        $modJenis = new PengadaanjenisT;
        $modDet = new RencanaumumpengadaandetT;
        $arrLokasi = array();
        $arrSumberDana = array();
        $arrJenis = array();
        
        $konfig = KonfigsystemK::model()->find();

        $model->rencanaumumpengadaan_nomor = "Otomatis";
        $model->rencanaumumpengadaan_kategori = Params::KATEGORI_PENGADAAN_DEFAULT;
        $model->swakelola_tipe = Params::KATEGORI_PENGADAAN_TIPE_DEFAULT;
        $model->pegawaipembuat_id = Yii::app()->user->getState('pegawai_id');
        $model->ispaket = 'ada';
        if (!empty($model->pegawaipembuat_id)) { //Load data pegawai dari Log-In serta Unit Kerja
            $pegawai = PegawaiM::model()->findByPk($model->pegawaipembuat_id);
            $unit = UnitkerjaM::model()->findByPk($pegawai->unitkerja_id);
            $model->pegawaipembuat_nama = $pegawai->namaLengkap;
            $model->unitkerja_id = $pegawai->unitkerja_id;
            $model->unitkerja_nama = !empty($unit) ? $unit->namaunitkerja : "-";
            $model->instalasi_id = !empty($unit) ? $unit->instalasi_id : null;
            $model->instalasi_nama = !empty($unit->instalasi_id) ? $unit->instalasi->instalasi_nama : null;
        }
        $model->isprodukdalamnegeri = 1;
        $model->isusahakecil = 0;
        $model->isdikecualikan = 0;
        $model->ispradpa = false;
        $model->is_hutang = 0;

        if (!empty($rencanaumumpengadaan_id)) {
            $model = ADRencanaumumpengadaanT::model()->findByPk($rencanaumumpengadaan_id);
            $model->pegawaipembuat_nama = $model->pegawaipembuat->namaLengkap;
            $model->unitkerja_nama = $model->unitkerja->namaunitkerja;
            $model->subprogram_nama = $model->subprogram->subprogramkerja_nama;
            $model->isprodukdalamnegeri = ($model->isprodukdalamnegeri) ? 1 : 0;
            $model->isusahakecil = ($model->isusahakecil) ? 1 : 0;

            $arrLokasi = PengadaanlokasiT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $rencanaumumpengadaan_id));
            $arrSumberDana = PengadaansumberdanaT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $rencanaumumpengadaan_id));
            $arrJenis = PengadaanjenisT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $rencanaumumpengadaan_id));
            $modRAB = RencanaumumpengadaandetT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $rencanaumumpengadaan_id));
        }

        if (isset($_POST['ADRencanaumumpengadaanT'])) {
            $valueansaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $model->attributes = $_POST['ADRencanaumumpengadaanT'];
                $model->rencanaumumpengadaan_nomor = MyGenerator::NoRUP();
                $model->rencanaumumpengadaan_tahun = !empty($model->periodeanggaran_id) ? $model->periodeanggaran->tahunanggaran : null;
                $model->metode_pengadaan = !empty($model->metodepengadaan_id) ? $model->metodepengadaan->metodepengadaan_nama : null;
                $model->total_pagu = $_POST['total_hargaseluruhnya']; //total dari jumlah detail RBA
                $model->kode_rup = null;
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->dpa_pagu = $_POST['ADRencanaumumpengadaanT']['dpa_pagu'];
                $model->subkegiatanprogram_id = $_POST['ADPengadaanprogramT'][0]['subkegiatanprogram_id'];
                $model->subprogram_id = $_POST['ADPengadaanprogramT'][0]['subprogramkerja_id'];
                if ($model->ispaket == 'ada') {
                    $model->ispaket = true;
                } else {
                    $model->ispaket = false;
                }
                
                if ($konfig->is_simplifikasipengadaan == true){
                    $model->rencanaumumpengadaan_status = 'Persetujuan PPK';
                }else{
                    if ($_POST['ADRencanaumumpengadaanT']['statusnya'] == 'Draft') {
                        $model->rencanaumumpengadaan_status = 'Draft';
                    } else {
                        $model->rencanaumumpengadaan_status = 'Persetujuan PPK';
                    }
                }

                //$model->validate(); //disini juga terdapat konversi tanggal agar sesuai format DB                
                if ($model->save()) { //jika transaksi berhasil simpan                                        
                    $ok &= true;
                    
                    if (isset($_POST['ADPengadaanprogramT'])){
                        foreach($_POST['ADPengadaanprogramT'] as $det){
                            $modNew = new ADPengadaanprogramT;
                            $modNew->attributes = $det;
                            $modNew->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;
                            if ($modNew->save()) {
                                $ok &= true;
                            } else {
                                $ok &= false;
                            }                            
                        }
                    }
                    
                    if (isset($_POST['PengadaanlokasiT'])) {
                        foreach ($_POST['PengadaanlokasiT'] as $key => $value) {
                            $modLokasi = new PengadaanlokasiT;
                            $modLokasi->attributes = $value;
                            $modLokasi->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;
                            if ($modLokasi->save()) {
                                $ok &= true;
                            } else {
                                $ok &= false;
                            }
                        }
                    }
                    /* Simpan sumber dana pengadaan */
                    if (isset($_POST['PengadaansumberdanaT'])) {
                        foreach ($_POST['PengadaansumberdanaT'] as $key => $value) {
                            $modSumberDana = new PengadaansumberdanaT;
                            $modSumberDana->attributes = $value;
                            $modSumberDana->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;
                            if ($modSumberDana->save()) {
                                $ok &= true;
                            } else {
                                $ok &= false;
                            }
                        }
                    }
                    /* Simpan jenis pengadaan */
                    if (isset($_POST['PengadaanjenisT'])) {
                        foreach ($_POST['PengadaanjenisT'] as $key => $value) {
                            $modJenis = new PengadaanjenisT;
                            $modJenis->attributes = $value;
                            $modJenis->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;
                            $modJenis->jenispengadaan_nama = !empty($modJenis->jenispengadaan_id) ? $modJenis->jenispengadaan->jenispengadaan_nama : null;
                            if ($modJenis->save()) {
                                $ok &= true;
                            } else {
                                $ok &= false;
                            }
                        }
                    }
                    /* Simpan rencana umum pengadaan */
                    if (isset($_POST['RencanaumumpengadaandetT'])) {
                        foreach ($_POST['RencanaumumpengadaandetT'] as $key => $value) {
                            $modDet = new RencanaumumpengadaandetT;
                            $modDet->attributes = $value;
                            $modDet->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;
                            if ($modDet->save()) {
                                $ok &= true;
                                $modDok = DokumenpelaksanaananggarandetT::model()->findByPk($value['dokumenpelaksanaananggarandet_id']);
                                    $modDok->sisapagu_pengadaan -= $modDet->rencanaumumpengadaandet_jumlah;
                                    if ($modDok->sisapagu_pengadaan <= 0) {
                                        $modDok->sisapagu_pengadaan = 0;
                                        if ($modDok->harga_satuan > 0 && $modDok->volume > 0) {
                                            $modDok->pengadaan_status = true;
                                        }
                                    }
                                    $modDok->sisavolume_pengadaan -= $modDet->rencanaumumpengadaandet_volume;
                                    if ($modDok->sisapagu_pengadaan <= 0) {
                                        $modDok->sisapagu_pengadaan = 0;
                                    }
                                    $ok &= $modDok->save();
                            } else {
                                $ok &= false;
                            }
                        }
                    }

                    if ($_POST['ADRencanaumumpengadaanT']['statusnya'] == 'PPK') {
                        /* Update Dokumen pelaksanaan anggaran det */
                        if (isset($_POST['RencanaumumpengadaandetT'])) {
                            foreach ($_POST['RencanaumumpengadaandetT'] as $key => $value) {
                                $modDok = DokumenpelaksanaananggarandetT::model()->findByPk($value['dokumenpelaksanaananggarandet_id']);
                                if ($modDok->harga_satuan > 0 && $modDok->volume > 0) {
                                    $modDok->pengadaan_status = true;
                                }

                                if ($modDok->update()) {
                                    $ok &= true;
                                } else {
                                    $ok &= false;
                                }
                            }
                        }
                    }
                    //simpan riwayat
                    $modRiwayat = new RiwayatpengadaanR;
                    $modRiwayat->pegawai_id = Yii::app()->user->getState('pegawai_id');
                    $peg = ADPegawaiM::model()->findByPk($modRiwayat->pegawai_id);
                    $jab = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => Yii::app()->user->getState('pegawai_id')));
                    $modRiwayat->nama_pegawai = !empty($peg) ? $peg->namaLengkap : '';
                    $modRiwayat->jabatan_pengadaan = !empty($jab) ? $jab->jabatan_pengadaan : '';
                    $modRiwayat->create_time = date('Y-m-d H:i:s');
                    $modRiwayat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modRiwayat->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modRiwayat->tanggal_update = date('Y-m-d H:i:s');
                    $modRiwayat->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;

                    if ($konfig->is_simplifikasipengadaan == true){
                        $modRiwayat->status_berkas = 'Persetujuan PPK';
                    }else{
                        if ($_POST['ADRencanaumumpengadaanT']['statusnya'] == 'Draft') {
                            $modRiwayat->status_berkas = 'Draft';
                        } else {
                            $modRiwayat->status_berkas = 'Persetujuan PPK';
                        }
                    }

                    if ($modRiwayat->save()) {
                        $ok &= true;
                    } else {
                        $ok &= false;
                    }
                   
                //Put The SMS Code Here
                }//if ($model->save()) 
                else {                    
                    $ok &= false;
                }
                if ($ok) {
                    $valueansaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
                    $this->redirect(array('/pengadaan/informasiRencanaUmum/detail', 'id' => $model->rencanaumumpengadaan_id, 'sukses' => 1));
                } else {
                    $valueansaction->rollback();
                    Yii::app()->user->setFlash('error', "Gagal! Data Gagal Disimpan.");
                }
            } catch (Exception $ex) {
                $valueansaction->rollback();
                Yii::app()->user->setFlash('error', "Gagal! Data Gagal Disimpan." . MyExceptionMessage::getMessage($ex, true));
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('index', array(
                'model' => $model,
                'modLokasi' => $modLokasi,
                'modSumberDana' => $modSumberDana,
                'modJenis' => $modJenis,
                'arrLokasi' => $arrLokasi,
                'arrSumberDana' => $arrSumberDana,
                'arrJenis' => $arrJenis,
                'modDet' => $modDet
            ));
        } else {
            $this->render('index', array(
                'model' => $model,
                'modLokasi' => $modLokasi,
                'modSumberDana' => $modSumberDana,
                'modJenis' => $modJenis,
                'arrLokasi' => $arrLokasi,
                'arrSumberDana' => $arrSumberDana,
                'arrJenis' => $arrJenis,
                'modDet' => $modDet
            ));
        }
    }

    /**
     * Autocomplete Sub program kerja / kegiatan
     */
    public function actionAutocompleteKegiatan() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(subprogramkerja_nama)', strtolower($_GET['term']), true);
            $criteria->order = 'subprogramkerja_nama';
            $criteria->limit = 5;
            $models = SubprogramkerjaM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->subprogramkerja_kode . " - " . $model->subprogramkerja_nama;
                $returnVal[$i]['value'] = $model->subprogramkerja_id;

                $cekSubprogramkerja = SubprogramkerjaM::model()->findByPk($model->subprogramkerja_id);
                if (!empty($cekSubprogramkerja)) {
                    $returnVal[$i]['subprogramkerja_nama'] = $cekSubprogramkerja->subprogramkerja_nama;
                    $returnVal[$i]['subprogramkerja_id'] = $cekSubprogramkerja->subprogramkerja_id;
                    $cekProgramkerja = ProgramkerjaM::model()->findByPk($cekSubprogramkerja->programkerja_id);
                    if (!empty($cekProgramkerja)) {
                        $returnVal[$i]['programkerja_nama'] = $cekProgramkerja->programkerja_nama;
                    }
                }
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete kegiatan program by no programkegiatan nama
     */
    public function actionAutoCompleteKegiatanProgram() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->select = " t.*,r5.rekening5_id, r5.nmrekening5, r5.kdrekening5 ";
            $criteria->join = " LEFT JOIN rekening5_m r5 ON r5.rekening5_id = t.rekening5_id ";
            $criteria->addCondition(" nmrekening5 ilike '%" . $_GET['term'] . "%' OR kdrekening5 ilike '%" . $_GET['term'] . "%' ");
            if (!empty($_GET['subprogramkerja_id'])) {
                $criteria->addCondition(" subprogramkerja_id = " . $_GET['subprogramkerja_id'] . " ");
            } else {
                $criteria->addCondition(" kegiatanprogram_id is null ");
            }
            $criteria->order = 'kegiatanprogram_nama ASC';
            $criteria->limit = 5;
            $models = KegiatanprogramM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->kegiatanprogram_kode . " - " . $model->kegiatanprogram_nama;
                $returnVal[$i]['value'] = $model->rekening5_id;
                $returnVal[$i]['namarekening'] = $model->kegiatanprogram_kode . ' - ' . $model->kegiatanprogram_nama;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Get data kabupaten berdasarkan propinsi_id
     */
    public function actionSetDropdownKabupaten() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal['form'] = "";
            $kabupaten = null;
            $criteria = new CDbCriteria();
            $criteria->addCondition("propinsi_id = " . $_POST['propinsi_id']);
            $criteria->compare('kabupaten_aktif', true);
            $criteria->order = 'kabupaten_nama';
            $models = KabupatenM::model()->findAll($criteria);
            $kabupaten = CHtml::listData($models, 'kabupaten_id', 'kabupaten_nama');

            if (!empty($kabupaten)) {
                foreach ($kabupaten as $value => $name) {
                    $returnVal['form'] .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Digunakan untuk mengenerate pegawai PPK berdasarkan instalasi yang dipilih
     */
    public function actionGeneratePegawaiPPK() {
        if (Yii::app()->request->isAjaxRequest) {
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;

            $cekDet = PejabatpengadaandetM::model()->findByAttributes(array('instalasi_id' => $instalasi_id));
            if (!empty($cekDet)) {
                $cekmodel = PejabatpengadaanM::model()->findByPk($cekDet->pejabatpengadaan_id);
                if (!empty($cekmodel)) {
                    $cekUnitKerja = UnitkerjaM::model()->findByAttributes(array('instalasi_id' => $instalasi_id));

                    $unitkerja_id = !empty($cekUnitKerja) ? $cekUnitKerja->unitkerja_id : '000';
                    $value = '  <div class="control-group">
                                    <label class="control-label" for="ADRencanaumumpengadaanT_pegawaippk_id">PPK</label>            
                                    <div class="controls">
                                        <input readonly="readonly" value="' . $unitkerja_id . '" class="span4" onkeyup="return $(this).focusNextInputField(event);" id="unitkerjanya" type="hidden">
                                        <input readonly="readonly" value="' . $cekmodel->pegawai_id . '" class="span4" onkeyup="return $(this).focusNextInputField(event);" name="ADRencanaumumpengadaanT[pegawaippk_id]" id="ADRencanaumumpengadaanT_pegawaippk_id" type="hidden">
                                        <input readonly="readonly" value="' . $cekmodel->pegawai->namaLengkap . '" class="span4" onkeyup="return $(this).focusNextInputField(event);" name="ADRencanaumumpengadaanT[pegawaippk_nama]" id="ADRencanaumumpengadaanT_pegawaippk_nama" type="text">            
                                    </div>
                                </div>
                             ';
                } else {
                    $cekUnitKerja = UnitkerjaM::model()->findByAttributes(array('instalasi_id' => $instalasi_id));

                    $unitkerja_id = !empty($cekUnitKerja) ? $cekUnitKerja->unitkerja_id : '000';
                    $value = '  <div class="control-group">
                                    <label class="control-label" for="ADRencanaumumpengadaanT_pegawaippk_id">PPK</label>            
                                    <div class="controls">
                                        <input readonly="readonly" value="' . $unitkerja_id . '" class="span4" onkeyup="return $(this).focusNextInputField(event);" id="unitkerjanya" type="hidden">
                                        <input readonly="readonly" class="span4" onkeyup="return $(this).focusNextInputField(event);" name="ADRencanaumumpengadaanT[pegawaippk_id]" id="ADRencanaumumpengadaanT_pegawaippk_id" type="hidden">
                                        <input readonly="readonly" class="span4" onkeyup="return $(this).focusNextInputField(event);" name="ADRencanaumumpengadaanT[pegawaippk_nama]" id="ADRencanaumumpengadaanT_pegawaippk_nama" type="text">            
                                    </div>
                                </div>';
                }
            } else {
                $cekUnitKerja = UnitkerjaM::model()->findByAttributes(array('instalasi_id' => $instalasi_id));

                $unitkerja_id = !empty($cekUnitKerja) ? $cekUnitKerja->unitkerja_id : '000';
                $value = '  <div class="control-group">
                                <label class="control-label" for="ADRencanaumumpengadaanT_pegawaippk_id">PPK</label>            
                                <div class="controls">
                                    <input readonly="readonly" value="' . $unitkerja_id . '" class="span4" onkeyup="return $(this).focusNextInputField(event);" id="unitkerjanya" type="hidden">
                                    <input readonly="readonly" class="span4" onkeyup="return $(this).focusNextInputField(event);" name="ADRencanaumumpengadaanT[pegawaippk_id]" id="ADRencanaumumpengadaanT_pegawaippk_id" type="hidden">
                                    <input readonly="readonly" class="span4" onkeyup="return $(this).focusNextInputField(event);" name="ADRencanaumumpengadaanT[pegawaippk_nama]" id="ADRencanaumumpengadaanT_pegawaippk_nama" type="text">            
                                </div>
                            </div>';
            }

            $data['sukses'] = 1;
            $data['html'] = $value;
            $data['unitkerja_id'] = $unitkerja_id;

            echo json_encode($data);

            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk mengenerate pegawai PPK berdasarkan instalasi yang dipilih
     */
    public function actionGeneratePegawaiPAKPA() {
        if (Yii::app()->request->isAjaxRequest) {
            $periodeanggaran_id = isset($_POST['periodeanggaran_id']) ? $_POST['periodeanggaran_id'] : null;
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
            //$cekPeriode = PeriodeanggaranK::model()->findByAttributes(array('periodeanggaran_id' => $periodeanggaran_id));            
            $pejabatPA = PejabatpengadaanM::model()->findByAttributes(array('pejabatpengadaan_aktif' => true, 'jabatan_pengadaan' => Params::JABATAN_PENGADAAN_PA));
            $value = '';
            $valuePA = ' 
                        <div class="col-md-12">
                            <div class="control-group">
                                <label class="control-label" for="ADRencanaumumpengadaanT_pegawaipa_id">PA <span class="required">*</span></label>            
                                <div class="controls">
                                    <input readonly="readonly" value="' . (!empty($pejabatPA) ? $pejabatPA->pegawai_id : '') . '" class="span4 required" onkeyup="return $(this).focusNextInputField(event);" name="ADRencanaumumpengadaanT[pegawaipa_id]" id="ADRencanaumumpengadaanT_pegawaipa_id" type="hidden">
                                    <input readonly="readonly" value="' . (!empty($pejabatPA) ? $pejabatPA->pegawai->namaLengkap : '') . '" class="span4 required" onkeyup="return $(this).focusNextInputField(event);" name="ADRencanaumumpengadaanT[pegawaipa_nama]" id="ADRencanaumumpengadaanT_pegawaipa_nama" type="text">            
                                </div>
                            </div>
                        </div>
                     ';

            $data['sukses'] = 1;
            $data['html'] = $value;
            $data['html_pa'] = $valuePA;

            echo json_encode($data);

            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk mengenerate tabel RAB
     */
    public function actionGenerateTableRAB() {
        if (Yii::app()->request->isAjaxRequest) {
            $periodeanggaran_id = isset($_POST['periodeanggaran_id']) ? $_POST['periodeanggaran_id'] : null;
            $unitkerjanya = isset($_POST['unitkerjanya']) ? $_POST['unitkerjanya'] : null;
            $subkegiatanprogram_id = isset($_POST['subkegiatanprogram_id']) ? $_POST['subkegiatanprogram_id'] : null;
            $mappingrekeninganggaran_id = isset($_POST['mappingrekeninganggaran_id']) ? $_POST['mappingrekeninganggaran_id'] : null;
            $loadData = isset($_POST['loaddata']) ? $_POST['loaddata'] : null;
            $value = "";
            $valueTotal = "";

            $criteria = new CDbCriteria();
            $criteria->join = " JOIN dokumenpelaksanaananggaran_t a ON a.dokumenpelaksanaananggaran_id = t.dokumenpelaksanaananggaran_id ";
            if (!empty($periodeanggaran_id)) {
                $criteria->addCondition(" a.periodeanggaran_id = " . $periodeanggaran_id . " ");
            } else {
                $criteria->addCondition(" t.dokumenpelaksanaananggarandet_id is null ");
            }
            if (!empty($unitkerjanya)) {
                $criteria->addCondition(" t.unitkerja_id = " . $unitkerjanya . " ");
            } else {
                $criteria->addCondition(" t.dokumenpelaksanaananggarandet_id is null ");
            }
            if (!empty($mappingrekeninganggaran_id)) {
                $criteria->addCondition(" t.mappingrekeninganggaran_id = " . $mappingrekeninganggaran_id . " ");
            } else {
                $criteria->addCondition(" t.dokumenpelaksanaananggarandet_id is null ");
            }
            if (!empty($subkegiatanprogram_id)) {
                $criteria->addInCondition(" t.subkegiatanprogram_id ", $subkegiatanprogram_id);
            } else {
                $criteria->addCondition(" t.dokumenpelaksanaananggarandet_id is null ");
            }
            $criteria->addCondition('pengadaan_status IS FALSE');
            $modDokumen = DokumenpelaksanaananggarandetT::model()->findAll($criteria);

            $value .= "<thead>";
            $value .= "<tr>";
            $value .= "<th style='text-align: center; vertical-align: middle'>No.</th>";
            $value .= "<th style='text-align: center; vertical-align: middle'>Jenis Barang / Jasa <span class='required'>*</span></th></th></th>";
            $value .= "<th style='text-align: center; vertical-align: middle'>Satuan</th>";
            $value .= "<th style='text-align: center; vertical-align: middle'>Volume <span class='required'>*</span></th></th>";
            $value .= "<th style='text-align: center; vertical-align: middle'>Harga (Rp) <span class='required'>*</span></th></th>";
            $value .= "<th style='text-align: center; vertical-align: middle'>Pajak (%) <span class='required'>*</span></th></th>";
            $value .= "<th style='text-align: center; vertical-align: middle'>Jumlah <br> Harga (Rp) <span class='required'>*</span></th>";
            $value .= "<th style='text-align: center; vertical-align: middle'>Sisa <br> Pagu (Rp) <span class='required'>*</span></th>";
            $value .= "<th style='text-align: center; vertical-align: middle'>Aksi</th>";
            $value .= "</tr>";
            $value .= "</thead>";
            $i = 1;
            $total = 0;
            $total2 = 0;
            $total_sisapagu = 0;
            $value .= "<tbody>";
            if (!empty($loadData)) {
                foreach ($modDokumen as $row2) {
                    $total2 += $row2->jumlah;
                }
                foreach ($modDokumen as $row) {
                    $value .= "<tr>";
                    $value .= "<td>" . $i . ""
                            . "<input readonly='readonly' class='span2' onkeyup='return $(this).focusNextInputField(event);' name='RencanaumumpengadaandetT[" . $i . "][barang_id]' id='RencanaumumpengadaandetT_" . $i . "_barang_id' value='" . $row->barang_id . "' type='hidden'>
                                 <input readonly='readonly' class='span2' onkeyup='return $(this).focusNextInputField(event);' name='RencanaumumpengadaandetT[" . $i . "][jenis_barang]' id='RencanaumumpengadaandetT_" . $i . "_jenis_barang' value='" . $row->jenis_barang . "' type='hidden'>
                                 <input readonly='readonly' class='span2' onkeyup='return $(this).focusNextInputField(event);' name='RencanaumumpengadaandetT[" . $i . "][dokumenpelaksanaananggarandet_id]' id='RencanaumumpengadaandetT_" . $i . "_dokumenpelaksanaananggarandet_id' value='" . $row->dokumenpelaksanaananggarandet_id . "' type='hidden'>
                                 <input class='span2' onkeyup='return $(this).focusNextInputField(event);' name='total' id='total' value='" . $total2 . "' type='hidden'>
                               </td>";
                    $value .= "<td><input readonly='readonly' class='span2' onkeyup='return $(this).focusNextInputField(event);' name='RencanaumumpengadaandetT[" . $i . "][rencanaumumpengadaandet_nama]' id='RencanaumumpengadaandetT_" . $i . "_rencanaumumpengadaandet_nama' value='" . $row->uraian . "' type='text'></td>";
                    $value .= "<td><input readonly='readonly' class='span2' onkeyup='return $(this).focusNextInputField(event);' name='RencanaumumpengadaandetT[" . $i . "][rencanaumumpengadaandet_satuan]' id='RencanaumumpengadaandetT_" . $i . "_rencanaumumpengadaandet_satuan' value='" . $row->satuan . "' type='text'></td>";
                    $value .= "<td><input class='span2 required numbers-only volume ubah' onchange='hitung();' onkeyup='return $(this).focusNextInputField(event); ' name='RencanaumumpengadaandetT[" . $i . "][rencanaumumpengadaandet_volume]' id='RencanaumumpengadaandetT_" . $i . "_rencanaumumpengadaandet_volume' value='" . $row->sisavolume_pengadaan . "' type='text'>"
                            . "<input class='span2 required numbers-only volumeawal ubah' name='RencanaumumpengadaandetT[" . $i . "][volumeawal]' id='RencanaumumpengadaandetT_" . $i . "_volumeawal' value='" . $row->sisavolume_pengadaan . "' type='hidden'></td>";
                    $value .= "<td><input class='span2 required integer-decimal estimasi ubah' onchange='hitung();' onkeyup='return $(this).focusNextInputField(event);' name='RencanaumumpengadaandetT[" . $i . "][rencanaumumpengadaandet_harga]' id='RencanaumumpengadaandetT_" . $i . "_rencanaumumpengadaandet_harga' value='" . $row->harga_satuan . "' type='text'>"
                            . "<input class='span2 required integer-decimal estimasiawal ubah' name='RencanaumumpengadaandetT[" . $i . "][hargaawal]' id='RencanaumumpengadaandetT_" . $i . "_hargaawal' value='" . $row->harga_satuan . "' type='hidden'></td>";
                    $value .= "<td><input class='span2 required float2 persenpajak ubah' onchange='hitung();' onkeyup='return $(this).focusNextInputField(event);' name='RencanaumumpengadaandetT[" . $i . "][rencanaumumpengadaandet_pajak]' id='RencanaumumpengadaandetT_" . $i . "_rencanaumumpengadaandet_pajak' value='0' type='text'>"
                            . "<input class='span2 required float2 persenpajakawal ubah' name='RencanaumumpengadaandetT[" . $i . "][persenawal]' id='RencanaumumpengadaandetT_" . $i . "_persenawal' value='0' type='hidden'></td>";
                    $value .= "<td><input readonly='readonly' class='span2 required integer-decimal harga' onkeyup='return $(this).focusNextInputField(event);' name='RencanaumumpengadaandetT[" . $i . "][rencanaumumpengadaandet_jumlah]' id='RencanaumumpengadaandetT_" . $i . "_rencanaumumpengadaandet_jumlah' value='" . $row->jumlah . "' type='text'>";
                    $value .= "<input readonly='readonly' class='span2 required integer-decimal hargaawal' onkeyup='return $(this).focusNextInputField(event);' name='RencanaumumpengadaandetT[" . $i . "][rencanaumumpengadaandet_jumlahawal]' id='RencanaumumpengadaandetT_" . $i . "_rencanaumumpengadaandet_jumlahawal' value='" . $row->jumlah . "' type='hidden'>";
                    $value .= "<input readonly='readonly' class='span2 required integer-decimal  pajak' onkeyup='return $(this).focusNextInputField(event); ' name='RencanaumumpengadaandetT[" . $i . "][rencanaumumpengadaandet_jmlpajak]' id='RencanaumumpengadaandetT_" . $i . "_rencanaumumpengadaandet_jmlpajak' value='" . (0 * $row->harga_satuan * $row->sisavolume_pengadaan) / 100 . "'></td>";
                    $value .= "<input readonly='readonly' class='span2 required integer-decimal  sisapagu_pengadaan' onkeyup='return $(this).focusNextInputField(event); ' name='RencanaumumpengadaandetT[" . $i . "][sisapagu_pengadaan]' id='RencanaumumpengadaandetT_" . $i . "_sisapagu_pengadaan' value='" . $row->sisapagu_pengadaan . "' type='hidden'></td>";
                    $value .= "<td><a onclick='hitung(); hapusRAB(this);  return false;' href='#'><i class='glyphicon glyphicon-minus'></i></a></td>";
                    $value .= "</tr>";
                    $i++;
                    $total += $row->jumlah;
                    $total_sisapagu += $row->sisapagu_pengadaan; 
                }
            } else {
                $modRAB = new RencanaumumpengadaandetT;
                $modRAB->rencanaumumpengadaandet_pajak = 10;
                $modRAB->persenawal = 0;
                $modRAB->rencanaumumpengadaandet_jmlpajak = 0;
                $modRAB->rencanaumumpengadaandet_volume = 0;
                $value .= $this->renderPartial('_rowRABHPS', array('model' => $modRAB), true);
            }
            $value .= "</tbody>
                            <tfoot>
                                <tr>
                                    <th colspan='6' style='text-align: right;'><label>Total Harga</label></th>
                                    <th>
                                        <input readonly='readonly' class='span2 required integer-decimal harga' onkeyup='return $(this).focusNextInputField(event);' name='total_hargaseluruhnya'   id='total_hargaseluruhnya' value='" . $total . "' type='text'>
                                        <input readonly='readonly' class='span2 required integer-decimal harga' onkeyup='return $(this).focusNextInputField(event);' name='total_awal'   id='total_awal' value='" . $total . "' type='hidden'>
                                    </th>
                                    <th>
                                        <input readonly='readonly' class='span2 required integer-decimal total_sisapagu' onkeyup='return $(this).focusNextInputField(event);' name='total_sisapagu'   id='total_sisapagu' value='" . $total_sisapagu . "' type='text'>
                                    </th>
                                    <th colspan='2'></th>
                                </tr>
                            </tfoot>";

            $valueTotal .= "    <div class='control-group'>
                                    <label class='control-label' for='ADRencanaumumpengadaanT_dpa_pagu'>Pagu pada DPA</label>            
                                    <div class='controls'>
                                        <input value='" . $total . "' readonly='readonly' class='span4 required integer-decimal' onkeyup='return $(this).focusNextInputField(event);' placeholder='Pagu pada DPA' name='ADRencanaumumpengadaanT[dpa_pagu]' id='ADRencanaumumpengadaanT_dpa_pagu' type='text'>            
                                    </div>
                                </div>";


            $sisa_pagu = 0;
            foreach ($modDokumen as $dok) {
                $sisa_pagu += $dok->sisapagu_pengadaan;
            }

//            $mapping = MappingrekeninganggaranM::model()->findByPk($mappingrekeninganggaran_id);
//            $sumberdana = '';
//            if (!empty($mapping)){
//                $modSumber = new PengadaansumberdanaT();
//                $modSumber->kegiatanprogram_id = $mapping->kegiatanprogram_id;
//                $modSumber->kode_rekening = $mapping->kodeanggaran.' - '.$mapping->nama_rekeninganggaran5;
//                $modSumber->pagu = $mapping->kodeanggaran;
//                $modSumber->mappingrekeninganggaran_id = $mapping->mappingrekeninganggaran_id;
//                $modSumber->rekeninganggaran5_id = $mapping->rekeninganggaran5_id;
//                $modSumber->pagu = number_format((float)$sisa_pagu,0,",",".");
//                
//                $sumberdana = $this->renderPartial('_rowSumberDana',array('modSumberDana'=>$modSumber), true);
//            }

            $data['sukses'] = 1;
            $data['html'] = $value;
            $data['valtotal'] = $valueTotal;
            //   $data['sumberdana'] = $sumberdana;

            echo json_encode($data);

            Yii::app()->end();
        }
    }

    /**
     * Autocomplete Rekening 5
     */
    public function actionAutocompleteRekening() {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nmrekening5)', strtolower($_GET['term']), true);
            $criteria->order = 'nourutrek';
            $criteria->limit = 5;
            $models = Rekening5M::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->kdrekening5 . ' - ' . $model->nmrekening5;
                $returnVal[$i]['value'] = $model->rekening5_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionRekeningMAK() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            
            $criteria = new CDbCriteria();
            
            if (!empty($this->subkegiatanprogram_id)) {
                if (is_array($this->subkegiatanprogram_id)) {
                    $criteria->addInCondition("t.subkegiatanprogram_id", $this->subkegiatanprogram_id);
                } else {
                    $criteria->addCondition("t.subkegiatanprogram_id = " . $this->subkegiatanprogram_id);
                }
            }else{
                $criteria->addCondition(" t.Dokumenpelaksanaananggarandet_id is null ");
            }
                        
            $criteria->addCondition(" mappingrekeninganggaran_m.kodeanggaran ilike '%" . $_GET['term'] . "%' OR mappingrekeninganggaran_m.nama_rekeninganggaran5 ilike '%" . $_GET['term'] . "%' ");
            

            $criteria->select = "                            
                                mappingrekeninganggaran_m.rekeninganggaran5_id, 
                                mappingrekeninganggaran_m.nama_rekeninganggaran5,
                                mappingrekeninganggaran_m.mappingrekeninganggaran_id, 
                                mappingrekeninganggaran_m.kodeanggaran, 
                                kegiatanprogram_m.kegiatanprogram_id, 
                                kegiatanprogram_m.kegiatanprogram_nama,
                                sub.subprogramkerja_nama";
            $criteria->join = "join kegiatanprogram_m on kegiatanprogram_m.kegiatanprogram_id = t.kegiatanprogram_id
                               join mappingrekeninganggaran_m on t.mappingrekeninganggaran_id = mappingrekeninganggaran_m.mappingrekeninganggaran_id                            
                               join subprogramkerja_m sub ON sub.subprogramkerja_id =   kegiatanprogram_m.subprogramkerja_id  ";
            $criteria->limit = 5;
            $models = DokumenpelaksanaananggarandetT::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->kodeanggaran.' - '.$model->nama_rekeninganggaran5;
                $returnVal[$i]['value'] = $model->mappingrekeninganggaran_id;                
                $returnVal[$i]['rekeninganggaran5_id'] = $model->rekeninganggaran5_id;               
                $returnVal[$i]['subprogramkerja_nama'] = $model->subprogramkerja_nama;               
                
            }

            echo CJSON::encode($returnVal);
            Yii::app()->end();
        }
    }

    public function actionAutoCompleteBarangJasa() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->join = " JOIN dokumenpelaksanaananggaran_t dok ON dok.dokumenpelaksanaananggaran_id = t.dokumenpelaksanaananggaran_id "
                    . " JOIN unitkerja_m u ON u.unitkerja_id = dok.unitkerja_id ";
            if (isset($_GET['subkegiatanprogram_id'])) {
                $criteria->addCondition(" t.subkegiatanprogram_id = " . $_GET['subkegiatanprogram_id'] . " ");
            } else {
                $criteria->addCondition(" t.dokumenpelaksanaananggarandet_id is null ");
            }

            if (isset($_GET['instalasi_id'])) {
                $criteria->addCondition(" u.instalasi_id = " . $_GET['instalasi_id'] . " ");
            } else {
                $criteria->addCondition(" t.dokumenpelaksanaananggarandet_id is null ");
            }

            if (isset($_GET['periodeanggaran_id'])) {
                $criteria->addCondition(" dok.periodeanggaran_id = " . $_GET['periodeanggaran_id'] . " ");
            } else {
                $criteria->addCondition(" t.dokumenpelaksanaananggarandet_id is null ");
            }

            $criteria->compare('LOWER(t.uraian)', strtolower($_GET['term']), true);
            $criteria->addCondition(" t.pengadaan_status = FALSE ");
            $criteria->order = 'dok.uraian ASC';
            $criteria->limit = 5;
            $models = DokumenpelaksanaananggarandetT::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->uraian;
                $returnVal[$i]['value'] = $model->dokumenpelaksanaananggarandet_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
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
                    $modRAB = new RencanaumumpengadaandetT;
                    $modRAB->rencanaumumpengadaandet_pajak = number_format(10, 2, ',', '.');
                    $modRAB->persenawal = 0;
                    $modRAB->rencanaumumpengadaandet_jmlpajak = 0;
                    $modRAB->rencanaumumpengadaandet_volume = number_format($dok->sisavolume_pengadaan, 2, ',', '.');
                    $modRAB->volumeawal = $modRAB->rencanaumumpengadaandet_volume;
                    //$harga_satuan = ($dok->jumlah - (($dok->jumlah/$modRAB->rencanaumumpengadaandet_volume)/11))/$modRAB->rencanaumumpengadaandet_volume;                    
                    if ($modRAB->rencanaumumpengadaandet_volume == 0) {
                        $harga_satuan = 0;
                    } else {
                        $harga_satuan = ((100 / 110) * $dok->jumlah) / $dok->volume;
                    }
                    $modRAB->rencanaumumpengadaandet_harga = number_format((float) $harga_satuan, 2, ",", ".");
                    $modRAB->hargaawal = $modRAB->rencanaumumpengadaandet_harga;
                    $modRAB->jenis_barang = $dok->jenis_barang;
                    $modRAB->rencanaumumpengadaandet_nama = $dok->uraian;
                    $modRAB->rencanaumumpengadaandet_satuan = $dok->satuan;
                    if ($jenis == 'paket') {
                        $modRAB->paketpekerjaan_id = $dok->paketpekerjaan_id;
                    }
                    
                    $modRAB->dokumenpelaksanaananggarandet_id = $dok->dokumenpelaksanaananggarandet_id;
                    $modRAB->sisapagu_pengadaan = number_format($dok->sisapagu_pengadaan, 2 , ',', '.'); 
                    $modRAB->rencanaumumpengadaandet_jumlah = number_format($dok->jumlah, 2 , ',', '.'); 
                    $modRAB->rencanaumumpengadaandet_jumlahawal = $dok->rencanaumumpengadaandet_jumlah; 
                    $modRAB->barang_id = $dok->barang_id;
                    $html .= $this->renderPartial('_rowRABHPS', array('model' => $modRAB), true);
                }
            }
            $data['sukses'] = 1;
            $data['html'] = $html;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * load metode, berdasarkan nama
     */
    public function actionLoadMetode() {
        if (Yii::app()->request->isAjaxRequest) {
            $subkegiatanprogram_id = isset($_POST['subkegiatanprogram_id']) ? $_POST['subkegiatanprogram_id'] : null;
            $periodeanggaran_id = isset($_POST['periodeanggaran_id']) ? $_POST['periodeanggaran_id'] : null;
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;


            $cri = new CDbCriteria();
            $cri->select = " t.*, met.metodepengadaan_id ";
            $cri->join = "  JOIN dokumenpelaksanaananggaran_t dok ON dok.dokumenpelaksanaananggaran_id = t.dokumenpelaksanaananggaran_id "
                    . "  JOIN unitkerja_m u ON u.unitkerja_id = t.unitkerja_id   "
                    . "  LEFT JOIN metodepengadaan_m met ON met.metodepengadaan_nama = t.metode_pengadaan ";
            $cri->addCondition(" dok.periodeanggaran_id = " . $periodeanggaran_id . " ");
            $cri->addCondition(" t.subkegiatanprogram_id = " . $subkegiatanprogram_id . " ");
            $cri->addCondition(" u.instalasi_id = " . $instalasi_id . " ");
            $model = DokumenpelaksanaananggarandetT::model()->findAll($cri);

            $arr = array();

            foreach ($model as $det) {
                $arr[$det->metode_pengadaan]['id'] = $det->metodepengadaan_id;
                $arr[$det->metode_pengadaan]['det'][$det->dokumenpelaksanaananggaran_id] = $det->dokumenpelaksanaananggaran_id;
            }

            $metode_tampung = '';
            $kategori_tampung = '';

            $nilai_metode = '';
            foreach ($arr as $key => $val) {

                if (!empty($nilai_metode)) {
                    if (count($val) <= $nilai_metode) {
                        $metode_tampung = $val['id'];
                        $kategori_tampung = $key;
                    }
                } else {
                    $metode_tampung = $val['id'];
                    $kategori_tampung = $key;
                }

                $nilai_metode = count($val['det']);
            }



            $data['metode'] = $metode_tampung;
            $data['kategori'] = !empty(strtolower($kategori_tampung) != strtolower(Params::KATEGORI_PENGADAAN_SWAKELOLA)) ? 'Penyedia' : 'Swakelola';
            $data['sukses'] = 1;

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * load paket, sesuai yang diketikkan
     */
    public function actionGetPaketPekerjaan() {
        if (Yii::app()->request->isAjaxRequest) {

            $cri = new CDbCriteria();
            if (!empty($this->unitkerja_id)) {
                $cri->addCondition(" unitkerja_id = " . $this->unitkerja_id . " ");
            }
            if (!empty($this->periodeanggaran_id)) {
                $cri->addCondition(" periodeanggaran_id = " . $this->periodeanggaran_id . " ");
            }

            $cri->compare("LOWER(kode_paketpekerjaan)", strtolower($_GET['term']), true);
            $models = RupPaketV::model()->findAll($cri);

            $returnVal = array();

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->kode_paketpekerjaan;
                $returnVal[$i]['value'] = $model->paketpekerjaan_id;
            }

            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }

    /**
     * load sumber dana, sesuai mappingrekeninganggaran_id
     */
    public function generateSumberDana() {
        if (Yii::app()->request->isAjaxRequest) {
            $mappingrekeninganggaran_id = isset($_POST['$mappingrekeninganggaran_id']) ? $_POST['$mappingrekeninganggaran_id'] : null;

            $mapping = MappingrekeninganggaranM::model()->findByPk($mappingrekeninganggaran_id);
            $sumberdana = '';
            if (!empty($mapping)) {
                $modSumber = new PengadaansumberdanaT();
                $modSumber->kegiatanprogram_id = $mapping->kegiatanprogram_id;
                $modSumber->kode_rekening = $mapping->kodeanggaran;
                $modSumber->pagu = $mapping->kodeanggaran;
                $modSumber->mappingrekeninganggaran_id = $mapping->mappingrekeninganggaran_id;
                $modSumber->rekeninganggaran5_id = $mapping->rekeninganggaran5_id;
                $modSumber->pagu = number_format((float) $sisa_pagu, 0, ",", ".");

                $sumberdana = $this->renderPartial('_rowSumberDana', array('modSumberDana' => $modSumber), true);
            }

            $data['sumberdana'] = $sumberdana;
            $data['sukses'] = 1;

            echo json_encode($data);
        }
    }

    public function actionGenFormSubkegiatan() {
        if (Yii::app()->request->isAjaxRequest) {
            $paket = isset($_POST['paket']) ? $_POST['paket'] : null;
            $paketpekerjaan_id = isset($_POST['paketpekerjaan_id']) ? $_POST['paketpekerjaan_id'] : null;
            $subkegiatanprogram_id = isset($_POST['subkegiatanprogram_id']) ? $_POST['subkegiatanprogram_id'] : null;
            $mappingrekeninganggaran_id = isset($_POST['mappingrekeninganggaran_id']) ? $_POST['mappingrekeninganggaran_id'] : null;
            
            $model = new ADPengadaanprogramT;
            $html = $this->renderPartial("tabel/_tabelListSubKegiatan", array('model' => $model, 'tipe' => 'kosong', 'paket'=>$paket), true);
            if ($paket == 'nonpaket') {                
                $html = $this->renderPartial("tabel/_tabelListSubKegiatan", array('model' => $model, 'paket' => $paket), true);
            }else{
                if (!empty($paketpekerjaan_id)){
                    $cri = new CDbCriteria();                    
                    $cri->addCondition("paketpekerjaan_id =". $paketpekerjaan_id);
                    $cri->addCondition("mappingrekeninganggaran_id =". $mappingrekeninganggaran_id);
                    $cri->addCondition("subkegiatanprogram_id =". $subkegiatanprogram_id);
                    $loadPaket = RupPaketV::model()->find($cri);
                                                      
                    $model->attributes = $loadPaket->attributes;
                    $model->programkerja_nama = $loadPaket->programkerja_nama;
                    $model->subprogramkerja_nama = $loadPaket->subprogramkerja_nama;
                    $model->kegiatanprogram_nama = $loadPaket->kegiatanprogram_nama;
                    $model->subkegiatanprogram_nama = $loadPaket->subkegiatanprogram_nama;

                    $data = $model->attributes;
                    $data['kodeanggaran'] = $loadPaket->kodeanggaran;
                    $data['nama_rekeninganggaran5'] = $loadPaket->nama_rekeninganggaran5;
                    $data['rekeninganggaran5_id'] = $loadPaket->rekeninganggaran5_id;
                    $data['mappingrekeninganggaran_id'] = $loadPaket->mappingrekeninganggaran_id;
                    $data['subprogramkerja_nama'] = $loadPaket->subprogramkerja_nama;
                    $data['subkegiatanprogram_nama'] = $loadPaket->subkegiatanprogram_nama;
                    $html =  $this->renderPartial('row/_rowSubKegiatan',array('model'=>$model, 'tipe'=>'load', 'paket'=>$paket), true);
                                        
                }
            }
            
            $data['sukses'] = 1;
            $data['html'] = $html;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
        

}
