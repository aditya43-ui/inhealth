<?php

$caraPrint = isset($caraPrint)?$caraPrint:null;

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$visible = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$filter = $model;
$data = $model->search();
if (isset($caraPrint)) {
    $row = '$row+1';
    $visible = false;
    $data->pagination = false;
    
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    $filter = null;
} else {
    
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'informasi-stok-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed', 
    'columns' => array(
        array(
            'header' => 'No',
            'value' => $row,
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        [
            'name' => 'tanggal',
            'value' => '!empty($data->tanggal)?MyFormatter::formatDateTimeForUser($data->tanggal):""'
        ],
        'no_bed_triage',
        'no_triage_pasien',
        [
            'name' => 'warna',
            'type' => 'raw',
            'value' => function($data) use (&$modTriage){

                // echo 'Asesmen wpss: ' . $data->asesmentriagewpss_id;
                if (empty($data->asesmentriagewpss_id)){
                    return CHtml::link('<u>Belum Diasesmen</u>',$this->createUrl('/'.$this->module->id.'/asesmenTriage/indexWps',['pendaftaran_id'=>$data->pendaftaran_id,'frame'=>0, 'notriage_pasien_id'=>$data->notriage_pasien_id]),['rel'=>'tooltip','title'=>'Menambahkan asesmen triage']);
                }else{
                    $modTriage = AsesmentriagewpssT::model()->findByAttributes(['notriage_pasien_id' => $data->notriage_pasien_id], ['order' => 'create_time desc']);
                    $warna ='';
                    if($modTriage->ruang == 'Ruang P-3'){
                        $warna =  CHtml::link('<div style="width:100px;height:20px;background:green"></div>',$this->createUrl('/'.$this->module->id.'/asesmenTriage/updateWPS',['pendaftaran_id'=>$data->pendaftaran_id,'asesmentriagewpss_id'=>$data->asesmentriagewpss_id,'frame'=>0, 'notriage_pasien_id'=>$data->notriage_pasien_id]),['rel'=>'tooltip','title'=>'Update asesmen triage']);
                
                    } else if($modTriage->ruang == 'Ruang P-2'){
                        $warna = CHtml::link('<div style="width:100px;height:20px;background:yellow"></div>',$this->createUrl('/'.$this->module->id.'/asesmenTriage/updateWPS',['pendaftaran_id'=>$data->pendaftaran_id,'asesmentriagewpss_id'=>$data->asesmentriagewpss_id,'frame'=>0, 'notriage_pasien_id'=>$data->notriage_pasien_id]),['rel'=>'tooltip','title'=>'Update asesmen triage']);
                
                    } else if($modTriage->ruang == 'Ruang P-1'){
                        $warna = CHtml::link('<div style="width:100px;height:20px;background:red"></div>',$this->createUrl('/'.$this->module->id.'/asesmenTriage/updateWPS',['pendaftaran_id'=>$data->pendaftaran_id,'asesmentriagewpss_id'=>$data->asesmentriagewpss_id,'frame'=>0, 'notriage_pasien_id'=>$data->notriage_pasien_id]),['rel'=>'tooltip','title'=>'Update asesmen triage']);
                
                    }else if($modTriage->ruang == 'Death on Arrival'){
                        // P-0
                        $warna = CHtml::link('<div style="width:100px;height:20px;background:black"></div>',$this->createUrl('/'.$this->module->id.'/asesmenTriage/updateWPS',['pendaftaran_id'=>$data->pendaftaran_id,'asesmentriagewpss_id'=>$data->asesmentriagewpss_id,'frame'=>0, 'notriage_pasien_id'=>$data->notriage_pasien_id]),['rel'=>'tooltip','title'=>'Update asesmen triage']);
                
                    } else if($modTriage->ruang == 'Screening') {
                        $warna = CHtml::link('<div style="width:100px;height:20px;background:#ff85ed"></div>',$this->createUrl('/'.$this->module->id.'/asesmenTriage/updateWPS',['pendaftaran_id'=>$data->pendaftaran_id,'asesmentriagewpss_id'=>$data->asesmentriagewpss_id,'frame'=>0, 'notriage_pasien_id'=>$data->notriage_pasien_id]),['rel'=>'tooltip','title'=>'Update asesmen triage']);
                    } else if($modTriage->ruang == 'APS') {
                        $warna = CHtml::link('<div style="width:100px;height:20px;background:#78a7ff"></div>',$this->createUrl('/'.$this->module->id.'/asesmenTriage/updateWPS',['pendaftaran_id'=>$data->pendaftaran_id,'asesmentriagewpss_id'=>$data->asesmentriagewpss_id,'frame'=>0, 'notriage_pasien_id'=>$data->notriage_pasien_id]),['rel'=>'tooltip','title'=>'Update asesmen triage']);
                    }
                    return $warna;
                }
            }
        ],
        'keterangan',
        [
            'name' => 'no_pendaftaran',
            'type' => 'raw',
            'value' => function($data){
                if (empty($data->pendaftaran_id)){
                    return CHtml::link('Pilih Pendaftaran','javascript:;',['onclick'=>'setDaftar(this)','rel'=>'tooltip','title'=>'Menambahkan data pendaftaran pasien','class'=>'btn btn-sm btn-success', 'data-url'=>$this->createUrl('setPendaftaran',['id'=>$data->notriage_pasien_id])]);
                }else{
                    if ($data->statusperiksa == Params::STATUSPERIKSA_ANTRIAN){
                        return CHtml::link($data->no_pendaftaran.' <i class="entypo-pencil"></i>','javascript:;',['onclick'=>'setDaftar2(this)','rel'=>'tooltip','title'=>'Mengubah data pendaftaran pasien', 'data-url'=>$this->createUrl('setPendaftaran2',['id'=>$data->notriage_pasien_id])]);
                    }else{
                        return CHtml::link($data->no_pendaftaran.' <i class="entypo-pencil"></i>','javascript:;',['onclick'=>'setDaftar2(this)','rel'=>'tooltip','title'=>'Mengubah data pendaftaran pasien', 'data-url'=>$this->createUrl('setPendaftaran2',['id'=>$data->notriage_pasien_id])]);
                    }
                    return '<div style="width:100px;height:20px;background:'.$data->warna.';"></div>';
                }
            }
        ],
        [
            'header' => 'Daftar Ke IGD',
            'type' => 'raw',
            'value' => function ($data) {
                if(empty($data->pendaftaran_id)) {
                    echo CHtml::link("<i class='icon-form-poliklinik'></i> ", Yii::app()->controller->createUrl("/pendaftaranPenjadwalan/pendaftaranRawatDarurat/index",array('modulId' => '2', "is_triage"=>true, "notriage_pasien_id" => $data->notriage_pasien_id)),array("rel"=>"tooltip","title"=>"Klik untuk Daftar Ke IGD"));
                } else {
                    echo 'Sudah Terdaftar';
                }
            }
        ],
        [
            'name' => 'anamnesa',
            'type' => 'raw',
            'value' => function($data){
                
                if (empty($data->anamesa_id) && empty($data->pendaftaran_id)){
                    return '<center>'.CHtml::link("<i class='icon-form-periksa'></i> ", Yii::app()->controller->createUrl("/rawatDarurat/anamnesaMedisTRD",array("is_triage"=>true, "notriage_pasien_id" => $data->notriage_pasien_id)),array("rel"=>"tooltip","title"=>"Klik untuk Anamnesa")).'</center>';
                }else{
                    return $data->status_anamnesa;
                }
            }
        ],
        [
            'name' => 'periksa_fisik',
            'type' => 'raw',
            'value' => function($data){
                
                
                if (empty($data->pemeriksaanfisik_id) && empty($data->pendaftaran_id)){
                    return '<center>'.CHtml::link("<i class='icon-form-periksa'></i> ", Yii::app()->controller->createUrl("/rawatDarurat/pemeriksaanFisikTRD/indexDarurat",array("is_triage"=>true, "notriage_pasien_id" => $data->notriage_pasien_id)),array("rel"=>"tooltip","title"=>"Klik untuk Periksa Fisik")).'</center>';
                }else{
                    return $data->status_pemeriksaanfisik;
                }
            }
        ],
        [            
            'name'=>'nama_pasien',
            'header'=>'Pasien',
            'type'=>'raw',
            'value'=>'$data->nama_pasien."<br/>".$data->no_rekam_medik'
        ],
        [
            'name'=>'statusperiksa',
            'type'=>'raw',
            'value' => function ($data) {
                $modTriage = AsesmentriagewpssT::model()->findByAttributes(['notriage_pasien_id' => $data->notriage_pasien_id], ['order' => 'create_time desc']);
                $status = Params::getWrStatusPeriksa($data->statusperiksa);
                if(!empty($modTriage->ruang)) {
                    if($modTriage->ruang == 'APS') {
                        $status = '<a class="btn" style="background:#78a7ff">' . strtoupper($modTriage->ruang) . '</a>';
                    } else if($modTriage->ruang == 'Screening') {
                        $status = '<a class="btn" style="background:#ff85ed">' . strtoupper($modTriage->ruang) . '</a>';
                    }
                }

                echo $status;
            }
        ],
        [
            'header' => 'Tindak Lanjut',
            'type' => 'raw',
            'value' => function($data) use (&$modTriage) {
            if(isset($modTriage->ruang)  && $modTriage->ruang == 'Death on Arrival'){
                    return '<div class="small-container">' . CHtml::link(
                        '<icon class="icon-form-ri"></icon><br>Tindak Lanjut',
                        '',
                        // Yii::app()->createUrl("/rawatDarurat/daftarPasien/PasienPulang", 
                        // array("pendaftaran_id" => $data->pendaftaran_id, "dialog" => true)),
                        array(
                            // "target" => "iframePasienPulang",
                            //"onclick"=>"$('#dialogPasienPulang').dialog('open');",
                            "onclick" => "cekVerifikasiTindakLanjut(this,'" . $data->pendaftaran_id . "');",
                            "rel" => "tooltip",
                            "title" => "Klik untuk menambahkan tindak lanjut",
                        )
                    ) . '</div>';
                }
            }
        ]
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});            
    }',
));
?>