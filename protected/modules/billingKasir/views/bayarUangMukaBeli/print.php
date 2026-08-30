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
                        <td width="25%">: &nbsp;<?php echo $modBuktiKeluar->nokaskeluar; ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="text-align:right;" align="right">Tanggal BKK</td>
                        <td>: &nbsp;<?php echo $modBuktiKeluar->tglkaskeluar; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="1024">
                    <tr>
                        <td width="150">Telah Bayar Kepada</td>
                        <td>:&nbsp;Uang Muka untuk Supplier <?php echo $modBuktiKeluar->namapenerima; ?></td>
                    </tr>
                    <tr>
                        <td>Dalam Jumlah Angka </td>
                        <td>: &nbsp;<span class="currency"><?php echo MyFormatter::formatUang($modBuktiKeluar->jmlkaskeluar);?></span></td>
                    </tr>
                    <tr>
                        <td>Dalam Jumlah Huruf</td>
                        <td>:<i>&nbsp;<?php echo MyFormatter::formatNumberTerbilang($modBuktiKeluar->jmlkaskeluar); ?> Rupiah</i></td>
                    </tr>
                </table>
            </td>
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