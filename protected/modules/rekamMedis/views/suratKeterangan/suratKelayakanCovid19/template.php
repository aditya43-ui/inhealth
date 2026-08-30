<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);


$format = new MyFormatter();
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

if (!empty($_GET['suratketerangan_id'])) {
    $model = SuratketeranganR::model()->findByPk($_GET['suratketerangan_id']);
}


?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p {
        text-indent: 50px;
        text-align: justify;
    }

    .add-on {
        border: #ddd 1px solid;
        padding: 6px;
        border-radius: 5px;
    }

    .table-checklist {
        border: #000 1px solid;
        padding: 6px;
    }

    .table-checklist tr>td {
        padding: 6px;
    }

    .table-checklist .btm {
        padding: 6px;
        border-bottom: #000 1px solid;
    }

    .table-checklist .bord {
        border-left: #000 1px solid;
        border-right: #000 1px solid;
        text-align: center;
        padding: 6px;
    }

    #txt_tanggal .input-append {
        display: inline-block;
    }
</style>
<div>
    <TABLE ALIGN="CENTER">
        <tr>
            <td ALIGN=CENTER VALIGN=MIDDLE>
                <div class="judulcontent"> <B><span SIZE=4><u><?php echo $model->judulsurat; ?></u></span></B></div>
            </td>
        </tr>
    </TABLE>
    <br><br><br>
    <p align="justify">
        Yang bertanda tangan dibawah ini menerangkan bahwa :
    </p>    
    <table width="100%" style="width:500px;margin-left:50px;">
        <tr>
            <td width="180">Pegawai pemeriksa</td>
            <td width="10">:</td>
            <td>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($modPendaftaran, 'dokter_pemeriksa',['readonly'=>true]);
                    ?>
                </div>
            </td>
        </tr>
    </table>
    <p align="justify">
        Menerangkan bahwa :
    </p>  
    <table width="100%" style="width:500px;margin-left:50px;">
        <tr>
            <td width="180">Nama</td>
            <td width="10">:</td>
            <td>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($modPasien, 'nama_pasien',['readonly'=>true]);
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <td width="180">Tanggal Lahir</td>
            <td width="10">:</td>
            <td>
                <div class="controls">
                    <?php
                    $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir);
                    echo CHtml::activeTextField($modPasien, 'tanggal_lahir',['readonly'=>true]);
                    ?>
                </div>
            </td>
        </tr>
    </table>
    <br />    
    <div style="text-align: justify; margin-left: 50px;" id="txt_tanggal">
        Setelah dilakukan pengkajian yang komprehensi <b><span id="layak" class="hover st-layak" onclick="cekLayak('layak', this)">layak</span>/<span id="tidaklayak" class="hover st-layak" onclick="cekLayak('tidak-layak', this)">tidak layak</span></b> mendapatkan vaksinasi covid.
    </div></br>
    <div style="text-align: justify; margin-left: 50px;" id="txt_tanggal">
        Demikian surat keterangan ini dibuat untuk digunakan dengan semestinya
    </div>   
</div><br><br><br><br><br>
<div class="">
    <div class="">
        <label class="font-13px" style="width:100%">
            <table class="tabel-surat">
                <tr style="text-align: center;">
                    <td width="30%">
                  
                    </td>
                    <td width="50%">
                    </td>
                    <td width="19%">
                        <?php $date = date('Y-m-d'); ?>
                        <?php echo strtoupper($data->kabupaten->kabupaten_nama); ?>, <?php echo ($format->formatDateTimeForUser(date('Y-m-d'))); 
                                                                                        ?><br>
                        <!-- <?php //echo strtoupper($data->nama_rumahsakit);
                                ?>, -->
                        <!-- Dokter Pemeriksa -->
                        <br><br><br><br><br>

                        <?php

                        echo CHtml::activeTextField($model, 'mengetahui_surat',['readonly'=>true]);
                        echo CHtml::activeCheckBox($model, 'islayak',['id'=>'cb-layak', 'class'=>'hide']);
                        ?>

                    </td>
                </tr>
                <tr>
                    <td width="80%" colspan="2">
                        <b>*Coret Salah Satu</b>
                    </td>
                </tr>
            </table>
        </label>
    </div>
</div>
</TABLE>

<script>
    function pilihFisik(obj) {
        var val = $(obj).attr('val');

        $("[id^=fisik]").each(function() {
            if ($(this).attr('val') != val) {
                $(this).addClass('line-words');
            } else {
                $(this).removeClass('line-words');
                $("#<?php echo CHtml::activeId($model, 'kelayakan_jiwa') ?>").val(val);
            }
        });
    }

    function setPenandaTangan() {
        var opt = $("#RKSuratketeranganR_mengetahui_surat :selected");

        $("#nama_pegawai").val($(opt).data('nama'));
        $("#sip").val($(opt).data('sip'));
        $("#jabatan").val($(opt).data('jabatan'));
        $("#instansi").val($(opt).data('instansi'));
    }

    function setInstansiDiri() {
        var nilai = $('#permintaandari').val();

        if (nilai == 'Instansi') {
            $('#instansidiri').show();
        } else {
            $('#instansidiri').hide();
        }
    }
</script>