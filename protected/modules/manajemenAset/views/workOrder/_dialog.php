<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - untuk mengenerate dialog box 
* RSST-1584
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
    $modPJ=new PegawaiV('search');    
    $modPJ->is_peg_pjasset = true;
    if(isset($_GET['PegawaiV'])){
        $modPJ->attributes=$_GET['PegawaiV'];            
        $modPJ->is_peg_pjasset = isset($_GET['PegawaiV']['is_peg_pjasset'])?$_GET['PegawaiV']['is_peg_pjasset']:null;
        $modPJ->is_peg_internalaset = isset($_GET['PegawaiV']['is_peg_internalaset'])?$_GET['PegawaiV']['is_peg_internalaset']:null;
        $modPJ->lokasi_id = isset($_GET['PegawaiV']['lokasi_id'])?$_GET['PegawaiV']['lokasi_id']:null;
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialog-pengirim-m-grid',
            'dataProvider'=>$modPJ->searchAllPegawai(),
            'filter'=>$modPJ,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'filter' => CHtml::activeHiddenField($modPJ, 'is_peg_pjasset').CHtml::activeHiddenField($modPJ, 'is_peg_internalaset'),
                        'value'=>function($data) {
                            $res = array('peg' => $data->attributes);                            
                            $res['peg']['namaLengkap'] = $data->namaLengkap;                            
                            $res['peg']['jabatan_nama'] = $data->jabatan_nama;
                            $res['peg']['namaunitkerja'] = $data->namaunitkerja;
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
                        'filter' => CHtml::activeDropDownList($modPJ, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE  order by jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
                    ),
            ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //=============================== AKHIR =======================================
    
    /** =============== AWAL teknisi eksternal ===================== **/
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogTeknisi',
            'options'=>array(
                'title'=>'Pencarian Teknisi Eksternal <span id="judul-teknisi"></span>' ,
                'autoOpen'=>false,
                'width' => 630,
                'height' => 500,
                'resizable' => true,
            ),
        )
    );
        	
    echo CHtml::hiddenField('idPilih',0,array('readonly'=>true));
    
    $format = new MyFormatter();
    $modTk=new TeknisiperalatanM('search');   
    $modTk->supplier_id = null;
    if(isset($_GET['TeknisiperalatanM'])){
            $modTk->attributes=$_GET['TeknisiperalatanM'];            
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialog-teknisi-m-grid',
            'dataProvider'=>$modTk->search(),
            'filter'=>$modTk,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $res = array('peg' => $data->attributes);                            
                           
                            $res = CJSON::encode($res);
        
                            return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
                                "onclick" => " setTeknisi(".$res."); return false; "));
                        },
                    ),
                     array(
                         'header' => 'Teknisi',
                        'name'=>'namateknisi',                        
                        'value'=>'$data->namateknisi',
                    ),                   
                    array(
                        'header' => 'Jenis Kelamin',
                        'name' => 'jeniskelamin',
                        'value' => function($data){
                            
                            return $data->jeniskelamin;
                                                        
                        },
                        'filter' => CHtml::activeHiddenField($modTk, 'supplier_id',array('class'=>'dialog_supplier_id')).CHtml::activeDropDownList($modTk, 'jeniskelamin', LookupM ::getItems('jeniskelamin'),array('empty'=>'-- Pilih --'))
                    ),
            ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //=============================== AKHIR =======================================
?>




