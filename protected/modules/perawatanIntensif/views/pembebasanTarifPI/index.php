<?php
$this->breadcrumbs = array(
    'Pembebasan Tarif'
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pembebasan Tarif</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pembebasantarif-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return requiredCheck(this);'
            ),
            'focus' => '#',
        )); ?>

        <?php $this->renderPartial('_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($model); ?>

        <?php echo $form->hiddenField($model, 'pegawai_id', array('class' => 'span3', 'readonly' => true)); ?>


        <?php //echo $form->textFieldRow($model,'tindakanpelayanan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'komponentarif_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'jmlpembebasan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Form Pembebasan Tarif
                </div>
            </div>
            <div class="panel-body">
                <table>
                    <thead>
                        <tr>
                            <th>
                                <div class="control-group">
                                    <?php $model->pegawai_nama = (!empty($model->pegawai_id)) ? PegawaiM::model()->findByPk($model->pegawai_id)->nama_pegawai : ''; ?>
                                    <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label required')); ?>
                                    <div class="controls">
                                        <?php $this->widget('MyJuiAutoComplete', array(
                                            'model' => $model,
                                            'attribute' => 'pegawai_nama',
                                            'source' => 'js: function(request, response) {
                                                               $.ajax({
                                                                   url: "' . Yii::app()->createUrl('ActionAutoComplete/DaftarDokter') . '",
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
                                                        $(this).val( ui.item.label);
                                                        return false;
                                                    }',
                                                'select' => 'js:function( event, ui ) {
                                                        $("#' . CHtml::activeId($model, 'pegawai_id') . '").val(ui.item.value);
                                                        return false;
                                                    }',

                                            ),
                                            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'),
                                            'tombolDialog' => array('idDialog' => 'dialogDokter', 'idTombol' => 'tombolDialogDokter'),
                                        )); ?>
                                    </div>
                                </div>
                            </th>
                            <th>
                                <?php //echo $form->textFieldRow($model,'tglpembebasan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                                ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'tglpembebasan', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $model,
                                            'attribute' => 'tglpembebasan',
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2-5'),
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                </table>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pembebasan Tarif Pasien</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive" id="divTarifPasien">
                        <table id="tblTindakanPasien" class="table table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th>Pembebasan Tarif Pasien</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => (isset($_GET['sukses'])) ? true : false)
            ); ?>
            <?php /*echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/'.pembebasantarifT.'/admin'), 
                    array('class' => 'btn btn-default',
                          'onclick'=>'window.parent.myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); */ ?>
            <?php
            $content = $this->renderPartial('../tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Dokter',
        'autoOpen' => false,
        'resizable' => true,
        'modal' => true,
    ),
));

$criteria = new CDbCriteria();
$criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
$criteria->order = 'nama_pegawai';
$models = DokterV::model()->findAll($criteria);
$dataProvider = new CActiveDataProvider('DokterV', array(
    'criteria' => $criteria,
));

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'riobat-alkes-m-grid',
    'dataProvider' => $dataProvider,
    //'filter'=>$moObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPasien",
                                    "onClick" => "
                                        $(\"#dialogDokter\").dialog(\"close\");
                                        $(\"#' . CHtml::activeId($model, 'pegawai_nama') . '\").val(\"$data->nama_pegawai\");
                                        $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                                    "))',
        ),
        array(
            'header' => 'Nama Dokter',
            'value' => '$data->gelardepan." ".$data->nama_pegawai',
        ),
    )
));

$this->endWidget('ext.bootstrap.widgets.BootGridView');
?>
</div>
</div>

<script type="text/javascript">
    $('form').bind('click keyup select change', function(event) {
        cekDisabled(this);
    });
    $(document).on('click keyup select change', function() {
        cekDisabled('form');
    });
    cekDisabled('form');
</script>