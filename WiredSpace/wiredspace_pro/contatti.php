<?php
require_once 'php/config.php';
$db = getDB();
$msg=''; $ok=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
    $nome=trim($_POST['nome']??''); $email=trim($_POST['email']??'');
    $tel=trim($_POST['telefono']??''); $ogg=trim($_POST['oggetto']??''); $mess=trim($_POST['messaggio']??'');
    if(!$nome||!$email||!$ogg||!$mess){ $msg='Compila tutti i campi obbligatori.'; }
    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){ $msg='Indirizzo email non valido.'; }
    else{
        $db->prepare("INSERT INTO contatti(nome,email,telefono,oggetto,messaggio)VALUES(?,?,?,?,?)")->execute([$nome,$email,$tel?:null,$ogg,$mess]);
        $ok=true; $msg='Messaggio inviato con successo!';
    }
}
?>
<!DOCTYPE html><html lang="it">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Contatti &mdash; WiredSpace S.r.l.</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
<?php include 'php/navbar.php'; ?>

<div class="page-hdr">
  <div class="page-grid"></div>
  <div class="wrap">
    <div class="ey-l">Siamo qui per te</div>
    <h1 class="animate__animated animate__fadeInLeft">Contattaci</h1>
    <p>Risposta garantita entro 24 ore lavorative &bull; Assistenza H24 per i clienti con contratto</p>
  </div>
</div>

<section class="section">
  <div class="wrap">
    <div style="display:grid;grid-template-columns:340px 1fr;gap:2.5rem;align-items:start" class="two-col">

      <!-- INFO -->
      <div class="rl">
        <div class="info-card" style="margin-bottom:1.5rem">
          <h3 style="font-family:var(--head);font-size:1.05rem;font-weight:800;margin-bottom:1.375rem;letter-spacing:-.03em">
            Recapiti
          </h3>
          <?php foreach([
            ['&#128222;','Telefono','<a href="tel:+390212345678" style="color:var(--teal)">+39 02 1234567</a>'],
            ['&#9993;','Email','<a href="mailto:info@wiredspace.it" style="color:var(--teal)">info@wiredspace.it</a>'],
            ['&#128205;','Sede','Via Tecnologia 12<br>25100 Brescia (BS), Italia'],
            ['&#128336;','Orari','Lun&ndash;Ven: 8:30&ndash;18:00<br>Sabato: 9:00&ndash;13:00'],
            ['&#128680;','Emergenze','Assistenza H24 per clienti con contratto di manutenzione'],
          ] as [$ic,$lab,$val]): ?>
          <div class="info-row">
            <div class="info-ico"><?php echo $ic; ?></div>
            <div><div class="info-lbl"><?php echo $lab; ?></div><div class="info-val"><?php echo $val; ?></div></div>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="card-premium">
          <h3 style="font-family:var(--head);font-size:1.05rem;font-weight:800;margin-bottom:1.125rem;letter-spacing:-.03em">
            Possiamo aiutarti con
          </h3>
          <?php foreach(['Richieste di preventivo','Informazioni sui servizi','Assistenza tecnica post-vendita','Contratti di manutenzione','Partnership e collaborazioni','Segnalazione guasti urgenti'] as $v): ?>
          <div class="check-item"><span class="check-ic">&#10003;</span><?php echo $v; ?></div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- FORM -->
      <div class="reveal">
        <?php if($ok): ?>
        <div class="success-box">
          <div class="success-icon">&#9993;</div>
          <h2>Messaggio inviato!</h2>
          <p>Il tuo messaggio &egrave; stato ricevuto. Ti risponderemo entro il prossimo giorno lavorativo.</p>
          <a href="index.php" class="btn btn-p">Torna alla home</a>
        </div>
        <?php else: ?>

        <?php if($msg): ?><div class="alert alert-err" style="margin-bottom:1.5rem"><?php echo esc($msg); ?></div><?php endif; ?>

        <div class="form-panel">
          <div class="form-section-title">Inviaci un messaggio</div>
          <form method="POST" novalidate>
            <div class="fg-grid-2" style="margin-bottom:1.25rem">
              <div class="fg"><label>Nome *</label><input type="text" name="nome" required placeholder="Mario Rossi" value="<?php echo esc($_POST['nome']??''); ?>"></div>
              <div class="fg"><label>Email *</label><input type="email" name="email" required placeholder="mario@azienda.it" value="<?php echo esc($_POST['email']??''); ?>"></div>
              <div class="fg"><label>Telefono</label><input type="tel" name="telefono" placeholder="+39 347 1234567" value="<?php echo esc($_POST['telefono']??''); ?>"></div>
              <div class="fg"><label>Oggetto *</label><input type="text" name="oggetto" required placeholder="Come possiamo aiutarti?" value="<?php echo esc($_POST['oggetto']??''); ?>"></div>
            </div>
            <div class="fg" style="margin-bottom:2rem">
              <label>Messaggio *</label>
              <textarea name="messaggio" rows="6" required placeholder="Descrivi le tue esigenze nel dettaglio. Pi&#249; informazioni ci dai, pi&#249; precisa sar&#224; la nostra risposta."><?php echo esc($_POST['messaggio']??''); ?></textarea>
            </div>
            <button type="submit" class="btn btn-p" style="width:100%;justify-content:center;font-size:.95rem;padding:1.05rem 2rem">
              &#9993;&ensp;Invia messaggio
            </button>
          </form>
        </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

<?php include 'php/footer.php'; ?>
<script src="js/main.js"></script>
</body></html>
