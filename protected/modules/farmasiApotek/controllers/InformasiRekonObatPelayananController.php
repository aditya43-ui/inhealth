<?php
class InformasiRekonObatPelayananController extends MyAuthController
{
    protected $path_view = "farmasiApotek.views.informasiRekonObatPelayanan.";

    public function actionIndex()
    {
        $model = new PasienrekonsiliasiobatV();
        $format = new MyFormatter();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        if(isset($_GET['PasienrekonsiliasiobatV'])){
            $model->attributes=$_GET['PasienrekonsiliasiobatV'];
            $model->tgl_awal = $format->formatDateTimeForDB($_GET['PasienrekonsiliasiobatV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDB($_GET['PasienrekonsiliasiobatV']['tgl_akhir']);
            $model->prefix_pendaftaran = $_GET['PasienrekonsiliasiobatV']['prefix_pendaftaran'];
        }

        $this->render($this->path_view.'index', array('model'=>$model));
    }

    public function actionRiwayatRekonsiliasi($pendaftaran_id, $typetransaksi) {
         $this->layout = '//layouts/iframe';
         $format = new MyFormatter();

         $target = $this->path_view.'_riwayatAlergiObat';
         if($typetransaksi =='obatalergi'){
           $target = $this->path_view.'_riwayatAlergiObat';
         }else if($typetransaksi =='obatsebelumadmisi'){
           $target = $this->path_view.'_riwayatObatAdmisi';
         }else if($typetransaksi =='obatsaattransfer'){
           $target = $this->path_view.'_riwayatObatTransfer';
         }else if($typetransaksi =='obatsaatdischarger'){
           $target = $this->path_view.'_riwayatObatDischarger';
         }

         $this->render($target, array(
             'pendaftaran_id' => $pendaftaran_id,
         ));
     }

     public function actionPrint($pendaftaran_id) {
       $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
       $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

       $modRekonAlergi = RekonobatalergiT::model()->findAllByAttributes(array('pendaftaran_id'=> $modPendaftaran->pendaftaran_id),array('order'=>'create_time DESC'));

       $crtRekonAdmisi = new CDbCriteria();
       $crtRekonAdmisi->select = "t.tanggal_pengisian, t.petugas_id, t.rujukansebelumnya, t.rujukanke, det.nama_obat, det.dosis, det.frekuensi, det.cara_pemberian, det.waktu_pemberian, det.jumlah_obat, det.tindaklanjut, det.keterangan, det.create_time";
   		$crtRekonAdmisi->group = $crtRekonAdmisi->select;
   		$crtRekonAdmisi->join = "JOIN rekonobatadmisidet_t det on det.rekonobatadmisi_id = t.rekonobatadmisi_id";
       $crtRekonAdmisi->addCondition('t.pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
       $crtRekonAdmisi->order = "det.create_time DESC";
       $modRekonAdmisi = RekonobatadmisiT::model()->findAll($crtRekonAdmisi);

       $crtRekonTransfer = new CDbCriteria();
       $crtRekonTransfer->select = "t.tanggal_pengisian, t.petugas_id, t.rujukansebelumnya, t.rujukanke, det.nama_obat, det.dosis, det.frekuensi, det.cara_pemberian, det.waktu_pemberian, det.jumlah_obat, det.tindaklanjut, det.keterangan, det.create_time";
   		$crtRekonTransfer->group = $crtRekonTransfer->select;
   		$crtRekonTransfer->join = "JOIN rekonobattransferdet_t det on det.rekonobattransfer_id = t.rekonobattransfer_id";
       $crtRekonTransfer->addCondition('t.pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
       $crtRekonTransfer->order = "det.create_time DESC";
       $modRekonTransfer = RekonobattransferT::model()->findAll($crtRekonTransfer);

       $crtRekonDischarge = new CDbCriteria();
       $crtRekonDischarge->select = "t.tanggal_pengisian, t.petugas_id, t.rujukansebelumnya, t.rujukanke, det.nama_obat, det.dosis, det.frekuensi, det.cara_pemberian, det.waktu_pemberian, det.jumlah_obat, det.tindaklanjut, det.keterangan, det.create_time";
   		$crtRekonDischarge->group = $crtRekonDischarge->select;
   		$crtRekonDischarge->join = "JOIN rekonobatdischargedet_t det on det.rekonobatdischarge_id = t.rekonobatdischarge_id";
       $crtRekonDischarge->addCondition('t.pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
       $crtRekonDischarge->order = "det.create_time DESC";
       $modRekonDischarge = RekonobatdischargeT::model()->findAll($crtRekonDischarge);

       $caraPrint = $_REQUEST['caraPrint'];

       $params = array(
         'modPasien' => $modPasien,
         'modPendaftaran' => $modPendaftaran,
         'modRekonAlergi'=>$modRekonAlergi,
         'modRekonAdmisi'=>$modRekonAdmisi,
         'modRekonTransfer'=>$modRekonTransfer,
         'modRekonDischarge'=>$modRekonDischarge,
         'caraPrint' => $caraPrint
       );

       if ($caraPrint == 'PRINT') {
         $this->layout = '//layouts/printWindows';
         $this->render($this->path_view . 'Print', $params);
       } else if ($caraPrint == 'EXCEL') {
           $this->layout = '//layouts/printExcel';
           $this->render($this->path_view . 'Print', $params);
       } else if ($_REQUEST['caraPrint'] == 'PDF') {
           $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
           $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
           $mpdf = new MyPDF('', $ukuranKertasPDF);
           $mpdf->useOddEven = 2;
           $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
           $mpdf->WriteHTML($stylesheet, 1);
           $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
           $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', $params, true));
           $mpdf->Output();
       }
     }
}
