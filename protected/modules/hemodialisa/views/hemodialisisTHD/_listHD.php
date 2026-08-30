<table class="items table table-striped table-condensed">
	 <thead>
        <tr>
            <!--<th>Tanggal Hemodialisa</th>-->
			<th>Jenis Dialiser / Suhu</th>
			<th>Tgl Penggunaan Awal</th>
			<th>Tgl Penggunaan Dialiser</th>
			<th>Penggunaan Ke-</th>
            <th>Perawat</th>
			<th>Lihat Detail</th>
            <th>Ubah</th>
            <th>Hapus</th>
        </tr>
    </thead>
	<?php foreach ($modRiwayatHD as $i => $hd) { ?>
	<tr>
		<!--<td><?php //echo MyFormatter::formatDateTimeForUser($hd->periksahd_tgl);?></td>-->
		<td><?php 
			echo isset($hd->jenisdialisat_id) ? $hd->jenisdialisatrl->jenisdialisat_nama : ""; 
			echo ' / '.$hd->suhudialisis_c;
			?>
		</td>
		<td><?php echo MyFormatter::formatDateTimeForUser($hd->tglpenggunaanawal);?></td>
		<td><?php echo MyFormatter::formatDateTimeForUser($hd->periksahd_tgl);?></td>
		<td><?php echo $hd->dialiserke; ?></td>
		<td>
			<?php
			$perawat = PegawaiM::model()->findByPk($hd->pegawai_id);
			echo (isset($perawat->nama_pegawai))? $perawat->nama_pegawai : "";
			?>
		</td>
		<td style="text-align: center">
			<?php echo CHtml::link("<i class='icon-eye-open'></i>", '#', array('onclick'=>'viewDetailHD("'.$hd->periksahd_id.'","'.$_GET["pendaftaran_id"].'");return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail Hemodialisa'));  ?>
		</td>
		<td style="text-align: center">
			<?php
            echo CHtml::link("<i class='icon-pencil'></i>", array($this->id.'/index', 'pendaftaran_id'=>$hd->pendaftaran_id, 'pasien_id'=>$hd->pasien_id, 'periksahd_id'=>$hd->periksahd_id)); 
			?>
		</td>
        <td style="text-align: center">
            <?php 
            $periksahd_id = isset($_GET['periksahd_id']) ? $_GET['periksahd_id'] : null;
            if($hd->periksahd_id != $periksahd_id){
            ?>
                <center><a onclick="hapushemodialisa('<?php echo $hd->periksahd_id; ?>','<?php echo $hd->pasien_id; ?>',this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Pemeriksaan Hemodialisa"><i class="entypo-trash"></i></a></center>
            <?php
            }
            ?>
        </td>
	</tr>
	<?php } ?>
</table>

<script>
	
	function viewDetailHD(idHD,pendaftaran_id){

		$.post('<?php echo $this->createUrl('ajaxDetailHD') ?>', {idHD: idHD, pendaftaran_id: pendaftaran_id}, function(data){
		    $('#contentDetailHD').html(data.result);
	    }, 'json');
	    $('#dialogDetailHD').dialog('open');
    }
    
    function hapushemodialisa(periksahd_id,pasien_id,obj)
    {
        tabel = obj;
        myConfirm('Apakah anda akan menghapus Pemeriksaan Hemodialisa ini?', 'Perhatian!', function(r)
        {
            if(r){
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('hapusRiwayatHemodialisa'); ?>',
                    data: {periksahd_id:periksahd_id,pasien_id:pasien_id},
                    dataType: "json",
                    success:function(data){
                        if(data.sukses){
                            var delete_row = $(tabel).parents('tr');
                            delete_row.detach();
                            $("#<?php echo CHtml::activeId($modPeriksaHD, "dialiserke");  ?>").val(data.jmlDialisat);
                        }
                        myAlert(data.pesan);
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });
            }
        });
    }
	
</script>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailHD',
    'options'=>array(
        'title'=>'Detail Hemodialisa',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    echo '<div id="contentDetailHD">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>