
                <?php foreach ($modKegiatanOperasi as $i => $kegiatanOperasi) {
                    $ceklist = false;

                    $cekperiksa = '';
                ?>
                   
                   <?php 
                   if(!empty($modOperasi)) {
                   foreach ($modOperasi as $j => $operasi) {
                                    if ($kegiatanOperasi->kegiatanoperasi_id == $operasi->kegiatanoperasi_id) {
                                        $cekperiksa .= '<label class="checkbox inline">' . CHtml::checkBox("operasi[]", $ceklist, array(
                                            'value' => $operasi->operasi_id,
                                            'onclick' => "inputOperasi(this);"
                                        ));
                                        $cekperiksa .= "<span>" . $operasi->operasi_nama . "</span></label><br>";
                                    }
                                } 
                            ?>

                    
                    <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'tabel-checklist-' . $i . '-' . $j,
                            'content' => array(
                                'content-checklist-' . $i . '-' . $j => array(
                                    'header' => '<h6>' . $kegiatanOperasi->kegiatanoperasi_nama .  '</h6>',
                                    'isi' => $cekperiksa,
                                    'active' => false,
                                ),
                            ),
                        ));
                    }
                    ?>
                <?php } ?>