<?php

class InformasiCopyResepController extends Controller
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $modInfoCopy = new FAInformasicopyresepV('searchCopyResep');
    $modInfoCopy->unsetAttributes();
    $modInfoCopy->tgl_awal = date("d M Y") . ' 00:00:00';
    $modInfoCopy->tgl_akhir = date("d M Y") . ' 23:59:59';
    if (isset($_GET['FAInformasicopyresepV'])) {
      $format = new MyFormatter();
      $modInfoCopy->attributes = $_GET['FAInformasicopyresepV'];
      $modInfoCopy->tgl_awal = $format->formatDateTimeForDb($_GET['FAInformasicopyresepV']['tgl_awal']);
      $modInfoCopy->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInformasicopyresepV']['tgl_akhir']);
    }

    $this->render('index', array('modInfoCopy' => $modInfoCopy));
  }
}
