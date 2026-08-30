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
<tr data-row="0">
    <td>        
        <?php 
                echo CHtml::hiddenField('detail['.$i.'][invperalatan_id]',$model->invperalatan_id,array('readonly' => true, 'class' => 'aset_id required'));                
                echo CHtml::hiddenField('detail['.$i.'][peminjamanbrg_id]',$model->peminjamanbrg_id,array('readonly' => true, 'class' => 'pinjamaset_id'));                

                $this->widget('MyJuiAutoComplete', array(
                    //'model'=>$model,
                    'name' => 'detail['.$i.'][invperalatan_namabrg]',
                    'value' => $model->invperalatan_namabrg,
                    'source' => 'js: function(request, response) {                        
                        $.ajax({
                                url: "' . $this->createUrl('/actionAutoComplete/dropInventarisasiAset') . '",
                                dataType: "json",
                                data: {
                                        term: request.term,                                                                                
                                },
                                success: function (data) {
                                                response(data);
                                }
                        })
                     }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val(ui.item.label);
                                return false;
                        }',
                        'select' => 'js:function( event, ui ) {                                
                                setAset(ui.item,this);
                                return false;
                        }',
                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogAset','jsFunction'=>"setDialog('aset',this);"),
                    'htmlOptions'=>array(                    
                        'onblur' => 'if(this.value==""){$(this).parents("tr").find(".aset_id").val("");}',
                        'class'=>'required  aset_nama','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik Barang'),
                ));		
            ?>            
    </td>
    <td><span class="noaset"><?php echo $model->invperalatan_kode; ?></span></td>
    <td><span class="merk"><?php echo $model->invperalatan_merk; ?></span></td>
    <td><span class="ukuran"><?php echo $model->invperalatan_ukuran; ?></span></td>
    <td><span class="keadaan"><?php echo $model->invperalatan_keadaan; ?></span></td>
    <td>
        <div class="cotrol-group">
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