<?php
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'method' => 'GET',
        'enableAjaxValidation' => true,
        'type' => 'horizontal',
        'id' => 'formCari',
        'focus' => '#' . CHtml::activeId($modInfoVerifikasiKunjuganRJ, 'no_rekam_medik'),
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
            'onKeyPress' => 'return disableKeyPress(event)',
            'class' => 'search-form'
        ),
    )
);
?>
<div class="row">
    <div class="col-sm-6">
        
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modInfoVerifikasiKunjuganRJ->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modInfoVerifikasiKunjuganRJ->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d F Y', strtotime($modInfoVerifikasiKunjuganRJ->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modInfoVerifikasiKunjuganRJ->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($modInfoVerifikasiKunjuganRJ, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($modInfoVerifikasiKunjuganRJ, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($modInfoVerifikasiKunjuganRJ, 'no_rekam_medik', array('class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'No. Rekam Medik')); ?>
        <?php echo $form->textFieldRow($modInfoVerifikasiKunjuganRJ, 'nama_pasien', array('class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'Nama Pasien')); ?>
        <?php echo $form->textAreaRow($modInfoVerifikasiKunjuganRJ, 'alamat_pasien', array('class' => 'span4 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'Alamat Pasien')); ?>
        <?php echo $form->dropDownListRow($modInfoVerifikasiKunjuganRJ, 'status_konfirmasi', CustomFunction::getStatusKonfirmasi(), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
        <?php echo $form->textFieldRow($modInfoVerifikasiKunjuganRJ, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
        <div class="control-group">
            <?php $modInfoVerifikasiKunjuganRJ->tgl_awall = date('d M Y', strtotime($modInfoVerifikasiKunjuganRJ->tgl_awall)); ?>
            <?php echo CHtml::label(CHtml::activeCheckBox($modInfoVerifikasiKunjuganRJ, 'ceklis') . " <label for='PPInfoKunjunganRJV_ceklis'>Tanggal Lahir</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modInfoVerifikasiKunjuganRJ,
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
            <?php $modInfoVerifikasiKunjuganRJ->tgl_akhirl = date('d M Y', strtotime($modInfoVerifikasiKunjuganRJ->tgl_akhirl)); ?>
            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modInfoVerifikasiKunjuganRJ,
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
        <?php echo $form->dropDownListRow($modInfoVerifikasiKunjuganRJ, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
            'instalasi_id' => Params::INSTALASI_ID_RJ,
            'ruangan_aktif' => true,
        ), array(
            'order' => 'ruangan_nama asc'
        )), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')); ?>
        <?php echo $form->dropDownListRow(
            $modInfoVerifikasiKunjuganRJ,
            'pegawai_id',
            CHtml::listData(DokterV::model()->findAllByAttributes(array(
                'instalasi_id' => Params::INSTALASI_ID_RJ,
                'pegawai_aktif' => true,
            ), array(
                'order' => 'nama_pegawai asc'
            )), 'pegawai_id', 'namaLengkap'),
            array('empty' => '-- Pilih --')
        ); ?>
        <?php echo $form->dropDownListRow(
            $modInfoVerifikasiKunjuganRJ,
            'statusperiksa',
            Params::statusPeriksaInfoKunjunganRJ(),
            array('empty' => '-- Pilih --')
        ); ?>
        <?php echo $form->dropDownListRow(
            $modInfoVerifikasiKunjuganRJ,
            'carakeluar_id',
            CHtml::listData(CarakeluarM::model()->findAll(
                'carakeluar_aktif is true ORDER BY carakeluar_nama ASC'
            ), 'carakeluar_id', 'carakeluar_nama'),
            array('empty' => '-- Pilih --', 'onchange' => 'setCaraKeluar(this)')
        ); ?>
        <?php echo $form->dropDownListRow(
            $modInfoVerifikasiKunjuganRJ,
            'kondisikeluar_id',
            [],
            array('empty' => '-- Pilih --', 'class' => 'kondisikeluar')
        ); ?>
        <div class="control-group">
            <?php echo CHtml::label('Petugas Loket', 'create_loginpemakai_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $cp = new CDbCriteria;
                $cp->join = 'join pegawairuangan_v p on p.pegawai_id = t.pegawai_id';
                $cp->compare('p.ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $cp->order = 't.nama_pemakai';
                $p = LoginpemakaiK::model()->findAll($cp);
                $arr = array();
                foreach ($p as $item) {
                    if (!empty($item->pegawai_id)) {
                        $arr[$item->loginpemakai_id] = $item->pegawai->nama_pegawai;
                    }
                }
                // var_dump($arr); die;
                echo $form->dropDownList($modInfoVerifikasiKunjuganRJ, 'create_loginpemakai_id', $arr, array('empty' => '-- Pilih --')); ?>
            </div>
        </div>
    
        
        <?php echo $form->dropDownListRow($modInfoVerifikasiKunjuganRJ, 'carabayar_id', CHtml::listData($modInfoVerifikasiKunjuganRJ->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
            'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('GetPenjaminPasien', array('encode' => false, 'namaModel' => 'PPInfoKunjunganRJV')),
                'update' => '#PPInfoKunjunganRJV_penjamin_id'  //selector to update
            ),
        )); ?>
        <div class="control-group">
            <?php echo CHtml::label('Penjamin', ' Penjamin', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modInfoVerifikasiKunjuganRJ, 'penjamin_id', CHtml::listData($modInfoVerifikasiKunjuganRJ->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status Verifikasi', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modInfoVerifikasiKunjuganRJ, 'is_verifikasidiagnosa', ['0' => 'Belum Verifikasi', '1' => 'Sudah Verifikasi'], array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array(
            'class' => 'btn btn-danger',
            'type' => 'submit',
            'title' => 'Cari'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiPasienRJ', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
</div>
<?php $this->endWidget(); ?>


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