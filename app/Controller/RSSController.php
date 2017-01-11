<?php 
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
class RSSController extends AppController {

    public $uses = array(
        'Blog'
        );

    public function makeRSSFile(){;
    //----------------------
    //サイト情報定義
    //----------------------
        $title = "サイトタイトル";
        $url = "サイトURL";
        $description = "サイトの概要";
        $rssFileName = "departRSS.rdf";

    //----------------------
    //記事情報取得
    //----------------------

        $dataList = $this->Blog->find('all');
        $dataList =Set::extract('/Blog/.', $dataList);
        // echo "<pre>";
        // print_r($dataList);
        // echo "</pre>";
    //----------------------
    //XML上半分作成
    //----------------------
        $rssHeader = '<?xml version="1.0" encoding="utf-8" ?>
        <rss version="2.0">
            <channel>
                <title>$title</title>
                <link>$url</link>
                <description>$description</description>
                <language>ja</language>
                ';

    //----------------------
    //XMLの記事部分作成
    //----------------------
                $item = "";
                foreach($dataList as $value){
                    $item .= "<item>\n";
                //title
                    $item .= "<title>" . $value['title'] . "</title>\n";
                //link
                    $item .= "<link>" . 'http://depart-info.com/blog/selectedBlog?id=' . $value['id'] . "</link>\n";
                //description
                //$itemDescription = strip_tags($value['text']);

                    $item .= "<description>" . $value['title'] . "</description>\n";
                //date
                    $itemPubDate = date('D, d M Y H:i:s O', strtotime($value['date']));
                    $item .= "<pubDate>". $itemPubDate . "</pubDate>\n";

                    $item .= "</item>\n";
                }


    //----------------------
    //XML下半分作成
    //----------------------
                $rssFooter = '
            </channel>
        </rss>
        ';
        // echo "<pre>";
        // print_r($rssHeader . $item . $rssFooter);
        // echo "</pre>";
        // exit;
    //----------------------
    //XML出力
    //----------------------
        // echo WWW_ROOT;
        // exit;
        $dir = new Folder(WWW_ROOT . 'files/');
        $file = new File($dir->pwd() . DS . $rssFileName);
        $file->write($rssHeader . $item . $rssFooter);
        $file->close(); 

        // $f = fopen($rssFileName, "wb");
        // fwrite($f, $rssHeader . $item . $rssFooter);
        // fclose($f);
        exit;
    }
}
?>