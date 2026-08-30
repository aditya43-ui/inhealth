<style>
    .uang {
        text-align: right !important;
    }
</style>

<div class="col-sm-12">
    <?php
    echo $this->renderPartial('application.views.headerReport.headerAnggaran', array('judulLaporan' => $judulLaporan, 'deskripsi' => $deskripsi, 'colspan' => 10));

    $sukses = null;
    if (isset($_GET['sukses'])) {
        $sukses = $_GET['sukses'];
    }
    if ($sukses > 0) {
        Yii::app()->user->setFlash('success', "Status Mengetahui berhasil disimpan!");
    }
    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <table bgcolor='white' class='table' style="box-shadow:none;">
        <tr bgcolor='white'>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('nomorindukpegawai')); ?></b>
            </td>
            <td>
                : <?php echo CHtml::encode($modelpegawai->nomorindukpegawai); ?>
            </td>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('nama_pegawai')); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->nama_pegawai); ?></td>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('tempatlahir_pegawai')); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->tempatlahir_pegawai); ?></td>
        </tr>
        <tr>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('tgl_lahirpegawai')); ?></b>
            </td>
            <td>
                : <?php echo !empty($modelpegawai->tgl_lahirpegawai) ? MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($modelpegawai->tgl_lahirpegawai)))) : "-" ?>
            </td>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('jeniskelamin')); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->jeniskelamin); ?></td>
            <td>
                <b><?php echo CHtml::encode("Jabatan"); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->jabatan_nama); ?></td>

        </tr>
        <tr>
            <td>
                <b><?php echo CHtml::encode("No Rekening"); ?></b>
            </td>
            <td>
                : <?php echo CHtml::encode($modelpegawai->norekening); ?> <?php echo CHtml::encode($modelpegawai->banknorekening); ?>
            </td>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('npwp')); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->npwp); ?></td>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('notelp_pegawai')); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->notelp_pegawai); ?> <?php echo CHtml::encode($modelpegawai->nomobile_pegawai); ?></td>
        </tr>
        <tr>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('agama')); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->agama); ?></td>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('alamat_pegawai')); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->alamat_pegawai); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>

    <div class="row">
        <div class="col-sm-6">
            <table bgcolor='white' class='table' style="box-shadow:none;">
                <tr bgcolor='white'>
                    <td>
                        <b><?php echo CHtml::encode($model->getAttributeLabel('tglpesangon')); ?></b>
                    </td>
                    <td>
                        : <?php echo !empty($model->tglpesangon) ? MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($model->tglpesangon)))) : "-" ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b><?php echo CHtml::encode($model->getAttributeLabel('nopesangon')); ?></b>
                    </td>
                    <td>: <?php echo CHtml::encode($model->nopesangon); ?></td>
                </tr>
                <tr>
                    <td>
                        <b><?php echo CHtml::encode($model->getAttributeLabel('keterangan')); ?></b>
                    </td>
                    <td>: <?php echo CHtml::encode($model->keterangan); ?></td>
                </tr>
                <tr>
                    <td>
                        <b><?php echo CHtml::encode($model->getAttributeLabel('totalpajak')); ?></b>
                    </td>
                    <td>: <?php echo CHtml::encode($model->totalpajak); ?></td>
                </tr>
                <tr>
                    <td>
                        <b><?php echo CHtml::encode($model->getAttributeLabel('penerimaanbersih')); ?></b>
                    </td>
                    <td>: <?php echo CHtml::encode($model->penerimaanbersih); ?></td>
                </tr>
            </table>
        </div>
        <div class="col-sm-6">
            <table id="tableObatAlkes" class="table border" bgcolor='white'>
                <thead>
                    <th>Deskripsi</th>
                    <th>Pesangon</th>
                    <th>Potongan</th>
                </thead>
                <tbody>
                    <?php foreach ($kom as $item) :
                        $komdat = KomponengajiM::model()->findByPk($item->komponengaji_id);

                    ?>
                        <tr bgcolor='white'>
                            <td bgcolor='white'><?php echo $komdat->komponengaji_nama; ?></td>
                            <td bgcolor='white' style="text-align: right;"><?php if (!$komdat->ispotongan) echo MyFormatter::formatNumberForPrint($item->jumlah); ?></td>
                            <td bgcolor='white' style="text-align: right;"><?php if ($komdat->ispotongan) echo MyFormatter::formatNumberForPrint($item->jumlah); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th style="text-align: right">
                            Total
                        </th>
                        <th>
                            <?php echo CHtml::encode($model->totalterima); ?>
                        </th>
                        <th>
                            <?php echo CHtml::encode($model->totalpotongan); ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!--<table bgcolor='white' class='table' style = "box-shadow:none;">
    <tr bgcolor='white' >
        <td>
             <b><?php // echo CHtml::encode($model->getAttributeLabel('nopembelian')); 
                ?></b>
        </td>
        <td>
            : <?php // echo CHtml::encode($model->nopembelian); 
                ?>
        </td>
        <td>
            &nbsp;
        </td>    
        <td>
            <b><?php // echo CHtml::encode($model->getAttributeLabel('peg_pemesanan_id')); 
                ?></b>            
        </td>
        <td>: <?php // echo CHtml::encode($model->pemesan->nama_pegawai); 
                ?></td>
    </tr>
    <tr>
        <td>
             <b><?php // echo CHtml::encode($model->getAttributeLabel('tglpembelian')); 
                ?></b>
        </td>
        <td>
            : <?php // echo !empty($model->tglpembelian)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($model->tglpembelian)))):"-" 
                ?>
        </td>
        <td>
            &nbsp;
        </td> 
        <td>
             <b><?php // echo "Supplier" 
                ?></b>            
        </td>
        <td>
            : <?php
                //                $nama = SupplierM::model()->findByAttributes(array('supplier_id'=>$model->supplier_id));
                //                echo $nama->supplier_nama;
                ?>
        </td>
    </tr>
    <tr>
        <td>
             <b><?php // echo CHtml::encode($model->getAttributeLabel('tgldikirim')); 
                ?></b>
        </td>
        <td>
            : <?php // echo !empty($model->tgldikirim)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($model->tgldikirim)))):"-"; 
                ?>
        </td>
    </tr>
        
</table>

<table id="tableBarang" class="table border" bgcolor='white'>
    <thead>
        <th>No.Urut</th>
        <th>Golongan</th>
        <th>Bidang</th>
        <th>Kelompok</th>
        <th>Sub Kelompok</th>
        <th>Sub Sub Kelompok</th>
        <th>Barang</th>
        <th>Harga Beli</th>
        <th>Harga Satuan</th>
        <th>Jumlah Beli</th>
        <th>Satuan</th>
        <th>Ukuran<br>Bahan</th>
    </thead>
    <tbody>
    <?php
    //    $no=1;
    //        foreach($modDetailBeli AS $detail): 
    ?>
        <?php // $modBarang = BarangM::model()->findByPk($detail->barang_id); 
        ?>
            <tr bgcolor='white'>   
                <td bgcolor='white'><?php // echo $no; 
                                    ?></td>
                <td bgcolor='white'><?php // echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->bidang->golongan->golongan_nama:null;  
                                    ?></td>
                <td bgcolor='white'><?php // echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->bidang->bidang_nama:null;  
                                    ?></td>
                <td bgcolor='white'><?php // echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->kelompok_nama:null; 
                                    ?></td>
                <td bgcolor='white'><?php // echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->subkelompok_nama:null; 
                                    ?></td>
                <td bgcolor='white'><?php // echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subsubkelompok_nama:null; 
                                    ?></td>
                <td bgcolor='white'><?php // echo $modBarang->barang_nama; 
                                    ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php // echo "Rp".$format->formatNumberForPrint($detail->hargabeli); 
                                                                ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php // echo "Rp".$format->formatNumberForPrint($detail->hargasatuan); 
                                                                ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php // echo $format->formatNumberForPrint($detail->jmlbeli).' '.$detail->satuanbeli; 
                                                                ?></td>
                <td bgcolor='white'><?php //echo $detail->satuanbeli; 
                                    ?></td>
                <td bgcolor='white'><?php // echo $modBarang->barang_ukuran; 
                                    ?><br><?php // echo $modBarang->barang_bahan; 
                                            ?></td>
            </tr>   
            <?php
            //        $no++;
            //        
            //        endforeach;

            ?>
    </tbody>
</table>-->
    <div class="row">
        <div class="col-sm-4" style="text-align:center;">
            <?php
            if (isset($_GET['sukses'])) {
                echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
                echo "Mengetahui (RS),";
            } else {
                echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
                if ($model->mengetahui_id == Yii::app()->user->getState('pegawai_id')) {
                    echo CHtml::link(
                        Yii::t('mds', ' Mengetahui (RS)'),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'class' => 'btn btn-danger',
                            'onclick' => 'myConfirm("Apakah Anda yakin?","Perhatian!",
                                            function(r) {if(r) window.location = "' . $this->createUrl('ApproveMengetahui', array('pesangonpeg_id' => $model->pesangonpeg_id, 'approve' => true)) . '";} ); return false;'
                        )
                    );
                } else {
                    echo CHtml::link(
                        Yii::t('mds', ' Mengetahui (RS)'),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'class' => 'btn btn-danger',
                            'onclick' => 'myAlert("Maaf, Anda tidak berhak Mengapprove Pegawai Mengetahui Pesangon Pegawai ini."); return false;'
                        )
                    );
                }
            }
            ?>
        </div>
        <div class="control-group">
            ( <?php echo $model->mengetahui; ?> )
        </div>
    </div>
    <div class="col-sm-4" style="text-align:center;">

    </div>
    <div class="col-sm-4" style="text-align:center;">

    </div>
</div>

<?php
echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
$urlPrint = $this->createUrl('printApproveMengetahui', array('pesangonpeg_id' => $model->pesangonpeg_id));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
</div>