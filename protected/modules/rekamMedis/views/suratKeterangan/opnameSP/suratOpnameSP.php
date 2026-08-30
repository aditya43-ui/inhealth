<?php 
$format = new MyFormatter();
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
if(!empty($_GET['pendaftaran_id'])){
    $pendaftaran_id = $_GET["pendaftaran_id"];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $model->mengetahui_surat = $modPendaftaran->pegawai->nama_pegawai;
    if(!empty($modPendaftaran->pasienadmisi_id)){
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        $model->mengetahui_surat = (isset($modAdmisi->pasienadmisi_id) ? $modAdmisi->pegawai->nama_pegawai : "");
    }else{
        $modAdmisi = new PasienadmisiT;
        $modAdmisi->tgladmisi = date('Y-m-d')." 00:00:00";
        $modAdmisi->tglpulang = date('Y-m-d')." 00:00:00";
    }
}else{
    $model->tglsurat = date('Y-m-d');
}

if(!empty($_GET['suratketerangan_id'])){
    $model = SuratketeranganR::model()->findByPk($_GET['suratketerangan_id']);
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p{
        text-indent: 50px;
        text-align: justify;
    }
</style>
<TABLE>
<div>
    <div>
        <TABLE ALIGN="CENTER" style="margin-left:100px; text-align: center;">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN OPNAME (SUDAH PULANG)"; ?></U></span></B>
                </td>
            </tr>
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4>NO : <?php echo CHtml::activeTextField($model,'nomorsurat', array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></span></B>
                    
                    <?php
                        echo CHtml::activeHiddenField($model,'suratketerangan_id',array()); 
                    ?>
                </td>
            </tr>
        </TABLE>
    </div>
    </br><br><br><br>
    <p align="justify">
        Saya yang bertanda tangan dibawah ini, Dokter <?php echo $data->nama_rumahsakit;?>, dengan ini menerangkan bahwa:
    </p>
    <p align="justify">
        <table width="100%" style="width:500px;margin-left:80px;">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->nama_pasien, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Umur/Tgl. lahir</td>
                <td>:</td>
                <td>
                    <?php echo CHtml::textField('nama_pasien',$modPendaftaran->umur, array('readonly'=>false,
                            'class'=>'span2',
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo CHtml::textField('nama_pasien',MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir), array('readonly'=>false,
                            'class'=>'span2',
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->jeniskelamin, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>No. RK</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->no_rekam_medik, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->alamat_pasien, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
        </table>
        <p align="justify">
            Adalah benar telah dirawat inap / opname di <?php echo $data->nama_rumahsakit;?>.
            <table width="100%" style="width:500px;margin-left:80px;">
            <tr>
                <td>Tanggal Masuk</td>
                <td>:</td>
                <td>
                    <?php 
                        $modAdmisi->tgladmisi = (!empty($modAdmisi->tgladmisi) ? $format->formatDateTimeForUser($modAdmisi->tgladmisi) : '');
                        $this->widget('MyDateTimePicker', array(
                            'model'=> $modAdmisi,
                            'attribute'=>'tgladmisi',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
//                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                    ?>
                </td>
            </tr>
            <?php if(!empty($_GET['pendaftaran_id'])){
                    if(!empty($modAdmisi->tglpulang)){
            ?>
                <tr>
                    <td>Tanggal Pulang</td>
                    <td>:</td>
                    <td>
                         <?php 
                            $modAdmisi->tglpulang = (!empty($modAdmisi->tglpulang) ? $format->formatDateTimeForUser($modAdmisi->tglpulang) : '');
                            $this->widget('MyDateTimePicker', array(
                                'model'=>$modAdmisi,
                                'attribute'=>'tglpulang',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
//                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                        ?>
                    </td>
                </tr>
               
            <?php }else{ echo ""; }}else{ ?>
               <tr>
                    <td>Tanggal Pulang</td>
                    <td>:</td>
                    <td>
                         <?php 
                            $modAdmisi->tglpulang = (!empty($modAdmisi->tglpulang) ? $format->formatDateTimeForUser($modAdmisi->tglpulang) : '');
                            $this->widget('MyDateTimePicker', array(
                                'model'=>$modAdmisi,
                                'attribute'=>'tglpulang',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
//                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                        ?>
                    </td>
                </tr> 
           <?php } ?>
        </table>
        </p>
        <p align="justify">
           Demikianlah Surat Keterangan Opname ini diperbuat untuk dapat dipergunakan seperlunya, atas kerjasamanya diucapkan Terima Kasih.
        </p>
</div><br><br><br><br><br>
<div style="margin-left: 50px">
    <?php $date = date('Y-m-d'); ?>
    <?php echo $data->kecamatan->kecamatan_nama ;?>, <?php echo $format->formatDateTimeForUser($date); ?>
<br><br><br><br><br>
<!--(_________________)-->
<?php
    echo CHtml::activeDropDownList($model,'mengetahui_surat', CHtml::listData(DokterV::model()->findAll(array(
        'condition'=>'pegawai_aktif = true AND kelompokpegawai_id = '.Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
        'order'=>'nama_pegawai'
    )), 'namaLengkap', 'namaLengkap'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)"));
?>
</div>
</TABLE>