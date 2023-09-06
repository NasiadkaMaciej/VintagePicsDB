<?php
require_once('db_config.php');
$connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);;


#if (!isset($_GET['tagList']))
#    $tagList = [];
#else
#    foreach ($tagList as $tag)
#        if (!in_array($tag, $tagList))
#            array_push($tagList, $_GET['tag']);

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
    $stmt = $connection->query("SELECT pictures.FileName, pictures.PhotoID FROM pictures INNER JOIN picTags ON pictures.PhotoID = picTags.PhotoID INNER JOIN tags ON picTags.TagID = tags.TagID WHERE tags.TagID = $tag");
    while ($row = $stmt->fetch_assoc()) {
        $ID = $row['PhotoID'];
        $filename = $row['FileName'];
        $fullName = $ID  . "-" . $filename;
        #echo '<img src="uploads/' . $fullName . '" alt="Image" width="400px">';
        echo '<img src="uploadsLink/' . $fullName . '" alt="Image" width="400px">';
        #show bigger image on click
    }
}


#Get tags

$tags = [];
#Get TagID, TagName and count of pictures with tag
$result = $connection->query("SELECT tags.TagID, TagName, COUNT(PhotoID) as Count FROM tags, picTags WHERE tags.TagID = picTags.TagID GROUP BY (TagID)");

while ($row = $result->fetch_assoc())
    #$arr = [];
    #var_dump($arr);
    array_push($tags, [$row["TagID"], $row["TagName"], $row["Count"]]);
echo "<br>Tags:<br>";
foreach ($tags as $tag) {
    if ($tag[0] ==  $_GET['tag'])
        echo "<a href='?tag=" . $tag[0] . "'>" . $tag[1] . " (" . $tag[2] . ") Selected</a><br>";
    #}
    echo "<a href='?tag=" . $tag[0] . "'>" . $tag[1] . " (" . $tag[2] . ")</a><br>";
}

#$values = array_count_values($tags);
#echo "TAGS:<br>";
#echo "<br>";

#foreach ($values as $key => $value) {
#    echo "$key($value)<br>";
#}
echo "<br><br><br>";
