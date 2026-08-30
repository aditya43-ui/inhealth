<div id="divSearch-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'rencana-t-search',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($model, 'noperencnaan'),
    )); ?>
    <!--fieldset class="box"-->
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Tgl. Retur", 'tglReturPembelian', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'noretur', array('placeholder' => 'No. Retur', 'class' => 'numberOnly')); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'instalasi_nama', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $model,
                        'instalasi_nama',
                        CHtml::listData(GFInformasireturpembelianV::model()->getInstalasi('instalasi_id'), 'instalasi_nama', 'instalasi_nama'),
                        array(
                            'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'empty' => '-- Pilih --', 'style' => 'width:130px;'
                        )
                    ); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Tgl. Terima Faktur", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tglterimafaktur)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tglfaktur)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tglterimafaktur)) ?> - <?php echo date('d M Y', strtotime($model->tglfaktur)) ?></span>
                        <?php echo $form->hiddenField($model, 'tglterimafaktur', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tglfaktur', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'nofaktur', array('placeholder' => 'No. Faktur', 'class' => 'numberOnly')); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'ruangan_nama', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $model,
                        'ruangan_nama',
                        CHtml::listData(GFInformasireturpembelianV::model()->getRuangan('ruangan_id'), 'ruangan_nama', 'ruangan_nama'),
                        array(
                            'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'empty' => '-- Pilih --', 'style' => 'width:130px;'
                        )
                    ); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
        ); ?>
        <?php
        $content = $this->renderPartial('gudangFarmasi.views/tips/informasi_gudangfarmasi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <!--</fieldset>-->
    <?php $this->endWidget(); ?>
</div>