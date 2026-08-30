<?php
/**
 * perbaikan format Laporan
 * BMB-295
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
?>
<style>
    #tabelstyle th{
        border: 2px #000 solid;
    }
    #tabelstyle td{
        border: 1px #000 solid;
    }
</style>
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
                    <div class="judulcontent"> <?php echo $judulLaporan; ?><br>
                        <b>Periode : <?php echo $periode; ?></b><br> </div>
                   
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td width="120px"><b>Ruangan Asal</b></td><td><b>: <?php echo (isset($ruanganAsal) ? $ruanganAsal : ""); ?></b></td>
                            <td width="120px"><b>No. Mutasi</b></td><td><b>: <?php echo (isset($model->nomutasioa) ? $model->nomutasioa : ""); ?></td>
                        </tr>
                        <tr>
                            <td width="120px"><b>Ruangan Tujuan</b></td><td><b>: <?php echo (isset($model->ruangantujuan->ruangan_nama) ? $model->ruangantujuan->ruangan_nama : ""); ?></td>
                            <td width="120px"><b>Status Terima</b></td><td><b>: <?php echo (!empty($model->terimamutasi_id)) ? "Sudah Diterima" : "Belum Diterima"; ?></td>
                        </tr>
                    </table>
                    <table width="100%" id="tabelstyle">
                        <thead>
                        <th>No.</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Tgl. Kedaluwarsa</th>
                        <th>Asal Barang</th>
                        <th>Jml Pesan</th>
                        <th>Jml Mutasi</th>
                        <th>Satuan</th>
                        <th>HPP</th>
                        <th>Harga Jual</th>
                        <th>Keringanan (%)</th>

                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $tr = null;
                            foreach ($modDetail as $i => $mod) {
                                $tr .= "<tr>";
                                $tr .= "<td>" . ($i + 1) . "</td>";
                                $tr .= "<td>" . $mod->obatalkes->obatalkes_kode . "</td>";
                                $tr .= "<td>" . $mod->obatalkes->obatalkes_nama . "</td>";
                                $tr .= "<td>" . date("d/m/Y H:i:s", strtotime($mod->tglkadaluarsa)) . "</td>";
                                $tr .= "<td>" . $mod->sumberdana->sumberdana_nama . "</td>";
                                $tr .= "<td style='text-align:right;'>" . number_format($mod->jmlpesan, 0, ",", ".") . "</td>";
                                $tr .= "<td style='text-align:right;'>" . number_format($mod->jmlmutasi, 0, ",", ".") . "</td>";
                                $tr .= "<td>" . $mod->satuankecil->satuankecil_nama . "</td>";
                                $tr .= "<td style='text-align:right;'>" . ((Params::cekHiddenHargaGudangFarmasi() == true) ? number_format($mod->harganetto, 0, ",", ".") : "Hidden") . "</td>";
                                $tr .= "<td style='text-align:right;'>" . ((Params::cekHiddenHargaGudangFarmasi() == true) ? number_format($mod->hargajualsatuan, 0, ",", ".") : "Hidden") . "</td>";
                                $tr .= "<td style='text-align:right;'>" . number_format($mod->persendiscount, 0, ",", ".") . "</td>";
                                $tr .= "</tr>";
                            }
                            echo $tr;
                            ?>
                        </tbody>
                    </table>
                    <?php
                    if (isset($_GET['caraPrint']))
                        $this->renderPartial('penerimaanObatAlkes/_tandatangan', array('model' => $model, 'caraPrint' => $caraPrint));
                    ?>
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

    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>

</div>

