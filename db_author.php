<?php

$aths = 0;

$jsonAuthor = file_get_contents("http://randomuser.me/api/?results=20&inc=name,location,email&noinfo");
$author = json_decode($jsonAuthor);

$msq = mysqli_connect('localhost', 'host1697434', '**********', '***************' );


if ( mysqli_connect_errno() ) {
    printf("Не удалось подключиться к базе авторства: %s\n", mysqli_connect_error());
    exit();
}
else {
    printf("База авторства подключена: %s\n", mysqli_get_host_info($msq) . "<br><br>");
}

$msq->query ("DROP TABLE IF EXISTS author");

$creat = "CREATE TABLE `author` ( `id` INT NOT NULL AUTO_INCREMENT , 
									`title` VARCHAR(10) NOT NULL ,
									`first name` VARCHAR(50) NOT NULL , 
									`second name` VARCHAR(50) NOT NULL , 
									`city` VARCHAR(50) NOT NULL , 
									`email` VARCHAR(70) NOT NULL , 
									PRIMARY KEY (`id`)) 
									ENGINE = InnoDB";


if ($msq->query($creat) === TRUE) {
   echo "Таблица author создана успешно <br><br>";
} else {
   echo "Ошибка создания таблицы author: " . $msq->error . "<br><br>";
}

for ($x=0; $x<20; $x++) {
	$title = ($author-> results[$x]->name->title);
	$f_name = ($author-> results[$x]->name->first);
	$S_name = ($author-> results[$x]->name->last);
	$city = ($author-> results[$x]->location->city);
	$email = ($author-> results[$x]->email);
						

$ins = "INSERT INTO `author` (`title`, `first name`, `second name`, `city`, `email`)
						VALUES ('$title', '$f_name', '$S_name', '$city', '$email')";

if (mysqli_query($msq, $ins)) {
   $aths++;
			}
 else {
  echo "Ошибка: " . $ins . "<br>" . mysqli_error($msq) . "<br><br>";
}
						}
echo "База оновлена, внесено " . $aths . " новых авторов";

mysqli_close($msq);
?>