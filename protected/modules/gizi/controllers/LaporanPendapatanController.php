<?php
Yii::import('rawatJalan.controllers.LaporanController');
Yii::import('rawatJalan.models.*');
class LaporanPendapatanController extends LaporanController
{
  //   public $path_view = 'rawatJalan.views.laporan.';
  //   public $pathViewLap = 'rawatJalan.views.laporan.';
  //    
  //    public function actionLaporanPendapatanRuangan(){
  //        $model = new RJLaporanpendapatanruangan('search');
  //        $model->tgl_awal = date('d M Y 00:00:00');
  //        $model->tgl_akhir = date('d M Y H:i:s');
  //        $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
  //        $model->penjamin_id = $penjamin;
  //        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
  //        $model->kelaspelayanan_id = $kelas;
  //        if (isset($_GET['RJLaporanpendapatanruangan'])) {
  //            $model->attributes = $_GET['RJLaporanpendapatanruangan'];
  //            $format = new MyFormatter();
  //            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpendapatanruangan']['tgl_awal']);
  //            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpendapatanruangan']['tgl_akhir']);
  //        }
  //
  //        $this->render($this->path_view.'pendapatanRuangan/adminPendapatanRuangan', array(
  //            'model' => $model, 'filter'=>$filter
  //        ));
  //    }
  //
  //    public function actionPrintLaporanPendapatanRuangan() {
  //        $model = new RJLaporanpendapatanruangan('search');
  //        $judulLaporan = 'Laporan Grafik Pendapatan Ruangan Rawat Jalan';
  //
  //        //Data Grafik        
  //        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
  //        $data['type'] = $_REQUEST['type'];
  //        if (isset($_REQUEST['RJLaporanpendapatanruangan'])) {
  //            $model->attributes = $_REQUEST['RJLaporanpendapatanruangan'];
  //            $format = new MyFormatter();
  //            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJLaporanpendapatanruangan']['tgl_awal']);
  //            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJLaporanpendapatanruangan']['tgl_akhir']);
  //        }
  //        
  //        $caraPrint = $_REQUEST['caraPrint'];
  //        $target = $this->path_view.'pendapatanRuangan/_printPendapatanRuangan';
  //        
  //        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  //    }
  //
  //    public function actionFrameGrafikLaporanPendapatanRuangan() {
  //        $this->layout = '//layouts/iframe';
  //        $model = new RJLaporanpendapatanruangan('search');
  //        $model->tgl_awal = date('d M Y 00:00:00');
  //        $model->tgl_akhir = date('d M Y H:i:s');
  //
  //        //Data Grafik
  //        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
  //        $data['type'] = $_GET['type'];
  //        if (isset($_GET['RJLaporanpendapatanruangan'])) {
  //            $model->attributes = $_GET['RJLaporanpendapatanruangan'];
  //            $format = new MyFormatter();
  //            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpendapatanruangan']['tgl_awal']);
  //            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpendapatanruangan']['tgl_akhir']);
  //        }
  //                
  //        $this->render($this->pathViewLap.'_grafik', array(
  //            'model' => $model,
  //            'data' => $data,
  //        ));
  //    }

}
