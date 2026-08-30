<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'luluskomponendarah-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="panel-body">
        <?php $this->renderPartial('_formPasien', array('modKantong' => $modKantong, 'model' => $model, 'form' => $form)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Pelulusan <b>Produksi Komponen</b>
                </div>
            </div>

            <div class="panel-body">
                <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Hemolisis <span class='required'>*</span>", 'is_hemolisis', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList(
                                $model,
                                'is_hemolisis',
                                array(1 => 'Ya', 0 => 'Tidak'),
                                array(
                                    'labelOptions' => array('style' => 'display:inline;'),
                                    'separator' => '  ',
                                    'onclick' => 'setLulus();'
                                )
                            ); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Lipemik <span class='required'>*</span>", 'is_lipemik', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList(
                                $model,
                                'is_lipemik',
                                array(1 => 'Ya', 0 => 'Tidak'),
                                array(
                                    'labelOptions' => array('style' => 'display:inline'),
                                    'separator' => '  ',
                                    'onclick' => 'setLulus();'
                                )
                            ); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Icterik <span class='required'>*</span>", 'is_icetrik', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList(
                                $model,
                                'is_icetrik',
                                array(1 => 'Ya', 0 => 'Tidak'),
                                array(
                                    'labelOptions' => array('style' => 'display:inline'),
                                    'separator' => '  ',
                                    'onclick' => 'setLulus();'
                                )
                            ); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Plasma Hijau <span class='required'>*</span>", 'is_plasmahijau', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList(
                                $model,
                                'is_plasmahijau',
                                array(1 => 'Ya', 0 => 'Tidak'),
                                array(
                                    'labelOptions' => array('style' => 'display:inline'),
                                    'separator' => '  ',
                                    'onclick' => 'setLulus();'
                                )
                            ); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Bekuan <span class='required'>*</span>", 'is_bekuan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList(
                                $model,
                                'is_bekuan',
                                array(1 => 'Ya', 0 => 'Tidak'),
                                array(
                                    'labelOptions' => array('style' => 'display:inline'),
                                    'separator' => '  ',
                                    'onclick' => 'setLulus();'
                                )
                            ); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Pelabelan <span class='required'>*</span>", 'is_pelabelan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList(
                                $model,
                                'is_pelabelan',
                                array(1 => 'Ya', 0 => 'Tidak'),
                                array(
                                    'labelOptions' => array('style' => 'display:inline'),
                                    'separator' => '  ',
                                    'onclick' => 'setLulus();'
                                )
                            ); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Identitas <span class='required'>*</span>", 'is_identitas', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList(
                                $model,
                                'is_identitas',
                                array(1 => 'Ya', 0 => 'Tidak'),
                                array(
                                    'labelOptions' => array('style' => 'display:inline'),
                                    'separator' => '  ',
                                    'onclick' => 'setLulus();'
                                )
                            ); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Kebocoran <span class='required'>*</span>", 'is_kebocoran', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList(
                                $model,
                                'is_kebocoran',
                                array(1 => 'Ya', 0 => 'Tidak'),
                                array(
                                    'labelOptions' => array('style' => 'display:inline'),
                                    'separator' => '  ',
                                    'onclick' => 'setLulus();'
                                )
                            ); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    <div class="control-group">
                        <?php echo CHtml::label("Hasil ", 'statuspelulusan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'statuspelulusan', array('class' => 'span3 required', 'placeholder' => 'Status Pelulusan', 'readonly' => true)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Keterangan ", 'keteranganpelulusan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textArea($model, 'keteranganpelulusan', array('class' => 'span3', 'placeholder' => 'Keterangan Pelulusan Komponen Darah')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <br> <br>
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Pelulusan <span class='required'>*</span> ", 'tglpelulusan', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglpelulusan',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'realtime span3 dtPicker3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:204px;'
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Koordinator Mutu <span class='required'>*</span> ", 'koordinatormutu_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'koordinatormutu_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'koordinatormutu_nama',
                            'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('autoCompletePegawai') . '",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'select' => 'js:function( event, ui ) {
                                                $(this).val( ui.item.nama_pegawai );
                                                $("#LuluskomponendarahT_koordinatormutu_id").val( ui.item.pegawai_id );
                                                return false;
                                    }',
                            ),
                            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'NIP / Nama Pegawai'),
                            'tombolDialog' => array('idDialog' => 'dialogKoordinatorMutu', 'idTombol' => 'tombolKoordinator'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <br> <br>
                <div class="control-group">
                    <?php echo CHtml::label("Kepala Instansi Transfusi Darah <span class='required'>*</span> ", 'kepalainstalasi_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'kepalainstalasi_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'kepalainstalasi_nama',
                            'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('autoCompleteInstalasi') . '",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'select' => 'js:function( event, ui ) {
                                                $("#LuluskomponendarahT_kepalainstalasi_id").val( ui.item.pegawai_id );
                                                return false;
                                    }',
                            ),
                            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Nama Kepala Instalasi'),
                            'tombolDialog' => array('idDialog' => 'dialogKepalaInstalasi', 'idTombol' => 'tombolKoordinator'),
                        ));
                        ?>
                        <?php // echo $form->textField($model, 'kepalainstalasi_nama', array('class' => 'span4', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php $this->widget('UserTips', array('content' => ''));
    if (isset($_GET['frame'])) {
        if (isset($_GET['sukses'])) {
            echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-danger', 'onclick' => 'window.history.go(-2); return false;', 'style' => 'color: white;'));
        } else {
            echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-danger', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;'));
        }
    }
    ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '/_jsFunctions', array(
    'model' => $model,
    'modKantong' => $modKantong,
    'form' => $form,
));
?>


<?php
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKoordinatorMutu',
    'options' => array(
        'title' => 'Pencarian Koordinator Mutu',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('search');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaipelaksana-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPemberiTugas",
                "onClick" => "$(\"#' . CHtml::activeId($model, 'koordinatormutu_id') . '\").val(\"$data->pegawai_id\");
                              $(\"#' . CHtml::activeId($model, 'koordinatormutu_nama') . '\").val(\"$data->namaLengkap\");
                              $(\"#dialogKoordinatorMutu\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pemberi Tugas dialog =============================
?>


<?php
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKepalaInstalasi',
    'options' => array(
        'title' => 'Pencarian Nama Kepala Instalasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new PegawaiM('search');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawaiM'])) {
    $modPegawai->attributes = $_GET['PegawaiM'];
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kepalapegawai-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPemberiTugas",
                "onClick" => "$(\"#' . CHtml::activeId($model, 'kepalainstalasi_id') . '\").val(\"$data->pegawai_id\");
                              $(\"#' . CHtml::activeId($model, 'kepalainstalasi_nama') . '\").val(\"$data->namaLengkap\");
                              $(\"#dialogKepalaInstalasi\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pemberi Instalasi dialog =============================
?>




<?php
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKepala',
    'options' => array(
        'title' => 'Pencarian Kepala Instalasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('search');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaikepala-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPemberiTugas",
                "onClick" => "$(\"#' . CHtml::activeId($model, 'kepalainstalasi_id') . '\").val(\"$data->pegawai_id\");
                              $(\"#' . CHtml::activeId($model, 'kepalainstalasi_nama') . '\").val(\"$data->namaLengkap\");
                              $(\"#dialogKepala\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pemberi Tugas dialog =============================
?>
<script>
    /**
     * Fungsi ini digunakan untuk menampilkan alasan tidak lulus
     * Display default dari alasan adalah none
     */

    function tidakLulus(obj) {
        var L = $('#LuluskomponendarahT_statuspelulusan_1');

        if (L.is(":checked")) {
            $('#alasan').show();
            $("#<?php echo CHtml::activeId($model, 'alasantidaklulus') ?>").attr('class', 'required');
        } else {
            $('#alasan').hide();
            $("#<?php echo CHtml::activeId($model, 'alasantidaklulus') ?>").attr('class', 'span3');
        }
    }
</script>