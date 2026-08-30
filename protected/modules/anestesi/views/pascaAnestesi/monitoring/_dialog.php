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
                'title'=>'Pencarian Petugas Monitoring' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 600,
                'resizable' => true,
            ),
        )
    );
        	        
    $format = new MyFormatter();
    $modPeg=new PegawairuanganV('search');
    
    if(isset($_GET['PegawairuanganV'])){
            $modPeg->attributes=$_GET['PegawairuanganV'];            
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialog-pengirim-m-grid',
            'dataProvider'=>$modPeg->searchDialogPegRuangan(),
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
                                        "onClick" => "                                                                                
                                            setPetugas(".$dt.");
                                            $('#".CHtml::activeId($model, 'monitoringpeg_nama')."').blur();
                                        return false;"));
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
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');        


    
//========= Dialog pencarian ruangan =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDiagnosa',
        'options' => array(
            'title' => 'Pencarian Diagnosa',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'resizable' => false,
        ),
    ));
    
    
    $modDiagnosa = new DiagnosaM('search');
    $modDiagnosa->diagnosa_aktif = true;
    if (isset($_GET['DiagnosaM'])){
        $modDiagnosa->attributes = $_GET['DiagnosaM'];
        $modDiagnosa->diagnosa_aktif = true;
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'ruangan-m-grid2',
        'dataProvider' => $modDiagnosa->search(),
        'filter' => $modDiagnosa,        
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
                                        "onClick" => "                                                                                
                                            setDiagnosa(".$res.");
                                            $('#".CHtml::activeId($model, 'diagnosa_nama')."').blur();
                                        return false;"));
                },
            ),
            array(
                'header' => 'Kode',                
                'name'=> 'diagnosa_kode',
                'value' => '$data->diagnosa_kode',                
            ),
            array(
                'header' => 'Diagnosis',                
                'name' => 'diagnosa_nama',
                'value' => '$data->diagnosa_nama'
            ),
            array(
                'header' => 'Catatan',                
                'name' => 'diagnosa_namalainnya',
                'value' => '$data->diagnosa_namalainnya'
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
        
    
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogUbah',
        'options' => array(
            'title' => 'Ubah Data',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 900,
            'height' => 300,
            'resizable' => true,    
            'close' => 'js:function(){$("#form-dialog-ubah").html("");}'
        ),
    ));

echo CHtml::hiddenField("noUrut", 0); ?>

<div id="form-dialog-ubah" class="form-horizontal">
        
    
</div>

<?php $this->endWidget(); ?>


