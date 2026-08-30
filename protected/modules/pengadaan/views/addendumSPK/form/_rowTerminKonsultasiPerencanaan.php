<tr style="height:40px;">
    <td style="text-align:center; min-width: 75px;">  <label> Termin I </label></td>
    <td style="text-align:center; min-width: 100px;"> 
        <?php echo CHtml::activeTextField($modTermin, '[0]jumlah_persen',array('onblur' => 'hitungTerminPerencanaan();', 'value' => 80, 'class'=>'span1 integer-decimal jumlah_persen')) ?>
    </td>
    <td style="text-align:center; min-width: 200px;"> 
        <?php echo CHtml::activeTextField($modTermin, '[0]jumlah_harga',array('class'=>'span3 integer-decimal jumlah_harga_perencanaan', 'readonly' => true)) ?>
        <?php echo CHtml::activeHiddenField($modTermin, '[0]urutan',array('value' => 1, 'class'=>'span3', 'readonly' => true)) ?>
        <?php echo CHtml::activeHiddenField($modTermin, '[0]terminke',array('value' => 'I', 'class'=>'span3', 'readonly' => true)) ?>
    </td>
    <td style="text-align:right; min-width: 200px;">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $modTermin,
            'attribute' => '[0]termintanggal_awal',
            'mode' => 'date',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'changeYear' => true,
            ),
            'htmlOptions' => array('class' => 'span2 tanggal_awal', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true),
        ));
        ?>
    </td>
    <td style="text-align:right; min-width: 200px;">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $modTermin,
            'attribute' => '[0]termintanggal_akhir',
            'mode' => 'date',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'changeYear' => true,
            ),
            'htmlOptions' => array('class' => 'span2 akhir tanggal_akhir', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true),
        ));
        ?>
    </td>
</tr>    
<tr style="height:40px;">
    <td style="text-align:center; min-width: 75px;">  <label> Termin II </label></td>
    <td style="text-align:center; min-width: 100px;"> 
        <?php echo CHtml::activeTextField($modTermin, '[1]jumlah_persen',array('onblur' => 'hitungTerminPerencanaan();', 'value' => 5, 'class'=>'span1 integer-decimal jumlah_persen', 'readonly' => false)) ?>
    </td>
    <td style="text-align:center; min-width: 200px;"> 
        <?php echo CHtml::activeTextField($modTermin, '[1]jumlah_harga',array('class'=>'span3 integer-decimal jumlah_harga_perencanaan', 'readonly' => true)) ?>
        <?php echo CHtml::activeHiddenField($modTermin, '[1]urutan',array('value' => 2, 'class'=>'span3', 'readonly' => true)) ?>
        <?php echo CHtml::activeHiddenField($modTermin, '[1]terminke',array('value' => 'II', 'class'=>'span3', 'readonly' => true)) ?>
    </td>
    <td style="text-align:right; min-width: 200px;">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $modTermin,
            'attribute' => '[1]termintanggal_awal',
            'mode' => 'date',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'changeYear' => true,
            ),
            'htmlOptions' => array('class' => 'span2 tanggal_awal', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true),
        ));
        ?>
    </td>
    <td style="text-align:right; min-width: 200px;">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $modTermin,
            'attribute' => '[1]termintanggal_akhir',
            'mode' => 'date',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'changeYear' => true,
            ),
            'htmlOptions' => array('class' => 'span2 akhir tanggal_akhir', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true),
        ));
        ?>
    </td>
</tr>    
<tr>
    <td style="text-align:center; min-width: 75px;">  <label> Termin III </label></td>
    <td style="text-align:center; min-width: 100px;"> 
        <?php echo CHtml::activeTextField($modTermin, '[2]jumlah_persen',array('onblur' => 'hitungTerminPerencanaan();', 'value' => 15, 'class'=>'span1 integer-decimal jumlah_persen', 'readonly' => false)) ?>
    </td>
    <td style="text-align:center; min-width: 200px;"> 
        <?php echo CHtml::activeTextField($modTermin, '[2]jumlah_harga',array('class'=>'span3 integer-decimal jumlah_harga_perencanaan', 'readonly' => true)) ?>
        <?php echo CHtml::activeHiddenField($modTermin, '[2]urutan',array('value' => 3, 'class'=>'span3', 'readonly' => true)) ?>
        <?php echo CHtml::activeHiddenField($modTermin, '[2]terminke',array('value' => 'III', 'class'=>'span3', 'readonly' => true)) ?>
    </td>
    <td style="text-align:right; min-width: 200px;">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $modTermin,
            'attribute' => '[2]termintanggal_awal',
            'mode' => 'date',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'changeYear' => true,
            ),
            'htmlOptions' => array('class' => 'span2 tanggal_awal', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true),
        ));
        ?>
    </td>
    <td style="text-align:right; min-width: 200px;">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $modTermin,
            'attribute' => '[2]termintanggal_akhir',
            'mode' => 'date',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'changeYear' => true,
            ),
            'htmlOptions' => array('class' => 'span2 akhir tanggal_akhir', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true),
        ));
        ?>
    </td>
</tr>    