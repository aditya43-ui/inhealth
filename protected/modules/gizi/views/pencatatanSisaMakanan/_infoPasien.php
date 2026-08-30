<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Pasien</div>
    </div>
    <div class="panel-body" id="panel_info">
        <div class='row-fluid'>
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(RuanganpasiengdietV::model()->findAll(array('order'=>'instalasi_id, ruangan_nama')), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'onchange'=>'setDialogPasien();', 'class'=>'info_ruangan_id')); ?>
                <div class='control-group'>
                    <?php echo $form->label($kunjungan, 'nama_pasien', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'pasienadmisi_id', array('class'=>'info_pasienadmisi_id')); ?>
                        <?php
                        if (!$kunjungan->isNewRecord) {
                            echo $form->textField($kunjungan, 'nama_pasien', array('class'=>'info_nama_pasien', 'readonly'=>true));
                        } else {
                        
                            $this->widget('MyJuiAutoComplete', array(
                                'name' => 'info_nama_pasien',
                                'value' => empty($kunjungan->nama_pasien) ? "" : $kunjungan->nama_pasien,
                                'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('AutocompletePasien') . '",
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
                                    'focus' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.label);
                                            return false;
                                        }',
                                    'select' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($model, 'pasienadmisi_id') . '").val(ui.item.pasienadmisi_id); 
                                            return false;
                                        }',
                                ),
                                'htmlOptions' => array('class' => 'span3 info_nama_pasien'),
                                'tombolDialog' => array('idDialog' => 'dialogPasien'),
                            ));
                        }
                        ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($kunjungan, 'tanggal_lahir', array('readonly'=>true, 'class'=>'info_tanggal_lahir')); ?>
                <?php echo $form->textFieldRow($kunjungan, 'no_rekam_medik', array('readonly'=>true, 'class'=>'info_no_rekam_medik')); ?>
                <?php echo $form->textFieldRow($kunjungan, 'jeniskasuspenyakit_nama', array('readonly'=>true, 'class'=>'info_jeniskasuspenyakit_nama')); ?>
            </div>
            <div class="col-sm-6">
                <div class='control-group'>
                    <label class='control-label'>Tgl Masuk RS/<br/>No. Pendaftaran</label>
                    <div class="controls">
                        <?php echo CHtml::textField('info_tgl_no_pendaftaran', (empty($kunjungan->pendaftaran_id) ? "" : ($kunjungan->tgl_pendaftaran." / ".$kunjungan->no_pendaftaran)), array('class'=>'info_tgl_no_pendaftaran', 'readonly'=>true)); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($kunjungan, 'nama_pegawai', array('readonly'=>true, 'class'=>'info_nama_pegawai')); ?>
                <?php echo $form->textFieldRow($kunjungan, 'statusperiksa', array('readonly'=>true, 'class'=>'info_statusperiksa')); ?>
                <div class='control-group'>
                    <label class='control-label'>Ruangan Perawatan/ No. Kamar, No. Bed</label>
                    <div class="controls">
                        <?php echo $form->textField($kunjungan, 'ruangan_nama', array('readonly'=>true, 'class'=>'info_ruangan_nama')); ?>
                        
                    </div>
                </div>
                <div class='control-group'>
                    <label class='control-label'>Jenis Penjamin / Penjamin</label>
                    <div class="controls">
                        <?php echo $form->textField($kunjungan, 'carabayar_nama', array('readonly'=>true, 'class'=>'info_carabayar_nama')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

if (empty($_GET['ajax']) || $_GET['ajax'] == 'infokunjunganri-v-grid') {

//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Daftar Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));

$modelPasien = new InfokunjunganriV('search');
$modelPasien->unsetAttributes();
if (isset($_GET['InfokunjunganriV'])) {
    $modelPasien->attributes = $_GET['InfokunjunganriV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'infokunjunganri-v-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modelPasien->search(),
    'filter' => $modelPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
    
                $data->tanggal_lahir = MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
                $data->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($data->tgladmisi);
                $data->ruangan_nama = $data->ruangan_nama." / ".$data->kamarruangan_nokamar." - ".$data->kamarruangan_nobed;
                $data->carabayar_nama = $data->carabayar_nama." / ".$data->penjamin_nama;
                
                $arr = $data->attributes;
                
                $tgl_awal = new DateTime($data->tgladmisi);
                $tgl_akhir = new DateTime(date('Y-m-d H:i:s'));
                
                $interval = $tgl_awal->diff($tgl_akhir);
                $arr['hari'] = $interval->days;
                
                
                
                $diagnosa_utama = "";
                $diagnosa_penyerta = "";

                if (!empty($kunjungan)) {
                    $diagnosa_utama_data = PasienmorbiditasT::model()->findByAttributes(array(
                        'pendaftaran_id' => $kunjungan->pendaftaran_id,
                        'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA,
                    ));
                    $diagnosa_penyerta_data = PasienmorbiditasT::model()->findByAttributes(array(
                        'pendaftaran_id' => $kunjungan->pendaftaran_id,
                        'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_TAMBAH,
                    ));

                    if (!empty($diagnosa_utama_data)) {
                        $diagnosa_utama = empty($diagnosa_utama_data->diagnosa) ? "" : ($diagnosa_utama_data->diagnosa->diagnosa_kode." - ".$diagnosa_utama_data->diagnosa->diagnosa_nama);
                    }
                    if (!empty($diagnosa_penyerta_data)) {
                        $diagnosa_penyerta = empty($diagnosa_penyerta_data->diagnosa) ? "" : ($diagnosa_penyerta_data->diagnosa->diagnosa_kode." - ".$diagnosa_penyerta_data->diagnosa->diagnosa_nama);
                    }
                }
                
                $arr['diagnosa_utama'] = $diagnosa_utama;
                $arr['diagnosa_penyerta'] = $diagnosa_penyerta;
                
                
                
                
    
                return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectPasien",
                    "onClick" => "setInputPasien(".CJSON::encode($arr).");
                                  $(\"#dialogPasien\").dialog(\"close\");    
                "));
    
            },
            'filter'=>CHtml::activeHiddenField($modelPasien, 'ruangan_id', array('class'=>'dialog_ruangan_id')),
        ),
        'no_rekam_medik',
        array(
            'name'=>'nama_pasien',
            'value'=>'$data->namadepan.$data->nama_pasien',
        ),
        'umur',
        array(
            'name'=>'jeniskelamin',
            'filter'=>CHtml::activeDropDownList($modelPasien, 'jeniskelamin', LookupM::getItemsUrutan('jeniskelamin'), array('empty'=>'-- Pilih --')),
        ),
        array(
            'name'=>'carabayar_id',
            'value'=>'$data->carabayar_nama',
            'filter'=>CHtml::activeDropDownList($modelPasien, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true order by carabayar_nama'), 'carabayar_id', 'carabayar_nama'), array('empty'=>'-- Pilih --')),
        ),
        array(
            'name'=>'penjamin_id',
            'value'=>'$data->penjamin_nama',
            'filter'=>CHtml::activeDropDownList($modelPasien, 'penjamin_id', empty($modelPasien->carabayar_id) ? array() : CHtml::listData(PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$modelPasien->carabayar_id, 'penjamin_aktif'=>true), array('condition'=>'penjamin_aktif = true', 'order'=>'penjamin_nama')), 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --')),
        ),
        'statusperiksa',
        'kamarruangan_nokamar',
        'kamarruangan_nobed',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================


}
?>


<script>
    
    function setDialogPasien() {
        var ruangan_id = $(".info_ruangan_id").val();
        
        $("#infokunjunganri-v-grid .dialog_ruangan_id").val(ruangan_id);
        $.fn.yiiGridView.update('infokunjunganri-v-grid', {data: $("#infokunjunganri-v-grid :input").serialize()});
    }
    
    function setInputPasien(data) {
        $(".info_pasienadmisi_id").val(data.pasienadmisi_id);
        $(".info_nama_pasien").val(data.nama_pasien);
        $(".info_tanggal_lahir").val(data.tanggal_lahir);
        $(".info_no_rekam_medik").val(data.no_rekam_medik);
        $(".info_jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
        $(".info_tgl_no_pendaftaran").val(data.tgl_pendaftaran + " / " + data.no_pendaftaran);
        $(".info_nama_pegawai").val(data.nama_pegawai);
        $(".info_statusperiksa").val(data.statusperiksa);
        $(".info_ruangan_nama").val(data.ruangan_nama);
        $(".info_carabayar_nama").val(data.carabayar_nama);
        $(".info_ruangan_id").val(data.ruangan_id).change();
        $("#SisamakananpasienT_hariperawatke").val(data.hari);
        $("#diagnosa_utama").val(data.diagnosa_utama);
        $("#diagnosa_penyerta").val(data.diagnosa_penyerta);
        
        $.fn.yiiGridView.update('riwayatsisamakanan-grid', {data: $("#panel_info :input").serialize() });
    }
    
</script>