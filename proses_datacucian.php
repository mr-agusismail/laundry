<?php
include "db/koneksi.php";

$data=mysql_query("select 
data_transaksi.id_nota,
data_pelanggan.nm_pel,                                   
data_transaksi.tgl,
data_transaksi.total,
data_transaksi.status_bayar,
data_transaksi.status_cucian
from                                      
data_transaksi,
data_pelanggan
where
data_pelanggan.id_pel=data_transaksi.id_pel order by id_nota DESC");
$op=isset($_GET['op'])?$_GET['op']:null;

if($op=='id_nota'){
    echo"<option>ID Nota</option>";
    while($r=mysql_fetch_array($data)){
        echo "<option value='$r[id_nota]'>$r[id_nota]  ($r[nm_pel])</option>";
    }
}elseif($op=='barang'){
    echo'<table id="barang" class="table table-hover">
    <thead>
            <tr>
                <Td colspan="5"><a href="?page=penjualan&act=tambah" class="btn btn-primary">Transaksi Baru</a></td>
            </tr>
            <tr>
                <td>ID Transaksi</td>
                <td>Nama Pelanggan</td>
                
                <td>Tanggal</td>
                <td>Total</td>
				<td>Status</td>
                <td>Status Cucian</td>
				<td>Detail</td>
            </tr>
        </thead>';
	while ($b=mysql_fetch_array($data)){
        echo"<tr>
                <td>$b[id_nota]</td>
                <td>$b[nm_pel]</td>
    
                <td>$b[tgl]</td>
                <td>$b[total]</td>
				<td>$b[status_bayar]</td> 
                <td>$b[status_cucian]</td> 
				<td><a href='?page=penjualan&act=detail&nota=$b[id_nota]' class='btn btn-primary'>Lihat Nota</a>
				</a></td>	
            </tr>";
        }
    echo "</table>";
}elseif($op=='ambildata'){
    $id_nota=$_GET['id_nota'];
    $dt=mysql_query("select * from data_transaksi where id_nota='$id_nota'");
    $d=mysql_fetch_array($dt);
    echo $d['id_pel']."|".$d['tgl']."|".$d['total']."|".$d['status_bayar']."|".$d['status_cucian'];
}elseif($op=='cek'){
    $kd=$_GET['kd'];
    $sql=mysql_query("select * from data_transaksi where id_nota='$kd'");
    $cek=mysql_num_rows($sql);
    echo $cek;
}elseif($op=='update'){
    $id_nota=$_GET['id_nota'];
    $id_pel=htmlspecialchars($_GET['id_pel']);
    $tgl=htmlspecialchars($_GET['tgl']);
    $total=htmlspecialchars($_GET['total']);
    $status_bayar=htmlspecialchars($_GET['status_bayar']);
    $status_cucian=htmlspecialchars($_GET['status_cucian']);
    $update=mysql_query("update data_transaksi set id_pel='$id_pel',
                        tgl='$tgl',
                        total='$total',
						status_bayar='$status_bayar',
                        status_cucian='$status_cucian'
                        where id_nota='$id_nota'");
    if($update){
        echo "Sukses";
    }else{
        echo "ERROR. . .";
    }
}elseif($op=='delete'){
    $id_nota=$_GET['id_nota'];
    $del=mysql_query("delete from data_transaksi where id_nota='$id_nota'");
    if($del){
        echo "sukses";
    }else{
        echo "ERROR";
    }
}elseif($op=='cari'){
    $pencarianSQL	= "";
    $katakunci=htmlspecialchars($_GET['katakunci']);
    $id_nota=$_GET['id_nota'];
# PENCARIAN DATA 
	$katakunci	= $_GET($_POST['katakunci']);
	$pencarianSQL	= "WHERE id_nota='$katakunci' OR id_pel LIKE '%$katakunci%' ";

    $mySql = "SELECT * FROM data_transaksi $pencarianSQL ORDER BY id_nota desc";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
    $nomor = $mulai; 
    while ($myData = mysql_fetch_array($myQry)) {
        $nomor++;
        $Kode = $myData['id_nota'];
    echo "
      <tr>
        <td>$nomor; </td>
        <td> $myData[id_nota]</td>
        <td> $myData[id_pel]</td>
        <td>$myData[tgl]</td>
        <td>$myData[total]</td>
        <td>$myData[status_bayar]</td>

      </tr>";
	// Menyusun sub query pencarian
	}
   
}elseif($op=='simpan'){
    $id_nota=$_GET['id_nota'];
    $id_pel=htmlspecialchars($_GET['id_pel']);
    $tgl=htmlspecialchars($_GET['tgl']);
    $total=htmlspecialchars($_GET['total']);
	$status_bayar=htmlspecialchars($_GET['status_bayar']);
    $status_cucian=htmlspecialchars($_GET['status_cucian']);
    
    $tambah=mysql_query("insert into data_transaksi (id_nota,id_pel,tgl,total,status_bayar,$status_cucian)
                        values ('$id_nota','$id_pel','$tgl','$total','$status_bayar','$status_cucian')");
    if($tambah){
        echo "sukses";
    }else{
        echo "error";
    }
}
?>