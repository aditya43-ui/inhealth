<?php
/** 
 * detail per baris aset
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
?>
<tr>    
    <td>
        <label class="control-label labeldefault" style="padding-left: 10px;"><?php echo str_replace('Cvc','CVC',ucwords(strtolower($model->kelompokinduksi))); ?></label>
    </td>
    <td width="10px;">
        
    </td>
    <td>        
        <?php 
            echo CHtml::activeHiddenField($model, '['.$i.']praanestesi_induksidet_id',array('readonly' => true, 'class'=>'id'));
            echo CHtml::activeHiddenField($model, '['.$i.']kelompokinduksi',array('readonly' => true, 'class'=>'kelompok'));
            echo CHtml::activeTextField($model, '['.$i.']keterangan',array('class' => '','style'=>'width:70px;'));
        ?>
    <td>
    <td width="10px;">
        
    </td>    
    <td>
        <label>Ukuran</label>
    </td>
    <td width="10px;">
        
    </td>     
    <td>
        <?php echo CHtml::activeTextField($model, '['.$i.']ukuran',array( 'class' => 'numbers-only','style'=>'width:70px;')); ?>
    </td>    
    <td>        
            <?php 
                if ($multiple == 'yes'){
            ?>
            <div class="controls rowbutton">            
                <?php echo CHtml::link('<span style="font-size:20px;"><i class="'.MyIcon::getIcons('tambah-baris').'"></i></span>', 'javascript:;', array('style'=>'border-radius:100%;padding:0px;','class'=>'btn btn-primary tambah','onclick'=>'tambahBaris(this);', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menambahkan baris baru",'data-placement'=>'left')); ?>            
            </div>
            <div class="controls rowbutton">
                <?php 
                    if ($i >= 1){
                        echo CHtml::link('<span style="font-size:20px;"><i class="'.MyIcon::getIcons('hapus-baris').'"></i></span>', 'javascript:;', array('style'=>'border-radius:100%;padding:0px;display:block;','class'=>'btn btn-danger hapus','onclick'=>'hapusBaris(this);', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menghapus baris",'data-placement'=>'left')); 
                    }else{
                        echo CHtml::link('<span style="font-size:20px;"><i class="'.MyIcon::getIcons('hapus-baris').'"></i></span>', 'javascript:;', array('style'=>'border-radius:100%;padding:0px;display:bloc;','class'=>'btn btn-danger hapus','onclick'=>'hapusBaris(this);', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menghapus baris",'data-placement'=>'left')); 
                    }
                ?>            
            </div>    
            <?php
                }
            ?>        
    </td>
</tr>
    