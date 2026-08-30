<div class="overflow-x"> 
<table class="table table-striped table-condensed" id="tblDetailPeralatan">
       <thead>
			<tr>
				<th>No.</th>                                
                                <th>Nama Peralatan <span class="required">*</span></th>
				<th>Jumlah</th>
				<th>Keterangan</th>
                                <th>Status</th>
				<th>Tambah / Batal</th>
			</tr>
		</thead>
        <tbody>
            <?php
		/*if(!empty($modDetail)){
//			foreach ($modDetail AS $row => $data) {
//				if(!empty($data->ruangan_id)){
//					echo $this->renderPartial($this->path_view.'_rowDetail', array('modDetail' => $modDetail, 'form' => $form, 'row' => 0));
//				}
//				echo $modDetail->barang_id;
//                    
//                }
			echo $this->renderPartial($this->path_view.'_rowPeralatan', array('modDetail' => $modDetail, 'form' => $form, 'row' => 0));
		} else {
                echo $this->renderPartial($this->path_view.'_rowPeralatan', array('modDetail' => $modDetail, 'form' => $form, 'row' => 0));
            }
                 * 
                 */
		?>
        </tbody>
    </table>
</div>