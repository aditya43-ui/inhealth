<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Metode Apgar
        </div>
    </div>
    <div class="panel-body">
        <div style="float:left;" class="control-group">
            <?php echo CHtml::activeLabel($model, '[' . $i . ']menitke'); ?>
            <?php echo CHtml::activeTextField($model, '[' . $i . ']menitke', array('class' => 'span1 numbersOnly required apgar_menit', 'maxlength' => 3,  'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
        <div id='menitkealert' class="additional-text"></div>
        <table width='100%' class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kriteria</th>
                    <th>Nilai 2</th>
                    <th>Nilai 1</th>
                    <th>Nilai 0</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i2 = $i;
                $i = 0; ?>
                <?php foreach ($appgards as $appgard) { ?>
                    <tr>
                        <td><?php echo $appgard->metodeapgar_id; ?></td>
                        <td><?php echo $appgard->kriteria; ?></td>
                        <td><?php echo CHtml::radioButton("KelahiranbayiT[" . $i2 . "][metodeApgar][$appgard->metodeapgar_id]", false, array('value' => '2' . $appgard->nilai_2, 'style' => 'margin-right:5px;', 'class' => 'apgar',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?><?php echo $appgard->nilai_2; ?></td>
                        <td><?php echo CHtml::radioButton("KelahiranbayiT[" . $i2 . "][metodeApgar][$appgard->metodeapgar_id]", false, array('value' => '1' . $appgard->nilai_1, 'style' => 'margin-right:5px;', 'class' => 'apgar',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?><?php echo $appgard->nilai_1; ?></td>
                        <td><?php echo CHtml::radioButton("KelahiranbayiT[" . $i2 . "][metodeApgar][$appgard->metodeapgar_id]", false, array('value' => '0' . $appgard->nilai_0, 'style' => 'margin-right:5px;', 'class' => 'apgar',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?><?php echo $appgard->nilai_0; ?></td>
                        <?php $i++; ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php $urlCekMenitKe = $this->createUrl('getMenitKe'); ?>
    </div>
</div>