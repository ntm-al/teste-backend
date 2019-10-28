<?php
// definições de host, database, usuário e senha
$host = "sql305.epizy.com";
$db   = "epiz_24695434_desafio";
$user = "epiz_24695434";
$pass = "M72sArXU2Vo";
// conecta ao banco de dados
$mysqli = new mysqli($host, $user, $pass, $db);
$sql = mysqli_query($mysqli,"SELECT regional,COUNT(*) FROM students GROUP BY regional");

$data = mysqli_fetch_all($sql);
$lines = count($data);
$Ntax = 0;

echo '<pre>
{
    "regionals":[';
for($i = 0; $i < $lines; $i++){
    $estado = $data[$i][0];
    $idea = mysqli_query($mysqli,"SELECT id FROM students WHERE regional = '".$estado."'"); 
    $idea = mysqli_fetch_all($idea); // Ids dos Ex-Alunos

    $tea = count($idea); // Total de Ex-Alunos 

    foreach($idea as $id){
        $resp = mysqli_query($mysqli,"SELECT alternative_id FROM answers WHERE student_id = '".$id[0]."'");
        $resp = mysqli_fetch_all($resp);
        $resp = $resp[0][0];
        if($resp == 37){
            $teaS++;
        };
    };

    $ave = ($teaS / $tea) * 100;
    $ave = number_format($ave, 4, '.', '');
    $Ntax += $ave;
    echo '
    {
        "description": "'.$estado.'",
        "average": '.$ave.'
    },';
        $teaS = 0;
         
};
        $Ntax = ($Ntax / $lines);
        $Ntax = number_format($Ntax, 4, '.', '');
echo '
   ],
   "national": '.$Ntax.'
}</pre>';
?>