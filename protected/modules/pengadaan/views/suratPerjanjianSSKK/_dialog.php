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
        	            
    $modPeg = new PegawaiV('search');
    $modPeg->unsetAttributes();
    $modPeg->pegawai_aktif = true;
    if(isset($_GET['PegawaiV'])){
        $modPeg->attributes = $_GET['PegawaiV'];        
        $modPeg->namaunitkerja = isset($_GET['PegawaiV']['namaunitkerja'])?$_GET['PegawaiV']['namaunitkerja']:null;  
        $modPeg->jabatan_nama = isset($_GET['PegawaiV']['jabatan_nama'])?$_GET['PegawaiV']['jabatan_nama']:null;
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
                        'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                        "id" => "selectDokter",
                           "onClick" => "
                                $(\"#ADSyaratkhususkontrakT_pegpengawas_id\").val(\"$data->pegawai_id\");
                                $(\"#ADSyaratkhususkontrakT_pegpengawas_nama\").val(\"$data->namaLengkap\");
                                $(\"#dialogPetugas\").dialog(\"close\");
                                return false;
                            "
                        ))',
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


