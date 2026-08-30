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
    body{
        color: black;
    }
    .tabelPajak th {
  border: 1px solid #918484;
  color: black;
}
.tabelPajak td {
  border: 1px solid #746A6A;
}

.tab_objek {
    border: 1px solid black;
}

.tab_objek td, .tab_objek th {
    vertical-align: top;
}
</style>
<table width="100%" class="utama">
    <tr>
        <td width="30%" rowspan="2" style="text-align: center; border-right: 1px solid #000; border-bottom: 1px solid #000;">
            <img src="<?php echo Params::urlProfilRSDirectory().'logo_menkeu.png'; ?> " style="max-width: 70px; width:70px;"/>
            <p>
                <b>KEMENTERIAN KEUANGAN RI<br>
                DIREKTORAT JENDRAL PAJAK</b>
            </p>
        </td>
        <td width="35%" style="text-align: center; border-right: 1px solid #000; vertical-align:top;">
            <b>BUKTI PEMOTONGAN PAJAK<br>
            PENGHASILAN PASAL 21 (TIDAK FINAL)<br>
            ATAU PASAL 26<br> 
            </b>
        </td>
        <td style="vertical-align:top;border-bottom: 1px solid #000;">
            <h4 style="text-align:right;">FORMULIR 1721 - VI</h4>
            Lembar ke-1 : untuk Penerima Penghasilan<br>
            Lembar ke-2 : untuk Pemotong<br>
    <p style="margin: 0; text-align: center;">
    </p>
            
        </td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000">
            <b>NOMOR : <?php echo $modelPajak->no_perhitungan; ?></b>
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
                    <td width="10%"><b>1. NPWP</b></td>
                    <td width="40%">: <?php echo $modelPegawai->npwp; ?></td>
                    
                    <td width="12%"><b>2. NIK / NO.PASPORT</b></td>
                    <td>: <?php echo $modelPegawai->noidentitas; ?></td>
                </tr>
                <tr>
                    <td><b>3. NAMA</b></td>
                    <td colspan="2">: <?php echo $modelPegawai->namaLengkap; ?></td>
                </tr>
                <tr>
                    <td><b>4. ALAMAT</b></td>
                    <td colspan="2">: <?php echo $modelPegawai->alamat_pegawai; ?></td>
                </tr>
            </table>
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="15%"><b>5. WAJIB PAJAK LUAR NEGERI</b></td>
                    <td width="35%">: <span style="border: 1px solid #C0C0C0; padding: 5px 10px 5px 10px">&nbsp;</span> YA</td>
                    <td colspan="2"><b>6. KODE NEGARA DOMISILI</b></td>
                    <td>: </td>
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
            <table width="100%" class="tabelPajak">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 35%">KODE OBJEK PAJAK</th>
                        <th style="text-align: center; width: 15%">JUMLAH PENGHASILAN BRUTO (Rp)</th>
                        <th style="text-align: center; width: 15%">DASAR PENGENAAN PAJAK (Rp)</th>
                        <th style="text-align: center; width: 10%">TARIF LEBIH TINGGI 20% (TIDAK BER-NPWP)</th>
                        <th style="text-align: center; width: 10%">TARIF (%)</th>
                        <th style="text-align: center; width: 15%">PPh DIPOTONG (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background-color: #B7B1B1; color: black;">
                        <td style="text-align: center">(1)</td>
                        <td style="text-align: center">(2)</td>
                        <td style="text-align: center">(3)</td>
                        <td style="text-align: center">(4)</td>
                        <td style="text-align: center">(5)</td>
                        <td style="text-align: center">(6)</td>
                    </tr>
                    <tr>
                        <td><?php echo (!empty($model->kode_objekpajak)? $model->kode_objekpajak: ""); ?></td>
                        <td style="text-align: right"><?php echo number_format($modelPajak->penghasilanbruto,0,",","."); ?></td>
                        <td style="text-align: right"><?php echo number_format($modelPajak->pkp,0,",","."); ?></td>
                        <td style="text-align: center"><span style="border: 1px solid #C0C0C0; padding: 2px 15px 2px 15px;">&nbsp;</span></td>
                        <td style="text-align: center">
                            <?php
                                $persenpelapis = '';
                                $kumulatif = $modelPajak->pkpkumulatif;
                                if ($kumulatif < 50000000) {
                                    $persenpelapis = '5';
                                }
                                
                                $kumulatif -= 50000000;
                                if ($kumulatif > 0 && $kumulatif < 200000000) {
                                    $persenpelapis = '15';
                                }
                                
                                $kumulatif -= 200000000;
                                if ($kumulatif > 0 && $kumulatif < 250000000) {
                                    $persenpelapis = '25';
                                }
                                
                                $kumulatif -= 250000000;
                                if ($kumulatif > 0) {
                                    $persenpelapis = '30';
                                }
                                
                                echo $persenpelapis; 
                            ?>
                        </td>
                        <td style="text-align: right"><?php echo number_format($modelPajak->pajakprogressif,0,",","."); ?></td>
                    </tr>
                </tbody>
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
                    <td width="50%"><b>1. NPWP : </b><?php echo $profil->npwp_pt; ?></td>
                    <td width="25%"><b>3. TANGGAL & TANDA TANGAN </b></td>
                    <td rowspan="2" style="border:1px solid #000;"></td>
                </tr>
                <tr>
                    <td><b>2. NAMA : </b><?php echo $profil->nama_pt; ?></td>
                    <td><p style="margin: 0; text-align: center;"><?php echo date('d-m-Y', strtotime($model->tglbayarjasa)); ?></p></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
</table>
<table width="100%" class="tab_objek">
    <tr>
        <th colspan="3" style="text-align: center; font-weight: bold; border: 1px solid black; padding: 5px; background-color: #B7B1B1; color: black;">KODE OBJEK PAJAK PENGHASILAN PASAL 21 (TIDAK FINAL) ATAU PASAL 26</th>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="2" style="font-weight: bold;">PPh PASAL 21 TIDAK FINAL</td>
    </tr>
    <tr>
        <td width="25">1. </td>
        <td width="100">21-100-03</td>
        <td>Upah Pegawai Tidak Tetap atau Tenaga Kerja Lepas</td>
    </tr>
    <tr>
        <td>2</td>
        <td>21-100-04</td>
        <td>Imbalan Kepada Distributor Multi Level Marketing (MLM)</td>
    </tr>
    <tr>
        <td>3</td>
        <td>21-100-05</td>
        <td>Imbalan Kepada Petugas Dinas Luar Asuransi</td>
    </tr>
    <tr>
        <td>4</td>
        <td>21-100-06</td>
        <td>Imbalan Kepada Penjaja Barang Dagangan</td>
    </tr>
    <tr>
        <td>5</td>
        <td>21-100-07</td>
        <td>Imbalan Kepada Tenaga Ahli</td>
    </tr>
    <tr>
        <td>6.</td>
        <td>21-100-08</td>
        <td>Imbalan Kepada Bukan Pegawai yang Menerima Penghasilan yang Bersifat Berkesinambungan</td>
    </tr>
    <tr>
        <td>7</td>
        <td>21-100-09</td>
        <td>Imbalan Kepada Bukan Pegawai yang Menerima Penghasilan yang Tidak Bersifat Berkesinambungan</td>
    </tr>
    <tr>
        <td>8</td>
        <td>21-100-10</td>
        <td>Honorarium atau Imbalan Kepada Anggota Dewan Komisaris atau Dewan Pengawas yang Tidak Merangkap sebagai Pegawai Tetap</td>
    </tr>
    <tr>
        <td>9</td>
        <td>21-100-11</td>
        <td>Jasa Produksi, Tantiem, Bonus atau Imbalan Kepada Mantan Pegawai</td>
    </tr>
    <tr>
        <td>10</td>
        <td>21-100-12</td>
        <td>Penarikan Dana Pensiun oleh Pegawai</td>
    </tr>
    <tr>
        <td>11</td>
        <td>21-100-13</td>
        <td>Imbalan Kepada Peserta Kegiatan</td>
    </tr>
    <tr>
        <td>12</td>
        <td>21-100-99</td>
        <td>Objek PPh Pasal 21 Tidak Final Lainnya</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="2" style="font-weight: bold;">PPh PASAL 26</td>
    </tr>
    <tr>
        <td style="width: 20px;">1.</td>
        <td>27-100-99</td>
        <td>Imbalan sehubungan dengan jasa, pekerjaan dan kegiatan, hadiah dan penghargaan, pensiun dan pembayaran berkala lainnya yang dipotong PPh Pasal 26</td>
    </tr>
</table>

<br>
<br>
<?php // $this->endWidget(); ?>

<?php
if(!isset($caraPrint)){
    
?>

<br>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printRincian(\'PRINT\')')); 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'printRincian(\'PDF\')')); 
    ?>
</div>

<?php
$penggajianpeg_id = isset($_GET['penggajianpeg_id']) ? $_GET['penggajianpeg_id'] : null;
$urlPrint= Yii::app()->controller->createUrl(Yii::app()->controller->id."/formulir",array('pembayaranjasa_id'=>$model->pembayaranjasa_id));
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
