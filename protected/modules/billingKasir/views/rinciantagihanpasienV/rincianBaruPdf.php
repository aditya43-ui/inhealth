<?php
if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
}
?>
<style>
    .info {
        font-size: 11px;
        font-family: tahoma;
    }

    .grid {
        border-collapse: collapse;
        font-size: 11px;
        font-family: tahoma;
        border: 1px solid #000;
    }

    .grid td,
    th {
        padding: 5px;
    }
</style>
<?php echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi', array('judulLaporan' => $data['judulLaporan'])); ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="info">
    <tr>
        <td width="20%">No. Rekam Medis/<br>No. Pendaftaran</td>
        <td width="30%"> :
            <?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?> /
            <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
        </td>
        <td width="20%">Nama PJP</td>
        <td>:
            <?php
            if (strlen($modPendaftaran->penanggungjawab_id) > 0) {
                echo CHtml::encode($modPendaftaran->penanggungJawab->nama_pj);
            } else {
                echo CHtml::encode($modPendaftaran->pasien->nama_pasien);
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>: <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?></td>
        <td>Alamat PJP</td>
        <td>: <?php echo CHtml::encode($modPendaftaran->pasien->alamat_pasien); ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:
            <?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>
        </td>
        <td>Umur</td>
        <td>:
            <?php echo CHtml::encode($modPendaftaran->umur); ?>
        </td>
    </tr>
    <tr>
        <td>Unit Pelayanan</td>
        <td>:
            <?php echo CHtml::encode($modPendaftaran->instalasi->instalasi_nama); ?>
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Dokter Pemeriksa</td>
        <td>:
            <?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?>
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Tgl. Perawatan</td>
        <td>: <?php echo CHtml::encode($modRincian[0]->tgl_tindakan); ?></td>
        <td>Perusahaan Penjamin</td>
        <td>: <?php echo CHtml::encode($modRincian[0]->penjamin_nama); ?></td>
    </tr>
</table>
<br>
<div align="center" style="text-align: center;">
    <p style="margin: 0; text-align: center;"><?php echo strtoupper($data['judulPrint']); ?></p>
</div>
<?php
$totalbiayaadminfarmasi = 0;
$row = array();
foreach ($modRincian as $i => $val) {
    $ruangan_id = $val->ruangan_id;
    $row[$ruangan_id]['nama'] = $val->ruangan_nama;
    $row[$ruangan_id]['ruangan_id'] = $val->ruangan_id;
    $row[$ruangan_id]['kategori'][$i]['nama_pegawai'] = $val->nama_pegawai;
    $row[$ruangan_id]['kategori'][$i]['tindakanpelayanan_id'] = $val->tindakanpelayanan_id;
    $row[$ruangan_id]['kategori'][$i]['daftartindakan_id'] = $val->daftartindakan_id;
    $row[$ruangan_id]['kategori'][$i]['daftartindakan_nama'] = $val->daftartindakan_nama;
    $row[$ruangan_id]['kategori'][$i]['kelas'] = $val->kelaspelayanan_nama;
    $row[$ruangan_id]['kategori'][$i]['harga'] = $val->tarif_satuan;
    //            $row[$ruangan_id]['kategori'][$i]['harga'] = (isset($val->tarif_medis) ? ($val->tarif_satuan - $val->tarif_medis) : $val->tarif_satuan);
    $row[$ruangan_id]['kategori'][$i]['qty'] = $val->qty_tindakan;
    //            $row[$ruangan_id]['kategori'][$i]['total'] = ($row[$ruangan_id]['kategori'][$i]['harga'] * $row[$ruangan_id]['kategori'][$i]['qty']);
    $row[$ruangan_id]['kategori'][$i]['total'] = ($row[$ruangan_id]['kategori'][$i]['harga'] * $row[$ruangan_id]['kategori'][$i]['qty']);
    $harga = TindakanpelayananT::model()->findAllByPk($val->tindakanpelayanan_id);
    $row[$ruangan_id]['kategori'][$i]['harga_dokter'] = (isset($val->tarif_medis) ? $val->tarif_medis : 0);
    $row[$ruangan_id]['kategori'][$i]['total_dokter'] = (isset($val->tarif_medis) ? ($val->qty_tindakan * $val->tarif_medis) : 0);
    $row[$ruangan_id]['kategori'][$i]['subsidiasuransi_tindakan'] = (isset($val->subsidiasuransi_tindakan) ? ($val->subsidiasuransi_tindakan) : 0);
    $row[$ruangan_id]['kategori'][$i]['subsidipemerintah_tindakan'] = (isset($val->subsidipemerintah_tindakan) ? ($val->subsidipemerintah_tindakan) : 0);
    $row[$ruangan_id]['kategori'][$i]['subsisidirumahsakit_tindakan'] = (isset($val->subsisidirumahsakit_tindakan) ? ($val->subsisidirumahsakit_tindakan) : 0);
    $row[$ruangan_id]['kategori'][$i]['iurbiaya_tindakan'] = (isset($val->iurbiaya_tindakan) ? ($val->iurbiaya_tindakan) : 0);
    //Total biaya racik dll
    $totalbiayaadminfarmasi += ($val->biayaadministrasi + $val->biayaservice + $val->biayakonseling);
}
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="grid">
    <thead>
        <tr>
            <th width="3%">&nbsp;</th>
            <th>&nbsp;</th>
            <th width="15%">Kelas</th>
            <th width="15%">Harga (Rp)</th>
            <th width="15%">Banyak</th>
            <th width="15%">Total (Rp)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $cols = '';
        $total_biaya = 0;
        foreach ($row as $values) {
            $cols .= '<tr>';
            $cols .= '<td colspan=6><b>' . strtoupper($values['nama']) . '</b></td>';
            $cols .= '</tr>';
            $col = '';
            $total = 0;
            $tampilAdminFarmasi = true;
            $tempAdminFarmasi = 0;
            foreach ($values['kategori'] as $val) {
                if ($values['instalasi_id'] == Params::INSTALASI_ID_FARMASI || $values['instalasi_id'] == Params::INSTALASI_ID_LAB) {
                    if ($values['instalasi_id'] != Params::INSTALASI_ID_LAB) {
                        if ($totalbiayaadminfarmasi > 0 && $tampilAdminFarmasi == true) {
                            $col .= '<tr>';
                            $col .= '<td></td>';
                            $col .= '<td>Biaya Racik, dll</td>';
                            $col .= '<td>' . $val['kelas'] . '</td>';
                            $col .= '<td style="text-align:right;">' . number_format($totalbiayaadminfarmasi) . '</td>';
                            $col .= '<td style="text-align:right;">1</td>';
                            $col .= '<td style="text-align:right;">' . number_format($totalbiayaadminfarmasi) . '</td>';
                            $col .= '</tr>';
                            $tampilAdminFarmasi = false;
                            $tempAdminFarmasi = $totalbiayaadminfarmasi;
                        }
                    }
                } else {
                    $tempAdminFarmasi = 0;
                }
                $col .= '<tr>';
                $col .= '<td>&nbsp;</td>';
                $col .= '<td>' . $val['daftartindakan_nama'] . '</td>';
                $col .= '<td>' . $val['kelas'] . '</td>';
                $col .= '<td align="right" class="uang">' . number_format($val['harga'], 0, '', '.') . '</td>';
                $col .= '<td align="right" class="uang">' . $val['qty'] . '</td>';
                $col .= '<td align="right" class="uang">' . number_format($val['total'], 0, '', '.') . '</td>';
                $col .= '</tr>';
                if ($values['instalasi_id'] == Params::INSTALASI_ID_FARMASI || $values['instalasi_id'] == Params::INSTALASI_ID_LAB) {
                } else {
                    if (strlen($val['nama_pegawai']) > 0) {
                        //                           //menampilkan harga dokter
                        //                                    $col .= '<tr>';
                        //                                    $col .= '<td>&nbsp;</td>';
                        //                                    $col .= '<td>'. $val['nama_pegawai'] .'</td>';
                        //                                    $col .= '<td>'. $val['kelas'] .'</td>';
                        //                                    $col .= '<td style="text-align:right;">'. number_format($val['harga_dokter']) .'</td>';
                        //                                    $col .= '<td>'. $val['qty'] .'</td>';
                        //                                    $col .= '<td style="text-align:right;">'. number_format($val['total_dokter']) .'</td>';
                        //                                    $col .= '</tr>';
                        if (strtoupper($values['nama']) != 'PENDAFTARAN') {
                            $col .= '<tr>';
                            $col .= '<td>&nbsp;</td>';
                            $col .= '<td>' . $val['nama_pegawai'] . '</td>';
                            $col .= '<td></td>';
                            $col .= '<td></td>';
                            $col .= '<td></td>';
                            $col .= '<td></td>';
                            $col .= '</tr>';
                        }
                    }
                }
                $total += $val['total'];
                $subsidiAsuransi += $val['subsidiasuransi_tindakan'];
                $subsidiPemerintah += $val['subsidipemerintah_tindakan'];
                $subsidiRumahSakit += $val['subsisidirumahsakit_tindakan'];
                $iurBiaya += $val['iurbiaya_tindakan'];
                //                    $total += $val['total'] + $val['total_dokter'];
            }
            $total = $total + $tempAdminFarmasi;
            $col .= '<tr>';
            $col .= '<td colspan=5 class="total">Total Biaya :</td>';
            $col .= '<td class="total" align="right">' . number_format($total, 0, '', '.') . '</td>';
            $col .= '</tr>';
            $cols .= $col;
            $total_biaya += $total;
        }
        echo ($cols);
        //HARUS DARI DATABASE >> $iurBiaya = $total_biaya - ($subsidiAsuransi + $subsidiPemerintah + $subsidiRumahSakit);  //karena $iurBiaya yang diambil di tindakanpelayanan_t sering tidak sama dengan total biaya - subsidi 
        ?>
    </tbody>
</table>
<br>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="info">
    <tr>
        <td width="50%" align="center" valign="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="50%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama") . ", " . Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></div>
                        <div>Petugas</div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div>
                            <?php echo $data['nama_pegawai']; ?>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
        <td align="center" valign="top">
            <table width="100%" style="text-align: right;">
                <tr>
                    <td><b>Total Biaya</b></td>
                    <td width="3%">:</td>
                    <td class="totalSeluruh"><?php echo number_format($total_biaya, 0, '', '.'); ?></td>
                </tr>
                <tr>
                    <td><b>Tanggungan Asuransi</b></td>
                    <td width="3%">:</td>
                    <td class="totalSeluruh"><?php echo number_format($subsidiAsuransi, 0, '', '.'); ?></td>
                </tr>
                <!--<tr>
                    <td><b>Tanggungan Pemerintah</b></td>
                    <td width="3%">:</td>
                    <td class="totalSeluruh"><?php //echo number_format($subsidiPemerintah,0,'','.'); 
                                                ?></td>
                </tr>-->
                <tr>
                    <td><b>Tanggungan Rumah Sakit</b></td>
                    <td width="3%">:</td>
                    <td class="totalSeluruh"><?php echo number_format($subsidiRumahSakit, 0, '', '.'); ?></td>
                </tr>
                <tr>
                    <td><b>Iur Biaya</b></td>
                    <td width="3%">:</td>
                    <td class="totalSeluruh"><?php echo number_format($iurBiaya, 0, '', '.'); ?></td>
                </tr>
                <tr>
                    <td><b>Deposit</b></td>
                    <td>:</td>
                    <td class="totalSeluruh"><?php echo number_format($data['uang_cicilan'], 0, '', '.'); ?></td>
                </tr>
                <tr>
                    <td><b>Pembulatan</b></td>
                    <td>:</td>
                    <td class="totalSeluruh">
                        <?php
                        $kembalian = ($total_biaya - $subsidiAsuransi - $subsidiPemerintah - $subsidiRumahSakit);
                        if ($data['uang_cicilan'] > 0) {
                            if ($data['uang_cicilan'] < $total_biaya) {
                                $kembalian = $kembalian - $data['uang_cicilan'];
                            }
                        }
                        $sisaTagihan = $pembulatan->totalsisatagihan;
                        $pembulatan = $sisaTagihan - $kembalian;
                        echo number_format($pembulatan, 0, '', '.')
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Tanggungan Pasien</b></td>
                    <td>:</td>
                    <td class="totalSeluruh"><?php echo number_format($sisaTagihan, 0, '', '.'); ?></td>
                </tr>
            </table>
            <div id="cetakan_jum" style="margin-top: 40px;font-size: 11px"></div>
        </td>
    </tr>
</table>
<script type="text/javascript">
    function insertCetakan() {
        var params = {
            pendaftaran_id: '<?= $modPendaftaran->pendaftaran_id ?>'
        };
        $.post("<?php echo Yii::app()->createUrl('ActionAjax/updateJumlahCetakan'); ?>", {
                id: params
            },
            function(data) {
                if (data.status == 'not') {
                    console.log('insert cetakan data error');
                } else {
                    $('#cetakan_jum').text('Cetakan Ke ' + data.jumlah);
                }
            }, "json"
        );
    }
    insertCetakan();
</script>