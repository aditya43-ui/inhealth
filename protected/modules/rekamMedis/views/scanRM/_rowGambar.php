<tr>
    <td>
        <input type="hidden" class="file_gambar">
        <input type="hidden" class="file_gambar_nama">
        <div class="hide">
            <input type="file" name="file" class="file_multi" onchange='cekFile(this)'>
        </div>
        <p><b>Nama Dokumen</b></p>
        <span class="span_filegambar">&nbsp;</span>
    </td>
    <td>
        <?php CHtml::dropDownList(
            'instalasi_ids',
            '',
            CHtml::listData(InstalasipelayananV::model()->findAll(), 'instalasi_id', 'instalasi_nama'),
            array('class' => 'form-control instalasi_ids', 'multiple' => 'multiple')
        ); ?>
    </td>
    <td>
        <?php echo CHtml::textField('dokfilerm_nama','',array('class'=>'dokfilerm_nama span3','required'=>true)); ?>
        <span class="required">*  Maks File 5Mb</span>
    </td>
    <td style="text-align: center;">
        <a onclick="batalGambar(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan upload"><i class="icon-remove"></i></a>
    </td>
</tr>