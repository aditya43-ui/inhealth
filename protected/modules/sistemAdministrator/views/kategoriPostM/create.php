<?php
/**
 * digunakan untuk modul portal rs post berita
 * RSST-2443
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 */
?>
<div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Tambah Kategori Berita</span>&nbsp;<span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setPegawaiReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data pegawai')); ?></span></div>
            </div>
            <div class="panel-body" style="overflow-x: scroll">  
                <?php
                    $this->widget('bootstrap.widgets.BootAlert');
                    //$this->renderPartial('_tabMenu',array());
                ?>
                    <div class="row-fluid">
                        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
                    </div>
            </div>
</div>	
