<?php

class Ebook extends Livro {

	private $waterMark;

	public function getWaterMark() {
		return $this->waterMark;
	}

	public function setWaterMark($waterMark) {
		$this->waterMark = $waterMark;
	}

}

?>