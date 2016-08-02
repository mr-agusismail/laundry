<?php
include "db/koneksi.php";
$data=mysql_query("select * from data_paket");
$datapel=mysql_query("select * from data_pelanggan");
$op=isset($_GET['op'])?$_GET['op']:null;

if($op=='id_paket'){
    echo"<option>ID Paket</option>";
    while($r=mysql_fetch_array($data)){
        echo "<option value='$r[id_paket]'>$r[nm_paket]</option>";
    }
}elseif($op=='id_pel'){
    echo"<option>ID Pelanggan</option>";
    while($r=mysql_fetch_array($datapel)){
        echo "<option value='$r[id_pel]'>$r[nm_pel]</option>";
    }
}elseif($op=='barang'){
    echo'<table id="barang" class="table table-hover">
    <thead>
            <tr>
                <Td colspan="5"><a href="?page=barang&act=tambah" class="btn btn-primary">Tambah Paket</a></td>
            </tr>
            <tr>
                <td>ID paket</td>
                <td>Nama paket</td>
                
                <td>Harga</td>
                <td>ket</td>
            </tr>
        </thead>';
	while ($b=mysql_fetch_array($data)){
        echo"<tr>
                <td>$b[id_paket]</td>
                <td>$b[nm_paket]</td>
    
                <td>$b[harga]</td>
                <td>$b[ket]</td>
            </tr>";
        }
    echo "</table>";
}elseif($op=='ambildata'){
    $id_paket=$_GET['id_paket'];
    $dt=mysql_query("select * from data_paket where id_paket='$id_paket'");
    $d=mysql_fetch_array($dt);
    echo $d['nm_paket']."|".$d['harga']."|".$d['ket'];
}elseif($op=='ambildatapelanggan'){
    $id_pel=$_GET['id_pel'];
    $dt=mysql_query("select * from data_pelanggan where id_pel='$id_pel'");
    $d=mysql_fetch_array($dt);
    echo $d['alamat']."|".$d['no_hp'];
}elseif($op=='cek'){
    $kd=$_GET['kd'];
    $sql=mysql_query("select * from data_paket where id_paket='$kd'");
    $cek=mysql_num_rows($sql);
    echo $cek;
}elseif($op=='update'){
    $id_paket=$_GET['id_paket'];
    $nm_paket=htmlspecialchars($_GET['nm_paket']);
    
    $harga=htmlspecialchars($_GET['harga']);
    $ket=htmlspecialchars($_GET['ket']);
    
    $update=mysql_query("update data_paket set nm_paket='$nm_paket',
                        harga='$harga',
                        ket='$ket'
                        where id_paket='$id_paket'");
    if($update){
        echo "Sukses";
    }else{
        echo "ERROR. . .";
    }
}elseif($op=='delete'){
    $id_paket=$_GET['id_paket'];
    $del=mysql_query("delete from data_paket where id_paket='$id_paket'");
    if($del){
        echo "sukses";
    }else{
        echo "ERROR";
    }
}elseif($op=='simpan'){
    $id_paket=$_GET['id_paket'];
    $nm_paket=htmlspecialchars($_GET['nm_paket']);
    $harga=htmlspecialchars($_GET['harga']);
    $ket=htmlspecialchars($_GET['ket']);
    
    $tambah=mysql_query("insert into data_paket (id_paket,nm_paket,harga,ket)
                        values ('$id_paket','$nm_paket','$harga','$ket')");
    if($tambah){
        echo "sukses";
    }else{
        echo "error";
    }
}
?>