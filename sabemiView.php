<style>
    table,te,th,td {
        border: 1px solid black;
    }
</style>

           <?php
                include("./config.php");

                $result2 = mysqli_query($conn, "SELECT * FROM `sabemi`ORDER BY valor ASC");
                $array = [];
                echo '<table class="fl-table">
                            <thead>
                                <tr>
                                    <th>CPF</th>
                                    <th>NOME</th>
                                    <th>Telefone</th>
                                    <th>dataNascimento</th>
                                    <th>empresa</th>
                                    <th>prazo</th>
                                    <th>valor</th>
                                </tr>
                            </thead>
                            <tbody>';

                $vazio = 0;
                if (!$result2){
                
                } else {
                    while($row = mysqli_fetch_row($result2)){
                            if (substr($row[4],6) >= "1960"){
                                $prazoL = str_replace(".","",$row[7]);
                                $prazoL = abs(str_replace(",",".",$prazoL));
                                if ($prazoL >= 100){
                                    $prazoL = str_replace(".",",",$prazoL);
                                    echo '<tr>';
                                    echo '<td>';
                                    echo $row[1];
                                    echo '</td>';
                                    echo '<td>';
                                    echo $row[2];
                                    echo '</td>';
                                    echo '<td>';
                                    echo $row[3];
                                    echo '</td>';
                                    echo '<td>';
                                    echo $row[4];
                                    echo '</td>';
                                    echo '<td>';
                                    echo $row[5];
                                    echo '</td>';
                                    echo '<td>';
                                    echo $row[6];
                                    echo '</td>';
                                    echo '<td>';
                                    echo $prazoL;
                                    echo '</td>';
                                }
                            }
                            
                        }
                    
                }
                echo '</tbody></table>';

            ?>