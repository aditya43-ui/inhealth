<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label("No. Pendaftaran", 'no_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $prefix = array(
                    0 => Params::PREFIX_RAWAT_JALAN
                );
                echo $form->dropDownList($model, 'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix), array('class' => 'numbers-only', 'style' => 'width:75px;'));
                ?>
                <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10, 'placeholder' => 'No. Pendaftaran')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'maxlength' => 20)); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
            </div>
        </div>
        <?php //echo $form->textFieldRow($model, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
        <div class="control-group">
            <?php $model->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
            <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis') . " <label for='RJInfokunjunganrjV_ceklis'>Tanggal Lahir</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_awall',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php $model->tgl_akhirl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhirl, 'yyyy-MM-dd'), 'medium', null); ?>
            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_akhirl',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php
        $mods = LookupM::getItems('statusperiksa');
        unset($mods['BATAL PERIKSA']);
        echo $form->dropDownListRow($model, 'statusperiksa', $mods, array('empty' => '-- Pilih --')); ?>
        <div class="control-group">
            <label for="namaPasien" class="control-label">
                Dokter Pemeriksa
            </label>
            <div class="controls">
                <?php //$query = "
				//	SELECT concat(pegawai_m.gelardepan, ' ', pegawai_m.nama_pegawai,  ' ',  gelarbelakang_m.gelarbelakang_nama) AS namalengkap, loginpemakai_k.loginpemakai_id FROM loginpemakai_k 
				//	JOIN ruanganpemakai_k ON ruanganpemakai_k.loginpemakai_id = loginpemakai_k.loginpemakai_id
				//	JOIN pegawai_m ON loginpemakai_k.pegawai_id = pegawai_m.pegawai_id
                //    LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
				//	WHERE ruanganpemakai_k.ruangan_id = ". Yii::app()->user->getState('ruangan_id') ."
				//";
                //$pegawai = Yii::app()->db->createCommand($query)->queryAll();

                $peg = Yii::app()->user->getState('pegawai_id');

                $listpeg = array('pegawai_id' => Yii::app()->user->getState('pegawai_id'), 'pegawai_aktif' => true);
                
                if($peg == 1028) {
                    $listpeg = array('pegawai_aktif' => true);
                }

                ?>
                <?php //echo $form->dropDownList($model, 'nama_pegawai', CHtml::listData($pegawai, 'nama_pegawai', 'namalengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); 
                    // $dok = DokterV::model()->findAllByAttributes($listpeg, array('order' => 'nama_pegawai'),'nama_pegawai','namaLengkap');?>
    
                    <?php echo $form->dropDownList($model, 'nama_pegawai', CHtml::listData(DokterV::model()->findAllByAttributes($listpeg, array('order' => 'nama_pegawai')), 'nama_pegawai', 'namaLengkap'), array('empty'=>'-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
            'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
            'ajax' => array(
                'type' => 'POST',
                'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                'update' => '#' . CHtml::activeId($model, 'penjamin_id') . ''  //selector to update
            ),
        )); ?>
        <?php echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
    </div>
</div>
<?php //echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'No. Pendaftaran', 'class'=>'span4', 'maxlength'=>20)); 
?>