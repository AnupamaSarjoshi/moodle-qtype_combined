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
 * Strings for component 'qtype_combined', language 'en'
 *
 * @package    qtype_combined
 * @copyright  2013 The Open University
 * @author     Jamie Pratt <me@jamiep.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['controlnamegapselect'] = 'drop down box';
$string['controlnamegapselectplural'] = 'drop down boxes';
$string['controlnamemultichoice'] = 'radio group';
$string['controlnameshowworking'] = 'text input';
$string['correct_choice_embed_code'] = '[[{$a->qid}:{$a->qtype}:{correct choice}]]';
$string['correctfeedback'] = 'Feedback for correct response';
$string['embeddedquestionremovedfromform'] = 'One or more embedded questions have been removed from the question text. The question data for these questions is still shown below, but it will be permanently removed when you either press the \'Update the form\' or \'Save changes\' button, unless you put the embed codes back in the question text again.';
$string['err_accepts_vertical_or_horizontal_layout_param'] = '<p>The \'{$a}\' question type allows you to specify the layout of your question type as follows:<ul>
<li>[[{question identifier}:{$a}:v]] vertical OR</li>
<li>[[{question identifier}:{$a}:h]] horizontal.</li></ul>
<p>You should not enter anything else after the second colon.</p>';
$string['err_duplicateids'] = 'Each embedded question instance should have a different identifier. You have used the following identifier(s) for more than one question \'{$a}\'.';
$string['err_fillinthedetailsforsubq'] = 'You need to fill in the details to describe the sub-question \'{$a}\'.';
$string['err_fillinthedetailshere'] = 'You need to fill in the details for this sub-question.';
$string['err_insufficientnoofcodeparts'] = 'Error, your code to embed a question control \'{$a->fullcode}\' has too few colon separated parts. You should have at least a question indentifier id, followed by a question type identifier.';
$string['err_invalid_number'] = 'The \'{$a}\' question type expects a number after the question type identifier, your embed code should be [[{your question id}:{$a}:{a number here}]]';
$string['err_invalid_width_specifier_postfix'] = '<p>The \'{$a}\' question type allows you to specify the width of your question type as follows:<ul>
<li>[[{question identifier}:{$a}:____]] where the width of the input box will depend on the number of underscores or</li>
<li>[[{question identifier}:{$a}:__10__]] where the width of the input box will depend on the number.</li></ul>
<p>You should not enter anything else after the second colon.</p>';
$string['err_invalid_width_specifier_postfix_showworking'] = '<p>The \'{$a}\' question type allows you to specify the plain text input box size and format as follows:</p>
<ul>
  <li>[[{question identifier}:showworking:____:plain]] where the width of the input box depends on the number of underscores.</li>
  <li>[[{question identifier}:showworking:__10__:plain]] where the width of the input box depends on the number.</li>
  <li>[[{question identifier}:showworking:__80x5__:plain]] where the width and height of the input box depend on the numbers.</li>
  <li>After {size} is set, you can specify \':plain\' or \':editor\' (editor is also the default). Note that due to the editor, you cannot control the input size width, only the height.</li>
</ul>';
$string['err_invalidquestionidentifier'] = 'Your question identifier code consist of one or more alphanumeric characters.';
$string['err_questionidentifiertoolong'] = 'The sub-question name \'{$a}\' is too long. You can use up to 10 alphanumeric characters.';
$string['err_subq_not_included_in_question_text'] = 'It seems you have removed this question from the question text. Embed this question in the form with the code {$a} or it will be removed when you submit this form again.';
$string['err_thisqtypecannothavemorethanonecontrol'] = 'You have tried to embed more than one control for question type \'{$a->qtype}\' with question instance name \'{$a->qid}\'. This question type only allows you to embed one control per question instance.';
$string['err_thisqtypedoesnotacceptextrainfo'] = 'This question type is embedded with the code [[{your question id}:{$a}]]. You should not include anything after the qtype identifier, even a second colon.';
$string['err_unrecognisedqtype'] = 'The question type identifier \'{$a->qtype}\' you entered in embedded code \'{$a->fullcode}\'is not known.';
$string['err_weightingsdonotaddup'] = 'Weightings for sub-questions do not add up to 1.';
$string['err_you_must_provide_third_param'] = 'You must provide a third param for question type {$a}.';
$string['err_youneedmorechoices'] = 'You need to enter two or more choices.';
$string['incorrectfeedback'] = 'Feedback for any incorrect response';
$string['multiresponse'] = 'Default options for multiresponse sub-questions';
$string['noembeddedquestions'] = 'There must be at least one embedded sub-question.';
$string['nosubquestiontypesinstalled'] = 'This question type allows for the combination of the functionality of other question
types. You need to install at least one of these other question types which will be used as sub-questions.

See the <a href="https://moodle.org/plugins/view.php?plugin=qtype_combined">entry in the plug-in db</a> for more details and a
list of question types that can be used as sub-questions.';
$string['pluginname'] = 'Combined';
$string['pluginname_help'] = ' Create a question with embedded response fields in your question text.

Depending on the sub-question types installed in your Moodle you may ask the student to enter a numeric or text value or select a
value from a number of options. Embed codes in the question text will be replaced by either check boxes, select boxes or a text
entry field so the student can enter their answer.

When you create a new question all the codes to embed available sub-question types are automatically added to the question text
as examples of codes you can use. And at the same time the appropriate form fragments to specify the options for each question
appear below the question text entry field. Edit the
question text and change the codes in the question text to change which types of sub-questions to include in the question text and
then press the "Update the form" button to have the correct parts of the form displayed to edit
your sub-question settings.';
$string['pluginname_link'] = 'question/type/combined';
$string['pluginnameadding'] = 'Adding a combined question';
$string['pluginnameediting'] = 'Editing a combined question';
$string['pluginnamesummary'] = 'A combined question type which allows the embedding of the response fields for various available
sub-questions in the question text.

Depending on which question types you have installed, the student can enter a numeric or short text answer or choose an answer or
answers using a select box or check boxes.';
$string['privacy:metadata'] = 'The Combined plugin does not store any personal data.';
$string['regradeissuenumsubquestionschanged'] = 'The number of embedded sub-questions in the question has changed.';
$string['shuffle'] = 'Shuffle';
$string['singlechoice'] = 'Default options for singlechoice sub-questions';
$string['subqheader'] = '\'{$a->qtype}\' input \'{$a->qid}\'';
$string['subqheader_not_in_question_text'] = '\'{$a->qtype}\' input \'{$a->qid}\' (not embedded in question text).';
$string['subquestiontypenotinstalled'] = 'You are attempting to use a combined question with a sub-question type \'{$a}\' that is not installed.';
$string['subquestiontypes'] = 'Sub-question placeholders';
$string['subquestiontypes_help'] = 'You can place a variety of sub-questions inline within the question text, including unmarked \'show working\' boxes. Each sub-question placeholder is composed of two to four parts. Each part is separated by a colon (:).

* Name: this is used for the specific sub-question in this authoring form, but will also display to students if they forget to respond as part of their answer. For this reason, we use the pattern of \'Part_n\' (where the underscore is converted to a space), as this should also make sense to a student, but it is fully customisable.
* Sub-question type: Combined currently supports \'multiple response\', \'numeric\', \'pattern match\', \'select menu\' (drop-downs), and \'single choice\'. It also allows a \'show your workings\' area.
* Response direction or field size: this varies by sub-question type. \'Multiple response\' and \'single choice\' allow the responses to be listed vertically (v) or horizontally (h). \'Numeric\', \'pattern match\', and \'show working\' (plain text mode only) allow you to set the input field or area size through double underlines and a value, such as *__10__* or *__20x2__*. For \'selectmenu\', you specify the correct answer in the choice list (note that you can reuse the same selectmenu multiple times).
* \'Show working\' has one final configuration setting: although it defaults to a text editor, you can set it to use plain text through adding \':plain\' to the end, e.g. *[[Part_5:showworking:__10x3__:plain]]*.';
$string['updateform'] = 'Update the form';
$string['validationerror'] = 'Part of your answer requires attention: {$a}';
$string['validationerror_part'] = 'Part {$a->identifier} - {$a->error}';
$string['validationerrors'] = 'Parts of your answer require attention: {$a}';
$string['vertical_or_horizontal_embed_code'] = '[[{$a->qid}:{$a->qtype}:v]] or [[{$a->qid}:{$a->qtype}:h]] depending on if you want the options layed out vertically or horizontally.';
$string['weighting'] = 'Weighting';
$string['widthspecifier_embed_code'] = '[[{$a->qid}:{$a->qtype}:{width specifier}]] or just [[{$a->qid}:{$a->qtype}]]';
$string['yougot1right'] = '1 of your answers is correct.';
$string['yougotnright'] = '{$a->num} of your answers are correct.';
