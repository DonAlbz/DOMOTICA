<?php
require_once 'php/config.php';
requireAuth('php/login.php');
$db  = getDB();
$uid = $_SESSION['uid'];
$ruolo = $_SESSION['ruolo'];
$utente = $db->prepare("SELECT * FROM utenti WHERE id=?")->execute([$uid]) && false ?: ($s=$db->prepare("SELECT * FROM utenti WHERE id=?")) && $s->execute([$uid]) && ($u=$s->fetch()) ? $u : [];
if(!$utente){ $s=$db->prepare("SELECT * FROM utenti WHERE id=?"); $s->execute([$uid]); $utente=$s->fetch(); }
$preventivi=[]; $progetti=[]; $interventi=[];
if(isAdmin()||isTecnico()){
    $preventivi=$db->query("SELECT pv.*,s.nome AS serv_nome,s.icona,u.nome AS cl_nome,u.cognome AS cl_cogn,u.email AS cl_email,u.azienda FROM preventivi pv JOIN servizi s ON pv.servizio_id=s.id JOIN utenti u ON pv.cliente_id=u.id ORDER BY pv.data_rich DESC LIMIT 20")->fetchAll();
    $progetti=$db->query("SELECT p.*,s.nome AS serv_nome,u.nome AS cl_nome,u.cognome AS cl_cogn,u.azienda,t.nome AS tec_nome,t.cognome AS tec_cogn FROM progetti p JOIN servizi s ON p.servizio_id=s.id JOIN utenti u ON p.cliente_id=u.id LEFT JOIN utenti t ON p.tecnico_id=t.id ORDER BY p.data_inizio DESC LIMIT 20")->fetchAll();
} else {
    $s=$db->prepare("SELECT pv.*,s.nome AS serv_nome,s.icona FROM preventivi pv JOIN servizi s ON pv.servizio_id=s.id WHERE pv.cliente_id=? ORDER BY pv.data_rich DESC"); $s->execute([$uid]); $preventivi=$s->fetchAll();
    $s2=$db->prepare("SELECT p.*,s.nome AS serv_nome,s.icona FROM progetti p JOIN servizi s ON p.servizio_id=s.id WHERE p.cliente_id=? ORDER BY p.data_inizio DESC"); $s2->execute([$uid]); $progetti=$s2->fetchAll();
    $s3=$db->prepare("SELECT iv.*,p.titolo AS prog_titolo FROM interventi iv JOIN progetti p ON iv.progetto_id=p.id WHERE p.cliente_id=? ORDER BY iv.data_interv DESC LIMIT 10"); $s3->execute([$uid]); $interventi=$s3->fetchAll();
}
?>
<!DOCTYPE html><html lang="it">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Dashboard &mdash; WiredSpace S.r.l.</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
<?php include 'php/navbar.php'; ?>
<div class="dash-hdr">
  <div class="wrap">
    <div class="ey-l"><?php echo ucfirst($ruolo); ?></div>
    <h1>Ciao, <span class="gt"><?php echo esc($utente['nome']??'Utente'); ?></span></h1>
    <p style="color:var(--muted);margin-top:.25rem;font-weight:300"><?php echo esc($utente['azienda']??'Area personale WiredSpace'); ?></p>
  </div>
</div>
<section style="padding:2.5rem 0 6rem">
  <div class="wrap">
    <?php if(isset($_GET['welcome'])): ?>
    <div class="alert alert-ok animate__animated animate__fadeIn" style="margin-bottom:1.5rem">&#127881; Account creato con successo! Benvenuto in WiredSpace.</div>
    <?php endif; ?>

    <!-- KPI -->
    <div class="dash-kpi-g">
      <div class="dash-kpi">
        <div class="dk-ico dk-b">&#128203;</div>
        <div><div class="dk-num"><?php echo count($preventivi); ?></div><div class="dk-lbl">Preventivi</div></div>
      </div>
      <div class="dash-kpi">
        <div class="dk-ico dk-g">&#127959;</div>
        <div><div class="dk-num"><?php echo count($progetti); ?></div><div class="dk-lbl">Progetti</div></div>
      </div>
      <div class="dash-kpi">
        <div class="dk-ico dk-y">&#128295;</div>
        <div><div class="dk-num"><?php echo count($interventi); ?></div><div class="dk-lbl">Interventi</div></div>
      </div>
      <div class="dash-kpi">
        <div class="dk-ico dk-c">&#128274;</div>
        <div><div class="dk-num" style="color:var(--teal)">OK</div><div class="dk-lbl">Sistema attivo</div></div>
      </div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
      <button class="tab-btn active" onclick="showTab('prev',this)">&#128203; Preventivi (<?php echo count($preventivi); ?>)</button>
      <button class="tab-btn" onclick="showTab('proj',this)">&#127959; Progetti (<?php echo count($progetti); ?>)</button>
      <?php if(!isAdmin()&&!isTecnico()): ?>
      <button class="tab-btn" onclick="showTab('int',this)">&#128295; Interventi (<?php echo count($interventi); ?>)</button>
      <?php endif; ?>
      <?php if(isAdmin()): ?><a href="admin.php" class="btn btn-sm btn-g" style="margin-left:auto;text-decoration:none">&#9881; Pannello Admin</a><?php endif; ?>
    </div>

    <!-- Preventivi -->
    <div class="tab-pane active" id="tab-prev">
      <?php if(empty($preventivi)): ?>
      <div style="text-align:center;padding:3rem 0">
        <p style="color:var(--muted)">Nessun preventivo ancora. <a href="preventivo.php" style="color:var(--teal)">Richiedine uno</a>.</p>
      </div>
      <?php else: ?>
      <div class="tbl">
        <table>
          <thead><tr>
            <th>Servizio</th>
            <?php if(isAdmin()||isTecnico()): ?><th>Cliente</th><?php endif; ?>
            <th>Data</th><th>Budget</th><th>Stato</th>
            <?php if(isAdmin()||isTecnico()): ?><th>Proposta</th><?php endif; ?>
          </tr></thead>
          <tbody>
            <?php foreach($preventivi as $pv):
              $bc=match($pv['stato']??''){
                'nuovo'=>'b-blue','in_lavorazione'=>'b-yellow','inviato'=>'b-blue',
                'accettato'=>'b-green','rifiutato'=>'b-red',default=>'b-gray'};
            ?>
            <tr>
              <td><?php echo esc(($pv['icona']??'').' '.($pv['serv_nome']??'')); ?></td>
              <?php if(isAdmin()||isTecnico()): ?>
              <td><strong><?php echo esc(($pv['cl_nome']??'').' '.($pv['cl_cogn']??'')); ?></strong><br><small style="color:var(--muted)"><?php echo esc($pv['azienda']??$pv['cl_email']??''); ?></small></td>
              <?php endif; ?>
              <td><?php echo isset($pv['data_rich'])?date('d/m/Y',strtotime($pv['data_rich'])):'&mdash;'; ?></td>
              <td><?php echo $pv['budget_est']?'&euro; '.number_format($pv['budget_est'],0,',','.'):'&mdash;'; ?></td>
              <td><span class="badge <?php echo $bc; ?>"><?php echo ucfirst(str_replace('_',' ',$pv['stato']??'')); ?></span></td>
              <?php if(isAdmin()||isTecnico()): ?>
              <td><?php echo $pv['importo_prop']?'<strong style="color:var(--teal)">&euro; '.number_format($pv['importo_prop'],0,',','.').'</strong>':'&mdash;'; ?></td>
              <?php endif; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>

    <!-- Progetti -->
    <div class="tab-pane" id="tab-proj">
      <?php if(empty($progetti)): ?>
      <div style="text-align:center;padding:3rem 0"><p style="color:var(--muted)">Nessun progetto attivo.</p></div>
      <?php else: ?>
      <div class="tbl">
        <table>
          <thead><tr>
            <th>Progetto</th>
            <?php if(isAdmin()||isTecnico()): ?><th>Cliente</th><th>Tecnico</th><?php endif; ?>
            <th>Servizio</th><th>Stato</th><th>Budget</th>
          </tr></thead>
          <tbody>
            <?php foreach($progetti as $p):
              $bc=match($p['stato']??''){
                'completato'=>'b-green','in_corso'=>'b-blue','richiesta'=>'b-yellow',default=>'b-gray'};
            ?>
            <tr>
              <td><strong><?php echo esc($p['titolo']); ?></strong><?php if($p['indirizzo']??''): ?><br><small style="color:var(--muted)">&#128205; <?php echo esc($p['indirizzo']); ?></small><?php endif; ?></td>
              <?php if(isAdmin()||isTecnico()): ?>
              <td><?php echo esc($p['azienda']??($p['cl_nome']??'').' '.($p['cl_cogn']??'')); ?></td>
              <td><?php echo $p['tec_nome']?esc($p['tec_nome'].' '.$p['tec_cogn']):'<span style="color:var(--muted)">—</span>'; ?></td>
              <?php endif; ?>
              <td><?php echo esc($p['serv_nome']??''); ?></td>
              <td><span class="badge <?php echo $bc; ?>"><?php echo ucfirst(str_replace('_',' ',$p['stato']??'')); ?></span></td>
              <td><?php echo $p['budget']?'&euro; '.number_format($p['budget'],0,',','.'):'&mdash;'; ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>

    <!-- Interventi (solo clienti) -->
    <?php if(!isAdmin()&&!isTecnico()): ?>
    <div class="tab-pane" id="tab-int">
      <?php if(empty($interventi)): ?>
      <div style="text-align:center;padding:3rem 0"><p style="color:var(--muted)">Nessun intervento registrato.</p></div>
      <?php else: ?>
      <div class="tbl">
        <table>
          <thead><tr><th>Progetto</th><th>Tipo</th><th>Data</th><th>Ore</th><th>Esito</th></tr></thead>
          <tbody>
            <?php foreach($interventi as $iv):
              $bc=match($iv['esito']??''){
                'completato'=>'b-green','da_completare'=>'b-yellow',default=>'b-red'};
            ?>
            <tr>
              <td><?php echo esc($iv['prog_titolo']); ?></td>
              <td><?php echo ucfirst(str_replace('_',' ',$iv['tipo']??'')); ?></td>
              <td><?php echo isset($iv['data_interv'])?date('d/m/Y',strtotime($iv['data_interv'])):'&mdash;'; ?></td>
              <td><?php echo $iv['ore_lavoro']?$iv['ore_lavoro'].'h':'&mdash;'; ?></td>
              <td><span class="badge <?php echo $bc; ?>"><?php echo ucfirst(str_replace('_',' ',$iv['esito']??'')); ?></span></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <div style="margin-top:2.5rem;display:flex;gap:1rem;flex-wrap:wrap">
      <a href="preventivo.php" class="btn btn-p">&#128203; Nuovo preventivo</a>
      <a href="contatti.php" class="btn btn-g">&#9993; Contatta l&#39;assistenza</a>
      <a href="php/logout.php" class="btn btn-danger btn-sm" style="margin-left:auto">Esci</a>
    </div>
  </div>
</section>
<?php include 'php/footer.php'; ?>
<script src="js/main.js"></script>
</body></html>
