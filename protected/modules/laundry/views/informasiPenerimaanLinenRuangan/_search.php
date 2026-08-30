<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'penerimaanlinen-info-search',
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($modPengirimanlinen, 'nopengirimanlinen'),
        ));
        ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modPengirimanlinen->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modPengirimanlinen->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($modPengirimanlinen->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modPengirimanlinen->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($modPengirimanlinen, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($modPengirimanlinen, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPengirimanlinen, 'nopengirimanlinen', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPengirimanlinen, 'nopengirimanlinen', array('placeholder' => 'No. Pengiriman', 'class' => 'span4', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->bareRoute, array(
                'class' => 'btn btn-default',
                'title' => 'Ulang',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) ' . $this->hardRefreshScript . ';}); return false;'
            ));
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips.informasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>