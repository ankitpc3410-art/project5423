<?php
include "db.php";

header("Content-Type: text/csv; charset=UTF-8");
header('Content-Disposition: attachment; filename="students.csv"');

$output = fopen("php://output", "w");

// Excel mein UTF-8 text sahi dikhane ke liye
fwrite($output, "\xEF\xBB\xBF");

fputcsv($output, [
    "ID", "Name", "Email", "Mobile","College",
    "Branch", "Technology", "duration(in months)","Skils","Address"
]);

$result = mysqli_query(
    $conn,
    "SELECT id, name, email, mobile, college, branch, technology, duration, skills, address
     FROM internship_students ORDER BY id ASC"
);

if (!$result) {
    fclose($output);
    exit("Unable to export student data.");
}

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, [
        $row['id'],
        $row['name'],
        $row['email'],
        $row['mobile'],
        $row['college'],
        $row['branch'],
        $row['technology'],
        $row['duration'],
        $row['skills'],
        $row['address']
    ]);
}

fclose($output);
exit;
?>