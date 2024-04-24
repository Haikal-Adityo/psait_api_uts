<?php

if (isset($_POST['submit'])) 
{
$nim = $_POST['nim']; 
$kode_mk = $_POST['kode_mk'];
$nilai = $_POST['nilai'];

// URL of the REST API endpoint
$url = 'http://localhost/psait_api_uts/back_end/perkuliahan_api.php';
$ch = curl_init($url);

// Data to be sent to the REST API in JSON format
$jsonData = array(
    'nim' => $nim,
    'kode_mk' => $kode_mk,
    'nilai' => $nilai,
);

// Encode the array into JSON
$jsonDataEncoded = json_encode($jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

// Execute the request
$result = curl_exec($ch);
$result = json_decode($result, true);

curl_close($ch);

echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">';
echo '<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">';
echo '<div style="text-align: center; font-size: 18px;">';
echo "<br>status : {$result["status"]} ";
echo "<br>{$result["message"]} ";
echo '<br><br><a href="selectMahasiswaView.php"><button type="button" class="btn btn-primary">OK</button></a>';
echo '</div>';
echo '</div>';

}
?>
