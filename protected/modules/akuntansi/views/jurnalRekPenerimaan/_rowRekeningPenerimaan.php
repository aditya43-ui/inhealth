<tr>
    <td>
        <?php
        echo CHtml::hiddenField('detail[rekening5_id][]', $r->rekening5_id);
        echo CHtml::hiddenField('detail[debitkredit][]', $dk);
        ?>
        <?php echo $r->kdrekening5." - ".$r->nmrekening5; ?>
    </td>
    <td><a onclick="batalRekening(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rekening penerimaan"><i class="icon-form-silang"></i></a></td>
</tr>