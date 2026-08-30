<tr data-row="<?php echo $i ?>">
    <?php // echo CHtml::activeHiddenField($modDetail, '[1]no_row',array('readonly' => true, 'class' => 'no_row',)); ?>
    <td style="text-align: center"><span class="no_urut"><?php echo $i; ?></span></td>      
    <td style="text-align: center">
        <?php 
                $modDetail->nama_pegawai = !empty($modDetail->pegawai_id) ? $modDetail->pegawai->nama_pegawai : "";
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$modDetail,
                    'attribute'=> '[1]nama_pegawai',
                    'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.Yii::app()->createUrl('ActionAutoComplete/getPegawaiPPHP').'",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
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
                                     return false;
                            }',
                        'select'=>'js:function( event, ui ) { 
                                setPegAuto($(this), ui.item);
                                     return false;
                            }',
                    ),
                    'htmlOptions'=>array(
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'class' => 'hurufs-only span3 nama_pegawai required',
                            'placeholder'=>'Ketik Nama PPHP'
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogPegpphp','jsFunction'=>"setDialog(this);"),
            )); 
        ?>
        <?php echo CHtml::activeHiddenField($modDetail, '['.$i.']pegawai_id',array('class'=>'span3 pegawai_id required', 'readonly' => true)) ?>
    </td>  
    <td style="text-align: center">
        <div class="control-group">
            <div class="controls">
                <?php $modDetail->nomorindukpegawai = !empty($modDetail->pegawai_id) ? $modDetail->pegawai->nomorindukpegawai : ""; ?>
                <?php echo CHtml::activeHiddenField($modDetail, '[' . $i . ']pegpphp_id', array('class' => '', 'readonly' => true)); ?>
                <?php echo CHtml::activeTextField($modDetail, '['.$i.']nomorindukpegawai',array('class'=>'span3 nomorindukpegawai', 'readonly' => true)) ?>
                <?php echo CHtml::activeHiddenField($modDetail, '[' . $i . ']status', array('class' => 'status', 'readonly' => true)); ?>
            </div>
        </div>
    </td>
    <td style="text-align: center">
        <?php echo CHtml::activeTextField($modDetail, '['.$i.']jabatan_pphp',array('class'=>'span3 required', 'readonly' => false)) ?>
    </td>    
    <td style="text-align: center;">
        <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', 'javascript:void(0)', array('class' => 'btn btn-primary', 'onclick' => 'tambahBaris()')); ?>
        <?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'hapusBaris(this)', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menghapus baris",'data-placement'=>'left')); ?>
    </td>
</tr>

