<?php
if($_GET["type"] === "new" || $_GET["type"] === "get"){
    if($_GET["type"] === "get"){
        $list = json_decode(file_get_contents("data/board_list.json"), true);
        echo json_encode([
            "code" => "200",
            "num" => count($list),
            "data" => $list
        ]);
    }elseif($_GET["type"] === "new"){
        if(!empty($_GET["name"])){
            $list = json_decode(file_get_contents("data/board_list.json"), true);
            $hex = bin2hex(openssl_random_pseudo_bytes(16));
            $list[] = ["name" => $_GET["name"], "id" => $hex, "ip" => $_SERVER["REMOTE_ADDR"]];
            $fh = fopen("data/board_list.json", "w"); 
            @fwrite($fh, json_encode($list));
            fclose($fh);
            $time = date("Y/m/d H:i:s");
            file_put_contents("data/chat/{$hex}.json", json_encode([
                "name" => $_GET["name"],
                "time" => $time,
                "data" => [
                    ["time" => $time, "post_id" => "0", "name" => "[System]", "text" => "Created new board.", "ip" => "::1"]
                ]
            ]));
            echo json_encode(["code" => "200", "id" => $hex]);
        }else{
            echo json_encode(["code" => "400", "line" => "27"]);
        }
    }
}else{
    echo json_encode(["code" => "400", "line" => "31"]);
}
