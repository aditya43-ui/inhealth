<?php if(isset($_GET['ubah']) && !isset($tambahDetail)){
?>
<tr>
    <td hidden> <?php echo CHtml::activeCheckBox($modDetail,'[i]checkList',array('class'=>'cekList','onclick'=>'hitungSemua();','checked'=>true)); ?>                             
        <?php echo CHtml::activeHiddenField($modDetail,'[i]golbahanmakanan_id',array('class'=>'golbahanmakanan_id')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[i]bahanmakanan_id',array('class'=>'bahanmakanan_id')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[i]jmlkemasan',array('class'=>'jmldlmkemasan')); ?>
        <?php // echo CHtml::activeHiddenField($modDetail,'[i]ukuranbahan',array('value'=>$model->ukuran, 'class'=>'ukuranbahan')); ?>
       <?php // echo CHtml::activeHiddenField($modDetail,'[i]merkbahan',array('value'=>$merk, 'class'=>'merkbahan')); ?>
    </td>
    <td> <?php echo CHtml::TextField('noUrut','',array('class'=>'span1 noUrut','readonly'=>TRUE, 'style'=>'width:20px;')); ?></td>
    <!--<td><?php // echo $modDetail->golbahanmakanan->golbahanmakanan_nama; ?></td>-->
    <!--<td><?php // echo $modDetail->bahanmakanan->jenisbahanmakanan; ?></td>-->
    <td><?php echo $modDetail->bahanmakanan->kelbahanmakanan; ?></td>
    <td><?php echo $modDetail->bahanmakanan->namabahanmakanan; ?></td>
    <td><?php echo $modDetail->bahanmakanan->ket_spesifikasibahanmakanan; ?></td>
    <td><?php echo MyFormatter::formatDateTimeForUser($modDetail->bahanmakanan->tglkadaluarsabahan); ?></td>
    <td><?php echo CHtml::activetextField($modDetail,'[i]qty_pengajuan',array('class'=>'span1 integer-decimal qty','onblur'=>'hitungTotal();', 'style'=>'text-align: right;', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
    <td style='text-align: right;'><?php echo (empty($modDetail->bahanmakanan->jmlpersediaan)?0:MyFormatter::formatNumberForPrint($modDetail->bahanmakanan->jmlpersediaan)); ?></td>
    <td><?php echo CHtml::activeDropDownList($modDetail,'[i]satuanbahan', LookupM::getItems('satuanbahanmakanan'), array('class'=>'satuanbahan span2')); ?></td>
    <td style='text-align: right;'><?php echo (Params::cekHiddenHargaGizi()==true) ? CHtml::activeTextField($modDetail,'[i]harganettobhn',array('class'=>'harganettobhn integer-decimal', 'style'=>'width:100px', 'onblur'=>'hitungTotal();')) : CHtml::activePasswordField($modDetail,'[i]harganettobhn',array('class'=>'harganettobhn integer-decimal', 'style'=>'width:100px', 'onblur'=>'hitungTotal();')); ?></td>
    <td style='text-align: right;'><?php echo CHtml::activeTextField($modDetail,'[i]persendiscount',array('class'=>'persendiscount integer-decimal number span1', 'onblur'=>'hitungTotal();', 'style'=>'text-align: right;', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
    <td style='text-align: right;'><?php echo (Params::cekHiddenHargaGizi()==true) ? CHtml::activeTextField($modDetail,'[i]jmldiscount',array('class'=>'jmldiscount integer-decimal', 'style'=>'width:100px; text-align: right;', 'readonly'=>true)) : CHtml::activePasswordField($modDetail,'[i]jmldiscount',array('class'=>'jmldiscount integer-decimal', 'style'=>'width:100px; text-align: right;', 'readonly'=>true)); ?></td>
    <td style='text-align: right;'><?php echo CHtml::activeTextField($modDetail,'[i]persenppn',array('class'=>'persenppn integer2 span1', 'onblur'=>'hitungTotal();', 'style'=>'text-align: right;', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
    <td style='text-align: right;'><?php echo (Params::cekHiddenHargaGizi()==true) ? CHtml::activeTextField($modDetail,'[i]jmlppn',array('class'=>'jmlppn integer-decimal', 'style'=>'width:100px; text-align: right;', 'readonly'=>true)) : CHtml::activePasswordField($modDetail,'[i]jmlppn',array('class'=>'jmlppn integer-decimal', 'style'=>'width:100px; text-align: right;', 'readonly'=>true)); ?></td>
    <td style='text-align: right;'><?php echo CHtml::activeTextField($modDetail,'[i]persenpph',array('class'=>'persenpph integer-decimal span1', 'onblur'=>'hitungTotal();', 'style'=>'text-align: right;', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
    <td style='text-align: right;'><?php echo (Params::cekHiddenHargaGizi()==true) ? CHtml::activeTextField($modDetail,'[i]jmlpph',array('class'=>'jmlpph integer-decimal', 'style'=>'width:100px; text-align: right;', 'readonly'=>true)) : CHtml::activePasswordField($modDetail,'[i]jmlpph',array('class'=>'jmlpph integer-decimal', 'style'=>'width:100px; text-align: right;', 'readonly'=>true)); ?></td>
    <!--<td style='text-align: right;'><?php // echo MyFormatter::formatNumberForPrint($modDetail->bahanmakanan->hargajualbahan); ?></td>-->
    <td><?php echo (Params::cekHiddenHargaGizi()==true) ? CHtml::activeTextField($modDetail,'[i]subNetto',array('class'=>'span2 integer-decimal subNetto','readonly'=>true, 'style'=>'width:100px; text-align: right;')) : CHtml::activePasswordField($modDetail,'[i]subNetto',array('class'=>'span2 integer-decimal subNetto','readonly'=>true, 'style'=>'width:100px; text-align: right;')); ?></td>
    <td><?php echo CHtml::link("<span class='icon-form-silang'>&nbsp;</span>",'',array('href'=>'','onclick'=>'hapus(this);return false;','style'=>'text-decoration:none;', 'class'=>'cancel')); ?></td>
</tr>
<?php }else{ ?>
<tr>
    <td hidden> <?php echo CHtml::activeCheckBox($modDetail,'[i]checkList',array('class'=>'cekList','onclick'=>'hitungSemua();','checked'=>true)); ?>                             
        <?php echo CHtml::activeHiddenField($modDetail,'[i]golbahanmakanan_id',array('value'=>$model->golbahanmakanan_id, 'class'=>'golbahanmakanan_id')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[i]bahanmakanan_id',array('value'=>$model->bahanmakanan_id, 'class'=>'bahanmakanan_id')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[i]jmlkemasan',array('value'=>$model->jmldlmkemasan, 'class'=>'jmldlmkemasan')); ?>
        <?php // echo CHtml::activeHiddenField($modDetail,'[i]ukuranbahan',array('value'=>$model->ukuran, 'class'=>'ukuranbahan')); ?>
       <?php // echo CHtml::activeHiddenField($modDetail,'[i]merkbahan',array('value'=>$merk, 'class'=>'merkbahan')); ?>
    </td>
    <td> <?php echo CHtml::TextField('noUrut','',array('class'=>'span1 noUrut','readonly'=>TRUE, 'style'=>'width:20px;')); ?></td>
    <!--<td><?php // echo $model->golbahanmakanan->golbahanmakanan_nama; ?></td>-->
    <!--<td><?php // echo $model->jenisbahanmakanan; ?></td>-->
    <td><?php echo $model->kelbahanmakanan; ?></td>
    <td><?php echo $model->namabahanmakanan; ?></td>
     <td><?php echo $model->ket_spesifikasibahanmakanan; ?></td>
     <td><?php echo MyFormatter::formatDateTimeForUser($model->tglkadaluarsabahan); ?></td>
     <td><?php echo CHtml::activetextField($modDetail,'[i]qty_pengajuan',array('value'=>number_format($qty,2,",","."),'class'=>'span1 integer-decimal qty number','onblur'=>'hitungTotal();', 'style'=>'text-align: right;', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
    <td style='text-align: right;'><?php echo (empty($model->jmlpersediaan)?0:MyFormatter::formatNumberForPrint($model->jmlpersediaan)); ?></td>
    <td><?php echo CHtml::activeDropDownList($modDetail,'[i]satuanbahan', LookupM::getItems('satuanbahanmakanan'), array('class'=>'satuanbahan span2')); ?></td>
    <td style='text-align: right;'><?php echo (Params::cekHiddenHargaGizi()==true) ? CHtml::activeTextField($modDetail,'[i]harganettobhn',array('value'=>number_format($model->harganettobahan,0,"","."), 'class'=>'harganettobhn integer-decimal', 'style'=>'width:100px; text-align: right;', 'onblur'=>'hitungTotal();')) : CHtml::activePasswordField($modDetail,'[i]harganettobhn',array('value'=>number_format($model->harganettobahan,0,"","."), 'class'=>'harganettobhn integer-decimal', 'style'=>'width:100px; text-align: right;', 'onblur'=>'hitungTotal();')); ?></td>
    <td style='text-align: right;'><?php echo CHtml::activeTextField($modDetail,'[i]persendiscount',array('class'=>'persendiscount integer-decimal span1', 'onblur'=>'hitungTotal();', 'style'=>'text-align: right;', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
    <td style='text-align: right;'><?php echo (Params::cekHiddenHargaGizi()==true) ? CHtml::activeTextField($modDetail,'[i]jmldiscount',array('class'=>'jmldiscount integer-decimal', 'style'=>'width:100px; text-align: right;', 'readonly'=>true)) : CHtml::activePasswordField($modDetail,'[i]jmldiscount',array('class'=>'jmldiscount integer-decimal', 'style'=>'width:100px; text-align: right;', 'readonly'=>true)); ?></td>
    <td style='text-align: right;'><?php echo CHtml::activeTextField($modDetail,'[i]persenppn',array('class'=>'persenppn integer2 span1', 'onblur'=>'hitungTotal();', 'style'=>'text-align: right;', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
    <td style='text-align: right;'><?php echo (Params::cekHiddenHargaGizi()==true) ? CHtml::activeTextField($modDetail,'[i]jmlppn',array('class'=>'jmlppn integer-decimal', 'style'=>'width:100px; text-align: right;', 'readonly'=>true)) : CHtml::activePasswordField($modDetail,'[i]jmlppn',array('class'=>'jmlppn integer-decimal', 'style'=>'width:100px; text-align: right;', 'readonly'=>true)); ?></td>
    <td style='text-align: right;'><?php echo CHtml::activeTextField($modDetail,'[i]persenpph',array('class'=>'persenpph integer-decimal span1', 'onblur'=>'hitungTotal();', 'style'=>'text-align: right;', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
    <td style='text-align: right;'><?php echo (Params::cekHiddenHargaGizi()==true) ? CHtml::activeTextField($modDetail,'[i]jmlpph',array('class'=>'jmlpph integer-decimal', 'style'=>'width:100px; text-align: right;', 'readonly'=>true)) : CHtml::activePasswordField($modDetail,'[i]jmlpph',array('class'=>'jmlpph integer-decimal', 'style'=>'width:100px; text-align: right;', 'readonly'=>true)); ?></td>
    <!--<td style='text-align: right;'><?php // echo MyFormatter::formatNumberForPrint($model->hargajualbahan); ?></td>-->
    <td><?php echo (Params::cekHiddenHargaGizi()==true) ? CHtml::activeTextField($modDetail,'[i]subNetto',array('value'=>$subNetto,'class'=>'span2 integer-decimal subNetto','readonly'=>true, 'style'=>'width:100px; text-align: right;',)): CHtml::activePasswordField($modDetail,'[i]subNetto',array('value'=>$subNetto,'class'=>'span2 integer-decimal subNetto','readonly'=>true, 'style'=>'width:100px; text-align: right;',)); ?></td>
    <td><?php echo CHtml::link("<span class='icon-form-silang'>&nbsp;</span>",'',array('href'=>'','onclick'=>'hapus(this);return false;','style'=>'text-decoration:none;', 'class'=>'cancel')); ?></td>
</tr>
<?php } ?>
