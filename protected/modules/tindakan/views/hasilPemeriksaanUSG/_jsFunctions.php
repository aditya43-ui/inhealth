<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">

function hapusHasilPemeriksaan(id,daftarid) {
    myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('hapusHasilPemeriksaan'); ?>', {id: id,pendaftaran_id:daftarid}, function(data) {
                if (data.sukses == 1) {
                    myAlert(data.msg);
                    window.location.replace('<?php echo $this->createUrl('index', array('pendaftaran_id'=>$model->pendaftaran_id)); ?>');
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
        }
    });
}

function choiseTrimester(obj){
<?php if(!isset($_GET['pemeriksaanusgpasien_id'])){ ?>
$('#choise_trs1').find('.panel-body').find('.formtrs1').find('#tbltrimester_1').find('tbody').html('');
$('#choise_trs2').find('.panel-body').find('.formtrs2').find('#tbltrimester_2').find('tbody').html('');
$('#choise_trs3').find('.panel-body').find('.formtrs3').find('#tbltrimester_3').find('tbody').html('');
<?php } ?>
    if($(obj).val() == 1 && $(obj).prop('checked')==true){
        inputAllEnabled($('#choise_trs1').find('.panel-body'));
        $('#choise_trs1').find('.panel-body').find('.formtrs1').show();

        inputAllDisabled($('#choise_trs2').find('.panel-body'));
        $('#choise_trs2').find('.panel-body').find('.formtrs2').hide();
        inputAllDisabled($('#choise_trs3').find('.panel-body'));
        $('#choise_trs3').find('.panel-body').find('.formtrs3').hide();
    }else if($(obj).val() == 2 && $(obj).prop('checked')==true){
        inputAllEnabled($('#choise_trs2').find('.panel-body'));
        $('#choise_trs2').find('.panel-body').find('.formtrs2').show();

        inputAllDisabled($('#choise_trs1').find('.panel-body'));
        $('#choise_trs1').find('.panel-body').find('.formtrs1').hide();
        inputAllDisabled($('#choise_trs3').find('.panel-body'));
        $('#choise_trs3').find('.panel-body').find('.formtrs3').hide();
    }else if($(obj).val() == 3 && $(obj).prop('checked')==true){
        inputAllEnabled($('#choise_trs3').find('.panel-body'));
        $('#choise_trs3').find('.panel-body').find('.formtrs3').show();

        inputAllDisabled($('#choise_trs2').find('.panel-body'));
        $('#choise_trs2').find('.panel-body').find('.formtrs2').hide();
        inputAllDisabled($('#choise_trs1').find('.panel-body'));
        $('#choise_trs1').find('.panel-body').find('.formtrs1').hide();
    }else{
        inputAllDisabled($('#choise_trs1').find('.panel-body'));
        $('#choise_trs1').find('.panel-body').find('.formtrs1').hide();
//        $('#choise_trs1').find('.panel-body').find('.formtrs1').find('#tbltrimester_1').find('tbody').html('');
        
        inputAllDisabled($('#choise_trs3').find('.panel-body'));
        $('#choise_trs3').find('.panel-body').find('.formtrs3').hide();
        inputAllDisabled($('#choise_trs2').find('.panel-body'));
        $('#choise_trs2').find('.panel-body').find('.formtrs2').hide();
    }
}

function inputAllDisabled(obj){
    $(obj).find('input,select,textarea').each(function(){ //element <input>
        $(this).attr('disabled',true);
    });
//    $(obj).find('.jumlahjaninLabel').removeClass('required');
    
}

function inputAllEnabled(obj){
    $(obj).find('input,select,textarea').each(function(){ //element <input>
        $(this).attr('disabled',false);
    });
//    $(obj).find('.jumlahjaninLabel').addClass('required');
}

function addRowTrs1(){
    var html = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowDetailTrimester1',array(),true));?>);
    $('#choise_trs1').find('.panel-body').find('.formtrs1').find('#tbltrimester_1').find('tbody').append(html.replace());
    generateRowTrs1($('#choise_trs1').find('.panel-body').find('.formtrs1').find('#tbltrimester_1').find('tbody'));
//    formatNumberSemua();
}

function generateRowTrs1(obj){
    var indexNo = 1;
    for(var i=0; i<$(obj).find('.janinke').length; i++){
        var trRow = $(obj).find('.janinke').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_janinke');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][janinke]');
       $(obj).find('.janinke').eq(i).val(indexNo);
         $(obj).find('.janinkeSpan').eq(i).html(indexNo);
        
        indexNo++;
    }
    
    for(var i=0; i<$(obj).find('.radio_mainkantong').length; i++){
         var trRow = $(obj).find('.radio_mainkantong').eq(i);
         
         trRow.find('.kantongkehamilan').attr('name','RJPemeriksaanusgpasiendetT['+i+'][kantongkehamilan]');
    }
    
    for(var i=0; i<$(obj).find('.radio_mainfetalecho').length; i++){
         var trRow = $(obj).find('.radio_mainfetalecho').eq(i);
         
         trRow.find('.fetalecho').attr('name','RJPemeriksaanusgpasiendetT['+i+'][fetalecho]');
    }
    
    for(var i=0; i<$(obj).find('.radio_mainletakkantong').length; i++){
         var trRow = $(obj).find('.radio_mainletakkantong').eq(i);
         
         trRow.find('.letakkehamilan').attr('name','RJPemeriksaanusgpasiendetT['+i+'][letakkehamilan]');
    }
    
    for(var i=0; i<$(obj).find('.radio_mainpulsasi').length; i++){
         var trRow = $(obj).find('.radio_mainpulsasi').eq(i);
         
         trRow.find('.pulsasi').attr('name','RJPemeriksaanusgpasiendetT['+i+'][pulsasi]');
    }
    
    for(var i=0; i<$(obj).find('.biometri_gs').length; i++){
        var trRow = $(obj).find('.biometri_gs').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_biometri_gs');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][biometri_gs]');
    }
    
    for(var i=0; i<$(obj).find('.biometri_crl').length; i++){
        var trRow = $(obj).find('.biometri_crl').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_biometri_crl');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][biometri_crl]');
    }
    
    for(var i=0; i<$(obj).find('.biometri_bpd').length; i++){
        var trRow = $(obj).find('.biometri_bpd').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_biometri_bpd');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][biometri_bpd]');
    }
    
    for(var i=0; i<$(obj).find('.biometri_fl').length; i++){
        var trRow = $(obj).find('.biometri_fl').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_biometri_fl');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][biometri_fl]');
    }
    
    for(var i=0; i<$(obj).find('.patologi').length; i++){
        var trRow = $(obj).find('.patologi').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_patologi');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][patologi]');
    }
    
    for(var i=0; i<$(obj).find('.denyutjantungjanin').length; i++){
        var trRow = $(obj).find('.denyutjantungjanin').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_denyutjantungjanin');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][denyutjantungjanin]');
    }
    
    for(var i=0; i<$(obj).find('.gravid').length; i++){
        var trRow = $(obj).find('.gravid').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_gravid');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][gravid]');
    }
    
    for(var i=0; i<$(obj).find('.taksiranmelahirkan').length; i++){
        var trRow = $(obj).find('.taksiranmelahirkan').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_taksiranmelahirkan');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][taksiranmelahirkan]');
       
       
       trRow.datepicker(
            jQuery.extend(
                {showMonthAfterYear:true},
                jQuery.datepicker.regional['id'],
                {
                    'dateFormat':'dd M yy',
                    'changeYear':true,
                    'changeMonth':true,
                    'showAnim':'fold',
                    'yearRange':'-0y:+10y'
                }
            )
        );
    }
    
    for(var i=0; i<$(obj).find('.kondisijaninkeseluruhan').length; i++){
        var trRow = $(obj).find('.kondisijaninkeseluruhan').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_kondisijaninkeseluruhan');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][kondisijaninkeseluruhan]');
    }
}

function pilihJumlahJaninTrs1(obj){
    if($(obj).val() === 'Tunggal' && $(obj).prop('checked')===true){
        addJumlahjaninTrs1(1);
        $('#choise_trs1').find('.panel-body').find('.formtrs1').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').attr('readonly',true);
    }else if($(obj).val() === 'Gemeli' && $(obj).prop('checked')===true){
        addJumlahjaninTrs1(2);
        $('#choise_trs1').find('.panel-body').find('.formtrs1').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').attr('readonly',true);
    }else if($(obj).val() === 'Triple' && $(obj).prop('checked')===true){
        addJumlahjaninTrs1(3);
        $('#choise_trs1').find('.panel-body').find('.formtrs1').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').attr('readonly',true);
    }else if($(obj).val() === 'Lainnya' && $(obj).prop('checked')===true){
        $('#choise_trs1').find('.panel-body').find('.formtrs1').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').attr('readonly',false);
    }else{
        $('#choise_trs1').find('.panel-body').find('.formtrs1').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').attr('readonly',true);
    }
}

function addJumlahjaninTrs1(type = ""){
$('#choise_trs1').find('.panel-body').find('.formtrs1').find('#tbltrimester_1').find('tbody').html('');
    var addData = 0; 
    if(type === ''){
        if($('#choise_trs1').find('.panel-body').find('.formtrs1').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').val() != ''){
            var jml = parseInt($('#choise_trs1').find('.panel-body').find('.formtrs1').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').val()); 
            addData = jml;
        }
    }else{
        addData = parseInt(type); 
    }
    $('#choise_trs1').find('.panel-body').find('.formtrs1').find('#<?php echo CHtml::activeId($model, 'jumlahjanin'); ?>').val(addData);
    
    for (var i=0; i<addData; i++){
        addRowTrs1();
    }
    
    $('#choise_trs1').find('.panel-body').find('.formtrs1').find('#tbltrimester_1').find(".integer-decimal").maskMoney(
            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
    );
}


function addRowTrs2(){
    var html = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowDetailTrimester2',array(),true));?>);
    $('#choise_trs2').find('.panel-body').find('.formtrs2').find('#tbltrimester_2').find('tbody').append(html.replace());
    generateRowTrs2($('#choise_trs2').find('.panel-body').find('.formtrs2').find('#tbltrimester_2').find('tbody'));
//    formatNumberSemua();
}

function generateRowTrs2(obj){
    var indexNo = 1;
    for(var i=0; i<$(obj).find('.janinke').length; i++){
        var trRow = $(obj).find('.janinke').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_janinke');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][janinke]');
       $(obj).find('.janinke').eq(i).val(indexNo);
         $(obj).find('.janinkeSpan').eq(i).html(indexNo);
        
        indexNo++;
    }
    
    for(var i=0; i<$(obj).find('.presentasi_janin').length; i++){
        var trRow = $(obj).find('.presentasi_janin').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_presentasi_janin');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][presentasi_janin]');
    }
    
    for(var i=0; i<$(obj).find('.radio_mainbunyijantung').length; i++){
         var trRow = $(obj).find('.radio_mainbunyijantung').eq(i);
         
         trRow.find('.bunyijantung').attr('name','RJPemeriksaanusgpasiendetT['+i+'][bunyijantung]');
    }
    
    for(var i=0; i<$(obj).find('.radio_mainjeniskelamin').length; i++){
         var trRow = $(obj).find('.radio_mainjeniskelamin').eq(i);
         
         trRow.find('.jeniskelamin').attr('name','RJPemeriksaanusgpasiendetT['+i+'][jeniskelamin]');
//         trRow.find('.jeniskelamin').on('click',function(){
//             alert('=== '+$(this).val());
//             if($(this).val() === 'Lainnya' && $(this).prop('checked')===true){
//                 $(obj).find('.jeniskelamin_lainnya').eq(i).attr('readonly', false);
//             }else{
////                 $(obj).find('.jeniskelamin_lainnya').eq(i).attr('readonly', true);
//             }
//         });
    }
    
    for(var i=0; i<$(obj).find('.jeniskelamin_lainnya').length; i++){
        var trRow = $(obj).find('.jeniskelamin_lainnya').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_jeniskelamin_lainnya');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][jeniskelamin_lainnya]');
    }
    
    for(var i=0; i<$(obj).find('.biometri_ac').length; i++){
        var trRow = $(obj).find('.biometri_ac').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_biometri_ac');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][biometri_ac]');
    }
    
    for(var i=0; i<$(obj).find('.biometri_bpd').length; i++){
        var trRow = $(obj).find('.biometri_bpd').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_biometri_bpd');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][biometri_bpd]');
    }
    
    for(var i=0; i<$(obj).find('.biometri_fl').length; i++){
        var trRow = $(obj).find('.biometri_fl').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_biometri_fl');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][biometri_fl]');
    }
    for(var i=0; i<$(obj).find('.taksiranberatjanin').length; i++){
        var trRow = $(obj).find('.taksiranberatjanin').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_taksiranberatjanin');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][taksiranberatjanin]');
    }
    for(var i=0; i<$(obj).find('.radio_mainjml_air_ketuban').length; i++){
         var trRow = $(obj).find('.radio_mainjml_air_ketuban').eq(i);
         
         trRow.find('.jml_air_ketuban').attr('name','RJPemeriksaanusgpasiendetT['+i+'][jml_air_ketuban]');
    }
    for(var i=0; i<$(obj).find('.radio_maininsertio_plasenta').length; i++){
         var trRow = $(obj).find('.radio_maininsertio_plasenta').eq(i);
         
         trRow.find('.insertio_plasenta').attr('name','RJPemeriksaanusgpasiendetT['+i+'][insertio_plasenta]');
    }
    
    for(var i=0; i<$(obj).find('.talipusat').length; i++){
        var trRow = $(obj).find('.talipusat').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_talipusat');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][talipusat]');
    }
    
    for(var i=0; i<$(obj).find('.patologi').length; i++){
        var trRow = $(obj).find('.patologi').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_patologi');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][patologi]');
    }
    
    for(var i=0; i<$(obj).find('.denyutjantungjanin').length; i++){
        var trRow = $(obj).find('.denyutjantungjanin').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_denyutjantungjanin');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][denyutjantungjanin]');
    }
    
    for(var i=0; i<$(obj).find('.gravid').length; i++){
        var trRow = $(obj).find('.gravid').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_gravid');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][gravid]');
    }
    
    for(var i=0; i<$(obj).find('.taksiranmelahirkan').length; i++){
        var trRow = $(obj).find('.taksiranmelahirkan').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_taksiranmelahirkan');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][taksiranmelahirkan]');
       
       
       trRow.datepicker(
            jQuery.extend(
                {showMonthAfterYear:true},
                jQuery.datepicker.regional['id'],
                {
                    'dateFormat':'dd M yy',
                    'changeYear':true,
                    'changeMonth':true,
                    'showAnim':'fold',
                    'yearRange':'-0y:+10y'
                }
            )
        );
    }
    
    for(var i=0; i<$(obj).find('.kondisijaninkeseluruhan').length; i++){
        var trRow = $(obj).find('.kondisijaninkeseluruhan').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_kondisijaninkeseluruhan');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][kondisijaninkeseluruhan]');
    }
}

function pilihJumlahJaninTrs2(obj){
    if($(obj).val() === 'Tunggal' && $(obj).prop('checked')===true){
        addJumlahjaninTrs2(1);
        $('#choise_trs2').find('.panel-body').find('.formtrs2').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').attr('readonly',true);
    }else if($(obj).val() === 'Gemeli' && $(obj).prop('checked')===true){
        addJumlahjaninTrs2(2);
        $('#choise_trs2').find('.panel-body').find('.formtrs2').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').attr('readonly',true);
    }else if($(obj).val() === 'Triple' && $(obj).prop('checked')===true){
        addJumlahjaninTrs2(3);
        $('#choise_trs2').find('.panel-body').find('.formtrs2').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').attr('readonly',true);
    }else if($(obj).val() === 'Lainnya' && $(obj).prop('checked')===true){
        $('#choise_trs2').find('.panel-body').find('.formtrs2').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').attr('readonly',false);
    }else{
        $('#choise_trs2').find('.panel-body').find('.formtrs2').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').attr('readonly',true);
    }
}

function addJumlahjaninTrs2(type = ""){
$('#choise_trs2').find('.panel-body').find('.formtrs2').find('#tbltrimester_2').find('tbody').html('');
    var addData = 0; 
    if(type === ''){
        if($('#choise_trs2').find('.panel-body').find('.formtrs2').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').val() != ''){
            var jml = parseInt($('#choise_trs2').find('.panel-body').find('.formtrs2').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').val()); 
            addData = jml;
        }
    }else{
        addData = parseInt(type); 
    }
    $('#choise_trs2').find('.panel-body').find('.formtrs2').find('#<?php echo CHtml::activeId($model, 'jumlahjanin'); ?>').val(addData);
    
    for (var i=0; i<addData; i++){
        addRowTrs2();
    }
     $('#choise_trs2').find('.panel-body').find('.formtrs2').find('#tbltrimester_2').find(".integer-decimal").maskMoney(
            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
    );
}

function addRowTrs3(){
    var html = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowDetailTrimester3',array(),true));?>);
    $('#choise_trs3').find('.panel-body').find('.formtrs3').find('#tbltrimester_3').find('tbody').append(html.replace());
    generateRowTrs3($('#choise_trs3').find('.panel-body').find('.formtrs3').find('#tbltrimester_3').find('tbody'));
//    unformatNumberSemua();
//    formatNumberSemua();
}

function generateRowTrs3(obj){
    var indexNo = 1;
    for(var i=0; i<$(obj).find('.janinke').length; i++){
        var trRow = $(obj).find('.janinke').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_janinke');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][janinke]');
       $(obj).find('.janinke').eq(i).val(indexNo);
         $(obj).find('.janinkeSpan').eq(i).html(indexNo);
        
        indexNo++;
    }
    
    for(var i=0; i<$(obj).find('.presentasi_janin').length; i++){
        var trRow = $(obj).find('.presentasi_janin').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_presentasi_janin');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][presentasi_janin]');
    }
    
    for(var i=0; i<$(obj).find('.radio_mainbunyijantung').length; i++){
         var trRow = $(obj).find('.radio_mainbunyijantung').eq(i);
         
         trRow.find('.bunyijantung').attr('name','RJPemeriksaanusgpasiendetT['+i+'][bunyijantung]');
    }
    
    for(var i=0; i<$(obj).find('.radio_mainjeniskelamin').length; i++){
         var trRow = $(obj).find('.radio_mainjeniskelamin').eq(i);
         
         trRow.find('.jeniskelamin').attr('name','RJPemeriksaanusgpasiendetT['+i+'][jeniskelamin]');
//         trRow.find('.jeniskelamin').on('click',function(){
//             alert('=== '+$(this).val());
//             if($(this).val() === 'Lainnya' && $(this).prop('checked')===true){
//                 $(obj).find('.jeniskelamin_lainnya').eq(i).attr('readonly', false);
//             }else{
////                 $(obj).find('.jeniskelamin_lainnya').eq(i).attr('readonly', true);
//             }
//         });
    }
    
    for(var i=0; i<$(obj).find('.jeniskelamin_lainnya').length; i++){
        var trRow = $(obj).find('.jeniskelamin_lainnya').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_jeniskelamin_lainnya');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][jeniskelamin_lainnya]');
    }
    
    for(var i=0; i<$(obj).find('.biometri_ac').length; i++){
        var trRow = $(obj).find('.biometri_ac').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_biometri_ac');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][biometri_ac]');
    }
    
    for(var i=0; i<$(obj).find('.biometri_bpd').length; i++){
        var trRow = $(obj).find('.biometri_bpd').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_biometri_bpd');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][biometri_bpd]');
    }
    
    for(var i=0; i<$(obj).find('.biometri_fl').length; i++){
        var trRow = $(obj).find('.biometri_fl').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_biometri_fl');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][biometri_fl]');
    }
    for(var i=0; i<$(obj).find('.taksiranberatjanin').length; i++){
        var trRow = $(obj).find('.taksiranberatjanin').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_taksiranberatjanin');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][taksiranberatjanin]');
    }
    for(var i=0; i<$(obj).find('.radio_mainjml_air_ketuban').length; i++){
         var trRow = $(obj).find('.radio_mainjml_air_ketuban').eq(i);
         
         trRow.find('.jml_air_ketuban').attr('name','RJPemeriksaanusgpasiendetT['+i+'][jml_air_ketuban]');
    }
    for(var i=0; i<$(obj).find('.radio_maininsertio_plasenta').length; i++){
         var trRow = $(obj).find('.radio_maininsertio_plasenta').eq(i);
         
         trRow.find('.insertio_plasenta').attr('name','RJPemeriksaanusgpasiendetT['+i+'][insertio_plasenta]');
    }
    
    for(var i=0; i<$(obj).find('.talipusat').length; i++){
        var trRow = $(obj).find('.talipusat').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_talipusat');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][talipusat]');
    }
    
    for(var i=0; i<$(obj).find('.patologi').length; i++){
        var trRow = $(obj).find('.patologi').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_patologi');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][patologi]');
    }
    
    for(var i=0; i<$(obj).find('.denyutjantungjanin').length; i++){
        var trRow = $(obj).find('.denyutjantungjanin').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_denyutjantungjanin');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][denyutjantungjanin]');
    }
    
    for(var i=0; i<$(obj).find('.gravid').length; i++){
        var trRow = $(obj).find('.gravid').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_gravid');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][gravid]');
    }
    
    for(var i=0; i<$(obj).find('.taksiranmelahirkan').length; i++){
        var trRow = $(obj).find('.taksiranmelahirkan').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_taksiranmelahirkan');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][taksiranmelahirkan]');
       
       
       trRow.datepicker(
            jQuery.extend(
                {showMonthAfterYear:true},
                jQuery.datepicker.regional['id'],
                {
                    'dateFormat':'dd M yy',
                    'changeYear':true,
                    'changeMonth':true,
                    'showAnim':'fold',
                    'yearRange':'-0y:+10y'
                }
            )
        );
    }
    
    for(var i=0; i<$(obj).find('.kondisijaninkeseluruhan').length; i++){
        var trRow = $(obj).find('.kondisijaninkeseluruhan').eq(i);
       trRow.attr('id','RJPemeriksaanusgpasiendetT_'+i+'_kondisijaninkeseluruhan');
       trRow.attr('name','RJPemeriksaanusgpasiendetT['+i+'][kondisijaninkeseluruhan]');
    }
}

function pilihJumlahJaninTrs3(obj){
    if($(obj).val() === 'Tunggal' && $(obj).prop('checked')===true){
        addJumlahjaninTrs3(1);
        $('#choise_trs3').find('.panel-body').find('.formtrs3').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').attr('readonly',true);
    }else if($(obj).val() === 'Gemeli' && $(obj).prop('checked')===true){
        addJumlahjaninTrs3(2);
        $('#choise_trs3').find('.panel-body').find('.formtrs3').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').attr('readonly',true);
    }else if($(obj).val() === 'Triple' && $(obj).prop('checked')===true){
        addJumlahjaninTrs3(3);
       $('#choise_trs3').find('.panel-body').find('.formtrs3').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').attr('readonly',true);
    }else if($(obj).val() === 'Lainnya' && $(obj).prop('checked')===true){
        $('#choise_trs3').find('.panel-body').find('.formtrs3').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').attr('readonly',false);
    }else{
        $('#choise_trs3').find('.panel-body').find('.formtrs3').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').attr('readonly',true);
    }
}

function addJumlahjaninTrs3(type = ""){
$('#choise_trs3').find('.panel-body').find('.formtrs3').find('#tbltrimester_3').find('tbody').html('');
    var addData = 0; 
    if(type === ''){
        if($('#choise_trs3').find('.panel-body').find('.formtrs3').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').val() != ''){
            var jml = parseInt($('#choise_trs3').find('.panel-body').find('.formtrs3').find('#<?php echo CHtml::activeId($model, 'jumlahjaninlain'); ?>').val()); 
            addData = jml;
        }
    }else{
        addData = parseInt(type); 
    }
    $('#choise_trs3').find('.panel-body').find('.formtrs3').find('#<?php echo CHtml::activeId($model, 'jumlahjanin'); ?>').val(addData);
    
    for (var i=0; i<addData; i++){
        addRowTrs3();
    }
    $('#choise_trs3').find('.panel-body').find('.formtrs3').find('#tbltrimester_3').find(".integer-decimal").maskMoney(
            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
    );
}

function cekSimpanData(){
   if(requiredCheck($("form"))){
        $(".integer2, .float2, .integer-decimal").each(function(){
            $(this).val(unformatNumber($(this).val()));
        });
        $('#hasilpemeriksaanusg-t-form').submit();
    }
    return false;
}

function printRiwayat(id, pendaftaranid,caraPrint)
{
    window.open('<?php echo $this->createUrl('print'); ?>&pemeriksaanusgpasien_id='+id+'&pendaftaran_id='+pendaftaranid+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
}

function dialogDetailPemeriksaan(value){
   $('#dialogHasil').parents().find('.titleDialog').html(value);
   $('#dialogHasil').dialog('open');
}
$(document).ready(function(){
    
    <?php if(isset($_GET['pemeriksaanusgpasien_id'])){ ?>
    <?php if($model->is_trimester == 1){ ?>
        choiseTrimester($('#choise_trs1').find('#<?php echo CHtml::activeId($model, 'is_trimester'); ?>'));
    <?php } else if($model->is_trimester == 2){ ?>
        choiseTrimester($('#choise_trs2').find('#<?php echo CHtml::activeId($model, 'is_trimester'); ?>'));
    <?php } else if($model->is_trimester == 3){ ?>
        choiseTrimester($('#choise_trs3').find('#<?php echo CHtml::activeId($model, 'is_trimester'); ?>'));
    <?php } ?>
    <?php }else{ ?>
        choiseTrimester();
    <?php } ?>
});
</script>