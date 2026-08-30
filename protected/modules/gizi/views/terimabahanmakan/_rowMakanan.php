<?php

/* 
 * Jika stok gizi di centang pada konfig sistem maka jumlah pada
 * data stok ditampilkan. Jika tidak maka hanya menampilkan data
 * jmlpersediaan pada master
 */
$stokgizi = Yii::app()->user->getState('krngistokgizi');

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


echo '<tr>
                    <td hidden>'
                        .CHtml::checkBox('checkList[]',true,array('class'=>'cekList','onclick'=>'hitungSemua()'))
                        .CHtml::activeHiddenField($modDetail, '[0]golbahanmakanan_id', array('value'=>$model->golbahanmakanan_id))
                        .CHtml::activeHiddenField($modDetail, '[0]bahanmakanan_id', array('value'=>$model->bahanmakanan_id))
                        .CHtml::activeHiddenField($modDetail, '[0]harganettobhn', array('value'=>$model->harganettobahan,'class'=>'integer2'))
                        .CHtml::activeHiddenField($modDetail, '[0]jmlkemasan', array('value'=>$model->jmldlmkemasan,'class'=>'integer2'))            
                        .CHtml::activeHiddenField($modDetail, '[0]hargajualbhn', array('value'=>$model->hargajualbahan,'class'=>'integer2'))
                        //.CHtml::activeHiddenField($modDetail, '[0]ukuran_bahanterima', array('value'=>$ukuran))
                        //.CHtml::activeHiddenField($modDetail, '[0]merk_bahanterima', array('value'=>$merk))
						.CHtml::activeHiddenField($modDetail, '[0]satuanbahan', array('value'=>$model->satuanbahan))
                    .'</td>
                    <td>'.CHtml::textField('noUrut',0,array('id'=>'noUrut','class'=>'noUrut span1', 'readonly'=>true)).'</td>
                    <td hidden>'.$model->golbahanmakanan->golbahanmakanan_nama.'</span></td>
                    <td hidden>'.$model->jenisbahanmakanan.'</td>
                    <td>'.$model->kelbahanmakanan.'</td>
                    <td>'.$model->namabahanmakanan.'</td>
                    <td style="text-align: right;">'.$model->jmlpersediaan." ".$model->satuanbahan.'</td>'.
                    //'<td>'.CHtml::activeDropDownList($modDetail, '[0]satuanbahan', LookupM::getItems('satuanbahanmakanan'), array( 'class'=>'span2 satuanbahan')).'</td>'.
					'<td>'. ((Params::cekHiddenHargaGizi()==true) ? CHtml::activeTextField($modDetail, '[0]harganettobahan', array('value'=>$model->harganettobahan, 'class'=>'span2 integer2 harganettobahan', 'onblur'=>'hitungSemua()','readonly'=>false)) : CHtml::activePasswordField($modDetail, '[0]harganettobahan', array('value'=>$model->harganettobahan, 'class'=>'span2 integer2 harganettobahan', 'onblur'=>'hitungSemua()','readonly'=>false)))
					.CHtml::activeHiddenField($modDetail, '[0]hargajualbahan', array('value'=>$model->hargajualbahan, 'class'=>'span2 integer2 hargajualbahan', 'readonly'=>true)).'</td>
                                            <td>'.CHtml::activeTextField($modDetail, '[0]qty_terima', array('value'=>$qty, 'class'=>'span1 float2 qty', 'onblur'=>'hitungSemua()'))." ".$model->satuanbahan.'</td>
                    <td hidden>'.CHtml::activeTextField($modDetail, '[0]discount', array('value'=>$model->discount, 'class'=>'discount integer2', 'onblur'=>'hitungTotalDiscount();', 'style'=>'width:70px;')).'</td>'.
                    // <td><span name="[0][tglkadaluarsabahan]">'.MyFormatter::formatDateTimeForUser($model->tglkadaluarsabahan).'</span></td>
                    '<td>'.
					//$this->renderPartial('_waktu', array('modDetail'=>$modDetail), true, true).
					'<div class="input-append">'.
					CHtml::activeTextField($modDetail, '[0]tglkadaluarsabahan', array('readonly'=>false,'value'=>MyFormatter::formatDateTimeForUser($model->tglkadaluarsabahan),'class'=>'tanggal dtPicker2', 'style'=>'float:left;')).
					'<span class="add-on tgl_tombol" onclick="$(this).parent().find(\'.tanggal\').datepicker(\'show\')"><i class="entypo-calendar"></i></span>'.
					'</div>'.
					'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '[0]persendiscount', array('value'=>0, 'class'=>'span2 float2 persendiscount','readonly'=>true, 'onblur'=>'hitungSemua()')).'</td>'.
                    '<td>'. ((Params::cekHiddenHargaGizi()==true) ? CHtml::activeTextField($modDetail, '[0]jmldiscount', array('value'=>0, 'class'=>'span2 integer2 jmldiscount','readonly'=>true)) : CHtml::activePasswordField($modDetail, '[0]jmldiscount', array('value'=>0, 'class'=>'span2 integer2 jmldiscount','readonly'=>true))) .'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '[0]persenppn', array('class'=>'span2 integer2 persenppn','readonly'=>true, 'onblur'=>'hitungSemua()')).'</td>'.
                    '<td>'. ((Params::cekHiddenHargaGizi()==true) ? CHtml::activeTextField($modDetail, '[0]jmlhargappn', array('value'=>0, 'class'=>'span2 integer2 jmlhargappn','readonly'=>true)) : CHtml::activePasswordField($modDetail, '[0]jmlhargappn', array('value'=>0, 'class'=>'span2 integer2 jmlhargappn','readonly'=>true))).'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '[0]persenpph', array('value'=>0, 'class'=>'span2 float2 persenpph','readonly'=>true, 'onblur'=>'hitungSemua()')).'</td>'.
                    '<td>'. ((Params::cekHiddenHargaGizi()==true) ? CHtml::activeTextField($modDetail, '[0]jmlhargapph', array('value'=>0, 'class'=>'span2 integer2 jmlhargapph','readonly'=>true)) : CHtml::activePasswordField($modDetail, '[0]jmlhargapph', array('value'=>0, 'class'=>'span2 integer2 jmlhargapph','readonly'=>true))) .'</td>'.
                    '<td>'. ((Params::cekHiddenHargaGizi()==true) ? CHtml::activeTextField($modDetail, '[0]subNetto', array('value'=>$subNetto, 'class'=>'span2 integer2 subNetto','readonly'=>true)) : CHtml::activePasswordField($modDetail, '[0]subNetto', array('value'=>$subNetto, 'class'=>'span2 integer2 subNetto','readonly'=>true))).'</td>
                    <td>'.CHtml::link("<span class='icon-form-silang'>&nbsp;</span>",'',array('href'=>'','onclick'=>'hapus(this);return false;','style'=>'text-decoration:none;', 'class'=>'cancel')).'</td>
                    </tr>';

