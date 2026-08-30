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
<table width="100%" style='margin-left:auto; margin-right:auto;'>
    <tr>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?>
        </td>
        <Td width="30%">
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->tgl_pendaftaran); ?>
        </td><br>
    </tr>
    <tr>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>
        </td>
        <Td width="30%">
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
        </td><br>
    </tr>
    <tr>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->umur); ?>
        </td>
        <Td width="30%">
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('kelaspelayanan')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); ?>
        </td><br>
    </tr>
    <tr>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('carabayar_id')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?>
        </td>
        <Td width="30%">
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('diagnosa')); ?>:</label>
            <?php if (!empty($modPendaftaran->diagnosa) && count((array)$modPendaftaran->diagnosa) > 0) { ?>
                <ul>
                    <?php foreach ($modPendaftaran->diagnosa as $row) {
                        echo '<li>' . $row->diagnosa->diagnosa_nama . '</li>';
                    } ?>
                </ul>
            <?php } else {
                echo ' - ';
            } ?>
        </td><br>
    </tr>
    <tr>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('penjamin_id')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?>
        </td>
        <Td width="30%">
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('instalasi_id')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->instalasi->instalasi_nama); ?>
        </td>
    </tr>
</table>
<table class='table table-striped table-bordered table-condensed'>
    <thead>
        <tr>
            <th>
                Keterangan
            </th>
            <th>
                Kategori (Dokter)<br>Tindakan
            </th>
            <th>
                Tarif Satuan
            </th>
            <th>
                Jumlah
            </th>
            <th>
                Tarif Cyto
            </th>
            <th style="text-align:center;">
                Keringanan (%)
            </th>
            <th>
                Sub Total
            </th>
            <th>
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
            $rowspan = count(BKRinciantagihanpasienV::model()->findAll('ruangan_id = ' . $row->ruangan_id . ' and pendaftaran_id = ' . $row->pendaftaran_id));
            if (!in_array($row->ruangan_id, $ruangan)) {
                $ruangan[] = $row->ruangan_id;
                $ruanganTd = '<td rowspan="' . $rowspan . '" style="vertical-align:middle;text-align:center;">' . $row->ruangan_nama . '</td>';
            } else {
                $ruanganTd = '';
            }
            //             ============== digunakan untuk menghitung bila ada diskon 
            if ($row->discount_tindakan != 0) {
                $qtyHarga = $row->qty_tindakan * $row->tarif_satuan;
                $subtot = round($qtyHarga - ($qtyHarga * ($row->discount_tindakan / 100)));
            } else {
                $subtot = $row->subTotal;
            }
            //          ======== end (add date : 30-04-2013 JW)
            echo '<tr>
                    ' . $ruanganTd . '
                    <td>' . $row->kategoritindakan_nama . ' (' . $row->nama_pegawai . ')<br>' . $row->daftartindakan_nama . '
                    </td>
                    <td style="text-align:right;">' . number_format($row->tarif_satuan) . '
                    </td>
                    <td>' . $row->qty_tindakan . '
                    </td>
                    <td style="text-align:right;">' . number_format($row->tarifcyto_tindakan) . '
                    </td>
                    <td style="text-align:right;">' . number_format($row->discount_tindakan) . '
                    </td>
                    <td style="text-align:right;">' . number_format($subtot) . '
                    </td>
                    <td>' . ((empty($row->tindakansudahbayar_id)) ? "BELUM LUNAS" : "LUNAS") . '
                    </td>
                   </tr>';
            //            $total += $row->subTotal;
            $total += round($subtot);
            $subsidiAsuransi += $row->subsidiasuransi_tindakan;
            $subsidiPemerintah += $row->subsidipemerintah_tindakan;
            $subsidiRumahSakit += $row->subsisidirumahsakit_tindakan;
            $iurBiaya += $row->iurbiaya_tindakan;
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">
                <div class='pull-right'>Total Tagihan</div>
            </td>
            <td style="text-align:right;"><?php echo number_format($total); ?></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6">
                <div class='pull-right'>Tanggungan Asuransi</div>
            </td>
            <td><?php echo $subsidiAsuransi; ?></td>
            <td></td>
        </tr>
        <!--<tr>
            <td colspan="6"><div class='pull-right'>Tanggungan Pemerintah</div></td>
            <td><?php // echo $subsidiPemerintah; 
                ?></td>
            <td></td>
        </tr>-->
        <tr>
            <td colspan="6">
                <div class='pull-right'>Tanggungan Rumah Sakit</div>
            </td>
            <td><?php echo $subsidiRumahSakit; ?></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6">
                <div class='pull-right'>Iur Biaya</div>
            </td>
            <td><?php echo $iurBiaya; ?></td>
            <td></td>
        </tr>
    </tfoot>
</table>
<?php
//$this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
//	'id'=>'rjrinciantagihanpasien-v-grid',
//        'enableSorting'=>false,
//	'rowProvider'=>$modRincian->searchrowRincian(),
//        'template'=>"{summary}\n{items}\n{pager}",
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        'mergeColumns' => array('ruangan_nama'),
//        
//	'columns'=>array(
//            array(
//                'name'=>'ruangan_nama',
//                'value'=>'$row->ruangan_nama',
//                'footer'=>false, 
//            ),
//            'tarif_satuan',
//            'qty_tindakan',
//            'tarifcyto_tindakan',
//            array(
//                'name'=>'discount_tindakan',
//                'value'=>'$row->discount_tindakan',
//               'footer'=>false, 
//                ),
//            array(
//                'name'=>'subTotal',
//                'value'=>'$row->subTotal',
////                'footer'=>$modRincian->totals(),
//                ),
//            
//        ),
//    
//    )); 
?>
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
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    $this->widget('UserTips', array('type' => 'admin'));
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