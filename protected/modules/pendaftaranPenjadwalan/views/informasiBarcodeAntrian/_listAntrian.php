<?php
//Yii::import("pendaftaranPenjadwalan.models.PPPasienM");

$kec_id = null;
$format = new MyFormatter;
$modPasien = new PPPasienM;
$modPasien->default = 'kosong';
if (isset($_GET['PPPasienM'])){
    $modPasien->attributes = $_GET['PPPasienM'];
    $modPasien->default = isset($_GET['PPPasienM']['default'])?$_GET['PPPasienM']['default']:null;
    $modPasien->nama_bin = isset($_GET['PPPasienM']['nama_bin'])?$_GET['PPPasienM']['nama_bin']:null;

    $modPasien->tanggal_lahir =  isset($_GET['PPPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['PPPasienM']['tanggal_lahir']) : null;
    $modPasien->cari_kelurahan_nama = isset($_GET['PPPasienM']['cari_kelurahan_nama'])?$_GET['PPPasienM']['cari_kelurahan_nama']:null;
    $modPasien->cari_kecamatan_nama = isset($_GET['PPPasienM']['cari_kecamatan_nama'])?$_GET['PPPasienM']['cari_kecamatan_nama']:null;
    if (isset($_GET['PPPasienM']['nomorindukpegawai'])) {
        $modPasien->nomorindukpegawai = $_GET['PPPasienM']['nomorindukpegawai'];
    }
    if (isset($_GET['PPPasienM']['tanggal_lahir'])) {
        $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForDB($_GET['PPPasienM']['tanggal_lahir']);
    }
    
    $kec = KecamatanM::model()->findByAttributes(array(
        'kecamatan_nama' => $modPasien->cari_kecamatan_nama,
        'kecamatan_aktif' => true,
    ));

    if (empty($kec))
        $kec_id = null;
    else
        $kec_id = $kec->kecamatan_id;
}

$drop_lookjeniskelamin = LookupM::getItems('jeniskelamin');
$prov = $modPasien->searchDialog();

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kunjungan-m-grid',
    'dataProvider' => $prov,
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data){
                $res = $data->attributes;
                $res = json_encode($res);    
                return CHtml::Link("<i class='icon-form-check'></i>","javascript:void(0);",array("class"=>"btn-small",
                        "id" => "selectPasien",
                        "onClick" => "
                            setPasienLama(".$res.");                            
                        "));
            },
        ),
        array(
            'name' => 'no_rekam_medik',
            'type' => 'raw',
            'value' => function($data){
                $res = $data->attributes;
                $res = json_encode($res);  
                return CHtml::Link($data->no_rekam_medik,"javascript:void(0);",array("class"=>"btn-small",
                        "id" => "selectPasien",
                        "onClick" => "
                            setPasienLama(".$res.");                            
                        "));
            }
        ),
        array(
            'name' => 'nama_pasien',
            'type' => 'raw',
            'value' => function($data){
                $res = $data->attributes;
                $res = json_encode($res);  
                return CHtml::Link($data->nama_pasien,"javascript:void(0);",array("class"=>"btn-small",
                        "id" => "selectPasien",
                        "onClick" => "
                            setPasienLama(".$res.");                            
                        "));
            }
        ),
        // 'no_rekam_medik',
        // 'nama_pasien',
        'nama_bin',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => $drop_lookjeniskelamin,
            'value' => function($data){
                $res = $data->attributes;
                $res = json_encode($res);  
                return CHtml::Link($data->jeniskelamin,"javascript:void(0);",array("class"=>"btn-small",
                        "id" => "selectPasien",
                        "onClick" => "
                            setPasienLama(".$res.");                            
                        "));
            }
            //'value' => '$data->jeniskelamin'
        ),      
        array(
            'name' => 'tanggal_lahir',            
            'filter' => CHtml::activeTextField($modPasien, 'tanggal_lahir', array('autocomplete' => 'on', 'style' => '', 'placeholder' => '00/00/0000', 'class' => 'form-control dtPicker2 datemask span3', 'onkeyup' => "return $(this).focusNextInputField(event)")),
            'htmlOptions' => array('width' => '140', 'style' => 'text-align:center'),
        ),
        'alamat_pasien',
        //'rw',
        //'rt',
        array(
            'header' => 'Nama Kecamatan',
            'name' => 'cari_kecamatan_nama',
            'type' => 'raw',
            'value' => '$data->kecamatan->kecamatan_nama',
            'filter' => CHtml::activeDropDownList($modPasien, 'cari_kecamatan_nama', CHtml::listData(KecamatanM::model()->findAll(array(
                'condition' => 'kecamatan_aktif = true',
                'order' => 'kecamatan_nama asc',
            )), 'kecamatan_nama', 'kecamatan_nama'), array(
                'empty' => '-- Pilih --',
            )),
        ),
        array(
            'header' => 'Nama Kelurahan',
            'name' => 'cari_kelurahan_nama',
            'type' => 'raw',
            'value' => 'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""',
            'filter' => CHtml::activeDropDownList($modPasien, 'cari_kelurahan_nama', CHtml::listData(KelurahanM::model()->findAllByAttributes(array(
                'kecamatan_id' => $kec_id,
            ), array(
                'condition' => 'kelurahan_aktif = true',
                'order' => 'kelurahan_nama asc',
            )), 'kelurahan_nama', 'kelurahan_nama'), array(
                'empty' => '-- Pilih --',
            )),
        ),
        'norm_lama',
        array(
            'name' => 'statusrekammedis',
            'type' => 'raw',
            'filter' => LookupM::getItems('statusrekammedis'),
            'value' => '$data->statusrekammedis',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
                        showMonthAfterYear:false},
                        jQuery.datepicker.regional[\'id\'],
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'\'}));
                // jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});


            }',
        ));