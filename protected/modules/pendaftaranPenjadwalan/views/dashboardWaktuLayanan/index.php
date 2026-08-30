<?php
$this->breadcrumbs = array(
    'Dashoboard Waktu Layanan',
); ?>

<style>
    /* hr {
        height: 1px;
        margin: 10px 0;
        background: #57a595;
        border: none;
    }

    #menu li {
        display: block;
        float: left;
        width: 100px;
        height: 53px;
        border: 1px solid #559DCF;
        border-radius: 3px;
        text-align: center;
        text-decoration: none;
        margin: 5px;
    }

    #menu a {
        padding: 1px;
        text-decoration: none;
        color: #6D6D6D;
    }

    #menu img {
        display: block;
        margin: 0 auto;
        padding: 10px;
        border: none;
    }

    #menu_laporan a:hover,
    #menu_laporan a:focus {
        color: #737881;
    }

    .selected {
        background: #57a595;
        color: #ffffff !important;
        font-weight: bold;
    }

    #satu,
    #dua,
    #tiga,
    #empat,
    #lima {
        margin-bottom: 15px
    }

    .border th,
    .border td {
        border: 1px solid #000;
    }

    .col-sm-3 {
        width: 23%;
        border: solid 1px #ddd;
        margin: 5px;
        padding: 0;
        border-radius: 15px;
        text-align: center;
        background: #f2f2f2;
        cursor: pointer;
        overflow: hidden;
        transition: .25s;
    }

    .col-sm-3>a {
        display: block;
        padding: 15px;
    }

    .col-sm-3 img {
        width: 100px;
        height: 100px;
    }

    .col-sm-3 span {
        display: inline-block;
        margin-top: 15px;
        padding: 0 15px 0;
        font-size: 13px;
    }

    .col-sm-3:hover {
        filter: brightness(.85);
    } */
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Dashboard <b>Waktu Layanan</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="row" style="margin-top: 10px">
            <div class="col-sm-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title" style="font-weight: bold; text-align: center !important; width: 80% !important;">
                            Rata-Rata Total Waktu Layanan 
                            <br/>
                            <i>(Admisi-Farmasi)</i>
                        </div>
                        <div class="panel-options">
                            <a data-rel="collapse" href="#">
                                <i class="entypo-down-open"></i>
                            </a>
                            <a data-rel="reload" href="#">
                                <i class="entypo-arrows-ccw"></i>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <center>
                            <span style="font-size: 16pt"><?php echo $dashboard['rata_rata_all']; ?></span>
                            </br>
                            <span style="font-size: 12pt"><i>(hh:mm:ss)</i></span>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <?php $this->renderPartial($this->path_view . '_chartBar', array('dashboard'=>$dashboard)); ?>
            </div>
            <div class="clear"></div>
            <div class="col-sm-4" style="margin-top: 10px" >
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title" style="font-weight: bold; text-align: center !important; width: 80% !important;">
                            Rata-Rata Waktu Tunggu Admisi 
                        </div>
                        <div class="panel-options">
                            <a data-rel="collapse" href="#">
                                <i class="entypo-down-open"></i>
                            </a>
                            <a data-rel="reload" href="#">
                                <i class="entypo-arrows-ccw"></i>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <center>
                            <span style="font-size: 16pt"><?php echo $dashboard['rata_rata_task1']; ?></span>
                            </br>
                            <span style="font-size: 12pt"><i>(hh:mm:ss)</i></span>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-sm-4" style="margin-top: 10px" >
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title" style="font-weight: bold; text-align: center !important; width: 80% !important;">
                            Rata-Rata Waktu Tunggu Poli
                        </div>
                        <div class="panel-options">
                            <a data-rel="collapse" href="#">
                                <i class="entypo-down-open"></i>
                            </a>
                            <a data-rel="reload" href="#">
                                <i class="entypo-arrows-ccw"></i>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <center>
                            <span style="font-size: 16pt"><?php echo $dashboard['rata_rata_task3']; ?></span>
                            </br>
                            <span style="font-size: 12pt"><i>(hh:mm:ss)</i></span>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-sm-4" style="margin-top: 10px" >
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title" style="font-weight: bold; text-align: center !important; width: 80% !important;">
                            Rata-Rata Waktu Tunggu Pada Farmasi
                        </div>
                        <div class="panel-options">
                            <a data-rel="collapse" href="#">
                                <i class="entypo-down-open"></i>
                            </a>
                            <a data-rel="reload" href="#">
                                <i class="entypo-arrows-ccw"></i>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <center>
                            <span style="font-size: 16pt"><?php echo $dashboard['rata_rata_task5']; ?></span>
                            </br>
                            <span style="font-size: 12pt"><i>(hh:mm:ss)</i></span>
                        </center>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="col-sm-4" style="margin-top: 10px" >
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title" style="font-weight: bold; text-align: center !important; width: 80% !important;">
                            Rata-Rata Waktu Layanan Admisi
                        </div>
                        <div class="panel-options">
                            <a data-rel="collapse" href="#">
                                <i class="entypo-down-open"></i>
                            </a>
                            <a data-rel="reload" href="#">
                                <i class="entypo-arrows-ccw"></i>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <center>
                            <span style="font-size: 16pt"><?php echo $dashboard['rata_rata_task2']; ?></span>
                            </br>
                            <span style="font-size: 12pt"><i>(hh:mm:ss)</i></span>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-sm-4" style="margin-top: 10px" >
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title" style="font-weight: bold; text-align: center !important; width: 80% !important;">
                            Rata-Rata Waktu Layanan Poli
                        </div>
                        <div class="panel-options">
                            <a data-rel="collapse" href="#">
                                <i class="entypo-down-open"></i>
                            </a>
                            <a data-rel="reload" href="#">
                                <i class="entypo-arrows-ccw"></i>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <center>
                            <span style="font-size: 16pt"><?php echo $dashboard['rata_rata_task4']; ?></span>
                            </br>
                            <span style="font-size: 12pt"><i>(hh:mm:ss)</i></span>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-sm-4" style="margin-top: 10px" >
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title" style="font-weight: bold; text-align: center !important; width: 80% !important;">
                            Rata-Rata Waktu Layanan Pada Farmasi
                        </div>
                        <div class="panel-options">
                            <a data-rel="collapse" href="#">
                                <i class="entypo-down-open"></i>
                            </a>
                            <a data-rel="reload" href="#">
                                <i class="entypo-arrows-ccw"></i>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <center>
                            <span style="font-size: 16pt"><?php echo $dashboard['rata_rata_task6']; ?></span>
                            </br>
                            <span style="font-size: 12pt"><i>(hh:mm:ss)</i></span>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
