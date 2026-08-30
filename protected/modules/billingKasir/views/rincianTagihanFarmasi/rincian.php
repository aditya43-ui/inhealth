<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
');
?>
<?php
if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $data['judulLaporan'] . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    } else if ($caraPrint == 'PRINT') {
        echo CHtml::css('.control-label{
                float:left; 
                text-align: right; 
                width:50%;
                color:black;
                padding-right:10px;
                font-size:11pt;
            }
            td, th{
                font-size:11pt;
            }
            
        ');
    }
//    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$data['judulLaporan']));      
}
?>
<style>

    .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }

    thead th{
        background:none;
        color:#333;
    }

    .border {
        box-shadow:none;
        border-spacing: 0;
        padding: 0;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header"><?php
                    if ($caraPrint != 'EXCEL') {
                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => "RINCIAN BIAYA FARMASI"));
                    }
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">

                        <tr>
                            <td>
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <td width="50%">
                                        <label class='control-label'>
                                            No. RM / No. Pend :
                                      </label>
                                        <?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?> / 
                                        <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
                                    </td>
                                    <Td width="5%"></td>
                                    <td>
                                        <label class='control-label'>
                                            Nama PJP :
                                      </label>
                                        <?php
                                        if (strlen($modPendaftaran->penanggungjawab_id) > 0) {
                                            echo CHtml::encode(isset($modPendaftaran->penanggungJawab->nama_pj) ? $modPendaftaran->penanggungJawab->nama_pj : '');
                                        } else {
                                            echo CHtml::encode($modPendaftaran->pasien->nama_pasien);
                                        }
                                        ?>
                                    </td>
                        </tr>
                        <tr>

                        <tr>
                            <td>
                                <label class='control-label'>
                                    <?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?>:
                              </label>
                                <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?>
                            </td>
                            <Td></td>
                            <td>   
                                <label class='control-label'>
                                    Alamat PJP :
                              </label>
                                <?php
                                if (strlen($modPendaftaran->penanggungjawab_id) > 0) {
                                    echo CHtml::encode(isset($modPendaftaran->penanggungJawab->nama_pj) ? $modPendaftaran->penanggungJawab->nama_pj : '');
                                } else {
                                    echo CHtml::encode($modPendaftaran->pasien->alamat_pasien);
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class='control-label'>
                                    <?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?>:
                              </label>
                                <?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>
                            </td>
                            <Td></td>
                            <td>   
                                <label class='control-label'>
                                    <?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('alamat_pasien')); ?>:
                              </label>
                                <?php echo CHtml::encode($modPendaftaran->pasien->alamat_pasien); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class='control-label'>
                                    <?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?>:
                              </label>
                                <?php echo CHtml::encode($modPendaftaran->umur); ?>
                            </td>
                            <Td></td>
                            <td>   
                                <label class='control-label'>
                                    Jenis Penjamin - Penjamin :
                              </label>
                                <?php
                                if (strlen($modPendaftaran->carabayar_id) && strlen($modPendaftaran->penjamin_id) > 0) {
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
                                <?php echo ( isset($modPendaftaran->rujukan->nama_perujuk) ? CHtml::encode($modPendaftaran->rujukan->nama_perujuk) : '-');
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class='control-label'>Dokter Pemeriksa :</label>
                                <?php echo CHtml::encode(isset($modPendaftaran->dokter->nama_pegawai) ? $modPendaftaran->dokter->nama_pegawai : ''); ?>                        
                            </td>
                            <Td></td>
                            <td>   
                                <label class='control-label'>
                                    Rujukan Dari :
                              </label>
                                <?php
                                if (strlen($modPendaftaran->rujukan_id) > 0) {
                                    echo CHtml::encode($modPendaftaran->rujukan->asalrujukan->asalrujukan_nama);
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class='control-label'>Tgl. Pemeriksaan :</label>
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
                                if (strlen($modPendaftaran->rujukan_id) > 0) {
                                    echo CHtml::encode($modPendaftaran->rujukan->no_rujukan);
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
                <table width="100%" style='margin-left:auto; margin-right:auto;'> <!--class='table table-striped table-bordered table-condensed'-->
                    <thead class="border">
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>No. Resep</th>
                            <th>Nama Items</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <?php
                    $totalSeluruh = 0;
                    $totalObat = 0;
                    $totalAlkes = 0;
                    $totalAdmin = 0;
                    $kelompokObat = 0;
                    $kelompokAlkes = 0;

                    $data_obat = array();
                    $data_alkes = array();
                    foreach ($modRincian as $i => $mod) {
                        $totalAdmin += ($mod->biayaservice + $mod->biayaadministrasi + $mod->biayakonseling);

                        //if(!(strtolower($mod->jenisobatalkes_nama) == 'obat')){ perbaikan 28-10-2013
                        if ((strtolower($mod->jenisobatalkes_nama) == 'obat')) {
                            if ($mod->qty_oa > 0) {
                                $data_obat[$kelompokObat] = $mod;
                                $kelompokObat++;
                                $totalObat += ($mod->qty_oa * $mod->hargasatuan_oa);
                            }
                        } else
                        if ((strtolower($mod->jenisobatalkes_nama) == 'alkes')) {
                            if ($mod->qty_oa > 0) {
                                $data_alkes[$kelompokAlkes] = $mod;
                                $kelompokAlkes++;
                                $totalAlkes += ($mod->qty_oa * $mod->hargasatuan_oa);
                            }
                        }
                    }
                    $totalSeluruh += ($totalObat + $totalAlkes);
                    ?>
                    <?php
                    if ($kelompokObat > 0) {
                        echo "<tr><td colspan = '7'><b>Kelompok : Obat</b></td></tr>";
                        for ($i = 0; $i < $kelompokObat; $i++) {
                            ?>
                            <tr>
                                <td><?php echo ($i + 1); ?></td>
                                <td><?php echo $data_obat[$i]->tglpenjualan; ?></td>
                                <td><?php echo $data_obat[$i]->noresep; ?></td>
                                <td><?php echo $data_obat[$i]->obatalkes_nama; ?></td>
                                <td class="uang"><?php echo $format->formatNumber($data_obat[$i]->qty_oa); ?></td>
                                <td class="uang"><?php echo $format->formatNumber($data_obat[$i]->hargasatuan_oa); ?></td>
                                <td class="uang"><?php echo $format->formatNumber($data_obat[$i]->qty_oa * $data_obat[$i]->hargasatuan_oa); ?></td>
                                <td><?php echo (empty($data_obat[$i]->oasudahbayar_id)) ? "Belum Lunas" : "Sudah Lunas"; ?></td>
                            </tr>
                        <?php } ?>
                        <tr class="border">
                            <td colspan="6"></td><td class="uang"><b><?php echo $format->formatNumber($totalObat); ?></b></td>
                        </tr>
                    <?php } ?>

                    <?php
                    if ($kelompokAlkes > 0) {
                        echo "<tr><td colspan = '7'><b>Kelompok : Alat Kesehatan</b></td></tr>";
                        for ($i = 0; $i < $kelompokAlkes; $i++) {
                            ?>
                            <tr>
                                <td><?php echo ($i + 1); ?></td>
                                <td><?php echo $data_alkes[$i]->tglpenjualan; ?></td>
                                <td><?php echo $data_alkes[$i]->noresep; ?></td>
                                <td><?php echo $data_alkes[$i]->obatalkes_nama; ?></td>
                                <td class="uang"><?php echo $format->formatNumber($data_alkes[$i]->qty_oa); ?></td>
                                <td class="uang"><?php echo $format->formatNumber($data_alkes[$i]->hargasatuan_oa); ?></td>
                                <td class="uang"><?php echo $format->formatNumber($data_alkes[$i]->qty_oa * $data_alkes[$i]->hargasatuan_oa); ?></td>
                                <td><?php echo (empty($data_alkes[$i]->oasudahbayar_id)) ? "Belum Lunas" : "Sudah Lunas"; ?></td>
                            </tr>
                        <?php } ?>
                        <tr class="border">
                            <td colspan="6"></td><td class="uang"><b><?php echo $format->formatNumber($totalAlkes); ?></b></td>
                        </tr>
                    <?php } ?>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="uang"><b>Total Tagihan :</b></td>
                            <td class="uang"><b><?php echo $format->formatNumber($totalSeluruh); ?></b></td>
                        </tr>
                        <tr>
                            <td colspan="6" class="uang"><b>Total Biaya Racik, dll. :</b></td>
                            <td class="uang"><b><?php echo $format->formatNumber($totalAdmin); ?></b></td>
                        </tr>
                        <tr>
                            <td colspan="6" class="uang"><b>Total Tangungan :</b></td>
                            <td class="uang"><b><?php echo $format->formatNumber($totalSeluruh + $totalAdmin); ?></b></td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
</table>
<?php if ($caraPrint == 'PRINT') { ?>

    <table width="80%" style="margin-top:20px;">
        <tr>
            <td width="50%" align="center"></td>
            <td width="50%" align="center">
                Tasikmalaya, <?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?><br>
                Petugas,
                <div style="margin-top:50px;"></div><?php echo $data['nama_pegawai']; ?>
            </td>
        </tr>
    </table>
    <?php
} else {

//echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
//        $this->widget('UserTips',array('type'=>'admin'));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/rincianTagihanFarmasi/rincian');
    $pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&id=${pendaftaran_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
}
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