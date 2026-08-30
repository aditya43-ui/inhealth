<?php
echo CHtml::css('#isiScroll{max-height:500px;overflow-y:scroll;margin-bottom:10px;}#makanan-m-grid th{vertical-align:middle;}');
?>

<div id="form-carikata">
	<?php echo CHtml::textField('carikata',"",array('onkeyup'=>'return $(this).focusNextInputField(event);','onblur'=>'cariKata();','placeholder'=>'Ketik kata yang akan dicari')) ?>

	<?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',array('class'=>'btn btn-primary','onclick'=>'cariKata();',)) ?>
	<?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger','onclick'=>'resetCariKata();')) ?>

	<?php //echo CHtml::htmlButton('<i class="entypo-search"></i>',array('class'=>'btn btn-primary','onclick'=>'cariKata();',)) ?>
	<?php //echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>',array('class'=>'btn btn-default','onclick'=>'resetCariKata();')) ?>

</div>
<label><i>Maksimal data yang ditampilkan = 1000</i></label>
<div id='isiScroll'>
<?php
$modDet = new StokopnamegizidetT;
$row = 0;

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
    'id'=>'makanan-m-grid',
    'dataProvider'=>$modMakanan->searchBahanMakananOpname(),
		'mergeHeaders'=>array(
            array(
                'name'=>'<center>Stock</center>',
                'start'=>7,
                'end'=>8,
            ),

        ),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(

		array(
                'header'=> 'Pilih '.CHtml::checkBox('is_pilihsemuaobat',false,array('onclick'=>'pilihSemua(this)','title'=>'Klik untuk pilih / tidak <br>semua obat','rel'=>'tooltip')),
                'type'=>'raw',
                'value'=>'
                    CHtml::hiddenField("StokopnamegizidetT[".$data->bahanmakanan_id."][bahanmakanan_id]",$data->bahanmakanan_id).
                    CHtml::checkBox("StokopnamegizidetT[".$data->bahanmakanan_id."][cekList]", false, array("class"=>"cekList", "onclick"=>"getTotal(); setNol(this);", "onkeyup"=>"return $(this).focusNextInputField(event);"));
                    ',
            ),
            array(
                'name'=>'kelbahanmakanan',
                'header'=>'Kelompok Bahan Makanan',
                'footerHtmlOptions'=>array(
                    'colspan'=>10,
                    'style'=>'text-align:right;font-style:italic;'
                ),
                'footer'=>'Total',
            ),
            array(
                'header'=>'Nama Bahan Makanan',
                'type'=>'raw',
                'value'=>'$data->namabahanmakanan',
            ),
            array(
                'header'=>'Satuan',
                'type'=>'raw',
                'value'=>function($data) {
                    $o = BahanmakananM::model()->findByPk($data->bahanmakanan_id);
                    return $o->satuanbahan;
                }
            ),
            array(
                    'header'=>'Harga Netto (Rp)',
                    'type'=>'raw',
                    'value'=>function($data) {
                            $o = BahanmakananM::model()->findByPk($data->bahanmakanan_id);
                            return CHtml::hiddenField("StokopnamegizidetT[".$data->bahanmakanan_id."][totalharganetto]", MyFormatter::formatNumberForPrint($o->harganettobahan,2), array("class"=>"integer-decimal", "readonly"=>true)).MyFormatter::formatNumberForPrint($o->harganettobahan,2);
                    }
            ),
            array(
                    'header'=>'HPP (Rp)',
                    'type'=>'raw',
                    'value'=>function($data) {
                            $o = BahanmakananM::model()->findByPk($data->bahanmakanan_id);
                            return CHtml::hiddenField("StokopnamegizidetT[".$data->bahanmakanan_id."][totalhpp]", MyFormatter::formatNumberForPrint($o->hpp,2), array("class"=>"integer-decimal", "readonly"=>true)).MyFormatter::formatNumberForPrint($o->hpp,2);
                    }
            ),
            array(
                    'header'=>'Harga Jual (Rp)',
                    'type'=>'raw',
                    'value'=>function($data) {
                            $o = BahanmakananM::model()->findByPk($data->bahanmakanan_id);
                            return MyFormatter::formatNumberForPrint($o->hargajualbahan,2);
                    }
            ),
            array(
                'header'=>'Sistem',
                'type'=>'raw',
                'value'=> function($data) {
                if (empty($data->qtystok)) {
                    $data->qtystok = 0;
                }
                $data->qtystok = MyFormatter::formatNumberForPrint($data->qtystok, 2);
                    return CHtml::textField("StokopnamegizidetT[".$data->bahanmakanan_id."][volume_sistem]", ($data->qtystok), array("class"=>"stok span1 integer-decimal", "readonly"=>true, "style"=>'text-align: right; width: 70px;'));
                },
                'htmlOptions'=>array(
                    'style'=>'text-align: right;',
                ),
            ),
            array(
                'header'=>' Fisik ',
                'type'=>'raw',
                'value'=> 'CHtml::textField("StokopnamegizidetT[".$data->bahanmakanan_id."][volume_fisik]", MyFormatter::formatNumberForPrint((isset($data->volume_fisik) ? ($data->volume_fisik) : ($data->qtystok)),2)  , array("class"=>"fisik span1 integer-decimal", "style"=>"text-align: right; width: 70px;","onblur"=>"getTotal();", "onkeyup"=>"return $(this).focusNextInputField(event);"))',
            ),
            array(
                'header'=>'Waktu Cek Fisik',
                'type'=>'raw',
                    'value' => function($data) use (&$modDet){

                    $tgl = MyFormatter::formatDateTimeForUser(empty($data->tglperiksafisik) ? date("Y-m-d H:i:s") : $data->tglperiksafisik);

                   return  $this->widget('MyDateTimePicker', array(
                        'model'=>$modDet,
                        'attribute'=>'['.$data->bahanmakanan_id.']tglperiksafisik',
                        'mode' => 'datetime',
                        'htmlOptions' => array(
                            'id' => 'StokopnamegizidetT_'.($data->bahanmakanan_id).'_tglperiksafisik',
                            //'size' => '10',
                            'style'=>'width:150px',
                            'class'=>'tglperiksafisik',
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
                'value'=> function($data) {
                    return CHtml::textField("StokopnamegizidetT[".$data->bahanmakanan_id."][totalnilaipersediaan]", MyFormatter::formatNumberForPrint(0,2), array("class"=>"totalnilaipersediaan span2 integer-decimal", "readonly"=>true));
                },
                'htmlOptions'=>array(
                    'style'=>'text-align: right;',
                ),
                'footerHtmlOptions'=>array('style'=>'text-align: right;'),
                'footer'=> CHtml::textField("footerTotalPersediaan", MyFormatter::formatNumberForPrint(0,2), array("class"=>"span2 footerTotalPersediaan integer-decimal", "onkeyup"=>"return $(this).focusNextInputField(event);",'readonly'=>true)),
            ),
            array(
                'header'=>'Tanggal Kadaluarsa',
                'type'=>'raw',
                    'value' => function($data) use (&$modDet, $modMakanan){
					   $tgl = BahanmakananM::model()->findByPk($data->bahanmakanan_id)->tglkadaluarsabahan;
					   $modDet->tglkadaluarsa = (!empty($tgl)?date("d M Y", strtotime($tgl)):null);

						return  $this->widget('MyDateTimePicker', array(
								 'model'=>$modDet,
								 'attribute'=>'[]tglkadaluarsa',
								 'mode' => 'date',
								 'htmlOptions' => array(
									 'id' => 'StokopnamegizidetT_'.($data->bahanmakanan_id+1).'_tglkadaluarsa',
									 //'size' => '10',
									 'style'=>'width:150px',
									 'class'=>' datemask',

								 ),
								 'options' => array(  // (#3)
									// 'dateFormat' => Params::DATE_FORMATV2,
									 //'maxDate' => 'd',

								 ),
							 ),
							 true);
                },
                'footer'=>'&nbsp;',
            ),
            array(
                'header'=>'Kondisi Bahan Makanan',
                'type'=>'raw',
                'value'=> 'CHtml::dropDownList("StokopnamegizidetT[".$data->bahanmakanan_id."][kondisibarang]", "", LookupM::getItems("stokopnamekeadaan"), array("class"=>"span2", "onkeyup"=>"return $(this).focusNextInputField(event);"))',
                'footer'=>'&nbsp;'
            ),
            array(
                'header'=>'Keterangan',
                'type'=>'raw',
				'value'=>'CHtml::textarea("StokopnamegizidetT[".$data->bahanmakanan_id."][ketstok]", "", array("class"=>"span3", "onkeyup"=>"return $(this).focusNextInputField(event);"))',
                'footer'=>'&nbsp;'
            ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("#makanan-m-grid .integer2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null})
            $("#makanan-m-grid .integer-decimal").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":2,"symbol":null})
            reinstallDatePicker();
         }',
));
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    var tr = $('#makanan-m-grid').find('table tbody tr');

    for (var i =1;i<=tr.length;i++){
        $('.tglperiksafisik').datetimepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeFormat':'hh:mm:ss'}));
        $('#StokopnamegizidetT_'+(i-1)+'_tglkadaluarsa').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true}));
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
                        'height'=>155,
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
