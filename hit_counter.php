<?php
 2         $servername = '127.0.0.1';
 3         $username = 'alumno';
 4         $password = 'contraseña';
 5         try{
 6             $conn = new PDO ("mysql:host=127.0.0.1;dbname=visitantes", $username, $password);
 7             $siteVisitsMap  = 'siteStats';
 8             $visitorHashKey = '';
 9                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
10
11                         $visitorHashKey = $_SERVER['HTTP_CLIENT_IP'];
12
13                  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
14
15                         $visitorHashKey = $_SERVER['HTTP_X_FORWARDED_FOR'];
16
17                 } else {
18
19                         $visitorHashKey = $_SERVER['REMOTE_ADDR'];
20                 }
21
22                 $totalVisits = 0 ;
23
24                 $query = $conn->prepare("SELECT ip, contador FROM visitas WHERE ip = :ip");
25                 $query -> bindParam(":ip",$visitorHashKey);
26                 $query-> execute();
27                 $result = $query -> fetch(PDO::FETCH_ASSOC);
28
29                 if ($result == FALSE){
30                     $totalVisits = 1;
31                     $sql = "INSERT INTO visitas (ip,contador) VALUES (:ip, :contador)";
32                     $stmt = $conn->prepare($sql);
33                     $stmt->bindParam(':ip', $visitorHashKey);
34                     $stmt->bindParam(':contador',$totalVisits);
35                     $stmt->execute();
36                     echo "Bienvenido, has entrado en la página " .$totalVisits.".";
37                 }else{
38                     $totalVisits = $result['contador']+1;
39                     $sql = "UPDATE visitas SET contador = :contador WHERE ip = :ip";
40                     $stmt = $conn->prepare($sql);
41                     $stmt->bindParam(':ip', $visitorHashKey);
42                     $stmt->bindParam(':contador',$totalVisits);
43                     $stmt->execute();
44                     echo "Bienvenido, has entrado en la página " .$totalVisits.".";
45                 }
46         }catch (Exception $e){
47
48          }
49 ?>
