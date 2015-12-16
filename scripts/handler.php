<?php
    require_once('socket.php');
    
    /*
    if($_POST['action'] == 'submitInfo')
    {
        uploadData($_POST['fullName'], $_POST['phoneNumber'], 
        $_POST['emailAddress'], $_POST['zipCode'], $_POST['bestContact'],
        $_POST['make'], $_POST['model'], $_POST['engine']);
    }
    */
    
    //function uploadData($fullName, $phoneNumber, $emailAddress, $zipCode, $bestContact, $make, $model, $engine)
    function uploadData($postData)
    {
        global $db;
        $query = "SELECT car_makes.make_name AS Make, car_models.model_name AS Model, car_engines.engine_name AS Engine
                    FROM car_makes
                     INNER JOIN car_models ON car_makes.make_id = car_models.make_id
                     INNER JOIN car_engines ON car_models.model_id = car_engines.model_id 
                     WHERE car_makes.make_id = " . $postData['make'] . " AND car_models.model_id = " . $postData['model'] . " AND car_engines.engine_id = " . $postData['engine'];
        $result = mysqli_query($db, $query);
        
        $selectedData = mysqli_fetch_assoc($result);
        $query = "INSERT INTO salesleads (fullName, phoneNumber, emailAddress, zipCode, bestContact, make, model, engine) 
        VALUES 
        ('" . $postData['fullName'] . "', '" 
            . $postData['phoneNumber'] . "', '" 
            . $postData['emailAddress'] . "', '"
            . $postData['zipCode'] . "', '" 
            . $postData['bestContact'] . "', '" 
            . $selectedData['Make'] . "', '" 
            . $selectedData['Model'] . "', '" 
            . $selectedData['Engine'] . "')";
        $result = mysqli_query($db, $query);
        //$message = "Welcome to the database";

        //$message = wordwrap($message, 70, "\r\n");

        //mail('velsharoon3@gmail.com', 'New User', $message);
        geoConvert($postData['zipCode']);
        // echo json_encode('Thank you' . $fullName . 'for your order!');
    }
    
    if(!empty($_POST['action']))
    {
        switch($_POST['action'])
        {
            case 'makes':
                findCarMakes();
                break;
            case 'models':
                findCarModels($_POST['make']);
                break;
            case 'engines':
                findCarEngines($_POST['model']);
                break;
            case 'submitInfo':
                uploadData($_POST);
                break;
            default:
                break;
        }
    }
    
    function findCarMakes()
    {
        global $db;
        
        $query = 'SELECT * FROM car_makes';
        $result = mysqli_query($db, $query);
        
        $makes = mysqli_fetch_all($result);
        
        echo json_encode($makes);
    }
    
    function findCarModels($make)
    {
        global $db;
        $query = 'SELECT * FROM car_models WHERE make_id = ' . $make;
        $result = mysqli_query($db, $query);
        
        $models = mysqli_fetch_all($result);
        echo json_encode($models);
    }
    
    function findCarEngines($model)
    {
        global $db;
        $query = 'SELECT * FROM car_engines WHERE model_id = ' . $model;
        $result = mysqli_query($db, $query);
        
        $engines = mysqli_fetch_all($result);
        echo json_encode($engines); 
    }
    
    function geoConvert($zipCode)
    {
        $apiURL = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $zipCode . '&key=AIzaSyBTTsdHxs_5b51hmP-OKwsgvVtVZ2cbc9k';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $geoloc = json_decode(curl_exec($ch), true);
        
        // echo json_encode($geoloc);
        
        $lat = $geoloc['results'][0]['geometry']['location']['lat'];
        $lon = $geoloc['results'][0]['geometry']['location']['lng'];

        curl_close($ch);
        getPlaces($lat, $lon);
    }
    
    function getPlaces($lat, $lon)
    {
        $apiURL = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=' . $lat . ','. $lon . '&radius=5000&types=car_dealer&key=AIzaSyBiaN6so44HSbgB3kjOvFeUdUQcfjyAW94';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $places = json_decode(curl_exec($ch), true);
        curl_close($ch);
        
        echo json_encode($places);
    }
?>