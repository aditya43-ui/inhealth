<tr data-row="0">
    <td>
        <span class="no_urut"><?php echo $i+1 ?></span>
    </td>
    <td>                
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']nama_dpa', array('class' => 'span2','readonly'=>true));
            //echo CHtml::activeTextField($model, '[detail]['.$i.']barang_nama', array('class' => 'required','readonly'=>true));
            echo CHtml::activeHiddenField($model,'[detail]['.$i.']barang_id',array('readonly' => true, 'class' => 'barang_id'));                               	
            echo CHtml::activeHiddenField($model,'[detail]['.$i.']jenis_barang',array('readonly' => true, 'class' => 'jenis_barang'));                               	
            echo CHtml::activeHiddenField($model,'[detail]['.$i.']suratperjanjiankerjarincian_id',array('readonly' => true, 'class' => 'suratperjanjiankerjarincian_id'));                               	            
            echo CHtml::activeHiddenField($model,'[detail]['.$i.']dokumenpelaksanaananggarandet_id',array('readonly' => true, 'class' => 'dokumenpelaksanaananggarandet_id'));                               	            
            echo CHtml::activeHiddenField($model,'[detail]['.$i.']obatalkes_id',array('readonly' => true, 'class' => 'obatalkes_id'));                               	            
        ?>            
    </td>
    <td>
        <?php
            echo CHtml::activeTextArea($model, '[detail]['.$i.']barang_nama', array('class' => 'span2 required barang_nama','readonly'=>true));
        ?>
    </td>
    <td>
        <?php
            echo CHtml::activeTextField($model, '[detail]['.$i.']merk', array('class' => 'span2','readonly'=>false));
        ?>
    </td>
    <td>
        <?php
            echo CHtml::activeTextField($model, '[detail]['.$i.']barang_satuan', array('class' => 'span1 required','readonly'=>true));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']barang_jumlah', array('readonly' => false,'class' => 'span2 required integer-decimal volume ubah', 'onblur' =>'hitungJumlahBaris(this);'));
            echo CHtml::activeHiddenField($model, '[detail]['.$i.']volume_awal', array('readonly' => false,'class' => 'span1 required integer-decimal'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']barang_harga', array('readonly' => false,'class' => 'span2 required integer-decimal barang_harga estimasi ubah', 'onblur' =>'hitungJumlahBaris(this);'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']pajak_persen', array('readonly' => false,'class' => 'span1 required integer-decimal persenpajak ubah', 'onblur' =>'hitungJumlahBaris(this);', 'maxlength' => 6, 'style'=>'text-align:right; width: 70px'));
            echo CHtml::activeHiddenField($model, '[detail]['.$i.']pajak_jumlah', array('readonly' => true,'class' => 'required integer-decimal pajak'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']ongkos_kirim', array('readonly' => false,'class' => 'span2 integer-decimal ongkos_kirim'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']barang_total', array('readonly' => false,'class' => 'span2 required integer-decimal harga barang_total', 'onblur' => 'hitungHargaBaris(this)'));
            echo CHtml::activeHiddenField($model, '[detail]['.$i.']jumlah_awal', array('readonly' => false,'class' => 'span2 required integer-decimal'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']sisa_pagu', array('readonly' => true,'class' => 'span2 required integer-decimal sisa_pagu'));
            echo CHtml::activeHiddenField($model, '[detail]['.$i.']sisa_volume', array('readonly' => true,'class' => 'span2 required integer-decimal sisa_volume'));
        ?>
    </td>
    <td>
        <div class="controls rowbutton"  >    
        <?php                
            echo CHtml::link('<span style="color:red;font-size:15px;"><i class="glyphicon glyphicon-minus"></i></span>', "javascript:;", array('class'=>'hapus','onclick'=>'hapusData(this); return false;',));                    
            echo CHtml::link('<span style="font-size:15px;"><i class="glyphicon glyphicon-plus"></i></span>', "javascript:;", array('class'=>'tambah ','onclick'=>'tambahBarisBaru(); return false;',));                
        ?>
        </div>
    </td>
</tr>