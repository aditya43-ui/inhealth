<tr>
    <td width="5%"> </td>
    <td width="20%"> Nama </td>
    <td> : <?php echo $form->textField($modPenanggungJawab, 'nama_pj', array('readonly' => true, 'placeholder' => 'Nama', 'class' => 'span3 angkahuruf-only form-control', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?></td>
</tr>
<tr>
    <td> </td>
    <td> Tempat/Tanggal Lahir </td>
    <td> : 
        <?php
        $val = $modPenanggungJawab->tempatlahir_pj . "/" . MyFormatter::formatDateTimeForUser($modPenanggungJawab->tgllahir_pj);
        $modPenanggungJawab->tempatlahir_pj = $val;
        ?>
        <?php echo $form->textField($modPenanggungJawab, 'tempatlahir_pj', array('readonly' => true, 'placeholder' => 'Tempat/Tanggal Lahir', 'class' => 'span3 form-control', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?></td>
</tr>
<tr>
    <td> </td>
    <td> Jenis Kelamin </td>
    <td> : <?php echo $form->textField($modPenanggungJawab, 'jeniskelamin', array('readonly' => true, 'placeholder' => 'Jenis Kelamin', 'class' => 'span3 angkahuruf-only form-control', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?></td>
</tr>
<tr>
    <td> </td>
    <td> No Identitas </td>
    <td> : <?php echo $form->textField($modPenanggungJawab, 'no_identitas', array('readonly' => true, 'placeholder' => 'No. Identitas', 'class' => 'span3 angkahuruf-only form-control', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?></td>
</tr>
<tr>
    <td> </td>
    <td> Hubungan dengan pasien </td>
    <td> : <?php echo $form->textField($modPenanggungJawab, 'hubungankeluarga', array('readonly' => true, 'placeholder' => 'Hubungan dengan pasien', 'class' => 'span3 angkahuruf-only form-control')); ?></td>
</tr>
<tr>
    <td> </td>
    <td> Alamat </td>
    <td> : <?php echo $form->textArea($modPenanggungJawab, 'alamat_pj', array('readonly' => true, 'placeholder' => 'Alamat', 'class' => 'span3 angkahuruf-only form-control')); ?></td>
</tr>
<tr>
    <td colspan="3"> <br> </td>
</tr>
<tr>
    <td> </td>
    <td colspan="2">
        Adalah diri saya sendiri sebagai  <?php echo $form->textField($modPenanggungJawab, 'hubungankeluarga', array('readonly' => true, 'placeholder' => 'Hubungan dengan pasien', 'class' => 'span3 angkahuruf-only form-control')); ?>
        Penanggung jawab pasien
    </td>
</tr>
<tr>
    <td width="5%"> </td>
    <td width="20%"> Nama </td>
    <td> : <?php echo $form->textField($modPasien, 'nama_pasien', array('readonly' => true, 'placeholder' => 'Nama', 'class' => 'span3 angkahuruf-only form-control', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?></td>
</tr>
<tr>
    <td> </td>
    <td> No. Rekam Medis </td>
    <td> : <?php echo $form->textField($modPasien, 'no_rekam_medik', array('readonly' => true, 'placeholder' => 'No. Identitas', 'class' => 'span3 angkahuruf-only form-control', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?></td>
</tr>
<tr>
    <td> </td>
    <td> Tempat/Tanggal Lahir </td>
    <td> : 
        <?php
        $val_2 = $modPasien->tempat_lahir . "/" . MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir);
        $modPasien->tempat_lahir = $val_2;
        ?>
        <?php echo $form->textField($modPasien, 'tempat_lahir', array('readonly' => true, 'placeholder' => 'Tempat/Tanggal Lahir', 'class' => 'span3 form-control', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?></td>
</tr>
<tr>
    <td> </td>
    <td> Umur </td>
    <td> : <?php echo $form->textField($modPendaftaran, 'umur', array('readonly' => true, 'placeholder' => 'Umur', 'class' => 'span3 angkahuruf-only form-control')); ?></td>
</tr>
<tr>
    <td> </td>
    <td> Jenis Kelamin </td>
    <td> : <?php echo $form->textField($modPasien, 'jeniskelamin', array('readonly' => true, 'placeholder' => 'Jenis Kelamin', 'class' => 'span3 angkahuruf-only form-control', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?></td>
</tr>