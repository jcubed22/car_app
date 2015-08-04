<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Car.php";

    $app = new Silex\Application();

    $app->get("/", function() {
        $porsche = new Car("2014 Porsche 911", 114991, 7864, "images/porsche.jpg");
        $ford = new Car("2011 Ford F450", 55995, 14241, "images/ford.jpg");
        $lexus = new Car("2013 Lexus RX 350", 44700, 20000, "images/lexus.jpg");
        $mercedes = new Car("Mercedes Benz CLS550", 39900, 37979, "images/benz.jpg");

        $cars = array($porsche, $ford, $lexus, $mercedes);

        $cars_matching_search = array();
        foreach ($cars as $car) {
            if ($car->getPrice() < $_GET["price"] && $car->getMiles() < $_GET["miles"]) {
                array_push($cars_matching_search, $car);
            }
        }

        output   "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Your Car Dealership's Homepage</title>
        </head>
        <body>
            <h1>Your Car Dealership</h1>
            <ul>
                <?php
                  if (empty($cars_matching_search)) {
                    echo "No matching result!";
                  } else {
                      foreach ($cars_matching_search as $car) {
                        $new_car_price = $car->getPrice();
                        $new_car_model = $car->getMakeModel();
                        $new_car_miles = $car->getMiles();
                        $new_car_image = $car->getImage();
                        echo "<li> $new_car_model </li>";
                        echo "<ul>";
                          echo "<li><img src='$new_car_image'></li>";
                          echo "<li> $$new_car_price </li>";
                          echo "<li> Miles: $new_car_miles </li>";
                        echo "</ul>";
                       }
                  }

                ?>
            </ul>
        </body>
        </html>
        ";
    });

    $app->get("/new_car", function() {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css'>
            <title>Find a Car</title>
        </head>
        <body>
            <div class='container'>
                <h1>Find a Car!</h1>
                <form action='Car.php'>
                    <div class='form-group'>
                        <label for='price'>Enter Maximum Price:</label>
                        <input id='price' name='price' class='form-control' type='number'>
                        <label for='miles'>Enter Maximum Miles:</label>
                        <input id='miles' name='miles' class='form-control' type='number'>
                    </div>
                    <button type='submit' class='btn-success'>Submit</button>
                </form>
            </div>
        </body>
        </html>
        ";
    });

    return $app;

?>
