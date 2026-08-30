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
            'id' => 'daftarPasien-form',
            'type' => 'horizontal',
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
            'focus' => '#' . CHtml::activeId($model, 'no_rekam_medik'),
        ));
        ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <label for="namaPasien" class="control-label">
                        <?php echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue' => 0, 'rel' => 'tooltip', 'onClick' => 'cekTanggal()', 'data-original-title' => 'Cek untuk pencarian berdasarkan tanggal')); ?>
                        Tanggal Masuk
                    </label>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'nama_bin', array('placeholder' => 'Nama Panggilan', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                <?php echo $form->dropDownListRow($model, 'caramasuk_id', CHtml::listData($model->getCaraMasukItems(), 'caramasuk_id', 'caramasuk_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php
                echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                    'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => 'AMPasienrawatinapV')),
                        'update' => '#' . CHtml::activeId($model, 'penjamin_id') . ''  //selector to update
                    ),
                ));
                ?>
                <?php echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array(
                'class' => 'btn btn-default',
                'title' => 'Ulang',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            ));
            ?>
            <?php
            $content = $this->renderPartial('../tips/informasi_ambulans', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php
        echo CHtml::hiddenField('pendaftaran_id');
        echo CHtml::hiddenField('pasien_id');
        $this->endWidget();
        ?>
    </div>
</div>