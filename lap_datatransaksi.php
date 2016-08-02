<html>
<head>
  <title>TRANSAKSI</title>
    <link rel="stylesheet" href="tabel.css" />


</head>
<body onLoad="document.postform.elements['id_pel'].focus();">

<?php
//untuk koneksi database
include "db/koneksi.php";

//untuk menantukan tanggal awal dan tanggal akhir data di database
$min_tanggal=mysql_fetch_array(mysql_query("select min(tgl) as min_tanggal from data_transaksi"));
$max_tanggal=mysql_fetch_array(mysql_query("select max(tgl) as max_tanggal from data_transaksi"));
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="postform">
  <form name='postform' method='post' action='".$_SERVER['PHP_SELF']."?action=del'>
<table width="435" border="0">
<tr>
  <label><h3>Laporan Transaksi Laundry</h3></label>
</tr> 
<tr>
    <td width="111">Nama Pelanggan</td>
    <td colspan="2"><input type="text" name="id_pel" value="<?php if(isset($_POST['id_pel'])){ echo $_POST['id_pel']; }?>"/></td>
</tr>
<tr>
    <td>Tanggal Awal</td>
    <td colspan="2"><input type="text" name="tanggal_awal" size="15" value="<?php echo $min_tanggal['min_tanggal'];?>"/>
    <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform.tanggal_awal);return false;" ><img src="calender/calender.jpeg" alt="" name="popcal" width="34" height="29" border="0" align="absmiddle" id="popcal" /></a>        
    </td>
</tr>
<tr>
    <td>Tanggal Akhir</td>
    <td colspan="2"><input type="text" name="tanggal_akhir" size="15" value="<?php echo $max_tanggal['max_tanggal'];?>"/>
    <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform.tanggal_akhir);return false;" ><img src="calender/calender.jpeg" alt="" name="popcal" width="34" height="29" border="0" align="absmiddle" id="popcal" /></a>       
    </td>
</tr>
<tr>
    <td width="111">Status Bayar</td>
    <td colspan="2"><label>
      <select name="status_bayar" size="1">
	  	<option></option>
        <option>Lunas</option>
        <option>Belum Lunas</option>
      <?php if(isset($_POST['status_bayar'])){ echo $_POST['status_bayar']; }?></select>
    </label></td>
</tr>
<tr>
    <td width="111">Status Cucian</td>
    <td colspan="2"><label>
      <select name="status_cucian" size="1">
      <option></option>
        <option>Proses</option>
        <option>Selesai</option>
        <option>Sudah Diambil</option>
      <?php if(isset($_POST['status_cucian'])){ echo $_POST['status_cucian']; }?></select>
    </label></td>
</tr>
<tr>
    <td><input type="submit" value="Tampilkan Data" name="cari"></td>
    <td colspan="2">&nbsp;</td>
</tr>

</table>
</form>
<p>

<?php
//di proses jika sudah klik tombol cari
if(isset($_POST['cari'])){
  
  //menangkap nilai form
  $id_pel=$_POST['id_pel'];
  $tanggal_awal=$_POST['tanggal_awal'];
  $tanggal_akhir=$_POST['tanggal_akhir'];
  $status_bayar=$_POST['status_bayar'];
  $status_cucian=$_POST['status_cucian'];

  if(empty($id_pel) and empty($tanggal_awal) and empty($tanggal_akhir) and empty($status_bayar) and empty($status_cucian)){
    //jika tidak menginput apa2
    $query=mysql_query("select * from data_transaksi order by id_nota desc");
    $jumlah=mysql_fetch_array(mysql_query("select sum(total) as total from data_transaksi"));
    
  }else{
    
    ?><i><b>Informasi : </b> Pencarian data laundry <b><?php echo ucwords($_POST['id_pel']);?></b> dari tanggal <b><?php echo $_POST['tanggal_awal']?></b> sampai dengan tanggal <b><?php echo $_POST['tanggal_akhir']?></b></i><?php
    
    $query=mysql_query("select * from data_transaksi where id_pel like '%$id_pel%' and tgl between '$tanggal_awal' and '$tanggal_akhir' and status_bayar like '$status_bayar%' and status_cucian like '$status_cucian%' order by id_nota desc");
    $jumlah=mysql_fetch_array(mysql_query("select sum(total) as total from data_transaksi where id_pel like '%$id_pel%' and tgl between '$tanggal_awal' and '$tanggal_akhir' and status_bayar like '$status_bayar%' and status_cucian like '%$status_cucian%'"));
  }
  
  ?>
</p>

<table class="datatable"  width="100%" border="0" cellpadding="3" cellspacing="1" class="table-list style2">
  <tr>
    
      <th width="3%" bgcolor="#F5F5F5">No </th>
        <th width="10%" bgcolor="#F5F5F5">Nota</th>
        <th width="15%" bgcolor="#F5F5F5">Nama</th>
        <th width="15%" bgcolor="#F5F5F5">Tanggal</th>
        <th width="16%" bgcolor="#F5F5F5">Status Bayar</th>
        <th width="16%" bgcolor="#F5F5F5">Status Cucian</th>
        <th width="17%" bgcolor="#F5F5F5">Total</th>
    </tr>
    <tr>
      <button onclick="window.print()">Cetak Data</button>
    </tr>
   
  <?php
  //untuk penomoran data
  $nomor=0;
  
  //menampilkan data
 
  while($row=mysql_fetch_array($query)){
  ?>
    <tr>
      <td><?php echo $nomor=$nomor+1; ?></td>
      <td><?php echo $row['id_nota']; ?></td>
      <td><?php echo $row['id_pel']; ?></td>
      <td><?php echo $row['tgl']; ?></td>
      <td><?php echo $row['status_bayar'];?></td>
      <td><?php echo $row['status_cucian'];?></td>
      <td align="right">
  
    <?php echo number_format($row['total'],2,',','.');?></td>
    </tr>
    <?php
  }
  ?>
    <tr>
      <td colspan="3" align="right"><strong>TOTAL SELURUH</strong></td><td align="right"><?php echo number_format($jumlah['total'],2,',','.');?></td>
    </tr>
    
    <tr>
      <td colspan="4" align="center"> 
    <?php
    //jika data tidak ditemukan
    if(mysql_num_rows($query)==0){
      echo "<font color=red><blink>Tidak ada data yang dicari!</blink></font>";
    }
    ?>
        </td>
    </tr>
     
</table>


<?php
}else{
  unset($_POST['cari']);
}
?>

<iframe width=174 height=189 name="gToday:normal:calender/normal.js" id="gToday:normal:calender/normal.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>
</body>
</html>