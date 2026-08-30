<?php
$myicon = new MyIcon();
$this->breadcrumbs = array(
    'Observasi Transfusi Darah HD',
);


?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'observasitransfusidarahhd-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
//        'focus'=>'#namaObatNonRacik',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        ));
?>

<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'list-rujukankeluar',
    'content' => array(
        'content-detailpasien' => array(
            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan Riwayat Transfusi Darah')) . '<b> Riwayat Transfusi Darah</b>',
            'isi' => $this->renderPartial($this->path_view . '_listHD', array(
                'model' => $model,
                'modPendaftaran' => $modPendaftaran,
                'modPasien' => $modPasien,
                'loadRiwayat' => $loadRiwayat,
                    ), true),
            'active' => true,
        ),
    ),
));
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Observasi Transfusi Darah</div>
    </div>
    <div class="panel-body">
<?php
$this->widget('bootstrap.widgets.BootAlert');
?>

        <div class="row-fluid">
            <div class="span12">
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label">Kantong Darah</label>
                            <div class="controls">
                                <?php
                                echo CHtml::DropdownList('kantong_darah', '', CHtml::listData(KantongTransfusiDarahDetT::model()->findAll("pendaftaran_id = " . $_GET['pendaftaran_id']), 'kantong_transfusi_darah_det_id', 'no_kantongdarah'), array('class' => 'inputFormTabel span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'));
//echo CHtml::DropdownList('kantong_darah', !empty($model->kantong_transfusi_darah_det_id) ? $model->kantong_transfusi_darah_det_id : '', CHtml::listData($model->getKantongDarah($_GET['pendaftaran_id']), 'kantong_transfusi_darah_det_id', 'no_kantongdarah'), array('class' => 'inputFormTabel span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Tanggal Observasi', 'tanggal', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'name' => 'tanggal_observasi',
                                    'attribute' => 'tanggal_observasi',
//                                'value' => !empty($model->tanggal_observasi) ? date('d-m-Y', strtotime($model->tanggal_observasi)) : '',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMATV2,
                                        'maxDate' => 'd',
                                        'yearRange' => "-60:+0",
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'class' => 'dtPicker3 datemask3 span3',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Jam Observasi', 'jam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'name' => 'jam_observasi',
                                    'attribute' => 'jam_observasi',
//                                'value' => !empty($model->jam_observasi) ? date('H:i:s', strtotime($model->jam_observasi)) : '',
                                    'mode' => 'time',
                                    'options' => array(
                                        'dateFormat' => Params::TIME_FORMAT,
                                        'maxDate' => 'd',
                                        'yearRange' => "-60:+0",
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 timemask3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Reaksi transfusi', 'reaksi_transfusi', array('class' => 'control-label')) ?>
                            <div class="controls">                                
                                    <?= CHtml::textField('reaksi_transfusi', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>                                
                            </div>
                            <div class="controls">
                                <?=
                                    CHtml::link('<span style="font-size:20px"><i class="fa fa-plus"></i></span>', 'javascript:void(0);', array('class' => '',
                                        'onclick' => "addReaksi();return false", 'style' => 'margin-left:10px;')) . "&nbsp;";
                                    ?>
                            </div>
                        </div>
                        
                        <table id="tbl-reaksi">
                            <tbody>
                                <?php
//                                    if (!empty($model->observasi_transfusi_darah_id)) {
//                                        $reaksi = ReaksiTransfusiT::model()->findAll("observasi_transfusi_darah_id = " . $model->observasi_transfusi_darah_id);
//                                        if (count($reaksi) > 0) {
//                                            foreach ($reaksi as $key => $rks) {
                                ?>
<!--                                                <tr class="tr-reaksi" baris="<?php //echo $key;  ?>">
                                                <td>-->
                                <?php //echo CHtml::TextField('[' . $key . ']reaksi_transfusi', '' . $rks->nama_reaksi_transfusi . '', array('readonly' => true, 'class' => 'span3 reaksi_transfusi')); ?>
                                <!--                                                    </td>
                                                                                    <td>-->
                                <?php //echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-minus-sign"></i>')), 'javascript:void(0);', array('class' => '', 'onclick' => "batalReaksi(this);return false", 'title' => 'Klik untuk membatalkan reaksi transfusi')) . "&nbsp;"; ?>
                                <!--                                                    </td>
                                                                                </tr>   -->
                                <?php
//        }
//    }
//}
                                ?>
                            </tbody>
                        </table>
                           
                        <div class="control-group ">
                            <label class="control-label">Keluhan</label>
                            <div class="controls">
                                <div class="input-append" style='display:inline'>
                                    <?= CHtml::textField('keluhan', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
                                    <?php //echo CHtml::textField('keluhan', !empty($model->keluhan) ? $model->keluhan : '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
                                </div>      
                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label">Kesadaran</label>
                            <div class="controls">
                                <div class="input-append" style='display:inline'>
                                    <?= CHtml::textField('kesadaran', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
                                    <?php // CHtml::textField('kesadaran', !empty($model->kesadaran) ? $model->kesadaran : '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
                                </div>      
                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label"></label>
                            <div class="controls">
                                <?php
                                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambah', array('onclick' => 'tambahObservasiTransfusiDarah();return false;',
                                    'class' => 'btn btn-primary',
                                    'id' => 'tomboltambahObservasiTransfusiDarah',
                                    'onkeypress' => "tambahObservasiTransfusiDarah(this);return false;",
                                    'rel' => "tooltip",
                                    'title' => "Klik untuk menambahkan Observasi Transfusi Darah",));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group ">
                            <label class="control-label">Tekanan Darah</label>
                            <div class="controls">
                                <?= CHtml::TextField('tensi_sistolik', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer')); ?> &nbsp; / &nbsp;
                                <?= CHtml::TextField('tensi_diatolik', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer')); ?>
                                <?php // CHtml::TextField('tensi_sistolik', !empty($model->tensi_sistolik) ? $model->tensi_sistolik : '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer')); ?> 
                                <?php // CHtml::TextField('tensi_diatolik', !empty($model->tensi_diatolik) ? $model->tensi_diatolik : '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer')); ?>

                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label">Nadi</label>
                            <div class="controls">
                                <div class="input-append" style='display:inline'>
                                    <?= CHtml::textField('nadi', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 integer')); ?>
                                    <?php // CHtml::textField('nadi', !empty($model->nadi) ? $model->nadi : '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 integer')); ?>
                                </div>      
                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label">Suhu</label>
                            <div class="controls">
                                <div class="input-append" style='display:inline'>
                                    <?= CHtml::textField('suhu', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?>
                                    <?php //CHtml::textField('suhu', !empty($model->suhu) ? $model->suhu : '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?>
                                </div>      
                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label">Pernapasan</label>
                            <div class="controls">
                                <div class="input-append" style='display:inline'>
                                    <?= CHtml::textField('pernapasan', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 integer')); ?>
                                    <?php //CHtml::textField('pernapasan', !empty($model->pernapasan) ? $model->pernapasan : '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 integer')); ?>
                                </div>      
                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label">Lainnya</label>
                            <div class="controls">
                                <div class="input-append" style='display:inline'>
                                    <?= CHtml::textField('lainnya', '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
                                    <?php //CHtml::textField('lainnya', !empty($model->lainnya) ? $model->lainnya : '', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
                                </div>      
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Petugas Observasi', 'petugas_observasi_id', array('class' => 'control-label')) ?>
                            <?php echo CHtml::HiddenField('petugas_observasi_id', '', array('readonly' => true, 'style' => 'width:110px;')); ?>
                            <?php //echo CHtml::HiddenField('petugas_observasi_id', !empty($model->petugas_observasi_id) ? $model->petugas_observasi_id : '', array('readonly' => true, 'style' => 'width:110px;')); ?>
                            <div class="controls">
                                <div class="input-append" style='display:inline'>
                                    <?php
                                    $this->widget('MyJuiAutoComplete', array(
                                        'name' => 'petugas_observasi_nama',
                                        'attribute' => 'petugas_observasi_nama',
//                                    'value' => !empty($model->petugas_observasi_nama) ? $model->petugas_observasi_nama : '',
                                        'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                            url: "' . $this->createUrl('AutoCompletePetugasObservasi') . '",
                                                            dataType: "json",
                                                            data: {
                                                                    term: request.term,
                                                                    perawat_id: $("#perawat1_id").val(),
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
                                                            $("#petugas_observasi_id").val(ui.item.pegawai_id); 
                                                            $("#petugas_observasi_nama").val(ui.item.nama_pegawai);
                                                            return false;
                                                    }',
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogPetugasObservasi'),
                                        'htmlOptions' => array('class' => 'span3'),
                                    ));
                                    ?>
                                </div>      
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span12 overflow-x">
                    <table class="table table-striped" id="tbl-observasitransfusi" style="width: 100%">
                        <tr>
                            <th>No. Kantong Darah</th>
                            <th>Tgl. Observasi</th>
                            <th>Jam Observasi</th>
                            <th>Reaksi Transfusi</th>
                            <th>Keluhan</th>
                            <th>Kesadaran</th>
                            <th>Tek. Darah (mmHg)</th>
                            <th>Nadi</th>
                            <th>Suhu(&#8451;)</th>
                            <th>Pernapasan</th>
                            <th>Lainnya (warna dan produksi urin)</th>
                            <th>Petugas Observasi</th>
                            <th></th>
                        </tr>
                        <tbody>
                            <?php if(count($modLoad) > 0) : ?>
                            <?php foreach ($modLoad as $key => $row) : ?>
                                <tr class="tr-observasitransfusi" baris="<?= $key; ?>">
                                    <td>
                                        <?= CHtml::activeHiddenField($model, '[' . $key . ']kantong_transfusi_darah_det_id', array('readonly' => true, 'class' => 'span2', 'value'=>$row->kantong_transfusi_darah_det_id)); ?>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']no_kantongdarah', array('readonly' => true, 'class' => 'span2', 'value'=>$row->no_kantongdarah)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']tanggal_observasi', array('readonly' => false, 'class' => '', 'style' => 'width: 80px;', 'value'=>$row->tanggal_observasi)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']jam_observasi', array('readonly' => false, 'class' => '', 'style' => 'width: 80px;', 'value'=>$row->jam_observasi)); ?>
                                    </td>
                                    <td>
                                        <?php
                                            $reaksi = ReaksiTransfusiT::model()->findAll('observasi_transfusi_darah_id = '.$row->observasi_transfusi_darah_id);
                                            $str = "";
                                            if(!empty($reaksi)){
                                                foreach($reaksi as $no=>$value){
                                                    $str .= $value->nama_reaksi_transfusi.'-';
                                                }
                                            }
                                            
                                            if($str != ''){
                                                $str = substr($str, 0, -1);
                                            }
                                        ?>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']reaksi_transfusi', array('readonly' => false, 'class' => '', 'style' => 'width: 80px;', 'value'=>$str)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']keluhan', array('readonly' => false, 'class' => 'span2', 'value'=>$row->keluhan)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']kesadaran', array('readonly' => false, 'class' => 'span2', 'value'=>$row->kesadaran)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']tensi_sistolik', array('readonly' => false, 'class' => 'span1', 'value'=>$row->tensi_sistolik)); ?> /
                                        <?= CHtml::activeTextField($model, '[' . $key . ']tensi_diatolik', array('readonly' => false, 'class' => 'span1', 'value'=>$row->tensi_diatolik)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']nadi', array('readonly' => false, 'class' => 'span1', 'value'=>$row->nadi)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']suhu', array('readonly' => false, 'class' => 'span1', 'value'=>$row->suhu)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']pernapasan', array('readonly' => false, 'class' => 'span1', 'value'=>$row->pernapasan)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']lainnya', array('readonly' => false, 'class' => 'span2', 'value'=>$row->lainnya)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeHiddenField($model, '[' . $key . ']petugas_observasi_id', array('readonly' => true, 'class' => 'span1', 'value'=>$row->petugas_observasi_id)); ?>
                                        <?php
                                            $nama = "";
                                            if(!empty($row->petugas_observasi_id)){
                                                $pegawai = PegawaiM::model()->findByPk($row->petugas_observasi_id);
                                                $nama = $pegawai->nama_pegawai;
                                            }
                                        ?>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']petugas_observasi_nama', array('readonly' => false, 'class' => 'span3', 'value'=>$nama)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-minus-sign"></i>')), 'javascript:void(0);', array('class' => '', 'onclick' => "batalObservasiTransfusi(this);return false", 'title' => 'Klik untuk membatalkan Observasi Transfusi')) . "&nbsp;"; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid" id="form-aksi">
    <div class="span12">
        <div class="form-actions">

            <?php
            if (isset($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => 'btn btn-danger', 'id' => 'btn_submit', 'disabled' => true)) . "&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']), array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']) . '";}); return false;'
                )) . "&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-success',
                    'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ",'');return false")) . "&nbsp;";
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'id' => 'btn_submit', 'onclick' => 'cekInsert();', 'onKeypress' => 'cekInsert();', 'disabled' => (isset($_GET['sukses'])) ? true : false)) . "&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']), array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']) . '";}); return false;'
                )) . "&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
            }
            ?>

        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Alat Kesehatan ala cak lontong (non racik - therapi obat)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugasObservasi',
    'options' => array(
        'title' => 'Data Transfusi',
        'autoOpen' => false,
        'position' => ['top', 20],
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('searchDialogPegRuangan');
$modPegawai->unsetAttributes();
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'therapiobat-grid',
    'dataProvider' => $modPegawai->searchDialogPegRuangan(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\"#petugas_observasi_id\").val(\"$data->pegawai_id\"); 
                                        $(\"#petugas_observasi_nama\").val(\"$data->nama_pegawai\"); 
                                        $(\'#dialogPetugasObservasi\').dialog(\'close\');
                                        return false;"))',
        ),
        'nama_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<script>
    $(document).ready(function () {
        // disable form ketika mode "lihat"
<?php if (isset($_GET['mode'])) { ?>
            $("#observasitransfusidarahhd-t-form").find('input,select,textarea, button').each(function () {
                $(this).attr('disabled', true);
            });
<?php } ?>

    <?php if (isset($_GET['detail'])) {            
        ?>
            $("#observasitransfusidarahhd-t-form").find('input,select,textarea, button').each(function () {
                $(this).attr('disabled', true);
            });
            $('#list-rujukankeluar').hide();
            $('#form-aksi').hide();
    <?php } ?>
    })

    function cekInsert() {
        $('#observasitransfusidarahhd-t-form').submit();
    }

    function addReaksi() {
        var reaksi_transfusi = $('#reaksi_transfusi').val();
        var key = $('.tr-reaksi:last').attr('baris');
        if (key == null) {
            var key = 0;
        }
        var keyNew = parseInt(key) + 1;

        if (reaksi_transfusi == "") {
            alert('isi Reaksi transfusi dahulu');
            return false;
        } else {
            $.ajax({
                url: '<?= $this->createUrl('addReaksi'); ?>',
                dataType: 'json',
                type: 'post',
                data: {reaksi_transfusi: reaksi_transfusi, key: keyNew},
                success: function (data) {
                    $('#tbl-reaksi > tbody').append(data.form);
                    $('#reaksi_transfusi').val('');
                }
            })
        }
    }

    function batalReaksi(obj) {
        $(obj).parents("tr").detach();
    }

    function tambahObservasiTransfusiDarah() {
        var key = $('.tr-observasitransfusi:last').attr('baris');
        var kantongdarahid = $('#kantong_darah').val();
        var tanggal_observasi = $('#tanggal_observasi').val();
        var jam_observasi = $('#jam_observasi').val();
        var keluhan = $('#keluhan').val();
        var kesadaran = $('#kesadaran').val();
        var tensi_sistolik = $('#tensi_sistolik').val();
        var tensi_diatolik = $('#tensi_diatolik').val();
        var nadi = $('#nadi').val();
        var suhu = $('#suhu').val();
        var pernapasan = $('#pernapasan').val();
        var lainnya = $('#lainnya').val();
        var petugas_observasi_id = $('#petugas_observasi_id').val();
        var petugas_observasi_nama = $('#petugas_observasi_nama').val();
        var reaksi = "";

        $('input.reaksi_transfusi').each(function () {
            reaksi += $(this).val() + "-";
        });
//        console.log(reaksi);return false;

//        console.log(tanggal_observasi);
        if (key == null) {
            var key = 0;
        }
        var keyNew = parseInt(key) + 1;

        $.ajax({
            url: '<?= $this->createUrl("AddObservasiTransfusi") ?>',
            dataType: 'json',
            type: 'post',
            data: {
                key: keyNew,
                kantongdarahid: kantongdarahid,
                tanggal_observasi: tanggal_observasi,
                jam_observasi: jam_observasi,
                reaksi_transfusi: reaksi,
                keluhan: keluhan,
                kesadaran: kesadaran,
                tensi_sistolik: tensi_sistolik,
                tensi_diatolik: tensi_diatolik,
                nadi: nadi,
                suhu: suhu,
                pernapasan: pernapasan,
                lainnya: lainnya,
                petugas_observasi_id: petugas_observasi_id,
                petugas_observasi_nama: petugas_observasi_nama,
            },
            success: function (data) {
                $('#tbl-observasitransfusi > tbody:last').append(data.form);
                clearForm();
            }
        })
    }

    function batalObservasiTransfusi(obj) {
        $(obj).parents("tr").detach();
    }

    function clearForm() {
        var kantongdarahid = $('#kantong_darah').val('');
        var tanggal_observasi = $('#tanggal_observasi').val('');
        var jam_observasi = $('#jam_observasi').val('');
        var keluhan = $('#keluhan').val('');
        var kesadaran = $('#kesadaran').val('');
        var tensi_sistolik = $('#tensi_sistolik').val('');
        var tensi_diatolik = $('#tensi_diatolik').val('');
        var nadi = $('#nadi').val('');
        var suhu = $('#suhu').val('');
        var pernapasan = $('#pernapasan').val('');
        var lainnya = $('#lainnya').val('');
        var petugas_observasi_id = $('#petugas_observasi_id').val('');
        var petugas_observasi_nama = $('#petugas_observasi_nama').val('');
    }

    function hapusRiwayat(id) {
        myConfirm('Apakah anda yakin menghapus data ini ?', 'Perhatian!', function (r) {
            if (r) {
                $.ajax({
                    url: '<?= $this->createUrl('hapusRiwayat') ?>',
                    dataType: 'json',
                    type: 'post',
                    data: {id: id},
                    success: function (data) {
                        if (data.sukses == 1) {
                            toastr.success(data.pesan, 'Perhatian!');
                            location.href = "<?= $this->createUrl('index&pendaftaran_id=') . $_GET['pendaftaran_id'] ?>";
                        } else {
                            toastr.error(data.pesan, 'Perhatian!');
                        }
                    }
                })
            }
        })
    }

    function print(pendaftaran_id, kantong_transfusi_darah_id)
    {
        window.open('<?php echo $this->createUrl('printRiwayat'); ?>&kantong_transfusi_darah_id=' + kantong_transfusi_darah_id + '&id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=640,height=640');
    }

</script>