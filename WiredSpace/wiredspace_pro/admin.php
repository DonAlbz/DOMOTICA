<?php
require_once 'php/config.php';;
if (!isAdmin()) { header('Location: index.php'); exit; }
$db = getDB();

$msg = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $a = $_POST['azione']??'';
    if ($a==='upd_preventivo') {
        $db->prepare("UPDATE preventivi SET stato=?,importo_prop=?,note_admin=? WHERE id=?")
           ->execute([$_POST['stato'],($_POST['importo']?:null),$_POST['note']?:null,intval($_POST['pid'])]);
        $msg='✅ Preventivo aggiornato.';
    }
    if ($a==='del_contatto') {
        $db->prepare("DELETE FROM contatti WHERE id=?")->execute([intval($_POST['cid'])]);
        $msg='🗑️ Messaggio eliminato.';
    }
    if ($a==='leggi_contatto') {
        $db->prepare("UPDATE contatti SET letto=1 WHERE id=?")->execute([intval($_POST['cid'])]);
    }
    header("Location: admin.php?msg=".urlencode($msg)); exit;
}
if (isset($_GET['msg'])) $msg=$_GET['msg'];

$preventivi = $db->query("SELECT pr.*,s.nome AS serv_nome,s.icona,u.nome AS cl_nome,u.cognome AS cl_cogn,u.azienda,u.email AS cl_email FROM preventivi pr JOIN servizi s ON pr.servizio_id=s.id JOIN utenti u ON pr.cliente_id=u.id ORDER BY pr.data_rich DESC")->fetchAll();
$progetti   = $db->query("SELECT p.*,s.nome AS serv_nome,u.nome AS cl_nome,u.cognome AS cl_cogn,u.azienda,t.nome AS tec_nome,t.cognome AS tec_cogn FROM progetti p JOIN servizi s ON p.servizio_id=s.id JOIN utenti u ON p.cliente_id=u.id LEFT JOIN utenti t ON p.tecnico_id=t.id ORDER BY p.data_crea DESC")->fetchAll();
$utenti     = $db->query("SELECT * FROM utenti ORDER BY data_reg DESC")->fetchAll();
$contatti   = $db->query("SELECT * FROM contatti ORDER BY data_inv DESC")->fetchAll();
$unread     = $db->query("SELECT COUNT(*) FROM contatti WHERE letto=0")->fetchColumn();

$stats = $db->query("SELECT
  (SELECT COUNT(*) FROM preventivi WHERE stato='nuovo') AS prev_nuovi,
  (SELECT COUNT(*) FROM progetti WHERE stato='in_corso') AS prog_attivi,
  (SELECT COUNT(*) FROM utenti WHERE ruolo='cliente') AS clienti,
  (SELECT COUNT(*) FROM contatti WHERE letto=0) AS msg_unread
")->fetch();
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Admin – WiredSpace</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'php/navbar.php'; ?>
<div class="dash-header">
  <div class="container">
    <span class="section-label">Pannello di controllo</span>
    <h1 class="section-title">⚙️ Admin <span class="text-accent">WiredSpace</span></h1>
  </div>
</div>
<section class="section" style="padding:3rem 0">
<div class="container">
  <?php if($msg): ?><div class="alert alert-success animate__animated animate__fadeIn"><?= esc($msg) ?></div><?php endif; ?>

  <!-- Stats rapide -->
  <div class="dash-grid" style="margin-bottom:2.5rem">
    <div class="dash-card"><div class="dash-icon dash-icon-yellow">📋</div><div><p class="dash-num"><?= $stats['prev_nuovi'] ?></p><p class="dash-label">Preventivi nuovi</p></div></div>
    <div class="dash-card"><div class="dash-icon dash-icon-blue">🏗️</div><div><p class="dash-num"><?= $stats['prog_attivi'] ?></p><p class="dash-label">Progetti attivi</p></div></div>
    <div class="dash-card"><div class="dash-icon dash-icon-green">👥</div><div><p class="dash-num"><?= $stats['clienti'] ?></p><p class="dash-label">Clienti</p></div></div>
    <div class="dash-card"><div class="dash-icon dash-icon-cyan">✉️</div><div><p class="dash-num"><?= $stats['msg_unread'] ?></p><p class="dash-label">Messaggi non letti</p></div></div>
  </div>

  <!-- Tab nav -->
  <div class="tab-nav">
    <button class="tab-btn active" onclick="showTab('preventivi',this)">📋 Preventivi (<?= count($preventivi) ?>)</button>
    <button class="tab-btn" onclick="showTab('progetti',this)">🏗️ Progetti (<?= count($progetti) ?>)</button>
    <button class="tab-btn" onclick="showTab('utenti',this)">👥 Utenti (<?= count($utenti) ?>)</button>
    <button class="tab-btn" onclick="showTab('contatti',this)">✉️ Messaggi<?= $unread ? " <span style='background:var(--danger);border-radius:999px;padding:.1rem .4rem;font-size:.7rem;margin-left:.25rem'>$unread</span>" : '' ?></button>
  </div>

  <!-- Preventivi -->
  <div class="tab-panel active" id="tab-preventivi">
    <div class="table-wrap">
      <table>
        <thead><tr><th>Cliente</th><th>Servizio</th><th>Data</th><th>Budget</th><th>Stato</th><th>Importo proposto</th><th>Azioni</th></tr></thead>
        <tbody>
        <?php foreach($preventivi as $pv):
          $bc=match($pv['stato']){'nuovo'=>'badge-yellow','in_lavorazione'=>'badge-blue','inviato'=>'badge-blue','accettato'=>'badge-green','rifiutato'=>'badge-red',default=>'badge-gray'};
        ?><tr>
          <td><strong><?= esc($pv['cl_nome'].' '.$pv['cl_cogn']) ?></strong><br><small style="color:var(--muted)"><?= esc($pv['azienda']?:$pv['cl_email']) ?></small></td>
          <td><?= esc($pv['icona'].' '.$pv['serv_nome']) ?></td>
          <td><?= date('d/m/Y',strtotime($pv['data_rich'])) ?></td>
          <td><?= $pv['budget_est']?'€ '.number_format($pv['budget_est'],0,',','.'):'—' ?></td>
          <td><span class="badge <?= $bc ?>"><?= ucfirst(str_replace('_',' ',$pv['stato'])) ?></span></td>
          <td><?= $pv['importo_prop']?'<strong style="color:var(--accent)">€ '.number_format($pv['importo_prop'],0,',','.').'</strong>':'—' ?></td>
          <td>
            <button onclick="openModal(<?= $pv['id'] ?>,'<?= esc($pv['stato']) ?>',<?= $pv['importo_prop']?:0 ?>,'<?= esc(addslashes($pv['note_admin']??'')) ?>')" class="btn btn-sm" style="background:rgba(0,102,204,.2);border:1px solid rgba(0,102,204,.4);color:#60a5fa">✏️ Modifica</button>
          </td>
        </tr><?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Progetti -->
  <div class="tab-panel" id="tab-progetti">
    <div class="table-wrap">
      <table>
        <thead><tr><th>Titolo</th><th>Cliente</th><th>Tecnico</th><th>Servizio</th><th>Stato</th><th>Budget</th></tr></thead>
        <tbody>
        <?php foreach($progetti as $p):
          $bc=match($p['stato']){'completato'=>'badge-green','in_corso'=>'badge-blue','richiesta'=>'badge-yellow',default=>'badge-gray'};
        ?><tr>
          <td><strong><?= esc($p['titolo']) ?></strong></td>
          <td><?= esc($p['azienda']?:$p['cl_nome'].' '.$p['cl_cogn']) ?></td>
          <td><?= $p['tec_nome']?esc($p['tec_nome'].' '.$p['tec_cogn']):'<span style="color:var(--muted)">—</span>' ?></td>
          <td><?= esc($p['serv_nome']) ?></td>
          <td><span class="badge <?= $bc ?>"><?= ucfirst(str_replace('_',' ',$p['stato'])) ?></span></td>
          <td><?= $p['budget']?'€ '.number_format($p['budget'],0,',','.'):'—' ?></td>
        </tr><?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Utenti -->
  <div class="tab-panel" id="tab-utenti">
    <div class="table-wrap">
      <table>
        <thead><tr><th>#</th><th>Username</th><th>Nome</th><th>Email</th><th>Azienda</th><th>Ruolo</th><th>Registrato</th></tr></thead>
        <tbody>
        <?php foreach($utenti as $u):
          $bc=match($u['ruolo']){'admin'=>'badge-red','tecnico'=>'badge-blue',default=>'badge-green'};
        ?><tr>
          <td><?= $u['id'] ?></td>
          <td><strong><?= esc($u['username']) ?></strong></td>
          <td><?= esc($u['nome'].' '.$u['cognome']) ?></td>
          <td><?= esc($u['email']) ?></td>
          <td><?= esc($u['azienda']??'—') ?></td>
          <td><span class="badge <?= $bc ?>"><?= ucfirst($u['ruolo']) ?></span></td>
          <td><?= date('d/m/Y',strtotime($u['data_reg'])) ?></td>
        </tr><?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Contatti -->
  <div class="tab-panel" id="tab-contatti">
    <div class="table-wrap">
      <table>
        <thead><tr><th>Nome</th><th>Email</th><th>Oggetto</th><th>Data</th><th>Stato</th><th>Azioni</th></tr></thead>
        <tbody>
        <?php foreach($contatti as $c): ?><tr style="<?= !$c['letto']?'background:rgba(0,102,204,.06)':'' ?>">
          <td><strong><?= esc($c['nome']) ?></strong><?= $c['telefono']?'<br><small style="color:var(--muted)">'.esc($c['telefono']).'</small>':'' ?></td>
          <td><a href="mailto:<?= esc($c['email']) ?>" style="color:var(--accent)"><?= esc($c['email']) ?></a></td>
          <td><?= esc($c['oggetto']) ?><br><small style="color:var(--muted);font-size:.75rem"><?= esc(substr($c['messaggio'],0,60)).'…' ?></small></td>
          <td><?= date('d/m/Y H:i',strtotime($c['data_inv'])) ?></td>
          <td><?= $c['letto']?'<span class="badge badge-green">Letto</span>':'<span class="badge badge-yellow">Nuovo</span>' ?></td>
          <td style="display:flex;gap:.5rem">
            <?php if(!$c['letto']): ?><form method="POST" style="display:inline"><input type="hidden" name="azione" value="leggi_contatto"><input type="hidden" name="cid" value="<?= $c['id'] ?>"><button class="btn btn-sm" style="background:rgba(16,185,129,.2);border:1px solid rgba(16,185,129,.4);color:#6ee7b7">✓</button></form><?php endif; ?>
            <form method="POST" style="display:inline"><input type="hidden" name="azione" value="del_contatto"><input type="hidden" name="cid" value="<?= $c['id'] ?>"><button class="btn btn-sm btn-danger" data-confirm="Eliminare questo messaggio?">🗑️</button></form>
          </td>
        </tr><?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
</section>

<!-- Modal aggiorna preventivo -->
<div id="modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:999;display:none;align-items:center;justify-content:center;padding:1rem">
  <div style="background:var(--dark2);border:1px solid rgba(255,255,255,.1);border-radius:var(--radius-lg);padding:2rem;max-width:480px;width:100%">
    <h3 style="margin-bottom:1.5rem;font-weight:700">✏️ Aggiorna preventivo</h3>
    <form method="POST">
      <input type="hidden" name="azione" value="upd_preventivo">
      <input type="hidden" name="pid" id="modal-pid">
      <div class="form-group" style="margin-bottom:1rem"><label>Stato</label>
        <select name="stato" id="modal-stato">
          <?php foreach(['nuovo','in_lavorazione','inviato','accettato','rifiutato'] as $st): ?>
          <option value="<?= $st ?>"><?= ucfirst(str_replace('_',' ',$st)) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group" style="margin-bottom:1rem"><label>Importo proposto (€)</label><input type="number" name="importo" id="modal-importo" step="100" min="0"></div>
      <div class="form-group" style="margin-bottom:1.5rem"><label>Note interne</label><textarea name="note" id="modal-note" rows="3"></textarea></div>
      <div style="display:flex;gap:.75rem">
        <button type="submit" class="btn btn-accent" style="flex:1;justify-content:center">Salva</button>
        <button type="button" onclick="closeModal()" class="btn btn-outline" style="flex:1;justify-content:center">Annulla</button>
      </div>
    </form>
  </div>
</div>

<?php include 'php/footer.php'; ?>
<script src="js/main.js"></script>
<script>
function showTab(name,btn){
  document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
  document.getElementById('tab-'+name).classList.add('active');
  btn.classList.add('active');
}
function openModal(pid,stato,importo,note){
  document.getElementById('modal-pid').value=pid;
  document.getElementById('modal-stato').value=stato;
  document.getElementById('modal-importo').value=importo||'';
  document.getElementById('modal-note').value=note||'';
  document.getElementById('modal').style.display='flex';
}
function closeModal(){document.getElementById('modal').style.display='none';}
</script>
</body>
</html>
