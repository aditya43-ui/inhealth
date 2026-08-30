<tr>
    <td>
        <?php echo CHtml::hiddenField('janinke', '',array('class'=>'janinke')) ?>
        <span class="janinkeSpan"></span>
    </td>
    <td>
        <div class="radio_mainkantong" style="width:80px !important">
            <?php echo CHtml::radioButtonList('kantongkehamilan', '', array('Ada'=>'Ada','Tidak Ada'=>'Tidak Ada'), array('class'=>'kantongkehamilan')) ?>
        </div>
    </td>
    <td>
        <div class="radio_mainfetalecho" style="width:80px !important">
            <?php echo CHtml::radioButtonList('fetalecho', '', array('Ada'=>'Ada','Tidak Ada'=>'Tidak Ada'), array('class'=>'fetalecho')) ?>
        </div>
    </td>
    <td>
        <div class="radio_mainletakkantong" style="width:80px !important">
            <?php echo CHtml::radioButtonList('letakkehamilan', '', array('Intra Uteri'=>'Intra Uteri','Ektra Uteri'=>'Ektra Uteri'), array('class'=>'letakkehamilan')) ?>
        </div>
    </td>
    <td>
        <div class="radio_mainpulsasi" style="width:80px !important">
            <?php echo CHtml::radioButtonList('pulsasi', '', array('Ada'=>'Ada','Tidak Ada'=>'Tidak Ada'), array('class'=>'pulsasi')) ?>
        </div>
    </td>
    <td>
        <?php echo CHtml::textField('biometri_gs', '',array('class'=>'biometri_gs span1 integer-decimal')) ?> cm
    </td>
    <td>
        <?php echo CHtml::textField('biometri_crl', '',array('class'=>'biometri_crl span1 integer-decimal')) ?> cm
    </td>
    <td>
        <?php echo CHtml::textField('biometri_bpd', '',array('class'=>'biometri_bpd span1 integer-decimal')) ?> cm
    </td>
    <td>
        <?php echo CHtml::textField('biometri_fl', '',array('class'=>'biometri_fl span1 integer-decimal')) ?> cm
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