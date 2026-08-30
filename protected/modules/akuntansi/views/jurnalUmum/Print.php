
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
?>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="11%" style="text-align:right;">Tanggal Bukti Jurnal</td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode(isset($model->tglbuktijurnal) ? MyFormatter::formatDateTimeForUser($model->tglbuktijurnal) : ""); ?>
                    </td>
                    <td width="11%" style="text-align:right;">Rek. Periode</td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode(isset($model->rekperiod_id) ? $model->rekPeriode->deskripsi : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td width="11%" style="text-align:right;">No. Bukti Jurnal</td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode(isset($model->nobuktijurnal) ? $model->nobuktijurnal : "-"); ?>
                    </td>
                    <td width="11%" style="text-align:right;">Kode Jurnal</td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode(isset($model->kodejurnal) ? $model->kodejurnal : ""); ?>
                    </td>
                </tr>
                <tr>
                    <td width="11%" style="text-align:right;">Jenis Jurnal</td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode(isset($model->jenisjurnal_id) ? $model->jenisJurnal->jenisjurnal_nama : ""); ?>
                    </td>
                    <td width="11%" style="text-align:right;">Uraian Jurnal</td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode(isset($model->urianjurnal) ? $model->urianjurnal : "-"); ?>
                    </td>
                </tr>
                   
            </table>            
        </td>
    </tr>
</table><br>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
    <thead>
        <tr>
			<th rowspan="2" style="text-align: center;">Tgl. Jurnal</th>
			<th rowspan="2" style="text-align: center;">Kode Jurnal</th>
			<th rowspan="2" style="text-align: center;">No. Bukti Jurnal</th>
			<th rowspan="2" style="text-align: center;">Tgl. Referensi <br> No. Referensi</th>
			<th rowspan="2" style="text-align: center;">Rekening</th>
			<th colspan="2" style="text-align: center;">Saldo</th>
		</tr>
		<tr>
			<th>Debit</th>
			<th>Kredit</th>
		</tr>
    </thead>
    <tbody>
        <?php 
			$total_debit = 0;
			$total_kredit = 0;
			foreach ($modDetail as $i => $detail) { 
				$total_debit += $detail->saldodebit;
				$total_kredit += $detail->saldokredit;
		?>
        <tr>
            <td>
                <?php echo isset($model->tglbuktijurnal) ? MyFormatter::formatDateTimeForUser($model->tglbuktijurnal) : ""; ?>
            </td>
            <td>
                <?php echo isset($model->kodejurnal)?$detail->kodejurnal:'-'; ?>
            </td>
            <td>
                <?php echo isset($model->nobuktijurnal)?$detail->nobuktijurnal:'-'; ?>
            </td>
            <td>
                <?php echo isset($model->tglreferensi) ? MyFormatter::formatDateTimeForUser($model->tglreferensi) : ""; ?><br>
				<?php echo isset($model->noreferensi) ? $model->noreferensi : ""; ?>
            </td>
            <td>
                <?php echo ($detail->getNamaRekDebit() == "-" ?  $detail->getNamaRekKredit() : $detail->getNamaRekDebit()); ?>
            </td>
			<td style="text-align: right;">
				<?php echo number_format($detail->saldodebit); ?>
			</td>
			<td style="text-align: right;">
				<?php echo number_format($detail->saldokredit); ?>
			</td>
        </tr>
        <?php } ?>
    </tbody>
	<tfoot>
		<tr>
			<td colspan="5" style="text-align: right;"><b>Total</b></td>
			<td style="text-align: right;"><?php echo number_format($total_debit); ?></td>
			<td style="text-align: right;"><?php echo number_format($total_kredit); ?></td>
		</tr>
	</tfoot>
</table>