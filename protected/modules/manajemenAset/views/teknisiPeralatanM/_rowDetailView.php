<?php
/**
* - digunakan untuk Admin Teknisi Peralatan
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<tr>
    <?php //print_r($modObatAlkesPasien);exit(); ?>
    <td>
        <?php echo CHtml::activehiddenField($modSertifikat, '[ii]sertifikatteknisi_id',array('readonly'=>true,'class'=>'span3')); ?>
        <?php echo CHtml::activeTextField($modSertifikat, '[ii]no_sertifikat_teknisi',array('readonly'=>true,'class'=>'span3')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modSertifikat, '[ii]nama_sertifikat',array('readonly'=>true,'class'=>'span3')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modSertifikat, '[ii]sertifikat_ket',array('readonly'=>true,'class'=>'span3')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modSertifikat, '[ii]berlaku_sd',array('readonly'=>true,'class'=>'span3')); ?>
    </td>
    <td>
        <?php
            if($modSertifikat->sertifikatteknisi_id!=NULL){
                echo Chtml::link($modSertifikat->file_sertifikat, ParamsUrl::urlSertifikatTeknisiDirectory().$modSertifikat->file_sertifikat);
            }else{
                echo CHtml::activeFileField($modSertifikat,'[ii]file_sertifikat'); 
            }
            ?>
    </td>
</tr> 
