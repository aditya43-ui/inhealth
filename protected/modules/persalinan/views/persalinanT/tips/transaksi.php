<span class="required"><i>Bagian dengan tanda * harus diisi.</i></span>
<p>
<table style="width:100%; padding: none; border: none;">
    <tr>
        <td style = "verticl-align:middle">1. </td>
        <td>Icon <i class="entypo-calendar"></i><i class="icon-time"></i>
            berfungsi untuk menentukan tanggal dan waktu persalinan .</td>
    </tr>
    <tr>
        <td style = "verticl-align:middle">2. </td>
        <td>
            <fieldset class='box'>
                <legend class="rim"><?php echo CHtml::checkBox('tipsRiwayatPasien',true, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?> &nbsp; </legend>
                <div id="tipsdivRiwayatPasien" class="control-group">
                    form       
                </div>
            </fieldset>
            Checkbox di checklist, maka akan menampilkan form, dan ketika checkbox di uncheck maka akan menyembunyikan form.
        </td>
    </tr>
    <tr>  
        <td style = "verticl-align:middle">3. </td>
        <td>Gunakan tombol ini  <a class="btn btn-primary"><i class="entypo-check"></i> Simpan</a>
             berfungsi untuk menyimpan data.</td>
    </tr> 
    <tr>
        <td style = "verticl-align:middle">4. </td>
        <td>Gunakan tombol ini <a class="btn btn-danger"><i class="entypo-arrows-ccw"></i>
            Ulang</a> untuk mengulang kembali inputan.</td>
    </tr>
</table>
</p>
<script>
    $("#tipsRiwayatPasien").change(function(){
    $('#tipsdivRiwayatPasien').slideToggle(500);
});
</script>

