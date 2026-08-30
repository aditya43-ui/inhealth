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
            'id' => 'gzpengajuanbahanmkn-search',
            'type' => 'horizontal',
        )); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); 
                ?>
                <div class="control-group">
                    <?php echo Chtml::label("Tgl. Faktur", 'tglfaktur', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        // $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                        // $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
                        $model->tgl_awal = date('d M Y',strtotime($model->tgl_awal));
                        $model->tgl_akhir = date('d M Y',strtotime($model->tgl_akhir));
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <label for="namaPasien" class="control-label">
                        Sampai dengan
                  </label>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Chtml::label("No Faktur", 'nofaktur', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nofaktur', array('class' => 'span4 angkahuruf-only', 'maxlength' => 20, 'autofocus' => true, 'placeholder' => 'No. Faktur')); ?>
                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo Chtml::label("Syarat Bayar", 'syaratbayar_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'syaratbayar_id', CHtml::listData(SyaratbayarM::model()->findAll("syaratbayar_aktif = true ORDER BY syaratbayar_nama ASC"), 'syaratbayar_id', 'syaratbayar_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Chtml::label("Jenis PPh", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'pajak_id', CHtml::listData(PajakM::model()->findAll("pajak_aktif = true AND ispajakpegawai = false ORDER BY pajak_nama ASC"), 'pajak_id', 'pajak_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                    </div>
                </div>
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
            $content = $this->renderPartial('gizi.views.tips.informasiPenerimaanMakanan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>