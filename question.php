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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Represents a combined question.
 *
 * @package    qtype_combined
 * @copyright  2013 The Open University
 * @author     Jamie Pratt <me@jamiep.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_combined_question extends question_graded_automatically_with_countback {

    /**
     * @var qtype_combined_combiner_for_run_time_question_instance class through which to access all subqs.
     */
    public $combiner;

    /** @var string Feedback for any correct response. */
    public $correctfeedback;

    /** @var int format of $correctfeedback. */
    public $correctfeedbackformat;

    /** @var string Feedback for any partially correct response. */
    public $partiallycorrectfeedback;

    /** @var int format of $partiallycorrectfeedback. */
    public $partiallycorrectfeedbackformat;

    /** @var string Feedback for any incorrect response. */
    public $incorrectfeedback;

    /** @var int format of $incorrectfeedback. */
    public $incorrectfeedbackformat;

    #[\Override]
    public function start_attempt(question_attempt_step $step, $variant) {
        $this->combiner->call_all_subqs('start_attempt', new qtype_combined_step_param($step), $variant);
    }

    #[\Override]
    public function apply_attempt_state(question_attempt_step $step) {
        $this->combiner->call_all_subqs('apply_attempt_state', new qtype_combined_step_param($step));
    }

    #[\Override]
    public function validate_can_regrade_with_other_version(question_definition $otherversion): ?string {
        $basemessage = parent::validate_can_regrade_with_other_version($otherversion);
        if ($basemessage) {
            return $basemessage;
        }

        return $this->combiner->validate_can_regrade_with_other_version($otherversion->combiner);
    }

    #[\Override]
    public function update_attempt_state_data_for_new_version(
            question_attempt_step $oldstep, question_definition $otherversion) {
        parent::update_attempt_state_data_for_new_version($oldstep, $otherversion);

        return $this->combiner->update_attempt_state_data_for_new_version(
                $oldstep, $otherversion->combiner);
    }

    #[\Override]
    public function get_expected_data() {
        return $this->combiner->aggregate_response_arrays(
            $this->combiner->call_all_subqs('get_expected_data')
        );
    }

    #[\Override]
    public function get_correct_response() {
        return $this->combiner->aggregate_response_arrays(
            $this->combiner->call_all_subqs('get_correct_response')
        );
    }

    #[\Override]
    public function summarise_response(array $response) {
        $subqsummaries = $this->combiner->call_all_subqs('summarise_response', new qtype_combined_response_array_param($response));
        $summarytexts = [];
        foreach ($subqsummaries as $subqno => $summary) {
            $subqname = $this->combiner->get_subq_property($subqno, 'name');
            $subqname = \qtype_combined\utils::replace_embed_placeholder($subqname);
            $summarytexts[] = "$subqname [{$summary}]";
        }
        return implode(', ', $summarytexts);
    }

    #[\Override]
    public function is_complete_response(array $response) {
        $subqiscompletes = $this->combiner->call_all_subqs('is_complete_response',
                                                           new qtype_combined_response_array_param($response));
        // All sub-questions are complete if none of the method calls returned false.
        return (false === array_search(false, $subqiscompletes));
    }

    /**
     * Check if the response is gradable.
     *
     * @param array $response The response to check.
     * @return bool True if the response is gradable, false otherwise.
     */
    public function is_gradable_response(array $response) {
        $subqisgradables = $this->combiner->call_all_subqs('is_gradable_response',
                                                           new qtype_combined_response_array_param($response));
        // Question is gradable if any of the subqs are gradable.
        return (false !== array_search(true, $subqisgradables));
    }

    #[\Override]
    public function get_validation_error(array $response) {
        return $this->combiner->get_validation_error(new qtype_combined_response_array_param($response));
    }

    #[\Override]
    public function is_same_response(array $prevresponse, array $newresponse) {
        $subqssame = $this->combiner->call_all_subqs('is_same_response',
                                                     new qtype_combined_response_array_param($prevresponse),
                                                     new qtype_combined_response_array_param($newresponse));
        // All sub-question responses are same if none of the method calls returned false.
        return (false === array_search(false, $subqssame));
    }

    #[\Override]
    public function check_file_access($qa, $options, $component, $filearea,
            $args, $forcedownload) {
        if ($component == 'question' && $filearea == 'hint') {
            return $this->check_hint_file_access($qa, $options, $args);
        }
        foreach ($qa->get_last_qt_data() as $answefilearea => $answer) {
            if ($component === 'question' &&
                question_file_saver::clean_file_area_name('response_' . $answefilearea) === $filearea) {
                return true;
            }
            continue;
        }
        // If this is not a hint then first arg is question id.
        list($qid, $filename) = $args;
        $subq = $this->combiner->find_subq_with_id($qid);
        if ($subq !== null) {
            if ($component == 'question' && $filearea == 'generalfeedback') {
                // We are (mis)using subq general feedback field to store incorrect feedback.
                // We will override the general feedback access control here for subqs so that subq general feeback files can
                // be shown whenever the feedback option is on and not just when the general feedback option is on.
                return (bool)$options->feedback;
            } else {
                // Pass through to subq.
                return $subq->question->check_file_access($qa, $options, $component, $filearea, $args, $forcedownload);
            }
        } else if ($component == 'question' && $filearea == 'answerfeedback') {
            // We are (mis)using subq varnumberic answer feedback field to store correct feedback.
            // We will override the answer feedback access control here for subqs.
            // So that subq answer feeback files can be shown whenever the answer is correct.
            return (bool) $options->correctness;
        } else if ($component == 'question' && in_array($filearea,
                ['correctfeedback', 'partiallycorrectfeedback', 'incorrectfeedback'])) {
            return $this->check_combined_feedback_file_access($qa, $options, $filearea, $args);
        } else {
            return parent::check_file_access($qa, $options, $component, $filearea,
                    $args, $forcedownload);
        }
    }

    #[\Override]
    public function grade_response(array $response) {
        $subqsgradable =
            $this->combiner->call_all_subqs('is_gradable_response', new qtype_combined_response_array_param($response));
        $subqstates = [];
        $fractionsum = 0;
        foreach ($subqsgradable as $subqno => $gradable) {
            if ($gradable) {
                list($subqfraction, $subqstate) =
                    $this->combiner->call_subq($subqno, 'grade_response', new qtype_combined_response_array_param($response));
                $subqstates[] = $subqstate;
            } else {
                $subqstates[] = question_state::$gaveup;
                $subqfraction = 0;
            }
            $fractionsum += $subqfraction * $this->combiner->get_subq_property($subqno, 'defaultmark');
        }
        return [$fractionsum, $this->overall_state($subqstates)];
    }

    /**
     * Overall state of the combined question.
     *
     * @param string[] $subqstates states of sub-questions.
     * @return string state of combined question
     */
    protected function overall_state($subqstates) {
        $subqstates = array_unique($subqstates);
        $subqstates = array_filter($subqstates, function($value) {
            return !is_null($value);
        });

        if (count($subqstates) === 1) {
            // All subqs in same state.
            return reset($subqstates);
        } else {
            if (count($subqstates) === 2 &&
                (false !== array_search(question_state::$gaveup, $subqstates)) &&
                (false !== array_search(question_state::$gradedwrong, $subqstates))
            ) {
                return question_state::$gradedwrong;
            } else {
                return question_state::$gradedpartial;
            }
        }
    }

    #[\Override]
    public function compute_final_grade($responses, $totaltries) {
        return $this->combiner->compute_final_grade($responses, $totaltries);
    }

    #[\Override]
    public function get_num_parts_right(array $response) {
        $subqresponses = new qtype_combined_response_array_param($response);
        $subqsnumpartscorrect = $this->combiner->call_all_subqs('get_num_parts_right', $subqresponses);
        $totalparts = $totalpartscorrect = 0;
        foreach ($subqsnumpartscorrect as $subqno => $numpartscorrect) {
            list($subqpartscorrect, $subqnumparts) = $numpartscorrect;
            if (is_null($subqpartscorrect) && is_null($subqnumparts)) {
                list (, $state) = $this->combiner->call_subq($subqno, 'grade_response', $subqresponses);
                $subqpartscorrect = ($state === question_state::$gradedright) ? 1 : 0;
                $subqnumparts = 1;
            }
            $totalpartscorrect += $subqpartscorrect;
            $totalparts += $subqnumparts;
        }
        return [$totalpartscorrect, $totalparts];
    }

    /**
     * Classify the response for each sub-question.
     *
     * @param array $response
     */
    public function classify_response(array $response) {
        $aggregatedresponses = [];
        $classifiedresps = $this->combiner->call_all_subqs('classify_response', new qtype_combined_response_array_param($response));
        foreach ($classifiedresps as $subqno => $subqclassifiedresponses) {
            $subqtype = $this->combiner->get_subq_property($subqno, 'qtype')->name();
            $subqname = $this->combiner->get_subq_property($subqno, 'name');
            $defaultmark = $this->combiner->get_subq_property($subqno, 'defaultmark');
            foreach ($subqclassifiedresponses as $subqsubqid => $subqclassifiedresponse) {
                $subqid = qtype_combined_type_manager::response_id($subqname, $subqtype, $subqsubqid);
                $subqclassifiedresponse->fraction = $subqclassifiedresponse->fraction * $defaultmark;
                $aggregatedresponses[$subqid] = $subqclassifiedresponse;
            }
        }
        return $aggregatedresponses;
    }
}
