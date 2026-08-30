<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'kupembgajipeg-t-search',
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($model, 'nokaskeluar'),
        )); ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="control-group">
                    <?php
                    $model->periodegaji = MyFormatter::formatMonthForUser($model->periodegaji);
                    echo $form->labelEx($model, 'Periode Gaji', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        // var_dump($model->attributes); die;
                        $this->widget('MyMonthPicker', array(
                            'model' => $model,
                            'attribute' => 'periodegaji',
                            'options' => array(
                                'dateFormat' => Params::MONTH_FORMAT,
                                'yearRange' => "-100y:+0y",
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'class' => "span2 periode_gaji",
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'onchange' => 'ambilDataGaji();'
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'nopengeluaran', array('placeholder' => 'No. Pengeluaran', 'class' => 'span4')); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'nokaskeluar', array('placeholder' => 'No. Kas Keluar', 'class' => 'span4')); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/InformasiPembayaranGaji/Index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php //echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('InformasiPembayaranGaji/Index'), array('class'=>'btn btn-danger')); 
            ?>
            <?php
            $content = $this->renderPartial('penggajian.views/tips/informasi_penggajianKaryawan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>