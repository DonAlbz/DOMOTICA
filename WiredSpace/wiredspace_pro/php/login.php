<?php
require_once 'config.php';
if(auth()){header('Location: ../dashboard.php');exit;}
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $u=trim($_POST['username']??'');$p=$_POST['password']??'';
    if(!$u||!$p){$err='Compila tutti i campi.';}
    else{
        $db2=getDB();$st=$db2->prepare("SELECT * FROM utenti WHERE (username=? OR email=?) LIMIT 1");
        $st->execute([$u,$u]);$row=$st->fetch();
        if($row&&password_verify($p,$row['password'])){
            $_SESSION['uid']=$row['id'];$_SESSION['username']=$row['username'];$_SESSION['ruolo']=$row['ruolo'];$_SESSION['nome']=$row['nome'];
            header('Location: ../dashboard.php');exit;
        }else{$err='Credenziali non valide.';}
    }
}
?>
<!DOCTYPE html><html lang="it">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Accedi &mdash; WiredSpace S.r.l.</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="auth-pg">
  <div class="auth-bx">
    <div class="fp">
      <div style="text-align:center;margin-bottom:2rem">
        <div style="width:52px;height:52px;border-radius:13px;background:linear-gradient(135deg,var(--blue),var(--teal));display:flex;align-items:center;justify-content:center;margin:0 auto .875rem;box-shadow:0 0 24px var(--glow)">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="#fff"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <h2 style="font-family:var(--head);font-size:1.75rem;font-weight:800;letter-spacing:-.04em;margin-bottom:.25rem">Bentornato</h2>
        <p class="auth-sub">Accedi alla tua area riservata WiredSpace</p>
      </div>
      <?php if($err): ?><div class="alert alert-err"><?php echo esc($err); ?></div><?php endif; ?>
      <form method="POST">
        <div style="display:flex;flex-direction:column;gap:1.125rem;margin-bottom:1.5rem">
          <div class="fg"><label>Username o Email</label><input type="text" name="username" required placeholder="mario.rossi" value="<?php echo esc($_POST['username']??''); ?>"></div>
          <div class="fg"><label>Password</label><input type="password" name="password" required placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"></div>
        </div>
        <button type="submit" class="btn btn-p" style="width:100%;justify-content:center;padding:.95rem">Accedi</button>
      </form>
      <p style="text-align:center;margin-top:1.375rem;font-size:.83rem;color:var(--muted)">
        Non hai un account? <a href="register.php" style="color:var(--teal);font-weight:600">Registrati</a>
      </p>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
</body></html>
