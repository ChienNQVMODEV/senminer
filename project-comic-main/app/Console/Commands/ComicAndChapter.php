<?php

namespace App\Console\Commands;

use App\Models\Chapter;
use App\Models\Comic;
use Goutte;
use DB;
use Illuminate\Console\Command;

class ComicAndChapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:comic_and_chapter';

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
        Comic::chunk(10, function ($comics) {
            foreach ($comics as $comic) {
                $comicGoutte = Goutte::request('GET', $comic->comic_link);

                // $comic = Comic::where('id_check', strrev(explode("-", strrev($linkDetailComic))[0]))->limit(1)->first();

                $nameComic = $comicGoutte->filter('article#item-detail h1.title-detail')->first()->text();
                $authorComic = $comicGoutte->filter('li.author.row p.col-xs-8')->first()->text();
                $statusComic = true;
                $categoryComic = 'N/A';
                $trailerComic = $comicGoutte->filter('article#item-detail div.detail-content p')->first()->text();
                $avatar = str_replace('//', '', $comicGoutte->filter('div.detail-info div.row div.col-xs-4.col-image img')->first()->attr('src'));

                $chapterCount = count($comicGoutte->filter('div.list-chapter nav ul li.row div.col-xs-5.chapter a')->each(function ($node) {
                    return $node->attr('href');
                }));

                if ($comic) {
                    $comic->update([
                        'avatar' => $avatar,
                        'name' => $nameComic,
                        'author' => $authorComic,
                        'status' => $statusComic,
                        'category' => $categoryComic,
                        'trailer' => $trailerComic
                    ]);
                }
                $comic->load(['chapters']);

                $comicId = $comic->id;

                $currentChapterCount = $comic->chapters->count();

                if (($chapterCount - $comic->chapters->count()) > 0) {
                    $hrefChapters = $comicGoutte->filter('div.list-chapter nav ul li.row div.col-xs-5.chapter a')->each(function ($node) {
                        return $node->attr('href');
                    });
                    foreach (array_reverse($hrefChapters) as $key => $hrefChapter) {
                        if ($key >= ($chapterCount - $currentChapterCount)) {
                            break;
                        }
                        $chapter = Goutte::request('GET', $hrefChapter);
                        $chapterImages = $chapter->filter('div.reading-detail.box_doc div.page-chapter img')->each(function ($node) {
                                    return str_replace('//', '', $node->attr('data-original'));
                                });
                        Chapter::create([
                            'comic_id' => $comicId,
                            'order' => $currentChapterCount + $key,
                            'content' => json_encode($chapterImages)
                        ]);
                    }
                }
            
                $comic->chapter_count = $chapterCount;
                $comic->save();
            }
        });
        print "OK";
    }
}
