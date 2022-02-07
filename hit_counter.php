<?php
        $servername = 'mysql';
        $username = 'alumno';
        $password = 'contraseña';
        try{
            $conn = new PDO ("mysql:host=$servername;dbname=visitantes", $username, $password);
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

                $sql = "SELECT ip, contador FROM visitas WHERE ip = :ip";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":ip", $visitorHashKey);

                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result = $stmt->execute();

                if ($result != TRUE){
                    $totalVisits = 1;
                    $sql = "INSERT INTO visitas (ip,cuenta) VALUES :ip, :contador ON DUPLICATE KEY UPDATE contador = :contador ; ";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam('ip', $visitorHashKey);
                    $stmt->bindParam('contador',$totalVisits);
                    $stmt->execute();
                }else{
                    $totalVisits = $row['contador'] + 1;
                    $sql = "UPDATE visitas SET contador=contador WHERE ip=ip";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam('ip', $visitorHashKey);
                    $stmt->bindParam('contador',$totalVisits);
                    $stmt->execute();
                }
                echo "Bienvenido, has entrado en la página " .$totalVisits.".";
        }catch (Exception e){
            
        }
?>
