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
    <table style="width: 100%; border: none;">
        <tr>
            <td style="text-align:center;" align="center"><b>DETAIL PENGELUARAN UMUM</b></td>
        </tr>
        <tr>
            <td>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td width="25%">&nbsp;</td>
                        <td width="25%">&nbsp;</td>
                        <td style="text-align:right;" width="25%" align="right">No. BKK</td>
                        <td width="25%">: &nbsp;<?php echo !empty($modPengeluaran->tandabuktikeluar_id)?$modPengeluaran->buktikeluar->nokaskeluar:' - '; ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="text-align:right;" align="right">Tanggal BKK</td>
                        <td>: &nbsp;<?php echo !empty($modPengeluaran->tandabuktikeluar_id)?$modPengeluaran->buktikeluar->tglkaskeluar:' - '; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="1024">
                    <tr>
                        <td width="150">Telah Bayar Kepada</td>
                        <td>:&nbsp;<?php echo $modPengeluaran->nopengeluaran.' / '.$modPengeluaran->jenispengeluaran->jenispengeluaran_nama.' / '.(!empty($modPengeluaran->tandabuktikeluar_id)?$modPengeluaran->buktikeluar->namapenerima:' - '); ?></td>
                    </tr>
                    <tr>
                        <td>Dalam Jumlah Angka </td>
                        <td>: &nbsp;<span class="currency"><?php echo MyFormatter::formatUang($modPengeluaran->totalharga);?></span></td>
                    </tr>
                    <tr>
                        <td>Dalam Jumlah Huruf</td>
                        <td>:<i>&nbsp;<?php echo MyFormatter::formatNumberTerbilang($modPengeluaran->totalharga); ?> Rupiah</i></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td>
				<?php if(count((array)$modUraianKeluarUmum) > 0){ ?>
                <table width="1024" class="<?php echo (isset($_GET['caraPrint']) ? "grid" : "table-striped table-bordered table-condensed")?>">
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
							foreach($modUraianKeluarUmum as $val)
							{
								$rows .= '<tr>';
								$rows .= '<td>'. MyFormatter::formatDateTimeForUser($modPengeluaran->tglpengeluaran) .'</td>';
								$rows .= '<td>'. $val->uraiantransaksi .'</td>';
								$rows .= '<td style="text-align:right;">'. MyFormatter::formatUang($val->totalharga) .'</td>';
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
</div>
<?php
    if(!isset($_GET['caraPrint'])){
?>
        <div class="form-actions">
            <?php
                echo CHtml::link(
                    Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')), 
                    'javascript:void(0);',
                    array(
                        'class'=>'btn btn-info',
                        'onClick'=>'print("PRINT")'
                    )
                );
            ?>
		</div>
<?php
$urlPrint = $this->createUrl('DetailPengeluaranUmum&pengeluaranumum_id='.$modPengeluaran->pengeluaranumum_id);
$js = <<< JSCRIPT
function print(caraPrint)
{
window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=890px');

}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);

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