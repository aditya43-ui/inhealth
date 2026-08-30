<?php
$this->breadcrumbs = array(
    'Informasi Gambaran Umum',
);
?>
<style type="text/css">
    .white-container {
        padding: 0 10px 0 0;
        border: none;
    }

    .iconrs {
        text-align: center;
    }

    .iconrs img {
        margin: 15px 0;
    }

    .kiri {
        border: 1px solid #006600;
        min-height: 350px;
        background-color: #f1f1f1;
    }

    .kiri ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        background-color: #f1f1f1;
    }

    .kiri li a {
        display: block;
        color: #000;
        padding: 10px 20px;
        text-decoration: none;
        cursor: pointer;
        transition: .15s;
    }

    .kiri li+li {
        border-top: solid 1px #ddd;
    }

    .kiri li.active a {
        color: #fff;
    }

    .kiri li a:hover {
        background-color: #aaa;
        /* color: white; */
    }

    .foricon.active {
        background-color: #555;
    }

    .konten {
        padding: 15px 0 0;
    }

    .judul {
        text-align: center;
        background-color: #00802b;
        padding: 5px;
        color: #FFF;
        border-radius: 5px;
        box-shadow: 0 6px 5px rgba(0, 0, 0, 0.25);
    }

    .judul h2 {
        color: #FFF;
        text-shadow: -1px 0 #000, 0 1px #000, 1px 0 #000, 0 -1px #000;
        font-size: 16pt;
        font-weight: bold;
    }

    .isi {
        background: rgba(0, 153, 0, 0.1);
        padding: 25px 20px;
    }
</style>
<!--<div class="white-container">-->
<div class="row">
    <div class="col-sm-3">
        <div class="iconrs">
            <img src="<?php echo Params::urlProfilRSDirectory() . $model->logo_rumahsakit ?>">
        </div>
        <div class="kiri testclick">
            <ul>
                <li class="foricon active"><a href="<?php echo $this->createUrl('Index') ?>">Gambaran Umum</a></li>
                <li class="foricon"><a onclick="getListData('visi');">Visi</a></li>
                <li class="foricon"><a onclick="getListData('misi');">Misi</a></li>
                <li class="foricon"><a onclick="getListData('motto');">Motto</a></li>
                <!--<li class="foricon"><a href="#" onclick="getListData('fasilitas');">Fasilitas Kesehatan</a></li>-->
                <!--<li class="foricon"><a href="#">Fasilitas Penunjang</a></li>-->
            </ul>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="konten contentData">
            <div class="judul">
                <h2>GAMBARAN UMUM RUMAH SAKIT</h2>
            </div>
            <div class="isi">
                <table>
                    <tr>
                        <td>Nama Rumah Sakit</td>
                        <td>:</td>
                        <td><?php echo $model->nama_rumahsakit; ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?php echo $model->alamatlokasi_rumahsakit; ?></td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td>:</td>
                        <td><?php echo $model->no_telp_profilrs; ?></td>
                    </tr>
                    <tr>
                        <td>Fax</td>
                        <td>:</td>
                        <td><?php echo $model->no_faksimili; ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><?php echo $model->email; ?></td>
                    </tr>
                    <tr>
                        <td>Website</td>
                        <td>:</td>
                        <td><?php echo $model->website; ?></td>
                    </tr>
                    <tr>
                        <td>Status Kepemilikan</td>
                        <td>:</td>
                        <td><?php echo $model->statusrsswasta; ?></td>
                    </tr>
                    <tr>
                        <td>Nama Direktur</td>
                        <td>:</td>
                        <td><?php echo $model->namadirektur_rumahsakit; ?></td>
                    </tr>
                    <tr>
                        <td>Kelas Rumah Sakit</td>
                        <td>:</td>
                        <td><?php echo $model->kelas_rumahsakit; ?></td>
                    </tr>
                    <tr>
                        <td>SK Mentri RI</td>
                        <td>:</td>
                        <td><?php echo $model->nomor_suratizin; ?></td>
                    </tr>
                    <tr>
                        <td>Nomor Registrasi RS</td>
                        <td>:</td>
                        <td><?php echo $model->nokode_rumahsakit; ?></td>
                    </tr>
                    <tr>
                        <td>No Ijin Operasional RS</td>
                        <td>:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Tanggal Ijin Operasional</td>
                        <td>:</td>
                        <td><?php echo $model->tglregistrasi; ?></td>
                    </tr>
                    <tr>
                        <td>Masa Berlaku</td>
                        <td>:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Luas Lahan</td>
                        <td>:</td>
                        <td><?php echo $model->luastanah; ?></td>
                    </tr>
                    <tr>
                        <td>Luas Bangunan</td>
                        <td>:</td>
                        <td><?php echo $model->luasbangunan; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<!--</div>-->
<script>
    $(".foricon").click(function() {
        $(".active").removeClass("active");
        $(this).addClass("active");
    });

    function getListData(listData) {
        $(".contentData").addClass("animation-loading");
        $.post('<?php echo $this->createUrl('ajaxListData') ?>', {
            listData: listData
        }, function(data) {
            $(".konten").html(data.isidata);
            $(".contentData").removeClass("animation-loading");
        }, 'json');
    }
</script>