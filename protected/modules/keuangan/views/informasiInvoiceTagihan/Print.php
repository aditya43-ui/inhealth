<p style="margin: 0; text-align: center;">
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
    .kertas{
     width:20cm;
     height:12cm;
    }
');
    ?>
    <?php
    if (!$modInvoice) {
        echo "Data tidak ditemukan.";
        exit;
    }
    echo $this->renderPartial('application.views.headerReport.headerRincian');
    $format = new MyFormatter;
    $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    ?>

    <body class="kertas">
        <div class="col-sm-4">
            <table class='table'>
                <tr>
                    <td>No. Invoice</td>
                    <td><?php echo $modInvoice->invoicetagihan_no ?></td>
                </tr>
                <tr>
                    <td>Tgl. Invoice</td>
                    <td><?php echo $modInvoice->invoicetagihan_tgl ?></td>
                </tr>
                <tr>
                    <td>Dari</td>
                    <td><?php echo $modInvoice->namapenagih ?></td>
                </tr>
                <tr>
                    <td>Perihal</td>
                    <td><?php echo $modInvoice->perihal_tagihan ?></td>
                </tr>
            </table>
        </div>
        <div class="col-sm-4">
            <table class='table'>
                <tr>
                    <td>Rekanan</td>
                    <td><?php echo $modInvoice->rekanan_tagihan ?></td>
                </tr>
                <tr>
                    <td>Keterangan Pembayaran</td>
                    <td><?php echo $modInvoice->ket_pembayaran ?></td>
                </tr>
                <tr>
                    <td>Isi Surat</td>
                    <td><?php echo $modInvoice->isisurat_tagihan ?></td>
                </tr>
            </table>
        </div>
        <div class="col-sm-4">
            <table class='table'>
                <tr>
                    <td>Status Verifikasi</td>
                    <td><?php echo $modInvoice->status_verifikasi == 1 ? 'Sudah Verifikasi' : 'Belum Verifikasi' ?></td>
                </tr>
                <tr>
                    <td>Tanggal Verifikasi</td>
                    <td><?php echo $modInvoice->tgl_verfikasi_tagihan ?></td>
                </tr>
                <tr>
                    <td>Nama Verifikasi RS Luar</td>
                    <td><?php echo $modInvoice->verifikator_nama ?></td>
                </tr>
            </table>
        </div>

        <br><br>
        <br><br>

        <table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
            <thead>
                <th>No.</th>
                <th>Uraiang</th>
                <th>Total</th>
                <th>Keterangan</th>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $total = 0;
                foreach ($modTagDet as $detailTagihan) :
                    $total += $detailTagihan->total_tagdetail;
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $detailTagihan->uraian_tagdetail; ?></td>
                        <td><?php echo MyFormatter::formatUang($detailTagihan->total_tagdetail); ?></td>
                        <td><?php echo $detailTagihan->ket_tagdetail; ?></td>
                    </tr>
                <?php
                    $no++;
                endforeach;
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Total Tagihan</td>
                    <td><?php echo MyFormatter::formatUang($total); ?></td>
                </tr>
            </tbody>
        </table>

        <table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
            <thead>
                <th>No.</th>
                <th>Uraiang</th>
                <th>Total</th>
                <th>Keterangan</th>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($modDetPosisi as $detailPosisi) : ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $detailPosisi->uraian_disoposisi; ?></td>
                        <td><?php echo MyFormatter::formatUang($detailPosisi->total_disposisi); ?></td>
                        <td><?php echo $detailPosisi->ket_disposisi; ?></td>
                    </tr>
                <?php
                    $no++;
                endforeach;
                ?>
            </tbody>
        </table>

        <table width="100%" style="margin-top:20px;">
            <tr>
                <td width="100%" align="left" align="top">
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td width="35%" align="center">
                                <div><?php echo $modInvoice->disetujui_posisi ?><br></div>
                                <div style="margin-top:60px;"><?php echo $modInvoice->disetujui_nama ?></div>
                            </td>
                            <td width="35%" align="center">
                            </td>
                            <td width="35%" align="center">
                                <div><?php echo $modInvoice->verifikator_posisi ?></div>
                                <div style="margin-top:60px;"><?php echo $modInvoice->verifikator_nama ?></div>
                                <div></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>