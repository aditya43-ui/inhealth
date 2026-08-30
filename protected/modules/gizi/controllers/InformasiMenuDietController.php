<?php
class InformasiMenuDietController extends MyAuthController
{
  /**
   * method retur / ubah pengiriman Menu Diet
   * digunakan di 
   * 1. Gizi -> informasi Pengiriman Menu Diet -> retur / ubah Menu Diet
   * @param integer $idKirimmenudiet
   */
  private $suksesUpdate = false;
  public function actionIndexKirim($idKirimmenudiet = null, $id = null)
  {
    $this->layout = '//layouts/iframe';
    $modKirim = new KirimmenudietT;

    $modDetail = array();
    $success = false;
    $modDetailKirim = array();
    if (!empty($idKirimmenudiet)) {
      $modKirim = KirimmenudietT::model()->findByPk($idKirimmenudiet);
      if ($modKirim->jenispesanmenu == Params::JENISPESANMENU_PASIEN) {
        $criteria = new CDbCriteria();
        $criteria->select = 'pasienadmisi_id, pendaftaran_id, pasien_id, menudiet_id, kirimmenudiet_id, jml_kirim, satuanjml_urt,ruangan_id';
        $criteria->group = 'pasienadmisi_id, pendaftaran_id, pasien_id, menudiet_id,kirimmenudiet_id, jml_kirim, satuanjml_urt,ruangan_id';
        $criteria->compare('kirimmenudiet_id', $idKirimmenudiet);
        $modDetailKirim = KirimmenupasienT::model()->findAll($criteria);
      } else {
        $criteria = new CDbCriteria();
        $criteria->select = 'pegawai_id, menudiet_id, kirimmenudiet_id, jml_kirim, satuanjml_urt, ruangan_id';
        $criteria->group = 'pegawai_id, menudiet_id, kirimmenudiet_id, jml_kirim, satuanjml_urt, ruangan_id';
        $criteria->compare('kirimmenudiet_id', $idKirimmenudiet);
        $modDetailKirim = KirimmenupegawaiT::model()->findAll($criteria);
      }

      $modKirim->jenispesanmenu = $modKirim->jenispesanmenu;
      $modKirim->nokirimmenu = $modKirim->nokirimmenu;
      $modKirim->tglkirimmenu = $modKirim->tglkirimmenu;
    }

    if (isset($_POST['KirimmenupasienT']) || isset($_POST['KirimmenupegawaiT'])) {
      if (count((array)$modDetailKirim) > 0) {
        if (isset($_POST['KirimmenupegawaiT']) && count((array)$_POST['KirimmenupegawaiT']) > 0) {
          foreach ($_POST['KirimmenupegawaiT'] as $i => $v) {
            if ($v['checkList'] == 1) {
              foreach ($v['menudiet_id'] as $j => $x) {
                if (!empty($x)) {
                  if ($v['jml_kirim'] > $v['jml_kirim_awal']) {
                    $selisih = $v['jml_kirim'] - $v['jml_kirim_awal'];
                    $jml_kirim = $v['jml_kirim'] + $selish;
                  } else if ($v['jml_kirim'] <= $v['jml_kirim_awal']) {
                    $jml_kirim = $v['jml_kirim'];
                  }

                  $updateDetail = KirimmenupegawaiT::model()->updateAll(array('jml_kirim' => $jml_kirim), 'kirimmenupegawai_id=' . $v['kirimmenupegawai_id'][$j] . '');
                  if ($updateDetail) {
                    if (!empty($modDetail->pesanmenupegawai_id)) {
                      PesanmenupegawaiT::model()->updateByPk($modDetail->pesanmenupegawai_id, array('jml_pesan_porsi' => $jml_kirim));
                    }
                    if (Yii::app()->user->getState('krngistokgizi') == TRUE) {
                      if (StokbahanmakananT::validasiStokMenu($modDetail->jml_kirim, $modDetail->menudiet_id)) {
                        StokbahanmakananT::kurangiStokMenu($modDetail->jml_kirim, $modDetail->menudiet_id);
                      } else {
                        $success = true;
                      }
                    }
                  } else {
                    $success = false;
                  }
                }
              }
            }
          }
        } else if (count((array)$_POST['KirimmenupasienT']) > 0) {
          foreach ($_POST['KirimmenupasienT'] as $i => $v) {
            if ($v['checkList'] == 1) {
              foreach ($v['menudiet_id'] as $j => $x) {
                if (!empty($x)) {
                  if ($v['jml_kirim'] > $v['jml_kirim_awal']) {
                    $selisih = $v['jml_kirim'] - $v['jml_kirim_awal'];
                    $jml_kirim = $v['jml_kirim'];
                  } else if ($v['jml_kirim'] <= $v['jml_kirim_awal']) {
                    $jml_kirim = $v['jml_kirim'];
                  }
                  $updateDetail = KirimmenupasienT::model()->updateAll(array('jml_kirim' => $jml_kirim), 'kirimmenupasien_id=' . $v['kirimmenupasien_id'][$j] . '');
                  if ($updateDetail) {
                    if (!empty($modDetail->pesanmenudetail_id)) {
                      PesanmenudetailT::model()->updateByPk($modDetail->pesanmenudetail_id, array('jml_pesan_porsi' => $jml_kirim));
                    }
                    $detail = KirimmenupasienT::model()->findAllByAttributes(array('kirimmenudiet_id' => $v['kirimmenudiet_id'][$j]));
                    $this->updateMenuTindakan($detail);
                    if (Yii::app()->user->getState('krngistokgizi') == TRUE) {
                      // if (StokbahanmakananT::validasiStokMenu($jml_kirim, $x['menudiet_id'])) {
                      //   StokbahanmakananT::kurangiStokMenu($jml_kirim, $x['menudiet_id']);
                      // } else {
                      //   $success = true;
                      // }
                      if (StokbahanmakananT::validasiStokMenu($jml_kirim, $x)){
                        StokbahanmakananT::kurangiStokMenu($jml_kirim, $x);                                                            
                      }else{
                          $success = true;
                      }
                    }
                  } else {
                    $success = false;
                  }
                }
              }
            }
          }
        }

        if ($success == true) {
          $modKirim->isNewRecord = false;
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('IndexKirim', 'idKirimmenudiet' => $modKirim->kirimmenudiet_id, 'id' => 1));
          $this->refresh();
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      }
    }

    $this->render('returMenu', array(
      'modKirim' => $modKirim,
      'modDetailKirim' => $modDetailKirim,
    ));
  }

  public function updateMenuTindakan($KirimPasien)
  {
    $updateTindakan = false;
    $success = true;
    foreach ($KirimPasien as $i => $detail) {
      $criteria = new CDbCriteria();
      $criteria->compare('menudiet_id', $detail->menudiet_id);
      $menudiet = MenuDietM::model()->findAll($criteria);
      // Untuk Mengupdate menu gizi dari TindakanPelayananT
      foreach ($menudiet as $d => $diet) {
        $criteria2 = new CDbCriteria();
        $criteria2->compare('pendaftaran_id', $detail->pendaftaran_id);
        $criteria2->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        $criteria2->compare('daftartindakan_id', $diet->daftartindakan_id);
        $criteria2->addCondition('tindakansudahbayar_id is null');
        $criteria2->order = 'tgl_tindakan desc';
        $criteria2->limit = 1;
        $tindakan = TindakanpelayananT::model()->findAll($criteria2);
        if (count((array)$tindakan) > 0) {
          foreach ($tindakan as $key => $datas) {
            $updateTindakan = TindakanpelayananT::model()->updateAll(
              array(
                'qty_tindakan' => $detail->jml_kirim,
                'tarif_tindakan' => $detail->jml_kirim * $detail->hargasatuan
              ),
              'tindakanpelayanan_id=' . $datas->tindakanpelayanan_id . ''
            );
          }
        }
      }
      if ($updateTindakan) {
        $success = true;
      }
    }
    return $success;
  }
}
