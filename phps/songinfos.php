<?php
require_once('./connectBooks.php');
session_start();
switch ($_GET['get']) {
  case 'song':
    try {
    $sql = "SELECT music.song_no,song_idn,song_name,song_pic,donate_acount,fav_total,song_addr, mem.mem_name FROM `total_station_music_library` as music, `member` as mem where music.mem_no = mem.mem_no and song_no = {$_REQUEST['song_no']}";
      $song = $pdo->prepare($sql);
      $song->execute();

      $songs = $song->fetch(PDO::FETCH_ASSOC);
      echo json_encode($songs);
    } catch (PDOException $th) {
      echo $th->getMessage(), "<br>";
    }

    break;
  case 'message':
    try {
      $sql = "select message_board.message_no,`member`.mem_name,message_board.mem_no,
        message_board.song_no,message_board.message_info,report.re_no,report.re_sta,message_board.message_time
        from `message_board` left join `report` on (message_board.message_no = report.message_no) 
        left join `member` on (message_board.mem_no = `member`.mem_no)
        where message_board.song_no = {$_GET['song_no']} ORDER BY message_board.message_time desc;
        ";
      $message = $pdo->prepare($sql);
      $message->execute();

      $messages = $message->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($messages);
    } catch (PDOException $th) {
      echo $th->getMessage(), "<br>";
    }

    break;
  case "post_message":
    try {
      $sql = "INSERT INTO `message_board` (`message_no`, `mem_no`, `song_no`, `message_info`) 
        VALUE (NULL,{$_SESSION['mem_no']},:song_no,:message_info)";
      $message = $pdo->prepare($sql);
      $message->bindValue(':song_no', $_GET['song_no']);
      $message->bindValue(':message_info', "{$_GET['text']}");
      $message->execute();



      echo 'ιεΊζε';
    } catch (PDOException $th) {
      echo $th->getMessage(), "<br>";
    }
    break;
  case "mem":
    try {
      $sql = "SELECT mem_no, mem_name FROM `member` WHERE mem_no = {$_SESSION['mem_no']}";
      $mem = $pdo->prepare($sql);
      $mem->execute();

      $mems = $mem->fetch(PDO::FETCH_ASSOC);
      echo json_encode($mems);
      // echo $mem;
    } catch (PDOException $th) {
      echo $th->getMessage(), "<br>";
    }
    break;
  case "report_mess":
    try {
      $sql = "SELECT message_no FROM `report`";
      $check = $pdo->prepare($sql);
      $check->execute();
      $checks = $check->fetchAll(PDO::FETCH_NUM);
      $isset = FALSE;
      // print_r($check);
      // echo json_encode($checks);

      // εε€ζ·ζ―ε¦ζθ’«θ¨»ει
      for ($i = 0; $i < count($checks); $i++) {
        if ($checks[$i][0] == $_GET['message_no']) {
          $isset = TRUE;
          break;
        }
      };
      // ε¦ζζ²ζηθ©±ε°±ζ°ε’θ³ζ
      if (!$isset) {
        $sql = "INSERT INTO `report` (re_no,message_no,	mem_no,re_sta) VALUE 
        (NULL,{$_GET['message_no']},{$_SESSION['mem_no']},0)";
        $report = $pdo->prepare($sql);
        $report->execute();
      }
      
      echo 'ζͺ’θζε';
    } catch (PDOException $th) {
      echo $th->getMessage(), "<br>";
    }
    break;
}
