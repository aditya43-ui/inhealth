<tr class="tr-kelengkapanAlat" baris="<?= $key; ?>">
    <td class="td-no" baris="<?= $no?>"><?= $no; ?></td>
    <td>
        <?= CHtml::activeHiddenField($modKelengkapanAlat, '['.$key.']obatalkes_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'required obatalkes_id')); ?>
        <?= CHtml::activeHiddenField($modKelengkapanAlat, '['.$key.']resephd_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '')); ?>
        <?= CHtml::activeHiddenField($modKelengkapanAlat, '['.$key.']resephd_det_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '')); ?>
        
        <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modKelengkapanAlat,
                'attribute' => '['.$key.']obatalkes_nama',
                'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . $this->createUrl('/actionAutoComplete/ObatAlkesPartograf') . '",
                                            dataType: "json",
                                            data: {
                                                    term: request.term,
                                                    perawat_id: $("#perawat1_id").val(),
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
                                            setObat(this, ui.item)
                                            return false;
                                    }',
                ),
//                                'tombolDialog' => array('idDialog' => 'dialogPerawat1'),
                'tombolDialog'=>array('idDialog'=>'dialogKelengkapanAlat', 'jsFunction'=>'setRow(this); $("#dialogKelengkapanAlat").dialog("open")'),
                'htmlOptions' => array('class' => 'span4 required obatalkes_nama'),
            ));
            ?>
    </td>
    <td><?= CHtml::activeTextField($modKelengkapanAlat, '['.$key.']jumlah') ?></td>
    <td>
        <a href="javascript:void(0)" onclick="hapusBaris(this)"><i class="icon-minus-sign"></i></a>
    </td>
</tr>

