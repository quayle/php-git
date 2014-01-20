<?php

class Pool
{
    public static $pool = array();
}

$a = array(
    "read" => function($oid){
        echo "\e[32m# read $oid\e[m\n";
        return array(
            Pool::$pool[$oid][0],
            Pool::$pool[$oid][1],
        );
    },
    "read_prefix" => function($short_oid){
            echo "Helo World";
            return array(
                "Buffer",
                "type",
                "actual_oid",
            );
    },
    "read_header" => function($oid) {
            echo "\e[32m# read header$oid\e[m\n";
            return array(
                strlen(Pool::$pool[$oid][0]),
                Pool::$pool[$oid][1],
            );
    },
    "write" => function($oid, $buffer, $otype) {
            echo "\e[32m# write $oid\e[m\n";
            Pool::$pool[$oid] = array($buffer, $otype);
    },
    "writestream" => function() {

    },
    "readstream" => function() {

    },
    "exists" => function($oid) {
            $retval = 0;
            if (isset(Pool::$pool[$oid])) {
                $retval = 1;
            }

            echo "\e[32m# exists $retval\e[m\n";

            return $retval;
    },
    "refresh" => function() {

    },
    "foreach" => function() {

    },
    "writepack" => function() {

    },
    "free" => function() {
    }
);
$memory_backend = git_odb_backend_new($a);

$repo = git_repository_open(".");
$odb = git_repository_odb($repo);
git_odb_add_backend($odb, $memory_backend, 1000);

$oid = git_odb_write($odb, "Helo World(php memory backend)", GIT_OBJ_BLOB);
$obj = git_odb_read($odb, $oid);

echo git_odb_object_data($obj);
echo "\n";

$header = git_odb_read_header($odb, $oid);
var_dump($header); // size, otype
exit;
