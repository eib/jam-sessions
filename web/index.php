<?php
try {
    require_once('db.php');
    $db = DB::connect();
    $stmt = $db->prepare('SELECT 1');
    $stmt->execute();
    $result = $stmt->fetch();
    print_r($result);
} catch (Exception $e) {
    print_r($e);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>
Jam Sessions
</title>

<body>
<h1>Hello, Rock-stars!</h1>
</body>
</html>
