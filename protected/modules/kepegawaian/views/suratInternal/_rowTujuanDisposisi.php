<?php
    $pegawai_id = (isset($modDokter) && (!empty($modDokter->pegawai_id))? $modDokter->pegawai_id:"");
    $pegawai_nama = (isset($modDokter) && (!empty($modDokter->pegawai))? $modDokter->pegawai->namaLengkap:"");
?>
<tr class="tr_pegawai">
    <td width="250px">
        <?php echo CHtml::hiddenField('pegawai_id',$pegawai_id,array('class'=>'pegawai_id')); ?>
        <?php $this->widget('MyJuiAutoComplete',array(
                    'id'=>'pegawai_nama',
                    'name'=>'pegawai_nama',
                    'value'=>$pegawai_nama,
                    'source'=>'js: function(request, response) {
                            $.ajax({
                                url: "'.Yii::app()->controller->createUrl('AutocompleteDokter').'",
                                dataType: "json",
                                data: {
                                    term: request.term
                                },
                                success: function (data) {
                                        response(data);
                                }
                            })
                        }',
                    'options'=>array(
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                       'select'=>'js:function( event, ui ) {
                            setPegawai($(this), ui.item);
                            return false;
                        }',

                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogPegawai','jsFunction'=>"setDialogPegawai(this);"),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'pegawai_nama span3','required'=>true),
        )); ?>    
    </td>
    <td>
        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick'=>'tambahPegawai();', 'class' => 'btn btn-primary')); ?>
        <?php echo CHtml::htmlButton('<i class="icon-minus icon-white"></i>', array('onclick'=>'hapusPegawai(this);', 'class' => 'btn btn-danger')); ?>
    </td>
</tr>