<?php
/** =============== Pengirima Start ===================== **/
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPetugas',
            'options'=>array(
                'title'=>'Pencarian Petugas' ,
                'autoOpen'=>false,
                'width' => 530,
                'height' => 680,
                'resizable' => true,
            ),
        )
    );
        	
    $format = new MyFormatter();
    $pegPengirim=new PegawairuanganV('search');    
    if(isset($_GET['PegawairuanganV'])){
            $pegPengirim->attributes=$_GET['PegawairuanganV'];            
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialog-pengirim-m-grid',
            'dataProvider'=>$pegPengirim->searchDialogPegRuangan(),
            'filter'=>$pegPengirim,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
                                        "onclick" => " setPetugas(\"".$data->namaLengkap."\",".$data->pegawai_id."); return false; "));
                        },
                    ),
                    array(
                        'name'=>'nama_pegawai',
                        // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
                        'value'=>'$data->namaLengkap',
                    ),
                    array(
                        'header' => 'Jabatan',
                        'name' => 'jabatan_id',
                        'value' => function($data){
                            $j = JabatanM::model()->findByPk($data->jabatan_id);
                            
                            if (!empty($j)){
                                return $j->jabatan_nama;
                            }
                        },
                        'filter' => CHtml::activeDropDownList($pegPengirim, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE "), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
                    ),
            ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //=============================== END Pengirim =======================================
    
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogKantong',
    'options'=>array(
        'title'=>'Pencarian Data No Kantong',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>400,
        'resizable'=>false,
    ),
));
    $modDialogPenyerahan = new BDPenyerahandarahT('searchKantongDarah');
    $modDialogPenyerahan->unsetAttributes();
    if(isset($_GET['BDPenyerahandarahT'])) {
        $modDialogPenyerahan->attributes = $_GET['BDPenyerahandarahT'];
        if(!empty($_GET['BDPenyerahandarahT']['gol_darah'])){
            $modDialogPenyerahan->gol_darah = $_GET['BDPenyerahandarahT']['gol_darah'];
        }
        if(!empty($_GET['BDPenyerahandarahT']['no_kantongdarah'])){
            $modDialogPenyerahan->no_kantongdarah = $_GET['BDPenyerahandarahT']['no_kantongdarah'];
        }
        if(!empty($_GET['BDPenyerahandarahT']['rhesus_darah'])){
            $modDialogPenyerahan->rhesus_darah = $_GET['BDPenyerahandarahT']['rhesus_darah'];
        }
        if(!empty($_GET['BDPenyerahandarahT']['singkatan_komp'])){
            $modDialogPenyerahan->singkatan_komp = $_GET['BDPenyerahandarahT']['singkatan_komp'];
        }
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datapenyerahan-grid',
            'dataProvider'=>$modDialogPenyerahan->searchKantongDarah(),
            'filter'=>$modDialogPenyerahan,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    /*array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>function($data){
                            return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectKunjungan",
                                        "onClick" => "
                                            $(\"#BDReturdarahT_nama_pasien\").val(\"$data->nama_pasien\");
                                            $(\"#BDReturdarahT_ujikompatibilitas_id\").val(\"$data->ujikompatibilitas_id\");
                                            $(\"#BDReturdarahT_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                            $(\"#BDReturdarahT_golongan_darah\").val(\"$data->gol_darah\");
                                            $(\"#BDReturdarahT_no_kantongdarah\").val(\"$data->no_kantongdarah\");
                                            $(\"#BDReturdarahT_jenis_komponen_darah\").val(\"$data->singkatan_komp\");
                                            $(\"#BDReturdarahT_ruangan_nama\").val(\"$data->ruangan_nama\");
                                            $(\"#dialogKantong\").dialog(\"close\");
                                        "));
                        },
                    ),*/
                    array(
                        'header'=>CHtml::checkBox('pilihSemua', false, array(
                                'class'=>'check_all_produk', 'onchange'=>'setSemuaKantong(this);'
                        )).' Pilih Semua',
                        'type'=>'raw',
                        'value'=>function($data){
                                return CHtml::checkBox('check', false, array(
                                        'no_kantongdarah'=>$data["no_kantongdarah"], 
                                        'onchange'=>'setKantong(this);',
                                        'class'=>'pilih',
                                ));
                        },
                        'htmlOptions'=>array(
                                'style'=>'text-align: center',
                        ),
                        'footer' => CHtml::htmlButton('OK', array('class'=>'btn btn-green', 'onclick'=>'inputKantong();'))
                    ),
                    array(
                        'header' => 'Nomor Kantong',
                        'name' => 'no_kantongdarah',
                        'value' => function($data){
                            if (!empty($data->no_kantongdarah)){
                                return $data->no_kantongdarah;
                            }
                        },
                        'filter' => CHtml::activeTextField($modDialogPenyerahan, 'no_kantongdarah',array())
                    ),
                    array(
                        'header' => 'Golongan Darah',
                        'name' => 'gol_darah',
                        'value' => function($data){
                            if (!empty($data->gol_darah)){
                                return $data->gol_darah;
                            }
                        },
                        'filter' => CHtml::activeTextField($modDialogPenyerahan, 'gol_darah',array())
                    ),
                    array(
                        'header' => 'Rhesus',
                        'name' => 'rhesus_darah',
                        'value' => function($data){
                            if (!empty($data->rhesus_darah)){
                                return $data->rhesus_darah;
                            }
                        },
                        'filter' => CHtml::activeTextField($modDialogPenyerahan, 'rhesus_darah',array())
                    ),
                    array(
                        'header' => 'Jenis Komponen Kantong',
                        'name' => 'singkatan_komp',
                        'value' => function($data){
                            if (!empty($data->singkatan_komp)){
                                return $data->singkatan_komp;
                            }
                        },
                        'filter' => CHtml::activeTextField($modDialogPenyerahan, 'singkatan_komp',array())
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>