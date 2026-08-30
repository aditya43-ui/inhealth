<tr>
    <td>
       <?php echo CHtml::checkBox("detailpengajuan[".$detail->pegawai_id."][cekList]", false, array("class"=>"cekList", "onclick"=>"setNol(this);", "onkeyup"=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::hiddenField("detailpengajuan[".$detail->pegawai_id."][pegawai_id]",$detail->pegawai_id,array('class'=>'span2')) ?>
        <?php echo CHtml::hiddenField("detailpengajuan[".$detail->pegawai_id."][kategoripegawai]",$detail->kategoripegawai,array('class'=>'span2')) ?>
        <?php echo CHtml::hiddenField("detailpengajuan[".$detail->pegawai_id."][tglditerima]",$detail->tglditerima,array('class'=>'span2')) ?>
        <?php echo CHtml::hiddenField("detailpengajuan[".$detail->pegawai_id."][jenisgaji]",$jenisgaji,array('class'=>'span2')) ?>
        <?php echo CHtml::hiddenField("detailpengajuan[".$detail->pegawai_id."][gajipokok]",$detail->nilaigajipokok,array('class'=>'span2 integer2')) ?>
        <?php echo CHtml::hiddenField("detailpengajuan[".$detail->pegawai_id."][tunjangantetap]",$detail->nilaitetap,array('class'=>'span2 integer2')) ?>
    </td>
    <td>
        <?php echo $detail->nama_pegawai; ?>
    </td>
    <td><?php echo $detail->metode_pph_21; ?></td>
    <td><?php echo $detail->kategoripegawai; ?></td>
    <td><?php echo $detail->tglditerima; ?></td>
    <td><?php echo $jenisgaji; ?></td>
    <td><?php echo MyFormatter::formatNumberForPrint($detail->nilaigajipokok,2); ?></td>
    <td><?php echo MyFormatter::formatNumberForPrint($detail->nilaitetap,2); ?></td>
    <td>
        <?php echo CHtml::textField("detailpengajuan[".$detail->pegawai_id."][totalthr]",MyFormatter::formatNumberForPrint($detail->nilaithr,2),array('class'=>'span2 integer-decimal','onblur'=>'generateFormatNumber()')) ?>
    </td>
    <td>
        <?php echo CHtml::textField("detailpengajuan[".$detail->pegawai_id."][tunjangan_pph_21_thr]",0,array('class'=>'span2 integer-decimal','onblur'=>'generateFormatNumber()')) ?>
    </td>
    <td>
        <?php echo CHtml::textField("detailpengajuan[".$detail->pegawai_id."][totalpajak]",0,array('class'=>'span2 integer-decimal','onblur'=>'generateFormatNumber()')) ?>
    </td>
</tr>
