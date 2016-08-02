<?php
include "db/koneksi.php";
$op = $_GET['op'];
if($op){
    $id_nota = $_GET['id'];
    $del = mysql_query("DELETE FROM data_transaksi WHERE id_nota='$id_nota'");
}else{
    foreach($_POST['id_nota'] as $value){
        $del = mysql_query("DELETE FROM data_transaksi WHERE id_nota='$value'");
    }
}
if($del){
    header("location:index.php?op=berhasildelete");
}else{
    echo "error";
}
?>