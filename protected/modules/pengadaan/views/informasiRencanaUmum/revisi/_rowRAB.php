<?php
    if (!isset($i)){
        $i = 0;
    }
?>
<tr data-row="0">
    <td>
        <label class="no_urut"> <?php echo $i+1; ?></label>
    </td>
    <td>                
        <?php 
            echo CHtml::activeHiddenField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_id', array('readonly'=>true,'class' => 'rencanaumumpengadaandet_id'));                              	
            echo CHtml::activeHiddenField($modRAB, '[detail]['.$i.']barang_id', array('readonly'=>true,'class' => 'barang_id'));
            echo CHtml::activeHiddenField($modRAB, '[detail]['.$i.']jenis_barang', array('readonly'=>true,'class' => 'jenis_barang'));
            echo CHtml::activeHiddenField($modRAB, '[detail]['.$i.']dokumenpelaksanaananggarandet_id', array('readonly'=>true,'class' => 'dokumenpelaksanaananggarandet_id required'));            
            echo CHtml::activeTextArea($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_nama', array('readonly'=>true,'class' => 'required'));       
        ?>            
    </td>
    <td>
        <?php
            echo CHtml::activeTextField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_satuan', array('readonly'=>true,'class' => 'span1 rencanaumumpengadaandet_satuan required'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_volume', array('readonly'=>false,'class' => 'span2 required integer-decimal volume ubah rencanaumumpengadaandet_volume', 'onblur' =>'hitungHargaBaris(this);'));
            echo CHtml::activeHiddenField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_volumeawal', array('readonly'=>false,'class' => 'span2 integer-decimal volumeawal'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_harga', array('readonly'=>false,'class' => 'span2 required integer-decimal estimasi ubah rencanaumumpengadaandet_harga', 'onblur' =>'hitungHargaBaris(this);'));
            echo CHtml::activeHiddenField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_estimasiawal', array('readonly'=>false,'class' => 'span2 integer-decimal estimasiawal'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_pajak', array('readonly'=>false,'class' => 'span2 required float2 persenpajak ubah rencanaumumpengadaandet_pajak', 'onblur' =>'hitungHargaBaris(this);', 'maxlength' => 6));
            echo CHtml::activeHiddenField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_persenpajakawal', array('readonly'=>false,'class' => 'span2 float2 persenpajakawal'));
            echo CHtml::activeHiddenField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_jmlpajak', array('readonly'=>false,'class' => 'span2 required float2 pajak rencanaumumpengadaandet_jmlpajak',));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_jumlah', array('onblur' => 'hitungJumlahBaris(this)', 'readonly' => false,'class' => 'span3 rencanaumumpengadaandet_jumlah required integer-decimal harga'));
            echo CHtml::activeHiddenField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_totalawal', array('readonly'=>false,'class' => 'span2 integer-decimal totalawal'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail]['.$i.']serapan', array('readonly' => true, 'class' => 'span3 integer-decimal serapan'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail]['.$i.']sisapagu_pengadaan', array('readonly' => true, 'class' => 'span3 integer-decimal sisapagu_pengadaan'));
            echo CHtml::activeHiddenField($modRAB, '[detail]['.$i.']status', array('readonly' => true, 'class' => 'status', 'value' => 0));
        ?>
    </td>
    <td>
        <?php 
        if ($modRAB->serapan == 0) {
            echo CHtml::link('<i class="glyphicon glyphicon-minus"></i>', 'javascript:;', array('class'=>'btnhapus','onclick'=>'hapusRAB(this)'));
        }
        ?>
        <?php echo CHtml::link('<i class="glyphicon glyphicon-plus"></i>', 'javascript:;', array('class'=>'btntambah','onclick'=>'tambahRAB(this)')); ?>
    </td>
    
</tr>