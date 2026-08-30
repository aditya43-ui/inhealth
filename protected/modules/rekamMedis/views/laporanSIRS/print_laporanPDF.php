<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<?php
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$title.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
?>
<table cellpadding="0" cellspacing="0" width="<?php echo(is_null($width) ? '650' : $width) ;?>" border="0" style="font-size: 11px;">
    <tr>
        <td width="50" style="border-bottom: 3px solid #000000;">
            <img src="<?php echo Yii::app()->request->baseUrl . "/images/bhakti_husada.jpg"; ?>" width="80"/>
        </td>
        <td width="400" align="left" VALIGN=MIDDLE style="border-bottom: 3px solid #000000;">
            <?php echo($formulir);?><br><?php echo($title);?></br>
        </td>
        <td width="150" style="border-bottom: 3px solid #000000;">
            <div style="border:1px solid #AEAEAE;font-size:9px;font-style: italic;border-style: dotted;padding: 10px;">
                Ditjen Bina Upaya Kesehatan<br>
                Kementrian Kesehatan RI
            </div>
        </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="3">
            <table cellpadding="0" cellspacing="0" width="<?php echo(is_null($width) ? '650' : $width) ;?>" border="0">
                <tr>
                    <td width="50%">
                        <table style="width: 100%; border: none;">
                            <tr>
                                <td width="100">Kode RS</td>
                                <td width="180">: <?php echo (isset($data->nokode_rumahsakit) ? $data->nokode_rumahsakit : "-"); ?></td>
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
                    </td>
                    <td width="50%">
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
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
</table>

            <?=$table;?>
