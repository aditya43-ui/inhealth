
    <table class="table table-bordered table-condensed table-striped" id="tab_setoran">
        <thead>
            <tr>
                <th rowspan="2">Ruangan</th>
                <th colspan="2">Jumlah Pasien</th>
                <th colspan="2">Farmasi</th>
				<th colspan="2">Jasa Medis</th>
                <th colspan="2">Jasa Paramedis</th>
                <th colspan="2">Administrasi</th>
                <th colspan="2">Jumlah</th>
                <th rowspan="2">Jumlah Total</th>
            </tr>
            <tr>
                <th>PL</th>
                <th>PB</th>
                <th>PL</th>
                <th>PB</th>
                <th>PL</th>
                <th>PB</th>
                <th>PL</th>
                <th>PB</th>
                <th>PL</th>
                <th>PB</th>
                <th>PL</th>
                <th>PB</th>
            </tr>
        </thead>
        <tbody>
			<?php 
			foreach ($setorandet as $idx=>$item) {
				echo $this->renderPartial('sub/_rowdetail', array('item'=>$item, 'idx'=>$idx), true);
			} 
			?>
		</tbody>
		<tfoot>
			<?php echo $this->renderPartial('sub/_rowtotal', array('item'=>$tot), true); ?>
		</tfoot>
    </table>

