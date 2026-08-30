<?php
Yii::import('billingKasir.controllers.RinciantagihanpasienVController');
Yii::import('billingKasir.models.*');
Yii::import('billingKasir.views.*');
class RinciantagihanpasienExtendsVController extends RinciantagihanpasienVController
{
  public function actionRincianBelumBayarPrint($id, $caraPrint)
  {
    if (!empty($id)) {
      $format = new MyFormatter();
      $judulLaporan = '';
      $this->layout = '//layouts/iframe';
      $data['judulPrint'] = 'Rincian Biaya Pelayanan';
      $data['judul'] = 'Rincian Biaya Pelayanan RJ';
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $id);
      $criteria->order = 'ruangantindakan_id';
      $modRincian = RincianbelumbayarrjV::model()->findAll($criteria);

      $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
      $data['jenis_cetakan'] = 'kwitansi';

      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render(
          'billingKasir.views.rinciantagihanpasienV.rincianBelumBayarPdf',
          array(
            'modRincian' => $modRincian,
            'data' => $data,
            'judulLaporan' => $judulLaporan,
          )
        );
      } else
            if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render('billingKasir.views.rinciantagihanpasienV.rincianBelumBayarPdf', array('modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint, 'judulLaporan' => $judulLaporan));
      } else
            if ($caraPrint == 'PDF') {
        $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('c', $ukuranKertasPDF);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $footer = '
                <table width="100%" style="vertical-align: top; font-family:tahoma;font-size: 8pt;"><tr>
                <td width="50%"></td>
                <td width="50%" align="right">{PAGENO} / {nb}</td>
                </tr></table>
                ';
        $mpdf->SetHTMLFooter($footer);

        $header = 0.75 * 72 / (72 / 25.4);
        $mpdf->AddPage($posisi, '', '', '', '', 5, 5, $header + 4, 8, 0, 0);
        $mpdf->WriteHTML(
          $this->renderPartial(
            'billingKasir.views.rinciantagihanpasienV.rincianBelumBayarPdf',
            array(
              'modRincian' => $modRincian,
              'data' => $data,
              'format' => $format,
            ),
            true
          )
        );
        $mpdf->Output();
        exit;
      }
    }
  }
}
