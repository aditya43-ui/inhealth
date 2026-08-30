<style>
    
    body {
        color: black;
    }
    
    .control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:11px;
    }

    td .tengah{
       text-align: center;  
    }
    .border th, .border td{
        border:1px solid #000 !important;
    }
    .table thead:first-child{
        border-top:1px solid #000 !important;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
    
    
</style>

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td>           
            <b>No. Pengajuan Klaim</b>            
        </td>
        <td><?php echo ": ".CHtml::encode(($modPengajuanKlaim->nopengajuanklaimanklaim)); ?> / </td>
        <td>&nbsp;</td>
        <td>           
            <b>Asuransi  </b>          
        </td>
        <td>
            <?php
                echo ": ".$modPengajuanKlaim->penjamin->penjamin_nama;
            ?>
        </td>
    </tr>
    <tr>
        <td>            
                <b>Tgl. Pembayaran Klaim</b>            
        <td>
            <?php echo ": ".CHtml::encode(MyFormatter::formatDateTimeForUser($modPengajuanKlaim->tglpengajuanklaimanklaim)); ?>
        </td>
        <Td>&nbsp;</td>
        <td>            
                <b>Total Piutang</b>            
        </td>
        <td>
                <?php echo ": ".CHtml::encode(number_format($modPengajuanKlaim->totalpiutang,0,"",".")); ?>
        </td>   
    </tr>
                 
</table>            
     <br>
<?php
    $totalbiayaadminfarmasi = 0;
    $row = array();
?>
<table width="100%" style='margin-left:auto; margin-right:auto;box-shadow:none;' class='table border'>
    <thead>
        <tr>
            <th>Tgl. Pembayaran</th>
            <th>No Pembayaran</th>
            <th>Pembayaran Melalui</th>
            <th>Pembayaran Ke - </th>
            <th style="text-align:right;">Jumlah Bayar</th>            
        </tr>
    </thead>
                    <tbody>
    <?php
        $total_piutang = 0;
        $total_bayar = 0;
        $total_telah_bayar = 0;
        $total_sisa_piutang = 0;                   

		$a = 1;
        foreach ($bayar as $i => $pembayaran) {
			$total_bayar += $pembayaran->totalbayar;
	?>
                            <tr>
                                    <td><?php echo MyFormatter::formatDateTimeForUser($pembayaran->tglpembayaranklaim); ?></td>
                                    <td><?php echo $pembayaran->nopembayaranklaim; ?></td>
                                    <td><?php echo $pembayaran->pembayaranmelalui; ?></td>
                                    <td><?php echo $a; ?></td>
                                    <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($pembayaran->totalbayar); ?></td>                                    
                            </tr>
                    <?php                             
			$a++;
		} 
                    ?>
                    </tbody>
     <tfoot>
        <tr>
            <td colspan="4"><div class='pull-right'><b>Total Pengajuan</b></div></td>
            <td style="text-align:right;"><b><?php echo number_format($modPengajuanKlaim->totalbayar,0,',','.'); ?></b></td>
        </tr>
        <tr>
            <td colspan="4"><div class='pull-right'><b>Total Bayar</b></div></td>
            <td style="text-align:right;"><b><?php echo number_format($total_bayar,0,',','.'); ?></b></td>
        </tr>        
        <tr>
            <td colspan="4"><div class='pull-right'><b>Total Sisa</b></div></td>
            <td style="text-align:right;"><b><?php echo number_format($modPengajuanKlaim->totalbayar-$total_bayar,0,',','.');?></b></td>
        </tr>                    
    </tfoot>

</table>
       