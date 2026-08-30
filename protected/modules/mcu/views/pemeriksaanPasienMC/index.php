<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan Pasien Klinik GCU
            <!-- <b>
                <?php
              //  $konsulpoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
              // echo (!empty($konsulpoli->konsulpoli_id)) ? $konsulpoli->politujuan->ruangan_nama : $modPendaftaran->ruangan->ruangan_nama; 
                ?>
            </b> -->
        </div>
    </div>
    <div class="panel-body">
        <?php echo CHtml::link('<i class="entypo-back"></i> Kembali', $this->createUrl('InformasiDaftarPasienMC/index'), array('class' => 'btn btn-success', 'style' => 'margin-bottom: 10px;',)); ?>
        <?php
        $this->breadcrumbs = array(
            'Informasi Pasien MCU' => Yii::app()->request->getUrlReferrer(),
            'Pemeriksaan Pasien'
        );
        ?>
        <?php
        $this->renderPartial($this->path_view_mcu . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
        $this->renderPartial($this->path_view_mcu . '_tabMenu', array());
        $this->renderPartial($this->path_view_mcu . '_jsFunctions', array("modPasien" => $modPasien, 'modPendaftaran' => $modPendaftaran)); ?>
        <div>
            <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
        </div>
    </div>
</div>