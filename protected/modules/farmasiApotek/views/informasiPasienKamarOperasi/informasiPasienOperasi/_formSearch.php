<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'search-penunjangrujukan-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));

Yii::app()->clientScript->registerScript('search', "
$('#search-penunjangrujukan-form').submit(function(){
	$.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="row">
        <div class="col-sm-6">
            
            <div class="control-group">
                <?php echo CHtml::label(CHtml::activeCheckBox($model, 'isPilihTglRencana',['checked'=>'isPilihTglRencana'])."Tgl. Rencana Pemeriksaan", 'tgl_rekam', array('class' => 'control-label')) ?>
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
                <label for="noPendaftaran" class="control-label">No. Pendaftaran</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'alphanumeric-only span4', 'maxlength' => 20, 'id' => 'noPendaftaran', 'autofocus' => true, 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                    <!--<input class ="alphanumeric-only" type="text" value="" maxlength="20" placeholder="No. pendaftaran" id="noPendaftaran" name="PasienkirimkeunitlainV[no_pendaftaran]" autofocus=true onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">-->
                </div>
            </div>
            <div class="control-group">
                <label for="noRekamMedik" class="control-label">No. Rekam Medik</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'numbers-only span4', 'maxlength' => 10, 'id' => 'noRekamMedik', 'autofocus' => true, 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                    <!--<input class ="numbers-only" type="text" value="" maxlength="10" placeholder="No. rekam medik" id="noRekamMedik" name="PasienkirimkeunitlainV[no_rekam_medik]" onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">-->
                </div>
            </div>
            
            <div class="control-group">
                <label for="namaPasien" class="control-label">Nama Pasien</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'hurufs-only span4', 'maxlength' => 50, 'id' => 'namaPasien', 'autofocus' => true, 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                    <!--<input class ="hurufs-only" type="text" value="" maxlength="50" placeholder="Ketik nama pasien" id="namaPasien" name="PasienkirimkeunitlainV[nama_pasien]" onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">-->
                </div>
            </div>
            <div class="control-group hide">
                    <?php echo Chtml::label("NIK", 'pasien_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pasien_id', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                    </div>
                </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo Chtml::label('Jenis Penjamin', 'crabayar_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif = TRUE ORDER BY carabayar_nama ASC"), 'carabayar_id', 'carabayar_nama'), array(
                        'empty' => '-- Pilih --',
                        'class' => 'span3',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                            'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
                        ),
                    ));
                    ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model, 'penjamin_id', array(), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50)); ?>
            <div class="control-group">
                <?php echo Chtml::label("Instalasi", 'instalasiasal_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE ORDER BY instalasi_nama ASC"), 'instalasi_id', 'instalasi_nama'), array(
                        'empty' => '-- Pilih --',
                        'class' => 'span3',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('/actionDynamic/GetRuanganAsalDariInstalasiAsal', array('encode' => false, 'namaModel' => get_class($model))),
                            'success' => 'function(data){$("#' . CHtml::activeId($model, "ruanganasal_id") . '").html(data); }',
                        ),
                    ));
                    ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model, 'ruanganasal_id', array(), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50)); ?>
           
        </div>
    </div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'name' => 'submitSearch')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php $content = $this->renderPartial('../tips/informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
</div>

<?php $this->endWidget(); ?>

<?php 
//========= Dialog buat cari data dokter =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Pencarian Data Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>400,
        'resizable'=>false,
    ),
));
    $pegawai = new DokterpegawaiV('searchByDokter');
    if (isset($_GET['DokterpegawaiV'])){
        $pegawai->attributes = $_GET['DokterpegawaiV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dokter-t-grid',
            'dataProvider'=>$pegawai->searchByDokter(),
            'filter'=>$pegawai,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogDokter\").dialog(\"close\");
                                            $(\"#PasienkirimkeunitlainV_nama_pegawai\").val(\"$data->nama_pegawai\");
                                            $(\"#PasienkirimkeunitlainV_namaDokter\").val(\"$data->nama_pegawai\");
                                        "))',
                    ),
                    array(
                        'name'=>'nama_pegawai',
                        'header'=>'Nama Dokter',
                    ),
                    array(
                        'name'=>'jabatan_id',
                        'header'=>'Jabatan',
                        'value' => function ($data) {
                            $jabatan = JabatanM::model()->findByPk($data->jabatan_id);
                            return isset($jabatan) ? $jabatan->jabatan_nama : '-';
                        },
                        'filter' => CHtml::activeDropDownList($pegawai, 'jabatan_id', CHtml::listData(
                            JabatanM::model()->findAll(array(
                                'condition' => 'jabatan_aktif = true',
                                'order' => 'jabatan_nama',
                            )),
                            'jabatan_id',
                            'jabatan_nama'
                        ), array('empty' => '-- Pilih --'))
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>