<?php 
   $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPegawai',
            'options'=>array(
                'title'=>'Pencarian <span id="judul-petugas"></span>' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 500,
                'resizable' => true,
            ),
        )
    );
        	
    echo CHtml::hiddenField('tipe','',array('readonly' => true));
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
                'itemsCssClass'=>'table table-bordered table-condesed',
                'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>function($data) {
        
                            $peg = $data->attributes;
                            $peg['namaLengkap'] = $data->namaLengkap;
                            $res = CJSON::encode($peg);
        
                            return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"javascript:;",array("class"=>"btn-small", 
                                        "onclick" => " setPetugas(".$res.");"));
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
                            return $data->jabatan_nama;
                        }
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>
