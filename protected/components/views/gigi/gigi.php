<table id="gram_<?php echo $i ?>" style="width:32px; margin:0; padding:0; background-image:url('<?php echo $this->getController()->createUrl('myOdontogram',array('code'=>$code)) ?>'); background-repeat: no-repeat;">
    <tr>
        <td style="width:10px;padding:0;"></td>
        <td style="height:9px;padding:0;" onclick="newOdontogram('gram_<?php echo $i ?>','t')"></td>
        <td style="width:10px;padding:0;"></td>
    </tr>
    <tr>
        <td style="width:10px;padding:0;" onclick="newOdontogram('gram_<?php echo $i ?>','l')"></td>
        <td style="width:20px;height:15px;padding:0;" onclick="newOdontogram('gram_<?php echo $i ?>','c')"></td>
        <td style="width:10px;padding:0;" onclick="newOdontogram('gram_<?php echo $i ?>','r')"></td>
    </tr>
    <tr>
        <td style="width:10px;padding:0;"></td>
        <td style="width:20px;height:9px;padding:0;" onclick="newOdontogram('gram_<?php echo $i ?>','b')"></td>
        <td style="width:10px;padding:0;"></td>
    </tr>
    <tr>
        <td colspan="3" style="text-align:center;padding:0;">
            <?php echo $i ?>
            <?php echo CHtml::hiddenField("codeOdon[$i]", $code, array('id'=>'odon'.$i,'class'=>'span1','readonly'=>true)); ?>
        </td>
    </tr>
</table>

