<?php
$this->breadcrumbs=array(
    'Istirahat',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'suratketerangan-r-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onSubmit'=>'cekValidasi();return false;'),
        'focus'=>'#',
)); ?>
<style>
.groupUkurans{
    display:inline;
    
}
 table > tbody > tr > td > input{
        margin-top:5px;
    }
</style>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Surat Keterangan Sehat</div>
        </div>
        <div class="panel-body" style="height:900px !important">
            <div class="col-sm-12"> 
                <div class="control-group">
                    <?php echo CHtml::label("Jenis Surat",'', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php if(!empty($_GET['jenissurat_id'])){ $model->jenissurat_id = $_GET['jenissurat_id']; } ?>
                        <?php echo $form->dropDownList($model,'jenissurat_id', CHtml::listData(JenisSuratM::model()->findAllByPk(array(9,10,11,12,14)), 'jenissurat_id', 'jenissurat_nama'),array('class'=>'span4 jenisform','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setJenisForm(); return false;')); ?>
                    </div>
                    <?php echo $form->hiddenField($model, 'pendaftaran_id',array('class'=>'pendaftaran_id','readonly'=>true, 'value'=>$_GET['pendaftaran_id'])) ?>
                </div>
                <hr>
                <div class="panel-body" id="form_tab" style="overflow-x: auto;">
                    <div class="hide">
                            <?php 
                                $this->widget('MyDateTimePicker', array(                                
                                'name' => 'testing',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                ),
                            ));
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

<?php $this->endWidget(); ?>

<script>  
    $(document).ready(function(){
//        var val = $("#<?php echo CHtml::activeId($model, 'jenissurat_id') ?>").val();
        var id= $(".pendaftaran_id").val();
        var jenissurat_id= $(".jenisform").val();
        $("#form_tab").addClass('animation-loading');
        
        if (jenissurat_id == 9) {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadForm1'); ?>',
                data: {id : id, jenissurat_id:jenissurat_id},
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){                    
                        $("#form_tab").html(data.html);
                        setTimeout(function(){
                            generatePicker();
                        },500);
                    }else{
                        Window.parent.showToast('error',data.pesan);
                    }
                    $("#form_tab").removeClass('animation-loading');
                    
                },
                 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        } else if (jenissurat_id == 10){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadForm2'); ?>',
                data: {id : id, jenissurat_id:jenissurat_id},
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){                    
                        $("#form_tab").html(data.html);
                        setTimeout(function(){
                            generatePicker();
                        },500);
                    }else{
                        Window.parent.showToast('error',data.pesan);
                    }
                    $("#form_tab").removeClass('animation-loading');
                    
                },
                 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else if (jenissurat_id == 11){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadForm3'); ?>',
                data: {id : id, jenissurat_id:jenissurat_id},
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){                    
                        $("#form_tab").html(data.html);
                        setTimeout(function(){
                            generatePicker();
                        },500);
                    }else{
                        Window.parent.showToast('error',data.pesan);
                    }
                    $("#form_tab").removeClass('animation-loading');
                    
                },
                 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        } else if (jenissurat_id == 12){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadForm4'); ?>',
                data: {id : id, jenissurat_id:jenissurat_id},
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){                    
                        $("#form_tab").html(data.html);
                        setTimeout(function(){
                            generatePicker();
                        },500);
                    }else{
                        Window.parent.showToast('error',data.pesan);
                    }
                    $("#form_tab").removeClass('animation-loading');
                    
                },
                 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else if (jenissurat_id == 14){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadForm5'); ?>',
                data: {id : id, jenissurat_id:jenissurat_id},
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){                    
                        $("#form_tab").html(data.html);
                        setTimeout(function(){
                            generatePicker();
                        },500);
                    }else{
                        Window.parent.showToast('error',data.pesan);
                    }
                    $("#form_tab").removeClass('animation-loading');
                    
                },
                 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else if (jenissurat_id == ''){
            myAlert('Silakan pilih jenis surat terlebih dahulu!');
        }
    });
    
    function setJenisForm() {
        var id= $(".pendaftaran_id").val();
        var jenissurat_id= $(".jenisform").val();
        $("#form_tab").addClass('animation-loading');
        
        if (jenissurat_id == 9) {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadForm1'); ?>',
                data: {id : id, jenissurat_id:jenissurat_id},
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){                    
                        $("#form_tab").html(data.html);
                        setTimeout(function(){
                            generatePicker();
                        },500);
                    }else{
                        Window.parent.showToast('error',data.pesan);
                    }
                    $("#form_tab").removeClass('animation-loading');
                    
                },
                 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        } else if (jenissurat_id == 10){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadForm2'); ?>',
                data: {id : id, jenissurat_id:jenissurat_id},
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){                    
                        $("#form_tab").html(data.html);
                        setTimeout(function(){
                            generatePicker();
                        },500);
                    }else{
                        Window.parent.showToast('error',data.pesan);
                    }
                    $("#form_tab").removeClass('animation-loading');
                    
                },
                 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else if (jenissurat_id == 11){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadForm3'); ?>',
                data: {id : id, jenissurat_id:jenissurat_id},
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){                    
                        $("#form_tab").html(data.html);
                        setTimeout(function(){
                            generatePicker();
                        },500);
                    }else{
                        Window.parent.showToast('error',data.pesan);
                    }
                    $("#form_tab").removeClass('animation-loading');
                    
                },
                 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        } else if (jenissurat_id == 12){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadForm4'); ?>',
                data: {id : id, jenissurat_id:jenissurat_id},
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){                    
                        $("#form_tab").html(data.html);
                        setTimeout(function(){
                            generatePicker();
                        },500);
                    }else{
                        Window.parent.showToast('error',data.pesan);
                    }
                    $("#form_tab").removeClass('animation-loading');
                    
                },
                 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else if (jenissurat_id == 14){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadForm5'); ?>',
                data: {id : id, jenissurat_id:jenissurat_id},
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){                    
                        $("#form_tab").html(data.html);
                        setTimeout(function(){
                            generatePicker();
                        },500);
                    }else{
                        Window.parent.showToast('error',data.pesan);
                    }
                    $("#form_tab").removeClass('animation-loading');
                    
                },
                 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else if (jenissurat_id == ''){
            myAlert('Silakan pilih jenis surat terlebih dahulu!');
        }
        
    }
    
    function generatePicker(){
    
        jQuery('.tglpemeriksaan').datepicker(
            jQuery.extend(
                {
                    showMonthAfterYear:false
                }, 
                jQuery.datepicker.regional['id'],
                {

//                    'minDate':'d',
                    'timeText':'Waktu',
                    'hourText':'Jam',
                    'minuteText':'Menit',
                    'secondText':'Detik',
                    'showSecond':true,
                    'timeOnlyTitle':'Pilih Waktu',
                    'timeFormat':'hh:mm:ss',
                    'changeYear':true,
                    'changeMonth':true,
                    'showAnim':'fold',
                    'yearRange':'-80y:+20y'
                }
            )
       );
    }
    
    //Digunakan untuk menampilkan textfield jika sampel pemeriksaannya adalah lainnya
    function myFunction(obj) {
        var id9  = document.getElementById("keterangan_sehat");
        var id10 = document.getElementById("keterangan_sehat_dokter");
        var id11 = document.getElementById("keterangan_sehat_praktek");
        
        if(obj.value == 9){
            if (id9.style.display === "none") {
                id9.style.display = "block";
            }
            if (id10.style.display === "block") {
                id10.style.display = "none";
            }
            if (id11.style.display === "block") {
                id11.style.display = "none";
            }
        }else if(obj.value == 10){
            if (id10.style.display === "none") {
                id10.style.display = "block";
            }
            if (id9.style.display === "block") {
                id9.style.display = "none";
            }
            if (id11.style.display === "block") {
                id11.style.display = "none";
            }
        }else if(obj.value == 11){
            if (id11.style.display === "none") {
                id11.style.display = "block";
            }
            if (id10.style.display === "block") {
                id10.style.display = "none";
            }
            if (id9.style.display === "block") {
                id9.style.display = "none";
            }
        }
    }
    
    function cekValidasi(){
        var tekanan_darah = $('#tekanan_darah').val();
        var tempratur = $('#tempratur').val();
        var pols = $('#pols').val();
        var rr = $('#rr').val();
        var tinggi_badan = $('#tinggi_badan').val();
        var berat_badan = $('#berat_badan').val();
        var buta_warna = $('#buta_warna').val();
        var pemeriksaan_lain = $('#pemeriksaan_lain').val();
        
        if(tekanan_darah == '' || tempratur == '' || pols == '' || rr == '' || tinggi_badan == '' || berat_badan == '' || buta_warna == '' || pemeriksaan_lain == ''){
            myAlert('Isi Terlebih dahulu data yang masih kosong');
            return false;
        }else{
            $('#suratketerangan-r-form').submit();
            return true
        }
    }    
</script>