<table width="100%" style="margin-top: 10px;">
    <tr>
        <td id="label_jmlpasien">JUMLAH <?php echo (strpos(strtolower($loket->modelantrian_nama), 'pasien') !== false)?"":"PASIEN"?> <?php echo strtoupper($loket->modelantrian_nama); ?></td>
        <td id="jmlpasien">000</td>
    </tr>
    <tr>
        <td id="label_jmlmenunggu">PASIEN MENUNGGU</td>
        <td id="jmlmenunggu">000</td>
    </tr>
    <tr>
        <td id="label_jmlterdaftar">PASIEN SUDAH BAYAR</td>
        <td id="jmlterdaftar">000</td>
    </tr>
</table>