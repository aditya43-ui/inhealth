<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gjpesangonpeg-t-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nomorindukpegawai'),
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="control-group">
                    <?php echo $form->label($model, 'Periode Gaji', array('class' => 'control-label inline')); ?>
                    <div class="controls">
                        <?php
                        // var_dump($model->attributes); die;
                        $model->periodegaji = MyFormatter::formatMonthForUser($model->periodegaji);
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
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->label($model, 'nopesangon', array('class' => 'control-label inline', 'label' => 'No. Pengajuan')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nopesangon', array('placeholder' => 'No. Pengajuan', 'class' => 'span3')); ?>
                    </div>
                </div>
                <?php // echo $form->dropDownListRow($model,'kategoripegawaiasal',LookupM::getItems('kategoriasalpegawai'), 
                //                        array(	'empty'=>'-- Pilih --','class'=>'span3', 
                //								'onkeyup'=>"return $(this).focusNextInputField(event)")); 
                ?>
                <?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('placeholder' => 'Nomor Induk Pegawai', 'class' => 'span3')); ?>
                <?php echo $form->textFieldRow($model, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span3')); ?>
            </div>
            <div class="col-sm-6">

                <div class="control-group">
                    <?php echo $form->label($model, 'kelompokpegawai_id', array('class' => 'control-label inline', 'label' => 'Kelompok Pegawai')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownlist($model, 'kelompokpegawai_id', CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true order by kelompokpegawai_id'), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($model, 'jabatan_id', JabatanM::jabatanList(), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
                <?php echo $form->dropDownListRow($model, 'status', array(1 => 'BELUM DIBAYAR', 2 => 'SUDAH DIBAYAR'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                <?php //echo $form->textFieldRow($model,'pesangonpeg_id',array('class'=>'span5')); 
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/PenggajianpegT/Informasi'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php //echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('PenggajianpegT/Informasi'), array('class'=>'btn btn-danger')); 
            ?>
            <?php
            $content = $this->renderPartial('penggajian.views/tips/informasi_penggajianKaryawan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>