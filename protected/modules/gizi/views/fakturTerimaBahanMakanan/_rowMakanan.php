<?php

/* 
 * Jika stok gizi di centang pada konfig sistem maka jumlah pada
 * data stok ditampilkan. Jika tidak maka hanya menampilkan data
 * jmlpersediaan pada master
 */
$stokgizi = Yii::app()->user->getState('krngistokgizi');
/*
if ($stokgizi) {
	$stok = StokbahanmakananT::model()->findAllByAttributes(array(
		'bahanmakanan_id'=>$model->bahanmakanan_id,
	));
	$tot = 0;
	foreach ($stok as $item) {
		$tot += $item->qty_current;
	}
	$model->jmlpersediaan = $tot;
}
 * 
 */

$model = BahanmakananM::model()->findByPk($modDetail->bahanmakanan_id);
$modDetail->harganettobahan = $modDetail->harganettobhn;
$modDetail->subNetto = $modDetail->harganettobhn * $modDetail->qty_terima;
$modDetail->tglkadaluarsabahan = MyFormatter::formatDateTimeForUser($modDetail->tglkadaluarsabahan);
$modDetail->namabahanmaster = $model->namabahanmakanan;
$modDetail->harganettomaster = $model->harganettobahan;
$modDetail->qty_terima = number_format($modDetail->qty_terima,2,",",".");
echo '<tr>
                    <td hidden>'
                        .CHtml::checkBox('checkList[]',true,array('class'=>'cekList','onclick'=>'hitungSemua()'))
                        .CHtml::activeHiddenField($modDetail, '[0]golbahanmakanan_id')
                        .CHtml::activeHiddenField($modDetail, '[0]bahanmakanan_id')
                        .CHtml::activeHiddenField($modDetail, '[0]harganettobhn', array('class'=>'integer2'))
                        .CHtml::activeHiddenField($modDetail, '[0]jmlkemasan', array('class'=>'integer2'))            
                        .CHtml::activeHiddenField($modDetail, '[0]hargajualbhn', array('class'=>'integer-decimal hargajualbhn'))
                        .CHtml::activeHiddenField($modDetail, '[0]terimabahandetail_id')
                        //.CHtml::activeHiddenField($modDetail, '[0]ukuran_bahanterima', array('value'=>$ukuran))
                        //.CHtml::activeHiddenField($modDetail, '[0]merk_bahanterima', array('value'=>$merk))
						.CHtml::activeHiddenField($modDetail, '[0]satuanbahan')
                    .'</td>
                    <td>'.CHtml::textField('noUrut',0,array('id'=>'noUrut','class'=>'noUrut span1', 'readonly'=>true))
                        .CHtml::activeHiddenField($modDetail, '[0]hppcheck')
        .CHtml::activeHiddenField($modDetail, '[0]harganettomaster', array('class'=>'integer-decimal'))
        .CHtml::activeHiddenField($modDetail, '[0]namabahanmaster', array('class'=>'')).'</td>

                    <td>'.$model->kelbahanmakanan.'</td>
                    <td>'.$model->namabahanmakanan.'</td>
                    <td style="text-align: right;">'.$model->jmlpersediaan." ".$model->satuanbahan.'</td>'.
        '<td>'.CHtml::activeTextField($modDetail, '[0]qty_terima', array('class'=>'span1 integer-decimal qty', 'onblur'=>'hitungSemua();', 'readonly'=>true))." ".$model->satuanbahan.'</td>'.
        '<td>'.'<div class="input-append">'.
            CHtml::activeTextField($modDetail, '[0]tglkadaluarsabahan', array('readonly'=>true,'class'=>'tanggal span2', 'style'=>'float:left;')).
            '<span class="add-on tgl_tombol" onclick="$(this).parent().find(\'.tanggal\').datepicker(\'show\')"><i class="entypo-calendar"></i></span>'.
            '</div>'.'</td>'.
					'<td>'.CHtml::activeTextField($modDetail, '[0]harganettobahan', array('class'=>'span2 integer-decimal harganettobahan text-right', 'onblur'=>'hitungSemua();','readonly'=>true))
					.CHtml::activeHiddenField($modDetail, '[0]hargajualbahan', array('class'=>'span2 integer-decimal hargajualbahan', 'readonly'=>true)).'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '[0]persendiscount', array('class'=>'span1 integer-decimal persendiscount','readonly'=>true, 'onblur'=>'hitungSemua();')).'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '[0]jmldiscount', array('class'=>'span2 integer-decimal jmldiscount text-right','readonly'=>true)).'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '[0]persenppn', array('class'=>'span1 integer2 persenppn','readonly'=>true, 'onblur'=>'hitungSemua();')).'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '[0]jmlhargappn', array('class'=>'span2 integer-decimal jmlhargappn text-right','readonly'=>true)).'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '[0]persenpph', array('class'=>'span1 integer-decimal persenpph','readonly'=>true, 'onblur'=>'hitungSemua();')).'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '[0]jmlhargapph', array('class'=>'span2 integer-decimal jmlhargapph text-right','readonly'=>true)).'</td>'.
                    // <td><span name="[0][tglkadaluarsabahan]">'.MyFormatter::formatDateTimeForUser($model->tglkadaluarsabahan).'</span></td>
                    
					//$this->renderPartial('_waktu', array('modDetail'=>$modDetail), true, true).
					
					
                    
                    '<td>'.CHtml::activeTextField($modDetail, '[0]subNetto', array('class'=>'span2 integer-decimal subNetto text-right','readonly'=>true)).'</td>
                    <td hidden>'.CHtml::link("<span class='icon-form-silang'>&nbsp;</span>",'',array('href'=>'','onclick'=>'hapus(this);return false;','style'=>'text-decoration:none;', 'class'=>'cancel')).'</td>
                    </tr>';

