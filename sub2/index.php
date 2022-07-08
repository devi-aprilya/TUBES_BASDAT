<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "baru";

$koneksi    = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$nama           = "";  
$alamat         = "";
$umur           = "";
$keluhan        = "";
$sukses         = "";
$error          = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if($op == 'delete'){
    $id_pasien     = $_GET['id_pasien'];
    $sql1       = "delete from pasien where id_pasien = '$id_pasien'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}

if ($op == 'edit') {
    $id_pasien      = $_GET['id_pasien'];
    $sql1           = "select * from pasien where id_pasien = '$id_pasien'";
    $q1             = mysqli_query($koneksi, $sql1);
    $r1             = mysqli_fetch_array($q1);
    $nama           = $r1['nama'];
    $alamat         = $r1['alamat'];
    $umur           = $r1['umur'];
    $keluhan         = $r1['keluhan'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}

if(isset($_POST['simpan'])){
    $nama           = $_POST['nama'];
    $alamat         = $_POST['alamat'];
    $umur          = $_POST['umur'];
    $keluhan       = $_POST['keluhan'];

    if($nama && $alamat && $umur && $keluhan){
        if ($op == 'edit') {
            $id_pasien = $_GET['id_pasien'];
            $sql1 = "UPDATE pasien SET nama='$nama', alamat='$alamat', umur='$umur', keluhan='$keluhan' WHERE id_pasien='$id_pasien'";
            $q1 = mysqli_query($koneksi, $sql1);

            if($q1){
                $sukses = "Data berhasil diupdate";
            }else{
                $error = "Data gagal diupdate";
            }
        } else {
            $sql1 = "INSERT INTO pasien (nama, alamat, umur, keluhan) VALUES ('$nama', '$alamat', '$umur', '$keluhan')";
            $q1 = mysqli_query($koneksi, $sql1);

            if($q1){
                $sukses = "Data berhasil ditambahkan";
            }else{
                $error = "Data gagal ditambahkan";
            }
        }
    } else {
        $error = "Data tidak boleh kosong";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tubes Basdat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 70%;
        }
        .card {
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<a href="../beranda/home.php" class="btn btn-info" role="button">Home</a>
    <div class = "mx-auto">
        <!-- INPUT DATA -->
        <div class = "card">
            <div class = "card-header text-white bg-secondary">
                DATA PASIEN
            </div>
            <div class = "card-body">
                <?php
                    if($error){
                        ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error ?>
                        </div>
                        <?php
                    }
                ?>
                <?php
                    if($sukses){
                        ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $sukses ?>
                        </div>
                        <?php
                    }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="umur" class="col-sm-2 col-form-label">Umur</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="umur" name="umur" value="<?php echo $umur ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="keluhan" class="col-sm-2 col-form-label">keluhan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="keluhan" name="keluhan" value="<?php echo $keluhan ?>">
                        </div>
                    </div>

                    <div class="col-12">
                        <input type="submit" name="simpan" value="simpan data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>

        <!-- TAMPIL DATA -->
        <div class = "card">
            <div class = "card-header text-white bg-secondary">
                DATA PASIEN
            </div>
            <div class = "card-body">
                <form action="" method="POST">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Umur</th>
                                <th scope="col">Keluhan</th>
                                <th scope="col">Edit / Hapus</th>
                            </tr>
                        </thead>

                        <tbody>
                                <?php
                                $sql2   = "select * from pasien order by id_pasien asc";
                                $q2     = mysqli_query($koneksi, $sql2);
                                $urut   = 1;
                                while ($r2 = mysqli_fetch_array($q2)) {
                                    $id_pasien      = $r2['id_pasien'];
                                    $nama           = $r2['nama'];
                                    $alamat         = $r2['alamat'];
                                    $umur           = $r2['umur'];
                                    $keluhan        = $r2['keluhan'];
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++ ?></th>
                                    <td scope="row"><?php echo $nama ?></td>
                                    <td scope="row"><?php echo $alamat ?></td>
                                    <td scope="row"><?php echo $umur ?></td>
                                    <td scope="row"><?php echo $keluhan ?></td>
                                    <td scope="row">
                                        <a href="index.php?op=edit&id_pasien=<?php echo $id_pasien ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                        <a href="index.php?op=delete&id_pasien=<?php echo $id_pasien?>" onclick="return confirm('Hapus Data ?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
