<style>
 
    tr:last-child > td:first-child 
    {
        border-bottom-left-radius: 0;
    }    
    
    .table
    {
        border: 1px solid #000;
        border-radius: 0 0px 0px 0px;
        box-shadow: 0 0px 0px 0px;
    }

    .table-striped tbody tr:nth-child(2n+1) td
    {
        background-color: #fff;
    }

    .table th
    {
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;

    }

    .c th + th, .c td + td, .c th + td, .c td + th 
    {
        border-left: 1px solid #000;

    }
   
    .d th + th, .d td + td, .d th + td, .d td + th 
    {
        border-left: 0;

    }
    
    table.d{
        border: 0;
    }
    
    
   thead th {
    background: none;
    border-bottom: 4px solid #6B994D;
    color: #333333;
    }
</style>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <b><?php echo CHtml::encode($modRetur->getAttributeLabel('noreturterima')); ?>:</b>
            <?php echo CHtml::encode($modRetur->noreturterima); ?>
            <br>
            <b><?php echo CHtml::encode($modRetur->getAttributeLabel('tglreturterima')); ?>:</b>
            <?php echo MyFormatter::formatDateTimeForUser($modRetur->tglreturterima); ?>
             <br>
        </td>    
		 <td>
            <b><?php echo CHtml::encode($modRetur->getAttributeLabel('supplier_id')); ?>:</b>
            <?php echo CHtml::encode($modRetur->terimapersediaan->supplier->supplier_nama); ?>
            <br>
            <b><?php echo CHtml::encode($modRetur->getAttributeLabel('alasanreturterima')); ?>:</b>
            <?php echo $modRetur->alasanreturterima; ?>
             <br>
        </td>    
    </tr>   
</table>

<table id="tableObatAlkes" class="table table-bordered">
    <thead>
        <th>No.</th>
        <th>Barang</th>
        <th>Jml Retur</th>
        <th>Satuan</th>        
    </thead>
    <tbody>
    <?php
        $no=1;
        foreach($modDetailRetur AS $detail): ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo $detail->terimapersdetail->barang->barang_nama; ?></td>
                <td><?php echo $detail->jmlretur; ?></td>
                <td><?php echo $detail->satuanbeli; ?></td>                
            </tr>
    <?php 
        $no++; 
        endforeach;     
    ?>
    </tbody>
</table>

<table width="100%" style="margin-top:20px;">
	<tr>
		<td width="100%" align="left" align="top">
			<table style="width: 100%; border: none;">
				<tr>
					<td width="35%" align="center">						
					</td>
					<td width="35%" align="center">
					</td>
					<td width="35%" align="center">
						<div>Yang Mengetahui</div>
						<div style="margin-top:60px;"><?php echo isset($modRetur->peg_mengetahui_id) ? $modRetur->pegawaimengetahui->NamaLengkap : "" ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>