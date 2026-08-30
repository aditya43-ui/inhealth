<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'formCari',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modInfoKunjunganRDV, 'no_rekam_medik'),
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class=" daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modInfoKunjunganRDV->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modInfoKunjunganRDV->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d F Y', strtotime($modInfoKunjunganRDV->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modInfoKunjunganRDV->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($modInfoKunjunganRDV, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($modInfoKunjunganRDV, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($modInfoKunjunganRDV, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($modInfoKunjunganRDV, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textAreaRow($modInfoKunjunganRDV, 'alamat_pasien', array('placeholder' => 'Alamat Pasien', 'class' => 'span4 custom-only', 'rows' => 3, 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->dropDownListRow($modInfoKunjunganRDV, 'status_konfirmasi', CustomFunction::getStatusKonfirmasi(), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
        <?php echo $form->textFieldRow($modInfoKunjunganRDV, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
        <div class="control-group">
            <?php $modInfoKunjunganRDV->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modInfoKunjunganRDV->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
            <?php echo CHtml::label(CHtml::activeCheckBox($modInfoKunjunganRDV, 'ceklis') . " <label for='PPInfoKunjunganRDV_ceklis'>Tanggal Lahir</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modInfoKunjunganRDV,
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
            <?php $modInfoKunjunganRDV->tgl_akhirl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modInfoKunjunganRDV->tgl_akhirl, 'yyyy-MM-dd'), 'medium', null); ?>
            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modInfoKunjunganRDV,
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
        <?php echo $form->dropDownListRow(
            $modInfoKunjunganRDV,
            'pegawai_id',
            CHtml::listData(DokterV::model()->findAllByAttributes(array(
                'instalasi_id' => Params::INSTALASI_ID_RD,
            ), array(
                'order' => 'nama_pegawai asc'
            )), 'pegawai_id', 'namaLengkap'),
            array('class' => 'span4', 'empty' => '-- Pilih --')
        ); ?>
        <?php echo $form->dropDownListRow(
            $modInfoKunjunganRDV,
            'statusperiksa',
            Params::statusPeriksaInfoKunjunganRJ(),
            array('class' => 'span4', 'empty' => '-- Pilih --')
        ); ?>
        <?php echo $form->dropDownListRow(
            $modInfoKunjunganRDV,
            'carakeluar_id',
            CHtml::listData(CarakeluarM::model()->findAll(
                'carakeluar_aktif is true ORDER BY carakeluar_nama ASC'
            ), 'carakeluar_id', 'carakeluar_nama'),
            array('empty' => '-- Pilih --', 'onchange' => 'setCaraKeluar(this)')
        ); ?>
        <?php echo $form->dropDownListRow(
            $modInfoKunjunganRDV,
            'kondisikeluar_id',
            [],
            array('empty' => '-- Pilih --', 'class' => 'kondisikeluar')
        ); ?>
        <?php echo $form->dropDownListRow($model, 'create_loginpemakai_id',  CHtml::listData($model->getPegawaiRuanganItems(), 'loginpemakai_id', 'pegawai.nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->dropDownListRow($modInfoKunjunganRDV, 'carabayar_id', CHtml::listData($modInfoKunjunganRDV->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
            'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('GetPenjaminPasien', array('encode' => false, 'namaModel' => 'PPInfoKunjunganRDV')),
                'update' => '#PPInfoKunjunganRDV_penjamin_id'  //selector to update
            ),
        )); ?>
        <div class="control-group">
            <?php echo CHtml::label('Penjamin', ' Penjamin', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modInfoKunjunganRDV, 'penjamin_id', CHtml::listData($modInfoKunjunganRDV->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($modInfoKunjunganRDV, 'asalrujukan_id', CHtml::listData(
            AsalrujukanM::model()->findAll(array(
                'condition' => 'asalrujukan_aktif = true',
                'order' => 'asalrujukan_nama'
            )),
            'asalrujukan_id',
            'asalrujukan_nama'
        ), array(
            'class' => 'span4',
            'empty' => '-- Pilih --',
            'ajax' => array(
                'type' => 'POST',
                'url' => Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/GetRujukanDari', array('encode' => false, 'namaModel' => get_class($modInfoKunjunganRDV))),
                'update' => '#' . CHtml::activeId($modInfoKunjunganRDV, 'rujukandari_id'),
            )
        )); ?>
        <?php echo $form->dropDownListRow($modInfoKunjunganRDV, 'rujukandari_id', array(), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
        <div class="control-group">
            <?php echo CHtml::label('Status Verifikasi', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modInfoKunjunganRDV, 'is_verifikasidiagnosa', ['0' => 'Belum Verifikasi', '1' => 'Sudah Verifikasi'], array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
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
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiPasienRD', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
    <?php $this->endWidget(); ?>
</div>

<script>
    function setCaraKeluar(obj) {
        var carakeluar_id = $(obj).val();
        console.log(carakeluar_id)
        if(carakeluar_id != '') {
            $.post('<?= $this->createUrl('/rekamMedis/infoVerifikasiKunjunganRJ/setDropDownKondisiKeluar') ?>', {
                carakeluar_id:carakeluar_id
            }, function(data){
                $('.kondisikeluar').html(data.option);
            }, 'json');
        } else {
            $('.kondisikeluar').html('<option value>-- Pilih --</option>');
        }
    }
</script>