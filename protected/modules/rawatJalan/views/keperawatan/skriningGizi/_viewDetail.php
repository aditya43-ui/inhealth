<table class="table table-striped table-bordered table-condensed" id="skrining-gizi">
    <thead>
        <tr>
            <th>Parameter</th>
            <th>Jawaban</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['gizi'] as $key => $value) {
            
            ?>
            <tr>
                <td width="40%"><?= $value['pertanyaan'] ?></td>
                <td>
                    <?php foreach ($value['det'] as $key2 => $value2) {?>
                        <?php echo CHtml::radioButton('SkriningmstT['.$key.'][nilai]', $value2['kondisi'],array('datavalue'=> $value2['nilai'], 'disabled' => true));?>&nbsp;<?php echo $value2['nama']?><br>
                        <?php } ?>
                </td>
                <td>
                    <?= $value['nilai']; ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="2"></td>
            <td><?= $model->total_skor; ?></td>
        </tr>
    </tbody>
</table>