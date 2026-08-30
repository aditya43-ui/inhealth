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
                    <?php echo CHtml::encode(isset($modPendaftaran->pasien->no_rekam_medik) ? $modPendaftaran->pasien->no_rekam_medik : null); ?> /
                    <?php echo CHtml::encode(isset($modPendaftaran->no_pendaftaran) ? $modPendaftaran->no_pendaftaran : null); ?>
                </td>
                <Td width="5%"></td>
                <td>
                    <label class='control-label'>
                        Nama PJP :
                    </label>
                    <?php
                    if (strlen(isset($modPendaftaran->penanggungjawab_id) ? $modPendaftaran->penanggungjawab_id : null) > 0) {
                        echo CHtml::encode(
                            isset($modPendaftaran->penanggungJawab->nama_pj) ?
                                $modPendaftaran->penanggungJawab->nama_pj : null
                        );
                    } else {
                        echo CHtml::encode(isset($modPendaftaran->pasien->nama_pasien) ? $modPendaftaran->pasien->nama_pasien : null);
                    }
                    ?>
                </td>
    </tr>
    <tr>
    <tr>
        <td>
            <label class='control-label'>
                <?php
                echo CHtml::encode(isset($modPendaftaran->pasien->nama_pasien) ? $modPendaftaran->pasien->nama_pasien : null);
                // echo CHtml::encode(isset($modPendaftaran->pasien->getAttributeLabel('nama_pasien')) ? $modPendaftaran->pasien->getAttributeLabel('nama_pasien') : null ); 
                ?>
            </label>
            <?php echo CHtml::encode(isset($modPendaftaran->pasien->nama_pasien) ? $modPendaftaran->pasien->nama_pasien : null); ?>
        </td>
        <Td></td>
        <td>
            <label class='control-label'>
                Alamat PJP :
            </label>
            <?php
            if (strlen(isset($modPendaftaran->penanggungjawab_id) ? $modPendaftaran->penanggungjawab_id : null) > 0) {
                echo CHtml::encode(
                    isset($modPendaftaran->penanggungJawab->nama_pj) ?
                        $modPendaftaran->penanggungJawab->nama_pj : null
                );
            } else {
                echo CHtml::encode(isset($modPendaftaran->pasien->alamat_pasien) ? $modPendaftaran->pasien->alamat_pasien : null);
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>
                Jenis Kelamin :
            </label>
            <?php echo CHtml::encode(isset($modPendaftaran->pasien->jeniskelamin) ? $modPendaftaran->pasien->jeniskelamin : null); ?>
        </td>
        <Td></td>
        <td>
            <label class='control-label'>
                Alamat Pasien :
            </label>
            <?php echo CHtml::encode(isset($modPendaftaran->pasien->alamat_pasien) ? $modPendaftaran->pasien->alamat_pasien : null); ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>
                No. Telpon Pasien :
            </label>
            <?php echo CHtml::encode(isset($modPendaftaran->pasien->no_telepon_pasien) ? $modPendaftaran->pasien->no_telepon_pasien : null); ?>
        </td>
        <Td></td>
        <td>
            <label class='control-label'>
                Jenis Penjamin - Penjamin :
            </label>
            <?php
            if (strlen(isset($modPendaftaran->carabayar_id) ? $modPendaftaran->carabayar_id : null)  && strlen($modPendaftaran->penjamin_id) > 0) {
                echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama) . " - " . CHtml::encode($modPendaftaran->penjamin->penjamin_nama);
            } else {
                echo '-' . "/" . "-";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>Umur :</label>
            <?php echo CHtml::encode(isset($modPendaftaran->umur) ? $modPendaftaran->umur : '-'); ?>
        </td>
        <Td></td>
        <td>
            <label class='control-label'>
                Nama Rujukan :
            </label>
            <?php
            if (strlen(isset($modPendaftaran->rujukan->nama_perujuk) ? $modPendaftaran->rujukan->nama_perujuk : null) > 0) {
                echo CHtml::encode($modPendaftaran->rujukan->nama_perujuk);
            } else {
                echo '-';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>Unit Pelayanan :</label>
            <?php echo CHtml::encode(isset($modPendaftaran->instalasi->instalasi_nama) ? $modPendaftaran->instalasi->instalasi_nama : '-'); ?>
        </td>
        <Td></td>
        <td>
            <label class='control-label'>
                Rujukan Dari :
            </label>
            <?php
            if (strlen(isset($modPendaftaran->rujukan_id) ? $modPendaftaran->rujukan_id : null) > 0) {
                echo CHtml::encode($modPendaftaran->rujukan->asalrujukan->asalrujukan_nama);
            } else {
                echo '-';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>Dokter Pemeriksa :</label>
            <?php echo CHtml::encode(isset($modPendaftaran->pegawai->nama_pegawai) ? $modPendaftaran->pegawai->nama_pegawai : '-'); ?>
        </td>
        <Td></td>
        <td>
            <label class='control-label'>
                No. Rujukan :
            </label>
            <?php
            if (strlen(isset($modPendaftaran->rujukan_id) ? $modPendaftaran->rujukan_id : null) > 0) {
                echo CHtml::encode($modPendaftaran->rujukan->no_rujukan);
            } else {
                echo '-';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>Tgl. Perawatan / Tgl. Pemeriksaan :</label>
            <?php
            if (strlen(isset($modPendaftaran->tgl_pendaftaran) ? $modPendaftaran->tgl_pendaftaran : null) > 0) {
                echo CHtml::encode($modPendaftaran->tgl_pendaftaran);
            } else {
                echo '-';
            }
            ?>
        </td>
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
        $totalbiayaadminfarmasi = 0;
        $row = array();
        foreach ($modRincian as $i => $val) {
            $ruangan_id = $val->ruangan_id;
            $row[$ruangan_id]['nama'] = $val->ruangan_nama;
            $row[$ruangan_id]['instalasi_id'] = $val->instalasi_id;
            $row[$ruangan_id]['ruangan_id'] = $val->ruangan_id;
            $row[$ruangan_id]['pendaftaran_id'] = $val->pendaftaran_id;
            $row[$ruangan_id]['kategori'][$i]['nama_pegawai'] = $val->nama_pegawai;
            $row[$ruangan_id]['kategori'][$i]['tindakanpelayanan_id'] = $val->tindakanpelayanan_id;
            $row[$ruangan_id]['kategori'][$i]['daftartindakan_nama'] = $val->daftartindakan_nama;
            $row[$ruangan_id]['kategori'][$i]['kelas'] = $val->kelaspelayanan_nama;
            $row[$ruangan_id]['kategori'][$i]['harga'] = $val->tarif_satuan;
            //                    $row[$ruangan_id]['kategori'][$i]['harga'] = (isset($val->tarif_medis) ? ($val->tarif_satuan - $val->tarif_medis) : $val->tarif_satuan);
            $row[$ruangan_id]['kategori'][$i]['qty'] = $val->qty_tindakan;
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
        <table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
            <thead>
                <tr>
                    <th>Ruangan / Unit</th>
                    <th>Uraian</th>
                    <th>Kelas</th>
                    <th>Harga (Rp)</th>
                    <th>Banyak</th>
                    <th>Total (Rp)</th>
                </tr>
            </thead>
            <?php
            $cols = '';
            $total_biaya = 0;
            $tampilAdminFarmasi = true;
            $tempAdminFarmasi = 0;
            $subsidiAsuransi = 0;
            $subsidiPemerintah = 0;
            $subsidiRumahSakit = 0;
            $iurBiaya = 0;
            foreach ($row as $key => $values) {
                $modRuangan = RuanganM::model()->findByPK($key);
                if ($modRuangan->instalasi_id == 4) {
                    $modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array(
                        'pendaftaran_id' => $values['pendaftaran_id'],
                    ));
                    $modKamarRuangan = KamarruanganM::model()->findByPk($modPasienAdmisi->kamarruangan_id);
                    $cols .= '<tr>';
                    $cols .= '<td colspan=6><b>' . strtoupper($values['nama']) . ' Kamar ' . $modKamarRuangan->kamarruangan_nokamar . ' Bed ' . $modKamarRuangan->kamarruangan_nobed . '</b></td>';
                    $cols .= '</tr>';
                } else {
                    $cols .= '<tr>';
                    $cols .= '<td colspan=6><b>' . strtoupper($values['nama']) . '</b></td>';
                    $cols .= '</tr>';
                }
                $col = '';
                $total = 0;
                foreach ($values['kategori'] as $val) {
                    if ($values['instalasi_id'] == Params::INSTALASI_ID_FARMASI || $values['instalasi_id'] == Params::INSTALASI_ID_LAB) {
                        if ($values['instalasi_id'] != Params::INSTALASI_ID_LAB) {
                            if ($totalbiayaadminfarmasi > 0 && $tampilAdminFarmasi == true) {
                                $col .= '<tr>';
                                $col .= '<td></td>';
                                $col .= '<td>Biaya Racik, dll</td>';
                                $col .= '<td>' . $val['kelas'] . '</td>';
                                $col .= '<td style="text-align:right;">' . number_format($totalbiayaadminfarmasi, 0, "", ".") . '</td>';
                                $col .= '<td>1</td>';
                                $col .= '<td style="text-align:right;">' . number_format($totalbiayaadminfarmasi, 0, "", ".") . '</td>';
                                $col .= '</tr>';
                                $tampilAdminFarmasi = false;
                            }
                        }
                    } else {
                        $tempAdminFarmasi = 0;
                    }
                    $col .= '<tr>';
                    $col .= '<td>&nbsp;</td>';
                    $col .= '<td>' . $val['daftartindakan_nama'] . '</td>';
                    $col .= '<td>' . $val['kelas'] . '</td>';
                    $col .= '<td style="text-align:right;">' . number_format($val['harga'], 0, "", ".") . '</td>'; //merge tarif dokter
                    //$col .= '<td style="text-align:right;">'. number_format($val['harga'] + $val['harga_dokter']) .'</td>'; //merge tarif dokter
                    $col .= '<td>' . $val['qty'] . '</td>';
                    $col .= '<td style="text-align:right;">' . number_format($val['total'], 0, "", ".") . '</td>';
                    //$col .= '<td style="text-align:right;">'. number_format($val['total'] + $val['total_dokter']) .'</td>';
                    $col .= '</tr>';
                    if ($values['instalasi_id'] != Params::INSTALASI_ID_FARMASI && $values['instalasi_id'] != Params::INSTALASI_ID_LAB) {
                        if (strlen($val['nama_pegawai']) > 0) {
                            //menampilkan harga dokter
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
                    //                            $total += $val['total'] + $val['total_dokter'];
                    $subsidiAsuransi += $val['subsidiasuransi_tindakan'];
                    $subsidiPemerintah += $val['subsidipemerintah_tindakan'];
                    $subsidiRumahSakit += $val['subsisidirumahsakit_tindakan'];
                    $iurBiaya += $val['iurbiaya_tindakan'];
                }
                $total = $total;
                $col .= '<tr">';
                $col .= '<td colspan=5><b>Total Biaya</b></td>';
                $col .= '<td style="text-align:right;">' . number_format($total, 0, "", ".") . '</td>';
                $col .= '</tr>';
                $cols .= $col;
                $total_biaya += $total;  //menambahkan biaya admin farmasi
            }
            echo ($cols);
            $total = round($total_biaya + $totalbiayaadminfarmasi);
            //HARUS DARI DATABASE >> $iurBiaya = $total - ($subsidiAsuransi + $subsidiPemerintah + $subsidiRumahSakit);  //karena $iurBiaya yang diambil di tindakanpelayanan_t sering tidak sama dengan total biaya - subsidi 
            ?>
            <tfoot>
                <tr>
                    <td colspan="5">
                        <div class='pull-right'>Total Biaya Keselurahan</div>
                    </td>
                    <td style="text-align:right;"><?php echo number_format($total, 0, "", "."); ?></td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class='pull-right'>Tanggungan Asuransi</div>
                    </td>
                    <td style="text-align:right;"><?php echo number_format($subsidiAsuransi, 0, "", "."); ?></td>
                </tr>
                <!--<tr>
                        <td colspan="5"><div class='pull-right'>Tanggungan Pemerintah</div></td>
                        <td style="text-align:right;"><?php //echo number_format($subsidiPemerintah); 
                                                        ?></td>
                    </tr>-->
                <tr>
                    <td colspan="5">
                        <div class='pull-right'>Tanggungan Rumah Sakit</div>
                    </td>
                    <td style="text-align:right;"><?php echo number_format($subsidiRumahSakit, 0, "", "."); ?></td>
                </tr>
                <!--
                    <tr>
                        <td colspan="5"><div class='pull-right'>Iur Biaya</div></td>
                        <td style="text-align:right;"><?php //echo number_format($iurBiaya);
                                                        ?></td>
                    </tr>
-->
                <tr>
                    <td colspan="5">
                        <div class='pull-right'>Tanggungan Pasien</div>
                    </td>
                    <td style="text-align:right;"><?php echo number_format(($total - $subsidiAsuransi - $subsidiPemerintah - $subsidiRumahSakit), 0, "", "."); ?></td>
                </tr>
            </tfoot>
        </table>
    </td>
</tr>
</table>
<?php if (isset($caraPrint)) { ?>
    <table width="100%" style="margin-top:20px;">
        <tr>
            <td width="50%" align="left" align="top">
                <table width="50%">
                    <tr>
                        <td width="50%" align="center">
                            <div><?php echo Yii::app()->user->getState("kabupaten_nama") . ", " . Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></div>
                            <div>Petugas</div>
                            <div style="margin-top:60px;"><?php echo $data['nama_pegawai']; ?></div>
                        </td>
                    </tr>
                </table>
            </td>
            <td align="right" valign="top">
                <table width="50%">
                    <tr>
                        <td width="50%">Total Biaya</td>
                        <td width="3%">:</td>
                        <td><?php echo $total_biaya; ?></td>
                    </tr>
                    <tr>
                        <td>Deposit</td>
                        <td>:</td>
                        <td><?php echo $data['uang_cicilan']; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggungan Pasien</td>
                        <td>:</td>
                        <td>
                            <?php
                            $kembalian = $total_biaya;
                            if ($data['uang_cicilan'] > 0) {
                                if ($data['uang_cicilan'] < $total_biaya) {
                                    $kembalian = $total_biaya - $data['uang_cicilan'];
                                }
                            }
                            echo $kembalian;
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
<?php } else {
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printPDF(\'PDF\')'));
    $this->widget('UserTips', array('type' => 'admin'));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    //        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    if (!empty($modRincian[0]->tindakansudahbayar_id)) { //sudah bayar / lunas
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/rincianKasirSudahBayarPrint');
    } else {
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/rincianKasirBaruPrint');
    }
    $pendaftaran_id = isset($modPendaftaran->pendaftaran_id) ? $modPendaftaran->pendaftaran_id : null;
    $idpembayaran = isset($modPendaftaran->pembayaranpelayanan_id) ? $modPendaftaran->pembayaranpelayanan_id : null;
    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&id=${pendaftaran_id}&idpembayaran=${idpembayaran}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
function printPDF(caraPrint)
{
    window.open("${urlPrint}&id=${pendaftaran_id}&idpembayaran=${idpembayaran}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
} ?>