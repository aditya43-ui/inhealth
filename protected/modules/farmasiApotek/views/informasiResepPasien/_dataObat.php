<?php if(!empty($kerangkaLooping)) {
foreach($kerangkaLooping as $i => $detail){ 
    
    ?>
    <?php
        $criteriitem=new CDbCriteria;
        $criteriitem->addCondition("reseptur_id = ". $detail->reseptur_id);
        $criteriitem->addCondition("racikan_id = ". $detail->racikan_id);
        if($detail->rke == null){

        }else{
            $criteriitem->addCondition("rke = ". $detail->rke);
        }
        $items = ResepturdetailT::model()->findAll($criteriitem);
        
        $R = $detail->rke;
        
    ?>
    <?php foreach($items as $ii => $item){ 
        
        ?>
        <?php if($item->racikan_id == Params::RACIKAN_ID_NONRACIKAN){ ?>
            <table width="50%">
                <tbody>
                    <tr>
                        <td width="50">R /<?php // echo $detail->rke; ?></td>
                        <td style="border-left: 0; border-right: 0;"><?php echo $item->obatalkes->obatalkes_nama; ?></td>
                        <td width="50">Jumlah </td>
                        <td width="50"><?php echo $item->qty_reseptur; ?></td>
                        /* <td width="50"><?php //echo CustomFunction::Romawi(ceil($item->qty_reseptur)); ?></td> */
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3"><?php echo empty($item->signa_reseptur) ? "" : ("∫ ".$item->signa_reseptur); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php }else{ ?>
            <table width="50%">
                <tbody>
                    <tr>
                        <td width="50"><?php if ($R != "") echo "R /"; ?></td>
                        <td style="border-left: 0; border-right: 0;"><?php echo $item->obatalkes->obatalkes_nama; ?></td>
                        <td width="50" style="text-align: right; padding-right: 2px;"><?php echo $item->permintaan_reseptur; ?></td>
                        <td width="20"><?php echo $item->satuankekuatan; ?></td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>
    <?php 
    
        
    $R = "";
    
    } ?>
    <?php if($item->racikan_id == Params::RACIKAN_ID_RACIKAN){ ?>
        <table width="50%">
            <tbody>
                <tr>
                    <td width="50">&nbsp;</td>
                    <td style="font-weight: bold;"><?php echo "m.f.l.a. ".$item->satuansediaan." No ".CustomFunction::Romawi(ceil($item->jmlkemasan_reseptur)); ?></td>
                </tr>
                <tr>
                    <td width="50">&nbsp;</td>
                    <td style="font-weight: bold;"><?php echo empty($item->signa_reseptur) ? "" : ("∫ ".$item->signa_reseptur); ?></td>
                </tr>
            </tbody>
        </table>
    <?php }  
    
    ?>

    
<fieldset class='iter'>
    <legend>Iter <?php echo $detail->iter; ?></legend>
</fieldset>
<br>
<?php }}else{ ?>
    <td width="50"> -<?php // echo $detail->rke; ?></td>
<?php }?>