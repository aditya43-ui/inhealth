<table width="100%" style="margin-top: 10px;" class="tab_statistik">
    <tr>
        <td id="label_jmlpasien"><?php echo (strpos(strtolower($loket->loket_namalain), 'pasien') !== false)?"":"PASIEN"?> <?php echo strtoupper($loket->loket_namalain); ?></td>
        <td id="jmlpasien">000</td>
    </tr>
    <tr>
        <td id="label_jmlmenunggu">PASIEN MENUNGGU</td>
        <td id="jmlmenunggu">000</td>
    </tr>
    <tr>
        <td id="label_jmlterlewatkan">PASIEN YANG TIDAK ADA</td>
        <td id="jmlterlewatkan">000</td>
    </tr>
    <tr>
        <td id="label_jmlterdaftar">PASIEN SUDAH DAFTAR</td>
        <td id="jmlterdaftar">000</td>
    </tr>
</table>