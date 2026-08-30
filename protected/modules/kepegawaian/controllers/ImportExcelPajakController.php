<?php

/**
 * Description of ImportExcelPajakController
 *
 * @author root
 */
class ImportExcelPajakController extends MyAuthController
{
  public $path_view = "kepegawaian.views.importExcelPajak.";

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Import Pajak Pegawai";
    if (isset($_POST['PenggajianpegT']) || isset($_POST['PembayaranjasaT'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;
      try {
        if (isset($_POST['PenggajianpegT'])) {

          foreach ($_POST['PenggajianpegT'] as $id => $val) {
            $model = PenggajianpegT::model()->findByPk($id);
            //                        $model->penerimaanbersih += $model->totalpajak;
            $model->totalpajak = $val['totalpajak'];
            //                        $model->penerimaanbersih -= $model->totalpajak;
            $model->penerimaanbersih = $val['totalpenerimaan'];

            if (isset($val['TJHT']) && !empty($val['TJHT'])) {
              $modPegKomp = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id' => $id, 'komponengaji_id' => 113));
              if (isset($modPegKomp)) {
                PenggajiankompT::model()->updateByPk($modPegKomp->penggajiankomp_id, array('jumlah' => $val['TJHT'], 'satuan' => $val['TJHT']));
              }
            }

            if (isset($val['JKK']) && !empty($val['JKK'])) {
              $modPegKomp = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id' => $id, 'komponengaji_id' => 97));

              if (isset($modPegKomp)) {
                PenggajiankompT::model()->updateByPk($modPegKomp->penggajiankomp_id, array('jumlah' => $val['JKK'], 'satuan' => $val['JKK']));
              }
            }

            if (isset($val['JKM']) && !empty($val['JKM'])) {
              $modPegKomp = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id' => $id, 'komponengaji_id' => 98));

              if (isset($modPegKomp)) {
                PenggajiankompT::model()->updateByPk($modPegKomp->penggajiankomp_id, array('jumlah' => $val['JKM'], 'satuan' => $val['JKM']));
              }
            }

            if (isset($val['TBK']) && !empty($val['TBK'])) {
              $modPegKomp = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id' => $id, 'komponengaji_id' => 114));

              if (isset($modPegKomp)) {
                PenggajiankompT::model()->updateByPk($modPegKomp->penggajiankomp_id, array('jumlah' => $val['TBK'], 'satuan' => $val['TBK']));
              }
            }

            if (isset($val['JHT']) && !empty($val['JHT'])) {
              $modPegKomp = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id' => $id, 'komponengaji_id' => 112));

              if (isset($modPegKomp)) {
                PenggajiankompT::model()->updateByPk($modPegKomp->penggajiankomp_id, array('jumlah' => $val['JHT'], 'satuan' => $val['JHT']));
              }
            }

            if (isset($val['JP']) && !empty($val['JP'])) {
              $modPegKomp = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id' => $id, 'komponengaji_id' => 100));

              if (isset($modPegKomp)) {
                PenggajiankompT::model()->updateByPk($modPegKomp->penggajiankomp_id, array('jumlah' => $val['JP'], 'satuan' => $val['JP']));
              }
            }

            if (isset($val['TBKSHT']) && !empty($val['TBKSHT'])) {
              $modPegKomp = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id' => $id, 'komponengaji_id' => 116));

              if (isset($modPegKomp)) {
                PenggajiankompT::model()->updateByPk($modPegKomp->penggajiankomp_id, array('jumlah' => $val['TBKSHT'], 'satuan' => $val['TBKSHT']));
              }
            }

            if (isset($val['TJP']) && !empty($val['TJP'])) {
              $modPegKomp = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id' => $id, 'komponengaji_id' => 119));

              if (isset($modPegKomp)) {
                PenggajiankompT::model()->updateByPk($modPegKomp->penggajiankomp_id, array('jumlah' => $val['TJP'], 'satuan' => $val['TJP']));
              }
            }

            if (isset($val['PTJP']) && !empty($val['PTJP'])) {
              $modPegKomp = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id' => $id, 'komponengaji_id' => 120));

              if (isset($modPegKomp)) {
                PenggajiankompT::model()->updateByPk($modPegKomp->penggajiankomp_id, array('jumlah' => $val['PTJP'], 'satuan' => $val['PTJP']));
              }
            }

            if (isset($val['PTJHT']) && !empty($val['PTJHT'])) {
              $modPegKomp = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id' => $id, 'komponengaji_id' => 115));

              if (isset($modPegKomp)) {
                PenggajiankompT::model()->updateByPk($modPegKomp->penggajiankomp_id, array('jumlah' => $val['PTJHT'], 'satuan' => $val['PTJHT']));
              }
            }

            if (isset($val['PTBK']) && !empty($val['PTBK'])) {
              $modPegKomp = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id' => $id, 'komponengaji_id' => 99));

              if (isset($modPegKomp)) {
                PenggajiankompT::model()->updateByPk($modPegKomp->penggajiankomp_id, array('jumlah' => $val['PTBK'], 'satuan' => $val['PTBK']));
              }
            }

            if (isset($val['PJKK']) && !empty($val['PJKK'])) {
              $modPegKomp = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id' => $id, 'komponengaji_id' => 117));

              if (isset($modPegKomp)) {
                PenggajiankompT::model()->updateByPk($modPegKomp->penggajiankomp_id, array('jumlah' => $val['PJKK'], 'satuan' => $val['PJKK']));
              }
            }

            if (isset($val['PJKM']) && !empty($val['PJKM'])) {
              $modPegKomp = PenggajiankompT::model()->findByAttributes(array('penggajianpeg_id' => $id, 'komponengaji_id' => 95));

              if (isset($modPegKomp)) {
                PenggajiankompT::model()->updateByPk($modPegKomp->penggajiankomp_id, array('jumlah' => $val['PJKM'], 'satuan' => $val['PJKM']));
              }
            }
            $terima = 0;
            $potongan = 0;

            $criteria = new CDbCriteria();
            $criteria->select = "komponengaji_m.ispotongan, t.jumlah";
            $criteria->join = "JOIN komponengaji_m ON komponengaji_m.komponengaji_id = t.komponengaji_id";
            $criteria->addCondition('penggajianpeg_id = ' . $id);
            $modPenggajianKom = PenggajiankompT::model()->findAll($criteria);

            if (count((array)$modPenggajianKom)) {
              foreach ($modPenggajianKom as $dataPegKom) {
                if ($dataPegKom->ispotongan) {
                  $potongan += $dataPegKom->jumlah;
                } else {
                  $terima += $dataPegKom->jumlah;
                }
              }
            }
            $model->totalterima = $terima;
            $model->totalpotongan = $potongan;

            $model->isimport = true;
            $ok = $ok && $model->save();
          }
        }
        //                if (isset($_POST['PembayaranjasaT'])) {
        //                    foreach ($_POST['PembayaranjasaT'] as $id => $val) {
        //                        $bayar = PembayaranjasaT::model()->findByPk($id);
        //                        $bayar->totalbayarjasa += $bayar->total_pajak;
        //                        $bayar->total_pajak = $val['total_pajak'];
        //                        $bayar->totalbayarjasa -= $bayar->total_pajak;
        //                        $bayar->total_terima = $bayar->totalbayarjasa;
        //                        $bayar->isimport = true;
        //                        $ok = $ok && $bayar->save();
        //                        
        //                        
        //                        $model = PajakdokterT::model()->findByPk($bayar->pajakdokter_id);
        //                        if (!empty($model)) {
        //                            $model->pajakprogressif = $val['total_pajak'];
        //                            $ok = $ok && $model->save();
        //                        }
        //                    }
        //                }

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('index', 'sukses' => 1));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }


    $this->render($this->path_view . 'index', array());
  }

  public function actionUpload()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $str = "";

    if (isset($_FILES['file'])) {
      try {
        $file_path = $_FILES['file']['tmp_name'];

        $sheet = Yii::app()->yexcel->readActiveSheet($file_path);

        $cr = new CDbCriteria();
        $cr->join = 'join pegawai_m p on p.pegawai_id = t.pegawai_id';
        $cr->addCondition("trim(p.nomorindukpegawai) = :npwp");
        $cr->addCondition("t.periodegaji = :periode");
        $cr->addCondition("t.isimport = false");

        //                $cr_jasa = new CDbCriteria();
        //                $cr_jasa->join = 'join pegawai_m p on p.pegawai_id = t.pegawai_id';
        //                $cr_jasa->addCondition("trim(p.nomorindukpegawai) = :npwp");
        //                $cr_jasa->addCondition("t.periodejasa = :periode");
        //                $cr_jasa->addCondition("t.isimport = false");

        $cnt = 0;
        $cnt_ada = 0;

        $array = array();
        foreach ($sheet[1] as $idx => $row) {
          $array[strtolower($row)] = $idx;
        }

        foreach ($sheet as $idx => $row) {

          if ($idx == 1) {
            continue;
          }

          $kode = $row[$array[strtolower('Nik')]];
          $kode = str_replace("‘", "", $kode);
          $kode = str_replace("'", "", $kode);
          $kode = str_replace("`", "", $kode);

          $cr->params[':npwp'] = $kode;
          $cr->params[':periode'] = $row[$array[strtolower('tahun')]] . "-" . str_pad($row[$array[strtolower('masa')]], 2, 0, STR_PAD_LEFT) . "-01";

          $gaji = PenggajianpegT::model()->find($cr);

          if (!empty($gaji)) {
            $str .= $this->renderPartial($this->path_view . "_rowPPH", array(
              'model' => $gaji,
              'tahun' => $row[$array[strtolower('tahun')]],
              'row' => $row,
              'indexRow' => $array
            ), true);
            $cnt_ada++;
          }

          //                    $cr_jasa->params[':npwp'] = $kode;
          //                     $cr_jasa->params[':periode'] = $row[$array[strtolower('tahun')]]."-".str_pad($row[$array[strtolower('masa')]], 2, 0, STR_PAD_LEFT)."-01";
          ////                    $cr_jasa->params[':periode'] = $row['I']."-".str_pad($row['H'], 2, 0, STR_PAD_LEFT)."-01";
          //                   
          //                     $jasa = PembayaranjasaT::model()->find($cr_jasa);
          //                    if (!empty($jasa)) {
          //                        $str .= $this->renderPartial($this->path_view."_rowPPHJasa", array(
          //                            'model'=>$jasa,
          //                            'tahun'=>$row[$array[strtolower('tahun')]],
          //                            'row'=>$row,
          //                            'indexRow'=>$array
          //                        ), true);
          //                        $cnt_ada++;
          //                    }

          $cnt++;
        }

        echo CJSON::encode(array(
          'ok' => 1,
          'msg' => '',
          'html' => $str,
          'total' => $cnt,
          'ada' => $cnt_ada,
        ));
      } catch (Exception $ex) {
        echo CJSON::encode(array(
          'ok' => 0,
          'msg' => $ex->getMessage(),
          'html' => '',
          'total' => 0,
          'ada' => 0
        ));
      }
    }
  }

  public function actionDownloadTemplate()
  {
    $this->layout = '//layouts/printExcel';
    $this->render('_templateExcel', array(
      //                'model'=>$model,
      //                'judulLaporan'=>$judulLaporan,
      //                'periode'=>$periode,
      //                'caraPrint'=>$caraPrint
    ));
  }
}
