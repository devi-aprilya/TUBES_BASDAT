<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "baru";

$koneksi    = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$nip           = "";  
$nama         = "";
$nip           = "";
$alamat        = "";
$jabatan        = "";
$sukses         = "";
$error          = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if($op == 'delete'){
    $id_pegawai = $_GET['id_pegawai'];
    $sql1       = "delete from pegawai where id_pegawai = '$id_pegawai'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}

if ($op == 'edit') {
    $id_pegawai      = $_GET['id_pegawai'];
    $sql1           = "select * from pegawai where id_pegawai = '$id_pegawai'";
    $q1             = mysqli_query($koneksi, $sql1);
    $r1             = mysqli_fetch_array($q1);
    $nip            = $r1['nip'];
    $nama           = $r1['nama'];
    $alamat      = $r1['alamat'];
    $jabatan    = $r1['jabatan'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}

if(isset($_POST['simpan'])){
    $nip           = $_POST['nip'];
    $nama         = $_POST['nama'];
    $alamat          = $_POST['alamat'];
    $jabatan       = $_POST['jabatan'];

    if($nip && $nama && $alamat && $jabatan){
        if ($op == 'edit') {
            $id_pegawai = $_GET['id_pegawai'];
            $sql1 = "UPDATE pegawai SET nip='$nip', nama='$nama', alamat='$alamat', jabatan='$jabatan' WHERE id_pegawai='$id_pegawai'";
            $q1 = mysqli_query($koneksi, $sql1);

            if($q1){
                $sukses = "Data berhasil diupdate";
            }else{
                $error = "Data gagal diupdate";
            }
        } else {
            $sql1 = "INSERT INTO pegawai (nip, nama, alamat, jabatan) VALUES ('$nip', '$nama', '$alamat', '$jabatan')";
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
                PEGAWAI
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
                        <label for="nip" class="col-sm-2 col-form-label">Nip</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nip" name="nip" value="<?php echo $nip ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="spesialis" class="col-sm-2 col-form-label">alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="rumah_sakit" class="col-sm-2 col-form-label">jabatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo $jabatan ?>">
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
                DOKTER
            </div>
            <div class = "card-body">
                <form action="" method="POST">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nip</th>
                                <th scope="col">Nama</th>
                                <th scope="col">alamat</th>
                                <th scope="col">jabatan</th>
                                <th scope="col">Edit / Hapus</th>
                            </tr>
                        </thead>

                        <tbody>
                                <?php
                                $sql2   = "select * from pegawai order by id_pegawai asc";
                                $q2     = mysqli_query($koneksi, $sql2);
                                $urut   = 1;
                                while ($r2 = mysqli_fetch_array($q2)) {
                                    $id_dokter      = $r2['id_pegawai'];
                                    $nip           = $r2['nip'];
                                    $nama         = $r2['nama'];
                                    $spesialis           = $r2['alamat'];
                                    $rumah_sakit        = $r2['jabatan'];
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++ ?></th>
                                    <td scope="row"><?php echo $nip ?></td>
                                    <td scope="row"><?php echo $nama ?></td>
                                    <td scope="row"><?php echo $alamat ?></td>
                                    <td scope="row"><?php echo $jabatan ?></td>
                                    <td scope="row">
                                        <a href="index5.php?op=edit&id_pasien=<?php echo $id_pegawai ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                        <a href="index5.php?op=delete&id_pasien=<?php echo $id_pegawai?>" onclick="return confirm('Hapus Data ?')"><button type="button" class="btn btn-danger">Delete</button></a>            
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
