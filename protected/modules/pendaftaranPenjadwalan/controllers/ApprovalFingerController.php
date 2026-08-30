<?php

class ApprovalFingerController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $septersimpan = false;
    public $updateapprove = false;
    public $deleteapprove = false;
    public $brigingapprove = true;

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionIndex($id = null) {
        $status = '';
        $model = new ARPengajuanapprovalsepT;
        $modInfoKunjungan = new InfokunjunganrjrdriV;
        $model->kode_ppk_pelayanan = Yii::app()->user->getState('ppkpelayanan');
        $model->nama_ppk_pelayanan = Yii::app()->user->getState('nama_rumahsakit');
        $model->tgl_sep = date('Y-m-d');
        $model->carabayar_id = 18;
        $model->jenisrujukan = 1;
        $model->poli_eksekutif = 0;
        $model->cob = 0;
        $model->lakalantas = 0;
        $model->carabayar_id = Params::CARABAYAR_ID_BPJS;
        $model->penjamin_id = Params::CARABAYAR_ID_BPJS;
        $model->cob_status = "TIDAK";
        $modLogin = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
        if(isset($modLogin->user_pemakai_bpjs) && !empty($modLogin->user_pemakai_bpjs)){
            $model->userpembuat_bpjs = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->user_pemakai_bpjs;
            $model->user_approval_bpjs = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->user_pemakai_bpjs;
        }else{
            $model->userpembuat_bpjs = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->nama_pemakai;
            $model->user_approval_bpjs = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->nama_pemakai;
        }
        $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->userpembuat_bpjs = $pegawai->nama_pegawai;
        $model->user_approval_bpjs =
        $pegawai->nama_pegawai;
        if (!empty($id)) {
            $model = ARPengajuanapprovalsepT::model()->findByPk($id);
            $model->lakalantas = ($model->lakalantas == false)? 0 : 1;
            $model->cob = ($model->cob == false)? 0 : 1;
            $model->poli_eksekutif = ($model->poli_eksekutif == false)? 0 : 1;
            $model->jenisrujukan = ($model->jenisrujukan == 1)? 1 : 2;
//            $modInfoKunjungan = ARInfokunjunganrsSepV::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        }

        if (isset($_POST['ARPengajuanapprovalsepT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['ARPengajuanapprovalsepT'];
                $model = $this->simpanApproval($model, $_POST['ARPengajuanapprovalsepT']);
                if ($model) {
                    if ($this->brigingapprove == false) {
                        $status = 'Data gagal disimpan karena koneksi server BPJS terputus! Silahkan hubungi admin SIMRS';
                    } else if ($this->septersimpan == false) {
                        $status = 'Data gagal disimpan karna kesalahan data / database!';
                    } else {
                        $status = 'Data Approve berhasil disimpan';
                    }
                    if ($this->septersimpan && $this->brigingapprove) {
                        $transaction->commit();
//                        Yii::app()->user->setFlash('success', $status);
                        $this->redirect(array('index', 'id' => $model->pengajuanapprovalsep_id, 'sukses' => 1));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', $status);
                    }
                }
            } catch (Exception $e) {
                var_dump($e->getMessage());die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data SEP gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'modInfoKunjungan' => $modInfoKunjungan,
        ));
    }
    
    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCreateSep($id = null) {
        $this->layout = '//layouts/iframe';
        $status = '';
        $model = new ARPengajuanapprovalsepT;
        $modInfoKunjungan = new InfokunjunganrjrdriV;
        $model->kode_ppk_pelayanan = Yii::app()->user->getState('ppkpelayanan');
        $model->nama_ppk_pelayanan = Yii::app()->user->getState('nama_ppkpelayanan');
        $model->tgl_sep = date('Y-m-d');
        $model->carabayar_id = 18;
        $model->jenisrujukan = 1;
        $model->poli_eksekutif = 0;
        $model->cob = 0;
        $model->lakalantas = 0;
        $modLogin = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
        if(isset($modLogin->user_pemakai_bpjs) && !empty($modLogin->user_pemakai_bpjs)){
            $model->userpembuat_bpjs = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->user_pemakai_bpjs;
            $model->user_approval_bpjs = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->user_pemakai_bpjs;
        }else{
            $model->userpembuat_bpjs = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->nama_pemakai;
            $model->user_approval_bpjs = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->nama_pemakai;
        }
        
        if (!empty($id)) {
            $model = ARPengajuanapprovalsepT::model()->findByPk($id);
            $model->lakalantas = ($model->lakalantas == false)? 0 : 1;
            $model->cob = ($model->cob == false)? 0 : 1;
            $model->poli_eksekutif = ($model->poli_eksekutif == false)? 0 : 1;
            $model->jenisrujukan = ($model->jenisrujukan == 1)? 1 : 2;
            $modInfoKunjungan = InfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
            if($model->cob == 1){
                $model->cob_status = "YA";
            }else{
                $model->cob_status = "TIDAK";
            }
        }

        if (isset($_POST['ARPengajuanapprovalsepT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['ARPengajuanapprovalsepT'];
                $model = $this->simpanApprovalSep($model, $_POST['ARPengajuanapprovalsepT']);
                if ($model) {
                    if ($this->brigingapprove == false) {
                        $status = 'Data gagal disimpan karena koneksi server BPJS terputus! Silahkan hubungi admin SIMRS';
                    } else if ($this->septersimpan == false) {
                        $status = 'Data gagal disimpan karna kesalahan data / database!';
                    } else {
                        $status = 'Data Approve berhasil disimpan';
                    }
                    if ($this->septersimpan && $this->brigingapprove) {
                        $transaction->commit();
//                        Yii::app()->user->setFlash('success', $status);
                        $this->redirect(array('CreateSep', 'id' => $model->pengajuanapprovalsep_id, 'sukses' => 1));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', $status);
                    }
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data SEP gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render('create_sep', array(
            'model' => $model,
            'modInfoKunjungan' => $modInfoKunjungan,
        ));
    }

    /**
     * Melihat daftar data.
     */
    // public function actionIndex() {
    //     $dataProvider = new CActiveDataProvider('ARPengajuanapprovalsepT');
    //     $this->render('index', array(
    //         'dataProvider' => $dataProvider,
    //     ));
    // }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new ARPengajuanapprovalsepT;
        $model->unsetAttributes();  // clear any default values
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        if (isset($_GET['ARPengajuanapprovalsepT'])) {
            $model->attributes = $_GET['ARPengajuanapprovalsepT'];
            $model->tgl_awal = isset($_GET['ARPengajuanapprovalsepT']['tgl_awal']) ? MyFormatter::formatDateTimeForDb($_GET['ARPengajuanapprovalsepT']['tgl_awal']) : null;
            $model->tgl_akhir = isset($_GET['ARPengajuanapprovalsepT']['tgl_akhir']) ? MyFormatter::formatDateTimeForDb($_GET['ARPengajuanapprovalsepT']['tgl_akhir']) : null;
            $model->no_pendaftaran = $_GET['ARPengajuanapprovalsepT']['no_pendaftaran'];
            $model->no_kartu_bpjs = $_GET['ARPengajuanapprovalsepT']['no_kartu_bpjs'];
        }
        $this->render('admin_new', array(
            'model' => $model,
        ));
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = ARPengajuanapprovalsepT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'assep-t-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new ARPengajuanapprovalsepT;
        $model->attributes = $_REQUEST['ARPengajuanapprovalsepT'];
        $model->tgl_awal = $_REQUEST['ARPengajuanapprovalsepT']['tgl_awal'];
        $model->tgl_akhir = $_REQUEST['ARPengajuanapprovalsepT']['tgl_akhir'];
        $judulLaporan = 'Data Approve';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    /**
     * set bpjs Interface
     */
    public function actionBpjsInterface() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (empty($_GET['param']) OR $_GET['param'] === '') {
                die('param can\'not empty value');
            } else {
                $param = $_GET['param'];
            }
            $jenis_rujukan = isset($_GET['jenis_rujukan'])? $_GET['jenis_rujukan'] : 1;

            $bpjs = new BpjsVklaim();

            switch ($param) {
                case '1':
                    $query = $_GET['query'];
                    $query2 = $_GET['query2'];
                    print_r($bpjs->search_kartu($query, $query2));
                    break;
                case '2':
                    $query = $_GET['query'];
                    print_r($bpjs->search_nik($query));
                    break;
                case '3':
                    $query = $_GET['query'];
                    if($jenis_rujukan==1){
                        print_r($bpjs->search_rujukan_no_rujukan($query));
                    }else{
                        print_r($bpjs->search_rujukan_no_rujukan_rs($query));
                    }
                    break;
                case '4':
                    $query = $_GET['query'];
                    print_r($bpjs->search_rujukan_no_bpjs($query));
                    break;
                case '13':
//                    $format = new CustomFormat();
                    // var_dump($_GET); die;

                    $noKartu = $_GET['noKartu'];
                    $tglSep = date('Y-m-d', strtotime($_GET['tglSep']));
                    $jnsPelayanan = $_GET['jnsPelayanan'];
                    $jnsPengajuan = $_GET['jnsPengajuan'];
                    $catatan = $_GET['catatan'];
                    $user = $_GET['user'];
                    $peg_user = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                    if (isset($peg_user)) {
                        $user = $peg_user->nama_pegawai;
                    }
                    $pendaftaran_id = isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null;
                    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

                    $reqApproval = CJSON::decode($bpjs->pengajuan_approval2($noKartu, $tglSep, $jnsPelayanan, $jnsPengajuan, $catatan, $user));

                    // $transaction = Yii::app()->db->beginTransaction();
                    $this->logBpjs($modPendaftaran, $reqApproval, $bpjs->server_new['pengajuan_approval']);
                    // $transaction->commit();
                    
                    /*
                    $noMR = $_GET['noMR'];
                    $ppkPelayanan = $_GET['ppkPelayanan'];
                    $klsRawat = $_GET['klsRawat'];
                    $asalRujukan = $_GET['asalRujukan'];
                    $tglRujukan = date('Y-m-d', strtotime($_GET['tglRujukan']));
                    $noRujukan = $_GET['noRujukan'];
                    $ppkRujukan = $_GET['ppkRujukan'];
                    $diagAwal = $_GET['diagAwal'];
                    $tujuan = $_GET['tujuan'];
                    $eksekutif = $_GET['eksekutif'];
                    $cob = $_GET['cob'];
                    $lakaLantas = $_GET['lakaLantas'];
                    $penjamin = $_GET['penjamin'];
                    $lokasiLaka = $_GET['lokasiLaka'];
                    $noTelp = $_GET['noTelp'];
                    */
                    
                    // print_r($bpjs->pengajuan_approval2($noKartu,$tglSep,$jnsPelayanan,$jnsPengajuan,$catatan,$user));
                    print_r(CJSON::encode($reqApproval));
                    
                    break;
                case '14':
//                    $format = new CustomFormat();
                    $noKartu = $_GET['noKartu'];
                    $tglSep = date('Y-m-d', strtotime($_GET['tglSep']));
                    $jnsPelayanan = $_GET['jnsPelayanan'];
                    $catatan = $_GET['catatan'];
                    $user = $_GET['user'];
                    
                    print_r($bpjs->approval_sep($noKartu,$tglSep,$jnsPelayanan,$catatan,$user));
                    break;
                case '15':
//                    $format = new CustomFormat();
                    $noMR = $_GET['noMR'];
                    $noKartu = $_GET['noKartu'];
                    $tglSep = date('Y-m-d', strtotime($_GET['tglSep']));
                    $ppkPelayanan = $_GET['ppkPelayanan'];
                    $jnsPelayanan = $_GET['jnsPelayanan'];
                    $klsRawat = $_GET['klsRawat'];
                    $asalRujukan = $_GET['asalRujukan'];
                    $tglRujukan = date('Y-m-d', strtotime($_GET['tglRujukan']));
                    $noRujukan = $_GET['noRujukan'];
                    $ppkRujukan = $_GET['ppkRujukan'];
                    $catatan = $_GET['catatan'];
                    $diagAwal = $_GET['diagAwal'];
                    $tujuan = $_GET['tujuan'];
                    $eksekutif = $_GET['eksekutif'];
                    $cob = $_GET['cob'];
                    $lakaLantas = $_GET['lakaLantas'];
                    $penjamin = $_GET['penjamin'];
                    $lokasiLaka = $_GET['lokasiLaka'];
                    $noTelp = $_GET['noTelp'];
                    $user = $_GET['user'];
                    
                    print_r($bpjs->create_sep_new($noKartu,$tglSep,$ppkPelayanan,$jnsPelayanan,$klsRawat,$noMR,$asalRujukan,$tglRujukan,$noRujukan,$ppkRujukan,$catatan,$diagAwal,$tujuan,$eksekutif,$cob,$lakaLantas,$penjamin,$lokasiLaka,$noTelp,$user));
                    break;
                case '100':
                    print_r($bpjs->help());
                    break;
                default:
                    die('error number, please check your parameter option');
                    break;
            }
            Yii::app()->end();
        }
    }

    public function simpanApproval($model, $postApp) {
        
        $model->attributes = $postApp;
        $model->tgl_sep = date('Y-m-d H:i:s', strtotime($model->tgl_sep));
        $model->pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
        $model->jenis_pelayanan = $postApp['jenis_pelayanan'];
        
        $model->namapeserta_bpjs = $postApp['namapeserta_bpjs'];
        $model->jenispeserta_bpjs_kode = $postApp['jenispeserta_bpjs_kode'];
        $model->jenispeserta_bpjs_nama = $postApp['jenispeserta_bpjs_nama'];
        $model->jenis_pelayanan = $postApp['jenis_pelayanan'];
        $model->diagnosa_awal_nama = $postApp['diagnosa_awal_nama'];
        //$model->politujuan = $postApp['politujuan'];
        //$model->politujuan_nama = $postApp['politujuan_nama'];
        $model->hakkelas_kode = $postApp['hakkelas_kode'];
        $model->lokasilakalantas = isset($postApp['lokasilakalantas'])? $postApp['lokasilakalantas'] : null;
        $model->penjamin = isset($postApp['penjamin'])? $postApp['penjamin'] : null;
        //$model->asal_rujukan = ($postApp['jenisrujukan']==1)? "PCare" : "Rumah Sakit";
        $model->tgl_rujukan = null;
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->nama_ppk_pelayanan = (empty($postApp['nama_ppk_pelayanan']))? Yii::app()->user->getState('nama_rumahsakit') : $postApp['nama_ppk_pelayanan'];
        $model->tanggal_pengajuan = date('Y-m-d');
        

        //  var_dump($model->attributes, $model->validate()); die;
        if ($model->save()) {
            $this->septersimpan = true;
        } else {
            $this->septersimpan = false;
        }

        return $model;
    }
    
    public function simpanApprovalSep($model, $postApp) {

        $model->attributes = $postApp;
        $model->jenis_pelayanan = $postApp['jenis_pelayanan'];
        
        $model->jenis_pelayanan = $postApp['jenis_pelayanan'];
        $model->diagnosa_awal_nama = $postApp['diagnosa_awal_nama'];
        $model->politujuan = $postApp['politujuan'];
        $model->politujuan_nama = $postApp['politujuan_nama'];
        $model->lokasilakalantas = isset($postApp['lokasilakalantas'])? $postApp['lokasilakalantas'] : null;
        $model->penjamin = isset($postApp['penjamin'])? $postApp['penjamin'] : null;
        $model->asal_rujukan = ($postApp['jenisrujukan']==1)? "PCare" : "Rumah Sakit";
        
        $modSep = new ARSepT;
        $modSep->attributes = $model;
        $modSep->jenisrujukan_kode = $postApp['jenisrujukan'];
        $modSep->jenisrujukan_nama = $model->asal_rujukan;
        $modSep->tglsep = $model->tgl_sep;
        $modSep->nosep = $postApp['no_sep'];
        $modSep->nokartuasuransi = $model->no_kartu_bpjs;
        $modSep->tglrujukan = $model->tgl_rujukan;
        $modSep->norujukan = $model->no_rujukan;
        $modSep->norujukan = $model->no_rujukan;
        $modSep->ppkrujukan = $model->kode_ppk_rujukan;
        $modSep->ppkpelayanan = $model->kode_ppk_pelayanan;
        $modSep->jnspelayanan = $model->jenis_pelayanan;
        $modSep->catatansep = $model->catatan;
        $modSep->diagnosaawal = $model->diagnosa_awal;
        $modSep->politujuan = $model->politujuan;
        $modSep->klsrawat = $model->kelas_tanggungan;
        $modSep->hakkelas_kode = $model->hakkelas_kode;
        $modSep->lakalantas = $model->lakalantas;
        $modSep->penjamin_lakalantas = $model->penjamin;
        $modSep->lokasi_lakalantas = $model->lokasilakalantas;
        $modSep->no_telpon_peserta = $model->no_telepon_pasien;
        $modSep->poli_eksekutif = $model->poli_eksekutif;
        $modSep->cob = $model->cob;
        $modSep->nama_diagnosaawal = $model->diagnosa_awal_nama;
        $modSep->namaasuransi_cob = $model->namaasuransi_cob;
        $modSep->no_asuransi_cob = $model->no_asuransi_cob;
        $modSep->create_time = date('Y-m-d H:i:s');
        $modSep->create_loginpemakai_id = Yii::app()->user->id;
        $modSep->create_ruangan = Yii::app()->user->getState('ruangan_id');
        var_dump($modSep->tgl_rujukan);
        if ($modSep->save()) {
            
            $model->sep_id = $modSep->sep_id;
            $model->save();
            
            $modPasien = ARPasienM::model()->findByPk($_POST['pasien_id']);
            if (isset($modPasien)) {
                $pasien_id = $modPasien->pasien_id;
                $modPendaftaran = ARPendaftaranT::model()->findByPk($model->pendaftaran_id);

                if(!empty($modPendaftaran->asuransipasien_id)){
                    $modAsuransiPasien = ARAsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
                    $modAsuransiPasien->pasien_id = $modPasien->pasien_id;
                    $modAsuransiPasien->jenispeserta_id = $model->jenispeserta_bpjs_kode;
                    $modAsuransiPasien->nokartuasuransi = $model->no_kartu_bpjs;
                    $modAsuransiPasien->nopeserta = $model->no_kartu_bpjs;
                    $modAsuransiPasien->namapemilikasuransi = $model->namapeserta_bpjs;
                    $modAsuransiPasien->tglcetakkartuasuransi = date('Y-m-d H:i:s');
                    $modAsuransiPasien->kelastanggunganasuransi_id = $model->kelas_tanggungan;
                    $modAsuransiPasien->kodefeskestk1 = $model->kode_ppk_pelayanan;
                    $modAsuransiPasien->nama_feskestk1 = $model->nama_ppk_pelayanan;
                    $modAsuransiPasien->carabayar_id = Params::CARABAYAR_ID_BPJS;
                    $modAsuransiPasien->penjamin_id = Params::CARABAYAR_ID_BPJS;
                    $modAsuransiPasien->update_time = date('Y-m-d H:i:s');
                    $modAsuransiPasien->update_loginpemakai_id = Yii::app()->user->id;
                    $modAsuransiPasien->save();
                }else{
                    $modAsuransiPasien = new ARAsuransipasienM;
                    $modAsuransiPasien->pasien_id = $modPasien->pasien_id;
                    $modAsuransiPasien->jenispeserta_id = $model->jenispeserta_bpjs_kode;
                    $modAsuransiPasien->nokartuasuransi = $model->no_kartu_bpjs;
                    $modAsuransiPasien->nopeserta = $model->no_kartu_bpjs;
                    $modAsuransiPasien->namapemilikasuransi = $model->namapeserta_bpjs;
                    $modAsuransiPasien->tglcetakkartuasuransi = date('Y-m-d H:i:s');
                    $modAsuransiPasien->kelastanggunganasuransi_id = $model->kelas_tanggungan;
                    $modAsuransiPasien->kodefeskestk1 = $model->kode_ppk_pelayanan;
                    $modAsuransiPasien->nama_feskestk1 = $model->nama_ppk_pelayanan;
                    $modAsuransiPasien->carabayar_id = Params::CARABAYAR_ID_BPJS;
                    $modAsuransiPasien->penjamin_id = Params::CARABAYAR_ID_BPJS;
                    $modAsuransiPasien->create_time = date('Y-m-d H:i:s');
                    $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
                    $modAsuransiPasien->save();
                }
                
                $modPendaftaran->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
                $modPendaftaran->sep_id = $model->sep_id;
                $modPendaftaran->update();
            }
            
            $this->septersimpan = true;
        } else {
            $this->septersimpan = false;
        }

        return $model;
    }

    /**
     * untuk menampilkan pasien lama dari autocomplete
     * 1. no_rekam_medik
     */
    public function actionAutocompletePasien() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->addCondition('ispasienluar = FALSE');
            $criteria->order = 'no_rekam_medik, nama_pasien';
            $criteria->limit = 50;
            $models = PasienM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . (!empty($model->nama_ayah) ? $model->nama_ayah : "(nama ayah tidak ada)") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
                $returnVal[$i]['value'] = $model->no_rekam_medik;
            }
            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    /**
     * @param type $sep_id
     */
    public function actionPrintSep($sep_id) {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modRujukanBpjs = new ARRujukanbpjsT;
        $modSep = ARSepT::model()->findByPk($sep_id);
        $modAsuransiPasienBpjs = ARAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta' => $modSep->nokartuasuransi));
        $modJenisPeserta = ARJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
        if (isset($modSep->norujukan)) {
            $modRujukanBpjs = ARRujukanbpjsT::model()->findByAttributes(array('no_rujukan' => $modSep->norujukan));
        }
        $modPendaftaran = ARPendaftaranT::model()->findByAttributes(array('sep_id' => $modSep->sep_id));
        $modPasien = ARPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $judul_print = 'SURAT ELIGIBILITAS PESERTA';
//        $this->render('printSep', array(
//            'format' => $format,
//            'modSep' => $modSep,
//            'judul_print' => $judul_print,
//            'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
//            'modRujukanBpjs' => $modRujukanBpjs,
//            'modPendaftaran' => $modPendaftaran,
//            'modPasien' => $modPasien,
//            'modJenisPeserta' => $modJenisPeserta,
//        ));
		ob_clean();
		$posisi ='P'; //Posisi L->Landscape,P->Portait
		$mpdf = new MyPDF('',array(215,93));    
		$mpdf->mirrorMargins = 2;
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
		$mpdf->WriteHTML($stylesheet, 1);
		$mpdf->AddPage($posisi,'','','','',0,0,0,0,0,0);
		$mpdf->WriteHTML(
			$this->renderPartial('printSep', array(
			'format' => $format,
            'modSep' => $modSep,
            'judul_print' => $judul_print,
            'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
            'modRujukanBpjs' => $modRujukanBpjs,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modJenisPeserta' => $modJenisPeserta,
			),true)
		);
		$mpdf->SetJS('this.print();');
		$mpdf->Output();
    }

    /**
     * Ubah Tanggal Pulang
     */
    public function actionApprove($id) {
        $this->layout = '//layouts/iframe';
        $model = ARPengajuanapprovalsepT::model()->findByPk($id);
        $modInfoKunjungan = PendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id));
        if(!empty($modInfoKunjungan)) {
            $modPasien = PasienM::model()->findByPk($modInfoKunjungan->pasien_id);
        } else {
            $modPasien = new PasienM();
        }
        $bpjs = new BpjsVklaim();
        $status = '';

        // $bpjs = new BpjsVklaim();
        // $transaction = Yii::app()->db->beginTransaction();
        // $reqSep = json_decode($bpjs->delete_transaksi_sep($model->no_sep, $nama), true);
        // if ($reqSep['metaData']['code'] == 200) {
        //     $this->brigingapprove = true;
        //     PendaftaranT::model()->updateAll(array('sep_id' => null), 'sep_id = ' . $model->sep_id);
        //     ARRujukankeluarBpjsT::model()->model()->deleteAll('sep_id='.$model->sep_id.''); 
        //     if ($model->delete()) {
        //         $this->deleteapprove = true;
        //         $transaction->commit();
        //     }
        // } else {
        //     $this->brigingapprove = false;
        //     $transaction->rollback();
        // }


        if (isset($_POST['ARPengajuanapprovalsepT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $jnspengajuan_approvalsep = $_POST['ARPengajuanapprovalsepT']['jnspengajuan_approvalsep'];
                $tglsep = date('Y-m-d',strtotime((String)MyFormatter::formatDateTimeForDb($model->tgl_sep)));
                $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                $rumahsakit = ProfilrumahsakitM::model()->find();
                $pegawai_nama = (!empty($pegawai)?$pegawai->nama_pegawai : (!empty($rumahsakit->nama_rumahsakit) ? $rumahsakit->nama_rumahsakit : "RS"));
                $model->is_approval = TRUE;
                $reqSep = CJSON::decode($bpjs->approvalnew_sep($model->no_kartu_bpjs, $tglsep, $model->jenis_pelayanan, $jnspengajuan_approvalsep, $model->catatan, $pegawai_nama), true);

                $suksesBridging = true;
                $pesan = "";
                if ($reqSep['metaData']['code'] == 200) {
                    $suksesBridging = true;
                    $this->logBpjs($modInfoKunjungan, $reqSep, $bpjs->server_new['approval_sep'] );
                } else {
                    $suksesBridging = false;
                    $pesan = $reqSep['metaData']['message'];
                    $this->logBpjs($modInfoKunjungan, $reqSep, $bpjs->server_new['approval_sep']);
                }

                if($model->save() && $suksesBridging == true){
                    $transaction->commit();
                    $this->redirect(array('Approve', 'id' => $id, 'sukses' => 1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Gagal disimpan ".$pesan);
                    $this->logBpjs($modInfoKunjungan, $reqSep, $bpjs->server_new['approval_sep']);
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
            }
        }

        $this->render('_approve', array(
            'model' => $model,
            'modInfoKunjungan' => $modInfoKunjungan,
            'modPasien' => $modPasien
        ));
    }

    function logBpjs($model, $reqSep, $api = null)
    {
       
        $log = new BpjslogR;
        $log->tgl_log = date('Y-m-d H:i:s');
        $log->code = $reqSep['metaData']['code'];
        $log->loginpemakai_id = Yii::app()->user->id;
        if (isset($reqSep['metaData']['message'])) {
            $log->pesan = $reqSep['metaData']['message'];
        }
        if (!empty($reqSep['request_vars'])) {
            $log->json_request_respose = $reqSep['request_vars'];
        }
        $log->pendaftaran_id = $model->pendaftaran_id ?? null;
        $request = Yii::app()->request;
        $ipAddress = $request->getUserHostAddress();
        $log->ip_address = $ipAddress;
        $log->api = $api;
        $log->save();
    }

    /**
     * Menghapus data SEP
     */
    public function actionHapusSEP($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $data['status'] = '';
            $model = $this->loadModel($id);
            $modUser = LoginpemakaiK::model()->findByPk($model->create_loginpemakai_id);
            $nama = (isset($modUser->user_pemakai_bpjs)&&!empty($modUser->user_pemakai_bpjs))? $modUser->user_pemakai_bpjs : $modUser->nama_pemakai ;
            $bpjs = new BpjsVklaim();
            $transaction = Yii::app()->db->beginTransaction();
            $reqSep = json_decode($bpjs->delete_transaksi_sep($model->no_sep, $nama), true);
            if ($reqSep['metaData']['code'] == 200) {
                $this->brigingapprove = true;
                PendaftaranT::model()->updateAll(array('sep_id' => null), 'sep_id = ' . $model->sep_id);
                ARRujukankeluarBpjsT::model()->model()->deleteAll('sep_id='.$model->sep_id.''); 
                if ($model->delete()) {
                    $this->deleteapprove = true;
                    $transaction->commit();
                }
            } else {
                $this->brigingapprove = false;
                $transaction->rollback();
            }

            if ($this->brigingapprove == false) {
                $data['status'] = 'Data gagal dihapus karena '.$reqSep['metaData']['message'];
            } else {
                $data['status'] = 'Data SEP berhasil dihapus';
            }

            echo CJSON::encode($data);
        }
    }

    /**
     * Mengurai data pasien berdasarkan:
     * - instalasi_id
     * - pendaftaran_id
     * - pasienadmisi_id
     * - no_pendaftaran
     * - no_rekam_medik
     * @throws CHttpException
     */
    public function actionGetDataInfoPasien() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
            $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $returnVal = array();
            $criteria = new CDbCriteria();
            if (!empty($pendaftaran_id)) {
                $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
            }
            if (!empty($pasienadmisi_id) && $pasienadmisi_id !== 'null') {
                $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
            }
            $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
            $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
            if ($instalasi_id == Params::INSTALASI_ID_RD) {
                $model = InfokunjunganrdV::model()->find($criteria);
            } else if ($instalasi_id == Params::INSTALASI_ID_RJ) {
                $model = InfokunjunganrjV::model()->find($criteria);
            } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
                $model = InfokunjunganriV::model()->find($criteria);
            }
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            $returnVal["no_kartu"] = "";

            $asu = AsuransipasienM::model()->findByAttributes(array(
                'pasien_id'=>$model->pasien_id,
                'penjamin_id'=>70,
            ));
            if (!empty($asu)) {
                $returnVal["no_kartu"] = $asu->nokartuasuransi;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    public function actionAutocompleteInfoPasien() {
        if(Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $instalasi_id = isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : null;
            $pendaftaran_id = isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null;
            $pasienadmisi_id = isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null;
            $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
            $criteria = new CDbCriteria();
            if(!empty($instalasi_id)){
                $criteria->addCondition('instalasi_id = '.$instalasi_id);
            }
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->limit = 5;
            $models = ARInfokunjunganrsSepV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {                    
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pendaftaran.' - '.$model->nama_pasien;
                $returnVal[$i]['value'] = $model->no_pendaftaran;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    public function actionSetFormPoli() {
        if (Yii::app()->request->isAjaxRequest) {
            $poliList = $_POST['poliList'];
            $form = '';
            $pesan = '';
            if (count((array)$poliList) > 0) {
                foreach ($poliList AS $i => $poli) {
                    $kdPoli = $poli['kode'];
                    $nmPoli = $poli['nama'];
                    $form .= 
                    "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\"$('#ARPengajuanapprovalsepT_politujuan').val('".$kdPoli."');$('#ARPengajuanapprovalsepT_politujuan_nama').val('".$nmPoli."');$('#dialogPoli').dialog('close'); \">
                            <i class='icon-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli' name=[ii][kdPoli]'>".$kdPoli."</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][nmPoli]'>".$nmPoli."</span>
                        </td>
                    </tr>";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }
    
    public function actionsetFormDiagnosa() {
        if (Yii::app()->request->isAjaxRequest) {
            $diagnosaList = $_POST['diagnosaList'];
            $form = '';
            $pesan = '';
            if (count((array)$diagnosaList) > 0) {
                foreach ($diagnosaList AS $i => $diagnosa) {
                    $kddiagnosa = $diagnosa['kode'];
                    $nmdiagnosa = $diagnosa['nama'];
                    $form .= 
                    "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\"$('#ARPengajuanapprovalsepT_diagnosa_awal').val('".$kddiagnosa."');$('#ARPengajuanapprovalsepT_diagnosa_awal_nama').val('".$nmdiagnosa."');$('#dialogDiagnosaBpjs').dialog('close'); \">
                            <i class='icon-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli' name=[ii][kdPoli]'>".$kddiagnosa."</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][nmPoli]'>".$nmdiagnosa."</span>
                        </td>
                    </tr>";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }
    
    public function actionsetFormFaskes() {
        if (Yii::app()->request->isAjaxRequest) {
            $faskesList = $_POST['faskesList'];
            $form = '';
            $pesan = '';
            if (count((array)$faskesList) > 0) {
                foreach ($faskesList AS $i => $faskes) {
                    $kdfaskes = $faskes['kode'];
                    $nmfaskes = $faskes['nama'];
                    $form .= 
                    "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" $('#ARPengajuanapprovalsepT_kode_ppk_rujukan').val('".$kdfaskes."');$('#ARPengajuanapprovalsepT_nama_ppk_rujukan').val('".$nmfaskes."');$('#dialogPpk').dialog('close'); \">
                            <i class='icon-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli' name=[ii][kdPoli]'>".$kdfaskes."</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][nmPoli]'>".$nmfaskes."</span>
                        </td>
                    </tr>";
                }
            } else {
                $pesan = "Data tidak ada!";
            }

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }
    
    public function actionUpdateSEP($sep_id){
        $this->layout = '//layouts/frameDialog';
        $model = ARSepT::model()->findByPk($sep_id);
        $modInfoKunjungan = ARInfokunjunganrsSepV::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        $model->ppkpelayanan = Yii::app()->user->getState('kode_ppk_bpjs');
        $model->ppkpelayanan_nama = Yii::app()->user->getState('nama_ppk_pelayanan');
        $modLogin = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
        if(isset($modLogin->user_pemakai_bpjs) && !empty($modLogin->user_pemakai_bpjs)){
            $model->pembuat_sep = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->user_pemakai_bpjs;
        }else{
            $model->pembuat_sep = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->nama_pemakai;
        }
        
        if(isset($_POST['ARSepT'])){
            
            $model->attributes = $_POST['ARSepT'];
            
            $model->update_time = date('Y-m-d H:i:s');
            $model->upate_loginpemakai_id = Yii::app()->user->id;
            $model->update();
                        
            if($model->update()){
                $this->redirect(array('UpdateSEP', 'sep_id' => $sep_id,'sukses' => 1));
            }else{
                Yii::app()->user->setFlash('error', "SEP gagal disimpan");
            }
        }
        
        $this->render('_formUpdate', array(
            'model' => $model,
            'modInfoKunjungan' => $modInfoKunjungan,
            
        ));
    }
    
    public function actionUpdateTglPulang($sep_id){
        $this->layout = '//layouts/frameDialog';
        $model = ARSepT::model()->findByPk($sep_id);
        $modInfoKunjungan = ARInfokunjunganrsSepV::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        $model->ppkpelayanan = Yii::app()->user->getState('kode_ppk_bpjs');
        $model->ppkpelayanan_nama = Yii::app()->user->getState('nama_ppk_pelayanan');
        $modLogin = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
        if(isset($modLogin->user_pemakai_bpjs) && !empty($modLogin->user_pemakai_bpjs)){
            $model->pembuat_sep = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->user_pemakai_bpjs;
        }else{
            $model->pembuat_sep = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->nama_pemakai;
        }
        
        if(isset($_POST['ARSepT'])){
            
            $model->attributes = $_POST['ARSepT'];
            $model->tanggalpulang_sep = $_POST['ARSepT']['tanggalpulang_sep'];
            $model->update_time = date('Y-m-d H:i:s');
            $model->upate_loginpemakai_id = Yii::app()->user->id;
            if($model->update()){
                $this->redirect(array('UpdateTglPulang', 'sep_id' => $sep_id, 'sukses' => 1));
            }else{
                Yii::app()->user->setFlash('error', "SEP gagal disimpan");
            }
        }
        
        $this->render('_formUpdatePulang', array(
            'model' => $model,
            'modInfoKunjungan' => $modInfoKunjungan,
        ));
    }
    
}
