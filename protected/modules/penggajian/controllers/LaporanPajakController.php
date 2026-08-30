<?php

class LaporanPajakController extends MyAuthController
{
  public $tgl_awal;
  public $tgl_akhir;
  public $path_view = 'penggajian.views.laporanPajak.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Pajak";
    $model = new GJLaporanpph21V();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tglpenggajian = date('Y-m-d');
    //		$model->tgl_awal = date('d M Y', strtotime('first day of this month'));
    //		$model->tgl_akhir = date('d M Y');
    //$model->tgl_awal = date('d/m/Y', strtotime('first day of this month'));
    //$model->tgl_akhir = date('d/m/Y');


    if (isset($_GET['GJLaporanpph21V'])) {
      $model->attributes = $_GET['GJLaporanpph21V'];
      //            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GJLaporanpph21V']['tgl_awal']);
      //            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GJLaporanpph21V']['tgl_akhir']);
      $model->tglpenggajian = $format->formatDateTimeForDb($_GET['GJLaporanpph21V']['tglpenggajian']);

      //            $model->tglpenggajian = $model->tglpenggajian;
      //            $model->tgl_akhir = $model->tgl_akhir;
    }

    $this->render($this->path_view . 'pajak/index', array(
      'model' => $model, 'format' => $format
    ));
  }

  protected function printFunction($model, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }


  public function actionPrintLaporanPajak()
  {
    $model = new GJLaporanpph21V('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tglpenggajian = date('Y-m-d');
    //        $model->tgl_awal = date("d/m/Y", strtotime('first day of this month'));
    //        $model->tgl_akhir = date("d/m/Y");

    $judulLaporan = 'Laporan Pajak';
    if (isset($_REQUEST['GJLaporanpph21V'])) {
      $model->attributes = $_GET['GJLaporanpph21V'];
      $model->tglpenggajian = $format->formatDateTimeForDb($_GET['GJLaporanpph21V']['tglpenggajian']);
      //            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GJLaporanpph21V']['tgl_awal']);
      //            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GJLaporanpph21V']['tgl_akhir']);
      //            
      //            $model->tgl_awal = $model->tgl_awal." 00:00:00";
      //            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";	 
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'pajak/_printPajak';
    $this->printFunction($model, $caraPrint, $judulLaporan, $target);
  }

  public function actionExportCSV()
  {
    $this->layout = FALSE;
    $model = new GJLaporanpph21V('search');
    $format = new MyFormatter();
    $model->tglpenggajian = date('Y-m-d');

    if (isset($_REQUEST['GJLaporanpph21V'])) {
      $model->attributes = $_GET['GJLaporanpph21V'];
      $model->tglpenggajian = $format->formatDateTimeForDb($_GET['GJLaporanpph21V']['tglpenggajian']);
      //            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GJLaporanpph21V']['tgl_awal']);
      //            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GJLaporanpph21V']['tgl_akhir']);

      if (isset($model)) {
        $judul = "Template CSV Laporan Pajak";
        $content = "";
        $tableName = "laporanpph21_v";

        $content .= 'Nama Pegawai;NIP;NPWP;Kategori Pegawai;Jenis Kelamin;Kode PTKP;Gaji Pokok;Tunjangan Lainnya Uang Lembur dan sebagainya;Honorarium dan Imbalan lain sejenisnya;Premi Asuransi yang Dibayar Pemberi Kerja;Penerimaan dalam Bentuk Natura;Tantiem Bonus Gratifikasi Jasa Produksi dan THR;Jumlah Penghasilan Bruto;Biaya Jabatan (5%);Iuran Pensiun atau Iuran THT/JHT;Jumlah Penghasilan Neto;Jumlah Penghasilan Neto Masa Sebelumnya;Jumlah Penghasilan Neto Disetahunkan;PTKP;PKP;PPh Pasal 21 atas PKP Disetahunkan;PPh Pasal 21 yang telah Dipotong Masa Sebelumnya;PPh Pasal 21 Terutang;PPh Pasal 21 dan PPh Pasal 26 yang telah Dipotong dan Dilunas';

        $criteria = new CDbCriteria();
        $criteria->select = "nama_pegawai, nomorindukpegawai, npwp, kategoripegawai, jeniskelamin, kodeptkp, totalterima, gajipertahun, biayajabatan, potonganpensiun, gajikotor, ptkppertahun, pkp, pph21perbulan, gajipokok,tunjangantetap,honorarium,premiasuransi,tunjanganmakan,tunjanganbonus, jaminanpensiun, bpjskesehatan,netto_masasebelumnya,pph21dipotong,pph21terutang,pph21telahdipotong, kodeptkp_pegawai,jmltanggunan,pph21perbulan";
        $criteria->group = $criteria->select;
        $criteria->addCondition("DATE(tglpenggajian) = '" . $model->tglpenggajian . "'");
        $criteria->compare('LOWER(nomorindukpegawai)', strtolower($model->nomorindukpegawai), true);
        if (!empty($model->kategoripegawai)) {
          if (is_array($model->kategoripegawai)) {
            $criteria->addInCondition('kategoripegawai', $model->kategoripegawai);
          } else {
            $criteria->addCondition('kategoripegawai = ' . $model->kategoripegawai);
          }
        }
        $modPajakPPh = GJLaporanpph21V::model()->findAll($criteria);
        $content .= "\n";
        if (count((array)$modPajakPPh) > 0) {
          foreach ($modPajakPPh as $dataPajak) {
            $dataPajak->tunjanganmakan = 0;
            $hasilNeto = ($dataPajak->gajipokok + $dataPajak->tunjangantetap + $dataPajak->honorarium + $dataPajak->premiasuransi + $dataPajak->tunjanganbonus);
            $iuran = ($dataPajak->potonganpensiun + $dataPajak->jaminanpensiun + $dataPajak->bpjskesehatan);
            $bruto = ($dataPajak->gajipokok + $dataPajak->tunjangantetap + $dataPajak->honorarium + $dataPajak->premiasuransi + $dataPajak->tunjanganbonus + $dataPajak->biayajabatan + $dataPajak->potonganpensiun + $dataPajak->jaminanpensiun + $dataPajak->bpjskesehatan);
            $hasilPkp = ($bruto - $dataPajak->ptkppertahun);
            $npwp = isset($dataPajak->npwp) ? '="' . preg_replace('/[^A-Za-z0-9]/s', "", $dataPajak->npwp) . '"' : "";
            //                    $npwp = isset($dataPajak->npwp)?'"'.$dataPajak->npwp.'"':"";
            $noinduk = isset($dataPajak->nomorindukpegawai) ? '="' . preg_replace('/[^A-Za-z0-9]/s', "", $dataPajak->nomorindukpegawai) . '"' : "";
            //                    $noinduk = isset($dataPajak->nomorindukpegawai)?'"'.$dataPajak->nomorindukpegawai.'"':"";
            $ptkp_kode = $dataPajak->kodeptkp_pegawai . "/" . $dataPajak->jmltanggunan;
            $content .= $dataPajak->nama_pegawai . ';' . $noinduk . ';' . $npwp . ';' . $dataPajak->kategoripegawai . ';' . $dataPajak->jeniskelamin . ';' . $ptkp_kode . ';' . $dataPajak->gajipokok . ';' . $dataPajak->tunjangantetap . ';' . $dataPajak->honorarium . ';' . $dataPajak->premiasuransi . ';' . $dataPajak->tunjanganmakan . ';' . $dataPajak->tunjanganbonus . ';' . $hasilNeto . ';' . $dataPajak->biayajabatan . ';' . $iuran . ';' . $bruto . ';' . $dataPajak->netto_masasebelumnya . ';' . $bruto . ';' . $dataPajak->ptkppertahun . ';' . $hasilPkp . ';' . $dataPajak->pph21perbulan . ';' . $dataPajak->pph21dipotong . ';' . $dataPajak->pph21perbulan . ';' . $dataPajak->pph21perbulan;
            $content .= "\n";
          }
        }


        //             $dt = array();
        //             $table = Yii::app()->db->getSchema()->getTable($tableName);
        //             
        //             $sql = "select nama_pegawai, nomorindukpegawai, npwp, kategoripegawai, jeniskelamin, kodeptkp, totalterima, gajipertahun, biayajabatan, potonganpensiun, gajikotor, ptkppertahun, pkp, pph21perbulan from {$table->name} where DATE(tglpenggajian) between '". $model->tgl_awal ."' and '". $model->tgl_akhir ."' and lower(nomorindukpegawai) like '%". strtolower($model->nomorindukpegawai) ."%' group by nama_pegawai, nomorindukpegawai, npwp, kategoripegawai, jeniskelamin, kodeptkp, totalterima, gajipertahun, biayajabatan, potonganpensiun, gajikotor, ptkppertahun, pkp, pph21perbulan";
        //             
        //             if(count((array)$model->kategoripegawai) > 0){
        //                $sqlPegIn = "(";
        //                 $a=0;
        //                 foreach ($model->kategoripegawai as $kategoriPeg){
        //                    if($a > 0){
        //                         $sqlPegIn .= ",";
        //                     }
        //                     $sqlPegIn .= "'".$kategoriPeg."'";
        //                     
        //                     $a++;
        //                 }
        //                $sqlPegIn .= ")"; 
        //                $sql = "select nama_pegawai, nomorindukpegawai, npwp, kategoripegawai, jeniskelamin, kodeptkp, totalterima, gajipertahun, biayajabatan, potonganpensiun, gajikotor, ptkppertahun, pkp, pph21perbulan from {$table->name} where DATE(tglpenggajian) between '". $model->tgl_awal ."' and '". $model->tgl_akhir ."' and lower(nomorindukpegawai) like '%". strtolower($model->nomorindukpegawai) ."%' and kategoripegawai in " . $sqlPegIn ." group by nama_pegawai, nomorindukpegawai, npwp, kategoripegawai, jeniskelamin, kodeptkp, totalterima, gajipertahun, biayajabatan, potonganpensiun, gajikotor, ptkppertahun, pkp, pph21perbulan";
        //             }
        //             
        //            
        //            $modelSql = Yii::app()->db->createCommand($sql)->queryAll(); 
        //             
        //             $sqlType = "SELECT
        //					a.attname as kolom ,
        //					pg_catalog.format_type(a.atttypid, a.atttypmod) as datatype
        //				FROM
        //					pg_catalog.pg_attribute a
        //				WHERE
        //					a.attnum > 0
        //					AND NOT a.attisdropped
        //					AND a.attrelid = (
        //						SELECT c.oid
        //						FROM pg_catalog.pg_class c
        //							LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace
        //						WHERE c.relname  = 'laporanpph21_v'
        //							AND pg_catalog.pg_table_is_visible(c.oid)
        //					);";
        //                    $sqlType = Yii::app()->db->createCommand($sqlType)->queryAll();
        //                   
        //                    foreach ($sqlType as $type) {
        //                        if($type['kolom'] == 'nama_pegawai' ||
        //                           $type['kolom'] == 'nomorindukpegawai' || 
        //                           $type['kolom'] == 'npwp' ||
        //                                $type['kolom'] == 'kategoripegawai' ||
        //                                $type['kolom'] == 'jeniskelamin' || 
        //                                $type['kolom'] == 'kodeptkp' ||
        //                                $type['kolom'] == 'totalterima' ||
        //                                $type['kolom'] == 'gajipertahun' ||
        //                                $type['kolom'] == 'biayajabatan' ||
        //                                $type['kolom'] == 'potonganpensiun' ||
        //                                $type['kolom'] == 'gajikotor' ||
        //                                $type['kolom'] == 'ptkppertahun' ||
        //                                $type['kolom'] == 'pkp' ||
        //                                $type['kolom'] == 'pph21perbulan'){
        //                             $dt[$type['kolom']] = $type['datatype'];
        //                        }
        //                       
        //                    }
        //            
        //            $kolom = $table->columns;
        //                $i = 0;
        //                
        //                foreach ($kolom as $counter => $column) {
        //                    if($column->name == 'nama_pegawai' || 
        //                        $column->name == 'nomorindukpegawai' || 
        //                        $column->name == 'npwp' ||
        //                        $column->name == 'kategoripegawai' ||
        //                        $column->name == 'jeniskelamin' ||
        //                        $column->name == 'kodeptkp' ||
        //                            $column->name == 'totalterima' ||
        //                            $column->name == 'gajipertahun' ||
        //                            $column->name == 'biayajabatan' ||
        //                            $column->name == 'potonganpensiun' ||
        //                            $column->name == 'gajikotor' ||
        //                            $column->name == 'ptkppertahun' ||
        //                            $column->name == 'pkp' ||
        //                            $column->name == 'pph21perbulan'){
        //                        
        //                        if($column->name == 'potonganpensiun'){
        //                            $content .= "jumlah";
        //                        }else{
        //                            $content .= $column->name;
        //                        }
        //                        
        //                        $i++;
        //                        if (count((array)$kolom) != $i) {
        //                            $content .= ',';
        //                        }
        //                    }
        //                    
        //                }


        //                $kolom = $table->columns;
        //
        //                $i = 0;
        //                foreach ($kolom as $counter => $column) {
        //                    if($column->name == 'nama_pegawai' || 
        //                        $column->name == 'nomorindukpegawai' || 
        //                        $column->name == 'npwp' ||
        //                        $column->name == 'kategoripegawai' ||
        //                        $column->name == 'jeniskelamin' ||
        //                        $column->name == 'kodeptkp' ||
        //                            $column->name == 'totalterima' ||
        //                            $column->name == 'gajipertahun' ||
        //                            $column->name == 'biayajabatan' ||
        //                            $column->name == 'potonganpensiun' ||
        //                            $column->name == 'gajikotor' ||
        //                            $column->name == 'ptkppertahun' ||
        //                            $column->name == 'pkp' ||
        //                            $column->name == 'pph21perbulan'){
        //                         $content .= $dt[$column->name];
        //                    $i++;
        //                    if (count((array)$kolom) != $i) {
        //                        $content .= ',';
        //                    }
        //                    }
        //                   
        //                }

        //                $content .= "\n";
        //                
        //                foreach ($modelSql as $key => $value) {
        //                    $i = 0;
        //
        //                    foreach ($kolom as $counter => $column) {
        //                         
        //                        if($column->name == 'nama_pegawai' || 
        //                        $column->name == 'nomorindukpegawai' || 
        //                        $column->name == 'npwp' ||
        //                        $column->name == 'kategoripegawai' ||
        //                        $column->name == 'jeniskelamin' ||
        //                        $column->name == 'kodeptkp' ||
        //                            $column->name == 'totalterima' ||
        //                            $column->name == 'gajipertahun' ||
        //                            $column->name == 'biayajabatan' ||
        //                            $column->name == 'potonganpensiun' ||
        //                            $column->name == 'gajikotor' ||
        //                            $column->name == 'ptkppertahun' ||
        //                            $column->name == 'pkp' ||
        //                            $column->name == 'pph21perbulan'){
        //                             if($column->name == 'potonganpensiun'){
        //                            $content .= $value[$column->name] + $value['biayajabatan'];
        //                        }else{
        //                            $content .= $value[$column->name];
        //                        }
        //                            
        //                            $i++;
        //                            if (count((array)$kolom) != $i) {
        //                                $content .= ',';
        //                            }
        //                        }
        //                    }
        //
        //                    $content .= "\n";
        //                }

        Yii::app()->getRequest()->sendFile($judul . '-' . date("Y/m/d") . '.csv', $content, "text/csv", false);
        die;
      }
    }
  }
}
