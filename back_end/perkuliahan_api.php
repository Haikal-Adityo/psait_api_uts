<?php
require_once "config.php";
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case "GET":
        if (!empty($_GET["nim"]) && !empty($_GET["kode_mk"])) 
        {
            $nim=$_GET["nim"];
            $kode_mk =$_GET["kode_mk"];
            get_nilai_mahasiswa($nim, $kode_mk);
        } elseif (!empty($_GET["nim"])) 
        {
            $nim = $_GET["nim"];
            get_data_mahasiswa($nim);
        } else 
        {
            get_all_nilai_mahasiswa();
        }
        break;
    case "POST":
        if(!empty($_GET["nim"]))
        {
            $nim=$_GET["nim"];
            $kode_mk = $_GET["kode_mk"];
            update_nilai_mahasiswa($nim, $kode_mk);
        }
        else
        {
            insert_nilai_mahasiswa();
        }     
        break; 
    case "DELETE":
        $nim = $_GET["nim"];
        $kode_mk = $_GET["kode_mk"];
        delete_nilai_mahasiswa($nim, $kode_mk);
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_all_nilai_mahasiswa()
{
    global $mysqli;
    $query = "SELECT mahasiswa.nim, mahasiswa.nama, mahasiswa.alamat, mahasiswa.tanggal_lahir, perkuliahan.kode_mk, matakuliah.nama_mk, matakuliah.sks, perkuliahan.nilai 
              FROM mahasiswa 
              JOIN perkuliahan ON mahasiswa.nim = perkuliahan.nim 
              JOIN matakuliah ON perkuliahan.kode_mk = matakuliah.kode_mk 
              ORDER BY mahasiswa.nim";
              
    $data = array();
    $result = $mysqli->query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' => 'Get List Nilai Mahasiswa Successfully.',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}



function get_nilai_mahasiswa($nim, $kode_mk)
{
    global $mysqli;
    $query = "SELECT mahasiswa.nim, mahasiswa.nama, mahasiswa.alamat, mahasiswa.tanggal_lahir, perkuliahan.kode_mk, matakuliah.nama_mk, matakuliah.sks, perkuliahan.nilai FROM mahasiswa JOIN perkuliahan ON mahasiswa.nim = perkuliahan.nim JOIN matakuliah ON perkuliahan.kode_mk = matakuliah.kode_mk WHERE mahasiswa.nim = '$nim' AND perkuliahan.kode_mk = '$kode_mk'";
    $data = array();
    $result = $mysqli->query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' => 'Get Nilai Mahasiswa Successfully.',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

function get_data_mahasiswa($nim)
{
    global $mysqli;
    $query = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
    $result = $mysqli->query($query);
    $data = mysqli_fetch_assoc($result);
    if ($data) {
        $response = array(
            'status' => 1,
            'message' => 'Get Mahasiswa Data Successfully.',
            'data' => $data
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Mahasiswa Data Not Found.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function insert_nilai_mahasiswa()
{
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);
    
    if(isset($data['nim'], $data['kode_mk'], $data['nilai'])) {
        $nim = $data['nim'];
        $kode_mk = $data['kode_mk'];
        $nilai = $data['nilai'];

        $checkQuery = "SELECT * FROM perkuliahan WHERE nim = '$nim' AND kode_mk = '$kode_mk'";
        $checkResult = mysqli_query($mysqli, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $response = array(
                'status' => 0,
                'message' => 'Duplicate data found for NIM: ' . $nim . ' and Kode MK: ' . $kode_mk
            );
        } else {
            $insertQuery = "INSERT INTO perkuliahan (nim, kode_mk, nilai) VALUES ('$nim', '$kode_mk', '$nilai')";
            $result = mysqli_query($mysqli, $insertQuery);

            if ($result) {
                $response = array(
                    'status' => 1,
                    'message' => 'Nilai Mahasiswa Added Successfully.'
                );
            } else {
                $response = array(
                    'status' => 0,
                    'message' => 'Nilai Mahasiswa Addition Failed.'
                );
            }
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Required fields (nim, kode_mk, nilai) not provided in the input data.'
        );
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

function update_nilai_mahasiswa($nim, $kode_mk)
{
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);
    $nilai = $data['nilai'];

    $result = mysqli_query($mysqli, "UPDATE perkuliahan SET 
    nilai = '$nilai' 
    WHERE nim = '$nim' AND kode_mk = '$kode_mk'");

    if ($result) {
        $response = array(
            'status' => 1,
            'message' => 'Nilai Mahasiswa Updated Successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Nilai Mahasiswa Updation Failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function delete_nilai_mahasiswa($nim, $kode_mk)
{
    global $mysqli;
    $query = "DELETE FROM perkuliahan WHERE nim = '$nim' AND kode_mk = '$kode_mk'";
    $result = mysqli_query($mysqli, $query);
    if ($result) {
        $response = array(
            'status' => 1,
            'message' => 'Nilai Mahasiswa Deleted Successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Nilai Mahasiswa Deletion Failed: ' . mysqli_error($mysqli)
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>
