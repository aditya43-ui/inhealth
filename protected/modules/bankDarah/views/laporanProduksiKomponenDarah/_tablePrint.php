<?php
/**
 * - digunakan sebagai Laporan Skrining IMLTD
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 * */
?>
<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    //$data = $model->searchTable();
    //$template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    if ($caraPrint == 'PDF') {
        $table = 'ext.bootstrap.widgets.BootGridViewPDF';
    }

    $itemCssClass = 'table border';
} else {
    //$data = $model->searchTable();
    //$template = "{summary}\n{items}\n{pager}";
}
?>

<div>
    <table width="100%" class="table table-bordered table-condensed" border="1px" style="text-align:center; font-weight: bold" id="table-laporan">
        <thead>
            <tr>
                <td rowspan="2" style="text-align:center;">Tanggal</td>
                <td rowspan="2" style="text-align:center;">Jumlah Donor</td>
                <td rowspan="2" style="text-align:center;">Gagal Sadap</td>
                <td rowspan="2" style="text-align:center;">IMLTD Reaktif</td>
                <td colspan="4" style="text-align:center;">Jenis Kantong</td>
                <td colspan="6" style="text-align:center;">Jenis Komponen</td>
                <td rowspan="2" style="text-align:center;">Gagal Produksi</td>
                <td rowspan="2" style="text-align:center;">Keterangan</td>
                <td rowspan="2" style="text-align:center;">Asal Darah</td>
            </tr>
            <tr>
                <td style="text-align:center;">SG</td>
                <td style="text-align:center;">DB</td>
                <td style="text-align:center;">TR</td>
                <td style="text-align:center;">QD</td>
                <td style="text-align:center;">WB</td>
                <td style="text-align:center;">PRC</td>
                <td style="text-align:center;">TC</td>
                <td style="text-align:center;">FFP</td>
                <td style="text-align:center;">PCR</td>
                <td style="text-align:center;">AHF</td>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($data != null) {
                $no_urut = 1;
                $jumlah_donor = 0;
                $gagal_sadap = 0;
                $skrining = 0;
                $kantong_sg = 0;
                $kantong_db = 0;
                $kantong_tr = 0;
                $kantong_qd = 0;
                $komponen_wb = 0;
                $komponen_prc = 0;
                $komponen_tc = 0;
                $komponen_ffp = 0;
                $komponen_pcr = 0;
                $komponen_ahf = 0;
                foreach ($data as $i => $d) {
                    $jumlah_donor = $jumlah_donor + $d['jumlah_donor'];
                    $gagal_sadap = $gagal_sadap + $d['gagal_sadap'];
                    $skrining = $skrining + $d['skrining'];
                    $kantong_sg = $kantong_sg + $d['kantong_sg'];
                    $kantong_db = $kantong_db + $d['kantong_db'];
                    $kantong_tr = $kantong_tr + $d['kantong_tr'];
                    $kantong_qd = $kantong_qd + $d['kantong_qd'];
                    $komponen_wb = $komponen_wb + $d['komponen_wb'];
                    $komponen_prc = $komponen_prc + $d['komponen_prc'];
                    $komponen_tc = $komponen_tc + $d['komponen_tc'];
                    $komponen_ffp = $komponen_ffp + $d['komponen_ffp'];
                    $komponen_pcr = $komponen_pcr + $d['komponen_pcr'];
                    $komponen_ahf = $komponen_ahf + $d['komponen_ahf'];
                    ?>
                    <tr>   
                        <td><?php echo MyFormatter::formatDateTimeForUser($d['tanggal']); ?></td>
                        <td><?php echo $d['jumlah_donor']; ?></td>
                        <td><?php echo $d['gagal_sadap']; ?></td>
                        <td><?php echo $d['skrining']; ?></td>
                        <td><?php echo $d['kantong_sg']; ?></td>
                        <td><?php echo $d['kantong_db']; ?></td>
                        <td><?php echo $d['kantong_tr']; ?></td>
                        <td><?php echo $d['kantong_qd']; ?></td>
                        <td><?php echo $d['komponen_wb']; ?></td>
                        <td><?php echo $d['komponen_prc']; ?></td>
                        <td><?php echo $d['komponen_tc']; ?></td>
                        <td><?php echo $d['komponen_ffp']; ?></td>
                        <td><?php echo $d['komponen_pcr']; ?></td>
                        <td><?php echo $d['komponen_ahf']; ?></td>
                        <td><?php
                            if (!empty($d['gagal_produksi'])) {
                                $gagalproduksi = array();
                                if ($d['gagal_produksi']['wb'] > 0) {
                                    $gagalproduksi[] = 'WB ' . $d['gagal_produksi']['wb'];
                                }
                                if ($d['gagal_produksi']['prc'] > 0) {
                                    $gagalproduksi[] = 'PRC ' . $d['gagal_produksi']['prc'];
                                }
                                if ($d['gagal_produksi']['ffp'] > 0) {
                                    $gagalproduksi[] = 'FFP ' . $d['gagal_produksi']['ffp'];
                                }
                                if ($d['gagal_produksi']['tc'] > 0) {
                                    $gagalproduksi[] = 'TC ' . $d['gagal_produksi']['tc'];
                                }
                                if ($d['gagal_produksi']['pcr'] > 0) {
                                    $gagalproduksi[] = 'PCR ' . $d['gagal_produksi']['pcr'];
                                }
                                if ($d['gagal_produksi']['cry'] > 0) {
                                    $gagalproduksi[] = 'AHF ' . $d['gagal_produksi']['cry'];
                                }
                                echo implode(",", $gagalproduksi);
                            } else {
                                echo 0;
                            }
                            ?></td>
                        <td>
                            <?php
                            if (!empty($d['keterangan'])) {
                                $data = array();
                                if ($d['keterangan']['wb']['total'] > 0) {
                                    $wb = array();
                                    if ($d['keterangan']['wb']['a'] > 0) {
                                        $wb[] = 'A ' . $d['keterangan']['wb']['a'];
                                    }
                                    if ($d['keterangan']['wb']['b'] > 0) {
                                        $wb[] = 'B ' . $d['keterangan']['wb']['b'];
                                    }
                                    if ($d['keterangan']['wb']['o'] > 0) {
                                        $wb[] = 'O ' . $d['keterangan']['wb']['o'];
                                    }
                                    if ($d['keterangan']['wb']['ab'] > 0) {
                                        $wb[] = 'AB ' . $d['keterangan']['wb']['ab'];
                                    }
                                    $data[] = ' WB(' . implode(", ", $wb) . ')';
                                }
                                if ($d['keterangan']['prc']['total'] > 0) {
                                    $prc = array();
                                    if ($d['keterangan']['prc']['a'] > 0) {
                                        $prc[] = 'A ' . $d['keterangan']['prc']['a'];
                                    }
                                    if ($d['keterangan']['prc']['b'] > 0) {
                                        $prc[] = 'B ' . $d['keterangan']['prc']['b'];
                                    }
                                    if ($d['keterangan']['prc']['o'] > 0) {
                                        $prc[] = 'O ' . $d['keterangan']['prc']['o'];
                                    }
                                    if ($d['keterangan']['prc']['ab'] > 0) {
                                        $prc[] = 'AB ' . $d['keterangan']['prc']['ab'];
                                    }
                                    $data[] = ' PRC(' . implode(", ", $prc) . ')';
                                }
                                if ($d['keterangan']['ffp']['total'] > 0) {
                                    $ffp = array();
                                    if ($d['keterangan']['ffp']['a'] > 0) {
                                        $ffp[] = 'A ' . $d['keterangan']['ffp']['a'];
                                    }
                                    if ($d['keterangan']['ffp']['b'] > 0) {
                                        $ffp[] = 'B ' . $d['keterangan']['ffp']['b'];
                                    }
                                    if ($d['keterangan']['ffp']['o'] > 0) {
                                        $ffp[] = 'O ' . $d['keterangan']['ffp']['o'];
                                    }
                                    if ($d['keterangan']['ffp']['ab'] > 0) {
                                        $ffp[] = 'AB ' . $d['keterangan']['ffp']['ab'];
                                    }
                                    $data[] = ' FFP(' . implode(", ", $ffp) . ')';
                                }

                                if ($d['keterangan']['tc']['total'] > 0) {
                                    $tc = array();
                                    if ($d['keterangan']['tc']['a'] > 0) {
                                        $tc[] = 'A ' . $d['keterangan']['tc']['a'];
                                    }
                                    if ($d['keterangan']['tc']['b'] > 0) {
                                        $tc[] = 'B ' . $d['keterangan']['tc']['b'];
                                    }
                                    if ($d['keterangan']['tc']['o'] > 0) {
                                        $tc[] = 'O ' . $d['keterangan']['tc']['o'];
                                    }
                                    if ($d['keterangan']['tc']['ab'] > 0) {
                                        $tc[] = 'AB ' . $d['keterangan']['tc']['ab'];
                                    }
                                    $data[] = ' TC(' . implode(", ", $tc) . ')';
                                }

                                if ($d['keterangan']['pcr']['total'] > 0) {
                                    $pcr = array();
                                    if ($d['keterangan']['pcr']['a'] > 0) {
                                        $pcr[] = 'A ' . $d['keterangan']['pcr']['a'];
                                    }
                                    if ($d['keterangan']['pcr']['b'] > 0) {
                                        $pcr[] = 'B ' . $d['keterangan']['pcr']['b'];
                                    }
                                    if ($d['keterangan']['pcr']['o'] > 0) {
                                        $pcr[] = 'O ' . $d['keterangan']['pcr']['o'];
                                    }
                                    if ($d['keterangan']['pcr']['ab'] > 0) {
                                        $pcr[] = 'AB ' . $d['keterangan']['pcr']['ab'];
                                    }
                                    $data[] = ' PCR(' . implode(", ", $pcr) . ')';
                                }

                                if ($d['keterangan']['cry']['total'] > 0) {
                                    $cry = array();
                                    if ($d['keterangan']['cry']['a'] > 0) {
                                        $cry[] = 'A ' . $d['keterangan']['cry']['a'];
                                    }
                                    if ($d['keterangan']['cry']['b'] > 0) {
                                        $cry[] = 'B ' . $d['keterangan']['cry']['b'];
                                    }
                                    if ($d['keterangan']['cry']['o'] > 0) {
                                        $cry[] = 'O ' . $d['keterangan']['cry']['o'];
                                    }
                                    if ($d['keterangan']['cry']['ab'] > 0) {
                                        $cry[] = 'AB ' . $d['keterangan']['cry']['ab'];
                                    }
                                    $data[] = ' AHF(' . implode(", ", $cry) . ')';
                                }

                                echo implode(",", $data);
                            } else {
                                echo '-';
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if (!empty($d['asal'])) {
                                $cekruangan = RuanganM::model()->findByPk($d['asal']);
                                $ruangan = !empty($cekruangan) ? $cekruangan->ruangan_nama : '-';
                                echo $ruangan;
                            } else {
                                echo '-';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                    $no_urut++;
                }
            }
            ?>
            <tr>
                <td>Total</td>
                <td><?php echo $jumlah_donor; ?></td>
                <td><?php echo $gagal_sadap; ?></td>
                <td><?php echo $skrining; ?></td>
                <td><?php echo $kantong_sg; ?></td>
                <td><?php echo $kantong_db; ?></td>
                <td><?php echo $kantong_tr; ?></td>
                <td><?php echo $kantong_qd; ?></td>
                <td><?php echo $komponen_wb; ?></td>
                <td><?php echo $komponen_prc; ?></td>
                <td><?php echo $komponen_tc; ?></td>
                <td><?php echo $komponen_ffp; ?></td>
                <td><?php echo $komponen_pcr; ?></td>
                <td><?php echo $komponen_ahf; ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

<table style="margin-top: 10px;width:100%">
    <tr>
        <td width="50%" style="text-align: center"> Penanggung Jawab</td>
        <td width="50%" style="text-align: center"> Surabaya,<?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d")) ?></td>
    </tr>
    <tr>
        <td width="50%" style="text-align: center;">Koordinator Pelayanan Donor<br><br><br><br><br><br></td>
        <td width="50%" style="text-align: center;">Petugas Pelaksana<br><br><br><br><br><br></td>
    </tr>
    <tr>
        <td width="50%" style="text-align: center"> (Rosa Rusdiana)</td>
        <td width="50%" style="text-align: center"> (.....................................)</td>
    </tr>
</table>