<?php
/* Copyright (C) 2024 SuperAdmin
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file    nextaccountingday/class/NextAccountingDayCalculator.class.php
 * \ingroup nextaccountingday
 * \brief   Class to calculate the next accounting (business) day
 */

/**
 * Class NextAccountingDayCalculator
 *
 * Provides methods to calculate the next business day (weekday)
 */
class NextAccountingDayCalculator
{
	/**
	 * Get the next business day (weekday) from a given date
	 *
	 * @param int|null $fromTimestamp Unix timestamp to calculate from (default: current time)
	 * @return int Unix timestamp of the next business day
	 */
	public function getNextBusinessDay($fromTimestamp = null)
	{
		if ($fromTimestamp === null) {
			$fromTimestamp = time();
		}

		// Get the next weekday
		$nextDay = strtotime('+1 Weekday', $fromTimestamp);

		return $nextDay;
	}

	/**
	 * Get the next business day as a formatted date string
	 *
	 * @param string $format PHP date format string
	 * @param int|null $fromTimestamp Unix timestamp to calculate from (default: current time)
	 * @return string Formatted date string
	 */
	public function getNextBusinessDayFormatted($format = 'Y-m-d', $fromTimestamp = null)
	{
		$nextDay = $this->getNextBusinessDay($fromTimestamp);
		return date($format, $nextDay);
	}

	/**
	 * Check if a given date is a weekday (Monday-Friday)
	 *
	 * @param int $timestamp Unix timestamp to check
	 * @return bool True if weekday, false if weekend
	 */
	public function isWeekday($timestamp)
	{
		$dayOfWeek = (int) date('N', $timestamp);
		return $dayOfWeek >= 1 && $dayOfWeek <= 5;
	}

	/**
	 * Check if a given date is a weekend day (Saturday or Sunday)
	 *
	 * @param int $timestamp Unix timestamp to check
	 * @return bool True if weekend, false if weekday
	 */
	public function isWeekend($timestamp)
	{
		return !$this->isWeekday($timestamp);
	}

	/**
	 * Get the day of week name for a given timestamp
	 *
	 * @param int $timestamp Unix timestamp
	 * @return string Day name (e.g., "Monday", "Tuesday", etc.)
	 */
	public function getDayName($timestamp)
	{
		return date('l', $timestamp);
	}

	/**
	 * Get the ISO day of week number (1 = Monday, 7 = Sunday)
	 *
	 * @param int $timestamp Unix timestamp
	 * @return int Day of week number (1-7)
	 */
	public function getDayOfWeek($timestamp)
	{
		return (int) date('N', $timestamp);
	}

	/**
	 * Calculate the number of business days between two dates
	 *
	 * @param int $startTimestamp Start date timestamp
	 * @param int $endTimestamp End date timestamp
	 * @return int Number of business days
	 */
	public function countBusinessDays($startTimestamp, $endTimestamp)
	{
		if ($startTimestamp > $endTimestamp) {
			return 0;
		}

		$count = 0;
		$current = $startTimestamp;

		while ($current <= $endTimestamp) {
			if ($this->isWeekday($current)) {
				$count++;
			}
			$current = strtotime('+1 day', $current);
		}

		return $count;
	}

	/**
	 * Add a specified number of business days to a date
	 *
	 * @param int $timestamp Starting timestamp
	 * @param int $businessDays Number of business days to add
	 * @return int Resulting timestamp
	 */
	public function addBusinessDays($timestamp, $businessDays)
	{
		if ($businessDays <= 0) {
			return $timestamp;
		}

		$daysAdded = 0;
		$current = $timestamp;

		while ($daysAdded < $businessDays) {
			$current = strtotime('+1 day', $current);
			if ($this->isWeekday($current)) {
				$daysAdded++;
			}
		}

		return $current;
	}
}
