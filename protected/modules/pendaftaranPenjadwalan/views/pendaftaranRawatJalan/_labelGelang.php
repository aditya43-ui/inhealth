<fieldset class="box">
    <legend class="rim">Label Gelang</legend>
    <table class="table table-condensed" width="100%">
        <tr>
            <td width="20%">No. Rekam Medik</td>
            <td width="10%">:</td>
            <td><?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td width="20%">Nama</td>
            <td width="10%">:</td>
            <td><?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeId($modPendaftaran->pasien->tanggal_lahir); ?></td>
        </tr>
        <tr>
            <td>Pilih Gelang</td>
            <td></td>
            <td>
                <?php echo CHtml::dropDownList('gelangPasien', '', array('1'=>'Gelang Anak', '2'=>'Gelang Dewasa')); ?>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php

        echo CHtml::link("<i class=icon-form-print></i> Print", "javascript:printLabelGelang(" . $modPendaftaran->pasien_id . ", " . $modPendaftaran->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print label gelang "));
                                 
        // echo CHtml::link(Yii::t('mds', '{icon} Print ', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printLabelGelang(" . $data->pasien_id . ", " . $data->pendaftaran_id . ");return false")
        // );
        ?>
    </div>
</fieldset>
<script type="text/javascript">

    function printLabelGelang(pasien_id, pendaftaran_id)
    {
        var gelang = $('#gelangPasien').val();
     
        if(gelang == '1'){
     window.open('<?php echo $this->createUrl('printLabelGelang', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=793,height=1122');
        }
        else{
        
             window.open('<?php  echo $this->createUrl('printLabelGelang', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=793,height=1122');
        }
        
    }

</script>