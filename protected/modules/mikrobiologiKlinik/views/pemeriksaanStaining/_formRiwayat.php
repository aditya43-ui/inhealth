<div class = "col-sm-12">
    <table class="table table-bordered" id="table-riwayat-staining">
        <thead>
            <tr>
                <th style="text-align: center">No.</th>
                <th style="text-align: center">Tgl Staining</th>
                <!--<th style="text-align: center">Analis</th>-->
                <th style="text-align: center">Status Verifikasi</th>
                <th style="text-align: center">Lihat</th>
                <th style="text-align: center">Ubah</th>
                <th style="text-align: center">Hapus</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($dataStaining as $key => $value) {
                $style = null;
                if (isset($_GET['staining_id'])) {
                    if ($_GET['staining_id'] == $value->staining_id) {
                        $style = " style='background-color: #fafccd'";
                    }
                }
                if ($value->status_verifikasi == "Terverifikasi") {
                    $update = "<span style='font-size:13px'> <i class ='entypo-pencil'> </i></span>";
                    $hapus = "<span style='font-size:13px'>  <i class ='entypo-trash'> </i></span>";
                } else {
                    $update = CHtml::link("<span style='font-size:13px'> <i class ='entypo-pencil'> </i></span>", $this->createUrl('index', array('spesimen_id' => $value->spesimen_id, 'staining_id' => $value->staining_id)), array('class' => 'hover'));
                    $hapus = CHtml::link("<span style='font-size:13px'> <i class ='entypo-trash'> </i></span>", "#", array('onclick' => 'hapusTransaksiStaining(' . $value->staining_id . ', this);return false;', 'class' => 'hover'));
                }
                ?>

                <tr <?= $style ?>>

                    <td style='text-align: center' id='no-urut'> <?= ($key + 1) ?></td>
                    <td style='text-align: center'> <?= MyFormatter::formatDateTimeForUser($value->tanggal_staining) ?></td>
                    <!--<td> <? $value->analis->namaLengkap ?></td>-->
                    <td style='text-align: center'> <?= $value['status_verifikasi'] ?></td>
                    <td style='text-align: center'>
                        <?php echo CHtml::link("<span style='font-size:13px'> <i class ='entypo-eye'> </i></span>", $this->createUrl('detail', array('staining_id' => $value->staining_id)), array('class' => 'hover', "target"=>"iframeDetail",
                        "onclick"=>"$('#dialogDetail').dialog('open');",)); ?>
                        </td>
                    <td style='text-align: center'> <?= $update ?></td>
                    <td style='text-align: center'> <?= $hapus ?></td>
                </tr>
                <?php 
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
// ===========================Dialog Details Rencana Umum Pengadaan=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogDetail',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Detail Staining',
            'autoOpen' => false,
            'width' => 1070,
            'height' => 650,
            'resizable' => true,
            'scroll' => false,
        ),
    ));
    ?>
    <iframe src="" name="iframeDetail" width="100%" height="100%">
    </iframe>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>