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
        <?php if (isset($_GET['caraPrint'])): ?>
        <tr>
            <td>
                <?php echo $this->renderPartial('application.views.headerReport.headerDefault', array(), true);?>
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <td style="text-align:center;" align="center"><b>DETAIL PENERIMAAN KAS / UMUM</b></td>
        </tr>
        <tr>
            <td>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td width="25%">&nbsp;</td>
                        <td width="25%">&nbsp;</td>
                        
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td width="150">Telah Bayar Kepada</td>
                        <td>:&nbsp;<?php echo $modPenerimaan->nopenerimaan.' / '.$modPenerimaan->jenispenerimaan->jenispenerimaan_nama.' / '.(!empty($modPenerimaan->tandabuktibayar_id)?$modPenerimaan->buktibayar->darinama_bkm:' - '); ?></td>
                        <td style="text-align:right;" width="25%" align="right">No. BKM</td>
                        <td width="25%">: &nbsp;<?php echo !empty($modPenerimaan->tandabuktibayar_id)?$modPenerimaan->buktibayar->nobuktibayar:' - '; ?></td>
                    </tr>
                    <tr>
                        <td>Dalam Jumlah Angka </td>
                        <td>: &nbsp;<span><?php echo "Rp".number_format($modPenerimaan->totalharga,0,'','.');?></span></td>
                        <td style="text-align:right;" align="right">Tanggal BKM</td>
                        <td>: &nbsp;<?php echo !empty($modPenerimaan->tandabuktibayar_id)?  MyFormatter::formatDateTimeForUser($modPenerimaan->buktibayar->tglbuktibayar):' - '; ?></td>
                    </tr>
                    <tr>
                        <td>Dalam Jumlah Huruf</td>
                        <td>:<i>&nbsp;<?php echo MyFormatter::formatNumberTerbilang($modPenerimaan->totalharga); ?> Rupiah</i></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td>
				<?php if(count((array)$modUraianTerimaUmum) > 0){ ?>
                <table width="100%" class="<?php echo (isset($_GET['caraPrint']) ? "grid" : "table-striped table-bordered table-condensed")?>">
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
							foreach($modUraianTerimaUmum as $val)
							{
								$rows .= '<tr>';
								$rows .= '<td>'. MyFormatter::formatDateTimeForUser($modPenerimaan->tglpenerimaan) .'</td>';
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
    <?php
$modPegawaiKeluar = PegawaiM::model()->findByPk($modPenerimaan->pegawai_id);
// $modPegawaiKetahui = PegawaiM::model()->findByPk($model->pegawaimengetahui_id);
?>
<table width='100%' style="text-align: center;">
    <tr>
        <td>Pegawai Pengirim</td>
        <td>Pegawai Penerima</td>
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
        <td>(<?php echo !empty($modTanda->darinama_bkm)  ? $modTanda->darinama_bkm: "______________________" ?>)</td>
        <td>(<?php echo !empty($modPegawaiKeluar->namaLengkap)?$modPegawaiKeluar->namaLengkap :'-'; ?>)</td>
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
$urlPrint = $this->createUrl('DetailPenerimaanUmum&penerimaanumum_id='.$modPenerimaan->penerimaanumum_id);
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