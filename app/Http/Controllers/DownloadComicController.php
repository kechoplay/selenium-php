<?php

namespace App\Http\Controllers;

use App\Comic;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Sunra\PhpSimple\HtmlDomParser;

class DownloadComicController extends Controller
{
    //
    public function getListCollect(Request $request)
    {
        $link = $request->link;

        $html = file_get_contents($link);
        $domHtml = HtmlDomParser::str_get_html($html);
        $collect = $domHtml->find('span[class=chapter-name]');
        $parentName = $domHtml->find('div[id=infor-box]');
        $comicName = $parentName[0]->childNodes()[1]->firstChild()->text();
        $totalEpisodes = 0;
        $listChapters = [];
        foreach ($collect as $item) {
            $totalEpisodes++;
            $listChapters[] = [
                'chapter_name' => $item->find('a')[0]->text(),
                'chapter_link' => $item->find('a')[0]->href
            ];
        }

        $data = [
            'name' => $comicName,
            'original_link' => $link,
            'slug_name' => Str::slug($comicName),
            'total_episodes' => $totalEpisodes
        ];
        Comic::insertOrUpdated($data);

        return view('list_chapter', compact('listChapters', 'comicName'));
    }

    public function downloadChap(Request $request)
    {
        $linkDownload = $request->linkDownload;
        $chapterName = $request->chapterName;

        foreach ($linkDownload as $link) {

            $html = file_get_contents($link);
            $domHtml = HtmlDomParser::str_get_html($html);
            $imageList = $domHtml->find("div#viewer img");
            echo($domHtml);die;
        }
//        Image::
        dd($chapterName);
    }
}
