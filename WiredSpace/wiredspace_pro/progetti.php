<?php
require_once 'php/config.php';
$db = getDB();
$proj = $db->query("SELECT p.*,s.nome AS sn,s.icona AS si,u.azienda,u.nome AS cn,u.cognome AS cc FROM progetti p JOIN servizi s ON p.servizio_id=s.id JOIN utenti u ON p.cliente_id=u.id ORDER BY p.data_fine DESC")->fetchAll();
$pimgs=['https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&q=80','https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=600&q=80','https://images.unsplash.com/photo-1565514020179-026b92b84bb6?w=600&q=80','https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80','https://images.unsplash.com/photo-1542361345-89e58247f2d5?w=600&q=80'];
?>
<!DOCTYPE html><html lang="it">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Portfolio Progetti &mdash; WiredSpace S.r.l.</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
<?php include 'php/navbar.php'; ?>
<div class="page-hdr">
  <div class="page-grid"></div>
  <div class="wrap">
    <div class="ey-l">I nostri lavori</div>
    <h1 class="animate__animated animate__fadeInLeft">Portfolio <span class="gt">progetti</span></h1>
    <p>Ogni progetto &egrave; una storia di successo. Risultati concreti e misurabili per i nostri clienti nel Nord Italia.</p>
  </div>
</div>
<section class="section">
  <div class="wrap">
    <?php if(empty($proj)): ?>
    <div style="text-align:center;padding:5rem 0">
      <div style="font-size:3.5rem;margin-bottom:1.5rem">&#128230;</div>
      <h2 style="font-family:var(--head);font-size:1.75rem;font-weight:800;margin-bottom:.875rem;letter-spacing:-.04em">Portfolio in costruzione</h2>
      <p style="color:var(--muted);font-weight:300;max-width:400px;margin:0 auto 2rem;line-height:1.8">I nostri progetti completati appariranno qui. Contattaci per scoprire i lavori gi&#224; realizzati.</p>
      <a href="contatti.php" class="btn btn-p">&#9993; Contattaci</a>
    </div>
    <?php else: ?>
    <div class="proj-g">
      <?php foreach($proj as $i=>$p):
        $bc=match($p['stato']??''){'completato'=>'b-green','in_corso'=>'b-blue','richiesta'=>'b-yellow',default=>'b-gray'};
        $bl=match($p['stato']??''){'completato'=>'&#10003; Completato','in_corso'=>'In corso','richiesta'=>'Richiesta',default=>'Sospeso'};
      ?>
      <article class="proj reveal" style="transition-delay:<?php echo ($i%3)*.08; ?>s">
        <div class="proj-img">
          <img src="<?php echo $pimgs[$i%count($pimgs)]; ?>" alt="<?php echo esc($p['titolo']); ?>" loading="lazy">
          <div class="proj-ov"></div>
          <span class="badge <?php echo $bc; ?> proj-badge-pos"><?php echo $bl; ?></span>
        </div>
        <div class="proj-body">
          <h3><?php echo esc($p['titolo']); ?></h3>
          <p class="proj-cli">&#127970; <?php echo esc($p['azienda']??$p['cn'].' '.$p['cc']); ?></p>
          <div class="proj-tags">
            <span class="ptag"><?php echo esc($p['si'].' '.$p['sn']); ?></span>
            <?php if($p['indirizzo']): ?><span class="ptag">&#128205; <?php echo esc(explode(',',$p['indirizzo'])[0]); ?></span><?php endif; ?>
            <?php if($p['budget']): ?><span class="ptag">&euro; <?php echo number_format($p['budget'],0,',','.'); ?></span><?php endif; ?>
          </div>
          <?php if($p['descrizione']): ?><p class="proj-desc"><?php echo esc(mb_substr($p['descrizione'],0,120)); ?>&hellip;</p><?php endif; ?>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
<section class="section-sm">
  <div class="wrap">
    <div class="cta-mini">
      <h2 class="s-h2" style="margin-bottom:1rem">Diventa il prossimo caso di successo</h2>
      <p class="s-p" style="margin:0 auto 2rem;text-align:center">Sopralluogo gratuito e preventivo personalizzato. Trasformiamo il tuo edificio in un asset tecnologico.</p>
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
