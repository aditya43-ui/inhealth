    <?php
		if(isset($_GET['sukses'])){
			Yii::app()->user->setFlash("success","Data Penerimaan Kantong Darah berhasil disimpan!");
		}
    ?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Penerimaan Kantong Darah</div>
        <div class="panel-options">
            <?php
                if (isset($_GET['frame'])) {
                    if (isset($_GET['sukses'])) {
                       echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', 'javascript:;', array('class'=>'btn btn-success','onclick'=>'window.history.go(-2); return false;', 'style'=>'color: white;'));   
                    } else {
                       echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', 'javascript:;', array('class'=>'btn btn-success','onclick'=>'window.history.back(); return false;', 'style'=>'color: white;'));
                    }    
                }
            ?>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
            'Penerimaan Kantong Darah'=>array('index'),
            'Tambah',
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        
        <?php echo $this->renderPartial($this->path_view.'_form', array(
              'modTerimaKantong'=>$modTerimaKantong,
              'modTerimaKantongDet'=>$modTerimaKantongDet,
              'modKirimKantongdetail'=>$modKirimKantongdetail,
              'modKirimKantong'=>$modKirimKantong,
              'kirimkantongdarah_id'=>$kirimkantongdarah_id,
              'format'=>$format,
            )); ?>
    </div>
</div>
<script>
    function cekLisKantongDarah(obj){
        var kirimkantong = $("#no_kirimkantongform").val();
        var tot = $("#table-detailbarang > tbody > tr ").length;
        var nokantong = $(obj).val();
                
        if (kirimkantong == '' && tot == 0 ){
            toastr.error("Maaf Data Pengiriman Kantong Darah belum dipilih","Perhatian!");
            $(obj).val('');
            $("#kirimkantongdarah_id").val('');            
        }else{
            if (nokantong != ''){
                
                var cek = 0;
                $("#table-detailbarang > tbody > tr ").each(function(){
                    if ($(this).find('.nobarcodeutama').html() == nokantong){
                        $(this).find('.checklist').prop("checked",true);
                        $(this).find('.checklistsample').prop("checked",true);
                        $(this).find('.checklistimltd').prop("checked",true); 
                        cek++;
                    }
                    if ($(this).find('.nobarcodesample').html() == nokantong){
                        //$(this).find('.checklistsample').prop("checked",true);
                        //$(this).parents("tr").find('.checklist').prop("checked",true);
                        //cek++;
                    }
                    if ($(this).find('.nobarcodeimltd').html() == nokantong){
                        //$(this).find('.checklistimltd').prop("checked",true); 
                        //$(this).parents("tr").find('.checklist').prop("checked",true);
                        //cek++;
                    }
                });
                
                if (cek == 0){
                    toastr.error("No. Kantong darah utama tidak tidak ada","Perhatian!");                    
                }
                
                $(obj).val('');
                setTimeout(function(){
                    $(obj).focus();                                
                },100);                
            }
        }
    }
    
    $(document).ready(function(){
        <?php if (!empty($modTerimaKantong->terimakantongdarah_id)){ ?>
               $("#form-penerimaan-det").find('input,select,textarea').attr('readonly',true);
               $("#form-penerimaan-det").find('.add-on').hide();
               setTimeout(function(){
                $('#<?php echo CHtml::activeId($modTerimaKantong, 'tglterimakantong') ?>').datepicker('destroy');
               },500);
               
        <?php } ?>
    });
</script>