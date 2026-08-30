<?php
Yii::import('rawatJalan.models.*');
/**
 * view untuk mengenerate prinout
 * issue RSST-2812
 * 
 * @package application.modules.mcu
 * @subpackage  controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class JantungKoronerController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $jantungkoronertersimpan = false;
  protected $path_view = 'mcu.views.jantungKoroner.';

  /**
   * action ini untuk masuk ke menu transaksi jantung koroner
   * @param type $pendaftaran_id
   * @param type $id
   */
  public function actionIndex($pendaftaran_id, $id = null)
  {
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPegawai = MCPegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
    $modJantungKoroner = new MCJantungkoronerT();
    $modDetails = array();

    if (!empty($id)) {
      $modJantungKoroner = MCJantungkoronerT::model()->findByPk($id);
    }

    $kolestrol_total = KlasifikasiatpM::model()->findAll("klasifikasiatp_jenis='Cholesterol Total'");
    $trigliserida = KlasifikasiatpM::model()->findAll("klasifikasiatp_jenis='Trigliserida'");
    $kolestrol_hdl = KlasifikasiatpM::model()->findAll("klasifikasiatp_jenis='Cholesterol HDL'");
    $kolestrol_ldl = KlasifikasiatpM::model()->findAll("klasifikasiatp_jenis='Cholesterol LDL'");

    $table_info['kolestroltotal'] = '';
    $table_info['trigliserida'] = '';
    $table_info['kolestrol_hdl'] = '';
    $table_info['kolestrol_ldl'] = '';

    $table_info = array();
    if (!empty($kolestrol_total)) {
      $table_info['kolestroltotal'] = '<table border = 1>';
      $table_info['kolestroltotal'] .= '<thead>';
      $table_info['kolestroltotal'] .= "<tr><td width='100px'>range data</td><td width='100px'>keterangan</td></tr>";
      $table_info['kolestroltotal'] .= '</thead>';
      foreach ($kolestrol_total as $det) {
        $table_info['kolestroltotal'] .= '<tr><td>' . $det->klasifikasiatp_nama . '</td><td>' . $det->klasifikasiatp_level . '</td></tr>';
      }
      $table_info['kolestroltotal'] .= '</table>';
    }

    if (!empty($trigliserida)) {
      $table_info['trigliserida'] = '<table border = 1>';
      $table_info['trigliserida'] .= '<thead>';
      $table_info['trigliserida'] .= "<tr><td width='100px'>range data</td><td width='100px'>keterangan</td></tr>";
      $table_info['trigliserida'] .= '</thead>';
      foreach ($trigliserida as $det) {
        $table_info['trigliserida'] .= '<tr><td>' . $det->klasifikasiatp_nama . '</td><td>' . $det->klasifikasiatp_level . '</td></tr>';
      }
      $table_info['trigliserida'] .= '</table>';
    }

    if (!empty($kolestrol_hdl)) {
      $table_info['kolestrol_hdl'] = '<table border = 1>';
      $table_info['kolestrol_hdl'] .= '<thead>';
      $table_info['kolestrol_hdl'] .= "<tr><td width='100px'>range data</td><td width='100px'>keterangan</td></tr>";
      $table_info['kolestrol_hdl'] .= '</thead>';
      foreach ($kolestrol_hdl as $det) {
        $table_info['kolestrol_hdl'] .= '<tr><td>' . $det->klasifikasiatp_nama . '</td><td>' . $det->klasifikasiatp_level . '</td></tr>';
      }
      $table_info['kolestrol_hdl'] .= '</table>';
    }

    if (!empty($kolestrol_ldl)) {
      $table_info['kolestrol_ldl'] = '<table border = 1>';
      $table_info['kolestrol_ldl'] .= '<thead>';
      $table_info['kolestrol_ldl'] .= "<tr><td width='100px'>range data</td><td width='100px'>keterangan</td></tr>";
      $table_info['kolestrol_ldl'] .= '</thead>';
      foreach ($kolestrol_ldl as $det) {
        $table_info['kolestrol_ldl'] .= '<tr><td>' . $det->klasifikasiatp_nama . '</td><td>' . $det->klasifikasiatp_level . '</td></tr>';
      }
      $table_info['kolestrol_ldl'] .= '</table>';
    }


    if (isset($_POST['MCJantungkoronerT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modJantungKoroner = $this->simpanJantungKoroner($modPendaftaran, $modJantungKoroner, $_POST['MCJantungkoronerT']);
        if ($this->jantungkoronertersimpan) {
          $transaction->commit();
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'id' => $modJantungKoroner->jantungkoroner_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Jantung Koroner gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data Jantung Koroner gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai,
      'modJantungKoroner' => $modJantungKoroner,
      'tableInfo' => $table_info
    ));
  }


  /**
   * proses simpan data periksa kacamata
   * @param type $model
   * @param type $post
   * @return type
   */
  public function simpanJantungKoroner($modPendaftaran, $post, $modJantungKoroner)
  {
    $format = new MyFormatter();
    $modJantungKoroner = new MCJantungkoronerT;
    $modJantungKoroner->attributes = $_POST['MCJantungkoronerT'];
    $modJantungKoroner->pasien_id = $modPendaftaran->pasien_id;
    $modJantungKoroner->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modJantungKoroner->tglhitungresiko = date('Y-m-d H:i:s');
    $modJantungKoroner->create_time = date('Y-m-d H:i:s');
    $modJantungKoroner->create_loginpemakai_id = Yii::app()->user->id;
    $modJantungKoroner->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modJantungKoroner->validate()) {
      $modJantungKoroner->save();
      $this->jantungkoronertersimpan = true;
    }

    return $modJantungKoroner;
  }

  /**
   * set tanggal lahir dari umur (__ Thn __ Bln __ Hr)
   */
  public function actionSetLevel()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $total = isset($_POST['total']) ? $_POST['total'] : null;
      $klasifikasiatp_jenis = isset($_POST['klasifikasiatp_jenis']) ? $_POST['klasifikasiatp_jenis'] : null;

      $data = '';
      $criteria = new CDbCriteria();
      //$criteria->addCondition(" (".$total." >= klasifikasiatp_min AND ".$total." <= klasifikasiatp_max) ");
      $criteria->compare('LOWER(klasifikasiatp_jenis)', strtolower($klasifikasiatp_jenis));

      $modKlasifikasiatp = MCKlasifikasiatpM::model()->findAll($criteria);

      $data = array();
      if (!empty($modKlasifikasiatp)) {
        $data['sukses'] = 1;
        foreach ($modKlasifikasiatp as $det) {
          if ($total >= $det->klasifikasiatp_min && $total <= $det->klasifikasiatp_max) {
            $data['klasifikasiatp_id'] = $det->klasifikasiatp_id;
            $data['klasifikasiatp_level'] = $det->klasifikasiatp_level;
            $data['klasifikasiatp_nama'] = $det->klasifikasiatp_nama;
          } else {
            if ($det->klasifikasiatp_max == 0) {
              if ($total > $det->klasifikasiatp_min) {
                $data['klasifikasiatp_id'] = $det->klasifikasiatp_id;
                $data['klasifikasiatp_level'] = $det->klasifikasiatp_level;
                $data['klasifikasiatp_nama'] = $det->klasifikasiatp_nama;
              }
            }
          }
        }
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk menampilkan riwayat pemeriksaan pasien
   * 1. pasien_id
   * 2. no_rekam_medik
   * 3. pendaftaran_id
   */
  public function actionGetRiwayatPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;

      $criteria = new CDbCriteria();
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      }
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modAnamnesa = AnamnesaT::model()->find($criteria);
      $modPemeriksaanFisik = PemeriksaanfisikT::model()->find($criteria);
      $modHasilPemeriksaanLab = HasilpemeriksaanlabT::model()->findAll($criteria);

      $td_systolic = '';
      $td_diastolic = '';

      if (isset($modPemeriksaanFisik)) {
        // untuk mengambil data tekanan darah
        $jeniskelamin = $modPemeriksaanFisik->pasien->jeniskelamin;
        $td_systolic = $modPemeriksaanFisik->td_systolic;
        $td_diastolic = $modPemeriksaanFisik->td_diastolic;
        if ($td_systolic >= 140 && $td_diastolic >= 90) {
          $returnVal['hipertensi'] = 'Ya';
        }
        if ($td_systolic >= 130 && $td_diastolic >= 85) {
          $returnVal['gangguan_metabolisme_td'] = 'Ya';
        }

        // untuk mengambil lingkarpinggang
        $lingkarpinggang = $modPemeriksaanFisik->lingkarpinggang;
        if ($jeniskelamin == 'PEREMPUAN' && $lingkarpinggang > 88) {
          $returnVal['gangguan_metabolisme_abdominal'] = 'Ya';
        }
        if ($jeniskelamin == 'LAKI-LAKI' && $lingkarpinggang > 102) {
          $returnVal['gangguan_metabolisme_abdominal'] = 'Ya';
        }
      }

      if (isset($modAnamnesa)) {
        // untuk mengambil status merokok
        if ($modAnamnesa->statusmerokok == true) {
          $returnVal['status_merokok'] = 'Ya';
        } else {
          $returnVal['status_merokok'] = 'Tidak';
        }

        // untuk mengambil status umur
        $jeniskelamin = $modAnamnesa->pasien->jeniskelamin;
        $umur = explode(' ', $modAnamnesa->pendaftaran->umur);
        $umur = $umur[0];
        if ($jeniskelamin == 'PEREMPUAN' && $umur >= 55) {
          $returnVal['umur'] = 'Ya';
        }
        if ($jeniskelamin == 'LAKI-LAKI' && $umur >= 45) {
          $returnVal['umur'] = 'Ya';
        }
      } else {
        $umur = explode(' ', $modPendaftaran->umur);
        $umur = $umur[0];
      }

      $total_kolesterol = '';
      $hdl_kolesterol = '';
      $triglceride = '';
      $ldl_kolesterol = '';
      foreach ($modHasilPemeriksaanLab as $i => $data) {
        // mencari total kolesterol
        $criteria_kolesterol = new CDbCriteria();
        $criteria_kolesterol->addCondition('hasilpemeriksaanlab_id = ' . $data->hasilpemeriksaanlab_id);
        $criteria_kolesterol->addCondition('pemeriksaanlab_id = 278');

        $modTotalKolesterol = MCDetailHasilPemeriksaanLabT::model()->find($criteria_kolesterol);
        if (!empty($modTotalKolesterol)) {
          $total_kolesterol = $modTotalKolesterol->hasilpemeriksaan;
        }

        // mencari total triglceride
        $criteria_triglceride = new CDbCriteria();

        $criteria_triglceride->addCondition('hasilpemeriksaanlab_id = ' . $data->hasilpemeriksaanlab_id);
        $criteria_triglceride->addCondition('pemeriksaanlab_id = 279');

        $modTotalTriglceride = MCDetailHasilPemeriksaanLabT::model()->find($criteria_triglceride);
        if (!empty($modTotalTriglceride)) {
          $triglceride = $modTotalTriglceride->hasilpemeriksaan;
        }

        // mencari total hdl kolesterol
        $criteria_hdl_kolesterol = new CDbCriteria();
        $criteria_hdl_kolesterol->addCondition('hasilpemeriksaanlab_id = ' . $data->hasilpemeriksaanlab_id);
        $criteria_hdl_kolesterol->addCondition('pemeriksaanlab_id = 280');

        $modTotalHdlKolesterol = MCDetailHasilPemeriksaanLabT::model()->find($criteria_hdl_kolesterol);
        if (!empty($modTotalHdlKolesterol)) {
          $hdl_kolesterol = $modTotalHdlKolesterol->hasilpemeriksaan;
        }

        // mencari total ldl kolesterol
        $criteria_ldl_kolesterol = new CDbCriteria();
        $criteria_ldl_kolesterol->addCondition('hasilpemeriksaanlab_id = ' . $data->hasilpemeriksaanlab_id);
        $criteria_ldl_kolesterol->addCondition('pemeriksaanlab_id = 281');

        $modTotalLdlKolesterol = MCDetailHasilPemeriksaanLabT::model()->find($criteria_ldl_kolesterol);
        if (!empty($modTotalLdlKolesterol)) {
          $ldl_kolesterol = $modTotalLdlKolesterol->hasilpemeriksaan;
        }
      }

      if (!empty($hdl_kolesterol)) {
        // menghitung hdl points
        $criteria_hdl = new CDbCriteria();
        $criteria_hdl->addCondition("'$hdl_kolesterol' between hdlpoints_min and hdlpoints_max or hdlpoints_min =" . $hdl_kolesterol);
        $modHdlpoints = MCHdlpointsM::model()->find($criteria_hdl);
      }

      // menghitung umur points
      $criteria_kelompokumur = new CDbCriteria();
      $criteria_kelompokumur->addCondition("'$umur' between kelompokumurjk_min and kelompokumurjk_max or kelompokumurjk_min =" . $umur);
      $modKelompokumur = MCKelompokumurjkM::model()->find($criteria_kelompokumur);
      if ($modPendaftaran->pasien->jeniskelamin == 'PEREMPUAN') {
        $jeniskelamin_umur = 2;
      } else {
        $jeniskelamin_umur = 1;
      }

      if (!empty($modKelompokumur)) {
        $criteria_pointumur = new CDbCriteria();
        $criteria_pointumur->addCondition('kelompokumurjk_id = ' . $modKelompokumur->kelompokumurjk_id);
        $criteria_pointumur->addCondition("jeniskelamin = '" . $jeniskelamin_umur . "'");
        $modUmurPoints = MCPointumurjkM::model()->find($criteria_pointumur);
      }

      // menghitung cholesterol points
      if (!empty($modKelompokumur)) {
        $criteria_cholesterol = new CDbCriteria();
        $criteria_cholesterol->addCondition('kelompokumurjk_id = ' . $modKelompokumur->kelompokumurjk_id);
        $criteria_pointumur->addCondition("jeniskelamin = '" . $jeniskelamin_umur . "'");
        $modCholesterolPoints = MCCholesterolpointsM::model()->find($criteria_cholesterol);
      }

      // menghitung smoker points
      if (!empty($modKelompokumur)) {
        $criteria_smoker = new CDbCriteria();
        $criteria_smoker->addCondition('kelompokumurjk_id = ' . $modKelompokumur->kelompokumurjk_id);
        $criteria_pointumur->addCondition("jeniskelamin = '" . $jeniskelamin_umur . "'");
        $modSmokerPoints = MCCholesterolpointsM::model()->find($criteria_smoker);
      }

      // menghitung systolicbp
      $criteria_systolicbp = new CDbCriteria();
      $criteria_systolicbp->addCondition("jeniskelamin = '" . $jeniskelamin_umur . "'");
      $modSysteolicbp = MCSysteolicbpM::model()->find($criteria_systolicbp);

      $hdlpoints_point = isset($modHdlpoints) ? $modHdlpoints->hdlpoints_point : 0;
      $umur_points = isset($modUmurPoints) ? $modUmurPoints->umur_points : 0;
      $cholesterolpoints_point = isset($modCholesterolPoints) ? $modCholesterolPoints->cholesterolpoints_point : 0;
      $smokerpoints_point = isset($modSmokerPoints) ? $modSmokerPoints->smokerpoints_points : 0;

      $total_point = $hdlpoints_point + $umur_points + $cholesterolpoints_point + $smokerpoints_point;
      // menghitung pointtotalrisk
      $criteria_pointtotalrisk = new CDbCriteria();
      $criteria_pointtotalrisk->addCondition("jeniskelamin = '" . $jeniskelamin_umur . "'");
      $criteria_pointtotalrisk->addCondition("point_total = '" . $total_point . "'");
      $modPointtotalrisk = MCPointtotalriskM::model()->find($criteria_pointtotalrisk);
      $pointtotalrisk = isset($modPointtotalrisk) ? $modPointtotalrisk->pointtotalrisk_matematika : 0;
      $yearrisk_persen = isset($modPointtotalrisk) ? $modPointtotalrisk->yearrisk_persen : 0;

      $returnVal['hdlpoints_point'] = $hdlpoints_point;
      $returnVal['umur_points'] = $umur_points;
      $returnVal['cholesterolpoints_point'] = $cholesterolpoints_point;
      $returnVal['smokerpoints_point'] = $smokerpoints_point;
      $returnVal['total_point'] = $total_point;
      $returnVal['pointtotalrisk'] = $pointtotalrisk;
      $returnVal['yearrisk_persen'] = $yearrisk_persen;

      $returnVal['total_kolesterol'] = $total_kolesterol;
      $returnVal['hdl_kolesterol'] = $hdl_kolesterol;
      $returnVal['triglceride'] = $triglceride;
      $returnVal['ldl_kolesterol'] = $ldl_kolesterol;
      $returnVal['td_systolic'] = $td_systolic;

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * untuk print data treadmill
   */
  public function actionPrint($jantungkoroner_id, $pendaftaran_id, $caraPrint = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $modJantungKoroner = MCJantungkoronerT::model()->findByPk($jantungkoroner_id);
    $modPendaftaran = MCPendaftaranT::model()->findByPk($modJantungKoroner->pendaftaran_id);
    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $judul_print = 'ANALISA RESIKO KORONER';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    } else if ($caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/iframeNeon';
    }

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modJantungKoroner' => $modJantungKoroner,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
      'caraPrint' => $caraPrint
    ));
  }
}
