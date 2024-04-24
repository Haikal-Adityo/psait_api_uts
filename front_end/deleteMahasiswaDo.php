<?php

$nim = $_GET['nim'];
$kode_mk = $_GET['kode_mk'];

// Construct the URL with the 'nim' and 'kode_mk' parameters for the DELETE operation
$url = 'http://localhost/psait_api_uts/back_end/perkuliahan_api.php?nim='.$nim.'&kode_mk='.$kode_mk;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
// pastikan method nya adalah delete
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
$result = json_decode($result, true);

curl_close($ch);

echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">';
echo '<div style="display: flex; justify-content: center; align-items: center; height: 100vh; ">';
echo '<div style="text-align: center; font-size: 18px;">';
echo "<br>status : {$result["status"]} ";
echo "<br>{$result["message"]} ";
echo '<br><br><a href="selectMahasiswaView.php"><button type="button" class="btn btn-primary">OK</button></a>';
echo '</div>';
echo '</div>';
    
?>
