<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'terdugatb-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    // 'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'),
    'focus' => '#RKAnamnesaT_keluhanutama_annoninput .maininput',
));
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row">
    <?php $this->renderPartial('_row_1', array('form' => $form, 'modPendaftaran' => $modPendaftaran, 'modBalance' => $modBalance, 'jenis' => $jenis)); ?>
    <br>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                Form Balance Cairan
            </div>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <div class="col-sm-6">
                    <div class="control-group ">
                        <label class="control-label">Tanggal</label>
                        <div class="controls">
                            <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modBalance,
                                    'attribute' => 'tanggal',
                                    'value' => null,
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        // 'minDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => false,
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span4 tanggal',
                                    ),
                                ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <label class="control-label">Jam</label>
                        <div class="controls">
                            <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modBalance,
                                    'attribute' => 'jam',
                                    'value' => null,
                                    'mode' => 'time',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        // 'minDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => false,
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span4 jam',
                                    ),
                                ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label">Petugas Pengisi</label>
                        <div class="controls">
                            <?php
                                echo $form->hiddenField($modBalance, 'pegawai_id',['class'=>'pegawai_id']);
                                $this->widget('MyJuiAutoComplete', array(
                                    'model'=>$modBalance,
                                    'attribute' => 'pegawai_nama',
                                    'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('/actionAutoComplete/dropPetugasRuangan') . '",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
                                            ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
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
                                            $(this).val("");
                                            return false;
                                        }',
                                        'select' => 'js:function( event, ui ) {
                                            $(".pegawai_id").val(ui.item.pegawai_id);
                                            $(".pegawai_nama").val(ui.item.namaLengkap);                                
                                            return false;
                                        }',
                                    ),
                                    'htmlOptions' => array(
                                        'onkeyup' => "return $(this).focusNextInputField(event)",
                                        'class'=>'span4 pegawai_nama',
                                        'disabled' => $jenis == 'lihat',
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPetugasPengisi'),
                                ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Keterangan", ' ', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textArea($modBalance, 'keterangan', array('rows'=>4, 'disabled' => false, 'class'=>'lainlain span4')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->renderPartial('_row_2', array('form' => $form, 'modPendaftaran' => $modPendaftaran, 'modBalance' => $modBalance, 'jenis' => $jenis)); ?>
            <?php $this->renderPartial('_row_3', array('form' => $form, 'modPendaftaran' => $modPendaftaran, 'modBalance' => $modBalance, 'jenis' => $jenis)); ?>
            <?php
                if(($jenis == 'lihat')){
                    echo CHtml::link('Kembali', $this->createUrl('index', array('pendaftaran_id' => $_GET['pendaftaran_id'])), array(
                        'class'=>'btn btn-danger'
                    )); 
                } else {
            ?>
            <?php
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                        array('title' => 'Simpan', 'class' => 'btn btn-success', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                    );
            ?>
            <?php
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl('jurnalRekPenjamin/admin'),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-warning',
                            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    );
                }
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<!-- open dialog perawat -->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogPetugasPengisi',
        'options' => array(
            'title' => 'Daftar ' . Params::setLabelKepegawaianKonfig(),
            'autoOpen' => false,
            'modal' => true,
            'width' => 700,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $modPeg = new PegawaiM('search');
    $modPeg->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPeg->pegawai_aktif = true;
    $modPeg->cek_array_or_not = true;
    $modPeg->array_1 = 2;
    $modPeg->array_2 = 20;
    // $modPeg->unsetAttributes();
    if (isset($_GET['PegawaiM'])) {
        $modPeg->attributes = $_GET['PegawaiM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'perawat-m-grid',
        'dataProvider' => $modPeg->search(),
        'filter' => $modPeg,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",array("class"=>"btn-small", 
                "id" => "selectperawat",
                "onClick" => "
                    $(\'.pegawai_id\').val($data->pegawai_id);
                    $(\'.pegawai_nama\').val(\'$data->namaLengkap\');
                    $(\'#dialogPetugasPengisi\').dialog(\'close\');
                    return false;"
                    ))',
            ),
            'nomorindukpegawai',
            [
                'header'=>'Nama',
                'name'=>'nama_pegawai',
                'value'=>'$data->namaLengkap'
            ],
            
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
?>