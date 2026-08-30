<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPetugas',
            'options'=>array(
                'title'=>'Pencarian Petugas <span class="judul-dialog-petugas"></span>' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 600,
                'resizable' => true,
            ),
        )
    );
        	            
    $modPeg = new PegawairuanganV('search');
    
    if(isset($_GET['PegawairuanganV'])){
        $modPeg->attributes = $_GET['PegawairuanganV'];        
        $modPeg->namaunitkerja = isset($_GET['PegawairuanganV']['namaunitkerja'])?$_GET['PegawairuanganV']['namaunitkerja']:null;  
        $modPeg->jabatan_nama = isset($_GET['PegawairuanganV']['jabatan_nama'])?$_GET['PegawairuanganV']['jabatan_nama']:null;
        $modPeg->default = isset($_GET['PegawairuanganV']['default'])?$_GET['PegawairuanganV']['default']:null;
        $modPeg->notkelompokpegawai_id = isset($_GET['PegawairuanganV']['notkelompokpegawai_id'])?$_GET['PegawairuanganV']['notkelompokpegawai_id']:null;
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialog-pegawai-grid',
            'dataProvider'=>$modPeg->searchDialogPegawai(),
            'filter'=>$modPeg,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                'columns'=>array(            
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>function($data) {
                                $load = $data->attributes;
                                $load['namaLengkap'] = $data->namaLengkap;
                                $load['namaunitkerja'] = $data->namaunitkerja;
                                $load['jabatan_nama'] = $data->jabatan_nama;
                                $res = json_encode($load);

                                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"javascript:;",array("class"=>"btn-small", 
                                        "onclick" => 'setPegawai('.$res.');'));
                            },
                    ),
                   'nomorindukpegawai',
                    array(
                        'header' => 'Nama Pegawai',
                        'name' => 'nama_pegawai',
                        'value' => '$data->namaLengkap',
                        'filter' =>CHtml::activeHiddenField($modPeg, 'default').CHtml::activeHiddenField($modPeg, 'notkelompokpegawai_id').CHtml::activeHiddenField($modPeg, 'kelompokpegawai_id').CHtml::activeHiddenField($modPeg, 'ruangan_id').CHtml::activeTextField($modPeg, 'nama_pegawai')
                    ),
                    'jabatan_nama',
                    'namaunitkerja'
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');   
    
     $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPPDS',
            'options'=>array(
                'title'=>'Pencarian PPDS' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 600,
                'resizable' => true,
            ),
        )
    );
        	            
    $modPPDS = new PpdsM('search');
    $modPPDS->ppds_aktif = TRUE;
    if(isset($_GET['PpdsM'])){
        $modPPDS->attributes = $_GET['PpdsM'];                        
        $modPPDS->programstudi_nama = isset($_GET['PpdsM']['programstudi_nama'])?$_GET['PpdsM']['programstudi_nama']:null;
        $modPPDS->ppds_aktif = TRUE;
    }    
   
    $dialog_load = $modPPDS->searchDialogPegawai();
               
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialog-ppds-grid',
            'dataProvider'=>$dialog_load,
            'filter'=>$modPPDS,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                'columns'=>array(            
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>function($data) {
                                    $load = $data->attributes;                                    
                                    $res = json_encode($load);

                                    return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"javascript:;",array("class"=>"btn-small", 
                                            "onclick" => 'setPegawai('.$res.');'));
                                },
                        ),
                        'ppds_nim',
                        'ppds_nama',
                         array(
                             'header' => 'Program Studi',
                             'name' =>'programstudi_nama',
                         )
                        
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog'); 