<tr data-row="<?php echo $i ?>">
    <td style="text-align: center;">
        <?php echo $modInsiden->kelompoksubtipeinsiden->kelompoksubtipeinsiden_nama;?>
    </td>
    <td style="text-align: center;">
        <table>
            <?php
                $modSubTipe = SubtipeinsidenM::model()->findAllByAttributes(array('kelompoksubtipeinsiden_id'=>$modInsiden->kelompoksubtipeinsiden_id,'subtipeinsiden_id'=>$modInsiden->subtipeinsiden_id));
                if(!empty($modSubTipe)){
                    foreach($modSubTipe as $subtipe){
                        $modInsiden->kelompoksubtipeinsiden_id = $subtipe->kelompoksubtipeinsiden_id;
                        $modInsiden->subtipeinsiden_id = $subtipe->subtipeinsiden_id;
            ?>
            <tr>
                <td>
                    
                    <?php echo CHtml::checkBox('', '['.$i.']pilih', array('checked'=>true,'disabled'=> true)); ?> <label><?php echo $subtipe->subtipeinsiden_nama;?></label>
                </td>
            </tr>
            <?php
                    }
                }
            ?>
        </table>
    </td>
</tr>