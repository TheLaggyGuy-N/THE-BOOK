<?php
session_start();

$hiragana_rows = [
    'A'  => ['あ', 'い', 'う', 'え', 'お'],
    'Ka' => ['か', 'き', 'く', 'け', 'こ'],
    'Sa' => ['さ', 'し', 'す', 'せ', 'そ'],
    'Ta' => ['た', 'ち', 'つ', 'て', 'と'],
    'Na' => ['な', 'に', 'ぬ', 'ね', 'の'],
    'Ha' => ['は', 'ひ', 'ふ', 'へ', 'ほ'],
    'Ma' => ['ま', 'み', 'む', 'め', 'も'],
    'Ya' => ['や', 'ゆ', 'よ'],
    'Ra' => ['ら', 'り', 'る', 'れ', 'ろ'],
    'Wa' => ['わ', 'を', 'ん']
];

$romaji_map = [
    'あ'=>'a','い'=>'i','う'=>'u','え'=>'e','お'=>'o','か'=>'ka','き'=>'ki','く'=>'ku','け'=>'ke','こ'=>'ko',
    'さ'=>'sa','し'=>'shi','す'=>'su','せ'=>'se','そ'=>'so','た'=>'ta','ち'=>'chi','つ'=>'tsu','て'=>'te','と'=>'to',
    'な'=>'na','に'=>'ni','ぬ'=>'nu','ね'=>'ne','の'=>'no','は'=>'ha','ひ'=>'hi','ふ'=>'fu','へ'=>'he','ほ'=>'ho',
    'ま'=>'ma','み'=>'mi','む'=>'mu','め'=>'me','も'=>'mo','ya'=>'ya','ゆ'=>'yu','よ'=>'yo','ら'=>'ra','り'=>'ri',
    'る'=>'ru','れ'=>'re','ろ'=>'ro','わ'=>'wa','を'=>'wo','ん'=>'n'
];

// Inisialisasi session
if (!isset($_SESSION['streak'])) $_SESSION['streak'] = 0;
if (!isset($_SESSION['best_streak'])) $_SESSION['best_streak'] = 0;
if (!isset($_SESSION['selected_rows'])) $_SESSION['selected_rows'] = ['A'];

// Update pilihan baris
if (isset($_POST['update_rows'])) {
    $_SESSION['selected_rows'] = $_POST['rows'] ?? ['A'];
    $_SESSION['streak'] = 0; // Reset streak saat ganti mode
    unset($_SESSION['target']);
}

// Pool huruf
$current_pool = [];
foreach ($_SESSION['selected_rows'] as $row_name) {
    if (isset($hiragana_rows[$row_name])) {
        $current_pool = array_merge($current_pool, $hiragana_rows[$row_name]);
    }
}

if (!isset($_SESSION['target'])) {
    $_SESSION['target'] = $current_pool[array_rand($current_pool)];
}

$feedback = "";
if (isset($_POST['tebak'])) {
    $user_input = strtolower(trim($_POST['jawaban']));
    $target_huruf = $_SESSION['target'];
    $jawaban_benar = $romaji_map[$target_huruf];

    if ($user_input == $jawaban_benar) {
        $_SESSION['streak']++;
        if ($_SESSION['streak'] > $_SESSION['best_streak']) {
            $_SESSION['best_streak'] = $_SESSION['streak'];
        }
        $feedback = "<b style='color:green;'>BENAR!</b>";
        $_SESSION['target'] = $current_pool[array_rand($current_pool)];
    } else {
        $feedback = "<b style='color:red;'>SALAH! (Jawaban: $jawaban_benar)</b>";
        $_SESSION['streak'] = 0;
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Hiragana Mastery - Custom</title></head>
<body>
    <h3>Pilih Baris:</h3>
    <form method="post">
        <?php foreach ($hiragana_rows as $name => $chars): ?>
            <label style="margin-right: 10px; display: inline-block;">
                <input type="checkbox" name="rows[]" value="<?php echo $name; ?>" 
                <?php echo in_array($name, $_SESSION['selected_rows']) ? 'checked' : ''; ?>>
                <?php echo $name; ?>
            </label>
        <?php endforeach; ?>
        <button type="submit" name="update_rows">Update</button>
    </form>

    <hr>
    
    <!-- Bagian Streak & Pencapaian -->
    <p>🔥 Current Streak: <b><?php echo $_SESSION['streak']; ?></b> | 🏆 Best: <?php echo $_SESSION['best_streak']; ?></p>
    
    <?php if ($_SESSION['streak'] >= 10): ?>
        <p>⭐ <b>Pencapaian:</b> Kamu mulai menguasai dasar! Pertahankan!</p>
    <?php endif; ?>
    
    <?php if ($_SESSION['streak'] >= 25): ?>
        <p>🏆 <b>Pencapaian:</b> GOKIL! Ingatanmu setajam katana!</p>
    <?php endif; ?>

    <?php if ($_SESSION['streak'] >= 50): ?>
        <p>⭐ <b>Pencapaian:</b>Shessh gelo lanjutkan brooo</p>
    <?php endif; ?>
    
    <?php if ($_SESSION['streak'] >= 75): ?>
        <p>🏆 <b>Pencapaian:</b> SUPER ULTRA GOKIL</p>
    <?php endif; ?>

    <div style="font-size: 100px; margin: 10px 0;">
        <?php echo $_SESSION['target']; ?>
    </div>

    <form method="post">
        <input type="text" name="jawaban" autofocus autocomplete="off" placeholder="Ketik bunyi...">
        <button type="submit" name="tebak">Cek</button>
    </form>
    
    <p><?php echo $feedback; ?></p>

</body>
</html>