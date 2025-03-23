<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    $username = getenv('USERNAME');
    $password = getenv('PASSWORD');
    if (empty($username)) $username = 'fake_username';
    if (empty($password)) $password = 'fake_password';

    $context = stream_context_create([
        "http" => [
            "header" => "Authorization: Basic " . base64_encode("$username:$password"),
        ]
    ]);

    // Utilisation du nom du service 'api' pour accéder à l'API
    $url = 'http://api:5000/supmit/api/v1.0/get_student_ages';  
    $response = @file_get_contents($url, false, $context);  // @ pour supprimer les messages d'erreur PHP

    if ($response === false) {
        $error = error_get_last();
        echo "Erreur de récupération des données: " . $error['message'];
    } else {
        $list = json_decode($response, true);
        if (isset($list['student_ages']) && is_array($list['student_ages'])) {
            echo "<p style='color:red; font-size: 20px;'>This is the list of the student with age</p>";
            foreach ($list["student_ages"] as $key => $value) {
                echo "- " . htmlspecialchars($key) . " is " . htmlspecialchars($value) . " years old <br>";
            }
        } else {
            echo "Données non valides reçues.";
        }
    }
}
?>
