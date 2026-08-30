<?php

class InformasiBedahSentralController extends MyAuthController
{
  public $path_view = "bedahSentral.views.informasiBedahSentral.";

  public function actionInformasiJadwalOperasi()
  {
    $this->pageTitle = Yii::app()->name . " - Jadwal Operasi";
    $model = new BSRencanaOperasiT('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['BSRencanaOperasiT'])) {
      $format = new MyFormatter;
      $model->attributes = $_GET['BSRencanaOperasiT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSRencanaOperasiT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSRencanaOperasiT']['tgl_akhir']);
    }

    $this->render($this->path_view . 'jadwalOperasi/admin', array('model' => $model));
  }

  /**
   * load data kalendar berdasarkan jadwal rotasi ppds dan orientasi
   */
  public function actionJadwalOperasi()
  {
    if (Yii::app()->request->isAjaxRequest) {

      //$ppds = PDKPpdsM::model()->findByPk(Yii::app()->user->getState('ppds_id'));
      //$ppds_id = $ppds->ppds_id;  

      $tgl = $_POST['date'];
      $tgl_awal = date('Y-m-01', strtotime($tgl));
      $tgl_akhir = date('Y-m-t', strtotime($tgl));

      $cri = new CDbCriteria();
      $cri->addBetweenCondition('tglrencanaoperasi::date', $tgl_awal, $tgl_akhir);
      $jadwal_operasi = BSRencanaOperasiT::model()->findAll($cri);

      $data = array();


      foreach ($jadwal_operasi as $det) {
        if ($det->statusoperasi == Params::STATUSOPERASI_SELESAI) {
          $col = "#0000aa";
        } else if ($det->statusoperasi == Params::STATUSOPERASI_MULAI) {
          $col = "#aaaa00";
        } else {
          $col = "#00aa00";
        }
        $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
          'pasienmasukpenunjang_id' => $det->pasienmasukpenunjang_id,
        ));
        $operasi = OperasiM::model()->findByPk($det->operasi_id);
        $kegiatan = KegiatanOperasiM::model()->findByPk($operasi->kegiatanoperasi_id);
        $operator = PegawaiM::model()->findByPk($det->dokterpelaksana1_id);

        $label = $penunjang->nama_pasien . "\n" . $penunjang->no_rekam_medik . " - " . $penunjang->no_pendaftaran
          . "\n" . (empty($operator) ? "-" : $operator->namaLengkap) . "\n"
          . (empty($kegiatan) ? "-" : $kegiatan->kegiatanoperasi_nama) . "\n"
          . $det->statusoperasi;
        $label2 = $penunjang->nama_pasien . "<br/>" . $penunjang->no_rekam_medik . " - " . $penunjang->no_pendaftaran
          . "<br/>" . (empty($operator) ? "-" : $operator->namaLengkap) . "<br/>"
          . (empty($kegiatan) ? "-" : $kegiatan->kegiatanoperasi_nama) . "<br/>"
          . $det->statusoperasi;

        $data['event'][] = array(
          'url' => 'javascript:;', //$this->createUrl('/pendidikanKlinis/InformasiJadwalOrientasi',array('OrientasiT[tgl_awal]'=>$det->tanggal_awal,'OrientasiT[tgl_akhir]'=>$det->tanggal_akhir))
          //'link' => $this->createUrl('/bedahSentral/InformasiBedahSentral/InformasiJadwalOperasi',array('rencanaoperasi_id'=>$det->rencanaoperasi_id)), 
          'title' => $label,
          'title2' => $label2,
          'keterangan' => "",
          'start' => $det->tglrencanaoperasi,
          'color'  => $col,
          'end' => date("Y-m-d", strtotime($det->tglrencanaoperasi . " +1 days"))
        );
      }

      echo json_encode($data);

      Yii::app()->end();
    }
  }
}
