<?php 
    $profil = ProfilrumahsakitM::model()->find(array(
        'order'=>'profilrs_id'
    ));

    $isdetail = false;
    if(isset($isDetail) && $isDetail == 1){
        $isdetail = true;
    }
?>

<p>Hak Pasien dan Keluarga di <?php echo $profil->nama_rumahsakit; ?>: </p>

<?php echo CHtml::hiddenField('hak_pasien_pendaftaran_id', $model->pendaftaran_id); ?>

<ul>
    <li><?php echo CHtml::checkBox('pilih_semua', false, array(
        'class'=>'ceklis_hak_pasien_semua',
        'onclick'=>'pilih_semua_hak_pasien()',
    )); ?> Pilih Semua</li>
    <?php 

    $hak = HakpasienM::model()->findAllByAttributes(array(
        'hakpasien_aktif'=>true,
        'kelompok' => "Hak"
    ), array(
        'order'=>'hakpasien_urutan'
    ));

    /*
    Yii::app()->user->setState('hak_pasien_sudah_baca', null);
    Yii::app()->user->setState('ceklis_hak_pasien_'.$this->id, null);
    Yii::app()->user->setState('hak_pasien_sudah_baca_'.$this->id, null);
    */

    $session_ceklis_hak_pasien = Yii::app()->user->getState('ceklis_hak_pasien_'.$this->id);
    $session_sudah_baca = Yii::app()->user->getState('hak_pasien_sudah_baca_'.$this->id);

    $if_sudah_baca = (!empty($session_sudah_baca) && $session_sudah_baca == 1) || $model->isbacahakpasien == true;

    // var_dump((!empty($session_sudah_baca) && $session_sudah_baca == 1), $model->isbacahakpasien); die;
        
    foreach ($hak as $item) { ?>

        <li>
            <?php echo CHtml::checkBox('cek_hak_pasien['.$item->hakpasien_id.']', 
                    !empty($session_ceklis_hak_pasien)
                    && in_array($item->hakpasien_id, $session_ceklis_hak_pasien)
                , array(
                'class'=>'ceklis_hak_pasien_baca',
                'onclick'=>'setCeklisHakPasien()',
                'data-id'=>$item->hakpasien_id,
            ))." ".$item->hakpasien_nama; ?>
        </li>

    <?php } ?>
</ul>

<div id="tampil">
    <p>Kewajiban Pasien dan Keluarga di <?php echo $profil->nama_rumahsakit; ?>: </p>
    <ul>
        
        <li><?php echo CHtml::checkBox('pilih_semua_kewajiban', false, array(
            'class'=>'ceklis_kewajiban_pasien_semua',
            'onclick'=>'pilih_semua_kewajiban_pasien()',
        )); ?> Pilih Semua</li>
        
        <?php 

        $hak = HakpasienM::model()->findAllByAttributes(array(
            'hakpasien_aktif'=>true,
            'kelompok' => "Kewajiban"
        ), array(
            'order'=>'hakpasien_urutan'
        ));

        $session_ceklis_kewajiban_pasien = Yii::app()->user->getState('ceklis_kewajiban_pasien_'.$this->id);
        $session_sudah_baca_kewajiban = Yii::app()->user->getState('kewajiban_pasien_sudah_baca_'.$this->id);

        $if_sudah_baca = (!empty($session_sudah_baca_kewajiban) && $session_sudah_baca_kewajiban == 1) || $model->isbacahakpasien == true;

        // var_dump((!empty($session_sudah_baca) && $session_sudah_baca == 1), $model->isbacahakpasien); die;
            
        foreach ($hak as $item) { ?>

            <li>
                <?php echo CHtml::checkBox('cek_kewajiban_pasien['.$item->hakpasien_id.']', 
                        !empty($session_ceklis_kewajiban_pasien)
                        && in_array($item->hakpasien_id, $session_ceklis_kewajiban_pasien)
                    , array(
                    'class'=>'ceklis_kewajiban_pasien_baca',
                    'onclick'=>'setCeklisKewajibanPasien()',
                    'data-id'=>$item->hakpasien_id,
                ))." ".$item->hakpasien_nama; ?>
            </li>

        <?php } ?>
    </ul>

</div>

<?php echo CHtml::button('Sudah dibaca oleh Pasien?', array(
    'class'=>'btn btn-green', 'id'=>'btn_hak_pasien_sudah_baca',
    'onclick'=>'setBacaSemua()',
    'disabled'=>$if_sudah_baca,
)); ?>

<?php
    // if($if_sudah_baca == 1){
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printHakPasien();return false"));
    // }else{
        // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"return false", 'disabled'=> TRUE,'style'=>'cursor:not-allowed;')).'&nbsp;';
    // }
?>

<script>
    
    function printHakPasien() {
        window.open('<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/printHak',array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }

    var pendaftaran_id = <?php echo !empty($model->pendaftaran_id) ? $model->pendaftaran_id : 0; ?>;
    var sudah_baca = <?php echo $if_sudah_baca ? 1 : 0; ?>; 
    
    function pilih_semua_hak_pasien() {
        $(".ceklis_hak_pasien_baca").prop('checked', $(".ceklis_hak_pasien_semua").is(':checked'));
        setCeklisHakPasien();
    }
    
    function setCeklisHakPasien() {
        var ceklis = new Array();
            
        $(".ceklis_hak_pasien_baca:checked").each(function() {
            ceklis.push($(this).data('id'));
        });
        

        $.post('<?php echo $this->createUrl('catatCeklisHakPasien'); ?>', {
            ceklis: ceklis
        }, function(data) {
            if (data.ok == 1) {
                cekTombolCeklis();
                console.log("Hak Pasien di Ceklis", data.list);
            }
        }, 'json');
    }

    function pilih_semua_kewajiban_pasien() {
        $(".ceklis_kewajiban_pasien_baca").prop('checked', $(".ceklis_kewajiban_pasien_semua").is(':checked'));
        setCeklisKewajibanPasien();
    }
    
    function setCeklisKewajibanPasien() {
        var ceklis = new Array();
            
        $(".ceklis_kewajiban_pasien_baca:checked").each(function() {
            ceklis.push($(this).data('id'));
        });
        

        $.post('<?php echo $this->createUrl('catatCeklisKewajibanPasien'); ?>', {
            ceklis: ceklis
        }, function(data) {
            if (data.ok == 1) {
                cekTombolCeklis();
                console.log("Kewajiban Pasien di Ceklis", data.list);
            }
        }, 'json');
    }
    
    function setBacaSemua() {
        $.post('<?php echo $this->createUrl('setSudahDibaca'); ?>', {
            pendaftaran_id: pendaftaran_id,
        }, function(data) {
            if (data.ok) {
               
                sudah_baca = 1;
                // $("#dialog-hak-pasien").dialog("close");
                $(".cetakHak").removeAttr("disabled");
                $("#btn_hak_pasien_sudah_baca").prop("disabled", true);
                $(".ceklis_hak_pasien_baca").prop("checked", true).prop("disabled", true);
                $(".ceklis_kewajiban_pasien_baca").prop("checked", true).prop("disabled", true);
            }
        }, 'json');
    }
    
    function cekTombolCeklis() {
        if (sudah_baca != 1 && $(".ceklis_hak_pasien_baca:checked").length == $(".ceklis_hak_pasien_baca").length && $(".ceklis_kewajiban_pasien_baca:checked").length == $(".ceklis_kewajiban_pasien_baca").length) {
            $("#btn_hak_pasien_sudah_baca").prop("disabled", false);
        } else {
            $("#btn_hak_pasien_sudah_baca").prop("disabled", true);
        }
    }
    
    $(document).ready(function() {
        // $("#tampil").hide();
        
        <?php if($isdetail == true){ ?>
            $("#btn_hak_pasien_sudah_baca").hide();
            $(".cetakHak").removeAttr("disabled");
            $(".ceklis_hak_pasien_baca, .ceklis_hak_pasien_semua").prop("disabled", true);
                $(".ceklis_kewajiban_pasien_baca, .ceklis_kewajiban_pasien_semua").prop("disabled", true);
        <?php }else{ ?>
            $(".cetakHak").prop("disabled", true);
            $("#btn_hak_pasien_sudah_baca").show();
            if (sudah_baca != 1) {
                $(".ceklis_hak_pasien_baca, .ceklis_hak_pasien_semua").prop("disabled", false);
                $(".ceklis_kewajiban_pasien_baca, .ceklis_kewajiban_pasien_semua").prop("disabled", false);
                // $(".cetakHak").prop("disabled", true);
                <?php if (!empty($model->pendaftaran_id)): ?>
                    $("#btn_hak_pasien").prop("disabled", false);
                <?php else: ?>
                if (otoval == 1) {
                    $("#btn_hak_pasien").prop("disabled", false);
                }
                <?php endif; ?>
                cekTombolCeklis();
            } else {
                $(".ceklis_hak_pasien_baca, .ceklis_hak_pasien_semua").prop("checked", true).prop("disabled", true);
                $(".ceklis_kewajiban_pasien_baca, .ceklis_kewajiban_pasien_semua").prop("checked", true).prop("disabled", true);
                $("#btn_hak_pasien_sudah_baca").prop("disabled", true);
                $("#btn_hak_pasien").prop("disabled", true);
                // $(".cetakHak").prop("disabled", false);
            }
        <?php } ?>
        
    });
    
</script>
