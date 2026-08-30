<?php
    $print = !empty($print)?$print:0;
    $profil = ProfilrumahsakitM::model()->find();
    $namars = !empty($profil)?$profil->nama_rumahsakit:'';
?>
<table class="w-100 prinout no-grid" style="text-align: center;">
    <tr>
        <th><h3 style="color:#333;"><b>SURAT KETERANGAN KEMATIAN</b></h3></th>
    </tr>
    <tr>
        <td style="text-align: left;">
            Nomor Urut Kematian Bulan Ini : <?= 'RM 46c. 15' ?>
        </td>
    </tr>    
</table>

<br/>

<table class="w-100 prinout no-grid" style="padding-left: 20px;">
    <tr>
        <th colspan="4" align="left"><b>IDENTITAS JANAZAH (SESUAI KTP)</b></th>
    </tr>
    <tr>
        <td width="5%">1.</td>
        <td width="20%">Nama Lengkap</td>
        <td width="5%">:</td>
        <td><?= ($print)?$model->pasien_nama:$form->textField($model,'pasien_nama',['readonly'=>true]) ?></td>
    </tr>    
    <tr>
        <td>2.</td>
        <td>Nomor Rekam Medis </td>
        <td>:</td>
        <td><?= ($print)?$model->pasien_no_rekam_medik:$form->textField($model,'pasien_no_rekam_medik',['readonly'=>true]) ?></td>
    </tr> 
    <tr>
        <td>3.</td>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?= ($print)?$model->pasien_jeniskelamin:$form->textField($model,'pasien_jeniskelamin',['readonly'=>true]) ?></td>
    </tr> 
    <tr>
        <td>4.</td>
        <td>Tempat/Tanggal Lahir</td>
        <td>:</td>
        <td><?= ($print)?$model->pasien_tempat_lahir.'/'.$model->pasien_tanggal_lahir:$form->textField($model,'pasien_tempat_lahir',['readonly'=>true]).'/'.$form->textField($model,'pasien_tanggal_lahir',['readonly'=>true]) ?></td>
    </tr> 
    <tr>
        <td>5.</td>
        <td>Alamat Tempat Tinggal</td>
        <td>:</td>
        <td height="80px"><?= ($print)?$model->pasien_alamat:$form->textField($model,'pasien_alamat',['readonly'=>true]) ?></td>
    </tr>
    <tr>
        <td>6.</td>
        <td>Tanggal Meninggal</td>
        <td>:</td>
        <td height="80px">
            <?php 
                if ($print){
                    echo $model->tanggal_meninggal;
                }else{
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tanggal_meninggal',
                        'mode' => 'date',
                        'options' => array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
                                'yearRange' => "-150:+0",
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'placeholder' => 'DD MM YYYY', 'class' => 'dtPicker2 span2 datetime required', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        ),
                    ));
                }                                
            ?>
        </td>
    </tr>
    <tr>
        <td>7.</td>
        <td>Tempat Meninggal</td>
        <td>:</td>
        <td>
            -
        </td>
    </tr>
    <tr>
        <td>8.</td>
        <td>Pemeriksaan Jenazah/Nama</td>
        <td>:</td>
        <td height="80px"><?= ($print)?$model->pemeriksa_pasienmeninggal:$form->dropDownList($model,'pemeriksa_pasienmeninggal', [
            'Paramedis' => 'Paramedis',
            'Dokter' => 'Dokter'
        ],['empty'=>'-- Pilih --']).'*)' ?></td>
    </tr>
    <tr>
        <td>9.</td>
        <td>Tanggal Pemeriksaan</td>
        <td>:</td>
        <td height="80px">
            <?php 
                if ($print){
                    echo $model->tanggal_pemeriksaan;
                }else{
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tanggal_pemeriksaan',
                        'mode' => 'date',
                        'options' => array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
                                'yearRange' => "-150:+0",
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'placeholder' => 'DD MM YYYY', 'class' => 'dtPicker2 span2 datetime required', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        ),
                    ));
                }                                
            ?>
        </td>
    </tr>
    <tr>
        <td>10.</td>
        <td>Jenis Pemeriksaan</td>
        <td>:</td>
        <td height="80px"><?= ($print)?$model->jenis_pemeriksaan:$form->dropDownList($model,'jenis_pemeriksaan', [
            'Pemeriksaan Luar' => 'Pemeriksaan Luar',
            'Autopsy' => 'Autopsy'
        ],['empty'=>'-- Pilih --']).'*)' ?></td>
    </tr>
</table>

<br/>
<table class="w-100 prinout no-grid" style="padding-left: 20px;">
    <tr>
        <th colspan="4" align="left"><b>PENYEBAB KEMATIAN</b></th>
    </tr>
    <tr>
        <td width="5%">A.</td>
        <td colspan="3"><?= ($model->kondisikeluar_id == Params::KONDISIKELUAR_ID_MENINGGAL_2)?'Kematian umur 0 - 2 hari':'Kematian umur 3 hari keatas' ?></td>        
    </tr> 
    <tr>
        <td>&nbsp;</td>
        <td>
            <table class="w100 prinout grid" >
                <tr>
                    <td width="5%">1.</td>
                    <td>Penyebab Langsung <?= ($print)?$model->penyebab_langsung:$form->textField($model,'penyebab_langsung') ?></td>
                    <td width="7%">ICD 10</td>
                    <td><?= $model->diagnosa_nama ?></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Penyakit yang mendasari <?= ($print)?$model->penyebab_yangmendasari:$form->textField($model,'penyebab_yangmendasari') ?></td>
                    <td>ICD 10</td>
                    <td><?= $model->diagnosa_nama2 ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table class="w-100 prinout no-grid" style="text-align: center;" width="100%">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?= $profil->propinsi->propinsi_nama.', '.date('d-m-Y') ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Dokter Penanggung Jawab</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td rowspan="5" colspan="2">            
            <table>
                <tr>
                    <td colspan="3" style="text-align:left;">
                        <b>Catatan :</b><br/>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">Lembar Asli</td>
                    <td>:</td>
                    <td>Untuk ahli waris yang bersangkutan</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Lembar Copy</td>
                    <td>:</td>
                    <td style="text-align: left;">Untuk Arsip di status RM</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: left;">
                        <i>*)Coret yang tidak perlu</i>
                    </td>
                </tr>
            </table>
        </td>
        <td colspan="2">&nbsp;</td>
    </tr>
     <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
     <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>       
        <td><?= $model->dpjp_nama ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>       
        <td>Stempel RS, Nama Tenang & Jabatan</td>
        <td>&nbsp;</td>
    </tr>
</table>













