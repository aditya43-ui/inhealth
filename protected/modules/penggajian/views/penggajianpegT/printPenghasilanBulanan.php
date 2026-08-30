<style>
    .border th, .border td {
        border:1px solid #000 !important;
    }
    .table thead:first-child{
        border-top:1px solid #000;
    }

    thead th{
        background:none;
        color:#333;
    }

    .border {
        box-shadow:none;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }

    .table {
        border-collapse: collapse;
    }

    .textfontwight th{
            display: table-cell;
      vertical-align: inherit;
      font-weight: normal !important;
      text-align: center  !important;
    }

    .num {
        text-align: right !important;
    }
</style>
<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

 echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'colspan'=>38));  
$nama = "";
$tgl = "";
$namapt = "";
$tglpt = "";
$namaSetuju = "";
$tglSetuju = "";
?>

<table id="tableObatAlkes" class="table border">
    <thead>
        <tr class="textfontwight">
            <th>NIK</th>
            <th>Nama Pegawai</th>
            <th>Gaji Pokok</th>
            <th>Tunjangan Fungsional</th>
            <th>Tunjangan Jabatan</th>
            <th>Garansi Jasa Dokter</th>
            <th>Tunjangan Makan</th>
            <th>Jasa Dokter</th>
            <th>Tunjangan Transport</th>
            <th>Lembur</th>
            <th>Tunjangan Hari Raya</th>
            <th>Bonus</th>

            <th>Rapel Gaji</th>
            <th>Tunjangan PPh</th>
            <th>Tantiem</th>
            <th>Gratifikasi</th>
            <th>Jasa Produksi</th>
            <th>Tunjangan Khusus</th>
            <th>Pesangon</th>

            <th>Honorarium</th>
            <th>Potongan Pinjaman</th>
            <th>Potongan Lain-Lain</th>

            <th>Penerimaan</th>
            <th>Pengurangan</th>

            <th>JAMS</th>

            <th>Dasar Upah Jamsostek</th>

            <th>JHT 2%</th>
            <th>JHT 3.7%</th>
            <th>JKK 0.54%</th>
            <th>JKM</th>
            <th>Pensiun</th>
            <th>Dasar Upah Pensiun</th>
            <th>Pensiun 2%</th>
            <th>Pensiun 1%</th>
            <th>Gaji BPJS Kesehatan</th>

            <th>IBPJS</th>

            <th>Dasar Upah BPJS</th>
            <th>BPJS 4%</th>
            <th>BPJS 1%</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <!--<th>THP</th>
            <th>&nbsp;</th>
            <th>Total Penerimaan</th>-->
        </tr>
        <tr>
            <th>NIK</th>
            <th>Nama Pegawai</th>
            <th>GJ</th>
            <th>TJFUNG</th>
            <th>TJBT</th>
            <th>GJD</th>
            <th>TJML</th>
            <th>JD</th>
            <th>TJTR</th>
            <th>OT</th>
            <th>THR</th>
            <th>BONUS</th>

            <th>RAPEL</th>
            <th>TJPPh</th>
            <th>TANT</th>
            <th>GRAT</th>
            <th>JAPROD</th>
            <th>TKH</th>
            <th>PESANGON</th>

            <th>HONOR</th>
            <th>POTPINJ</th>
            <th>POTLAIN</th>

            <th>TERIMALAIN</th>
            <th>KURANGLAIN</th>

            <th>JAMS</th>

            <th>DUJ</th>

            <th>JHT2</th>
            <th>JHT37</th>
            <th>JKK</th>
            <th>JKM</th>
            <th>JIP</th>
            <th>DUP</th>
            <th>JIP2</th>
            <th>JIP1</th>
            <th>BPJSGJ</th>

            <th>IBPJS</th>

            <th>DUB</th>
            <th>BPJS4</th>
            <th>BPJSP</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <!--<th>THP</th>-->
            <!--<th>&nbsp;</th>-->
            <!--<th>Total Penerimaan</th>-->
        </tr>
    </thead>
     <tbody>
         <?php

            if(count((array)$model)>0){
                $no = 1;
                $totalTerima = 0;
                $totalBersih = 0;
                $nama = $model[0]->mengetahui;
                $tgl = $model[0]->tgl_mengetahui;
                $namapt = $model[0]->mengetahuipt;
                $tglpt = $model[0]->tgl_mengetahuipt;
                $namaSetuju = $model[0]->menyetujui;
                $tglSetuju = $model[0]->tgl_menyetujui;
                foreach ($model as $data){
                    $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                    $id[] = $data->penggajianpeg_id;
                     $totalTerima += $data->totalterima;
                $totalBersih += $data->penerimaanbersih;

                $makan = PenggajiankompT::model()->findByAttributes(array(
                    'penggajianpeg_id'=>$data->penggajianpeg_id,
                    'komponengaji_id'=>Params::KOMPONENGAJI_ID_NATURA
                ));

                $total = 0;

                $gp = $data->getNilaiKomponenGajiDariKode("GP");
                $tf = $data->getNilaiKomponenGajiDariKode("TF");
                $tj = $data->getNilaiKomponenGajiDariKode("TJ");
                $gjd = $data->getNilaiKomponenGajiDariKode("GJD");
                $tm = $data->getNilaiKomponenGajiDariKode("TM");
                $jd = $data->getNilaiKomponenGajiDariKode("JD");
                $tt = $data->getNilaiKomponenGajiDariKode("TT");
                $lmbr = $data->getNilaiKomponenGajiDariKode("LMBR");
                $thr = $data->getNilaiKomponenGajiDariKode("THR");
                $bns = $data->getNilaiKomponenGajiDariKode("BNS");
                $total += $gp + $tf + $tj + $gjd + $tm + $jd + $tt + $lmbr + $thr + $bns;

                $rg = $data->getNilaiKomponenGajiDariKode("RG");
                $tp = $data->getNilaiKomponenGajiDariKode("TP");
                $tntm = $data->getNilaiKomponenGajiDariKode("TNTM");
                $gtf = $data->getNilaiKomponenGajiDariKode("GTF");
                $jsp = $data->getNilaiKomponenGajiDariKode("JSP");
                $tk = $data->getNilaiKomponenGajiDariKode("TK");
                $ps = $data->getNilaiKomponenGajiDariKode("PS");
                $total += $rg + $tp + $tntm + $gtf + $jsp + $tk + $ps;

                $hnr = $data->getNilaiKomponenGajiDariKode("HNR");
                $pj = $data->getNilaiKomponenGajiDariKode("PJ");
                $pl = $data->getNilaiKomponenGajiDariKode("PL");
                $total += $hnr + $pj + $pl + $data->penambahan + $data->pengurangan;

                $duj = $data->getNilaiKomponenGajiDariKode("DUJ");
                $total += $duj;

                $jht2 = $data->getNilaiKomponenGajiDariKode("JHT",true);
                $jht37 = $data->getNilaiKomponenGajiDariKode("PTJHT");
                $jkk = (($data->getNilaiKomponenGajiDariKode("PJKK") > 0)?$data->getNilaiKomponenGajiDariKode("PJKK") : $data->getNilaiKomponenGajiDariKode("JKK"));
                $jkm = (($data->getNilaiKomponenGajiDariKode("PJKM") > 0)?$data->getNilaiKomponenGajiDariKode("PJKM") : $data->getNilaiKomponenGajiDariKode("JKM"));
                $pensiun2 = (($data->getNilaiKomponenGajiDariKode("PTJP") > 0) ? $data->getNilaiKomponenGajiDariKode("PTJP") : $data->getNilaiKomponenGajiDariKode("TJP"));
                $pensiun1 = $data->getNilaiKomponenGajiDariKode("JP", true);

//                $jht2 = (($duj * 2)/100);
//                $jht37 = (($duj * 3.7)/100);
//                $jkk = (($duj * 0.54)/100);
//                $jkm = (($duj * 0.3)/100);
                $dup = (($duj>'8000000')?'8000000':$duj);
//                $pensiun2 = (($duj * 2)/100);
//                $pensiun1 = (($duj * 1)/100);

//                $jht = $data->getNilaiKomponenGajiDariKode("JHT");
//                $tjht = $data->getNilaiKomponenGajiDariKode("TJHT");
//                $jkk = $data->getNilaiKomponenGajiDariKode("JKK");
//                $jkm = $data->getNilaiKomponenGajiDariKode("JKM");
//                $jp = $data->getNilaiKomponenGajiDariKode("JP");
//                $jp2 = $data->getNilaiKomponenGajiDariKode("JP");
//                $jp02 = $data->getNilaiKomponenGajiDariKode("JP") * 0.02;
//                $jp01 = $data->getNilaiKomponenGajiDariKode("JP") * 0.01;
//                $total += $jht + $tjht + $jkk + $jkm + $jp + $jp2 + $jp02 + $jp01;

                $tbk4 = (($data->getNilaiKomponenGajiDariKode("PTBK") > 0) ? $data->getNilaiKomponenGajiDariKode("PTBK") : $data->getNilaiKomponenGajiDariKode("TBKSHT"));
                $tbn1 = $data->getNilaiKomponenGajiDariKode("TBK", true);

                $tbn = $data->getNilaiKomponenGajiDariKode("TBN");
                $dupbpjs = (($tbn>'12000000')?'12000000':$tbn);
//                $tbk4 = (($tbn*4)/100);
//                $tbn1 = (($tbn*1)/100);

                $total += $tbn + $tbk4 + $tbn1;

                $thp = $gp + $tf + $tj + $gjd + $tm + $jd + $tt + $lmbr + $thr + $bns + $rg + $tp + $tntm + $gtf + $jsp + $tk + $ps - $hnr - $pj + $pl - $data->penambahan - $duj - $pensiun2 - $tbk4;

                $ikutbpjstk = 0;

                if($jht2 > 0 || $jht37 > 0 || $jkk > 0 || $jkm > 0){
                    $ikutbpjstk = 1;
                }

                $ikutbpjskes = 0;
                if($tbk4 > 0 || $tbn1 > 0){
                    $ikutbpjskes = 1;
                }

            ?>

                <tr>
                    <td><?php echo (!empty($peg->nomorindukpegawai)? '="'.preg_replace('/[^A-Za-z0-9]/s',"",$peg->nomorindukpegawai).'"' : ""); ?></td>
                    <td><?php echo empty($peg) ? "-" : $peg->namaLengkap; ?></td>
                    <td class="num"><?php echo '="'.number_format($gp, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($tf, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($tj, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($gjd, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($tm, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($jd, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($tt, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($lmbr, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($thr, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($bns, 0, ",", ".").'"'; ?></td>

                    <td class="num"><?php echo '="'.number_format($rg, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($tp, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($tntm, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($gtf, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($jsp, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($tk, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($ps, 0, ",", ".").'"'; ?></td>

                    <td class="num"><?php echo '="'.number_format($hnr, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($pj, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($pl, 0, ",", ".").'"'; ?></td>

                    <td class="num"><?php echo '="'.number_format($data->penambahan, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($data->pengurangan, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo $ikutbpjstk; ?></td>
                    <td class="num"><?php echo '="'.number_format($duj, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($jht2, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($jht37, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($jkk, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($jkm, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo ($pensiun2 > 0 || $pensiun1 > 0)?0:1; ?></td>
                    <td class="num"><?php echo '="'.number_format($dup, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($pensiun2, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($pensiun1, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo ((!empty($tbn1) && $tbn1 >0)?'="'.number_format($tbn1, 0, ",", ".").'"':1); ?></td>
                    <td class="num"><?php echo $ikutbpjskes; ?></td>
                    <td class="num"><?php echo '="'.number_format($dupbpjs, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($tbk4, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($tbn1, 0, ",", ".").'"'; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <!--<td class="num"><?php // echo '="'.number_format($data->penerimaanbersih, 0, ",", ".").'"'; ?></td>
                    <td>&nbsp;</td>
                    <td class="num"><?php // echo '="'.number_format($data->totalterima, 0, ",", ".").'"'; ?></td>-->

<!--<td class="num"><?php // echo '="'.number_format($jht, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php // echo '="'.number_format($tjht, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php // echo '="'.number_format($jkk, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php // echo '="'.number_format($jkm, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php // echo '="'.number_format($jp, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php // echo '="'.number_format($jp2, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php // echo '="'.number_format($jp02, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php // echo '="'.number_format($jp01, 0, ",", ".").'"'; ?></td>

                    <td class="num"><?php // echo '="'.number_format($tbn, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php // echo '="'.number_format($tbk4, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php // echo '="'.number_format($tbn2, 0, ",", ".").'"'; ?></td>

                    <td class="num"><?php // echo '="'.number_format($total, 0, ",", ".").'"'; ?></td>-->

                    <?php /*
                    <td class="num"><?php echo '="'.number_format($data->getNilaiKomponenGajiDariKode("PGT"), 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($data->getNilaiKomponenGajiDariKode("TF") + $data->getNilaiKomponenGajiDariKode("TK"), 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($data->premiasuransi, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format(empty($makan) ? 0 : $makan->jumlah, 0, ",", ".").'"'; ?></td>
                    <td class="num"><?php echo '="'.number_format($data->potonganpensiun, 0, ",", ".").'"'; ?></td>
                     *
                     */ ?>

                </tr>
             <?php
             }
            }else{
             ?>
         <tr colspan="6">
             <td>Tidak Ditemukan</td>
         </tr>
             <?php
            }
         ?>
     </tbody>
     <?php /*
     <tfoot>
        <tr>
            <th style="text-align: right" colspan="5">
                Total
            </th>
            <th style="text-align: right">
                <?php echo CHtml::encode(number_format($totalBersih,0,"",".")); ?>
            </th>
                <th style="text-align: right">
                 <?php echo CHtml::encode(number_format($totalTerima,0,"",".")); ?>
            </th>
        </tr>
     </tfoot>
      *
      */ ?>
</table>
