<style type="text/css">
    h3{
        line-height: 20px;
    }
</style>
<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table width="<?php echo ((isset($width)) ? $width : "100%")?>" class="headers">       
	<TR>
        <TD style="text-align: center; border-bottom: 1px solid black !important;" align="center">
			 <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="text-align: center;  max-height:150px" class='image_report'/>
		</TD>
	</TR>   
	<tr>
		<td colspan="<?php echo isset($colspan)?$colspan:2 ?>">&nbsp;</td>
	</tr>
</table>
