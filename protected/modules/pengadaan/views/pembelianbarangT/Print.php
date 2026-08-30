
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'pembelianbarang_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->pembelianbarang_id',
                ),
		'terimapersediaan_id',
		'sumberdana_id',
		'supplier_id',
		'tglpembelian',
		'nopembelian',
		/*
		'tgldikirim',
		'peg_pemesanan_id',
		'peg_mengetahui_id',
		'peg_menyetujui_id',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		*/
 
        ),
    )); 
?>
<?php 
$profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $alamat=!empty($profil->alamatlokasi_rumahsakit)?$profil->alamatlokasi_rumahsakit:"";
	$motto=!empty($profil->motto)?$profil->motto:"";
        $telp=!empty($profil->no_telp_profilrs)?$profil->no_telp_profilrs:"";
        $email=!empty($profil->email)?$profil->email:"";
        $website=!empty($profil->website)?$profil->website:"";
        $layoutkiri=$alamat."<br>"."Telp:".$telp." Email:".$email." Website:".$website;
?>
<table width="100%" class="footer">
    <tr><td width="70%" style="text-align:left" align="left" class="alamatfooter" ><?php echo  $layoutkiri ?></td><td class="mottofooter" style="text-align:right"  width="30%" align="right"><?php echo $motto ?></td></tr>
        
</table>