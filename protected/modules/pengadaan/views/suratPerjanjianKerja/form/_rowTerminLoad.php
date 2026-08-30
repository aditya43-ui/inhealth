<tr style="height:40px;">
    <td style="margin-bottom:20px;text-align:center; min-width: 75px;"> <label> Termin <?php echo $modTermin['terminke']; ?> </label></td>
    
    <td style="text-align:center; min-width: 100px;"> 
        <?php echo CHtml::activeTextField($modTermin, '[' . $i . ']jumlah_persen', array('class' => 'span1', 'readonly' => true)) ?>
    </td>
    <td style="text-align:center; min-width: 200px;"> 
        <?php echo CHtml::activeTextField($modTermin, '[' . $i . ']jumlah_harga', array('class' => 'span2 integer-decimal', 'readonly' => true)) ?>
        <?php echo CHtml::activeHiddenField($modTermin, '[' . $i . ']urutan', array('class' => 'span3', 'readonly' => true)) ?>
        <?php echo CHtml::activeHiddenField($modTermin, '[' . $i . ']terminke', array('class' => 'span3', 'readonly' => true)) ?>
    </td>
    <td style="text-align:right; min-width: 200px;">
        <div class="control-group">
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modTermin,
                    'attribute' => '[' . $i . ']termintanggal_awal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'changeYear' => true,
                    ),
                    'htmlOptions' => array('class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true),
                ));
                ?>
            </div>
        </div>
    </td>
    <td style="text-align:right; min-width: 200px;">
        <div class="control-group">
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modTermin,
                    'attribute' => '[' . $i . ']termintanggal_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'changeYear' => true,
                    ),
                    'htmlOptions' => array('class' => 'span2 akhir', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true),
                ));
                ?>
            </div>
        </div>
    </td>
</tr>