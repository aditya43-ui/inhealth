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
                'width' => 840,
				'height' => 420,
                'resizable' => true,
            ),
        )
    );
	
	$format = new MyFormatter();
	$modDPJP=new PegawaiV('search');
	$modDPJP->unsetAttributes();
	if(isset($_GET['PegawaiV'])){
		$modDPJP->attributes=$_GET['PegawaiV'];
	}
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'dialog-dpjp-m-grid',
		'dataProvider'=>$modDPJP->searchDokterDPJP(),
		'filter'=>$modDPJP,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
                'value'=>function($data) {
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
								"onclick" => " setDokterReseptur('".$data->namaLengkap."',".$data->pegawai_id."); return false; "));
                },
			),
			array(
                'name'=>'nama_pegawai',
                // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
                'value'=>'$data->namaLengkap',
            ),
		),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
	//=============================== END DPJP =======================================
?>