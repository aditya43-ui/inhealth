<style type="text/css">
    table.utama tr td{
        padding: 5px;
    }
    table.anak tr td{
        padding: 0;
    }
    table.pph21 tr td{
        border: 1px solid #000;
    }
    .simbol{
        font-size: 18px;
    }
</style>
<?php 
$periodegaji = date('Y-m-d');
$tglpenggajian = date('Y-m-d');
$nopenggajian = "GAJI190329001";
$fungsional = 0;
$pph21perbulan = 0;
$gajipokok = 0;
$premiasuransi = 0;
$bonus = 0;
$biayajabatan = 0;
$potonganpensiun = 0; $jaminanpensiun = 0; $bpjskesehatan = 0;
$ptkppertahun = 0;
$pph21pertahun = 0;

foreach ($modelpeg as $key => $val) {
    $periodegaji = $val->periodegaji;
    $nopenggajian = $val->nopenggajian;
    $tglpenggajian = $val->tglpenggajian;
    $pemotong_id = $val->pemotong_id;
    
    $gajipokok += $val->gajipokok;
    $pph21perbulan += $val->pph21perbulan;
    
    $fungsional += ($val->fungsional($val->penggajianpeg_id) + $val->lembur($val->penggajianpeg_id));
    $premiasuransi += $val->premiasuransi;
    
    $bonus += ($val->bonus($val->penggajianpeg_id)) + $val->thr($val->penggajianpeg_id);
    $biayajabatan += $val->biayajabatan;
    $potonganpensiun += $val->potonganpensiun;
    $jaminanpensiun += $val->jaminanpensiun;
    $bpjskesehatan += $val->bpjskesehatan;
    $ptkppertahun += $val->ptkppertahun;
    $pph21pertahun += $val->pph21perbulan;
}
$masaPjk = substr($periodegaji, 5, 2);
$thnPjk = substr($periodegaji, 2, 2);
$noGaji = '000000'.substr($nopenggajian, 10, 3);

$modPem = new PegawaiM();
if (!empty($pemotong_id)) {
    $modPem = PegawaiM::model()->findByPk($pemotong_id);
}

if (count((array)$modelpeg) != 0) {
    $modelpeg = $modelpeg[0];
}

?>
<table width="100%" class="utama">
    <tr>
        <td width="30%" rowspan="2" style="text-align: center; border-right: 1px solid #000;">
            <img src="<?php echo Params::urlProfilRSDirectory().'logo_menkeu.png'; ?> " style="max-width: 70px; width:70px;"/>
            <p>
                <b>KEMENTERIAN KEUANGAN RI<br>
                DIREKTORAT JENDRAL PAJAK</b>
            </p>
        </td>
        <td width="35%" style="text-align: center; border-right: 1px solid #000; vertical-align:top;">
            <b>BUKTI PEMOTONGAN PAJAK PENGHASILAN<br>
            PASAL 21 BAGI PEGAWAI TETAP ATAU<br>
            PENERIMA PENSIUN ATAU TUNJANGAN HARI<br> 
            TUA ATAU JAMINAN HARI TUA BERKALA<br>
            </b>
        </td>
        <td style="vertical-align:top;">
            <h4 style="text-align:right;">FORMULIR 1721 - A1</h4>
            Lembar ke-1 : untuk Penerima Penghasilan<br>
            Lembar ke-2 : untuk Pemotong<br>
    <p style="margin: 0; text-align: center;">
            <b>MASA PEROLEHAN<br>
            PENGHASILAN (mm - mm)</b>
    </p>
            
        </td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000; border-right: 1px solid #000;">
            <b>NOMOR : 1 . 1 - <?php echo $masaPjk.' - '.$thnPjk.' - '.$noGaji; ?></b>
        </td>
        <td>
            <p style="margin: 0; text-align: center;">
            <?php echo $masa_1; ?>
                 - 
            <?php echo $masa_2; ?>
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid #000;">
            
            <table width="100%" class="anak">
                <tr>
                    <td width="150"><b>NPWP PEMOTONG</b></td>
                    <td style="vertical-align: bottom;">: <?php echo $profil->npwp; ?></td>
                </tr>
                <tr>
                    <td><b>NAMA PEMOTONG</b></td>
                    <td style="vertical-align: bottom;">: <?php echo $profil->nama_rumahsakit; ?></td>
                </tr>
            </table>
            
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <b>A. IDENTITAS PENERIMA PENGHASILAN YANG DIPOTONG</b>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid #000;">
            
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="150"><b>1.NPWP</b></td>
                    <td>: <?php echo $modPegawai->npwp; ?></td>
                    
                    <td colspan="2" width="50%"><b>6.STATUS / JUMLAH TANGGUNGAN KELUARGA UNTUK PTKP</b> :</td>
                </tr>
                <tr>
                    <td><b>2.NIK / NO.PASPORT</b></td>
                    <td>: <?php echo $modPegawai->noidentitas; ?></td>
                    
                    <td colspan="2">
                    <?php 
                        echo $modPegawai->getStatusKodePtkp(); 
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><b>3.NAMA</b></td>
                    <td>: <?php echo $modPegawai->NamaLengkap; ?></td>
                    
                    <td colspan="2"><b>7.NAMA JABATAN </b>:
                        <?php echo $modPegawai->getJabatanNama(); ?>
                    </td>
                </tr>
                <tr>
                    <td><b>4.ALAMAT</b></td>
                    <td>: <?php echo $modPegawai->alamat_pegawai; ?></td>
                    
                    <td colspan="2"><b>8.KARYAWAN ASING</b> :
                        <?php 
                        if($modPegawai->warganegara_pegawai == 'INDONESIA'){
                            echo '<b class="simbol">&#9744;</b> YA';
                        }
                        else{
                            echo '<b class="simbol">&#9746;</b> YA';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><b>5.JENIS KELAMIN</b> : 
                        <?php 
                        if($modPegawai->jeniskelamin == 'PEREMPUAN'){
                            echo '<b class="simbol">&#9744;</b> LAKI-LAKI &nbsp; &nbsp; &nbsp; ';
                            echo '<b class="simbol">&#9746;</b> PEREMPUAN';
                        }
                        else{
                            echo '<b class="simbol">&#9746;</b> LAKI-LAKI &nbsp; &nbsp; &nbsp; ';
                            echo '<b class="simbol">&#9744;</b> PEREMPUAN';
                        }
                        ?>
                    </td>
                    
                    <td colspan="2"><b>9.KODE NEGARA DOMISILI</b> :
                    </td>
                </tr>
            </table>
            
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <b>B. RINCIAN PENGHASILAN DAN PERHITUNGAN PPh PASAL 21</b>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            
            <table width="100%" class="pph21">
                <tr>
                    <td colspan="2" style="text-align:center;"><b>URAIAN</b></td>
                    <td style="text-align:center;"><b>JUMLAH (Rp)</b></td>
                </tr>
                <tr>
                    <td colspan="2"><b>KODE OBJEK PAJAK: 
                        <?php 
                        if($modelpeg->pegawai->kode_objekpajak == '21-100-01'){
                            echo '<b class="simbol">&#9746;</b> 21-100-01 &nbsp; &nbsp; &nbsp; ';
                            echo '<b class="simbol">&#9744;</b> 21-100-02';
                        }
                        else{
                            echo '<b class="simbol">&#9744;</b> 21-100-01 &nbsp; &nbsp; &nbsp; ';
                            echo '<b class="simbol">&#9746;</b> 21-100-02';
                        }
                        ?>
                        </b>
                    </td>
                    <td style="background-color:#f2f2f2;"></td>
                </tr>
                <tr>
                    <td colspan="2"><b>PENGHASILAN BRUTO:</b></td>
                    <td style="background-color:#f2f2f2;"></td>
                </tr>
                <tr>
                    <td style="width: 20px;">1.</td>
                    <td>GAJI/PENSIUN ATAU THT/JHT</td>
                    <td style="text-align:right;" class="no_1">
                        <?php 
                        $no1 = 0;
                        if(!empty($modelpeg->gajipokok)){
                            $no1 = $modelpeg->gajipokok;
                            echo number_format($no1);
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>TUNJANGAN PPh</td>
                    <td style="text-align:right;" class="no_2">
                        <?php 
                        $no2 = 0; //$modelpeg->pph21perbulan;
                        echo number_format($no2);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>TUNJANGAN LAINNYA, UANG LEMBUR DAN SEBAGAINYA</td>
                    <td style="text-align:right;" class="no_3">
                        <?php 
//                            $no3 = ($modelpeg->fungsional($modelpeg->penggajianpeg_id) + $modelpeg->lembur($modelpeg->penggajianpeg_id)) * 12;
                            $no3 = ($modelpeg->tunjangantetap);
                            echo number_format($no3);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>HONONARIUM DAN IMBALAN LAIN SEJENISNYA</td>
                    <td style="text-align:right;" class="no_4">
                        <?php 
                        $no4 = ($modelpeg->honorarium);
                        echo number_format($no4);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>PREMI ASURANSI YANG DIBAYAR PEMBERI KERJA</td>
                    <td style="text-align:right;" class="no_5">
                        <?php 
//                            $no5 = $modelpeg->premiasuransi * 12;
                            $no5 = $modelpeg->premiasuransi;
                            echo number_format($no5); 
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td>PENERIMAAN DALAM BENTUK NATURA DAN KENIKMATAN LAINNYA YANG DIKENAKAN PEMOTONGAN PPh PASAL 21</td>
                    <td style="text-align:right;" class="no_6">
                        <?php 
                        $no6 = $modelpeg->tunjanganmakan;
                        echo number_format($no6);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>TANTIEM, BONUS, GRATIFIKASI, JASA PRODUKSI DAN THR</td>
                    <td style="text-align:right;" class="no_7">
                        <?php 
//                            $no7 = ($modelpeg->bonus($modelpeg->penggajianpeg_id) * 12) + $modelpeg->thr($modelpeg->penggajianpeg_id);
                            $no7 = ($modelpeg->tunjanganbonus);
                            echo number_format($no7);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>JUMLAH PENGHASILAN BRUTO(1 S.D. 7)</td>
                    <td style="text-align:right;" class="no_8">
                        <?php 
                            $no8 = $no1 + $no2 + $no3 + $no4 + $no5 + $no6 + $no7;
                            echo number_format($no8);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><b>PENGURANGAN:</b></td>
                    <td style="background-color:#f2f2f2;"></td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>BIAYA JABATAN/ BIAYA PENSIUN</td>
                    <td style="text-align:right;" class="no_9">
                        <?php 
                            $no9 = $modelpeg->biayajabatan;
                            echo number_format($no9); 
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>IURAN PENSIUN ATAU IURAN THT/JHT</td>
                    <td style="text-align:right;" class="no_10">
                        <?php 
                            $no10 = $modelpeg->potonganpensiun;
                            echo number_format($no10); 
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>11</td>
                    <td>JUMLAH PENGURANGAN(10 S.D. 11)</td> 
                    <td style="text-align:right;" class="no_11">
                        <?php 
                        $no11 = $no9 + $no10;
                        echo number_format($no11); 
                        ?>
                    </td>
                </tr> 
                <tr>
                    <td colspan="2"><b>PENGHITUNGAN PPh PASAL 21:</b></td>
                    <td style="background-color:#f2f2f2;"></td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>JUMLAH PENGHASILAN NETTO(8 - 11)</td>
                    <td style="text-align:right;" class="no_12">
                        <?php 
//                        $no12 = (($modelpeg->totalterima+$modelpeg->premiasuransi) * 12) - $modelpeg->biayajabatan - $modelpeg->potonganpensiun - $modelpeg->jaminanpensiun - $modelpeg->bpjskesehatan;
                        $no12 = $no8 - $no11;
                        echo number_format($no12); 
                        ?>
                    </td>
                </tr>    
                <tr>
                    <td>13</td>
                    <td>PENGHASILAN NETO MASA SEBELUMNYA</td>
                    <td style="text-align:right;" class="no_13">
                        <?php 
                        $no13 = $modelpeg->netto_masasebelumnya;
                        echo number_format($no13); 
                        ?>
                    </td>
                </tr> 
                <tr>
                    <td>14</td>
                    <td>JUMLAH PENGHASILAN NETO UNTUK PERHITUNGAN PPh PASAL 21(SETAHUN/DISETAHUNKAN)</td>
                    <td style="text-align:right;" class="no_14">
                        <?php 
                        $no14 = $modelpeg->penerimaanbersihpertahun;
                        echo number_format($no14); 
                        ?>
                    </td>
                </tr> 
                <tr>
                    <td>15</td>
                    <td>PENGHASILAN TIDAK KENA PAJAK(PTKP)</td>
                    <td style="text-align:right;" class="no_15"> 
                        <?php 
                            $no15 = $modelpeg->ptkppertahun;
                            echo number_format($no15); 
                        ?>
                    </td>
                </tr> 
                <tr>
                    <td>16</td>
                    <td>PENGHASILAN KENA PAJAK SETAHUN/DISETAHUNKAN(14 - 15)</td>
                    <td style="text-align:right;" class="no_16">
                        <?php 
                        
                        $no16 = $no14 - $no15;
                        if ($no16 < 0) {
                            $no16 = 0;
                        }
                        
                        echo number_format($no16); ?>
                    </td>
                </tr> 
                <tr>
                    <td>17</td>
                    <td>PPh PASAL 21 ATAS PENGHASILAN KENA PAJAK SETAHUN/DISETAHUNKAN</td>
                    <td style="text-align:right;" class="no_17"> 
                        <?php echo number_format($modelpeg->pph21pertahun); ?>
                    </td>
                </tr> 
                <tr>
                    <td>18</td>
                    <td>PPh PASAL 21 YANG TELAH DIPOTONG MASA SEBELUMNYA</td>
                    <td style="text-align:right;" class="no_18">
                        <?php echo number_format($modelpeg->pph21dipotong); ?>
                    </td>
                </tr> 
                <tr>
                    <td>19</td>
                    <td>PPh PASAL 21 TERUTANG</td>
                    <td style="text-align:right;" class="no_19"> 
                        <?php echo number_format($modelpeg->pph21terutang); ?>
                    </td>
                </tr> 
                <tr>
                    <td>20</td>
                    <td>PPh PASAL 21 DAN PPh PASAL 26 YANG TELAH DIPOTONG DAN DILUNASI</td>
                    <td style="text-align:right;" class="no_20"> 
                        <?php echo number_format($modelpeg->pph21telahdipotong); ?>
                    </td>
                </tr> 
            </table>
            
        </td>
    </tr>
    <tr>
        <td colspan="3"><b>C. IDENTITAS PEMOTONG</b></td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid #000;">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="100px"><b>1. NPWP : </b><?php echo $modPem->npwp; ?></td>
                    <td width="30%"><b>3. TANGGAL & TANDA TANGAN </b></td>
                    <td width="25%" rowspan="2" style="border:1px solid #000;"></td>
                </tr>
                <tr>
                    <td><b>2. NAMA : </b><?php echo $modPem->NamaLengkap; ?></td>
                    <td><p style="margin: 0; text-align: center;"><?php echo substr($tglpenggajian,8,2).' - '.substr($tglpenggajian,5,2).' - '.substr($tglpenggajian,0,4); ?></p></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>
<br>

<?php
if(isset($caraPrint)){

}    
else{
?>

<br>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printRincian(\'PRINT\')')); 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'printRincian(\'PDF\')')); 
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
$penggajianpeg_id = isset($_GET['penggajianpeg_id']) ? $_GET['penggajianpeg_id'] : null;

$urlPrint= $this->createUrl('formulirPrint',array('tahun'=>$tahunPajak, 'pegawai_id'=>$modelpeg->pegawai_id));
$js = <<< JSCRIPT
function printRincian(caraPrint)
{
    var masa_1 = $("#masa_1").val();
    var masa_2 = $("#masa_2").val();
    window.open("${urlPrint}&masa_1="+masa_1+"&masa_2="+masa_2+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
 
JSCRIPT;
    Yii::app()->clientScript->registerScript('printRincian',$js,CClientScript::POS_HEAD);  
}    
?>

