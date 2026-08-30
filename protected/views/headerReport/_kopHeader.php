<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table width="100%" class="headerku" style="margin-bottom:5px;">
    <tr>
        <td width="25%" align="center">
            <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 40mm; width:40mm;"/>
        </td>
        <td align="center" nowrap>            
            <div>
                <b><?php echo $modProfilRs->nama_rumahsakit; ?></b>
            </div>
            <div>
                <?php echo $modProfilRs->alamatlokasi_rumahsakit; ?>
            </div>
            <div>
                Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> / Fax. <?php echo $modProfilRs->no_faksimili; ?>
            </div>
        </td>
        <td width="25%" align="center">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border-bottom: 3px solid #000000" height="2">&nbsp;</td>
    </tr>
    
</table>

<?php if (isset($show_judul)){ ?>
<div class="judul-rincian">
    <?= $judulLaporan ?><br/>
    <?php if (isset($periode)){ ?>
    <span class="periode"><?= $periode ?></span>
    <?php } ?>
</div>
<?php } ?>