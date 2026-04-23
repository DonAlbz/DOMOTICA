<?php require_once 'php/config.php'; ?>
<!DOCTYPE html><html lang="it">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Settori &mdash; WiredSpace S.r.l.</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
<?php include 'php/navbar.php'; ?>
<div class="page-hdr">
  <div class="page-grid"></div>
  <div class="wrap">
    <div class="ey-l">Dove operiamo</div>
    <h1 class="animate__animated animate__fadeInLeft">Settori di <span class="gt">intervento</span></h1>
    <p>Dalla piccola azienda all&#39;edificio pubblico, WiredSpace porta la domotica KNX professionale in ogni contesto</p>
  </div>
</div>
<section class="section">
  <div class="wrap">
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem" class="three-col">
      <?php foreach([
        ['&#127970;','Uffici e PMI','Automazione completa degli spazi lavorativi: illuminazione, clima, sicurezza e reti per aumentare la produttivit&#224; e ridurre i costi energetici fino al 40%.','https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&q=80'],
        ['&#127963;','Pubblica Amministrazione','Soluzioni per edifici pubblici: comuni, scuole, ospedali e uffici governativi. Conformi alle normative EPBD 2024 e ai bandi europei per la transizione energetica.','https://images.unsplash.com/photo-1542361345-89e58247f2d5?w=600&q=80'],
        ['&#127978;','Grande Distribuzione','Sistemi integrati per centri commerciali, supermercati e retail: illuminazione adattiva, HVAC intelligente e videosorveglianza centralizzata con analytics.','https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&q=80'],
        ['&#127968;','Hospitality','Hotel, resort e strutture ricettive: domotica per le camere, energy management centralizzato e sistemi di check-in e benvenuto personalizzati.','https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80'],
        ['&#127981;','Industria','Automazione industriale: controllo accessi avanzato, monitoraggio asset IoT, gestione energia e sistemi di sicurezza per ambienti produttivi complessi.','https://images.unsplash.com/photo-1565514020179-026b92b84bb6?w=600&q=80'],
        ['&#127968;','Residenziale Premium','Ville e abitazioni di pregio: smart home completa con voice control, sicurezza perimetrale avanzata, audio/video multiroom hi-fi e automazione tapparelle e luci.','https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80'],
      ] as $s): ?>
      <article class="settore-card reveal">
        <div class="settore-img">
          <img src="<?php echo $s[3]; ?>" alt="<?php echo htmlspecialchars(strip_tags($s[1])); ?>" loading="lazy">
          <div style="position:absolute;inset:0;background:linear-gradient(to top,var(--ink2) 0%,transparent 60%)"></div>
        </div>
        <div class="settore-body">
          <div style="font-size:1.75rem;margin-bottom:.875rem"><?php echo $s[0]; ?></div>
          <h3><?php echo $s[1]; ?></h3>
          <p><?php echo $s[2]; ?></p>
          <a href="preventivo.php" class="sc-link">Richiedi preventivo</a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<section class="section-sm">
  <div class="wrap">
    <div class="cta-mini">
      <h2 class="s-h2" style="margin-bottom:1rem">Il tuo settore non &egrave; in lista?</h2>
      <p class="s-p" style="margin:0 auto 2rem;text-align:center">WiredSpace lavora in qualsiasi contesto. Contattaci e troveremo la soluzione giusta per le tue esigenze specifiche.</p>
      <div style="display:flex;gap:1rem;justify-content:center;position:relative">
        <a href="contatti.php" class="btn btn-p">&#9993; Contattaci</a>
        <a href="preventivo.php" class="btn btn-g">&#128203; Preventivo</a>
      </div>
    </div>
  </div>
</section>
<?php include 'php/footer.php'; ?>
<script src="js/main.js"></script>
</body></html>
