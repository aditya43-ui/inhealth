<div class="panel panel-success panel-shadow">
          <div class="panel-heading">
              <div class="panel-title"><strong>Riwayat Ringkasan Pasien Pulang</strong></div>
          </div>
          <div class="panel-body">
          <table class="items table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Penginputan</th>
                        <th>Dokter Pemeriksa</th>
                        <th>Ruangan</th>
                        <th>Lihat</th>
                        <th>Cetak</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($modRi != null) : ?>   
                        <?php $no = 1; foreach($modRi as $mod ) : ?>
                            <tr>
                                
                                <td><?= $no++ ?></td>
                                <td><?= $mod->tanggal_penginputan ?></td>
                                <td>
                                    <?php

                                        $pegawai = PegawaiM::model()->findByPk($mod->dokter_yangmerawat_id);

                                        echo $pegawai ? $pegawai->namaLengkap : "-";
                                    
                                    ?>
                                </td>
                                <td><?= $mod->ruangan->ruangan_nama ?></td>
                                <td style = 'text-align: center; width:60px;'>
                                    <?php 

                                       echo CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("/rawatInap/RingkasanMasukKeluar/lihatRiwayatPasienPulang",array("id"=>$mod->ringkasanmasukdankeluar_id,"frame"=>true)),
                                        array("class"=>"", 
                                            "target"=>"iframeRincianPasienPulang",
                                            "onclick"=>"$(\"#dialogRincianPasienPulang\").dialog(\"open\");",
                                            "rel"=>"tooltip",
                                            "title"=>"Klik untuk Lihat Riwayat Ringkasan Pasien Pulang",
                                        ));
                                    ?>
                                </td>
                                <td style = 'text-align: center; width:60px; padding-top:12px'>
                                    <?php 

                                       echo CHtml::Link("<i class=\"icon-print\"></i>",Yii::app()->controller->createUrl("/rawatInap/RingkasanMasukKeluar/print",array("id"=>$mod->ringkasanmasukdankeluar_id,"frame"=>true)),
                                        array("class"=>"", 
                                            "target"=>"iframeRincianPasienPulang",
                                            "onclick"=>"$(\"#dialogRincianPasienPulang\").dialog(\"open\");",
                                            "rel"=>"tooltip",
                                            "title"=>"Klik untuk Cetak Riwayat Ringkasan Pasien Pulang",
                                            
                                        ));
                                    ?>
                                </td>
                                <td style = 'text-align: center; width:60px; padding-top:12px'>
                                    <?php 

                                       echo CHtml::link("<i class='" . MyIcon::getIcons('batal') . "'></i>","#", array("submit"=>array('delete', 'id'=>$mod->ringkasanmasukdankeluar_id,'pendaftaran_id'=>$_GET['pendaftaran_id']), 'confirm' => 'Are you sure?'));?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php else : ?>
                            <tr>
                                <td colspan="7" style="text-align: center;"> Tidak ada riwayat ringkasan pasien pulang</td>
                            </tr>
                    <?php endif; ?>
                </tbody>
          </table>
          </div>
      </div>