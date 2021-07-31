<?php
if($_GET["type"] === "new" || $_GET["type"] === "get"){
    if($_GET["type"] === "get"){
        if(!empty($_GET["id"])){
            $res = json_decode(file_get_contents("data/chat/".str_replace("/", "", $_GET["id"]).".json"), true);
            echo json_encode([
                "code" => "200",
                "board_name" => $res["name"],
                "create_time" => $res["time"],
                "data" => array_reverse($res["data"])
            ]);
        }else{
            echo json_encode(["code" => "400", "line" => "13"]);
        }
    }elseif($_GET["type"] === "new"){
        if(!empty($_GET["name"]) && !empty($_GET["text"]) && !empty($_GET["id"])){
            $ID = str_replace("/", "", $_GET["id"]);
            if(file_exists("data/chat/{$ID}.json")){
                $list = json_decode(file_get_contents("data/chat/{$ID}.json"), true);
                $list["data"][] = ["time" => date("Y/m/d H:i:s"), "post_id" => count($list["data"]), "name" => $_GET["name"], "text" => $_GET["text"], "ip" => $_SERVER["REMOTE_ADDR"]];
                $fh = fopen("data/chat/{$ID}.json", "w"); 
                @fwrite($fh, json_encode($list));
                fclose($fh);
                echo json_encode(["code" => "200"]);
            }else{
                echo json_encode(["code" => "400", "line" => "26"]);
            }
        }else{
            echo json_encode(["code" => "400", "line" => "29"]);
        }
    }else{
        echo json_encode(["code" => "400", "line" => "32"]);
    }
}else{
    echo json_encode(["code" => "400"]);
}
