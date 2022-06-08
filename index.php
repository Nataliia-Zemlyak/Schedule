<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>графік чергування студентів 1-го курсу</title>
    <link rel = "stylesheet" href = "css/style-rel.css">
</head>
<body>
    <div class ="wrapper">
    <form action="index.php" method="POST">
        <table class = table-schedule>
            <thead>
                <tr>
                    <th rowspan = "2">Ім'я</th>
                    <th rowspan = "2">Група</th>
                    <th colspan = "5">Графік</th>
                    <th rowspan = "2">Видалити</th>
                </tr>
                <tr>
                    <td>Понеділок</td>
                    <td>Вівторок</td>
                    <td>Середа</td>
                    <td>Четвер</td>
                    <td>П'ятниця</td>
                </tr>
            </thead>
            <tbody>


            <?php
                session_start();
                //session_unset();
                if (isset($_SESSION["students"])) {
                    $students = json_decode($_SESSION["students"]);
                } else {
                    $students = [
                        ["Петро", "11-ЕУ"],
                        ["Данііл", "ПЦБ-11-07"],
                        ["Назар", "БО-11"],
                        ["Оксана", "ПЦБ-11-07"],
                        ["Андрій", "БО-11"],
                        ["Діана", "11-ЕУ"],
                        ["Олексій", "БО-11"],
                        ["Жанна", "ПЦБ-11-07"],
                        ["Людмила", "БО-11"],
                        ["Валентина", "11-ЕУ"],
                    ];
                }
                if (isset($_POST["add"])) {
                    $newStudent = [];
                    array_push($newStudent, $_POST["name"], $_POST["group"]);
                    array_push($students, $newStudent);
                    header('Location: index.php');
                }
                if (isset($_POST["delete"])) {
                    array_splice($students, $_POST["delete"], 1);
                    header('Location: index.php');
                    
                }
                
                $countDays = 5;
                $schedule1Start = 9;
                $schedule2Start = 18;
                $schedule1 = [];
                $schedule2 = [];
                $schedule3 = [];
                for ($i = 0, $k = $schedule1Start, $m =$schedule2Start; $i < $countDays; $i++, $k++, $m--) {
                    $schedule3Start = rand(9,18);
                    $isNotok = true; 
                    if ($schedule3Start != $k && $schedule3Start != $m ) {
                        $isNotok = true;
                        for ($j = 0; $j < count($schedule3); $j++) {
                            $test = $schedule3[$j] [0] . $schedule3[$j] [1];
                            if ($schedule3[$j][0] == $schedule3Start || $schedule3[$j][1] == $schedule3Start || $test == $schedule3Start) {
                                $isNotok = true;
                                break;
                            }
                    }
                }
                    while ($schedule3Start == $k || $schedule3Start == $m || $isNotok) {
                        if (count($schedule3) == 0) {
                            $isNotok = false;
                        }
                        for ($j = 0; $j < count($schedule3); $j++) {
                            $test = $schedule3[$j] [0] . $schedule3[$j] [1];
                            if ($schedule3[$j][0] == $schedule3Start || $schedule3[$j][1] == $schedule3Start || $test == $schedule3Start) {
                                $isNotok = true;
                                break;
                            }
                            if (($j + 1) == count($schedule3)) {
                                $isNotok = false;
                            }
                        }
                        if ($schedule3Start == $k || $schedule3Start == $m || $isNotok) {

                            $schedule3Start = rand(9,18);
                            $isNotok = true;
                            
                        }
                    }
                    $time1 = "";
                    $time2 ="";
                    $time3 ="";
                    if ($k < 10) {
                        $time1 .= 0;
                    }
                    if ($m <10) {
                        $time2 .= 0;
                    }
                    if ($schedule3Start < 10) {
                        $time3 .= 0;
                    }
                    $time1 .= $k .":00";
                    $time2 .= $m .":00";
                    $time3 .= $schedule3Start .":00";
                    
                    $schedule1[] .= $time1; 
                    $schedule2[] .= $time2;
                    $schedule3[] .=$time3;

                    //array_push ($schedule1, $time);
                }
                for ($i = 0; $i < count($students); $i++) {
                    echo "<tr>";
                    echo "<td>".$students[$i][0]."</td>";
                    echo "<td>".$students[$i][1]."</td>";
                    for ($j = 0; $j < count($schedule1); $j++ ) {
                        if ($students[$i][1] == "11-ЕУ") {
                            echo "<td>".$schedule1[$j]."</td>";
                        } else if ($students[$i][1] == "ПЦБ-11-07") {
                            echo "<td>".$schedule2[$j]."</td>";
                        } else if ($students[$i][1] == "БО-11") {
                            echo "<td>".$schedule3[$j]."</td>";
                        }
                    }
                    echo "<td><button type='submit' name='delete' value='$i'>-</button></td>";
                    echo "</tr>";
                }
                $_SESSION["students"] = json_encode($students);
                

                ?>
            </tbody>
            </table>

            <p>
                <label>
                    <input type="text" name="name" placeholder="Ім'я">
                </label>
                <label class="select">
                    <select name="group">
                        <option value="БО-11" selected desibled>Група</option>
                        <option value="11-ЕУ">11-ЕУ</option>
                        <option value="ПЦБ-11-07">ПЦБ-11-07</option>
                        <option value="БО-11">БО-11</option>
                        
                </label>
                
                <label>
                    <input type="submit" name ="add" value ="+">
                </label>
            </p>
        
        </form>
     </div>
    
</body>
</html>