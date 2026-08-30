<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'formCari',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modPPInfoKunjunganRIV, 'no_rekam_medik'),
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Masuk", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modPPInfoKunjunganRIV->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modPPInfoKunjunganRIV->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d F Y', strtotime($modPPInfoKunjunganRIV->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modPPInfoKunjunganRIV->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($modPPInfoKunjunganRIV, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($modPPInfoKunjunganRIV, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($modPPInfoKunjunganRIV, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($modPPInfoKunjunganRIV, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textAreaRow($modPPInfoKunjunganRIV, 'alamat_pasien', array('placeholder' => 'Alamat Pasien', 'class' => 'span4 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'rows' => 2, 'maxlength' => 50)); ?>
        <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV, 'caramasuk_id', CHtml::listData(CaramasukM::model()->findAllByAttributes(array(
            //'instalasi_id'=>Params::INSTALASI_ID_RI,
            'caramasuk_aktif' => true,
        ), array(
            'order' => 'caramasuk_nama asc'
        )), 'caramasuk_id', 'caramasuk_nama'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
        <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV, 'status_konfirmasi', CustomFunction::getStatusKonfirmasi(), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
        <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV, 'carabayar_id', CHtml::listData($modPPInfoKunjunganRIV->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
            'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('GetPenjaminPasien', array('encode' => false, 'namaModel' => 'PPInfoKunjunganRIV')),
                'update' => '#PPInfoKunjunganRIV_penjamin_id'  //selector to update
            ),
        )); ?>
        <div class="control-group">
            <?php echo CHtml::label('Penjamin', ' Penjamin', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPPInfoKunjunganRIV, 'penjamin_id', CHtml::listData($modPPInfoKunjunganRIV->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modPPInfoKunjunganRIV, 'no_identitas_pasien', array('placeholder' => 'NIK', 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php $modPPInfoKunjunganRIV->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPPInfoKunjunganRIV->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
            <?php echo CHtml::label(CHtml::activeCheckBox($modPPInfoKunjunganRIV, 'ceklis') . " <label for='PPInfoKunjunganRIV_ceklis'>Tanggal Lahir</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPPInfoKunjunganRIV,
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
            <?php $modPPInfoKunjunganRIV->tgl_akhirl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPPInfoKunjunganRIV->tgl_akhirl, 'yyyy-MM-dd'), 'medium', null); ?>
            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPPInfoKunjunganRIV,
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
        <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV, 'asalrujukan_id', CHtml::listData(
            AsalrujukanM::model()->findAll(array(
                'condition' => 'asalrujukan_aktif = true',
                'order' => 'asalrujukan_nama'
            )),
            'asalrujukan_id',
            'asalrujukan_nama'
        ), array(
            'empty' => '-- Pilih --',
            'ajax' => array(
                'type' => 'POST',
                'url' => Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/GetRujukanDari', array('encode' => false, 'namaModel' => get_class($modPPInfoKunjunganRIV))),
                'update' => '#' . CHtml::activeId($modPPInfoKunjunganRIV, 'rujukandari_id'),
            )
        )); ?>
        <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV, 'rujukandari_id', array(), array('empty' => '-- Pilih --')); ?>
        <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
            'instalasi_id' => array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_ICU),
            'ruangan_aktif' => true,
        ), array(
            'order' => 'ruangan_nama asc'
        )), 'ruangan_id', 'ruangan_nama'), array(
            'empty' => '-- Pilih --',
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('/actionDynamic/getKamarRuangan', array('encode' => false, 'namaModel' => get_class($modPPInfoKunjunganRIV))),
                'success' => 'function(data){$("#' . CHtml::activeId($modPPInfoKunjunganRIV, "kamarruangan_id") . '").html(data); }',
            ),
        )); ?>
        <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV, 'kelaspelayanan_id', CHtml::listData(
            KelaspelayananM::model()->findAllByAttributes(array(
                'kelaspelayanan_aktif' => true,
            ), array(
                'order' => 'kelaspelayanan_nama'
            )),
            'kelaspelayanan_id',
            'kelaspelayanan_nama'
        ), array(
            'empty' => '-- Pilih --',
        )); ?>
        <div class="control-group">
            <?php echo $form->label($modPPInfoKunjunganRIV, 'Kamar Ruangan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPPInfoKunjunganRIV, 'kamarruangan_id', array(), array('empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->label($modPPInfoKunjunganRIV, 'dokterpenerima_id', array('class' => 'control-label', 'label' => 'Dokter Penerima')); ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $modPPInfoKunjunganRIV,
                    'dokterpenerima_id',
                    CHtml::listData(PegawaiV::model()->findAllByAttributes(array(
                        'pegawai_aktif' => true,
                        'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                        'jabatan_id' => Params::JABATAN_ID_DOKTER_UMUM,
                    ), array(
                        'order' => 'nama_pegawai asc'
                    )), 'pegawai_id', 'namaLengkap'),
                    array('empty' => '-- Pilih --')
                ); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->label($modPPInfoKunjunganRIV, 'pegawai_id', array('class' => 'control-label', 'label' => 'DPJP')); ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $modPPInfoKunjunganRIV,
                    'pegawai_id',
                    CHtml::listData(PegawaiV::model()->findAllByAttributes(array(
                        'pegawai_aktif' => true,
                        'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                    ), array(
                        'condition' => 'jabatan_id <> ' . Params::JABATAN_ID_DOKTER_UMUM,
                        'order' => 'nama_pegawai asc'
                    )), 'pegawai_id', 'namaLengkap'),
                    array('empty' => '-- Pilih --')
                ); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow(
            $modPPInfoKunjunganRIV,
            'statusperiksa',
            Params::statusPeriksa(),
            array('empty' => '-- Pilih --')
        ); ?>
        <?php echo $form->dropDownListRow(
            $modPPInfoKunjunganRIV,
            'carakeluar_id',
            CHtml::listData(CarakeluarM::model()->findAll(
                'carakeluar_aktif is true ORDER BY carakeluar_nama ASC'
            ), 'carakeluar_id', 'carakeluar_nama'),
            array('empty' => '-- Pilih --', 'onchange' => 'setCaraKeluar(this)')
        ); ?>
        <?php echo $form->dropDownListRow(
            $modPPInfoKunjunganRIV,
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
                echo $form->dropDownList($modPPInfoKunjunganRIV, 'create_loginpemakai_id', $arr, array('empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status Verifikasi', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPPInfoKunjunganRIV, 'is_verifikasidiagnosa', ['0' => 'Belum Verifikasi', '1' => 'Sudah Verifikasi'], array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    );
    ?>
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
    $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiPasienRI', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    $this->endWidget();
    ?>
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