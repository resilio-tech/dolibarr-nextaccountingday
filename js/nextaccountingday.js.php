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
 *
 * Library javascript to enable Browser notifications
 */

if (!defined('NOREQUIREUSER')) {
	define('NOREQUIREUSER', '1');
}
if (!defined('NOREQUIREDB')) {
	define('NOREQUIREDB', '1');
}
if (!defined('NOREQUIRESOC')) {
	define('NOREQUIRESOC', '1');
}
if (!defined('NOCSRFCHECK')) {
	define('NOCSRFCHECK', 1);
}
if (!defined('NOTOKENRENEWAL')) {
	define('NOTOKENRENEWAL', 1);
}
if (!defined('NOLOGIN')) {
	define('NOLOGIN', 1);
}
if (!defined('NOREQUIREMENU')) {
	define('NOREQUIREMENU', 1);
}
if (!defined('NOREQUIREHTML')) {
	define('NOREQUIREHTML', 1);
}
if (!defined('NOREQUIREAJAX')) {
	define('NOREQUIREAJAX', '1');
}


/**
 * \file    nextaccountingday/js/nextaccountingday.js.php
 * \ingroup nextaccountingday
 * \brief   JavaScript file for module NextAccountingDay.
 */

// Load Dolibarr environment
$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) {
	$res = @include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
}
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp = empty($_SERVER['SCRIPT_FILENAME']) ? '' : $_SERVER['SCRIPT_FILENAME']; $tmp2 = realpath(__FILE__); $i = strlen($tmp) - 1; $j = strlen($tmp2) - 1;
while ($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i] == $tmp2[$j]) {
	$i--; $j--;
}
if (!$res && $i > 0 && file_exists(substr($tmp, 0, ($i + 1))."/main.inc.php")) {
	$res = @include substr($tmp, 0, ($i + 1))."/main.inc.php";
}
if (!$res && $i > 0 && file_exists(substr($tmp, 0, ($i + 1))."/../main.inc.php")) {
	$res = @include substr($tmp, 0, ($i + 1))."/../main.inc.php";
}
// Try main.inc.php using relative path
if (!$res && file_exists("../../main.inc.php")) {
	$res = @include "../../main.inc.php";
}
if (!$res && file_exists("../../../main.inc.php")) {
	$res = @include "../../../main.inc.php";
}
if (!$res) {
	die("Include of main fails");
}

// Define js type
header('Content-Type: application/javascript');
// Important: Following code is to cache this file to avoid page request by browser at each Dolibarr page access.
// You can use CTRL+F5 to refresh your browser cache.
if (empty($dolibarr_nocache)) {
	header('Cache-Control: max-age=3600, public, must-revalidate');
} else {
	header('Cache-Control: no-cache');
}

include_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';

global $langs;

$langs->load('nextaccountingday@nextaccountingday');

function getNextAccountingDay () {
	// get the next business day
	$nextDay = date('Y-m-d', strtotime('+1 Weekday'));
	$nextDay = dol_stringtotime($nextDay);

	return $nextDay;
}

$nextDay = getNextAccountingDay();
?>

function defineOnClick (name) {
	return `
	jQuery('#${name}').val('<?= dol_print_date($nextDay, 'day', 'tzuserrel') ?>');
	jQuery('#${name}month').val('<?= dol_print_date($nextDay, '%m', 'tzuserrel') ?>');
	jQuery('#${name}day').val('<?= dol_print_date($nextDay, '%d', 'tzuserrel') ?>');
	jQuery('#${name}year').val('<?= dol_print_date($nextDay, '%Y', 'tzuserrel') ?>');
	jQuery('#${name}').change();
	return;
`;
}

/* Javascript library of module NextAccountingDay */
function createNextAccountingDay(name) {
	const button = document.createElement('button');
	button.type = 'button';
	button.className = 'dpInvisibleButtons datenowlink';
	button.setAttribute('onclick', defineOnClick(name));
	button.innerHTML = '<?= $langs->trans("NextAccountingDayButton") ?>';
	button.title = '<?= $langs->trans("NextAccountingDayButtonTooltip") ?>';
	button.name = `${name}nextaccountingday`;
	button.setAttribute('data-toggle', 'tooltip');
	button.setAttribute('data-placement', 'top');

	return button;
}

function proceed() {
	setTimeout(() => {
		$('.divfordateinput').each(function () {
			const input = $(this).find('input');
			const name = input.attr('name');
			const button = createNextAccountingDay(name);
			$(this).after(' ');
			$(this).after(button);
		})
	}, 5);
}

const contain = [
	'salaries',
	'compta/sociales',
	'compta/bank/various_payment',
	'fourn/facture'
]

$(document).ready(function () {
	const path = window.location.pathname;
	const isContain = contain.some((el) => path.includes(el));
	if (!isContain) return;
	proceed();
});
