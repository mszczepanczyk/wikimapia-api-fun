<?php
require 'settings.php';

function create_tables() {
    global $dbfile;
    $db = sqlite_open($dbfile);
    sqlite_query($db, 'drop table objects;');
    sqlite_query($db, 'drop table tags;');
    sqlite_query($db, 'drop table objects_tags;');
    sqlite_query($db, 'create table objects (
        id integer primary key,
        place varchar(100));');
    sqlite_query($db, 'create table tags (
        id integer primary key,
        title varchar(100));');
    sqlite_query($db, 'create table objects_tags (
        objects_id integer references objects,
        tags_id integer references tags);');
    sqlite_close($db);
}

function update_db($json) {
    $arr = json_decode($json, true);

    global $dbfile;
    $db = sqlite_open($dbfile);
    $id = $arr["id"];
    $place = $arr["location"]["place"];    
    sqlite_query($db, "insert into objects (id, place) values ('$id', '$place');");
    if (isset($arr["tags"]))
        foreach ($arr["tags"] as $tag) {
            $tag_id = $tag["id"];
            $tag_title = $tag["title"];

            $res = sqlite_array_query($db, "select id from tags where id = '$tag_id'");
            if (empty($res))
                sqlite_query($db, "insert into tags (id, title) values ('$tag_id', '$tag_title');");
            sqlite_query($db, "insert into objects_tags (objects_id, tags_id) values ('$id', '$tag_id');");
        }
    sqlite_close($db);
}

function init_db() {
    create_tables();
    if ($dirhandle = opendir('objects/')) {
        while (false !== ($filename = readdir($dirhandle))) 
            if (strlen($filename) > 4) {
                //print substr($filename, 0, strlen($filename) - 5) . "\n";
                $id = substr($filename, 0, strlen($filename) - 5);

                $json = "";
                $handle = fopen("objects/$filename", "r");
                while(!feof($handle)) {
                    $json = $json . fgets($handle, 4096);
                }
                fclose ($handle);
                update_db($json);
            }
    }
}

function load_json($id) {
    global $dbfile;
    $db = sqlite_open($dbfile);
    $arr = sqlite_array_query($db, "select json from objects where id = '$id'");
    sqlite_close($db);
    if (empty($arr))
        return null;
    else
        return $arr[0]['json'];
}

function save_json($json) {
    global $dbfile;
    $db = sqlite_open($dbfile);
    $arr = json_decode($json, true);
    $id = sqlite_escape_string($arr['id']);
    $json = sqlite_escape_string($json);
    sqlite_query($db, "insert into objects (id, json) values ('$id', '$json');");
    sqlite_close($db);
}

?>
