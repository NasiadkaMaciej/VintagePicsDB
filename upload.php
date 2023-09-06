<?php

if (isset($_FILES['picture'])) {
    //Generate random 10 letter file ID
    //Move file to storage
    //Upload ID and file name to database
    $filename = $_FILES['picture']['name'];
    $filename = urldecode($filename);
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $ID = "";
    for ($i = 0; $i < 10; $i++)
        $ID .= $characters[rand(0, strlen($characters) - 1)];

    #move_uploaded_file($_FILES['picture']['tmp_name'], '/www/pics/uploads/' . $ID . "-" . $filename);

    move_uploaded_file($_FILES['picture']['tmp_name'], '/tmp/picsStorage/' . $ID . "-" . $filename);
    #if (file_exists('/www/pics/uploads/' . $ID . "-" . $filename)) {
    if (file_exists('/tmp/picsStorage/' . $ID . "-" . $filename)) {

        require_once('db_config.php');

        $connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        #Upload tags if they don't exist
        $itemsArray = array_unique(array_map('trim', explode(',', $_POST["tags"])));

        $checkIfTag = $connection->prepare("SELECT * FROM tags WHERE TagName = (?)");
        $insertTag = $connection->prepare("INSERT INTO tags (TagName) VALUES (?)");

        foreach ($itemsArray as $tag) {
            $checkIfTag->bind_param('s', $tag);
            $checkIfTag->execute();
            $result = $checkIfTag->get_result();
            if ($result->num_rows == 0) {
                $insertTag->bind_param('s', $tag);
                $insertTag->execute();
            }
        }
        $checkIfTag->close();
        $insertTag->close();

        #Put picture info to DB
        $stmt = $connection->prepare("INSERT INTO pictures (PhotoID, FileName, PictureName, Description, Author) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $ID, $filename, $_POST["pictureName"], $_POST["description"], $_SESSION['username']);
        $stmt->execute();

        #Put tags and picture relation info to db
        foreach ($itemsArray as $tag) {
            $getTagID = $connection->prepare("SELECT TagID FROM tags WHERE TagName = (?)");
            $getTagID->bind_param('s', $tag);
            $getTagID->execute();
            $getTagID->bind_result($tag_id);
            $getTagID->fetch();
            $getTagID->close();

            $putRelation = $connection->prepare("INSERT INTO picTags (PhotoID, TagID) VALUES (?, ?)");
            $putRelation->bind_param('si', $ID,  $tag_id);
            $putRelation->execute();
            $putRelation->close();
        }
    }
    header('Location: ' . "https://pics.nasiadka.pl/");
}
?>
Upload Photos
<form action="upload.php" method="post" enctype="multipart/form-data">
    <div>
        <label for="picture">Picture:</label>
        <input type="file" name="picture" id="picture" accept="image/*" required>
    </div>
    <div>
        <label for="pictureName">Picture Name:</label>
        <input type="text" name="pictureName" id="pictureName" required>
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="4" required></textarea>
    </div>
    <div>
        <label for="tags">Tags (comma-separated):</label>
        <input type="text" name="tags" id="tags" required>
    </div>
    <div>
        <input type="submit" value="Upload">
    </div>
</form>