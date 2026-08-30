<style>
    body {
        color: black;
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
<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
			<div class="judulcontent"> <table class="tab_head" width="100%">
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

<table class="tab_detail" width="100%">
	<thead>
		<tr>
			<th>Kode Akun</th>
			<th>Uraian Rincian</th>
			<th>Jumlah</th>
		</tr>
	</thead>
	<tbody>
		<?php 
        foreach($det as $setorankasir_id=>$item): ?>
		
			<?php //foreach ($val['det'] as $item): ?>
		<tr>
			<td><?php echo $item['rek']; ?></td>
			<td><?php echo $item['kel']; ?></td>
			<td style="text-align: right; "><?php echo MyFormatter::formatNumberForPrint($item['nilai']); ?></td>
		</tr>
			<?php // endforeach; ?>
		
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">Total</td>
			<td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($total); ?></td>
		</tr>
	</tfoot>
</table>

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
</table> </div>
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>
