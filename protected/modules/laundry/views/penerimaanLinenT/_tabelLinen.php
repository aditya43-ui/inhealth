<?php
/**
 * view ini digunakan untuk menampilkan data penerimaan dalam bentuk tabel
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://172.9.1.15/simpp/docs/> 
 */

echo CHtml::css('#table-linen thead tr th{vertical-align:middle;}'); ?>

<table class="table table-striped table-condensed table-bordered" id="table-linen">
	<thead>
		<tr>
			<th>No. </th>
			<th>No. Register Linen</th>
			<th>Nama Barang</th>
			<th>Jenis Perawatan</th>
			<th>Jumlah</th>
			<th>Keterangan</th>
			<!--<th>Batal</th>-->
		</tr>
	</thead>
	<tbody>
		<?php                 
                if (!isset($_GET['id'])){                                        
                    if (!empty($modPengajuanDetail)){                                           
                        echo $this->renderPartial($this->path_view.'_tabelPengajuanLinen',array('modDetail'=>$modPengajuanDetail),true);                       
                    }
                }else{
                    if (!empty($modPengajuanDetail)){
                        foreach($modPengajuanDetail as $i => $detail){                        
                            echo $this->renderPartial($this->path_view.'_tabelDetailLinen',array('det'=>$detail),true);
                        }
                    }
                 
                } ?>
	</tbody>
</table>
