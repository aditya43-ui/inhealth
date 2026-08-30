<?php $linkHalaman = CustomFunction::getUrlByMenuID(3487); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pembebasantarif-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
    'focus' => '#' . CHtml::activeId($modPasien, 'no_rekam_medik'),
));
?>
<style>
    tr td .add-on {
        margin: 0 !important;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Transaksi Pembebasan Tarif Pasien',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pembebasan Tarif Pasien</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->pathView . '_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Detail <b>Tarif Pasien</b>
                </div>
            </div>
            <div class="panel-body">
                <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->
                <?php echo $form->errorSummary($model); ?>
                <?php echo $form->hiddenField($model, 'pegawai_id', array('class' => 'span3', 'readonly' => true)); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php $model->pegawai_nama = (!empty($model->pegawai_id)) ? PegawaiM::model()->findByPk($model->pegawai_id)->nama_pegawai : ''; ?>
                            <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label required')); ?>
                            <div class="controls">
                                <?php $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'pegawai_nama',
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
                                        'class' => 'span3 hurufs-only',
                                        'placeholder' => 'Dokter',
                                        'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($model, 'pegawai_id') . '").val("");setDataPasien(); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogDokter', 'idTombol' => 'tombolDialogDokter'),
                                )); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglpembebasan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($model, 'tglpembebasan', array('class' => 'realtime span3', 'readonly' => TRUE));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pembebasan Tarif Pasien</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div id="divTarifPasien">
                            <table id="tblTindakanPasien" class="table table-bordered table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            );
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->module->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                )
            ); ?>
            <?php /*echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
Yii::app()->createUrl($this->module->id.'/'.pembebasantarifT.'/admin'), 
array('class' => 'btn btn-default',
'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); */ ?>
            <?php
            $content = $this->renderPartial('rawatJalan.views/tips/transaksiPembebasanTarif', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
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
$criteria = new CDbCriteria();
$criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
$criteria->order = 'nama_pegawai';
$models = DokterV::model()->findAll($criteria);
$dataProvider = new CActiveDataProvider('DokterV', array(
    'criteria' => $criteria,
));
$modDokter = new RJDokterV('searchDokterdialog');
$modDokter->unsetAttributes();
if (isset($_GET['RJDokterV'])) {
    $modDokter->attributes = $_GET['RJDokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rjdokterpembebasan-v-grid',
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
$(\"#' . CHtml::activeId($model, 'pegawai_nama') . '\").val(\"$data->namaLengkap\");
$(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
            setDataPasien();
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
$this->endWidget('ext.bootstrap.widgets.BootGridView');
?>
<script type="text/javascript">
    $(document).ready(function() {
        // Notifikasi Pasien
        <?php
        if (isset($_GET['smspasien'])) {
            if ($_GET['smspasien'] == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                insert_notifikasi(params);
        <?php
            }
        }
        ?>
        // Notifikasi Dokter
        <?php
        if (isset($_GET['smsdokter'])) {
            if ($_GET['smsdokter'] == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS DOKTER',
                    isinotifikasi: 'dr. <?php echo $model->pegawai->nama_pegawai; ?> tidak memiliki nomor mobile'
                }; // 16 
                insert_notifikasi(params);
        <?php
            }
        }
        ?>
    });
</script>