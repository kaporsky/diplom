<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin 3.0.7
|| # ---------------------------------------------------------------- # ||
|| # Copyright ©2000–2005 Jelsoft Enterprises Ltd. All Rights Reserved. ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| # http://www.vbulletin.com | http://www.vbulletin.com/license.html # ||
|| ############################[DGT-TEAM]############################## ||
\*======================================================================*/

error_reporting(E_ALL & ~E_NOTICE);

// ###################### Start getallforumsql #######################
function fetch_all_forums_sql()
{
	global $fpermscache, $bbuserinfo;

	foreach ($bbuserinfo['forumpermissions'] AS $forumid => $ugperms)
	{
		if (!($ugperms & CANVIEW))
		{
			$noforums[] = $forumid;
		}
	}
	if (sizeof($noforums) > 0)
	{
		return ' AND forumid NOT IN (' . implode(',', $noforums) . ')';
	}
	else
	{
		return '';
	}
}

// ###################### Start makejs #######################
function print_js($typename, $data, $dates)
{
	// make the javascript function definition
	global $DB_site, $vboptions;

	// make the function

	if ($DB_site->num_rows($data))
	{

		echo 'function ' . $typename . ' (';

		$firstline = $DB_site->fetch_array($data);

		$firstitem = false;
		foreach ($firstline AS $name => $value)
		{

			if ($firstitem)
			{
				echo ', ';
			}
			$firstitem = true;

			echo $name;

		}

		echo ")
		{\n";

		foreach ($firstline AS $name => $value)
		{

			if (in_array($name, $dates))
			{ // handling for date type variables
				echo "\tthis." . $name . ' = new Date((' . $name . " - $vboptions[hourdiff]) * 1000);\n";
			}
			else
		
			{
				echo "\tthis." . $name . ' = ' . $name . ";\n";
			}

		}

		echo "}\n\n"; // end function

		echo 'var ' . $typename . 's = new Array(' . $DB_site->num_rows($data) . ");\n\n";

		print_js_data($typename, $firstline, 1);

		$counter = 1;
		while ($datarow = $DB_site->fetch_array($data))
		{
			$counter++;

			print_js_data($typename, $datarow, $counter);
		}

		echo "\n\n";

	}
}

// ###################### Start printdata #######################
function print_js_data($typename, $datarow, $number)
{
	echo $typename . 's[' . ($number - 1) . '] = new ' . $typename . '(';

	$firstitem = false;
	foreach ($datarow AS $name => $value)
	{

		if ($firstitem)
		{
			echo ', ';
		}
		$firstitem = true;

		echo "'" . addslashes_js($value) . "'";

	}

	echo ");\n";
}

// ###################### Start makejs_array #######################
function print_js_array($typename, $data, $dates)
{
	global $vboptions;

	if (is_array($data))
	{
		// make the function

		echo 'function ' . $typename . ' (';

		reset($data);

		$firstline = current($data);
		$firstitem = false;
		foreach ($firstline AS $name => $value)
		{

			if ($firstitem)
			{
				echo ', ';
			}
			$firstitem = trues;

			echo $name;

		}

		echo ")
	{\n";

		reset ($firstline);

		foreach ($firstline AS $name => $value)
		{

			if (in_array($name, $dates))
			{ // handling for date type variables
				echo "\tthis." . $name . ' = new Date((' . $name . " - $vboptions[hourdiff]) * 1000);\n";
			}
			else
		
			{
				echo "\tthis." . $name . ' = ' . $name . ";\n";
			}

		}

		echo "}\n\n"; // end function

		echo 'var ' . $typename . 's = new Array(' . sizeof($data) . ");\n\n";

		print_js_data($typename, $firstline, 1);

		$counter = 1;
		while ($datarow = next($data))
		{
			$counter++;

			print_js_data($typename, $datarow, $counter);

		}
		echo "\n\n";

	}
}

/*======================================================================*\
|| ####################################################################
|| # Downloaded: 11:11, Sat Feb 19th 2005
|| # CVS: $RCSfile: functions_external.php,v $ - $Revision: 1.9 $
|| ####################################################################
\*======================================================================*/
?>