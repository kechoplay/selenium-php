<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Comic;
use App\ImageComic;
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
        $comic = Comic::insertOrUpdated($data);

        return view('list_chapter', compact('listChapters', 'comicName', 'comic'));
    }

    public function downloadChap(Request $request)
    {
        $linkDownload = $request->linkDownload;
        $chapterName = $request->chapterName;
        $comicId = $request->comic_id;

        foreach ($linkDownload as $key => $link) {
            $episode = substr($chapterName[$key], strrpos($chapterName[$key], ' ') + 1);
            $chapter = Chapter::create([
                'comic_id' => $comicId,
                'chapter_name' => $chapterName[$key],
                'episode' => (int)$episode,
                'original_link' => $link
            ]);
            $html = file_get_contents($link);
            $domHtml = HtmlDomParser::str_get_html($html);
            $scripts = $domHtml->find("script");
            foreach ($scripts as $script) {
                $pattern = '/var slides_page_url_path = \["(.*)"\];/';
                preg_match($pattern, $script->innertext(), $matches);
                if (!isset($matches[1]))
                    continue;
                $url_path = str_replace("\"", "", $matches[1]);
                $urlArray = explode(",", $url_path);
                foreach ($urlArray as $url) {
                    ImageComic::create([
                        'comic_id' => $comicId,
                        'chapter_id' => $chapter->id,
                        'image_path' => $url
                    ]);
                }
            }
        }

        return response()->json([], 200);
    }
}
