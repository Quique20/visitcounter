!DOCTYPE html>
<html>

  <head>
    <title>Site Visits Report</title>
  </head>

  <body>
<h1>Site Visits Report</h1>

<table border = '1'>
  <tr>
    <th>No.</th>
    <th>Visitor</th>
    <th>Total Visits</th>
  </tr>

  <?php

      try {
          $servername = 'localhost';
          $username = 'alumno';
          $password = 'contraseña';

          $conn = new PDO ("mysql:host=$servername;dbname=visitantes", $username, $password);
          
          $siteVisitsMap = 'siteStats';

          $i = 1;
                foreach($conn->query("SELECT ip, contador FROM visitas") as $row) {
                    echo "<tr>";
                      echo "<td align = 'left'>"   . $i . "."     . "</td>";
                      echo "<td align = 'left'>"   . $row['ip']     . "</td>";
                      echo "<td align = 'right'>"  . $row['contador'] . "</td>";
                    echo "</tr>";

                    $i++;
                }

      } catch (Exception $e) {
          echo $e->getMessage();
      }

  ?>

</table>
</body>

</html>