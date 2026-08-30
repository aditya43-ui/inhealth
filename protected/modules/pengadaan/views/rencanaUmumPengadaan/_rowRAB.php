<tr data-row="0">
    <td>
        <span class="no_urut"><?php echo $i++; ?></span>
    </td>
    <td>                
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail][0]rencanaumumpengadaandet_nama', array('readonly'=>true,'class' => 'required'));                              	
        ?>            
    </td>
    <td>
        <?php
            echo CHtml::activeTextField($modRAB, '[detail][0]rencanaumumpengadaandet_satuan', array('readonly'=>true,'class' => 'span1 required'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail][0]rencanaumumpengadaandet_volume', array('readonly'=>true,'class' => 'span2 required integer-decimal volume ubah', 'onblur' =>'hitung();'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail][0]harga', array('readonly'=>true,'class' => 'required integer-decimal estimasi ubah', 'onblur' =>'hitung();'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail][0]rencanaumumpengadaandet_pajak', array('readonly'=>true,'class' => 'span2 required float2 persenpajak ubah', 'onblur' =>'hitung();', 'maxlength' => 6));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail][0]jumlah', array('readonly' => true,'class' => 'required integer-decimal harga'));
        ?>
    </td>
    
</tr>