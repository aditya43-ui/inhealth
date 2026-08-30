<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - untuk mengenerate dialog box 
* RSST-1640
*/

/** =============== AWAL Pegawai Penanggung Jawab dan teknisi internal ===================== **/
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPegawai',
            'options'=>array(
                'title'=>'Pencarian <span id="judul"></span>' ,
                'autoOpen'=>false,
                'width' => 630,
                'height' => 500,
                'resizable' => true,
            ),
        )
    );
        	
    echo CHtml::hiddenField('idPilih',0,array('readonly'=>true));
    
    $format = new MyFormatter();
    $modPJ=new PegawairuanganV('search');    
    if(isset($_GET['PegawairuanganV'])){
            $modPJ->attributes=$_GET['PegawairuanganV'];            
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialog-pengirim-m-grid',
            'dataProvider'=>$modPJ->searchDialogPegRuangan(),
            'filter'=>$modPJ,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $res = array('peg' => $data->attributes);                            
                            $res['peg']['namaLengkap'] = $data->namaLengkap;                            
                            $res['peg']['jabatan_nama'] = $data->jabatan_nama;                            
                            $res = CJSON::encode($res);
        
                            return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
                                "onclick" => " setPegawai(".$res."); return false; "));
                        },
                    ),
                     array(
                         'header' => 'NIP',
                        'name'=>'nomorindukpegawai',                        
                        'value'=>'$data->nomorindukpegawai',
                    ),
                    array(
                        'name'=>'nama_pegawai',                        
                        'value'=>'$data->namaLengkap',
                    ),
                    array(
                        'header' => 'Jabatan',
                        'name' => 'jabatan_id',
                        'value' => function($data){
                            
                            return $data->jabatan_nama;
                                                        
                        },
                        'filter' => CHtml::activeDropDownList($modPJ, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE "), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
                    ),
            ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //=============================== AKHIR =======================================
