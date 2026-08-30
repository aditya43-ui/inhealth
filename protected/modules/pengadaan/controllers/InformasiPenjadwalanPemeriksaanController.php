<?php
/**
 * Informasi Penjadwalan Pemeriksaan
 * 
 * @author Aida Rahmawati<aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class InformasiPenjadwalanPemeriksaanController extends MyAuthController{
    /**
     * index Informasi Penjadwalan Pemeriksaan
     */
    public function actionIndex(){
        $model = new ADPengadaanjadwalpemeriksaanT();
        $model->tanggal_awal = date("d M Y");
        $model->tanggal_akhir = date("d M Y");
        if (isset($_GET['ADPengadaanjadwalpemeriksaanT'])){
            $model->attributes = $_GET['ADPengadaanjadwalpemeriksaanT']; 
            $model->tanggal_awal = MyFormatter::formatDateTimeForDb($_GET['ADPengadaanjadwalpemeriksaanT']['tanggal_awal']);
            $model->tanggal_akhir = MyFormatter::formatDateTimeForDb($_GET['ADPengadaanjadwalpemeriksaanT']['tanggal_akhir']);
            $model->nosuratperjanjiankerja=isset($_GET['ADPengadaanjadwalpemeriksaanT']['nosuratperjanjiankerja'])?$_GET['ADPengadaanjadwalpemeriksaanT']['nosuratperjanjiankerja']:null;
            $model->nama_pekerjaan=isset($_GET['ADPengadaanjadwalpemeriksaanT']['nama_pekerjaan'])?$_GET['ADPengadaanjadwalpemeriksaanT']['nama_pekerjaan']:null;
            $model->pengadaanjadwalpemeriksaan_nomor=isset($_GET['ADPengadaanjadwalpemeriksaanT']['pengadaanjadwalpemeriksaan_nomor'])?$_GET['ADPengadaanjadwalpemeriksaanT']['pengadaanjadwalpemeriksaan_nomor']:null;
            $model->supplier_nama=isset($_GET['ADPengadaanjadwalpemeriksaanT']['supplier_nama'])?$_GET['ADPengadaanjadwalpemeriksaanT']['supplier_nama']:null;
            $model->pengadaanjadwalpemeriksaan_status=isset($_GET['ADPengadaanjadwalpemeriksaanT']['pengadaanjadwalpemeriksaan_status'])?$_GET['ADPengadaanjadwalpemeriksaanT']['pengadaanjadwalpemeriksaan_status']:null;
        }
        
        $this->render('index', array('model' => $model)); 
    }
    
    /**
     * Detail 
     * @param type $id
     */
    public function actionDetail($id){
        $this->layout = '//layouts/iframe';
        $model = ADPengadaanjadwalpemeriksaanT::model()->findByPk($id);
        $model->nosuratperjanjiankerja = $model->suratperjanjiankerja->nosuratperjanjiankerja;
        $model->nama_pekerjaan = $model->suratperjanjiankerja->namapekerjaan;
        $model->pengadaanjadwalpemeriksaan_tanggal = MyFormatter::formatDateTimeForUser($model->pengadaanjadwalpemeriksaan_tanggal);
        $model->tanggal_pemeriksaan = MyFormatter::formatDateTimeForUser($model->tanggal_pemeriksaan);
        $this->render('_detail', array('model' => $model)); 
    }
    
    /**
     * Halaman tolak 
     * @param type $id
     * @param type $pegpemeriksa
     */
    public function actionTolak($id, $pegpemeriksa){
        $this->layout = '//layouts/iframe';
        $model = ADPengadaanjadwalpemeriksaanT::model()->findByPk($id);
        $modPemeriksa = PengadaanjadwalpemeriksaandetT::model()->findByAttributes(array('pengadaanjadwalpemeriksaan_id' => $id, 'pegpemeriksa_id' => $pegpemeriksa));
        $model->pengadaanjadwalpemeriksaan_tanggal = MyFormatter::formatDateTimeForUser($model->pengadaanjadwalpemeriksaan_tanggal); 
        $model->tanggal_pemeriksaan = MyFormatter::formatDateTimeForUser($model->tanggal_pemeriksaan); 
        $model->pegverifikasi_id = $pegpemeriksa; 
        $this->render('tolak', array('model' => $model, 'modPemeriksa' => $modPemeriksa)); 
    }
    
    /**
     * Menolak penjadwalan pemeriksaan
     * @throws CHttpException
     */
    public function actionAjaxUbahStatus(){
        if(Yii::app()->request->isPostRequest)
        {
            $tanggal = date("d M Y H:i:s");
            $alasan = $_POST['alasan'];
            $id = $_POST['id']; 
            $pegawai = $_POST['pegawai'];

            $updateJadwal = PengadaanjadwalpemeriksaanT::model()->updateByPk($id, array(
                'pengadaanjadwalpemeriksaan_status' => Params::STATUSDITOLAK,
                'alasan_tolak' => $alasan,
                'pegverifikasi_id' => $pegawai,
                'verifikasi_waktu' => $tanggal,
                'update_time' => $tanggal, 
                'update_loginpemakai_id' => Yii::app()->user->id
                ));
            if($updateJadwal){
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Penolakan berhasil disimpan.</div>",
                        ));
                    exit;
                }
            } else{
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'gagal_form', 
                        'div'=>"<div class='flash-danger'>Penolakan gagal disimpan.</div>",
                        ));
                    exit;
                }
            }
        }
        else{
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }
        
    /**
     * Verifikasi
     */
    public function actionVerifikasi() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $pegawai = Yii::app()->user->getState('pegawai_id');
            $tanggal = date("d M Y H:i:s");
            $updateJadwal = PengadaanjadwalpemeriksaanT::model()->updateByPk($id, array(
                    'pengadaanjadwalpemeriksaan_status' => Params::STATUSDISETUJUI,
                    'pegverifikasi_id' => $pegawai,
                    'verifikasi_waktu' => $tanggal,
                    'update_time' => $tanggal, 
                    'update_loginpemakai_id' => Yii::app()->user->id
                    ));
            if (!$updateJadwal) {
                $data['status'] = 0;
                $data['pesan'] = 'Persetujuan gagal disimpan';
            } else {
                $data['status'] = 1;
                $data['pesan'] = 'Persetujuan berhasil disimpan';
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Cetak penjadwalan pemeriksaan
     */
    public function actionPrint() {
        $model = new ADPengadaanjadwalpemeriksaanT();
        if (isset($_GET['ADPengadaanjadwalpemeriksaanT'])){
            $model->attributes = $_GET['ADPengadaanjadwalpemeriksaanT']; 
            $model->tanggal_awal = MyFormatter::formatDateTimeForDb($_GET['ADPengadaanjadwalpemeriksaanT']['tanggal_awal']);
            $model->tanggal_akhir = MyFormatter::formatDateTimeForDb($_GET['ADPengadaanjadwalpemeriksaanT']['tanggal_akhir']);
            $model->nosuratperjanjiankerja=isset($_GET['ADPengadaanjadwalpemeriksaanT']['nosuratperjanjiankerja'])?$_GET['ADPengadaanjadwalpemeriksaanT']['nosuratperjanjiankerja']:null;
            $model->nama_pekerjaan=isset($_GET['ADPengadaanjadwalpemeriksaanT']['nama_pekerjaan'])?$_GET['ADPengadaanjadwalpemeriksaanT']['nama_pekerjaan']:null;
            $model->pengadaanjadwalpemeriksaan_nomor=isset($_GET['ADPengadaanjadwalpemeriksaanT']['pengadaanjadwalpemeriksaan_nomor'])?$_GET['ADPengadaanjadwalpemeriksaanT']['pengadaanjadwalpemeriksaan_nomor']:null;
            $model->supplier_nama=isset($_GET['ADPengadaanjadwalpemeriksaanT']['supplier_nama'])?$_GET['ADPengadaanjadwalpemeriksaanT']['supplier_nama']:null;
            $model->pengadaanjadwalpemeriksaan_status=isset($_GET['ADPengadaanjadwalpemeriksaanT']['pengadaanjadwalpemeriksaan_status'])?$_GET['ADPengadaanjadwalpemeriksaanT']['pengadaanjadwalpemeriksaan_status']:null;

        }
        
        $judulLaporan = 'Data Penjadwalan Pemeriksaan';
        $caraPrint = $_REQUEST['caraPrint'];
         if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows3';
            $this->render('print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $kertas = Params::getUkuranKertas();
            $mpdf = new MyPDF('', $kertas['F4']);
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI_LANDSCAPE, '', '', '', '', 20, 20, 20, 30, 20, 20);
            $mpdf->WriteHTML($this->renderPartial('print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }
}
