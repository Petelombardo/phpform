<?php

// You may want to set your variables statically when you are done to make this a bit more secure.
foreach ($_REQUEST as $key=>$value) {
        $$key=$value;
}

function CleanString($text="") {
	// This function coalesces the question/title so that it can be used as a variable.
	$text=preg_replace("/ /","",$text);
	$text=preg_replace("/\-/","",$text);
        $text=preg_replace("/\(/","",$text);
        $text=preg_replace("/\)/","",$text);
	return $text;
}

function send_email($message="") {
	// Update this section to send emails
        $headers="From: Noreply <noreply@mydomain.com>\r\n";
	$headers.="Reply-To: noreply@mydomain.com\r\n";
	$headers.="Cc: noreply2@mydomain.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $subject="My Subject";
        $to="noreply@mydomain.com";
        mail($to,$subject,$message,$headers);
}

function get_description($text="") {
	if (empty($text)) return;
	return " <font size=-2>(".$text.")</font>\n";
}

class question {
	// This is the question object.   The only required fields are text, and choiceType.
	public $text;
	public $choiceType;
	public $defaultChoices=array();
	public $choices = array();
	public $align="center";
	public $width=20;
	public $description;
	public $preferred = array();
}

$questions=array();

// This is an example form.   You only need to customize the section titled BEGIN FORM to END FORM
// BEGIN FORM

$q = new question;
$q->text="Employee Name";
$q->choiceType="text";
$q->align="left";
$q->description="English";
array_push($questions,$q);

$q = new question;
$q->text="Hiring Manager";
$q->choiceType="text";
$q->align="right";
array_push($questions,$q);

$q = new question;
$q->text="Office Location";
$q->choiceType="select";
$q->defaultChoices=array("City1");
$q->choices=array("City1","City2","City3");
$q->align="left";
array_push($questions,$q);

$q = new question;
$q->text="Start Date";
$q->choiceType="date";
$q->align="right";
array_push($questions,$q);

$q = new question;
$q->text="Department";
$q->choiceType="select";
$q->choices=array("Administrative","Design","Finance","Human Resources","Marketing","Product Development","Product Management","Sales","Services","Information Technology","Internal Systems","Engineering Services","Product and Integrated Marketing");
$q->align="left";
array_push($questions,$q);

$q = new question;
$q->text="Title";
$q->choiceType="text";
$q->align="right";
array_push($questions,$q);

$q = new question;
$q->text="Status";
$q->choiceType="radio";
$q->choices=array("Full-Time","Temp");
$q->defaultChoices=array("Full-Time");
$q->preferred=array("Full-Time");
array_push($questions,$q);

$q = new question;
$q->text="Seat Location";
$q->choiceType="text";
$q->description="Location code or description.";
array_push($questions,$q);

$q = new question;
$q->text="Laptop Type";
$q->choiceType="radio";
$q->defaultChoices=array("PC");
$q->choices=array("PC","Mac");
$q->preferred=array("PC");
$q->align="left";
array_push($questions,$q);

$q = new question;
$q->text="Number of Monitors";
$q->choiceType="select";
$q->defaultChoices=array("2");
$q->choices=array("0","1","2","3");
$q->align="right";
$q->description="External";
array_push($questions,$q);

$q = new question;
$q->text="Standard Software";
$q->choiceType="checkbox";
$q->choices=array("Visual Studio 2015","Visual Studio 2013","Visual Studio 2010","Office 2013","Office 2016","Parallels");
$q->preferred=array("Visual Studio 2015","Office 2016");
$q->defaultChoices=array("Office 2016");
$q->align="left";
array_push($questions,$q);

$q = new question;
$q->text="Additional Software";
$q->choiceType="textarea";
$q->align="right";
array_push($questions,$q);

$q = new question;
$q->text="Access to Business Applications";
$q->choiceType="checkbox";
$q->choices=array("Salesforce","Dynamics");
array_push($questions,$q);

$q = new question;
$q->text="Company Mobile Phone";
$q->choiceType="radio";
$q->defaultChoices=array("No");
$q->choices=array("Yes","No");
$q->align="left";
array_push($questions,$q);

$q = new question;
$q->text="Tablet";
$q->choiceType="checkbox";
$q->choices=array("iPad","Android","Microsoft Surface");
$q->align="right";
array_push($questions,$q);

$q = new question;
$q->text="VPN Access";
$q->choiceType="radio";
$q->defaultChoices=array("Yes");
$q->choices=array("Yes","No");
$q->align="left";
array_push($questions,$q);

$q = new question;
$q->text="TFS Access";
$q->choiceType="radio";
$q->defaultChoices=array("No");
$q->choices=array("Yes","No");
$q->align="right";
array_push($questions,$q);


$q = new question;
$q->text="Shared Mailboxes";
$q->description="Please list any shared email boxes to grant access to.";
$q->choiceType="textarea";
array_push($questions,$q);

$q = new question;
$q->text="Security Groups";
$q->choiceType="textarea";
$q->description="List any known AD security groups.  Leave blank if unknown.";
array_push($questions,$q);

$q = new question;
$q->text="Other Notes";
$q->choiceType="textarea";
array_push($questions,$q);

// END FORM

$top="
<html>
<head>";
?>
<link rel="stylesheet" type="text/css" href="pikaday.css" media="all">
<?php
$top.="
<style>
div.button {
	box-shadow:5px 5px 3px #555555;
}
div.form {
	border-radius: 25px;
	border:1px solid #333333;
	background: #eeeeee;
	padding: 20px;
}
span.preferred {
	background-color: #fff5ce;
}
body
{
        background:#77aadd;
        font-family:\"Lucida Grande\", Tahoma, Arial, Verdana, sans-serif;
        font-size:small;
        margin:8px 20px 16px;
        text-align:left;
}
</style>
</head>
<body>
<center>
<br>
<h2><font color=#000000>New Hire Request Form (IT)</font></h2>
<br>
<br>
";
if ($action=="submit") {
	$notice="<b><font color=#cc0000>Thank you for submitting your request.  A ticket with this information has been created.</font></b><br><br>";
}
$message="
<table cellspacing=0 cellpadding=0 width=700>
<td align=center>
<div class='form'>
<table width=100% cellpadding=2 cellspacing=2>
<form method=POST id=\"form1\">
";
foreach ($questions as $q) {
	if ($q->align=="left") {
		$message.="<tr><td colspan=2 align=left><table cellspacing=0 cellpadding=0 width=100%>\n<td width=50% valign=top><table>\n";
	}
	$message.="<tr><td align=left colspan=2><b>".$q->text."</b>".get_description($q->description)."<br></td></tr>\n";
	$message.="<tr><td width=30>&nbsp;</td><td>";
	$name=CleanString($q->text);
	$text=$q->text;
	$value=$$name;
	if ($q->choiceType=="text") {
		$message.="<input type=text size='".$q->width."' name='".$name."' value='".$value."'>\n";
	} elseif ($q->choiceType=="select") {
		$message.="<select name='".$name."'>\n";
		asort($q->choices);
		foreach ($q->choices as $choice) {
			if ((in_array($choice,$q->defaultChoices) && empty($value)) || (!empty($value) && $choice==$value)) {
				$line="<option selected>".$choice."</option>\n";
			} else {
				$line="<option>".$choice."</option>\n";
			}
			if (in_array($choice,$q->preferred)) {
				$message.="<span style=\"background-color:#eeffee\">\n".$line."</span>\n";
			} else {
				$message.=$line;
			}
		}
		$message.="</select>\n";
	} elseif ($q->choiceType=="radio") {
		$message.="<table>";
               	foreach ($q->choices as $choice) {
			$message.="<tr>\n<td>";
                        if ((in_array($choice,$q->defaultChoices) && empty($value)) || (!empty($value) && $choice==$value)) {
                                $message.="<input type='radio' checked name='".$name."' value='".$choice."'>\n";
                        } else {
                                $message.="<input type='radio' name='".$name."' value='".$choice."'>\n";
                        }
                        $message.="</td>\n<td>";
                        if (in_array($choice,$q->preferred)) {
                                $message.="<span class=\"preferred\">".$choice."</style>\n";
                        } else {
                                $message.=$choice;
                        }
                        $message.="</td>\n</tr>\n";
		}
		$message.="</table>\n";
	} elseif ($q->choiceType=="checkbox") {
		$message.="<table>";
		asort($q->choices);
              	foreach ($q->choices as $choice) {
			$message.="<tr>\n<td>";
                        if ((in_array($choice,$q->defaultChoices) && empty($value)) || (is_array($value) && in_array($choice,$value))) {
                                $message.="<input type='checkbox' checked name='".$name."[]' value='".$choice."'>";
                        } else {
                                $message.="<input type='checkbox' name='".$name."[]' value='".$choice."'>";
                        }
			$message.="</td>\n<td>";
			if (in_array($choice,$q->preferred)) {
				$message.="<span class=\"preferred\">".$choice."</style>\n";
			} else {
				$message.=$choice;
			}
			$message.="</td>\n</tr>\n";
                }
		$message.="</table>\n";
	} elseif ($q->choiceType=="textarea") {
		$message.="<textarea rows=10 cols=40 name='".$name."'>".$value."</textarea>\n";
	} elseif ($q->choiceType=="date") {
		$message.="<input name='".$name."' type=\"text\" id=\"datepicker\" value='".$value."'>\n";
	}
	$message.="</td>\n";
	$message.="</tr>\n<tr><td height=30 colspan=2>&nbsp;</td></tr>\n";
	if ($q->align=="left") {
		$message.="</table></td><td width=50% align=left valign=top><table>\n";
	}
	if ($q->align=="right") {
		$message.="</table></td></table></td></tr>\n";
	}
}

$message.="
</table>
</td>
</table>
</div>
";
print $top.$notice.$message;
?>
<br>
<table width=700>
<tr><td width=50% align=center valign=center>
<button form="form1" type=submit style="border: none;padding: 0px 0px;"><div class='button' style="background-color:#bbeebb; border:1px; padding:1px 1px;"><font size=+1>Submit</font></div></button>
<input type=hidden name='action' value='submit'>
</form>
</td>
<form method=POST id="form2">
<td width=50% align=center valign=center>
<button form="form2" type=submit style="border: none;padding: 0px 0px;"><div class='button' style="background-color:#eebbbb; border:1px; padding:1px 1px;"><font size=+1>Reset/Clear</font></div></button>
</form>
</td>
</table>
<script src="pikaday.js"></script>
<script>
    var picker = new Pikaday({ field: document.getElementById('datepicker') });
</script>
<?

if ($action=="submit") {
	$message=$top.$message."</body></html>";
	send_email($message);
}
