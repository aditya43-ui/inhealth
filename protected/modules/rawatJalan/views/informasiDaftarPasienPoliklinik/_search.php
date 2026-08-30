<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'no_pendaftaran'),
    'htmlOptions' => array(),
));
?>
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
                    <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'maxlength' => 20)); ?>
                <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span4', 'placeholder' => 'Nama Pasien', 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span4', 'placeholder' => 'No. Rekam Medik', 'maxlength' => 10)); ?>
                <div class="control-group">
                    <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label for="namaPasien" class="control-label">Spesialis</label>
                    <div class="controls">
                    <?php echo $form->dropDownList($model, 'jeniskasuspenyakit_id', CHtml::listData(JeniskasuspenyakitM::model()->findAll("jeniskasuspenyakit_aktif = true order by jeniskasuspenyakit_nama"), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>

                    </div>
                </div>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">Poliklinik</label>
                    <div class="controls">
                    <?php 
                        $ruangan_pengguna = CHtml::listData(RuanganpemakaiK::model()->findAllByAttributes(array(
                            'loginpemakai_id'=>Yii::app()->user->id
                        )), 'ruangan_id', 'ruangan_id');
                        $crRuangan = new CDbCriteria;
                        $crRuangan->join = 'join ruanganpemakai_k k on k.ruangan_id = t.ruangan_id';
                        $crRuangan->compare('k.loginpemakai_id', Yii::app()->user->id);
                        $crRuangan->compare('t.instalasi_id', Params::INSTALASI_ID_RJ);
                        $crRuangan->order = 't.ruangan_nama';
                        
                        echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll($crRuangan), 'ruangan_id', 'ruangan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>   
                    <?php // echo $form->dropDownList($model, 'ruangan_id', CHtml::listData($model->getRuanganItems(Params::INSTALASI_ID_RJ), 'ruangan_id', 'ruangan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">Status Periksa</label>
                    <div class="controls">
                    <?php echo $form->dropDownList($model, 'statusperiksa', LookupM::getItems('statusperiksa'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>

                    </div>
                </div>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">Dokter Penanggung Jawab</label>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'nama_pegawai', CHtml::listData(DokterV::model()->findAll(), 'nama_pegawai', 'nama_pegawai'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            );
            ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
            ); ?>
            <?php
            $content = $this->renderPartial('../tips/informasiRJ', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>