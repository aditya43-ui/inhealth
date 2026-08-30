<div class='block-tabel'>
  <div style="overflow: auto">
    <table class="items table table-bordered table-striped table-condensed" width="100%">
      <thead>
        <tr>
          <th width="200px">Nama Pemeriksaan</th>
          <th width="300px">Jenis Pemeriksaan</th>
          <th>Kiri</th>
          <th>Kanan</th>
        </tr>
      </thead>
      <tbody>
          <?php
            $modMasterMMT = PemeriksaanmmtM::model()->findAllByAttributes(array('pemeriksaanmmt_aktif'=>true),array('order'=>'urutan asc'));

            if(count($modMasterMMT) > 0){
              $arrMMt = array();
              foreach ($modMasterMMT as $master) {
                $arrMMt[$master->nama_pemeriksaan][] = array('pemeriksaanmmt_id'=>$master->pemeriksaanmmt_id,'nama_pemeriksaan'=>$master->nama_pemeriksaan,'jenis_pemeriksaan'=>$master->jenis_pemeriksaan,'urutan'=>$master->urutan);
              }

              if(count($arrMMt)){
                $indexMMt = 0;
                foreach ($arrMMt as $nama => $lopMaster) {
                  ?>
                  <tr>
                    <td style="vertical-align: middle; text-align: center;" rowspan="<?php echo (count($lopMaster)+1); ?>"><?php echo $nama; ?></td>
                    <?php
                      foreach ($lopMaster as $dataLop) {
                        $kananData = "";
                        $kiriData = "";
                        if(isset($modAsesmenmmtT) && count($modAsesmenmmtT) > 0){
                          foreach ($modAsesmenmmtT as $periksafisikMMt) {
                            if($dataLop['pemeriksaanmmt_id'] == $periksafisikMMt->pemeriksaanmmt_id){
                              $kananData = $periksafisikMMt->kanan;
                              $kiriData = $periksafisikMMt->kiri;
                            }
                          }
                        }
                        ?>
                        <tr>
                          <td>
                            <?php echo $dataLop['jenis_pemeriksaan']; ?>
                          </td>
                          <td>
                            <?php echo CHtml::hiddenField('PemeriksaanFisikMMT['.$indexMMt.'][pemeriksaanmmt_id]',$dataLop['pemeriksaanmmt_id']) ?>
                            <?php echo CHtml::textField('PemeriksaanFisikMMT['.$indexMMt.'][kiri]',$kiriData,array('class'=>'span3', 'maxlengt'=>100)) ?>
                          </td>
                          <td>
                            <?php echo CHtml::textField('PemeriksaanFisikMMT['.$indexMMt.'][kanan]',$kananData,array('class'=>'span3', 'maxlengt'=>100)) ?>
                          </td>
                        </tr>
                        <?php
                        $indexMMt++;
                      }
                     ?>
                  </tr>
                  <?php
                }
              }
            }
          ?>
      </tbody>
    </table>
  </div>
</div>
