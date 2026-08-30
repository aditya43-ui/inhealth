<div class="col-sm-6">
    <?php 
        echo $form->dropDownListRow($model,'cara_pembayaran', LookupM::getItemsUrutan('kontrakcarapembayaran'),array('empty'=>'-- Pilih --', 'class' => 'span3'));
        echo $form->dropDownListRow($model,'pembebanan_tahunanggaran', LookupM::getItemsUrutan('kontraktahunanggaran'),array('empty'=>'-- Pilih --', 'class' => 'span3'));
    ?>
</div>

<div class="col-sm-6">   
    <?php         
        echo $form->dropDownListRow($model,'sumber_pendanaan', LookupM::getItemsUrutan('kontraksumberpendanaan'),array('empty'=>'-- Pilih --', 'class' => 'span3'));
        echo $form->dropDownListRow($model,'jenis_pekerjaan', LookupM::getItemsUrutan('kontrakjenispekerjaan'),array('empty'=>'-- Pilih --', 'class' => 'span3'));
    ?>
</div>
