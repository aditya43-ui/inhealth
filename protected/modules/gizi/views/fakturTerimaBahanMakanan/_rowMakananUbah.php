<?php

/* 
 * Jika stok gizi di centang pada konfig sistem maka jumlah pada
 * data stok ditampilkan. Jika tidak maka hanya menampilkan data
 * jmlpersediaan pada master
 */
$stokgizi = Yii::app()->user->getState('krngistokgizi');

$model = BahanmakananM::model()->findByPk($modDetail->bahanmakanan_id);
$modDetail->harganettobahan = $modDetail->harganettobhn;
$modDetail->subNetto = $modDetail->harganettobhn * $modDetail->qty_terima;
$modDetail->tglkadaluarsabahan = MyFormatter::formatDateTimeForUser($modDetail->tglkadaluarsabahan);
$modDetail->namabahanmaster = $model->namabahanmakanan;
$modDetail->harganettomaster = $model->harganettobahan;
$modDetail->qty_terima = number_format($modDetail->qty_terima,2,",",".");

echo '<tr>
                    <td>'
                        .CHtml::activeHiddenField($modDetail, '['.$key.']golbahanmakanan_id')
                        .CHtml::activeHiddenField($modDetail, '['.$key.']bahanmakanan_id')
                        .CHtml::activeHiddenField($modDetail, '['.$key.']harganettobhn', array('class'=>'integer2'))
                        .CHtml::activeHiddenField($modDetail, '['.$key.']jmlkemasan', array('class'=>'integer2'))            
                        .CHtml::activeHiddenField($modDetail, '['.$key.']hargajualbhn', array('class'=>'integer2'))
                        .CHtml::activeHiddenField($modDetail, '['.$key.']terimabahandetail_id')
                        .CHtml::activeHiddenField($modDetail, '['.$key.']satuanbahan')
                    .CHtml::textField('noUrut',$no++,array('id'=>'noUrut','class'=>'noUrut span1', 'readonly'=>true))
                        .CHtml::activeHiddenField($modDetail, '['.$key.']hppcheck')
        .CHtml::activeHiddenField($modDetail, '['.$key.']harganettomaster', array('class'=>'integer2'))
        .CHtml::activeHiddenField($modDetail, '['.$key.']namabahanmaster', array('class'=>'')).'</td>

                    <td>'.$model->kelbahanmakanan.'</td>
                    <td>'.$model->namabahanmakanan.'</td>
                    <td style="text-align: right;">'.$model->jmlpersediaan." ".$model->satuanbahan.'</td>'.
        '<td>'.CHtml::activeTextField($modDetail, '['.$key.']qty_terima', array('class'=>'span1 integer-decimal qty', 'onblur'=>'hitungSemua();', 'readonly'=>true))." ".$model->satuanbahan.'</td>'.
        '<td>'.'<div class="input-append">'.
            CHtml::activeTextField($modDetail, '['.$key.']tglkadaluarsabahan', array('readonly'=>true,'class'=>'tanggal span2', 'style'=>'float:left;')).
            '<span class="add-on tgl_tombol" onclick="$(this).parent().find(\'.tanggal\').datepicker(\'show\')"><i class="entypo-calendar"></i></span>'.
            '</div>'.'</td>'.
					'<td>'.CHtml::activeTextField($modDetail, '['.$key.']harganettobahan', array('class'=>'span2 integer-decimal harganettobahan text-right', 'onblur'=>'hitungSemua();','readonly'=>true))
					.CHtml::activeHiddenField($modDetail, '['.$key.']hargajualbahan', array('class'=>'span2 integer-decimal hargajualbahan', 'readonly'=>true)).'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '['.$key.']persendiscount', array('class'=>'span1 integer-decimal persendiscount','readonly'=>true, 'onblur'=>'hitungSemua();')).'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '['.$key.']jmldiscount', array('class'=>'span2 integer-decimal jmldiscount  text-right','readonly'=>true)).'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '['.$key.']persenppn', array('class'=>'span1 integer2 persenppn','readonly'=>true, 'onblur'=>'hitungSemua();')).'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '['.$key.']jmlhargappn', array('class'=>'span2 integer-decimal jmlhargappn  text-right','readonly'=>true)).'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '['.$key.']persenpph', array('class'=>'span1 integer-decimal persenpph','readonly'=>true, 'onblur'=>'hitungSemua();')).'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '['.$key.']jmlhargapph', array('class'=>'span2 integer-decimal jmlhargapph  text-right','readonly'=>true)).'</td>'.
					
					
                    
                    '<td>'.CHtml::activeTextField($modDetail, '[0]subNetto', array('class'=>'span2 integer-decimal subNetto  text-right','readonly'=>true)).'</td>
                    </tr>';

