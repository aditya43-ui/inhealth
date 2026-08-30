<tr class="tr-kantong" baris="<?= $key ?>">
    <td>
        <?= CHtml::activeTextField($modDetail, '['.$key.']no_kantongdarah', array('disabled' => false, 'class' => 'span2')); ?>
    </td>
    <td>
        <?= CHtml::activeDropDownList($modDetail, '['.$key.']jeniskomponendarah_id', CHtml::listData(JeniskomponendarahM::model()->findAll(" jeniskantongdarah_aktif = true ORDER BY jeniskomponenedarah_nama ASC "), 'jeniskomponendarah_id', 'jeniskomponenedarah_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'empty' => '--Pilih--')); ?>
    </td>
    <td>
        <?= CHtml::activeTextField($modDetail, '['.$key.']volume_darah', array('disabled' => false, 'class' => 'span2 integer')); ?>
    </td>
    <td>
        <?= CHtml::activeHiddenField($modDetail, '['.$key.']petugas_transfusi_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '')); ?>
        <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modDetail,
                'attribute' => '['.$key.']petugas_transfusi_nama',
                'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . $this->createUrl('AutoCompletePerawat') . '",
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
                                            $(this).val( ui.item.label);
                                            return false;
                                     }',
                    'select' => 'js:function( event, ui ) {
                                            $("#perawat1_id").val(ui.item.perawat1_id); 
                                            $("#perawat1_nama").val(ui.item.perawat1_nama);
                                            return false;
                                    }',
                ),
//                                'tombolDialog' => array('idDialog' => 'dialogPerawat1'),
                'tombolDialog'=>array('idDialog'=>'dialogTransfusi', 'jsFunction'=>'setTransfusi(this); $("#dialogTransfusi").dialog("open")'),
                'htmlOptions' => array('class' => 'span4'),
            ));
        ?>
    </td>
    <td>
        <?= CHtml::activeHiddenField($modDetail, '['.$key.']petugas_verifikasi_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '')); ?>
        <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modDetail,
                'attribute' => '['.$key.']petugas_verifikasi_nama',
                'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . $this->createUrl('AutoCompletePerawat') . '",
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
                                            $(this).val( ui.item.label);
                                            return false;
                                     }',
                    'select' => 'js:function( event, ui ) {
                                            $("#perawat1_id").val(ui.item.perawat1_id); 
                                            $("#perawat1_nama").val(ui.item.perawat1_nama);
                                            return false;
                                    }',
                ),
//                                'tombolDialog' => array('idDialog' => 'dialogPerawat1'),
                'tombolDialog'=>array('idDialog'=>'dialogVerifikasi', 'jsFunction'=>'setVerifikasi(this); $("#dialogVerifikasi").dialog("open")'),
                'htmlOptions' => array('class' => 'span4'),
            ));
        ?>
    </td>
    <td style="text-align: center;">
        <?php echo CHtml::link('<span style="font-size:20px;color:red;"><i class=" entypo-trash"></i></span>', 'javascript:void(0);', array('class'=>'', 'onclick'=>"batalKantongDarah(this);return false"))."&nbsp;"; ?>
    </td>
</tr>