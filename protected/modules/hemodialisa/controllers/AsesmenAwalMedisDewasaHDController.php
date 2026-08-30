<?php
/**
 * -digunakan untuk mengekstend menu dari rawat inap yaitu : asesmen awal medis
 * @author  Andyka <andy@cloud.piiproject.co.id>
 * RSST-1745
 */

Yii::import('rawatInap.controllers.AsesmenAwalMedisAnakController');
Yii::import('rawatInap.models.*');
class AsesmenAwalMedisDewasaHDController extends AsesmenAwalMedisAnakController
{
    public $init = 'HD';
    
    public function actionPrint($id){
        $this->layout = '//layouts/_auto';
        $format = new MyFormatter;         
        
        $model = RIAsesmenAwalMedisT::model()->findByPk($id);
        $model->riwayat_obat = $model->loadRiwayatObatSebelum();
        $model->set_periksa_internal_lab = $model->loadPemeriksaanLab();
        $model->set_periksa_lab_dari_luar = $model->loadLabPeriksaDariLuar();
        $model->set_periksa_internal_rad = $model->loadPemeriksaanRad();
        $model->set_diagnosa_morbiditas = $model->loadDiagnosaMorbiditas();
        
        
        $no_dok = 'RM 05 HD';
        $view = 'print/index';
            
        $judullaporan = 'ASESMEN AWAL MEDIS DIALISIS';
        $alias = 'DIALYSIS INITIAL ASSESMENT';
        
        $pasien = $model->pasien;
        
        $umur = CustomFunction::getUmurTahun($pasien->tanggal_lahir, $model->pendaftaran->tgl_pendaftaran);;
        
        if ($umur < 18){
            return parent::actionPrint($id);
        }
        
        $data = [
            'judul_laporan' => $judullaporan,
            'no_dok' => $no_dok,
            'alias' => $alias,
            'nama_lengkap' => $pasien->nama_pasien,
            'no_rm' => $pasien->no_rekam_medik,
            'tanggal_lahir' => date('d/m/Y', strtotime($pasien->tanggal_lahir)),
        ];
                      
        $ukuranKertasPDF = Params::getUkuranKertas();
        $mpdf = new MyPDF('', $ukuranKertasPDF['A4']);
        $mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/global-prinout-pdf.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $posisi = Yii::app()->user->getState('posisi_kertas');  
        $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
        $mpdf->WriteHTML( $this->renderPartial($view, array(
            'format' => $format,
            'model' => $model,
            'judullaporan' => $judullaporan,
            'data' => $data,        
        ),true));
        $mpdf->Output($judullaporan . '-' . date("Y/m/d") . '.pdf', 'I');
    }
}