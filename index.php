<?php


	$question = '';
	$msg="!سوال خود را بپرسید";
	$ans=fopen("messages.txt","r");
    $cntrl=0;
    $cntrl2=0;
	$answer=array();
    $esm=array();
	while(!feof($ans))
    {
		$answer[$cntrl]=fgets($ans);
		$cntrl+=1;
	}
	$bozorgan=json_decode(file_get_contents('people.json'));																							
   foreach ($bozorgan as $kilid => $meghdar) 
    {
		$cntrl2+=1;
		$esm[$cntrl2]=$kilid;
    }
	if($_SERVER["REQUEST_METHOD"]=="POST") 
    {
		$en_name =$_POST["person"];
		$question=$_POST["question"];
		$msg=$answer[hexdec(hash('crc32b',$en_name." ".$question))%16];
	}
	
	else if($_SERVER["REQUEST_METHOD"]!="POST")
    {
		$en_name=$esm[array_rand($esm)];
	}
	foreach ($bozorgan as $kilid => $meghdar)
     {
		if($kilid==$en_name)
         {
			$fa_name=$meghdar;
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>


<body>
    <p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
    <div id="wrapper">
        <div id="title">
            <span id="label">
                <?php
			if($question!="")
				{
                    echo "پرسش:";
                    }
                    ?>
                    </span>
            <span id="question"><?php echo $question ?></span>
        </div>
		<div id="container">
            <div id="message">
                <p>
                    <?php
                    if($question!="")
                     {
                        echo $msg;
                    }
					else if($question=="")
                    {
						echo "سوال خود را بپرسید!";
					}
                    ?>
                    </p>
            </div>
            <div id="person">
                <div id="person">
                    <img src="images/people/<?php echo "$en_name.jpg" ?>" />
                    <p id="person-name"><?php echo $fa_name ?></p>
                </div>
            </div>
        </div>
        <div id="new-q">
            <form method="post">
                سوال
                <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..." />
                را از
                <select name="person" value="<?php echo $fa_name ?>" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <?php
                    foreach($bozorgan as $kilid => $meghdar){
                        if($en_name==$key)
                        {
							echo "<option value=$kilid selected> $meghdar
                            </option> ";
                        }
						else if($en_name!=$kilid)
                        {
                            echo "<option value=$kilid > $meghdar
                            </option> ";
                        }
                    }
                    ?>
                </select>
                <input type="submit" value="بپرسید" />
            </form>
        </div>
    </div>
</body>

</html>