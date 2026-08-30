<?php 
echo CHtml::css('#isiScroll{max-height:300px;overflow-y:scroll;margin-bottom:10px;}'); 
?>
<div id='isiScroll'>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'gantikacamata-t-grid',
    'dataProvider'=>$modGantiKacamata->searchGantiKacamata(),
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-bordered table-condensed',
    'columns'=>array(
            array(
                'header'=> 'Pilih '.CHtml::checkBox('is_pilihsemua',true,array('onclick'=>'pilihSemua(this)','title'=>'Klik untuk pilih / tidak <br> daftar penggantian kacamata','rel'=>'tooltip')),
                'type'=>'raw',
                'value'=>'
                    CHtml::hiddenField(\'MCGantikacamataT[\'.$data->gantikacamata_id.\'][gantikacamata_id]\',$data->gantikacamata_id).
                    CHtml::checkBox(\'MCGantikacamataT[\'.$data->gantikacamata_id.\'][cekList]\', true, array(\'class\'=>\'cekList\', \'onclick\'=>\'hitungTotal(this);setNol(this);\'));
                    ',
            ),
            array(
                'header'=>'NIP',
                'type'=>'raw',
                'value'=>'$data->pegawai->nomorindukpegawai',
            ),
            array(
                'header'=>'Nama Pasien',
                'type'=>'raw',
                'value'=>'$data->namapasien_hub',
            ),
            array(
                'header'=>'Status',
                'type'=>'raw',
                'value'=>'$data->statushubungan',
            ),
            array(
                'header'=>'Nama Pekerjaan',
                'type'=>'raw',
                'value'=>'isset($data->pegawai->jabatan->jabatan_nama) ? $data->pegawai->jabatan->jabatan_nama : "-"',
            ),
            array(
                'header'=>'Departement',
                'type'=>'raw',
                'value'=>'isset($data->departement_peg) ? $data->departement_peg : "-"',
            ),
            array(
                'header'=>'Due Date',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->duedata_kacamata)',
				'htmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
                'header'=>'Tgl. Ganti Kacamata',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tglgantikacamata)',
				'htmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
                'header'=>'VOD',
                'type'=>'raw',
                'value'=>'$data->vod_spheris." ".$data->vod_cylindrys',
            ),
            array(
                'header'=>'VOS',
                'type'=>'raw',
                'value'=>'$data->vos_spheris." ".$data->vos_cylindrys',
            ),
            array(
                'header'=>'ADD',
                'type'=>'raw',
                'value'=>'$data->add_kacamata',
            ),            
            array(
                'header'=>'Harga',
                'type'=>'raw',
                'value'=>'CHtml::textField(\'MCGantikacamataT[\'.$data->gantikacamata_id.\'][jumlahharga_km]\',$data->jumlahharga_km,array("class"=>"span2 integer","readonly"=>true))'
            ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
			}',
)); ?> 
</div>