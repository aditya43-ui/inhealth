<?php
/**
 * digunakan untuk format laporan buku register
 * footer tanpa keterangan dicetak oleh
 * RSST-3210
 * @author          Aida Rahmawati <aidarahmawati@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * 
 */
    $modUser = LoginpemakaiK::model()->findByPK(Yii::app()->user->id);
    $modProfile = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
//    echo $modUser->nama_pemakai.' '.date('Y-m-d H:i:s');
?>

<div>
  
<div style="row-fluid">
    
    <table width="100%" border="">
        <tr>
            <td HEIGHT=2 style="border-bottom: 2px solid #000000" width="100%" colspan="4"> </td>
        </tr>
        <tr>
        <td width="25%" align="left"><FONT FACE="" SIZE=<?php echo isset($judulFont)?$judulFont:2; ?> color="black"><?php echo date("d/m/Y");?></FONT></td>
        <td width="50%" align="center"><FONT FACE="" SIZE=<?php echo isset($judulFont)?$judulFont:2; ?> color="black">Bagian Unit Kerja <?php echo InstalasiM::model()->findByPk(Yii::app()->user->getState('instalasi_id'))->instalasi_nama;   ?></FONT></td>
        <td width="25%" align="right"><FONT FACE="" SIZE=<?php echo isset($judulFont)?$judulFont:2; ?> color="black">Hal {PAGENO} dari {nbpg}</FONT></td>
        </tr>
        <tr>
        <td width="25%" align="left"></td>
        <td width="50%" align="center"> </td>
        <td width="25%" align="right"></td>
        </tr>
         
    </table>
</div>
