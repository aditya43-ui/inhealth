<table class="table table-striped table-bordered table-condensed" id="skrining-gizi">
    <thead>
        <tr>
            <th>Parameter</th>
            <th>Jawaban</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>

        <?php if(!empty($data['gizi'])):?>
        <?php foreach ($data['gizi'] as $key => $value) {

            
            ?>
            <tr>
                <td><?= $value['pertanyaan'] ?></td>
                <td>
                    <?php foreach ($value['det'] as $key2 => $value2) {?>
                        <?php echo CHtml::radioButton('SkriningmstT['.$key.'][nilai]', $value2['kondisi'],array('datavalue'=> $value2['nilai'], 'skrining' => $value2['id'], 'onClick' => 'hitungScore(this);'));?>&nbsp;<?php echo $value2['nama']?><br>
                        <?php } ?>
                </td>
                <td>
                    <?php echo CHtml::hiddenField('RJSkriningmstT['.$key.'][jawabanskrininggizimst_id]', '') ?>
                    <?php echo CHtml::hiddenField('RJSkriningmstT['.$key.'][skrininggizimst_id]', $key) ?>
                    <?php echo CHtml::textField('RJSkriningmstT['.$key.'][skriningmst_jawaban]', $value['nilai'] , array('readonly' => true, 'class' => 'span2', 'onKeyup' => 'hitungTotal();', 'class' => 'nilai span2')) ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="2"></td>
            <td>
                <?php echo $form->textField($model, 'total_skor', array('class' => 'span2', 'readonly' => true)); ?>
            </td>
        </tr>
        <?php endif;?>
    </tbody>
</table>
<span><i>Skor >= 2 pasien beresiko, konusltasikan ke Gizi</i></span>