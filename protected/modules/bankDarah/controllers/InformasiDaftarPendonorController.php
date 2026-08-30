<?php

/**
 * digunakan sebagai Informasi daftar pendonor
 * @author  Elham Budianto <elhambudianto1@gmail.com>
 * @author  Andyka <andykaputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @website <.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @category controller
 * */
class InformasiDaftarPendonorController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'bankDarah.views.informasiDaftarPendonor.';
    public $path_view_detailseleksi = 'bankDarah.views.informasiDaftarPendonor.detailSeleksiDarah.';
    public $path_view_detailkantong = 'bankDarah.views.informasiDaftarPendonor.detailKantong.';
    public $batalkantong = false;

    /**
     * Menampilkan daftar pendonor darah
     */
    public function actionIndex() {

        $model = new BDDaftardonasiT('search');

        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");
        if (isset($_GET['BDDaftardonasiT'])) {
            $model->attributes = $_GET['BDDaftardonasiT'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDDaftardonasiT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDDaftardonasiT']['tgl_akhir']);
            $model->no_identitas = $_GET['BDDaftardonasiT']['no_identitas'];
            $model->no_pendonor = $_GET['BDDaftardonasiT']['no_pendonor'];
            $model->no_formulir = $_GET['BDDaftardonasiT']['no_formulir'];
            $model->nama_lengkap = $_GET['BDDaftardonasiT']['nama_lengkap'];
            $model->gol_darah = $_GET['BDDaftardonasiT']['gol_darah'];
            $model->rhesus = $_GET['BDDaftardonasiT']['rhesus'];
            $model->status = $_GET['BDDaftardonasiT']['status'];
            $model->jeniskelamin = $_GET['BDDaftardonasiT']['jeniskelamin'];
        }

        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'daftarpendonor-grid') {
                $this->renderPartial('_table', ['model' => $model]);
                Yii::app()->end();
            }
        }

        $this->render($this->path_view . 'index', array('model' => $model));
    }

    /**
     * Digunakan untuk mengubah status batal donor darah menjadi true
     */
    public function actionBataldonordarah() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            $trans = Yii::app()->db->beginTransaction();
            $modKantong = KantongdarahT::model()->findAllByAttributes(array('daftarpendonor_id' => $id));
            $model = DaftardonasiT::model()->findByPk($id);
            $model->bataldonordarah = true;
            $this->batalkantong = $model->save() && true;
            if ($model->save()) {
                foreach ($modKantong as $kantong) {
                    $Kantong = KantongdarahT::model()->findByPk($kantong->kantongdarah_id);
                    $Kantong->bataldonordarah = true;
                    $this->batalkantong = $Kantong->save() && true;
                }
            }
            if (Yii::app()->request->isAjaxRequest) {
                if ($this->batalkantong == true) {
                    $trans->commit();
                    echo CJSON::encode(array(
                        'status' => 'berhasil_form',
                        'div' => "<div class='flash-success'>Data berhasil diubah.</div>",
                    ));
                    exit;
                } else {
                    $trans->rollback();
                    echo CJSON::encode(array(
                        'status' => 'gagal_form',
                        'div' => "<div class='flash-success'>Data gagal diubah.</div>",
                    ));
                    exit;
                }
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Digunakan untuk menampilkan detail seleksi
     * @param type $pendonor_id
     * @param type $daftardonasi_id
     */
    public function actionDetailSeleksi($pendonor_id, $daftardonasi_id) {
        $this->layout = '//layouts/iframe';
        $model = BDSeleksipendonorT::model()->findByAttributes(array('pendonor_id' => $pendonor_id, 'daftardonasi_id' => $daftardonasi_id));
        $modKuesioner = BDSeleksikuesionerT::model()->findAllByAttributes(array('seleksidonor_id' => $model->seleksidonor_id, 'daftardonasi_id' => $daftardonasi_id));
        $modPendonor = PendonorM::model()->findByPk($pendonor_id);
        $modDaftarDonasi = DaftardonasiT::model()->findByPk($daftardonasi_id);
        $modObservasi = new ObservasipendonorT;
        $model->ruangan_id = 545; //Ruang Tranfusi Darah
        $model->tglseleksidonor = date('d M Y');

        if (isset($_GET['seleksidonor_id'])) {
            $model = BDSeleksipendonorT::model()->findByPk($_GET['seleksidonor_id']);
            $model->ruangan_id = 545; //Ruang Tranfusi Darah
        }

        if (!empty($pendonor_id)) {
            $modPendonor = PendonorM::model()->findByPk($pendonor_id);
            $modPendonor->tgllahir = MyFormatter::formatDateTimeForUser($modPendonor->tgllahir);
        }

        if (!empty($daftardonasi_id)) {
            $modDaftarDonasi = DaftardonasiT::model()->findByPk($daftardonasi_id);
        }

        /**
         * Pencarian riwayat donor sebelumnya
         */
        $modObs = ObservasipendonorT::model()->findByAttributes(array('daftardonasi_id' => $daftardonasi_id));
        if (!empty($modObs)) {
            $sql = "select * FROM (
                        select 
                        ROW_NUMBER() OVER (ORDER BY observasipendonor_id) AS nomor_urut, 
                        daftardonasi_id,
                        pendonor_id,
                        date(waktu_observasi) as waktu_observasi,
                        observasipendonor_id
                        from observasipendonor_t where pendonor_id = '" . $modPendonor->pendonor_id . "'
                        order by observasipendonor_id ASC
                    ) AS sub
                    GROUP BY nomor_urut,  daftardonasi_id, pendonor_id, waktu_observasi, observasipendonor_id
                    HAVING max(observasipendonor_id) <= '" . $modObs->observasipendonor_id . "'
                    order by observasipendonor_id ASC";
            $modObservasi = Yii::app()->db->createCommand($sql)->queryAll();

            if ($modObservasi > 1) {
                foreach ($modObservasi as $mod) {
                    $hasil = $mod['nomor_urut'] - 1;
                }
                $sql = " select * FROM (
                                select 
                                    ROW_NUMBER() OVER (ORDER BY observasipendonor_id) AS nomor_urut, 
                                    daftardonasi_id,
                                    pendonor_id,
                                    date(waktu_observasi) as waktu_observasi,
                                    observasipendonor_id
                                from observasipendonor_t where pendonor_id = '" . $modPendonor->pendonor_id . "'
                                order by observasipendonor_id ASC
                            ) AS sub
                            group by nomor_urut,  daftardonasi_id, pendonor_id, waktu_observasi, observasipendonor_id
                            having max(nomor_urut) = '" . $hasil . "'
                            order by observasipendonor_id ASC";
                $result = Yii::app()->db->createCommand($sql)->queryAll();
                foreach ($result as $item) {
                    $modPendonor->waktu_observasi = date('d M Y', strtotime($item['waktu_observasi']));
                }
            } else {
                $modPendonor->waktu_observasi = '-';
            }
        } else {
            $modPendonor->waktu_observasi = '-';
        }

        $this->render($this->path_view_detailseleksi . '/detailseleksi', array(
            'model' => $model,
            'modKuesioner' => $modKuesioner,
            'modPendonor' => $modPendonor,
            'modDaftarDonasi' => $modDaftarDonasi,
            'modObservasi' => $modObservasi
        ));
    }

    /**
     * Menampilkan detail seleksi kuesioner
     * @param type $pendonor_id
     * @param type $daftardonasi_id
     */
    public function actionSeleksiIndex($pendonor_id = null, $daftardonasi_id = null) {
        $this->layout = '//layouts/iframe';

        $model = BDSeleksipendonorT::model()->findByAttributes(array('pendonor_id' => $pendonor_id, 'daftardonasi_id' => $daftardonasi_id));
        $modKuesioner = BDSeleksikuesionerT::model()->findAllByAttributes(array('daftardonasi_id' => $daftardonasi_id));
        $modPendonor = PendonorM::model()->findByPk($pendonor_id);
        $modDaftarDonasi = DaftardonasiT::model()->findByPk($daftardonasi_id);
        $petugaskuesioner_nama = '-';
        $dpjpkuesioner_nama = '-';
        if (!empty($model->tglseleksikuesioner)) {
            $model->tglseleksikuesioner = MyFormatter::formatDateTimeForUser($model->tglseleksikuesioner);
        } else {
            $model->tglseleksikuesioner = '-';
        }
        if (!empty($model->petugaskuesioner_id)) {
            $pegawai = PegawaiM::model()->findByPk($model->petugaskuesioner_id);
            if (!empty($pegawai)) {
                $petugaskuesioner_nama = $pegawai->namaLengkap;
            }
        }
        if (!empty($model->dpjpkuesioner_id)) {
            $pegawai = PegawaiM::model()->findByPk($model->dpjpkuesioner_id);
            if (!empty($pegawai)) {
                $dpjpkuesioner_nama = $pegawai->namaLengkap;
            }
        }


        $this->render($this->path_view_detailseleksi . '/formSeleksiIndex', array(
            'model' => $model,
            'modKuesioner' => $modKuesioner,
            'modPendonor' => $modPendonor,
            'modDaftarDonasi' => $modDaftarDonasi,
            'petugaskuesioner_nama' => $petugaskuesioner_nama,
            'dpjpkuesioner_nama' => $dpjpkuesioner_nama,
        ));
    }

    /**
     * Menampilkan detail seleksi tanda vital
     * @param type $pendonor_id
     * @param type $daftardonasi_id
     */
    public function actionSeleksiTandaVitalIndex($pendonor_id = null, $daftardonasi_id = null) {
        $this->layout = '//layouts/iframe';
        if (isset($daftardonasi_id)) {
            $modSeleksi = SeleksipendonorT::model()->findByAttributes(array('daftardonasi_id' => $daftardonasi_id));
            $model = BDSeleksipendonorT::model()->findByPk($modSeleksi->seleksidonor_id);
            $modDokter = PegawaiM::model()->findByPk($model->dokter_id);
            $model->dokter_nama = isset($modDokter->nama_pegawai) ? $modDokter->nama_pegawai : '';
        } else {
            $model = new BDSeleksipendonorT;
        }
        $modKuesioner = new BDSeleksikuesionerT;
        $modPendonor = new PendonorM;
        $modDaftarDonasi = new DaftardonasiT;


        if (isset($_GET['seleksidonor_id'])) {
            $model = BDSeleksipendonorT::model()->findByPk($_GET['seleksidonor_id']);
            $model->ruangan_id = 545; //Ruang Tranfusi Darah
        }

        if (!empty($pendonor_id)) {
            $modPendonor = PendonorM::model()->findByPk($pendonor_id);
            $modPendonor->tgllahir = MyFormatter::formatDateTimeForUser($modPendonor->tgllahir);
        }

        if (!empty($daftardonasi_id)) {
            $modDaftarDonasi = DaftardonasiT::model()->findByPk($daftardonasi_id);
        }

        $model->tglseleksidonor = MyFormatter::formatDateTimeForUser($model->tglseleksidonor);

        $this->render($this->path_view_detailseleksi . '/formSeleksiTandaVitalIndex', array(
            'model' => $model,
            'modKuesioner' => $modKuesioner,
            'modPendonor' => $modPendonor,
            'modDaftarDonasi' => $modDaftarDonasi,
        ));
    }

    /**
     * Menampilkan detail seleksi kantong darah
     * @param type $daftardonasi_id
     * @param type $pendonor_id
     */
    public function actionDetailKantongDarah($daftardonasi_id, $pendonor_id) {
        $this->layout = '//layouts/iframe';
        $kantongdarah_id = array();
        $daftarDonasi = DaftardonasiT::model()->findByPk($daftardonasi_id);
        $pendonor = PendonorM::model()->findByPk($daftarDonasi->pendonor_id);
        $model = KantongdarahT::model()->findByAttributes(array('daftarpendonor_id' => $daftardonasi_id, 'pendonor_id' => $pendonor_id));
        //$model->pendonor_id = $daftarDonasi->pendonor_id;
        //$model->daftarpendonor_id = $daftardonasi_id;
        //$model->tglpencatatan = MyFormatter::formatDateTimeForUser($model->tglpencatatan);
        $models = KantongdarahT::model()->findAllByAttributes(array(
            'daftarpendonor_id' => $daftardonasi_id
        ));

        $this->render($this->path_view_detailseleksi . '/formKantongDarah', array(
            'daftarDonasi' => $daftarDonasi,
            'pendonor' => $pendonor,
            'model' => $model,
            'models' => $models,
            'kantongdarah_id' => $kantongdarah_id,
        ));
    }

    /**
     * Print barcode
     * @param integer $kantongdarah_id
     */
    public function actionPrintBarcode($kantongdarah_id) {
        $format = new MyFormatter;

        //Dicari 1 data, lalu komponennya dipisahkan dari no_kantongdarah
        //maka, akan didapatkan nomornya saja agar bisa dicari semua data no_kantongdarah yang memiliki nomor tsb
        $cekkantong = KantongdarahT::model()->findByPk($kantongdarah_id);
        $kantong = substr($cekkantong->no_kantongdarah, 2);

        $criteria = new CDbCriteria();
        $criteria->addCondition("no_kantongdarah like '%" . $kantong . "%'");
        $criteria->addCondition('(komponendarah_id = 7) OR (komponendarah_id = 8) OR (komponendarah_id = 10) OR (komponendarah_id = 15)');
        $criteria->order = 'no_kantongdarah desc';
        $modKantongDarah = KantongdarahT::model()->findAll($criteria);

        $judul_print = 'Barcode';
        //lebar, panjang
        $mpdf = new MyPDF('', array(80, 28));
        $posisi = 'P';
        $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->WriteHTML(utf8_encode(
                        $this->renderPartial($this->path_view_detailseleksi . '_printBarcodepdf', array(
                            'format' => $format,
                            'judul_print' => $judul_print,
                            'modKantongDarah' => $modKantongDarah
                                ), true)));
        $mpdf->Output("Barcode.pdf", 'I');
    }

    /**
     * untuk print barcode komponen
     * @param integer $kantongdarah_id
     * @param integer $daftarpendonor_id
     */
    public function actionPrintBarcodeKomponen($kantongdarah_id, $daftarpendonor_id = null) {
        $format = new MyFormatter;

        //Dicari 1 data, lalu komponennya dipisahkan dari no_kantongdarah
        //maka, akan didapatkan nomornya saja agar bisa dicari semua data no_kantongdarah yang memiliki nomor tsb
        $cekkantong = KantongdarahT::model()->findByPk($kantongdarah_id);
        $kantong = substr($cekkantong->no_kantongdarah, 2);

        $criteria = new CDbCriteria();
        $criteria->addCondition("no_kantongdarah like '%" . $kantong . "%'");
        if (!empty($daftarpendonor_id)) {
            $criteria->addCondition('daftarpendonor_id =' . $daftarpendonor_id);
        }
        $criteria->addCondition('(komponendarah_id = 7) OR (komponendarah_id = 9) OR (komponendarah_id = 11 OR komponendarah_id = 12) OR (komponendarah_id = 14 OR komponendarah_id = 16)');
        $criteria->order = 'no_kantongdarah desc';
        $modKantongDarah = KantongdarahT::model()->findAll($criteria);

        $judul_print = 'Barcode Komponen';
        //lebar, panjang
        $mpdf = new MyPDF('', array(80, 28));
        $posisi = 'P';
        $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->WriteHTML(utf8_encode(
                        $this->renderPartial($this->path_view_detailseleksi . '_printBarcodeKomponenpdf', array(
                            'format' => $format,
                            'judul_print' => $judul_print,
                            'modKantongDarah' => $modKantongDarah
                                ), true)));
        $mpdf->Output("Barcode.pdf", 'I');
    }

    /**
     * Detail Pendonor untuk merelasikan pendonor dan kantong darah 
     * @param type $pendonor_id
     */
    public function actionSetKantong($pendonor_id, $daftardonasi_id) {
        $this->layout = '//layouts/iframe';
        $modDaftarDonasi = DaftardonasiT::model()->findByPk($daftardonasi_id);
        $modPendonor = PendonorM::model()->findByPk($modDaftarDonasi->pendonor_id);
        if (isset($_POST['PendonorM'])) {
            // echo '<pre>';var_dump($_POST);die;
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            // $modKantong = KantongdarahT::model()->findByPk($_POST['detail']['kantongdarah_id']);
            // $modKomponen = KomponendarahM::model()->findByPk($modKantong->komponendarah_id);
            // $komponendarah = substr($modKantong->no_kantongdarah, strlen($modKomponen->singkatan_komp));
            $kantongdarah_id_arr = [];
            foreach($_POST['detail'] as $i => $data) {
                $kantongdarah_id_arr[] = $data['kantongdarah_id'];
            } 
            $cri = new CDbCriteria();
            //$cri->addCondition("no_kantongdarah LIKE '%" . $komponendarah . "%'");
            // $cri->addCondition("nomorbarcode_utama = :nomorbarcode_utama");
            $cri->params[':nomorbarcode_utama'] = $_POST['detail']['nomorbarcode'];
            $cri->addInCondition('kantongdarah_id', array_merge($kantongdarah_id_arr));
            $modKantongs = KantongdarahT::model()->findAll($cri);
            
            $obs = ObservasipendonorT::model()->findByAttributes(array('pendonor_id' =>  $modDaftarDonasi->pendonor_id, 'daftardonasi_id'=> $modDaftarDonasi->daftardonasi_id));
            // echo '<pre>';var_dump($_POST);die;
            if (!empty($modKantongs)) {
                foreach ($modKantongs as $i => $mod) {
                    $mod->pendonor_id = $_POST['PendonorM']['pendonor_id'];
                    $mod->no_kantongpabrik = $_POST['detail'][$i]['no_kantongpabrik'];
                    $mod->daftarpendonor_id = $modDaftarDonasi->daftardonasi_id;
                    if (!empty($obs)){
                        $mod->observasipendonor_id = $obs->observasipendonor_id;
                    }
                    $ok = $ok && $mod->save();
                }
               
            }
            try {
                if ($ok) {
                    if (isset($_POST['del_kantong'])){
                        $upCri = new CDbCriteria();
                        $upCri->addInCondition("nomorbarcode_utama", $_POST['del_kantong']);
                        $load = KantongdarahT::model()->findAll($upCri);
                        
                        foreach($load as $det){
                            $det->pendonor_id = null;
                            $det->daftarpendonor_id = null;
                            $det->observasipendonor_id = null;
                            $ok = $ok && $det->save();                                                        
                        }
                    }                    
                    
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('setkantong', 'pendonor_id' => $_GET['pendonor_id'], 'daftardonasi_id' => $_GET['daftardonasi_id'], 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($modKantong));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view_detailkantong . 'index', array(
            'modPendonor' => $modPendonor,
            'modDaftarDonasi' => $modDaftarDonasi
        ));
    }

    /**
     * Load kantong darah dari data yang diceklis dari dialog/autocomplete kantong darah.
     */
    public function actionAjaxKantongDarah() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        if (!isset($_POST['kantongdarah_id'])) {
            Yii::app()->end();
        }
        if (!isset($_POST['pendonor_id'])) {
            Yii::app()->end();
        }

        $str = "";
        $msg = "";

        if ($_POST['tipe'] == "auto") {
            $kantong = KantongdarahT::model()->findByPk($_POST['kantongdarah_id']);
        } else {
            $kantong = KantongdarahT::model()->findByAttributes(array('no_kantongdarah' => $_POST['kantongdarah_id']));
        }
        
        $pendonor = PendonorM::model()->findByPk($_POST['pendonor_id']);
        $komponen = KomponendarahM::model()->findByPk($kantong->komponendarah_id);
        $jenis = JeniskantongdarahM::model()->findByPk($kantong->jeniskantongdarah_id);

        $str .= $this->renderPartial($this->path_view_detailkantong . "ajaxKantongDarah", array(
            'kantong' => $kantong,
            'pendonor' => $pendonor,
            'komponen' => $komponen,
            'jenis' => $jenis,
                ), true);

        echo CJSON::encode(array(
            'html' => $str,
            'data' => $msg
        ));
    }

    /**
     * Load data kantong darah berdasarkan nomor kantong darah-nya.
     * Data yang sudah ditambahkan tidak akan ditampilkan.
     * 
     * @param string  $term No Kantong Darah yang dicari
     * @param integer $id   ID Pengecualian pada Data Kantong Darah
     */
    public function actionAutocompleteKantongDarah($term = "", $id = null) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $modKantong = new BDKantongdarahT('search');
        $modKantong->unsetAttributes();
        $modKantong->no_kantongdarah = $term;


        $prov = $modKantong->searchKantongDarahuntukPendonor();
        if (!empty($id)) {
            $id = explode(".", $id);
            if (is_array($id)) {
                $prov->criteria->addCondition('t.kantongdarah_id', $id);
            }
        }

        $res = array();
        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $komponen = KomponendarahM::model()->findByPk($item->komponendarah_id);
            $jenis = JeniskantongdarahM::model()->findByPk($item->jeniskantongdarah_id);

            $sub['label'] = $item->no_kantongdarah . " - " . $jenis->nama_jenis . " - " . $komponen->singkatan_komp;
            $sub['value'] = $item->kantongdarah_id;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }
}