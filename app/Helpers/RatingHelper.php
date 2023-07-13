<?php

namespace Helpers;

class RatingHelper
{
	public function starsPlusRating($ratings)
	{
		$star_rating = ceil(array_sum($ratings) * 2 / count($ratings))/2;
		$avg_rating = round(array_sum($ratings) / count($ratings), 2);
		$rtn = '<span class="text-primary">'
		. str_repeat('<i class="fa-solid fa-star"></i>', floor($star_rating))
		. str_repeat('<i class="fa-solid fa-star-half-stroke"></i>', ceil($star_rating - floor($star_rating)))
		. str_repeat('<i class="fa-regular fa-star"></i>', 5 - ceil($star_rating))
		. '</span> '
		. $avg_rating;

		return $rtn;
	}
}

