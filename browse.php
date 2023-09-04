<?php
require_once('db_config.php');
$connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);;
$result = $connection->query("SELECT * FROM pictures ORDER BY UploadDate DESC LIMIT 5");

while ($row = $result->fetch_assoc()) {
    $ID = $row['PhotoID'];
    $filename = $row['FileName'];
    $fullName = $ID  . "-" . $filename;
    #echo '<img src="uploads/' . $fullName . '" alt="Image" width="400px">';
    echo '<img src="uploadsLink/' . $fullName . '" alt="Image" width="400px">';
}

#Get tags

#$tags = [];
#$result = $connection->query("SELECT Tags FROM pictures ORDER BY UploadDate");
#while ($row = $result->fetch_assoc()) {
#    foreach ($row as $tag){
#        $itemsArray = preg_split('/\s*,\s*/', $tag, -1, PREG_SPLIT_NO_EMPTY);
#        foreach ($itemsArray as $tagg)
#            array_push($tags, $tagg);
#    }
#}
#echo "<br>";
#$values = array_count_values($tags);
#echo "TAGS:<br>";
#echo "<br>";
#
#foreach ($values as $key => $value) {
#    echo "$key($value)<br>";
#}
#echo "<br><br><br>";
?>