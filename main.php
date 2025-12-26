<?php
include "connect.php";

$selectedHero = '';
$storyHtml = '';

if (isset($_GET['hero']) && $_GET['hero'] != '') {
    $selectedHero = mysqli_real_escape_string($con, $_GET['hero']);
    $query = "SELECT name, story FROM herostory WHERE name='$selectedHero'";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $storyHtml = "<div id='heroStory' style='display:none;'>";
        $storyHtml .= "<h2>📜 Story of " . ucfirst($row['name']) . "</h2>";
        $storyHtml .= "<p>" . nl2br($row['story']) . "</p>";
        $storyHtml .= "</div>";
    } else {
        $storyHtml = "<div id='heroStory' style='display:none;'><p>Story not found.</p></div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Bir Sreshtho Puzzle Game</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<!-- jQuery + jQuery UI -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container mt-4">
    <h2 class="text-center">🧩 Bir Sreshtho Puzzle</h2>

    <!-- HERO SELECT -->
    <form method="GET" action="">
        <div class="d-flex justify-content-center mb-3">
            <select name="hero" id="heroSelect" class="form-control w-50" onchange="this.form.submit()">
                <option value="">-- Select Bir Sreshtho --</option>
                <option value="jahangir" <?= ($selectedHero=='jahangir')?'selected':'' ?>>Captain Mohiuddin Jahangir</option>
                <option value="matiur" <?= ($selectedHero=='matiur')?'selected':'' ?>>Flight Lieutenant Matiur Rahman</option>
                <option value="noor" <?= ($selectedHero=='noor')?'selected':'' ?>>Lance Naik Noor Mohammad Sheikh</option>
                <option value="hamidur" <?= ($selectedHero=='hamidur')?'selected':'' ?>>Sepoy Hamidur Rahman</option>
                <option value="mostafa" <?= ($selectedHero=='mostafa')?'selected':'' ?>>Sepoy Mostafa Kamal</option>
                <option value="rouf" <?= ($selectedHero=='rouf')?'selected':'' ?>>Sepoy Munshi Abdur Rouf</option>
                <option value="ruhul" <?= ($selectedHero=='ruhul')?'selected':'' ?>>Engine Room Artificer Mohammad Ruhul Amin</option>
            </select>
        </div>
    </form>

    <div class="row">
        <!-- FULL IMAGE -->
        <div class="col-md-6 text-center">
            <?php if($selectedHero): ?>
                <img id="fullImage" class="hero-img" src="<?= $selectedHero ?>/hero.jpg">
                <p class="mt-2" id="heroName"><?= ucfirst($selectedHero) ?></p>
            <?php else: ?>
                <img id="fullImage" class="hero-img" src="" style="display:none;">
                <p class="mt-2" id="heroName"></p>
            <?php endif; ?>

            <!-- MESSAGE -->
            <p id="unlockMsg" class="text-info font-weight-bold mt-3">
                🔒 Solve the puzzle to unlock the story of the hero
            </p>
        </div>

        <!-- PUZZLE -->
        <div class="col-md-6">
            <ul id="puzzle">
                <?php
                if ($selectedHero) {
                    $pieces = range(1,9);
                    shuffle($pieces);
                    foreach ($pieces as $i) {
                        echo "<li id='$i'><img src='$selectedHero/$i.jpg'></li>";
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<!-- STORY HTML (outside container for full width) -->
<?= $storyHtml ?>

<script>
$("#puzzle").sortable({
    update: function () {
        let order = $(this).sortable("toArray").toString();
        if (order === "1,2,3,4,5,6,7,8,9") {
            $("#unlockMsg")
                .text("🔓 Puzzle solved! Story unlocked ✔")
                .removeClass("text-info")
                .addClass("text-success");

            // Reveal the story
            $("#heroStory").show();
        }
    }
});
</script>

</body>
</html>

