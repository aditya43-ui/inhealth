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
    echo "Data tidak ditemukan.";
    exit;
}
$judulLaporan = "SURAT PESANAN";
$konfig = KonfigsystemK::model()->find();
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$alamatrs = $modProfilRs->alamatlokasi_rumahsakit . ", Kelurahan " . $modProfilRs->kelurahan->kelurahan_nama . ", Kecamatan " . $modProfilRs->kecamatan->kecamatan_nama . ", " . $modProfilRs->kabupaten->kabupaten_nama;

//if (!isset($_GET['frame'])){
//    echo $this->renderPartial($this->path_view.'_headerObat'); 
//}
?>
<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF') {
    ?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                        ?></div>  
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">
                        <br>
                        <div class="judulcontent"><table style="margin:0 auto; ">
                                <?php
                                if (isset($judulLaporan) || strlen($judulLaporan) > 0) {
                                    ?>
                                    <tr>
                                        <td style="border-bottom: 2px solid #000000; text-align: center;" colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE ><span color="black"><h3><?php echo $judulLaporan ?></h3></span></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                                $deskripsi = (isset($deskripsi) ? $deskripsi : null);
                                if (isset($deskripsi) || strlen($deskripsi) > 0) {
                                    ?>
                                    <tr>
                                        <td style="text-align: center;" colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE><span color="black"><?php echo $deskripsi ?></span></td>
                                    </tr>  
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE></td>
                                </tr>  
                                <tr>
                                    <td style="text-align: center;" colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE>Nomor : <?php echo $modPermintaanPembelian->nopermintaan; ?></td>
                                </tr>
                            </table></div>
                        <br>

                        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>Yang bertanda tangan di bawah ini:</td>
                            </tr>
                            <tr>
                                <td width="20%">Nama</td>
                                <td>:</td>
                                <td><?php echo $modPermintaanPembelian->pegawaiapoteker->namaLengkap; ?></td>
                            </tr>
                            <tr>
                                <td width="20%">Jabatan</td>
                                <td>:</td>
                                <td><?php echo (!empty($modPermintaanPembelian->pegawaiapoteker->jabatan_id) ? $modPermintaanPembelian->pegawaiapoteker->jabatan->jabatan_nama : ""); ?></td>
                            </tr>
                        </table><br>
                        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>Mengajukan pesanan kepada :</td>
                            </tr>
                            <tr>
                                <td width="20%">Nama Distributor</td>
                                <td>:</td>
                                <td><?php echo $modPermintaanPembelian->supplier->supplier_nama; ?></td>
                            </tr>
                            <tr>
                                <td width="20%">Alamat</td>
                                <td>:</td>
                                <td><?php echo (!empty($modPermintaanPembelian->supplier_id) ? $modPermintaanPembelian->supplier->supplier_alamat : ""); ?></td>
                            </tr>
                            <tr>
                                <td width="20%">Telp</td>
                                <td>:</td>
                                <td><?php echo (!empty($modPermintaanPembelian->supplier_id) ? $modPermintaanPembelian->supplier->supplier_telp : ""); ?></td>
                            </tr>
                            <tr>
                                <td width="20%">No Referensi</td>
                                <td>:</td>
                                <td><?php echo (!empty($modPermintaanPembelian->noreferensi)?$modPermintaanPembelian->noreferensi:""); ?></td>
                            </tr>
                        </table><br>
                        <p>Dengan barang yang dipesan adalah : </p><br>
                        <table width="100%" style='margin-left:auto; margin-right:auto;' class ="border">
                            <thead class="border">
                            <th>No.</th>
                            <th>Nama Barang</th>
                            <th>Merk Dagang</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
                            <th>PPn (%)</th>
                            <th>PPn (Rp)</th>
                            <th>HPP</th>
                            <th>Sub Total</th>
                            </thead>
                            <tbody>

                                <?php
                                $total = 0;
                                $subtotal = 0;
                                foreach ($modPermintaanPembelianDetail as $i => $modObat) {
                                    $oa = ObatalkesM::model()->findByPk($modObat->obatalkes_id);
                                    $total += $modObat->hpp;
                                    ?>
                                    <tr class="border">
                                        <td><?php echo ($i + 1) . "."; ?></td>
                                        <td><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                                        <td>
                                            <?php
                                            $zatobat = ObatalkeszataktifM::model()->findAllByAttributes(array('obatalkes_id' => $modObat->obatalkes_id));
                                            $zatvalue = "";
                                            if (count((array)$zatobat) > 0) {
                                                foreach ($zatobat as $i => $datazat) {
                                                    if ($i > 0) {
                                                        $zatvalue .= ", ";
                                                    }
                                                    $zatvalue .= $datazat->obatalkeszataktif_nama;
                                                }
                                            }
                                            echo $zatvalue;
                                            ?>
                                        </td>
                                        <td style = "text-align:right;"><?php echo number_format($modObat->jmlpermintaan, 0, "", "."); ?></td>
                                        <td style = "text-align:right;"><?php
                                            if (!empty($modObat->satuanbesar_id)) {
                                                $besar = SatuanbesarM::model()->findByPk($modObat->satuanbesar_id);
                                                echo $besar->satuanbesar_nama;
                                            } else if (!empty($modObat->satuankecil_id)) {
                                                $kecil = SatuankecilM::model()->findByPk($modObat->satuankecil_id);
                                                echo $kecil->satuankecil_nama;
                                            }
                                            ?></td>
                                        <td style = "text-align:right;"><?php echo "Rp" . MyFormatter::formatNumberForPrint($modObat->harganettoper, 2) ; ?></td>
                                        <td style = "text-align:right;"><?php echo ($modObat->persenppn) ; ?></td>
                                        <td style = "text-align:right;"><?php echo "Rp" . MyFormatter::formatNumberForPrint($modObat->ppn, 2) ; ?></td>
                                        <td style = "text-align:right;"><?php echo "Rp" . MyFormatter::formatNumberForPrint($modObat->hpp, 2) ; ?></td>
                                        <td style = "text-align:right;"><?php echo "Rp" . MyFormatter::formatNumberForPrint($modObat->hpp, 2) ; ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan = "9" style="text-align:right;" align="center"><b>Total Harga</b></td>
                                    <td style = "text-align:right;" class="border"><b><?php echo "Rp" . MyFormatter::formatNumberForPrint($total, 2) ; ?></b></td>
                                </tr>
                            </tbody>
                        </table><br><br>
                        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="width: 80px" valign="top">Keterangan :</td>
                                <td><?php echo preg_replace('/\s\s+/', '<br>', $modPermintaanPembelian->keteranganpermintaan); ?></td>
                            </tr>

                        </table><br>
                        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td colspan="3">Pesanan tersebut akan dipergunakan untuk :</td>
                            </tr>
                            <tr>
                                <td width="20%">Nama Sarana</td>
                                <td>:</td>
                                <td>Instalasi Farmasi <?php echo $modProfilRs->nama_rumahsakit; ?></td>
                            </tr>
                            <tr>
                                <td width="20%">Alamat</td>
                                <td>:</td>
                                <td><?php echo ucwords(strtolower($modPermintaanPembelian->alamatpengiriman)); ?></td>
                            </tr>
                        </table><br>
                      
                        <div class="row">
                            <div class="col-sm-4" style="text-align:center;">
                                <div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
                                    <!--Manager Umum, <br>Mengetahui-->
                                </div>
                                <div class="control-group">
                                        <!--( <?php // echo $model->pegawaimengetahui->NamaLengkap;  ?> )-->
                                </div>	
                            </div>
                            <div class="col-sm-4" style="text-align:center;">
                                <div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
                                    <!--Manager Keuangan, <br>Mengetahui-->
                                </div>
                                <div class="control-group">
                                        <!--( <?php // echo $model->pegawaimengetahuiumum->NamaLengkap;  ?> )-->
                                </div>
                            </div>
                            <div class="col-sm-4" style="text-align:center;">
                                <div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
                                    <?php echo ucwords(strtolower($modProfilRs->kabupaten->kabupaten_nama)); ?>, <?php echo MyFormatter::getMonthId(date('m')) . " " . date('Y'); ?> <br> Apoteker Penanggung Jawab
                                </div>
                                <div class="control-group">
                                    ( <?php echo $modPermintaanPembelian->pegawaiapoteker->namaLengkap; ?> )
                                </div>
                            </div>
                        </div>
                         
                        <br><br>
                    </div>		
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <div class="footer-space">&nbsp;</div>
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="">
    </div>
    <div class="footer">
        <?php if (isset($caraPrint) && $caraPrint != "PDF") { ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php } ?>
    </div>   

    <?php
}
if ($caraPrint == 'PDF') {
    ?>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <br>
        <div class="judulcontent"> 
            <table style="margin:0 auto; ">
                <?php
                if (isset($judulLaporan) || strlen($judulLaporan) > 0) {
                    ?>
                    <tr>
                        <td style="border-bottom: 2px solid #000000; text-align: center;" colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE ><span color="black"><h3><?php echo $judulLaporan ?></h3></span></td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                $deskripsi = (isset($deskripsi) ? $deskripsi : null);
                if (isset($deskripsi) || strlen($deskripsi) > 0) {
                    ?>
                    <tr>
                        <td style="text-align: center;" colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE><span color="black"><?php echo $deskripsi ?></span></td>
                    </tr>  
                    <?php
                }
                ?>
                <tr>
                    <td colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE></td>
                </tr>  
                <tr>
                    <td style="text-align: center;" colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE>Nomor : <?php echo $modPermintaanPembelian->nopermintaan; ?></td>
                </tr>
            </table></div>
        <br>

        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td>Yang bertanda tangan di bawah ini:</td>
            </tr>
            <tr>
                <td width="20%">Nama</td>
                <td>:</td>
                <td><?php echo $modPermintaanPembelian->pegawaiapoteker->namaLengkap; ?></td>
            </tr>
            <tr>
                <td width="20%">Jabatan</td>
                <td>:</td>
                <td><?php echo (!empty($modPermintaanPembelian->pegawaiapoteker->jabatan_id) ? $modPermintaanPembelian->pegawaiapoteker->jabatan->jabatan_nama : ""); ?></td>
            </tr>
        </table><br>
        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td>Mengajukan pesanan kepada :</td>
            </tr>
            <tr>
                <td width="20%">Nama Distributor</td>
                <td>:</td>
                <td><?php echo $modPermintaanPembelian->supplier->supplier_nama; ?></td>
            </tr>
            <tr>
                <td width="20%">Alamat</td>
                <td>:</td>
                <td><?php echo (!empty($modPermintaanPembelian->supplier_id) ? $modPermintaanPembelian->supplier->supplier_alamat : ""); ?></td>
            </tr>
            <tr>
                <td width="20%">Telp</td>
                <td>:</td>
                <td><?php echo (!empty($modPermintaanPembelian->supplier_id) ? $modPermintaanPembelian->supplier->supplier_telp : ""); ?></td>
            </tr>
            <tr>
                <td width="20%">No Referensi</td>
                <td>:</td>
                <td><?php echo (!empty($modPermintaanPembelian->noreferensi)?$modPermintaanPembelian->noreferensi:""); ?></td>
            </tr>
        </table><br>
        <p>Dengan barang yang dipesan adalah : </p><br>
        <table width="100%" style='margin-left:auto; margin-right:auto;' class ="border">
            <thead class="border">
            <th>No.</th>
            <th>Nama Barang</th>
            <th>Merk Dagang</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Harga Satuan</th>
            <th>PPn (%)</th>
            <th>PPn (Rp)</th>
            <th>HPP</th>
            <th>Sub Total</th>
            </thead>
            <tbody>

                <?php
                $total = 0;
                $subtotal = 0;
                foreach ($modPermintaanPembelianDetail as $i => $modObat) {
                    $oa = ObatalkesM::model()->findByPk($modObat->obatalkes_id);
                    $total += $modObat->hpp * $modObat->jmlpermintaan;
                    ?>
                    <tr class="border">
                        <td><?php echo ($i + 1) . "."; ?></td>
                        <td><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                        <td>
                            <?php
                            $zatobat = ObatalkeszataktifM::model()->findAllByAttributes(array('obatalkes_id' => $modObat->obatalkes_id));
                            $zatvalue = "";
                            if (count((array)$zatobat) > 0) {
                                foreach ($zatobat as $i => $datazat) {
                                    if ($i > 0) {
                                        $zatvalue .= ", ";
                                    }
                                    $zatvalue .= $datazat->obatalkeszataktif_nama;
                                }
                            }
                            echo $zatvalue;
                            ?>
                        </td>
                        <td style = "text-align:right;"><?php echo number_format($modObat->jmlpermintaan, 0, "", "."); ?></td>
                        <td style = "text-align:right;"><?php
                            if (!empty($modObat->satuanbesar_id)) {
                                $besar = SatuanbesarM::model()->findByPk($modObat->satuanbesar_id);
                                echo $besar->satuanbesar_nama;
                            } else if (!empty($modObat->satuankecil_id)) {
                                $kecil = SatuankecilM::model()->findByPk($modObat->satuankecil_id);
                                echo $kecil->satuankecil_nama;
                            }
                            ?></td>
                        <td style = "text-align:right;"><?php echo "Rp" . MyFormatter::formatNumberForPrint($modObat->harganettoper, 2) ; ?></td>
                        <td style = "text-align:right;"><?php echo ($modObat->persenppn) ; ?></td>
                        <td style = "text-align:right;"><?php echo "Rp" . MyFormatter::formatNumberForPrint($modObat->ppn, 2) ; ?></td>
                        <td style = "text-align:right;"><?php echo "Rp" . MyFormatter::formatNumberForPrint($modObat->hpp, 2) ; ?></td>
                        <td style = "text-align:right;"><?php echo "Rp" . MyFormatter::formatNumberForPrint($modObat->hpp * $modObat->jmlpermintaan, 2) ; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan = "9" style="text-align:right;" align="center"><b>Total Harga</b></td>
                    <td style = "text-align:right;" class="border"><b><?php echo "Rp" . MyFormatter::formatNumberForPrint($total, 2) ; ?></b></td>
                </tr>
            </tbody>
        </table><br><br>
        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 80px" valign="top">Keterangan :</td>
                <td><?php echo preg_replace('/\s\s+/', '<br>', $modPermintaanPembelian->keteranganpermintaan); ?></td>
            </tr>

        </table><br>
        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="3">Pesanan tersebut akan dipergunakan untuk :</td>
            </tr>

            <tr>
                <td width="20%">Nama Sarana</td>
                <td>:</td>
                <td>Instalasi Farmasi <?php echo $modProfilRs->nama_rumahsakit; ?></td>
            </tr>
            <tr>
                <td width="20%">Alamat</td>
                <td>:</td>
                <td><?php echo ucwords(strtolower($modPermintaanPembelian->alamatpengiriman)); ?></td>
            </tr>
        </table><br>

        <div class="row">
            <div class="col-sm-4" style="text-align:center;">
                <div class='control-group' style=''>
                    <!--Manager Umum, <br>Mengetahui-->
                </div>
                <div class="control-group">
                        <!--( <?php // echo $model->pegawaimengetahui->NamaLengkap;  ?> )-->
                </div>	
            </div>
            <div class="col-sm-4" style="text-align:center;">
                <div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
                    <!--Manager Keuangan, <br>Mengetahui-->
                </div>
                <div class="control-group">
                        <!--( <?php // echo $model->pegawaimengetahuiumum->NamaLengkap;  ?> )-->
                </div>
            </div>
            <div class="col-sm-4" style="text-align:center;">
                <div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
                    <?php echo ucwords(strtolower($modProfilRs->kabupaten->kabupaten_nama)); ?>, <?php echo MyFormatter::getMonthId(date('m')) . " " . date('Y'); ?> <br> Apoteker Penanggung Jawab
                </div>
                <div class="control-group">
                    ( <?php echo $modPermintaanPembelian->pegawaiapoteker->namaLengkap; ?> )
                </div>
            </div>
        </div>
        <br><br>
    </div>

    <?php
}

?>
<?php
if (isset($_GET['frame'])) {
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')"));
    echo CHtml::link(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('EXCEL')"));
    ?>
    <script type='text/javascript'>
        /**
         * print
         */
        function print(caraPrint) {
            permintaanpembelian_id = '<?php echo isset($modPermintaanPembelian->permintaanpembelian_id) ? $modPermintaanPembelian->permintaanpembelian_id : ''; ?>';
            window.open('<?php echo $this->createUrl('print'); ?>&permintaanpembelian_id=' + permintaanpembelian_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
        }
    </script>
<?php } else {
    ?>
    <!--<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div>Pejabat Pengadaan</div>
                        <div style="margin-top:60px;"><?php // echo isset($modPermintaanPembelian->pegawaimenyetujui_id) ? $modPermintaanPembelian->pegawai->NamaLengkap : ""  ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div style="margin-top:60px;"><b>Mengetahui<br>Direktur</b></div>
                        <div style="margin-top:60px;"><?php // echo $modProfilRs->namadirektur_rumahsakit;   ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div><?php // echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Ka. Instalasi Farmasi</div>
                        <div style="margin-top:60px;"><?php //  echo isset($modPermintaanPembelian->pegawai_id) ? $modPermintaanPembelian->pegawai->NamaLengkap : ""   ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>-->
<?php } ?>
