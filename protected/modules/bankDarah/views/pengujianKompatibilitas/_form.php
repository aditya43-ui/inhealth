<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pengujiankompabilitas-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_formPasien', array(
            'modUjiKompatibilitas' => $modUjiKompatibilitas,
            'format' => $format,
            'modPendaftaran' => $modPendaftaran,
            'form' => $form,
            'modPermintaanDarah' => $modPermintaanDarah,
            'modUjiDarah' => $modUjiDarah,
            'modPengujianDarah' => $modPengujianDarah,
            'modUjiDarahPasien' => $modUjiDarahPasien
        )); ?>

    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Pemeriksaan Golongan Darah ABO & Rhesus D Pasien Metode Slide Test</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->renderPartial($this->path_view . '_formPemeriksaanPengujianDarah', array(
            'modUjiKompatibilitas' => $modUjiKompatibilitas,
            'format' => $format,
            'modPendaftaran' => $modPendaftaran,
            'form' => $form,
            'modPermintaanDarah' => $modPermintaanDarah,
            'modUjiDarah' => $modUjiDarah,
            'modPengujianDarah' => $modPengujianDarah,
            'modUjiDarahPasien' => $modUjiDarahPasien
        ));
        ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan Golongan Darah ABO & Rhesus D Pasien Metode Tube Test
        </div>
    </div>
    <div class="panel-body" id="form-pemeriksaan-goldarah-tubetest" metode="pasien">
        <?php
        $this->renderPartial($this->path_view . '_formPemeriksaanPengujianDarahTube', array(
            'modUjiKompatibilitas' => $modUjiKompatibilitas,
            'format' => $format,
            'modPendaftaran' => $modPendaftaran,
            'form' => $form,
            'modPermintaanDarah' => $modPermintaanDarah,
            'modUjiDarah' => $modUjiDarah,
            'modPengujianDarah' => $modPengujianDarah,
            'modUjiDarahPasien' => $modUjiDarahPasien
        ));
        ?>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Pengujian Kompatibilitas</b>
        </div>
    </div>
    <div class='panel-body table-responsive'>
        <?php
        //                    $this->renderPartial($this->path_view.'formKantong',array(
        //                                            'modUjiKompatibilitas'=>$modUjiKompatibilitas,
        //                                            'format'=>$format,
        //                                            'modPendaftaran'=>$modPendaftaran,
        //                                            'form'=>$form,
        //                                            'modPermintaanDarah'=>$modPermintaanDarah,
        //                                            'modUjiDarah'=>$modUjiDarah,
        //                                            'modPengujianDarah'=>$modPengujianDarah,
        //                                            'modUjiDarahPasien'=>$modUjiDarahPasien
        //                      ));
        ?>
        <?php
        $this->renderPartial($this->path_view . 'tablePengujian', array(
            'modUjiKompatibilitas' => $modUjiKompatibilitas,
            'format' => $format,
            'modPendaftaran' => $modPendaftaran,
            'form' => $form,
            'modPermintaanDarah' => $modPermintaanDarah,
            'modUjiDarah' => $modUjiDarah,
            'modPengujianDarah' => $modPengujianDarah,
            'modUjiDarahPasien' => $modUjiDarahPasien,
            'modPermantaanDetail' => $modPermantaanDetail
        ));
        ?>
    </div>
</div>
<div class='panel-body'>
    <div class='control-group'>
        <?php echo CHtml::label('Waktu Pemeriksaan', '', array('class' => 'control-label')); ?>
        <div class='controls'>
            <?php
            echo CHtml::hiddenField('no_row', '', array('readonly' => true));
            echo CHtml::hiddenField('nama_komponen', '', array('readonly' => true));
            $this->widget('MyDateTimePicker', array(
                'model' => $modUjiDarahPasien,
                'attribute' => 'tglujidarahpasien',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array(
                    'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
        </div>
    </div>
    <div class='control-group'>
        <?php echo CHtml::label('Pemeriksa <span class="required">*</span>', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($modUjiDarahPasien, 'peg_pemeriksa_id', array('readonly' => true, 'class' => 'required'));
            echo $form->hiddenField($modUjiDarahPasien, 'pendaftaran_id', array('readonly' => true));
            echo $form->hiddenField($modUjiDarahPasien, 'pasien_id', array('readonly' => true));
            echo $form->hiddenField($modUjiDarahPasien, 'permintaandarah_id', array('readonly' => true));

            $this->widget('MyJuiAutoComplete', array(
                'name' => 'peg_pemeriksa_nama',
                'value' => '',
                'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('/actionAutoComplete/dropPetugasRuangan') . '",
                                    dataType: "json",
                                        data: {
                                            term: request.term,
                                            ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . ',
                                    },
                                        success: function (data) {                                        
                                        response(data);                                        
                                }
                                 })
                            }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.label);
                                            return false;
                                    }',
                    'select' => 'js:function( event, ui ) {
                                            return false;
                                    }',
                ),
                'htmlOptions' => array(
                    'readonly' => false,
                    'placeholder' => 'Nama Pemeriksa',
                    'class' => ' required',
                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modUjiDarahPasien, 'peg_pemeriksa_id') . '").val(""); ',
                    'onkeypress' => "return $(this).focusNextInputField(event);",
                ),
                'tombolDialog' => array('idDialog' => 'dialogPetugas', 'idTombol' => 'tombolPengirim'),
            ));
            ?>
        </div>

    </div>
</div>
<div class="form-actions">
    <?php
    $id = isset($modPendaftaran->pendaftaran_id) ? $modPendaftaran->pendaftaran_id : null;
    ?>
    <?php echo CHtml::htmlButton($modUjiDarahPasien->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => (isset($_GET['sukses'])) ? true : false));
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->module->id . '/Index', array('pendaftaran_id' => $id)),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index', array('pendaftaran_id' => $id)) . '";} ); return false;'
        )
    ); ?>
    <?php
    if (isset($_GET['sukses'])) {
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => false));
    } else {
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
    }
    ?>
</div>
<?php
$this->renderPartial($this->path_view . '_jsFunctions', array(
    'modUjiKompatibilitas' => $modUjiKompatibilitas,
    'format' => $format,
    'modPendaftaran' => $modPendaftaran,
    'form' => $form,
    'modUjiDarahPasien' => $modUjiDarahPasien
));

$this->endWidget(); ?>
<?php
?>
<?php
/** =============== dialog pemeriksa ===================== **/
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogPetugas',
        'options' => array(
            'title' => 'Pencarian Petugas',
            'autoOpen' => false,
            'width' => 530,
            'height' => 500,
            'resizable' => true,
        ),
    )
);

$format = new MyFormatter();
$pegPengirim = new PegawairuanganV('search');
if (isset($_GET['PegawairuanganV'])) {
    $pegPengirim->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-pengirim-m-grid',
    'dataProvider' => $pegPengirim->searchDialogPegRuangan(),
    'filter' => $pegPengirim,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectBahan",
					"onClick" => "
						$(\'#' . Chtml::activeId($modUjiDarahPasien, 'peg_pemeriksa_id') . '\').val(\'$data->pegawai_id\');
						$(\'#peg_pemeriksa_nama\').val(\'$data->NamaLengkap\');
						$(\'#dialogPetugas\').dialog(\'close\');
						return false;"))',
        ),
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            },
            'filter' => CHtml::activeDropDownList($pegPengirim, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE "), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END =======================================
?>
<script>
    $(document).ready(function() {
        //setKantongDarah();
        renameInput();
        $('form').bind('click keyup select change', function(event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function() {
            cekDisabled('form');
        });
        cekDisabled('form');
    });
</script>