<?php echo CHtml::css('#table-linen thead tr th{vertical-align:middle;}'); ?>

<table class="table table-striped table-condensed" id="table-linen">
	<thead>
		<tr>
			<th>No. </th>
			<th>No. Register Linen</th>
			<th>Nama Linen</th>
			<th>Keterangan</th>
			<!--<th>Batal</th>-->
		</tr>
	</thead>
	<tbody>
		<?php foreach($modPengirimanDetail as $i => $detail){ ?>
		<tr>
			<td style="width:30px;"><?php echo $i+1; ?></td>
			<td>
				<?php echo $form->hiddenField($detail,'['.$i.']linen_id',array('readonly'=>true));?>
				<?php echo $detail->linen->noregisterlinen; ?>
			</td>
			<td><?php echo $detail->linen->namalinen; ?></td>
			<td>
				<?php echo $form->hiddenField($detail,'['.$i.']keterangan_linen',array('readonly'=>true));?>
				<?php echo $detail->keterangan_linen; ?>
			</td>
<!--			<td>
				<a onclick="batalLinen(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan linen"><i class="icon-form-silang"></i></a>
			</td>-->
		</tr>
		<?php } ?>
	</tbody>
</table>