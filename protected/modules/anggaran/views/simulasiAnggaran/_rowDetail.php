<tr>
    <td style="width:50px;">
        <?php echo CHtml::textField('no_urut',$i+1,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modSimulasiAnggaran,'['.$i.']konfiganggaran_id'); ?>
        <?php echo CHtml::activeHiddenField($modSimulasiAnggaran,'['.$i.']unitkerja_id'); ?>
        <?php echo CHtml::activeHiddenField($modSimulasiAnggaran,'['.$i.']subkegiatanprogram_id'); ?>
        <?php echo CHtml::activeHiddenField($modSimulasiAnggaran,'['.$i.']tglsimulasianggaran'); ?>
        <?php echo CHtml::activeHiddenField($modSimulasiAnggaran,'['.$i.']nilai_anggaran'); ?>
        <?php echo CHtml::activeHiddenField($modSimulasiAnggaran,'['.$i.']nosimulasianggaran'); ?>
    </td>
    <td>
        <?php echo (!empty($modelDetail->subkegiatanprogram->subkegiatanprogram_kode) ? $modelDetail->subkegiatanprogram->subkegiatanprogram_kode.' - ' : "") ?>
        <?php echo (!empty($modelDetail->subkegiatanprogram->subkegiatanprogram_nama) ? $modelDetail->subkegiatanprogram->subkegiatanprogram_nama : "") ?>
    </td>
    <td style="width:150px;">
        <?php echo (!empty($modelDetail->nilairencpengeluaran) ? MyFormatter::formatUang($modelDetail->nilairencpengeluaran) : "") ?>
    </td>
    <td style="width:100px; text-align: right;">
        <?php echo CHtml::ActiveTextField($modSimulasiAnggaran,'['.$i.']kenaikan_persen',array('class'=>'span2 integer','style'=>'width:30px;','onkeyup'=>"return $(this).focusNextInputField(event);",'onblur'=>'hitungrupiah(this);')); ?>
    </td>
     <td style="width:100px;">
        <?php echo CHtml::ActiveTextField($modSimulasiAnggaran,'['.$i.']kenaikan_rupiah',array('class'=>'span2 integer','style'=>'width:100px;','onkeyup'=>"return $(this).focusNextInputField(event);",'onblur'=>'hitungpersen(this);')); ?>
    </td>
    <td style="width:100px;">
        <?php echo CHtml::ActiveTextField($modSimulasiAnggaran,'['.$i.']total_nilaianggaran',array('class'=>'span2 integer','style'=>'width:100px;','onkeyup'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
    </td>
</tr>
