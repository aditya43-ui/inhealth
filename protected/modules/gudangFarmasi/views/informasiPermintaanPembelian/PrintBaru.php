<?php
if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judul_print . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
}
?>
<?php
echo CHtml::css('.control-label{
        float:left;
        text-align: right;
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
');
?>
<style>

    body {
        color: black;
    }

    .border th, .border td{
        border:1px solid #000;
        padding:2px;
    }
    .table thead:first-child{
        border-top:1px solid #000;
    }

    thead th{
        background:none;
        color:#333;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
<?php
if (!$modPermintaanPembelianDetail) {
    echo "Data tidak ditemukan";
    exit;
}
$judulLaporan = "PERMINTAAN PEMBELIAN OBAT ALKES";
$konfig = KonfigsystemK::model()->find();
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$alamatrs = $modProfilRs->alamatlokasi_rumahsakit . ", Kelurahan " . $modProfilRs->kelurahan->kelurahan_nama . ", Kecamatan " . $modProfilRs->kecamatan->kecamatan_nama . ", " . $modProfilRs->kabupaten->kabupaten_nama;

$model = $modPermintaanPembelian;
$modDetails = $modPermintaanPembelianDetail;
?>
<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));

$norencana = "";
$tglrencan = "";
if(isset($model->rencanakebfarmasi)){
    $norencana = $model->rencanakebfarmasi->noperencnaan;
    $tglrencan = MyFormatter::formatDateTimeForUser($model->rencanakebfarmasi->tglperencanaan);
}
?>
<table width="100%" class="tableHead">
    <!-- <tr>
        <td style="text-align: center;">
            <img src="<?php echo Yii::app()->baseUrl.'/images/logo-rspmc-transparan.png'; ?> " width="400px"/>
        </td>
    </tr> -->
    <tr>
        <td style="text-align: center; border-bottom: 2px solid #000;">
            <div class="headingNew" style="display:flex; align-items:center;">
                <div class="logo" style="width:20%;"><img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 80px; width:80px;"/></div>
                <div class="alamat" style="width:60%;">
                    <?php echo $konfig->alamatheadersurat; ?>
                </div>
            </div>
            
        
            
            <!--Jalan Raya Maos-Sampang, Kelurahan Karangtengah, Kecamatan Sampang, Kabupaten Cilacap-->
            <br>
            <br>
        </td>
    </tr>
</table>
<table style="margin:0 auto; ">
        <?php
            if(isset($judulLaporan) || strlen($judulLaporan) > 0){
        ?>
             <TR>
                <TD style="text-align: center;" colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE ><font color="black"><h3><?php echo $judulLaporan ?></h3></font></TD>
            </TR>
        <?php
            }
        ?>
</table>
<br />
<table width="100%">
    <tr>
        <td width="50%">
            <table width="100%">
                <tr>
                    <td width="120px">No. Permintaan</td>
                    <td>
                        : <?php echo $model->nopermintaan; ?>
                    </td>
                </tr>
                <tr>
                    <td>Tgl. Permintaan</td>
                    <td>
                        : <?php echo MyFormatter::formatDateTimeForUser($model->tglpermintaanpembelian); ?>
                    </td>
                </tr>
                <tr>
                    <td>Tgl. minta Dikirim</td>
                    <td>
                        : <?php echo (!empty($model->tgldikirim)? MyFormatter::formatDateTimeForUser($model->tgldikirim) : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>No. Rencana</td>
                    <td>
                        : <?php echo $norencana; ?>
                    </td>
                </tr>
                <tr>
                    <td>Tgl. Rencana</td>
                    <td>
                        : <?php echo $tglrencan; ?>
                    </td>
                </tr>
                <tr>
                    <td>Pegawai Pemesan</td>
                    <td>
                        : <?php echo (isset($model->pegawai)?$model->pegawai->namaLengkap:""); ?>
                    </td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>
                        : <?php echo preg_replace('/\s\s+/', '<br />', $model->keteranganpermintaan); ?>
                    </td>
                </tr>
                <tr>
                    <td>Jenis PPh</td>
                    <td>
                        : <?php echo (isset($model->pajak)?$model->pajak->pajak_nama:""); ?>
                    </td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="150px">No Referensi</td>
                    <td>
                        : <?php echo $model->noreferensi; ?>
                    </td>
                </tr>
                <tr>
                    <td>Sumber Dana</td>
                    <td>
                        :  <?php echo (isset($model->sumberdana)?$model->sumberdana->sumberdana_nama:""); ?>
                    </td>
                </tr>
                <tr>
                    <td>Supplier</td>
                    <td>
                        :  <?php echo (isset($model->supplier)?$model->supplier->supplier_nama:""); ?>
                    </td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>
                        :  <?php echo (isset($model->supplier)?$model->supplier->supplier_alamat:""); ?>
                    </td>
                </tr>
                <tr>
                    <td>No. Telp</td>
                    <td>
                        :  <?php echo (isset($model->supplier)?$model->supplier->supplier_telp:""); ?>
                    </td>
                </tr>
                <tr>
                    <td>Tgl. Permintaan Uang Muka</td>
                    <td>
                        :  <?php echo (!empty($model->tglpermintaanuangmuka)?MyFormatter::formatDateTimeForUser($model->tglpermintaanuangmuka):"-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>Jumlah Permintaan Uang Muka</td>
                    <td>
                        :  Rp. <?php echo (!empty($model->jmlpermintaanuangmuka)? MyFormatter::formatNumberForPrint($model->jmlpermintaanuangmuka,2): "-"); ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<br />
     <table width="100%" style='margin-left:auto; margin-right:auto;' class ="border" >
        <thead>
            <tr class="border">
            <th class="text-center">No.</th>
                <th class="text-center">Kode</th>
                <th class="text-center">Nama Obat & Alkes</th>
                <th class="text-center">Zat Aktif</th>
                <th class="text-center">Bentuk/<br/> Kekuatan</th>
                <th class="text-center">Jumlah Permintaan</th>
                <th class="text-center">Kemasan Terkecil</th>
                <th class="text-center">Harga Satuan (Rp.)</th>
                <th class="text-center">Keringanan (%)</th>
                <th class="text-center">Keringanan (Rp.)</th>
                <th class="text-center">PPN (%)</th>
                <th class="text-center">PPN (Rp.)</th>
                <th class="text-center">PPh (%)</th>
                <th class="text-center">PPh (Rp.)</th>
                <th class="text-center">HPP</th>
                <th class="text-center">Sub Total (Rp.)</th>
                <th class="text-center">Keterangan</th>
            </tr>
        </thead>
        <?php
        $total = 0;
        $subtotal = 0;
        $satuanobat = "";
        foreach ($modDetails as $i=>$modObat){
            $oa = ObatalkesM::model()->findByPk($modObat->obatalkes_id);

            $kemasanJml = 0;
                if (!empty($modObat->satuanbesar_id)) {
                    if($modObat->kemasanbesar>0){
                        $kemasanJml = ($modObat->jmlpermintaan * $modObat->kemasanbesar);
                    }
                }else{
                    $kemasanJml = $modObat->jmlpermintaan;
                }

             $jmlTotal = round(($modObat->harganettoper * $kemasanJml),2);
                $jmlDiskon = round((($jmlTotal * $modObat->persendiscount)/100),2);
                $jmlPPn = round(((($jmlTotal - $jmlDiskon) * $modObat->persenppn)/100),2);
                $jmlPPh = round(((($jmlTotal - $jmlDiskon) * $modObat->persenpph)/100),2);
                $total = ($jmlTotal - $jmlDiskon + $jmlPPn - $jmlPPh);
                $subtotal =  $subtotal + $total;

                 if (!empty($modObat->satuanbesar_id)) {
                    $besar = SatuanbesarM::model()->findByPk($modObat->satuanbesar_id);
                    $satuanobat = $besar->satuanbesar_nama;
                } else if (!empty($modObat->satuankecil_id)) {
                    $kecil = SatuankecilM::model()->findByPk($modObat->satuankecil_id);
                    $satuanobat = $kecil->satuankecil_nama;
                }
        ?>
             <tr class="border">
                <td><?php echo ($i+1)."."; ?></td>
                <td><?php echo $modObat->obatalkes->obatalkes_kode; ?></td>
                <td><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                <td>
                    <?php
                    $modZatAktif = ObatalkeszataktifM::model()->findAllByAttributes(array(
                        'obatalkes_id'=>$oa->obatalkes_id
                    ));

                    $zatAktif = "-";
                    if (count((array)$modZatAktif) > 0) {
                        $zatAktif = "<ul>";
                        foreach ($modZatAktif as $item) {
                            $zatAktif .= "<li>".$item->obatalkeszataktif_nama."</li>";
                        }
                        $zatAktif .= "</ul>";
                    }
                    echo $zatAktif;
                    ?>
                </td>
                <td>
                    <?php echo $oa->bentuk_obat." / ".$oa->kekuatan." ".$oa->satuankekuatan; ?>
                </td>
                <td style = "text-align:right;"><?php echo number_format($modObat->jmlpermintaan,0,"",".")." ".$satuanobat; ?></td>
               <td style = "text-align:right;"><?php echo (!empty($modObat->satuanbesar_id) ? number_format($modObat->kemasanbesar,0,"",".")." ". (isset($oa->satuankecil)?$oa->satuankecil->satuankecil_nama:""):"-"); ?></td>
                <td style = "text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangFarmasi()==true)?MyFormatter::formatNumberForPrint($modObat->harganettoper, 2):"Hidden"; ?></td>
                <td style="text-align:right;"><?php echo number_format($modObat->persendiscount,2,",",""); ?></td>
                <td style="text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangFarmasi()==true)?number_format($jmlDiskon,2,",","."):"Hidden"; ?></td>
                <td style="text-align:right;"><?php echo number_format($modObat->persenppn,0,"","."); ?></td>
                <td style="text-align:right;" ><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangFarmasi()==true)?number_format($jmlPPn,2,",","."):"Hidden"; ?></td>
                <td style="text-align:right;" ><?php echo number_format($modObat->persenpph,2,",","."); ?></td>
                <td style="text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangFarmasi()==true)?number_format($jmlPPh,2,",","."):"Hidden"; ?></td>
                <td style="text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangFarmasi()==true)?number_format($total,2,",","."):"Hidden"; ?></td>
                <td style="text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangFarmasi()==true)?number_format($total,2,",","."):"Hidden"; ?></td>
                <td>
                    <?php echo $modObat->keterangan; ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan = "15" style="text-align:right;" align="center"><strong>Total</strong></td>
            <td style = "text-align:right;" class="border"><strong><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangFarmasi()==true)? MyFormatter::formatNumberForPrint($subtotal, 2):"Hidden"; ?></strong></td>
            <td></td>
        </tr>
</table>
<br><br>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3">Pesanan tersebut akan dipergunakan untuk :</td>
    </tr>
    <tr>
        <td  width="20%">Nama Sarana</td>
        <td width="5px">:</td>
        <td>Instalasi Farmasi <?php echo $modProfilRs->nama_rumahsakit; ?></td>
    </tr>
    <tr>
        <td  width="20%">Alamat</td>
        <td>:</td>
        <td><?php echo ucwords(strtolower($modPermintaanPembelian->alamatpengiriman)); ?></td>
    </tr>
</table><br/>

<table width="100%">
    <tr>
       <td width="35%">&nbsp;</td>
       <td width="30%">&nbsp;</td>
       <td width="35%" style="text-align: center;">
       Direktur, <br />Menyetujui
       <br/><br/><br/><br/><br/>
       <?php echo $model->pegawaimenyetujui->NamaLengkap;?>
       </td>
    </tr>
</table>
<div class="footer">
    <p>Surat Pesanan ini telah disetujui dan disahkan secara Elektronik</p>
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>
