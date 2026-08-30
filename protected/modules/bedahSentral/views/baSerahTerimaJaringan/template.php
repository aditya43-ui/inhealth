<?php
    $print = !empty($print)?$print:0;
    $profil = ProfilrumahsakitM::model()->find();
    $namars = !empty($profil)?$profil->nama_rumahsakit:'';
?>
<table class="w-100 prinout no-grid" style="text-align: center;" width="100%">
    <tr>
        <th align="center" style="text-align:center;"><b>BERITA ACARA SERAH TERIMA JARINGAN/IMPLANT</b></th>
    </tr>
    <tr>
        <th align="center" style="text-align:center;"><b>Bismillahirohmanirohim</b></th>
    </tr>
</table>
<br/>

<table class="w-100 prinout no-grid">
    <tr>
        <td colspan="4">Saya yang bertanda tangan dibawah ini :</td>
    </tr>    
    <tr>
        <td width="10%">Nama</td>
        <td width="5">:</td>
        <td><?= ($print)?$model->petugas_nama:$form->textField($model,'petugas_nama',['class'=>'required', 'readonly'=>true]) ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td><?= (($print)?$model->jabatan_nama:$form->textField($model,'jabatan_nama'))?></td>
        <td></td>
    </tr>    
    <tr>
        <td colspan="4"><b><u>Pihak Pertama</u></b></td>
    </tr>       
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td><?= ($print)?$model->nama_kepenanggungjawab:$form->textField($model,'nama_kepenanggungjawab',['class'=>'required']) ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?= ($print)?$model->alamat:$form->textArea($model,'alamat') ?></td>
    </tr>
     <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?= ($print)?$model->namapasien:$form->textField($model,'namapasien',['class'=>'required']) ?></td>
    </tr>
    <tr>
        <td>No RM</td>
        <td>:</td>
        <td><?= (($print)?$model->nomor_rm:$form->textField($model,'nomor_rm')) ?></td>
    </tr>
    <tr>
        <td>Diagnosa</td>
        <td>:</td>
        <td><?= ($print)?$model->diagnosa:$form->textArea($model,'diagnosa',['rows'=>7, 'readonly'=>true]) ?></td>
    </tr>    
    <tr>
        <td colspan="4">
            Yang selanjutnya disebut sebagai <b><u>Pihak Pertama</u></b>
        </td>
    </tr>
    <tr>
        <td> Pada hari ini</td>
        <td colspan="3">
            <?php 
                if ($print){
                    echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->create_time)));
                }else{
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'create_time',
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
        <td colspan="4">Untuk di rawat Inap / ODC di <?= $namars ?>, serta sanggup untuk :</td>
    </tr>
    <tr>
        <td colspan="4">
            Pihak pertama menyerahkan jaringan/implant yang sudah dipulasarakan sesuai dengan syariah atas nama pasien terebut 
            dan atas kepada pihak kedua yang selanjutnya perlakuan terhadap jaringan tersebut menjadi tanggung jawab pihak kedua. 
            Pihak kedua menerima jaringan/implant yang kemudian menentukan perlakuan.
            <ol>
                <li>Jaringan/Implant dibawa pulang.</li>
                <li>Jaringan/Implant diserahkan ke pihak pertama untuk dilakukan pemeriksaan di laboratorium</li>                
            </ol>
        </td>
    </tr>
    <tr>
        <td colspan="4">Demikian serah terima ini dibuat untuk dapat digunakan sebagaimana mestinya.</td>
    </tr>
</table>

<br/>

<table class="w-100 prinout no-grid" style="text-align: center;" width="100%">   
    <tr>
        <td width="10">&nbsp;</td>
        <td><b><u>Pihak Pertama</u></b></td>
        <td><b><u>Pihak Kedua</u></b></td>
        <td width="10">&nbsp;</td>
    </tr>
    <tr>
        <td width="10">&nbsp;</td>
        <td>(yang menerima)</td>
        <td>(yang menyerahkan)</td>
        <td width="10">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td class="pihakpertama"><?= (($print)?$model->pihakpenerima:$form->textField($model,'pihakpenerima',['class'=>'required'])) ?></td>
        <td class="pihakkedua"><?= (($print)?$model->pihakmenyerahkan:$form->textField($model,'pihakmenyerahkan',['class'=>'required'])) ?></td>
        <td>&nbsp;</td>
    </tr>    
</table>













