<fieldset>
    <table width="50%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Perawatan</td>
            <td>:</td>
            <td><?php echo isset($model->noperawatan) ? $model->noperawatan : ""; ?></td>
        </tr>
        <tr>
            <td>Tanggal Perawatan</td>
            <td>:</td>
            <td><?php echo isset($model->tglperawatanlinen) ? MyFormatter::formatDateTimeForUser($model->tglperawatanlinen) : ""; ?></td>
        </tr>
    </table><br>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Ruangan Asal</th>
                <th>Tgl/ No.Penerimaan</th>
                <th>Kode Linen</th>
                <th>Nama Linen</th>
                <th>Keterangan</th>
                <th style="text-align: center">Status Perawatan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modDetail) > 0){
                foreach($modDetail AS $i=>$detail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($detail->ruangan_id) ? $detail->ruangan->ruangan_nama : ""); ?></td>
                <td>
					<?php 
					echo (!empty($detail->penerimaanlinen_id) ? MyFormatter::formatDateTimeId($detail->penerimaanlinen->tglpenerimaanlinen) : ""); 
					echo '/ ';
					echo (!empty($detail->penerimaanlinen_id) ? $detail->penerimaanlinen->nopenerimaanlinen : ""); 
					?>
				</td>
                <td><?php echo (!empty($detail->linen_id) ? $detail->linen->kodelinen : ""); ?></td>
                <td><?php echo (!empty($detail->linen_id) ? $detail->linen->namalinen : ""); ?></td>
                <td><?php echo $detail->keteranganperawatan; ?></td>
                <td style="text-align: center"><?php echo ($detail->statusperawatanlinen == "SELESAI")? $detail->statusperawatanlinen : '<button id="green" class="btn btn-danger" name="yt1" onclick="setStatus('.$detail->perawatanlinendetail_id.')">'.$detail->statusperawatanlinen.'</button>' ; ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
	<br>
	<table style="width: 100%; border: none;">
		<tr>
			<td width="60%" style="vertical-align:top;">
				Keterangan : <br>
				<?php echo isset($model->keterangan_perawatan) ? $model->keterangan_perawatan : ""; ?>
			</td>
			<td style="text-align: center;">
				Pegawai Mengetahui, <br>
				<br>
				<br>
				<br>
				<?php 
				if(!empty($model->pegmengetahui)){
					$modPegMeng = PegawaiM::model()->findByPk($model->pegmengetahui);
					echo '('.$modPegMeng->getNamaLengkap().')';
				}
				?>
			</td>
			<td width="10%"></td>
		</tr>
	</table>
</fieldset>

<script type="text/javascript">
    function setStatus(perawatanlinendetail_id){
        var perawatanlinendetail_id = perawatanlinendetail_id;
        window.parent.myConfirm(' Yakin Akan Merubah Status linen ? ', 'Perhatian!', function(r){
            if(r){
                $.post('<?php echo $this->createUrl('UbahStatusDetailLinen');?>', {perawatanlinendetail_id:perawatanlinendetail_id}, function(data){
                    if(data == true){
                        window.parent.myAlert("Data berhasil disimpan");
                        location.reload();
                    }else{
                        window.parent.myAlert("Update status linen gagal");
                    }
                }, 'json');
            }else{
                preventDefault();
            }
        });    
    }
</script>