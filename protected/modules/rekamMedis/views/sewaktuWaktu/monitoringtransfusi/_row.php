<tr>
    <td>
        <div style="margin-left:115px;">
            <div class="controls">
                <?php echo CHtml::dropDownList('['.$counter.']kondisi', '',  LookupM::getItemsUrutan('tandareaksi'),array('empty'=>'-- Pilih --','class'=>"span3 tandareaksi_$counter")) ?>
                <?php echo CHtml::htmlButton('-', array('class'=>'btn btn-danger', 'onclick'=>'hapusData(this);')); ?>
            </div>
        </div>
    </td>
</tr>