<?php
    if(!is_null($caraPrint))
    {
        if($caraPrint=='EXCEL')
        {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
            header('Cache-Control: max-age=0');
        }
    }
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<style>
    .grid th {
        border: 1px solid;
        padding: 2px;
        background-color: transparent;
        text-align: center;
    }
    .grid td{
        border: 1px solid;
        padding: 2px;
        background-color: transparent;
    }
</style>

<table width="100%">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNewV1', array());
                    ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
    <table width="100%">
        <tr>
            <td style="text-align:center;" align="center"><div class="judulcontent"><b>BUKTI KAS MASUK</b></div></td>
        </tr>
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td width="25%">&nbsp;</td>
                        <td width="25%">&nbsp;</td>
                        <td style="text-align:right;" width="25%" align="right">No. BKM</td>
                        <td width="25%">: &nbsp;<?php echo $data['header']['no_bkm']?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="text-align:right;" align="right">Tgl. BKM</td>
                        <td>: &nbsp;<?php echo $data['header']['tgl_bkm']?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td width="150">Telah Terima Dari</td>
                        <td>:&nbsp;<?php echo $data['header']['pembayar']?></td>
                    </tr>
                    <tr>
                        <td>Dalam Jumlah Angka </td>
                        <td>: &nbsp;<span class="currency"><?php echo $data['header']['total_bayar']?></span></td>
                    </tr>
                    <tr>
                        <td>Dalam Jumlah Huruf</td>
                        <td>:<i>&nbsp;<?php echo $data['header']['total_bayar_huruf']?> Rupiah</i></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="100%" class="<?php echo (!is_null($caraPrint) ? "grid" : "table-striped table-bordered table-condensed")?>">
                    <thead>
                        <tr>
                            <th style="text-align:center;" width="150">Tanggal</th>
                            <th style="text-align:center;" >Keterangan</th>
                            <th style="text-align:center;" width="150">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $rows = '';
                            if (count((array)$data['detail']) > 0)
                            {
                                $rows = '';
                                foreach($data['detail'] as $val)
                                {
                                    $rows .= '<tr>';
                                    $rows .= '<td>'. MyFormatter::formatDateTimeForUser($val['tglpembayaran']) .'</td>';
                                    $rows .= '<td>'. $val['keterangan'] .'</td>';
                                    $rows .= '<td style="text-align:right;">Rp. '. $format->formatNumberForPrint($val['jumlah'],0) .'</td>';
                                    $rows .= '</tr>';
                                }
                            }else{
                                $rows .= '<tr>';
                                $rows .= '<td colspan="3">data kosong</td>';
                                $rows .= '</tr>';
                            }
                            echo $rows;
                        ?>
                        <?php if($data['header']['totalsubsidirs'] != 0){ ?>
                        <tr>
                            <td colspan="2" style="text-align:center;">Total Tanggungan Rumah Sakit</td>
                            <td style="text-align:right;">
                            <?php
                                // if($data['header']['pembulatan'] < 0) {
                                    // abs berfungsi untuk mengubah nilai ngatif jadi positif
                                    echo "(Rp. ".MyFormatter::formatNumberForPrint($data['header']['totalsubsidirs'], 2, true).")";
                                // } else {
                                //     echo "Rp ".$data['header']['pembulatan'];
                                // }
                            ?>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="2" style="text-align:center;">Jumlah Pembulatan</td>
                            <td style="text-align:right;">
                            <?php
                                // if($data['header']['pembulatan'] < 0) {
                                    // abs berfungsi untuk mengubah nilai ngatif jadi positif
                                    echo "Rp. ".MyFormatter::formatNumberForPrint($data['header']['pembulatan'], 0, true);
                                // } else {
                                //     echo "Rp ".$data['header']['pembulatan'];
                                // }
                            ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
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
    <?php //echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
<?php
    if(!empty($caraPrint))
    {

    }else{
?>
        <div class="form-actions">
            <?php
                echo CHtml::link(
                    Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),
                    'javascript:void(0);',
                    array(
                        'class'=>'btn btn-info',
                        'onClick'=>'print("PRINT")'
                    )
                );
            ?>
            <?php
                echo CHtml::link(
                    Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),
                    'javascript:void(0);',
                    array(
                        'class'=>'btn btn-info',
                        'onClick'=>'print("PDF")'
                    )
                );
            ?>
<?php
$urlPrint = $actionUrl;
$js = <<< JSCRIPT
function print(caraPrint)
{
window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=890px');

}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);

    }
?>
