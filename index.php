<?php 

#MYSQL CONNECTION SETTINGS
$host = 'localhost';
$port = '3306';
$dbname = 'test';
$user = 'root';
$pass = '';

#POSTGRESQL CONNECTION SETTINGS
$phost = 'localhost';
$pport = '5432';
$pdbname = 'TEST';
$puser = 'postgres';
$ppass = 'pass1234';


set_time_limit(0);
$timeStart = microtime(true);


#MYSQL CONNECTION
try {
  $myvt = new PDO("mysql:host={$host};port={$port};dbname={$dbname};charset=utf8", "{$user}", "{$pass}");
  $myvt->query("SET NAMES 'utf8'");
  $myvt->query("SET CHARACTER SET utf8");
  $myvt->query("SET COLLATION_CONNECTION = 'utf8_turkish_ci'");
  $myvt->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch ( PDOException $e ){
    print $e->getMessage();
} //try x



#POSTGRESQL CONNECTION
try {
  $pgvt = new PDO("pgsql:host={$phost};port={$pport};dbname={$pdbname};user={$puser};password={$ppass};");
  $pgvt->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch ( PDOException $e ){
    print $e->getMessage();
} //try x


#PURE SQL MAKER
function sql(&$vt,$sql){
    $query = $vt->prepare($sql);
    $query->execute();
    $qw = $query->fetchAll(PDO::FETCH_ASSOC);    
    return $qw;
}


#MSSQL ADD DATA
function mssqlAddData(&$vt, $data){

    $sql = "INSERT INTO {$data['tablo']} ";
    $execute_array = array();
    $i = 1;
    $sqlBefore = "";
    $sqlAfter = "";

    foreach ($data['add'] as $key => $value) {

      if($i==1){
          $sqlBefore .= "( ";
          $sqlBefore .= $key;
          
          $sqlAfter .= "( ";
          $sqlAfter .= $value;
          
        //   $execute_array[$key] = $value;

      } else {
     
          $sqlBefore .= ", ";
          $sqlBefore .= $key;

          $sqlAfter .= ", ";
          $sqlAfter .= $value;

        //   $execute_array[$key] = $value;
      }

      $i++;

    }

    $sqlBefore .= ") ";
    $sql .= $sqlBefore;
    $sql .= "VALUES ";
    $sqlAfter .= ") ";
    $sql .= $sqlAfter;

    
    $sql_guncelle = $vt->prepare($sql);
    $sql_guncelle->execute($execute_array);
    $last_id = $vt->lastInsertId();
    return $last_id;

}


#MYSQL ADD DATA
function mysqlAddData(&$vt, $data){

    $sql = "INSERT INTO {$data['tablo']} ";
    $execute_array = array();
    $i = 1;
    $sqlBefore = "";
    $sqlAfter = "";

    foreach ($data['add'] as $key => $value) {

        if($i==1){
            $sqlBefore .= "( ";
            $sqlBefore .= $key;
            
            $sqlAfter .= "( ";
            $sqlAfter .= $value;
            
        //   $execute_array[$key] = $value;

        } else {
        
            $sqlBefore .= ", ";
            $sqlBefore .= $key;

            $sqlAfter .= ", ";
            $sqlAfter .= $value;

        //   $execute_array[$key] = $value;
        }

        $i++;

    }

    $sqlBefore .= ") ";
    $sql .= $sqlBefore;
    $sql .= "VALUES ";
    $sqlAfter .= ") ";
    $sql .= $sqlAfter;


    $sql_guncelle = $vt->prepare($sql);
    $sql_guncelle->execute($execute_array);
    $last_id = $vt->lastInsertId();
    return $last_id;

}


#POSTGRESQL ADD DATA
function postgreSqlAddData(&$vt, $data){

    $sql = "INSERT INTO {$data['tablo']} ";
    $execute_array = array();
    $i = 1;
    $sqlBefore = "";
    $sqlAfter = "";
    
    foreach ($data['add'] as $key => $value) {
    
        if($i==1){
            $sqlBefore .= "( ";
            $sqlBefore .= $key;
            
            $sqlAfter .= "( ";
            $sqlAfter .= $value;
            
        //   $execute_array[$key] = $value;
    
        } else {
        
            $sqlBefore .= ", ";
            $sqlBefore .= $key;
    
            $sqlAfter .= ", ";
            $sqlAfter .= $value;
    
        //   $execute_array[$key] = $value;
        }
    
        $i++;
    
    }
    
    $sqlBefore .= ") ";
    $sql .= $sqlBefore;
    $sql .= "VALUES ";
    $sqlAfter .= ") ";
    $sql .= $sqlAfter;
    
    
    $sql_guncelle = $vt->prepare($sql);
    $sql_guncelle->execute($execute_array);
    $last_id = $vt->lastInsertId();
    return $last_id;
    
}

#SHOW ARRAY DATA
function pre($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}


#RANDOM STRING MAKER
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

#----------------------------------------------------------------------------------------#

#WHICH ACTIVE DATABASE
$mysql  = false;
$ms     = false;
$pgsql  = false;

if(isset($_GET['db'])){
    switch($_GET['db']){
        case 'mysql':
            $mysql = true;
        break;
        case 'ms':
            $ms = true;
        break;
        case 'pgsql':
            $pgsql = true;
        break;
    }
}

#PROCESS YOU CAN CHANGE (INSERT,SUM,COUNT,LIKE)
$process = 'COUNT';
$db = '';

$showDetails = true;

#HOW MANY DATA SHOULD ADD
$recordCount = 1;

#DATA LIMIT
$recordLimit = 1;


#----------------------------------------------------------------------------------------#

#OS
$os = [
    'windows',
    'linux',
    'android',
    'mac',
    'ubuntu',
    'centos',
    'windowserver'
];

for($i=0; $i < $recordCount; $i++){
    $data = [
        'tablo' => '[TEST].[dbo].[data_table]',
        'add' => [
            'user_id'  => rand(1,99999),
            'admin_id'   => rand(1,99999),
            'keyword'  => "'".generateRandomString()."'",
            'os' => "'".$os[rand(0,6)]."'",
            'browser'  => "'".generateRandomString(7)."'",
        ]
    ];

    if($ms){
        $db = 'MSSQL';
        if($process == 'INSERT'){
            $durum = mssqlAddData($vt, $data);
        }

        if($process == 'LIKE'){
            $sql = sql($vt, "SELECT TOP({$recordLimit}) * FROM [TEST].[dbo].[data_table] WHERE keyword LIKE '%a%' OR  keyword LIKE '%b%' OR  keyword LIKE '%c%' AND user_id > 1337 ORDER BY keyword ASC");
            pre($sql);
        }

        if($process == 'COUNT'){
            $sql = sql($vt, "SELECT TOP({$recordLimit}) COUNT(id) AS totalRecord FROM [TEST].[dbo].[data_table]");
            pre($sql);
        }

        if($process == 'SUM'){
            $sql = sql($vt, "SELECT TOP({$recordLimit}) SUM(id) AS totalRecord FROM [TEST].[dbo].[data_table]");
            pre($sql);
        }
        
    }
   
    if($mysql){
        $db = 'MYSQL';

        if($process == 'INSERT'){
            $data['tablo'] = 'data_table';
            $durum2 = mysqlAddData($myvt, $data);
        }

        if($process == 'LIKE'){
            $sql = sql($myvt, "SELECT * FROM data_table WHERE keyword LIKE '%a%' OR  keyword LIKE '%b%' OR  keyword LIKE '%c%' AND user_id > 1337 ORDER BY keyword ASC LIMIT {$recordLimit}");
            pre($sql);
        }

        if($process == 'COUNT'){
            $sql = sql($myvt, "SELECT COUNT(id) AS totalRecord FROM data_table LIMIT {$recordLimit}");
            pre($sql);
        }

        if($process == 'SUM'){
            $sql = sql($myvt, "SELECT SUM(id) AS totalRecord FROM data_table LIMIT {$recordLimit}");
            pre($sql);
        }
    }

    if($pgsql){
        $db = 'PGSQL';


        if($process == 'INSERT'){
            $data['tablo'] = 'data_table';
            $durum3 = postgreSqlAddData($pgvt, $data);
        }
        
        if($process == 'LIKE'){
            $sql = sql($pgvt, "SELECT * FROM data_table WHERE keyword LIKE '%a%' OR keyword LIKE '%b%' OR  keyword LIKE '%c%' AND user_id > 1337 ORDER BY keyword ASC LIMIT {$recordLimit}");
            pre($sql);
        }

        if($process == 'COUNT'){
            $sql = sql($pgvt, "SELECT COUNT(id) AS totalRecord FROM data_table LIMIT {$recordLimit}");
            pre($sql);
        }

        if($process == 'SUM'){
            $sql = sql($pgvt, "SELECT SUM(id) AS totalRecord FROM data_table LIMIT {$recordLimit}");
            pre($sql);
        }
    }
    
}



if($ms){
    if($process == 'INSERT'){
        echo " MSSQL Last Insert ID - <b>  ".number_format($durum)."</b><br>";
    }
}

if($mysql){
    if($process == 'INSERT'){
        echo " MYSQL Last Insert ID - <b>".number_format($durum2)."</b><br>";
    }
}

if($pgsql){
    if($process == 'INSERT'){
        echo " PGSQL Last Insert ID - <b>".number_format($durum3)."</b><br>";
    }
}




if($showDetails == true){ 

    $timeEnd = microtime(true);
    $time = $timeEnd - $timeStart;
    $memory = round(memory_get_peak_usage()/1048576, 2);
    $px = ceil($memory);
    $lastTime = mb_substr($time,0,5);
    $queryCounts = 0;
    if($queryCounts < 10){
      $queryCounts = '0';
    }
    $k_id = '';

    $line = '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------';
    $spacer = '    |    ';

    $content = "<br>";
    $content .= $line;
    $content .= "<br>";
    $content .= '|    ';
    $content .= "Records : ".$recordCount ." Qty";
    $content .= $spacer;
    $content .= "Time : ".$lastTime." Seconds";
    $content .= $spacer;
    $content .= "Memory : ".number_format($memory,3)." MB";
    $content .= $spacer;
    
    $content .= "<br>";
    $content .= $line;
    $content .= "<br>";

    if($process != 'INSERT'){
        $recordCount = $recordLimit;
    }
  
    $data = [
       'tablo' =>  'analizyap',
       'add' => [
            'queryCounts' =>$recordCount,
            'time' => floatval($lastTime),
            'memory' => floatval(number_format($memory,3)),
            'db' => "'".$db."'",
            'process' => "'".$process."'"
       ]
    ];

    $durum4 = mysqlAddData($pgvt, $data);
 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BENCMARK TEST</title>
</head>
<body>

<div class="centered">
    <?php echo $content; ?>
</div>

<style>
    .centered{
        background-color: #333;
        color:#FFF;
        font-family: Arial;
        padding: 5px;
        padding-bottom: 25px;
        text-align: center;
    }
</style>
    <script>    

    // setTimeout(() => {
    //     window.location.reload();
    // }, 3663);
        
    </script>
</body>
</html>