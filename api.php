<?php
$in = $_GET['request'];

$msq = mysqli_connect('localhost', 'host1697434', '********', '*****************' );
if ( mysqli_connect_errno() ) {
    printf("Не удалось подключиться к базе: %s\n", mysqli_connect_error());
    exit();}
$msq->query ( "SET NAMES 'utf8'");
$out = $msq->query ("SELECT * FROM author, book WHERE (book.a1=$in OR book.a2=$in OR book.a3=$in) AND author.id=$in");

// $row = mysqli_fetch_all($out);

// print_r (json_encode(array('ID' => $row['id'], 'TITLE:' => $row['booktitle'], 'CONTENT:' => $row['content'], 'AUTHOR' =>$row['title'], $row['first name'], $row['second name']) ));

while($row = $out->fetch_array()) {
    echo $row['id']." "."TITLE: " . $row['booktitle']."<br>".'CONTENT: ' . $row['content']."<br>".
    'AUTHOR: ' . $row['title']." ". $row['first name']." ".$row['second name'] . "<br><hr><br>";}

// $out = $msq->query ("SELECT author.*, book.booktitle, book.content FROM author, book WHERE (book.a1=1 OR book.a2=1 OR book.a3=1) AND author.id=1");
echo "<pre";
print_r($out);
?>
