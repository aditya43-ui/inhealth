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
    .table {
        border: none;
        border-collapse: collapse;
        box-shadow: none;
    }
    .table td, .table th {
        background-color: white !important;
        border: 1px solid black !important;
    }
');
?>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>No. RM / No. Pend</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode($modPasien->no_rekam_medik); ?> / <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
                    <td>Nama PJP :</td>
                    <td>:</td>
                    <td>
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
                    <td>Nama Pasien</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode($modPasien->namadepan . $modPasien->nama_pasien); ?></td>
                    <td>Alamat PJP</td>
                    <td>:</td>
                    <td>
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
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode($modPasien->jeniskelamin); ?></td>
                    <td>Alamat Pasien</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode($modPasien->alamat_pasien); ?></td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode(substr($modPendaftaran->umur, 0, 7)); ?></td>
                    <td nowrap>Jenis Penjamin / Penjamin</td>
                    <td>:</td>
                    <td>
                        <?php
                        if (strlen($modPendaftaran->carabayar_id)  && strlen($modPendaftaran->penjamin_id) > 0) {
                            echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama) . " / " . CHtml::encode($modPendaftaran->penjamin->penjamin_nama);
                        } else {
                            echo '-' . "/" . "-";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Unit Pelayanan</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode($modPendaftaran->instalasi->instalasi_nama); ?></td>
                    <td>Nama Rujukan</td>
                    <td>:</td>
                    <td>
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
                    <td>Dokter Pemeriksa</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode($modPendaftaran->pegawai->namaLengkap); ?></td>
                    <td>Rujukan Dari</td>
                    <td>:</td>
                    <td>
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
                    <td nowrap>Tanggal Pemeriksaan</td>
                    <td>:</td>
                    <td>
                        <?php
                        if (strlen($modPendaftaran->tgl_pendaftaran) > 0) {
                            echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran));
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                    <td>No. Rujukan</td>
                    <td>:</td>
                    <td>
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
                    <td>Tanggal Tindakan</td>
                    <td>:</td>
                    <td>
                        <?php
                        if (isset($modRincianTagihan->pendaftaran_id)) {
                            echo CHtml::encode(MyFormatter::formatDateTimeForUser(MyFormatter::formatDateTimeForDb($modRincianTagihan->tgl_tindakan)));
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                    <td colspan="3"></td>
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
                $row[$ruangan_id]['kategori'][$i]['daftartindakan_nama'] = $val->daftartindakan_nama;
                $row[$ruangan_id]['kategori'][$i]['kelas'] = $val->kelaspelayanan_nama;
                $row[$ruangan_id]['kategori'][$i]['harga'] = (isset($val->tarif_medis) ? ($val->tarif_satuan - $val->tarif_medis) : $val->tarif_satuan);
                $row[$ruangan_id]['kategori'][$i]['qty'] = $val->qty_tindakan;
                $row[$ruangan_id]['kategori'][$i]['total'] = ($row[$ruangan_id]['kategori'][$i]['harga'] * $row[$ruangan_id]['kategori'][$i]['qty']);
                if ($val->daftartindakan_id == 5527 && ($val->daftartindakan_nama == 'LDL-Cholesterol' || $val->daftartindakan_nama == 'Cholesterol Total' || $val->daftartindakan_nama == 'Triglyseride')) {
                    $row[$ruangan_id]['kategori'][$i]['harga'] = 0;
                    $row[$ruangan_id]['kategori'][$i]['total'] = 0;
                }
                $harga = TindakanpelayananT::model()->findAllByPk($val->tindakanpelayanan_id);
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
                        $col .= '<td style="text-align:right;">' . MyFormatter::formatNumberForPrint($val['harga']) . '</td>';
                        $col .= '<td style="text-align:right;">' . $val['qty'] . '</td>';
                        $col .= '<td style="text-align:right;">' . MyFormatter::formatNumberForPrint($val['total']) . '</td>';
                        $col .= '</tr>';
                        if (strlen($val['nama_pegawai']) > 0) {
                            $col .= '<tr>';
                            $col .= '<td>&nbsp;</td>';
                            $col .= '<td>' . $val['nama_pegawai'] . '</td>';
                            $col .= '<td style="text-align:right;">' . MyFormatter::formatNumberForPrint($val['harga_dokter']) . '</td>';
                            $col .= '<td style="text-align:right;">' . $val['qty'] . '</td>';
                            $col .= '<td style="text-align:right;">' . MyFormatter::formatNumberForPrint($val['total_dokter']) . '</td>';
                            $col .= '</tr>';
                        }
                        $total += $val['total'] + $val['total_dokter'];
                        $subsidiAsuransi += $val['subsidiasuransi_tindakan'];
                        $subsidiPemerintah += $val['subsidipemerintah_tindakan'];
                        $subsidiRumahSakit += $val['subsisidirumahsakit_tindakan'];
                        $iurBiaya += $val['iurbiaya_tindakan'];
                    }
                    $col .= '<tr">';
                    $col .= '<td colspan=4><b>Total Biaya</b></td>';
                    $col .= '<td style="text-align:right;">' . MyFormatter::formatNumberForPrint($total) . '</td>';
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
                        <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($total); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div class='pull-right'>Tanggungan Asuransi</div>
                        </td>
                        <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($subsidiAsuransi); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div class='pull-right'>Tanggungan Pemerintah</div>
                        </td>
                        <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($subsidiPemerintah); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div class='pull-right'>Tanggungan Rumah Sakit</div>
                        </td>
                        <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($subsidiRumahSakit); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div class='pull-right'>Iur Biaya</div>
                        </td>
                        <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($iurBiaya); ?></td>
                    </tr>
                </tfoot>
            </table>
        </td>
    </tr>
</table>
<?php
if (isset($caraPrint)) { ?>
    <table width="100%" style="margin-top:20px;">
        <tr>
            <td width="50%" align="left" align="top">
                <table width="50%">
                    <tr>
                        <td width="50%" align="center">
                            <div><?php echo Yii::app()->user->getState('kecamatan_nama'); ?>, <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')); ?></div>
                            <div>Petugas Kasir</div>
                            <div style="margin-top:60px;"><?php echo $data['nama_pegawai']; ?></div>
                        </td>
                    </tr>
                </table>
            </td>
            <?php /*
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
                            if($data['uang_cicilan'] > 0){
                                if($data['uang_cicilan'] < $total_biaya)
                                {
                                    $kembalian = $total_biaya - $data['uang_cicilan'];
                                }                                            
                            }
                            echo $kembalian;
                        ?>
                    </td>
                </tr> ?>
            </table>                        
        </td>
         * 
         */ ?>
        </tr>
    </table>
<?php
} else {
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printPdf(\'PDF\')'));
    $this->widget('UserTips', array('type' => 'admin'));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    if (!empty($modRincian[0]->tindakansudahbayar_id)) { //sudah bayar / lunas
        $urlPrintPdf =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/rincianKasirLabSudahBayarPrint');
    } else {
        $urlPrintPdf =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/rincianKasirLabPrint');
    }
    //        $urlPrintPdf=  Yii::app()->createAbsoluteUrl('billingKasir/rinciantagihanpasienV/rincianKasirBaruPrint');
    $pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&id=${pendaftaran_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
function printPdf(caraPrint)
{
    window.open("${urlPrintPdf}/&id=${pendaftaran_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
} ?>