<?php
include "db/koneksi.php";
$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='ambilbarang'){
    $data=mysql_query("select * from data_paket");
    echo"<option></option>";
    while($r=mysql_fetch_array($data)){
        echo "<option value='$r[id_paket]'>$r[nm_paket]</option>";
    }
}elseif($op=='ambilpelanggan'){
    $data=mysql_query("select * from data_pelanggan");
    echo"<option></option>";
    while($r=mysql_fetch_array($data)){
        echo "<option value='$r[id_pel]'>$r[nm_pel]</option>";
    }
}elseif($op=='ambildatapelanggan'){
    $id_pel=$_GET['id_pel'];
    $dt=mysql_query("select * from data_pelanggan where id_pel='$id_pel'");
    $d=mysql_fetch_array($dt);
    echo $d['alamat']."|".$d['no_hp'];

}elseif($op=='ambildata'){
    $id_paket=$_GET['id_paket'];
    $dt=mysql_query("select * from data_paket where id_paket='$id_paket'");
    $d=mysql_fetch_array($dt);
    echo $d['nm_paket']."|".$d['harga'];
}elseif($op=='barang'){
    $brg=mysql_query("select * from data_cucian");
    echo "<thead>
            <tr>
                <td>id paket</td>
                <td>Nama Paket</td>
                <td>Harga</td>
                <td>Banyak</td>
                <td>total_bayar</td>
                <td>Tools</td>
            </tr>
        </thead>";
    $total=mysql_fetch_array(mysql_query("select sum(total_bayar) as total from data_cucian"));
    while($r=mysql_fetch_array($brg)){
        echo "<tr>
                <td>$r[id_paket]</td>
                <td>$r[nm_paket]</td>
                <td>$r[harga]</td>
                <td>$r[banyak]</td>
                <td>$r[total_bayar]</td>
                <td><a href='pk.php?op=hapus&id_paket=$r[id_paket]' id='hapus'>Hapus</a></td>
            </tr>";
    }
    echo "<tr>
        <td colspan='3'>Total</td>
        <td colspan='4'>$total[total]</td>
    </tr>
	<tr>
        <td colspan='3'>Sisa</td>
        <td colspan='4'>$sisa[sisa]</td>
    </tr>";
	
}elseif($op=='tambah'){
    $id_paket=$_GET['id_paket'];
    $nm_paket=$_GET['nm_paket'];
    $harga=$_GET['harga'];
    $banyak=$_GET['banyak'];
    $total_bayar=$harga*$banyak;
	  
    $tambah=mysql_query("INSERT into data_cucian (id_paket,nm_paket,harga,banyak,total_bayar)
                        values ('$id_paket','$nm_paket','$harga','$banyak','$total_bayar')");
    
    if($tambah){
        echo "sukses";
    }else{
        echo "ERROR";
    }

}elseif($op=='hapus'){
    $id_paket=$_GET['id_paket'];
    $del=mysql_query("delete from data_cucian where id_paket='$id_paket'");
    if($del){
        echo "<script>window.location='index.php?page=penjualan&act=tambah';</script>";
    }else{
        echo "<script>alert('Hapus Data Berhasil');
            window.location='index.php?page=penjualan&act=tambah';</script>";
    }

}elseif($op=='proses'){
    $nota=$_GET['nota'];
	$id_pel=$_GET['id_pel'];
    $tgl=$_GET['tgl'];
    $to=mysql_fetch_array(mysql_query("select sum(total_bayar) as total from data_cucian"));
    $tot=$to['total'];
	
	 $id_paket=$_GET['id_paket'];
	 $harga=$_GET['harga'];
	 $banyak=$_GET['banyak'];
	 $total_bayar=$_GET['total_bayar'];
	 $status_bayar=$_GET['status_bayar'];
    $simpan=mysql_query("insert into data_transaksi(id_nota,id_pel,tgl,total,status_bayar,status_cucian)
                        values ('$nota','$id_pel','$tgl','$tot','$status_bayar','Proses')");
			
    if($simpan){
        $query=mysql_query("select * from data_cucian");
        while($r=mysql_fetch_row($query)){
            mysql_query("insert into data_detailtransaksi(id_nota,id_paket,harga,banyak,subtotal)
                        values('$nota','$r[0]','$r[2]','$r[3]','$r[4]')");
           
        }
        //hapus seluruh isi tabel sementara
        mysql_query("truncate table data_cucian");
        echo "sukses";
    }else{
        echo "ERROR";
    }
}
?>