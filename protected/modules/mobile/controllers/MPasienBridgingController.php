<?php
/**
 * class ini digunakan untuk bridging mobile apps dengan sistem utama
 */
ini_set('memory_limit', '128M');
class MPasienBridgingController extends MyMobileAuthController
{
    public $defaultAction = "Index";
    public $layout = "//layouts/iframe";

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionGetNoPendaftaran(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['pasien_id'])){
            $sql = "SELECT pendaftaran_t.pendaftaran_id,
                    no_pendaftaran,statusperiksa,
                    (CASE WHEN pendaftaran_t.pasienadmisi_id IS NOT NULL THEN ruanganadmisi_m.ruangan_nama ELSE ruangan_m.ruangan_nama END) AS ruangan_nama,
                    instalasi_nama, TO_CHAR(tgl_pendaftaran,'d Mon YYYY HH24:MI') AS tgl_pendaftaran,
                    pendaftaran_t.pasienpulang_id,kelaspelayanan_nama,carabayar_nama 
                    FROM pendaftaran_t 
                    LEFT JOIN pasienadmisi_t ON pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id
                    LEFT JOIN ruangan_m ruanganadmisi_m ON ruanganadmisi_m.ruangan_id = pasienadmisi_t.ruangan_id
                    JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id 
                    JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
                    JOIN kelaspelayanan_m ON pendaftaran_t.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
                    JOIN carabayar_m ON pendaftaran_t.carabayar_id = carabayar_m.carabayar_id
                    WHERE pendaftaran_t.pasien_id = ".$_GET['pasien_id']." 
                    AND pendaftaran_t.pasienbatalperiksa_id IS NULL 
                    ORDER BY pendaftaran_t.pendaftaran_id DESC ";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if(!empty($loadDatas)){
                foreach($loadDatas AS $i => $val){
                    $data[$i] = $val;
                }
            }     
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackNoPendaftaran(".$encode.")";
        Yii::app()->end();
    } 
//    ..pendaftaran hd
    public function actionGetNoPendaftaranHD(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['pasien_id'])){
            $sql = "SELECT pendaftaran_t.pendaftaran_id,
                    no_pendaftaran,statusperiksa,
                    (CASE WHEN pendaftaran_t.pasienadmisi_id IS NOT NULL THEN ruanganadmisi_m.ruangan_nama ELSE ruangan_m.ruangan_nama END) AS ruangan_nama,
                    instalasi_nama, TO_CHAR(tgl_pendaftaran,'d Mon YYYY HH24:MI') AS tgl_pendaftaran,
                    pendaftaran_t.pasienpulang_id,kelaspelayanan_nama,carabayar_nama FROM 
                    pendaftaran_t 
                    LEFT JOIN pasienadmisi_t ON pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id
                    LEFT JOIN ruangan_m ruanganadmisi_m ON ruanganadmisi_m.ruangan_id = pasienadmisi_t.ruangan_id
                    JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id 
                    JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
                    JOIN kelaspelayanan_m ON pendaftaran_t.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
                    JOIN carabayar_m ON pendaftaran_t.carabayar_id = carabayar_m.carabayar_id
                    WHERE pendaftaran_t.instalasi_id = 45 and pendaftaran_t.pasien_id = ".$_GET['pasien_id']." 
                    AND pendaftaran_t.pasienbatalperiksa_id IS NULL 
                    ORDER BY tgl_pendaftaran DESC";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            $data = $loadDatas;     
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackNoPendaftaranHD(".$encode.")";
        Yii::app()->end();
    }

    /**
     * menampilkan riwayat kunjungan pasien
     * Issue: MA-4
     * @param : $_GET['pasien_id']
     * @return json array
     */
    public function actionGetRiwayatKunjunganPasien()
    {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['pasien_id'])){
            $pasien_id = $_GET['pasien_id'];            
            $sql = "SELECT pasien_m.no_rekam_medik, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.tempat_lahir, pasien_m.tanggal_lahir,pendaftaran_t.pendaftaran_id, pasien_m.jeniskelamin, pasien_m.no_mobile_pasien, pasien_m.statusperkawinan, pasien_m.alamat_pasien,pasien_m.photopasien,pasien_m.alamatemail,pendaftaran_t.statusperiksa,pasien_m.no_telepon_pasien,pasien_m.photopasien,pekerjaan_m.pekerjaan_nama,pendaftaran_t.no_pendaftaran,ruangan_m.ruangan_nama,instalasi_m.instalasi_nama, pendaftaran_t.kelaspelayanan_id,
                    pendaftaran_t.tgl_pendaftaran, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, pegawai_m.gelardepan AS gelardepan_dokter, pegawai_m.nama_pegawai AS nama_dokter,
                    pasienmasukpenunjang_t.pasienmasukpenunjang_id, pasienmasukpenunjang_t.tglmasukpenunjang, ruanganpenunjang_m.ruangan_id AS ruanganpenunjang_id, ruanganpenunjang_m.ruangan_nama AS ruanganpenunjang_nama,  pasienadmisi_t.pasienadmisi_id, pasienadmisi_t.tgladmisi, ruanganadmisi_m.ruangan_id AS ruanganadmisi_id, ruanganadmisi_m.ruangan_nama AS ruanganadmisi_nama, dokteradmisi_m.gelardepan AS gelardepan_dokteradmisi, dokteradmisi_m.nama_pegawai AS nama_dokteradmisi, dokterpenunjang_m.gelardepan AS gelardepan_dokterpenunjang, dokterpenunjang_m.nama_pegawai AS nama_dokterpenunjang
                    FROM pendaftaran_t
                    JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id
                    JOIN loginpemakai_k ON pasien_m.pasien_id = loginpemakai_k.pasien_id
                    LEFT JOIN pekerjaan_m ON pekerjaan_m.pekerjaan_id = pasien_m.pekerjaan_id
                    LEFT JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
                    LEFT JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = pendaftaran_t.pasienadmisi_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                    JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id
                    LEFT JOIN ruangan_m ruanganpenunjang_m ON ruanganpenunjang_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
                    LEFT JOIN ruangan_m ruanganadmisi_m ON ruanganadmisi_m.ruangan_id = pasienadmisi_t.ruangan_id
                    JOIN pegawai_m ON pegawai_m.pegawai_id = pendaftaran_t.pegawai_id
                    LEFT JOIN pegawai_m dokterpenunjang_m ON dokterpenunjang_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
                    LEFT JOIN pegawai_m dokteradmisi_m ON dokteradmisi_m.pegawai_id = pasienadmisi_t.pegawai_id
                    WHERE pendaftaran_t.pasien_id = ".$pasien_id."
                    ORDER BY pasienmasukpenunjang_t.tglmasukpenunjang DESC, pendaftaran_t.tgl_pendaftaran DESC, pasienadmisi_t.tgladmisi DESC
                    LIMIT 3";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();

            if(count($loadDatas) > 0){
                //echo "a";exit;
                $data['nama_pasien'] = $loadDatas[0]['namadepan']." ".$loadDatas[0]['nama_pasien'];
                $data['no_rekam_medik'] = $loadDatas[0]['no_rekam_medik'];
                $data['tempat_lahir'] = $loadDatas[0]['tempat_lahir'];
                $data['tanggal_lahir'] = $format->formatDateTimeId($loadDatas[0]['tanggal_lahir']);
                $data['jeniskelamin'] = $loadDatas[0]['jeniskelamin'];
                $data['pekerjaan_nama'] = $loadDatas[0]['pekerjaan_nama'];
                $data['statusperkawinan'] = $loadDatas[0]['statusperkawinan'];
                $data['alamat_pasien'] = $loadDatas[0]['alamat_pasien'];
                $data['no_telepon_pasien'] = $loadDatas[0]['no_telepon_pasien'];
                $data['no_mobile_pasien'] = $loadDatas[0]['no_mobile_pasien'];
                $data['photopasien'] = $loadDatas[0]['photopasien'];
                $data['pekerjaan_nama'] = $loadDatas[0]['pekerjaan_nama'];
                $data['statusperiksa'] = $loadDatas[0]['statusperiksa'];
                $data['no_pendaftaran'] = $loadDatas[0]['no_pendaftaran'];
                $data['pendaftaran_id'] = $loadDatas[0]['pendaftaran_id'];
                $data['alamatemail'] = $loadDatas[0]['alamatemail'];
                $data['kelaspelayanan_id'] = $loadDatas[0]['kelaspelayanan_id'];
                $data['ruangan'] = $loadDatas[0]['ruangan_nama'];
                $data['instalasi'] = $loadDatas[0]['instalasi_nama'];
                foreach($loadDatas AS $i => $val){
                    if(!empty($val['pasienmasukpenunjang_id'])){
                        $data['riwayatkunjungan'][$i]['tanggal'] = $format->formatDateTimeId($val['tglmasukpenunjang']);
                        $data['riwayatkunjungan'][$i]['ruangan_id'] = $val['ruanganpenunjang_id'];
                        $data['riwayatkunjungan'][$i]['ruangan_nama'] = $val['ruanganpenunjang_nama'];
                        $data['riwayatkunjungan'][$i]['nama_dokter'] = $val['gelardepan_dokterpenunjang']." ".$val['nama_dokterpenunjang'];
                    }else if(!empty($val['pasienadmisi_id'])){
                        $data['riwayatkunjungan'][$i]['tanggal'] = $format->formatDateTimeId($val['tgladmisi']);
                        $data['riwayatkunjungan'][$i]['ruangan_id'] = $val['ruanganadmisi_id'];
                        $data['riwayatkunjungan'][$i]['ruangan_nama'] = $val['ruanganadmisi_nama'];
                        $data['riwayatkunjungan'][$i]['nama_dokter'] = $val['gelardepan_dokteradmisi']." ".$val['nama_dokteradmisi'];
                    }else{
                        $data['riwayatkunjungan'][$i]['tanggal'] = $format->formatDateTimeId($val['tgl_pendaftaran']);
                        $data['riwayatkunjungan'][$i]['ruangan_id'] = $val['ruangan_id'];
                        $data['riwayatkunjungan'][$i]['ruangan_nama'] = $val['ruangan_nama'];
                        $data['riwayatkunjungan'][$i]['nama_dokter'] = $val['gelardepan_dokter']." ".$val['nama_dokter'];
                    }
                    $data['riwayatkunjungan'][$i]['no_pendaftaran'] = $val['no_pendaftaran'];
                }
            }else{
                $sql1 = "SELECT pasien_m.pasien_id,pasien_m.no_rekam_medik,
                pasien_m.namadepan, pasien_m.nama_pasien,
                pasien_m.tempat_lahir, pasien_m.tanggal_lahir,
                pasien_m.jeniskelamin, pasien_m.statusperkawinan,
                pasien_m.alamat_pasien, pasien_m.no_telepon_pasien, pasien_m.no_mobile_pasien,
                pasien_m.photopasien, pasien_m.alamatemail, pekerjaan_m.pekerjaan_nama
                FROM  pasien_m
                LEFT JOIN pekerjaan_m ON pekerjaan_m.pekerjaan_id = pasien_m.pekerjaan_id
                WHERE  pasien_m.pasien_id = ".$pasien_id."
                ";
                $loadDatas1 = Yii::app()->db->createCommand($sql1)->queryRow();
                $data['no_rekam_medik'] = $loadDatas1['no_rekam_medik'];
                $data['pasien_id'] = $loadDatas1['pasien_id'];
                $data['nama_pasien'] = $loadDatas1['namadepan']." ".$loadDatas1['nama_pasien'];
                $data['tempat_lahir'] = $loadDatas1['tempat_lahir'];
                $data['tanggal_lahir'] = $format->formatDateTimeId($loadDatas1['tanggal_lahir']);
                $data['jeniskelamin'] = $loadDatas1['jeniskelamin'];
                $data['pekerjaan_nama'] = $loadDatas1['jeniskelamin'];
                $data['statusperkawinan'] = $loadDatas1['statusperkawinan'];
                $data['alamatemail'] = $loadDatas1['alamatemail'];
                $data['alamat_pasien'] = $loadDatas1['alamat_pasien'];
                $data['no_telepon_pasien'] = $loadDatas1['no_telepon_pasien'];
                $data['no_mobile_pasien'] = $loadDatas1['no_mobile_pasien'];
                $data['statusperiksa'] = 'Belum pernah daftar';
                $data['photopasien'] = "jsonCallback(".Params::urlPhotoPasienDirectory().$loadDatas1['photopasien'].")";
                $data['pekerjaan_nama'] = $loadDatas1['pekerjaan_nama'];
                $data['pendaftaran_id'] = '';
                $data['no_pendaftaran'] = '';
                $data['ruangan'] = '';
                $data['instalasi'] = '';
                $data['kelaspelayanan_id'] = '';
            }
        }else{
            $data['pesan'] = "Error 404. Request tidak valid!";
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackProfile(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * Ubah Profil
     * @param : $_GET['pasien_id']
     * @param : $_GET['pekerjaanbaru']
     * @param : $_GET['statusperkawinanbaru']
     * @param : $_GET['nobaru']
     * @param : $_GET['alamatbaru']
     * @return json array
     */
    public function actionUbahProfilPasien(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = "Error 404. Request tidak valid!";
        $loginpemakai = MOLoginpemakaiK::model()->findByAttributes(array('loginpemakai_id'=>$_GET['loginpemakai_id']));
        if(isset($_GET['pasien_id']) && isset($_GET['loginpemakai_id']) && isset($_GET['nobaru']) && isset($_GET['emailbaru']) && isset($_GET['alamatbaru'])){
            $transaction = Yii::app()->db->beginTransaction();
            $pasien_id = $_GET['pasien_id'];
            try{
                $pasien = PasienM::model()->findByPk($pasien_id);
                $pasien->alamatemail = $_GET['emailbaru'];
                $pasien->no_mobile_pasien = $_GET['nobaru'];
                $pasien->alamat_pasien = $_GET['alamatbaru'];
                $pasien->update_time = date("Y-m-d H:i:s");
                $pasien->update_loginpemakai_id = $_GET['loginpemakai_id'];
                if($pasien->save()){
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Data berhasil diubah!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Data gagal diubah!<br>';
                }
            }catch (Exception $exc) {
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Data gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
            }

        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackUbahProfil(".$encode.")";
        Yii::app()->end();
    }
    /**
     * menampilkan data ruangan, kamar dan tarif
     * @param $_GET['q']
     * @return json
     */
    public function actionGetInfoRuangan(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $kelas = array();
        $kelaspelayanan='';
        $kelasID='';
        
        $req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
        if(isset($_GET['kelaspelayananId'])){
           
            if($_GET['kelaspelayananId'] == 'ALL' || empty($_GET['kelaspelayananId']))
                $kelas = '';
            if($_GET['kelaspelayananId'] == '0')
                $kelas = PARAMS::KELASPELAYANAN_ID_TANPA_KELAS;
            if($_GET['kelaspelayananId'] == '1')
                $kelas = PARAMS::KELASPELAYANAN_ID_KELAS_I; 
            if($_GET['kelaspelayananId'] == '2')
                $kelas = PARAMS::KELASPELAYANAN_ID_KELAS_II;
            if($_GET['kelaspelayananId'] == '3')
                $kelas = PARAMS::KELASPELAYANAN_ID_KELAS_III;        
            if($_GET['kelaspelayananId'] == 'VIP')
                $kelas = PARAMS::KELASPELAYANAN_ID_KELAS_VIP;         
            if($_GET['kelaspelayananId'] == 'VVIP')
                $kelas = PARAMS::KELASPELAYANAN_ID_KELAS_VVIP; 
                   
            if(!empty($kelas))
                $kelaspelayanan = ' AND kelaspelayanan_id = '.$kelas;
            else
                $kelaspelayanan = '';
          
               
        } 
        //ruangan hemodialisa
                $sql = "SELECT * 
                FROM Informasikamarinap_v
                WHERE 
                kamarruangan_aktif = true AND instalasi_id='".Params::INSTALASI_ID_HD."'
                ".(!empty($kelaspelayanan)?$kelaspelayanan:'')."
                ORDER BY ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed DESC";
                
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$val['ruangan_nama']][] = $val;
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackRuangan(".$encode.")";
        Yii::app()->end();
    }

    /**
     * transaksi booking kamar
     * @param $_GET['pasien_id']
     * @param $_GET['ruangan_id']
     * @param $_GET['kamarruangan_id']
     * @param $_GET['kelaspelayanan_id']
     * @return json
     */
    public function actionBookingKamar(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Gagal';
        if(isset($_GET['pasien_id']) && isset($_GET['ruangan_id']) && isset($_GET['kamarruangan_id']) && isset($_GET['kelaspelayanan_id'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model = new MOBookingkamarT;
                $model->tglbookingkamar = date('Y-m-d H:i:s');
                $model->tgltransaksibooking = date('Y-m-d H:i:s');
                $model->pasien_id = $_GET['pasien_id'];
                $model->ruangan_id = $_GET['ruangan_id'];
                $model->kamarruangan_id = $_GET['kamarruangan_id'];
                $model->kelaspelayanan_id = $_GET['kelaspelayanan_id'];
                $model->statuskonfirmasi = Params::STATUSKONFIRMASI_BOOKING_BELUM;
                $model->keteranganbooking = "Booking kamar via m-Pasien";
                $model->statusbooking = Params::STATUSBOOKING_NON_ANTRI;
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = 1;
                $model->bookingkamar_no = MyGenerator::noBookingKamar();

                if($model->save()){
                    KamarruanganM::model()->updateByPk($model->kamarruangan_id,array('keterangan_kamar'=>  Params::KETERANGANKAMAR_DIPESAN));
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Data booking kamar berhasil disimpan!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Data booking kamar gagal disimpan!';
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Data booking kamar gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
            }

        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }

    /**
     * menampilkan data tarif atau paket checkup
     * Issue: MA-15
     * @param : $_GET['r']
     * @param : $_GET['is_paket'] 0 = bukan paket | 1 = paket
     * @return json array
     */
    public function actionGetInfoTarifTindakan()
    {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Gagal';
        $kelas = array();
        $kelasID = '';
        $kelaspelayanan = '';
        $req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
        $is_paket = (isset($_GET['is_paket']) ? $_GET['is_paket'] : null);
        
        if(isset($_GET['kelasPelayananID'])){
           

            switch ((string)$_GET['kelasPelayananID']) {
                case '':
                    $kelas = '';
                    break;
                case '0':
                    $kelas = PARAMS::KELASPELAYANAN_ID_TANPA_KELAS;
                    break;
                case '1':
                    $kelas = PARAMS::KELASPELAYANAN_ID_KELAS_I;
                    break;
                case '2':
                    $kelas = PARAMS::KELASPELAYANAN_ID_KELAS_II;
                    break;
                case '3':
                    $kelas = PARAMS::KELASPELAYANAN_ID_KELAS_III;
                    break;
                case 'VIP':
                    $kelas = PARAMS::KELASPELAYANAN_ID_KELAS_VIP;
                    break;
                case 'VVIP':
                    $kelas = PARAMS::KELASPELAYANAN_ID_KELAS_VVIP;
                    break;
            }
            if(!empty($kelas))
                $kelaspelayanan = ' AND kelaspelayanan_m.kelaspelayanan_id = '.$kelas;
            else
                $kelaspelayanan = '';
        }
        // if($is_paket){ // paket
            $sql = "SELECT tipepaket_m.tipepaket_id, tipepaket_m.tipepaket_nama FROM tipepaket_m";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();           
            $sql = "SELECT tipepaket_m.tarifpaket, tipepaket_m.tipepaket_id, tipepaket_m.tipepaket_nama,
                    paketpelayanan_m.namatindakan, paketpelayanan_m.tarifpaketpel,
                    daftartindakan_m.daftartindakan_nama, daftartindakan_m.daftartindakan_namalainnya FROM tipepaket_m
                    JOIN paketpelayanan_m ON tipepaket_m.tipepaket_id=paketpelayanan_m.tipepaket_id
                    JOIN daftartindakan_m ON paketpelayanan_m.daftartindakan_id=daftartindakan_m.daftartindakan_id
                    WHERE LOWER(daftartindakan_m.daftartindakan_nama) like '%".$req."%'
                    OR LOWER(daftartindakan_m.daftartindakan_namalainnya) like '%".$req."%' 
                    OR LOWER(tipepaket_m.tipepaket_nama) like '%".$req."%' ORDER BY tipepaket_id ASC";
                        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
                        if(count($loadDatas) > 0){
                                foreach($loadDatas AS $i => $val){
                                        $data['paket'][$i] = $val;
                                }
                        }
            $sql = "SELECT daftartindakan_m.daftartindakan_nama, daftartindakan_m.daftartindakan_namalainnya, daftartindakan_m.daftartindakan_katakunci,
                jenistarif_m.jenistarif_nama,
                komponentarif_m.komponentarif_nama, tariftindakan_m.harga_tariftindakan,
                CASE
                    WHEN tariftindakan_m.persendiskon_tind > 0::double precision THEN tariftindakan_m.harga_tariftindakan * tariftindakan_m.persendiskon_tind / 100
                    ELSE tariftindakan_m.hargadiskon_tind
                    END AS hargadiskon_tind,
                tariftindakan_m.persencyto_tind,
                jeniskelas_m.jeniskelas_nama,
                kelaspelayanan_m.kelaspelayanan_nama, kelaspelayanan_m.kelaspelayanan_namalainnya
                FROM daftartindakan_m
                JOIN tariftindakan_m ON daftartindakan_m.daftartindakan_id = tariftindakan_m.daftartindakan_id
                JOIN perdatarif_m ON tariftindakan_m.perdatarif_id = perdatarif_m.perdatarif_id
                JOIN jenistarif_m ON tariftindakan_m.jenistarif_id = jenistarif_m.jenistarif_id
                JOIN komponentarif_m ON tariftindakan_m.komponentarif_id = komponentarif_m.komponentarif_id
                JOIN kelaspelayanan_m ON tariftindakan_m.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
                JOIN jeniskelas_m ON kelaspelayanan_m.jeniskelas_id = jeniskelas_m.jeniskelas_id
                WHERE komponentarif_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
                    AND perdatarif_m.perda_aktif = true
                    AND jenistarif_m.jenistarif_id = ".Params::JENISTARIF_ID_PELAYANAN."
                    ".(!empty($kelas)?'AND tariftindakan_m.kelaspelayanan_id = '.$kelas:'')."
                AND
                (LOWER(daftartindakan_m.daftartindakan_nama) like '%".$req."%'
                OR LOWER(daftartindakan_m.daftartindakan_namalainnya) like '%".$req."%'
                OR LOWER(daftartindakan_m.daftartindakan_katakunci) like '%".$req."%') 
                ORDER BY daftartindakan_m.daftartindakan_nama,kelaspelayanan_nama ";

                        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
                        if(count($loadDatas) > 0){
                                foreach($loadDatas AS $i => $val){
                                        $data['nonPaket'][$i] = $val;
                                }
                        }
        // }
            $encode = CJSON::encode($data);
            echo "jsonCallbackTarifTindakan(".$encode.")";
            Yii::app()->end();
    }

    /**
     * menampilkan data tindakan pelayanan dan Obat Alkes pasien
     * Issue: MA-16
     * @param : $_GET['pasien_id']
     * @return json array
     */
    public function actionGetTindakanObatPasien(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['tindakan'] = array();
        $data['obatalkes'] = array();
        $data['pembayaran'] = array();
        $data['tagihan'] = array();
       
        if(!empty($_GET['pasien_id']) && !empty($_GET['pendaftaran_id'])){
            $pasien_id = $_GET['pasien_id'];           
            $pendaftaran_id = $_GET['pendaftaran_id'];           
            $sql = "SELECT pendaftaran_id, pasien_id, no_pendaftaran, tgl_pendaftaran, instalasi_nama, ruangan_nama
                    FROM pendaftaran_t
                    JOIN instalasi_m ON instalasi_m.instalasi_id = pendaftaran_t.instalasi_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                    WHERE pendaftaran_t.pasien_id = ".$pasien_id." ".(!empty($pendaftaran_id)?"AND pendaftaran_t.pendaftaran_id = ".$pendaftaran_id:"")." ORDER BY pendaftaran_id DESC";
            $loadData = Yii::app()->db->createCommand($sql)->queryRow();
            $pendaftaran_id = (isset($loadData['pendaftaran_id']) ? $loadData['pendaftaran_id'] : null);
            $data['tagihan']['no_pendaftaran']=(isset($loadData['no_pendaftaran']) ? $loadData['no_pendaftaran'] : null);
            $data['tagihan']['instalsi']=(isset($loadData['instalasi_nama']) ? $loadData['instalasi_nama'] : null);
            $data['tagihan']['ruangan']=(isset($loadData['ruangan_nama']) ? $loadData['ruangan_nama'] : null);
            $data['tagihan']['tgl_pendaftaran']=$format->formatDateTimeForUser(isset($loadData['tgl_pendaftaran']) ? $loadData['tgl_pendaftaran'] : null);
            //TINDAKAN
            if(!empty($pendaftaran_id)){
                    $sql = "SELECT
                            tindakanpelayanan_t.instalasi_id,ruangan_m.ruangan_nama,daftartindakan_m.daftartindakan_nama, tindakanpelayanan_t.tgl_tindakan, tindakanpelayanan_t.tarif_satuan, tindakanpelayanan_t.qty_tindakan, tindakanpelayanan_t.discount_tindakan, (tindakanpelayanan_t.pembebasan_tindakan + tindakanpelayanan_t.subsidiasuransi_tindakan + tindakanpelayanan_t.subsidipemerintah_tindakan + tindakanpelayanan_t.subsisidirumahsakit_tindakan) AS subsidi,tindakanpelayanan_t.tindakansudahbayar_id
                            FROM tindakanpelayanan_t
                            JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tindakanpelayanan_t.daftartindakan_id
                            JOIN ruangan_m ON tindakanpelayanan_t.ruangan_id = ruangan_m.ruangan_id
                            WHERE tindakanpelayanan_t.pendaftaran_id = ".$pendaftaran_id;
                    $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
                    if(!empty($loadDatas)){
                        $data['tindakan']['totalsudahbayar'] = 0;
                        $data['tindakan']['totalbelumbayar'] = 0;
                        $data['tindakan']['total'] = 0;
                        $data['tindakan']['totaldiscount'] = 0;
                        $data['tindakan']['totalsubsidi'] = 0;
                        foreach($loadDatas AS $i => $val){
                            $data['tindakan']['items'][$i] = $val;
                            $data['tindakan']['items'][$i]['tgl_tindakan'] = MyFormatter::formatDateTimeForUser($data['tindakan']['items'][$i]['tgl_tindakan']);
                                if($val['tindakansudahbayar_id']){
                                    $data['tindakan']['totalsudahbayar'] += ($val['tarif_satuan'] * $val['qty_tindakan']);
                                }else{
                                    $data['tindakan']['totalbelumbayar'] += ($val['tarif_satuan'] * $val['qty_tindakan']);
                                }
                            $data['tindakan']['totaldiscount'] += $val['discount_tindakan'];
                            $data['tindakan']['totalsubsidi'] += $val['subsidi'];
                        }
                        $data['tindakan']['total'] = $data['tindakan']['totalsudahbayar'] + $data['tindakan']['totalbelumbayar'];
                    }
                    //OBATALKES PASIEN
                    $sql = "SELECT
                            ruangan_m.ruangan_nama,obatalkes_m.obatalkes_nama, obatalkespasien_t.tglpelayanan, obatalkespasien_t.qty_oa, obatalkespasien_t.hargasatuan_oa, (obatalkespasien_t.biayaservice + obatalkespasien_t.biayakonseling + obatalkespasien_t.jasadokterresep + obatalkespasien_t.biayakemasan + obatalkespasien_t.biayaadministrasi + obatalkespasien_t.tarifcyto) AS biayalain, obatalkespasien_t.discount, (obatalkespasien_t.subsidiasuransi + obatalkespasien_t.subsidipemerintah + obatalkespasien_t.subsidirs) AS subsidi , obatalkespasien_t.oasudahbayar_id
                            FROM obatalkespasien_t
                            JOIN obatalkes_m ON obatalkes_m.obatalkes_id = obatalkespasien_t.obatalkes_id
                            JOIN ruangan_m ON obatalkespasien_t.ruangan_id = ruangan_m.ruangan_id
                            WHERE obatalkespasien_t.pendaftaran_id = ".$pendaftaran_id;
                    $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
                    if(!empty($loadDatas)){
                        $data['obatalkes']['totalsudahbayar'] = 0;
                        $data['obatalkes']['totalbelumbayar'] = 0;
                        $data['obatalkes']['total'] = 0;
                        $data['obatalkes']['totalbiayalain'] = 0;
                        $data['obatalkes']['totaldiscount'] = 0;
                        $data['obatalkes']['totalsubsidi'] = 0;
                        foreach($loadDatas AS $i => $val){
                            $data['obatalkes']['items'][$i] = $val;
                            $data['obatalkes']['items'][$i]['tglpelayanan'] = MyFormatter::formatDateTimeForUser($data['obatalkes']['items'][$i]['tglpelayanan']);
                                if($val['oasudahbayar_id']){
                                    $data['obatalkes']['totalsudahbayar'] += ($val['qty_oa'] * $val['hargasatuan_oa']);
                                }else{
                                    $data['obatalkes']['totalbelumbayar'] += ($val['qty_oa'] * $val['hargasatuan_oa']);
                                }
                            $data['obatalkes']['totalbiayalain'] += $val['biayalain'];
                            $data['obatalkes']['totaldiscount'] += $val['discount'];
                            $data['obatalkes']['totalsubsidi'] += $val['subsidi'];
                        }
                        $data['obatalkes']['total'] = $data['obatalkes']['totalsudahbayar'] + $data['obatalkes']['totalbelumbayar'];
                    }
                    //PEMBAYARAN
                    $sql = "SELECT SUM(tandabuktibayar_t.biayaadministrasi) AS biayaadministrasi, SUM(tandabuktibayar_t.biayamaterai) AS biayamaterai, SUM(tandabuktibayar_t.jmlpembulatan) AS jmlpembulatan, SUM(pembayaranpelayanan_t.totalbayartindakan) AS totalbayartindakan, SUM(pembayaranpelayanan_t.totalsisatagihan) AS totalsisatagihan
                            FROM pembayaranpelayanan_t
                            JOIN tandabuktibayar_t ON tandabuktibayar_t.pembayaranpelayanan_id = pembayaranpelayanan_t.pembayaranpelayanan_id
                            WHERE pembayaranpelayanan_t.pendaftaran_id = ".$pendaftaran_id."
                            GROUP BY pembayaranpelayanan_t.pendaftaran_id";
                    $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                    $data['pembayaran'] = $loadData;
            }
        }else{
            $data['pesan'] = "Error 404. Request tidak valid!";
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackRiwayatPeriksa(".$encode.")";
        Yii::app()->end();
    }

    /**
     * menampilkan riwayat penunjang pasien
     * Issue: MA-24
     * @param : $_GET['bulan'] format: yyyy-mm
     * @param : $_GET['pasien_id']
     * @return json array
     */
    public function actionGetRiwayatPenunjang()
    {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['pasien_id']) && isset($_GET['pendaftaran_id'])){
            $pasien_id = $_GET['pasien_id'];
            $pendaftaran_id = $_GET['pendaftaran_id'];
            if(!empty($pendaftaran_id))
                $pendaftaran = "AND pendaftaran_t.pendaftaran_id = ".$pendaftaran_id;
            else
                $pendaftaran = '';
            // $bulan = !empty($_GET['bulan'])?$_GET['bulan']:date('Y-m');
            $ruangan = !empty($_GET['ruangan'])?$_GET['ruangan']:'';
            if($ruangan == 'lab')
                $ruangan_id = PARAMS::RUANGAN_ID_LAB_KLINIK;
            else if($ruangan == 'rad')
                $ruangan_id = PARAMS::RUANGAN_ID_RAD;
            else if($ruangan == 'gizi')
                $ruangan_id = PARAMS::RUANGAN_ID_GIZI;
            else if($ruangan == 'rehab')
                $ruangan_id = PARAMS::RUANGAN_ID_FISIOTERAPI;

            if(!empty($ruangan_id))
                $ruangan_sql = " AND ruanganpenunjang_m.ruangan_id = ".$ruangan_id;
            else
                $ruangan_sql = '';

            $sql = "SELECT pendaftaran_t.pendaftaran_id,pendaftaran_t.no_pendaftaran,pasienmasukpenunjang_t.pasienmasukpenunjang_id,
                ruanganpenunjang_m.ruangan_id,ruanganpenunjang_m.ruangan_nama, 
                pasienmasukpenunjang_t.no_masukpenunjang,TO_CHAR(tglmasukpenunjang,'d Mon YYYY HH24:MI') AS tglmasukpenunjang,
                kelaspelayanan_m.kelaspelayanan_nama,dokterpenunjang_m.gelardepan, 
                dokterpenunjang_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, 
                daftartindakan_m.daftartindakan_nama,tindakanpelayanan_t.qty_tindakan
                FROM tindakanpelayanan_t
                JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tindakanpelayanan_t.daftartindakan_id
                JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = tindakanpelayanan_t.pasienmasukpenunjang_id
                JOIN kelaspelayanan_m ON kelaspelayanan_m.kelaspelayanan_id = pasienmasukpenunjang_t.kelaspelayanan_id
                JOIN pegawai_m dokterpenunjang_m ON dokterpenunjang_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
                LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = dokterpenunjang_m.gelarbelakang_id
                JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = tindakanpelayanan_t.pendaftaran_id
                JOIN ruangan_m ruanganpenunjang_m ON ruanganpenunjang_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
                WHERE
                    pendaftaran_t.pasienbatalperiksa_id IS NULL
                    AND pasienmasukpenunjang_t.pasien_id = ".$pasien_id."   
                    ".$pendaftaran."                 
                    ".$ruangan_sql."
                ORDER BY pasienmasukpenunjang_t.tglmasukpenunjang DESC, ruanganpenunjang_m.ruangan_nama ASC
                ";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            
            if(!empty($loadDatas)){
                foreach($loadDatas AS $i => $val){
                    $data[$val['no_pendaftaran']]['pendaftaran_id'] = $val['pendaftaran_id'];
                    $data[$val['no_pendaftaran']]['ruangan'] = $val['ruangan_nama'];
                    $data[$val['no_pendaftaran']]['riwayat'][$val['pasienmasukpenunjang_id']]['pasienmasukpenunjang_id'] = $val['pasienmasukpenunjang_id'];                    
                    $data[$val['no_pendaftaran']]['riwayat'][$val['pasienmasukpenunjang_id']]['ruangan'] = $val['ruangan_nama'];
                    $data[$val['no_pendaftaran']]['riwayat'][$val['pasienmasukpenunjang_id']]['ruangan_id'] = $val['ruangan_id'];
                    $data[$val['no_pendaftaran']]['riwayat'][$val['pasienmasukpenunjang_id']]['no_masukpenunjang'] = $val['no_masukpenunjang'];
                    $data[$val['no_pendaftaran']]['riwayat'][$val['pasienmasukpenunjang_id']]['tglmasukpenunjang'] = $val['tglmasukpenunjang'];
                    $data[$val['no_pendaftaran']]['riwayat'][$val['pasienmasukpenunjang_id']]['kelaspelayanan_nama'] = $val['kelaspelayanan_nama'];
                    $data[$val['no_pendaftaran']]['riwayat'][$val['pasienmasukpenunjang_id']]['nama_dokter'] = $val['gelardepan']." ".$val['nama_pegawai']." ".$val['gelarbelakang_nama'];
                    $data[$val['no_pendaftaran']]['riwayat'][$val['pasienmasukpenunjang_id']]['pemeriksaan'][] = $val['daftartindakan_nama'];
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }

    public function actionGetRiwayatHasilPenunjang()
    {
        $data = array();
        header("content-type:application/json");
        $modPenunjang = PasienmasukpenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$_GET['pasienmasukpenunjang_id']));
        $data['identitas'] = $modPenunjang->attributes;       
        if(!empty($modPenunjang)){
            if($modPenunjang->ruangan_id == PARAMS::RUANGAN_ID_LAB_KLINIK){
                $modHasil = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$modPenunjang->pasienmasukpenunjang_id));
                $sqlDetHasil = "SELECT nm.namapemeriksaandet,pm.pemeriksaanlab_id,pm.pemeriksaanlab_nama,t.nilairujukan,t.hasilpemeriksaan,t.hasilpemeriksaan_metode,tt.satuantindakan FROM DetailHasilPemeriksaanLab_T t
                    JOIN pemeriksaanlab_m pm ON pm.pemeriksaanlab_id = t.pemeriksaanlab_id 
                    JOIN pemeriksaanlabdet_m pmd ON pmd.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
                    JOIN nilairujukan_m nm ON nm.nilairujukan_id = pmd.nilairujukan_id
                    JOIN tindakanpelayanan_t tt ON tt.tindakanpelayanan_id = t.tindakanpelayanan_id
                    WHERE hasilpemeriksaanlab_id = ".$modHasil->hasilpemeriksaanlab_id;
             
                $modDetHasil = Yii::app()->db->createCommand($sqlDetHasil)->queryAll();

                $data['dataHasil'] = $modHasil->attributes;
                $data['dataHasil']['tglhasilpemeriksaanlab'] = MyFormatter::FormatDateTimeForUser($modHasil->tglhasilpemeriksaanlab);
                foreach ($modDetHasil as $i => $detail) {
                    $data['dataDetHasil'][$i] = $detail;
                } 
            }else if($modPenunjang->ruangan_id == PARAMS::RUANGAN_ID_RAD){
                $modHasil = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$modPenunjang->pasienmasukpenunjang_id));
                if(!empty($modHasil)){
                    foreach ($modHasil as $i => $value) {
                         $data['dataHasil'][$i] = $value->attributes;
                         $data['dataHasil'][$i]['nama_pemeriksaan'] = $value->pemeriksaanrad->pemeriksaanrad_nama;
                    }
                }
            }else if($modPenunjang->ruangan_id == PARAMS::RUANGAN_ID_GIZI){
                $modHasil = MOTindakanpelayananT::model()->detailRiwayatKonsul($modPenunjang->pendaftaran_id);
                foreach ($modHasil as $i => $detail) {
                    $data['dataHasil'][$i] = $detail->attributes;
                    $data['dataHasil'][$i]['daftartindakan_nama'] = $detail->daftartindakan_nama;
                    $data['dataHasil'][$i]['kategoritindakan_nama'] = $detail->kategoritindakan_nama;
                    $data['dataHasil'][$i]['daftartindakan_kode'] = $detail->daftartindakan_kode;
                    $data['dataHasil'][$i]['instalasi_nama'] = $detail->instalasi_nama;
                    $data['dataHasil'][$i]['ruangan_nama'] = $detail->ruangan_nama;
                    $data['dataHasil'][$i]['tgl_tindakan'] = MyFormatter::formatDateTimeForUser($detail->tgl_tindakan);
                }               
            }else if($modPenunjang->ruangan_id == PARAMS::RUANGAN_ID_FISIOTERAPI){
                $modHasil = HasilpemeriksaanrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$modPenunjang->pasienmasukpenunjang_id));
                if(!empty($modHasil)){
                    foreach ($modHasil as $i => $value) {
                         $data['dataHasil'][$i] = $value->attributes;
                         $data['dataHasil'][$i]['nama_tindakan'] = $value->tindakanrm->tindakanrm_nama;
                    }
                }
            }
        }

        $encode = CJSON::encode($data);
        echo "jsonCallbackRiwayatHasil(".$encode.")";
        Yii::app()->end();
    }

    /**
     * menampilkan data menu diet (makanan)
     * MA-26
     * @param $_GET['q']
     * @return json
     */
    public function actionGetInfoMenuMakanan(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
        $sql = "SELECT jenisdiet_m.jenisdiet_id, jenisdiet_m.jenisdiet_nama, jenisdiet_m.jenisdiet_namalainnya, menudiet_m.menudiet_id, menudiet_m.menudiet_nama, menudiet_m.menudiet_namalain, menudiet_m.jml_porsi, menudiet_m.ukuranrumahtangga, tariftindakan_m.harga_tariftindakan, tariftindakan_m.persendiskon_tind, tariftindakan_m.hargadiskon_tind, penjaminpasien_m.penjamin_nama, kelaspelayanan_m.kelaspelayanan_nama
            FROM menudiet_m
            JOIN jenisdiet_m ON jenisdiet_m.jenisdiet_id = menudiet_m.jenisdiet_id
            LEFT JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = menudiet_m.daftartindakan_id
            LEFT JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
            LEFT JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = jenistarifpenjamin_m.penjamin_id
            LEFT JOIN kelaspelayanan_m ON kelaspelayanan_m.kelaspelayanan_id = tariftindakan_m.kelaspelayanan_id
            WHERE jenisdiet_m.jenisdiet_aktif = TRUE
            AND komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
            AND jenistarifpenjamin_m.penjamin_id = ".Params::PENJAMIN_ID_UMUM."
            AND(
                LOWER(jenisdiet_m.jenisdiet_nama) like '%".$req."%'
                OR LOWER(jenisdiet_m.jenisdiet_namalainnya) like '%".$req."%'
                OR LOWER(menudiet_m.menudiet_nama) like '%".$req."%'
                OR LOWER(menudiet_m.menudiet_namalain) like '%".$req."%'
                OR TO_CHAR(tariftindakan_m.harga_tariftindakan,'999999999999999999') like '%".str_replace(".", "", $req)."%'
            )
            ORDER BY jenisdiet_nama ASC, menudiet_nama ASC, harga_tariftindakan DESC
            ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            $sql_jeniswaktu = "SELECT *
                FROM jeniswaktu_m
                WHERE jeniswaktu_aktif = TRUE";
            $loadDataJenisWaktus = Yii::app()->db->createCommand($sql_jeniswaktu)->queryAll();
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['jeniswaktu'] = $loadDataJenisWaktus;
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackMenuMakanan(".$encode.")";
        Yii::app()->end();
    }

    /**
     * transaksi pemesanan menu makanan
     * MA-27
     * @param $_GET['pasien_id']
     * @param $_GET['menus'][] array (jenisdiet_id,menudiet_id, jeniswaktu_id)
     * @return ['sukses'] = 0/1
     * @return ['pesan'] = string
     */
    public function actionPesanMenuMakanan(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        $menus = array();
        if(isset($_GET['pasien_id']) && count($_GET['menus']) > 0){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $sql = "SELECT pendaftaran_t.pendaftaran_id, pasienadmisi_t.pasienadmisi_id, pasien_m.pasien_id, pasien_m.namadepan, pasien_m.nama_pasien, pendaftaran_t.ruangan_id, pasienadmisi_t.ruangan_id AS ruanganadmisi_id
                    FROM pendaftaran_t
                    JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id
                    LEFT JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = pendaftaran_t.pasienadmisi_id
                    WHERE pendaftaran_t.pasien_id = ".$_GET['pasien_id']."
                    LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if(empty($loadData)){
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Data gagal disimpan! Pasien tidak sedang melakukan kunjungan RS';
                }else{
                    $model = new MOPesanmenudietT;
                    $model->tglpesanmenu = date('Y-m-d H:i:s');
                    $model->ruangan_id = (!empty($loadData['ruanganadmisi_id']) ? $loadData['ruanganadmisi_id'] : $loadData['ruangan_id']);
                    $model->jenispesanmenu = Params::JENISPESANMENU_PASIEN;
                    $model->nama_pemesan = $loadData['namadepan']." ".$loadData['nama_pasien'];
                    $model->keterangan_pesan = "via m-Pasien";
                    $model->create_time = date("Y-m-d H:i:s");
                    $model->create_loginpemakai_id = 1;
                    $model->create_ruangan = Params::RUANGAN_ID_GIZI;
                    $model->nopesanmenu = MyGenerator::noPesanMenuDiet();
                    $model->bahandiet_id = 1; //sementara
                    $model->totalpesan_org = 1; //sementara
                    $model->jenisdiet_id = 82;
           
                    if($model->validate()){
                        $model->save();
                        $detailtersimpan = true;
                        foreach($_GET['menus'] AS $i => $menu){
                            $modDetails[$i] = new MOPesanmenudetailT;
                            $modDetails[$i]->pesanmenudiet_id = $model->pesanmenudiet_id;
                            $modDetails[$i]->pasien_id = $loadData['pasien_id'];
                            $modDetails[$i]->pendaftaran_id = $loadData['pendaftaran_id'];
                            $modDetails[$i]->pasienadmisi_id = (!empty($loadData['pasienadmisi_id']) ? $loadData['pasienadmisi_id'] : null);
                            $modDetails[$i]->menudiet_id = $menu['menudiet_id'];
                            $modDetails[$i]->jeniswaktu_id = $menu['jeniswaktu_id'];
                            $modDetails[$i]->jml_pesan_porsi = $menu['jml_pesan_porsi'];
                            $modDetails[$i]->satuanjml_urt = Params::SATUANJML_URT;
                            if($modDetails[$i]->save()){
                                $detailtersimpan &= true;
                            }else{
                                $detailtersimpan = false;
                            }
                        }
                        if($detailtersimpan){
                            $transaction->commit();
                            $data['sukses'] = 1;
                            $data['pesan'] = 'Data pemesanan menu makanan berhasil disimpan!';
                        }else{
                            $transaction->rollback();
                            $data['sukses'] = 0;
                            $data['pesan'] = 'Data detail pemesanan menu makanan gagal disimpan! <br>'.CHtml::errorSummary($model);
                        }
                    }else{
                        $transaction->rollback();
                        $data['sukses'] = 0;
                        $data['pesan'] = 'Data pemesanan menu makanan gagal disimpan';
                    }
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Data pemesanan menu makanan gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }

    /**
     * menampilkan hasil pemeriksaan:
     * - Laboratorium Klinik
     * - Laboratorium Patologi Anatomi
     * - Radiologi
     * - Rehabilitasi Medis
     * @param int $_GET['pasienmasukpenunjang_id']
     * @param int $_GET['ruangan_id']
     * @return json
     */
    public function actionGetHasilPemeriksaan(){
        header("content-type:application/json");
        $data = array();
        if(isset($_GET['pasienmasukpenunjang_id']) && isset($_GET['ruangan_id'])){
            $pasienmasukpenunjang_id = $_GET['pasienmasukpenunjang_id'];
            $ruangan_id = $_GET['ruangan_id'];
            if($ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){
                $data = $this->getHasilLabKliniks($pasienmasukpenunjang_id);
            }else if($ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI){
                $data = $this->getHasilLabPatologis($pasienmasukpenunjang_id);
            }else if($ruangan_id == Params::RUANGAN_ID_RAD){
                $data = $this->getHasilRadiologis($pasienmasukpenunjang_id);
            }else if($ruangan_id == Params::RUANGAN_ID_FISIOTERAPI){
                $data = $this->getHasilRehabMedis($pasienmasukpenunjang_id);
            }            
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    /**
     * data hasil laboratorium klinik
     * @param type $pasienmasukpenunjang_id
     * @return type
     */
    protected function getHasilLabKliniks($pasienmasukpenunjang_id){
        $data = array();
        // $sqlKesimpulan = "SELECT nama_pegawai,hasilpemeriksaanlab_t.* FROM hasilpemeriksaanlab_t 
        //                     JOIN pasienmasukpenunjang_t ON hasilpemeriksaanlab_t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
        //                     JOIN pegawai_m ON pasienmasukpenunjang_t.pegawai_id = pegawai_m.pegawai_id
        //                     WHERE hasilpemeriksaanlab_t.pasienmasukpenunjang_id = ".$pasienmasukpenunjang_id;

        $sql = "SELECT pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran,
                pasienmasukpenunjang_t.no_masukpenunjang, pasienmasukpenunjang_t.tglmasukpenunjang, ruangan_m.ruangan_id, ruangan_m.ruangan_nama,
                hasilpemeriksaanlab_t.nohasilperiksalab, hasilpemeriksaanlab_t.tglhasilpemeriksaanlab, hasilpemeriksaanlab_t.catatanlabklinik, hasilpemeriksaanlab_t.kesimpulan, hasilpemeriksaanlab_t.printhasillab,
                pasien_m.no_rekam_medik, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.tanggal_lahir, pasien_m.jeniskelamin, pasien_m.alamat_pasien,
                jenispemeriksaanlab_m.jenispemeriksaanlab_nama,
                pemeriksaanlab_m.pemeriksaanlab_id, pemeriksaanlab_m.pemeriksaanlab_nama,
                nilairujukan_m.kelompokdet, nilairujukan_m.namapemeriksaandet,
                detailhasilpemeriksaanlab_t.hasilpemeriksaan, detailhasilpemeriksaanlab_t.nilairujukan, detailhasilpemeriksaanlab_t.hasilpemeriksaan_satuan, detailhasilpemeriksaanlab_t.hasilpemeriksaan_metode,
                pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
                FROM pasienmasukpenunjang_t 
                JOIN hasilpemeriksaanlab_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = hasilpemeriksaanlab_t.pasienmasukpenunjang_id
                LEFT JOIN detailhasilpemeriksaanlab_t ON detailhasilpemeriksaanlab_t.hasilpemeriksaanlab_id = detailhasilpemeriksaanlab_t.detailhasilpemeriksaanlab_id
                LEFT JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = detailhasilpemeriksaanlab_t.pemeriksaanlab_id
                LEFT JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
                LEFT JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = detailhasilpemeriksaanlab_t.pemeriksaanlabdet_id
                LEFT JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id         
                JOIN pegawai_m ON pegawai_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
                LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
                JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienmasukpenunjang_t.pendaftaran_id
                JOIN pasien_m ON pasien_m.pasien_id = pasienmasukpenunjang_t.pasien_id
            WHERE pasienmasukpenunjang_t.pasienmasukpenunjang_id = ".$pasienmasukpenunjang_id."
            ORDER BY jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut";

        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        // $loadDataKesimpulan = Yii::app()->db->createCommand($sqlKesimpulan)->queryRow();
        // if(count($loadDataKesimpulan) > 0){
        //     $data['kesimpulan'] = $loadDataKesimpulan;
        // }
        if(count($loadDatas) > 0){
            $data['header']['no_pendaftaran'] = $loadDatas[0]['no_pendaftaran'];
            $data['header']['tgl_pendaftaran'] = $loadDatas[0]['tgl_pendaftaran'];
            $data['header']['no_masukpenunjang'] = $loadDatas[0]['no_masukpenunjang'];
            $data['header']['tglmasukpenunjang'] = $loadDatas[0]['tglmasukpenunjang'];
            $data['header']['ruangan_id'] = $loadDatas[0]['ruangan_id'];
            $data['header']['ruangan_nama'] = $loadDatas[0]['ruangan_nama'];
            $data['header']['no_rekam_medik'] = $loadDatas[0]['no_rekam_medik'];
            $data['header']['nama_pasien'] = $loadDatas[0]['namadepan']." ".$loadDatas[0]['nama_pasien'];
            $data['header']['tanggal_lahir'] = $loadDatas[0]['tanggal_lahir'];
            $data['header']['jeniskelamin'] = $loadDatas[0]['jeniskelamin'];
            $data['header']['alamat_pasien'] = $loadDatas[0]['alamat_pasien'];
            $data['header']['nohasil'] = $loadDatas[0]['nohasilperiksalab'];
            $data['header']['printhasil'] = $loadDatas[0]['printhasillab'];
            foreach($loadDatas AS $i => $val){
                $data['detail'][$val['pemeriksaanlab_id']]['pemeriksaanlab_nama'] = $val['pemeriksaanlab_nama'];
                $data['detail'][$val['pemeriksaanlab_id']]['kelompokdet'] = $val['kelompokdet'];
                $data['detail'][$val['pemeriksaanlab_id']]['pemeriksaanlabdet'][$i]['namapemeriksaandet'] = $val['namapemeriksaandet'];
                $data['detail'][$val['pemeriksaanlab_id']]['pemeriksaanlabdet'][$i]['hasilpemeriksaan'] = $val['hasilpemeriksaan'];
                $data['detail'][$val['pemeriksaanlab_id']]['pemeriksaanlabdet'][$i]['nilairujukan'] = $val['nilairujukan'];
                $data['detail'][$val['pemeriksaanlab_id']]['pemeriksaanlabdet'][$i]['hasilpemeriksaan_satuan'] = $val['hasilpemeriksaan_satuan'];
                $data['detail'][$val['pemeriksaanlab_id']]['pemeriksaanlabdet'][$i]['hasilpemeriksaan_metode'] = $val['hasilpemeriksaan_metode'];
            }
            $data['footer']['catatan'] = $loadDatas[0]['catatanlabklinik'];
            $data['footer']['kesimpulan'] = $loadDatas[0]['kesimpulan'];
            $data['footer']['nama_dokter'] = $loadDatas[0]['gelardepan']." ".$loadDatas[0]['nama_pegawai']." ".$loadDatas[0]['gelarbelakang_nama'];
        }
        return $data;
    }

    /**
     * menampilkan hasil laboratorium patologi anatomi
     * @param type $pasienmasukpenunjang_id
     * @return type
     */
    protected function getHasilLabPatologis($pasienmasukpenunjang_id){
        $data = array();
        $sql = "SELECT pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran,
            pasienmasukpenunjang_t.no_masukpenunjang, pasienmasukpenunjang_t.tglmasukpenunjang, ruangan_m.ruangan_id, ruangan_m.ruangan_nama,
            pasien_m.no_rekam_medik, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.tanggal_lahir, pasien_m.jeniskelamin, pasien_m.alamat_pasien,
            jenispemeriksaanlab_m.jenispemeriksaanlab_nama,
            pemeriksaanlab_m.pemeriksaanlab_id, pemeriksaanlab_m.pemeriksaanlab_nama,
            hasilpemeriksaanpa_t.nosediaanpa, hasilpemeriksaanpa_t.tglperiksapa, hasilpemeriksaanpa_t.makroskopis, hasilpemeriksaanpa_t.mikroskopis, hasilpemeriksaanpa_t.kesimpulanpa, hasilpemeriksaanpa_t.saranpa, hasilpemeriksaanpa_t.catatanpa, hasilpemeriksaanpa_t.printhasilpa,
            pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
            FROM hasilpemeriksaanpa_t
            JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = hasilpemeriksaanpa_t.pemeriksaanlab_id
            JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
            JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = hasilpemeriksaanpa_t.pasienmasukpenunjang_id
            JOIN pegawai_m ON pegawai_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
            JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienmasukpenunjang_t.pendaftaran_id
            JOIN pasien_m ON pasien_m.pasien_id = hasilpemeriksaanpa_t.pasien_id
            WHERE pasienmasukpenunjang_t.pasienmasukpenunjang_id = ".$pasienmasukpenunjang_id."
            ORDER BY jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC
            ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            $data['header']['no_pendaftaran'] = $loadDatas[0]['no_pendaftaran'];
            $data['header']['tgl_pendaftaran'] = $loadDatas[0]['tgl_pendaftaran'];
            $data['header']['no_masukpenunjang'] = $loadDatas[0]['no_masukpenunjang'];
            $data['header']['tglmasukpenunjang'] = $loadDatas[0]['tglmasukpenunjang'];
            $data['header']['ruangan_id'] = $loadDatas[0]['ruangan_id'];
            $data['header']['ruangan_nama'] = $loadDatas[0]['ruangan_nama'];
            $data['header']['no_rekam_medik'] = $loadDatas[0]['no_rekam_medik'];
            $data['header']['nama_pasien'] = $loadDatas[0]['namadepan']." ".$loadDatas[0]['nama_pasien'];
            $data['header']['tanggal_lahir'] = $loadDatas[0]['tanggal_lahir'];
            $data['header']['jeniskelamin'] = $loadDatas[0]['jeniskelamin'];
            $data['header']['alamat_pasien'] = $loadDatas[0]['alamat_pasien'];
            $data['header']['nohasil'] = $loadDatas[0]['nosediaanpa'];
            $data['header']['printhasil'] = $loadDatas[0]['printhasilpa'];
            foreach($loadDatas AS $i => $val){
                $data['detail'][$i]['jenispemeriksaanlab_nama'] = $val['jenispemeriksaanlab_nama'];
                $data['detail'][$i]['pemeriksaanlab_nama'] = $val['pemeriksaanlab_nama'];
                $data['detail'][$i]['makroskopis'] = $val['makroskopis'];
                $data['detail'][$i]['mikroskopis'] = $val['mikroskopis'];
                $data['detail'][$i]['kesimpulanpa'] = $val['kesimpulanpa'];
                $data['detail'][$i]['saranpa'] = $val['saranpa'];
                $data['detail'][$i]['catatanpa'] = $val['catatanpa'];
            }
            $data['footer']['catatan'] = "";
            $data['footer']['kesimpulan'] = "";
            $data['footer']['nama_dokter'] = $loadDatas[0]['gelardepan']." ".$loadDatas[0]['nama_pegawai']." ".$loadDatas[0]['gelarbelakang_nama'];
        }
        return $data;
    }
    /**
     * menampilkan hasil radiologi
     * @param type $pasienmasukpenunjang_id
     * @return string
     */
    protected function getHasilRadiologis($pasienmasukpenunjang_id){
        $data = array();
        $sql = "SELECT pasienmasukpenunjang_t.pasienmasukpenunjang_id, pasienmasukpenunjang_t.ruangan_id,pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran,
            pasienmasukpenunjang_t.no_masukpenunjang, pasienmasukpenunjang_t.tglmasukpenunjang, ruangan_m.ruangan_nama,
            pasien_m.no_rekam_medik, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.tanggal_lahir, pasien_m.jeniskelamin, pasien_m.alamat_pasien,
            jenispemeriksaanrad_m.jenispemeriksaanrad_nama,
            pemeriksaanrad_m.pemeriksaanrad_id, pemeriksaanrad_m.pemeriksaanrad_nama,
            hasilpemeriksaanrad_t.tglpemeriksaanrad, hasilpemeriksaanrad_t.hasilexpertise, hasilpemeriksaanrad_t.kesan_hasilrad, hasilpemeriksaanrad_t.kesimpulan_hasilrad, hasilpemeriksaanrad_t.printhasilrad,
            pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
            FROM hasilpemeriksaanrad_t
            JOIN pemeriksaanrad_m ON pemeriksaanrad_m.pemeriksaanrad_id = hasilpemeriksaanrad_t.pemeriksaanrad_id
            JOIN jenispemeriksaanrad_m ON jenispemeriksaanrad_m.jenispemeriksaanrad_id = pemeriksaanrad_m.jenispemeriksaanrad_id
            JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = hasilpemeriksaanrad_t.pasienmasukpenunjang_id
            JOIN pegawai_m ON pegawai_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
            JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienmasukpenunjang_t.pendaftaran_id
            JOIN pasien_m ON pasien_m.pasien_id = hasilpemeriksaanrad_t.pasien_id
            WHERE pasienmasukpenunjang_t.pasienmasukpenunjang_id = ".$pasienmasukpenunjang_id."
            ORDER BY jenispemeriksaanrad_m.jenispemeriksaanrad_urutan ASC, pemeriksaanrad_m.pemeriksaanrad_urutan ASC";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            $data['header']['no_pendaftaran'] = $loadDatas[0]['no_pendaftaran'];
            $data['header']['tgl_pendaftaran'] = $loadDatas[0]['tgl_pendaftaran'];
            $data['header']['no_masukpenunjang'] = $loadDatas[0]['no_masukpenunjang'];
            $data['header']['tglmasukpenunjang'] = $loadDatas[0]['tglmasukpenunjang'];
            $data['header']['ruangan_id'] = $loadDatas[0]['ruangan_id'];
            $data['header']['ruangan_nama'] = $loadDatas[0]['ruangan_nama'];
            $data['header']['no_rekam_medik'] = $loadDatas[0]['no_rekam_medik'];
            $data['header']['nama_pasien'] = $loadDatas[0]['namadepan']." ".$loadDatas[0]['nama_pasien'];
            $data['header']['tanggal_lahir'] = $loadDatas[0]['tanggal_lahir'];
            $data['header']['jeniskelamin'] = $loadDatas[0]['jeniskelamin'];
            $data['header']['alamat_pasien'] = $loadDatas[0]['alamat_pasien'];
            $data['header']['nohasil'] = "-";
            $data['header']['printhasil'] = $loadDatas[0]['printhasilrad'];
            foreach($loadDatas AS $i => $val){
                $data['detail'][$i]['jenispemeriksaanrad_nama'] = $val['jenispemeriksaanrad_nama'];
                $data['detail'][$i]['pemeriksaanrad_nama'] = $val['pemeriksaanrad_nama'];
                $data['detail'][$i]['hasilexpertise'] = $val['hasilexpertise'];
                $data['detail'][$i]['kesan_hasilrad'] = $val['kesan_hasilrad'];
                $data['detail'][$i]['kesimpulan_hasilrad'] = $val['kesimpulan_hasilrad'];
            }
            $data['footer']['catatan'] = "";
            $data['footer']['kesimpulan'] = "";
            $data['footer']['nama_dokter'] = $loadDatas[0]['gelardepan']." ".$loadDatas[0]['nama_pegawai']." ".$loadDatas[0]['gelarbelakang_nama'];
        }
        return $data;
    }
    /**
     * menampilkan hasil pemeriksaan rehabilitasi medis
     * @param type $pasienmasukpenunjang_id
     * @return string
     */
    protected function getHasilRehabMedis($pasienmasukpenunjang_id){
        $data = array();
        $sql = "SELECT pasienmasukpenunjang_t.pasienmasukpenunjang_id, pasienmasukpenunjang_t.ruangan_id,pendaftaran_t.no_pendaftaran,pendaftaran_t.pendaftaran_id, pendaftaran_t.tgl_pendaftaran,
            pasienmasukpenunjang_t.no_masukpenunjang, pasienmasukpenunjang_t.tglmasukpenunjang, ruangan_m.ruangan_nama,
            pasien_m.no_rekam_medik, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.tanggal_lahir, pasien_m.jeniskelamin, pasien_m.alamat_pasien,
            jenistindakanrm_m.jenistindakanrm_nama,
            tindakanrm_m.tindakanrm_id, tindakanrm_m.tindakanrm_nama,
            hasilpemeriksaanrm_t.tglpemeriksaanrm, hasilpemeriksaanrm_t.nohasilrm, hasilpemeriksaanrm_t.kunjunganke, hasilpemeriksaanrm_t.hasilpemeriksaanrm, hasilpemeriksaanrm_t.keteranganhasilrm, hasilpemeriksaanrm_t.peralatandigunakan,
            paramedis1_m.gelardepan AS gelardepan_paramedis1 , paramedis1_m.nama_pegawai AS nama_paramedis1, gelarbelakangpm1_m.gelarbelakang_nama AS gelarbelakang_paramedis1,
            paramedis2_m.gelardepan AS gelardepan_paramedis2 , paramedis2_m.nama_pegawai AS nama_paramedis2, gelarbelakangpm2_m.gelarbelakang_nama AS gelarbelakang_paramedis2,
            pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
            FROM hasilpemeriksaanrm_t
            LEFT JOIN jadwalkunjunganrm_t ON jadwalkunjunganrm_t.jadwalkunjunganrm_id = hasilpemeriksaanrm_t.jadwalkunjunganrm_id
            JOIN tindakanrm_m ON tindakanrm_m.tindakanrm_id = hasilpemeriksaanrm_t.tindakanrm_id
            JOIN jenistindakanrm_m ON jenistindakanrm_m.jenistindakanrm_id = tindakanrm_m.jenistindakanrm_id
            JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = hasilpemeriksaanrm_t.pasienmasukpenunjang_id
            JOIN pegawai_m ON pegawai_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            LEFT JOIN pegawai_m paramedis1_m ON paramedis1_m.pegawai_id = hasilpemeriksaanrm_t.paramedis1_id
            LEFT JOIN gelarbelakang_m gelarbelakangpm1_m ON gelarbelakangpm1_m.gelarbelakang_id = paramedis1_m.gelarbelakang_id
            LEFT JOIN pegawai_m paramedis2_m ON paramedis2_m.pegawai_id = hasilpemeriksaanrm_t.paramedis2_id
            LEFT JOIN gelarbelakang_m gelarbelakangpm2_m ON gelarbelakangpm2_m.gelarbelakang_id = paramedis2_m.gelarbelakang_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
            JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienmasukpenunjang_t.pendaftaran_id
            JOIN pasien_m ON pasien_m.pasien_id = hasilpemeriksaanrm_t.pasien_id
            WHERE pasienmasukpenunjang_t.pasienmasukpenunjang_id = ".$pasienmasukpenunjang_id."
            ORDER BY jenistindakanrm_m.jenistindakanrm_urutan ASC, tindakanrm_m.tindakanrm_urutan ASC";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            $data['header']['no_pendaftaran'] = $loadDatas[0]['no_pendaftaran'];
            $data['header']['pendaftaran_id'] = $loadDatas[0]['pendaftaran_id'];
            $data['header']['tgl_pendaftaran'] = $loadDatas[0]['tgl_pendaftaran'];
            $data['header']['no_masukpenunjang'] = $loadDatas[0]['no_masukpenunjang'];
            $data['header']['tglmasukpenunjang'] = $loadDatas[0]['tglmasukpenunjang'];
            $data['header']['ruangan_id'] = $loadDatas[0]['ruangan_id'];
            $data['header']['ruangan_nama'] = $loadDatas[0]['ruangan_nama'];
            $data['header']['no_rekam_medik'] = $loadDatas[0]['no_rekam_medik'];
            $data['header']['nama_pasien'] = $loadDatas[0]['namadepan']." ".$loadDatas[0]['nama_pasien'];
            $data['header']['tanggal_lahir'] = $loadDatas[0]['tanggal_lahir'];
            $data['header']['jeniskelamin'] = $loadDatas[0]['jeniskelamin'];
            $data['header']['alamat_pasien'] = $loadDatas[0]['alamat_pasien'];
            $data['header']['nohasilrm'] = $loadDatas[0]['nohasilrm'];
            $data['header']['printhasil'] = "";
            foreach($loadDatas AS $i => $val){
                $data['detail'][$i]['jenistindakanrm_nama'] = $val['jenistindakanrm_nama'];
                $data['detail'][$i]['tindakanrm_nama'] = $val['tindakanrm_nama'];
                $data['detail'][$i]['kunjunganke'] = $val['kunjunganke'];
                $data['detail'][$i]['hasilpemeriksaanrm'] = $val['hasilpemeriksaanrm'];
                $data['detail'][$i]['keteranganhasilrm'] = $val['keteranganhasilrm'];
                $data['detail'][$i]['peralatandigunakan'] = $val['peralatandigunakan'];
                $data['detail'][$i]['nama_paramedis1'] = $val['gelardepan_paramedis1']." ".$val['nama_paramedis1']." ".$val['gelarbelakang_paramedis1'];
                $data['detail'][$i]['nama_paramedis2'] = $val['gelardepan_paramedis2']." ".$val['nama_paramedis2']." ".$val['gelarbelakang_paramedis2'];
            }
            $data['footer']['catatan'] = "";
            $data['footer']['kesimpulan'] = "";
            $data['footer']['nama_dokter'] = $loadDatas[0]['gelardepan']." ".$loadDatas[0]['nama_pegawai']." ".$loadDatas[0]['gelarbelakang_nama'];
        }
        return $data;
    }

//    public function actionGetRiwayatPemeriksaan(){
//        header("content-type:application/json");
//        $format = new MyFormatter();
//        $data = array();
//        $pasien_id = !empty($_GET['pasien_id'])?$_GET['pasien_id']:null;
//        $pendaftaran_id = !empty($_GET['pendaftaran_id'])?$_GET['pendaftaran_id']:null;
//        if(!empty($pasien_id) && !empty($pendaftaran_id)){            
//            $queryPendaftaran = !empty($pendaftaran_id)?' AND pendaftaran_t.pendaftaran_id = '.$pendaftaran_id:'';                  
//            if(empty($bulan)){ //DEFAULT NILAI JIKA TIDAK ADA BULAN MA-129
//                $sql_terakhir = "SELECT pendaftaran_t.tgl_pendaftaran
//                                 FROM pendaftaran_t
//                                 WHERE
//                                    pendaftaran_t.pasienbatalperiksa_id IS NULL
//                                    AND pendaftaran_t.pasien_id = ".$pasien_id." 
//                                    ".$queryPendaftaran."
//                                 ORDER BY pendaftaran_t.tgl_pendaftaran DESC
//                                 LIMIT 1";
//                $loadData = Yii::app()->db->createCommand($sql_terakhir)->queryRow();
//                if($loadData){
//                    $bulan = substr($loadData['tgl_pendaftaran'], 0, 7);
//                }
//            }
//            $sql = "SELECT pendaftaran_t.pendaftaran_id,
//                           no_pendaftaran,statusperiksa,
//                           (CASE WHEN pendaftaran_t.pasienadmisi_id IS NOT NULL THEN ruanganadmisi_m.ruangan_nama ELSE ruangan_m.ruangan_nama END) AS ruangan_nama,
//                           instalasi_nama, TO_CHAR(tgl_pendaftaran,'d Mon YYYY HH24:MI') AS tgl_pendaftaran,
//                           pendaftaran_t.pasienpulang_id,kelaspelayanan_nama,carabayar_nama FROM 
//                    pendaftaran_t 
//                    LEFT JOIN pasienadmisi_t ON pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id
//                    LEFT JOIN ruangan_m ruanganadmisi_m ON ruanganadmisi_m.ruangan_id = pasienadmisi_t.ruangan_id
//                    JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id 
//                    JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
//                    JOIN kelaspelayanan_m ON pendaftaran_t.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
//                    JOIN carabayar_m ON pendaftaran_t.carabayar_id = carabayar_m.carabayar_id
//                    WHERE pendaftaran_t.pasien_id = ".$pasien_id." ".$queryPendaftaran."
//                    AND pendaftaran_t.pasienbatalperiksa_id IS NULL 
//                    ORDER BY tgl_pendaftaran DESC";
//            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
//            $dates = (!empty($_GET['bulan'])?$_GET['bulan']:date('Y-m-d'));
//            if(!empty($loadDatas)){
//                foreach($loadDatas AS $i => $val){
//                    $data[$val['no_pendaftaran']]['pendaftaran'] = $val;
//                    $data[$val['no_pendaftaran']]['anamnesa'] = $this->getRiwayatAnamnesa($val['pendaftaran_id']);
//                    $data[$val['no_pendaftaran']]['pemeriksaanfisik'] = $this->getRiwayatPemeriksaanFisik($val['pendaftaran_id']);
//                    $data[$val['no_pendaftaran']]['tindakan'] = $this->getRiwayatTindakan($val['pendaftaran_id']);
//                    $data[$val['no_pendaftaran']]['konsulpoli'] = $this->getRiwayatKonsultasiPoli($val['pendaftaran_id']);
//                    $data[$val['no_pendaftaran']]['rujukankeluar'] = $this->getRiwayatRujukanKeluar($val['pendaftaran_id']);
//                    $data[$val['no_pendaftaran']]['rujukankeluar'] = $this->getRiwayatRujukanKeluar($val['pendaftaran_id']);
//                    $data[$val['no_pendaftaran']]['reseptur'] = $this->getRiwayatReseptur($val['pendaftaran_id']);
//                    $data[$val['no_pendaftaran']]['diagnosis'] = $this->getRiwayatMorbiditas($val['pendaftaran_id']);               
//                }                
//            }
//        }
//        $encode = CJSON::encode($data);
//        //echo "jsonCallback(".$encode.")";
//        echo "jsonCallbackRiwayatPeriksa(".$encode.")";
//        Yii::app()->end();
//    }


    /**
     * menampilkan data riwayat anamnesa
     * MA-36
     * @param type $pendaftaran_id
     * @return array
     */
    protected function getRiwayatAnamnesa($pendaftaran_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "SELECT anamnesa_t.tglanamnesis, anamnesa_t.keluhanutama, anamnesa_t.keluhantambahan, anamnesa_t.riwayatpenyakitterdahulu, anamnesa_t.riwayatpenyakitkeluarga, anamnesa_t.lamasakit, anamnesa_t.pengobatanygsudahdilakukan, anamnesa_t.riwayatalergiobat, anamnesa_t.riwayatkelahiran, anamnesa_t.riwayatmakanan, anamnesa_t.riwayatimunisasi, anamnesa_t.paramedis_nama, anamnesa_t.keterangananamesa,
            pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
            triase_m.triase_nama,triase_m.warna_triase, triase_m.kode_warnatriase, triase_m.keterangan_triase
            FROM anamnesa_t
            LEFT JOIN triase_m ON triase_m.triase_id = anamnesa_t.triase_id
            JOIN pegawai_m ON pegawai_m.pegawai_id = anamnesa_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            WHERE anamnesa_t.pendaftaran_id = ".$pendaftaran_id;
        $loadData = Yii::app()->db->createCommand($sql)->queryRow();
        if(!empty($loadData)){
            $data = $loadData;
            $data['tglanamnesis'] = $format->formatDateTimeForUser($loadData['tglanamnesis']);
        }
        return $data;
    }
    /**
     * menampilkan data riwayat pemeriksaan fisik
     * MA-37
     * @param type $pendaftaran_id
     * @return array
     */
    protected function getRiwayatPemeriksaanFisik($pendaftaran_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "SELECT gcs_m.gcs_nama, gcs_m.gcs_nilaimin, gcs_nilaimax,
                pemeriksaanfisik_t.tglperiksafisik, pemeriksaanfisik_t.keadaanumum, pemeriksaanfisik_t.inspeksi,
                pemeriksaanfisik_t.palpasi, pemeriksaanfisik_t.perkusi, pemeriksaanfisik_t.auskultasi,
                pemeriksaanfisik_t.tekanandarah, pemeriksaanfisik_t.td_systolic, pemeriksaanfisik_t.td_diastolic,
                pemeriksaanfisik_t.meanarteripressure, pemeriksaanfisik_t.detaknadi, pemeriksaanfisik_t.heartindex_i1,
                pemeriksaanfisik_t.heartindex_i2, pemeriksaanfisik_t.heartindex_i3, pemeriksaanfisik_t.suhutubuh,
                pemeriksaanfisik_t.beratbadan_kg, pemeriksaanfisik_t.tinggibadan_cm, pemeriksaanfisik_t.bb_ideal,
                pemeriksaanfisik_t.pernapasan, pemeriksaanfisik_t.paramedis_nama, pemeriksaanfisik_t.kelainanpadabagtubuh,
                pemeriksaanfisik_t.gcs_eye, pemeriksaanfisik_t.gcs_verbal, pemeriksaanfisik_t.gcs_motorik,
                pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
                FROM pemeriksaanfisik_t
                JOIN pegawai_m ON pegawai_m.pegawai_id = pemeriksaanfisik_t.pegawai_id
                LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                LEFT JOIN gcs_m ON gcs_m.gcs_id = pemeriksaanfisik_t.gcs_id
                WHERE pemeriksaanfisik_t.pendaftaran_id = ".$pendaftaran_id."
                LIMIT 1";
        $loadData = Yii::app()->db->createCommand($sql)->queryRow();
        if(!empty($loadData)){
            $data = $loadData;
            $data['tglperiksafisik'] = $format->formatDateTimeForUser($loadData['tglperiksafisik']);
        }
        return $data;
    }
    /**
     * Menampilkan riwayat perisa fisik
     * MA-38
     * @param type pasien_id, bulanperiksa, tahunperiksa
     * @return type
     */
    public function actionGetRiwayatPemeriksaan(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['pasien_id'])&& isset($_GET['bulanpemeriksaan'])&& isset($_GET['tahunpemeriksaan'])){
        $sql = "SELECT pendaftaran_t.no_pendaftaran, pendaftaran_t.pendaftaran_id, pendaftaran_t.tglperiksa, pendaftaran_t.pasien_id,
                ruangan_m.ruangan_id, ruangan_m.ruangan_nama,
                pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
                FROM pendaftaran_t        
                JOIN pegawai_m ON pegawai_m.pegawai_id = pendaftaran_t.pegawai_id
                LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                WHERE pendaftaran_t.pasien_id = ".$_GET['pasien_id']." AND date_part('month',tglperiksa) = ".$_GET['bulanpemeriksaan']." AND date_part('year',tglperiksa) = ".$_GET['tahunpemeriksaan']."
                ORDER BY pendaftaran_t.tglperiksa DESC
                limit 10";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($loadDatas)){
            foreach($loadDatas AS $i => $val){
            $data[$i] = $val;
            $data[$i]['tglperiksa'] = MyFormatter::formatDateTimeForuser(explode(' ',$val['tglperiksa'])[0]);
            $data[$i]['gelardepan'] = $val['gelardepan'];
            $data[$i]['nama_pegawai'] = $val['nama_pegawai'];
            $data[$i]['gelarbelakang_nama'] = $val['gelarbelakang_nama'];
            $data[$i]['ruangan_nama'] = $val['ruangan_nama'];
            $data[$i]['pendaftaran_id'] = $val['pendaftaran_id'];
            $data[$i]['ruangan_id'] = $val['ruangan_id'];
            $data[$i]['no_pendaftaran'] = $val['no_pendaftaran'];
            }
        }
    }
    $encode = CJSON::encode($data);
    echo "jsonCallbackPemeriksaan(".$encode.")";
    Yii::app()->end();
 }
 
    /**
     * Menampilkan riwayat pemakaian obat
     * MA-38
     * @param type pasien_id, bulanobat, tahunobat
     * @return type
     */
    public function actionGetRiwayatPemakaianObat(){
        header("content-type:application/json");
        $data = array();
        if(isset($_GET['pasien_id'])&& isset($_GET['bulanobat'])&& isset($_GET['tahunobat'])){
        $sql = "SELECT ruangan_m.ruangan_nama, penjualanresep_t.noresep, penjualanresep_t.penjualanresep_id, penjualanresep_t.tglpenjualan,
                pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
                pendaftaran_t.pendaftaran_id,pendaftaran_t.no_pendaftaran,
                pasien_m.namadepan, pasien_m.nama_pasien
                FROM penjualanresep_t
                JOIN ruangan_m ON penjualanresep_t.ruangan_id = ruangan_m.ruangan_id
                JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = penjualanresep_t.pendaftaran_id
                JOIN pasien_m ON pasien_m.pasien_id = penjualanresep_t.pasien_id
                JOIN pegawai_m ON pegawai_m.pegawai_id = penjualanresep_t.pegawai_id
                LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                WHERE pasien_m.pasien_id = ".$_GET['pasien_id']." AND date_part('month',tglpenjualan) = ".$_GET['bulanobat']." AND date_part('year',tglpenjualan) = ".$_GET['tahunobat']."
                ORDER BY penjualanresep_t.penjualanresep_id DESC
                limit 10";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($loadDatas)){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tglpenjualan'] = MyFormatter::formatDateTimeForuser(explode(' ',$val['tglpenjualan'])[0]);
                $data[$i]['jampenjualan'] = explode(' ',$val['tglpenjualan'])[1];
                $data[$i]['gelardepan'] = $val['gelardepan'];
                $data[$i]['nama_pegawai'] = $val['nama_pegawai'];
                $data[$i]['gelarbelakang_nama'] = $val['gelarbelakang_nama'];
                $data[$i]['penjualanresep_id'] = $val['penjualanresep_id'];
                $penjualanresepID = $val['penjualanresep_id'];
                $data[$i]['detail'] = array();
                $sql_obat = "SELECT *
                            FROM obatalkespasien_t
                            JOIN obatalkes_m ON obatalkespasien_t.obatalkes_id=obatalkes_m.obatalkes_id
                            WHERE obatalkespasien_t.penjualanresep_id = ".$penjualanresepID." ";
                $loadDataObat = Yii::app()->db->createCommand($sql_obat)->queryAll();
                if(!empty($loadDataObat)){
                    $data[$i]['detail'] = $loadDataObat;
                }
            }
        }
    }
    $encode = CJSON::encode($data);
    echo "jsonCallbackRiwayatObat(".$encode.")";
    Yii::app()->end();
 }

    /**
     * Menampilkan riwayat konsultasi poliklinik
     * MA-38
     * @param type $pendaftaran_id
     * @return type
     */
    protected function getRiwayatKonsultasiPoli($pendaftaran_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "SELECT konsulpoli_t.tglkonsulpoli, konsulpoli_t.statusperiksa, konsulpoli_t.catatan_dokter_konsul, konsulpoli_t.no_antriankonsul,
            asalruangan_m.ruangan_nama AS asalpoliklinik, ruangan_m.ruangan_nama AS tujuankonsul,
            daftartindakan_m.daftartindakan_nama
            FROM konsulpoli_t
            JOIN ruangan_m ON ruangan_m.ruangan_id = konsulpoli_t.ruangan_id
            JOIN ruangan_m asalruangan_m ON asalruangan_m.ruangan_id = konsulpoli_t.asalpoliklinikkonsul_id
            LEFT JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = konsulpoli_t.daftartindakan_id
            WHERE konsulpoli_t.pendaftaran_id = ".$pendaftaran_id;
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tglkonsulpoli'] = $format->formatDateTimeForUser($val['tglkonsulpoli']);
            }
        }
        return $data;
    }

    /**
     * Menampilkan riwayat tindakan (selain karcis)
     * MA-39
     * @param type $pendaftaran_id
     * @return string
     */
    protected function getRiwayatTindakan($pendaftaran_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "SELECT tindakanpelayanan_t.tgl_tindakan, daftartindakan_m.daftartindakan_nama, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, tindakanpelayanan_t.keterangantindakan,
            dokterpemeriksa1_m.gelardepan AS gelardepan_dokter1, dokterpemeriksa1_m.nama_pegawai AS nama_dokter1, gelarbelakangdokter1_m.gelarbelakang_nama AS gelarbelakang_dokter1,
            dokterpemeriksa2_m.gelardepan AS gelardepan_dokter2, dokterpemeriksa2_m.nama_pegawai AS nama_dokter2, gelarbelakangdokter2_m.gelarbelakang_nama AS gelarbelakang_dokter2,
            dokterpendamping_m.gelardepan AS gelardepan_dokterpendamping, dokterpendamping_m.nama_pegawai AS nama_dokterpendamping, gelarbelakangpendamping_m.gelarbelakang_nama AS gelarbelakang_dokterpendamping,
            dokteranastesi_m.gelardepan AS gelardepan_dokteranastesi, dokteranastesi_m.nama_pegawai AS nama_dokteranastesi, gelarbelakangdokteranastesi_m.gelarbelakang_nama AS gelarbelakang_dokteranastesi,
            dokterdelegasi_m.gelardepan AS gelardepan_dokterdelegasi, dokterdelegasi_m.nama_pegawai AS nama_dokterdelegasi, gelarbelakangdokterdelegasi_m.gelarbelakang_nama AS gelarbelakang_dokterdelegasi,
            bidan_m.gelardepan AS gelardepan_bidan, bidan_m.nama_pegawai AS nama_bidan, gelarbelakangbidan_m.gelarbelakang_nama AS gelarbelakang_bidan,
            suster_m.gelardepan AS gelardepan_suster, suster_m.nama_pegawai AS nama_suster, gelarbelakangsuster_m.gelarbelakang_nama AS gelarbelakang_suster,
            perawat_m.gelardepan AS gelardepan_perawat, perawat_m.nama_pegawai AS nama_perawat, gelarbelakangperawat_m.gelarbelakang_nama AS gelarbelakang_perawat
            FROM tindakanpelayanan_t
            JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tindakanpelayanan_t.daftartindakan_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = tindakanpelayanan_t.ruangan_id
            LEFT JOIN pegawai_m dokterpemeriksa1_m ON dokterpemeriksa1_m.pegawai_id = tindakanpelayanan_t.dokterpemeriksa1_id
            LEFT JOIN gelarbelakang_m gelarbelakangdokter1_m ON gelarbelakangdokter1_m.gelarbelakang_id = dokterpemeriksa1_m.gelarbelakang_id
            LEFT JOIN pegawai_m dokterpemeriksa2_m ON dokterpemeriksa2_m.pegawai_id = tindakanpelayanan_t.dokterpemeriksa2_id
            LEFT JOIN gelarbelakang_m gelarbelakangdokter2_m ON gelarbelakangdokter2_m.gelarbelakang_id = dokterpemeriksa2_m.gelarbelakang_id
            LEFT JOIN pegawai_m dokterpendamping_m ON dokterpendamping_m.pegawai_id = tindakanpelayanan_t.dokterpendamping_id
            LEFT JOIN gelarbelakang_m gelarbelakangpendamping_m ON gelarbelakangpendamping_m.gelarbelakang_id = dokterpendamping_m.gelarbelakang_id
            LEFT JOIN pegawai_m dokteranastesi_m ON dokteranastesi_m.pegawai_id = tindakanpelayanan_t.dokteranastesi_id
            LEFT JOIN gelarbelakang_m gelarbelakangdokteranastesi_m ON gelarbelakangdokteranastesi_m.gelarbelakang_id = dokteranastesi_m.gelarbelakang_id
            LEFT JOIN pegawai_m dokterdelegasi_m ON dokterdelegasi_m.pegawai_id = tindakanpelayanan_t.dokterdelegasi_id
            LEFT JOIN gelarbelakang_m gelarbelakangdokterdelegasi_m ON gelarbelakangdokterdelegasi_m.gelarbelakang_id = dokterdelegasi_m.gelarbelakang_id
            LEFT JOIN pegawai_m bidan_m ON bidan_m.pegawai_id = tindakanpelayanan_t.bidan_id
            LEFT JOIN gelarbelakang_m gelarbelakangbidan_m ON gelarbelakangbidan_m.gelarbelakang_id = bidan_m.gelarbelakang_id
            LEFT JOIN pegawai_m suster_m ON suster_m.pegawai_id = tindakanpelayanan_t.suster_id
            LEFT JOIN gelarbelakang_m gelarbelakangsuster_m ON gelarbelakangsuster_m.gelarbelakang_id = suster_m.gelarbelakang_id
            LEFT JOIN pegawai_m perawat_m ON perawat_m.pegawai_id = tindakanpelayanan_t.perawat_id
            LEFT JOIN gelarbelakang_m gelarbelakangperawat_m ON gelarbelakangperawat_m.gelarbelakang_id = perawat_m.gelarbelakang_id
            WHERE tindakanpelayanan_t.karcis_id IS NULL
                AND tindakanpelayanan_t.pendaftaran_id = ".$pendaftaran_id."
            ORDER BY ruangan_m.ruangan_nourut ASC, ruangan_m.ruangan_nama ASC, tindakanpelayanan_t.tgl_tindakan ASC, daftartindakan_m.daftartindakan_nama ASC";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tgl_tindakan'] = $format->formatDateTimeForUser($val['tgl_tindakan']);
                $data[$i]['nama_dokter1'] = $val['gelardepan_dokter1']." ".$val['nama_dokter1']." ".$val['gelarbelakang_dokter1'];
                $data[$i]['nama_dokter2'] = $val['gelardepan_dokter2']." ".$val['nama_dokter2']." ".$val['gelarbelakang_dokter2'];
                $data[$i]['nama_dokterpendamping'] = $val['gelardepan_dokterpendamping']." ".$val['nama_dokterpendamping']." ".$val['gelarbelakang_dokterpendamping'];
                $data[$i]['nama_dokteranastesi'] = $val['gelardepan_dokteranastesi']." ".$val['nama_dokteranastesi']." ".$val['gelarbelakang_dokteranastesi'];
                $data[$i]['nama_dokterdelegasi'] = $val['gelardepan_dokterdelegasi']." ".$val['nama_dokterdelegasi']." ".$val['gelarbelakang_dokterdelegasi'];
                $data[$i]['nama_bidan'] = $val['gelardepan_bidan']." ".$val['nama_bidan']." ".$val['gelarbelakang_bidan'];
                $data[$i]['nama_suster'] = $val['gelardepan_suster']." ".$val['nama_suster']." ".$val['gelarbelakang_suster'];
                $data[$i]['nama_perawat'] = $val['gelardepan_perawat']." ".$val['nama_perawat']." ".$val['gelarbelakang_perawat'];
            }
        }
        return $data;
    }

    /**
     * Menampilkan riwayat rujukan keluar
     * MA-50
     * @param type $pendaftaran_id
     * @return type
     */
    protected function getRiwayatRujukanKeluar($pendaftaran_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "SELECT pasiendirujukkeluar_t.*, rujukankeluar_m.rumahsakitrujukan, instalasi_m.instalasi_nama AS instalasiasal_nama, ruangan_m.ruangan_nama AS ruanganasal_nama
            FROM pasiendirujukkeluar_t
            JOIN rujukankeluar_m ON rujukankeluar_m.rujukankeluar_id = pasiendirujukkeluar_t.rujukankeluar_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = pasiendirujukkeluar_t.ruanganasal_id
            JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id
            WHERE pasiendirujukkeluar_t.pendaftaran_id = ".$pendaftaran_id;
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tgldirujuk'] = $format->formatDateTimeForUser($val['tgldirujuk']);
            }
        }
        return $data;
    }
    /**
     * Menampilkan riwayat rujukan keluar
     * MA-49
     * @param type $pendaftaran_id
     * @return type
     */
    protected function getRiwayatReseptur($pendaftaran_id){
        
        $format = new MyFormatter();
        $data = array();
        
        $sql = "SELECT ruangan_m.ruangan_nama, ruanganreseptur_m.ruangan_nama AS ruanganreseptur_nama,
            pegawai_m.gelardepan, pegawai_m.nama_pegawai AS nama_dokterresep, gelarbelakang_m.gelarbelakang_nama ,
            reseptur_t.reseptur_id, reseptur_t.tglreseptur, reseptur_t.noresep, reseptur_t.fileresep,
            unitdosis_t.nounitdosis, unitdosis_t.tgluntidosis, unitdosis_t.beratbadan_kg, unitdosis_t.tinggibadan_cm, unitdosis_t.alergiobat, ruanganunitdosis_m.ruangan_nama AS ruanganunitdosis_nama
            FROM reseptur_t
            JOIN ruangan_m ON ruangan_m.ruangan_id = reseptur_t.ruangan_id
            JOIN ruangan_m ruanganreseptur_m ON ruanganreseptur_m.ruangan_id = reseptur_t.ruanganreseptur_id
            JOIN pegawai_m ON pegawai_m.pegawai_id = reseptur_t.pegawai_id
            LEFT JOIN unitdosis_t ON unitdosis_t.unitdosis_id = reseptur_t.unitdosis_id
            LEFT JOIN ruangan_m ruanganunitdosis_m ON ruanganunitdosis_m.ruangan_id = unitdosis_t.ruanganunitdosis_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            WHERE reseptur_t.pendaftaran_id = ".$pendaftaran_id;
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tglreseptur'] = $format->formatDateTimeForUser($val['tglreseptur']);
                // $data[$i]['tgluntidosis'] = $format->formatDateTimeForUser($val['tgluntidosis']);
                $data[$i]['nama_dokterresep'] = $val['gelardepan']." ".$val['nama_dokterresep']." ".$val['gelarbelakang_nama'];
                $data[$i]['resepdetail'] = array();
                $sql_det = "SELECT
                    resepturdetail_t.r, resepturdetail_t.rke, resepturdetail_t.permintaan_reseptur, resepturdetail_t.jmlkemasan_reseptur, resepturdetail_t.kekuatan_reseptur, resepturdetail_t.satuankekuatan, resepturdetail_t.signa_reseptur, resepturdetail_t.etiket, resepturdetail_t.qty_reseptur, resepturdetail_t.hargasatuan_reseptur, obatalkes_m.obatalkes_nama, satuankecil_m.satuankecil_nama
                    FROM resepturdetail_t
                    JOIN obatalkes_m ON obatalkes_m.obatalkes_id = resepturdetail_t.obatalkes_id
                    JOIN satuankecil_m ON satuankecil_m.satuankecil_id = resepturdetail_t.satuankecil_id
                    WHERE resepturdetail_t.reseptur_id = ".$val['reseptur_id'];
                $loadDataDets = Yii::app()->db->createCommand($sql_det)->queryAll();
                if(count($loadDataDets) > 0){
                    $data[$i]['resepdetail'] = $loadDataDets;
                }
            }
        }
        return $data;
 }
 
 public function actionGetRiwayatResep(){
    header("content-type:application/json");
    $format = new MyFormatter();
    $data = array();
    if(isset($_GET['pasien_id'])&& isset($_GET['bulanreseptur'])&& isset($_GET['tahunreseptur'])){        
    $sql = "SELECT ruangan_m.ruangan_nama, ruanganreseptur_m.ruangan_nama AS ruanganreseptur_nama,
            pasien_m.nama_pasien, resepturdetail_t.jmlkemasan_reseptur, resepturdetail_t.qty_reseptur, resepturdetail_t.hargasatuan_reseptur, obatalkes_m.obatalkes_nama,
            pegawai_m.gelardepan, pegawai_m.nama_pegawai AS nama_dokterresep, gelarbelakang_m.gelarbelakang_nama ,
            reseptur_t.reseptur_id, reseptur_t.tglreseptur, reseptur_t.noresep, reseptur_t.fileresep
            FROM reseptur_t
            JOIN ruangan_m ON ruangan_m.ruangan_id = reseptur_t.ruangan_id
            JOIN pasien_m ON pasien_m.pasien_id = reseptur_t.pasien_id
            JOIN ruangan_m ruanganreseptur_m ON ruanganreseptur_m.ruangan_id = reseptur_t.ruanganreseptur_id
            JOIN resepturdetail_t ON resepturdetail_t.reseptur_id = reseptur_t.reseptur_id
            LEFT JOIN obatalkes_m ON obatalkes_m.obatalkes_id = resepturdetail_t.obatalkes_id
            JOIN pegawai_m ON pegawai_m.pegawai_id = reseptur_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            WHERE pasien_m.pasien_id = ".$_GET['pasien_id']." AND date_part('month',tglreseptur) = ".$_GET['bulanreseptur']." AND date_part('year',tglreseptur) = ".$_GET['tahunreseptur']."
            ORDER BY reseptur_t.tglreseptur DESC
            limit 10";
    $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
    if(!empty($loadDatas)){
        foreach($loadDatas AS $i => $val){
            $data[$i] = $val;
        }
    }
    }
    $encode = CJSON::encode($data);
    echo "jsonCallbackResep(".$encode.")";
    Yii::app()->end();
 }
 
 /**
     * Menampilkan riwayat diagnosa
     * MA-38
     * @param type pasien_id, bulandiagnosa, tahundiagnosa
     * @return json
     */
    public function actionGetRiwayatDiagnosa(){
    header("content-type:application/json");
    $format = new MyFormatter();
    $data = array();
    if(isset($_GET['pasien_id'])&& isset($_GET['bulandiagnosa'])&& isset($_GET['tahundiagnosa'])){
        $sql = "SELECT morfologineoplasma_m.morfologineoplasma_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_nama, ruangan_m.ruangan_nama, kamarruangan_m.kamarruangan_nokamar, kamarruangan_m.kamarruangan_nobed,
                diagnosaicdix_m.diagnosaicdix_kode, diagnosaicdix_m.diagnosaicdix_nama,
                sebabdiagnosa_m.sebabdiagnosa_nama,
                kelompokumur_m.kelompokumur_nama,
                golonganumur_m.golonganumur_nama,
                diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,
                sebabin_m.sebabin_nama,
                penyebabluarcedera_m.penyebabluarcedera_nama,
                pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.kasusdiagnosa, pasienmorbiditas_t.infeksinosokomial,
                pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
                pasien_m.nama_pasien, pendaftaran_t.no_pendaftaran
                FROM pasienmorbiditas_t
                LEFT JOIN morfologineoplasma_m ON morfologineoplasma_m.morfologineoplasma_id = pasienmorbiditas_t.morfologineoplasma_id
                JOIN jeniskasuspenyakit_m ON jeniskasuspenyakit_m.jeniskasuspenyakit_id = pasienmorbiditas_t.jeniskasuspenyakit_id
                JOIN pasien_m ON pasien_m.pasien_id = pasienmorbiditas_t.pasien_id
                JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienmorbiditas_t.pendaftaran_id
                JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmorbiditas_t.ruangan_id
                LEFT JOIN kamarruangan_m ON kamarruangan_m.kamarruangan_id = pasienmorbiditas_t.kamarruangan_id
                LEFT JOIN diagnosaicdix_m ON diagnosaicdix_m.diagnosaicdix_id = pasienmorbiditas_t.diagnosaicdix_id
                LEFT JOIN sebabdiagnosa_m ON sebabdiagnosa_m.sebabdiagnosa_id = pasienmorbiditas_t.sebabdiagnosa_id
                JOIN kelompokumur_m ON kelompokumur_m.kelompokumur_id = pasienmorbiditas_t.kelompokumur_id
                JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
                LEFT JOIN sebabin_m ON sebabin_m.sebabin_id = pasienmorbiditas_t.sebabin_id
                JOIN golonganumur_m ON golonganumur_m.golonganumur_id = pasienmorbiditas_t.golonganumur_id
                LEFT JOIN penyebabluarcedera_m ON penyebabluarcedera_m.penyebabluarcedera_id = pasienmorbiditas_t.penyebabluarcedera_id
                JOIN pegawai_m ON pegawai_m.pegawai_id = pasienmorbiditas_t.pegawai_id
                LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                WHERE pasien_m.pasien_id = ".$_GET['pasien_id']." AND date_part('month',tglmorbiditas) = ".$_GET['bulandiagnosa']." AND date_part('year',tglmorbiditas) = ".$_GET['tahundiagnosa']."
                ORDER BY pasienmorbiditas_t.tglmorbiditas DESC
                limit 10";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($loadDatas)){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
            }
        }
    }
    $encode = CJSON::encode($data);
    echo "jsonCallbackDaignosa(".$encode.")";
    Yii::app()->end();
 }

    /**
     * Menampilkan riwayat morbiditas (diagnosis)
     * MA-55
     * @param type $pendaftaran_id
     * @return type
     */
    protected function getRiwayatMorbiditas($pendaftaran_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "SELECT morfologineoplasma_m.morfologineoplasma_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_nama, ruangan_m.ruangan_nama, kamarruangan_m.kamarruangan_nokamar, kamarruangan_m.kamarruangan_nobed,
            diagnosaicdix_m.diagnosaicdix_kode, diagnosaicdix_m.diagnosaicdix_nama,
            sebabdiagnosa_m.sebabdiagnosa_nama,
            kelompokumur_m.kelompokumur_nama,
            golonganumur_m.golonganumur_nama,
            diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,
            sebabin_m.sebabin_nama,
            penyebabluarcedera_m.penyebabluarcedera_nama,
            pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.kasusdiagnosa, pasienmorbiditas_t.infeksinosokomial,
            pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
            FROM pasienmorbiditas_t
            LEFT JOIN morfologineoplasma_m ON morfologineoplasma_m.morfologineoplasma_id = pasienmorbiditas_t.morfologineoplasma_id
            JOIN jeniskasuspenyakit_m ON jeniskasuspenyakit_m.jeniskasuspenyakit_id = pasienmorbiditas_t.jeniskasuspenyakit_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmorbiditas_t.ruangan_id
            LEFT JOIN kamarruangan_m ON kamarruangan_m.kamarruangan_id = pasienmorbiditas_t.kamarruangan_id
            LEFT JOIN diagnosaicdix_m ON diagnosaicdix_m.diagnosaicdix_id = pasienmorbiditas_t.diagnosaicdix_id
            LEFT JOIN sebabdiagnosa_m ON sebabdiagnosa_m.sebabdiagnosa_id = pasienmorbiditas_t.sebabdiagnosa_id
            JOIN kelompokumur_m ON kelompokumur_m.kelompokumur_id = pasienmorbiditas_t.kelompokumur_id
            JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
            LEFT JOIN sebabin_m ON sebabin_m.sebabin_id = pasienmorbiditas_t.sebabin_id
            JOIN golonganumur_m ON golonganumur_m.golonganumur_id = pasienmorbiditas_t.golonganumur_id
            LEFT JOIN penyebabluarcedera_m ON penyebabluarcedera_m.penyebabluarcedera_id = pasienmorbiditas_t.penyebabluarcedera_id
            JOIN pegawai_m ON pegawai_m.pegawai_id = pasienmorbiditas_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            WHERE pasienmorbiditas_t.pendaftaran_id = ".$pendaftaran_id;
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tglmorbiditas'] = $format->formatDateTimeForUser($val['tglmorbiditas']);
                $data[$i]['nama_pegawai'] = $val['gelardepan']." ".$val['nama_pegawai']." ".$val['gelarbelakang_nama'];
            }
        }
        return $data;
    }

    /**
     * menampilkan berita terbaru
     * MA-17
     * @param $_GET['q']
     * @return json
     */
    public function actionGetBeritaTerbaru(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
        $sql = "SELECT mkategoriberita_m.* , mberita_m.*
            FROM mberita_m
            JOIN mkategoriberita_m ON mkategoriberita_m.mkategoriberita_id = mberita_m.mkategoriberita_id
            WHERE
            LOWER(mberita_m.judulberita) like '%".$req."%'
            OR LOWER(mberita_m.ringkasanberita) like '%".$req."%'
            OR LOWER(mberita_m.isiberita) like '%".$req."%'
            OR LOWER(mkategoriberita_m.kategoriberita) like '%".$req."%'
            OR LOWER(mkategoriberita_m.ketkategoriberita) like '%".$req."%'
            AND (mberita_m.waktutampilberita > '".date("Y-m-d H:i:s")."')
            ORDER BY mberita_m.waktutampilberita DESC
            LIMIT 10
            ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i]= $val;
                $data[$i]['gambarberita_path']= (!empty($val['gambarberita_path']) ? Params::urlBerita().$val['gambarberita_path'] : "");
                $data[$i]['komentarberita'] = array();
                $sql_det = "SELECT *
                    FROM mberitakomentar_t
                    WHERE mberitakomentar_t.mberita_id = ".$val['mberita_id']."
                    ORDER BY mberitakomentar_t.tglkomentar DESC
                    LIMIT 5
                    ";
                $loadDataDets = Yii::app()->db->createCommand($sql_det)->queryAll();
                if(count($loadDataDets) > 0){
                    foreach($loadDataDets AS $ii => $komentar){
                        $data[$i]['komentarberita'][$ii] = $komentar;
                        $data[$i]['komentarberita'][$ii]['tglkomentar'] = $format->formatDateTimeForUser($komentar['tglkomentar']);
                    }
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan dokter berdasarkan ruangan yang jadwalnya hari ini
     */
    public function actionGetJadwalDokter(){
        header("content-type:application/json");
        $data = array();
        $sql = " SELECT pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, jadwaldokter_m.pegawai_id, jadwaldokter_m.ruangan_id
            FROM pegawai_m
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            LEFT JOIN jadwaldokter_m ON jadwaldokter_m.pegawai_id = pegawai_m.pegawai_id
            WHERE
                pegawai_m.kelompokpegawai_id = ".Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP." AND
                jadwaldokter_m.jadwaldokter_hari = '".CustomFunction::getHariByNomorMobile(date('w', strtotime('+1 day')))."'
            GROUP BY pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, jadwaldokter_m.pegawai_id, jadwaldokter_m.ruangan_id ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($loadDatas)){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['gelardepan'] = !empty($val['gelardepan'])?$val['gelardepan']:'';
                $data[$i]['gelarbelakang_nama'] = !empty($val['gelarbelakang_nama'])?$val['gelarbelakang_nama']:'';
                $data[$i]['poliklinik'] = array();
                $sql_poli = "SELECT instalasi_m.instalasi_id, instalasi_m.instalasi_nama, ruangan_m.ruangan_id, ruangan_m.ruangan_nama
                    FROM ruanganpegawai_m
                    JOIN ruangan_m ON ruangan_m.ruangan_id = ruanganpegawai_m.ruangan_id
                    JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id
                    WHERE
                        ruangan_m.instalasi_id = ".Params::INSTALASI_ID_RJ."
                        AND ruanganpegawai_m.ruangan_id = ".$val['ruangan_id']."
                    GROUP BY ruangan_m.ruangan_id, ruangan_m.ruangan_nama, instalasi_m.instalasi_id, instalasi_m.instalasi_nama
                    ORDER BY ruangan_m.ruangan_nama ASC
                ";
                $loadDataPolis = Yii::app()->db->createCommand($sql_poli)->queryAll();
                if(!empty($loadDataPolis)){
                    $data[$i]['poliklinik'] = $loadDataPolis;
                }
            }
        }
        
        $encode = CJSON::encode($data);
        echo "jsonCallbackJadwalDokter(".$encode.")";
        Yii::app()->end();

    }
    
    /**
     * cek tanggal
     * @param : $_GET['tglharilibur']
     * @return json array
     */
    public function actionGetJadwalBukaPoli(){
        header("content-type:application/json");
        $data = array();
        $dokter_id = !empty($_GET['dokter_id'])?$_GET['dokter_id']:'';
        $sql = "SELECT jadwaldokter_m.jadwaldokter_id, jadwaldokter_m.pegawai_id, jadwaldokter_m.jadwaldokter_hari, jadwaldokter_m.ruangan_id, jadwaldokter_m.jadwaldokter_mulai, jadwaldokter_m.jadwaldokter_tutup, pegawai_m.pegawai_id from pegawai_m
                LEFT JOIN jadwaldokter_m ON jadwaldokter_m.pegawai_id = pegawai_m.pegawai_id
                LEFT JOIN buatjanjipoli_t ON buatjanjipoli_t.jadwaldokter_id = jadwaldokter_m.jadwaldokter_id
                WHERE pegawai_m.pegawai_id = ".$dokter_id." AND jadwaldokter_m.jadwaldokter_hari = '".CustomFunction::getHariByNomorMobile(date('w', strtotime('+1 day')))."'
                GROUP BY jadwaldokter_m.jadwaldokter_id, jadwaldokter_m.pegawai_id, jadwaldokter_m.jadwaldokter_hari, jadwaldokter_m.ruangan_id, jadwaldokter_m.jadwaldokter_mulai, jadwaldokter_m.jadwaldokter_tutup, pegawai_m.pegawai_id ";
        $loadData = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($loadData)){
            foreach($loadData AS $i => $val){
                $data[$i] = $val;
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackGetJadwalPoli(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * set form Asal Rujukan load di mobile
     * @param $_GET['pasien_id']
     * @return json
     */
    public function actionGetCaraBayar(){
        header("content-type:application/json");
        $data = array();
        $sql = "SELECT * FROM carabayar_m WHERE carabayar_aktif = true ORDER BY carabayar_nama ASC";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        $data['carabayars'] = array();
        if(!empty($loadDatas)){
            $data['carabayars'] = $loadDatas;
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackCaraBayarJanji(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan penjamin pasien
     * @params $_GET['pasien_id']
     */
    public function actionGetPenjamin(){
        header("content-type:application/json");
        $data = array();
        $sql = "SELECT * from penjaminpasien_m WHERE penjamin_aktif = true ORDER BY penjamin_nama ASC ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($loadDatas)){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['carabayar'] = array();
                $sql_poli = "SELECT carabayar_m.carabayar_id, carabayar_m.carabayar_nama from carabayar_m
                    JOIN penjaminpasien_m ON carabayar_m.carabayar_id = penjaminpasien_m.carabayar_id
                    WHERE penjaminpasien_m.carabayar_id = ".$val['carabayar_id']."
                    GROUP BY carabayar_m.carabayar_id, carabayar_m.carabayar_nama ";
                $loadDataPolis = Yii::app()->db->createCommand($sql_poli)->queryAll();
                if(!empty($loadDataPolis)){
                    $data[$i]['carabayar'] = $loadDataPolis;
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackPenjamin(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * cek tanggal
     * @param : $_GET['tglharilibur']
     * @return json array
     */
    public function actionGetCaraBayarAsuransi(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['carabayar_id']) && isset($_GET['buatjanjipoli_id'])){
            $carabayar_id = $_GET['carabayar_id'];
            $buatjanjipoli_id = $_GET['buatjanjipoli_id'];
            $sql = "SELECT * from buatjanjipoli_t
                    WHERE carabayar_id = ".$carabayar_id." AND buatjanjipoli_id = ".$buatjanjipoli_id." ";
            $loadData = Yii::app()->db->createCommand($sql)->queryRow();
            if(!empty($loadData)){
                foreach($loadData AS $i => $val){
                    $data[$i] = $val;
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackKartuAsuransi(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan profil dokter berdasarkan pencarian
     * @params $_GET['q']
     * MA-56
     */
    public function actionGetProfilDokter(){
        header("content-type:application/json");
        $req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
        $data = array();
        $sql = "SELECT pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, pegawai_m.nomorindukpegawai, pegawai_m.tempatlahir_pegawai, pegawai_m.tgl_lahirpegawai, pegawai_m.jeniskelamin, pegawai_m.statusperkawinan,
            pegawai_m.alamat_pegawai, kelurahan_m.kelurahan_nama, kecamatan_m.kecamatan_nama, kabupaten_m.kabupaten_nama, propinsi_m.propinsi_nama,
            pegawai_m.alamatemail, pegawai_m.nomobile_pegawai, pegawai_m.notelp_pegawai, pegawai_m.photopegawai, pegawai_m.suratizinpraktek, pegawai_m.deskripsi, jadwaldokter_m.jadwaldokter_mulai, jadwaldokter_m.jadwaldokter_tutup 
            FROM pegawai_m
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            LEFT JOIN propinsi_m ON propinsi_m.propinsi_id =  pegawai_m.propinsi_id
            LEFT JOIN kabupaten_m ON kabupaten_m.kabupaten_id =  pegawai_m.kabupaten_id
            LEFT JOIN kecamatan_m ON kecamatan_m.kecamatan_id =  pegawai_m.kecamatan_id
            LEFT JOIN kelurahan_m ON kelurahan_m.kelurahan_id =  pegawai_m.kelurahan_id
            LEFT JOIN jadwaldokter_m ON jadwaldokter_m.pegawai_id =  pegawai_m.pegawai_id
            WHERE
                kelompokpegawai_id = ".Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP."
                AND (LOWER(pegawai_m.nama_pegawai) LIKE '%".$req."%'
                OR LOWER(pegawai_m.nomorindukpegawai) LIKE '%".$req."%')                
            GROUP BY pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, pegawai_m.nomorindukpegawai, pegawai_m.tempatlahir_pegawai, pegawai_m.tgl_lahirpegawai, pegawai_m.jeniskelamin, pegawai_m.statusperkawinan,
            pegawai_m.alamat_pegawai, kelurahan_m.kelurahan_nama, kecamatan_m.kecamatan_nama, kabupaten_m.kabupaten_nama, propinsi_m.propinsi_nama,
            pegawai_m.alamatemail, pegawai_m.nomobile_pegawai, pegawai_m.notelp_pegawai, pegawai_m.photopegawai, pegawai_m.suratizinpraktek, pegawai_m.deskripsi, jadwaldokter_m.jadwaldokter_mulai, jadwaldokter_m.jadwaldokter_tutup";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['url_photopegawai'] = !empty($val['photopegawai'])?Params::urlPegawaiDirectory().$val['photopegawai']:Params::urlPegawaiDirectory().'no_photo.jpeg';
                $data[$i]['url_thumb_photopegawai'] = !empty($val['photopegawai'])?Params::urlPegawaiTumbsDirectory()."kecil_".$val['photopegawai']:Params::urlPegawaiDirectory().'no_photo.jpeg';
                $data[$i]['poliklinik'] = "";
                $sql_poli = "SELECT instalasi_m.instalasi_id, instalasi_m.instalasi_nama, ruangan_m.ruangan_id, ruangan_m.ruangan_nama
                    FROM ruanganpegawai_m
                    JOIN ruangan_m ON ruangan_m.ruangan_id = ruanganpegawai_m.ruangan_id
                    JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id
                    WHERE
                        ruangan_m.instalasi_id = ".Params::INSTALASI_ID_RJ."
                        AND ruanganpegawai_m.pegawai_id = ".$val['pegawai_id']."
                    ORDER BY ruangan_m.ruangan_nama ASC
                ";
                $loadDataPolis = Yii::app()->db->createCommand($sql_poli)->queryAll();
                if(count($loadDataPolis > 0)){
                    $data[$i]['poliklinik'] = $loadDataPolis;
                }
                $data[$i]['pendidikan'] = "";
                $sql_pendidikan = "SELECT pendidikanpegawai_r.nourut_pend, pendidikan_m.pendidikan_nama, pendidikanpegawai_r.jenispendidikan, pendidikanpegawai_r.namasek_univ, pendidikanpegawai_r.almtsek_univ, kabupaten_m.kabupaten_nama, propinsi_m.propinsi_nama,
                    pendidikanpegawai_r.tglmasuk, pendidikanpegawai_r.tgllulus, pendidikanpegawai_r.lamapendidikan_bln, pendidikanpegawai_r.keteranganpend
                    FROM pendidikanpegawai_r
                    LEFT JOIN pendidikan_m ON pendidikan_m.pendidikan_id = pendidikanpegawai_r.pendidikan_id
                    LEFT JOIN kabupaten_m ON kabupaten_m.kabupaten_id = pendidikanpegawai_r.kabupaten_id
                    LEFT JOIN propinsi_m ON propinsi_m.propinsi_id = pendidikanpegawai_r.propinsi_id
                    WHERE pendidikanpegawai_r.pegawai_id = ".$val['pegawai_id']."
                    ORDER BY pendidikanpegawai_r.nourut_pend ASC
                ";
                $loadDataPendidikans = Yii::app()->db->createCommand($sql_pendidikan)->queryAll();
                if(count($loadDataPendidikans > 0)){
                    $data[$i]['pendidikan'] = $loadDataPendidikans;
                }
                $data[$i]['pengalamankerja'] = "";
                $sql_kerja = "SELECT pengalamankerja_r.pengalamankerja_nourut,pengalamankerja_r.namaperusahaan, pengalamankerja_r.bidangperusahaan, pengalamankerja_r.jabatanterahkir, pengalamankerja_r.tglmasuk, pengalamankerja_r.tglkeluar, pengalamankerja_r.lama_tahun, pengalamankerja_r.lama_bulan, pengalamankerja_r.keterangan
                    FROM pengalamankerja_r
                    WHERE pengalamankerja_r.pegawai_id = ".$val['pegawai_id']."
                    ORDER BY pengalamankerja_r.pengalamankerja_nourut ASC
                ";
                $loadDataKerjas = Yii::app()->db->createCommand($sql_kerja)->queryAll();
                if(count($loadDataPendidikans > 0)){
                    $data[$i]['pengalamankerja'] = $loadDataKerjas;
                }
                $data[$i]['rateaverage'] = 0;
                $sql_rate = "SELECT ratedokter_t.pegawai_id, AVG(ratedokter) AS rateaverage
                    FROM ratedokter_t
                    WHERE ratedokter_t.pegawai_id = ".$val['pegawai_id']."
                    GROUP BY ratedokter_t.pegawai_id
                ";
                $loadDataRate = Yii::app()->db->createCommand($sql_rate)->queryRow();
                if(isset($loadDataRate['rateaverage'])){
                    $data[$i]['rateaverage'] = $loadDataRate['rateaverage'];
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackDokter(".$encode.")";
        Yii::app()->end();

    } 
    
    /**
     * menampilkan profil dokter berdasarkan pencarian
     * @params $_GET['q']
     * MA-56
     */
    public function actionGetProfilDok(){
        header("content-type:application/json");
        $req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
        $data = array();
        $sql = "SELECT pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, pegawai_m.nomorindukpegawai, pegawai_m.tempatlahir_pegawai, pegawai_m.tgl_lahirpegawai, pegawai_m.jeniskelamin, pegawai_m.statusperkawinan,
            pegawai_m.alamat_pegawai, kelurahan_m.kelurahan_nama, kecamatan_m.kecamatan_nama, kabupaten_m.kabupaten_nama, propinsi_m.propinsi_nama,
            pegawai_m.alamatemail, pegawai_m.nomobile_pegawai, pegawai_m.notelp_pegawai, pegawai_m.photopegawai, pegawai_m.suratizinpraktek, pegawai_m.deskripsi, pegawai_m.kelompokpegawai_id, jadwaldokter_m.jadwaldokter_id, jadwaldokter_m.pegawai_id, jadwaldokter_m.instalasi_id, jadwaldokter_m.ruangan_id, jadwaldokter_m.jadwaldokter_hari, 
            jadwaldokter_m.jadwaldokter_buka, jadwaldokter_m.jadwaldokter_mulai, jadwaldokter_m.jadwaldokter_tutup
            FROM pegawai_m
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            LEFT JOIN propinsi_m ON propinsi_m.propinsi_id =  pegawai_m.propinsi_id
            LEFT JOIN kabupaten_m ON kabupaten_m.kabupaten_id =  pegawai_m.kabupaten_id
            LEFT JOIN kecamatan_m ON kecamatan_m.kecamatan_id =  pegawai_m.kecamatan_id
            LEFT JOIN kelurahan_m ON kelurahan_m.kelurahan_id =  pegawai_m.kelurahan_id
            LEFT JOIN kelompokpegawai_m ON kelompokpegawai_m.kelompokpegawai_id =  pegawai_m.kelompokpegawai_id
            JOIN pegawai_m on pegawai_m.pegawai_id = jadwaldokter_m.pegawai_id
            WHERE
               pegawai_m.kelompokpegawai_id = 1
                AND (LOWER(kelompokpegawai_fungsi) LIKE '%".$req."%')                
            ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($loadDatas)){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['url_photopegawai'] = !empty($val['photopegawai'])?Params::urlPegawaiDirectory().$val['photopegawai']:Params::urlPegawaiDirectory().'no_photo.jpeg';
                $data[$i]['url_thumb_photopegawai'] = !empty($val['photopegawai'])?Params::urlPegawaiTumbsDirectory()."kecil_".$val['photopegawai']:Params::urlPegawaiDirectory().'no_photo.jpeg';
                $data[$i]['poliklinik'] = "";
                $sql_poli = "SELECT instalasi_m.instalasi_id, instalasi_m.instalasi_nama, ruangan_m.ruangan_id, ruangan_m.ruangan_nama
                    FROM ruanganpegawai_m
                    JOIN ruangan_m ON ruangan_m.ruangan_id = ruanganpegawai_m.ruangan_id
                    JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id
                    WHERE
                        ruangan_m.instalasi_id = ".Params::INSTALASI_ID_RJ."
                        AND ruanganpegawai_m.pegawai_id = ".$val['pegawai_id']."
                    ORDER BY ruangan_m.ruangan_nama ASC
                ";
                $loadDataPolis = Yii::app()->db->createCommand($sql_poli)->queryAll();
                if(!empty($loadDataPolis)){
                    $data[$i]['poliklinik'] = $loadDataPolis;
                }
                $data[$i]['pendidikan'] = "";
                $sql_pendidikan = "SELECT pendidikanpegawai_r.nourut_pend, pendidikan_m.pendidikan_nama, pendidikanpegawai_r.jenispendidikan, pendidikanpegawai_r.namasek_univ, pendidikanpegawai_r.almtsek_univ, kabupaten_m.kabupaten_nama, propinsi_m.propinsi_nama,
                    pendidikanpegawai_r.tglmasuk, pendidikanpegawai_r.tgllulus, pendidikanpegawai_r.lamapendidikan_bln, pendidikanpegawai_r.keteranganpend
                    FROM pendidikanpegawai_r
                    LEFT JOIN pendidikan_m ON pendidikan_m.pendidikan_id = pendidikanpegawai_r.pendidikan_id
                    LEFT JOIN kabupaten_m ON kabupaten_m.kabupaten_id = pendidikanpegawai_r.kabupaten_id
                    LEFT JOIN propinsi_m ON propinsi_m.propinsi_id = pendidikanpegawai_r.propinsi_id
                    WHERE pendidikanpegawai_r.pegawai_id = ".$val['pegawai_id']."
                    ORDER BY pendidikanpegawai_r.nourut_pend ASC
                ";
                $loadDataPendidikans = Yii::app()->db->createCommand($sql_pendidikan)->queryAll();
                if(!empty($loadDataPendidikans)){
                    $data[$i]['pendidikan'] = $loadDataPendidikans;
                }
                $data[$i]['pengalamankerja'] = "";
                $sql_kerja = "SELECT pengalamankerja_r.pengalamankerja_nourut,pengalamankerja_r.namaperusahaan, pengalamankerja_r.bidangperusahaan, pengalamankerja_r.jabatanterahkir, pengalamankerja_r.tglmasuk, pengalamankerja_r.tglkeluar, pengalamankerja_r.lama_tahun, pengalamankerja_r.lama_bulan, pengalamankerja_r.keterangan
                    FROM pengalamankerja_r
                    WHERE pengalamankerja_r.pegawai_id = ".$val['pegawai_id']."
                    ORDER BY pengalamankerja_r.pengalamankerja_nourut ASC
                ";
                $loadDataKerjas = Yii::app()->db->createCommand($sql_kerja)->queryAll();
                if(!empty($loadDataPendidikans)){
                    $data[$i]['pengalamankerja'] = $loadDataKerjas;
                }
                $data[$i]['rateaverage'] = 0;
                $sql_rate = "SELECT ratedokter_t.pegawai_id, AVG(ratedokter) AS rateaverage
                    FROM ratedokter_t
                    WHERE ratedokter_t.pegawai_id = ".$val['pegawai_id']."
                    GROUP BY ratedokter_t.pegawai_id
                ";
                $loadDataRate = Yii::app()->db->createCommand($sql_rate)->queryRow();
                if(isset($loadDataRate['rateaverage'])){
                    $data[$i]['rateaverage'] = $loadDataRate['rateaverage'];
                }
                
                $data[$i]['jadwaldokter'] = "";
                $sql_jadwal = "
                        select jadwaldokter_m.jadwaldokter_id, jadwaldokter_m.pegawai_id, jadwaldokter_m.instalasi_id, jadwaldokter_m.ruangan_id, jadwaldokter_m.jadwaldokter_hari, 
                        jadwaldokter_m.jadwaldokter_buka, jadwaldokter_m.jadwaldokter_mulai, jadwaldokter_m.jadwaldokter_tutup 
                        from jadwaldokter_m 
                        join pegawai_m on pegawai_m.pegawai_id = jadwaldokter_m.pegawai_id
                        where jadwaldokter_m.pegawai_id = ".$val['pegawai_id']."
                        
                ";
                
                $loadDataJadwal = Yii::app()->db->createCommand($sql_jadwal)->queryAll();
                if(!empty($loadDataJadwal)){
                    $data[$i]['jadwaldokter'] = $loadDataJadwal;
                }
                
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackDok(".$encode.")";
        Yii::app()->end();

    }
    
    /**
     * set form Asal Rujukan load di mobile
     * @param $_GET['pasien_id']
     * @return json
     */
    public function actionGetAsalRujukan(){
        header("content-type:application/json");
        $data = array();
        if(isset($_GET['pasien_id'])){
            $sql = "SELECT * FROM asalrujukan_m WHERE asalrujukan_aktif = true";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            $data['asalrujukans'] = array();
            if(!empty($loadDatas)){
                $data['asalrujukans'] = $loadDatas;
            }
        }

        $encode = CJSON::encode($data);
        echo "jsonCallbackAsalRujukan(".$encode.")";
        Yii::app()->end();
    }

    /**
     * menampilkan jadwal pasien
     * MA-62
     * @params $_GET['pasien_id']
     * @params $_GET['bulan'] : yyyy-mm
     */
    public function actionGetJadwalPasien(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['pasien_id'])){
            $pasien_id = $_GET['pasien_id'];
            $pendaftaran_id = !empty($_GET['pendaftaran_id'])?'AND pendaftaran_t.pendaftaran_id = '.$_GET['pendaftaran_id']:'';
            $bulan = !empty($_GET['bulan'])?$_GET['bulan']:date('Y-m');
        $sql = "
            (
                SELECT NULL AS pendaftaran_id,NULL AS no_pendaftaran,
                buatjanjipoli_t.tgljadwal AS tgljadwal,pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
                ruangan_m.ruangan_nama, 'Janji Poliklinik' AS keterangan
                FROM buatjanjipoli_t
                LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = buatjanjipoli_t.pegawai_id
                LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                JOIN ruangan_m ON ruangan_m.ruangan_id = buatjanjipoli_t.ruangan_id
                WHERE buatjanjipoli_t.pasien_id = ".$pasien_id."
            )
            UNION ALL
            (
                SELECT pendaftaran_t.pendaftaran_id,pendaftaran_t.no_pendaftaran,
                pendaftaran_t.tglrenkontrol AS tgljadwal, 
                CASE WHEN dokterpenunjang_m.gelardepan != null 
                    THEN dokterpenunjang_m.gelardepan 
                ELSE pegawai_m.gelardepan 
                END as gelardepan, 
                CASE WHEN dokterpenunjang_m.nama_pegawai != null 
                    THEN dokterpenunjang_m.nama_pegawai
                    ELSE pegawai_m.nama_pegawai 
                END, 
                CASE WHEN gelarbelakangpenunjang_m.gelarbelakang_nama != null
                    THEN gelarbelakangpenunjang_m.gelarbelakang_nama 
                    ELSE gelarbelakang_m.gelarbelakang_nama 
                END,
                CASE WHEN ruanganpenunjang_m.ruangan_nama != null
                    THEN ruanganpenunjang_m.ruangan_nama 
                    ELSE ruangan_m.ruangan_nama 
                END, 
                'Rencana Kontrol' AS keterangan
                FROM pendaftaran_t
                LEFT JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
                JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                LEFT JOIN ruangan_m ruanganpenunjang_m ON ruanganpenunjang_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
                LEFT JOIN pegawai_m dokterpenunjang_m ON dokterpenunjang_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
                JOIN pegawai_m ON pendaftaran_t.pegawai_id = pegawai_m.pegawai_id
                LEFT JOIN gelarbelakang_m gelarbelakangpenunjang_m ON gelarbelakangpenunjang_m.gelarbelakang_id = dokterpenunjang_m.gelarbelakang_id
                LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                WHERE pendaftaran_t.tglrenkontrol IS NOT NULL
                AND pendaftaran_t.pasien_id = ".$pasien_id." ".$pendaftaran_id."
            )
            ORDER BY tgljadwal ASC";
    
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                if($i>0){
                    if($val['tgljadwal'] != $loadDatas[$i-1]['tgljadwal']){
                        $data[$val['no_pendaftaran']]['pendaftaran']['pendaftaran_id'] = $val['pendaftaran_id'];
                        $data[$val['no_pendaftaran']]['pendaftaran']['no_pendaftaran'] = $val['no_pendaftaran'];
                        $data[$val['no_pendaftaran']]['riwayat'][$i] = $val;
                        $data[$val['no_pendaftaran']]['riwayat'][$i]['nama_pegawai'] = $val['gelardepan']." ".$val['nama_pegawai']." ".$val['gelarbelakang_nama'];
                        $data[$val['no_pendaftaran']]['riwayat'][$i]['tgljadwal'] = $format->formatDateTimeForUser($val['tgljadwal']);
                    }
                }else{
                    $data[$val['no_pendaftaran']]['pendaftaran']['pendaftaran_id'] = $val['pendaftaran_id'];
                    $data[$val['no_pendaftaran']]['pendaftaran']['no_pendaftaran'] = $val['no_pendaftaran'];
                    $data[$val['no_pendaftaran']]['riwayat'][$i] = $val;
                    $data[$val['no_pendaftaran']]['riwayat'][$i]['nama_pegawai'] = $val['gelardepan']." ".$val['nama_pegawai']." ".$val['gelarbelakang_nama'];
                    $data[$val['no_pendaftaran']]['riwayat'][$i]['tgljadwal'] = $format->formatDateTimeForUser($val['tgljadwal']);
                }
            }
        }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackJadwal(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan jadwal pasien
     * MA-62
     * @params $_GET['pasien_id']
     * @params $_GET['bulan'] : yyyy-mm
     */
    public function actionGetJadPasien(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['pasien_id'])&& isset($_GET['bulanjadwal'])&& isset($_GET['tahunjadwal'])){
            $sql = "
                SELECT buatjanjipoli_t.pendaftaran_id,
                buatjanjipoli_t.tgljadwal AS tgljadwal, buatjanjipoli_t.buatjanjipoli_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
                CONCAT(ruangdaftar.ruangan_singkatan,pegawaidaftar.defaultantrian,'-',pendaftaran_t.no_urutantri) as noantrianpendaftaran,
                ruangan_m.ruangan_nama, buatjanjipoli_t.no_buatjanji, buatjanjipoli_t.keteranganbuatjanji, 'Janji Poliklinik' AS keterangan, buatjanjipoli_t.no_antrianjanji, ruangan_m.ruangan_id
                FROM buatjanjipoli_t
                LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = buatjanjipoli_t.pegawai_id
                LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = buatjanjipoli_t.pendaftaran_id
                LEFT JOIN ruangan_m ruangdaftar ON ruangdaftar.ruangan_id = pendaftaran_t.ruangan_id
                LEFT JOIN pegawai_m pegawaidaftar ON pegawaidaftar.pegawai_id = pegawai_m.pegawai_id
                JOIN ruangan_m ON ruangan_m.ruangan_id = buatjanjipoli_t.ruangan_id
                WHERE buatjanjipoli_t.pasien_id = ".$_GET['pasien_id']." AND buatjanjipoli_t.is_aktif = TRUE AND date_part('month',tgljadwal) = ".$_GET['bulanjadwal']." AND date_part('year',tgljadwal) = ".$_GET['tahunjadwal']."
                ORDER BY tgljadwal DESC";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if(!empty($loadDatas)){
                foreach($loadDatas AS $i => $val){
                    $data[$i] = $val;
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackJadwalPasien(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan riwayat reservasi
     * @params $_GET['pasien_id']
     * @params $_GET['bulanreservasi'] : mm
     * @params $_GET['tahunreservasi'] : yyyy
     */
    public function actionGetRiwayatReservasi(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['pasien_id'])&& isset($_GET['bulanreservasi'])&& isset($_GET['tahunreservasi'])){
            $sql = " SELECT buatjanjipoli_t.pendaftaran_id,
                buatjanjipoli_t.tgljadwal AS tgljadwal, buatjanjipoli_t.buatjanjipoli_id, buatjanjipoli_t.no_buatjanji, 
                buatjanjipoli_t.pasien_id, buatjanjipoli_t.code_booking, buatjanjipoli_t.bukti_pembayaran, 
                buatjanjipoli_t.kelaspelayanan_id, buatjanjipoli_t.penjamin_id, buatjanjipoli_t.tglbuatjanji,
                buatjanjipoli_t.estimasiperiksa, pendaftaran_t.statusperiksa,
                pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
                carabayar_m.carabayar_id, carabayar_m.carabayar_nama,
                ruangan_m.ruangan_nama, ruangan_m.ruangan_id
                FROM buatjanjipoli_t
                LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = buatjanjipoli_t.pegawai_id
                LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = buatjanjipoli_t.pendaftaran_id
                LEFT JOIN carabayar_m ON carabayar_m.carabayar_id = buatjanjipoli_t.carabayar_id
                LEFT JOIN ruangan_m ruangdaftar ON ruangdaftar.ruangan_id = pendaftaran_t.ruangan_id
                LEFT JOIN pegawai_m pegawaidaftar ON pegawaidaftar.pegawai_id = pegawai_m.pegawai_id
                JOIN ruangan_m ON ruangan_m.ruangan_id = buatjanjipoli_t.ruangan_id
                WHERE buatjanjipoli_t.pasien_id = ".$_GET['pasien_id']." AND buatjanjipoli_t.is_aktif = TRUE AND date_part('month',tgljadwal) = ".$_GET['bulanreservasi']." AND date_part('year',tgljadwal) = ".$_GET['tahunreservasi']."
                ORDER BY tglbuatjanji DESC ";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if(!empty($loadDatas)){
                foreach($loadDatas AS $i => $val){
                    $data[$i] = $val;
                    $data[$i]['tgljadwal'] = MyFormatter::formatDateTimeForuser(explode(' ',$val['tgljadwal'])[0]);
                    $data[$i]['gelardepan'] = $val['gelardepan'];
                    $data[$i]['nama_pegawai'] = $val['nama_pegawai'];
                    $data[$i]['gelarbelakang_nama'] = $val['gelarbelakang_nama'];
                    $data[$i]['buatjanjipoli_id'] = $val['buatjanjipoli_id'];
                    $data[$i]['statusperiksa'] = $val['statusperiksa'];
                    $data[$i]['ruangan_nama'] = $val['ruangan_nama'];
                    $data[$i]['carabayar_id'] = $val['carabayar_id'];
                    $data[$i]['carabayar_nama'] = $val['carabayar_nama'];
                    $data[$i]['pendaftaran_id'] = $val['pendaftaran_id'];
                    $data[$i]['code_booking'] = $val['code_booking'];
                    $data[$i]['bukti_pembayaran'] = $val['bukti_pembayaran'];
                    $data[$i]['kelaspelayanan_id'] = $val['kelaspelayanan_id'];
                    $data[$i]['penjamin_id'] = $val['penjamin_id'];
                    $data[$i]['ruangan_id'] = $val['ruangan_id'];
                    $data[$i]['tglbuatjanji'] = date("Y-m-d", strtotime($val['tglbuatjanji']));
                    $data[$i]['estimasiperiksa'] = $val['estimasiperiksa'];
                    $data[$i]['jamAkhir'] = date("H:i:s", strtotime($val['estimasiperiksa'].'+1 hours'));
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackRiwayatReservasi(".$encode.")";
        Yii::app()->end();
    }

    /**
     * transaksi pesan ambulan
     * MA-60
     * @param $_GET['pasien_id']
     * @param $_GET['longitude']
     * @param $_GET['latitude']
     * @param $_GET['alamattujuan']
     * @param $_GET['nomobile']
     * @return json
     */
    public function actionPesanAmbulan(){
        header("content-type:application/json");
        $ok = 1;
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        if(isset($_GET['pasien_id']) && isset($_GET['loginpemakai_id'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model = new MOPesanambulansT;
                $model->tglpemesananambulans = date('Y-m-d H:i:s');
                $model->pesanambulans_no = MyGenerator::noPesanAmbulans(Params::INSTALASI_ID_AMBULAN);
                $modPasien = PasienM::model()->findByPk($_GET['pasien_id']);
                $model->pasien_id = $modPasien->pasien_id;
                $model->pendaftaran_id = $_GET['pendaftaran_id'];
                $model->norekammedis = $modPasien->no_rekam_medik;
                $model->namapasien = $modPasien->namadepan." ".$modPasien->nama_pasien;
                $model->ruangan_id = Params::RUANGAN_ID_AMBULANCE;
                $model->keteranganpesan = "Pesan ambulan via m-Pasien";
                $model->longitude = (isset($_GET['longitude']) ? $_GET['longitude'] : "");
                $model->latitude = (isset($_GET['latitude']) ? $_GET['latitude'] : "");
                $model->alamattujuan = (isset($_GET['alamattujuan']) ? $_GET['alamattujuan'] : "");
                $model->nomobile = (isset($_GET['nomobile']) ? $_GET['nomobile'] : "");
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = $_GET['loginpemakai_id'];
                $model->create_ruangan = Params::RUANGAN_ID_AMBULANCE;
                if($model->save()){
                    $judul = "Pemesanan Ambulans";
                    $isi =" Pada ".$model->tglpemesananambulans.", pasien ".$model->namapasien.", memesan ambulans untuk dijemput di ".$model->alamattujuan.",  no yang dapat dihubungi ".$model->nomobile."";
                    $r= RuanganM::model()->findByPk($model->ruangan_id);
                    $notif = new NotifikasiR;
                    $notif->instalasi_id = $r->instalasi_id;
                    $notif->modul_id = $r->modul_id;
                    $notif->tglnotifikasi = date('Y-m-d H:i:s');
                    $notif->judulnotifikasi = $judul;
                    $notif->isinotifikasi =  $isi;                
                    $notif->create_time = date('Y-m-d H:i:s');
                    $notif->create_loginpemakai_id = 1;
                    $notif->create_ruangan = $r->ruangan_id;
                    $notif->save();
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Pemesanan ambulan berhasil dilakukan!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Pemesanan ambulan gagal dilakukan!';
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Pemesanan ambulan gagal dilakukan!'.MyExceptionMessage::getMessage($exc,true);
            }

        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
      
        
    }
    
    /**
     * Untuk membatalkan reservasi
     * @param $_GET['buatjanjipoli_id']
     * @return json
     */
    public function actionBatalReservasi(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        if(isset($_GET['buatjanjipoli_id']) && isset($_GET['loginpemakai_id'])){
            $transaction = Yii::app()->db->beginTransaction();
            $buatjanjipoli_id = $_GET['buatjanjipoli_id'];
            try{
                $model = BuatjanjipoliT::model()->findByPk($buatjanjipoli_id);
                $modPasien = PasienM::model()->findByPk($model->pasien_id);
                $model->update_time = date("Y-m-d H:i:s");
                $model->is_aktif = FALSE;
                $model->update_loginpemakai_id = $_GET['loginpemakai_id'];               
                if($model->save()){
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Anda telah batal reservasi!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Reservasi Gagal Dikirim!<br>'.CHtml::errorSummary($model);
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Reservasi Gagal Dikirim!'.MyExceptionMessage::getMessage($exc,true);
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackBatalReservasi(".$encode.")";
        Yii::app()->end();
    }

    /**
     * transaksi rate dokter
     * MA-67
     * @param $_GET['pasien_id']
     * @param $_GET['pegawai_id']
     * @param $_GET['ratedokter']
     * @return json
     */
    public function actionRateDokter(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        if(isset($_GET['pasien_id']) && isset($_GET['pegawai_id']) && isset($_GET['ratedokter'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model = MORatedokterT::model()->findByAttributes(array('pasien_id'=>$_GET['pasien_id'],'pegawai_id'=>$_GET['pegawai_id']));
                if(empty($model)){
                    $model = new MORatedokterT;
                }
                $model->pasien_id = $_GET['pasien_id'];
                $model->pegawai_id = $_GET['pegawai_id'];
                $model->ratedokter = $_GET['ratedokter'];
                $model->tglratedokter = date('Y-m-d H:i:s');
                if($model->save()){
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Rate dokter '.$model->NamaDokter.' berhasil dilakukan!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Rate dokter '.$model->NamaDokter.' gagal dilakukan!';
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Rate dokter '.$model->NamaDokter.' gagal dilakukan!'.MyExceptionMessage::getMessage($exc,true);
            }

        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }

    /**
     * transaksi survei pelayanan (kepuasan)
     * MA-71
     * @param $_GET['pasien_id'] Boleh Kosong
     * @param $_GET['status_kepuasan'] | 0 = PUAS, 1 = TIDAK PUAS
     * @return json
     */
    public function actionSurveiPelayanan(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        if(isset($_GET['pasien_id']) && isset($_GET['status_kepuasan'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model = new MOMsurveypelayananT;
                $model->pasien_id = $_GET['pasien_id'];
                $model->status_kepuasan = ($_GET['status_kepuasan'] >= 1 ? Params::STATUS_KEPUASAN_PUAS : Params::STATUS_KEPUASAN_TIDAK_PUAS);
                $model->jenissurvey = Params::JENISSURVEY_MOBILE;
                $model->tglsurveypelayanan = date('Y-m-d H:i:s');
                if($model->save()){
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Survei berhasil dilakukan!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Survei gagal dilakukan!';
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Survei gagal dilakukan!'.MyExceptionMessage::getMessage($exc,true);
            }

        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * set form Asal Rujukan load di mobile
     * @param $_GET['pasien_id']
     * @return json
     */
    public function actionGetJenisPoli(){
        header("content-type:application/json");
        $data = array();
        $sql = "select * from lookup_m where lookup_type = 'jenispoli' ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        $data['jenisklinikpoli'] = array();
        if(!empty($loadDatas)){
            $data['jenisklinikpoli'] = $loadDatas;
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackJenisKlinikPoli(".$encode.")";
        Yii::app()->end();
    }

    /**
     * set form janji ketika load di mobile
     * MA-79
     * @param $_GET['pasien_id']
     * @return json
     */    
    public function actionSetFormJanjiPoli(){
        header("content-type:application/json");
        $data = array();
        $sql = " SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama
                FROM ruangan_m
                WHERE ruangan_m.ruangan_aktif = TRUE AND ruangan_m.instalasi_id = ".Params::INSTALASI_ID_RJ."
                ORDER BY ruangan_m.ruangan_nama ASC ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        $data['ruangans'] = array();
        if(!empty($loadDatas)){
            $data['ruangans'] = $loadDatas;
        }
        $data['dokters'] = array();
        $encode = CJSON::encode($data);
        echo "jsonCallbackRuangan(".$encode.")";
        Yii::app()->end();
    }

    /**
     * menampilkan dokter untuk janji poliklinik
     * MA-79
     * @param $_GET['ruangan_id']
     * @return json
     */
    public function actionGetDokterJanjiPoli(){
        header("content-type:application/json");
        $data = array();
            if(!empty($_GET['ruangan_id']))
                $ruangan = "AND ruanganpegawai_m.ruangan_id = ".$_GET['ruangan_id'];
            else
                $ruangan = '';
            $sql = "SELECT 
                        pegawai_m.pegawai_id, pegawai_m.gelardepan, 
                        pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, 
                        pegawai_m.jeniskelamin
                    FROM ruanganpegawai_m
                    JOIN pegawai_m ON ruanganpegawai_m.pegawai_id = pegawai_m.pegawai_id
                    LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
                    WHERE (pegawai_m.kelompokpegawai_id = ANY (ARRAY[1, 3]))
                        AND pegawai_m.pegawai_aktif = true
                        ".$ruangan."
                     GROUP BY pegawai_m.pegawai_id, pegawai_m.gelardepan, 
                        pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama, 
                        pegawai_m.jeniskelamin ORDER BY pegawai_m.nama_pegawai ";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            $data['dokters'] = array();
            if(count($loadDatas) > 0){
                foreach($loadDatas AS $i => $val){
                    $sqlRuanganKontrol = "SELECT ruangan_id FROM ruanganpegawai_m WHERE pegawai_id = ".$val['pegawai_id'];
                    $loadDatasRuangan = Yii::app()->db->createCommand($sqlRuanganKontrol)->queryAll();
                    $data['dokters'][$i] = $val;
                    $data['dokters'][$i]['nama_pegawai'] = $val['gelardepan']." ".$val['nama_pegawai'].", ".$val['gelarbelakang_nama'];
                    $data['dokters'][$i]['poliklinik'] = $loadDatasRuangan;
                }
            }
        // }

        $encode = CJSON::encode($data);
        echo "jsonCallbackDokter(".$encode.")";
        Yii::app()->end();
    } 
    
    
    /**
     * set form cara bayar ketika load di mobile
     * MA-79
     * @param $_GET['pasien_id']
     * @return json
     */
    public function actionSetFormCaraBayar(){
        header("content-type:application/json");
        $data = array();
        if(isset($_GET['pasien_id'])){
            $sql = "SELECT carabayar_id, carabayar_nama
                    FROM carabayar_m
                    WHERE carabayar_aktif = TRUE
                    and carabayar_id = 1   
                    ORDER BY carabayar_id ASC";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            $data['carabayars'] = array();
            if(count($loadDatas) > 0){
                $data['carabayars'] = $loadDatas;
            }
            $data['penjamins'] = array();
        }

        $encode = CJSON::encode($data);
        echo "jsonCallbackCarabayar(".$encode.")";
        Yii::app()->end();
    }

    /**
     * transaksi janji poliklinik
     * @param $_GET['pasien_id']
     * @param $_GET['loginpemakai_id']
     * @param $_GET['buatjanjipoli'] array() / serialize
     * @return json
     */
    public function actionJanjiPoli(){
        header("content-type:application/json");
        $data = array();
        $response = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter'; 
        $data['pesanerror'] =array();
        $tgl = date('Y-m-d');
        $loginpemakai = MOLoginpemakaiK::model()->findByAttributes(array('loginpemakai_id'=>$_GET['loginpemakai_id']));
        $jadwalBukaPoli = JadwaldokterM::model()->findByAttributes(array('pegawai_id'=>$_GET['buatjanjipoli']['pegawai_id'], 'jadwaldokter_hari'=> CustomFunction::getHariByNomorMobile(date('w', strtotime('+1 day'))), 'ruangan_id'=>$_GET['buatjanjipoli']['ruangan_id'], 'jadwaldokter_id'=>$_GET['buatjanjipoli']['jadwaldokter_id']));
        $jeniskasuspenyakit = RuanganM::model()->findByAttributes(array('ruangan_id'=>$_GET['buatjanjipoli']['ruangan_id']));
        $kelaspelayanan_id = KelasruanganM::model()->findByAttributes(array('ruangan_id'=>$_GET['buatjanjipoli']['ruangan_id']));
        if(isset($_GET['pasien_id']) && isset($_GET['loginpemakai_id']) && isset($_GET['buatjanjipoli']) && isset($_GET['pasien'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model = new MOBuatjanjipoliT;
                $modPasien = PasienM::model()->findByPk($_GET['pasien_id']);
                $model->pasien_id = $modPasien->pasien_id;
                $model->attributes = $_GET['buatjanjipoli'];
                $model->keteranganbuatjanji = $_GET['buatjanjipoli']['keteranganbuatjanji']." via m-Pasien";
                $model->penjamin_id = $_GET['buatjanjipoli']['penjamin_id'];
                $model->carabayar_id = $_GET['buatjanjipoli']['carabayar_id'];
                $model->ruangan_id = $_GET['buatjanjipoli']['ruangan_id'];
                $model->pegawai_id = $_GET['buatjanjipoli']['pegawai_id'];
                $model->create_time = date("Y-m-d H:i:s");
                $model->tglbuatjanji = date("Y-m-d H:i:s");
                $model->isonsite = FALSE;
                $model->jadwaldokter_id = $_GET['buatjanjipoli']['jadwaldokter_id'];
                $model->tgljadwal = date("Y-m-d", strtotime('+1 day')).' '.$jadwalBukaPoli->jadwaldokter_mulai;
                $model->tglperiksa = date("Y-m-d", strtotime('+1 day')).' '.$jadwalBukaPoli->jadwaldokter_mulai;
                $model->jeniskasuspenyakit_id = $jeniskasuspenyakit->kasuspenyakitdefault_id;
                $model->kelaspelayanan_id = $kelaspelayanan_id->kelaspelayanan_id;
                $model->alamatemail = $modPasien->alamatemail;                
                $model->harijadwal = CustomFunction::getHariByNomorMobile(date('w', strtotime($model->tgljadwal)));
                $model->create_loginpemakai_id = $_GET['loginpemakai_id'];
                $model->no_buatjanji = MyGenerator::noJanjiPoli();                
                $model->pendaftaran_id = (!empty($_GET['buatjanjipoli']['pendaftaran_id'])?(($_GET['buatjanjipoli']['pendaftaran_id'] != 'null')?$_GET['buatjanjipoli']['pendaftaran_id']:''):'');
                if($model->save()){
                    if(!empty($model->alamatemail)){
                        if($model->carabayar_id == Params::CARABAYAR_ID_ASURANSI ){
                            $transaction->commit();
                            $data['sukses'] = 1;
                            $data['pesan'] = 'Silakan upload foto kartu asuransi di Menu Riwayat Reservasi Poliklinik!';
                            $data['pesanerror'] ='Silakan upload foto kartu asuransi di Menu Riwayat Reservasi Poliklinik!';
                        }else{
                            $transaction->commit();
                            $data['sukses'] = 1;
                            $data['kelaspelayanan_id'] = $model->kelaspelayanan_id;
                            $data['buatjanjipoli_id'] = $model->buatjanjipoli_id;
                            $data['pesan'] = 'Silakan upload foto kartu asuransi di Menu Riwayat Reservasi Poliklinik!';
                            $data['pesanerror'] ='Silakan upload foto kartu asuransi di Menu Riwayat Reservasi Poliklinik!';
                        }
                    }else{
                        $pasien = PasienM::model()->findByPk($_GET['pasien_id']);
                        $pasien->alamatemail = $_GET['pasien']['alamatemail'];
                        if($pasien->save()){
                            if($pasien->alamatemail !=''){
                                if($model->carabayar_id == Params::CARABAYAR_ID_ASURANSI ){
                                    $transaction->commit();
                                    $data['sukses'] = 1;
                                    $data['pesan'] = 'Silakan upload foto kartu asuransi di Menu Riwayat Reservasi Poliklinik!'; 
                                    $data['pesanerror'] ='Silakan upload foto kartu asuransi di Menu Riwayat Reservasi Poliklinik!';
                                }else{
                                    $transaction->commit();
                                    $data['sukses'] = 1;
                                    $data['kelaspelayanan_id'] = $model->kelaspelayanan_id;
                                    $data['buatjanjipoli_id'] = $model->buatjanjipoli_id;
                                    $data['pesan'] = 'Silakan upload foto kartu asuransi di Menu Riwayat Reservasi Poliklinik!';
                                    $data['pesanerror'] ='Silakan upload foto kartu asuransi di Menu Riwayat Reservasi Poliklinik!';
                                }
                            }else{
                                $transaction->rollback();
                                $data['sukses'] = 0;
                                $data['pesan'] = 'Email Tidak Boleh Kosong!';
                                $data['pesanerror'] ='Email tidak boleh kosong!';
                            }
                        }
                    }
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Janji poliklinik gagal!'.MyExceptionMessage::getMessage($exc,true);
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackJanjiPoli(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan riwayat reservasi
     * @params $_GET['pasien_id']
     * @params $_GET['bulanreservasi'] : mm
     * @params $_GET['tahunreservasi'] : yyyy
     */
    public function actionGetTagihanPasien(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['ruangan_id']) && isset($_GET['kelaspelayanan_id']) && isset($_GET['penjamin_id']) && isset($_GET['buatjanjipoli_id'])){
            $sql = " SELECT * from karcis_v
                    JOIN karcispoli_t ON karcis_v.karcis_id = karcispoli_t.karcis_id
                    WHERE komponentarif_id = 6 AND pasienbaru_karcis = False 
                    AND ruangan_id = ".$_GET['ruangan_id']." AND kelaspelayanan_id = ".$_GET['kelaspelayanan_id']."
                    AND penjamin_id = ".$_GET['penjamin_id']." AND buatjanjipoli_id = ".$_GET['buatjanjipoli_id']." ";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if(!empty($loadDatas)){
                foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['harga_tariftindakan'] = MyFormatter::formatNumberForUser($val['harga_tariftindakan']);
                $data[$i]['karcis_id'] = $val['karcis_id'];
                $data[$i]['daftartindakan_id'] = $val['daftartindakan_id'];
                $data[$i]['daftartindakan_nama'] = $val['daftartindakan_nama'];
                $data[$i]['karcis_nama'] = $val['karcis_nama'];
                $data[$i]['penjamin_id'] = $val['penjamin_id'];
                $data[$i]['komponentarif_id'] = $val['komponentarif_id'];
                $data[$i]['ruangan_id'] = $val['ruangan_id'];
                $data[$i]['kelaspelayanan_id'] = $val['kelaspelayanan_id'];
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackTagihanPasien(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan riwayat reservasi
     * @params $_GET['pasien_id']
     * @params $_GET['bulanreservasi'] : mm
     * @params $_GET['tahunreservasi'] : yyyy
     */
    public function actionGetListPendaftaran(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['ruangan_id']) && isset($_GET['kelaspelayanan_id']) && isset($_GET['penjamin_id']) && isset($_GET['buatjanjipoli_id'])){
            $sql = " SELECT
                buatjanjipoli_t.tgljadwal, buatjanjipoli_t.no_buatjanji, 
                buatjanjipoli_t.pasien_id, buatjanjipoli_t.ruangan_id, buatjanjipoli_t.kelaspelayanan_id, 
                buatjanjipoli_t.penjamin_id,
                buatjanjipoli_t.estimasiperiksa, buatjanjipoli_t.buatjanjipoli_id,
                pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
                ruangan_m.ruangan_nama
                FROM buatjanjipoli_t
                LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = buatjanjipoli_t.pegawai_id
                LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                JOIN ruangan_m ON ruangan_m.ruangan_id = buatjanjipoli_t.ruangan_id
                WHERE buatjanjipoli_t.ruangan_id = ".$_GET['ruangan_id']." AND buatjanjipoli_t.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']." AND buatjanjipoli_t.penjamin_id = ".$_GET['penjamin_id']." AND buatjanjipoli_t.buatjanjipoli_id = ".$_GET['buatjanjipoli_id']." AND buatjanjipoli_t.is_aktif = TRUE 
                ORDER BY tglbuatjanji DESC ";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if(!empty($loadDatas)){
                foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tgljadwal'] = MyFormatter::formatDateTimeForuser(explode(' ',$val['tgljadwal'])[0]);
                $data[$i]['gelardepan'] = $val['gelardepan'];
                $data[$i]['nama_pegawai'] = $val['nama_pegawai'];
                $data[$i]['gelarbelakang_nama'] = $val['gelarbelakang_nama'];
                $data[$i]['buatjanjipoli_id'] = $val['buatjanjipoli_id'];
                $data[$i]['penjamin_id'] = $val['penjamin_id'];
                $data[$i]['ruangan_id'] = $val['ruangan_id'];
                $data[$i]['ruangan_nama'] = $val['ruangan_nama'];
                $data[$i]['no_buatjanji'] = $val['no_buatjanji'];
                $data[$i]['kelaspelayanan_id'] = $val['kelaspelayanan_id'];
                $data[$i]['jamPrakter'] = date("H:i:s", strtotime($val['tgljadwal']));
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackListPendaftaran(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan Tagihan Pembayaran
     */
    public function actionGetPembayaranPasien(){
        header("content-type:application/json");
        $data = array();
        $total = 0;
        if(isset($_GET['ruangan_id']) && isset($_GET['kelaspelayanan_id']) && isset($_GET['penjamin_id']) && isset($_GET['buatjanjipoli_id'])){
            $tglpendaftaran = date("Y-m-d H:i:s");
            $sql = " SELECT * from karcis_v
                    JOIN karcispoli_t ON karcis_v.karcis_id = karcispoli_t.karcis_id
                    JOIN buatjanjipoli_t ON buatjanjipoli_t.buatjanjipoli_id = karcispoli_t.buatjanjipoli_id
                    WHERE karcis_v.komponentarif_id = 6 AND karcis_v.pasienbaru_karcis = False 
                    AND karcis_v.ruangan_id = ".$_GET['ruangan_id']." AND karcis_v.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']."
                    AND karcis_v.penjamin_id = ".$_GET['penjamin_id']." AND buatjanjipoli_t.buatjanjipoli_id = ".$_GET['buatjanjipoli_id']." ";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if(!empty($loadDatas)){
                foreach($loadDatas AS $i => $val){
                $total = $total + $val['harga_tariftindakan'];
                $data[$i] = $val;
                $data[$i]['total_tariftindakan'] = MyFormatter::formatNumberForUser($total);
                $data[$i]['create_time'] = MyFormatter::formatDateTimeForuser(explode(' ',$val['create_time'])[0]);
                $data[$i]['penjamin_id'] = $val['penjamin_id'];
                $data[$i]['ruangan_id'] = $val['ruangan_id'];
                $data[$i]['kelaspelayanan_id'] = $val['kelaspelayanan_id'];
                $data[$i]['buatjanjipoli_id'] = $val['buatjanjipoli_id'];
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackPembayaranPasien(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan Tagihan Pembayaran
     */
    public function actionGetNoRekening(){
        header("content-type:application/json");
        $data = array();
        $sql = " SELECT * from bank_m
                WHERE is_mobile = TRUE ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($loadDatas)){
            foreach($loadDatas AS $i => $val){
            $data[$i] = $val;
            $data[$i]['bank_id'] = $val['bank_id'];
            $data[$i]['namabank'] = $val['namabank'];
            $data[$i]['norekening'] = $val['norekening'];
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackNoRekening(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * Konfirmasi pembayaran
     * @return json array
     */
    public function actionKonfirmasiPendaftaranPasien(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = "Error 404. Request tidak valid!";
        $response = array();
        if(isset($_GET['buatjanjipoli_id'])){
            $transaction = Yii::app()->db->beginTransaction();
            $buatjanjipoli_id = $_GET['buatjanjipoli_id'];
            try{
                $length = 6;
                $model = BuatjanjipoliT::model()->findByPk($buatjanjipoli_id);
                $model->code_booking = strtoupper(GenerateTokenPass::generateRandomBase62String($length));
                $sql2 = " SELECT * from karcis_v
                    WHERE komponentarif_id = 6 AND pasienbaru_karcis = False 
                    AND ruangan_id = ".$model->ruangan_id." AND kelaspelayanan_id = ".$model->kelaspelayanan_id."
                    AND penjamin_id = ".$model->penjamin_id." ";
                $loadData = Yii::app()->db->createCommand($sql2)->queryAll();
                
                $tglpendaftaran = date('Y-m-d 00:00:00', strtotime('+1 day'));
                $tglbooking = date('Y-m-d', strtotime('+1 day'));
                $modInstalasi = RuanganM::model()->findByAttributes(array('ruangan_id'=>$model->ruangan_id));
                $modPasien = MOPasienM::model()->findByAttributes(array('pasien_id'=>$model->pasien_id));
                $modPendaftaran = new MOPendaftaranT;
                $modPendaftaran->penjamin_id = $model->penjamin_id;
                $modPendaftaran->pasien_id = $model->pasien_id;
                $modPendaftaran->pegawai_id = $model->pegawai_id;
                $modPendaftaran->instalasi_id = $modInstalasi->instalasi_id;
                $modPendaftaran->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
                $modPendaftaran->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
                $modPendaftaran->ruangan_id = $model->ruangan_id;
                $modPendaftaran->no_pendaftaran = MyGenerator::noPendaftaran($modInstalasi->instalasi_id, $tglbooking);
                $modPendaftaran->tgl_pendaftaran = $tglpendaftaran;
                if($model->is_pasiensakit == TRUE){
                    $modPendaftaran->no_urutantri = MyGenerator::noAntrianJanjiPoliKsSakit($model->ruangan_id, $model->pegawai_id);
                    $sql = " SELECT * from jadwalbukapoli_m
                        WHERE ruangan_id = ".$model->ruangan_id." AND dokter_id = ".$model->pegawai_id." AND jadwalbukapoli_id = ".$model->jadwalbukapoli_id." ";
                    $loadAntrian = JadwalbukapoliM::model()->findBySql($sql);
                    if($modPendaftaran->no_urutantri <= '008'){
                        $model->estimasiperiksa = date("H:i", strtotime($model->tgljadwal));
                    }else if($modPendaftaran->no_urutantri == '009'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+1 hours'));
                    }else if($modPendaftaran->no_urutantri > '009'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+1 hours'));
                    }else if($modPendaftaran->no_urutantri == '017'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+2 hours'));
                    }else if($modPendaftaran->no_urutantri > '017'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+2 hours'));
                    }else if($modPendaftaran->no_urutantri == '025'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+3 hours'));
                    }else if($modPendaftaran->no_urutantri > '025'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+3 hours'));
                    }else if($modPendaftaran->no_urutantri == '033'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+4 hours'));
                    }else if($modPendaftaran->no_urutantri > '033'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+4 hours'));
                    }else if($modPendaftaran->no_urutantri == '041'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+5 hours'));
                    }else if($modPendaftaran->no_urutantri > '041'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+5 hours'));
                    }else if($modPendaftaran->no_urutantri == '049'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+6 hours'));
                    }else if($modPendaftaran->no_urutantri > '049'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+6 hours'));
                    }else if($modPendaftaran->no_urutantri == '057'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+7 hours'));
                    }else if($modPendaftaran->no_urutantri > '057'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+7 hours'));
                    }else if($modPendaftaran->no_urutantri == '065'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+8 hours'));
                    }else if($modPendaftaran->no_urutantri > '065'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+8 hours'));
                    }
                }else{
                    $modPendaftaran->no_urutantri = MyGenerator::noAntrianJanjiPoliKsSehat($model->ruangan_id, $model->pegawai_id);
                    $sql = " SELECT * from jadwalbukapoli_m
                        WHERE ruangan_id = ".$model->ruangan_id." AND dokter_id = ".$model->pegawai_id." AND jadwalbukapoli_id = ".$model->jadwalbukapoli_id." ";
                    $loadAntrian = JadwalbukapoliM::model()->findBySql($sql);
                    if($modPendaftaran->no_urutantri <= '008'){
                        $model->estimasiperiksa = date("H:i", strtotime($model->tgljadwal));
                    }else if($modPendaftaran->no_urutantri == '009'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+1 hours'));
                    }else if($modPendaftaran->no_urutantri > '009'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+1 hours'));
                    }else if($modPendaftaran->no_urutantri == '017'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+2 hours'));
                    }else if($modPendaftaran->no_urutantri > '017'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+2 hours'));
                    }else if($modPendaftaran->no_urutantri == '025'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+3 hours'));
                    }else if($modPendaftaran->no_urutantri > '025'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+3 hours'));
                    }else if($modPendaftaran->no_urutantri == '033'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+4 hours'));
                    }else if($modPendaftaran->no_urutantri > '033'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+4 hours'));
                    }else if($modPendaftaran->no_urutantri == '041'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+5 hours'));
                    }else if($modPendaftaran->no_urutantri > '041'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+5 hours'));
                    }else if($modPendaftaran->no_urutantri == '049'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+6 hours'));
                    }else if($modPendaftaran->no_urutantri > '049'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+6 hours'));
                    }else if($modPendaftaran->no_urutantri == '057'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+7 hours'));
                    }else if($modPendaftaran->no_urutantri > '057'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+7 hours'));
                    }else if($modPendaftaran->no_urutantri == '065'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+8 hours'));
                    }else if($modPendaftaran->no_urutantri > '065'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+8 hours'));
                    }
                }
                $modPendaftaran->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
                $modPendaftaran->statuspasien = Params::STATUSPASIEN_LAMA;
                $modPendaftaran->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
                $modPendaftaran->alihstatus = FALSE;
                $modPendaftaran->byphone = FALSE;
                $modPendaftaran->kunjunganrumah = FALSE;
                $modPendaftaran->statusmasuk = Params::STATUSMASUK_NONRUJUKAN;
                $modPendaftaran->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
                $modPendaftaran->create_time = $tglpendaftaran;
                $modPendaftaran->create_loginpemakai_id = $model->create_loginpemakai_id;
                $modPendaftaran->create_ruangan = $model->ruangan_id;
                $modPendaftaran->nopendaftaran_aktif = TRUE;
                $modPendaftaran->statusfarmasi = FALSE;
                $modPendaftaran->panggilantrian = FALSE;
                $modPendaftaran->asuransipasien_id = $model->asuransipasienjanjipoli_id;
                $modPendaftaran->tglperiksa = $model->tgljadwal;
                $modPendaftaran->tglakandilayani = $model->tgljadwal;
                $modPendaftaran->is_hadir = FALSE;
                $modPendaftaran->carabayar_id = $model->carabayar_id;
                $modPendaftaran->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
                $modPendaftaran->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
                $modPendaftaran->shift_id = 1;
                $modPendaftaran->save();
                foreach($loadData as $i => $karcis) {
                    $modPelayanan = new TindakanpelayananT;
                    $modPelayanan->shift_id = 1;
                    $modPelayanan->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
                    $modPelayanan->pasien_id = $model->pasien_id;
                    $modPelayanan->instalasi_id = $modInstalasi->instalasi_id;
                    $modPelayanan->daftartindakan_id = $karcis['daftartindakan_id'];
                    $modPelayanan->karcis_id = $karcis['karcis_id'];
                    $modPelayanan->carabayar_id = $model->carabayar_id;
                    $modPelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                    $modPelayanan->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
                    $modPelayanan->ruangan_id = $model->ruangan_id;
                    $modPelayanan->satuantindakan = "KALI";
                    $modPelayanan->penjamin_id = $model->penjamin_id;
                    $modPelayanan->tgl_tindakan = $tglpendaftaran;
                    $modPelayanan->tarif_rsakomodasi = $karcis['harga_tariftindakan'];
                    $modPelayanan->tarif_medis = 0;
                    $modPelayanan->tarif_paramedis = 0;
                    $modPelayanan->tarif_bhp = 0;
                    $modPelayanan->tarif_satuan = $karcis['harga_tariftindakan'];
                    $modPelayanan->tarif_tindakan = $karcis['harga_tariftindakan'];
                    $modPelayanan->qty_tindakan = 1;
                    $modPelayanan->cyto_tindakan = 0;
                    $modPelayanan->tarifcyto_tindakan = 0;
                    $modPelayanan->dokterpemeriksa1_id = $model->pegawai_id;
                    $modPelayanan->discount_tindakan = 0;
                    $modPelayanan->pembebasan_tindakan = 0;
                    $modPelayanan->subsidiasuransi_tindakan = 0;
                    $modPelayanan->subsidipemerintah_tindakan = 0;
                    $modPelayanan->subsisidirumahsakit_tindakan = 0;
                    $modPelayanan->iurbiaya_tindakan = $karcis['harga_tariftindakan'];
                    $modPelayanan->tm = "TM";
                    $modPelayanan->create_time = $tglpendaftaran;
                    $modPelayanan->create_loginpemakai_id = $model->create_loginpemakai_id;
                    $modPelayanan->create_ruangan = $model->ruangan_id;
                    $modPelayanan->save();
                }
                if($model->save()){
                    BuatjanjipoliT::model()->updateByPk($model->buatjanjipoli_id, array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'no_antrianjanji' =>$modPendaftaran->no_urutantri));
                    MOPendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('karcis_id'=>$modPelayanan->karcis_id));
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Konfirmasi berhasil!';
                    $data['pesanerror'] = 'Pembayaran Telah Berhasil! Silakan Menuju Ke Beranda Untuk melihat Detail Reservasi';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Konfirmasi Gagal!<br>';
                    $data['pesanerror'] = 'Konfirmasi Gagal';
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Konfirmasi Gagal!'.MyExceptionMessage::getMessage($exc,true);
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackKonfirmasiPendaftaranPasien(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * Konfirmasi pembayaran
     * @return json array
     */
    public function actionKonfirmasiPembayaran(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = "Error 404. Request tidak valid!";
        $response = array();
        if(isset($_GET['buatjanjipoli_id'])){
            $transaction = Yii::app()->db->beginTransaction();
            $buatjanjipoli_id = $_GET['buatjanjipoli_id'];
            try{
                $length = 6;
                $model = BuatjanjipoliT::model()->findByPk($buatjanjipoli_id);
                $model->code_booking = strtoupper(GenerateTokenPass::generateRandomBase62String($length));
                $sql2 = " SELECT * from karcis_v
                    WHERE komponentarif_id = 6 AND pasienbaru_karcis = False 
                    AND ruangan_id = ".$model->ruangan_id." AND kelaspelayanan_id = ".$model->kelaspelayanan_id."
                    AND penjamin_id = ".$model->penjamin_id." ";
                $loadData = Yii::app()->db->createCommand($sql2)->queryAll();
                
                $tglpendaftaran = date('Y-m-d 00:00:00', strtotime('+1 day'));
                $tglbooking = date('Y-m-d', strtotime('+1 day'));
                $modInstalasi = RuanganM::model()->findByAttributes(array('ruangan_id'=>$model->ruangan_id));
                $modPasien = MOPasienM::model()->findByAttributes(array('pasien_id'=>$model->pasien_id));
                $modPendaftaran = new MOPendaftaranT;
                $modPendaftaran->penjamin_id = $model->penjamin_id;
                $modPendaftaran->pasien_id = $model->pasien_id;
                $modPendaftaran->pegawai_id = $model->pegawai_id;
                $modPendaftaran->instalasi_id = $modInstalasi->instalasi_id;
                $modPendaftaran->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
                $modPendaftaran->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
                $modPendaftaran->ruangan_id = $model->ruangan_id;
                $modPendaftaran->no_pendaftaran = MyGenerator::noPendaftaran($modInstalasi->instalasi_id, $tglbooking);
                $modPendaftaran->tgl_pendaftaran = $tglpendaftaran;
                if($model->is_pasiensakit == TRUE){
                    $modPendaftaran->no_urutantri = MyGenerator::noAntrianJanjiPoliKsSakit($model->ruangan_id, $model->pegawai_id);
                    $sql = " SELECT * from jadwalbukapoli_m
                        WHERE ruangan_id = ".$model->ruangan_id." AND dokter_id = ".$model->pegawai_id." AND jadwalbukapoli_id = ".$model->jadwalbukapoli_id." ";
                    $loadAntrian = JadwalbukapoliM::model()->findBySql($sql);
                    if($modPendaftaran->no_urutantri <= '008'){
                        $model->estimasiperiksa = date("H:i", strtotime($model->tgljadwal));
                    }else if($modPendaftaran->no_urutantri == '009'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+1 hours'));
                    }else if($modPendaftaran->no_urutantri > '009'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+1 hours'));
                    }else if($modPendaftaran->no_urutantri == '017'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+2 hours'));
                    }else if($modPendaftaran->no_urutantri > '017'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+2 hours'));
                    }else if($modPendaftaran->no_urutantri == '025'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+3 hours'));
                    }else if($modPendaftaran->no_urutantri > '025'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+3 hours'));
                    }else if($modPendaftaran->no_urutantri == '033'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+4 hours'));
                    }else if($modPendaftaran->no_urutantri > '033'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+4 hours'));
                    }else if($modPendaftaran->no_urutantri == '041'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+5 hours'));
                    }else if($modPendaftaran->no_urutantri > '041'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+5 hours'));
                    }else if($modPendaftaran->no_urutantri == '049'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+6 hours'));
                    }else if($modPendaftaran->no_urutantri > '049'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+6 hours'));
                    }else if($modPendaftaran->no_urutantri == '057'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+7 hours'));
                    }else if($modPendaftaran->no_urutantri > '057'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+7 hours'));
                    }else if($modPendaftaran->no_urutantri == '065'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+8 hours'));
                    }else if($modPendaftaran->no_urutantri > '065'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->mulaibukasakit.'+8 hours'));
                    }
                }else{
                    $modPendaftaran->no_urutantri = MyGenerator::noAntrianJanjiPoliKsSehat($model->ruangan_id, $model->pegawai_id);
                    $sql = " SELECT * from jadwalbukapoli_m
                        WHERE ruangan_id = ".$model->ruangan_id." AND dokter_id = ".$model->pegawai_id." AND jadwalbukapoli_id = ".$model->jadwalbukapoli_id." ";
                    $loadAntrian = JadwalbukapoliM::model()->findBySql($sql);
                    if($modPendaftaran->no_urutantri <= '008'){
                        $model->estimasiperiksa = date("H:i", strtotime($model->tgljadwal));
                    }else if($modPendaftaran->no_urutantri == '009'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+1 hours'));
                    }else if($modPendaftaran->no_urutantri > '009'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+1 hours'));
                    }else if($modPendaftaran->no_urutantri == '017'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+2 hours'));
                    }else if($modPendaftaran->no_urutantri > '017'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+2 hours'));
                    }else if($modPendaftaran->no_urutantri == '025'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+3 hours'));
                    }else if($modPendaftaran->no_urutantri > '025'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+3 hours'));
                    }else if($modPendaftaran->no_urutantri == '033'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+4 hours'));
                    }else if($modPendaftaran->no_urutantri > '033'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+4 hours'));
                    }else if($modPendaftaran->no_urutantri == '041'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+5 hours'));
                    }else if($modPendaftaran->no_urutantri > '041'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+5 hours'));
                    }else if($modPendaftaran->no_urutantri == '049'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+6 hours'));
                    }else if($modPendaftaran->no_urutantri > '049'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+6 hours'));
                    }else if($modPendaftaran->no_urutantri == '057'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+7 hours'));
                    }else if($modPendaftaran->no_urutantri > '057'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+7 hours'));
                    }else if($modPendaftaran->no_urutantri == '065'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+8 hours'));
                    }else if($modPendaftaran->no_urutantri > '065'){
                        $model->estimasiperiksa = date("H:i", strtotime($loadAntrian->jammulai.'+8 hours'));
                    }
                }
                $modPendaftaran->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
                $modPendaftaran->statuspasien = Params::STATUSPASIEN_LAMA;
                $modPendaftaran->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
                $modPendaftaran->alihstatus = FALSE;
                $modPendaftaran->byphone = FALSE;
                $modPendaftaran->kunjunganrumah = FALSE;
                $modPendaftaran->statusmasuk = Params::STATUSMASUK_NONRUJUKAN;
                $modPendaftaran->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
                $modPendaftaran->create_time = $tglpendaftaran;
                $modPendaftaran->keterangan_reg = $model->keteranganbuatjanji;
                $modPendaftaran->create_loginpemakai_id = $model->create_loginpemakai_id;
                $modPendaftaran->create_ruangan = $model->ruangan_id;
                $modPendaftaran->nopendaftaran_aktif = TRUE;
                $modPendaftaran->statusfarmasi = FALSE;
                $modPendaftaran->panggilantrian = FALSE;
                $modPendaftaran->asuransipasien_id = $model->asuransipasienjanjipoli_id;
                $modPendaftaran->tglperiksa = $model->tgljadwal;
                $modPendaftaran->tglakandilayani = $model->tgljadwal;
                $modPendaftaran->is_hadir = FALSE;
                $modPendaftaran->carabayar_id = $model->carabayar_id;
                $modPendaftaran->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
                $modPendaftaran->tgljadwal = $model->tgljadwal;
                $modPendaftaran->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
                $modPendaftaran->shift_id = 1;
                $modPendaftaran->save();
                $modPembayaran = new PembayaranpelayananT;
                $modPembayaran->carabayar_id = $model->carabayar_id;
                $modPembayaran->ruangan_id = $model->ruangan_id;
                $modPembayaran->penjamin_id = $model->penjamin_id;
                $modPembayaran->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modPembayaran->pasien_id = $model->pasien_id;
                $modPembayaran->nopembayaran = MyGenerator::noPembayaran();
                $modPembayaran->tglpembayaran = $tglpendaftaran;
                $modPembayaran->totalbiayaoa = 0;
                $modPembayaran->totalbiayatindakan = $model->total_tarif;
                $modPembayaran->totalbiayapelayanan = $model->total_tarif;
                $modPembayaran->totalsubsidiasuransi = 0;
                $modPembayaran->totalsubsidipemerintah = 0;
                $modPembayaran->totalsubsidirs = 0;
                $modPembayaran->totaliurbiaya = $model->total_tarif;
                $modPembayaran->totalbayartindakan = $model->total_tarif;
                $modPembayaran->totaldiscount = 0;
                $modPembayaran->totalpembebasan = 0;
                $modPembayaran->totalsisatagihan = 0;
                $modPembayaran->ruanganpelakhir_id = $model->ruangan_id;
                $modPembayaran->statusbayar = Params::STATUSBAYAR_LUNAS;
                $modPembayaran->create_time = $tglpendaftaran;
                $modPembayaran->create_loginpemakai_id = $model->create_loginpemakai_id;
                $modPembayaran->create_ruangan = Params::RUANGAN_ID_KASIR;
                $modPembayaran->save();
                foreach($loadData as $i => $karcis) {
                    //Untuk simpan daftar tindakan
                    $modPelayanan = new TindakanpelayananT;
                    $modPelayanan->shift_id = 1;
                    $modPelayanan->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
                    $modPelayanan->pasien_id = $model->pasien_id;
                    $modPelayanan->instalasi_id = $modInstalasi->instalasi_id;
                    $modPelayanan->daftartindakan_id = $karcis['daftartindakan_id'];
                    $modPelayanan->karcis_id = $karcis['karcis_id'];
                    $modPelayanan->carabayar_id = $model->carabayar_id;
                    $modPelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                    $modPelayanan->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
                    $modPelayanan->ruangan_id = $model->ruangan_id;
                    $modPelayanan->satuantindakan = "KALI";
                    $modPelayanan->penjamin_id = $model->penjamin_id;
                    $modPelayanan->tgl_tindakan = $tglpendaftaran;
                    $modPelayanan->tarif_rsakomodasi = $karcis['harga_tariftindakan'];
                    $modPelayanan->tarif_medis = 0;
                    $modPelayanan->tarif_paramedis = 0;
                    $modPelayanan->tarif_bhp = 0;
                    $modPelayanan->tarif_satuan = $karcis['harga_tariftindakan'];
                    $modPelayanan->tarif_tindakan = $karcis['harga_tariftindakan'];
                    $modPelayanan->qty_tindakan = 1;
                    $modPelayanan->cyto_tindakan = 0;
                    $modPelayanan->tarifcyto_tindakan = 0;
                    $modPelayanan->dokterpemeriksa1_id = $model->pegawai_id;
                    $modPelayanan->discount_tindakan = 0;
                    $modPelayanan->pembebasan_tindakan = 0;
                    $modPelayanan->subsidiasuransi_tindakan = 0;
                    $modPelayanan->subsidipemerintah_tindakan = 0;
                    $modPelayanan->subsisidirumahsakit_tindakan = 0;
                    $modPelayanan->iurbiaya_tindakan = $karcis['harga_tariftindakan'];
                    $modPelayanan->tm = "TM";
                    $modPelayanan->create_time = $tglpendaftaran;
                    $modPelayanan->create_loginpemakai_id = $model->create_loginpemakai_id;
                    $modPelayanan->create_ruangan = $model->ruangan_id;
                    $modPelayanan->save();
                    $modTindakanSudahBayar = new TindakansudahbayarT();
                    $modTindakanSudahBayar->pembayaranpelayanan_id = $modPembayaran->pembayaranpelayanan_id;
                    $modTindakanSudahBayar->tindakanpelayanan_id = $modPelayanan->tindakanpelayanan_id;
                    $modTindakanSudahBayar->daftartindakan_id = $karcis['daftartindakan_id'];
                    $modTindakanSudahBayar->ruangan_id = $modPelayanan->ruangan_id;
                    $modTindakanSudahBayar->qty_tindakan = 1;
                    $modTindakanSudahBayar->jmlbiaya_tindakan = $karcis['harga_tariftindakan'];
                    $modTindakanSudahBayar->jmlsubsidi_rs = 0;
                    $modTindakanSudahBayar->jmlsubsidi_asuransi = 0;
                    $modTindakanSudahBayar->jmlsubsidi_pemerintah = 0;
                    $modTindakanSudahBayar->jmliurbiaya = $karcis['harga_tariftindakan'];
                    $modTindakanSudahBayar->jmlpembebasan = 0;
                    $modTindakanSudahBayar->jmlbayar_tindakan = 0;
                    $modTindakanSudahBayar->jmlsisabayar_tindakan = $karcis['harga_tariftindakan'];
                    $modTindakanSudahBayar->save();
                    TindakanpelayananT::model()->updateByPk($modPelayanan->tindakanpelayanan_id, array('tindakansudahbayar_id'=>$modTindakanSudahBayar->tindakansudahbayar_id));
                }
                $modTandaBukti = new TandabuktibayarT;
                $modTandaBukti->ruangan_id = Params::RUANGAN_ID_KASIR;
                $modTandaBukti->pembayaranpelayanan_id = $modPembayaran->pembayaranpelayanan_id;
                $modTandaBukti->shift_id = 1;
                $modTandaBukti->tglbuktibayar = $tglpendaftaran;
                $modTandaBukti->nourutkasir = MyGenerator::noUrutKasir($model->ruangan_id);
                $modTandaBukti->nobuktibayar = MyGenerator::noBuktiBayar();
                $modTandaBukti->carapembayaran = Params::CARAPEMBAYARAN_TUNAI;
                $modTandaBukti->darinama_bkm = $modPasien->no_rekam_medik.'-'.$modPasien->namadepan.' '.$modPasien->nama_pasien;
                $modTandaBukti->alamat_bkm = $modPasien->alamat_pasien;
                $modTandaBukti->sebagaipembayaran_bkm = 'BIAYA PELAYANAN RUMAH SAKIT TANGGAL'.' '.$format->formatDateTimeForUser($tglpendaftaran); ;
                $modTandaBukti->jmlpembulatan = 0;
                $modTandaBukti->jmlpembayaran = $model->total_tarif;
                $modTandaBukti->biayaadministrasi = 0;
                $modTandaBukti->biayamaterai = 0;
                $modTandaBukti->uangditerima = 0;
                $modTandaBukti->uangkembalian = 0;
                $modTandaBukti->create_time = $tglpendaftaran;
                $modTandaBukti->create_loginpemakai_id = $model->create_loginpemakai_id;
                $modTandaBukti->create_ruangan = Params::RUANGAN_ID_KASIR;
                $modTandaBukti->isprint = FALSE;
                $modTandaBukti->bank_id = Params::BANK_ID_BNI;
                $modTandaBukti->bank_nama = Params::BANK_NAMA_BNI;
                $modTandaBukti->bank_nominal = $model->total_tarif;
                $modTandaBukti->save();
                if($model->save()){
                    BuatjanjipoliT::model()->updateByPk($model->buatjanjipoli_id, array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'no_antrianjanji' =>$modPendaftaran->no_urutantri));
                    MOPendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id, 'karcis_id'=>$modPelayanan->karcis_id));
                    PembayaranpelayananT::model()->updateByPk($modPembayaran->pembayaranpelayanan_id, array('tandabuktibayar_id'=>$modTandaBukti->tandabuktibayar_id));
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Konfirmasi berhasil!';
                    $data['pesanerror'] = 'Pembayaran Telah Berhasil! Silakan Menuju Ke Beranda Untuk melihat Detail Reservasi';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Konfirmasi Gagal!<br>';
                }
            }catch (Exception $exc) {
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Konfirmasi Gagal!'.MyExceptionMessage::getMessage($exc,true);
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackKonfirmasiPembayaran(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan status pasien
     * @param : $_GET['pasien_id']
     * @return json array
     */
    public function actionGetStatusPasien(){
        header("content-type:application/json");
        $data = array();
        if(isset($_GET['pasien_id'])){
            $sql = " SELECT pendaftaran_t.pendaftaran_id, pendaftaran_t.statusperiksa, pendaftaran_t.no_pendaftaran,
                    pendaftaran_t.tgl_pendaftaran, pasienadmisi_t.pasienadmisi_id
                    FROM pendaftaran_t
                    LEFT JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = pendaftaran_t.pasienadmisi_id
                    WHERE pendaftaran_t.pasien_id = ".$_GET['pasien_id']."
                    ORDER BY pendaftaran_t.tgl_pendaftaran DESC LIMIT 1 ";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if(!empty($loadDatas)){
                foreach($loadDatas AS $i => $val){
                    if($val['statusperiksa'] == Params::STATUSPERIKSA_SEDANG_DIRAWATINAP){
                        $data['sukses'] = 0;
                        $data['pesan'] = "Anda Sedang Dirawat Inap, Tidak Bisa Melakukan Pendaftaran";
                        $data['pesanerror'] ="Anda Sedang Dirawat Inap, Tidak Bisa Melakukan Pendaftaran";
                    }else if($val['statusperiksa'] == Params::STATUSPERIKSA_ANTRIAN || $val['statusperiksa'] == Params::STATUSPERIKSA_SEDANG_PERIKSA || $val['statusperiksa'] == Params::STATUSPERIKSA_SUDAH_DIPERIKSA){
                        $data['sukses'] = 0;
                        $data['pesan'] = "Mohon Maaf Anda Tidak Bisa Melakukan Reservasi Poli Karena Pemeriksaan Sebelumnya Belum Selesai. Silakan Hubungi Customer Service!";
                        $data['pesanerror'] ="Mohon Maaf Anda Tidak Bisa Melakukan Reservasi Poli Karena Pemeriksaan Sebelumnya Belum Selesai. Silakan Hubungi Customer Service!";
                    }else{
                        $data['pesan'] = "Silakan Daftar!";
                        $data['sukses'] = 1;
                    }
                }
            }else{
                $data['pesan'] = "Silakan Daftar!";
                $data['sukses'] = 1;
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackStatusPasien(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * transaksi pendaftaran RJ
     * @param $_GET['pasien_id']
     * @param $_GET['buatpendaftaran'] array() / serialize
     * @return json
     */
    public function actionPendaftaranRJ(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter'; 
        $data['pesanerror'] =''; 
        
        $tglpendaftaran = date("Y-m-d H:i:s");
        $loginpemakai = MOLoginpemakaiK::model()->findByAttributes(array('loginpemakai_id'=>$_GET['loginpemakai_id']));
        $modPasien = MOPasienM::model()->findByAttributes(array('pasien_id'=>$_GET['pasien_id']));
        $modInstalasi = RuanganM::model()->findByAttributes(array('ruangan_id'=>$_GET['buatpendaftaran']['ruangan_id']));
        $kasuspenyakitruangan = KasuspenyakitruanganM::model()->findByAttributes(array('ruangan_id'=>$_GET['buatpendaftaran']['ruangan_id']));
        $jeniskasuspenyakit = JeniskasuspenyakitM::model()->findByAttributes(array('jeniskasuspenyakit_id'=>$kasuspenyakitruangan->jeniskasuspenyakit_id));
        $penjaminpasien = PenjaminpasienM::model()->findByAttributes(array('penjamin_id'=>$_GET['buatpendaftaran']['penjamin_id']));
        if(isset($_GET['pasien_id']) && isset($_GET['loginpemakai_id']) && isset($_GET['buatpendaftaran']) && isset($_GET['buatpendaftaransep']) && isset($_GET['buatpendaftaranrujukan']) && isset($_GET['buatpendaftaranasuransi'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model = new MOPendaftaranT;
                $model->attributes = $_GET['buatpendaftaran'];
                $model->pasien_id = $_GET['pasien_id'];
                $model->tgl_pendaftaran = $tglpendaftaran;         
                $model->ruangan_id = $_GET['buatpendaftaran']['ruangan_id'];
                $model->pegawai_id = $_GET['buatpendaftaran']['pegawai_id'];
                $model->carabayar_id = 2;
                $model->penjamin_id = $_GET['buatpendaftaran']['penjamin_id'];
                $model->no_rujukan = $_GET['buatpendaftaran']['no_rujukan'];
                $model->shift_id = 1;
                $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
                $model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
                $model->jeniskasuspenyakit_id = $jeniskasuspenyakit->jeniskasuspenyakit_id;
                $model->instalasi_id = (isset($modInstalasi->instalasi_id) ? $modInstalasi->instalasi_id : null);
                $model->no_urutantri = MyGenerator::noAntrian($_GET['buatpendaftaran']['ruangan_id']);
                $model->no_pendaftaran = MyGenerator::noPendaftaran($modInstalasi->instalasi_id, $tglpendaftaran);
                $model->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
                $model->create_loginpemakai_id = $_GET['loginpemakai_id'];
                $model->statuspasien =  Params::STATUSPASIEN_LAMA; 
                $model->kelaspelayanan_id =  6; //tanpa kelas
                $model->kunjungan = CustomFunction::getKunjungan($modPasien, $_GET['buatpendaftaran']['ruangan_id']);
                $model->create_time = date("Y-m-d H:i:s"); 
                $model->statusmasuk = Params::STATUSMASUK_NONRUJUKAN; 
                $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
                $modbpjs = new SepT();
                $modbpjs->attributes = $_GET['buatpendaftaransep'];
                $modbpjs->tglsep = date("Y-m-d H:i:s");
                $modbpjs->nosep = "Test"; //smentara
                $modbpjs->nokartuasuransi = $_GET['buatpendaftaransep']['nokartuasuransi'];
                $modbpjs->tglrujukan = date("Y-m-d H:i:s");
                $modbpjs->ppkrujukan = 1;
                $modbpjs->norujukan = $model->no_rujukan;
                $modbpjs->ppkpelayanan = 1;
                $modbpjs->jnspelayanan = 2;
                $modbpjs->diagnosaawal = "Test"; //sementara
                $modbpjs->catatansep = $_GET['buatpendaftaransep']['catatansep'];
                $modbpjs->create_time = date("Y-m-d H:i:s");
                $modbpjs->create_loginpemakai_id = $_GET['loginpemakai_id'];
                $modbpjs->create_ruangan = $modInstalasi->instalasi_id;
                $modbpjs->politujuan = $_GET['buatpendaftaransep']['politujuan'];
                $modbpjs->save();
                $modRujukan = new MORujukanT();   
                $modRujukan->asalrujukan_id = $modbpjs->politujuan;
                $modRujukan->no_rujukan = $model->no_rujukan;
                $modRujukan->tanggal_rujukan = date("Y-m-d H:i:s");
                $modRujukan->nama_perujuk = $_GET['buatpendaftaranrujukan']['nama_perujuk'];
                $modRujukan->save();
                $modAsuransi = new AsuransipasienM();   
                $modAsuransi->pasien_id = $_GET['pasien_id'];
                $modAsuransi->penjamin_id = $model->penjamin_id;
                $modAsuransi->carabayar_id = $model->carabayar_id;
                $modAsuransi->nokartuasuransi = $modbpjs->nokartuasuransi;
                $modAsuransi->carabayar_id = $model->carabayar_id;
                $modAsuransi->nopeserta = $_GET['buatpendaftaranasuransi']['nopeserta'];
                $modAsuransi->namapemilikasuransi = $_GET['buatpendaftaranasuransi']['namapemilikasuransi'];
                $modAsuransi->tglcetakkartuasuransi = date("Y-m-d H:i:s");
                $modAsuransi->create_loginpemakai_id = $_GET['loginpemakai_id'];
                $modAsuransi->kelastanggunganasuransi_id = 1;
                $modAsuransi->create_time = date("Y-m-d H:i:s");
                $modAsuransi->save();
                if($model->save()){
                    if(!empty($model->antrian_id)) {
                        AntrianT::model()->updateByPk($model->antrian_id, array('pendaftaran_id' => $model->pendaftaran_id));
                    }
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Pendaftaran berhasil!'; 
                    $data['pesanerror'] ='Pendaftaran berhasil!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Pendaftaran gagal!<br>'.CHtml::errorSummary($model);
                    $data['pesanerror'] ='Form harus di isi !';
                }
                
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Pendaftaran gagal!'.MyExceptionMessage::getMessage($exc,true);
            }

        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackPendaftaranRJ(".$encode.")";
        Yii::app()->end();
    }

    /**
     * transaksi komentar berita pasien
     * MA-124
     * @param $_GET['pasien_id']
     * @param $_GET['mberita_id']
     * @param $_GET['isikomentar'] text
     * @return json
     */
    public function actionKomentariBerita(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        if(isset($_GET['pasien_id']) && isset($_GET['mberita_id']) && isset($_GET['isikomentar'])){
            $pasien_id = $_GET['pasien_id'];
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $sql = "SELECT *
                        FROM pasien_m
                        WHERE pasien_id = ".$pasien_id;
                $loadDatas = Yii::app()->db->createCommand($sql)->queryRow();
                $model = new MOMberitakomentarT();
                $model->mberita_id = $_GET['mberita_id'];
                $model->tglkomentar = date("Y-m-d H:i:s");
                $model->isikomentar = str_replace('"','',str_replace("'","",$_GET['isikomentar']));
                if($loadDatas){
                    $model->namakomentar = $loadDatas['nama_pasien'].", ".$loadDatas['namadepan']." / No.RM: ".$loadDatas['no_rekam_medik'];
                    $model->emailkomentar = (empty($loadDatas['alamatemail']) ? "-" : $loadDatas['alamatemail']);
                    $model->tampilkankomentar = TRUE;
                }else{
                    $model->namakomentar = "Tidak dikenal";
                    $model->emailkomentar = "-";
                    $model->tampilkankomentar = FALSE;
                }

                if($model->save()){
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Komentar berita berhasil dikirim!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Komentar berita gagal dikirim!<br>'.CHtml::errorSummary($model);
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Komentar berita gagal dikirim!'.MyExceptionMessage::getMessage($exc,true);
            }

        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan ruangan soetomo berdasarkan jamtutuppoli
     * @param : $_GET['ruangan_id']
     * @return json array
     */
    public function actionHideBatal(){
        header("content-type:application/json");
        $data = array();
        if(isset($_GET['buatjanjipoli_id'])){
            $sql = "SELECT * FROM buatjanjipoli_t WHERE buatjanjipoli_id = ".$_GET['buatjanjipoli_id']." " ;
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if(!empty($loadDatas)){
                foreach($loadDatas AS $i => $val){
                    $data[$i] = $val;
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackHideBatal(".$encode.")";
        Yii::app()->end();
    }

    /**
     * Set form dashboard pasien
     * MA-145
     */
    public function actionSetDashboardPasien(){
        header("content-type:application/json");
        $data = array();
        $data['janjipoli'] = array();
        $data['pemeriksaanfisik'] = array();
        $data['anamnesa'] = array();
        $data['pendaftaran'] = array();
        if(isset($_GET['pasien_id'])){
            $pasien_id = $_GET['pasien_id'];
            $pendaftaran_id = !isset($_GET['pendaftaran_id'])?'':$_GET['pendaftaran_id'];
            $sql = "SELECT *
                    FROM pendaftaran_t
                    ".(!empty($pendaftaran_id)?" WHERE pendaftaran_id = ".$pendaftaran_id:"")."
                    ORDER BY tgl_pendaftaran DESC
                    LIMIT 1";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryRow();
            if(!empty($loadDatas)){
                $data['pendaftaran'] = $loadDatas;
                $data['anamnesa'] = $this->getRiwayatAnamnesa($loadDatas['pendaftaran_id']);
                $data['pemeriksaanfisik'] = $this->getRiwayatPemeriksaanFisik($loadDatas['pendaftaran_id']);
                $data['janjipoli'] = $this->getJanjiPoliPasien($pasien_id);
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackDashboard(".$encode.")";
        Yii::app()->end();
    }

    /**
     * Menampilkan janji poliklinik
     * MA-145
     * @param type $pasien_id
     * @return type
     */
    protected function getJanjiPoliPasien($pasien_id){
        $format = new MyFormatter();
        $data = array();
        $sql = " SELECT buatjanjipoli_t.pendaftaran_id,
            buatjanjipoli_t.tgljadwal AS tgljadwal, buatjanjipoli_t.buatjanjipoli_id, buatjanjipoli_t.no_buatjanji, 
            buatjanjipoli_t.pasien_id, buatjanjipoli_t.code_booking, buatjanjipoli_t.bukti_pembayaran, 
            buatjanjipoli_t.kelaspelayanan_id, buatjanjipoli_t.penjamin_id, buatjanjipoli_t.carabayar_id, buatjanjipoli_t.tglbuatjanji,
            buatjanjipoli_t.estimasiperiksa, buatjanjipoli_t.ruangan_id, pendaftaran_t.statusperiksa,
            pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
            ruangan_m.ruangan_nama, jadwalbukapoli_m.jammulai, jadwalbukapoli_m.jadwalbukapoli_id
            FROM buatjanjipoli_t
            LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = buatjanjipoli_t.pegawai_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = buatjanjipoli_t.pendaftaran_id
            LEFT JOIN ruangan_m ruangdaftar ON ruangdaftar.ruangan_id = pendaftaran_t.ruangan_id
            LEFT JOIN pegawai_m pegawaidaftar ON pegawaidaftar.pegawai_id = pegawai_m.pegawai_id
            JOIN jadwalbukapoli_m ON jadwalbukapoli_m.jadwalbukapoli_id = buatjanjipoli_t.jadwalbukapoli_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = buatjanjipoli_t.ruangan_id
            WHERE buatjanjipoli_t.pasien_id = ".$pasien_id."
            AND DATE(buatjanjipoli_t.tgljadwal) >= '".date("Y-m-d")."' AND buatjanjipoli_t.is_aktif = TRUE
            ORDER BY buatjanjipoli_id DESC
            LIMIT 5 ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($loadDatas)){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tgljadwal'] = $format->formatDateTimeId($val['tgljadwal']);
                $data[$i]['jamAkhir'] = date("H:i:s", strtotime($val['estimasiperiksa'].'+1 hours'));
                $data[$i]['tglbuatjanji'] = date("Y-m-d", strtotime($val['tglbuatjanji']));
                $data[$i]['jammulai'] = date("H:i:s", strtotime($val['jammulai']));
                $data[$i]['statusperiksa'] = $val['statusperiksa'];
            }
        }
        return $data;
    }
    /**
     * Menampilkan rencana kontrol
     * MA-145
     * @param type $pasien_id
     * @return type
     */
    protected function getRencanaKontrolPasien($pasien_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "
            SELECT
                pendaftaran_t.pendaftaran_id, 
                pendaftaran_t.no_pendaftaran, 
                pendaftaran_t.tglrenkontrol, 
                dokterpenunjang_m.gelardepan as dokterpenunjanggelardepan, 
                dokterpenunjang_m.nama_pegawai as dokterpenunjang_nama, 
                gelarbelakangpenunjang_m.gelarbelakang_nama as dokterpenunjanggelarbelakang,
                ruanganpenunjang_m.ruangan_nama as ruanganpenunjang_nama,
                pegawai_m.gelardepan, 
                pegawai_m.nama_pegawai, 
                gelarbelakang_m.gelarbelakang_nama ,
                ruangan_m.ruangan_nama 
            FROM pendaftaran_t
            LEFT JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
            JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
            LEFT JOIN ruangan_m ruanganpenunjang_m ON ruanganpenunjang_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
            LEFT JOIN pegawai_m dokterpenunjang_m ON dokterpenunjang_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
            JOIN pegawai_m ON pendaftaran_t.pegawai_id = pegawai_m.pegawai_id
            LEFT JOIN gelarbelakang_m gelarbelakangpenunjang_m ON gelarbelakangpenunjang_m.gelarbelakang_id = dokterpenunjang_m.gelarbelakang_id
            LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
            WHERE pendaftaran_t.tglrenkontrol IS NOT NULL
                AND pendaftaran_t.pasien_id = ".$pasien_id."
                AND DATE(pendaftaran_t.tglrenkontrol) >= '".date("Y-m-d")." 00:00:00'
            ORDER BY tglrenkontrol ASC
            LIMIT 5
            ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($loadDatas)){
            foreach($loadDatas AS $i => $val){
                if($i > 0){
                    if($val['tglrenkontrol'] != $loadDatas[$i-1]['tglrenkontrol']){
                        $data[$i] = $val;
                        $data[$i]['tglrenkontrol'] = $format->formatDateTimeId($val['tglrenkontrol']);
                    }
                }else{
                    $data[$i] = $val;
                    $data[$i]['tglrenkontrol'] = $format->formatDateTimeId($val['tglrenkontrol']);
                }
            }
        }
        return $data;
    }

    public function actionGetInfoKelasPelayanan(){
        $format = new MyFormatter();
        $data = array();
        $sql = "
            SELECT * FROM kelaspelayanan_m";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallKelasPelayanan(".$encode.")";
        Yii::app()->end();
    }
    /**
     * Menampilkan rencana kontrol
     * MA-145
     * @param type $pasien_id
     * @return type
     */
    protected function getBookingKamarPasien($pasien_id){
        $format = new MyFormatter();
        $data = array();
        $sql = "
            SELECT bookingkamar_t.bookingkamar_id, bookingkamar_t.bookingkamar_no, bookingkamar_t.tgltransaksibooking, bookingkamar_t.tglbookingkamar, bookingkamar_t.statusbooking, bookingkamar_t.keteranganbooking, bookingkamar_t.statuskonfirmasi,
            kelaspelayanan_m.kelaspelayanan_nama,
            ruangan_m.ruangan_nama,
            kamarruangan_m.kamarruangan_nokamar, kamarruangan_m.kamarruangan_nobed
            FROM bookingkamar_t
            JOIN ruangan_m ON ruangan_m.ruangan_id = bookingkamar_t.ruangan_id
            JOIN kamarruangan_m ON kamarruangan_m.kamarruangan_id = bookingkamar_t.kamarruangan_id
            JOIN kelaspelayanan_m ON kelaspelayanan_m.kelaspelayanan_id = bookingkamar_t.kelaspelayanan_id
            WHERE bookingkamar_t.pasien_id = ".$pasien_id."
                AND DATE(bookingkamar_t.tglbookingkamar) >= '".date("Y-m-d")."'
            ORDER BY tglbookingkamar ASC
            LIMIT 100
            ";
        $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($loadDatas)){
            foreach($loadDatas AS $i => $val){
                $data[$i] = $val;
                $data[$i]['tgltransaksibooking'] = $format->formatDateTimeId($val['tgltransaksibooking']);
            }
        }
        return $data;
    }

    /**
     * Set get jumlah antrian ke pendaftaran untuk dashboard pasien
     * MA-152
     * @params $_GET['pasien_id']
     * @return
     * $data['totalantrian'] = array(array());
     * $data['sisaantrian'] = array(array());
     */
    public function actionGetAntrianKePendaftaran(){
        header("content-type:application/json");
        $data = array();
        $data['totalantrian']=array();
        $data['sisaantrian']=array();
        if(isset($_GET['pasien_id'])){

            $sql = "SELECT loket_m.loket_id, loket_m.loket_nama, COUNT(antrian_t.loket_id) AS jumlah
                    FROM antrian_t
                    LEFT JOIN loket_m ON loket_m.loket_id = antrian_t.loket_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = antrian_t.ruangan_id
                    JOIN carabayar_m ON carabayar_m.carabayar_id = antrian_t.carabayar_id
                    WHERE DATE(antrian_t.tglantrian) = '".date("Y-m-d")."'
                        AND ruangan_m.ruangan_id = ".Params::DEFAULT_RUANGAN_KIOSK."
                    GROUP BY antrian_t.loket_id, loket_m.loket_id, loket_m.loket_nama";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if($loadDatas){
                $data['totalantrian'] = $loadDatas;
            }

            $sql = "SELECT loket_m.loket_id, loket_m.loket_nama, COUNT(antrian_t.loket_id) AS jumlah
                    FROM antrian_t
                    LEFT JOIN loket_m ON loket_m.loket_id = antrian_t.loket_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = antrian_t.ruangan_id
                    JOIN carabayar_m ON carabayar_m.carabayar_id = antrian_t.carabayar_id
                    WHERE DATE(antrian_t.tglantrian) = '".date("Y-m-d")."'
                        AND ruangan_m.ruangan_id = ".Params::DEFAULT_RUANGAN_KIOSK."
                        AND (antrian_t.panggil_flaq = FALSE)
                    GROUP BY antrian_t.loket_id, loket_m.loket_id, loket_m.loket_nama";

            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if($loadDatas){
                $data['sisaantrian'] = $loadDatas;
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackPendaftaran(".$encode.")";
        Yii::app()->end();
    }
    /**
     * Set get jumlah antrian ke poliklinik untuk dashboard pasien
     * MA-152
     * @params $_GET['pasien_id']
     * @return
     * $data['antrianpasien']=array();
     * $data['antriandipanggil']=array();
     * $data['totalantrian']=0;
     * $data['sisaantrian']=0;
     */
    public function actionGetAntrianKePoliklinik(){
        header("content-type:application/json");
        $data = array();
        $data['antrianpasien']=array();
        $data['antriandipanggil']=array();
        $data['totalantrian']=0;
        $data['sisaantrian']=0;
        if(isset($_GET['pasien_id'])){
            $pasien_id = $_GET['pasien_id'];           
            $sql = "SELECT pendaftaran_t.pendaftaran_id, pendaftaran_t.tgl_pendaftaran,
                        pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
                        ruangan_m.ruangan_id, ruangan_m.ruangan_nama, ruangan_m.ruangan_singkatan,
                        pendaftaran_t.no_urutantri, pendaftaran_t.statusperiksa
                    FROM pendaftaran_t
                    JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                    JOIN pegawai_m ON pegawai_m.pegawai_id = pendaftaran_t.pegawai_id
                    LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                    WHERE pendaftaran_t.pasien_id = ".$pasien_id." 
                    AND DATE(pendaftaran_t.tgl_pendaftaran) = '".date('Y-m-d')."'
                    ORDER BY pendaftaran_t.tgl_pendaftaran DESC
                    LIMIT 1
                    ";
            $loadDataAntrian = Yii::app()->db->createCommand($sql)->queryRow();
            if(isset($loadDataAntrian['ruangan_id'])){
                $data['antrianpasien'] = $loadDataAntrian;

                $sql = "SELECT pendaftaran_t.pendaftaran_id, pendaftaran_t.tgl_pendaftaran,
                            pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
                            ruangan_m.ruangan_id, ruangan_m.ruangan_nama, ruangan_m.ruangan_singkatan,
                            pendaftaran_t.no_urutantri, pendaftaran_t.statusperiksa
                        FROM pendaftaran_t
                        JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                        JOIN pegawai_m ON pegawai_m.pegawai_id = pendaftaran_t.pegawai_id
                        LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                        WHERE DATE(pendaftaran_t.tgl_pendaftaran) = '".date("Y-m-d")."'
                            AND ruangan_m.ruangan_id = ".$loadDataAntrian['ruangan_id']."
                            AND pendaftaran_t.pasien_id = ".$pasien_id."
                            AND pendaftaran_t.panggilantrian = TRUE 
                        ORDER BY pendaftaran_t.no_urutantri DESC
                        LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if($loadData){
                    $data['antriandipanggil'] = $loadData;
                }

                $sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama, COUNT(pendaftaran_t.pendaftaran_id) AS jumlah
                        FROM pendaftaran_t
                        JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                        WHERE DATE(pendaftaran_t.tgl_pendaftaran) = '".date("Y-m-d")."'
                            AND ruangan_m.ruangan_id = ".$loadDataAntrian['ruangan_id']." AND pendaftaran_t.pasien_id = ".$pasien_id." 
                        GROUP BY ruangan_m.ruangan_id, ruangan_m.ruangan_nama
                        LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if($loadData){
                    $data['totalantrian'] = $loadData['jumlah'];
                }
                $sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama, COUNT(pendaftaran_t.pendaftaran_id) AS jumlah
                        FROM pendaftaran_t
                        JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                        WHERE DATE(pendaftaran_t.tgl_pendaftaran) = '".date("Y-m-d")."'
                            AND ruangan_m.ruangan_id = ".$loadDataAntrian['ruangan_id']." AND pendaftaran_t.pasien_id =  ".$pasien_id." 
                            AND (pendaftaran_t.panggilantrian = FALSE OR pendaftaran_t.statusperiksa <> '".Params::STATUSPERIKSA_ANTRIAN."')
                        GROUP BY ruangan_m.ruangan_id, ruangan_m.ruangan_nama
                        LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if($loadData){
                    $data['sisaantrian'] = $loadData['jumlah'];
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackPoliklinik(".$encode.")";
        Yii::app()->end();
    }

    /**
     * Set get jumlah antrian ke farmasi apotek (pengambilan obat) untuk dashboard pasien
     * MA-156
     * @params $_GET['pasien_id']
     * @return
     * $data['antrianpasien']=array();
     * $data['antriandipanggil']=array();
     * $data['totalantrian'] = array(array());
     * $data['sisaantrian'] = array(array());
     */
    public function actionGetAntrianKeFarmasi(){
        header("content-type:application/json");
        $data = array();
        $data['antrianpasien']=array();
        $data['antriandipanggil']=array();
        $data['totalantrian']=0;
        $data['sisaantrian']=0;
        if(isset($_GET['pasien_id'])){
            $pasien_id = $_GET['pasien_id'];
            $sql_OR = "SELECT antrianfarmasi_t.antrianfarmasi_id, antrianfarmasi_t.tglambilantrian, antrianfarmasi_t.noantrian,
                    racikan_m.racikan_id, racikan_m.racikan_nama, racikan_m.racikan_singkatan,
                    penjualanresep_t.noresep, pasien_m.namadepan, pasien_m.nama_pasien
                    FROM antrianfarmasi_t
                    JOIN racikan_m ON racikan_m.racikan_id = antrianfarmasi_t.racikan_id
                    LEFT JOIN penjualanresep_t ON penjualanresep_t.antrianfarmasi_id = antrianfarmasi_t.antrianfarmasi_id
                    LEFT JOIN pasien_m ON pasien_m.pasien_id = penjualanresep_t.pasien_id
                    WHERE DATE(antrianfarmasi_t.tglambilantrian) = '".date("Y-m-d")."'
                    AND penjualanresep_t.pasien_id = ".$pasien_id." 
                    AND antrianfarmasi_t.racikan_id = 1 
                    ORDER BY antrianfarmasi_t.noantrian DESC
                    LIMIT 1
                    ";
            $sql_NR = "SELECT antrianfarmasi_t.antrianfarmasi_id, antrianfarmasi_t.tglambilantrian, antrianfarmasi_t.noantrian,
                    racikan_m.racikan_id, racikan_m.racikan_nama, racikan_m.racikan_singkatan,
                    penjualanresep_t.noresep, pasien_m.namadepan, pasien_m.nama_pasien
                    FROM antrianfarmasi_t
                    JOIN racikan_m ON racikan_m.racikan_id = antrianfarmasi_t.racikan_id
                    LEFT JOIN penjualanresep_t ON penjualanresep_t.antrianfarmasi_id = antrianfarmasi_t.antrianfarmasi_id
                    LEFT JOIN pasien_m ON pasien_m.pasien_id = penjualanresep_t.pasien_id
                    WHERE DATE(antrianfarmasi_t.tglambilantrian) = '".date("Y-m-d")."'
                    AND penjualanresep_t.pasien_id = ".$pasien_id." 
                    AND antrianfarmasi_t.racikan_id = 2 
                    ORDER BY antrianfarmasi_t.noantrian DESC
                    LIMIT 1
                    ";
            $loadData_OR = Yii::app()->db->createCommand($sql_OR)->queryRow();
            $loadData_NR = Yii::app()->db->createCommand($sql_NR)->queryRow();
            if(isset($loadData_OR['antrianfarmasi_id'])){
                $data['antrianpasien']['OR'] = $loadData_OR;
            } 
            if(isset($loadData_NR['antrianfarmasi_id'])){
                $data['antrianpasien']['NR'] = $loadData_NR;
            }
            //TETAP TAMPILKAN ANTRIAN FARMASI MESKI BELUM MENGANTRI
            $sql = "SELECT antrianfarmasi_t.antrianfarmasi_id, antrianfarmasi_t.tglambilantrian, antrianfarmasi_t.noantrian,
                    racikan_m.racikan_id, racikan_m.racikan_nama, racikan_m.racikan_singkatan,
                    penjualanresep_t.noresep, pasien_m.namadepan, pasien_m.nama_pasien
                    FROM antrianfarmasi_t
                    JOIN racikan_m ON racikan_m.racikan_id = antrianfarmasi_t.racikan_id
                    LEFT JOIN penjualanresep_t ON penjualanresep_t.antrianfarmasi_id = antrianfarmasi_t.antrianfarmasi_id
                    LEFT JOIN pasien_m ON pasien_m.pasien_id = penjualanresep_t.pasien_id
                    WHERE antrianfarmasi_t.panggilantrian = TRUE
                        AND DATE(antrianfarmasi_t.tglambilantrian) = '".date("Y-m-d")."' 
                        ".(isset($loadData['racikan_id']) ? " AND racikan_m.racikan_id = ".$loadData['racikan_id'] : "")."
                    ORDER BY antrianfarmasi_t.noantrian DESC
                    LIMIT 1";
            $loadData = Yii::app()->db->createCommand($sql)->queryRow();
            if($loadData){
                $data['antriandipanggil'] = $loadData;
            }

            $sql = "SELECT racikan_m.racikan_id, racikan_m.racikan_nama, racikan_m.racikan_singkatan,
                    COUNT(antrianfarmasi_t.antrianfarmasi_id) AS jumlah
                    FROM antrianfarmasi_t
                    JOIN racikan_m ON racikan_m.racikan_id = antrianfarmasi_t.racikan_id
                    LEFT JOIN penjualanresep_t ON penjualanresep_t.antrianfarmasi_id = antrianfarmasi_t.antrianfarmasi_id
                    LEFT JOIN pasien_m ON pasien_m.pasien_id = penjualanresep_t.pasien_id
                    WHERE DATE(antrianfarmasi_t.tglambilantrian) = '".date("Y-m-d")."'
                    GROUP BY racikan_m.racikan_id, racikan_m.racikan_nama, racikan_m.racikan_singkatan";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if($loadDatas){
                $data['totalantrian'] = $loadDatas;
            }
            $sql = "SELECT racikan_m.racikan_id, racikan_m.racikan_nama, racikan_m.racikan_singkatan,
                    COUNT(antrianfarmasi_t.antrianfarmasi_id) AS jumlah
                    FROM antrianfarmasi_t
                    JOIN racikan_m ON racikan_m.racikan_id = antrianfarmasi_t.racikan_id
                    LEFT JOIN penjualanresep_t ON penjualanresep_t.antrianfarmasi_id = antrianfarmasi_t.antrianfarmasi_id
                    LEFT JOIN pasien_m ON pasien_m.pasien_id = penjualanresep_t.pasien_id
                    WHERE DATE(antrianfarmasi_t.tglambilantrian) = '".date("Y-m-d")."' 
                        AND antrianfarmasi_t.panggilantrian = FALSE
                    GROUP BY racikan_m.racikan_id, racikan_m.racikan_nama, racikan_m.racikan_singkatan";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if($loadDatas){
                $data['sisaantrian'] = $loadDatas;
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackFarmasi(".$encode.")";
        Yii::app()->end();
    }

    /**
     * Set get jumlah antrian ke penunjang (pasien luar rs) untuk dashboard pasien
     * MA-156
     * @params $_GET['pasien_id']
     * @return
     * $data['antrianpasien']=array();
     * $data['antriandipanggil']=array();
     * $data['totalantrian'] = 0;
     * $data['sisaantrian'] = 0;
     */
    public function actionGetAntrianKePenunjang(){
        header("content-type:application/json");
        $data = array();
        $data['antrianpasien']=array();
        $data['antriandipanggil']=array();
        $data['totalantrian']=0;
        $data['sisaantrian']=0;
        if(isset($_GET['pasien_id'])){
            $pasien_id = $_GET['pasien_id'];
           
            $sql = "SELECT pendaftaran_id, tgl_pendaftaran, ruangan_id, ruangan_nama, 
                    ruangan_singkatan, no_urutperiksa,no_masukpenunjang, statusperiksa,nama_pegawai
                    FROM PasienMasukPenunjang_V WHERE pasien_id = ".$pasien_id." 
                    AND DATE(tglmasukpenunjang) = '".date('Y-m-d')."'
                    ORDER BY tglmasukpenunjang DESC
                    LIMIT 1
                    ";
            $loadData = Yii::app()->db->createCommand($sql)->queryRow();
            if(isset($loadData['ruangan_id'])){
                $data['antrianpasien'] = $loadData;

                $sql = "SELECT pendaftaran_id, tgl_pendaftaran, ruangan_id, ruangan_nama, 
                        ruangan_singkatan, no_urutperiksa,no_masukpenunjang, statusperiksa,nama_pegawai
                        FROM PasienMasukPenunjang_V 
                        WHERE DATE(tglmasukpenunjang) = '".date("Y-m-d")."'
                        AND ruangan_id = ".$loadData['ruangan_id']."
                        ORDER BY tglmasukpenunjang DESC
                        LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if($loadData){
                    $data['antriandipanggil'] = $loadData;
                }

                $sql = "SELECT ruangan_id,ruangan_nama,COUNT(pasienmasukpenunjang_id) AS jumlah
                        FROM PasienMasukPenunjang_V 
                        WHERE DATE(tglmasukpenunjang) = '".date("Y-m-d")."' 
                            AND ruangan_id = ".$loadData['ruangan_id']."
                        GROUP BY ruangan_id,ruangan_nama
                        LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if($loadData){
                    $data['totalantrian'] = $loadData['jumlah'];
                }
                $sql = "SELECT ruangan_id,ruangan_nama,COUNT(pasienmasukpenunjang_id) AS jumlah
                        FROM PasienMasukPenunjang_V 
                        WHERE DATE(tglmasukpenunjang) = '".date("Y-m-d")."'
                        AND ruangan_id = ".$loadData['ruangan_id']."
                        AND (panggilantrian = TRUE OR statusperiksa = '".Params::STATUSPERIKSA_ANTRIAN."')
                        GROUP BY ruangan_id, ruangan_nama
                        LIMIT 1";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if($loadData){
                    $data['sisaantrian'] = $loadData['jumlah'];
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackPenunjang(".$encode.")";
        Yii::app()->end();
    }

    /**
     * Set get jumlah antrian ke penunjang (pasien luar rs) untuk dashboard pasien
     * MA-156
     * @params $_GET['pasien_id']
     * @return
     * $data['antrianpasien']=array();
     * $data['antriandipanggil']=array();
     * $data['totalantrian'] = array(array());
     * $data['sisaantrian'] = array(array());
     */
    public function actionGetAntrianKeKasir(){
        header("content-type:application/json");
        $data = array();
        $data['totalantrian']=array();
        $data['sisaantrian']=array();
        if(isset($_GET['pasien_id'])){

            $sql = "SELECT loket_m.loket_id, loket_m.loket_nama, COUNT(antrian_t.loket_id) AS jumlah
                    FROM antrian_t
                    LEFT JOIN loket_m ON loket_m.loket_id = antrian_t.loket_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = antrian_t.ruangan_id
                    JOIN carabayar_m ON carabayar_m.carabayar_id = antrian_t.carabayar_id
                    WHERE DATE(antrian_t.tglantrian) = '".date("Y-m-d")."'
                        AND ruangan_m.ruangan_id = ".Params::DEFAULT_RUANGAN_KIOSK_KASIR."
                    GROUP BY antrian_t.loket_id, loket_m.loket_id, loket_m.loket_nama";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if($loadDatas){
                $data['totalantrian'] = $loadDatas;
            }

            $sql = "SELECT loket_m.loket_id, loket_m.loket_nama, COUNT(antrian_t.loket_id) AS jumlah
                    FROM antrian_t
                    LEFT JOIN loket_m ON loket_m.loket_id = antrian_t.loket_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = antrian_t.ruangan_id
                    JOIN carabayar_m ON carabayar_m.carabayar_id = antrian_t.carabayar_id
                    WHERE DATE(antrian_t.tglantrian) = '".date("Y-m-d")."'
                        AND ruangan_m.ruangan_id = ".Params::DEFAULT_RUANGAN_KIOSK_KASIR."
                        AND (antrian_t.panggil_flaq = FALSE)
                    GROUP BY antrian_t.loket_id, loket_m.loket_id, loket_m.loket_nama";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if($loadDatas){
                $data['sisaantrian'] = $loadDatas;
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackAntrianKasir(".$encode.")";
        Yii::app()->end();
    } 
    
    
    //hemodialisa 
      //jadwalhemodialisa 
      public function actionGetRiwayatJadwalHD(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array(); 
        
        if(isset($_GET['pasien_id']) && isset($_GET['pendaftaranID'])){
            $pasien_id = $_GET['pasien_id'];
            $pendaftaran_id = $_GET['pendaftaranID'];   
            $queryPendaftaran = !empty($pendaftaran_id)?' AND pendaftaran_t.pendaftaran_id = '.$pendaftaran_id:'';                  
          
               $sql_terakhir = "SELECT pendaftaran_t.pendaftaran_id,pendaftaran_t.pasien_id,
                           no_pendaftaran,statusperiksa,
                           (CASE WHEN pendaftaran_t.pasienadmisi_id IS NOT NULL THEN ruanganadmisi_m.ruangan_nama ELSE ruangan_m.ruangan_nama END) AS ruangan_nama,
                           instalasi_nama, TO_CHAR(tgl_pendaftaran,'d Mon YYYY HH24:MI') AS tgl_pendaftaran,
                           pendaftaran_t.pasienpulang_id,kelaspelayanan_nama,carabayar_nama FROM 
                    pendaftaran_t 
                    LEFT JOIN pasienadmisi_t ON pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id
                    LEFT JOIN ruangan_m ruanganadmisi_m ON ruanganadmisi_m.ruangan_id = pasienadmisi_t.ruangan_id
                    JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id 
                    JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
                    JOIN kelaspelayanan_m ON pendaftaran_t.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
                    JOIN carabayar_m ON pendaftaran_t.carabayar_id = carabayar_m.carabayar_id
                    WHERE pendaftaran_t.pasien_id = ".$pasien_id." ".$queryPendaftaran."
                    AND pendaftaran_t.pasienbatalperiksa_id IS NULL 
                    ORDER BY tgl_pendaftaran DESC limit 1";
                $loadData = Yii::app()->db->createCommand($sql_terakhir)->queryRow();
                if(count($loadData) > 0){        
                        $data['no_pendaftaran']['pendaftaran'] = $loadData; 
                        $data['no_pendaftaran']['jadwalhemodialisa'] = $this->getJadwalHemodialisa($loadData['pasien_id']);        
                             
            }
            
     
        }
        $encode = CJSON::encode($data);
        //echo "jsonCallback(".$encode.")";
        echo "jsonCallbackJadwahHD(".$encode.")";
        Yii::app()->end();
    } 


// get riwayat jadwal hemodialisa 
     protected function getJadwalHemodialisa($pasien_id){
        $format = new MyFormatter();
        $data = array(); 
        $no = 1;
        $sql = "SELECT jadwalhemodialisa_t.jadwalhemodialisa_id,jadwalhemodialisa_t.pasien_id,
                       pasien_m.nama_pasien,jadwalhemodialisa_t.pendaftaran_id, 
                       pasien_m.no_rekam_medik, 
                       pasien_m.jeniskelamin, 
                       ruangan_m.ruangan_nama, 
                       ruangan_m.ruangan_id, 
                       jadwalhemodialisa_t.ruangan_id, 
                       shift_m.shift_nama, 
                       shift_m.shift_id,  
                       jadwalhemodialisa_t.jadwalhemodialisa_tgl_ke, 
                       jadwalhemodialisa_t.jadwalhemodialisa_hari, 
                       jadwalhemodialisa_t.pendaftaran_id
            FROM jadwalhemodialisa_t
            LEFT JOIN ruangan_m ON ruangan_m.ruangan_id= jadwalhemodialisa_t.ruangan_id
            LEFT JOIN pasien_m ON pasien_m.pasien_id= jadwalhemodialisa_t.pasien_id 
            LEFT JOIN shift_m ON shift_m.shift_id= jadwalhemodialisa_t.shift_id
                where jadwalhemodialisa_t.pasien_id = ".$pasien_id." 
                     ORDER BY jadwalhemodialisa_id DESC";
             $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($loadDatas) > 0){
            foreach($loadDatas AS $i => $val){ 
//                
                $data[$i] = $val;
                $data[$i]['nama_pasien'] = $val['nama_pasien']; 
                $data[$i]['no_rekam_medik'] = $val['no_rekam_medik']; 
                $data[$i]['jeniskelamin'] = $val['jeniskelamin']; 
                $data[$i]['ruangan_nama'] = $val['ruangan_nama']; 
                $data[$i]['shift_nama'] = $val['shift_nama'];  
                $data[$i]['jadwalhemodialisa_tgl_ke'] = $val['jadwalhemodialisa_tgl_ke'];  
                $data[$i]['jadwalhemodialisa_hari'] = $val['jadwalhemodialisa_hari'];  
                $data[$i]['pendaftaran_id'] = isset($val['pendaftaran_id']) ? 'Sudah' : 'Belum';   
                $data[$i]['ke'] = $no;
                $no++;
                
            } 
           
        }
        return $data;
    }  
	
	 /**
     * set bpjs Interface
     */
    public function actionBpjsInterface() {
        $data = array();
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
		
            if (empty($_GET['param']) OR $_GET['param'] === '') {
                die('param can\'not empty value');
            } else {
                $param = $_GET['param'];
            }
            $bpjs = new Bpjs_Vklaim();

            switch ($param) {
                 case '1':
                    $query = $_GET['query'];
                     print_r($bpjs->search_kartu($query));
                    break; 
				
                case '3':
                    $query = $_GET['query'];
                     print_r($bpjs->search_rujukan_no_rujukan($query)); 
                    break; 
					
                case '4':
                    $query = $_GET['query'];
                    print_r($bpjs->search_rujukan_no_bpjs($query));
                    break;
               
                case '6':

//                    $nokartu = $_GET['no_kartu'];
//                    $tglsep = date('Y-m-d H:i:s');
//                    $tglrujukan = date('Y-m-d H:i:s');
//                    $ppkrujukan = $_GET['ppk_rujukan'];
//                    $catatan = "-";
//                    $klsrawat = $_GET['kls_rawat'];
//                    $nomr =  0;
				    $modPoli = RuanganM::model()->findByPk($_GET['poli_tujuan']);
					$nokartu = $_GET['no_kartu'];
                    $tglsep = date('Y-m-d');
                    $tglrujukan = date('Y-m-d');
                    $norujukan = '-';
                    $ppkrujukan = $_GET['ppk_rujukan'];
                    $ppkpelayanan = '1001R015';
                    $jnspelayanan = '2';
                    $lakalantas = 0;
                    $catatan = '-';
                    $diagawal = 'C12';
                    $politujuan = 'BED';
//                    $klsrawat = $_GET['kls_rawat'];
                    $user = 'iyan';
                    $nomr = 0;
                    $notrans = '-';

                    $noTelp = '089656341935';
                    $asalRujukan = 1;
                    $eksekutif = 1;
                    $cob = 0;
                    $penjamin = '-';
                    $lokasiLaka = '-';

                    
                
                    $klsrawat = 1;
                   
                   
                    print_r($bpjs->create_sep_new($nokartu, $tglsep, $ppkpelayanan, $jnspelayanan, $klsrawat, $nomr, $asalRujukan, $tglrujukan, $norujukan, $ppkrujukan, $catatan, $diagawal, $politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user));
                    break;
               
                default:
                    die('error number, please check your parameter option');
                    break;
            }
           Yii::app()->end();
		}
		
       
    }
}