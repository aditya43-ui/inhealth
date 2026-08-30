<?php

$det = AldrettepasienruangpulihT::model()->findByAttributes(array(
    'pasienruangpulih_id'=>$model->pasienruangpulih_id,
    'jenisaldrette'=>'Masuk Ruang Pulih'
));

if (empty($det)) {
    $det = new AldrettepasienruangpulihT;
    $det->jenisaldrette = "Masuk Ruang Pulih";
}

echo $form->hiddenField($det, 'jenisaldrette');

?>

<table class="table table-bordered table-condensed" id="tab_skor">
    <thead>
        <tr>
            <th>Parameter</th>
            <th>Penilaian</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $det->getAttributeLabel('aktivitas_penilaian'); ?></td>
            <td><?php 
            
            $list = LookupM::getItemsUrutanExtra('aldrette_aktivitas', 'lookup_name', array(
                'data-nilai'=>'lookup_value'
            ));
            
            
            
            echo $form->dropDownList($det, 'aktivitas_penilaian', $list['data'], array(
                'class'=>'span3 penilaian', 'options'=>$list['option']
            )); ?></td>
            <td><?php echo $form->textField($det, 'aktivitas_skor', array('class'=>'span1 skor', 'readonly'=>true, 'style'=>'text-align: right;')); ?></td>
        </tr>
        <tr>
            <td><?php echo $det->getAttributeLabel('sirkulasi_penilaian'); ?></td>
            <td><?php 
            
            $list = LookupM::getItemsUrutanExtra('aldrette_sirkulasi', 'lookup_name', array(
                'data-nilai'=>'lookup_value'
            ));
            
            
            
            echo $form->dropDownList($det, 'sirkulasi_penilaian', $list['data'], array(
                'class'=>'span3 penilaian', 'options'=>$list['option']
            )); ?></td>
            <td><?php echo $form->textField($det, 'sirkulasi_skor', array('class'=>'span1 skor', 'readonly'=>true, 'style'=>'text-align: right;')); ?></td>
        </tr>
        <tr>
            <td><?php echo $det->getAttributeLabel('pernapasan_penilaian'); ?></td>
            <td><?php 
            
            $list = LookupM::getItemsUrutanExtra('aldrette_pernapasan', 'lookup_name', array(
                'data-nilai'=>'lookup_value'
            ));
            
            
            
            echo $form->dropDownList($det, 'pernapasan_penilaian', $list['data'], array(
                'class'=>'span3 penilaian', 'options'=>$list['option']
            )); ?></td>
            <td><?php echo $form->textField($det, 'pernapasan_skor', array('class'=>'span1 skor', 'readonly'=>true, 'style'=>'text-align: right;')); ?></td>
        </tr>
        <tr>
            <td><?php echo $det->getAttributeLabel('kesadaran_penilaian'); ?></td>
            <td><?php 
            
            $list = LookupM::getItemsUrutanExtra('aldrette_kesadaran', 'lookup_name', array(
                'data-nilai'=>'lookup_value'
            ));
            
            
            
            echo $form->dropDownList($det, 'kesadaran_penilaian', $list['data'], array(
                'class'=>'span3 penilaian', 'options'=>$list['option']
            )); ?></td>
            <td><?php echo $form->textField($det, 'kesadaran_skor', array('class'=>'span1 skor', 'readonly'=>true, 'style'=>'text-align: right;')); ?></td>
        </tr>
        <tr>
            <td><?php echo $det->getAttributeLabel('warnakulit_penilaian'); ?></td>
            <td><?php 
            
            $list = LookupM::getItemsUrutanExtra('aldrette_warnakulit', 'lookup_name', array(
                'data-nilai'=>'lookup_value'
            ));
            
            
            
            echo $form->dropDownList($det, 'warnakulit_penilaian', $list['data'], array(
                'class'=>'span3 penilaian', 'options'=>$list['option']
            )); ?></td>
            <td><?php echo $form->textField($det, 'warnakulit_skor', array('class'=>'span1 skor', 'readonly'=>true, 'style'=>'text-align: right;')); ?></td>
        </tr>
        <tr>
            <td colspan="2">Total Skor</td>
            <td><?php echo $form->textField($model, 'totalskor_aldrettemasukrpulih', array('class'=>'span1 total_skor', 'readonly'=>true, 'style'=>'text-align: right;')); ?></td>
   
        </tr>
    </tbody>
</table>

<script>
    
    function setSkor() {
        var total = 0;
        
        $("#tab_skor .penilaian").each(function() {
            var n = $(this).find(":selected").data('nilai');
            
            if (n == null || n == '') {
                n = 0;
            }
            
            $(this).parents("tr").find(".skor").val(n);
            
            total += parseFloat(n);
        });
        
        $("#tab_skor .total_skor").val(total);
    }
    
    $(document).ready(function() {
        $("#tab_skor .penilaian").on("change", setSkor);
        setSkor();
        
    });
    
</script>