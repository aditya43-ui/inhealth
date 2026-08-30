<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
?>
<style>
    .form-horizontal .control-label{
        text-align: right;
        width: 180px
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Dokumen Pengadaan</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $this->widget('bootstrap.widgets.BootAlert');

                $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                    'id'=>'kelengkapan-m-form',
                    'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
                    'focus'=>'#',
                )); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Kelengkapan Kontrak</div>
                    </div>
                    <div class="panel-body">
                        <div class="row-fluid">
                            <div class="col-md-12">
                                <?php echo $form->textFieldRow($model, 'nama_pekerjaan', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textFieldRow($model, 'metode_pengadaan', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                <div class="control-group">
                                    <label class="control-label"> Nomor RUP / Kode SiRUP </label>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'rencanaumumpengadaan_nomor', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?> /
                                        <?php echo $form->textField($model, 'kode_rup', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"> Nomor Persiapan Pengadaan </label>
                                    <div class="controls">
                                        <?php echo $form->textField($modDokumenPengadaan, 'persiapanpengadaan_nomor', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"> Pejabat Pembuat Komitmen </label>
                                    <div class="controls">
                                        <?php echo $form->textField($modDokumenPengadaan, 'nama_pegawai', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"> Nilai HPS </label>
                                    <div class="controls">
                                        <?php
                                            $modDokumenPengadaan->total_pagu = number_format($modDokumenPengadaan->total_pagu,  2, ",", ".");
                                            echo $form->textField($modDokumenPengadaan, 'total_pagu', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                                        ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"> Nilai Kontrak </label>
                                    <div class="controls">
                                        <?php 
                                            $modDokumenPengadaan->nilaikontrak = number_format($modDokumenPengadaan->nilaikontrak,  2, ",", ".");
                                            echo $form->textField($modDokumenPengadaan, 'nilaikontrak', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                                        ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">&nbsp;</label>
                                    <div class="controls">
                                        <table width="50%" class="table table-striped table-bordered table-condensed">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center">Jenis Dokumen</th>
                                                    <th style="text-align: center">Nomor Dokumen</th>
                                                    <th style="text-align: center">Tanggal Dokumen</th>
                                                    <th style="text-align: center">Perbaruan Terakhir</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> Pembuka Penawaran</td>
                                                    <td> <?php echo !empty($modKelengkapan->pembukaanpenawaran_nodok) ? $modKelengkapan->pembukaanpenawaran_nodok : "-"; ?></td>
                                                    <td> <?php echo !empty($modKelengkapan->pembukaanpenawaran_tanggal)?date('d ', strtotime($modKelengkapan->pembukaanpenawaran_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($modKelengkapan->pembukaanpenawaran_tanggal))) . date(' Y', strtotime($modKelengkapan->pembukaanpenawaran_tanggal)):"-"; ?></td>
                                                    <td> <?php
                                                    if (!empty($modKelengkapan->pembukaanpenawaran_perbaruanuser) && !empty($modKelengkapan->pembukaanpenawaran_perbaruanwaktu)) {
                                                        $user = $modKelengkapan->pembukaanpenawaran_perbaruanuser;
                                                        $waktu = date("d/m/Y H:i:s",strtotime($modKelengkapan->pembukaanpenawaran_perbaruanwaktu));
                                                        echo $user . ' <br> ' . $waktu;
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> Evaluasi Penawaran</td>
                                                    <td> <?php echo !empty($modKelengkapan->evaluasipenawaran_nodok)?$modKelengkapan->evaluasipenawaran_nodok:"-"; ?></td>
                                                    <td> <?php echo !empty($modKelengkapan->evaluasipenawaran_tanggal)?date('d ', strtotime($modKelengkapan->evaluasipenawaran_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($modKelengkapan->evaluasipenawaran_tanggal))) . date(' Y', strtotime($modKelengkapan->evaluasipenawaran_tanggal)):"-"; ?></td>
                                                    <td> <?php
                                                    if (!empty($modKelengkapan->evaluasipenawaran_perbaruanuser) && !empty($modKelengkapan->evaluasipenawaran_perbaruanwaktu)) {
                                                        $user = $modKelengkapan->evaluasipenawaran_perbaruanuser;
                                                        $waktu = date("d/m/Y H:i:s",strtotime($modKelengkapan->evaluasipenawaran_perbaruanwaktu));
                                                        echo $user . ' <br> ' . $waktu;
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> BA Klarifikasi/Negosiasi</td>
                                                    <td> <?php echo !empty($modKelengkapan->banegosiasi_nodok)?$modKelengkapan->banegosiasi_nodok:"-"; ?></td>
                                                    <td> <?php echo !empty($modKelengkapan->banegosiasi_tanggal)?date('d ', strtotime($modKelengkapan->banegosiasi_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($modKelengkapan->banegosiasi_tanggal))) . date(' Y', strtotime($modKelengkapan->banegosiasi_tanggal)):"-"; ?></td>
                                                    <td> <?php
                                                    if (!empty($modKelengkapan->banegosiasi_perbaruanuser) && !empty($modKelengkapan->banegosiasi_perbaruanwaktu)) {
                                                        $user = $modKelengkapan->banegosiasi_perbaruanuser;
                                                        $waktu = date("d/m/Y H:i:s",strtotime($modKelengkapan->banegosiasi_perbaruanwaktu));
                                                        echo $user . ' <br> ' . $waktu;
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> BA Hasil Pengadaan Langsung</td>
                                                    <td> <?php echo !empty($modKelengkapan->bapengadaanlangsung_nodok)?$modKelengkapan->bapengadaanlangsung_nodok:"-"; ?></td>
                                                    <td> <?php echo !empty($modKelengkapan->bapengadaanlangsung_tanggal)?date('d ', strtotime($modKelengkapan->bapengadaanlangsung_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($modKelengkapan->bapengadaanlangsung_tanggal))) . date(' Y', strtotime($modKelengkapan->bapengadaanlangsung_tanggal)):"-"; ?></td>
                                                    <td> <?php
                                                    if (!empty($modKelengkapan->bapengadaanlangsung_perbaruanuser) && !empty($modKelengkapan->bapengadaanlangsung_perbaruanwaktu)) {
                                                        $user = $modKelengkapan->bapengadaanlangsung_perbaruanuser;
                                                        $waktu = date("d/m/Y H:i:s",strtotime($modKelengkapan->bapengadaanlangsung_perbaruanwaktu));
                                                        echo $user . ' <br> ' . $waktu;
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> Penetapan Pemenang</td>
                                                    <td> <?php echo !empty($modKelengkapan->penetapanpemenang_nodok)?$modKelengkapan->penetapanpemenang_nodok:"-"; ?></td>
                                                    <td> <?php echo !empty($modKelengkapan->penetapanpemenang_tanggal)?date('d ', strtotime($modKelengkapan->penetapanpemenang_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($modKelengkapan->penetapanpemenang_tanggal))) . date(' Y', strtotime($modKelengkapan->penetapanpemenang_tanggal)):"-"; ?></td>
                                                    <td> <?php
                                                    if (!empty($modKelengkapan->penetapanpemenang_perbaruanuser) && !empty($modKelengkapan->penetapanpemenang_perbaruanwaktu)) {
                                                        $user = $modKelengkapan->penetapanpemenang_perbaruanuser;
                                                        $waktu = date("d/m/Y H:i:s",strtotime($modKelengkapan->penetapanpemenang_perbaruanwaktu));
                                                        echo $user . ' <br> ' . $waktu;
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> Pengumuman Pemenang</td>
                                                    <td> <?php echo !empty($modKelengkapan->pengumumanpemenang_nodok)?$modKelengkapan->pengumumanpemenang_nodok:"-"; ?></td>
                                                    <td> <?php echo !empty($modKelengkapan->pengumumanpemenang_tanggal)?date('d ', strtotime($modKelengkapan->pengumumanpemenang_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($modKelengkapan->pengumumanpemenang_tanggal))) . date(' Y', strtotime($modKelengkapan->pengumumanpemenang_tanggal)):"-"; ?></td>
                                                    <td> <?php
                                                    if (!empty($modKelengkapan->pengumumanpemenang_perbaruanuser) && !empty($modKelengkapan->pengumumanpemenang_perbaruanwaktu)) {
                                                        $user = $modKelengkapan->pengumumanpemenang_perbaruanuser;
                                                        $waktu = date("d/m/Y H:i:s",strtotime($modKelengkapan->pengumumanpemenang_perbaruanwaktu));
                                                        echo $user . ' <br> ' . $waktu;
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> Penunjukan Penyedia</td>
                                                    <td> <?php echo !empty($modKelengkapan->penunjukanpenyedia_nodok)?$modKelengkapan->penunjukanpenyedia_nodok:"-"; ?></td>
                                                    <td> <?php echo !empty($modKelengkapan->penunjukanpenyedia_tanggal)?date('d ', strtotime($modKelengkapan->penunjukanpenyedia_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($modKelengkapan->penunjukanpenyedia_tanggal))) . date(' Y', strtotime($modKelengkapan->penunjukanpenyedia_tanggal)):"-"; ?></td>
                                                    <td> <?php
                                                    if (!empty($modKelengkapan->penunjukanpenyedia_perbaruanuser) && !empty($modKelengkapan->penunjukanpenyedia_perbaruanwaktu)) {
                                                        $user = $modKelengkapan->penunjukanpenyedia_perbaruanuser;
                                                        $waktu = date("d/m/Y H:i:s",strtotime($modKelengkapan->penunjukanpenyedia_perbaruanwaktu));
                                                        echo $user . ' <br> ' . $waktu;
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> Kontrak</td>
                                                    <td> <?php echo !empty($modKelengkapan->kontrak_nodok)?$modKelengkapan->kontrak_nodok:"-"; ?></td>
                                                    <td> <?php echo !empty($modKelengkapan->kontrak_kontrak)?date('d ', strtotime($modKelengkapan->kontrak_kontrak)) . MyFormatter::getMonthId(date('m', strtotime($modKelengkapan->kontrak_kontrak))) . date(' Y', strtotime($modKelengkapan->kontrak_kontrak)):"-"; ?></td>
                                                    <td> <?php
                                                    if (!empty($modKelengkapan->kontrak_perbaruanuser) && !empty($modKelengkapan->kontrak_perbaruanwaktu)) {
                                                        $user = $modKelengkapan->kontrak_perbaruanuser;
                                                        $waktu = date("d/m/Y H:i:s",strtotime($modKelengkapan->kontrak_perbaruanwaktu));
                                                        echo $user . ' <br> ' . $waktu;
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> SSKK</td>
                                                    <td> <?php echo !empty($modKelengkapan->syaratkhusukontrak_nodok)?$modKelengkapan->syaratkhusukontrak_nodok:"-"; ?></td>
                                                    <td> <?php echo !empty($modKelengkapan->syaratkhususkontrak_tanggal)?date('d ', strtotime($modKelengkapan->syaratkhususkontrak_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($modKelengkapan->syaratkhususkontrak_tanggal))) . date(' Y', strtotime($modKelengkapan->syaratkhususkontrak_tanggal)):"-"; ?></td>
                                                    <td> <?php
                                                    if (!empty($modKelengkapan->syaratkhususkontrak_perbaruanuser) && !empty($modKelengkapan->syaratkhususkontrak_perbaruanwaktu)) {
                                                        $user = $modKelengkapan->syaratkhususkontrak_perbaruanuser;
                                                        $waktu = date("d/m/Y H:i:s",strtotime($modKelengkapan->syaratkhususkontrak_perbaruanwaktu));
                                                        echo $user . ' <br> ' . $waktu;
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> Perintah Mulai Kerja</td>
                                                    <td> <?php echo !empty($modKelengkapan->perintahmulaikerja_nodok)?$modKelengkapan->perintahmulaikerja_nodok:"-"; ?></td>
                                                    <td> <?php echo !empty($modKelengkapan->perintahmulaikerja_tanggal)?date('d ', strtotime($modKelengkapan->perintahmulaikerja_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($modKelengkapan->perintahmulaikerja_tanggal))) . date(' Y', strtotime($modKelengkapan->perintahmulaikerja_tanggal)):"-"; ?></td>
                                                    <td> <?php
                                                    if (!empty($modKelengkapan->perintahmulaikerja_perbaruanuser) && !empty($modKelengkapan->perintahmulaikerja_perbaruanwaktu)) {
                                                        $user = $modKelengkapan->perintahmulaikerja_perbaruanuser;
                                                        $waktu = date("d/m/Y H:i:s",strtotime($modKelengkapan->perintahmulaikerja_perbaruanwaktu));
                                                        echo $user . ' <br> ' . $waktu;
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <?php foreach ($modKelengkapanSurat as $i=>$surat) {?>
                                                    <td> Perintah Pengiriman </td>
                                                    <td> <?php echo !empty($surat->perintahpengiriman_nodok)?$surat->perintahpengiriman_nodok:"-"; ?></td>
                                                    <td> <?php echo !empty($surat->perintahpengiriman_tanggal)?date('d ', strtotime($surat->perintahpengiriman_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($surat->perintahpengiriman_tanggal))) . date(' Y', strtotime($surat->perintahpengiriman_tanggal)):"-"; ?></td>
                                                    <td> <?php
                                                    if (!empty($surat->perintahpengiriman_perbaruanuser) && !empty($surat->perintahpengiriman_perbaruanwaktu)) {
                                                        $user = $surat->perintahpengiriman_perbaruanuser;
                                                        $waktu = date("d/m/Y H:i:s",strtotime($surat->perintahpengiriman_perbaruanwaktu));
                                                        echo $user . ' <br> ' . $waktu;
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                    </td>
                                                </tr>
                                                  <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php 
                    echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="entypo-left-bold"></i>')), 
                    Yii::app()->createUrl('pengadaan/InformasiDokumenPengadaan/index'),
                    array('class'=>'btn btn-success')); 
                ?>
                </div>
            <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');
    });
</script>