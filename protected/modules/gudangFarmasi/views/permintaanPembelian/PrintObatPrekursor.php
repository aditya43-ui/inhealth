<style type="text/css">
    table.tableHead tr td {
        padding: 0px;
    }

    table.tableIndex tr td {
        padding: 3px 5px;
    }

    table.obat tr th {
        text-align: center;
        vertical-align: top;
    }

    table.obat tr td, table.obat tr th {
        padding: 3px 5px;
        border: 1px solid #000;
    }
</style>

<?php
//echo $this->renderPartial($this->path_view.'_headerObat'); 
?>
<table width="100%">
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
                    <div class="judulcontent">  <h3><u>SURAT PESANAN OBAT MENGANDUNG PREKURSOR FARMASI</u></h3></div>
                    <center>

                        Nomor: <?php echo $modPermintaanPembelian->nopermintaan; ?>
                    </center>
                    <br>
                    <br>

                    Yang bertanda tangan di bawah ini:
                    <table class="tableIndex">
                        <tr>
                            <td>Nama</td>
                            <td>: <?php echo $apoteker->NamaLengkap; ?></td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>: <?php echo $apoteker->JabatanNama; ?></td>
                        </tr>
                        <tr>
                            <td>Nomor SIPA</td>
                            <td>: <?php echo $apoteker->suratizinpraktek; ?></td>
                        </tr>
                    </table>
                    <br>

                    Mengajukan pesanan obat mengandung Prekursor Farmasi kepada:
                    <table class="tableIndex">
                        <tr>
                            <td>Nama industri Farmasi / PBF / Rumah Sakit</td>
                            <td>: <?php echo $distributor->supplier_nama; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: <?php echo $distributor->supplier_alamat; ?></td>
                        </tr>
                        <tr>
                            <td>Telp</td>
                            <td>: <?php echo $distributor->supplier_telp; ?></td>
                        </tr>
                    </table>
                    Jenis obat mengandung prekursor Farmasi yang dipesan adalah
                    <br>
                    <br>
                    <table class="obat" width="100%">
                        <tr>
                            <th>No</th>
                            <th>Nama obat yang mengandung Prekursor Farmasi</th>
                            <th>Zat Aktif Prekursor Farmasi</th>
                            <th>Bentuk dan kekuatan sediaan</th>
                            <th>Satuan</th>
                            <th>Jumlah dalam bentuk angka dan huruf</th>
                            <th>Ket</th>
                        </tr>
                        <?php
                        if (!empty($modPermintaanPembelianDetail)) {
                            $no = 1;
                            foreach ($modPermintaanPembelianDetail as $key => $val) {
                                echo '<tr>';
                                echo '<td>' . $no . '</td>';
                                echo '<td>' . $val->obatalkes->obatalkes_nama . '</td>';

                                $modZatAktif = ObatalkeszataktifM::model()->findAllByAttributes(array('obatalkes_id' => $val->obatalkes_id));
                                $zatAktif = "-";
                                if (count((array)$modZatAktif) > 0) {
                                    foreach ($modZatAktif as $item) {
                                        $zatAktif .= "- " . $item->obatalkeszataktif_nama . "<br>";
                                    }
                                }

                                echo '<td>' . $zatAktif . '</td>';
                                echo '<td>' . $val->obatalkes->bentuk_obat . ' - ' . $val->obatalkes->kekuatan . ' ' . $val->obatalkes->satuankekuatan . '</td>';
                                echo '<td>' . (isset($val->obatalkes->satuankecil_id) ? $val->obatalkes->satuankecil->satuankecil_nama : "") . '</td>';
                                echo '<td>' . $val->jmlpermintaan . '</td>';
                                echo '<td>' . $val->keterangan . '</td>';
                                echo '<tr>';
                                $no++;
                            }
                        }
                        ?>
                    </table>

                    <br>
                    Obat mengandung Prekursor Farmasi tersebut akan digunakan untuk memenuhi kebutuhan:
                    <table class="tableIndex">
                        <tr>
                            <td>Nama Sarana</td>
                            <td>: Instalasi Farmasi  RS Priscilla Medical Center</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: Jalan Raya Maos-Sampang, Kelurahan Karangtengah, Kecamatan Sampang Kabupaten Cilacap</td>
                        </tr>
                    </table>
                    <br>
                    <br>
                    <table width="100%">
                        <tr>
                            <td width="50%" style="text-align: center; vertical-align: top;">
                                <br>....................................
                            </td>
                            <td style="text-align: center;">
                                Cilacap, <?php echo $format->formatDateTimeId(date('Y-m-d')); ?>
                                <br>
                                Apoteker Penanggung Jawab
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                ( <?php echo $apoteker->NamaLengkap; ?> )
                                <br>
                                No.SIPA <?php echo $apoteker->suratizinpraktek; ?>
                            </td>
                        </tr>
                    </table>
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
