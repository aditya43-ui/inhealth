<fieldset>
    <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Pencucian</td>
            <td>:</td>
            <td><?php echo $model->nopencucianlinen; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pencucian</td>
            <td>:</td>
            <td><?php echo isset($model->tglpencucianlinen) ? MyFormatter::formatDateTimeForUser($model->tglpencucianlinen) : ""; ?></td>
        </tr>
    </table><br>
    <table width="100%" class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Ruangan Asal</th>
                <th>Kode Linen</th>
                <th>Nama Linen</th>
                <th style="text-align: center">Status Pencucian</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modDetail) > 0){
                foreach($modDetail AS $i=>$detail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td>
					<?php 
					echo (!empty($detail->penerimaanlinen_id) ? $detail->getRuanganAsal($detail->penerimaanlinen_id) : "");
//					echo (!empty($detail->create_ruangan) ? $detail->ruangan->ruangan_nama : "");
					?>
				</td>
                <td><?php echo (!empty($detail->linen_id) ? $detail->linen->kodelinen : ""); ?></td>
                <td><?php echo (!empty($detail->linen_id) ? $detail->linen->namalinen : ""); ?></td>
                <td style="text-align: center"><?php echo ($detail->statuspencucian == "SELESAI")? $detail->statuspencucian : '<button id="green" class="btn btn-danger" name="yt1" onclick="setStatus('.$detail->pencuciandetail_id.')">'.$detail->statuspencucian.'</button>' ; ?></td>
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
				<?php echo isset($model->keterangan_pencucianlinen) ? $model->keterangan_pencucianlinen : ""; ?>
			</td>
			<td style="text-align: center;">
				Pegawai Mengetahui, <br>
				<br>
				<br>
				<br>
				<?php 
				if(!empty($model->pegpenerima_id)){
					$modPegMeng = PegawaiM::model()->findByPk($model->pegpenerima_id);
					echo '('.$modPegMeng->getNamaLengkap().')';
				}
				?>
			</td>
			<td width="10%"></td>
		</tr>
	</table>
</fieldset>

<script type="text/javascript">
    function setStatus(pencuciandetail_id){
        var pencuciandetail_id = pencuciandetail_id;
        window.parent.myConfirm(' Yakin Akan Merubah Status linen ? ', 'Perhatian!', function(r){
            if(r){
                $.post('<?php echo $this->createUrl('UbahStatusDetailLinen');?>', {pencuciandetail_id:pencuciandetail_id}, function(data){
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