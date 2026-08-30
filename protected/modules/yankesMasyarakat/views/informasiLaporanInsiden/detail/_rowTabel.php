<?php
    $i=0;
    foreach($modKelompok as $kelompok){
?>
<tr>
        <td style="text-align: center;">
            <?php echo $kelompok->kelompoksubtipeinsiden_nama;?>
	</td>
	<td style="text-align: center;">
            <table>
                <?php
                    $modSubTipe = SubtipeinsidenM::model()->findAllByAttributes(array('kelompoksubtipeinsiden_id'=>$kelompok->kelompoksubtipeinsiden_id));
                    if(!empty($modSubTipe)){
                        foreach($modSubTipe as $subtipe){
                            $model->kelompoksubtipeinsiden_id = $subtipe->kelompoksubtipeinsiden_id;
                            $model->subtipeinsiden_id = $subtipe->subtipeinsiden_id;
                ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($model, '['.$i.']kelompoksubtipeinsiden_id', array('class' => '')); ?>
                        <?php echo CHtml::activeHiddenField($model, '['.$i.']subtipeinsiden_id', array('class' => '')); ?>
                        <?php echo CHtml::activeCheckBox($model, '['.$i.']pilih', array()); ?> <label><?php echo $subtipe->subtipeinsiden_nama;?></label>
                    </td>
                </tr>
                <?php
                        }
                    }
                ?>
            </table>
	</td>
</tr>
<?php
    $i++;
    }
?>