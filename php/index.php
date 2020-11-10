<html>
<head>
<style>
	thead td {
		white-space: nowrap;
		font-weight: 700;
	}
	td {
		padding: 0 .25em;
	}
}
</style>
</head>
<body>

<?php
require_once('db.php');

$time_start = microtime();
echo "Start time: " . $time_start;

//execute table header query, display results

//init fixed headers
$col_headers = array('DATE', 'COUNT', 'LAST ACCESS COUNT', 'CORP');

//get all roles
$roles_query = $db->query('SELECT DISTINCT users_details.job_role
	FROM users_details
	WHERE users_details.job_role <> ""
	ORDER BY 1 ASC');
$roles_query_substrings = array();

//construct query
while($role = $roles_query->fetch_assoc()) {
  $job_role = $role['job_role'];
  array_push($roles_query_substrings, 'SUM(CASE WHEN users_details.job_role="' . $job_role . '" THEN 1 ELSE 0 END) "' . $job_role . '"');

  //add all roles to col headers
  array_push($col_headers, $job_role);
}

?>

<table border="1"><thead>

<?php
echo '<tr><td>'.implode('</td><td>', $col_headers).'</td></tr>';
?>
</thead><tbody>
<?php

$pivot_query_string = 'SELECT DATE(users.created) DATE,
 	COUNT(users.created) "COUNT",
    COUNT(users.last_access) "LAST ACCESS",
    SUM(CASE WHEN users_details.job_role="" THEN 1 ELSE 0 END) CORP,';
$pivot_query_string .= implode(', ', $roles_query_substrings);
$pivot_query_string .= 'FROM users_details
LEFT JOIN users
ON users_details.user_id = users.id
WHERE DATE(users.created) BETWEEN "2020-04-21" AND "2020-10-31"
GROUP BY 1
ORDER BY 1';

//execute table body query, display results
$pivot_query = $db->query($pivot_query_string);
while($pivot_row = $pivot_query->fetch_row()) {
  echo '<tr><td>'.implode('</td><td>', $pivot_row).'</td></tr>';
}

?>

</tbody></table>

<?php

$time_end = microtime();
echo 'END TIME: ' . $time_end . '<br/>';
echo 'Elapsed time: ' . ($time_end - $time_start);

?>