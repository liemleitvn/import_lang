<?php
//
//namespace App\Console\Commands;
//
//use Illuminate\Console\Command;
//use Excel;
//
//class Import extends Command
//{
//    /**
//     * The name and signature of the console command.
//     *
//     * @var string
//     */
//
////      php artisan import:import ja
////      php artisan import:import en
//
//    protected $signature = 'import:import {lang_code}';
//
//    /**
//     * The console command description.
//     *
//     * @var string
//     */
//    protected $description = 'Command description';
//
//    /**
//     * Create a new command instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        parent::__construct();
//    }
//
//    protected $dir = "./pos/";
//    /**
//     * Execute the console command.
//     *
//     * @return mixed
//     */
//    public function handle()
//    {
//        $lang_code = 'en';
//        if (!empty($this->argument('lang_code'))) {
//            $lang_code = $this->argument('lang_code');
//        }
//
//        foreach (glob("./pos/*.po") as $del) {
//            unlink($del);
//        }
//
//        $results = Excel::selectSheetsByIndex(0)
//            ->load('./localization.xlsx', function ($reader) {
//            })->ignoreEmpty()->all()->toArray();
//
//        $validates = Excel::selectSheetsByIndex(1)
//            ->load('./localization.xlsx', function ($reader) {
//            })->ignoreEmpty()->all()->toArray();
//
//        $merged = array_merge($results, $validates);
//        $collection = collect($merged);
//
//        $unique = $collection->unique(1);
//        $unique->values()->all();
////        msgid ""
////msgstr "Project-Id-Version: tygh"
////"Content-Type: text/plain; charset=UTF-8\n"
////"Language-Team: English\n"
////"Language: en_US"
//
//        foreach ($unique as $item) {
//            $header = 'msgid ""'."\n";
//            if ($lang_code == 'ja') {
//                $header .= 'msgstr "Project-Id-Version: cs-cart-latest\n"'."\n";
//                $header .= '"Language-Team: Japanese\n"'."\n";
//                $header .= '"Language: ja_JP"'."\n";
//            } else {
//                $header .= 'msgstr "Project-Id-Version: tygh"'."\n";
//                $header .= '"Content-Type: text/plain; charset=UTF-8\n"'."\n";
//                $header .= '"Language-Team: English\n"'."\n";
//                $header .= '"Language: en_US"'."\n";
//            }
//            $header .= "\n";
//            $header .= 'msgctxt "Addons::name::'.$item[1].'"'."\n";
//            $header .= 'msgid "'.ucfirst(str_replace('_', ' ', $item[1])).'"'."\n";
//            $header .= 'msgstr "'.ucfirst(str_replace('_', ' ', $item[1])).'"'."\n";
//            if(!empty($item[1])){
//                $file = $this->dir.$item[1].'.po';
//                file_put_contents($file, $header.PHP_EOL, FILE_APPEND | LOCK_EX);
//            }
//        }
//        self::putContents($results, $lang_code);
//        self::putContents($validates, $lang_code);
//    }
//
//    public function putContents($results, $lang_code)
//    {
//        foreach ($results as $result) {
//            if (!empty($result[1])) {
//                $msgctxt = 'msgctxt "Languages::description::';
//                $msgid = 'msgid "';
//                $msgstr = 'msgstr "';
//                $file = $this->dir.$result[1].'.po';
//                // Open the file to get existing content
//                // Append a new person to the file
//                $current = $msgctxt.$result[3].'"'."\n";
//                $txt = $result[3];
//                if ($lang_code == 'ja') {
//                    if (!empty($result[5])) {
//                        $txt = $result[5];
//                    }
//                    $current .= $msgid.$txt.'"'."\n";
//                    $current .= $msgstr.$txt.'"'."\n";
//                } else {
//                    if (!empty($result[4])) {
//                        $txt = $result[4];
//                    }
//                    $current .= $msgid.$txt.'"'."\n";
//                    $current .= $msgstr.$txt.'"'."\n";
//                }
//
//                // Write the contents back to the file
//                file_put_contents($file, $current.PHP_EOL, FILE_APPEND | LOCK_EX);
//            }
//        }
//    }
//}

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Excel;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//      docker-compose up -d
//      docker exec -it language_scrap bash
//      php artisan import:import ja
//      php artisan import:import en
//      php artisan import:import zh
//      php artisan import:import tw

//  /Applications/XAMPP/bin/php artisan import:import ja
//  /Applications/XAMPP/bin/php artisan import:import en

    protected $signature = 'import:import {lang_code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected $dir = "./pos/";
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lang_code = 'en';
        if (!empty($this->argument('lang_code'))) {
            $lang_code = $this->argument('lang_code');
        }

        // foreach (glob("./pos/*.po") as $del) {
        //     unlink($del);
        // }

        $results = Excel::selectSheetsByIndex(0)
            ->load('./localization.xlsx', function ($reader) {
            })->ignoreEmpty()->all()->toArray();

        $validates = Excel::selectSheetsByIndex(1)
            ->load('./localization.xlsx', function ($reader) {
            })->ignoreEmpty()->all()->toArray();

        $merged = array_merge($results, $validates);
        $collection = collect($merged);

        $unique = $collection->unique(1);
        $unique->values()->all();

        $file_all = $this->dir.'all_'.$lang_code.'.po';

        $init_header = 'msgid ""'."\n";

        if ($lang_code == 'ja') {
            $init_header .= 'msgstr "Project-Id-Version: cs-cart-latest\n"' . "\n";
            $init_header .= '"Language-Team: Japanese\n"' . "\n";
            $init_header .= '"Language: ja_JP"' . "\n";
        } elseif ($lang_code == 'zh') {
            $init_header .= 'msgstr "Project-Id-Version: cs-cart-latest\n"' . "\n";
            $init_header .= '"Language-Team: China\n"' . "\n";
            $init_header .= '"Language: zh_CN"' . "\n";
        } elseif ($lang_code == 'tw') {
            $init_header .= 'msgstr "Project-Id-Version: cs-cart-latest\n"' . "\n";
            $init_header .= '"Language-Team: Taiwan\n"' . "\n";
            $init_header .= '"Language: tw_TW"' . "\n";
        } else {
            $init_header .= 'msgstr "Project-Id-Version: tygh"' . "\n";
            $init_header .= '"Content-Type: text/plain; charset=UTF-8\n"' . "\n";
            $init_header .= '"Language-Team: English\n"' . "\n";
            $init_header .= '"Language: en_US"' . "\n";
        }

        $all_header = $init_header;

        file_put_contents($file_all, $all_header.PHP_EOL, FILE_APPEND | LOCK_EX);

        foreach ($unique as $item) {
            $header = $init_header;

            $header .= "\n";
            $header .= 'msgctxt "Addons::name::'.$item[1].'"'."\n";
            $header .= 'msgid "'.ucfirst(str_replace('_', ' ', $item[1])).'"'."\n";
            $header .= 'msgstr "'.ucfirst(str_replace('_', ' ', $item[1])).'"'."\n";
            
            // if(!empty($item[1])){
            //     $file = $this->dir.$item[1].'.po';
            //     file_put_contents($file, $header.PHP_EOL, FILE_APPEND | LOCK_EX);
            // }
        }

        self::putContents($results, $lang_code,$file_all);
        self::putContents($validates, $lang_code,$file_all);
    }

    public function putContents($results, $lang_code,$file_all)
    {
        foreach ($results as $result) {
            if (!empty($result[1])) {
                $msgctxt = 'msgctxt "Languages::description::';
                $msgid = 'msgid "';
                $msgstr = 'msgstr "';
                $file = $this->dir.$result[1].'.po';
                // Open the file to get existing content
                // Append a new person to the file
                $current = $msgctxt.$result[3].'"'."\n";
                $txt = $result[3];

                if ($lang_code == 'ja') {
                    if (!empty($result[5])) {
                        $txt = str_replace(PHP_EOL, '', $result[5]);
                    }
                    $current .= $msgid.$txt.'"'."\n";
                    $current .= $msgstr.$txt.'"'."\n";
                } elseif ($lang_code == 'en') {
                    if (!empty($result[4])) {
                        $txt = str_replace(PHP_EOL, '', $result[4]);
                    }

                    $current .= $msgid.$txt.'"'."\n";
                    $current .= $msgstr.$txt.'"'."\n";
                }elseif ($lang_code == 'zh') {
                    if (!empty($result[6])) {
                        $txt = str_replace(PHP_EOL, '', $result[6]);
                    }
                    $current .= $msgid.$txt.'"'."\n";
                    $current .= $msgstr.$txt.'"'."\n";
                }elseif ($lang_code == 'tw') {
                    if (!empty($result[7])) {
                        $txt = str_replace(PHP_EOL, '', $result[7]);;
                    }
                    $current .= $msgid.$txt.'"'."\n";
                    $current .= $msgstr.$txt.'"'."\n";
                }

                // Write the contents back to the file
                file_put_contents($file_all, $current.PHP_EOL, FILE_APPEND | LOCK_EX);
                //file_put_contents($file, $current.PHP_EOL, FILE_APPEND | LOCK_EX);
            }
        }
    }
}

