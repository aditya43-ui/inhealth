<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
//echo $this->renderPartial('application.views.headerReport.headerBuktiKas',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<style type="text/css">
	.table2 {
    font-size: 11px;
    margin-bottom: 20px;
    margin-top: 30px;
    width: 30%;
}
</style>

<?php $data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<table width="<?php echo ((isset($width)) ? $width : "100%")?>">
    <TR>
        <!--<TD width="15%" height="50%">-->
        <TD width="15%" >
            <?php
//		if (file_exists(Params::urlProfilRSDirectory().'pjn.png')) {
                    $gambar2 = Params::urlProfilRSDirectory().'pjn.png';
//		}else{
//                    $gambar2 = Params::urlProfilRSDirectory().$data->logo_rumahsakit;
            ?>
		<img src="<?php echo $gambar2 ?> " style="max-width: 30mm; width:30mm; margin-left: 20px;"/>
            <?php
//		}
            ?>
        </TD>
        <TD align="right">
            <div align="right">
                    <FONT FACE="Liberation Serif" SIZE=3 color="black">
                    No. Urut Register : <?php echo $model->no_voucher; ?> <br>
                        <?php // echo $data->nama_rumahsakit ?>
                    </FONT>
                    <FONT FACE="Liberation Serif" SIZE=3 color="black">
                    No. Urut Kasir : ............................... <br>
                        <?php // echo $data->nama_rumahsakit ?>
                    </FONT>
                    <FONT FACE="Liberation Serif" SIZE=3 color="black">
                    No. Mata Anggaran : ............................... <br>
                        <?php // echo $data->nama_rumahsakit ?>
                    </FONT>
            </div>
        </TD>
        <TD width="15%">
            <?php
//		}
            ?>
        </TD>
    </TR>
    <TR>
        <TD colspan="3" HEIGHT=2 >&nbsp;</TD>
    </TR>
    <TR>
        <TD ALIGN=CENTER colspan="3">
            <font color="black"><h5><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h5></font>
        </TD>
    </TR>    
</table>

<div class="span11">
	<div class="row-fluid">
		<table width="100%">
			<tr>
				<td width="100px">Diterima dari</td><td width="2%">:</td>
				<td><?php echo $model->diterimadari; ?></td> 
			</tr>
			<tr>
				<td width="100px">Uang Sejumlah</td><td width="2%">:</td>
				<!--<td><?php // echo isset($model->jml_penerimaan)?$model->formatUang($model->jml_penerimaan):'-'; ?></td>-->
				<td><?php echo $format->formatUang($model->jml_penerimaan); ?></td>
				</tr>
				<tr>
				<td></td>
				<td></td>
				<td><?php echo strtoupper($format->formatNumberTerbilang($model->jml_penerimaan)) . ' RUPIAH'; ?></td>
			</tr>
			<tr>
				<td width="300px">Untuk keperluan</td><td width="2%">:</td>
				<td><?php echo $model->untukkeperluan; ?></td> 
			</tr>
		</table>
	</div>
</div>
<br />
<br />
<div class="row-fluid">
		<table class="table">
			<tr> 
				<th style="" colspan="2">
                        <center>
					<br>
					Pejabat yang berwenang
					<br><br><br><br><br><br>
					<!--(<?php // echo $model->peg_bendahara; ?>)-->
                                        (......................................)</center>
				</th>
				<th style="" colspan="2">
                        <center>
					Jakarta, <?php echo date('j F Y'); ?>
					<br>
					Bendahara,
					<br><br><br><br><br><br>
					<!--(<?php // echo $model->peg_verifikasi; ?>)-->
                                        (......................................)</center>
				</th>
			</tr>
		</table>
	</div>

<!--<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td width="11%" style="text-align:right;">Tanggal Voucher</td><td width="2%">:</td>
                    <td width="37%">
                        <?php // echo CHtml::encode($format->formatDateTimeForUser($model->tgl_voucher)); ?>
                    </td>
                </tr>
                <tr>
                    <td width="11%" style="text-align:right;">Jenis Penerimaan</td><td width="2%">:</td>
                    <td width="37%">
                        <?php 
//                            $modJenisPenerimaan = VRJenispenerimaanM::model()->findByPk($model->jenispenerimaan_id);
                            
                        ?>
                        <?php // echo CHtml::encode(isset($model->jenispenerimaan_id) ? $modJenisPenerimaan->jenispenerimaan_nama : "-"); ?>
                    </td>
                </tr>
            </table>            
        </td>
    </tr>
</table><br>-->

<!--<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
    <thead>
        <tr>
            <th>No</th>
            <th>Uraian</th>
            <th>Jumlah (Rp.)</th>
        </tr>
    </thead>
    <tbody>
        <?php
//            $no = 0;
//            $total = 0;
//             
//            foreach ($modDetail as $i => $uraian) { 
//                $total += $uraian->jml_uraian;    
            ?>
        <tr>
            <td>
                <?php // echo $no += 1; ?>
            </td>
            <td>
                <?php // echo isset($uraian->namauraian)?$uraian->namauraian:'-'; ?>
            </td>
            <td>
                <?php // echo isset($uraian->jml_uraian)?$format->formatUang($uraian->jml_uraian):'-'; ?>
            </td>
        </tr>
        <?php // } ?>
        <tr>
            <td colspan="2" align="center"><strong>Total</strong></td>
            <td><?php // echo $format->formatUang($total); ?></td>
        </tr>
    </tbody>
</table>-->
<div class="row-fluid">
    <table border="1" align="" width="100%" style='margin-left:auto; margin-right:auto;' class=''>
        <thead>
            <tr>
                <th style="width: 15%">No. Perkiraan</th>
                <th style="width: 15%">Debit</th>
                <th style="width: 15%">Kredit</th>
                <th style="width: 15%">No. Perkiraan</th>
                <th style="width: 15%">Debit</th>
                <th style="width: 15%">Kredit</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>&nbsp;<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>        
        </tbody>
    </table>
</div>


<table border="1" align="left" width="50%" style='margin-left:auto; margin-right:auto;' class=''>
    <thead>
        <tr>
            <th>Verifikasi</th>
            <th>Akuntansi</th>
            <th>Pelaksana</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>&nbsp;<br /><br /><br /><br /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>        
    </tbody>
</table>

<!--
  


<style type="text/css">
	.table2 {
    font-size: 11px;
    margin-bottom: 20px;
    margin-top: 30px;
    width: 30%;
}
</style>
<div class="span11">
	<div class="row-fluid">
		<table width="100%">
			<tr>
				<td width="100px">Diterima dari</td><td width="2%">:</td>
				<td><?php // echo $model->diterimadari; ?></td> 
			</tr>
			<tr>
				<td width="100px">Uang Sejumlah</td><td width="2%">:</td>
				<td><?php // echo isset($model->jml_penerimaan)?$model->formatUang($model->jml_penerimaan):'-'; ?></td>
				<td><?php // echo $format->formatUang($model->jml_penerimaan); ?></td>
				</tr>
				<tr>
				<td></td>
				<td></td>
				<td><?php // echo strtoupper($format->formatNumberTerbilang($model->jml_penerimaan)) . ' RUPIAH'; ?></td>
			</tr>
			<tr>
				<td width="300px">Untuk keperluan</td><td width="2%">:</td>
				<td><?php // echo $model->untukkeperluan; ?></td> 
			</tr>
		</table>
	</div>
</div>

<div class="row-fluid">
		<table class="table">
			<tr> 
				<th style="" colspan="2">
					<br>
					Pejabat yang berwenang
					<br><br><br><br><br><br>
					(<?php // echo $model->peg_bendahara; ?>)
				</th>
				<th style="" colspan="2">
					Jakarta, <?php // echo MyFormatter::formatDateTimeForUser($model->tgl_voucher); ?>
					<br>
					Verifikasi,
					<br><br><br><br><br><br>
					(<?php // echo $model->peg_verifikasi; ?>)
				</th>
			</tr>
		</table>
	</div>

<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td width="11%" style="text-align:right;">Tanggal Voucher</td><td width="2%">:</td>
                    <td width="37%">
                        <?php // echo CHtml::encode($format->formatDateTimeForUser($model->tgl_voucher)); ?>
                    </td>
                </tr>
                <tr>
                    <td width="11%" style="text-align:right;">Jenis Penerimaan</td><td width="2%">:</td>
                    <td width="37%">
                        <?php 
//                            $modJenisPenerimaan = VRJenispenerimaanM::model()->findByPk($model->jenispenerimaan_id);
                            
                        ?>
                        <?php // echo CHtml::encode(isset($model->jenispenerimaan_id) ? $modJenisPenerimaan->jenispenerimaan_nama : "-"); ?>
                    </td>
                </tr>
            </table>            
        </td>
    </tr>
</table><br>

<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
    <thead>
        <tr>
            <th>No</th>
            <th>Uraian</th>
            <th>Jumlah (Rp.)</th>
        </tr>
    </thead>
    <tbody>
        <?php
//            $no = 0;
//            $total = 0;
             
//            foreach ($modDetail as $i => $uraian) { 
//                $total += $uraian->jml_uraian;    
            ?>
        <tr>
            <td>
                <?php // echo $no += 1; ?>
            </td>
            <td>
                <?php // echo isset($uraian->namauraian)?$uraian->namauraian:'-'; ?>
            </td>
            <td>
                <?php // echo isset($uraian->jml_uraian)?$format->formatUang($uraian->jml_uraian):'-'; ?>
            </td>
        </tr>
        <?php // } ?>
        <tr>
            <td colspan="2" align="center"><strong>Total</strong></td>
            <td><?php // echo $format->formatUang($total); ?></td>
        </tr>
    </tbody>
</table>

<table align="left" width="50%" style='margin-left:auto; margin-right:auto;' class='table2 table-bordered table-condensed'>
    <thead>
        <tr>
            <th>Verifikasi</th>
            <th>Akuntansi</th>
            <th>Pelaksana</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>-</th>
            <th></th>
            <th></th>
        </tr>        
    </tbody>
</table>

<table class="table">
	<tr> 
         <th style="" colspan="2">
                Pegawai Verifikasi,
                <br><br><br><br><br><br>
                (<?php // echo isset($model->peg_verifikasi)?$model->peg_verifikasi:'-';?>)
            </th>
	</tr>
</table>
-->
