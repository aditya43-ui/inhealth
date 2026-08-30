<?php

/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAutoCompleteController extends MyAuthController
{
  /**
   * menampilkan seluruh pendaftaran pasien
   * digunakan di:
   * - tindakanTSA/_ringkasDataPasien
   */
  public function actionDaftarPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter;
      $criteria = new CDbCriteria();
      if (isset($_GET['term'])) {
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
      } else if (isset($_GET['noPendaftaran'])) {
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($_GET['noPendaftaran']), true);
      }
      $criteria->limit = 10;
      $criteria->order = 'no_pendaftaran ASC';
      $models = InfopasienpengunjungV::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $tglPendaftaran = $format->formatDateTimeId(date('Y-m-d', strtotime($model->tgl_pendaftaran)));
        $model->tgl_pendaftaran = date('d M Y H:i:s', strtotime($model->tgl_pendaftaran));
        if (isset($_GET['term'])) {
          $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->ruangan_nama . ' - ' . $tglPendaftaran;
          $returnVal[$i]['value'] = $model->no_rekam_medik;
        } else if (isset($_GET['noPendaftaran'])) {
          $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $tglPendaftaran . ' - ' . $model->nama_pasien;
          $returnVal[$i]['value'] = $model->no_pendaftaran;
        }
        $returnVal[$i]['jeniskasuspenyakit_id'] = $modPendaftaran->jeniskasuspenyakit_id;
        $returnVal[$i]['jeniskasuspenyakit_nama'] = $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;
      }


      // $returnVal['tindakan']['jml_tindakan'] = count((array)$modViewTindakans);

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actiondaftarTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter;
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $modViewTindakans = TindakanpelayananT::model()->with('daftartindakan', 'dokter1', 'dokter2', 'dokterPendamping', 'dokterAnastesi', 'dokterDelegasi', 'bidan', 'suster', 'perawat', 'tipePaket')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));


      $tr = "<tr>";
      $no = 1;
      $i = 0;
      foreach ($modViewTindakans as $i => $modTindakan) {
        if (!empty($modTindakan->tindakansudahbayar_id)) {
          $status = "SUDAH BAYAR";
        } else {
          $status = CHtml::link(
            "<i class='icon-remove'></i>",
            '#',
            array(
              'onclick' => 'deleteTindakan(this,' . $modTindakan->tindakanpelayanan_id . ');return false;',
              'rel' => 'tooltip', 'title' => 'Klik untuk menghapus tindakan'
            )
          );
        }
        $satuan_tindakan = $modTindakan->qty_tindakan . " " . $modTindakan->satuantindakan;

        $modViewBmhp = ObatalkespasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'tindakanpelayanan_id' => $modTindakan->tindakanpelayanan_id));

        $td_bmph = "";
        foreach ($modViewBmhp as $ax => $bmhp) {
          $obatalkes_nama = $bmhp->obatalkes->obatalkes_nama;
          $qty = $bmhp->qty_oa;
          $satuankecil = $bmhp->satuankecil->satuankecil_nama;
          $hargajual = number_format($bmhp->hargajual_oa);
          $td_bmph .= $obatalkes_nama . " " . $qty . "(" . $satuankecil . ") " . $hargajual . "<br>";
        }

        if ($i > 0)
          $tr .= "<tr>";
        $tr .= "<td>" . $no . "</td>";
        $tr .= "<td>" . $format->formatDateTimeId(date('Y-m-d', strtotime($modTindakan->tgl_tindakan))) . "</td>";
        $tr .= "<td>" . $modTindakan->tipepaket->tipepaket_nama . "<br>Kategori Tindakan: " . $modTindakan->daftartindakan->daftartindakan_nama . ", " . $satuan_tindakan . "<br>(" . $modTindakan->instalasi->instalasi_nama . ")<br>Pemeriksa: " . $modTindakan->dokter1->nama_pegawai . "</td>";
        $tr .= "<td>" . $td_bmph . "</td>";
        $tr .= "<td style='vertical-align:middle;text-align:center'>" . $status . "</td>";
        $tr .= "</tr>";
        $no++;
      }
      $returnVal['tr'] = $tr;
      $returnVal['jumlahtindakan'] = $i;

      echo CJSON::encode($returnVal);
    }

    Yii::app()->end();
  }
}
