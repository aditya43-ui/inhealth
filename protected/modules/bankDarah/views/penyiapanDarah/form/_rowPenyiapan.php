<?php

if (!empty($item['tgl_referal'])) {

    //$model = $submodel;
    $model->tgl_referal = MyFormatter::formatDateTimeForUser($item['tgl_referal']);
    $model->tglpelabelan = MyFormatter::formatDateTimeForUser($item['tglpelabelan']);
    $model->tglpenyiapandarah = MyFormatter::formatDateTimeForUser($item['tglpenyiapandarah']);

    $pegReferal = PegawaiM::model()->findByPk($item['peg_referal_id']);
    $pegPelabelan = PegawaiM::model()->findByPk($item['peg_pelabelan']);
    $pegTerima = PegawaiM::model()->findByPk($item['peg_penerimapermintaan_id']);

    if (!empty($pegReferal)) {
        $model->peg_referal_nama = $pegReferal->nama_pegawai;
    }

    if (!empty($pegPelabelan)) {
        $model->peg_pelabelan_nama = $pegPelabelan->nama_pegawai;
    }

    if (!empty($pegTerima)) {
        $model->peg_penerimapermintaan_nama = $pegTerima->nama_pegawai;
    }

} else {
    $model->tgl_referal = $model->tglpelabelan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
}

?>
<tr row-data ='<?php echo $item['ujikompatibilitas_id']; ?>'>
    <td>
        <?php echo $item['nomorbarcode']; ?>
    </td>
    <td><?php
        echo CHtml::activeHiddenField($model, '[detail]['.$item['ujikompatibilitas_id'].']peg_referal_id', array(
            'class'=>'peg_referal_id',
        ));
        $this->widget('MyJuiAutoComplete', array(
                'model'=>$model,
                'attribute'=>'[detail]['.$item['ujikompatibilitas_id'].']peg_referal_nama',
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
                'tombolDialog'=>!$model->isNewRecord ? null : array('idDialog'=>'dialogPetugas', 'jsFunction'=>'setDialogPetugasReferal('.$a.'); return false;'),
            ));
    ?></td>
    <td>
        <div class="tanggal">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => '[detail]['.$item['ujikompatibilitas_id'].']tgl_referal',
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
        echo CHtml::activeHiddenField($model, '[detail]['.$item['ujikompatibilitas_id'].']peg_pelabelan', array(
            'class'=>'peg_pelabelan req',
        ));
        $this->widget('MyJuiAutoComplete', array(
                'model'=>$model,
                'attribute'=>'[detail]['.$item['ujikompatibilitas_id'].']peg_pelabelan_nama',
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
                'tombolDialog'=>!$model->isNewRecord ? null : array('idDialog'=>'dialogPetugas', 'jsFunction'=>'setDialogPetugasLabeling('.$a.'); return false;'),
            ));
    ?></td>
    <td>
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $model,
            'attribute' => '[detail]['.$item['ujikompatibilitas_id'].']tglpelabelan',
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