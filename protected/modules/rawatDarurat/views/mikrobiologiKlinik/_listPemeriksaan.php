<?php
/**
 * mengenerate daftar pemeriksaan mikrobiologi klinik
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
if (!empty($tarif_gen)){
    foreach($tarif_gen as $jns){
        $ceklist = false;
        $patologi = $jns['jenispemeriksaanlab_kelompok'];
        if($patologi==Params::PATOLOGI_MIKROBIOLOGI_KLINIK){
?>
         <div class="col-sm-4">
            <div class="boxtindakan">
                    <div class="panel panel-success panel-shadow">
                            <div class="panel-heading">
                                    <div class="panel-title"><h6><?php echo $jns['jenispemeriksaanlab_nama']; ?></h6></div>
                            </div>
                            <div class="panel-body">
                                    <?php   foreach ($jns['det'] as $j => $pr) {                                                                                                                            
                                                echo '<label class="checkbox inline">'.CHtml::checkBox("pemeriksaanLab[]", $ceklist, array('value'=>$pr['pemeriksaanlab_id'],
                                                'onclick' => "inputPeriksaSatu(this);",'id'=>'pemeriksaanlabid', 'data-kode_unik'=>$pr['kode_unik']));
                                                echo "<span>".$pr['pemeriksaanlab_nama']."</span></label><br/>";                                                                                                                            
                                    } ?>
                            </div>
                    </div>

            </div>
        </div>
<?php
        }
    }
}

?>
