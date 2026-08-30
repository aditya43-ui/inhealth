<?php

/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @digunakan   - mengenerate data ke tabel partograf lain - lain, per baris
 * @website     <http://> 
 * RSST-1603
 */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogUbah',
    'options' => array(
        'title' => 'Ubah Data <span class="judul-ubah"></span>',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'close' => 'js:function(){$("#form-dialog-ubah").html(""); $(".tab_iv").empty();}'
    ),
));
?>
<?php echo CHtml::hiddenField("noUrut", 0); ?>

<div id="form-dialog-ubah" class="form-horizontal">

    <?php //echo $this->renderPartial($this->path_view.'subyektif/_formTambahRiwayat',array('model'=>$model)); 
    ?>

</div>

<?php $this->endWidget(); ?>

<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogOA',
    'options' => array(
        'title' => 'Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));

$format = new MyFormatter();
$modObatAlkes = new ObatalkesM();
$modObatAlkes->unsetAttributes();
if (isset($_GET['ObatalkesM'])) {
    $modObatAlkes->attributes = $_GET['ObatalkesM'];
    $modObatAlkes->obatalkes_kode = isset($_GET['ObatalkesM']['obatalkes_kode']) ? $_GET['ObatalkesM']['obatalkes_kode'] : null;
    $modObatAlkes->satuankecil_nama = isset($_GET['ObatalkesM']['satuankecil_nama']) ? $_GET['ObatalkesM']['satuankecil_nama'] : null;
}

$provider = $modObatAlkes->search();
$provider->sort->defaultOrder = 'obatalkes_nama asc';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $provider,
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        tambahObat(".CJSON::encode($data->attributes).");
                                        $(\'#dialogOA\').dialog(\'close\');
                                        return false;"
                                        ))',
        ),
        array(
            'header' => 'Jenis Obat Alkes',
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => '(!empty($data->jenisobatalkes) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
            'filter' =>  CHtml::activeDropDownList($modObatAlkes, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll(array(
                'condition' => 'jenisobatalkes_aktif = true',
                'order' => 'jenisobatalkes_nama'
            )), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --')),
        ),

        array(
            'name' => 'obatalkes_kategori',
            'filter' => CHtml::activeDropDownList($modObatAlkes, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --'))
        ),
        array(
            'name' => 'obatalkes_golongan',
            'filter' => CHtml::activeDropDownList($modObatAlkes, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --'))
        ),
        //'obatalkes_kode',
        'obatalkes_nama',


    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
			jQuery(\'#tglkadaluarsa\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tglkadaluarsa_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});}',
));

$this->endWidget(); ?>