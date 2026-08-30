<?php 


    /** =============== TIM MEDIS ===================== * */
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogLab',
        'options' => array(
            'title' => 'Daftar Pemeriksaan Laboratorium',
            'autoOpen' => false,
            'width' => 850,
            'height' => 600,
            'resizable' => true,
        ),
            )
    );
    
    $format = new MyFormatter();
    $modTarif = new MKTariftindakanM('search');
    $modTarif->unsetAttributes();
    $modTarif->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;
    if (isset($_GET['MKTariftindakanM'])) {
        $modTarif->attributes = $_GET['MKTariftindakanM'];
        $modTarif->kategoritindakan_nama = $_GET['MKTariftindakanM']['kategoritindakan_nama'] ?? "";
        $modTarif->daftartindakan_kode = $_GET['MKTariftindakanM']['daftartindakan_kode'] ?? "";
        $modTarif->daftartindakan_nama = $_GET['MKTariftindakanM']['daftartindakan_nama'] ?? "";
        $modTarif->jenispemeriksaanlab_nama = $_GET['MKTariftindakanM']['jenispemeriksaanlab_nama'] ?? "";
        $modTarif->pemeriksaanlab_nama = $_GET['MKTariftindakanM']['pemeriksaanlab_nama'] ?? "";
        $modTarif->paket = $_GET['MKTariftindakanM']['paket'] ?? "";
    }
    
    if ($modTarif->paket == "paket") {
    
        $modTarif->unsetAttributes();
        if (isset($_GET['MKTariftindakanM'])) {
            $modTarif->attributes = $_GET['MKTariftindakanM'];
            $modTarif->tipepaket_nama = $_GET['MKTariftindakanM']['tipepaket_nama'] ?? "";
            $modTarif->paket = $_GET['MKTariftindakanM']['paket'];
        }
    
    
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'dialog-tariftindakan-m-grid',
            'dataProvider' => $modTarif->searchPaket(),
            'filter' => $modTarif,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'filter' => CHtml::dropDownList('MKTariftindakanM[paket]', $modTarif->paket, ['paket' => 'Paket', 'nonpaket' => 'Non Paket'], array('empty' => '-- Pilih --')),
                    'value' => function($data) {
                        return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                                    "onclick" => "pilihPemeriksaanIniDialogPaket(".$data->tipepaket_id."); $('#dialogLab').dialog('close'); return false;"));
                    },
                ),
                array(
                    'header' => 'Nama Paket',
                    //'name'=>'nama_pegawai',
                    'filter' => CHtml::activeTextField($modTarif, 'tipepaket_nama', array('class' => 'span3')),
                    'value' => '$data->tipepaket_nama',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        
    
    } else {
    
        $modTarif->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;
    
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'dialog-tariftindakan-m-grid',
            'dataProvider' => $modTarif->search2(),
            'filter' => $modTarif,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'filter' => CHtml::dropDownList('MKTariftindakanM[paket]', $modTarif->paket, ['paket' => 'Paket', 'nonpaket' => 'Non Paket'], array('empty' => '-- Pilih --')),
                    'value' => function($data) {
                        echo CHtml::hiddenField('daftartindakan_kode', $data->daftartindakan->daftartindakan_kode, array('class' => 'span3 daftartindakan_kode'));
                        echo CHtml::hiddenField('jenispemeriksaanlab_nama', $data->jenispemeriksaanlab_nama, array('class' => 'span3 jenispemeriksaanlab_nama'));
                        echo CHtml::hiddenField('jenispemeriksaanlab_id', $data->jenispemeriksaanlab_id, array('class' => 'span3 jenispemeriksaanlab_id'));
                        echo CHtml::hiddenField('pemeriksaanlab_id', $data->pemeriksaanlab_id, array('class' => 'span3 pemeriksaanlab_id_dialog'));
                        echo CHtml::hiddenField('pemeriksaanlab_nama', $data->pemeriksaanlab_nama, array('class' => 'span3 pemeriksaanlab_nama'));
                        echo CHtml::hiddenField('daftartindakan_id', $data->daftartindakan_id, array('class' => 'span3 daftartindakan_id'));
                        echo CHtml::hiddenField('jenistarif_id', $data->jenistarif_id, array('class' => 'span3 jenistarif_id'));
                        echo CHtml::hiddenField('harga_tariftindakan', $data->harga_tariftindakan, array('class' => 'span3 harga_tariftindakan'));
                        echo CHtml::hiddenField('kelaspelayanan_id', $data->kelaspelayanan_id, array('class' => 'span3 kelaspelayanan_id_dialog'));
                        return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                                    "onclick" => "pilihPemeriksaanIniDialog(this); $('#dialogLab').dialog('close'); return false;"));
                    },
                ),
                array(
                    'header' => 'Kategori Tindakan',
                    //'name'=>'nama_pegawai',
                    'filter' => CHtml::activeTextField($modTarif, 'kategoritindakan_nama', array('class' => 'span3')),
                    'value' => '$data->daftartindakan->kategoritindakan->kategoritindakan_nama',
                ),
                array(
                    'header' => 'Kode Tindakan',
                    //'name'=>'nama_pegawai',
                    'filter' => CHtml::activeTextField($modTarif, 'daftartindakan_kode', array('class' => 'span3')),
                    'value' => '$data->daftartindakan->daftartindakan_kode',
                ),
                array(
                    'header' => 'Jenis Pemeriksaan',
                    //'name'=>'nama_pegawai',
                    'filter' => CHtml::activeTextField($modTarif, 'jenispemeriksaanlab_nama', array('class' => 'span3')),
                    'value' =>  function ($data) {
                        return $data->jenispemeriksaanlab_nama;
                    },
                ),
                array(
                    'header' => 'Nama Pemeriksaan',
                    //'name'=>'nama_pegawai',
                    'filter' => CHtml::activeTextField($modTarif, 'pemeriksaanlab_nama', array('class' => 'span3')),
                    'value' => '$data->pemeriksaanlab_nama',
                ),
                array(
                    'header' => 'Uraian Tindakan',
                    //'name'=>'nama_pegawai',
                    'filter' => CHtml::activeTextField($modTarif, 'daftartindakan_nama', array('class' => 'span3')),
                    'value' => '$data->daftartindakan->daftartindakan_nama',
                ),
                array(
                    'header' => 'Kelas Pelayanan',
                    //'name'=>'nama_pegawai',
                    'filter' => CHtml::dropDownList('MKTariftindakanM[kelaspelayanan_id]', $modTarif->kelaspelayanan_id, CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif IS TRUE"), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --')),
                    'value' => '$data->kelaspelayanan->kelaspelayanan_nama',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
    
    }
    
    
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //=============================== END TIM MEDIS =======================================
    

?>