<?php
require_once 'php/config.php';
$db   = getDB();
$id   = intval($_GET['id'] ?? 0);
$tutti = $db->query("SELECT * FROM servizi WHERE attivo=1 ORDER BY ordine")->fetchAll();
$svc   = null;
if($id){ $st=$db->prepare("SELECT * FROM servizi WHERE id=?"); $st->execute([$id]); $svc=$st->fetch(); }
$simgs=[1=>'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80',
        2=>'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=800&q=80',
        3=>'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=800&q=80',
        4=>'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=800&q=80',
        5=>'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=800&q=80',
        6=>'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=800&q=80'];
$feats=[
  1=>['Sopralluogo e analisi tecnica gratuita','Progettazione KNX personalizzata','Installazione certificata con collaudo','Controllo da smartphone e tablet ovunque','Assistenza post-installazione 12 mesi'],
  2=>['Analisi rischi e vulnerabilit&#224;','Videosorveglianza IP H.264/H.265 4K','Antintrusione perimetrale con sensori PIR','Controllo accessi con badge NFC','Monitoraggio H24 opzionale con centrale'],
  3=>['Audit energetico preliminare gratuito','Gateway IoT per monitoraggio real-time','Dashboard consumi aggiornata ogni minuto','Reportistica mensile con ROI calcolato','Integrazione impianto fotovoltaico'],
  4=>['Progettazione acustica professionale','Diffusori hi-fi multi-zona calibrati','Home theater integrato con KNX','Controllo vocale Alexa e Google Home','Calibrazione e tuning professionale'],
  5=>['Progettazione rete LAN/WAN strutturata','Cablaggio Cat.6A certificato','Wi-Fi 6 enterprise ad alta densit&#224;','Sistemi ridondanti con failover automatico','Monitoraggio continuo con alert'],
  6=>['Contratto manutenzione annuo o biennale','Interventi programmati e preventivi','Assistenza remota attiva 7 giorni su 7','Ricambi originali garantiti dal produttore','Report mensili sullo stato del sistema'],
];
?>
<!DOCTYPE html><html lang="it">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title><?php echo $svc?esc($svc['nome']).' &mdash; ':''; ?>Servizi &mdash; WiredSpace S.r.l.</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
<?php include 'php/navbar.php'; ?>

<div class="page-hdr">
  <div class="page-grid"></div>
  <div class="wrap">
    <div class="ey-l">Cosa facciamo</div>
    <h1 class="animate__animated animate__fadeInLeft">
      <?php if($svc): echo esc($svc['icona']).'&ensp;<span class="gt">'.esc($svc['nome']).'</span>';
      else: echo 'I nostri <span class="gt">servizi</span>'; endif; ?>
    </h1>
    <?php if($svc&&$svc['prezzo_base']): ?>
    <p>A partire da <strong style="color:var(--teal)">&euro; <?php echo number_format($svc['prezzo_base'],0,',','.'); ?></strong> &bull; KNX Partner Certified &bull; Sopralluogo gratuito</p>
    <?php else: ?>
    <p>Soluzioni certificate per ogni tipo di edificio &bull; Progettazione KNX &bull; Sopralluogo gratuito</p>
    <?php endif; ?>
  </div>
</div>

<?php if($svc): ?>
<!-- ═══ DETTAGLIO SERVIZIO ═══ -->
<section class="section">
  <div class="wrap">
    <div style="display:grid;grid-template-columns:1fr 1.7fr;gap:4rem;align-items:start" class="two-col">

      <div class="rl">
        <img src="<?php echo $simgs[$svc['id']]??''; ?>" alt="<?php echo esc($svc['nome']); ?>" class="serv-detail-img" style="margin-bottom:1.5rem">
        <div class="card-premium" style="margin-bottom:1rem">
          <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.875rem">
            <div style="font-size:1.75rem"><?php echo $svc['icona']; ?></div>
            <div>
              <div style="font-size:.68rem;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.08em">Servizio</div>
              <div style="font-weight:700;font-size:.9rem"><?php echo esc($svc['nome']); ?></div>
            </div>
          </div>
          <?php if($svc['prezzo_base']): ?>
          <div style="background:rgba(0,212,188,.08);border:1px solid rgba(0,212,188,.2);border-radius:10px;padding:.875rem;margin-bottom:1rem;text-align:center">
            <div style="font-size:.68rem;color:var(--muted);margin-bottom:.2rem;text-transform:uppercase;letter-spacing:.06em">A partire da</div>
            <div style="font-family:var(--head);font-size:1.75rem;font-weight:800;color:var(--teal);letter-spacing:-.03em">&euro; <?php echo number_format($svc['prezzo_base'],0,',','.'); ?></div>
          </div>
          <?php endif; ?>
          <a href="preventivo.php?servizio=<?php echo $svc['id']; ?>" class="btn btn-p" style="width:100%;justify-content:center;margin-bottom:.75rem">&#128203; Richiedi preventivo</a>
          <a href="contatti.php" class="btn btn-g" style="width:100%;justify-content:center">&#9993; Fai una domanda</a>
        </div>
      </div>

      <div class="reveal">
        <h2 style="font-family:var(--head);font-size:2.25rem;font-weight:800;margin-bottom:1.375rem;letter-spacing:-.05em"><?php echo esc($svc['nome']); ?></h2>
        <p style="color:var(--muted);line-height:1.85;font-size:.95rem;margin-bottom:2.5rem;font-weight:300"><?php echo nl2br(esc($svc['descrizione'])); ?></p>

        <h3 style="font-family:var(--head);font-size:1.1rem;font-weight:800;margin-bottom:1.125rem;letter-spacing:-.03em">
          Cosa &egrave; incluso nel servizio
        </h3>
        <div style="display:flex;flex-direction:column;gap:.5rem;margin-bottom:2.5rem">
          <?php foreach($feats[$svc['id']]??[] as $f): ?>
          <div class="feature-check">
            <span class="feature-check-ic">&#10003;</span>
            <?php echo $f; ?>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="card-premium" style="padding:1.5rem">
          <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;text-align:center">
            <?php foreach([['&#10003;','KNX Certified'],['&#128197;','Garanzia 2 anni'],['&#128222;','Supporto H24']] as $b): ?>
            <div style="padding:.75rem;background:rgba(255,255,255,.04);border-radius:10px;border:1px solid var(--bord)">
              <div style="font-size:1.25rem;margin-bottom:.375rem"><?php echo $b[0]; ?></div>
              <div style="font-size:.7rem;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.06em"><?php echo $b[1]; ?></div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Altri servizi -->
    <div style="margin-top:5.5rem">
      <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:2.5rem;flex-wrap:wrap;gap:1rem">
        <h2 style="font-family:var(--head);font-size:1.875rem;font-weight:800;letter-spacing:-.05em">Altri <span class="gt">servizi</span></h2>
        <a href="servizi.php" class="btn btn-g">Vedi tutti &rarr;</a>
      </div>
      <div class="servizi-g">
        <?php foreach($tutti as $i=>$s): if($s['id']==$svc['id'])continue; ?>
        <article class="sc reveal">
          <div class="sc-img">
            <img src="<?php echo $simgs[$s['id']]??''; ?>" alt="<?php echo esc($s['nome']); ?>" loading="lazy">
            <div class="sc-fade"></div>
            <span class="sc-num">0<?php echo $i+1; ?></span>
          </div>
          <div class="sc-body">
            <div class="sc-ico"><?php echo $s['icona']; ?></div>
            <h3><?php echo esc($s['nome']); ?></h3>
            <p><?php echo esc(mb_substr($s['descrizione'],0,90)); ?>&hellip;</p>
            <a href="servizi.php?id=<?php echo $s['id']; ?>" class="sc-link">Scopri di pi&ugrave;</a>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<?php else: ?>
<!-- ═══ LISTA SERVIZI ═══ -->
<section class="section">
  <div class="wrap">
    <div class="servizi-g">
      <?php foreach($tutti as $i=>$s): ?>
      <article class="sc reveal" style="transition-delay:<?php echo $i*.08; ?>s">
        <div class="sc-img">
          <img src="<?php echo $simgs[$s['id']]??''; ?>" alt="<?php echo esc($s['nome']); ?>" loading="lazy">
          <div class="sc-fade"></div>
          <span class="sc-num">0<?php echo $i+1; ?></span>
        </div>
        <div class="sc-body">
          <div class="sc-ico"><?php echo $s['icona']; ?></div>
          <h3><?php echo esc($s['nome']); ?></h3>
          <p><?php echo esc(mb_substr($s['descrizione'],0,100)); ?>&hellip;</p>
          <?php if($s['prezzo_base']): ?><p style="color:var(--teal);font-size:.78rem;font-weight:600;margin-bottom:.75rem">Da &euro; <?php echo number_format($s['prezzo_base'],0,',','.'); ?></p><?php endif; ?>
          <a href="servizi.php?id=<?php echo $s['id']; ?>" class="sc-link">Scopri di pi&ugrave;</a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section-sm">
  <div class="wrap">
    <div class="cta-mini">
      <h2 class="s-h2" style="margin-bottom:1rem">Non sai quale servizio fa per te?</h2>
      <p class="s-p" style="margin:0 auto 2rem;text-align:center">Raccontaci le tue esigenze. Troveremo insieme la soluzione ideale per il tuo edificio.</p>
      <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;position:relative">
        <a href="preventivo.php" class="btn btn-p">&#128203; Preventivo gratuito</a>
        <a href="contatti.php" class="btn btn-g">&#9993; Contattaci</a>
      </div>
    </div>
  </div>
</section>

<?php include 'php/footer.php'; ?>
<script src="js/main.js"></script>
</body></html>
