<?php
        $servername = '127.0.0.1';
        $username = 'alumno';
        $password = 'contraseña';
        try{
            $conn = new PDO ("mysql:host=127.0.0.1;dbname=visitantes", $username, $password);
            $siteVisitsMap  = 'siteStats';
            $visitorHashKey = '';
               if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

                        $visitorHashKey = $_SERVER['HTTP_CLIENT_IP'];

                 } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

                        $visitorHashKey = $_SERVER['HTTP_X_FORWARDED_FOR'];

                } else {

                        $visitorHashKey = $_SERVER['REMOTE_ADDR'];
                }

                $totalVisits = 0 ;

                $query = $conn->prepare("SELECT ip, contador FROM visitas WHERE ip = :ip");
                $query = bindParam(":ip",$visitorHashKey);
                $query-> execute();
                $result = $query -> fetch(PDO::FETCH_ASSOC);

                if ($result !== TRUE){
                    $totalVisits = 1;
                    $sql = "INSERT INTO visitas (ip,contador) VALUES (:ip, :contador)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':ip', $visitorHashKey);
                    $stmt->bindParam(':contador',$totalVisits);
                    $stmt->execute();
                    echo "Bienvenido, has entrado en la página " .$totalVisits.".";
                }else{
                    $totalVisits = $result['contador']+1;
                    $sql = "UPDATE visitas SET contador = :contador WHERE ip = :ip";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':ip', $visitorHashKey);
                    $stmt->bindParam(':contador',$totalVisits);
                    $stmt->execute();
                    echo "Bienvenido, has entrado en la página " .$totalVisits.".";
                }
        }catch (Exception e){

         }
?>
