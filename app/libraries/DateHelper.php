<?php

class DateHelper{

	static function DanishDateTimeFormat($dato){
	    $timestamp = strtotime($dato);

        return date('d/m-Y H:i:s', $timestamp);

	}
}