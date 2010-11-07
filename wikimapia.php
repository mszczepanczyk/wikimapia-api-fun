<?
require 'db.php';
require 'settings.php';

function get_json($id) {
    $filename = "objects/$id.json";
    if (file_exists($filename)) {
        $json = "";
        $handle = fopen($filename, "r");
        while(!feof($handle)) {
            $json = $json . fgets($handle, 4096);
        }
        fclose ($handle);
    }
    else {
        global $key;
        $json = file_get_contents("http://api.wikimapia.org/?function=object&key=$key&id=$id&format=json");
        $arr = json_decode($json, true);
        if (isset($arr["id"]) && ($handle = fopen($filename, 'w'))) {
            fwrite($handle, $json);
            fclose($handle);
            update_db($json);
        }
    }
    return $json;
}

function get_some_jsons() {
    for ($i = 0; $i < 50; $i++) {
        $id = rand(1, 100000);
        get_json($id);
        print $id . "\n";
        sleep(1);
    }
}

function get_object($id) {
    return json_decode(get_json($id), true);
}

?>
