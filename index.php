<!doctype html>
    <html>
        <head>
            <title>Aplikasi Laundry</title>
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/bootstrap.css">
        </head>
        <body>
            <div id="container">
            <header>
                <h1>Sistem Admin Laundry Dekat Rumah </a></h1>
            </header>
            <!--menu -->
            <nav>
                <ul>
                    <li><a href="index.php">Data</a>
                        <ul>
                            <li><a href="?page=barang">Paket Cuci</a></li>
							<li><a href="?page=pelanggan">Pelanggan</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Transaksi</a>
                        <ul>
                            <li><a href="?page=penjualan&act=tambah">Nota Cucian</a></li>
							<li><a href="?page=datacucian">Data Cucian</a></li>
                            <li><a href="?page=hapus_datatransaksi">Hapus Data</a></li>
                        </ul>
                    </li>
                     <li><a href="?page=transaksi_sistemsaldo">Sistem Saldo</a></li>
                     <li><a href="#">Laporan</a>
                        <ul>
                            <li><a href="?page=lap_datatransaksi">Transaksi</a></li>
                            <li><a href="?page=lap_transaksi_sistemsaldo">Sistem Saldo</a></li>
                            
                        </ul>
                    </li>
                </ul>
            </nav>
            <br>
            <div class="container">
                    <?php
                    include "db/koneksi.php";
                    $p=isset($_GET['page'])?$_GET['page']:null;
                    switch($p){
                        default:
                            
                            break;
                        case "barang":
                            include "barang.php";
                            break;
                        case "pelanggan":
                            include "pelanggan.php";
                            break;                                  
                        case "penjualan":
                            include "transaksi.php";
                            break;
						case "datacucian":
                            include "datacucian.php";
                            break;
                        case "lap_datatransaksi":
                            include "lap_datatransaksi.php";
                        break;
                         case "hapus_datatransaksi":
                            include "hapus_datatransaksi.php";
                        break;
                          case "transaksi_sistemsaldo":
                            include "transaksi_sistemsaldo.php";
                        break;
                         case "lap_transaksi_sistemsaldo":
                            include "lap_transaksi_sistemsaldo.php";
                        break;
                    }
                    ?>
            </div>
            </body>
    </html>