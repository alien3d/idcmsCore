<?php
	class smile {
		var  $wpsmiliestrans; 
		var $wp_smiliessearch;
		
		function smilies_init() {
				$this->wpsmiliestrans = array(
				':mrgreen:' => 'icon_mrgreen.gif',
				':neutral:' => 'icon_neutral.gif',
				':twisted:' => 'icon_twisted.gif',
				  ':arrow:' => 'icon_arrow.gif',
				  ':shock:' => 'icon_eek.gif',
				  ':smile:' => 'icon_smile.gif',
					':???:' => 'icon_confused.gif',
				   ':cool:' => 'icon_cool.gif',
				   ':evil:' => 'icon_evil.gif',
				   ':grin:' => 'icon_biggrin.gif',
				   ':idea:' => 'icon_idea.gif',
				   ':oops:' => 'icon_redface.gif',
				   ':razz:' => 'icon_razz.gif',
				   ':roll:' => 'icon_rolleyes.gif',
				   ':wink:' => 'icon_wink.gif',
					':cry:' => 'icon_cry.gif',
					':eek:' => 'icon_surprised.gif',
					':lol:' => 'icon_lol.gif',
					':mad:' => 'icon_mad.gif',
					':sad:' => 'icon_sad.gif',
					  '8-)' => 'icon_cool.gif',
					  '8-O' => 'icon_eek.gif',
					  ':-(' => 'icon_sad.gif',
					  ':-)' => 'icon_smile.gif',
					  ':-?' => 'icon_confused.gif',
					  ':-D' => 'icon_biggrin.gif',
					  ':-P' => 'icon_razz.gif',
					  ':-o' => 'icon_surprised.gif',
					  ':-x' => 'icon_mad.gif',
					  ':-|' => 'icon_neutral.gif',
					  ';-)' => 'icon_wink.gif',
					   '8)' => 'icon_cool.gif',
					   '8O' => 'icon_eek.gif',
					   ':(' => 'icon_sad.gif',
					   ':)' => 'icon_smile.gif',
					   ':?' => 'icon_confused.gif',
					   ':D' => 'icon_biggrin.gif',
					   ':P' => 'icon_razz.gif',
					   ':o' => 'icon_surprised.gif',
					   ':x' => 'icon_mad.gif',
					   ':|' => 'icon_neutral.gif',
					   ';)' => 'icon_wink.gif',
					  ':!:' => 'icon_exclaim.gif',
					  ':?:' => 'icon_question.gif',
				);

			if (count($this->wpsmiliestrans) == 0) {
				return;
			}

			/*
			 * NOTE: we sort the smilies in reverse key order. This is to make sure
			 * we match the longest possible smilie (:???: vs :?) as the regular
			 * expression used below is first-match
			 */
			krsort($this->wpsmiliestrans);

			$this->wp_smiliessearch = '/(?:\s|^)';

			$subchar = '';
			foreach ( (array) $this->wpsmiliestrans as $smiley => $img ) {
				$firstchar = substr($smiley, 0, 1);
				$rest = substr($smiley, 1);

				// new subpattern?
				if ($firstchar != $subchar) {
					if ($subchar != '') {
						$this->wp_smiliessearch .= ')|(?:\s|^)';
					}
					$subchar = $firstchar;
					$this->wp_smiliessearch .= preg_quote($firstchar, '/') . '(?:';
				} else {
					$this->wp_smiliessearch .= '|';
				}
				$this->wp_smiliessearch .= preg_quote($rest, '/');
			}

			$this->wp_smiliessearch .= ')(?:\s|$)/m';
		}
	function translate_smiley($smiley) {
		if (count($smiley) == 0) {
			return '';
		}

		$img = $this->wpsmiliestrans[$smiley];
		$smiley_masked = esc_attr($smiley);

		return " <img src='$images/smilies/$img' alt='$smiley_masked'/> ";
	}
	function convert_smilies($text) {
		$output = '';
		if (!empty($this->wp_smiliessearch) ) {
			// HTML loop taken from texturize function, could possible be consolidated
			$textarr = preg_split("/(<.*>)/U", $text, -1, PREG_SPLIT_DELIM_CAPTURE); // capture the tags as well as in between
			$stop = count($textarr);// loop stuff
			for ($i = 0; $i < $stop; $i++) {
				$content = $textarr[$i];
				if ((strlen($content) > 0) && ('<' != $content{0})) { // If it's not a tag
					$content = preg_replace_callback($this->wp_smiliessearch, '$this->translate_smiley', $content);
				}
				$output .= $content;
			}
		} else {
			// return default text.
			$output = $text;
		}
		return $output;
	}	
	}
?>