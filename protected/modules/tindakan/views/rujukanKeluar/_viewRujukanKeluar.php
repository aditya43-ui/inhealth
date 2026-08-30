
<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$modRujukanKeluar,
            'attributes'=>array(
          
                'tgldirujuk',
                'pegawai.nama_pegawai',
                array(
                    'name'=>'rujukankeluar_id',
                    'value'=>$modRujukanKeluar->rujukankeluar->rumahsakitrujukan,
                ),
                // 'rumahsakitrujukan',
                'nosuratrujukan',
                'kepadayth',
                'dirujukkebagian',
                array(
                    'name'=>'ruangan_id',
                    'value'=>$modRujukanKeluar->pendaftaran->ruangan->ruangan_nama,
                ),
                'catatandokterperujuk',

                'alasandirujuk',
                'hasilpemeriksaan_ruj',
                'diagnosasementara_ruj',
                'pengobatan_ruj',
                'lainlain_ruj',
            ),
    )); ?>

<div class="row">
        <div class="span12">
            <?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
                'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons'=>array(
                    array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'printRujukan(\'PRINT\','.$modRujukanKeluar->rujukankeluar_id.')')),
                    array('label'=>'', 'items'=>array(
                        array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'printRujukan(\'PDF\','.$modRujukanKeluar->rujukankeluar_id.')')),
                        array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'printRujukan(\'EXCEL\','.$modRujukanKeluar->rujukankeluar_id.')')),
                       
                    )),       
                ),
                'htmlOptions'=>array()
        //        'htmlOptions'=>array('class'=>'btn')
            )); ?>
        </div>
    </div>