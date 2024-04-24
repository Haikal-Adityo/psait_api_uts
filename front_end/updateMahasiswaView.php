<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<?php
 $nim = $_GET['nim'];
 $kode_mk = $_GET['kode_mk'];
 $curl= curl_init();
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 //Pastikan sesuai dengan alamat endpoint dari REST API di ubuntu
 curl_setopt($curl, CURLOPT_URL, 'http://localhost/psait_api_uts/back_end/perkuliahan_api.php?nim='.$nim.'&kode_mk='.$kode_mk);
 $res = curl_exec($curl);
 $json = json_decode($res, true);
//var_dump($json);
?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Data</h2>
                    </div>
                    <p>Please fill this form and submit to edit the student record from the database.</p>
                    <form action="updateMahasiswaDo.php" method="post">
                    <div class="form-group">
                        <label>Mahasiswa</label>
                        <input type="text" name="nim" class="form-control" value="<?php echo $json["data"][0]["nim"]; ?>" placeholder="<?php echo '[' . $json["data"][0]["nim"] . '] - ' . $json["data"][0]["nama"]; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Matakuliah</label>
                        <input type="text" name="kode_mk" class="form-control" value="<?php echo $json["data"][0]["kode_mk"]; ?>" placeholder="<?php echo '[' . $json["data"][0]["kode_mk"] . '] - ' . $json["data"][0]["nama_mk"]; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nilai</label>
                        <input type="number" name="nilai" class="form-control" value="<?php echo $json["data"][0]["nilai"]; ?>">
                    </div>
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>