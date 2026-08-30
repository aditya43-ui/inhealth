<?php
    /**
* - digunakan sebagai url utuk :
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>

<?php
    $i=1;
    foreach($modDetail as $detail){
        $linen = LinenM::model()->findByPk($detail->linen_id);
        if (!empty($linen)){
        ?>
<tr>
    <td style="width:30px;"><?php echo $i++; ?></td>
    <td style="width:30px;"><?php
        echo CHtml::hiddenField("LAPengperawatanlinendetT[".$detail->pengperawatanlinendet_id."][linen_id]",$detail->linen_id);
        echo $linen->noregisterlinen;
    ?></td>
    <td style="width:30px;"><?php
        echo $linen->namalinen;
    ?></td>
    <td style="width:30px;">
        <?php 
            echo CHtml::dropDownList("LAPengperawatanlinendetT[".$detail->pengperawatanlinendet_id."][jenisperawatan]", $detail->jenisperawatan, LookupM::getItems('jenisperawatan'), array("class"=>"span2", "onkeyup"=>"return $(this).focusNextInputField(event);"));
            //echo $detail->jenisperawatan; 
            ?>

    </td>
    <td style="width:30px;"><?php 
        //echo $detail->jumlah; 
        echo CHtml::textField("LAPengperawatanlinendetT[".$detail->pengperawatanlinendet_id."][jumlah]",$detail->jumlah,array('class' => 'numbers-only')); 
        ?></td>
    <td style="width:30px;"><?php 
        //echo $detail->keterangan_pengperawatan; 
        echo CHtml::textField("LAPengperawatanlinendetT[".$detail->pengperawatanlinendet_id."][keterangan_pengperawatan]",$detail->keterangan_pengperawatan);
     ?></td>
</tr>
    <?php } }
?>
	