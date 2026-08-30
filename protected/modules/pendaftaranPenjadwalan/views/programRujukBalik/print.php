<?php
if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judul_print . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
}
?>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])) {
    echo $this->renderPartial('_headerPrint');
}
?>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valign="middle" colspan="3">
            <b><?php echo $judulLaporan ?></b>
        </td>
    </tr>
</table>
<br />

<?= $this->renderPartial('_table',['model'=>$model,'caraPrint'=>'PRINT']) ?>
