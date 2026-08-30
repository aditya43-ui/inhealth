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
            'id'=>'dialogRUP',
            'options'=>array(
                'title'=>'Pencarian Rencana Umum Pengadaan' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 600,
                'resizable' => true,
            ),
        )
    );
        	        
    $format = new MyFormatter();
    $modRen =new ADRencanaumumpengadaanT('search');
    
    if(isset($_GET['ADRencanaumumpengadaanT'])){
        $modRen->attributes=$_GET['ADRencanaumumpengadaanT'];
        $modRen->filter = isset($_GET['ADRencanaumumpengadaanT']['filter'])?$_GET['ADRencanaumumpengadaanT']['filter']:null;
        $modRen->namaunitkerja = isset($_GET['ADRencanaumumpengadaanT']['namaunitkerja'])?$_GET['ADRencanaumumpengadaanT']['namaunitkerja']:null;
        $modRen->instalasi_nama = isset($_GET['ADRencanaumumpengadaanT']['instalasi_nama'])?$_GET['ADRencanaumumpengadaanT']['instalasi_nama']:null;
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialog-rup-grid',
            'dataProvider'=>$modRen->searchForPersiapanPengadaan(),
            'filter'=>$modRen,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',                                                
                        'value'=>function($data) use ($model) {                                                                
        
                            return CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("class"=>"btn-small", 
                                        "id" => "selectBahan",
                                        "onClick" => 'loadRUP('.$data->rencanaumumpengadaan_id.');'));
                        },
                    ),  
                    array(
                        'header' => 'Kode RUP',
                        'name' => 'kode_rup',
                        'filter' => CHtml::activeTextField($modRen, 'kode_rup', array()).
                                    CHtml::activeHiddenField($modRen, 'filter', array('readonly' => true)).
                                    CHtml::activeHiddenField($modRen, 'rencanaumumpengadaan_kategori', array('readonly' => true)).
                                    CHtml::activeHiddenField($modRen, 'periodeanggaran_id', array('readonly' => true)).
                                    CHtml::activeHiddenField($modRen, 'instalasi_id', array('readonly' => true)).
                                    CHtml::activeHiddenField($modRen, 'unitkerja_id', array('readonly' => true)).
                                    CHtml::activeHiddenField($modRen, 'pegawaippk_id', array('readonly' => true)),
                        'value' => function($data){
                            return $data->kode_rup;
                        }
                    ),
                    array(
                        'header' => 'Pekerjaan',
                        'name' => 'nama_pekerjaan',
                        'value' => function($data){
                            return $data->nama_pekerjaan;
                        }
                    ),
                    array(
                        'header' => 'Total',
                        'htmlOptions' => array('style' => 'text-align:right;'),
                        'name' => 'total_pagu',
                        'filter' => false,
                        'value' => function($data){
                            return "Rp. ".number_format($data->total_pagu, 2, ',', '.');
                        }
                    ),
//                    array(
//                        'header' => 'Bidang/Bagian/Instalasi',
//                        'name' => 'instalasi_nama',
//                        'value' => function($data){
//                            return $data->instalasi_nama;
//                        }
//                    ),
//                    array(
//                        'header' => 'Unit Kerja',
//                        'name' => 'namaunitkerja',
//                        'value' => function($data){
//                            return $data->namaunitkerja;
//                        }
//                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');            
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogUnitKerjaPPK',
            'options'=>array(
                'title'=>'Pencarian Unit Kerja PPK' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 600,
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
            'dataProvider'=>$modUnitPPk->searchDialogUnitKerjaPPK(),
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
                                        "onClick" => 'setUnitKerjaPPK('.$res.');'));
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
?>


