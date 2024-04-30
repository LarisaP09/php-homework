<?php
require_once "pdo.php";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $apiKey = 'de7d91cf71a92209fd7cd95d37f0ec47';
    $city = $_GET['city-input'];
    $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=$city&APPID=$apiKey";

    //kelvin to celsius
    function convertKelvinToCelsius($kelvin) {
        return $kelvin - 273.15;
    }

    $response = file_get_contents($apiUrl);

    if ($response) {
        $data = json_decode($response, true);

        $temperatureKelvin = $data['main']['temp'];
        $temperatureCelsius = convertKelvinToCelsius($temperatureKelvin);
        $description = $data['weather'][0]['description'];
        $location = $data['name'];

        echo "<p>Temperature in $location: " . number_format($temperatureCelsius, 2) . "°C</p>";
        echo "<p>Weather: $description</p>";
        
    } else {
        echo "Error: Unable to retrieve weather data.";
    }
    exit();
}
?>
