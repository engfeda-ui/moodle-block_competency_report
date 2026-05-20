<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Version information for block_competency_report.
 *
 * @package    block_competency_report
 * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'block_competency_report';
$plugin->version   = 2026052000;
$plugin->requires  = 2024042210; // Requires Moodle 4.5.
$plugin->supported = [405, 500]; // Supported Moodle versions.
$plugin->maturity  = MATURITY_STABLE;
$plugin->release   = 'v1.1.0';

$plugin->dependencies = [
    'local_competency_report' => 2026052000,
];
