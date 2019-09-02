<?php
$comment  = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$name  = filter_input(INPUT_POST, "commenterName", FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

$output = $_SERVER["REMOTE_ADDR"] . "|Name:  " . $name . "|Comment: " . $comment;

$myfile = file_put_contents('comments.txt', $output.PHP_EOL , FILE_APPEND | LOCK_EX);
?>

<html>
<head>
<script>
document.location.href = "index.php";
</script>
</head>
<body>
Successfully received your comment!
</body>
</html>
