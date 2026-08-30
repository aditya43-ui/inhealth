<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'enableAjaxValidation' => false,
    'id' => 'informasipembebasantarif-t-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pembebasan", 'tglpembebasan', array('class' => 'control-label')) ?>
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
            <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklistdaftar') . " <label for='RJLaporanpembebasantarifV_ceklistdaftar'>Tanggal Pelayanan</label>", 'tgl_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgldaftar_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgldaftar_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgldaftar_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgldaftar_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgldaftar_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgldaftar_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4')); ?>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4')); ?>
        <?php echo $form->dropDownListRow($model, 'komponentarif_id', CHtml::listData(KomponentarifM::model()->findAll('komponentarif_aktif = true ORDER BY komponentarif_nama ASC'), 'komponentarif_id', 'komponentarif_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
            <?php echo CHtml::label("Nama Dokter", 'pegawai_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawai_id', array('class' => 'span3', 'readonly' => true)); ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'nama_pegawai',
                    'source' => 'js: function(request, response) {
                                $.ajax({
                                        url: "' . Yii::app()->createUrl('ActionAutoComplete/DaftarDokter') . '",
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
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.label);
                                            return false;
                                    }',
                        'select' => 'js:function( event, ui ) {																												$(this).val(ui.item.value);
                                            $("#' . CHtml::activeId($model, 'pegawai_id') . '").val(ui.item.value);																												setDataPasien();
                                            return false;
                                    }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span4 hurufs-only',
                        'placeholder' => 'Nama Dokter',
                        'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($model, 'pegawai_id') . '").val("")'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDokter', 'idTombol' => 'tombolDialogDokter'),
                )); ?>
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
        array(
            'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    $content = $this->renderPartial($this->path_view . '/tips', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Dokter',
        'autoOpen' => false,
        'resizable' => true,
        'modal' => true,
        'width' => 640,
    ),
));
$modDokter = new RJDokterV('searchDokterdialog');
$modDokter->unsetAttributes();
if (isset($_GET['RJDokterV'])) {
    $modDokter->attributes = $_GET['RJDokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rjdokterpembebasaninfo-v-grid',
    'dataProvider' => $modDokter->searchDokterdialog(),
    'filter' => $modDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                        "id" => "selectPasien",
                        "onClick" => "                                        
                            $(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->namaLengkap\");
                            $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                            $(\"#dialogDokter\").dialog(\"close\");
                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modDokter, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
            'filter' => Chtml::activeTextField($modDokter, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){            
            $(".numbers-only").keyup(function() {
                setNumbersOnly(this);
            });            
        }',
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>