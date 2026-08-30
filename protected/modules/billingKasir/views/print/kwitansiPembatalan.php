<?php
$format = new MyFormatter();
$pendaftaran = PendaftaranT::model()->findByPk($uangmuka->pendaftaran_id);

echo CHtml::css('
    
    .tab_list {
        width: 100%;
    }

    body {
        color: black;
    }

    .control-label{
        float:left; 
        text-align: left; 
        width:160px;
        color:black;
        padding-right:10px;
        font-size: 12pt;
    }
    table{
        font-size:12px;
    }
');
?>
<style>
    td, div{
        font-size: 12pt;
    }
    td .uang{
        text-align: right;
    }
    td .total{
        border-top: 1px solid #000000;
        text-align: right;
        font-weight: bold;
    }
    td .totalSeluruh{
        border-bottom: 1px solid #000000;
        text-align: right;
        font-weight: bold;
    }
</style>

<table width="100%" style='margin-left:auto; margin-right:auto;' class='tab_list'>
                    <tr>
                        <th colspan="3" align="center" style="font-size:14pt;text-decoration:underline;padding:10px; text-align: center;">
                            <b>KUITANSI PEMBATALAN UANG MUKA </b>
                        </th>
                    </tr>           
                    <tr>
                        <td width="40%">No. Kuitansi</td>
                        <td width="2%">:</td>
                        <td align="left"><?php echo $model->nokaskeluar;?></td>
                    </tr>
                    <tr>
                        <td>Banyak Uang</td>
                        <td>:</td>
                        <td><?php echo $format->formatNumberTerbilang($model->jmlkaskeluar).' rupiah';?></td>
                    </tr>
                    <tr>
                        <td>Untuk Pembayaran</td>
                        <td>:</td>
                        <td><?php echo $model->untukpembayaran;?> Tanggal <?php echo date('d/m/Y');?></td>
                    </tr>
                    <tr>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td><?php // echo $model->darinama_bkm;?><?php echo $pendaftaran->pasien->nama_pasien; ?> - No. RM : <?php echo $pendaftaran->pasien->no_rekam_medik ?></td>
                    </tr>
                </tbody>
            </table>
            <table frame=void align=left cellspacing=0 cols=11 rules=none border=0 width="100%">
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="50%" align="center">
                            <div style="border:1px solid #000000;width:200px;padding:10px;font-size:14pt;font-weight: bold;">
                                Rp <?php echo MyFormatter::formatNumberForPrint($model->jmlkaskeluar); ?>,-
                            </div>
                        </td>
                        <td align="center">
                                <div><?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeId(date($model->tglkaskeluar)); ?>
                                </div>
                                <div>Petugas Kasir,</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                
                                <div>
                                    <?php 
                                    $login = LoginpemakaiK::model()->findByPk($pembatalan->create_loginpemakai_id);
                                    
                                    if (!empty($login)) {
                                        $pegawai = PegawaiM::model()->findByPk($login->pegawai_id);
                                        if (!empty($pegawai)) echo '<b>'.$pegawai->nama_pegawai.'</b>';
                                        else echo '<b>-</b>';
                                    } else echo '<b>-</b>';
                                    ?>
                                    
                                </div>
                        </td>
                    </tr>
                    <br><br>
             
            </table>


<?php
if (!isset($_GET['caraPrint'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print ', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(){
        window.open("<?php echo $this->createUrl("pembatalanUangMuka", array("idTandaBukti"=>$_GET['idTandaBukti'])) ?>&caraPrint=PRINT","",'location=_new, width=1024px');
    }
	
	function printExcel(){
		var pegawai_id = '<?php echo Yii::app()->user->getState('pegawai_id') ?>';
		
		<?php 
			if (!empty(Params::getPegawaiAksesRincianExcel(Yii::app()->user->getState('pegawai_id')))){
		?>
				window.open("<?php echo Yii::app()->createUrl("billingKasir/pembayaranTagihanPasien/printRincianSudahBayar&caraPrint=EXCEL", array("pembayaranpelayanan_id"=>$_GET['pembayaranpelayanan_id'])) ?>","",'location=_new, width=1024px');	
		<?php
			}else{
		?>
				myAlert("Anda tidak berhak untuk mengakses fungsi ini","Perhatian!");
		<?php		
			}
		?>
		
        
    }
    </script>
<?php
}

?>

   