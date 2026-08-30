<tr row-rincian="0">
    <td style="text-align: center;">
        <?php echo CHtml::activeHiddenField($model, '[ii]tautansdki_slki_id', array('readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($model, '[ii]tautansdki_slki_det_id', array('readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($model, '[ii]luarankeperawatan_id', array('readonly' => true,'class'=>'luarankeperawatan_id')); ?>
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $model,
            'attribute' => '[ii]luarankeperawatan_nama',
            'source' => 'js: function(request, response) {
                            $.ajax({
                                    url: "' . $this->createUrl('AutoCompleteLuaranKeperawatan') . '",
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
                                $(this).val( ui.item.value);
                                return false;
                            }',
                'select' => 'js:function( event, ui ) { 
                                setLuarankeperawatan();
                                return false;
                            }',
            ),
            'htmlOptions' => array(
                'placeholder' => 'Nama Luaran Keperawatan',
                'onkeypress' => "return $(this).focusNextInputField(event)",
                'class' => 'span4 luarankeperawatan_nama'
            ),
            'tombolDialog' => array('idDialog' => 'dialogLuaranKeperawatan','jsFunction'=>"setDialog(this);"),
        ));
        ?>
    </td>
    <td style="text-align: center;">
        <?php 
        if($model->tautansdki_slki_aktif == 'aktif'){
            $checked = "'checked'=>'checked'";
        }else{
            $checked = '';
        }  ?>
        <?php echo CHtml::activeCheckBox($model, '[ii]tautansdki_slki_aktif', array('rel' => 'tooltip', 'title' => 'Klik untuk menonaktifkan status', 'onkeypress' => "return $(this).focusNextInputField(event);", "onClick" => 'cek(this);', $checked)); ?>
    </td>
    <td style="text-align: center;" class="rowbutton">
        <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('rel' => 'tooltip', 'title' => 'Tambahkan Luaran Keperawatan', 'class' => 'btn btn-primary', 'onclick' => 'tambahLookup()')); ?>
    </td>
    <td style="text-align: center;" class="rowbutton">
<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('rel' => 'tooltip', 'title' => 'Hapus Luaran Keperawatan', 'class' => 'btn btn-danger', 'onclick' => 'hapusLookup(this)')); ?>
    </td>
</tr>
