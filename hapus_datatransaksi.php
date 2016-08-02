<?php
include "db/koneksi.php";
?>
<html>
<head><title>Delete</title>
<script>
var jumlahnya;
function ceksemua(){
    jumlahnya = document.getElementById("jumlahcek").value;
    if(document.getElementById("cekbox").checked==true){
        for(i=0;i<jumlahnya;i++){
            idcek = "id_nota"+i;
            idtr = "tr"+i;
            document.getElementById(idtr).style.backgroundColor = "#efefef";
            document.getElementById(idcek).checked = true;
        }
    }else{
        for(i=0;i<jumlahnya;i++){
            idcek = "id_nota"+i;
            idtr = "tr"+i;
            document.getElementById(idtr).style.backgroundColor = "#FFFF99";
            document.getElementById(idcek).checked = false;
        }
    }
}
function konfirmasicek(indeks){
    idcek = "id_nota"+indeks;
    id_nota = document.getElementById(idcek).value;
    tanya = confirm("Delete nota dengan ID "+id_nota+"?");
    if(tanya == 1){
        window.location.href="delete.php?op=delsatu&id="+id_nota;
    }
}
function konfirmasicek2(){
    ada = 0;            //untuk mengecek apakah ada checkbox yang dicek
    semuanyakah = 1;    //untuk mengecek apakah semua checkbox tercek
    
    //untuk mengambil jumlah total checkbox yang ada
    jumlahnya = document.getElementById("jumlahcek").value;
    
    jumlahx = 0         //untuk mengetahui jumlah yang dicek
    for(i=0;i<jumlahnya;i++){
        idcek = "id_nota"+i;
        if(document.getElementById(idcek).checked == true){
            jumlahx++;
            ada = 1;
        }else{
            semuanyakah = 0;
        }
    }
    if(ada==1){
        if(semuanyakah == 1){
            tanya = confirm("Mau delete semuanyakah?");
            if(tanya == 1){
                document.getElementById("formulirku").submit();
            }
        }else{
            tanya = confirm("Mau delete data "+jumlahx+" item ?");
            if(tanya == 1){
                document.getElementById("formulirku").submit();
            }
        }
    }
}
function setwarna(indeks){
    idcek = "id_nota"+indeks;
    idtr = "tr"+indeks;
    if(document.getElementById(idcek).checked == true){
        document.getElementById(idtr).style.backgroundColor = "#efefef";
    }else{
        document.getElementById(idtr).style.backgroundColor = "#FFFF99";
    }
}
</script>
<h2> Hapus Data Laundry </h2>
</head>
<body bgcolor="#FFFF99">
<?php
$_GET['op']="";
if($_GET['op']=="berhasildelete"){
    echo "<b><font color=red>Data berhasil didelete</font></b><br>";
}
?>
<form action=delete.php method=post id=formulirku>
<table border="1" cellpadding="3" cellspacing="1" bgcolor="#FFFF99"
style="border-collapse: collapse" bordercolor="#FFCC00">
  <tr>
    <td  width="10%" bgcolor="#F5F5F5"><b><input type="checkbox" onclick="ceksemua()" id="cekbox">Semua</b></td>
    <th width="10%" bgcolor="#F5F5F5">Nota</th>
        <th width="15%" bgcolor="#F5F5F5">Nama</th>
        <th width="15%" bgcolor="#F5F5F5">Tanggal</th>
        <th width="16%" bgcolor="#F5F5F5">Status Bayar</th>
        <th width="16%" bgcolor="#F5F5F5">Status Cucian</th>
        <th width="17%" bgcolor="#F5F5F5">Total</th>
  </tr>
<?php
$data = mysql_query("select 
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
$indexcek = 0;
while($d = mysql_fetch_array($data)){
    echo "<tr id='tr$indexcek'><td><input type='checkbox' name='id_nota[]'
    value='".$d['id_nota']."' id='id_nota$indexcek' onclick='setwarna($indexcek)'>
    <img src='image/delete.GIF' onclick=\"konfirmasicek('$indexcek')\"
    style='cursor:pointer'>\n";
    echo "<td>".$d['id_nota']."</td>
          <td>".$d['nm_pel']."</td>
          <td>".$d['tgl']."</td>
          <td>".$d['status_bayar']."</td>
          <td>".$d['status_cucian']."</td>
          <td>".$d['total']."</td>
        </tr>\n";
    $indexcek++;
}
echo "<input type=hidden id='jumlahcek' value='$indexcek' name='jumlahcek'>";
?>
</table>
<input type="button" value="delete" onclick="konfirmasicek2()">
</form>
<a href="export.php"><button>Export Data ke Excel</button></a>
</body>
</html>