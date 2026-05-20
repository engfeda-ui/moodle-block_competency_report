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
 * Privacy provider for block_competency_report.
 *
 * @package    block_competency_report
 * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_competency_report\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\writer;

/**
 * Privacy provider — this block stores no personal data of its own.
 *
 * All competency data displayed by this block is owned by core_competency
 * and local_competency_report; those plugins are responsible for their own
 * privacy declarations.
 *
 * @package    block_competency_report
 * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements \core_privacy\local\metadata\provider {
    /**
     * Returns metadata about this plugin's privacy footprint.
     *
     * @param collection $collection The initialised collection to add items to.
     * @return collection The updated collection.
     */
    public static function get_metadata(collection $collection): collection {
        // This block reads competency data from core tables but stores nothing itself.
        $collection->add_plugintype_link(
            'local_competency_report',
            [],
            'privacy:metadata:local_competency_report'
        );

        return $collection;
    }
}
