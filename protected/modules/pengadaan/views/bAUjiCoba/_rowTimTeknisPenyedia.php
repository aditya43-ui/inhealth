<tr data-row="<?php echo $i ?>">
    <td>
        <?php echo CHtml::textField('no_urut', '1', array('readonly' => true, 'class' => 'span1 integer', 'style' => 'width:20px;')); ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField('no_row','',array('readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($modPegawaiPenyedia, '[0]teknisipenyedia_id'); ?>
        <?php
        echo CHtml::activeTextField($modPegawaiPenyedia, '[0]teknisipenyedia_nama', array('class' => 'span3 pegawai_nama required'));
        /*$this->widget('MyJuiAutoComplete', array(
            'model' => $modPegawaiPenyedia,
            'attribute' => '[0]teknisipenyedia_nama',
            'source' => 'js: function(request, response) {
                $.ajax({
                    url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
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
                    $(this).val( ui.item.nama_pegawai);
                    return false;
                }',
                'select' => 'js:function( event, ui ) {
                    setPenyediaAuto($(this), ui.item);
                    return false;
                }',
            ),
            'htmlOptions' => array(
                'class' => 'span3 pegawai_nama required',
                'onkeypress' => "return $(this).focusNextInputField(event)",
                'placeholder' => 'Ketikan Nama Pegawai',
            ),
            'tombolDialog' => array('idDialog' => 'dialog2', 'jsFunction'=>"setDialogPenyedia(this);"),
        ));*/
        ?>
    </td>
    <td style="text-align: center" class="aksi">
        <div style="display: none;" class="tambahRow">
            <?php echo CHtml::link('<i class="icon-plus-sign"></i>', 'javascript:void(0)', array('onclick'=>'tambahBarisPenyedia(this)', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk tambah baris",'data-placement'=>'left')); ?>
        </div>
        <div style="display: none" class="hapusRow">
            <?php echo CHtml::link('<i class="icon-minus-sign"></i>', '#', array('onclick'=>'hapusBarisPenyedia(this);return false;', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menghapus baris",'data-placement'=>'left'));?>
        </div>
    </td>
</tr>