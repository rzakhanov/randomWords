<?php

require_once __DIR__ . '/../vendor/autoload.php';

$generator = new \RandomWordsGenerator\MakeWords();

try {

    print_r(
        $generator
            #->location('az_AZ')
            ->count(10)
            #->fromLength(3)
            #->toLength(4)
            ->search('shop')
            ->uniqueWords()
            ->generate()
    );

} catch (Exception $e) {
    echo $e->getMessage();
}