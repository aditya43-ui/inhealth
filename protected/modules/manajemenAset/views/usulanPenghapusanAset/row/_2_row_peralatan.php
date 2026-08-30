<?php
    $i = !empty($i)?$i:0;
?>
<tr row-data="<?= $i ?>" class="baris">    
    <td>
        <?php
            echo CHtml::activeHiddenField($model, '['.$i.']usulanpenghapusanasetdet_id', ['class'=>'det_id pengeringanbjdet_id']);
            echo CHtml::activeHiddenField($model, '['.$i.']invperalatan_id', ['class'=>'invperalatan_id']);
            echo CHtml::activeHiddenField($model, '['.$i.']kondisi', ['class'=>'kondisi']);            
            
            $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => '[' . $i . ']invperalatan_namabrg',
                    'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('/actionAutoComplete/DropInventarisasiAset') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,    
                                        lokasi_id : $(".lokasi_id").val()
                                    },
                                    success: function (data) {
                                        response(data);
                                    }
                                })
                            }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);
                                    return false;
                                 }',
                        'select' => 'js:function( event, ui ) { 
                                    setAset(ui.item, this)
                                    return false;
                                }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => "Ketik nama aset",
                        'class' => 'span3 invperalatan_namabrg required',
                        'onblur' => 'if(this.value==""){resetAset(this)}'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogAset', 'jsFunction' => 'setDialog("","dialogAset");setNo(this);refreshAset();'),                        
                ));
            ?>        
    </td>
    <td>
        <span class='lbl label-kode'><?= $model->invperalatan_kode ?></span>
    </td>
    <td>
        <span class='lbl label-merk'><?= $model->invperalatan_merk ?></span>
    </td>
    <td>
        <span class='lbl label-tanggal-perolehan'><?= $model->tanggal_perolehan ?></span>
    </td>
    <td>
        <span class='lbl label-keadaan'><?= $model->invperalatan_keadaan ?></span>
    </td>
    <td>
        <?= 
            CHtml::activeTextArea($model, '['.$i.']alasan',['class'=>'span3'])
        ?>
    </td>
    <td class='btn-ulang'>        
        <?= CHtml::link("<i class='" . MyIcon::getIcons('tambah-baris') . "'></i>", 'javascript:;', ['onclick' => 'set_action(this,"tambah");', 'class' => 'btn btn-primary btn-tambah', 'style' => 'padding:5px;margin-bottom:5px;']) ?>
        <br/>
        <?= CHtml::link("<i class='" . MyIcon::getIcons('hapus-baris') . "'></i>", 'javascript:;', ['onclick' => 'set_action(this,"hapus");', 'class' => 'btn btn-danger btn-hapus', 'style' => 'padding:5px;']) ?>
    </td>
</tr>

