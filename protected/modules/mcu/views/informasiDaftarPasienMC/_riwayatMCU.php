<?php

/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
        <i class="glyphicon glyphicon-file"></i> Riwayat Asesmen Awal Medis
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pembayaran-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#ASPendaftaranT_no_pendaftaran',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                // 'onsubmit'=>'return cekOtorisasi();'
            ),
        ));
        ?>

        <?php
        echo $this->renderPartial($this->path_view_askep . '_rowRiwayatAsesmenAwalMedis', array(
            'form' => $form,
            'modRiwayatAwalMedis' => $modRiwayatAwalMedis,
            'st' => 'asuhan'
        ), true);
        ?>

        <?php
        // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        //     'id' => 'asesmenawalmedis',
        //     'content' => array(
        //         'content-asesmenawalmedis' => array(
        //             'header' => '<b>Riwayat Asesmen Awal Medis</b>',
        //             'isi' => $this->renderPartial($this->path_view_askep . '_rowRiwayatAsesmenAwalMedis', array(
        //                 'form' => $form,
        //                 'modRiwayatAwalMedis' => $modRiwayatAwalMedis,
        //                 'st' => 'asuhan'
        //             ), true),
        //             'active' => true,
        //         ),
        //     ),
        // ));
        $this->endWidget(); ?>
    </div>
</div>