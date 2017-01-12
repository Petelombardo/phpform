# phpform

This form uses the calendar from https://github.com/dbushell/Pikaday.  
<br>
Adding an element to the form is simple.  Add a block like this:
<br>
<pre>
// This is an example of a simple test question
$q = new question;
$q->text="Test Question";
$q->choiceType="text";
array_push($questions,$q);

// This is an example of an advanced test question
$q = new question;
$q->text="Favorite Cities";
$q->choiceType="checkbox";
$q->defaultChoices=array("City3");
$q->choices=array("City1","City2","City3");
$q->preferred=array("City1","City3");
$q->align="left";
array_push($questions,$q);
</pre>
<br>
<b>Question Attributes Explained</b>
<pre>
text            - The actual question/statement/heading; This attribute generates the variable as well
choiceType      - The type of input element. Choices are:  select, radio, date, text, textarea, checkbox
defaultChoices  - Always an array, this contains the choices that you wish to be pre-selected by default.
choices         - Always an array, this contains a list of items to choose from.
align           - Possible options: "left", "right", NULL/undefined.  
preferred       - Always an array, any choices that are listed in the array are highlighted.  These are recommended options.
</pre>
<br>
<b>Notes on Align</b>
<pre>
The align option values are "left", "right", or leave it blank for the default.
If you choose "left", the very next element should be "right".   Likewise, if an element has "right" set, then the element above it must be set to "left".  If you do not follow these rules, the formatting will not be properly set.  When the align setting is left blank, the element is automatically shown on the left-hand side with no option for another element to be on the right.  

There is no need for you to worry about adding variables.  It is done automatically.  The form will send a completed version, in HTML, to an email address of your choice.   If you want to add the information to a database, you would need to add the appropriate logic to it.
</pre>
