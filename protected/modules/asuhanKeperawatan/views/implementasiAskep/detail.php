<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pembayaran-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#ASPendaftaranT_no_pendaftaran',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Detail <b>Implementasi Keperawatan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Rencana</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="white-container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($modRencana, 'no_rencana', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    if (!empty($modRencana->rencanaaskep_id)) {
                                        echo CHtml::hiddenField('ASRencanaaskepT[iskeperawatan]', $modRencana->iskeperawatan, array('readonly' => true));
                                        echo CHtml::hiddenField('ASRencanaaskepT[rencanaaskep_id]', $modRencana->rencanaaskep_id, array('readonly' => true));
                                        echo CHtml::textField('ASRencanaaskepT[no_rencana]', $modRencana->no_rencana, array('readonly' => true));
                                    } else {
                                        echo CHtml::hiddenField('ASRencanaaskepT[iskeperawatan]', $modRencana->iskeperawatan, array('readonly' => true));
                                        echo CHtml::hiddenField('ASRencanaaskepT[rencanaaskep_id]', $modRencana->rencanaaskep_id, array('readonly' => true));
                                        $this->widget('MyJuiAutoComplete', array(
                                            'name' => 'ASRencanaaskepT[no_rencana]',
                                            'value' => $modRencana->no_rencana,
                                            'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . $this->createUrl('AutocompleteRencana') . '",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                           instalasiId: $("#ASPengkajianaskepT_instalasi_id").val(),
                                                       },
                                                       success: function (data) {
                                                               response(data);
                                                       }
                                                   })
                                                }',
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 3,
                                                'focus' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
                                                'select' => 'js:function( event, ui ) {
												cekRencanaId(ui.item.rencanaaskep_id);
                                                return false;
                                            }',
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogRencanaKep', 'idTombol' => 'tombolRencanaDialog'),
                                            'htmlOptions' => array(
                                                'class' => 'span3',
                                                'placeholder' => 'No. Rencana', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                            ),
                                        ));
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('Nama Pegawai', 'nama_pegawai', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($modRencana, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id')) ?>
                                    <?php echo CHtml::textField('ASRencanaaskepT[nama_pegawai]', $modRencana->nama_pegawai, array('readonly' => true)); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo $form->labelEx($modRencana, 'rencanaaskep_tgl', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php echo CHtml::textField('ASRencanaaskepT[rencanaaskep_tgl]', $modRencana->rencanaaskep_tgl, array('readonly' => true, 'class' => 'span3')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Identitas Pasien
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_ringkasDataPasien', array('model' => $model, 'modPasien' => $modPasien)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Implementasi</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="white-container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php // echo CHtml::activeHiddenField($model, 'anamesa_id',array('readonly'=>true, 'class'=>'span1')); 
                                ?>
                                <?php // echo CHtml::activeHiddenField($model, 'pemeriksaanfisik_id',array('readonly'=>true, 'class'=>'span1')); 
                                ?>
                                <?php echo CHtml::activeLabel($model, 'no_implementasi', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'no_implementasi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'implementasiaskep_tgl', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'implementasiaskep_tgl',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    ));
                                    ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo CHtml::label('Nama Pegawai', 'nama_pegawai', array('required' => true, 'class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true)) ?>
                                    <?php
                                    if (!empty($model->pegawai_id)) {
                                        $cekpegawai = PegawaiM::model()->findByPk($model->pegawai_id);
                                        $model->nama_pegawai = !empty($cekpegawai->namaLengkap) ? $cekpegawai->namaLengkap : '';
                                    }
                                    echo $form->textField($model, 'nama_pegawai', array('required' => true, 'readonly' => true));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Implementasi Keperawatan
                </div>
            </div>
            <div class="panel-body">
                <table id="table-rencana" class="table table-striped table-bordered table-condensed">
                    <thead>
                        <th>Diagnosa Keperawatan</th>
                        <th>Luaran Keperawatan</th>
                        <th>Intervensi</th>
                        <th>Implementasi</th>
                    </thead>
                    <tbody>
                        <?php
                        $trImplementasi = $this->renderPartial($this->path_view . '_rowImplementasiDetail', array('modDetail' => $modDetail, 'modPilih' => $modPilih), true);
                        echo $trImplementasi;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$this->renderPartial('_jsFunctions', array(
    'model' => $model,
    'modDetail' => $modDetail,
    'modRencana' => $modRencana,
    'form' => $form
));
?>
<script>
    $(document).ready(function() {
        $("#pembayaran-form").find('input,select,textarea').each(function() {
            $(this).attr('disabled', true);
        });
        $("#pembayaran-form .add-on").remove();
    });
</script>