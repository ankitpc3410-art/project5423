<?php
require "config.php";
$search=trim($_GET['search']??''); $domain=trim($_GET['domain']??'');
$sql="SELECT * FROM innovation_projects WHERE 1"; $types=""; $params=[];
if($search!==''){ $sql.=" AND student_name LIKE ?"; $types.="s"; $params[]="%$search%"; }
if($domain!==''){ $sql.=" AND domain=?"; $types.="s"; $params[]=$domain; }
$sql.=" ORDER BY id DESC";
$stmt=$conn->prepare($sql); if($types) $stmt->bind_param($types,...$params); $stmt->execute(); $result=$stmt->get_result();
$total=$conn->query("SELECT COUNT(*) c FROM innovation_projects")->fetch_assoc()['c'];
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Projects</title>
        <link rel="stylesheet" href="style.css"></head>
<body>

    <nav class="nav">
    <div class="inner">
        <strong>Innovation Center</strong>
    <div class="links">
        <a href="index.php">Register</a>
        <a href="display.php">Projects</a>
    </div>
</div>
</nav>
<div class="container">
<div class="dashboard">
    <div class="stat">Total Projects<b><?= $total ?></b></div>
    <div class="stat">Search by Student Name<b>🔎</b>
</div>
<div class="stat">Filter by Domain<b>⚙</b></div>
</div>
<div class="card">
    <h1>All Projects</h1>
<form class="filters" method="get">
    <input name="search" value="<?=htmlspecialchars($search)?>" placeholder="Student name">
<select name="domain">
    <option value="">All Domains</option><?php foreach(['AI','IoT','Web','Robotics','Embedded'] as $d): ?>
    <option <?= $domain===$d?'selected':'' ?>><?=$d?></option><?php endforeach; ?>
</select>
<button class="btn" style="margin:0">Search</button>
</form>
<div class="table-wrap">
    <table>
        <tr>
            <th>Poster</th>
            <th>Project</th>
            <th>Student</th>
            <th>College</th>
            <th>Domain</th>
            <th>Contact</th>
            <th>Actions</th>
        </tr>
<?php while($r=$result->fetch_assoc()): ?>
    <tr>
        <td>
            <img class="poster" src="uploads/<?=htmlspecialchars($r['poster'])?>" alt="Poster">
        </td>
        <td>
            <b><?=htmlspecialchars($r['project_title'])?></b>
            <br>
            <?=htmlspecialchars($r['description'])?>
        </td>
        <td><?=htmlspecialchars($r['student_name'])?>
        <br>
        <span class="badge"><?=htmlspecialchars($r['branch'])?></span>
        </td>
        <td><?=htmlspecialchars($r['college_name'])?></td>
        <td>
            <span class="badge"><?=htmlspecialchars($r['domain'])?></span>
        </td>
        <td><?=htmlspecialchars($r['email'])?>
        <br>
        <?=htmlspecialchars($r['mobile'])?>
        <br>
        <a href="<?=htmlspecialchars($r['github_link'])?>" target="_blank">GitHub</a>
        </td>
        <td>
            <a class="btn" href="edit.php?id=<?=$r['id']?>">Edit</a>
            <br>
            <a class="btn danger" href="delete.php?id=<?=$r['id']?>" 
            onclick="return confirm('Delete this project and its poster?')">
                Delete
            </a>
        </td>
</tr>
<?php endwhile; ?>
</table>
</div>
</div>
</div>
</body>
</html>