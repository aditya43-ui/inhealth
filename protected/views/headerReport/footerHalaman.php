
<?php
/**
 * Digunakan untuk format print yang hanya memerlukan halaman saja
 * @author          Andyka Putra <andykaputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * 
 */
?>
<div style="row-fluid">
    <table width="100%" border="">
        <tr>
            <td HEIGHT=2 style="border-bottom: 2px solid #000000" width="100%" colspan="4"> </td>
        </tr>
        <tr>
            <td width="25%" align="left"></td>
            <td width="50%" align="center"></td>
            <td width="25%" align="right"><FONT FACE="" SIZE=<?php echo isset($judulFont) ? $judulFont : 2; ?> color="black">Hal {PAGENO} dari {nbpg}</FONT></td>
        </tr>
        <tr>
            <td width="25%" align="left"></td>
            <td width="50%" align="center"></td>
            <td width="25%" align="right"></td>
        </tr>
    </table>
</div>
