<?php
include "db/koneksi.php";
$data=mysql_query("select * from data_pelanggan");
$op=isset($_GET['op'])?$_GET['op']:null;

if($op=='id_pel'){
    echo"<option>ID Pelanggan</option>";
    while($r=mysql_fetch_array($data)){
        echo "<option value='$r[id_pel]'>$r[nm_pel]</option>";
    }
}elseif($op=='pelanggan'){
    echo'<table id="pelanggan" class="table table-hover">
    <thead>
            <tr>
                <Td colspan="5"><a href="?page=pelanggan&act=tambah" class="btn btn-primary">Tambah Pelanggan</a></td>
            </tr>
            <tr>
                <td>ID Pelanggan</td>
                <td>Nama Pelanggan</td>
                
                <td>Alamat</td>
                <td>No HP</td>
            </tr>
        </thead>';
	while ($b=mysql_fetch_array($data)){
        echo"<tr>
                <td>$b[id_pel]</td>
                <td>$b[nm_pel]</td>
    
                <td>$b[alamat]</td>
                <td>$b[no_hp]</td>
            </tr>";
        }
    echo "</table>";
}elseif($op=='ambildata'){
    $id_pel=$_GET['id_pel'];
    $dt=mysql_query("select * from data_pelanggan where id_pel='$id_pel'");
    $d=mysql_fetch_array($dt);
    echo $d['nm_pel']."|".$d['alamat']."|".$d['no_hp'];
}elseif($op=='cek'){
    $kd=$_GET['kd'];
    $sql=mysql_query("select * from data_pelanggan where id_pel='$kd'");
    $cek=mysql_num_rows($sql);
    echo $cek;
}elseif($op=='update'){
    $id_pel=$_GET['id_pel'];
    $nm_pel=htmlspecialchars($_GET['nm_pel']);
    
    $alamat=htmlspecialchars($_GET['alamat']);
    $no_hp=htmlspecialchars($_GET['no_hp']);
    
    $update=mysql_query("update data_pelanggan set nm_pel='$nm_pel',
                        alamat='$alamat',
                        no_hp='$no_hp'
                        where id_pel='$id_pel'");
    if($update){
        echo "Sukses";
    }else{
        echo "ERROR. . .";
    }
}elseif($op=='delete'){
    $id_pel=$_GET['id_pel'];
    $del=mysql_query("delete from data_pelanggan where id_pel='$id_pel'");
    if($del){
        echo "sukses";
    }else{
        echo "ERROR";
    }
}elseif($op=='simpan'){
    $id_pel=$_GET['id_pel'];
    $nm_pel=htmlspecialchars($_GET['nm_pel']);
    $alamat=htmlspecialchars($_GET['alamat']);
    $no_hp=htmlspecialchars($_GET['no_hp']);
    
    $tambah=mysql_query("insert into data_pelanggan (id_pel,nm_pel,alamat,no_hp)
                        values ('$id_pel','$nm_pel','$alamat','$no_hp')");
    if($tambah){
        echo "sukses";
    }else{
        echo "error";
    }
}
?>