<style>
  .nama_profil {
    font-size: 12pt;
    font-weight: bold;
  }
</style>


<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();




?>
<table width="<?php echo ((isset($width)) ? $width : "100%") ?>" class="headers table-header">
    
    <!--<TD width="15%" height="50%">-->
    <TR>
        <TD>
            <div class="nama_profil" style="color: black !important; ">
                <?php 
                $header = strip_tags($konfig->alamatheadersurat, "<br>");
                
                echo $header;
                echo "<br/>";
                echo "Telp : ".$data->no_telp_profilrs.", Fax : ".(empty($data->no_faksimili) ? "-" : $data->no_faksimili) ?>
            </div>
        </TD>
        
    </TR>
    <tr>
        <td colspan="1">&nbsp;</td>
    </tr>

</table>

