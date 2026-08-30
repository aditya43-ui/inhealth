<tr>   
    <td><?php 
        echo CHtml::hiddenField('no_urut', '', array('class'=>'')); 
        echo CHtml::activeHiddenField($modDetail, '[ii]bahanmakanan_id', array('class'=>'bahanmakanan')); 
        echo CHtml::activeHiddenField($modDetail, '[ii]satuanbahan', array()); 
//        echo CHtml::activeHiddenField($modDetail, '[ii]ppn', array('class'=>'ppn')); 
//        echo CHtml::activeHiddenField($modDetail, '[ii]disc', array('class'=>'disc')); 
//        echo CHtml::activeHiddenField($modDetail, '[ii]hpp', array('class'=>'hpp'));
        echo $modBahanmkn->golbahanmakanan->golbahanmakanan_nama;
        ?>
    </td>
    <td><?php echo $modBahanmkn->jenisbahanmakanan; ?></td>
    <td><?php echo $modBahanmkn->kelbahanmakanan; ?></td>
        <td><?php echo $modBahanmkn->namabahanmakanan; ?></td>    
    <td><?php echo $format->formatDateTimeForUser($modBahanmkn->tglkadaluarsabahan); ?></td>
    <td><?php echo (Params::cekHiddenHargaGizi()==true)?CHtml::activeTextField($modDetail, '[ii]harganetto', array('class'=>'span2 float beli', 'readonly'=>true)):CHtml::activePasswordField($modDetail, '[ii]harganetto', array('class'=>'span2 float beli', 'readonly'=>true)); ?></td>
    <!--<td><?php // echo number_format($modBahanmkn->harganettobahan,0,"","."); ?></td>-->
    <!--<td><?php // echo CHtml::activeTextField($modDetail, '[ii]harganetto', array('class'=>'span2 float beli',)); ?> </td>-->
<!--//    <td><?php // echo (Params::cekHiddenHargaGudangUmum()==true || Params::cekHiddenHargaGudangFarmasi()==true)?CHtml::activeTextField($modDetail, '[ii]hargajual', array('class'=>'span2 integer2 satuan', )):CHtml::activePasswordField($modDetail, '[ii]hargajual', array('class'=>'span2 integer2 satuan', )); ?></td>-->
    <td><?php echo CHtml::activeTextField($modDetail, '[ii]jmlpemakaianbhnmkn', array('class'=>'span1 float qty', )); ?></td>
    <!--<td><?php //echo CHtml::activeDropDownList($modDetail, '[ii]satuanpakai', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>-->    
    <td><?php echo Chtml::link('<icon class="icon-form-silang"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        