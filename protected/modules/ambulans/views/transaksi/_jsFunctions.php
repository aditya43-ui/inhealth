<script type="text/javascript">
/**
* untuk print pemesanan ambulans pasien luar
 */
function print(caraPrint)
{
    var pesanambulans_t = '<?php echo isset($modPemesanan->pesanambulans_t) ? $modPemesanan->pesanambulans_t : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pesanambulans_t='+pesanambulans_t+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
$(document).ready(function(){
    
     <?php if(isset($_GET['sukses'])){ ?>
        $("input, select, textarea").attr("readonly",true);
		$(".btn-mini, .add-on").detach();
		
    <?php } ?>
    
    
    // Notifikasi Pasien
    
    <?php 
        if(isset($smspasien)){
            if($smspasien==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPemesanan->namapasien; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>

    <?php 
        if(isset($modPemesanan->pesanambulans_id)){
            
            $nama_pasien = null;
            $no_rekam_medik = null;
            
            if (!empty($modPemesanan->pasien)) {
                $nama_pasien = $modPemesanan->pasien->nama_pasien;
                $no_rekam_medik = $modPemesanan->pasien->no_rekam_medik;
            }
            
    ?>
        var params = [];
        params = {
            instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, 
            modul_id:<?php echo Params::MODUL_ID_AMBULANS ?>, 
            judulnotifikasi:'Pemesanan Ambulans', 
            isinotifikasi:'Telah dilakukan pemesanan ambulans atas nama <?php echo $nama_pasien ?> dengan <?php echo $no_rekam_medik ?> pada <?php echo $modPemesanan->tglpemesananambulans ?> untuk pemakaian pada <?php echo $modPemesanan->tglpemakaianambulans ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
         cekDisabled($('#pesanambulans-t-form'));   
})

$('#resetbtn').click(function(){
    window.location = '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Pemesanan'); ?>';
});

function clearDataPasien()
{
    $("#<?php echo CHtml::activeId($modPemesanan, 'pasien_id') ?>").val('');
    $("#<?php echo CHtml::activeId($modPemesanan, 'norekammedis') ?>").val('');
    $("#<?php echo CHtml::activeId($modPemesanan, 'pendaftaran_id') ?>").val('');
}
</script>