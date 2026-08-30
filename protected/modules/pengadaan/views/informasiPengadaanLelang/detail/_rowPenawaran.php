<?php 
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
?>
<tr>
    <td> <?php echo $i+1; ?> </td>
    <td> <?php 
        echo CHtml::hiddenField("PenawaranpenyediaT[".$model->penawaranpenyedia_id."][penawaranpenyedia_id]",$model->penawaranpenyedia_id).
                CHtml::checkBox("PenawaranpenyediaT[".$model->penawaranpenyedia_id."][cekList]", false, array("class"=>"cekList", "onkeyup"=>"return $(this).focusNextInputField(event);",$model->penawaranpenyedia_id)); 
    ?> </td>
    <td> <?php echo $model->penawaranpenyedia_nomor; ?> </td>
    <td> <?php echo $model->penyedia->penyedia_nama; ?> </td>
    <td> <?php echo $model->penawaranpenyedia_harga; ?> </td>
    <td> <?php echo $model->penawaranpenyedia_file; ?> </td>
    <td> <?php echo $model->penawaranpenyedia_keterangan; ?> </td>
    <td>
        <?php echo CHtml::activeTextField($modRiwayat, '[0]penilaian_skor',array('class'=>'span2'));?>	
        <?php echo CHtml::activeHiddenField($model, '[0]penawaranpenyedia_id',array('class'=>'span2'));?>	
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($model,'[0]penilaian_hasil', LookupM::getItems("hasilseleksipenawaran"),
                    array('class' => 'span2 penilaian_hasil' ,'onkeypress'=>"return $(this).focusNextInputField(event)", 'empty'=>'-- Pilih --')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[0]penilaian_alasan',array('class'=>'span2'));?>	
    </td>
    <td>
        <?php 
         if ($modRiwayat->penilaian_hasil == "Diundang") {
             echo "<i class ='fa fa-envelope' style='color: black'> </i>";
         } else {
            echo "<i class ='fa fa-envelope' style='color: grey'> </i>"; 
         }?>
    </td>
</tr>
    
    