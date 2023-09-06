<?php
require_once('db_config.php');
$connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);;

if (!isset($_GET['tag'])) {
    $result = $connection->query("SELECT * FROM pictures ORDER BY UploadDate DESC LIMIT 5");
    while ($row = $result->fetch_assoc()) {
        $ID = $row['PhotoID'];
        $filename = $row['FileName'];
        $fullName = $ID  . "-" . $filename;
        #echo '<img src="uploads/' . $fullName . '" alt="Image" width="400px">';
        echo '<img src="uploadsLink/' . $fullName . '" alt="Image" width="400px">';
    }
} else {
    $tag = $_GET['tag'];
    $stmt = $connection->query("SELECT pictures.FileName, pictures.PhotoID FROM pictures INNER JOIN picTags ON pictures.PhotoID = picTags.PhotoID INNER JOIN tags ON picTags.TagID = tags.TagID WHERE tags.TagName = '$tag'");
    while ($row = $stmt->fetch_assoc()) {
        $ID = $row['PhotoID'];
        $filename = $row['FileName'];
        $fullName = $ID  . "-" . $filename;
        #echo '<img src="uploads/' . $fullName . '" alt="Image" width="400px">';
        echo '<img src="uploadsLink/' . $fullName . '" alt="Image" width="400px">';
    }
}


#Get tags

$tags = [];

$result = $connection->query("SELECT TagName FROM tags");

while ($row = $result->fetch_assoc())
    array_push($tags, $row["TagName"]);
echo "<br>Tags:<br>";
foreach ($tags as $key => $value) {
    echo "<a href='?tag=$value'>" . "$value</a><br>";
}

#$values = array_count_values($tags);
#echo "TAGS:<br>";
#echo "<br>";

#foreach ($values as $key => $value) {
#    echo "$key($value)<br>";
#}
echo "<br><br><br>";
