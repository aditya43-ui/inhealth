<div id="content-karcis-html">
<?php 
//	RND-6338 Code ini sudah ada di controller fungsi SetKarcis dari function setKarcis() (_jsFunction)
//	Jika tidak di comment muncul error "Attempt to assign property of non-object"  
//	if(count((array)$dataTindakans) > 0){ 
//        $format = new MyFormatter();
//        echo "<table>";
//        echo "<thead>";
//        echo "<th>Karcis</th>";
//        echo "<th>Harga</th>";
//        echo "<th>Pilih</th>";
//        echo "</thead>";
//        foreach($dataTindakans AS $i =>$data){
//            if ($i == 0){
//			$data->is_pilihtindakan = 1;
//            $data->tarif_satuan = $format->formatNumberForUser($data->tarif_satuan);
//            echo '<tr class="checked">
//                    <td>'.CHtml::label($data->daftartindakan->daftartindakan_nama,$data->daftartindakan->daftartindakan_nama).'</td>
//                    <td style="text-align:right;">'.CHtml::activeTextField($data, '['.$i.']tarif_satuan',array('readonly'=>true, 'class'=>'span1 integer', 'style'=>'width:96px;text-align:right;')).'</td>
//                    <td><a data-karcis="'.$data['karcis_id'].'"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="pilihKarcis(this);return false;">
//                        <i class="icon-form-check"></i>
//                        </a>'
//                    .CHtml::activeHiddenField($data, '['.$i.']is_pilihtindakan',array('readonly'=>true, 'class'=>'span1'))  
//                    .CHtml::activeHiddenField($data, '['.$i.']daftartindakan_id',array('readonly'=>true, 'class'=>'span1'))  
//                    .CHtml::activeHiddenField($data, '['.$i.']karcis_id',array('readonly'=>true, 'class'=>'span1'))  
//                .'</td>'
//                .'</tr>';
//            }
//        }
//        echo "</table>";
//} 
?>
</div>
<!--<div class="control-group"> //fitur belum ada >> RND-666
    <div class="controls">
    <?php echo $form->checkBox($model,'is_bayarkarcis',array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo CHtml::label('Karcis Dibayar Langsung', 'is_bayarkarcis') ?>
    </div>
</div>-->

