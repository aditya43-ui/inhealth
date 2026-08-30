<style>
    .border {
        border: 1px solid #000;
    }

    .table thead:first-child {
        border-top: 1px solid #000;
    }

    thead th {
        background: none;
        color: #333;
    }

    .table tbody tr:hover td,
    .table tbody tr:hover th {
        background-color: none;
    }
</style>
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
        width:140px;
        font-size:12px;
        color:black;
        padding-right:10px;
        }
    ');
?>
<table width="100%" class="table" style="box-shadow:none;">
    <tr>
        <td>
            <b><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?>:</b>
        </td>
        <td>
            : <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?>
        </td>
        <td>&nbsp;</td>
        <td><b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?></b></td>
        <td>: <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
    </tr>
    <tr>
        <td>
            <b><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>
        </td>
        <td>&nbsp;</td>
        <td><b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('kelaspelayanan_id')); ?></b></td>
        <td>: <?php echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); ?></td>
    </tr>
    <tr>
        <td>
            <b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($modPendaftaran->umur); ?>
        </td>
        <td>&nbsp;</td>
        <td><b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('diagnosa')); ?></b></td>
        <td>: <?php
                if (isset($modPendaftaran->diagnosa)) {
                    if (count((array)$modPendaftaran->diagnosa) > 0) { ?>
                    <ul>
                        <?php
                        foreach ($modPendaftaran->diagnosa as $row) {
                            echo '<li>' . $row->diagnosa->diagnosa_nama . '</li>';
                        }
                        ?>
                    </ul>
            <?php } else {
                        echo ' - ';
                    }
                } ?>
        </td>
    </tr>
    <tr>
        <td>
            <b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('carabayar_id')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?>
        </td>
        <td>&nbsp;</td>
        <td><b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); ?></b></td>
        <td>: <?php echo MyFormatter::formatDateTimeForUser(CHtml::encode($modPendaftaran->tgl_pendaftaran)); ?></td>
    </tr>
    <tr>
        <td>
            <b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('ruangan_id')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($modPendaftaran->ruangan->ruangan_nama); ?>
        </td>
    </tr>
</table>
<table class='table' style="box-shadow:none;">
    <thead>
        <tr>
            <th class="border">
                Keterangan
            </th>
            <th class="border">
                Kategori (Dokter)<br>Tindakan
            </th>
            <th class="border">
                Tarif Satuan
            </th>
            <th class="border">
                Jumlah
            </th>
            <th class="border">
                Tarif Cyto
            </th>
            <th class="border">
                Keringanan
            </th>
            <th class="border">
                Sub Total
            </th>
            <th class="border">
                Status Bayar
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $ruangan = array();
        $total = 0;
        $subsidiAsuransi = 0;
        $subsidiPemerintah = 0;
        $subsidiRumahSakit = 0;
        $iurBiaya = 0;
        foreach ($modRincian as $i => $row) {
            $rowspan = count(GZRincianTagihanPasienGizi::model()->findAll('ruangan_id = ' . $row->ruangan_id . ' and pendaftaran_id = ' . $row->pendaftaran_id));
            if (!in_array($row->ruangan_id, $ruangan)) {
                $ruangan[] = $row->ruangan_id;
                $ruanganTd = '<td class="border" rowspan="' . $rowspan . '" style="vertical-align:middle;text-align:center;">' . $row->ruangan_nama . '</td>';
            } else {
                $ruanganTd = '';
            }
            //            
            echo '<tr>
                ' . $ruanganTd . '
                    <td class="border">' . $row->kategoritindakan_nama . ' (' . $row->nama_pegawai . ')<br>' . $row->daftartindakan_nama . '
                    </td>
                    <td class="border" style="text-align:right;">' . number_format($row->tarif_satuan, 0, ',', '.') . '
                    </td>
                    <td class="border" style="text-align:right;">' . $row->qty_tindakan . '
                    </td>
                    <td class="border" style="text-align:right;">' . number_format($row->tarifcyto_tindakan, 0, ',', '.') . '
                    </td>
                    <td class="border">' . $row->discount_tindakan . '
                    </td>
                    <td class="border" style="text-align:right;">' . number_format($row->subTotal, 0, ',', '.') . '
                    </td>
                    <td class="border">' . ((empty($row->tindakansudahbayar_id)) ? "BELUM LUNAS" : "LUNAS") . '
                    </td>
                   </tr>';
            $total += $row->subTotal;
            $subsidiAsuransi += $row->subsidiasuransi_tindakan;
            $subsidiPemerintah += $row->subsidipemerintah_tindakan;
            $subsidiRumahSakit += $row->subsisidirumahsakit_tindakan;
            $iurBiaya += $row->iurbiaya_tindakan;
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td class="border" colspan="6">
                <div class='pull-right'>Total Tagihan</div>
            </td>
            <td class="border" style="text-align:right;"><?php echo number_format($total, 0, ',', '.'); ?></td>
            <td class="border" rowspan="5"></td>
        </tr>
        <tr>
            <td class="border" colspan="6">
                <div class='pull-right'>Tanggungan Asuransi</div>
            </td>
            <td class="border" style="text-align:right;"><?php echo number_format($subsidiAsuransi, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td class="border" colspan="6">
                <div class='pull-right'>Tanggungan Pemerintah</div>
            </td>
            <td class="border" style="text-align:right;"><?php echo number_format($subsidiPemerintah, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td class="border" colspan="6">
                <div class='pull-right'>Tanggungan Rumah Sakit</div>
            </td>
            <td class="border" style="text-align:right;"><?php echo number_format($subsidiRumahSakit, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td class="border" colspan="6">
                <div class='pull-right'>Iur Biaya</div>
            </td>
            <td class="border" style="text-align:right;"><?php echo number_format($iurBiaya, 0, ',', '.'); ?></td>
        </tr>
    </tfoot>
</table>
<?php if (isset($caraPrint)) { ?>
    <table width="100%" style='margin-top:100px;margin-left:auto;margin-right:auto;'>
        <tr>
            <td width="50%">
                <label style='float:left;'>Petugas : <?php echo $data['nama_pegawai']; ?></label>
            </td>
            <td width="50%">
                <label style='float:right;'>Tanggal Print : <?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></label>
            </td>
        </tr>
    </table>
<?php } else {
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    $content = $this->renderPartial('../tips/informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    $pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&id=${pendaftaran_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
} ?>