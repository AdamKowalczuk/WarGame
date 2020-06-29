<?php
session_start();

$num1 = isset($_SESSION['num1']) ? $_SESSION['num1'] : 0;
$num2 = isset($_SESSION['num2']) ? $_SESSION['num2'] : 0;

$_SESSION['num1'] = $num1;
$_SESSION['num2'] = $num2;

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="grid-container">
        
        <div class="item2" id="przycisk">
            <form method="post"> 
                <div>
                    <h1>
                        <?php 
                            echo $num1;
                        ?>
                        
                    </h1>
                </div>
                <button onclick="Losuj()" class="myButton">Kolejna bitwa</button>
                <div>
                    <h1>
                        <?php 
                            echo $num2; 
                        ?>
                    </h1>
                </div>
            </form>
        </div>
        <div class="item3">
            <div class="gora">
            <?php
            $connection=@mysql_connect('127.0.0.1:3306','root','')
            or die('zly adres lub login');
            $db=@mysql_select_db('baza',$connection);
            Losuj();
            function Losuj()
            {
                if($_SESSION['num1']==0 && $_SESSION['num2']==0)
                {
                    $sql = "DELETE FROM war";
                    $wynik=mysql_query($sql);
                }
                $licznik=0;
                $karty = array(
                    100000,0,3000,2000,2000,5000,1000,4000,2000,2000,
                    1000,9000,9000,4000,5000,8000,3000,3000,4000,3000,
                    5000,11000,8500,3000,3000,2000,6000,8000,4000,2000,
                    2000,3000,3000,3000,5000,5000,4000,3000,2000,3000,
                    4000,3000,5000,2000,5000,1000,6000,2000,2000,7000,
                );
                $losowa1=rand(0,49);
                $talia1 = $karty[$losowa1];
                $losowa1+=1;
                
                
                
                $losowa2=rand(0,49);
                $talia2 = $karty[$losowa2];
                $losowa2+=1;
                
                if($talia1<$talia2)
                {
                    ++$_SESSION['num2'];
                    echo "<img id='img1' src='cards/photo$losowa1.jpg' height='350px' >";
                    echo "</div>";
                    echo "<div class='dol'>";
                    echo "<img id='img4' src='cards/photo$losowa2.jpg' height='350px' >";
                    
                    $sql="INSERT INTO war(tekst) VALUES('Wygrana')";
                    $wynik=mysql_query($sql);
                    
                }
                elseif($talia1>$talia2)
                {
                    ++$_SESSION['num1'];
                    echo "<img id='img3' src='cards/photo$losowa1.jpg' height='350px' >";
                    echo "</div>";
                    echo "<div class='dol'>";
                    echo "<img id='img1' src='cards/photo$losowa2.jpg' height='350px' >";
                    
                    $sql="INSERT INTO war(tekst) VALUES('Przegrana')";
                    $wynik=mysql_query($sql);
                    
                }
                else
                {
                    echo "<img id='img5' src='cards/photo$losowa1.jpg' height='350px' >";
                    echo "</div>";
                    echo "<div class='dol'>";
                    echo "<img id='img6' src='cards/photo$losowa2.jpg' height='350px' >";
                    
                    $sql="INSERT INTO war(tekst) VALUES('Remis')";
                    $wynik=mysql_query($sql);
                    
                }
            }
            echo '</div>';
        echo '</div>'; 
        echo '<div class="item4"><h2>Historia<br>rozgrywek</h2>';
            
        $sql = "select * from war";
        $wynik = mysql_query($sql); 
        $numer=1; 
            while($linia=mysql_fetch_array($wynik))
            {
                echo '<br/>';
                echo $numer." ".$linia['tekst'];
                $numer++;
            }
        echo '</div>';
    echo '</div>';
    echo '<script>';

       if($_SESSION['num1']>=10)
       {
           ?>
           
           setTimeout(function() 
           {
                Swal.fire({
                title: 'Przegrana!',
                text: 'Jesteś beznadziejny...',
                imageUrl: "wyniki/przegrana"+(Math.floor(Math.random()*5)+1)+".jpg",
                imageWidth: 800,
                imageHeight: 400,
                timer:10000,
                })
            }, 6000);
            $sql = "DELETE FROM war WHERE id=147";
            $wynik=mysql_query($sql);
            <?php 
       }
       elseif($_SESSION['num2']>=10)
       {
        ?>
        setTimeout(function() 
        {
            Swal.fire({
            title: 'Wygrana!',
            text: 'Jesteś mistrzem...',
            imageUrl: "wyniki/wygrana"+(Math.floor(Math.random()*5)+1)+".jpg",
            imageWidth: 800,
            imageHeight: 400,
            timer:10000,
            })
        }, 6000);
        $sql = "DELETE FROM war WHERE id=147";
        $wynik=mysql_query($sql);
        <?php
        
       }
        if($_SESSION['num1']>=10 || $_SESSION['num2']>=10)
        {
            $_SESSION['num1']=0;
            $_SESSION['num2']=0;
        }
       ?>
       window.localStorage.clear();
    </script>
     
</body>
</html>


