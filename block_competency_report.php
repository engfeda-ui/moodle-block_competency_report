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
 * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * block_competency_report class definition.
 *
 * @package    block_competency_report
 * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_competency_report extends block_base {

    /**
     * Initialize block title.
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_competency_report');
    }

    /**
     * Get block content rendered via Mustache template.
     *
     * @return stdClass The block content object.
     */
    public function get_content() {
        global $USER, $DB, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content         = new stdClass();
        $this->content->text   = '';
        $this->content->footer = '';

        if (!isloggedin() || isguestuser()) {
            return $this->content;
        }

        $courseid = $this->page->course->id;

        if ($courseid == SITEID) {
            $this->content->text = $this->render_dashboard_view($USER->id, $DB, $OUTPUT);
        } else {
            $this->content->text = $this->render_course_view($courseid, $OUTPUT);
        }

        return $this->content;
    }

    /**
     * Build template context and render the dashboard (site-home) view.
     *
     * Shows total proficient competencies with a progress bar.
     *
     * @param int    $userid The current user ID.
     * @param \moodle_database $db  The global DB object.
     * @param \core_renderer   $output The global OUTPUT renderer.
     * @return string Rendered HTML.
     */
    protected function render_dashboard_view(int $userid, $db, $output): string {
        // Count proficient competencies for this user.
        $proficient = (int) $db->count_records_sql(
            "SELECT COUNT(id) FROM {competency_usercomp} WHERE userid = :userid AND proficiency = 1",
            ['userid' => $userid]
        );

        // Count total competencies assigned to this user.
        $total = (int) $db->count_records_sql(
            "SELECT COUNT(id) FROM {competency_usercomp} WHERE userid = :userid",
            ['userid' => $userid]
        );

        $percent  = ($total > 0) ? (int) round(($proficient / $total) * 100) : 0;

        // Choose progress-bar colour based on percentage.
        if ($percent >= 80) {
            $barclass = 'bg-success';
        } else if ($percent >= 50) {
            $barclass = 'bg-warning';
        } else {
            $barclass = 'bg-danger';
        }

        $context = [
            'is_dashboard'    => true,
            'summary_text'    => get_string('dashboard_summary', 'block_competency_report'),
            'proficient_label' => get_string('totalproficient_label', 'block_competency_report'),
            'proficient'      => $proficient,
            'total'           => $total,
            'percent'         => $percent,
            'bar_class'       => $barclass,
            'has_data'        => ($total > 0),
            'nodata_str'      => get_string('nodata', 'block_competency_report'),
        ];

        return $output->render_from_template('block_competency_report/block_content', $context);
    }

    /**
     * Build template context and render the course-specific view.
     *
     * Shows a button linking to the student's full report card.
     *
     * @param int              $courseid The current course ID.
     * @param \core_renderer   $output   The global OUTPUT renderer.
     * @return string Rendered HTML.
     */
    protected function render_course_view(int $courseid, $output): string {
        $url = new moodle_url('/local/competency_report/student_report.php', ['courseid' => $courseid]);

        $context = [
            'is_dashboard'   => false,
            'summary_text'   => get_string('course_summary', 'block_competency_report'),
            'report_url'     => $url->out(false),
            'viewreport_str' => get_string('viewmyreport', 'block_competency_report'),
        ];

        return $output->render_from_template('block_competency_report/block_content', $context);
    }

    /**
     * Determine where the block can be added.
     *
     * @return array The page formats where this block is applicable.
     */
    public function applicable_formats() {
        return [
            'course-view' => true,
            'my'          => true,
            'site'        => true,
        ];
    }
}
