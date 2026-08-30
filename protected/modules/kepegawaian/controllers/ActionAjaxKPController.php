<?php

/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAjaxKPController extends MyAuthController
{
  /**
   * Untuk transaksi rencana lembur pegawai
   */
  public function actionGetPegawaiLembur()
  {
    $tr = "";
    if (Yii::app()->request->isAjaxRequest) {

      $modRencanaLembur = new KPRencanaLemburT;
      if (!empty($_POST['idPegawaiLembur'])) {
        $idPegawaiLembur = $_POST['idPegawaiLembur'];
        $modPegawai = PegawaiM::model()->findByPk($idPegawaiLembur);
      } else if (!empty($_POST['nomorindukpegawaiPegawaiLembur'])) {
        $nomorindukpegawaiPegawaiLembur = $_POST['nomorindukpegawaiPegawaiLembur'];
        $modPegawai = PegawaiM::model()->findByAttributes(array('nomorindukpegawai' => $nomorindukpegawaiPegawaiLembur));
        $idPegawaiLembur = $modPegawai->pegawai_id;
      }


      if (!empty($modPegawai->pegawai_id)) {
        $tr .= "<tr>
                        <td>" . CHtml::activeTextField($modRencanaLembur, '[' . $idPegawaiLembur . ']nourut', array('class' => 'span1 noUrut', 'readonly' => TRUE)) .
          CHtml::activeHiddenField($modRencanaLembur, '[' . $idPegawaiLembur . ']pegawai_id', array('value' => $modPegawai->pegawai_id, 'class' => 'karlemburNama')) .
          CHtml::activeHiddenField($modPegawai, 'nomorindukpegawai', array('value' => $modPegawai->nomorindukpegawai, 'class' => 'karlemburNik')) .
          "</td>
                        <td>" . $modPegawai->nomorindukpegawai . "</td>
                        <td>" . $modPegawai->nama_pegawai . "</td>";      //<td>".$modPegawai->jabatan->jabatan_nama."</td>                  

        $tr .= "<td>" . CHtml::activetextField($modRencanaLembur, '[' . $idPegawaiLembur . ']jamMulai', array('placeholder' => '00:00', 'class' => 'span1 detailRequired', 'readonly' => false, 'maxLength' => 5, 'onkeypress' => 'return $(this).focusNextInputField(event)', 'onblur' => 'checkTime(this);')) . "</td>";
        $tr .= "<td>" . CHtml::activetextField($modRencanaLembur, '[' . $idPegawaiLembur . ']jamSelesai', array('placeholder' => '00:00', 'class' => 'span1', 'readonly' => false, 'maxLength' => 5, 'onkeypress' => 'return $(this).focusNextInputField(event)', 'onblur' => 'checkTime(this);')) . "</td>";

        $tr .= "        <td>" . CHtml::activetextField($modRencanaLembur, '[' . $idPegawaiLembur . ']alasanlembur', array('class' => 'span3', 'readonly' => false, 'onkeypress' => 'return $(this).focusNextInputField(event)')) . "</td>
                        <td>" . CHtml::link("<span class='icon-remove'>&nbsp;</span>", '#', array('href' => '', 'onclick' => 'hapusBaris(this); return false;')) . "</td>
                     </tr>   
                    ";

        $data['tr'] = $tr;
        echo json_encode($data);
        Yii::app()->end();
      } else {
        // Jika data pegawai salah
      }
    }
  }

  /**
   * Untuk transaksi Pemesanan (Pendaftaran) Makanan versi 2
   */
  public function actionGetPegawaiPemesan()
  {
    $tr = "";
    if (Yii::app()->request->isAjaxRequest) {
      $modKPPMakananDetail = new KPMakananDetailT;

      if (!empty($_POST['pegawaiId'])) {
        $pegawaiId = $_POST['pegawaiId'];
        $modKPPegawai = KPPegawaiM::model()->findByPk($pegawaiId);
      } else if (!empty($_POST['pegawaiNik'])) {
        $pegawaiNik = $_POST['pegawaiNik'];
        $modKPPegawai = KPPegawaiM::model()->findByAttributes(array('nomorindukpegawai' => $pegawaiNik));
        $pegawaiId = $modKPPegawai->pegawai_id;
      } else if (!empty($_POST['jabatanId'])) {
        $jabatanId = $_POST['jabatanId'];
        $modPegawaiBanyak = KPPegawaiM::model()->findAllByAttributes(array('jabatan_id' => $jabatanId));
        foreach ($modPegawaiBanyak as $key => $value) {
          $pegawaiId = $modPegawaiBanyak[$key]->pegawai_id;
          $tr .= $this->renderPartial(
            'hrd.views.actionAjax._detailPesanMakanan',
            array(
              'modKPPegawai' => $modPegawaiBanyak[$key],
              'modKPPMakananDetail' => $modKPPMakananDetail,
              'pegawaiId' => $pegawaiId
            ),
            true
          );
        }
        $data['tr'] = $tr;
        echo json_encode($data);
        Yii::app()->end();
      }

      if ((!empty($modKPPegawai->pegawai_id)) && empty($_POST['jabatanId'])) {
        $tr .= $this->renderPartial(
          'hrd.views.actionAjax._detailPesanMakanan',
          array(
            'modKPPegawai' => $modKPPegawai,
            'modKPPMakananDetail' => $modKPPMakananDetail,
            'pegawaiId' => $pegawaiId
          ),
          true
        );
        $data['tr'] = $tr;

        echo json_encode($data);
        Yii::app()->end();
      }
    }
  }

  /**
   * Untuk Generate tgl_akhirCuti pada hrd/pengelolaanPegawai/cutiPegawai
   */
  public function actionGetTglAkhirCuti()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $lamacuti = explode(' ', $_POST['lamaCuti']);
      //$today = date('Y-m-d');
      $format = new MyFormatter;
      $tglMulaiCuti = $format->formatDateTimeForDb($_POST['tglMulaiCuti']);
      if (!empty($_POST['lamaCuti'])) {
        $thn = $lamacuti[0];
        $bln = $lamacuti[2];
        $hr = $lamacuti[4];
        if ($thn == '') $thn = 0;
        if ($bln == '') $bln = 0;
        $dateCalculate = strtotime(date("Y-m-d", strtotime($tglMulaiCuti)) . "+$thn year");
        $date = date('Y-m-d', $dateCalculate);
        $dateCalculate = strtotime(date("Y-m-d", strtotime($date)) . "+$bln month");
        $date = date('Y-m-d', $dateCalculate);
        $dateCalculate = strtotime(date("Y-m-d", strtotime($date)) . "+$hr day");
        $tgl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d', $dateCalculate), 'yyyy-MM-dd'), 'medium', null);
        $data['tgl_akhirCuti'] = $tgl;
      } else {
        $tgl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($today, 'yyyy-MM-dd'), 'medium', null);
        $data['tgl_akhirCuti'] = $tgl;
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * Untuk Generate lamacuti pada hrd/pengelolaanPegawai/cutiPegawai
   */
  public function actionGetLamaCuti()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $format = new MyFormatter;
      $tglMulaiCuti = $format->formatDateTimeForDb($_POST['tglMulaiCuti']);
      $tgl_akhirCuti = $format->formatDateTimeForDb($_POST['tgl_akhirCuti']);
      list($y, $m, $d) = explode('-', $tglMulaiCuti);
      list($ty, $tm, $td) = explode('-', $tgl_akhirCuti);
      if ($td - $d < 0) {
        $day = ($td + 30) - $d;
        $tm--;
      } else {
        $day = $td - $d;
      }
      if ($tm - $m < 0) {
        $month = ($tm + 12) - $m;
        $ty--;
      } else {
        $month = $tm - $m;
      }
      $year = $ty - $y;

      $data['lamacuti'] = str_pad($year, 2, '0', STR_PAD_LEFT) . ' Thn ' . str_pad($month, 2, '0', STR_PAD_LEFT) . ' Bln ' . str_pad($day, 2, '0', STR_PAD_LEFT) . ' Hr';
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
