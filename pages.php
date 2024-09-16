<?php
//nadefinujeme tridu a pole se strankami(pages)
class Page
{
	//zde napiseme vlastnosti tridy Page
	public $id;
	public $title;
	public $menu;

	function __construct($id, $title, $menu)
	{
		$this->id = $id;
		$this->title = $title;
		$this->menu = $menu;
	}

	//pridani nove funkci
	//pouziti v pripadech:
	//1)
	//automaticke vyplneni obsahu v "admin.php", konkrétně v editacnim formulari->textarea
	function getContent()
	{
		return file_get_contents("$this->id.html");
	}

	function setContent($content)
	{
		file_put_contents("$this->id.html", $content);
	}
}

//nadefinovani konkretni instance (stranky)
//diky foreach ($pageList as $pageId => $pageInstant) {echo "<li><a href='?page=$pageInstant->id'>$pageInstant->menu</a></li>";}
//v zalozce index.php tady muzeme jednoduse pridavat new Page a automaticky se objevi jako nova zalozka i na webu
//timpadem uz nemusime mit napsany seznam stranek v html (
/*	
				<ul>
  					<li><a href="?page=home">H O M E</a></li>
					<li><a href="?page=live">L I V E</a></li>
					<li><a href="?page=gallery">G A L L E R Y</a></li>
					<li><a href="?page=contact">C O N T A C T</a></li>
				</ul>)*/
$pageList = [
	"home" => new Page("home", "The_Darkades", "H O M E"),
	"live" => new Page("live", "The_Darkades - Live", "L I V E"),
	"gallery" => new Page("gallery", "The_Darkades - Gallery", "G A L L E R Y"),
	"contact" => new Page("contact", "The_Darkades - Contact", "C O N T A C T"),
	"video_page" => new Page("video_page", "The_Darkades - Video", "V I D E O"),
	"404" => new Page("404", "Error/Hacking too much time", ""),
	"arcade" => new Page("arcade", "The_Darkades - Arcade", ""),
	"leftplayer" => new Page("leftplayer", "The_Darkades - Left_Player_Wins!", ""),
	"rightplayer" => new Page("rightplayer", "The_Darkades - Right_Player_Wins!", ""),
];
