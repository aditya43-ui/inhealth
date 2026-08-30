<?php

$submodel = PenyerahandarahT::model()->findByAttributes(array(
    'penyiapandarah_id'=>$detail->penyiapandarah_id
));
$stok = StokkantongdarahT::model()->findByPk($item->stokkantongdarah_id);
$jenis = JeniskantongdarahM::model()->findByPk($stok->jeniskantongdarah_id);

if (!empty($submodel) && empty($isAjax)) {

    $model = $submodel;
    $model->tglpenyerahan = MyFormatter::formatDateTimeForUser($model->tglpenyerahan);
    $model->tglverifikasi = MyFormatter::formatDateTimeForUser($model->tglverifikasi);

    $pegPenyerahkan = PegawaiM::model()->findByPk($model->peg_ygmenyerahkan_id);
    $pegVerifikator = PegawaiM::model()->findByPk($model->peg_vetifikator_id);
    $pegTransporter = PegawaiM::model()->findByPk($model->peg_transporter_id);

    if (!empty($pegPenyerahkan)) {
        $model->peg_ygmenyerahkan_nama = $pegPenyerahkan->nama_pegawai;
    }

    if (!empty($pegVerifikator)) {
        $model->peg_vetifikator_nama = $pegVerifikator->nama_pegawai;
    }

    if (!empty($pegTransporter)) {
        $model->peg_transporter_nama = $pegTransporter->nama_pegawai;
    }

} else {
    $model->tglpenyerahan = $model->tglverifikasi = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
}

?>
<tr>
    <td>
        <?php echo $item->nomorbarcode; ?>
    </td>
    <td><?php
        echo CHtml::activeHiddenField($model, '[detail]['.$detail->penyiapandarah_id.']peg_vetifikator_id', array(
            'class'=>'peg_vetifikator_id req',
        ));
        $this->widget('MyJuiAutoComplete', array(
                'model'=>$model,
                'attribute'=>'[detail]['.$detail->penyiapandarah_id.']peg_vetifikator_nama',
                'source'=>'js: function(request, response) {
                               $.ajax({
                                   url: "'.$this->createUrl('AutocompletePetugasVerifikator').'",
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
                            $(this).val(ui.item.nama_pegawai);
                            $(this).parents("td").find(".peg_vetifikator_id").val(ui.item.pegawai_id);
                            return false;
                        }',
                ),
                'htmlOptions'=>array(
                    'disabled'=>!$model->isNewRecord,
                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                    'class'=>'span3 peg_vetifikator_nama',
                ),
                'tombolDialog'=>!$model->isNewRecord ? null : array('idDialog'=>'dialogPetugasVerifikator', 'jsFunction'=>'setDialogPetugas('.$row.', \'dialogPetugasVerifikator\'); return false;'),
            ));
    ?>
    </td>
    <td>
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $model,
            'attribute' => '[detail]['.$detail->penyiapandarah_id.']tglverifikasi',
            'mode' => 'datetime',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'maxDate' => 'd',
            ),
            'htmlOptions' => array(
                'disabled' => !$model->isNewRecord,
                'readonly' => true, 'class' => 'dtPicker3 tgl_tab_verifikasi', 'onkeypress' => "return $(this).focusNextInputField(event)"
            ),
        ));
        ?>

    </td>
    <td><?php
        echo CHtml::activeHiddenField($model, '[detail]['.$detail->penyiapandarah_id.']peg_ygmenyerahkan_id', array(
            'class'=>'peg_ygmenyerahkan_id req',
        ));
        $this->widget('MyJuiAutoComplete', array(
                'model'=>$model,
                'attribute'=>'[detail]['.$detail->penyiapandarah_id.']peg_ygmenyerahkan_nama',
                'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.$this->createUrl('AutocompletePetugasMenyerahkan').'",
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
                            $(this).val(ui.item.nama_pegawai);
                            $(this).parents("td").find(".peg_ygmenyerahkan_id").val(ui.item.pegawai_id);
                            return false;
                        }',
                ),
                'htmlOptions'=>array(
                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                    'class'=>'span3 peg_ygmenyerahkan_nama',
                    'disabled'=>!$model->isNewRecord,
                ),
                'tombolDialog'=>!$model->isNewRecord ? null : array('idDialog'=>'dialogPetugasMenyerahkan', 'jsFunction'=>'setDialogPetugas('.$row.', \'dialogPetugasMenyerahkan\'); return false;'),
            ));
    ?></td>
    <td>
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $model,
            'attribute' => '[detail]['.$detail->penyiapandarah_id.']tglpenyerahan',
            'mode' => 'datetime',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'maxDate' => 'd',
            ),
            'htmlOptions' => array(
                'disabled' => !$model->isNewRecord,
                'readonly' => true, 'class' => 'dtPicker3 tgl_tab_verifikasi', 'onkeypress' => "return $(this).focusNextInputField(event)"
            ),
        ));
        ?>
    </td>
    <td><?php
        echo CHtml::activeHiddenField($model, '[detail]['.$detail->penyiapandarah_id.']peg_transporter_id', array(
            'class'=>'peg_transporter_id req',
        ));
        $this->widget('MyJuiAutoComplete', array(
                'model'=>$model,
                'attribute'=>'[detail]['.$detail->penyiapandarah_id.']peg_transporter_nama',
                'source'=>'js: function(request, response) {
                               $.ajax({
                                    url: "'.$this->createUrl('AutocompletePetugasTransporter').'",
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
                            $(this).val(ui.item.nama_pegawai);
                            $(this).parents("td").find(".peg_transporter_id").val(ui.item.pegawai_id);
                            return false;
                        }',
                ),
                'htmlOptions'=>array(
                    'disabled'=>!$model->isNewRecord,
                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                    'class'=>'span3 peg_transporter_nama',
                ),
                'tombolDialog'=>!$model->isNewRecord ? null : array('idDialog'=>'dialogPetugasTransporter', 'jsFunction'=>'setDialogPetugas('.$row.', \'dialogPetugasTransporter\'); return false;'),
            ));
    ?>
    </td>
</tr>