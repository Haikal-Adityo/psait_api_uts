<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            padding: 32px;
        }
        .wrapper{
            width: 100%;
            margin: 0 auto;
            overflow-x: auto;
        }
        table {
            width: 100%;
            white-space: nowrap;
        }
        table tr td:last-child{
            width: 120px;
        }
        div.scroll {
            height: auto;
            overflow: auto;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();  

            $(".delete-btn").click(function(){
                return confirm("Are you sure you want to delete this record?");
            });
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Mahasiswa</h2>
                        <a href="insertMahasiswaView.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New</a>
                    </div>
                    <div class="scroll">
                        <?php
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_URL, 'http://localhost/psait_api_uts/back_end/perkuliahan_api.php');
                        $res = curl_exec($curl);
                        $json = json_decode($res, true);

                        if (!empty($json["data"])) {
                            echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>NIM</th>";
                            echo "<th>Nama</th>";
                            echo "<th>Alamat</th>";
                            echo "<th>Tanggal Lahir</th>";
                            echo "<th>Kode MK</th>";
                            echo "<th>Nama MK</th>";
                            echo "<th>SKS</th>";
                            echo "<th>Nilai</th>";
                            echo "<th>Action</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            foreach ($json["data"] as $mahasiswa) {
                                echo "<tr>";
                                echo "<td>{$mahasiswa["nim"]}</td>";
                                echo "<td>{$mahasiswa["nama"]}</td>";
                                echo "<td>{$mahasiswa["alamat"]}</td>";
                                echo "<td>{$mahasiswa["tanggal_lahir"]}</td>";
                                echo "<td>{$mahasiswa["kode_mk"]}</td>";
                                echo "<td>{$mahasiswa["nama_mk"]}</td>";
                                echo "<td>{$mahasiswa["sks"]}</td>";
                                echo "<td>{$mahasiswa["nilai"]}</td>";
                                echo "<td>";
                                echo '<a href="updateMahasiswaView.php?nim=' . $mahasiswa["nim"] . '&kode_mk=' . $mahasiswa["kode_mk"] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                echo '<a href="deleteMahasiswaDo.php?nim=' . $mahasiswa["nim"] . '&kode_mk=' . $mahasiswa["kode_mk"] . '" title="Delete Record" data-toggle="tooltip" class="delete-btn"><span class="fa fa-trash"></span></a>';
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                        } else {
                            echo "No data available.";
                        }

                        curl_close($curl);
                        ?>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
