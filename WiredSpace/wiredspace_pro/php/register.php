<?php
require_once 'config.php';
if(auth()){header('Location: ../dashboard.php');exit;}
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $nome=$_POST['nome']??'';$cogn=$_POST['cognome']??'';$user=$_POST['username']??'';$email=$_POST['email']??'';
    $tel=$_POST['telefono']??'';$az=$_POST['azienda']??'';$pw=$_POST['password']??'';$pw2=$_POST['confirm']??'';
    if(!$nome||!$cogn||!$user||!$email||!$pw||!$pw2){$err='Compila tutti i campi obbligatori.';}
    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){$err='Email non valida.';}
    elseif(strlen($pw)<8){$err='Password minimo 8 caratteri.';}
    elseif($pw!==$pw2){$err='Le password non coincidono.';}
    else{
        $db=getDB();$chk=$db->prepare("SELECT id FROM utenti WHERE username=? OR email=?");$chk->execute([$user,$email]);
        if($chk->fetch()){$err='Username o email gi&agrave; in uso.';}
        else{
            $db->prepare("INSERT INTO utenti (username,email,password,nome,cognome,telefono,ruolo,azienda) VALUES (?,?,?,?,?,?,'cliente',?)")
               ->execute([$user,$email,password_hash($pw,PASSWORD_BCRYPT),trim($nome),trim($cogn),$tel?:null,$az?:null]);
            $id=$db->lastInsertId();
            $_SESSION['uid']=$id;$_SESSION['username']=$user;$_SESSION['ruolo']='cliente';$_SESSION['nome']=trim($nome);
            header('Location: ../dashboard.php?welcome=1');exit;
        }
    }
}
$db=getDB();
?>
<!DOCTYPE html><html lang="it">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Registrazione &mdash; WiredSpace S.r.l.</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="auth-pg">
  <div class="auth-bx" style="max-width:500px">
    <div class="fp">
      <div style="text-align:center;margin-bottom:2rem">
        <div style="width:52px;height:52px;border-radius:13px;background:linear-gradient(135deg,var(--blue),var(--teal));display:flex;align-items:center;justify-content:center;margin:0 auto .875rem;box-shadow:0 0 24px var(--glow)">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="#fff"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <h2 style="font-family:var(--head);font-size:1.75rem;font-weight:800;letter-spacing:-.04em;margin-bottom:.25rem">Crea account</h2>
        <p class="auth-sub">Accedi all&#39;area clienti WiredSpace</p>
      </div>
      <?php if($err): ?><div class="alert alert-err"><?php echo $err; ?></div><?php endif; ?>
      <form method="POST">
        <div class="form-grid" style="margin-bottom:1.125rem">
          <div class="fg"><label>Nome *</label><input type="text" name="nome" required value="<?php echo esc($_POST['nome']??''); ?>"></div>
          <div class="fg"><label>Cognome *</label><input type="text" name="cognome" required value="<?php echo esc($_POST['cognome']??''); ?>"></div>
          <div class="fg"><label>Username *</label><input type="text" name="username" required value="<?php echo esc($_POST['username']??''); ?>"></div>
          <div class="fg"><label>Email *</label><input type="email" name="email" required value="<?php echo esc($_POST['email']??''); ?>"></div>
          <div class="fg"><label>Telefono</label><input type="tel" name="telefono" value="<?php echo esc($_POST['telefono']??''); ?>"></div>
          <div class="fg"><label>Azienda</label><input type="text" name="azienda" value="<?php echo esc($_POST['azienda']??''); ?>"></div>
          <div class="fg"><label>Password * (min. 8 caratteri)</label><input type="password" name="password"></div>
          <div class="fg"><label>Conferma password *</label><input type="password" name="confirm"></div>
        </div>
        <button type="submit" class="btn btn-p" style="width:100%;justify-content:center;padding:.95rem">Crea account</button>
      </form>
      <p style="text-align:center;margin-top:1.375rem;font-size:.83rem;color:var(--muted)">
        Hai gi&agrave; un account? <a href="login.php" style="color:var(--teal);font-weight:600">Accedi</a>
      </p>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
</body></html>
