<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'search-penunjangrujukan-form',
    'focus' => '#' . CHtml::activeId($model, 'no_pendaftaran'),
    'htmlOptions' => array(),
));
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Rujukan", 'tgl_rekam', array('class' => 'control-label')) ?>
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
                <?php echo CHtml::label(CHtml::activeCheckBox($model, 'isPilihTglRencana',['checked'=>false])."Tgl. Rencana Pemeriksaan", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_rencana_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_rencana_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_rencana_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_rencana_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_rencana_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_rencana_akhir', array('class' => 'end')) ?>
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
                    2 => Params::PREFIX_RAWAT_JALAN,
                );
                echo $form->dropDownList($model, 'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix), array('class' => 'numbers-only', 'style' => 'width:75px;'));
                ?>
                <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10, 'placeholder' => 'No. Pendaftaran')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("Dokter Pengirim", 'pegawai_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'pegawai_id', array('placeholder' => 'Dokter PJP', 'class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50));
                $this->widget('MyJuiAutoComplete', array(
                    'attribute' => 'nama_pegawai',
                    'model' => $model,
                    'sourceUrl' => Yii::app()->createUrl('/ActionAutoComplete/DaftarAllDokter2'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
									//$(this).val( ui.item.label);
								//	$("#' . CHtml::activeId($model, 'pegawai_id') . '").val( ui.item.pegawai_id);
								//	$("#' . CHtml::activeId($model, 'nama_pegawai') . '").val( ui.item.label);
									return false;
								}',
                        'select' => 'js:function( event, ui ) {                                     
									$(this).val( ui.item.label);
									$("#' . CHtml::activeId($model, 'pegawai_id') . '").val( ui.item.pegawai_id);         
									//$("#' . CHtml::activeId($model, 'nama_pegawai') . '").val( ui.item.label);
								}'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDokter'),
                    'htmlOptions' => array('onblur' => 'cekClear();', 'placeholder' => 'Dokter Pengirim', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'hurufs-only span4'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label for="noRekamMedik" class="control-label">No. Rekam Medik</label>
            <div class="controls">
                <?php echo CHtml::activeTextField($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'numbers-only span4', 'maxlength' => 8)); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="namaPasien" class="control-label">Nama Pasien</label>
            <div class="controls">
                <?php echo CHtml::activeTextField($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'hurufs-only span4',)); ?>
            </div>
        </div>
        <div class="control-group">
                    <?php echo Chtml::label("NIK", 'pasien_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pasien_id', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                    </div>
                </div>

    </div>
    <div class="col-sm-6">
        <?php
        $carabayar = CarabayarM::model()->findAll(array(
            'condition' => 'carabayar_aktif = true',
            'order' => 'carabayar_nourut',
        ));
        foreach ($carabayar as $idx => $item) {
            $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                'carabayar_id' => $item->carabayar_id,
                'penjamin_aktif' => true,
            ));
            if (empty($penjamins)) unset($carabayar[$idx]);
        }
        $penjamin = PenjaminpasienM::model()->findAll(array(
            'condition' => 'penjamin_aktif = true',
            'order' => 'penjamin_nama',
        ));
        echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
            'empty' => '-- Pilih --',
            'class' => 'span4',
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
            ),
        ));
        echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
        ?>
        <?php
        $instalasi = InstalasiM::model()->findAllByAttributes(array(
            'instalasi_id' => array(2, 3, 4),
        ));
        $ruangan = RuanganM::model()->findAllByAttributes(array(
            'instalasi_id' => array(2, 3, 4),
            'ruangan_aktif' => true,
        ), array(
            'order' => 'instalasi_id, ruangan_nama',
        ));
        echo $form->dropDownListRow($model, 'instalasiasal_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
            'empty' => '-- Pilih --',
            'class' => 'span4',
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('/actionDynamic/getRuanganAsalDariInstalasiAsal', array('encode' => false, 'namaModel' => get_class($model))),
                'success' => 'function(data){$("#' . CHtml::activeId($model, "ruanganasal_id") . '").html(data); }',
            ),
        ));
        echo $form->dropDownListRow($model, 'ruanganasal_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
        ?>
        <div class="control-group">
            <?php echo CHtml::label("Status Periksa", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'statusperiksa', LookupM::getItems('statusperiksa'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'name' => 'submitSearch', 'title' => 'Cari')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/informasi_pasien_rujukan', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
</div>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Pencarian Dokter Pengirim',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modDokter = new DokterV('search');
$modDokter->unsetAttributes();
if (isset($_GET['DokterV'])) {
    $modDokter->attributes = $_GET['DokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengajukan-m-grid',
    'dataProvider' => $modDokter->searchAllDokter(),
    'filter' => $modDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"                            
                            $(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->namaLengkap\");                            
                            $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");                            
                            $(\"#dialogDokter\").dialog(\"close\");
                            return false;"
                ))'
        ),
        //'gelardepan',
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
            'name' => 'nomorindukpegawai',
            'filter' => Chtml::activeTextField($modDokter, 'nomorindukpegawai', array('class' => 'numbers-only')),
        ),
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama Dokter',
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modDokter, 'nama_pegawai', array('class' => 'hurufs-only')),
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
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id',  Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });                '
        . '}',
));
$this->endWidget();
?>
<script>
    function cekClear() {
        var nama_pegawai = $("#LBPasienKirimKeUnitLainV_nama_pegawai").val();
        if (nama_pegawai == '') {
            $("#LBPasienKirimKeUnitLainV_pegawai_id").val('');
        }
    }
</script>