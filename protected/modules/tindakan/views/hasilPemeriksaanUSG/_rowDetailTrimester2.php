<tr>
    <td>
        <?php echo CHtml::hiddenField('janinke', '',array('class'=>'janinke')) ?>
        <span class="janinkeSpan"></span>
    </td>
    <td>
        <?php echo CHtml::dropDownList('presentasi_janin', '', LookupM::getItems('pemeriksaanusg_presentasijanin'), array('empty'=>'-Pilih-','class'=>'presentasi_janin span2')) ?>
    </td>
    <td>
        <div class="radio_mainbunyijantung" style="width:80px !important">
            <?php echo CHtml::radioButtonList('bunyijantung', '', array('Ada'=>'Ada','Tidak Ada'=>'Tidak Ada'), array('class'=>'bunyijantung')) ?>
        </div>
    </td>
    <td>
        <div class="radio_mainjeniskelamin" style="width:80px !important">
            <?php echo CHtml::radioButton('jeniskelamin', false, array('class'=>'jeniskelamin','value'=>'Laki-laki', 'uncheckValue'=>null)) ?> <label>Laki-laki</label><br/>
            <?php echo CHtml::radioButton('jeniskelamin', false, array('class'=>'jeniskelamin','value'=>'Perempuan', 'uncheckValue'=>null)) ?> <label>Perempuan</label>
            <?php echo CHtml::radioButton('jeniskelamin', false, array('class'=>'jeniskelamin','value'=>'Lainnya', 'uncheckValue'=>null)) ?> <label>Lainnya</label>
        </div>
        <?php echo CHtml::textField('jeniskelamin_lainnya', '',array('class'=>'jeniskelamin_lainnya span2','readonly'=>false)) ?>
    </td>
    <td>
        <?php echo CHtml::textField('biometri_ac', '',array('class'=>'biometri_ac span1 integer-decimal')) ?> cm
    </td>
    <td>
        <?php echo CHtml::textField('biometri_bpd', '',array('class'=>'biometri_bpd span1 integer-decimal')) ?> cm
    </td>
    <td>
        <?php echo CHtml::textField('biometri_fl', '',array('class'=>'biometri_fl span1 integer-decimal')) ?> cm
    </td>
    <td>
        <?php echo CHtml::textField('taksiranberatjanin', '',array('class'=>'taksiranberatjanin span1 integer-decimal')) ?>
    </td>
    <td>
        <div class="radio_mainjml_air_ketuban" style="width:80px !important">
            <?php echo CHtml::radioButtonList('jml_air_ketuban', '', array('< 5 cm'=>'< 5 cm','> 5 cm'=>'> 5 cm'), array('class'=>'jml_air_ketuban')) ?>
        </div>
    </td>
    <td>
        <div class="radio_maininsertio_plasenta" style="width:200px !important">
            <?php echo CHtml::radioButtonList('insertio_plasenta', '', array('Karpus'=>'Karpus','SBR (Segmen Bawah Rahim)'=>'SBR (Segmen Bawah Rahim)'), array('class'=>'insertio_plasenta')) ?>
        </div>
    </td>
    <td>
        <?php echo CHtml::textArea('talipusat', '',array('class'=>'talipusat span2')) ?>
    </td>
    <td>
        <?php echo CHtml::textArea('patologi', '',array('class'=>'patologi span2')) ?>
    </td>
    <td>
        <?php echo CHtml::textField('denyutjantungjanin', '',array('class'=>'denyutjantungjanin span1 integer2')) ?>
    </td>
    <td>
        <?php echo CHtml::textField('gravid', '',array('class'=>'gravid span2')) ?>
    </td>
    <td>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker',array(
                'id'=>'taksiranmelahirkan',
                'name'=>'taksiranmelahirkan',
                'mode'=>'date',
                'options'=> array(
                    'dateFormat'=>PARAMS::DATE_FORMAT,
                ),
                'htmlOptions'=>array('readonly'=>true,'class'=>'span2 taksiranmelahirkan', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                ),
        )); ?>
        </div>
    </td>
    <td>
        <?php echo CHtml::textArea('kondisijaninkeseluruhan', '',array('class'=>'kondisijaninkeseluruhan span2')) ?>
    </td>
</tr>