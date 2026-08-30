<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'searchLaporan',
    'type' => 'horizontal',
)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td width="50%">
            <div class="control-group">
                <label class="control-label">Periode Penggajian</label>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_awal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array(
                            'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:140px;',
                        ),
                    ));
                    ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                <label class="control-label">Sampai dengan</label>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array(
                            'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:140px;',
                        ),
                    ));
                    ?>
                </div>
            </div>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->route),
        array('title' => 'Cari', 'class' => 'btn btn-default')
    );
    echo $this->renderPartial('akuntansi.views.laporanAkuntansi/_tombolPrinoutNonGrafik', true);
    ?>
</div>
<?php $this->endWidget(); ?>