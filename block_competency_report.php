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
 * Competency Report Block.
 *
 * @package    block_competency_report
 * @copyright  2026 Mahmoud
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_competency_report extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_competency_report');
    }

    public function get_content() {
        global $USER, $DB, $PAGE;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        if (!isloggedin() || isguestuser()) {
            return $this->content;
        }

        // We only want to show this block on course pages or dashboard.
        $courseid = $this->page->course->id;
        
        // If on the dashboard/site home, courseid is usually SITEID (1).
        // Let's get a general summary across all courses if on dashboard.
        // Or a specific course summary if inside a course.

        if ($courseid == SITEID) {
            $this->content->text = get_string('dashboard_summary', 'block_competency_report');
            
            // Just output a quick stat of total proficiencies.
            $sql = "SELECT COUNT(id) FROM {competency_usercomp} 
                     WHERE userid = :userid AND proficiency = 1";
            $count = $DB->count_records_sql($sql, ['userid' => $USER->id]);
            
            $this->content->text .= '<br><br><strong>' . get_string('totalproficient', 'block_competency_report', $count) . '</strong>';
            
        } else {
            // Course specific view.
            $this->content->text = get_string('course_summary', 'block_competency_report');
            
            $url = new moodle_url('/local/competency_report/student_report.php', ['courseid' => $courseid]);
            $this->content->text .= '<br><br><a href="'.$url.'" class="btn btn-primary w-100">' . get_string('viewmyreport', 'block_competency_report') . '</a>';
        }

        return $this->content;
    }

    public function applicable_formats() {
        return [
            'course-view' => true,
            'my'          => true,
            'site'        => true,
        ];
    }
}
