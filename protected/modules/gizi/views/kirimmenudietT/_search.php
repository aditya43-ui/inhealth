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
            'id' => 'gzpesanmenudiet-t-search',
            'type' => 'horizontal',
        )); ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo Chtml::label('Tgl. Kirim Menu', 'tglkirimmenu', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        //$model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                        //$model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
                        $model->tgl_awal = date('d M Y', strtotime($model->tgl_awal));
                        $model->tgl_akhir = date('d M Y', strtotime($model->tgl_akhir));
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2'),
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
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2'),
                        )); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo Chtml::label('No. Kirim Menu', 'nokirimmenu', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nokirimmenu', array('class' => 'span4 angkahuruf-only', 'maxlength' => 20, 'autofocus' => true, 'placeholder' => 'No. kirim menu')); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo Chtml::label('No. Pesan Menu', 'nokirimmenu', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pesan_menu', array('class' => 'span4 angkahuruf-only', 'maxlength' => 20, 'autofocus' => true, 'placeholder' => 'No. Pesan Menu')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php
                if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
                    echo $form->dropDownListRow(
                        $model,
                        'instalasi_id',
                        Chtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE ORDER BY instalasi_nama ASC"), 'instalasi_id', 'instalasi_nama'),
                        array(
                            'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/ActionDynamic/GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($model))),
                                'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
                            )
                        )
                    );

                ?>
                    <div class="control-group">
                        <?php echo Chtml::label("Ruangan", 'ruangan_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'ruangan_id', array(), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                <?php
                } ?>
                <div class="control-group">
                    <?php echo Chtml::label('Jenis Pesan', 'nokirimmenu', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'jenispesanmenu', LookupM::getItems('jenispesanmenu'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo Chtml::label('Jenis Menu Diet', 'nokirimmenu', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'jenisdiet_id', Chtml::ListData(JenisdietM::model()->findAll("jenisdiet_aktif = TRUE ORDER BY jenisdiet_nama ASC"), 'jenisdiet_id', 'jenisdiet_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20)); ?>
                    </div>
                </div>

                <?php //echo $form->dropDownListRow($model,'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'),array('empty'=>'-- Pilih --','class'=>'span4', 'maxlength'=>20)); 
                ?>

                <div class="control-group">
                    <?php echo Chtml::label('Pegawai Pengirim', 'nokirimmenu', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'create_loginpemakai_id', Chtml::ListData(GZPegawaiM::model()->PegawaiRuangan(), 'loginpemakai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20)); ?>
                    </div>
                </div>
                <?php //echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'span4', 'maxlength'=>20)); 
                ?>
                <?php //echo $form->dropDownListRow($model,'sumberdanabhn', LookupM::getItems('sumberdanabahan'),array('empty'=>'-- Pilih --')); 
                ?>
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
            $content = $this->renderPartial('../tips/informasiPengirimanMenuDiet', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>