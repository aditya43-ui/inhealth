<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->label($model, 'tgl_awal', array('class' => 'control-label', 'label' => 'Tgl. Kirim ke Keuangan')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                //                                                    'minDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->label($model, 'tgl_akhir', array('class' => 'control-label', 'label' => 'Sampai Dengan')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                //                                                    'minDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
                '#',
                array(
                    'title' => 'Cari',
                    'class' => 'btn btn-primary',
                    'onclick' => 'loadSetoranKasir(); return false;'
                )
            );
            ?>
        </div>
    </div>
</div>

<div class="clear"></div>