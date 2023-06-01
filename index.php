<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lb3</title>
    <?php
    require_once "connection.php";
    ?>
</head>
<body>
    <div>
        <h3>Результат: </h3>
        <div class="result">Результату щє немає</div>
    </div>
    <div>
        <h3>Отриманити дохід з прокату станом на обрану дату; </h3>
        <input type="date" id="date" value="2014-10-01">
        <input type="submit" id="text" value="Отримати">
    </div>
    <div>
        <h3>Отримати автомобілі обраного виробника; </h3>
        <select id="vendor" >
            <?php
            try{
                $stmt = $dbh->prepare("SELECT Name FROM vendors");
                $stmt->execute(); 
                $cursor = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($cursor as $vendor) {
                    echo '<option>' . $vendor['Name'] . '</option>';
                }
            } catch (PDOException $ex) {
                echo $ex->getMessage(); 
            }
            ?>
        </select>
        <input type="submit" id="xml" value="Отримати">
    </div>
    <div>
        <h3>Отримати вільні автомобілі на обрану дату. </h3>
		<input type="date" id="freeDate" value="2014-08-15" />
        <input type="submit" id="json" value="Отримати">
    </div>
    <script>
        const ajax = new XMLHttpRequest();

        document.getElementById("text").addEventListener("click", function () {
            ajax.onreadystatechange = function() {
                if (ajax.readyState === 4 && ajax.status === 200) {
                    document.getElementsByClassName("result")[0].innerHTML = ajax.responseText;
                }
            };
            const date = document.getElementById("date").value;
            ajax.open('GET', 'income.php?date=' + date);
            ajax.send();
        })
        
        document.getElementById("xml").addEventListener("click", function () {
            ajax.onreadystatechange = function() {
                if (ajax.readyState === 4 && ajax.status === 200) {
                    const xml = ajax.responseXML;
                    let output = "";
                    let car = xml.getElementsByTagName("car");
                    for (i = 0; i < car.length; i++) {
                        output += car[i].childNodes[0].nodeValue + "<br>";
                    }
                    document.getElementsByClassName("result")[0].innerHTML = output;
                }
            };
            const vendor = document.getElementById("vendor").value;
            ajax.open('GET', 'vendorCar.php?vendor=' + vendor);
            ajax.send();
        })
        document.getElementById("json").addEventListener("click", function () {
            ajax.onreadystatechange = function() {
                if (ajax.readyState === 4 && ajax.status === 200) {
                    const responseJSON = JSON.parse(ajax.responseText);
                    let output = "";
                    for (let i = 0; i < responseJSON.length; i++) {
                        output += responseJSON[i].Name + "<br>";
                    }
                    document.getElementsByClassName("result")[0].innerHTML = output;
                }
            };
            const freeDate = document.getElementById("freeDate").value;
            ajax.open('GET', 'freeCars.php?freeDate=' + freeDate);
            ajax.send();
        })
    </script>
</body>
</html>