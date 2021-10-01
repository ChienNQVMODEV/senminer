<?php

namespace App\Console\Commands;

use App\Models\Chapter;
use App\Models\Comic;
use Goutte;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class NetTruyen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:netTruyen';

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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $crawler = Goutte::request('GET', 'http://www.nettruyenvip.com/truyen-con-trai');
        // $linkImages[] = $crawler->filter('div.image a img.lazy')->each(function ($node) {
            // print($node->attr('data-original')."\n");

            // $current = Carbon::now()->timestamp;
            // $first = Str::random(8);["ssdsdsad"];
            // $last = Str::random(8);

            // array_push($linkImages, $result);
            // $linkImages[] = $result;
            // dd($linkImages);

            // $client = new \GuzzleHttp\Client();
            // $res = $client->get($result);
            // $fileContent = (string) $res->getBody();

            // $fileName = 'public/'.$current.'/'.$first.'_'.$last.'.jpg';
            // $storage = Storage::disk('local');
            // $storage->put($fileName, $fileContent);
            // dd($storage->put($fileName, $fileContent));
            // Storage::disk('local')->put('google.html', $contents);

            // return str_replace('//', '', $node->attr('data-original'));
        // });

        $hrefComics = array();
        array_push($hrefComics,$crawler->filter('figcaption h3 a.jtip')->each(function ($node) {
            return $node->attr('href');
        }));
        foreach ($hrefComics[0] as $key => $hrefComic) {
            $comicGoutte = Goutte::request('GET', $hrefComic);
            $nameComic = $comicGoutte->filter('article#item-detail h1.title-detail')->first()->text();

            $authorComic = $comicGoutte->filter('li.author.row p.col-xs-8')->first()->text();
            $statusComic = true;
            $categoryComic = 'N/A';
            $trailerComic = $comicGoutte->filter('article#item-detail div.detail-content p')->first()->text();

            $avatar = str_replace('//', '', $comicGoutte->filter('div.detail-info div.row div.col-xs-4.col-image img')->first()->attr('src'));

            $hrefChapters = array();
            array_push($hrefChapters,$comicGoutte->filter('div.list-chapter nav ul li.row div.col-xs-5.chapter a')->each(function ($node) {
                return $node->attr('href');
            }));

            $dataComic[] = [
                'avatar' => $avatar[0],
                'name' => $nameComic[0],
                'author' => $authorComic[0],
                'status' => $statusComic,
                'category' => $categoryComic,
                'trailer' => $trailerComic[0]
            ];

            $comic = Comic::create($dataComic[0]);
            print $avatar[0]."\n";
            // dd($comic->id);

            // dd(array_reverse($hrefChapters[0]));
            // foreach (array_reverse($hrefChapters[0]) as $key => $hrefChapter) {
            //     $chapter = Goutte::request('GET', $hrefChapter);
            //     $chapterName = $chapter->filter('div.top h1.txt-primary span')->each(function ($node) {
            //         return $node->text();
            //     });

            //     $chapterImages = array();
            //     array_push($chapterImages, $chapter->filter('div.reading-detail.box_doc div.page-chapter img')->each(function ($node) {
            //         return str_replace('//', '', $node->attr('data-original'));
            //     }));
            //     // dd(json_encode($chapterImages[0]));

            //     $dataChapter[] = [
            //         'comic_id' => $comic->id,
            //         'order' => $key + 1,
            //         'content' => json_encode($chapterImages[0])
            //     ];

            //     Chapter::create($dataChapter[0]);
            // }
        }
    }
}
