<tr data-row="0">
    <td>
        <span class="no_urut"><?php echo $i+1 ?> </span>
    </td>
    <td>                
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']nama_dpa', array('class' => 'span2','readonly'=>true));
            //echo CHtml::activeTextField($model, '[detail]['.$i.']barang_nama', array('class' => 'required','readonly'=>true));
            echo CHtml::activeHiddenField($model,'[detail]['.$i.']barang_id',array('readonly' => true, 'class' => 'barang_id'));                               	
            echo CHtml::activeHiddenField($model,'[detail]['.$i.']jenis_barang',array('readonly' => true, 'class' => ''));                               	
            echo CHtml::activeHiddenField($model,'[detail]['.$i.']dokumenpelaksanaananggarandet_id',array('readonly' => true, 'class' => ''));                               	            
            echo CHtml::activeHiddenField($model,'[detail]['.$i.']obatalkes_id',array('readonly' => true, 'class' => 'obatalkes_id'));                               	            
        ?>            
    </td>
    <td>
        <?php
            echo CHtml::activeTextField($model, '[detail]['.$i.']barang_nama', array('class' => 'required barang_nama','readonly'=>true));
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
            echo CHtml::activeTextField($model, '[detail]['.$i.']barang_jumlah', array('readonly' => false,'class' => 'span1 required integer-decimal volume ubah', 'onblur' =>($readonlyHPS == true) ? '' : 'hitungJumlahBaris(this);', ));
            echo CHtml::activeHiddenField($model, '[detail][' . $i . ']volume_awal', array('readonly' => true, 'class' => 'span1 required integer-decimal volume_awal ubah'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']barang_harga', array('readonly' => $readonlyHPS,'class' => 'span3 required integer-decimal harga_satuan ubah', 'onblur' =>($readonlyHPS == true) ? '' : 'hitungJumlahBaris(this);', ));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']pajak_persen', array('readonly' => $readonlyHPS,'class' => 'required integer-decimal persenpajak ubah', 'onblur' =>($readonlyHPS == true) ? '' : 'hitungJumlahBaris(this);', 'maxlength' => 6, 'style'=>'text-align:right; width: 70px'));
            echo CHtml::activeHiddenField($model, '[detail]['.$i.']pajak_jumlah', array('readonly' => true,'class' => 'required integer-decimal pajak'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']ongkos_kirim', array('readonly' => false,'class' => 'span3 integer-decimal ongkos_kirim'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']barang_total', array('onblur' =>($readonlyHPS == true) ? '' : 'hitungHargaBaris(this);', 'readonly' => $readonlyHPS,'class' => 'span3 required integer-decimal total_harga'));
            echo CHtml::activeHiddenField($model, '[detail][' . $i . ']jumlah_awal', array('readonly' => true, 'class' => 'span3 required integer-decimal jumlah_awal'));
            echo CHtml::activeHiddenField($model, '[detail][' . $i . ']sebelum_pajak', array('readonly' => true, 'class' => 'span3 integer-decimal sebelum_pajak'));
        ?>
    </td>
    <td class="<?php echo ($readonlyHPS == true) ? 'hide' : ''?>">
        <?php
        echo CHtml::activeTextField($model, '[detail][' . $i . ']sisa_pagu', array('readonly' => true, 'value' => MyFormatter::formatNumberForPrint($model->sisa_pagu),  'class' => 'span3 integer-decimal sisa_pagu'));
        ?>
    </td>
    <td class="hide">
        <div class="control-group">
            <div class="controls rowbutton">            
                <?php echo CHtml::link('<span style="font-size:20px;"><i class="'.MyIcon::getIcons('tambah-baris').'"></i></span>', 'javascript:;', array('style'=>'border-radius:100%;padding:0px;','class'=>'btn btn-primary tambah','onclick'=>'tambahBaris()', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menambahkan baris baru",'data-placement'=>'left')); ?>            
            </div>
            <div class="controls rowbutton"  >            
                <?php 
                    if ($i >= 1){
                        echo CHtml::link('<span style="font-size:20px;"><i class="'.MyIcon::getIcons('hapus-baris').'"></i></span>', 'javascript:;', array('style'=>'border-radius:100%;padding:0px;display:block;','class'=>'btn btn-danger hapus','onclick'=>'hapusBaris(this)', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menghapus baris",'data-placement'=>'left')); 
                    }else{
                        echo CHtml::link('<span style="font-size:20px;"><i class="'.MyIcon::getIcons('hapus-baris').'"></i></span>', 'javascript:;', array('style'=>'border-radius:100%;padding:0px;display:none;','class'=>'btn btn-danger hapus','onclick'=>'hapusBaris(this)', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menghapus baris",'data-placement'=>'left')); 
                    }
                        ?>            
            </div>
        </div>
    </td>
</tr>