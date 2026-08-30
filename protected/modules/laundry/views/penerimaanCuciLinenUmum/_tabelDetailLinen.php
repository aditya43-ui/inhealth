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
        
        $linen = LinenM::model()->findByPk($det->linen_id);
        
        if (!empty($linen)){
        ?>
<tr>
    <td style="width:30px;"><?php echo $i++; ?></td>
    <td style="width:30px;"><?php
        echo $linen->noregisterlinen;
    ?></td>
    <td style="width:30px;"><?php
        echo $linen->namalinen;
    ?></td>
    <td style="width:30px;">
        <?php 
            echo $det->jenisperawatanlinen; 
            ?>

    </td>
    <td style="width:30px;"><?php 
        echo $det->jumlah; 
        ?></td>
    <td style="width:30px;"><?php 
        echo $det->keterangan_penerimaanlinen; 
        ?></td>
</tr>
    <?php }
?>
	