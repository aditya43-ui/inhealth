<?php 
    /**
     * @author Tim Developer ITKI <developer.itki@gmail.com>
     */
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rencanaumumpengadaan-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);')
    ));
    $this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row-fluid">
    <b> Daftar RUP yang akan Diumumkan </b>
    <br><br>
    <table class="table table-condensed table-bordered table-striped">
        <thead>
            <tr>
                <th style="text-align: center"> Nomor dan Tanggal RUP </th>
                <th style="text-align: center"> Bidang / Bagian / Instalasi </th>
                <th style="text-align: center"> Kategori Pengadaan </th>
                <th style="text-align: center"> Nama Pekerjaan </th>
                <th style="text-align: center"> Pagu </th>
                <th style="text-align: center"> Total RAB/HPS </th>
                <th style="text-align: center"> Tahun Anggaran </th>
                <th style="text-align: center"> Sumber Dana </th>
                <th style="text-align: center"> Status </th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($modRup as $i => $det)
                {
            ?>
                <tr>
                    <td style="text-align: center"> 
                        <?php 
                            echo '' . $det->rencanaumumpengadaan_nomor . '<br>' . $det->rencanaumumpengadaan_tanggal . '';
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                            $instalasi = InstalasiM::model()->findByPk($det->instalasi_id);
                            echo $instalasi->instalasi_nama;
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $det->rencanaumumpengadaan_kategori ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $det->nama_pekerjaan ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo 'Rp ' . number_format($det->dpa_pagu, 2, ',', '.') ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo 'Rp ' . number_format($det->total_pagu, 2, ',', '.') ?>   
                    </td>
                    <td style="text-align: center">
                        <?php
                            $tahun = InformasirencanaumumpengadaanV::model()->findBySql('select tahunanggaran, anggaran_nama, daftarsumberdana from informasirencanaumumpengadaan_v where rencanaumumpengadaan_id = '. $det->rencanaumumpengadaan_id .'');
                            echo '' . $tahun->tahunanggaran . ' - ' . $tahun->anggaran_nama . '';
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $tahun->daftarsumberdana ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                            echo $det->rencanaumumpengadaan_status;
                            echo $form->hiddenField($det,'['.$i.']rencanaumumpengadaan_id',array());
                        ?>
                    </td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    <div class="row-fluid">
        <div class="form-actions">
            <?php 
                if (!isset($_GET['sukses']))
                {
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'));
                }
                else
                {
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>true));
                }
                ?>
        </div>
    </div>
    <?php
        $this->endWidget();
    ?>
</div>

<script>
    $(document).ready(function(){
        <?php
            if (isset($_GET['sukses']))
            {
        ?>
                window.parent.clearCekLis();
        <?php
            }
        ?>
    });
</script>