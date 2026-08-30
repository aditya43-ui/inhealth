<?php 
echo CHtml::css('#isiScroll{max-height:500px;overflow-y:scroll;margin-bottom:10px;}#obatalkes-m-grid th{vertical-align:middle;}'); 
?>
<?php 

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
    'id'=>'obatalkes-m-grid',
    'dataProvider'=>$modAkun->searchSaldoAwal(), //RND-6011 
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-bordered table-striped table-condensed',
    'columns'=>array(
            array(
                'header'=> 'Pilih '.CHtml::checkBox('is_pilihsemuasaldo',false,array('onclick'=>'pilihSemua(this)','title'=>'Klik untuk pilih / tidak <br>semua obat','rel'=>'tooltip')),
                'type'=>'raw',
				'value'=>'
					CHtml::hiddenField("AKSaldoawalT[".$row."][rekening5_id]",$data->rekening5_id).
					CHtml::hiddenField("AKSaldoawalT[".$row."][saldoawal_id]",$data->saldoawal_id).
					CHtml::hiddenField("AKSaldoawalT[".$row."][rekperiod_id]",$data->rekperiod_id).
					CHtml::hiddenField("AKSaldoawalT[".$row."][periodeposting_id]",$data->periodeposting_id).
                    CHtml::checkBox("AKSaldoawalT[".$row."][cekList]", (!empty($data->saldoawal_id)?true:false), array("class"=>"cekList", "onclick"=>"setNol(this);"));
                    ',
            ),
            array(
				'header' => 'Nama Akun',
				'value' => '$data->kdrekening5." - ".$data->nmrekening5'
			),
            array(
				'header' => 'Mata Uang/<br/>Kurs',
				'type'=>'raw',
				'value'=> 'CHtml::dropDownList("AKSaldoawalT[".$row."][matauang_id]", !empty($data->matauang_id)?$data->matauang_id:Params::MATAUANG_ID_RUPIAH, CHtml::listData(MatauangM::model()->findAll(" matauang_aktif = TRUE ORDER BY matauang ASC "),"matauang_id","matauang"), array("class"=>"span2", "onkeyup"=>"return $(this).focusNextInputField(event);"))."<br/>".CHtml::dropDownList("AKSaldoawalT[".$row."][kursrp_id]", !empty($data->kursrp_id)?$data->kursrp_id:"", CHtml::listData(KursrpM::model()->findAll(" kursrp_aktif = TRUE  ORDER BY nilai ASC "),"kursrp_id","nilaiRupiah"), array("empty"=>"-- Pilih --","class"=>"span2", "onkeyup"=>"return $(this).focusNextInputField(event);"))',//AND matauang_id =".(!empty($data->matauang_id)?$data->matauang_id:9999999)."
			),
			array(
				'header' => 'Saldo Debit',
				'type'=>'raw',
				'value' => 'CHtml::textField("AKSaldoawalT[".$row."][jmlsaldoawald]",!empty($data->jmlsaldoawald)?number_format($data->jmlsaldoawald,2,",","."):number_format(0,2,",","."),array("style"=>"text-align:right;","class"=>"float2"))',
				'htmlOptions' => array('style' => 'text-align:right;')
			),
			array(
				'header' => 'Saldo Kredit',
				'type'=>'raw',
				'value' => 'CHtml::textField("AKSaldoawalT[".$row."][jmlsaldoawalk]",!empty($data->jmlsaldoawalk)?number_format($data->jmlsaldoawalk,2,",","."):number_format(0,2,",","."),array("style"=>"text-align:right;","class"=>"float2"))',
				'htmlOptions' => array('style' => 'text-align:right;')
			),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            //console.log("kick");
            
            $(".cekList").each(function() {setNol(this); });
            $("#obatalkes-m-grid .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null})                                    
                }',
)); 

            ?> 
