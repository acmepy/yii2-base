<?php

namespace acmepy\base\helpers;

class TelefonoHelper{
    public static function numero($num, $ret = 0){
		$cel = $num;
		$cel = str_replace(['(', ')'], '', $cel);
		$cel = str_replace([';'], '|', $cel);
		$cel = str_replace([', '], '|', $cel);
		$cel = str_replace([' 0'], '|0', $cel);
		$cel = str_replace(['/|'], '|', $cel);
		$cel = str_replace([' |'], '|', $cel);
		$cel = strpos($cel, '-')<7?str_replace(['-'], '', $cel):$cel;
		$cel = strpos($cel, '-')>7?str_replace(['/',',', '-', ' '], '|', $cel):$cel;
		$cel = strpos($cel, ' ')>7?str_replace(['/',',', '-', ' '], '|', $cel):$cel;
		$cel = str_replace(['/',','], '|', $cel);
		$cel = str_replace([' '], '', $cel);
		$cel = str_replace(['-'], '', $cel);
		$cel = explode('|', $cel);
		$cel = isset($cel[$ret])?$cel[$ret]:$cel;
		return $cel;
    }
}