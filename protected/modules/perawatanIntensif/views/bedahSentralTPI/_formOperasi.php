<!--<fieldset class="box">-->
<table style="width: 100%; border: none;">
    <tr>
        <td>
        <div id="formOperasi">
    <?php foreach($modKegiatanOperasi as $i=>$kegiatanOperasi){ 
            $ceklist = false;
    ?>
            <!--<div class="boxtindakan">-->
                <!--<h6><?php // echo $kegiatanOperasi->kegiatanoperasi_nama; ?></h6>-->
            <div class="boxtindakan">
                <div class="panel panel-success">
                        <div class="panel-heading">
                                <div class="panel-title"><?php echo $kegiatanOperasi->kegiatanoperasi_nama; ?></div>
                        </div>
                        <div class="panel-body">
                                <?php foreach ($modOperasi as $j => $operasi) {
                                        if($kegiatanOperasi->kegiatanoperasi_id == $operasi->kegiatanoperasi_id) {
                                                echo '<label class="checkbox inline">'.CHtml::checkBox("operasi[]", $ceklist, array('value'=>$operasi->operasi_id,
                                                'onclick' => "inputOperasi(this);"));
                                                echo "<span>".$operasi->operasi_nama."</span></label><br>";
                                        }
                                } ?>
                        </div>
                </div>										
            </div>
                <?php 
//					$dataCekOp = '';
//					foreach ($modOperasi as $j => $operasi) {
//                         if($kegiatanOperasi->kegiatanoperasi_id == $operasi->kegiatanoperasi_id) {
//                             $dataCekOp .= '<label class="checkbox inline">'.CHtml::checkBox("operasi[]", $ceklist, array('value'=>$operasi->operasi_id,
//                                                                                      'onclick' => "inputOperasi(this);"));
//                             $dataCekOp .= "<span>".$operasi->operasi_nama."</span></label><br>";
//                         }
//                     } 
				?>
            <!--</div>-->
			
					<?php
//					if(!empty($dataCekOp)){
//						echo '<div class="boxtindakan">';
//						echo '<h6>'.$kegiatanOperasi->kegiatanoperasi_nama.'</h6>';
//						echo $dataCekOp;
//						echo ' </div>';
//					}
					?>
			
    <?php } ?>
        </div>
        </td>
    </tr>
</table>
<!--</fieldset>-->
<script>
    $('#formOperasi').tile({widths : [ 198 ]});
</script>