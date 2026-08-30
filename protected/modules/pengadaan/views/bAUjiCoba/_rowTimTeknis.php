<tr data-row="<?php echo $i ?>">
    <td>
        <?php echo CHtml::textField('no_urut', '1', array('readonly' => true, 'class' => 'span1 integer', 'style' => 'width:20px;')); ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField('no_row','',array('readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($modPegawai, '[0]pegtimteknis_id'); ?>
        <?php echo CHtml::activeHiddenField($modPegawai, '[0]pegawai_id', array('class' => 'pegawai_id')); ?>
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $modPegawai,
            'attribute' => '[0]nama_pegawai',
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
                    setPegAuto($(this), ui.item);
                    return false;
                }',
            ),
            'htmlOptions' => array(
                'class' => 'span3 pegawai_nama required',
                'onkeypress' => "return $(this).focusNextInputField(event)",
                'placeholder' => 'Ketikan Nama Pegawai',
            ),
            'tombolDialog' => array('idDialog' => 'dialog1', 'jsFunction'=>"setDialog(this);"),
        ));
        ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPegawai, '[0]nomorindukpegawai', array('readonly' => true, 'class' => 'span3 nip')); ?>
    </td>
    <!--<td><?php // echo CHtml::activeTextField($modPegawai, '[0]jabatan_timteknis', array('class' => 'span3 jabatan', 'placeholder' => 'Ketikkan Jabatan')); ?> </td>-->
    <td style="text-align: center" class="aksi">
        <div style="display: none" class="tambahRow">
            <?php echo CHtml::link('<i class="icon-plus-sign"></i>', 'javascript:void(0)', array('onclick'=>'tambahBaris(this)', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk tambah baris",'data-placement'=>'left')); ?>
        </div>
        <div style="display: none" class="hapusRow">
            <?php echo CHtml::link('<i class="icon-minus-sign"></i>', '#', array('onclick'=>'hapusBaris(this);return false;', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menghapus baris",'data-placement'=>'left'));?>
        </div>
    </td>
</tr>