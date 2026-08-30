<div id='isiScroll'>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pencucianlinen-grid',
    'dataProvider'=>$modInfoPencucian->searchPenyimpanan(),
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
            array(
                'header'=> 'Pilih '.CHtml::checkBox('is_pilihsemua',true,array('onclick'=>'pilihSemua(this)','title'=>'Klik untuk pilih / tidak <br>semua obat','rel'=>'tooltip')),
                'type'=>'raw', //$row+1
                'value'=>'
                    CHtml::hiddenField(\'LAPenyimpananlinendetT[\'.($row+1).\'][linen_id]\',$data->linen_id).
					CHtml::hiddenField(\'LAPenyimpananlinendetT[\'.($row+1).\'][ruangan_id]\',$data->ruangan_id).
                    CHtml::hiddenField(\'LAPenyimpananlinendetT[\'.($row+1).\'][pencucianlinen_id]\',$data->getNoPencucian($data->no_linen, $data->kode)).
                    CHtml::hiddenField(\'LAPenyimpananlinendetT[\'.($row+1).\'][perawatanlinen_id]\',$data->getNoPerawatan($data->no_linen, $data->kode)).
                    CHtml::checkBox(\'LAPenyimpananlinendetT[\'.($row+1).\'][checklist]\', true, array(\'class\'=>\'checklist\', \'onclick\'=>\'setNol(this);\'));
                    ',
            ),
            array(
                'header'=>'Lokasi Penyimpanan <span class="required">*</span>',
                'type'=>'raw',
                'value'=>function($data){
                     echo CHtml::dropDownList('lokasipenyimpanan_id', '', CHtml::listData(LALokasipenyimpananM::model()->findAll('lokasipenyimpanan_aktif = true ORDER BY lokasipenyimpanan_nama ASC'), 'lokasipenyimpanan_id', 'lokasipenyimpanan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'setRekonsiliasiBank(this);'));
                },
                // 'value'=>'CHtml::dropDownList(\'LAPenyimpananlinendetT[\'.($row+1).\'][lokasipenyimpanan_id]\',"",CHtml::listData(LALokasipenyimpananM::model()->findAll(),"lokasipenyimpanan_id","lokasipenyimpanan_nama"),array("onchange"=>"updateListRakPenyimpanan(this)","empty"=>"-- Pilih --","class"=>"span2 required", "onkeypress"=>"return $(this).focusNextInputField(event);"))'
            ),
            array(
                'header'=>'Sub Rak <span class="required">*</span>',
                'type'=>'raw',
                'value'=>'CHtml::dropDownList(\'LAPenyimpananlinendetT[\'.($row+1).\'][rakpenyimpanan_id]\',"",CHtml::listData(LARakpenyimpananM::model()->findAll(),"rakpenyimpanan_id","rakpenyimpanan_nama"),array("empty"=>"-- Pilih --","class"=>"span2 rak required", "onkeypress"=>"return $(this).focusNextInputField(event);"))'
            ),
            array(
                'header'=>'No. Pencucian/ Perawatan',
                'type'=>'raw',
                'value'=>'isset($data->no_linen) ? $data->no_linen : ""',
            ),            
            array(
                'header'=>'Ruangan Asal',
                'type'=>'raw',
                'value'=>'isset($data->ruangan_nama) ? $data->ruangan_nama : ""',
            ),            
            array(
                'header'=>'Kode Linen',
                'type'=>'raw',
                'value'=>'isset($data->kodelinen) ? $data->kodelinen : ""',
            ),            
            array(
                'header'=>'Nama Linen',
                'type'=>'raw',
                'value'=>'isset($data->namalinen) ? $data->namalinen : ""',
            ),            
            array(
                'header'=>'Keterangan',
                'type'=>'raw',
                'value'=>'CHtml::textField(\'LAPenyimpananlinendetT[\'.($row+1).\'][keterangan_penyimpananlinen]\')'
            ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                }',
)); ?> 
</div>