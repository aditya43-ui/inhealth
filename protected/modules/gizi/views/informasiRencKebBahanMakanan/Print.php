<p style="margin: 0; text-align: center;">

    <?php
    if ($caraprint == 'EXCEL') {

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judul_print . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
    if ($caraprint == 'EXCEL') {
        echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => '', 'colspan' => 13));
    } else {
        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => '', 'colspan' => 10));
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
	td {
		vertical-align: top;
	}
    .border{
        border:1px solid #000;
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
    /*.kertas{
     width:20cm;
     height:12cm;
    }*/
');
    ?>
    <?php
    if (!$modRencanaKebBarangDetail) {
        echo "Data tidak ditemukan.";
        exit;
    }
    //echo $this->renderPartial('application.views.headerReport.headerRincian');
    $format = new MyFormatter;
    $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    $tglrencana = MyFormatter::formatDateTimeForUser($modRencanaKebBarang->renkebbahanmakanan_tgl);
    ?>

    <body class="kertas">
        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center" valig="middle" colspan="2">
                    <b>
                        <h3><?php echo $judul_print; ?></h3>
                    </b>
                </td>
            </tr>

        </table> <br>
        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:150px">
                    <h4>No. Rencana</h4>
                </td>
                <td style="width:10px">
                    <h4>:</h4>
                </td>
                <td>
                    <h4><?php echo $modRencanaKebBarang->renkebbahanmakanan_no; ?></h4>
                </td>

                <td style="width:150px">
                    <h4>Sumber Dana</h4>
                </td>
                <td style="width:10px">
                    <h4>:</h4>
                </td>
                <td>
                    <h4><?php echo (!empty($modRencanaKebBarang->sumberdana_id) ? $modRencanaKebBarang->sumberdana->sumberdana_nama : ""); ?></h4>
                </td>
            </tr>
            <tr>
                <td>
                    <h4>Tanggal Rencana : </h4>
                </td>
                <td>
                    <h4>:</h4>
                </td>
                <td>
                    <h4><?php echo $format->formatDateTimeForUser(MyFormatter::formatDateTimeForUser($modRencanaKebBarang->renkebbahanmakanan_tgl)); ?></h4>
                </td>
            </tr>
        </table><br>
        <?php
        $tr = ($caraprint == 'PDF') ? '<tr>' : '<thead>';
        $tr1 = ($caraprint == 'PDF') ? '</tr>' : '</thead>';
        ?>
        <table class="table" style="box-shadow:none;">
            <?php echo $tr; ?>
            <th class="border" style="text-align: center;">No.</th>
            <th class="border" style="text-align: center;">Golongan</th>
            <th class="border" style="text-align: center;">Jenis</th>
            <th class="border" style="text-align: center;">Kelompok</th>
            <th class="border" style="text-align: center;">Nama Bahan Makanan</th>
            <th class="border" style="text-align: center;">Satuan </th>
            <th class="border" style="text-align: center;">Stok Akhir</th>
            <th class="border" style="text-align: center;">Minimal Stok</th>
            <th class="border" style="text-align: center;">Maksimal Stok</th>
            <th class="border" style="text-align: center;">Jumlah Kebutuhan</th>
            <th class="border" width="75" style="text-align: center;">Harga</th>
            <th class="border" style="text-align: center;">PPN (%)</th>
            <th class="border" style="text-align: center;">PPN (Rp)</th>
            <th class="border" width="75" style="text-align: center;">Sub Total</th>
            <?php echo $tr1; ?>
            <?php
            $total = 0;
            $subtotal = 0;
            foreach ($modRencanaKebBarangDetail as $i => $modBarang) {
                $barang = BahanmakananM::model()->findByPk($modBarang->bahanmakanan_id);
                $gol_nama = "";
                if (!empty($barang->golbahanmakanan_id)) {
                    $gol = GolbahanmakananM::model()->findByPk($barang->golbahanmakanan_id);
                    if (!empty($gol)) {
                        $gol_nama = $gol->golbahanmakanan_nama;
                    }
                }
                $jmlTotal = ($modBarang->harga_barangdet * $modBarang->jmlpermintaandet);
                $jmlppn = (($jmlTotal * $modBarang->persen_ppn) / 100);
                $subtotal = ($jmlTotal + $jmlppn);
                $total += $subtotal;

            ?>
                <tr>
                    <td class="border" style="text-align: center;"><?php echo ($i + 1) . "."; ?></td>
                    <td class="border"><?php echo $gol_nama; ?></td>
                    <td class="border"><?php echo $barang->jenisbahanmakanan; ?></td>
                    <td class="border"><?php echo $barang->kelbahanmakanan; ?></td>
                    <td class="border"><?php echo (!empty($modBarang->bahanmakanan_id)) ? $barang->namabahanmakanan : ""; ?></td>
                    <td class="border" style="text-align: center;"><?php echo $modBarang->satuanbahan; ?></td>
                    <td class="border" style="text-align: center;" nowrap><?php echo $modBarang->stokakhir_bahanmakanan; ?></td>
                    <td class="border" style="text-align: center;" nowrap><?php echo $modBarang->minstok_bahanmakanan; ?></td>
                    <td class="border" style="text-align: center;" nowrap><?php echo $modBarang->makstok_bahanmakanan; ?></td>
                    <td class="border" style="text-align: center;"><?php echo number_format($modBarang->jmlpermintaandet, 2, ",", "."); ?></td>
                    <td class="border" style="text-align: right;" nowrap><?php echo (Params::cekHiddenHargaGizi() == true) ? "Rp " . number_format($modBarang->harga_barangdet, 2, ",", ".") : "Hidden"; ?></td>
                    <td class="border" style="text-align: center;"><?php echo $modBarang->persen_ppn; ?></td>
                    <td class="border" style="text-align: right;" nowrap><?php echo (Params::cekHiddenHargaGizi() == true) ? "Rp " . number_format($jmlppn, 2, ",", ".") : "Hidden"; ?></td>
                    <td class="border" style="text-align: right;" nowrap><?php
                                                                            echo (Params::cekHiddenHargaGizi() == true) ? "Rp " . number_format($subtotal, 2, ",", ".") : "Hidden"; ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td class="border" colspan="13" style="text-align: right;"><b>Total (Rp)</b></td>
                <td class="border" style="text-align:right;"><b>
                        <?php echo (Params::cekHiddenHargaGizi() == true) ? number_format($total, 2, ",", ".") : "Hidden"; ?>
                    </b>
                </td>
            </tr>
        </table>
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
                    renkebbarang_id = '<?php echo isset($modRencanaKebBarang->renkebbarang_id) ? $modRencanaBarang->renkebbarang_id : ''; ?>';
                    window.open('<?php echo $this->createUrl('print'); ?>&rencanakebfarmasi_id=' + rencanakebfarmasi_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
                }
            </script>
        <?php
        } else { ?>
            <table width="100%" style="margin-top:20px;">
                <tr>
                    <td width="100%" align="left" align="top">
                        <table style="width: 100%; border: none;">
                            <tr>
                                <td width="35%" align="center">
                                    <div>Mengetahui</div>
                                </td>
                                <td width="35%" align="center">
                                </td>
                                <td width="35%" align="center">
                                    <div>Dibuat Oleh :</div>

                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <?php
                            if ($caraprint != 'PRINT') {
                            ?>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td align="center">
                                    <div style="margin-top:60px;"><?php echo isset($modRencanaKebBarang->pegmenyetujui_id) ? $modRencanaKebBarang->pegawaimenyetujui->NamaLengkap : "" ?></div>
                                </td>
                                <td>&nbsp;</td>
                                <td align="center">
                                    <div style="margin-top:60px;"><?php echo isset($modRencanaKebBarang->pegawai_id) ? $modRencanaKebBarang->pegawai->NamaLengkap : "" ?></div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td align="center">
                                    <div>(Petugas Gudang Umum)</div>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
    </body>
<?php } ?>