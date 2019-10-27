<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png'); ?>">

    <title>Laporan Perhitungan - Aplikasi SPK Seleksi Penerimaan Beasiswa Siswa Berprestasi</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url("assets/vendor/bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- jQuery -->
    <script src="<?= base_url("assets/vendor/jquery/jquery.min.js"); ?>"></script>
    <style>
        .main_container{
            width:90%; 
            padding-top:5px;
        }
        .img_logo{
            width: 90%;
            text-align: center;
        }
        .head_center{
            padding-top: 45px;
        }
        .head_center>h1,h3,h4{
            margin: 0;
        }
        .head_center>h1{
            font-size: 2.25em;
        }
        .head_center>h3{
            font-size: 1.5em;
        }
        .head_center>h4{
            font-size: 1.125em;
        }

        hr{
            margin: 5px 0;
            border-top: 1px solid #000;
        }

        .wp{
            border-top: 2px solid #000;
        }

        @media (min-width: 768px){ 

            .img_logo{
                width: 80%;
                padding-top: 15px;
            }

            .head_center{
                padding-top: 20px;
            }

            .head_center>h1{
                font-size: 2em;
            }
            .head_center>h3{
                font-size: 1.1em;
            }
            .head_center>h4{
                font-size: 1.025em;
            }
        }

        @media print{ 
            .img_logo{
                width: 80%;
                padding-top: 15px;
            }
            .head_center{
                padding-top: 20px;
            }
            .head_center>h1{
                font-size: 1.8em;
            }
            .head_center>h3{
                font-size: 0.9em;
            }
            .head_center>h4{
                font-size: 1em;
            }
        }
    </style>
</head>

<body>
    <div class="container main_container">
        <div class="row">
            <div class="col-xs-2">
                <img class="img-responsive img_logo" src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo">
            </div>
            <div class="col-xs-8 head_center text-center">
                <h3><?= $judul; ?> Seleksi Penerimaan Beasiswa Siswa Berprestasi</h3>
                <h1>SMK Antartika 2 Sidoarjo</h1>
                <h4>Jl. Raya Siwalanpanji, Bedrek, Siwalanpanji, Kec. Buduran, Kabupaten Sidoarjo, Jawa Timur 61252 Telp. (031) 8065117</h4>
            </div>
            <div class="col-xs-2"></div>
        </div>
        <hr class="wp">
        <hr>
        


        <?php if(isset($table_normal)): ?>
            <br>
            <h3>Deskripsi</h3>
            <br>
            <?= isset($table_desk)?$table_desk:'';?>
            <br>
            <br>
            <h3>Nilai</h3>
            <br>
            <?= isset($table)?$table:'';?>
            <br>
            <h3>Normalisasi</h3>
            <br>
            <?= isset($table_normal)?$table_normal:'';?>
        <?php else: ?>
            <br>
            <h3>Rangking</h3>
            <br>
            <?= isset($table)?$table:'';?>
        <?php endif; ?>

        <div class="row">
            <div class="col-xs-offset-8 col-xs-4 text-center">
                <br><br><br>
                <p>Sidoarjo, <?= date("d-m-Y")?></p>
                <br><br>
                <p>Panitia Penerimaan Beasiswa</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url("assets/vendor/bootstrap/js/bootstrap.min.js"); ?>"></script>
    <script type="text/javascript">
        window.print();
    </script>
</body>

</html>
