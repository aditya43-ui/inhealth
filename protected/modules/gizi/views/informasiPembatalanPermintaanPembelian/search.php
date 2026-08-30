<div id="divSearch-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'informasipembatal-v-search',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($model, 'nofaktur'),
    )); ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Tgl. Permintaan', 'tglpermintaanpembelian', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                    <?php
                    //                                $model->tglpermintaanpembelian = $format->formatDateTimeForUser($model->tglpermintaanpembelian);
                    //                                $this->widget('MyDateTimePicker',array(
                    //                                    'model'=>$model,
                    //                                    'attribute'=>'tglpermintaanpembelian',
                    //                                    'mode'=>'date',
                    //                                    'options'=> array(
                    //                                        'dateFormat'=>Params::DATE_FORMAT,
                    //                                    ),
                    //                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                    //                                    ),
                    //                                )); 
                    //                                $model->tglpermintaanpembelian = $format->formatDateTimeForDb($model->tglpermintaanpembelian);
                    ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'nopermintaan', array('placeholder' => 'No. Permintaan', 'class' => 'span4')); ?>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Tgl. Pembatalan', 'tglbatalpermintaan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tglbatal_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tglbatal_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tglbatal_awal)) ?> - <?php echo date('d M Y', strtotime($model->tglbatal_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tglbatal_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tglbatal_akhir', array('class' => 'end')) ?>
                    </div>
                    <?php
                    //                                $model->tglbatalpermintaan = $format->formatDateTimeForUser($model->tglbatalpermintaan);
                    //                                $this->widget('MyDateTimePicker',array(
                    //                                    'model'=>$model,
                    //                                    'attribute'=>'tglbatalpermintaan',
                    //                                    'mode'=>'date',
                    //                                    'options'=> array(
                    //                                        'dateFormat'=>Params::DATE_FORMAT,
                    //                                    ),
                    //                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                    //                                    ),
                    //                                )); 
                    //                                $model->tglbatalpermintaan = $format->formatDateTimeForDb($model->tglbatalpermintaan);
                    ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'supplier_nama', array('placeholder' => 'Nama Supplier', 'class' => 'span4')); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
        ); ?>
        <?php
        $content = $this->renderPartial($this->path_view . 'tips/informasirenkebbarang', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>