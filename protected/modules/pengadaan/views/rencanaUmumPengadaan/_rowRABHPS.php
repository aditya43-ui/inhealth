<tr rowdata="0">
    <td><label class="no-urut">1</label>        
        <?php
            echo CHtml::activeHiddenField($model, '[0]barang_id',array('readonly'=>true, 'class'=>'barang_id'));
            echo CHtml::activeHiddenField($model, '[0]jenis_barang',array('readonly'=>true, 'class'=>'jenis_barang'));
            echo CHtml::activeHiddenField($model, '[0]dokumenpelaksanaananggarandet_id',array('readonly'=>true, 'class'=>'dokumenpelaksanaananggarandet_id required'));
            echo CHtml::activeHiddenField($model, '[0]paketpekerjaan_id',array('readonly'=>true, 'class'=>'paketpekerjaan_id'));
            echo CHtml::hiddenField('total',0,array('readonly'=>'true'));
        ?>                         
    </td>
    <td>        
        <?php
            //autocomplete
            //echo CHtml::activeHiddenField($model, '[0]rencanaumumpengadaandet_nama',array('readonly'=>true, 'class'=>'rencanaumumpengadaandet_nama'));
        $this->widget('MyJuiAutoComplete', array(    
            'model'=>$model,
            'attribute' => '[0]rencanaumumpengadaandet_nama',            
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
                 'class'=>'required rencanaumumpengadaandet_nama',
                 'onblur' => 'if(this.value === ""){ $(this).parents("tr").find(".barang_id").val(""); }',
                 'onkeypress'=>"return $(this).focusNextInputField(event);",
             ),
             'tombolDialog'=>array('idDialog'=>'dialogBarangJasa','jsFunction'=>'setRow(this);refreshBarangJasa();$("#dialogBarangJasa").dialog("open")'),
        ));
        
        echo CHtml::hiddenField("tempNama",$model->rencanaumumpengadaandet_nama,array('class'=>'tempNama'));
        ?>
    </td>
    <td>        
        <?php
            echo CHtml::activeTextField($model, '[0]rencanaumumpengadaandet_satuan',array('readonly'=>true, 'class'=>'rencanaumumpengadaandet_satuan span2'));
        ?>
    </td>
    <td>                
        <?php
            echo CHtml::activeTextField($model, '[0]rencanaumumpengadaandet_volume',array('class'=>'span2 required integer-decimal volume ubah rencanaumumpengadaandet_volume', 'onblur'=>'hitungHargaBaris(this);',' onkeyup'=>'return $(this).focusNextInputField(event);'));
            echo CHtml::activeHiddenField($model, '[0]volumeawal',array('readonly'=>true, 'class'=>'span2 required numbers-only volumeawal ubah volumeawal',' onkeyup'=>'return $(this).focusNextInputField(event);'));
        ?>
    </td>
    <td>
        <?php
            echo CHtml::activeTextField($model, '[0]rencanaumumpengadaandet_harga',array( 'class'=>'span2 required integer-decimal estimasi ubah rencanaumumpengadaandet_harga', 'onblur'=>'hitungHargaBaris(this);',' onkeyup'=>'return $(this).focusNextInputField(event);'));
            echo CHtml::activeHiddenField($model, '[0]hargaawal',array('readonly'=>true, 'class'=>'span2 required integer-decimal estimasiawal ubah hargaawal',' onkeyup'=>'return $(this).focusNextInputField(event);'));
        ?>                  
    </td>
    <td>                
        <?php            
            if (empty($model->rencanaumumpengadaandet_pajak)){
                $model->rencanaumumpengadaandet_pajak = 10;
            }
            echo CHtml::activeTextField($model, '[0]rencanaumumpengadaandet_pajak',array( 'class'=>'span2 required float2 persenpajak ubah rencanaumumpengadaandet_pajak', 'onblur'=>'hitungHargaBaris(this);',' onkeyup'=>'return $(this).focusNextInputField(event);'));
            echo CHtml::activeHiddenField($model, '[0]persenawal',array('readonly'=>true, 'class'=>'span2 required float2 persenpajakawal ubah persenawal',' onkeyup'=>'return $(this).focusNextInputField(event);'));
            echo CHtml::activeHiddenField($model, '[0]rencanaumumpengadaandet_jmlpajak',array('readonly'=>true, 'class'=>'span2 required integer-decimal pajak',' onkeyup'=>'return $(this).focusNextInputField(event);'));
        ?>
    </td>
    <td>                
        <?php            
            echo CHtml::activeTextField($model, '[0]rencanaumumpengadaandet_jumlah',array('readonly'=>false, 'class'=>'span2 required integer-decimal harga rencanaumumpengadaandet_jumlah', 'onblur' => 'hitungJumlahBaris(this)' ,'onkeyup'=>'return $(this).focusNextInputField(event);'));
            echo CHtml::activeHiddenField($model, '[0]rencanaumumpengadaandet_jumlahawal',array('readonly'=>true, 'class'=>'span2 required integer-decimal hargaawal',' onkeyup'=>'return $(this).focusNextInputField(event);'));
        ?>
    </td>
    <td>                
        <?php            
            echo CHtml::activeTextField($model, '[0]sisapagu_pengadaan',array('readonly'=>true, 'class'=>'span2 required integer-decimal sisapagu_pengadaan',' onkeyup'=>'return $(this).focusNextInputField(event);'));
        ?>
    </td>
    <td>
        <a class="hide btnhapus" onclick='hapusRAB(this);  return false;' href='javascript:;'><i class='glyphicon glyphicon-minus'></i></a>
        <a class="hide btntambah"  onclick='tambahRAB(this);  return false;' href='javascript:;'><i class='glyphicon glyphicon-plus'></i></a>
    </td>
</tr>