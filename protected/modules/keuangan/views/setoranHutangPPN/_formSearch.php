<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'setoranhutangppn-src-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)'
    ),
)); ?>
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
                    <?php echo CHtml::label("Tgl. Pembayaran <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $model->tgl_awal = date('Y-m-d');
                        $model->tgl_akhir = date('Y-m-d');
                        ?>
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo CHtml::activeHiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo CHtml::activeHiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("No. Pembayaran", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'nopembayaran', array('placeholder' => 'No. Pembayaran', 'class' => 'span3')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("No. Pendaftaran", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span3')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Jenis Penjamin', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeDropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama'), array(
                            'class' => 'span3', 'multiple' => 'multiple'
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Penjamin", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeDropDownList(
                            $model,
                            'penjamin_id',
                            CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'),
                            array('class' => 'span3', 'multiple' => 'multiple')
                        ); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Jenis PPN", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($model, 'pajak_id', array('class' => 'span3')); ?>
                        <?php echo CHtml::activeTextField($model, 'pajak_nama', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'loadDataPencarian();')
            ); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>