<?php
$i = $modPemeriksaanGoldar->pemeriksaangoldar_id;
?>
<tr row-data ='<?php echo $modPemeriksaanGoldar->pemeriksaangoldar_id ?>' data-pemeriksaangoldar = '<?php echo $modPemeriksaanGoldar->pemeriksaangoldar_id ?>'>
    <td>
        <?php echo $modPemeriksaanGoldar->nomorbarcode; ?>
    </td>
    <td><?php
        echo CHtml::activeHiddenField($model, '[detail]['.$i.']hasilujicocokserasi_id', array(
            'class'=>'hasilujicocokserasi_id',
            'value' => $modPemeriksaanGoldar->hasilujicocokserasi_id
        ));
        echo CHtml::activeHiddenField($model, '[detail]['.$i.']stokkantongdarah_id', array(
            'class'=>'stokkantongdarah_id',
            'value' => $modPemeriksaanGoldar->stokkantongdarah_id
        ));
        echo CHtml::activeHiddenField($model, '[detail]['.$i.']peg_referal_id', array(
            'class'=>'peg_referal_id',
        ));
        $this->widget('MyJuiAutoComplete', array(
                'model'=>$model,
                'attribute'=>'[detail]['.$i.']peg_referal_nama',
                'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.$this->createUrl('AutocompletePetugas').'",
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
                       'minLength' => 3,
                       'focus'=> 'js:function( event, ui ) {
                            $(this).val("");
                            return false;
                        }',
                       'select'=>'js:function( event, ui ) {
                            $(this).val(ui.item.label);
                            $(this).parents("td").find(".peg_referal_id").val(ui.item.pegawai_id);
                            $("#PenyiapandarahT_lamapenyiapan_detik_0").blur();
                            return false;
                        }',
                ),
                'htmlOptions'=>array(
                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                    'class'=>'span3 peg_referal_nama',
                    'disabled'=>!$model->isNewRecord,
                ),
                'tombolDialog'=>!$model->isNewRecord ? null : array('idDialog'=>'dialogPetugas', 'jsFunction'=>'setDialogPetugasReferal('.$i.'); return false;'),
            ));
    ?></td>
    <td>
        <div class="tanggal">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => '[detail]['.$i.']tgl_referal',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array(
                    'disabled' => !$model->isNewRecord,
                    'readonly' => true, 'class' => 'dtPicker3 tgl_tab_penyiapan', 'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>    
        </div>
    </td>
    <td><?php
        echo CHtml::activeHiddenField($model, '[detail]['.$i.']peg_pelabelan', array(
            'class'=>'peg_pelabelan req',
        ));
        $this->widget('MyJuiAutoComplete', array(
                'model'=>$model,
                'attribute'=>'[detail]['.$i.']peg_pelabelan_nama',
                'source'=>'js: function(request, response) {
                               $.ajax({
                                   url: "'.$this->createUrl('AutocompletePetugasLabeling').'",
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
                       'minLength' => 3,
                       'focus'=> 'js:function( event, ui ) {
                            $(this).val("");
                            return false;
                        }',
                       'select'=>'js:function( event, ui ) {
                            $(this).val(ui.item.label);
                            $(this).parents("td").find(".peg_pelabelan").val(ui.item.pegawai_id);
                            $("#PenyiapandarahT_lamapenyiapan_detik_0").blur();
                            return false;
                        }',
                ),
                'htmlOptions'=>array(
                    'disabled'=>!$model->isNewRecord,
                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                    'class'=>'span3 peg_pelabelan_nama',
                ),
                'tombolDialog'=>!$model->isNewRecord ? null : array('idDialog'=>'dialogPetugas', 'jsFunction'=>'setDialogPetugasLabeling('.$i.'); return false;'),
            ));
    ?></td>
    <td>
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $model,
            'attribute' => '[detail]['.$i.']tglpelabelan',
            'mode' => 'datetime',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'maxDate' => 'd',
            ),
            'htmlOptions' => array(
                'disabled' => !$model->isNewRecord,
                'readonly' => true, 'class' => 'dtPicker3 tgl_tab_penyiapan', 'onkeypress' => "return $(this).focusNextInputField(event)"
            ),
        ));
        ?>

    </td>
</tr>