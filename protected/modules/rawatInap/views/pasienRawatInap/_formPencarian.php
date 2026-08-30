<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'daftarPasien-form',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'no_pendaftaran'),
    'htmlOptions' => array(),
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Masuk", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No. Pendaftaran', 'no_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $prefix = array(
                    0 => Params::PREFIX_RAWAT_DARURAT,
                    1 => Params::PREFIX_RAWAT_INAP,
                    2 => Params::PREFIX_RAWAT_JALAN
                );
                echo $form->dropDownList($model, 'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix), array('class' => 'numbers-only', 'style' => 'width:75px;'));
                ?>
                <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10, 'placeholder' => 'No. Pendaftaran')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <div class="control-group">
                    <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                    </div>
                </div>
        <div class="control-group">
            <?php $model->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
            <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis') . " <label for='RIInfopasienmasukkamarV_ceklis'>Tanggal Lahir</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
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
                        'readonly' => true, 'class' => 'dtPicker3 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
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
                        'readonly' => true, 'class' => 'dtPicker3 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'caramasuk_id', CHtml::listData($model->getCaraMasukItems(), 'caramasuk_id', 'caramasuk_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'ajax' => array('type' => 'POST', 'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => 'RIInfopasienmasukkamarV')), 'update' => '#' . CHtml::activeId($model, 'penjamin_id') . ''),)); ?>
        <?php echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
        <div class="control-group">
            <label for="namaPasien" class="control-label">Dokter Penerima</label>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'dokterpenerima_id', CHtml::listData(
                    PegawaiM::model()->findAllByAttributes(array(
                        'jabatan_id' => Params::JABATAN_ID_DOKTER_UMUM,
                        'pegawai_aktif' => true,
                    ), array(
                        'order' => 'nama_pegawai'
                    )),
                    'pegawai_id',
                    'namaLengkap'
                ), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="namaPasien" class="control-label">DPJP</label>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'pegawai_id', CHtml::listData(
                    PegawaiM::model()->findAllByAttributes(array(
                        'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                        'pegawai_aktif' => true,
                    ), array(
                        'condition' => 'jabatan_id <> ' . Params::JABATAN_ID_DOKTER_UMUM,
                        'order' => 'nama_pegawai',
                    )),
                    'pegawai_id',
                    'namaLengkap'
                ), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Kelas Pelayanan", 'kelaspelayanan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananRuangan(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array(
                    'empty' => '-- Pilih --',
                    'ajax' => array(
                        'type' => 'POST',
                        'data' => array(
                            'kelaspelayanan_id' => 'js:this.value',
                            'ruangan_id' => Yii::app()->user->getState('ruangan_id')
                        ),
                        'url' => $this->createUrl('/ActionDynamic/GetKamarRuanganByKelas', array('encode' => false, 'namaModel' => get_class($model))),
                        'update' => '#' . CHtml::activeId($model, 'kamarruangan_id'),
                    )
                ))
                ?>
            </div>
        </div>
        <?php /*echo $form->dropDownListRow($model,'kamarruangan_id',  CHtml::listData(KamarruanganM::model()->findAllByAttributes(array(
            'kamarruangan_aktif'=>true,
            'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
        ), array(
            'order'=>'kamarruangan_nokamar',
        )), 'kamarruangan_id', 'kamarDanTempatTidurPolos'),array('empty'=>'-- Pilih --','placeholder'=>'Nama Pasien','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); */
        echo $form->dropDownListRow($model, 'kamarruangan_id', array(), array('empty' => '-- Pilih --', 'placeholder' => 'Nama Pasien', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50));
        ?>
        <div class="control-group">
            <?php echo CHtml::label("Kasus Penyakit", 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'jeniskasuspenyakit_id', CHtml::listData($model->getKasusPenyakit(), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih --'))
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Status Periksa", 'statusperiksa', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php
                $mods = LookupM::getItems('statusperiksa');
                unset($mods['BATAL PERIKSA']);
                echo $form->dropDownList($model, 'statusperiksa', $mods, array('empty' => '-- Pilih --')); ?>
            </div>
        </div> 
        <div class="control-group">
       
        <label for="namaPasien" class="control-label">
            </label>
            <div class="controls">
                <?php echo CHtml::activecheckBox($model, 'is_nursestation', array('uncheckValue' => 0, 'rel' => 'tooltip', 'data-original-title' => 'Cek untuk pencarian berdasarkan nurse station')); ?>
                <label for="RIInfopasienmasukkamarV_is_nursestation">Tampilkan berdasarkan Nurse Station</label>
            </div>


        </div>
        <?php echo CHtml::label("Pasien Global DPJP", 'is_global', array('class' => 'control-label','style'=>'color:white; width:104px; background-color:blue;')); ?>
            <div class="controls">            
                <?php echo CHtml::activecheckBox($model, 'is_global', array('uncheckValue' => 0, 'rel' => 'tooltip','style'=>'width:68px;', 'data-original-title' => 'Cek untuk pencarian berdasarkan pasien global')); ?>
    
            </div>

    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    );
    echo CHtml::hiddenField('pendaftaran_id');
    echo CHtml::hiddenField('pasien_id');
    ?>
    <?php
    $back_url = Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '');
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $back_url . '";}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/informasi', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
</div>
<!--fieldset class="box"-->
<?php $this->endWidget(); ?>
<!--</fieldset>-->
<script>
    // document.getElementById('RIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style","display:none;");
    // document.getElementById('RIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal() {
        var checklist = $('#RIInfopasienmasukkamarV_ceklis');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('RIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('RIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('RIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('RIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }
</script>