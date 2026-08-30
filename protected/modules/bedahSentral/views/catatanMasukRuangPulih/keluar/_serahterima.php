<?php

$det = VerifikasikeluarRuangpulihT::model()->findByAttributes(array(
    'pasienruangpulih_id'=>$model->pasienruangpulih_id
));

if (empty($det)) {
    $det = new VerifikasikeluarRuangpulihT;
}

$det->isjaringan = $det->isjaringan == "Ada" ? "Ada" : "Tidak Ada";
$det->isformulir_pa = $det->isformulir_pa == "Ada" ? "Ada" : "Tidak Ada";
$det->islembar_ro = $det->islembar_ro == "Ada" ? "Ada" : "Tidak Ada";

?>

<div class="control-group">
    <?php echo $form->label($det, 'isjaringan', array('class'=>'control-label')); ?>
    <div class="controls st_panel">
        <?php 
        
        echo $form->radioButtonList($det, 'isjaringan', array('Tidak Ada'=>'Tidak Ada', 'Ada'=>'Ada'), array(
            'template'=>'<span class="radio-inline">{input}{label} </span>', 'class'=>'st_ceklis', 'uncheckValue'=>null
        )); ?>
        <?php echo $form->textField($det, 'jenisjaringan', array('class'=>'span3 st_input')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->label($det, 'isformulir_pa', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php 
        echo $form->radioButtonList($det, 'isformulir_pa', array('Tidak Ada'=>'Tidak Ada', 'Ada'=>'Ada'), array(
            'template'=>'<span class="radio-inline">{input}{label} </span>', 'uncheckValue'=>null
        )); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->label($det, 'islembar_ro', array('class'=>'control-label')); ?>
    <div class="controls st_panel">
        <?php echo $form->radioButtonList($det, 'islembar_ro', array('Tidak Ada'=>'Tidak Ada', 'Ada'=>'Ada'), array(
            'template'=>'<span class="radio-inline">{input}{label} </span>', 'class'=>'st_ceklis', 'uncheckValue'=>null
        )); ?>
        <label>, Jumlah</label>
        <?php echo $form->textField($det, 'islembar_ro_jumlah', array('class'=>'span2 st_input numbers-only')); ?>
        <label>Lembar</label>
    </div>
</div>
<?php echo $form->textAreaRow($det, 'verifikasiserahterima_lainlain'); ?>

<script>
    
    function cekSTCeklis() {
        $(".st_panel").each(function() {
            var nilai = $(this).find(".st_ceklis:checked").val();
            
            if (nilai == "Ada") {
                $(this).find('.st_input').prop("readonly", false);
            } else {
                $(this).find('.st_input').prop("readonly", true).val("");
                
            }
        });
    }
    $(document).ready(function() {
        $(".st_panel .st_ceklis").on("click", cekSTCeklis);
        cekSTCeklis();
    });
    
</script>