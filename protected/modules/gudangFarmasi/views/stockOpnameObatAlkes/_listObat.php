<?php
echo CHtml::css('#isiScroll{max-height:500px;overflow-y:scroll;margin-bottom:10px;}#obatalkes-m-grid th{vertical-align:middle;}');
?>
<div id="form-carikata">
	<?php echo CHtml::textField('carikata',"",array('onkeyup'=>'return $(this).focusNextInputField(event);','onblur'=>'cariKata();','placeholder'=>'Ketik kata yang akan dicari')) ?>
	<?php echo CHtml::htmlButton('<i class="entypo-search"></i>',array('class'=>'btn btn-danger','onclick'=>'cariKata();',)) ?>
	<?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>',array('class'=>'btn btn-default','onclick'=>'resetCariKata();')) ?>
</div>
<label><i>Maksimal data yang ditampilkan = 250</i></label>
<div id='isiScroll'>
<?php

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
    'id'=>'obatalkes-m-grid',
    'dataProvider'=>$modObat->searchObatStokOpname(), //RND-6011
    'mergeHeaders'=>array(
            array(
                'name'=>'<center>Stok</center>',
                'start'=>8,
                'end'=>9,
            ),

        ),
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-bordered table-striped table-condensed',
    'columns'=>array(
            array(
                'header'=> 'Pilih '.CHtml::checkBox('is_pilihsemuaobat',false,array('onclick'=>'pilihSemua(this)','title'=>'Klik untuk pilih / tidak <br>semua obat','rel'=>'tooltip')),
                'type'=>'raw',
                'value'=>'
                    CHtml::hiddenField("GFStokopnamedetT[".$data->obatalkes_id."][obatalkes_id]",$data->obatalkes_id).
                    CHtml::checkBox("GFStokopnamedetT[".$data->obatalkes_id."][cekList]", false, array("class"=>"cekList", "onclick"=>"getTotal(); setNol(this);", "onkeyup"=>"return $(this).focusNextInputField(event);"));
                    ',
            ),
            array(
                'header'=>'Jenis Obat Alkes',
                'type'=>'raw',
                'value'=>'$data->jenisobatalkes_nama',
                'footerHtmlOptions'=>array(
                    'colspan'=>11,
                    'style'=>'text-align:right;font-style:italic;'
                ),
                'footer'=>'Total',
            ),
         array(
                'header'=>'Kode Obat Alkes',
                'type'=>'raw',
                'value'=>'$data->obatalkes_kode',
            ),
            array(
                'header'=>'Nama Obat Alkes',
                'type'=>'raw',
                'value'=>'$data->obatalkes_nama',
            ),
            array(
                'header'=>'Satuan<br/>Kecil',
                'type'=>'raw',
                'value'=>function($data) {
                    $o = ObatalkesM::model()->findByPk($data->obatalkes_id);
                    return $o->satuankecil->satuankecil_nama;
                }
            ),
            array(
                'header'=>'Harga Netto (Rp)',
                'type'=>'raw',
                'value'=>function($data){
                    return MyFormatter::formatNumberForPrint($data->harganetto,2).CHtml::hiddenField("GFStokopnamedetT[".$data->obatalkes_id."][harganetto]", MyFormatter::formatNumberForPrint($data->harganetto,2), array("class"=>"span2 netto integer-decimal","onkeyup"=>"return $(this).focusNextInputField(event);"));
                },
            ),
						array(
                'header'=>'HPP (Rp)',
                'type'=>'raw',
                'value'=>function($data){
                    return MyFormatter::formatNumberForPrint($data->hpp,2).CHtml::hiddenField("GFStokopnamedetT[".$data->obatalkes_id."][hpp]", MyFormatter::formatNumberForPrint($data->hpp,2), array("class"=>"span2 hpp integer-decimal", "onkeyup"=>"return $(this).focusNextInputField(event);"));
                },
            ),
            array(
                'header'=>'Harga Jual (Rp)',
                'type'=>'raw',
				'value'=>function($data){
					return MyFormatter::formatNumberForPrint((isset($data->hargajual) ? $data->hargajual : $data->hargasatuan),2).CHtml::hiddenField("GFStokopnamedetT[".$data->obatalkes_id."][hargasatuan]", MyFormatter::formatNumberForPrint((isset($data->hargajual) ? $data->hargajual : $data->hargasatuan),2), array("class"=>"span2 harga integer-decimal","onkeyup"=>"return $(this).focusNextInputField(event);"));
				},
            ),
            array(
                'header'=>'Sistem',
                'type'=>'raw',
                'value'=> 'CHtml::textField("GFStokopnamedetT[".$data->obatalkes_id."][volume_sistem]", MyFormatter::formatNumberForPrint(($data->qtystok),2), array("class"=>"stok span1 integer-decimal", "readonly"=>true))',
                'htmlOptions'=>array(
                    'style'=>'text-align: right;',
                ),
            ),
            array(
                'header'=>'Fisik',
                'type'=>'raw',
                'value'=> 'CHtml::textField("GFStokopnamedetT[".$data->obatalkes_id."][volume_fisik]", MyFormatter::formatNumberForPrint((isset($data->volume_fisik) ? ($data->volume_fisik) : ($data->qtystok)),2)  , array("class"=>"fisik span1  integer-decimal numberdecimal", "style"=>"text-align: right;","onblur"=>"getTotal();", "onkeyup"=>"return $(this).focusNextInputField(event);"))',
            ),
            array(
                'header'=>'Waktu Cek Fisik',
                'type'=>'raw',
                    'value' => function($data) use (&$modDet){

                    $tgl = (empty($data->tglperiksafisik)) ? date("d/m/Y H:i:s") : date("d/m/Y H:i:s",strtotime($data->tglperiksafisik));

                   return  $this->widget('MyDateTimePicker', array(
                        'model'=>$modDet,
                        'attribute'=>'[]tglperiksafisik',
                        'mode' => 'datetime',
                        'htmlOptions' => array(
                            'id' => 'GFStokopnamedetT_'.($data->obatalkes_id+1).'_tglperiksafisik',
                            //'size' => '10',
                            'style'=>'width:150px',
                            'class'=>' datetimemask',
                            'value'=>$tgl
                        ),
                        'options' => array(  // (#3)
                           // 'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                            'value'=>$tgl,
                        ),
                    ),
                    true);
                }
            ),
            array(
                'header'=>'Nilai Persediaan (Rp)',
                'type'=>'raw',
                'value'=>function($data){
                    return CHtml::textField("GFStokopnamedetT[".$data->obatalkes_id."][totalnilaipersediaan]", MyFormatter::formatNumberForPrint(0,2), array("class"=>"span2 integer-decimal",'readonly'=>true,"onkeyup"=>"return $(this).focusNextInputField(event);"));
                },
                'footerHtmlOptions'=>array('style'=>'text-align: right;'),
                'footer'=> CHtml::textField("footerTotalPersediaan", MyFormatter::formatNumberForPrint(0,2), array("class"=>"span2 footerTotalPersediaan integer-decimal", "onkeyup"=>"return $(this).focusNextInputField(event);",'readonly'=>true)),
            ),
            array(
                'header'=>'Tanggal Kadaluarsa',
                'type'=>'raw',
                    'value' => function($data) use (&$modDet, $modObat){
				   if ($modObat->jenisstokopname == Params::JENISSTOKOPNAME_PENYESUAIAN){
					   return CHtml::dropDownList("GFStokopnamedetT[".$data->obatalkes_id."][tglkadaluarsa]", '',$data->getAllTglKadaluarsa($data->obatalkes_id, Yii::app()->user->getState('ruangan_id')),array('class'=>'span3'));
				   }else{
					   $tgl = ObatalkesM::model()->findByPk($data->obatalkes_id)->tglkadaluarsa;
					   $modDet->tglkadaluarsa = (!empty($tgl)?date("d/m/Y", strtotime($tgl)):null);

						return  $this->widget('MyDateTimePicker', array(
								 'model'=>$modDet,
								 'attribute'=>'[]tglkadaluarsa',
								 'mode' => 'date',
								 'htmlOptions' => array(
									 'id' => 'GFStokopnamedetT_'.($data->obatalkes_id+1).'_tglkadaluarsa',
									 //'size' => '10',
									 'style'=>'width:150px',
									 'class'=>' datemask',

								 ),
								 'options' => array(  // (#3)
									// 'dateFormat' => Params::DATE_FORMATV2,
									 'maxDate' => '+10y',

								 ),
							 ),
							 true);
				   }
                },
								'footerHtmlOptions'=>array(),
								'footer'=>'&nbsp;',
            ),
            array(
                'header'=>'Kondisi Obat',
                'type'=>'raw',
                'value'=> 'CHtml::dropDownList("GFStokopnamedetT[".$data->obatalkes_id."][kondisibarang]", "", LookupM::getItems("stokopnamekeadaan"), array("class"=>"span2", "onkeyup"=>"return $(this).focusNextInputField(event);"))',
								'footerHtmlOptions'=>array(),
								'footer'=>'&nbsp;',
            ),
            array(
                'header'=>'Keterangan',
                'type'=>'raw',
//                'value'=>'$data->',
				'value'=>'CHtml::textField("GFStokopnamedetT[".$data->obatalkes_id."][ketstok]", "", array("class"=>"span3", "style"=>"text-align: right;", "onkeyup"=>"return $(this).focusNextInputField(event);"))',
				'footerHtmlOptions'=>array(),
				'footer'=>'&nbsp;',
            ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            //console.log("kick");

            $(".cekList").each(function() {setNol(this); });
            $("#obatalkes-m-grid .integer2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null})
            $("#obatalkes-m-grid .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null})
            $("#obatalkes-m-grid .numberdecimal").maskMoney({"symbol": null, "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2})
            $("#obatalkes-m-grid .datetimemask").mask("99/99/9999 99:99:99");
            $("#obatalkes-m-grid .datemask").mask("99/99/9999");
            getTotal();
            reinstallDatePicker();
                }',
));
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    var tr = $('#obatalkes-m-grid').find('table tbody tr');

    for (var i =1;i<=tr.length;i++){
        $('#GFStokopnamedetT_'+(i-1)+'_tglperiksafisik').datetimepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::TIME_FORMATV2."','changeMonth':true, 'changeYear':true,'maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeFormat':'hh:mm:ss'}));
        $('#GFStokopnamedetT_'+(i-1)+'_tglkadaluarsa').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMATV2."','changeMonth':true, 'changeYear':true,'maxDate':'+10y'}));
    }
}
");
            ?>
    </div>

<?php
// ===========================Dialog Details Tarif=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogDetails',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Volume Fisik',
                        'autoOpen'=>false,
                        'width'=>150,
                        'height'=>140,
                        'resizable'=>false,
                        'scroll'=>false,
                            'modal'=>true
                         ),
                    ));
?>
<div class="awawa" width="100%" height="100%">
    <?php echo CHtml::textField('fisiks', 0, array('class'=>'numbers-only span2')); ?><br><br>
    <?php echo CHtml::button('submit', array('class'=>'btn btn-primary', 'onclick'=>'setVolume();', 'id'=>'submitJumlahVolume')); ?>
</div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');

Yii::app()->clientScript->registerScript('openDialog','
    function openDialogini(){
        $("#dialogDetails").dialog("open");
    }
',  CClientScript::POS_HEAD);
?>
