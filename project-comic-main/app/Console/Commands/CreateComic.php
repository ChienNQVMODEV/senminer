<?php

namespace App\Console\Commands;

use App\Models\Comic;
use Goutte;
use Illuminate\Console\Command;

class CreateComic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:comic';

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
        $crawler = Goutte::request('GET', 'http://www.nettruyenvip.com/');
        $crawler->filter('figcaption h3 a.jtip')->each(function ($node) {
            $linkComic = $node->attr('href');
            Comic::updateOrCreate([
                'id_check' => strrev(explode("-", strrev($node->attr('href')))[0])
            ],[
                'comic_link' => $linkComic
            ]);
        });
        print "OK";
    }
}
