<tr>
    <td>
        <?php
		echo CHtml::hiddenField('detail[jnspengeluaranrek_id][]', $item->jnspengeluaranrek_id,array('class' => 'jnspengeluaranrek_id'));
        echo CHtml::hiddenField('detail[rekening5_id][]', $r->rekening5_id);
        echo CHtml::hiddenField('detail[debitkredit][]', $dk);
        ?>
        <?php echo $r->kdrekening5." - ".$r->nmrekening5; ?>
    </td>	
    <td><a onclick="batalRekening(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rekening jenis pegeluaran ini"><i class="icon-form-silang"></i></a></td>
</tr>