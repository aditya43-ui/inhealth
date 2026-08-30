<?php
if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $data['judulLaporan'] . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $data['judulLaporan']));
}
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:11px;
    }
');
?>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <td width="50%">
                    <label class='control-label'>
                        No. RM / No. Pend :
                    </label>
                    <?php echo CHtml::encode($modPasien->no_rekam_medik); ?> /
                    <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
                </td>
                <Td width="5%"></td>
                <td>
                    <label class='control-label'>
                        Nama PJP :
                    </label>
                    <?php
                    if (strlen($modPendaftaran->penanggungjawab_id) > 0) {
                        echo CHtml::encode($modPendaftaran->penanggungJawab->nama_pj);
                    } else {
                        echo CHtml::encode($modPasien->nama_pasien);
                    }
                    ?>
                </td>
    </tr>
    <tr>
    <tr>
        <td>
            <label class='control-label'>
                Nama Pasien :
            </label>
            <?php echo CHtml::encode($modPasien->nama_pasien); ?>
        </td>
        <Td></td>
        <td>
            <label class='control-label'>
                Alamat PJP :
            </label>
            <?php
            if (strlen($modPendaftaran->penanggungjawab_id) > 0) {
                echo CHtml::encode($modPendaftaran->penanggungJawab->alamat_pj);
            } else {
                echo CHtml::encode($modPasien->alamat_pasien);
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>
                Jenis Kelamin :
            </label>
            <?php echo CHtml::encode($modPasien->jeniskelamin); ?>
        </td>
        <Td></td>
        <td>
            <label class='control-label'>
                Alamat Pasien :
            </label>
            <?php echo CHtml::encode($modPasien->alamat_pasien); ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>
                Umur :
            </label>
            <?php echo CHtml::encode(substr($modPendaftaran->umur, 0, 7)); ?>
        </td>
        <Td></td>
        <td>
            <label class='control-label'>
                Jenis Penjamin - Penjamin :
            </label>
            <?php
            if (strlen($modPendaftaran->carabayar_id)  && strlen($modPendaftaran->penjamin_id) > 0) {
                echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama) . " - " . CHtml::encode($modPendaftaran->penjamin->penjamin_nama);
            } else {
                echo '-' . "/" . "-";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>Unit Pelayanan :</label>
            <?php echo CHtml::encode($modPendaftaran->instalasi->instalasi_nama); ?>
        </td>
        <Td></td>
        <td>
            <label class='control-label'>
                Nama Rujukan :
            </label>
            <?php
            if (!empty($modPendaftaran->rujukan_id)) {
                if (strlen($modPendaftaran->rujukan->nama_perujuk) > 0) {
                    echo CHtml::encode($modPendaftaran->rujukan->nama_perujuk);
                } else {
                    echo '-';
                }
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>Dokter Pemeriksa :</label>
            <?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?>
        </td>
        <Td></td>
        <td>
            <label class='control-label'>
                Rujukan Dari :
            </label>
            <?php
            if (!empty($modPendaftaran->rujukan_id) > 0) {
                echo CHtml::encode($modPendaftaran->rujukan->asalrujukan->asalrujukan_nama);
            } else {
                echo '-';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>Tanggal Perawatan / Tanggal Pemeriksaan :</label>
            <?php
            if (strlen($modPendaftaran->tgl_pendaftaran) > 0) {
                echo CHtml::encode($modPendaftaran->tgl_pendaftaran);
            } else {
                echo '-';
            }
            ?>
        </td>
        <Td></td>
        <td>
            <label class='control-label'>
                No. Rujukan :
            </label>
            <?php
            if (!empty($modPendaftaran->rujukan_id) > 0) {
                echo CHtml::encode($modPendaftaran->rujukan->no_rujukan);
            } else {
                echo '-';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>Tanggal Tindakan :</label>
            <?php
            if (isset($modRincianTagihan->pendaftaran_id)) {
                echo CHtml::encode($modRincianTagihan->tgl_tindakan);
            } else {
                echo '-';
            }
            ?>
        </td>
        <Td></td>
        <td></td>
    </tr>
</table>
</td>
</tr>
<tr>
    <td>
        <div align="center" style="border-bottom: 1px solid #000000;padding: 10px;margin-bottom: 15px;">
            <?php echo strtoupper($data['judulLaporan']); ?>
        </div>
        <?php
        $row = array();
        $id_tindakan = "";
        foreach ($modRincian as $i => $val) {
            $ruangan_id = $val->ruangan_id;
            $row[$ruangan_id]['nama'] = $val->ruangan_nama;
            $row[$ruangan_id]['ruangan_id'] = $val->ruangan_id;
            $row[$ruangan_id]['kategori'][$i]['nama_pegawai'] = null;
            $row[$ruangan_id]['kategori'][$i]['tindakanpelayanan_id'] = $val->tindakanpelayanan_id;
            $row[$ruangan_id]['kategori'][$i]['daftartindakan_nama'] = (empty($val->daftartindakan_nama) ? $val->pemeriksaanlab_nama : $val->daftartindakan_nama);
            $row[$ruangan_id]['kategori'][$i]['kelas'] = $val->kelaspelayanan_nama;
            $row[$ruangan_id]['kategori'][$i]['harga'] =  $val->tarif_satuan;
            $row[$ruangan_id]['kategori'][$i]['qty'] = $val->qty_tindakan;
            $row[$ruangan_id]['kategori'][$i]['total'] = ($row[$ruangan_id]['kategori'][$i]['harga'] * $row[$ruangan_id]['kategori'][$i]['qty']);
            // if($val->daftartindakan_id==5527 && ($val->daftartindakan_nama=='LDL-Cholesterol' || $val->daftartindakan_nama=='Cholesterol Total' || $val->daftartindakan_nama=='Triglyseride'))
            // {
            //     $row[$ruangan_id]['kategori'][$i]['harga'] = 0;
            //     $row[$ruangan_id]['kategori'][$i]['total'] = 0;
            // }
            // $harga = TindakanpelayananT::model()->findAllByPk($val->tindakanpelayanan_id);
            $row[$ruangan_id]['kategori'][$i]['harga_dokter'] = (isset($val->tarif_medis) ? $val->tarif_medis : 0);
            $row[$ruangan_id]['kategori'][$i]['total_dokter'] = (isset($val->tarif_medis) ? ($val->qty_tindakan * $val->tarif_medis) : 0);
            $row[$ruangan_id]['kategori'][$i]['subsidiasuransi_tindakan'] = (isset($val->subsidiasuransi_tindakan) ? ($val->subsidiasuransi_tindakan) : 0);
            $row[$ruangan_id]['kategori'][$i]['subsidipemerintah_tindakan'] = (isset($val->subsidipemerintah_tindakan) ? ($val->subsidipemerintah_tindakan) : 0);
            $row[$ruangan_id]['kategori'][$i]['subsisidirumahsakit_tindakan'] = (isset($val->subsisidirumahsakit_tindakan) ? ($val->subsisidirumahsakit_tindakan) : 0);
            $row[$ruangan_id]['kategori'][$i]['iurbiaya_tindakan'] = (isset($val->iurbiaya_tindakan) ? ($val->iurbiaya_tindakan) : 0);
        }
        ?>
        <table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
            <thead>
                <tr>
                    <th>Ruangan / Unit</th>
                    <th>Uraian</th>
                    <th>Harga (Rp)</th>
                    <th>Jumlah</th>
                    <th>Total (Rp)</th>
                </tr>
            </thead>
            <?php
            $cols = '';
            $total_biaya = 0;
            $subsidiAsuransi = 0;
            $subsidiPemerintah = 0;
            $subsidiRumahSakit = 0;
            $iurBiaya = 0;
            foreach ($row as $values) {
                $cols .= '<tr>';
                $cols .= '<td colspan=6>' . $values['nama'] . '</td>';
                $cols .= '</tr>';
                $col = '';
                $total = 0;
                foreach ($values['kategori'] as $val) {
                    $col .= '<tr>';
                    $col .= '<td>&nbsp;</td>';
                    $col .= '<td>' . $val['daftartindakan_nama'] . '</td>';
                    $col .= '<td style="text-align:right;">' . number_format($val['harga'], 0, "", ".") . '</td>';
                    $col .= '<td>' . $val['qty'] . '</td>';
                    $col .= '<td style="text-align:right;">' . number_format($val['total'], 0, "", ".") . '</td>';
                    $col .= '</tr>';
                    if (strlen($val['nama_pegawai']) > 0) {
                        $col .= '<tr>';
                        $col .= '<td>&nbsp;</td>';
                        $col .= '<td>' . $val['nama_pegawai'] . '</td>';
                        $col .= '<td style="text-align:right;">' . number_format($val['harga_dokter'], 0, "", ".") . '</td>';
                        $col .= '<td>' . $val['qty'] . '</td>';
                        $col .= '<td style="text-align:right;">' . number_format($val['total_dokter'], 0, "", ".") . '</td>';
                        $col .= '</tr>';
                    }
                    $total += $val['total'];
                    $subsidiAsuransi += $val['subsidiasuransi_tindakan'];
                    $subsidiPemerintah += $val['subsidipemerintah_tindakan'];
                    $subsidiRumahSakit += $val['subsisidirumahsakit_tindakan'];
                    $iurBiaya += $val['iurbiaya_tindakan'];
                }
                $col .= '<tr">';
                $col .= '<td colspan=4><b>Total Biaya</b></td>';
                $col .= '<td style="text-align:right;">' . number_format($total, 0, "", ".") . '</td>';
                $col .= '</tr>';
                $cols .= $col;
                $total_biaya += $total;
            }
            echo ($cols);
            $total = round($total_biaya);
            //HARUS DARI DATABASE >> $iurBiaya = $total - ($subsidiAsuransi + $subsidiPemerintah + $subsidiRumahSakit);  //karena $iurBiaya yang diambil di tindakanpelayanan_t sering tidak sama dengan total biaya - subsidi 
            ?>
            <tfoot>
                <tr>
                    <td colspan="4">
                        <div class='pull-right'>Total Biaya</div>
                    </td>
                    <td style="text-align:right;"><?php echo number_format($total, 0, "", "."); ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class='pull-right'>Tanggungan Asuransi</div>
                    </td>
                    <td style="text-align:right;"><?php echo number_format($subsidiAsuransi, 0, "", "."); ?></td>
                </tr>
                <!--<tr>
                        <td colspan="4"><div class='pull-right'>Tanggungan Pemerintah</div></td>
                        <td style="text-align:right;"><?php echo number_format($subsidiPemerintah, 0, "", "."); ?></td>
                    </tr>-->
                <tr>
                    <td colspan="4">
                        <div class='pull-right'>Tanggungan Rumah Sakit</div>
                    </td>
                    <td style="text-align:right;"><?php echo number_format($subsidiRumahSakit, 0, "", "."); ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class='pull-right'>Iur Biaya</div>
                    </td>
                    <td style="text-align:right;"><?php echo number_format($iurBiaya, 0, "", "."); ?></td>
                </tr>
            </tfoot>
        </table>
    </td>
</tr>
</table>