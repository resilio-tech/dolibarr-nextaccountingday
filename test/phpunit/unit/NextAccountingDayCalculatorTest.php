<?php
/**
 * Standalone unit tests for NextAccountingDayCalculator
 * No Dolibarr dependency required
 *
 * Run with: phpunit htdocs/custom/nextaccountingday/test/phpunit/unit/NextAccountingDayCalculatorTest.php
 */

use PHPUnit\Framework\TestCase;

require_once dirname(__FILE__).'/../../../class/NextAccountingDayCalculator.class.php';

class NextAccountingDayCalculatorTest extends TestCase
{
	/**
	 * @var NextAccountingDayCalculator
	 */
	private $calculator;

	protected function setUp(): void
	{
		$this->calculator = new NextAccountingDayCalculator();
	}

	// ========================================
	// Tests for getNextBusinessDay()
	// ========================================

	public function testGetNextBusinessDayFromMonday()
	{
		// Monday 2024-01-15 -> Tuesday 2024-01-16
		$monday = strtotime('2024-01-15');
		$result = $this->calculator->getNextBusinessDay($monday);

		$this->assertEquals('2024-01-16', date('Y-m-d', $result));
		$this->assertEquals('Tuesday', date('l', $result));
	}

	public function testGetNextBusinessDayFromTuesday()
	{
		// Tuesday 2024-01-16 -> Wednesday 2024-01-17
		$tuesday = strtotime('2024-01-16');
		$result = $this->calculator->getNextBusinessDay($tuesday);

		$this->assertEquals('2024-01-17', date('Y-m-d', $result));
		$this->assertEquals('Wednesday', date('l', $result));
	}

	public function testGetNextBusinessDayFromWednesday()
	{
		// Wednesday 2024-01-17 -> Thursday 2024-01-18
		$wednesday = strtotime('2024-01-17');
		$result = $this->calculator->getNextBusinessDay($wednesday);

		$this->assertEquals('2024-01-18', date('Y-m-d', $result));
		$this->assertEquals('Thursday', date('l', $result));
	}

	public function testGetNextBusinessDayFromThursday()
	{
		// Thursday 2024-01-18 -> Friday 2024-01-19
		$thursday = strtotime('2024-01-18');
		$result = $this->calculator->getNextBusinessDay($thursday);

		$this->assertEquals('2024-01-19', date('Y-m-d', $result));
		$this->assertEquals('Friday', date('l', $result));
	}

	public function testGetNextBusinessDayFromFriday()
	{
		// Friday 2024-01-19 -> Monday 2024-01-22 (skips weekend)
		$friday = strtotime('2024-01-19');
		$result = $this->calculator->getNextBusinessDay($friday);

		$this->assertEquals('2024-01-22', date('Y-m-d', $result));
		$this->assertEquals('Monday', date('l', $result));
	}

	public function testGetNextBusinessDayFromSaturday()
	{
		// Saturday 2024-01-20 -> Monday 2024-01-22
		$saturday = strtotime('2024-01-20');
		$result = $this->calculator->getNextBusinessDay($saturday);

		$this->assertEquals('2024-01-22', date('Y-m-d', $result));
		$this->assertEquals('Monday', date('l', $result));
	}

	public function testGetNextBusinessDayFromSunday()
	{
		// Sunday 2024-01-21 -> Monday 2024-01-22
		$sunday = strtotime('2024-01-21');
		$result = $this->calculator->getNextBusinessDay($sunday);

		$this->assertEquals('2024-01-22', date('Y-m-d', $result));
		$this->assertEquals('Monday', date('l', $result));
	}

	public function testGetNextBusinessDayReturnsTimestamp()
	{
		$monday = strtotime('2024-01-15');
		$result = $this->calculator->getNextBusinessDay($monday);

		$this->assertIsInt($result);
		$this->assertGreaterThan($monday, $result);
	}

	// ========================================
	// Tests for getNextBusinessDayFormatted()
	// ========================================

	public function testGetNextBusinessDayFormattedDefaultFormat()
	{
		$monday = strtotime('2024-01-15');
		$result = $this->calculator->getNextBusinessDayFormatted('Y-m-d', $monday);

		$this->assertEquals('2024-01-16', $result);
	}

	public function testGetNextBusinessDayFormattedCustomFormat()
	{
		$monday = strtotime('2024-01-15');
		$result = $this->calculator->getNextBusinessDayFormatted('d/m/Y', $monday);

		$this->assertEquals('16/01/2024', $result);
	}

	public function testGetNextBusinessDayFormattedWithDayName()
	{
		$friday = strtotime('2024-01-19');
		$result = $this->calculator->getNextBusinessDayFormatted('l, Y-m-d', $friday);

		$this->assertEquals('Monday, 2024-01-22', $result);
	}

	// ========================================
	// Tests for isWeekday()
	// ========================================

	public function testIsWeekdayMonday()
	{
		$monday = strtotime('2024-01-15');
		$this->assertTrue($this->calculator->isWeekday($monday));
	}

	public function testIsWeekdayTuesday()
	{
		$tuesday = strtotime('2024-01-16');
		$this->assertTrue($this->calculator->isWeekday($tuesday));
	}

	public function testIsWeekdayWednesday()
	{
		$wednesday = strtotime('2024-01-17');
		$this->assertTrue($this->calculator->isWeekday($wednesday));
	}

	public function testIsWeekdayThursday()
	{
		$thursday = strtotime('2024-01-18');
		$this->assertTrue($this->calculator->isWeekday($thursday));
	}

	public function testIsWeekdayFriday()
	{
		$friday = strtotime('2024-01-19');
		$this->assertTrue($this->calculator->isWeekday($friday));
	}

	public function testIsWeekdaySaturday()
	{
		$saturday = strtotime('2024-01-20');
		$this->assertFalse($this->calculator->isWeekday($saturday));
	}

	public function testIsWeekdaySunday()
	{
		$sunday = strtotime('2024-01-21');
		$this->assertFalse($this->calculator->isWeekday($sunday));
	}

	// ========================================
	// Tests for isWeekend()
	// ========================================

	public function testIsWeekendSaturday()
	{
		$saturday = strtotime('2024-01-20');
		$this->assertTrue($this->calculator->isWeekend($saturday));
	}

	public function testIsWeekendSunday()
	{
		$sunday = strtotime('2024-01-21');
		$this->assertTrue($this->calculator->isWeekend($sunday));
	}

	public function testIsWeekendMonday()
	{
		$monday = strtotime('2024-01-15');
		$this->assertFalse($this->calculator->isWeekend($monday));
	}

	public function testIsWeekendFriday()
	{
		$friday = strtotime('2024-01-19');
		$this->assertFalse($this->calculator->isWeekend($friday));
	}

	// ========================================
	// Tests for getDayName()
	// ========================================

	public function testGetDayNameMonday()
	{
		$monday = strtotime('2024-01-15');
		$this->assertEquals('Monday', $this->calculator->getDayName($monday));
	}

	public function testGetDayNameSaturday()
	{
		$saturday = strtotime('2024-01-20');
		$this->assertEquals('Saturday', $this->calculator->getDayName($saturday));
	}

	// ========================================
	// Tests for getDayOfWeek()
	// ========================================

	public function testGetDayOfWeekMonday()
	{
		$monday = strtotime('2024-01-15');
		$this->assertEquals(1, $this->calculator->getDayOfWeek($monday));
	}

	public function testGetDayOfWeekFriday()
	{
		$friday = strtotime('2024-01-19');
		$this->assertEquals(5, $this->calculator->getDayOfWeek($friday));
	}

	public function testGetDayOfWeekSaturday()
	{
		$saturday = strtotime('2024-01-20');
		$this->assertEquals(6, $this->calculator->getDayOfWeek($saturday));
	}

	public function testGetDayOfWeekSunday()
	{
		$sunday = strtotime('2024-01-21');
		$this->assertEquals(7, $this->calculator->getDayOfWeek($sunday));
	}

	// ========================================
	// Tests for countBusinessDays()
	// ========================================

	public function testCountBusinessDaysSameDay()
	{
		$monday = strtotime('2024-01-15');
		$result = $this->calculator->countBusinessDays($monday, $monday);

		$this->assertEquals(1, $result);
	}

	public function testCountBusinessDaysOneWeek()
	{
		// Monday to Friday = 5 business days
		$monday = strtotime('2024-01-15');
		$friday = strtotime('2024-01-19');
		$result = $this->calculator->countBusinessDays($monday, $friday);

		$this->assertEquals(5, $result);
	}

	public function testCountBusinessDaysTwoWeeks()
	{
		// Monday Jan 15 to Friday Jan 26 = 10 business days
		$monday = strtotime('2024-01-15');
		$friday = strtotime('2024-01-26');
		$result = $this->calculator->countBusinessDays($monday, $friday);

		$this->assertEquals(10, $result);
	}

	public function testCountBusinessDaysWeekendOnly()
	{
		// Saturday to Sunday = 0 business days
		$saturday = strtotime('2024-01-20');
		$sunday = strtotime('2024-01-21');
		$result = $this->calculator->countBusinessDays($saturday, $sunday);

		$this->assertEquals(0, $result);
	}

	public function testCountBusinessDaysInvalidRange()
	{
		// End before start = 0
		$monday = strtotime('2024-01-15');
		$friday = strtotime('2024-01-12');
		$result = $this->calculator->countBusinessDays($monday, $friday);

		$this->assertEquals(0, $result);
	}

	// ========================================
	// Tests for addBusinessDays()
	// ========================================

	public function testAddBusinessDaysOne()
	{
		// Monday + 1 business day = Tuesday
		$monday = strtotime('2024-01-15');
		$result = $this->calculator->addBusinessDays($monday, 1);

		$this->assertEquals('2024-01-16', date('Y-m-d', $result));
		$this->assertEquals('Tuesday', date('l', $result));
	}

	public function testAddBusinessDaysFive()
	{
		// Monday + 5 business days = Monday (next week)
		$monday = strtotime('2024-01-15');
		$result = $this->calculator->addBusinessDays($monday, 5);

		$this->assertEquals('2024-01-22', date('Y-m-d', $result));
		$this->assertEquals('Monday', date('l', $result));
	}

	public function testAddBusinessDaysFromFriday()
	{
		// Friday + 1 business day = Monday
		$friday = strtotime('2024-01-19');
		$result = $this->calculator->addBusinessDays($friday, 1);

		$this->assertEquals('2024-01-22', date('Y-m-d', $result));
		$this->assertEquals('Monday', date('l', $result));
	}

	public function testAddBusinessDaysFromSaturday()
	{
		// Saturday + 1 business day = Monday
		$saturday = strtotime('2024-01-20');
		$result = $this->calculator->addBusinessDays($saturday, 1);

		$this->assertEquals('2024-01-22', date('Y-m-d', $result));
		$this->assertEquals('Monday', date('l', $result));
	}

	public function testAddBusinessDaysZero()
	{
		// Monday + 0 business days = Monday (same day)
		$monday = strtotime('2024-01-15');
		$result = $this->calculator->addBusinessDays($monday, 0);

		$this->assertEquals('2024-01-15', date('Y-m-d', $result));
	}

	public function testAddBusinessDaysNegative()
	{
		// Negative days returns same day
		$monday = strtotime('2024-01-15');
		$result = $this->calculator->addBusinessDays($monday, -1);

		$this->assertEquals('2024-01-15', date('Y-m-d', $result));
	}

	public function testAddBusinessDaysTen()
	{
		// Monday + 10 business days = two weeks later (Friday)
		$monday = strtotime('2024-01-15');
		$result = $this->calculator->addBusinessDays($monday, 10);

		$this->assertEquals('2024-01-29', date('Y-m-d', $result));
		$this->assertEquals('Monday', date('l', $result));
	}
}
