<div class="col-sm-6">
    <?php 
        echo $form->textFieldRow($model,'nilai_kontrak',array('readonly' => true, 'class' => 'span3 integer-decimal'));
        echo $form->dropDownListRow($model,'indeks_dikeluarkan', LookupM::getItemsUrutan('indeksdikeluarkan'),array('empty'=>'-- Pilih --', 'class' => 'span3'));        
        echo $form->dropDownListRow($model,'indeks_digunakan', LookupM::getItemsUrutan('indeksdipergunakan'),array('empty'=>'-- Pilih --', 'class' => 'span3'));
    ?>
</div>

<div class="col-sm-6">   
    <?php         
        echo $form->textFieldRow($model,'jumlah_indeks',array('readonly' => false, 'class' => 'span3 integer2'));
        echo $form->textFieldRow($model,'koefisien_tetap',array('readonly' => false, 'class' => 'span3 integer2'));
        echo $form->textFieldRow($model,'koefisien_kontrak',array('readonly' => false, 'class' => 'span3 integer2'));
    ?>
</div>