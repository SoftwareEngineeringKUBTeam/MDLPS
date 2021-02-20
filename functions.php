<?php



/* Function Name: printTable
 * Description: prints an HTML table based on data from the sqlite3 database
 * Parameters: (string) $name: the array of sql data being passed to the function
 */

function printTable($data) {
    if (count($data) === 0) {
        return;
    }
    $header = array_keys($data[0]);
    print "<table>\n";
    print "<tr>";
    foreach ($header as $h) {
        print "<th>$h</th>";
    }
    print "</tr>\n";
    foreach ($data as $record) {
        $values = array_values($record);
        print "<tr>";
        foreach ($values as $v) {
            print "<td>$v</td>";
        }
        print "</tr>\n";
    }
    print "</table>";
}

?>