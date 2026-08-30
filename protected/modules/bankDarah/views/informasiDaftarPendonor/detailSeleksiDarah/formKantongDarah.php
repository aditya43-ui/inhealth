<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Pencatatan Kantong Darah</div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'kantongdarah-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        ));
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?> 
        
        <?php
            $sample = '-';
            $utama = ' - ';
            $imltd = ' - ';

            if (!empty($model->kantongdarah_id)) {
                $sample = $model->nomorbarcode_sample;
                $utama = $model->nomorbarcode_utama;
                $imltd = $model->nomorbarcode_sample_imltd;
            }
            ?>
        <div class="panel-body overflow-x" >    
            <table>
                <tr>
                    <td>
                        <?php echo CHtml::label("Jenis Kantong Darah", "", array('class' => 'control-label'));?>
                    </td>
                    <td>
                        <?php
                        $jeniskantong = '-';
                        if (!empty($model)) {
                            $jenisKantong = JeniskantongdarahM::model()->findByPk($model->jeniskantongdarah_id);
                            $jeniskantong = $jenisKantong->nama_jenis;
                        }
                        echo '&nbsp;&nbsp;'.CHtml::textField('jeniskantong', $jeniskantong, array('readonly' => true,'class' => 'span3'));
                        ?>
                    </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>
                        <label class="control-label">No Barcode Kantong Utama</label>
                    </td>
                    <td colspan="2">
                        <?php echo '&nbsp;&nbsp;'.CHtml::textField('barcode_utama', $utama, array('readonly' => true,'class' => 'span3')) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <?php echo CHtml::label("Jenis Komponen Darah", "", array('class' => 'control-label'));?>
                    </td>
                    <td>
                        <div class="komponen">
                            <?php
                            foreach ($models as $model) {


                                $kom = KomponendarahM::model()->findByPk($model->komponendarah_id);

                                echo '&nbsp;&nbsp;'.CHtml::textField('komponen[' . $model->komponendarah_id . ']kode', $kom->singkatan_komp, array(
                                    'class' => 'span1',
                                    'readonly' => true,
                                ));
                                echo '&nbsp;&nbsp;'.CHtml::textField('komponen[' . $model->komponendarah_id . ']no', substr($model->no_kantongdarah, strlen($kom->singkatan_komp)), array(
                                    'class' => 'span2',
                                    'readonly' => true,
                                ));
                                echo "<br/>";
                            }
                            ?>
                        </div>
                    </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>
                        <label class="control-label">No Barcode Sampel</label>
                    </td>
                    <td colspan="2">
                        <?php echo '&nbsp;&nbsp;'.CHtml::textField('barcode_sampel', $sample, array('readonly' => true, 'class' => 'span3')) ?>
                    </td>
                    
                </tr>
                <tr>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>
                        
                    </td>
                    <td colspan="2">
                        <?php echo '&nbsp;&nbsp;'.CHtml::textField('barcode_sampel', $imltd, array('readonly' => true, 'class' => 'span3')) ?>
                    </td>
                    
                </tr>
                
                
                <tr>
                    <td colspan="6"><hr/></td>
                </tr>
                <tr>
                    <td>
                        <?php echo Chtml::label("Tanggal Pencatatan &nbsp;&nbsp;", 'petugaspencatat_id', array('class' => 'control-label'));?>
                    </td>
                    <td>
                        <?php
                        if (!empty($model)) {
                            $tglpencatatan = MyFormatter::formatDateTimeForUser($model->tglpencatatan);
                        } else {
                            $tglpencatatan = '-';
                        }
                        echo CHtml::textField('tglpencatatan', $tglpencatatan, array('class' => 'required', 'readonly' => true));
                        ?>
                    </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>
                        <?php
                        echo Chtml::label("Petugas &nbsp;&nbsp;", 'petugaspencatat_id', array(
                            'class' => 'control-label',
                        ));
                        ?>
                    </td>
                    <td colspan="2">
                        <?php
                        $nama = '-';
                        if (isset($model->petugaspencatat_id)) {
                            $modPegawai = PegawaiM::model()->findByPk($model->petugaspencatat_id);
                            if (isset($modPegawai)) {
                                $nama = $modPegawai->namaLengkap;
                            }
                        }
                        echo CHtml::textField('pegawai', $nama, array('class' => 'required span3', 'readonly' => true));
                        ?> 
                    </td>
                </tr>
                <tr>
                    <td colspan="6">&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <?php echo CHtml::label('Nama DPJP &nbsp;&nbsp;', '', array('class' => 'control-label')); ?>
                    </td>
                    <td>
                        <?php
                        if (empty($model->dpjp_id)) {
                            $modSeleksipendonor = SeleksipendonorT::model()->findByAttributes(array('daftardonasi_id' => $_GET['daftardonasi_id']));
                            $model->dpjp_id = $modSeleksipendonor->dpjpkuesioner_id;
                            $cekDPJP = PegawaiM::model()->findByPk($modSeleksipendonor->dpjpkuesioner_id);
                            if (!empty($cekDPJP)) {
                                $model->dpjp_nama = $cekDPJP->nama_pegawai;
                            }
                        }
                        echo $form->hiddenField($model, 'dpjp_id', array('class' => 'span3 required'))
                        ?>
                        <?php echo $form->textField($model->dpjp, 'namaLengkap', array('readonly' => true,'class'=>'span3'));?>
                    </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>
                        <?php echo CHtml::label('Petugas Koreksi &nbsp;&nbsp;', '', array('class' => 'control-label')); ?>
                    </td>
                    <td>
                        <?php
                        if (empty($model->kantongdarah_id)) {
                            echo CHtml::checkBox('cek_ppds', '', array('onclick' => 'ubahDialog();'));
                        } else {
                            if (!empty($model->ppds_id)) {
                                echo CHtml::checkBox('cek_ppds', true, array('disabled' => true, 'readonly' => true));
                            } else {
                                echo CHtml::checkBox('cek_ppds', false, array('disabled' => true, 'readonly' => true));
                            }
                        }
                        if (!empty($model->petugaskoreksi_id)) {
                            $petugasKoreksi = PegawaiM::model()->findByPk($model->petugaskoreksi_id);
                            if (!empty($petugasKoreksi)) {
                                $model->petugaskoreksi_nama = $petugasKoreksi->namaLengkap;
                            } else {
                                $model->petugaskoreksi_nama = '-';
                            }
                        } else if (!empty($model->ppds_id)) {
                            $ppds = PpdsM::model()->findByPk($model->ppds_id);
                            if (!empty($ppds)) {
                                $model->ppds_nama = $ppds->ppds_nama;
                            } else {
                                $model->ppds_nama = '-';
                            }
                        }
                        ?> <label>PPDS</label>
                    </td>
                    <td>
                        <div class="controls" id="petugaskoreksi">
                            <?php
                            echo $form->hiddenField($model, 'petugaskoreksi_id', array('class' => 'span3 required'));
                            
                            echo $form->textField($model, 'petugaskoreksi_nama', array('readonly' => true, 'style'=>'width:200px !important'));
                            ?>
                        </div>
                        <div class="controls" id="ppds" hidden>
                            <?php echo $form->hiddenField($model, 'ppds_id', array('class' => '')) ?>
                            <?php echo $form->textField($model, 'ppds_nama', array('readonly' => true, 'style'=>'width:200px !important'));?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>
        <?php
        if (!empty($model)) {
            ?>
            <div class="form-actions">
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printBarcodeLab();return false"));
                echo "&nbsp;";
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode Komponen', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printBarcodeKomponen();return false"));
                ?>
            </div>
            <?php
        } else {
            ?>
            <div class="form-actions">
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                echo "&nbsp;";
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode Komponen', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                ?>
            </div>
            <?php
        }
        ?>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
if (!empty($model)) {
    ?>
    <script>

        function printBarcodeLab()
        {
            window.open('<?php echo $this->createUrl('PrintBarcode', array('kantongdarah_id' => $model->kantongdarah_id)); ?>', 'printwin', 'left=100,top=100,width=700,height=640');

        }

        function printBarcodeKomponen()
        {
            window.open('<?php echo $this->createUrl('PrintBarcodeKomponen', array('kantongdarah_id' => $model->kantongdarah_id, 'daftarpendonor_id' => $model->daftarpendonor_id)); ?>', 'printwin', 'left=100,top=100,width=700,height=640');

        }
    </script>
    <?php
}
?>