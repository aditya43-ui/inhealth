<table class="table table-striped table-condensed" id="tabel-detail">
	<thead>
		<tr>
			<th rowspan="2">No.</th>
			<th rowspan="2">Uraian Rekening	 <span class="required">*</span></th>
			<th colspan="5" rowspan="2">Kode Rekening</th>
			<th rowspan="2">Nama Rekening</th>
			<th colspan="2" align="center">Saldo</th>
			<th rowspan="2">Catatan</th>
			<th rowspan="2">Batal</th>
		</tr>
		<tr>
			<th>Debit</th>
			<th>Kredit</th>
		</tr>
	</thead>
	<tbody></tbody>
	<tfoot>
		<tr class="trfooter">
			<td colspan="8"><b>Total</b></td>
			<td>
				<?php
					echo CHtml::textField(
						"totalSaldoDebit",
						0,
						array(
							'readonly'=>true,'class'=>'span2 integer'
						)
					);
				?>
			</td>
			<td>
				<?php
					echo CHtml::textField(
						"totalSaldoKredit",
						0,
						array(
							'readonly'=>true,'class'=>'span2 integer'
						)
					);
				?>
			</td>
			<td colspan="2">&nbsp;</td>
		</tr>
	</tfoot>        
</table>