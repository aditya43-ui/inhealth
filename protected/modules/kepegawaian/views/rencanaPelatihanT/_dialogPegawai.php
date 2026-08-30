<?php

$modPegawai = new KPPegawaiV('searchPegawaiPelatihan');
$modPegawai->unsetAttributes();
if(isset($_GET['KPPegawaiV'])) {
    $modPegawai->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-grid',
	'dataProvider'=>$modPegawai->searchPegawaiPelatihan(),
	'filter'=>$modPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPegawai",
                                    "onClick" => "
                                            setPegawaiAuto($data->pegawai_id);
									"))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),                
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawai, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                ),
                array(
                    'header'=>'Jabatan',
                    'filter'=>  CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --')),
                    'value'=> function($data){
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                        
                        if (!empty($j)){
                            return $j->jabatan_nama;
                        }else{
                            return '-';
                        }
                    }   
                ),
                /*array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawai, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),*/
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
?>
<script type="text/javascript">
    
    $("#tablePencarianPegawai .pagination ul li a").click(function(event){
        url = $(this).attr("href");
        $.get(url,{},function(data){
            $('#tablePencarianPegawai').html(data);
        });
        return false;
    });
</script>