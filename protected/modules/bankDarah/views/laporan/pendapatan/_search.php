<?php
$format = new MyFormatter();
?>
<div class="search-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'laporan-search',
        'type' => 'horizontal',
    )); ?>
    <fieldset class="box">
        <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
        <div class="row">
            <div class="col-sm-4">
                <?php echo CHtml::hiddenField('type', '', array()); ?>
                <?php echo CHtml::label('Tgl. Tindakan', 'tgl_tindakan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('class' => 'span2', 'onchange' => 'ubahJnsPeriode();')); ?>
                </div>
            </div>
            <div class="col-sm-4">
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
            </div>
            <div class="col-sm-4">
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
                array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>

<script type="text/javascript">
    function ubahJnsPeriode() {
        var obj = $("#<?php echo CHtml::activeId($model, 'jns_periode') ?>");
        if (obj.val() == 'hari') {
            $('.hari').show();
            $('.bulan').hide();
            $('.tahun').hide();
        } else if (obj.val() == 'bulan') {
            $('.hari').hide();
            $('.bulan').show();
            $('.tahun').hide();
        } else if (obj.val() == 'tahun') {
            $('.hari').hide();
            $('.bulan').hide();
            $('.tahun').show();
        }
    }
</script>