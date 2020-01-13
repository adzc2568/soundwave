<?php 
  try {
	require_once("connectBooks.php");
    $sql = "Insert into `total_station_music_library`(`song_no`,`song_name`,`song_date`,`song_idn`,`song_pic`,
            `mem_no`,`donate_acount`,`cat_no`,`fav_total`,`song_addr`)
            values(`song_no`=:song_no,`song_name`=:song_name,`song_date`=:song_date,`song_idn`=:song_idn,`song_pic`=:song_pic,
            `mem_no`=:mem_no,`donate_acount`=:donate_acount,`cat_no`=:cat_no,`fav_total`=:fav_total,`song_addr`=:song_addr)";
    $songsadd = $pdo -> prepare($sql);
    $songsadd->bindValue('song_name',$_GET['song_name']);
    $songsadd->bindValue('song_no',11);
    $songsadd->bindValue('song_date','2020-01-12');
    $songsadd->bindValue('song_idn',$_GET['song_idn']);
    $songsadd->bindValue('song_pic',$_GET['song_pic']);
    $songsadd->bindValue('mem_no',1);
    $songsadd->bindValue('donate_acount',0);
    $songsadd->bindValue('cat_no',3);
    $songsadd->bindValue('fav_total',0);
    $songsadd->bindValue('song_addr',$_GET['song_addr']);
    $songsadd->execute();
    if( $songsadd->rowCount() != 0){
        $addRow = $songsadd->fetch(PDO::FETCH_ASSOC);
        // $songpic=$_POST["song_pic"];
        // $songpic=$_GET["song_name"];
        echo "Successly";
    }else{
        echo "Failure";
    }
  } catch (PDOException $e) {
	echo "例外行號 : ", $e->getLine(),"<br>";
	echo "例外原因 : ", $e->getMessage(),"<br>";		
  }
  ?> 