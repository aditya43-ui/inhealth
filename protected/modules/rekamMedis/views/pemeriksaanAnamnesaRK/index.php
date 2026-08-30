<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><?php echo $this->judul; ?> </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-users"></i> Data <b>Kunjungan</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Sapendidikan Ms' => array('index'),
                    'Manage',
                );
                ?>
                <?php
                $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
                $this->renderPartial($this->path_view . '_tabMenu', array());
                $this->renderPartial($this->path_view . '_jsFunctions', array("modPasien" => $modPasien)); ?>
                <div>
                    <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
                </div>
            </div>
        </div>
    </div>
</div>