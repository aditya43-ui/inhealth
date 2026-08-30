<?php
echo CHtml::css('#isiScroll{max-height:500px;overflow-y:scroll;margin-bottom:10px;}#barang-m-grid th{vertical-align:middle;}');
?>

<div id="form-carikata">
	<?php echo CHtml::textField('carikata',"",array('onkeyup'=>'return $(this).focusNextInputField(event);','onblur'=>'cariKata();','placeholder'=>'Ketik kata yang akan dicari')) ?>
	<?php echo CHtml::htmlButton('<i class="entypo-search"></i>',array('class'=>'btn btn-danger','onclick'=>'cariKata();',)) ?>
	<?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>',array('class'=>'btn btn-default','onclick'=>'resetCariKata();')) ?>
</div>
<label><i>Maksimal data yang ditampilkan = 1000</i></label>
<div id='isiScroll'>
<?php
$modInvBrgDet = new GUInvbarangdetT;
$row = 0;
$array = array();
$provData = $modBarang->searchBarangInventarisasi();
if(count((array)$provData->data)>0){
    $aa=array();
   foreach($provData->data as $i=> $itemd) {
        $aa[$itemd->barang_id][]=$itemd;
        $aaa[]=$itemd->barang_id;
    }
    $index =0;
    foreach($aa as $i=> $itemd) {
        $inventarisasi_qty_in = 0;
        $inventarisasi_qty_out = 0;
        $inventarisasi_qty_skrg = 0;

        foreach ($itemd as $data){
            $inventarisasi_qty_in += $data->inventarisasi_qty_in;
            $inventarisasi_qty_out += $data->inventarisasi_qty_out;
            $inventarisasi_qty_skrg += $data->inventarisasi_qty_skrg;
        }
        foreach ($itemd as $data){
            $data->inventarisasi_qty_in = $inventarisasi_qty_in;
            $data->inventarisasi_qty_out = $inventarisasi_qty_out;
            $data->inventarisasi_qty_skrg = $inventarisasi_qty_skrg;
            $array[$index] = $data;
        }
         $index++;
    }
    $provData->data = $array;
}

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
    'id'=>'barang-m-grid',
//    'dataProvider'=>$modBarang->searchBarangInventarisasi(),
     'dataProvider'=>$provData,
    'mergeHeaders'=>array(
		array(
			'name'=>'<center>Stok</center>',
			'start'=>8,
			'end'=>9,
		),
	),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
		array(
			'header'=> 'Pilih '.CHtml::checkBox('is_pilihsemuabarang',true,array('onclick'=>'pilihSemua(this)','title'=>'Klik untuk pilih / tidak <br>semua obat','rel'=>'tooltip')),
			'type'=>'raw',
			'value'=>'
				CHtml::hiddenField("GUInvbarangdetT[".$data->invbarangdet_id."][invbarangdet_id]",$data->invbarangdet_id).
				(isset($data->inventarisasi_id) ? CHtml::hiddenField("GUInvbarangdetT[".$data->inventarisasi_id."][inventarisasi_id]",$data->inventarisasi_id) : " ").
				CHtml::hiddenField("GUInvbarangdetT[".$data->barang_id."][barang_id]",$data->barang_id).
				CHtml::checkBox("GUInvbarangdetT[".$data->barang_id."][cekList]", false, array("onclick"=>"setUrutan()", "class"=>"cekList", "onclick"=>"getTotal();setNol(this);", "onkeyup"=>"return $(this).focusNextInputField(event);"));
				',
		),
		array(
		 'header'=>'Jenis Barang',
		 'type'=>'raw',
		 'value'=>function($data){
			 $jnsbrg = BarangM::model()->findByPK($data->barang_id);

			 return (isset($jnsbrg->jenisbarangs)?$jnsbrg->jenisbarangs->jenisbarang_nama:"");
			 },
			 'footerHtmlOptions'=>array(
											 'colspan'=>10,
											 'style'=>'text-align:right;font-style:italic;'
			 ),
			 'footer'=>'Total',
	 ),
		array(
			'header'=>'Kode Barang',
			'type'=>'raw',
			'value'=>'!empty($data->barang_kode) ? $data->barang_kode :"-"',
		),
		array(
			'header'=>'Nama Barang',
			'type'=>'raw',
			'value'=>'$data->barang_nama',
		),
		array(
			'header'=>'Merk',
			'type'=>'raw',
			'value'=>'$data->barang_merk',
		),
		array(
			'header'=>'No. Seri',
			'type'=>'raw',
			'value'=>'$data->barang_noseri',
		),
		array(
			'header'=>'Harga Netto (Rp)',
			'type'=>'raw',
			'value'=>function($data){
 			 return MyFormatter::formatNumberForPrint($data->barang_harganetto,2) . CHtml::hiddenField("GUInvbarangdetT[".$data->barang_id."][inventarisasi_hargasatuan]", MyFormatter::formatNumberForPrint($data->barang_harganetto,2)
 			, array("class"=>"span1 netto integer-decimal","onkeyup"=>"return $(this).focusNextInputField(event);", "style"=>"width:64px;"));
 		 },
		),
		array(
		 'header'=>'HPP (Rp)',
		 'type'=>'raw',
		 'value'=>function($data){
			 $brg = BarangM::model()->findByPK($data->barang_id);

			 return MyFormatter::formatNumberForPrint((isset($brg)?$brg->barang_hpp:0),2).CHtml::hiddenField("GUInvbarangdetT[".$data->invbarangdet_id."][barang_hpp]",MyFormatter::formatNumberForPrint((isset($brg)?$brg->barang_hpp:0),2),array('class'=>'integer-decimal'));
		 },
	 ),
		array(
			'header'=>'Sistem',
			'type'=>'raw',
            'value'=> function($data) {
                if (!empty($data->invbarang_id)) {
                    $val = $data->volume_sistem;
                } else {
                    $val = (isset($data->inventarisasi_qty_skrg) ? $data->inventarisasi_qty_skrg :
                    (isset($data->inventarisasi->inventarisasi_qty_skrg) ? $data->inventarisasi->inventarisasi_qty_skrg :
                    0));
                }
				$val = MyFormatter::formatNumberForPrint($data->inventarisasi_qty_skrg,2);
                return CHtml::textField("GUInvbarangdetT[".$data->barang_id."][inventarisasi_qty_skrg]", $val,
                array("class"=>"stok span1 integer-decimal", "readonly"=>true))." ".$data->barang_satuan;
            },
		),
		array(
			'header'=>'<div class="test" style="cursor:pointer;" onclick="openDialogini()"> Fisik <icon class="icon-white icon-list"></icon></div> ',
			'type'=>'raw',
			'value'=> 'CHtml::textField("GUInvbarangdetT[".$data->barang_id."][inventarisasi_qty_fisik]", '
			. '(isset($data->inventarisasi_qty_skrg) ? MyFormatter::formatNumberForPrint($data->inventarisasi_qty_skrg,2) : '
			. '(isset($data->volume_fisik) ? MyFormatter::formatNumberForPrint($data->volume_fisik,2) : '
			. 'MyFormatter::formatNumberForPrint(0,2))), array("class"=>"fisik span1 integer-decimal numberdesimal", "onblur"=>"getTotal();", "onkeyup"=>"return $(this).focusNextInputField(event);", "style"=>"text-align: right;"))." ".$data->barang_satuan',
		),
		array(
		 'header'=>'Nilai Persediaan (Rp)',
		 'type'=>'raw',
		 'value'=>function($data){
			 return CHtml::textField("GUInvbarangdetT[".$data->invbarangdet_id."][totalnilaipersediaan]",MyFormatter::formatNumberForPrint(0,2),array('class'=>'integer-decimal span2','readonly'=>true));
		 },
		 'footerHtmlOptions'=>array('style'=>'text-align: right;'),
		 'footer'=> CHtml::textField("footerTotalPersediaan",MyFormatter::formatNumberForPrint(0,2),array('class'=>'integer-decimal span2 footerTotalPersediaan','readonly'=>true)),
	 ),
		array(
			'header'=>'Waktu Cek Fisik',
			'type'=>'raw',
			'value' => function($data) use (&$modInvBrgDet){
				$modInvBrgDet->tglperiksafisik = (isset($data->tglperiksafisik) ? (empty($data->tglperiksafisik) ?  date("d M Y H:i:s") : date("d M Y H:i:s",strtotime($data->tglperiksafisik))) : date("d M Y H:i:s"));

				return  $this->widget('MyDateTimePicker', array(
					'model'=>$modInvBrgDet,
					'attribute'=>'[]tglperiksafisik',
					'mode' => 'datetime',
					'htmlOptions' => array(
						'id' => 'GUInvbarangdetT_'.($modInvBrgDet->invbarangdet_id+1).'_tglperiksafisik',
						'size' => '10',
						'style'=>'width:150px'
					),
					'options' => array(  // (#3)
						'dateFormat' => Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
				),
				true);
			},
			'footerHtmlOptions'=>array(),
			'footer'=>'&nbsp;',
		),
		array(
			'header'=>'Kondisi Barang',
			'type'=>'raw',
			'value'=> 'CHtml::dropDownList("GUInvbarangdetT[".$data->barang_id."][kondisi_barang]", "", LookupM::getItems("inventariskeadaan"), array("class"=>"span2", "onkeyup"=>"return $(this).focusNextInputField(event);"))',
			'footerHtmlOptions'=>array(),
			'footer'=>'&nbsp;',
		),
        array(
			'header'=>'Keterangan',
			'type'=>'raw',
			'value'=>'CHtml::textArea("GUInvbarangdetT[".$data->barang_id."][ket_inv]", "")',
			'footerHtmlOptions'=>array(),
			'footer'=>'&nbsp;',
		),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("#barang-m-grid .integer2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null})
            $("#barang-m-grid .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null})
            $("#barang-m-grid .numberdesimal").maskMoney({"symbol": null, "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2})
			$("#barang-m-grid .datetimemask").mask("99/99/9999 99:99:99");
            getTotal();
            reinstallDatePicker();
         }',
));
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    var tr = $('#barang-m-grid').find('table tbody tr');

    for (var i =1;i<=tr.length;i++){
    $('#GUInvbarangdetT_'+(i-1)+'_tglperiksafisik').datetimepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeFormat':'hh:mm:ss'}));
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
