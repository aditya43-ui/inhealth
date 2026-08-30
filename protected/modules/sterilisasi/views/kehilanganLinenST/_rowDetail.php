<tr>
    <td>
        <?php $row = isset($row) ? $row : 0; ?>
        <?php echo CHtml::textField('noUrut', ($row+1), array('readonly'=>true, 'class'=>'span1 noUrut integer')); ?>
        <?php echo CHtml::hiddenField('row', $row, array('readonly'=>true, 'class'=>'span1 row')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'['.$row.']linen_id',array('readonly'=>true,'class'=>'span1')); ?>
	</td>
    <td>
        <?php echo CHtml::activeHiddenField($modDetail,'['.$row.']barang_id', array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);",)); ?>
        <?php $this->widget('MyJuiAutoComplete',array(
                    'model'=>$modDetail,
                    'attribute'=>'['.$row.']barang_nama',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('AutoCompleteBarang').'",
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
                       'minLength' => 3,
                       'focus'=> 'js:function( event, ui ) {
                            $(this).val("");
                            return false;
                        }',
                       'select'=>'js:function( event, ui ) {
                            $(this).val(ui.item.value);
                            $(this).parents("tr").find("input[name$=\"[barang_id]\"]").val(ui.item.barang_id);
                            $(this).parents("tr").find("input[name$=\"[barang_nama]\"]").val(ui.item.barang_nama);
                            return false;
                        }',

                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogPeralatan','jsFunction'=>"setDialog(this);"),
                    'htmlOptions'=>array('placeholder'=>'Nama Peralatan dan Linen','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'required'),
        )); ?>
    </td>
    <td><?php echo CHtml::activeTextField($modDetail,'['.$row.']penerimaansterilisasidet_jml', array('class'=>'span1 integer', 'value'=>'1', 'onkeypress'=>"return $(this).focusNextInputField(event);",)); ?></td>
    <td><?php echo CHtml::activeTextField($modDetail,'['.$row.']penerimaansterilisasidet_ket', array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);",)); ?></td>
    <td>
        <?php 
        echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowBarang(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah barang')); 
        $removeButton=isset($removeButton)?$removeButton:false;
        if($removeButton){
            echo "<br><br>";
            echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalBarang(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan barang'));
        }
        ?>
    </td>
</tr>
