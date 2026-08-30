<tr>
    <td>
        <?php $row = isset($row) ? $row : 0; ?>
        <?php //echo $row; ?>
        <?php echo CHtml::textField('noUrut', ($row+1), array('readonly'=>true, 'class'=>'span1 noUrut integer2')); ?>
        <?php echo CHtml::hiddenField('row', $row, array('readonly'=>true, 'class'=>'span1 row')); ?>
        <?php echo CHtml::activeHiddenField($modProduksiDetail,'['.$row.']hargasatuan', array('readonly'=>true,'class'=>'inputFormTabel lebar2')); ?>
        <?php echo CHtml::activeHiddenField($modProduksiDetail,'['.$row.']harganetto', array('readonly'=>true,'class'=>'inputFormTabel lebar2')); ?>
        <?php echo CHtml::activeHiddenField($modProduksiDetail,'['.$row.']hpp', array('readonly'=>true,'class'=>'inputFormTabel lebar2')); ?>
        <?php echo CHtml::activeHiddenField($modProduksiDetail,'['.$row.']stokobatalkes_id',array('readonly'=>true,'class'=>'inputFormTabel lebar2')); ?>
    </td>
    <td><?php echo CHtml::activeTextField($modProduksiDetail,'['.$row.']obatalkes_kode', array('readonly'=>true,'class'=>'span1')); ?></td>
    <td>
        <?php echo CHtml::activeHiddenField($modProduksiDetail,'['.$row.']obatalkes_id', array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);",)); ?>
        <?php $this->widget('MyJuiAutoComplete',array(
                    'model'=>$modProduksiDetail,
                    'attribute'=>'['.$row.']obatalkes_nama',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('AutoCompleteObat').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                        },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                    'options'=>array(
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $(this).val("");
                            return false;
                        }',
                       'select'=>'js:function( event, ui ) {
                            $(this).val(ui.item.value);
                            $(this).parents("tr").find("input[name$=\"[obatalkes_id]\"]").val(ui.item.obatalkes_id);
                            $(this).parents("tr").find("input[name$=\"[obatalkes_kode]\"]").val(ui.item.obatalkes_kode);
                            $(this).parents("tr").find("input[name$=\"[hargasatuan]\"]").val(ui.item.hjaresep);
                            $(this).parents("tr").find("input[name$=\"[harganetto]\"]").val(ui.item.harganetto);
                            $(this).parents("tr").find("input[name$=\"[hpp]\"]").val(ui.item.hpp);
                            $(this).parents("tr").find("input[name$=\"[satuankecil_id]\"]").val(ui.item.satuankecil_id);
                            $(this).parents("tr").find("input[name$=\"[satuankecil_nama]\"]").val(ui.item.satuankecil_nama);
                            return false;
                        }',

                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogDaftarTindakanPaket','jsFunction'=>"setDialog(this);"),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'required'),
        )); ?>
    </td>
    <td><?php echo CHtml::activeTextField($modProduksiDetail,'['.$row.']dosis', array('onblur'=>'hitungQty(this);','class'=>'span1 integer2','onkeypress'=>"return $(this).focusNextInputField(event);",)); ?></td>
    <td><?php echo CHtml::activeTextField($modProduksiDetail,'['.$row.']kemasan', array('onblur'=>'hitungQty(this);','class'=>'span1 integer2','onkeypress'=>"return $(this).focusNextInputField(event);",)); ?></td>
    <td><?php echo CHtml::activeTextField($modProduksiDetail,'['.$row.']kekuatan', array('onblur'=>'hitungQty(this);','class'=>'span1 integer2','onkeypress'=>"return $(this).focusNextInputField(event);",)); ?></td>
    <td><?php echo CHtml::activeTextField($modProduksiDetail,'['.$row.']qtyproduksi', array('class'=>'span1 integer2','onkeypress'=>"return $(this).focusNextInputField(event);",)); ?></td>
    <td><?php echo CHtml::activeTextField($modProduksiDetail,'['.$row.']qtystok', array('class'=>'span1 integer2','onkeypress'=>"return $(this).focusNextInputField(event);",)); ?></td>
    <td>
        <?php echo CHtml::activeHiddenField($modProduksiDetail,'['.$row.']satuankecil_id', array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeTextField($modProduksiDetail,'['.$row.']satuankecil_nama', array('readonly'=>true,'class'=>'span2')); ?>
    </td>
    <td>
        <?php 
        echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowBahan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah bahan')); 
        $removeButton=isset($removeButton)?$removeButton:false;
        if($removeButton){
            echo "<br><br>";
            echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalBahan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan bahan'));
        }
        ?>
    </td>
</tr>
