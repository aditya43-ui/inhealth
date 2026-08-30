<style>
    body {
        color: black;
    }
    
    .num {
        text-align: right;
    }
    
    .footee td {
        font-weight: bold;
    }
    
	.jdl {
		text-align: center;
		font-weight: bold;
		margin: 10px;
	}
	
	.tab_detail th, .tab_detail td {
		border: 1px solid black;
        padding: 2px;
	}
    
    .tab_detail th {
        font-weight: bold;
    }
	
	.tab_detail {
		margin-bottom: 20px;
	}
	
	.tab_detail thead, .tab_detail tfoot {
		font-weight: bold;
	}
	
	.tab_head {
		margin-top: 10px;
		margin-bottom: 10px;
	}
    
    .tab_head td, .tab_head th {
        padding: 2px;
    }
</style>
<?php
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'sub/_headerPrint'); 
}

?>

<table class="tab_head" width="100%">
	<tr>
        <td>No.</td>
		<td>: </td>
		<td nowrap><?php echo $model->nosetoranbdhara; ?></td>
		
		<td style="vertical-align: top;">No. Struk</td>
		<td style="vertical-align: top;">: </td>
		<td style="vertical-align: top;" nowrap><?php echo $setorbank->nostruksetor; ?></td>
	</tr>
	<tr>
        <td nowrap>Diterima Uang Sebesar</td>
		<td>: </td>
		<td width="100%"><b><?php echo MyFormatter::formatNumberForPrint($total); ?></b></td>
		
		<td style="vertical-align: top;">Bank</td>
		<td style="vertical-align: top;">: </td>
		<td style="vertical-align: top;" nowrap><?php echo $setorbank->namabank; ?></td>
	</tr>
	<tr>
        <td style="vertical-align: top;">Terbilang</td>
		<td style="vertical-align: top;">: </td>
		<td style="vertical-align: top;"><b><em><?php echo strtoupper(MyFormatter::formatNumberTerbilang($total)); ?> RUPIAH</em></b></td>
		
        <td nowrap>No. Rekening</td>
		<td>: </td>
		<td><?php echo $setorbank->norekening; ?></td>
	</tr>
</table>
<hr style="border-bottom: 1px solid black; "/>
<div class="jdl">RINCIAN PEMBAYARAN</div>
<table class="base tab_detail">
	<thead>
		<tr>
			<th>No.</th>
			<th>Tgl. Pembayaran</th>
			<th>No Pembayaran</th>
			<th>Nama Pasien</th>
			<th>Penjamin</th>
			<th>Piutang</th>
			<th>Tunai</th>
			<th>Jumlah Pembayaran</th>
		</tr>
	</thead>
	<tbody class="unwrap">
		<?php
		$cnt = 0;
		$total = 0;
        $total_piutang = 0;
        $total_tunai = 0;
        
        foreach ($det as $closingkasir_id => $val):
        
            $total_meta = 0;
            $total_piutang_meta = 0;
            $total_tunai_meta = 0;
            
            $closing = ClosingkasirT::model()->findByPk($closingkasir_id);
            $bkm = TandabuktibayarT::model()->findAllByAttributes(array('closingkasir_id'=>$closingkasir_id), array('order'=>'tglbuktibayar asc'));
            // $rincian = RincianclosingT::model()->findAllByAttributes(array('closingkasir_id' => $idClosing), array('order'=>'nourutrincian'));
            
        ?>
        <tr>
            <td colspan="8" style="font-weight: bold;">
                <?php echo $closing->closingkasir_no." - ".MyFormatter::formatDateTimeForUser($closing->tglclosingkasir); ?>
            </td>
        </tr>
        <?php
            
        
            foreach ($bkm as $item):
                $cnt++;
                $bayar = PembayaranpelayananT::model()->findByPk($item->pembayaranpelayanan_id);

                if (!empty($bayar)) {
                    $no_bayar = $bayar->nopembayaran;
                    $tgl_bayar = $item->tglbuktibayar;
                    $total_bayar = $bayar->totaliurbiaya;
                    $total_biaya = $bayar->totalbiayapelayanan;
                    $penjamin_bayar = $bayar->penjamin_id;
                    $pasien = $bayar->pasien;

                    /*
                    $pakai = PemakaianuangmukaT::model()->findAllByAttributes(array(
                        'pembayaranpelayanan_id'=>$bayar->pembayaranpelayanan_id,
                    ));

                    foreach ($pakai as $item) {
                        // $total_bayar -= $item->pemakaianuangmuka;
                    }
                     * 
                     */
                } else { 
                    $uangmuka = BayaruangmukaT::model()->findByAttributes(array(
                        'tandabuktibayar_id'=>$item->tandabuktibayar_id
                    ));

                    if (empty($uangmuka)) continue;

                    if (!empty($uangmuka->pasienadmisi_id))
                        $moddat = PasienadmisiT::model()->findByPk($uangmuka->pasienadmisi_id);
                    else
                        $moddat = PendaftaranT::model()->findByPk($uangmuka->pendaftaran_id);

                    $tgl_bayar = $total_biaya = $uangmuka->tgluangmuka;
                    $total_bayar =$uangmuka->jumlahuangmuka;
                    $penjamin_bayar = $moddat->penjamin_id;
                    $pasien = $uangmuka->pasien;
                }

                $item->jmlpembayaran = ((empty($bayar) || !empty($item->jmlpembayaran)) ? $item->jmlpembayaran : $total_biaya);

                $total_piutang += empty($bayar) ? 0 : $bayar->totalsubsidiasuransi + $bayar->totalsubsidirs;
                $total_tunai += $total_bayar;
                $total += $total_bayar + $total_piutang;
                
                $total_piutang_meta += empty($bayar) ? 0 : $bayar->totalsubsidiasuransi + $bayar->totalsubsidirs;
                $total_tunai_meta += $total_bayar;
                $total_meta += $total_bayar + $total_piutang;

        ?>
            <tr>
                <td class="nom"><?php echo $cnt; ?></td>
                <td><?php echo MyFormatter::formatDateTimeForUser($item->tglbuktibayar); ?></td>
                <td><?php
                            if (!empty($item->pembayaranpelayanan_id)) echo $item->pembayaranpelayanan->nopembayaran;
                            else {
                                if (!empty($uangmuka) && !empty($uangmuka->nouangmuka)) echo $uangmuka->nouangmuka;
                                else echo $item->nobuktibayar;
                            }
                            ?></td>
                <td class="wrap" width="100%"><?php
                // $pasien = $item->pembayaranpelayanan->pasien;
                if (empty($pasien)) $pasien = $item->bayaruangmuka->pasien;
                echo $pasien->namadepan." ".$pasien->nama_pasien;
                ?></td>
                <td class="wrap" nowrap><?php 
                $penjamin = PenjaminpasienM::model()->findByPk($penjamin_bayar);
                if (!empty($penjamin)) echo $penjamin->penjamin_nama;
                else echo "UMUM";
                // echo !empty($item->pembayaranpelayanan->pendaftaran_id)?$item->pembayaranpelayanan->pendaftaran->penjamin->penjamin_nama:"UMUM"; 

                ?></td>
                <td class="num"><?php echo "Rp".MyFormatter::formatNumberForPrint(empty($bayar) ? 0 : ($bayar->totalsubsidiasuransi + $bayar->totalsubsidirs)); ?></td>
                <td class="num"><?php echo "Rp".MyFormatter::formatNumberForPrint($total_bayar); ?></td>
                <td class="num" nowrap><?php echo 'Rp'.MyFormatter::formatNumberForPrint($total_bayar + (empty($bayar) ? 0 : ($bayar->totalsubsidiasuransi + $bayar->totalsubsidirs))); // materai dan administrasi sudah termasuk dalam biaya pembayaran ?></td>
            </tr>
        <?php 
            endforeach; 
        ?>
            
            <tr style="border-top:1px solid" class="footee">
                <td colspan="5">Total - <?php echo $closing->closingkasir_no; ?></td>
                <td class="num"><?php echo 'Rp'.MyFormatter::formatNumberForPrint($total_piutang_meta); ?></td>
                <td class="num"><?php echo 'Rp'.MyFormatter::formatNumberForPrint($total_tunai_meta); ?></td>
                <td class="num"><?php echo 'Rp'.MyFormatter::formatNumberForPrint($total_piutang_meta + $total_tunai_meta); ?></td>
            </tr>
            
        <?php
        endforeach;
        ?>
            
            
	</tbody>
	<tfoot>
		<tr style="border-top:1px solid">
			<td colspan="5">Grand Total</td>
			<td class="num"><?php echo 'Rp'.MyFormatter::formatNumberForPrint($total_piutang); ?></td>
			<td class="num"><?php echo 'Rp'.MyFormatter::formatNumberForPrint($total_tunai); ?></td>
			<td class="num"><?php echo 'Rp'.MyFormatter::formatNumberForPrint($total_piutang + $total_tunai); ?></td>
		</tr>
	</tfoot>
</table>
<div class="note">* Biaya administrasi dan meterai sudah termasuk pada biaya invoice.</div>    
    

<table width='100%'>
	<tr>
		<td>&nbsp;</td>
		<td width="100%">&nbsp;</td>
		<td align='center' nowrap><?php echo Yii::app()->user->getState('kecamatan_nama').", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></td>
	</tr>
	<tr>
		<td align='center' nowrap>Mengetahui</td>
		<td align='center' style="text-align: center;"></td>
		<td align='center' style="text-align: center;" nowrap>Bendahara</td>
	</tr>
	<tr>
		<td align='center' style="text-align: center;" nowrap>
			<br><br><br><br><br>
			<?php
				echo "<u>".$model->mengetahui_nama."</u><br>".$nip[1];

			?>
		</td>
		<td align='center' style="text-align: center;"></td>
		<td align='center' style="text-align: center;" nowrap>
			<br><br><br><br><br>
			<?php 
				echo "<u>".$model->pegawai_nama."</u><br>".$nip[0];
			?>
		</td>
	</tr>
</table>
<br>
<?php

$urlPrint = $this->createUrl('rincianSetoran', array('id'=>$model->setoranbdhara_id));
if (isset($_GET['frame'])) {
    echo CHtml::htmlButton("<i class='entypo-print'></i> Print", array(
        'class' => 'btn btn-danger',
        'onclick'=>"print('PRINT')",
    ));
?>

<script>

function print(caraPrint)
{
    window.open("<?php echo $urlPrint ?>"+"&caraPrint="+caraPrint,"",'location=_new, width=1100px, scrollbars=yes');
}

</script>

<?php
    
}

?>
