<?php
$this->breadcrumbs = array(
    'Asesmen Awal Medis',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'monitoringintra-t-hd-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this)'),
        ));
?>
<style>
    a.accordion-toggle{
        color: #045702 !important;
        text-decoration: none !important;
        background: #BDEDBC none repeat scroll 0% 0% !important;
        border: 1px solid #b4e8a8 !important;
        font-weight: inherit !important;
        padding: 10px !important;
        font-size: 14px !important;
        border-radius: 5px 5px 0px 0px !important;
    }
    .accordion-inner{
        border: 1px solid #b4e8a8 !important;
    }
</style>
    
<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'list-rujukankeluar',
    'content' => array(
        'content-detailpasien' => array(
            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan Riwayat Hemodialisis Pasien')) . '<b> Riwayat Monitoring Pasien Intra HD</b>',
            'isi' => $this->renderPartial($this->path_view . '_listHD', array(
                'model' => $model,
                'modPendaftaran' => $modPendaftaran,
                'modPasien' => $modPasien,
                'loadRiwayat' => $loadRiwayat
                    ), true),
            'active' => false,
        ),
    ),
));
?>
<div class="panel panel-success" style="margin-top: 18px !important;">
    <div class="panel-body">
        <div class="row-fluid">
            <!--    <div class="span12">
                    <fieldset class="box row-fluid">-->

            <div class="span6">
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal', 'tanggal', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php
//                           (isset($model->waktu_prescription)) ? $model->waktu_prescription : date('d-m-Y');
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tanggal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => 'd M yy',
                                'maxDate' => 'd',
                                'yearRange' => "-60:+0",
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 ', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">DPJP</label>
                    <div class="controls">
                        <?= $form->HiddenField($model, 'dpjp_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                        <?= $form->textField($model, 'dpjp_nama', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group ">
                    <?php echo CHtml::label('Perawat 1', 'perawat1_id', array('class' => 'control-label')) ?>
                    <?php echo CHtml::activeHiddenField($model, 'perawat1_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
                    <div class="controls">
                        <div class="input-append" style='display:inline'>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'perawat1_nama',
                                'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                            url: "' . $this->createUrl('AutoCompletePerawat') . '",
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
                                                            $("#perawat1_id").val(ui.item.perawat1_id); 
                                                            $("#perawat1_nama").val(ui.item.perawat1_nama);
                                                            return false;
                                                    }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPerawat1'),
                                'htmlOptions' => array('class' => 'span4'),
                            ));
                            ?>
                        </div>      
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Perawat 2', 'perawat2_id', array('class' => 'control-label')) ?>
                    <?php echo CHtml::activeHiddenField($model, 'perawat2_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
                    <div class="controls">
                        <div class="input-append" style='display:inline'>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'perawat2_nama',
                                'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                            url: "' . $this->createUrl('AutoCompletePerawat') . '",
                                                            dataType: "json",
                                                            data: {
                                                                    term: request.term,
                                                                    perawat_id: $("#perawat2_id2").val(),
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
                                                            $("#perawat2_id2").val(ui.item.perawat2_id2); 
                                                            $("#perawat2_nama").val(ui.item.perawat2_nama);
                                                            return false;
                                                    }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPerawat2'),
                                'htmlOptions' => array('class' => 'span4'),
                            ));
                            ?>
                        </div>      
                    </div>
                </div>
            </div>

            <!--        </fieldset>
                </div>-->
        </div>
    </div>
</div>
<div class="panel panel-success">
    <!--<div class="span12">-->
    <div class="panel-heading">
        <div class="panel-title">Tindakan Keperawatan</div>
    </div>
    <div class="panel-body">
        <div class="span12">
            <div class="control-group hide">
                <label class="control-label">Akses Vaskuler</label>
                <div class="controls">
                    <?php
                    $akvas = "";
                    if (count($modAksesVaskular) > 0) {
                        foreach ($modAksesVaskular as $akses) {
                            $akvas .= $akses->nama_akses_vaskular . ",";
                        }
                    } else {
                        $akvas .= "-";
                    }
                    ?>
                    <?= CHtml::activeHiddenField($model, 'akses_vaskular', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'value' => $akvas)); ?>

                    <?php
                    if (count($modAksesVaskular) > 0) {
                        foreach ($modAksesVaskular as $value) {
                            echo CHtml::textField('akses_vaskular', $value->nama_akses_vaskular.(!empty($value->hd_kateter)?' - '.$value->hd_kateter:''), array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'disabled' => true, 'style' => 'margin-bottom: 10px;')) . "<br>";
                        }
                    } else {
                        echo CHtml::textField('akses_vaskular', '-', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'disabled' => true));
                    }
                    ?>
                    <?php //$form->textField($model, 'akses_vaskular', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'disabled' => true)); ?>
                </div>
            </div>
<!--            <div class="control-group">
                <label class="control-label">Heparinisasi</label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'heparinisasi_ya', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'cekHeparinisasiYa()')) ?> <label>Ya : </label>
                    <label>- Dosis Awal</label> &nbsp;
                    <?= $form->textField($model, 'heparinisasi_ya_dosis_awal', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'style' => 'margin-left:42px; margin-bottom: 10px;', 'disabled' => true)); ?> <label>international units</label>
                    <div class="control-group">
                        <div class="controls">
                            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Dosis Maintenance</label> &nbsp;
                            <?= $form->textField($model, 'heparinisasi_ya_dosis_maintenan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'disabled' => true)); ?> <label>international units</label>
                        </div>
                    </div>
                </div>
            </div>-->
            <table border="0">
                <tr>
                    <td style="width: 133px; text-align: right; padding-right: 8px;">
                        <label>Heparinisasi</label>
                    </td>
                    <td>
                        <?php echo $form->checkBox($model, 'heparinisasi_ya', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'cekHeparinisasiYa()')) ?> <label>Ya : </label>
                    <label>- Dosis Awal</label>
                    </td>
                    <td style="padding-left: 25px;">
                        <?= $form->textField($model, 'heparinisasi_ya_dosis_awal', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'style' => 'margin-bottom: 10px;', 'disabled' => true)); ?> <label>international units</label>
                    </td>
                </tr>
                <tr>
                    <td style="width: 133px;">
                        
                    </td>
                    <td style="padding-left: 38px;">
                        <label>- Dosis Maintenance</label>
                    </td>
                    <td style="padding-left: 25px;">
                        <?= $form->textField($model, 'heparinisasi_ya_dosis_maintenan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'disabled' => true, 'style' => 'margin-bottom: 10px;')); ?> <label>international units</label>
                    </td>
                </tr>
                <tr>
                    <td style="width: 133px;">
                        
                    </td>
                    <td>
                        <?php echo $form->checkBox($model, 'heparinisasi_tidak', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'cekHeparinisasiTidak()')) ?> <label>Tidak, program bilas NaCL 0,9 % 100 cc </label>
                    </td>
                    <td style="padding-left: 10px;">
                        <?php echo $form->checkBox($model, 'per_jam', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'cekPer_jam()', 'disabled' => true)) ?>
                    <?= $form->textField($model, 'heparinisasi_tidak_per_jam', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'disabled' => true, 'style' => 'margin-bottom: 10px;')); ?> <label>/ jam</label>
                    </td>
                </tr>
                <tr>
                    <td style="width: 133px;">
                        
                    </td>
                    <td>
                        
                    </td>
                    <td style="padding-left: 10px;">
                        <?php echo $form->checkBox($model, 'per_setengah', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'cekPer_setengah()', 'disabled' => true)) ?>
                            <?= $form->textField($model, 'heparinisasi_tidak_per_setengah', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'disabled' => true)); ?> <label>/ 1/2 jam</label>
                    </td>
                </tr>
            </table>
<!--            <div class="control-group">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'heparinisasi_tidak', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'cekHeparinisasiTidak()')) ?> <label>Tidak, program bilas NaCL 0,9 % 100 cc </label>
                    <?php echo $form->checkBox($model, 'per_jam', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'cekPer_jam()', 'disabled' => true)) ?>
                    <?= $form->textField($model, 'heparinisasi_tidak_per_jam', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'disabled' => true, 'style' => 'margin-bottom: 10px;')); ?> <label>/ jam</label> &nbsp;
                    <div class="control-group">
                        <div class="controls">
                            <?php echo $form->checkBox($model, 'per_setengah', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'cekPer_setengah()', 'disabled' => true, 'style' => 'margin-left:210px')) ?>
                            <?= $form->textField($model, 'heparinisasi_tidak_per_setengah', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'disabled' => true)); ?> <label>/ 1/2 jam</label>
                        </div>
                    </div>
                </div>
            </div>-->
            <hr style="height: 1px; width: auto; background: #ababab; margin-left: 10px; margin-right: 10px;" />
        </div>


        <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label class="control-label">Observasi</label>
                <div class="controls">
                    <?php echo CHtml::DropdownList('jenis_observasi', 'Intra HD', CHtml::listData(LookupM::model()->findAll("lookup_type = 'jenis_observasi_hd'"), 'lookup_value', 'lookup_name'), array('class' => 'inputFormTabel span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'onchange' => 'cekObservasi(this)')); ?>

                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Jam', 'jam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
//                           (isset($model->waktu_prescription)) ? $model->waktu_prescription : date('d-m-Y');
                    $this->widget('MyDateTimePicker', array(
                        'name' => 'jam_observasi',
                        'mode' => 'time',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                            'yearRange' => "-60:+0",
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>

                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Blood Flow</label>
                <div class="controls">
                    <?php echo CHtml::textField('blood_flow', $modDetail->blood_flow, array('class' => 'inputFormTabel span3 float', "rel" => "tooltip")) ?><label>ml/mnt</label>
                </div>
            </div>            
             <div class="control-group">
                <label class="control-label">Penyulit Selama HD</label>
                <div class="controls">
                    <?php echo CHtml::dropDownList('penyulit_hd_id', '', CHtml::listData(PenyulitHdM::model()->findAll(), 'penyulit_hd_id', 'penyulit_hd_nama'), array('class' => 'inputFormTabel span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                </div>
            </div>

            <div class="control-group ">
                <label class="control-label"></label>
                <div class="controls">
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambah', array('onclick' => 'tambahTindakanKeperawatan(this);return false;',
                        'class' => 'btn btn-primary',
                        'id' => 'tomboltambahracikan',
                        'onkeypress' => "tambahTindakanKeperawatan(this);return false;",
                        'rel' => "tooltip",
                        'title' => "Klik untuk menambahkan tindakan keperawatan",));
                    ?>
                </div>
            </div>
            
           
        </div>
        <div class="span6">            
            
            
            <div class="control-group">
                <label class="control-label">Tekanan Darah</label>
                <div class="controls">
                    <?php echo CHtml::textField('tensi_sistolik', '', array('class' => 'inputFormTabel span1 integer', "rel" => "tooltip")) ?> / <?php echo CHtml::textField('tensi_diastolik', '', array('class' => 'inputFormTabel span1 integer', "rel" => "tooltip")) ?><label>mmHg</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Nadi</label>
                <div class="controls">
                    <?php echo CHtml::textField('nadi', '', array('class' => 'inputFormTabel span3 integer', "rel" => "tooltip")) ?><label>x/mnt</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Suhu</label>
                <div class="controls">
                    <?php echo CHtml::textField('suhu', '', array('class' => 'inputFormTabel span3 float', "rel" => "tooltip")) ?><label></label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Respirasi</label>
                <div class="controls">
                    <?php echo CHtml::textField('respirasi', '', array('class' => 'inputFormTabel span3 integer', "rel" => "tooltip")) ?><label>x/mnt</label>
                </div>
            </div>
        </div>
        </div>
        <div class="span12 overflow-x">
            <table class="table table-striped" id="table-tindakankeperawatan">
                <thead>
                    <tr style="text-align: center">
                        <th rowspan="2">Observasi</th>
                        <th rowspan="2">Jam</th>
                        <th rowspan="2">Blood Flow (ml/mnt)</th>                        
                        <th rowspan="2">Tekanan Darah (mmHg)</th>
                        <th rowspan="2">Nadi (x/mnt)</th>
                        <th rowspan="2">Suhu (&#8451;)</th>
                        <th rowspan="2">Respirasi (x/mnt)</th>
                        
                <th rowspan="2">Penyulit HD</th>
                <th rowspan="2">Nama Pegawai</th>
                <th rowspan="2">Aksi</th>
                </tr>               
                </thead>
                <tbody>
                    <?php if (count($modLoadDetail) > 0) : ?>
                        <?php foreach ($modLoadDetail as $row):
                            if (!empty($row->penyulit_hd_id)){
                                $penyulit = PenyulitHdM::model()->findByPk($row->penyulit_hd_id);
                                $penyulit_nama = $penyulit->penyulit_hd_nama;
                                $data = $row->attributes;
                                $data['konsulpoli_id'] = isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null;
                                $data['tensi_sis'] = $data['tensi_sistolik'];
                                $data['tensi_dia'] = $data['tensi_diastolik'];
                                $data['intake_lain'] = $data['intake_lainnya_keterangan'];
                                $data['output_lain'] = $data['output_lainnya_keterangan'];
                                echo $this->renderPartial('_rowDetailPenyulit', array('model'=>$model,'data'=>$data,'pendaftaran_id'=>$model->pendaftaran_id,'penyulit_nama'=>$penyulit_nama,'modDetail' => $row)); 
                            }else{
                                echo $this->renderPartial('_rowDetail', array('modDetail' => $row)); 
                            }
                        endforeach; ?>
                    <?php endif; ?>
                </tbody>
                
            </table>
        </div>
    </div>


    <!--</fieldset>-->
    <!--</div>-->
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Prescription Dokter</div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Reseptur',
        );

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <div class="col-md-6">
            <div class="control-group ">
                <?php echo CHtml::label('Waktu prescription <span class="required">*</span>', 'tanggal', array('class' => 'control-label required')) ?>
                <div class="controls">
                    <?php
//                           (isset($model->waktu_prescription)) ? $model->waktu_prescription : date('d-m-Y');
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modPrescriptionDokter,
                        'attribute' => 'waktu_prescription',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                            'yearRange' => "-60:+0",
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Prescription Dokter</label>
                <div class="controls">
                    <?= $form->radioButton($modPrescriptionDokter, 'prescription_dokter', array('value' => 'akut', 'uncheckValue' => null)) ?><label>Akut</label> &nbsp;
                    <?= $form->radioButton($modPrescriptionDokter, 'prescription_dokter', array('value' => 'kronis', 'uncheckValue' => null)) ?><label>Kronis</label> &nbsp;
                    <?= $form->radioButton($modPrescriptionDokter, 'prescription_dokter', array('value' => 'pirrt', 'uncheckValue' => null)) ?><label>PIRRT</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Time</label>
                <div class="controls"><?= $form->textField($modPrescriptionDokter, 'durasi_time', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 integer')); ?>
                    <?= $form->dropDownList($modPrescriptionDokter, 'time_satuan', CHtml::listData(LookupM::model()->findAll("lookup_type='satuanlamanyeri' AND lookup_aktif=TRUE"), 'lookup_name', 'lookup_name'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'empty' => '--Pilih--')); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Blood Flow</label>
                <div class="controls"><?= $form->textField($modPrescriptionDokter, 'blood_flow', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?><label>mL/menit</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dialysate Flow</label>
                <div class="controls"><?= $form->textField($modPrescriptionDokter, 'dialysate_flow', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float',)); ?><label>mL/menit</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dialysate</label>
                <div class="controls">
                    <?php echo $form->checkBox($modPrescriptionDokter, 'dialysate_bicarbonat', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkDialysate("bicarbonat")')) ?> <label>Bicarbonat</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                    <?php echo $form->checkBox($modPrescriptionDokter, 'dialysate_lainnya', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkDialysate("lainnya")')) ?> <label>Lainnya</label>
                    <?php echo $form->textField($modPrescriptionDokter, 'dialysate_lainnya_keterangan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dialyser</label>
                <div class="controls"><?= $form->textField($modPrescriptionDokter, 'diayser', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?></div>
            </div>
            <div class="control-group">
                <label class="control-label">Dialyser Temperature</label>
                <div class="controls"><?= $form->textField($modPrescriptionDokter, 'dialyser_temperature', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?><label>&#8451;</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Ultra Filtration Goal</label>
                <div class="controls"><?= $form->textField($modPrescriptionDokter, 'uf_goal', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?></div>
            </div>
            <div class="control-group">
                <label class="control-label">Akses Vaskuler</label>
                <div class="controls">
                    <?php if (count($modAksesVaskular) > 0) : ?>
                        <?php foreach ($modAksesVaskular as $av) : ?>
                            <?= CHtml::textField('aksesvaskular[]', $av->nama_akses_vaskular.(!empty($av->hd_kateter)?' - '.$av->hd_kateter:''), array('readonly' => true, 'style' => 'margin-bottom: 10px;')) ?><br>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <?= $form->textField($modPrescriptionDokter, 'akses_vaskular', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'disabled' => true)); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Catatan Lain</label>
                <div class="controls"><?= $form->textArea($modPrescriptionDokter, 'catatan_lain', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'style' => 'width:285px; height: 100px')); ?></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="control-group">
                <label class="control-label">DPJP <span class="required">*</span></label>
                <div class="controls">
                    <?= $form->dropDownList($modPrescriptionDokter, 'dpjp_id', CHtml::listData(PegawaiM::model()->findAll('pegawai_aktif is true and kelompokpegawai_id = 1'), 'pegawai_id', 'namaLengkap'),array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'required search-dropdown', 'readonly' => false, 'empty' => '-- Pilih --')); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Heparinisasi</label>
                <div class="controls">
                    <?php echo $form->checkBox($modPrescriptionDokter, 'heparinisasi_standar', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkHeparinisasi("standar")')) ?> <label>Standar</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                    <?php echo $form->checkBox($modPrescriptionDokter, 'heparinisasi_minimal', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkHeparinisasi("minimal")')) ?> <label>Minimal</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                    <?php echo $form->checkBox($modPrescriptionDokter, 'heparinisasi_tanpaheparin', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkHeparinisasi("tanpaheparin")')) ?> <label>Tanpa Heparin</label>
                    <?php echo $form->textField($modPrescriptionDokter, 'heparinisasi_tanpaheparin_penyebab', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                    <?php echo $form->checkBox($modPrescriptionDokter, 'heparinisasi_lmwh', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkHeparinisasi("lmwh")')) ?> <label>LMWH</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                    <?php echo $form->checkBox($modPrescriptionDokter, 'heparinisasi_lainnya', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkHeparinisasi("lainnya")')) ?> <label>lainnya</label>
                    <?php echo $form->textField($modPrescriptionDokter, 'heparinisasi_lainnya_penyebab', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Selisih BB</label>
                <div class="controls"><?= $form->textField($modPrescriptionDokter, 'selisih_berat_badan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?> <label>Kg</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Infus</label>
                <div class="controls"><?= $form->textField($modPrescriptionDokter, 'infus', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?> <label>mL</label>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php echo $form->checkBox($modPrescriptionDokter, 'transfusi_darah', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>Transfusi Darah</label>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php echo $form->checkBox($modPrescriptionDokter, 'penggunaan_elektropetin', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>Penggunaan Elektropetin</label>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php echo $form->checkBox($modPrescriptionDokter, 'penggunaan_zatbesi', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>Penggunaan Zat Besi</label>
                </div>
            </div>
        </div>
        </fieldset>
        <!--</div>-->
    </div>
</div>
<div class="row-fluid" id="form-aksi">
    <div class="span12">
        <div class="form-actions">

            <?php
            if (isset($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'id' => 'btn_submit', 'disabled' => true)) . "&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']), array(
                    'class' => 'btn btn-default',
                    'onclick' => 'window.parent.myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']) . '";}); return false;'
                )) . "&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info',
                    'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ",'".(isset($_GET['intra_hd_id'])?$_GET['intra_hd_id']:'')."');return false")) . "&nbsp;";
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'id' => 'btn_submit', 'onclick' => 'cekInsert();', 'onKeypress' => 'cekInsert();', 'disabled' => (isset($_GET['sukses'])) ? true : false)) . "&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']), array(
                    'class' => 'btn btn-default',
                    'onclick' => 'window.parent.myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']) . '";}); return false;'
                )) . "&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
            }
            ?>

        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Alat Kesehatan ala cak lontong (non racik - therapi obat)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPerawat1',
    'options' => array(
        'title' => 'Data Perawat',
        'autoOpen' => false,
        'position' => ['top', 20],
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('searchDialog2');
$modPegawai->unsetAttributes();
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}
$modPegawai->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'perawat1-grid',
    'dataProvider' => $modPegawai->searchDialogPegRuangan(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectPerawat1",
                                    "onClick" => "
                                                $(\"#HDMonitoringIntraHdT_perawat1_id\").val(\"$data->pegawai_id\"); 
                                                $(\"#HDMonitoringIntraHdT_perawat1_nama\").val(\"$data->nama_pegawai\"); 
                                                $(\'#dialogPerawat1\').dialog(\'close\');
                                                return false;"))',
        ),
        'nama_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari data Alat Kesehatan ala cak lontong (non racik - therapi obat)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPerawat2',
    'options' => array(
        'title' => 'Data Perawat',
        'autoOpen' => false,
        'position' => ['top', 20],
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('searchDialog2');
$modPegawai->unsetAttributes();
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}
$modPegawai->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'perawat2-grid',
    'dataProvider' => $modPegawai->searchDialogPegRuangan(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectPerawat2",
                                    "onClick" => "
                                                $(\"#HDMonitoringIntraHdT_perawat2_id\").val(\"$data->pegawai_id\"); 
                                                $(\"#HDMonitoringIntraHdT_perawat2_nama\").val(\"$data->nama_pegawai\"); 
                                                $(\'#dialogPerawat2\').dialog(\'close\');
                                                return false;"))',
        ),
        'nama_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<!--<div class="frame-dialog"></div>-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogTransfusi',
    'options' => array(
        'title' => 'Perkembangan Terintgrasi Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'minHeight' => 610,
        'resizable' => true,
    ),
));
?>
<div class="frame-dialog"></div>
<iframe src="" name="iframeDetPengeluaran" width="100%" height="550" ></iframe>
<?php
$this->endWidget();
?>


<!--<div class="frame-dialog"></div>-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObs',
    'options' => array(
        'title' => 'Transfusi Darah',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'minHeight' => 610,
        'resizable' => true,
    ),
));
?>
<div class="frame-dialog"></div>
<iframe src="" name="iframeObs" width="100%" height="550" ></iframe>
<?php
$this->endWidget();
?>

<script>
    $(document).ready(function () {
<?php if (isset($_GET['mode'])) { ?>
            $("#monitoringintra-t-hd-form").find('input,select,textarea, button').each(function () {
                $(this).attr('disabled', true);
            });
<?php } ?>
    
    <?php if (isset($_GET['detail'])) { ?>
            $("#monitoringintra-t-hd-form").find('input,select,textarea, button').each(function () {
                $(this).attr('disabled', true);
            });
            $('#form-aksi').hide();
            $('#list-rujukankeluar').hide();
    <?php } ?>
    });

    function stopTindakanDialisis(obj){
        var konsulpoli_id = $(obj).data('konsul');
        var id = $(obj).data('id');
        
        window.parent.myConfirm("Apakah akan melakukan Stop Tindakan ?","Perhatian!", function(r){
            if (r){
                $.ajax({
                    url: '<?= $this->createUrl('stopTindakanDialisis') ?>',
                    dataType: 'json',
                    type: 'post',
                    data:{id:id,konsulpoli_id:konsulpoli_id},
                    success: function(data){
                        if(data.sukses == 1){
                            window.parent.toastr.success(data.pesan, 'Perhatian!');                    
                        }else{
                            window.parent.toastr.error(data.pesan,'Perhatian!');
                        }
                    }
                })
            }
        })
        
    }

    function cekInsert() {
        $(".integer").each(function () {
            $(this).val(parseInt(unformatNumber($(this).val())));
        });
        $(".float").each(function () {
            $(this).val(parseFloat(unformatNumber($(this).val())));
        });

//            var hd = $('#HDInformtoconsentHdT_hd').val();
//            console.log(hd);return false;

        $('#monitoringintra-t-hd-form').submit();


    }
    function cekHeparinisasiYa()
    {
        if ($('#HDMonitoringIntraHdT_heparinisasi_ya').is(":checked")) {
            $('#HDMonitoringIntraHdT_heparinisasi_ya_dosis_awal').attr('disabled', false);
            $('#HDMonitoringIntraHdT_heparinisasi_ya_dosis_maintenan').attr('disabled', false);
        } else {
            $('#HDMonitoringIntraHdT_heparinisasi_ya_dosis_awal').attr('disabled', true);
            $('#HDMonitoringIntraHdT_heparinisasi_ya_dosis_maintenan').attr('disabled', true);
            $('#HDMonitoringIntraHdT_heparinisasi_ya_dosis_awal').val('');
            $('#HDMonitoringIntraHdT_heparinisasi_ya_dosis_maintenan').val('');
        }
    }
    function cekHeparinisasiTidak()
    {
        if ($('#HDMonitoringIntraHdT_heparinisasi_tidak').is(":checked")) {
            $('#HDMonitoringIntraHdT_per_jam').attr('disabled', false);
            $('#HDMonitoringIntraHdT_per_setengah').attr('disabled', false);

        } else {
            $('#HDMonitoringIntraHdT_per_jam').attr('disabled', true);
            $('#HDMonitoringIntraHdT_per_setengah').attr('disabled', true);
        }
    }
    function cekPer_jam() {
        if ($('#HDMonitoringIntraHdT_per_jam').is(":checked")) {
            $('#HDMonitoringIntraHdT_heparinisasi_tidak_per_jam').attr('disabled', false);
        } else {
            $('#HDMonitoringIntraHdT_heparinisasi_tidak_per_jam').attr('disabled', true);
            $('#HDMonitoringIntraHdT_heparinisasi_tidak_per_jam').val('');
        }
    }
    function cekPer_setengah() {
        if ($('#HDMonitoringIntraHdT_per_setengah').is(":checked")) {
            $('#HDMonitoringIntraHdT_heparinisasi_tidak_per_setengah').attr('disabled', false);
        } else {
            $('#HDMonitoringIntraHdT_heparinisasi_tidak_per_setengah').attr('disabled', true);
            $('#HDMonitoringIntraHdT_heparinisasi_tidak_per_setengah').val('');
        }
    }
    function cekIntakeNacl() {
        if ($('#intake_nacl').is(":checked")) {
            $('#intake_nacl_keterangan').attr('disabled', false);
        } else {
            $('#intake_nacl_keterangan').attr('disabled', true);
            $('#intake_nacl_keterangan').val('');
        }
    }
    function cekIntakeLain() {
        if ($('#intake_lainnya').is(":checked")) {
            $('#intake_lainnya_keterangan').attr('disabled', false);
        } else {
            $('#intake_lainnya_keterangan').attr('disabled', true);
            $('#intake_lainnya_keterangan').val('');
        }
    }
    function cekOutputUf() {
        if ($('#output_uf_goal').is(":checked")) {
            $('#output_uf_goal_keterangan').attr('disabled', false);
        } else {
            $('#output_uf_goal_keterangan').attr('disabled', true);
            $('#output_uf_goal_keterangan').val('');
        }
    }
    function cekOutputLain() {
        if ($('#output_lainnya').is(":checked")) {
            $('#output_lainnya_keterangan').attr('disabled', false);
        } else {
            $('#output_lainnya_keterangan').attr('disabled', true);
            $('#output_lainnya_keterangan').val('');
        }
    }
    function cekObservasi(obj) {
        console.log(obj.value);
        if (obj.value == 'Pre - HD') {
            console.log('yes');
            $.ajax({
                url: '<?= $this->createUrl('setObservasi') ?>',
                dataType: 'json',
                type: 'post',
                data: {
                    pendaftaran_id:<?= $_GET['pendaftaran_id'] ?>
                },
                success: function (data) {
                    console.log(data.suhu);
                    $('#tensi_sistolik').val(data.tensi_sis);
                    $('#tensi_diastolik').val(data.tensi_dia);
                    $('#nadi').val(data.nadi);
                    $('#suhu').val(data.suhu);
                    $('#respirasi').val(data.respirasi);
                }
            })
        }
    }
    function tambahTindakanKeperawatan() {
        var observasi = $('#jenis_observasi').val();
        var jam = $('#jam_observasi').val();
        var blood_flow = $('#blood_flow').val();
        var uf_rate = $('#uf_rate').val();
        var tensi_sis = $('#tensi_sistolik').val();
        var tensi_dia = $('#tensi_diastolik').val();
        var nadi = $('#nadi').val();
        var suhu = $('#suhu').val();
        var respirasi = $('#respirasi').val();
        if ($('#intake_nacl').is(":checked")) {
            var intakeNaclBol = 1;
        } else {
            var intakeNaclBol = 0;
        }
        if ($('#intake_lainnya').is(":checked")) {
            var intakeLainBol = 1;
        } else {
            var intakeLainBol = 0;
        }
        var intakeNacl = $('#intake_nacl_keterangan').val();
        var intakeLain = $('#intake_lainnya_keterangan').val();
        if ($('#output_uf_goal').is(":checked")) {
            var outputUfBol = 1;
        } else {
            var outputUfBol = 0;
        }
        if ($('#output_lainnya').is(":checked")) {
            var outputLainBol = 1;
        } else {
            var outputLainBol = 0;
        }
        var outputUf = $('#output_uf_goal_keterangan').val();
        var outputLain = $('#output_lainnya_keterangan').val();
        var penyulit_id = $('#penyulit_hd_id').val();
        var pendaftaran_id = <?= $_GET["pendaftaran_id"] ?>;

        var intra_tanggal = $('#HDMonitoringIntraHdT_tanggal').val();
        var intra_dpjp = $('#HDMonitoringIntraHdT_dpjp_id').val();
        var intra_perawat1 = $('#HDMonitoringIntraHdT_perawat1_id').val();
        var intra_perawat2 = $('#HDMonitoringIntraHdT_perawat2_id').val();
        var intra_akses_vaskular = $('#HDMonitoringIntraHdT_akses_vaskular').val();
        var intra_dosis_awal = $('#HDMonitoringIntraHdT_heparinisasi_ya_dosis_awal').val();
        var intra_dosis_maintenan = $('#HDMonitoringIntraHdT_heparinisasi_ya_dosis_maintenan').val();
        var intra_tidak_per_jam = $('#HDMonitoringIntraHdT_heparinisasi_tidak_per_jam').val();
        var intra_tidak_per_set_jam = $('#HDMonitoringIntraHdT_heparinisasi_tidak_per_setengah').val();
        var konsulpoli_id = '<?= (isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null) ?>';
//        if (observasi == "") {
//            alert('Pilih Observasi dahulu');
//            return false;
//        }
        $.ajax({
            url: "<?= $this->createUrl('setTindakanKeperawatan'); ?>",
            dataType: 'json',
            type: 'post',
            data: {
                observasi: observasi,
                jam: jam,
                blood_flow: blood_flow,
                uf_rate: uf_rate,
                tensi_sis: tensi_sis,
                tensi_dia: tensi_dia,
                nadi: nadi,
                suhu: suhu,
                respirasi: respirasi,
                intakeNaclBol: intakeNaclBol,
                intakeNacl: intakeNacl,
                intakeLainBol: intakeLainBol,
                intakeLain: intakeLain,
                outputUfBol: outputUfBol,
                outputUf: outputUf,
                outputLainBol: outputLainBol,
                outputLain: outputLain,
                penyulit_id: penyulit_id,
                pendaftaran_id: pendaftaran_id,
                intra_tanggal: intra_tanggal,
                intra_dpjp: intra_dpjp,
                intra_perawat1: intra_perawat1,
                intra_perawat2: intra_perawat2,
                intra_akses_vaskular: intra_akses_vaskular,
                intra_dosis_awal: intra_dosis_awal,
                intra_dosis_maintenan: intra_dosis_maintenan,
                intra_tidak_per_jam: intra_tidak_per_jam,
                intra_tidak_per_set_jam: intra_tidak_per_set_jam,
                konsulpoli_id: konsulpoli_id
            },
            success: function (data) {
                $('#table-tindakankeperawatan > tbody').append(data.form);
                $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney({"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": "", "precision": 0}
                );
                renameInputRowObatAlkes($("#table-tindakankeperawatan"));
                hitungIntakeNacl();
                hitungIntakeLain();
                hitungOutputUf();
                hitungOutputLain();
                hitungTotalIntake();
                hitungTotalOutput();
                clearInput();

            }
        })
//        console.log(jam);
    }
    function renameInputRowObatAlkes(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(row + 1);
//            $(this).find('span').each(function () { //element <input>
//                var old_name = $(this).attr("name").replace(/]/g, "");
//                var old_name_arr = old_name.split("[");
//                if (old_name_arr.length == 3) {
//                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
//                }
//            });
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });

//        $("#RJResepturT_noresep").blur();
    }
    function hitungIntakeNacl() {
        var total = 0;
        $('.intake_nacl_ket').each(
                function () {
//			qty = $(this).parents('tr').find('.gty').val();
                    total_harga = unformatNumber(this.value);
                    total += total_harga;
                }
        );

        $('#HDMonitoringIntraHdT_jumlah_intake_nacl').val(total);

    }
    function hitungIntakeLain() {
        var total = 0;
        $('.intake_lain_ket').each(
                function () {
//			qty = $(this).parents('tr').find('.gty').val();
                    total_harga = unformatNumber(this.value);
                    total += total_harga;
                }
        );

        $('#HDMonitoringIntraHdT_jumlah_intake_lainnya').val(total);

    }
    function hitungOutputUf() {
        var total = 0;
        $('.output_uf_ket').each(
                function () {
//			qty = $(this).parents('tr').find('.gty').val();
                    total_harga = unformatNumber(this.value);
                    total += total_harga;
                }
        );

        $('#HDMonitoringIntraHdT_jumlah_output_ufgoal').val(total);

    }
    function hitungOutputLain() {
        var total = 0;
        $('.output_lain_ket').each(
                function () {
//			qty = $(this).parents('tr').find('.gty').val();
                    total_harga = unformatNumber(this.value);
                    total += total_harga;
                }
        );

        $('#HDMonitoringIntraHdT_jumlah_output_lainnya').val(total);

    }
    function hitungTotalIntake() {
        var nacl = $('#HDMonitoringIntraHdT_jumlah_intake_nacl').val();
        var lain = $('#HDMonitoringIntraHdT_jumlah_intake_lainnya').val();
        var total = parseFloat(nacl) + parseFloat(lain);


        $('#HDMonitoringIntraHdT_total_intake').val(total);

    }
    function hitungTotalOutput() {
        var uf = $('#HDMonitoringIntraHdT_jumlah_output_ufgoal').val();
        var lain = $('#HDMonitoringIntraHdT_jumlah_output_lainnya').val();
        var total = parseFloat(uf) + parseFloat(lain);


        $('#HDMonitoringIntraHdT_total_output').val(total);

    }

    function batalTindakanKeperawatan(obj) {
        window.parent.myConfirm("Apakah anda akan membatalkan penjualan obat alkes ini?", "Perhatian!",
                function (r) {
                    if (r) {
                        $(obj).parents('tr').detach();
                        renameInputRowObatAlkes($("#table-tindakankeperawatan"));
                        hitungIntakeNacl();
                        hitungIntakeLain();
                        hitungOutputUf();
                        hitungOutputLain();
                        hitungTotalIntake();
                        hitungTotalOutput();
                    }
                });
    }

    function clearInput() {
        $('#jenis_observasi').val('');
        $('#jam_observasi').val('');
        $('#blood_flow').val('');
        $('#uf_rate').val('');
        $('#tensi_sistolik').val('');
        $('#tensi_diastolik').val('');
        $('#nadi').val('');
        $('#suhu').val('');
        $('#respirasi').val('');
        $('#intake_nacl_keterangan').val('');
        $('#intake_lainnya_keterangan').val('');
        $('#output_uf_goal_keterangan').val('');
        $('#output_lainnya_keterangan').val('');
        $('#penyulit_hd_id').val('');
        $('#intake_nacl').attr("checked", false);
        cekIntakeNacl();
        $('#intake_lainnya').attr("checked", false);
        cekIntakeLain();
        $('#output_uf_goal').attr("checked", false);
        cekOutputUf();
        $('#output_lainnya').attr("checked", false);
        cekOutputLain();
    }
    function hapusRiwayat(id) {
        window.parent.myConfirm('Apakah anda yakin menghapus data ini ?', 'Perhatian!', function (r) {
            if (r) {
                $.ajax({
                    url: '<?= $this->createUrl('hapusRiwayat') ?>',
                    dataType: 'json',
                    type: 'post',
                    data: {id: id},
                    success: function (data) {
                        if (data.sukses == 1) {
                            window.parent.toastr.success(data.pesan, 'Perhatian!');
                            location.href = "<?= $this->createUrl('index&pendaftaran_id=') . $_GET['pendaftaran_id'] ?>&konsulpoli_id=<?= isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null ?>";
                        } else {
                            window.parent.toastr.error(data.pesan, 'Perhatian!');
                        }
                    }
                })
            }
        })
    }
    function print(pendaftaran_id, monitoringintraid)
    {
        window.open('<?php echo $this->createUrl('printRiwayat'); ?>&monitoringintraid=' + monitoringintraid + '&id=' + pendaftaran_id+'&konsulpoli_id=<?= isset($_GET['konsulpoli_id'])?$_GET['konsulpoli_id']:null ?>', 'printwin', 'left=100,top=100,width=640,height=640');
    }

    function generateForm(obj, pendaftaran_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GenerateForm'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                formdata: $(obj).parents("tr").find('input,select,textarea').serialize()
            },
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    $("#dialogTransfusi").dialog("open");
                    $(".frame-dialog").html(data.html);

//                    setTimeout(generatePicker(jenis),500);
                } else {
                    window.parent.myAlert(data.pesan);
                }
            },
            //error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }

    $(function () { 
        var classDrop = jQuery('.search-dropdown');
     
        jQuery(classDrop).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                onDropdownShown: function(even) {
                    setTimeout(function(){
                        $('.search-dropdown').parent().find("input[type='text'].multiselect-search").focus();
                    }, 100);
                },
                enableCaseInsensitiveFiltering: true
        }).hide();
    })


</script>
