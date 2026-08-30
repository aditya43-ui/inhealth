<style>
    .cols_hide {
        display: none;
    }

    <?php if (isset($_GET['caraPrint'])) : ?>.table {
        border-collapse: collapse;
        box-shadow: none;
    }

    .table th,
    .table td {
        background-color: #fff !important;
        border: 1px solid black !important;
    }

    .table th {
        text-align: center !important;
    }

    <?php endif; ?>
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
<table width="100%" style='margin-left:auto; margin-right:auto;font-size: 12px;'>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
        <td width="40%"></td>
        <td>Tgl. Pendaftaran</td>
        <td>:</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?></td>
    </tr>
    <tr>
        <td>Jeni Kelamin</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pasien->jeniskelamin; ?></td>
        <td></td>
        <td>No. Pendafaran</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->umur; ?></td>
        <td></td>
        <td>Kelas Pelayanan</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
    </tr>
    <tr>
        <td>Jenis Penjamin</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
        <td></td>
        <td>Diagnosa</td>
        <td>:</td>
        <td><?php
            if (!empty($modPendaftaran->diagnosa) && count((array)$modPendaftaran->diagnosa) > 0) { ?>
                <ul>
                    <?php foreach ($modPendaftaran->diagnosa as $row) {
                        echo '<li>' . $row->diagnosa->diagnosa_nama . '</li>';
                    } ?>
                </ul>
            <?php } else {
                echo ' - ';
            }
            ?>
        </td>
    </tr>
    <!--tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pasien->nama_pasien ?></td>
        <td></td>
        <td>Tgl. Pendaftaran</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->tgl_pendaftaran ?></td>
    </tr-->
    <tr>
        <td>Penjamin</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
        <td></td>
        <td>Jenis Kasus Penyakit</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama; ?></td>
    </tr>
</table>
<!--<table width="100%" style='margin-left:auto; margin-right:auto;'>
     <tr>        
        <td>
            <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); 
                                            ?>:</label>
            <?php //echo CHtml::encode($modPendaftaran->pasien->nama_pasien); 
            ?>
            <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); 
                                                ?>:</label>
                <?php //echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); 
                ?>
            <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); 
                                                ?>:</label>
                <?php //echo CHtml::encode($modPendaftaran->umur); 
                ?>
            <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('carabayar_id')); 
                                                ?>:</label>
                <?php //echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); 
                ?>
            <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('penjamin_id')); 
                                                ?>:</label>
                <?php //echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); 
                ?>
        </td>
        <td width="30%">
        </td>
        <td>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); 
                                                ?>:</label>
            <?php //echo CHtml::encode($modPendaftaran->tgl_pendaftaran); 
            ?>
            <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); 
                                                ?>:</label>
                <?php //echo CHtml::encode($modPendaftaran->no_pendaftaran); 
                ?>
            <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('kelaspelayanan')); 
                                                ?>:</label>
            <?php //echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); 
            ?>
            <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('diagnosa')); 
                                                ?>:</label>
                    <?php //if (count((array)$modPendaftaran->diagnosa) > 0 ){ 
                    ?>
                    <ul>
                            <?php ///foreach ($modPendaftaran->diagnosa as $row){
                            //echo '<li>'.$row->diagnosa->diagnosa_nama.'</li>';
                            //  } 
                            ?>
                    </ul>
                    <?php //} else { echo ' - '; }
                    ?>
                   <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('jeniskasuspenyakit_id')); 
                                                ?>:</label>
            <?php //echo CHtml::encode($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama); 
            ?>
        </td>
        </tr>
    </table>-->
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
            <th>
                Keringanan
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
            $rowspan = count(RJRinciantagihanpasienV::model()->findAll('ruangan_id = ' . $row->ruangan_id . ' and pendaftaran_id = ' . $row->pendaftaran_id));
            if (!in_array($row->ruangan_id, $ruangan)) {
                $ruangan[] = $row->ruangan_id;
                $ruanganTd = '<td rowspan="' . $rowspan . '" style="vertical-align:middle;text-align:center;">' . $row->ruangan_nama . '</td>';
            } else {
                $ruanganTd = '';
            }
            $subtot = $row->tarifcyto_tindakan + ($row->tarif_satuan * $row->qty_tindakan);
            $pegawai = PegawaiM::model()->findByPk($row->pegawai_id);
            echo '<tr>
                    ' . $ruanganTd . '
                    <td>' . $row->kategoritindakan_nama . ' (' . $pegawai->namaLengkap . ')<br>' . $row->daftartindakan_nama . '
                    </td>
                    <td style="text-align:right;">' . number_format($row->tarif_satuan, 0, ',', '.') . '
                    </td>
                    <td style="text-align:right;">' . $row->qty_tindakan . '
                    </td>
                    <td style="text-align:right;">' . number_format($row->tarifcyto_tindakan, 0, ',', '.') . '
                    </td>
                    <td style="text-align:right;">' . $row->discount_tindakan . '
                    </td>
                    <td style="text-align:right;">' . number_format($subtot, 0, ',', '.') . '
                    </td>
                    <td>' . ((empty($row->tindakansudahbayar_id)) ? "BELUM LUNAS" : "LUNAS") . '
                    </td>
                   </tr>';
            $total += $subtot;
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
            <td style="text-align:right;"><?php echo number_format($total, 0, ',', '.'); ?></td>
            <td rowspan="4"></td>
        </tr>
        <tr>
            <td colspan="6">
                <div class='pull-right'>Tanggungan Asuransi</div>
            </td>
            <td style="text-align:right;"><?php echo number_format($subsidiAsuransi, 0, ',', '.'); ?></td>
            <!--td></td-->
        </tr>
        <!--<tr class="cols_hide">
            <td colspan="6"><div class='pull-right'>Tanggungan Pemerintah</div></td>
            <td style="text-align:right;"><?php echo number_format($subsidiPemerintah, 0, ',', '.'); ?></td>
            <td></td>
        </tr>-->
        <tr>
            <td colspan="6">
                <div class='pull-right'>Tanggungan Rumah Sakit</div>
            </td>
            <td style="text-align:right;"><?php echo number_format($subsidiRumahSakit, 0, ',', '.'); ?></td>
            <!--td></td-->
        </tr>
        <tr>
            <td colspan="6">
                <div class='pull-right'>Iur Biaya</div>
            </td>
            <td style="text-align:right;"><?php echo number_format(($total - $iurBiaya), 0, ',', '.'); ?></td>
            <!--td></td-->
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
    // $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $controller = 'RinciantagihanpasienV';
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