<?php
/**
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * 
 * Menampilkan dialog DPJP rawat inap
 */


    //=============================== Dialog DPJP =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogDokterDPJP',
            'options'=>array(
                'title'=>'Dokter Resep' ,
                'autoOpen'=>false,
                'width' => 600,
              
                'resizable' => true,
            ),
        )
    );
    
    
	
	$format = new MyFormatter();
	$modDPJP=new DokterV('search');
	$modDPJP->unsetAttributes();
	if(isset($_GET['DokterV'])){
		$modDPJP->attributes=$_GET['DokterV'];
	}
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'dialog-dpjp-m-grid',
		'dataProvider'=>($this->init_modul == 'FA' ? $modDPJP->searchDialogPeg() : $modDPJP->searchDialogPegRuangan()),
		'filter'=>$modDPJP,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
                'value'=>function($data) {
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
								"onclick" => " setDokterReseptur(\"".$data->namaLengkap."\",".$data->pegawai_id."); return false; "));
                },
                'filter'=>($this->init_modul == 'FA' ? CHtml::activeHiddenField($modDPJP, 'ruangan_id') : false),
			),
			 array(
                            'name'=>'nomorindukpegawai',
                            'header'=>'NIP',
                            ),
                            array(
                            'header' => 'Nama Dokter',
                            'name' =>'nama_pegawai',
                            'value' => '$data->namaLengkap',
                            ),
                            array(
                            'name'=>'jabatan_id',
                            'header'=>'Jabatan',
                            'value'=>function($data) {
                            $modul = JabatanM::model()->findByPk($data->jabatan_id);
                            if (!empty($modul)){
                            return $modul->jabatan_nama;}
                            },
                            'filter' => Chtml::activeDropDownList($modDPJP, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll(), 'jabatan_id', 'jabatan_nama'), array('empty'=>'-- Pilih --')),
                            ),
		),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
	//=============================== END DPJP =======================================
?>