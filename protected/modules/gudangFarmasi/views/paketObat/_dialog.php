
<?php
//========= Dialog buat cari data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Pencarian Data Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 550,
        'resizable' => false,
    ),
));
$modPegawai = new DokterV('searchByDokter');
$modPegawai->unsetAttributes();
if(isset($_GET['DokterV'])){
    $modPegawai->attributes = $_GET['DokterV'];
    $modPegawai->jabatan_nama = isset($_GET['DokterV']['jabatan_nama'])?$_GET['DokterV']['jabatan_nama']:null;
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaiYangMengajukan-m-grid',
    'dataProvider'=>$modPegawai->searchAllDokter(),
    'filter'=>$modPegawai,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"$(\"#GFPaketobatM_dokter_id\").val(\"$data->pegawai_id\");
                            $(\"#GFPaketobatM_nama_pegawai\").val(\"$data->nama_pegawai\");
                            $(\"#GFPaketobatM_jabatan_nama\").val(\"$data->jabatan_nama\");
                            $(\"#dialogDokter\").dialog(\"close\");
                            return false;"
                ))'
        ),
        'nomorindukpegawai',
        array(
            'header' => 'Dokter',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap'
        ),        
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_nama',
            'value' => '$data->jabatan_nama'
        ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>


<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'dialogObatAlkes',
        'options'=>array(
            'title'=>'Pencarian Obat Alkes',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>600,
            'resizable'=>false,
        ),
    ));
    
    $modObatalkes = new ObatalkesM;
    $modObatalkes->unsetAttributes();
    if (isset($_GET['ObatalkesM'])) {
        $modObatalkes->attributes = $_GET['ObatalkesM'];      
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'obatalkes-grid',
        'dataProvider'=>$modObatalkes->searchPaketObat(),
        'filter'=>$modObatalkes,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'columns'=>array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => function($data){
                    echo CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "onClick" => ''
                        . '$("#PaketobatdetailM_obatalkes_id").val("'.$data->obatalkes_id.'");'
                        . '$("#PaketobatdetailM_obatalkes_nama").val("'.$data->obatalkes_nama.'");'
                        . '$("#dialogObatAlkes").dialog("close");',
                     ));
                },
            ),
            array(
                'header'=>'Kode Obat',
                'name' => 'obatalkes_kode',
                'value'=>'$data->obatalkes_kode',
            ),
            array(
                'header'=>'Nama Obat',
                'name' => 'obatalkes_nama',
                'value'=>'$data->obatalkes_nama',
            ),
            array(
                'header'=>'Jenis',
                'name' => 'jenisobatalkes_id',
                'value'=>'(isset($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "-")',
                'filter' => CHtml::dropDownList('ObatalkesM[jenisobatalkes_id]', $modObatalkes->jenisobatalkes_id, CHtml::listData(JenisobatalkesM::model()->findAll("jenisobatalkes_aktif = TRUE ORDER BY jenisobatalkes_nama ASC"), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty'=>'-- Pilih --'))
            ),
            array(
                'header'=>'Kategori',
                'name' => 'obatalkes_kategori',
                'value'=>'$data->obatalkes_kategori',
                'filter' => CHtml::dropDownList('ObatalkesM[obatalkes_kategori]', $modObatalkes->obatalkes_kategori, LookupM::getItems('obatalkes_kategori'), array('empty'=>'-- Pilih --'))
            ),
            array(
                'header'=>'Golongan',
                'name' => 'obatalkes_golongan',
                'value'=>'$data->obatalkes_golongan',
                'filter' => CHtml::dropDownList('ObatalkesM[obatalkes_golongan]', $modObatalkes->obatalkes_golongan, LookupM::getItems('obatalkes_golongan'), array('empty'=>'-- Pilih --'))
            ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
$this->endWidget();
?>