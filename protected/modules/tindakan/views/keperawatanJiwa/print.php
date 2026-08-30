<style>
    .form_predispo > tbody > tr > td {
        vertical-align: top;
        padding: 2px;
    }

    #tab_aniaya {
        width: 100%;
    }

    #tab_aniaya td {
        border: 1px solid black;
        padding: 2px;
    }

    #tab_aniaya .rad_center {
        text-align: center;
    }

    .tab_subpart {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .tab_subpart > thead > tr > th {
        padding: 2px;
        font-weight: bold;
    }
    
    .tab_subpart > thead > tr > th, .tab_subpart > tbody > tr > td {
        border: 1px solid black;
        padding: 2px;
    }

</style>

<h4 style="text-align: center;">PENGKAJIAN KEPERAWATAN KESEHATAN JIWA</h4>
<br>

<table class="tab_subpart">
    <thead>
        <tr>
            <th>PERAWAT : <?php 
            echo $model->perawat ? $model->perawat->namaLengkap : "-";
            
            ?></th>
        </tr>
    </thead>
</table>
<table class="tab_subpart">
    <thead>
        <tr>
            <th>I. IDENTITAS KLIEN</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'_print/_identitas', array(
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'model'=>$model,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab_subpart">
    <thead>
        <tr>
            <th>II. ALASAN MASUK</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding-left: 4px;">
                <?php echo $model->alasan_masuk; ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab_subpart">
    <thead>
        <tr>
            <th>III. FAKTOR PREDISPOSISI</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'_print/_presdisposisi', array(
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'model'=>$model,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab_subpart">
    <thead>
        <tr>
            <th>IV. FISIK</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'_print/_fisik', array(
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'model'=>$model,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab_subpart">
    <thead>
        <tr>
            <th>V. PSIKOSOSIAL</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'_print/_psikososial', array(
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'model'=>$model,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab_subpart">
    <thead>
        <tr>
            <th>VI. STATUS MENTAL</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'_print/_mental', array(
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'model'=>$model,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab_subpart">
    <thead>
        <tr>
            <th>VII. KEBUTUHAN PERSIAPAN PULANG</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'_print/_persiapanPulang', array(
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'model'=>$model,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab_subpart">
    <thead>
        <tr>
            <th>VIII. MEKANISME KOPING</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'_print/_koping', array(
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'model'=>$model,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab_subpart">
    <thead>
        <tr>
            <th>IX. MASALAH PSIKOSOSIAL DAN LINGKUNGAN</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'_print/_masalahPsikososial', array(
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'model'=>$model,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab_subpart">
    <thead>
        <tr>
            <th>X. PENGETAHUAN KURANG TENTANG</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'_print/_pengetahuan', array(
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'model'=>$model,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="tab_subpart">
    <thead>
        <tr>
            <th>XI. ASPEK MEDIK</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo $this->renderPartial($this->path_view.'_print/_aspekMedik', array(
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'model'=>$model,
                ), true); ?>
            </td>
        </tr>
    </tbody>
</table>
