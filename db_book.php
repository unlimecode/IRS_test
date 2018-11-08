<?php 

$msq = mysqli_connect('localhost', 'host1697434', '***********', '****************' );


if ( mysqli_connect_errno() ) {
    printf("Не удалось подключиться к базе книг: %s\n", mysqli_connect_error());
    exit();
}
else {
    printf("База книг подключена: %s\n", mysqli_get_host_info($msq) . "<br><br>");
}

$msq->query ("DROP TABLE IF EXISTS book");

$creat = "CREATE TABLE `book` ( `id` INT NOT NULL AUTO_INCREMENT , 
									`booktitle` VARCHAR(80) NOT NULL ,
									`content` TEXT NOT NULL , 
									`a1` INT NOT NULL,
									`a2` INT NOT NULL,
									`a3` INT NOT NULL,
									PRIMARY KEY (`id`)) 
									ENGINE = InnoDB";

if ($msq->query($creat) === TRUE) {
   echo "Таблица book создана успешно <br><br>";
} else {
   echo "Ошибка создания таблицы book: " . $msq->error . "<br><br>";
}
$count = 0;
for ($x=1; $x<21; $x++){

$jsonBook = file_get_contents("https://www.poemist.com/api/v1/randompoems");
$book = json_decode($jsonBook);


for ($y=0; $y<5; $y++) {

$title = mysqli_real_escape_string($msq, $book[$y]->title);
$cont = mysqli_real_escape_string($msq, $book[$y]->content);
$a1 = rand(0,20);
$a2 = rand(0,20);
$a3 = rand(0,20);
$a4 = rand(0,1);
if ($a4 == 0){$a2 = 0; $a3 = 0;}

$ins = "INSERT INTO `book` (`booktitle`, `content`, `a1`, `a2`, `a3`)
						VALUES ('$title', '$cont', '$a1', '$a2', '$a3')";

if (mysqli_query($msq, $ins)) {
   $count++;
} else {
  echo "Ошибка: " . $ins . "<br>" . mysqli_error($msq) . "<br><br>";
}

						}
					}
echo "База оновлена, внесено " . $count . " новых книг";
mysqli_close($msq);
 ?>