<?php
/**
 * Digunakan untuk laporan RL
 * @author Rusdiyanto <rusdiyanto@.com>
 * @package application.modules.rekamMedis
 * @subpackage controllers
 */
class LaporanSIRSController extends MyAuthController
{
    /**
     * fungsi untuk menampilkan halaman laporan RL
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::app()->name . " - Laporan RL";
        $model = new MenumodulK('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        $this->render('sirs', array(
            'model' => $model,
        ));
    }
    /**
     * fungsi untuk menampilkan halaman laporan pengunjung rs
     */
    public function actionPengunjungRUmahSakit()
    {
        $model = new RKRrl51PengunjungrsV;        
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        
        $criteria = new CDbCriteria();
        $criteria->select = 'statuspasien, sum(jmlpasien) as jmlpasien';
        $criteria->group = 'statuspasien';
        $criteria->addBetweenCondition('DATE(tgl_pendaftaran)',$tgl_awal,$tgl_akhir);
        
		//print_r($criteria);die();

        $statuspasien = LookupM::model()->findAll('lookup_type = '."'statuspasien'");
        // var_dump($statuspasien);die;
        $records = Rl51PengunjungrsV::model()->findAll($criteria);
             
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
        );

        $rows = array();
        $i=0;
        $total_jumlah = 0;
        // var_dump($statuspasien[$i]['lookup_name']);die;

        if (count((array)$records)):
        foreach($records as $row)
        {
        
            $rows[] = array(
                '<td style = "text-align:center;">'. ($i+1).'</td>', '<td>'.$row['statuspasien'].'</td>', '<td style = "text-align:center;">'.number_format($row['jmlpasien'],0,"",".").'</td>'
            );
            $i++;
            
            $total_jumlah += $row['jmlpasien'];
        }    
        else:    
        for($i = 0 ; $i<2;$i++ ){
            $rows[] = array(
                '<td style = "text-align:center;">'. ($i+1).'</td>', '<td>'.$statuspasien[$i]['lookup_name'].'</td>', '<td style = "text-align:center;">'.number_format(0,0,"",".").'</td>'
            );
        }         
      
                    
        endif;
            

        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
       
        foreach($rows as $xxx)
        {
            $table .= '<tr>'. implode('', $xxx) . '<tr>';
        }
        $table .= '<tr><td style="text-align:center;">99</td><td align="right"><b>Total</b></td><td style = "text-align:center;">'. number_format($total_jumlah) .'</td><tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
            );
            $title = 'PENGUNJUNG RUMAH SAKIT';
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 5.1',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){ 
            $this->layout = '//layouts/iframe';
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 5.1',
                    'title'=>'DATA DASAR RUMAH SAKIT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );                
        }else{
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 5.1',
                    'title'=>'PENGUNJUNG RUMAH SAKIT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }        
    }
    /**
     * fungsi untuk menampilkan halaman laporan rawat jalan
     */
    public function actionKunjunganRawatJalan()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;

        $criteria = new CDbCriteria();
        $criteria->select = 'jeniskasuspenyakit_id, jeniskasuspenyakit_nama, sum(jmlpasien) as jmlpasien';
        $criteria->group = 'jeniskasuspenyakit_id, jeniskasuspenyakit_nama';
        $criteria->addBetweenCondition('DATE(tgl_pendaftaran)',$tgl_awal,$tgl_akhir);

        $records = Rl52KunjunganrjV::model()->findAll($criteria);
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
        );
        $rowHeaders= JeniskasuspenyakitM::model()->findAll();

        $rows = array();
        $i=0;
        $total_jumlah = 0;
        if (count((array)$rowHeaders) > 0):
             foreach($rowHeaders as $row)
        {
            $rows[] = array(
                '<td style="text-align:center;">'. ($i+1).'</td>', '<td>'.$row['jeniskasuspenyakit_nama'].'</td>', '<td style="text-align:center;">'.number_format($row['jmlpasien'],0,"",".").'</td>'
            );
            $i++;
            $total_jumlah += $row['jmlpasien'];
        }
            
        else:
            $rows[] = array(
                '<td colspan = "3"><i>Data Tidak Ditemukan</i></td>'
            );
            
        endif;
        
       

        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        $table .= '<tr>';
        foreach($header as $key=>$index)
        {
            $table .= '<td style="text-align:center;" bgcolor="#AFAFAF">'. ($key+1) .'</td>';
        }        
        $table .= '</tr>';
        foreach($rows as $xxx)
        {
            $table .= '<tr>'. implode('', $xxx) . '<tr>';
        }
        $table .= '<tr><td style="text-align:center;"></td><td align="right"><b>Total</b></td><td style="text-align:center;">'. number_format($total_jumlah,0,"",".") .'</td><tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
            );
            $title = "KEGIATAN KUNJUNGAN RAWAT JALAN";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 5.2',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){ 
            $this->layout = '//layouts/iframe';
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 5.2',
                    'title'=>'KEGIATAN KUNJUNGAN RAWAT JALAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );                
        }else{
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 5.2',
                    'title'=>'KEGIATAN KUNJUNGAN RAWAT JALAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }
    }
     /**
     * fungsi untuk menampilkan halaman laporan rawat jalan
     */
    public function actionPrintKunjunganRawatJalan()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;

        $criteria = new CDbCriteria();
        $criteria->select = 'jeniskasuspenyakit_id, jeniskasuspenyakit_nama, sum(jmlpasien) as jmlpasien';
        $criteria->group = 'jeniskasuspenyakit_id, jeniskasuspenyakit_nama';
        $criteria->addBetweenCondition('DATE(tgl_pendaftaran)',$tgl_awal,$tgl_akhir);
        $modProfil=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $modKabupaten = KabupatenM::model()->findByPk($modProfil->kabupaten_id);
        $modPropinsi = PropinsiM::model()->findByPk($modProfil->propinsi_id);
        $records = Rl52KunjunganrjV::model()->findAll($criteria);
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th style="text-align:center;">kode RS</th>',
            '<th style="text-align:center;">Nama RS</th>',
            '<th style="text-align:center;">Bulan</th>',
            '<th style="text-align:center;">Tahun</th>',
            '<th style="text-align:center;">KAB/KOTA</th>',
            '<th style="text-align:center;">KODE PROPINSI</th>',
            '<th width="50" style="text-align:center;">NO</th>', 
            '<th style="text-align:center;">Jenis Kegiatan</th>', 
            '<th style="text-align:center;">Jumlah</th>'
        );

        $rows = array();
        $i=0;
        $total_jumlah = 0;
        if (count((array)$records) > 0):
             foreach($records as $row)
               
        {
            $rows[] = array(
                 '<td>'.$modProfil->nokode_rumahsakit.'</td>', 
                 '<td>'.$modProfil->nama_rumahsakit.'</td>', 
                 '<td></td>', 
                 '<td></td>', 
                 '<td>'.$modKabupaten->kabupaten_nama.'</td>', 
                 '<td>'.$modPropinsi->propinsi_nama.'</td>',                 
                '<td style="text-align:center;">'. ($i+1).'</td>', 
                '<td>'.$row['jeniskasuspenyakit_nama'].'</td>', 
                '<td style="text-align:center;">'.number_format($row['jmlpasien'],0,"",".").'</td>'
            );
            $i++;
            $total_jumlah += $row['jmlpasien'];
        }
            
        else:
            $rows[] = array(
                '<td colspan = "3"><i>Data Tidak Ditemukan</i></td>'
            );
            
        endif;
        
       

        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
       
        foreach($rows as $xxx)
        {
            $table .= '<tr>'. implode('', $xxx) . '<tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
        
       
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporancarabayar',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 5.2',
                    'title'=>'KEGIATAN KUNJUNGAN RAWAT JALAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
    }
     /**
     * fungsi untuk menampilkan halaman laporan sepuluh besar penyakit ri
     */
    public function actionSepuluhBesarPenyakitRawatInap()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        
//        $sql = "
//            SELECT * FROM laporan10besarpenyakit_v
//            WHERE instalasi_id = ".PARAMS::INSTALASI_ID_RI."
//        ";
//        $records = YII::app()->db->createCommand($sql)->queryAll();
        $criteria = new CDbCriteria();
        $criteria->select = "diagnosa_kode, diagnosa_nama";
        $criteria->group = "diagnosa_kode, diagnosa_nama";
        $criteria->addBetweenCondition('DATE(tglmorbiditas)',$tgl_awal,$tgl_akhir);
        $criteria->order = "diagnosa_kode";        
        $records = Rl5310bsrpenyakitriV::model()->findAll($criteria);
               
        
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" rowspan="2" style="text-align:center;">No. Urut</th>', 
            '<th rowspan="2" style="text-align:center;">KODE ICD 10</th>', 
            '<th rowspan="2"  style="text-align:center;">DESKRIPSI</th>',
            '<th colspan="2" style="text-align:center;">Pasien Keluar (Hidup & Mati) Menurut Jenis Kelamin</th>',
            '<th rowspan="2" style="text-align:center;">Jumlah Pasien Keluar Hidup</th>',
            '<th rowspan="2" style="text-align:center;">Jumlah Pasien Keluar Mati</th>',
        );
        $header2 = array(
            '<th style="text-align:center;">LK</th>', 
            '<th style="text-align:center;">PR</th>',
            
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">23</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">24</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">25</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">26</td>',
            // '<td style="text-align:center;" bgcolor="#AFAFAF">8</td>',
        );
        
        $rows = array();
        $i=0;
//        $total_laki = 0;
//        $total_perempuan = 0;
//        $total_lh= 0;
//        $total_lm= 0;
//        $total_ph= 0;
//        $total_pm= 0;
//        $total_pasien = 0;
//        $total_jmlpasien= 0;
        $jumlah = 0;
        $pasein_lh = 0;
        $pasein_ph = 0;
        $pasein_lm = 0;
        $pasein_pm = 0;
//        $jumlah_hidup = 0;
//        $jumlah_mati = 0;
//        $datas = array();
        $no = 0;
//        $total_pasien_hidup= 0;
//        $total_pasien_mati= 0;
        
        if(count((array)$records) > 0):                    
            foreach($records as $row)
            {            
                $no++;            
                $pasein_lh = Rl5310bsrpenyakitriV::model()->getSumPasienHM($row['diagnosa_kode'],'LAKI-LAKI','HIDUP');
                $pasein_ph = Rl5310bsrpenyakitriV::model()->getSumPasienHM($row['diagnosa_kode'],'PEREMPUAN','HIDUP');
                $pasein_lm = Rl5310bsrpenyakitriV::model()->getSumPasienHM($row['diagnosa_kode'],'LAKI-LAKI','MENINGGAL');
                $pasein_pm = Rl5310bsrpenyakitriV::model()->getSumPasienHM($row['diagnosa_kode'],'PEREMPUAN','MENINGGAL');
                $pasein_hidup = Rl5310bsrpenyakitriV::model()->getSumPasienHM($row['diagnosa_kode'],'HIDUP');
                $pasein_mati = Rl5310bsrpenyakitriV::model()->getSumPasienHM($row['diagnosa_kode'],'MENINGGAL');
                $jumlah = $pasein_lh + $pasein_ph + $pasein_lm + $pasein_pm;
//                $laki = $pasein_lh + $pasein_lm;
//                $perempuan = $pasein_ph + $pasein_pm;
               $jumlah_hidup = $pasein_lh + $pasein_ph;
               $jumlah_mati = $pasein_lm + $pasein_pm;

                     $rows[] = array(
                    '<td style=text-align:center;>'.$no.'</td>',
                    '<td>'.$row['diagnosa_kode'].'</td>',
                    '<td>'.$row['diagnosa_nama'].'</td>',
                    '<td style = "text-align:center;">'.number_format($pasein_lh,0,"",".").'</td>',
                    '<td style = "text-align:center;">'.number_format($pasein_ph,0,"",".").'</td>',
                    '<td style = "text-align:center;">'.number_format($jumlah_hidup,0,"",".").'</td>',
                    '<td style = "text-align:center;">'.number_format($jumlah_mati,0,"",".").'</td>',
                    // '<td style = "text-align:center;">'.number_format($jumlah,0,"",".").'</td>',
                    );

//                    $total_lh += $pasein_lh;
//                    $total_lm += $pasein_lm;
//                    $total_ph += $pasein_ph;
//                    $total_pm += $pasein_pm;
//                    $total_laki += $pasein_lh + $pasein_ph;
//                    $total_perempuan += $pasein_lm + $pasein_pm;
//                    $total_pasien_hidup += $jumlah_hidup;
//                    $total_pasien_mati += $jumlah_mati;
            }
        else:
            // $rows[] = array(
            //             '<td colspan = "8"><i>Data Tidak Ditemukan</i></td>',                                                             
            //         );
            for($i=0;$i<10;$i++){
                $rows[] = array(
                    '<td>'.($i+1).'</td>',                                                             
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                );
            }
        endif;
         //foreach() 
       /* foreach($records as $j=>$row)
        {
            $diagnosa_id = $row->diagnosa_id;
            $jeniskelamin = $row->jeniskelamin;
            
            $datas[$diagnosa_id]['diagnosa_id']= $row->diagnosa_id;
            $datas[$diagnosa_id]['jeniskelamin']= $row->jeniskelamin;
            
            $datas[$diagnosa_id]['diagnosa'][$j]['diagnosa_kode'] = $row->diagnosa_kode;
            $datas[$diagnosa_id]['diagnosa'][$j]['jeniskelamin'] = $row->jeniskelamin;
            $datas[$diagnosa_id]['diagnosa'][$j]['pasienhidupmati'] = $row->pasienhidupmati;
            $datas[$diagnosa_id]['diagnosa'][$j]['diagnosa_nama'] = $row->diagnosa_nama;
            $datas[$diagnosa_id]['diagnosa'][$j]['jmlpasien'] = $row->jmlpasien;
                     
        }
        
        if (count((array)$datas) > 0):
            foreach($datas as $key=>$data){
                $diagnosa = $data['diagnosa'];
                $temp = array();
                foreach($diagnosa as $d) {
                    $name = "$d[diagnosa_kode] - $d[jeniskelamin] - $d[pasienhidupmati]";
                    if(!isset($temp[$name])) {
                        $temp[$name] = $d;
                    } else {
                        $temp[$name]['jmlpasien'] += $d['jmlpasien'];
                    }
                }
                $diagnosa = array_values($temp);
                $data['diagnosa'] = $diagnosa;

                foreach($data['diagnosa'] as $x => $val)
                {
                    if($val['pasienhidupmati'] == 'HIDUP'){
                        if($val['jeniskelamin'] == 'LAKI-LAKI'){
                            $lh = $val['jmlpasien'];
                            $lm = '';
                            $ph = '';
                            $pm = '';
                        }else{
                            $ph = $val['jmlpasien'];
                            $pm = '';
                            $lh = '';
                            $lm = '';
                        }                    
                    }else{
                        if($val['jeniskelamin'] == 'LAKI-LAKI'){
                            $lh = '';
                            $lm = $val['jmlpasien'];
                            $ph = '';
                            $pm = '';
                        }else{
                            $ph = '';
                            $pm = $val['jmlpasien'];
                            $lh = '';
                            $lm = '';
                        }   
                    }
                    $jmlpasien = $lh + $lm + $ph + $pm;
                    $rows[] = array(
                        '<td style=text-align:center;>'. ($i+1).'</td>',
                        '<td>'.$val['diagnosa_kode'].'</td>',
                        '<td>'.$val['diagnosa_nama'].'</td>',
                        '<td style=text-align:center;>'.$lh.'</td>',
                        '<td style=text-align:center;>'.$ph.'</td>',
                        '<td style=text-align:center;>'.$lm.'</td>',
                        '<td style=text-align:center;>'.$pm.'</td>',
                        '<td style=text-align:center;>'.$jmlpasien.'</td>',                    
                    );
                        $i++;
                        $total_lh += $lh;
                        $total_lm += $lm;
                        $total_ph += $ph;
                        $total_pm += $pm;
                        $total_pasien += $jmlpasien;
                    }
                } 
        else:
            $rows[] = array(
                        '<td colspan = "8"><i>Data Tidak Ditemukan</i></td>',                                                             
                    );
        endif;*/
          

        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>'.'<tr>'.implode('', $header2).'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        
        foreach($rows as $xxx)
        {
            $table .= '<tr>'. implode('', $xxx) . '<tr>';
        }
//        $table .= '<tr><td></td><td></td><td align="right"><b>Total</b></td><td style=text-align:center;>'. number_format($total_laki,0,"",".") .'</td><td style=text-align:center;>'. $total_perempuan .'<td style=text-align:center;>'. number_format($total_pasien_hidup,0,"",".") .'</td><td style=text-align:center;>'. number_format($total_pasien_mati,0,"",".") .'</td><tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
            );
            $title = "KEGIATAN KUNJUNGAN RAWAT JALAN";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 5.2',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){ 
            $this->layout = '//layouts/iframe';
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 5.3',
                    'title'=>'10 BESAR PENYAKIT RAWAT INAP',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );                
        }else{
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 2;
                $colspan1 = 2;
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 5.3',
                    'title'=>'10 BESAR PENYAKIT RAWAT INAP',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }

    }
     /**
     * fungsi untuk menampilkan halaman laporan rawat inap
     */
     public function actionPrintSepuluhBesarPenyakitRawatInap()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;

        $criteria = new CDbCriteria();
        $criteria->select = "diagnosa_kode, diagnosa_nama,tglmorbiditas";
        $criteria->group = "diagnosa_kode, diagnosa_nama,tglmorbiditas";
        $criteria->addBetweenCondition('DATE(tglmorbiditas)',$tgl_awal,$tgl_akhir);
        $criteria->order = "diagnosa_kode";        
        $records = Rl5310bsrpenyakitriV::model()->findAll($criteria);
        $modProfil=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $modKabupaten = KabupatenM::model()->findByPk($modProfil->kabupaten_id);
        $modPropinsi = PropinsiM::model()->findByPk($modProfil->propinsi_id);
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th style="text-align:center;">KODE PROPINSI</th>', 
            '<th style="text-align:center;">KAB/KOTA</th>', 
            '<th style="text-align:center;">KODE RS</th>', 
            '<th style="text-align:center;">NAMA RS</th>', 
            '<th style="text-align:center;">BULAN</th>', 
            '<th style="text-align:center;">TAHUN</th>', 
            '<th width="50" style="text-align:center;">No. Urut</th>', 
            '<th style="text-align:center;">KODE ICD 10</th>', 
            '<th style="text-align:center;">DESKRIPSI</th>',
            '<th style="text-align:center;">Pasien Keluar Hidup Menurut Jenis LK</th>',
            '<th style="text-align:center;">Pasien Keluar Hidup Menurut Jenis PR</th>',
            '<th style="text-align:center;">Pasien Keluar Mati Menurut Jenis JK LK</th>',
            '<th style="text-align:center;">Pasien Keluar Mati Menurut Jenis JK PR</th>',
            '<th style="text-align:center;">Total ALL</th>',
        );
        $header2 = array(
            '<th style="text-align:center;">LK</th>', 
            '<th style="text-align:center;">PR</th>',
            
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">4</td>',
            
            '<td style="text-align:center;" bgcolor="#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">7</td>',
        );
        
        $rows = array();
        $i=0;
        $total_laki = 0;
        $total_perempuan = 0;
        $total_lh= 0;
        $total_lm= 0;
        $total_ph= 0;
        $total_pm= 0;
        $total_pasien = 0;
        $total_jmlpasien= 0;
        $jumlah = 0;
        $pasein_lh = 0;
        $pasein_ph = 0;
        $pasein_lm = 0;
        $pasein_pm = 0;
        $jumlah_hidup = 0;
        $jumlah_mati = 0;
        $datas = array();
        $no = 0;
        $total_pasien_hidup= 0;
        $total_pasien_mati= 0;
        
        if(count((array)$records) > 0):                    
            foreach($records as $row)
            {            
                $no++;            
                $pasein_lh = Rl5310bsrpenyakitriV::model()->getSumPasienHM($row['diagnosa_kode'],'LAKI-LAKI','HIDUP');
                $pasein_ph = Rl5310bsrpenyakitriV::model()->getSumPasienHM($row['diagnosa_kode'],'PEREMPUAN','HIDUP');
                $pasein_lm = Rl5310bsrpenyakitriV::model()->getSumPasienHM($row['diagnosa_kode'],'LAKI-LAKI','MENINGGAL');
                $pasein_pm = Rl5310bsrpenyakitriV::model()->getSumPasienHM($row['diagnosa_kode'],'PEREMPUAN','MENINGGAL');
                $jumlah = $pasein_lh + $pasein_ph + $pasein_lm + $pasein_pm;
                $laki = $pasein_lh + $pasein_lm;
                $perempuan = $pasein_ph + $pasein_pm;
                $jumlah_hidup = $pasein_lh + $pasein_ph;
                $jumlah_mati = $pasein_lm + $pasein_pm;

                     $rows[] = array(
                    '<td style=text-align:center;>'.$modPropinsi->propinsi_nama.'</td>',
                    '<td style=text-align:center;>'.$modKabupaten->kabupaten_nama.'</td>',
                    '<td style=text-align:center;>'.$modProfil->nokode_rumahsakit.'</td>',
                    '<td style=text-align:center;>'.$modProfil->nama_rumahsakit.'</td>',
                    '<td style=text-align:center;>'.date('M',strtotime($row['tglmorbiditas'])).'</td>',
                    '<td style=text-align:center;>'.date('Y',strtotime($row['tglmorbiditas'])).'</td>',
                    '<td style=text-align:center;>'.$no.'</td>',
                    '<td>'.$row['diagnosa_kode'].'</td>',
                    '<td>'.$row['diagnosa_nama'].'</td>',
                    '<td style = "text-align:center;">'.number_format($pasein_lh,0,"",".").'</td>',
                    '<td style = "text-align:center;">'.number_format($pasein_ph,0,"",".").'</td>',
                    '<td style = "text-align:center;">'.number_format($pasein_lm,0,"",".").'</td>',
                    '<td style = "text-align:center;">'.number_format($pasein_pm,0,"",".").'</td>',
                    '<td style = "text-align:center;">'.number_format($jumlah,0,"",".").'</td>',
                    );

                    $total_lh += $pasein_lh;
                    $total_lm += $pasein_lm;
                    $total_ph += $pasein_ph;
                    $total_pm += $pasein_pm;
                    $total_laki += $pasein_lh + $pasein_ph;
                    $total_perempuan += $pasein_lm + $pasein_pm;
                    $total_pasien_hidup += $jumlah_hidup;
                    $total_pasien_mati += $jumlah_mati;
            }
        else:
            $rows[] = array(
                        '<td colspan = "8"><i>Data Tidak Ditemukan</i></td>',                                                             
                    );
        endif;
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        
        foreach($rows as $xxx)
        {
            $table .= '<tr>'. implode('', $xxx) . '<tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
       
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 2;
                $colspan1 = 2;
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporanGigimulut',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 5.3',
                    'title'=>'10 BESAR PENYAKIT RAWAT INAP',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            

    }
     /**
     * fungsi untuk menampilkan halaman sepuluh besar laporan rawat jalan
     */
    public function actionPrintSepuluhBesarPenyakitRawatJalan()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        
        $criteria = new CDbCriteria();
        $criteria->select = "diagnosa_kode, diagnosa_nama,tglmorbiditas";
        $criteria->group = "diagnosa_kode, diagnosa_nama,tglmorbiditas";
        $criteria->addBetweenCondition('DATE(tglmorbiditas)',$tgl_awal,$tgl_akhir);
        $criteria->order = "diagnosa_kode";        
        $records = Rl5410bsrpenyakitrjV::model()->findAll($criteria);
        
        $criteriaL = new CDbCriteria();
        $criteriaL->select = "diagnosa_kode, sum(jmlpasien) as jmlpasien, sum(jmlkasus) as jmlkasus, jeniskelamin ";
        $criteriaL->group = "diagnosa_kode,  jeniskelamin";
        $criteriaL->addCondition("jeniskelamin = 'LAKI-LAKI' ");
        $criteriaL->addBetweenCondition('DATE(tglmorbiditas)',$tgl_awal,$tgl_akhir);
        $criteriaL->order = "diagnosa_kode";        
        $recordsL = Rl5410bsrpenyakitrjV::model()->findAll($criteriaL);
        
        $criteriaP = new CDbCriteria();
        $criteriaP->select = "diagnosa_kode,  sum(jmlpasien) as jmlpasien, sum(jmlkasus) as jmlkasus, jeniskelamin ";
        $criteriaP->group = "diagnosa_kode,  jeniskelamin";
        $criteriaP->addCondition("jeniskelamin = 'PEREMPUAN' ");
        $criteriaP->addBetweenCondition('DATE(tglmorbiditas)',$tgl_awal,$tgl_akhir);
        $criteriaP->order = "diagnosa_kode";        
        $recordsP = Rl5410bsrpenyakitrjV::model()->findAll($criteriaP);
        
        $modProfil=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $modKabupaten = KabupatenM::model()->findByPk($modProfil->kabupaten_id);
        $modPropinsi = PropinsiM::model()->findByPk($modProfil->propinsi_id);        
        $header = array(
            '<th style="text-align:center;">KODE PROPINSI</th>', 
            '<th style="text-align:center;">KAB/KOTA</th>', 
            '<th style="text-align:center;">KODE RS</th>', 
            '<th style="text-align:center;">NAMA RS</th>', 
            '<th style="text-align:center;">BULAN</th>', 
            '<th style="text-align:center;">TAHUN</th>', 
            '<th width="50" style="text-align:center;">No. Urut</th>', 
            '<th style="text-align:center;">KODE ICD 10</th>', 
            '<th style="text-align:center;">DESKRIPSI</th>',
            '<th style="text-align:center;">Kasus Baru Menurut Jenis Kelamin LK</th>',
            '<th style="text-align:center;">Kasus Baru Menurut Jenis Kelamin PR</th>',
            '<th style="text-align:center;">Jumlah Kasus Baru (23 + 24)</th>',
            '<th style="text-align:center;">Jumlah Kunjungan</th>'
        );
        $header2 = array(
            '<th style="text-align:center;">Laki - Laki</th>', 
            '<th style="text-align:center;">Perempuan</th>',
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor = "#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">23</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">24</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">25</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">26</td>',
        );

        $rows = array();
        $i=0;
        $total_laki = 0;
        $total_perempuan = 0;
        $total_kasus = 0;
        $total_kunjungan = 0;
        $pasein_kl = 0;
        $pasein_kp = 0;
        $jumlahkasusBaru = 0;
        $jumlah = 0;
        $datas = array();
        $no = 0;
        $diagnosa_kode = 0;
        $lakilaki_kasus = 0;
        $lakilaki_kunjungan = 0;
        $perempuan_kasus = 0;
        $lperempuan_kunjungan = 0;
        foreach($records as $row)
        {
            $diagnosa_kode = $row->diagnosa_kode;
            $tglmorbiditas = $row->tglmorbiditas;
            $datas[$diagnosa_kode]['diagnosa']['diagnosa_kode'] = $row->diagnosa_kode;
            $datas[$diagnosa_kode]['diagnosa']['diagnosa_nama'] = $row->diagnosa_nama;
            $datas[$tglmorbiditas]['diagnosa']['tglmorbiditas'] = $row->tglmorbiditas;
            foreach($recordsL as $lakilaki):               
                if (($row->diagnosa_kode == $lakilaki->diagnosa_kode))
                {
                    $datas[$diagnosa_kode]['diagnosa']['lakilaki_kasus'] = $lakilaki->jmlkasus;
                    $datas[$diagnosa_kode]['diagnosa']['lakilaki_kunjungan'] = $lakilaki->jmlpasien;                  
                }                  
            endforeach;
            
            
            //masukkan data wanita
            foreach($recordsP as $perempuan):
                  if (($row->diagnosa_kode == $perempuan->diagnosa_kode))
                {
                    $datas[$diagnosa_kode]['diagnosa']['perempuan_kasus'] = $perempuan->jmlkasus;
                    $datas[$diagnosa_kode]['diagnosa']['perempuan_kunjungan'] = $perempuan->jmlpasien;                  
                }    
            endforeach;
        }
       // var_dump($datas);die;
        
        if(count((array)$datas) > 0):                    
            foreach($datas as $key => $row)
            {            
                $no++;        
                       
               // var_dump($row['diagnosa']['lakilaki_kasus']);die;
                if (array_key_exists('lakilaki_kasus',$row['diagnosa']))
                {
                    $pasein_kl = $row['diagnosa']['lakilaki_kasus'];
                }
                else
                {
                    $pasein_kl = 0;
                }
                
                if (array_key_exists('lakilaki_kunjungan',$row['diagnosa']))
                {
                    $lakilaki_kunjungan = $row['diagnosa']['lakilaki_kunjungan'];
                }
                else
                {
                    $lakilaki_kunjungan = 0;
                }
                
                if (array_key_exists('perempuan_kasus',$row['diagnosa']))
                {
                    $pasein_kp = $row['diagnosa']['perempuan_kasus'];
                }
                else
                {
                    $pasein_kp = 0;
                }
                
                if (array_key_exists('perempuan_kunjungan',$row['diagnosa']))
                {
                    $perempuan_kunjungan = $row['diagnosa']['perempuan_kunjungan'];
                }
                else
                {
                    $perempuan_kunjungan = 0;
                }
                                           
                
                $jumlahkasusBaru = $pasein_kl+ $pasein_kp;
                $jumlah = $perempuan_kunjungan + $lakilaki_kunjungan;

                     $rows[] = array(
                         '<td>'.$modPropinsi->propinsi_nama.'</td>',
                         '<td>'.$modkabaputen->kabupaten_nama.'</td>',
                         '<td>'.$modProfil->nokode_rumahsakit.'</td>',
                         '<td>'.$modProfil->nama_rumahsakit.'</td>',
                         '<td>'.date('M',strtotime($row['diagnosa']['tglmorbiditas'])).'</td>',
                         '<td>'.date('Y',strtotime($row['diagnosa']['tglmorbiditas'])).'</td>',
                    '<td style=text-align:center;>'.$no.'</td>',
                    '<td>'.$row['diagnosa']['diagnosa_kode'].'</td>',
                    '<td>'.$row['diagnosa']['diagnosa_nama'].'</td>',
                    '<td style = "text-align:center;">'.number_format($pasein_kl,0,"",".").'</td>',
                    '<td style = "text-align:center;">'.number_format($pasein_kp,0,"",".").'</td>',
                    '<td style = "text-align:center;">'.number_format($jumlahkasusBaru,0,"",".").'</td>',                    
                    '<td style = "text-align:center;">'.number_format($jumlah,0,"",".").'</td>',
                    );
                    
                    $total_laki += $pasein_kl;
                    $total_perempuan += $pasein_kp;
                    $total_kasus +=  $jumlahkasusBaru;
                    $total_kunjungan += $jumlah;
                    //$total_pasien += $jumlah;
            }
        else:
            for($i=0;$i<10;$i++){
                $rows[] = array(
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                );
            }
          
        endif;
       
               
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
       
        foreach($rows as $xxx)
        {
            $table .= '<tr>'. implode('', $xxx) . '<tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
        
        
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 2;
                $colspan1 = 2;
                $this->layout = '//layouts/printExcel';
            }
            
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 5.4',
                    'title'=>'10 BESAR PENYAKIT RAWAT JALAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            

    }
     /**
     * fungsi untuk menampilkan halaman sepuluh besar laporan rawat jalan
     */
    public function actionSepuluhBesarPenyakitRawatJalan()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        
//        $sql = "
//            SELECT * FROM laporan10besarpenyakit_v
//            WHERE instalasi_id = ".PARAMS::INSTALASI_ID_RJ."
//        ";
//        $records = YII::app()->db->createCommand($sql)->queryAll()
		
		/*$sql = "
			SELECT
			diagnosa_id,
			diagnosa_kode,
			diagnosa_nama,
			kasusdiagnosa,
			SUM(lakilaki) AS lakilaki,
			SUM(perempuan) AS perempuan,
			SUM(lakilaki) + SUM(perempuan) AS jmlkasus,
			SUM(jmlkunjungan) AS jmlkunjungan
			FROM (
			SELECT
			diagnosa_id,
			diagnosa_kode,
			diagnosa_nama,
			kasusdiagnosa,
			SUM(jmlkasus) AS lakilaki,
			0 AS perempuan,
			SUM(jmlpasien) AS jmlkunjungan
			FROM
			rl5_4_10bsrpenyakitrj_v
			WHERE jeniskelamin = 'LAKI-LAKI'
			AND tglmorbiditas > '".$tgl_awal."'
			GROUP BY
			diagnosa_id,
			diagnosa_kode,
			diagnosa_nama,
			kasusdiagnosa,
			jeniskelamin

			UNION

			SELECT
			diagnosa_id,
			diagnosa_kode,
			diagnosa_nama,
			kasusdiagnosa,
			0 AS lakilaki,
			SUM(jmlkasus) AS perempuan,
			SUM(jmlpasien) AS jmlkunjungan
			FROM
			rl5_4_10bsrpenyakitrj_v
			WHERE jeniskelamin = 'PEREMPUAN'
			AND tglmorbiditas > '".$tgl_akhir."'
			GROUP BY
			diagnosa_id,
			diagnosa_kode,
			diagnosa_nama,
			kasusdiagnosa,
			jeniskelamin) rl5_4_10bsrpenyakitrj
			GROUP BY
			diagnosa_id,
			diagnosa_kode,
			diagnosa_nama,
			kasusdiagnosa
			ORDER BY
			diagnosa_kode ASC
			";*/
                       
                //var_dump($records);die;
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        
        $criteria = new CDbCriteria();
        $criteria->select = "diagnosa_kode, diagnosa_nama ";
        $criteria->group = "diagnosa_kode, diagnosa_nama";
        $criteria->addBetweenCondition('DATE(tglmorbiditas)',$tgl_awal,$tgl_akhir);
        $criteria->order = "diagnosa_kode";        
        $records = Rl5410bsrpenyakitrjV::model()->findAll($criteria);
        
        $criteriaL = new CDbCriteria();
        $criteriaL->select = "diagnosa_kode, sum(jmlpasien) as jmlpasien, sum(jmlkasus) as jmlkasus, jeniskelamin ";
        $criteriaL->group = "diagnosa_kode,  jeniskelamin";
        $criteriaL->addCondition("jeniskelamin = 'LAKI-LAKI' ");
        $criteriaL->addBetweenCondition('DATE(tglmorbiditas)',$tgl_awal,$tgl_akhir);
        $criteriaL->order = "diagnosa_kode";        
        $recordsL = Rl5410bsrpenyakitrjV::model()->findAll($criteriaL);
        
        $criteriaP = new CDbCriteria();
        $criteriaP->select = "diagnosa_kode,  sum(jmlpasien) as jmlpasien, sum(jmlkasus) as jmlkasus, jeniskelamin ";
        $criteriaP->group = "diagnosa_kode,  jeniskelamin";
        $criteriaP->addCondition("jeniskelamin = 'PEREMPUAN' ");
        $criteriaP->addBetweenCondition('DATE(tglmorbiditas)',$tgl_awal,$tgl_akhir);
        $criteriaP->order = "diagnosa_kode";        
        $recordsP = Rl5410bsrpenyakitrjV::model()->findAll($criteriaP);
                
        $header = array(
            '<th width="50" rowspan="2" style="text-align:center;">No. Urut</th>', 
            '<th rowspan="2" style="text-align:center;">KODE ICD 10</th>', 
            '<th rowspan="2"  style="text-align:center;">DESKRIPSI</th>',
            '<th colspan="2" style="text-align:center;">KASUS BARU MENURUT JENIS KELAMIN</th>',
            '<th rowspan="2" style="text-align:center;">Jumlah Kasus Baru (4 + 5)</th>',
            '<th rowspan="2" style="text-align:center;">Jumlah Kunjungan</th>'
        );
        $header2 = array(
            '<th style="text-align:center;">Laki - Laki</th>', 
            '<th style="text-align:center;">Perempuan</th>',
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor = "#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">7</td>',
        );

        $rows = array();
        $i=0;
        $total_laki = 0;
        $total_perempuan = 0;
        $total_kasus = 0;
        $total_kunjungan = 0;
        $pasein_kl = 0;
        $pasein_kp = 0;
        $jumlahkasusBaru = 0;
        $jumlah = 0;
        $datas = array();
        $no = 0;
        $diagnosa_kode = 0;
        $lakilaki_kasus = 0;
        $lakilaki_kunjungan = 0;
        $perempuan_kasus = 0;
        $lperempuan_kunjungan = 0;
        foreach($records as $row)
        {
            $diagnosa_kode = $row->diagnosa_kode;
            $datas[$diagnosa_kode]['diagnosa']['diagnosa_kode'] = $row->diagnosa_kode;
            $datas[$diagnosa_kode]['diagnosa']['diagnosa_nama'] = $row->diagnosa_nama;
            foreach($recordsL as $lakilaki):               
                if (($row->diagnosa_kode == $lakilaki->diagnosa_kode))
                {
                    $datas[$diagnosa_kode]['diagnosa']['lakilaki_kasus'] = $lakilaki->jmlkasus;
                    $datas[$diagnosa_kode]['diagnosa']['lakilaki_kunjungan'] = $lakilaki->jmlpasien;                  
                }                  
            endforeach;
            
            
            //masukkan data wanita
            foreach($recordsP as $perempuan):
                  if (($row->diagnosa_kode == $perempuan->diagnosa_kode))
                {
                    $datas[$diagnosa_kode]['diagnosa']['perempuan_kasus'] = $perempuan->jmlkasus;
                    $datas[$diagnosa_kode]['diagnosa']['perempuan_kunjungan'] = $perempuan->jmlpasien;                  
                }    
            endforeach;
        }
       // var_dump($datas);die;
        
        if(count((array)$datas) > 0):                    
            foreach($datas as $key => $row)
            {            
                $no++;        
                       
               // var_dump($row['diagnosa']['lakilaki_kasus']);die;
                if (array_key_exists('lakilaki_kasus',$row['diagnosa']))
                {
                    $pasein_kl = $row['diagnosa']['lakilaki_kasus'];
                }
                else
                {
                    $pasein_kl = 0;
                }
                
                if (array_key_exists('lakilaki_kunjungan',$row['diagnosa']))
                {
                    $lakilaki_kunjungan = $row['diagnosa']['lakilaki_kunjungan'];
                }
                else
                {
                    $lakilaki_kunjungan = 0;
                }
                
                if (array_key_exists('perempuan_kasus',$row['diagnosa']))
                {
                    $pasein_kp = $row['diagnosa']['perempuan_kasus'];
                }
                else
                {
                    $pasein_kp = 0;
                }
                
                if (array_key_exists('perempuan_kunjungan',$row['diagnosa']))
                {
                    $perempuan_kunjungan = $row['diagnosa']['perempuan_kunjungan'];
                }
                else
                {
                    $perempuan_kunjungan = 0;
                }
                                           
                
                $jumlahkasusBaru = $pasein_kl+ $pasein_kp;
                $jumlah = $perempuan_kunjungan + $lakilaki_kunjungan;

                     $rows[] = array(
                    '<td style=text-align:center;>'.$no.'</td>',
                    '<td>'.$row['diagnosa']['diagnosa_kode'].'</td>',
                    '<td>'.$row['diagnosa']['diagnosa_nama'].'</td>',
                    '<td style = "text-align:center;">'.number_format($pasein_kl,0,"",".").'</td>',
                    '<td style = "text-align:center;">'.number_format($pasein_kp,0,"",".").'</td>',
                    '<td style = "text-align:center;">'.number_format($jumlahkasusBaru,0,"",".").'</td>',                    
                    '<td style = "text-align:center;">'.number_format($jumlah,0,"",".").'</td>',
                    );
                    
                    $total_laki += $pasein_kl;
                    $total_perempuan += $pasein_kp;
                    $total_kasus +=  $jumlahkasusBaru;
                    $total_kunjungan += $jumlah;
                    //$total_pasien += $jumlah;
            }
        else:
            // $rows[] = array(
            //             '<td colspan = "8"><i>Data Tidak Ditemukan</i></td>',                                                             
            //         );
            for($i=0;$i<10;$i++){
                $rows[] = array(
                    '<td>'.($i+1).'</td>',                                                             
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                    '<td></td>',                                                             
                );
            }
        endif;

        /*foreach($records as $j=>$row)
        {
            $diagnosa_id = $row['diagnosa_id'];
//            $jeniskelamin = $row["jeniskelamin"];
            
            $datas[$diagnosa_id]['diagnosa_id']= $row["diagnosa_id"];
            //$datas[$diagnosa_id]['jeniskelamin']= $row["jeniskelamin"];
            
            $datas[$diagnosa_id]['diagnosa'][$j]['diagnosa_kode'] = $row["diagnosa_kode"];
            $datas[$diagnosa_id]['diagnosa'][$j]['lakilaki'] = $row["lakilaki"];
            $datas[$diagnosa_id]['diagnosa'][$j]['perempuan'] = $row["perempuan"];
            $datas[$diagnosa_id]['diagnosa'][$j]['diagnosa_nama'] = $row["diagnosa_nama"];
            $datas[$diagnosa_id]['diagnosa'][$j]['jmlpasien'] = $row["jmlkunjungan"];
            $datas[$diagnosa_id]['diagnosa'][$j]['jmlkasus'] = $row["jmlkasus"];
            $datas[$diagnosa_id]['diagnosa'][$j]['jmlkunjungan'] = $row["jmlkunjungan"];
                     
        }

        if (count((array)$datas) > 0):
            foreach($datas as $key=>$data){
                foreach($data['diagnosa'] as $x => $val)
                {
                    $jmlkasus = $val['jmlkunjungan'];

                                            $rows[] = array(
                                                    '<td style=text-align:center;>'. ($i+1).'</td>',
                                                    '<td>'.$val['diagnosa_kode'].'</td>',
                                                    '<td>'.$val['diagnosa_nama'].'</td>',
                                                    '<td style=text-align:center;>'.$val['lakilaki'].'</td>',
                                                    '<td style=text-align:center;>'.$val['perempuan'].'</td>',
                                                    '<td style=text-align:center;>'.$jmlkasus.'</td>',
                                                    '<td style=text-align:center;>'.$val['jmlkunjungan'].'</td>',
                                            );
                    $i++;
                    $total_laki += $val['lakilaki'];
                    $total_perempuan += $val['perempuan'];
                    $total_kasus += $val['jmlkunjungan'];
                    $total_kunjungan += $val['jmlkunjungan'];
                }
            }
        else:
            $rows[] = array(
                    '<td colspan = "8"><i>Data Tidak Ditemukan</i></td>',                   
            );
        endif;*/
               
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>'.'<tr>'.implode("", $header2).'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        foreach($rows as $xxx)
        {
            $table .= '<tr>'. implode('', $xxx) . '<tr>';
        }
        $table .= '<tr><td></td><td></td><td align="right"><b>Total</b></td><td style=text-align:center;>'. number_format($total_laki,0,"",".") .'</td><td style=text-align:center;>'. number_format($total_perempuan,0,"",".") .'</td><td style=text-align:center;>'. number_format($total_kasus,0,"",".") .'</td><td style=text-align:center;>'. number_format($total_kunjungan,0,"",".") .'</td><tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
            );
            $title = "10 BESAR PENYAKIT RAWAT JALAN";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 5.4',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){ 
            $this->layout = '//layouts/iframe';
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 5.4',
                    'title'=>'10 BESAR PENYAKIT RAWAT JALAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );                
        }else{
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 2;
                $colspan1 = 2;
                $this->layout = '//layouts/printExcel';
            }
            
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 5.4',
                    'title'=>'10 BESAR PENYAKIT RAWAT JALAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }

    }
     /**
     * fungsi untuk menampilkan halaman data dasar rs
     */
     public function actionDataDasarRS()
    {
        $model = new Rl1datarsV('search');                
            
        if (isset($_GET['Rl1datarsjmbedV'])){
            $model->attributes = $_GET['Rl1datarsjmbedV'];              
        }
        
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;

        // $model->kelaspelayanan_nama = $_GET['Rl1datarsjmbedV'];
        // print_r($model->kelaspelayanan_nama);exit();

        $sql = " 
        SELECT * FROM rl1datars_v WHERE profilrs_id = ".PARAMS::getDefaultProfilRS()."";
//        $sql2 ="
//        SELECT * FROM rl1datarsjmbed_v";

        $records = YII::app()->db->createCommand($sql)->queryAll();

//        $records2 = YII::app()->db->createCommand($sql2)->queryAll();

        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $rows = array();
        $i=0;

        $table = '<table border = "1" cellpadding="2" cellspacing="0" class="table border" style="width:100%">';
        $table .= '<tbody>';
        
        $i = 0;
        $judul[] = array("Nomor Kode RS","Tanggal Registrasi","Nama Rumah Sakit","Jenis Rumah Sakit","Kelas Rumah Sakit",
            "Nama Direktur RS","Nama Penyelenggara RS","Alamat/Lokasi RS","Kab/Kota", "Kode Pos", "Telepon","Fax","Email",
            "Nomor Telp Bag. Umum/Humas RS","Website","Luas Rumah Sakit","Tanah","Bangunan","Surat Izin/Penetapan",
            "Nomor","Tanggal","Oleh","Sifat","Masa Berlaku s/d thn", "Status Penyelenggara Swasta *","Akreditasi RS *",
            "Pentahapan *","Status *","Tanggal Akreditasi", "Jumlah Tempat Tidur", "Pernitalogi", "Kelas VVIP", "Kelas VIP", "Kelas I",
            "Kelas II","Kelas III","ICU","PICU","NICU","ICCU","HCU","Ruang Isolasi","Ruang UGD","Ruang Bersalin","Ruang Operasi",
            "Jumlah Tenaga medis","Dokter Sp.A","Dokter Sp.OG","Dokter Sp.OG","Dokter Sp.Pd","Dokter Sp.B","Dokter Sp.Rad",
            "Dokter Sp.RK","Dokter Sp.An","Dokter Sp.Jp","Dokter Sp.M","Dokter Sp.THT","Dokter Sp.Kj","Dokter Sp.PK","Dokter Sub Spesialis",
            "Dokter Spesialis Lain", "Dokter Umum", "Dokter Gigi","Dokter Gigi Spesialis","Perawat","Bidan","Farmasi","Tenaga Kesehatan Lainnya",
            "Jumlah Tenaga Non Kesehatan");

        // $isi[] = array("OK");
//        $hitung = array_count_values($judul);
        // echo $hitung["Nomor Kode RS"];
        // $arr = count((array)$hitung);
        // echo $arr;
        for($i=0; $i<69; $i++){
                $no = $i;                    
            $table .= '<tr>';
            $table .= '<td>'.($i+1). '</td>';            
            foreach($judul as $a){
                if (isset($a[$i])){
                    $table .= '<td>'.$a[$i].'</td>';
                    $table .= '<td>:</td>';
                }
               
                // $table .= '<td>'.$b[$i].'</td>'; 
            }
            foreach ($records as $b) {
                $rows[] = array(
                    $b['nokode_rumahsakit']
                );

            }
//            foreach ($c as $d) {
//                $rows3[] = array(
//                     $d 
//                    );
//            }
            

            if($i==0) {
                $table .= '<td>'.$b['nokode_rumahsakit'].'</td>';
            }elseif($i==1){
                $table .= '<td>'.$b['tglregistrasi'].'</td>';
            }elseif($i==2){
                $table .= '<td>'.$b['nama_rumahsakit'].'</td>';
            }elseif($i==3){
                $table .= '<td>'.$b['jenisrs_profilrs'].'</td>';
            }elseif($i==4){
                $table .= '<td>'.$b['kelas_rumahsakit'].'</td>';
            }elseif($i==5){
                $table .= '<td>'.$b['namadirektur_rumahsakit'].'</td>';
            }elseif($i==6){
                $table .= '<td>'.$b['namakepemilikanrs'].'</td>';
            }elseif($i==7){
                $table .= '<td>'.$b['alamatlokasi_rumahsakit'].'</td>';
            }elseif($i==8){
                $table .= '<td>'.$b['kabupaten_nama'].'</td>';
            }elseif($i==9){
                $table .= '<td>'.$b['kode_pos'].'</td>';
            }elseif($i==10){
                $table .= '<td>'.$b['no_telp_profilrs'].'</td>';
            }elseif($i==11){
                $table .= '<td>'.$b['no_faksimili'].'</td>';
            }elseif($i==12){
                $table .= '<td>'.$b['email'].'</td>';
            }elseif($i==13){
                $table .= '<td>'.$b['notelphumas'].'</td>';
            }elseif($i==14){
                $table .= '<td>'.$b['website'].'</td>';
            }elseif($i==15){
                $table .= '<td></td>';
            }elseif($i==16){
                $table .= '<td>'.$b['luastanah'].'</td>';
            }elseif($i==17){
                $table .= '<td>'.$b['luasbangunan'].'</td>';
            }elseif($i==18){
                $table .= '<td></td>';
            }elseif($i==19){
                $table .= '<td>'.$b['nomor_suratizin'].'</td>';
            }elseif($i==20){
                $table .= '<td>'.$b['tgl_suratizin'].'</td>';
            }elseif($i==21){
                $table .= '<td>'.$b['oleh_suratizin'].'</td>';
            }elseif($i==22){
                $table .= '<td>'.$b['sifat_suratizin'].'</td>';
            }elseif($i==23){
                $table .= '<td>'.$b['masaberlakutahun_suratizin'].'</td>';
            }elseif($i==24){
                $table .= '<td>'.$b['statusrsswasta'].'</td>';
            }elseif($i==25){
                $table .= '<td>'.$b['akreditasirs'].'</td>';
            }elseif($i==26){
                $table .= '<td>'.$b['pentahapanakreditasrs'].'</td>';
            }elseif($i==27){
                $table .= '<td>'.$b['statusakreditasrs'].'</td>';
            }elseif($i==28){
                $table .= '<td>'.$b['tglakreditasi'].'</td>';
            }elseif($i==29){
                $table .= '<td></td>';
            }elseif($i==30){//kelas awal
                $table .= '<td>'.$this->getSumRuangan('Pernitalogi').'</td>';
            }elseif($i==31){
                $table .= '<td>'.$this->getSumRuangan('Kelas VVIP').'</td>';
            }elseif($i==32){
                $table .= '<td>'.$this->getSumRuangan('Kelas VIP').'</td>';
            }elseif($i==33){
                $table .= '<td>'.$this->getSumRuangan('Kelas I').'</td>';
            }elseif($i==34){
                $table .= '<td>'.$this->getSumRuangan('Kelas II').'</td>';
            }elseif($i==35){
                $table .= '<td>'.$this->getSumRuangan('Kelas III').'</td>';
            }elseif($i==36){
                $table .= '<td>'.$this->getSumRuangan('ICU').'</td>';
            }//kelas akhir
            
//        foreach ($records2 as $c) {
//                // $rows2[] = array(
//                //     $c['kelaspelayanan_nama'], $c['kelaspelayanan_id']
//                // );
//                $kelas = $c['kelaspelayanan_id'];
//                $nama = $c['kelaspelayanan_nama'][$kelas];
//
//                if($i==30 && $c['Vip B']){
//                $table .= '<td>'.$c['jlmbed'].'</td>';
//                }elseif($i==31 && $c['Vip B']){
//                $table .= '<td>'.$c['jlmbed'].'</td>';
//                }elseif($i==32  && $c['Vip B']){
//                    $table .= '<td>'.$c['jlmbed'].'</td>';
//                }elseif($i==33  && $c['Vip B']){
//                    $table .= '<td>'.$c['jlmbed'].'</td>';
//                }elseif($i==34  && $c['Vip B']){
//                    $table .= '<td>'.$c['jlmbed'].'</td>';
//                }elseif($i==35  && $c['Vip B']){
//                    $table .= '<td>'.$c['jlmbed'].'</td>';
//                }
//           }
            if($i==37){
                $table .= '<td>'.$this->getSumRuangan('PICU').'</td>';
            }elseif($i==38){
                $table .= '<td>'.$this->getSumRuangan('NICU').'</td>';
            }elseif($i==39){
                $table .= '<td>'.$this->getSumRuangan('ICCU').'</td>';
            }elseif($i==40){
                $table .= '<td>'.$this->getSumRuangan('HCU').'</td>';
            }elseif($i==41){
                $table .= '<td>'.$this->getSumRuangan('Ruang Isolasi').'</td>';
            }elseif($i==42){
                $table .= '<td>'.$this->getSumRuangan('Ruang UGD').'</td>';
            }elseif($i==43){
                $table .= '<td>'.$this->getSumRuangan('Ruang Bersalin').'</td>';
            }elseif($i==44){
                $table .= '<td>'.$this->getSumRuangan('Ruang Operasi').'</td>';
            }elseif($i==45){
                $table .= '<td></td>';
            }elseif($i==46){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Sp.A').'</td>';
            }elseif($i==47){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Sp.OG').'</td>';
            }elseif($i==48){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Sp.OG').'</td>';
            }elseif($i==49){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Sp.Pd').'</td>';
            }elseif($i==50){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Sp.B').'</td>';
            }elseif($i==51){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Sp.Rad').'</td>';
            }elseif($i==52){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Sp.RK').'</td>';
            }elseif($i==53){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Sp.An').'</td>';
            }elseif($i==54){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Sp.Jp').'</td>';
            }elseif($i==55){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Sp.M').'</td>';
            }elseif($i==56){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Sp.THT').'</td>';
            }elseif($i==57){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Sp.Kj').'</td>';
            }elseif($i==58){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Sp.PK').'</td>';
            }elseif($i==59){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Sub Spesialis').'</td>';
            }elseif($i==60){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Spesialis Lain').'</td>';
            }elseif($i==61){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Umum').'</td>';
            }elseif($i==62){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Gigi').'</td>';
            }elseif($i==63){
                $table .= '<td>'.$this->countMedisByGelar('Dokter Gigi Spesialis').'</td>';
            }elseif($i==64){
                $table .= '<td>'.$this->countMedisByGelar('Perawat').'</td>';
            }elseif($i==65){
                $table .= '<td>'.$this->countMedisByGelar('Bidan').'</td>';
            }elseif($i==66){
                $table .= '<td>'.$this->countMedisByGelar('Farmasi').'</td>';
            }elseif($i==67){
                $table .= '<td>'.$this->countMedisByGelar('Tenaga Kesehatan Lainnya').'</td>';
            }elseif($i==68){
                $table .= '<td>'.$this->countNonMedis().'</td>';
            }
            $table .= '</tr>';
            // $table .= '<td>'.$rows[$i].'<td></tr>';
            //  foreach($rows as $hsl)
            // {
                // $table .= '<td>'.count((array)$rows).'<td></tr>';
            // }
            
        }

       

        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
            );
            $title = "DATA DASAR RUMAH SAKIT";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'1000',
                        'formulir'=>'Formulir RL 1.1',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){ 
            $this->layout = '//layouts/iframe';
            $this->render('print_laporan',
                array(
                    'width'=>'1000',
                    'formulir'=>'Formulir RL 1.1',
                    'title'=>'DATA DASAR RUMAH SAKIT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );                
        }elseif($_GET['caraPrint'] == 'Dialog'){ 
            $this->layout = '//layouts/iframe';
            $this->render('print_laporan',
                array(
                    'width'=>'1000',
                     'formulir'=>'Formulir RL 1.1',
                    'title'=>'DATA DASAR RUMAH SAKIT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );                
        }else{
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'1000',
                    'formulir'=>'Formulir RL 1.1',
                    'title'=>'DATA DASAR RUMAH SAKIT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }        
    }

    /**
     * fungsi untuk menampilkan halaman tempat tidur ri
     */

     protected function getSumRuangan($ruangan){
         $cr = new CDbCriteria();
         $cr->compare('ruangan_nama ',$ruangan);
         $cr->select = 'SUM(kamarruangan_jmlbed) as totalbed';
         $res =  InformasikamarinapV::model()->find($cr);
         return $res->totalbed > 0 ? number_format($res->totalbed) : 0;
    }

    protected function countNonMedis(){
        $cr = new CDbCriteria();
        // $cr->compare('ruangan_nama ',$ruangan);
        $cr->addCondition('kelompokpegawai_id <> 1');
        $cr->select = 'COUNT(pegawai_id) as totalpeg';
        $res =  PegawaiM::model()->find($cr);
        return $res->totalpeg > 0 ? number_format($res->totalpeg) : 0;
    }
    protected function countMedisByGelar($gelar){
        $cr = new CDbCriteria();
        // $cr->compare('ruangan_nama ',$ruangan);
        $cr->addCondition('t.kelompokpegawai_id = 1');
        $cr->compare('jenistenagamedis_m.tenagamedis_nama', $gelar);
        $cr->join = 'JOIN jenistenagamedis_m ON t.jenistenagamedis_id = jenistenagamedis_m.jenistenagamedis_id';
        $cr->select = 'COUNT(t.pegawai_id) as totalpeg';
        $res =  PegawaiM::model()->find($cr);
        return $res->totalpeg > 0 ? number_format($res->totalpeg) : 0;
    }

     public function actionTempatTidurRI()
    {
        $model = new RKrl13FastempattidurV;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
       
        // $sql = "
        //     SELECT jeniskasuspenyakit_id, jeniskasuspenyakit_nama, sum(jlmtt) as jlmtt FROM rl1_3_fastempattidur_v WHERE instalasi_id = ".PARAMS::INSTALASI_ID_RI." group by jeniskasuspenyakit_id, jeniskasuspenyakit_nama
        //     order by jeniskasuspenyakit_id asc";


        // $sqljmltt = "
        //     SELECT jeniskasuspenyakit_nama FROM rl1_3_fastempattidur_v WHERE instalasi_id = ".PARAMS::INSTALASI_ID_RI." group by jeniskasuspenyakit_nama";
        // $records = YII::app()->db->createCommand($sql)->queryAll();
        
        $criteria=new CDbCriteria;
        $criteria->select = 'jeniskasuspenyakit_id, jeniskasuspenyakit_nama, sum(jlmtt) as jlmtt';
        $criteria->addCondition('instalasi_id = '.PARAMS::INSTALASI_ID_RI);
        $criteria->group = 'jeniskasuspenyakit_id, jeniskasuspenyakit_nama';
        $criteria->order = 'jeniskasuspenyakit_id asc';        
        
        $records = RKrl13FastempattidurV::model()->findAll($criteria);
		$modKelas = RKKelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE");
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" rowspan="2" style="text-align:center;">NO</th>', 
            '<th rowspan="2" style="text-align:center;">JENIS PELAYANAN</th>', 
            '<th rowspan="2"  style="text-align:center;">JUMLAH TT</th>',
            '<th colspan="'.(count((array)$modKelas)).'" style="text-align:center;">PERINCIAN TEMPAT TIDUR PER KELAS</th>',
        );
		$tdCount = array(
            '<td style="text-align:center;background-color:#AFAFAF">1</td>',
            '<td style="text-align:center;background-color:#AFAFAF">2</td>',
            '<td style="text-align:center;background-color:#AFAFAF">3</td>',
            
        );
		$header2 = array();
		$tdCount2 = array();
		$kolomke = 4; //1 s.d 3 statik
		if(count((array)$modKelas) > 0){
			foreach($modKelas AS $i => $kelas){
				$header2 = array_merge($header2,array('<th style="text-align:center;">'.strtoupper($kelas->kelaspelayanan_nama).'</th>'));
				$tdCount = array_merge($tdCount,array('<td style="text-align:center;background-color:#AFAFAF">'.$kolomke.'</td>'));
				$kolomke ++;
			}
		}
		
        $rows = array();
        $i=0;
        $total_jumlah = 0;
        foreach($records as $i => $row)
        {
            
            $rows[$i] = array(
                '<td style="text-align:center;">'. ($i+1).'</td>',
                '<td>'.$row['jeniskasuspenyakit_nama'].'</td>',
                '<td style="text-align:right;">'.number_format($row['jlmtt'],0,"",".").'</td>',
            );
			if(count((array)$modKelas) > 0){
				foreach($modKelas AS $ii => $kelas){
					$rows[$i] = array_merge($rows[$i], array('<td style="text-align:right;">'.number_format($row->getSumPelayanan($row['jeniskasuspenyakit_id'],$kelas->kelaspelayanan_id, PARAMS::INSTALASI_ID_RI),0,"",".").'</td>'));
				}
			}
            $total_jumlah += $row['jlmtt'];
        }
        
        $table = '<table cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>'.'<tr>'.implode("", $header2).'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        $table .= '<tr>';
        $table .= implode("", $tdCount).'</tr>';
        foreach($rows as $xxx)
        {
            $table .= '<tr>'. implode('', $xxx) . '</tr>';
        }
        $table .= '<tr><td></td><td></td><td style="text-align:right;"><b>Total</b></td>';
		if(count((array)$modKelas) > 0){
			foreach($modKelas AS $ii => $kelas){
				$table .= '<td style="text-align:right;">'. number_format($model->getSumTotal($kelas->kelaspelayanan_id, PARAMS::INSTALASI_ID_RI),0,"",".") .'</td>';
			}
		}
        $table .= '</tr></tbody>';
        $table .= '</table>';        
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
            );
            $title = "FASILITAS TEMPAT TIDUR RAWAT INAP";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 1.3',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
                $this->layout = '//layouts/iframe';
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 1.3',
                    'title'=>'FASILITAS TEMPAT TIDUR RAWAT INAP',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );              
        }else{
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 1.3',
                    'title'=>'FASILITAS TEMPAT TIDUR RAWAT INAP',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }

    }
     /**
     * fungsi untuk menampilkan halaman tempat tidur ri
     */
    public function actionPrintTempatTidurRI()
    {
        $model = new RKrl13FastempattidurV;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
       
        // $sql = "
        //     SELECT jeniskasuspenyakit_id, jeniskasuspenyakit_nama, sum(jlmtt) as jlmtt FROM rl1_3_fastempattidur_v WHERE instalasi_id = ".PARAMS::INSTALASI_ID_RI." group by jeniskasuspenyakit_id, jeniskasuspenyakit_nama
        //     order by jeniskasuspenyakit_id asc";


        // $sqljmltt = "
        //     SELECT jeniskasuspenyakit_nama FROM rl1_3_fastempattidur_v WHERE instalasi_id = ".PARAMS::INSTALASI_ID_RI." group by jeniskasuspenyakit_nama";
        // $records = YII::app()->db->createCommand($sql)->queryAll();
        
        $criteria=new CDbCriteria;
        $criteria->select = 'jeniskasuspenyakit_id, jeniskasuspenyakit_nama, sum(jlmtt) as jlmtt';
        $criteria->addCondition('instalasi_id = '.PARAMS::INSTALASI_ID_RI);
        $criteria->group = 'jeniskasuspenyakit_id, jeniskasuspenyakit_nama';
        $criteria->order = 'jeniskasuspenyakit_id asc';        
        
        $records = RKrl13FastempattidurV::model()->findAll($criteria);
		$modKelas = RKKelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE");
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" style="text-align:center;">NO</th>', 
            '<th style="text-align:center;">KODE RS</th>', 
            '<th style="text-align:center;">KODE PROPINSI</th>', 
            '<th style="text-align:center;">KAB/KOTA</th>', 
            '<th style="text-align:center;">TAHUN</th>', 
            '<th style="text-align:center;">JENIS PELAYANAN</th>', 
            '<th style="text-align:center;">JUMLAH TT</th>',
        );
		$tdCount = array(
            '<td style="text-align:center;background-color:#AFAFAF">1</td>',
            '<td style="text-align:center;background-color:#AFAFAF">2</td>',
            '<td style="text-align:center;background-color:#AFAFAF">3</td>',
            
        );
		$header2 = array();
		$tdCount2 = array();
		$kolomke = 4; //1 s.d 3 statik
		if(count((array)$modKelas) > 0){
			foreach($modKelas AS $i => $kelas){
				$header2 = array_merge($header2,array('<th style="text-align:center;">'.strtoupper($kelas->kelaspelayanan_nama).'</th>'));
				$tdCount = array_merge($tdCount,array('<td style="text-align:center;background-color:#AFAFAF">'.$kolomke.'</td>'));
				$kolomke ++;
			}
		}
		
        $rows = array();
        $i=0;
        $total_jumlah = 0;
        foreach($records as $i => $row)
        {
            
            $rows[$i] = array(
                '<td style="text-align:center;">'. ($i+1).'</td>',
                 '<td></td>',
                 '<td></td>',
                 '<td></td>',
                 '<td></td>',
                '<td>'.$row['jeniskasuspenyakit_nama'].'</td>',
                '<td style="text-align:right;">'.number_format($row['jlmtt'],0,"",".").'</td>',
            );
			if(count((array)$modKelas) > 0){
				foreach($modKelas AS $ii => $kelas){
					$rows[$i] = array_merge($rows[$i], array('<td style="text-align:right;">'.number_format($row->getSumPelayanan($row['jeniskasuspenyakit_id'],$kelas->kelaspelayanan_id, PARAMS::INSTALASI_ID_RI),0,"",".").'</td>'));
				}
			}
            $total_jumlah += $row['jlmtt'];
        }
        
        $table = '<table cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header).implode("", $header2).'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
       
        foreach($rows as $xxx)
        {
            $table .= '<tr>'. implode('', $xxx) . '</tr>';
        }
		if(count((array)$modKelas) > 0){
			foreach($modKelas AS $ii => $kelas){
				$table .= '<td style="text-align:right;">'. number_format($model->getSumTotal($kelas->kelaspelayanan_id, PARAMS::INSTALASI_ID_RI),0,"",".") .'</td>';
			}
		}
        $table .= '</tr></tbody>';
        $table .= '</table>';        
        
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporanGigimulut',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 1.3',
                    'title'=>'FASILITAS TEMPAT TIDUR RAWAT INAP',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            

    }
    /**
     * fungsi untuk menampilkan halaman kegiatan pembedahan
     */
    public function actionKegiatanPembedahan()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;

        $criteria = new CDbCriteria();
        $criteria->select = 'propinsi,
                           
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskasuspenyakit_nama,
                            SUM (khusus) AS khusus,
                            SUM (besar) AS besar,
                            SUM (sedang) AS sedang,
                            SUM (kecil) AS kecil,
                            SUM (khusus) + SUM (besar) + SUM (sedang) + SUM (kecil) AS total';
        $criteria->group = 'propinsi,
                           
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskasuspenyakit_nama';
        $criteria->order = 'jeniskasuspenyakit_nama';
        $criteria->addBetweenCondition('DATE(tgl_laporan)',$tgl_awal,$tgl_akhir);
        $recordsGroup = RKRl36KegiatanpembedahanV::model()->findAll($criteria);
        
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        
        $header = array(
            '<th width="50" style="text-align:center;">NO</th>', 
            '<th style="text-align:center;">SPESIALISASI</th>', 
            '<th style="text-align:center;">TOTAL</th>',
            '<th style="text-align:center;">KHUSUS</th>',
            '<th style="text-align:center;">BESAR</th>',
            '<th style="text-align:center;">SEDANG</th>',
            '<th style="text-align:center;">KECIL</th>',
        );
        
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">7</td>',
        );

        $rows = array();
        $judul = array();
        $i=0;
        $total= 0;
        $total_khusus= 0;
        $total_besar= 0;
        $total_sedang= 0;
        $total_kecil= 0;
        $dataGroup = array();

        
        foreach($recordsGroup as $m=>$value)
        {
            $kegiatanoperasi = $value->jeniskasuspenyakit_nama;
            $dataGroup[$kegiatanoperasi]['jeniskasuspenyakit_nama'] = $value->jeniskasuspenyakit_nama;
            $dataGroup[$kegiatanoperasi]['khusus'] = $value->khusus;                    
            $dataGroup[$kegiatanoperasi]['besar'] = $value->besar;                    
            $dataGroup[$kegiatanoperasi]['sedang'] = $value->sedang;  
            $dataGroup[$kegiatanoperasi]['kecil'] = $value->kecil;                    
            $dataGroup[$kegiatanoperasi]['total'] = $value->total;                    
        }
        
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
            $a = 0;
            
            if (count((array)$dataGroup) > 0):
                foreach($dataGroup as $key=>$val){
                         $table .= '<tr>';
                         $table .= '<td style=text-align:center;>'. ($a+1).'</td>
                             <td>'.$val['jeniskasuspenyakit_nama'].'</td>
                             <td style=text-align:center;>'.number_format($val['total'],0,"",".").'</td>
                             <td style=text-align:center;>'.number_format($val['khusus'],0,"",".").'</td>
                             <td style=text-align:center;>'.number_format($val['besar'],0,"",".").'</td>
                             <td style=text-align:center;>'.number_format($val['sedang'],0,"",".").'</td>
                             <td style=text-align:center;>'.number_format($val['kecil'],0,"",".").'</td></tr>';
                         $a++;
                         $total += $val['total'];
                         $total_khusus += $val['khusus'];
                         $total_besar += $val['besar'];
                         $total_sedang += $val['sedang'];
                         $total_kecil += $val['kecil'];

                 }
            else:
                $table .= '<tr>';
                $table .= '<td colspan=10><i>Data tidak ditemukan.</i></td>';
                $table .= '</tr>';
            endif;
                 
        $table .= '<tr><td></td><td style="text-align:right;"><b>Total</b></td><td style=text-align:center;>'.number_format($total,0,"",".") .'</td><td style=text-align:center;>'.$total_khusus .'</td><td style=text-align:center;>'.number_format($total_besar,0,"",".") .'</td><td style=text-align:center;>'.number_format($total_sedang,0,"",".") .'</td><td style=text-align:center;>'.number_format($total_kecil,0,"",".") .'</td><tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
            );
            $title = "KEGIATAN PEMBEDAHAN";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 3.6',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
             $this->layout = '//layouts/iframe';
             $colspan = null;
             $colspan1 = null;
             $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.6',
                    'title'=>'KEGIATAN PEMBEDAHAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }else{
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 2;
                $colspan1 = 0;
                $this->layout = '//layouts/printExcel';
            }
            
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.6',
                    'title'=>'KEGIATAN PEMBEDAHAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }

    }
     /**
     * fungsi untuk menampilkan halaman kegiatan pembedahan
     */
     public function actionPrintKegiatanPembedahan()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;

        $criteria = new CDbCriteria();
        $criteria->select = "
                            date_part('year',tgl_laporan) as tahun,
                            propinsi,
                            koders,
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskasuspenyakit_nama,
                            SUM (khusus) AS khusus,
                            SUM (besar) AS besar,
                            SUM (sedang) AS sedang,
                            SUM (kecil) AS kecil,
                            SUM (khusus) + SUM (besar) + SUM (sedang) + SUM (kecil) AS total";
        $criteria->group = "date_part('year',tgl_laporan),
                            propinsi,
                            koders,
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskasuspenyakit_nama";
        $criteria->order = 'jeniskasuspenyakit_nama';
        $criteria->addBetweenCondition('DATE(tgl_laporan)',$tgl_awal,$tgl_akhir);
        $recordsGroup = RKRl36KegiatanpembedahanV::model()->findAll($criteria);

        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        
        $header = array(
             '<th style="text-align:center;">KODE PROPINSI</th>', 
             '<th style="text-align:center;">KAB/KOTA</th>', 
             '<th style="text-align:center;">KODE RS</th>', 
             '<th style="text-align:center;">NAMA RS</th>', 
             '<th style="text-align:center;">TAHUN</th>', 
            '<th width="50" style="text-align:center;">NO</th>', 
            '<th style="text-align:center;">SPESIALISASI</th>', 
            '<th style="text-align:center;">TOTAL</th>',
            '<th style="text-align:center;">KHUSUS</th>',
            '<th style="text-align:center;">BESAR</th>',
            '<th style="text-align:center;">SEDANG</th>',
            '<th style="text-align:center;">KECIL</th>',
        );
        
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">7</td>',
        );

        $rows = array();
        $judul = array();
        $i=0;
        $total= 0;
        $total_khusus= 0;
        $total_besar= 0;
        $total_sedang= 0;
        $total_kecil= 0;
        $dataGroup = array();

        
        foreach($recordsGroup as $m=>$value)
        {
            $kegiatanoperasi = $value->jeniskasuspenyakit_nama;
            $dataGroup[$kegiatanoperasi]['jeniskasuspenyakit_nama'] = $value->jeniskasuspenyakit_nama;
            $dataGroup[$kegiatanoperasi]['khusus'] = $value->khusus;                    
            $dataGroup[$kegiatanoperasi]['besar'] = $value->besar;                    
            $dataGroup[$kegiatanoperasi]['sedang'] = $value->sedang;  
            $dataGroup[$kegiatanoperasi]['kecil'] = $value->kecil;                    
            $dataGroup[$kegiatanoperasi]['total'] = $value->total;                    
        }
        
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
            $a = 0;
            
            if (count((array)$dataGroup) > 0):
                foreach($dataGroup as $key=>$val){
                         $table .= '<tr>';
                         $table .=      
                             '
                             <td>'.$val['propinsi'].'</td>
                             <td>'.$val['kabupaten'].'</td>
                             <td>'.$val['koders'].'</td>
                             <td>'.$val['namars'].'</td>
                             <td>'.$val['tahun'].'</td>
                             <td style=text-align:center;>'. ($a+1).'</td>
                             <td>'.$val['jeniskasuspenyakit_nama'].'</td>
                             <td style=text-align:center;>'.number_format($val['total'],0,"",".").'</td>
                             <td style=text-align:center;>'.number_format($val['khusus'],0,"",".").'</td>
                             <td style=text-align:center;>'.number_format($val['besar'],0,"",".").'</td>
                             <td style=text-align:center;>'.number_format($val['sedang'],0,"",".").'</td>
                             <td style=text-align:center;>'.number_format($val['kecil'],0,"",".").'</td></tr>';
                         $a++;
                         $total += $val['total'];
                         $total_khusus += $val['khusus'];
                         $total_besar += $val['besar'];
                         $total_sedang += $val['sedang'];
                         $total_kecil += $val['kecil'];

                 }
            else:
                $table .= '<tr>';
                $table .= '<td colspan=10><i>Data tidak ditemukan.</i></td>';
                $table .= '</tr>';
            endif;
                 
        $table .= '</tbody>';
        $table .= '</table>';
        
       
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 2;
                $colspan1 = 0;
                $this->layout = '//layouts/printExcel';
            }
            
            $this->render('print_laporancarabayar',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.6',
                    'title'=>'KEGIATAN PEMBEDAHAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
    }
        
	/**
     * Formulir RL 4.A MORBIDITAS PASIEN RAWAT INAP RUMAH SAKIT
     */	
    public function actionMorbiditasRawatInap()
    {
        $model = new RKRl4aMobiditaspasienriV();
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        
        $criteria =  new CDbCriteria();
        $criteria->group = 'profilrs_id,propinsi,kabupaten, namars,dtd_kode,dtd_noterperinci,golongansebabpenyakit';
        $criteria->select = $criteria->group.', SUM ("var_0hr_6hr_l") AS "var_0hr_6hr_l",
						SUM ("var_0hr_6hr_p") AS "var_0hr_6hr_p",
						SUM ("var_6hr_28hr_l") AS "var_6hr_28hr_l",
						SUM ("var_6hr_28hr_p") AS "var_6hr_28hr_p",
						SUM ("var_28hr_1th_l") AS "var_28hr_1th_l",
						SUM ("var_28hr_1th_p") AS "var_28hr_1th_p",
						SUM ("var_1th_4th_l") AS "var_1th_4th_l",
						SUM ("var_1th_4th_p") AS "var_1th_4th_p",
						SUM ("var_4th_14th_l") AS "var_4th_14th_l",
						SUM ("var_4th_14th_p") AS "var_4th_14th_p",
						SUM ("var_14th_24th_l") AS "var_14th_24th_l",
						SUM ("var_14th_24th_p") AS "var_14th_24th_p",
						SUM ("var_24th_44th_l") AS "var_24th_44th_l",
						SUM ("var_24th_44th_p") AS "var_24th_44th_p",
						SUM ("var_44th_64th_l") AS "var_44th_64th_l",
						SUM ("var_44th_64th_p") AS "var_44th_64th_p",
						SUM ("var_64th_keatas_l") AS "var_64th_keatas_l",
						SUM ("var_64th_keatas_p") AS "var_64th_keatas_p",
						SUM (pasienkeluarlakilaki) AS pasienkeluarlakilaki,
						SUM (pasienkeluarperempuan) AS pasienkeluarperempuan,
						SUM (pasienkeluarhidup) AS pasienkeluarhidup,
						SUM (pasienkeluarmati) AS pasienkeluarmati';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl4aMobiditaspasienriV::model()->findAll($criteria);
        
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" rowspan="3" style="text-align:center;vertical-align:middle;">No. Urut</th>', 
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">No. DTD</th>', 
            '<th rowspan="3"  style="text-align:center;vertical-align:middle;">No. Daftar Terperinci</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Golongan Sebab Penyakit</th>',
            '<th colspan="18" style="text-align:center;vertical-align:middle;">Jumlah Pasien Hidup dan Mati menurut Golongan Umur & Jenis Kelamin</th>',
            '<th colspan="2" style="text-align:center;vertical-align:middle;">Pasien Keluar (Hidup & Mati) Menurut Jenis Kelamin</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Jumlah Pasien Keluar Hidup (23+24)</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Jumlah Pasien Keluar Mati</th>',
        );
        $header2 = array(
            '<th colspan="2" style="text-align:center;">0-6hr</th>', 
            '<th colspan="2" style="text-align:center;">6-28hr</th>', 
            '<th colspan="2" style="text-align:center;">28hr-1th</th>', 
            '<th colspan="2" style="text-align:center;">1-4th</th>', 
            '<th colspan="2" style="text-align:center;">4-14th</th>', 
            '<th colspan="2" style="text-align:center;">14-24th</th>', 
            '<th colspan="2" style="text-align:center;">24-44th</th>', 
            '<th colspan="2" style="text-align:center;">44-64th</th>', 
            '<th colspan="2" style="text-align:center;">>64</th>', 
            '<th rowspan="2" style="text-align:center;">LK</th>', 
            '<th rowspan="2" style="text-align:center;">PR</th>',
        );
        $header3 = array(
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>',              
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor = "#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">7</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">8</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">9</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">10</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">11</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">12</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">13</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">14</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">15</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">16</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">17</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">18</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">19</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">20</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">21</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">22</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">23</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">24</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">25</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">26</td>',
        );

        $i=0;
        $datas = array();
		$total_0hr_l = 0;
		$total_0hr_p = 0;
		$total_6hr_l = 0;
		$total_6hr_p = 0;
		$total_28hr_l = 0;
		$total_28hr_p = 0;
		$total_1th_l = 0;
		$total_1th_p = 0;
		$total_4th_l = 0;
		$total_4th_p = 0;
		$total_14th_l = 0;
		$total_14th_p = 0;
		$total_24th_l = 0;
		$total_24th_p = 0;
		$total_44th_l = 0;
		$total_44th_p = 0;
		$total_64th_l = 0;
		$total_64th_p = 0;
		$total_pasienkeluarlakilaki = 0;
		$total_pasienkeluarperempuan = 0;
		$total_pasienkeluarhidup = 0;
		$total_pasienkeluarmati = 0;
		
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>'.'<tr>'. implode("", $header2) .'</tr>'.'<tr>'. implode("", $header3) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        
            $a = 0;
        if (count((array)$records) > 0):
            foreach($records as $key=>$val){               
                $table .= '<tr>';
                $table .= '<td style=text-align:center;>'. ($key+1).'</td>
                    <td>'.$val['dtd_kode'].'</td>
                    <td>'.$val['dtd_noterperinci'].'</td>
                    <td>'.$val['golongansebabpenyakit'].'</td>
                    <td style=text-align:center;>'.number_format($val['var_0hr_6hr_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_0hr_6hr_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_6hr_28hr_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_6hr_28hr_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_28hr_1th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_28hr_1th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_1th_4th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_1th_4th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_4th_14th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_4th_14th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_14th_24th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_14th_24th_p'],0,"",".").'</td>  
                    <td style=text-align:center;>'.number_format($val['var_24th_44th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_24th_44th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_44th_64th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_44th_64th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_64th_keatas_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_64th_keatas_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['pasienkeluarlakilaki'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['pasienkeluarperempuan'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['pasienkeluarhidup'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['pasienkeluarmati'],0,"",".").'</td></tr>';
                
				$total_0hr_l += $val['var_0hr_6hr_l'];
				$total_0hr_p += $val['var_0hr_6hr_p'];
				$total_6hr_l += $val['var_6hr_28hr_l'];
				$total_6hr_p += $val['var_6hr_28hr_p'];
				$total_28hr_l += $val['var_28hr_1th_l'];
				$total_28hr_p += $val['var_28hr_1th_p'];
				$total_1th_l += $val['var_1th_4th_l'];
				$total_1th_p += $val['var_1th_4th_p'];
				$total_4th_l += $val['var_4th_14th_l'];
				$total_4th_p += $val['var_4th_14th_p'];
				$total_14th_l += $val['var_14th_24th_l'];
				$total_14th_p += $val['var_14th_24th_p'];
				$total_24th_l += $val['var_24th_44th_l'];
				$total_24th_p += $val['var_24th_44th_p'];
				$total_44th_l += $val['var_44th_64th_l'];
				$total_44th_p += $val['var_44th_64th_p'];
				$total_64th_l += $val['var_64th_keatas_l'];
				$total_64th_p += $val['var_64th_keatas_p'];
				$total_pasienkeluarlakilaki += $val['pasienkeluarlakilaki'];
				$total_pasienkeluarperempuan += $val['pasienkeluarperempuan'];
				$total_pasienkeluarhidup += $val['pasienkeluarhidup'];
				$total_pasienkeluarmati += $val['pasienkeluarmati'];

            } 
        else:
            $table .= '<tr>';
            $table .= '<td colspan="26"><i>Data Tidak Ditemukan</i></td>';
            $table .= '</tr>';
        endif;  
        
            $table .= '<tr><td></td><td></td><td></td><td align="right"><b>Total</b></td>
                        <td style=text-align:center;>'.number_format($total_0hr_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_0hr_p,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_6hr_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_6hr_p,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_28hr_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_28hr_p,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_1th_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_1th_p,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_4th_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_4th_p,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_14th_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_14th_p,0,"",".").'</td>  
                        <td style=text-align:center;>'.number_format($total_24th_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_24th_p,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_44th_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_44th_p,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_64th_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_64th_p,0,"",".").'</td>'
                    . '<td style=text-align:center;>'.number_format($total_pasienkeluarlakilaki,0,"",".").'</td>'
                    . '<td style=text-align:center;>'.number_format($total_pasienkeluarperempuan,0,"",".").'</td>'
                    . '<td style=text-align:center;>'.number_format($total_pasienkeluarhidup,0,"",".").'</td>'
                    . '<td style=text-align:center;>'.number_format($total_pasienkeluarmati,0,"",".").'</td><tr>';
            $table .= '</tbody>';
            $table .= '</table>';
            
           
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
            );
            $title = "DATA KEADAAN MORBIDITAS PASIEN RAWAT INAP RUMAH SAKIT";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'1024',
                        'formulir'=>'Formulir RL 4.A',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
            $this->layout = '//layouts/iframe';
            $colspan = null;
            $colspan1 = null;
            $this->render('print_laporan',
                array(
                    'width'=>'1024',
                    'formulir'=>'Formulir RL 4.A',
                    'title'=>'DATA KEADAAN MORBIDITAS PASIEN RAWAT INAP RUMAH SAKIT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );               
        }else{
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 20;
                $colspan1 = 12;
                $this->layout = '//layouts/printExcel';
            }
            
            $this->render('print_laporan',
                array(
                    'width'=>'1024',
                    'formulir'=>'Formulir RL 4.A',
                    'title'=>'DATA KEADAAN MORBIDITAS PASIEN RAWAT INAP RUMAH SAKIT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }

    }
    
    /**
     * Formulir RL 4.A MORBIDITAS PASIEN RAWAT INAP RUMAH SAKIT
     * PENYEBAB KECELAKAAN
     */	
    public function actionMorbiditasRawatInapKecelakaan()
    {
        $model = new RKRl4aMobiditaspasienriV();
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        
        $criteria =  new CDbCriteria();
        $criteria->group = 'profilrs_id,propinsi,kabupaten, namars,dtd_kode,dtd_noterperinci,golongansebabpenyakit';
        $criteria->select = $criteria->group.', SUM ("var_0hr_6hr_l") AS "var_0hr_6hr_l",
						SUM ("var_0hr_6hr_p") AS "var_0hr_6hr_p",
						SUM ("var_6hr_28hr_l") AS "var_6hr_28hr_l",
						SUM ("var_6hr_28hr_p") AS "var_6hr_28hr_p",
						SUM ("var_28hr_1th_l") AS "var_28hr_1th_l",
						SUM ("var_28hr_1th_p") AS "var_28hr_1th_p",
						SUM ("var_1th_4th_l") AS "var_1th_4th_l",
						SUM ("var_1th_4th_p") AS "var_1th_4th_p",
						SUM ("var_4th_14th_l") AS "var_4th_14th_l",
						SUM ("var_4th_14th_p") AS "var_4th_14th_p",
						SUM ("var_14th_24th_l") AS "var_14th_24th_l",
						SUM ("var_14th_24th_p") AS "var_14th_24th_p",
						SUM ("var_24th_44th_l") AS "var_24th_44th_l",
						SUM ("var_24th_44th_p") AS "var_24th_44th_p",
						SUM ("var_44th_64th_l") AS "var_44th_64th_l",
						SUM ("var_44th_64th_p") AS "var_44th_64th_p",
						SUM ("var_64th_keatas_l") AS "var_64th_keatas_l",
						SUM ("var_64th_keatas_p") AS "var_64th_keatas_p",
						SUM (pasienkeluarlakilaki) AS pasienkeluarlakilaki,
						SUM (pasienkeluarperempuan) AS pasienkeluarperempuan,
						SUM (pasienkeluarhidup) AS pasienkeluarhidup,
						SUM (pasienkeluarmati) AS pasienkeluarmati';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl4aMobiditaspasienriV::model()->findAll($criteria);
        
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" rowspan="3" style="text-align:center;vertical-align:middle;">No. Urut</th>', 
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">No. DTD</th>', 
            '<th rowspan="3"  style="text-align:center;vertical-align:middle;">No. Daftar Terperinci</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Golongan Sebab Penyakit</th>',
            '<th colspan="18" style="text-align:center;vertical-align:middle;">Jumlah Pasien Hidup dan Mati menurut Golongan Umur & Jenis Kelamin</th>',
            '<th colspan="2" style="text-align:center;vertical-align:middle;">Pasien Keluar (Hidup & Mati) Menurut Jenis Kelamin</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Jumlah Pasien Keluar Hidup (23+24)</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Jumlah Pasien Keluar Mati</th>',
        );
        $header2 = array(
            '<th colspan="2" style="text-align:center;">0-6hr</th>', 
            '<th colspan="2" style="text-align:center;">7-28hr</th>', 
            '<th colspan="2" style="text-align:center;">28hr-<1th</th>', 
            '<th colspan="2" style="text-align:center;">1-4th</th>', 
            '<th colspan="2" style="text-align:center;">5-14th</th>', 
            '<th colspan="2" style="text-align:center;">15-24th</th>', 
            '<th colspan="2" style="text-align:center;">25-44th</th>', 
            '<th colspan="2" style="text-align:center;">45-64th</th>', 
            '<th colspan="2" style="text-align:center;">>65</th>', 
            '<th rowspan="2" style="text-align:center;">LK</th>', 
            '<th rowspan="2" style="text-align:center;">PR</th>',
        );
        $header3 = array(
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>',              
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor = "#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">7</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">8</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">9</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">10</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">11</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">12</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">13</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">14</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">15</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">16</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">17</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">18</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">19</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">20</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">21</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">22</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">23</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">24</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">25</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">26</td>',
        );

        $i=0;
        $datas = array();
		$total_0hr_l = 0;
		$total_0hr_p = 0;
		$total_6hr_l = 0;
		$total_6hr_p = 0;
		$total_28hr_l = 0;
		$total_28hr_p = 0;
		$total_1th_l = 0;
		$total_1th_p = 0;
		$total_4th_l = 0;
		$total_4th_p = 0;
		$total_14th_l = 0;
		$total_14th_p = 0;
		$total_24th_l = 0;
		$total_24th_p = 0;
		$total_44th_l = 0;
		$total_44th_p = 0;
		$total_64th_l = 0;
		$total_64th_p = 0;
		$total_pasienkeluarlakilaki = 0;
		$total_pasienkeluarperempuan = 0;
		$total_pasienkeluarhidup = 0;
		$total_pasienkeluarmati = 0;
		
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>'.'<tr>'. implode("", $header2) .'</tr>'.'<tr>'. implode("", $header3) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        
            $a = 0;
        if (count((array)$records) > 0):
            foreach($records as $key=>$val){               
                $table .= '<tr>';
                $table .= '<td style=text-align:center;>'. ($key+1).'</td>
                    <td>'.$val['dtd_kode'].'</td>
                    <td>'.$val['dtd_noterperinci'].'</td>
                    <td>'.$val['golongansebabpenyakit'].'</td>
                    <td style=text-align:center;>'.number_format($val['var_0hr_6hr_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_0hr_6hr_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_6hr_28hr_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_6hr_28hr_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_28hr_1th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_28hr_1th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_1th_4th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_1th_4th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_4th_14th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_4th_14th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_14th_24th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_14th_24th_p'],0,"",".").'</td>  
                    <td style=text-align:center;>'.number_format($val['var_24th_44th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_24th_44th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_44th_64th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_44th_64th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_64th_keatas_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_64th_keatas_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['pasienkeluarlakilaki'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['pasienkeluarperempuan'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['pasienkeluarhidup'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['pasienkeluarmati'],0,"",".").'</td></tr>';
                
				$total_0hr_l += $val['var_0hr_6hr_l'];
				$total_0hr_p += $val['var_0hr_6hr_p'];
				$total_6hr_l += $val['var_6hr_28hr_l'];
				$total_6hr_p += $val['var_6hr_28hr_p'];
				$total_28hr_l += $val['var_28hr_1th_l'];
				$total_28hr_p += $val['var_28hr_1th_p'];
				$total_1th_l += $val['var_1th_4th_l'];
				$total_1th_p += $val['var_1th_4th_p'];
				$total_4th_l += $val['var_4th_14th_l'];
				$total_4th_p += $val['var_4th_14th_p'];
				$total_14th_l += $val['var_14th_24th_l'];
				$total_14th_p += $val['var_14th_24th_p'];
				$total_24th_l += $val['var_24th_44th_l'];
				$total_24th_p += $val['var_24th_44th_p'];
				$total_44th_l += $val['var_44th_64th_l'];
				$total_44th_p += $val['var_44th_64th_p'];
				$total_64th_l += $val['var_64th_keatas_l'];
				$total_64th_p += $val['var_64th_keatas_p'];
				$total_pasienkeluarlakilaki += $val['pasienkeluarlakilaki'];
				$total_pasienkeluarperempuan += $val['pasienkeluarperempuan'];
				$total_pasienkeluarhidup += $val['pasienkeluarhidup'];
				$total_pasienkeluarmati += $val['pasienkeluarmati'];

            } 
        else:
            $table .= '<tr>';
            $table .= '<td colspan="26"><i>Data Tidak Ditemukan</i></td>';
            $table .= '</tr>';
        endif;  
        
            $table .= '<tr><td></td><td></td><td></td><td align="right"><b>Total</b></td>
                        <td style=text-align:center;>'.number_format($total_0hr_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_0hr_p,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_6hr_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_6hr_p,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_28hr_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_28hr_p,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_1th_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_1th_p,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_4th_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_4th_p,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_14th_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_14th_p,0,"",".").'</td>  
                        <td style=text-align:center;>'.number_format($total_24th_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_24th_p,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_44th_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_44th_p,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_64th_l,0,"",".").'</td>
                        <td style=text-align:center;>'.number_format($total_64th_p,0,"",".").'</td>'
                    . '<td style=text-align:center;>'.number_format($total_pasienkeluarlakilaki,0,"",".").'</td>'
                    . '<td style=text-align:center;>'.number_format($total_pasienkeluarperempuan,0,"",".").'</td>'
                    . '<td style=text-align:center;>'.number_format($total_pasienkeluarhidup,0,"",".").'</td>'
                    . '<td style=text-align:center;>'.number_format($total_pasienkeluarmati,0,"",".").'</td><tr>';
            $table .= '</tbody>';
            $table .= '</table>';
            
           
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
            );
            $title = "DATA KEADAAN MORBIDITAS PASIEN RAWAT INAP RUMAH SAKIT <br>PENYEBAB KECELAKAAN";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'1024',
                        'formulir'=>'Formulir RL 4A',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
            $this->layout = '//layouts/iframe';
            $colspan = null;
            $colspan1 = null;
            $this->render('print_laporan',
                array(
                    'width'=>'1024',
                    'formulir'=>'Formulir RL 4A',
                    'title'=>'DATA KEADAAN MORBIDITAS PASIEN RAWAT INAP RUMAH SAKIT <br>PENYEBAB KECELAKAAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );               
        }else{
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 20;
                $colspan1 = 12;
                $this->layout = '//layouts/printExcel';
            }
            
            $this->render('print_laporan',
                array(
                    'width'=>'1024',
                    'formulir'=>'Formulir RL 4A',
                    'title'=>'DATA KEADAAN MORBIDITAS PASIEN RAWAT INAP RUMAH SAKIT <br>PENYEBAB KECELAKAAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }

    }
    
    /**
     * PRINT Formulir RL 4.A MORBIDITAS PASIEN RAWAT INAP RUMAH SAKIT
     */	
    public function actionPrintMorbiditasRawatInap()
    {
        $model = new RKRl4aMobiditaspasienriV();
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        
        $criteria =  new CDbCriteria();
        $criteria->group = 'koders, tgl_laporan,profilrs_id,propinsi,kabupaten, namars,dtd_kode,dtd_noterperinci,golongansebabpenyakit';
        $criteria->select = $criteria->group.', SUM ("var_0hr_6hr_l") AS "var_0hr_6hr_l",
						SUM ("var_0hr_6hr_p") AS "var_0hr_6hr_p",
						SUM ("var_6hr_28hr_l") AS "var_6hr_28hr_l",
						SUM ("var_6hr_28hr_p") AS "var_6hr_28hr_p",
						SUM ("var_28hr_1th_l") AS "var_28hr_1th_l",
						SUM ("var_28hr_1th_p") AS "var_28hr_1th_p",
						SUM ("var_1th_4th_l") AS "var_1th_4th_l",
						SUM ("var_1th_4th_p") AS "var_1th_4th_p",
						SUM ("var_4th_14th_l") AS "var_4th_14th_l",
						SUM ("var_4th_14th_p") AS "var_4th_14th_p",
						SUM ("var_14th_24th_l") AS "var_14th_24th_l",
						SUM ("var_14th_24th_p") AS "var_14th_24th_p",
						SUM ("var_24th_44th_l") AS "var_24th_44th_l",
						SUM ("var_24th_44th_p") AS "var_24th_44th_p",
						SUM ("var_44th_64th_l") AS "var_44th_64th_l",
						SUM ("var_44th_64th_p") AS "var_44th_64th_p",
						SUM ("var_64th_keatas_l") AS "var_64th_keatas_l",
						SUM ("var_64th_keatas_p") AS "var_64th_keatas_p",
						SUM (pasienkeluarlakilaki) AS pasienkeluarlakilaki,
						SUM (pasienkeluarperempuan) AS pasienkeluarperempuan,
						SUM (pasienkeluarhidup) AS pasienkeluarhidup,
						SUM (pasienkeluarmati) AS pasienkeluarmati';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl4aMobiditaspasienriV::model()->findAll($criteria);
        
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" rowspan="3" style="text-align:center;vertical-align:middle;">No. Urut</th>', 
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">No. DTD</th>', 
            '<th rowspan="3"  style="text-align:center;vertical-align:middle;">No. Daftar Terperinci</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Golongan Sebab Penyakit</th>',
            '<th colspan="18" style="text-align:center;vertical-align:middle;">Jumlah Pasien Hidup dan Mati menurut Golongan Umur & Jenis Kelamin</th>',
            '<th colspan="2" style="text-align:center;vertical-align:middle;">Pasien Keluar (Hidup & Mati) Menurut Jenis Kelamin</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Jumlah Pasien Keluar Hidup (23+24)</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Jumlah Pasien Keluar Mati</th>',
        );
        $header2 = array(
            '<th style="text-align:center;vertical-align:middle;">KODE PROPINSI</th>', 
            '<th style="text-align:center;vertical-align:middle;">KAB/KOTA</th>', 
            '<th style="text-align:center;vertical-align:middle;">KODE RS</th>', 
            '<th style="text-align:center;vertical-align:middle;">TAHUN</th>', 
            '<th width="50" style="text-align:center;vertical-align:middle;">No. Urut</th>', 
            '<th style="text-align:center;vertical-align:middle;">No. DTD</th>', 
            '<th style="text-align:center;vertical-align:middle;">No. Daftar Terperinci</th>',
            '<th style="text-align:center;vertical-align:middle;">Golongan Sebab Penyakit</th>',
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURRJSEX06hr L</th>', 
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURRJSEX06hr P</th>', 
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX728hr L</th>', 
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX728hr P</th>', 
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX28hr1th L</th>', 
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX28hr1th P</th>',
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX14th L</th>', 
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX14th P</th>',
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX514th L</th>', 
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX514th P</th>',
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX1524th L</th>', 
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX1524th P</th>',
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX2544th L</th>', 
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX2544th P</th>',
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX4564th L</th>', 
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX4564th P</th>',
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX65th L</th>', 
            '<th style="text-align:center;">JMLHPASYGHIDUPMATIMENUTURGOLUMURSEX65th P</th>',
            '<th style="text-align:center;">JMLHPASIENKELUARHIDUPMENURUTJENISKELAMINLK</th>', 
            '<th style="text-align:center;">JMLHPASIENKELUARHIDUPMENURUTJENISKELAMINPR</th>', 
            '<th style="text-align:center;">JMLPASIENKELUARHIDUPMATI12324</th>', 
            '<th style="text-align:center;">JUMLAHPASIENKELUARMATI</th>', 
           
        );
        $header3 = array(
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>',              
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor = "#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">7</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">8</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">9</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">10</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">11</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">12</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">13</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">14</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">15</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">16</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">17</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">18</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">19</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">20</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">21</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">22</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">23</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">24</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">25</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">26</td>',
        );

        $i=0;
        $datas = array();
		$total_0hr_l = 0;
		$total_0hr_p = 0;
		$total_6hr_l = 0;
		$total_6hr_p = 0;
		$total_28hr_l = 0;
		$total_28hr_p = 0;
		$total_1th_l = 0;
		$total_1th_p = 0;
		$total_4th_l = 0;
		$total_4th_p = 0;
		$total_14th_l = 0;
		$total_14th_p = 0;
		$total_24th_l = 0;
		$total_24th_p = 0;
		$total_44th_l = 0;
		$total_44th_p = 0;
		$total_64th_l = 0;
		$total_64th_p = 0;
		$total_pasienkeluarlakilaki = 0;
		$total_pasienkeluarperempuan = 0;
		$total_pasienkeluarhidup = 0;
		$total_pasienkeluarmati = 0;
		
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header2) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        
            $a = 0;
        if (count((array)$records) > 0):
            foreach($records as $key=>$val){               
                $table .= '<tr>';
                $table .= 
                    '
                    <td>'.$val['propinsi'].'</td>
                    <td>'.$val['kabupaten'].'</td>
                    <td>'.$val['koders'].'</td>
                    <td>'.date('Y',strtotime($val['tgl_laporan'])).'</td>
                    <td style=text-align:center;>'. ($key+1).'</td>
                    <td>'.$val['dtd_kode'].'</td>
                    <td>'.$val['dtd_noterperinci'].'</td>
                    <td>'.$val['golongansebabpenyakit'].'</td>
                    <td style=text-align:center;>'.number_format($val['var_0hr_6hr_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_0hr_6hr_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_6hr_28hr_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_6hr_28hr_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_28hr_1th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_28hr_1th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_1th_4th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_1th_4th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_4th_14th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_4th_14th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_14th_24th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_14th_24th_p'],0,"",".").'</td>  
                    <td style=text-align:center;>'.number_format($val['var_24th_44th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_24th_44th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_44th_64th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_44th_64th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_64th_keatas_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_64th_keatas_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['pasienkeluarlakilaki'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['pasienkeluarperempuan'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['pasienkeluarhidup'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['pasienkeluarmati'],0,"",".").'</td></tr>';
                
				$total_0hr_l += $val['var_0hr_6hr_l'];
				$total_0hr_p += $val['var_0hr_6hr_p'];
				$total_6hr_l += $val['var_6hr_28hr_l'];
				$total_6hr_p += $val['var_6hr_28hr_p'];
				$total_28hr_l += $val['var_28hr_1th_l'];
				$total_28hr_p += $val['var_28hr_1th_p'];
				$total_1th_l += $val['var_1th_4th_l'];
				$total_1th_p += $val['var_1th_4th_p'];
				$total_4th_l += $val['var_4th_14th_l'];
				$total_4th_p += $val['var_4th_14th_p'];
				$total_14th_l += $val['var_14th_24th_l'];
				$total_14th_p += $val['var_14th_24th_p'];
				$total_24th_l += $val['var_24th_44th_l'];
				$total_24th_p += $val['var_24th_44th_p'];
				$total_44th_l += $val['var_44th_64th_l'];
				$total_44th_p += $val['var_44th_64th_p'];
				$total_64th_l += $val['var_64th_keatas_l'];
				$total_64th_p += $val['var_64th_keatas_p'];
				$total_pasienkeluarlakilaki += $val['pasienkeluarlakilaki'];
				$total_pasienkeluarperempuan += $val['pasienkeluarperempuan'];
				$total_pasienkeluarhidup += $val['pasienkeluarhidup'];
				$total_pasienkeluarmati += $val['pasienkeluarmati'];

            } 
        else:
            $table .= '<tr>';
            $table .= '<td colspan="26"><i>Data Tidak Ditemukan</i></td>';
            $table .= '</tr>';
        endif;  
           
            $table .= '</tbody>';
            $table .= '</table>';  
        
       
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 20;
                $colspan1 = 12;
                $this->layout = '//layouts/printExcel';
            }
            
            $this->render('print_laporancarabayar',
                array(
                    'width'=>'1024',
                    'formulir'=>'Formulir RL 4.A',
                    'title'=>'DATA KEADAAN MORBIDITAS PASIEN RAWAT INAP RUMAH SAKIT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            

    }
    /**
     * Formulir RL 4.A MORBIDITAS PASIEN RAWAT JALAN
     */	
    public function actionMorbiditasRawatJalan()
    {
        $model = new RKRl4bMobiditaspasienrjV();
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        
        $criteria =  new CDbCriteria();
        $criteria->group = 'profilrs_id,
                            propinsi,
                            kabupaten,
                            koders,
                            namars,
                            tgl_laporan,
                            dtd_kode,
                            dtd_noterperinci,
                            golongansebabpenyakit';
        $criteria->select = 'profilrs_id,
                            propinsi,
                            kabupaten,
                            koders,
                            namars,
                            tgl_laporan,
                            dtd_kode,
                            dtd_noterperinci,
                            golongansebabpenyakit,
                            SUM ("var_0hr_6hr_l") AS "var_0hr_6hr_l",
                            SUM ("var_0hr_6hr_p") AS "var_0hr_6hr_p",
                            SUM ("var_6hr_28hr_l") AS "var_6hr_28hr_l",
                            SUM ("var_6hr_28hr_p") AS "var_6hr_28hr_p",
                            SUM ("var_28hr_1th_l") AS "var_28hr_1th_l",
                            SUM ("var_28hr_1th_p") AS "var_28hr_1th_p",
                            SUM ("var_1th_4th_l") AS "var_1th_4th_l",
                            SUM ("var_1th_4th_p") AS "var_1th_4th_p",
                            SUM ("var_4th_14th_l") AS "var_4th_14th_l",
                            SUM ("var_4th_14th_p") AS "var_4th_14th_p",
                            SUM ("var_14th_24th_l") AS "var_14th_24th_l",
                            SUM ("var_14th_24th_p") AS "var_14th_24th_p",
                            SUM ("var_24th_44th_l") AS "var_24th_44th_l",
                            SUM ("var_24th_44th_p") AS "var_24th_44th_p",
                            SUM ("var_44th_64th_l") AS "var_44th_64th_l",
                            SUM ("var_44th_64th_p") AS "var_44th_64th_p",
                            SUM ("var_64th_keatas_l") AS "var_64th_keatas_l",
                            SUM ("var_64th_keatas_p") AS "var_64th_keatas_p",
                            SUM(kasusbaru_lakilaki) AS kasusbaru_lakilaki,
                            SUM(kasusbaru_perempuan) AS kasusbaru_perempuan,
                            SUM(jumlahkasusbaru) AS jumlahkasusbaru,
                            SUM(jumlahkunjungan) AS jumlahkunjungan';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl4bMobiditaspasienrjV::model()->findAll($criteria);
        
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" rowspan="3" style="text-align:center;vertical-align:middle;">No. Urut</th>', 
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">No. DTD</th>', 
            '<th rowspan="3"  style="text-align:center;vertical-align:middle;">No. Daftar Terperinci</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Golongan Sebab Penyakit</th>',
            '<th colspan="18" style="text-align:center;vertical-align:middle;">Jumlah Pasien Kasus Menurut Golongan Umur & Jenis Kelamin</th>',
            '<th colspan="2" style="text-align:center;vertical-align:middle;">Kasus Baru Menurut Jenis Kelamin</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Jumlah Kasus Baru(23+24)</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Jumlah Kunjungan</th>',
        );
        $header2 = array(
            '<th colspan="2" style="text-align:center;">0-6hr</th>', 
            '<th colspan="2" style="text-align:center;">7-28hr</th>', 
            '<th colspan="2" style="text-align:center;">28hr-<1th</th>', 
            '<th colspan="2" style="text-align:center;">1-4th</th>', 
            '<th colspan="2" style="text-align:center;">5-14th</th>', 
            '<th colspan="2" style="text-align:center;">15-24th</th>', 
            '<th colspan="2" style="text-align:center;">25-44th</th>', 
            '<th colspan="2" style="text-align:center;">45-64th</th>', 
            '<th colspan="2" style="text-align:center;">>65</th>', 
            '<th rowspan="2" style="text-align:center;">LK</th>', 
            '<th rowspan="2" style="text-align:center;">PR</th>',
        );
        $header3 = array(
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>',              
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">7</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">8</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">9</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">10</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">11</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">12</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">13</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">14</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">15</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">16</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">17</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">18</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">19</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">20</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">21</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">22</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">23</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">24</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">25</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">26</td>',
        );

        $rows = array();
        $tot_var_0hr_6hr_l =  0;
        $tot_var_0hr_6hr_p =  0;
        $tot_var_6hr_28hr_l =  0;
        $tot_var_6hr_28hr_p =  0;
        $tot_var_28hr_1th_l =  0;
        $tot_var_28hr_1th_p =  0;
        $tot_var_1th_4th_l =  0;
        $tot_var_1th_4th_p =  0;
        $tot_var_4th_14th_l =  0;
        $tot_var_4th_14th_p =  0;
        $tot_var_14th_24th_l =  0;
        $tot_var_14th_24th_p =  0;
        $tot_var_24th_44th_l =  0;
        $tot_var_24th_44th_p =  0;
        $tot_var_44th_64th_l =  0;
        $tot_var_44th_64th_p =  0;
        $tot_var_64th_keatas_l =  0;
        $tot_var_64th_keatas_p =  0;
        $tot_kasusbaru_lakilaki =  0;
        $tot_kasusbaru_perempuan =  0;
        $tot_jumlahkasusbaru =  0;
        $tot_jumlahkunjungan =  0;

        $datas = array();
        $dataGroup = array();
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>'.'<tr>'. implode("", $header2) .'</tr>'.'<tr>'. implode("", $header3) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        
        if (count((array)$records) > 0):
            foreach($records as $a=>$val){               
                $table .= '<tr>';
                $table .= '<td style=text-align:center;>'. ($a+1).'</td>
                    <td>'.$val['dtd_kode'].'</td>
                    <td>'.$val['dtd_noterperinci'].'</td>
                    <td>'.$val['golongansebabpenyakit'].'</td>
                    <td style=text-align:center;>'.number_format($val['var_0hr_6hr_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_0hr_6hr_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_6hr_28hr_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_6hr_28hr_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_28hr_1th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_28hr_1th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_1th_4th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_1th_4th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_4th_14th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_4th_14th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_14th_24th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_14th_24th_p'],0,"",".").'</td>  
                    <td style=text-align:center;>'.number_format($val['var_24th_44th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_24th_44th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_44th_64th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_44th_64th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_64th_keatas_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_64th_keatas_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['kasusbaru_lakilaki'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['kasusbaru_perempuan'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['jumlahkasusbaru'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['jumlahkunjungan'],0,"",".").'</td></tr>';
                
                $tot_var_0hr_6hr_l +=  $val['var_0hr_6hr_l'];
                $tot_var_0hr_6hr_p +=  $val['var_0hr_6hr_p'];
                $tot_var_6hr_28hr_l +=  $val['var_6hr_28hr_l'];
                $tot_var_6hr_28hr_p +=  $val['var_6hr_28hr_p'];
                $tot_var_28hr_1th_l +=  $val['var_28hr_1th_l'];
                $tot_var_28hr_1th_p +=  $val['var_28hr_1th_p'];
                $tot_var_1th_4th_l +=  $val['var_1th_4th_l'];
                $tot_var_1th_4th_p +=  $val['var_1th_4th_p'];
                $tot_var_4th_14th_l +=  $val['var_4th_14th_l'];
                $tot_var_4th_14th_p +=  $val['var_4th_14th_p'];
                $tot_var_14th_24th_l +=  $val['var_14th_24th_l'];
                $tot_var_14th_24th_p +=  $val['var_14th_24th_p'];
                $tot_var_24th_44th_l +=  $val['var_24th_44th_l'];
                $tot_var_24th_44th_p +=  $val['var_24th_44th_p'];
                $tot_var_44th_64th_l +=  $val['var_44th_64th_l'];
                $tot_var_44th_64th_p +=  $val['var_44th_64th_p'];
                $tot_var_64th_keatas_l +=  $val['var_64th_keatas_l'];
                $tot_var_64th_keatas_p +=  $val['var_64th_keatas_p'];
                $tot_kasusbaru_lakilaki +=  $val['kasusbaru_lakilaki'];
                $tot_kasusbaru_perempuan +=  $val['kasusbaru_perempuan'];
                $tot_jumlahkasusbaru +=  $val['jumlahkasusbaru'];
                $tot_jumlahkunjungan +=  $val['jumlahkunjungan'];
            } 
        else:
            $table .= "<tr>";
            $table .= "<td colspan='24'><i>Data Tidak Ditemukan</i></td>";
            $table .= "</tr>";
            
        endif;
                   
        $table .= '<tr><td></td><td></td><td></td><td align = "right"><b>Total</b></td>
                    <td style=text-align:center;>'.number_format($tot_var_0hr_6hr_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_0hr_6hr_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_6hr_28hr_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_6hr_28hr_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_28hr_1th_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_28hr_1th_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_1th_4th_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_1th_4th_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_4th_14th_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_4th_14th_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_14th_24th_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_14th_24th_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_24th_44th_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_24th_44th_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_44th_64th_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_44th_64th_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_64th_keatas_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_64th_keatas_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_kasusbaru_lakilaki,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_kasusbaru_perempuan,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_jumlahkasusbaru,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_jumlahkunjungan,0,"",".").'</td><tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
            );
            $title = "DATA KEADAAN MORBIDITAS PASIEN RAWAT JALAN RUMAH SAKIT";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'1024',
                        'formulir'=>'Formulir RL 4.B',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/iframe';
            
            $this->render('print_laporan',
                array(
                    'width'=>'1024',
                    'formulir'=>'Formulir RL 4.B',
                    'title'=>'DATA KEADAAN MORBIDITAS PASIEN RAWAT JALAN RUMAH SAKIT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );           
        }else{
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 20;
                $colspan1 = 12;
                $this->layout = '//layouts/printExcel';
            }
            
            $this->render('print_laporan',
                array(
                    'width'=>'1024',
                    'formulir'=>'Formulir RL 4.B',
                    'title'=>'DATA KEADAAN MORBIDITAS PASIEN RAWAT JALAN RUMAH SAKIT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }

    }
    /**
     * Formulir RL 4.A MORBIDITAS PASIEN RAWAT JALAN
     * PENYEBAB KECELAKAAN
     */	
    public function actionMorbiditasRawatJalanKecelakaan()
    {
        $model = new RKRl4bMobiditaspasienrjV();
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        
        $criteria =  new CDbCriteria();
        $criteria->group = 'profilrs_id,
                            propinsi,
                            kabupaten,
                            koders,
                            namars,
                            tgl_laporan,
                            dtd_kode,
                            dtd_noterperinci,
                            golongansebabpenyakit';
        $criteria->select = 'profilrs_id,
                            propinsi,
                            kabupaten,
                            koders,
                            namars,
                            tgl_laporan,
                            dtd_kode,
                            dtd_noterperinci,
                            golongansebabpenyakit,
                            SUM ("var_0hr_6hr_l") AS "var_0hr_6hr_l",
                            SUM ("var_0hr_6hr_p") AS "var_0hr_6hr_p",
                            SUM ("var_6hr_28hr_l") AS "var_6hr_28hr_l",
                            SUM ("var_6hr_28hr_p") AS "var_6hr_28hr_p",
                            SUM ("var_28hr_1th_l") AS "var_28hr_1th_l",
                            SUM ("var_28hr_1th_p") AS "var_28hr_1th_p",
                            SUM ("var_1th_4th_l") AS "var_1th_4th_l",
                            SUM ("var_1th_4th_p") AS "var_1th_4th_p",
                            SUM ("var_4th_14th_l") AS "var_4th_14th_l",
                            SUM ("var_4th_14th_p") AS "var_4th_14th_p",
                            SUM ("var_14th_24th_l") AS "var_14th_24th_l",
                            SUM ("var_14th_24th_p") AS "var_14th_24th_p",
                            SUM ("var_24th_44th_l") AS "var_24th_44th_l",
                            SUM ("var_24th_44th_p") AS "var_24th_44th_p",
                            SUM ("var_44th_64th_l") AS "var_44th_64th_l",
                            SUM ("var_44th_64th_p") AS "var_44th_64th_p",
                            SUM ("var_64th_keatas_l") AS "var_64th_keatas_l",
                            SUM ("var_64th_keatas_p") AS "var_64th_keatas_p",
                            SUM(kasusbaru_lakilaki) AS kasusbaru_lakilaki,
                            SUM(kasusbaru_perempuan) AS kasusbaru_perempuan,
                            SUM(jumlahkasusbaru) AS jumlahkasusbaru,
                            SUM(jumlahkunjungan) AS jumlahkunjungan';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl4bMobiditaspasienrjV::model()->findAll($criteria);
        
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" rowspan="3" style="text-align:center;vertical-align:middle;">No. Urut</th>', 
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">No. DTD</th>', 
            '<th rowspan="3"  style="text-align:center;vertical-align:middle;">No. Daftar Terperinci</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Golongan Sebab Penyakit</th>',
            '<th colspan="18" style="text-align:center;vertical-align:middle;">Jumlah Pasien Kasus Menurut Golongan Umur & Jenis Kelamin</th>',
            '<th colspan="2" style="text-align:center;vertical-align:middle;">Kasus Baru Menurut Jenis Kelamin</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Jumlah Kasus Baru(23+24)</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Jumlah Kunjungan</th>',
        );
        $header2 = array(
            '<th colspan="2" style="text-align:center;">0-6hr</th>', 
            '<th colspan="2" style="text-align:center;">7-28hr</th>', 
            '<th colspan="2" style="text-align:center;">28hr-<1th</th>', 
            '<th colspan="2" style="text-align:center;">1-4th</th>', 
            '<th colspan="2" style="text-align:center;">5-14th</th>', 
            '<th colspan="2" style="text-align:center;">15-24th</th>', 
            '<th colspan="2" style="text-align:center;">25-44th</th>', 
            '<th colspan="2" style="text-align:center;">45-64th</th>', 
            '<th colspan="2" style="text-align:center;">>65</th>', 
            '<th rowspan="2" style="text-align:center;">LK</th>', 
            '<th rowspan="2" style="text-align:center;">PR</th>',
        );
        $header3 = array(
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>',              
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">7</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">8</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">9</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">10</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">11</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">12</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">13</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">14</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">15</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">16</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">17</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">18</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">19</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">20</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">21</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">22</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">23</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">24</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">25</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">26</td>',
        );

        $rows = array();
        $tot_var_0hr_6hr_l =  0;
        $tot_var_0hr_6hr_p =  0;
        $tot_var_6hr_28hr_l =  0;
        $tot_var_6hr_28hr_p =  0;
        $tot_var_28hr_1th_l =  0;
        $tot_var_28hr_1th_p =  0;
        $tot_var_1th_4th_l =  0;
        $tot_var_1th_4th_p =  0;
        $tot_var_4th_14th_l =  0;
        $tot_var_4th_14th_p =  0;
        $tot_var_14th_24th_l =  0;
        $tot_var_14th_24th_p =  0;
        $tot_var_24th_44th_l =  0;
        $tot_var_24th_44th_p =  0;
        $tot_var_44th_64th_l =  0;
        $tot_var_44th_64th_p =  0;
        $tot_var_64th_keatas_l =  0;
        $tot_var_64th_keatas_p =  0;
        $tot_kasusbaru_lakilaki =  0;
        $tot_kasusbaru_perempuan =  0;
        $tot_jumlahkasusbaru =  0;
        $tot_jumlahkunjungan =  0;

        $datas = array();
        $dataGroup = array();
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>'.'<tr>'. implode("", $header2) .'</tr>'.'<tr>'. implode("", $header3) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        
        if (count((array)$records) > 0):
            foreach($records as $a=>$val){               
                $table .= '<tr>';
                $table .= '<td style=text-align:center;>'. ($a+1).'</td>
                    <td>'.$val['dtd_kode'].'</td>
                    <td>'.$val['dtd_noterperinci'].'</td>
                    <td>'.$val['golongansebabpenyakit'].'</td>
                    <td style=text-align:center;>'.number_format($val['var_0hr_6hr_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_0hr_6hr_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_6hr_28hr_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_6hr_28hr_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_28hr_1th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_28hr_1th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_1th_4th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_1th_4th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_4th_14th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_4th_14th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_14th_24th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_14th_24th_p'],0,"",".").'</td>  
                    <td style=text-align:center;>'.number_format($val['var_24th_44th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_24th_44th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_44th_64th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_44th_64th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_64th_keatas_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_64th_keatas_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['kasusbaru_lakilaki'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['kasusbaru_perempuan'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['jumlahkasusbaru'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['jumlahkunjungan'],0,"",".").'</td></tr>';
                
                $tot_var_0hr_6hr_l +=  $val['var_0hr_6hr_l'];
                $tot_var_0hr_6hr_p +=  $val['var_0hr_6hr_p'];
                $tot_var_6hr_28hr_l +=  $val['var_6hr_28hr_l'];
                $tot_var_6hr_28hr_p +=  $val['var_6hr_28hr_p'];
                $tot_var_28hr_1th_l +=  $val['var_28hr_1th_l'];
                $tot_var_28hr_1th_p +=  $val['var_28hr_1th_p'];
                $tot_var_1th_4th_l +=  $val['var_1th_4th_l'];
                $tot_var_1th_4th_p +=  $val['var_1th_4th_p'];
                $tot_var_4th_14th_l +=  $val['var_4th_14th_l'];
                $tot_var_4th_14th_p +=  $val['var_4th_14th_p'];
                $tot_var_14th_24th_l +=  $val['var_14th_24th_l'];
                $tot_var_14th_24th_p +=  $val['var_14th_24th_p'];
                $tot_var_24th_44th_l +=  $val['var_24th_44th_l'];
                $tot_var_24th_44th_p +=  $val['var_24th_44th_p'];
                $tot_var_44th_64th_l +=  $val['var_44th_64th_l'];
                $tot_var_44th_64th_p +=  $val['var_44th_64th_p'];
                $tot_var_64th_keatas_l +=  $val['var_64th_keatas_l'];
                $tot_var_64th_keatas_p +=  $val['var_64th_keatas_p'];
                $tot_kasusbaru_lakilaki +=  $val['kasusbaru_lakilaki'];
                $tot_kasusbaru_perempuan +=  $val['kasusbaru_perempuan'];
                $tot_jumlahkasusbaru +=  $val['jumlahkasusbaru'];
                $tot_jumlahkunjungan +=  $val['jumlahkunjungan'];
            } 
        else:
            $table .= "<tr>";
            $table .= "<td colspan='24'><i>Data Tidak Ditemukan</i></td>";
            $table .= "</tr>";
            
        endif;
                   
        $table .= '<tr><td></td><td></td><td></td><td align = "right"><b>Total</b></td>
                    <td style=text-align:center;>'.number_format($tot_var_0hr_6hr_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_0hr_6hr_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_6hr_28hr_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_6hr_28hr_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_28hr_1th_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_28hr_1th_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_1th_4th_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_1th_4th_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_4th_14th_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_4th_14th_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_14th_24th_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_14th_24th_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_24th_44th_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_24th_44th_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_44th_64th_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_44th_64th_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_64th_keatas_l,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_var_64th_keatas_p,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_kasusbaru_lakilaki,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_kasusbaru_perempuan,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_jumlahkasusbaru,0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($tot_jumlahkunjungan,0,"",".").'</td><tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
            );
            $title = "DATA KEADAAN MORBIDITAS PASIEN RAWAT JALAN RUMAH SAKIT <br>PENYEBAB KECELAKAAN";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'1024',
                        'formulir'=>'Formulir RL 4B',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/iframe';
            
            $this->render('print_laporan',
                array(
                    'width'=>'1024',
                    'formulir'=>'Formulir RL 4B',
                    'title'=>'DATA KEADAAN MORBIDITAS PASIEN RAWAT JALAN RUMAH SAKIT <br>PENYEBAB KECELAKAAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );           
        }else{
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 20;
                $colspan1 = 12;
                $this->layout = '//layouts/printExcel';
            }
            
            $this->render('print_laporan',
                array(
                    'width'=>'1024',
                    'formulir'=>'Formulir RL 4B',
                    'title'=>'DATA KEADAAN MORBIDITAS PASIEN RAWAT JALAN RUMAH SAKIT <br>PENYEBAB KECELAKAAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }

    }
    /**
     * print Formulir RL 4.A MORBIDITAS PASIEN RAWAT JALAN
     */
    public function actionPrintMorbiditasRawatJalan()
    {
        $model = new RKRl4bMobiditaspasienrjV();
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        
        $criteria =  new CDbCriteria();
        $criteria->group = 'profilrs_id,
                            propinsi,
                            kabupaten,
                            koders,
                            namars,
                            tgl_laporan,
                            dtd_kode,
                            dtd_noterperinci,
                            golongansebabpenyakit';
        $criteria->select = 'profilrs_id,
                            propinsi,
                            kabupaten,
                            koders,
                            namars,
                            tgl_laporan,
                            dtd_kode,
                            dtd_noterperinci,
                            golongansebabpenyakit,
                            SUM ("var_0hr_6hr_l") AS "var_0hr_6hr_l",
                            SUM ("var_0hr_6hr_p") AS "var_0hr_6hr_p",
                            SUM ("var_6hr_28hr_l") AS "var_6hr_28hr_l",
                            SUM ("var_6hr_28hr_p") AS "var_6hr_28hr_p",
                            SUM ("var_28hr_1th_l") AS "var_28hr_1th_l",
                            SUM ("var_28hr_1th_p") AS "var_28hr_1th_p",
                            SUM ("var_1th_4th_l") AS "var_1th_4th_l",
                            SUM ("var_1th_4th_p") AS "var_1th_4th_p",
                            SUM ("var_4th_14th_l") AS "var_4th_14th_l",
                            SUM ("var_4th_14th_p") AS "var_4th_14th_p",
                            SUM ("var_14th_24th_l") AS "var_14th_24th_l",
                            SUM ("var_14th_24th_p") AS "var_14th_24th_p",
                            SUM ("var_24th_44th_l") AS "var_24th_44th_l",
                            SUM ("var_24th_44th_p") AS "var_24th_44th_p",
                            SUM ("var_44th_64th_l") AS "var_44th_64th_l",
                            SUM ("var_44th_64th_p") AS "var_44th_64th_p",
                            SUM ("var_64th_keatas_l") AS "var_64th_keatas_l",
                            SUM ("var_64th_keatas_p") AS "var_64th_keatas_p",
                            SUM(kasusbaru_lakilaki) AS kasusbaru_lakilaki,
                            SUM(kasusbaru_perempuan) AS kasusbaru_perempuan,
                            SUM(jumlahkasusbaru) AS jumlahkasusbaru,
                            SUM(jumlahkunjungan) AS jumlahkunjungan';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl4bMobiditaspasienrjV::model()->findAll($criteria);
        
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" rowspan="3" style="text-align:center;vertical-align:middle;">No. Urut</th>', 
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">No. DTD</th>', 
            '<th rowspan="3"  style="text-align:center;vertical-align:middle;">No. Daftar Terperinci</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Golongan Sebab Penyakit</th>',
            '<th colspan="18" style="text-align:center;vertical-align:middle;">Jumlah Pasien Kasus Menurut Golongan Umur & Jenis Kelamin</th>',
            '<th colspan="2" style="text-align:center;vertical-align:middle;">Kasus Baru Menurut Jenis Kelamin</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Jumlah Kasus Baru(23+24)</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">Jumlah Kunjungan</th>',
        );
        $header2 = array(
            '<th style="text-align:center;">KODE PROPINSI</th>', 
            '<th style="text-align:center;">KAB/KOTA</th>', 
            '<th style="text-align:center;">KODE RS</th>', 
            '<th style="text-align:center;">NAMA RS</th>', 
            '<th style="text-align:center;">TAHUN</th>', 
            '<th style="text-align:center;">NO. URUT</th>', 
            '<th style="text-align:center;">NO. DTD</th>', 
            '<th style="text-align:center;">NO. DAFTAR TERPERINCI</th>', 
            '<th style="text-align:center;">GOLONGAN SEBAB PENYAKIT</th>', 
            '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_0-6 hr_L</th>', 
            '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_0-6 hr_P</th>', 
            '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_7-28 hr_L</th>', 
            '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_7-28 hr_P</th>',
            '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_28hr-<1th_L</th>', 
            '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_28hr-<1th_L</th>', 

            '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_1-4th_L</th>', 
             '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_1-4th_P</th>', 
            '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_5-14th_L</th>',
            '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_5-14th_P</th>', 
            '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_15-24th_L</th>', 
             '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_15-24th_P</th>', 
            '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_25-44th_L</th>', 
             '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_25-44th_P</th>', 
            '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_45-64th_L</th>', 
             '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_45-64th_P</th>', 
            '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_>65_L</th>', 
            '<th style="text-align:center;">JUMLAH PASIEN KASUS MENURUT GOLONGAN UMUR & SEX_>65_P</th>', 
            '<th style="text-align:center;">KASUS BARU MENURUT JENIS KELAMIN_LK</th>', 
            '<th style="text-align:center;">KASUS BARU MENURUT JENIS KELAMIN_PR</th>',
            '<th style="text-align:center;vertical-align:middle;">JUMLAH KASUS BARU(23+24)</th>',
            '<th style="text-align:center;vertical-align:middle;">JUMLAH KUNJUNGAN</th>',
        );
        $header3 = array(
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>', 
            '<th style="text-align:center;">L</th>', 
            '<th style="text-align:center;">P</th>',              
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">7</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">8</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">9</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">10</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">11</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">12</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">13</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">14</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">15</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">16</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">17</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">18</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">19</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">20</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">21</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">22</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">23</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">24</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">25</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">26</td>',
        );

        $rows = array();
        $tot_var_0hr_6hr_l =  0;
        $tot_var_0hr_6hr_p =  0;
        $tot_var_6hr_28hr_l =  0;
        $tot_var_6hr_28hr_p =  0;
        $tot_var_28hr_1th_l =  0;
        $tot_var_28hr_1th_p =  0;
        $tot_var_1th_4th_l =  0;
        $tot_var_1th_4th_p =  0;
        $tot_var_4th_14th_l =  0;
        $tot_var_4th_14th_p =  0;
        $tot_var_14th_24th_l =  0;
        $tot_var_14th_24th_p =  0;
        $tot_var_24th_44th_l =  0;
        $tot_var_24th_44th_p =  0;
        $tot_var_44th_64th_l =  0;
        $tot_var_44th_64th_p =  0;
        $tot_var_64th_keatas_l =  0;
        $tot_var_64th_keatas_p =  0;
        $tot_kasusbaru_lakilaki =  0;
        $tot_kasusbaru_perempuan =  0;
        $tot_jumlahkasusbaru =  0;
        $tot_jumlahkunjungan =  0;

        $datas = array();
        $dataGroup = array();
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header2).'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
   
        
        if (count((array)$records) > 0):
            foreach($records as $a=>$val){               
                $table .= '<tr>';
                $table .= '
                    <td style=text-align:center;>'.$val['propinsi'].'</td>
                    <td style=text-align:center;>'.$val['kabupaten'].'</td>
                    <td style=text-align:center;>'.$val['koders'].'</td>
                    <td style=text-align:center;>'.$val['namars'].'</td>
                    <td style=text-align:center;>'.date('Y', strtotime($val['tgl_laporan'])).'</td>
                    <td style=text-align:center;>'. ($a+1).'</td>
                    <td>'.$val['dtd_kode'].'</td>
                    <td>'.$val['dtd_noterperinci'].'</td>
                    <td>'.$val['golongansebabpenyakit'].'</td>
                    <td style=text-align:center;>'.number_format($val['var_0hr_6hr_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_0hr_6hr_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_6hr_28hr_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_6hr_28hr_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_28hr_1th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_28hr_1th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_1th_4th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_1th_4th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_4th_14th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_4th_14th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_14th_24th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_14th_24th_p'],0,"",".").'</td>  
                    <td style=text-align:center;>'.number_format($val['var_24th_44th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_24th_44th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_44th_64th_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_44th_64th_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_64th_keatas_l'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['var_64th_keatas_p'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['kasusbaru_lakilaki'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['kasusbaru_perempuan'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['jumlahkasusbaru'],0,"",".").'</td>
                    <td style=text-align:center;>'.number_format($val['jumlahkunjungan'],0,"",".").'</td></tr>';
                
                $tot_var_0hr_6hr_l +=  $val['var_0hr_6hr_l'];
                $tot_var_0hr_6hr_p +=  $val['var_0hr_6hr_p'];
                $tot_var_6hr_28hr_l +=  $val['var_6hr_28hr_l'];
                $tot_var_6hr_28hr_p +=  $val['var_6hr_28hr_p'];
                $tot_var_28hr_1th_l +=  $val['var_28hr_1th_l'];
                $tot_var_28hr_1th_p +=  $val['var_28hr_1th_p'];
                $tot_var_1th_4th_l +=  $val['var_1th_4th_l'];
                $tot_var_1th_4th_p +=  $val['var_1th_4th_p'];
                $tot_var_4th_14th_l +=  $val['var_4th_14th_l'];
                $tot_var_4th_14th_p +=  $val['var_4th_14th_p'];
                $tot_var_14th_24th_l +=  $val['var_14th_24th_l'];
                $tot_var_14th_24th_p +=  $val['var_14th_24th_p'];
                $tot_var_24th_44th_l +=  $val['var_24th_44th_l'];
                $tot_var_24th_44th_p +=  $val['var_24th_44th_p'];
                $tot_var_44th_64th_l +=  $val['var_44th_64th_l'];
                $tot_var_44th_64th_p +=  $val['var_44th_64th_p'];
                $tot_var_64th_keatas_l +=  $val['var_64th_keatas_l'];
                $tot_var_64th_keatas_p +=  $val['var_64th_keatas_p'];
                $tot_kasusbaru_lakilaki +=  $val['kasusbaru_lakilaki'];
                $tot_kasusbaru_perempuan +=  $val['kasusbaru_perempuan'];
                $tot_jumlahkasusbaru +=  $val['jumlahkasusbaru'];
                $tot_jumlahkunjungan +=  $val['jumlahkunjungan'];
            } 
        else:
            $table .= "<tr>";
            $table .= "<td colspan='24'><i>Data Tidak Ditemukan</i></td>";
            $table .= "</tr>";
            
        endif;
                   

        $table .= '</tbody>';
        $table .= '</table>';
        
      
 
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 20;
                $colspan1 = 12;
                $this->layout = '//layouts/printExcel';
            }
            
            $this->render('print_laporanGigimulut',
                array(
                    'width'=>'1024',
                    'formulir'=>'Formulir RL 4.B',
                    'title'=>'DATA KEADAAN MORBIDITAS PASIEN RAWAT JALAN RUMAH SAKIT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        

    }
    /**
     * Formulir RL 4.A ketenagaan
     */
     public function actionKetenagaan()
    {
        $model = new RKrl2KetenagaanV;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
     
        $criteria=new CDbCriteria;
        $criteria->select = 'kelompokpegawai_id, kelompokpegawai_nama, jeniskelamin, pendkualifikasi_id, pendkualifikasi_nama, jmlkeadaanskrg, jmlkeblaki, jmlkebperempuan';
        $criteria->addCondition('pendkualifikasi_id IS NOT NULL');
        $criteria->group = 'kelompokpegawai_id, kelompokpegawai_nama, jeniskelamin, pendkualifikasi_id, pendkualifikasi_nama, jmlkeadaanskrg, jmlkeblaki, jmlkebperempuan';
        
        $criteria->order = 'kelompokpegawai_nama asc';

        $records = RKrl2KetenagaanV::model()->findAll($criteria);
        
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" rowspan="2" style="text-align:center;">NO KODE</th>', 
            '<th rowspan="2" style="text-align:center;">KUALIFIKASI PENDIDIKAN</th>', 
            '<th colspan="2" style="text-align:center;">KEADAAN</th>',
            '<th colspan="2" style="text-align:center;">KEBUTUHAN</th>',
            '<th colspan="2" style="text-align:center;">KEKURANGAN</th>',
        );
        $header2 = array(
            '<th style="text-align:center;">Laki-Laki</th>', 
            '<th style="text-align:center;">Perempuan</th>',
            '<th style="text-align:center;">Laki-Laki</th>', 
            '<th style="text-align:center;">Perempuan</th>',
            '<th style="text-align:center;">Laki-Laki</th>', 
            '<th style="text-align:center;">Perempuan</th>',
        );
        $tdCount = array(
            '<td style="text-align:center;background-color:#AFAFAF">1</td>',
            '<td style="text-align:center;background-color:#AFAFAF">2</td>',
            '<td style="text-align:center;background-color:#AFAFAF">3</td>',
            '<td style="text-align:center;background-color:#AFAFAF">4</td>',
            '<td style="text-align:center;background-color:#AFAFAF">5</td>',
            '<td style="text-align:center;background-color:#AFAFAF">6</td>',
            '<td style="text-align:center;background-color:#AFAFAF">7</td>',
            '<td style="text-align:center;background-color:#AFAFAF">8</td>',
        );

        $rows = array();
        $i=0;
        $total_jumlah = 0;

        // $kelompokpegawai_nama[-1] = '';
        $no = 0;
        $subno = 0;
        $kurangLaki = 0;
        $kurangPerempuan = 0;
        foreach($records as $row)
        {
            // $kelompokpegawai_nama[$row] = $value['kelompokpegawai_nama'];
            // $kelompokpegawai_nama[$row] = $value['kelompokpegawai_nama'];

            // echo $kelompokpegawai_nama[$row]; exit;
            //if($kelompokpegawai_nama[$row]!=$kelompokpegawai_nama[$val-0]){
            $no++;
            $totalLaki = ($row['jmlkeblaki'] - $model->getSumKeadaan($row['pendkualifikasi_id'], PARAMS::JENIS_KELAMIN_LAKI_LAKI));
            $totalPerempuan = ($row['jmlkeblaki'] - $model->getSumKeadaan($row['pendkualifikasi_id'], PARAMS::JENIS_KELAMIN_PEREMPUAN));
            if ($totalLaki < 0){
                $totalLaki = 0;
            } else {
                $kurangLaki = $kurangLaki + $totalLaki;
            }
            if ($totalPerempuan < 0){
                $totalPerempuan = 0;
            } else {
                $kurangPerempuan = $kurangPerempuan +$totalPerempuan;
            }
            if ($model->cekPendidikanKualifikasi($row['pendkualifikasi_id'], $row['jeniskelamin']) === true):
                
                 $rows[] = array(
                '<td style="text-align:center;">'.$no.'</td>',
                '<td>'.$row['pendkualifikasi_nama'].'</td>',
                '<td style = "text-align:right;">'.number_format($model->getSumKeadaan($row['pendkualifikasi_id'],PARAMS::JENIS_KELAMIN_LAKI_LAKI),0,"",".").'</td>',
                '<td style = "text-align:right;">'.number_format($model->getSumKeadaan($row['pendkualifikasi_id'],PARAMS::JENIS_KELAMIN_PEREMPUAN),0,"",".").'</td>',
                '<td style = "text-align:right;">'.number_format($row['jmlkeblaki'],0,"",".").'</td>',
                '<td style = "text-align:right;">'.number_format($row['jmlkebperempuan'],0,"",".").'</td>',
                '<td style = "text-align:right;">'.number_format($totalLaki,0,"",".").'</td>',
                '<td style = "text-align:right;">'.number_format($totalPerempuan,0,"",".").'</td>',                   
                );
            else:    
                $no = $no -1;
                //$rows[] = array();
            endif;
           
           // }
            // else{

            //     $no++;
            //     $subno++;
            //     $rows[] = array(

            //     '<td style=text-align:center;>'.($no+1).'.'.$subno.'</td>',
            //     '<td>'.$value['pendkualifikasi_nama'].'</td>',
            //     '<td>'.''.'</td>',
            //     '<td>'.''.'</td>',
            //     '<td>'.''.'</td>',
            //     '<td>'.''.'</td>',
            //     '<td>'.''.'</td>',
            //     '<td>'.''.'</td>',
              
            // );
            // }
            //$i++;
            // $total_jumlah += $row['jlmtt'];
        }


        $table = '<table cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>'.'<tr>'.implode("", $header2).'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        $table .= '<tr>';
        $table .= implode("", $tdCount).'</tr>';
        foreach($rows as $xxx)
        {
            $table .= '<tr>'. implode('', $xxx) . '<tr>';
        }
         $table .= '<tr><td></td><td style = "text-align:right;"><b>Total</b></td><td style = "text-align:right;">' . number_format($model->getSumTotal(PARAMS::JENIS_KELAMIN_LAKI_LAKI),0,"",".") .'</td><td style = "text-align:right;">'
                                                            . number_format($model->getSumTotal(PARAMS::JENIS_KELAMIN_PEREMPUAN),0,"",".") .'</td><td style = "text-align:right;">'
                                                            . number_format($model->getSumkebutuhanL(),0,"",".") .'</td><td style = "text-align:right;">'
                                                            . number_format($model->getSumkebutuhanP(),0,"",".") .'</td><td style = "text-align:right;">'
                                                            . number_format($kurangLaki,0,"",".") .'</td><td style = "text-align:right;">'
                                                            . number_format($kurangPerempuan,0,"",".") .'</td><tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
            );
            $title = "KETENAGAAN";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 2',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){  
             $this->layout = '//layouts/iframe';
           
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 2',
                    'title'=>'KETENAGAAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );              
        }else{
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 2',
                    'title'=>'KETENAGAAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }

    }
    
    
    /**
     * Print Formulir RL 4.A ketenagaan
     */
     public function actionPrintKetenagaan()
    {
        $model = new RKrl2KetenagaanV;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
     
        $criteria=new CDbCriteria;
        $criteria->select = 'kelompokpegawai_id, kelompokpegawai_nama, jeniskelamin, pendkualifikasi_id, pendkualifikasi_nama, jmlkeadaanskrg, jmlkeblaki, jmlkebperempuan';
        $criteria->addCondition('pendkualifikasi_id IS NOT NULL');
        $criteria->group = 'kelompokpegawai_id, kelompokpegawai_nama, jeniskelamin, pendkualifikasi_id, pendkualifikasi_nama, jmlkeadaanskrg, jmlkeblaki, jmlkebperempuan';
        
        $criteria->order = 'kelompokpegawai_nama asc';

        $records = RKrl2KetenagaanV::model()->findAll($criteria);
        $modProfil=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $modKabupaten = KabupatenM::model()->findByPk($modProfil->kabupaten_id);
        $modPropinsi = PropinsiM::model()->findByPk($modProfil->propinsi_id);
        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" rowspan="2" style="text-align:center;">NO KODE</th>', 
            '<th rowspan="2" style="text-align:center;">KUALIFIKASI PENDIDIKAN</th>', 
            '<th colspan="2" style="text-align:center;">KEADAAN</th>',
            '<th colspan="2" style="text-align:center;">KEBUTUHAN</th>',
            '<th colspan="2" style="text-align:center;">KEKURANGAN</th>',
        );
        $header2 = array(
            '<th style="text-align:center;">KODE RS</th>', 
            '<th style="text-align:center;">KAB/KOTA</th>', 
            '<th style="text-align:center;">KODE PROPINSI</th>', 
            '<th style="text-align:center;">NAMA RS</th>', 
            '<th style="text-align:center;">TAHUN</th>', 
            '<th width="50"style="text-align:center;">NO KODE</th>', 
            '<th style="text-align:center;">KUALIFIKASI PENDIDIKAN</th>', 
            '<th style="text-align:center;">KEADAANLaki-Laki</th>', 
            '<th style="text-align:center;">KEADAAN Perempuan</th>',
            '<th style="text-align:center;">KEBUTUHAN Laki-Laki</th>', 
            '<th style="text-align:center;">KEBUTUHAN Perempuan</th>',
            '<th style="text-align:center;">KEKURANGAN Laki-Laki</th>', 
            '<th style="text-align:center;">KEKURANGAN Perempuan</th>',
        );
        $tdCount = array(
            '<td style="text-align:center;background-color:#AFAFAF">1</td>',
            '<td style="text-align:center;background-color:#AFAFAF">2</td>',
            '<td style="text-align:center;background-color:#AFAFAF">3</td>',
            '<td style="text-align:center;background-color:#AFAFAF">4</td>',
            '<td style="text-align:center;background-color:#AFAFAF">5</td>',
            '<td style="text-align:center;background-color:#AFAFAF">6</td>',
            '<td style="text-align:center;background-color:#AFAFAF">7</td>',
            '<td style="text-align:center;background-color:#AFAFAF">8</td>',
        );

        $rows = array();
        $i=0;
        $total_jumlah = 0;

        // $kelompokpegawai_nama[-1] = '';
        $no = 0;
        $subno = 0;
        $kurangLaki = 0;
        $kurangPerempuan = 0;
        foreach($records as $row)
        {
            // $kelompokpegawai_nama[$row] = $value['kelompokpegawai_nama'];
            // $kelompokpegawai_nama[$row] = $value['kelompokpegawai_nama'];

            // echo $kelompokpegawai_nama[$row]; exit;
            //if($kelompokpegawai_nama[$row]!=$kelompokpegawai_nama[$val-0]){
            $no++;
            $totalLaki = ($row['jmlkeblaki'] - $model->getSumKeadaan($row['pendkualifikasi_id'], PARAMS::JENIS_KELAMIN_LAKI_LAKI));
            $totalPerempuan = ($row['jmlkeblaki'] - $model->getSumKeadaan($row['pendkualifikasi_id'], PARAMS::JENIS_KELAMIN_PEREMPUAN));
            if ($totalLaki < 0){
                $totalLaki = 0;
            } else {
                $kurangLaki = $kurangLaki + $totalLaki;
            }
            if ($totalPerempuan < 0){
                $totalPerempuan = 0;
            } else {
                $kurangPerempuan = $kurangPerempuan +$totalPerempuan;
            }
            if ($model->cekPendidikanKualifikasi($row['pendkualifikasi_id'], $row['jeniskelamin']) === true):
                
                 $rows[] = array(
                '<td>'.$modProfil->nokode_rumahsakit.'</td>',
                '<td>'.$modKabupaten->kabupaten_nama.'</td>',
                '<td>'.$modPropinsi->propinsi_nama.'</td>',
                '<td>'.$modProfil->nama_rumahsakit.'</td>',
                '<td></td>',
                '<td style="text-align:center;">'.$no.'</td>',
                '<td>'.$row['pendkualifikasi_nama'].'</td>',
                '<td style = "text-align:right;">'.number_format($model->getSumKeadaan($row['pendkualifikasi_id'],PARAMS::JENIS_KELAMIN_LAKI_LAKI),0,"",".").'</td>',
                '<td style = "text-align:right;">'.number_format($model->getSumKeadaan($row['pendkualifikasi_id'],PARAMS::JENIS_KELAMIN_PEREMPUAN),0,"",".").'</td>',
                '<td style = "text-align:right;">'.number_format($row['jmlkeblaki'],0,"",".").'</td>',
                '<td style = "text-align:right;">'.number_format($row['jmlkebperempuan'],0,"",".").'</td>',
                '<td style = "text-align:right;">'.number_format($totalLaki,0,"",".").'</td>',
                '<td style = "text-align:right;">'.number_format($totalPerempuan,0,"",".").'</td>',                   
                );
            else:    
                $no = $no -1;
                //$rows[] = array();
            endif;
       
        }


        $table = '<table cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'.implode("", $header2).'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        $table .= '<tr>';
        $table .= implode("", $tdCount).'</tr>';
        foreach($rows as $xxx)
        {
            $table .= '<tr>'. implode('', $xxx) . '<tr>';
        }
         $table .= '<tr><td></td><td style = "text-align:right;"><b>Total</b></td><td style = "text-align:right;">' . number_format($model->getSumTotal(PARAMS::JENIS_KELAMIN_LAKI_LAKI),0,"",".") .'</td><td style = "text-align:right;">'
                                                            . number_format($model->getSumTotal(PARAMS::JENIS_KELAMIN_PEREMPUAN),0,"",".") .'</td><td style = "text-align:right;">'
                                                            . number_format($model->getSumkebutuhanL(),0,"",".") .'</td><td style = "text-align:right;">'
                                                            . number_format($model->getSumkebutuhanP(),0,"",".") .'</td><td style = "text-align:right;">'
                                                            . number_format($kurangLaki,0,"",".") .'</td><td style = "text-align:right;">'
                                                            . number_format($kurangPerempuan,0,"",".") .'</td><tr>';
        $table .= '</tbody>';
        $table .= '</table>';
      
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 2',
                    'title'=>'KETENAGAAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        

    }
    /**
     *  Formulir RL 3.1 KUNJUNGAN RD
     */
     public function actionKunjunganRD()
    {         
        $model = new RKRl32KegiatanpelayananrawatdaruratV;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
     
        $criteria=new CDbCriteria;
        $criteria->select = 'propinsi,
                            
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskasuspenyakit_id,
                            jeniskasuspenyakit_nama,
                            SUM(rujukan) AS rujukan,
                            SUM(nonrujukan) AS nonrujukan,
                            SUM(tindaklanjut_dirawat) AS tindaklanjut_dirawat,
                            SUM(tindaklanjut_dirujuk) AS tindaklanjut_dirujuk,
                            SUM(tindaklanjut_pulang) AS tindaklanjut_pulang,
                            SUM(meninggal) AS meninggal,
                            SUM(doa) AS doa';
        $criteria->group = 'propinsi,
                            
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskasuspenyakit_id,
                            jeniskasuspenyakit_nama';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        // $criteria->order = 'jeniskasuspenyakit_nama asc';

        $records = RKRl32KegiatanpelayananrawatdaruratV::model()->findAll($criteria);

        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" rowspan="2" style="text-align:center;">NO</th>', 
            '<th rowspan="2" style="text-align:center;">JENIS PELAYANAN</th>', 
            '<th colspan="2" style="text-align:center;">TOTAL PASIEN</th>',
            '<th colspan="3" style="text-align:center;">TINDAK LANJUT PELAYANAN</th>',
            '<th rowspan="2" style="text-align:center;">MENINGGAL</th>',
            '<th rowspan="2" style="text-align:center;">DOA</th>',
        );
        $header2 = array(
            '<th style="text-align:center;">RUJUKAN</th>', 
            '<th style="text-align:center;">NON RUJUKAN</th>',
            '<th style="text-align:center;">DIRAWAT</th>', 
            '<th style="text-align:center;">DIRUJUK</th>',
            '<th style="text-align:center;">PULANG</th>', 
        );
        $tdCount = array(
            '<td style="text-align:center;background-color:#AFAFAF">1</td>',
            '<td style="text-align:center;background-color:#AFAFAF">2</td>',
            '<td style="text-align:center;background-color:#AFAFAF">3</td>',
            '<td style="text-align:center;background-color:#AFAFAF">4</td>',
            '<td style="text-align:center;background-color:#AFAFAF">5</td>',
            '<td style="text-align:center;background-color:#AFAFAF">6</td>',
            '<td style="text-align:center;background-color:#AFAFAF">7</td>',
            '<td style="text-align:center;background-color:#AFAFAF">8</td>',
            '<td style="text-align:center;background-color:#AFAFAF">9</td>',
        );


        $rows = array();
        $i=0;
        $total_jumlah = 0;
        $no = 0;
        $subno = 0;

        $totRujukan = 0;
        $totNonRujukan = 0;
        $totDirawat = 0;
        $totDirujuk = 0;
        $totPulang = 0;
        $totMeninggal = 0;
        $totDoa = 0;
        
        if (count((array)$records) > 0):
            foreach($records as $row)
            {
                    $no++;
                $rows[] = array(
                    '<td style=text-align:center;>'.$no.'</td>',
                    '<td style="text-align:right;">'.$row['jeniskasuspenyakit_nama'].'</td>',
                    '<td style="text-align:right;">'.number_format($row['rujukan'],0,"",".").'</td>',
                    '<td style="text-align:right;">'.number_format($row['nonrujukan'],0,"",".").'</td>',
                    '<td style="text-align:right;">'.number_format($row['tindaklanjut_dirawat'],0,"",".").'</td>',
                    '<td style="text-align:right;">'.number_format($row['tindaklanjut_dirujuk'],0,"",".").'</td>',
                    '<td style="text-align:right;">'.number_format($row['tindaklanjut_pulang'],0,"",".").'</td>',
                    '<td style="text-align:right;">'.number_format($row['meninggal'],0,"",".").'</td>',
                    '<td style="text-align:right;">'.number_format($row['doa'],0,"",".").'</td>',
                );
                $totRujukan += $row['rujukan'];
                $totNonRujukan += $row['nonrujukan'];
                $totDirawat += $row['tindaklanjut_dirawat'];
                $totDirujuk += $row['tindaklanjut_dirujuk'];
                $totPulang += $row['tindaklanjut_pulang'];
                $totMeninggal += $row['meninggal'];
                $totDoa += $row['doa'];
            }
        else:
            $cr1 = new CDbCriteria();
            $cr1->addCondition('ruangan_id ='.Params::RUANGAN_ID_PERAWATAN_DARURAT);
            $modKasusPenyakitRuangan = KasuspenyakitruanganM::model()->findAll($cr1);
            $ids =[];
            foreach($modKasusPenyakitRuangan as $d){
                $ids[]=$d['jeniskasuspenyakit_id'];
            }

            $criteria = new CDbCriteria();
            // $criteria->join = 'jeniskasuspenyakit_m'
            $criteria->addInCondition('jeniskasuspenyakit_id',$ids);
            $kasuspenyakitruanganigd = JeniskasuspenyakitM::model()->findAll($criteria);
            $x=0;
            foreach($kasuspenyakitruanganigd as $k){
                $rows[] = array(
                    '<td>'.($x+1).'</td>',                
                    '<td>'.$k['jeniskasuspenyakit_nama'].'</td>',       
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                );
                $x++;
            }
           
        endif;
        
        $table = '<table border = "1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>'.'<tr>'.implode("", $header2).'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        $table .= '<tr>';
        $table .= implode("", $tdCount)."</tr>";
        foreach($rows as $xxx)
        {
            $table .= '<tr>'. implode('', $xxx) . '<tr>';
        }
         $table .= '<tr><td style=text-align:center;>99</td><td style="text-align:right"><b>Total</b></td><td style="text-align:right">' .number_format($totRujukan,0,"",".").'</td><td style="text-align:right">'
                                                            .number_format($totNonRujukan,0,"",".").'</td><td style="text-align:right">'
                                                            .number_format($totDirawat,0,"",".").'</td><td style="text-align:right">'
                                                            .number_format($totDirujuk,0,"",".").'</td><td style="text-align:right">'
                                                            .number_format($totPulang,0,"",".").'</td><td style="text-align:right">'
                                                            .number_format($totMeninggal,0,"",".").'</td><td style="text-align:right">'
                                                            .number_format($totDoa,0,"",".").'</td><tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
            );
            $title = "KUNJUNGAN RAWAT DARURAT";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 3.2',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
            $this->layout = '//layouts/iframe';
            $colspan = null;
            $colspan1 = null;
            
             $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.2',
                    'title'=>'KUNJUNGAN RAWAT DARURAT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );       
            
        }else{
            $this->layout = '//layouts/printWindows';
            $colspan = null;
            $colspan1 = null;
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
                $colspan = 3;
                $colspan1 = 4;
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.2',
                    'title'=>'KUNJUNGAN RAWAT DARURAT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }

    }
     /**
     * Print Formulir RL 3.1 KUNJUNGAN RD
     */
     public function actionPrintKunjunganRD()
    {         
        $model = new RKRl32KegiatanpelayananrawatdaruratV;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
     
        $criteria=new CDbCriteria;
        $criteria->select = "propinsi,
                            date_part('year', tgl_laporan) AS tahun,
                            koders,
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskasuspenyakit_id,
                            jeniskasuspenyakit_nama,
                            SUM(rujukan) AS rujukan,
                            SUM(nonrujukan) AS nonrujukan,
                            SUM(tindaklanjut_dirawat) AS tindaklanjut_dirawat,
                            SUM(tindaklanjut_dirujuk) AS tindaklanjut_dirujuk,
                            SUM(tindaklanjut_pulang) AS tindaklanjut_pulang,
                            SUM(meninggal) AS meninggal,
                            SUM(doa) AS doa";
        $criteria->group = "propinsi,
                            date_part('year', tgl_laporan),
                            koders,
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskasuspenyakit_id,
                            jeniskasuspenyakit_nama";
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        // $criteria->order = 'jeniskasuspenyakit_nama asc';

        $records = RKRl32KegiatanpelayananrawatdaruratV::model()->findAll($criteria);

        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" rowspan="2" style="text-align:center;">NO</th>', 
            '<th rowspan="2" style="text-align:center;">JENIS PELAYANAN</th>', 
            '<th colspan="2" style="text-align:center;">TOTAL PASIEN</th>',
            '<th colspan="3" style="text-align:center;">TINDAK LANJUT PELAYANAN</th>',
            '<th rowspan="2" style="text-align:center;">MENINGGAL</th>',
            '<th rowspan="2" style="text-align:center;">DOA</th>',
        );
        $header2 = array(
            '<th style="text-align:center;">KODE PROPINSI</th>',
            '<th style="text-align:center;">KAB/KOTA</th>', 
            '<th style="text-align:center;">KODE RS</th>',
            '<th style="text-align:center;">NAMA RS</th>', 
            '<th style="text-align:center;">TAHUN</th>',
            '<th width="50" style="text-align:center;">NO</th>', 
            '<th style="text-align:center;">JENIS PELAYANAN</th>',
            '<th style="text-align:center;">TOTAL PASIEN RUJUKAN</th>', 
            '<th style="text-align:center;">TOTAL PASIEN NON RUJUKAN</th>',
            '<th style="text-align:center;">TINDAK LANJUT PELAYANAN DIRAWAT</th>', 
            '<th style="text-align:center;">TINDAK LANJUT PELAYANAN DIRUJUK</th>',
            '<th style="text-align:center;">TINDAK LANJUT PELAYANAN PULANG</th>', 
            '<th style="text-align:center;">MATI DI UGD</th>', 
            '<th style="text-align:center;">DOA</th>', 
        );
        $tdCount = array(
            '<td style="text-align:center;background-color:#AFAFAF">1</td>',
            '<td style="text-align:center;background-color:#AFAFAF">2</td>',
            '<td style="text-align:center;background-color:#AFAFAF">3</td>',
            '<td style="text-align:center;background-color:#AFAFAF">4</td>',
            '<td style="text-align:center;background-color:#AFAFAF">5</td>',
            '<td style="text-align:center;background-color:#AFAFAF">6</td>',
            '<td style="text-align:center;background-color:#AFAFAF">7</td>',
            '<td style="text-align:center;background-color:#AFAFAF">8</td>',
            '<td style="text-align:center;background-color:#AFAFAF">9</td>',
        );


        $rows = array();
        $i=0;
        $total_jumlah = 0;
        $no = 0;
        $subno = 0;

        $totRujukan = 0;
        $totNonRujukan = 0;
        $totDirawat = 0;
        $totDirujuk = 0;
        $totPulang = 0;
        $totMeninggal = 0;
        $totDoa = 0;
        
        if (count((array)$records) > 0):
            foreach($records as $row)
            {
                    $no++;
                $rows[] = array(
                    '<td style="text-align:right;">'.$row['propinsi'].'</td>',
                    '<td style="text-align:right;">'.$row['kabupaten'].'</td>',
                    '<td style="text-align:right;">'.$row['koders'].'</td>',
                    '<td style="text-align:right;">'.$row['namars'].'</td>',
                    '<td style="text-align:right;">'.$row['tahun'].'</td>',
                    '<td style=text-align:center;>'.$no.'</td>',
                    '<td style="text-align:right;">'.$row['jeniskasuspenyakit_nama'].'</td>',
                    '<td style="text-align:right;">'.number_format($row['rujukan'],0,"",".").'</td>',
                    '<td style="text-align:right;">'.number_format($row['nonrujukan'],0,"",".").'</td>',
                    '<td style="text-align:right;">'.number_format($row['tindaklanjut_dirawat'],0,"",".").'</td>',
                    '<td style="text-align:right;">'.number_format($row['tindaklanjut_dirujuk'],0,"",".").'</td>',
                    '<td style="text-align:right;">'.number_format($row['tindaklanjut_pulang'],0,"",".").'</td>',
                    '<td style="text-align:right;">'.number_format($row['meninggal'],0,"",".").'</td>',
                    '<td style="text-align:right;">'.number_format($row['doa'],0,"",".").'</td>',
                );
                $totRujukan += $row['rujukan'];
                $totNonRujukan += $row['nonrujukan'];
                $totDirawat += $row['tindaklanjut_dirawat'];
                $totDirujuk += $row['tindaklanjut_dirujuk'];
                $totPulang += $row['tindaklanjut_pulang'];
                $totMeninggal += $row['meninggal'];
                $totDoa += $row['doa'];
            }
        else:
            $rows[] = array(
                    '<td colspan=8><i>Data tidak ditemukan.</i></td>',                
                );
        endif;
        
        $table = '<table border = "1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'.implode("", $header2).'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
       
        foreach($rows as $xxx)
        {
            $table .= '<tr>'. implode('', $xxx) . '<tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
       
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
                $colspan = 3;
                $colspan1 = 4;
            }
            $this->render('print_laporancarabayar',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.2',
                    'title'=>'KUNJUNGAN RAWAT DARURAT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            

    }

    /**
     * Formulir RL 1.3 KEGIATAN KESEHATAN GIGI DAN MULUT
     */
 public function actionGigiMulut()
    {
        $model = new RKRl33KegiatangigimulutV;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        
     
        $criteria=new CDbCriteria;
        $criteria->select = 'propinsi,                            
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskegiatan_id,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama,
                            SUM(jumlah) AS jumlah';
        $criteria->group = 'propinsi,
                            
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskegiatan_id,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama';
        $criteria->order = 'jeniskegiatan_nama asc';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);

        $records = RKRl33KegiatangigimulutV::model()->findAll($criteria);

        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th width="50" style="text-align:center;">NO</th>', 
            '<th style="text-align:center;">JENIS KEGIATAN</th>', 
            '<th style="text-align:center;">JUMLAH</th>',
        );

        $tdCount = array(
            '<td style="text-align:center;background-color:#AFAFAF">1</td>',
            '<td style="text-align:center;background-color:#AFAFAF">2</td>',
            '<td style="text-align:center;background-color:#AFAFAF">3</td>',
        );

        $rows = array();
        $i=0;
        $total_jumlah = 0;
        $no = 0;
        $subno = 0;
        
        if (count((array)$records) > 0):
            foreach($records as $row)
            {
                    $no++;
                $rows[] = array(
                    '<td style="text-align:center;">'.$no.'</td>',
                    '<td>'.$row['jeniskegiatan_nama'].'</td>',
                    '<td style="text-align:right;">'.number_format($row['jumlah'],0,"",".").'</td>',
                );
                $total_jumlah += $row['jumlah'];
            }
        else:

            $cr1 = new CDbCriteria();
            $cr1->compare('jeniskegiatan_ruangan', 'Gigi dan Mulut');
            $modKasusPenyakitRuangan = JeniskegiatanM::model()->findAll($cr1);
            
            $x=0;
            foreach($modKasusPenyakitRuangan as $k){
                $rows[] = array(
                    '<td>'.($x+1).'</td>',                
                    '<td>'.$k['jeniskegiatan_nama'].'</td>',       
                    '<td style="text-align:right;">0</td>',         
                );
                $x++;
            }

            //  $rows[] = array(
            //         '<td colspan=8><i>Data tidak ditemukan.</i></td>',                
            //     );
        endif;


        $table = '<table width="100%" border = "1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        $table .= '<tr>';
        $table .= implode("", $tdCount).'</td>';
        foreach($rows as $xxx)
        {
            $table .= '<tr>'. implode('', $xxx) . '<tr>';
        }
        $table .= '<tr><td style="text-align:center;">99</td><td style = "text-align:right"><b>Total</b></td><td style="background-color:#AFAFAF;text-align:right;">' . number_format($total_jumlah,0,"",".") .'</td>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
            );
            $title = "KEGIATAN KESEHATAN GIGI DAN MULUT";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 3.3',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
            $this->layout = '//layouts/iframe';
            
              $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.3',
                    'title'=>'KEGIATAN KESEHATAN GIGI DAN MULUT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
            
        }else{
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.3',
                    'title'=>'KEGIATAN KESEHATAN GIGI DAN MULUT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }

    }
    
    /**
     * print excel KEGIATAN KESEHATAN GIGI DAN MULUT
     */
 public function actionPrintGigiMulut()
    {
        $model = new RKRl33KegiatangigimulutV;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        
     
        $criteria=new CDbCriteria;
        $criteria->select = "date_part('year', tgl_laporan) AS tahun,
                            propinsi, 
                            koders,
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskegiatan_id,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama,
                            SUM(jumlah) AS jumlah";
        $criteria->group = "date_part('year', tgl_laporan),
                            propinsi,
                            koders,
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskegiatan_id,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama";
        $criteria->order = 'jeniskegiatan_nama asc';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);

        $records = RKRl33KegiatangigimulutV::model()->findAll($criteria);

        $periode = date('d M Y', strtotime($tgl_awal)) . ' sd ' . date('d M Y', strtotime($tgl_akhir));
        $header = array(
            '<th style="text-align:center;vertical-align:middle;">KODE PROPINSI</th>', 
            '<th style="text-align:center;vertical-align:middle;">KAB/KOTA</th>', 
            '<th style="text-align:center;vertical-align:middle;">KODE RS</th>', 
            '<th style="text-align:center;vertical-align:middle;">NAMA RS</th>', 
            '<th style="text-align:center;vertical-align:middle;">TAHUN</th>', 
            '<th width="50" style="text-align:center;">NO</th>', 
            '<th style="text-align:center;">JENIS KEGIATAN</th>', 
            '<th style="text-align:center;">JUMLAH</th>',
        );

        $tdCount = array(
            '<td style="text-align:center;background-color:#AFAFAF">1</td>',
            '<td style="text-align:center;background-color:#AFAFAF">2</td>',
            '<td style="text-align:center;background-color:#AFAFAF">3</td>',
        );

        $rows = array();
        $i=0;
        $total_jumlah = 0;
        $no = 0;
        $subno = 0;
        
        if (count((array)$records) > 0):
            foreach($records as $row)
            {
                    $no++;
                $rows[] = array(
                    '<td>'.$row['propinsi'].'</td>',
                    '<td>'.$row['kabupaten'].'</td>',
                    '<td>'.$row['koders'].'</td>',
                    '<td>'.$row['namars'].'</td>',
                    '<td>'.$row['tahun'].'</td>',
                    '<td style="text-align:center;">'.$no.'</td>',
                    '<td>'.$row['jeniskegiatan_nama'].'</td>',
                    '<td style="text-align:right;">'.number_format($row['jumlah'],0,"",".").'</td>',
                );
                $total_jumlah += $row['jumlah'];
            }
        else:
             $rows[] = array(
                    '<td colspan=8><i>Data tidak ditemukan.</i></td>',                
                );
        endif;


        $table = '<table width="100%" border = "1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        $table .= '<tr>';
        foreach($rows as $xxx)
        {
            $table .= '<tr>'. implode('', $xxx) . '<tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
    
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporanGigimulut',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.3',
                    'title'=>'KEGIATAN KESEHATAN GIGI DAN MULUT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            

    }
    
    /**
     * Formulir RL 1.2 INDIKATOR PELAYANAN RUMAH SAKIT
     */ 
    public function actionKegiatanPelayananRS()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_GET['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria=new CDbCriteria;
        $criteria->select = "date_part('year', tgl_laporan) AS tahun,
                            propinsi,
                            kabupaten,
                            profilrs_id,
                           
                            namars,
                            sum(bor) AS bor,
                            avg(los) AS los,
                            sum(bto) AS bto,
                            avg(toi) AS toi,
                            (sum(ndr)/count(ndr)) AS ndr,
                            (sum(gdr)/count(gdr)) AS gdr";
        $criteria->group = "date_part('year', tgl_laporan),
                            propinsi,
                            kabupaten,
                            profilrs_id,
                          
                            namars";//  koders,
       // $criteria->addCondition("namars = 'RSUD ABEPURA' ");
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl12IndikatorpelayananrumahsakitV::model()->findAll($criteria);

        $criteria2=new CDbCriteria;
        $criteria2->select = "date_part('year', tgl_pendaftaran) AS tahun, 
                            (count(DISTINCT pendaftaran_id)/(date('".$tgl_akhir."')-date('".$tgl_awal."')+1))::double precision AS kunjunganperhari";
        $criteria2->group = "date_part('year', tgl_pendaftaran)";
        $criteria2->addBetweenCondition('tgl_pendaftaran',$tgl_awal,$tgl_akhir);
        $criteria2->addCondition("pasienbatalperiksa_id IS NULL");
        $records2 = RKPendaftaranT::model()->findAll($criteria2);
        
        $kunjungan = array();
        foreach ($records2 as $per){
            $kunjungan['kunjunganperhari'] = $per->kunjunganperhari;
        }
        
        $header = array(
            '<th style="text-align:center;vertical-align:middle;">Tahun</th>', 
            '<th style="text-align:center;vertical-align:middle;">BOR</th>', 
            '<th style="text-align:center;vertical-align:middle;">ALOS</th>',
            '<th style="text-align:center;vertical-align:middle;">BTO</th>',
            '<th style="text-align:center;vertical-align:middle;">TOI</th>',
            '<th style="text-align:center;vertical-align:middle;">NDR</th>',
            '<th style="text-align:center;vertical-align:middle;">GDR</th>',
            '<th style="text-align:center;vertical-align:middle;">Rata-rata<br/>Kunjungan /hari</th>'
        );
        $tdCount = array(
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">1</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">2</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">3</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">4</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">5</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">6</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">7</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">8</td>',
        );

        $rows = array();
        //var_dump($records);die;
        $i=0;
        $total_lh= 0;
        $total_lm= 0;
        $total_ph= 0;
        $total_pm= 0;
        $total_jmlpasien= 0;
        if(count((array)$records) > 0){
            foreach($records as $i=>$record){
                $rows[] = array(
                    '<td style="text-align:center;">'. $record['tahun'].'</td>',
                    '<td style="text-align:center;">'.$record['bor'].'</td>',
                    '<td style="text-align:center;width:100px;">'.$record['los'].'</td>',
                    '<td style="text-align:center;width:100px;">'.$record['bto'].'</td>',
                    '<td style="text-align:center;width:100px;">'.$record['toi'].'</td>',
                    '<td style="text-align:center;">'.$record['ndr'].'</td>',
                    '<td style="text-align:center;">'.$record['gdr'].'</td>',
                    '<td style="text-align:center;">'.$kunjungan['kunjunganperhari'].'</td>',                    
                );                
            }   
        }else{
            $rows[] = array(
                    '<td colspan=8><i>Data tidak ditemukan.</i></td>',                
                );
        }

        $table = '<table border="1"   cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">Tahun</th>', '<th style="text-align:center;">BOR</th>', '<th style="text-align:center;">LOS</th>', '<th style="text-align:center;">BTO</th>','<th style="text-align:center;">TOI</th>','<th style="text-align:center;">NDR</th>','<th style="text-align:center;">GDR</th>','<th style="text-align:center;">Rata-rata <br/> Kunjungan /hari</th>'
            );
            $title = "INDIKATOR PELAYANAN RUMAH SAKIT";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 1.2',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
            $colspan1 = null; 
            $this->layout = '//layouts/iframe';
             $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 1.2',
                    'title'=>'INDIKATOR PELAYANAN RUMAH SAKIT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan1'=>$colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );          
            
            
        }else{
            $colspan1 = null; 
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
                $colspan1 = 3; 
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 1.2',
                    'title'=>'INDIKATOR PELAYANAN RUMAH SAKIT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan1'=>$colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }
    }
    
    /**
     * print excelkegiatan pelayanan
     */
    public function actionPrintKegiatanPelayanan()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_GET['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria=new CDbCriteria;
        $criteria->select = "date_part('year', tgl_laporan) AS tahun,
                            propinsi,
                            kabupaten,
                            profilrs_id,
                            koders,
                            namars,
                            sum(bor) AS bor,
                            avg(los) AS los,
                            sum(bto) AS bto,
                            avg(toi) AS toi,
                            (sum(ndr)/count(ndr)) AS ndr,
                            (sum(gdr)/count(gdr)) AS gdr";
        $criteria->group = "date_part('year', tgl_laporan),
                            propinsi,
                            koders,
                            kabupaten,
                            profilrs_id,
                          
                            namars";//  koders,
       // $criteria->addCondition("namars = 'RSUD ABEPURA' ");
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl12IndikatorpelayananrumahsakitV::model()->findAll($criteria);

        $criteria2=new CDbCriteria;
        $criteria2->select = "date_part('year', tgl_pendaftaran) AS tahun, 
                            (count(DISTINCT pendaftaran_id)/(date('".$tgl_akhir."')-date('".$tgl_awal."')+1))::double precision AS kunjunganperhari";
        $criteria2->group = "date_part('year', tgl_pendaftaran)";
        $criteria2->addBetweenCondition('tgl_pendaftaran',$tgl_awal,$tgl_akhir);
        $criteria2->addCondition("pasienbatalperiksa_id IS NULL");
        $records2 = RKPendaftaranT::model()->findAll($criteria2);
        
        $kunjungan = array();
        foreach ($records2 as $per){
            $kunjungan['kunjunganperhari'] = $per->kunjunganperhari;
        }
        
        $header = array(
            '<th style="text-align:center;vertical-align:middle;">Koders</th>', 
            '<th style="text-align:center;vertical-align:middle;">Kode Propinsi</th>', 
            '<th style="text-align:center;vertical-align:middle;">KAB/KOTA</th>',
            '<th style="text-align:center;vertical-align:middle;">TAHUN</th>',
            '<th style="text-align:center;vertical-align:middle;">BOR</th>',
            '<th style="text-align:center;vertical-align:middle;">ALOS</th>',
            '<th style="text-align:center;vertical-align:middle;">BTO</th>',
            '<th style="text-align:center;vertical-align:middle;">TOI</th>',
            '<th style="text-align:center;vertical-align:middle;">NDR</th>',
            '<th style="text-align:center;vertical-align:middle;">GDR</th>',
            '<th style="text-align:center;vertical-align:middle;">Rata-rata Kunjungan</th>'
        );
        $tdCount = array(
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">1</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">2</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">3</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">4</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">5</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">6</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">7</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">8</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">9</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">10</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">11</td>',
        );
        
         $rows = array();
        //var_dump($records);die;
        $i=0;
        $total_lh= 0;
        $total_lm= 0;
        $total_ph= 0;
        $total_pm= 0;
        $total_jmlpasien= 0;
        if(count((array)$records) > 0){
            foreach($records as $i=>$record){
                $rows[] = array(
                    '<td style="text-align:center;">'. $record['koders'].'</td>',
                    '<td style="text-align:center;">'. $record['propinsi'].'</td>',
                    '<td style="text-align:center;">'. $record['kabupaten'].'</td>',
                    '<td style="text-align:center;">'. $record['tahun'].'</td>',
                    '<td style="text-align:center;">'.$record['bor'].'</td>',
                    '<td style="text-align:center;width:100px;">'.$record['los'].'</td>',
                    '<td style="text-align:center;width:100px;">'.$record['bto'].'</td>',
                    '<td style="text-align:center;width:100px;">'.$record['toi'].'</td>',
                    '<td style="text-align:center;">'.$record['ndr'].'</td>',
                    '<td style="text-align:center;">'.$record['gdr'].'</td>',
                    '<td style="text-align:center;">'.$kunjungan['kunjunganperhari'].'</td>',                    
                );                
            }   
        }else{
            $rows[] = array(
                    '<td colspan=8><i>Data tidak ditemukan.</i></td>',                
                );
        }
        
        $table = '<table border="1"   cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
                $colspan1 = 3; 
            }
            $this->render('print_kegiatanpelayanan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 1.2',
                    'title'=>'INDIKATOR PELAYANAN RUMAH SAKIT',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan1'=>$colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        
    }
    
    /**
     * Formulir RL 3.1 KEGIATAN PELAYANAN RAWAT INAP
     */
    public function actionKegiatanPelayananRawatInap()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria=new CDbCriteria;

        $criteria->select = 'profilrs_id,
                            propinsi,
                            kabupaten,
                            
                            namars,
                            jeniskasuspenyakit_id,
                            jeniskasuspenyakit_nama,
                            sum(pasienawaltahun) AS pasienawaltahun,
                            sum(pasienmasuk) AS pasienmasuk,
                            sum(pasienkeluarhidup) AS pasienkeluarhidup,
                            sum(pasienmatikurang48jam) AS pasienmatikurang48jam,
                            sum(pasienmatilebih48jam) AS pasienmatilebih48jam,
                            sum(lamadirawat) AS lamadirawat,
                            sum(hariperawatan) AS hariperawatan,
                            sum(kelasvvip) AS kelasvvip,
                            sum(kelasvip) AS kelasvip,
                            sum(kelasi) AS kelasi,
                            sum(kelasii) AS kelasii,
                            sum(kelasiii) AS kelasiii,
                            sum(kelaskhusus) AS kelaskhusus,
                            sum(pasienakhirtahun) AS pasienakhirtahun';
        $criteria->group = 'profilrs_id,
                            propinsi,
                            kabupaten,
                            
                            namars,
                            jeniskasuspenyakit_id,
                            jeniskasuspenyakit_nama';
        $criteria->order = 'namars,jeniskasuspenyakit_nama asc';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);//koders,
        
        $records = RKRl31KegiatanpelayananrawatinapV::model()->findAll($criteria);
        $header = array(
            '<th width="50" rowspan=2 style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th rowspan=2 style="text-align:center;vertical-align:middle;">JENIS PELAYANAN</th>', 
            '<th rowspan=2 style="text-align:center;vertical-align:middle;">PASIEN AWAL TAHUN</th>',
            '<th rowspan=2 style="text-align:center;vertical-align:middle;">PASIEN MASUK</th>',
            '<th rowspan=2 style="text-align:center;vertical-align:middle;">PASIEN KELUAR HIDUP</th>',
            '<th colspan=2 style="text-align:center;vertical-align:middle;">PASIEN KELUAR MATI</th>',
            '<th rowspan=2 style="text-align:center;vertical-align:middle;">JUMLAH LAMA DIRAWAT</th>',
            '<th rowspan=2 style="text-align:center;vertical-align:middle;">PASIEN AKHIR TAHUN</th>',
            '<th rowspan=2 style="text-align:center;vertical-align:middle;">JUMLAH HARI PERAWATAN</th>',
            '<th colspan=6 style="text-align:center;vertical-align:middle;">RINCIAN HARI PERAWATAN PER KELAS</th>',
        );
        $header2 = array(
            '<th style="text-align:center;"> < 48 Jam</th>', 
            '<th style="text-align:center;"> >= 48 Jam</th>',
            '<th style="text-align:center;">VVIP</th>', 
            '<th style="text-align:center;">VIP</th>',
            '<th style="text-align: center;">I</th>', 
            '<th style="text-align:center;">II</th>', 
            '<th style="text-align:center;">III</th>', 
            '<th style="text-align:center;">Kelas Khusus</th>', 
        );
        $tdCount = array(
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">1</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">2</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">3</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">4</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">5</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">6</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">7</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">8</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">9</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">10</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">11</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">12</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">13</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">14</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">15</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">16</td>',
        );

        $rows = array();
        $i=0;
        $datas = array();
        foreach($records as $j=>$row)
        {
            $jeniskasuspenyakit_id = $row->jeniskasuspenyakit_id;
            $datas[$jeniskasuspenyakit_id]['jeniskasuspenyakit_id']= $row->jeniskasuspenyakit_id;            
            $datas[$jeniskasuspenyakit_id]['jeniskasuspenyakit_nama'] = $row->jeniskasuspenyakit_nama;
            $datas[$jeniskasuspenyakit_id]['pasienawaltahun'] = $row->pasienawaltahun;
            $datas[$jeniskasuspenyakit_id]['pasienmasuk'] = $row->pasienmasuk;
            $datas[$jeniskasuspenyakit_id]['pasienkeluar'] = $row->pasienkeluarhidup;
            $datas[$jeniskasuspenyakit_id]['pasienmatikurang48jam'] = $row->pasienmatikurang48jam;
            $datas[$jeniskasuspenyakit_id]['pasienmatilebih48jam'] = $row->pasienmatilebih48jam;
            $datas[$jeniskasuspenyakit_id]['lamadirawat'] = $row->lamadirawat;
            $datas[$jeniskasuspenyakit_id]['pasienakhirtahun'] = $row->pasienakhirtahun;
            $datas[$jeniskasuspenyakit_id]['hariperawatan'] = $row->hariperawatan;
            $datas[$jeniskasuspenyakit_id]['rincianhariperawatanvvip'] = $row->kelasvvip;
            $datas[$jeniskasuspenyakit_id]['rincianhariperawatanvip'] = $row->kelasvip;
            $datas[$jeniskasuspenyakit_id]['rincianhariperawatan1'] = $row->kelasi;
            $datas[$jeniskasuspenyakit_id]['rincianhariperawatan2'] = $row->kelasii;
            $datas[$jeniskasuspenyakit_id]['rincianhariperawatan3'] = $row->kelasiii;
            $datas[$jeniskasuspenyakit_id]['rincianhariperawatankelaskhusus'] = $row->kelaskhusus;
                     
        }
        
        $total_awaltahun = 0;
        $total_masuk = 0;
        $total_keluarhidup = 0;
        $total_kurang48 = 0;
        $total_lebih48 = 0;
        $total_lamarawat = 0;
        $total_akhirtahun = 0;
        $total_perawatan = 0;
        $total_vvip = 0;
        $total_vip = 0;
        $total_1 = 0;
        $total_2 = 0;
        $total_3 = 0;
        $total_kelaskhusus = 0;
        if(count((array)$datas) > 0){

            
            foreach($datas as $key=>$data){
                $rows[] = array(
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['jeniskasuspenyakit_nama'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['pasienawaltahun'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['pasienmasuk'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['pasienkeluar'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['pasienmatikurang48jam'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['pasienmatilebih48jam'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['lamadirawat'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['pasienakhirtahun'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['hariperawatan'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rincianhariperawatanvvip'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rincianhariperawatanvip'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rincianhariperawatan1'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rincianhariperawatan2'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rincianhariperawatan3'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rincianhariperawatankelaskhusus'],0,"",".").'</td>',
                );
                $i++;
                $total_awaltahun += $data['pasienawaltahun'];
                $total_masuk += $data['pasienmasuk'];
                $total_keluarhidup += $data['pasienkeluar'];
                $total_kurang48 += $data['pasienmatikurang48jam'];
                $total_lebih48 += $data['pasienmatilebih48jam'];
                $total_lamarawat += $data['lamadirawat'];
                $total_akhirtahun += $data['pasienakhirtahun'];
                $total_perawatan += $data['hariperawatan'];
                $total_vvip += $data['rincianhariperawatanvvip'];
                $total_vip += $data['rincianhariperawatanvip'];
                $total_1 += $data['rincianhariperawatan1'];
                $total_2 += $data['rincianhariperawatan2'];
                $total_3 += $data['rincianhariperawatan3'];
                $total_kelaskhusus += $data['rincianhariperawatankelaskhusus'];
            }   


        }else{
            $modJenisKasusPenyakit = JeniskasuspenyakitM::model()->findAll('jeniskasuspenyakit_aktif = true order by jeniskasuspenyakit_nama asc');
            for($i = 0;$i < count($modJenisKasusPenyakit);$i++){
                $rows[] = array(
                    '<td style="text-align:center;vertical-align:middle;">'.($i + 1).'</td>',                
                    '<td>'.$modJenisKasusPenyakit[$i]['jeniskasuspenyakit_nama'].'</td>',                
                    '<td style="text-align:center;vertical-align:middle;"><span style="text-align:center;">0</span></td>',                                
                    '<td style="text-align:center;vertical-align:middle;"><span style="text-align:center;">0</span></td>',                                
                    '<td style="text-align:center;vertical-align:middle;"><span style="text-align:center;">0</span></td>',                                
                    '<td style="text-align:center;vertical-align:middle;"><span style="text-align:center;">0</span></td>',                                
                    '<td style="text-align:center;vertical-align:middle;"><span style="text-align:center;">0</span></td>',                                
                    '<td style="text-align:center;vertical-align:middle;"><span style="text-align:center;">0</span></td>',                                
                    '<td style="text-align:center;vertical-align:middle;"><span style="text-align:center;">0</span></td>',                                
                    '<td style="text-align:center;vertical-align:middle;"><span style="text-align:center;">0</span></td>',                                
                    '<td style="text-align:center;vertical-align:middle;"><span style="text-align:center;">0</span></td>',                                
                    '<td style="text-align:center;vertical-align:middle;"><span style="text-align:center;">0</span></td>',                                
                    '<td style="text-align:center;vertical-align:middle;"><span style="text-align:center;">0</span></td>',                                
                    '<td style="text-align:center;vertical-align:middle;"><span style="text-align:center;">0</span></td>',                                
                    '<td style="text-align:center;vertical-align:middle;"><span style="text-align:center;">0</span></td>',                                
                    '<td style="text-align:center;vertical-align:middle;"><span style="text-align:center;">0</span></td>',                                
                );
            }
            
        }

        $table = '<table border = "1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>'.'<tr>'.implode("", $header2).'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        $table .= '<tr>';
        $table .= implode("", $tdCount).'</tr>';
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '</tr>';
        }
        $table .= '<tr><td style=text-align:center;>99</td><td><b>Total</b></td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_awaltahun,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_masuk,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_keluarhidup,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_kurang48,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_lebih48,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_lamarawat,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_akhirtahun,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_perawatan,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_vvip,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_vip,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_1,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_2,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_3,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_kelaskhusus,0,"",".") .'</td><tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">Tahun</th>', '<th style="text-align:center;">BOR</th>', '<th style="text-align:center;">LOS</th>', '<th style="text-align:center;">BTO</th>','<th style="text-align:center;">TOI</th>','<th style="text-align:center;">NDR</th>','<th style="text-align:center;">GDR</th>','<th style="text-align:center;">Rata-rata <br/> Kunjungan /hari</th>'
            );
            $title = "KEGIATAN PELAYANAN RAWAT INAP";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 3.1',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
            $this->layout = '//layouts/iframe';
            $colspan = null;
            $colspan1 = null;            
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.1',
                    'title'=>'KEGIATAN PELAYANAN RAWAT INAP',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );          
            
        }else{
            $this->layout = '//layouts/printWindows';
            $colspan = null;
            $colspan1 = null;
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
                $colspan = 10;
                $colspan1 = 6;
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.1',
                    'title'=>'KEGIATAN PELAYANAN RAWAT INAP',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }
    }
     /**
     * Print Formulir RL 3.1 KEGIATAN PELAYANAN RAWAT INAP
     */
    public function actionPrintKegiatanPelayananRawatInap()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria=new CDbCriteria;

        $criteria->select = "
                            date_part('year',tgl_laporan) as tahun,
                            profilrs_id,
                            propinsi,
                            kabupaten,
                            koders,
                            namars,
                            jeniskasuspenyakit_id,
                            jeniskasuspenyakit_nama,
                            sum(pasienawaltahun) AS pasienawaltahun,
                            sum(pasienmasuk) AS pasienmasuk,
                            sum(pasienkeluarhidup) AS pasienkeluarhidup,
                            sum(pasienmatikurang48jam) AS pasienmatikurang48jam,
                            sum(pasienmatilebih48jam) AS pasienmatilebih48jam,
                            sum(lamadirawat) AS lamadirawat,
                            sum(hariperawatan) AS hariperawatan,
                            sum(kelasvvip) AS kelasvvip,
                            sum(kelasvip) AS kelasvip,
                            sum(kelasi) AS kelasi,
                            sum(kelasii) AS kelasii,
                            sum(kelasiii) AS kelasiii,
                            sum(kelaskhusus) AS kelaskhusus,
                            sum(pasienakhirtahun) AS pasienakhirtahun";
        $criteria->group = "date_part('year',tgl_laporan),
                            profilrs_id,
                            propinsi,
                            kabupaten,
                            koders,
                            namars,
                            jeniskasuspenyakit_id,
                            jeniskasuspenyakit_nama";
        $criteria->order = 'namars,jeniskasuspenyakit_nama asc';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);//koders,
        
        $records = RKRl31KegiatanpelayananrawatinapV::model()->findAll($criteria);
        $header = array(
            '<th width="50" rowspan=2 style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th rowspan=2 style="text-align:center;vertical-align:middle;">JENIS PELAYANAN</th>', 
            '<th rowspan=2 style="text-align:center;vertical-align:middle;">PASIEN AWAL TAHUN</th>',
            '<th rowspan=2 style="text-align:center;vertical-align:middle;">PASIEN MASUK</th>',
            '<th rowspan=2 style="text-align:center;vertical-align:middle;">PASIEN KELUAR HIDUP</th>',
            '<th colspan=2 style="text-align:center;vertical-align:middle;">PASIEN KELUAR MATI</th>',
            '<th rowspan=2 style="text-align:center;vertical-align:middle;">JUMLAH LAMA DIRAWAT</th>',
            '<th rowspan=2 style="text-align:center;vertical-align:middle;">PASIEN AKHIR TAHUN</th>',
            '<th rowspan=2 style="text-align:center;vertical-align:middle;">JUMLAH HARI PERAWATAN</th>',
            '<th colspan=6 style="text-align:center;vertical-align:middle;">RINCIAN HARI PERAWATAN PER KELAS</th>',
        );
        $header2 = array(
            '<th style="text-align:center;">KODE RS</th>',
            '<th style="text-align:center;">KODE PROPINSI</th>',
            '<th style="text-align:center;">KAB/KOTA</th>',
            '<th style="text-align:center;">NAMA RS</th>',
            '<th style="text-align:center;">TAHUN</th>',
            '<th width="50" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th style="text-align:center;vertical-align:middle;">JENIS PELAYANAN</th>', 
            '<th style="text-align:center;vertical-align:middle;">PASIEN AWAL TAHUN</th>',
            '<th style="text-align:center;vertical-align:middle;">PASIEN MASUK</th>',
            '<th style="text-align:center;vertical-align:middle;">PASIEN KELUAR HIDUP</th>',
            '<th style="text-align:center;"> < 48 Jam</th>', 
            '<th style="text-align:center;"> >= 48 Jam</th>',
            '<th style="text-align:center;">JUMLAH LAMA DIRAWAT</th>',
            '<th style="text-align:center;">PASIEN AKHIR TAHUN</th>',
            '<th style="text-align:center;">JUMLAH HARI PERAWATAN</th>',
            '<th style="text-align:center;">VVIP</th>', 
            '<th style="text-align:center;">VIP</th>',
            '<th style="text-align: center;">I</th>', 
            '<th style="text-align:center;">II</th>', 
            '<th style="text-align:center;">III</th>', 
            '<th style="text-align:center;">Kelas Khusus</th>', 
        );
        $tdCount = array(
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">1</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">2</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">3</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">4</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">5</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">6</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">7</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">8</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">9</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">10</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">11</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">12</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">13</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">14</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">15</td>',
            '<td style="text-align:center;vertical-align:middle;background-color:#AFAFAF">16</td>',
        );

        $rows = array();
        $i=0;
        $datas = array();
        foreach($records as $j=>$row)
        {
            $jeniskasuspenyakit_id = $row->jeniskasuspenyakit_id;
            $datas[$jeniskasuspenyakit_id]['jeniskasuspenyakit_id']= $row->jeniskasuspenyakit_id;            
            $datas[$jeniskasuspenyakit_id]['jeniskasuspenyakit_nama'] = $row->jeniskasuspenyakit_nama;
            $datas[$jeniskasuspenyakit_id]['pasienawaltahun'] = $row->pasienawaltahun;
            $datas[$jeniskasuspenyakit_id]['koders'] = $row->koders;
            $datas[$jeniskasuspenyakit_id]['propinsi'] = $row->propinsi;
            $datas[$jeniskasuspenyakit_id]['kabupaten'] = $row->kabupaten;
            $datas[$jeniskasuspenyakit_id]['namars'] = $row->namars;
            $datas[$jeniskasuspenyakit_id]['tahun'] = $row->tahun;
            $datas[$jeniskasuspenyakit_id]['pasienmasuk'] = $row->pasienmasuk;
            $datas[$jeniskasuspenyakit_id]['pasienkeluar'] = $row->pasienkeluarhidup;
            $datas[$jeniskasuspenyakit_id]['pasienmatikurang48jam'] = $row->pasienmatikurang48jam;
            $datas[$jeniskasuspenyakit_id]['pasienmatilebih48jam'] = $row->pasienmatilebih48jam;
            $datas[$jeniskasuspenyakit_id]['lamadirawat'] = $row->lamadirawat;
            $datas[$jeniskasuspenyakit_id]['pasienakhirtahun'] = $row->pasienakhirtahun;
            $datas[$jeniskasuspenyakit_id]['hariperawatan'] = $row->hariperawatan;
            $datas[$jeniskasuspenyakit_id]['rincianhariperawatanvvip'] = $row->kelasvvip;
            $datas[$jeniskasuspenyakit_id]['rincianhariperawatanvip'] = $row->kelasvip;
            $datas[$jeniskasuspenyakit_id]['rincianhariperawatan1'] = $row->kelasi;
            $datas[$jeniskasuspenyakit_id]['rincianhariperawatan2'] = $row->kelasii;
            $datas[$jeniskasuspenyakit_id]['rincianhariperawatan3'] = $row->kelasiii;
            $datas[$jeniskasuspenyakit_id]['rincianhariperawatankelaskhusus'] = $row->kelaskhusus;
                     
        }
        
        $total_awaltahun = 0;
        $total_masuk = 0;
        $total_keluarhidup = 0;
        $total_kurang48 = 0;
        $total_lebih48 = 0;
        $total_lamarawat = 0;
        $total_akhirtahun = 0;
        $total_perawatan = 0;
        $total_vvip = 0;
        $total_vip = 0;
        $total_1 = 0;
        $total_2 = 0;
        $total_3 = 0;
        $total_kelaskhusus = 0;
        if(count((array)$datas) > 0){

            
            foreach($datas as $key=>$data){
                $rows[] = array(
                    '<td>'.$data['koders'].'</td>',
                    '<td>'.$data['propinsi'].'</td>',
                    '<td>'.$data['kabupaten'].'</td>',
                    '<td>'.$data['namars'].'</td>',
                    '<td>'.$data['tahun'].'</td>',
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['jeniskasuspenyakit_nama'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['pasienawaltahun'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['pasienmasuk'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['pasienkeluar'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['pasienmatikurang48jam'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['pasienmatilebih48jam'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['lamadirawat'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['pasienakhirtahun'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['hariperawatan'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rincianhariperawatanvvip'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rincianhariperawatanvip'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rincianhariperawatan1'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rincianhariperawatan2'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rincianhariperawatan3'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rincianhariperawatankelaskhusus'],0,"",".").'</td>',
                );
                $i++;
                $total_awaltahun += $data['pasienawaltahun'];
                $total_masuk += $data['pasienmasuk'];
                $total_keluarhidup += $data['pasienkeluar'];
                $total_kurang48 += $data['pasienmatikurang48jam'];
                $total_lebih48 += $data['pasienmatilebih48jam'];
                $total_lamarawat += $data['lamadirawat'];
                $total_akhirtahun += $data['pasienakhirtahun'];
                $total_perawatan += $data['hariperawatan'];
                $total_vvip += $data['rincianhariperawatanvvip'];
                $total_vip += $data['rincianhariperawatanvip'];
                $total_1 += $data['rincianhariperawatan1'];
                $total_2 += $data['rincianhariperawatan2'];
                $total_3 += $data['rincianhariperawatan3'];
                $total_kelaskhusus += $data['rincianhariperawatankelaskhusus'];
            }   


        }else{
            $rows[] = array(
                    '<td colspan=8><i>Data tidak ditemukan.</i></td>',                
                );
        }

        $table = '<table border = "1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'.implode("", $header2).'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '</tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';

            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
                $colspan = 10;
                $colspan1 = 6;
            }
            $this->render('print_laporancarabayar',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.1',
                    'title'=>'KEGIATAN PELAYANAN RAWAT INAP',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
    }
    
    /**
     * Formulir RL 3.4 KEGIATAN KEBIDANAN
     */
    public function actionKegiatanKebidanan()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria=new CDbCriteria;

        $criteria->select = 'propinsi,
                            
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskegiatan_id,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama,
                            SUM(rujukanmedis_rumah_sakit) AS rujukanmedis_rumah_sakit,
                            SUM(rujukanmedis_bidan) AS rujukanmedis_bidan,
                            SUM(rujukanmedis_puskesmas) AS rujukanmedis_puskesmas,
                            SUM(rujukanmedis_faskes_lainnya) AS rujukanmedis_faskes_lainnya,
                            SUM(rujukanmedis_hidup) AS rujukanmedis_hidup,
                            SUM(rujukanmedis_mati) AS rujukanmedis_mati,
                            SUM(rujukanmedis_total) AS rujukanmedis_total,
                            SUM(rujukannonmedis_hidup) AS rujukannonmedis_hidup,
                            SUM(rujukannonmedis_mati) AS rujukannonmedis_mati,
                            SUM(rujukannonmedis_total) AS rujukannonmedis_total,
                            SUM(nonrujukan_hidup) AS nonrujukan_hidup,
                            SUM(nonrujukan_mati) AS nonrujukan_mati,
                            SUM(nonrujukan_total) AS nonrujukan_total,
                            SUM(dirujuk) AS dirujuk';
        $criteria->group = 'propinsi,
                            
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskegiatan_id,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama';
        $criteria->order = 'profilrs_id,namars,jeniskegiatan_nama asc';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        
        $records = RKRl34KegiatankebidananV::model()->findAll($criteria);
        $header = array(
            '<th rowspan=3 style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th rowspan=3 style="text-align:center;vertical-align:middle;">JENIS KEGIATAN</th>', 
            '<th colspan=10 style="text-align:center;vertical-align:middle;">RUJUKAN</th>',
            '<th colspan=3 rowspan=2 style="text-align:center;vertical-align:middle;">NON RUJUKAN</th>',
            '<th rowspan=3 style="text-align:center;vertical-align:middle;">DIRUJUK</th>',
        );
        $header2 = array(
            '<th colspan=7 style="text-align:center;">MEDIS</th>', 
            '<th colspan=3 style="text-align:center;">NON MEDIS</th>',
        );
        $header3 = array(
            '<th style="text-align:center;">RUMAH SAKIT</th>', 
            '<th style="text-align:center;">BIDAN</th>',
            '<th style="text-align:center;">PUSKESMAS</th>',
            '<th style="text-align:center;">FASKES LAINNYA</th>',
            '<th style="text-align:center;">JUMLAH HIDUP</th>',
            '<th style="text-align:center;">JUMLAH MATI</th>',
            '<th style="text-align:center;">JUMLAH TOTAL</th>',
            '<th style="text-align:center;">JUMLAH HIDUP</th>',
            '<th style="text-align:center;">JUMLAH MATI</th>',
            '<th style="text-align:center;">JUMLAH TOTAL</th>',
            '<th style="text-align:center;">JUMLAH HIDUP</th>',
            '<th style="text-align:center;">JUMLAH MATI</th>',
            '<th style="text-align:center;">JUMLAH TOTAL</th>',
        );
        
        $tdCount = array(
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">3</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">4</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">5</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">6</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">7</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">8</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">9</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">10</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">11</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">12</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">13</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">14</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">15</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">16</td>',
        );

        $rows = array();
        $i=0;
        $datas = array();
        foreach($records as $j=>$row)
        {
            $jeniskegiatan_id = $row->jeniskegiatan_id;
            
            $datas[$jeniskegiatan_id]['jeniskegiatan_id']= $row->jeniskegiatan_id;            
            $datas[$jeniskegiatan_id]['jeniskegiatan_nama']= $row->jeniskegiatan_nama;            
            $datas[$jeniskegiatan_id]['rujukanmedis_rumah_sakit']= $row->rujukanmedis_rumah_sakit;            
            $datas[$jeniskegiatan_id]['rujukanmedis_bidan'] = $row->rujukanmedis_bidan;
            $datas[$jeniskegiatan_id]['rujukanmedis_puskesmas'] = $row->rujukanmedis_puskesmas;
            $datas[$jeniskegiatan_id]['rujukanmedis_faskes_lainnya'] = $row->rujukanmedis_faskes_lainnya;
            $datas[$jeniskegiatan_id]['rujukanmedis_hidup'] = $row->rujukanmedis_hidup;
            $datas[$jeniskegiatan_id]['rujukanmedis_mati'] = $row->rujukanmedis_mati;
            $datas[$jeniskegiatan_id]['rujukanmedis_total'] = $row->rujukanmedis_total;
            $datas[$jeniskegiatan_id]['rujukannonmedis_hidup'] = $row->rujukannonmedis_hidup;
            $datas[$jeniskegiatan_id]['rujukannonmedis_mati'] = $row->rujukannonmedis_mati;
            $datas[$jeniskegiatan_id]['rujukannonmedis_total'] = $row->rujukannonmedis_total;
            $datas[$jeniskegiatan_id]['nonrujukan_hidup'] = $row->nonrujukan_hidup;
            $datas[$jeniskegiatan_id]['nonrujukan_mati'] = $row->nonrujukan_mati;
            $datas[$jeniskegiatan_id]['nonrujukan_total'] = $row->nonrujukan_total;
            $datas[$jeniskegiatan_id]['dirujuk'] = $row->dirujuk;
                     
        }
        
        $total_rujukanrs = 0;
        $total_rujukanbidan = 0;
        $total_rujukanpuskemas = 0;
        $total_rujukanfaskeslainnya = 0;
        $total_rujukanjumlahhidup = 0;
        $total_rujukanjumlahmati = 0;
        $total_rujukanjumlahtotal = 0;
        $total_rujukannonmedisjumlahhidup = 0;
        $total_rujukannonmedisjumlahmati = 0;
        $total_rujukannonmedisjumlahtotal = 0;
        $total_nonrujukanjumlahhidup = 0;
        $total_nonrujukanjumlahmati = 0;
        $total_nonrujukanjumlahtotal = 0;
        $total_dirujuk = 0;
            
        if(count((array)$datas) > 0){
            foreach($datas as $key=>$data){
                $rows[] = array(
                    '<td style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['jeniskegiatan_nama'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_rumah_sakit'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_bidan'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_puskesmas'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_faskes_lainnya'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_hidup'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_mati'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_total'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukannonmedis_hidup'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukannonmedis_mati'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukannonmedis_total'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['nonrujukan_hidup'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['nonrujukan_mati'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['nonrujukan_total'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['dirujuk'],0,"",".").'</td>',
                );
                $i++;
                $total_rujukanrs += $data['rujukanmedis_rumah_sakit'];
                $total_rujukanbidan += $data['rujukanmedis_bidan'];
                $total_rujukanpuskemas += $data['rujukanmedis_puskesmas'];
                $total_rujukanfaskeslainnya += $data['rujukanmedis_faskes_lainnya'];
                $total_rujukanjumlahhidup += $data['rujukanmedis_hidup'];
                $total_rujukanjumlahmati += $data['rujukanmedis_mati'];
                $total_rujukanjumlahtotal += $data['rujukanmedis_total'];
                $total_rujukannonmedisjumlahhidup += $data['rujukannonmedis_hidup'];
                $total_rujukannonmedisjumlahmati += $data['rujukannonmedis_mati'];
                $total_rujukannonmedisjumlahtotal += $data['rujukannonmedis_total'];
                $total_nonrujukanjumlahhidup += $data['nonrujukan_hidup'];
                $total_nonrujukanjumlahmati += $data['nonrujukan_mati'];
                $total_nonrujukanjumlahtotal += $data['nonrujukan_total'];
                $total_dirujuk += $data['dirujuk'];
            }   
        }else{
            $cr1 = new CDbCriteria();
            $cr1->compare('jeniskegiatan_ruangan', 'Persalinan/Kebidanan/Perinatologi');
            $modKasusPenyakitRuangan = JeniskegiatanM::model()->findAll($cr1);
            
            $x=0;
            foreach($modKasusPenyakitRuangan as $k){
                $rows[] = array(
                    '<td>'.($x+1).'</td>',                
                    '<td>'.$k['jeniskegiatan_nama'].'</td>',       
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                    '<td style="text-align:right;">0</td>',         
                );
                $x++;
            }

            // $rows[] = array(
            //         // '<td colspan=8><i>Data tidak ditemukan.</i></td>',                
            //     );
        }

        $table = '<table style="width:100%;" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>'.'<tr>'.implode("", $header2).'</tr>'.'<tr>'.implode("", $header3).'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        $table .= '<tr>';
        $table .= implode("", $tdCount).'</tr>';
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
        $table .= '<tr><td style=text-align:center;>99</td><td style = "text-align:right;"><b>Total</b></td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_rujukanrs,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_rujukanbidan,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_rujukanpuskemas,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_rujukanfaskeslainnya,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_rujukanjumlahhidup,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_rujukanjumlahmati,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_rujukanjumlahtotal,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_rujukannonmedisjumlahhidup,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_rujukannonmedisjumlahmati,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_rujukannonmedisjumlahtotal,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_nonrujukanjumlahhidup,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_nonrujukanjumlahmati,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_nonrujukanjumlahtotal,0,"",".") .'</td><td style="background-color:#AFAFAF;text-align:center;vertical-align:middle;">' . number_format($total_dirujuk,0,"",".") .'</td><tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
//            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
//            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
//            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
//            ////$mpdf->useOddEven = 2;
//            $mpdf->AddPage('P','','','','',5,5,5,5,5,5);
            $ukuranKertasPDF =  Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('c',$ukuranKertasPDF); 
    //                    ////$mpdf->useOddEven = 2;  
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);
            
            $header = array(
                '<th style="text-align:center;">Tahun</th>', '<th style="text-align:center;">BOR</th>', '<th style="text-align:center;">LOS</th>', '<th style="text-align:center;">BTO</th>','<th style="text-align:center;">TOI</th>','<th style="text-align:center;">NDR</th>','<th style="text-align:center;">GDR</th>','<th style="text-align:center;">Rata-rata <br/> Kunjungan /hari</th>'
            );
            $footer = '
                    <table width="100%" style="vertical-align: top; font-family:tahoma;font-size: 8pt;"><tr>
                    <td width="50%"></td>
                    <td width="50%" align="right">{PAGENO} / {nb}</td>
                    </tr></table>
                    ';
            $mpdf->SetHTMLFooter($footer);
//            $header = 0.75 * 72 / (72/25.4);                    
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,0,0);
            $title = "KEGIATAN KEBIDANAN";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporanPDF',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 3.4',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/iframe';
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.4',
                    'title'=>'KEGIATAN KEBIDANAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint' => $_GET['caraPrint']
                )
            );       
            
        }else{
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
                $colspan = 9;
                $colspan1 = 8;
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.4',
                    'title'=>'KEGIATAN KEBIDANAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint' => $_GET['caraPrint']
                )
            );            
        }
    }
    
    /**
     * print excel kegiatan kebidanan
     */
    public function actionPrintKegiatanKebidanan(){
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria=new CDbCriteria;

        $criteria->select = "propinsi,
                            date_part('year', tgl_laporan) AS tahun,
                            profilrs_id,
                            kabupaten,
                            koders,
                            namars,
                            jeniskegiatan_id,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama,
                            SUM(rujukanmedis_rumah_sakit) AS rujukanmedis_rumah_sakit,
                            SUM(rujukanmedis_bidan) AS rujukanmedis_bidan,
                            SUM(rujukanmedis_puskesmas) AS rujukanmedis_puskesmas,
                            SUM(rujukanmedis_faskes_lainnya) AS rujukanmedis_faskes_lainnya,
                            SUM(rujukanmedis_hidup) AS rujukanmedis_hidup,
                            SUM(rujukanmedis_mati) AS rujukanmedis_mati,
                            SUM(rujukanmedis_total) AS rujukanmedis_total,
                            SUM(rujukannonmedis_hidup) AS rujukannonmedis_hidup,
                            SUM(rujukannonmedis_mati) AS rujukannonmedis_mati,
                            SUM(rujukannonmedis_total) AS rujukannonmedis_total,
                            SUM(nonrujukan_hidup) AS nonrujukan_hidup,
                            SUM(nonrujukan_mati) AS nonrujukan_mati,
                            SUM(nonrujukan_total) AS nonrujukan_total,
                            SUM(dirujuk) AS dirujuk";
        $criteria->group = "propinsi,
                            date_part('year', tgl_laporan),
                            profilrs_id,
                            kabupaten,
                            koders,
                            namars,
                            jeniskegiatan_id,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama";
        $criteria->order = 'profilrs_id,namars,jeniskegiatan_nama asc';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        
        $records = RKRl34KegiatankebidananV::model()->findAll($criteria);
        $header = array(
            '<th rowspan=3 style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th rowspan=3 style="text-align:center;vertical-align:middle;">JENIS KEGIATAN</th>', 
            '<th colspan=10 style="text-align:center;vertical-align:middle;">RUJUKAN</th>',
            '<th colspan=3 rowspan=2 style="text-align:center;vertical-align:middle;">NON RUJUKAN</th>',
            '<th rowspan=3 style="text-align:center;vertical-align:middle;">DIRUJUK</th>',
        );
        $header2 = array(
            '<th colspan=7 style="text-align:center;">MEDIS</th>', 
            '<th colspan=3 style="text-align:center;">NON MEDIS</th>',
        );
        $header3 = array(
            '<th style="text-align:center;">TAHUN</th>', 
            '<th style="text-align:center;">KODE PROPINSI</th>',
            '<th style="text-align:center;">KODE RS</th>',
            '<th style="text-align:center;">NAMA RS</th>',
            '<th style="text-align:center;">KAB/KOTA</th>',
            '<th style="text-align:center;">NO</th>',
            '<th style="text-align:center;">JENIS KEGIATAN</th>',
            '<th style="text-align:center;">RM RUMAH SAKIT</th>',
            '<th style="text-align:center;">RM BIDAN</th>',
            '<th style="text-align:center;">RM PUSKESMAS</th>',
            '<th style="text-align:center;">RM FASKES LAINNYA</th>',
            '<th style="text-align:center;">RM HIDUP</th>',
            '<th style="text-align:center;">RM MATI</th>',
            '<th style="text-align:center;">RM TOTAL</th>',
            '<th style="text-align:center;">RNM HIDUP</th>',
            '<th style="text-align:center;">RNM MATI</th>',
            '<th style="text-align:center;">RNM TOTAL</th>',
            '<th style="text-align:center;">NR HIDUP</th>',
            '<th style="text-align:center;">NR MATI</th>',
            '<th style="text-align:center;">RNM TOTAL</th>',
            '<th style="text-align:center;">DIRUJUK</th>',
        );
        
        $tdCount = array(
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">3</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">4</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">5</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">6</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">7</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">8</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">9</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">10</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">11</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">12</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">13</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">14</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">15</td>',
            '<td style="text-align:center;vertical-align:middle;" bgcolor="#AFAFAF">16</td>',
        );

        $rows = array();
        $i=0;
        $datas = array();
        foreach($records as $j=>$row)
        {
            $jeniskegiatan_id = $row->jeniskegiatan_id;
            
            $datas[$jeniskegiatan_id]['jeniskegiatan_id']= $row->jeniskegiatan_id;            
            $datas[$jeniskegiatan_id]['jeniskegiatan_nama']= $row->jeniskegiatan_nama;            
            $datas[$jeniskegiatan_id]['rujukanmedis_rumah_sakit']= $row->rujukanmedis_rumah_sakit;            
            $datas[$jeniskegiatan_id]['rujukanmedis_bidan'] = $row->rujukanmedis_bidan;
            $datas[$jeniskegiatan_id]['rujukanmedis_puskesmas'] = $row->rujukanmedis_puskesmas;
            $datas[$jeniskegiatan_id]['rujukanmedis_faskes_lainnya'] = $row->rujukanmedis_faskes_lainnya;
            $datas[$jeniskegiatan_id]['rujukanmedis_hidup'] = $row->rujukanmedis_hidup;
            $datas[$jeniskegiatan_id]['rujukanmedis_mati'] = $row->rujukanmedis_mati;
            $datas[$jeniskegiatan_id]['rujukanmedis_total'] = $row->rujukanmedis_total;
            $datas[$jeniskegiatan_id]['rujukannonmedis_hidup'] = $row->rujukannonmedis_hidup;
            $datas[$jeniskegiatan_id]['rujukannonmedis_mati'] = $row->rujukannonmedis_mati;
            $datas[$jeniskegiatan_id]['rujukannonmedis_total'] = $row->rujukannonmedis_total;
            $datas[$jeniskegiatan_id]['nonrujukan_hidup'] = $row->nonrujukan_hidup;
            $datas[$jeniskegiatan_id]['nonrujukan_mati'] = $row->nonrujukan_mati;
            $datas[$jeniskegiatan_id]['nonrujukan_total'] = $row->nonrujukan_total;
            $datas[$jeniskegiatan_id]['dirujuk'] = $row->dirujuk;
                     
        }
        
        $total_rujukanrs = 0;
        $total_rujukanbidan = 0;
        $total_rujukanpuskemas = 0;
        $total_rujukanfaskeslainnya = 0;
        $total_rujukanjumlahhidup = 0;
        $total_rujukanjumlahmati = 0;
        $total_rujukanjumlahtotal = 0;
        $total_rujukannonmedisjumlahhidup = 0;
        $total_rujukannonmedisjumlahmati = 0;
        $total_rujukannonmedisjumlahtotal = 0;
        $total_nonrujukanjumlahhidup = 0;
        $total_nonrujukanjumlahmati = 0;
        $total_nonrujukanjumlahtotal = 0;
        $total_dirujuk = 0;
            
        if(count((array)$datas) > 0){
            foreach($datas as $key=>$data){
                $rows[] = array(
                     '<td>'.$data['tahun'].'</td>',
                     '<td>'.$data['propinsi'].'</td>',
                     '<td>'.$data['koders'].'</td>',
                     '<td>'.$data['namars'].'</td>',
                     '<td>'.$data['kabupaten'].'</td>',
                    '<td>'.$data['jeniskegiatan_kode'].'</td>',
                    '<td>'.$data['jeniskegiatan_nama'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_rumah_sakit'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_bidan'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_puskesmas'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_faskes_lainnya'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_hidup'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_mati'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_total'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukannonmedis_hidup'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukannonmedis_mati'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukannonmedis_total'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['nonrujukan_hidup'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['nonrujukan_mati'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['nonrujukan_total'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['dirujuk'],0,"",".").'</td>',
                );
                $i++;
                $total_rujukanrs += $data['rujukanmedis_rumah_sakit'];
                $total_rujukanbidan += $data['rujukanmedis_bidan'];
                $total_rujukanpuskemas += $data['rujukanmedis_puskesmas'];
                $total_rujukanfaskeslainnya += $data['rujukanmedis_faskes_lainnya'];
                $total_rujukanjumlahhidup += $data['rujukanmedis_hidup'];
                $total_rujukanjumlahmati += $data['rujukanmedis_mati'];
                $total_rujukanjumlahtotal += $data['rujukanmedis_total'];
                $total_rujukannonmedisjumlahhidup += $data['rujukannonmedis_hidup'];
                $total_rujukannonmedisjumlahmati += $data['rujukannonmedis_mati'];
                $total_rujukannonmedisjumlahtotal += $data['rujukannonmedis_total'];
                $total_nonrujukanjumlahhidup += $data['nonrujukan_hidup'];
                $total_nonrujukanjumlahmati += $data['nonrujukan_mati'];
                $total_nonrujukanjumlahtotal += $data['nonrujukan_total'];
                $total_dirujuk += $data['dirujuk'];
            }   
        }else{
            $rows[] = array(
                    '<td colspan=8><i>Data tidak ditemukan.</i></td>',                
                );
        }

        $table = '<table style="width:100%;" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'.implode("", $header3).'</tr>';
        $table .= '';
        $table .= '';
        $table .= '<tbody>';
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
        
         if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
                $colspan = 9;
                $colspan1 = 8;
            }
            $this->render('print_kegiatankebidanan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.4',
                    'title'=>'KEGIATAN KEBIDANAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint' => $_GET['caraPrint']
                )
            );            
    }
    
    /**
     * Formulir RL 3.7 KEGIATAN RADIOLOGI
     */ 
    public function actionKegiatanRadiologi()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        $periode	= date('d M Y',strtotime($tgl_awal))." - ".date('d M Y',strtotime($tgl_akhir));
        
        $criteria=new CDbCriteria;

        //$criteria->select	= 'propinsi,kabupaten,profilrs_id,koders,namars,jeniskegiatan_kode,jeniskegiatan_nama,sum(jumlah) AS jumlah';
        //$criteria->group	= 'propinsi,kabupaten,profilrs_id,koders,namars,jeniskegiatan_kode,jeniskegiatan_nama';
       // $criteria->order	= 'koders,namars,jeniskegiatan_kode,jeniskegiatan_nama asc';        
        $criteria->select	= 'jeniskegiatan_kode,jeniskegiatan_nama,sum(jumlah) AS jumlah';
        $criteria->group	= 'jeniskegiatan_kode,jeniskegiatan_nama';
        $criteria->order	= 'jeniskegiatan_kode,jeniskegiatan_nama asc';        
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        
        $records = RKRl37KegiatanradiologiV::model()->findAll($criteria);
		
        $criteria2 =  new CDbCriteria();
        $criteria2->group = 'jeniskegiatan_kode';
        $criteria2->select = $criteria2->group;
        $criteria2->order = 'jeniskegiatan_kode';
        $criteria2->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $recordsGroup = RKRl37KegiatanradiologiV::model()->findAll($criteria2);
        
        $header = array(
            '<th width="50" style="text-align:center;">NO. URUT</th>', 
            '<th style="text-align:center;">JENIS KEGIATAN</th>', 
            '<th style="text-align:center;">JUMLAH</th>',
        );
        
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
        );

        $rows = array();
        $judul = array();
        $i=0;
        $total= 0;
        $datas = array();
        $dataGroup = array();
        foreach($records as $j=>$row)
        {
            $jenis = $row->jeniskegiatan_kode;
            $datas[$jenis][$row->jeniskegiatan_nama]['jeniskegiatan_nama'] = $row->jeniskegiatan_nama;
            $datas[$jenis][$row->jeniskegiatan_nama]['jumlah'] = $row->jumlah;                                 
        }
        
        foreach($recordsGroup as $m=>$value){
            $jenis = $value->jeniskegiatan_kode;
            $dataGroup[$jenis]['jeniskegiatan_kode']= $value->jeniskegiatan_kode;           
        }
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        
        if (count((array)$dataGroup) > 0):
            foreach($dataGroup as $key=>$data){
                $table .= '<tr>';
                $table .= '<td colspan=3><b>'.strtoupper($data['jeniskegiatan_kode']).'</b></td></tr>';  
                $a = 0;
                foreach($datas[$data['jeniskegiatan_kode']] as $x => $val)
                {
                    $jmlpasien = $val['jumlah'];
                    $table .= '<tr>';
                    $table .= '<td style=text-align:center;>'. ($a+1).'</td>
                        <td>'.$val['jeniskegiatan_nama'].'</td>
                        <td style=text-align:center;>'.number_format($val['jumlah'],0,"",".").'</td></tr>';
                    $a++;
                    $total += $jmlpasien;
                }
            }   
        else:
            $cr1 = new CDbCriteria();
            $cr1->compare('jeniskegiatan_ruangan', 'Persalinan/Kebidanan/Perinatologi');
            $modKasusPenyakitRuangan = JeniskegiatanM::model()->findAll($cr1);
            
            $x=0;
            foreach($modKasusPenyakitRuangan as $k){
                // $rows[] = array(
                //     '<td>'.($x+1).'</td>',                
                //     '<td>'.$k['jeniskegiatan_nama'].'</td>',       
                       
                // );
                $table .= '<tr>';
                $table .= '<td>'.($x+1).'</td>';
                $table .= '</tr>';

                $x++;
            }
            
        endif;
            
        $table .= '<tr><td></td><td style = "text-align:right;"><b>Total</b></td><td style=text-align:center;>'.number_format($total,0,"",".") .'</td><tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">NO</th>', '<th style="text-align:center;">Jenis Kegiatan</th>', '<th style="text-align:center;">Jumlah</th>'
            );
            $title = "KEGIATAN RADIOLOGI";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 3.7',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
             $this->layout = '//layouts/iframe';         
             $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.7',
                    'title'=>'KEGIATAN RADIOLOGI',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );       
        }else{
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.7',
                    'title'=>'KEGIATAN RADIOLOGI',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }
    }
    /**
     * Print Formulir RL 3.7 KEGIATAN RADIOLOGI
     */ 
    public function actionPrintKegiatanRadiologi()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        $periode	= date('d M Y',strtotime($tgl_awal))." - ".date('d M Y',strtotime($tgl_akhir));
        
        $criteria=new CDbCriteria;

        //$criteria->select	= 'propinsi,kabupaten,profilrs_id,koders,namars,jeniskegiatan_kode,jeniskegiatan_nama,sum(jumlah) AS jumlah';
        //$criteria->group	= 'propinsi,kabupaten,profilrs_id,koders,namars,jeniskegiatan_kode,jeniskegiatan_nama';
       // $criteria->order	= 'koders,namars,jeniskegiatan_kode,jeniskegiatan_nama asc';        
        $criteria->select	= 'jeniskegiatan_kode,jeniskegiatan_nama,sum(jumlah) AS jumlah';
        $criteria->group	= 'jeniskegiatan_kode,jeniskegiatan_nama';
        $criteria->order	= 'jeniskegiatan_kode,jeniskegiatan_nama asc';        
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        
        $records = RKRl37KegiatanradiologiV::model()->findAll($criteria);
		
        $criteria2 =  new CDbCriteria();
        $criteria2->group = 'jeniskegiatan_kode,propinsi,koders,namars,kabupaten,tgl_laporan';
        $criteria2->select = $criteria2->group.",date_part('year',tgl_laporan) as tahun";
        $criteria2->order = 'jeniskegiatan_kode';
        $criteria2->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $recordsGroup = RKRl37KegiatanradiologiV::model()->findAll($criteria2);
        
        $header = array(
            '<th style="text-align:center;">KODE PROPINSI</th>', 
            '<th style="text-align:center;">KAB/KOTA</th>', 
            '<th style="text-align:center;">KODE RS</th>', 
            '<th style="text-align:center;">NAMA RS</th>', 
            '<th style="text-align:center;">TAHUN</th>', 
            '<th width="50" style="text-align:center;">NO. URUT</th>', 
            '<th style="text-align:center;">JENIS KEGIATAN</th>', 
            '<th style="text-align:center;">JUMLAH</th>',
        );
        
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
        );

        $rows = array();
        $judul = array();
        $i=0;
        $total= 0;
        $datas = array();
        $dataGroup = array();
        foreach($records as $j=>$row)
        {
            $jenis = $row->jeniskegiatan_kode;
            $datas[$jenis][$row->jeniskegiatan_nama]['jeniskegiatan_nama'] = $row->jeniskegiatan_nama;
            $datas[$jenis][$row->jeniskegiatan_nama]['jumlah'] = $row->jumlah;                                 
        }
        
        foreach($recordsGroup as $m=>$value){
            $jenis = $value->jeniskegiatan_kode;
            $dataGroup[$jenis]['jeniskegiatan_kode']= $value->jeniskegiatan_kode;           
        }
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        
        if (count((array)$dataGroup) > 0):
            foreach($dataGroup as $key=>$data){
                $table .= '<tr>';
                $table .= '<td colspan=3><b>'.strtoupper($data['jeniskegiatan_kode']).'</b></td></tr>';  
                $a = 0;
                foreach($datas[$data['jeniskegiatan_kode']] as $x => $val)
                {
                    $jmlpasien = $val['jumlah'];
                    $table .= '<tr>';
                    $table .= 
                        '
                        <td>'.$val['propinsi'].'</td>
                        <td>'.$val['kabupaten'].'</td>
                        <td>'.$val['koders'].'</td>
                        <td>'.$val['namars'].'</td>
                        <td>'.$val['tahun'].'</td>
                        <td style=text-align:center;>'. ($a+1).'</td>
                        <td>'.$val['jeniskegiatan_nama'].'</td>
                        <td style=text-align:center;>'.number_format($val['jumlah'],0,"",".").'</td></tr>';
                    $a++;
                    $total += $jmlpasien;
                }
            }   
        else:
            $table .= '<tr>';
            $table .= '<td colspan=8><i>Data tidak ditemukan.</i></td>';
            $table .= '</tr>';
        endif;
            
        $table .= '</tbody>';
        $table .= '</table>';
        
       
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporancarabayar',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.7',
                    'title'=>'KEGIATAN RADIOLOGI',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
    }
    /**
     * Formulir RL 3.8 PEMERIKSAAN LABORATORIUM => dikomen sudah memakai yang baru(RND-8113)
     */
//    public function actionPemeriksaanLaboratorium()
//    {
//        $format = new MyFormatter();
//        $tgl_awal = $format->formatDateTimeForDB($_REQUEST['tgl_awal']);
//        $tgl_akhir = $format->formatDateTimeForDB($_REQUEST['tgl_akhir']);
//        $tanggal_awal = explode('-',$tgl_awal);
//        $tanggal_akhir = explode('-',$tgl_akhir);
//        
//        $tahun_awal = $tanggal_awal[0];
//        $tahun_akhir = $tanggal_akhir[0];
//        
//        if($tahun_awal < $tahun_akhir){
//            $periode = $tahun_awal." - ".$tahun_akhir;
//        }else{
//            $periode = $tahun_akhir;
//        }
//        
//        $criteria2 = new CDbCriteria();
//        $criteria2->group = 'jenispemeriksaanlab_kelompok,jenispemeriksaanlab_nama,pemeriksaanlab_nama';
//        $criteria2->select = $criteria2->group.', sum(jumlah) as jumlah';
//        $criteria2->order = 'pemeriksaanlab_nama';
//        $criteria2->addBetweenCondition('tahun',$tahun_awal,$tahun_akhir);
//        $records = RKRl38KegiatanlaboratoriumV::model()->findAll($criteria2);
//        
//        $criteria=new CDbCriteria;
//
//        $criteria->group = 'tahun, jenispemeriksaanlab_kelompok,jenispemeriksaanlab_nama';
//        $criteria->select = $criteria->group;
//        $criteria->order = 'jenispemeriksaanlab_kelompok';
//        $criteria->addBetweenCondition('tahun',$tahun_awal,$tahun_akhir);
//        
//        $recordsGroup = RKRl38KegiatanlaboratoriumV::model()->findAll($criteria);
//        
//        
//        
//        $header = array(
//            '<th width="50" style="text-align:center;">NO</th>', 
//            '<th style="text-align:center;">JENIS KEGIATAN</th>', 
//            '<th style="text-align:center;">JUMLAH</th>',
//        );
//        
//        $tdCount = array(
//            '<td style="text-align:center;background-color:#AFAFAF">1</td>',
//            '<td style="text-align:center;background-color:#AFAFAF">2</td>',
//            '<td style="text-align:center;background-color:#AFAFAF">3</td>',
//        );
//
//        $rows = array();
//        $judul = array();
//        $i=0;
//        $total= 0;
//        $datas = array();
//        $dataGroup = array();
//        foreach($records as $j=>$row)
//        {
//            $kelompok = $row->jenispemeriksaanlab_kelompok;
//            $datas[$kelompok][$row->pemeriksaanlab_nama]['jenispemeriksaanlab_nama'] = $row->jenispemeriksaanlab_nama;
//            $datas[$kelompok][$row->pemeriksaanlab_nama]['pemeriksaanlab_nama'] = $row->pemeriksaanlab_nama;
//            if (isset($datas[$kelompok][$row->pemeriksaanlab_nama]['jumlah'])){
//                $datas[$kelompok][$row->pemeriksaanlab_nama]['jumlah'] += $row->jumlah;
//            } else {
//                $datas[$kelompok][$row->pemeriksaanlab_nama]['jumlah'] = $row->jumlah;
//            }
//        }
//        
//        foreach($recordsGroup as $m=>$value){
//            $kelompok = $value->jenispemeriksaanlab_kelompok;
//            $dataGroup[$kelompok]['jenispemeriksaanlab_kelompok']= $value->jenispemeriksaanlab_kelompok;           
//            $dataGroup[$kelompok]['jenispemeriksaan'][$m]['jenispemeriksaanlab_nama']= $value->jenispemeriksaanlab_nama;           
//        }
//        
//        $table = '<table width="750" '. ($_GET['caraPrint'] == 'PDF' ? 'border="1"': " ") .' cellpadding="2" cellspacing="0" class="table table-striped table-bordered table-condensed">';
//        $table .= '<thead>';
//        $table .= '<tr>'. implode($header, "") .'</tr>';
//        $table .= '</thead>';
//        $table .= '<tbody>'; 
//        $table .= '<tr>';
//        $table .= implode($tdCount, "");
//        $table .= '</tr>';
//        foreach($dataGroup as $key=>$data){
//            $table .= '<tr>';
//            $table .= '<td colspan=3><b>'.strtoupper($data['jenispemeriksaanlab_kelompok']).'</b></td></tr>';  
////            $jenispemeriksaanlab_nama = $data['jenispemeriksaan'][$i]['jenispemeriksaanlab_nama'];
//            
//            foreach($data['jenispemeriksaan'] as $x => $val)
//            {
//                $table .= '<tr>';
//                $table .= '<td style="background-color:#D8D8D8;text-align:center;">'. ($x+1).'</td>
//                    <td style="background-color:#D8D8D8">'.$val['jenispemeriksaanlab_nama'].'</td>
//                    <td style="background-color:#D8D8D8;text-align:center;"></td></tr>';
//                $total = 0;
//                $no = 0;
//                foreach($datas[$data['jenispemeriksaanlab_kelompok']] as $j => $vals)
//                {
//                    $jmlpasien = $vals['jumlah'];
//                    if($val['jenispemeriksaanlab_nama'] == $vals['jenispemeriksaanlab_nama']){
//                        $table .= '<tr>';
//                        $table .= '<td style=text-align:center;>'. ($x+1).'.'.($no+1).'</li></ol></td>
//                            <td>'.$vals['pemeriksaanlab_nama'].'</td>
//                            <td style=text-align:center;>'.$vals['jumlah'].'</td></tr>';                                          
//                        $no++; 
//                    }
//                    
//                    $total += $jmlpasien;
//                }
//            }
//        }   
//        $table .= '<tr><td></td><td><b>Total</b></td><td style=text-align:center;>'.$total .'</td><tr>';
//        $table .= '</tbody>';
//        $table .= '</table>';
//        
//        if($_GET['caraPrint'] == 'PDF')
//        {
//            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
//            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
//            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
//            ////$mpdf->useOddEven = 2;
//            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
//            
//            $header = array(
//                '<th style="text-align:center;">Tahun</th>', '<th style="text-align:center;">BOR</th>', '<th style="text-align:center;">LOS</th>', '<th style="text-align:center;">BTO</th>','<th style="text-align:center;">TOI</th>','<th style="text-align:center;">NDR</th>','<th style="text-align:center;">GDR</th>','<th style="text-align:center;">Rata-rata <br/> Kunjungan /hari</th>'
//            );
//            
//            $mpdf->WriteHTML(
//                $this->renderPartial('print_laporan',
//                    array(
//                        'width'=>'750',
//                        'formulir'=>'Formulir RL 3.8',
//                        'title'=>'PEMERIKSAAN LABORATORIUM',
//                        'periode'=>$periode,
//                        'table'=>$table,
//                        'caraPrint'=>$_GET['caraPrint']
//                    ), true
//                )
//            );
//            $mpdf->Output();
//        }else{
//            $this->layout = '//layouts/printWindows';
//            if($_GET['caraPrint'] == 'EXCEL')
//            {
//                $this->layout = '//layouts/printExcel';
//            }
//            $this->render('print_laporan',
//                array(
//                    'width'=>'750',
//                    'formulir'=>'Formulir RL 3.8',
//                    'title'=>'PEMERIKSAAN LABORATORIUM',
//                    'periode'=>$periode,
//                    'table'=>$table,
//                    'caraPrint'=>$_GET['caraPrint']
//                )
//            );            
//        }
//    }
	
    /**
     * Formulir RL 3.8 PEMERIKSAAN LABORATORIUM
     */
    public function actionPemeriksaanLaboratorium()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria = new CDbCriteria();     
        $criteria->select = "jeniskegiatanlab_kode, SUM(jumlah) as jumlah, jeniskegiatanlab1, jeniskegiatanlab2, jeniskegiatanlab3";
        $criteria->group = "jeniskegiatanlab_kode, jeniskegiatanlab1, jeniskegiatanlab2, jeniskegiatanlab3";
        $criteria->order = 'jeniskegiatanlab_kode ASC';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl38KegiatanlaboratoriumV::model()->findAll($criteria);
		
        $header = array(
            '<th width="50" style="text-align:center;">NO</th>', 
            '<th style="text-align:center;">JENIS KEGIATAN</th>', 
            '<th style="text-align:center;">JUMLAH</th>',
        );
        
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
        );

        $total= 0;
        $datas = array();
        //var_dump($records);die;
        foreach($records as $j=>$row)
        {
			$datas[$row->jeniskegiatanlab1]['jeniskegiatanlab1'] = $row->jeniskegiatanlab1;
			$datas[$row->jeniskegiatanlab1]['jeniskegiatanlab_kode'] = $row->jeniskegiatanlab_kode;
			$datas[$row->jeniskegiatanlab1]['kegiatan2'][$row->jeniskegiatanlab2]['jeniskegiatanlab2'] = $row->jeniskegiatanlab2;
			$datas[$row->jeniskegiatanlab1]['kegiatan2'][$row->jeniskegiatanlab2]['jeniskegiatanlab_kode'] = $row->jeniskegiatanlab_kode;
			$datas[$row->jeniskegiatanlab1]['kegiatan2'][$row->jeniskegiatanlab2]['kegiatan3'][$row->jeniskegiatanlab3]['jeniskegiatanlab3'] = $row->jeniskegiatanlab3;
			$datas[$row->jeniskegiatanlab1]['kegiatan2'][$row->jeniskegiatanlab2]['kegiatan3'][$row->jeniskegiatanlab3]['jeniskegiatanlab_kode'] = $row->jeniskegiatanlab_kode;
			$datas[$row->jeniskegiatanlab1]['kegiatan2'][$row->jeniskegiatanlab2]['kegiatan3'][$row->jeniskegiatanlab3]['jumlah'] = $row->jumlah;
                        //var_dump($datas[$row->jeniskegiatanlab1]['kegiatan2'][$row->jeniskegiatanlab2]['kegiatan3']);die;
        }
        
        $table = '<table width="100%"  border = "1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        $table .= '<tr><td colspan=3 style=text-align:center;><b>Patologi Klinik</b></td><tr>';
		$table .= '</tr>';
        if (count((array)$datas) > 0):
            foreach($datas as $i=>$data1)
                {
                $table .= '<tr>';
                $table .= '<td><b>'.substr($data1['jeniskegiatanlab_kode'],0,1).'</b></td><td><b>'.strtoupper($data1['jeniskegiatanlab1']).'</b></td><td></td></tr>';
                            foreach($data1['kegiatan2'] as $ii=>$data2){
                                    $table .= '<tr>';
                                    $table .= '<td><b>'.substr($data2['jeniskegiatanlab_kode'],0,3).'</b></td><td><b>&nbsp;&nbsp;&nbsp;&nbsp;'.$data2['jeniskegiatanlab2'].'</b></td><td></tr>';
                                    foreach($data2['kegiatan3'] as $iii=>$data3){
                                            $table .= '<tr>';
                                            $table .= '<td>'.$data3['jeniskegiatanlab_kode'].'</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data3['jeniskegiatanlab3'].'</td><td td style=text-align:center;>'.number_format($data3['jumlah'],0,"",".").'</td></tr>';
                                            $total += $data3['jumlah'];
                                    }
                            }
                    }
        else:
            $table .= '<tr>';
            $table .= '<td colspan=10><i>Data tidak ditemukan.</i></td>';
            $table .= '</tr>';
        endif;                    
		
        $table .= '<tr><td></td><td style=text-align:right;><b>Total</b></td><td style=text-align:center;><b>'.number_format($total,0,"",".") .'</b></td><tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">Tahun</th>', '<th style="text-align:center;">BOR</th>', '<th style="text-align:center;">LOS</th>', '<th style="text-align:center;">BTO</th>','<th style="text-align:center;">TOI</th>','<th style="text-align:center;">NDR</th>','<th style="text-align:center;">GDR</th>','<th style="text-align:center;">Rata-rata <br/> Kunjungan /hari</th>'
            );
            $title = "PEMERIKSAAN LABORATORIUM";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 3.8',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
             $this->layout = '//layouts/iframe';
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.8',
                    'title'=>'PEMERIKSAAN LABORATORIUM',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );                    
        }else{
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.8',
                    'title'=>'PEMERIKSAAN LABORATORIUM',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }
    }
     /**
     * Print Formulir RL 3.8 PEMERIKSAAN LABORATORIUM
     */
     public function actionPrintPemeriksaanLaboratorium()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria = new CDbCriteria();     
        $criteria->select = "tgl_laporan,jeniskegiatanlab_kode, SUM(jumlah) as jumlah, jeniskegiatanlab1, jeniskegiatanlab2, jeniskegiatanlab3";
        $criteria->group = "tgl_laporan, jeniskegiatanlab_kode, jeniskegiatanlab1, jeniskegiatanlab2, jeniskegiatanlab3";
        $criteria->order = 'jeniskegiatanlab_kode ASC';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl38KegiatanlaboratoriumV::model()->findAll($criteria);
		
        $header = array(
            '<th style="text-align:center;">KODE PROPINSI</th>', 
            '<th style="text-align:center;">KAB/KOTA</th>', 
            '<th style="text-align:center;">KODE RS</th>', 
            '<th style="text-align:center;">NAMA RS</th>', 
            '<th style="text-align:center;">TAHUN</th>', 
            '<th width="50" style="text-align:center;">NO</th>', 
            '<th style="text-align:center;">JENIS KEGIATAN</th>', 
            '<th style="text-align:center;">JUMLAH</th>',
        );
        
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
        );
        $modProfil=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $modKabupaten = KabupatenM::model()->findByPk($modProfil->kabupaten_id);
        $modPropinsi = PropinsiM::model()->findByPk($modProfil->propinsi_id);
        $total= 0;
        $datas = array();
        //var_dump($records);die;
        foreach($records as $j=>$row)
        {
                        $datas[$row->jeniskegiatanlab1]['tgl_laporan'] = $row->tgl_laporan;
			$datas[$row->jeniskegiatanlab1]['jeniskegiatanlab1'] = $row->jeniskegiatanlab1;
			$datas[$row->jeniskegiatanlab1]['jeniskegiatanlab_kode'] = $row->jeniskegiatanlab_kode;
			$datas[$row->jeniskegiatanlab1]['kegiatan2'][$row->jeniskegiatanlab2]['jeniskegiatanlab2'] = $row->jeniskegiatanlab2;
			$datas[$row->jeniskegiatanlab1]['kegiatan2'][$row->jeniskegiatanlab2]['jeniskegiatanlab_kode'] = $row->jeniskegiatanlab_kode;
			$datas[$row->jeniskegiatanlab1]['kegiatan2'][$row->jeniskegiatanlab2]['kegiatan3'][$row->jeniskegiatanlab3]['jeniskegiatanlab3'] = $row->jeniskegiatanlab3;
			$datas[$row->jeniskegiatanlab1]['kegiatan2'][$row->jeniskegiatanlab2]['kegiatan3'][$row->jeniskegiatanlab3]['jeniskegiatanlab_kode'] = $row->jeniskegiatanlab_kode;
			$datas[$row->jeniskegiatanlab1]['kegiatan2'][$row->jeniskegiatanlab2]['kegiatan3'][$row->jeniskegiatanlab3]['jumlah'] = $row->jumlah;
                        //var_dump($datas[$row->jeniskegiatanlab1]['kegiatan2'][$row->jeniskegiatanlab2]['kegiatan3']);die;
        }
        
        $table = '<table width="100%"  border = "1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
       
        if (count((array)$datas) > 0):
            foreach($datas as $i=>$data1)
                {
                $table .= '<tr>';
                $table .= '<td><b>'.substr($data1['jeniskegiatanlab_kode'],0,1).'</b></td><td><b>'.strtoupper($data1['jeniskegiatanlab1']).'</b></td><td></td></tr>';
                            foreach($data1['kegiatan2'] as $ii=>$data2){
                                    $table .= '<tr>';
                                    $table .= '<td><b>'.substr($data2['jeniskegiatanlab_kode'],0,3).'</b></td><td><b>&nbsp;&nbsp;&nbsp;&nbsp;'.$data2['jeniskegiatanlab2'].'</b></td><td></tr>';
                                    foreach($data2['kegiatan3'] as $iii=>$data3){
                                            $table .= '<tr>';
                                            $table .= '<td>'.$modPropinsi->propinsi_nama.'</td><td>'.$modKabupaten->kabupaten_nama.'</td><td>'.$modProfil->nokode_rumahsakit.'</td><td>'.$modProfil->nama_rumahsakit.'</td><td>'.date('Y',strtotime($data3['tgl_laporan'])).'</td><td>'.$data3['jeniskegiatanlab_kode'].'</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data3['jeniskegiatanlab3'].'</td><td td style=text-align:center;>'.number_format($data3['jumlah'],0,"",".").'</td></tr>';
                                            $total += $data3['jumlah'];
                                    }
                            }
                    }
        else:
            $table .= '<tr>';
            $table .= '<td colspan=10><i>Data tidak ditemukan.</i></td>';
            $table .= '</tr>';
        endif;                    
		
        $table .= '</tbody>';
        $table .= '</table>';
        
        
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporancarabayar',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.8',
                    'title'=>'PEMERIKSAAN LABORATORIUM',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
    }
    
	/**
     * Formulir RL 3.9 PELAYANAN REHABILITASI MEDIK
     */
    public function actionPelayananRehabMedik()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria = new CDbCriteria();
        $criteria->select = '
                            propinsi,
                          
                            kabupaten,
                            namars,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama,
                            SUM(jumlah) AS jumlah';
        $criteria->group = '
                            propinsi,
                          
                            kabupaten,
                            namars,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama';
        
        $criteria->order = 'propinsi,kabupaten,namars,jeniskegiatan_kode,jeniskegiatan_nama';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl39KegiatanrehabilitasimedisV::model()->findAll($criteria);
        
        
        $header = array(
            '<th width="50" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th style="text-align:center;vertical-align:middle;">JENIS TINDAKAN</th>', 
            '<th style="text-align:center;vertical-align:middle;">JUMLAH</th>',
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
        );

        $rows = array();
        $judul = array();

        $total= 0;
        
        
        $total = 0;           
        
        if(count((array)$records) > 0){
            foreach($records as $i=>$data){
                $rows[] = array(
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['jeniskegiatan_nama'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.$data['jumlah'].'</td>',
                );
                $total += $data['jumlah'];  
            }   
        }else{
            $rows[] = array(
                '<td colspan=3><i>Data tidak ditemukan.</i></td>',                
            );
        }
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>'.'<tr></tr>'.'<tr></tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
        $table .= '<tr><td style="text-align:center;">99</td><td style = "text-align:right;"><b>Total</b></td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total,0,"",".") .'</td>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">Tahun</th>', '<th style="text-align:center;">BOR</th>', '<th style="text-align:center;">LOS</th>', '<th style="text-align:center;">BTO</th>','<th style="text-align:center;">TOI</th>','<th style="text-align:center;">NDR</th>','<th style="text-align:center;">GDR</th>','<th style="text-align:center;">Rata-rata <br/> Kunjungan /hari</th>'
            );
            $title = "PELAYANAN REHABILITASI MEDIK";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 3.9',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
           $this->layout = '//layouts/iframe';
          $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.9',
                    'title'=>'PELAYANAN REHABILITASI MEDIK',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );              
        }else{
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.9',
                    'title'=>'PELAYANAN REHABILITASI MEDIK',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }
    }
    /**
     * Print Formulir RL 3.9 PELAYANAN REHABILITASI MEDIK
     */
     public function actionPrintPelayananRehabMedik()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria = new CDbCriteria();
        $criteria->select = "date_part('year', tgl_laporan) as tahun,
                            propinsi,
                            koders,
                            kabupaten,
                            namars,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama,
                            SUM(jumlah) AS jumlah";
        $criteria->group = "date_part('year', tgl_laporan),
                            propinsi,
                            koders,
                            kabupaten,
                            namars,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama";
        
        $criteria->order = 'propinsi,kabupaten,namars,jeniskegiatan_kode,jeniskegiatan_nama';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl39KegiatanrehabilitasimedisV::model()->findAll($criteria);
        
        
        $header = array(
            '<th style="text-align:center;vertical-align:middle;">KODE PROPINSI</th>', 
            '<th style="text-align:center;vertical-align:middle;">KAB/KOTA</th>', 
            '<th style="text-align:center;vertical-align:middle;">KODE RS</th>', 
            '<th style="text-align:center;vertical-align:middle;">NAMA RS</th>', 
            '<th style="text-align:center;vertical-align:middle;">TAHUN</th>', 
            '<th width="50" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th style="text-align:center;vertical-align:middle;">JENIS TINDAKAN</th>', 
            '<th style="text-align:center;vertical-align:middle;">JUMLAH</th>',
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
        );

        $rows = array();
        $judul = array();

        $total= 0;
        
        
        $total = 0;           
        
        if(count((array)$records) > 0){
            foreach($records as $i=>$data){
                $rows[] = array(
                    '<td>'.$data['propinsi'].'</td>',
                    '<td>'.$data['kabupaten'].'</td>',
                    '<td>'.$data['koders'].'</td>',
                    '<td>'.$data['namars'].'</td>',
                    '<td>'.$data['tahun'].'</td>',
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['jeniskegiatan_nama'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.$data['jumlah'].'</td>',
                );
                $total += $data['jumlah'];  
            }   
        }else{
            $rows[] = array(
                '<td colspan=3><i>Data tidak ditemukan.</i></td>',                
            );
        }
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
        
        $table .= '</tbody>';
        $table .= '</table>';
  
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporancarabayar',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.9',
                    'title'=>'PELAYANAN REHABILITASI MEDIK',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
    }
	
    /**
     * Formulir RL 3.12 KEGIATAN KELUARGA BERENCANA
     */
    public function actionKegiatanKeluargaBerencana()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        $criteria2 = new CDbCriteria();
        $criteria2->group = 'propinsi,
                            kabupaten,
                            koders,
                            namars,
                            metoda';
        $criteria2->select = $criteria2->group.', SUM (konseling_anc) AS konseling_anc,
                            SUM (konseling_pascapersalinan) AS konseling_pascapersalinan,
                            SUM (kbbaru_bukanrujukan) AS kbbaru_bukanrujukan,
                            SUM (kbbaru_rujukanri) AS kbbaru_rujukanri,
                            SUM (kbbaru_rujukanrj) AS kbbaru_rujukanrj,
                            SUM (kunjunganulang) AS kunjunganulang,
                            SUM (keluhanefeksamping_jumlah) AS keluhanefeksamping_jumlah,
                            SUM (keluhanefeksamping_dirujuk) AS keluhanefeksamping_dirujuk';
        $criteria2->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl312KegiatankeluargaberencanaV::model()->findAll($criteria2);
        
        
        $header = array(
            '<th width="50" rowspan="2" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th rowspan="2" style="text-align:center;vertical-align:middle;">METODA</th>', 
            '<th colspan="2" style="text-align:center;vertical-align:middle;">KONSELING</th>',
            '<th colspan="4" style="text-align:center;vertical-align:middle;">KB BARU DENGAN CARA MASUK</th>',
            '<th colspan="3" style="text-align:center;vertical-align:middle;">KB BARU DENGAN KONDISI</th>',
            '<th rowspan="2" style="text-align:center;vertical-align:middle;">KUNJUNGAN ULANG</th>',
            '<th colspan="2" style="text-align:center;vertical-align:middle;">KELUHAN EFEK SAMPING</th>',
        );
        $header2 = array(
            '<th style="text-align:center;vertical-align:middle;">ANC</th>', 
            '<th style="text-align:center;vertical-align:middle;">Pasca Persalinan</th>', 
            '<th style="text-align:center;vertical-align:middle;">BUKAN RUJUKAN</th>',
            '<th style="text-align:center;vertical-align:middle;">RUJUKAN R. INAP</th>',
            '<th style="text-align:center;vertical-align:middle;">RUJUKAN R. JALAN</th>',
            '<th style="text-align:center;vertical-align:middle;">TOTAL</th>',
            '<th style="text-align:center;vertical-align:middle;">PASCA PERSALINAN/NIFAS</th>',
            '<th style="text-align:center;vertical-align:middle;">ABORTUS</th>',
            '<th style="text-align:center;vertical-align:middle;">LAINNYA</th>',
            '<th style="text-align:center;vertical-align:middle;">JUMLAH</th>',
            '<th style="text-align:center;vertical-align:middle;">DIRUJUK</th>',
        );
        
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">7</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">8</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">9</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">10</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">11</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">12</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">13</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">14</td>',
        );

        $rows = array();
        $judul = array();
        $total= 0;

        $total_anc = 0;                     
        $total_pascapersalinan = 0;                        
        $total_bukanrujukan = 0;                        
        $total_rujukanri = 0;        
        $total_rujukanrj = 0;                  
        $total = 0;                       
        $total_pascapersalinannifas = 0;                        
        $total_abortus = 0;                      
        $total_lainnya = 0;                         
        $total_kunjunganulang = 0;                    
        $total_keluhanefeksampingjumlah = 0;                                    
        $total_keluhanefeksampingdirujuk = 0; 

        if(count((array)$records) > 0){
            foreach($records as $i=>$data){
                $rows[] = array(
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['metoda'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['konseling_anc'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['konseling_pascapersalinan'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['kbbaru_bukanrujukan'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['kbbaru_rujukanri'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['kbbaru_rujukanrj'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.'belum'.'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.'belum'.'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.'belum'.'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.'belum'.'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['kunjunganulang'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['keluhanefeksamping_jumlah'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['keluhanefeksamping_dirujuk'],0,"",".").'</td>',
                );

                $total_anc += $data['konseling_anc'];                     
                $total_pascapersalinan += $data['konseling_pascapersalinan'];                               
                $total_bukanrujukan += $data['kbbaru_bukanrujukan'];                               
                $total_rujukanri += $data['kbbaru_rujukanri'];              
                $total_rujukanrj += $data['kbbaru_rujukanrj'];                         
                // $total += $data['total'];                             
                // $total_pascapersalinannifas += $data['pascapersalinannifas'];                              
                // $total_abortus += $data['abortus'];                            
                // $total_lainnya += $data['lainnya'];                                
                $total_kunjunganulang += $data['kunjunganulang'];                           
                $total_keluhanefeksampingjumlah += $data['keluhanefeksamping_jumlah'];                                          
                $total_keluhanefeksampingdirujuk += $data['keluhanefeksamping_dirujuk'];          
            }   
        }else{
            $rows[] = array(
                    '<td colspan=8><i>Data tidak ditemukan.</i></td>',                
                );
        }
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>'.'<tr>'. implode("", $header2) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
        $table .= '<tr><td style="text-align:center;">99</td><td style="text-align:right;"><b>Total</b></td>'
                . '<td style="text-align:center;background-color:#AFAFAF">'.$total_anc .'</td>'
                . '<td style="text-align:center;background-color:#AFAFAF">'.$total_pascapersalinan .'</td>'
                . '<td style="text-align:center;background-color:#AFAFAF">'.$total_bukanrujukan .'</td>'
                . '<td style="text-align:center;background-color:#AFAFAF">'.$total_rujukanri .'</td>'
                . '<td style="text-align:center;background-color:#AFAFAF">'.$total_rujukanrj .'</td>'
                . '<td style="text-align:center;background-color:#AFAFAF">'.$total .'</td>'
                . '<td style="text-align:center;background-color:#AFAFAF"></td>'//$total_pascapersalinannifas
                . '<td style="text-align:center;background-color:#AFAFAF"></td>'//'.$total_abortus .'
                . '<td style="text-align:center;background-color:#AFAFAF"></td>'//'.$total_lainnya .'
                . '<td style="text-align:center;background-color:#AFAFAF">'.$total_kunjunganulang .'</td>'
                . '<td style="text-align:center;background-color:#AFAFAF">'.$total_keluhanefeksampingjumlah .'</td>'
                . '<td style="text-align:center;background-color:#AFAFAF">'.$total_keluhanefeksampingdirujuk .'</td><tr>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">Tahun</th>', '<th style="text-align:center;">BOR</th>', '<th style="text-align:center;">LOS</th>', '<th style="text-align:center;">BTO</th>','<th style="text-align:center;">TOI</th>','<th style="text-align:center;">NDR</th>','<th style="text-align:center;">GDR</th>','<th style="text-align:center;">Rata-rata <br/> Kunjungan /hari</th>'
            );
            $title = "KEGIATAN KELUARGA BERENCANA";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 3.12',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){  
            $colspan=null;
            $colspan1=null;
            $this->layout = '//layouts/iframe';
             $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.12',
                    'title'=>'KEGIATAN KELUARGA BERENCANA',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );             
        }else{
            $colspan=null;
            $colspan1=null;
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan=8;
                $colspan1=6;
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.12',
                    'title'=>'KEGIATAN KELUARGA BERENCANA',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }
    }
    /**
     * print excel keluarga berencana
     */
    public function actionPrintKegiatanKeluargaBerencana()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        $criteria2 = new CDbCriteria();
        $criteria2->group = "date_part('year', tgl_laporan),
                            propinsi,
                            kabupaten,
                            koders,
                            namars,
                            metoda";
        $criteria2->select = $criteria2->group.",date_part('year', tgl_laporan) as tahun, SUM (konseling_anc) AS konseling_anc,
                            SUM (konseling_pascapersalinan) AS konseling_pascapersalinan,
                            SUM (kbbaru_bukanrujukan) AS kbbaru_bukanrujukan,
                            SUM (kbbaru_rujukanri) AS kbbaru_rujukanri,
                            SUM (kbbaru_rujukanrj) AS kbbaru_rujukanrj,
                            SUM (kunjunganulang) AS kunjunganulang,
                            SUM (keluhanefeksamping_jumlah) AS keluhanefeksamping_jumlah,
                            SUM (keluhanefeksamping_dirujuk) AS keluhanefeksamping_dirujuk";
        $criteria2->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl312KegiatankeluargaberencanaV::model()->findAll($criteria2);
        
        
        $header = array(
            '<th width="50" rowspan="2" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th rowspan="2" style="text-align:center;vertical-align:middle;">METODA</th>', 
            '<th colspan="2" style="text-align:center;vertical-align:middle;">KONSELING</th>',
            '<th colspan="4" style="text-align:center;vertical-align:middle;">KB BARU DENGAN CARA MASUK</th>',
            '<th colspan="3" style="text-align:center;vertical-align:middle;">KB BARU DENGAN KONDISI</th>',
            '<th rowspan="2" style="text-align:center;vertical-align:middle;">KUNJUNGAN ULANG</th>',
            '<th colspan="2" style="text-align:center;vertical-align:middle;">KELUHAN EFEK SAMPING</th>',
        );
        $header2 = array(
            '<th style="text-align:center;vertical-align:middle;">KODE PROPINSI</th>',
            '<th style="text-align:center;vertical-align:middle;">KAB/KOTA</th>',
            '<th style="text-align:center;vertical-align:middle;">KODE RS</th>',
            '<th style="text-align:center;vertical-align:middle;">NAMA RS</th>',
            '<th style="text-align:center;vertical-align:middle;">TAHUN</th>',
            '<th width="50" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th style="text-align:center;vertical-align:middle;">METODA</th>',
            '<th style="text-align:center;vertical-align:middle;">KONSELING ANC</th>', 
            '<th style="text-align:center;vertical-align:middle;">KONSELING Pasca Persalinan</th>', 
            '<th style="text-align:center;vertical-align:middle;">KB BARU DENGAN CARA MASUK BUKAN RUJUKAN</th>',
            '<th style="text-align:center;vertical-align:middle;">KB BARU DENGAN CARA MASUK RUJUKAN R. INAP</th>',
            '<th style="text-align:center;vertical-align:middle;">KB BARU DENGAN CARA MASUK RUJUKAN R. JALAN</th>',
            '<th style="text-align:center;vertical-align:middle;">KB BARU DENGAN CARA MASUK TOTAL</th>',
            '<th style="text-align:center;vertical-align:middle;">KB BARU DENGAN KONDISI PASCA PERSALINAN/NIFAS</th>',
            '<th style="text-align:center;vertical-align:middle;">KB BARU DENGAN KONDISI ABORTUS</th>',
            '<th style="text-align:center;vertical-align:middle;">KB BARU DENGAN KONDISI LAINNYA</th>',
            '<th style="text-align:center;vertical-align:middle;">KB BARU DENGAN KONDISI UMLAH</th>',
            '<th style="text-align:center;vertical-align:middle;">KB BARU DENGAN KONDISI DIRUJUK</th>',
        );
        
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">7</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">8</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">9</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">10</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">11</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">12</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">13</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">14</td>',
        );

        $rows = array();
        $judul = array();
        $total= 0;

        $total_anc = 0;                     
        $total_pascapersalinan = 0;                        
        $total_bukanrujukan = 0;                        
        $total_rujukanri = 0;        
        $total_rujukanrj = 0;                  
        $total = 0;                       
        $total_pascapersalinannifas = 0;                        
        $total_abortus = 0;                      
        $total_lainnya = 0;                         
        $total_kunjunganulang = 0;                    
        $total_keluhanefeksampingjumlah = 0;                                    
        $total_keluhanefeksampingdirujuk = 0; 

        if(count((array)$records) > 0){
            foreach($records as $i=>$data){
                $rows[] = array(
                     '<td>'.$data['propinsi'].'</td>',
                     '<td>'.$data['kabupaten'].'</td>',
                     '<td>'.$data['koders'].'</td>',
                     '<td>'.$data['namars'].'</td>',
                     '<td>'.$data['tahun'].'</td>',
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['metoda'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['konseling_anc'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['konseling_pascapersalinan'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['kbbaru_bukanrujukan'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['kbbaru_rujukanri'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['kbbaru_rujukanrj'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.'belum'.'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.'belum'.'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.'belum'.'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.'belum'.'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['kunjunganulang'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['keluhanefeksamping_jumlah'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['keluhanefeksamping_dirujuk'],0,"",".").'</td>',
                );

                $total_anc += $data['konseling_anc'];                     
                $total_pascapersalinan += $data['konseling_pascapersalinan'];                               
                $total_bukanrujukan += $data['kbbaru_bukanrujukan'];                               
                $total_rujukanri += $data['kbbaru_rujukanri'];              
                $total_rujukanrj += $data['kbbaru_rujukanrj'];                         
                                              
                $total_kunjunganulang += $data['kunjunganulang'];                           
                $total_keluhanefeksampingjumlah += $data['keluhanefeksamping_jumlah'];                                          
                $total_keluhanefeksampingdirujuk += $data['keluhanefeksamping_dirujuk'];          
            }   
        }else{
            $rows[] = array(
                    '<td colspan=8><i>Data tidak ditemukan.</i></td>',                
                );
        }
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header2) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
       
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
      
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan=8;
                $colspan1=6;
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_kegiatankeluargaberencana',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.12',
                    'title'=>'KEGIATAN KELUARGA BERENCANA',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
    }
    
    
    /**
     * Formulir RL 3.14 KEGIATAN RUJUKAN
     */
    public function actionKegiatanRujukan()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria2 = new CDbCriteria();
        $criteria2->group = '
                            propinsi,
                           
                            kabupaten,
                            namars,
                            jeniskasuspenyakit_nama';
        $criteria2->select = '
                            propinsi,
                           
                            kabupaten,
                            namars,
                            jeniskasuspenyakit_nama,
                            SUM (rujukan_puskesmas) AS rujukan_puskesmas,
                            SUM (rujukan_faskeslain) AS rujukan_faskeslain,
                            SUM (rujukan_rslain) AS rujukan_rslain,
                            SUM (rujukan_dikembalikan_ke_puskesmas) AS rujukan_dikembalikan_ke_puskesmas,
                            SUM (rujukan_dikembalikan_ke_faskeslain) AS rujukan_dikembalikan_ke_faskeslain,
                            SUM (rujukan_dikembalikan_ke_rs_asal) AS rujukan_dikembalikan_ke_rs_asal,
                            SUM (dirujuk_pasienrujukan) AS dirujuk_pasienrujukan,
                            SUM (dirujuk_pasiennonrujukan) AS dirujuk_pasiennonrujukan,
                            SUM (dirujuk_diterimakembali) AS dirujuk_diterimakembali';
        $criteria2->order = 'jeniskasuspenyakit_nama';
        $criteria2->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl314KegiatanrujukanV::model()->findAll($criteria2);
        
        
        $header = array(
            '<th width="50" rowspan="2" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th rowspan="2" style="text-align:center;vertical-align:middle;">JENIS SPESIALISASI</th>', 
            '<th colspan="6" style="text-align:center;vertical-align:middle;">RUJUKAN</th>',
            '<th colspan="3" style="text-align:center;vertical-align:middle;">DIRUJUKAN</th>',
        );
        $header2 = array(
            '<th style="text-align:center;vertical-align:middle;">DITERIMA DARI PUSKESMAS</th>', 
            '<th style="text-align:center;vertical-align:middle;">DITERIMA DARI FASILITAS KES. LAIN</th>', 
            '<th style="text-align:center;vertical-align:middle;">DITERIMA DARI RS LAIN</th>',
            '<th style="text-align:center;vertical-align:middle;">DIKEMBALIKAN KE PUSKESMAS</th>',
            '<th style="text-align:center;vertical-align:middle;">DIKEMBALIKAN KE FASILITAS KES. LAIN</th>',
            '<th style="text-align:center;vertical-align:middle;">DIKEMBALIKAN KE RS ASAL</th>',
            '<th style="text-align:center;vertical-align:middle;">PASIEN RUJUKAN</th>',
            '<th style="text-align:center;vertical-align:middle;">PASIEN DATANG SENDIRI</th>',
            '<th style="text-align:center;vertical-align:middle;">DITERIMA KEMBALI</th>',
        );
        
        $tdCount = array(
            '<td style="text-align:center;" bgcolor = "#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">7</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">8</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">9</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">10</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">11</td>',
        );

        $rows = array();
        $judul = array();

        $total= 0;

            $total_rujukanpuskesmas = 0;                     
            $total_rujukanfaskeslain = 0;                  
            $total_rujukanrs = 0;         
            $total_kembalipuskesmas = 0;    
            $total_kembalifaskeslain = 0;                  
            $total_kembalirslain = 0;                     
            $total_pasienrujukankeluar = 0;                     
            $total_pasiendatangsendiri = 0;                   
            $total_diterimakembali = 0;      
        if(count((array)$records) > 0){
            foreach($records as $i=>$data){
                $rows[] = array(
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['jeniskasuspenyakit_nama'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukan_puskesmas'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukan_faskeslain'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukan_rslain'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukan_dikembalikan_ke_puskesmas'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukan_dikembalikan_ke_faskeslain'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukan_dikembalikan_ke_rs_asal'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['dirujuk_pasienrujukan'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['dirujuk_pasiennonrujukan'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['dirujuk_diterimakembali'],0,"",".").'</td>',
                );

                $total_rujukanpuskesmas += $data['rujukan_puskesmas'];                    
                $total_rujukanfaskeslain += $data['rujukan_faskeslain'];
                $total_rujukanrs += $data['rujukan_rslain'];         
                $total_kembalipuskesmas += $data['rujukan_dikembalikan_ke_puskesmas'];    
                $total_kembalifaskeslain += $data['rujukan_dikembalikan_ke_faskeslain'];                  
                $total_kembalirslain += $data['rujukan_dikembalikan_ke_rs_asal'];                     
                $total_pasienrujukankeluar += $data['dirujuk_pasienrujukan'];                    
                $total_pasiendatangsendiri += $data['dirujuk_pasiennonrujukan'];                   
                $total_diterimakembali += $data['dirujuk_diterimakembali'];               
            }   
        }else{
            $rows[] = array(
                    '<td colspan=8><i>Data tidak ditemukan.</i></td>',                
                );
        }
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>'.'<tr>'. implode("", $header2) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
        $table .= '<tr><td style="text-align:center;">99</td><td align="right"><b>Total</b></td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.$total_rujukanpuskesmas .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.$total_rujukanfaskeslain .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.$total_rujukanrs .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.$total_kembalipuskesmas .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.$total_kembalifaskeslain .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.$total_kembalirslain .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.$total_pasienrujukankeluar .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.$total_pasiendatangsendiri .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.$total_diterimakembali .'</td>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">Tahun</th>', '<th style="text-align:center;">BOR</th>', '<th style="text-align:center;">LOS</th>', '<th style="text-align:center;">BTO</th>','<th style="text-align:center;">TOI</th>','<th style="text-align:center;">NDR</th>','<th style="text-align:center;">GDR</th>','<th style="text-align:center;">Rata-rata <br/> Kunjungan /hari</th>'
            );
            $title = "KEGIATAN RUJUKAN";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 3.14',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/iframe';
              $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.14',
                    'title'=>'KEGIATAN RUJUKAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );         
        }else{
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 5;
                $colspan1 = 4;
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.14',
                    'title'=>'KEGIATAN RUJUKAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }
    }
     /**
     * fungsi untuk menampilkan halaman kegiatan rujukan
     */
     public function actionPrintKegiatanRujukan()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria2 = new CDbCriteria();
        $criteria2->group = "
                            date_part('year',tgl_laporan),
                            propinsi,
                            koders,
                            kabupaten,
                            namars,
                            jeniskasuspenyakit_nama";
        $criteria2->select = "
                            date_part('year',tgl_laporan) as tahun,
                            propinsi,
                            koders,
                            kabupaten,
                            namars,
                            jeniskasuspenyakit_nama,
                            SUM (rujukan_puskesmas) AS rujukan_puskesmas,
                            SUM (rujukan_faskeslain) AS rujukan_faskeslain,
                            SUM (rujukan_rslain) AS rujukan_rslain,
                            SUM (rujukan_dikembalikan_ke_puskesmas) AS rujukan_dikembalikan_ke_puskesmas,
                            SUM (rujukan_dikembalikan_ke_faskeslain) AS rujukan_dikembalikan_ke_faskeslain,
                            SUM (rujukan_dikembalikan_ke_rs_asal) AS rujukan_dikembalikan_ke_rs_asal,
                            SUM (dirujuk_pasienrujukan) AS dirujuk_pasienrujukan,
                            SUM (dirujuk_pasiennonrujukan) AS dirujuk_pasiennonrujukan,
                            SUM (dirujuk_diterimakembali) AS dirujuk_diterimakembali";
        $criteria2->order = 'jeniskasuspenyakit_nama';
        $criteria2->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl314KegiatanrujukanV::model()->findAll($criteria2);
        
        
        $header = array(
            '<th width="50" rowspan="2" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th rowspan="2" style="text-align:center;vertical-align:middle;">JENIS SPESIALISASI</th>', 
            '<th colspan="6" style="text-align:center;vertical-align:middle;">RUJUKAN</th>',
            '<th colspan="3" style="text-align:center;vertical-align:middle;">DIRUJUKAN</th>',
        );
        $header2 = array(
            '<th style="text-align:center;vertical-align:middle;">KODE PROPINSI</th>', 
            '<th style="text-align:center;vertical-align:middle;">KAB/KOTA</th>', 
            '<th style="text-align:center;vertical-align:middle;">KODE RS</th>', 
            '<th style="text-align:center;vertical-align:middle;">NAMA RS</th>', 
            '<th style="text-align:center;vertical-align:middle;">TAHUN</th>', 
            '<th width="50" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th style="text-align:center;vertical-align:middle;">JENIS SPESIALISASI</th>', 
            '<th style="text-align:center;vertical-align:middle;">RUJUKAN DITERIMA DARI PUSKESMAS</th>', 
            '<th style="text-align:center;vertical-align:middle;">RUJUKAN DITERIMA DARI FASILITAS KES. LAIN</th>', 
            '<th style="text-align:center;vertical-align:middle;">RUJUKAN DITERIMA DARI RS LAIN</th>',
            '<th style="text-align:center;vertical-align:middle;">RUJUKAN DIKEMBALIKAN KE PUSKESMAS</th>',
            '<th style="text-align:center;vertical-align:middle;">RUJUKAN DIKEMBALIKAN KE FASILITAS KES. LAIN</th>',
            '<th style="text-align:center;vertical-align:middle;">RUJUKAN DIKEMBALIKAN KE RS ASAL</th>',
            '<th style="text-align:center;vertical-align:middle;">DIRUJUKAN PASIEN RUJUKAN</th>',
            '<th style="text-align:center;vertical-align:middle;">DIRUJUKAN PASIEN DATANG SENDIRI</th>',
            '<th style="text-align:center;vertical-align:middle;">DIRUJUKAN DITERIMA KEMBALI</th>',
        );
        
        $tdCount = array(
            '<td style="text-align:center;" bgcolor = "#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">7</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">8</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">9</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">10</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">11</td>',
        );

        $rows = array();
        $judul = array();

        $total= 0;

            $total_rujukanpuskesmas = 0;                     
            $total_rujukanfaskeslain = 0;                  
            $total_rujukanrs = 0;         
            $total_kembalipuskesmas = 0;    
            $total_kembalifaskeslain = 0;                  
            $total_kembalirslain = 0;                     
            $total_pasienrujukankeluar = 0;                     
            $total_pasiendatangsendiri = 0;                   
            $total_diterimakembali = 0;      
        if(count((array)$records) > 0){
            foreach($records as $i=>$data){
                $rows[] = array(
                    '<td>'.$data['propinsi'].'</td>',
                    '<td>'.$data['kabupaten'].'</td>',
                    '<td>'.$data['koders'].'</td>',
                    '<td>'.$data['namars'].'</td>',
                    '<td>'.$data['tahun'].'</td>',
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['jeniskasuspenyakit_nama'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukan_puskesmas'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukan_faskeslain'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukan_rslain'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukan_dikembalikan_ke_puskesmas'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukan_dikembalikan_ke_faskeslain'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukan_dikembalikan_ke_rs_asal'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['dirujuk_pasienrujukan'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['dirujuk_pasiennonrujukan'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['dirujuk_diterimakembali'],0,"",".").'</td>',
                );

                $total_rujukanpuskesmas += $data['rujukan_puskesmas'];                    
                $total_rujukanfaskeslain += $data['rujukan_faskeslain'];
                $total_rujukanrs += $data['rujukan_rslain'];         
                $total_kembalipuskesmas += $data['rujukan_dikembalikan_ke_puskesmas'];    
                $total_kembalifaskeslain += $data['rujukan_dikembalikan_ke_faskeslain'];                  
                $total_kembalirslain += $data['rujukan_dikembalikan_ke_rs_asal'];                     
                $total_pasienrujukankeluar += $data['dirujuk_pasienrujukan'];                    
                $total_pasiendatangsendiri += $data['dirujuk_pasiennonrujukan'];                   
                $total_diterimakembali += $data['dirujuk_diterimakembali'];               
            }   
        }else{
            $rows[] = array(
                    '<td colspan=8><i>Data tidak ditemukan.</i></td>',                
                );
        }
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header2) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
    
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 5;
                $colspan1 = 4;
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporancarabayar',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.14',
                    'title'=>'KEGIATAN RUJUKAN',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
    }
    
    /**
     * Formulir RL 3.10 KEGIATAN PELAYANAN KHUSUS
     */
    public function actionKegiatanPelayananKhusus()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria = new CDbCriteria();
        $criteria->group = '
                            propinsi,
                           
                            kabupaten,
                            namars,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama';
        $criteria->select = $criteria->group.', sum(jumlah) as jumlah';
        $criteria->order = 'jeniskegiatan_nama';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl310KegiatanpelayanankhususV::model()->findAll($criteria);
        
        
        $header = array(
            '<th width="50" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th style="text-align:center;vertical-align:middle;">JENIS KEGIATAN</th>', 
            '<th style="text-align:center;vertical-align:middle;">JUMLAH</th>',
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
        );

        $rows = array();
        $judul = array();
        $total= 0;
        $datas = array();
                   
        if(count((array)$records) > 0){
            foreach($records as $i=>$data){
                $rows[] = array(
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['jeniskegiatan_nama'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['jumlah'],0,"",".").'</td>',
                );
                $total += $data['jumlah'];                            
            }   
        }else{
            $rows[] = array(
                '<td colspan=3><i>Data tidak ditemukan.</i></td>',                
            );
        }
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
        $table .= '<tr><td style="text-align:center;">99</td><td style="text-align:right;"><b>Total</b></td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total,0,"",".") .'</td>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">Tahun</th>', '<th style="text-align:center;">BOR</th>', '<th style="text-align:center;">LOS</th>', '<th style="text-align:center;">BTO</th>','<th style="text-align:center;">TOI</th>','<th style="text-align:center;">NDR</th>','<th style="text-align:center;">GDR</th>','<th style="text-align:center;">Rata-rata <br/> Kunjungan /hari</th>'
            );
            $title = "KEGIATAN PELAYANAN KHUSUS";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 3.10',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){            
            $this->layout = '//layouts/iframe';
             $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.10',
                    'title'=>'KEGIATAN PELAYANAN KHUSUS',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );     
            
        }else{
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.10',
                    'title'=>'KEGIATAN PELAYANAN KHUSUS',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }
    }
     /**
     * fungsi untuk menampilkan halaman kegiatan pelayanan
     */
     public function actionPrintKegiatanPelayananKhusus()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria = new CDbCriteria();
        $criteria->group = "
                            date_part('year',tgl_laporan),
                            propinsi,
                            koders,
                            kabupaten,
                            namars,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama";
        $criteria->select = $criteria->group.", date_part('year',tgl_laporan) as tahun, sum(jumlah) as jumlah";
        $criteria->order = 'jeniskegiatan_nama';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl310KegiatanpelayanankhususV::model()->findAll($criteria);
        
        
        $header = array(
            '<th style="text-align:center;vertical-align:middle;">KODE PROPINSI</th>', 
            '<th style="text-align:center;vertical-align:middle;">KAB/KOTA</th>', 
            '<th style="text-align:center;vertical-align:middle;">KODE RS</th>', 
            '<th style="text-align:center;vertical-align:middle;">NAMA RS</th>', 
            '<th style="text-align:center;vertical-align:middle;">TAHUN</th>', 
            '<th width="50" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th style="text-align:center;vertical-align:middle;">JENIS KEGIATAN</th>', 
            '<th style="text-align:center;vertical-align:middle;">JUMLAH</th>',
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
        );

        $rows = array();
        $judul = array();
        $total= 0;
        $datas = array();
                   
        if(count((array)$records) > 0){
            foreach($records as $i=>$data){
                $rows[] = array(
                    '<td>'.$data['propinsi'].'</td>',
                    '<td>'.$data['kabupaten'].'</td>',
                    '<td>'.$data['koders'].'</td>',
                    '<td>'.$data['namars'].'</td>',
                    '<td>'.$data['tahun'].'</td>',
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['jeniskegiatan_nama'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['jumlah'],0,"",".").'</td>',
                );
                $total += $data['jumlah'];                            
            }   
        }else{
            $rows[] = array(
                '<td colspan=3><i>Data tidak ditemukan.</i></td>',                
            );
        }
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
       
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
        
        $table .= '</tbody>';
        $table .= '</table>';
        
       
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporancarabayar',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.10',
                    'title'=>'KEGIATAN PELAYANAN KHUSUS',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
    }
    
    /**
     * Formulir RL 3.15 CARA BAYAR
     */
    public function actionCaraBayar()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria = new CDbCriteria();
        $criteria->group = '
                            propinsi,
                            
                            kabupaten,
                            namars,
                            carabayar_id,
                            carabayar_nama,
                            carapembayaran_kode,
                            carapembayaran_nama';
        $criteria->select = $criteria->group.', SUM(pasienrawatinapkeluar) AS pasienrawatinaplamadirawat,
                                                SUM(pasienrawatinaplamadirawat) AS pasienrawatinaplamadirawat,
                                                SUM(pasienrawatjalan) AS pasienrawatjalan,
                                                SUM(pasienlaboratorium) AS pasienlaboratorium,
                                                SUM(pasienradiologi) AS pasienradiologi,
                                                SUM(pasienrawatjalanlain) AS pasienrawatjalanlain';
        $criteria->order = 'carabayar_id,carapembayaran_nama';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl315KegiatancarabayarV::model()->findAll($criteria);
        
        $criteria2=new CDbCriteria;
        $criteria2->group = 'carabayar_id, carabayar_nama';
        $criteria2->select = $criteria2->group;
        $criteria2->order = 'carabayar_id';
        $criteria2->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);       
        $recordsGroup = RKRl315KegiatancarabayarV::model()->findAll($criteria2);
        
        
        $header = array(
            '<td rowspan="2" width="50px" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<td rowspan="2" width="250px" style="text-align:center;vertical-align:middle;">CARA PEMBAYARAN</th>', 
            '<td colspan="2" width="150px" style="text-align:center;vertical-align:middle;">PASIEN RAWAT INAP</th>',
            '<td rowspan="2" width="75px" style="text-align:center;vertical-align:middle;">JUMLAH PASIEN RAWAT JALAN</th>',
            '<td colspan="3" width="225px" style="text-align:center;vertical-align:middle;">JUMLAH PASIEN RAWAT JALAN</th>',
        );
        $header2 = array(
            '<td width="75px" style="text-align:center;vertical-align:middle;">JUMLAH PASIEN KELUAR</th>', 
            '<td width="75px"  style="text-align:center;vertical-align:middle;">JUMLAH LAMA DIRAWAT (Hari)</th>', 
            '<td width="75px" style="text-align:center;vertical-align:middle;">LABO<BR/>RATORIUM</th>',
            '<td width="75px" style="text-align:center;vertical-align:middle;">RADIOLOGI</th>',
            '<td width="75px" style="text-align:center;vertical-align:middle;">LAIN-LAIN</th>',
        );
        $tdCount = array(
            '<td width="50px" style="text-align:center;" bgcolor = "#AFAFAF">1</td>',
            '<td width="250px" style="text-align:center;" bgcolor = "#AFAFAF">2</td>',
            '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">3</td>',
            '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">4</td>',
            '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">5</td>',
            '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">6</td>',
            '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">7</td>',
            '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">8</td>',
        );

        $rows = array();
        $judul = array();
        $i=0;
        $datas = array();
        $dataGroup = array();
        
        $total_pasienrikeluar = 0;
        $total_pasienrilamadirawat = 0;
        $total_pasienrj = 0;
        $total_pasienrjlab = 0;
        $total_pasienrjrad = 0;                     
        $total_pasienrjlain = 0;
            

        foreach($records as $j=>$row)
        {
            $carabayar = $row->carabayar_nama;
            $datas[$carabayar][$row->carapembayaran_nama]['carabayar_nama'] = $row->carabayar_nama;
            $datas[$carabayar][$row->carapembayaran_nama]['carapembayaran_nama'] = $row->carapembayaran_nama;
            if (isset($datas[$carabayar][$row->carapembayaran_nama]['pasienrikeluar'])){
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrikeluar'] += $row->pasienrawatinapkeluar;
            } else {
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrikeluar'] = $row->pasienrawatinapkeluar;
            }
            if (isset($datas[$carabayar][$row->carapembayaran_nama]['pasienrilamadirawat'])){
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrilamadirawat'] += $row->pasienrawatinaplamadirawat;
            } else {
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrilamadirawat'] = $row->pasienrawatinaplamadirawat;
            }
            if (isset($datas[$carabayar][$row->carapembayaran_nama]['pasienrj'])){
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrj'] += $row->pasienrawatjalan;
            } else {
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrj'] = $row->pasienrawatjalan;
            }
            if (isset($datas[$carabayar][$row->carapembayaran_nama]['pasienrjlab'])){
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrjlab'] += $row->pasienlaboratorium;
            } else {
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrjlab'] = $row->pasienlaboratorium;
            }
            if (isset($datas[$carabayar][$row->carapembayaran_nama]['pasienrjrad'])){
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrjrad'] += $row->pasienradiologi;
            } else {
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrjrad'] = $row->pasienradiologi;
            }
            if (isset($datas[$carabayar][$row->carapembayaran_nama]['pasienrjlain'])){
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrjlain'] += $row->pasienrawatjalanlain;
            } else {
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrjlain'] = $row->pasienrawatjalanlain;
            }                                 
        }
        
        foreach($recordsGroup as $m=>$value){
            $carabayar = $value->carabayar_nama;
            $dataGroup[$carabayar]['carabayar_nama']= $value->carabayar_nama;           
            $dataGroup[$carabayar]['carabayar'][$m]['carabayar_nama'] = $value->carabayar_nama;           
        }
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class = "border table">';
        $table .= '';
        $table .= '<tr style="font-weight:bold;">'. implode("", $header) .'</tr>'.'<tr style="font-weight:bold;">'. implode("", $header2) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr style="font-weight:bold;">';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        
        $i = 0;   
        if(count((array)$dataGroup) > 0){
            foreach($dataGroup as $key=>$data){
                $table .='';
                $table .= '<tr>';
                $table .= '<td width="50px" style="text-align:center;vertical-align:center;"><b>'.($i+1).'</b></td>';  
                $table .= '<td colspan=7><b>'.strtoupper($data['carabayar_nama']).'</b></td></tr>';  
                $table .= '';
                $carabayar_nama = $data['carabayar_nama'];

                $no = 0;
                foreach($datas[$data['carabayar_nama']] as $j => $vals)
                {
                    if($carabayar_nama == $vals['carabayar_nama']){
                        $table .='';
                        $table .='';
                        $table .= '<tr>';
                        $table .= '<td width="50px" style=text-align:center;>'. ($i+1).'.'.($no+1).'</li></ol></td>
                            <td width="250px">'.$vals['carapembayaran_nama'].'</td>
                            <td width="75px" style=text-align:center;>'.number_format($vals['pasienrikeluar'],0,"",".").'</td>                                        
                            <td width="75px" style=text-align:center;>'.number_format($vals['pasienrilamadirawat'],0,"",".").'</td>                                          
                            <td width="75px" style=text-align:center;>'.number_format($vals['pasienrj'],0,"",".").'</td>                                     
                            <td width="75px" style=text-align:center;>'.number_format($vals['pasienrjlab'],0,"",".").'</td>                                   
                            <td width="75px" style=text-align:center;>'.number_format($vals['pasienrjrad'],0,"",".").'</td>                                     
                            <td width="75px" style=text-align:center;>'.number_format($vals['pasienrjlain'],0,"",".").'</td></tr>';                                          
                        $no++; 
                    }

                    $total_pasienrikeluar += $vals['pasienrikeluar'];
                    $total_pasienrilamadirawat += $vals['pasienrilamadirawat'];
                    $total_pasienrj += $vals['pasienrj'];
                    $total_pasienrjlab += $vals['pasienrjlab'];
                    $total_pasienrjrad += $vals['pasienrjrad'];                     
                    $total_pasienrjlain += $vals['pasienrjlain'];
                }
                $i++;
            }   
        }else{
            $table .='<tr><td colspan=8><i>Data tidak ditemukan.</i></td></tr>';
        }
        $table .= '<tr>'
                . '<td width="50px" style="text-align:center;">99</td>'
                . '<td width="250px" ><b>Total</b></td>'
                . '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">'.number_format($total_pasienrikeluar,0,"",".") .'</td>'
                . '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">'.number_format($total_pasienrilamadirawat,0,"",".") .'</td>'
                . '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">'.number_format($total_pasienrj,0,"",".") .'</td>'
                . '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">'.number_format($total_pasienrjlab,0,"",".") .'</td>'
                . '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">'.number_format($total_pasienrjrad,0,"",".") .'</td>'
                . '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">'.number_format($total_pasienrjlain,0,"",".") .'</td>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">Tahun</th>', '<th style="text-align:center;">BOR</th>', '<th style="text-align:center;">LOS</th>', '<th style="text-align:center;">BTO</th>','<th style="text-align:center;">TOI</th>','<th style="text-align:center;">NDR</th>','<th style="text-align:center;">GDR</th>','<th style="text-align:center;">Rata-rata <br/> Kunjungan /hari</th>'
            );
            $title = 'Jenis Penjamin';
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 3.15',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
            
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/iframe'; 
             $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.15',
                    'title'=>'CARA BAYAR',
                    'periode'=>$periode,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );           
            
        }else{
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 2;
                $colspan1 = 2;
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.15',
                    'title'=>'CARA BAYAR',
                    'periode'=>$periode,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }
    }
    
     /**
     * print excel cara bayar
     */
    public function actionPrintCaraBayar()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria = new CDbCriteria();
        $criteria->group = "
                            date_part('year', tgl_laporan),
                            koders,
                            kabupaten,
                            namars,
                            carabayar_id,
                            carabayar_nama,
                            carapembayaran_kode,
                            carapembayaran_nama";
        $criteria->select = $criteria->group.",date_part('year', tgl_laporan) AS tahun, SUM(pasienrawatinapkeluar) AS pasienrawatinaplamadirawat,
                                                SUM(pasienrawatinaplamadirawat) AS pasienrawatinaplamadirawat,
                                                SUM(pasienrawatjalan) AS pasienrawatjalan,
                                                SUM(pasienlaboratorium) AS pasienlaboratorium,
                                                SUM(pasienradiologi) AS pasienradiologi,
                                                SUM(pasienrawatjalanlain) AS pasienrawatjalanlain";
        $criteria->order = 'carabayar_id,carapembayaran_nama';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl315KegiatancarabayarV::model()->findAll($criteria);
        
        $criteria2=new CDbCriteria;
        $criteria2->group = 'carabayar_id, carabayar_nama';
        $criteria2->select = $criteria2->group;
        $criteria2->order = 'carabayar_id';
        $criteria2->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);       
        $recordsGroup = RKRl315KegiatancarabayarV::model()->findAll($criteria2);
        
        
        $header = array(
            '<td rowspan="2" width="50px" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<td rowspan="2" width="250px" style="text-align:center;vertical-align:middle;">CARA PEMBAYARAN</th>', 
            '<td colspan="2" width="150px" style="text-align:center;vertical-align:middle;">PASIEN RAWAT INAP</th>',
            '<td rowspan="2" width="75px" style="text-align:center;vertical-align:middle;">JUMLAH PASIEN RAWAT JALAN</th>',
            '<td colspan="3" width="225px" style="text-align:center;vertical-align:middle;">JUMLAH PASIEN RAWAT JALAN</th>',
        );
        $header2 = array(
            '<td width="75px" style="text-align:center;vertical-align:middle;">KODE PROPINSI</th>', 
            '<td width="75px" style="text-align:center;vertical-align:middle;">KAB/KOTA</th>', 
            '<td width="75px" style="text-align:center;vertical-align:middle;">KODE RS</th>', 
            '<td width="75px" style="text-align:center;vertical-align:middle;">NAMA RS</th>', 
            '<td width="75px" style="text-align:center;vertical-align:middle;">TAHUN</th>', 
            '<td width="75px" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<td width="75px" style="text-align:center;vertical-align:middle;">PASIEN RAWAT INAP_JPK</th>', 
            '<td width="75px"  style="text-align:center;vertical-align:middle;">PASIEN RAWAT INAP_JLD</th>', 
            '<td width="75px"  style="text-align:center;vertical-align:middle;">PASIEN RAWAT JALAN</th>', 
            '<td width="75px"  style="text-align:center;vertical-align:middle;">PASIEN RAWAT JALAN_LAB</th>', 
            '<td width="75px" style="text-align:center;vertical-align:middle;">PASIEN RAWAT JALAN_RAD</th>',
            '<td width="75px" style="text-align:center;vertical-align:middle;">PASIEN RAWAT JALAN_LL</th>',
        );
        $tdCount = array(
            '<td width="50px" style="text-align:center;" bgcolor = "#AFAFAF">1</td>',
            '<td width="250px" style="text-align:center;" bgcolor = "#AFAFAF">2</td>',
            '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">3</td>',
            '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">4</td>',
            '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">5</td>',
            '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">6</td>',
            '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">7</td>',
            '<td width="75px" style="text-align:center;" bgcolor = "#AFAFAF">8</td>',
        );

        $rows = array();
        $judul = array();
        $i=0;
        $datas = array();
        $dataGroup = array();
        
        $total_pasienrikeluar = 0;
        $total_pasienrilamadirawat = 0;
        $total_pasienrj = 0;
        $total_pasienrjlab = 0;
        $total_pasienrjrad = 0;                     
        $total_pasienrjlain = 0;
            

        foreach($records as $j=>$row)
        {
            $carabayar = $row->carabayar_nama;
            $datas[$carabayar][$row->carapembayaran_nama]['carabayar_nama'] = $row->carabayar_nama;
            $datas[$carabayar][$row->carapembayaran_nama]['carapembayaran_nama'] = $row->carapembayaran_nama;
            if (isset($datas[$carabayar][$row->carapembayaran_nama]['pasienrikeluar'])){
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrikeluar'] += $row->pasienrawatinapkeluar;
            } else {
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrikeluar'] = $row->pasienrawatinapkeluar;
            }
            if (isset($datas[$carabayar][$row->carapembayaran_nama]['pasienrilamadirawat'])){
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrilamadirawat'] += $row->pasienrawatinaplamadirawat;
            } else {
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrilamadirawat'] = $row->pasienrawatinaplamadirawat;
            }
            if (isset($datas[$carabayar][$row->carapembayaran_nama]['pasienrj'])){
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrj'] += $row->pasienrawatjalan;
            } else {
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrj'] = $row->pasienrawatjalan;
            }
            if (isset($datas[$carabayar][$row->carapembayaran_nama]['pasienrjlab'])){
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrjlab'] += $row->pasienlaboratorium;
            } else {
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrjlab'] = $row->pasienlaboratorium;
            }
            if (isset($datas[$carabayar][$row->carapembayaran_nama]['pasienrjrad'])){
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrjrad'] += $row->pasienradiologi;
            } else {
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrjrad'] = $row->pasienradiologi;
            }
            if (isset($datas[$carabayar][$row->carapembayaran_nama]['pasienrjlain'])){
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrjlain'] += $row->pasienrawatjalanlain;
            } else {
                $datas[$carabayar][$row->carapembayaran_nama]['pasienrjlain'] = $row->pasienrawatjalanlain;
            }                                 
        }
        
        foreach($recordsGroup as $m=>$value){
            $carabayar = $value->carabayar_nama;
            $dataGroup[$carabayar]['carabayar_nama']= $value->carabayar_nama;           
            $dataGroup[$carabayar]['carabayar'][$m]['carabayar_nama'] = $value->carabayar_nama;           
        }
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class = "border table">';
        $table .= '';
        $table .= '<tr style="font-weight:bold;">'. implode("", $header2) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $i = 0;   
        if(count((array)$dataGroup) > 0){
            foreach($dataGroup as $key=>$data){
                $table .='';
                $table .= '<tr>';
                $table .= '<td width="50px" style="text-align:center;vertical-align:center;"><b>'.($i+1).'</b></td>';  
                $table .= '<td colspan=7><b>'.strtoupper($data['carabayar_nama']).'</b></td></tr>';  
                $table .= '';
                $carabayar_nama = $data['carabayar_nama'];

                $no = 0;
                foreach($datas[$data['carabayar_nama']] as $j => $vals)
                {
                    if($carabayar_nama == $vals['carabayar_nama']){
                        $table .='';
                        $table .='';
                        $table .= '<tr>';
                        $table .= 
                            '<td width="50px" style=text-align:center;>'. $vals['propinsi'].'</li></ol></td>
                            <td width="50px" style=text-align:center;>'. $vals['kabupaten'].'</li></ol></td>    
                            <td width="50px" style=text-align:center;>'. $vals['koders'].'</li></ol></td>    
                            <td width="50px" style=text-align:center;>'. $vals['namars'].'</li></ol></td>    
                            <td width="50px" style=text-align:center;>'. $vals['tahun'].'</li></ol></td>    
                            <td width="50px" style=text-align:center;>'. ($i+1).'.'.($no+1).'</li></ol></td>    
                            <td width="250px">'.$vals['carapembayaran_nama'].'</td>
                            <td width="75px" style=text-align:center;>'.number_format($vals['pasienrikeluar'],0,"",".").'</td>                                        
                            <td width="75px" style=text-align:center;>'.number_format($vals['pasienrilamadirawat'],0,"",".").'</td>                                          
                            <td width="75px" style=text-align:center;>'.number_format($vals['pasienrj'],0,"",".").'</td>                                     
                            <td width="75px" style=text-align:center;>'.number_format($vals['pasienrjlab'],0,"",".").'</td>                                   
                            <td width="75px" style=text-align:center;>'.number_format($vals['pasienrjrad'],0,"",".").'</td>                                     
                            <td width="75px" style=text-align:center;>'.number_format($vals['pasienrjlain'],0,"",".").'</td></tr>';                                          
                        $no++; 
                    }

                    $total_pasienrikeluar += $vals['pasienrikeluar'];
                    $total_pasienrilamadirawat += $vals['pasienrilamadirawat'];
                    $total_pasienrj += $vals['pasienrj'];
                    $total_pasienrjlab += $vals['pasienrjlab'];
                    $total_pasienrjrad += $vals['pasienrjrad'];                     
                    $total_pasienrjlain += $vals['pasienrjlain'];
                }
                $i++;
            }   
        }else{
            $table .='<tr><td colspan=8><i>Data tidak ditemukan.</i></td></tr>';
        }
      
        $table .= '</tbody>';
        $table .= '</table>';
  
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $colspan = 2;
                $colspan1 = 2;
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporancarabayar',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.15',
                    'title'=>'CARA BAYAR',
                    'periode'=>$periode,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
    }
    
    /**
     * Formulir RL 3.11 KEGIATAN KESEHATAN JIWA
     */
    public function actionKegiatanKesehatanJiwa()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria = new CDbCriteria();
        $criteria->group = 'propinsi,
                            kabupaten,
                            profilrs_id,
                            koders,
                            namars,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama';
        $criteria->select = $criteria->group.', sum(qty_tindakan) AS jumlah';
        $criteria->order = 'jeniskegiatan_nama';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl311KegiatankesehatanjiwaV::model()->findAll($criteria);
        
        
        $header = array(
            '<th width="50" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th style="text-align:center;vertical-align:middle;">JENIS PELAYANAN</th>', 
            '<th style="text-align:center;vertical-align:middle;">JUMLAH</th>',
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor = "#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">3</td>',
        );

        $rows = array();
        $judul = array();

        $total= 0;
        $datas = $records;
 
            $total = 0;                  
        if(count((array)$datas) > 0){
            foreach($datas as $i=>$data){
                $rows[] = array(
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['jeniskegiatan_nama'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['jumlah'],0,"",".").'</td>',
                );

                $total += $data['jumlah'];                            
            }   
        }else{
            $rows[] = array(
                '<td colspan=3><i>Data tidak ditemukan.</i></td>',                
            );
        }
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
        $table .= '<tr><td style="text-align:center;">99</td><td style = "text-align:right;"><b>Total</b></td>'
                . '<td style="text-align:center;">'.number_format($total,0,"",".") .'</td>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">Tahun</th>', '<th style="text-align:center;">BOR</th>', '<th style="text-align:center;">LOS</th>', '<th style="text-align:center;">BTO</th>','<th style="text-align:center;">TOI</th>','<th style="text-align:center;">NDR</th>','<th style="text-align:center;">GDR</th>','<th style="text-align:center;">Rata-rata <br/> Kunjungan /hari</th>'
            );
            $title = "KEGIATAN KESEHATAN JIWA";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 3.11',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
            $this->layout = '//layouts/iframe';     
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.11',
                    'title'=>'KEGIATAN KESEHATAN JIWA',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );     
            
        }else{
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.11',
                    'title'=>'KEGIATAN KESEHATAN JIWA',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }
    }    
    /**
     * print exel kesehatan Jiwa
     */
    public function actionPrintKegiatanKesehatanJiwa(){
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria = new CDbCriteria();
        $criteria->group = "date_part('year', tgl_laporan),
                            propinsi,
                            kabupaten,
                            profilrs_id,
                            koders,
                            namars,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama";
        $criteria->select = $criteria->group.",date_part('year', tgl_laporan) as tahun, sum(qty_tindakan) AS jumlah";
        $criteria->order = 'jeniskegiatan_nama';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl311KegiatankesehatanjiwaV::model()->findAll($criteria);
        
         $header = array(
            '<th style="text-align:center;vertical-align:middle;">KODE PROPINSI</th>', 
            '<th style="text-align:center;vertical-align:middle;">KAB/KOTA</th>', 
            '<th style="text-align:center;vertical-align:middle;">KODE RS</th>',
            '<th style="text-align:center;vertical-align:middle;">NAMA RS</th>',
            '<th style="text-align:center;vertical-align:middle;">TAHUN</th>',
            '<th style="text-align:center;vertical-align:middle;">NO</th>',
            '<th style="text-align:center;vertical-align:middle;">JENIS PELAYANAN</th>',
            '<th style="text-align:center;vertical-align:middle;">JUMLAH</th>',

        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor = "#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">7</td>',
            '<td style="text-align:center;" bgcolor = "#AFAFAF">8</td>',

        );

        $rows = array();
        $judul = array();

        $total= 0;
        $datas = array();
 
            $total = 0;                  
        if(count((array)$datas) > 0){
            foreach($datas as $i=>$data){
                $rows[] = array(
                    '<td>'.$data['propinsi'].'</td>',
                    '<td>'.$data['kabupaten'].'</td>',
                    '<td>'.$data['koders'].'</td>',
                    '<td>'.$data['namars'].'</td>',
                    '<td>'.$data['tahun'].'</td>',
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['jeniskegiatan_nama'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['jumlah'],0,"",".").'</td>',
                );

                $total += $data['jumlah'];                            
            }   
        }else{
            $rows[] = array(
                '<td colspan=3><i>Data tidak ditemukan.</i></td>',                
            );
        }
        
        $table = '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
       
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
        
        
         if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('printKegiatanKesehatanJiwa',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.11',
                    'title'=>'KEGIATAN KESEHATAN JIWA',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        
    }
    
    /**
     * Formulir RL 3.5 KEGIATAN PERINATOLOGI
     */
    public function actionKegiatanPerinatologi()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria = new CDbCriteria();
        $criteria->group = 'propinsi,
                            koders,
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskegiatan_id,
                            jeniskegiatan_kode,                            
                            jeniskegiatan_nama';
        $criteria->select = 'propinsi,
                            koders,
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskegiatan_id,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama,
                            SUM(rujukanmedis_rumah_sakit) AS rujukanmedis_rumah_sakit,
                            SUM(rujukanmedis_bidan) AS rujukanmedis_bidan,
                            SUM(rujukanmedis_puskesmas) AS rujukanmedis_puskesmas,
                            SUM(rujukanmedis_faskes_lainnya) AS rujukanmedis_faskes_lainnya,
                            SUM(rujukanmedis_hidup) AS rujukanmedis_hidup,
                            SUM(rujukanmedis_mati) AS rujukanmedis_mati,
                            SUM(rujukanmedis_total) AS rujukanmedis_total,
                            SUM(rujukannonmedis_hidup) AS rujukannonmedis_hidup,
                            SUM(rujukannonmedis_mati) AS rujukannonmedis_mati,
                            SUM(rujukannonmedis_total) AS rujukannonmedis_total,
                            SUM(nonrujukan_hidup) AS nonrujukan_hidup,
                            SUM(nonrujukan_mati) AS nonrujukan_mati,
                            SUM(nonrujukan_total) AS nonrujukan_total,
                            SUM(dirujuk) AS dirujuk';
        $criteria->order = 'jeniskegiatan_nama';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl35KegiatanperinatologiV::model()->findAll($criteria);
        //var_dump($records);die;
        
        $header = array(
            '<th rowspan="3" width="50" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">JENIS KEGIATAN</th>', 
            '<th colspan="10" style="text-align:center;vertical-align:middle;">RUJUKAN</th>',
            '<th colspan="3" rowspan="2" style="text-align:center;vertical-align:middle;">NON RUJUKAN</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">DIRUJUK</th>',
        );
        $header2 = array(
            '<th colspan="7" width="50" style="text-align:center;vertical-align:middle;">MEDIS</th>', 
            '<th colspan="3" style="text-align:center;vertical-align:middle;">NON MEDIS</th>', 
        );
        $header3 = array(
            '<th width="50" style="text-align:center;vertical-align:middle;">RUMAH SAKIT</th>', 
            '<th style="text-align:center;vertical-align:middle;">BIDAN</th>', 
            '<th style="text-align:center;vertical-align:middle;">PUSKESMAS</th>',
            '<th style="text-align:center;vertical-align:middle;">FASKES LAINNYA</th>',
            '<th style="text-align:center;vertical-align:middle;">HIDUP</th>',
            '<th style="text-align:center;vertical-align:middle;">MATI</th>',
            '<th style="text-align:center;vertical-align:middle;">TOTAL</th>',
            '<th style="text-align:center;vertical-align:middle;">HIDUP</th>',
            '<th style="text-align:center;vertical-align:middle;">MATI</th>',
            '<th style="text-align:center;vertical-align:middle;">TOTAL</th>',
            '<th style="text-align:center;vertical-align:middle;">HIDUP</th>',
            '<th style="text-align:center;vertical-align:middle;">MATI</th>',
            '<th style="text-align:center;vertical-align:middle;">TOTAL</th>',
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">7</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">8</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">9</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">10</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">11</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">12</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">13</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">14</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">15</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">16</td>',
        );

        $rows = array();
        $judul = array();
        $i=0;
        $total= 0;        
        
        $datas = array();
        
        foreach($records as $j=>$row)
        {           
            
            $daftartindakan = $row->jeniskegiatan_nama;                                          
            $datas[$daftartindakan]['jeniskegiatan_nama'] = ($row->jeniskegiatan_nama === null)?0:$row->jeniskegiatan_nama;
            $datas[$daftartindakan]['rujukanmedis_rumah_sakit'] = ($row->rujukanmedis_rumah_sakit  === null)?0:$row->rujukanmedis_rumah_sakit;                                        
            $datas[$daftartindakan]['rujukanmedis_bidan'] = ($row->rujukanmedis_bidan  === null)?0:$row->rujukanmedis_bidan;                                        
            $datas[$daftartindakan]['rujukanmedis_puskesmas'] = ($row->rujukanmedis_puskesmas  === null)?0:$row->rujukanmedis_puskesmas;     
            $datas[$daftartindakan]['rujukanmedis_faskes_lainnya'] = ($row->rujukanmedis_faskes_lainnya  === null)?0:$row->rujukanmedis_faskes_lainnya;                                  
            $datas[$daftartindakan]['rujukanmedis_hidup'] = ($row->rujukanmedis_hidup  === null)?0:$row->rujukanmedis_hidup;                                        
            $datas[$daftartindakan]['rujukanmedis_mati'] = ($row->rujukanmedis_mati  === null)?0:$row->rujukanmedis_mati;                                        
            $datas[$daftartindakan]['rujukanmedis_total'] = ($row->rujukannonmedis_mati  === null)?0:$row->rujukannonmedis_mati;                                        
            $datas[$daftartindakan]['rujukannonmedis_hidup'] = ($row->rujukannonmedis_hidup  === null)?0:$row->rujukannonmedis_hidup; 
            $datas[$daftartindakan]['rujukannonmedis_mati'] = ($row->rujukannonmedis_mati  === null)?0:$row->rujukannonmedis_mati;                                        
            $datas[$daftartindakan]['rujukannonmedis_total'] = ($row->rujukannonmedis_total  === null)?0:$row->rujukannonmedis_total;                                        
            $datas[$daftartindakan]['nonrujukan_hidup'] = ($row->nonrujukan_hidup  === null)?0:$row->nonrujukan_hidup; 
            $datas[$daftartindakan]['nonrujukan_mati'] = ($row->nonrujukan_mati  === null)?0:$row->nonrujukan_mati;                                        
            $datas[$daftartindakan]['nonrujukan_total'] = ($row->nonrujukan_total  === null)?0:$row->nonrujukan_total;                                        
            $datas[$daftartindakan]['dirujuk'] = ($row->dirujuk === null)?0:$row->dirujuk;                                        
        }
        
        $total_rujukanrs = 0;                                    
        $total_rujukanbidan = 0;
        $total_rujukanpuskesmas = 0;                                        
        $total_rujukanfaskeslain = 0; 
        $total_rujukanmedishidup = 0;                                   
        $total_rujukanmedismati = 0;                                       
        $total_totalrujukanmedis = 0;
        $total_rujukannonmedishidup = 0;                                        
        $total_rujukannonmedismati = 0;
        $total_totalrujukannonmedis = 0;     
        $total_nonrujukanhidup = 0;                                   
        $total_nonrujukanmati = 0;                                       
        $total_totalnonrujukan = 0;                                      
        $total_dirujukkeluar = 0;
        
        if(count((array)$datas) > 0){
            foreach($datas as $key=>$data){
                $rows[] = array(
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['jeniskegiatan_nama'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_rumah_sakit'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_bidan'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_puskesmas'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_faskes_lainnya'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_hidup'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_mati'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_total'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukannonmedis_hidup'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukannonmedis_mati'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukannonmedis_total'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['nonrujukan_hidup'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['nonrujukan_mati'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['nonrujukan_total'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['dirujuk'],0,"",".").'</td>',
                );
                $i++;
                $total_rujukanrs += $data['rujukanmedis_rumah_sakit'];                                    
                $total_rujukanbidan += $data['rujukanmedis_bidan'];    
                $total_rujukanpuskesmas += $data['rujukanmedis_puskesmas'];    
                $total_rujukanfaskeslain += $data['rujukanmedis_faskes_lainnya']; 
                $total_rujukanmedishidup += $data['rujukanmedis_hidup'];                                 
                $total_rujukanmedismati += $data['rujukanmedis_mati'];                                       
                $total_totalrujukanmedis += $data['rujukanmedis_total'];
                $total_rujukannonmedishidup += $data['rujukannonmedis_hidup'];                                        
                $total_rujukannonmedismati += $data['rujukannonmedis_mati'];
                $total_totalrujukannonmedis += $data['rujukannonmedis_total'];    
                $total_nonrujukanhidup += $data['nonrujukan_hidup'];                                 
                $total_nonrujukanmati += $data['nonrujukan_mati'];                                       
                $total_totalnonrujukan += $data['nonrujukan_total'];                                      
                $total_dirujukkeluar += $data['dirujuk'];
            }   
        }else{
            $rows[] = array(
                '<td colspan=13><i>Data tidak ditemukan.</i></td>',                
            );
        }     


        $table = '<table border = "1" width="100%"  cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header) .'</tr>'.'<tr>'. implode("", $header2) .'</tr>'.'<tr>'. implode("", $header3) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr>';
        $table .= implode("", $tdCount);
        $table .= '</tr>';
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
        $table .= '<tr><td style="text-align:center;">99</td><td style="text-align:right;"><b>Total</b></td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_rujukanrs,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_rujukanbidan,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_rujukanpuskesmas,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_rujukanfaskeslain,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_rujukanmedishidup,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_rujukanmedismati,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_totalrujukanmedis,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_rujukannonmedishidup,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_rujukannonmedismati,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_totalrujukannonmedis,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_nonrujukanhidup,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_nonrujukanmati,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_totalnonrujukan,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_dirujukkeluar,0,"",".") .'</td>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">Tahun</th>', '<th style="text-align:center;">BOR</th>', '<th style="text-align:center;">LOS</th>', '<th style="text-align:center;">BTO</th>','<th style="text-align:center;">TOI</th>','<th style="text-align:center;">NDR</th>','<th style="text-align:center;">GDR</th>','<th style="text-align:center;">Rata-rata <br/> Kunjungan /hari</th>'
            );
            $title = "KEGIATAN PERINATOLOGI";
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 3.5',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){
             $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/iframe';
             $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.5',
                    'title'=>'KEGIATAN PERINATOLOGI',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );      
        }else{
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
                $colspan = 10;
                $colspan1 = 8;
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.5',
                    'title'=>'KEGIATAN PERINATOLOGI',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }
    }       
     /**
     * fungsi untuk menampilkan halaman perinatologi
     */
    public function actionPrintKegiatanPerinatologi()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria = new CDbCriteria();
        $criteria->group = "date_part('year',tgl_laporan),
                            propinsi,
                            koders,
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskegiatan_id,
                            jeniskegiatan_kode,                            
                            jeniskegiatan_nama";
        $criteria->select = "
                            date_part('year',tgl_laporan) as tahun,
                             propinsi,
                            koders,
                            profilrs_id,
                            kabupaten,
                            namars,
                            jeniskegiatan_id,
                            jeniskegiatan_kode,
                            jeniskegiatan_nama,
                            SUM(rujukanmedis_rumah_sakit) AS rujukanmedis_rumah_sakit,
                            SUM(rujukanmedis_bidan) AS rujukanmedis_bidan,
                            SUM(rujukanmedis_puskesmas) AS rujukanmedis_puskesmas,
                            SUM(rujukanmedis_faskes_lainnya) AS rujukanmedis_faskes_lainnya,
                            SUM(rujukanmedis_hidup) AS rujukanmedis_hidup,
                            SUM(rujukanmedis_mati) AS rujukanmedis_mati,
                            SUM(rujukanmedis_total) AS rujukanmedis_total,
                            SUM(rujukannonmedis_hidup) AS rujukannonmedis_hidup,
                            SUM(rujukannonmedis_mati) AS rujukannonmedis_mati,
                            SUM(rujukannonmedis_total) AS rujukannonmedis_total,
                            SUM(nonrujukan_hidup) AS nonrujukan_hidup,
                            SUM(nonrujukan_mati) AS nonrujukan_mati,
                            SUM(nonrujukan_total) AS nonrujukan_total,
                            SUM(dirujuk) AS dirujuk";
        $criteria->order = 'jeniskegiatan_nama';
        $criteria->addBetweenCondition('tgl_laporan',$tgl_awal,$tgl_akhir);
        $records = RKRl35Kegiatanperinatologi::model()->findAll($criteria);
        //var_dump($records);die;
        
        $header = array(
            '<th rowspan="3" width="50" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">JENIS KEGIATAN</th>', 
            '<th colspan="10" style="text-align:center;vertical-align:middle;">RUJUKAN</th>',
            '<th colspan="3" rowspan="2" style="text-align:center;vertical-align:middle;">NON RUJUKAN</th>',
            '<th rowspan="3" style="text-align:center;vertical-align:middle;">DIRUJUK</th>',
        );
        $header2 = array(
            '<th colspan="7" width="50" style="text-align:center;vertical-align:middle;">MEDIS</th>', 
            '<th colspan="3" style="text-align:center;vertical-align:middle;">NON MEDIS</th>', 
        );
        $header3 = array(
            '<th style="text-align:center;vertical-align:middle;">KODE PROPINSI</th>', 
            '<th style="text-align:center;vertical-align:middle;">KAB/KOTA</th>', 
            '<th style="text-align:center;vertical-align:middle;">KODE RS</th>', 
            '<th style="text-align:center;vertical-align:middle;">NAMA RS</th>', 
            '<th style="text-align:center;vertical-align:middle;">TAHUN</th>', 
            '<th width="50" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th style="text-align:center;vertical-align:middle;">JENIS KEGIATAN</th>', 
            '<th style="text-align:center;vertical-align:middle;">RUMAH SAKIT</th>', 
            '<th style="text-align:center;vertical-align:middle;">BIDAN</th>', 
            '<th style="text-align:center;vertical-align:middle;">PUSKESMAS</th>',
            '<th style="text-align:center;vertical-align:middle;">FASKES LAINNYA</th>',
            '<th style="text-align:center;vertical-align:middle;">HIDUP</th>',
            '<th style="text-align:center;vertical-align:middle;">MATI</th>',
            '<th style="text-align:center;vertical-align:middle;">TOTAL</th>',
            '<th style="text-align:center;vertical-align:middle;">HIDUP</th>',
            '<th style="text-align:center;vertical-align:middle;">MATI</th>',
            '<th style="text-align:center;vertical-align:middle;">TOTAL</th>',
            '<th style="text-align:center;vertical-align:middle;">HIDUP</th>',
            '<th style="text-align:center;vertical-align:middle;">MATI</th>',
            '<th style="text-align:center;vertical-align:middle;">TOTAL</th>',
        );
        $tdCount = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">5</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">6</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">7</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">8</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">9</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">10</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">11</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">12</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">13</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">14</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">15</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">16</td>',
        );

        $rows = array();
        $judul = array();
        $i=0;
        $total= 0;        
        
        $datas = array();
        
        foreach($records as $j=>$row)
        {           
            
            $daftartindakan = $row->jeniskegiatan_nama;                                          
            $datas[$daftartindakan]['jeniskegiatan_nama'] = ($row->jeniskegiatan_nama === null)?0:$row->jeniskegiatan_nama;
            $datas[$daftartindakan]['rujukanmedis_rumah_sakit'] = ($row->rujukanmedis_rumah_sakit  === null)?0:$row->rujukanmedis_rumah_sakit;                                        
            $datas[$daftartindakan]['rujukanmedis_bidan'] = ($row->rujukanmedis_bidan  === null)?0:$row->rujukanmedis_bidan;                                        
            $datas[$daftartindakan]['rujukanmedis_puskesmas'] = ($row->rujukanmedis_puskesmas  === null)?0:$row->rujukanmedis_puskesmas;     
            $datas[$daftartindakan]['rujukanmedis_faskes_lainnya'] = ($row->rujukanmedis_faskes_lainnya  === null)?0:$row->rujukanmedis_faskes_lainnya;                                  
            $datas[$daftartindakan]['rujukanmedis_hidup'] = ($row->rujukanmedis_hidup  === null)?0:$row->rujukanmedis_hidup;                                        
            $datas[$daftartindakan]['rujukanmedis_mati'] = ($row->rujukanmedis_mati  === null)?0:$row->rujukanmedis_mati;                                        
            $datas[$daftartindakan]['rujukanmedis_total'] = ($row->rujukannonmedis_mati  === null)?0:$row->rujukannonmedis_mati;                                        
            $datas[$daftartindakan]['rujukannonmedis_hidup'] = ($row->rujukannonmedis_hidup  === null)?0:$row->rujukannonmedis_hidup; 
            $datas[$daftartindakan]['rujukannonmedis_mati'] = ($row->rujukannonmedis_mati  === null)?0:$row->rujukannonmedis_mati;                                        
            $datas[$daftartindakan]['rujukannonmedis_total'] = ($row->rujukannonmedis_total  === null)?0:$row->rujukannonmedis_total;                                        
            $datas[$daftartindakan]['nonrujukan_hidup'] = ($row->nonrujukan_hidup  === null)?0:$row->nonrujukan_hidup; 
            $datas[$daftartindakan]['nonrujukan_mati'] = ($row->nonrujukan_mati  === null)?0:$row->nonrujukan_mati;                                        
            $datas[$daftartindakan]['nonrujukan_total'] = ($row->nonrujukan_total  === null)?0:$row->nonrujukan_total;                                        
            $datas[$daftartindakan]['dirujuk'] = ($row->dirujuk === null)?0:$row->dirujuk;                                        
        }
        
        $total_rujukanrs = 0;                                    
        $total_rujukanbidan = 0;
        $total_rujukanpuskesmas = 0;                                        
        $total_rujukanfaskeslain = 0; 
        $total_rujukanmedishidup = 0;                                   
        $total_rujukanmedismati = 0;                                       
        $total_totalrujukanmedis = 0;
        $total_rujukannonmedishidup = 0;                                        
        $total_rujukannonmedismati = 0;
        $total_totalrujukannonmedis = 0;     
        $total_nonrujukanhidup = 0;                                   
        $total_nonrujukanmati = 0;                                       
        $total_totalnonrujukan = 0;                                      
        $total_dirujukkeluar = 0;
        
        if(count((array)$datas) > 0){
            foreach($datas as $key=>$data){
                $rows[] = array(
                     '<td>'.$data['propinsi'].'</td>',
                     '<td>'.$data['kabupaten'].'</td>',
                     '<td>'.$data['koders'].'</td>',
                     '<td>'.$data['namars'].'</td>',
                     '<td>'.$data['jeniskegiatan_nama'].'</td>',
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['jeniskegiatan_nama'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_rumah_sakit'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_bidan'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_puskesmas'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_faskes_lainnya'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_hidup'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_mati'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukanmedis_total'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukannonmedis_hidup'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukannonmedis_mati'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['rujukannonmedis_total'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['nonrujukan_hidup'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['nonrujukan_mati'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['nonrujukan_total'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['dirujuk'],0,"",".").'</td>',
                );
                $i++;
                $total_rujukanrs += $data['rujukanmedis_rumah_sakit'];                                    
                $total_rujukanbidan += $data['rujukanmedis_bidan'];    
                $total_rujukanpuskesmas += $data['rujukanmedis_puskesmas'];    
                $total_rujukanfaskeslain += $data['rujukanmedis_faskes_lainnya']; 
                $total_rujukanmedishidup += $data['rujukanmedis_hidup'];                                 
                $total_rujukanmedismati += $data['rujukanmedis_mati'];                                       
                $total_totalrujukanmedis += $data['rujukanmedis_total'];
                $total_rujukannonmedishidup += $data['rujukannonmedis_hidup'];                                        
                $total_rujukannonmedismati += $data['rujukannonmedis_mati'];
                $total_totalrujukannonmedis += $data['rujukannonmedis_total'];    
                $total_nonrujukanhidup += $data['nonrujukan_hidup'];                                 
                $total_nonrujukanmati += $data['nonrujukan_mati'];                                       
                $total_totalnonrujukan += $data['nonrujukan_total'];                                      
                $total_dirujukkeluar += $data['dirujuk'];
            }   
        }else{
            $rows[] = array(
                '<td colspan=13><i>Data tidak ditemukan.</i></td>',                
            );
        }     


        $table = '<table border = "1" width="100%"  cellpadding="2" cellspacing="0" class="table border">';
        $table .= '';
        $table .= '<tr>'. implode("", $header3) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
       
        foreach($rows as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
       
        $table .= '</table>';
      
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
                $colspan = 10;
                $colspan1 = 8;
            }
            $this->render('print_laporancarabayar',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.5',
                    'title'=>'KEGIATAN PERINATOLOGI',
                    'periode'=>$periode,
                    'table'=>$table,
                    'colspan' => $colspan,
                    'colspan1' => $colspan1,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
    }       
    
    /**
     * Formulir RL 3.13 PENGADAAN OBAT, PENULISAN DAN PELAYANAN RESEP
     */
    public function actionPengadaanObatResep()
    {
        $model = new MenumodulK;
        $format = new MyFormatter();
        $model->jns_periode = $_REQUEST['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['bln_akhir']);
        $model->thn_awal = $_REQUEST['thn_awal'];
        $model->thn_akhir = $_REQUEST['thn_akhir'];
        $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
        $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
        switch($model->jns_periode){
            case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
            case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
            default : null;
        }
        $model->tgl_awal = $model->tgl_awal." 00:00:00";
        $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        $tgl_awal = $model->tgl_awal;
        $tgl_akhir = $model->tgl_akhir;
        $tanggal_awal = explode('-',$tgl_awal);
        $tanggal_akhir = explode('-',$tgl_akhir);
        
        $tahun_awal = $tanggal_awal[0];
        $tahun_akhir = $tanggal_akhir[0];
        
        if($tahun_awal < $tahun_akhir){
            $periode = $tahun_awal." - ".$tahun_akhir;
        }else{
            $periode = $tahun_akhir;
        }
        
        $criteria = new CDbCriteria();
        /*$criteria->group = 'tgl_laporan,
                            propinsi,
                            koders,
                            profilrs_id,
                            kabupaten,
                            namars,
                            golonganobat';*/
        $criteria->group = 'golonganobat';
        /*$criteria->select = 'tgl_laporan,
                            propinsi,
                            koders,
                            profilrs_id,
                            kabupaten,
                            namars,
                            golonganobat,
                            SUM(jumlahitemobat) AS jumlahitemobat,
                            SUM(jumlahitemobattersedia) AS jumlahitemobattersedia,
                            SUM(jumlahitemobatformulatoriumtersedia) AS jumlahitemobatformulatoriumtersedia';*/
        $criteria->select = 'golonganobat,
                            SUM(jumlahitemobat) AS jumlahitemobat,
                            SUM(jumlahitemobattersedia) AS jumlahitemobattersedia,
                            SUM(jumlahitemobatformulatoriumtersedia) AS jumlahitemobatformulatoriumtersedia';
        $criteria->order = 'golonganobat';
        $criteria->addBetweenCondition('date(tgl_laporan)',$tgl_awal,$tgl_akhir);
        $recordsObat = RKRl313ObatV::model()->findAll($criteria);
        
        $criteria2 = new CDbCriteria();
       /* $criteria2->group = 'tgl_laporan,
                            propinsi,
                            koders,
                            profilrs_id,
                            kabupaten,
                            namars,
                            golonganobat';*/
        $criteria2->group = 'golonganobat';
        /*$criteria2->select = 'tgl_laporan,
                            propinsi,
                            koders,
                            profilrs_id,
                            kabupaten,
                            namars,
                            golonganobat,
                            SUM(rawatjalan) AS rawatjalan,
                            SUM(rawatdarurat) AS rawatdarurat,
                            SUM(rawatinap) AS rawatinap';*/
        $criteria2->select = 'golonganobat,
                            SUM(rawatjalan) AS rawatjalan,
                            SUM(rawatdarurat) AS rawatdarurat,
                            SUM(rawatinap) AS rawatinap';
        $criteria2->order = 'golonganobat';
        $criteria2->addBetweenCondition('date(tgl_laporan)',$tgl_awal,$tgl_akhir);
        $recordsResep = RKRl313ObatV::model()->findAll($criteria2);
        
        
        $headerObat = array(
            '<th width="50" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th width="350" style="text-align:center;vertical-align:middle;">GOLONGAN OBAT</th>', 
            '<th style="text-align:center;vertical-align:middle;">JUMLAH ITEM OBAT</th>',
            '<th style="text-align:center;vertical-align:middle;">JUMLAH ITEM OBAT YANG TERSEDIA DI RUMAH SAKIT</th>',
            '<th style="text-align:center;vertical-align:middle;">JUMLAH ITEM OBAT FORKULATORIUM TERSEDIA DI RUMAH SAKIT</th>',
        );        
        $tdCountObat = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">5</td>',
        );
        
        $headerResep = array(
            '<th width="50" style="text-align:center;vertical-align:middle;">NO</th>', 
            '<th width="350" style="text-align:center;vertical-align:middle;">GOLONGAN OBAT</th>', 
            '<th style="text-align:center;vertical-align:middle;">RAWAT JALAN</th>',
            '<th style="text-align:center;vertical-align:middle;">IGD</th>',
            '<th style="text-align:center;vertical-align:middle;">RAWAT INAP</th>',
        );
        $tdCountResep = array(
            '<td style="text-align:center;" bgcolor="#AFAFAF">1</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">2</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">3</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">4</td>',
            '<td style="text-align:center;" bgcolor="#AFAFAF">5</td>',
        );

        $rowsObat = array();
        $rowsResep = array();
        $judul = array();

        $datasObat = array();
        $datasResep = array();

        $total_jumlahitemobat = 0;           
        $total_jumlahitemrs = 0;           
        $total_jumlahitemformulatoriumobat = 0;           
        
        if(count((array)$recordsObat) > 0){
            foreach($recordsObat as $i=>$data){
                $rowsObat[] = array(
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$data['golonganobat'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['jumlahitemobat'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['jumlahitemobattersedia'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($data['jumlahitemobatformulatoriumtersedia'],0,"",".").'</td>',
                );
                $total_jumlahitemobat += $data['jumlahitemobat'];           
                $total_jumlahitemrs += $data['jumlahitemobattersedia'];             
                $total_jumlahitemformulatoriumobat += $data['jumlahitemobatformulatoriumtersedia'];    
            }   
        }else{
            $rowsObat[] = array(
                '<td colspan=5><i>Data tidak ditemukan.</i></td>',                
            );
        }
        
        $total_rawatjalan = 0;           
        $total_rawatinap = 0;           
        $total_igd = 0;
        if(count((array)$recordsResep) > 0){
        foreach($recordsResep as $i=>$dataResep){
                $rowsResep[] = array(
                    '<td width=50 style="text-align:center;vertical-align:middle;">'. ($i+1).'</td>',
                    '<td>'.$dataResep['golonganobat'].'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($dataResep['rawatjalan'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($dataResep['rawatdarurat'],0,"",".").'</td>',
                    '<td style="text-align:center;vertical-align:middle;">'.number_format($dataResep['rawatinap'],0,"",".").'</td>',
                );
                $total_rawatjalan += $dataResep['rawatjalan'];           
                $total_rawatinap += $dataResep['rawatinap'];             
                $total_igd += $dataResep['rawatdarurat'];    
            }   
        }else{
            $rowsResep[] = array(
                '<td colspan=5><i>Data tidak ditemukan.</i></td>',                
            );
        }

        /**
         * untuk tabel kolom A. Pengadaan Obat
         */
        $table = '<div style="font-weight:bold;margin-left:10px;border: 1px 2px white;" colspan = "5">3.13 Pengadaan Obat, Penulisan dan Pelayanan Resep</div><br>';
        $table .= '<div style="font-weight:bold;margin-left:10px;border:none;" colspan = "5">A. Pengadaan Obat</div>'; 
        $table .= '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';      
        $table .= '';                       
        $table .= '<tr>'. implode("", $headerObat) .'</tr>';
        
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr>';
        $table .= implode("", $tdCountObat);
        $table .= '</tr>';
        foreach($rowsObat as $row)
        {
            $table .= '<tr>'. implode('', $row) . '<tr>';
        }
        $table .= '<tr><td style="text-align:center;">99</td><td style = "text-align:right;"><b>Total</b></td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_jumlahitemobat,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_jumlahitemrs,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor="#AFAFAF">'.number_format($total_jumlahitemformulatoriumobat,0,"",".") .'</td>';
        $table .= '</tbody>';
        $table .= '</table><br/>';        
        /**
         * untuk tabel kolom B. Penulisan dan Pelayanan Resep
         */
        $table .= '<div style="font-weight:bold;margin-left:10px;">B. Penulisan dan Pelayanan Resep </div>';
        $table .= '<table width="100%" border="1" cellpadding="2" cellspacing="0" class="table border">';       
        $table .= '';
        $table .= '<tr>'. implode("", $headerResep) .'</tr>';
        $table .= '';
        $table .= '<tbody>'; 
        $table .= '<tr>';
        $table .= implode("", $tdCountResep);
        $table .= '</tr>';
        foreach($rowsResep as $rowResep)
        {
            $table .= '<tr>'. implode('', $rowResep) . '<tr>';
        }
        $table .= '<tr><td style="text-align:center;">99</td><td style = "text-align:right;"><b>Total</b></td>'
                . '<td style="text-align:center;" bgcolor = "#AFAFAF">'.number_format($total_rawatjalan,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor = "#AFAFAF">'.number_format($total_igd,0,"",".") .'</td>'
                . '<td style="text-align:center;" bgcolor = "#AFAFAF">'.number_format($total_rawatinap,0,"",".") .'</td>';
        $table .= '</tbody>';
        $table .= '</table>';
        
        if($_GET['caraPrint'] == 'PDF')
        {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
            ////$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi,'','','','',5,5,5,5,5,5);
            
            $header = array(
                '<th style="text-align:center;">Tahun</th>', '<th style="text-align:center;">BOR</th>', '<th style="text-align:center;">LOS</th>', '<th style="text-align:center;">BTO</th>','<th style="text-align:center;">TOI</th>','<th style="text-align:center;">NDR</th>','<th style="text-align:center;">GDR</th>','<th style="text-align:center;">Rata-rata <br/> Kunjungan /hari</th>'
            );
            $title = "PENGADAAN OBAT, PENULISAN DAN PELAYANAN RESEP";
            
            $mpdf->WriteHTML(
                $this->renderPartial('print_laporan',
                    array(
                        'width'=>'750',
                        'formulir'=>'Formulir RL 3.13',
                        'title'=>$title,
                        'periode'=>$periode,
                        'table'=>$table,                       
                        'caraPrint'=>$_GET['caraPrint']
                    ), true
                )
            );
            $mpdf->Output($title.'-'.date('Y_m_d').'.pdf','I');
        }elseif($_GET['caraPrint'] == 'Dialog'){ 
             $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/iframe';
            
             $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.13',
                    'title'=>'PENGADAAN OBAT, PENULISAN DAN PELAYANAN RESEP',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );          
        }else{
            $colspan = null;
            $colspan1 = null;
            $this->layout = '//layouts/printWindows';
            if($_GET['caraPrint'] == 'EXCEL')
            {
                $this->layout = '//layouts/printExcel';
            }
            $this->render('print_laporan',
                array(
                    'width'=>'750',
                    'formulir'=>'Formulir RL 3.13',
                    'title'=>'PENGADAAN OBAT, PENULISAN DAN PELAYANAN RESEP',
                    'periode'=>$periode,
                    'table'=>$table,
                    'caraPrint'=>$_GET['caraPrint']
                )
            );            
        }
    }
    
    /**
     * function untuk format periode tanggal laporan
     */
    public function actionGetPeriodeLaporan()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $format = new MyFormatter();
            $periode = $_GET['periode'];
            
            $month = date('m');
            $year = date('Y');
            $jumHari = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            $bulan =  date ("d M Y", mktime (0,0,0,$month,$jumHari,$year)); 
            $awalBulan =  date ("d M Y", mktime (0,0,0,$month,1,$year)); 
            $awalTahun=  date ("d M Y", mktime (0,0,0,1,1,$year)); 
            $akhirTahun=  date ("d M Y", mktime (0,0,0,12,31,$year)); 


            $lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
            $nextyear  = mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1);

            if($periode == "hari"){
               $tgl_awal = date('d M Y 00:00:00');
               $tgl_akhir = date('d M Y 23:59:59');
            }else if($periode == "bulan"){
               $tgl_awal = ''.$awalBulan.' 00:00:00';
               $tgl_akhir = ''.$bulan.' 23:59:59';

            }else if($periode == "tahun"){
                $tgl_awal = ''.$awalTahun.' 00:00:00';

                $tgl_akhir = ''.$akhirTahun.' 23:59:59';

            }else{
                $tgl_awal = date('d M Y 00:00:00 ');
                $tgl_akhir = date('d M Y 23:59:59');
            }
            
            $data = array(
                'tgl_awal'=>$tgl_awal,
                'tgl_akhir'=>$tgl_akhir
            );
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
}
