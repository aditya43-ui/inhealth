<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Evaluasi Identifikasi Resiko </strong></div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'penelitian-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);'),
            'focus' => '#',
        ));
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', '<strong>Berhasil </strong> Data berhasil disimpan');
        }
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <div class="row-fluid">
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label('Periode Manajemen Resiko <span class="required">*</span>', 'perioderegister_nama', ['class'=>'span3' ]) ?>              
                    <div class="controls">
                        <?php
                        if (!empty($model->identifikasiresiko_id)) {
                            echo CHtml::textField('perioderegister_nama', $model->periode->nama_perioderiskregister, array('class' => 'span3 required', 'readonly' => true));
                        } else {
                            echo $form->dropDownList($model, 'perioderiskregister_id', CHtml::listData($model->getPeriodeResikoItems(), 'perioderiskregister_id', 'nama_perioderiskregister'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            ));
                        }
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label(' Jenis Risk Management <span class="required">*</span>', 'jenisriskmanajemen', ['class'=>'span3']) ?>
                    <div class="controls">
                        <?= $form->dropDownList($model, 'jenisriskmanajemen', LookupM::getItems("jenisriskmanajemen"), array('class' => 'span3 required', 'empty' => '-- Pilih --'));?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label('Ruangan <span class="required">*</span>', '', array('class' => 'span3 ')) ?>
                    <div class="controls">
                        <?php
                            echo $form->hiddenField($model, 'ruangan_id', array('class' => 'span3 required'));

                        if ((Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KEPERAWATAN_YANKES) || (Yii::app()->user->getState('ruangan_id') == $model->ruangan_id)) {
                            $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'ruangan_nama',
                            'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('AutoCompleteRuangan') . '",
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
                                'class' => 'required',
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function(event, ui ) {
                                                return false;
                                            }',
                                'select' => 'js:function(event, ui ) {
                                                $("#YKMIdentifikasiresikoT_ruangan_id").val(ui.item.ruangan_id);
                                                $("#YKMIdentifikasiresikoT_ruangan_nama").val(ui.item.ruangan_nama);
                                                return false;
                                            }',
                            ),
                            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikan nama ruangan',
                                'onblur' => 'if($(this).val() == ""){ $("#YKMIdentifikasiresikoT_ruangan_id").val(""); }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogRuangan'),
                        ));
                        } else {
                            echo $form->textField($model, 'ruangan_nama', array('class' => 'span3 required')); 
                        }
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Unit Kerja <span class="required">*</span>', '', array('class' => 'span3')) ?>
                    <div class="controls">
                        <?php
                        echo $form->hiddenField($model, 'unitkerja_id', array('class' => 'span3 required'));
                        if ((Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KEPERAWATAN_YANKES) || (Yii::app()->user->getState('ruangan_id') == $model->ruangan_id)) {
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'namaunitkerja',
                                'source' => 'js: function(request, response) {
                                                $.ajax({
                                                    url: "' . $this->createUrl('AutocompleteUnitKerjaRuangan') . '",
                                                    dataType: "json",
                                                    data: {
                                                        term: request.term,
                                                        ruangan_id: $("#YKMIdentifikasiresikoT_ruangan_id").val()
                                                    },
                                                    success: function (data) {
                                                        response(data);
                                                    }
                                                })
                                            }',
                                'options' => array(
                                    'class' => 'required',
                                    'showAnim' => 'fold',
                                    'minLength' => 3,
                                    'focus' => 'js:function(event, ui ) {
                                                    return false;
                                                }',
                                    'select' => 'js:function(event, ui ) {
                                                    $("#YKMIdentifikasiresikoT_unitkerja_id").val(ui.item.unitkerja_id);
                                                    $(this).val(ui.item.label);
                                                    return false;
                                                }',
                                ),
                                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikan nama ruangan',
                                    'onblur' => 'if($(this).val() == ""){ $("#YKMIdentifikasiresikoT_unitkerja_id").val(""); }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogUnitKerja'),
                            ));
                        } else {
                            echo $form->textField($model, 'namaunitkerja', array('class' => 'span3 required')); 
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="panel panel-success ">
                <div class="panel-heading">
                    <div class="panel-title"><b>Identifikasi Risiko</b></div>
                </div>
                <div class="panel-body">
                    <?php
                    echo $this->renderPartial('_formIdentifikasiResiko', array(
                        'model' => $model,
                        'form' => $form,
                    ));
                    ?>
                </div>
            </div>
            <div class="panel panel-success ">
                <div class="panel-heading">
                    <div class="panel-title"><b>Rating Analisis</b></div>
                </div>
                <div class="panel-body">
                    <?php
                    echo $this->renderPartial('_formAnalisis', array(
                        'model' => $model,
                        'form' => $form,
                    ));
                    ?>
                </div>
            </div>
            <div class="panel panel-success ">
                <div class="panel-heading">
                    <div class="panel-title"><b>Evaluasi / Pengolahan Risiko</b></div>
                </div>
                <div class="panel-body">
                    <?php
                    echo $this->renderPartial('_formEvaluasi', array(
                        'modEvaluasi' => $modEvaluasi,
                        'form' => $form,
                    ));
                    ?>
                </div>
            </div>


        </div>
        <div class="form-actions">
            <?php
            $disabled = (isset($_GET['sukses'])) ? true : false;
            ?>

            <?php
            if ((Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KEPERAWATAN_YANKES) || (Yii::app()->user->getState('ruangan_id') == $model->ruangan_id)) {
                if (!isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary', 'onclick' => 'cekForm(); return false;'));
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary', 'type' => 'submit', 'disabled' => true));
                }
            }
            ?>
            &nbsp;

        </div>
    </div>
    <?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
    <?php $this->endWidget(); ?>
</div>
<script>
    function cekForm(){
        if (requiredCheck($("#penelitian-t-form"))){
            $("#penelitian-t-form").submit(); 
            window.parent.$("#dialogEvaluasi").dialog('close');
        }
    }
</script>