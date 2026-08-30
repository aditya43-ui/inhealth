<tr <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer no_urut', 'style'=>'width:30px;')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <span name="[ii][pemeriksaanlab_nama]"><?php echo (!empty($modTindakan->daftartindakan_id) ? $modTindakan->getPemeriksaanLab()->pemeriksaanlab_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]tindakansudahbayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]pemeriksaanlab_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]qty_tindakan',array('readonly'=>false,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]satuantindakan',array('readonly'=>true,'class'=>'span2')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?> <?php  // echo (Yii::app()->session['modul_id']== Params::MODUL_ID_PENDAFTARAN)?"":Params::HIDDEN_HARGA; /* RSIA-17 */ ?>>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]tarif_satuan',array('readonly'=>true,'class'=>'span2 integer-decimal','style'=>'text-align:right;')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?> <?php // echo(Yii::app()->session['modul_id']== Params::MODUL_ID_PENDAFTARAN)?"":Params::HIDDEN_HARGA; /* RSIA-17 */ ?>>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:96px')); ?>
    </td>
    <!-- <td <?php //if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php //} ?> <?php //echo(Yii::app()->session['modul_id']== Params::MODUL_ID_PENDAFTARAN)?"":Params::HIDDEN_HARGA; /* RSIA-17 */ ?>>
        <?php 
        // if($modTindakan->cyto_tindakan = true){
        //     echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]tarifcyto_tindakan',array('readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:96px'));
        // }else{
        //     echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]tarif_tindakan',array('readonly'=>true,'class'=>'span2 integer-decimal'));
        // }
        ?>
    </td> -->
</tr>
