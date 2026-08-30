<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
<style type="text/css">
    @page { 
        size: potrait;
        font-style:"Arial Narrow", Arial, sans-serif;
        size: A5;
        margin: 0;
    }
    .control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:14px;
        font-style:"Arial Narrow", Arial, sans-serif;
    }
</style>
<?php 
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
?>
<table>
    <thead>
        <tr>
             <!-- <td>
                <div class="header"><?php
                    //echo $this->renderPartial('application.views.headerReport.headerDefaultV3', array());
                    ?></div>
            </td> -->
            <td style="padding-left:300px;" valign="MIDDLE" align="right" colspan=" 9">
                <br>
                <!-- <b><font size="5" color="black" face="Liberation Serif">INSTALASI FARMASI APOTEK</font></b><br> -->
                <b><font size="4" color="black" face="Liberation Serif"><b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b></font></b><br>
                <font color="black" face="Liberation Serif"><?php echo $modProfilRs->alamatlokasi_rumahsakit; ?></font><br>
                <font color="black" face="Liberation Serif">Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?></font>
            </td>
        </tr>
    </thead>
</table>
<br>
<table style="width: 100%; border: none;">
    <tr>
        <td style="text-align:center;" align="center"><b>DETAIL PENGELUARAN KAS / UMUM</b></td>
    </tr>
    <tr>
        <td>
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="25%">&nbsp;</td>
                    <td width="25%">&nbsp;</td>
                    <td style="text-align:right;" width="25%" align="right">No. BKK</td>
                    <td width="25%">: &nbsp;<?php echo !empty($model->tandabuktikeluar_id) ? $model->buktikeluar->nokaskeluar : ' - '; ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td style="text-align:right;" align="right">Tanggal BKK</td>
                    <td>: &nbsp;<?php echo !empty($model->tandabuktikeluar_id) ?  MyFormatter::formatDateTimeForUser($model->buktikeluar->tglkaskeluar) : ' - '; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td width="150">Telah Bayar Kepada</td>
                    <td>:&nbsp;<?php echo $model->nopengeluaran . ' / ' . $model->jenispengeluaran->jenispengeluaran_nama . ' / ' . (!empty($model->tandabuktikeluar_id) ? $model->buktikeluar->namapenerima : ' - '); ?></td>
                </tr>
                <tr>
                    <td>Dalam Jumlah Angka </td>
                    <td>: &nbsp;<span class="currency"><?php echo MyFormatter::formatUang($model->totalharga); ?></span></td>
                </tr>
                <tr>
                    <td>Dalam Jumlah Huruf</td>
                    <td>:<i>&nbsp;<?php echo MyFormatter::formatNumberTerbilang($model->totalharga); ?> Rupiah</i></td>
                </tr>
                <tr>
                    <td>Cara Pembayaran</td>
                    <td>:<i>&nbsp;<?php 
                    $modTandaBuktiBayar = TandabuktikeluarT::model()->findByPk($model->tandabuktikeluar_id);
                    echo $modTandaBuktiBayar->carabayarkeluar; 
                    ?></i></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="text-align:center;" align="center">&nbsp;</td>
    </tr>
    <tr>
        <td>
            <?php if (count((array)$modUraian) > 0) { ?>
                <table class="<?php echo (isset($_GET['caraPrint']) ? "grid" : "table-striped table-bordered table-condensed") ?>">
                    <thead>
                        <tr>
                            <th style="text-align:center;" width="150">Tanggal</th>
                            <th style="text-align:center;">Keterangan</th>
                            <th style="text-align:center;" width="150">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rows = '';
                        foreach ($modUraian as $val) {
                            $rows .= '<tr>';
                            $rows .= '<td>' . MyFormatter::formatDateTimeForUser($model->tglpengeluaran) . '</td>';
                            $rows .= '<td>' . $val->uraiantransaksi . '</td>';
                            $rows .= '<td style="text-align:right;">' . MyFormatter::formatUang($val->totalharga) . '</td>';
                            $rows .= '</tr>';
                        }
                        echo $rows;
                        ?>
                    </tbody>
                </table>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
<?php
$modPegawaiKeluar = PegawaiM::model()->findByPk($modTandaBukti->create_loginpemakai_id);
// $modPegawaiKetahui = PegawaiM::model()->findByPk($model->pegawaimengetahui_id);
?>
<table style="text-align: center;width:100%;">
    <tr>
        <td>Penerima</td>
        <td>Pegawai Mengeluarkan</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>(<?php echo !empty($modTandaBukti->namapenerima)?$modTandaBukti->namapenerima:'______________________'; ?>)</td>
        <td>(<?php echo !empty($modPegawaiKeluar->namaLengkap)?$modPegawaiKeluar->namaLengkap :'-'; ?>)</td>
    </tr>
</table>
<?php
if (!isset($_GET['caraPrint'])) {
?>
    <div class="form-actions">
        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
            'javascript:void(0);',
            array(
                'class' => 'btn btn-info',
                'onClick' => 'print("PDF")'
            )
        );
        ?>
    </div>
<?php
    $urlPrint = $this->createUrl('DetailPengeluaranUmum&pengeluaranumum_id=' . $modPengeluaran->pengeluaranumum_id);
    $js = <<< JSCRIPT
function print(caraPrint)
{
window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=890px');

}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
}
?>
<!--<script type="text/javascript">
//	$(document).ready(function(){
//		$(".currency").each(
//                    function()
//                    {
//                        var val = $(this).text();
//                        $(this).text(formatNumber(val));
//                    }
//		);                
//	});
 </script>-->