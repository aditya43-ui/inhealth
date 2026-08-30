<table style="width: 100%; border: none;">
    <tr>
        <td>
        <div id="formOperasi">
    <?php foreach($modKegiatanOperasi as $i=>$kegiatanOperasi){ 
            $ceklist = false;
    ?>
        <div class="jquery-tiler-block">
            <div class="boxtindakan" style="margin-bottom: 17px;">
				<div class="panel panel-success">
					<div class="panel-heading">
						<!--<h6><?php //echo $kegiatanOperasi->kegiatanoperasi_nama; ?></h6>-->
						<div class="panel-title"><?php echo $kegiatanOperasi->kegiatanoperasi_nama; ?></div>
					</div>
					<div class="panel-body">
                <?php foreach ($modOperasi as $j => $operasi) {
                    //      if($kegiatanOperasi->kegiatanoperasi_id == $operasi->kegiatanoperasi_id) {
                    //          echo '<label class="checkbox inline">'.CHtml::checkBox("operasi[]", $ceklist, array('value'=>$operasi->operasi_id,
                    //                                                                   'onclick' => "inputOperasi(this);"));
                    //          echo "<span>".$operasi->operasi_nama."</span></label><br>";
                    //      }
                    //  } 
                    if($kegiatanOperasi->kegiatanoperasi_id == $operasi->kegiatanoperasi_id) {
                        echo '<div class="pilih_periksa"><label class="checkbox inline" data-nama="'.strtolower($operasi->operasi_nama).'" data-jenis="'.$kegiatanOperasi->kegiatanoperasi_id.'">'.CHtml::checkBox("operasi[]", $ceklist, array('value'=>$operasi->operasi_id,
                                                                                 'onclick' => "inputOperasi(this);"));
                            echo "<span>".$operasi->operasi_nama."</span></label><br></div>";
                         }
                    } ?>
					</div>
				</div>
             </div>
            </div>
    <?php } ?>
        </div>
        </td>
    </tr>
</table>
<script>
    $('#formOperasi').tile({widths : [ 198 ]});
</script>