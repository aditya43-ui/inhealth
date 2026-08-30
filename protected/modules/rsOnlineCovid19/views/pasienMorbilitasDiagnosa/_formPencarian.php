<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'daftarPasienmorbiditas-form',
    'type' => 'horizontal',
    //    'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
    'htmlOptions' => array(),
)); ?>
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
        <div class="control-group">
            <?php echo CHtml::label('No. Pendaftaran', 'no_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span3', 'maxlength' => 100, 'placeholder' => 'No. Pendaftaran')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span3 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                    'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => 'RIInfopasienmasukkamarV')),
                        'update' => '#' . CHtml::activeId($model, 'penjamin_id') . ''  //selector to update
                    ),
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Penjamin", 'penjamin_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
        <!--<div class="control-group ">
            <label for="namaPasien" class="control-label">Dokter Penerima</label>
            <div class="controls">
                <?php // echo $form->dropDownList($model,'dokterpenerima_id', CHtml::listData(
                //                PegawaiM::model()->findAllByAttributes(array(
                //                    'jabatan_id'=>Params::JABATAN_ID_DOKTER_UMUM,
                //                    'pegawai_aktif'=>true,
                //                ), array(
                //                    'order'=>'nama_pegawai'
                //                )), 
                //                'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); 
                ?>
            </div>
        </div>-->
        <!--<div class="control-group ">
            <label for="namaPasien" class="control-label">DPJP</label>
            <div class="controls">
                <?php // echo $form->dropDownList($model,'pegawai_id', CHtml::listData(
                //                    PegawaiM::model()->findAllByAttributes(array(
                //                        'kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                //                        'pegawai_aktif'=>true,
                //                    ), array(
                //                        'condition'=>'jabatan_id <> '.Params::JABATAN_ID_DOKTER_UMUM,
                //                        'order'=>'nama_pegawai',
                //                    )), 
                //                'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); 
                ?>
            </div>
        </div>-->
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
        <?php
        //		echo $form->dropDownListRow($model,'kamarruangan_id', array(),array('empty'=>'-- Pilih --','placeholder'=>'Nama Pasien','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50));
        ?>
        <div class="control-group">
            <?php echo CHtml::label("Kasus Penyakit", 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'jeniskasuspenyakit_id', CHtml::listData($model->getKasusPenyakit(), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih --'))
                ?>
            </div>
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
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $back_url . '";}); return false;'
        )
    ); ?>
    <?php
    $tips = array(
        '0' => 'cari',
        '1' => 'ulang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<!--fieldset class="box"-->
<?php $this->endWidget(); ?>
<!--</fieldset>-->
<script>
    // document.getElementById('RIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style","display:none;");
    // document.getElementById('RIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style","display:none;");
    //function cekTanggal(){
    //
    //    var checklist = $('#ROCInfopasienmasukkamarV_ceklis');
    //    var pilih = checklist.attr('checked');
    //    if(pilih){
    //        document.getElementById('ROCInfopasienmasukkamarV_tgl_awal_date').setAttribute("style","display:block;");
    //        document.getElementById('ROCInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style","display:block;");
    //    }else{
    //        document.getElementById('ROCInfopasienmasukkamarV_tgl_awal_date').setAttribute("style","display:none;");
    //        document.getElementById('ROCInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style","display:none;");
    //    }
    //}
</script>