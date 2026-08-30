<?php
/** 
 * view ini digunakan untuk menampilkan data dialog
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */      
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogUnitKerja',
            'options'=>array(
                'title'=>'Pencarian SMF' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 500,
                'resizable' => true,
            ),
        )
    );
        	            
    $modUnitPPk = new UnitkerjaM('search');
    
    if(isset($_GET['UnitkerjaM'])){
        $modUnitPPk->attributes= $_GET['UnitkerjaM'];     
        $modUnitPPk->instalasi_nama  = isset($_GET['UnitkerjaM']['instalasi_nama'])?$_GET['UnitkerjaM']['instalasi_nama']:null;
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialog-unitkerja-grid',
            'dataProvider'=>$modUnitPPk->searchDialog(),
            'filter'=>$modUnitPPk,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',                                                
                        'value'=>function($data){                                                                
                            $dt = $data->attributes;
                            $dt['instalasi_nama'] = $data->instalasi_nama;
                            $dt['instalasi_id'] = $data->instalasi_id;

                            $res = json_encode($dt);
        
                            return CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("class"=>"btn-small", 
                                        "id" => "selectBahan",
                                        "onClick" => 'setSMF('.$res.');'));
                        },
                    ),  
                    array(
                        'header' => 'Nama Unit Kerja',
                        'name' => 'namaunitkerja',                        
                        'value' => function($data){
                            return $data->namaunitkerja;
                        }
                    ),                   
                    array(
                        'header' => 'Instalasi',
                        'name' => 'instalasi_nama',
                        'value' => function($data){
                            return $data->instalasi_nama;
                        }
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog'); 
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPetugas',
            'options'=>array(
                'title'=>'Pencarian Petugas <span class="judul-dialog-petugas"></span>' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 500,
                'resizable' => true,
            ),
        )
    );
        	            
    $modPeg = new PegawaiV('search');
    $modPeg->kelompokpegawai_id = array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN);
    
    if(isset($_GET['PegawaiV'])){
        $modPeg->attributes = $_GET['PegawaiV'];        
        $modPeg->namaunitkerja = isset($_GET['PegawaiV']['namaunitkerja'])?$_GET['PegawaiV']['namaunitkerja']:null;  
        $modPeg->jabatan_nama = isset($_GET['PegawaiV']['jabatan_nama'])?$_GET['PegawaiV']['jabatan_nama']:null;
        $modPeg->kelompokpegawai_id = array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN);
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialog-pegawai-grid',
            'dataProvider'=>$modPeg->searchAllPegawai(),
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
                        'value' => '$data->namaLengkap'
                    ),
                    'jabatan_nama',
                    'namaunitkerja'
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog'); 
?>

