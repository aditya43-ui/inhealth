<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<script type='text/javascript'>
    function choiseObservasi(obj,jenisobservasi){
        if(($(obj).val() == 'anak' && $(obj).prop('checked')==true) || jenisobservasi !== undefined && jenisobservasi ==='anak'){
            inputAllEnabled($('#choise_observasiAnak').find('.panel-body'));
            $('#choise_observasiAnak').find('.panel-body').find('.formObservasiAnak').show();
            <?php
                if(!isset($_GET['observasipasienri_id'])){
                ?>
                          $('#choise_observasiAnak').find('.panel-body').find('.formObservasiAnak').find('input[type="text"], textarea, select').val('');  
                <?php
                }
            ?>
            inputAllDisabled($('#choise_observasiDewasa').find('.panel-body'));
            $('#choise_observasiDewasa').find('.panel-body').find('.formObservasiDewasa').hide();
        }else if(($(obj).val() == 'dewasa' && $(obj).prop('checked')==true ) || jenisobservasi !== undefined && jenisobservasi ==='dewasa'){
           inputAllEnabled($('#choise_observasiDewasa').find('.panel-body'));
            $('#choise_observasiDewasa').find('.panel-body').find('.formObservasiDewasa').show();
            <?php
                if(!isset($_GET['observasipasienri_id'])){
                ?>
                     $('#choise_observasiDewasa').find('.panel-body').find('.formObservasiDewasa').find('input[type="text"], textarea, select').val('');       
                <?php
                }
            ?>
            inputAllDisabled($('#choise_observasiAnak').find('.panel-body'));
            $('#choise_observasiAnak').find('.panel-body').find('.formObservasiAnak').hide();
        }else{
            inputAllDisabled($('#choise_observasiDewasa').find('.panel-body'));
            $('#choise_observasiDewasa').find('.panel-body').find('.formObservasiDewasa').hide();
            
            inputAllDisabled($('#choise_observasiAnak').find('.panel-body'));
            $('#choise_observasiAnak').find('.panel-body').find('.formObservasiAnak').hide();
        }
    }
    
    function inputAllDisabled(obj){
        $(obj).find('input,select,textarea').each(function(){ //element <input>
            $(this).attr('disabled',true);
        });
    }
    
    function inputAllEnabled(obj){
        $(obj).find('input,select,textarea').each(function(){ //element <input>
            $(this).attr('disabled',false);
        });
    }
    
function printRiwayat(pendaftaran_id, pasienadmisi_id,caraPrint,jenisobservasi)
{
    window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id+'&pasienadmisi_id='+pasienadmisi_id+'&caraPrint='+caraPrint+'&jenisobservasi='+jenisobservasi,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
}

function hapusRiwayat(pendaftaran_id,pasienadmisi_id,observasipasienri_id) {
    myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('hapusObservasi'); ?>', {pendaftaran_id: pendaftaran_id,pasienadmisi_id:pasienadmisi_id, observasipasienri_id:observasipasienri_id}, function(data) {
                if (data.sukses == 1) {
                    myAlert(data.msg);
                    if(data.jenisobservasi=='anak'){
                        $.fn.yiiGridView.update('riwayatobservasianak-grid', {
                            data: {
                                "RDObservasipasienriT[pendaftaran_id]":pendaftaran_id,
                                "RDObservasipasienriT[pasienadmisi_id]":pasienadmisi_id
                            }
                        });
                    }else{
                        $.fn.yiiGridView.update('riwayatobservasidewasa-grid', {
                            data: {
                                "RDObservasipasienriT[pendaftaran_id]":pendaftaran_id,
                                "RDObservasipasienriT[pasienadmisi_id]":pasienadmisi_id
                            }
                        });
                    }
                    
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
        }
    });
}

$(document).ready(function(){
<?php if(isset($model->isobservasi_anakbayi)){ ?>
        choiseObservasi($('#<?php echo CHtml::activeId($model, 'isobservasi_anakbayi') ?>'),'<?php echo $model->isobservasi_anakbayi; ?>');
<?php }else{ ?>
    choiseObservasi($('#<?php echo CHtml::activeId($model, 'isobservasi_anakbayi') ?>'));
<?php } ?>
    
});
</script>

