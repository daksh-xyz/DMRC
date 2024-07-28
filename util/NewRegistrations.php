<?php
$dataPoints = array();

try {
    // Creating a new connection.
    $link = new \PDO(
        'mysql:host=localhost;dbname=dmrc;charset=utf8mb4;port=3307',
        'root',
        'root',
        array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_PERSISTENT => false
        )
    );

    // Update SQL query to group by date only
    $handle = $link->prepare("SELECT DATE(RegisterTime) AS RegisterDate, COUNT(Alumni_id) AS NumberOfRegistrations 
FROM alumni  
WHERE RegisterTime >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
GROUP BY RegisterDate;
");
    $handle->execute();
    $result = $handle->fetchAll(\PDO::FETCH_OBJ);

    foreach ($result as $row) {
        // Convert date to a timestamp
        $date = strtotime($row->RegisterDate) * 1000; // Convert to milliseconds
        array_push($dataPoints, array("x" => $date, "y" => $row->NumberOfRegistrations));
    }
    $link = null;
} catch (\PDOException $ex) {
    print ($ex->getMessage());
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                axisX: {
                    valueFormatString: "DD MMM YY",
                    title: "Date",
                },
                axisY: {
                    title: "Number of Registrations",
                    interval: 1
                },
                data: [{
                    type: "line", // change type to bar, line, area, pie, etc
                    xValueType: "dateTime",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>
</head>

<body>
    <div id="chartContainer" style="height:100%; width:90%;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>

</html>