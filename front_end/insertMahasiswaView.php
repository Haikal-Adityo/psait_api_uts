<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>New Data</h2>
                    </div>
                    <p>Please select a Mahasiswa and Kode MK to modify the Nilai.</p>
                    <form id="updateForm" action="insertMahasiswaDo.php" method="post">
                    <div class="form-group">
                        <label>Select Mahasiswa</label>
                            <select id="nim" name="nim" class="form-control">
                                <?php
                                require_once "config.php";
                                $query_mahasiswa = "SELECT * FROM mahasiswa";
                                $result_mahasiswa = mysqli_query($mysqli, $query_mahasiswa);
                                if (mysqli_num_rows($result_mahasiswa) > 0) {
                                    while ($row_mahasiswa = mysqli_fetch_assoc($result_mahasiswa)) {
                                        echo "<option value='" . $row_mahasiswa["nim"] . "'>" . "[" . $row_mahasiswa["nim"] . "] - " . $row_mahasiswa["nama"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select Matakuliah</label>
                            <select id="kode_mk" name="kode_mk" class="form-control">
                                <?php
                                $query_matakuliah = "SELECT * FROM matakuliah";
                                $result_matakuliah = mysqli_query($mysqli, $query_matakuliah);
                                if (mysqli_num_rows($result_matakuliah) > 0) {
                                    while ($row_matakuliah = mysqli_fetch_assoc($result_matakuliah)) {
                                        echo "<option value='" . $row_matakuliah["kode_mk"] . "'>" . "[" . $row_matakuliah["kode_mk"] . "] - " . $row_matakuliah["nama_mk"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nilai</label>
                            <input type="number" name="nilai" class="form-control" min="0" value="0">
                        </div>
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </form>
                    <br/>
                    <div id="duplicateMessage" class="alert alert-warning" style="display: none;">
                        Data already exists with the same nim and kode_mk combination.
                    </div>
                </div>
            </div>        
        </div>
    </div>

</body>
</html>
