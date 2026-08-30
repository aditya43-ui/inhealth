<tr>
    <td style="text-align: center;">
        <?php echo CHtml::activeHiddenField($model, '[ii]intervensidet_id', array('readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($model, '[ii]intervensi_id', array('readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($model, '[ii]jenisintervensi_id', array('readonly' => true, 'class' => 'jenisintervensi_id')); ?>
        <?php 
        $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => '[ii]intervensidet_indikator',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('GetJenisIntervensi') . '",
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
                        'focus' => 'js:function(event, ui ) {
                            return false;
                        }',
                        'select' => 'js:function(event, ui ) {
                            setRincian(ui.item,this);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'required intervensidet_indikator span4', 'placeholder' => 'Intervensi Keperawatan',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogMenyerahkan', 'jsFunction'=>'setDialogRincian(this);'),
                ));
        
        ?>
    
    </td>
    <td style="text-align: center;">
        <?php echo CHtml::activeCheckBox($model, '[ii]intervensidet_aktif', array('rel' => 'tooltip', 'title' => 'Klik untuk mengaktifkan sttaus intervensi', 'onkeypress' => "return $(this).focusNextInputField(event);", "onClick" => 'cek(this);', 'checked' => 'checked')); ?>
    </td>
    <td style="text-align: center;" class="rowbutton">
        <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('rel' => 'tooltip', 'title' => 'Tambah Intervensi', 'class' => 'btn btn-primary', 'onclick' => 'tambahLookup()')); ?>

    </td>
    <td style="text-align: center;" class="rowbutton">

        <?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('rel' => 'tooltip', 'title' => 'Hapus Intervensi', 'class' => 'btn btn-danger', 'onclick' => 'hapusLookup(this)')); ?>
    </td>
</tr>
