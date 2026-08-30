<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
	'id'=>'batalkirimdiet-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
        'htmlOptions'=>array(
            'onKeyPress'=>'return disableKeyPress(event)'
        ),
    )
);

?>
<table class='table'>
    <tr>
        <td>
            <b><?php echo CHtml::encode($model->getAttributeLabel('jenispesanmenu')); ?>:</b>
            <?php echo CHtml::encode($model->jenispesanmenu); ?>
            <br>
            <b><?php echo CHtml::encode($model->getAttributeLabel('nokirimmenu')); ?>:</b>
            <?php echo CHtml::encode($model->nokirimmenu); ?>
            <br>
            <b><?php echo CHtml::encode($model->getAttributeLabel('tglkirimmenu')); ?>:</b>
            <?php echo CHtml::encode($model->tglkirimmenu); ?>
            <br>

        </td>
        <td>
            <b><?php echo CHtml::encode($model->getAttributeLabel('create_time')); ?>:</b>
            <?php echo CHtml::encode($model->create_time); ?>
            <br>
        </td>
    </tr>   
</table>
<style>
    .table thead tr th{
        vertical-align:middle;
    }
</style>
<p class="help-block"><?php echo "Pilih menu diet yang akan dibatalkan"?></p>
    <?php echo $form->errorSummary($modelKirim); ?>

<div>
    <?php echo CHtml::hiddenField('idKirimDiet', '', array('readonly'=>TRUE)); ?>
    <?php if(count((array)$modDetail) > 0){ ?>
    <div>
        <table class="table table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th style="text-align:center;"><p style="margin: 0; text-align: center;"><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll();"></p></th>
                    <th style="text-align:center;">Instalasi/ <br> Ruangan</th>
                    <th style="text-align:center;">No. Pendaftaran/ <br> No. RM </th>
                    <th style="text-align:center;">Nama Pasien</th>
                    <th style="text-align:center;">Umur</th>
                    <th style="text-align:center;">Jenis Kelamin</th>
                    <th style="text-align:center;">Menu Diet</th>
                    <th style="text-align:center;">Jumlah</th>
                    <th style="text-align:center;">Satuan URT</th>
                    <th style="text-align:center;">Jenis Makanan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($modDetail as $i=>$detail){
                ?>
                <tr>
                    <td><p style="margin: 0; text-align: center;">
                        <?php
                            echo CHtml::checkBox('KirimmenupasienT['.$i.'][checkList]',true,array('class'=>'cekList','onclick'=>'checkList(this)')) ;
                            echo CHtml::hiddenField('KirimmenupasienT['.$i.'][kirimmenupasien_id]',$detail->kirimmenupasien_id); 
                            echo CHtml::hiddenField('KirimmenupasienT['.$i.'][pendaftaran_id]',$detail->pendaftaran_id); 
                            echo CHtml::hiddenField('KirimmenupasienT['.$i.'][pasienadmisi_id]',$detail->pasienadmisi_id); 
                            echo CHtml::hiddenField('KirimmenupasienT['.$i.'][pasien_id]',$detail->pasien_id); 
                            echo CHtml::hiddenField('KirimmenupasienT['.$i.'][satuanjml_urt]',$detail->satuanjml_urt); 
                            echo CHtml::hiddenField('KirimmenupasienT['.$i.'][penjamin_id]', $detail->pendaftaran->penjamin_id);
                            echo CHtml::hiddenField('KirimmenupasienT['.$i.'][jeniskasuspenyakit_id]', $detail->pendaftaran->jeniskasuspenyakit_id);
                            echo CHtml::hiddenField('KirimmenupasienT['.$i.'][kirimmenudiet_id]', $detail->kirimmenudiet_id);
                            echo CHtml::hiddenField('KirimmenupasienT['.$i.'][pesanmenudetail_id]', $detail->pesanmenudetail_id);
                            echo CHtml::hiddenField('KirimmenupasienT['.$i.'][menudiet_id]', $detail->menudiet_id);
                        ?>                        
                        </p></td>
                    <td><?php echo $detail->pendaftaran->instalasi->instalasi_nama."<br>".$detail->pendaftaran->ruangan->ruangan_nama; ?></td>
                    <td><?php echo $detail->pendaftaran->no_pendaftaran."<br>".$detail->pendaftaran->pasien->no_rekam_medik; ?></td>
                    <td><?php echo $detail->pasien->nama_pasien ?></td>
                    <td><?php echo $detail->pendaftaran->umur ?></td>
                    <td><?php echo $detail->pasien->jeniskelamin ?></td>
                    <td><?php echo $detail->jeniswaktu->jeniswaktu_nama." - ".$detail->menudiet->menudiet_nama ?></td>
                    <td><p style="margin: 0; text-align: center;"><?php echo $detail->jml_kirim; ?></p></td>
                    <td><p style="margin: 0; text-align: center;"><?php echo $detail->satuanjml_urt; ?></p></td>
                    <td><p style="margin: 0; text-align: center;">-</p></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php }else if(count((array)$modPegawai) > 0) { 
        
        $header_nama = "Nama Pegawai/Tamu";
        $pesan = PesanmenudietT::model()->findByPk($model->pesanmenudiet_id);
        $is_pendamping = false;
        $nama_pasien_pendamping = null;
        $pasien = null;

        if (!empty($pesan) && !empty($pesan->pendaftaran_id) && $model->jenispesanmenu == Params::JENISPESANMENU_PENDAMPING) {
            $header_nama = "Nama Pasien";
            $pasien = $pesan->pendaftaran->pasien;
            $is_pendamping = true;
            $nama_pasien_pendamping = $pasien->namadepan.$pasien->nama_pasien;
        }
        ?>
    <div>
        <table class="table table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th style="text-align:center;"><p style="margin: 0; text-align: center;"><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll();"></p></th>
                    <th style="text-align:center;">Instalasi/ <br> Ruangan</th>
                    <th style="text-align:center;"><?php echo $header_nama ?></th>
                    <th style="text-align:center;">Menu Diet</th>
                    <th style="text-align:center;">Jumlah</th>
                    <th style="text-align:center;">Satuan URT</th>
                    <th style="text-align:center;">Jenis Makanan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($modPegawai as $i=>$detail){
                ?>
                <tr>
                    <td><p style="margin: 0; text-align: center;">
                        <?php
                            echo CHtml::checkBox('KirimmenupegawaiT['.$i.'][checkList]',true,array('class'=>'cekList','onclick'=>'checkList(this)')) ;
                            echo CHtml::hiddenField('KirimmenupegawaiT['.$i.'][kirimmenupegawai_id]',$detail->kirimmenupegawai_id); 
                            echo CHtml::hiddenField('KirimmenupegawaiT['.$i.'][pegawai_id]',$detail->pegawai_id); 
                            echo CHtml::hiddenField('KirimmenupegawaiT['.$i.'][satuanjml_urt]',$detail->satuanjml_urt); 
                            echo CHtml::hiddenField('KirimmenupegawaiT['.$i.'][kirimmenudiet_id]', $detail->kirimmenudiet_id);
                            echo CHtml::hiddenField('KirimmenupegawaiT['.$i.'][pesanmenupegawai_id]', $detail->pesanmenupegawai_id);
                            echo CHtml::hiddenField('KirimmenupegawaiT['.$i.'][menudiet_id]', $detail->menudiet_id);
                        ?>
                    </td>
                    <td><?php echo $detail->ruangan->instalasi->instalasi_nama."<br>".$detail->ruangan->ruangan_nama; ?></td>
                    <td><?php echo $is_pendamping ? $pasien->namadepan.$pasien->nama_pasien : $detail->pegawai->nama_pegawai; ?> </td>
                    <td><?php echo $detail->jeniswaktu->jeniswaktu_nama." - ".$detail->menudiet->menudiet_nama ?></td>
                    <td><p style="margin: 0; text-align: center;"><?php echo $detail->jml_kirim; ?></p></td>
                    <td><p style="margin: 0; text-align: center;"><?php $detail->satuanjml_urt; ?></p></td>
                    <td><p style="margin: 0; text-align: center;">-</p></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php }else{ ?>
    <div>
        <table class="table table-bordered table-striped table-condensed">
            <tr>
                <td>Data tidak ditemukan</td>
            </tr>
        </table>
    </div>
    <?php } ?>
</div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                                array('class' => 'btn btn-danger', 'onclick'=>'konfirmasiKirim(event);','onKeypress'=>'return formSubmit(this,event)')); ?>

        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
                                                                array('class' => 'btn btn-default','onclick'=>'cancel();')); ?>
    </div>

<?php $this->endWidget(); ?>
<script>
function checkList(obj){
    if ($(obj).is(":checked")) {
           $(obj).attr('checked',true);
           $(obj).val(1);
    } else {
           $(obj).removeAttr('checked');
           $(obj).val(0);
    }
}

function checkAll(){
    if ($("#checkListUtama").is(":checked")) {
        $('.cekList').each(function(){
           $(this).attr('checked',true);
           $(this).val(1);
        })
    } else {
       $('.cekList').each(function(){
           $(this).removeAttr('checked');
           $(this).val(0);
        })
    }
}
function konfirmasiKirim(event){
//    var answer = confirm('Yakin Akan Membatalkan Pemesanan Diet?');
    
//    if(answer){
      $('#batalkirimdiet-form').submit();
      return true;
//    }else{
//        event.preventDefault();         
//        return false;
//    }
}
function cancel(){
    $('#dialogBatalKirim').dialog('close');
}
</script>