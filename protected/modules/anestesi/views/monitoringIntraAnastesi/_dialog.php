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
            'id'=>'dialogPegawai',
            'options'=>array(
                'title'=>'Pencarian Peminjam' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 600,
                'resizable' => true,
            ),
        )
    );
        	        
    $format = new MyFormatter();
    $modPeg=new PegawaiV('search');
    
    if(isset($_GET['PegawaiV'])){
            $modPeg->attributes=$_GET['PegawaiV'];            
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialog-pengirim-m-grid',
            'dataProvider'=>$modPeg->searchAllPegawai(),
            'filter'=>$modPeg,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>function($data) use ($model) {
                                    
                            $res = $data->attributes;
                            $res['namaLengkap'] = $data->namaLengkap;
                            $res['jabatan_nama'] = $data->jabatan_nama;
                            
                            $dt = CJSON::encode($res);
        
                            return CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("class"=>"btn-small", 
                                        "id" => "selectBahan",
                                        "onClick" => 'setPeminjam('.$dt.');'));
                        },
                    ),
                    array(
                        'name'=>'nomorindukpegawai',
                        'value'=>'$data->nomorindukpegawai',
                    ),
                    array(
                        'name'=>'nama_pegawai',
                        'value'=>'$data->namaLengkap',
                    ),                    
                    array(
                        'header' => 'Jabatan',
                        'name'=>'jabatan_id',
                        'value'=>'$data->jabatan_nama',
                        'filter' => CHtml::activeDropDownList($modPeg, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"),'jabatan_id','jabatan_nama'),array('empty' => '-- Pilih --'))
                    ),
                    array(
                        'header' => 'Unit Kerja',
                        'name'=>'unitkerja_id',
                        'value'=>'$data->namaunitkerja',
                        'filter' => CHtml::activeDropDownList($modPeg, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"),'unitkerja_id','namaunitkerja'),array('empty' => '-- Pilih --'))
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');            
//========= Dialog pencarian ruangan =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogRuangan',
        'options' => array(
            'title' => 'Pencarian Ruangan <span id="judul_ruangan"></span>',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'resizable' => false,
        ),
    ));
    
    
    $modRuangan = new GURuanganM('search');
    $modRuangan->unsetAttributes();    
    if (isset($_GET['GURuanganM'])){
        $modRuangan->attributes = $_GET['GURuanganM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'ruangan-m-grid2',
        'dataProvider' => $modRuangan->searchDialog(),
        'filter' => $modRuangan,        
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(            
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => function($data) use ($model){
                    $ins = $data->attributes;
                    $ins['instalasi_nama'] = $data->instalasi_nama;
                    
                    $res = CJSON::encode($ins);
        
                    return CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("class"=>"btn-small", 
                                        "id" => "selectBahan",
                                        "onClick" => "                                                                                
                                            setRuangan(".$res.");
                                            $('#".CHtml::activeId($model, 'ruangan_nama')."').blur();
                                        return false;"));
                },
            ),
            array(
                'header' => 'Instalasi',                
                'name'=> 'instalasi_id',
                'value' => '$data->instalasi_nama',
                'filter' => CHtml::activeDropDownList($modRuangan, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(" instalasi_aktif = TRUE ORDER BY instalasi_nama ASC "), 'instalasi_id', 'instalasi_nama'),array('empty'=>'-- Pilih --'))
            ),
            array(
                'header' => 'Ruangan',                
                'name' => 'ruangan_nama',
                'value' => '$data->ruangan_nama'
            ),

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
    
    
    //========= Dialog pencarian inventarisasi =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogAset',
        'options' => array(
            'title' => 'Pencarian Barang',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'resizable' => false,
        ),
    ));
    
    
    $modAset = new InvperalatanT('search');
    $modAset->unsetAttributes();    
    if (isset($_GET['InvperalatanT'])){
        $modAset->attributes = $_GET['InvperalatanT'];
        $modAset->custom = isset($_GET['InvperalatanT']['custom'])?$_GET['InvperalatanT']['custom']:null;
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'aset-m-grid2',
        'dataProvider' => $modAset->searchDialogInvPeralatan(),
        'filter' => $modAset,        
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(            
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => function($data) use ($model){
                    $ins = $data->attributes;                    
                    
                    $res = CJSON::encode($ins);
        
                    return CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("class"=>"btn-small", 
                                        "id" => "selectBahan",
                                        "onClick" => "setAset(".$res.");"));
                },
            ),     
            array(
                'header' => 'Nama Aset',
                'name' => 'invperalatan_namabrg'
            ),
            array(
                'header' => 'No. Aset',
                'name' => 'invperalatan_kode'
            ),
            array(
                'header' => 'Merk',
                'name' => 'invperalatan_merk'
            ),
            array(
                'header' => 'Ukuran',
                'name' => 'invperalatan_ukuran'
            ),
            array(
                'header' => 'Keadaaan',
                'name' => 'invperalatan_keadaan'
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
    //========= Dialog pencarian inventarisasi end =========================
?>


