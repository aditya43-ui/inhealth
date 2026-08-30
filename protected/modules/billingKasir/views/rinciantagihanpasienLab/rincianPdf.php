<style>
    .info {
        vertical-align: top;
        font-size: 11px;
        font-family: tahoma;
    }

    .grid {
        border-bottom: 0.5px solid;
        border-collapse: collapse;
        font-size: 11px;
        font-family: tahoma;
    }

    .grid td,
    th {
        padding: 5px;
    }
</style>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="info">
    <tr>
        <td width="20%">No. RM / Reg</td>
        <td width="33%"> :
            <?php echo CHtml::encode($modRincianTagihan->no_rekam_medik); ?> /
            <?php echo CHtml::encode($modRincianTagihan->no_pendaftaran); ?>
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
        <td>: <?php echo CHtml::encode($modRincianTagihan->nama_pasien); ?></td>
        <td>Alamat PJP</td>
        <td rowspan="2">: <?php echo CHtml::encode($modRincianTagihan->alamat_pasien); ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:
            <?php echo CHtml::encode($modRincianTagihan->jeniskelamin); ?> /
            <?php echo CHtml::encode($modRincianTagihan->umur); ?>
        </td>
    </tr>
    <tr>
        <td>Unit Pelayanan</td>
        <td>:
            <?php echo CHtml::encode($modRincianTagihan->instalasi_nama); ?>
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Dokter Pemeriksa</td>
        <td>:
            <?php echo CHtml::encode($modRincianTagihan->nama_pegawai); ?>
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Tanggal Perawatan</td>
        <td>: -</td>
        <td>Perusahaan Penjamin</td>
        <td>: -</td>
    </tr>
</table>
<br>
<div align="center" style="text-align: center;">
    <p style="margin: 0; text-align: center;"><b><?php echo strtoupper($data['judulPrint']); ?></b></p>
</div>
<?php
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
    $row[$ruangan_id]['kategori'][$i]['harga'] = (isset($val->tarif_medis) ? ($val->tarif_satuan - $val->tarif_medis) : $val->tarif_satuan);
    $row[$ruangan_id]['kategori'][$i]['qty'] = $val->qty_tindakan;
    $row[$ruangan_id]['kategori'][$i]['total'] = ($row[$ruangan_id]['kategori'][$i]['harga'] * $row[$ruangan_id]['kategori'][$i]['qty']);
    $harga = TindakanpelayananT::model()->findAllByPk($val->tindakanpelayanan_id);
    $row[$ruangan_id]['kategori'][$i]['harga_dokter'] = (isset($val->tarif_medis) ? $val->tarif_medis : 0);
    $row[$ruangan_id]['kategori'][$i]['total_dokter'] = (isset($val->tarif_medis) ? ($val->qty_tindakan * $val->tarif_medis) : 0);
    $row[$ruangan_id]['kategori'][$i]['subsidiasuransi_tindakan'] = (isset($val->subsidiasuransi_tindakan) ? ($val->subsidiasuransi_tindakan) : 0);
    $row[$ruangan_id]['kategori'][$i]['subsidipemerintah_tindakan'] = (isset($val->subsidipemerintah_tindakan) ? ($val->subsidipemerintah_tindakan) : 0);
    $row[$ruangan_id]['kategori'][$i]['subsisidirumahsakit_tindakan'] = (isset($val->subsisidirumahsakit_tindakan) ? ($val->subsisidirumahsakit_tindakan) : 0);
    $row[$ruangan_id]['kategori'][$i]['iurbiaya_tindakan'] = (isset($val->iurbiaya_tindakan) ? ($val->iurbiaya_tindakan) : 0);
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
            $cols .= '<td colspan=3><b>' . strtoupper($values['nama']) . '</b></td>';
            $cols .= '</tr>';
            $col = '';
            $total = 0;
            foreach ($values['kategori'] as $val) {
                //menentukan harga obat
                if ($values['instalasi_id'] == Params::INSTALASI_ID_FARMASI) {
                    $modObat = ObatalkesM::model()->findByAttributes(array('obatalkes_id' => $val['daftartindakan_id']));
                    $val['harga'] = $modObat->hjaresep;
                    $val['total'] = $val['qty'] * $val['harga'];
                }
                $col .= '<tr>';
                $col .= '<td>&nbsp;</td>';
                $col .= '<td colspan=2>' . $val['daftartindakan_nama'] . '</td>';
                $col .= '<td align="right" class="uang">' . number_format($val['harga'] + $val['total_dokter'], 0, '', '.') . '</td>';
                $col .= '<td align="right" class="uang">' . $val['qty'] . '</td>';
                $col .= '<td align="right" class="uang">' . number_format($val['total'] + $val['total_dokter'], 0, '', '.') . '</td>';
                $col .= '</tr>';
                $total += $val['total'] + $val['total_dokter'];
                $subsidiAsuransi += $val['subsidiasuransi_tindakan'];
                $subsidiPemerintah += $val['subsidipemerintah_tindakan'];
                $subsidiRumahSakit += $val['subsisidirumahsakit_tindakan'];
                $iurBiaya += $val['iurbiaya_tindakan'];
            }
            $col .= '<tr>';
            $col .= '<td colspan=2 class="total">Total Biaya :</td>';
            $col .= '<td colspan=4 class="total" align="right">' . number_format($total, 0, '', '.') . '</td>';
            $col .= '</tr>';
            $cols .= $col;
            $total_biaya += $total;
        }
        echo ($cols);
        //HARUS DARI DATABASE >> $iurBiaya = $total - ($subsidiAsuransi + $subsidiPemerintah + $subsidiRumahSakit);  //karena $iurBiaya yang diambil di tindakanpelayanan_t sering tidak sama dengan total biaya - subsidi 
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
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama"); ?>, <?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></div>
                        <div>Petugas RS</div>
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
                <!--
                <tr>
                    <td><b>Tanggungan Pemerintah</b></td>
                    <td width="3%">:</td>
                    <td class="totalSeluruh"><?php echo number_format($subsidiPemerintah, 0, '', '.'); ?></td>
                </tr>
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
-->
                <tr>
                    <td><b>Deposit</b></td>
                    <td>:</td>
                    <td class="totalSeluruh"><?php echo number_format($data['uang_cicilan'], 0, '', '.'); ?></td>
                </tr>
                <tr>
                    <td><b>Tanggungan Pasien</b></td>
                    <td>:</td>
                    <td class="totalSeluruh">
                        <?php
                        $kembalian = ($total_biaya - $subsidiAsuransi - $subsidiPemerintah - $subsidiRumahSakit);
                        if ($data['uang_cicilan'] > 0) {
                            if ($data['uang_cicilan'] < $total_biaya) {
                                $kembalian = $kembalian - $data['uang_cicilan'];
                            }
                        }
                        echo number_format($kembalian, 0, '', '.');
                        ?>
                    </td>
                </tr>
            </table>
            <div id="cetakan_jum" style="margin-top: 40px;font-size: 11px"></div>
        </td>
    </tr>
    <tr>
        <td colspan="2"><i><b>Catatan :</b><br> Bukti pembayaran ini harus dibawa pada saat pengambilan hasil</i></td>
    </tr>
</table>
<script type="text/javascript">
    function insertCetakan() {
        var params = {
            pendaftaran_id: '<?= $modRincian[0]->pendaftaran_id ?>'
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