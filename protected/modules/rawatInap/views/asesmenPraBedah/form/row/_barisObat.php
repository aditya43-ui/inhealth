<?php
    $i = !empty($i)?$i:0;
    $dropSatuan  = !empty($dropSatuan)?$dropSatuan:[];
?>
<tr row-data="<?= $i ?>" class="baris">    
    <td >
 <?php

        $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => '[' . $i . ']obatalkes_nama',
                'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "'.$this->createUrl('/actionAutoComplete/ObatAlkesPartograf').'",
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
                    'minLength' => 2,
                    'focus' => 'js:function( event, ui ) {
                                $(this).val( ui.item.label);
                                return false;
                             }',
                    'select' => 'js:function( event, ui ) { 
                                setObat(ui.item, this)
                                return false;
                            }',
                ),
                'htmlOptions' => array(
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'placeholder' => "Ketik nama obat alkes",
                    'class' => 'span3 obatalkes_nama',
                    'onblur' => 'resetObat(this);'
                ),
                'tombolDialog' => array('idDialog' => 'dialogObat', 'jsFunction' => 'setDialog("","dialogObat");setNo(this);refreshGridObat();'),                        
            ));
        ?>                
    </td>
    <td>
        <?= 
            CHtml::activeTextField($model, '['.$i.']jumlah',[
                'style'=>'text-align:right;',
                'class'=>'numbers-only span1 jumlah',
            ]) 
        ?>
    </td>
    <td>
        <?= 
            CHtml::activeTextField($model, '['.$i.']dosis',[
                'style'=>'text-align:right;',
                'class'=>'numbers-only span1 dosis',
            ]).' '.CHtml::activeDropDownList($model, '['.$i.']satuandosis',$dropSatuan,[
                'class'=>' span2',
                'empty'=>'-- Pilih --'
            ]) 
        ?>
    </td>    
    <td> 
         <?= 
            CHtml::activeTextField($model, '['.$i.']carapemberian',[
                'class'=>'span2',
            ]) 
        ?>

    </td>
    <td> 
         <?php 
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => '['.$i.']jam',
                'mode' => 'datetime',
                'options' => array(
                    'minDate'=>'d',
                    'yearRange' => "-150:+0",
                ),
                'htmlOptions' => array(

                    'class' => 'span3 jam',
                    'readonly'=>true
                ),
            ));
        ?>

    </td>
    <td> 
         <?= 
            CHtml::activeTextArea($model, '['.$i.']petunjukkhusus',[
                'class'=>'span2',
            ]) 
        ?>

    </td>
    <td class='btn-ulang' style="text-align:center;"> 
        <?php
            echo CHtml::activeHiddenField($model, '['.$i.']obatalkes_id',['class'=>'obatalkes_id']);
            echo CHtml::activeHiddenField($model, '['.$i.']rencanapulangdet_id',['class'=>'rencanapulangdet_id det_id']);
        ?>
        <?= CHtml::link("<i class='" . MyIcon::getIcons('hapus-baris') . "'></i>", 'javascript:;', ['onclick' => 'set_action(this,"hapus");', 'class' => 'btn btn-danger btn-hapus', 'style' => 'padding:5px;']) ?>
    </td>
</tr>