<?php
/** 
 * detail per hps
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
?>
<tr data-row="0">
    <td>
        <span class="no_urut"></span>
    </td>
    <td>                
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']persiapanpengadaandet_nama', array('readonly' => true,'class' => 'required persiapanpengadaandet_nama'));
            echo CHtml::activeHiddenField($model,'[detail]['.$i.']persiapanpengadaandet_id',array('readonly' => true, 'class' => 'det_id'));                
            echo CHtml::activeHiddenField($model,'[detail]['.$i.']persiapanpengadaan_id',array('readonly' => true, 'class' => 'parent_id'));                               	
            echo CHtml::activeHiddenField($model,'[detail]['.$i.']barang_id',array('readonly' => true, 'class' => ''));                               	
            echo CHtml::activeHiddenField($model,'[detail]['.$i.']jenis_barang',array('readonly' => true, 'class' => ''));                               	
            echo CHtml::activeHiddenField($model,'[detail]['.$i.']dokumenpelaksanaananggarandet_id',array('readonly' => true, 'class' => ''));           	
            echo CHtml::activeHiddenField($model,'[detail]['.$i.']rencanaumumpengadaandet_id',array('readonly' => true, 'class' => ''));                               	            
        ?>            
    </td>
    <td>
        <?php
            echo CHtml::activeTextField($model, '[detail]['.$i.']persiapanpengadaandet_satuan', array('readonly' => true,'class' => 'span1 required'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']persiapanpengadaandet_volume', array('readonly' => true,'class' => 'required integer-decimal volume', 'onblur' =>'hitung();'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']harga_estimasi', array('readonly' => true,'class' => 'required integer-decimal estimasi', 'onblur' =>'hitung();'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']pajak_persen', array('readonly' => true,'class' => 'required float2 persenpajak', 'onblur' =>'hitung();', 'maxlength' => 6, 'style'=>'text-align:right;'));
            echo CHtml::activeHiddenField($model, '[detail]['.$i.']jumlah_pajak', array('readonly' => true,'class' => 'required integer-decimal pajak', 'onblur' =>'hitung();'));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($model, '[detail]['.$i.']jumlah_harga', array('readonly' => true,'class' => 'required integer-decimal harga'));
            echo CHtml::activeHiddenField($model, '[detail]['.$i.']sisapagu_pengadaan', array('readonly' => true,'class' => 'required integer-decimal sisapagu_pengadaan'));
            echo CHtml::activeHiddenField($model, '[detail]['.$i.']jumlah_hargalama', array('readonly' => true,'class' => 'required integer-decimal jumlah_hargalama'));
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