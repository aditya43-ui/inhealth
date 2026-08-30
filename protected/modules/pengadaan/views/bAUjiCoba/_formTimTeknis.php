<div class="row-fluid">
    <div class="col-sm-12">
        <p><b>Tenaga Teknis Instalasi</b></p>
        <table id="tabelTimTeknis" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center; width: 30px;">No.</th>
                    <th style="text-align: center">Nama Tim Teknis <span class="required">*</span> </th>
                    <th style="text-align: center">NIP </th>
                    <!--<th style="text-align: center">Jabatan</th>-->
                    <th style="text-align: center" class="aksi"> Aksi </th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="col-sm-12">
        <p><b>Teknisi Penyedia</b></p>
        <table id="tabelTimPenyedia" class="table table-striped table-bordered" style="width: 500px;">
            <thead>
                <tr>
                    <th style="text-align: center; width: 30px;">No.</th>
                    <th style="text-align: center">Nama Teknisi Penyedia <span class="required">*</span> </th>
                    <th style="text-align: center" class="aksi"> Aksi </th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialog1',
    'options' => array(
        'title' => 'Pencarian Pegawai Tim Teknis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPihak1 = new PegawaiV('search');
$modPihak1->unsetAttributes();
$modPihak1->pegawai_aktif = true;
if (isset($_GET['PegawaiV'])) {
    $modPihak1->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'teknisi-grid',
    'dataProvider' => $modPihak1->search(),
    'filter' => $modPihak1,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                "id" => "selectPegawai",
                "onClick" => "
                        setPegawaiDialog($data->pegawai_id);
                "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPihak1, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPihak1, 'jabatan_id', CHtml::listData(
                JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'
            ), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                if (empty($data->jabatan_id))
                    return "-";
                $jabatan = JabatanM::model()->findByPk($data->jabatan_id);
                return $jabatan->jabatan_nama;
            },
        ),
        array(
            'header' => 'Unit Kerja',
            'name' => 'unitkerja_id',
            'filter' => CHtml::activeDropDownList($modPihak1, 'unitkerja_id', CHtml::listData(
                UnitkerjaM::model()->findAll('unitkerja_aktif = true order by namaunitkerja'), 'unitkerja_id', 'namaunitkerja'
            ), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                if (empty($data->unitkerja_id))
                    return "-";
                $unit = UnitkerjaM::model()->findByPk($data->unitkerja_id);
                if (empty($data->namaunitkerja)) {
                    return "-";                    
                } else {
                    return $unit->namaunitkerja;
                }
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialog2',
    'options' => array(
        'title' => 'Pencarian Pegawai Tim Teknis Penyedia',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPihak1 = new PegawaiV('search');
$modPihak1->unsetAttributes();
$modPihak1->pegawai_aktif = true;
if (isset($_GET['PegawaiV'])) {
    $modPihak1->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'penyedia-grid',
    'dataProvider' => $modPihak1->search(),
    'filter' => $modPihak1,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                "id" => "selectPegawai",
                "onClick" => "
                    setPenyediaDialog($data->pegawai_id, \"$data->nama_pegawai\");
                "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPihak1, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPihak1, 'jabatan_id', CHtml::listData(
                JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'
            ), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                if (empty($data->jabatan_id))
                    return "-";
                $jabatan = JabatanM::model()->findByPk($data->jabatan_id);
                return $jabatan->jabatan_nama;
            },
        ),
        array(
            'header' => 'Unit Kerja',
            'name' => 'unitkerja_id',
            'filter' => CHtml::activeDropDownList($modPihak1, 'unitkerja_id', CHtml::listData(
                UnitkerjaM::model()->findAll('unitkerja_aktif = true order by namaunitkerja'), 'unitkerja_id', 'namaunitkerja'
            ), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                if (empty($data->unitkerja_id))
                    return "-";
                $unit = UnitkerjaM::model()->findByPk($data->unitkerja_id);
                if (empty($data->namaunitkerja)) {
                    return "-";                    
                } else {
                    return $unit->namaunitkerja;
                }
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>