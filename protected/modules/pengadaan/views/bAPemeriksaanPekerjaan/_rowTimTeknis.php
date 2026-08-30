<tr data-row="<?php echo $i ?>">
    <td>
        <?php echo CHtml::textField('no_urut', '1', array('readonly' => true, 'class' => 'span1 integer', 'style' => 'width:20px;')); ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField('no_row', '', array('readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($modPegawai, '[0]pegtimteknis_id'); ?>
        <?php echo CHtml::activeHiddenField($modPegawai, '[0]pegawai_id', array('class' => 'pegawai_id')); ?>
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $modPegawai,
            'attribute' => '[0]nama_pegawai',
            'source' => 'js: function(request, response) {
                $.ajax({
                    url: "' . Yii::app()->createUrl('ActionAutoComplete/getTimTeknis') . '",
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
            'tombolDialog' => array('idDialog' => 'dialog1', 'jsFunction' => "setDialog(this);"),
        ));
        ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPegawai, '[0]nomorindukpegawai', array('readonly' => true, 'class' => 'span3 nip')); ?>
    </td>
    <td><?php echo CHtml::activeTextField($modPegawai, '[0]jabatan_timteknis', array('class' => 'span3 required jabatan', 'placeholder' => 'Ketikkan Jabatan')); ?> 
        <?php echo CHtml::activeHiddenField($modPegawai, '[0]status', array('class' => 'status', 'readonly' => true)); ?></td>
    <td>
        <div style="display: none" class="tambahRow">
            <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', 'javascript:void(0)', array('class'=>'btn btn-primary','onclick' => 'tambahBaris(this)')); ?>
        </div>
        <div style="display: none" class="hapusRow">
            <?php
            if(!empty($modPegawai->pegtimteknis_id)){
                echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'hapusData(this)', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menghapus Data",'data-placement'=>'left'));  
            }else{
                echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'hapusBaris(this)', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menghapus baris",'data-placement'=>'left')); 
            }
        ?>
        </div>
    </td>
</tr>