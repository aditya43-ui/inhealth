<?php
$i = !empty($i)?$i:0;
?>
<div class="control-group pengelompokkan baris">
    <label class="control-label "><span class="no-labelno-label">Pelaksana</span></label>
    <div class="controls">
        <?php        
            echo CHtml::activeHiddenField($model,'['.$i.']invkalibrasidet_id',array('class'=>'invkalibrasidet_id det_id'));
            echo CHtml::activeHiddenField($model,'['.$i.']pegawai_id',array('class'=>'pegawai_id required'));

            $this->widget('MyJuiAutoComplete', array(    
               'model'=>$model,
               'attribute' => '['.$i.']nama_pegawai',
                'source'=>'js: function(request, response) {
                    $.ajax({
                        url: "'.Yii::app()->createUrl('/ActionAutoComplete/getPegawai').'",
                        dataType: "json",
                        data: {
                            term: request.term,
                            is_peg_internalaset: "ya"
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
                        $(this).val( ui.item.label);
                        return false;
                    }',
                    'select' => 'js:function( event, ui ) {
                        setPegawai(ui.item, this);
                        return false;
                    }',
               ),
                'htmlOptions'=>array(                    
                    'placeholder'=>'ketik pelaksana',                    
                    'class'=>'required nama_pegawai span3',
                    'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegawai_id') . '").val(""); ',
                    'onkeypress'=>"return $(this).focusNextInputField(event);",
                ),
                'tombolDialog'=>array('idDialog'=>'dialogPegawai', 'jsFunction'=>"$('#dialogPegawai').dialog('open');setNo(this);"),

           ));
       ?>
    </div>
    <div class="controls">
        <?= CHtml::link("<i class='".MyIcon::getIcons('tambah-baris')."'></i>",'javascript:;',['onclick'=>'set_action(this,"tambah")','class'=>'btn btn-primary btn-tambah','style'=>'padding:5px;']) ?>                
        <?= CHtml::link("<i class='".MyIcon::getIcons('hapus-baris')."'></i>",'javascript:;',['onclick'=>'set_action(this,"hapus")','class'=>'btn btn-danger btn-hapus','style'=>'padding:5px;']) ?>
    </div>
</div>