<?php
/**
 * Created by PhpStorm.
 * User: riesbyfe
 * Date: 4/7/17
 * Time: 6:57 AM
 */

namespace Calendar;


class View
{

    /**
     * Set the page title
     * @param $title New page title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Create the HTML for the contents of the head tag
     * @return string HTML for the page head
     */
    public function head()
    {
        return <<<HTML
<meta charset="utf-8">
<title>$this->title</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>
      <script src="lib/js/main.js"></script>
    <link href="lib\css\main.css" type="text/css" rel="stylesheet" />
HTML;
    }

    public function header()
    {
        $html = <<<HTML
<nav>
<ul>
<li class="left">
            <img src="images/title.png" width="600" height="104" alt="Title" />
</li>
HTML;

        if (count($this->links) > 0) {
            foreach ($this->links as $link) {
                $html .= '<li><a href="' .
                    $link['href'] . '">' .
                    $link['text'] . '</a></li>';
            }
        }
        $additional = $this->headerAdditional();

        $html .= <<<HTML
</ul></nav>
HTML;
        return $html;
    }


    /**
     * Add a link that will appear on the nav bar
     * @param $href What to link to
     * @param $text
     */
    public function addLink($href, $text) {
        $this->links[] = array("href" => $href, "text" => $text);
    }

    /**
     * Override in derived class to add content to the header.
     * @return string Any additional comment to put in the header
     */
    protected function headerAdditional() {
        return '';
    }

    /**
     * Get any redirect page
     */
    public function getProtectRedirect() {
        return $this->protectRedirect;
    }

    /// Page protection redirect
    private $protectRedirect = null;
    private $title = "";	///< The page title
    private $links = array();	///< Links to add to the nav bar

}