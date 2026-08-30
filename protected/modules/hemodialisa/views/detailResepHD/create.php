<?php
$this->breadcrumbs=array(
	'Resephd Ms'=>array('index'),
	'Create',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Tambah <b>Paket HD</b></div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
</div>
<!--<script>
    function tambahDetailresephd(){
        var resephd_id = $('#resephd_id').val();
        var obatalkes_id = $('#obatalkes_id').val();
        var key = $('.tr-obatalkes:last').attr("baris");
        if(key == null){
            var key = 0;
        }
//        console.log(key);return false;
        var keyNew = parseInt(key)+1;
//        console.log(resephd_id);
        if(resephd_id == ''){
//            console.log('Pilih Paket HD dahulu');
            alert('Pilih Paket HD dahulu');
            return false;
        }
        
        if(obatalkes_id == ''){
            alert('Pilih Obat/Alkes dahulu');
            return false;
        }
        
        $.ajax({
            url: "<?= $this->createUrl('setDetailresephd'); ?>",
            dataType: 'json',
            type: 'post',
            data: {resephd_id: resephd_id, obatalkes_id: obatalkes_id, key: keyNew},
            success: function(data){
                $('#tbl-obatalkes > tbody > tr:last').after(data.form);
                clearForm();
//                $('#tbl-obatalkes > tbody').append(data.form);
            }
        })
    }
    function hapusBaris(obj){
//        console.log("ok");return false;
        $(obj).parents("tr").detach();
    }
    
    function clearForm(){
//        $('#resephd_id').val('');
        $('#obatalkes_id').val('');
        $('#obatalkes_nama').val('');
    }
    
    function setDetailPaket(obj){
//        console.log(obj.value);
        $.ajax({
            url: "<?= $this->createUrl('setDetailPaket'); ?>",
            dataType: 'json',
            type: 'post',
            data: {paket_id: obj.value},
            success: function(data){
                $('#tbl-obatalkes > tbody:last').append(data.form);
                clearForm();
//                $('#tbl-obatalkes > tbody').append(data.form);
            }
        })
    }
</script>-->