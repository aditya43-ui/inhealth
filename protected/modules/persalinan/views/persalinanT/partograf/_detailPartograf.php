<?php 
	$ii = isset($i)?$i:'0';

	if ($data == 'djj'){
		echo '<td>'.
				CHtml::activeTextField($det, '['.$ii.']p1_djj_menit',array('onkeyup'=>'setNumbersOnly(this);','class' => 'numbers-only span1 djj manyinput', 'valueid'=>2, 'onblur'=>'generateGrafik();')).
				CHtml::activeHiddenField($det,'['.$ii.']pemeriksaanpartografdet_id',array('class' => 'numbers-only span1 det_id manyinput', 'valueid'=>2)).
			'</td>';
	}elseif($data == 'airketuban'){
		echo '<td>'.CHtml::activeDropDownList($det, '['.$ii.']p2_airketuban', LookupM::getItems('partograf_airketuban'), array('empty' => '-- Pilih --','class' => 'span3 airketuban', 'valueid'=>1)).'</td>';
	}elseif($data == 'penyusupan'){
		echo '<td>'.CHtml::activeDropDownList($det, '['.$ii.']p2_penyusupan', LookupM::getItems('partograf_penyusupan'), array('empty' => '-- Pilih --','class' => 'span3 penyusupan', 'valueid'=>2)).'</td>';
	}elseif($data == 'serviks'){
		echo '<td>'.CHtml::activeTextField($det, '['.$ii.']p3_pembukaanserviks',array('onkeyup'=>'setNumbersOnly(this);','class' => 'numbers-only span1 serviks', 'valueid'=>3, 'onblur'=>'generateGrafik();')).'</td>';
	}elseif($data == 'kepala'){
		echo '<td>'.CHtml::activeTextField($det, '['.$ii.']p3_turunnyakepala',array('onkeyup'=>'setNumbersOnly(this);','class' => 'numbers-only span1 turunkepala', 'valueid'=>4, 'onblur'=>'generateGrafik();')).'</td>';
	}elseif($data == 'waktu'){
		echo '<td>'.CHtml::activeTextField($det, '['.$ii.']p3_waktu',array('class' => 'span1 waktu', 'valueid'=>5, 'readonly'=>true, 'onblur'=>'generateGrafik();')).'</td>';
	}elseif($data == 'waktulabel'){		
		$lbl = '';
		if (isset($labeltime)){
			$lbl = $labeltime;
		}
		
		if ($row % 2 == 0){
			//echo '<td colspan="1"><span class="waktulabel">'.$tot.'</span></td>';
		}else{
			echo '<td colspan="2"><span class="waktulabel">'.$lbl.'</span></td>';
		}
	}elseif($data == 'kontraksijumlah'){
		echo '<td>'.CHtml::activeTextField($det, '['.$ii.']p4_kontraksi_jml',array('onkeyup'=>'setNumbersOnly(this);','class' => 'span1 kontraksijumlah numbers-only', 'valueid'=>6, 'onblur'=>'generateGrafik();')).'</td>';
	}elseif($data == 'kontraksidetik'){
		echo '<td>'.CHtml::activeDropDownList($det, '['.$ii.']p4_kontraksi_lama_detik', LookupM::getItems('partograf_lamakontraksi'), array('onkeyup'=>'setNumbersOnly(this);','empty' => '-- Pilih --','class' => 'span2 kontraksidetik', 'valueid'=>7, 'onchange'=>'generateGrafik();')).'</td>';
	}elseif($data == 'oksilosin'){
		echo '<td>'.CHtml::activeTextField($det, '['.$ii.']p5_oksitosin_unit',array('onkeyup'=>'setNumbersOnly(this);','class' => 'span1 oksilosin numbers-only', 'valueid'=>8)).'</td>';
	}elseif($data == 'tetes'){
		echo '<td>'.CHtml::activeTextField($det, '['.$ii.']p5_tetes_menit',array('onkeyup'=>'setNumbersOnly(this);','class' => 'span1 tetesmenit numbers-only', 'valueid'=>9)).'</td>';
	}elseif($data == 'tekanandarah'){
		echo '<td>'.
				CHtml::activeTextField($det, '['.$ii.']p6_systolic',array('onkeyup'=>'setNumbersOnly(this);','class' => 'span1 systolic numbers-only  manyinput', 'valueid'=>3, 'onblur'=>'generateGrafik();')).' Mm'.
				CHtml::activeTextField($det, '['.$ii.']p6_diastolic',array('onkeyup'=>'setNumbersOnly(this);','class' => 'span1 diastolic numbers-only manyinput', 'valueid'=>3, 'onblur'=>'generateGrafik();')).' Hg'.
				CHtml::activeHiddenField($det, '['.$ii.']p6_tekanandarah',array('class' => 'span1 p6tekanandarah  manyinput', 'valueid'=>3)).
			 '</td>';
	}elseif($data == 'obat'){	
		if (!isset($showdata)){
			echo "<td>";
		}
		
		//CHtml::activeHiddenField($det, '['.$ii.']p6_tekanandarah',array('class' => 'span1 p6tekanandarah  manyinput', 'valueid'=>2)).
			
		$this->widget('MyJuiAutoComplete', array(
			'model'=>$det,
			'attribute' => '['.$ii.']obatalkes_nama[obat]',
			'source' => 'js: function(request, response) {
							   $.ajax({
								   url: "' . $this->createUrl('/ActionAutoComplete/ObatAlkesPartograf') . '",
								   dataType: "json",
								   data: {
									   term: request.term,
								   },
								   success: function (data) {
										   response(data);
								   }
							   })
							}',
			'options' => array(
				'showAnim' => 'fold',
				'minLength' => 3,
				'focus' => 'js:function( event, ui ) {
					$(this).val(ui.item.label);
					return false;
				}',
				'select' => 'js:function( event, ui ) {
					setObat($(this), ui.item);
					return false;
				}',
			),
			'tombolDialog'=>array("idDialog"=>'dialogObatPersalinan','jsFunction'=>"setDialog(this);"),
			'htmlOptions'=>array('class'=>'span2 required manyinput','onkeypress'=>"return $(this).focusNextInputField(event)"),
		));		
		if (!isset($showdata)){
			echo "</td>";
		}
	}elseif($data == 'nadi'){
		echo '<td>'.CHtml::activeTextField($det, '['.$ii.']p6_nadi',array('onkeyup'=>'setNumbersOnly(this);','class' => 'span1 p6nadi numbers-only', 'valueid'=>9, 'onblur'=>'generateGrafik();')).'/Menit</td>';
	}elseif($data == 'penyulit'){		
		echo '<td>'.CHtml::activeDropDownList($det, '['.$ii.']p6_penyulit',array('ada'=>'Ya','tidak'=>'Tidak'),array('class' => 'span2 p6penyulit', 'valueid'=>9, 'onchange'=>'generateGrafik();')).'</td>';
	}elseif($data == 'suhu'){
		if (!empty($det->p7_suhu)){
			//$det->p7_suhu = number_format($det->p7_suhu,2,",","");
		}
		echo '<td>'.CHtml::activeTextField($det, '['.$ii.']p7_suhu',array('onkeyup'=>'setAngkaComaOnly(this);', 'class' => 'span1 suhu', 'valueid'=>9, 'onblur'=>'generateGrafik();')).'</td>';
	}elseif($data == 'urinprotein'){
		echo '<td>'.CHtml::activeDropDownList($det, '['.$ii.']p8_urin_protein', LookupM::getItems('partograf_urinprotein'), array('empty' => '-- Pilih --','class' => 'span2 urinprotein', 'valueid'=>7)).'</td>';
	}elseif($data == 'urinasolon'){
		echo '<td>'.CHtml::activeDropDownList($det, '['.$ii.']p8_urin_aseton', LookupM::getItems('partograf_urinasolon'), array('empty' => '-- Pilih --','class' => 'span2 urinasolon', 'valueid'=>7)).'</td>';
	}elseif($data == 'urinvolume'){
		echo '<td>'.CHtml::activeTextField($det, '['.$ii.']p8_urin_volume',array('onkeyup'=>'setNumbersOnly(this);','class' => 'span1 urinvolume float2', 'valueid'=>9)).'cc</td>';
        }elseif($data == 'catatwaktu'){
            echo "<td>";
            $this->widget('MyDateTimePicker', array(
                    'model' => $det,
                    'attribute' => '['.$ii.']waktucatat',
                    'mode' => 'time',
                    'options' => array(
                            'dateFormat' => Params::DATE_FORMATV3,
                            //'maxDate' => 'd',                            
                            'onSelect' => 'js:function(){generateGrafik();}'
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2 waktucatat', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:70px;'
                    ),
            ));	
            echo "</td>";
        }
?>