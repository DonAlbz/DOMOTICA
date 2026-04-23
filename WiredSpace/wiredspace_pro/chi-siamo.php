<?php require_once 'php/config.php'; ?>
<!DOCTYPE html><html lang="it">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Chi Siamo &mdash; WiredSpace S.r.l.</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
<?php include 'php/navbar.php'; ?>
<div class="page-hdr">
  <div class="page-grid"></div>
  <div class="wrap">
    <div class="ey-l">La nostra storia</div>
    <h1 class="animate__animated animate__fadeInLeft">Chi <span class="gt">siamo</span></h1>
    <p>Un team certificato KNX con 15 anni di esperienza nella domotica professionale per il Nord Italia</p>
  </div>
</div>
<section class="section">
  <div class="wrap">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center;margin-bottom:6rem" class="two-col">
      <div class="rl">
        <div class="eyebrow">La nostra missione</div>
        <h2 class="s-h2" style="margin-bottom:1.5rem">Connettere spazi.<br><span class="gt2">Costruire futuro.</span></h2>
        <p class="s-p" style="margin-bottom:1.25rem">WiredSpace nasce con l&#39;obiettivo di progettare e installare impianti domotici professionali per uffici, aziende ed edifici pubblici. Siamo il partner tecnologico affidabile per chi vuole automatizzare e ottimizzare la gestione degli spazi lavorativi.</p>
        <p class="s-p" style="margin-bottom:2.5rem">A differenza di un semplice rivenditore, WiredSpace offre un servizio a 360&deg;: dalla consulenza iniziale alla progettazione su misura, dall&#39;installazione alla manutenzione post-vendita.</p>
        <a href="preventivo.php" class="btn btn-p">&#128203; Richiedi preventivo gratuito</a>
      </div>
      <div class="rr">
        <div class="card-premium">
          <?php foreach([['&#127970;','Sede','Brescia (BS), Italia'],['&#128101;','Fondatori','3 soci con competenze complementari'],['&#127981;','Settore','Impiantistica domotica &mdash; B2B e PA'],['&#128197;','Fondazione','Anno Scolastico 2024/2025'],['&#127942;','Certificazioni','KNX Partner &bull; ISO 9001:2015'],['&#127758;','Area operativa','Nord Italia (Brescia, Milano, Bergamo)'],] as [$ic,$k,$v]): ?>
          <div style="display:flex;justify-content:space-between;align-items:center;padding:.875rem 0;border-bottom:1px solid var(--bord)">
            <span style="color:var(--muted);font-size:.84rem;font-weight:300"><?php echo $ic; ?>&ensp;<?php echo $k; ?></span>
            <span style="font-weight:600;font-size:.84rem;color:var(--off)"><?php echo $v; ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Valori -->
    <div style="text-align:center;margin-bottom:3.5rem">
      <div class="eyebrow ec">I nostri valori</div>
      <h2 class="s-h2">Cosa ci rende <span class="gt">diversi</span></h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;margin-bottom:6rem" class="three-col">
      <?php foreach([
        ['&#9889;','Competenza tecnica','Certificazione KNX Partner e 15 anni di installazioni professionali. Ogni impianto rispetta gli standard europei pi&#249; rigorosi.'],
        ['&#127807;','Sostenibilit&#224;','Ogni nostro impianto riduce mediamente del 40% i consumi energetici. ROI documentato con report mensili.'],
        ['&#128737;','Affidabilit&#224;','Contratti di manutenzione e assistenza H24 garantiti. Non spartiamo dopo l&#39;installazione.'],
      ] as $v): ?>
      <div class="card-premium reveal">
        <div style="font-size:2rem;margin-bottom:1rem"><?php echo $v[0]; ?></div>
        <h3 style="font-family:var(--head);font-size:1.05rem;font-weight:800;margin-bottom:.625rem;letter-spacing:-.02em"><?php echo $v[1]; ?></h3>
        <p style="color:var(--muted);font-size:.83rem;line-height:1.75;font-weight:300"><?php echo $v[2]; ?></p>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Team -->
    <div style="text-align:center;margin-bottom:3.5rem">
      <div class="eyebrow ec">Il team</div>
      <h2 class="s-h2">Le persone dietro <span class="gt">WiredSpace</span></h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem" class="three-col">
      <?php foreach([
        ['A','Membro A','Responsabile Tecnico','Progettazione impianti KNX, cablaggi strutturati, sopralluoghi, installazione e collaudo certificato.'],
        ['B','Membro B','Responsabile Commerciale','Sviluppo commerciale B2B, gestione clienti, preventivi tecnici e acquisizione nuovi contratti.'],
        ['C','Membro C','Responsabile Amministrativo','Gestione finanziaria, compliance normativa, risorse umane, contabilit&#224; e rapporti con fornitori.'],
      ] as $m): ?>
      <div class="team-card reveal">
        <div class="team-avatar"><?php echo $m[0]; ?></div>
        <h3 style="font-family:var(--head);font-size:1.05rem;font-weight:800;margin-bottom:.3rem;letter-spacing:-.02em"><?php echo $m[1]; ?></h3>
        <p style="color:var(--teal);font-size:.78rem;font-weight:600;margin-bottom:.875rem"><?php echo $m[2]; ?></p>
        <p style="color:var(--muted);font-size:.82rem;line-height:1.72;font-weight:300"><?php echo $m[3]; ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section-sm">
  <div class="wrap">
    <div class="cta-mini">
      <h2 class="s-h2" style="margin-bottom:1rem">Lavoriamo insieme?</h2>
      <p class="s-p" style="margin:0 auto 2rem;text-align:center">Sopralluogo gratuito, preventivo personalizzato, nessun impegno. Scopri come possiamo trasformare il tuo edificio.</p>
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
