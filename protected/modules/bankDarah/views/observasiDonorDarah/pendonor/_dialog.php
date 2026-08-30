<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - untuk memanggil dialog box 
* RSST-1498
*/

/** =============== Pengirima Start ===================== **/
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPetugas',
            'options'=>array(
                'title'=>'Pencarian Petugas Pengirim' ,
                'autoOpen'=>false,
                'width' => 530,
                'height' => 500,
                'resizable' => true,
            ),
        )
    );
        	
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
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
                                        "onclick" => " setPetugas(\"".$data->namaLengkap."\",".$data->pegawai_id."); return false; "));
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
                            $j = JabatanM::model()->findByPk($data->jabatan_id);
                            
                            if (!empty($j)){
                                return $j->jabatan_nama;
                            }
                        },
                        'filter' => CHtml::activeDropDownList($pegPengirim, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE "), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
                    ),
            ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //=============================== END Pengirim =======================================