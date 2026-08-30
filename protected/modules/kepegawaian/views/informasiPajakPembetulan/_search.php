<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pegmutasi-r-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nama_pegawai'),
));
$format = new MyFormatter();
?>

<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); 
?>

<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo Chtml::label("Nama Pegawai", 'nama_pegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span4')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Penggajian", 'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tglpenggajian = MyFormatter::formatDateTimeForUser($model->tglpenggajian);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglpenggajian',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'dtPicker3 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label("Tgl. Perbaikan", 'periodegaji', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'periodegaji',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => 'span2',
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Export CSV Non PPh', array('{icon}' => '<i class="entypo-newspaper"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'exportRincianCSV()'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Export CSV PPh', array('{icon}' => '<i class="entypo-newspaper"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'exportRincianCSVPPh()'));
    ?>
    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'cari',
        '2' => 'ulang',
        '3' => 'masterCSV',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>