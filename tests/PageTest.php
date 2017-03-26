<?php

use Lesstif\Confluence\Page\Page;
use \Lesstif\Confluence\Page\PageService;

class PageTest extends PHPUnit_Framework_TestCase
{
    public function testGetPage()
    {
        global $argv, $argc;

        $pageId = '59444134';

        // override command line parameter
        if ($argc > 2) {
            $pageId = $argv[2];
        }

        try {
            $ps = new PageService();

            $p = $ps->getPage($pageId);

            //$this->assertClassNotHasAttribute('id', $p);

        } catch (\Lesstif\Confluence\ConfluenceException $e) {
            $this->assertTrue(false, 'testGetSpace Failed : '.$e->getMessage());
        }

        return $pageId;
    }

    /**
     * @depends testGetPage
     */
    public function testGetChildPage($pageId)
    {
        try {
            $ps = new PageService();

            $p = $ps->getChild($pageId);

            //print attachments
            $i = 0;
            foreach($p->attachments as $a) {
                if ($i++ > 3)
                    break;

                dump($a);
                $ret = $ps->deletePage($a->id);
                dump($ret);
                break;
            }

        } catch (\Lesstif\Confluence\ConfluenceException $e) {
            $this->assertTrue(false, 'testGetSpace Failed : '.$e->getMessage());
        }

        return $pageId;
    }

}
