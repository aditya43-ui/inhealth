<style>
    .form-horizontal .radio>label,
    .form-horizontal .checkbox>label {
        float: left !important;
        margin-left: 5px !important;
        padding: 0 !important;
    }

    .form-horizontal .radio>input,
    .form-horizontal .checkbox>input {
        float: left !important;
        margin-top: 2px !important;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="search-form">
            <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'type' => 'horizontal',
                'id' => 'searchLaporan',
                'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
            $format = new MyFormatter();
            ?>
            <style>
                label.checkbox {
                    width: 150px;
                    display: inline-block;
                }
            </style>
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::hiddenField('type', ''); ?>
                        <?php echo CHtml::label('Periode Laporan', 'tglpelayanan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('class' => 'span2', 'onchange' => 'ubahJnsPeriode();')); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Jenis Obat</label>
                        <div class="controls">
                            <?php
                            echo '<table><tr>      
                    <td>' . CHtml::checkBox('checkAllJenis', true, array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked'
                            )) . '<label for="checkAllJenis">Pilih Semua</label><td></tr></table>
                    <table id="tindak_lanjut_tbl">
<tr>
<td>' .
                                $form->CheckBoxList($model, 'jenisobatalkes_id', CHtml::listData($model->getJenisobatalkesItems(), 'jenisobatalkes_id', 'jenisobatalkes_nama'))
                                . '</td>
</tr>
</table>';
                            ?>
                        </div>
                    </div>

                    <?php
                    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    //     'id' => 'kunjungan',
                    //     'slide' => true,
                    //     'content' => array(
                    //         'content2' => array(
                    //             'header' => 'Berdasarkan Jenis Obat',
                    //             'isi' => '<table><tr>      
                    //                             <td>' . CHtml::checkBox('checkAllJenis', true, array(
                    //                 'onkeypress' => "return $(this).focusNextInputField(event)",
                    //                 'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked'
                    //             )) . '<label for="checkAllJenis">Pilih Semua</label><td></tr></table>
                    //                             <table id="tindak_lanjut_tbl">
                    // 	<tr>
                    // 		<td>' .
                    //                 $form->CheckBoxList($model, 'jenisobatalkes_id', CHtml::listData($model->getJenisobatalkesItems(), 'jenisobatalkes_id', 'jenisobatalkes_nama'))
                    //                 . '</td>
                    // 	</tr>
                    // 	</table>',
                    //             'active' => true,
                    //         ),
                    //     ),
                    //     //                                    'htmlOptions'=>array('class'=>'aw',)
                    // ));
                    ?>
                </div>
                <div class="col-sm-6">
                    <div class='control-group hari'>
                        <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                        </div>

                    </div>
                    <div class='control-group bulan'>
                        <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
                            <?php
                            $this->widget('MyMonthPicker', array(
                                'model' => $model,
                                'attribute' => 'bln_awal',
                                'options' => array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
                        </div>
                    </div>
                    <div class='control-group tahun'>
                        <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                    <div class='control-group hari'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                        </div>
                    </div>
                    <div class='control-group bulan'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->bln_akhir = $format->formatMonthForUser($model->bln_akhir); ?>
                            <?php
                            $this->widget('MyMonthPicker', array(
                                'model' => $model,
                                'attribute' => 'bln_akhir',
                                'options' => array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php $model->bln_akhir = $format->formatMonthForDb($model->bln_akhir); ?>
                        </div>
                    </div>
                    <div class='control-group tahun'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                    array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                ); ?>
                <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '') . '";}); return false;'
                    )
                ); ?>
            </div>
        </div>
    </div>

    <?php
    $this->endWidget();
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    ?>
    <?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
    ?>
    <script>
        function checkAll() {
            if ($('#checkAllJenis').is(':checked')) {
                $('#searchLaporan input[name*="jenisobatalkes_id"]').each(function() {
                    $(this).attr('checked', true);
                });
            } else {
                $('#searchLaporan input[name*="jenisobatalkes_id"]').each(function() {
                    $(this).removeAttr('checked');
                });
            }
        }

        function konfirmasi() {
            location.reload();
        }
    </script>
    <?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>