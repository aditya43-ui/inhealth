<?php
//========= Dialog buat cari data Pendonor =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPendonor',
    'options' => array(
        'title' => 'Pencarian Pendonor',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPendonor = new BDPendonorM('searchDialog');
$modPendonor->unsetAttributes();
if (isset($_GET['BDPendonorM'])) {
    $modPendonor->attributes = $_GET['BDPendonorM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimenyetujui-grid',
    'dataProvider' => $modPendonor->searchDialog(),
    'filter' => $modPendonor,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $res = $data->attributes;

                $photo = $data->photopendonor;
                $path_file = $path_file = Params::urlPendonorDirectory() . 'no_photo.jpeg';
                if (!empty($photo)) {
                    if (file_exists(Params::pathPendonorDirectory() . $photo)) {
                        $path_file = Params::urlPendonorDirectory() . $photo;
                    }
                }
                $id = $data->pendonor_id;
                $res['photopendonor'] = $photo;
                $res['path_file'] = $path_file;
                $res['temp_file'] = $photo;
                $res['pegawai'] = '';
                $res['sudahadapegawai'] = '';
                if (!empty($data->pegawai_id)){
                    $peg = PegawaiM::model()->findByPK($data->pegawai_id);
                    $res['sudahadapegawai'] = 'ada';
                    $res['pegawai'] = $peg->attributes;
                }

                $res = json_encode($res);

                return CHtml::Link("<i class='icon-form-check'></i>", "javascript:;", array("class" => "btn-small",
                            "href" => "",
                            "id" => "selectObat",
                            "onClick" => 'cekData("pegawai",'.$id.');'));
            },
        ),
        'no_pendonor',
        'no_identitas',
        'nama_lengkap',
        'tempat_lahir',
        array(
            'header' => 'Tanggal Lahir',
            'name' => 'tgllahir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgllahir)',
            'filter' => $this->widget('MyDateTimePicker', array(
                'model' => $modPendonor,
                'attribute' => 'tgllahir',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT
                ),
                'htmlOptions' => array('readonly' => false, 'id' => 'tgllahir', 'class' => 'dtPicker3'),
                    ), true
            ),
        ),
        'jenis_kelamin',
        'gol_darah',
        'rhesus',
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});

            jQuery(\'#tgllahir\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
            jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
            jQuery(\'#tgllahir_date\').on(\'click\', function(){jQuery(\'#tgllahir\').datepicker(\'show\');}); 
    }',
));
$this->endWidget();
//========= end Pendonor dialog =============================
?>