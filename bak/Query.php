<?php

namespace alfmarks;

class Query {

	public $term;

	public $regex;

	public $accuracy = 0.5;

	public function __construct($term) {
		$this->term = $term;
	}

	public function multiScore(array $words) {
		$max = 0;
		foreach ($words as $word) {
			$max = max($max, $this->score($word));
		}
		return $max;
	}

	public function score($string) {
		preg_match($this->regex(), $string, $matches);
		$matched_chars = array_slice(array_values(array_filter($matches, 'strlen')), 2);
		if (empty($matches)) return;
		// How many characters you matched from the term
		$positive_score = strlen(implode('', $matched_chars)) / strlen($this->term);
		// Deductions for longer strings
		$negative_score = abs(strlen($matches[1]) - strlen($this->term)) / 100;
		return $positive_score - $negative_score;
	}

	public function regex() {
		if (!$this->regex) {
			$this->regex = '/.*?((';
			$this->regex .= implode(')).*?|.*?((', array_map(function($gram) {
				$gram_chars = str_split($gram);
				return implode(').*?(', array_map(function($gram_char) {
					return preg_quote($gram_char);
				}, $gram_chars));
			}, $this->grams()));
			$this->regex .= ')).*?/i';
		}
		return $this->regex;
	}

	public function grams() {
		$max = strlen($this->term);
		$min = ceil($this->accuracy * $max);
		$grams = array();
		foreach (range($max, $min) as $length) {
			$grams = array_merge($grams, $this->gramsByLength($length));
		}
		return $grams;
	}

	public function gramsByLength($length) {
		$ngrams = array();
		$stop = strlen($this->term) - $length;
		foreach (range(0, $stop) as $pos) {
			$ngrams[] = substr($this->term, $pos, $length);
		}
		return $ngrams;
	}

}