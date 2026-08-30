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
            echo CHtml::activeTextField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_nama', array('readonly'=>true,'class' => 'required'));       
            /*
            $this->widget('MyJuiAutoComplete', array(    
                'model'=>$modRAB,
                'attribute' => '[detail]['.$i.']rencanaumumpengadaandet_nama',            
                'sourceUrl' => Yii::app()->createUrl('autoCompleteBarangJasa'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                    'select' => 'js:function( event, ui ) {
                                setBarangJasa(ui.item, this);
                                return false;
                                  }',
                ),
                 'htmlOptions'=>array(
                     'readonly'=>false,
                     'placeholder'=>'Barang dan Jasa',
                     'size'=>20,
                     'class'=>'required rencanaumumpengadaandet_nama',
                     'onblur' => 'if(this.value === ""){ $(this).parents("tr").find(".barang_id").val(""); }',
                     'onkeypress'=>"return $(this).focusNextInputField(event);",
                 ),
                 'tombolDialog'=>array('idDialog'=>'dialogBarangJasa','jsFunction'=>'setRow(this);refreshBarangJasa();$("#dialogBarangJasa").dialog("open")'),
            ));
             */
        ?>            
    </td>
    <td>
        <?php
            echo CHtml::activeTextField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_satuan', array('readonly'=>true,'class' => 'span2 rencanaumumpengadaandet_satuan required'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_volume', array('readonly'=>false,'class' => 'span2 required integer-decimal volume ubah rencanaumumpengadaandet_volume', 'onblur' =>'hitungHargaBaris(this);'));
            echo CHtml::activeHiddenField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_volumeawal', array('readonly'=>false,'class' => 'span2  volumeawal'));
            echo CHtml::activeHiddenField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_estimasiawal', array('readonly'=>false,'class' => 'span2 estimasiawal'));
            echo CHtml::activeHiddenField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_persenpajakawal', array('readonly'=>false,'class' => 'span2 persenpajakawal'));
            echo CHtml::activeHiddenField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_totalawal', array('readonly'=>false,'class' => 'span2  totalawal'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_harga', array('readonly'=>false,'class' => 'span2 required integer-decimal estimasi ubah rencanaumumpengadaandet_harga', 'onblur' =>'hitungHargaBaris(this);'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_pajak', array('readonly'=>false,'class' => 'span2 required integer-decimal persenpajak ubah rencanaumumpengadaandet_pajak', 'onblur' =>'hitungHargaBaris(this);', 'maxlength' => 6));
            echo CHtml::activeHiddenField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_jmlpajak', array('readonly'=>false,'class' => 'span2 required integer-decimal pajak rencanaumumpengadaandet_jmlpajak'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail]['.$i.']rencanaumumpengadaandet_jumlah', array('onblur' => 'hitungJumlahBaris(this)', 'readonly' => false,'class' => 'rencanaumumpengadaandet_jumlah required integer-decimal harga'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modRAB, '[detail]['.$i.']sisapagu_pengadaan', array('readonly' => true, 'class' => 'integer-decimal sisapagu_pengadaan'));
        ?>
    </td>
    <td>
        <?php echo CHtml::link('<i class="glyphicon glyphicon-minus"></i>', 'javascript:;', array('class'=>'btnhapus hide','onclick'=>'hapusRAB(this)')); ?>
        <?php echo CHtml::link('<i class="glyphicon glyphicon-plus"></i>', 'javascript:;', array('class'=>'btntambah','onclick'=>'tambahRAB(this)')); ?>
    </td>
    
</tr>