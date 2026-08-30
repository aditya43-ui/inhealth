<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$title.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}

?>
<table width="<?php echo(is_null($width) ? '650' : $width) ;?>" border="0">
    <tr>
        <td width="100">
            <img src="<?php echo Yii::app()->request->baseUrl . "/images/bhakti_husada.jpg"; ?>" width="80"/>
        </td>
        <td align="left" VALIGN=MIDDLE>
            <?php echo($formulir);?><br><?php echo($title);?></br>
        </td>
        <td width="150">
            <div style="border:1px solid #AEAEAE;font-size:9px;font-style: italic;border-style: dotted;padding: 10px;">
                Ditjen Bina Upaya Kesehatan<br>
                Kementrian Kesehatan RI
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <div style="border-bottom: 3px solid #000000;margin-bottom: 2px;">&nbsp;</div>
            <div style="border-top: 1px solid #000000;">&nbsp;</div>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <div style="float:left;width:280px;">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td width="100">Kode RS</td>
                        <td width="180">: -</td>
                    </tr>
                    <tr>
                        <td>Nama RS</td>
                        <td>: <?php echo Yii::app()->user->getState('nama_rumahsakit'); ?></td>
                    </tr>
                    <tr>
                        <td>Tahun</td>
                        <td>: <?=date('Y')?></td>
                    </tr>
                </table>
            </div>
            <div style="float:right;width:280px;">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td width="100">Kab/Kota</td>
                        <td width="180">: Tasikmalaya</td>
                    </tr>
                    <tr>
                        <td>Kode Provinsi</td>
                        <td>: 1234</td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td>: <?=$periode?></td>
                    </tr>
                </table>                
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3">
            <?=$table;?>
        </td>
    </tr>
</table>