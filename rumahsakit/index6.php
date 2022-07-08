<?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "baru";

    $koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));
    
    if(isset($_POST['bsimpan']))
    {
      $simpan = mysqli_query($koneksi, "INSERT INTO obat (nama, alamat, call_center, rating)
                                        VALUES ('$_POST[tnama]',
                                                '$_POST[talamat]',  
                                                '$_POST[tca]' 
                                                               ) 
                                                     ");
    if($simpan)
    {
      echo "<script>
            alert('Simpan Data Sukses');
            document.location='index6.php';
            </script>";
    }
    else
    {
      echo "<script>
            alert('Simpan Data Gagal');
            document.location='index6.php';
            </script>";
    }
    }

    //pengujian jika tombol edit/hapus dklik
    if(isset($_GET['hal']))
    {
      if($_GET['hal'] == "edit")
      {
        $tampil = mysqli_query($koneksi, "SELECT * FROM obat WHERE id_obat = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if($data)
        {
          $vnama = $data['nama'];
          $vbentuk = $data['bentuk'];
          $vjenis = $data['jenis'];

        }
      }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUSKESMAS</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<a href="../beranda/home.php" class="btn btn-info" role="button">Home</a>
<div class="container">

<h1>DATA OBAT</h1>

<!-- AWAL CARD FORM-->
<div class="card mt-5">
  <div class="card-header bg-primary text-white">
    obat
  </div>
  <div class="card-body">
    <form method="post" action="" >
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="tnama" class="form-control" placeholder=" " required>
        </div>
        <div class="form-group">
            <label>bentuk</label>
            <input type="text" name="tbentuk" class="form-control" placeholder=" " required>
        </div>
        <div class="form-group">
            <label>jenis</label>
            <input type="text" name="tjenis" class="form-control" placeholder=" " required>
        </div>

        <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
        <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
    </form>
  </div>
</div>
<!-- AKHIR CARD FORM-->

<!-- AWAL CARD TABEL-->

<div class="card mt-5">
  <div class="card-header bg-success text-white">
    Daftar Pasien
  </div>
  <div class="card-body">

  <table class="table table-bordered table-striped">
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Bentuk</th>
      <th>Jenis</th>
    </tr>
    <?php
        $no = 1;
        $tampil = mysqli_query($koneksi, "SELECT * from obat order by id_obat desc");
        while($data = mysqli_fetch_array($tampil)) :
  ?>
  <tr>
  <td><?=$no++?></td>
  <td><?=$data['nama']?></td>
  <td><?=$data['bentuk']?></td>
  <td><?=$data['jenis']?></td>
  <td>
    <a href="index3.php?hal=edit&id=<?=$data['id_obat']?>" class="btn btn-warning"> Edit </a>
    <a href="#" class="btn btn-danger"> Hapus </a>

  
</tr>
<?php endwhile; ?>

</table>
    
  </div>
</div>
<!-- AKHIR CARD TABEL-->

</div>

<script type="text/javascript" src="js/bootstrap.min.js"></script>

</body>
</html>