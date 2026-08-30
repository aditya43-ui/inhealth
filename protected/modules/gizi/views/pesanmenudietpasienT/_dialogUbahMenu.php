<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogUbahMenu',
        'options' => array(
           'title' => '<span class="judul-tambah">Ubah Menu Diet</span>',
            'autoOpen' => false,
            'modal' => true,            
            'width' => 600,
            'height' => 450,
            'resizable' => true,
            'close' => 'js:function(){
                $("#tambah-menu-diet").html("");
                loadRiwayatPesan();
            }'
        ),
    ));
?>
<div id="ubah-menu-diet" class="form-horizontal">

</div>
<?php
    $this->endWidget(); 


    // dialog jenis diet

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'jenisDietNama',
        'options' => array(
            'title' => 'Jenis Diet',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $modJenisDiet = new GZJenisdietM('search');
    $modJenisDiet->unsetAttributes();
    if (isset($_GET['GZJenisdietM'])){
        $modJenisDiet->attributes = $_GET['GZJenisdietM'];    
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'grid-jenisdiet',
        'dataProvider' => $modJenisDiet->searchJenisDiet(),
        'filter' => $modJenisDiet,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                    "id" => "selectBahan",
                    "onClick" => "
                    $(\'#dlg_jenisdiet_id\').val($data->jenisdiet_id);
                    $(\'#jenisdiet_id_filter\').val($data->jenisdiet_id);
                    $(\'#dialog_jenisdiet_nama\').val(\'$data->jenisdiet_nama\');
                    $(\'#dlg_menudiet_id\').val(\'\');
                    $(\'#dlg_menudiet_nama\').val(\'\');
                    refreshDialogMenuDiet1();
                    $(\'#jenisDietNama\').dialog(\'close\');return false;"))',
            ),
            array(
                'header' => 'Jenis Diet',
                'name'=>'jenisdiet_nama',
                //'filter'=>Chtml::dropDownList('GZJenisdietM[jenisdiet_id]', GZJenisdietM->jenisdiet_id, '$data',array('empty'=>'-- Pilih --'))
            ),
            // 'jenisdiet_nama',
            //'jenisdiet_namalainnya',
            'jenisdiet_keterangan',
            'jenisdiet_catatan',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();


    // menu diet

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'menuDietNama',
        'options' => array(
            'title' => 'Daftar Menu Diet ',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'resizable' => false,
            // 'close' => 'js:function(){resetChecked();}'
        ),
    ));
    
    $modMenuDiet = new GZMenuDietM();
    $modMenuDiet->unsetAttributes();
    if (isset($_GET['GZMenuDietM'])){
        $modMenuDiet->attributes = $_GET['GZMenuDietM'];
        $modMenuDiet->jenisdiet_id = isset($_GET['GZMenuDietM']['jenisdiet_id']) ? $_GET['GZMenuDietM']['jenisdiet_id'] : null;
        $modMenuDiet->menudiet_nama = isset($_GET['GZMenuDietM']['menudiet_nama']) ? $_GET['GZMenuDietM']['menudiet_nama'] : null;
        $modMenuDiet->jeniswaktu_id = isset($_GET['GZMenuDietM']['jeniswaktu_id']) ? $_GET['GZMenuDietM']['jeniswaktu_id'] : null;
        $modMenuDiet->kelaspelayanan_id = isset($_GET['GZMenuDietM']['kelaspelayanan_id']) ? $_GET['GZMenuDietM']['kelaspelayanan_id'] : null;
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'grid-menudiet',
        'dataProvider' => $modMenuDiet->searchDialogDiet(),
        'filter' => $modMenuDiet,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => function($data){
                    $dt['menudiet_id'] = $data->menudiet_id;
                    $dt['jenismenudiet_nama'] = $data->menudiet_nama;
                    $dt['jenisdiet_id'] = $data->jenisdiet_id;
                    $dt['ukuranrumahtangga'] = $data->ukuranrumahtangga;
    
                    // kebutuhan untuk pilih semua saat pilih kelas pelayanan
                    echo CHtml::hiddenField('menudiet_id', $data->menudiet_id, ['class' => 'menudiet_id_ubah']);
                    
                    echo CHtml::hiddenField('jeniswaktu_id', $data->jeniswaktu_id, ['class' => 'jeniswaktu_id_ubah']);
                    echo CHtml::hiddenField('menudiet_nama', $data->menudiet_nama, ['class' => 'menudiet_nama_ubah']);
                    echo CHtml::hiddenField('jeniswaktu_nama', $data->jeniswaktu->jeniswaktu_nama, ['class' => 'jeniswaktu_nama_ubah']);
    
                    $res = json_encode($dt);
    
                    echo CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                        "id" => "selectBahan", "onClick" => 'setMenuDietDlg('.$res.')', "data-menudiet" => $data->menudiet_id
                    ));        
    
                },
            ),
            array(
                'header' => 'No.',
                'value' => '$row+1'
            ),
            array(
                'header'=>'Tipe Diet',
                'type'=>'raw',
                'value'=>'!empty($data->tipediet_id) ? $data->tipediet->tipediet_nama : \'\'',
            ),
             array(
                'header'=>'Jenis Diet',
                'name'=>'jenisdiet_nama',
                'type'=>'raw',
                'value'=>'$data->jenisdiet_nama',
                'filter'=>CHtml::activeHiddenField($modMenuDiet, 'jenisdiet_id', ['id' => 'jenisdiet_id_filter']),
            ),
            array(
                // 'name'=>'menudiet_nama',
                'header'=>'Nama Menu Diet',
                'value' => '$data->menudiet_nama'
            ),
            array(
                // 'name'=>'jml_porsi',
                'header'=>'Jml Porsi',
                'value' => '$data->jml_porsi',
                'headerHtmlOptions' => array('style' => 'width: 40px;')
            ),
            // array(
            //     'name'=>'ukuranrumahtangga',
            //     'header'=>'Ukuran Rumah Tangga'
            // ),
            array(
                'header'=>'Waktu',
                'type'=>'raw',
                'value'=>'!empty($data->jeniswaktu_id) ? $data->jeniswaktu->jeniswaktu_nama : \'\'',
                // 'filter'=>  CHtml::activeDropDownList($modMenuDiet, 'jeniswaktu_id', CHtml::listData(
                //     JeniswaktuM::model()->findAllByAttributes(array(
                //         'jeniswaktu_aktif'=>true
                //     )), 'jeniswaktu_id', 'jeniswaktu_nama'), array('empty'=>'-- Pilih --')),
            ),
            array(
                'header'=>'Kelas Pelayanan',
                'type'=>'raw',
                'value'=>'!empty($data->kelaspelayanan_id) ? $data->kelaspelayanan->kelaspelayanan_nama : \'\'',
                'filter'=>  CHtml::activeDropDownList($modMenuDiet, 'kelaspelayanan_id', CHtml::listData(
                    KelaspelayananM::model()->findAllByAttributes(array(
                        'kelaspelayanan_aktif'=>true
                )), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty'=>'-- Pilih --', 'class' => 'kelaspelayanan_id_Ubah')),
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); pilihAllMenuUbah(this, id, data)}',
    ));
    
    $this->endWidget();
    