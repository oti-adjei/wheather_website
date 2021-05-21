<?php 

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

?>
<?php
function getWeather($city)
{
    $city_name = $city;
    $api_key = 'b5c57ba8e797c2533ec2ed1c93ffee5a';

    $api_url = 'http://api.openweathermap.org/data/2.5/weather?q=' . $city_name . '&appid=' . $api_key;

    $weather_data = json_decode(file_get_contents($api_url), true);
    return $weather_data;
}

if (isset($_GET['city'])) {
    $data =  getWeather($_GET['city']);
    $city_name = $_GET['city'];
} else {
    $data = getWeather('Accra');
    $city_name = 'Accra';
}
$temperature = $data['main']['temp'];

$temp_in_celsius = round($temperature - 273.15);

$pressure = $data['main']['pressure'];

$wind_speed = $data['wind']['speed'];

$description = $data['weather']['0']['description'];

$location = $data['name'];

$wind_cover = $data['wind']['deg'];

$weather_icon = $data['weather']['0']['icon'];

//echo "<pre>";
//print_r($data);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Dashboard</title>
</head>
<body>
    <!-- Background Image -->
    <div class="bg"></div>
    <header>
        <div class="wrapper">
            <div class="logo">
                <img src="https://i.postimg.cc/mg4rWBmv/logo.png" alt="">
            </div>
            <ul class="nav-area">
                <li><a href="#">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact Us</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </header>
    
    <div class="wrappers">
    <?php echo "<h1>Welcome " . $_SESSION['username'] . "</h1>"; ?>
        <div class="search-input" method="post">
            <a href="" target="_blank" hidden></a>
            <form method="get">
                <input type="text" placeholder="Type to search.." value="<?php echo $city_name ?>" name="city" required>
            </form>
            <div class="autocom-box">
                <!-- here list are inserted from javascript -->
            </div>
            <div class="icon" onclick="document.querySelector('form').submit()"><i class="fa fa-search"></i></div>
        </div>
    </div>
    <div class="container">
        <!-- Weather Widget -->
        <div class="widget">
            <div class="left">
                <img src="assets/images/cloud.svg" class="icon">
                <h5 class="weather-status">
                    <?php echo "<pre>";
                    print_r($description)
                    ?>
                </h5>
            </div>
            <div class="right">
                <h5 class="city"><?php echo "<pre>";
                                    print_r($location)
                                    ?></h5>
                <h5 class="degree"><?php echo "<pre>";
                                    print_r($temp_in_celsius)?>°C</h5>
            </div>
            <div class="bottom">
                <div>
                    Wind Speed <span><?php echo ($wind_speed) ?></span>
                </div>
                <div>
                    Cloud Cover <span><?php echo ($wind_cover) ?></span>
                </div>
                <div>
                    Pressure <span><?php echo "<pre>";
                                    print_r($pressure) ?> mb</span>
                </div>
            </div>
        </div>
        <!-- ./End of weather widget -->
    </div>

    <script src="js/suggestions.js"></script>
    <script src="js/script.js"></script>
</body>

</html>