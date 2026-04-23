<?php
require_once 'php/config.php';
$db = getDB();
$servizi = $db->query("SELECT id,nome,icona FROM servizi WHERE attivo=1 ORDER BY ordine")->fetchAll();
$msg = ''; $ok = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome   = trim($_POST['nome']    ?? '');
    $email  = trim($_POST['email']   ?? '');
    $tel    = trim($_POST['telefono']?? '');
    $az     = trim($_POST['azienda'] ?? '');
    $sid    = intval($_POST['servizio_id'] ?? 0);
    $descr  = trim($_POST['descrizione']  ?? '');
    $indir  = trim($_POST['indirizzo']    ?? '');
    $sup    = intval($_POST['superficie'] ?? 0) ?: null;
    $bud    = !empty($_POST['budget_est']) ? floatval($_POST['budget_est']) : null;
    if (!$nome||!$email||!$sid||!$descr) { $msg = 'Compila tutti i campi obbligatori (con *).'; }
    elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) { $msg = 'Indirizzo email non valido.'; }
    else {
        $chk=$db->prepare("SELECT id FROM utenti WHERE email=?"); $chk->execute([$email]); $uid=$chk->fetchColumn();
        if(!$uid){
            $p=explode(' ',$nome,2);
            $db->prepare("INSERT INTO utenti(username,email,password,nome,cognome,telefono,ruolo,azienda)VALUES(?,?,?,?,?,?,'cliente',?)")
               ->execute([strtolower(str_replace(' ','.',substr($nome,0,20))).rand(10,99),$email,password_hash(uniqid(),PASSWORD_BCRYPT),$p[0],$p[1]??'-',$tel?:null,$az?:null]);
            $uid=$db->lastInsertId();
        }
        $db->prepare("INSERT INTO preventivi(cliente_id,servizio_id,nome_ref,email_ref,telefono_ref,azienda,descrizione,indirizzo,superficie,budget_est)VALUES(?,?,?,?,?,?,?,?,?,?)")
           ->execute([$uid,$sid,$nome,$email,$tel?:null,$az?:null,$descr,$indir?:null,$sup,$bud]);
        $ok=true; $msg='Richiesta inviata con successo!';
    }
}
$sel = intval($_GET['servizio'] ?? 0);
?>
<!DOCTYPE html><html lang="it">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Preventivo Gratuito &mdash; WiredSpace S.r.l.</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
<?php include 'php/navbar.php'; ?>

<div class="page-hdr">
  <div class="page-grid"></div>
  <div class="wrap">
    <div class="ey-l">Nessun impegno</div>
    <h1 class="animate__animated animate__fadeInLeft">Preventivo <span class="gt">gratuito</span></h1>
    <p>Sopralluogo senza costi &bull; Risposta entro 24 ore &bull; Proposta personalizzata</p>
  </div>
</div>

<section class="section">
  <div class="wrap">
    <div style="display:grid;grid-template-columns:340px 1fr;gap:2.5rem;align-items:start" class="two-col">

      <!-- SIDEBAR SINISTRA -->
      <div>
        <div class="card-premium" style="margin-bottom:1.5rem">
          <h3 style="font-family:var(--head);font-size:1.05rem;font-weight:800;margin-bottom:1.375rem;letter-spacing:-.03em;color:var(--white)">
            Come funziona
          </h3>
          <?php foreach([['01','Compili il modulo','Descrivi il progetto e le esigenze specifiche.'],['02','Sopralluogo gratuito','Un tecnico certificato viene da te senza costi.'],['03','Preventivo in 48h','Ricevi una proposta dettagliata e trasparente.'],['04','Si parte!','Iniziamo i lavori nei tempi concordati.']] as $s): ?>
          <div class="step-row">
            <div class="step-num"><?php echo $s[0]; ?></div>
            <div><div class="step-title"><?php echo $s[1]; ?></div><div class="step-desc"><?php echo $s[2]; ?></div></div>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="card-premium">
          <h3 style="font-family:var(--head);font-size:1.05rem;font-weight:800;margin-bottom:1.125rem;letter-spacing:-.03em;color:var(--white)">
            Perch&eacute; sceglierci
          </h3>
          <?php foreach(['KNX Partner Certified','ISO 9001:2015 certificati','Sopralluogo sempre gratuito','15 anni di esperienza','Risparmio energetico -40%','Assistenza H24 inclusa'] as $v): ?>
          <div class="check-item"><span class="check-ic">&#10003;</span><?php echo $v; ?></div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- FORM PRINCIPALE -->
      <div class="reveal">
        <?php if($ok): ?>
        <div class="success-box">
          <div class="success-icon">&#10003;</div>
          <h2>Richiesta inviata!</h2>
          <p>Ti contatteremo entro 24 ore lavorative con una proposta su misura. Controlla la tua email per la conferma.</p>
          <a href="index.php" class="btn btn-p">Torna alla home</a>
        </div>
        <?php else: ?>

        <?php if($msg): ?><div class="alert alert-err" style="margin-bottom:1.5rem"><?php echo esc($msg); ?></div><?php endif; ?>

        <div class="form-panel">
          <div class="form-section-title">Descrivi il tuo progetto</div>

          <form method="POST" novalidate>

            <div class="fg-grid-2" style="margin-bottom:1.25rem">
              <div class="fg">
                <label>Nome e cognome *</label>
                <input type="text" name="nome" required placeholder="Mario Rossi" value="<?php echo esc($_POST['nome']??''); ?>">
              </div>
              <div class="fg">
                <label>Email aziendale *</label>
                <input type="email" name="email" required placeholder="mario@azienda.it" value="<?php echo esc($_POST['email']??''); ?>">
              </div>
              <div class="fg">
                <label>Telefono</label>
                <input type="tel" name="telefono" placeholder="+39 347 1234567" value="<?php echo esc($_POST['telefono']??''); ?>">
              </div>
              <div class="fg">
                <label>Azienda / Ente</label>
                <input type="text" name="azienda" placeholder="Nome organizzazione" value="<?php echo esc($_POST['azienda']??''); ?>">
              </div>
            </div>

            <div class="fg" style="margin-bottom:1.25rem">
              <label>Servizio richiesto *</label>
              <select name="servizio_id" required>
                <option value="">&#128269; Seleziona il servizio di interesse</option>
                <?php foreach($servizi as $s): ?>
                <option value="<?php echo $s['id']; ?>"<?php echo ($sel==$s['id']||($_POST['servizio_id']??'')==$s['id'])?' selected':''; ?>><?php echo esc($s['icona'].' '.$s['nome']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="fg-grid-2" style="margin-bottom:1.25rem">
              <div class="fg">
                <label>Indirizzo immobile</label>
                <input type="text" name="indirizzo" placeholder="Via Roma 1, Milano" value="<?php echo esc($_POST['indirizzo']??''); ?>">
              </div>
              <div class="fg">
                <label>Superficie (m&sup2;)</label>
                <input type="number" name="superficie" placeholder="es. 350" min="1" value="<?php echo esc($_POST['superficie']??''); ?>">
              </div>
              <div class="fg" style="grid-column:1/-1">
                <label>Budget indicativo (&euro;) &mdash; opzionale</label>
                <input type="number" name="budget_est" placeholder="Inserisci un importo orientativo, non vincolante" min="0" step="500" value="<?php echo esc($_POST['budget_est']??''); ?>">
              </div>
            </div>

            <div class="fg" style="margin-bottom:2rem">
              <label>Descrizione del progetto *</label>
              <textarea name="descrizione" rows="5" required placeholder="Descrivi il tipo di edificio, le esigenze specifiche, eventuali sistemi gi&#224; presenti, tempistiche desiderate..."><?php echo esc($_POST['descrizione']??''); ?></textarea>
            </div>

            <button type="submit" class="btn btn-p" style="width:100%;justify-content:center;font-size:.95rem;padding:1.05rem 2rem">
              &#128203;&ensp;Invia richiesta di preventivo
            </button>

            <p style="margin-top:1rem;font-size:.72rem;color:var(--muted);text-align:center;font-weight:300;line-height:1.7">
              &#128274;&ensp;I tuoi dati sono al sicuro e non vengono mai ceduti a terzi.<br>
              Riceverai risposta entro il prossimo giorno lavorativo.
            </p>

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
