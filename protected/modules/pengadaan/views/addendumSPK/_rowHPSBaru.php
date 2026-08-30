<tr data-row="0">
    <td>
        <span class="no_urut"><?php echo $i+1 ?></span>
    </td>
    <td>                
        <?php 
            echo CHtml::activeHiddenField($model, '[detail][ii]nama_dpa', array('class' => 'span2','readonly'=>true));
            echo CHtml::activeHiddenField($model,'[detail][ii]barang_id',array('readonly' => true, 'class' => 'barang_id'));                               	
            echo CHtml::activeHiddenField($model,'[detail][ii]jenis_barang',array('readonly' => true, 'class' => 'jenis_barang'));                               	
            echo CHtml::activeHiddenField($model,'[detail][ii]dokumenpelaksanaananggarandet_id',array('readonly' => true, 'class' => 'dokumenpelaksanaananggarandet_id'));                               	            
            echo CHtml::activeHiddenField($model,'[detail][ii]obatalkes_id',array('readonly' => true, 'class' => 'obatalkes_id'));
            
            $this->widget('MyJuiAutoComplete', array(    
            'model'=>$model,
            'attribute' => '[detail][ii]nama_dpa',            
            'sourceUrl' => $this->createUrl('autoCompleteBarangJasa'),
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
                 'class'=>'span2 required nama_dpa',
                 'onblur' => 'if(this.value === ""){ $(this).parents("tr").find(".barang_id").val(""); }',
                 'onkeypress'=>"return $(this).focusNextInputField(event);",
             ),
             'tombolDialog'=>array('idDialog'=>'dialogBarangJasa','jsFunction'=>'cekListBarang(); setRow(this);refreshBarangJasa();$("#dialogBarangJasa").dialog("open")'),
        ));
            
        ?>            
    </td>
    <td class="rowbarang">
        <?php
            $this->widget('MyJuiAutoComplete', array(    
            'model'=>$model,
            'attribute' => '[detail][ii]barang_nama',            
            'sourceUrl' => $this->createUrl('autoCompleteBarangJasa'),
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
                 'class'=>'required barang_nama',
                 'onblur' => 'if(this.value === ""){ $(this).parents("tr").find(".barang_id").val(""); }',
                 'onkeypress'=>"return $(this).focusNextInputField(event);",
             ),
            'tombolDialog' => array('idDialog' => 'dialogMenyerahkan', 'jsFunction'=>'setDialogRincian("lokasi","dialogKode",this);'),
        ));            
        ?>
    </td>
    <td>
        <?php
            echo CHtml::activeTextField($model, '[detail][ii]merk', array('class' => 'span2','readonly'=>false));
        ?>
    </td>
    <td>
        <?php
            echo CHtml::activeTextField($model, '[detail][ii]barang_satuan', array('class' => 'span1 required','readonly'=>true));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail][ii]barang_jumlah', array('readonly' => false,'class' => 'span2 required integer-decimal volume ubah', 'onblur' =>'hitungJumlahBaris(this);'));
            echo CHtml::activeHiddenField($model, '[detail][ii]volume_awal', array('readonly' => false,'class' => 'span1 required integer-decimal'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail][ii]barang_harga', array('readonly' => false,'class' => 'span2 required integer-decimal barang_harga estimasi ubah', 'onblur' =>'hitungJumlahBaris(this);'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail][ii]pajak_persen', array('readonly' => false,'class' => 'span1 required integer-decimal persenpajak ubah', 'onblur' =>'hitungJumlahBaris(this);', 'maxlength' => 6, 'style'=>'text-align:right; width: 70px'));
            echo CHtml::activeHiddenField($model, '[detail][ii]pajak_jumlah', array('readonly' => true,'class' => 'required integer-decimal pajak'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail][ii]ongkos_kirim', array('readonly' => false,'class' => 'span2 integer-decimal ongkos_kirim'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail][ii]barang_total', array('readonly' => false,'class' => 'span2 required integer-decimal harga barang_total', 'onblur' => 'hitungHargaBaris(this)'));
            echo CHtml::activeHiddenField($model, '[detail][ii]jumlah_awal', array('readonly' => false,'class' => 'span2 required integer-decimal'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail][ii]sisa_pagu', array('readonly' => true,'class' => 'span2 required integer-decimal sisa_pagu'));
            echo CHtml::activeHiddenField($model, '[detail][ii]sisa_volume', array('readonly' => true,'class' => 'span2 required integer-decimal sisa_volume'));
        ?>
    </td>
    <td>
        <div class="controls rowbutton"  >    
        <?php                
            echo CHtml::link('<span style="color:red;font-size:15px;"><i class="glyphicon glyphicon-minus"></i></span>', "javascript:;", array('class'=>'hapus','onclick'=>'hapusBaris(this); return false;',));                    
            echo CHtml::link('<span style="font-size:15px;"><i class="glyphicon glyphicon-plus"></i></span>', "javascript:;", array('class'=>'tambah ','onclick'=>'tambahBarisBaru(); return false;',));                
        ?>
        </div>
    </td>
</tr>