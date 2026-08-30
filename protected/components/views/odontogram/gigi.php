<table id="gram_<?php echo $i ?>" style="height:<?php echo Params::TINGGI_GIGI_DRAW; ?>;color:#333;width:32px; margin:0; padding:0; background-image:url('<?php echo $this->getController()->createUrl('myOdontogram',array('code'=>$code,'a'=>$i)) ?>'); background-repeat: no-repeat;">        
	<tr>
		<td style="height:32px;"></td>
		<td style="height:32px;"></td>
		<td style="height:32px;"></td>
	</tr>
    <tr>
        <td style="width:10px;padding:0;"></td>
        <td style="height:9px;padding:0;" onclick="newOdontogram('gram_<?php echo $i ?>','t')" class="t"></td>
        <td style="width:10px;padding:0;"></td>
    </tr>
    <tr>
        <td style="width:10px;padding:0;" onclick="newOdontogram('gram_<?php echo $i ?>','l')" class="l"></td>
        <td style="width:20px;height:15px;padding:0;" onclick="newOdontogram('gram_<?php echo $i ?>','c')" class="c"></td>
        <td style="width:10px;padding:0;" onclick="newOdontogram('gram_<?php echo $i ?>','r')" class="r"></td>
    </tr>
    <tr>
        <td style="width:10px;padding:0;"></td>
        <td style="width:20px;height:9px;padding:0;" onclick="newOdontogram('gram_<?php echo $i ?>','b')" class="b"></td>
        <td style="width:10px;padding:0;"></td>
    </tr>    
    <tr>
        <td colspan="3" style="text-align:center;padding:0;">
            <span class="<?php echo $posisi ?>"><?php echo $i ?></span>
            <?php echo CHtml::hiddenField("codeOdon[$i]", $code, array('id'=>'odon'.$i,'class'=>'span1','readonly'=>true, 'nomor'=>$i)); ?>            
        </td>
    </tr>
</table>
